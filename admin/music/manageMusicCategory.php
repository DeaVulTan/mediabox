<?php
/**
* This file is use for manage Music Category
*
* This file is having Adding category and sub category
*
*
* @category	Rayzz
* @package		Admin
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
**/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/manageMusicCategory.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['site']['is_module_page']='music';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
/**
* This class is used to manage music playlist
*
* @category	Rayzz
* @package		manage music playlist
*/
class MusicCategoryFormHandler extends MusicHandler
	{
		public $category_details_arr;
		public $subcategory_details_arr;
		public $category_id;
		/**
		* musicCategoryFormHandler::setIHObject()
		*
		* @param mixed $imObj
		* @return void
		*/
		public function setIHObject($imObj)
			{
				$this->imageObj = $imObj;
			}
		/**
		* musicCategoryFormHandler::buildConditionQuery()
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
		* musicCategoryFormHandler::checkSortQuery()
		* To sort the query
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
		* musicCategoryFormHandler::storeImagesTempServer()
		*
		* @param string $uploadUrl
		* @param string $extern
		* @return void
		*/
		public function storeImagesTempServer($uploadUrl, $extern)
			{
				@chmod($uploadUrl.'.'.$extern, 0777);
				if($this->CFG['admin']['musics']['category_height'] or $this->CFG['admin']['musics']['category_width'])
					{
						$this->imageObj->resize($this->CFG['admin']['musics']['category_width'], $this->CFG['admin']['musics']['category_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'.'.$extern, strtoupper($extern));
					}
				else
					{
						$this->imageObj->output_original($uploadUrl.'.'.$extern, strtoupper($extern));
					}
			}
		/**
		* musicCategoryFormHandler::isValidCategoryId()
		* To check the music_categroy id is valid or not
		*
		* @param Integer $category_id
		* @param string $err_tip
		* @return boolean
		*/
		public function isValidCategoryId($category_id, $err_tip='')
			{
				$sql = 'SELECT music_category_id, music_category_description,'.
				' music_category_name, music_category_status, date_added, music_category_type, allow_post, music_category_ext, priority'.
				' FROM '.$this->CFG['db']['tbl']['music_category'].
				' WHERE music_category_id = '.$this->dbObj->Param($this->fields_arr[$category_id]);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$category_id]));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if ($this->category_details_arr = $rs->FetchRow())
					{
						return true;
					}
				$this->setCommonErrorMsg($err_tip);
				return false;
			}
		/**
		* musicCategoryFormHandler::chkmusicExists()
		* To check if selected category have musics
		*
		* @param mixed $category_ids
		* @return boolean
		*/
		public function chkmusicExists($category_ids)
			{
				$sql = 'SELECT count( g.music_id ) AS cat_count, music_category_id'.' FROM '.$this->CFG['db']['tbl']['music'].' g'.
				' WHERE music_category_id IN ( '.$category_ids.' )'.' AND music_status!=\'Deleted\''.' GROUP BY music_category_id';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if ($rs->PO_RecordCount())
				return true;
				return false;
			}
		/**
		* musicCategoryFormHandler::deleteSelectedCategories()
		* To delete the given category id
		*
		* @return boolean
		*/
		public function deleteSelectedCategories()
			{
				$category_ids = $this->fields_arr['category_ids'];
				if ($this->chkmusicExists($category_ids))
				return false;
				$this->adjustPriorityOrder(0, '', 'music_category', 'music_category_id', 'delete', explode(',', $category_ids));
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_category'].' '.
				'WHERE music_category_id IN ('.$category_ids.') ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				return true;
			}
		/**
		* musicCategoryFormHandler::chkCategoryExits()
		* To check if the category exists already
		*
		* @param string $category
		* @param string $err_tip
		* @return boolean
		*/
		public function chkCategoryExits($category, $err_tip='')
			{
				$sql = 'SELECT COUNT(music_category_id) AS count FROM '.$this->CFG['db']['tbl']['music_category'].' '.
				'WHERE UCASE(music_category_name) = UCASE('.$this->dbObj->Param($this->fields_arr[$category]).') AND parent_category_id =0 ';
				$fields_value_arr[] = $this->fields_arr[$category];
				if ($this->fields_arr['category_id'])
					{
						$sql .= ' AND music_category_id != '.$this->dbObj->Param($this->fields_arr['category_id']);
						$fields_value_arr[] = $this->fields_arr['category_id'];
					}
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($fields_value_arr));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
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
		* musicCategoryFormHandler::getLastPriority()
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
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$row = $rs->FetchRow();
				return $row['last_priority_value'];
			}
		/**
		* musicCategoryFormHandler::getPriorityOrder()
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
		* musicCategoryFormHandler::adjustPriorityOrder()
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
								trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
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
											trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
									}
								elseif($current_priority>$this->category_details_arr['priority'])
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl'][$table].' SET '.
												'priority = priority-1 WHERE priority <= \''.$current_priority.'\' AND priority >= \''.$this->category_details_arr['priority'].'\' '.$condition;

										$stmt_update = $this->dbObj->Prepare($sql);
										$resultSet = $this->dbObj->Execute($stmt_update);
										if (!$resultSet)
											trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
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
											trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
									}
								elseif($current_priority>$this->subcategory_details_arr['priority'])
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl'][$table].' SET '.
												'priority = priority-1 WHERE priority <= \''.$current_priority.'\' AND priority >= \''.$this->subcategory_details_arr['priority'].'\' '.$condition;
										$stmt_update = $this->dbObj->Prepare($sql);
										$resultSet = $this->dbObj->Execute($stmt_update);
										if (!$resultSet)
											trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
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
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
							$row = $rs->FetchRow();
							$current_priority = $row['priority'];
							$sql_query = 'UPDATE '.$this->CFG['db']['tbl'][$table].' SET '.
							'priority = \'0\' WHERE '.$field_name.' = \''.$category_ids[$inc].'\''.$condition;
							$stmt_result = $this->dbObj->Prepare($sql_query);
							$rsSet = $this->dbObj->Execute($stmt_result);
							if (!$rsSet)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
							$sql = 'SELECT '.$field_name.' '.
							'FROM '.$this->CFG['db']['tbl'][$table].' '.
							'WHERE priority > '.$this->dbObj->Param($current_priority).$condition;
							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($current_priority));
							if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
							while($resultSet = $rs->FetchRow())
								{
									$value = $resultSet[$field_name];
									$sql = 'UPDATE '.$this->CFG['db']['tbl'][$table].' SET '.
									'priority ='.$current_priority.' WHERE '.$field_name.' = '.$this->dbObj->Param($value).$condition;
									$stmt = $this->dbObj->Prepare($sql);
									$rsSet = $this->dbObj->Execute($stmt, array($value));
									if (!$rsSet)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
									$current_priority++;
								}
						}
					break;
					}
				return true;
			}
		/**
		* musicCategoryFormHandler::isValidCategoryId()
		* To check the music_categroy id is valid or not
		*
		* @param Integer $category_id
		* @param string $err_tip
		* @return boolean
		*/
		public function isValidSubCategoryId($category_id, $err_tip='')
			{
				$sql = 'SELECT music_category_id, music_category_description,'.' music_category_name, music_category_status, date_added, music_category_type, allow_post, music_category_ext, priority'.
				' FROM '.$this->CFG['db']['tbl']['music_category'].' WHERE music_category_id = '.$this->dbObj->Param($this->fields_arr[$category_id]);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$category_id]));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if ($this->subcategory_details_arr = $rs->FetchRow())
					{
						return true;
					}
				$this->setCommonErrorMsg($err_tip);
				return false;
			}
		/**
		* musicCategoryFormHandler::createCategory()
		* To create/update music category
		*
		* @param string $category_table
		* @return boolean
		*/
		public function createCategory($category_table,$category)
			{
				$old_priority = $this->fields_arr['priority'];
					if ($this->fields_arr['category_id'])
						{

							if($this->chkUpdateCategoryAlreadyExists($this->fields_arr['category_id'],$this->fields_arr['category']))
                			{

								$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'music_category', 'update', 0);
								$this->adjustPriorityOrder(0, $priority, 'music_category', 'music_category_id', 'update', $this->fields_arr['category_id']);
								$sql = 'UPDATE '.$category_table.' SET '.
								'music_category_name = '.$this->dbObj->Param($this->fields_arr['category']).', '.
								'music_category_description = '.$this->dbObj->Param($this->fields_arr['category_description']).', '.
								'music_category_status = '.$this->dbObj->Param($this->fields_arr['status']).', '.
								'music_category_type = '.$this->dbObj->Param($this->fields_arr['music_category_type']).', '.
								'allow_post= '.$this->dbObj->Param($this->fields_arr['allow_post']).', '.
								'priority= '.$this->dbObj->Param($priority).' '.
								'WHERE music_category_id = '.$this->dbObj->Param($this->fields_arr['category_id']);
								$fields_value_arr = array($this->fields_arr['category'],
								$this->fields_arr['category_description'],
								$this->fields_arr['status'],
								$this->fields_arr['music_category_type'],
								$this->fields_arr['allow_post'],
								$priority,
								$this->fields_arr['category_id']);
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
								if (!$rs)
								trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
								$this->category_id = $this->fields_arr['category_id'];
								return true;
							}
							else
							{
                                return false;
							}
						}
					else
						{

							if($this->chkCategoryAlreadyExists($category))
                			{
									$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'music_category', 'add', 0);
									$this->adjustPriorityOrder(0, $priority, 'music_category', 'music_category_id', 'add');
									$sql = 'INSERT INTO '.$category_table.' SET '.
									'music_category_name = '.$this->dbObj->Param($this->fields_arr['category']).', '.
									'music_category_description = '.$this->dbObj->Param($this->fields_arr['category_description']).', '.
									'music_category_status = '.$this->dbObj->Param($this->fields_arr['status']).', '.
									'music_category_type = '.$this->dbObj->Param($this->fields_arr['music_category_type']).', '.
									'priority = '.$this->dbObj->Param($priority).', '.
									'date_added = now()';
									$fields_value_arr = array($this->fields_arr['category'],
									$this->fields_arr['category_description'],
									$this->fields_arr['status'],
									$this->fields_arr['music_category_type'],
									$priority);
									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
									if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
									$this->category_id = $this->dbObj->Insert_ID();
									return true;
								}
								else
								{
							    	return false;
								}
						}
			      }
		/**
		* musicCategoryFormHandler::chkCategoryAlreadyExists()
		*
		* @return boolean
		*/
		public function chkCategoryAlreadyExists($category)
			{

				$sql = 'SELECT music_category_name  FROM '.$this->CFG['db']['tbl']['music_category'].
				' WHERE music_category_name='.$this->dbObj->Param('music_category_name') .' AND parent_category_id =0 ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
                if($rs->PO_RecordCount())
				{
					if($row = $rs->FetchRow())
						return false;
				}
		     	return true;
             }
        /**
		* musicCategoryFormHandler::chkUpdateCategoryAlreadyExists()
		*
		* @return boolean
		*/
		public function chkUpdateCategoryAlreadyExists($category_id,$category)
			{

				$sql = 'SELECT music_category_name,music_category_id  FROM '.$this->CFG['db']['tbl']['music_category'].
				' WHERE music_category_id != '.$this->dbObj->Param('music_category_id').' AND music_category_name='.$this->dbObj->Param('music_category_name');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category_id,$category));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$total = $rs->PO_RecordCount();
				if($total>0)
				{
                  return false;
				}
				else
				{
				  return true;
				}
             }

		/**
		* musicCategoryFormHandler::getmusicCount()
		* To get music count of the category
		*
		* @param Integer $category_id
		* @return Integer
		*/
		public function getmusicCount($category_id)
			{
				$sql = 'SELECT count(g.music_id) as cat_count '.
				'FROM '.$this->CFG['db']['tbl']['music'].' as g '.
				'WHERE music_category_id = '.$this->dbObj->Param($category_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category_id));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$row = $rs->FetchRow();
				return $row['cat_count'];
			}
		/**
		* musicCategoryFormHandler::showCategories()
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
						$row['music_category_name'] =  wordWrap_mb_ManualWithSpace($row['music_category_name'], $this->CFG['admin']['musics']['admin_music_category_name_length'], $this->CFG['admin']['musics']['admin_music_category_name_total_length'], 0);
						$row['music_category_description'] = wordWrap_mb_ManualWithSpace($row['music_category_description'], $this->CFG['admin']['musics']['admin_music_category_description_length'], $this->CFG['admin']['musics']['admin_music_category_description_total_length'], 0);
						$showCategories_arr[$inc]['record'] = $row;
						$showCategories_arr[$inc]['checked'] = '';
						if((is_array($this->fields_arr['category_ids'])) && (in_array($row['music_category_id'], $this->fields_arr['category_ids'])))
						$showCategories_arr[$inc]['checked'] = "CHECKED";
						$inc++;
					}
				$smartyObj->assign('showCategories_arr', $showCategories_arr);
			}
		/**
		* musicCategoryFormHandler::populateSubCategories()
		*
		* @return void
		*/
		public function populateSubCategories()
			{
				global $smartyObj;
				$populateSubCategories_arr = array();
				$sql = 'SELECT music_category_id, music_category_name,music_category_ext,'.
				' DATE_FORMAT(date_added, \'%D %b %y\') AS date_added'.
				' FROM '.$this->CFG['db']['tbl']['music_category'].
				' WHERE parent_category_id='.$this->dbObj->Param('parent_category_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['category_id']));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$populateSubCategories_arr['rs_PO_RecordCount'] = $rs->PO_RecordCount();
				if($rs->PO_RecordCount())
					{
						$populateSubCategories_arr['row'] = array();
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								$row['music_category_name'] = wordWrap_mb_ManualWithSpace($row['music_category_name'], $this->CFG['admin']['musics']['admin_music_category_name_length']);

								$populateSubCategories_arr['row'][$inc]['record'] = $row;
								$populateSubCategories_arr['row'][$inc]['checked'] = '';
								if((is_array($this->fields_arr['category_ids'])) && (in_array($row['music_category_id'], $this->fields_arr['category_ids'])))
								$populateSubCategories_arr['row'][$inc]['checked'] = "CHECKED";
								$inc++;
							}
					}
				$smartyObj->assign('populateSubCategories_arr', $populateSubCategories_arr);
			}
		/**
		* musicCategoryFormHandler::chkValidFileType()
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
						if (!in_array($extern, $this->CFG['admin']['musics']['category_image_format_arr']))
								{
									$this->fields_err_tip_arr[$field_name] = $err_tip;
									return false;
								}
					}
				return true;
			}
		/**
		* musicCategoryFormHandler::chkValideFileSize()
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
						$max_size = $this->CFG['admin']['musics']['category_image_max_size'] * 1024;
						if ($_FILES[$field_name]['size'] > $max_size)
							{
								$this->fields_err_tip_arr[$field_name] = $err_tip;
								return false;
							}
					}
				return true;
			}
		/**
		* musicCategoryFormHandler::chkErrorInFile()
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
		* musicCategoryFormHandler::resetFieldsArray()
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
				$this->setFormField('category_image_ext', '');
				$this->setFormField('status', 'Yes');
				$this->setFormField('category_ids', array());
				$this->setFormField('action', '');
				$this->setFormField('opt', '');
				$this->setFormField('allow_post', 'Yes');
				$this->setFormField('music_category_type', 'General');
				$this->setFormField('music_category_ext', '');
				$this->setFormField('priority', '');
			}
		/**
		* musicCategoryFormHandler::chkIsEditMode()
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
		* musicCategoryFormHandler::chkIsEditModeSubCategory()
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
		* musicCategoryFormHandler::changeStatus()
		*
		* @param string $status
		* @return boolean
		*/
		public function changeStatus($status)
			{
				$category_ids = $this->fields_arr['category_ids'];
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_category'].' SET'.
				' music_category_status='.$this->dbObj->Param('music_category_status').
				' WHERE music_category_id IN('.$category_ids.')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				return true;
			}
		/**
		* musicCategoryFormHandler::chkIsDuplicateSubCategory()
		*
		* @param string $err_tip
		* @return boolean
		*/
		public function chkIsDuplicateSubCategory($err_tip = '')
			{
				$sql = 'SELECT music_category_id FROM '.$this->CFG['db']['tbl']['music_category'].
				' WHERE music_category_name='.$this->dbObj->Param('music_category_name').
				' AND parent_category_id='.$this->dbObj->Param('parent_category_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category'], $this->fields_arr['category_id']));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if($rs->PO_RecordCount())
					{
						$this->fields_err_tip_arr['sub_category'] = $err_tip;
						return false;
					}
				return true;
			}
		/**
		* musicCategoryFormHandler::chkIsDuplicateSubCategoryForEdit()
		*
		* @param string $err_tip
		* @return boolean
		*/
		public function chkIsDuplicateSubCategoryForEdit($err_tip = '')
			{
				$sql = 'SELECT music_category_id FROM '.$this->CFG['db']['tbl']['music_category'].
				' WHERE music_category_name='.$this->dbObj->Param('music_category_name').
				' AND parent_category_id='.$this->dbObj->Param('parent_category_id').
				' AND music_category_id!='.$this->dbObj->Param('music_category_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category'], $this->fields_arr['category_id'], $this->fields_arr['sub_category_id']));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if($rs->PO_RecordCount())
					{
						$this->fields_err_tip_arr['sub_category'] = $err_tip;
						return false;
					}
				return true;
			}
		/**
		* musicCategoryFormHandler::addSubCategory()
		*
		* @return void
		*/
		public function addSubCategory()
			{
				$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'music_category', 'add', $this->fields_arr['category_id']);
				$this->adjustPriorityOrder($this->fields_arr['category_id'], $priority, 'music_category', 'music_category_id', 'add');
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_category'].' SET'.
				' music_category_name='.$this->dbObj->Param('music_category_name').','.
				' parent_category_id='.$this->dbObj->Param('parent_category_id').','.
				' priority='.$this->dbObj->Param('priority').','.
				' music_category_status=\'Yes\','.
				' date_added=NOW()';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category'], $this->fields_arr['category_id'], $priority));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$this->subcategory_id = $this->dbObj->Insert_ID();
			}
		/**
		* musicCategoryFormHandler::updateSubCategory()
		*
		* @return void
		*/
		public function updateSubCategory()
			{
				$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'music_category', 'update', $this->fields_arr['category_id']);
				$this->adjustPriorityOrder($this->fields_arr['category_id'], $priority, 'music_category', 'music_category_id', 'update', $this->fields_arr['category_id']);
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_category'].' SET'.
				' music_category_name='.$this->dbObj->Param('music_category_name').', '.
				' priority='.$this->dbObj->Param('priority').' WHERE'.
				' music_category_id='.$this->dbObj->Param('music_category_id').' AND'.
				' parent_category_id='.$this->dbObj->Param('parent_category_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category'], $priority, $this->fields_arr['sub_category_id'], $this->fields_arr['category_id']));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		/**
		* musicCategoryFormHandler::populateSubCategory()
		*
		* @return boolean
		*/
		public function populateSubCategory()
			{
				$sql = 'SELECT music_category_name, priority, music_category_id,music_category_ext  FROM '.$this->CFG['db']['tbl']['music_category'].
				' WHERE music_category_id='.$this->dbObj->Param('music_category_id').
				' AND parent_category_id='.$this->dbObj->Param('parent_category_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category_id'], $this->fields_arr['category_id']));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if($row = $rs->FetchRow())
					{
						$this->fields_arr['sub_category'] = $row['music_category_name'];
						$this->fields_arr['priority'] = $row['priority'];
						$this->fields_arr['sub_category_id'] = $row['music_category_id'];
						$this->fields_arr['music_category_ext'] = $row['music_category_ext'];
						return true;
					}
				return $row['music_category_ext'];
			}
		/**
		* musicCategoryFormHandler::deleteSeletctedSubCategories()
		*
		* @return void
		*/
		public function deleteSeletctedSubCategories()
			{
				$category_id = $this->fields_arr['category_id'];
				$category_ids = $this->fields_arr['category_ids'];
				$this->adjustPriorityOrder($category_id, '', 'music_category', 'music_category_id', 'delete', explode(',', $category_ids));
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_category'].
				' WHERE music_category_id  IN('.$this->fields_arr['category_ids'].')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET music_sub_category_id=0'.
				' WHERE music_sub_category_id IN('.$this->fields_arr['category_ids'].')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		/**
		* To Update category image ext
		*
		* @param string $category_ext
		* @access public
		* @return void
		**/
		public function updateCategoryImageExt($categoryId,$category_ext)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_category'].' SET '.
				'music_category_ext = '.$this->dbObj->Param($category_ext).' '.
				'WHERE music_category_id = '.$this->dbObj->Param($this->category_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category_ext, $categoryId));
				if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				return true;
			}
			public function setMediaPath($path='../../')
				{
					$this->media_relative_path = $path;
				}

	}
