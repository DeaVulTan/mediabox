<?php
/**
 * HeaderFormHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class HeaderFormHandler extends HeaderHandler
	{
		//To store the mail count
		public $newMail = 0;

		private $userDetails = array();

		private $currentStatus = 'Online';

		/**
		 * HeaderFormHandler::isLogin()
		 *
		 * @return
		 */
		public function isLogin()
			{
				if(isset($_SESSION['user']['user_id']) and $_SESSION['user']['user_id'])
					return true;
				return false;
			}

		/**
		 * To get the New mail Count
		 *
		 * @param string $users_table
		 * @param integer $user_id
		 * @access public
		 * @return void
		 **/
		public function storeUserDetails()
			{
				if($row = $this->getUserDetail('user_id', $this->CFG['user']['user_id']))
					{
						$this->newMail = $row['new_mails'];
						$this->userDetails['total_videos'] = $row['total_videos'];
						$this->userDetails['total_friends'] = $this->getTotalFriendsCount($this->CFG['user']['user_id']);
						$this->userDetails['privacy'] = $row['privacy'];
						$this->userDetails['status_id'] = $row['status_msg_id'];
						return false;
					}
				return true;
			}

		/**
		 * HeaderFormHandler::getTotalFriendsCount()
		 *
		 * @param int $user_id
		 *
		 * @return int $friends_count
		 */
		public function getTotalFriendsCount($user_id)
			{
				$sql =  ' SELECT COUNT(DISTINCT(fl.friend_id)) AS total_friends_count '.
						' FROM '.$this->CFG['db']['tbl']['friends_list'].' AS fl, '.$this->CFG['db']['tbl']['users'].' AS u '.
						' WHERE fl.friend_id = u.user_id AND u.usr_status = \'Ok\' AND fl.owner_id='.$this->dbObj->Param('user_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['total_friends_count'];
			}

		/**
		 * HeaderFormHandler::getUserStatusMessages()
		 *
		 * @return
		 */
		public function getUserStatusMessages()
			{
				$sql = 'SELECT status_msg_id, message FROM '.$this->CFG['db']['tbl']['users_status_messages'].
						' WHERE user_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
						' ORDER BY status_msg_id DESC LIMIT 20';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$status = array();
				if ($rs->PO_RecordCount()>0)
				    {
				     	while($row = $rs->FetchRow())
				     	    {
				     		    $status[$row['status_msg_id']] = $row['message'];
				     	    } // while
				    }
				return $status;
			}

		/**
		 * HeaderFormHandler::displayStatusAsJsObject()
		 *
		 * @return
		 */
		public function displayStatusAsJsObject()
			{
				if(!isMember())
					return;
				$status = $this->getUserStatusMessages();
				$all_status='';
				if ($status)
				    {
						foreach($status as $key=>$value)
							{
								$all_status.=$key.'#~#'.$value.',';
							}
						$all_status = substr($all_status,0,strlen($all_status)-1);
						echo $all_status;
					}
			}

		/**
		 * HeaderFormHandler::getCurrentStatus()
		 *
		 * @return
		 */
		public function getCurrentStatus()
			{
				if(!isMember())
					return;
				$status=array();
				$status['status'] = $this->userDetails['privacy'];
				$status['wrapped_status'] = wordWrap_mb_ManualWithSpace($status['status'],$this->CFG['admin']['status_message_text_length'],$this->CFG['admin']['status_message_text_total_length']);
				if (strcmp($this->userDetails['privacy'], 'Online')==0)
				  	{
					  	$status['status'] = 'Available';
					  	$status['wrapped_status'] = wordWrap_mb_ManualWithSpace($status['status'],$this->CFG['admin']['status_message_text_length'],$this->CFG['admin']['status_message_text_total_length']);
				  	}
				if (strcmp($this->userDetails['privacy'], 'Custom')==0)
				    {
						$status['status'] = 'Available';
						$sql = 'SELECT message FROM '.$this->CFG['db']['tbl']['users_status_messages'].
								' WHERE status_msg_id='.$this->dbObj->Param('status_msg_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->userDetails['status_id']));
						    if (!$rs)
							    trigger_db_error($this->dbObj);

						if ($rs->PO_RecordCount()>0)
						    {
						        $row = $rs->FetchRow();
								$status['status'] = $row['message'];
								$status['wrapped_status'] = wordWrap_mb_ManualWithSpace($row['message'],$this->CFG['admin']['status_message_text_length'],$this->CFG['admin']['status_message_text_total_length']);
						    }
					}
				return $status;
			}

		/**
		 * HeaderFormHandler::getShortcutPopup()
		 * Short cut links shown on mouseover of the user name in the top menu
		 * @return
		 */
		public function getShortcutPopup()
			{
			   	$show_shortcuts_arr = array();
			   	$show_shortcuts_arr[0]['Link']=getUrl('myprofile');
			   	$show_shortcuts_arr[0]['Link_Name']=$this->LANG['header_myprofilelinks_profilelayout'];

				$show_shortcuts_arr[1]['Link']=getUrl('viewprofile', '?user='.$this->CFG['user']['user_name'], $this->CFG['user']['user_name'].'/');
			   	$show_shortcuts_arr[1]['Link_Name']=$this->LANG['header_myprofilelinks_profilequickedit'];

			   	$show_shortcuts_arr[2]['Link']=getUrl('profilebasic', '', '', 'members');
			   	$show_shortcuts_arr[2]['Link_Name']=$this->LANG['header_myprofilelinks_profile_basic'];
			   	$inc = 3;
	           	foreach ($this->CFG['site']['modules_arr'] as $key=>$value)
	            	{
	            	  	if(chkAllowedModule(array(strtolower($value))))
	    					{
	    						if(isset($CFG['page_url'][$value.'list']['normal']))
	    							{
				   	   	   		  		$show_shortcuts_arr[$inc]['Link']=getUrl($value.'list', '?pg=my'.$value.'s', 'my'.$value.'s/', '', $value);
						            	$show_shortcuts_arr[$inc]['Link_Name']=$this->LANG['header_my_shortcuts_popup_'.$value];
						            	$inc++;
									}
			            	}
	            	}
	           	return $show_shortcuts_arr;
			}

		/**
		 * HeaderFormHandler::chkIsProfilePage()
		 *
		 * @return
		 */
		public function chkIsProfilePage()
			{
				$allowed_pages_array = array('viewProfile.php', 'myProfile.php', 'userDetail.php');
				if(displayBlock($allowed_pages_array, false, $append_default_pages=false))
					return true;
				return false;
			}

		/**
		 * HeaderFormHandler::isUserStyle()
		 *
		 * @return
		 */
		public function isUserStyle()
			{
				$allowed_pages_array = array('viewProfile.php', 'myProfile.php');

				if(!displayBlock($allowed_pages_array))
					return false;

				if(displayBlock(array('myProfile.php')))
					{
						$this->fields_arr['user_id'] = $this->CFG['user']['user_id'];
					}
				else if($this->fields_arr['user'])
					{
						if($this->fields_arr['user']==$this->CFG['user']['user_name'])
							$this->fields_arr['user_id'] = $this->CFG['user']['user_id'];
						else
							{
								$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users'].
										' WHERE user_name='.$this->dbObj->Param('user_name');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user']));
								    if (!$rs)
									    trigger_db_error($this->dbObj);

								if($row = $rs->FetchRow())
									$this->fields_arr['user_id'] = $row['user_id'];
							}
					}
				if($userId = $this->fields_arr['user_id'])
					{
						$sql = 'SELECT user_style FROM '.$this->CFG['db']['tbl']['users_profile_theme'].' WHERE user_id='.$this->dbObj->Param($userId);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($userId));
						if (!$rs)
							trigger_db_error($this->dbObj);
						$row = array();
						$style = '';
						if ($rs->PO_RecordCount())
							{
								$row = $rs->FetchRow();
								$style = $row['user_style'];
							}
						if(trim($style))
							return true;
					}
				return false;
			}

		/**
		 * HeaderFormHandler::intitializeLNBarVars()
		 *
		 * @param array $lnBarArr
		 * @return
		 */
		public function intitializeLNBarVars($lnBarArr=array())
			{
				foreach($lnBarArr as $index=>$value)
					{
						$this->lnBarArr[$value]['nav']='display:none;';
						$this->lnBarArr[$value]['class']='clsSideBarLeft';
					}
			}

		/**
		 * HeaderFormHandler::getTotalVideos()
		 *
		 * @return
		 */
		public function getTotalVideos()
			{
				return $this->userDetails['total_videos'];
			}

		/**
		 * HeaderFormHandler::showTotalMembersInUsersNetwork()
		 *
		 * @return
		 */
		public function showTotalMembersInUsersNetwork()
			{
				$count = 0;
				$sql = 'SELECT COUNT(user_id) AS cnt FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_status=\'Ok\'';

	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
			}

		/**
		 * HeaderFormHandler::getTotalVideosWatched()
		 *
		 * @return
		 */
		public function getTotalVideosWatched()
			{
				$sql = 'SELECT COUNT(DISTINCT video_id) AS cnt FROM '.$this->CFG['db']['tbl']['video_viewed'].
						' WHERE user_id=\''.$this->CFG['user']['user_id'].'\'';
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
			}

		/**
		 * HeaderFormHandler::getTotalVideosFavourite()
		 *
		 * @return
		 */
		public function getTotalVideosFavourite()
			{
				$sql = 'SELECT COUNT(DISTINCT video_id) AS cnt FROM '.$this->CFG['db']['tbl']['video_favorite'].
						' WHERE user_id=\''.$this->CFG['user']['user_id'].'\'';
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
			}

		/**
		 * HeaderFormHandler::getTotalVideosViews()
		 *
		 * @return
		 */
		public function getTotalVideosViews()
			{
				$sql = 'SELECT SUM(total_views) AS cnt FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE user_id=\''.$this->CFG['user']['user_id'].'\' ';
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
			}

		/**
		 * HeaderFormHandler::getTotalComments()
		 *
		 * @return
		 */
		public function getTotalComments()
			{
				$sql = 'SELECT COUNT(profile_user_id) AS cnt FROM '.$this->CFG['db']['tbl']['users_profile_comments'].
						' WHERE profile_user_id=\''.$this->CFG['user']['user_id'].'\' ';
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
			}

		/**
		 * HeaderFormHandler::getTotalFriendsNew()
		 *
		 * @return
		 */
		public function getTotalFriendsNew()
			{
				return $this->userDetails['total_friends'];
			}

		/**
		 * HeaderFormHandler::populateMyHotLinks()
		 *
		 * @return
		 */
		public function populateMyHotLinks()
			{
			    global $smartyObj;
				$smartyObj->assign('getTotalFriendsNew',$this->getTotalFriendsNew());
				setTemplateFolder('members/');
				$smartyObj->display('myDashboard.tpl');

			}

		/**
		 * HeaderFormHandler::populateRSSPageLink()
		 *
		 * @param string $diplay_in
		 * @param string $display_tab
		 * @return
		 */
		public function populateRSSPageLink($diplay_in = 'footer', $display_tab='general')
			{
				global $smartyObj;
				$rss_page_link_arr = array();
				$inc = 0;
			    foreach($this->CFG['site']['modules_arr'] as $value)
			     	{
						if(chkAllowedModule(array(strtolower($value),'rss')))
							{
								if(isset($this->LANG['footer_rss_title_'.$value]))
									{
										$rss_page_link_arr[$inc]['link'] = getUrl('rss'.$value,'','','',$value);
										$rss_page_link_arr[$inc]['link_text'] = $this->LANG['footer_rss_title_'.$value];
										$inc++;
									}
							}
    		     	}
    		    $smartyObj->assign('rss_page_link_arr', $rss_page_link_arr);
				return false;
			}

		/**
		 * HeaderFormHandler::contentFilterTopLink()
		 *
		 * @return
		 */
		public function contentFilterTopLink()
			{
				global $CFG;
				if (!chkAllowedModule(array('content_filter')))
					return '';

				/*if(!empty($CFG['site']['is_module_page']))
					{
						$module_config = $CFG['site']['is_module_page'];
						$module_config .= 's';
						$module_config.'_content_filter';
						if(!chkAllowedModule(array($module_config.'_content_filter')))
							return '';
					}*/

				$this->contentFilterTopLink = getInitialFilterLink();
				return true;
			}

		/**
		 * HeaderFormHandler::displayLoginFormRightNavigation()
		 *
		 * @return
		 */
		public function displayLoginFormRightNavigation()
			{
				global $smartyObj;
				$displayLoginFormRightNavigation_arr = array();

				if(!chkAllowedModule(array('login')))
					return;

				if(isMember())
					return;

				$allowed_pages_array = array('viewProfile.php', 'login.php', 'extLogin.php', 'devLogin.php', 'index.php');

				if(!displayBlock($allowed_pages_array, true))
					return;

				if($this->CFG['admin']['email_using_to_login'])
					$login_field = 'email';
				else
					$login_field = 'username';

				$user_login_details_arr = array('user_name'=>'', 'password'=>'');
				$displayLoginFormRightNavigation_arr['user_login_details_arr'] = $user_login_details_arr;

				$displayLoginFormRightNavigation_arr['header_nav_login_login_field'] = $this->LANG['header_nav_login_'.$login_field];
				$displayLoginFormRightNavigation_arr['chkAllowedModule_registration'] = chkAllowedModule(array('signup'));

				$smartyObj->assign('displayLoginFormRightNavigation_arr',$displayLoginFormRightNavigation_arr);
				setTemplateFolder('root/');
				$smartyObj->display('displayLoginFormRightNavigation.tpl');
			}

		/**
		 * HeaderFormHandler::populateMailRightNavigation()
		 *
		 * @return
		 */
		public function populateMailRightNavigation()
			{
			    global $smartyObj;
				$allowed_pages_array = array('mail.php', 'mailCompose.php', 'mailRead.php');

				if(!displayBlock($allowed_pages_array))
					return;

				$cssClassToHighlightSubLink = 'clsActivePhotoLink clsActive';

				$mail = $mailCompose = $mail_pg_inbox = $mail_pg_sent = $mail_pg_saved = $mail_pg_request = $mail_pg_video = $mail_pg_trash = $mail_pg_compose = '';
				$currentPage = $this->CFG['html']['current_script_name'];

				$$currentPage = $cssClassToHighlightSubLink;

				$pg = (isset($_REQUEST['folder']))?$_REQUEST['folder']:'';
				$pgRelatedPage = $currentPage.'_pg_'.$pg;
				$$pgRelatedPage = $cssClassToHighlightSubLink;
				$smartyObj->assign('mail_pg_inbox_class',$mail_pg_inbox);
				$smartyObj->assign('mail_pg_sent_class',$mail_pg_sent);
				$smartyObj->assign('mail_pg_saved_class',$mail_pg_saved);
				$smartyObj->assign('mail_pg_request_class',$mail_pg_request);
				$smartyObj->assign('mail_pg_video_class',$mail_pg_video);
				$smartyObj->assign('mail_pg_trash_class',$mail_pg_trash);
				$smartyObj->assign('mailCompose_class',$mailCompose);
				setTemplateFolder('general/');
				$smartyObj->display('populateMailRightNavigation.tpl');
			}

		/**
		 * HeaderFormHandler::populateProfileRightNavigation()
		 *
		 * @return
		 */
		public function populateProfileRightNavigation()
			{
			   	global $smartyObj;
				$allowed_pages_array = array('profileBasic.php', 'profileInfo.php',
										'profilePassword.php', 'profileSettings.php',
										'profileTheme.php', 'profileThemeDesign.php',
										'profileAvatar.php', 'profileBackground.php',
										'notificationSettings.php');

				if(!displayBlock($allowed_pages_array))
					return;

				$profileBlocks_arr = $this->getProfileBlocks();

				$sql = 'SELECT id, title FROM '.$this->CFG['db']['tbl']['users_profile_category'].
					   ' WHERE status=\'Yes\'
					    AND FIND_IN_SET(id,(SELECT GROUP_CONCAT(DISTINCT form_id ORDER BY form_id) FROM '.$this->CFG['db']['tbl']['users_profile_question'].'))';

				$stmt = $this->dbObj->Prepare($sql);
				$stmt_cls=$stmt;
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				// for link hightlight
			    $rs_cls = $this->dbObj->Execute($stmt_cls);
			    if (!$rs_cls)
				    trigger_db_error($this->dbObj);

				$cssClassToHighlightSubLink = 'clsActivePhotoLink clsActive';
				$clsActivePhotoSubLink = 'clsActivePhotoSubLink';

				$profileTheme = $profileThemeDesign = $profileBasic = $profilePersonal = $notificationSettings = $profileSettings = $profilePassword = $profileInfo = $profileBackground = '';

				foreach($profileBlocks_arr['block_name'] as $key => $block_name)
					{
						$profile_var = 'profileTheme_pg_'.$block_name;
						$$profile_var = '';
					}

				$profileAvatar= '';

				while($row_cls = $rs_cls->FetchRow())
					{
						$pageHighlight='profileInfo_pg_'.$this->changeTitle($row_cls['title']);
				    	$$pageHighlight='';
				   	}

				$currentPage = $this->CFG['html']['current_script_name'];
				$$currentPage = $cssClassToHighlightSubLink;

				$pg = '';
				if(isset($_REQUEST['pg']))
				  	$pg = $this->changeTitle($_REQUEST['pg']);
				else if(isset($_REQUEST['block']))
				  	$pg = $_REQUEST['block'];

				$pgRelatedPage = $currentPage.'_pg_'.$pg;
				$$pgRelatedPage = $cssClassToHighlightSubLink;
                $profile_li_arr = array();
			    $inc = 0;
				if ($rs->PO_RecordCount()>0)
				   	{
					    while($row = $rs->FetchRow())
						   	{
							   	$pageHighlight = 'profileInfo_pg_'.$this->changeTitle($row['title']);
							   	$profile_li_arr[$inc]['profileInfo_class'] = $$pageHighlight;
							   	$profile_li_arr[$inc]['profileInfo_record'] = $row;
							   	$profile_li_arr[$inc]['profileInfo_link'] = getUrl('profileinfo','?id='.$row['id'].'&pg'.$this->changeTitle($row['title']),$row['id'].'/'.$this->changeTitle($row['title']).'/');
							   	$inc++;
							}
					}

				$profile_theme_arr = array();
				$inc = 0;
				foreach($profileBlocks_arr['block_name'] as $key => $block_name)
					{
						$profile_var = 'profileTheme_pg_'.$block_name;
						$profile_theme_arr[$inc]['class'] = $$profile_var;
						$profile_theme_arr[$inc]['url'] = getUrl('profiletheme', '?block='.$block_name, '?block='.$block_name);
						$profile_theme_arr[$inc]['lang'] = (isset($this->LANG['header_nav_profile_theme_layout_'.$block_name])?$this->LANG['header_nav_profile_theme_layout_'.$block_name]:str_replace('VAR_BLOCK_NAME',$this->getProfileCategoryName($block_name),$this->LANG['header_nav_profile_theme_layout_default_block']));
						$inc++;
					}
				//Fetch user details
				$userDetails = $this->getUserDetail('user_id', $this->CFG['user']['user_id']);
				//Assign to smary
				$smartyObj->assign('userDetails',$userDetails);
				$smartyObj->assign('profileAvatar_class',$profileAvatar);
				$smartyObj->assign('profileBasic_class',$profileBasic);
				$smartyObj->assign('profileSettings_class',$profileSettings);
				$smartyObj->assign('profilePassword_class',$profilePassword);
				$smartyObj->assign('notificationSettings_class',$notificationSettings);
				$smartyObj->assign('profileThemeDesign_class',$profileThemeDesign);
				$smartyObj->assign('profileTheme_class',$profileTheme);
				$smartyObj->assign('profileBackground_class',$profileBackground);
				$smartyObj->assign('profile_theme_arr', $profile_theme_arr);
				$smartyObj->assign('profile_li_arr',$profile_li_arr);
				setTemplateFolder('general/');
				$smartyObj->display('populateProfileRightNavigation.tpl');
			}

		/**
		 * ThemeEditor::getProfileCategoryName()
		 *
		 * @return
		 */
		public function getProfileCategoryName($block_name)
			 {
			 	$sql = 'SELECT title FROM '.$this->CFG['db']['tbl']['users_profile_category'].
				 		' AS pc, '.$this->CFG['db']['tbl']['profile_block'].' AS pb
						  WHERE pc.id = pb.profile_category_id AND pb.block_name = '.$this->dbObj->Param('title');
			 	$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($block_name));
				if (!$rs)
				    trigger_db_error($this->dbObj);

			 	if($row = $rs->FetchRow())
					return $form_id = $row['title'];
				return $block_name;
			 }

		/**
		 * HeaderFormHandler::populateRelationRightNavigation()
		 *
		 * @return
		 */
		public function populateRelationRightNavigation()
			{
				global $smartyObj;
				$populateRelationRightNavigation_arr = array();
				$allowed_pages_array = array('relationManage.php', 'relationView.php', 'myFriends.php', 'invitationHistory.php');

				if(!displayBlock($allowed_pages_array))
					return;

				$currentPage = $this->CFG['html']['current_script_name'];
				$populateRelationRightNavigation_arr['relationManage'] = $populateRelationRightNavigation_arr['relationView'] = $populateRelationRightNavigation_arr['myFriends'] = $populateRelationRightNavigation_arr['myFriends_pg_top_friends'] = $populateRelationRightNavigation_arr['membersInvite'] = $populateRelationRightNavigation_arr['invitationHistory'] = '';

				$pg = (isset($_REQUEST['pg']))?$_REQUEST['pg']:'';
				if($pg)
					{
						$pgRelatedPage = $currentPage.'_pg_'.$pg;
						$populateRelationRightNavigation_arr[$pgRelatedPage] = ' class="clsActivePhotoLink clsActive"';
					}
				else
					{
						$populateRelationRightNavigation_arr[$currentPage] = ' class="clsActivePhotoLink clsActive"';
					}

				if($currentPage == 'relationView')
					$populateRelationRightNavigation_arr['relationManage'] = ' class="clsActivePhotoLink clsActive"';

				$this->setMyRelations();

				$relationViewPage = getUrl('relationview');
				$populateRelationRightNavigation_arr['myRelation_arr'] = array();
				$inc = 0;
				foreach($this->myRelation as $key=>$value)
					{
						$populateRelationRightNavigation_arr['myRelation_arr'][$inc]['class'] = (isset($_GET['relation']) and strcmp($_GET['relation'], $key)==0)?' class = "clsActivePhotoSubLink"':'';
						$count = $this->myRelationCount[$key];
						$populateRelationRightNavigation_arr['myRelation_arr'][$inc]['count'] = $count;
						$populateRelationRightNavigation_arr['myRelation_arr'][$inc]['href'] = ($count)?'href="'.$relationViewPage.'?relation='.$key.'"':'';
						$populateRelationRightNavigation_arr['myRelation_arr'][$inc]['title'] = $this->myRelationCount[$key];
						$populateRelationRightNavigation_arr['myRelation_arr'][$inc]['value'] = $value;
						$inc++;
					}
				$smartyObj->assign('populateRelationRightNavigation_arr',$populateRelationRightNavigation_arr);
				setTemplateFolder('general/');
				$smartyObj->display('populateRelationRightNavigation.tpl');
			}

		/**
		 * HeaderFormHandler::populateSiteStatistics()
		 *
		 * @return
		 */
		public function populateSiteStatistics()
			{
				global $smartyObj;
				//commented this since we need to show the stats in all pages
				/*
				$allowed_pages_array = array('index.php');

				if(!displayBlock($allowed_pages_array))
					return;*/

				$details = array();
				$inc = 0;
				$site_stats_module_arr = array('video', 'music', 'photo');

				//Get Other module's statistics : Only for video, audio and photo
				foreach ($site_stats_module_arr as $key=>$value)
	            	{
		    			if(chkAllowedModule(array(strtolower($value))))
		    				{
			                	$function_name = 'getTotal'.ucfirst($value).'sInSite';
								if(function_exists($function_name))
									{
										$details[$inc]['lang'] = $this->LANG['index_statistics_total_'.$value.'s'];
										$details[$inc]['value'] = $function_name();
										$details[$inc]['class'] = 'clsTotal'.$value;
										$inc++;
								  	}
							}
					}
				$smartyObj->assign('statistics',$details);
				setTemplateFolder('general/');
				$smartyObj->display('siteStatistics.tpl');
			}

		/**
		 * HeaderFormHandler::populateSiteUserStatistics()
		 *
		 * @return
		 */
		public function populateSiteUserStatistics()
			{
				global $smartyObj;
				//commented this since we need to show the stats in all pages
				/*
				$allowed_pages_array = array('index.php');

				if(!displayBlock($allowed_pages_array))
					return;*/
				if(isset($_SESSION['user']['user_id']) and $_SESSION['user']['user_id'])
				{
					$user_id = $_SESSION['user']['user_id'];
				}
				else
				{
					$user_id = '';
				}
				$details = array();
				$inc = 0;
				$site_stats_module_arr = array('video', 'music', 'photo');

				//Get Other module's statistics : Only for video, audio and photo
				foreach ($site_stats_module_arr as $key=>$value)
	            	{
		    			if(chkAllowedModule(array(strtolower($value))))
		    				{
			                	$function_name = 'getTotal'.ucfirst($value).'sInSite';
								if(function_exists($function_name))
									{
										$details[$inc]['lang'] = $this->LANG['index_statistics_total_'.$value.'s'];
										$details[$inc]['value'] = $function_name($user_id);
										$details[$inc]['class'] = 'clsTotal'.$value;
										$inc++;
								  	}
							}
					}
				$smartyObj->assign('userstatistics',$details);
			}
		/**
		 * HeaderFormHandler::populateModuleStatistics()
		 *
		 * @return
		 */
		public function populateModuleStatistics()
			{
				global $smartyObj;
				//commented this since we need to show the stats in all pages
				/*
				$allowed_pages_array = array('index.php');

				if(!displayBlock($allowed_pages_array))
					return;*/

				$details = array();

				$site_stats_module_arr = array('video', 'music', 'photo');

				//Get Other module's statistics : Only for video, audio and photo
				foreach ($site_stats_module_arr as $key=>$value)
	            	{
	            		$inc = 0;
		    			if(chkAllowedModule(array(strtolower($value))))
		    				{
			                	$function_name = 'getTotal'.ucfirst($value).'sInSite';
								if(function_exists($function_name))
									{
										$details[$value][$inc]['lang'] = $this->LANG['index_statistics_total_'.$value.'s'];
										$details[$value][$inc]['value'] = $function_name();
										$details[$value][$inc]['class'] = 'clsTotal'.$value;
										$inc++;
								  	}
			                	$related_tats_function_name = 'get'.ucfirst($value).'RelatedStats';
								if(function_exists($related_tats_function_name))
								  {
									  $details[$value][$inc]['lang'] = $this->LANG['index_statistics_'.$value.'_related_stats'];
									  $details[$value][$inc]['value'] = $related_tats_function_name();
									  $details[$value][$inc]['class'] = 'cls'.$value.'Stats';
									  $inc++;
								  }
							}
					}
				$smartyObj->assign('modulestatistics',$details);
			}
		/**
		 * HeaderFormHandler::populateTopContributorsRightNavigation()
		 *
		 * @return
		 */
		public function populateTopContributorsRightNavigation()
			{
				global $smartyObj;
				$allowed_pages_array = array('index.php', 'membersList.php');
				$this->contributor=array();
				if(!displayBlock($allowed_pages_array))
					return;

                //TopContributors removed from login page.
				$not_allowed_array=array('login.php');
				if(displayBlock($not_allowed_array))
					return false;

				$module = (!empty($this->CFG['site']['is_module_page'])
								?$this->CFG['site']['is_module_page']
									:$this->CFG['admin']['site_top_contributors']);
				if(!chkAllowedModule(array(strtolower($module))))
					return false;

				$function_name = 'populate'.ucfirst($module).'TopContributors';

				if(function_exists($function_name))
					$function_name();
			}

		/**
		 * HeaderFormHandler::populateURLsRightNavigation()
		 *
		 * @return
		 */
		public function populateURLsRightNavigation()
			{
			    global $smartyObj;
				if(!chkAllowedModule(array('urls')))
					return;

				$allowed_pages_array = array( 'index.php', 'exturl.php');

				if(!displayBlock($allowed_pages_array))
					return;

				$sql = 'SELECT exturl_id, exturl_name, exturl_url,'.
						' exturl_description,'.
						' exturl_status, exturl_ext, date_added FROM '.$this->CFG['db']['tbl']['exturl'].
						' WHERE exturl_status = \'Yes\' ORDER BY exturl_name ASC LIMIT 0, 5';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$count=0;
				$exturl_link_arr = array();
				$inc=0;
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$exturl_link_arr[$inc]['exturl_link']=makeClickableLinks($row['exturl_url'], $use_text=$row['exturl_name']);
								$inc++;
							}
					}
				else
					{
					  	$exturl_link_arr=0;
					}
				$smartyObj->assign('exturl_link_arr',$exturl_link_arr);
				setTemplateFolder('general/');
				$smartyObj->display('populateURLsRightNavigation.tpl');
			}

		/**
		 * HeaderFormHandler::displayFeaturedMemberRightNavigation()
		 *
		 * @return
		 */
		public function displayFeaturedMemberRightNavigation()
			{
				global $LANG_LIST_ARR;
				global $smartyObj;

				$allowed_pages_array = array('membersList.php', 'membersBrowse.php', 'membersAdvSearch.php', );
				if(!displayBlock($allowed_pages_array))
					return;

				$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users_featured'];
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);

				if (!$rs->PO_RecordCount())
					return ;

				$featured_ids = array();
				while($row = $rs->FetchRow())
					{
						$featured_ids[] = $row['user_id'];
					}
				$cntFeatured = count($featured_ids);
				$randomFeatured = rand(0, $cntFeatured-1);
				$featuredMeber = $featured_ids[$randomFeatured];

				$sql = 'SELECT user_name, first_name, last_name, user_id, total_videos, total_musics, total_photos,'.
						' total_friends, icon_id, icon_type,image_ext, sex, age, country, city, relation_status'.
					   	' FROM '.$this->CFG['db']['tbl']['users'].
					   	' WHERE user_id = '.$this->dbObj->Param('uid').' AND usr_status=\'Ok\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($featuredMeber));
				if (!$rs)
					    trigger_db_error($this->dbObj);
	   	   	   	$fields_list = array('user_name', 'icon_id', 'icon_type', 'sex', 'image_ext');

				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$iconDetails = getMemberAvatarDetails($row['user_id']);

						$this->UserDetails[$row['user_id']] = $row;
						$userdetail = $this->getUserDetail('user_id', $row['user_id']);
						$name = $userdetail['user_name'];
						$featuredMember['sex'] = $row['sex']=='male'?'M':'F';
						if(isset($LANG_LIST_ARR['user_relation_status'][$row['relation_status']]))
							$realtional_status = $row['relation_status']?(', '.$LANG_LIST_ARR['user_relation_status'][$row['relation_status']]):'';
						$featuredMember['city'] = $row['city']?$row['city']:'';

						$featuredMember['profileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
						$featuredMember['icon'] = $iconDetails;
						$featuredMember['name'] = $name;
						$featuredMember['age'] = $row['age'];
						$featuredMember['viewFriendsUrl'] = getUrl('viewfriends', '?user='.$row['user_name'], $row['user_name'].'/');
						$featuredMember['total_friends'] = $row['total_friends'];
						foreach ($this->CFG['site']['modules_arr'] as $key=>$value)
						{
							//$function_name = 'getTotalUsers'.ucfirst($value).'s';
							if ($value == 'blog') {
								$function_name = 'getTotalUsersPosts';
							}
							else
								$function_name = 'getTotalUsers'.ucfirst($value).'s';
							if(function_exists($function_name))
								{
									$stats = $function_name($row['user_id'],1);
									$featuredMember['total_'.strtolower($value).'s'] = $stats;
									$featuredMember[$value.'_icon_title'] = sprintf($this->CFG['admin']['members'][$value.'_icon_title'], $stats);
								}
						}

						/*if(chkAllowedModule(array('video')))
							{
								$featuredMember['videoListUrl'] = getUrl('videolist', '?pg=uservideolist&amp;user_id='.$row['user_id'], 'uservideolist/?user_id='.$row['user_id'],'','video');
								$featuredMember['total_videos'] = $row['total_videos'];
								$featuredMember['total_musics'] = $row['total_musics'];
								$featuredMember['musicListUrl'] = getUrl('musiclist', '?pg=usermusiclist&amp;user_id='.$row['user_id'], 'usermusiclist/?user_id='.$row['user_id'],'','music');
								$featuredMember['total_photos'] = $row['total_photos'];
								$featuredMember['photoListUrl'] = getUrl('photolist', '?pg=userphotolist&amp;user_id='.$row['user_id'], 'userphotolist/?user_id='.$row['user_id'],'','photo');
							}*/
						$smartyObj->assign('featuredMember', $featuredMember);
						setTemplateFolder('general/');
						$smartyObj->display('featuredMember.tpl');
				    }
			}

		/**
		 * HeaderFormHandler::chooseStyle()
		 *
		 * @param mixed $style
		 * @return
		 */
		public function chooseStyle($style)
			{
				//Have fixed querystring issue while changing the style
				$url = getCurrentUrl(true);
				if(strstr($url, 'template'))
					{
						$request_arr = $_REQUEST;
						$url_no_par = getCurrentUrl();
						foreach($request_arr as $key => $value)
							{
								if(strstr($url, $key))
									{
										if($key == 'template')
											{
												if(strstr($url_no_par, '?'))
													$url_no_par .= '&template='.$style;
												else
													$url_no_par .= '?template='.$style;
											}
										else
											{
												if(strstr($url_no_par, '?'))
													$url_no_par .= '&'.$key.'='.$value;
												else
													$url_no_par .= '?'.$key.'='.$value;
											}
									}
							}
						return $url_no_par;
					}
				if(strstr($url, '?'))
					$url .= '&template='.$style;
				else
					$url .= '?template='.$style;
				return $url;
			}

		/**
		 * HeaderFormHandler::populateUploadLink()
		 *  To populate upload link
		 * @return boolean
		 */
		public function populateUploadLink()
			{
				$this->upload_link = false;
				if($this->CFG['site']['is_module_page'])
					{
						$module = $this->CFG['site']['is_module_page'];
					}
				elseif(chkAllowedModule(array(strtolower($this->CFG['admin']['site_menu_default_upload_link']))))
					{
						$module = $this->CFG['admin']['site_menu_default_upload_link'];
					}
				else
					{
						foreach($this->CFG['site']['modules_arr'] as $value)
							{
								if(chkAllowedModule(array(strtolower($value))))
									{
										$module = $value;
										break;
									}
							}
						if(empty($module))
							return false;
					}
				if(isset($this->CFG['page_url'][$module.'uploadpopup']['normal']))
					$this->upload_link = getUrl($module.'uploadpopup', '', '', 'members', $module);
			}

		/**
		 * HeaderFormHandler::populateSearchModules()
		 * To populate default search link and text
		 * @return boolean
		 */
		public function populateSearchModules()
			{
				global $smartyObj;
				$this->display_search_form = false;
				$populateSearchModules_arr = array();
				$sql = 'SELECT module, label, file_name, normal_querystring,'.
						' seo_querystring, default_search FROM '.$this->CFG['db']['tbl']['search_settings'].
						' WHERE status=\'Yes\' ORDER BY priority ASC, default_search DESC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								if(!empty($row['module']) and chkAllowedModule(array($row['module'])))
									{
										$populateSearchModules_arr[$inc]['module'] = $row['module'];
										$populateSearchModules_arr[$inc]['label'] = (!empty($this->LANG['searchModules'][$row['module']])?$this->LANG['searchModules'][$row['module']]:$row['label']);
										$populateSearchModules_arr[$inc]['form_action'] = getUrl($row['file_name'], $row['normal_querystring'], $row['seo_querystring'], '', $row['module']);
										if($row['default_search'] == 1)
											$default_search_form = getUrl($row['file_name'], $row['normal_querystring'], $row['seo_querystring'], '', $row['module']);
										$inc++;
									}
								elseif($row['module'] == 'general')
									{
										$populateSearchModules_arr[$inc]['module'] = $row['module'];
										$populateSearchModules_arr[$inc]['label'] = (!empty($this->LANG['searchModules'][str_replace(' ', '_', strtolower($row['label']))])?$this->LANG['searchModules'][str_replace(' ', '_', strtolower($row['label']))]:$row['label']);
										$populateSearchModules_arr[$inc]['form_action'] = getUrl($row['file_name'], $row['normal_querystring'], $row['seo_querystring']);
										if($row['default_search'] == 1)
											{
												$default_search_form = getUrl($row['file_name'], $row['normal_querystring'], $row['seo_querystring']);
											}
										$inc++;
									}
							}
					}
				$this->search_box_text = $this->LANG['header_search_text'];
				$smartyObj->assign('populateSearchModules_arr', $populateSearchModules_arr);

				if(isset($default_search_form) and !empty($default_search_form))
					{
						$this->display_search_form = true;
						$this->search_form_action = $default_search_form;
					}
				else
					{
						foreach($populateSearchModules_arr as $value)
							{
								$this->display_search_form = true;
								$this->search_form_action = $value['form_action'];
								break;
							}
					}
				$this->search_type = '';
				$this->populateSearchModules_arr = $populateSearchModules_arr;
			}

		/**
		 * HeaderFormHandler::populateSearchRelatedJs()
		 *
		 * @return
		 */
		public function populateSearchRelatedJs()
			{
				?>
				<script type="text/javascript">
					var search_tag_text= '<?php echo $this->search_box_text; ?>';
					function chooseSearchSelect(type, search_position)
						{
							var search_tag_text='<?php echo $this->search_box_text; ?>';
							tag_value=$Jq('#searchTags_'+search_position).val();
							tag_value = escape(tag_value);
							search_tag_text=escape(search_tag_text);
							if(Trim(tag_value) == '') tag_value = search_tag_text;
							if(search_tag_text==tag_value)
							    {
									$Jq('#searchTags_'+search_position).focus();
								  	return false;
								}
			  			   <?php
						   foreach($this->populateSearchModules_arr as $value)
				  			   {
									echo "if(type == '".$value['module']."')
										search_page_location = '".$value['form_action']."'+tag_value;";

					           }
							echo 'if(search_page_location)
							   window.location = search_page_location;';
							?>
						}
				</script>
				<?php
			}
		/**
		 * HeaderFormHandler::getTotalMembers()
		 *
		 * @return
		 */
		public function getTotalMembers(){
				$sql = 'SELECT COUNT(DISTINCT user_id) AS cnt FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_status=\'Ok\'';
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
		}
		/**
		 * HeaderFormHandler::getTotalOnlineMembers()
		 *
		 * @return
		 */
		public function getTotalOnlineMembers(){
				$sql = 'SELECT COUNT(DISTINCT user_id) AS cnt FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_status=\'Ok\' AND (logged_in=\'1\'  AND DATE_SUB(NOW(), INTERVAL 20 SECOND) < last_active) AND user_id!=\''.$this->CFG['user']['user_id'].'\'';
	            $stmt = $this->dbObj->Prepare($sql);
	            $rs = $this->dbObj->Execute($stmt);
	                if (!$rs)
	            	    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
				    {
				        $row = $rs->FetchRow();
						$count = $row['cnt'];
				    }
				$count = number_format($count);
				return $count;
		}

		/**
		 * HeaderFormHandler::chkIsProfilePage()
		 *
		 * @return
		 */
		public function chkIsAllMemberPage()
			{
				$allowed_pages_array = array('membersList.php', 'membersBrowse.php', 'membersAdvSearch.php','memberBlock.php' );
				if(displayBlock($allowed_pages_array, false, $append_default_pages=false))
					return true;
				return false;
			}
		/**
		 * HeaderFormHandler::chkIsNoSidebarPage()
		 *
		 * @return
		 */
		public function chkIsNoSidebarPage()
			{
				$allowed_pages_array = array('login.php','contactUs.php','signup.php','receiveBugs.php','reportBugs.php');
				if(displayBlock($allowed_pages_array, false, $append_default_pages=false))
					return true;
				return false;
			}
		/**
		 * HeaderFormHandler::chkIsAllMailPage()
		 *
		 * @return
		 */
		public function chkIsAllMailPage()
			{
				$allowed_pages_array = array('mail.php', 'mailCompose.php', 'mailRead.php');
				if(displayBlock($allowed_pages_array, false, $append_default_pages=false))
					return true;
				return false;
			}
		/**
		 * HeaderFormHandler::chkIsAllFriendPage()
		 *
		 * @return
		 */
		public function chkIsAllFriendPage()
			{
				$allowed_pages_array = array('relationManage.php', 'relationView.php', 'myFriends.php', 'invitationHistory.php');
				if(displayBlock($allowed_pages_array, false, $append_default_pages=false))
					return true;
				return false;
			}
		/**
		 * HeaderFormHandler::chkIsAllProfilePage()
		 *
		 * @return
		 */
		public function chkIsAllProfilePage()
			{
				$allowed_pages_array = array('profileBasic.php', 'profileInfo.php',
										'profilePassword.php', 'profileSettings.php',
										'profileTheme.php', 'profileThemeDesign.php',
										'profileAvatar.php', 'profileBackground.php',
										'notificationSettings.php');
				if(displayBlock($allowed_pages_array, false, $append_default_pages=false))
					return true;
				return false;
			}
	}

