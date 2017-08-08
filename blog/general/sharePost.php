<?php
/**
 * File to allow the users to send email to friends about post
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
class SharePost extends BlogHandler
	{
		public $EMAIL_ADDRESS;
		//To store block ids
		public $blockArr = array();

		/**
		 * SharePost::populateContactLists()
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
		 * SharePost::populateCheckBoxForRelation()
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
		 * SharePost::populateCheckBoxForFriendsList()
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
		 * SharePost::chkIsNotEmptyLocal()
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
		 * SharePost::chkIsValidEmailLocal()
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
						$err_tip = str_replace('{email}',$value,$this->LANG['sharepost_err_tip_invalid_email']);
						$this->setFormFieldErrorTip('email_address', $err_tip);
					}
				return $is_ok;
			}

		/**
		 * SharePost::getEmailAddressOfFriend()
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
								$err_tip = str_replace('{friend}',$friend,$this->LANG['sharepost_err_tip_username_blocked']);
								$this->common_error_message = $err_tip;
								return false;
							}
						if($value)
							$this->EMAIL_ADDRESS[] = $value;
						return true;
					}
				$err_tip = str_replace('{friend}',$friend,$this->LANG['sharepost_err_tip_invalid_friend']);
				$this->common_error_message = $err_tip;
				return false;
			}

		/**
		 * SharePost::getEmailAddressOfRelation()
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
				$err_tip = str_replace('{relation}',$value,$this->LANG['sharepost_err_tip_invalid_relation']);
				$this->common_error_message = $err_tip;
				return false;
			}

		/**
		 * SharePost::getBlockUsers()
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
		 * SharePost::chkValidEmailIdRoot()
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
		 * SharePost::chkValidEmailId()
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
		 * SharePost::isBlocked()
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
		 * SharePost::getSharePostDetails()
		 *
		 * @return boolean
		 */
		public function getSharePostDetails()
			{
				$sql = 'SELECT blog_post_name, '.
						' message FROM '.$this->CFG['db']['tbl']['blog_posts'].
						' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->BLOG_POST_NAME = $row['blog_post_name'];
						$this->BLOG_DESCRIPTION = strip_tags($row['message']);
						return true;
					}
				return false;
			}

		/**
		 * SharePost::sendEmailToAll()
		 *
		 * @return boolean
		 */
		public function sendEmailToAllSharePost()
			{
				$this->EMAIL_ADDRESS = array_unique($this->EMAIL_ADDRESS);
				$is_ok=false;
				if($this->EMAIL_ADDRESS)
					{
						if($this->getSharePostDetails())
							{

								$activity_email = '';
								$recevier_emailids='';

								foreach($this->EMAIL_ADDRESS as $email)
									{
										$mailSent = false;
										$subject = $this->LANG['blog_post_share_subject'];
										$subject = str_replace('VAR_USER_NAME', $this->CFG['user']['name'], $subject);
										$body = $this->LANG['blog_post_share_content'];
										if(isMember())
											{
												$postlink = $this->getAffiliateUrl(getUrl('viewpost', '?blog_post_id='.$this->fields_arr['blog_post_id'].'&title='.
																$this->changeTitle($this->BLOG_POST_NAME), $this->fields_arr['blog_post_id'].'/'.
																	$this->changeTitle($this->BLOG_POST_NAME).'/', 'root', 'blog'));
												//$this->setEmailTemplateValue('user_name', $this->CFG['user']['name']);
												//$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
												$body = str_replace('VAR_USER_NAME', $this->CFG['user']['name'], $body);
												$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
											}
										else
											{
												$postlink = $this->getAffiliateUrl(getUrl('viewpost', '?blog_post_id='.$this->fields_arr['blog_post_id'].'&title='.$this->changeTitle($this->BLOG_POST_NAME), $this->fields_arr['blog_post_id'].'/'.$this->changeTitle($this->BLOG_POST_NAME).'/', 'root', 'blog'));
												//$this->setEmailTemplateValue('user_name', $this->fields_arr['first_name']);
												//$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
												$body = str_replace('VAR_USER_NAME', $this->CFG['user']['name'], $body);
												$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
											}

										$body = str_replace('BLOG_POST_NAME', $this->BLOG_POST_NAME, $body);
										$body = str_replace('BLOG_POST_DESCRIPTION', $this->BLOG_DESCRIPTION, $body);
										$body = str_replace('PERSONAL_MESSAGE', $this->fields_arr['personal_message'], $body);
										$body = str_replace('VAR_SITE_URL', $postlink, $body);
										$body = str_replace('VIEW_BLOG_POST', $this->getAffiliateUrl($this->CFG['site']['url']), $body);
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
										//Srart share post activity	..
										$sql = 'SELECT u.user_name, bp.user_id, bp.blog_post_name, bp.blog_post_id'.
												' FROM '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['blog_posts'].' as bp '.
												' WHERE u.user_id = bp.user_id AND bp.blog_post_id = '.$this->dbObj->Param('blog_post_id');

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
										if (!$rs)
											trigger_error($this->dbObj->ErrorNo().' '.
												$this->dbObj->ErrorMsg(), E_USER_ERROR);

										$row = $rs->FetchRow();
										$activity_arr = $row;
										$activity_arr['action_key']	= 'blog_post_share';
										$activity_arr['sender_user_id']	= $this->CFG['user']['user_id'];
										$activity_arr['sender_user_name']	= $this->CFG['user']['user_name'];
										$activity_arr['firend_list']	= 	$recevier_emailids;
										$blogActivityObj = new BlogActivityHandler();
										$blogActivityObj->addActivity($activity_arr);
										//end
									}

							}

						if($is_ok)
							return true;
						return false;
			    	}
			}

		/**
		 * SharePost::setHeaderStart()
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
		 * SharePost::getCaptchaText()
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
		 * SharePost::chkIsValidCaptcha()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkIsValidCaptcha($field_name, $err_tip='')
			{
				$is_ok = (isset($_SESSION['sharepost']) and
							($_SESSION['sharepost'] == $this->fields_arr[$field_name]));
				if (!$is_ok)
						$this->fields_err_tip_arr[$field_name] = $err_tip;
				return $is_ok;
			}
	}
//<<<<<-------------- Class ShareArticle begins ---------------//
//-------------------- Code begins -------------->>>>>//
$sharePost = new SharePost();

if(!chkAllowedModule(array('blog')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$sharePost->setPageBlockNames(array('form_success', 'share_post_block',
									'block_checkbox', 'populate_checkbox_for_relation',
										'populate_checkbox_for_friend_list', 'import_contacts'));

//default form fields and values...
$sharePost->setFormField('blog_post_id', '');
$sharePost->setFormField('email_address', '');
$sharePost->setFormField('personal_message', '');
$sharePost->setFormField('relation_id', '');
$sharePost->setFormField('friend_id', '');
$sharePost->setFormField('first_name', '');
$sharePost->setFormField('captcha_value', '');
//for ajax
$sharePost->setFormField('ajax_page', '');
$sharePost->setFormField('page', '');

//Default page Block
$sharePost->setAllPageBlocksHide();
$sharePost->sanitizeFormInputs($_REQUEST);

if($sharePost->isFormPOSTed($_POST,'send') || ($sharePost->getFormField('page')=='send'))
	{
		$sharePost->chkIsNotEmptyLocal('email_address') and
			$sharePost->chkValidEmailId('email_address');
		if($CFG['admin']['blog']['captcha'] and $CFG['admin']['blog']['captcha_method']=='image')
			$sharePost->chkIsNotEmpty('captcha_value', $LANG['common_err_tip_required']) and
				$sharePost->chkIsValidCaptcha('captcha_value', $LANG['common_blog_invalid_captcha']);

		if(!isMember())
			{
				$sharePost->chkIsNotEmpty('first_name', $LANG['common_err_tip_required']);
			}
		if($sharePost->isValidFormInputs())
			{
				if(isset($sharePost->EMAIL_ADDRESS) AND $sharePost->EMAIL_ADDRESS)
					{
						if($sharePost->sendEmailToAllSharePost())
							{
								$CFG['feature']['auto_hide_success_block'] = false;
								$sharePost->setCommonSuccessMsg($LANG['sharepost_success_msg']);
								$sharePost->setAllPageBlocksHide();
								$sharePost->setPageBlockShow('form_success');
								$sharePost->setFormField('email_address', '');
								$sharePost->setFormField('personal_message', '');
								if(!isMember())
									{
										$sharePost->setFormField('first_name', '');
									}
							}
						else
							{
								$sharePost->setAllPageBlocksHide();
								$sharePost->setCommonErrorMsg($LANG['sharepost_mail_failure']);
								$sharePost->setPageBlockShow('block_msg_form_error');
							}
					}
				else
					{
						$sharePost->setAllPageBlocksHide();
						$sharePost->setCommonErrorMsg($LANG['sharepost_invalid_emailid']);
						$sharePost->setPageBlockShow('block_msg_form_error');
					}
			}
		else
			{
				//$sharePost->setCommonErrorMsg($LANG['sharepost_invalid_emailid']);
				$sharePost->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$sharePost->setPageBlockShow('block_msg_form_error');
			}
		$sharePost->setPageBlockShow('share_post_block');
	}
if($sharePost->getFormField('page'))
	{
		$sharePost->includeAjaxHeader();

		if($sharePost->getFormField('page')=='relation')
			{
				$sharePost->includeAjaxHeaderSessionCheck();
				$sharePost->setPageBlockShow('block_checkbox');
				if($sharePost->getFormField('relation_id')==0)
					{
						$sharePost->setPageBlockShow('populate_checkbox_for_relation');
						$sharePost->setPageBlockShow('populate_checkbox_for_friend_list');
						$sharePost->populateCheckBoxForRelation();
						$sharePost->populateCheckBoxForFriendsList();
					}
				else
					{
						$sharePost->setPageBlockShow('populate_checkbox_for_friend_list');
						$sharePost->populateCheckBoxForFriendsList();
					}
			}
		else
			{
				$sharePost->includeAjaxHeader();
			}
	}
if($sharePost->getFormField('page')=='import')
{
$sharePost->relation_onchange = getUrl('sharepost', '?ajax_page=true&amp;page=relation&amp;blog_post_id='.
									$sharePost->getFormField('blog_post_id'),  $sharePost->getFormField('blog_post_id').
										'/?ajax_page=true&amp;page=relation', '', 'blog');
?>
<script type="text/javascript" src="<?php echo $CFG['site']['blog_url'].'js/sharePost.js';?>"></script>
<?php
	$sharePost->includeAjaxHeader();
	$sharePost->setPageBlockShow('import_contacts');
	$sharePost->populateCheckBoxForRelation();
	$sharePost->populateCheckBoxForFriendsList();
	setTemplateFolder('general/', 'blog');
	$smartyObj->display('sharePost.tpl');
	$sharePost->includeAjaxFooter();
	exit;
}
if($sharePost->getFormField('page')=='sharepost' || $sharePost->getFormField('page')=='blog')
	{
		$sharePost->setPageBlockShow('share_post_block');
	}

$sharePost->relation_onchange = getUrl('sharepost', '?ajax_page=true&amp;page=relation&amp;blog_post_id='.
									$sharePost->getFormField('blog_post_id'),  $sharePost->getFormField('blog_post_id').
										'/?ajax_page=true&amp;page=relation', '', 'blog');

if ($sharePost->isShowPageBlock('share_post_block'))
	{
		$sharePost->share_post_block['hidden_arr'] = array('blog_post_id');
		$sharePost->populateCheckBoxForRelation();
		$sharePost->populateCheckBoxForFriendsList();

		$sharePost->share_post_block['import_contacts_url'] = getUrl('sharepost', '?page=import&blog_post_id='.
																	$sharePost->getFormField('blog_post_id'),
																		$sharePost->getFormField('blog_post_id').'/?page=import', '', 'blog');

		if($CFG['admin']['blog']['captcha'] and $CFG['admin']['blog']['captcha_method']=='image')
			{
				$sharePost->captcha_url = $CFG['site']['url'].'captchaComment.php?captcha_key=sharepost&amp;captcha_value='.$sharePost->getCaptchaText();
				$sharePost->share_post_block['send_onclick'] = getUrl('sharepost', '?ajax_page=true&amp;page=send&amp;blog_post_id='.$sharePost->getFormField('blog_post_id'), $sharePost->getFormField('blog_post_id').'/?ajax_page=true&amp;page=send', '', 'blog');

			}
		elseif($CFG['admin']['blog']['captcha'] and $CFG['admin']['blog']['captcha_method']=='honepot')
			{
				$sharePost->share_post_block['send_onclick'] = getUrl('sharepost', '?ajax_page=true&amp;page=send&amp;blog_post_id='.$sharePost->getFormField('blog_post_id'), $sharePost->getFormField('blog_post_id').'/?ajax_page=true&amp;page=send', '', 'blog');
			}
		else
			{
				$sharePost->share_post_block['send_onclick'] = getUrl('sharepost',
																	'?ajax_page=true&amp;page=send&amp;blog_post_id='.
																		$sharePost->getFormField('blog_post_id'), $sharePost->getFormField('blog_post_id').
																			'/?ajax_page=true&amp;page=send', '', 'blog');
			}

	}
if(!isAjaxpage())
	{
		$sharePost->includeAjaxHeader();
		if($sharePost->getFormField('page') == 'sharepost')
			{
		?>
				<script type="text/javascript" src="<?php echo $CFG['site']['url'].'js/lib/lightwindow/lightwindow.js';?>"></script>
				<script type="text/javascript" src="<?php echo $CFG['site']['blog_url'].'js/sharePost.js';?>">
				</script>
		<?php
			}
		setTemplateFolder('general/', 'blog');
		$smartyObj->display('sharePost.tpl');
	}
else
	{
		setTemplateFolder('general/', 'blog');
		$smartyObj->display('sharePost.tpl');
	}

if(!isAjaxpage())
	{
		$sharePost->includeAjaxFooter();
	}
else
	$sharePost->includeAjaxFooter();
?>