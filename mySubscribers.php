<?php
/**
 * Members Index
 *
 *
 * @category	Rayzz
 * @package		Members
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/mySubscribers.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_SubscriptionHandler.lib.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class SubscriptionHandler ----------------------->>>
/**
 * MySubscribersHandler
 *
 * @package
 * @author shankar_044at09
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class MySubscribersHandler extends SubscriptionHandler
	{
		/**
		 * MySubscribersHandler::buildConditionQuery()
		 *
		 * @return void
		 */
		public function buildConditionQuery()
			{
				$this->sql_condition = ' u.usr_status=\'Ok\' AND s.owner_id='.$this->CFG['user']['user_id'].
											' AND s.status=\'Yes\'';
			}

		/**
		 * MySubscribersHandler::populateMemberSubscription()
		 *
		 * @return array
		 */
		public function populateMemberSubscription()
			{
				$member_subscription_arr = array();
				$usersPerRow = $this->CFG['admin']['mysubscribers_list']['cols'];
				$count = 0;
				$found = false;

				$rank = $this->fields_arr['start']+1;

				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						$found = true;
						$member_subscription_arr[$inc]['memberProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
						$joined = 0;
						$member_subscription_arr[$inc]['profileIcon']= getMemberAvatarDetails($row['user_id']);
						$member_subscription_arr[$inc]['open_tr'] = false;

						if ($count%$usersPerRow==0)
						    {
						    	$member_subscription_arr[$inc]['open_tr'] = true;
						    }

						$member_subscription_arr[$inc]['record'] = $row;

						$member_subscription_arr[$inc]['end_tr'] = false;
						$count++;
						if ($count%$usersPerRow==0)
						    {
								$count = 0;
								$member_subscription_arr[$inc]['end_tr'] = true;
						    }
						$inc++;
					}// while
				$this->mem_last_tr_close = false;
				if ($found and $count and $count<$usersPerRow)
					{
					 	$this->mem_last_tr_close  = true;
					 	$this->mem_user_per_row= $usersPerRow-$count;
					}
				return $member_subscription_arr;
			}
	}
//<<<<<---------------class SubscriptionHandler------///
//--------------------Code begins-------------->>>>>//
$mysubscription = new MySubscribersHandler();
if(!chkAllowedModule(array('subscription')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$mysubscription->setPageBlockNames(array('subscribers_list'));
$mysubscription->setFormField('owner_id', $CFG['user']['user_id']);
$mysubscription->setFormField('start', 0);

$mysubscription->setTableNames(array($CFG['db']['tbl']['subscription'].' as s '.' INNER JOIN '.$CFG['db']['tbl']['users'].' as u ON s.subscriber_id = u.user_id'));
$mysubscription->setReturnColumns(array('u.user_id', 'u.user_name', 'icon_id', 'icon_type', 'image_ext', 'sex'));

$mysubscription->setAllPageBlocksHide();
$mysubscription->setPageBlockShow('subscribers_list');

$mysubscription->sanitizeFormInputs($_REQUEST);

if($mysubscription->isShowPageBlock('subscribers_list'))
	{
		$mysubscription->buildSelectQuery();
		$mysubscription->buildConditionQuery();
		$mysubscription->buildSortQuery();
		$mysubscription->buildQuery();
		$mysubscription->executeQuery();
		//$mysubscription->printQuery();
		$mysubscription->member_subscription_arr = $mysubscription->populateMemberSubscription();
		$smartyObj->assign('smarty_paging_list', $mysubscription->populatePageLinksGET($mysubscription->getFormField('start'), array()));
	}
//<<<<--------------------Code Ends----------------------//
//include the header file
$mysubscription->includeHeader();
?>
<script type="text/javascript">
	var block_arr = new Array('selMsgConfirmCommon');
</script>
<?php
//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('mySubscribers.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$mysubscription->includeFooter();
?>