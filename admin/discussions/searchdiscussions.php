<?php
//--------------class DiscussionsFormHandler--------------->>>//
/**
 * @category	Discuzz
 * @package		DiscussionsFormHandler
 * @author 		shankar_76ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2008-12-22
 **/
require_once('../../common/configs/config.inc.php'); //configurations

$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/admin/discussions.php';
$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/email_notify.inc.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';

$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_DiscussionHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_DiscussionsActivityHandler.lib.php';

if ($_POST)
	$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require_once($CFG['site']['project_path'] . 'common/application_top.inc.php');

/**
 * DiscussionsFormHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2009 - 2010
 * @version $Id$
 * @access public
 */
class DiscussionsFormHandler extends DiscussionHandler
	{
		public $paging_arr = array();
		public $category_titles;
		public $allCategories_arr;
		public $valid_subcategory_array;

		/**
		 * set the condition
		 *
		 * @access public
		 * @return void
		 **/
		public function buildConditionQuery($condition='1')
			{
				$this->sql_condition = 'u.'.$this->getUserTableField('user_status').'=\'Ok\'';

				if($this->fields_arr['discussion_title'])
					{
						$this->sql_condition .= ' AND ('.getSearchRegularExpressionQuery($this->fields_arr['discussion_title'], 'd.discussion_title').')';
						$this->paging_arr[] = 'discussion_title';
					}

				if ($this->fields_arr['dname'])
					{
						$this->sql_condition .= ' AND ('.getSearchRegularExpressionQuery($this->fields_arr['dname'], 'u.'.$this->getUserTableField('display_name')).')';
						$this->paging_arr[] = 'dname';
					}
				if($this->fields_arr['discussion_category'] && $this->fields_arr['discussion_category']!='EMPTY')
					{
						$this->paging_arr[] = 'discussion_category';
						$search_arr = explode('#', $this->fields_arr['discussion_category']);

						if(isset($search_arr[1]) AND $search_arr[1]!=0)
							{
								$sub_cat_id = $search_arr[1];
								$this->valid_subcategory_array[] = $sub_cat_id;
								//echo "<br>--->".$sub_cat_id;
								$this->getSubCategoriesList($sub_cat_id);
								$sub_cat_ids = implode(",", $this->valid_subcategory_array);
								$this->sql_condition .= ' AND d.pcat_id IN ('.$sub_cat_ids.') ';
							}
						else{
								$search_arr = explode(',', $this->fields_arr['discussion_category']);
								if(isset($search_arr[1]) AND $search_arr[1]!=0)
									$this->sql_condition .= ' AND d.discussion_id='.$search_arr[1];
						}
					}


				$date_condtion = '';
				switch($this->fields_arr['date_limits_to'])
					{
						case $this->LANG['search_option_today']:
							$date_condtion = 'date( d.date_added ) = date( now( ) )';
							break;
						case $this->LANG['search_option_oneday']:
							$date_condtion = 'DATE_ADD(d.date_added, INTERVAL 1 DAY) >= NOW()';
							break;
						case $this->LANG['search_option_oneweek']:
							$date_condtion = 'DATE_ADD(d.date_added, INTERVAL 7 DAY) >= NOW()';
							break;
						case $this->LANG['search_option_onemonth']:
							$date_condtion = 'DATE_ADD(d.date_added, INTERVAL 1 MONTH) >= NOW()';
							break;
						case $this->LANG['search_option_threemonths']:
							$date_condtion = 'DATE_ADD(d.date_added, INTERVAL 3 MONTH) >= NOW()';
							break;
						case $this->LANG['search_option_sixmonths']:
							$date_condtion = 'DATE_ADD(d.date_added, INTERVAL 6 MONTH) >= NOW()';
							break;
						case $this->LANG['search_option_oneyear']:
							$date_condtion = 'DATE_ADD(d.date_added, INTERVAL 1 YEAR) >= NOW()';
							break;
					}

				$this->paging_arr[] = 'date_limits_to';
				if($date_condtion!='') $this->sql_condition .= ' AND '.$date_condtion;

			}
		public function getSubCategoriesList($cat_id)
			{
				$sql = 'SELECT cat_id FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE parent_id = '.$this->dbObj->Param('cat_id').
						' AND status = \'Active\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$cat_id = $row['cat_id'];
								$this->valid_subcategory_array[] = $cat_id;
								$this->getSubCategoriesList($row['cat_id']);
							}
					}
			}
		/**
		 * To sort the query
		 *
		 * @access public
		 * @return void
		 **/
		public function checkSortQuery($field, $sort='asc')
			{
				if(!($this->sql_sort))
					{
						$this->sql_sort = ' '.$field . ' ' . $sort;
					}
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getUnpublishedBoards($discussion_id)
			{
				$sql = 'SELECT count(board_id) as total_unpublished_boards '.
						'FROM '.$this->CFG['db']['tbl']['boards'].' '.
						'WHERE discussion_id = '.$this->dbObj->Param($discussion_id).' '.
						'AND status = \'ToActivate\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($discussion_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				return $row;
			}

		/**
		 * DiscussionsFormHandler::deleteDiscussionTitles()
		 *
		 * @return
		 */
		public function deleteDiscussionTitles()
			{
				$discussion_ids = $this->fields_arr['discussion_ids'];
				$this->deleteDiscussionsTable($discussion_ids);
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
				$sql = 'SELECT board_id, user_id, best_solution_id, status, total_solutions FROM '.$this->CFG['db']['tbl']['boards'].
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
		 * DiscussionsFormHandler::activateDiscussionTitles()
		 *
		 * @return
		 */
		public function activateDiscussionTitles()
			{
				$discussion_ids = $this->fields_arr['discussion_ids'];

				//Get discussion_id, pcat_id then decrease the total_discussion count in category table..
				$res_sql = 'SELECT discussion_id, status, pcat_id FROM '.$this->CFG['db']['tbl']['discussions'].
							' WHERE discussion_id IN ('.$discussion_ids.') AND status=\'Inactive\'';
				$res_stmt = $this->dbObj->Prepare($res_sql);
				$res_rs = $this->dbObj->Execute($res_stmt);
				if (!$res_rs)
					trigger_db_error($this->dbObj);

				if (!$res_rs->PO_RecordCount())
					return ;

				while ($row = $res_rs->FetchRow()){
					$ub_sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
								' SET total_discussions=total_discussions+1'.
								' WHERE cat_id ='.$row['pcat_id'];
					$ub_stmt = $this->dbObj->Prepare($ub_sql);
					$ub_rs = $this->dbObj->Execute($ub_stmt);
					if (!$ub_rs)
						trigger_db_error($this->dbObj);
				}

				//Activate boards and increase users board logs
				$discussion_ids_new = $this->getDiscussionsOfActiveCategory($discussion_ids);
				$this->updateBoaardAndSolutions($discussion_ids_new, 'Active');

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].' SET status = \'Active\' '.
						'WHERE discussion_id IN ('.$discussion_ids.') AND status = \'Inactive\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				return true;
			}

		/**
		 * DiscussionsFormHandler::inactivateDiscussionTitles()
		 *
		 * @return
		 */
		public function inactivateDiscussionTitles()
			{
				$discussion_ids = $this->fields_arr['discussion_ids'];

				//Get discussion_id, pcat_id then decrease the total_discussion count in category table..
				$res_sql = 'SELECT discussion_id, status, pcat_id FROM '.$this->CFG['db']['tbl']['discussions'].
							' WHERE discussion_id IN ('.$discussion_ids.') AND status=\'Active\'';
				$res_stmt = $this->dbObj->Prepare($res_sql);
				$res_rs = $this->dbObj->Execute($res_stmt);
				if (!$res_rs)
					trigger_db_error($this->dbObj);

				if (!$res_rs->PO_RecordCount())
					return ;

				while ($row = $res_rs->FetchRow()){
					$ub_sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
								' SET total_discussions=total_discussions-1'.
								' WHERE cat_id ='.$row['pcat_id'];
					$ub_stmt = $this->dbObj->Prepare($ub_sql);
					$ub_rs = $this->dbObj->Execute($ub_stmt);
					if (!$ub_rs)
						trigger_db_error($this->dbObj);
				}

				//Inactivate boards and decrease users board logs
				$discussion_ids_new = $this->getDiscussionsOfActiveCategory($discussion_ids);
				$this->updateBoaardAndSolutions($discussion_ids_new, 'Inactive');

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].' SET status = \'Inactive\' '.
						'WHERE discussion_id IN ('.$discussion_ids.') AND status = \'Active\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
			    	trigger_db_error($this->dbObj);

				return true;
			}
		/**
		 * DiscussionsFormHandler::getDiscussionsOfActiveCategory()
		 *
		 * @return
		 */

		public function getDiscussionsOfActiveCategory($discussion_ids)
			{
				$sql = 'SELECT d.discussion_id FROM '.$this->CFG['db']['tbl']['discussions'].' As d, '.$this->CFG['db']['tbl']['category'].' As c'.
						' WHERE d.pcat_id=c.cat_id AND d.discussion_id IN ('.$discussion_ids.')'.
						' AND c.status=\'Active\'';
								$stmt = $this->dbObj->Prepare($sql);

				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
			    	trigger_db_error($this->dbObj);

				$discussion_ids_new = array();
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$discussion_ids_new[] = $row['discussion_id'];
							}
							$discussion_ids = implode(',', $discussion_ids_new);
						return $discussion_ids;
					}
				else return 0;
			}
		/**
		 * DiscussionsFormHandler::publishDiscussionTitles()
		 *
		 * @return
		 */
		public function publishDiscussionTitles()
			{
				$discussion_ids = $this->fields_arr['discussion_ids'];
				$sql = 'SELECT f.user_id, '.$this->getUserTableField('display_name').' as display_name, '.$this->getUserTableField('email').' as email'.
						', f.discussion_id, f.discussion_title, f.seo_title, f.description'.
						' FROM '.$this->CFG['db']['tbl']['discussions'].
						' as f LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
						' ON f.user_id = u.'.$this->CFG['users']['user_id'].
						' WHERE status=\'ToActivate\' AND discussion_id IN('.$discussion_ids.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				while($row = $rs->FetchRow())
					{
						$this->sendPublishedMailAlert($row['email'], $row['display_name'], $row['discussion_title'], $row['seo_title'], $row['description']);
						//Add Activity
						if($this->CFG['admin']['index']['activity']['show'])
							{
								$activity_arr['action_key'] = 'publish_discussion';
								$activity_arr['owner_id'] = $row['user_id'];
								$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
								$activity_arr['discussion_id'] = $row['discussion_id'];
								$this->discussionsActivityObj->addActivity($activity_arr);
							}
					}
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].' SET status = \'Active\' '.
						'WHERE discussion_id IN ('.$discussion_ids.') AND status = \'ToActivate\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				return true;
			}

		/**
		 * DiscussionsFormHandler::sendPublishedMailAlert()
		 *
		 * @param mixed $toEmail
		 * @param mixed $reciever_name
		 * @param mixed $content
		 * @param mixed $content_seo
		 * @param mixed $content_description
		 * @return
		 */
		public function sendPublishedMailAlert($toEmail, $reciever_name, $content, $content_seo, $content_description)
			{
				$site_link = "<a target=\"_blank\" href=\"".URL($this->CFG['site']['url'])."\">".URL($this->CFG['site']['url'])."</a>";
				$url_link = getUrl('boards', '?title='.$content_seo, $content_seo.'/', 'root', $this->CFG['admin']['index']['home_module']);
				$forum_link = "<a target=\"_blank\" href=\"".$url_link."\"><strong>".$content."</strong></a>";
				$subject = $this->getMailContent($this->LANG['discussion_publish_subject'], array('VAR_USERNAME'=>$reciever_name, 'VAR_SITENAME'=>$this->CFG['site']['name'], 'VAR_DESCRIPTION_OF_DISCUSSION'=>$content_description, 'VAR_DISCUSSION'=>$forum_link, 'VAR_LINK'=>$site_link));
				$content = $this->getMailContent($this->LANG['discussion_publish_message'], array('VAR_USERNAME'=>$reciever_name, 'VAR_SITENAME'=>$this->CFG['site']['name'], 'VAR_DESCRIPTION_OF_DISCUSSION'=>$content_description, 'VAR_DISCUSSION'=>$forum_link, 'VAR_LINK'=>$site_link));
				$this->_sendMail($toEmail, $subject, $content, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
			}

		/**
		 * To display the discussions titles
		 *
		 * @access public
		 * @return void
		 **/
		public function showDiscussionTitles()
			{
				while ($row = $this->fetchResultRecord())
					{
						//$row['discussionBoards']['url'] = getUrl('boards', '?title='.$row['seo_title'], $row['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']);
						$row['discussionBoards']['url'] = 'manageSolutions.php?did='.$row['discussion_id'];
						$row['discussionBoards']['title'] = wordWrapManual($row['discussion_title'], 15);
						$row['discussion_description_manual'] = nl2br(wordWrapManual($row['description'], 15));
						$row['myanswers']['url'] = $this->CFG['site']['url'].'admin/viewMembers.php?uid='.$row['user_id'];
						$row['lastPost']['url'] = $this->CFG['site']['url'].'admin/viewMembers.php?uid='.$row['last_post_user_id'];
						$row['edit']['url'] = 'addDiscussionTitle.php?did='.$row['discussion_id'];
						$row['delete']['url'] = 'discussions.php?delid='.$row['discussion_id'];
						$row['last_post_name1'] = stripString($row['last_post_name'], 20);
						$row['category_name'] = '<a href="discussionCategory.php?mode=viewsubcategory&cat_id='.$row['pcat_id'].'">'.$this->getCategoryName($row['pcat_id']).'</a>';
						if($row['user_id'] == $this->CFG['user']['user_id'] and ($this->fields_arr['my']))
							{
								$publish_details = $this->getUnpublishedBoards($row['discussion_id']);
								$row['discussions_unpublished_boards']['content'] = $this->LANG['unpublished_boards'].' : <a href="'.getUrl('boards', '?title='.$row['seo_title'].'&unpublished=1', $row['seo_title'].'/?unpublished=1', '', $this->CFG['admin']['index']['home_module']).'">'.$publish_details['total_unpublished_boards'].'</a>';
							}
						$row['action_text'] = $this->LANG['discuzz_common_publish'];
						$row['action_link'] = 'Publish';
						$row['confirm_msg'] = $this->LANG['discussions_publish_confirm_message'];
						if($row['status'] == 'Inactive')
							{
								$row['action_text'] = $this->LANG['discuzz_common_activate'];
								$row['action_link'] = 'Active';
								$row['confirm_msg'] = $this->LANG['discussions_active_confirm_message'];
							}
						else if($row['status'] == 'Active')
							{
								$row['action_text'] = $this->LANG['discuzz_common_inactivate'];
								$row['action_link'] = 'Inactive';
								$row['confirm_msg'] = $this->LANG['discussions_inactive_confirm_message'];
							}
						$discussion_titles[] = $row;
				}

				return $discussion_titles;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getCategoryName($cat_id)
			{
				$sql = 'SELECT cat_name, parent_id, seo_title FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE cat_id = '.$this->dbObj->Param($cat_id).
						' AND status = \'Active\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$cat_name = '';
				$category_info = array();
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$cat_name = $row['cat_name'];
						$category_info['cat_name'] = $cat_name;
						$category_info['cat_url'] = $cat_name;
						$this->category_titles[] = $category_info;
						if($row['parent_id'] > 0)
							$this->getCategoryTitles($row['parent_id']);
					}
				return $cat_name;
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
		public function fetchAllCategories()
			{
				$sql = 'SELECT cat_id, cat_name FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE status=\'Active\' AND parent_id=0'.
						' ORDER BY cat_name ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$category_info = array();
				$tab = 1;
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$category_info['search_text'] = '';
								$category_info['search_value'] = 'EMPTY';
								$category_info['tab'] = 0;
								$this->allCategories_arr[] = $category_info;
								$category_info['search_text'] = stripString($row['cat_name'], 40);
								$category_info['search_value'] = $row['cat_id']."#".$row['cat_id'];
								$category_info['tab'] = 0;
								$this->allCategories_arr[] = $category_info;
								$this->fetchSubCategories($row['cat_id'], $tab);
								//$this->fetchDiscussionTitles($row['cat_id'], $tab);
							}
					}
			}
		public function fetchSubCategories($cat_id, $tab=0)
			{
				$sql = 'SELECT cat_id, cat_name FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE status=\'Active\' AND parent_id='.$this->dbObj->Param($cat_id).
						' ORDER BY cat_name ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$category_info = array();
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$category_info['search_text'] = stripString($row['cat_name'], 40);
								$category_info['search_value'] = $cat_id."#".$row['cat_id'];
								$category_info['tab'] = $tab;
								$this->allCategories_arr[] = $category_info;
								$this->fetchSubCategories($row['cat_id'], $tab+1);
								//$this->fetchDiscussionTitles($row['cat_id'], $tab+1);
							}
					}
			}
		public function fetchDiscussionTitles($cat_id, $tab=0)
			{
				$sql = 'SELECT discussion_id, discussion_title FROM '.$this->CFG['db']['tbl']['discussions'].
						' WHERE status=\'Active\' AND pcat_id='.$this->dbObj->Param($cat_id).
						' ORDER BY discussion_title ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$category_info = array();
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$category_info['search_text'] = stripString($row['discussion_title']);
								$category_info['search_value'] = $cat_id.",".$row['discussion_id'];
								$category_info['tab'] = $tab;
								$this->allCategories_arr[] = $category_info;
							}
					}
			}
	}
