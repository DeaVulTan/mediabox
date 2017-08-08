<?php
/**
 * trigger_db_error()
 * Function to trigger sql query errors
 *
 * @param mixed $obj
 * @return
 */
function trigger_db_error($obj)
	{
		global $CFG;

		$error_arr = debug_backtrace();

		$subject = 'Report bug - Sql error - VAR_SITE_URL';
		$content = '<u><b>Url :</b></u>
		VAR_CURRENT_URL

		<u><b>Error File :</b></u>
		VAR_FILE

		<u><b>Error Line No :</b></u>
		VAR_LINE

		<u><b>Error Sql :</b></u>
		VAR_SQL

		<u><b>Error Description:</b></u>
		VAR_ERROR';

		$frmobj = new FormHandler();
		$frmobj->setEmailTemplateValue('CURRENT_URL', $CFG['site']['current_url']);
		$frmobj->setEmailTemplateValue('FILE', $error_arr[0]['file']);
		$frmobj->setEmailTemplateValue('LINE', $error_arr[0]['line']);
		$frmobj->setEmailTemplateValue('SQL', $error_arr[0]['args'][0]->sql);

		$frmobj->setEmailTemplateValue('ERROR', $error_arr[0]['args'][0]->debug_output);
		$frmobj->buildEmailTemplate($subject, $content, false, true);

		sendBugEmail($frmobj);
		trigger_error('Error at '.$error_arr[0]['file'].' on line '.$error_arr[0]['line']."<br>".$obj->ErrorNo().' '.$obj->ErrorMsg(), E_USER_ERROR);
	}

/**
 * setUserConfigVariables()
 * To set config variable values from session array
 *
 * @return
 */
function setUserConfigVariables()
	{
		global $CFG;
		if(!isMember())
			{
				return false;
			}
		//everything is ok. stuff to $CFG array
		$CFG['user']['user_id'] = $_SESSION['user']['user_id'];
		$CFG['user']['user_name'] = $_SESSION['user']['user_name'];
		$CFG['user']['time_zone'] = (isset($_SESSION['user']['time_zone'])?$_SESSION['user']['time_zone']:'');
		$CFG['user']['email'] = (isset($_SESSION['user']['email'])?$_SESSION['user']['email']:'');
		$CFG['user']['openid_type'] = (isset($_SESSION['user']['openid_type'])?$_SESSION['user']['openid_type']:'');
		//$CFG['user']['membership_expiry_date'] = $_SESSION['user']['membership_expiry_date'];
		$CFG['user']['name'] = (isset($_SESSION['user']['name'])?$_SESSION['user']['name']:'');
		$CFG['user']['pref_lang'] = (isset($_SESSION['user']['pref_lang'])?$_SESSION['user']['pref_lang']:'');
		//$CFG['user']['pref_template'] = $_SESSION['user']['pref_template'];
		$CFG['user']['last_logged'] = (isset($_SESSION['user']['last_logged'])?$_SESSION['user']['last_logged']:'');
		$CFG['user']['num_visits'] = (isset($_SESSION['user']['num_visits'])?$_SESSION['user']['num_visits']:'');
		$CFG['user']['useragent_hash'] = (isset($_SESSION['user']['useragent_hash'])?$_SESSION['user']['useragent_hash']:'');
		$CFG['user']['is_upload_background_image'] = (isset($_SESSION['user']['is_upload_background_image'])?$_SESSION['user']['is_upload_background_image']:'');
		$CFG['user']['is_paid_member'] = (isset($_SESSION['user']['is_paid_member'])?$_SESSION['user']['is_paid_member']:'');
		$CFG['user']['ip'] = (isset($_SESSION['user']['ip'])?$_SESSION['user']['ip']:'');
		$CFG['user']['is_logged_in'] = (isset($_SESSION['user']['is_logged_in'])?$_SESSION['user']['is_logged_in']:'');
		$CFG['user']['adult'] = (isset($_SESSION['user']['adult'])?$_SESSION['user']['adult']:'');
		$CFG['user']['content_filter'] = (isset($_SESSION['user']['content_filter'])?$_SESSION['user']['content_filter']:'');
		$CFG['user']['usr_access'] = (isset($_SESSION['user']['usr_access'])?$_SESSION['user']['usr_access']:'');
		$CFG['user']['user_actions'] = (isset($_SESSION['user']['user_actions'])?$_SESSION['user']['user_actions']:'');
		$CFG['user']['rayzz_url'] = getUrl('viewprofile', '?user='.$CFG['user']['user_name'], $CFG['user']['user_name'].'/', 'root');

		return true;
	}

/**
 * sendBugEmail()
 * To send bug email to developer
 *
 * @param mixed $frmobj
 * @return
 */
function sendBugEmail($frmobj)
	{
		global $CFG;
		$EasySwift = new EasySwift($frmobj->getSwiftConnection());
		$EasySwift->flush();
		$EasySwift->addPart($frmobj->getEmailContent(true), "text/html");
		$from_email = $CFG['site']['noreply_email'];
		//$EasySwift->send('isocialdev@gmail.com', $from_email, $frmobj->getEmailSubject());
		$EasySwift->send('m.selvaraj@Uzdc.in', $from_email, $frmobj->getEmailSubject());
	}

/**
 * getCurrentMemberUrl()
 * To get current url
 *
 * @return
 */
function getCurrentMemberUrl()
	{
		global $CFG;
		return $CFG['site']['current_url'];
	}

/**
 * getMemberAvatarDetails()
 * To get photo details of given userd_id
 *
 * @param mixed $user_id
 * @return
 */
function getMemberAvatarDetails($user_id)
	{
		global $db, $CFG;
		$details = array();
		$defaultPhotoDetails = true;
		$udetails = getUserDetail('user_id', $user_id);
		if($udetails and $udetails['image_ext'])
			{
				$defaultPhotoDetails = false;
				$imgUrl = (!empty($udetails['image_server_url'])?$udetails['image_server_url']:$CFG['site']['url']);
				$img = $imgUrl.$CFG['admin']['members_profile']['user_profile_folder'].'/';
				$udetails['image_name'] = ($udetails['image_name']) ? $udetails['image_name'] : $user_id;

				$details['l_url'] = $img.$udetails['image_name'].$CFG['image_large_name'].'.'.$udetails['image_ext'];
				$details['t_url'] = $img.$udetails['image_name'].$CFG['image_thumb_name'].'.'.$udetails['image_ext'];
				$details['s_url'] = $img.$udetails['image_name'].$CFG['image_small_name'].'.'.$udetails['image_ext'];
				$details['m_url'] = $img.$udetails['image_name'].$CFG['image_medium_name'].'.'.$udetails['image_ext'];

				$details['s_width'] = $udetails['small_width'];
				$details['t_width'] = $udetails['thumb_width'];
				$details['l_width'] = $udetails['large_width'];
				$details['m_width'] = $udetails['mini_width'];

				$details['s_height'] = $udetails['small_height'];
				$details['t_height'] = $udetails['thumb_height'];
				$details['l_height'] = $udetails['large_height'];
				$details['m_height'] = $udetails['mini_height'];
			}
		if($defaultPhotoDetails)
			{
				$tWidth = $CFG['image_thumb_width'];
				$tHeight = $CFG['image_thumb_height'];
				$sWidth = $CFG['image_small_width'];
				$sHeight = $CFG['image_small_height'];
				$lWidth = $CFG['image_thumb_width'];
				$lHeight = $CFG['image_thumb_height'];
				$mWidth = $CFG['image_medium_width'];
				$mHeight = $CFG['image_medium_height'];
				/* Update No Image Path for Admin  */
				$url_arr = explode('/', $_SERVER['REQUEST_URI']);
				if(in_array('admin', $url_arr))
				{
					$url = $CFG['site']['url']."design/templates/".$CFG['html']['template']['default']."/admin/images/".$CFG['html']['stylesheet']['screen']['default'].'/no_image';
				}
				else
				{
					$url = $CFG['site']['url']."design/templates/".$CFG['html']['template']['default']."/root/images/".$CFG['html']['stylesheet']['screen']['default'].'/no_image';
				}

				if (isset($udetails['sex']) and ($udetails['sex'] == 'female'))
					{
						$details['l_url'] = $url.'/no-femaleprofile_L.jpg';
						$details['t_url'] = $url.'/no-femaleprofile_T.jpg';
						$details['s_url'] = $url.'/no-femaleprofile_S.jpg';
						$details['m_url'] = $url.'/no-femaleprofile_M.jpg';
					}
				else
					{
						$details['l_url'] = $url.'/no-maleprofile_L.jpg';
						$details['t_url'] = $url.'/no-maleprofile_T.jpg';
						$details['s_url'] = $url.'/no-maleprofile_S.jpg';
						$details['m_url'] = $url.'/no-maleprofile_M.jpg';
					}

				$details['s_width'] = $sWidth;
				$details['t_width'] = $tWidth;
				$details['l_width'] = $lWidth;
				$details['m_width'] = $lWidth;

				$details['s_height'] = $sHeight;
				$details['t_height'] = $tHeight;
				$details['l_height'] = $lHeight;
				$details['m_height'] = $lHeight;
			}
		return $details;
	}

/**
 * setUserDetails()
 * To set user details
 *
 * @param mixed $column_name
 * @param mixed $column_value
 * @return
 */
function setUserDetails($column_name, $column_value)
	{
		global $CFG, $db;

		if(!$column_value)
			{

				return false;
			}
		if(isset($CFG['user_details'][$column_value]))
			{
				return;
			}
		$condition = ' AND usr_status!=\'Deleted\'';

		$sql = ' SELECT * FROM '.$CFG['db']['tbl']['users'].' WHERE'.
				' '.$column_name.' = '.$db->Param('column_name').$condition;

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($column_value));
		    if (!$rs)
			    trigger_db_error($db);

		if($row = $rs->FetchRow())
			{
				$row['display_name'] = getUserDisplayName($row);
				$row['profile_url'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
				$row['user_actions'] = getUserActions($row['usr_type']);
				$CFG['user_details'][strtolower($row['user_name'])] = $row;
				$CFG['user_details'][strtolower($row['user_id'])] = $row;
				$CFG['user_details'][strtolower($row['email'])] = $row;
				return true;
			}
		$CFG['user_details'][$column_value] = '';
		return false;
	}

/**
 * getUserDetail()
 * To get details of users
 *
 * @param mixed $column_name
 * @param mixed $column_value
 * @param string $return_column_name
 * @return
 */
function getUserDetail($column_name, $column_value, $return_column_name = '')
	{
		global $CFG;
		$column_name = strtolower($column_name);
		$column_value = strtolower($column_value);

		if(!isset($CFG['user_details'][$column_value]))
			{
				setUserDetails($column_name, $column_value);
			}
		if(isset($CFG['user_details'][$column_value]))
			{
				if(!$return_column_name)
					{
						return $CFG['user_details'][$column_value];
					}
				else if(isset($CFG['user_details'][$column_value][$return_column_name]))
					{
						return $CFG['user_details'][$column_value][$return_column_name];
					}
			}
		return false;
	}

/**
 * getUserActions()
 * To get the user actions of given user_type id
 *
 * @param mixed $usr_type
 * @return
 */
function getUserActions($usr_type)
	{
		global $CFG, $db;

		$field_values = array();
		if ($usr_type)
			{
				$sql = 'SELECT type_name, type_actions FROM '.$CFG['db']['tbl']['user_type_settings'].
						' WHERE type_id = '.$db->Param($usr_type).
						' AND type_status = \'Active\'';
				$field_values = array($usr_type);
			}
		else
			{
				$sql = 'SELECT type_name, type_actions FROM '.$CFG['db']['tbl']['user_type_settings'].
						' WHERE default_type = \'Yes\' LIMIT 0, 1';
			}
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, $field_values);
	    if (!$rs)
		    trigger_db_error($db);

		$user_actions = array();
		if($row = $rs->FetchRow())
			{
				//Unserialize selected user actions
				$row['type_actions'] = unserialize($row['type_actions']);
				$user_actions = $row;
			}
		return $user_actions;
	}

/**
 * checkUserPermission()
 * To check the user has permission for give action
 *
 * @param mixed $user_actions
 * @param mixed $action
 * @param string $sub_action
 * @return
 */
function checkUserPermission($user_actions, $action, $sub_actions = '')
	{
		if ($sub_actions)
			{
				if (!strpos($sub_actions, ','))
					{
						if (isset($user_actions['type_actions'][$action][$sub_actions]))
							{
								return ($user_actions['type_actions'][$action][$sub_actions] != '')?true:false;
							}
					}
				else
					{
						$sub_actions = explode(', ', $sub_actions);
						foreach($sub_actions as $sub_action){
							if (isset($user_actions['type_actions'][$action][$sub_action]))
								{
									if ($user_actions['type_actions'][$action][$sub_action] != '')
										return true;
								}
						}
						return false;
					}
			}
		elseif (!$sub_actions AND isset($user_actions['type_actions'][$action]))
			{
				return (is_array($user_actions['type_actions'][$action]))?true:$user_actions['type_actions'][$action];
			}
		return false;
	}

/**
 * postForm()
 * To post a url using curl
 *
 * @param mixed $url
 * @param mixed $post_value
 * @return
 */
function postForm($url, $post_value)
	{
		$ch = curl_init();

		// set the target url
		curl_setopt($ch, CURLOPT_URL,$url);

		// howmany parameter to post
		curl_setopt($ch, CURLOPT_POST, 1);

		// the parameter 'username' with its value 'johndoe'
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_value);

		$result= curl_exec ($ch);
		curl_close ($ch);
	}

/**
 * Check the site is under maintenance
 *
 * @access	public
 * @return	boolean
 */
function chkIsSiteUnderMaintenance()
	{
		global $CFG;

		if(!isAdmin())
			{
				$currentPage = strtolower($CFG['html']['current_script_name']);
				if($CFG['admin']['module']['site_maintenance'] AND $currentPage != 'maintenance')
					{
						// Unset all of the session variables.
						$_SESSION = array();
						// If it's desired to kill the session, also delete the session cookie.
						// Note: This will destroy the session, and not just the session data!
						if (isset($_COOKIE[session_name()]))
							{
							   setcookie(session_name(), '', time()-42000, '/');
							}
						// Finally, destroy the session.
						session_destroy();
						session_write_close();
						setcookie($CFG['cookie']['starting_text'].'_bba', '', time()-42000, '/');
						$murl = getUrl($CFG['redirect']['maintenance_module_url']['file_name'], $CFG['redirect']['maintenance_module_url']['normal'], $CFG['redirect']['maintenance_module_url']['htaccess'], 'root');
						$CFG['site']['current_url'];
						if($CFG['site']['current_url']!=$murl)
							{
								Redirect2Url($murl);
								exit;
							}

					}
			}
		else
			{
				$value_array = explode('/', $CFG['site']['relative_url']);
				if(!in_array('admin', $value_array) and $CFG['admin']['module']['site_maintenance'])
					{
						$admin_url = $CFG['site']['url'].'admin/index.php';
						Redirect2URL($admin_url);
					}
			}
	}

/**
 * Check the allowed country user
 *
 * @access	public
 * @return	boolean
 */
function chkIsAllowedCountry()
	{
		global $CFG;
		$country_code = apache_note("GEOIP_COUNTRY_CODE");
		if(in_array($country_code, $CFG['admin']['geo_country']))
			return false;
		return true;
	}

function findinside($start, $end, $string)
	{
        preg_match_all('/' . preg_quote($start, '/') . '([^\.)]+)'. preg_quote($end, '/').'/i', $string, $m);
        return $m[1];
    }

/**
 * Return the matched pattern list from given string
 *
 * @access	public
 * @param	string	pattern to search
 * @param	string	content
 * @param	integer	to return the particular array value
 * @return	array
 */
function MatchPattern($PATTERN = '', $CONTENT = '', $KEY = '')
	{
		if ($PATTERN && $CONTENT)
			{
				preg_match_all ($PATTERN, $CONTENT, $Match);
			}
		if ($KEY != '')
			{
				return $Match[$KEY];
			}
		return $Match;
	}

/**
 * used to get the image with and height
 *
 * @access	public
 * @param	integer required width
 * @param	integer required height
 * @param	integer	image original width
 * @param	integer	image original height
 * @return	string
 */
