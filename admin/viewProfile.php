<?php
/**
* This file is used for admin view the user profile
 *
 * This file is having view the user profile
 *
 * PHP version 5.0
 * @category	Rayzz
 * @package		Admin
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'common/configs/config_members_profile.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/admin/viewProfile.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/gender_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/profile_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class MyProfileFormHandler begins -------------------->>>>>//
/**
 * This class is used for admin view the user profile
 *
 * @category	Rayzz
 * @package		Admin
 */
class MyProfileFormHandler extends MediaHandler
	{
		public $isValidUser = false;

		public $isCurrentUser = false;

		public $showEditableLink = false;

		/**
		 * MyProfileFormHandler::getUserDetailsArrFromDB()
		 * To get the user details from the DB
		 *
		 * @param 		string $table_name table name
		 * @param 		array $fields_arr Array of fields
		 * @param 		integer $user_id user id
		 * @return 		array
		 * @access 		public
		 */
		public function getUserDetailsArrFromDB($table_name, $fields_arr=array(), $alias_fields_arr=array())
			{
				$user_id = $this->fields_arr['user_id'];
				$sql = 'SELECT ';
				foreach($fields_arr as $field_name)
						$sql .= $field_name . ', ';
				$sql = substr($sql, 0, strrpos($sql, ','));
				$sql .= ' FROM '.$table_name.
						' WHERE user_id='.$this->dbObj->Param($user_id);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = array();
				$ret_fields_arr = array();
				if ($rs->PO_RecordCount())
					{
			          	$row = $rs->FetchRow();
					}
				$fields_arr = array_merge($fields_arr, $alias_fields_arr);
				foreach($fields_arr as $field_name)
					$ret_fields_arr[$field_name] = isset($row[$field_name]) ? $row[$field_name] : '';
				return $ret_fields_arr;
			}

		/**
		 * MyProfileFormHandler::showTheseValuesIfExistIn()
		 * Show the persional details if exist in db
		 *
		 * @param array $personalDetails persional details
		 * @return array
		 * @access 		public
		 */
		public function showTheseValuesIfExistIn($personalDetails=array())
			{
				$showTheseValuesIfExistIn_arr = array();
				if ($showTheseValuesIfExistIn_arr['personalDetails'])
					{
						$inc = 0;
						foreach($personalDetails as $key=>$value)
							{
								if (empty($value) and !$this->isEditableLinksAllowed())
									{
										continue;
									}
								else
									{
										$showTheseValuesIfExistIn_arr[$inc]['record'] = $value;
										$showTheseValuesIfExistIn_arr[$inc]['lang'] = $this->LANG['myprofile_optional_labels'][$key];
									}
								$inc++;
							}
					}
				return 	$showTheseValuesIfExistIn_arr;
			}

		/**
		 * MyProfileFormHandler::checkUserId()
		 * To check the user id is valid or not
		 *
		 * @return array
		 * @access 		public
		 */
		public function checkUserId()
			{
				$user_id = $this->fields_arr['user_id'];
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id='.$this->dbObj->Param($user_id).' AND usr_status!=\'Deleted\'';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = array();
				$this->isValidUser = ($rs->PO_RecordCount() > 0);
				$this->isCurrentUser = (strcmp($this->CFG['user']['user_id'], $user_id)==0);
				$edit = $this->fields_arr['edit'];
				$edit = (strcmp($edit, '1')==0);
				$this->showEditableLink = ($this->isCurrentUser and $edit);
			}

		/**
		 * MyProfileFormHandler::isValidUserId()
		 * To return the user id is valid or not
		 *
		 * @return boolean
		 * @access 		public
		 */
		public function isValidUserId()
			{
				return $this->isValidUser;
			}

		/**
		 * MyProfileFormHandler::setUserId()
		 * To set the user id
		 *
		 * @return
		 * @access 		public
		 */
		public function setUserId()
			{
				$userName = $this->fields_arr['user'];
				$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_name='.$this->dbObj->Param($userName).' AND usr_status!=\'Deleted\' LIMIT 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($userName));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = array();
				if ($rs->PO_RecordCount())
					{
				        $row = $rs->FetchRow();
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->isValidUser = true;
						$this->isCurrentUser = (strcmp($this->CFG['user']['user_id'], $this->fields_arr['user_id'])==0);
						$edit = $this->fields_arr['edit'];
						$edit = (strcmp($edit, '1')==0);
						$this->showEditableLink = ($this->isCurrentUser and $edit);
					}
			}

		/**
		 * MyProfileFormHandler::getCurrentUserId()
		 * To get the current user id
		 *
		 * @return int
		 * @access 		public
		 */
		public function getCurrentUserId()
			{
				return $this->fields_arr['user_id'];
			}

		/**
		 * MyProfileFormHandler::updateUserViews()
		 * To update the user views
		 *
		 * @param string $userId user id
		 * @return
		 */
		public function updateUserViews($userId='')
			{
				if(!$userId)
					return false;

				$viewed_user_id=$this->CFG['user']['user_id'];
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_views'].' SET total_views=total_views+1, last_viewed_date=now() '.
						' WHERE user_id='.$this->dbObj->Param($userId).' AND viewed_user_id='.$this->dbObj->Param($viewed_user_id).' ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($userId, $viewed_user_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if(!$this->dbObj->Affected_Rows())
					{
						$sql = ' INSERT INTO '.$this->CFG['db']['tbl']['users_views'].' SET total_views=1, last_viewed_date=now(), date_added=now()  '.
								', user_id='.$this->dbObj->Param($userId).', viewed_user_id='.$this->dbObj->Param($viewed_user_id);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($userId, $viewed_user_id));
					    if (!$rs)
						    trigger_db_error($this->dbObj);
					}
			}

		/**
		 * MyProfileFormHandler::updateProfileViewCount()
		 * To update the profile view count
		 *
		 * @return
		 * @access 		public
		 */
		public function updateProfileViewCount()
			{
				$userId = $this->getCurrentUserId();
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET profile_hits = profile_hits + 1 WHERE user_id='.$this->dbObj->Param($userId);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($userId));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$this->updateUserViews($userId);
			}

		/**
		 * MyProfileFormHandler::haveRightToViewThisProfile()
		 * To have right to view this profile
		 *
		 * @return int
		 * @access 		public
		 */
		public function haveRightToViewThisProfile()
			{
				$current = $this->CFG['user']['user_id'];
				$friend  = $this->getCurrentUserId();
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].' WHERE (owner_id='.$this->dbObj->Param($current).' AND friend_id='.$this->dbObj->Param($friend).') LIMIT 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($current, $friend));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = array();
				return $rs->PO_RecordCount();
			}

		/**
		 * MyProfileFormHandler::getUserStyle()
		 * To get user style
		 *
		 * @return
		 * @access 		public
		 */
		public function getUserStyle()
			{
				$userId = $this->getCurrentUserId();
				$sql = 'SELECT user_style FROM '.$this->CFG['db']['tbl']['users_profile_theme'].' WHERE user_id='.$this->dbObj->Param($userId);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($userId));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = array();
				$style = '';
					if ($rs->PO_RecordCount())
						{
							$row = $rs->FetchRow();
							$style = $row['user_style'];
						}
				return $style;
			}

		/**
		 * MyProfileFormHandler::isMyFriend()
		 * To check any user in friends list
		 *
		 * @param integer $user_id user id
		 * @return int
		 * @access 		public
		 */
		public function isMyFriend($user_id=0)
			{
				$friendId = $user_id;
				$ownerId = $this->CFG['user']['user_id'];
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].' WHERE (owner_id='.$this->dbObj->Param($ownerId).' AND friend_id='.$this->dbObj->Param($friendId).') LIMIT 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($ownerId, $friendId));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = array();
				return $rs->PO_RecordCount();
			}

		/**
		 * MyProfileFormHandler::displayProfileComments()
		 * To display the profile comments
		 *
		 * @param mixed $currentAccount
		 * @return array
		 * @access 		public
		 */
		public function displayProfileComments($currentAccount = false)
			{
				$limit = 4;
				$displayProfileComments_arr = array();
				$currentUserId = $this->getCurrentUserId();
				$sql = ' SELECT COUNT(users_profile_comment_id) AS cnt FROM '.$this->CFG['db']['tbl']['users_profile_comments'].' pc '.
				 ' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' u ON u.user_id = pc.comment_user_id'.
				 ' WHERE pc.profile_user_id='.$this->dbObj->Param($currentUserId).'  AND u.usr_status=\'Ok\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($currentUserId));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$displayProfileComments_arr['totalResults'] = $row['cnt'];
				if ($displayProfileComments_arr['totalResults'] > 0)
				    {
						$sql = ' SELECT users_profile_comment_id, comment, comment_user_id, u.icon_id, u.icon_type,u.image_ext,u.user_id, u.user_name, u.sex, date_added as display_date_added, total_videos, total_musics'.
							   ' FROM '.$this->CFG['db']['tbl']['users_profile_comments'].' pc '.
							   ' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' u ON u.user_id = pc.comment_user_id'.
							   ' WHERE pc.profile_user_id='.$this->dbObj->Param($currentUserId).'  AND u.usr_status=\'Ok\' ORDER BY pc.users_profile_comment_id DESC '.
							   ' LIMIT 0,'.$limit.'';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($currentUserId));
						if (!$rs)
							trigger_db_error($this->dbObj);

						$displayProfileComments_arr['row'] = array();
						$inc = 0;
						$commentedUserIcon = array();
				    		while($row = $rs->FetchRow())
							    {
									$displayProfileComments_arr['row'][$inc]['record'] = $row;
									if (!isset($commentedUserIcon[$row['comment_user_id']]))
										$commentedUserIcon[$row['comment_user_id']] = getMemberAvatarDetails($row['user_id']);
									$displayProfileComments_arr['row'][$inc]['profileIcon'] = $profileIcon = $commentedUserIcon[$row['comment_user_id']];
									$displayProfileComments_arr['row'][$inc]['online'] = '';
									$displayProfileComments_arr['row'][$inc]['commentorProfileUrl'] = 'viewProfile.php?user_id='.$row['comment_user_id'];//getMemberProfileUrl($row['comment_user_id'], $row['user_name']);
									$inc++;
			           			 } // while
				    }
				return $displayProfileComments_arr;
			}

		/**
		 * MyProfileFormHandler::getValueFromArray()
		 * To get value from array
		 *
		 * @param array $array
		 * @param string $index
		 * @return mixed
		 * @access 		public
		 */
		public function getValueFromArray($array=array(), $index='')
			{
				$value = '';
				if (is_array($array) and isset($array[$index]))
				    {
				        $value = $array[$index];
				    }
				return $value;
			}

		/**
		 * MyProfileFormHandler::displayRecord()
		 * To display the records
		 *
		 * @param string $caption
		 * @param string $text
		 * @param mixed $displayAll
		 * @return
		 * @access 		public
		 */
		public function displayRecord($caption='', $text='', $displayAll=false)
			{
				$caption = trim($caption);
				$text	 = trim($text);
				$display = (($caption and $text) OR $displayAll OR $this->isEditableLinksAllowed());
				if ($display)
				    {
?>
<tr>
	<td class="text clsProfileSideTitle"><?php echo $caption;?></td>
  	<td><?php echo ucwords($text);?></td>
</tr>
<?php
				    }
			}

		/**
		 * MyProfileFormHandler::getZodiacSign()
		 * To get Zodiac sign
		 *
		 * @param mixed $date
		 * @return
		 * @access 		public
		 */
		public function getZodiacSign($date)
			{
				list($day,$month)=explode("-",$date);
				if(($month==1 && $day>20)||($month==2 && $day<20))
					{
					        return "Aquarius";
					}
				else if(($month==2 && $day>18 )||($month==3 && $day<21))
					{
					        return "Pisces";
					}
				else if(($month==3 && $day>20)||($month==4 && $day<21))
					{
					        return "Aries";
					}
				else if(($month==4 && $day>20)||($month==5 && $day<22))
					{
					        return "Taurus";
					}
				else if(($month==5 && $day>21)||($month==6 && $day<22))
					{
					        return "Gemini";
					}
				else if(($month==6 && $day>21)||($month==7 && $day<24))
					{
					        return "Cancer";
					}
				else if(($month==7 && $day>23)||($month==8 && $day<24))
					{
					        return "Leo";
					}
				else if(($month==8 && $day>23)||($month==9 && $day<24))
					{
					        return "Virgo";
					}
				else if(($month==9 && $day>23)||($month==10 && $day<24))
					{
					        return "Libra";
					}
				else if(($month==10 && $day>23)||($month==11 && $day<23))
					{
						return "Scorpio";
					}
				else if(($month==11 && $day>22)||($month==12 && $day<23))
					{
						return "Sagittarius";
					}
				else if(($month==12 && $day>22)||($month==1 && $day<21))
					{
					        return "Capricorn";
					}
			}

		/**
		 * MyProfileFormHandler::getNextUserDetails()
		 * To get next user details
		 *
		 * @param integer $userId user id
		 * @return
		 * @access 		public
		 */
		public function getNextUserDetails($userId = 0)
			{
				$sql = 'SELECT user_id,user_name FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id>'.$this->dbObj->Param($userId).' AND usr_status=\'Ok\' ORDER BY user_id ASC LIMIT 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($userId));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$nextUserId = array();
				if ($rs->PO_RecordCount())
					{
			          	$row = $rs->FetchRow();
				     	$nextUserId['id'] = $row['user_id'];
						$nextUserId['name'] = $row['user_name'];
					}
				else
					{
						$sql = 'SELECT user_id, user_name FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id <'.$this->dbObj->Param($userId).' AND usr_status=\'Ok\' AND 1 ORDER BY user_id ASC LIMIT 1';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($userId));
						if (!$rs)
							trigger_db_error($this->dbObj);

						$row = array();
						if ($rs->PO_RecordCount())
							{
						        $row = $rs->FetchRow();
						     	$nextUserId['id'] = $row['user_id'];
								$nextUserId['name'] = $row['user_name'];
						    }
					}
				return $nextUserId;
			}

		/**
		 * MyProfileFormHandler::isEditableLinksAllowed()
		 * To check editable links allowed or not
		 *
		 * @return boolean
		 * @access 		public
		 */
		public function isEditableLinksAllowed()
			{
				return $this->showEditableLink;
			}

		/**
		 * MyProfileFormHandler::getCurrentUserOnlineStatus()
		 * To get user online status
		 *
		 * @param string $privacy privacy settings
		 * @param string $status_msg_id status message id
		 * @return mixed
		 * @access 		public
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
						$sql = 'SELECT message FROM '.$this->CFG['db']['tbl']['users_status_messages'].' WHERE status_msg_id='.$this->dbObj->Param($status_msg_id);

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

		/**
		 * MyProfileFormHandler::getPersonalInfoFormId()
		 * To get persional info from id
		 *
		 * @return mixed
		 * @access 		public
		 */
		public function getPersonalInfoFormId()
			 {
			  	$other_info=$this->CFG['profile']['personal_info'];
			 	$sql= 'SELECT id FROM '.$this->CFG['db']['tbl']['users_profile_category'].' WHERE title = '.$this->dbObj->Param('title');
			 	$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($other_info));
				  if (!$rs)
				    trigger_db_error($this->dbObj);

			 		if($row = $rs->FetchRow())
						return $form_id= $row['id'];

			 }

		/**
		 * MyProfileFormHandler::getMyPersonalInfo()
		 * To get persional info
		 *
		 * @return mixed
		 * @access 		public
		 */
		public function getMyPersonalInfo($currentAccount = false)
			{
				global $smartyObj;
			    $sql = 'SELECT id,form_id,question,question_type,rows,order_no,width,instruction,options,answer_required,error_message,default_value,max_length,display '.
							' FROM '.$this->CFG['db']['tbl']['users_profile_question'].
							' WHERE form_id='.$this->dbObj->Param('form_id').
							' ORDER BY order_no ASC ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($this->getPersonalInfoFormId()));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				$personal_info_arr = array();
				$inc=0;
				$personal_info_count=0;
				if($rs->PO_RecordCount())
					{

					while($row = $rs->FetchRow())
						{

							$answer_arr=$this->populateAnswer($row['id']);
							if($this->getQuestionType($row['id'])=='checkbox')
							{
							$answer='';
							 foreach($answer_arr as $value)
								   {
									 $answer.=$value.'/';
								   }
							 $answer=substr($answer, 0, strrpos($answer, '/'));
							}
							else
							{
							$answer=((count($answer_arr)>0)?$answer_arr[0]:'');
							}
							$ans=($answer==''?$row['default_value']:$answer);
							if($ans!='' && $ans!=$this->CFG['profile']['question_no_answer'])
							{
							$personal_info_count=1;
							$personal_info_arr[$inc]['answer_result']=$ans;
							$personal_info_arr[$inc]['form_id'] = $row['form_id'];
							$personal_info_arr[$inc]['question'] = $row['question'];
							}
							$inc++;
						}
				  }
				  if($personal_info_count==0)
				     $personal_info_arr=0;

				$smartyObj->assign('personal_info_arr', $personal_info_arr);

			}

		/**
		 * MyProfileFormHandler::populateAnswer()
		 * To populate answer
		 *
		 * @param  int $question_id question id
		 * @return mixed
		 * @access 		public
		 */
		public function populateAnswer($question_id)
			{

			  $sql = 'SELECT answer'.
					' FROM '.$this->CFG['db']['tbl']['users_profile_info'].
					' WHERE user_id='.$this->dbObj->Param('user_id').' AND question_id='.$this->dbObj->Param('question_id').' ';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt,array($this->fields_arr['user_id'],$question_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

					$answer=array();
					$inc=0;
					while($row = $rs->FetchRow())
					{
						 $answer[$inc] = $row['answer'];
						 $inc++;
					}
				return $answer;
			}

		/**
		 * MyProfileFormHandler::getQuestionType()
		 * To get question type
		 *
		 * @param  int $question_id question id
		 * @return mixed
		 * @access 		public
		 */
		public function getQuestionType($question_id)
			{
				$sql = 'SELECT question_type '.
						' FROM '.$this->CFG['db']['tbl']['users_profile_question'].
						' WHERE id='.$this->dbObj->Param('question_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($question_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['question_type'];
			}

		/**
		 * MyProfileFormHandler::displayMyFriends()
		 * To display the friends list
		 *
		 * @return mixed
		 * @access 		public
		 */
		public function displayMyFriends()
			{
				$displayMyFriends_arr = array();
				$profileUserId = $this->fields_arr['user_id'];
				$sql = 'SELECT friend_id FROM '.$this->CFG['db']['tbl']['friends_list'].' WHERE owner_id='.$this->dbObj->Param($profileUserId).' LIMIT 0,4';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($profileUserId));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$displayMyFriends_arr['record_count'] = 0;
				$row = array();
				if ($rs->PO_RecordCount())
					{
						$displayMyFriends_arr['record_count'] = 1;
						$inc = 0;
						$displayMyFriends_arr['row'] = array();
						$count = 0;
				    	while($row = $rs->FetchRow())
							{
								if(!($userDetails = getUserDetail('user_id', $row['friend_id'])))
									{
										continue;
									}
								$displayMyFriends_arr['row'][$inc]['record'] = $row;
								$count++;
								$displayMyFriends_arr['row'][$inc]['userDetails'] = $userDetails;
								$displayMyFriends_arr['row'][$inc]['friendName'] = $userDetails['user_name'];
								$displayMyFriends_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['friend_id']);
								$inc++;
						    } // while
				    }
				return $displayMyFriends_arr;
			}

		/**
		 * MyProfileFormHandler::getUserTypeName()
		 *
		 * @param mixed $usr_type
		 * @return
		 */
		public function getUserTypeName($usr_type)
			{
				$sql = 'SELECT type_name FROM '.$this->CFG['db']['tbl']['user_type_settings'].
						' WHERE type_id = '.$this->dbObj->Param($usr_type);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($usr_type));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$type_name = $this->LANG['myprofile_user_type_not_selected'];
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$type_name = $row['type_name'];
					}
				return $type_name;
			}
	}
