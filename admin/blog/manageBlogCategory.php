<?php
/**
* This file is to manage the Blog Category
*
* This file is having Blog Category
*
*
* @category	    Rayzz Blogs
* @package		Admin
* @copyright 	Copyright (c) 2010 {@link http://www.mediabox.uz Uzdc Infoway}
* @license		http://www.mediabox.uz Uzdc Infoway Licence
**/

require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/blog/admin/manageBlogCategory.php';
$CFG['lang']['include_files'][] = 'languages/%s/blog/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page'] = 'blog';
require_once($CFG['site']['project_path'] . 'common/application_top.inc.php');

class ManageBlogCategory extends MediaHandler
{
	public $category_details_arr = array();
	/**
	 * ManageBlogCategory::resetFieldsArray()
	 *
	 * @return void
	 */
	public function resetFieldsArray()
	{
		$this->setFormField('category', '');
		$this->setFormField('sub_category', '');
		$this->setFormField('category_image', '');
		$this->setFormField('category_id', '');
		$this->setFormField('sub_category_id', '');
		$this->setFormField('category_description', '');
		$this->setFormField('blog_category_ext', '');
		$this->setFormField('status', 'Yes');
		$this->setFormField('category_ids', array());
		$this->setFormField('allow_post', 'Yes');
		$this->setFormField('action', '');
		$this->setFormField('opt', '');
		$this->setFormField('blog_category_type', 'General');
		$this->setFormField('priority', '');
		$this->setFormField('blog_category_id', '');
	}


	/**
	 * ManageBlogCategory::chkIsEditMode()
	 *
	 * @return boolean
	 */
	public function chkIsEditMode()
	{
		if($this->fields_arr['category_id'])
			return true;
		return false;
	}

   /**
	* ManageBlogCategory::chkIsEditModeSubCategory()
	*
	* @return boolean
	*/
	public function chkIsEditModeSub()
	{
		if($this->fields_arr['category_id'] and $this->fields_arr['opt']=='subedit')
		return true;
		return false;
	}

   /**
	* ManageBlogCategory::buildConditionQuery()
	* set the condition
	*
	* @param string $condition
	* @return void
	*/
	public function buildConditionQuery($condition='')
	{
		$this->sql_condition = $condition;
	}

	/**
	 * ManageBlogCategory::checkSortQuery()
	 *
	 * @param mixed $field
	 * @param string $sort
	 * @return void
	 */
	public function checkSortQuery($field, $sort='asc')
	{
		if(!($this->sql_sort))
		{
			$this->sql_sort = $field . ' ' . $sort;
		}
	}

