<?php
/**
 * To manage embed contents
 *
 * PHP version 5.0
 *
 * @category	Discuzz
 * @package		UserDetailHandler
 * @author 		senthil_52ag05
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2008-12-19
 */

//-------------- Class UserDetailHandler begins --------------->>>>>//
class UserDetailHandler extends FormHandler
	{

		/**
		 * to display embed content
		 *
		 * @return 		string
		 * @access 		public
		 */
		public function displayUserDetails()
			{
				$uid = $this->fields_arr['uid'];
				if ($userDetails = $this->chkIsValidUser($uid))
					{
						$displayUserDetails_arr = array();
						$uid 		= $userDetails['user_id'];
						$uname 		= $userDetails['name'];
						$display_uname 		= $userDetails['display_name'];
						$discussionHandler = new DiscussionHandler();
						$userLog	= $discussionHandler->getUserLog($uid);
						$displayUserDetails_arr['userLevelClass'] = '';
						if($this->CFG['admin']['user_levels']['allowed'])
							$displayUserDetails_arr['userLevelClass'] = getUserLevelClass($userLog['total_points']);

						$displayUserDetails_arr['user_mysolutions_url'] = getMemberUrl($uid, $uname);
						$displayUserDetails_arr['user_display_uname'] = $display_uname;
						$displayUserDetails_arr['user_compose_url'] = getUrl('mailcompose', '?mcomp='.$uname, '?mcomp='.$uname, 'members');
						$displayUserDetails_arr['user_boards_ans_url'] = getUrl('boards', '?view=search&amp;uname='.$uname.'&amp;opt=sol', 'search/?uname='.$uname.'&amp;opt=sol', '', $this->CFG['admin']['index']['home_module']);
						$displayUserDetails_arr['userLog_total_points'] = $userLog['total_points'];
						$displayUserDetails_arr['userLog_total_solution'] = $userLog['total_solution'];

						if($this->CFG['admin']['best_solutions']['allowed'])
							{
								$displayUserDetails_arr['bestAnspercentage'] = 0;
								if($userLog['total_solution'])
									$displayUserDetails_arr['bestAnspercentage'] = round(($userLog['total_best_solution']/$userLog['total_solution'])*100);
							}

						$displayUserDetails_arr['user_boards_bestans_url'] = getUrl('boards', '?view=search&amp;uname='.$uname.'&amp;opt=bestsol', 'search/?uname='.$uname.'&amp;opt=bestsol', '', $this->CFG['admin']['index']['home_module']);
						$displayUserDetails_arr['user_boards_ques_url'] = getUrl('boards', '?view=search&amp;uname='.$uname.'&amp;opt=board', 'search/?uname='.$uname.'&amp;opt=board', '', $this->CFG['admin']['index']['home_module']);
						$displayUserDetails_arr['userLog_total_board'] = $userLog['total_board'];

						return $displayUserDetails_arr;
					}
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function chkIsValidUser($uid)
		    {
				if (!$uid)
					return false;

				$sql = 'SELECT '.getUserTableFields(array('user_id', 'name', 'display_name', 'email', 'user_status', 'user_access', 'doj')).
						', u.'.getUserTableField('user_id').' AS img_user_id'.
						' FROM '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE u.'.getUserTableField('user_id').'='.$this->dbObj->Param($uid).
						' AND u.'.getUserTableField('user_status').'=\'Ok\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($uid));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					{
						return false;
					}
				$req_arr = array('img_path', 'm_height', 'm_width', 't_height', 't_width', 's_height', 's_width', 'photo_server_url', 'photo_ext', 'gender', 'bio', 'online_hours');
				$user_arr = $rs->FetchRow();
				//getting user info..
				$user_info_details_arr = getUserInfoDetails($req_arr, 'user_id', $user_arr['img_user_id']);
				$row = array_merge($user_arr, $user_info_details_arr);

				return $row;
		    }

	}
//----------------------------- Code begins ------------------>>>>>//
$userdetails = new UserDetailHandler();

$userdetails->setFormField('uid', '');

$userdetails->sanitizeFormInputs($_REQUEST);
if ($userdetails->isFormGETed($_REQUEST, 'uid'))
	{
		$userdetails->userdetails_arr = $userdetails->displayUserDetails();
	}
//<<<<<------------------------- Code ends ----------------------------------//
$userdetails->includeAjaxHeader();
//include the content of the page
setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
//<<<<<<--------------------Page block templates Ends--------------------//
//include the footer of the page
$smartyObj->display('userDetails.tpl');
$userdetails->includeAjaxFooter();
?>