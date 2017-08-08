<?php
/**
 * File to list activities
 *
 * @category	Framework
 * @package
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/myHome.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$memberListCase = array('friends','my');
if (isset($_REQUEST['pg']) AND in_array($_REQUEST['pg'],$memberListCase))
	{
		$CFG['auth']['is_authenticate'] = 'members';
	}
else
		$CFG['auth']['is_authenticate'] = false;
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ActivityHandler.lib.php';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');


//-------------------------class ActivityPageHandler-------------------->>>
/**
 * ActivityPageHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class ActivityPageHandler extends MediaHandler
	{
		/**
		 * ActivityPageHandler::setActivityHandlerObject()
		 *
		 * @param string $Activity
		 * @return void
		 */
		public function setActivityHandlerObject($Activity='')
			{
				$this->ActivityObj = $Activity;
			}

		/**
		 * ActivityPageHandler::getUsersByActivityType()
		 *
		 * @return string
		 */
		public function getUsersByActivityType()
			{
				$this->users_id = '';
				switch($this->fields_arr['pg'])
					{
						case 'friends':
							$this->users_id = 'AND EXISTS (SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_list'].' fl WHERE fl.friend_id = '.$this->CFG['user']['user_id'].' AND fl.owner_id = actor_id)';
							break;
						case 'my':
							$this->users_id = 'AND actor_id = '.$this->CFG['user']['user_id'];
							break;
						case 'all':
							$this->users_id = 'all';
							break;
					}
				$this->users_id;
			}

		/**
		 * ActivityPageHandler::buildConditionQuery()
		 *
		 * @return void
		 */
		public function buildConditionQuery()
			{
				$interval_by = strtolower($this->CFG['admin']['myhome']['recent_activities_interval_by']);

				$this->sql_condition = 'status=\'Yes\''.
										' AND  DATE_FORMAT( date_added, \'%Y-%m-%d\' ) >'.
										' DATE_SUB(CURDATE(), INTERVAL '.$this->CFG['admin']['myhome']['recent_activities_interval'].' '.$interval_by.')
										AND (SELECT usr_status FROM '.$this->CFG['db']['tbl']['users'].
										' WHERE user_id = owner_id) = \'Ok\' AND ( SELECT usr_status FROM '.$this->CFG['db']['tbl']['users'].
										' WHERE user_id = actor_id) = \'Ok\'';
				if($this->users_id == 'all')
					{
						/*$this->sql_condition .= 'AND owner_id NOT IN ('.$this->CFG['user']['user_id'].')'.
											' AND actor_id NOT IN ('.$this->CFG['user']['user_id'].')';*/
					}
				elseif($this->users_id != '')
					$this->sql_condition .= $this->users_id;
				if ($this->fields_arr['module'] == 'general' AND (!isset($_REQUEST['pg'])) OR chkAllowedModule(array($this->fields_arr['module'])) )
				{
					$this->sql_condition .= ' AND module = \''.addslashes($this->fields_arr['module']).'\'';
				}
				elseif(!isset($_REQUEST['pg']))
					$this->sql_condition .= ' AND module = \'general\'';
			}

		/**
		 * ActivityPageHandler::buildSortQuery()
		 *
		 * @return void
		 */
		public function buildSortQuery()
			{
				$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}

		/**
		 * ActivityPageHandler::populateAllActivities()
		 *
		 * @return void
		 */
		public function populateAllActivities()
			{
				global $smartyObj;
				$populateActivities_arr = array();
				$module_arr = array();

				$inc = 0;
	    		while($row = $this->fetchResultRecord())
				    {
						if($row['module'] == 'general')
				    		{
								$populateActivities_arr[$row['module']][] = $row['child_id'];
								$module_arr[$inc]['parent_id'] = $row['parent_id'];
								$module_arr[$inc]['module'] = $row['module'];
								$module_arr[$inc]['file_name'] = $row['module'].'Activity.tpl';
								$inc++;
							}
						elseif(chkAllowedModule(array($row['module'])))
							{
								$populateActivities_arr[$row['module']][] = $row['child_id'];
								$module_arr[$inc]['parent_id'] = $row['parent_id'];
								$module_arr[$inc]['module'] = $row['module'];
								$module_arr[$inc]['file_name'] = $row['module'].'Activity.tpl';
								$inc++;
							}
				    }
				$this->ActivityObj->getActivities($populateActivities_arr);
				$smartyObj->assign('module_arr', $module_arr);
			}

		/**
		 * ActivityPageHandler::myHomeActivity()
		 *
		 * @return void
		 */
		public function myHomeActivity($totRecords = 10)
			{
				global $smartyObj;
				setTemplateFolder('members/');
				$smartyObj->assign('activitiesView', $totRecords);
				$smartyObj->display('myHomeActivity.tpl');
			}
	}