//<<<<<<<--------------class musicCategoryFormHandler---------------//
//--------------------Code begins-------------->>>>>//
$category = new MusicCategoryFormHandler();
$category->setPageBlockNames(array('form_create_category', 'form_create_sub_category', 'form_show_category', 'form_show_sub_category', 'form_confirm'));
$category->setMediaPath('../../');
$category->setAllPageBlocksHide();
//default form fields and values...
$category->resetFieldsArray();
$category->setFormField('prev_numpg',0);//To retain the last numpg
/***********set form field for navigation****/
$category->setFormField('asc', 'gc.music_category_name');
$category->setFormField('dsc', '');
$category->setFormField('priority', '');
$category->setFormField('sub_category_id', '');
$category->setFormField('music_category_ext', '');
$category->imageFormat=implode(', ',$CFG['admin']['musics']['category_image_format_arr']);
//$category->setFormField('category_id', '');
/*************Start navigation******/
//fetch number of records show in the result--numpg
$condition = '';
//Set tables and fields to return
$category->setTableNames(array($CFG['db']['tbl']['music_category'].' as gc'));
$category->setReturnColumns(array('gc.music_category_id, gc.priority,gc.music_category_description, gc.music_category_name, gc.music_category_status, DATE_FORMAT(gc.date_added, \''.$CFG['format']['date'].'\') as date_added','music_category_ext','allow_post','music_category_type'));
$category->sanitizeFormInputs($_REQUEST);
/*************End navigation******/
if ($category->isFormGETed($_GET, 'category_id'))
	{
		$category->chkIsNotEmpty('category_id', $LANG['common_err_tip_required'])and
		$category->chkIsNumeric('category_id', $LANG['managemusiccategory_err_tip_invalid_category_id'])and
		$category->isValidCategoryId('category_id', $LANG['managemusiccategory_err_tip_invalid_category_id']);
		$category->getFormField('start')and
		$category->chkIsNumeric('start', $LANG['common_err_tip_required']);
		if ($category->isFormGETed($_GET, 'sub_category_id'))
			{
				$category->chkIsNotEmpty('sub_category_id', $LANG['common_err_tip_required'])and
				$category->chkIsNumeric('sub_category_id', $LANG['managemusiccategory_err_tip_invalid_category_id'])and
				$category->isValidSubCategoryId('sub_category_id', $LANG['common_err_tip_required']);
			}
		if ($category->isValidFormInputs())
			{
				if($category->getFormField('opt')=='sub')
					{
						$category->setAllPageBlocksHide();
						$category->setPageBlockShow('form_create_sub_category');
					}
				else
					{
						$category->getFormField('sub_category_id', '');
						$category->setAllPageBlocksHide();
						$category->setFormField('category_id', $category->category_details_arr['music_category_id']);
						$image_extern=$category->category_details_arr['music_category_ext'];
						$category->category_image_ext_music = $category->category_details_arr['music_category_ext'];
						$category->category_tmp_music_image = $category->media_relative_path.$CFG['admin']['musics']['category_folder'].$CFG['admin']['musics']['music_no_image'];
						$category->category_image = $category->media_relative_path.$CFG['admin']['musics']['category_folder'].$category->category_details_arr['music_category_id'].'.'.$category->category_details_arr['music_category_ext'];
						$category->setFormField('category', stripslashes($category->category_details_arr['music_category_name']));
						$category->setFormField('category_description', stripslashes($category->category_details_arr['music_category_description']));
						$category->setFormField('status', $category->category_details_arr['music_category_status']);
						$category->setFormField('allow_post', $category->category_details_arr['allow_post']);
						$category->setFormField('music_category_type', $category->category_details_arr['music_category_type']);
						$category->setFormField('priority', $category->category_details_arr['priority']);
						$category->setFormField('music_category_ext', $category->category_details_arr['music_category_ext']);
					}
				if($category->getFormField('opt')=='subedit')
					{
						$category->category_image = $category->media_relative_path.$CFG['admin']['musics']['category_folder'].$category->getFormField('sub_category_id').'.'.$category->category_details_arr['music_category_ext'];
					}
			}
		else
			{
				$category->setAllPageBlocksHide();
				$category->setFormField('start', 0);
				$category->setPageBlockShow('block_msg_form_error');
				$category->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			}
	}
