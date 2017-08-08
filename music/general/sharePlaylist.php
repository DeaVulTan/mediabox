<?php
/**
 * File to allow the users to send email to friends about Article
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
 * ShareArticle
 *
 * @category	Rayzz
 * @package		General
 **/
class sharePlaylist extends MusicHandler
	{
		public $EMAIL_ADDRESS;
		//To store block ids
		public $blockArr = array();

		/**
		 * ShareArticle::populateContactLists()
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
		 * ShareArticle::populateCheckBoxForRelation()
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
		 * ShareArticle::populateCheckBoxForFriendsList()
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
								' AND u.usr_status=\'Ok\') WHERE (fl.friend_id='.$this->CFG['user']['user_id'].' OR'.
								' fl.owner_id='.$this->CFG['user']['user_id'].') ORDER BY u.user_name';
					}
				else
					{
						$sql = 'SELECT u.user_name, u.first_name, u.last_name,'.
								' IF (fl.owner_id = '.$this->CFG['user']['user_id'].', fl.friend_id,'.
								' fl.owner_id) AS friend, fl.id as friendship_id FROM '.$this->CFG['db']['tbl']['friends_list'].
								' AS fl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON'.
								' (u.user_id = IF(fl.owner_id='.$this->CFG['user']['user_id'].',fl.friend_id, fl.owner_id)'.
								' AND u.usr_status=\'Ok\') WHERE (fl.friend_id='.$this->CFG['user']['user_id'].' OR'.
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
		 * ShareArticle::chkIsNotEmptyLocal()
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
		 * ShareArticle::chkIsValidEmailLocal()
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
						$err_tip = str_replace('VAR_EMAIL',$value,$this->LANG['shareplaylist_err_tip_invalid_email']);
						$this->setFormFieldErrorTip('email_address', $err_tip);
					}
				return $is_ok;
			}

		/**
		 * ShareArticle::getEmailAddressOfFriend()
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
						' AND u.usr_status=\'Ok\') WHERE (fl.friend_id='.$this->CFG['user']['user_id'].' OR'.
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
								$err_tip = str_replace('VAR_FRIEND',$friend,$this->LANG['shareplaylist_err_tip_username_blocked']);
								$this->common_error_message = $err_tip;
								return false;
							}
						if($value)
							$this->EMAIL_ADDRESS[] = $value;
						return true;
					}
				$err_tip = str_replace('VAR_FRIEND',$friend,$this->LANG['shareplaylist_err_tip_invalid_friend']);
				$this->common_error_message = $err_tip;
				return false;
			}

		/**
		 * ShareArticle::getEmailAddressOfRelation()
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
				$err_tip = str_replace('VAR_RELATION',$value,$this->LANG['shareplaylist_err_tip_invalid_relation']);
				$this->common_error_message = $err_tip;
				return false;
			}

		/**
		 * ShareArticle::getBlockUsers()
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
		 * ShareArticle::chkValidEmailIdRoot()
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
		 * ShareArticle::chkValidEmailId()
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
												$err_tip = str_replace('VAR_RELATION',$value,$this->LANG['sharearticle_err_tip_invalid_relation']);
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
												$err_tip = str_replace('VAR_FRIEND',$value,$this->LANG['sharearticle_err_tip_invalid_friend']);
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
		 * ShareArticle::isBlocked()
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
						$err_tip = str_replace('VAR_FRIEND', $email, $this->LANG['sharearticle_err_tip_username_blocked']);
						$this->common_error_message = $err_tip;
						return true;
				    }
				return false;
			}

		/**
		 * ShareArticle::getsharePlaylistDetails()
		 *
		 * @return boolean
		 */
		public function getsharePlaylistDetails()
			{
				$sql = 'SELECT playlist_name, playlist_description, thumb_music_id, thumb_ext'.
						' FROM '.$this->CFG['db']['tbl']['music_playlist'].
						' WHERE playlist_id='.$this->dbObj->Param('playlist_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->PLAYLIST_NAME = $row['playlist_name'];
						$this->PLAYLIST_DESCRIPTION = strip_tags($row['playlist_description']);
						//$this->PLAYLIST_DESCRIPTION = wordWrap_mb_Manual(strip_tags($row['playlist_description']), $this->CFG['admin']['musics']['member_playlist_description_length'], $this->CFG['admin']['musics']['member_playlist_description_total_length']);
						return true;
					}
				return false;
			}

		/**
		 * ShareArticle::sendEmailToAll()
		 *
		 * @return boolean
		 */
		public function sendEmailToAll()
			{
				$this->EMAIL_ADDRESS = array_unique($this->EMAIL_ADDRESS);
				$is_ok=false;
				if($this->EMAIL_ADDRESS)
					{

						if($this->getSharePlaylistDetails())
							{

								$playlist_forder = '';
								$activity_email = '';
								$recevier_emailids='';

								foreach($this->EMAIL_ADDRESS as $email)
									{
										$mailSent = false;
										$subject = $this->LANG['music_playlist_share_subject'];
										$body = $this->LANG['music_playlist_share_content'];

										$playlist_image = '<img src="'.$this->CFG['site']['url'].'music/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_T.jpg" title="'.$this->PLAYLIST_NAME.'"/> ';
										//Image..
										$playlist_thumbnail_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' . $this->CFG['admin']['musics']['thumbnail_folder'] . '/';
										$playlist_image_array = $this->getPlaylistImageName($this->fields_arr['playlist_id']);// This function return playlist image detail array..//
										if(!empty($playlist_image_array))
											{
												$playlist_path = $playlist_image_array['music_server_url'].$playlist_thumbnail_folder.getMusicImageName($playlist_image_array['music_id']).$this->CFG['admin']['musics']['thumb_name'].'.'.$playlist_image_array['music_thumb_ext'];
												$disp_image = DISP_IMAGE($this->CFG['admin']['musics']['thumb_width'], $this->CFG['admin']['musics']['thumb_height'], $playlist_image_array['thumb_width'], $playlist_image_array['thumb_height']);
												$playlist_image = '<img src="'.$playlist_path.'" '.$disp_image.' title="'.$this->PLAYLIST_NAME.'" />';
											}

										if(isMember())
											{
												$playlistlink = $this->getAffiliateUrl(getUrl('viewplaylist', '?playlist_id='.$this->fields_arr['playlist_id'].'&title='.$this->changeTitle($this->PLAYLIST_NAME), $this->fields_arr['playlist_id'].'/'.$this->changeTitle($this->PLAYLIST_NAME).'/', 'root', 'music'));
												$this->setEmailTemplateValue('user_name', $this->CFG['user']['name']);
												$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
											}
										else
											{
												$playlistlink = $this->getAffiliateUrl(getUrl('viewplaylist', '?playlist_id='.$this->fields_arr['playlist_id'].'&title='.$this->changeTitle($this->PLAYLIST_NAME), $this->fields_arr['playlist_id'].'/'.$this->changeTitle($this->PLAYLIST_NAME).'/', 'root', 'music'));
												$this->setEmailTemplateValue('user_name', $this->fields_arr['first_name']);
												$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
											}
										$this->setEmailTemplateValue('playlist_name', $this->PLAYLIST_NAME);
										$this->setEmailTemplateValue('playlist_image', '<a href="'.$playlistlink.'">'.$playlist_image.'</a>');
										$this->setEmailTemplateValue('music_playlist_description', $this->PLAYLIST_DESCRIPTION);
										$this->setEmailTemplateValue('personal_message', $this->fields_arr['personal_message']);
										$this->setEmailTemplateValue('view_playlist', $playlistlink);
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
											//Srart share playlist activity	..
											$sql = 'SELECT u.user_name, v.user_id, v.playlist_name, v.playlist_id'.
													' FROM '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['music_playlist'].' as v '.
													' WHERE u.user_id = v.user_id AND v.playlist_id = '.$this->dbObj->Param('playlist_id');

											$stmt = $this->dbObj->Prepare($sql);
											$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id']));
											if (!$rs)
												trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

											$row = $rs->FetchRow();
											$activity_arr = $row;
											$activity_arr['action_key']	= 'playlist_share';
											$activity_arr['sender_user_id']	= $this->CFG['user']['user_id'];
											$activity_arr['sender_user_name']	= $this->CFG['user']['user_name'];
											$activity_arr['firend_list']	= 	$recevier_emailids;
											$sharrplaylist_image_array = $this->getPlaylistImageName($this->fields_arr['playlist_id']);
											if(empty($sharrplaylist_image_array))
												{
													$activity_arr['music_id'] = '';
													$activity_arr['music_server_url'] = '';
													$activity_arr['music_thumb_ext'] = '';
												}
											else
												{
													$activity_arr['music_id'] = $sharrplaylist_image_array['music_id'];
													$activity_arr['music_server_url'] = $sharrplaylist_image_array['music_server_url'];
													$activity_arr['music_thumb_ext'] = $sharrplaylist_image_array['music_thumb_ext'];
												}
											$playlistActivityObj = new MusicActivityHandler();
											$playlistActivityObj->addActivity($activity_arr);
											//end
										}

							}
							if($is_ok)
								return true;
						return false;
			               		}
			}



		/**
		 * ShareArticle::setHeaderStart()
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
		 * sharePlaylist::getCaptchaText()
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
		 * sharePlaylist::chkIsValidCaptcha()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkIsValidCaptcha($field_name, $err_tip='')
			{
				$is_ok = (isset($_SESSION['shareplaylist']) and
							($_SESSION['shareplaylist'] == $this->fields_arr[$field_name]));
				if (!$is_ok)
						$this->fields_err_tip_arr[$field_name] = $err_tip;
				return $is_ok;
			}
	}
//<<<<<-------------- Class ShareArticle begins ---------------//
//-------------------- Code begins -------------->>>>>//
if(!($CFG['admin']['musics']['captcha_method'] == 'honeypot' OR $CFG['admin']['musics']['captcha_method'] == 'image'))
	$CFG['admin']['musics']['captcha_method'] = 'honeypot';
$sharePlaylist = new sharePlaylist();
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$sharePlaylist->setPageBlockNames(array('form_success', 'share_playlist_block', 'block_checkbox', 'populate_checkbox_for_relation', 'populate_checkbox_for_friend_list', 'import_contacts'));

//default form fields and values...
$sharePlaylist->setFormField('playlist_id', '');
$sharePlaylist->setFormField('email_address', '');
$sharePlaylist->setFormField('personal_message', '');
$sharePlaylist->setFormField('relation_id', '');
$sharePlaylist->setFormField('friend_id', '');
$sharePlaylist->setFormField('first_name', '');
$sharePlaylist->setFormField('captcha_value', '');
//for ajax
$sharePlaylist->setFormField('ajax_page', '');
$sharePlaylist->setFormField('page', '');

//Default page Block
$sharePlaylist->setAllPageBlocksHide();
$sharePlaylist->sanitizeFormInputs($_REQUEST);

if($sharePlaylist->isFormPOSTed($_POST,'send') || ($sharePlaylist->getFormField('page')=='send' && isAjaxPage()))
	{
		$sharePlaylist->chkIsNotEmptyLocal('email_address') and
			$sharePlaylist->chkValidEmailId('email_address');
		if($CFG['admin']['musics']['captcha'] and $CFG['admin']['musics']['captcha_method']=='image')
			$sharePlaylist->chkIsNotEmpty('captcha_value', $LANG['common_err_tip_required']) and
				$sharePlaylist->chkIsValidCaptcha('captcha_value', $LANG['common_music_playlist_invalid_captcha']);

		if(!isMember())
			{
				$sharePlaylist->chkIsNotEmpty('first_name', $LANG['common_err_tip_required']);
			}
		if($sharePlaylist->isValidFormInputs())
			{
				if(isset($sharePlaylist->EMAIL_ADDRESS) AND $sharePlaylist->EMAIL_ADDRESS)
					{
						if($sharePlaylist->sendEmailToAll())
							{
								$CFG['feature']['auto_hide_success_block'] = false;
								$sharePlaylist->setCommonSuccessMsg($LANG['shareplaylist_success_msg']);
								$sharePlaylist->setAllPageBlocksHide();
								$sharePlaylist->setPageBlockShow('form_success');
								$sharePlaylist->setFormField('email_address', '');
								$sharePlaylist->setFormField('personal_message', '');
								if(!isMember())
									{
										$sharePlaylist->setFormField('first_name', '');
									}
							}
						else
							{
								$sharePlaylist->setAllPageBlocksHide();
								$sharePlaylist->setCommonErrorMsg($LANG['shareplaylist_mail_failure']);
								$sharePlaylist->setPageBlockShow('block_msg_form_error');
							}
					}
				else
					{
							$sharePlaylist->setAllPageBlocksHide();
							$sharePlaylist->setCommonErrorMsg($LANG['shareplaylist_invalid_emailid']);
							$sharePlaylist->setPageBlockShow('block_msg_form_error');
					}
			}
		else
			{
				//$sharePlaylist->setCommonErrorMsg($LANG['shareplaylist_invalid_emailid']);
				$sharePlaylist->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$sharePlaylist->setPageBlockShow('block_msg_form_error');
			}
		$sharePlaylist->setPageBlockShow('share_playlist_block');
	}
if(isAjaxpage())
	{
		$sharePlaylist->includeAjaxHeader();

		if($sharePlaylist->getFormField('page')=='relation')
			{
				$sharePlaylist->includeAjaxHeaderSessionCheck();
				$sharePlaylist->setPageBlockShow('block_checkbox');
				if($sharePlaylist->getFormField('relation_id')==0)
					{
						$sharePlaylist->setPageBlockShow('populate_checkbox_for_relation');
						$sharePlaylist->setPageBlockShow('populate_checkbox_for_friend_list');
						$sharePlaylist->populateCheckBoxForRelation();
						$sharePlaylist->populateCheckBoxForFriendsList();
					}
				else
					{
						$sharePlaylist->setPageBlockShow('populate_checkbox_for_friend_list');
						$sharePlaylist->populateCheckBoxForFriendsList();
					}
			}
		else
			{
				$sharePlaylist->includeAjaxHeaderSessionCheck();
			}
	}

//since while loading via fancy box it is not ajax call
if($sharePlaylist->getFormField('page')=='import')
{
	?>
	<script type="text/javascript" src="<?php echo $CFG['site']['music_url'].'js/sharePlaylist.js';?>"></script>
	<?php
	$sharePlaylist->includeHeader();
	$sharePlaylist->setPageBlockShow('import_contacts');
	$sharePlaylist->populateCheckBoxForRelation();
	$sharePlaylist->populateCheckBoxForFriendsList();
	setTemplateFolder('general/', 'music');
	$smartyObj->display('sharePlaylist.tpl');
	$sharePlaylist->includeFooter();
	exit;
}
if($sharePlaylist->getFormField('page')=='shareplaylist' || $sharePlaylist->getFormField('page')=='music')
	{
		$sharePlaylist->setPageBlockShow('share_playlist_block');
	}

$sharePlaylist->relation_onchange = getUrl('shareplaylist', '?ajax_page=true&amp;page=relation&amp;playlist_id='.$sharePlaylist->getFormField('playlist_id'),  $sharePlaylist->getFormField('playlist_id').'/?ajax_page=true&amp;page=relation', '', 'music');
if ($sharePlaylist->isShowPageBlock('share_playlist_block'))
	{
		$sharePlaylist->share_playlist_block['hidden_arr'] = array('playlist_id');
		$sharePlaylist->populateCheckBoxForRelation();
		$sharePlaylist->populateCheckBoxForFriendsList();
		$sharePlaylist->share_playlist_block['import_contacts_url'] = getUrl('shareplaylist', '?page=import&playlist_id='.$sharePlaylist->getFormField('playlist_id'), $sharePlaylist->getFormField('playlist_id').'/?page=import', '', 'music');

		if($CFG['admin']['musics']['captcha'] and $CFG['admin']['musics']['captcha_method']=='image')
			{
				$sharePlaylist->captcha_url = $CFG['site']['url'].'captchaComment.php?captcha_key=shareplaylist&amp;captcha_value='.$sharePlaylist->getCaptchaText();
				$sharePlaylist->share_playlist_block['send_onclick'] = getUrl('shareplaylist', '?ajax_page=true&amp;page=send&amp;playlist_id='.$sharePlaylist->getFormField('playlist_id'), $sharePlaylist->getFormField('playlist_id').'/?ajax_page=true&amp;page=send', '', 'music');
				//$CFG['site']['url'].'music/members/sharePlaylist.php?ajax_page=true&amp;page=send&amp;playlist_id='.$sharePlaylist->getFormField('playlist_id').'&amp;vpkey='.$sharePlaylist->getFormField('vpkey').'&amp;show='.$sharePlaylist->getFormField('show');
			}
		elseif($CFG['admin']['musics']['captcha'] and $CFG['admin']['musics']['captcha_method']=='honepot')
			{
				$sharePlaylist->share_playlist_block['send_onclick'] = getUrl('shareplaylist', '?ajax_page=true&amp;page=send&amp;playlist_id='.$sharePlaylist->getFormField('playlist_id'), $sharePlaylist->getFormField('playlist_id').'/?ajax_page=true&amp;page=send', '', 'music');
				//$CFG['site']['url'].'music/members/sharePlaylist.php?ajax_page=true&amp;page=send&amp;playlist_id='.$sharePlaylist->getFormField('playlist_id').'&amp;vpkey='.$sharePlaylist->getFormField('vpkey').'&amp;show='.$sharePlaylist->getFormField('show');
			}
		else
			{
				$sharePlaylist->share_playlist_block['send_onclick'] = getUrl('shareplaylist', '?ajax_page=true&amp;page=send&amp;playlist_id='.$sharePlaylist->getFormField('playlist_id'), $sharePlaylist->getFormField('playlist_id').'/?ajax_page=true&amp;page=send', '', 'music');
			}
	}
if(!isAjaxpage())
	{
		$sharePlaylist->includeHeader();
		if($sharePlaylist->getFormField('page')=='music')
		{
		?>
		<script type="text/javascript" src="<?php echo $CFG['site']['music_url'].'js/sharePlaylist.js';?>">
		</script>
		<?php
		}
		setTemplateFolder('general/', 'music');
		$smartyObj->display('sharePlaylist.tpl');
	}
else
	{
		setTemplateFolder('general/', 'music');
		$smartyObj->display('sharePlaylist.tpl');
	}

if(!isAjaxpage())
	{
		$sharePlaylist->includeFooter();
	}
else
	$sharePlaylist->includeAjaxFooter();
?>