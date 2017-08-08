<?php
/**
 * To list my subscriptions
 *
 *
 * @category	Rayzz
 * @package		Members
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/mySubscription.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_SubscriptionHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_GeneralActivityHandler.lib.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class SubscriptionHandler ----------------------->>>
/**
 * MySubscriptionHandler
 *
 * @package
 * @author shankar_044at09
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class MySubscriptionHandler extends SubscriptionHandler
	{
		/**
		 * MySubscriptionHandler::chkIsValidUser()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkIsValidUser($field_name, $err_tip='')
			{
				if($this->fields_arr[$field_name] != $this->CFG['user']['user_name'])
					{
						$user_details_arr = getUserDetail('user_name', $this->fields_arr[$field_name]);
						if(isset($user_details_arr['user_id']) and !empty($user_details_arr['user_id']))
							{
								$this->setFormField('owner_id', $user_details_arr['user_id']);
								return true;
							}
						else
							{
								$this->setFormFieldErrorTip($field_name, $err_tip);
							}
					}
				else
					{
						$this->setFormFieldErrorTip($field_name, $this->LANG['mysubscription_its_your_username']);
					}
				return false;
			}

		/**
		 * MySubscriptionHandler::populateMemberSubscription()
		 *
		 * @return
		 */
		public function populateMemberSubscription()
			{
				global $CFG;
				$sql = 'SELECT u.user_id, u.user_name, icon_id, icon_type, image_ext, sex FROM '.$CFG['db']['tbl']['subscription'].' as s '.
						' INNER JOIN '.$CFG['db']['tbl']['users'].' as u ON s.owner_id = u.user_id'.
						' WHERE u.usr_status=\'Ok\' AND s.subscriber_id='.$this->CFG['user']['user_id'].
						' AND s.status=\'Yes\' GROUP BY s.owner_id';

				$stmt = $this->dbObj->Prepare($sql);

				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_db_error($this->dbObj);

				$member_subscription_arr = array();
				$usersPerRow = $this->CFG['admin']['subscription_members_list']['cols'];
				$count = 0;
				$found = false;

				$rank = $this->fields_arr['start']+1;

				$inc = 0;
				if($rs->PO_RecordCount())
					{
						$found = true;
						while($row = $rs->FetchRow())
							{
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
					}
				$this->mem_last_tr_close = false;
				if ($found and $count and $count<$usersPerRow)
					{
					 	$this->mem_last_tr_close  = true;
					 	$this->mem_user_per_row= $usersPerRow-$count;
					}
				return $member_subscription_arr;
			}

		/**
		 * MySubscriptionHandler::populateCategorySubscription()
		 *
		 * @return void
		 */
		public function populateSubscribedCategories()
			{
				$file_name = $this->CFG['site']['project_path'].'common/classes/class_'.ucfirst($this->fields_arr['category_module']).'Handler.lib.php';
				if(file_exists($file_name))
					{
						require_once($file_name);
						$class = ucfirst($this->fields_arr['category_module']).'Handler';
						$obj = $this->fields_arr['category_module'].'Handler';
						$$obj = new $class();
						$method = 'populate'.ucfirst($this->fields_arr['category_module']).'CategoriesListForSubscription';
						$$obj->$method();
					}
			}

		/**
		 * MySubscriptionHandler::populateTagSubscription()
		 *
		 * @return
		 */
		public function populateSubscribedTags()
			{
				$file_name = $this->CFG['site']['project_path'].'common/classes/class_'.ucfirst($this->fields_arr['tag_module']).'Handler.lib.php';
				if(file_exists($file_name))
					{
						require_once($file_name);
						$class = ucfirst($this->fields_arr['tag_module']).'Handler';
						$obj = $this->fields_arr['tag_module'].'Handler';
						$$obj = new $class();
						$method = 'populate'.ucfirst($this->fields_arr['tag_module']).'TagListForSubscription';
						$$obj->$method();
					}
			}
	}
