<?php
/**
 * List all boards
 *
 * PHP version 5.0
 *
 * @category	Discuzz
 * @package		SolutionFormHandler
 * @author 		shankar_76ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:
 * @since 		2008-12-22
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('../../common/configs/config.inc.php');

$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/admin/viewSolutions.php';
$CFG['lang']['include_files'][] = 'languages/%s/'.$CFG['admin']['index']['home_module'].'/email_notify.inc.php';

$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';

$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_DiscussionHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_DiscussionsActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'tools/bbcode/nbbc.php';

if ($_POST)
	$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * File to include the header file, database access file, session management file, help file and necessary functions
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');

//-------------- Class SolutionFormHandler begins --------------->>>>>//
class SolutionFormHandler extends DiscussionHandler
	{
		public $board_repliesArray = array();
		public $navigation_array = array();
		public $solution_attachment_count = 0;
		public $category_titles;

		/**
		 * SolutionFormHandler::deleteBoard()
		 *
		 * @return
		 */
		public function deleteBoard($users_board_log_table)
			{
				$board_user_id ='';
				$this->deleteBoardsComment();

				//select user_id to decrease board count and point
				$sql = 'SELECT user_id, board_id, status, best_solution_id, total_solutions, tags FROM '.$this->CFG['db']['tbl']['boards'].
						' WHERE board_id='.$this->dbObj->Param('bid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				if (!$rs->PO_RecordCount())
					return ;

				$row = $rs->FetchRow();
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


						$sql = 'SELECT user_id, solution_id, status FROM '.$this->CFG['db']['tbl']['solutions'].
								' WHERE board_id='.$this->dbObj->Param('bid');
						$stmt = $this->dbObj->Prepare($sql);
						$rs_sol = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
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

						if ($row['best_solution_id'] AND $row['status'] == 'Active' AND $this->discussion_details['status'] == 'Active' AND $this->checkDiscussionCategoryActive($this->discussion_details['discussion_id']))
							$this->decreaseBestSolutionCount($row['best_solution_id']);

						//Delete solutions
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['solutions'].' WHERE board_id='.$this->dbObj->Param('bid');
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
						if (!$rs)
							    trigger_db_error($this->dbObj);
					}

				//to delete attachments
				$this->commonDeleteAttachments('Board', $this->fields_arr['bid']);

				//Decrement tag_count
				if($this->board_details['tags'])
					$this->updateDeletedBoardsTagCount($this->board_details['tags']);

				//Delete board
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['boards'].' WHERE board_id='.$this->dbObj->Param('bid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		public function deleteBoardsComment()
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['board_comment'].
						' WHERE board_id='.$this->dbObj->Param($this->fields_arr['bid']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
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
		 * SolutionFormHandler::chkIsValidBoard()
		 *
		 * @return
		 */
		public function chkIsValidBoard()
		    {
				$this->chkIsNotEmpty('bid', $this->LANG['err_tip_compulsory']);
				if (!$this->isValidFormInputs())
					{
						$this->setCommonErrorMsg($this->LANG['err_tip_invalid_board']);
						return false;
					}
				//Query to display recent and popular boards
				$sql = 'SELECT b.board_id, b.discussion_id, b.total_solutions, b.best_solution_id, b.description, b.total_stars, b.tags, b.board, b.redirect_link'.
						', TIMEDIFF(NOW(), board_added) as board_added, '.$this->getUserTableField('display_name').' AS asked_by'.
						', u.'.$this->getUserTableField('user_id').' as img_user_id, '.$this->getUserTableFields(array('gender', 'name', 'email'), false).', b.status, b.user_id'.
						', b.publish_status, b.seo_title, IF(status=\'Active\', 1, 0) is_open FROM '.$this->CFG['db']['tbl']['boards'].' AS b'.
						', '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE b.user_id=u.'.$this->getUserTableField('user_id').
						' AND u.'.$this->getUserTableField('user_status').'=\'Ok\' AND b.board_id='.$this->dbObj->Param('bid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));

				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					{
						$this->setCommonErrorMsg($this->LANG['err_tip_invalid_board']);
						return false;
					}
				$this->board_details = $rs->FetchRow();
				if($this->board_details['redirect_link']!='')
					{
						Redirect2URL($this->board_details['redirect_link']);
					}

				$this->fields_arr['did'] = $this->board_details['discussion_id'];
				return true;
		    }

		/**
		 * SolutionFormHandler::buildConditionQuery()
		 *
		 * @return
		 */
		public function buildConditionQuery()
			{
				$this->sql_condition = 'a.user_id=u.'.$this->getUserTableField('user_id').
										' AND u.'.$this->getUserTableField('user_status').'=\'Ok\''.
										' AND a.board_id='.$this->fields_arr['bid'].
										' AND a.solution_id!='.$this->board_details['best_solution_id'];
			}

		/**
		 * SolutionFormHandler::buildSortQuery()
		 *
		 * @return
		 */
		public function buildSortQuery()
			{
				$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}

		/**
		 * SolutionFormHandler::chkIsValidSolution()
		 *
		 * @param mixed $solution_id
		 * @return
		 */
		public function chkIsValidSolution()
		    {
				#$this->chkIsNotEmpty('aid', $this->LANG['err_tip_compulsory']);
				if (!$this->isValidFormInputs())
					{
						$this->setCommonErrorMsg($this->LANG['err_tip_invalid_solution']);
						return false;
					}
				//Query to display recent and popular boards
				$sql = 'SELECT a.board_id, a.user_id, a.status, a.solution'.
						' FROM '.$this->CFG['db']['tbl']['solutions'].' AS a'.
						', '.$this->CFG['db']['tbl']['boards'].' AS b, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE a.board_id=b.board_id AND a.user_id=u.'.$this->getUserTableField('user_id').' AND b.status IN (\'Active\', \'Inactive\')'.
						' AND u.'.$this->getUserTableField('user_status').'=\'Ok\' AND a.solution_id='.$this->dbObj->Param('aid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					{
						$this->setCommonErrorMsg($this->LANG['err_tip_invalid_board']);
						return false;
					}
				$this->solution_details = $rs->FetchRow();
				$this->fields_arr['bid'] = $this->solution_details['board_id'];
				return true;
		    }

		/**
		 * SolutionFormHandler::displayBestSolution()
		 *
		 * @return
		 */
		public function displayBestSolution()
		    {
				if ($this->board_details['best_solution_id'])
					{
						$displayBestSolution_arr = array();
						$sql = 'SELECT a.solution_id, a.user_id, a.solution, TIMEDIFF(NOW(), solution_added) as solution_added'.
								', u.'.$this->getUserTableField('user_id').' as img_user_id, '.$this->getUserTableFields(array('image_path', 'gender', 't_height', 't_width','photo_server_url', 'photo_ext'), false).$this->getUserTableField('display_name').' as solutioned_by'.
								' FROM '.$this->CFG['db']['tbl']['solutions'].' AS a'.
								', '.$this->CFG['db']['tbl']['users'].' AS u'.
								' WHERE a.user_id=u.'.$this->getUserTableField('user_id').
								' AND u.'.$this->getUserTableField('user_status').'=\'Ok\''.
								' AND a.board_id='.$this->dbObj->Param('bid').
								' AND a.solution_id='.$this->dbObj->Param('aid').
								' ORDER BY a.solution_id DESC';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid'], $this->board_details['best_solution_id']));
						if (!$rs)
						        trigger_db_error($this->dbObj);

						if (!$rs->PO_RecordCount())
							return ;
						$row = $rs->FetchRow();
						$best_solution_id = $this->board_details['best_solution_id'];
						$displayBestSolution_arr['populateCommentList'] = $this->populateCommentList($this->board_details['best_solution_id']);
						$displayBestSolution_arr['record'] = $row;
						$displayBestSolution_arr['best_solution_id'] = $best_solution_id;

						$displayBestSolution_arr['fetchMoreAttachments'] = '';
						if ($this->hasMoreAttachments($this->board_details['best_solution_id'], 'Solution'))
							{
								$displayBestSolution_arr['fetchMoreAttachments'] = $this->fetchMoreAttachments($this->board_details['best_solution_id']);
							}

						$displayBestSolution_arr['row_solution_manual'] = nl2br(wordWrapManual($row['solution'], 50));

						return $displayBestSolution_arr;
					}

				return false;
		    }

		/**
		 * SolutionFormHandler::isFavoriteBoard()
		 *
		 * @return
		 */
		public function isFavoriteBoard()
		    {
				$sql = 'SELECT fav_id FROM '.$this->CFG['db']['tbl']['users_favorite_boards'].
						' WHERE board_id = '.$this->dbObj->Param('bid').
						' AND user_id = '.$this->dbObj->Param('uid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid'], $this->CFG['user']['user_id']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				$ok = false;
				if ($rs->PO_RecordCount())
					$ok = true;
				return $ok;
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function showAnotherBoard($next='')
		    {
				$condition = '<';
				$orderby = 'DESC';
				$caption = $this->LANG['solutions_prev'];

				$clsInActive = 'clsInActiveSolnPrev';
				$clsActive = 'clsActiveSolnPrev';

				$showAnotherBoard_val = '';
				if($next)
					{
						$clsActive = 'clsActiveSonNext';
						$clsInActive = 'clsInActiveSonNext';
						$caption = $this->LANG['solutions_next'];
						$condition = '>';
						$orderby = 'ASC';
						$clsNoBorder = 'clsNoBorder';
					}

				$sql = 'SELECT board_id, seo_title FROM '.$this->CFG['db']['tbl']['boards'].
						' WHERE board_id'.$condition.$this->dbObj->Param('bid').
						' AND discussion_id='.$this->dbObj->Param($this->discussion_details['discussion_id']).
						' ORDER BY board_id '.$orderby.' LIMIT 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid'], $this->discussion_details['discussion_id']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$showAnotherBoard_val = '<span class="'.$clsActive.'"><a href="'.$this->CFG['site']['relative_url'].'viewSolutions.php?bid='.$row['board_id'].'">'.$caption.'</a></span>';
					}
				else
					{

						$showAnotherBoard_val = '<span class="'.$clsInActive.'">'.$caption.'</span>';
					}

				return $showAnotherBoard_val;
		    }

		/**
		 * SolutionFormHandler::showCategoryNameInAdmin()
		 *
		 * @param mixed $cat_id
		 * @return
		 */
		public function showCategoryNameInAdmin($cat_id)
		    {
				$sql = 'SELECT cat_name, seo_title, cat_id FROM '.$this->CFG['db']['tbl']['category'].' WHERE cat_id='.$this->dbObj->Param('cat_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();

						$showCategoryNameInAdmin_val = '<span>'.$this->LANG['discuzz_common_in'].' <a href="'.$this->CFG['site']['relative_url'].'manageSolutions.php?go=1&amp;search_cat=8&amp;search_name='.$row['seo_title'].'">'.$row['cat_name'].'</a></span>
						&nbsp;-&nbsp;';

						return $showCategoryNameInAdmin_val;
					}
				return false;
		    }

		/**
		 * SolutionFormHandler::displayBoardDetails()
		 *
		 * @return
		 */
		public function displayBoardDetails()
		    {
				if (!$this->board_details) return false;
				$displayBoardDetails_arr = array();

				$qid = $this->fields_arr['bid'];
				$anchor1 = 'selConPos_'.$qid;
				$qanchor = 'selConPos1_'.$qid;

				$displayBoardDetails_arr['bid'] = $qid;

				$displayBoardDetails_arr['board_manual'] = wordWrapManual($this->board_details['board'], 50);

				//BBCODE PARSING
				$bbcode = new BBCode;
				$parsed_output = $bbcode->Parse($this->board_details['description']);
				$displayBoardDetails_arr['description_manual'] = wordWrapManual($parsed_output, 50);

				if ($this->hasMoreAttachments($this->board_details['board_id']))
					{
						$displayBoardDetails_arr['fetchMoreAttachments'] = $this->fetchMoreAttachments();
					}

				$displayBoardDetails_arr['displayBestSolution_arr'] = $this->displayBestSolution();
				$displayBoardDetails_arr['onclick_action'] = '';
				$displayBoardDetails_arr['reply_solution']['url'] = 'viewSolutions.php?action=reply&bid='.$this->board_details['board_id'].'&did='.$this->board_details['discussion_id'];
				return $displayBoardDetails_arr;
		    }

		/**
		 * SolutionFormHandler::displayAllSolutions()
		 *
		 * @return
		 */
		public function displayAllSolutions()
			{
				//Query to display recent and popular boards

				if (!$this->isResultsFound())
					{
						return ;
					}
				$displayAllSolutions_arr = array();

							$id_cnt = 0;
				//$anchor1 = '';
				$this->da_anchor = '';
				$inc = 1;
				while($row = $this->fetchResultRecord())
					{
						$solution_id = $row['solution_id'];
						$displayAllSolutions_arr[$inc]['solution_id'] = $solution_id;
						$displayAllSolutions_arr[$inc]['populateCommentList'] = $this->populateCommentList($row['solution_id']);
						$this->da_anchor = 'dAltMlti';
						$displayAllSolutions_arr[$inc]['record'] = $row;
						//BBCODE PARSING
						$bbcode = new BBCode;
						$parsed_output = $bbcode->Parse($row['solution']);
						$displayAllSolutions_arr[$inc]['row_solution_manual'] = wordWrapManual($parsed_output, 50);

						$displayAllSolutions_arr[$inc]['row_solutioned_by_manual'] = stripString($row['solutioned_by'], $this->CFG['username']['short_length']);

						if ($this->hasMoreAttachments($row['solution_id'], 'Solution'))
							{
								$displayAllSolutions_arr[$inc]['fetchMoreAttachments'] = $this->fetchMoreAttachments();
							}
						$displayAllSolutions_arr[$inc]['commentSpanIDId'] = 'commentSpanID_'.$row['solution_id'];
						$inc++;

					} // while

				return $displayAllSolutions_arr;
			}

		public function populateCommentList($c_ansid)
			{
				$sql = 'SELECT comment_id, solution_id, user_id, comment ,status,  DATE_FORMAT(date_added, \''.$this->CFG['mysql_format']['date_time'].'\') AS date_added'.
						' FROM '.$this->CFG['db']['tbl']['board_comment'].' WHERE'.
						' solution_id = '.$this->dbObj->Param('c_solution_id').'ORDER BY  comment_id DESC';


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($c_ansid));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				$populateCommentList_arr = array();
				if($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								$row['comment'] = nl2br(wordWrapManual(strip_slashes($row['comment']), 60));
								//$row['comment'] = html_entity_decode($row['comment'], ENT_QUOTES);
								$populateCommentList_arr[$inc]['record'] = $row;
								$populateCommentList_arr[$inc]['commentSpanIDId'] = 'commentSpanID_'.$row['comment_id'];
								$populateCommentList_arr[$inc]['user_details'] = $this->getUserDetails($row['user_id']);
								$populateCommentList_arr[$inc]['mysolutions']['url'] = $this->CFG['site']['url'].'admin/viewMembers.php?uid='.$populateCommentList_arr[$inc]['user_details']['user_id'];
								$populateCommentList_arr[$inc]['msg'] = 'msg_'.$row['solution_id'];
								$populateCommentList_arr[$inc]['anchor'] = 'deleteComment'.$row['comment_id'];
								$inc++;
							}
					}
				return $populateCommentList_arr;
			}

		/**
		 * SolutionFormHandler::updateAbuseBoard()
		 *
		 * @return
		 */
		public function updateAbuseBoard()
		    {
				$sql = 'SELECT abuse_id FROM '.$this->CFG['db']['tbl']['abuse_boards'].
						' WHERE board_id='.$this->dbObj->Param('bid').
						' AND reported_by='.$this->dbObj->Param('rid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid'],
														 $this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['abuse_boards'].
								' SET board_id='.$this->dbObj->Param('bid').
								', reported_by='.$this->dbObj->Param('rid').
								', reason='.$this->dbObj->Param('reason').
								', date_abused=NOW()';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid'],
																 $this->CFG['user']['user_id'],
																 $this->fields_arr['reason']));
						if (!$rs)
						        trigger_db_error($this->dbObj);

						if ($this->dbObj->Affected_Rows())
							{
								$this->updateBoardAbuseCount();
								$this->updateAbuseUserPoints($this->CFG['admin']['abuse_boards_points']['allowed'], $this->board_details['user_id'], $this->CFG['admin']['abuse_boards']['points']);
								$this->sendAbuseMailToAsker();
							}
					}
		    }

		/**
		 * SolutionFormHandler::updateBoardAbuseCount()
		 *
		 * @return
		 */
		public function updateBoardAbuseCount()
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].' SET abuse_count=abuse_count+1'.
						' WHERE board_id='.$this->dbObj->Param('bid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
		    }

		/**
		 * SolutionFormHandler::updateAbuseSolution()
		 *
		 * @return
		 */
		public function updateAbuseSolution()
		    {
				$sql = 'SELECT abuse_id FROM '.$this->CFG['db']['tbl']['abuse_solutions'].
						' WHERE solution_id='.$this->dbObj->Param('aid').
						' AND reported_by='.$this->dbObj->Param('rid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid'],
														 $this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['abuse_solutions'].
								' SET board_id='.$this->dbObj->Param('bid').
								', solution_id='.$this->dbObj->Param('aid').
								', reported_by='.$this->dbObj->Param('rid').
								', reason='.$this->dbObj->Param('reason').
								', date_abused=NOW()';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid'],
																 $this->fields_arr['aid'],
																 $this->CFG['user']['user_id'],
																 $this->fields_arr['reason']));
						if (!$rs)
						        trigger_db_error($this->dbObj);

						if ($this->dbObj->Affected_Rows())
							{
								$this->updateSolutionAbuseCount();
								$this->updateAbuseUserPoints($this->CFG['admin']['abuse_solutions_points']['allowed'], $this->solution_details['user_id'], $this->CFG['admin']['abuse_solutions']['points']);
								$this->sendAbuseMailToSolutioner();
							}
					}
		    }

		/**
		 * SolutionFormHandler::updateSolutionAbuseCount()
		 *
		 * @return
		 */
		public function updateSolutionAbuseCount()
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['solutions'].' SET abuse_count=abuse_count+1'.
						' WHERE solution_id='.$this->dbObj->Param('aid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
		    }

		/**
		 * SolutionFormHandler::updateAbuseUserPoints()
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
		 * SolutionFormHandler::updateBestSolution()
		 *
		 * @return
		 */
		public function updateBestSolution()
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].' SET best_solution_id='.$this->dbObj->Param('aid').
						' WHERE board_id='.$this->dbObj->Param('bid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid'], $this->fields_arr['bid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($this->dbObj->Affected_Rows() AND $this->discussion_details['status'] == 'Active' AND $this->board_details['status'] == 'Active')
					{
						$this->sendMailToSolutioner();
						if ($this->chkIsValidSolution($this->fields_arr['aid']))
							$this->increaseBestSolutionPoints($this->solution_details['user_id']);
						//Add Activity
						if($this->CFG['admin']['index']['activity']['show'])
							{
								if($this->board_details['best_solution_id'])
									$activity_arr['action_key'] = 'best_solution_changed';
								else
									$activity_arr['action_key'] = 'best_solution';
								$activity_arr['owner_id'] = $this->solution_details['user_id'];
								$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
								$activity_arr['solution_id'] = $this->fields_arr['aid'];
								$user_details = $this->getUserDetails($this->CFG['user']['user_id']);
								$activity_arr['display_name'] = $user_details['display_name'];
								$this->discussionsActivityObj->addActivity($activity_arr);
							}
					}
		    }

		/**
		 * SolutionFormHandler::publishSolution()
		 *
		 * @return
		 */
		public function publishSolution()
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['solutions'].' SET status=\'Active\' WHERE solution_id='.$this->dbObj->Param('aid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				if ($this->dbObj->Affected_Rows())
					{
						// To increase the total solutions count for the board..
						$this->updateBoard();

						if ($this->discussion_details['status'] == 'Active' AND $this->board_details['status'] == 'Active')
							{
								// To increase the total solution count for that solutioner
								$usr_sql = 'SELECT a.solution_id, a.user_id, a.solution, a.board_id, '.$this->getUserTableFields(array('email', 'display_name'), false).
											' , a.status FROM '.$this->CFG['db']['tbl']['solutions'].' AS a, '.$this->CFG['db']['tbl']['users'].' AS u'.
											' WHERE a.user_id=u.'.$this->getUserTableField('user_id').
											' AND u.'.$this->getUserTableField('user_status').'=\'Ok\''.
											' AND a.board_id='.$this->dbObj->Param('bid').
											' AND a.solution_id='.$this->dbObj->Param('aid').
											' ORDER BY a.solution_id DESC';
								$usr_stmt = $this->dbObj->Prepare($usr_sql);
								$usr_rs = $this->dbObj->Execute($usr_stmt, array($this->fields_arr['bid'], $this->fields_arr['aid']));
								if (!$usr_rs)
								        trigger_db_error($this->dbObj);

								$row = $usr_rs->FetchRow();

								$update_sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
												' SET total_solution=total_solution+1';
								if($this->CFG['admin']['reply_solutions']['allowed'])
									$update_sql .= ', total_points=total_points+'.$this->CFG['admin']['reply_solutions']['points'];
								$update_sql .= ', date_updated=NOW()'.
										' WHERE user_id='.$this->dbObj->Param('uid');
								$update_stmt = $this->dbObj->Prepare($update_sql);
								$update_rs = $this->dbObj->Execute($update_stmt, array($row['user_id']));
								if (!$update_rs)
					        			trigger_db_error($this->dbObj);

						        	// To send email alert for published users..
								$this->sendPublishedMailAlert($row['email'], $row['display_name'], $row['solution']);

								//Add Activity
								if($this->CFG['admin']['index']['activity']['show'])
									{
										$activity_arr['action_key'] = 'publish_solution';
										$activity_arr['owner_id'] = $row['user_id'];
										$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
										$activity_arr['solution_id'] = $this->fields_arr['aid'];
										$this->discussionsActivityObj->addActivity($activity_arr);
									}
							}
					}
		    }

		/**
		 * SolutionFormHandler::sendPublishedMailAlert()
		 *
		 * @param mixed $toEmail
		 * @param mixed $reciever_name
		 * @param mixed $content_description
		 * @return
		 */
		public function sendPublishedMailAlert($toEmail, $reciever_name, $content_description)
			{
				$site_link = "<a target=\"_blank\" href=\"".URL($this->CFG['site']['url'])."\">".URL($this->CFG['site']['url'])."</a>";
				$url_link = getUrl('solutions', '?title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'root', $this->CFG['admin']['index']['home_module']);
				$quesiton_link = "<a target=\"_blank\" href=\"".$url_link."\"><strong>".$this->board_details['board']."</strong></a>";

				$subject = $this->getMailContent($this->LANG['solution_publish_subject'], array('VAR_USERNAME'=>$reciever_name, 'VAR_SITENAME'=>$this->CFG['site']['name'], 'VAR_DESCRIPTION_OF_QUESTION'=>$content_description, 'VAR_BOARD'=>$quesiton_link, 'VAR_LINK'=>$site_link));
				$content = $this->getMailContent($this->LANG['solution_publish_message'], array('VAR_USERNAME'=>$reciever_name, 'VAR_SITENAME'=>$this->CFG['site']['name'], 'VAR_DESCRIPTION_OF_QUESTION'=>$content_description, 'VAR_BOARD'=>$quesiton_link, 'VAR_LINK'=>$site_link));

				$qowner_email = $this->board_details['email'];
				$qowner_name = $this->board_details['asked_by'];
				$owner_subject = $this->getMailContent($this->LANG['solution_publish_owner_subject'], array('VAR_USERNAME'=>$qowner_name, 'VAR_SITENAME'=>$this->CFG['site']['name'], 'VAR_DESCRIPTION_OF_QUESTION'=>$content_description, 'VAR_BOARD'=>$quesiton_link, 'VAR_LINK'=>$site_link));
				$owner_content = $this->getMailContent($this->LANG['solution_publish_owner_message'], array('VAR_USERNAME'=>$qowner_name, 'VAR_SITENAME'=>$this->CFG['site']['name'], 'VAR_DESCRIPTION_OF_QUESTION'=>$content_description, 'VAR_BOARD'=>$quesiton_link, 'VAR_LINK'=>$site_link));

				$this->_sendMail($toEmail, $subject, $content, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
				$this->_sendMail($qowner_email, $owner_subject, $owner_content, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
			}

		/**
		 * SolutionFormHandler::deleteSolutions()
		 *
		 * @param mixed $board_name
		 * @param mixed $solutions_table
		 * @param mixed $users_board_log_table
		 * @param mixed $solution_id
		 * @return
		 */
		public function deleteSolutions($board_name, $solutions_table, $users_board_log_table, $solution_id)
		    {
				$this->deleteSolutionsComment();

				if ($this->discussion_details['status'] == 'Active' AND $this->board_details['status'] == 'Active' AND $this->checkDiscussionCategoryActive($this->discussion_details['discussion_id']))
					{
						$sql = 'SELECT user_id FROM '.$solutions_table.' WHERE solution_id IN ('.$this->dbObj->Param('aid').') AND status !=\'ToActivate\'';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($solution_id));
						if (!$rs)
						        trigger_db_error($this->dbObj);
						$solution_status = '';
						if ($rs->PO_RecordCount())
							{
								$row = $rs->FetchRow();
								$sql = 'UPDATE '.$users_board_log_table.' SET total_solution=total_solution-1';
								if($this->CFG['admin']['reply_solutions']['allowed'])
									$sql .= ', total_points=total_points-'.$this->CFG['admin']['reply_solutions']['points'];
								$sql .= ' WHERE user_id='.$this->dbObj->Param('uid');
								$stmt = $this->dbObj->Prepare($sql);
								$rs_user_log = $this->dbObj->Execute($stmt, array($row['user_id']));
								if (!$rs_user_log)
								        trigger_db_error($this->dbObj);

						        $sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].
										' SET total_solutions=total_solutions-1'.
										' WHERE discussion_id='.$this->dbObj->Param($this->board_details['discussion_id']);
						        $stmt = $this->dbObj->Prepare($sql);
						        $rs_discuss = $this->dbObj->Execute($stmt, array($this->board_details['discussion_id']));
						        if (!$rs_discuss)
					        	    trigger_db_error($this->dbObj);

	        					//Decrement total_solutions in category table
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
										' SET total_solutions=total_solutions-1'.
										' WHERE cat_id='.$this->dbObj->Param($this->discussion_details['pcat_id']);
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->discussion_details['pcat_id']));
								if (!$rs)
									    trigger_db_error($this->dbObj);
								$this->updateSolutionsOfParentCategories($this->discussion_details['pcat_id'], '-');

							}
					}

				$sql = 'DELETE FROM '.$solutions_table.' WHERE solution_id IN ('.$this->dbObj->Param('aid').')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($solution_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				//if($solution_status == 'ToActivate')
				//	return ;

				$sql = 'UPDATE '.$board_name.' SET total_solutions=total_solutions-1 WHERE board_id IN ('.$this->dbObj->Param('bid').')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				//to delete attachments
				$this->commonDeleteAttachments('Solution', $solution_id);
		    }

		public function deleteSolutionsComment()
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['board_comment'].
						' WHERE solution_id  IN ('.$this->dbObj->Param('aid').')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * SolutionFormHandler::removeBestSolution()
		 *
		 * @return
		 */
		public function removeBestSolution()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].' SET best_solution_id=0'.
						' WHERE board_id='.$this->dbObj->Param('bid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($this->dbObj->Affected_Rows() AND $this->discussion_details['status'] == 'Active' AND $this->board_details['status'] == 'Active' AND $this->checkDiscussionCategoryActive($this->discussion_details['discussion_id']))
					{
						$this->decreaseBestSolutionPoints($this->solution_details['user_id']);
						//Add Activity
						if($this->CFG['admin']['index']['activity']['show'])
							{
								$activity_arr['action_key'] = 'remove_bestsolution';
								$activity_arr['owner_id'] = $this->solution_details['user_id'];
								$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
								$activity_arr['solution_id'] = $this->fields_arr['aid'];
								$user_details = $this->getUserDetails($this->CFG['user']['user_id']);
								$activity_arr['display_name'] = $user_details['display_name'];
								$this->discussionsActivityObj->addActivity($activity_arr);
							}
					}
			}

		public function updateSolution()
			{
		    	$search_title = $this->filterWordsForSearching($this->fields_arr['solution']);
				$search_title = implode(" ", $search_title);
				$search_title = ' '.$search_title.' ';

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['solutions'].
						' SET solution='.$this->dbObj->Param('solution').
						', search_word='.$this->dbObj->Param('search_word').
						' WHERE user_id='.$this->dbObj->Param('uid').
						' AND board_id='.$this->dbObj->Param('bid').
						' AND solution_id='.$this->dbObj->Param('aid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['solution'],
														 $search_title,
														 $this->CFG['user']['user_id'],
														 $this->fields_arr['bid'],
														 $this->fields_arr['aid']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$this->fields_arr['content_id'] = $this->fields_arr['aid'];
				$this->addAttachments();
				return ;
			}
		/**
		 * SolutionFormHandler::addSolution()
		 *
		 * @return
		 */
		public function addSolution()
		    {
				$this->fields_arr['content_id'] = $this->insertSolution();
				$this->updateBoard();
				$this->updateDiscussion();
				$this->updateUserSolutionLog();
				$this->addAttachments();
				$this->sendMailToAsker();
		    }

		/**
		 * SolutionFormHandler::insertSolution()
		 *
		 * @return
		 */
		public function insertSolution()
		    {
		    	$search_title = $this->filterWordsForSearching($this->fields_arr['solution']);
				$search_title = implode(" ", $search_title);
				$search_title = ' '.$search_title.' ';

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['solutions'].
						' SET user_id='.$this->dbObj->Param('uid').
						', board_id='.$this->dbObj->Param('bid').
						', solution='.$this->dbObj->Param('solution').
						', search_word='.$this->dbObj->Param('search_word').
						', solution_added=NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'],
														 $this->fields_arr['bid'],
														 $this->fields_arr['solution'],
														 $search_title));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				return $this->dbObj->Insert_ID();
		    }

		/**
		 * SolutionFormHandler::updateBoard()
		 *
		 * @return
		 */
		public function updateBoard()
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].
						' SET total_solutions=total_solutions+1'.
						', last_post_by='.$this->dbObj->Param($this->CFG['user']['user_id']).
						', email_sent=\'No\', solution_added=NOW()'.
						' WHERE board_id='.$this->dbObj->Param('bid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['bid']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				// update categories count
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
						' SET total_solutions=total_solutions+1'.
						' WHERE cat_id='.$this->dbObj->Param('cat_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->discussion_details['pcat_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				$this->updateSolutionsOfParentCategories($this->discussion_details['pcat_id'], '+');
		    }

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function updateDiscussion()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].
						' SET total_solutions=total_solutions+1'.
						', last_post_user_id='.$this->dbObj->Param($this->CFG['user']['user_id']).
						', last_post_date=NOW()'.
						' WHERE discussion_id='.$this->dbObj->Param($this->discussion_details['discussion_id']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->discussion_details['discussion_id']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * SolutionFormHandler::updateUserSolutionLog()
		 *
		 * @return
		 */
		public function updateUserSolutionLog()
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
						' SET total_solution=total_solution+1';
				if($this->CFG['admin']['reply_solutions']['allowed'])
					$sql .= ', total_points=total_points+'.$this->CFG['admin']['reply_solutions']['points'];
				$sql .=	', date_updated=NOW()'.
						' WHERE user_id='.$this->dbObj->Param('uid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
		    }

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

						$uploaded = false;
						$local_upload = true;
						$dir = '../'.$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'];

						$imageObj = new ImageHandler($def_req);
						$this->setIHObject($imageObj);
						$temp_file =$temp_dir.'temp_'.$req_upl[1].'_'.$req_upl[2];
						if(in_array($extern, $this->CFG['admin']['attachments']['image_formats']))
							$this->storePicturesTempServer($temp_file, $extern);

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
												echo $temp_file.'L.'.$extern;
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

		public function storePicturesTempServer($uploadUrl, $extern)
			{
				$this->imageObj->output_original($uploadUrl.'L.'.$extern, strtoupper($extern));
				$image_info = getImageSize($uploadUrl.'L.'.$extern);
				$this->L_WIDTH = $image_info[0];
				$this->L_HEIGHT = $image_info[1];
				//GET SMALL IMAGE
				if($this->CFG['admin']['ans_pictures']['small_name']=='S')
					{
						$this->imageObj->resize($this->CFG['admin']['ans_pictures']['small_width'], $this->CFG['admin']['ans_pictures']['small_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'S.'.$extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl.'S.'.$extern);
						$this->S_WIDTH = $image_info[0];
						$this->S_HEIGHT = $image_info[1];
					}
				if($this->CFG['admin']['ans_pictures']['thumb_name']=='T')
					{
						$this->imageObj->resize($this->CFG['admin']['ans_photos']['thumb_width'], $this->CFG['admin']['ans_photos']['thumb_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'T.'.$extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl.'T.'.$extern);
						$this->T_WIDTH = $image_info[0];
						$this->T_HEIGHT = $image_info[1];
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
		 * SolutionsFormHandler::createAttachmentRecord()
		 *
		 * @param mixed $size
		 * @return
		 */
		public function createAttachmentRecord($size)
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['attachments'].
						' SET content_type=\'Solution\''.
						', content_id='.$this->dbObj->Param('solution').
						', attachment_size='.$this->dbObj->Param('size').
						', date_added=NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['content_id'], $size));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				return $this->dbObj->Insert_ID();
			}

		public function updateAttachmentRecord($aid, $file_path)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['attachments'].
						' SET attachment_name='.$this->dbObj->Param('solution').
						' ,photo_server_url='.$this->dbObj->Param('server_url').
						' WHERE attachment_id='.$this->dbObj->Param('id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($file_path, $this->fields_arr['server_url'], $aid));
				if (!$rs)
				        trigger_db_error($this->dbObj);
			}
		/**
		 * SolutionFormHandler::sendMailToAsker()
		 *
		 * @return
		 */
		public function sendMailToAsker()
		    {
				if ($this->board_details['user_id'] == $this->CFG['user']['user_id'])
						return ;
				$email_options = $this->getEmailOptionsOfUser($this->board_details['user_id']);
				if ($email_options['reply_mail'] == 'Yes')
					{
						$asker_details = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $this->board_details['user_id']);
						$solutions_reply_subject = str_ireplace('VAR_USERNAME', $asker_details['display_name'], $this->LANG['solutions_reply_email_subject']);
						$solutions_reply_subject = str_ireplace('VAR_SENDER_NAME', $this->CFG['user']['display_name'], $solutions_reply_subject);
						$receiver_url = getMemberUrl($this->board_details['user_id'], $this->board_details['name'], 'root');
						$solutions_reply_content = str_ireplace('VAR_USERNAME', '<a href="'.$receiver_url.'">'.$asker_details['display_name'].'</a>', $this->LANG['solutions_reply_email_content']);
						$sender_url = getMemberUrl($this->CFG['user']['user_id'], $this->CFG['user']['name'], 'root');
						$sender_name = '<a href="'.$sender_url.'">'.$this->CFG['user']['display_name'].'</a>';
						$solutions_reply_content = str_ireplace('VAR_SENDER_NAME', $sender_name, $solutions_reply_content);
						$solutions_reply_content = str_ireplace('VAR_SITENAME', $this->CFG['site']['name'], $solutions_reply_content);
						$solutions_reply_content = str_ireplace('VAR_BOARD_POSTED', '<strong>'.$this->board_details['board'].'</strong>', $solutions_reply_content);
						$solutions_reply_content = str_ireplace('VAR_BOARD_REPLY', nl2br($this->fields_arr['solution']), $solutions_reply_content);
						$board_link = getUrl('solutions', '?title='.$this->fields_arr['seo_title'], $this->board_details['seo_title'].'/', 'root', $this->CFG['admin']['index']['home_module']);
						$solutions_reply_content = str_ireplace('VAR_LINK', '<a href="'.$board_link.'">'.$board_link.'</a>', $solutions_reply_content);

						$this->_sendMail($asker_details['email'],
										 $solutions_reply_subject,
										 $solutions_reply_content,
										 $this->CFG['site']['noreply_name'],
										 $this->CFG['site']['noreply_email']);
					}
		    }

		/**
		 * SolutionFormHandler::sendMailToSolutioner()
		 *
		 * @return
		 */
		public function sendMailToSolutioner()
		    {
				#die('here');
				if ($this->board_details['user_id'] != $this->CFG['user']['user_id'])
						return ;

				$solution_details = $this->getSolutionDetails($this->fields_arr['aid']);
				$email_options = $this->getEmailOptionsOfUser($solution_details['user_id']);
				if ($email_options['best_solution_mail'] == 'Yes')
					{
						$solutioner_details = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $solution_details['user_id']);
						$best_solutions_subject = str_ireplace('VAR_USERNAME', $solutioner_details['display_name'], $this->LANG['best_solution_email_subject']);
						$receiver_url = getMemberUrl($solution_details['user_id'], $solution_details['name'], 'root');
						$best_solutions_content = str_ireplace('VAR_USERNAME', '<a href="'.$receiver_url.'">'.$solutioner_details['display_name'].'</a>', $this->LANG['best_solution_email_content']);
						$sender_url = getMemberUrl($this->CFG['user']['user_id'], $this->CFG['user']['name'], 'root');
						$sender_name = '<a href="'.$sender_url.'">'.$this->CFG['user']['display_name'].'</a>';
						$best_solutions_content = str_ireplace('VAR_SENDER_NAME', $sender_name, $best_solutions_content);
						$best_solutions_content = str_ireplace('VAR_SITENAME', $this->CFG['site']['name'], $best_solutions_content);
						$best_solutions_content = str_ireplace('VAR_BOARD_POSTED', '<strong>'.$this->board_details['board'].'</strong>', $best_solutions_content);
						$best_solutions_content = str_ireplace('VAR_BOARD_REPLY', nl2br($solution_details['solution']), $best_solutions_content);
						$board_link = getUrl('solutions', '?title='.$this->fields_arr['seo_title'], $this->board_details['seo_title'].'/', 'root', $this->CFG['admin']['index']['home_module']);
						$best_solutions_content = str_ireplace('VAR_LINK', '<a href="'.$board_link.'">'.$board_link.'</a>', $best_solutions_content);

						$this->_sendMail($solutioner_details['email'],
										 $best_solutions_subject,
										 $best_solutions_content,
										 $this->CFG['site']['noreply_name'],
										 $this->CFG['site']['noreply_email']);
					}
		    }

		/**
		 * SolutionFormHandler::getSolutionDetails()
		 *
		 * @param mixed $aid
		 * @return
		 */
		public function getSolutionDetails($aid)
		    {
				$sql = 'SELECT user_id, solution FROM '.$this->CFG['db']['tbl']['solutions'].' WHERE solution_id='.$this->dbObj->Param('aid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				return $row;
		    }

		/**
		 * SolutionFormHandler::sendAbuseMailToAsker()
		 *
		 * @return
		 */
		public function sendAbuseMailToAsker()
		    {
				$email_options = $this->getEmailOptionsOfUser($this->board_details['user_id']);
				if ($email_options['abuse_mail'] == 'Yes')
					{
						$asker_details = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $this->board_details['user_id']);
						$abuse_board_subject = str_ireplace('VAR_USERNAME', $asker_details['display_name'], $this->LANG['abuse_board_email_subject']);
						$receiver_url = getMemberUrl($this->board_details['user_id'], $this->board_details['name'], 'root');
						$abuse_board_content = str_ireplace('VAR_USERNAME', '<a href="'.$receiver_url.'">'.$asker_details['display_name'].'</a>', $this->LANG['abuse_board_email_content']);
						$sender_url = getMemberUrl($this->CFG['user']['user_id'], $this->CFG['user']['name'], 'root');
						$sender_name = '<a href="'.$sender_url.'">'.$this->CFG['user']['display_name'].'</a>';
						$abuse_board_content = str_ireplace('VAR_SENDER_NAME', $sender_name, $abuse_board_content);
						$abuse_board_content = str_ireplace('VAR_SITENAME', $this->CFG['site']['name'], $abuse_board_content);
						$abuse_board_content = str_ireplace('VAR_BOARD_POSTED', '<strong>'.$this->board_details['board'].'</strong>', $abuse_board_content);
						$board_link = getUrl('solutions', '?title='.$this->fields_arr['seo_title'], $this->board_details['seo_title'].'/', 'root', $this->CFG['admin']['index']['home_module']);
						$abuse_board_content = str_ireplace('VAR_LINK', '<a href="'.$board_link.'">'.$board_link.'</a>', $abuse_board_content);

						$this->_sendMail($asker_details['email'],
										 $abuse_board_subject,
										 $abuse_board_content,
										 $this->CFG['site']['noreply_name'],
										 $this->CFG['site']['noreply_email']);
					}
		    }

		/**
		 * SolutionFormHandler::sendAbuseMailToSolutioner()
		 *
		 * @return
		 */
		public function sendAbuseMailToSolutioner()
		    {
				$email_options = $this->getEmailOptionsOfUser($this->solution_details['user_id']);
				if ($email_options['abuse_mail'] == 'Yes')
					{
						$solutioner_details = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $this->solution_details['user_id']);
						$abuse_solutions_subject = str_ireplace('VAR_USERNAME', $solutioner_details['display_name'], $this->LANG['abuse_solution_email_subject']);
						$receiver_url = getMemberUrl($this->solution_details['user_id'], $this->solution_details['name'], 'root');
						$abuse_solutions_content = str_ireplace('VAR_USERNAME', '<a href="'.$receiver_url.'">'.$solutioner_details['display_name'].'</a>', $this->LANG['abuse_solution_email_content']);
						$sender_url = getMemberUrl($this->CFG['user']['user_id'], $this->CFG['user']['name'], 'root');
						$sender_name = '<a href="'.$sender_url.'">'.$this->CFG['user']['display_name'].'</a>';
						$abuse_solutions_content = str_ireplace('VAR_SENDER_NAME', $sender_name, $abuse_solutions_content);
						$abuse_solutions_content = str_ireplace('VAR_SITENAME', $this->CFG['site']['name'], $abuse_solutions_content);
						$abuse_solutions_content = str_ireplace('VAR_BOARD_POSTED', '<strong>'.$this->board_details['board'].'</strong>', $abuse_solutions_content);
						$abuse_solutions_content = str_ireplace('VAR_BOARD_REPLY', nl2br($this->solution_details['solution']), $abuse_solutions_content);
						$board_link = getUrl('solutions', '?title='.$this->fields_arr['seo_title'], $this->board_details['seo_title'].'/', 'root', $this->CFG['admin']['index']['home_module']);
						$abuse_solutions_content = str_ireplace('VAR_LINK', '<a href="'.$board_link.'">'.$board_link.'</a>', $abuse_solutions_content);

						$this->_sendMail($solutioner_details['email'],
										 $abuse_solutions_subject,
										 $abuse_solutions_content,
										 $this->CFG['site']['noreply_name'],
										 $this->CFG['site']['noreply_email']);
					}
		    }

		 /**
		  * SolutionFormHandler::fetchMoreAttachments()
		  *
		  * @return
		  */
		 public function fetchMoreAttachments()
			{
				if (!$this->repliesArray) return ;

				$fetchMoreAttachments_arr = array();
				$inc = 1;
				$fetchMoreAttachments_arr['row'] = array();
				foreach($this->repliesArray as $row)
					{
						$fetchMoreAttachments_arr['row'][$inc]['anchor'] = 'replyQues'.$row['attachment_id'];

						$row['date_added'] = ($row['date_added'] != '') ? $this->getTimeDiffernceFormat($row['date_added']) : '';
						$extern = strtolower(substr($row['attachment_name'], strrpos($row['attachment_name'], '.')+1));
						$attachment_file_name = getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['thumb_name'].'.'.$extern;
						$attachment_original_file_name = getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['large_name'].'.'.$extern;


						$fetchMoreAttachments_arr['row'][$inc]['attachment_path'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$attachment_original_file_name;
						$fetchMoreAttachments_arr['row'][$inc]['gallery'] = $row['gallary'];
						$fetchMoreAttachments_arr['row'][$inc]['attachment_name'] = $row['attachment_name'];
						$fetchMoreAttachments_arr['row'][$inc]['attachment_original_path'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['large_name'].'.'.$extern;
						$fetchMoreAttachments_arr['row'][$inc]['extern'] = $extern;
						$fetchMoreAttachments_arr['row'][$inc]['image_path'] = $row['photo_server_url'].$this->CFG['admin']['ans_attachments_path'].$attachment_file_name;
						$fetchMoreAttachments_arr['row'][$inc]['attachment_file_name'] = getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['large_name'].'.'.$extern;

		                $fetchMoreAttachments_arr['row'][$inc]['record'] = $row;
		                $inc++;
					}
				return $fetchMoreAttachments_arr;
			}

		/**
		 * SolutionFormHandler::hasMoreAttachments()
		 *
		 * @param mixed $mainSolution_id
		 * @param string $type
		 * @return
		 */
		public function hasMoreAttachments($mainSolution_id, $type='Board')
			{

				$sql = 'SELECT attachment_id, attachment_name, photo_server_url, content_id, CONCAT(\''.$type.'_\',content_id) as gallary, TIMEDIFF(NOW(), date_added) AS date_added'.
						' FROM '.$this->CFG['db']['tbl']['attachments'].' AS bc'.
						' WHERE content_id='.$this->dbObj->Param('bid').
						' AND content_type=\''.$type.'\''.
						' ORDER BY attachment_id DESC';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($mainSolution_id));

				if (!$rs)
				    trigger_db_error($this->dbObj);

				$this->repliesArray = array();

				while($row = $rs->FetchRow())
					{
						$this->repliesArray[] = $row;
					}
				return $this->repliesArray;
			}

		/**
		 * SolutionFormHandler::deleteMoreAttachments()
		 *
		 * @param mixed $aid
		 * @param mixed $attach_name
		 * @return
		 */
		public function deleteMoreAttachments($aid, $attach_name)
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
		 * SolutionFormHandler::updateDeletedBoardsTagCount()
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
		public function getCommentDetails($comment_id)
			{
				$sql = 'SELECT comment from '.$this->CFG['db']['tbl']['board_comment'].''.
				       ' WHERE comment_id = '.$comment_id;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
		    		trigger_db_error($this->dbObj);
				while($row = $rs->FetchRow())
					{
						return $row['comment'];
					}

			}
		public function updateComment($comment_id)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['board_comment'].
							' SET comment = \''.$this->getFormField('user_comment').'\''.
							' WHERE comment_id='.$comment_id;
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
					    		trigger_db_error($this->dbObj);
			}
	   public function 	populateAjaxCommentList($comment_id)
			{
				global $smartyObj, $LANG,$CFG ;
				$sql = 'SELECT user_id, comment, DATE_FORMAT(date_added, \''.$this->CFG['mysql_format']['date_time'].'\') AS date_added'.
				        ' FROM  '.$this->CFG['db']['tbl']['board_comment'].''.
				       ' WHERE comment_id = '.$comment_id;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
		    		trigger_db_error($this->dbObj);
				$populateAjaxCommentList_arr = array();
				while($row = $rs->FetchRow())
					{
						$row['comment'] = nl2br(wordWrapManual($row['comment'], 60));
						//$row['comment'] = html_entity_decode($row['comment'], ENT_QUOTES);
						$populateAjaxCommentList_arr[$inc]['record'] = $row;
						$populateAjaxCommentList_arr[$inc]['user_details'] = $this->getUserDetails($row['user_id']);
						$populateAjaxCommentList_arr[$inc]['mysolutions']['url'] = $this->CFG['site']['url'].'admin/viewMembers.php?uid='.$populateAjaxCommentList_arr[$inc]['user_details']['user_id'];

						$populateAjaxCommentList_arr[$inc]['msg'] = 'msg_'.$row['solution_id'];
						$populateAjaxCommentList_arr[$inc]['commentSpanIDId'] = 'commentSpanID_'.$row['comment_id'];
						$inc++;
					}
			  if($this->getFormField('success') == 'success')
				  $smartyObj->assign('success','success');
			  else
				  $smartyObj->assign('success','');
  			  $smartyObj->assign('LANG',$LANG);
			  $smartyObj->assign('myobj',$this);
			  $smartyObj->assign('CFG',$CFG);
			  $smartyObj->assign('populateAjaxCommentList_arr',$populateAjaxCommentList_arr);
			  setTemplateFolder('admin/');
			  $smartyObj->display('commentSolutionsAjaxList.tpl');
			}

		public function deleteComment($comment_id)
			{
				$sql = 'DELETE from '.$this->CFG['db']['tbl']['board_comment'].''.
				       ' WHERE comment_id = '.$comment_id;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		public function postSolutionsForm($for)
			{
				global $smartyObj;

				$postSolutionsForm_arr = array();
				$postSolutionsForm_arr['for'] = $for;

				if($this->CFG['admin']['solutions']['point_notification'] && $this->CFG['admin']['reply_solutions']['allowed'] && !$this->fields_arr['aid'])
					{
						//$postSolutionsForm_arr['earn_points_details_info'] = str_ireplace('VAR_POINTS', $this->CFG['admin']['reply_solutions']['points'], $this->LANG['earn_points_details_info']);
					}

				$postSolutionsForm_arr['form_action'] = 'viewSolutions.php?action=reply&bid='.$this->fields_arr['bid'];

			    $postSolutionsForm_arr['hidden_arr'] = array('rid');

			    $postSolutionsForm_arr['attach_hidden_arr'] = array('start','bid','did');

				$postSolutionsForm_arr['board_manual'] = wordWrapManual($this->board_details['board'], $this->CFG['admin']['board']['line_length']);

				$postSolutionsForm_arr['getAttachments'] = '';
				if ($this->fields_arr['aid'])
					{
						$postSolutionsForm_arr['getAttachments'] = $this->getAttachments();
					}

				$postSolutionsForm_arr['allowed_formats'] = implode(",",$this->CFG['admin']['attachments']['format_arr']);
				if($postSolutionsForm_arr['allowed_formats'] == '')
					$postSolutionsForm_arr['allowed_formats'] = 'jpg,gif,png';
				$allowed_size = $this->CFG['admin']['attachments']['max_size'];
				$postSolutionsForm_arr['allowed_size'] = str_ireplace('VAR_SIZE', $allowed_size, $this->LANG['attachment_size_tip']);
				$postSolutionsForm_arr['attach_style'] = '';

				if($this->solution_attachment_count == $this->CFG['admin']['attachments_allowed']['count'])
					$postSolutionsForm_arr['attach_style'] = 'style="display:none;"';

		  		$postSolutionsForm_arr['attachments_allowed_manual'] = str_ireplace('VAR_COUNT', $this->CFG['admin']['attachments_allowed']['count'] ,$this->LANG['attachment_allowed_tip']);
		  		$postSolutionsForm_arr['allowed_formats_manual'] = str_ireplace('VAR_FORMAT', $postSolutionsForm_arr['allowed_formats'], $this->LANG['attachment_format_tip']);

				$smartyObj->assign('postSolutionsForm_arr', $postSolutionsForm_arr);
				setTemplateFolder('admin/', $this->CFG['admin']['index']['home_module']);
				$smartyObj->display('postSolutionsForm.tpl');

			}

		public function getAttachments()
			{
				$getAttachments_val = '';
				$getAttachments_arr = array();
				$sql = 'SELECT attachment_id, attachment_name FROM '.$this->CFG['db']['tbl']['attachments'].
					' WHERE content_id='.$this->fields_arr['aid'].' AND content_type=\'Solution\' ORDER BY date_added';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						$attach_count = 0;
						while($row = $rs->FetchRow())
							{
								$getAttachments_arr[$attach_count]['record'] = $row;
								$extern = strtolower(substr($row['attachment_name'], strrpos($row['attachment_name'], '.')+1));
								$getAttachments_arr[$attach_count]['attachment_file_name'] = getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['large_name'].'.'.$extern;
								$getAttachments_arr[$attach_count]['attachment_file_name_thumb'] = getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['thumb_name'].'.'.$extern;
								$getAttachments_arr[$attach_count]['anchor'] = 'seldel_'.$row['attachment_id'];
								$getAttachments_arr[$attach_count]['attachment']['url'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$getAttachments_arr[$attach_count]['attachment_file_name'];
								$getAttachments_arr[$attach_count]['attachment']['url_thumb'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$getAttachments_arr[$attach_count]['attachment_file_name_thumb'];
								$getAttachments_arr[$attach_count]['extern'] = $extern;
								$getAttachments_arr[$attach_count]['attachment_name'] = $row['attachment_name'];
								$getAttachments_arr[$attach_count]['attachment']['original_url'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['large_name'].'.'.$extern;
								$attach_count++;
							} // while

						$this->solution_attachment_count = $attach_count;
					}
				return $getAttachments_arr;
			}

		public function isValidDiscussionId()
			{
				$sql = 'SELECT d.discussion_id, d.discussion_title, d.visible_to, d.pcat_id, d.cat_id, d.description, d.visible_to, d.publish_status'.
						', TIMEDIFF(NOW(), date_added) as date_asked, '.$this->getUserTableField('display_name').' as asked_by'.
						', u.'.$this->getUserTableField('user_id').' as img_user_id,'.$this->getUserTableFields(array('name')).' , d.status, d.user_id'.
						', d.seo_title FROM '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE d.user_id=u.'.$this->getUserTableField('user_id').
						' AND u.'.$this->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id='.$this->dbObj->Param($this->fields_arr['did']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['did']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					{
						$this->setCommonErrorMsg($this->LANG['err_tip_invalid_question']);
						return false;
					}
				$this->discussion_details = $rs->FetchRow();
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

		public function isAddMode()
			{
				$sql = 'SELECT status, board, discussion_id FROM '.$this->CFG['db']['tbl']['boards'].
						' WHERE board_id='.$this->dbObj->Param($this->fields_arr['bid']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
				if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$ok = false;
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						switch($row['status']){
							case 'Active':
								$ok = true;
								break;
							case 'ToActivate':
								$please_publish_the_board = str_replace('VAR_BOARD', $row['board'], $this->LANG['please_publish_the_board']);
								$this->setCommonErrorMsg($please_publish_the_board);
								break;
							case 'Inactive':
								$please_activate_the_board = str_replace('VAR_BOARD', $row['board'], $this->LANG['please_activate_the_board']);
								$this->setCommonErrorMsg($please_activate_the_board);
								break;
						} // switch
					}

				if ($ok)
					{
						$ok = false;
						$sql = 'SELECT d.status, d.discussion_title, c.status AS cat_status, c.cat_name'.
								' FROM '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c'.
								' WHERE c.cat_id=d.pcat_id AND d.discussion_id='.$this->dbObj->Param($row['discussion_id']);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($row['discussion_id']));
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
					}
				if (!$ok)
					$this->setPageBlockShow('block_msg_form_error');
				return $ok;
			}
	}
//<<<<<-------------- Class SolutionFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$solutions = new SolutionFormHandler();
if($CFG['admin']['index']['activity']['show'])
	{
		$DiscussionsActivity = new DiscussionsActivityHandler();
		$solutions->discussionsActivityObj = $DiscussionsActivity;
	}
$solutions->setPageBlockNames(array('form_search', 'form_add', 'form_abuse_board', 'form_abuse_solution', 'form_confirm', 'form_board', 'form_solutions', 'form_best_solution', 'show_option_to_comment', 'cancel_option_to_comment', 'post_your_comment'));
//default form fields and values...
$solutions->setFormField('did', '');
$solutions->setFormField('bid', '');
$solutions->setFormField('aid', '');
$solutions->setFormField('viid', '');
$solutions->setFormField('auid', '');
$solutions->setFormField('search_name', '');
$solutions->setFormField('search_cat', '');
$solutions->setFormField('solution', '');
$solutions->setFormField('source', '');
$solutions->setFormField('action', '');
$solutions->setFormField('act', '');
$solutions->setFormField('reason', '');
$solutions->setFormField('str', '');
$solutions->setFormField('msg', '');
$solutions->setFormField('attachments', '');
$solutions->setFormField('attachment_id', '');
$solutions->setFormField('attach_content_id', '');
$solutions->setFormField('attachment_name', '');
$solutions->setFormField('comment_id', '');
$solutions->setFormField('c_bid', '');
$solutions->setFormField('user_comment', '');
$solutions->setFormField('success', '');
$solutions->setFormField('rid', '');
$solutions->setFormField('upl_original', array());
$solutions->setFormField('uplarr', array());
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
/*************Start navigation******/
$solutions->numpg = $CFG['data_tbl']['numpg'];
$solutions->setFormField('start', 0);
$solutions->setFormField('numpg', $CFG['data_tbl']['numpg']);//

$solutions->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$solutions->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$solutions->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
//Set tables and fields to return
$solutions->setTableNames(array());
$solutions->setReturnColumns(array());
//orderby field and orderby
$solutions->setFormField('orderby_field', '');
$solutions->setFormField('orderby', '');
/*************End navigation******/

$solutions->sanitizeFormInputs($_REQUEST);

$solutions->navigation_array = $solutions->adminNavigationDetails($solutions->getFormField('bid'));

if ($solutions->isFormPOSTed($_REQUEST, 'showOptionToComment'))
	{
		ob_start();
		$solutions->sanitizeFormInputs($_REQUEST);
		$showOptionToComment_arr = array();
		$comment_id = $solutions->getFormField('comment_id');
		$commentSpanIDId = 'commentSpanID_'.$solutions->getFormField('comment_id');
		$showOptionToComment_arr['comment']['details'] = $solutions->getCommentDetails($solutions->getFormField('comment_id'));
		$showOptionToComment_arr['submit']['onclick'] = $CFG['site']['url'].'admin/viewSolutions.php?success=success&bid='.$solutions->getFormField('bid').'&action=view&ajax_page=true&postYourComment=1&comment_id='.$solutions->getFormField('comment_id');
		$showOptionToComment_arr['cancel']['onclick'] = $CFG['site']['url'].'admin/viewSolutions.php?bid='.$solutions->getFormField('bid').'&action=view&ajax_page=true&cancelOptionToComment=1&comment_id='.$solutions->getFormField('comment_id');
		$solutions->setPageBlockShow('show_option_to_comment');
		$solutions->includeAjaxHeader();
		$smartyObj->assign('showOptionToComment_arr', $showOptionToComment_arr);
		$smartyObj->assign('comment_id', $comment_id);
		$smartyObj->assign('commentSpanIDId', $commentSpanIDId);
		setTemplateFolder('admin/');
		$smartyObj->display('commentSolutionsAjax.tpl');
		//$smartyObj->display('replyBugsAjax.tpl');
		$solutions->includeAjaxFooter();
		die();
	}
if ($solutions->isFormPOSTed($_REQUEST, 'cancelOptionToComment'))
	{
		ob_start();
		$solutions->sanitizeFormInputs($_REQUEST);
		$solutions->setPageBlockShow('cancel_option_to_comment');
		$solutions->populateAjaxCommentList($solutions->getFormField('comment_id'));
		$solutions->includeAjaxHeader();
		setTemplateFolder('admin/');
		$smartyObj->display('commentSolutionsAjax.tpl');
		$solutions->includeAjaxFooter();
		die();
	}
if ($solutions->isFormPOSTed($_REQUEST, 'postYourComment'))
	{
		ob_start();
		$solutions->sanitizeFormInputs($_REQUEST);
		$solutions->updateComment($solutions->getFormField('comment_id'));

		$solutions->setFormField('success', $solutions->getFormField('success'));
		$solutions->setCommonSuccessMsg($LANG['solutions_comment_edited_successfully']);
		$solutions->setPageBlockShow('block_msg_form_success');
		$solutions->populateAjaxCommentList($solutions->getFormField('comment_id'));
		$solutions->includeAjaxHeader();
		setTemplateFolder('admin/');
		$smartyObj->display('commentSolutionsAjax.tpl');
		$solutions->includeAjaxFooter();
		die();
		//Redirect2URL($CFG['site']['url'].'admin/viewSolutions.php?msg=5&bid='.$solutions->getFormField('c_bid'));
	}
// Default page block
$solutions->setAllPageBlocksHide();
$solutions->updateBoardViews();
#$solutions->setPageBlockShow('form_search');
$solutions->title = $LANG['open_board'];
$title_image = 'open_board';
if ($solutions->chkIsValidBoard())
	{
		if(!$solutions->isValidDiscussionId())
			Redirect2URL($CFG['site']['relative_url'].'discussions.php');

		if ($solutions->isFormGETed($_GET, 'aid'))
			$solutions->chkIsValidSolution();

		if ($solutions->isFormPOSTed($_REQUEST, 'deletemoreattachments'))
			{
				if (!isMember())
					{
						echo 'Session Expired. <a href="'.$CFG['auth']['login_url'].'?r">Login to continue..!</a>';
						die();
					}
				ob_start();

				$comment_id = $solutions->getFormField('attachment_id');
				$attachment_name = $solutions->getFormField('attachment_name');
				$solutions->deleteMoreAttachments($comment_id, $attachment_name);
				die();
			}


		$solutions->title = '';
		$title_image = '';

		$solutions->setPageBlockShow('form_board');
		$solutions->setPageBlockShow('form_solutions');
		$solutions->hidden_array = array();
		if ($solutions->isFormGETed($_GET, 'action'))
			{
				switch($solutions->getFormField('action'))
					{
						case 'reply':
							$solutions->setPageBlockHide('form_board');
							$solutions->setPageBlockHide('form_solutions');
							if ($solutions->isAddMode())
								$solutions->setPageBlockShow('form_add');
							$solutions->title = $LANG['what_is_your_solution'];
							$title_image = 'what_is_your_solution';
							break;

						case 'abuseboard':
							if ($solutions->isValidFormInputs() AND $solutions->board_details['user_id'] != $CFG['user']['user_id'])
								{
									$solutions->setPageBlockHide('form_board');
									$solutions->setPageBlockHide('form_solutions');
									$solutions->setPageBlockShow('form_abuse_board');
									$solutions->title = $LANG['report_abuse'];
									$title_image = 'report_abuse';
								}
							else
								{
									$solutions->setAllPageBlocksHide();
									$solutions->setPageBlockShow('block_msg_form_error');
									$solutions->setCommonErrorMsg($LANG['err_tip_invalid_action']);
								}
							break;
						case 'abusesolution':
							if ($solutions->isValidFormInputs() AND $solutions->solution_details['user_id'] != $CFG['user']['user_id'])
								{
									$solutions->setPageBlockHide('form_board');
									$solutions->setPageBlockHide('form_solutions');
									$solutions->setPageBlockShow('form_abuse_solution');
									$$solutions->title = $LANG['report_abuse'];
									$title_image = 'report_abuse';
								}
							else
								{
									$solutions->setAllPageBlocksHide();
									$solutions->setPageBlockShow('block_msg_form_error');
									$solutions->setCommonErrorMsg($LANG['err_tip_invalid_action']);
								}
							break;

						case 'edit':
							$solutions->chkIsNotEmpty('aid', $LANG['err_tip_compulsory']);
							if ($solutions->isValidFormInputs())
								{
									$solutions->setPageBlockHide('form_board');
									$solutions->setPageBlockHide('form_solutions');
									$solutions->setPageBlockShow('form_add');

									$solutions->setFormField('solution', $solutions->solution_details['solution']);
									$solutions->title = $LANG['solutions_edit_your_solution'];
								}
							else
								{
									$solutions->setAllPageBlocksHide();
									$solutions->setPageBlockShow('block_msg_form_error');
									$solutions->setPageBlockShow('form_board');
									$solutions->setPageBlockShow('form_solutions');
									$solutions->setCommonErrorMsg($LANG['err_tip_invalid_action']);
								}
							break;
					} // switch
			}
	if ($solutions->isFormPOSTed($_POST, 'delete_add'))
		{
			switch($solutions->getFormField('act'))
				{
					case 'delete':
						$solutions->chkIsNotEmpty('aid', $LANG['err_tip_compulsory']);
						$ans_array = explode(',', $solutions->getFormField('aid'));
						foreach($ans_array as $value){
							$solutions->deleteSolutions($CFG['db']['tbl']['boards'], $CFG['db']['tbl']['solutions'], $CFG['db']['tbl']['users_board_log'], $value);
						}
						$solutions->setPageBlockShow('block_msg_form_success');
						$solutions->setCommonSuccessMsg($LANG['solutions_deleted_successfully']);
						Redirect2URL($CFG['site']['relative_url'].'viewSolutions.php?bid='.$solutions->getFormField('bid').'&msg=delete');
						break;
					case 'deleteBoard':
						$solutions->deleteBoard($CFG['db']['tbl']['users_board_log']);
						Redirect2URL($CFG['site']['relative_url'].'manageSolutions.php?did='.$solutions->getFormField('did').'&delmsg=1');
						break;
					case 'deleteBestSolution':
						if ($solutions->chkIsValidSolution($solutions->getFormField('aid')) and $solutions->isValidFormInputs())
							$solutions->removeBestSolution();
						$solutions->setPageBlockShow('block_msg_form_success');
						$solutions->setCommonSuccessMsg($LANG['best_solutions_deleted_successfully']);
						Redirect2URL($CFG['site']['relative_url'].'viewSolutions.php?bid='.$solutions->getFormField('bid').'&msg=removebestans');
						break;
					case 'deleteSolution':
						if ($solutions->chkIsValidSolution($solutions->getFormField('aid')) and $solutions->isValidFormInputs())
							{
								$solutions->deleteSolutions($CFG['db']['tbl']['boards'], $CFG['db']['tbl']['solutions'], $CFG['db']['tbl']['users_board_log'], $solutions->getFormField('aid'));
								$solutions->removeBestSolution();
							}
						$solutions->setPageBlockShow('block_msg_form_success');
						$solutions->setCommonSuccessMsg($LANG['solutions_deleted_successfully']);
						Redirect2URL($CFG['site']['relative_url'].'viewSolutions.php?bid='.$solutions->getFormField('bid').'&msg=deleteans');
						break;
					case 'bestsolution':
						$solutions->chkIsNotEmpty('aid', $LANG['err_tip_compulsory']);
						if ($solutions->isValidFormInputs()  AND $solutions->board_details['best_solution_id'] == 0)
							{
								$solutions->updateBestSolution();
								$solutions->setPageBlockShow('block_msg_form_success');
								$solutions->setPageBlockShow('form_board');
								$solutions->setPageBlockShow('form_solutions');
								$solutions->setCommonSuccessMsg($LANG['solutions_best_solution_added_successfully']);
								Redirect2URL($CFG['site']['relative_url'].'viewSolutions.php?bid='.$solutions->getFormField('bid').'&msg=addbestsolution');
							}
						else
							{
								$solutions->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
								$solutions->setPageBlockShow('block_msg_form_error');
							}
						break;
					case 'publishsolution':
						$solutions->chkIsNotEmpty('aid', $LANG['err_tip_compulsory']);
						if ($solutions->isValidFormInputs() AND $solutions->board_details['publish_status'] == 'No')
							{
								$solutions->publishSolution();
								$solutions->setPageBlockShow('block_msg_form_success');
								$solutions->setPageBlockShow('form_board');
								$solutions->setPageBlockShow('form_solutions');
								$solutions->setCommonSuccessMsg($LANG['solutions_published_successfully']);
								Redirect2URL($CFG['site']['relative_url'].'viewSolutions.php?bid='.$solutions->getFormField('bid').'&msg=published');
							}
						else
							{
								$solutions->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
								$solutions->setPageBlockShow('block_msg_form_error');
							}
						break;
					case 'deletecomment':
						$comment_id = $solutions->getFormField('comment_id');
						$solutions->deleteComment($comment_id);
						$solutions->setPageBlockShow('block_msg_form_success');
						$solutions->setCommonSuccessMsg($LANG['solutions_resolved_successfully']);
						Redirect2URL($CFG['site']['relative_url'].'viewSolutions.php?bid='.$solutions->getFormField('bid').'&msg=resolved');
						break;

				}
		}
	if ($solutions->isFormPOSTed($_POST, 'abuse_board'))
		{
			$solutions->chkIsNotEmpty('reason', $LANG['err_tip_compulsory']);
			if ($solutions->isValidFormInputs() and $solutions->board_details['user_id'] != $CFG['user']['user_id'])
				{
					$solutions->updateAbuseBoard();
					$solutions->setPageBlockShow('block_msg_form_success');
					$solutions->setPageBlockShow('form_board');
					$solutions->setPageBlockShow('form_solutions');
					$solutions->setCommonSuccessMsg($LANG['solutions_board_abused_successfully']);
					Redirect2URL($CFG['site']['relative_url'].'viewSolutions.php?bid='.$solutions->getFormField('bid').'&msg=2');
				}
			else
				{
					$solutions->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
					$solutions->setPageBlockShow('block_msg_form_error');
				}
		}
	if ($solutions->isFormPOSTed($_POST, 'abuse_solution'))
		{
			$solutions->chkIsNotEmpty('reason', $LANG['err_tip_compulsory']);
			if ($solutions->isValidFormInputs() and $solutions->solution_details['user_id'] != $CFG['user']['user_id'])
				{
					$solutions->updateAbuseSolution();
					$solutions->setPageBlockShow('block_msg_form_success');
					$solutions->setPageBlockShow('form_board');
					$solutions->setPageBlockShow('form_solutions');
					$solutions->setCommonSuccessMsg($LANG['solutions_solution_abused_successfully']);
					Redirect2URL($CFG['site']['relative_url'].'viewSolutions.php?bid='.$solutions->getFormField('bid').'&msg=3');
				}
			else
				{
					$solutions->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
					$solutions->setPageBlockShow('block_msg_form_error');
				}
		}
	if ($solutions->isFormPOSTed($_POST, 'submit'))
		{
			$solutions->chkIsNotEmpty('solution', $LANG['err_tip_compulsory']);
			if ($solutions->isValidFormInputs())
				{
					$solutions->addSolution();
					$solutions->setCommonSuccessMsg($LANG['solutions_added_successfully']);
					$solutions->setPageBlockShow('block_msg_form_success');
					Redirect2URL($CFG['site']['relative_url'].'viewSolutions.php?bid='.$solutions->getFormField('bid').'&msg=1');
				}
			else
				{
					$solutions->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
					$solutions->setPageBlockShow('block_msg_form_error');
				}
		}
	if ($solutions->isFormPOSTed($_POST, 'update_solution'))
		{
			$solutions->chkIsNotEmpty('solution', $LANG['err_tip_compulsory']);
			if ($solutions->isValidFormInputs())
				{
					$solutions->updateSolution();
					$solutions->setCommonSuccessMsg($LANG['solutions_edited_successfully']);
					$solutions->setPageBlockShow('block_msg_form_success');
					Redirect2URL($CFG['site']['relative_url'].'viewSolutions.php?bid='.$solutions->getFormField('bid').'&msg=6');
				}
			else
				{
					$solutions->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
					$solutions->setPageBlockShow('block_msg_form_error');
				}
		}
	if ($solutions->isFormPOSTed($_POST, 'cancel'))
		{
			Redirect2URL($CFG['site']['relative_url'].'viewSolutions.php?bid='.$solutions->getFormField('bid'));
		}
	if ($solutions->isFormGETed($_GET, 'msg'))
		{
			switch($solutions->getFormField('msg'))
				{
					case 2:
						$solutions->setCommonSuccessMsg($LANG['solutions_board_abused_successfully']);
						break;
					case 3:
						$solutions->setCommonSuccessMsg($LANG['solutions_solution_abused_successfully']);
						break;
					case 4:
						$solutions->setCommonSuccessMsg($LANG['solutions_board_edited_successfully']);
						break;
					case 5:
						$solutions->setCommonSuccessMsg($LANG['solutions_comment_edited_successfully']);
						break;
					case 6:
						$solutions->setCommonSuccessMsg($LANG['solutions_edited_successfully']);
						break;
					case 'removebestans':
						$solutions->setCommonSuccessMsg($LANG['best_solutions_deleted_successfully']);
						break;
					case 'delete':
						$solutions->setCommonSuccessMsg($LANG['solutions_deleted_successfully']);
						break;
					case 'addbestsolution':
						$solutions->setCommonSuccessMsg($LANG['solutions_best_solution_added_successfully']);
						break;
					case 'published':
						$solutions->setCommonSuccessMsg($LANG['solutions_published_successfully']);
						break;
					default:
						$solutions->setCommonSuccessMsg($LANG['solutions_added_successfully']);
						break;
				} // switch
			$solutions->setPageBlockShow('block_msg_form_success');
		}
	}
else
	{
		$solutions->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
		$solutions->setPageBlockShow('block_msg_form_error');
	}
//<<<<<<<---------------code ends-------------///
if ($solutions->isShowPageBlock('form_board'))
	{
		$solutions->form_board['delete_hidden_arr'] = array('did');
		$solutions->form_board['attach_style'] = '';
		$solutions->form_board['attach_hidden_arr'] = array('start','bid','did');
	}

if ($solutions->isShowPageBlock('form_search'))
	{
		$solutions->form_search['search_cat_arr'] = array("1" => $LANG['login_user_name'], "2" => $LANG['search_type_email'],
													"3" => $LANG['active_boards'], "4" => $LANG['discuzz_common_inactive_boards'],
													"5" => $LANG['search_type_blocked'], "6" => $LANG['boards'],
													"7" => $LANG['search_type_tags'], "8" => $LANG['categories']);
	}

if ($solutions->isShowPageBlock('form_board'))
	{
		$solutions->form_board['displayBoardDetails_arr'] = $solutions->displayBoardDetails();
	}

if ($solutions->isShowPageBlock('form_solutions'))
	{
		$solutions->setTableNames(array($CFG['db']['tbl']['solutions'].' as a', $CFG['db']['tbl']['users'].' as u'));
		$solutions->setReturnColumns(array('a.solution_id, a.user_id, a.solution, a.board_id, a.status, a.abuse_count, TIMEDIFF(NOW(), solution_added) as solution_added'.
						', u.'.$solutions->getUserTableField('user_id').' as img_user_id, '.$solutions->getUserTableFields(array('gender'), false).$solutions->getUserTableField('display_name').' as solutioned_by'));

		$solutions->setFormField('orderby_field', 'a.solution_id');
		$solutions->setFormField('orderby', 'DESC');
		$solutions->buildSelectQuery();
		$solutions->buildConditionQuery();
		$solutions->buildSortQuery();
		$solutions->buildQuery();
		//$solutions->printQuery();
		$solutions->executeQuery();
		$solutions->form_solutions['displayAllSolutions_arr'] = $solutions->displayAllSolutions();

		if ($solutions->isResultsFound())
			{
				$solutions->form_solutions['pagingArr'] = array();
				if ($solutions->getFormField('bid'))
					$solutions->form_solutions['pagingArr'] = array('bid');

				$smartyObj->assign('smarty_paging_list', $solutions->populatePageLinksGET($solutions->getFormField('start'), $solutions->form_solutions['pagingArr']));
				$solutions->form_solutions['confirm_delete'] = nl2br($solutions->LANG['confirm_delete_message']);
			}
	}
$solutions->confirm['hidden_arr1'] = array('comment_id');
//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$solutions->includeHeader();
?>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>tools/bbcode/ed.js"></script>
<?php
//include the content of the page
setTemplateFolder('admin/', $CFG['admin']['index']['home_module']);
$smartyObj->display('viewSolutions.tpl');
?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm','selMsgConfirm1', 'selDelAttachconfirm', 'lightwindow_contents');

	function showdiv(divid)
		{
			document.getElementById[divid].style.display = '';
		}
	function chkMessage(message,form)
		{
			var comm = document.getElementById(message).value
			if(comm=='' || comm == null)
				{
					alert_manual("<?php echo $LANG['enter_proper_message'];?>");
				}
			else
				return 0;

		}
	function checkifAlreadyOpen()
		{
			 var a = document.getElementsByTagName("textarea").length;
			 if(a > 0)
			 	{
					alert_manual('<?php echo $LANG['close_previous'];?>');
					return false;
				}
			return true;
		}

</script>
<?php
if($solutions->isShowPageBlock('form_add'))
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

if(count($solutions->getFormField('uplarr')) != 0  && $solutions->isShowPageBlock('form_add') )
	{

	?>

		<script language="javascript" type="text/javascript">
			var required_array =  new Array();
			var required_ori_array =  new Array();
			var i = 0;
			var j= 0;
		</script>
		<?php
		$upl_count  =  count($solutions->getFormField('uplarr'));
		$req_uploaded_array = $solutions->getFormField('uplarr');
		$req_ori_uploaded_array = $solutions->getFormField('upl_original');
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
$solutions->includeFooter();
?>
