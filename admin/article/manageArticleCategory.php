<?php
/**
 * Manage Article Category
 *
 * This file is to manage article categories and subcategories
 *
 * @category	Rayzz
 * @package		admin
 **/
require_once('../../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'article';
$CFG['lang']['include_files'][] = 'languages/%s/article/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/admin/manageArticleCategory.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';;
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class ArticleCategoryFormHandler--------------->>>//
/**
 * @category	Rayzz
 * @package		Admin
 **/
class ArticleCategoryFormHandler extends ArticleHandler
	{
		public $category_details_arr;
		public $category_id;

		/**
		 * ArticleCategoryFormHandler::setIHObject()
		 *
		 * @param mixed $imObj
		 * @return void
		 */
		public function setIHObject($imObj)
			{
				$this->imageObj = $imObj;
			}

		/**
		 * ArticleCategoryFormHandler::buildConditionQuery()
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
		 * ArticleCategoryFormHandler::checkSortQuery()
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
		 * ArticleCategoryFormHandler::storeImagesTempServer()
		 *
		 * @param string $uploadUrl
		 * @param string $extern
		 * @return void
		 */
		public function storeImagesTempServer($uploadUrl, $extern)
			{
				//GET LARGE IMAGE
				@chmod($uploadUrl.'.'.$extern, 0777);
				if($this->CFG['admin']['articles']['category_height'] or $this->CFG['admin']['articles']['category_width'])
					{
						$this->imageObj->resize($this->CFG['admin']['articles']['category_width'], $this->CFG['admin']['articles']['category_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'.'.$extern, strtoupper($extern));
					}
				else
					{
						$this->imageObj->output_original($uploadUrl.'.'.$extern, strtoupper($extern));
					}
			}

		/**
		* ArticleCategoryFormHandler::updateCategoryImageExt()
		* To Update category image ext
		*
		* @param string $category_ext
		* @access public
		* @return void
		**/
		public function updateCategoryImageExt($categoryId,$category_ext)
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['article_category'].' SET '.
			'article_category_ext = '.$this->dbObj->Param('category_ext').' '.
			'WHERE article_category_id = '.$this->dbObj->Param('article_category_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($category_ext, $categoryId));
			if (!$rs)
			trigger_db_error($this->dbObj);
			return true;
		}

		/**
		* ArticleCategoryFormHandler::updateCategoryImageExt()
		*/
		public function setMediaPath($path='../../')
		{
			$this->media_relative_path = $path;
		}

		/**
		 * ArticleCategoryFormHandler::isValidCategoryId()
		 * To check the article_categroy id is valid or not
		 *
		 * @param Integer $category_id
		 * @param string $err_tip
		 * @return boolean
		 */
		public function isValidCategoryId($category_id, $err_tip='')
			{
				$sql = 'SELECT article_category_id, article_category_description,'.
						' article_category_name, article_category_type, article_category_status, date_added, allow_post, article_category_ext, priority'.
						' FROM '.$this->CFG['db']['tbl']['article_category'].
						' WHERE article_category_id = '.$this->dbObj->Param('category_id');

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
		* ArticleCategoryFormHandler::isValidCategoryId()
		* To check the article_categroy id is valid or not
		*
		* @param Integer $category_id
		* @param string $err_tip
		* @return boolean
		*/
		public function isValidSubCategoryId($category_id, $err_tip='')
		{
			$sql = 'SELECT article_category_id, article_category_description,'.' article_category_name, article_category_status, date_added, article_category_ext, priority'.
			' FROM '.$this->CFG['db']['tbl']['article_category'].' WHERE article_category_id = '.$this->dbObj->Param('category_id');
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

		/**
		 * ArticleCategoryFormHandler::chkArticleExists()
		 * To check if selected category have articles
		 *
		 * @param mixed $category_ids
		 * @return boolean
		 */
		public function chkArticleExists($category_ids)
			{
				$sql = 'SELECT count( g.article_id ) AS cat_count, article_category_id'.
						' FROM '.$this->CFG['db']['tbl']['article'].' g'.
						' WHERE article_category_id IN ( '.$category_ids.' )'.
						' AND article_status!=\'Deleted\''.
						' GROUP BY article_category_id';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					return true;
				return false;
			}

		/**
		 * ArticleCategoryFormHandler::deleteSelectedCategories()
		 * To delete the given category id
		 *
		 * @return boolean
		 */
		public function deleteSelectedCategories()
			{
				$category_ids = $this->fields_arr['category_ids'];
				if ($this->chkArticleExists($category_ids))
					{
						$this->setCommonErrorMsg($this->LANG['managearticlecategory_err_tip_have_article']);
						return false;
				    }
				$this->adjustPriorityOrder(0, '', 'article_category', 'article_category_id', 'delete', explode(',', $category_ids));
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['article_category'].' '.
						'WHERE article_category_id IN ('.$category_ids.') ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_db_error($this->dbObj);
				return true;

			}

		/**
		 * ArticleCategoryFormHandler::chkCategoryExists()
		 * To check if the category exists already
		 *
		 * @param string $category
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkCategoryExists($category, $err_tip='')
			{
				$sql = 'SELECT COUNT(article_category_id) AS count FROM '.$this->CFG['db']['tbl']['article_category'].' '.
						'WHERE UCASE(article_category_name) = '.$this->dbObj->Param('category_name').' AND parent_category_id =0';
				$fields_value_arr[] = strtoupper($this->fields_arr[$category]);
				if ($this->fields_arr['category_id'])
					{
						$sql .= ' AND article_category_id != '.$this->dbObj->Param('category_id');
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
		 * ArticleCategoryFormHandler::createCategory()
		 * To create/update article category
		 *
		 * @param string $category_table
		 * @return boolean
		 */
		public function createCategory($category_table)
			{
				$old_priority = $this->fields_arr['priority'];
				if ($this->fields_arr['category_id'])
					{
						$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'article_category', 'update', 0);
						$this->adjustPriorityOrder(0, $priority, 'article_category', 'article_category_id', 'update', $this->fields_arr['category_id']);
						$sql = 'UPDATE '.$category_table.' SET '.
								'article_category_name = '.$this->dbObj->Param('category_name').', '.
								'article_category_type = '.$this->dbObj->Param('category_type').', '.
								'article_category_description = '.$this->dbObj->Param('category_descrption').', '.
								'allow_post = '.$this->dbObj->Param('allow_post').', '.
								'article_category_status = '.$this->dbObj->Param('status').', '.
								'priority= '.$this->dbObj->Param('priority').' '.
								'WHERE article_category_id = '.$this->dbObj->Param('category_id');

						$fields_value_arr = array($this->fields_arr['category'],$this->fields_arr['article_category_type'],
												$this->fields_arr['category_description'],$this->fields_arr['allow_post'],
												$this->fields_arr['status'],
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
						$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'article_category', 'add', 0);
						$this->adjustPriorityOrder(0, $priority, 'article_category', 'article_category_id', 'add');
						$sql = 'INSERT INTO '.$category_table.' SET '.
								'article_category_name = '.$this->dbObj->Param('category_name').', '.
								'article_category_type = '.$this->dbObj->Param('category_type').', '.
								'article_category_description = '.$this->dbObj->Param('category_descrption').', '.
								'allow_post = '.$this->dbObj->Param('allow_post').', '.
								'article_category_status = '.$this->dbObj->Param('status').', '.
								'priority = '.$this->dbObj->Param('priority').', '.
								'date_added = now()';

						$fields_value_arr = array($this->fields_arr['category'],$this->fields_arr['article_category_type'],
													$this->fields_arr['category_description'],$this->fields_arr['allow_post'],
													$this->fields_arr['status'],
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
		 * ArticleCategoryFormHandler::getArticleCount()
		 * To get article count of the category
		 *
		 * @param Integer $category_id
		 * @return Integer
		 */
		public function getArticleCount($category_id)
			{
				$sql = 'SELECT count(g.article_id) as cat_count '.
						'FROM '.$this->CFG['db']['tbl']['article'].' as g '.
						'WHERE article_category_id = '.$this->dbObj->Param('category_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category_id));
				if (!$rs)
			        trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['cat_count'];
			}

		/**
		 * ArticleCategoryFormHandler::showCategories()
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
						$row['article_category_name'] =  wordWrap_mb_ManualWithSpace($row['article_category_name'], $this->CFG['admin']['articles']['member_article_category_name_length'], $this->CFG['admin']['articles']['member_article_category_name_total_length'], 0);
						$row['article_category_description'] = wordWrap_mb_ManualWithSpace($row['article_category_description'], $this->CFG['admin']['articles']['member_article_category_description_length'], $this->CFG['admin']['articles']['member_article_category_description_total_length'], 0);
						$showCategories_arr[$inc]['record'] = $row;
						$showCategories_arr[$inc]['checked'] = '';
						if((is_array($this->fields_arr['category_ids'])) && (in_array($row['article_category_id'], $this->fields_arr['category_ids'])))
							$showCategories_arr[$inc]['checked'] = "CHECKED";

						$inc++;
					}

				$smartyObj->assign('showCategories_arr', $showCategories_arr);
			}

		/**
		 * ArticleCategoryFormHandler::populateSubCategories()
		 *
		 * @return void
		 */
		public function populateSubCategories()
			{
				global $smartyObj;
				$populateSubCategories_arr = array();
				$sql = 'SELECT article_category_id, article_category_name, article_category_ext, date_added'.
						' FROM '.$this->CFG['db']['tbl']['article_category'].
						' WHERE parent_category_id='.$this->dbObj->Param('parent_category_id');

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
								$row['article_category_name'] = wordWrap_mb_ManualWithSpace($row['article_category_name'], $this->CFG['admin']['articles']['admin_article_category_name_length']);
								$populateSubCategories_arr['row'][$inc]['record'] = $row;
								$populateSubCategories_arr['row'][$inc]['checked'] = '';
								if((is_array($this->fields_arr['category_ids'])) && (in_array($row['article_category_id'], $this->fields_arr['category_ids'])))
									$populateSubCategories_arr['row'][$inc]['checked'] = "CHECKED";

								$inc++;
							}
					}
				$smartyObj->assign('populateSubCategories_arr', $populateSubCategories_arr);
			}

		/**
		 * ArticleCategoryFormHandler::checkValidFileType()
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
					if (!in_array($extern, $this->CFG['admin']['articles']['category_image_format_arr']))
						{
							$this->fields_err_tip_arr[$field_name] = $err_tip;
							return false;
						}
				}
				return true;
			}


		/**
		 * ArticleCategoryFormHandler::chkValideFileSize()
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
					$max_size = $this->CFG['admin']['articles']['category_image_max_size'] * 1024;
					if ($_FILES[$field_name]['size'] > $max_size)
						{
							$this->fields_err_tip_arr[$field_name] = $err_tip;
							return false;
						}
				}
				return true;
			}

		/**
		 * ArticleCategoryFormHandler::chkErrorInFile()
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
		 * ArticleCategoryFormHandler::resetFieldsArray()
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
				//$this->setFormField('category_image_ext', '');
				$this->setFormField('article_category_ext', '');
				$this->setFormField('priority', '');
				$this->setFormField('status', 'Yes');
				$this->setFormField('category_ids', array());
				$this->setFormField('action', '');
				$this->setFormField('article_category_type', 'General');
				$this->setFormField('allow_post', 'Yes');
				$this->setFormField('opt', '');
			}

		/**
		 * ArticleCategoryFormHandler::chkIsEditMode()
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
		 * ArticleCategoryFormHandler::chkIsEditModeSubCategory()
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
		 * ArticleCategoryFormHandler::changeStatus()
		 *
		 * @param string $status
		 * @return boolean
		 */
		public function changeStatus($status)
			{
				$category_ids = $this->fields_arr['category_ids'];

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['article_category'].' SET'.
						' article_category_status='.$this->dbObj->Param('article_category_status').
						' WHERE article_category_id IN('.$category_ids.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				return true;
			}

		/**
		 * ArticleCategoryFormHandler::chkIsDuplicateSubCategory()
		 *
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkIsDuplicateSubCategory($err_tip = '')
			{
				$sql = 'SELECT article_category_id FROM '.$this->CFG['db']['tbl']['article_category'].
						' WHERE article_category_name='.$this->dbObj->Param('article_category_name').
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
		 * ArticleCategoryFormHandler::chkIsDuplicateSubCategoryForEdit()
		 *
		 * @param string $err_tip
		 * @return boolean
		 */
		public function chkIsDuplicateSubCategoryForEdit($err_tip = '')
			{
				$sql = 'SELECT article_category_id FROM '.$this->CFG['db']['tbl']['article_category'].
						' WHERE article_category_name='.$this->dbObj->Param('article_category_name').
						' AND parent_category_id='.$this->dbObj->Param('parent_category_id').
						' AND article_category_id!='.$this->dbObj->Param('article_category_id');

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
		 * ArticleCategoryFormHandler::addSubCategory()
		 *
		 * @return void
		 */
		public function addSubCategory()
			{
				$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'article_category', 'add', $this->fields_arr['category_id']);
				$this->adjustPriorityOrder($this->fields_arr['category_id'], $priority, 'article_category', 'article_category_id', 'add');
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_category'].' SET'.
						' article_category_name='.$this->dbObj->Param('article_category_name').','.
						' parent_category_id='.$this->dbObj->Param('parent_category_id').','.
						' priority='.$this->dbObj->Param('priority').','.
						' article_category_status=\'Yes\','.
						' date_added=NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category'], $this->fields_arr['category_id'], $priority));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$this->subcategory_id = $this->dbObj->Insert_ID();
			}

		/**
		 * ArticleCategoryFormHandler::updateSubCategory()
		 *
		 * @return void
		 */
		public function updateSubCategory()
			{
				$priority = $this->getPriorityOrder($this->fields_arr['priority'], 'article_category', 'update', $this->fields_arr['category_id']);
				$this->adjustPriorityOrder($this->fields_arr['category_id'], $priority, 'article_category', 'article_category_id', 'update', $this->fields_arr['category_id']);
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['article_category'].' SET'.
						' article_category_name='.$this->dbObj->Param('article_category_name').', '.
						' priority='.$this->dbObj->Param('priority').' WHERE'.
						' article_category_id='.$this->dbObj->Param('article_category_id').' AND'.
						' parent_category_id='.$this->dbObj->Param('parent_category_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category'], $priority, $this->fields_arr['sub_category_id'], $this->fields_arr['category_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * ArticleCategoryFormHandler::populateSubCategory()
		 *
		 * @return boolean
		 */
		public function populateSubCategory()
			{
				$sql = 'SELECT article_category_name, priority, article_category_id, article_category_ext FROM '.$this->CFG['db']['tbl']['article_category'].
						' WHERE article_category_id='.$this->dbObj->Param('article_category_id').
						' AND parent_category_id='.$this->dbObj->Param('parent_category_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['sub_category_id'], $this->fields_arr['category_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['sub_category'] = $row['article_category_name'];
						$this->fields_arr['priority'] = $row['priority'];
						$this->fields_arr['sub_category_id'] = $row['article_category_id'];
						$this->fields_arr['article_category_ext'] = $row['article_category_ext'];
						return true;
					}
				return false;
			}

		/**
		 * ArticleCategoryFormHandler::deleteSeletctedSubCategories()
		 *
		 * @return void
		 */
		public function deleteSeletctedSubCategories()
			{
				$category_id = $this->fields_arr['category_id'];
				$category_ids = $this->fields_arr['category_ids'];
				$this->adjustPriorityOrder($category_id, '', 'article_category', 'article_category_id', 'delete', explode(',', $category_ids));
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['article_category'].
						' WHERE article_category_id  IN('.$this->fields_arr['category_ids'].')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET article_sub_category_id=0'.
						' WHERE article_sub_category_id IN('.$this->fields_arr['category_ids'].')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * ArticleCategoryFormHandler::deleteSubCategoryImage()
		 * @param integer $article_category_id
		 * @return null
		 */
		public function deleteCategoryImage($article_category_id)
			{
			    //Get the extension for the image to be deleted
				$article_category = $this->getCategoryDetail($article_category_id);

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['article_category'].' SET '.
						' article_category_ext =\'\''.
						' WHERE article_category_id = '.$this->dbObj->Param('article_category_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($article_category_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$affected = $this->dbObj->Affected_Rows();
				if($affected>0)
					{
						@unlink($this->media_relative_path.$this->CFG['admin']['articles']['category_folder'].$article_category_id.'.'.$article_category['article_category_ext']);
					}
			}

		/**
		* ArticleCategoryFormHandler::getCategoryDetail()
		* @param integer $category_id, boolean $parent_id
		* @return string category name
		*/
		public function getCategoryDetail($article_category_id='', $parent_id='')
			{
			    $cond = '';
			    if($parent_id)
					{
						$cond = ' AND parent_category_id =0';
					}

				$sql = 'SELECT article_category_name,	article_category_ext'.
						' FROM '.$this->CFG['db']['tbl']['article_category'].
						' WHERE article_category_id='.$this->dbObj->Param('article_category_id').$cond;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($article_category_id));
				if (!$rs)
				trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
					{
						$this->setFormField('category_name', $row['article_category_name']);
						return $row;
					}
				 return true;

			}

	   /**
		* ArticleCategoryFormHandler::getLastPriority()
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
		* ArticleCategoryFormHandler::getPriorityOrder()
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
		* ArticleCategoryFormHandler::adjustPriorityOrder()
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
						'WHERE '.$field_name.' = '.$this->dbObj->Param('field_name').$condition;
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
						'WHERE priority > '.$this->dbObj->Param('priority').$condition;
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($current_priority));
						if (!$rs)
						trigger_db_error($this->dbObj);
						while($resultSet = $rs->FetchRow())
							{
								$value = $resultSet[$field_name];
								$sql = 'UPDATE '.$this->CFG['db']['tbl'][$table].' SET '.
								'priority ='.$current_priority.' WHERE '.$field_name.' = '.$this->dbObj->Param('field_name').$condition;
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

	}
//<<<<<<<--------------class ArticleCategoryFormHandler---------------//

//--------------------Code begins-------------->>>>>//
$category = new ArticleCategoryFormHandler();
$category->setPageBlockNames(array('form_create_category', 'form_create_sub_category', 'form_show_category', 'form_show_sub_category', 'form_confirm'));
$category->setMediaPath('../../');
$category->setAllPageBlocksHide();
//default form fields and values...
$category->resetFieldsArray();

$category->setFormField('prev_numpg',0);//To retain the last numpg
/***********set form field for navigation****/
$category->setFormField('asc', 'gc.article_category_name');
$category->setFormField('dsc', '');
$category->setFormField('msg', '');
$category->imageFormat=implode(', ',$CFG['admin']['articles']['category_image_format_arr']);
$category->left_navigation_div = 'articleMain';
/*************Start navigation******/
//fetch number of records show in the result--numpg
$condition = '';

//Set tables and fields to return
$category->setTableNames(array($CFG['db']['tbl']['article_category'].' as gc'));
$category->setReturnColumns(array('gc.article_category_id, gc.article_category_description, gc.article_category_name, gc.article_category_type, gc.allow_post, gc.article_category_status, gc.article_category_ext, gc.priority, DATE_FORMAT(gc.date_added, \''.$CFG['format']['date'].'\') as date_added'));

$category->sanitizeFormInputs($_REQUEST);
/*************End navigation******/
if ($category->isFormGETed($_GET, 'category_id'))
	{
		$category->chkIsNotEmpty('category_id', $LANG['common_err_tip_required'])and
			$category->chkIsNumeric('category_id', $LANG['managearticlecategory_err_tip_invalid_category_id'])and
				$category->isValidCategoryId('category_id', $LANG['managearticlecategory_err_tip_invalid_category_id']);
		$category->getFormField('start')and
			$category->chkIsNumeric('start', $LANG['common_err_tip_required']);
			if ($category->isFormGETed($_GET, 'sub_category_id'))
			{
				$category->chkIsNotEmpty('sub_category_id', $LANG['common_err_tip_required'])and
				$category->chkIsNumeric('sub_category_id', $LANG['managearticlecategory_err_tip_invalid_category_id'])and
				$category->isValidSubCategoryId('sub_category_id', $LANG['common_err_tip_required']);
			}
		if ($category->isValidFormInputs())
			{
				if($category->getFormField('opt')=='sub' && $CFG['admin']['articles']['sub_category'])
					{
						$category->setAllPageBlocksHide();
						$category->setPageBlockShow('form_create_sub_category');
					}
				else
					{
						$category->getFormField('sub_category_id', '');
						$category->setAllPageBlocksHide();
						$category->setFormField('category_id', $category->category_details_arr['article_category_id']);
						$image_extern=$category->category_details_arr['article_category_ext'];
						$category->category_image_ext_article = $category->category_details_arr['article_category_ext'];
						$category->category_tmp_article_image = $category->media_relative_path.$CFG['admin']['articles']['category_folder'].$CFG['admin']['articles']['article_no_image'];
						$category->category_image = $category->media_relative_path.$CFG['admin']['articles']['category_folder'].$category->category_details_arr['article_category_id'].'.'.$category->category_details_arr['article_category_ext'];
						$category->setFormField('category', stripslashes($category->category_details_arr['article_category_name']));
						$category->setFormField('category_description', stripslashes($category->category_details_arr['article_category_description']));
						$category->setFormField('allow_post', $category->category_details_arr['allow_post']);
						$category->setFormField('article_category_type', $category->category_details_arr['article_category_type']);
						$category->setFormField('status', $category->category_details_arr['article_category_status']);
						$category->setFormField('priority', $category->category_details_arr['priority']);
						$category->setFormField('article_category_ext', $category->category_details_arr['article_category_ext']);
					}
					if($category->getFormField('opt')=='subedit')
					{
						$category->category_image = $category->media_relative_path.$CFG['admin']['articles']['category_folder'].$category->getFormField('sub_category_id').'.'.$category->category_details_arr['article_category_ext'];
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
			$category->setCommonErrorMsg($LANG['managearticlecategory_err_tip_select_category']);
		}

		if($category->isValidFormInputs())
			{
				switch($category->getFormField('action'))
					{
						case 'Delete':
							if(!$category->deleteSelectedCategories())
							 {
								$category->setCommonErrorMsg($LANG['managearticlecategory_err_tip_have_article']);
								$category->error = 1;
							 }
							break;

						case 'Enable':
							$LANG['managearticlecategory_success_message'] = $LANG['managearticlecategory_success_enable_msg'];
							$category->changeStatus('Yes');
							break;

						case 'Disable':
							$LANG['managearticlecategory_success_message'] = $LANG['managearticlecategory_success_disable_msg'];
							$category->changeStatus('No');
							break;

					}
			}

			if($category->getFormField('action')=='delete_category_image')
			{
				$category->getFormField('category_id');
				$category->deleteCategoryImage($category->getFormField('category_id'));
				$category->setCommonSuccessMsg($LANG['managearticlecategory_image_success_delete_message']);
				$category->setPageBlockShow('block_msg_form_success');
				$category->setPageBlockShow('form_create_category');
				$url = getCurrentUrl(true).'&msg=success';
				Redirect2URL($url);
			}

		$category->setAllPageBlocksHide();
		if ($category->isValidFormInputs())
			{
				$category->setCommonSuccessMsg($LANG['managearticlecategory_success_message']);
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
if ($category->isFormPOSTed($_POST, 'sub_category_submit') && $CFG['admin']['articles']['sub_category'])
	{
		if(!$category->getFormField('sub_category_id'))
		{
			$category->checkValidFileType('sub_category_image', $CFG['admin']['articles']['category_image_format_arr'], $LANG['common_err_tip_invalid_file_type']) and
			$category->chkValideFileSize('sub_category_image',$LANG['common_err_tip_invalid_file_size']) and
			$category->chkErrorInFile('sub_category_image',$LANG['common_err_tip_invalid_file']);
		}
		$category->chkIsNotEmpty('sub_category', $LANG['common_err_tip_required']);
		$category->chkIsNotEmpty('category_id', $LANG['common_err_tip_required']);
		$category->isValidFormInputs() and $category->chkIsDuplicateSubCategory($LANG['managearticlesubcategory_err_tip_alreay_exists']);
		if($category->getFormField('priority'))
			$category->chkIsNumeric('priority', $LANG['managearticlecategory_err_tip_invalid_priority']);
		if($category->isValidFormInputs())
			{
				if ($category->isValidFormInputs())
					{
						$category->addSubCategory();
						if ($category->isValidFormInputs() && isset($_FILES['sub_category_image']['name']) && trim($_FILES['sub_category_image']['name']!=''))
						{
							$extern = strtolower(substr($_FILES['sub_category_image']['name'], strrpos($_FILES['sub_category_image']['name'], '.')+1));
							if (in_array($extern, $CFG['admin']['articles']['category_image_format_arr']))
							{
								if ($_FILES['sub_category_image']['size'] <= $CFG['admin']['articles']['category_image_max_size'] * 1024)
								{
									if (!$_FILES['sub_category_image']['error'])
									{
										$imageObj = new ImageHandler($_FILES['sub_category_image']['tmp_name']);
										$category->setIHObject($imageObj);
										$image_name = $category->subcategory_id;
										$temp_dir = $category->media_relative_path.$CFG['admin']['articles']['category_folder'];
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
						$category->setFormField('article_category_ext', $category->category_details_arr['article_category_ext']);
						$LANG['managearticlecategory_success_message'] = $LANG['managearticlecategory_success_add_message'];
						$category->setCommonSuccessMsg($LANG['managearticlecategory_success_message']);
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
				$category->checkValidFileType('sub_category_image', $CFG['admin']['articles']['category_image_format_arr'], $LANG['common_err_tip_invalid_file_type']) and
				$category->chkValideFileSize('sub_category_image',$LANG['common_err_tip_invalid_file_size']) and
				$category->chkErrorInFile('sub_category_image',$LANG['common_err_tip_invalid_file']);
				$category->isValidFormInputs() and $category->chkIsDuplicateSubCategoryForEdit($LANG['managearticlesubcategory_err_tip_alreay_exists']);
				if($category->getFormField('priority'))
					$category->chkIsNumeric('priority', $LANG['managearticlecategory_err_tip_invalid_priority']);
				$category->isValidCategoryId('category_id', $LANG['managearticlecategory_err_tip_invalid_category_id']);
				$category->isValidCategoryId('sub_category_id', $LANG['managearticlecategory_err_tip_invalid_category_id']);
				if($category->isValidFormInputs())
					{
						$category->updateSubCategory();
						if ($category->isValidFormInputs() && isset($_FILES['sub_category_image']['name']) && trim($_FILES['sub_category_image']['name']!=''))
						{
							$extern = strtolower(substr($_FILES['sub_category_image']['name'], strrpos($_FILES['sub_category_image']['name'], '.')+1));
							if (in_array($extern, $CFG['admin']['articles']['category_image_format_arr']))
							{
								if ($_FILES['sub_category_image']['size'] <= $CFG['admin']['articles']['category_image_max_size'] * 1024)
								{
									if (!$_FILES['sub_category_image']['error'])
									{
										$imageObj = new ImageHandler($_FILES['sub_category_image']['tmp_name']);
										$category->setIHObject($imageObj);
										$image_name = $category->getFormField('sub_category_id');
										$temp_dir = $category->media_relative_path.$CFG['admin']['articles']['category_folder'];
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
						$LANG['managearticlecategory_success_message'] = $LANG['managearticlecategory_success_edit_message'];
						$category->setCommonSuccessMsg($LANG['managearticlecategory_success_message']);
						$category->setPageBlockShow('block_msg_form_success');
						$category->setPageBlockShow('form_create_sub_category');
						//$url = $CFG['site']['url'].'admin/article/manageArticleCategory.php?category_id='.$category->getFormField('category_id').'&opt=sub';
						//Redirect2URL($url);
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
				$category->sub_category_image = $category->media_relative_path.$CFG['admin']['articles']['category_folder'].$category->getFormField('sub_category_id').'.'.$category->getFormField('article_category_ext');
				//Condition to delete the subcategory image
				if($category->getFormField('action')=='delete_subcategory_image')
	    			{
						$category->deleteCategoryImage($category->getFormField('sub_category_id'));
						$category->setCommonSuccessMsg($LANG['managearticlecategory_image_success_delete_message']);
						$category->setPageBlockShow('block_msg_form_success');
						$category->setPageBlockShow('form_create_sub_category');
						$url = getCurrentUrl(true).'&msg=success';
						Redirect2URL($url);
	    			}
	    		if($category->getFormField('msg')=='success')
					{
						$category->setCommonSuccessMsg($LANG['managearticlecategory_image_delete_success_message']);
						$category->setPageBlockShow('block_msg_form_success');
					}
			}
	}
else if($category->isFormPOSTed($_POST, 'confirm_actionSub') && $CFG['admin']['articles']['sub_category'])
	{
		$category->deleteSeletctedSubCategories();
		$category->setCommonSuccessMsg($LANG['managearticlecategory_success_message']);
		$category->setPageBlockShow('block_msg_form_success');
		$category->setPageBlockShow('form_create_sub_category');
	}
else if ($category->isFormPOSTed($_POST, 'category_submit'))
	{
		if(!$category->getFormField('category_id') || isset($_FILES['category_image']['name']) && trim($_FILES['category_image']['name']!=''))
		{
			$category->checkValidFileType('category_image', $CFG['admin']['articles']['category_image_format_arr'], $LANG['common_err_tip_invalid_file_type']) and
			$category->chkValideFileSize('category_image',$LANG['common_err_tip_invalid_file_size']) and
			$category->chkErrorInFile('category_image',$LANG['common_err_tip_invalid_file']);
		}
		$category->chkIsNotEmpty('category', $LANG['common_err_tip_required'])and
			$category->chkCategoryExists('category', $LANG['managearticlecategory_err_tip_alreay_exists']);
		$category->chkIsNotEmpty('status', $LANG['common_err_tip_required']);
		$category->chkIsNotEmpty('category_description', $LANG['common_err_tip_required']);

		$category->getFormField('category_id')and
			$category->chkIsNotEmpty('category_id', $LANG['common_err_tip_required'])and
				$category->chkIsNumeric('category_id', $LANG['managearticlecategory_err_tip_invalid_category_id'])and
					$category->isValidCategoryId('category_id', $LANG['managearticlecategory_err_tip_invalid_category_id']);

		if($category->getFormField('priority'))
			$category->chkIsNumeric('priority', $LANG['managearticlecategory_err_tip_invalid_priority']);

		$category->isValidFormInputs()and
			$category->createCategory($CFG['db']['tbl']['article_category']);

		if ($category->isValidFormInputs() && isset($_FILES['category_image']['name']) && trim($_FILES['category_image']['name']!=''))
		{
			$extern = strtolower(substr($_FILES['category_image']['name'], strrpos($_FILES['category_image']['name'], '.')+1));
			if (in_array($extern, $CFG['admin']['articles']['category_image_format_arr']))
			{
				if ($_FILES['category_image']['size'] <= $CFG['admin']['articles']['category_image_max_size'] * 1024)
				{
					if (!$_FILES['category_image']['error'])
					{
						$imageObj = new ImageHandler($_FILES['category_image']['tmp_name']);
						$category->setIHObject($imageObj);
						$image_name = $category->category_id;
						$temp_dir = $category->media_relative_path.$CFG['admin']['articles']['category_folder'];
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
					$category->setCommonSuccessMsg($LANG['managearticlecategory_success_edit_message']);
				else
					$category->setCommonSuccessMsg($LANG['managearticlecategory_success_add_message']);

				$category->setPageBlockShow('block_msg_form_success');
				$category->resetFieldsArray();
			}
		else
			{
				$category->setAllPageBlocksHide();
				$category->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$category->setPageBlockShow('block_msg_form_error');
				$category->setFormField('category_id', $category->category_details_arr['article_category_id']);
			}
	}
else if($category->isFormPOSTed($_POST, 'category_cancel'))
	{
		$category->resetFieldsArray();
	}

if ($category->isFormPOSTed($_POST, 'sub_category_cancel'))
{
	$url = $CFG['site']['url'].'admin/article/manageArticleCategory.php?category_id='.$category->getFormField('category_id').'&opt=sub';
	$category->resetFieldsArray();
	Redirect2URL($url);
}

if($category->getFormField('msg')=='success' && !$category->getFormField('sub_category_id'))
{
	$category->setCommonSuccessMsg($LANG['managearticlecategory_image_delete_success_message']);
	$category->setPageBlockShow('block_msg_form_success');
}


/*************Start navigation******/
if (!$category->isShowPageBlock('form_create_sub_category'))
	{
		$category->setTableNames(array($CFG['db']['tbl']['article_category'].' as gc'));
		$category->setReturnColumns(array('gc.article_category_id, gc.article_category_description, gc.article_category_name, gc.article_category_type, gc.article_category_status, DATE_FORMAT(gc.date_added, \''.$CFG['format']['date'].'\') as date_added'));
		//Condition of the query
		$condition = 'parent_category_id=0';
		$category->buildSelectQuery();
		$category->buildConditionQuery($condition);
		$category->buildSortQuery();
		$category->checkSortQuery('gc.article_category_name', 'asc');
		$category->buildQuery();
		//$category->printQuery();
		$category->executeQuery();
		/*************End navigation******/
		$category->setPageBlockShow('form_create_category');
		$category->setPageBlockShow('form_show_category');
	}

//<<<<--------------------Code Ends----------------------//
$category->hidden_arr1 = array('start');
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

//include the header file
$category->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'article');
$smartyObj->display('manageArticleCategory.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
//Added jquery validation for required fileds in article category and subcategory
if($CFG['feature']['jquery_validation'])
{
	$allowed_image_formats = implode("|", $CFG['admin']['articles']['category_image_format_arr']);
	if ($category->isShowPageBlock('form_create_category'))
		{
?>
		<script type="text/javascript">
		$Jq("#frmSelCreateCategory").validate({
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
	elseif($category->isShowPageBlock('form_create_sub_category'))
	{
?>
	<script type="text/javascript">
		$Jq("#frmSelCreateSubCategory").validate({
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
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
</script>
<?php
$category->includeFooter();
?>