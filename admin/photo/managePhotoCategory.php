<?php
/**
* This file is to manage the Photo Category
*
* This file is having Photo Category
*
*
* @category	    Rayzz PhotoSharing
* @package		Admin
* @copyright 	Copyright (c) 2010 {@link http://www.mediabox.uz Uzdc Infoway}
* @license		http://www.mediabox.uz Uzdc Infoway Licence
**/

require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/admin/managePhotoCategory.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/help.inc.php';
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
$CFG['site']['is_module_page'] = 'photo';
require_once($CFG['site']['project_path'] . 'common/application_top.inc.php');

class ManagePhotoCategory extends MediaHandler
{
	public $category_details_arr = array();
	/**
	 * ManagePhotoCategory::resetFieldsArray()
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
		$this->setFormField('photo_category_ext', '');
		$this->setFormField('status', 'Yes');
		$this->setFormField('category_ids', array());
		$this->setFormField('allow_post', 'Yes');
		$this->setFormField('action', '');
		$this->setFormField('opt', '');
		$this->setFormField('photo_category_type', 'General');
		$this->setFormField('priority', '');
		$this->setFormField('photo_category_id', '');
	}


	/**
	 * ManagePhotoCategory::chkIsEditMode()
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
	* ManagePhotoCategory::chkIsEditModeSubCategory()
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
	* ManagePhotoCategory::buildConditionQuery()
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
	 * ManagePhotoCategory::checkSortQuery()
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
	* ManagePhotoCategory::isValidCategoryId()
	* To check the photo_categroy id is valid or not
	*
	* @param Integer $category_id
	* @param string $err_tip
	* @return boolean
	*/
	public function isValidCategoryId($category_id, $err_tip='')
	{
		$sql = 'SELECT photo_category_id, 	photo_category_description,'.
		' photo_category_name, photo_category_status, date_added, photo_category_type, allow_post, photo_category_ext, priority'.
		' FROM '.$this->CFG['db']['tbl']['photo_category'].
		' WHERE photo_category_id = '.$this->dbObj->Param($this->fields_arr[$category_id]);
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
	* ManagePhotoCategory::checkValidFileType()
	*
	* @param string $field_name
	* @param string $err_tip
	* @return boolean
	*/
	public function checkValidFileType($field_name, $err_tip = '')
	{
		$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));
		if($extern!='')
		{
			if (!in_array($extern, $this->CFG['admin']['photos']['category_image_format_arr']))
			{
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}
		}
		return true;
	}

   /**
	* ManagePhotoCategory::chkValideFileSize()
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
			$max_size = $this->CFG['admin']['photos']['category_image_max_size'] * 1024;
			if ($_FILES[$field_name]['size'] > $max_size)
			{
				$this->fields_err_tip_arr[$field_name] = $err_tip;
				return false;
			}
		}
		return true;
	}
	/**
	* ManagePhotoCategory::chkErrorInFile()
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
	* ManagePhotoCategory::getLastPriority()
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
	* ManagePhotoCategory::getPriorityOrder()
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
	 * ManagePhotoCategory::chkCategoryExists()
	 * To check if the category exists already
	 *
	 * @param string $category
	 * @param string $err_tip
	 * @return boolean
	 */
	public function chkCategoryExists($category, $err_tip='')
	{
		$sql = 'SELECT COUNT(photo_category_id) AS count FROM '.$this->CFG['db']['tbl']['photo_category'].' '.
				'WHERE UCASE(photo_category_name) = '.$this->dbObj->Param('category_name').' AND parent_category_id =0';
		$fields_value_arr[] = strtoupper($this->fields_arr[$category]);
		if ($this->fields_arr['category_id'])
			{
				$sql .= ' AND photo_category_id != '.$this->dbObj->Param('category_id');
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
	 * ManagePhotoCategory::deleteSubCategoryImage()
	 * @param integer $photo_category_id
	 * @return null
	 */
	public function deleteCategoryImage($photo_category_id)
	{
	    //Get the extension for the image to be deleted
		$photo_category = $this->getCategoryDetail($photo_category_id);

		$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_category'].' SET '.
				' photo_category_ext =\'\''.
				' WHERE photo_category_id = '.$this->dbObj->Param('photo_category_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt,array($photo_category_id));
		if (!$rs)
		        trigger_db_error($this->dbObj);

		$affected = $this->dbObj->Affected_Rows();
		if($affected>0)
			{
				@unlink($this->media_relative_path.$this->CFG['admin']['photos']['category_folder'].$photo_category_id.'.'.$photo_category['photo_category_ext']);
			}
	}

	/**
	* ManagePhotoCategory::getCategoryDetail()
	* @param integer $category_id, boolean $parent_id
	* @return string category name
	*/
	public function getCategoryDetail($photo_category_id='', $parent_id='')
	{
	    $cond = '';
	    if($parent_id)
			{
				$cond = ' AND parent_category_id =0';
			}

		$sql = 'SELECT photo_category_name,	photo_category_ext'.
				' FROM '.$this->CFG['db']['tbl']['photo_category'].
				' WHERE photo_category_id='.$this->dbObj->Param('photo_category_id').$cond;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photo_category_id));
		if (!$rs)
		trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
			{
				$this->setFormField('category_name', $row['photo_category_name']);
				return $row;
			}
		 return true;

	}

   /**
	* ManagePhotoCategory::adjustPriorityOrder()
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
	* ManagePhotoCategory::createCategory()
	* To create/update photo category
	*
	* @param string $category_table
	* @return boolean
	*/
	public function createCategory($category_table)
	{
		$old_priority = $this->fields_arr['priority'];
		if ($this->fields_arr['category_id'])
		{
			$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'photo_category', 'update', 0);
			$this->adjustPriorityOrder(0, $priority, 'photo_category', 'photo_category_id', 'update', $this->fields_arr['category_id']);
			$sql = 'UPDATE '.$category_table.' SET '.
			'photo_category_name = '.$this->dbObj->Param($this->fields_arr['category']).', '.
			'photo_category_description = '.$this->dbObj->Param($this->fields_arr['category_description']).', '.
			'photo_category_status = '.$this->dbObj->Param($this->fields_arr['status']).', '.
			'photo_category_type = '.$this->dbObj->Param($this->fields_arr['photo_category_type']).', '.
			'allow_post= '.$this->dbObj->Param($this->fields_arr['allow_post']).', '.
			'priority= '.$this->dbObj->Param($priority).' '.
			'WHERE photo_category_id = '.$this->dbObj->Param($this->fields_arr['category_id']);
			$fields_value_arr = array($this->fields_arr['category'],
			$this->fields_arr['category_description'],
			$this->fields_arr['status'],
			$this->fields_arr['photo_category_type'],
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
			$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'photo_category', 'add', 0);
			$this->adjustPriorityOrder(0, $priority, 'photo_category', 'photo_category_id', 'add');
			$sql = 'INSERT INTO '.$category_table.' SET '.
			'photo_category_name = '.$this->dbObj->Param($this->fields_arr['category']).', '.
			'photo_category_description = '.$this->dbObj->Param($this->fields_arr['category_description']).', '.
			'photo_category_status = '.$this->dbObj->Param($this->fields_arr['status']).', '.
			'photo_category_type = '.$this->dbObj->Param($this->fields_arr['photo_category_type']).', '.
			'priority = '.$this->dbObj->Param($priority).', '.
			'date_added = now()';
			$fields_value_arr = array($this->fields_arr['category'],
			$this->fields_arr['category_description'],
			$this->fields_arr['status'],
			$this->fields_arr['photo_category_type'],
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
	* ManagePhotoCategory::setIHObject()
	*
	* @param mixed $imObj
	* @return void
	*/
	public function setIHObject($imObj)
	{
		$this->imageObj = $imObj;
	}

   /**
	* ManagePhotoCategory::storeImagesTempServer()
	*
	* @param string $uploadUrl
	* @param string $extern
	* @return void
	*/
	public function storeImagesTempServer($uploadUrl, $extern)
	{
		@chmod($uploadUrl.'.'.$extern, 0777);
		if($this->CFG['admin']['photos']['category_height'] or $this->CFG['admin']['photos']['category_width'])
		{
			$this->imageObj->resize($this->CFG['admin']['photos']['category_width'], $this->CFG['admin']['photos']['category_height'], '-');
			$this->imageObj->output_resized($uploadUrl.'.'.$extern, strtoupper($extern));
		}
		else
		{
			$this->imageObj->output_original($uploadUrl.'.'.$extern, strtoupper($extern));
		}
	}

   /**
	* ManagePhotoCategory::updateCategoryImageExt()
	* To Update category image ext
	*
	* @param string $category_ext
	* @access public
	* @return void
	**/
	public function updateCategoryImageExt($categoryId,$category_ext)
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_category'].' SET '.
		'photo_category_ext = '.$this->dbObj->Param($category_ext).' '.
		'WHERE photo_category_id = '.$this->dbObj->Param('photo_category_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($category_ext, $categoryId));
		if (!$rs)
		trigger_db_error($this->dbObj);
		return true;
	}

   /**
	* ManagePhotoCategory::updateCategoryImageExt()
	*/
	public function setMediaPath($path='../../')
	{
		$this->media_relative_path = $path;
	}

   /**
	* ManagePhotoCategory::showCategories()
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
			$row['photo_category_name'] =  wordWrap_mb_ManualWithSpace($row['photo_category_name'], $this->CFG['admin']['photos']['member_photo_category_name_length'], $this->CFG['admin']['photos']['member_photo_category_name_total_length'], 0);
			$row['photo_category_description'] = wordWrap_mb_ManualWithSpace($row['photo_category_description'], $this->CFG['admin']['photos']['member_photo_category_description_length'], $this->CFG['admin']['photos']['member_photo_category_description_total_length'], 0);
			$showCategories_arr[$inc]['record'] = $row;
			$showCategories_arr[$inc]['checked'] = '';
			if((is_array($this->fields_arr['category_ids'])) && (in_array($row['photo_category_id'], $this->fields_arr['category_ids'])))
			$showCategories_arr[$inc]['checked'] = "CHECKED";
			$inc++;
		}
		$smartyObj->assign('showCategories_arr', $showCategories_arr);
	}

   /**
	* ManagePhotoCategory::getPhotoCount()
	* To get photo count of the category
	*
	* @param Integer $category_id
	* @return Integer
	*/
	public function getPhotoCount($category_id)
	{
		$sql = 'SELECT count(p.photo_id) as cat_count '.'FROM '.$this->CFG['db']['tbl']['photo'].' as p '.
		'WHERE photo_category_id = '.$this->dbObj->Param($category_id);
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($category_id));
		if (!$rs)
		trigger_db_error($this->dbObj);
		$row = $rs->FetchRow();
		return $row['cat_count'];
	}

   /**
	* ManagePhotoCategory::chkIsDuplicateSubCategory()
	*
	* @param string $err_tip
	* @return boolean
	*/
	public function chkIsDuplicateSubCategory($err_tip = '')
	{
		$sql = 'SELECT photo_category_id FROM '.$this->CFG['db']['tbl']['photo_category'].' WHERE photo_category_name='.$this->dbObj->Param('photo_category_name').
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
	* ManagePhotoCategory::chkIsDuplicateSubCategoryForEdit()
	*
	* @param string $err_tip
	* @return boolean
	*/
	public function chkIsDuplicateSubCategoryForEdit($err_tip = '')
	{
		$sql = 'SELECT photo_category_id FROM '.$this->CFG['db']['tbl']['photo_category'].
		' WHERE photo_category_name='.$this->dbObj->Param('photo_category_name').
		' AND parent_category_id='.$this->dbObj->Param('parent_category_id').
		' AND photo_category_id!='.$this->dbObj->Param('photo_category_id');
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
	* ManagePhotoCategory::updateSubCategory()
	*
	* @return void
	*/
	public function updateSubCategory()
	{
		$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'photo_category', 'update', $this->fields_arr['category_id']);
		$this->adjustPriorityOrder($this->fields_arr['category_id'], $priority, 'photo_category', 'photo_category_id', 'update', $this->fields_arr['category_id']);
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_category'].' SET'.
		' photo_category_name='.$this->dbObj->Param('photo_category_name').', '.
		' priority='.$this->dbObj->Param('priority').' WHERE'.
		' photo_category_id='.$this->dbObj->Param('photo_category_id').' AND'.
		' parent_category_id='.$this->dbObj->Param('parent_category_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category'], $priority, $this->fields_arr['sub_category_id'], $this->fields_arr['category_id']));
		if (!$rs)
		trigger_db_error($this->dbObj);
	}

   /**
	* ManagePhotoCategory::populateSubCategory()
	*
	* @return boolean
	*/
	public function populateSubCategory()
	{
		$sql = 'SELECT photo_category_name, priority, photo_category_id,photo_category_ext  FROM '.$this->CFG['db']['tbl']['photo_category'].
		' WHERE photo_category_id='.$this->dbObj->Param('photo_category_id').
		' AND parent_category_id='.$this->dbObj->Param('parent_category_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category_id'], $this->fields_arr['category_id']));
		if (!$rs)
		trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
		{
			$this->fields_arr['sub_category'] = $row['photo_category_name'];
			$this->fields_arr['priority'] = $row['priority'];
			$this->fields_arr['sub_category_id'] = $row['photo_category_id'];
			$this->fields_arr['photo_category_ext'] = $row['photo_category_ext'];
			return true;
		}
		return $row['photo_category_ext'];
	}

   /**
	* ManagePhotoCategory::deleteSeletctedSubCategories()
	*
	* @return void
	*/
	public function deleteSeletctedSubCategories()
	{
		$category_id = $this->fields_arr['category_id'];
		$category_ids = $this->fields_arr['category_ids'];
		$this->adjustPriorityOrder($category_id, '', 'photo_category', 'photo_category_id', 'delete', explode(',', $category_ids));
		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_category'].
		' WHERE photo_category_id  IN('.$this->fields_arr['category_ids'].')';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_db_error($this->dbObj);
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET photo_sub_category_id=0'.
		' WHERE photo_sub_category_id IN('.$this->fields_arr['category_ids'].')';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_db_error($this->dbObj);
	}

   /**
	* ManagePhotoCategory::chkPhotoExists()
	* To check if selected category have photos
	*
	* @param mixed $category_ids
	* @return boolean
	*/
	public function chkPhotoExists($category_ids)
	{
		$sql = 'SELECT count( p.photo_id ) AS cat_count, photo_category_id'.' FROM '.$this->CFG['db']['tbl']['photo'].' p'.
		' WHERE photo_category_id IN ( '.$category_ids.' )'.' AND photo_status!=\'Deleted\''.' GROUP BY photo_category_id';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_db_error($this->dbObj);
		if ($rs->PO_RecordCount())
		return true;
		return false;
	}

   /**
	* ManagePhotoCategory::deleteSelectedCategories()
	* To delete the given category id
	*
	* @return boolean
	*/
	public function deleteSelectedCategories()
	{
		$category_ids = $this->fields_arr['category_ids'];
		if ($this->chkPhotoExists($category_ids))
		return false;
		$this->adjustPriorityOrder(0, '', 'photo_category', 'photo_category_id', 'delete', explode(',', $category_ids));
		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_category'].' '.
		'WHERE photo_category_id IN ('.$category_ids.') ';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_db_error($this->dbObj);
		return true;
	}

   /**
	* ManagePhotoCategory::changeStatus()
	*
	* @param string $status
	* @return boolean
	*/
	public function changeStatus($status)
	{
		$category_ids = $this->fields_arr['category_ids'];
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_category'].' SET'.' photo_category_status='.$this->dbObj->Param('photo_category_status').
				' WHERE photo_category_id IN('.$category_ids.')';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($status));
		if (!$rs)
		trigger_db_error($this->dbObj);
		return true;
	}

   /**
	* ManagePhotoCategory::addSubCategory()
	*
	* @return void
	*/
	public function addSubCategory()
	{
		$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'photo_category', 'add', $this->fields_arr['category_id']);
		$this->adjustPriorityOrder($this->fields_arr['category_id'], $priority, 'photo_category', 'photo_category_id', 'add');
		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_category'].' SET'.
		' photo_category_name='.$this->dbObj->Param('photo_category_name').','.
		' parent_category_id='.$this->dbObj->Param('parent_category_id').','.
		' priority='.$this->dbObj->Param('priority').','.
		' photo_category_status=\'Yes\','.
		' date_added=NOW()';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category'], $this->fields_arr['category_id'], $priority));
		if (!$rs)
		trigger_db_error($this->dbObj);
		$this->subcategory_id = $this->dbObj->Insert_ID();
	}

   /**
	* ManagePhotoCategory::populateSubCategories()
	*
	* @return void
	*/
	public function populateSubCategories()
	{
		global $smartyObj;
		$populateSubCategories_arr = array();
		$sql = 'SELECT photo_category_id, photo_category_name,photo_category_ext,'.' DATE_FORMAT(date_added, \'%D %b %y\') AS date_added'.
		' FROM '.$this->CFG['db']['tbl']['photo_category'].' WHERE parent_category_id='.$this->dbObj->Param('parent_category_id');
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
				$row['photo_category_name'] = wordWrap_mb_ManualWithSpace($row['photo_category_name'], $this->CFG['admin']['photos']['admin_photo_category_name_length']);

				$populateSubCategories_arr['row'][$inc]['record'] = $row;
				$populateSubCategories_arr['row'][$inc]['checked'] = '';
				if((is_array($this->fields_arr['category_ids'])) && (in_array($row['photo_category_id'], $this->fields_arr['category_ids'])))
				$populateSubCategories_arr['row'][$inc]['checked'] = "CHECKED";
				$inc++;
			}
		}
		$smartyObj->assign('populateSubCategories_arr', $populateSubCategories_arr);
	}

   /**
	* ManagePhotoCategory::isValidCategoryId()
	* To check the photo_categroy id is valid or not
	*
	* @param Integer $category_id
	* @param string $err_tip
	* @return boolean
	*/
	public function isValidSubCategoryId($category_id, $err_tip='')
	{
		$sql = 'SELECT photo_category_id, photo_category_description,'.' photo_category_name, photo_category_status, date_added, photo_category_type, allow_post, photo_category_ext, priority'.
		' FROM '.$this->CFG['db']['tbl']['photo_category'].' WHERE photo_category_id = '.$this->dbObj->Param($this->fields_arr[$category_id]);
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
$managePhotoCategory = new ManagePhotoCategory();
$managePhotoCategory->setPageBlockNames(array('form_create_category', 'form_show_category', 'form_create_sub_category', 'form_show_sub_category', 'form_confirm'));
$managePhotoCategory->setMediaPath('../../');
$managePhotoCategory->setAllPageBlocksHide();
//default form fields and values...
$managePhotoCategory->resetFieldsArray();
$managePhotoCategory->setFormField('prev_numpg',0);//To retain the last numpg
/***********set form field for navigation****/
$managePhotoCategory->setFormField('asc', 'pc.photo_category_name');
$managePhotoCategory->setFormField('dsc', '');
$managePhotoCategory->setFormField('msg', '');
$managePhotoCategory->imageFormat=implode(', ',$CFG['admin']['photos']['category_image_format_arr']);

/*************Start navigation******/
$condition = '';
$managePhotoCategory->setTableNames(array($CFG['db']['tbl']['photo_category'].' as pc'));
$managePhotoCategory->setReturnColumns(array('pc.photo_category_id, pc.parent_category_id, pc.photo_category_name, pc.photo_category_type,'.
					' pc.photo_category_description, photo_category_ext, pc.photo_category_status, pc.allow_post, pc.priority, DATE_FORMAT(pc.date_added, \''.$CFG['format']['date'].'\') as date_added'));
$managePhotoCategory->sanitizeFormInputs($_REQUEST);

if ($managePhotoCategory->isFormGETed($_GET, 'category_id'))
{
	$managePhotoCategory->chkIsNotEmpty('category_id', $LANG['common_err_tip_required'])and
	$managePhotoCategory->chkIsNumeric('category_id', $LANG['managephotocategory_err_tip_invalid_category_id'])and
	$managePhotoCategory->isValidCategoryId('category_id', $LANG['managephotocategory_err_tip_invalid_category_id']);
	$managePhotoCategory->getFormField('start')and
	$managePhotoCategory->chkIsNumeric('start', $LANG['common_err_tip_required']);
	if ($managePhotoCategory->isFormGETed($_GET, 'sub_category_id'))
	{
		$managePhotoCategory->chkIsNotEmpty('sub_category_id', $LANG['common_err_tip_required'])and
		$managePhotoCategory->chkIsNumeric('sub_category_id', $LANG['managephotocategory_err_tip_invalid_category_id'])and
		$managePhotoCategory->isValidSubCategoryId('sub_category_id', $LANG['common_err_tip_required']);
	}
	if ($managePhotoCategory->isValidFormInputs())
	{
		if($managePhotoCategory->getFormField('opt')=='sub')
		{
			$managePhotoCategory->setAllPageBlocksHide();
			$managePhotoCategory->setPageBlockShow('form_create_sub_category');
		}
		else
		{
			$managePhotoCategory->getFormField('sub_category_id', '');
			$managePhotoCategory->setAllPageBlocksHide();
			$managePhotoCategory->setFormField('category_id', $managePhotoCategory->category_details_arr['photo_category_id']);
			$image_extern=$managePhotoCategory->category_details_arr['photo_category_ext'];
			$managePhotoCategory->category_image_ext_photo = $managePhotoCategory->category_details_arr['photo_category_ext'];
			$managePhotoCategory->category_tmp_photo_image = $managePhotoCategory->media_relative_path.$CFG['admin']['photos']['category_folder'].$CFG['admin']['photos']['photo_no_image'];
			$managePhotoCategory->category_image = $managePhotoCategory->media_relative_path.$CFG['admin']['photos']['category_folder'].$managePhotoCategory->category_details_arr['photo_category_id'].'.'.$managePhotoCategory->category_details_arr['photo_category_ext'];
			$managePhotoCategory->setFormField('category', stripslashes($managePhotoCategory->category_details_arr['photo_category_name']));
			$managePhotoCategory->setFormField('category_description', stripslashes($managePhotoCategory->category_details_arr['photo_category_description']));
			$managePhotoCategory->setFormField('status', $managePhotoCategory->category_details_arr['photo_category_status']);
			$managePhotoCategory->setFormField('allow_post', $managePhotoCategory->category_details_arr['allow_post']);
			$managePhotoCategory->setFormField('photo_category_type', $managePhotoCategory->category_details_arr['photo_category_type']);
			$managePhotoCategory->setFormField('priority', $managePhotoCategory->category_details_arr['priority']);
			$managePhotoCategory->setFormField('photo_category_ext', $managePhotoCategory->category_details_arr['photo_category_ext']);
		}
		if($managePhotoCategory->getFormField('opt')=='subedit')
		{
			$managePhotoCategory->category_image = $managePhotoCategory->media_relative_path.$CFG['admin']['photos']['category_folder'].$managePhotoCategory->getFormField('sub_category_id').'.'.$managePhotoCategory->category_details_arr['photo_category_ext'];
		}
	}
	else
	{
		$managePhotoCategory->setAllPageBlocksHide();
		$managePhotoCategory->setFormField('start', 0);
		$managePhotoCategory->setPageBlockShow('block_msg_form_error');
		$managePhotoCategory->setCommonErrorMsg($LANG['common_msg_error_sorry']);
	}
}

if ($managePhotoCategory->isFormPOSTed($_POST, 'confirm_action'))
{
	$managePhotoCategory->error = 0;
	if(!$managePhotoCategory->chkIsNotEmpty('category_ids', $LANG['common_err_tip_required']))
	{
		$managePhotoCategory->setCommonErrorMsg($LANG['managephotocategory_err_tip_select_category']);
	}
	if($managePhotoCategory->isValidFormInputs())
		{
			switch($managePhotoCategory->getFormField('action'))
					{
						case 'Delete':
							 if(!$managePhotoCategory->deleteSelectedCategories())
							 {
								$managePhotoCategory->setCommonErrorMsg($LANG['managephotocategory_err_tip_have_photo']);
								$managePhotoCategory->error = 1;
							 }
							 break;
						case 'Enable':
							$LANG['managephotocategory_success_message'] = $LANG['managephotocategory_success_enable_msg'];
							$managePhotoCategory->changeStatus('Yes');
							break;
						case 'Disable':
							$LANG['managephotocategory_success_message'] = $LANG['managephotocategory_success_disable_msg'];
							$managePhotoCategory->changeStatus('No');
							break;
					}
		}

	if($managePhotoCategory->getFormField('action')=='delete_category_image')
		{
			$managePhotoCategory->getFormField('category_id');
			$managePhotoCategory->deleteCategoryImage($managePhotoCategory->getFormField('category_id'));
			$managePhotoCategory->setCommonSuccessMsg($LANG['managephotocategory_image_success_delete_message']);
			$managePhotoCategory->setPageBlockShow('block_msg_form_success');
			$managePhotoCategory->setPageBlockShow('form_create_category');
			$url = getCurrentUrl(true).'&msg=success';
			Redirect2URL($url);
		}

	$managePhotoCategory->setAllPageBlocksHide();
	if ($managePhotoCategory->isValidFormInputs())
		{
			$managePhotoCategory->setCommonSuccessMsg($LANG['managephotocategory_success_message']);
			$managePhotoCategory->setPageBlockShow('block_msg_form_success');
			$managePhotoCategory->resetFieldsArray();
		}
	else
		{
			if(!$managePhotoCategory->error)
			$managePhotoCategory->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			$managePhotoCategory->setPageBlockShow('block_msg_form_error');
		}
}

if ($managePhotoCategory->isFormPOSTed($_POST, 'sub_category_submit'))
{
	if(!$managePhotoCategory->getFormField('sub_category_id'))
	{
		$managePhotoCategory->checkValidFileType('sub_category_image',$LANG['common_err_tip_invalid_file_type']) and
		$managePhotoCategory->chkValideFileSize('sub_category_image',$LANG['common_err_tip_invalid_file_size']) and
		$managePhotoCategory->chkErrorInFile('sub_category_image',$LANG['common_err_tip_invalid_file']);
	}
	$managePhotoCategory->chkIsNotEmpty('sub_category', $LANG['common_err_tip_required']);
	$managePhotoCategory->chkIsNotEmpty('category_id', $LANG['common_err_tip_required']);
	$managePhotoCategory->isValidFormInputs() and $managePhotoCategory->chkIsDuplicateSubCategory($LANG['managephotosubcategory_err_tip_alreay_exists']);
	if($managePhotoCategory->getFormField('priority'))
	$managePhotoCategory->chkIsNumeric('priority', $LANG['managephotocategory_err_tip_invalid_priority']);
	if($managePhotoCategory->isValidFormInputs())
	{
		if ($managePhotoCategory->isValidFormInputs())
		{
			$managePhotoCategory->addSubCategory();
			if ($managePhotoCategory->isValidFormInputs() && isset($_FILES['sub_category_image']['name']) && trim($_FILES['sub_category_image']['name']!=''))
			{
				$extern = strtolower(substr($_FILES['sub_category_image']['name'], strrpos($_FILES['sub_category_image']['name'], '.')+1));
				if (in_array($extern, $CFG['admin']['photos']['category_image_format_arr']))
				{
					if ($_FILES['sub_category_image']['size'] <= $CFG['admin']['photos']['category_image_max_size'] * 1024)
					{
						if (!$_FILES['sub_category_image']['error'])
						{
							$imageObj = new ImageHandler($_FILES['sub_category_image']['tmp_name']);
							$managePhotoCategory->setIHObject($imageObj);
							$image_name = $managePhotoCategory->subcategory_id;
							$temp_dir = $managePhotoCategory->media_relative_path.$CFG['admin']['photos']['category_folder'];
							$managePhotoCategory->chkAndCreateFolder($temp_dir);
							$temp_file = $temp_dir.$image_name;
							$managePhotoCategory->storeImagesTempServer($temp_file, $extern);
							$externs=$managePhotoCategory->setFormField('category_image_ext', $extern);
							$managePhotoCategory->updateCategoryImageExt($managePhotoCategory->subcategory_id,$extern);
						}
					}
				}
			}
			$managePhotoCategory->setFormField('sub_category', '');
			$managePhotoCategory->setFormField('priority', '');
			$managePhotoCategory->setFormField('photo_category_ext', $managePhotoCategory->category_details_arr['photo_category_ext']);
			$LANG['managephotocategory_success_message'] = $LANG['managephotocategory_success_add_message'];
			$managePhotoCategory->setCommonSuccessMsg($LANG['managephotocategory_success_message']);
			$managePhotoCategory->setPageBlockShow('block_msg_form_success');
			$managePhotoCategory->setPageBlockShow('form_create_sub_category');
		}
	}
	else
	{
		$managePhotoCategory->setCommonErrorMsg($LANG['common_msg_error_sorry']);
		$managePhotoCategory->setPageBlockShow('block_msg_form_error');
		$managePhotoCategory->setPageBlockShow('form_create_sub_category');
	}
}
else if($managePhotoCategory->chkIsEditModeSub())
{
	if($managePhotoCategory->isFormPOSTed($_POST, 'update_category_submit'))
	{
		$managePhotoCategory->sanitizeFormInputs($_REQUEST);
		$managePhotoCategory->chkIsNotEmpty('sub_category', $LANG['common_err_tip_required']);
		$managePhotoCategory->chkIsNotEmpty('category_id', $LANG['common_err_tip_required']);
		$managePhotoCategory->checkValidFileType('sub_category_image',$LANG['common_err_tip_invalid_file_type']) and
		$managePhotoCategory->chkValideFileSize('sub_category_image',$LANG['common_err_tip_invalid_file_size']) and
		$managePhotoCategory->chkErrorInFile('sub_category_image',$LANG['common_err_tip_invalid_file']);
		$managePhotoCategory->isValidFormInputs() and $managePhotoCategory->chkIsDuplicateSubCategoryForEdit($LANG['managephotosubcategory_err_tip_alreay_exists']);
		if($managePhotoCategory->getFormField('priority'))
		$managePhotoCategory->chkIsNumeric('priority', $LANG['managephotocategory_err_tip_invalid_priority']);
		$managePhotoCategory->isValidCategoryId('category_id', $LANG['managephotocategory_err_tip_invalid_category_id']);
		$managePhotoCategory->isValidCategoryId('sub_category_id', $LANG['managephotocategory_err_tip_invalid_category_id']);
		if($managePhotoCategory->isValidFormInputs())
		{
			$managePhotoCategory->updateSubCategory();
			if ($managePhotoCategory->isValidFormInputs() && isset($_FILES['sub_category_image']['name']) && trim($_FILES['sub_category_image']['name']!=''))
			{
				$extern = strtolower(substr($_FILES['sub_category_image']['name'], strrpos($_FILES['sub_category_image']['name'], '.')+1));
				if (in_array($extern, $CFG['admin']['photos']['category_image_format_arr']))
				{
					if ($_FILES['sub_category_image']['size'] <= $CFG['admin']['photos']['category_image_max_size'] * 1024)
					{
						if (!$_FILES['sub_category_image']['error'])
						{
							$imageObj = new ImageHandler($_FILES['sub_category_image']['tmp_name']);
							$managePhotoCategory->setIHObject($imageObj);
							$image_name = $managePhotoCategory->getFormField('sub_category_id');
							$temp_dir = $managePhotoCategory->media_relative_path.$CFG['admin']['photos']['category_folder'];
							$managePhotoCategory->chkAndCreateFolder($temp_dir);
							$temp_file = $temp_dir.$image_name;
							$managePhotoCategory->storeImagesTempServer($temp_file, $extern);
							$managePhotoCategory->setFormField('category_image_ext', $extern);
							$managePhotoCategory->updateCategoryImageExt($managePhotoCategory->getFormField('sub_category_id'),$extern);
						}
					}
				}
			}
			$managePhotoCategory->setFormField('sub_category', '');
			$managePhotoCategory->setFormField('priority', '');
			$managePhotoCategory->setFormField('opt', 'sub');
			$LANG['managephotocategory_success_message'] = $LANG['managephotocategory_success_edit_message'];
			$managePhotoCategory->setCommonSuccessMsg($LANG['managephotocategory_success_message']);
			$managePhotoCategory->setPageBlockShow('block_msg_form_success');
			$managePhotoCategory->setPageBlockShow('form_create_sub_category');
		}
		else
		{
			$managePhotoCategory->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			$managePhotoCategory->setPageBlockShow('block_msg_form_error');
			$managePhotoCategory->setPageBlockShow('form_create_sub_category');
		}
	}
	else if($managePhotoCategory->populateSubCategory())
	{
		$managePhotoCategory->setPageBlockShow('form_create_sub_category');
		$managePhotoCategory->sub_category_image = $managePhotoCategory->media_relative_path.$CFG['admin']['photos']['category_folder'].$managePhotoCategory->getFormField('sub_category_id').'.'.$managePhotoCategory->getFormField('photo_category_ext');
		//Condition to delete the subcategory image
		if($managePhotoCategory->getFormField('action')=='delete_subcategory_image')
			{
				$managePhotoCategory->deleteCategoryImage($managePhotoCategory->getFormField('sub_category_id'));
				$managePhotoCategory->setCommonSuccessMsg($LANG['managephotocategory_image_success_delete_message']);
				$managePhotoCategory->setPageBlockShow('block_msg_form_success');
				$managePhotoCategory->setPageBlockShow('form_create_sub_category');
				$url = getCurrentUrl(true).'&msg=success';
				Redirect2URL($url);
			}
		if($managePhotoCategory->getFormField('msg')=='success')
			{
				$managePhotoCategory->setCommonSuccessMsg($LANG['managephotocategory_image_delete_success_message']);
				$managePhotoCategory->setPageBlockShow('block_msg_form_success');
			}
	}
}
else if($managePhotoCategory->isFormPOSTed($_POST, 'confirm_actionSub'))
{
	$managePhotoCategory->deleteSeletctedSubCategories();
	$managePhotoCategory->setCommonSuccessMsg($LANG['managephotocategory_success_message']);
	$managePhotoCategory->setPageBlockShow('block_msg_form_success');
	$managePhotoCategory->setPageBlockShow('form_create_sub_category');
}
else if ($managePhotoCategory->isFormPOSTed($_POST, 'category_submit'))
{
	if(!$managePhotoCategory->getFormField('category_id') || isset($_FILES['category_image']['name']) && trim($_FILES['category_image']['name']!=''))
	{
		$managePhotoCategory->checkValidFileType('category_image',$LANG['common_err_tip_invalid_file_type']) and
		$managePhotoCategory->chkValideFileSize('category_image',$LANG['common_err_tip_invalid_file_size']) and
		$managePhotoCategory->chkErrorInFile('category_image',$LANG['common_err_tip_invalid_file']);
	}
	$managePhotoCategory->chkIsNotEmpty('category', $LANG['common_err_tip_required'])and
		$managePhotoCategory->chkCategoryExists('category', $LANG['managephotocategory_err_tip_alreay_exists']);
	$managePhotoCategory->chkIsNotEmpty('status', $LANG['common_err_tip_required']);
	$managePhotoCategory->chkIsNotEmpty('category_description', $LANG['common_err_tip_required']);
	$managePhotoCategory->getFormField('category_id')and
	$managePhotoCategory->chkIsNotEmpty('category_id', $LANG['common_err_tip_required'])and
	$managePhotoCategory->chkIsNumeric('category_id', $LANG['managephotocategory_err_tip_invalid_category_id'])and
	$managePhotoCategory->isValidCategoryId('category_id', $LANG['managephotocategory_err_tip_invalid_category_id']);
	//$managePhotoCategory->category_image = $managePhotoCategory->media_relative_path.$CFG['admin']['photos']['category_folder'].$managePhotoCategory->category_details_arr['photo_category_id'].'.'.$managePhotoCategory->category_details_arr['photo_category_ext'];
	//$managePhotoCategory->setFormField('photo_category_ext', $managePhotoCategory->category_details_arr['photo_category_ext']);
	if($managePhotoCategory->getFormField('priority'))
	$managePhotoCategory->chkIsNumeric('priority', $LANG['managephotocategory_err_tip_invalid_priority']);
	$managePhotoCategory->isValidFormInputs()and
	$managePhotoCategory->createCategory($CFG['db']['tbl']['photo_category']);
	if ($managePhotoCategory->isValidFormInputs() && isset($_FILES['category_image']['name']) && trim($_FILES['category_image']['name']!=''))
	{
		$extern = strtolower(substr($_FILES['category_image']['name'], strrpos($_FILES['category_image']['name'], '.')+1));
		if (in_array($extern, $CFG['admin']['photos']['category_image_format_arr']))
		{
			if ($_FILES['category_image']['size'] <= $CFG['admin']['photos']['category_image_max_size'] * 1024)
			{
				if (!$_FILES['category_image']['error'])
				{
					$imageObj = new ImageHandler($_FILES['category_image']['tmp_name']);
					$managePhotoCategory->setIHObject($imageObj);
					$image_name = $managePhotoCategory->category_id;
					$temp_dir = $managePhotoCategory->media_relative_path.$CFG['admin']['photos']['category_folder'];
					$managePhotoCategory->chkAndCreateFolder($temp_dir);
					$temp_file = $temp_dir.$image_name;
					$managePhotoCategory->storeImagesTempServer($temp_file, $extern);
					$managePhotoCategory->setFormField('category_image_ext', $extern);
					$managePhotoCategory->updateCategoryImageExt($managePhotoCategory->category_id,$extern);
				}
			}
		}
	}
	if ($managePhotoCategory->isValidFormInputs())
	{
		if($managePhotoCategory->getFormField('category_id'))
		$managePhotoCategory->setCommonSuccessMsg($LANG['managephotocategory_success_edit_message']);
		else
		$managePhotoCategory->setCommonSuccessMsg($LANG['managephotocategory_success_add_message']);
		$managePhotoCategory->setPageBlockShow('block_msg_form_success');
		$managePhotoCategory->resetFieldsArray();
	}
	else
	{
		$managePhotoCategory->setAllPageBlocksHide();
		$managePhotoCategory->setCommonErrorMsg($LANG['common_msg_error_sorry']);
		$managePhotoCategory->setPageBlockShow('block_msg_form_error');
		//$managePhotoCategory->setFormField('category_id', $managePhotoCategory->category_details_arr['photo_category_id']);
	}
}
else if($managePhotoCategory->isFormPOSTed($_POST, 'category_cancel'))
{
	$managePhotoCategory->resetFieldsArray();
}

if ($managePhotoCategory->isFormPOSTed($_POST, 'sub_category_cancel'))
{
	$url = $CFG['site']['url'].'admin/photo/managePhotoCategory.php?category_id='.$managePhotoCategory->getFormField('category_id').'&opt=sub';
	$managePhotoCategory->resetFieldsArray();
	Redirect2URL($url);
}

if($managePhotoCategory->getFormField('msg')=='success' && !$managePhotoCategory->getFormField('sub_category_id'))
{
	$managePhotoCategory->setCommonSuccessMsg($LANG['managephotocategory_image_delete_success_message']);
	$managePhotoCategory->setPageBlockShow('block_msg_form_success');
}

$managePhotoCategory->left_navigation_div = 'photoMain';

if (!$managePhotoCategory->isShowPageBlock('form_create_sub_category'))
{
	$condition = 'parent_category_id=0';
	$managePhotoCategory->buildSelectQuery();
	$managePhotoCategory->buildConditionQuery($condition);
	$managePhotoCategory->buildSortQuery();
	$managePhotoCategory->checkSortQuery('pc.photo_category_name', 'asc');
	$managePhotoCategory->buildQuery();
	$managePhotoCategory->executeQuery();
	$managePhotoCategory->setPageBlockShow('form_create_category');
	$managePhotoCategory->setPageBlockShow('form_show_category');
}


/*  Set the smarty variables  */
$managePhotoCategory->hidden_arr1 = array('start', 'category_id');
$managePhotoCategory->hidden_arr2 = array('category_id', 'opt');
if ($managePhotoCategory->isShowPageBlock('form_create_category'))
{
	$managePhotoCategory->form_create_category['hidden_arr'] = array('category_id', 'start');
}
if ($managePhotoCategory->isShowPageBlock('form_show_category'))
{
	$managePhotoCategory->form_show_category['hidden_arr'] = array('start');
	if($managePhotoCategory->isResultsFound())
	{
		$managePhotoCategory->showCategories();
		$smartyObj->assign('smarty_paging_list', $managePhotoCategory->populatePageLinksPOST($managePhotoCategory->getFormField('start'), 'selFormCategory'));
	}
}
if ($managePhotoCategory->isShowPageBlock('form_create_sub_category'))
{
	$managePhotoCategory->setPageBlockShow('form_show_sub_category');
	$managePhotoCategory->form_create_sub_category['hidden_arr'] = array('category_id', 'opt');
}
if ($managePhotoCategory->isShowPageBlock('form_show_sub_category'))
{
	$managePhotoCategory->populateSubCategories();
}


//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$managePhotoCategory->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'photo');
$smartyObj->display('managePhotoCategory.tpl');
//Added jquery validation for required fileds in photo category and subcategory
if($CFG['feature']['jquery_validation'])
{
	$allowed_image_formats = implode("|", $CFG['admin']['photos']['category_image_format_arr']);
	if ($managePhotoCategory->isShowPageBlock('form_create_category'))
		{
?>
		<script type="text/javascript">
		$Jq("#selCreateCategory").validate({
		rules: {
			category: {
				required: true
		    },
			category_description: {
				required: true
		    },
		    category_image: {
				isValidFileFormat: "<?php echo $allowed_image_formats; ?>"
		    }
		 },
		 messages: {
		 	category: {
				required: "<?php echo $LANG['common_err_tip_required'];?>"
			},
			category_description: {
				required: "<?php echo $LANG['common_err_tip_required'];?>"
			},
			category_image: {
				isValidFileFormat: "<?php echo $LANG['common_err_tip_invalid_image_format']; ?>"
		    }
		}
		});
		</script>
<?php
		}
	elseif($managePhotoCategory->isShowPageBlock('form_create_sub_category'))
	{
?>
	<script type="text/javascript">
		$Jq("#selCreateSubCategory").validate({
		rules: {
			sub_category: {
				required: true
		    },
		    sub_category_image: {
				isValidFileFormat: "<?php echo $allowed_image_formats; ?>"
		    }
		 },
		 messages: {
		 	sub_category: {
				required: "<?php echo $LANG['common_err_tip_required'];?>"
			},
			sub_category_image: {
				isValidFileFormat: "<?php echo $LANG['common_err_tip_invalid_image_format']; ?>"
		    }
		}
		});
		</script>
<?php
	}
}
?>
<script language="javascript" type="text/javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmSub');
</script>
<?php
//<<<<<-------------------- Page block templates ends -------------------//
$managePhotoCategory->includeFooter();
?>