$HeaderHandler = new HeaderFormHandler();
global $LANG;
$HeaderHandler->setPageBlockNames(array('headerBlock', 'pollFormBlock', 'pollResultBlock'));
$HeaderHandler->storeUserDetails();
$HeaderHandler->setFormField('tags', '');
$HeaderHandler->setFormField('keyword', '');
$HeaderHandler->setFormField('soption', '');
$HeaderHandler->setFormField('user_id', 0);
$HeaderHandler->setFormField('user', 0);
$HeaderHandler->setFormField('blog_name', '');
$HeaderHandler->setFormField('article_title', '');
$HeaderHandler->setFormField('search_article_title', '');
$HeaderHandler->setFormField('blog_title', '');
$HeaderHandler->setFormField('search_blog_title', '');
$HeaderHandler->sanitizeFormInputs($_REQUEST);
$HeaderHandler->setAllPageBlocksHide();
$HeaderHandler->setPageBlockShow('headerBlock');
$soption = $HeaderHandler->getFormField('soption');
//Get site logo and favicon from corresponding directory
$dir = $CFG['site']['project_path'].'design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/header/';
$logodir = $dir.'logo/';
$favicondir = $dir.'favicon/';
$logo_extn = $HeaderHandler->getSiteLogoAndFavicon($logodir, 'logo');
$favicon_extn = $HeaderHandler->getSiteLogoAndFavicon($favicondir, 'favicon');
$image_path = $CFG['site']['url'].'design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/header/';
$HeaderHandler->logo_url = $image_path.'logo/logo.'.$logo_extn;
$HeaderHandler->favicon_url = $image_path.'favicon/favicon.'.$favicon_extn;
if ($soption)
    {
        $$soption = 'SELECTED';
		$link = $soption.'SearchLinkClass';
		$$link = ' searchHighLightLink';
    }
