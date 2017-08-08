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
class ShareVideo extends VideoHandler
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
				   trigger_db_error($this->dbObj);

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
					    trigger_db_error($this->dbObj);

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
				    trigger_db_error($this->dbObj);

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
						$err_tip = str_replace('{email}',$value,$this->LANG['sharevideo_err_tip_invalid_email']);
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
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$value = trim($row['email']);
						if (in_array($row['user_id'], $this->blockArr))
							{
								$err_tip = str_replace('{friend}',$friend,$this->LANG['sharevideo_err_tip_username_blocked']);
								$this->common_error_message = $err_tip;
								return false;
							}
						if($value)
							$this->EMAIL_ADDRESS[] = $value;
						return true;
					}
				$err_tip = str_replace('{friend}',$friend,$this->LANG['sharevideo_err_tip_invalid_friend']);
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
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$sql = 'SELECT u.email, u.user_id FROM '.$this->CFG['db']['tbl']['friends_relation'].' AS fr,'.
								' '.$this->CFG['db']['tbl']['friends_list'].' AS fl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u'.
								' ON (u.user_id = IF(fl.owner_id='.$this->CFG['user']['user_id'].',fl.friend_id, fl.owner_id)'.
								' AND u.usr_status=\'Ok\' ) WHERE (fr.relation_id='.$row['relation_id'].' AND fl.id=fr.friendship_id)';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_db_error($this->dbObj);

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
				$err_tip = str_replace('{relation}',$value,$this->LANG['sharevideo_err_tip_invalid_relation']);
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
					    trigger_db_error($this->dbObj);

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
												$err_tip = str_replace('{relation}',$value,$this->LANG['sharearticle_err_tip_invalid_relation']);
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
												$err_tip = str_replace('{friend}',$value,$this->LANG['sharearticle_err_tip_invalid_friend']);
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
					   trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount()>0)
				    {
						$err_tip = str_replace('{friend}', $email, $this->LANG['sharearticle_err_tip_username_blocked']);
						$this->common_error_message = $err_tip;
						return true;
				    }
				return false;
			}

		/**
		 * ShareArticle::getArticleDetails()
		 *
		 * @return boolean
		 */
		public function getShareVideoDetails()
			{
				$sql = 'SELECT video_server_url, t_width, t_height, video_title, video_caption'.
						' FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_id='.$this->dbObj->Param('video_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->VIDEO_TITLE = $row['video_title'];
						$this->VIDEO_DESCRIPTION = wordWrap_mb_Manual(strip_tags($row['video_caption']), $this->CFG['admin']['videos']['caption_length_share_video'], $this->CFG['admin']['videos']['description_total_char_share_video']);
						$this->VIDEO_SERVER_URL = $row['video_server_url'];
						$this->T_WIDTH = $row['t_width'];
						$this->T_HEIGHT = $row['t_height'];
						$this->VIDEO_TITLE = $row['video_title'];


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

						if($this->getShareVideoDetails())
							{

								$videos_folder =$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
								$activity_email = '';
								$recevier_emailids='';

								foreach($this->EMAIL_ADDRESS as $email)
									{
										$mailSent = false;
										$subject = $this->LANG['video_share_subject'];
										$body = $this->LANG['video_share_content'];
										$subject = str_replace('VAR_USER_NAME', $this->CFG['user']['name'], $subject);
										$video_image = '<img border="0" src="'.$this->VIDEO_SERVER_URL.$videos_folder.getVideoImageName($this->fields_arr['video_id']).$this->CFG['admin']['videos']['thumb_name'].'.'.$this->CFG['video']['image']['extensions'].'" alt="'.$this->VIDEO_TITLE.'" title="'.$this->VIDEO_TITLE.'" />';
										if(isMember())
											{
												$videolink = $this->getAffiliateUrl(getUrl('viewvideo', '?video_id='.$this->fields_arr['video_id'].'&video_title='.$this->VIDEO_TITLE, $this->fields_arr['video_id'].'/'.$this->VIDEO_TITLE.'/', 'root', 'video'));
												//$this->setEmailTemplateValue('user_name', $this->CFG['user']['name']);
												//$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
												$body = str_replace('VAR_USER_NAME', $this->CFG['user']['name'], $body);
												$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
											}
										else
											{
												$videolink = $this->getAffiliateUrl(getUrl('viewvideo', '?video_id='.$this->fields_arr['video_id'].'&video_title='.$this->VIDEO_TITLE, $this->fields_arr['video_id'].'/'.$this->VIDEO_TITLE.'/', 'root', 'video'));
												//$this->setEmailTemplateValue('user_name', $this->fields_arr['first_name']);
												//$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
												$body = str_replace('VAR_USER_NAME', $this->CFG['user']['name'], $body);
												$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
											}
										$body = str_replace('VAR_VIDEO_TITLE', $this->VIDEO_TITLE, $body);
										$body = str_replace('VAR_VIDEO_IMAGE', '<a href="'.$videolink.'">'.$video_image.'</a>', $body);
										$body = str_replace('VAR_VIDEO_DESCRIPTION', $this->VIDEO_DESCRIPTION, $body);
										$body = str_replace('VAR_PERSONAL_MESSAGE', $this->fields_arr['personal_message'], $body);
										$body = str_replace('VAR_SITE_URL', $videolink, $body);
										$body = str_replace('VAR_LINK', $this->getAffiliateUrl($this->CFG['site']['url']), $body);
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
											//Srart share Video activity	..
											$sql = 'SELECT u.user_name, v.user_id, v.video_title, v.video_id, v.video_server_url, v.is_external_embed_video, v.embed_video_image_ext '.
													' FROM '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['video'].' as v '.
													' WHERE u.user_id = v.user_id AND v.video_id = '.$this->dbObj->Param('video_id');

											$stmt = $this->dbObj->Prepare($sql);
											$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
											if (!$rs)
												trigger_db_error($this->dbObj);

											$row = $rs->FetchRow();
											$activity_arr = $row;
											$activity_arr['action_key']	= 'video_share';
											$activity_arr['sender_user_id']	= $this->CFG['user']['user_id'];
											$activity_arr['sender_user_name']	= $this->CFG['user']['user_name'];
											$activity_arr['firend_list']	= 	$recevier_emailids;
											$videoActivityObj = new VideoActivityHandler();
											$videoActivityObj->addActivity($activity_arr);
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
		 * ShareVideo::getCaptchaText()
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
		 * ShareVideo::chkIsValidCaptcha()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkIsValidCaptcha($field_name, $err_tip='')
			{
				$is_ok = (isset($_SESSION['sharevideo']) and
							($_SESSION['sharevideo'] == $this->fields_arr[$field_name]));
				if (!$is_ok)
						$this->fields_err_tip_arr[$field_name] = $err_tip;
				return $is_ok;
			}
	}
//<<<<<-------------- Class ShareArticle begins ---------------//
//-------------------- Code begins -------------->>>>>//
$shareVideo = new ShareVideo();
if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$shareVideo->setPageBlockNames(array('form_success', 'share_video_block', 'block_checkbox', 'populate_checkbox_for_relation', 'populate_checkbox_for_friend_list', 'import_contacts'));

//default form fields and values...
$shareVideo->setFormField('video_id', '');
$shareVideo->setFormField('email_address', '');
$shareVideo->setFormField('personal_message', '');
$shareVideo->setFormField('relation_id', '');
$shareVideo->setFormField('friend_id', '');
$shareVideo->setFormField('first_name', '');
$shareVideo->setFormField('captcha_value', '');
//for ajax
$shareVideo->setFormField('ajax_page', '');
$shareVideo->setFormField('page', '');

//Default page Block
$shareVideo->setAllPageBlocksHide();
$shareVideo->sanitizeFormInputs($_REQUEST);

if($shareVideo->isFormPOSTed($_POST,'send') || ($shareVideo->getFormField('page')=='send' && isAjaxPage()))
	{
		$shareVideo->chkIsNotEmptyLocal('email_address') and
			$shareVideo->chkValidEmailId('email_address');
		if($CFG['admin']['videos']['share_captcha'] and $CFG['admin']['videos']['share_captcha_method']=='image')
			$shareVideo->chkIsNotEmpty('captcha_value', $LANG['common_err_tip_required']) and
				$shareVideo->chkIsValidCaptcha('captcha_value', $LANG['common_video_invalid_captcha']);

		if(!isMember())
			{
				$shareVideo->chkIsNotEmpty('first_name', $LANG['common_err_tip_required']);
			}
		if($shareVideo->isValidFormInputs())
			{
				if(isset($shareVideo->EMAIL_ADDRESS) AND $shareVideo->EMAIL_ADDRESS)
					{
						if($shareVideo->sendEmailToAll())
							{
								$CFG['feature']['auto_hide_success_block'] = false;
								$shareVideo->setCommonSuccessMsg($LANG['sharevideo_success_msg']);
								$shareVideo->setAllPageBlocksHide();
								$shareVideo->setPageBlockShow('form_success');
								$shareVideo->setFormField('email_address', '');
								$shareVideo->setFormField('personal_message', '');
								if(!isMember())
									{
										$shareVideo->setFormField('first_name', '');
									}
							}
						else
							{
								$shareVideo->setAllPageBlocksHide();
								$shareVideo->setCommonErrorMsg($LANG['sharevideo_mail_failure']);
								$shareVideo->setPageBlockShow('block_msg_form_error');
							}
					}
				else
					{
							$shareVideo->setAllPageBlocksHide();
							$shareVideo->setCommonErrorMsg($LANG['sharevideo_invalid_emailid']);
							$shareVideo->setPageBlockShow('block_msg_form_error');
					}
			}
		else
			{
				//$shareVideo->setCommonErrorMsg($LANG['sharevideo_invalid_emailid']);
				$shareVideo->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$shareVideo->setPageBlockShow('block_msg_form_error');
			}
		$shareVideo->setPageBlockShow('share_video_block');
	}
if(isAjaxpage())
	{
		$shareVideo->includeAjaxHeader();

		if($shareVideo->getFormField('page')=='relation')
			{
				$shareVideo->includeAjaxHeaderSessionCheck();
				$shareVideo->setPageBlockShow('block_checkbox');
				if($shareVideo->getFormField('relation_id')==0)
					{
						$shareVideo->setPageBlockShow('populate_checkbox_for_relation');
						$shareVideo->setPageBlockShow('populate_checkbox_for_friend_list');
						$shareVideo->populateCheckBoxForRelation();
						$shareVideo->populateCheckBoxForFriendsList();
					}
				else
					{
						$shareVideo->setPageBlockShow('populate_checkbox_for_friend_list');
						$shareVideo->populateCheckBoxForFriendsList();
					}
			}
		else
			{
				$shareVideo->includeAjaxHeaderSessionCheck();
			}
	}
if($shareVideo->getFormField('page')=='import')
			{
			?>
			<script type="text/javascript" src="<?php echo $CFG['site']['video_url'].'js/shareVideo.js';?>"></script>
				<?php
				$shareVideo->includeHeader();
				$shareVideo->setPageBlockShow('import_contacts');
				$shareVideo->populateCheckBoxForRelation();
				$shareVideo->populateCheckBoxForFriendsList();
				setTemplateFolder('general/', 'video');
				$smartyObj->display('shareVideo.tpl');
				$shareVideo->includeFooter();
				exit;
			}
if($shareVideo->getFormField('page')=='sharevideo' || $shareVideo->getFormField('page')=='video')
	{
		$shareVideo->setPageBlockShow('share_video_block');
	}

$shareVideo->relation_onchange = getUrl('sharevideo', '?ajax_page=true&amp;page=relation&amp;video_id='.$shareVideo->getFormField('video_id'),  $shareVideo->getFormField('video_id').'/?ajax_page=true&amp;page=relation', '', 'video');
if ($shareVideo->isShowPageBlock('share_video_block'))
	{
		$shareVideo->share_video_block['hidden_arr'] = array('video_id');
		$shareVideo->populateCheckBoxForRelation();
		$shareVideo->populateCheckBoxForFriendsList();

		$shareVideo->share_video_block['import_contacts_url'] = getUrl('sharevideo', '?page=import&video_id='.$shareVideo->getFormField('video_id'), $shareVideo->getFormField('video_id').'/?page=import', '', 'video');

		if($CFG['admin']['videos']['share_captcha'] and $CFG['admin']['videos']['share_captcha_method']=='image')
			{
				$shareVideo->captcha_url = $CFG['site']['url'].'captchaComment.php?captcha_key=sharevideo&amp;captcha_value='.$shareVideo->getCaptchaText();
				$shareVideo->share_video_block['send_onclick'] = getUrl('sharevideo', '?ajax_page=true&amp;page=send&amp;video_id='.$shareVideo->getFormField('video_id'), $shareVideo->getFormField('video_id').'/?ajax_page=true&amp;page=send', '', 'video');
				//$CFG['site']['url'].'video/members/shareVideo.php?ajax_page=true&amp;page=send&amp;video_id='.$shareVideo->getFormField('video_id').'&amp;vpkey='.$shareVideo->getFormField('vpkey').'&amp;show='.$shareVideo->getFormField('show');
			}
		elseif($CFG['admin']['videos']['share_captcha'] and $CFG['admin']['videos']['share_captcha_method']=='honepot')
			{
				$shareVideo->share_video_block['send_onclick'] = getUrl('sharevideo', '?ajax_page=true&amp;page=send&amp;video_id='.$shareVideo->getFormField('video_id'), $shareVideo->getFormField('video_id').'/?ajax_page=true&amp;page=send', '', 'video');
				//$CFG['site']['url'].'video/members/shareVideo.php?ajax_page=true&amp;page=send&amp;video_id='.$shareVideo->getFormField('video_id').'&amp;vpkey='.$shareVideo->getFormField('vpkey').'&amp;show='.$shareVideo->getFormField('show');
			}
		else
			{
				$shareVideo->share_video_block['send_onclick'] = getUrl('sharevideo', '?ajax_page=true&amp;page=send&amp;video_id='.$shareVideo->getFormField('video_id'), $shareVideo->getFormField('video_id').'/?ajax_page=true&amp;page=send', '', 'video');
			}

	}
if(!isAjaxpage())
	{
		$shareVideo->includeHeader();
		if($shareVideo->getFormField('page')=='video')
		{
		?>
		<script type="text/javascript" src="<?php echo $CFG['site']['video_url'].'js/shareVideo.js';?>">
		</script>
		<?php
		}
		setTemplateFolder('general/', 'video');
		$smartyObj->display('shareVideo.tpl');
	}
else
	{
		setTemplateFolder('general/', 'video');
		$smartyObj->display('shareVideo.tpl');
	}

if(!isAjaxpage())
	{
		$shareVideo->includeFooter();
	}
else
	$shareVideo->includeAjaxFooter();
?>