   /**
	* ManageBlogCategory::isValidCategoryId()
	* To check the blog_category_id is valid or not
	*
	* @param Integer $category_id
	* @param string $err_tip
	* @return boolean
	*/
	public function isValidCategoryId($category_id, $err_tip='')
	{
		$sql = 'SELECT blog_category_id, 	blog_category_description,'.
		' blog_category_name, blog_category_status, date_added, blog_category_type, allow_post, blog_category_ext, priority'.
		' FROM '.$this->CFG['db']['tbl']['blog_category'].
		' WHERE blog_category_id = '.$this->dbObj->Param($this->fields_arr[$category_id]);
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$category_id]));
		if (!$rs)
			trigger_db_error($this->dbObj);
		if ($this->category_details_arr = $rs->FetchRow())
		{
			return true;
		}
		$this->setCommonErrorMsg($err_tip);
		return false;
	}

   /**
	* ManageBlogCategory::chkValidFileType()
	*
	* @param string $field_name
	* @param string $err_tip
	* @return boolean
	*/
	public function chkValidFileType($field_name, $err_tip = '')
	{
		$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));
		if($extern!='')
		{
			if (!in_array($extern, $this->CFG['admin']['blog']['category_image_format_arr']))
			{
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}
		}
		return true;
	}

   /**
	* ManageBlogCategory::chkValideFileSize()
	*
	* @param string $field_name
	* @param string $err_tip
	* @return boolean
	*/
	public function chkValideFileSize($field_name, $err_tip='')
	{
		$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));
		if($extern!='')
		{
			$max_size = $this->CFG['admin']['blog']['category_image_max_size'] * 1024;
			if ($_FILES[$field_name]['size'] > $max_size)
			{
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}
		}
		return true;
	}
	/**
	* ManageBlogCategory::chkErrorInFile()
	*
	* @param string $field_name
	* @param string $err_tip
	* @return boolean
	*/
	public function chkErrorInFile($field_name, $err_tip='')
	{
		$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));
		if($extern!='')
		{
			if($_FILES[$field_name]['error'])
			{
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}
		}
		return true;
	}

   /**
	* ManageBlogCategory::getLastPriority()
	*
	* @param mixed $table
	* @param mixed $parent_category_id
	* @return
	*/
	public function getLastPriority($table, $parent_category_id)
	{
		$sql = 'SELECT max(priority) as last_priority_value '.'FROM '.$this->CFG['db']['tbl'][$table].' WHERE parent_category_id = \''.$parent_category_id.'\'';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_db_error($this->dbObj);
		$row = $rs->FetchRow();
		return $row['last_priority_value'];
	}

   /**
	* ManageBlogCategory::getPriorityOrder()
	*
	* @param integer $priority_order
	* @param string $table
	* @param string $action
	* @param int $parent_category_id
	* @return
	*/
	public function getPriorityOrder($priority_order, $table, $action, $parent_category_id)
	{
		$getLastPriority = $this->getLastPriority($table, $parent_category_id);
		if($priority_order == '' or !isset($priority_order) or $priority_order==0)
		{
			if($action == 'update')
			{
				if($getLastPriority==1)
				return 1;
				elseif($priority_order>$getLastPriority or $priority_order == '' or !isset($priority_order) or $priority_order==0)
				return $this->category_details_arr['priority'];
				else
				return $priority_order;
			}
			else
			{
				return $getLastPriority = $getLastPriority+1;
			}
		}
		else
		{
			if($action == 'update')
			{
				if($priority_order>$getLastPriority)
				{
					return $this->category_details_arr['priority'];
				}
				else
				{
					return $priority_order;
				}
			}
			else
			{
				if($priority_order>=$getLastPriority)
				{
					return $getLastPriority = $getLastPriority+1;
				}
				else
				{
					return $priority_order;
				}
			}
		}
	}

	/**
	 * ManageBlogCategory::chkCategoryExists()
	 * To check if the category exists already
	 *
	 * @param string $category
	 * @param string $err_tip
	 * @return boolean
	 */
	public function chkCategoryExists($category, $err_tip='')
	{
		$sql = 'SELECT COUNT(blog_category_id) AS count FROM '.$this->CFG['db']['tbl']['blog_category'].' '.
				'WHERE UCASE(blog_category_name) = '.$this->dbObj->Param('category_name').' AND parent_category_id =0';
		$fields_value_arr[] = strtoupper($this->fields_arr[$category]);
		if ($this->fields_arr['category_id'])
			{
				$sql .= ' AND blog_category_id != '.$this->dbObj->Param('category_id');
				$fields_value_arr[] = $this->fields_arr['category_id'];
		    }
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($fields_value_arr));
		if (!$rs)
	        trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();
		if(!$row['count'])
			{
				return false;
			}
		$this->fields_err_tip_arr['category'] = $err_tip;
		$this->setCommonErrorMsg($err_tip);
		return false;
	}

	/**
	 * ManageBlogCategory::deleteSubCategoryImage()
	 * @param integer $blog_category_id
	 * @return null
	 */
	public function deleteCategoryImage($blog_category_id)
	{
	    //Get the extension for the image to be deleted
		$blog_category = $this->getCategoryDetail($blog_category_id);

		$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_category'].' SET '.
				' blog_category_ext =\'\''.
				' WHERE blog_category_id = '.$this->dbObj->Param('blog_category_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt,array($blog_category_id));
		if (!$rs)
		        trigger_db_error($this->dbObj);

		$affected = $this->dbObj->Affected_Rows();
		if($affected>0)
			{
				@unlink($this->media_relative_path.$this->CFG['admin']['blog']['category_folder'].$blog_category_id.'.'.$blog_category['blog_category_ext']);
			}
	}

	/**
	* ManageBlogCategory::getCategoryDetail()
	* @param integer $category_id, boolean $parent_id
	* @return string category name
	*/
	public function getCategoryDetail($blog_category_id='', $parent_id='')
	{
	    $cond = '';
	    if($parent_id)
			{
				$cond = ' AND parent_category_id =0';
			}

		$sql = 'SELECT blog_category_name,	blog_category_ext'.
				' FROM '.$this->CFG['db']['tbl']['blog_category'].
				' WHERE blog_category_id='.$this->dbObj->Param('blog_category_id').$cond;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($blog_category_id));
		if (!$rs)
		 trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
			{
				$this->setFormField('category_name', $row['blog_category_name']);
				return $row;
			}
		 return true;

	}

   /**
	* ManageBlogCategory::adjustPriorityOrder()
	*
	* @param integer $parent_category_id
	* @param integer $current_priority
	* @param string $table
	* @param string $field_name
	* @param string $action
	* @param array $category_ids
	* @return
	*/
	public function adjustPriorityOrder($parent_category_id, $current_priority = 0, $table, $field_name, $action, $category_ids = array())
	{
		$condition = ' AND parent_category_id = \''.$parent_category_id.'\'';
		$getLastPriority = $this->getLastPriority($table, $parent_category_id);
		switch($action)
			{
				case 'add':
				if($current_priority >= $getLastPriority)
					{
						return true;
					}
				elseif($current_priority<$getLastPriority)
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl'][$table].' SET '.
						'priority = priority+1 '.' WHERE priority >= \''.$current_priority.'\''.$condition;
						$stmt_update = $this->dbObj->Prepare($sql);
						$resultSet = $this->dbObj->Execute($stmt_update);
						if (!$resultSet)
						trigger_db_error($this->dbObj);
					}
				break;
				case 'update':
				if($current_priority >$getLastPriority)
					{
						return true;
					}
				else
				{
				if(!isset($this->fields_arr['sub_category_id']) or  $this->fields_arr['sub_category_id'] =='')
					{
						if($current_priority<$this->category_details_arr['priority'])
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl'][$table].' SET '.
										'priority = priority+1 WHERE priority >= \''.$current_priority.'\' AND priority < \''.$this->category_details_arr['priority'].'\' '.$condition;
								$stmt_update = $this->dbObj->Prepare($sql);
								$resultSet = $this->dbObj->Execute($stmt_update);
								if (!$resultSet)
									trigger_db_error($this->dbObj);
							}
						elseif($current_priority>$this->category_details_arr['priority'])
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl'][$table].' SET '.
										'priority = priority-1 WHERE priority <= \''.$current_priority.'\' AND priority >= \''.$this->category_details_arr['priority'].'\' '.$condition;

								$stmt_update = $this->dbObj->Prepare($sql);
								$resultSet = $this->dbObj->Execute($stmt_update);
								if (!$resultSet)
									trigger_db_error($this->dbObj);
							}
					}
				else
					{
						if($current_priority<$this->subcategory_details_arr['priority'])
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl'][$table].' SET '.
										'priority = priority+1 WHERE priority >= \''.$current_priority.'\' AND priority < \''.$this->subcategory_details_arr['priority'].'\' '.$condition;

								$stmt_update = $this->dbObj->Prepare($sql);
								$resultSet = $this->dbObj->Execute($stmt_update);
								if (!$resultSet)
									trigger_db_error($this->dbObj);
							}
						elseif($current_priority>$this->subcategory_details_arr['priority'])
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl'][$table].' SET '.
										'priority = priority-1 WHERE priority <= \''.$current_priority.'\' AND priority >= \''.$this->subcategory_details_arr['priority'].'\' '.$condition;
								$stmt_update = $this->dbObj->Prepare($sql);
								$resultSet = $this->dbObj->Execute($stmt_update);
								if (!$resultSet)
									trigger_db_error($this->dbObj);
							}
					}
				}
			break;
			case 'delete':
			for($inc=0;$inc<count($category_ids);$inc++)
				{
					$sql = 'SELECT priority '.
					'FROM '.$this->CFG['db']['tbl'][$table].' '.
					'WHERE '.$field_name.' = '.$this->dbObj->Param($category_ids[$inc]).$condition;
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($category_ids[$inc]));
					if (!$rs)
					trigger_db_error($this->dbObj);
					$row = $rs->FetchRow();
					$current_priority = $row['priority'];
					$sql_query = 'UPDATE '.$this->CFG['db']['tbl'][$table].' SET '.
					'priority = \'0\' WHERE '.$field_name.' = \''.$category_ids[$inc].'\''.$condition;
					$stmt_result = $this->dbObj->Prepare($sql_query);
					$rsSet = $this->dbObj->Execute($stmt_result);
					if (!$rsSet)
					trigger_db_error($this->dbObj);
					$sql = 'SELECT '.$field_name.' '.
					'FROM '.$this->CFG['db']['tbl'][$table].' '.
					'WHERE priority > '.$this->dbObj->Param($current_priority).$condition;
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($current_priority));
					if (!$rs)
				    trigger_db_error($this->dbObj);
					while($resultSet = $rs->FetchRow())
						{
							$value = $resultSet[$field_name];
							$sql = 'UPDATE '.$this->CFG['db']['tbl'][$table].' SET '.
							'priority ='.$current_priority.' WHERE '.$field_name.' = '.$this->dbObj->Param($value).$condition;
							$stmt = $this->dbObj->Prepare($sql);
							$rsSet = $this->dbObj->Execute($stmt, array($value));
							if (!$rsSet)
							trigger_db_error($this->dbObj);
							$current_priority++;
						}
				}
			break;
			}
		return true;
	}

   /**
	* ManageBlogCategory::createCategory()
	* To create/update blog category
	*
	* @param string $category_table
	* @return boolean
	*/
	public function createCategory($category_table)
	{
		$old_priority = $this->fields_arr['priority'];
		if ($this->fields_arr['category_id'])
		{
			$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'blog_category', 'update', 0);
			$this->adjustPriorityOrder(0, $priority, 'blog_category', 'blog_category_id', 'update', $this->fields_arr['category_id']);
			$sql = 'UPDATE '.$category_table.' SET '.
			'blog_category_name = '.$this->dbObj->Param($this->fields_arr['category']).', '.
			'blog_category_description = '.$this->dbObj->Param($this->fields_arr['category_description']).', '.
			'blog_category_status = '.$this->dbObj->Param($this->fields_arr['status']).', '.
			'blog_category_type = '.$this->dbObj->Param($this->fields_arr['blog_category_type']).', '.
			'allow_post= '.$this->dbObj->Param($this->fields_arr['allow_post']).', '.
			'priority= '.$this->dbObj->Param($priority).' '.
			'WHERE blog_category_id = '.$this->dbObj->Param($this->fields_arr['category_id']);
			$fields_value_arr = array($this->fields_arr['category'],
			$this->fields_arr['category_description'],
			$this->fields_arr['status'],
			$this->fields_arr['blog_category_type'],
			$this->fields_arr['allow_post'],
			$priority,
			$this->fields_arr['category_id']);
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
			if (!$rs)
			trigger_db_error($this->dbObj);
			$this->category_id = $this->fields_arr['category_id'];
			return true;
		}
		else
		{
			$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'blog_category', 'add', 0);
			$this->adjustPriorityOrder(0, $priority, 'blog_category', 'blog_category_id', 'add');
			$sql = 'INSERT INTO '.$category_table.' SET '.
			'blog_category_name = '.$this->dbObj->Param($this->fields_arr['category']).', '.
			'blog_category_description = '.$this->dbObj->Param($this->fields_arr['category_description']).', '.
			'blog_category_status = '.$this->dbObj->Param($this->fields_arr['status']).', '.
			'blog_category_type = '.$this->dbObj->Param($this->fields_arr['blog_category_type']).', '.
			'priority = '.$this->dbObj->Param($priority).', '.
			'date_added = now()';
			$fields_value_arr = array($this->fields_arr['category'],
			$this->fields_arr['category_description'],
			$this->fields_arr['status'],
			$this->fields_arr['blog_category_type'],
			$priority);
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
			if (!$rs)
			trigger_db_error($this->dbObj);
			$this->category_id = $this->dbObj->Insert_ID();
			return true;
		}
	}

   /**
	* ManageBlogCategory::setIHObject()
	*
	* @param mixed $imObj
	* @return void
	*/
	public function setIHObject($imObj)
	{
		$this->imageObj = $imObj;
	}

   /**
	* ManageBlogCategory::storeImagesTempServer()
	*
	* @param string $uploadUrl
	* @param string $extern
	* @return void
	*/
	public function storeImagesTempServer($uploadUrl, $extern)
	{
		@chmod($uploadUrl.'.'.$extern, 0777);
		if($this->CFG['admin']['blog']['category_height'] or $this->CFG['admin']['blog']['category_width'])
		{
			$this->imageObj->resize($this->CFG['admin']['blog']['category_width'], $this->CFG['admin']['blog']['category_height'], '-');
			$this->imageObj->output_resized($uploadUrl.'.'.$extern, strtoupper($extern));
		}
		else
		{
			$this->imageObj->output_original($uploadUrl.'.'.$extern, strtoupper($extern));
		}
	}

   /**
	* ManageBlogCategory::updateCategoryImageExt()
	* To Update category image ext
	*
	* @param string $category_ext
	* @access public
	* @return void
	**/
	public function updateCategoryImageExt($categoryId,$category_ext)
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_category'].' SET '.
		'blog_category_ext = '.$this->dbObj->Param($category_ext).' '.
		'WHERE blog_category_id = '.$this->dbObj->Param('blog_category_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($category_ext, $categoryId));
		if (!$rs)
		trigger_db_error($this->dbObj);
		return true;
	}

   /**
	* ManageBlogCategory::updateCategoryImageExt()
	*/
	public function setMediaPath($path='../../')
	{
		$this->media_relative_path = $path;
	}

   /**
	* ManageBlogCategory::showCategories()
	* To display the categories
	*
	* @return void
	*/
	public function showCategories()
	{
		global $smartyObj;
		$showCategories_arr = array();
		$inc = 0;
		while($row = $this->fetchResultRecord())
		{
			$row['blog_category_name'] =  wordWrap_mb_ManualWithSpace($row['blog_category_name'], $this->CFG['admin']['blog']['member_blog_category_name_length'], $this->CFG['admin']['blog']['member_blog_category_name_total_length'], 0);
			$row['blog_category_description'] = wordWrap_mb_ManualWithSpace($row['blog_category_description'], $this->CFG['admin']['blog']['member_blog_category_description_length'], $this->CFG['admin']['blog']['member_blog_category_description_total_length'], 0);
			$showCategories_arr[$inc]['record'] = $row;
			$showCategories_arr[$inc]['checked'] = '';
			if((is_array($this->fields_arr['category_ids'])) && (in_array($row['blog_category_id'], $this->fields_arr['category_ids'])))
			$showCategories_arr[$inc]['checked'] = "CHECKED";
			$inc++;
		}
		$smartyObj->assign('showCategories_arr', $showCategories_arr);
	}

   /**
	* ManageBlogCategory::getBlogPostCount()
	* To get post count of the category
	*
	* @param Integer $category_id
	* @return Integer
	*/
	public function getBlogPostCount($category_id)
	{
		$sql = 'SELECT count(bp.blog_post_id) as cat_count '.'FROM '.$this->CFG['db']['tbl']['blog_posts'].' as bp '.
		'WHERE blog_category_id = '.$this->dbObj->Param($category_id);
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($category_id));
		if (!$rs)
		trigger_db_error($this->dbObj);
		$row = $rs->FetchRow();
		return $row['cat_count'];
	}

   /**
	* ManageBlogCategory::chkIsDuplicateSubCategory()
	*
	* @param string $err_tip
	* @return boolean
	*/
	public function chkIsDuplicateSubCategory($err_tip = '')
	{
		$sql = 'SELECT blog_category_id FROM '.$this->CFG['db']['tbl']['blog_category'].' WHERE blog_category_name='.$this->dbObj->Param('blog_category_name').
				' AND parent_category_id='.$this->dbObj->Param('parent_category_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category'], $this->fields_arr['category_id']));
		if (!$rs)
		trigger_db_error($this->dbObj);
		if($rs->PO_RecordCount())
		{
			$this->fields_err_tip_arr['sub_category'] = $err_tip;
			return false;
		}
		return true;
	}

   /**
	* ManageBlogCategory::chkIsDuplicateSubCategoryForEdit()
	*
	* @param string $err_tip
	* @return boolean
	*/
	public function chkIsDuplicateSubCategoryForEdit($err_tip = '')
	{
		$sql = 'SELECT blog_category_id FROM '.$this->CFG['db']['tbl']['blog_category'].
		' WHERE blog_category_name='.$this->dbObj->Param('blog_category_name').
		' AND parent_category_id='.$this->dbObj->Param('parent_category_id').
		' AND blog_category_id!='.$this->dbObj->Param('blog_category_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category'], $this->fields_arr['category_id'], $this->fields_arr['sub_category_id']));
		if (!$rs)
		trigger_db_error($this->dbObj);
		if($rs->PO_RecordCount())
		{
			$this->fields_err_tip_arr['sub_category'] = $err_tip;
			return false;
		}
		return true;
	}

   /**
	* ManageBlogCategory::updateSubCategory()
	*
	* @return void
	*/
	public function updateSubCategory()
	{
		$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'blog_category', 'update', $this->fields_arr['category_id']);
		$this->adjustPriorityOrder($this->fields_arr['category_id'], $priority, 'blog_category', 'blog_category_id', 'update', $this->fields_arr['category_id']);
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_category'].' SET'.
		' blog_category_name='.$this->dbObj->Param('blog_category_name').', '.
		' priority='.$this->dbObj->Param('priority').' WHERE'.
		' blog_category_id='.$this->dbObj->Param('blog_category_id').' AND'.
		' parent_category_id='.$this->dbObj->Param('parent_category_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category'], $priority, $this->fields_arr['sub_category_id'], $this->fields_arr['category_id']));
		if (!$rs)
    	trigger_db_error($this->dbObj);
	}

   /**
	* ManageBlogCategory::populateSubCategory()
	*
	* @return boolean
	*/
	public function populateSubCategory()
	{
		$sql = 'SELECT blog_category_name, priority, blog_category_id,blog_category_ext  FROM '.$this->CFG['db']['tbl']['blog_category'].
		' WHERE blog_category_id='.$this->dbObj->Param('blog_category_id').
		' AND parent_category_id='.$this->dbObj->Param('parent_category_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category_id'], $this->fields_arr['category_id']));
		if (!$rs)
		trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
		{
			$this->fields_arr['sub_category'] = $row['blog_category_name'];
			$this->fields_arr['priority'] = $row['priority'];
			$this->fields_arr['sub_category_id'] = $row['blog_category_id'];
			$this->fields_arr['blog_category_ext'] = $row['blog_category_ext'];
			return true;
		}
		return $row['blog_category_ext'];
	}

   /**
	* ManageBlogCategory::deleteSeletctedSubCategories()
	*
	* @return void
	*/
	public function deleteSeletctedSubCategories()
	{
		$category_id = $this->fields_arr['category_id'];
		$category_ids = $this->fields_arr['category_ids'];
		$this->adjustPriorityOrder($category_id, '', 'blog_category', 'blog_category_id', 'delete', explode(',', $category_ids));
		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['blog_category'].
		' WHERE blog_category_id  IN('.$this->fields_arr['category_ids'].')';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_db_error($this->dbObj);
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET blog_sub_category_id=0'.
		' WHERE blog_sub_category_id IN('.$this->fields_arr['category_ids'].')';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_db_error($this->dbObj);
	}

   /**
	* ManageBlogCategory::chkPostExists()
	* To check if selected category have posts
	*
	* @param mixed $category_ids
	* @return boolean
	*/
	public function chkPostExists($category_ids)
	{
		$sql = 'SELECT count( bp.blog_post_id ) AS cat_count, blog_category_id'.' FROM '.$this->CFG['db']['tbl']['blog_posts'].' bp'.
		' WHERE blog_category_id IN ( '.$category_ids.' )'.' AND status!=\'Deleted\''.' GROUP BY blog_category_id';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
	    trigger_db_error($this->dbObj);
		if ($rs->PO_RecordCount())
		return true;
		return false;
	}

   /**
	* ManageBlogCategory::deleteSelectedCategories()
	* To delete the given category id
	*
	* @return boolean
	*/
	public function deleteSelectedCategories()
	{
		$category_ids = $this->fields_arr['category_ids'];
		if ($this->chkPostExists($category_ids))
		return false;
		$this->adjustPriorityOrder(0, '', 'blog_category', 'blog_category_id', 'delete', explode(',', $category_ids));
		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['blog_category'].' '.
		'WHERE blog_category_id IN ('.$category_ids.') ';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_db_error($this->dbObj);
		return true;
	}

   /**
	* ManageBlogCategory::changeStatus()
	*
	* @param string $status
	* @return boolean
	*/
	public function changeStatus($status)
	{
		$category_ids = $this->fields_arr['category_ids'];
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_category'].' SET'.' blog_category_status='.$this->dbObj->Param('blog_category_status').
				' WHERE blog_category_id IN('.$category_ids.')';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($status));
		if (!$rs)
		trigger_db_error($this->dbObj);
		return true;
	}

   /**
	* ManageBlogCategory::addSubCategory()
	*
	* @return void
	*/
	public function addSubCategory()
	{
		$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'blog_category', 'add', $this->fields_arr['category_id']);
		$this->adjustPriorityOrder($this->fields_arr['category_id'], $priority, 'blog_category', 'blog_category_id', 'add');
		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_category'].' SET'.
		' blog_category_name='.$this->dbObj->Param('blog_category_name').','.
		' parent_category_id='.$this->dbObj->Param('parent_category_id').','.
		' priority='.$this->dbObj->Param('priority').','.
		' blog_category_status=\'Yes\','.
		' date_added=NOW()';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category'], $this->fields_arr['category_id'], $priority));
		if (!$rs)
	    trigger_db_error($this->dbObj);
		$this->subcategory_id = $this->dbObj->Insert_ID();
	}

   /**
	* ManageBlogCategory::populateSubCategories()
	*
	* @return void
	*/
	public function populateSubCategories()
	{
		global $smartyObj;
		$populateSubCategories_arr = array();
		$sql = 'SELECT blog_category_id, blog_category_name,blog_category_ext,'.' DATE_FORMAT(date_added, \'%D %b %y\') AS date_added'.
		' FROM '.$this->CFG['db']['tbl']['blog_category'].' WHERE parent_category_id='.$this->dbObj->Param('parent_category_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['category_id']));
		if (!$rs)
		trigger_db_error($this->dbObj);
		$populateSubCategories_arr['rs_PO_RecordCount'] = $rs->PO_RecordCount();
		if($rs->PO_RecordCount())
		{
			$populateSubCategories_arr['row'] = array();
			$inc = 0;
			while($row = $rs->FetchRow())
			{
				$row['blog_category_name'] = wordWrap_mb_ManualWithSpace($row['blog_category_name'], $this->CFG['admin']['blog']['admin_blog_category_name_length']);

				$populateSubCategories_arr['row'][$inc]['record'] = $row;
				$populateSubCategories_arr['row'][$inc]['checked'] = '';
				if((is_array($this->fields_arr['category_ids'])) && (in_array($row['blog_category_id'], $this->fields_arr['category_ids'])))
				$populateSubCategories_arr['row'][$inc]['checked'] = "CHECKED";
				$inc++;
			}
		}
		$smartyObj->assign('populateSubCategories_arr', $populateSubCategories_arr);
	}

   /**
	* ManageBlogCategory::isValidCategoryId()
	* To check the blog_categroy id is valid or not
	*
	* @param Integer $category_id
	* @param string $err_tip
	* @return boolean
	*/
	public function isValidSubCategoryId($category_id, $err_tip='')
	{
		$sql = 'SELECT blog_category_id, blog_category_description,'.' blog_category_name, blog_category_status, date_added, blog_category_type, allow_post, blog_category_ext, priority'.
		' FROM '.$this->CFG['db']['tbl']['blog_category'].' WHERE blog_category_id = '.$this->dbObj->Param($this->fields_arr[$category_id]);
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$category_id]));
		if (!$rs)
	     trigger_db_error($this->dbObj);
		if ($this->subcategory_details_arr = $rs->FetchRow())
			{
				return true;
			}
		$this->setCommonErrorMsg($err_tip);
		return false;
	}
}
//<<<<<-------------- Class obj begins ---------------//
$manageBlogCategory = new ManageBlogCategory();
$manageBlogCategory->setPageBlockNames(array('form_create_category', 'form_show_category', 'form_create_sub_category', 'form_show_sub_category', 'form_confirm'));
$manageBlogCategory->setMediaPath('../../');
$manageBlogCategory->setAllPageBlocksHide();
//default form fields and values...
$manageBlogCategory->resetFieldsArray();
$manageBlogCategory->setFormField('prev_numpg',0);//To retain the last numpg
/***********set form field for navigation****/
$manageBlogCategory->setFormField('asc', 'bc.blog_category_name');
$manageBlogCategory->setFormField('dsc', '');
$manageBlogCategory->setFormField('msg', '');
$manageBlogCategory->imageFormat=implode(', ',$CFG['admin']['blog']['category_image_format_arr']);

