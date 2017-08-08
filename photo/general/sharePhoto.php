<?php
/**
 * File to allow the users to send email to friends about Photo
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
class SharePhoto extends PhotoHandler
	{
		public $EMAIL_ADDRESS;
		//To store block ids
		public $blockArr = array();

		/**
		 * SharePhoto::populateContactLists()
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
		 * SharePhoto::populateCheckBoxForRelation()
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
		 * SharePhoto::populateCheckBoxForFriendsList()
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
		 * SharePhoto::chkIsNotEmptyLocal()
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
		 * SharePhoto::chkIsValidEmailLocal()
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
						$err_tip = str_replace('{email}',$value,$this->LANG['sharephoto_err_tip_invalid_email']);
						$this->setFormFieldErrorTip('email_address', $err_tip);
					}
				return $is_ok;
			}

		/**
		 * SharePhoto::getEmailAddressOfFriend()
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
								$err_tip = str_replace('{friend}',$friend,$this->LANG['sharephoto_err_tip_username_blocked']);
								$this->common_error_message = $err_tip;
								return false;
							}
						if($value)
							$this->EMAIL_ADDRESS[] = $value;
						return true;
					}
				$err_tip = str_replace('{friend}',$friend,$this->LANG['sharephoto_err_tip_invalid_friend']);
				$this->common_error_message = $err_tip;
				return false;
			}

		/**
		 * SharePhoto::getEmailAddressOfRelation()
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
				$err_tip = str_replace('{relation}',$value,$this->LANG['sharephoto_err_tip_invalid_relation']);
				$this->common_error_message = $err_tip;
				return false;
			}

		/**
		 * SharePhoto::getBlockUsers()
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
		 * SharePhoto::chkValidEmailIdRoot()
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
		 * SharePhoto::chkValidEmailId()
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
		 * SharePhoto::isBlocked()
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
		 * SharePhoto::getPhotoDetails()
		 *
		 * @return boolean
		 */
		public function getSharePhotoDetails()
			{
				$sql = 'SELECT photo_server_url, t_width, t_height, photo_title, '.
						' photo_caption, photo_ext FROM '.$this->CFG['db']['tbl']['photo'].
						' WHERE photo_id='.$this->dbObj->Param('photo_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->PHOTO_TITLE = $row['photo_title'];
						$this->PHOTO_DESCRIPTION = strip_tags($row['photo_caption']);
						$this->PHOTO_SERVER_URL = $row['photo_server_url'];
						$this->T_WIDTH = $row['t_width'];
						$this->T_HEIGHT = $row['t_height'];
						$this->PHOTO_TITLE = $row['photo_title'];
						$this->PHOTO_EXT = $row['photo_ext'];
						return true;
					}
				return false;
			}

		/**
		 * SharePhoto::sendEmailToAll()
		 *
		 * @return boolean
		 */
		public function sendEmailToAll()
			{
				$this->EMAIL_ADDRESS = array_unique($this->EMAIL_ADDRESS);
				$is_ok=false;
				if($this->EMAIL_ADDRESS)
					{
						if($this->getSharePhotoDetails())
							{

								$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
								$activity_email = '';
								$recevier_emailids='';

								foreach($this->EMAIL_ADDRESS as $email)
									{
										$mailSent = false;
										$subject = $this->LANG['photo_share_subject'];
										$body = $this->LANG['photo_share_content'];
										$photo_image = '<img src="'.$this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_photo_T.jpg"/> ';
										if($this->PHOTO_EXT != '')
											{
												$photo_image = '<img border="0" src="'.
																	$this->PHOTO_SERVER_URL.$photos_folder.getPhotoName($this->fields_arr['photo_id']).
																		$this->CFG['admin']['photos']['thumb_name'].'.'.$this->PHOTO_EXT.'" alt="'.$this->PHOTO_TITLE.
																			'" title="'.$this->PHOTO_TITLE.'" />';
											}
										if(isMember())
											{
												$photolink = $this->getAffiliateUrl(getUrl('viewphoto', '?photo_id='.$this->fields_arr['photo_id'].'&title='.
																$this->changeTitle($this->PHOTO_TITLE), $this->fields_arr['photo_id'].'/'.
																	$this->changeTitle($this->PHOTO_TITLE).'/', 'root', 'photo'));
												$this->setEmailTemplateValue('user_name', $this->CFG['user']['name']);
												$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
											}
										else
											{
												$photolink = $this->getAffiliateUrl(getUrl('viewphoto', '?photo_id='.$this->fields_arr['photo_id'].'&title='.$this->changeTitle($this->PHOTO_TITLE), $this->fields_arr['photo_id'].'/'.$this->changeTitle($this->PHOTO_TITLE).'/', 'root', 'photo'));
												$this->setEmailTemplateValue('user_name', $this->fields_arr['first_name']);
												$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
											}

										$this->setEmailTemplateValue('photo_title', $this->PHOTO_TITLE);
										$this->setEmailTemplateValue('photo_image', '<a href="'.$photolink.'">'.$photo_image.'</a>');
										$this->setEmailTemplateValue('photo_description', $this->PHOTO_DESCRIPTION);
										$this->setEmailTemplateValue('personal_message', $this->fields_arr['personal_message']);
										$this->setEmailTemplateValue('view_photo', $photolink);
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
										//Srart share photo activity	..
										$sql = 'SELECT u.user_name, p.user_id, p.photo_title, p.photo_id, p.photo_server_url'.
												' FROM '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['photo'].' as p '.
												' WHERE u.user_id = p.user_id AND p.photo_id = '.$this->dbObj->Param('photo_id');

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
										if (!$rs)
											trigger_db_error($this->dbObj);

										$row = $rs->FetchRow();
										$activity_arr = $row;
										$activity_arr['action_key']	= 'photo_share';
										$activity_arr['sender_user_id']	= $this->CFG['user']['user_id'];
										$activity_arr['sender_user_name']	= $this->CFG['user']['user_name'];
										$activity_arr['firend_list']	= 	$recevier_emailids;
										$activity_arr['photo_ext']	= 	$this->PHOTO_EXT;
										$photoActivityObj = new PhotoActivityHandler();
										$photoActivityObj->addActivity($activity_arr);
										//end
									}

							}

						if($is_ok)
							return true;
						return false;
			    	}
			}

		/**
		 * SharePhoto::setHeaderStart()
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
		 * SharePhoto::getCaptchaText()
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
		 * SharePhoto::chkIsValidCaptcha()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkIsValidCaptcha($field_name, $err_tip='')
			{
				$is_ok = (isset($_SESSION['sharephoto']) and
							($_SESSION['sharephoto'] == $this->fields_arr[$field_name]));
				if (!$is_ok)
						$this->fields_err_tip_arr[$field_name] = $err_tip;
				return $is_ok;
			}
	}
//<<<<<-------------- Class ShareArticle begins ---------------//
//-------------------- Code begins -------------->>>>>//
$sharePhoto = new SharePhoto();

if(!chkAllowedModule(array('photo')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$sharePhoto->setPageBlockNames(array('form_success', 'share_photo_block',
									'block_checkbox', 'populate_checkbox_for_relation',
										'populate_checkbox_for_friend_list', 'import_contacts'));

//default form fields and values...
$sharePhoto->setFormField('photo_id', '');
$sharePhoto->setFormField('email_address', '');
$sharePhoto->setFormField('personal_message', '');
$sharePhoto->setFormField('relation_id', '');
$sharePhoto->setFormField('friend_id', '');
$sharePhoto->setFormField('first_name', '');
$sharePhoto->setFormField('captcha_value', '');
//for ajax
$sharePhoto->setFormField('ajax_page', '');
$sharePhoto->setFormField('page', '');

//Default page Block
$sharePhoto->setAllPageBlocksHide();
$sharePhoto->sanitizeFormInputs($_REQUEST);

if($sharePhoto->isFormPOSTed($_POST,'send') || ($sharePhoto->getFormField('page')=='send' && isAjaxPage()))
	{
		$sharePhoto->chkIsNotEmptyLocal('email_address') and
			$sharePhoto->chkValidEmailId('email_address');
		if($CFG['admin']['photos']['captcha'] and $CFG['admin']['photos']['captcha_method']=='image')
			$sharePhoto->chkIsNotEmpty('captcha_value', $LANG['common_err_tip_required']) and
				$sharePhoto->chkIsValidCaptcha('captcha_value', $LANG['common_photo_invalid_captcha']);

		if(!isMember())
			{
				$sharePhoto->chkIsNotEmpty('first_name', $LANG['common_err_tip_required']);
			}
		if($sharePhoto->isValidFormInputs())
			{
				if(isset($sharePhoto->EMAIL_ADDRESS) AND $sharePhoto->EMAIL_ADDRESS)
					{
						if($sharePhoto->sendEmailToAll())
							{
								$CFG['feature']['auto_hide_success_block'] = false;
								$sharePhoto->setCommonSuccessMsg($LANG['sharephoto_success_msg']);
								$sharePhoto->setAllPageBlocksHide();
								$sharePhoto->setPageBlockShow('form_success');
								$sharePhoto->setFormField('email_address', '');
								$sharePhoto->setFormField('personal_message', '');
								if(!isMember())
									{
										$sharePhoto->setFormField('first_name', '');
									}
							}
						else
							{
								$sharePhoto->setAllPageBlocksHide();
								$sharePhoto->setCommonErrorMsg($LANG['sharephoto_mail_failure']);
								$sharePhoto->setPageBlockShow('block_msg_form_error');
							}
					}
				else
					{
						$sharePhoto->setAllPageBlocksHide();
						$sharePhoto->setCommonErrorMsg($LANG['sharephoto_invalid_emailid']);
						$sharePhoto->setPageBlockShow('block_msg_form_error');
					}
			}
		else
			{
				//$sharePhoto->setCommonErrorMsg($LANG['sharephoto_invalid_emailid']);
				$sharePhoto->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$sharePhoto->setPageBlockShow('block_msg_form_error');
			}
		$sharePhoto->setPageBlockShow('share_photo_block');
	}
if(isAjaxpage())
	{
		$sharePhoto->includeAjaxHeader();

		if($sharePhoto->getFormField('page')=='relation')
			{
				$sharePhoto->includeAjaxHeaderSessionCheck();
				$sharePhoto->setPageBlockShow('block_checkbox');
				if($sharePhoto->getFormField('relation_id')==0)
					{
						$sharePhoto->setPageBlockShow('populate_checkbox_for_relation');
						$sharePhoto->setPageBlockShow('populate_checkbox_for_friend_list');
						$sharePhoto->populateCheckBoxForRelation();
						$sharePhoto->populateCheckBoxForFriendsList();
					}
				else
					{
						$sharePhoto->setPageBlockShow('populate_checkbox_for_friend_list');
						$sharePhoto->populateCheckBoxForFriendsList();
					}
			}
		elseif($sharePhoto->getFormField('page')=='import')
			{
				$sharePhoto->includeAjaxHeader();
				$sharePhoto->setPageBlockShow('import_contacts');
				$sharePhoto->populateCheckBoxForRelation();
				$sharePhoto->populateCheckBoxForFriendsList();
			}
		else
			{
				$sharePhoto->includeAjaxHeaderSessionCheck();
			}
	}
if($sharePhoto->getFormField('page')=='sharephoto' || $sharePhoto->getFormField('page')=='photo')
	{
		$sharePhoto->setPageBlockShow('share_photo_block');
	}

$sharePhoto->relation_onchange = getUrl('sharephoto', '?ajax_page=true&amp;page=relation&amp;photo_id='.
									$sharePhoto->getFormField('photo_id'),  $sharePhoto->getFormField('photo_id').
										'/?ajax_page=true&amp;page=relation', '', 'photo');

if ($sharePhoto->isShowPageBlock('share_photo_block'))
	{
		$sharePhoto->share_photo_block['hidden_arr'] = array('photo_id');
		$sharePhoto->populateCheckBoxForRelation();
		$sharePhoto->populateCheckBoxForFriendsList();

		$sharePhoto->share_photo_block['import_contacts_url'] = getUrl('sharephoto', '?ajax_page=true&page=import&photo_id='.
																	$sharePhoto->getFormField('photo_id'),
																		$sharePhoto->getFormField('photo_id').'/?ajax_page=true&page=import', '', 'photo');

		if($CFG['admin']['photos']['captcha'] and $CFG['admin']['photos']['captcha_method']=='image')
			{
				$sharePhoto->captcha_url = $CFG['site']['url'].'captchaComment.php?captcha_key=sharephoto&amp;captcha_value='.$sharePhoto->getCaptchaText();
				$sharePhoto->share_photo_block['send_onclick'] = getUrl('sharephoto', '?ajax_page=true&amp;page=send&amp;photo_id='.$sharePhoto->getFormField('photo_id'), $sharePhoto->getFormField('photo_id').'/?ajax_page=true&amp;page=send', '', 'photo');
				//$CFG['site']['url'].'photo/members/sharePhoto.php?ajax_page=true&amp;page=send&amp;photo_id='.$sharePhoto->getFormField('photo_id').'&amp;vpkey='.$sharePhoto->getFormField('vpkey').'&amp;show='.$sharePhoto->getFormField('show');
			}
		elseif($CFG['admin']['photos']['captcha'] and $CFG['admin']['photos']['captcha_method']=='honepot')
			{
				$sharePhoto->share_photo_block['send_onclick'] = getUrl('sharephoto', '?ajax_page=true&amp;page=send&amp;photo_id='.$sharePhoto->getFormField('photo_id'), $sharePhoto->getFormField('photo_id').'/?ajax_page=true&amp;page=send', '', 'photo');
				//$CFG['site']['url'].'photo/members/sharePhoto.php?ajax_page=true&amp;page=send&amp;photo_id='.$sharePhoto->getFormField('photo_id').'&amp;vpkey='.$sharePhoto->getFormField('vpkey').'&amp;show='.$sharePhoto->getFormField('show');
			}
		else
			{
				$sharePhoto->share_photo_block['send_onclick'] = getUrl('sharephoto',
																	'?ajax_page=true&amp;page=send&amp;photo_id='.
																		$sharePhoto->getFormField('photo_id'), $sharePhoto->getFormField('photo_id').
																			'/?ajax_page=true&amp;page=send', '', 'photo');
			}

	}
if(!isAjaxpage())
	{
		$sharePhoto->includeHeader();
		if($sharePhoto->getFormField('page') == 'photo')
			{
		?>
				<script type="text/javascript" src="<?php echo $CFG['site']['photo_url'].'js/sharePhoto.js';?>">
				</script>
		<?php
			}
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('sharePhoto.tpl');
	}
else
	{
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('sharePhoto.tpl');
	}

if(!isAjaxpage())
	{
		$sharePhoto->includeFooter();
	}
else
	$sharePhoto->includeAjaxFooter();
?>