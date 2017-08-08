<?php
/**
 * This file handle members
 *
 *
 * @category	Rayzz
 * @package		Members
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_GeneralActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_SubscriptionHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class MemberHandling--------------->>>//
/**
 * MemberHandling
 *
 * @package
 * @author shankar_044at09
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class MemberHandling extends SubscriptionHandler
	{
		/**
		 * MemberHandling::getCategories()
		 *
		 * @return void
		 */
		public function getCategories()
			{
				$file_name = $this->CFG['site']['project_path'].'common/classes/class_'.ucfirst($this->fields_arr['sub_module']).'Handler.lib.php';
				if(file_exists($file_name))
					{
						require_once($file_name);
						$class = ucfirst($this->fields_arr['sub_module']).'Handler';
						$obj = $this->fields_arr['sub_module'].'Handler';
						$$obj = new $class();
						$method = 'populate'.ucfirst($this->fields_arr['sub_module']).'CategoriesForSubscription';
						$category_arr = $$obj->$method();


						$category_list = '<select name="category_id" id="category_id" onchange="getCategoriesForSubscription(this.value, \'sub_category\');">
									 	<option value="">'.$this->LANG['common_select_option'].'</option>';

						foreach($category_arr as $category)
							{
								$category_list .= '<option value="'.$category['id'].'">'.$category['name'].'</option>';
							}
						$category_list .= '</select>';
						return $category_list;
					}
				$default_category = '<select name="category_id" id="category_id">
							 		<option value="">'.$this->LANG['common_select_option'].'</option></select>';
				return $default_category;
			}

		/**
		 * MemberHandling::getSubCategories()
		 *
		 * @return
		 */
		public function getSubCategories()
			{
				$file_name = $this->CFG['site']['project_path'].'common/classes/class_'.ucfirst($this->fields_arr['sub_module']).'Handler.lib.php';
				if(file_exists($file_name))
					{
						require_once($file_name);
						$class = ucfirst($this->fields_arr['sub_module']).'Handler';
						$obj = $this->fields_arr['sub_module'].'Handler';
						$$obj = new $class();
						$method = 'populate'.ucfirst($this->fields_arr['sub_module']).'SubCategoriesForSubscription';
						$category_arr = $$obj->$method($this->fields_arr['category_id']);


						$category_list = '<select name="sub_category_id" id="sub_category_id">
									 	  <option value="">'.$this->LANG['common_select_option'].'</option>';

						foreach($category_arr as $category)
							{
								$category_list .= '<option value="'.$category['id'].'">'.$category['name'].'</option>';
							}
						$category_list .= '</select>';
						return $category_list;
					}
				$default_category = '<select name="sub_category_id" id="sub_category_id">
							 		  <option value="">'.$this->LANG['common_select_option'].'</option></select>';
				return $default_category;
			}
	}
//--------------------Code begins-------------->>>>>//
$member = new MemberHandling();

$member->setPageBlockNames(array('block_msg_form_error', 'block_msg_form_success', 'subcription_option'));
$member->setFormField('subscriber_id', $CFG['user']['user_id']);
$member->setFormField('owner_id', 0);
$member->setFormField('category_id', 0);
$member->setFormField('tag', '');
$member->setFormField('sub_module', '');
$member->setFormField('sub_type', '');
$member->setFormField('action', '');

$member->sanitizeFormInputs($_REQUEST);

if($CFG['admin']['show_recent_activities'] and $member->getFormField('sub_type') =='User')
	{
		$GeneralActivity = new GeneralActivityHandler();
	}

if($member->getFormField('owner_id'))
	{
		$fields_list_arr = array('user_name');
		$user_name = getUserDetail('user_id', $member->getFormField('owner_id'), 'user_name');
		$member->setFormField('user_name', $user_name);
	}