//<<<<<<<--------------class DiscussionsFormHandler---------------//

//--------------------Code begins-------------->>>>>//
//echo '<pre>';print_r($_POST);echo '</pre>';
$discussions = new DiscussionsFormHandler();
if($CFG['admin']['index']['activity']['show'])
	{
		$DiscussionsActivity = new DiscussionsActivityHandler();
		$discussions->discussionsActivityObj = $DiscussionsActivity;
	}

if(!chkIsAllowedModule(array($CFG['admin']['index']['home_module'])))
	Redirect2URL(getUrl($CFG['redirect']['dsabled_module_url']['file_name']));
$discussions->setPageBlockNames(array('form_show_discussions', 'form_confirm', 'form_show_search'));

$discussions->setAllPageBlocksHide();

//default form fields and values...
$discussions->setFormField('discussion_ids', array());
$discussions->setFormField('my', '');
$discussions->setFormField('action', '');
$discussions->setFormField('cat', '');
$discussions->setFormField('msg', '');

$discussions->setFormField('dname', '');
$discussions->setFormField('cat_id', '');
$discussions->setFormField('delid', '');
$discussions->setFormField('discussion_title', '');
$discussions->setFormField('discussion_category', '');
$discussions->setFormField('date_limits_to', '');

$discussions->setFormField('numpg',0);
$discussions->setFormField('start',0);
$discussions->setFormField('prev_numpg',0);//To retain the last numpg
/***********set form field for navigation****/
$discussions->setFormField('asc', '');
$discussions->setFormField('dsc', 'd.date_added');
/*************Start navigation******/
//fetch number of records show in the result--numpg
$condition = $discussions->alter_link = '';
$discussions->LANG['discussions_pagetitle'] = $LANG['discussions_title_index'];
$discussions->page_title = $LANG['discussion_search_discussion'];
$discussions->setPageBlockShow('form_show_search');