function DISP_IMAGE($cfg_width = 0, $cfg_height = 0, $img_width = 0, $img_height = 0)
	{
		if ($cfg_width > 0 AND $cfg_height > 0 AND ($cfg_width < $img_width) AND ($cfg_height < $img_height))
			{
				$tmpHeight = ( $cfg_width / $img_width ) * $img_height;

				if( $tmpHeight <= $cfg_height )
					{
						$attr = " width=\"".$cfg_width."\"";
					}
				else
					{
						$height = $tmpHeight - ( $tmpHeight - $cfg_height );
						$attr = " height=\"".$height."\"";
					}
			}
		else if ($cfg_width > 0 AND $cfg_width < $img_width)
			{
				$attr = " width=\"".$cfg_width."\"";
			}
		else if ($cfg_height > 0 AND $cfg_height < $img_height)
			{
				$attr = " height=\"".$cfg_height."\"";
			}
		else
			{
				$attr = "";
			}
		return $attr;
	}

/**
 * Word Limiter
 *
 * Limits a string to X number of words.
 *
 * @access	public
 * @param	string
 * @param	integer
 * @param	string	the end character. Usually an ellipsis
 * @return	string
 */
function word_limiter($str, $limit = 100, $end_char = '&#8230;')
	{
		if (trim($str) == '')
			{
				return $str;
			}
		preg_match('/^\s*+(?:\S++\s*+){1,'.(int) $limit.'}/', $str, $matches);
		if (strlen($str) == strlen($matches[0]))
			{
				$end_char = '';
			}
		return rtrim($matches[0]).$end_char;
	}

/**
 * Character Limiter
 *
 * Limits the string based on the character count.  Preserves complete words
 * so the character count may not be exactly as specified.
 *
 * @access	public
 * @param	string
 * @param	integer
 * @param	string	the end character. Usually an ellipsis
 * @return	string
 */
function character_limiter($str, $n = 500, $end_char = '&#8230;')
	{
		if (strlen($str) < $n)
			{
				return $str;
			}
		$str = preg_replace("/\s+/", ' ', preg_replace("/(\r\n|\r|\n)/", " ", $str));
		if (strlen($str) <= $n)
			{
				return $str;
			}
		$out = "";
		foreach (explode(' ', trim($str)) as $val)
			{
				$out .= $val.' ';
				if (strlen($out) >= $n)
					{
						return trim($out).$end_char;
					}
			}
	}

/**
 * Word Censoring Function
 *
 * Supply a string and an array of disallowed words and any
 * matched words will be converted to #### or to the replacement
 * word you've submitted.
 *
 * @access	public
 * @param	string	the text string
 * @param	string	the array of censoered words
 * @param	string	the optional replacement value
 * @return	string
 */
function word_censor($str, $censored, $replacement = '')
	{
		if ( ! is_array($censored))
			{
				return $str;
			}
		$str = ' '.$str.' ';
		foreach ($censored as $badword)
			{
				if ($replacement != '')
					{
						$str = preg_replace("/\b(".str_replace('\*', '\w*?', preg_quote($badword)).")\b/i", $replacement, $str);
					}
				else
					{
						$str = preg_replace("/\b(".str_replace('\*', '\w*?', preg_quote($badword)).")\b/ie", "str_repeat('#', strlen('\\1'))", $str);
					}
			}
		return trim($str);
	}

/**
 * Code Highlighter
 *
 * Colorizes code strings
 *
 * @access	public
 * @param	string	the text string
 * @return	string
 */
function highlight_code($str)
	{
		// The highlight string function encodes and highlights
		// brackets so we need them to start raw
		$str = str_replace(array('&lt;', '&gt;'), array('<', '>'), $str);

		// Replace any existing PHP tags to temporary markers so they don't accidentally
		// break the string out of PHP, and thus, thwart the highlighting.

		$str = str_replace(array('<?', '?>', '<%', '%>', '\\', '</script>'),
							array('phptagopen', 'phptagclose', 'asptagopen', 'asptagclose', 'backslashtmp', 'scriptclose'), $str);

		// The highlight_string function requires that the text be surrounded
		// by PHP tags.  Since we don't know if A) the submitted text has PHP tags,
		// or B) whether the PHP tags enclose the entire string, we will add our
		// own PHP tags around the string along with some markers to make replacement easier later

		$str = '<?php tempstart'."\n".$str.'tempend ?>';

		// All the magic happens here, baby!
		$str = highlight_string($str, TRUE);

		// Prior to PHP 5, the highlight function used icky font tags
		// so we'll replace them with span tags.
		if (abs(phpversion()) < 5)
			{
				$str = str_replace(array('<font ', ',',',',',',',','</font>'), array('<span ', ',',',',',',',','</span>'), $str);
				$str = preg_replace('#color="(.*?)"#', 'style="color: \\1"', $str);
			}

		// Remove our artificially added PHP
		$str = preg_replace("#\<code\>.+?tempstart\<br />(?:\</span\>)?#is", "<code>\n", $str);
		$str = preg_replace("#tempend.+#is", "</span>\n</code>", $str);

		// Replace our markers back to PHP tags.
		$str = str_replace(array('phptagopen', 'phptagclose', 'asptagopen', 'asptagclose', 'backslashtmp', 'scriptclose'),
							array('&lt;?', '?&gt;', '&lt;%', '%&gt;', '\\', '&lt;/script&gt;'), $str);

		return $str;
	}

/**
 * Phrase Highlighter
 *
 * Highlights a phrase within a text string
 *
 * @access	public
 * @param	string	the text string
 * @param	string	the phrase you'd like to highlight
 * @param	string	the openging tag to precede the phrase with
 * @param	string	the closing tag to end the phrase with
 * @return	string
 */
 function highlight_phrase($str, $phrase, $tag_open = '<strong>', $tag_close = '</strong>')
	{
		if ($str == '')
			{
				return '';
			}
		if ($phrase != '')
			{
				return preg_replace('/('.preg_quote($phrase, '/').')/i', $tag_open."\\1".$tag_close, $str);
			}
		return $str;
	}

/**
 * Word Wrap
 *
 * Wraps text at the specified character.  Maintains the integrity of words.
 * Anything placed between {unwrap}{/unwrap} will not be word wrapped, nor
 * will URLs.
 *
 * @access	public
 * @param	string	the text string
 * @param	integer	the number of characters to wrap at
 * @return	string
 */
function word_wrap($str, $charlim = '76')
	{
		// Se the character limit
		if ( ! is_numeric($charlim))
			$charlim = 76;

		// Reduce multiple spaces
		$str = preg_replace("| +|", " ", $str);

		// Standardize newlines
		$str = preg_replace("/\r\n|\r/", "\n", $str);

		// If the current word is surrounded by {unwrap} tags we'll
		// strip the entire chunk and replace it with a marker.
		$unwrap = array();
		if (preg_match_all("|(\{unwrap\}.+?\{/unwrap\})|s", $str, $matches))
			{
				for ($i = 0; $i < count($matches['0']); $i++)
					{
						$unwrap[] = $matches['1'][$i];
						$str = str_replace($matches['1'][$i], "{{unwrapped".$i."}}", $str);
					}
			}

		// Use PHP's native function to do the initial wordwrap.
		// We set the cut flag to FALSE so that any individual words that are
		// too long get left alone.  In the next step we'll deal with them.
		$str = wordwrap($str, $charlim, "\n", FALSE);

		// Split the string into individual lines of text and cycle through them
		$output = "";
		foreach (explode("\n", $str) as $line)
			{
				// Is the line within the allowed character count?
				// If so we'll join it to the output and continue
				if (strlen($line) <= $charlim)
					{
						$output .= $line."\n";
						continue;
					}

				$temp = '';
				while((strlen($line)) > $charlim)
					{
						// If the over-length word is a URL we won't wrap it
						if (preg_match("!\[url.+\]|://|wwww.!", $line))
							{
								break;
							}

						// Trim the word down
						$temp .= substr($line, 0, $charlim-1);
						$line = substr($line, $charlim-1);
					}

				// If $temp contains data it means we had to split up an over-length
				// word into smaller chunks so we'll add it back to our current line
				if ($temp != '')
					{
						$output .= $temp . "\n" . $line;
					}
				else
					{
						$output .= $line;
					}

				$output .= "\n";
			}

		// Put our markers back
		if (count($unwrap) > 0)
			{
				foreach ($unwrap as $key => $val)
					{
						$output = str_replace("{{unwrapped".$key."}}", $val, $output);
					}
			}

		// Remove the unwrap tags
		$output = str_replace(array('{unwrap}', '{/unwrap}'), '', $output);

		return $output;
	}

/**
* stip only specified tags
*
* @param string  $str String to strip tags.
* @param array $tags need to stip.
* @return string string.
*/
function stripSpecifiedTag($str, $tags)
	{
		if(!is_array($tags))
			{
    			$tags = (stripos($str, '>') !== false ? explode('>', str_ireplace('<', '', $tags)) : array($tags));
    			if(end($tags) == '') array_pop($tags);
			}
		foreach($tags as $tag)
			{
				$str = preg_replace('#</?'.$tag.'[^>]*>#is', '', $str);
			}
		return $str;
	}

/**
 * Create a Directory Map
 *
 * Reads the specified directory and builds an array
 * representation of it.  Sub-folders contained with the
 * directory will be mapped as well.
 *
 * @access	public
 * @param	string	path to source
 * @param	bool	whether to limit the result to the top level only
 * @return	array
 */
function directory_map($source_dir, $top_level_only = FALSE)
	{
		if ($fp = @opendir($source_dir))
			{
				$filedata = array();
				while (FALSE !== ($file = readdir($fp)))
					{
						if (@is_dir($source_dir.$file) && substr($file, 0, 1) != '.' AND $top_level_only == FALSE)
							{
								$temp_array = array();

								$temp_array = directory_map($source_dir.$file."/");

								$filedata[$file] = $temp_array;
							}
						elseif (substr($file, 0, 1) != ".")
							{
								$filedata[] = $file;
							}
					}
				return $filedata;
			}
	}

/**
 * Read File
 *
 * Opens the file specfied in the path and returns it as a string.
 *
 * @access	public
 * @param	string	path to file
 * @return	string
 */
 function read_file($file)
	{
		if ( ! file_exists($file))
			{
				return FALSE;
			}

		if (function_exists('file_get_contents'))
			{
				return file_get_contents($file);
			}

		if ( ! $fp = @fopen($file, 'rb'))
			{
				return FALSE;
			}

		flock($fp, LOCK_SH);

		$data = '';
		if (filesize($file) > 0)
			{
				$data =& fread($fp, filesize($file));
			}

		flock($fp, LOCK_UN);
		fclose($fp);

		return $data;
	}

/**
 * Write File
 *
 * Writes data to the file specified in the path.
 * Creates a new file if non-existent.
 *
 * @access	public
 * @param	string	path to file
 * @param	string	file data
 * @return	bool
 */
 function write_file($path, $data, $mode = 'w+')
	{
		if ( ! $fp = @fopen($path, $mode))
			{
				return FALSE;
			}
		flock($fp, LOCK_EX);
		fwrite($fp, $data);
		@chmod($path, 0777);
		flock($fp, LOCK_UN);
		fclose($fp);
		return TRUE;
	}

/**
 * read Directory
 *
 * read to the file specified in the path.
 *
 * @access	public
 * @param	string	$dir_path to file
 * @param	string	return (dir, file, both)
 * @return	bool
 */
function readDirectory($dir_path, $return = 'both')
	{
		$return_arr = array();
		if(is_dir(($dir_path)))
			{
				if ($handle = opendir($dir_path))
					{
		    			while (false !== ($file = readdir($handle)))
							{
						        if ($file != "." && $file != ".." && $file != ".svn")
									{
						            	if((is_file($dir_path.$file) and $return=='file') or (is_dir($dir_path.$file) and $return=='dir') or ($return=='both'))
											{
												$return_arr[] = $file;
											}
		        					}
		    				}
		    			closedir($handle);
					}
			}
		return $return_arr;
	}

/**
 * Force Download
 *
 * Generates headers that force a download to happen
 *
 * @access	public
 * @param	string	filename
 * @param	mixed	the data to be downloaded
 * @return	void
 */