if(isAjaxPage())
	{
		if ($member->isFormGETed($_REQUEST, 'action'))
			{
				if ($member->getFormField('action') == 'get_subscription_details')
		    		{
		    			$member->includeAjaxHeader();
						$member->getSubscriptionDetails();
						setTemplateFolder('members/');
						$smartyObj->display('subscriptionOptions.tpl');
		    			$member->includeAjaxFooter();
					}
				elseif ($member->getFormField('action') == 'subscribe' and $member->getFormField('sub_type') =='User')
		    		{
		    			//Check whether user is previously subscribed to owner
						$user_previously_subscribed = $member->chkIsUserSubscribedToOwner($member->getFormField('owner_id'));
						$member->includeAjaxHeader();
						$member->subscribeUser();

						//Add Activity
						if($CFG['admin']['show_recent_activities'] and !$user_previously_subscribed)
							{
								$GeneralActivity->activity_arr['action_key'] = 'subscribed';
								$GeneralActivity->activity_arr['owner_id'] = $member->getFormField('owner_id');
								$GeneralActivity->activity_arr['subscriber_id'] = $member->getFormField('subscriber_id');
								$GeneralActivity->activity_arr['content_id'] = 0;
								$GeneralActivity->addActivity($GeneralActivity->activity_arr);
							}
		    			$member->includeAjaxFooter();
					}
				else if($member->getFormField('action') == 'unsubscribe'  and $member->getFormField('sub_type') =='User')
					{
		    			$member->includeAjaxHeader();
						$member->unSubscribeUser();

						//Check whether user is previously subscribed to owner
						$user_previously_subscribed = $member->chkIsUserSubscribedToOwner($member->getFormField('owner_id'));

						//Remove Activity
						if($CFG['admin']['show_recent_activities'] and !$user_previously_subscribed)
							{
								$GeneralActivity->activity_arr['action_key'] = 'unsubscribed';
								$GeneralActivity->activity_arr['owner_id'] = $member->getFormField('owner_id');
								$GeneralActivity->activity_arr['subscriber_id'] = $member->getFormField('subscriber_id');
								$GeneralActivity->activity_arr['content_id'] = 0;
								$GeneralActivity->addActivity($GeneralActivity->activity_arr);
							}
		    			$member->includeAjaxFooter();
					}
				elseif ($member->getFormField('action') == 'subscribe' and $member->getFormField('sub_type') =='Category')
		    		{
						$member->includeAjaxHeader();
						$member->subscribeToCategory();
		    			$member->includeAjaxFooter();
					}
				else if($member->getFormField('action') == 'unsubscribe'  and $member->getFormField('sub_type') =='Category')
					{
		    			$member->includeAjaxHeader();
						$member->unSubscribeFromCategory();
		    			$member->includeAjaxFooter();
					}
				else if ($member->getFormField('action') == 'get_sub_category_details')
					{
						$member->includeAjaxHeader();
						$member->setpageBlockShow('subcription_option');
						$member->getSubscriptionContent();
						setTemplateFolder('members/', $member->getFormField('sub_module'));
						$smartyObj->display('subscription.tpl');
						$member->includeAjaxFooter();
					}
				elseif ($member->getFormField('action') == 'subscribe' and $member->getFormField('sub_type') =='Tag')
		    		{
						$member->includeAjaxHeader();
						$member->subscribeToTag();
		    			$member->includeAjaxFooter();
					}
				else if($member->getFormField('action') == 'unsubscribe'  and $member->getFormField('sub_type') =='Tag')
					{
		    			$member->includeAjaxHeader();
						$member->unSubscribeFromTag();
		    			$member->includeAjaxFooter();
					}
				else if ($member->getFormField('action') == 'get_sub_tag_details')
					{
						$member->includeAjaxHeader();
						$member->setpageBlockShow('subcription_option');
						$member->getSubscriptionContent();
						setTemplateFolder('members/', $member->getFormField('sub_module'));
						$smartyObj->display('subscription.tpl');
						$member->includeAjaxFooter();
					}
				else if ($member->getFormField('action') == 'get_categories')
					{
						$member->includeAjaxHeader();
						$category = $member->getCategories();
						echo $category;
						$member->includeAjaxFooter();
					}
				else if ($member->getFormField('action') == 'get_sub_categories')
					{
						$member->includeAjaxHeader();
						$category = $member->getSubCategories();
						echo $category;
						$member->includeAjaxFooter();
					}
			}
	}
?>