if(isMember())
	{
		$discussions->alter_link = '<a href="'.getUrl('discussions', '?my=1', '?my=1', 'members', $CFG['admin']['index']['home_module']).'">'.$LANG['discussions_mytitles'].'</a>';
	}

$discussions->numpg = $CFG['data_tbl']['numpg'];
$discussions->setFormField('start', 0);
$discussions->setFormField('numpg', $CFG['data_tbl']['numpg']);

$discussions->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$discussions->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$discussions->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
//Set tables and fields to return
$discussions->setTableNames(array());
$discussions->setReturnColumns(array());
/*************End navigation******/
$discussions->setPageBlockShow('form_show_discussions'); //default page block. show it. All others hidden
$discussions->searchOption_arr = array($LANG['search_option_allresult'] => $LANG['search_option_allresult'],
			  $LANG['search_option_today'] => $LANG['search_option_today'],
			  $LANG['search_option_oneday'] => $LANG['search_option_oneday'],
			  $LANG['search_option_oneweek'] => $LANG['search_option_oneweek'],
			  $LANG['search_option_onemonth'] => $LANG['search_option_onemonth'],
			  $LANG['search_option_threemonths'] => $LANG['search_option_threemonths'],
			  $LANG['search_option_sixmonths'] => $LANG['search_option_sixmonths'],
			  $LANG['search_option_oneyear'] => $LANG['search_option_oneyear']);