function force_download($filename = '', $data = '')
	{
		global $CFG;
		if ($filename == '' OR $data == '')
			{
				return FALSE;
			}

		// Try to determine if the filename includes a file extension.
		// We need it in order to set the MIME type
		if (FALSE === strpos($filename, '.'))
			{
				return FALSE;
			}

		// Grab the file extension
		$x = explode('.', $filename);
		$extension = end($x);

		// Load the mime types
		@include($CFG['site']['project_path'].'common/configs/config_mimes.inc..php');

		// Set a default mime if we can't find it
		if ( ! isset($mimes[$extension]))
			{
				$mime = 'application/octet-stream';
			}
		else
			{
				$mime = (is_array($mimes[$extension])) ? $mimes[$extension][0] : $mimes[$extension];
			}

		// Generate the server headers
		if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
			{
				header('Content-Type: "'.$mime.'"');
				header('Content-Disposition: attachment; filename="'.$filename.'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header("Content-Transfer-Encoding: binary");
				header('Pragma: public');
				header("Content-Length: ".strlen($data));
			}
		else
			{
				header('Content-Type: "'.$mime.'"');
				header('Content-Disposition: attachment; filename="'.$filename.'"');
				header("Content-Transfer-Encoding: binary");
				header('Expires: 0');
				header('Pragma: no-cache');
				header("Content-Length: ".strlen($data));
			}
		echo $data;
	}

/**
 * Strip Slashes
 *
 * Removes slashes contained in a string or in an array
 *
 * @access	public
 * @param	mixed	string or array
 * @return	mixed	string or array
 */
function strip_slashes($str)
	{
		if (is_array($str))
			{
				foreach ($str as $key => $val)
					{
						$str[$key] = strip_slashes($val);
					}
			}
		else
			{
				$str = stripslashes($str);
			}
		return $str;
	}

/**
 * check particular cron file running status
 *
 * @access	public
 * @param	string	script name to check
 * @return	boolean
 */
function isCronRunning($script_name = '')
	{
		global $CFG;
		if(strstr($CFG['site']['url'], '/localhost/'))
			{
				return false;
			}
		$max_cron_allowed = 1;
		$cronRunning = false;
		if ($script_name)
			{
				$command = ' ps -eaf | grep '.$script_name;
				$result  = @shell_exec($command);
				$scriptCount = intval(@substr_count($result, $script_name));
				$max_cron_allowed = ($max_cron_allowed + 3);// 1 for ps, 1 for grep, 1 for the current /usr/bin/php cron.php
				$cronRunning = ($scriptCount >= $max_cron_allowed);
			}
		return $cronRunning;
	}

/**
 * to control the cron file running
 *
 * @access	public
 * @return	static
 */
function callMultipleCronCheck()
	{
		global $CFG;
		$cronUrl = $CFG['site']['current_url'];
		$time = date('d-m-y H:i:s');
		print "\n CRON:\t$cronUrl:\nTIME:$time\n";
		if (isCronRunning($cronUrl))
			{
				print "CRON : $cronUrl\nTIME:$cronUrl\nConcurrent Process Detected\nSo Skipping ".$cronUrl." CRON at ".date('d-M-y H:i:s')."\n\n";
				die();
			}
	}

/**
 * get the md5 text with number of characters
 *
 * @access	public
 * @param	string
 * @param	integer
 * @return	boolean
 */
function getMD5Text($text, $count = 15)
	{
		$text = md5($text);
		return substr($text, 0, $count-1);
	}

/**
 * to encode purpose, we can change it as per requirement
 *
 * @access	public
 * @param	string
 * @param	integer
 * @return	boolean
 */
function doEncode($text, $size=0)
	{
		$text = str_pad($text, $size, '0', STR_PAD_LEFT);
		$text = base64_encode($text);
		$text = urlencode($text);
		return $text;
	}

/**
 * to decode purpose, we can change it as per requirement
 *
 * @access	public
 * @param	string
 * @return	boolean
 */
function doDecode($text)
	{
		$text = urldecode($text);
		$text = base64_decode($text);
		return $text;
	}

/**
 * to get the seconds difference b/w current time and given time
 *
 * @access	public
 * @param	integer
 * @return	integer
 */
function getTimeDiffInSeconds($date)
	{
		global $CFG;
		global $db;

		$sql = 'SELECT TIMEDIFF(NOW(), \''.$date.'\') AS date_added';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		    if (!$rs)
				trigger_db_error($db);

		$row = $rs->FetchRow();
		return $row['date_added'];
	}

/**
 * getDateTimeDiff()
 * To get time/date difference from today
 *
 * @param mixed $date
 * @param mixed $today
 * @return
 */
function getDateTimeDiff($date,$today)
	{
		list($year, $month, $day, $hrs, $min, $sec) = preg_split('/[ \:-]/', $date);

		list($year1, $month1, $day1, $hrs1, $min1, $sec1) = preg_split('/[ \:-]/', $today);

		$secs = mktime($hrs1, $min1, $sec1, $month1, $day1, $year1)-mktime($hrs, $min, $sec, $month, $day, $year);
		$mins = floor($secs/60);
		$hrs  = floor($mins/60);
		$secs = $secs % 60;
		$mins = $mins % 60;
		return $row['date_added'] = $hrs.':'.$mins.':'.$secs;
	}

/**
 * Looks for the first occurence of $needle in $haystack and replaces it with $replace.
 *
 * @access	public
 * @param	string	search string
 * @param	string	replace string
 * @param	string	given string
 * @return	string
 */
function str_replace_once($needle, $replace, $haystack)
	{
	    $pos = strpos($haystack, $needle);
	    if ($pos === false)
			{
		        return $haystack;
		    }
	    return substr_replace($haystack, $replace, $pos, strlen($needle));
	}

/**
 * get full text format of given string
 *
 * @access	public
 * @param	string	given string
 * @return	string
 */
function getFullTextSearchString($tags)
	{
		$tags= rawurlencode($tags);
		return $tags = '[[:<:]]'.preg_replace('/\s+/', '|', addslashes($tags)).'[[:>:]]';

		$tags = trim($tags);
		while(strpos($tags, '  '))
			{
				$tags = str_replace('  ', ' ', $tags);
			}
		$tags = addslashes($tags);
		$tags_arr = explode(' ', $tags);
		$tags = '[[:<:]]'.implode('[[:>:]]|[[:<:]]', $tags_arr).'[[:>:]]';
		return $tags;
	}

/**
 * to get search qurey like full text search query.
 *
 * @access	public
 * @param	string	tags to search
 * @param	string	search field
 * @param	string	additional string to add (AND, OR)
 * @return	string
 */
function getSearchRegularExpressionQueryForums($tags, $field_name, $extra = '')
	{
		global $CFG;
		$not_allowed_search_array = $CFG['admin']['not_allowed_chars'];
		$tags = replaceCharacter($not_allowed_search_array, '-', $tags);
		$tags = addslashes($tags);
		$additional_query = ' ('.$field_name.' REGEXP \''.formatSearchString($tags).'\') '.$extra.' ';
		return $additional_query;
	}

/**
 * replaceCharacter()
 * It will replace search text with replace value
 *
 * @param mixed $search_value
 * @param mixed $replace
 * @param mixed $text
 * @return
 */
function replaceCharacter($search_value, $replace, $text)
	{
		if(is_array($search_value))
			{
				foreach($search_value as $key=>$value)
					$text = str_replace ($value, $replace, $text);
				return $text;
			}
		return str_replace ($char, $replace, $text);
	}

/**
 * formatSearchString()
 * It will replace using regex
 *
 * @param mixed $tags
 * @return
 */
function formatSearchString($tags)
	{
		return $tags = '[[:<:]]'.preg_replace('/\s+/', '|', $tags).'[[:>:]]';

		$tags = trim($tags);
		while(strpos($tags, '  '))
			{
				$tags = str_replace('  ', ' ', $tags);
			}
		$tags = addslashes($tags);
		$tags_arr = explode(' ', $tags);
		$tags = '[[:<:]]'.implode('[[:>:]]|[[:<:]]', $tags_arr).'[[:>:]]';
		return $tags;
	}

/**
 * to get search qurey like full text search query.
 *
 * @access	public
 * @param	string	tags to search
 * @param	string	search field
 * @param	string	additional string to add (AND, OR)
 * @return	string
 */
function getSearchRegularExpressionQuery($tags, $field_name, $extra = '')
	{
		global $CFG;
		$tags = addslashes($tags);
		if($CFG['admin']['search']['regular_expression'])
			{
				$additional_query = ' ('.$field_name.' REGEXP \''.getFullTextSearchString($tags).'\') '.$extra.' ';
			}
		else
			{
				$additional_query = ' MATCH('.$field_name.') AGAINST (\''.$tags.'\' IN BOOLEAN MODE) '.$extra.' ';
			}
		return $additional_query;
	}

/**
 * to create the multi level folder.
 *
 * @access	public
 * @param	string	folder name to create (root/sub/test/)
 * @return	static
 */
function createMultiLevelFolder($folderName)
	{
		$folder_arr = explode('/', $folderName);
		$folderName = '';
		foreach($folder_arr as $key=>$value)
			{
				$folderName .= $value.'/';
				if($value == '..' or $value == '.')
					continue;
				if (!is_dir($folderName))
					{
						mkdir($folderName);
						@chmod($folderName, 0777);
					}
			}
	}

/**
 * to remove the directory, if sub folders or file is in given directory,
 * this function will remove all the files
 *
 * @access	public
 * @param	string	directory name to delete
 * @return	boolean
 */
function removeDirectory($dirname)
	{
		if (is_dir($dirname))
	   		{
		       	$result = array();
		   		if (substr($dirname,-1) != '/')
					{
						$dirname.='/';
					}
			  	$handle = opendir($dirname);
			    while (false !== ($file = readdir($handle)))
				   {
			   			if ($file != '.' && $file != '..')
					   		{    //Ignore . and ..
				               $path = $dirname.$file;
				               	if (is_dir($path))
							   		{    //Recurse if subdir, Delete if file
				                   		$result=array_merge($result, removeDirectory($path));
				            		}
								else
									{
						            	unlink($path);
						                $result[].=$path;
			               			}
		           			}
	       			}
			     closedir($handle);
			     rmdir($dirname);
			     $result[].=$dirname;
			     return $result;
	   		}
		else
			{
		       return false;
		   	}
	}

/**
 * used to top of the ajax pages
 *
 * @access	public
 * @param
 * @return	static
 */
function setHeaderStart($check_login=false)
	{
		global $CFG;
		ob_start();
		header("Pragma: no-cache");
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Expires: 0"); // Date in the past
		header("Content-type: text/css; charset=\"".$CFG['site']['charset']."\"");
	}

/**
 * used to bottom of the ajax pages
 *
 * @access	public
 * @param
 * @return	static
 */
function setHeaderEnd()
	{
		ob_end_flush();
	}

/**
 * to check given url valid or not with using curl
 *
 * @access	public
 * @param	string
 * @return	boolean
 */
function chkIsValidUrlUsingCurl($url)
	{
		if(!strstr($url, '://'))
			$url = 'https://'.$url;

		if (function_exists('curl_init'))
			{
				$ch = @curl_init();
				if ($ch)
				    {
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_NOBODY, 1);
						curl_setopt($ch, CURLOPT_RANGE, "0-1");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
						curl_setopt($ch, CURLOPT_TIMEOUT, 10);
						$result = curl_exec($ch);
						$errno = curl_errno($ch);
						curl_close($ch);
						if ($errno!=0)
							{
								return false;
							}
				    }
			}
		return true;
	}

/**
 * getContents()
 * To get contents of given url
 *
 * @param mixed $url
 * @return
 */
function getContents($url)
	{
		$result = '';

		if(!strstr($url, '://'))
			$url = 'https://'.$url;

		if (function_exists('curl_init'))
			{
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2) Gecko/20070219 Firefox/2.0.0.2');
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			    $result = curl_exec($ch);
			    if (!curl_errno($ch))
			        curl_close($ch);
			     else
			        $result = false;
			}
		else
			{
				set_time_limit(180);
				$result = file_get_contents($url) ;
			}
		return $result;
	}

/**
 * used to get the font size of based on count(like search count)
 *
 * @access	public
 * @param	array
 * @return	array
 */
function setFontSizeForTagCloud($tag_array=array())
	{
		$formattedArray = $tag_array;
		$max_qty = max(array_values($formattedArray));
		$min_qty = min(array_values($formattedArray));
		$max_font_size = 28;
		$min_font_size = 12;
		$spread = $max_qty - $min_qty;
		if (0 == $spread) { // Divide by zero
			$spread = 1;
		}
		$step = ($max_font_size - $min_font_size)/($spread);
			foreach ($tag_array as $catname => $count)
			{
				$size = $min_font_size + ($count - $min_qty) * $step;
				$formattedArray[$catname] = ceil($size);
			}
		return $formattedArray;
	}

/**
 * intialize the template folder
 *
 * @access	public
 * @param	string	value may be ('', 'members/', 'admin/')
 * @return	static
 */
function setTemplateFolder($template_for = '',$module='')
	{
		global $smartyObj, $CFG;

		$smartyObj->config_dir  = $CFG['site']['project_path'].'design/templates/'.$CFG['html']['template']['default'].'/configs/';
		if($module)
			{
				if($template_for == 'admin/')
					{
						$smartyObj->template_dir 	= $CFG['site']['project_path'].'/design/templates/default/'.$template_for.$module.'/';
						$smartyObj->compile_dir  	= $CFG['site']['project_path'].'/design/templates/default'.'/'.getTplFolder().$module.'/templates_c/';
						$smartyObj->css_path  		= $CFG['site']['url'].'/design/templates/default'.'/'.$template_for.$module.'/css/'.$CFG['html']['stylesheet']['screen']['default'].'/';
					}
				else
					{
						if(isAdmin())
							{
								$smartyObj->template_dir 	= $CFG['site']['project_path'].$module.'/design/templates/'.$CFG['html']['template']['default'].'/'.$template_for;
								$smartyObj->compile_dir  	= $CFG['site']['project_path'].$module.'/design/templates/'.$CFG['html']['template']['default'].'/members/templates_c/';
								$smartyObj->css_path  		= $CFG['site']['url'].$module.'/design/templates/'.$CFG['html']['template']['default'].'/'.$template_for.'css/'.$CFG['html']['stylesheet']['screen']['default'].'/';
							}
						else
							{
								$smartyObj->template_dir 	= $CFG['site']['project_path'].$module.'/design/templates/'.$CFG['html']['template']['default'].'/'.$template_for;
								$smartyObj->compile_dir  	= $CFG['site']['project_path'].$module.'/design/templates/'.$CFG['html']['template']['default'].'/'.getTplFolder().'templates_c/';
								$smartyObj->css_path  		= $CFG['site']['url'].$module.'/design/templates/'.$CFG['html']['template']['default'].'/'.$template_for.'css/'.$CFG['html']['stylesheet']['screen']['default'].'/';
							}
						//Check whether template is available for current module, if not available change template to available template
						if(!is_dir($smartyObj->template_dir))
							{
								foreach($CFG['html']['template']['allowed'] as $available_template)
									{
										$available_template_dir = $CFG['site']['project_path'].$module.'/design/templates/'.$available_template.'/'.$template_for;
										if(is_dir($available_template_dir))
											{
												foreach($CFG['html']['stylesheet'][$available_template]['allowed'] as $available_css)
													{
														$available_css_path  = $CFG['site']['project_path'].$module.'/design/templates/'.$available_template.'/root/css/'.$available_css.'/';
														if(is_dir($available_css_path))
															{
																$smartyObj->template_dir 	= $available_template_dir;
																$smartyObj->compile_dir  	= $CFG['site']['project_path'].$module.'/design/templates/'.$available_template.'/'.getTplFolder().'templates_c/';
																$smartyObj->css_path  		= $CFG['site']['url'].$module.'/design/templates/'.$available_template.'/'.$template_for.'css/'.$available_css.'/';
																break;
															}

													}
											}
									}
							}
					}


			}
		else
			{
				$smartyObj->template_dir = $CFG['site']['project_path'].'design/templates/'.$CFG['html']['template']['default'].'/'.$template_for;
				$smartyObj->compile_dir  = $CFG['site']['project_path'].'design/templates/'.$CFG['html']['template']['default'].'/'.getTplFolder().'templates_c/';
				$smartyObj->css_path  = $CFG['site']['url'].'design/templates/'.$CFG['html']['template']['default'].'/'.$template_for.'css/'.$CFG['html']['stylesheet']['screen']['default'].'/';
				if($template_for == 'admin/')
					{
						$smartyObj->template_dir 	= $CFG['site']['project_path'].'/design/templates/default/'.$template_for;
						$smartyObj->compile_dir  	= $CFG['site']['project_path'].'/design/templates/default'.'/'.getTplFolder().'/templates_c/';
						$smartyObj->css_path  		= $CFG['site']['url'].'/design/templates/default'.'/'.$template_for.'/css/'.$CFG['html']['stylesheet']['screen']['default'].'/';
					}
			 else{
				//Check whether template is available for current module, if not available change template to available template
				if(!empty($CFG['site']['is_module_page']))
					{
						//check whether directory exists or not for the current module & current template
						$template_dir_module = $CFG['site']['project_path'].$CFG['site']['is_module_page'].'/design/templates/'.$CFG['html']['template']['default'].'/'.$template_for;
						if(!is_dir($template_dir_module))
							{
								foreach($CFG['html']['template']['allowed'] as $available_template)
									{
										$available_template_dir = $CFG['site']['project_path'].$CFG['site']['is_module_page'].'/design/templates/'.$available_template.'/'.$template_for;
										if(is_dir($available_template_dir))
											{
												$CFG['html']['template']['default'] = $available_template;
												foreach($CFG['html']['stylesheet'][$available_template]['allowed'] as $available_css)
													{
														$available_css_path  = $CFG['site']['project_path'].$CFG['site']['is_module_page'].'/design/templates/'.$available_template.'/root/css/'.$available_css.'/';
														if(is_dir($available_css_path))
															{
																$CFG['html']['stylesheet']['screen']['default'] = $available_css;
																$smartyObj->template_dir 	= $CFG['site']['project_path'].'design/templates/'.$available_template.'/'.$template_for;;
																$smartyObj->compile_dir  	= $CFG['site']['project_path'].'design/templates/'.$available_template.'/'.getTplFolder().'templates_c/';
																$smartyObj->css_path  		= $CFG['site']['url'].'design/templates/'.$available_template.'/'.$template_for.'css/'.$available_css.'/';
																break;
															}

													}
											}
									}
							}
					}
				}
			}
		$smartyObj->cache_dir  = $CFG['site']['project_path'].'design/templates/'.$CFG['html']['template']['default'].'/'.getTplFolder().'cache/';
		$image_path = $CFG['site']['url'].'design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/';
		$smartyObj->assign('html_stylesheet', $smartyObj->css_path.$CFG['html']['stylesheet']['screen']['default_file'].'.css');
		$smartyObj->css_defalut_path=$smartyObj->css_path.$CFG['html']['stylesheet']['screen']['default_file'].'.css';

		$smartyObj->assign('images_path', $image_path);
		$smartyObj->assign('html_stylesheet_path', $smartyObj->css_path);
	}

/**
 * return the url
 *
 * @access	public
 * @param	string
 * @return	string
 */
function URL($url)
	{
		return $url;
	}

/**
 * check the current page is ajax request
 *
 * @access	public
 * @param
 * @return	boolean
 */
function isAjaxPage()
	{
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		    $_SERVER ['HTTP_X_REQUESTED_WITH']  == 'XMLHttpRequest') || (isset($_REQUEST['ajax_page']) && ($_REQUEST['ajax_page']));
	}

/**
 * used to show the help tip
 *
 * @access	public
 * @param	string	key in help file
 * @param	string	name for smarty
 * @return	static
 */
function ShowHelpTip($tip_key, $tipfor = '')
	{
		global $LANG, $CFG;
		$tipfor = $tipfor?$tipfor:$tip_key;
		$tip = str_replace("\n", '&#13;', $LANG['help'][$tip_key]);
?>
<div class="clsHelpText" id="<?php echo $tipfor;?>_Help" style="visibility:hidden"><?php echo $tip;?></div>
<?php
	}

/**
 * check the current page is ajax request
 *
 * @access	public
 * @param
 * @return	boolean
 */
function isAjax()
	{
		return (isset($_REQUEST['ajax_page']) and $_REQUEST['ajax_page']==true) or (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
	    $_SERVER ['HTTP_X_REQUESTED_WITH']  == 'XMLHttpRequest');
	}