if ($category->isFormPOSTed($_POST, 'confirm_action'))
	{
		$category->error = 0;
		if(!$category->chkIsNotEmpty('category_ids', $LANG['common_err_tip_required']))
				{
					$category->setCommonErrorMsg($LANG['managemusiccategory_err_tip_select_category']);
				}
		if($category->isValidFormInputs())
			{
				switch($category->getFormField('action'))
						{
							case 'Delete':
							if(!$category->deleteSelectedCategories())
									{
										$category->setCommonErrorMsg($LANG['managemusiccategory_err_tip_have_music']);
										$category->error = 1;
									}
								break;
								case 'Enable':
								$LANG['managemusiccategory_success_message'] = $LANG['managemusiccategory_success_enable_msg'];
								$category->changeStatus('Yes');
								break;
								case 'Disable':
								$LANG['managemusiccategory_success_message'] = $LANG['managemusiccategory_success_disable_msg'];
								$category->changeStatus('No');
								break;
						}
			}
		$category->setAllPageBlocksHide();
		if ($category->isValidFormInputs())
			{
				$category->setCommonSuccessMsg($LANG['managemusiccategory_success_message']);
				$category->setPageBlockShow('block_msg_form_success');
				$category->resetFieldsArray();
			}
		else
			{
				if(!$category->error)
				$category->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$category->setPageBlockShow('block_msg_form_error');
			}
	}
