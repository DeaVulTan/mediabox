<?php
if(class_exists('ListRecordsHandler'))
	{
		$parent_class = 2;
	}
else
	{
		$parent_class = 1;
	}

switch($parent_class)
	{
		case 2:
			class Handler extends ListRecordsHandler{}
			break;
		case 1:
		default:
			class Handler extends FormHandler{}
			break;
	}

/**
 * signupAndLoginHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class signupAndLoginHandler extends Handler
	{
		/**
		 * signupAndLoginHandler::chkIsNotDuplicateUserName()
		 * To check for the duplicate user name
		 *
		 * @param 		string $field_name field name
		 * @param 		string $err_tip error tip
		 * @return 		boolean true/false
		 * @access 		public
		 */
		public function chkIsNotDuplicateUserName($field_name, $err_tip='')
			{
				$sql = 'SELECT user_id FROM ' . $this->CFG['db']['tbl']['users'] .
				 	   	' WHERE user_name = '.$this->dbObj->Param('user_name').
						' AND usr_status!=\'Deleted\''.
						' LIMIT 0, 1';

               	$stmt = $this->dbObj->Prepare($sql);
               	$rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$field_name]));
            	if (!$rs)
               	    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount() <= 0)
				    {
				        return true;
				    }
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}

		/**
		 * signupAndLoginHandler::chkIsNotDuplicateEmail()
		 * To check for the duplicate email id
		 *
		 * @param 		string $field_name email field name
		 * @param 		string $err_tip error tip
		 * @return 		boolean true/false
		 * @access 		public
		 */
		public function chkIsNotDuplicateEmail($field_name, $err_tip='')
			{
				$data_arr[] = $this->fields_arr[$field_name];
				$add = '';
				if(isset($this->fields_arr['user_id']))
					{
						$add = ' AND user_id != '.$this->dbObj->Param('user_id');
						$data_arr[] = $this->fields_arr['user_id'];
					}
				$sql = 'SELECT 1 FROM ' . $this->CFG['db']['tbl']['users'] .
				 	   	' WHERE email = '.$this->dbObj->Param('email').$add.
						' AND usr_status!=\'Deleted\''.
						' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
                $rs = $this->dbObj->Execute($stmt, $data_arr);
                if (!$rs)
            	    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount() <= 0)
				    {
				        return true;
				    }
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}

		/**
		 * signupAndLoginHandler::chkIsSamePasswords()
		 * To check the confirmation of password and password are same
		 *
		 * @param 		string $field_name1 password Field name
		 * @param 		string $field_name2 confirmation password field name
		 * @param 		string $err_tip error tip message
		 * @return 		boolean $is_ok true/false
		 * @access 		public
		 */
		public function chkIsSamePasswords($field_name1, $field_name2, $err_tip='')
			{
				$is_ok = ($this->fields_arr[$field_name1]==$this->fields_arr[$field_name2]);
				if (!$is_ok)
						$this->fields_err_tip_arr[$field_name1] = $this->fields_err_tip_arr[$field_name2] = $err_tip;
				return $is_ok;
			}

		/**
		 * signupAndLoginHandler::chkAlreadySignedIn()
		 * To check already singned in using external login
		 * @param mixed $identity
		 * @param string $status
		 * @param mixed $identity_from
		 * @return
		 */
		public function chkAlreadySignedIn($identity, $status= '',$identity_from='openid')
			{
				$sql = 'SELECT identity_id, user_id FROM '. $this->CFG['db']['tbl']['user_identity'] .
					   ' WHERE identity='.$this->dbObj->Param('identity') .
					   ' AND identity_from = '.$this->dbObj->Param($identity_from);

				if($status == 'ToActivate')
					{
						$sql .=  ' AND status = \'ToActivate\'';
					}
				elseif($status == 'InActive')
					{
						$sql .=  ' AND status = \'InActive\'';
					}
				else
					{
						$sql .=  ' AND status = \'Ok\'';
					}
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($identity, $identity_from));
			    if (!$rs)
		    		trigger_db_error($this->dbObj);
				if($rs->PO_RecordCount() != 0)
					{
						$row = $rs->FetchRow();
						return $row['user_id'];
					}
				return(-1);
			}

		/**
		 * signupAndLoginHandler::chkIsPasswordAndUserNameAreSame()
		 * To check username and password are same or not
		 *
		 * @param  string $err_tip
		 * @return boolean value
		 * @access public
		 */
		public function chkIsPasswordAndUserNameAreSame($err_tip = '')
			{
				if($this->fields_arr['user_name'] and $this->fields_arr['password'])
					{
						if($this->fields_arr['user_name'] == $this->fields_arr['password'])
							{
								$this->fields_err_tip_arr['password'] = $err_tip;
								return false;
							}
					}
				return true;
			}

		/**
		 * signupAndLoginHandler::chkIsAllowedUserName()
		 * To check whether the username is allowed username or not
		 *
		 * @param  string $err_tip
		 * @return boolean value
		 */
		public function chkIsAllowedUserName($err_tip = '')
			{
				$user_name = strtolower($this->fields_arr['user_name']);
				if(in_array($user_name, $this->CFG['admin']['not_allowed_usernames']))
					{
						$this->fields_err_tip_arr['user_name'] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * signupAndLoginHandler::chkIsCorrectDateSignup()
		 * Verifies the date value
		 *
		 * @param string $date yyyy-mm-dd hh:mm:ss
		 * @param string $field form field name
		 * @param string $err_tip_empty error to be shown when the passed date value is empty
		 * @param string $err_tip_empty error to be shown when the passed date value is invalid
		 * @return boolean
		 **/
		public function chkIsCorrectDateSignup($day, $field='', $err_tip_empty='', $err_tip_invalid='')
			{
				$dodArray = explode('-', $day);
				$date = $dodArray[2];
				$month = $dodArray[1];
				$year = $dodArray[0];
				if (empty($field))
				    {
						$this->fields_err_tip_arr[$field] = $err_tip_empty;
						return false;
				    }
				if (checkdate(intval($month), intval($date), intval($year)))
				    {
						$dob = $year.'-'.$month.'-'.$date;
						$date_to_validation = date('Y')-$this->CFG['admin']['members_signup']['age_limit_start'];
						if($year>$date_to_validation)
							$age = $this->getAge($dob);
						else
							$age = date('Y')-$year;
						if ((date('m')-$month < 0) || (date('m')-$month == 0 && date('d')-$date < 0))
							{
								$age = $age - 1;
							}
						if($age<$this->CFG['admin']['members_signup']['age_limit_start'])
							{
								$this->LANG['err_tip_age_min'] = str_replace('VAR_MIN_AGE', $this->CFG['admin']['members_signup']['age_limit_start'], $this->LANG['err_tip_age_min']);
								$this->fields_err_tip_arr[$field] = $this->LANG['err_tip_age_min'];
								return false;
							}
						if($age>$this->CFG['admin']['members_signup']['age_limit_end'])
						  	{
								$this->LANG['err_tip_age_max'] = str_replace('VAR_MAX_AGE', $this->CFG['admin']['members_signup']['age_limit_end'], $this->LANG['err_tip_age_max']);
								$this->fields_err_tip_arr[$field] = $this->LANG['err_tip_age_max'];
								return false;
							}
						 $this->fields_arr[$field] = $dob;
					     return true;
				    }
				else
					{
						$this->fields_err_tip_arr[$field] = $err_tip_invalid;
						return false;
					}
			}

		/**
		 * signupAndLoginHandler::insertIntoUserIdentity()
		 * To update user indentity info in user_identity table
		 * @param mixed $user_id
		 * @param mixed $identity_from
		 * @return
		 */
		public function insertIntoUserIdentity($user_id,$identity_from='openid')
			{
				$sql =  'INSERT INTO ' . $this->CFG['db']['tbl']['user_identity'] .
						' SET user_id = ' . $this->dbObj->Param('user_id') .
						', identity = ' . $this->dbObj->Param('identity') .
						', hashcode = ' . $this->dbObj->Param('hashcode') .
						', identity_from = '.$this->dbObj->Param($identity_from).
						', status = \'ToActivate\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($user_id, $this->esc_identity, $this->hashcode, $identity_from));
			    if (!$rs)
		    		trigger_db_error($this->dbObj);

				return $this->dbObj->Insert_ID();
			}

		/**
		 * signupAndLoginHandler::chkIsNotDuplicateIdentity()
		 * To check duplicate identity
		 * @param mixed $table_name
		 * @param mixed $hash
		 * @param mixed $identity_from
		 * @return
		 */
		public function chkIsNotDuplicateIdentity($table_name, $hash,$identity_from='openid')
			{
				$sql = 'SELECT * FROM ' . $table_name .
						' WHERE hashcode = '.$this->dbObj->Param($hash).
						' AND identity_from = '.$this->dbObj->Param($identity_from).
						' AND user_id != 0';
				// prepare query
				$stmt = $this->dbObj->Prepare($sql);
				// execute query
				$rs = $this->dbObj->Execute($stmt, array($hash, $identity_from));
				//raise user error... fatal
				if (!$rs)
						trigger_db_error($this->dbObj);
				// counts number of rows
				$numrows = $rs->PO_RecordCount();
				// finds row exists
				return $numrows;
			}

		/**
		 * LoginFormHandler::updateUserLog()
		 *
		 * To update the login info in users table
		 *
		 * @param 		string $table_name table name
		 * @param 		string $ip ip address
		 * @param 		string $session_id session id
		 * @return 		void
		 * @access 		public
		 */
		public function updateUserLog($table_name, $ip, $session_id)
			{
				$sql = 'UPDATE '.$table_name .
						' SET last_logged=NOW()'.
						', num_visits=num_visits+1, logged_in=\'1\''.
						', last_active=NOW(), ip='.$this->dbObj->Param('ip').
						', session='.$this->dbObj->Param('session').
				 	   	' WHERE user_id='.$this->dbObj->Param('user_id');

                $stmt = $this->dbObj->Prepare($sql);
                $rs = $this->dbObj->Execute($stmt, array($ip, $session_id, $this->user_details_arr['user_id']));
                if (!$rs)
            	    trigger_db_error($this->dbObj);
			}

		/**
		 * LoginFormHandler::saveUserVarsInSession()
		 *
		 * To save the user information in session
		 *
		 * @param 		string $ip ip address
		 * @return 		void
		 * @access 		public
		 */
		public function saveUserVarsInSession($ip)
			{
				if(isset($_SESSION['popup_login_redirect_url']) && $_SESSION['popup_login_redirect_url'])
				{
					$popup_login_redirect_url = $_SESSION['popup_login_redirect_url'];
				}
				$_SESSION = array(); //reset any variables present
				$_SESSION['user']['user_id'] = $this->user_details_arr['user_id'];
				$_SESSION['user']['name'] = getUserDisplayName($this->user_details_arr);
				$_SESSION['user']['user_name'] = $this->user_details_arr['user_name'];
				$_SESSION['user']['time_zone'] = $this->user_details_arr['time_zone'];
				$_SESSION['user']['pref_lang'] = $this->user_details_arr['pref_lang'];
				$_SESSION['user']['pref_template'] = $this->user_details_arr['pref_template'];
				$_SESSION['user']['last_logged'] = $this->user_details_arr['last_logged'];
				$_SESSION['user']['num_visits'] = $this->user_details_arr['num_visits'];
				$_SESSION['user']['group_name'] = $this->user_details_arr['group_name'];
				$_SESSION['user']['email'] = $this->user_details_arr['email'];
				$_SESSION['user']['membership_expiry_date'] = $this->user_details_arr['membership_expiry_date'];
				$_SESSION['user']['is_logged_in'] = true;
				$_SESSION['user']['useragent_hash'] = md5($_SERVER['HTTP_USER_AGENT']);
				$_SESSION['user']['ip'] = $ip;
				$_SESSION['url'] = isset($this->fields_arr['url'])?$this->fields_arr['url']:'';
				$_SESSION['user']['total_videos'] = $this->user_details_arr['total_videos'];
				$_SESSION['user']['total_photos'] = $this->user_details_arr['total_photos'];
				$_SESSION['user']['total_friends'] = $this->user_details_arr['total_friends'];
				$_SESSION['user']['referrer_id'] = $this->user_details_arr['referrer_id'];
				$_SESSION['user']['content_filter'] = $this->user_details_arr['content_filter'];
				$_SESSION['user']['quick_list_clear']=false;
				$_SESSION['user']['quick_history']='';
				$_SESSION['user']['quick_history_set']=true;
				$_SESSION['user']['music_quick_list_clear']=false;
				$_SESSION['user']['music_quick_history']='';
				$_SESSION['user']['openid_type']=$this->user_details_arr['openid_type'];
				$_SESSION['user']['usr_access']=$this->user_details_arr['usr_access'];
				$_SESSION['user']['user_actions']=$this->user_details_arr['user_actions'];

				if(isset($popup_login_redirect_url) && $popup_login_redirect_url)
				{
					$_SESSION['user']['popup_login_redirect_url'] = $popup_login_redirect_url;
				}

				if(isset($this->fields_arr['download_type']))
					{
						$_SESSION['download_type']=$this->fields_arr['download_type'];
					}

				$_SESSION['user']['is_upload_background_image'] = $this->user_details_arr['is_upload_background_image'];
				$_SESSION['user']['is_paid_member'] = $this->user_details_arr['is_paid_member'];

				if(chkAllowedModule(array('content_filter')))
					{
						$_SESSION['user']['adult'] = chkIsAdultUser($this->user_details_arr['dob']);
					}
				else
					{
						$_SESSION['user']['adult'] = true;
					}

				if($this->user_details_arr['usr_access']=='Admin' OR checkUserPermission($this->user_details_arr['user_actions'], 'admin_access') == 'Yes')
					$_SESSION['admin']['is_logged_in'] = true;
			}

		/**
		 * LoginFormHandler::setCookieValue()
		 *
		 * @return void
		 */
		public function setCookieValue()
			{
				if($this->fields_arr['remember'])
					{
						$encodetoken=base64_encode($this->user_details_arr['bba_token']);
						setcookie($this->CFG['cookie']['starting_text'].'_user_name', $this->user_details_arr['user_name'], time()+60*60*24*365, '/');
						setcookie($this->CFG['cookie']['starting_text'].'_token', $encodetoken, time()+60*60*24*365, '/');
					}
				else
					{
						setcookie($this->CFG['cookie']['starting_text'].'_user_name', '', time()+60*60*24*365, '/');
						setcookie($this->CFG['cookie']['starting_text'].'_token', '', time()+60*60*24*365, '/');
					}
			}

		/**
		 * SignupAndLoginHandler::doLogin()
		 *
		 * @return
		 */
		public function doLogin()
			{
				$this->setCookieValue();
				$this->updateUserLog($this->CFG['db']['tbl']['users'],
										$this->CFG['remote_client']['ip'],
										session_id());
				$this->saveUserVarsInSession($this->CFG['remote_client']['ip']);
				$this->resetLoginFailureAttemptCount($this->user_details_arr['user_id']);
				if (isAjaxPage())
					{
						$this->includeAjaxHeader();
						echo '|##|true|##|';
						ob_end_flush();
						die();
					}

				if ($this->chkIsFirstVisit())
				    {
				        Redirect2URL(getUrl('mail', '?folder=inbox', 'inbox/', 'members'));
				    }
				else
					{
						if (isMember() and isset($_SESSION['user']['popup_login_redirect_url']) and $_SESSION['user']['popup_login_redirect_url'])
						{
							$popup_login_redirect_url = $_SESSION['user']['popup_login_redirect_url'];
							$_SESSION['user']['popup_login_redirect_url'] = '';
							Redirect2URL(urldecode($popup_login_redirect_url));
						}
						else
						{
							Redirect2URL(getUrl($this->CFG['auth']['members_url']['file_name'], '', '', 'members'));
						}

					}
			}

		/**
		 * LoginFormHandler::chkIsFirstVisit()
		 *
		 * To Check whether the user's entered at first here..
		 *
		 * @return 		boolean
		 * @access 		public
		 */
		public function chkIsFirstVisit()
			{
				return ($this->user_details_arr['num_visits']==0);
			}

		/**
		 * signupAndLoginHandler::insertFormFieldsInUserTable()
		 *
		 * @param mixed $user_table_name
		 * @param array $fields_to_insert_arr
		 * @return
		 */
		public function insertFormFieldsInUserTable($fields_to_insert_arr=array())
			{
				// field name, parameters and fields value are intialized
				$field_names_separated_by_comma = 'doj, ';
				$parameters_separated_by_comma  = 'NOW(), ';
				$field_values_arr = array();
				// field name, parameters and fields value are set
				$f_count = 0;
				foreach($fields_to_insert_arr as $field_name)
					if (isset($this->fields_arr[$field_name]))
						{
							$con_field_name = $field_name;
							$field_names_separated_by_comma .= $con_field_name.', ';
							$parameters_separated_by_comma .= $this->dbObj->Param($con_field_name).', ';
							$field_values_arr[] = $this->fields_arr[$field_name];
						}
				// eleminates last comma
				$field_names_separated_by_comma = substr($field_names_separated_by_comma, 0, strrpos($field_names_separated_by_comma, ','));
				$parameters_separated_by_comma = substr($parameters_separated_by_comma, 0, strrpos($parameters_separated_by_comma, ','));
				// generates query INSERT INTO users (user_name, email, password, first_name, last_name, phone, fax, address, city, state, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
				 $sql =  'INSERT INTO '.$this->CFG['db']['tbl']['users'].
						' ( '.$field_names_separated_by_comma.') '.
						' VALUES ('.$parameters_separated_by_comma.')';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// executes query
				$result = $this->dbObj->Execute($stmt, $field_values_arr);
				//raise user error... fatal
				if (!$result)
						trigger_db_error($this->dbObj);
				// returns record id
				return $this->dbObj->Insert_ID();
			}

		/**
		 * signupAndLoginHandler::chkIsFaceBookImageUploaded()
		 *
		 * @param mixed $file_name
		 * @param mixed $user_id
		 * @return
		 */
		public function chkIsFaceBookImageUploaded($file_name,  $user_id)
			{
				// $image_name = getImageName($user_id);
				$image_name = $user_id;
				$temp_dir = $this->CFG['site']['project_path'] . $this->CFG['profile']['temp_folder'];
				$this->chkAndCreateFolder($temp_dir);
				$temp_file = $temp_dir . $image_name;
				$output=$temp_file.'.jpg';
				if(!ini_get('allow_url_fopen'))
					return false;

				file_put_contents($output, getContents($file_name));
				$file_name = $output;
				$extern = 'jpg';
				//Initialize width and height of the image
				$this->setFormField('photo_ext', $extern);
				//$temp_file_path = $temp_dir . $image_name.'.'.$extern;
				if(copy($file_name, $temp_file))
					{
						$imageObj = new ImageHandler($temp_file);
						$this->setIHObject($imageObj);
						$this->storeImagesTempServer($temp_file, $extern);
						$dir = $this->CFG['profile']['image_folder'];
						$local_upload = true;

						if ($this->getServerDetails())
							{
								if ($FtpObj = new FtpHandler($this->getFormField('ftp_server'), $this->getFormField('ftp_usrename'), $this->getFormField('ftp_password')))
									{
										$FtpObj->makeDirectory($dir);
										$FtpObj->changeDirectory($dir);
										$FtpObj->moveTo($temp_file . '.' . $extern, $dir . $image_name . '.' . $extern);
										unlink($temp_file . '.' . $extern);
										if ($this->CFG['image_large_name'] == 'L')
											{
												$FtpObj->moveTo($temp_file . 'L.' . $extern, $dir . $image_name . 'L.' . $extern);
												unlink($temp_file . 'L.' . $extern);
											}
										if ($this->CFG['image_thumb_name'] == 'T')
											{
												$FtpObj->moveTo($temp_file . 'T.' . $extern, $dir . $image_name . 'T.' . $extern);
												unlink($temp_file . 'T.' . $extern);
											}
										if ($this->CFG['image_small_name'] == 'S')
											{
												$FtpObj->moveTo($temp_file . 'S.' . $extern, $dir . $image_name . 'S.' . $extern);
												unlink($temp_file . 'S.' . $extern);
											}
										$this->setFormField('server_url', $this->getFormField('server_url'));
										$local_upload = false;
										return;
									}
							}
						if ($local_upload)
							{
								// $dir = $this->CFG['site']['project_path']  . $this->CFG['profile']['image_folder'];
								$dir = $this->CFG['site']['project_path'].$this->CFG['admin']['members_profile']['user_profile_folder'];
								$this->chkAndCreateFolder($dir);
								$uploadUrl = $dir . $image_name;
								if ($this->CFG['image_large_name'] == 'L')
									{
										copy($temp_file . 'L.' . $extern, $uploadUrl . 'L.' . $extern);
										unlink($temp_file . 'L.' . $extern);
									}
								if ($this->CFG['image_thumb_name'] == 'T')
									{
										copy($temp_file . 'T.' . $extern, $uploadUrl . 'T.' . $extern);
										unlink($temp_file . 'T.' . $extern);
									}
								if ($this->CFG['image_small_name'] == 'S')
									{
										copy($temp_file . 'S.' . $extern, $uploadUrl . 'S.' . $extern);
										unlink($temp_file . 'S.' . $extern);
									}
								$this->setFormField('server_url', $this->CFG['site']['url']);
							}

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
								' SET image_ext = '.$this->dbObj->Param($extern).
								' WHERE user_id = '.$this->dbObj->Param($user_id);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($extern, $user_id));
						if (!$rs)
							trigger_db_error($this->dbObj);

						@unlink($image_path);
						return true;
					}
				return false;
			}

		/**
		 * signupAndLoginHandler::updateUsersAgeValue()
		 * Update the user age in user table
		 *
		 * @param  string $table_name
		 * @param  integer $user_id
		 * @return void
		 * @access public
		 */
		public function updateUsersAgeValue($user_id=0)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
						' SET age = DATE_FORMAT(NOW(), \'%Y\') - DATE_FORMAT(dob, \'%Y\') - (DATE_FORMAT(NOW(), \'00-%m-%d\') < DATE_FORMAT(dob, \'00-%m-%d\'))'.
						' WHERE user_id='.$this->dbObj->Param('user_id');

               $stmt = $this->dbObj->Prepare($sql);
               $rs = $this->dbObj->Execute($stmt, array($user_id));
               if (!$rs)
           	    	trigger_db_error($this->dbObj);
			}

		/**
		 * SignupAndLoginHandler::getUserDetails()
		 * To get user details
		 * @param mixed $user_id
		 * @return
		 */
		public function getUserDetails($user_id)
			{
				if($row = getUserDetail('user_id', $user_id))
					{
						return $this->UserDetails[$user_id] = $row;
					}
				return false;
			}

		/**
		 * SignupAndLoginHandler::populateDateYearList()
		 *
		 * @param integer $start_no
		 * @param integer $end_no
		 * @param string $highlight_value
		 * @return
		 */
		public function populateDateYearList($start_no, $end_no, $highlight_value='')
			{
				//echo($start_no.' '.$end_no);
				for($start_no;$start_no<=$end_no;$start_no++)
					{
						$selected = trim($highlight_value) == trim($start_no)?' selected':'';
?>
	<option value="<?php echo $start_no;?>" <?php echo $selected;?>><?php echo $start_no;?></option>
<?php
					}
			}

		/**
		 * AddMemberFormHandler::getAge()
		 *
		 * @param mixed $dob
		 * @return
		 */
		public function getAge($dob)
			{
				$sql = 'SELECT TIMEDIFF(NOW(), \''.$dob.' 00:00:00\') AS date_added';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$date_added_pc = explode(':', $row['date_added']);
						$date_added_pc[0] = intval($date_added_pc[0]);
						$date_added_pc[1] = intval($date_added_pc[1]);
						$date_added_pc[2] = intval($date_added_pc[2]);

						$day = floor($date_added_pc[0]/24);
						$time = 0;
						if($day>365)
							{
								$year = floor($day/365);
								$time = $year;
							}
						return $time;
					}
			}

		/**
		 * SignupAndLoginHandler::increaseFailureLoginAttempt()
		 *
		 * @param mixed $user_id
		 * @return
		 */
		public function increaseFailureLoginAttempt($user_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
						' total_failure_attempt = total_failure_attempt+1, '.
						' last_failure_attempt_date = NOW() '.
						' WHERE user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
					if (!$rs)
						trigger_db_error($this->dbObj);
			}

		/**
		 * SignupAndLoginHandler::chkAllowToRetry()
		 *
		 * @param mixed $date
		 * @return
		 */
		public function chkAllowToRetry($date)
			{
				$sql = 'SELECT IF(DATE_ADD(\''.$date.'\', INTERVAL '.$this->CFG['auth']['session']['retry_duration_after_invalid_tries'].' HOUR)<NOW(), 1, 0) AS allow';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
					if (!$rs)
						trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				return $row['allow'];
			}

		/**
		 * SignupAndLoginHandler::resetLoginFailureAttemptCount()
		 *
		 * @param mixed $user_id
		 * @return
		 */
		public function resetLoginFailureAttemptCount($user_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
						' total_failure_attempt = 0 WHERE'.
						' user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
					if (!$rs)
						trigger_db_error($this->dbObj);
			}

		/**
		 * SignupAndLoginHandler::chkAllowToLogin()
		 *
		 * @param mixed $db_column_name
		 * @param mixed $data
		 * @return
		 */
		public function chkAllowToLogin($db_column_name, $data)
			{
				if(!$this->CFG['auth']['session']['check_invalid_login_tries'])
					{
						return true;
					}
				$user_details = getUserDetail($db_column_name, $data);
				if($this->chkAllowToRetry($user_details['last_failure_attempt_date']))
					{
						$this->resetLoginFailureAttemptCount($user_details['user_id']);
						return true;
					}
				if($user_details['total_failure_attempt']>=$this->CFG['auth']['session']['allowed_num_invalid_tries'])
					{
						return false;
					}
				return true;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getUserTypes()
			{
				$sql = 'SELECT type_id, type_name FROM '.$this->CFG['db']['tbl']['user_type_settings'].
						' WHERE type_status = \'Active\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$user_types = array();
				if ($rs->PO_RecordCount())
					{
						while ($row = $rs->FetchRow())
							{
								$user_types[$row['type_id']] = $row['type_name'];
							}
					}
				return $user_types;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function updateDefaultUserTypeForUser($uid)
			{
				$sql = 'SELECT type_id FROM '.$this->CFG['db']['tbl']['user_type_settings'].
						' WHERE default_type = \'Yes\' LIMIT 0, 1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$usr_type = $row['type_id'];
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
								' SET usr_type = '.$this->dbObj->Param($usr_type).
								' WHERE user_id = '.$this->dbObj->Param($uid);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($usr_type, $uid));
						if (!$rs)
							    trigger_db_error($this->dbObj);
					}
			}
	}
?>