/*************Start navigation******/
$condition = '';
$manageBlogCategory->setTableNames(array($CFG['db']['tbl']['blog_category'].' as bc'));
$manageBlogCategory->setReturnColumns(array('bc.blog_category_id, bc.parent_category_id, bc.blog_category_name, bc.blog_category_type,'.
					' bc.blog_category_description, bc.blog_category_ext, bc.blog_category_status, bc.allow_post, bc.priority, DATE_FORMAT(bc.date_added, \''.$CFG['format']['date'].'\') as date_added'));
$manageBlogCategory->sanitizeFormInputs($_REQUEST);

if ($manageBlogCategory->isFormGETed($_GET, 'category_id'))
{
	$manageBlogCategory->chkIsNotEmpty('category_id', $LANG['common_err_tip_required'])and
	$manageBlogCategory->chkIsNumeric('category_id', $LANG['manageblogcategory_err_tip_invalid_category_id'])and
	$manageBlogCategory->isValidCategoryId('category_id', $LANG['manageblogcategory_err_tip_invalid_category_id']);
	$manageBlogCategory->getFormField('start')and
	$manageBlogCategory->chkIsNumeric('start', $LANG['common_err_tip_required']);
	if ($manageBlogCategory->isFormGETed($_GET, 'sub_category_id'))
	{
		$manageBlogCategory->chkIsNotEmpty('sub_category_id', $LANG['common_err_tip_required'])and
		$manageBlogCategory->chkIsNumeric('sub_category_id', $LANG['manageblogcategory_err_tip_invalid_category_id'])and
		$manageBlogCategory->isValidSubCategoryId('sub_category_id', $LANG['common_err_tip_required']);
	}
	if ($manageBlogCategory->isValidFormInputs())
	{
		if($manageBlogCategory->getFormField('opt')=='sub')
		{
			$manageBlogCategory->setAllPageBlocksHide();
			$manageBlogCategory->setPageBlockShow('form_create_sub_category');
		}
		else
		{
			$manageBlogCategory->getFormField('sub_category_id', '');
			$manageBlogCategory->setAllPageBlocksHide();
			$manageBlogCategory->setFormField('category_id', $manageBlogCategory->category_details_arr['blog_category_id']);
			$image_extern=$manageBlogCategory->category_details_arr['blog_category_ext'];
			$manageBlogCategory->category_image_ext_blog = $manageBlogCategory->category_details_arr['blog_category_ext'];
			$manageBlogCategory->category_tmp_blog_image = $manageBlogCategory->media_relative_path.$CFG['admin']['blog']['category_folder'].$CFG['admin']['blog']['blog_no_image'];
			$manageBlogCategory->category_image = $manageBlogCategory->media_relative_path.$CFG['admin']['blog']['category_folder'].$manageBlogCategory->category_details_arr['blog_category_id'].'.'.$manageBlogCategory->category_details_arr['blog_category_ext'];
			$manageBlogCategory->setFormField('category', stripslashes($manageBlogCategory->category_details_arr['blog_category_name']));
			$manageBlogCategory->setFormField('category_description', stripslashes($manageBlogCategory->category_details_arr['blog_category_description']));
			$manageBlogCategory->setFormField('status', $manageBlogCategory->category_details_arr['blog_category_status']);
			$manageBlogCategory->setFormField('allow_post', $manageBlogCategory->category_details_arr['allow_post']);
			$manageBlogCategory->setFormField('blog_category_type', $manageBlogCategory->category_details_arr['blog_category_type']);
			$manageBlogCategory->setFormField('priority', $manageBlogCategory->category_details_arr['priority']);
			$manageBlogCategory->setFormField('blog_category_ext', $manageBlogCategory->category_details_arr['blog_category_ext']);
		}
		if($manageBlogCategory->getFormField('opt')=='subedit')
		{
			$manageBlogCategory->category_image = $manageBlogCategory->media_relative_path.$CFG['admin']['blog']['category_folder'].$manageBlogCategory->getFormField('sub_category_id').'.'.$manageBlogCategory->category_details_arr['blog_category_ext'];
		}
	}
	else
	{
		$manageBlogCategory->setAllPageBlocksHide();
		$manageBlogCategory->setFormField('start', 0);
		$manageBlogCategory->setPageBlockShow('block_msg_form_error');
		$manageBlogCategory->setCommonErrorMsg($LANG['common_msg_error_sorry']);
	}
}