if ($category->isFormPOSTed($_POST, 'sub_category_submit'))
	{
		if(!$category->getFormField('sub_category_id'))
		{
		$category->chkValidFileType('sub_category_image',$LANG['common_err_tip_invalid_file_type']) and
		$category->chkValideFileSize('sub_category_image',$LANG['common_err_tip_invalid_file_size']) and
		$category->chkErrorInFile('sub_category_image',$LANG['common_err_tip_invalid_file']);
		}
		$category->chkIsNotEmpty('sub_category', $LANG['common_err_tip_required']);
		$category->chkIsNotEmpty('category_id', $LANG['common_err_tip_required']);
		$category->isValidFormInputs() and $category->chkIsDuplicateSubCategory($LANG['managemusiccategory_already_exist']);
		if($category->getFormField('priority'))
		$category->chkIsNumeric('priority', $LANG['managemusiccategory_err_tip_invalid_priority']);
		if($category->isValidFormInputs())
			{
			if ($category->isValidFormInputs())
				{
					$category->addSubCategory();
					if ($category->isValidFormInputs() && isset($_FILES['sub_category_image']['name']) && trim($_FILES['sub_category_image']['name']!=''))
						{
							$extern = strtolower(substr($_FILES['sub_category_image']['name'], strrpos($_FILES['sub_category_image']['name'], '.')+1));
							if (in_array($extern, $CFG['admin']['musics']['category_image_format_arr']))
								{
									if ($_FILES['sub_category_image']['size'] <= $CFG['admin']['musics']['category_image_max_size'] * 1024)
										{
											if (!$_FILES['sub_category_image']['error'])
												{
													$imageObj = new ImageHandler($_FILES['sub_category_image']['tmp_name']);
													$category->setIHObject($imageObj);
													$image_name = $category->subcategory_id;
													$temp_dir = $category->media_relative_path.$CFG['admin']['musics']['category_folder'];
													$category->chkAndCreateFolder($temp_dir);
													$temp_file = $temp_dir.$image_name;
													$category->storeImagesTempServer($temp_file, $extern);
													$externs=$category->setFormField('category_image_ext', $extern);
													$category->updateCategoryImageExt($category->subcategory_id,$extern);
												}
										}
								}
						}
					$category->setFormField('sub_category', '');
					$category->setFormField('priority', '');
					$category->setFormField('music_category_ext', $category->category_details_arr['music_category_ext']);
					$LANG['managemusiccategory_success_message'] = $LANG['managemusiccategory_success_add_message'];
					$category->setCommonSuccessMsg($LANG['managemusiccategory_success_message']);
					$category->setPageBlockShow('block_msg_form_success');
					$category->setPageBlockShow('form_create_sub_category');
				}
			}
		else
			{
				$category->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$category->setPageBlockShow('block_msg_form_error');
				$category->setPageBlockShow('form_create_sub_category');
			}
	}
