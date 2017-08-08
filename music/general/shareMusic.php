<?php
/**
 * File to allow the users to send email to friends about Music
 *
 * Provides an interface to get Email Addresses and optional message.
 * If the email address is valid email will be sent to the given
 * email addresses.
 *
 *
 * @category	Rayzz
 * @package		General
 */

/**
 * ShareMusic
 *
 * @category	Rayzz
 * @package		General
 **/
class ShareMusic extends MusicHandler
	{
		public $EMAIL_ADDRESS;
		//To store block ids
		public $blockArr = array();

		/**
		 * ShareMusic::populateContactLists()
		 *
		 * @return void
		 */
		public function populateContactLists()
			{
				$sql = 'SELECT relation_id, relation_name ,total_contacts '.
						' FROM '.$this->CFG['db']['tbl']['friends_relation_name'].
						' where user_id = '.$this->dbObj->Param('user_id').' AND total_contacts>0'.
						' ORDER BY relation_name ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$highlight_value = $this->fields_arr['relation_id'];
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$out = '';
								$selected = $highlight_value == $row['relation_id']?' selected':'';
?>
								<option value="<?php echo $row['relation_id'];?>"<?php echo $selected;?>>
									<?php echo $row['relation_name'].'('.$row['total_contacts'].')';?>
								</option>
<?php
							}
					}
			}

		/**
		 * ShareMusic::populateCheckBoxForRelation()
		 *
		 * @return void
		 */
		public function populateCheckBoxForRelation()
			{
				global $smartyObj;
				$populateCheckBoxForRelation_arr = array();
				$additional_query = '';
				if($this->fields_arr['relation_id'])
					{
						$additional_query = ' AND relation_id=\''.addslashes($this->fields_arr['relation_id']).'\'';
					}
				$sql = 'SELECT relation_id, relation_name ,total_contacts '.
						' FROM '.$this->CFG['db']['tbl']['friends_relation_name'].
						' where user_id = '.$this->dbObj->Param('user_id').' AND'.
						' total_contacts>0'.$additional_query.
						' ORDER BY relation_name ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				//$populateCheckBoxForRelation_arr['row'] = array();
				if($rs->PO_RecordCount())
					{
						$inc = 1;
						while($row = $rs->FetchRow())
							{
								$populateCheckBoxForRelation_arr[$inc]['record'] = $row;
								$inc++;
							}
					}

				$smartyObj->assign('populateCheckBoxForRelation_arr', $populateCheckBoxForRelation_arr);
			}

		/**
		 * ShareMusic::populateCheckBoxForFriendsList()
		 *
		 * @return void
		 */
		public function populateCheckBoxForFriendsList()
			{
				global $smartyObj;
				$populateCheckBoxForFriendsList_arr = array();
				if($this->fields_arr['relation_id'])
					{
						$sql = 'SELECT u.user_name, u.first_name, u.last_name,'.
								' IF (fl.owner_id = '.$this->CFG['user']['user_id'].', fl.friend_id,'.
								' fl.owner_id) AS friend, fl.id as friendship_id FROM '.$this->CFG['db']['tbl']['friends_relation'].' AS fr'.
								' JOIN '.$this->CFG['db']['tbl']['friends_list'].' AS fl ON'.
								' fl.id = fr.friendship_id AND fr.relation_id = '.$this->fields_arr['relation_id'].
								' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON'.
								' (u.user_id = IF(fl.owner_id='.$this->CFG['user']['user_id'].',fl.friend_id, fl.owner_id)'.
								' AND u.usr_status=\'Ok\') WHERE ('.
								' fl.owner_id='.$this->CFG['user']['user_id'].') ORDER BY u.user_name';
					}
				else
					{
						$sql = 'SELECT u.user_name, u.first_name, u.last_name,'.
								' IF (fl.owner_id = '.$this->CFG['user']['user_id'].', fl.friend_id,'.
								' fl.owner_id) AS friend, fl.id as friendship_id FROM '.$this->CFG['db']['tbl']['friends_list'].
								' AS fl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON'.
								' (u.user_id = IF(fl.owner_id='.$this->CFG['user']['user_id'].',fl.friend_id, fl.owner_id)'.
								' AND u.usr_status=\'Ok\') WHERE ('.
								' fl.owner_id='.$this->CFG['user']['user_id'].') ORDER BY u.user_name';
					}

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				//$populateCheckBoxForFriendsList_arr['row'] = array();
				if($rs->PO_RecordCount())
					{
						$inc = 1;
						while($row = $rs->FetchRow())
							{
								$name = $this->CFG['format']['name'];
								$name = str_replace('$first_name', $row['first_name'],$name);
								$name = str_replace('$last_name', $row['last_name'],$name);
								$name = str_replace('$user_name', $row['user_name'],$name);

								$populateCheckBoxForFriendsList_arr[$inc]['record'] = $row;
								$populateCheckBoxForFriendsList_arr[$inc]['name'] = $name;
								$inc++;
							}
					}
				$smartyObj->assign('populateCheckBoxForFriendsList_arr', $populateCheckBoxForFriendsList_arr);
			}

		/**
		 * ShareMusic::chkIsNotEmptyLocal()
		 *
		 * @param string $field_name
		 * @return boolean
		 */
		public function chkIsNotEmptyLocal($field_name)
			{
				$is_ok = (is_string($this->fields_arr[$field_name])) ?
								($this->fields_arr[$field_name]!='') : (!empty($this->fields_arr[$field_name]));

				if (!$is_ok)
					{
						$this->setFormFieldErrorTip($field_name, $this->LANG['common_err_tip_required']);
					}
				return $is_ok;
			}

		/**
		 * ShareMusic::chkIsValidEmailLocal()
		 *
		 * @param string $value
		 * @return boolean
		 */
		public function chkIsValidEmailLocal($value)
			{
			//	$is_ok = (preg_match("/^.+@.+\..+$/i", $this->fields_arr[$field_name]));
				$is_ok = (preg_match("/^\S+@\S+\.\S+$/i", $value));
				if (!$is_ok)
					{
						$err_tip = str_replace('VAR_EMAIL',$value,$this->LANG['sharemusic_err_tip_invalid_email']);
						$this->setFormFieldErrorTip('email_address', $err_tip);
					}
				return $is_ok;
			}

		/**
		 * ShareMusic::getEmailAddressOfFriend()
		 *
		 * @param string $friend
		 * @return boolean
		 */
		public function getEmailAddressOfFriend($friend)
			{
				$sql = 'SELECT u.email, u.user_id, '.
						' IF (fl.owner_id = '.$this->CFG['user']['user_id'].', fl.friend_id,'.
						' fl.owner_id) AS friend, fl.id as friendship_id FROM '.$this->CFG['db']['tbl']['friends_list'].
						' AS fl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON'.
						' (u.user_id = IF(fl.owner_id='.$this->CFG['user']['user_id'].',fl.friend_id, fl.owner_id)'.
						' AND u.usr_status=\'Ok\') WHERE ('.
						' fl.owner_id='.$this->CFG['user']['user_id'].') AND u.user_name=\''.addslashes($friend).'\' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$value = trim($row['email']);
						if (in_array($row['user_id'], $this->blockArr))
							{
								$err_tip = str_replace('VAR_FRIEND',$friend,$this->LANG['sharemusic_err_tip_username_blocked']);
								$this->common_error_message = $err_tip;
								return false;
							}
						if($value)
							$this->EMAIL_ADDRESS[] = $value;
						return true;
					}
				$err_tip = str_replace('VAR_FRIEND',$friend,$this->LANG['sharemusic_err_tip_invalid_friend']);
				$this->common_error_message = $err_tip;
				return false;
			}

		/**
		 * ShareMusic::getEmailAddressOfRelation()
		 *
		 * @param string $value
		 * @return boolean
		 */
		public function getEmailAddressOfRelation($value)
			{
				$sql = 'SELECT relation_id FROM '.$this->CFG['db']['tbl']['friends_relation_name'].
						' WHERE relation_name='.$this->dbObj->Param('relation_name');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($value));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$sql = 'SELECT u.email, u.user_id FROM '.$this->CFG['db']['tbl']['friends_relation'].' AS fr,'.
								' '.$this->CFG['db']['tbl']['friends_list'].' AS fl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u'.
								' ON (u.user_id = IF(fl.owner_id='.$this->CFG['user']['user_id'].',fl.friend_id, fl.owner_id)'.
								' AND u.usr_status=\'Ok\' ) WHERE (fr.relation_id='.$row['relation_id'].' AND fl.id=fr.friendship_id)';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if($rs->PO_RecordCount())
							{
								while($row = $rs->FetchRow())
									{
										$value = trim($row['email']);
										if($value && !in_array($row['user_id'], $this->blockArr))
											$this->EMAIL_ADDRESS[] = $value;
									}
							}
						return true;
					}
				$err_tip = str_replace('VAR_RELATION',$value,$this->LANG['sharemusic_err_tip_invalid_relation']);
				$this->common_error_message = $err_tip;
				return false;
			}

		/**
		 * ShareMusic::getBlockUsers()
		 *
		 * @return boolean
		 */
		public function getBlockUsers()
			{
				$sql = 'SELECT GROUP_CONCAT( user_id )  as user_ids '.
						'FROM '.$this->CFG['db']['tbl']['block_members'].' '.
						'WHERE block_id = '.$this->dbObj->Param('block_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($row = $rs->FetchRow())
					{
						$this->blockArr = explode(',', $row['user_ids']);
				    }
				return true;
			}

		/**
		 * ShareMusic::chkValidEmailIdRoot()
		 *
		 * @param string $field
		 * @return boolean
		 */
		public function chkValidEmailIdRoot($field)
			{
				$email_value = $this->fields_arr[$field];
				//$email_value = str_replace('[','',$email_value);
				$email_arr = explode(',',$this->fields_arr[$field]);
				foreach($email_arr as $value)
					{
						$value = trim($value);
						if($value!=='')
							{
								$value = ' '.$value;
								if($value!=' ')
									{
										if($this->chkIsValidEmailLocal(trim($value)))
											{
												$this->EMAIL_ADDRESS[] = trim($value);
											}
										else
											return false;
									}
							}
					}
				return true;
			}

		/**
		 * ShareMusic::chkValidEmailId()
		 *
		 * @param string $field
		 * @return boolean
		 */
		public function chkValidEmailId($field)
			{
				if(!isMember())
					return $this->chkValidEmailIdRoot($field);

				$email_value = $this->fields_arr[$field];
				//$email_value = str_replace('[','',$email_value);
				$email_arr = explode(',',$this->fields_arr[$field]);
				$this->getBlockUsers();
				foreach($email_arr as $value)
					{
						$value = trim($value);
						if($value!=='')
							{
								$value = ' '.$value;
								if(strpos($value,'[')==1)
									{
										if(strpos($value,']')==strlen($value)-1)
											{
												$value = str_replace('[','',$value);
												$value = str_replace(']','',$value);
												$value = trim($value);
												if(!$this->getEmailAddressOfRelation($value))
													{
														return false;
													}
											}
										else
											{
												$value = str_replace('[','',$value);
												$err_tip = str_replace('VAR_RELATION',$value,$this->LANG['sharemusic_err_tip_invalid_relation']);
												$this->common_error_message = $err_tip;
												return false;
											}
									}
								else if(strpos($value,'(')==1)
									{
										if(strpos($value,')')==strlen($value)-1)
											{
												$value = str_replace('(','',$value);
												$value = str_replace(')','',$value);
												$value = trim($value);
												if(!$this->getEmailAddressOfFriend($value))
													{
														return false;
													}
											}
										else
											{
												$value = str_replace('(','',$value);
												$err_tip = str_replace('VAR_FRIEND',$value,$this->LANG['sharemusic_err_tip_invalid_friend']);
												$this->common_error_message = $err_tip;
												return false;
											}
									}
								else if($value!=' ')
									{
										if($this->chkIsValidEmailLocal(trim($value)) && !$this->isBlocked(trim($value)))
											{
												$this->EMAIL_ADDRESS[] = trim($value);
											}
										else
											return false;
									}
							}
					}
				return true;
			}

		/**
		 * ShareMusic::isBlocked()
		 *
		 * @param string $email
		 * @return boolean
		 */
		public function isBlocked($email)
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['block_non_members'].
				 		' WHERE email = '.$this->dbObj->Param('email').
						' AND ( block_id = '.$this->dbObj->Param('block_id').' OR block_all = \'Yes\' ) LIMIT 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($email, $this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount()>0)
				    {
						$err_tip = str_replace('VAR_FRIEND', $email, $this->LANG['sharemusic_err_tip_username_blocked']);
						$this->common_error_message = $err_tip;
						return true;
				    }
				return false;
			}

		/**
		 * ShareMusic::getMusicDetails()
		 *
		 * @return boolean
		 */
		public function getShareMusicDetails()
			{
				$sql = 'SELECT music_server_url, thumb_width, thumb_height, music_title, '.
						' music_caption, music_thumb_ext FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE music_id='.$this->dbObj->Param('music_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->MUSIC_TITLE = $row['music_title'];
						$this->MUSIC_DESCRIPTION = strip_tags($row['music_caption']);
						$this->MUSIC_SERVER_URL = $row['music_server_url'];
						$this->T_WIDTH = $row['thumb_width'];
						$this->T_HEIGHT = $row['thumb_height'];
						$this->MUSIC_TITLE = $row['music_title'];
						$this->MUSIC_THUMB_EXT = $row['music_thumb_ext'];
						return true;
					}
				return false;
			}

		/**
		 * ShareMusic::sendEmailToAll()
		 *
		 * @return boolean
		 */
		public function sendEmailToAll()
			{
				$this->EMAIL_ADDRESS = array_unique($this->EMAIL_ADDRESS);
				$is_ok=false;
				if($this->EMAIL_ADDRESS)
					{
						if($this->getShareMusicDetails())
							{

								$musics_folder = $this->CFG['media']['folder'].'/'.
													$this->CFG['admin']['musics']['folder'].'/'.
															$this->CFG['admin']['musics']['thumbnail_folder'].'/';
								$activity_email = '';
								$recevier_emailids='';

								foreach($this->EMAIL_ADDRESS as $email)
									{
										$mailSent = false;
										$subject = $this->LANG['music_share_subject'];
										$body = $this->LANG['music_share_content'];
										$music_image = '<img src="'.$this->CFG['site']['url'].'music/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_T.jpg"/> ';
										if($this->MUSIC_THUMB_EXT != '')
											{
												$music_image = '<img border="0" src="'.
																	$this->MUSIC_SERVER_URL.$musics_folder.getMusicImageName($this->fields_arr['music_id']).
																		$this->CFG['admin']['musics']['thumb_name'].'.'.$this->MUSIC_THUMB_EXT.'" alt="'.$this->MUSIC_TITLE.
																			'" title="'.$this->MUSIC_TITLE.'" />';
											}
										if(isMember())
											{
												$musiclink = $this->getAffiliateUrl(getUrl('viewmusic', '?music_id='.$this->fields_arr['music_id'].'&title='.
																$this->changeTitle($this->MUSIC_TITLE), $this->fields_arr['music_id'].'/'.
																	$this->changeTitle($this->MUSIC_TITLE).'/', 'root', 'music'));
												$this->setEmailTemplateValue('user_name', $this->CFG['user']['name']);
												$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
											}
										else
											{
												$musiclink = $this->getAffiliateUrl(getUrl('viewmusic', '?music_id='.$this->fields_arr['music_id'].'&title='.$this->changeTitle($this->MUSIC_TITLE), $this->fields_arr['music_id'].'/'.$this->changeTitle($this->MUSIC_TITLE).'/', 'root', 'music'));
												$this->setEmailTemplateValue('user_name', $this->fields_arr['first_name']);
												$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
											}

										$this->setEmailTemplateValue('music_title', $this->MUSIC_TITLE);
										$this->setEmailTemplateValue('music_image', '<a href="'.$musiclink.'">'.$music_image.'</a>');
										$this->setEmailTemplateValue('music_description', $this->MUSIC_DESCRIPTION);
										$this->setEmailTemplateValue('personal_message', $this->fields_arr['personal_message']);
										$this->setEmailTemplateValue('view_music', $musiclink);
										$this->setEmailTemplateValue('link', $this->getAffiliateUrl($this->CFG['site']['url']));

										if(isMember())
											{
												$this->FromName = $this->CFG['user']['name'];
												$this->From = $this->CFG['user']['email'];
												//Activity mail recevier name and id list..
												$recevier_emailids .= $email.',';
											}
										else
											{
												$this->FromName = $this->fields_arr['first_name'];
												$this->From = $this->CFG['site']['noreply_email'];
											}

										$is_ok=$this->_sendMail($email, $subject, $body, $this->FromName, $this->From);
									}
								if(isMember())
									{
										//Srart share music activity	..
										$sql = 'SELECT u.user_name, m.user_id, m.music_title, m.music_id, m.music_server_url'.
												' FROM '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['music'].' as m '.
												' WHERE u.user_id = m.user_id AND m.music_id = '.$this->dbObj->Param('music_id');

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
										if (!$rs)
											trigger_error($this->dbObj->ErrorNo().' '.
												$this->dbObj->ErrorMsg(), E_USER_ERROR);

										$row = $rs->FetchRow();
										$activity_arr = $row;
										$activity_arr['action_key']	= 'music_share';
										$activity_arr['sender_user_id']	= $this->CFG['user']['user_id'];
										$activity_arr['sender_user_name']	= $this->CFG['user']['user_name'];
										$activity_arr['firend_list']	= 	$recevier_emailids;
										$activity_arr['music_thumb_ext']	= 	$this->MUSIC_THUMB_EXT;
										$musicActivityObj = new MusicActivityHandler();
										$musicActivityObj->addActivity($activity_arr);
										//end
									}

							}

						if($is_ok)
							return true;
						return false;
			    	}
			}

		/**
		 * ShareMusic::setHeaderStart()
		 *
		 * @return void
		 */
		function setHeaderStart()
			{
				global $CFG, $smartyObj;
				$this->assignSmartyVariables();
				ob_start();
				header("Pragma: no-cache");
				header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
				header("Expires: 0"); // Date in the past
				header("Content-type: text/html; charset=\"".$CFG['site']['charset']."\"");
			}

		/**
		 * ShareMusic::getCaptchaText()
		 *
		 * @return string
		 */
		public function getCaptchaText()
			{
				$captcha_length = 5;
				$this->captchaText = rand(pow(10, $captcha_length-1), pow(10, $captcha_length)-1);
				return $this->captchaText;
			}

		/**
		 * ShareMusic::chkIsValidCaptcha()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkIsValidCaptcha($field_name, $err_tip='')
			{
				$is_ok = (isset($_SESSION['sharemusic']) and
							($_SESSION['sharemusic'] == $this->fields_arr[$field_name]));
				if (!$is_ok)
						$this->fields_err_tip_arr[$field_name] = $err_tip;
				return $is_ok;
			}
	}
//<<<<<-------------- Class ShareMusic begins ---------------//
//-------------------- Code begins -------------->>>>>//
if(!($CFG['admin']['musics']['captcha_method'] == 'honeypot' OR $CFG['admin']['musics']['captcha_method'] == 'image'))
	$CFG['admin']['musics']['captcha_method'] = 'honeypot';
$shareMusic = new ShareMusic();

if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$shareMusic->setPageBlockNames(array('form_success', 'share_music_block',
									'block_checkbox', 'populate_checkbox_for_relation',
										'populate_checkbox_for_friend_list', 'import_contacts'));

//default form fields and values...
$shareMusic->setFormField('music_id', '');
$shareMusic->setFormField('email_address', '');
$shareMusic->setFormField('personal_message', '');
$shareMusic->setFormField('relation_id', '');
$shareMusic->setFormField('friend_id', '');
$shareMusic->setFormField('first_name', '');
$shareMusic->setFormField('captcha_value', '');
//for ajax
$shareMusic->setFormField('ajax_page', '');
$shareMusic->setFormField('page', '');

//Default page Block
$shareMusic->setAllPageBlocksHide();
$shareMusic->sanitizeFormInputs($_REQUEST);

if($shareMusic->isFormPOSTed($_POST,'send') || ($shareMusic->getFormField('page')=='send' && isAjaxPage()))
	{
		$shareMusic->chkIsNotEmptyLocal('email_address') and
			$shareMusic->chkValidEmailId('email_address');
		if($CFG['admin']['musics']['captcha'] and $CFG['admin']['musics']['captcha_method']=='image')
			$shareMusic->chkIsNotEmpty('captcha_value', $LANG['common_err_tip_required']) and
				$shareMusic->chkIsValidCaptcha('captcha_value', $LANG['common_music_invalid_captcha']);

		if(!isMember())
			{
				$shareMusic->chkIsNotEmpty('first_name', $LANG['common_err_tip_required']);
			}
		if($shareMusic->isValidFormInputs())
			{
				if(isset($shareMusic->EMAIL_ADDRESS) AND $shareMusic->EMAIL_ADDRESS)
					{
						if($shareMusic->sendEmailToAll())
							{
								$CFG['feature']['auto_hide_success_block'] = false;
								$shareMusic->setCommonSuccessMsg($LANG['sharemusic_success_msg']);
								$shareMusic->setAllPageBlocksHide();
								$shareMusic->setPageBlockShow('form_success');
								$shareMusic->setFormField('email_address', '');
								$shareMusic->setFormField('personal_message', '');
								if(!isMember())
									{
										$shareMusic->setFormField('first_name', '');
									}
							}
						else
							{
								$shareMusic->setAllPageBlocksHide();
								$shareMusic->setCommonErrorMsg($LANG['sharemusic_mail_failure']);
								$shareMusic->setPageBlockShow('block_msg_form_error');
							}
					}
				else
					{
						$shareMusic->setAllPageBlocksHide();
						$shareMusic->setCommonErrorMsg($LANG['sharemusic_invalid_emailid']);
						$shareMusic->setPageBlockShow('block_msg_form_error');
					}
			}
		else
			{
				//$shareMusic->setCommonErrorMsg($LANG['sharemusic_invalid_emailid']);
				$shareMusic->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$shareMusic->setPageBlockShow('block_msg_form_error');
			}
		$shareMusic->setPageBlockShow('share_music_block');
	}
if(isAjaxpage())
	{
		$shareMusic->includeAjaxHeader();

		if($shareMusic->getFormField('page')=='relation')
			{
				$shareMusic->includeAjaxHeaderSessionCheck();
				$shareMusic->setPageBlockShow('block_checkbox');
				if($shareMusic->getFormField('relation_id')==0)
					{
						$shareMusic->setPageBlockShow('populate_checkbox_for_relation');
						$shareMusic->setPageBlockShow('populate_checkbox_for_friend_list');
						$shareMusic->populateCheckBoxForRelation();
						$shareMusic->populateCheckBoxForFriendsList();
					}
				else
					{
						$shareMusic->setPageBlockShow('populate_checkbox_for_friend_list');
						$shareMusic->populateCheckBoxForFriendsList();
					}
			}
		else
			{
				$shareMusic->includeAjaxHeaderSessionCheck();
			}
	}
//since while loading via fancy box it is not ajax call
if($shareMusic->getFormField('page')=='import')
			{
				?>
				<script type="text/javascript" src="<?php echo $CFG['site']['music_url'].'js/shareMusic.js';?>"></script>
				<?php
				$shareMusic->includeHeader();
				$shareMusic->setPageBlockShow('import_contacts');
				$shareMusic->populateCheckBoxForRelation();
				$shareMusic->populateCheckBoxForFriendsList();
				setTemplateFolder('general/', 'music');
				$smartyObj->display('shareMusic.tpl');
				$shareMusic->includeFooter();
				exit;
			}


if($shareMusic->getFormField('page')=='sharemusic' || $shareMusic->getFormField('page')=='music')
	{
		$shareMusic->setPageBlockShow('share_music_block');
	}

$shareMusic->relation_onchange = getUrl('sharemusic', '?ajax_page=true&amp;page=relation&amp;music_id='.
									$shareMusic->getFormField('music_id'),  $shareMusic->getFormField('music_id').
										'/?ajax_page=true&amp;page=relation', '', 'music');

if ($shareMusic->isShowPageBlock('share_music_block'))
	{
		$shareMusic->share_music_block['hidden_arr'] = array('music_id');
		$shareMusic->populateCheckBoxForRelation();
		$shareMusic->populateCheckBoxForFriendsList();

		$shareMusic->share_music_block['import_contacts_url'] = getUrl('sharemusic', '?page=import&music_id='.
																	$shareMusic->getFormField('music_id'),
																		$shareMusic->getFormField('music_id').'/?page=import', '', 'music');

		if($CFG['admin']['musics']['captcha'] and $CFG['admin']['musics']['captcha_method']=='image')
			{
				$shareMusic->captcha_url = $CFG['site']['url'].'captchaComment.php?captcha_key=sharemusic&amp;captcha_value='.$shareMusic->getCaptchaText();
				$shareMusic->share_music_block['send_onclick'] = getUrl('sharemusic', '?ajax_page=true&amp;page=send&amp;music_id='.$shareMusic->getFormField('music_id'), $shareMusic->getFormField('music_id').'/?ajax_page=true&amp;page=send', '', 'music');
				//$CFG['site']['url'].'music/members/shareMusic.php?ajax_page=true&amp;page=send&amp;music_id='.$shareMusic->getFormField('music_id').'&amp;vpkey='.$shareMusic->getFormField('vpkey').'&amp;show='.$shareMusic->getFormField('show');
			}
		elseif($CFG['admin']['musics']['captcha'] and $CFG['admin']['musics']['captcha_method']=='honepot')
			{
				$shareMusic->share_music_block['send_onclick'] = getUrl('sharemusic', '?ajax_page=true&amp;page=send&amp;music_id='.$shareMusic->getFormField('music_id'), $shareMusic->getFormField('music_id').'/?ajax_page=true&amp;page=send', '', 'music');
				//$CFG['site']['url'].'music/members/shareMusic.php?ajax_page=true&amp;page=send&amp;music_id='.$shareMusic->getFormField('music_id').'&amp;vpkey='.$shareMusic->getFormField('vpkey').'&amp;show='.$shareMusic->getFormField('show');
			}
		else
			{
				$shareMusic->share_music_block['send_onclick'] = getUrl('sharemusic',
																	'?ajax_page=true&amp;page=send&amp;music_id='.
																		$shareMusic->getFormField('music_id'), $shareMusic->getFormField('music_id').
																			'/?ajax_page=true&amp;page=send', '', 'music');
			}

	}
if(!isAjaxpage())
	{
		$shareMusic->includeHeader();
		if($shareMusic->getFormField('page') == 'music')
			{
		?>
				<script type="text/javascript" src="<?php echo $CFG['site']['music_url'].'js/shareMusic.js';?>">
				</script>
		<?php
			}
		setTemplateFolder('general/', 'music');
		$smartyObj->display('shareMusic.tpl');
	}
else
	{
		setTemplateFolder('general/', 'music');
		$smartyObj->display('shareMusic.tpl');
	}

if(!isAjaxpage())
	{
		$shareMusic->includeFooter();
	}
else
	$shareMusic->includeAjaxFooter();
?>