$discussions->populateCategories_arr = $discussions->populateCategories('admin');
$discussions->advanced_search_action = 'searchdiscussions.php?so=adv';
/*************Start navigation******/
$discussions->setTableNames(array($CFG['db']['tbl']['discussions'].' as d LEFT JOIN '.$CFG['db']['tbl']['users'].' AS u on d.user_id = u.'.$discussions->getUserTableField('user_id').' LEFT JOIN '.$CFG['db']['tbl']['category'].' AS c on d.pcat_id = c.cat_id LEFT JOIN '.$CFG['db']['tbl']['users'].' AS lp on d.last_post_user_id = lp.'.$discussions->getUserTableField('user_id')));
$discussions->setReturnColumns(array('d.discussion_title', 'd.discussion_id', 'd.user_id', 'd.pcat_id', 'd.last_post_user_id', 'c.cat_name', 'u.'.$discussions->getUserTableField('name').' AS name', 'd.seo_title', 'd.description', 'd.total_boards', 'd.status', 'd.total_solutions', 'd.publish_status', 'DATE_FORMAT(d.last_post_date, \''.$CFG['mysql_format']['date_time_meridian'].'\') as last_post_date', 'lp.'.$discussions->getUserTableField('name').' AS last_post_user', 'lp.'.$discussions->getUserTableField('display_name').' as last_post_name', 'u.'.$discussions->getUserTableField('name').' AS post_user', 'u.'.$discussions->getUserTableField('display_name').' as post_name', 'DATE_FORMAT(d.last_post_date, \''.$discussions->CFG['mysql_format']['new_date'].'\') AS last_post_date_only', 'DATE_FORMAT(d.last_post_date, \'%h:%m %p\') AS last_post_time_only'));
//Condition of the query
$discussions->sanitizeFormInputs($_REQUEST);