//<<<<<---------------class MyProfileFormHandler------///
//--------------------Code begins-------------->>>>>//
$myprofile = new MyProfileFormHandler();
$myprofile->setPageBlockNames(array('msg_form_private_account','form_show_profile', 'form_preview_layout'));
$myprofile->setFormField('user_id', 0);
$myprofile->setFormField('user', 0);
$myprofile->setFormField('edit', 0);
$myprofile->setFormField('design', '');
$myprofile->setFormField('layout', '');
$myprofile->setAllPageBlocksHide();

if ($CFG['user']['usr_access'] == 'Admin' OR checkUserPermission($CFG['user']['user_actions'], 'user_manage', 'View'))
	{
		if ($myprofile->isPageGETed($_GET, 'user_id'))
		    {
		        $myprofile->sanitizeFormInputs($_GET);
				$myprofile->checkUserId();
		    }
		if ($myprofile->isPageGETed($_GET, 'user'))
		    {
		        $myprofile->sanitizeFormInputs($_GET);
				$myprofile->setUserId();
		    }
		if (isset($__myProfile)) //its declared in members/myProfile.php
		    {
		        $myprofile->setFormField('user_id', $CFG['user']['user_id']);
				$myprofile->setFormField('edit', '1');
				$myprofile->checkUserId();
		    }
		$userId = $myprofile->getFormField('user_id');
		if (!is_numeric($userId))
		    {
		        $myprofile->setFormField('user_id', intval($userId));
		    }

		if ($myprofile->isValidUserId())
		    {
				$user_details_arr = $myprofile->getUserDetailsArrFromDB($CFG['db']['tbl']['users'],
																			 array(	'user_id', 'user_name', 'password', 'sex', 'icon_type', 'image_ext', 'age', 'relation_status',
																			 		'icon_id', 'country', 'total_videos', 'total_musics', 'total_photos', 'total_friends',
																					'total_posts', 'profile_hits', 'about_me', 'web_url', 'email', 'first_name', 'last_name',
																					'theme', 'show_profile', 'show_dob', 'allow_comment', 'privacy', 'status_msg_id', 'usr_status',
																					'last_logged', 'doj', 'dob', 'dob as dob_zodiac', 'last_active', 'dob as birthday', 'usr_type',
																					'(logged_in=\'1\' AND DATE_SUB(NOW(), INTERVAL 20 SECOND) < last_active) AS logged_in_currently'
																				  ),
																			array('doj', 'last_logged', 'dob', 'dob_zodiac', 'last_active', 'birthday', 'logged_in_currently')
																			);
				$myprofile->form_show_profile['user_details_arr'] = $myprofile->user_details_arr = $user_details_arr;
				$myprofile->setPageBlockShow('form_show_profile');
				$myprofile->form_show_profile['userIcon'] = $userIcon = getMemberAvatarDetails($user_details_arr['user_id']);

			}
		else
			{
				$myprofile->setCommonErrorMsg($LANG['myprofile_msg_invalid_user']);
				$myprofile->setPageBlockShow('block_msg_form_error');
			}
	}