else if($category->chkIsEditModeSub())
	{
		if($category->isFormPOSTed($_POST, 'update_category_submit'))
			{
				$category->sanitizeFormInputs($_REQUEST);
				$category->chkIsNotEmpty('sub_category', $LANG['common_err_tip_required']);
				$category->chkIsNotEmpty('category_id', $LANG['common_err_tip_required']);
				$category->chkValidFileType('sub_category_image',$LANG['common_err_tip_invalid_file_type']) and
				$category->chkValideFileSize('sub_category_image',$LANG['common_err_tip_invalid_file_size']) and
				$category->chkErrorInFile('sub_category_image',$LANG['common_err_tip_invalid_file']);
				$category->isValidFormInputs() and $category->chkIsDuplicateSubCategoryForEdit($LANG['managemusiccategory_already_exist']);
				if($category->getFormField('priority'))
				$category->chkIsNumeric('priority', $LANG['managemusiccategory_err_tip_invalid_priority']);
				$category->isValidCategoryId('category_id', $LANG['managemusiccategory_err_tip_invalid_category_id']);
				$category->isValidCategoryId('sub_category_id', $LANG['managemusiccategory_err_tip_invalid_category_id']);
				if($category->isValidFormInputs())
					{
						$category->updateSubCategory();
						if ($category->isValidFormInputs() && isset($_FILES['sub_category_image']['name']) && trim($_FILES['sub_category_image']['name']!=''))
							{
								$extern = strtolower(substr($_FILES['sub_category_image']['name'], strrpos($_FILES['sub_category_image']['name'], '.')+1));
								if (in_array($extern, $CFG['admin']['musics']['category_image_format_arr']))
									{
										if ($_FILES['sub_category_image']['size'] <= $CFG['admin']['musics']['category_image_max_size'] * 1024)
											{
												if (!$_FILES['sub_category_image']['error'])
													{
														$imageObj = new ImageHandler($_FILES['sub_category_image']['tmp_name']);
														$category->setIHObject($imageObj);
														$image_name = $category->getFormField('sub_category_id');
														$temp_dir = $category->media_relative_path.$CFG['admin']['musics']['category_folder'];
														$category->chkAndCreateFolder($temp_dir);
														$temp_file = $temp_dir.$image_name;
														$category->storeImagesTempServer($temp_file, $extern);
														$category->setFormField('category_image_ext', $extern);
														$category->updateCategoryImageExt($category->getFormField('sub_category_id'),$extern);
													}
											}
									}
							}
						$category->setFormField('sub_category', '');
						$category->setFormField('priority', '');
						$category->setFormField('opt', 'sub');
						$LANG['managemusiccategory_success_message'] = $LANG['managemusiccategory_success_edit_message'];
						$category->setCommonSuccessMsg($LANG['managemusiccategory_success_message']);
						$category->setPageBlockShow('block_msg_form_success');
						$category->setPageBlockShow('form_create_sub_category');
					}
				else
					{
						$category->setCommonErrorMsg($LANG['common_msg_error_sorry']);
						$category->setPageBlockShow('block_msg_form_error');
						$category->setPageBlockShow('form_create_sub_category');
					}
			}
		else if($category->populateSubCategory())
			{
				$category->setPageBlockShow('form_create_sub_category');
				$category->sub_category_image = $category->media_relative_path.$CFG['admin']['musics']['category_folder'].$category->getFormField('sub_category_id').'.'.$category->getFormField('music_category_ext');
			}
	}
