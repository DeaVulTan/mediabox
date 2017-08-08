<?php
/**
 * List edit members
 *
 * PHP version 5.0
 *
 * @category	Discuzz
 * @package		SolutionsFormHandler
 * @author 		shankar_76ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:
 * @since 		2008-12-23
 * @filesource
 **/
require_once('../../common/configs/config.inc.php'); //configurations

$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/admin/manageSolutions.php';
$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/email_notify.inc.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';

$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_DiscussionHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_DiscussionsActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';

if ($_POST)
	$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['site']['is_module_page']='discussions';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require_once($CFG['site']['project_path'] . 'common/application_top.inc.php');
//------------------- Class SolutionsFormHandler Begins ------->>>>>//
class SolutionsFormHandler extends DiscussionHandler
	{
		/**
		 * @var object $current_user_id Current user id
		 */
		private $current_user_id;
		public $solution_attachment_count = 0;
		public $discussion_details = array();
		public $category_titles;
		/**
		 * SolutionsFormHandler::ConditionQueryNo Search()
		 *
		 * @return 		void
		 * @access		public
		**/
		public function ConditionQueryNoSearch()
			{
				$this->sql_condition .= ' b.user_id=u.'.$this->getUserTableField('user_id').' AND  u.'.$this->getUserTableField('user_status').' = \'Ok\' ';
				if($this->fields_arr['did'] != '')
					$this->sql_condition .= ' AND b.discussion_id='.$this->fields_arr['did'];

			}

		public function addSlashForPercentageOnly($value)
			{
				//$value = 'demo % ';'%%%';'% %%';%demo%';
				$value_rep = addslashes($value);
				$search_value = trim($value_rep);
				$str_arr = str_split($search_value);
				$percentage_avail = false;
				$slashed_value = '';
				foreach($str_arr as $str_val)
					{
						if($str_val == '%')
							{
								$percentage_avail = true;
								$slashed_value .= '\\'.$str_val;
							}
						else
							$slashed_value .= $str_val;
					}

				if($percentage_avail)
					return $slashed_value;

				return $value_rep;
			}
		/**
		 * SolutionsFormHandler::ConditionQuery()
		 *
		 * @param       string $table
		 * @return 		void
		 * @access		public
		**/
		public function ConditionQuery()
			{
				$this->sql_condition = 'b.user_id=u.'.$this->getUserTableField('user_id').' AND  u.'.$this->getUserTableField('user_status').' = \'Ok\' AND b.discussion_id='.$this->fields_arr['did'];
				$and = 1;
				if($this->fields_arr['search_name'])
					{
						$search_array = array();
						if (strlen($this->getFormField('search_name')) > 1)
			                $search_array = $this->filterWordsForSearching($this->getFormField('search_name'));
			            if ($search_array) {
				            $where_search = '';
				            foreach($search_array as $word_key => $word) {
				                $word = trim($word);
				                if ($word AND strlen($word) > 1)
				                    $where_search .= getSearchBoardExpressionQuery($word, 'b.search_word') .' OR EXISTS(SELECT 1 FROM '.$this->CFG['db']['tbl']['solutions'].' AS s WHERE s.board_id = b.board_id AND '.
													 getSearchBoardExpressionQuery($word, 's.search_word') .') OR';
				            }
				            if ($where_search != '') {
				                $where_search = substr($where_search, 0, strlen($where_search)-2);
				                $where_search = ' (' . $where_search . ')';
				            }
				        }
						if($this->fields_arr['search_cat'] == 1)
							{
								if($and == 1)
									$this->sql_condition .= ' AND ';
								$this->sql_condition .=  ' '.$this->getUserTableField('display_name').' LIKE \'%'.$this->addSlashForPercentageOnly($this->fields_arr['search_name']).'%\'';
								$and = 1;
							}
						elseif($this->fields_arr['search_cat'] == 2)
							{
								if($and == 1)
									$this->sql_condition .= ' AND ';
								$this->sql_condition .=  ' '.$this->getUserTableField('email').' like \'%'.addslashes($this->fields_arr['search_name']).'%\'';
								$and = 1;
							}
						elseif($this->fields_arr['search_cat'] == 3)//open boards
							{
								if($and == 1)
									$this->sql_condition .= ' AND ';
								$this->sql_condition .=  ' status = \'Active\' AND '.$where_search;
								$and = 1;
							}
						elseif($this->fields_arr['search_cat'] == 4)//resloved boards
							{
								if($and == 1)
									$this->sql_condition .= ' AND ';
								$this->sql_condition .=  ' (b.status IN(\'Inactive\')) AND '.$where_search;
								$and = 1;
							}
						elseif($this->fields_arr['search_cat'] == 5)//blocked boards
							{
								if($and == 1)
									$this->sql_condition .= ' AND ';
								$this->sql_condition .=  ' status = \'Blocked\' AND '.$where_search;
								$and = 1;
							}
						elseif($this->fields_arr['search_cat'] == 6)//board
							{
								if($and == 1)
									$this->sql_condition .= ' AND ';
								$this->sql_condition .=  $where_search;
								$and = 1;
							}
						elseif($this->fields_arr['search_cat'] == 8)//categories
							{
								if($and == 1)
									$this->sql_condition .= ' AND ';
								$this->sql_condition .= $this->getCatIds($this->fields_arr['search_name']);
								$and = 1;
							}
						elseif($this->fields_arr['search_cat'] == 11)//boards with best asnswer
							{
								if($and == 1)
									$this->sql_condition .= ' AND ';
								$this->sql_condition .=  ' best_solution_id!=0 AND '.getSearchRegularExpressionQuery($this->fields_arr['search_name'], 'board');
								$and = 1;
							}
						elseif($this->fields_arr['search_cat'] == 12)//Unpublished boards
							{
								if($and == 1)
									$this->sql_condition .= ' AND ';
								$this->sql_condition .=  ' status = \'ToActivate\' AND '.getSearchRegularExpressionQuery($this->fields_arr['search_name'], 'board');
								$and = 1;
							}
						elseif($this->fields_arr['search_cat'] == 13)//boards with featured
							{
								if($and == 1)
									$this->sql_condition .= ' AND ';
								$this->sql_condition .=  ' b.featured = \'Yes\' AND '.getSearchRegularExpressionQuery($this->fields_arr['search_name'], 'board');
								$and = 1;
							}
					}
				elseif($this->fields_arr['search_cat'] == 3)//open boards
					{
						if($and == 1)
							$this->sql_condition .= ' AND ';
						$this->sql_condition .=  ' (b.status = \'Active\')';
						$and = 1;
					}
				elseif($this->fields_arr['search_cat'] == 4)//resloved boards
					{
						if($and == 1)
							$this->sql_condition .= ' AND ';
						$this->sql_condition .=  ' (b.status IN(\'Inactive\'))';
						$and = 1;
					}
				elseif($this->fields_arr['search_cat'] == 5)//blocked boards
					{
						if($and == 1)
							$this->sql_condition .= ' AND ';
						$this->sql_condition .=  ' status = \'Blocked\'';
						$and = 1;
					}
				elseif($this->fields_arr['search_cat'] == 11)//boards with best asnswer
					{
						if($and == 1)
							$this->sql_condition .= ' AND ';
						$this->sql_condition .=  ' best_solution_id!=0';
						$and = 1;
					}
				elseif($this->fields_arr['search_cat'] == 12)//Unpublished boards
					{
						if($and == 1)
							$this->sql_condition .= ' AND ';
						$this->sql_condition .=  ' (b.status = \'ToActivate\')';
						$and = 1;
					}
				elseif($this->fields_arr['search_cat'] == 13)//boards with featured
					{
						if($and == 1)
							$this->sql_condition .= ' AND ';
						$this->sql_condition .=  ' (b.featured = \'Yes\')';
						$and = 1;
					}
			}

		/**
		 * To build sorting query
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function buildSortQuery()
			{
				$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}

		public function isValidDiscussionId($discussion_id, $err_tip='')
			{
				$this->chkIsNotEmpty('did', $this->LANG['err_tip_compulsory']);
				if (!$this->isValidFormInputs())
					{
						$this->setCommonErrorMsg($this->LANG['err_tip_invalid_question']);
						return false;
					}

				$sql = 'SELECT d.discussion_id, d.discussion_title, d.pcat_id, d.cat_id, d.description, d.visible_to, d.publish_status, d.redirect_link'.
						', TIMEDIFF(NOW(), date_added) as date_asked, '.$this->getUserTableField('display_name').' AS asked_by'.
						', u.'.$this->getUserTableField('user_id').' as img_user_id, '.$this->getUserTableField('name').' AS name, d.status, d.user_id'.
						', d.seo_title FROM '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE d.user_id=u.'.$this->getUserTableField('user_id').
						' AND u.'.$this->getUserTableField('user_status').'=\'Ok\''.
						' AND d.discussion_id ='.$this->dbObj->Param('discussion_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($discussion_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					{
						$this->setCommonErrorMsg($this->LANG['err_tip_invalid_question']);
						return false;
					}
				$this->discussion_details = $rs->FetchRow();
				if($this->discussion_details['redirect_link']!='')
					{
						Redirect2URL($this->discussion_details['redirect_link']);
					}
				$this->discussion_details['discussion_title'] = stripString($this->discussion_details['discussion_title'], $this->CFG['admin']['board']['tiny_length']);
				$this->fields_arr['did'] = $this->discussion_details['discussion_id'];
				$this->fields_arr['seo_title'] = $this->discussion_details['seo_title'];
				$this->getCategoryTitles($this->discussion_details['pcat_id']);
				$this->category_titles = array_reverse($this->category_titles);
				return true;

			}
		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getCategoryTitles($cat_id)
			{
				$sql = 'SELECT cat_id, cat_name, seo_title, parent_id FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE cat_id = '.$this->dbObj->Param($cat_id).
						' AND status = \'Active\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$category_info = array();
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$category_info['cat_name'] = $row['cat_name'];
						$category_info['cat_url'] = '<a href="discussions.php?cat='.$row['cat_id'].'">'.$row['cat_name'].'</a>';
						$this->category_titles[] = $category_info;
						if($row['parent_id'] > 0)
							$this->getCategoryTitles($row['parent_id']);
					}
			}
		/**
		 * SolutionsFormHandler::chkIsValidBoard()
		 *
		 * @return
		 */
		public function chkIsValidBoard()
		    {
				$this->chkIsNotEmpty('bid', $this->LANG['err_tip_compulsory']);
				if (!$this->isValidFormInputs())
					{
						$this->setCommonErrorMsg($this->LANG['err_tip_invalid_board_id']);
						return false;
					}
				//Query to display recent and popular boards
				$sql = 'SELECT b.board_id, b.total_solutions, b.publish_status, b.readonly, b.tags, b.visible_to, b.featured, b.best_solution_id, b.seo_title, b.redirect_link'.
						', b.description, b.total_stars, b.board, TIMEDIFF(NOW(), board_added) as board_added'.
						', '.$this->getUserTableField('display_name').' AS asked_by, '.$this->getUserTableField('name').' AS name, b.status, b.user_id, b.seo_title'.
						' FROM '.$this->CFG['db']['tbl']['boards'].' AS b, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE b.user_id=u.'.$this->getUserTableField('user_id').' AND b.status IN (\'Active\', \'Inactive\', \'ToActivate\', \'Blocked\')'.
						' AND u.'.$this->getUserTableField('user_status').'=\'Ok\' AND b.board_id='.$this->dbObj->Param('bid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					{
						$this->setCommonErrorMsg($this->LANG['err_tip_invalid_board_id']);
						return false;
					}
				$this->board_details = $rs->FetchRow();

				return true;
		    }

		/**
		 * SolutionsFormHandler::chkIsBoardExists()
		 *
		 * @param mixed $field
		 * @param string $err_tip
		 * @return
		 */
		public function chkIsBoardExists($field, $err_tip='')
		    {
				$sql = 'SELECT board_id FROM '.$this->CFG['db']['tbl']['boards'].
						' WHERE board LIKE '.$this->dbObj->Param('board');
				if ($this->fields_arr['bid'])
					$sql .= ' AND board_id != \''.addslashes($this->fields_arr['bid']).'\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$field]));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					return true;
				$this->setCommonErrorMsg($err_tip);
				$this->setFormFieldErrorTip($field, $err_tip);
				return false;
		    }

		public function addBoard()
		    {
				$this->setFormField('seo_title', $this->getSeoTitleForBoard($this->fields_arr['board'], $this->fields_arr['bid']));
				$this->fields_arr['content_id'] = $this->insertBoard();
				$this->updateUserSolutionLog();
				$this->updateTotalBoardCount($this->fields_arr['did']);
				$this->updateCategoryBoardCount();
				$this->addAttachments();
				$this->updateTags($this->fields_arr['tags']);
		    }

		public function insertBoard()
		    {
				$this->fields_arr['tags'] = removeDuplicateKeywords($this->fields_arr['tags']);
				$search_title = $this->filterWordsForSearching($this->fields_arr['seo_title'].' '.$this->fields_arr['descriptions'].' '.$this->fields_arr['tags']);
				$search_title = implode(" ", $search_title);
				$search_title = ' '.$search_title.' ';

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['boards'].
						' SET user_id='.$this->dbObj->Param('uid').
						', board='.$this->dbObj->Param('board').
						', seo_title='.$this->dbObj->Param('seo_title').
						', description='.$this->dbObj->Param('descriptions').
						', tags='.$this->dbObj->Param('tags').
						', search_word='.$this->dbObj->Param('search_word').
						', visible_to='.$this->dbObj->Param('visible_to').
						', publish_status='.$this->dbObj->Param('publish').
						', readonly='.$this->dbObj->Param('readonly').
						', redirect_link='.$this->dbObj->Param('redirect_link').
						', discussion_id='.$this->dbObj->Param('did');

				$sql .= ', board_added=NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'],
														 $this->fields_arr['board'],
														 $this->fields_arr['seo_title'],
														 $this->fields_arr['descriptions'],
														 $this->fields_arr['tags'],
														 $search_title,
														 $this->fields_arr['visible_to'],
														 $this->fields_arr['publish'],
														 $this->fields_arr['readonly'],
														 $this->fields_arr['redirect_link'],
														 $this->fields_arr['did']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				$board_inserted_id = $this->dbObj->Insert_ID();

				//Add Activity
				if($this->CFG['admin']['index']['activity']['show'])
					{
						$activity_arr['action_key'] = 'new_board';
						$activity_arr['owner_id'] = $this->CFG['user']['user_id'];
						$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
						$activity_arr['board_id'] = $board_inserted_id;

						$user_details = $this->getUserDetails($this->CFG['user']['user_id']);
						$activity_arr['display_name'] = $user_details['display_name'];
						$this->discussionsActivityObj->addActivity($activity_arr);
					}

				return $board_inserted_id;
		    }

		public function updateUserSolutionLog()
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
						' SET total_board=total_board+1';
				if($this->CFG['admin']['ask_solutions']['allowed'])
					$sql .= ', total_points=total_points+'.$this->CFG['admin']['ask_solutions']['points'];
				$sql .=  ', date_updated=NOW()'.
						' WHERE user_id='.$this->dbObj->Param('uid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
		    }

		public function updateTotalBoardCount($did)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].
						' SET total_boards=total_boards+1'.
						' ,last_post_user_id='.$this->dbObj->Param('user_id').
						' ,last_post_date=NOW()'.
						' WHERE discussion_id='.$this->dbObj->Param($did);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $did));
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}
		/**
		 * SolutionsFormHandler::updateBoard()
		 *
		 * @return
		 */
		public function updateBoard()
		    {
				$this->setFormField('seo_title', $this->getSeoTitleForBoard($this->fields_arr['board'], $this->fields_arr['bid']));
				$search_title = $this->filterWordsForSearching($this->fields_arr['seo_title'].' '.$this->fields_arr['descriptions'].' '.$this->fields_arr['tags']);
				$search_title = implode(" ", $search_title);
				$search_title = ' '.$search_title.' ';

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].
						' SET board='.$this->dbObj->Param('board').
						', seo_title='.$this->dbObj->Param('seo_title').
						', description='.$this->dbObj->Param('descriptions').
						', tags='.$this->dbObj->Param('tags').
						', search_word='.$this->dbObj->Param('search_word').
						', visible_to='.$this->dbObj->Param('visible_to').
						', publish_status='.$this->dbObj->Param('publish').
						', readonly='.$this->dbObj->Param('readonly').
						', redirect_link='.$this->dbObj->Param('redirect_link').
						' WHERE board_id='.$this->dbObj->Param('bid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['board'],
														 $this->fields_arr['seo_title'],
														 $this->fields_arr['descriptions'],
														 $this->fields_arr['tags'],
														 $search_title,
														 $this->fields_arr['visible_to'],
														 $this->fields_arr['publish'],
														 $this->fields_arr['readonly'],
														 $this->fields_arr['redirect_link'],
														 $this->fields_arr['bid']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

	            $this->fields_arr['content_id'] = $this->fields_arr['bid'];
				$this->addAttachments();
				$this->modifyTags();
		    }

		/**
		 * SolutionsFormHandler::updateStatus()
		 *
		 * @param mixed $table_name
		 * @param mixed $status
		 * @return
		 */
		public function updateStatus($table_name, $status)
		    {
				if(!$this->fields_arr['board_ids'])
					return ;

				$id = $this->fields_arr['board_ids'];
				//$this->updateBoardCountForBlockUnblock($id, $status);
				if($this->discussion_details['status'] == 'Active' && $this->checkDiscussionCategoryActive($this->discussion_details['discussion_id']))
					$this->updateBoardCountForActiveInactive($id, $status);

				$condition = '\'ToActivate\'';
				if($status == 'Blocked' or $status == 'Unblock')
					$condition = '\'Inactive\',\'ToActivate\'';
				if($status == 'Unblock')
					$status = 'Active';

				$sql = 'UPDATE '.$table_name.' SET status=\''.$status.'\' WHERE board_id IN ('.$id.')'.
						' AND status NOT IN('.$condition.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);
		    }

		/**
		 * SolutionsFormHandler::updateFeatured()
		 *
		 * @param mixed $table_name
		 * @param mixed $status
		 * @return
		 */
		public function updateFeatured($table_name, $status)
		    {
				if(!$this->fields_arr['board_ids'])
					return ;

				$id = $this->fields_arr['board_ids'];

				$sql = 'UPDATE '.$table_name.' SET featured='.$this->dbObj->Param($status).' WHERE board_id IN ('.$id.')'.
						' AND status !=\'ToActivate\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($status));
				if (!$rs)
				        trigger_db_error($this->dbObj);
		    }

		/**
		 * SolutionsFormHandler::updateBoardCountForBlockUnblock()
		 *
		 * @param mixed $board_ids
		 * @param mixed $status
		 * @return
		 */
		public function updateBoardCountForBlockUnblock($board_ids, $status)
		    {
				/*Following will be executed only if we do block or unblock  boards*/
				//if($status != 'Blocked' AND $status != 'Unblock')
				//return ;
				if($status == 'Blocked')
					 {
					 	$s_status = ' !=\'Blocked\' AND status !=\'ToActivate\'';
						$q_update = '-';
					 }
				else {
						$s_status = ' =\'Blocked\'';
						$q_update = '+';
					 }

				$sql = 'SELECT user_id, board_id, status FROM '.$this->CFG['db']['tbl']['boards'].
						' WHERE board_id IN ('.$board_ids.') AND status'.$s_status;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow()) {
							$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
									' SET total_board=total_board'.$q_update.'1';
							if($this->CFG['admin']['ask_solutions']['allowed'])
								$sql .= ', total_points=total_points'.$q_update.$this->CFG['admin']['ask_solutions']['points'];
							$sql .= ', date_updated=NOW()'.
									' WHERE user_id='.$row['user_id'];
							$stmt = $this->dbObj->Prepare($sql);
							$user_logs = $this->dbObj->Execute($stmt);
							if (!$user_logs)
						        trigger_db_error($this->dbObj);
						}
					}

				return ;
		    }

		/**
		 * SolutionsFormHandler::updateBoardAndCategoryCountForPublish()
		 *
		 * @param mixed $board_ids
		 * @param mixed $status
		 * @return
		 */
		public function updateBoardAndCategoryCountForPublish($board_ids, $status)
		    {
				/*Following will be executed only if we do publish  boards*/
				if($status != 'Publish')
					return ;

				$s_status = ' =\'ToActivate\'';

				$sql = 'SELECT user_id, board_id, board, seo_title, description, board_id, tags, total_solutions, last_post_by, status'.
						' FROM '.$this->CFG['db']['tbl']['boards'].
						' WHERE board_id IN ('.$board_ids.') AND status'.$s_status;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$date_closed = ', board_added= NOW()';
								$update_status = 'Active';

								$updatesql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].' SET status='.$this->dbObj->Param($update_status).$date_closed.' WHERE board_id IN ('.$row['board_id'].')';
								$updatesqlstmt = $this->dbObj->Prepare($updatesql);
								$updatesqlrs = $this->dbObj->Execute($updatesqlstmt, array($update_status));
								if (!$updatesqlrs)
								        trigger_db_error($this->dbObj);


								$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
									' SET total_board=total_board+1';
								if($this->CFG['admin']['ask_solutions']['allowed'])
									$sql .= ', total_points=total_points+'.$this->CFG['admin']['ask_solutions']['points'];
								$sql .= ', date_updated=NOW()'.
									' WHERE user_id='.$row['user_id'];
								$stmt = $this->dbObj->Prepare($sql);
								$user_logs = $this->dbObj->Execute($stmt);
								if (!$user_logs)
							       	trigger_db_error($this->dbObj);


							    $sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].
										' SET total_boards=total_boards+1'.
										', total_solutions=total_solutions+'.$this->dbObj->Param($row['total_solutions']).
										', last_post_user_id='.$this->dbObj->Param($row['last_post_by']).
										', last_post_date=NOW()'.
										' WHERE discussion_id='.$this->dbObj->Param($this->discussion_details['discussion_id']);
							    $stmt = $this->dbObj->Prepare($sql);
							    $rs_discuss = $this->dbObj->Execute($stmt, array($row['total_solutions'], $row['last_post_by'], $this->discussion_details['discussion_id']));
							    if (!$rs_discuss)
							    	    trigger_db_error($this->dbObj);

								if($row['tags'])
									$this->updateTags($row['tags']);

								$this->sendPublishedMailAlert($row['user_id'], 'Board', $row['seo_title'], $row['board'], $row['description']);

								//Add Activity
								if($this->CFG['admin']['index']['activity']['show'])
									{
										$activity_arr['action_key'] = 'publish_board';
										$activity_arr['owner_id'] = $row['user_id'];
										$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
										$activity_arr['board_id'] = $row['board_id'];
										$this->discussionsActivityObj->addActivity($activity_arr);
									}
							}
						//die('here');
					}
				return ;
		    }

		/**
		 * SolutionsFormHandler::increaseCategoryBoardCount()
		 *
		 * To update boards count
		 *
		 * @param mixed $cat_id
		 * @return
		 */
		public function increaseCategoryBoardCount($cat_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
						' SET total_discussions=total_discussions+1'.
						' WHERE cat_id='.$this->dbObj->Param($cat_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * SolutionsFormHandler::deleteBoards()
		 *
		 * @param mixed $table_name
		 * @param mixed $solutions_table
		 * @param mixed $users_board_log_table
		 * @return
		 */
		public function deleteBoards($table_name, $solutions_table, $users_board_log_table)
		    {
				if(!$this->fields_arr['board_ids'])
					return ;

				$id = $this->fields_arr['board_ids'];

				$sql = 'SELECT user_id, board_id, status, best_solution_id, total_solutions, tags FROM '.$table_name.' WHERE board_id IN ('.$id.')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow()){

							if($row['status'] != 'ToActivate')
								{
									if($row['status'] == 'Active' AND $this->discussion_details['status'] == 'Active' AND $this->checkDiscussionCategoryActive($this->discussion_details['discussion_id']))
										{
											$sql = 'UPDATE '.$users_board_log_table.' SET total_board=total_board-1';
											if($this->CFG['admin']['ask_solutions']['allowed'])
												$sql .= ', total_points=total_points-'.$this->CFG['admin']['ask_solutions']['points'];
											$sql .= ' WHERE user_id='.$this->dbObj->Param('uid');

											$stmt = $this->dbObj->Prepare($sql);
											$rs_user_log = $this->dbObj->Execute($stmt, array($row['user_id']));
											if (!$rs_user_log)
									        		trigger_db_error($this->dbObj);
										}

							        if($row['status'] == 'Active')
							        	{
									        $sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].
													' SET total_boards=total_boards-1'.
													', total_solutions=total_solutions-'.$this->dbObj->Param($row['total_solutions']).
													' WHERE discussion_id='.$this->dbObj->Param($this->fields_arr['did']);
									        $stmt = $this->dbObj->Prepare($sql);
									        $rs_discuss = $this->dbObj->Execute($stmt, array($row['total_solutions'], $this->fields_arr['did']));
									        if (!$rs_discuss)
									        	    trigger_db_error($this->dbObj);
										}

								// update total_baords, total_solutions of category and parent categories
									$cat_sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
												' SET total_solutions=total_solutions-'.$this->dbObj->Param($row['total_solutions']).
												', total_boards=total_boards-1'.
												' WHERE cat_id='.$this->dbObj->Param($this->discussion_details['pcat_id']);

									$cat_stmt = $this->dbObj->Prepare($cat_sql);
									$cat_rs = $this->dbObj->Execute($cat_stmt, array($row['total_solutions'], $this->discussion_details['pcat_id']));
									if (!$cat_rs)
									    trigger_db_error($this->dbObj);
									$this->updateParentCategories($this->discussion_details['pcat_id'], '-', $row['total_solutions']);

									$sql = 'SELECT user_id, solution_id, status FROM '.$solutions_table.
											' WHERE board_id='.$this->dbObj->Param($row['board_id']);
									$stmt = $this->dbObj->Prepare($sql);
									$rs_sol = $this->dbObj->Execute($stmt, array($row['board_id']));
									if (!$rs_sol)
									        trigger_db_error($this->dbObj);
									if ($rs_sol->PO_RecordCount())
										{
											while($row_sol = $rs_sol->FetchRow()){

												if($row_sol['status'] == 'Active' AND $row['status'] == 'Active' AND $this->discussion_details['status'] == 'Active' AND $this->checkDiscussionCategoryActive($this->discussion_details['discussion_id']))
													{
														$sql = 'UPDATE '.$users_board_log_table.' SET total_solution=total_solution-1';
														if($this->CFG['admin']['reply_solutions']['allowed'])
															{
																$points = $this->CFG['admin']['reply_solutions']['points'];
																$sql .= ', total_points=total_points-'.$points;
															}
														$sql .= ' WHERE user_id='.$this->dbObj->Param($row_sol['user_id']);
														$stmt = $this->dbObj->Prepare($sql);
														$rs_user_log = $this->dbObj->Execute($stmt, array($row_sol['user_id']));
														if (!$rs_user_log)
														        trigger_db_error($this->dbObj);
													}

												//to delete attachments
												$this->commonDeleteAttachments('Solution', $row_sol['solution_id']);

											} // while
										}


									//Decrement tag_count
									$this->updateDeletedBoardsTagCount($row['tags']);

									if ($row['best_solution_id'] AND $row['status'] == 'Active' AND $this->discussion_details['status'] == 'Active' AND $this->checkDiscussionCategoryActive($this->discussion_details['discussion_id']))
										$this->decreaseBestSolutionCount($row['best_solution_id']);
								}

							//to delete attachments
							$this->commonDeleteAttachments('Board', $this->fields_arr['board_ids']);
						} // while
					}

				$sql = 'DELETE FROM '.$table_name.' WHERE board_id IN ('.$id.')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$sql = 'DELETE FROM '.$solutions_table.' WHERE board_id IN ('.$id.')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);
		    }

		/**
		 * SolutionsFormHandler::decreaseBestSolutionCount()
		 *
		 * @param mixed $bid
		 * @return
		 */
		public function decreaseBestSolutionCount($bid)
			{
				if ($bid and $this->CFG['admin']['best_solutions']['allowed'])
					{
						$best_sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['solutions'].' WHERE solution_id='.$bid;
						$best_stmt = $this->dbObj->Prepare($best_sql);
						$best_rs = $this->dbObj->Execute($best_stmt);
						if (!$best_rs)
						        trigger_db_error($this->dbObj);

						if ($best_rs->PO_RecordCount()){
								$best_row = $best_rs->FetchRow();
								$best_ans_userid = $best_row['user_id'];
							}

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
								' SET total_best_solution = total_best_solution - 1'.
								' WHERE user_id='.$this->dbObj->Param($best_ans_userid);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($best_ans_userid));
						if (!$rs)
							    trigger_db_error($this->dbObj);
					}
			}

		/**
		 * BoardFormHandler::updateCategoryBoardCount()
		 *
		 * @return
		 */
		public function updateCategoryBoardCount()
		    {
				echo $sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
						' SET total_boards=total_boards+1'.
						' ,last_post_user_id='.$this->dbObj->Param('user_id').
						' ,last_post_date=NOW()'.
						' WHERE cat_id='.$this->dbObj->Param('cat_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->discussion_details['pcat_id']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				$this->updateParentCategories($this->discussion_details['pcat_id'], '+');
		    }
		/**
		 * SolutionsFormHandler::abuseBoards()
		 *
		 * @return
		 */
		public function abuseBoards()
		    {
				if(!$this->fields_arr['board_ids'])
					return ;

				$id = '';
				$eboard_id = explode(',',$this->fields_arr['board_ids']);
				foreach($eboard_id as $board_id)
					{
						$id .= '\''.$board_id.'\',';
						$this->updateAbuseBoard($board_id);
					}
				$id = substr($id, 0, strrpos($id, ','));
		    }

		/**
		 * SolutionsFormHandler::updateAbuseBoard()
		 *
		 * @param mixed $board_id
		 * @return
		 */
		public function updateAbuseBoard($board_id)
		    {
				$sql = 'SELECT abuse_id FROM '.$this->CFG['db']['tbl']['abuse_boards'].
						' WHERE board_id='.$this->dbObj->Param('bid').
						' AND reported_by='.$this->dbObj->Param('rid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($board_id,
														 $this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['abuse_boards'].
								' SET board_id='.$this->dbObj->Param('bid').
								', reported_by='.$this->dbObj->Param('rid').
								', date_abused=NOW()';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($board_id, $this->CFG['user']['user_id']));
						if (!$rs)
						        trigger_db_error($this->dbObj);

						if ($this->dbObj->Affected_Rows())
							{
								$this->updateBoardAbuseCount($board_id);
								$this->getBoardDetails($board_id);
								$this->updateAbuseUserPoints($this->CFG['admin']['abuse_boards_points']['allowed'], $this->board_details['user_id'], $this->CFG['admin']['abuse_boards']['points']);
								$this->sendAbuseMailToAsker($board_id);
							}
					}
		    }

		/**
		 * SolutionsFormHandler::updateBoardAbuseCount()
		 *
		 * @param mixed $board_id
		 * @return
		 */
		public function updateBoardAbuseCount($board_id)
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].' SET abuse_count=abuse_count+1'.
						' WHERE board_id='.$this->dbObj->Param('bid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($board_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
		    }

		/**
		 * SolutionsFormHandler::getBoardDetails()
		 *
		 * @param integer $board_id
		 * @return
		 */
		public function getBoardDetails($board_id=0)
		    {
				$sql = 'SELECT user_id, seo_title, board FROM '.$this->CFG['db']['tbl']['boards'].' WHERE board_id='.$this->dbObj->Param('bid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($board_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				$this->board_details = $rs->FetchRow();
		    }

		/**
		 * SolutionsFormHandler::updateAbuseUserPoints()
		 *
		 * @param mixed $config_abuse
		 * @param mixed $uid
		 * @param mixed $points
		 * @return
		 */
		public function updateAbuseUserPoints($config_abuse, $uid, $points)
		    {
				if (!$config_abuse or $points == 0 or !isset($this->CFG['user']['user_id']) or empty($this->CFG['user']['user_id']))
					return ;
				//update users_board_log table
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
						' SET total_points=total_points+'.$points.
						', date_updated=NOW()'.
						' WHERE user_id='.$this->dbObj->Param('uid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($uid));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				return ;
		    }

		/**
		 * SolutionsFormHandler::sendAbuseMailToAsker()
		 *
		 * @param mixed $board_id
		 * @return
		 */
		public function sendAbuseMailToAsker($board_id)
		    {
				$email_options = $this->getEmailOptionsOfUser($this->board_details['user_id']);
				if ($email_options['abuse_mail'] == 'Yes')
					{
						$asker_details = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $this->board_details['user_id']);
						$abuse_board_subject = str_ireplace('VAR_USERNAME', $asker_details['display_name'], $this->LANG['abuse_board_email_subject']);

						$receiver_url = getMemberUrl($asker_details['user_id'], $asker_details['name'], 'root');
						$abuse_board_content = str_ireplace('VAR_USERNAME', '<a href="'.$receiver_url.'">'.$asker_details['display_name'].'</a>', $this->LANG['abuse_board_email_content']);
						$sender_url = getMemberUrl($this->CFG['user']['user_id'], $this->CFG['user']['name'], 'root');
						$sender_name = '<a href="'.$sender_url.'">'.$this->CFG['user']['display_name'].'</a>';
						$abuse_board_content = str_ireplace('VAR_SENDER_NAME', $sender_name, $abuse_board_content);
						$abuse_board_content = str_ireplace('VAR_SITENAME', $this->CFG['site']['name'], $abuse_board_content);
						$abuse_board_content = str_ireplace('VAR_BOARD_POSTED', '<strong>'.$this->board_details['board'].'</strong>', $abuse_board_content);
						$board_link = getUrl('solutions', '?title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'root', $this->CFG['admin']['index']['home_module']);
						$abuse_board_content = str_ireplace('VAR_LINK', '<a href="'.$board_link.'">'.$board_link.'</a>', $abuse_board_content);

						$this->_sendMail($asker_details['email'],
										 $abuse_board_subject,
										 $abuse_board_content,
										 $this->CFG['site']['noreply_name'],
										 $this->CFG['site']['noreply_email']);
					}
		    }

		/**
		 * SolutionsFormHandler::populateSearchOptions()
		 *
		 * @return
		 */
		public function populateSearchOptions()
			{
				$populateSearchOptions_arr = array();
				foreach($this->search_options as $key=>$value)
					{
						//$selected = ($highlight_search==$key)?'SELECTED':'';
						$populateSearchOptions_arr[$key] = $value;
					}
				return $populateSearchOptions_arr;
			}

		/**
		 * SolutionsFormHandler::generateRandomId()
		 *
		 * @return
		 */
		public function generateRandomId()
			{
				$time = time();
				$this->fields_arr['rid'] = md5($time);
			}

		/**
		 * SolutionsFormHandler::sendPublishedMailAlert()
		 *
		 * @param mixed $userid
		 * @param mixed $mailtype
		 * @param mixed $mail_content_seo
		 * @param mixed $mail_content
		 * @param mixed $content_description
		 * @return
		 */
		public function sendPublishedMailAlert($userid, $mailtype, $mail_content_seo, $mail_content, $content_description)
			{
				$toDetails = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $userid);
				$site_link = "<a target=\"_blank\" href=\"".URL($this->CFG['site']['url'])."\">".URL($this->CFG['site']['url'])."</a>";

				if($mailtype == 'Board')
					{

						$url_link = getUrl('solutions', '?title='.$mail_content_seo, $mail_content_seo.'/', 'root', $this->CFG['admin']['index']['home_module']);
						$quesiton_link = "<a target=\"_blank\" href=\"".$url_link."\">".$mail_content."</a>";
						$subject = $this->getMailContent($this->LANG['board_publish_subject'], array('VAR_USERNAME'=>$toDetails['display_name'], 'VAR_SITENAME'=>$this->CFG['site']['name'], 'VAR_DESCRIPTION_OF_QUESTION'=>$content_description, 'VAR_BOARD'=>$quesiton_link, 'VAR_LINK'=>$site_link));
						$content = $this->getMailContent($this->LANG['board_publish_message'], array('VAR_USERNAME'=>$toDetails['display_name'], 'VAR_SITENAME'=>$this->CFG['site']['name'], 'VAR_DESCRIPTION_OF_QUESTION'=>$content_description, 'VAR_BOARD'=>$quesiton_link, 'VAR_LINK'=>$site_link));
					}

				$this->_sendMail($toDetails['email'],
									$subject,
									$content,
									$this->CFG['site']['noreply_name'],
									$this->CFG['site']['noreply_email']);
			}

		/**
		 * SolutionsFormHandler::populateSubCategoriesCount()
		 *
		 * @param mixed $cid
		 * @param mixed $scid
		 * @return
		 */
		public function populateSubCategoriesCount($cid, $scid)
		   	{
				$sql = 'SELECT count(cat_id) as count FROM '.
					$this->CFG['db']['tbl']['category'].
					' WHERE parent_id='.$this->dbObj->Param('cid').
					' AND parent_id!=0'.
					' AND status=\'Active\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cid));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						return $row['count'];
					}
				else
					{
						return 0;
					}
	    	}

		/**
		 * SolutionsFormHandler::getAttachments()
		 *
		 * @return
		 */
		public function getAttachments()
			{
				$getAttachments_arr = array();
				$sql = 'SELECT attachment_id, attachment_name FROM '.$this->CFG['db']['tbl']['attachments'].
					' WHERE content_id='.$this->fields_arr['bid'].' AND content_type=\'Board\' ORDER BY date_added';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						$attach_count = 0;
						$inc=1;
						while($row = $rs->FetchRow())
							{
								$getAttachments_arr[$inc]['record'] = $row;
								$extern = strtolower(substr($row['attachment_name'], strrpos($row['attachment_name'], '.')+1));
								$getAttachments_arr[$inc]['attachment_file_name'] = getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['large_name'].'.'.$extern;
								$getAttachments_arr[$inc]['attachment_file_name_thumb'] = getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['thumb_name'].'.'.$extern;

								$getAttachments_arr[$inc]['extern'] = $extern;
								$getAttachments_arr[$inc]['attachment_name'] = $row['attachment_name'];
								$getAttachments_arr[$inc]['attachment']['original_url'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['large_name'].'.'.$extern;
								$getAttachments_arr[$inc]['anchor'] = 'seldel_'.$row['attachment_id'];
								$getAttachments_arr[$inc]['gallery'] = 'Solution_'.$this->fields_arr['bid'];
								$getAttachments_arr[$inc]['attachment']['url'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$getAttachments_arr[$inc]['attachment_file_name'];
								$getAttachments_arr[$inc]['attachment']['url_thumb'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$getAttachments_arr[$inc]['attachment_file_name_thumb'];

								$attach_count++;
								$inc++;

							} // while
						$this->solution_attachment_count = $attach_count;
					}
				return $getAttachments_arr;
			}

		/**
		 * SolutionsFormHandler::deleteMoreInfos()
		 *
		 * @param mixed $aid
		 * @param mixed $aname
		 * @return
		 */
		public function deleteMoreInfos($aid, $attach_name)
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['attachments'].
						' WHERE attachment_id='.$this->dbObj->Param('info_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($aid));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				//deleting large and small images
				$small_name = substr($attach_name, 0, strrpos($attach_name, '.')-1);
				$extern = strtolower(substr($attach_name, strrpos($attach_name, '.')+1));
				// for image formats only
				if(in_array($extern, $this->CFG['admin']['attachments']['image_formats']))
					{
						$attachment_large_file = $this->CFG['site']['project_path'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$attach_name;
						$attachment_small_file = $this->CFG['site']['project_path'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$small_name.$this->CFG['admin']['ans_pictures']['small_name'].'.'.$extern;
						$attachment_thumbnail_file = $this->CFG['site']['project_path'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$small_name.$this->CFG['admin']['ans_pictures']['thumb_name'].'.'.$extern;
						unlink($attachment_large_file);
						unlink($attachment_small_file);
						unlink($attachment_thumbnail_file);
					}
				else // for other formats like doc,pdf,..
					{
						$attachment_large_file = $this->CFG['site']['project_path'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$attach_name;
						unlink($attachment_large_file);
					}
			}

		/**
		 * SolutionsFormHandler::chkFileNameIsNotEmpty()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkFileNameIsNotEmpty($field_name, $err_tip = '')
			{
				if(!isset($_FILES[$field_name]['name']) or !$_FILES[$field_name]['name'])
					{
						$this->setFormFieldErrorTip($field_name,$err_tip);
						return false;
					}
				return true;
			}

		/**
		 * SolutionsFormHandler::chkValidFileType()
		 *
		 * @param mixed $field_name
		 * @param mixed $type
		 * @param string $err_tip
		 * @return
		 */
		public function chkValidFileType($field_name, $type, $err_tip = '')
			{
				$file_allowed_count = $this->CFG['admin']['attachments_allowed']['count'];
				for($i=0;$i<$file_allowed_count;$i++)
					{

						if(!isset($_FILES[$field_name]['name'][$i]) or  $_FILES[$field_name]['name'][$i] == '')
							continue;

						$extern = strtolower(substr($_FILES[$field_name]['name'][$i], strrpos($_FILES[$field_name]['name'][$i], '.')+1));

						if (!in_array($extern, $this->CFG['admin'][$type]['format_arr']))
							{
								$this->fields_err_tip_arr[$field_name] = $err_tip;
								return false;
							}

					}
				return true;
			}

		/**
		 * SolutionsFormHandler::chkValideFileSize()
		 *
		 * @param mixed $field_name
		 * @param mixed $type
		 * @param string $err_tip
		 * @return
		 */
		public function chkValideFileSize($field_name, $type, $err_tip='')
			{
				$file_allowed_count = $this->CFG['admin']['attachments_allowed']['count'];
				for($i=0;$i<$file_allowed_count;$i++)
					{
						if(!isset($_FILES[$field_name]['name'][$i]) or  $_FILES[$field_name]['name'][$i] == '')
							continue;

						if($this->CFG['admin'][$type]['max_size'])
							{
								$max_size = $this->CFG['admin'][$type]['max_size']*1024*1024;
								if ($_FILES[$field_name]['size'][$i] == 0)
									{
										$this->fields_err_tip_arr[$field_name] = $this->LANG['err_tip_invalid_file'];
										return false;
									}
								if ($_FILES[$field_name]['size'][$i] > $max_size)
									{
										$this->fields_err_tip_arr[$field_name] = $err_tip;
										return false;
									}
							}

     				}
     			return true;
			}

		/**
		 * SolutionsFormHandler::chkErrorInFile()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkErrorInFile($field_name, $err_tip='')
			{
				$file_allowed_count = $this->CFG['admin']['attachments_allowed']['count'];
				for($i=0;$i<$file_allowed_count;$i++)
					{
						if(!isset($_FILES[$field_name]['name'][$i]) or  $_FILES[$field_name]['name'][$i] == '')
							continue;

						if($_FILES[$field_name]['error'][$i])
							{
								$this->fields_err_tip_arr[$field_name] = $err_tip;
								return false;
							}
					}
				return true;
			}

		/**
		 * SolutionsFormHandler::getServerDetailsForPhotos()
		 *
		 * @return
		 */
		public function getServerDetailsForPhotos()
			{
				$sql = 'SELECT server_url, ftp_server, ftp_usrename, ftp_password'.
						' FROM '.$this->CFG['db']['tbl']['server_settings'].
						' WHERE server_for=\'Ans_photo\' AND server_status=\'Yes\' LIMIT 0,1';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt);
				//raise user error... fatal
				if (!$rs)
				trigger_db_error($this->dbObj);
				$row = array();
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$this->fields_arr['ftp_server'] = $row['ftp_server'];
						$this->fields_arr['ftp_usrename'] = $row['ftp_usrename'];
						$this->fields_arr['ftp_password'] = $row['ftp_password'];
						$this->fields_arr['server_url'] = $row['server_url'];
						return true;
					}
				return false;
			}

		/**
		 * SolutionsFormHandler::storePicturesTempServer()
		 *
		 * @param mixed $uploadUrl
		 * @param mixed $extern
		 * @return
		 */
		public function storePicturesTempServer($uploadUrl, $extern)
			{
				$this->imageObj->output_original($uploadUrl.'L.'.$extern, strtoupper($extern));
				$image_info = getImageSize($uploadUrl.'L.'.$extern);
				$this->L_WIDTH = $image_info[0];
				$this->L_HEIGHT = $image_info[1];
				//echo '<br>size<br>'.$image_info[1];
				//die('hard');
				//GET SMALL IMAGE
				if($this->CFG['admin']['ans_pictures']['small_name']=='S')
					{
						$this->imageObj->resize($this->CFG['admin']['ans_pictures']['small_width'], $this->CFG['admin']['ans_pictures']['small_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'S.'.$extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl.'S.'.$extern);
						$this->S_WIDTH = $image_info[0];
						$this->S_HEIGHT = $image_info[1];
					///	echo '<br>size<br>'.$image_info[1];
						//die('hard');

					}
				if($this->CFG['admin']['ans_pictures']['thumb_name']=='T')
					{
						$this->imageObj->resize($this->CFG['admin']['ans_photos']['thumb_width'], $this->CFG['admin']['ans_photos']['thumb_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'T.'.$extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl.'T.'.$extern);
						$this->T_WIDTH = $image_info[0];
						$this->T_HEIGHT = $image_info[1];
				    	//echo '<br>size<br>'.$image_info[1];
						//die('hard');

					}

				$wname = $this->CFG['admin']['ans_pictures']['large_name'].'_WIDTH';
				$hname = $this->CFG['admin']['ans_pictures']['large_name'].'_HEIGHT';
				$this->L_WIDTH = $this->$wname;
				$this->L_HEIGHT = $this->$hname;

				$wname = $this->CFG['admin']['ans_pictures']['small_name'].'_WIDTH';
				$hname = $this->CFG['admin']['ans_pictures']['small_name'].'_HEIGHT';
				$this->S_WIDTH = $this->$wname;
				$this->S_HEIGHT = $this->$hname;

				$wname = $this->CFG['admin']['ans_pictures']['thumb_name'].'_WIDTH';
				$hname = $this->CFG['admin']['ans_pictures']['thumb_name'].'_HEIGHT';
				$this->T_WIDTH = $this->$wname;
				$this->T_HEIGHT = $this->$hname;
			}

		/**
		 * SolutionsFormHandler::addAttachments()
		 *
		 * @return
		 */

		 public function addAttachments()
		 	{
				$uploads_arr =array();
				$uploads_arr_original =array();
				$uploads_arr = $this->getFormField('uplarr');
				$uploads_arr_original = $this->getFormField('upl_original');
				$file_allowed_count = count($uploads_arr);

				for($i=0;$i<$file_allowed_count;$i++)
					{
						if($uploads_arr[$i] == '')
							continue;
						$extern = strtolower(substr($uploads_arr[$i], strrpos($uploads_arr[$i], '.')+1));
						$this->setFormField('photo_ext',$extern);
						$req_upl = explode('_', $uploads_arr[$i]);
						$temp_dir = '../../'.$this->CFG['admin']['index']['home_module'].'/files/uploads/';
						$def_req = $temp_dir.'temp_'.$req_upl[1].'_'.$req_upl[2].'.'.$extern;
						$imageObj = new ImageHandler($def_req);
						$this->setIHObject($imageObj);
						$temp_file =$temp_dir.'temp_'.$req_upl[1].'_'.$req_upl[2];
						if(in_array($extern, $this->CFG['admin']['attachments']['image_formats']))
							$this->storePicturesTempServer($temp_file, $extern);

						$uploaded = false;
						$local_upload = true;
						$dir = '../'.$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'];

						if($this->getServerDetailsForPhotos())
							{
								if($FtpObj = new FtpHandler($this->getFormField('ftp_server'),$this->getFormField('ftp_usrename'),$this->getFormField('ftp_password')))
									{
										$FtpObj->makeDirectory($dir);
										$FtpObj->changeDirectory($dir);

										$FtpObj->moveTo($temp_file.'.'.$extern, $dir.$image_name.'.'.$extern);
										unlink($temp_file.'.'.$extern);
										if(in_array($extern, $this->CFG['admin']['attachments']['image_formats']))
											{
												if($this->CFG['admin']['ans_pictures']['large_name']=='L')
													{
														$FtpObj->moveTo($temp_file.'L.'.$extern, $dir.$image_name.'L.'.$extern);
														unlink($temp_file.'L.'.$extern);
													}
												if($this->CFG['admin']['ans_pictures']['small_name']=='S')
													{
														$FtpObj->moveTo($temp_file.'S.'.$extern, $dir.$image_name.'S.'.$extern);
														unlink($temp_file.'S.'.$extern);
														$uploaded = true;
													}
												if($this->CFG['admin']['ans_pictures']['thumb_name']=='T')
													{
														$FtpObj->moveTo($temp_file.'T.'.$extern, $dir.$image_name.'T.'.$extern);
														unlink($temp_file.'T.'.$extern);
														$uploaded = true;
													}
											}
										else
											{
												$FtpObj->moveTo($temp_file.'.'.$extern, $dir.$image_name.'L.'.$extern);
												$uploaded = true;
											}
										$this->setFormField('server_url',$this->getFormField('server_url'));
										$local_upload = false;
										return;
									}
							}
						if($local_upload)
							{
								$dir = '../../'.$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'];
								$this->chkAndCreateFolder($dir);
								$attachment_id = $this->createAttachmentRecord('');
								$uploadUrl = $dir.getImageName($attachment_id);

								if(in_array($extern, $this->CFG['admin']['attachments']['image_formats']))
									{
										if($this->CFG['admin']['ans_pictures']['large_name']=='L')
											{
												if(copy($temp_file.'L.'.$extern, $uploadUrl.'L.'.$extern))
													unlink($temp_file.'L.'.$extern);

											}
										if($this->CFG['admin']['ans_pictures']['small_name']=='S')
											{
												if(copy($temp_file.'S.'.$extern, $uploadUrl.'S.'.$extern))
													unlink($temp_file.'S.'.$extern);

											}
										if($this->CFG['admin']['ans_pictures']['thumb_name']=='T')
											{

												if(copy($temp_file.'T.'.$extern, $uploadUrl.'T.'.$extern))
													unlink($temp_file.'T.'.$extern);
												$uploaded = true;
											}
									}
								else
									{
										copy($temp_file.'.'.$extern, $uploadUrl.'L.'.$extern);
										$uploaded = true;
									}


								$this->setFormField('server_url',$this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/');
							}

						if($uploaded)
							$this->updateAttachmentRecord($attachment_id, $uploads_arr_original[$i]);

							unlink('../../'.$uploads_arr[$i]);
							unlink($temp_dir.'temp_'.$req_upl[1].'_'.$req_upl[2].'.'.$extern);
					}
			}

		/**
		 * SolutionsFormHandler::createAttachmentRecord()
		 *
		 * @param mixed $size
		 * @return
		 */
		public function createAttachmentRecord($size)
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['attachments'].
						' SET content_type=\'Board\''.
						', content_id='.$this->dbObj->Param('board').
						', attachment_size='.$this->dbObj->Param('size').
						', date_added=NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['content_id'], $size));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				return $this->dbObj->Insert_ID();
			}

		/**
		 * SolutionsFormHandler::updateAttachmentRecord()
		 *
		 * @param mixed $aid
		 * @param mixed $file_path
		 * @return
		 */
		public function updateAttachmentRecord($aid, $file_path)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['attachments'].
						' SET attachment_name='.$this->dbObj->Param('board').
						' ,photo_server_url='.$this->dbObj->Param('server_url').
						' WHERE attachment_id='.$this->dbObj->Param('id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($file_path, $this->fields_arr['server_url'], $aid));
				if (!$rs)
				        trigger_db_error($this->dbObj);
			}

		/**
		 * SolutionsFormHandler::updateTags()
		 *
		 * @param mixed $qtags
		 * @return
		 */
		public function updateTags($qtags)
			{
				$tags = explode(' ', $qtags);
				foreach($tags as $eachTag){
					if (trim($eachTag) == '') continue;
					if ($this->isTagExists($eachTag))
						$this->updateTagCount($eachTag);
					else
						$this->insertTagCount($eachTag);
				}
			}

		/**
		 * SolutionsFormHandler::isTagExists()
		 *
		 * @param mixed $tagname
		 * @param mixed $minus
		 * @return
		 */
		public function isTagExists($tagname, $minus=false)
			{
				$condition = ' ';
				if($minus)
					$condition = ' total_count > 0 AND ';
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['tags'].
						' WHERE'.$condition.'tag_name='.$this->dbObj->Param($tagname);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($tagname));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				$ok = false;
				if ($rs->PO_RecordCount())
					$ok = true;
				return $ok;
			}

		/**
		 * SolutionsFormHandler::updateTagCount()
		 *
		 * @param mixed $tagname
		 * @param mixed $minus
		 * @return
		 */
		public function updateTagCount($tagname, $minus=false)
			{
				$countAction = '+';
				if($minus)
					$countAction = '-';

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['tags'].
						' SET total_count=total_count'.$countAction.'1'.
						' WHERE tag_name='.$this->dbObj->Param($tagname);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($tagname));
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * SolutionsFormHandler::insertTagCount()
		 *
		 * @param mixed $tagname
		 * @return
		 */
		public function insertTagCount($tagname)
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['tags'].
						' SET tag_name='.$this->dbObj->Param($tagname).
						', total_count=1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($tagname));
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * SolutionsFormHandler::modifyTags()
		 *
		 * @return
		 */
		public function modifyTags()
			{
				$tags = explode(' ', $this->fields_arr['tags']);
				$old_tags = explode(' ',$this->board_details['tags']);
				$tags_to_decrement = array_diff($old_tags, $tags);
				$tags_to_increment = array_diff($tags, $old_tags);

				if(!empty($tags_to_increment))
					{
						foreach($tags_to_increment as $eachTag)
							{
								if (trim($eachTag) == '') continue;
								if ($this->isTagExists($eachTag))
									$this->updateTagCount($eachTag);
								else
									$this->insertTagCount($eachTag);
							}
					}

				if(!empty($tags_to_decrement))
					{
						foreach($tags_to_decrement as $removableTag)
							{
								if (trim($removableTag) == '') continue;
								$this->updateTagCount($removableTag, $minus=true);
							}
					}
			}

		/**
		 * SolutionsFormHandler::updateDeletedBoardsTagCount()
		 *
		 * @param mixed $tags
		 * @return
		 */
		public function updateDeletedBoardsTagCount($tags)
			{
				$tags_arr = explode(' ', $tags);
				foreach($tags_arr as $tagname)
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['tags'].
							' SET total_count=total_count-1'.
							' WHERE tag_name='.$this->dbObj->Param($tagname);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($tagname));
						if (!$rs)
					    		trigger_db_error($this->dbObj);
					}
			}

		public function isAddMode()
			{
				$ok = false;
				$sql = 'SELECT d.status, d.discussion_title, c.status AS cat_status, c.cat_name'.
						' FROM '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c'.
						' WHERE c.cat_id=d.pcat_id AND d.discussion_id='.$this->dbObj->Param($this->fields_arr['did']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['did']));
				if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						switch($row['status']){
							case 'Active':
								$ok = true;
								break;
							case 'ToActivate':
								$please_publish_the_discussion = str_replace('VAR_DISCUSSION', $row['discussion_title'], $this->LANG['please_publish_the_discussion']);
								$this->setCommonErrorMsg($please_publish_the_discussion);
								break;
							case 'Inactive':
								$please_activate_the_discussion = str_replace('VAR_DISCUSSION', $row['discussion_title'], $this->LANG['please_activate_the_discussion']);
								$this->setCommonErrorMsg($please_activate_the_discussion);
								break;
						} // switch$row = $rs->FetchRow();
						if ($ok)
							{
								switch($row['cat_status']){
									case 'Active':
										$ok = true;
										break;
									case 'Inactive':
										$ok = false;
										$please_activate_the_category = str_replace('VAR_CAT_NAME', $row['cat_name'], $this->LANG['please_activate_the_category']);
										$this->setCommonErrorMsg($please_activate_the_category);
										break;
								} // switch
							}
					}
				if (!$ok)
					$this->setPageBlockShow('block_msg_form_error');
				return $ok;
			}
	}
//<<<<<-------------------- Class SolutionsFormHandler Ends ------------------------//
//------------------------- Code Begins ---------------------------------->>>>>//
$boards = new SolutionsFormHandler();
$boards->left_navigation_div = 'discussionsMain';
if($CFG['admin']['index']['activity']['show'])
	{
		$DiscussionsActivity = new DiscussionsActivityHandler();
		$boards->discussionsActivityObj = $DiscussionsActivity;
	}

$boards->setLang(array('sort_ascending' => $LANG['list_sort_ascending'],
						'sort_descending' => $LANG['list_sort_descending']
						));
$boards->setPageBlockNames(array('list_records', 'form_edit', 'show_form_search', 'show_form_confirm'));
$boards->setAllPageBlocksHide();
$boards->setColumnSortUrl($_SERVER['REQUEST_URI']);

$boards->setSearchFormFieldNames('start', 'numpg', 'dsc', 'asc'); //, 'q');
$boards->setFormField('search_name', '');
$boards->setFormField('search_cat', '');
$boards->setFormField('action', '');
$boards->setFormField('bid', '');
$boards->setFormField('f', '');
$boards->setFormField('board', '');
$boards->setFormField('descriptions', '');
$boards->setFormField('rid', '');
$boards->setFormField('sort', 'date');
$boards->setFormField('order', '');
$boards->setFormField('uname', '');
$boards->setFormField('tags', '');
$boards->setFormField('act', '');
$boards->setFormField('with', '');
$boards->setFormField('type', '');
$boards->setFormField('more_boards', '');
$boards->setFormField('tags', '');
$boards->setFormField('publish', 'Yes');
$boards->setFormField('readonly', 'No');
$boards->setFormField('board_ids', array());
$boards->setFormField('title', '');
$boards->setFormField('did', '');
$boards->setFormField('asc', '');
$boards->setFormField('dsc', '');
$boards->setFormField('start', 0);
$boards->setFormField('act', '');
$boards->setFormField('mode', '');
$boards->setFormField('msg', '');
$boards->setFormField('sort_act', '');
$boards->setFormField('attachments', '');
$boards->setFormField('attachment_id', '');
$boards->setFormField('attachment_name', '');
$boards->setFormField('photo_server_url', '');
$boards->setFormField('upl_original', array());
$boards->setFormField('uplarr', array());
$boards->setFormField('visible_to', 'All');
$boards->setFormField('isredirect', 'No');
$boards->setFormField('redirect_link', '');

$req_settings = '';
$cnt_format = count($CFG['admin']['attachments']['format_arr']);
if($cnt_format <= 0)
	{
		$req_settings = "*.jpg;*.jpeg;*.png; *.gif";
	}
else
	{
		for ($i=0;$i<$cnt_format;$i++)
			{
				$req_settings = $req_settings.'*.'.$CFG['admin']['attachments']['format_arr'][$i].';';
			}
	}
$boards->paging_arr = array('orderby_field', 'orderby', 'did');

$boards->setFormField('numpg', $CFG['data_tbl']['numpg']);
$boards->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$boards->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$boards->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);

$boards->member_url = $CFG['site']['relative_url'].$CFG['redirect']['member'].'/';
$boards->setTableNames(array($CFG['db']['tbl']['boards'].' as b', $CFG['db']['tbl']['users'].' as u'));
$boards->setReturnColumns(array('board_id', 'u.'.$boards->getUserTableField('user_status').' AS user_status', 'b.user_id', 'b.abuse_count', 'b.featured', 'b.publish_status', 'b.readonly', 'b.tags', 'b.total_solutions', $boards->getUserTableFields(array('name', 'display_name')), 'board', 'total_stars', 'TIMEDIFF(NOW(), board_added) as board_added', 'CASE when status=\'Active\' then \''.$LANG['board_active'].'\' when status=\'ToActivate\' then \''.$LANG['discuzz_common_unpublished'].'\' when status=\'Blocked\' then \''.$LANG['discuzz_common_blocked'].'\' ELSE \''.$LANG['board_inactive'].'\' END status'));
$boards->setFormField('orderby_field', 'board_id');
$boards->setFormField('orderby', 'DESC');
$boards->search_options = array(1=>$LANG['board_owner'], 2=>$LANG['search_type_email'],
									3=>$LANG['board_active'], 4=>$LANG['board_inactive'],
									6=>$LANG['search_type_all'],
									11=>$LANG['search_type_with_best_solution'],
									12=>$LANG['search_type_unpublished'],
									13=>$LANG['discuzz_common_featured_boards']);

$boards->setAllPageBlocksHide();
$boards->sanitizeFormInputs($_REQUEST);

if ($boards->isFormPOSTed($_REQUEST, 'deletemoreattachments'))
	{
		if (!isMember())
			{
				echo 'Session Expired. <a href="'.$CFG['auth']['login_url'].'?r">Login to continue..!</a>';
				die();
			}
		ob_start();

		$comment_id = $boards->getFormField('attachment_id');
		$attachment_name = $boards->getFormField('attachment_name');
		$boards->deleteMoreInfos($comment_id, $attachment_name);

		die();
	}

if(!$boards->isValidDiscussionId($boards->getFormField('did'), $LANG['discussions_err_tip_invalid_discussion_id']))
	Redirect2URL('discussions.php');

if($boards->getFormField('f'))
	$boards->setFormField('f', 'v');

if(!$boards->getFormField('rid'))
	$boards->generateRandomId();

$boards->buildSelectQuery();

if ($boards->isFormGETed($_GET, 'delmsg'))
	{
		$boards->setPageBlockShow('block_msg_form_success');
		$boards->setCommonSuccessMsg($LANG['board_deleted_succesfully']);
	}

if($boards->isFormPOSTed($_POST, 'todo'))
	{
		$boards->setAllPageBlocksHide();
		$num_selected = count($boards->getFormField('board_ids'));
		if($num_selected > 0)
			{
				$boards->setPageBlockShow('show_form_confirm');
				$boards->ConditionQuery();
			}
    }
elseif($boards->isFormPOSTed($_POST, 'action') and $boards->getFormField('board_ids') and  $boards->getFormField('sort_act'))
	{
		//die($boards->getFormField('board_ids'));
		if($boards->getFormField('action') == 'publish_board')
			{
     			$boards->updateBoardAndCategoryCountForPublish($boards->getFormField('board_ids'), 'Publish');
     			$LANG['board_status_updated_succesfully'] = $LANG['board_status_published_succesfully'];
			}
		elseif($boards->getFormField('action') == 'block_board')
			{
                    $boards->updateStatus($CFG['db']['tbl']['boards'], 'Blocked');
                    $LANG['board_status_updated_succesfully'] = $LANG['board_status_blocked_succesfully'];
            }
		elseif($boards->getFormField('action') == 'active_board')
			{
                    $boards->updateStatus($CFG['db']['tbl']['boards'], 'Active');
                    $LANG['board_status_updated_succesfully'] = $LANG['board_status_activated_succesfully'];
            }
		elseif($boards->getFormField('action') == 'Inactive_board')
			{
                    $boards->updateStatus($CFG['db']['tbl']['boards'], 'Inactive');
                    $LANG['board_status_updated_succesfully'] = $LANG['board_status_inactivated_succesfully'];
            }
		elseif($boards->getFormField('action') == 'delete_board')
			{
                    $boards->deleteBoards($CFG['db']['tbl']['boards'], $CFG['db']['tbl']['solutions'], $CFG['db']['tbl']['users_board_log']);
                    $LANG['board_status_updated_succesfully'] = $LANG['board_status_deleted_succesfully'];
            }
		elseif($boards->getFormField('action') == 'abuse_board')
			{
                    $boards->abuseBoards();
                    $LANG['board_status_updated_succesfully'] = $LANG['board_status_abused_succesfully'];
            }
		elseif($boards->getFormField('action') == 'unblock_board')
			{
                    $boards->updateStatus($CFG['db']['tbl']['boards'], 'Unblock');
                    $LANG['board_status_updated_succesfully'] = $LANG['board_status_unblocked_succesfully'];
            }
        elseif($boards->getFormField('action') == 'feature_board')
			{
                    $boards->updateFeatured($CFG['db']['tbl']['boards'], 'Yes');
                    $LANG['board_status_updated_succesfully'] = $LANG['board_status_featured_succesfully'];
            }
        elseif($boards->getFormField('action') == 'remove_feature')
			{
                    $boards->updateFeatured($CFG['db']['tbl']['boards'], 'No');
                    $LANG['board_status_updated_succesfully'] = $LANG['board_status_feature_removed_succesfully'];
            }

		$boards->ConditionQuery();
		$boards->setCommonSuccessMsg($LANG['board_status_updated_succesfully']);
		$boards->setPageBlockShow('block_msg_form_success');
	}
elseif($boards->isFormPOSTed($_POST, 'go') || $boards->isFormPOSTed($_GET, 'search_cat'))
	{
		$boards->ConditionQuery();
		$boards->paging_arr = array('search_cat', 'search_name', 'did');
	}
elseif(($boards->isFormPOSTed($_POST, 'dcancel')) OR ($boards->isFormGETed($_GET, 'change')))
	{
		$boards->ConditionQuery();
		$boards->setPageBlockShow('form_edit');
	}
elseif(($boards->isFormPOSTed($_POST, 'cancel')))
	{
		Redirect2URL($CFG['site']['relative_url'].'manageSolutions.php?did='.$boards->getFormField('did'));
	}
elseif(($boards->isFormPOSTed($_POST, 'submit')))
	{
		$boards->chkIsValidBoard();
		if($CFG['admin']['board']['duplicates'])
			{
				$boards->chkIsNotEmpty('board', $LANG['err_tip_compulsory']);
			}
		else
			{
				$boards->chkIsNotEmpty('board', $LANG['err_tip_compulsory'])	and
					$boards->chkIsBoardExists('board', $LANG['boards_err_exists_already']);
			}

		if ($CFG['admin']['description']['mandatory'])
			$boards->chkIsNotEmpty('descriptions', $LANG['err_tip_compulsory']);

		if (isset($_FILES['attachments']) and $_FILES['attachments']['tmp_name'])
			{
				$boards->chkValidFileType('attachments', 'attachments', $LANG['err_tip_invalid_file_type']) and
					$boards->chkValideFileSize('attachments','attachments',$LANG['err_tip_invalid_file_size']) and
						$boards->chkErrorInFile('attachments', $LANG['err_tip_invalid_file']);
			}

		if($boards->getFormField('isredirect') == 'Yes')
			{
				if($boards->chkIsNotEmpty('redirect_link', $LANG['redirect_link_empty']))
					{
						if(stripos($boards->getFormField('redirect_link'), 'http://') === false)
							$boards->setFormField('redirect_link', 'http://'.$boards->getFormField('redirect_link'));
						$boards->chkIsValidURL('redirect_link', $LANG['redirect_link_not_valid']);
					}
			}
		else
			{
				$boards->setFormField('redirect_link', '');
			}

		if ($boards->isValidFormInputs())
			{
				$boards->updateBoard();
				if($boards->getFormField('f')=='v')
					Redirect2URL($CFG['site']['relative_url'].'viewSolutions.php?bid='.$boards->getFormField('bid').'&msg=4&did='.$boards->getFormField('did'));

				Redirect2URL($CFG['site']['relative_url'].'manageSolutions.php?msg=1&did='.$boards->getFormField('did'));
			}
		else
			{
				$boards->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
				$boards->setPageBlockShow('block_msg_form_error');
				$boards->setPageBlockShow('form_edit');
			}
		$boards->ConditionQuery();
	}
elseif(($boards->isFormPOSTed($_POST, 'add_submit')))
	{
		if($CFG['admin']['board']['duplicates'])
			$boards->chkIsNotEmpty('board', $LANG['err_tip_compulsory']);
		else
			$boards->chkIsNotEmpty('board', $LANG['err_tip_compulsory']) and $boards->chkIsBoardExists('board', $LANG['boards_err_exists_already']);

		if ($CFG['admin']['description']['mandatory'])
			$boards->chkIsNotEmpty('descriptions', $LANG['err_tip_compulsory']);

		if($boards->getFormField('isredirect') == 'Yes')
			{
				if($boards->chkIsNotEmpty('redirect_link', $LANG['redirect_link_empty']))
					{
						if(stripos($boards->getFormField('redirect_link'), 'http://') === false)
							$boards->setFormField('redirect_link', 'http://'.$boards->getFormField('redirect_link'));
						$boards->chkIsValidURL('redirect_link', $LANG['redirect_link_not_valid']);
					}
			}
		else
			{
				$boards->setFormField('redirect_link', '');
			}


		if ($boards->isValidFormInputs())
			{
				$boards->addBoard();
				Redirect2URL($CFG['site']['relative_url'].'manageSolutions.php?msg=2&did='.$boards->getFormField('did'));
			}
		else
			{
				$boards->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
				$boards->setPageBlockShow('block_msg_form_error');
				$boards->setPageBlockShow('form_edit');
			}

		$boards->ConditionQuery();
	}
elseif(($boards->isFormGETed($_GET, 'bid') AND $boards->chkIsValidBoard()))
	{
		$boards->setPageBlockShow('form_edit');
		$boards->setFormField('board', $boards->board_details['board']);
		$boards->setFormField('descriptions', $boards->board_details['description']);
		$boards->setFormField('tags', $boards->board_details['tags']);
		$boards->setFormField('visible_to', $boards->board_details['visible_to']);
		$boards->setFormField('publish', $boards->board_details['publish_status']);
		$boards->setFormField('readonly', $boards->board_details['readonly']);
		$boards->setFormField('redirect_link', $boards->board_details['redirect_link']);
		if($boards->board_details['redirect_link']!='')
			{
				$boards->setFormField('isredirect', 'Yes');
			}
		$boards->ConditionQuery();
	}
else
	{
		$boards->ConditionQueryNoSearch();
	}

if ($boards->isFormGETed($_GET, 'msg'))
	{
		$boards->setPageBlockShow('block_msg_form_success');
		if($boards->getFormField('msg') == 2)
			$boards->setCommonSuccessMsg($LANG['board_added_succesfully']);
		else
			$boards->setCommonSuccessMsg($LANG['board_updated_succesfully']);
	}


$boards->buildSortQuery();
$boards->buildQuery();
//$boards->printQuery();
$boards->executeQuery();

if(!$boards->isFormGETed($_GET, 'bid'))
	{
		$boards->setPageBlockShow('list_records');
	}

if($boards->getFormField('mode')== 'search')
	{
		$boards->setAllPageBlocksHide();
		$boards->setPageBlockShow('show_form_search');
		$boards->LANG['member_title'] = $LANG['member_search_title'];
	}
elseif($boards->getFormField('mode')== 'add')
	{
		$boards->setAllPageBlocksHide();
		$LANG['member_edit_title'] = $LANG['member_add_title'];
		if ($boards->isAddMode())
			{
				$boards->setPageBlockShow('form_edit');
			}
	}
$boards->LANG['discuzz_common_tag_size'] = str_ireplace('VAR_MIN_SIZE', $CFG['admin']['tag_min_size'], $boards->LANG['discuzz_common_tag_size']);
$boards->LANG['discuzz_common_tag_size'] = str_ireplace('VAR_MAX_SIZE', $CFG['admin']['tag_max_size'], $boards->LANG['discuzz_common_tag_size']);

//<<<<<<<---------------code ends-------------///
$boards->show_form_confirm['hidden_arr'] = array('start', 'numpg', 'search_name', 'search_cat');

if ($boards->isShowPageBlock('form_edit'))
	{
		$boards->LANG['member_title'] = $LANG['member_edit_title'];
		$boards->form_edit['hidden_arr'] = array('rid', 'f', 'did');

		if ($boards->getFormField('bid'))
			$boards->form_edit['getAttachments_arr'] = $boards->getAttachments();

	      	$allowed_formats = implode(",",$CFG['admin']['attachments']['format_arr']);
			if($allowed_formats == '')
					$allowed_formats = 'jpg,gif,png';
			$allowed_size = $CFG['admin']['attachments']['max_size'];
	      	$boards->form_edit['attach_style'] = '';

		if($boards->solution_attachment_count == $CFG['admin']['attachments_allowed']['count'])
			$boards->form_edit['attach_style'] = 'style="display:none;"';

		$boards->form_edit['attachment_allowed_tip_manual'] = str_ireplace('VAR_COUNT', $CFG['admin']['attachments_allowed']['count'] ,$LANG['attachment_allowed_tip']);
		$boards->form_edit['attachment_format_tip_manual'] = str_ireplace('VAR_FORMAT', $allowed_formats, $LANG['attachment_format_tip']);
		$boards->form_edit['attachment_size_tip_manual'] = str_ireplace('VAR_SIZE', $allowed_size, $LANG['attachment_size_tip']);
		$boards->form_edit['description_manual'] = stripslashes($boards->getFormField('descriptions'));
	}

if ($boards->isShowPageBlock('show_form_search'))
	{
		$boards->populateSearchOptions_arr = $boards->populateSearchOptions();
	}

if ($boards->isShowPageBlock('list_records'))
	{
		$boards->list_records_confirm_arr = array('start', 'numpg', 'did', 'orderby_field', 'orderby');
		if($boards->isFormPOSTed($_GET, 'search_cat'))
			{
				$boards->paging_arr = array('search_cat', 'search_name', 'did', 'orderby_field', 'orderby');
			}

		$smartyObj->assign('smarty_paging_list', $boards->populatePageLinksGET($boards->getFormField('start'), $boards->paging_arr));
		$tab = 4000;

		if($boards->isResultsFound())
			{
				$boards->list_records = array();
				$inc = 1;
				while($boards->fetchResultRecord())
					{
						$boards->list_records[$inc]['board_id'] = $boards->getColumnValue('board_id');
						$boards->list_records[$inc]['board_manual'] = wordWrapManual($boards->getColumnValue('board'), 25);
						$boards->list_records[$inc]['display_name_manual'] = stripString($boards->getColumnValue('display_name'), $CFG['username']['short_length']);
						$boards->list_records[$inc]['tags'] = $boards->getColumnValue('tags');
						$boards->list_records[$inc]['total_solutions'] = $boards->getColumnValue('total_solutions');
						$boards->list_records[$inc]['abuse_count'] = $boards->getColumnValue('abuse_count');
						$boards->list_records[$inc]['status'] = $boards->getColumnValue('status');
						$boards->list_records[$inc]['board_added'] = $boards->getColumnValue('board_added');
						$boards->list_records[$inc]['featured'] = $boards->getColumnValue('featured');
						$inc++;
				   	}
			}
		$boards->action_arr = array("active_board" => $LANG['discuzz_common_activate'], "Inactive_board" => $LANG['discuzz_common_inactivate'],
									"delete_board" => $LANG['discuzz_common_delete'], "abuse_board" => $LANG['discuzz_common_abuse'],
									"publish_board" => $LANG['discuzz_common_publish'], "feature_board" => $LANG['set_featured'],
									"remove_feature" => $LANG['remove_from_featured']);
	}

//-----------------Page block template begins-------->>>>///
//include the header file
$boards->includeHeader();
//include the content of the page
?>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>tools/bbcode/ed.js"></script>
<?php
setTemplateFolder('admin/', $CFG['admin']['index']['home_module']);
$smartyObj->display('manageSolutions.tpl');
?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm', 'selDelInfoconfirm');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['please_select_action'];?>';
	var confirm_message = '';
	function getAction()
		{
			var act_value = document.selManageSolutionForm.action.value;
			if(act_value)
				{
					switch(act_value)
						{
							case 'block_board':
								confirm_message = '<?php echo $LANG['are_you_sure_want_to_block_the_board'];?>';
								break;
							case 'unblock_board':
								confirm_message = '<?php echo $LANG['are_you_sure_want_to_unblock_the_board'];?>';
								break;
							case 'active_board':
								confirm_message = '<?php echo $LANG['are_you_sure_want_to_activate_the_board'];?>';
								break;
							case 'Inactive_board':
								confirm_message = '<?php echo $LANG['are_you_sure_want_to_inactive_the_board'];?>';
								break;
							case 'delete_board':
								confirm_message = '<?php echo $LANG['are_you_sure_want_to_delete_the_board'];?>';
								break;
							case 'abuse_board':
								confirm_message = '<?php echo $LANG['are_you_sure_want_to_abuse_the_board'];?>';
								break;
							case 'publish_board':
								confirm_message = '<?php echo $LANG['are_you_sure_want_to_publish_the_board'];?>';
								break;
							case 'feature_board':
								confirm_message = '<?php echo $LANG['are_you_sure_want_to_feature_the_board'];?>';
								break;
							case 'remove_feature':
								confirm_message = '<?php echo $LANG['are_you_sure_want_to_remove_the_feature'];?>';
								break;
						}
					$Jq('#msgConfirmText').html(confirm_message);
					document.msgConfirmform.action.value = act_value;
					document.msgConfirmform.act.value = '';
					Confirmation('selMsgConfirm', 'msgConfirmform', Array('board_ids'), Array(multiCheckValue), Array('value'));
				}
				else{
						alert_manual(please_select_action);
					}
		}
</script>
<script language="javascript"  type="text/javascript" >
	var removeId = 0;
	function add_more_upload(lang) {

		var id = removeId++;
		var ptags = $Jq('p', '#tdID');
		var len = ptags.length;

		if(len > <?php echo $CFG['admin']['attachments_allowed']['count']+1;?>)
			$Jq('#brsBtn').css('display', 'none');

		if(len > <?php echo $CFG['admin']['attachments_allowed']['count']+2;?>)
			return;

		var rowTemplate = '<p id="p_'+id+'"><input type="file" name="attachments[]" value=""> <a href="#" onClick="removeThis('+id+');">'+lang+'<\/a><\/p>';

		//new Insertion.Before('brsBtn', rowTemplate);
		$Jq('#brsBtn').before(rowTemplate);
	}

	function removeThis(id)	{
		var remId = id;
		$Jq('#p_'+remId).remove();
		$Jq('$brsBtn').css('display', '');
	}
</script>
<?php
if ($boards->isShowPageBlock('form_edit'))
	{
?>
<script language="javascript" type="text/javascript" defer="defer">
		var swfu;
		swfu = new SWFUpload({
			// Backend Settings
			upload_url: "<?php echo $CFG['site']['url'].$CFG['admin']['index']['home_module'];?>/upload.php",
			post_params: {"PHPSESSID": "<?php echo session_id();?>"},

			// File Upload Settings
			file_size_limit : "<?php echo $CFG['admin']['attachments']['max_size'];?>",	// 2MB
			file_types : "<?php echo $req_settings;?>",
			file_types_description : "File Types ",
			file_upload_limit : "<?php echo $CFG['admin']['attachments_allowed']['count'];?>",

			// Event Handler Settings - these functions as defined in Handlers.js
			//  The handlers are not part of SWFUpload but are part of my website and control how
			//  my website reacts to the SWFUpload events.
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,

			// Button Settings
			button_image_url : "images/SmallSpyGlassWithTransperancy_17x18.png",
			button_placeholder_id : "spanButtonPlaceholder",
			button_width: 200,
			button_height: 18,
			button_text : '<span class="button"><?php echo $LANG['discuzz_common_choose_files'];?><span class="buttonSmall"></span></span>',
			button_text_style : '.button { text-align:center; font-family: Helvetica, Arial, sans-serif; font-size: 12pt; font-weight:bold;} .buttonSmall { font-size: 10pt; }',
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor: SWFUpload.CURSOR.HAND,

			// Flash Settings
			flash_url : "<?php echo $CFG['site']['url'].$CFG['admin']['index']['home_module'];?>/js/swfupload/swfupload.swf",

			custom_settings : {
				upload_target : "divFileProgressContainer"
			},

			// Debug Settings
			debug: false
		});
</script>
<?php
	}
?>
<?php
if((count($boards->getFormField('uplarr')) != 0 ) && $boards->isShowPageBlock('form_edit'))
	{

	?>

		<script language="javascript" type="text/javascript">
			var required_array =  new Array();
			var required_ori_array =  new Array();
			var i = 0;
			var j= 0;
		</script>
		<?php
		$upl_count  =  count($boards->getFormField('uplarr'));
		$req_uploaded_array = $boards->getFormField('uplarr');
		$req_ori_uploaded_array = $boards->getFormField('upl_original');
		foreach ($req_uploaded_array as $value)
			{

			  ?>
			  	<script language="javascript" type="text/javascript">
					 required_array[i] = "<?php echo $value;?>";
					 i++;
				</script>
			  <?php
			}
		foreach ($req_ori_uploaded_array as $value)
			{

			  ?>
			  	<script language="javascript" type="text/javascript">
					 required_ori_array[j] = "<?php echo $value;?>";
					 j++;
				</script>
			  <?php
			}



		?>
			<script language="javascript" type="text/javascript">
				function checkElementPresent()
						{
							var thumbnails = document.getElementById("thumbnails");
							items = thumbnails.getElementsByTagName("img");
							if(items.length == 0)
								{
		                             var req_upl = '<?php echo $upl_count;?>';
									 for(i =0;i<req_upl;i++)
									 	{
											addImage(required_array[i]);
											addHiddenElement(required_array[i]);
											addHiddenElementForName(required_ori_array[i] , required_array[i])

										}
								}

						}
				checkElementPresent();
			</script>
		<?php
	}
//<<<<<<<<<---------Page block template ends--------------------------//
$boards->includeFooter();
?>
