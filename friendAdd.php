<?php
/**
 * Accept as Friend from Inbox.
 *
 * @category	rayzz
 * @package		MailInboxFormHandler
 **/
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/members/friendAdd.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FriendHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class FriendAcceptor--------------->>>//
/**
 * FriendAcceptor
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class FriendAcceptor extends FriendHandler
	{
		/**
		 * FriendAcceptor::displayFriendsSmallImage()
		 *
		 * @return
		 */
		public function displayFriendsSmallImage()
			{
				$user = $this->getUserDetail('user_id', $this->getFormField('friend'));
				$this->fields_arr['friend_name'] = $user['user_name'];
				return $user;
			}
	}
//<<<<<<<--------------class FriendAcceptor---------------//

//--------------------Code begins-------------->>>>>//
$friend = new FriendAcceptor();
$friend->setPageBlockNames(array('form_confirmation', 'form_member_blocked'));
$friend->setDBObject($db);
$friend->makeGlobalize($CFG, $LANG);
$friend->setFormField('owner', $CFG['user']['user_id']);
$friend->setFormField('friend', 0);
$friend->setFormField('friend_name', '');
$friend->setFormField('backUrl', '');
$friend->setFormField('user_message', '');
$friend->setAllPageBlocksHide();
$friend->sanitizeFormInputs($_REQUEST);

if ($friend->isFormPOSTed($_GET, 'friend'))
	{
		if (!isset($_SERVER['HTTP_REFERER']))
		    {
		        Redirect2URL(getUrl($CFG['auth']['members_url']['file_name']));
		    }
		$friend->setFriendId($friend->getFormField('friend'));
		if ($friend->isFriendIsAMember())
		    {
				if ($friend->chkIsAlreadyFriend())
		    		{
						$_SESSION['friend_request_message'] = str_replace('VAR_USER_NAME', $friend->getFormField('friend_name'), $LANG['addfriend_msg_already_friend']);
						Redirect2URL($_SERVER['HTTP_REFERER']);
				    }
				else if ($friend->isFriendIsMe())
			        {
						$_SESSION['friend_request_message'] = $LANG['addfriend_msg_cant_invite_himeself'];
						Redirect2URL($_SERVER['HTTP_REFERER']);
			        }
				else if ($blocked = $friend->isThisFriendBlocked() and $blocked['uBlocked'])
			    	{
						$friend->setAllPageBlocksHide();
				        $friend->setPageBlockShow('form_member_blocked');
			    	}
				else if ($blocked = $friend->isThisFriendRequested())
		 	    	{
		 				$_SESSION['friend_request_message'] = $LANG['addfriend_msg_already_invited'];
		 		        Redirect2URL($_SERVER['HTTP_REFERER']);
		 	    	}
				else
					{
						$friend->setPageBlockShow('form_confirmation');
						$friend->setFormField('backUrl', urlencode($_SERVER['HTTP_REFERER']));
					}
			}
		else
			{
				$friend->setPageBlockShow('block_msg_form_error');
				$friend->setCommonErrorMsg($LANG['addfriend_msg_invalid_user']);
			}
	}

if ($friend->isFormPOSTed($_POST, 'confirmSubmit'))
    {
		$friend->setFriendId($friend->getFormField('friend'));
		if (!$blocked = $friend->isThisFriendBlocked($friend->getFormField('friend')))
		    {
				$friend->sendFriendRequestMessage($friend->getFormField('user_message'));
			}

		$_SESSION['friend_request_message'] = str_replace('VAR_USER_NAME',$friend->friendDetails['user_name'], $LANG['addfriend_msg_request_sent']);
		$url = $friend->getFormField('backUrl');
		if(strpos($url, 'login'))
			$url = $CFG['site']['url'];
		Redirect2URL(urldecode($url));
    }

if ($friend->isFormPOSTed($_POST, 'cancel'))
    {
     	$friend->sanitizeFormInputs($_POST);
		$url = $friend->getFormField('backUrl');
		if(strpos($url, 'login'))
			$url = $CFG['site']['url'];
		Redirect2URL(urldecode($url));
    }
if ($friend->isShowPageBlock('form_member_blocked'))
	{
		$friend->form_member_blocked['memberProfileUrl'] = getMemberProfileUrl($friend->getFormField('friend'), $friend->getFormField('friend_name'));
		$friend->form_member_blocked['memberblock_url'] = getUrl('memberblock', '?block_id='.$friend->getFormField('friend'), '?block_id='.$friend->getFormField('friend'), 'members');
	}

if ($friend->isShowPageBlock('form_confirmation'))
    {
		$friend->displayFriendsSmallImage();
		$friend->form_confirmation_arr['icon'] = getMemberAvatarDetails($friend->getFormField('friend'));
		$friend->form_confirmation_arr['user_details'] = getUserDetail('user_id', $friend->getFormField('friend'));
    }

$friend->includeHeader();
setTemplateFolder('members/');
$smartyObj->display('friendAdd.tpl');
$friend->includeFooter();
?>