if ($discussions->isFormPOSTed($_POST, 'confirm_action'))
	{
		$discussions->chkIsNotEmpty('discussion_ids', $LANG['err_tip_compulsory'])or
		$discussions->setCommonErrorMsg($LANG['discussions_err_tip_select_titles']);
		$discussions->chkIsNotEmpty('action', $LANG['err_tip_compulsory'])or
		$discussions->setCommonErrorMsg($LANG['err_tip_select_action']);
		if ($discussions->isValidFormInputs())
			{
			 	switch($discussions->getFormField('action'))
					 {
				 		case 'Delete':
							$discussions->deleteDiscussionTitles();
							$discussions->setCommonSuccessMsg($LANG['discussions_success_delete_message']);
							break;

						case 'Active':
							$discussions->activateDiscussionTitles();
							$discussions->setCommonSuccessMsg($LANG['discussions_success_active_message']);
							break;

						case 'Inactive':
							$discussions->inactivateDiscussionTitles();
							$discussions->setCommonSuccessMsg($LANG['discussions_success_inactive_message']);
							break;

						case 'Publish':
							$discussions->publishDiscussionTitles();
							$discussions->setCommonSuccessMsg($LANG['discussions_success_published_message']);
							break;
						case 'deleteDiscussion':
							$discussions->deleteDiscussionsTable($discussions->getFormField('discussion_ids'));
							$discussions->setCommonSuccessMsg($LANG['discussions_success_delete_message']);
							break;


				 	} // switch
				$discussions->setFormField('discussion_ids', array());
				$discussions->setPageBlockShow('block_msg_form_success');
			}
		else //error in form inputs
			{
				$discussions->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
				$discussions->setPageBlockShow('block_msg_form_error');
			}
	}