if(isAjaxPage())
	{
	  	$HeaderHandler->setAllPageBlocksHide();
	}
if(isMember())
	{
		$HeaderHandler->my_profile_link = getUrl('viewprofile', '?user='.$CFG['user']['user_name'], $CFG['user']['user_name'].'/');
	}
//assign for populate the language list in header
$HeaderHandler->populateLanguageDetails();
$HeaderHandler->populateTemplateDetails();
$smartyObj->assign('isMember', isMember());
$smartyObj->assign('isAdmin', isAdmin());
$smartyObj->assign_by_ref('header', $HeaderHandler);
$dashboardmodule_arr = array();
$inc = 0;
foreach($CFG['site']['modules_arr'] as $value)
	{
		if(chkAllowedModule(array(strtolower($value))))
			{
				$funtion_name = 'getMyDashboard'.ucfirst($value).'Links';
				$dashboardmodule_arr[$value] = '';
				if(function_exists($funtion_name))
					$dashboardmodule_arr[$value] = $funtion_name();
				$inc++;
		    }
	}
$HeaderHandler->headerBlock['dashboard_module_arr'] = $dashboardmodule_arr;
$HeaderHandler->headerBlock['is_dashboard_module'] = false;
if($inc > 0)
	$HeaderHandler->headerBlock['is_dashboard_module'] = true;

