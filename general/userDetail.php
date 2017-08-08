<?php
//--------------class userDetail--------------->>>//
/**
 * userDetail
 * This class is used to view the user detail in popup
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class userDetail extends FormHandler
    {
		/**
		 * to display embed content
		 *
		 * @return 		string
		 * @access 		public
		 */
		public function displayUserDetails()
			{
				$displayUserDetails_arr = array();
				$displayUserDetails_arr['uid'] = $this->fields_arr['uid'];
				$sql = 'SELECT user_id, user_name, first_name,last_name,profile_hits, total_photos, total_videos, total_articles, total_friends'.
						', total_musics,  icon_id, icon_type, image_ext,  sex, age, country, city, privacy, show_dob '.
						' , (logged_in=\'1\'  AND DATE_SUB(NOW(), INTERVAL 20 SECOND) < last_active) as logged_in_currently, status_msg_id '.
						' FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE usr_status=\'Ok\' AND user_id='.$this->dbObj->Param($displayUserDetails_arr['uid']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($displayUserDetails_arr['uid']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$displayUserDetails_arr['record'] = $rs->FetchRow();
				$displayUserDetails_arr['icon']   = getMemberAvatarDetails($displayUserDetails_arr['record']['user_id']);
				$displayUserDetails_arr['getMemberProfileUrl']   = getMemberProfileUrl($displayUserDetails_arr['record']['user_id'], $displayUserDetails_arr['record']['user_name']);

				if(isMember())
					{
						$displayUserDetails_arr['friend'] = '';
						$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].
								' WHERE friend_id='.$this->dbObj->Param('friend_id1').
								' AND owner_id='.$this->dbObj->Param('owner_id1');
						$fields_val_arr = array($displayUserDetails_arr['record']['user_id'], $this->CFG['user']['user_id']);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $fields_val_arr);
						if (!$rs)
							trigger_db_error($this->dbObj);

						if ($rs->PO_RecordCount())
							{
								$displayUserDetails_arr['friend'] = 'yes';
						    }
					}
				 $displayUserDetails_arr['online'] = $this->CFG['admin']['members']['offline_anchor_attributes'];
				 $displayUserDetails_arr['currentStatus'] = $this->LANG['members_list_offline_status_default'];
				 $displayUserDetails_arr['onlineStatusClass'] = 'memListUserStatusOffline';
				 if($this->CFG['admin']['members_listing']['online_icon'] and $displayUserDetails_arr['record']['logged_in_currently'])
					 {
					 	 $displayUserDetails_arr['currentStatus'] = $this->getCurrentUserOnlineStatus($displayUserDetails_arr['record']['privacy'], $displayUserDetails_arr['record']['status_msg_id']);
						 $onlineAnchorAttr = $this->CFG['admin']['members']['online_anchor_attributes'];
						 $displayUserDetails_arr['online'] = str_replace('{online_status}', $displayUserDetails_arr['currentStatus'], $onlineAnchorAttr);
						 $displayUserDetails_arr['onlineStatusClass'] = 'memListUserStatusOnline';
					 }

				$displayUserDetails_arr['friendAddUrl'] = getUrl('friendadd', '?friend='.$displayUserDetails_arr['record']['user_id'], '?friend='.$displayUserDetails_arr['record']['user_id'], 'members');
				$displayUserDetails_arr['mailComposeUrl'] = getUrl('mailcompose', '?mcomp='.$displayUserDetails_arr['record']['user_name'], '?mcomp='.$displayUserDetails_arr['record']['user_name'], 'members');
				return $displayUserDetails_arr;
			}

		/**
		 * userDetail::getCurrentUserOnlineStatus()
		 *
		 * @param string $privacy
		 * @param string $status_msg_id
		 * @return
		 */
		public function getCurrentUserOnlineStatus($privacy='', $status_msg_id='')
			{
				$currentStatus = $this->LANG['members_list_online_status_default'];
				$Online = $Offline = $Custom = false;
				if ($privacy)
				    {
				        $$privacy = true;
				    }
				if ($Online)
				    {
						$currentStatus = $this->LANG['members_list_online_status_online'];
				    }
				elseif($Offline)
					{
						$currentStatus = $this->LANG['members_list_online_status_offline'];
					}
				elseif($Custom AND $status_msg_id)
					{
						$sql = 'SELECT message FROM '.$this->CFG['db']['tbl']['users_status_messages'].
								' WHERE status_msg_id='.$this->dbObj->Param($status_msg_id);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($status_msg_id));
						if (!$rs)
							trigger_db_error($this->dbObj);

						if ($rs->PO_RecordCount())
							{
								$row = $rs->FetchRow();
								$currentStatus = $row['message'];
								$rs->Free();
						    }
					}
				return $currentStatus;
			}
    }
//<<<<<---------------- Class ContactUsHandler ends -------------//
//--------------------- Code begins -------------------->>>>>//
$userinfo = new userDetail();
$userinfo->setDBObject($db);
$userinfo->makeGlobalize($CFG, $LANG);
$userinfo->setFormField('uid', '');
$userinfo->setFormField('option', '');
$userinfo->sanitizeFormInputs($_REQUEST);
if ($userinfo->isFormGETed($_REQUEST, 'uid'))
	{
		ob_start();
		$userinfo->displayUserDetails_arr = $userinfo->displayUserDetails();
	}
$userinfo->includeAjaxHeader();
setTemplateFolder('general/');
if($userinfo->getFormField('option') == 'L')
	{
		$smartyObj->display('userDetailLeft.tpl');
	}
elseif($userinfo->getFormField('option') == 'R')
	{
		$smartyObj->display('userDetailRight.tpl');
	}
$userinfo->includeAjaxFooter();
?>