//if ($discussions->isFormPOSTed($_GET, 'mode'))
	{
		//$discussions->setAllPageBlocksHide();
		$discussions->setPageBlockShow('form_show_search');
		$discussions->LANG['discussions_pagetitle'] = $LANG['discussions_seach_title'];
		$discussions->form_advanced_search_arr['discussionCategories_arr'] = $discussions->fetchAllCategories();
	}

if($CFG['admin']['discussions']['order'] == 'ASC')
	{
		$discussions->setFormField('asc', 'd.date_added');
	}

$discussions->sanitizeFormInputs($_REQUEST);
$discussions->buildSelectQuery();
$discussions->buildConditionQuery($condition);
$discussions->buildSortQuery();
$discussions->checkSortQuery('d.discussion_id', 'DESC');
$discussions->buildQuery();
//$discussions->printQuery();
$discussions->executeQuery();
/*************End navigation******/
$discussions->discussionsAddTitle_url = 'addDiscussionTitle.php';
$discussions->login_url = getUrl('login', '?light_url='.$discussions->discussionsAddTitle_url, '?light_url='.$discussions->discussionsAddTitle_url, 'root');
if ($discussions->isFormPOSTed($_GET, 'msg'))
	{
		switch($discussions->getFormField('msg')){
			case 'success':
				$discussions->setCommonSuccessMsg($LANG['discussions_title_created_successfully']);
				break;
			case 'update':
				$discussions->setCommonSuccessMsg($LANG['discussions_title_updated_successfully']);
				break;
		} // switch
		$discussions->setPageBlockShow('block_msg_form_success');
	}