if ($manageBlogCategory->isFormPOSTed($_POST, 'confirm_action'))
{
	$manageBlogCategory->error = 0;
	if(!$manageBlogCategory->chkIsNotEmpty('category_ids', $LANG['common_err_tip_required']))
	{
		$manageBlogCategory->setCommonErrorMsg($LANG['manageblogcategory_err_tip_select_category']);
	}
	if($manageBlogCategory->isValidFormInputs())
		{
			switch($manageBlogCategory->getFormField('action'))
					{
						case 'Delete':
							 if(!$manageBlogCategory->deleteSelectedCategories())
							 {
								$manageBlogCategory->setCommonErrorMsg($LANG['manageblogcategory_err_tip_have_post']);
								$manageBlogCategory->error = 1;
							 }
							 break;
						case 'Enable':
							$LANG['manageblogcategory_success_message'] = $LANG['manageblogcategory_success_enable_msg'];
							$manageBlogCategory->changeStatus('Yes');
							break;
						case 'Disable':
							$LANG['manageblogcategory_success_message'] = $LANG['manageblogcategory_success_disable_msg'];
							$manageBlogCategory->changeStatus('No');
							break;
					}
		}

	if($manageBlogCategory->getFormField('action')=='delete_category_image')
		{
			$manageBlogCategory->getFormField('category_id');
			$manageBlogCategory->deleteCategoryImage($manageBlogCategory->getFormField('category_id'));
			$manageBlogCategory->setCommonSuccessMsg($LANG['manageblogcategory_image_success_delete_message']);
			$manageBlogCategory->setPageBlockShow('block_msg_form_success');
			$manageBlogCategory->setPageBlockShow('form_create_category');
			$url = getCurrentUrl(true).'&msg=success';
			Redirect2URL($url);
		}

	$manageBlogCategory->setAllPageBlocksHide();
	if ($manageBlogCategory->isValidFormInputs())
		{
			$manageBlogCategory->setCommonSuccessMsg($LANG['manageblogcategory_success_message']);
			$manageBlogCategory->setPageBlockShow('block_msg_form_success');
			$manageBlogCategory->resetFieldsArray();
		}
	else
		{
			if(!$manageBlogCategory->error)
			$manageBlogCategory->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			$manageBlogCategory->setPageBlockShow('block_msg_form_error');
		}
}

