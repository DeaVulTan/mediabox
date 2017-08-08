<?php
/**
 * File to create discussion title
 *
 * Ther user can create a category
 *
 * PHP version 5.0
 *
 * @category	Discuzz
 * @package		DiscussionFormHandler
 * @author		shankar_76ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2008-24-10
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('../../common/configs/config.inc.php'); //configurations

$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/admin/addDiscussionTitle.php';
$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/email_notify.inc.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['include_files'][] = 'common/classes/class_DiscussionHandler.lib.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='discussions';
/**
 * To include application top file
 */
require_once($CFG['site']['project_path'] . 'common/application_top.inc.php');
//-------------- Class DiscussionFormHandler begins --------------->>>>>//
class DiscussionFormHandler extends DiscussionHandler
	{
		//Variable to store group discussion details
		public $discussion_details_arr;
		public $subcategory_details;

		/**
		 * To check the length of given url
		 *
		 * @param 		string $field_name form field name
		 * @param 		string $err_tip error tip
		 * @access public
		 * @return Boolean
		 **/
		public function chkLength($field_name, $err_tip='')
			{
				$url_len = strlen($this->fields_arr[$field_name]);
				if ($url_len < 3 || $url_len > 20)
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * To check if the discussion id is valid
		 *
		 * @param 		string $table_name discussions
		 * @param 		integer $discussion_id
		 * @param 		string $err_tip error tip
		 * @access public
		 * @return Boolean
		 **/
		public function isValidDiscussionId($discussion_table, $discussion_id, $err_tip='')
			{
				$sql = 'SELECT discussion_id, discussion_title, description, status, pcat_id, visible_to, publish_status, redirect_link'.
						' FROM '.$discussion_table.
						' WHERE discussion_id = '.$this->dbObj->Param($discussion_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($discussion_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if ($this->discussion_details_arr = $rs->FetchRow())
					{
						$this->setFormField('discussion_title', stripslashes($this->discussion_details_arr['discussion_title']));
						$this->setFormField('status', $this->discussion_details_arr['status']);
						$this->setFormField('discussion_description', stripslashes($this->discussion_details_arr['description']));
						$this->setFormField('visible_to', stripslashes($this->discussion_details_arr['visible_to']));
						$this->setFormField('publish', stripslashes($this->discussion_details_arr['publish_status']));
						$this->setFormField('redirect_link', stripslashes($this->discussion_details_arr['redirect_link']));
						if($this->discussion_details_arr['redirect_link']!='')
							{
								$this->setFormField('isredirect', 'Yes');
							}
						//$this->setFormField('category', stripslashes($this->discussion_details_arr['pcat_id']));
						//$this->setFormField('old_category', stripslashes($this->discussion_details_arr['pcat_id']));
						$this->getParentCategory($this->discussion_details_arr['pcat_id']);
						$this->sublevel_categories = array_reverse($this->sublevel_categories);
						return true;
				    }
				$this->setCommonErrorMsg($err_tip);
				return false;
			}

		/**
		 * To Check if the discussion title exists
		 *
		 * @param 		string $discussion_title discussion title
		 * @param		integer $discussion_id
		 * @param 		string $table_name discussions
		 * @param 		string $err_tip error tip
		 * @access public
		 * @return boolean
		 **/
		public function chkIsNotExists($discussion_title, $discussion_id, $discussion_table, $err_tip='')
			{
				$sql = 'SELECT COUNT(discussion_id) AS count'.
						' FROM '.$discussion_table.
						' WHERE discussion_title = '.$this->dbObj->Param($discussion_title);
				$fields_value_arr[] = $discussion_title;
				if ($discussion_id)
					{
						$sql .= ' AND discussion_id != '.$this->dbObj->Param($discussion_id);
						$fields_value_arr[] = $discussion_id;
					}

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
				if (!$rs)
				        trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				if ($row['count'])
					{
						$this->fields_err_tip_arr['discussion_title'] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * To create a group
		 *
		 * @param 		string $table_name discussions
		 * @param 		integer $discussion_id
		 * @access public
		 * @return void
		 **/
		public function createDiscussionTitle($discussion_id)
			{
				$this->setFormField('seo_title', $this->getSeoTitleForDiscussion($this->fields_arr['discussion_title'], $this->fields_arr['discussion_id']));

				if($this->fields_arr['sublevel_id'])
					$discussion_category = $this->fields_arr['sublevel_id'];
				else
					$discussion_category = $this->fields_arr['category'];
				if ($discussion_id)
					{
						$this->decreaseCategoryCount($this->fields_arr['old_category']);
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].' SET'.
								' discussion_title = '.$this->dbObj->Param($this->fields_arr['discussion_title']).
								', seo_title = '.$this->dbObj->Param($this->fields_arr['seo_title']).
								', description = '.$this->dbObj->Param($this->fields_arr['discussion_description']).
								', pcat_id = '.$this->dbObj->Param('category').
								', visible_to = '.$this->dbObj->Param('visible_to').
								', publish_status = '.$this->dbObj->Param('publish').
								', redirect_link = '.$this->dbObj->Param('redirect_link').
								' WHERE discussion_id = '.$this->dbObj->Param($discussion_id).'';
						$fields_value_arr = array($this->fields_arr['discussion_title'],
												  $this->fields_arr['seo_title'],
												  $this->fields_arr['discussion_description'],
												  $discussion_category,
												  $this->fields_arr['visible_to'],
												  $this->fields_arr['publish'],
												  $this->fields_arr['redirect_link'],
												  $discussion_id);
				    }
				else
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['discussions'].' SET'.
								' discussion_title = '.$this->dbObj->Param($this->fields_arr['discussion_title']).
								', seo_title = '.$this->dbObj->Param($this->fields_arr['seo_title']).
								', description = '.$this->dbObj->Param($this->fields_arr['discussion_description']).
								', user_id = '.$this->dbObj->Param('user_id').
								', pcat_id = '.$this->dbObj->Param('category').
								', visible_to = '.$this->dbObj->Param('visible_to').
								', publish_status = '.$this->dbObj->Param('publish').
								', redirect_link = '.$this->dbObj->Param('redirect_link').
								', date_added = NOW()';

						$fields_value_arr = array($this->fields_arr['discussion_title'],
											  $this->fields_arr['seo_title'],
												  $this->fields_arr['discussion_description'],
												  $this->CFG['user']['user_id'],
												  $discussion_category,
												  $this->fields_arr['visible_to'],
												  $this->fields_arr['publish'],
												  $this->fields_arr['redirect_link']);
					}
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$this->increaseCategoryCount($this->fields_arr['category']);
				return $discussion_category;
			}

		public function increaseCategoryCount($cat_id)
			{
				if(!$cat_id)
					return true;

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
						' SET total_discussions=total_discussions+1'.
						' WHERE cat_id = '.$this->dbObj->Param('cat_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);
			}

		public function decreaseCategoryCount($cat_id)
			{
				if(!$cat_id)
					return true;

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
						' SET total_discussions=total_discussions-1'.
						' WHERE cat_id = '.$this->dbObj->Param('cat_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);
			}

		public function getSubCategories($cat_id)
			{
				if(!$cat_id)
					return true;

				$sql = 'SELECT cat_id, cat_name FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE parent_id = '.$this->dbObj->Param('cat_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								$this->subcategory_details[$row['cat_id']] = wordWrapManual($row['cat_name'],$this->CFG['admin']['category']['line_length'], $this->CFG['admin']['category']['short_length']);
							}
					}
			}

		public function generateSubLevelCategories($cat_id, $subcat_id = 0)
			{
				if(!$cat_id)
					return true;

				$sql = 'SELECT cat_id, cat_name FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE parent_id='.$this->dbObj->Param('cat_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$sublevel_category_details = array();
				$sub_cat_array = $this->fields_arr['subcategory'];
				if($rs->PO_RecordCount())
					{
						$inc = 0;

						while($row = $rs->FetchRow())
							{
								$sublevel_category_details[$inc]['cat_id'] = $row['cat_id'];
								$sublevel_category_details[$inc]['cat_name'] = $row['cat_name'];
								if($subcat_id != 0)
									{
										if($subcat_id == $row['cat_id'])
											$sublevel_category_details[$inc]['selected'] = 'selected';
										else
											$sublevel_category_details[$inc]['selected'] = '';
									}
								else
									{
										if(in_array($row['cat_id'], $sub_cat_array)){
											$sublevel_category_details[$inc]['selected'] = 'selected';
											$sublevel_category_details[$inc]['divname'] = 'subCategoryDiv'.$row['cat_id'];
										}
										else{
											$sublevel_category_details[$inc]['selected'] = '';
										}
									}
								$sublevel_category_details[$inc]['parent_id'] = $cat_id;
								$inc++;
							}
						return $sublevel_category_details;
					}
			}

		public function getParentCategory($cat_id)
			{
				if(!$cat_id)
					return true;

				$sql = 'SELECT cat_id, parent_id FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE status=\'Active\' AND cat_id='.$this->dbObj->Param('cat_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$sublevel_category_details = array();
				$sub_cat_array = $this->fields_arr['subcategory'];
				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						if($row['parent_id'] > 0){
							$this->sublevel_categories[] = $this->generateSubLevelCategories($row['parent_id'], $cat_id);
							$this->getParentCategory($row['parent_id']);
						}
						else{
							$this->setFormField('category', stripslashes($row['cat_id']));
							$this->setFormField('old_category', stripslashes($row['cat_id']));
						}
					}
			}

		public function getSubLevelId($count)
			{
				$sub_cat_array = $this->getFormField('subcategory');
				$count = $count-1;
				$sublevel_id = $sub_cat_array[$count];
				if($sublevel_id == '' && $count > 0)
					return $this->getSubLevelId($count);
				return $sublevel_id;
			}
	}
//<<<<<-------------- Class DiscussionFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$discussion = new DiscussionFormHandler();
$discussion->setPageBlockNames(array('form_create_discussion', 'sub_category_block'));

//default form fields and values...
$discussion->setFormField('did', '');
$discussion->setFormField('discussion_id', '');
$discussion->setFormField('discussion_title', '');
$discussion->setFormField('seo_title', '');
$discussion->setFormField('status', '');
$discussion->setFormField('category', '');
$discussion->setFormField('old_category', '');
$discussion->setFormField('discussion_description', '');
$discussion->setFormField('visible_to', 'All');
$discussion->setFormField('publish', 'Yes');
$discussion->setFormField('mode', '');
$discussion->setFormField('cat_id', '');
$discussion->setFormField('subcategory', '');
$discussion->setFormField('sublevel_id', '');
$discussion->setFormField('isredirect', 'No');
$discussion->setFormField('redirect_link', '');

$discussion->setAllPageBlocksHide();
$discussion->sanitizeFormInputs($_REQUEST);
$discussion->sublevel_categories = array();

if($discussion->getFormField('mode') == 'showNext')
	{
		$discussion->getSubCategories($discussion->getFormField('cat_id'));
		$discussion->includeAjaxHeader();
		$discussion->setAllPageBlocksHide();
		$discussion->setPageBlockShow('sub_category_block');
		setTemplateFolder('admin/', $CFG['admin']['index']['home_module']);
		$smartyObj->display('addDiscussionTitle.tpl');
		$discussion->includeAjaxFooter();
		die();
	}
if ($discussion->isFormGETed($_GET, 'did'))
	{
		$discussion->chkIsNotEmpty('did', $LANG['err_tip_compulsory'])and
			$discussion->chkIsNumeric('did', $LANG['err_tip_compulsory'])and
				$discussion->isValidDiscussionId($CFG['db']['tbl']['discussions'], $discussion->getFormField('did'), $LANG['discussions_err_tip_invalid_discussion_id']);

		if ($discussion->isValidFormInputs())
			{

			}
		else
			{
				$discussion->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
				$discussion->setPageBlockShow('block_msg_form_error');
			}
	}
elseif ($discussion->isFormPOSTed($_POST, 'discussion_submit'))
	{
		//validations...
		$discussion->chkIsNotEmpty('discussion_title', $LANG['err_tip_compulsory'])and
			$discussion->chkIsNotExists($discussion->getFormField('discussion_title'), $discussion->getFormField('did'), $CFG['db']['tbl']['discussions'], $LANG['discussion_err_tip_discussion_title_exists']);
		$discussion->chkIsNotEmpty('discussion_description', $LANG['err_tip_compulsory']);
		$discussion->chkIsNotEmpty('category', $LANG['err_tip_compulsory']);

		$discussion->getFormField('did')and
			$discussion->chkIsNotEmpty('did', $LANG['err_tip_compulsory'])and
				$discussion->chkIsNumeric('did', $LANG['err_tip_compulsory']);
		if($discussion->getFormField('isredirect') == 'Yes')
			{
				if($discussion->chkIsNotEmpty('redirect_link', $LANG['redirect_link_empty']))
					{
						if(stripos($discussion->getFormField('redirect_link'), 'http://') === false)
							$discussion->setFormField('redirect_link', 'http://'.$discussion->getFormField('redirect_link'));
						$discussion->chkIsValidURL('redirect_link', $LANG['redirect_link_not_valid']);
					}
			}
		else
			{
				$discussion->setFormField('redirect_link', '');
			}
		if($discussion->getFormField('subcategory'))
			{
				$sub_cat_array = $discussion->getFormField('subcategory');
				$sublevel_id = $sub_cat_array[count($discussion->getFormField('subcategory'))-1];
				// sublevel category compulsory check...
				//if($sublevel_id == '') $discussion->setFormFieldErrorTip('category', $LANG['sublevel_not_selected']);
				$sublevel_id = $discussion->getSubLevelId(count($discussion->getFormField('subcategory')));
				$discussion->setFormField('sublevel_id', $sublevel_id);
			}
		$redirect_cat_id = 0;
		if ($discussion->isValidFormInputs())
			{
				$redirect_cat_id = $discussion->createDiscussionTitle($discussion->getFormField('did'));
			}
		$discussion->setAllPageBlocksHide();

		if ($discussion->isValidFormInputs())
			{
				$discussion->setPageBlockShow('block_msg_form_success');
				//now redirect to members page...
				if ($discussion->getFormField('did'))
					Redirect2URL($CFG['site']['relative_url'].'discussions.php?cat='.$redirect_cat_id.'&msg=update');
				Redirect2URL($CFG['site']['relative_url'].'discussions.php?cat='.$redirect_cat_id.'&msg=success');

			}
		else //error in form inputs
			{
				if($discussion->getFormField('subcategory'))
					{
						$sub_cat_array = $discussion->getFormField('subcategory');
						$sub_cat_ids = implode(",", $sub_cat_array);
						$discussion->sublevel_categories[] = $discussion->generateSubLevelCategories($discussion->getFormField('category'));
						foreach($sub_cat_array as $cat_values){
							if($cat_values != '')
								$discussion->sublevel_categories[] = $discussion->generateSubLevelCategories($cat_values);
						}
					}

				$discussion->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
				$discussion->setPageBlockShow('block_msg_form_error');
			}
	}
elseif ($discussion->isFormPOSTed($_POST, 'discussion_cancel'))
	{
		//now redirect to members page...
		Redirect2URL($CFG['site']['relative_url'].'discussions.php');
	}

$discussion->setPageBlockShow('form_create_discussion'); //default page block. show it. All others hidden
$discussion->back_to_discussions['url'] = $CFG['site']['relative_url'].'discussions.php';
$discussion->button_value = $LANG['discussion_create_title'];
$discussion->populateCategories_arr = $discussion->populateCategories('admin');
if ($discussion->getFormField('did'))
	{
		$discussion->button_value = $LANG['discuzz_common_update'];
		$discussion->LANG['discussionslinks_add_title'] = $LANG['discussionslinks_edit_title'];
	}

//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//

//<<<<<-------------------- Page block templates ends -------------------//
$discussion->left_navigation_div = 'discussionsMain';
//include the header file
$discussion->includeHeader();
//include the content of the page
setTemplateFolder('admin/', $CFG['admin']['index']['home_module']);
$smartyObj->display('addDiscussionTitle.tpl');
//include the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
if($CFG['feature']['jquery_validation']){
?>
<script type="text/javascript">
	$Jq("#selAddDiscussionFrm").validate({
		rules: {
			discussion_title: {
				required: true
		    },
		    discussion_description: {
		    	required: true
		    },
		    category: {
		    	required: true
		    }
		},
		messages: {
			discussion_title: {
				required: "<?php echo $LANG['common_err_tip_compulsory'];?>"
			},
			discussion_description: {
				required: "<?php echo $LANG['common_err_tip_compulsory'];?>"
			},
			category: {
				required: "<?php echo $LANG['common_err_tip_compulsory'];?>"
			}
		}
	});
</script>
<?php
}
$discussion->includeFooter();
?>