else if($category->isFormPOSTed($_POST, 'confirm_actionSub'))
	{
		$category->deleteSeletctedSubCategories();
		$category->setCommonSuccessMsg($LANG['managemusiccategory_success_message']);
		$category->setPageBlockShow('block_msg_form_success');
		$category->setPageBlockShow('form_create_sub_category');
	}
else if ($category->isFormPOSTed($_POST, 'category_submit'))
	{
		if(!$category->getFormField('category_id'))
			{
				$category->chkValidFileType('category_image',$LANG['common_err_tip_invalid_file_type']) and
				$category->chkValideFileSize('category_image',$LANG['common_err_tip_invalid_file_size']) and
				$category->chkErrorInFile('category_image',$LANG['common_err_tip_invalid_file']);
			}
		$category->chkIsNotEmpty('category', $LANG['common_err_tip_required'])and
		$category->chkIsNotEmpty('status', $LANG['common_err_tip_required']);
		$category->chkIsNotEmpty('category_description', $LANG['common_err_tip_required']);
		$category->getFormField('category_id')and
		$category->chkIsNotEmpty('category_id', $LANG['common_err_tip_required'])and
		$category->chkIsNumeric('category_id', $LANG['managemusiccategory_err_tip_invalid_category_id'])and
		$category->isValidCategoryId('category_id', $LANG['managemusiccategory_err_tip_invalid_category_id']);
		if($category->getFormField('priority'))
		$category->chkIsNumeric('priority', $LANG['managemusiccategory_err_tip_invalid_priority']);
	if($category->isValidFormInputs())
	{
		if($category->createCategory($CFG['db']['tbl']['music_category'],$category->getFormField('category')))
		{
			if ($category->isValidFormInputs() && isset($_FILES['category_image']['name']) && trim($_FILES['category_image']['name']!=''))
			{
				$extern = strtolower(substr($_FILES['category_image']['name'], strrpos($_FILES['category_image']['name'], '.')+1));
				if (in_array($extern, $CFG['admin']['musics']['category_image_format_arr']))
				{
					if ($_FILES['category_image']['size'] <= $CFG['admin']['musics']['category_image_max_size'] * 1024)
					{
						if (!$_FILES['category_image']['error'])
						{
							$imageObj = new ImageHandler($_FILES['category_image']['tmp_name']);
							$category->setIHObject($imageObj);
							$image_name = $category->category_id;
							$temp_dir = $category->media_relative_path.$CFG['admin']['musics']['category_folder'];
							$category->chkAndCreateFolder($temp_dir);
							$temp_file = $temp_dir.$image_name;
							$category->storeImagesTempServer($temp_file, $extern);
							$category->setFormField('category_image_ext', $extern);
							$category->updateCategoryImageExt($category->category_id,$extern);
						}
					}
				}
			}
			if ($category->isValidFormInputs())
			{
				if($category->getFormField('category_id'))
				$category->setCommonSuccessMsg($LANG['managemusiccategory_success_edit_message']);
				else
				$category->setCommonSuccessMsg($LANG['managemusiccategory_success_add_message']);
				$category->setPageBlockShow('block_msg_form_success');
				$category->resetFieldsArray();
			}
			else
			{
				$category->setAllPageBlocksHide();
				$category->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$category->setPageBlockShow('block_msg_form_error');
				$category->setFormField('category_id', $category->category_details_arr['music_category_id']);
			}
		}
		//Category Already Added Error Block
		else
		{
			$category->setAllPageBlocksHide();
			$category->setCommonErrorMsg($LANG['managemusiccategory_category_error_msg']);
			$category->setPageBlockShow('block_msg_form_error');
			$category->setFormField('category_id', $category->category_details_arr['music_category_id']);
		}
	}
	//Invalid Iputs Error Block
	else
	{
		$category->setAllPageBlocksHide();
		$category->setCommonErrorMsg($LANG['common_msg_error_sorry']);
		$category->setPageBlockShow('block_msg_form_error');
		$category->setFormField('category_id', $category->category_details_arr['music_category_id']);
	}
}
else if($category->isFormPOSTed($_POST, 'category_cancel'))
	{
		$category->resetFieldsArray();
	}