if ($manageBlogCategory->isFormPOSTed($_POST, 'sub_category_submit'))
{
	if(!$manageBlogCategory->getFormField('sub_category_id'))
	{
		$manageBlogCategory->chkValidFileType('sub_category_image',$LANG['common_err_tip_invalid_file_type']) and
		$manageBlogCategory->chkValideFileSize('sub_category_image',$LANG['common_err_tip_invalid_file_size']) and
		$manageBlogCategory->chkErrorInFile('sub_category_image',$LANG['common_err_tip_invalid_file']);
	}
	$manageBlogCategory->chkIsNotEmpty('sub_category', $LANG['common_err_tip_required']);
	$manageBlogCategory->chkIsNotEmpty('category_id', $LANG['common_err_tip_required']);
	$manageBlogCategory->isValidFormInputs() and $manageBlogCategory->chkIsDuplicateSubCategory($LANG['manageblogsubcategory_err_tip_alreay_exists']);
	if($manageBlogCategory->getFormField('priority'))
	$manageBlogCategory->chkIsNumeric('priority', $LANG['manageblogcategory_err_tip_invalid_priority']);
	if($manageBlogCategory->isValidFormInputs())
	{
		if ($manageBlogCategory->isValidFormInputs())
		{
			$manageBlogCategory->addSubCategory();
			if ($manageBlogCategory->isValidFormInputs() && isset($_FILES['sub_category_image']['name']) && trim($_FILES['sub_category_image']['name']!=''))
			{
				$extern = strtolower(substr($_FILES['sub_category_image']['name'], strrpos($_FILES['sub_category_image']['name'], '.')+1));
				if (in_array($extern, $CFG['admin']['blog']['category_image_format_arr']))
				{
					if ($_FILES['sub_category_image']['size'] <= $CFG['admin']['blog']['category_image_max_size'] * 1024)
					{
						if (!$_FILES['sub_category_image']['error'])
						{
							$imageObj = new ImageHandler($_FILES['sub_category_image']['tmp_name']);
							$manageBlogCategory->setIHObject($imageObj);
							$image_name = $manageBlogCategory->subcategory_id;
							$temp_dir = $manageBlogCategory->media_relative_path.$CFG['admin']['blog']['category_folder'];
							$manageBlogCategory->chkAndCreateFolder($temp_dir);
							$temp_file = $temp_dir.$image_name;
							$manageBlogCategory->storeImagesTempServer($temp_file, $extern);
							$externs=$manageBlogCategory->setFormField('category_image_ext', $extern);
							$manageBlogCategory->updateCategoryImageExt($manageBlogCategory->subcategory_id,$extern);
						}
					}
				}
			}
			$manageBlogCategory->setFormField('sub_category', '');
			$manageBlogCategory->setFormField('priority', '');
			$manageBlogCategory->setFormField('blog_category_ext', $manageBlogCategory->category_details_arr['blog_category_ext']);
			$LANG['manageblogcategory_success_message'] = $LANG['manageblogcategory_success_add_message'];
			$manageBlogCategory->setCommonSuccessMsg($LANG['manageblogcategory_success_message']);
			$manageBlogCategory->setPageBlockShow('block_msg_form_success');
			$manageBlogCategory->setPageBlockShow('form_create_sub_category');
		}
	}
	else
	{
		$manageBlogCategory->setCommonErrorMsg($LANG['common_msg_error_sorry']);
		$manageBlogCategory->setPageBlockShow('block_msg_form_error');
		$manageBlogCategory->setPageBlockShow('form_create_sub_category');
	}
}
else if($manageBlogCategory->chkIsEditModeSub())
{
	if($manageBlogCategory->isFormPOSTed($_POST, 'update_category_submit'))
	{
		$manageBlogCategory->sanitizeFormInputs($_REQUEST);
		$manageBlogCategory->chkIsNotEmpty('sub_category', $LANG['common_err_tip_required']);
		$manageBlogCategory->chkIsNotEmpty('category_id', $LANG['common_err_tip_required']);
		$manageBlogCategory->chkValidFileType('sub_category_image',$LANG['common_err_tip_invalid_file_type']) and
		$manageBlogCategory->chkValideFileSize('sub_category_image',$LANG['common_err_tip_invalid_file_size']) and
		$manageBlogCategory->chkErrorInFile('sub_category_image',$LANG['common_err_tip_invalid_file']);
		$manageBlogCategory->isValidFormInputs() and $manageBlogCategory->chkIsDuplicateSubCategoryForEdit($LANG['manageblogsubcategory_err_tip_alreay_exists']);
		if($manageBlogCategory->getFormField('priority'))
		$manageBlogCategory->chkIsNumeric('priority', $LANG['manageblogcategory_err_tip_invalid_priority']);
		$manageBlogCategory->isValidCategoryId('category_id', $LANG['manageblogcategory_err_tip_invalid_category_id']);
		$manageBlogCategory->isValidCategoryId('sub_category_id', $LANG['manageblogcategory_err_tip_invalid_category_id']);
		if($manageBlogCategory->isValidFormInputs())
		{
			$manageBlogCategory->updateSubCategory();
			if ($manageBlogCategory->isValidFormInputs() && isset($_FILES['sub_category_image']['name']) && trim($_FILES['sub_category_image']['name']!=''))
			{
				$extern = strtolower(substr($_FILES['sub_category_image']['name'], strrpos($_FILES['sub_category_image']['name'], '.')+1));
				if (in_array($extern, $CFG['admin']['blog']['category_image_format_arr']))
				{
					if ($_FILES['sub_category_image']['size'] <= $CFG['admin']['blog']['category_image_max_size'] * 1024)
					{
						if (!$_FILES['sub_category_image']['error'])
						{
							$imageObj = new ImageHandler($_FILES['sub_category_image']['tmp_name']);
							$manageBlogCategory->setIHObject($imageObj);
							$image_name = $manageBlogCategory->getFormField('sub_category_id');
							$temp_dir = $manageBlogCategory->media_relative_path.$CFG['admin']['blog']['category_folder'];
							$manageBlogCategory->chkAndCreateFolder($temp_dir);
							$temp_file = $temp_dir.$image_name;
							$manageBlogCategory->storeImagesTempServer($temp_file, $extern);
							$manageBlogCategory->setFormField('category_image_ext', $extern);
							$manageBlogCategory->updateCategoryImageExt($manageBlogCategory->getFormField('sub_category_id'),$extern);
						}
					}
				}
			}
			$manageBlogCategory->setFormField('sub_category', '');
			$manageBlogCategory->setFormField('priority', '');
			$manageBlogCategory->setFormField('opt', 'sub');
			$LANG['manageblogcategory_success_message'] = $LANG['manageblogcategory_success_edit_message'];
			$manageBlogCategory->setCommonSuccessMsg($LANG['manageblogcategory_success_message']);
			$manageBlogCategory->setPageBlockShow('block_msg_form_success');
			$manageBlogCategory->setPageBlockShow('form_create_sub_category');
		}
		else
		{
			$manageBlogCategory->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			$manageBlogCategory->setPageBlockShow('block_msg_form_error');
			$manageBlogCategory->setPageBlockShow('form_create_sub_category');
		}
	}
	else if($manageBlogCategory->populateSubCategory())
	{
		$manageBlogCategory->setPageBlockShow('form_create_sub_category');
		$manageBlogCategory->sub_category_image = $manageBlogCategory->media_relative_path.$CFG['admin']['blog']['category_folder'].$manageBlogCategory->getFormField('sub_category_id').'.'.$manageBlogCategory->getFormField('blog_category_ext');
		//Condition to delete the subcategory image
		if($manageBlogCategory->getFormField('action')=='delete_subcategory_image')
			{
				$manageBlogCategory->deleteCategoryImage($manageBlogCategory->getFormField('sub_category_id'));
				$manageBlogCategory->setCommonSuccessMsg($LANG['manageblogcategory_image_success_delete_message']);
				$manageBlogCategory->setPageBlockShow('block_msg_form_success');
				$manageBlogCategory->setPageBlockShow('form_create_sub_category');
				$url = getCurrentUrl(true).'&msg=success';
				Redirect2URL($url);
			}
		if($manageBlogCategory->getFormField('msg')=='success')
			{
				$manageBlogCategory->setCommonSuccessMsg($LANG['manageblogcategory_image_delete_success_message']);
				$manageBlogCategory->setPageBlockShow('block_msg_form_success');
			}
	}
}
else if($manageBlogCategory->isFormPOSTed($_POST, 'confirm_actionSub'))
{
	$manageBlogCategory->deleteSeletctedSubCategories();
	$manageBlogCategory->setCommonSuccessMsg($LANG['manageblogcategory_success_message']);
	$manageBlogCategory->setPageBlockShow('block_msg_form_success');
	$manageBlogCategory->setPageBlockShow('form_create_sub_category');
}
else if ($manageBlogCategory->isFormPOSTed($_POST, 'category_submit'))
{
	if(!$manageBlogCategory->getFormField('category_id') || isset($_FILES['category_image']['name']) && trim($_FILES['category_image']['name']!=''))
	{
		$manageBlogCategory->chkValidFileType('category_image',$LANG['common_err_tip_invalid_file_type']) and
		$manageBlogCategory->chkValideFileSize('category_image',$LANG['common_err_tip_invalid_file_size']) and
		$manageBlogCategory->chkErrorInFile('category_image',$LANG['common_err_tip_invalid_file']);
	}
	$manageBlogCategory->chkIsNotEmpty('category', $LANG['common_err_tip_required'])and
		$manageBlogCategory->chkCategoryExists('category', $LANG['manageblogcategory_err_tip_alreay_exists']);
	$manageBlogCategory->chkIsNotEmpty('status', $LANG['common_err_tip_required']);
	$manageBlogCategory->chkIsNotEmpty('category_description', $LANG['common_err_tip_required']);
	$manageBlogCategory->getFormField('category_id')and
	$manageBlogCategory->chkIsNotEmpty('category_id', $LANG['common_err_tip_required'])and
	$manageBlogCategory->chkIsNumeric('category_id', $LANG['manageblogcategory_err_tip_invalid_category_id'])and
	$manageBlogCategory->isValidCategoryId('category_id', $LANG['manageblogcategory_err_tip_invalid_category_id']);
	if($manageBlogCategory->getFormField('priority'))
	$manageBlogCategory->chkIsNumeric('priority', $LANG['manageblogcategory_err_tip_invalid_priority']);
	$manageBlogCategory->isValidFormInputs()and
	$manageBlogCategory->createCategory($CFG['db']['tbl']['blog_category']);
	if ($manageBlogCategory->isValidFormInputs() && isset($_FILES['category_image']['name']) && trim($_FILES['category_image']['name']!=''))
	{
		$extern = strtolower(substr($_FILES['category_image']['name'], strrpos($_FILES['category_image']['name'], '.')+1));
		if (in_array($extern, $CFG['admin']['blog']['category_image_format_arr']))
		{
			if ($_FILES['category_image']['size'] <= $CFG['admin']['blog']['category_image_max_size'] * 1024)
			{
				if (!$_FILES['category_image']['error'])
				{
					$imageObj = new ImageHandler($_FILES['category_image']['tmp_name']);
					$manageBlogCategory->setIHObject($imageObj);
					$image_name = $manageBlogCategory->category_id;
					$temp_dir = $manageBlogCategory->media_relative_path.$CFG['admin']['blog']['category_folder'];
					$manageBlogCategory->chkAndCreateFolder($temp_dir);
					$temp_file = $temp_dir.$image_name;
					$manageBlogCategory->storeImagesTempServer($temp_file, $extern);
					$manageBlogCategory->setFormField('category_image_ext', $extern);
					$manageBlogCategory->updateCategoryImageExt($manageBlogCategory->category_id,$extern);
				}
			}
		}
	}
	if ($manageBlogCategory->isValidFormInputs())
	{
		if($manageBlogCategory->getFormField('category_id'))
		$manageBlogCategory->setCommonSuccessMsg($LANG['manageblogcategory_success_edit_message']);
		else
		$manageBlogCategory->setCommonSuccessMsg($LANG['manageblogcategory_success_add_message']);
		$manageBlogCategory->setPageBlockShow('block_msg_form_success');
		$manageBlogCategory->resetFieldsArray();
	}
	else
	{
		$manageBlogCategory->setAllPageBlocksHide();
		$manageBlogCategory->setCommonErrorMsg($LANG['common_msg_error_sorry']);
		$manageBlogCategory->setPageBlockShow('block_msg_form_error');
		//$manageBlogCategory->setFormField('category_id', $manageBlogCategory->category_details_arr['blog_category_id']);
	}
}
else if($manageBlogCategory->isFormPOSTed($_POST, 'category_cancel'))
{
	$manageBlogCategory->resetFieldsArray();
}