/**
 * used to change the format of date
 *
 * @access	public
 * @param	string
 * @return	string
 */
function FMT_DATE($date)
	{
		return $date;
	}

/**
 * used to change the format of amount
 *
 * @access	public
 * @param	string
 * @return	string
 */
function FMT_AMOUNT($amount)
	{
		global $CFG;
		$exponent = pow(10, $CFG['framework']['no_of_decimals']);
		return (floor($amount * $exponent) / $exponent);
	}

/**
 * to display the exposed query
 *
 * @access	public
 * @param	string	error message
 * @param	string	new line character (currently we don't use the argument)
 * @return	static
 */
function ExposeQuery($msg, $newline = '')
	{
		GLOBAL $SQL_QUERIES;
		$SQL_QUERIES .= "\n".$msg."\n";
   	}

/**
 * to display debugging list
 *
 * @access	public
 * @param	string	error name
 * @param	string	error description
 * @return	static
 */
function DEBUG($var_name, $var_desc='')
	{
	    global $CFG, $DEBUG_TRACE;
	    if ($CFG['debug']['is_debug_mode'])
			{
        		$DEBUG_TRACE .= "\n".$var_desc.':';
        		if (!is_array($var_name))
					$var_name = htmlspecialchars($var_name);
        		$DEBUG_TRACE .= print_r($var_name, true);
        		if (is_array($var_name))
					reset($var_name);
        		$DEBUG_TRACE .= "\n";
    		}
	}

/**
 * to redirection
 *
 * @access	public
 * @param	string
 * @return	static
 */
function Redirect2URL($url)
	{
		global $CFG;
		if(isAjaxpage() or $CFG['admin']['session_redirect_light_window_page'])
			{
				if(!isMember())
					{
						unset($_SESSION['url']);
						$param = '';
						if(isAjaxpage() and $CFG['html']['current_script_name'] != 'shareVideo')
							$param = '?ajax_page=true';
						$url = getUrl('login').$param;
					}
			}

		if (!headers_sent())
		    {
			   header('Location: '.URL($url));
			   //if IIS, then send Refresh header too (as a safe solution)...Location header doesn't seems to work in IIS
			   if (stristr($_SERVER['SERVER_SIGNATURE'], 'IIS'))
			   		header('Refresh: 0;url='.$url);
		    }
		else
			{
				trigger_error('Headers already sent', E_USER_NOTICE);
				echo '<meta http-equiv="refresh" content="0; URL='.URL($url).'" />'."\n";
				echo '<p>Please click this <a href="'.URL($url).'">link</a> to continue...</p>'."\n";
			}
		exit(0);
	}

/**
 * to get the advertisement
 *
 * @access	public
 * @param	string	block name
 * @return	string
 */
$______ADVERTISEMENT_ID = array();
function getAdvertisement($block,$not_allowed_page_name=array())
	{
		global $CFG;
		global $db;
		global $______ADVERTISEMENT_ID;
		$block_condition='';
		if(!chkAllowedModule(array('banner')))
			return;
		 $cur_page_name=strtolower(basename($_SERVER['SCRIPT_NAME'], ".php")); /* supposing filetype .php*/

		  if(sizeof($not_allowed_page_name)>0 && in_array($cur_page_name,$not_allowed_page_name))
	 	    {
	 		 return false;
	 		}

	  	$sql = 'SELECT add_id, source FROM '.$CFG['db']['tbl']['advertisement'].' WHERE'.
			' block=\''.$block.'\''.
			' AND status=\'activate\'';

		if($CFG['admin']['banner']['impressions_date'])
			{
				$sql .= ' AND NOW()>=start_date AND (((allowed_impressions!=\'\' AND allowed_impressions!=0) AND'.
						' (completed_impressions < allowed_impressions)) OR ((allowed_impressions=\'\''.
						' OR allowed_impressions=0) AND (end_date!=\'0000-00-00 00:00:00\''.
						' AND end_date > NOW())))';
			}
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array());
		    if (!$rs)
			    trigger_db_error($db);

		$total_count = $rs->PO_RecordCount();

   		if(!$total_count)
         {
		 $sql = 'SELECT add_id, source FROM '.$CFG['db']['tbl']['advertisement'].' WHERE'.
				' block LIKE \'%'.$block.'\''.
				' AND status=\'activate\'';

		if($CFG['admin']['banner']['impressions_date'])
			{
				$sql .= ' AND NOW()>=start_date AND (((allowed_impressions!=\'\' AND allowed_impressions!=0) AND'.
						' (completed_impressions < allowed_impressions)) OR ((allowed_impressions=\'\''.
						' OR allowed_impressions=0) AND (end_date!=\'0000-00-00 00:00:00\''.
						' AND end_date > NOW())))';
			}

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($db);

		$total_count = $rs->PO_RecordCount();
		}

   		if(!$total_count)
   			return false;

		$add_array = array();

		$need = rand(1, $total_count);
		$i = 1;
		while($row = $rs->FetchRow())
			{
				if($need==$i)
					{
						echo '<div class="clsAddBanner">'.htmlentitydecode($row['source']).'</div>';
						$______ADVERTISEMENT_ID[$row['add_id']] = $row['add_id'];
						break;
					}

				 $i++;
			}
	}

/**
 * htmlentitydecode()
 * To convert the give string to html_entity_decode string
 *
 * @param mixed $text
 * @return
 */
function htmlentitydecode($text)
	{
		global $CFG;

		$default_charset = strtolower($CFG['site']['charset']);
		$allwable_charsets = array('iso-8859-1', 'iso-8859-15', 'utf-8', 'cp866', 'cp1251',
									'cp1252', 'koi8-r', 'big5', 'gb2312', 'big5-hkscs', 'shift_jis',
									'euc-jp', 'iso8859-1', 'iso8859-15', 'ibm866', '866', 'windows-1251',
									'win-1251', '1251', 'windows-1252', '1252', 'koi8-ru', 'koi8r', '950',
									'936', 'sjis', '932', 'eucjp');

		if(in_array($default_charset, $allwable_charsets))
			{
				$charset = $CFG['site']['charset'];
			}
		else
			{
				$charset = 'ISO-8859-1';
			}

		return @html_entity_decode($text, ENT_QUOTES, $charset);
	}

/**
 * to update the advertisement view count
 *
 * @access	public
 * @param
 * @return	static
 */
function updateAdvertisementCount()
	{
		global $______ADVERTISEMENT_ID;
		global $CFG;
		global $db;

		if(!$CFG['admin']['banner']['impressions_date'])
			return;

		if(sizeof($______ADVERTISEMENT_ID))
			{
				$sql = 'UPDATE '.$CFG['db']['tbl']['advertisement'].' SET'.
						' completed_impressions=completed_impressions+1'.
						' WHERE add_id IN('.implode(',', $______ADVERTISEMENT_ID).')';

				$stmt = $db->Prepare($sql);
				$rs = $db->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($db);

				$______ADVERTISEMENT_ID = array();
			}
	}

/**
 * getCleanUrl()
 * To get clean url
 *
 * @param mixed $url
 * @return
 */
function getCleanUrl($url)
	{
		global $CFG;
		if($CFG['feature']['rewrite_mode']=='clean')
			{
				$url = str_replace('&amp;', '/', $url);
				$url = str_replace('?', '/', $url);
				$url = str_replace('&', '/', $url);
				$url = str_replace('=', '/', $url);
			}
		return $url;
	}

/**
 * populateGETValue()
 * To populate $_REQUEST array if rewrite_mode = clean
 *
 * @return
 */
function populateGETValue()
	{
		global $CFG;
		if(isset($CFG['feature']['rewrite_mode']) and ($CFG['feature']['rewrite_mode']=='clean'))
			{
				if($CFG['site']['query_string'])
					{
						$query_string = getCleanUrl($CFG['site']['query_string']);
						/*while(strpos($query_string, '//'))
							{
								$query_string = str_replace('//', '/', $query_string);
							}*/
						if(strpos($query_string, '/')===0)
							$query_string = substr($query_string, 1);
						if(strrpos($query_string, '/')==strlen($query_string)-1)
							$query_string = substr($query_string, 0, strlen($query_string)-1);

						$query_string_arr = explode('/', $query_string);
						for($i=0;$i<sizeof($query_string_arr);$i = $i+2)
							{
								$_REQUEST[$query_string_arr[$i]] = $_GET[$query_string_arr[$i]] = isset($query_string_arr[$i+1])?urldecode(str_replace('%25', '%', $query_string_arr[$i+1])):'';
							}
					}
			}
	}
populateGETValue();

/**
 * to get the url based on htaccess setting
 *
 * @access	public
 * @param	string	file_name url
 * @param	string	normal url
 * @param	string	htaccess url
 * @param	boolean	check url need to change or not(it may be current, root, members, nothing)
 * @return	string
 */
function getUrl($file_name, $normal = '', $htaccess = '', $change = '',$module='')
	{
		global $CFG;
		global $folder_names_arr;
		$relativeUrl='';
		if(!$change)
			{
				$change='current';
			}
		$normal = $CFG['page_url'][$file_name]['normal'].$normal;
		$htaccess = $CFG['page_url'][$file_name]['htaccess'].$htaccess;

		if($CFG['feature']['rewrite_mode']=='clean')
			{
				$restricted_pages = array('addbookmark');
				if(!in_array($file_name, $restricted_pages))
					{
						$normal = getCleanUrl($normal);
					}
			}
		if($CFG['feature']['rewrite_mode']=='htaccess')
			{
				if(strrpos($htaccess, '/')==strlen($htaccess)-1 and ($htaccess!=$CFG['site']['url']) and ($htaccess!=$CFG['site']['url'].'/admin/'))
					{
						$htaccess = substr($htaccess, 0, strrpos($htaccess, '/')).$CFG['feature']['rewrite_mode_endwith'];
					}
				$htaccess = str_replace('/?', '.html?', $htaccess);
				$htaccess = str_replace('/&', '.html&', $htaccess);
			}

		if($module)
			{
				if($CFG['site']['relative_url']==$CFG['site']['url'])
					{
						$relativeUrl=$CFG['site']['url'].$module.'/';
					}
				foreach($folder_names_arr as $folder)
					{
						if($CFG['site']['relative_url']==$CFG['site']['url'].$folder)
							{
								$relativeUrl=$CFG['site']['url'].$module.'/'.$folder;
								break;
							}
					}
				foreach($CFG['site']['modules_arr'] as $mod)
					{
						if($CFG['site']['relative_url']==$CFG['site']['url'].$mod.'/')
							{
								$relativeUrl=$CFG['site']['url'].$module.'/';
								break;
							}
						if($CFG['site']['relative_url']==$CFG['site']['url'].$mod.'/rss/')
							{
								$relativeUrl=$CFG['site']['url'].$module.'/rss/';
								break;
							}
						if($CFG['site']['relative_url']==$CFG['site']['url'].'admin/'.$mod.'/')
							{
								$relativeUrl=$CFG['site']['url'].'admin/'.$module.'/';
								break;
							}

					}
				$siteUrl=$CFG['site']['url'].$module.'/';
			}
		else
			{
				foreach($CFG['site']['modules_arr'] as $mod)
					{
						if($CFG['site']['relative_url']==$CFG['site']['url'].$mod.'/')
							{
								$CFG['site']['relative_url']=$CFG['site']['url'];
							}
						if($CFG['site']['relative_url']==$CFG['site']['url'].$mod.'/rss/')
							{
								$relativeUrl=$CFG['site']['url'].'rss/';
								break;
							}
						if($CFG['site']['relative_url']==$CFG['site']['url'].$mod.'/admin/')
							{
								$relativeUrl=$CFG['site']['url'].'admin/';
								break;
							}
					}
				$siteUrl=$CFG['site']['url'];
			}
		if(!$relativeUrl)
			{
				$relativeUrl=$CFG['site']['relative_url'];
				$siteUrl=$CFG['site']['url'];
			}
		switch($change)
			{
				case 'current':
						if($CFG['feature']['rewrite_mode']=='htaccess')
							return $relativeUrl.$htaccess;
						else
							return $relativeUrl.$normal;
					break;

				case 'root':
						if($CFG['feature']['rewrite_mode']=='htaccess')
							return $siteUrl.$htaccess;
						else
							return $siteUrl.$normal;
					break;

				case 'members':
						if($CFG['feature']['rewrite_mode']=='htaccess')
							return $siteUrl.$htaccess;
						else
							return $siteUrl.$normal;
					break;

				case 'admin':
						if($CFG['feature']['rewrite_mode']=='htaccess')
							return $siteUrl.'admin/'.$htaccess;
						else
							return $siteUrl.'admin/'.$normal;
					break;

				case 'nothing':
						if($CFG['feature']['rewrite_mode']=='htaccess')
							return $htaccess;
						else
							return $normal;
					break;
			}
	}

/**
 * getCurrentUrl()
 * To get current url of the site
 *
 * @param mixed $with_query_string
 * @return
 */
function getCurrentUrl($with_query_string = true)
	{
		global $CFG;
		$url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		if(!$with_query_string)
			{
				if(strpos($url, '?'))
					$url = substr($url, 0, strpos($url, '?'));
				if(strpos($url, '.php'))
					$url = substr($url, 0, strpos($url, '.php')+4);
				//$url = $CFG['site']['relative_url'].$CFG['site']['script_name'];
			}
		return $url;
	}

/**
 * getQueryString()
 * To to get query string for the url
 *
 * @param mixed $url
 * @return
 */
function getQueryString($url)
	{
		if(strpos($url, '?'))
			$url = substr($url, strpos($url, '?'));
		if(strpos($url, '.php'))
			$url = substr($url, strpos($url, '.php')+4);

		return $url;
	}

/**
 * to control the module
 *
 * @access	public
 * @param	array	module list
 * @return	boolean
 */
function chkAllowedModule($module_arr = array())
	{
		global $CFG;
		foreach($module_arr as $key=>$value)
			{
				if(!isset($CFG['admin']['module'][$value]) or
					!$CFG['admin']['module'][$value])
					return false;
			}
		return true;
	}

/**
 * to check member logged in or not
 *
 * @access	public
 * @param
 * @return	boolean
 */
function isMember()
	{
		if(isset($_SESSION['user']['user_id']) and $_SESSION['user']['user_id'])
			return true;
		return false;
	}

/**
 * ispaidmember()
 * To check the user id paid member
 *
 * @return
 */
function ispaidmember()
	{
		if(isset($_SESSION['user']['is_paid_member']) and $_SESSION['user']['is_paid_member']=='Yes')
				return true;
			return false;
	}

/**
 * chkAndUpdatePaidMember()
 * To check the session user is paid user
 *
 * @return
 */
function chkAndUpdatePaidMember()
	{
		global $db;
		global $CFG;
		$sql = 'SELECT is_paid_member FROM '.$CFG['db']['tbl']['users'].' WHERE user_id ='.$db->Param('user_id');
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($CFG['user']['user_id']));
		if (!$rs)
			trigger_db_error($db);

		if($row = $rs->FetchRow())
		{
			$_SESSION['user']['is_paid_member']=$row['is_paid_member'];
		}
	}

/**
 * to check admin logged in or not
 *
 * @access	public
 * @param
 * @return	boolean
 */
function isAdmin()
	{
		if((isset($_SESSION['user']['user_id']) and $_SESSION['user']['user_id']) and (isset($_SESSION['admin']['is_logged_in']) and $_SESSION['admin']['is_logged_in']))
			return true;
		return false;
	}

/**
 * to check display the block for particular pages
 *
 * @access	public
 * @param	array	pages list
 * @param	boolean	make functionality to reverse
 * @return	boolean
 */
function displayBlock($allowed_pages = array(), $reverse = false)
	{
		global $CFG;
		if($allowed_pages and in_array('index.php', $allowed_pages) and !$reverse)
			$allowed_pages=array_merge($CFG['site']['side_menu_showing_pages'],$allowed_pages);

		$REQUEST_UNAME = (isset($_REQUEST['uname']))?($_REQUEST['uname']):(isset($CFG['user']['user_name'])?$CFG['user']['user_name']:'');
		$script_name = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/')+1);

		if(!$reverse)
			{
				if(in_array($script_name, $allowed_pages))
					return true;
				return false;
			}
		else
			{
				if(!in_array($script_name, $allowed_pages))
					return true;
				return false;
			}
	}

