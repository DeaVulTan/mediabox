<?php
/**
 * Class to handle the article module
 *
 * This is having class ArticleHandler to handle
 *
 *
 * @category	Rayzz
 * @package		Common/Classes
 */
//------------------- Class ActivityHandler begins ------------------->>>>>//
class ActivityHandler
	{

		private $dbObj;

		private $CFG = array();

		private $LANG = array();

		public function __construct()
			{
				global $CFG, $LANG, $db;
				$this->dbObj 	= $db;
				$this->CFG 		= $CFG;
				$this->LANG 	= $LANG;
			}

		/**
		 * ActivityHandler::setActivityType()
		 *
		 * @param string $activity_type
		 * @param string $module
		 * @return void
		 */
		public function setActivityType($activity_type, $module = '',$limit='')
			{
				if (!$limit)
					$limit = $this->CFG['admin']['myhome']['total_recent_activities'];
				switch($activity_type)
					{

						case 'friends':
							$friend_id = $this->populateFriendDetails();
							if($friend_id)
								$this->populateActivities($limit, $module, $friend_id);
							break;
						case 'my':
							$this->populateActivities($limit, $module, $this->CFG['user']['user_id']);
							break;
						case 'all':
							$this->populateActivities($limit, $module, 'all');
							break;

					} // switchs
			}

		/**
		 * ActivityHandler::displayActivities()
		 *
		 * @param integer $num_records
		 * @param string $module
		 * @param string $user_id
		 * @return void
		 */
		public function populateActivities($num_records, $module, $user_id = '')
			{
				global $smartyObj;
				$populateActivities_arr = array();
				$module_arr = array();

				$interval_by = strtolower($this->CFG['admin']['myhome']['recent_activities_interval_by']);

				$condition = ' AND DATE_FORMAT( date_added, \'%Y-%m-%d\' ) >'.
								' DATE_SUB(CURDATE(), INTERVAL '.$this->CFG['admin']['myhome']['recent_activities_interval'].' '.$interval_by.') ';
				//$condition = '';
				if($user_id == 'all')
					{
						/*$condition = 'AND owner_id NOT IN ('.$this->CFG['user']['user_id'].')'.
										' AND actor_id NOT IN ('.$this->CFG['user']['user_id'].')';*/
					}
				elseif($user_id != '')
					$condition = ' AND actor_id IN ('.$user_id.')';

				if($module != '')
					$condition .= ' AND module=\''.$module.'\'';

				$sql = 'SELECT module, parent_id, owner_id, actor_id, child_id'.
						' FROM '.$this->CFG['db']['tbl']['activity'].
						' WHERE status=\'Yes\' '.$condition.
						' ORDER BY date_added DESC LIMIT 0,'.$num_records;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($record_count=$rs->PO_RecordCount())
					{
						$inc = 0;
			    		while($row = $rs->FetchRow())
						    {
								$user1_details = getUserDetail('user_id', $row['owner_id']);
								$user2_details = getUserDetail('user_id', $row['actor_id']);
								if(!empty($user1_details) AND !empty($user2_details))
									{
										if (chkAllowedModule(array($row['module']))
											AND in_array($row['module'], $this->CFG['site']['modules_arr'])
												OR $row['module'] == 'general')
											{
												$populateActivities_arr[$row['module']][] = $row['child_id'];
												$module_arr[$inc]['parent_id'] = $row['parent_id'];
												$module_arr[$inc]['module'] = $row['module'];
												//Total Activitity >4  view all link visible
												$module_arr[$inc]['total_count'] = $record_count;
												$module_arr[$inc]['file_name'] = $row['module'].'Activity.tpl';
												$inc++;
											}
									}
	 					    }
	 					if(!empty($populateActivities_arr))
							$this->getActivities($populateActivities_arr);
						$smartyObj->assign('module_total_records', $inc-1);
					}
				$smartyObj->assign('module_arr', $module_arr);
			}

		/**
		 * ActivityHandler::getActivities()
		 *  Including classes, creating objects dynamically and calling the
		 *  method to get activities.
		 *
		 * @param array $activities_arr
		 * @return void
		 */
		public function getActivities($activities_arr)
			{
				global $smartyObj;
				$getActivities_arr = array();
				$inc = 0;

				foreach($activities_arr as $key=>$value)
					{
				    	if (chkAllowedModule(array($key))
							AND in_array($key, $this->CFG['site']['modules_arr'])
								OR $key == 'general')
				    		{
								$file_name = $this->CFG['site']['project_path'].'common/classes/class_'.ucfirst($key).'ActivityHandler.lib.php';

								if(file_exists($file_name))
									{
										require_once($file_name);
										$class = $key.'ActivityHandler';
										$obj = $key.'Activity';

										if(!isset($$obj))
											{
												$$obj = new $class();
											}

										$$obj->getActivities($value);
									}
							}
						$inc++;
					}
			}

		/**
		 * ActivityHandler::populateFriendDetails()
		 *
		 * @return string
		 */
		public function populateFriendDetails()
			{
				$populateFriendDetails_arr = array();
				$sql = 'SELECT friend_id as user_friend_id'.
						' FROM '.$this->CFG['db']['tbl']['friends_list'].
						' WHERE owner_id = '.$this->dbObj->Param('owner_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$populateFriendDetails_arr[] = $row['user_friend_id'];
	 					    }
						$friend_ids = implode(',', $populateFriendDetails_arr);
						return $friend_ids;
					}
				return false;
			}
	}
?>