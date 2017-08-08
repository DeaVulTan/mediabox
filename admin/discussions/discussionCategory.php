<?php
/**
 * This file is to manage venue categories
 *
 * PHP version 5.0
 *
 * @category	Discuzz
 * @package		discussionCategoryFormHandler
 * @author 		karthiselvam_75ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:
 * @since 		2008-12-23
 */
/**
 * To include config file
 */
require_once('../../common/configs/config.inc.php');
$CFG['site']['is_module_page']='discussions';
$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/admin/discussionCategory.php';


$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_DiscussionHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');

class discussionCategoryFormHandler extends DiscussionHandler
	{
		public $valid_category_array;
		public $categoryNameList;
		public $parent_active_array;
		public $current_category_id;
		public $category_details;
		public $discussions_count=0;
		public $pagingArr;
		/**
		 * BrowseUsersFormHandler::buildConditionQuery()
		 *
		 * @return
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'parent_id=0';
			}
		/**
		 * BrowseUsersFormHandler::ConditionQuery()
		 *
		 * @return
		 **/
		public function ConditionQuery()
			{
				$this->sql_condition = 'parent_id=\''.addslashes($this->fields_arr['cat_id']).'\'';
			}
		/**
		 * searchMembersFormHandler::buildSortQuery()
		 *
		 * @return
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}
		/**
		 * showCategory()
		 *
		 * @return
		 **/
		public function showCategory()
			{
				$this->showCategory_arr	=	array();
				if (!$this->isResultsFound())
					{
						$this->showCategory_arr['RecordCount']	=	0;
					}
					$this->showCategory_arr['RecordCount']	=	1;
				$found = false;
				$this->showCategory_arr['row']	=	array();
				$inc=0;
				while($row = $this->fetchResultRecord())
					{
						$this->discussions_count = 0;
						if (!$this->fields_arr['catid_'.$row['cat_id']])
							{
								$this->fields_arr['catid_'.$row['cat_id']] = $row['disporder'];
							}
						$row['disporder'] = $this->fields_arr['catid_'.$row['cat_id']];
						$row['disporder_elementclass'] = $this->getCSSFormFieldElementClass('catid_'.$row['cat_id']);
						$row['disporder_formfieldclass'] = $this->getCSSFormFieldCellClass('catid_'.$row['cat_id']);
						$this->showCategory_arr['row'][$inc]['record']	=	$row;
						$this->showCategory_arr['row'][$inc]['linkid']	=	'category_'.$row['cat_id'];
						$this->showCategory_arr['row'][$inc]['subcategory_count']	=	$this->getSubcategoryCount($row['cat_id']);
						$this->showCategory_arr['row'][$inc]['total_discussions']   = $this->fetchSubLevelCounts($row['cat_id']);
						$this->showCategory_arr['row'][$inc]['add_subcategory_link']	= 'discussionCategory.php?cat_id='.$row['cat_id'].'&amp;mode=showSubLevelForm';
						$this->showCategory_arr['row'][$inc]['linkid']	=	'category_'.$row['cat_id'];
						$this->showCategory_arr['row'][$inc]['discussionCategory_mode_url']	=	'discussionCategory.php?mode=viewsubcategory&amp;cat_id='.$row['cat_id'];
						$this->showCategory_arr['row'][$inc]['discussionCategory_url']	=	'discussionCategory.php?cat_id='.$row['cat_id'].'&amp;start='.$this->fields_arr['start'].'&amp;mode=showCategoryForm';
						$inc++;
					}
				$this->showCategory_arr['populateFilterList']	=	$this->populateFilterList($this->action_arr, $this->fields_arr['action']);
				return $this->showCategory_arr;
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function fetchSubLevelCounts($cat_id)
		    {
		    	$sql = 'SELECT cat_id, parent_id FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE parent_id='.$this->dbObj->Param('cat_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								if(!$this->getSubcategoryCount($row['cat_id']))
									$this->discussions_count+=$this->getDiscussionsCount($row['cat_id']);
								else
									$this->fetchSubLevelCounts($row['cat_id']);
							}
					}
				else
					{
						return $this->getDiscussionsCount($cat_id);
					}
				return $this->discussions_count;
		    }
		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getDiscussionsCount($cat_id)
		    {
				$ds_sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['discussions'].
				 			' WHERE status=\'Active\' AND pcat_id='.$this->dbObj->Param($cat_id);
				$ds_stmt = $this->dbObj->Prepare($ds_sql);
				$ds_rs = $this->dbObj->Execute($ds_stmt, array($cat_id));
				if (!$ds_rs)
					trigger_db_error($this->dbObj);
				return $ds_rs->PO_RecordCount();
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getSubcategoryCount($cat_id)
		    {
				$sql = 'SELECT cat_id FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE parent_id='.$this->dbObj->Param('cat_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				return $rs->PO_RecordCount();
		    }
		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function showAllCategoriesName($cat_id)
		    {
				$sql = 'SELECT cat_id, cat_name, parent_id FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE cat_id='.$this->dbObj->Param('cat_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						$category_info = array();
						$row = $rs->FetchRow();
						if($this->fields_arr['cat_id'] == $row['cat_id'])
							$category_info['url'] = $row['cat_name'];
						else
							$category_info['url'] = '<a href="discussionCategory.php?mode=viewsubcategory&cat_id='.$row['cat_id'].'">'.$row['cat_name'].'</a>';
						$category_info['cat_name'] = $row['cat_name'];
						$this->categoryNameList[] = $category_info;
						if($row['parent_id'] > 0)
								$this->showAllCategoriesName($row['parent_id']);
					}
		    }
		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function showCategoryName($cat_id)
		    {
				$sql = 'SELECT cat_name, seo_title, cat_id FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE cat_id='.$this->dbObj->Param('cat_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						return $row['cat_name'];
					}
		    }
		/**
		 * showCategory()
		 *
		 * @return
		 **/
		public function showSubCategory()
			{
				$this->showSubCategory_arr	=	array();
				$this->showSubCategory_arr['RecordCount']	=	1;
				if (!$this->isResultsFound())
					{
						$this->showSubCategory_arr['RecordCount']	=	0;
					}
				$this->showSubCategory_arr['row']	=	array();
				$found = false;
				$inc=0;
				while($row = $this->fetchResultRecord())
					{
						$this->discussions_count = 0;
						$this->showSubCategory_arr['row'][$inc]['record']	=	$row;
						$this->showSubCategory_arr['row'][$inc]['subcategory_count']	=	$this->getSubcategoryCount($row['cat_id']);
						$this->showSubCategory_arr['row'][$inc]['add_subcategory_link']	= 'discussionCategory.php?cat_id='.$row['cat_id'].'&amp;mode=showSubLevelForm';
						$this->showSubCategory_arr['row'][$inc]['linkid']	=	'category_'.$row['cat_id'];
						$this->showSubCategory_arr['row'][$inc]['discussionCategory_mode_url']	=	'discussionCategory.php?mode=viewsubcategory&amp;cat_id='.$row['cat_id'];
						$this->showSubCategory_arr['row'][$inc]['total_discussions']   = $this->fetchSubLevelCounts($row['cat_id']);
						//$this->showSubCategory_arr['row'][$inc]['discussionCategory_url']	=	'discussionCategory.php?sub_cat_id='.$row['cat_id'].'&amp;start='.$this->fields_arr['start'].'&amp;mode=editsubcategory';
						$this->showSubCategory_arr['row'][$inc]['discussionCategory_url']	=	'discussionCategory.php?sub_cat_id='.$row['cat_id'].'&amp;mode=showSubLevelForm&amp;cat_id='.$this->fields_arr['cat_id'];
						$inc++;
					}
					$this->showSubCategory_arr['getMultiCheckBoxValue']	=	'if(getMultiCheckBoxValue(\'formViewCategory\', \'checkall\', \''.$this->LANG['category_err_tip_select_subcategory'].'\')){getAction()}';
					$this->showSubCategory_arr['populateFilterList']	=	$this->populateFilterList($this->action_arr, $this->fields_arr['action']);
				return $this->showSubCategory_arr;
			}
		/**
		 * To populate filter list
		 *
		 * @param	    string $highlight Selected filter
		 * @return 		void
		 * @access		public
		*/
		public function populateFilterList($array_to_expand, $highlight)
			{
				$this->populateFilterList_arr	=	array();
				$inc=0;
				foreach ($array_to_expand as $key=>$value)
					{
						$this->populateFilterList_arr[$inc]['key']	=	$key;
						$this->populateFilterList_arr[$inc]['name']	=	$value;
						if($key == $highlight)
							{
								$this->populateFilterList_arr[$inc]['selected_chk']	=	'selected="selected"';
							}
						else
							{
								$this->populateFilterList_arr[$inc]['selected_chk']	=	'';
							}
						$inc++;
					}
				return 	$this->populateFilterList_arr;
			}

		public function chkCategoryExists($err_tip='')
			{
				$sql = 'SELECT COUNT(cat_id) AS count FROM '.$this->CFG['db']['tbl']['category'].' WHERE'.
						' cat_name='.$this->dbObj->Param($this->fields_arr['category']);
				$fields_value_array[] = $this->fields_arr['category'];
				if ($this->fields_arr['cat_id'])
					{
						$sql .= ' AND cat_id!='.$this->dbObj->Param($this->fields_arr['cat_id']);
						$sql .= ' AND parent_id = 0';
						$fields_value_array[] = $this->fields_arr['cat_id'];
					}

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $fields_value_array);
				if (!$rs)
						trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if ($row['count'])
					{
						$this->fields_err_tip_arr['category'] = $err_tip;
						return false;
					}
				return true;
			}
		public function chkCharLength($fieldname, $err_tip)
			{
				if(strlen($this->fields_arr[$fieldname]) < 3)
					{
						$this->fields_err_tip_arr[$fieldname] = $err_tip;
						return false;
					}

			}
		public function chkSubCategoryExists($err_tip='')
			{
				$sql = 'SELECT COUNT(cat_id) AS count FROM '.$this->CFG['db']['tbl']['category'].' WHERE'.
						' cat_name='.$this->dbObj->Param($this->fields_arr['category']).
						' AND parent_id='.$this->dbObj->Param($this->fields_arr['parent_id']);
				$fields_value_array[] = $this->fields_arr['category'];
				$fields_value_array[] = $this->fields_arr['parent_id'];
				if ($this->fields_arr['sub_cat_id'])
					{
						$sql .= ' AND cat_id!='.$this->dbObj->Param($this->fields_arr['sub_cat_id']);
						$fields_value_array[] = $this->fields_arr['sub_cat_id'];
					}

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $fields_value_array);
				if (!$rs)
						trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if ($row['count'])
					{
						$this->fields_err_tip_arr['category'] = $err_tip;
						return false;
					}
				return true;
			}

		public function isValidCategoryId($cat_id, $err_tip='')
			{
				$sql = 'SELECT cat_name, seo_title, description, parent_id, status, restricted FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE cat_id=\''.addslashes($this->fields_arr[$cat_id]).'\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
						trigger_db_error($this->dbObj);

				$row = array();
				if (!$rs->PO_RecordCount())
					{
						$this->setCommonErrorMsg($err_tip);
						return false;
					}
				$this->link_details_arr = $rs->FetchRow();
				return true;
			}
		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getMaxCount()
			{
				$sql = 'SELECT MAX( disporder ) +1 as max_count FROM '.$this->CFG['db']['tbl']['category'];
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
						trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['max_count'];
			}
		/**
		 * updateUsersTable()
		 *
		 * @return
		 **/
		public function insertCategory()
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['category'].
						' SET cat_name='.$this->dbObj->Param('category').
						', seo_title='.$this->dbObj->Param('seo_title').
						', description='.$this->dbObj->Param('description').
						', parent_id='.$this->dbObj->Param('parent_id').
						', status='.$this->dbObj->Param('status').
						', previous_status=\'\''.
						', restricted='.$this->dbObj->Param('is_restricted').
						', date_added=NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['category'],
														 $this->fields_arr['seo_title'],
														 $this->fields_arr['description'],
														 $this->fields_arr['parent_id'],
														 $this->fields_arr['status'],
														 $this->fields_arr['is_restricted']));
				if (!$rs)
						trigger_db_error($this->dbObj);

				//Get insert id to update category order
				$cat_id = $this->dbObj->Insert_ID();
				$this->current_category_id = $cat_id;
				$max_id = $this->getMaxCount();
				//Update disporder field
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
						' SET disporder='.$this->dbObj->Param($cat_id).
						' WHERE cat_id='.$this->dbObj->Param($cat_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($max_id, $cat_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				return true;
			}

		/**
		 * discussionCategoryFormHandler::updateCategory()
		 *
		 * @param mixed $cat_field
		 * @return
		 */
		public function updateCategory($cat_field)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
						' SET cat_name='.$this->dbObj->Param('category').
						', seo_title='.$this->dbObj->Param('seo_title').
						', description='.$this->dbObj->Param('description').
						', parent_id='.$this->dbObj->Param('parent_id').
						', status='.$this->dbObj->Param('status').
						', restricted='.$this->dbObj->Param('is_restricted').
						' WHERE cat_id = '.$this->dbObj->Param($cat_field);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['category'],
														 $this->fields_arr['seo_title'],
														 $this->fields_arr['description'],
														 $this->fields_arr['parent_id'],
														 $this->fields_arr['status'],
														 $this->fields_arr['is_restricted'],
														 $this->fields_arr[$cat_field]));
				if (!$rs)
						trigger_db_error($this->dbObj);
				if($this->fields_arr['is_restricted'])
					{
						$this->getSubCategoriesList($this->fields_arr[$cat_field]);
						if(!empty($this->valid_category_array))
							$this->updateRestrictedStatus($this->fields_arr['is_restricted']);
					}
				return true;
			}
		/**
		* public
		* cat_id int
		*/
		public function updateRestrictedStatus($status)
			{
				$sub_cat_ids = implode(",", $this->valid_category_array);
				$sub_sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
							' SET restricted='.$this->dbObj->Param($status).
						    ' WHERE cat_id IN ('.$sub_cat_ids.') ';

				$substmt = $this->dbObj->Prepare($sub_sql);
				$subrs = $this->dbObj->Execute($substmt, array($status));
				if (!$subrs)
					trigger_db_error($this->dbObj);
			}

		/**
		* public
		* cat_id int
		*/
		public function chkParentActive($cat_id)
			{
				if($cat_id == 0) return true;
				if(is_array($this->parent_active_array))
					if(in_array($cat_id, $this->parent_active_array)) return true;

				$sub_sql = 'SELECT status, parent_id FROM '.$this->CFG['db']['tbl']['category'].
						   ' WHERE cat_id='.$this->dbObj->Param($cat_id);

				$substmt = $this->dbObj->Prepare($sub_sql);
				$subrs = $this->dbObj->Execute($substmt, array($cat_id));
				if (!$subrs)
					trigger_db_error($this->dbObj);

				if($subrs->PO_RecordCount())
					{
						$row = $subrs->FetchRow();
						if($row['status'] == 'Inactive')
							return false;
						else if($row['status'] == 'Active')
							{
								if($row['parent_id'] > 0)
									$this->chkParentActive($row['parent_id']);
								return true;
							}
					}
			}
		/**
		* public
		* cat_id int
		* status_value
		*/
		public function getSubLevelCategories($cat_id, $status_value)
			{

				if($status_value == 'Inactive')
					 {
					 	$check_status = 'Active';
					 }
				else
					 {
						$check_status = 'Inactive';
					 }

				$sub_sql = 'SELECT cat_id, status, parent_id, previous_status FROM '.$this->CFG['db']['tbl']['category'].
						   ' WHERE parent_id='.$this->dbObj->Param($cat_id);

				$substmt = $this->dbObj->Prepare($sub_sql);
				$subrs = $this->dbObj->Execute($substmt, array($cat_id));
				if (!$subrs)
					trigger_db_error($this->dbObj);

				if($subrs->PO_RecordCount())
					{
						while($row = $subrs->FetchRow())
							{
								if($this->chkParentActive($row['parent_id'])){
									if($row['previous_status'] == '')
										{
											$this->updatePreviousStatus($row['cat_id'], $status_value, $row['status']);
										}
									else
										{
											if($row['previous_status'] == 'Active')
												{
													$current_status = $status_value;
												}
											else
												{
													$current_status = $row['previous_status'];
												}
											$previous_status = $row['status'];
											$this->updatePreviousStatus($row['cat_id'], $current_status, $previous_status);
										}
								}
								else return false;

								if((!$this->getSubLevelCategories($row['cat_id'], $status_value)) AND
										($row['status'] == $check_status))
									$this->valid_category_array[] = $row['cat_id'];
								//$this->updatePreviousStatus($row['cat_id'], $status_value, $row['status']);
							}
					}
				return $subrs->PO_RecordCount();
			}

		/**
		* public
		*
		*/
		public function updatePreviousStatus($cat_id, $status, $previous_status = '')
			{
				$input_array = array();
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].' SET status='.$this->dbObj->Param('status').
						', previous_status='.$this->dbObj->Param($previous_status).
						' WHERE cat_id='.$this->dbObj->Param($cat_id);

				$this->parent_active_array[] = $cat_id;
				$input_array[] = $status;
				$input_array[] = $previous_status;
				$input_array[] = $cat_id;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $input_array);
				if (!$rs)
					trigger_db_error($this->dbObj);
			}
		/**
		 * discussionCategoryFormHandler::updateAction()
		 *
		 * @param mixed $fieldToUpdate
		 * @param mixed $fieldValue
		 * @return
		 */
		public function updateAction($fieldToUpdate, $fieldValue)
			{
				$cat_ids = $this->fields_arr['cat_ids'];

				if (!in_array($fieldValue, array('Active', 'Inactive')))
					return ;

				if($fieldValue == 'Inactive')
					 {
					 	$check_status = 'Active';
					 }
				else
					 {
						$check_status = 'Inactive';
					 }

				$sql = 'SELECT cat_id, parent_id, status FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE cat_id IN ('.$cat_ids.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
						trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$cats_new = '';
						while($row_cat = $rs->FetchRow())
							{
								// check if the parent category is active
								if($this->chkParentActive($row_cat['parent_id']))
									{
										// updating the category status with previous status to null
										$this->updatePreviousStatus($row_cat['cat_id'], $fieldValue);
									}
								else return false;

								// if it has sub categories , update the sub category status.
								if((!$this->getSubLevelCategories($row_cat['cat_id'], $fieldValue)) AND
										($row_cat['status'] == $check_status))
									$this->valid_category_array[] = $row_cat['cat_id'];
								// valid category contains the sub level category ids for updating its discussions.
							}
							/*
							echo "<pre>";
							print_r($this->valid_category_array);
							echo "</pre>";
							echo "<br>comes here---";
							die();
							*/
							if(count($this->valid_category_array))
								{
									$valid_category_ids = implode(',', $this->valid_category_array);
									$this->updateDiscussionsInCategories($valid_category_ids, $fieldValue);
								}
					}

				return true;
			}
		/**
		*
		* get sub-category list
		*/
		public function getSubCategoriesList($cat_id, $check_flag = 0)
			{
				$sub_sql = 'SELECT cat_id, status, parent_id, previous_status FROM '.$this->CFG['db']['tbl']['category'].
						   ' WHERE parent_id='.$this->dbObj->Param($cat_id);

				if($check_flag == 1)
					$sub_sql.=' AND status=\'Active\'';
				$substmt = $this->dbObj->Prepare($sub_sql);
				$subrs = $this->dbObj->Execute($substmt, array($cat_id));
				if (!$subrs)
					trigger_db_error($this->dbObj);

				if($subrs->PO_RecordCount())
					{
						while($row = $subrs->FetchRow())
							{
								if($check_flag == 0){
									$this->valid_category_array[] = $row['cat_id'];
									if($row['parent_id'] != 0)
										$this->parent_active_array[] = $row['parent_id'];
									$this->getSubCategoriesList($row['cat_id']);
								}
								else {
									if(!$this->getSubCategoriesList($row['cat_id']))
										$this->valid_category_array[] = $row['cat_id'];
								}
							}
					}
				return $subrs->PO_RecordCount();
			}

	/**
	 * discussionCategoryFormHandler::deleteDiscussionCategories()
	 *
	 * @return
	 */
	public function deleteDiscussionCategories()
		{
			$cat_ids = $this->fields_arr['cat_ids'];

			$sql = 'SELECT cat_id FROM '.$this->CFG['db']['tbl']['category'].
					' WHERE status=\'Active\''.
					' AND cat_id IN ('.$cat_ids.')';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
					trigger_db_error($this->dbObj);

			if($rs->PO_RecordCount())
				{
					$cats_new = array();
					while($row_cat = $rs->FetchRow())
						{
							if(!$this->getSubCategoriesList($row_cat['cat_id'], 1))
								$this->valid_category_array[] = $row_cat['cat_id'];
						}
					$cat_new_ids = implode(',', $this->valid_category_array);

					$sql_ds = 'SELECT discussion_id FROM '.$this->CFG['db']['tbl']['discussions'].
							' WHERE pcat_id IN ('.$cat_new_ids.')';

					$stmt_ds = $this->dbObj->Prepare($sql_ds);
					$rs_ds = $this->dbObj->Execute($stmt_ds);
					if (!$rs_ds)
						trigger_db_error($this->dbObj);

					if($rs_ds->PO_RecordCount())
						{
							$discussion_ids = array();
							while($row_ds = $rs_ds->FetchRow())
								{
									$discussion_ids[] = $row_ds['discussion_id'];
								}
							$discussion_new_ids = implode(',', $discussion_ids);
							$this->deleteDiscussionsTable($discussion_new_ids);
						}
				}

			$sql = 'SELECT cat_id, parent_id FROM '.$this->CFG['db']['tbl']['category'].' WHERE cat_id IN ('.$cat_ids.') ';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
		        trigger_db_error($this->dbObj);

			if($rs->PO_RecordCount())
				{
					while($row = $rs->FetchRow())
						{
							$this->valid_category_array[] = $row['cat_id'];
							if($row['parent_id'] != 0)
								$this->parent_active_array[] = $row['parent_id'];
							$this->getSubCategoriesList($row['cat_id']);
						}
				}
			$delete_cat_ids = implode(',', $this->valid_category_array);

			$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['category'].' WHERE cat_id IN ('.$delete_cat_ids.') ';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
		        trigger_db_error($this->dbObj);

		    if(count($this->parent_active_array))
				$this->changeChildStatus();

			return true;
		}

		/**
		* public
		*
		*/
	public function changeChildStatus()
		{
			foreach($this->parent_active_array as $key => $parent_values)
				{
					$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['category'].' WHERE parent_id='.$this->dbObj->Param($parent_values);
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($parent_values));
					if (!$rs)
				        trigger_db_error($this->dbObj);
				    if(!$rs->PO_RecordCount())
				    	{
							$sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
									' SET has_child=\'No\''.
									' WHERE cat_id='.$this->dbObj->Param($parent_values);
							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($parent_values));
							if (!$rs)
						        trigger_db_error($this->dbObj);
						}
					//if($this->getSubCategoriesList($parent_values));
				}
			$parent_ids = implode(',', $this->parent_active_array);

		}
		/**
		 * discussionCategoryFormHandler::updateDiscussionsInCategories()
		 *
		 * @param mixed $cats_news
		 * @param mixed $check_status
		 * @return
		 */
	public function updateDiscussionsInCategories($cats_news, $check_status)
		{
				if($check_status == 'Inactive')
					 {
					 	$qry_status = 'Active';
						$addsub = '-';
					 }
				else
					 {
						$qry_status = 'Inactive';
						$addsub = '+';
					 }

				$sql = 'SELECT discussion_id, pcat_id FROM '.$this->CFG['db']['tbl']['discussions'].
						' WHERE pcat_id IN ('.$cats_news.') AND status=\'Active\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$discussion_ids_new = array();
				if ($rs->PO_RecordCount())
					{
						while ($row = $rs->FetchRow()){
							$discussion_ids_new[] = $row['discussion_id'];
						}
					}

				if ($discussion_ids_new)
					{
						$discussion_ids = implode(',', $discussion_ids_new);

						$sql = 'SELECT b.user_id, b.board_id, b.best_solution_id, d.pcat_id FROM '.$this->CFG['db']['tbl']['boards'].' as b, '.$this->CFG['db']['tbl']['discussions'].' as d'.
								' WHERE b.discussion_id=d.discussion_id AND b.discussion_id IN ('.$discussion_ids.') AND b.status = \'Active\'';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							    trigger_db_error($this->dbObj);
						if ($rs->PO_RecordCount())
							{
								while ($row = $rs->FetchRow()){
									//Update users_board_log for board owner
									$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
											' SET total_board=total_board'.$addsub.'1';
									if($this->CFG['admin']['ask_solutions']['allowed'])
										{
											$points = $this->CFG['admin']['ask_solutions']['points'];
											$sql .= ', total_points=total_points'.$addsub.$points;
										}
									$sql .= ' WHERE user_id='.$this->dbObj->Param($row['user_id']);
									$stmt = $this->dbObj->Prepare($sql);
									$rs_user = $this->dbObj->Execute($stmt, array($row['user_id']));
									if (!$rs_user)
										    trigger_db_error($this->dbObj);

									//To store user_id of best solution
									$best_solution_user_id = 0;
									//Get user_id of the solutions posted in this board
									$sql = 'SELECT s.user_id, s.solution_id FROM '.$this->CFG['db']['tbl']['users_board_log'].' AS ubl, '.$this->CFG['db']['tbl']['solutions'].' AS s'.
											' WHERE ubl.user_id=s.user_id AND s.board_id='.$this->dbObj->Param($row['board_id']).' AND s.status=\'Active\'';
									$stmt = $this->dbObj->Prepare($sql);
									$rs_sol = $this->dbObj->Execute($stmt, array($row['board_id']));
									if (!$rs_sol)
										    trigger_db_error($this->dbObj);
									if ($total_sols = $rs_sol->PO_RecordCount())
										{
											while ($rowuser = $rs_sol->FetchRow()){
												//Update users_board_log for solutions owners
												$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].' AS ubl'.
														' SET total_solution=total_solution'.$addsub.'1';
												if($this->CFG['admin']['reply_solutions']['allowed'])
													{
														$points = $this->CFG['admin']['reply_solutions']['points'];
														$sql .= ', total_points=total_points'.$addsub.$points;
													}
												$sql .= ' WHERE ubl.user_id='.$this->dbObj->Param($rowuser['user_id']);
												$stmt = $this->dbObj->Prepare($sql);
												$rs_user = $this->dbObj->Execute($stmt, array($rowuser['user_id']));
												if (!$rs_user)
													    trigger_db_error($this->dbObj);

												if ($row['best_solution_id'] == $rowuser['solution_id'])
													$best_solution_user_id = $rowuser['user_id'];
											}
										}

									// update total_baords, total_solutions of category and parent categories
									$cat_sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
												' SET total_solutions=total_solutions'.$addsub.$this->dbObj->Param($total_sols).
												', total_boards=total_boards'.$addsub.'1'.
												' WHERE cat_id='.$this->dbObj->Param($row['pcat_id']);

									$cat_stmt = $this->dbObj->Prepare($cat_sql);
									$cat_rs = $this->dbObj->Execute($cat_stmt, array($total_sols, $row['pcat_id']));
									if (!$cat_rs)
									    trigger_db_error($this->dbObj);
									$this->updateParentCategories($row['pcat_id'], $addsub, $total_sols, true);

									//If best solution found
									if ($best_solution_user_id)
										{
											//Update best_solution_id points and counts
											$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].' AS ubl'.
													' SET total_best_solution=total_best_solution'.$addsub.'1';
											if($this->CFG['admin']['best_solutions']['allowed'])
												{
													$points = $this->CFG['admin']['best_solutions']['points'];
													$sql .= ', total_points=total_points'.$addsub.$points;
												}
											$sql .= ' WHERE ubl.user_id='.$this->dbObj->Param($best_solution_user_id);
											$stmt = $this->dbObj->Prepare($sql);
											$rs_user = $this->dbObj->Execute($stmt, array($best_solution_user_id));
											if (!$rs_user)
												    trigger_db_error($this->dbObj);
										}
								}
							}
					}

			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function populateCategory($parent_id)
		    {
				$sql = 'SELECT cat_name, cat_id FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE parent_id=0 ORDER BY cat_name';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					    trigger_db_error($this->dbObj);
				$this->populateCategories_arr	=	array();
				if ($rs->PO_RecordCount())
					{
						$inc=0;
						while($row = $rs->FetchRow())
						{
							$this->populateCategories_arr[$inc]['record']	=	$row;
							if($row['cat_id']==$parent_id)
								{
									$this->populateCategories_arr[$inc]['selected_chk']	=	'selected';
								}
							else
								{
									$this->populateCategories_arr[$inc]['selected_chk']	=	'';
								}
							$inc++;
						} // while
					}
				return $this->populateCategories_arr;
		    }

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function updateHasChild()
			{
				$cat_id = $this->fields_arr['cat_id'];
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE parent_id='.$this->dbObj->Param($cat_id).' AND status=\'Active\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				$has_child = '0';
				if ($rs->PO_RecordCount())
					$has_child = '1';

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
						' SET has_child='.$this->dbObj->Param($has_child).
						' WHERE cat_id='.$this->dbObj->Param($cat_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($has_child, $cat_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function setFormFieldsForOrder()
			{
				if (is_numeric($this->fields_arr['start']) AND $this->fields_arr['start'] >= 0)
					{
						$sql = 'SELECT cat_id FROM '.$this->CFG['db']['tbl']['category'].' as qc'.
								' WHERE parent_id=0'.
								' ORDER BY '.$this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'].
								' LIMIT '.$this->fields_arr['start'].', '.$this->fields_arr['numpg'];
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							    trigger_db_error($this->dbObj);
						if ($rs->PO_RecordCount())
							{
								while ($row = $rs->FetchRow()){
									$this->fields_arr['catid_'.$row['cat_id']] = 0;
								}
							}
					}

			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function validateFormFieldsForOrderAndUpdate()
			{
				//if (is_int($this->fields_arr['start']) OR 1)
				if (is_numeric($this->fields_arr['start']) AND $this->fields_arr['start'] >= 0)
					{
						$sql = 'SELECT cat_id FROM '.$this->CFG['db']['tbl']['category'].' as qc'.
								' WHERE parent_id=0'.
								' ORDER BY '.$this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'].
								' LIMIT '.$this->fields_arr['start'].', '.$this->fields_arr['numpg'];
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							    trigger_db_error($this->dbObj);
						if ($rs->PO_RecordCount())
							{
								while ($row = $rs->FetchRow()){
									$this->chkIsNotEmpty('catid_'.$row['cat_id'], $this->LANG['err_tip_compulsory']) and
										$this->chkIsNumeric('catid_'.$row['cat_id'], $this->LANG['discuzz_common_err_tip_numeric']);
								}
							}
						if (!$this->isValidFormInputs())
							{
								$this->setPageBlockShow('block_msg_form_error');
								$this->setCommonErrorMsg($this->LANG['category_err_tip_invalid_order']);
								return false;
							}
						else
							{
								$sql = 'SELECT cat_id FROM '.$this->CFG['db']['tbl']['category'].' as qc'.
										' WHERE parent_id=0'.
										' ORDER BY '.$this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'].
										' LIMIT '.$this->fields_arr['start'].', '.$this->fields_arr['numpg'];
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									    trigger_db_error($this->dbObj);
								if ($rs->PO_RecordCount())
									{
										while ($row = $rs->FetchRow()){
											$fieldName = 'catid_'.$row['cat_id'];
											$sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
													' SET disporder='.$this->dbObj->Param($this->fields_arr[$fieldName]).
													' WHERE cat_id='.$this->dbObj->Param($row['cat_id']);
											$stmt = $this->dbObj->Prepare($sql);
											$rs_update = $this->dbObj->Execute($stmt, array($this->fields_arr[$fieldName], $row['cat_id']));
											if (!$rs_update)
												    trigger_db_error($this->dbObj);
										}
									}
								$this->setPageBlockShow('block_msg_form_success');
								$this->setCommonSuccessMsg($this->LANG['category_updated_successfully']);
								return false;
							}
					}
			}
		/**
		 * DiscussionsFormHandler::deleteDiscussionsTable()
		 *
		 * @param mixed $discussion_ids
		 * @return
		 */
		public function deleteDiscussionsTable($discussion_ids)
			{
				//Get discussion_id, pcat_id then decrease the total_discussion count in category table..
				$res_sql = 'SELECT discussion_id, status, pcat_id FROM '.$this->CFG['db']['tbl']['discussions'].
							' WHERE discussion_id IN ('.$discussion_ids.') ';
				$res_stmt = $this->dbObj->Prepare($res_sql);
				$res_rs = $this->dbObj->Execute($res_stmt);
				if (!$res_rs)
					trigger_db_error($this->dbObj);

				if (!$res_rs->PO_RecordCount())
					return ;

				//Decrease number of total discussions..
				while($res_row=$res_rs->FetchRow())
					{
						if ($res_row['status'] == 'Active')
							{
								$ub_sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
											' SET total_discussions=total_discussions-1'.
											' WHERE cat_id ='.$res_row['pcat_id'];
								$ub_stmt = $this->dbObj->Prepare($ub_sql);
								$ub_rs = $this->dbObj->Execute($ub_stmt);
								if (!$ub_rs)
									trigger_db_error($this->dbObj);
							}
						if($this->checkDiscussionCategoryActive($res_row['discussion_id']))
							$this->deleteBoardsTable($res_row['discussion_id'], $res_row['status'], $res_row['pcat_id']);
					}

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['discussions'].' WHERE discussion_id IN ('.$discussion_ids.') ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);

				return true;
			}

		/**
		 * DiscussionsFormHandler::deleteBoardsTable()
		 *
		 * @param mixed $discussion_id
		 * @return
		 */
		public function deleteBoardsTable($discussion_id, $discuss_status, $pcat_id)
			{
				$sql = 'SELECT board_id, user_id, best_solution_id, status FROM '.$this->CFG['db']['tbl']['boards'].
						' WHERE discussion_id='.$this->dbObj->Param($discussion_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($discussion_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$topic_ids = 0;
				$board_ids_arr = array();
				$solution_ids_arr = array();
				while($row = $rs->FetchRow())
					{
						$board_ids_arr[] = $row['board_id'];
						if ($row['status'] == 'Active' AND $discuss_status == 'Active')
							{
								//Decrease total_boards by the user_id
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
										' SET total_board=total_board-1';
								if($this->CFG['admin']['ask_solutions']['allowed'])
									{
										$points = $this->CFG['admin']['ask_solutions']['points'];
										$sql .= ', total_points=total_points-'.$points;
									}
								$sql .= ' WHERE user_id='.$this->dbObj->Param($row['user_id']);
								$stmt = $this->dbObj->Prepare($sql);
								$rs_user = $this->dbObj->Execute($stmt, array($row['user_id']));
								if (!$rs_user)
									    trigger_db_error($this->dbObj);
							}

						//To store user_id of best solution
						$best_solution_user_id = 0;
						//Get user_id of the solutions posted in this board
						$sql = 'SELECT s.user_id, s.solution_id, s.status FROM '.$this->CFG['db']['tbl']['solutions'].' AS s'.
								' WHERE s.board_id='.$this->dbObj->Param($row['board_id']);
						$stmt = $this->dbObj->Prepare($sql);
						$rs_sol = $this->dbObj->Execute($stmt, array($row['board_id']));
						if (!$rs_sol)
							    trigger_db_error($this->dbObj);

						if ($total_sols = $rs_sol->PO_RecordCount())
							{
								while ($rowuser = $rs_sol->FetchRow()){
									$solution_ids_arr[] = $rowuser['solution_id'];
									if ($rowuser['status'] == 'Active' AND $row['status'] == 'Active' AND $discuss_status == 'Active')
										{
											//Update users_board_log for solutions owners
											$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].' AS ubl'.
													' SET total_solution=total_solution-1';
											if($this->CFG['admin']['reply_solutions']['allowed'])
												{
													$points = $this->CFG['admin']['reply_solutions']['points'];
													$sql .= ', total_points=total_points-'.$points;
												}
											$sql .= ' WHERE ubl.user_id='.$this->dbObj->Param($rowuser['user_id']);
											$stmt = $this->dbObj->Prepare($sql);
											$rs_user = $this->dbObj->Execute($stmt, array($rowuser['user_id']));
											if (!$rs_user)
												    trigger_db_error($this->dbObj);
										}

									if ($row['best_solution_id'] == $rowuser['solution_id'])
										$best_solution_user_id = $rowuser['user_id'];

								}
							}

							// update total_baords, total_solutions of category and parent categories
							$cat_sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
										' SET total_solutions=total_solutions-'.$this->dbObj->Param($total_sols).
										', total_boards=total_boards-1'.
										' WHERE cat_id='.$this->dbObj->Param($pcat_id);

							$cat_stmt = $this->dbObj->Prepare($cat_sql);
							$cat_rs = $this->dbObj->Execute($cat_stmt, array($total_sols, $pcat_id));
							if (!$cat_rs)
							    trigger_db_error($this->dbObj);
							$this->updateParentCategories($pcat_id, '-', $total_sols);

						//If best solution found
						if ($best_solution_user_id AND $row['status'] == 'Active' AND $discuss_status == 'Active')
							{
								//Update best_solution_id points and counts
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].' AS ubl'.
										' SET total_best_solution=total_best_solution-1';
								if($this->CFG['admin']['best_solutions']['allowed'])
									{
										$points = $this->CFG['admin']['best_solutions']['points'];
										$sql .= ', total_points=total_points-'.$points;
									}
								$sql .= ' WHERE ubl.user_id='.$this->dbObj->Param($best_solution_user_id);
								$stmt = $this->dbObj->Prepare($sql);
								$rs_user = $this->dbObj->Execute($stmt, array($best_solution_user_id));
								if (!$rs_user)
									    trigger_db_error($this->dbObj);
							}

						//Delete solutions posted in this board
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['solutions'].' WHERE board_id='.$this->dbObj->Param($row['board_id']);
						$stmt = $this->dbObj->Prepare($sql);
						$rs_sol = $this->dbObj->Execute($stmt, array($row['board_id']));
						if (!$rs_sol)
							    trigger_db_error($this->dbObj);
					} // while

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['boards'].' WHERE discussion_id='.$this->dbObj->Param($discussion_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($discussion_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				//to delete boards attachments
				if(count($board_ids_arr) > 0)
					{
						$board_attach_ids = implode(",", $board_ids_arr);
						$this->commonDeleteAttachments('Board', $board_attach_ids);
					}
				//to delete solutions attachments
				if(count($solution_ids_arr) > 0)
					{
						$solution_attach_ids = implode(",", $solution_ids_arr);
						$this->commonDeleteAttachments('Solution', $solution_attach_ids);
					}
				return true;
			}
		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getDiscussionIds($parent_id)
		    {
				$sql = 'SELECT discussion_id FROM '.$this->CFG['db']['tbl']['discussions'].
						' WHERE pcat_id='.$this->dbObj->Param($parent_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($parent_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$discussion_array = array();
				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
						{
							$discussion_array[] = $row['discussion_id'];
						} // while
					}
				return $discussion_array;
		    }
		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function moveCategories($valid_discussion_ids)
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].
						' SET pcat_id='.$this->dbObj->Param($this->current_category_id).
						' WHERE discussion_id IN ('.$valid_discussion_ids.')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->current_category_id));
				if (!$rs)
			    	trigger_db_error($this->dbObj);
		    }

	}
//<<<<<---------------class discussionCategoryFormHandler------///
//--------------------Code begins-------------->>>>>//
$categoryfrm = new discussionCategoryFormHandler();
$categoryfrm->setPageBlockNames(array('form_add_category', 'form_view_category', 'form_view_sub_category', 'form_add_sub_category', 'form_add_subcategory', 'sublevel_msg_block', 'form_edit_category_ajax'));
// Set the form fields
$categoryfrm->setFormField('user_id', '');
$categoryfrm->setFormField('category', '');
$categoryfrm->setFormField('seo_title', '');
$categoryfrm->setFormField('parent_id', 0);
$categoryfrm->setFormField('status', 'Active');
$categoryfrm->setFormField('cat_id', '');
$categoryfrm->setFormField('sub_cat_id', '');
$categoryfrm->setFormField('cat_ids', array());
$categoryfrm->setFormField('sub_cat_ids', array());
$categoryfrm->setFormField('action', '');
$categoryfrm->setFormField('mode', '');
$categoryfrm->setFormField('msg', '');
$categoryfrm->setFormField('description', '');
$categoryfrm->setFormField('orderby_field', 'qc.disporder');
$categoryfrm->setFormField('orderby', 'ASC');
$categoryfrm->setFormField('is_restricted', 'No');
$categoryfrm->action_arr = array('' => $LANG['discuzz_common_select_action'],
					'Active' => $LANG['discuzz_common_activate'],
					'Inactive' => $LANG['discuzz_common_inactivate'],
					'Delete' => $LANG['discuzz_common_delete']
					);

// Default page block
$categoryfrm->setAllPageBlocksHide();
/*********** Page Navigation Start *********/
$categoryfrm->setFormField('start', 0);
$categoryfrm->setFormField('numpg', $CFG['data_tbl']['numpg']);
$categoryfrm->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$categoryfrm->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$categoryfrm->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);

$categoryfrm->setTableNames(array($CFG['db']['tbl']['category'].' AS qc'));
$categoryfrm->setReturnColumns(array('qc.cat_id', 'qc.cat_name', 'qc.disporder', 'qc.seo_title', 'CASE WHEN qc.status=1 THEN \''.$LANG['discuzz_common_display_active'].'\' ELSE \''.$LANG['discuzz_common_display_inactive'].'\' END AS status', 'qc.date_added', 'qc.restricted'));
/************ page Navigation stop *************/
$categoryfrm->sanitizeFormInputs($_REQUEST);
$categoryfrm->setFormFieldsForOrder();
$categoryfrm->sanitizeFormInputs($_REQUEST);

if($categoryfrm->getFormField('mode') == 'editSubLevel')
	{
		$cat_id = $categoryfrm->getFormField('sub_cat_id');
		$categoryfrm->setAllPageBlocksHide();
		$categoryfrm->chkIsNotEmpty('category', $LANG['err_tip_compulsory'])and
			$categoryfrm->chkSubCategoryExists($LANG['category_err_tip_category_exists']);
		$categoryfrm->chkCharLength('category', $LANG['category_length_error']);
		$categoryfrm->chkIsNotEmpty('description', $LANG['err_tip_compulsory']);
		$showcat = $LANG['category_subtitle_edit_sub_category'];
		$smartyObj->assign('categoryName', $showcat);

		if ($categoryfrm->isValidFormInputs())
			{
				$categoryfrm->setFormField('seo_title', $categoryfrm->getSeoTitleFordiscussionCategory($categoryfrm->getFormField('category'), $categoryfrm->getFormField('sub_cat_id')));
				$categoryfrm->updateCategory('sub_cat_id');
				$categoryfrm->setFormField('cat_id', $categoryfrm->getFormField('parent_id'));
				$categoryfrm->updateHasChild();
				$caturl = '<a href=discussionCategory.php?mode=viewsubcategory&cat_id='.$cat_id.'>'.htmlspecialchars($categoryfrm->getFormField('category')).'</a>';
				?>
				<script language="javascript" type="text/javascript">
					document.getElementById('catNameDiv'+<?php echo $cat_id;?>).innerHTML = "<?php echo $caturl;?>";
					//document.getElementById('catNameDiv'+<?php echo $cat_id;?>).innerHTML = "<?php echo htmlspecialchars($categoryfrm->getFormField('category'));?>";
					document.getElementById('restrict_'+<?php echo $cat_id;?>).innerHTML = "<?php echo $categoryfrm->getFormField('is_restricted');?>";
					hideAllBlocks();
				</script>
				<?php
			}
		else
			{
				$categoryfrm->includeAjaxHeader();
				if($categoryfrm->isValidCategoryId('sub_cat_id'))
				{
					$categoryfrm->setFormField('category', $categoryfrm->link_details_arr['cat_name']);
					$categoryfrm->setFormField('cat_id', $categoryfrm->getFormField('parent_id'));
					$categoryfrm->setFormField('description', $categoryfrm->link_details_arr['description']);
					$categoryfrm->setFormField('is_restricted', $categoryfrm->link_details_arr['restricted']);
				}
				$categoryfrm->setPageBlockShow('form_add_subcategory');
				$categoryfrm->setCommonErrorMsg($categoryfrm->getCommonErrorMsg().$LANG['discuzz_common_msg_error_sorry']);
				$categoryfrm->setPageBlockShow('block_msg_form_error');
				setTemplateFolder('admin/', $CFG['admin']['index']['home_module']);
				$smartyObj->display('discussionCategory.tpl');
				$categoryfrm->includeAjaxFooter();
			}
		die();
	}

if($categoryfrm->getFormField('mode') == 'addSubLevel')
	{
		$cat_id = $categoryfrm->getFormField('parent_id');
		$categoryfrm->setAllPageBlocksHide();
		$categoryfrm->chkIsNotEmpty('category', $LANG['err_tip_compulsory'])and
			$categoryfrm->chkSubCategoryExists($LANG['category_err_tip_category_exists']);
		$categoryfrm->chkCharLength('category', $LANG['category_length_error']);
		$categoryfrm->chkIsNotEmpty('description', $LANG['err_tip_compulsory']);
		$showcat = $categoryfrm->showCategoryName($cat_id);
		$smartyObj->assign('categoryName', $showcat);

		if ($categoryfrm->isValidFormInputs())
			{
				$categoryfrm->setFormField('seo_title', $categoryfrm->getSeoTitleFordiscussionCategory($categoryfrm->getFormField('category'), $categoryfrm->getFormField('cat_id')));
				$categoryfrm->setFormField('status', 'Active');

				// Check if parent has sub categories
				$discussion_array = array();
				if(!$categoryfrm->getSubCategoriesList($categoryfrm->getFormField('parent_id'), 1))
					{
						$discussion_array = $categoryfrm->getDiscussionIds($categoryfrm->getFormField('parent_id'));
					}
				$categoryfrm->insertCategory();

				// Move the parent category discussions to its newly added sub category
				/*if(count($discussion_array))
					{
						$valid_discussion_ids = implode(',', $discussion_array);
						$categoryfrm->moveCategories($valid_discussion_ids);
					}
				*/
				$categoryfrm->setFormField('cat_id', $categoryfrm->getFormField('parent_id'));
				$categoryfrm->updateHasChild();
				$categoryfrm->includeAjaxHeader();
				$categoryfrm->add_category_link = 'discussionCategory.php?mode=showSubLevelForm&cat_id='.$cat_id;
				$subcat_count = $categoryfrm->getSubcategoryCount($cat_id);
				?>
				<script defer="defer" language="javascript" type="text/javascript">
					document.getElementById('subcat'+<?php echo $cat_id;?>).innerHTML = '<?php echo $subcat_count;?>';
				</script>
				<?php
				$categoryfrm->setPageBlockShow('sublevel_msg_block');
				setTemplateFolder('admin/', $CFG['admin']['index']['home_module']);
				$smartyObj->display('discussionCategory.tpl');
				$categoryfrm->includeAjaxFooter();
			}
		else
			{
				$categoryfrm->includeAjaxHeader();
				$showcat = $LANG['category_subtitle_edit_sub_category'];
				$categoryfrm->setFormField('cat_id', $cat_id);
				$categoryfrm->setPageBlockShow('form_add_subcategory');
				$categoryfrm->setCommonErrorMsg($categoryfrm->getCommonErrorMsg().$LANG['discuzz_common_msg_error_sorry']);
				$categoryfrm->setPageBlockShow('block_msg_form_error');
				setTemplateFolder('admin/', $CFG['admin']['index']['home_module']);
				$smartyObj->display('discussionCategory.tpl');
				$categoryfrm->includeAjaxFooter();
			}
		die();
	}

if($categoryfrm->getFormField('mode') == 'showSubLevelForm')
	{
		$categoryfrm->includeAjaxHeader();
		$categoryfrm->setAllPageBlocksHide();

		if($categoryfrm->getFormField('sub_cat_id'))
			{
				$categoryfrm->isValidCategoryId('sub_cat_id');
				$showcat = $LANG['category_subtitle_edit_sub_category'];
				$categoryfrm->setFormField('category', $categoryfrm->link_details_arr['cat_name']);
				$categoryfrm->setFormField('description', $categoryfrm->link_details_arr['description']);
				$categoryfrm->setFormField('is_restricted', $categoryfrm->link_details_arr['restricted']);
			}
		else
			{
				$categoryfrm->isValidCategoryId('cat_id');
				$showcat = $categoryfrm->link_details_arr['cat_name'];
			}


		$smartyObj->assign('categoryName', $showcat);
		$categoryfrm->setPageBlockShow('form_add_subcategory');
		setTemplateFolder('admin/', $CFG['admin']['index']['home_module']);
		$smartyObj->display('discussionCategory.tpl');
		$categoryfrm->includeAjaxFooter();
		die();
	}

if($categoryfrm->getFormField('mode') == 'showCategoryForm')
	{
		$categoryfrm->includeAjaxHeader();
		$categoryfrm->setAllPageBlocksHide();

		if($categoryfrm->isValidCategoryId('cat_id'))
			{
				$showcat = $categoryfrm->link_details_arr['cat_name'];
				$smartyObj->assign('categoryName', $showcat);
				$categoryfrm->setFormField('category', $categoryfrm->link_details_arr['cat_name']);
				$categoryfrm->setFormField('description', $categoryfrm->link_details_arr['description']);
				$categoryfrm->setFormField('is_restricted', $categoryfrm->link_details_arr['restricted']);
			}

		$categoryfrm->setPageBlockShow('form_edit_category_ajax');
		setTemplateFolder('admin/', $CFG['admin']['index']['home_module']);
		$smartyObj->display('discussionCategory.tpl');
		$categoryfrm->includeAjaxFooter();
		die();
	}
if($categoryfrm->getFormField('mode') == 'editParentCategory')
	{
		$cat_id = $categoryfrm->getFormField('cat_id');
		$categoryfrm->setAllPageBlocksHide();
		$categoryfrm->chkIsNotEmpty('category', $LANG['err_tip_compulsory'])and
			$categoryfrm->chkCategoryExists($LANG['category_err_tip_category_exists']);
		$categoryfrm->chkCharLength('category', $LANG['category_length_error']);
		$categoryfrm->chkIsNotEmpty('description', $LANG['err_tip_compulsory']);
		$showcat = $LANG['category_subtitle_edit_category'];
		$smartyObj->assign('categoryName', $showcat);

		if ($categoryfrm->isValidFormInputs())
			{
				$categoryfrm->setFormField('seo_title', $categoryfrm->getSeoTitleFordiscussionCategory($categoryfrm->getFormField('category'), $categoryfrm->getFormField('sub_cat_id')));
				$categoryfrm->updateCategory('cat_id');
				$caturl = '<a href=discussionCategory.php?mode=viewsubcategory&cat_id='.$cat_id.'>'.htmlspecialchars($categoryfrm->getFormField('category')).'</a>';
				?>
				<script language="javascript" type="text/javascript">
					document.getElementById('catNameDiv'+<?php echo $cat_id;?>).innerHTML = "<?php echo $caturl;?>";
					document.getElementById('restrict_'+<?php echo $cat_id;?>).innerHTML = "<?php echo $categoryfrm->getFormField('is_restricted');?>";
					hideAllBlocks();
				</script>
				<?php
			}
		else
			{
				$categoryfrm->includeAjaxHeader();
				if($categoryfrm->isValidCategoryId('sub_cat_id'))
					{
						$showcat = $categoryfrm->link_details_arr['cat_name'];
						$smartyObj->assign('categoryName', $showcat);
						$categoryfrm->setFormField('category', $categoryfrm->link_details_arr['cat_name']);
						$categoryfrm->setFormField('description', $categoryfrm->link_details_arr['description']);
						$categoryfrm->setFormField('is_restricted', $categoryfrm->link_details_arr['restricted']);
					}
				//$categoryfrm->setFormField('category', $categoryfrm->showCategoryName($categoryfrm->getFormField('sub_cat_id')));
				$categoryfrm->setPageBlockShow('form_edit_category_ajax');
				$categoryfrm->setCommonErrorMsg($categoryfrm->getCommonErrorMsg().$LANG['discuzz_common_msg_error_sorry']);
				$categoryfrm->setPageBlockShow('block_msg_form_error');
				setTemplateFolder('admin/', $CFG['admin']['index']['home_module']);
				$smartyObj->display('discussionCategory.tpl');
				$categoryfrm->includeAjaxFooter();
			}
		die();
	}


$categoryfrm->setPageBlockShow('form_view_category');
if ($categoryfrm->isFormPOSTed($_POST, 'update_order'))
	{
		$categoryfrm->validateFormFieldsForOrderAndUpdate();
		Redirect2URL($CFG['site']['relative_url'].'discussionCategory.php');
	}
if ($categoryfrm->isFormPOSTed($_POST, 'add_category'))
	{
		// Validations
		$categoryfrm->chkIsNotEmpty('status', $LANG['err_tip_compulsory']);
		$categoryfrm->chkIsNotEmpty('category', $LANG['err_tip_compulsory'])and
			$categoryfrm->chkCategoryExists($LANG['category_err_tip_category_exists']);
		$categoryfrm->chkCharLength('category', $LANG['category_length_error']);
		$categoryfrm->chkIsNotEmpty('description', $LANG['err_tip_compulsory']);
		if ($categoryfrm->isValidFormInputs())
			{
				$categoryfrm->setFormField('seo_title', $categoryfrm->getSeoTitleFordiscussionCategory($categoryfrm->getFormField('category'), $categoryfrm->getFormField('cat_id')));
				if ($categoryfrm->getFormField('cat_id'))
					{
						$categoryfrm->updateCategory('cat_id');
						Redirect2URL($CFG['site']['relative_url'].'discussionCategory.php?msg=updated');
					}
				else
					{
						$categoryfrm->insertCategory();
						Redirect2URL($CFG['site']['relative_url'].'discussionCategory.php?msg=added');
					}
			}
		else
			{
				$categoryfrm->setAllPageBlocksHide();
				$categoryfrm->setPageBlockShow('form_add_category');
				$categoryfrm->setCommonErrorMsg($categoryfrm->getCommonErrorMsg().$LANG['discuzz_common_msg_error_sorry']);
				$categoryfrm->setPageBlockShow('block_msg_form_error');
			}
	}
elseif ($categoryfrm->isFormPOSTed($_POST, 'add_sub_category'))
	{
		// Validations
		$categoryfrm->chkIsNotEmpty('parent_id', $LANG['err_tip_compulsory']);
		$categoryfrm->chkIsNotEmpty('status', $LANG['err_tip_compulsory']);
		$categoryfrm->chkIsNotEmpty('category', $LANG['err_tip_compulsory'])and
			$categoryfrm->chkSubCategoryExists($LANG['category_err_tip_sub_category_exists']);
		$categoryfrm->chkCharLength('category', $LANG['category_length_error']);
		if ($categoryfrm->isValidFormInputs())
			{
				$categoryfrm->setFormField('seo_title', $categoryfrm->getSeoTitleFordiscussionCategory($categoryfrm->getFormField('category'), $categoryfrm->getFormField('cat_id')));
				if ($categoryfrm->getFormField('sub_cat_id'))
					{
						$categoryfrm->updateCategory('sub_cat_id');
						$categoryfrm->setFormField('cat_id', $categoryfrm->getFormField('parent_id'));
						$categoryfrm->updateHasChild();
						Redirect2URL($CFG['site']['relative_url'].'discussionCategory.php?mode=viewsubcategory&cat_id='.$categoryfrm->getFormField('parent_id').'&msg=updatedsub');
					}
				else
					{
						$categoryfrm->insertCategory();
						$categoryfrm->setFormField('cat_id', $categoryfrm->getFormField('parent_id'));
						$categoryfrm->updateHasChild();
						Redirect2URL($CFG['site']['relative_url'].'discussionCategory.php?mode=viewsubcategory&cat_id='.$categoryfrm->getFormField('parent_id').'&msg=addedsub');
					}
			}
		else
			{
				$categoryfrm->setAllPageBlocksHide();
				$categoryfrm->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
				$categoryfrm->setPageBlockShow('block_msg_form_error');
				$categoryfrm->setPageBlockShow('form_add_sub_category');
			}
	}
elseif ($categoryfrm->isFormPOSTed($_POST, 'confirm_action'))
	{
		// Validations
		$categoryfrm->chkIsNotEmpty('cat_ids', $LANG['err_tip_compulsory'])or
			$categoryfrm->setCommonErrorMsg($LANG['category_err_tip_select_category']);
		$categoryfrm->chkIsNotEmpty('action', $LANG['err_tip_compulsory'])or
			$categoryfrm->setCommonErrorMsg($LANG['err_tip_select_action']);
		if ($categoryfrm->isValidFormInputs())
			{
				$categoryfrm->setAllPageBlocksHide();
				$categoryfrm->setPageBlockShow('block_msg_form_success');
				switch($categoryfrm->getFormField('action')){
					case 'Active':
						if($categoryfrm->updateAction('status', 'Active'))
							$categoryfrm->setCommonSuccessMsg($LANG['category_success_activate']);
						else
							$categoryfrm->setCommonSuccessMsg($LANG['parent_category_inactive']);
						break;
					case 'Inactive':
						if($categoryfrm->updateAction('status', 'Inactive'))
							$categoryfrm->setCommonSuccessMsg($LANG['category_success_inactivate']);
						else
							$categoryfrm->setCommonSuccessMsg($LANG['parent_category_inactive2']);
						break;
					case 'Delete':
						$categoryfrm->deleteDiscussionCategories();
						$redirectUrl = 'discussionCategory.php?msg=delted';
						if($categoryfrm->getFormField('mode'))
							$redirectUrl.='&mode='.$categoryfrm->getFormField('mode');
						if($categoryfrm->getFormField('cat_id'))
							$redirectUrl.='&cat_id='.$categoryfrm->getFormField('cat_id');

						Redirect2URL($CFG['site']['relative_url'].$redirectUrl);
						$categoryfrm->setCommonSuccessMsg($LANG['category_success_message_for_delete']);
						break;
				} // switch
				if ($categoryfrm->getFormField('cat_id'))
					{
						$categoryfrm->setPageBlockShow('form_view_sub_category');
						$categoryfrm->updateHasChild();
					}
				else
					{
						$categoryfrm->setPageBlockShow('form_view_category');
					}
			}
		else
			{
				$categoryfrm->setAllPageBlocksHide();
				$categoryfrm->setPageBlockShow('block_msg_form_error');
			}
	}
elseif ($categoryfrm->isFormPOSTed($_POST, 'cancel'))
	{
		$mode = $categoryfrm->getFormField('mode');
		$catId = $categoryfrm->getFormField('parent_id');
		if ($catId AND strcmp($mode, 'editsubcategory')==0)
			Redirect2URL($CFG['site']['relative_url'].'discussionCategory.php?mode=viewsubcategory&cat_id='.$catId);

		Redirect2URL($CFG['site']['relative_url'].'discussionCategory.php');
	}
elseif ($categoryfrm->isFormGETed($_GET, 'cat_id'))
	{
		$categoryfrm->chkIsNotEmpty('cat_id', $LANG['err_tip_compulsory'])and
			$categoryfrm->isValidCategoryId('cat_id', $LANG['category_err_tip_invalid_id']);
		if ($categoryfrm->isValidFormInputs())
			{
				$categoryfrm->setFormField('category', $categoryfrm->link_details_arr['cat_name']);
				$categoryfrm->setFormField('status', $categoryfrm->link_details_arr['status']);
			}
		else
			{
				$categoryfrm->setAllPageBlocksHide();
				$categoryfrm->setPageBlockShow('block_msg_form_error');
			}
	}
elseif ($categoryfrm->isFormGETed($_GET, 'sub_cat_id'))
	{
		$categoryfrm->chkIsNotEmpty('sub_cat_id', $LANG['err_tip_compulsory'])and
			$categoryfrm->isValidCategoryId('sub_cat_id', $LANG['category_err_tip_invalid_id']);
		if ($categoryfrm->isValidFormInputs())
			{
				$categoryfrm->setFormField('category', $categoryfrm->link_details_arr['cat_name']);
				$categoryfrm->setFormField('parent_id', $categoryfrm->link_details_arr['parent_id']);
				$categoryfrm->setFormField('status', $categoryfrm->link_details_arr['status']);
			}
		else
			{
				$categoryfrm->setAllPageBlocksHide();
				$categoryfrm->setPageBlockShow('block_msg_form_error');
			}
	}
if ($categoryfrm->isPageGETed($_GET, 'mode') && $categoryfrm->isValidFormInputs())
    {
		$mode = $categoryfrm->getFormField('mode');
		$catId = $categoryfrm->getFormField('cat_id');
		$subCatId = $categoryfrm->getFormField('sub_cat_id');
		if ($catId AND strcmp($mode, 'edit')==0)
		    {
				$categoryfrm->setAllPageBlocksHide();
				$categoryfrm->setPageBlockShow('form_add_category');
		    }
		elseif ($subCatId AND strcmp($mode, 'editsubcategory')==0)
		    {
		        $categoryfrm->setAllPageBlocksHide();
				$categoryfrm->setPageBlockShow('form_add_sub_category');
		    }
		elseif ($catId AND strcmp($mode, 'viewsubcategory')==0 AND $categoryfrm->isValidFormInputs())
			{
				$categoryfrm->setAllPageBlocksHide();
				$categoryfrm->setPageBlockShow('form_view_sub_category');
			}
		else if (strcmp($mode, 'add')==0)
         	{
				$categoryfrm->setAllPageBlocksHide();
				$categoryfrm->setPageBlockShow('form_add_category');
	        }
		else if (strcmp($mode, 'addsubcategory')==0)
         	{
				$categoryfrm->setAllPageBlocksHide();
	            $categoryfrm->setPageBlockShow('form_add_sub_category');
	        }
    }
if ($categoryfrm->isPageGETed($_GET, 'msg'))
	{
		$categoryfrm->setPageBlockShow('block_msg_form_success');
		switch($categoryfrm->getFormField('msg'))
			{
				case 'added':
					$categoryfrm->setCommonSuccessMsg($LANG['category_success_message']);
					break;
				case 'addedsub':
					$categoryfrm->setCommonSuccessMsg($LANG['subcategory_success_message']);
					break;
				case 'updated':
					$categoryfrm->setCommonSuccessMsg($LANG['category_success_update_message']);
					break;
				case 'updatedsub':
					$categoryfrm->setCommonSuccessMsg($LANG['subcategory_success_update_message']);
					break;
				case 'delted':
					$categoryfrm->setCommonSuccessMsg($LANG['category_success_message_for_delete']);
					break;
			} // switch
	}
$categoryfrm->discussionCategoryCommon['title']	=	$title = $LANG['category_title'];
if ($categoryfrm->isShowPageBlock('form_add_category'))
	{
		$categoryfrm->discussionCategoryCommon['title']	=	$title = $LANG['category_add'];
		$catId = $categoryfrm->getFormField('cat_id');
		if ($catId)
		    {
		       $categoryfrm->discussionCategoryCommon['title']	=	 $title = $LANG['category_subtitle_edit_category'];
		    }
	}
if ($categoryfrm->isShowPageBlock('form_add_sub_category'))
	{
		$categoryfrm->discussionCategoryCommon['title']	=	$title = $LANG['category_add_sub'];
		$subCatId = $categoryfrm->getFormField('sub_cat_id');
		if ($subCatId)
		    {
		        $categoryfrm->discussionCategoryCommon['title']	=	$title = $LANG['category_subtitle_edit_sub_category'];
		    }
		$categoryfrm->form_add_sub_category['populateCategories']	=	$categoryfrm->populateCategory($categoryfrm->getFormField('parent_id'));
	}
//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//
if ($categoryfrm->isShowPageBlock('form_add_category'))
	{
		$catId = $categoryfrm->getFormField('cat_id');
		$categoryfrm->form_add_category['hidden_array']	=	array('start');
	}
if ($categoryfrm->isShowPageBlock('form_add_sub_category'))
	{
		$subCatId = $categoryfrm->getFormField('sub_cat_id');
		$categoryfrm->form_add_sub_category['hidden_array']	=	array('start', 'mode');
	}
if ($categoryfrm->isShowPageBlock('form_view_category'))
	{
		/****** navigtion continue*********/
		$categoryfrm->buildSelectQuery();
		$categoryfrm->buildConditionQuery();
		$categoryfrm->buildSortQuery();
		$categoryfrm->buildQuery();
		$categoryfrm->executeQuery();
		//$categoryfrm->printQuery();
		$categoryfrm->pagingArr[] = 'start';
		$categoryfrm->pagingArr[] = 'orderby_field';
		$categoryfrm->pagingArr[] = 'orderby';

		$smartyObj->assign('paging_arr', $categoryfrm->pagingArr);
		$smartyObj->assign('smarty_paging_list', $categoryfrm->populatePageLinksPOST($categoryfrm->getFormField('start'), 'formViewCategory'));
		//$smartyObj->assign('smarty_paging_list', $categoryfrm->populatePageLinksGET($categoryfrm->getFormField('start'), array('orderby_field', 'orderby')));

		$categoryfrm->form_view_category['showCategory']	=	$categoryfrm->showCategory();
		//$categoryfrm->form_view_category['hidden_array']	=	array('start', 'orderby_field', 'orderby', 'mode');
	}
if ($categoryfrm->isShowPageBlock('form_view_sub_category'))
	{
		/****** navigtion continue*********/
		$categoryfrm->buildSelectQuery();
		$categoryfrm->ConditionQuery();
		$categoryfrm->buildSortQuery();
		$categoryfrm->buildQuery();
		$categoryfrm->executeQuery();
		$categoryfrm->pagingArr[] = 'start';
		$categoryfrm->pagingArr[] = 'orderby_field';
		$categoryfrm->pagingArr[] = 'orderby';
		$categoryfrm->pagingArr[] = 'mode';
		$categoryfrm->pagingArr[] = 'cat_id';

		$smartyObj->assign('paging_arr', $categoryfrm->pagingArr);
		$smartyObj->assign('smarty_paging_list', $categoryfrm->populatePageLinksPOST($categoryfrm->getFormField('start'), 'formViewCategory'));
		//$smartyObj->assign('smarty_paging_list', $categoryfrm->populatePageLinksGET($categoryfrm->getFormField('start'), array('mode', 'cat_id', 'orderby_field', 'orderby')));
		$LANG['category_activage_msg'] = $LANG['category_activage_submsg'];
		$LANG['category_inactivage_msg'] = $LANG['category_inactivage_submsg'];
		$categoryfrm->form_view_sub_category['showSubCategory']	=	$categoryfrm->showSubCategory();
		$categoryfrm->form_view_sub_category['hidden_array']	=	array('start', 'mode', 'cat_id', 'orderby_field', 'orderby');
	}
$categoryfrm->category_index = $LANG['categories_index'];
if($categoryfrm->getFormField('cat_id'))
	{
		$categoryfrm->category_index = '<a href="discussionCategory.php">'.$LANG['categories_index'].'</a>';
		$categoryfrm->showAllCategoriesName($categoryfrm->getFormField('cat_id'));
		$categoryfrm->categoryNameList = array_reverse($categoryfrm->categoryNameList);
	}

$categoryfrm->left_navigation_div = 'discussionsMain';
//include the header file
$categoryfrm->includeHeader();
//include the content of the page
setTemplateFolder('admin/', $CFG['admin']['index']['home_module']);
$smartyObj->display('discussionCategory.tpl');
//include the footer of the page
?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction()
		{
			var act_value = document.formViewCategory.action.value;
			if(act_value)
				{
					switch (act_value)
						{
							case 'Active':
								confirm_message = '<?php echo $LANG['category_activage_msg'];?>';
								break;
							case 'Inactive':
								confirm_message = '<?php echo $LANG['category_inactivage_msg'];?>';
								break;
							case 'Delete':
								confirm_message = '<?php echo $LANG['category_delete_confirm_msg'];?>';
								break;
						}
					$Jq('#confirmMessage').html(confirm_message);
					document.formConfirm.action.value = act_value;
					Confirmation('selMsgConfirm', 'formConfirm', Array('cat_ids'), Array(multiCheckValue), Array('value'), 'formViewCategory');
				}
				else
					alert_manual(please_select_action);
		}
</script>
<?php
//<<<<<<--------------------Page block templates Ends--------------------//
$categoryfrm->includeFooter();
?>