$footermodule_arr=array();
$inc=0;
$footer_links_module_arr = array('video', 'music', 'photo');

foreach($footer_links_module_arr as $value)
	{
		if(chkAllowedModule(array(strtolower($value))))
			{
				$funtion_name = 'getMyFooter'.ucfirst($value).'Links';
				$footermodule_arr[$value] = '';
				$footermodulehead_arr[$value] = isset($LANG['footer_link_head_'.$value])?$LANG['footer_link_head_'.$value]: $value;
				if(function_exists($funtion_name))
					$footermodule_arr[$value] = $funtion_name();
				$inc++;
			}
	}

//Home page link
$HeaderHandler->generateIndexPageLink();
//Upload Link
$HeaderHandler->populateUploadLink();
//Search
$HeaderHandler->populateSearchModules();
//Rss links
$HeaderHandler->populateRSSPageLink();
if (isset($footermodule_arr)) {
	$HeaderHandler->headerBlock['footer_module_links_arr'] = $footermodule_arr;
}
if (isset($footermodulehead_arr)) {
	$HeaderHandler->headerBlock['footer_module_head_arr'] = $footermodulehead_arr;
	$smartyObj->assign('footer_module_head_arr', $footermodulehead_arr);
}

$HeaderHandler->headerBlock['is_footer_links']=false;
if($inc > 0)
	$HeaderHandler->headerBlock['is_footer_links']=true;