if ($manageBlogCategory->isFormPOSTed($_POST, 'sub_category_cancel'))
{
	$url = $CFG['site']['url'].'admin/blog/manageBlogCategory.php?category_id='.$manageBlogCategory->getFormField('category_id').'&opt=sub';
	$manageBlogCategory->resetFieldsArray();
	Redirect2URL($url);
}

if($manageBlogCategory->getFormField('msg')=='success' && !$manageBlogCategory->getFormField('sub_category_id'))
{
	$manageBlogCategory->setCommonSuccessMsg($LANG['manageblogcategory_image_delete_success_message']);
	$manageBlogCategory->setPageBlockShow('block_msg_form_success');
}

$manageBlogCategory->left_navigation_div = 'blogMain';

if (!$manageBlogCategory->isShowPageBlock('form_create_sub_category'))
{
	$condition = 'parent_category_id=0';
	$manageBlogCategory->buildSelectQuery();
	$manageBlogCategory->buildConditionQuery($condition);
	$manageBlogCategory->buildSortQuery();
	$manageBlogCategory->checkSortQuery('bc.blog_category_name', 'asc');
	$manageBlogCategory->buildQuery();
	$manageBlogCategory->executeQuery();
	$manageBlogCategory->setPageBlockShow('form_create_category');
	$manageBlogCategory->setPageBlockShow('form_show_category');
}