//<<<<<---------------class ActivityPageHandler------///
//--------------------Code begins-------------->>>>>//
$ViewActivity = new ActivityPageHandler();
$ViewActivity->setPageBlockNames(array('block_activities'));
$ViewActivity->setAllPageBlocksHide();

$ViewActivity->setFormField('pg', '');
$ViewActivity->setFormField('module', 'general');
$ViewActivity->setFormField('user_id', $CFG['user']['user_id']);
/*********** Page Navigation Start *********/
$ViewActivity->setFormField('orderby_field', 'date_added');
$ViewActivity->setFormField('orderby', 'DESC');
$ViewActivity->setTableNames(array($CFG['db']['tbl']['activity']));
$ViewActivity->setReturnColumns(array('module', 'parent_id', 'owner_id', 'actor_id', 'child_id'));
/************ page Navigation stop *************/

$ViewActivity->sanitizeFormInputs($_REQUEST);

if($ViewActivity->getFormField('pg') == '')
	$ViewActivity->setFormField('pg', $CFG['admin']['myhome']['recent_activity_default_content']);

$Activity = new ActivityHandler();
$ViewActivity->setActivityHandlerObject($Activity);

$ViewActivity->getUsersByActivityType();

$ViewActivity->activity_friends_url = getUrl('activity', '?pg=friends', 'friends/updates/', 'members');
$ViewActivity->activity_my_url = getUrl('activity', '?pg=my', 'my/updates/', 'members');
$ViewActivity->activity_all_url = getUrl('activity', '?pg=all', 'all/updates/', 'members');

if($ViewActivity->users_id)
	{
		$ViewActivity->setPageBlockShow('block_activities');
	}
else
	{
		switch($ViewActivity->getFormField('pg'))
			{
				case 'friends':
					$ViewActivity->setCommonErrorMsg($LANG['myhome_recent_activities_no_friends']);
					break;
				case 'my':
					$ViewActivity->setCommonErrorMsg($LANG['myhome_my_recent_activities_no_records']);;
					break;
				default:
					$ViewActivity->setCommonErrorMsg($LANG['myhome_recent_activities_no_records']);
					break;
			}
		$ViewActivity->setPageBlockShow('block_msg_form_error');
	}

if($ViewActivity->isShowPageBlock('block_activities'))
	{
		$ViewActivity->buildSelectQuery();
		$ViewActivity->buildConditionQuery();
		$ViewActivity->buildSortQuery();
		$ViewActivity->buildQuery();
		$ViewActivity->executeQuery();
		//$ViewActivity->printQuery();

		$ViewActivity->populateAllActivities();

		if($ViewActivity->isResultsFound())
			{
				$paging_arr = array();
				if($CFG['feature']['rewrite_mode'] == 'normal')
					$paging_arr = array('pg');
				$smartyObj->assign('smarty_paging_list', $ViewActivity->populatePageLinksGET($ViewActivity->getFormField('start'), $paging_arr));
			}
		else
			{
				switch($ViewActivity->getFormField('pg'))
					{
						case 'friends':
							$ViewActivity->setCommonErrorMsg($LANG['myhome_recent_activities_no_friends']);
							break;
						case 'my':
							$ViewActivity->setCommonErrorMsg($LANG['myhome_my_recent_activities_no_records']);;
							break;
						default:
							$ViewActivity->setCommonErrorMsg($LANG['myhome_recent_activities_no_records']);
							break;
					}
				$ViewActivity->setPageBlockShow('block_msg_form_error');
			}
	}
$ViewActivity->includeHeader();
//include the content of the page
?>
<script language="javascript" type="text/javascript">
	<?php if($CFG['admin']['show_recent_activities']) { ?>
		var show_div = 'selActivity<?php echo ucfirst($ViewActivity->getFormField('pg')); ?>Content';
		var more_tabs_div = new Array('selActivityFriendsContent', 'selActivityMyContent', 'selActivityAllContent');
		var more_tabs_class = new Array('selHeaderActivityFriends', 'selHeaderActivityMy', 'selHeaderActivityAll');
		//var hide_ajax_tabs = new Array('flag_content_tab', 'favorite_content_tab', 'email_content_tab');
		var current_active_tab_class = 'clsActiveMoreVideosNavLink';

		$Jq(document).ready(function(){
			//To Show the default div and hide the other divs
			unhighlightMoreTabsDivs(show_div); //To hide the more tabs div and set the class to empty
			highlightMoreTabsDivs(show_div); //To show the more tabs div and set the class to selected
		});
	<?php } ?>

</script>
<?php
setTemplateFolder('members/');
$smartyObj->display('activity.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$ViewActivity->includeFooter();
?>