else
	{
		$myprofile->setCommonErrorMsg($LANG['myprofile_err_permission_denied']);
		$myprofile->setPageBlockShow('block_msg_form_error');
	}
//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//
if ($myprofile->isShowPageBlock('form_show_profile'))
    {
		$myprofile->form_show_profile['defaultTableBgColor'] = 'bgcolor = "#F1F4F6" style="font:1em Tahoma"';
		$myprofile->form_show_profile['defaultBlockTitle'] = 'bgcolor="#D1D9DF" ';
		$myprofile->form_show_profile['userProfileLink'] = getUrl('viewprofile', '?user='.$user_details_arr['user_name'], $user_details_arr['user_name'].'/', 'members');
		$myprofile->form_show_profile['currentStatus'] = $LANG['members_list_offline_status_default'];
		$myprofile->form_show_profile['onlineStatusClass'] = $onlineStatusClass = 'viewProfileOfflineStatus';
		$myprofile->form_show_profile['user_details_arr'] = $myprofile->user_details_arr;
		if ($user_details_arr['logged_in_currently'])
			{
				$myprofile->form_show_profile['currentStatus'] = $myprofile->getCurrentUserOnlineStatus($user_details_arr['privacy'], $user_details_arr['status_msg_id']);
				$myprofile->form_show_profile['onlineStatusClass'] = 'viewProfileOnlineStatus';
			}
		$myprofile->form_show_profile['details'] = $details = '';
		if($user_details_arr['sex'] !='')
			$details .= ($LANG_LIST_ARR['gender'][$user_details_arr['sex']])?$LANG_LIST_ARR['gender'][$user_details_arr['sex']].', ':'';
		$details .= ($user_details_arr['age'])?$user_details_arr['age'].', ':'';
		$relationStatus = $myprofile->getValueFromArray($LANG_LIST_ARR['user_relation_status'], $user_details_arr['relation_status']);
		$details .= ($relationStatus)?$relationStatus.', ':'';
		$country = $myprofile->getValueFromArray($LANG_LIST_ARR['countries'], $user_details_arr['country']);
		$details .= $country?$country:'';
		$myprofile->form_show_profile['details'] = $details;
		//Sex
		$myprofile->form_show_profile['sex'] = $myprofile->getValueFromArray($LANG_LIST_ARR['gender'], $user_details_arr['sex']);
		//Country
		$myprofile->form_show_profile['country'] = $myprofile->getValueFromArray($LANG_LIST_ARR['countries'], $user_details_arr['country']);
		$myprofile->form_show_profile['usr_type'] = $myprofile->getUserTypeName($user_details_arr['usr_type']);
		//Relation
		$myprofile->form_show_profile['relation'] = $myprofile->getValueFromArray($LANG_LIST_ARR['user_relation_status'], $user_details_arr['relation_status']);
		/*$temp = array_values($user_personal_details_arr);
		$temp = array_unique($temp);
		$myprofile->form_show_profile['temp'] = array_shift($temp);
		if ($temp OR $myprofile->isEditableLinksAllowed())
			{
				$myprofile->form_show_profile['showTheseValuesIfExistIn'] = $myprofile->showTheseValuesIfExistIn($user_personal_details_arr);
			}*/
		$about_me = $user_details_arr['about_me'];
		$myprofile->form_show_profile['about_me'] = trim($about_me);
		if ($myprofile->form_show_profile['about_me'] OR $myprofile->isEditableLinksAllowed())
			{
				$myprofile->form_show_profile['about_me'] = nl2br($about_me);
			}
		//$myprofile->form_show_profile['to_meet'] = $user_personal_details_arr['to_meet'];

		//all module on/off Dynamic code..
		$module_statistics_arr['row'] = array();
		$inc=0;

		foreach($CFG['site']['modules_arr'] as $value)
			{
				if(chkAllowedModule(array(strtolower($value))))
					{
						$arr_name = 'displayMy'.ucfirst($value).'s_arr';
						$$arr_name = array("record_count"=>"0");
						$smartyObj->assign($arr_name, $$arr_name);
						$function_name = 'displayMy'.ucfirst($value).'s';
						if(function_exists($function_name))
							$function_name(0, 4, $myprofile->getFormField('user_id'));
						$common_language = 'common_'.$value.'s';
						$module_statistics_arr['row'][$inc]['lang']  = $LANG[$common_language];
						//Total uploaded..
						$get_user_upload_total = 'getTotal'.ucfirst($value).'s';
						$module_statistics_arr['row'][$inc]['total_uploaded'] = '';
						if(function_exists($get_user_upload_total))
							$module_statistics_arr['row'][$inc]['total_uploaded']  = $get_user_upload_total($myprofile->getFormField('user_id'));
						//Total views..
						$get_user_total_views = 'getTotal'.ucfirst($value).'sViews';
						$module_statistics_arr['row'][$inc]['total_views'] ='';
						if(function_exists($get_user_total_views))
							$module_statistics_arr['row'][$inc]['total_views']  = $get_user_total_views($myprofile->getFormField('user_id'));
						$inc++;
					}
			}
		$myprofile->form_show_profile['module_statistics_arr'] = $module_statistics_arr;
		//Member friends
		$myprofile->form_show_profile['hasFriends'] = $user_details_arr['total_friends']>0;

		$myprofile->form_show_profile['user_name'] = str_replace('user_name', $user_details_arr['user_name'], $LANG['viewprofile_username']);
		if ($myprofile->form_show_profile['hasFriends'])
			{
				$myprofile->form_show_profile['displayMyFriends'] = $myprofile->displayMyFriends();
			}
		//Member comments
		$myprofile->form_show_profile['displayProfileComments'] = $myprofile->displayProfileComments();
		//PersonalInfo
		$myprofile->getMyPersonalInfo();
	}
$myprofile->left_navigation_div = 'generalMember';
//echo $CFG['remote_client']['ip'];
$myprofile->includeHeader();
setTemplateFolder('admin/');
$smartyObj->display('viewProfile.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
$myprofile->includeFooter();
?>