$HeaderHandler->show_shortcuts_arr = $HeaderHandler->getShortcutPopup();

//display the header tpl file
setTemplateFolder('members/');
if($HeaderHandler->isShowPageBlock('headerBlock'))
	{
		$HeaderHandler->headerBlock['navigationBar_js_allowed'] = displayBlock(array('index.php'));
		$HeaderHandler->headerBlock['searchlist_default_url'] = (isMember())?$CFG['site']['url'].'searchList.php':$CFG['site']['url'].'searchList.php';
		$allowed_pages_array = array('viewProfile.php','myProfile.php', 'membersInvite.php','myHome.php');
		$HeaderHandler->headerBlock['left_menu_display'] = displayBlock($allowed_pages_array, false, $append_default_pages=false);

		$HeaderHandler->headerBlock['banner']['banner2']='';
		$HeaderHandler->headerBlock['banner']['banner3']='';
		$HeaderHandler->headerBlock['banner']['display']='';
		$HeaderHandler->headerBlock['banner']['class']='';
		if(!$HeaderHandler->headerBlock['left_menu_display'])
			{
				$class_main = '';

				$HeaderHandler->lnBarURL=isMember()?'../ajaxLnBarUpdater.php':'./ajaxLnBarUpdater.php';
				$HeaderHandler->lnBarURL=$CFG['site']['url'].'ajaxLnBarUpdater.php';
				if(!$HeaderHandler->chkIsProfilePage())
					{
						$HeaderHandler->intitializeLNBarVars(
						array('sideBarPhotoTagsNav', 'sideBarPhotoRightNav', 'sideBarPhotoRightRootNav',
						'sideBarMusicRightMemNav', 'sideBarGameRightNav', 'sideBarGameRightRootNav',
						'sideBarVideoRightCIDNav', 'sideBarVideoRightRootNav', 'sideBarMusicRightNav',
						'sideBarArticleRightNav', 'sideBarVideoRightNav', 'sideBarBlogsMenuNav','sideBarMembersRightNav',
						'sideBarBulletinRightNav','sideBarGroupRightNav','sideBarGroupHomeRightNav','sideBarViewFriendsRightNav',
						'sideBarMailRightNav','sideBarProfileRightNav','sideBarRelationRightNav','sideBarPhotoChannelsRightNav','sideBarVideoChannelsRightNav',
						'sideBarArticleChannelsRightNav','sideBarVideoTagsRightNav','sideBarArticleTagsRightNav','sideBarMusicChannelsRightNav',
						'sideBarMusicTagsRightNav','sideBarGameChannelsRightNav','sideBarGameTagsRightNav','sideBarFeaturedMemberRightNav','sideBarBlogsListRightNav','sideBarURLsRightNav'));
						if(isset($_SESSION['site']['lnbar']) and $left_nav_bar=$_SESSION['site']['lnbar'])
							{
								$HeaderHandler->lnBarArr[$left_nav_bar]['class']='clsSideBarLeft clsSideBarLeftActive';
								$HeaderHandler->lnBarArr[$left_nav_bar]['nav']='';
							}
						$HeaderHandler->headerBlock['banner']['class'] = ' clsNoAdVertisement';
						$HeaderHandler->headerBlock['banner']['display'] = false;
						if($HeaderHandler->headerBlock['banner']['banner2'] or $HeaderHandler->headerBlock['banner']['banner3'])
							{
								$HeaderHandler->headerBlock['banner']['class'] = ' clsHasAdVertisement';
								$allowed_pages_array = array('index.php');
								if(displayBlock($allowed_pages_array))
									{
										$HeaderHandler->headerBlock['banner']['display'] = true;
									}
							}
					}
			}
	}
if($HeaderHandler->isShowPageBlock('headerBlock'))
	{

		if($CFG['site']['is_module_page'])
			{
				$filePath=$this->CFG['site']['project_path'].$CFG['site']['is_module_page'].'/design/templates/'.$CFG['html']['template']['default'].'/'.'general/'.$CFG['site']['default_html_header_tpl'];
				if(!file_exists($filePath))
					{
						$CFG['site']['is_module_page']='';
					}
			}
		setTemplateFolder('general/',$CFG['site']['is_module_page']);
		$smartyObj->display($CFG['site']['default_html_header_tpl']);
	}
?>