if ($category->isFormPOSTed($_POST, 'sub_category_cancel'))
	{
		$url = $CFG['site']['url'].'admin/music/manageMusicCategory.php?category_id='.$category->getFormField('category_id').'&opt=sub';
		$category->resetFieldsArray();
		Redirect2URL($url);
	}
/*************Start navigation******/
if (!$category->isShowPageBlock('form_create_sub_category'))
	{
		$condition = 'parent_category_id=0';
		$category->buildSelectQuery();
		$category->buildConditionQuery($condition);
		$category->buildSortQuery();
		$category->checkSortQuery('gc.music_category_name', 'asc');
		$category->buildQuery();
		$category->executeQuery();
		/*************End navigation******/
		$category->setPageBlockShow('form_create_category');
		$category->setPageBlockShow('form_show_category');
	}
//<<<<--------------------Code Ends----------------------//
$category->hidden_arr1 = array('start', 'category_id');
$category->hidden_arr2 = array('category_id', 'opt');
if ($category->isShowPageBlock('form_create_category'))
	{
		$category->form_create_category['hidden_arr'] = array('category_id', 'start');
	}
if ($category->isShowPageBlock('form_create_sub_category'))
	{
		$category->setPageBlockShow('form_show_sub_category');
		$category->form_create_sub_category['hidden_arr'] = array('category_id', 'opt');
	}
if ($category->isShowPageBlock('form_show_sub_category'))
	{
		$category->populateSubCategories();
	}
if ($category->isShowPageBlock('form_show_category'))
	{
		$category->form_show_category['hidden_arr'] = array('start');
		if($category->isResultsFound())
			{
				$category->showCategories();
				$smartyObj->assign('smarty_paging_list', $category->populatePageLinksPOST($category->getFormField('start'), 'selFormCategory'));
			}
	}
$category->left_navigation_div = 'musicMain';
//include the header file
$category->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'music');
$smartyObj->display('manageMusicCategory.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript">
var block_arr= new Array('selMsgConfirm', 'selMsgConfirmSub');
var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
</script>
<?php
$category->includeFooter();
?>