/*  Set the smarty variables  */
$manageBlogCategory->hidden_arr1 = array('start', 'category_id');
$manageBlogCategory->hidden_arr2 = array('category_id', 'opt');
if ($manageBlogCategory->isShowPageBlock('form_create_category'))
{
	$manageBlogCategory->form_create_category['hidden_arr'] = array('category_id', 'start');
}
if ($manageBlogCategory->isShowPageBlock('form_show_category'))
{
	$manageBlogCategory->form_show_category['hidden_arr'] = array('start');
	if($manageBlogCategory->isResultsFound())
	{
		$manageBlogCategory->showCategories();
		$smartyObj->assign('smarty_paging_list', $manageBlogCategory->populatePageLinksPOST($manageBlogCategory->getFormField('start'), 'selFormCategory'));
	}
}
if ($manageBlogCategory->isShowPageBlock('form_create_sub_category'))
{
	$manageBlogCategory->setPageBlockShow('form_show_sub_category');
	$manageBlogCategory->form_create_sub_category['hidden_arr'] = array('category_id', 'opt');
}
if ($manageBlogCategory->isShowPageBlock('form_show_sub_category'))
{
	$manageBlogCategory->populateSubCategories();
}


//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$manageBlogCategory->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'blog');
$smartyObj->display('manageBlogCategory.tpl');
?>
<script language="javascript" type="text/javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmSub');
</script>
<?php
/* Added code to validate mandataory fields in photo defaut settings page */
if ($CFG['feature']['jquery_validation'])
{
//$allowed_image_formats=$this->CFG['admin']['blog']['category_image_format_arr'];
$allowed_image_formats=implode("|", $CFG['admin']['blog']['category_image_format_arr']);
?>
<script type="text/javascript">
$Jq("#selCreateCategoryfrm").validate({
	rules:
	{
		category: {
		required: true,
		checkSpecialChr: true
		},
		category_image: {
		isValidFileFormat: "<?php echo $allowed_image_formats; ?>"
		},
		category_description: {
		required: true
		},
		priority: {
		number: true
		}
	},
	messages:
	{
		category: {
		required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		category_image: {
		isValidFileFormat: "<?php echo $manageBlogCategory->LANG['common_err_tip_invalid_image_format']; ?>"
		},
		category_description: {
		required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		priority: {
		number: LANG_JS_NUMBER
		}
	}
});

$Jq("#selCreateSubCategoryfrm").validate({
	rules:
	{
		sub_category: {
		required: true,
		checkSpecialChr: true
		},
		sub_category_image: {
		isValidFileFormat: "<?php echo $allowed_image_formats; ?>"
		},
		priority: {
		number: true
		}
	},
	messages:
	{
		sub_category: {
		required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		sub_category_image: {
		isValidFileFormat: "<?php echo $manageBlogCategory->LANG['common_err_tip_invalid_image_format']; ?>"
		},
		priority: {
		number: LANG_JS_NUMBER
		}
	}
});

</script>
<?php
}
//<<<<<-------------------- Page block templates ends -------------------//
$manageBlogCategory->includeFooter();
?>