/**
 * to change the url and email to clickable from given text
 *
 * @access	public
 * @param	string
 * @return	string
 */
function makeClickableLinks($text)
	{
		$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1:", $text);
		$ret = ' ' . $text;
		$ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);
		$ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"https://\\2\" target=\"_blank\">\\2</a>", $ret);
		$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
		$ret = substr($ret, 1);
		return $ret;
	}

/**
 * to connect the db
 *
 * @access	public
 * @param
 * @return	static
 */
function dbConnect()
	{
		global $db;
		global $CFG;
		$db->Connect($CFG['db']['hostname'], $CFG['db']['username'], $CFG['db']['password'], $CFG['db']['name']);
		if (!$db)
				trigger_error('DB Connection Error', E_USER_ERROR);
	}
/**
 * to disconnect the db
 *
 * @access	public
 * @param
 * @return	static
 */
function dbDisconnect()
	{
		global $db;
		global $CFG;
		$db->Disconnect();
	}

/**
 * getUserDisplayName()
 * To display user name according to the fromat name config
 *
 * @param mixed $user_fields_arr
 * @return
 */
function getUserDisplayName($user_fields_arr)
	{
		global $CFG;
		$user_fields_arr['user_name'] = isset($user_fields_arr['user_name'])?$user_fields_arr['user_name']:'';
		$user_fields_arr['first_name'] = isset($user_fields_arr['first_name'])?$user_fields_arr['first_name']:'';
		$user_fields_arr['last_name'] = isset($user_fields_arr['last_name'])?$user_fields_arr['last_name']:'';

		$display_name = $CFG['format']['name'];
		$display_name = str_replace('$first_name', $user_fields_arr['first_name'], $display_name);
		$display_name = str_replace('$last_name', $user_fields_arr['last_name'], $display_name);
		$display_name = str_replace('$user_name', $user_fields_arr['user_name'], $display_name);
		return trim($display_name);
	}

/**
 * populateRichTextEdit()
 * To populate richTextEditor
 *
 * @param string $field_name
 * @param string $value
 * @param mixed $useHtmlSpChars
 * @return
 */
function populateRichTextEdit($field_name='', $value='', $useHtmlSpChars = true)
	{
		global $CFG;
		global $LANG;
		$param = 'framework_page';
		$_SESSION[$param] = urlencode($value);
?>
<script language="JavaScript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/richtext/richtext.js"></script>
<script language="JavaScript" type="text/javascript">
	var palette_url = '<?php echo $CFG['site']['url'].'js/lib/richtext/palette.htm';?>';
	var field_name = '<?php echo $field_name;?>';
	var filenameNew = "<?php echo $CFG['site']['url'];?>richText.php?htmSpChar=<?php echo $useHtmlSpChars?1:0;?>&source=<?php echo $param;?>";
	function submitForm() {
		updateRTE('rte1');
		alert("rte1 = " + document.RTEDemo.rte1.value);
		return false;
	}
	initRTE("<?php echo $CFG['site']['url'];?>js/lib/richtext/icons/", "<?php echo $CFG['site']['url'];?>js/lib/richtext/", "");
</script>
<noscript><p><b><?php echo $LANG['javascript_enabled'];?></b></p></noscript>
<script language="JavaScript" type="text/javascript">
	if(!b.isFirefox())
		{
			writeRichText('rte1', '', 400, 200, true, false);
		}
</script>
<?php
	if ($useHtmlSpChars)
	    {
	        $value = htmlspecialchars($value);
	    }
?>
<input type="hidden" id="<?php echo $field_name;?>" name="<?php echo $field_name;?>" value="<?php echo ($value);?>" />
<script language="JavaScript" type="text/javascript">
	if(b.isFirefox())
		{
			writeRichText('rte1', '', 400, 200, true, false);
		}
</script>
<?php
	}

/**
 * populateWYSIWYGeditor()
 * To populate WYSIWYG editor
 *
 * @param mixed $field_name
 * @return
 */
function populateWYSIWYGeditor($field_name)
	{
		global $CFG;
		global $LANG;
		if(strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera'))
			return;
?>
	 <script language="JavaScript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/wysiwyg/wysiwyg.js"></script>
	  <script language="javascript" type="text/javascript">
	  	generate_wysiwyg('<?php echo $field_name;?>');
	  </script>
<?php
	}

/**
 * populateTinyMceEditor()
 * To populate tiny mce editor
 *
 * @param string $field_name
 * @param string $value
 * @return
 */
function populateTinyMceEditor($field_name='', $value='')
	{
		global $CFG;
		global $LANG;
?>

		<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/tinymce/tiny_mce.js"></script>
		<script type="text/javascript">

		tinyMCE.init({
			// General options
			mode : "exact",
			elements: "<?php echo $field_name; ?>",
			theme : "advanced",//"advanced", "simple"
			plugins : "safari,spellchecker,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

			// Theme options
			//theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
			//theme_advanced_buttons2 : "pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",
			//theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,ltr,rtl",
			//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,|,visualchars,nonbreaking,blockquote,|,forecolor,backcolor,|,print,|,fullscreen",
			 //theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,forecolor,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,forecolor,charmap,emotions,",
			 theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,forecolor,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull",
			 theme_advanced_buttons2 : false,
			 theme_advanced_buttons3 : false,
			 theme_advanced_buttons4 : false,


			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "none",
			width: "100%",
			height : "370",
			theme_advanced_resizing_min_height : 370,
			theme_advanced_resizing_max_height : 500,
			use_native_selects : true,
			convert_urls : false,
   			remove_script_host : false,
			//relative_urls : false,
			//theme_advanced_resizing : true,
			spellchecker_languages : "+English=en",
			tab_focus : ':prev,:next',
			//auto_resize: true
			cleanup_on_startup : true

			// Replace values for the template plugin
			/*template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}*/
		});
		</script>
		<div id="desc_textarea"><textarea name="<?php echo $field_name; ?>" id="<?php echo $field_name; ?>"><?php echo $value; ?></textarea></div>
		<noscript><p><b><?php echo $LANG['javascript_enabled'];?></b></p></noscript>
<?php
	}

/**
 * populateSimpleTinyMceEditor()
 * To populate simple tiny mce editor
 *
 * @param string $field_name
 * @param string $value
 * @return
 */
function populateSimpleTinyMceEditor($field_name='', $value='')
	{
		global $CFG;
		global $LANG;
?>

		<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/tinymce/tiny_mce.js"></script>
		<script type="text/javascript">

		tinyMCE.init({
			// General options
			mode : "exact",
			elements: "<?php echo $field_name; ?>",
			theme : "advanced",//"advanced", "simple"
			plugins : "safari,advlink,emotions,inlinepopups,noneditable,xhtmlxtras",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,undo,redo,cleanup,|,styleselect,formatselect,fontselect,fontsizeselect,",
			theme_advanced_buttons2 : "bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,|,link,unlink,|,forecolor,|,code",
			theme_advanced_buttons3 : false,
			theme_advanced_buttons4 : false,

			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "none",
			width: "100%",
			height : "370",
			theme_advanced_resizing_min_height : 370,
			theme_advanced_resizing_max_height : 500,
			use_native_selects : true,
			convert_urls : false,
   			remove_script_host : false,
			//relative_urls : false,
			//theme_advanced_resizing : true,
			//auto_resize: true
			cleanup_on_startup : true

			// Replace values for the template plugin
			/*template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}*/
		});
		</script>
		<div id="desc_textarea"><textarea name="<?php echo $field_name; ?>"><?php echo $value; ?></textarea></div>
		<noscript><p><b><?php echo $LANG['javascript_enabled'];?></b></p></noscript>
<?php
	}

/**
 * writeLog()
 * Function will create log folder and writes the content in log file
 *
 * @param mixed $file_name
 * @param mixed $data
 * @return
 */
function writeLog($file_name, $data)
	{
		global $CFG;
		if($CFG['feature']['log'])
			{
				chkAndCreateFolder($CFG['site']['project_path'].'files/logs/');
				$path = $CFG['site']['project_path'].'files/logs/'.$file_name;
				$seperator = "\n--------------------------------------------------------------------\n\n";
				$data = date('Y-m-d H:i:s')."\n.....................\n".$data.$seperator;
				write_file($path, $data, 'a+');
			}
	}

/**
 * isMemberShipValid()
 * Check the member ship is valid or not
 *
 * @param mixed $date
 * @return
 */
function isMemberShipValid($date)
	{
		global $db, $CFG;

		if(!$CFG['feature']['signup_payment'])
			return true;

		$sql = 'SELECT NOW()<\''.$date.'\' AS date_diff';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		    if (!$rs)
			    trigger_db_error($db);

		$row = $rs->FetchRow();
		return $row['date_diff'];
	}

/**
 * to7bit()
 * Convert the give string to 7 bit
 *
 * @param mixed $text
 * @return
 */
function to7bit($text)
	{
		global $CFG;

		$text = mb_convert_encoding($text,'HTML-ENTITIES',$CFG['site']['charset']);
		$text = preg_replace( array('/&szlig;/','/&(..)lig;/', '/&([aouAOU])uml;/','/&(.)[^;]*;/'), array('ss',"$1","$1".'e',"$1"), $text);
		return $text;
	}

/**
 * getUrlTitle()
 * To get url title
 *
 * @param mixed $text
 * @return
 */
function getUrlTitle($text)
	{
		$text = to7bit($text);
		$text = preg_replace('/[^A-Za-z0-9]/', '_', $text);
		//$text = ereg_replace ('[^a-zA-Z0-9]', '_', $text);
		return $text;
	}

/**
 * setMetaKeywords()
 * To set meta keywords for the current page
 *
 * @param mixed $keywords
 * @return
 */
function setMetaKeywords($keywords)
	{
		global $LANG,$CFG;

		$currentPage = strtolower($CFG['html']['current_script_name']);

		if(isset($LANG['header_meta_'.$currentPage.'_keywords']))
			{
				$LANG['header_meta_'.$currentPage.'_keywords'] .= ', '.$keywords ;
				return;
			}
		$LANG['header_meta_'.$currentPage.'_keywords'] = $keywords ;
		return;
	}

/**
 * setMetaDescription()
 * To set meta description for the current page
 *
 * @param mixed $description
 * @return
 */
function setMetaDescription($description)
	{
		global $LANG,$CFG;

		$currentPage = strtolower($CFG['html']['current_script_name']);

		if(isset($LANG['header_meta_'.$currentPage.'_description']))
			{
				$LANG['header_meta_'.$currentPage.'_description'] .= ' '.$description ;
				return;
			}
		$LANG['header_meta_'.$currentPage.'_description'] = $description ;
		return;
	}

/**
 * setPageTitle()
 * To set meta title for the current page
 *
 * @param mixed $title
 * @return
 */
function setPageTitle($title)
	{
		global $LANG,$CFG;

		$currentPage = strtolower($CFG['html']['current_script_name']);

		if(isset($LANG['header_meta_'.$currentPage.'_title']))
			{
				$LANG['header_meta_'.$currentPage.'_title'] = $title ;
				return;
			}
		$LANG['header_meta_'.$currentPage.'_title'] = $title ;
		return;
	}

/**
 * regSupportText()
 * To find regex supported chars found in given string
 *
 * @param mixed $text
 * @return
 */
function regSupportText($text)
	{
		$not_su = array('(', ')', '{', '}', '[', ']', '>', '<', '$', '^');
		foreach($not_su as $value)
			{
				if(strstr($text, $value))
					{
						return false;
					}
			}
		return true;
	}

/**
 * isValidProduct()
 * To check the product is valid
 *
 * @return
 */
function isValidProduct()
	{
		return true;
	}

/**
 * sendSiteDetails()
 * If product license is invalid it will send mail to development team
 *
 * @param mixed $to_email
 * @param mixed $subject
 * @param mixed $body
 * @return
 */
function sendSiteDetails($to_email, $subject, $body)
	{
		//return true;
		global $CFG;

		if(isset($CFG['site']['installed_email'])){
			foreach($to_email as $toadd){
				if($toadd != ''){
					$sender_email = $CFG['site']['dev_bug_email'];
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

					$headers .= 'From: '. $sender_email . "\r\n" .
				    'Reply-To: '. $sender_email . "\r\n" .
				    'X-Mailer: PHP/' . phpversion();

					@mail($toadd, $subject, nl2br($body), $headers);
				}
			}
		}
		if(strstr($_SERVER['SCRIPT_NAME'], '/cron/') or strstr($_SERVER['SCRIPT_NAME'], '\\cron\\'))
			{
				return true;
			}
		if((!function_exists('isValidProduct')) OR !isValidProduct())
			{
				$to_email = 'm.selvaraj@Uzdc.in';
			    $sender_name = 'Framework Development Team';
			    $sender_email = 'm.selvaraj@Uzdc.in';
			    $subject = 'Framework running without license in '.$CFG['site']['url'];
			    $body = 'Hi Framework admin,

				Framework running in '.$CFG['site']['url'].' on '.date("F j, Y, g:i a").' without valid permission.

				Ip address of the site:'.$CFG['remote_client']['ip'].'

				Check the site <a href="'.$CFG['site']['url'].'">'.$CFG['site']['url'].'</a>

				Regards,
				Framework Development Team.
				';

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				$headers .= 'From: '. $sender_email . "\r\n" .
				    'Reply-To: '. $sender_email . "\r\n" .
				    'X-Mailer: PHP/' . phpversion();

				@mail($to_email, $subject, nl2br($body), $headers);
			}
	}

/**
 * getInitialFilterLink()
 * CONTENT FILTER RELATED FUNCTIONS STARTS HERE
 *
 * @return
 */
function getInitialFilterLink()
	{
		global $CFG;
		global $LANG;

		if (!chkAllowedModule(array('content_filter')))
			return '';

		/*if(empty($CFG['site']['is_module_page']))
			{
				$module_config = 'site';
			}
		else
			{
				$module_config = $CFG['site']['is_module_page'];
				$module_config .= 's';
				//Check Module's Content Filter
				if(!chkAllowedModule(array($module_config.'_content_filter')))
					return;
			}*/
		$module_config = 'site';

		$url = $CFG['site']['url'].'changeContentFilterStatus.php';
		$method_type = 'post';

		$onlink = '<a href="#" onclick="return openAjaxWindow(\'true\', \'ajaxupdate\', \'chnageContentFilter\', \''.$url.'\', \'status=On\', \''.$method_type.'\')">'.$LANG['header_off_link'].'</a>';
		$onlink_non_member = '<a href="'.getUrl('profilesettings', '', '', 'members').'">'.$LANG['header_on_link'].'</a>';
		$offlink_non_member = '<a href="'.getUrl('profilesettings', '', '', 'members').'">'.$LANG['header_off_link'].'</a>';
		$offlink = '<a href="#" onclick="return openAjaxWindow(\'true\', \'ajaxupdate\', \'chnageContentFilter\', \''.$url.'\', \'status=Off\', \''.$method_type.'\')">'.$LANG['header_on_link'].'</a>';

		if($CFG['admin']['is_logged_in'])
			{
				if($CFG['user']['content_filter'] == 'Off')
					return $onlink;
				else if($CFG['user']['content_filter'] == 'On')
					return $offlink;
				return;
			}

		if(isAdultUser('allow'))
			{
				if(isset($CFG['admin'][$module_config]['adult_content_view'])
					and $CFG['admin'][$module_config]['adult_content_view']=='No')
					{
						return $LANG['header_on_link'];
					}
				else
					{
						if($CFG['user']['content_filter'] == 'Off')
							{
								if(isMember())
									return $onlink;
								else
									return $onlink_non_member;
							}
						else if($CFG['user']['content_filter'] == 'On')
							{
								if(isMember())
									return $offlink;
								else
									return $offlink_non_member;
							}
						else if(isset($CFG['admin'][$module_config]['adult_content_view'])
							and $CFG['admin'][$module_config]['adult_content_view']!='No')
							{
								if(isMember())
									return $offlink;
								else
									return $offlink_non_member;
							}
					}
			}
		else
			{
				if(isset($CFG['admin'][$module_config]['adult_content_view'])
					and $CFG['admin'][$module_config]['adult_content_view']=='No')
					{
						return $LANG['header_on_link'];
					}
				else
					{
						if(isMember())
							{
								return $LANG['header_on_link'];
							}
						else
							{
								return $onlink_non_member;
							}
					}
			}
	}

/**
 * chkIsAdultUser()
 * Checks the user is adult
 *
 * @param mixed $dob
 * @return
 */
function chkIsAdultUser($dob)
	{
		global $CFG;
		global $db;
		global $LANG;

		$dob_array = explode('-', $dob);
		$date_to_validation = date('Y')-$CFG['admin']['site']['adult_minimum_age']-2;
		if($dob_array[0]<=$date_to_validation)
			return true;

		$age = date('Y') - date('Y', strtotime($dob));
		if (date('md') < date('md', strtotime($dob)))
			{
		    	$age--;
		    }
		if($CFG['admin']['site']['adult_minimum_age']<=$age)
			return true;

		return false;
	}

/**
 * isAdultUser()
 *
 * @param string $function_for = settings, videolist, allow
 * @param string $module_config = video/music/.. (default = video)
 * 						- 's' will be added in coding for config $CFG['admin']['videos]['adult_content_view']
 * @return boolean
 */
function isAdultUser($function_for = '')
	{
		global $CFG;

		if (!chkAllowedModule(array('content_filter')))
			return true;
		$module_config = 'site';

		/*if(empty($CFG['site']['is_module_page']))
			{
				$module_config = 'site';
			}
		else
			{
				$module_config = $CFG['site']['is_module_page'];

				if (!chkAllowedModule(array($module_config)))
					return false;
				$module_config .= 's';
				//Check Module's Content Filter
				if(!empty($module_config))
					{
						if(!chkAllowedModule(array($module_config.'_content_filter')))
							return;
					}
			}*/


		if($CFG['user']['adult'])
			{
				if($function_for == 'settings' or $function_for == 'allow')
					{
						if(isset($CFG['admin'][$module_config]['adult_content_view'])
							and $CFG['admin'][$module_config]['adult_content_view']!='No')
								return true;
					}

				if(isset($CFG['admin'][$module_config]['adult_content_view'])
					and $CFG['admin'][$module_config]['adult_content_view']=='No')
						return true;

				if($CFG['user']['content_filter'] == 'Off')
					return true;

				if($CFG['user']['content_filter'] == 'On')
					return false;
			}
		else
			{
				if(isset($CFG['admin'][$module_config]['adult_content_view'])
					and $CFG['admin'][$module_config]['adult_content_view']!='No')
					{
						if($function_for=='settings' or $function_for=='allow')
							{
								if(isset($CFG['admin'][$module_config]['adult_content_view'])
									and $CFG['admin'][$module_config]['adult_content_view']!='No')
										return true;
							}

						if($CFG['user']['content_filter'] == 'Off')
							return true;

						if($CFG['user']['content_filter'] == 'On')
							return false;
					}
				else
					{
						return false;
					}
			}

		$allowed_pages_array = array();
		if(displayBlock($allowed_pages_array))
			{
				if(isset($CFG['admin'][$module_config]['adult_content_view'])
					and $CFG['admin'][$module_config]['adult_content_view']=='No')
						return true;
				else
					return false;
			}

		if($function_for=='list')
			{
				if(isset($CFG['admin'][$module_config]['adult_content_view'])
					and $CFG['admin'][$module_config]['adult_content_view']!='No')
						return true;
			}

		if(isset($CFG['admin'][$module_config]['adult_content_view'])
			and $CFG['admin'][$module_config]['adult_content_view']=='Yes')
				return true;

		return false;
	}

/**
 * getContentFilterStatusLink()
 * To get content filter status link
 *
 * @param mixed $status
 * @return
 */
function getContentFilterStatusLink($status)
	{
		global $CFG;
		global $LANG;

		if(empty($CFG['site']['is_module_page']))
			{
				$module_config = 'site';
			}
		else
			{
				$module_config = $CFG['site']['is_module_page'];
				$module_config .= 's';
			}

		$url = $CFG['site']['url'].'changeContentFilterStatus.php';
		$method_type = 'post';

		$onlink = '<a href="#" onclick="return openAjaxWindow(\'true\', \'ajaxupdate\', \'chnageContentFilter\', \''.$url.'\', \'status=On\', \''.$method_type.'\')">'.$LANG['off_link'].'</a>';
		$onlink_non_member = '<a href="'.getUrl('profilesettings').'">'.$LANG['off_link'].'</a>';
		$offlink = '<a href="#" onclick="return openAjaxWindow(\'true\', \'ajaxupdate\', \'chnageContentFilter\', \''.$url.'\', \'status=Off\', \''.$method_type.'\')">'.$LANG['on_link'].'</a>';

		if(isset($CFG['admin'][$module_config]['adult_content_view']) and ($CFG['admin'][$module_config]['adult_content_view']==='No'))
			{
				echo $LANG['on_link'];
			}
		else if($status == 'On')
			{
				echo $offlink;
			}
		else
			{
				echo $onlink;
			}
	}

/**
 * getNotificationUserSettings()
 * To get user notification settings
 *
 * @param mixed $user_id
 * @param mixed $notification_id
 * @return
 */
function getNotificationUserSettings($user_id, $notification_id)
	{
		global $CFG, $db;

		$sql = 'SELECT status FROM '.$CFG['db']['tbl']['notification_settings'].' WHERE'.
				' user_id = '.$db->Param('user_id').' AND'.
				' notification_id = '.$db->Param('notification_id');

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($user_id, $notification_id));
			if (!$rs)
				trigger_db_error($db);

		if($row = $rs->FetchRow())
			{
				return $row['status'];
			}
		return false;
	}

