<?php
/**
 * Manage Group Category
 *
 *
 * @category	Rayzz
 * @package		admin
 **/
require_once('../../common/configs/config.inc.php');
require_once('../../common/configs/config_video.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/admin/manageVideoCategory.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
//$CFG['mods']['include_files'][] = 'video/common/classes/class_VideoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['site']['is_module_page']='video';
$CFG['html']['header'] = 'admin/html_header.php';;
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class VideoCategoryFormHandler--------------->>>//
/**
 * @category	Rayzz
 * @package		Admin
 **/
class VideoCategoryFormHandler extends ListRecordsHandler
	{
		public $category_details_arr;
		public $subcategory_details_arr;
		public $category_id;

		/**
		 * VideoCategoryFormHandler::setIHObject()
		 *
		 * @param mixed $imObj
		 * @return void
		 */
		public function setIHObject($imObj)
			{
				$this->imageObj = $imObj;
			}

		/**
		 * VideoCategoryFormHandler::buildConditionQuery()
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
		 * VideoCategoryFormHandler::checkSortQuery()
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
		 * VideoCategoryFormHandler::storeImagesTempServer()
		 *
		 * @param string $uploadUrl
		 * @param string $extern
		 * @return void
		 */
		public function storeImagesTempServer($uploadUrl, $extern)
			{
				//GET LARGE IMAGE
				@chmod($uploadUrl.'.'.$extern, 0777);
				if($this->CFG['admin']['videos']['category_height'] or $this->CFG['admin']['videos']['category_width'])
					{
						$this->imageObj->resize($this->CFG['admin']['videos']['category_width'], $this->CFG['admin']['videos']['category_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'.'.$extern, strtoupper($extern));
					}
				else
					{
						$this->imageObj->output_original($uploadUrl.'.'.$extern, strtoupper($extern));
					}
			}

		/**
		 * VideoCategoryFormHandler::isValidCategoryId()
		 * To check the video_categroy id is valid or not
		 *
		 * @param Integer $category_id
		 * @param string $err_tip
		 * @return boolean
		 */
		public function isValidCategoryId($category_id, $err_tip='')
			{
				$sql = 'SELECT video_category_id, video_category_description,'.
						' video_category_name, video_category_status, date_added, video_category_type, allow_post, video_category_ext, priority'.
						' FROM '.$this->CFG['db']['tbl']['video_category'].
						' WHERE video_category_id = '.$this->dbObj->Param($this->fields_arr[$category_id]);

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
		 * VideoCategoryFormHandler::chkVideoExists()
		 * To check if selected category have videos
		 *
		 * @param mixed $category_ids
		 * @return boolean
		 */
		public function chkVideoExists($category_ids)
			{
				$sql = 'SELECT count( g.video_id ) AS cat_count, video_category_id'.
						' FROM '.$this->CFG['db']['tbl']['video'].' g'.
						' WHERE video_category_id IN ( '.$category_ids.' )'.
						' AND video_status!=\'Deleted\''.
						' GROUP BY video_category_id';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					return true;
				return false;
			}

		/**
		 * VideoCategoryFormHandler::deleteSelectedCategories()
		 * To delete the given category id
		 *
		 * @return boolean
		 */
		public function deleteSelectedCategories()
			{
				$category_ids = $this->fields_arr['category_ids'];
				//$category_id = $this->fields_arr['category_id'];

				if ($this->chkVideoExists($category_ids))
						return false;

				//Adjust priority order..
				$this->adjustPriorityOrder(0, '', 'video_category', 'video_category_id', 'delete', explode(',', $category_ids));

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['video_category'].' '.
						'WHERE video_category_id IN ('.$category_ids.') ';
				$stmt = $this->dbObj->Prepare($sql);

				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				return true;

			}

		/**
		 * VideoCategoryFormHandler::chkCategoryExits()
		 * To check if the category exists already
		 *
		 * @param string $category
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkCategoryExits($category, $err_tip='')
			{
				$sql = 'SELECT COUNT(video_category_id) AS count FROM '.$this->CFG['db']['tbl']['video_category'].' '.
						'WHERE UCASE(video_category_name) = UCASE('.$this->dbObj->Param($this->fields_arr[$category]).') ';
				$fields_value_arr[] = $this->fields_arr[$category];
				if ($this->fields_arr['category_id'])
					{
						$sql .= ' AND video_category_id != '.$this->dbObj->Param($this->fields_arr['category_id']);
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
		 * VideoCategoryFormHandler::getLastPriority()
		 *
		 * @param mixed $table
		 * @param mixed $parent_category_id
		 * @return
		 */
		public function getLastPriority($table, $parent_category_id)
			{
				$sql = 'SELECT max(priority) as last_priority_value '.
						'FROM '.$this->CFG['db']['tbl'][$table].' WHERE parent_category_id = \''.$parent_category_id.'\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = $rs->FetchRow();
				return $row['last_priority_value'];
			}

		/**
		 * VideoCategoryFormHandler::getPriorityOrder()
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
				if($priority_order == '' or !isset($priority_order) or $priority_order==0)//if user set empty priority or 0 then we take last one..
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
				else//we find priority order..
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
		 * VideoCategoryFormHandler::adjustPriorityOrder()
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
				//Main/sub category..
				$condition = ' AND parent_category_id = \''.$parent_category_id.'\'';
				$getLastPriority = $this->getLastPriority($table, $parent_category_id);
				switch($action)
					{
						case 'add'://Insert..
								if($current_priority >= $getLastPriority) //Last priority so no adjustment..
									{
										return true;
									}
								elseif($current_priority<$getLastPriority)//Last priority less then current so adjustment is need..
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl'][$table].' SET '.
												'priority = priority+1 '.' WHERE priority >= \''.$current_priority.'\''.$condition;

										$stmt_update = $this->dbObj->Prepare($sql);
										$resultSet = $this->dbObj->Execute($stmt_update);
										if (!$resultSet)
											trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
									}
						break;

						case 'update'://update.
								if($current_priority >$getLastPriority) //Last priority so no adjustment..
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

						case 'delete'://Delete..
								for($inc=0;$inc<count($category_ids);$inc++)
									{
										//Get current priority..
										$sql = 'SELECT priority '.
												'FROM '.$this->CFG['db']['tbl'][$table].' '.
												'WHERE '.$field_name.' = '.$this->dbObj->Param($category_ids[$inc]).$condition;

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($category_ids[$inc]));
										if (!$rs)
											trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

										$row = $rs->FetchRow();
										$current_priority = $row['priority'];

										//Set category is as zero..
										$sql_query = 'UPDATE '.$this->CFG['db']['tbl'][$table].' SET '.
													 'priority = \'0\' WHERE '.$field_name.' = \''.$category_ids[$inc].'\''.$condition;

										$stmt_result = $this->dbObj->Prepare($sql_query);
										$rsSet = $this->dbObj->Execute($stmt_result);
										if (!$rsSet)
											trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

										//Get category_ids..
										$sql = 'SELECT '.$field_name.' '.
												'FROM '.$this->CFG['db']['tbl'][$table].' '.
												'WHERE priority > '.$this->dbObj->Param($current_priority).$condition;

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($current_priority));
										if (!$rs)
											trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

										//Uptate priority order..
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
		 * VideoCategoryFormHandler::isValidCategoryId()
		 * To check the video_categroy id is valid or not
		 *
		 * @param Integer $category_id
		 * @param string $err_tip
		 * @return boolean
		 */
		public function isValidSubCategoryId($category_id, $err_tip='')
			{
				$sql = 'SELECT video_category_id, video_category_description,'.
						' video_category_name, video_category_status, date_added, video_category_type, allow_post, video_category_ext, priority'.
						' FROM '.$this->CFG['db']['tbl']['video_category'].
						' WHERE video_category_id = '.$this->dbObj->Param($this->fields_arr[$category_id]);

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
		 * VideoCategoryFormHandler::createCategory()
		 * To create/update video category
		 *
		 * @param string $category_table
		 * @return boolean
		 */
		public function createCategory($category_table)
			{
				$old_priority = $this->fields_arr['priority'];
				if ($this->fields_arr['category_id'])
					{
						//Get priority order..
						$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'video_category', 'update', 0);
						//Adjust priority order..
						$this->adjustPriorityOrder(0, $priority, 'video_category', 'video_category_id', 'update', $this->fields_arr['category_id']);
						$sql = 'UPDATE '.$category_table.' SET '.
								'video_category_name = '.$this->dbObj->Param($this->fields_arr['category']).', '.
								'video_category_description = '.$this->dbObj->Param($this->fields_arr['category_description']).', '.
								'video_category_status = '.$this->dbObj->Param($this->fields_arr['status']).', '.
								'video_category_type = '.$this->dbObj->Param($this->fields_arr['video_category_type']).', '.
								'allow_post= '.$this->dbObj->Param($this->fields_arr['allow_post']).', '.
								'priority= '.$this->dbObj->Param($priority).' '.
								'WHERE video_category_id = '.$this->dbObj->Param($this->fields_arr['category_id']);

						$fields_value_arr = array($this->fields_arr['category'],
												$this->fields_arr['category_description'],
												$this->fields_arr['status'],
												$this->fields_arr['video_category_type'],
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
						//Get priority order..
						$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'video_category', 'add', 0);
						//Adjust priority order..
						$this->adjustPriorityOrder(0, $priority, 'video_category', 'video_category_id', 'add');
						$sql = 'INSERT INTO '.$category_table.' SET '.
									'video_category_name = '.$this->dbObj->Param($this->fields_arr['category']).', '.
									'video_category_description = '.$this->dbObj->Param($this->fields_arr['category_description']).', '.
									'video_category_status = '.$this->dbObj->Param($this->fields_arr['status']).', '.
									'priority = '.$this->dbObj->Param($priority).', '.
									'date_added = now()';

						$fields_value_arr = array($this->fields_arr['category'],
													$this->fields_arr['category_description'],
													$this->fields_arr['status'],
													$priority);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
						if (!$rs)
					        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$this->category_id = $this->dbObj->Insert_ID();
						return true;
					}
			}

		/**
		 * VideoCategoryFormHandler::getVideoCount()
		 * To get video count of the category
		 *
		 * @param Integer $category_id
		 * @return Integer
		 */
		public function getVideoCount($category_id)
			{
				$sql = 'SELECT count(g.video_id) as cat_count '.
						'FROM '.$this->CFG['db']['tbl']['video'].' as g '.
						'WHERE video_category_id = '.$this->dbObj->Param($category_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category_id));
				if (!$rs)
			        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = $rs->FetchRow();
				return $row['cat_count'];
			}

		/**
		 * VideoCategoryFormHandler::showCategories()
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
						$row['video_category_name'] = wordWrap_mb_ManualWithSpace($row['video_category_name'], $this->CFG['admin']['videos']['admin_video_category_name_length']);
						$row['video_category_description'] = wordWrap_mb_ManualWithSpace($row['video_category_description'], $this->CFG['admin']['videos']['admin_video_category_description_length']);
						$showCategories_arr[$inc]['record'] = $row;
						$showCategories_arr[$inc]['checked'] = '';
						if((is_array($this->fields_arr['category_ids'])) && (in_array($row['video_category_id'], $this->fields_arr['category_ids'])))
							$showCategories_arr[$inc]['checked'] = "CHECKED";

						$inc++;
					}

				$smartyObj->assign('showCategories_arr', $showCategories_arr);
			}

		/**
		 * VideoCategoryFormHandler::populateSubCategories()
		 *
		 * @return void
		 */
		public function populateSubCategories()
			{

				global $smartyObj;
				$populateSubCategories_arr = array();
				$sql = 'SELECT video_category_id, video_category_name, date_added'.
						' FROM '.$this->CFG['db']['tbl']['video_category'].
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
								$row['video_category_name'] = wordWrap_mb_ManualWithSpace($row['video_category_name'], $this->CFG['admin']['videos']['admin_video_category_name_length']);
								$populateSubCategories_arr['row'][$inc]['record'] = $row;
								$populateSubCategories_arr['row'][$inc]['checked'] = '';
								if((is_array($this->fields_arr['category_ids'])) && (in_array($row['video_category_id'], $this->fields_arr['category_ids'])))
									$populateSubCategories_arr['row'][$inc]['checked'] = "CHECKED";
								$inc++;
							}
					}
				$smartyObj->assign('populateSubCategories_arr', $populateSubCategories_arr);
			}

		/**
		 * VideoCategoryFormHandler::chkFileNmaeIsNotEmpty()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkFileNameIsNotEmpty($field_name, $err_tip = '')
			{
				if(!$_FILES[$field_name]['name'])
					{
						$this->setFormFieldErrorTip($field_name,$err_tip);
						return false;
					}
				return true;
			}

		/**
		 * VideoCategoryFormHandler::chkValidFileType()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkValidFileType($field_name, $err_tip = '')
			{
				$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));
				if (!in_array($extern, $this->CFG['admin']['videos']['category_image_format_arr']))
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * VideoCategoryFormHandler::chkValideFileSize()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkValideFileSize($field_name, $err_tip='')
			{
				$max_size = $this->CFG['admin']['videos']['category_image_max_size'] * 1024;
				if ($_FILES[$field_name]['size'] > $max_size)
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * VideoCategoryFormHandler::chkErrorInFile()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkErrorInFile($field_name, $err_tip='')
			{
				if($_FILES[$field_name]['error'])
					{
						$this->fields_err_tip_arr[$field_name] = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * VideoCategoryFormHandler::resetFieldsArray()
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
				$this->setFormField('video_category_type', 'General');
				$this->setFormField('video_category_ext', '');
				$this->setFormField('priority', '');
			}

		/**
		 * VideoCategoryFormHandler::chkIsEditMode()
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
		 * VideoCategoryFormHandler::chkIsEditModeSubCategory()
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
		 * VideoCategoryFormHandler::changeStatus()
		 *
		 * @param string $status
		 * @return boolean
		 */
		public function changeStatus($status)
			{
				$category_ids = $this->fields_arr['category_ids'];
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_category'].' SET'.
						' video_category_status='.$this->dbObj->Param('video_category_status').
						' WHERE video_category_id IN('.$category_ids.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				return true;
			}

		/**
		 * VideoCategoryFormHandler::chkIsDuplicateSubCategory()
		 *
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkIsDuplicateSubCategory($err_tip = '')
			{
				$sql = 'SELECT video_category_id FROM '.$this->CFG['db']['tbl']['video_category'].
						' WHERE video_category_name='.$this->dbObj->Param('video_category_name').
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
		 * VideoCategoryFormHandler::chkIsDuplicateSubCategoryForEdit()
		 *
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkIsDuplicateSubCategoryForEdit($err_tip = '')
			{
				$sql = 'SELECT video_category_id FROM '.$this->CFG['db']['tbl']['video_category'].
						' WHERE video_category_name='.$this->dbObj->Param('video_category_name').
						' AND parent_category_id='.$this->dbObj->Param('parent_category_id').
						' AND video_category_id!='.$this->dbObj->Param('video_category_id');

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
		 * VideoCategoryFormHandler::addSubCategory()
		 *
		 * @return void
		 */
		public function addSubCategory()
			{
				//Get priority order..
				$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'video_category', 'add', $this->fields_arr['category_id']);
				//die('End of solution');
				//Adjust priority order..
				$this->adjustPriorityOrder($this->fields_arr['category_id'], $priority, 'video_category', 'video_category_id', 'add');
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_category'].' SET'.
						' video_category_name='.$this->dbObj->Param('video_category_name').','.
						' parent_category_id='.$this->dbObj->Param('parent_category_id').','.
						' priority='.$this->dbObj->Param('priority').','.
						' video_category_status=\'Yes\','.
						' date_added=NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category'], $this->fields_arr['category_id'], $priority));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$this->subcategory_id = $this->dbObj->Insert_ID();
			}

		/**
		 * VideoCategoryFormHandler::updateSubCategory()
		 *
		 * @return void
		 */
		public function updateSubCategory()
			{
				//Get priority order..
				$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'video_category', 'update', $this->fields_arr['category_id']);
				//Adjust priority order..
				$this->adjustPriorityOrder($this->fields_arr['category_id'], $priority, 'video_category', 'video_category_id', 'update', $this->fields_arr['category_id']);

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_category'].' SET'.
						' video_category_name='.$this->dbObj->Param('video_category_name').', '.
						' priority='.$this->dbObj->Param('priority').' WHERE'.
						' video_category_id='.$this->dbObj->Param('video_category_id').' AND'.
						' parent_category_id='.$this->dbObj->Param('parent_category_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category'], $priority, $this->fields_arr['sub_category_id'], $this->fields_arr['category_id']));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		/**
		 * VideoCategoryFormHandler::populateSubCategory()
		 *
		 * @return boolean
		 */
		public function populateSubCategory()
			{
				$sql = 'SELECT video_category_name, priority, video_category_id  FROM '.$this->CFG['db']['tbl']['video_category'].
						' WHERE video_category_id='.$this->dbObj->Param('video_category_id').
						' AND parent_category_id='.$this->dbObj->Param('parent_category_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category_id'], $this->fields_arr['category_id']));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['sub_category'] = $row['video_category_name'];
						$this->fields_arr['priority'] = $row['priority'];
						$this->fields_arr['sub_category_id'] = $row['video_category_id'];
						return true;
					}
				return false;
			}

		/**
		 * VideoCategoryFormHandler::deleteSeletctedSubCategories()
		 *
		 * @return void
		 */
		public function deleteSeletctedSubCategories()
			{
				$category_id = $this->fields_arr['category_id'];
				$category_ids = $this->fields_arr['category_ids'];
				//Adjust priority order..
				$this->adjustPriorityOrder($category_id, '', 'video_category', 'video_category_id', 'delete', explode(',', $category_ids));

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['video_category'].
						' WHERE video_category_id  IN('.$this->fields_arr['category_ids'].')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET video_sub_category_id=0'.
						' WHERE video_sub_category_id IN('.$this->fields_arr['category_ids'].')';

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
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_category'].' SET '.
						'video_category_ext = '.$this->dbObj->Param($category_ext).' '.
						'WHERE video_category_id = '.$this->dbObj->Param($this->category_id);
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
//<<<<<<<--------------class VideoCategoryFormHandler---------------//
//--------------------Code begins-------------->>>>>//
$category = new VideoCategoryFormHandler();
$category->setPageBlockNames(array('form_create_category', 'form_create_sub_category', 'form_show_category', 'form_show_sub_category', 'form_confirm'));
$category->setMediaPath('../../');
$category->setAllPageBlocksHide();
//default form fields and values...
$category->resetFieldsArray();
$category->setFormField('prev_numpg',0);//To retain the last numpg
/***********set form field for navigation****/
$category->setFormField('asc', 'gc.video_category_name');
$category->setFormField('dsc', '');
$category->setFormField('priority', '');
$category->setFormField('sub_category_id', '');
$category->imageFormat=implode(',',$CFG['admin']['videos']['category_image_format_arr']);
//$category->setFormField('category_id', '');
/*************Start navigation******/
//fetch number of records show in the result--numpg
$condition = '';
//Set tables and fields to return
$category->setTableNames(array($CFG['db']['tbl']['video_category'].' as gc'));
$category->setReturnColumns(array('gc.video_category_id, gc.priority,gc.video_category_description, gc.video_category_name, gc.video_category_status, DATE_FORMAT(gc.date_added, \''.$CFG['format']['date'].'\') as date_added','video_category_ext','allow_post','video_category_type'));
$category->sanitizeFormInputs($_REQUEST);
/*************End navigation******/
if ($category->isFormGETed($_GET, 'category_id'))
	{
		$category->chkIsNotEmpty('category_id', $LANG['common_err_tip_required'])and
			$category->chkIsNumeric('category_id', $LANG['managevideocategory_err_tip_invalid_category_id'])and
				$category->isValidCategoryId('category_id', $LANG['managevideocategory_err_tip_invalid_category_id']);
		$category->getFormField('start')and
			$category->chkIsNumeric('start', $LANG['common_err_tip_required']);
		if ($category->isFormGETed($_GET, 'sub_category_id'))
			{
				$category->chkIsNotEmpty('sub_category_id', $LANG['common_err_tip_required'])and
								$category->chkIsNumeric('sub_category_id', $LANG['managevideocategory_err_tip_invalid_category_id'])and
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
						$category->setFormField('category_id', $category->category_details_arr['video_category_id']);
						$category->category_image = $category->media_relative_path.$CFG['admin']['videos']['category_folder'].$category->category_details_arr['video_category_id'].'.'.$category->category_details_arr['video_category_ext'];
						$category->setFormField('category', stripslashes($category->category_details_arr['video_category_name']));
						$category->setFormField('category_description', stripslashes($category->category_details_arr['video_category_description']));
						$category->setFormField('status', $category->category_details_arr['video_category_status']);
						$category->setFormField('allow_post', $category->category_details_arr['allow_post']);
						$category->setFormField('video_category_type', $category->category_details_arr['video_category_type']);
						$category->setFormField('priority', $category->category_details_arr['priority']);
					}
				if($category->getFormField('opt')=='subedit')
					{
						$category->category_image = $category->media_relative_path.$CFG['admin']['videos']['category_folder'].$category->getFormField('sub_category_id').'.'.$category->category_details_arr['video_category_ext'];
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
				$category->setCommonErrorMsg($LANG['managevideocategory_err_tip_select_category']);
			}
		if($category->isValidFormInputs())
			{
					switch($category->getFormField('action'))
						{
							case 'Delete':
								if(!$category->deleteSelectedCategories())
									{
										$category->setCommonErrorMsg($LANG['managevideocategory_err_tip_have_video']);
										$category->error = 1;
									}
								break;

							case 'Enable':
								$LANG['managevideocategory_success_message'] = $LANG['managevideocategory_success_enable_msg'];
								$category->changeStatus('Yes');
								break;

							case 'Disable':
								$LANG['managevideocategory_success_message'] = $LANG['managevideocategory_success_disable_msg'];
								$category->changeStatus('No');
								break;
						}
			}

		$category->setAllPageBlocksHide();
		if ($category->isValidFormInputs())
			{
				$category->setCommonSuccessMsg($LANG['managevideocategory_success_message']);
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
				$category->chkFileNameIsNotEmpty('sub_category_image', $LANG['common_err_tip_required']) and
					$category->chkValidFileType('sub_category_image',$LANG['common_err_tip_invalid_file_type']) and
					$category->chkValideFileSize('sub_category_image',$LANG['common_err_tip_invalid_file_size']) and
					$category->chkErrorInFile('sub_category_image',$LANG['common_err_tip_invalid_file']);
			}

		$category->chkIsNotEmpty('sub_category', $LANG['common_err_tip_required']);
		$category->chkIsNotEmpty('category_id', $LANG['common_err_tip_required']);
		$category->isValidFormInputs() and $category->chkIsDuplicateSubCategory($LANG['managevideocategory_already_exist']);
		if($category->getFormField('priority'))
			$category->chkIsNumeric('priority', $LANG['managevideocategory_err_tip_invalid_priority']);

		if($category->isValidFormInputs())
			{
				if ($category->isValidFormInputs())
					{
						$category->addSubCategory();
						if ($category->isValidFormInputs() && isset($_FILES['sub_category_image']['name']) && trim($_FILES['sub_category_image']['name']!=''))
							{
								$extern = strtolower(substr($_FILES['sub_category_image']['name'], strrpos($_FILES['sub_category_image']['name'], '.')+1));

								if (in_array($extern, $CFG['admin']['videos']['category_image_format_arr']))
									{
										if ($_FILES['sub_category_image']['size'] <= $CFG['admin']['videos']['category_image_max_size'] * 1024)
											{
												if (!$_FILES['sub_category_image']['error'])
													{
														$imageObj = new ImageHandler($_FILES['sub_category_image']['tmp_name']);
														$category->setIHObject($imageObj);
														$image_name = $category->subcategory_id;
														 $temp_dir = $category->media_relative_path.$CFG['admin']['videos']['category_folder'];

														$category->chkAndCreateFolder($temp_dir);
														$temp_file = $temp_dir.$image_name;
														$category->storeImagesTempServer($temp_file, $extern);
														$category->setFormField('category_image_ext', $extern);
														$category->updateCategoryImageExt($category->subcategory_id,$extern);

													}
											}
									}
							}
						$category->setFormField('sub_category', '');
						$category->setFormField('priority', '');
						//$category->setFormField('sub_category', 'priority');
						$LANG['managevideocategory_success_message'] = $LANG['managevideocategory_success_add_message'];
						$category->setCommonSuccessMsg($LANG['managevideocategory_success_message']);
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
				$category->isValidFormInputs() and $category->chkIsDuplicateSubCategoryForEdit($LANG['managevideocategory_already_exist']);
				if($category->getFormField('priority'))
					$category->chkIsNumeric('priority', $LANG['managevideocategory_err_tip_invalid_priority']);
				$category->isValidCategoryId('category_id', $LANG['managevideocategory_err_tip_invalid_category_id']);
				$category->isValidCategoryId('sub_category_id', $LANG['managevideocategory_err_tip_invalid_category_id']);

				if($category->isValidFormInputs())
					{
						$category->updateSubCategory();
						if ($category->isValidFormInputs() && isset($_FILES['sub_category_image']['name']) && trim($_FILES['sub_category_image']['name']!=''))
							{
								$extern = strtolower(substr($_FILES['sub_category_image']['name'], strrpos($_FILES['sub_category_image']['name'], '.')+1));

								if (in_array($extern, $CFG['admin']['videos']['category_image_format_arr']))
									{
										if ($_FILES['sub_category_image']['size'] <= $CFG['admin']['videos']['category_image_max_size'] * 1024)
											{
												if (!$_FILES['sub_category_image']['error'])
													{
														$imageObj = new ImageHandler($_FILES['sub_category_image']['tmp_name']);
														$category->setIHObject($imageObj);
														$image_name = $category->getFormField('sub_category_id');
														 $temp_dir = $category->media_relative_path.$CFG['admin']['videos']['category_folder'];

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
						$LANG['managevideocategory_success_message'] = $LANG['managevideocategory_success_edit_message'];
						$category->setCommonSuccessMsg($LANG['managevideocategory_success_message']);
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
			}
	}
else if($category->isFormPOSTed($_POST, 'confirm_actionSub'))
	{
		$category->deleteSeletctedSubCategories();
		$category->setCommonSuccessMsg($LANG['managevideocategory_success_message']);
		$category->setPageBlockShow('block_msg_form_success');
		$category->setPageBlockShow('form_create_sub_category');
	}
else if ($category->isFormPOSTed($_POST, 'category_submit'))
	{

		if(!$category->getFormField('category_id'))
			{
				$category->chkFileNameIsNotEmpty('category_image', $LANG['common_err_tip_required']) and
					$category->chkValidFileType('category_image',$LANG['common_err_tip_invalid_file_type']) and
					$category->chkValideFileSize('category_image',$LANG['common_err_tip_invalid_file_size']) and
					$category->chkErrorInFile('category_image',$LANG['common_err_tip_invalid_file']);
			}

		$category->chkIsNotEmpty('category', $LANG['common_err_tip_required'])and
			$category->chkCategoryExits('category', $LANG['managevideocategory_err_tip_alreay_exists']);
		$category->chkIsNotEmpty('status', $LANG['common_err_tip_required']);
		$category->chkIsNotEmpty('category_description', $LANG['common_err_tip_required']);

		$category->getFormField('category_id')and
			$category->chkIsNotEmpty('category_id', $LANG['common_err_tip_required'])and
				$category->chkIsNumeric('category_id', $LANG['managevideocategory_err_tip_invalid_category_id'])and
					$category->isValidCategoryId('category_id', $LANG['managevideocategory_err_tip_invalid_category_id']);

		if($category->getFormField('priority'))
			$category->chkIsNumeric('priority', $LANG['managevideocategory_err_tip_invalid_priority']);

		$category->isValidFormInputs()and
		$category->createCategory($CFG['db']['tbl']['video_category']);

		if ($category->isValidFormInputs() && isset($_FILES['category_image']['name']) && trim($_FILES['category_image']['name']!=''))
				{
					$extern = strtolower(substr($_FILES['category_image']['name'], strrpos($_FILES['category_image']['name'], '.')+1));

					if (in_array($extern, $CFG['admin']['videos']['category_image_format_arr']))
						{
							if ($_FILES['category_image']['size'] <= $CFG['admin']['videos']['category_image_max_size'] * 1024)
								{
									if (!$_FILES['category_image']['error'])
										{
											$imageObj = new ImageHandler($_FILES['category_image']['tmp_name']);
											$category->setIHObject($imageObj);
											$image_name = $category->category_id;
											$temp_dir = $category->media_relative_path.$CFG['admin']['videos']['category_folder'];

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
					$category->setCommonSuccessMsg($LANG['managevideocategory_success_edit_message']);
				else
					$category->setCommonSuccessMsg($LANG['managevideocategory_success_add_message']);

				$category->setPageBlockShow('block_msg_form_success');
				$category->resetFieldsArray();
			}
		else
			{
				$category->setAllPageBlocksHide();
				$category->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$category->setPageBlockShow('block_msg_form_error');
				$category->setFormField('category_id', $category->category_details_arr['video_category_id']);
			}
	}
else if($category->isFormPOSTed($_POST, 'category_cancel'))
	{
		$category->resetFieldsArray();
	}
if ($category->isFormPOSTed($_POST, 'sub_category_cancel'))
	{

		$url = $CFG['site']['url'].'admin/video/manageVideoCategory.php?category_id='.$category->getFormField('category_id').'&opt=sub';
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
		$category->checkSortQuery('gc.video_category_name', 'asc');
		$category->buildQuery();
		//$category->printQuery();
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
$category->left_navigation_div = 'videoMain';
//include the header file
$category->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'video');
$smartyObj->display('manageVideoCategory.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmSub');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
</script>
<?php
/* Added code to validate mandataory fields in video defaut settings page */
if ($CFG['feature']['jquery_validation'])
{
$allowed_image_formats=implode("|",  $CFG['admin']['videos']['category_image_format_arr']);
?>
<script type="text/javascript">
$Jq("#selCreateCategoryFrom").validate({
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
		isValidFileFormat: "<?php echo $category->LANG['common_err_tip_invalid_image_format']; ?>"
		},
		category_description: {
		required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		priority: {
		number: LANG_JS_NUMBER
		}
	}
});
</script>
<?php
}
$category->includeFooter();
?>