//<<<<<---------------class SubscriptionHandler------///
//--------------------Code begins-------------->>>>>//
$mysubscription = new MySubscriptionHandler();
if(!chkAllowedModule(array('subscription')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$mysubscription->setPageBlockNames(array('member_subscription', 'category_subscription', 'tag_subscription'));
$mysubscription->setFormField('subscriber_id', $CFG['user']['user_id']);
$mysubscription->setFormField('owner_id', 0);
$mysubscription->setFormField('category_id', 0);
$mysubscription->setFormField('sub_category_id', 0);
$mysubscription->setFormField('tag', '');
$mysubscription->setFormField('sub_module', '');
$mysubscription->setFormField('category_module', '');
$mysubscription->setFormField('tag_module', '');
$mysubscription->setFormField('sub_type', '');
$mysubscription->setFormField('action', '');
$mysubscription->setFormField('pg', 'member_subcription');

$mysubscription->setFormField('activity_type', '');
$mysubscription->setFormField('action', '');
$mysubscription->setFormField('suggestion_id', '');
$mysubscription->setFormField('user_name', '');

//Generate Modules
$inc = 0;
$sub_module_arr = array();
foreach($CFG['site']['modules_arr'] as $value)
	{
		if(chkAllowedModule(array(strtolower($value))) and chkIsSubscriptionEnabledForModule($value))
			{
				$sub_module_arr[$inc] = $value;
				$inc++;
			}
	}
$mysubscription->sub_module_arr = $sub_module_arr;

$mysubscription->sanitizeFormInputs($_REQUEST);

if($CFG['admin']['show_recent_activities'])
	{
		$GeneralActivity = new GeneralActivityHandler();
	}

if(!isAjaxPage())
	{
		$mysubscription->setAllPageBlocksHide();
		$mysubscription->setPageBlockShow($mysubscription->getFormField('pg'));

		if ($mysubscription->isFormPOSTed($_REQUEST, 'member_submit'))
			{
				$mysubscription->chkIsNotEmpty('user_name', $LANG['common_err_tip_required']) and
					$mysubscription->chkIsValidUser('user_name',  $LANG['mysubscription_invalid_user']);

				$mysubscription->setAllPageBlocksHide();
				$mysubscription->setPageBlockShow($mysubscription->getFormField('pg'));

				if($mysubscription->isValidFormInputs())
					{
		    			//Check whether user is previously subscribed to owner
						$user_previously_subscribed_forsub = $mysubscription->chkIsUserSubscribedToOwner($mysubscription->getFormField('owner_id'));

						$fmodule_arr = $mysubscription->getFormField('sub_module');
						foreach($mysubscription->sub_module_arr as $smodule)
							{
								//Subscribe if selected
								if(!empty($fmodule_arr) and in_array($smodule, $fmodule_arr))
									{
										$mysubscription->setFormField('sub_module', $smodule);
										$mysubscription->subscribeUser();
									}
								else //unsubscribe
									{
										$mysubscription->setFormField('sub_module', $smodule);
										$mysubscription->unSubscribeUser();
									}
							}
						//Check whether user is previously subscribed to owner
						$user_previously_subscribed_forunsub = $mysubscription->chkIsUserSubscribedToOwner($mysubscription->getFormField('owner_id'));

						//Add Activity
						if($CFG['admin']['show_recent_activities'] and !$user_previously_subscribed_forsub)
							{
								$GeneralActivity->activity_arr['action_key'] = 'subscribed';
								$GeneralActivity->activity_arr['owner_id'] = $mysubscription->getFormField('owner_id');
								$GeneralActivity->activity_arr['subscriber_id'] = $mysubscription->getFormField('subscriber_id');
								$GeneralActivity->activity_arr['content_id'] = 0;
								$GeneralActivity->addActivity($GeneralActivity->activity_arr);
							}
						//Remove Activity
						if($CFG['admin']['show_recent_activities'] and !$user_previously_subscribed_forunsub)
							{
								$GeneralActivity->activity_arr['action_key'] = 'unsubscribed';
								$GeneralActivity->activity_arr['owner_id'] = $mysubscription->getFormField('owner_id');
								$GeneralActivity->activity_arr['subscriber_id'] = $mysubscription->getFormField('subscriber_id');
								$GeneralActivity->activity_arr['content_id'] = 0;
								$GeneralActivity->addActivity($GeneralActivity->activity_arr);
							}

						$mysubscription->setFormField('user_name', '');
						$mysubscription->setAllPageBlocksHide();
						$mysubscription->setPageBlockShow('block_msg_form_success');
						$mysubscription->setCommonSuccessMsg($LANG['mysubscription_subscription_added']);
						$mysubscription->setPageBlockShow($mysubscription->getFormField('pg'));
					}
				else
					{
						$mysubscription->setAllPageBlocksHide();
						$mysubscription->setPageBlockShow('block_msg_form_error');
						$mysubscription->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$mysubscription->setPageBlockShow($mysubscription->getFormField('pg'));
					}
			}
		else if ($mysubscription->isFormPOSTed($_REQUEST, 'category_submit'))
			{
				$mysubscription->chkIsNotEmpty('sub_module', $LANG['common_err_tip_required']);
					$mysubscription->chkIsNotEmpty('category_id', $LANG['common_err_tip_required']);

				$mysubscription->setAllPageBlocksHide();
				$mysubscription->setPageBlockShow($mysubscription->getFormField('pg'));

				if($mysubscription->isValidFormInputs())
					{
						if($mysubscription->getFormField('sub_category_id') != '')
							$mysubscription->setFormField('category_id', $mysubscription->getFormField('sub_category_id'));
						$mysubscription->subscribeToCategory();
						$mysubscription->setAllPageBlocksHide();
						$mysubscription->setPageBlockShow('block_msg_form_success');
						$mysubscription->setCommonSuccessMsg($LANG['mysubscription_subscription_added']);
						$mysubscription->setPageBlockShow($mysubscription->getFormField('pg'));
						$mysubscription->setFormField('sub_module', '');
					}
				else
					{
						$mysubscription->setAllPageBlocksHide();
						$mysubscription->setPageBlockShow('block_msg_form_error');
						$mysubscription->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$mysubscription->setPageBlockShow($mysubscription->getFormField('pg'));
					}
			}
		else if ($mysubscription->isFormPOSTed($_REQUEST, 'tag_submit'))
			{
				$mysubscription->chkIsNotEmpty('sub_module', $LANG['common_err_tip_required']);
					$mysubscription->chkIsNotEmpty('tag', $LANG['common_err_tip_required']);

				$mysubscription->setAllPageBlocksHide();
				$mysubscription->setPageBlockShow($mysubscription->getFormField('pg'));

				if($mysubscription->isValidFormInputs())
					{
						$mysubscription->subscribeToTag();
						$mysubscription->setAllPageBlocksHide();
						$mysubscription->setPageBlockShow('block_msg_form_success');
						$mysubscription->setCommonSuccessMsg($LANG['mysubscription_subscription_added']);
						$mysubscription->setPageBlockShow($mysubscription->getFormField('pg'));
						$mysubscription->setFormField('sub_module', '');
						$mysubscription->setFormField('tag', '');
					}
				else
					{
						$mysubscription->setAllPageBlocksHide();
						$mysubscription->setPageBlockShow('block_msg_form_error');
						$mysubscription->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$mysubscription->setPageBlockShow($mysubscription->getFormField('pg'));
					}
			}
	}
$mysubscription->active_member_class = $mysubscription->active_category_class = $mysubscription->active_tag_class = '';
$active_class = ' class="clsActiveSubscription"';
if($mysubscription->isShowPageBlock('member_subscription'))
	{
		$mysubscription->member_subscription_arr = $mysubscription->populateMemberSubscription();
		$mysubscription->active_member_class = $active_class;
	}
elseif($mysubscription->isShowPageBlock('category_subscription'))
	{
		$mysubscription->category_filter_arr = array();
		$inc = 0;
		foreach($mysubscription->sub_module_arr as $cat_module)
			{
				$mysubscription->category_filter_arr[$inc]['url'] = getUrl('mysubscription', '?pg=category_subscription&category_module='.$cat_module, 'category_subscription/?category_module='.$cat_module, 'members');
				$mysubscription->category_filter_arr[$inc]['display_val'] = $cat_module;
				$inc++;
			}
		$mysubscription->display_category_module = '';
		if(count($mysubscription->sub_module_arr) == 1)
			{
				$mysubscription->display_category_module = ' style="display:none;"';
				$mysubscription->category_module = $mysubscription->sub_module_arr[0];
				$mysubscription->setFormField('category_module', $mysubscription->category_module);
			}
		$mysubscription->active_category_class = $active_class;
	}
elseif($mysubscription->isShowPageBlock('tag_subscription'))
	{
		$mysubscription->tag_filter_arr = array();
		$inc = 0;
		foreach($mysubscription->sub_module_arr as $cat_module)
			{
				$mysubscription->tag_filter_arr[$inc]['url'] = getUrl('mysubscription', '?pg=tag_subscription&tag_module='.$cat_module, 'tag_subscription/?tag_module='.$cat_module, 'members');
				$mysubscription->tag_filter_arr[$inc]['display_val'] = $cat_module;
				$inc++;
			}
		$mysubscription->display_tag_module = '';
		if(count($mysubscription->sub_module_arr) == 1)
			{
				$mysubscription->display_tag_module = ' style="display:none;"';
				$mysubscription->tag_module = $mysubscription->sub_module_arr[0];
				$mysubscription->setFormField('tag_module', $mysubscription->tag_module);
			}
		$mysubscription->active_tag_class = $active_class;
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
$smartyObj->display('mySubscription.tpl');
if($mysubscription->isShowPageBlock('member_subscription') and $CFG['feature']['jquery_validation'])
	{
?>
<script type="text/javascript">
	$Jq("#form_membersubscription").validate({
		rules: {
				user_name: {
					required: true
			    }
		},
		messages: {
				user_name: {
					required: "<?php echo $mysubscription->LANG['common_err_tip_compulsory'];?>"
				}
		}
	});
</script>
<?php
	}
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$mysubscription->includeFooter();
?>