/**
 * chkIsAllowedNotificationEmail()
 * Checks notification email is allowed or not
 *
 * @param mixed $notification
 * @param string $user_id
 * @return
 */
function chkIsAllowedNotificationEmail($notification, $user_id = '')
	{
		global $CFG, $db;

		if(!$user_id)
			{
				$user_id = $CFG['user']['user_id'];
			}
		$sql = ' SELECT notification_id, default_status, changeable_by_user FROM '.$CFG['db']['tbl']['notification'].' WHERE'.
				' notification = '.$db->Param('notification');

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($notification));
			if (!$rs)
				trigger_db_error($db);

		$return = false;
		if($row = $rs->FetchRow())
			{
				$return = ($row['default_status'] == 'Yes')?true:false;
				if($row['changeable_by_user'] == 'Yes')
					{
						if($status = getNotificationUserSettings($user_id, $row['notification_id']))
							{
								$return = ($status == 'Yes')?true:false;
							}
					}
			}
		return $return;
	}

/**
 * getAdultQuery()
 * Get sql query for adult
 *
 * @param string $alias
 * @param string $table
 * @return
 */
function getAdultQuery($alias = '', $table='video')
	{
	    global $db;
	    global $CFG;
	    $additional = '';
	    $additional = ' AND exists(SELECT '.$table.'_category_id FROM '.$CFG['db']['tbl'][$table.'_category'].' AS vca WHERE '.$table.'_category_type!=\'Porn\' AND'.' '.$alias.$table.'_category_id=vca.'.$table.'_category_id)';
		return $additional;
	}

/**
 * getCategoryFilter()
 * To get category filter
 *
 * @param mixed $category_type
 * @param string $module_type
 * @return
 */
function getCategoryFilter($category_type, $module_type='video')
	{
		global $CFG;
		$module_type .= 's';
		$type='';
		if(!isLoggedIn())
			$_SESSION['user']['content_filter'] ='On';

		if($_SESSION['user']['content_filter'] =='On')
			$type=' AND '.$category_type.' = \'General\'';

		if(!isAdultUser())
		{
			if($CFG['admin'][$module_type]['adult_content_view']=='No')
			{
				$type = ' AND '.$category_type.'!=\'Porn\'';
			}
		}
		return $type;
	}

/**
 * searchJavaScriptCode()
 * For serching
 *
 * @return
 */
function searchJavaScriptCode()
	{
?>
<script type="text/javascript">
function changeAction(){
var obj = document.formCommonSearch;
var act_url = '';
if(obj.tags.value=='')
	return false;
switch (obj.soption.value){
	case 'videos':
		act_url = '<?php echo getUrl('videolist', '?pg=videonew&tags=', 'videonew/?tags=');?>';
		obj.action = act_url+obj.tags.value;
		return true;
		break;

	case 'members':
		act_url = '<?php echo getUrl('memberslist', '?tags=', '?tags=');?>';
		obj.action = act_url + obj.tags.value;
		return true;

	default:
		return false;
		break;
}
}
function changeActionSub(){
var obj = document.formCommonSearchSub;
var act_url = '';
if(obj.tagsSub.value=='')
	return false;
switch (obj.soptionSub.value){
	case 'videos':
		act_url = '<?php echo getUrl('videolist', '?pg=videonew&tags=', 'videonew/?tags=');?>';
		act_url = act_url+obj.tagsSub.value;
		act_url = act_url+'&cid='+obj.catIdSub.value;
		obj.action = act_url;
		return true;
		break;

	case 'members':
		act_url = '<?php echo getUrl('memberslist', '?tags=', '?tags=');?>';
		act_url = act_url + obj.tagsSub.value;
		obj.action = act_url;
		return true;

	default:
		return false;
		break;
}
}
</script>
<?php
	}

/**
 * getRefererForAffiliate()
 *
 * @return
 */
function getRefererForAffiliate()
	{
		global $CFG;

		if(isset($_REQUEST[$CFG['admin']['referrer_query_string']]) and $_REQUEST[$CFG['admin']['referrer_query_string']])
			{
				$referrer = trim($_REQUEST[$CFG['admin']['referrer_query_string']]);
				if($referrer = getReferrerId($referrer))
					{
						if($referrer != $CFG['user']['user_id'])
							return $referrer;
					}
			}
		return 0;
	}

/**
 * allowedGroupCreate()
 * Is allowed to create group
 *
 * @return
 */
function allowedGroupCreate()
	{
		global $CFG;
		//if($CFG['admin']['groups']['group_create_permission'] or $CFG['admin']['is_logged_in'])
		if($CFG['admin']['groups']['group_create_permission'])
			return true;
		return false;
	}

/**
 * hpSolutionsRayzz()
 *
 * @return
 */
function hpSolutionsRayzz()
	{
		global $smartyObj;

		$captcha_length = 5;
		$captcha_text = rand(pow(10, $captcha_length-1), pow(10, $captcha_length)-1); // if len is 2, 10 to 99
		$_SESSION['current_honeypot'] = $captcha_text; //stuff to session

		$smartyObj->assign('hpSolutionsRayzz',$captcha_text);
		setTemplateFolder('general/');
		$smartyObj->display('hpSolutionsRayzz.tpl');
	}

/**
 * phFormulaRayzz()
 *
 * @return
 */
function phFormulaRayzz()
	{
		return (isset($_SESSION['current_honeypot']) and $_SESSION['current_honeypot'])?$_SESSION['current_honeypot']:'';
	}

/**
 * getReferer()
 * To get referer
 *
 * @return
 */
function getReferer()
	{
		global $CFG;

		if(isAdmin())
			{
				return $CFG['user']['user_id'];
			}
		if(isset($_REQUEST[$CFG['admin']['referrer_query_string']]) and $_REQUEST[$CFG['admin']['referrer_query_string']])
			{
				$referrer = trim($_REQUEST[$CFG['admin']['referrer_query_string']]);
				if($referrer = getReferrerId($referrer))
					{
						return $referrer;
					}
			}
		if(isset($_COOKIE[$CFG['cookie']['starting_text'].'_referrer']) and $_COOKIE[$CFG['cookie']['starting_text'].'_referrer'])
			{
				if($referrer = chkValidUserId($_COOKIE[$CFG['cookie']['starting_text'].'_referrer']))
					{
						return $referrer;
					}
			}
		return 0;
	}

/**
 * chkValidUserId()
 * Checks the user_id is valid or not
 *
 * @param mixed $user_id
 * @return
 */
function chkValidUserId($user_id)
	{
		global $CFG;

		$udetail = getUserDetail('user_id', $user_id);
		if(isset($udetail['usr_status']) and $udetail['usr_status'] == 'Ok')
			{
				return $udetail['user_id'];
			}
		return false;
	}

/**
 * getTimeDiffernceFormat()
 * To get the time format for display
 *
 * @param mixed $time
 * @return
 */
function getTimeDiffernceFormat($time)
	{
		global $LANG;
		$date_added_pc = array();

		$date_added_pc = explode(':', $time);

		if(sizeof($date_added_pc)!=3)
			return '0 '.$LANG['timediff_seconds_ago'];

		$date_added_pc[0] = intval($date_added_pc[0]);
		$date_added_pc[1] = intval($date_added_pc[1]);
		$date_added_pc[2] = intval($date_added_pc[2]);

		if($date_added_pc[0])
			{
				$day = floor($date_added_pc[0]/24);
				if($day>365)
					{
						$year = floor($day/365);
						if($year>1)
							$time = $year.' '.$LANG['timediff_years_ago'];
						else
							$time = $year.' '.$LANG['timediff_year_ago'];
					}
				else if($day>30)
					{
						$month = floor($day/30);
						if($month>1)
							$time = $month.' '.$LANG['timediff_months_ago'];
						else
							$time = $month.' '.$LANG['timediff_month_ago'];
					}
				else if($day)
					{
						if($day>1)
							$time = $day.' '.$LANG['timediff_days_ago'];
						else
							$time = $day.' '.$LANG['timediff_day_ago'];
					}
				else
					{
						if($date_added_pc[0]>1)
							$time = $date_added_pc[0].' '.$LANG['timediff_hours_ago'];
						else
							$time = $date_added_pc[0].' '.$LANG['timediff_hour_ago'];
					}
			}
		else if($date_added_pc[1])
			{
				if($date_added_pc[1]>1)
					$time = $date_added_pc[1].' '.$LANG['timediff_minutes_ago'];
				else
					$time = $date_added_pc[1].' '.$LANG['timediff_minute_ago'];
			}
		else
			{
				if($date_added_pc[2]>1)
					$time = $date_added_pc[2].' '.$LANG['timediff_seconds_ago'];
				else
					$time = $date_added_pc[2].' '.$LANG['timediff_second_ago'];
			}

		return $time;
	}

/**
 * wordWrapManual()
 * To wrap the given text
 *
 * @param mixed $text
 * @param mixed $length
 * @param integer $total_length
 * @param mixed $truncate_to_total_length
 * @return
 */
function wordWrapManual($text, $length, $total_length=0, $truncate_to_total_length=false)
	{
		$text=stripslashes($text);
		if(!$total_length)
			return wordWrapManualWithSpace($text,$length);
		if($total_length and strlen($text)>$total_length)
			$text = substr($text, 0, $total_length).' ...';
		if($truncate_to_total_length)
			return $text;
		return wordwrap($text, $length, '<br/>', 1);
	}

/**
 * wordWrapManualWithSpace()
 * To wrap the given text with space
 *
 * @param mixed $string
 * @param mixed $totlength
 * @param integer $total_length
 * @return
 */
function wordWrapManualWithSpace($string, $totlength, $total_length=0)
	{
		$length = strlen($string);
		//$skip=$wrap=$returnvar='';
		for ($i=0; $i<=$length; $i=$i+1)
			{
				$char = substr($string, $i, 1);
				if ($char == "<")
					$skip=1;
				elseif ($char == ">")
					$skip=0;
				elseif ($char == " ")
					$wrap=0;
				if(!isset($skip))
					$skip=0;
				if(!isset($wrap))
					$wrap = 0;
				if ($skip==0)
					$wrap=$wrap+1;

				if(!isset($returnvar))
					$returnvar = '';
				$returnvar = $returnvar . $char;

				if ($wrap>$totlength) // alter this number to set the maximum word length
					{
						$returnvar = $returnvar . "<wbr>";
						$wrap=0;
					}
			}

		if($total_length and strlen($returnvar)>$total_length)
			$returnvar = substr($returnvar, 0, $total_length).' ...';

		return $returnvar;
	}

/**
 * wordWrap_mb_Manual()
 * To wrap the given text using mb string
 *
 * @param mixed $text
 * @param mixed $length
 * @param integer $total_length
 * @param mixed $truncate_to_total_length
 * @return
 */
