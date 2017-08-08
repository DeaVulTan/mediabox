<?php
/**
 * solutions rating page.
 *
 * PHP version 5.0
 *
 * @category	Discuzz
 * @package		SolutionRatingHandler
 * @author 		karthiselvam_75ag08, shankar_76ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2008-12-22
 */
require_once('../common/configs/config.inc.php');
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['html']['is_use_footer'] = false;
$CFG['http_headers']['is_cache'] = false;
$CFG['http_headers']['is_use_if_modified_since'] = false;
$CFG['is']['ajax_page'] = true;
$CFG['site']['is_module_page']='discussions';
$CFG['auth']['is_authenticate'] = 'members';
/**
 * To include various types of files
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//FOR RAYZZ INTEGRATION
if(class_exists('DiscussionHandler'))
	{
		$discussionHandler = new DiscussionHandler();
		$smartyObj->assign_by_ref('discussion', $discussionHandler);
	}

//-------------- Class LoginFormHandler begins --------------->>>>>//
class SolutionRatingHandler extends FormHandler
	{
		/**
		 * SolutionRatingHandler::addBoardRating()
		 *
		 * to add rating details
		 *
		 * @param mixed $users_stared_board_table
		 * @param mixed $board_table
		 * @param mixed $users_board_log_table
		 * @param mixed $board_id
		 * @param mixed $user_id
		 * @param mixed $session_user_id
		 * @param mixed $cfg_project_path_relative
		 * @param mixed $relative_path
		 * @return
		 */
		public function addBoardRating($users_stared_board_table, $board_table, $users_board_log_table, $board_id, $user_id, $session_user_id, $cfg_project_path_relative, $relative_path)
			{
				$old_points = $old_ratings = $rating = 0;

				$param_arr = array();
				$increase_rating = $this->CFG['admin']['rate']['points'];
				$return_rating = -$this->CFG['admin']['rate']['points'];
				$alt_text = $this->LANG['solutions_unrate_it'];

				$rateimg['rateit_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/board_icon-rateit.gif';
				$rateimg['rateitdisable_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/board_icon-rateitdisable.gif';
				$rateimg['unrateit_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/board_icon-unrateit.gif';
				$rateimg['unrateitdisable_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/board_icon-unrateitdisable.gif';

				if($this->fields_arr['rating'] == $this->CFG['admin']['rate']['points'])
					{
						$sql = 'INSERT INTO '.$users_stared_board_table.' SET rating='.$this->dbObj->Param('rating').
									', board_id='.$this->dbObj->Param('bid').', user_id='.$this->dbObj->Param('user_id');

						$param_arr[] = $this->fields_arr['rating'];
						$param_arr[] = $this->fields_arr['bid'];
						$param_arr[] = $session_user_id;

						$rate_img = $rateimg['unrateit_img'];
					}
				else
					{
						$sql = 'DELETE FROM '.$users_stared_board_table.
								' WHERE board_id='.$this->dbObj->Param('bid').' AND user_id='.$this->dbObj->Param('user_id');
						$param_arr[] = $this->fields_arr['bid'];
						$param_arr[] = $session_user_id;
						$increase_rating = -$this->CFG['admin']['rate']['points'];
						$return_rating = $this->CFG['admin']['rate']['points'];
						$alt_text = $this->LANG['solutions_rate_it'];

						$rate_img = $rateimg['rateit_img'];
					}

				$stmt = $this->dbObj->Prepare($sql);
				$result = $this->dbObj->Execute($stmt, $param_arr);
				if (!$result)
						trigger_db_error($this->dbObj);

				$avg_rating = 0;
				$sql = 'SELECT SUM(rating) as avg_rating FROM '.$users_stared_board_table.' WHERE board_id = '.$this->dbObj->Param('bid');
				$stmt = $this->dbObj->Prepare($sql);
				$result = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
				if (!$result)
						trigger_db_error($this->dbObj);
				$row = $result->FetchRow();
				if($row['avg_rating'] != '')
					$avg_rating = $row['avg_rating'];

				$sql = 'UPDATE '.$board_table.' set total_stars = '.$this->dbObj->Param($avg_rating).
					   ' WHERE board_id = '.$this->dbObj->Param('bid');
				$stmt = $this->dbObj->Prepare($sql);
				$result = $this->dbObj->Execute($stmt, array($avg_rating, $this->fields_arr['bid']));
				if (!$result)
						trigger_db_error($this->dbObj);

				$sql = 'UPDATE '.$users_board_log_table.' set total_points=total_points+'.$this->dbObj->Param('points').
					   ', date_updated=NOW() WHERE user_id = '.$this->dbObj->Param('uid');
				$stmt = $this->dbObj->Prepare($sql);
				$result = $this->dbObj->Execute($stmt, array($increase_rating, $this->fields_arr['uid']));
				if (!$result)
						trigger_db_error($this->dbObj);

				//to display stars
				$rating_count = 0;
				$sql = 'SELECT SUM(rating) as cnt FROM '.$users_stared_board_table.' WHERE board_id = '.$this->dbObj->Param('bid');
				$stmt = $this->dbObj->Prepare($sql);
				$result = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
				if (!$result)
						trigger_db_error($this->dbObj);
				$row = $result->FetchRow();
				if($row['cnt'] != '')
					$rating_count = $row['cnt'];

				$display_arr = array();
				$display_arr['rating_link'] = true;
				$display_arr['total_rating'] = $rating_count;
				$this->LANG['index_rating_lang'] = ($rating_count==1)?$this->LANG['index_rating']:$this->LANG['index_ratings'];
				$display_arr['alt_text'] = $alt_text;
				$display_arr['rate_img'] = $rate_img;

				$display_arr['board_id'] = $board_id;
				$display_arr['rating_url'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/ratingSolution.php?action=board&bid='.$this->fields_arr['bid'].'&uid='.$this->fields_arr['uid'].'&rating='.$return_rating;
				if (!$this->CFG['admin']['board']['unrate'])
					{
						$display_arr['rating_link'] = false;
						$display_arr['alt_text'] = $this->LANG['solutions_rated_it'];
						$display_arr['rate_img'] = $rateimg['unrateitdisable_img'];
					}
				return $display_arr;
			}

		/**
		 * SolutionRatingHandler::addSolutionRating()
		 *
		 * to add rating details
		 *
		 * @param mixed $users_stared_solution_table
		 * @param mixed $solutions_table
		 * @param mixed $users_board_log_table
		 * @param mixed $solution_id
		 * @param mixed $user_id
		 * @param mixed $session_user_id
		 * @param mixed $cfg_project_path_relative
		 * @param mixed $relative_path
		 * @param mixed $id_cnt
		 * @return
		 */
		public function addSolutionRating($users_stared_solution_table, $solutions_table, $users_board_log_table, $solution_id, $user_id, $session_user_id, $cfg_project_path_relative, $relative_path, $id_cnt, $is_best=0)
			{
				$param_arr = array();
				$increase_rating = $this->CFG['admin']['rate']['points'];
				$return_rating = -$this->CFG['admin']['rate']['points'];
				$alt_text = $this->LANG['solutions_unrate_it'];

				$rateimg['rateit_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/icon-rateit.gif';
				$rateimg['rateitdisable_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/icon-rateitdisable.gif';
				$rateimg['unrateit_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/icon-unrateit.gif';
				$rateimg['unrateitdisable_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/icon-unrateitdisable.gif';

				if($this->fields_arr['rating'] == $this->CFG['admin']['rate']['points'])
					{
						$sql = 'INSERT INTO '.$users_stared_solution_table.' SET rating='.$this->dbObj->Param('rating').
									', solution_id='.$this->dbObj->Param('sid').', user_id='.$this->dbObj->Param('user_id');

						$param_arr[] = $this->fields_arr['rating'];
						$param_arr[] = $this->fields_arr['sid'];
						$param_arr[] = $session_user_id;

						$rate_img = $rateimg['unrateit_img'];
					}
				else
					{
						$sql = 'DELETE FROM '.$users_stared_solution_table.
								' WHERE solution_id='.$this->dbObj->Param('sid').' AND user_id='.$this->dbObj->Param('user_id');

						$param_arr[] = $this->fields_arr['sid'];
						$param_arr[] = $session_user_id;
						$increase_rating = -$this->CFG['admin']['rate']['points'];
						$return_rating = $this->CFG['admin']['rate']['points'];
						$alt_text = $this->LANG['solutions_rate_it'];

						$rate_img = $rateimg['rateit_img'];
					}

				$stmt = $this->dbObj->Prepare($sql);
				$result = $this->dbObj->Execute($stmt, $param_arr);
				if (!$result)
						trigger_db_error($this->dbObj);


				$avg_rating = 0;
				$sql = 'SELECT SUM(rating) as avg_rating FROM '.$users_stared_solution_table.' WHERE solution_id = '.$this->dbObj->Param('sid');
				$stmt = $this->dbObj->Prepare($sql);
				$result = $this->dbObj->Execute($stmt, array($this->fields_arr['sid']));
				if (!$result)
						trigger_db_error($this->dbObj);
				$row = $result->FetchRow();
				if($row['avg_rating'] != '')
					$avg_rating = $row['avg_rating'];

				$sql = 'UPDATE '.$solutions_table.' set total_stars = '.$this->dbObj->Param($avg_rating).
					   ' WHERE solution_id = '.$this->dbObj->Param('sid');
				$stmt = $this->dbObj->Prepare($sql);
				$result = $this->dbObj->Execute($stmt, array($avg_rating, $this->fields_arr['sid']));
				if (!$result)
						trigger_db_error($this->dbObj);

				$sql = 'UPDATE '.$users_board_log_table.' set total_points=total_points+'.$this->dbObj->Param('points').
					   ', date_updated=NOW() WHERE user_id = '.$this->dbObj->Param('uid');
				$stmt = $this->dbObj->Prepare($sql);
				$result = $this->dbObj->Execute($stmt, array($increase_rating, $this->fields_arr['uid']));
				if (!$result)
						trigger_db_error($this->dbObj);

				//to display stars
				$rating_count = 0;
				$sql = 'SELECT SUM(rating) as cnt FROM '.$users_stared_solution_table.' WHERE solution_id = '.$this->dbObj->Param('sid');
				$stmt = $this->dbObj->Prepare($sql);
				$result = $this->dbObj->Execute($stmt, array($this->fields_arr['sid']));
				if (!$result)
						trigger_db_error($this->dbObj);
				$row = $result->FetchRow();
				if($row['cnt'] != '')
					$rating_count = $row['cnt'];

				$display_arr = array();
				$display_arr['rating_link'] = true;
				$display_arr['total_rating'] = $rating_count;
				$this->LANG['index_rating_lang'] = ($rating_count==1)?$this->LANG['index_rating']:$this->LANG['index_ratings'];
				$display_arr['id_cnt'] = $id_cnt;
				$display_arr['alt_text'] = $alt_text;
				$display_arr['rate_img'] = $rate_img;

				if($is_best)
					$display_arr['star_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/icon-bestanswer.gif';
				else
					$display_arr['star_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/icon-answerstar.gif';

				$display_arr['solution_id'] = $solution_id;
				$display_arr['rating_url'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/ratingSolution.php?action=solutions&sid='.$this->fields_arr['sid'].'&uid='.$this->fields_arr['uid'].'&is_best='.$is_best.'&rating='.$return_rating.'&id_cnt='.$id_cnt;
				if (!$this->CFG['admin']['solution']['unrate'])
					{
						$display_arr['rating_link'] = false;
						$display_arr['alt_text'] = $this->LANG['solutions_rated_it'];
						$display_arr['rate_img'] = $rateimg['unrateitdisable_img'];
					}
				return $display_arr;
			}
	}
//----------------------------- Code begins ------------------>>>>>//
$solutionRating = new SolutionRatingHandler();
$solutionRating->setPageBlockNames(array('solution_rating', 'board_rating'));
$solutionRating->setFormField('action', '');
$solutionRating->setFormField('sid', '');
$solutionRating->setFormField('bid', '');
$solutionRating->setFormField('uid', '');
$solutionRating->setFormField('rating', '');
$solutionRating->setFormField('id_cnt', '');
$solutionRating->setFormField('is_best', 0);
$solutionRating->setAllPageBlocksHide();
if ($solutionRating->isFormGETed($_GET, 'action'))
	{
		$solutionRating->sanitizeFormInputs($_GET);
		switch($solutionRating->getFormField('action'))
			{
				case 'solutions':
					if ($solutionRating->getFormField('sid') and $solutionRating->getFormField('uid') and $solutionRating->getFormField('rating'))
						{
							$solutionRating->setFormField('solution_id', $solutionRating->getFormField('sid'));
							$solutionRating->setFormField('user_id', $solutionRating->getFormField('uid'));
							$solutionRating->solution_rating['addSolutionRating'] = $solutionRating->addSolutionRating($CFG['db']['tbl']['users_stared_solution'],
																				  $CFG['db']['tbl']['solutions'],
																				  $CFG['db']['tbl']['users_board_log'],
																				  $solutionRating->getFormField('sid'),
																				  $solutionRating->getFormField('uid'),
																				  $CFG['user']['user_id'],
																				  $CFG['site']['project_path_relative'],
																				  $CFG['site']['relative_url'],
																				  $solutionRating->getFormField('id_cnt'),
																				  $solutionRating->getFormField('is_best'));
							$solutionRating->setPageBlockShow('solution_rating');
						}
					break;
				case 'board':
					if ($solutionRating->getFormField('bid') and $solutionRating->getFormField('uid') and $solutionRating->getFormField('rating'))
						{
							$solutionRating->setFormField('board_id', $solutionRating->getFormField('bid'));
							$solutionRating->setFormField('user_id', $solutionRating->getFormField('uid'));
							$solutionRating->board_rating['addBoardRating'] = $solutionRating->addBoardRating($CFG['db']['tbl']['users_stared_board'],
																					  $CFG['db']['tbl']['boards'],
																					  $CFG['db']['tbl']['users_board_log'],
																					  $solutionRating->getFormField('bid'),
																					  $solutionRating->getFormField('uid'),
																					  $CFG['user']['user_id'],
																					  $CFG['site']['project_path_relative'],
																					  $CFG['site']['relative_url']);
							$solutionRating->setPageBlockShow('board_rating');
						}
					break;
			} // switch
	}
//<<<<<------------------------- Code ends ----------------------------------//

//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$solutionRating->includeAjaxHeader();
//include the content of the page
setTemplateFolder('members/', $CFG['admin']['index']['home_module']);
$smartyObj->display('ratingSolution.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$solutionRating->includeAjaxFooter();
?>