//<<<<--------------------Code Ends----------------------//
$CFG['site']['title'] = $discussions->LANG['discussions_pagetitle'].' - '.$CFG['site']['title'];
//--------------------Page block templates begins-------------------->>>>>//
$discussions->hidden_arr =  array('orderby_field', 'orderby');

if ($discussions->isShowPageBlock('form_show_discussions'))
	{
		if ($discussions->isResultsFound())
			{
				$discussions->form_show_discussions_arr = $discussions->showDiscussionTitles();
				$discussions->form_show_forums['action_arr'] = array("Active" => $LANG['discuzz_common_activate'],
					                        					"Inactive" => $LANG['discuzz_common_inactivate'], "Delete" => $LANG['discuzz_common_delete'],
					                        					"Publish" => $LANG['discuzz_common_publish']);
				$discussions->form_show_forums['anchor'] = 'dAltMlti';
				$discussions->form_show_forums['hidden_arr'] = array('start', 'so', 'date_limits_to', 'discussion_title', 'dname', 'cat_id', 'orderby_field', 'orderby');
			}
		$discussions->paging_arr[] = 'start';
		$discussions->paging_arr[] = 'orderby_field';
		$discussions->paging_arr[] = 'orderby';

		$smartyObj->assign('paging_arr', $discussions->paging_arr);
		$smartyObj->assign('smarty_paging_list', $discussions->populatePageLinksPOST($discussions->getFormField('start'), 'discussionsFrm'));

		//$smartyObj->assign('smarty_paging_list', $discussions->populatePageLinksGET($discussions->getFormField('start'), $discussions->paging_arr));
	}

//include the header file
$discussions->includeHeader();
//include the content of the page
setTemplateFolder('admin/', $CFG['admin']['index']['home_module']);
$smartyObj->display('searchdiscussions.tpl');
?>
<script language="javascript" type="text/javascript">
	var block_arr= new Array('selMsgConfirm');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction()
		{
			var act_value = document.selFormForums.action.value;
			if(act_value)
				{
					switch (act_value)
						{
							case 'Delete':
								confirm_message = '<?php echo $LANG['discussions_delete_confirm_message'];?>';
								break;
							case 'Active':
								confirm_message = '<?php echo $LANG['discussions_active_confirm_message'];?>';
								break;
							case 'Inactive':
								confirm_message = '<?php echo $LANG['discussions_inactive_confirm_message'];?>';
								break;
							case 'Publish':
								confirm_message = '<?php echo $LANG['discussions_publish_confirm_message'];?>';
								break;
						}
					$Jq('#confirmMessage').html(confirm_message);
					document.msgConfirmform.action.value = act_value;
					Confirmation('selMsgConfirm', 'msgConfirmform', Array('forum_ids'), Array(multiCheckValue), Array('value'));
				}
				else
					alert_manual(please_select_action);
		}
</script>
<?php
//<<<<<<--------------------Page block templates Ends--------------------//
//include the footer of the page
$discussions->includeFooter();
?>