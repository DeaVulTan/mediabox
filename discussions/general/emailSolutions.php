<?php
/**
 * File to allow the users to send email to friends about Discussion
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
class EmailSolutions extends DiscussionHandler
	{
		public $EMAIL_ADDRESS;
		//To store block ids
		public $blockArr = array();

		/**
		 * EmailSolutions::populateContactLists()
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
		 * EmailSolutions::populateCheckBoxForRelation()
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
		 * EmailSolutions::populateCheckBoxForFriendsList()
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
		 * EmailSolutions::chkIsNotEmptyLocal()
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
		 * EmailSolutions::chkIsValidEmailLocal()
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
						$err_tip = str_replace('{email}',$value,$this->LANG['emailsolutions_err_tip_invalid_email']);
						$this->setFormFieldErrorTip('email_address', $err_tip);
					}
				return $is_ok;
			}

		/**
		 * EmailSolutions::getEmailAddressOfFriend()
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
								$err_tip = str_replace('{friend}',$friend,$this->LANG['emailsolutions_err_tip_username_blocked']);
								$this->common_error_message = $err_tip;
								return false;
							}
						if($value)
							$this->EMAIL_ADDRESS[] = $value;
						return true;
					}
				$err_tip = str_replace('{friend}',$friend,$this->LANG['emailsolutions_err_tip_invalid_friend']);
				$this->common_error_message = $err_tip;
				return false;
			}

		/**
		 * EmailSolutions::getEmailAddressOfRelation()
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
				$err_tip = str_replace('{relation}',$value,$this->LANG['emailsolutions_err_tip_invalid_relation']);
				$this->common_error_message = $err_tip;
				return false;
			}

		/**
		 * EmailSolutions::getBlockUsers()
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
		 * EmailSolutions::chkValidEmailIdRoot()
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
		 * EmailSolutions::chkValidEmailId()
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
		 * EmailSolutions::isBlocked()
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
		 * EmailSolutions::getPhotoDetails()
		 *
		 * @return boolean
		 */
		/*public function getEmailSolutionsDetails()
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
			}*/

		/**
		 * Check is valid board id
		 *
		 * @param 		string $board_table table name
		 * @param 		integer $port_id
		 * @param 		string $err_msg
		 * @return 		boolean
		 * @access 		public
		 */
		public function getShareBoardDetails($err_msg = '')
			{
				if (!$this->fields_arr['title'])
					{
						$this->setCommonErrorMsg($err_msg);
						return false;
					}
				$sql = 'SELECT q.board_id, q.total_solutions, q.best_solution_id, q.description, q.total_stars, q.board, TIMEDIFF(NOW(), board_added) as board_added'.
						', '.getUserTableField('display_name').' as asked_by, '.getUserTableField('name').' as name, q.status, q.user_id, q.seo_title'.
						' FROM '.$this->CFG['db']['tbl']['boards'].' AS q, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE q.user_id=u.'.getUserTableField('user_id').' AND q.status IN (\'Active\')'.
						' AND u.'.getUserTableField('user_status').'=\'Ok\' AND q.seo_title='.$this->dbObj->Param('title');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['title']));
				if (!$rs)
						trigger_db_error($this->dbObj);
				// counts number of rows
				$numrows = $rs->PO_RecordCount();
				// finds row exists
				if ($numrows > 0 )
					{
						$this->board_details = $rs->FetchRow();
						$this->fields_arr['qid'] = $this->board_details['board_id'];
						$this->BOARD_TITLE = $this->getFormField('title');
						$this->BOARD_MANUAL = wordWrapManual($this->board_details['board'], $this->CFG['admin']['board']['line_length'], $this->CFG['admin']['board']['total_length']);
						$this->BOARD_MANUAL_Stripped = stripString($this->board_details['board'], 75);
						return true;
					}
				$this->setCommonErrorMsg($err_msg);
				return false;
			}

		/**
		 * EmailSolutions::sendEmailToAll()
		 *
		 * @return boolean
		 */
		public function sendEmailToAll()
			{
				$this->EMAIL_ADDRESS = array_unique($this->EMAIL_ADDRESS);
				$is_ok=false;

				if($this->EMAIL_ADDRESS)
					{
						if($this->getShareBoardDetails())
							{
								$activity_email = '';
								$recevier_emailids='';

								foreach($this->EMAIL_ADDRESS as $email)
									{
										$mailSent = false;
										//$subject = $this->LANG['photo_share_subject'];
										//$body = $this->LANG['photo_share_content'];

										$subject = $this->getMailContent($this->LANG['send_board_to_friend_subject'], array('VAR_BOARD'=>$this->board_details['board'], 'VAR_SITENAME'=>$this->CFG['site']['name'], 'VAR_SENDER_NAME'=>$this->CFG['user']['name'], 'VAR_DESCRIPTION_OF_QUESTION'=>$this->board_details['description']));
			     						$body = $this->getMailContent($this->LANG['send_board_to_friend_content'], array('VAR_BOARD'=>'<strong><a href="'.getUrl('solutions', '?title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'root', $this->CFG['admin']['index']['home_module']).'">'.$this->board_details['board'].'</a></strong>', 'VAR_SITENAME'=>$this->CFG['site']['name'], 'VAR_SENDER_NAME'=>$this->CFG['user']['name'], 'VAR_DESCRIPTION_OF_QUESTION'=>$this->board_details['description'],'VAR_PERSONAL_MESSAGE'=>$this->fields_arr['personal_message']));

										if(isMember())
											{
												$this->setEmailTemplateValue('user_name', $this->CFG['user']['name']);
												$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
											}
										else
											{
												$this->setEmailTemplateValue('user_name', $this->fields_arr['first_name']);
												$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
											}

										$this->setEmailTemplateValue('board_title', $this->BOARD_TITLE);
										$this->setEmailTemplateValue('board_description', $this->BOARD_MANUAL);
										$this->setEmailTemplateValue('personal_message', $this->fields_arr['personal_message']);
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

										$activity_arr = $this->board_details;
										$activity_arr['action_key']	= 'board_share';
										$activity_arr['sender_user_id']	= $this->CFG['user']['user_id'];
										$activity_arr['sender_user_name']	= $this->CFG['user']['user_name'];
										$activity_arr['firend_list']	= 	$recevier_emailids;
										//$photoActivityObj = new PhotoActivityHandler();
										//$photoActivityObj->addActivity($activity_arr);
										//end
									}

							}

						if($is_ok)
							return true;
						return false;
			    	}
			}

		/**
		 * EmailSolutions::setHeaderStart()
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
		 * EmailSolutions::getCaptchaText()
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
		 * EmailSolutions::chkIsValidCaptcha()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkIsValidCaptcha($field_name, $err_tip='')
			{
				$is_ok = (isset($_SESSION['EmailSolutions']) and
							($_SESSION['EmailSolutions'] == $this->fields_arr[$field_name]));
				if (!$is_ok)
						$this->fields_err_tip_arr[$field_name] = $err_tip;
				return $is_ok;
			}
	}
//<<<<<-------------- Class ShareArticle begins ---------------//
//-------------------- Code begins -------------->>>>>//
$emailsolutionsfrm = new EmailSolutions();

if(!chkAllowedModule(array('discussions')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$emailsolutionsfrm->setPageBlockNames(array('form_success', 'share_board_block',
									'block_checkbox', 'populate_checkbox_for_relation',
										'populate_checkbox_for_friend_list', 'import_contacts'));

//default form fields and values...
$emailsolutionsfrm->setFormField('board_id', '');
$emailsolutionsfrm->setFormField('title', '');
$emailsolutionsfrm->setFormField('email_address', '');
$emailsolutionsfrm->setFormField('personal_message', '');
$emailsolutionsfrm->setFormField('relation_id', '');
$emailsolutionsfrm->setFormField('friend_id', '');
$emailsolutionsfrm->setFormField('first_name', '');
$emailsolutionsfrm->setFormField('captcha_value', '');
//for ajax
$emailsolutionsfrm->setFormField('ajax_page', '');
$emailsolutionsfrm->setFormField('page', '');

//Default page Block
$emailsolutionsfrm->setAllPageBlocksHide();
$emailsolutionsfrm->sanitizeFormInputs($_REQUEST);

if($emailsolutionsfrm->isFormPOSTed($_POST,'send') || ($emailsolutionsfrm->getFormField('page')=='send' && isAjaxPage()))
	{
		$emailsolutionsfrm->chkIsNotEmptyLocal('email_address') and
			$emailsolutionsfrm->chkValidEmailId('email_address');

		if(!isMember())
			{
				$emailsolutionsfrm->chkIsNotEmpty('first_name', $LANG['common_err_tip_required']);
			}
		if($emailsolutionsfrm->isValidFormInputs())
			{
				if(isset($emailsolutionsfrm->EMAIL_ADDRESS) AND $emailsolutionsfrm->EMAIL_ADDRESS)
					{
						if($emailsolutionsfrm->sendEmailToAll())
							{
								$CFG['feature']['auto_hide_success_block'] = false;
								$emailsolutionsfrm->setCommonSuccessMsg($LANG['emailsolutions_success_msg']);
								$emailsolutionsfrm->setAllPageBlocksHide();
								$emailsolutionsfrm->setPageBlockShow('form_success');
								$emailsolutionsfrm->setFormField('email_address', '');
								$emailsolutionsfrm->setFormField('personal_message', '');
								if(!isMember())
									{
										$emailsolutionsfrm->setFormField('first_name', '');
									}
							}
						else
							{
								$emailsolutionsfrm->setAllPageBlocksHide();
								$emailsolutionsfrm->setCommonErrorMsg($LANG['emailsolutions_mail_failure']);
								$emailsolutionsfrm->setPageBlockShow('block_msg_form_error');
							}
					}
				else
					{
						$emailsolutionsfrm->setAllPageBlocksHide();
						$emailsolutionsfrm->setCommonErrorMsg($LANG['emailsolutions_invalid_emailid']);
						$emailsolutionsfrm->setPageBlockShow('block_msg_form_error');
					}
			}
		else
			{
				//$emailsolutionsfrm->setCommonErrorMsg($LANG['emailsolutions_invalid_emailid']);
				$emailsolutionsfrm->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$emailsolutionsfrm->setPageBlockShow('block_msg_form_error');
			}
		$emailsolutionsfrm->setPageBlockShow('share_board_block');
	}
if(isAjaxpage())
	{

		$emailsolutionsfrm->includeAjaxHeader();

		if($emailsolutionsfrm->getFormField('page')=='relation')
			{
				$emailsolutionsfrm->includeAjaxHeaderSessionCheck();
				$emailsolutionsfrm->setPageBlockShow('block_checkbox');
				if($emailsolutionsfrm->getFormField('relation_id')==0)
					{
						$emailsolutionsfrm->setPageBlockShow('populate_checkbox_for_relation');
						$emailsolutionsfrm->setPageBlockShow('populate_checkbox_for_friend_list');
						$emailsolutionsfrm->populateCheckBoxForRelation();
						$emailsolutionsfrm->populateCheckBoxForFriendsList();
					}
				else
					{
						$emailsolutionsfrm->setPageBlockShow('populate_checkbox_for_friend_list');
						$emailsolutionsfrm->populateCheckBoxForFriendsList();
					}
			}
		elseif($emailsolutionsfrm->getFormField('page')=='import')
			{
				$emailsolutionsfrm->includeAjaxHeader();
				$emailsolutionsfrm->setPageBlockShow('import_contacts');
				$emailsolutionsfrm->populateCheckBoxForRelation();
				$emailsolutionsfrm->populateCheckBoxForFriendsList();
			}
		else
			{
				$emailsolutionsfrm->includeAjaxHeaderSessionCheck();
			}
	}
if($emailsolutionsfrm->getFormField('page')=='shareboards' || $emailsolutionsfrm->getFormField('page')=='discussions')
	{
		$emailsolutionsfrm->setPageBlockShow('share_board_block');
	}

$emailsolutionsfrm->relation_onchange = getUrl('emailsolutions', '?ajax_page=true&page=relation&title='.$emailsolutionsfrm->getFormField('title'), $emailsolutionsfrm->getFormField('title').'/?ajax_page=true&amp;page=relation', '', $CFG['admin']['index']['home_module']);

if ($emailsolutionsfrm->isShowPageBlock('share_board_block'))
	{
		$emailsolutionsfrm->share_board_block['hidden_arr'] = array('title');
		$emailsolutionsfrm->populateCheckBoxForRelation();
		$emailsolutionsfrm->populateCheckBoxForFriendsList();

		$emailsolutionsfrm->share_board_block['import_contacts_url'] = getUrl('emailsolutions', '?ajax_page=true&page=import&title='.$emailsolutionsfrm->getFormField('title'), $emailsolutionsfrm->getFormField('title').'/?ajax_page=true&page=import', '', $CFG['admin']['index']['home_module']);


		$emailsolutionsfrm->share_board_block['send_onclick'] = getUrl('emailsolutions', '?ajax_page=true&page=send&title='.$emailsolutionsfrm->getFormField('title'), $emailsolutionsfrm->getFormField('title').'/?ajax_page=true&page=send', '', $CFG['admin']['index']['home_module']);

	}
if(!isAjaxpage())
	{
		$emailsolutionsfrm->includeHeader();
		if($emailsolutionsfrm->getFormField('page')=='shareboards' || $emailsolutionsfrm->getFormField('page') == 'discussions')
			{
		?>
				<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'].$CFG['admin']['index']['home_module'];?>/js/shareDiscussions.js"></script>
		<?php
			}
	setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
	$smartyObj->display('emailSolutions.tpl');
	}
else
	{
	setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
	$smartyObj->display('emailSolutions.tpl');
	}

if(!isAjaxpage())
	{
		$emailsolutionsfrm->includeFooter();
	}
else
	$emailsolutionsfrm->includeAjaxFooter();
?>