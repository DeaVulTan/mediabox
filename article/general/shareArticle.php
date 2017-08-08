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
class ShareArticle extends FormHandler
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
						$err_tip = str_replace('{email}',$value,$this->LANG['sharearticle_err_tip_invalid_email']);
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
								$err_tip = str_replace('{friend}',$friend,$this->LANG['sharearticle_err_tip_username_blocked']);
								$this->common_error_message = $err_tip;
								return false;
							}
						if($value)
							$this->EMAIL_ADDRESS[] = $value;
						return true;
					}
				$err_tip = str_replace('{friend}',$friend,$this->LANG['sharearticle_err_tip_invalid_friend']);
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
				$err_tip = str_replace('{relation}',$value,$this->LANG['sharearticle_err_tip_invalid_relation']);
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
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount()>0)
				    {
						$err_tip = str_replace('{friend}', $email, $this->LANG['sharearticle_err_tip_username_blocked']);
						$this->common_error_message = $err_tip;
						return true;
				    }
				return false;
			}

		/**
		 * ShareArticle::getShareArticleDetails()
		 *
		 * @return boolean
		 */

		public function getShareArticleDetails()
		{
			$sql = 'SELECT article_title, article_caption, article_summary, article_server_url'.
					' FROM '.$this->CFG['db']['tbl']['article'].
					' WHERE article_id='.$this->dbObj->Param('article_id').' LIMIT 0,1';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($row = $rs->FetchRow())
				{
					$this->ARTICLE_TITLE = $row['article_title'];
					$this->ARTICLE_SUMMARY = strip_tags($row['article_summary']);
					$this->ARTICLE_SERVER_URL = $row['article_server_url'];

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
				global $CFG;
				$this->EMAIL_ADDRESS = array_unique($this->EMAIL_ADDRESS);
				$is_ok=false;
				if($this->EMAIL_ADDRESS)
					{
						if($this->getShareArticleDetails())
							{
								$recevier_emailids='';
								foreach($this->EMAIL_ADDRESS as $email)
									{
										$mailSent = false;
										$subject = $this->LANG['article_share_subject'];
										$subject = str_replace('VAR_USER_NAME', $this->CFG['user']['name'], $subject);
										$body = $this->LANG['article_share_content'];
										if(isMember())
											{
												//$articlelink = $this->getAffiliateUrl(getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'], $this->fields_arr['article_id'].'/', 'root', 'article'));
												$articlelink = $this->getAffiliateUrl(getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&title='.
																$this->changeTitle($this->ARTICLE_TITLE), $this->fields_arr['article_id'].'/'.
																	$this->changeTitle($this->ARTICLE_TITLE).'/', 'root', 'article'));
												$body = str_replace('VAR_USER_NAME', $this->CFG['user']['name'], $body);
												$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
											}
										else
											{
												//$articlelink = $this->getAffiliateUrl(getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'], $this->fields_arr['article_id'].'/', 'root', 'article'));
												$articlelink = $this->getAffiliateUrl(getUrl('viewarticle', '?article_id='.$this->fields_arr['article_id'].'&title='.
																$this->changeTitle($this->ARTICLE_TITLE), $this->fields_arr['article_id'].'/'.
																	$this->changeTitle($this->ARTICLE_TITLE).'/', 'root', 'article'));
												$body = str_replace('VAR_USER_NAME', $this->fields_arr['first_name'], $body);
												$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
											}

										$body = str_replace('VAR_ARTICLE_TITLE', $this->ARTICLE_TITLE, $body);
										$body = str_replace('VAR_ARTICLE_SUMMARY', $this->ARTICLE_SUMMARY, $body);
										$body = str_replace('VAR_PERSONAL_MESSAGE', $this->fields_arr['personal_message'], $body);
										$body = str_replace('VAR_VIEW_ARTICLE', $articlelink, $body);
										$body = str_replace('VAR_LINK', $this->getAffiliateUrl($this->CFG['site']['url']), $body);


										if(isMember())
											{

												$userEmail = $this->CFG['user']['email'];
												$userName =  $this->CFG['user']['user_name'];

												$this->From = $userEmail;
												$this->FromName = $userName;

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
										//Start share article activity	..
										$sql = 'SELECT u.user_name, a.user_id, a.article_title, a.article_id, a.article_server_url'.
												' FROM '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['article'].' as a '.
												' WHERE u.user_id = a.user_id AND a.article_id = '.$this->dbObj->Param('article_id');

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
										if (!$rs)
											trigger_error($this->dbObj->ErrorNo().' '.
												$this->dbObj->ErrorMsg(), E_USER_ERROR);

										$row = $rs->FetchRow();
										$activity_arr = $row;
										$activity_arr['action_key']	= 'article_share';
										$activity_arr['sender_user_id']	= $this->CFG['user']['user_id'];
										$activity_arr['sender_user_name']	= $this->CFG['user']['user_name'];
										$activity_arr['firend_list']	= 	$recevier_emailids;
										$articleActivityObj = new ArticleActivityHandler();
										$articleActivityObj->addActivity($activity_arr);
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
		 * ShareArticle::getCaptchaText()
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
		 * ShareArticle::chkIsValidCaptcha()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkIsValidCaptcha($field_name, $err_tip='')
			{
				$is_ok = (isset($_SESSION['sharearticle']) and
							($_SESSION['sharearticle'] == $this->fields_arr[$field_name]));
				if (!$is_ok)
						$this->fields_err_tip_arr[$field_name] = $err_tip;
				return $is_ok;
			}

		/**
		 * ShareArticle::_sendMail()
		 *
		 * @param 		string $to_email to email id
		 * @param 		string $subject subject
		 * @param		string $body mail body
		 * @param 		string $sender_name sender name
		 * @param 		string $sender_email sender email
		 * @return 		void
		 * @access 		private
		 */
		public function _sendMail($to_email, $subject, $body, $sender_name, $sender_email)
			{
			    $this->buildEmailTemplate($subject, $body, false, true);
				$EasySwift = new EasySwift($this->getSwiftConnection());
				$EasySwift->flush();
				//$EasySwift->addCc($CC_ADDRESS);
				$EasySwift->addPart($this->getEmailContent(), "text/html");
				$from_address = $sender_name.'<'.$sender_email.'>';
				return $EasySwift->send($to_email, $from_address, $this->getEmailSubject(),$body);
			}
	}
//<<<<<-------------- Class ShareArticle begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ShareArticle = new ShareArticle();
//die('asdasdasdsad');
if(!chkAllowedModule(array('article')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

	//die('in');

$ShareArticle->setPageBlockNames(array('form_success', 'share_article_block', 'block_checkbox', 'populate_checkbox_for_relation',
									'populate_checkbox_for_friend_list', 'import_contacts'));

//default form fields and values...
$ShareArticle->setFormField('article_id', '');
$ShareArticle->setFormField('email_address', '');
$ShareArticle->setFormField('personal_message', '');
$ShareArticle->setFormField('relation_id', '');
$ShareArticle->setFormField('friend_id', '');
$ShareArticle->setFormField('first_name', '');
$ShareArticle->setFormField('captcha_value', '');
//for ajax
$ShareArticle->setFormField('ajax_page', '');
$ShareArticle->setFormField('page', '');

//Default page Block
$ShareArticle->setAllPageBlocksHide();
$ShareArticle->sanitizeFormInputs($_REQUEST);

if($ShareArticle->isFormPOSTed($_POST,'send') || ($ShareArticle->getFormField('page')=='send' && isAjaxPage()))
	{
		$ShareArticle->chkIsNotEmptyLocal('email_address') and
			$ShareArticle->chkValidEmailId('email_address');
		if($CFG['admin']['articles']['captcha'] and $CFG['admin']['articles']['captcha_method']=='image')
			$ShareArticle->chkIsNotEmpty('captcha_value', $LANG['common_err_tip_required']) and
				$ShareArticle->chkIsValidCaptcha('captcha_value', $LANG['common_err_tip_invalid_captcha']);

		if(!isMember())
			{
				$ShareArticle->chkIsNotEmpty('first_name', $LANG['common_err_tip_required']);
			}
		if($ShareArticle->isValidFormInputs())
			{
				if($ShareArticle->sendEmailToAll())
					{
						$CFG['feature']['auto_hide_success_block'] = false;
						$ShareArticle->setAllPageBlocksHide();
						$ShareArticle->setCommonSuccessMsg($LANG['sharearticle_success_msg']);
						$ShareArticle->setPageBlockShow('form_success');
						$ShareArticle->setFormField('email_address', '');
						$ShareArticle->setFormField('personal_message', '');
						if(!isMember())
							{
								$ShareArticle->setFormField('first_name', '');
							}
					}
				else
					{
						$ShareArticle->setAllPageBlocksHide();
						$ShareArticle->setCommonErrorMsg($LANG['sharearticle_invalid_article_id']);
						$ShareArticle->setPageBlockShow('block_msg_form_error');
					}
			}
		else
			{
				$ShareArticle->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$ShareArticle->setPageBlockShow('block_msg_form_error');
			}
		$ShareArticle->setPageBlockShow('share_article_block');
	}

if(isAjaxpage())
	{
		if($ShareArticle->getFormField('page')=='relation')
			{
				$ShareArticle->includeAjaxHeaderSessionCheck();
				$ShareArticle->setPageBlockShow('block_checkbox');
				if($ShareArticle->getFormField('relation_id')==0)
					{
						$ShareArticle->setPageBlockShow('populate_checkbox_for_relation');
						$ShareArticle->setPageBlockShow('populate_checkbox_for_friend_list');
						$ShareArticle->populateCheckBoxForRelation();
						$ShareArticle->populateCheckBoxForFriendsList();
					}
				else
					{
						$ShareArticle->setPageBlockShow('populate_checkbox_for_friend_list');
						$ShareArticle->populateCheckBoxForFriendsList();
					}
			}
		elseif($ShareArticle->getFormField('page')=='import')
			{
				$ShareArticle->includeAjaxHeader();
				$ShareArticle->setPageBlockShow('import_contacts');
				$ShareArticle->populateCheckBoxForRelation();
				$ShareArticle->populateCheckBoxForFriendsList();
			}
		else
			{
				$ShareArticle->includeAjaxHeaderSessionCheck();
			}


	}
if($ShareArticle->getFormField('page')=='sharearticle' || $ShareArticle->getFormField('page')=='article')
	{
		$ShareArticle->setPageBlockShow('share_article_block');
	}

$ShareArticle->relation_onchange = getUrl('sharearticle', '?ajax_page=true&amp;page=relation&amp;article_id='.$ShareArticle->getFormField('article_id'),  $ShareArticle->getFormField('article_id').'/?ajax_page=true&amp;page=relation', '', 'article');
if ($ShareArticle->isShowPageBlock('share_article_block'))
	{
		$ShareArticle->share_article_block['hidden_arr'] = array('article_id');
		$ShareArticle->populateCheckBoxForRelation();
		$ShareArticle->populateCheckBoxForFriendsList();
		//$ShareArticle->share_article_block['send_onclick'] = getUrl('sharearticle', '?ajax_page=true&amp;page=send&amp;article_id='.$ShareArticle->getFormField('article_id'), $ShareArticle->getFormField('article_id').'/?ajax_page=true&amp;page=send', '', 'article');
		$ShareArticle->share_article_block['import_contacts_url'] = getUrl('sharearticle', '?ajax_page=true&page=import&amp;article_id='.$ShareArticle->getFormField('article_id'), $ShareArticle->getFormField('article_id').'/?ajax_page=true&page=import', '', 'article');

			if($CFG['admin']['articles']['captcha'] and $CFG['admin']['articles']['captcha_method']=='image')
			{
				$ShareArticle->captcha_url = $CFG['site']['url'].'captchaComment.php?captcha_key=sharearticle&amp;captcha_value='.$ShareArticle->getCaptchaText();
				$ShareArticle->share_article_block['send_onclick'] = getUrl('sharearticle', '?ajax_page=true&amp;page=send&amp;article_id='.$ShareArticle->getFormField('article_id'), $ShareArticle->getFormField('article_id').'/?ajax_page=true&amp;page=send', '', 'article');

			}
		elseif($CFG['admin']['articles']['captcha'] and $CFG['admin']['articles']['captcha_method']=='honepot')
			{
				$ShareArticle->share_article_block['send_onclick'] = getUrl('sharearticle', '?ajax_page=true&amp;page=send&amp;article_id='.$ShareArticle->getFormField('article_id'), $ShareArticle->getFormField('article_id').'/?ajax_page=true&amp;page=send', '', 'article');
			}
		else
			{
				$ShareArticle->share_article_block['send_onclick'] = getUrl('sharearticle',
																	'?ajax_page=true&amp;page=send&amp;article_id='.
																		$ShareArticle->getFormField('article_id'), $ShareArticle->getFormField('article_id').
																			'/?ajax_page=true&amp;page=send', '', 'article');
			}

	}
if(!isAjaxpage())
	{
		setPageTitle($LANG['sharearticle_title']);
		setMetaKeywords('Share Article');
		setMetaDescription('Share Article');

		$ShareArticle->includeHeader();
			if($ShareArticle->getFormField('page') == 'article')
			{
		?>
				<script type="text/javascript" src="<?php echo $CFG['site']['article_url'].'js/shareArticle.js';?>">
				</script>
		<?php
			}
		setTemplateFolder('general/', 'article');
		$smartyObj->display('shareArticle.tpl');
	}
else
	{
		setTemplateFolder('general/', 'article');
		$smartyObj->display('shareArticle.tpl');
	}
?>
		<script type="text/javascript" language="javascript">
			var replace_url = '<?php echo getUrl('login');?>';
		</script>
<?php
if(!isAjaxpage())
	{
		$ShareArticle->includeFooter();
	}
else
	$ShareArticle->includeAjaxFooter();
?>