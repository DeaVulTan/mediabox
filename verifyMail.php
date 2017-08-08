<?php
/**
 * File to handle the verify mail page
 *
 * This file is used to check the mail using the password of the user.
 *
 * @category	RAYZZ
 * @package		ROOT
 */
require_once('common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/root/verifyMail.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_GeneralActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_SignupAndLoginHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FriendHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'root';
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class verifyMailHandler begins--------------->>>//
/**
 * verifyMailHandler
 * This class is used to verify user mail ids
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class  verifyMailHandler extends FriendHandler
	{
		/**
		 * verifyMailHandler::setHandlerObject()
		 *
		 * @param object $obj
		 * @return void
		 */
		public function setGeneralActivityHandlerObject($obj='')
			{
				$this->GeneralActivityObj = $obj;
			}

		/**
		 * verifyMailHandler::isNotVerified()
		 * To check the user status
		 *
		 * @return 		boolean
		 */
		public function isNotVerified()
			{
				if(!($user_id = $this->chkIsValidActivationCode($this->getFormField('code'), 'Signup')))
					{
						return false;
					}
				$row = getUserDetail('user_id', $user_id);
				if ($row and ($row['password'] == md5($this->fields_arr['password'].$row['bba_token'])))
					{
						$this->fields_arr['user_name'] = $row['user_name'];
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['email'] = $row['email'];

						//valid code and not verified yet
						if ($row['usr_status'] == 'ToActivate')
							{
								$this->setFormField('user_id', $row['user_id']);
								return true;
				    		}
						//Already activated
						else if ($row['usr_status'] == 'Ok')
					         {
				    	    	$this->setCommonErrorMsg($this->LANG['err_tip_verified']);
								return false;
					         }
						//User account locked
						else if ($row['usr_status'] == 'Locked')
					         {
				    	    	$this->setCommonErrorMsg($this->LANG['err_tip_locked']);
								return false;
					         }
					}
				else
					{
						//invalid code
						$this->setCommonErrorMsg($this->LANG['err_tip_invalid']);
						return false;
					}
			}

		/**
		 * verifyMailHandler::getFriendDetails()
		 * To get the friend details
		 * @return boolean
		 * @access public
		 */
		public function getFriendDetails()
			{
				$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_name='.$this->dbObj->Param('user_name').
						' AND usr_status=\'Ok\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['admin']['default_friend_name']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['user_id'];
				return false;
			}

		/**
		 * verifyMailHandler::addDefaultFriend()
		 * To set the deault friend to admin
		 * @return void
		 * @access public
		 */
		public function addDefaultFriend()
			{
				if($this->CFG['admin']['default_friend_name'] and ($friend_id = $this->getFriendDetails()))
					{
						if(!($friend_id and $this->fields_arr['user_id']))
							return;

						if($this->CFG['admin']['default_friend_mail'])
							{
								$subject = $this->LANG['default_friend_joined_subject'];
								$content = $this->LANG['default_friend_joined_content'];

								$subject = str_replace('VAR_FRIEND_NAME', $this->CFG['admin']['default_friend_name'], $subject);
								$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $subject);
								$subject = str_replace('VAR_USER_NAME', $this->fields_arr['user_name'], $subject);

								$content = str_replace('VAR_FRIEND_NAME', $this->CFG['admin']['default_friend_name'], $content);
								$content = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $content);
								$content = str_replace('VAR_USER_NAME', $this->fields_arr['user_name'], $content);
								$content = nl2br($content);
								$content = html_entity_decode($content);

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['messages'].
										' SET subject = '.$this->dbObj->Param('subject').
										', message ='.$this->dbObj->Param('message').
										', mess_date = NOW()';

						        $stmt = $this->dbObj->Prepare($sql);
						        $rs = $this->dbObj->Execute($stmt, array($subject, $content));
						        if (!$rs)
					                trigger_db_error($this->dbObj);

						        $msg_id = $this->dbObj->Insert_ID();

								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['messages_info'].
										' SET message_id = '.$this->dbObj->Param('message_id').
										', from_id ='.$this->dbObj->Param('from_id').
										', to_id ='.$this->dbObj->Param('to_id');

								$stmt = $this->dbObj->Prepare($sql);
						        $rs = $this->dbObj->Execute($stmt, array($msg_id, $friend_id, $this->fields_arr['user_id']));
						        if (!$rs)
					                trigger_db_error($this->dbObj);

								$update_fields = 'new_mails = new_mails + 1';

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
										' SET '.$update_fields.
										' WHERE user_id= '.$this->dbObj->Param('user_id');

						        $stmt = $this->dbObj->Prepare($sql);
						        $rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
						        if (!$rs)
					                trigger_db_error($this->dbObj);
							}

						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['friends_list'].
								' SET owner_id='.$this->dbObj->Param('owner_id').', friend_id='.$this->dbObj->Param('friend_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($friend_id, $this->fields_arr['user_id']));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['friends_list'].
								' SET owner_id='.$this->dbObj->Param('owner_id').', friend_id='.$this->dbObj->Param('friend_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id'], $friend_id));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						$uids = $friend_id.','.$this->fields_arr['user_id'];

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
								' SET total_friends = total_friends + 1'.
								' WHERE user_id = '.$this->dbObj->Param($friend_id).
								' OR user_id = '.$this->dbObj->Param($this->fields_arr['user_id']);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($friend_id, $this->fields_arr['user_id']));
					    if (!$rs)
						    trigger_db_error($this->dbObj);
					}
			}

		/**
		 * verifyMailHandler::getAdminId()
		 * To get the admin id
		 * @return id
		 * @access public
		 */
		public function getAdminId()
			{
				$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_access=\'Admin\' AND usr_status=\'Ok\' LIMIT 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['user_id'];
				return false;
			}

		/**
		 * verifyMailHandler::addWelcomeMessage()
		 * add welcome message to database
		 * @return void
		 * @access bublic
		 */
		public function addWelcomeMessage()
			{
				if($this->CFG['admin']['welcome_mail'])
					{
						$subject = $this->LANG['welcome_message_subject'];
						$content = $this->LANG['welcome_message_content'];

						$subject = str_replace('VAR_USER_NAME', $this->fields_arr['user_name'], $subject);
						$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $subject);

						$content = str_replace('VAR_USER_NAME', $this->fields_arr['user_name'], $content);
						$content = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $content);

						$content = nl2br($content);
						$content = html_entity_decode($content);

						if(!($admin_id = $this->getAdminId()))
							return;

						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['messages'].
								' SET subject = '.$this->dbObj->Param('subject').
								', message ='.$this->dbObj->Param('message').
								', mess_date = NOW()';

				        $stmt = $this->dbObj->Prepare($sql);
				        $rs = $this->dbObj->Execute($stmt, array($subject, $content));
				        if (!$rs)
			                trigger_db_error($this->dbObj);

				        $msg_id = $this->dbObj->Insert_ID();

						$sql = 'INSERT INTO ' . $this->CFG['db']['tbl']['messages_info'] .
								' SET message_id = '.$this->dbObj->Param('message_id').
								', from_id ='.$this->dbObj->Param('from_id').
								', to_id ='.$this->dbObj->Param('to_id');

						$stmt = $this->dbObj->Prepare($sql);
				        $rs = $this->dbObj->Execute($stmt, array($msg_id, $admin_id, $this->fields_arr['user_id']));
				        if (!$rs)
			                trigger_db_error($this->dbObj);

						$update_fields = 'new_mails = new_mails + 1';

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].
								' SET '.$update_fields.
								' WHERE user_id= '.$this->dbObj->Param('user_id');

				        $stmt = $this->dbObj->Prepare($sql);
				        $rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
				        if (!$rs)
				            trigger_db_error($this->dbObj);
					}
			}

		/**
		 * verifyMailHandler::updateIsVerifiedInUserMailsTable()
		 * Sets verified for user mail in user_emails table
		 *
		 * @param 		int $user_id user id
		 * @param 		string $err_tip err_tip message
		 * @return 		void
		 * @access 		public
		 */
		public function updateIsVerifiedInUserMailsTable($user_id, $err_tip='')
			{
				$sql = 'UPDATE ' . $this->CFG['db']['tbl']['users'] .
						 ' SET usr_status = \'Ok\''.
						 ' WHERE user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$this->addWelcomeMessage();

				if($this->CFG['admin']['add_default_friend'])
					$this->addDefaultFriend();

				//Add Activity
				if($this->CFG['admin']['show_recent_activities'])
					{
						$this->GeneralActivityObj->activity_arr['action_key'] = 'new_member';
						$this->GeneralActivityObj->activity_arr['user_id'] = $user_id;
						$user_details = $this->getUserDetail('user_id', $user_id);
						$this->GeneralActivityObj->activity_arr['user_name'] = $user_details['user_name'];
						$this->GeneralActivityObj->activity_arr['doj'] = $user_details['doj'];
						$this->GeneralActivityObj->addActivity($this->GeneralActivityObj->activity_arr);
					}
				//Insert records to friend_suggestion table
				$this->insertToFriendSuggestionTable($user_id);
				$this->deleteActivationCode('Signup', $this->getFormField('user_id'));
				return true;

			}

		/**
		 * verifyMailHandler::chkIsValidCode()
		 * To check the valide code for the user
		 * @return boolean
		 * @access public
		 */
		public function chkIsValidCode()
			{
				if(!($user_id = $this->chkIsValidActivationCode($this->getFormField('code'), 'Signup')))
					{
						//invalid code
						$this->setAllPageBlocksHide();
						$this->setCommonErrorMsg($this->LANG['err_tip_invalid_link']);
						$this->setPageBlockShow('block_msg_form_error');
						return false;
					}
				if ($row = getUserDetail('user_id', $user_id))
					{
						$this->fields_arr['user_name'] = $row['user_name'];
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['referrer_id'] = $row['referrer_id'];
						$this->fields_arr['email'] = $row['email'];
						$this->fields_arr['openid_used'] = $row['openid_used'];

						//valid code and not verified yet
						if ($row['usr_status'] == 'ToActivate')
							{
								$this->setFormField('user_id', $row['user_id']);
								return true;
				    		}
						//Already activated
						else if ($row['usr_status'] == 'Ok')
					         {
				    	    	$this->setAllPageBlocksHide();
								$this->setCommonErrorMsg($this->LANG['err_tip_verified']);
								$this->setPageBlockShow('block_msg_form_error');
								return false;
					         }
						//User account locked
						else if ($row['usr_status'] == 'Locked')
					         {
				    	    	$this->setAllPageBlocksHide();
								$this->setCommonErrorMsg($this->LANG['err_tip_locked']);
								$this->setPageBlockShow('block_msg_form_error');
								return false;
					         }
					}
			}

		/**
		 * verifyMailHandler::insertToFriendSuggestionTable()
		 *
		 * @param integer $user_id
		 * @return void
		 */
		public function insertToFriendSuggestionTable($user_id)
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['friend_suggestion_log'].
						' SET user_id='.$this->dbObj->Param('user_id').','.
						' date_added = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		public function doActivate()
			{
				$this->updateIsVerifiedInUserMailsTable($this->getFormField('user_id'));
				if(($this->getFormField('referrer_id') and getUserDetail('user_id', $this->getFormField('referrer_id'))) and ($this->getFormField('user_id') and getUserDetail('user_id', $this->getFormField('user_id'))))
					{
						$ownerId = $this->setFormField('owner', $this->getFormField('referrer_id'));
						$friendId = $this->setFormField('friend', $this->getFormField('user_id'));
						$this->setFriendId($this->getFormField('friend'));
						$this->setOwnerId($this->getFormField('owner'));
						$this->addNewFriendDetails();
						$this->sendAcceptedMessage();
					}
				if($this->user_details_arr = getUserDetail('user_id', $this->getFormField('user_id')))
					{
						$this->updateUserLog($this->CFG['db']['tbl']['users'], $this->CFG['remote_client']['ip'],session_id());
						$this->saveUserVarsInSession($this->CFG['remote_client']['ip']);
						if ($this->chkIsFirstVisit())
						    {
						        Redirect2URL(getUrl('mail', '?folder=inbox', 'inbox/', 'members'));
						    }
						else
							{
								Redirect2URL(getUrl($this->CFG['auth']['members_url']['file_name'], '', '', 'members'));
							}
					}
			}
	}