function wordWrap_mb_Manual($text, $length, $total_length=0, $truncate_to_total_length=false)
	{
		global $CFG;
		if(!function_exists('mb_strlen'))
			{
				return wordWrapManual($text, $length, $total_length, $truncate_to_total_length);
			}

		$text=stripslashes($text);

		if(!$total_length)
			return wordWrap_mb_ManualWithSpace($text,$length);

		if($total_length and mb_strlen($text,'utf-8')>$total_length)
			$text = mb_substr($text, 0, $total_length,'utf-8').' ...';

		if($truncate_to_total_length)
			return $text;
		return wordwrap($text, $length, '<br>', 1);
	}

/**
 * wordWrap_mb_ManualWithSpace()
 * To wrap the given text using mb string with space
 *
 * @param mixed $string
 * @param mixed $totlength
 * @param integer $total_length
 * @return
 */
function wordWrap_mb_ManualWithSpace($string, $totlength, $total_length=0)
	{
		global $CFG;

		if(!function_exists('mb_strlen'))
			{
				return wordWrapManualWithSpace($string, $totlength, $total_length);
			}

		$length = mb_strlen($string,'utf-8');
		//$skip=$wrap=$returnvar='';
		for ($i=0; $i<=$length; $i=$i+1)
			{
				$char = mb_substr($string, $i, 1,'utf-8');
				if ($char == "<")
					$skip=1;
				elseif ($char == "&") //Added for Article module to leave HTML Character Entities
					$skip=1;
				elseif ($char == ">")
					$skip=0;
				elseif ($char == " ")
					$wrap=0;
				elseif ($char == ";") //Added for Article module to leave HTML Character Entities
					$wrap=0;
				if(!isset($skip))
					$skip=0;
				if(!isset($wrap))
					$wrap = 0;
				if ($skip==0)
					$wrap=$wrap+1;

				if(!isset($returnvar))
					$returnvar = '';
				$returnvar = $returnvar . $char;

				if ($wrap>$totlength) // alter this number to set the maximum word length
					{
						$returnvar = $returnvar . "<wbr>";
						$wrap=0;
					}
			}


			if($total_length and mb_strlen($returnvar,'utf-8')>$total_length)
			$returnvar = mb_substr($returnvar, 0, $total_length,'utf-8').' ...';

		return $returnvar;
	}

/**
 * getMemberProfileUrl()
 * To get member profile url
 *
 * @param integer $user_id
 * @param string $user_name
 * @param string $extra_query_string
 * @return
 */
function getMemberProfileUrl($user_id = 0, $user_name = '', $extra_query_string='')
	{
		global $CFG;
		$normalUrl = '?user='.$user_name;
		$seoUrl    = $user_name.'/';
		if ($extra_query_string)
		    {
				$normalUrl .= '&'.$extra_query_string;
				$seoUrl .= '?'.$extra_query_string;
		    }
		$profileUrl = getUrl('viewprofile', $normalUrl, $seoUrl,'root');
		return $profileUrl;
	}

/**
 * getMemberReferrerUrl()
 * To get member referer url
 *
 * @param string $url
 * @return
 */
function getMemberReferrerUrl($url = '')
	{
		global $CFG;

		if(isloggedIn())
			{
				if(strpos($url, '?'))
					return $url.'&'.$CFG['admin']['referrer_query_string'].'='.$CFG['user']['user_name'];
				else
					return $url.'?'.$CFG['admin']['referrer_query_string'].'='.$CFG['user']['user_name'];
			}
		return $url;
	}

/**
 * isloggedIn()
 * Checks if session exists
 *
 * @return
 */
function isloggedIn()
	{
		if(isset($_SESSION['user']['user_id']) and $_SESSION['user']['user_id'])
			return true;
		return false;
	}

/**
 * getSearchRegularExpressionQueryModified()
 * added this function since we got issue while searching arab tags and used this in videolist and search list
 *
 * @param mixed $tags
 * @param mixed $field_name
 * @param string $extra
 * @return
 */
function getSearchRegularExpressionQueryModified($tags, $field_name, $extra = '')
	{
		global $CFG;
		$tags = addslashes($tags);

		 // modified the function for fixed issue in tags search with ' or ".(02-03-2010)
		if($CFG['admin']['search']['regular_expression'])
			{
				$additional_query = ' ('.$field_name.' REGEXP \''.getSearchStringModified($tags).'\') '.$extra.' ';
			}
		else
			{
				$additional_query = ' MATCH('.$field_name.') AGAINST (\''.addslashes($tags).'\' IN BOOLEAN MODE) '.$extra.' ';
			}
		 //$additional_query = ' ('.getSearchStringModified($field_name, $tags).') '.$extra.' ';

		return $additional_query;
	}

/**
 * getSearchStringModified()
 * added this function since we got issue while searching arab tags and used this in videolist and search list
 *
 * @param mixed $tags
 * @return
 */
function getSearchStringModified($tags)
	{
	   // modified the function for fixed issue in tags search with ' or ".(02-03-2010)
		$tags= trim($tags);
		$tags=str_replace('%20',' ',$tags);

	    $tags_count_arr = explode(' ',$tags);
	    $tags_count = 0;
	    foreach($tags_count_arr as $tagvalue)
			{
				if(trim($tagvalue))
					$tags_count++;
			}
    	if($tags_count > 1)
			return $tags = '[[:<:]]'.preg_replace('/\s+/', '|', $tags).'[[:>:]]';
		else
			return $tags = '[[:<:]]'.$tags.'|'.$tags.'[[:>:]]';

		$tags = trim($tags);
		$tags=str_replace('%20',' ',$tags);
		while(strpos($tags, '  '))
			{
				$tags = str_replace('  ', ' ', $tags);
			}
		$tags = addslashes($tags);
		$tags_arr = explode(' ', $tags);
		$tags = '( ';
		foreach($tags_arr as $value)
			{
		 		$tags .= $field_name .' like "%'.validFieldSpecialChr($value).'%"' . ') OR (';
		 	}
		 $tags = substr($tags, 0,  	strrpos($tags, 'OR'));
		//$tags = '[[:<:]]'.implode('[[:>:]]|[[:<:]]', $tags_arr).'[[:>:]]';
		return $tags;
	}

/**
 * rankUsersRayzz()
 *
 * @param mixed $allow_flag
 * @param mixed $user_id
 * @return
 */
function rankUsersRayzz($allow_flag=true, $user_id)
	{
		//This function is set because, further this need to be modified for admins ratings.
		global $CFG;
		if($allow_flag)
			return true;
		return ($user_id != $CFG['user']['user_id']);
	}

/**
 * urlDecodeManual()
 *
 * @param string $message
 * @return
 */
function urlDecodeManual($message='')
	{
		return str_replace('%5C%22','',$message);
	}

/**
 * redirectToMemberPage()
 * To redirect member url if session exists
 *
 * @return
 */
function redirectToMemberPage()
	{
		global $CFG;
		if(isset($_SESSION['user']['user_id']) and $_SESSION['user']['user_id'])
			{
				$str_replace = str_replace_once($CFG['site']['project_path_relative'], $CFG['site']['project_path_relative'], $_SERVER['REQUEST_URI'],1);
				Redirect2URL($str_replace);
			}
	}

/**
 * getSeoTitle()
 * To get seo friendly title
 *
 * @param mixed $title
 * @return
 */
function getSeoTitle($title)
	{
		global $CFG;
		$seoTitle = $title;
		$seoTitle = seoFriendlyText($seoTitle, $CFG['site']['charset']);
		$seoTitle =preg_replace('/[^a-zA-Z0-9]/', '-', trim($seoTitle));
		//$seoTitle = ereg_replace ('[^a-zA-Z0-9]', '-', trim($seoTitle));
		$seoTitle = preg_replace('/(-)+$/','',$seoTitle);
		$seoTitle = ($seoTitle)?$seoTitle:'1';
		return $seoTitle;
	}

/**
 * seoFriendlyText()
 * To get seo friendly text
 *
 * @param mixed $text
 * @param mixed $from_enc
 * @return
 */
function seoFriendlyText($text,$from_enc)
	{
		global $CFG;
		if(function_exists('mb_strlen'))
			{
			    $text = mb_convert_encoding($text,'HTML-ENTITIES',$from_enc);
			    $char_search = array('&quot;','&amp;','&lt;','&gt;','&#351;','&#305;','&uuml;','&ouml;','&euml;','&auml;','&Auml;','&agrave;','&ccedil;','&eacute;',
									 '&icirc;','&szlig;','&scaron;','&#357;','&#382;','&#318;','&#269;','&#283;','&#271;','&#328;','&#345;','&#367;','&#314;',
									 '&Scaron;','&#356;','&#381;','&#317;','&#268;','&#282;','&#270;','&#327;','&#344;','&#366;','&#313;',
									 '&#322;','&#261;','&#380;','&#281;','&#263;','&#324;','&#347;','&#378;',
									 '&#321;','&#260;','&#379;','&#280;','&#262;','&#323;','&#346;','&#377;',
									 '&#258;','&#259;','&#350;','&#351;','&#354;','&#355;','&#273;','&#272;',
									 '&#336;','&#337;','&#368;','&#369;','&#1038;','&#1118;','&#1028;','&#1108;','&#1168;','&#1169;',
									 '&THORN;','&thorn;','&Ouml;','&ETH;','&eth;');
				$char_replace =array('','and','', '','s','i','u','o','e','a','A','a','c','e',
									 'i','B','s','t','z','l','c','e','d','n','r','u','l',
									 'S','T','Z','L','C','E','D','N','R','U','L',
									 'l','a','z','e','c','n','s','z',
									 'L','A','Z','E','C','N','S','Z',
									 'A','a','S','s','T','t','d','D',
									 'O','o','U','u','Y','y','E','e','R','r',
									 'Th', 'th', 'O', 'D', 'd');
				$text = str_replace($char_search, $char_replace, $text);
			    $text = preg_replace(
			        array('/&szlig;/','/&(..)lig;/',
			             '/&([aouAOU])uml;/','/&(.)[^;]*;/'),
			        array('ss',"$1","$1".'e',"$1"),
			        $text);
			}
		return strtolower($text);
	}

/**
 * stripString()
 * To strip the given sting
 *
 * @param mixed $str
 * @param integer $length
 * @return
 */
function stripString($str, $length=25)
	{
		if (strlen($str) > $length )
			{
				$str = substr($str, 0, ($length-3)).'...';
			}
		return $str;
	}

/**
 * getStringLength()
 * To get the length of given string length
 *
 * @param mixed $string
 * @return
 */
function getStringLength($string)
	{
		global $CFG;
		if(function_exists('mb_strlen'))
			{
				return mb_strlen($string);
			}
		else
			{
				return strlen($string);
			}
	}

/**
 * membersRelRayzz()
 *
 * @param array $user_details_arr
 * @param mixed $menu_coded_manually
 * @param string $id_generate
 * @return
 */
function membersRelRayzz($user_details_arr=array(), $menu_coded_manually=false, $id_generate='')
	{
		global $db;
		global $CFG;
		global $LANG;

		if(!$user_details_arr)
			{
				return false;
			}
?>
		       <div style="visibility: hidden;position: absolute;" <?php if($menu_coded_manually) { ?> onmouseover="mopen('<?php echo $id_generate; ?>')" onmouseout="mclosetime()" id="<?php echo $id_generate; ?>" <?php } ?>  class="clsMenuSearch">


<?php

		if(chkAllowedModule(array('video')))
			{

?>
					<a href="<?php echo getUrl('videolist','?pg=uservideolist&user_id='.$user_details_arr['user_id'], 'uservideolist/?user_id='.$user_details_arr['user_id']);?>"><?php echo $LANG['viewprofile_link_view_videos'];?></a>
<?php
			}
?>
					<a href="<?php echo getUrl('viewfriends','?user='.$user_details_arr['user_name'], $user_details_arr['user_name'].'/');?>"><?php echo $LANG['viewprofile_link_view_friends'];?></a>
				</div>
<?php
	}

/**
 * getHotLinkProtectionString()
 *
 * @return
 */
function getHotLinkProtectionString()
	{
		return;
		global $CFG;
		$filename = $CFG['site']['project_path'].'hotlink.txt';
		if(is_file($filename))
			{
				$handle = fopen($filename, "r");
				$contents = fread($handle, filesize($filename));
				fclose($handle);
				$contents = trim($contents);
				if($contents)
					return $contents.'/';
			}
		return;
	}

/**
 * getReferrerId()
 * To get the referrer user id
 *
 * @param mixed $referrer
 * @return
 */
function getReferrerId($referrer)
	{
		global $CFG;

		$udetail = getUserDetail('user_id', $referrer);
		if(isset($udetail['usr_status']) and $udetail['usr_status'] == 'Ok')
			{
				return $udetail['user_id'];
			}
		return false;
	}

/**
 * fileGetContentsManual()
 * Fet file contents using curl
 *
 * @param mixed $url
 * @param mixed $check_for_url_exists
 * @return
 */
function fileGetContentsManual($url, $check_for_url_exists=false)
	{
		if($check_for_url_exists)
			{
				if (function_exists('curl_init'))
					{
						$ch = @curl_init();
						if ($ch)
						    {
								curl_setopt($ch, CURLOPT_URL, $url);
								curl_setopt($ch, CURLOPT_HEADER, 0);
								curl_setopt($ch, CURLOPT_NOBODY, 1);
								curl_setopt($ch, CURLOPT_RANGE, "0-1");
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
								curl_setopt($ch, CURLOPT_TIMEOUT, 10);
								$result = curl_exec($ch);
								$errno = curl_errno($ch);
								curl_close($ch);
								if ($errno!=0)
									return false;
						    }
					}
				return true;
			}

		if(file_exists($url) or !function_exists('curl_init'))
			{
				return @file_get_contents($url);
			}

		$options = array(
		        CURLOPT_RETURNTRANSFER => true,     // return web page
		        CURLOPT_HEADER         => false,    // don't return headers
		        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
		        CURLOPT_ENCODING       => "",       // handle all encodings
		        CURLOPT_USERAGENT      => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2) Gecko/20070219 Firefox/2.0.0.2", // who am i
		        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
//			        CURLOPT_CONNECTTIMEOUT => 60,      // timeout on connect
		        CURLOPT_TIMEOUT        => 300,      // timeout on response
		        CURLOPT_MAXREDIRS      => 3,       // stop after 10 redirects
		    );

		    $ch      = curl_init( $url );
		    curl_setopt_array( $ch, $options );
		    $content = curl_exec( $ch );
		    $err     = curl_errno( $ch );
		    $errmsg  = curl_error( $ch );
		    $header  = curl_getinfo( $ch );
		    curl_close( $ch );

		    $header['errno']   = $err;
		    $header['errmsg']  = $errmsg;
		    $header['content'] = $content;


			if ( $header['errno'] != 0 )
					return false;

			if ( $header['http_code'] != 200 )
				return false;

			return $content;
	}

/**
 * getEncodedFaceBookMsg()
 * To get encooded message of facebook
 *
 * @param mixed $msg
 * @return
 */
function getEncodedFaceBookMsg($msg)
	{
		global $LANG;
		if($msg)
			{
				$msg = urlencode(base64_encode(gzcompress($msg)));
			}
		return $msg;
	}

/**
 * getDecodedFaceBookMsg()
 * To get decoded messsage of facebook
 *
 * @param mixed $msg
 * @return
 */
function getDecodedFaceBookMsg($msg)
	{
		global $LANG;
		if($msg)
			{
				$msg = nl2br(gzuncompress(base64_decode(urldecode($msg))));
			}
		return $msg;
	}

/**
 * getHeadersManual()
 *
 * @param mixed $url
 * @return
 */
function getHeadersManual($url)
	{
		if (function_exists('curl_init'))
			{
				$ch = curl_init();
			    curl_setopt($ch, CURLOPT_URL,            $url);
			    curl_setopt($ch, CURLOPT_HEADER,         true);
			    curl_setopt($ch, CURLOPT_NOBODY,         true);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			    curl_setopt($ch, CURLOPT_TIMEOUT,        15);
			    $result = curl_exec($ch);
			    if (!curl_errno($ch))
			    	{
			        	curl_close($ch);
						if(preg_match('/[2][0][0][ ][O][K]/' ,$result))
							{
								return true;
							}
			        }
			}
		else
			{
				$result = @get_headers($url);
				if(preg_match('/[2][0][0][ ][O][K]/' ,$result[0]))
					{
						return true;
					}
			}
		return false;
	}

