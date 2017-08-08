<?php
class EmailContactsImporterHandler extends FormHandler
	{
		public function getYahooUrl()
			{
				global $CFG;
				$appid = $CFG['admin']['email_api']['yahoo_appid'];  // my application ID, obtained at registration
				$appdata = $CFG['admin']['email_api']['yahoo_appdata'];                             // my optional, arbitrary url-encoded data
				$ts = time();                                    // seconds since Jan 1, 1970 GMT
				$secret = $CFG['admin']['email_api']['yahoo_secret']; // my shared secret, obtained at registration

				$sig = md5( "/WSLogin/V1/wslogin?appid=$appid&appdata=$appdata&ts=$ts" . "$secret" );
				$url = "https://api.login.yahoo.com/WSLogin/V1/wslogin?appid=$appid&appdata=$appdata&ts=$ts&sig=$sig";
				return $url;
			}
		public function getGmailUrl()
			{
				global $CFG;
				$next = $CFG['site']['url'].'api.emails.php';
				$next = urlencode($next);
				$scope = urlencode('http://www.google.com/m8/feeds/');
				$url = 'https://www.google.com/accounts/AuthSubRequest?scope='.$scope.'&session=0&secure=0&next='.$next;
				return $url;
			}
		public function get_yahoo_credentials( $url )
			{
				$ch = curl_init();
				curl_setopt( $ch, CURLOPT_URL, $url );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
				$store = curl_exec( $ch );
				$xml = curl_exec( $ch );
				if (  preg_match( "/(Y=.*)/", $xml, $match_array ) == 1 ) {
					$COOKIE = $match_array[1];
					}
				if (  preg_match( "/<WSSID>(.+)<\/WSSID>/", $xml, $match_array ) == 1 ) {
					$WSSID = $match_array[1];
					}
				if (  preg_match( "/<Timeout>(.+)<\/Timeout>/", $xml, $match_array ) == 1 ) {
					$timeout = $match_array[1];
					}
				$rv = array();
				$rv["COOKIE"] = $COOKIE;
				$rv["WSSID"] = $WSSID;
				$rv["timeout"]   = $timeout;
				return $rv;
			}
		public function getLiveUrl()
			{
				global $CFG, $EmailApisDir;

				$msnDir = $EmailApisDir.'msn/';
				$KEYFILE = $msnDir.'Application-Key.xml';
				require_once $msnDir.'lib/windowslivelogin.php';
				$wll = WindowsLiveLogin::initFromXml($KEYFILE);
				$wll->setDebug(true);
				//Get the consent URL for the specified offers.
				$consenturl = $wll->getConsentUrl('Contacts.View');
				return $consenturl;
			}
		// fetchLiveContacts is used to get the XML from the Live-servers
		// $dt = Delegation token
		// $uri = URI to use
		// $lid = Location ID, the user ID.
		public function fetchLiveContacts($dt, $lid)
			{
				$uri = "https://livecontacts.services.live.com/@C@$lid/REST/LiveContacts/contacts";
				// Add the token to the header
				$headers = array
				(
				"Authorization: DelegatedToken dt=\"$dt\""
				//"Authorization: DelegationToken dt=\"$dt\""
				);

				// I use cURL (www.php.net/curl) to get the information
				// Let's set up the request
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $uri);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_TIMEOUT, 60);
				#	curl_setopt($curl, CURLOPT_HEADER, true);
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_USERAGENT, "Uzdc - Product - Live API Integration");

				// Ready? Set? GO!
				$data = curl_exec($curl);

				// Get the info and close the connection
				$curlinfo = curl_getinfo($curl);
				curl_close($curl);
				// Have any errors occured? If so, print them.
				if($curlinfo["http_code"] == "401")
					{
						echo "<h2>The remote server refused the DT. Is it correct?</h2>";
						echo "<h3>Sometimes this error may occur. If you're sure everything is correct, try again.</h3>";
						return false;
					}
				if($curlinfo["http_code"] == "403")
					{
						echo "<h2>The remote server refused to give you this information. Are you sure you have selected the mode belonging to the requested offer (i.e. Contacts for Contacts.View)</h2>";
						return false;
					}
				if($curlinfo["http_code"] == "404")
					{
						echo "<h2>Woops... looks like you're trying to request something that isn't there. Are you sure the CID and LID are ok?</h2>";
						return false;
					}
				// If the code reaches this point, everything went well.
				return $data;
			}

		public function get_gmail_contacts_from_xml($xml = '')
			{
				$return = array();
				$XmlParser = new XmlParser();
				$data_arr = $XmlParser->parse($xml);
				if($data_arr)
					{
						if(isset($data_arr[0]['children']))
							{
								foreach($data_arr[0]['children'] as $key=>$value)
									{
										if(isset($data_arr[0]['children'][$key]['children']))
											{
												$email = '';
												$display = '';
												foreach($data_arr[0]['children'][$key]['children'] as $key1=>$value1)
													{
														if(isset($data_arr[0]['children'][$key]['children'][$key1]['name']) and $data_arr[0]['children'][$key]['children'][$key1]['name']=='GD:EMAIL')
															{
																$email =$data_arr[0]['children'][$key]['children'][$key1]['attrs']['ADDRESS'] = $data_arr[0]['children'][$key]['children'][$key1]['attrs']['ADDRESS'];
															}
														if(isset($data_arr[0]['children'][$key]['children'][$key1]['name']) and $data_arr[0]['children'][$key]['children'][$key1]['name']=='TITLE')
															{
																$display =$data_arr[0]['children'][$key]['children'][$key1]['tagData'];
															}
													}
												if($email and $display)
													{
														$return[$email] = $display;
													}
											}
									}
							}
					}				
				return $return;
			}
		public function get_yahoo_contacts_from_xml($xml = '')
			{
				$obj = simplexml_load_string($xml);
				$return = array();
				foreach($obj->contact as $contact)
					{
						$email = (string)@$contact->email;
						$first = (string)@$contact->name->first;
						$last = (string)@$contact->name->last;
						$name = $first;
						$name .= ($first and $last)?' ':'';
						$name .= $last;
						if ($email)
							{
								$return[$email] = $name?$name:$email;
							}
					}
				return $return;
			}
		public function get_msn_contacts_from_xml($xml = '')
			{
				$obj = simplexml_load_string($xml);
				$return = array();
				foreach($obj->Contact as $contact)
					{
						$email = (string)@$contact->Emails->Email->Address;
						$first = (string)@$contact->Profiles->Personal->FirstName;
						$last = (string)@$contact->Profiles->Personal->LastName;
						$name = $first;
						$name .= ($first and $last)?' ':'';
						$name .= $last;
						if ($email)
							{
								$return[$email] = $name?$name:$email;
							}
					}
				return $return;
			}
		public function displayEmailForm($emails = array())
			{
				/*
				for($i=1; $i<100; $i++)
				{
				$emails["emaiil$i@delta.com"] = "$i name";
				}*/

				global $smartyObj, $emailsAPI;
				$emailsAPI->setPageBlockShow('form_imported_emails');
				$smartyObj->assign('emails_returned', $emails);
			}
		// thanks to Romain Thiberville for finding this
		public function hexaTo64SignedDecimal($hexa)
			{
				$bin = $this->unfucked_base_convert($hexa, 16, 2);
				if (64 === strlen($bin) and 1 == $bin[0])
					{
						$inv_bin = strtr($bin, '01', '10');
						$i = 63;
						while (0 !== $i)
							{
								if (0 == $inv_bin[$i])
									{
										$inv_bin[$i] = 1;
										$i = 0;
									}
								else
									{
										$inv_bin[$i] = 0;
										$i--;
									}
							}
						return '-' . $this->unfucked_base_convert($inv_bin, 2, 10);
					}
				else
					{
						return $this->unfucked_base_convert($hexa, 16, 10);
					}
			}
		/* unfucked_base_convert is used to correctly convert the CID's to INT64 LID's
		Follows the syntax of base_convert (http://www.php.net/base_convert)
		Created by Michael Renner @ http://www.php.net/base_convert
		17-May-2006 03:24
			*/
		public function unfucked_base_convert($numstring, $frombase, $tobase)
			{
				$chars = "0123456789abcdefghijklmnopqrstuvwxyz";
				$tostring = substr($chars, 0, $tobase);

				$length = strlen($numstring);
				$result = '';
				for ($i = 0; $i < $length; $i++)
					{
						$number[$i] = strpos($chars, $numstring{$i});
					}
				do
					{
						$divide = 0;
						$newlen = 0;
						for ($i = 0; $i < $length; $i++)
							{
								$divide = $divide * $frombase + $number[$i];
								if ($divide >= $tobase)
									{
										$number[$newlen++] = (int)($divide / $tobase);
										$divide = $divide % $tobase;
									}
								elseif ($newlen > 0)
									{
										$number[$newlen++] = 0;
									}
							}
						$length = $newlen;
						$result = $tostring{$divide} . $result;
					} while ($newlen != 0);
				return $result;
			}
	}
?>