//<<<<<----------------- Class verifyMailHandler ends ------------//
//----------------------- Code begins -------------->>>>>//
$verifyfrm = new verifyMailHandler();
$verifyfrm->setPageBlockNames(array('form_verifymail'));
$verifyfrm->setFormField('code', '');
$verifyfrm->setFormField('password', '');
$verifyfrm->setFormField('user_id', '');
$verifyfrm->setFormField('openid_used', 'No');
$downloadType='';
if(isset($_SESSION['download_url']))
	{
		$_SESSION['url']=$_SESSION['download_url'];
		$downloadType=$_SESSION['download_type'];
	}
$verifyfrm->setFormField('download_type',$downloadType);

if($CFG['admin']['show_recent_activities'])
	{
		$GeneralActivity = new GeneralActivityHandler();
		$verifyfrm->setGeneralActivityHandlerObject($GeneralActivity);
	}

$verifyfrm->setAllPageBlocksHide();
$verifyfrm->setPageBlockShow('form_verifymail');
$verifyfrm->sanitizeFormInputs($_REQUEST);
if ($verifyfrm->isFormGETed($_GET, 'code'))
	{
		if($verifyfrm->chkIsValidCode())
			{
				if($verifyfrm->getFormField('openid_used') != 'No')
					{
						$verifyfrm->doActivate();
					}
				else if(!$CFG['admin']['ask_password_to_activation'])
					{
						$verifyfrm->doActivate();
					}
			}
	}
if ($verifyfrm->isFormPOSTed($_POST, 'password') and $CFG['admin']['ask_password_to_activation'])
	{
		if ($verifyfrm->chkIsNotEmpty('password', $LANG['common_err_tip_compulsory']) and
			($verifyfrm->isNotVerified()))
			{
				$verifyfrm->doActivate();
			}
		else
			{
				$verifyfrm->setAllPageBlocksHide();
				$verifyfrm->setCommonErrorMsg($verifyfrm->LANG['common_msg_error_sorry']);
				$verifyfrm->setPageBlockShow('block_msg_form_error');
				$verifyfrm->setFormField('password', '');
				$verifyfrm->setPageBlockShow('form_verifymail');
			}
	}
//<<<<<------------ Code ends --------------------------//
$verifyfrm->includeHeader();
setTemplateFolder('root/');
$smartyObj->display('verifyMail.tpl');
$verifyfrm->includeFooter();
?>