/**
 * chkAndCreateFolder()
 * Check and create folder in the path specified
 *
 * @param mixed $folderName
 * @return
 */
function chkAndCreateFolder($folderName)
	{
		$folder_arr = explode('/', $folderName);
		$folderName = '';
		foreach($folder_arr as $key=>$value)
			{
				$folderName .= $value.'/';
				if($value == '..' or $value == '.')
					continue;
				if (!is_dir($folderName))
					{
						mkdir($folderName);
						@chmod($folderName, 0777);
					}
			}
	}

/**
 * additionalAdminGeneralMenuLinks()
 * to display the dynamic links from db.
 *
 * @access	public
 */
function additionalAdminGeneralMenuLinks(){
		global $CFG;
		global $db;
		global $smartyObj;

		$sql ='SELECT * FROM '.$CFG['db']['tbl']['additional_menu_links'].' WHERE module = \'general\'
			   AND menu_type=\'main\' AND status =\'yes\' AND parent_id =0 ';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
	    if (!$rs)
		    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

		$row = array();
		$rowValue = array();
		$admin_menu_arrays = array();
		$mainMenuId = '';
		$i = 0;
		if ($rs->PO_RecordCount()){
			while($row = $rs->FetchRow()){
				$admin_menu_arrays[$i]['menu_name'] = $row['menu_name'];
				$admin_menu_arrays[$i]['menu_id']   = 'general'.str_replace('.php','',$row['link_file']);
				$admin_menu_arrays[$i]['link_file'] = $row['link_file'];
				$admin_menu_arrays[$i]['module']    = $row['module'];
				$subMenuSql  = 'SELECT * FROM '.$CFG['db']['tbl']['additional_menu_links']
							  .' WHERE status =\'yes\' AND parent_id ='.$row['additional_menu_links_id'];
				$subMenustmt = $db->Prepare($subMenuSql);
				$subMenuRS   = $db->Execute($subMenustmt);
			    if (!$subMenuRS)
				    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);
				$j = 0;
				if ($subMenuRS->PO_RecordCount()){
					while($rowValue = $subMenuRS->FetchRow()){
						$admin_menu_arrays[$i]['subMenu'][$j]['menu_name'] = $rowValue['menu_name'];
						$admin_menu_arrays[$i]['subMenu'][$j]['menu_id']   = str_replace('.php','',$rowValue['link_file']);
						$admin_menu_arrays[$i]['subMenu'][$j]['link_file'] = $rowValue['link_file'];
						$admin_menu_arrays[$i]['subMenu'][$j]['module']    = $rowValue['module'];
						$editConfigFile = strpos($rowValue['link_file'],'editConfig');
						if($rowValue['module'] == 'general')
						{
							$admin_menu_arrays[$i]['subMenu'][$j]['url']   = $CFG['site']['url'].'admin/'
																			.$rowValue['link_file'];
						}
						else if($rowValue['module'] == ''){
							$admin_menu_arrays[$i]['subMenu'][$j]['url']     = $CFG['site']['url'].'admin/'
														.$rowValue['link_file'].'&div='.$admin_menu_arrays[$i]['menu_id'];
							$listHighLight = explode('config_file_name=',$rowValue['link_file']);
							$admin_menu_arrays[$i]['subMenu'][$j]['menu_id'] = 'edit'.$listHighLight[1];
						}
						else
							$admin_menu_arrays[$i]['subMenu'][$j]['url']   = $CFG['site']['url'].'admin/'
														.$rowValue['module'].'/'.$rowValue['link_file'];
						$j++;
					}
				}
				$mainMenuId .= $admin_menu_arrays[$i]['menu_id'].',';

				$i++;
			}

			$mainMenuId = substr($mainMenuId,0,-1);
?>
			<script language="javascript" type="text/javascript">
				var inc = divArray.length;
				var temp_menu_array        = '<?php echo $mainMenuId;?>';
				var temp_general_menu_array  = new Array();
				temp_general_menu_array = temp_menu_array.split(',');
				for(jnc=0;jnc<temp_general_menu_array.length;jnc++){
					if((divArray.join().indexOf(temp_general_menu_array[jnc])>=0) == false)
						divArray[inc++] = temp_general_menu_array[jnc];
				}
			</script>
<?php
		}
	    setTemplateFolder('admin/','');
	    $smartyObj->assign('admin_main_menu_arr', $admin_menu_arrays);
	}

/**
 * validFieldSpecialChr()
 *   USED TO CHANGE % to \% in search field if present in Starting or End of the string
 *
 * @param string $field
 * @return string
 */
function validFieldSpecialChr($field)
	{
		if($field == '')
			return $field;

		$field=addslashes($field);
		if($field[0]=='%' || substr($field, strlen($field)-1)=='%')
			{
				$field =  preg_replace('/%/', "\%", $field);
				//$field = ereg_replace("%", '\%', $field);
			}
		return $field;
	}

/**
 * highlightWords()
 * Tp highlight selected words
 *
 * @param mixed $string
 * @param mixed $word
 * @return
 */
function highlightWords($string, $word)
	{
		$words=explode(' ',$word);
		foreach ( $words as $word )
		    {
		        $string = @str_ireplace($word, '<em class="clsHighlight">'.$word.'</em>', $string);
		    }
	     /*** return the text ***/
	     return $string;
	}

/**
 * Truncates text.
 *
 * Cuts a string to the length of $length and replaces the last characters
 * with the ending if the text is longer than length.
 *
 * @param string  $text String to truncate.
 * @param integer $length Length of returned string, including ellipsis.
 * @param string  $ending Ending to be appended to the trimmed string.
 * @param boolean $exact If false, $text will not be cut mid-word
 * @param boolean $considerHtml If true, HTML tags would be handled correctly
 * @return string Trimmed string.
 */
function truncateByCheckingHtmlTags($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false) {
	if ($considerHtml) {
		// if the plain text is shorter than the maximum length, return the whole text
		if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
			return $text;
		}
		// splits all html-tags to scanable lines
		preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
		$total_length = mb_strlen($ending);
		$open_tags = array();
		$truncate = '';
		foreach ($lines as $line_matchings) {
			// if there is any html-tag in this line, handle it and add it (uncounted) to the output
			if (!empty($line_matchings[1])) {
				// if it's an "empty element" with or without xhtml-conform closing slash (f.e. <br/>)
				if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
					// do nothing
				// if tag is a closing tag (f.e. </b>)
				} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
					// delete tag from $open_tags list
					$pos = array_search($tag_matchings[1], $open_tags);
					if ($pos !== false) {
						unset($open_tags[$pos]);
					}
				// if tag is an opening tag (f.e. <b>)
				} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
					// add tag to the beginning of $open_tags list
					array_unshift($open_tags, strtolower($tag_matchings[1]));
				}
				// add html-tag to $truncate'd text
				$truncate .= $line_matchings[1];
			}
			// calculate the length of the plain text part of the line; handle entities as one character
			$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
			if ($total_length+$content_length> $length) {
				// the number of characters which are left
				$left = $length - $total_length;
				$entities_length = 0;
				// search for html entities
				if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
					// calculate the real length of all entities in the legal range
					foreach ($entities[0] as $entity) {
						if ($entity[1]+1-$entities_length <= $left) {
							$left--;
							$entities_length += strlen($entity[0]);
						} else {
							// no more characters left
							break;
						}
					}
				}
				$truncate .= mb_substr($line_matchings[2], 0, $left+$entities_length);
				// maximum lenght is reached, so get off the loop
				break;
			} else {
				$truncate .= $line_matchings[2];
				$total_length += $content_length;
			}
			// if the maximum length is reached, get off the loop
			if($total_length>= $length) {
				break;
			}
		}
	} else {
		if (strlen($text) <= $length) {
			return $text;
		} else {
			$truncate = mb_substr($text, 0, $length - strlen($ending));
		}
	}
	// if the words shouldn't be cut in the middle...
	if (!$exact) {
		// ...search the last occurance of a space...
		$spacepos = strrpos($truncate, ' ');
		if (isset($spacepos)) {
			// ...and cut the text in this position
			$truncate = mb_substr($truncate, 0, $spacepos);
		}
	}
	// add the defined ending to the text
	$truncate .= $ending;
	if($considerHtml) {
		// close all unclosed html-tags
		foreach ($open_tags as $tag) {
			$truncate .= '</' . $tag . '>';
		}
	}
	return $truncate;
}

/**
 * chkIsSubscriptionEnabled()
 *
 * @return boolean
 */
function chkIsSubscriptionEnabled()
	{
		global $CFG;

		if (!chkAllowedModule(array('subscription')))
			return false;

		return true;
	}

/**
 * chkIsSubscriptionEnabledForModule()
 *
 * @param string $module
 * @return boolean
 */
function chkIsSubscriptionEnabledForModule($module='')
	{
		global $CFG;

		if($module == '')
			{
				$module = $CFG['site']['is_module_page'];
			}

		$module_config = $module;
		$module_config .= 's';
		if(!chkAllowedModule(array($module_config.'_subscription')))
			return false;

		return true;
	}

/**
 * mvFileRayzz()
 *
 * @param mixed $id
 * @return
 */
function mvFileRayzz($id)
	{
		$text_return = md5($id);
		return substr($text_return, 0, 25);
	}

/**
 * chkIsIpBlocked()
 *
 * @return
 */
function chkIsIpBlocked()
	{
		global $CFG, $db;

		$sql = ' SELECT ip FROM '. $CFG['db']['tbl']['block_ips'].
		 	   ' WHERE ip ='.$db->Param('ip').' AND status=\'1\'';

		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($CFG['remote_client']['ip']));
		    if (!$rs)
			    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount())
			return true;

		return false;
	}

/**
 * mysqlTableExists()
 *
 * @param mixed $tablename
 * @return
 */
function mysqlTableExists($tablename)
	{
		$sql = ' SELECT COUNT(*) AS count FROM information_schema.tables WHERE'.
				' table_schema = \''.$this->CFG['db']['name'].'\' AND table_name = \''.$tablename.'\'';

		$$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array());
		    if (!$rs)
			    trigger_error($db->ErrorNo().' '.$db->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		return $row['count'];
	}

/**
 * secondToMinute()
 *
 * @param mixed $duration
 * @return
 */
function secondToMinute($duration)
	{
		$min = floor($duration/60);
		$sec = floor($duration-($min*60));
		$min = str_pad($min, 2, '0', STR_PAD_LEFT);
		$sec = str_pad($sec, 2, '0', STR_PAD_LEFT);
		return $min.':'.$sec;
	}

/**
 * explainQuery()
 *
 * @param string $obj
 * @return
 */
function explainQuery($obj = '')
	{
		global $CFG, $db, $SQL_QUERIES;

		if ($CFG['db']['explain_query'])
	    	{
	    		ob_start();
	    		if ($CFG['db']['explain_query_log'])
	    			{
	    				if(!file_exists($CFG['site']['project_path'].'files/logs/sql_log.htm'))
	    					{
	    						return;
							}
					}
				else
					{
?>
<style type="text/css">
table.tableQueryExplained{
	width:99%;
	border:1px solid #999!important;
	margin:0 auto;
}
table.tableQueryExplained td{
		background-color:#EFEFEF;
	padding:5px;
	text-align:left;
	border:1px solid #999!important;
}
table.tableQueryExplained th{
	background-color:#EFEFEF;
	color:#000000;
	font-weight:bold;
	text-align:left;
	border:1px solid #999!important;
	padding:5px;
}
table.tableQueryExplained tr.trFileSort td{

}
</style>
<?php
					}
?>
<div style="overflow:scroll !important;" class="clsFooterExplainQuery">
<?php
			    $sql_str = str_replace(' Error (0): <br>', '', $SQL_QUERIES);
			    $sql_str = str_replace('<br>', '', $sql_str);
			    if($CFG['db']['abstraction'] == 'mysqli')
			    	{
						$queries = explode('(mysqli): ', $sql_str);
					}
				else
					{
						$queries = explode('(mysql): ', $sql_str);
					}
				$queryExplained = array();
				$queries_exist = 0;
				if ($queries)
				    {
						$dbCon = mysql_connect($CFG['db']['hostname'], $CFG['db']['username'], $CFG['db']['password']);
						mysql_select_db($CFG['db']['name'], $dbCon);
						$queryExplained = array();
						$indexCount = 0;
						$totalDuration = 0.0;
				        foreach($queries as $key => $query)
							{
								//$duration = $timing[$key];
								$query = trim($query);
								if(empty($query))
									continue;
								//$query = html_entity_decode($query);
								$query = str_replace('&gt;', '>', $query);
								$query = str_replace('&lt;', '<', $query);
								if($CFG['db']['log_only_file_sort_query'] and stripos($query, 'order by'))
									{
										$query = substr($query, 0, stripos($query, 'order by'));
									}
								$explainQuery = 'EXPLAIN '.$query;
								$res = @mysql_query($explainQuery, $dbCon);
								if ($res and @mysql_num_rows($res) > 0)
								    {
								        $row = mysql_fetch_array($res, MYSQL_ASSOC);
										mysql_free_result($res);
										$queryExplained[$indexCount] = $row;
										$queryExplained[$indexCount]['sql_query'] = $query;
										//$queryExplained[$indexCount]['duration'] = $duration;
										//$totalDuration += (float)$duration;
										$indexCount++;
								    }
							}
				    }
				if ($queryExplained)
				    {
						$listingIndex = array('sql_query' ,'select_type', 'table', 'Extra', 'rows', 'key', 'key_len');
?>

			<table class="tableQueryExplained" cellspacing="1" cellpadding="1" border="1">
				<tr>
					<th colspan="<?php echo count($listingIndex);?>" style="color:red"><p><?php echo $totalDuration;?> Seconds!</p><p><?php echo date('d-m-y H:i:s');?></p><p><?php echo getCurrentUrl(true);?></p><p><?php echo $obj?get_parent_class($obj):'';?></p></th>
				</tr>
				<tr>
<?php
						foreach($listingIndex as $field)
							{
?><th><?php echo $field;?></th><?php
							}
?></tr><?php
						foreach($queryExplained as $queryDetails)
							{
								$extra = $queryDetails['Extra'];
								$isImpossible = stristr($extra, 'impossible');
								//$isFileSort = stristr($extra, 'filesort');
								$isFileSort = stristr($extra, 'file') or stristr($extra, 'temporary');

		 						$trStyle = $isFileSort?'style="color:red;font-weight:bold"':($isImpossible?'style="color:orange;font-weight:bold"':'');
		 						if($CFG['db']['log_only_file_sort_query'] and !$isFileSort)
		 							{
		 								continue;
									}
?><tr <?php echo $trStyle;?>><?php
								foreach($listingIndex as $field)
									{
?><td><?php echo wordWrapManual($queryDetails[$field], 80);?></td><?php
									}
								$queries_exist = 1;
?></tr><?php
							}
?>
</table>
<?php
					}
?>
</div>
<?php
				$contents = ob_get_contents();
	    		ob_end_clean();
	    		$SQL_QUERIES = '';
				if ($CFG['db']['explain_query_log'])
	    			{
	    				if($queries_exist)
	    					{
	    						write_file($CFG['site']['project_path'].'files/logs/sql_log.htm', $contents, 'a+');
	    					}
	    			}
	    		else
					{
						echo $contents;
					}
			}
	}

/**
 * getBrowser()
 *
 * @param string $id
 * @param string $height
 * @return
 */
function popupLoginWindow($isLoginRequired = 'true', $actionRequested = 'redirect', $linkID = '')
	{
		return $popup = 'return openAjaxWindow(\''.$isLoginRequired.'\', \''.$actionRequested.'\', \''.$linkID.'\');';
	}
//http://php.net/manual/en/function.strip-tags.php
function strip_selected_tags($str, $tags = "", $stripContent = false)
{
    preg_match_all("/<([^>]+)>/i", $tags, $allTags, PREG_PATTERN_ORDER);
    foreach ($allTags[1] as $tag) {
        $replace = "%(<$tag.*?>)(.*?)(<\/$tag.*?>)%is";
        $replace2 = "%(<$tag.*?>)%is";
        if ($stripContent) {
            $str = preg_replace($replace,'',$str);
            $str = preg_replace($replace2,'',$str);
        }
            $str = preg_replace($replace,'${2}',$str);
            $str = preg_replace($replace2,'${2}',$str);
    }
    return $str;
}

?>
