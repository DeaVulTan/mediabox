<?php
/**
 *
 * PHP version 5.0
 *
 * @category	Discuzz
 * @package		DiscussionHandler
 * @author		saravanan_024at09
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id : $
 * @since 		2008-11-05
 */
if(class_exists('ListRecordsHandler'))
	{
		$parent_class = 2;
	}
else
	{
		$parent_class = 1;
	}

switch($parent_class)
	{
		case 2:
			class Handlers extends ListRecordsHandler{}
			break;
		case 1:
		default:
			class Handlers extends FormHandler{}
			break;
	}

class DiscussionHandler extends Handlers
	{
		public $_currentPage;
		public $_common_words = array();

		public function setIHObject($imObj)
			{
				$this->imageObj = $imObj;
			}


		/**
		 * DiscussionsHandler::getTotalFriends()
		 *
		 * @param mixed $owner_id
		 * @return
		 */
		public function getTotalFriends($owner_id)
			{
				if(isset($this->TotalFriends_arr[$owner_id]))
					{
						return $this->TotalFriends_arr[$owner_id];
					}
				$sql = 'SELECT total_friends FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param('owner_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($owner_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
				    {
				        $this->TotalFriends_arr[$owner_id] = $row['total_friends'];
						return $row['total_friends'];
				    }
				$this->TotalFriends_arr[$owner_id] = 0;
				return 0;
			}
		public function adminNavigationDetails($bid)
			{
				$sql = 'SELECT d.discussion_title, d.discussion_id, b.board, b.board_id FROM '.$this->CFG['db']['tbl']['boards'].
						' as b LEFT JOIN '.$this->CFG['db']['tbl']['discussions'].' as d ON  b.discussion_id=d.discussion_id'.
						' WHERE b.board_id ='.$this->dbObj->Param('bid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($bid));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$row['discussion_title'] = stripString($row['discussion_title'], $this->CFG['admin']['board']['tiny_length']);
						$row['board_title'] = stripString($row['board'], $this->CFG['admin']['board']['tiny_length']);
					}

				return $row;

			}
		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function chkIsBoardAbusedAlready($qid)
			{
				$uid = $this->CFG['user']['user_id'];
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['abuse_boards'].
						' WHERE board_id='.$this->dbObj->Param('qid').
						' AND reported_by='.$this->dbObj->Param('uid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($qid, $uid));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					return true;
				return false;
			}
		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function chkIsSolutionAbusedAlready($aid)
			{
				$uid = $this->CFG['user']['user_id'];
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['abuse_solutions'].
						' WHERE solution_id='.$this->dbObj->Param('aid').
						' AND reported_by='.$this->dbObj->Param('uid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($aid, $uid));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					return true;
				return false;
			}
		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function commonDeleteAttachments($content_type, $content_id)
			{
				$sql = 'SELECT attachment_id, attachment_name FROM '.$this->CFG['db']['tbl']['attachments'].
						' WHERE content_type=\''.$content_type.'\''.
						' AND content_id IN('.$content_id.')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);
				while($row=$rs->FetchRow())
					{
						$extern = strtolower(substr($row['attachment_name'], strrpos($row['attachment_name'], '.')+1));
						// for image formats only
						if(in_array($extern, $this->CFG['admin']['attachments']['image_formats']))
							{
								$attachment_large_file_name = $this->CFG['site']['project_path'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['large_name'].'.'.$extern;
								$attachment_small_file_name = $this->CFG['site']['project_path'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['small_name'].'.'.$extern;
								$attachment_thumbnail_file_name = $this->CFG['site']['project_path'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['thumb_name'].'.'.$extern;
								@unlink($attachment_large_file_name);
								@unlink($attachment_small_file_name);
								@unlink($attachment_thumbnail_file_name);
							}
						else // for other formats like doc,pdf,..
							{
								$attachment_large_file_name = $this->CFG['site']['project_path'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['large_name'].'.'.$extern;
								@unlink($attachment_large_file_name);
							}
					}

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['attachments'].
						' WHERE content_type=\''.$content_type.'\''.
						' AND content_id IN('.$content_id.')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);
			}
		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function decreaseBestSolutionPoints($uid)
			{
				if ($uid and $this->CFG['admin']['best_solutions']['allowed'])
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
								' SET total_points = total_points - '.$this->CFG['admin']['best_solutions']['points'].
								' , total_best_solution = total_best_solution - 1'.
								' WHERE user_id='.$this->dbObj->Param($uid);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($uid));
						if (!$rs)
							    trigger_db_error($this->dbObj);
					}
			}
		/**
		 * DiscussionHandler::getBoardDetails()
		 *
		 * @param integer $board_id
		 * @return
		 */
		public function getBoardDetails($board_id=0)
			{
				if (isset($this->_cache_board_details[$board_id]))
					{
						return $this->_cache_board_details[$board_id];
					}


				if(isMember())
					$this->CFG['admin']['new_post_day'] = $this->CFG['user']['last_active'];
				else
					$this->CFG['admin']['new_post_day'] = '0000-00-00 00:00:00';


				$sql = 'SELECT board_id, b.board, b.last_post_by, b.seo_title, b.description,b.rating_total, b.rating_count, best_solution_id'.
						', b.solution_added, DATE_FORMAT(solution_added, \''.$this->CFG['mysql_format']['date_time_meridian'].'\') as last_post_date'.
						', DATE_FORMAT(solution_added, \''.$this->CFG['mysql_format']['new_date'].'\') as last_post_date_only'.
						', DATE_FORMAT(solution_added, \'%h:%m %p\') as last_post_time_only, b.visible_to, b.readonly, b.total_solutions'.
						', b.total_views, b.status, b.user_id, u.'.$this->getUserTableField('display_name').' as asked_by'.
						', lp.'.$this->getUserTableField('display_name').' as last_post_name, lp.'.$this->getUserTableField('name').' as last_post_user'.
						', u.'.$this->getUserTableField('name').' AS name, board, total_stars'.
						', DATE_FORMAT(board_added, \''.$this->CFG['mysql_format']['new_date'].'\') as board_added_date'.
						', DATE_FORMAT(board_added, \'%h:%m %p\') as board_added_time'.
						', DATE_FORMAT(board_added, \''.$this->CFG['mysql_format']['date_time_meridian'].'\') as board_added'
						.' FROM '.$this->CFG['db']['tbl']['boards'].' as b'.
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as lp ON lp.'.$this->getUserTableField('user_id').'=b.last_post_by, '.$this->CFG['db']['tbl']['users'].' as u'.
						' WHERE b.user_id=u.'.$this->getUserTableField('user_id').' AND u.'.$this->getUserTableField('user_status').'=\'Ok\''.
						' AND (b.status = \'Active\') AND b.board_id='.$this->dbObj->Param('bid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($board_id));
					if (!$rs)
						trigger_db_error($this->dbObj);

				$board_details = array();
				if ($rs->PO_RecordCount())
					{
						$board_details = $row = $rs->FetchRow();
						$board_details['pubdate']  = date('d M Y',strtotime($board_details['board_added']));
						//$board_details['pubdate']  = getTimeDiffernceFormat(getDateTimeDiff(date('Y-m-d h:i:s',strtotime($board_details['board_added'])),date('Y-m-d h:i:s')));

						$board_details['qLink'] = getUrl('solutions', '?title='.$board_details['seo_title'], $board_details['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']);
						$board_details['board_link']= '<a href="'.$board_details['qLink'].'">'.$board_details['board'].'</a>';
						$board_details['best_board_link']= '<a href="'.$board_details['qLink'].'">'.$board_details['board'].'</a>';
						$board_details['asked_by_link'] = '<a href="'.getMemberUrl($board_details['user_id'], $board_details['name']).'">'.stripString($board_details['asked_by'], $this->CFG['username']['medium_length']).'</a>';
						$board_details['asked_by_link1'] = '<a href="'.getMemberUrl($board_details['user_id'], $board_details['name']).'">'.stripString($board_details['asked_by'], 11).'</a>';
						$board_details['bestIcon'] = $board_details['legendIcon'] = '';

						if($row['last_post_user'])
							$board_details['last_post_by'] = '<a href="'.getMemberUrl($row['last_post_by'], $row['last_post_user']).'">'.stripString($row['last_post_name'], $this->CFG['username']['medium_length']).'</a>';
						else
							$board_details['last_post_by'] = '';

						$board_details['last_post_on'] = $row['last_post_date'];
						$board_details['last_post_date_only'] = $row['last_post_date_only'];
						$board_details['last_post_time_only'] = $row['last_post_time_only'];

						$row['isNewPost'] = $this->chkIsNewPostOnthisBoard($this->CFG['user']['user_id'], $this->CFG['remote_client']['ip'], $row['board_id'], $row['solution_added']);

						$board_details['appendIcon'] = ' clsAppendNoNewThread';
						if($row['isNewPost'])
							$board_details['appendIcon'] = ' clsAppendNewThread';

						if($row['best_solution_id'])
							{
								$board_details['bestIcon'] = '<img alt="" src="'.$this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/icon-bestsolutionsmall.gif" />';
							}
						if($row['readonly'] == 'Yes')
							{
								$board_details['legendIcon'] = 'clsIconROThread';
							}
						elseif($row['total_solutions'] >= $this->CFG['admin']['hot_board']['limit'])
							{
								$board_details['legendIcon'] = 'clsIconHotThread';
							}
						elseif(isMember() and $this->myPostIncludedBoard($row['board_id']))
							{
								$board_details['legendIcon'] = 'clsIconMyThread';
							}
						elseif($row['isNewPost'])
							{
								$board_details['legendIcon'] = 'clsIconNewThread';
							}
						else
							{
								$board_details['legendIcon'] = 'clsIconNoNewThread';
							}
					}

				$this->_cache_board_details[$board_id] = $board_details;
				return $board_details;
			}

		/**
		 * DiscussionHandler::myPostIncludedBoard()
		 *
		 * @param mixed $board_id
		 * @return
		 */
		public function myPostIncludedBoard($board_id)
			{
				$sql = 'SELECT solution_id FROM '.$this->CFG['db']['tbl']['solutions'].' AS s'.
						' WHERE s.status IN (\'Active\')'.
						' AND s.user_id='.$this->dbObj->Param('uid').
						' AND s.board_id='.$this->dbObj->Param('bid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $board_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);


				if ($rs->PO_RecordCount())
					return true;

				return false;
			}

		/**
		 * DiscussionHandler::getSolutionDetails()
		 *
		 * @param mixed $solution_id
		 * @return
		 */
		public function getSolutionDetails($solution_id)
			{
				$sql = 'SELECT s.solution_id, s.board_id, s.total_stars,s.rating_total,s.rating_count, s.user_id, s.solution'.
						', DATE_FORMAT(solution_added, \''.$this->CFG['mysql_format']['date_time_meridian'].'\') as date_added'.
						', TIMEDIFF(NOW(), solution_added) as solution_added, u.'.$this->getUserTableField('user_id').' as img_user_id'.
						', u.'.$this->getUserTableField('name').' as name, '.$this->getUserTableField('display_name').' as solutioned_by'.
						' FROM '.$this->CFG['db']['tbl']['solutions'].' AS s, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE s.user_id=u.'.$this->getUserTableField('user_id').
						' AND u.'.$this->getUserTableField('user_status').'=\'Ok\''.
						' AND s.solution_id='.$this->dbObj->Param('aid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($solution_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$solutionDetails = array();
				$req_arr = array('img_path', 't_height', 't_width', 's_height', 's_width', 'photo_server_url', 'photo_ext', 'gender');
				if ($rs->PO_RecordCount())
					{
						$solutionDetails = $rs->FetchRow();
						//getting user info..
						$user_info_details_arr = getUserInfoDetails($req_arr, 'user_id', $solutionDetails['user_id']);
						$solutionDetails = array_merge($solutionDetails, $user_info_details_arr);

						$boardDetails = $this->getBoardDetails($solutionDetails['board_id']);
						if(!isset($boardDetails['board']))
							return;
						$solutionDetails['board'] = $boardDetails['board'];
						$solutionDetails['board_added'] = $boardDetails['board_added'];
						$solutionDetails['seo_title'] = $boardDetails['seo_title'];
						$solutionDetails['qLink'] = $boardDetails['qLink'];
						$solutionDetails['board_link'] = $boardDetails['board_link'];
						$solutionDetails['asked_by_link'] = $boardDetails['asked_by_link'];
                        $solutionDetails['solutioned_by_link'] = '<a href="'.getMemberUrl($solutionDetails['user_id'], $solutionDetails['name']).'">'.$solutionDetails['solutioned_by'].'</a>';
						$solutionId = 'solutionmore'.$solution_id;
						$solutionDetails['aLink'] = getUrl('solutions', '?title='.$boardDetails['seo_title'], $boardDetails['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']).'#'.$solutionId;
						$solutionDetails['solution_link'] = '<a href="'.$boardDetails['qLink'].'">'.wordWrapManual($solutionDetails['solution'], $this->CFG['admin']['board']['line_length'], $this->CFG['admin']['board']['short_length']).'</a>';

					}
				return $solutionDetails;
			}

		/**
		 * DiscussionHandler::getRecentBoards()
		 *
		 * @param integer $limit
		 * @return
		 */
		public function getRecentBoards($limit = 5,$current_id='')
			{
				if ($current_id != '') {
					$userCondition = ' AND u. user_id ='.$current_id;
				}
				else
					$userCondition = '';
				$sql = 'SELECT q.board_id FROM '.$this->CFG['db']['tbl']['boards'].' AS q'.
						' WHERE q.status IN (\'Active\')'.
						' AND EXISTS(SELECT 1 FROM  '.$this->CFG['db']['tbl']['users'].' AS u WHERE u.'.$this->getUserTableField('user_id').' = q.user_id  AND u.'.$this->getUserTableField('user_status').' = \'OK\''.$userCondition.')'.
						' AND EXISTS(SELECT 1 FROM  '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c, '.$this->CFG['db']['tbl']['users'].' AS ud'.
						' WHERE d.pcat_id=c.cat_id AND c.status=\'Active\' AND d.user_id = ud.'.$this->getUserTableField('user_id').' AND ud.'.$this->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id = q.discussion_id  AND d.status = \'Active\')'.
						' ORDER BY board_id DESC LIMIT 0,'.$limit;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
						trigger_db_error($this->dbObj);

				$recent_boards = array();
				while($row = $rs->FetchRow())
					{
						$recent_boards[] = $row['board_id'];
					}
				return $recent_boards;
			}

		/**
		 * DiscussionHandler::getRecentlySolutionsBoards()
		 *
		 * @param integer $limit
		 * @return
		 */
		public function getRecentlySolutionsBoards($limit = 5)
			{
				$sql = 'SELECT q.board_id FROM '.$this->CFG['db']['tbl']['boards'].' AS q'.
						' WHERE q.status IN (\'Active\') AND total_solutions >0'.
						' AND EXISTS(SELECT 1 FROM  '.$this->CFG['db']['tbl']['users'].' AS u WHERE u.'.$this->getUserTableField('user_id').' = q.user_id  AND u.'.$this->getUserTableField('user_status').' = \'OK\')'.
						' AND EXISTS(SELECT 1 FROM  '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c, '.$this->CFG['db']['tbl']['users'].' AS ud'.
						' WHERE d.pcat_id=c.cat_id AND c.status=\'Active\' AND d.user_id = ud.'.$this->getUserTableField('user_id').' AND ud.'.$this->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id = q.discussion_id  AND d.status = \'Active\')'.
						' ORDER BY solution_added DESC LIMIT 0,'.$limit;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$recent_boards = array();
				while($row = $rs->FetchRow())
					{
						$recent_boards[] = $row['board_id'];
					}
				return $recent_boards;
			}

		/**
		 * DiscussionHandler::displayRecentBoards()
		 *
		 * @param mixed $limit
		 * @param mixed $close
		 * @return
		 */
		public function displayRecentBoards($limit = 5 , $close = NULL,$currentuser_id = '')
			{
				$this->displayRecentBoards_arr	=	array();
				$this->displayRecentBoards_arr['recent_boards']	=	$recent_boards = $this->getRecentBoards($limit,$currentuser_id);
				$this->displayRecentBoards_arr['have_boards']	=		$have_boards = false;
				if ($recent_boards)
					{
						$i = 0;
						$inc	=	0;
						$this->displayRecentBoards_arr['row']	=	array();
						foreach($recent_boards as $eachBoard)
							{
								$this->displayRecentBoards_arr['row'][$inc]['boardDetails']	=	$boardDetails = $this->getBoardDetails($eachBoard);
								if (!$boardDetails)
									continue;
								$this->displayRecentBoards_arr['have_boards']	=	$have_boards = true;
								$i++;
								$this->displayRecentBoards_arr['row'][$inc]['clsOddOrEvenBoard']	=	$clsOddOrEvenBoard = 'clsEvenBoard';
								if ($i%2)
									$this->displayRecentBoards_arr['row'][$inc]['clsOddOrEvenBoard']	=	$clsOddOrEvenBoard = 'clsOddBoard';
								$this->displayRecentBoards_arr['row'][$inc]['solution_plural']	=	$solution_plural = $this->LANG['discuzz_common_total_solution'];
								if($boardDetails['total_solutions']!= 1)
									$this->displayRecentBoards_arr['row'][$inc]['solution_plural']	=	$solution_plural = $this->LANG['solutions'];
								$this->displayRecentBoards_arr['row'][$inc]['boardDetails']['image_id']	=	$boardDetails['image_id'] = 'drq';
								$this->displayRecentBoards_arr['row'][$inc]['member_profile_url'] = getMemberUrl($boardDetails['user_id'], $boardDetails['name']);
								$this->displayRecentBoards_arr['row'][$inc]['member_icon'] =  getMemberAvatarDetails($boardDetails['user_id']);
								$inc++;
							} //foreach
						if ($have_boards)
							{
								$this->displayRecentBoards_arr['boards_url']	=	getUrl('boards', '?view=recent', 'recent/', '', $this->CFG['admin']['index']['home_module']);
							}
					}
				return	$this->displayRecentBoards_arr;
			}

		/**
		 * DiscussionHandler::displayRecentlySolutionedBoards()
		 *
		 * @param mixed $limit
		 * @param mixed $close
		 * @return
		 */
		public function displayRecentlySolutionedBoards($limit = 5 , $close = NULL)
			{
				$this->displayRecentlySolutionedBoards_arr	=	array();
				$this->displayRecentlySolutionedBoards_arr['recently_solutioned']	=	$recently_solutioned = $this->getRecentlySolutionsBoards($limit);
				$this->displayRecentlySolutionedBoards_arr['have_recently_solutioned']	=		$have_recently_solutioned = false;
				if ($recently_solutioned)
					{
						$i = 0;
						$inc	=	0;
						$this->displayRecentlySolutionedBoards_arr['row']	=	array();
						foreach($recently_solutioned as $eachBoard)
							{
								$this->displayRecentlySolutionedBoards_arr['row'][$inc]['boardDetails']	=	$boardDetails = $this->getBoardDetails($eachBoard);
								if (!$boardDetails)
									continue;
								$this->displayRecentlySolutionedBoards_arr['have_recently_solutioned']	=	$have_recently_solutioned = true;
								$i++;
								$this->displayRecentlySolutionedBoards_arr['row'][$inc]['clsOddOrEvenBoard']	=	$clsOddOrEvenBoard = 'clsEvenBoard';
								if ($i%2)
									$this->displayRecentlySolutionedBoards_arr['row'][$inc]['clsOddOrEvenBoard']	=	$clsOddOrEvenBoard = 'clsOddBoard';
								$this->displayRecentlySolutionedBoards_arr['row'][$inc]['solution_plural']	=	$solution_plural = $this->LANG['discuzz_common_total_solution'];
								if($boardDetails['total_solutions']!= 1)
									$this->displayRecentlySolutionedBoards_arr['row'][$inc]['solution_plural']	=	$solution_plural = $this->LANG['solutions'];
								$this->displayRecentlySolutionedBoards_arr['row'][$inc]['boardDetails']['image_id']	=	$boardDetails['image_id'] = 'drq';
								$inc++;
							} //foreach
						if ($have_recently_solutioned)
							{
								$this->displayRecentlySolutionedBoards_arr['boards_url']	=	getUrl('boards', '?view=recentlysolutioned', 'recentlysolutioned/', '', $this->CFG['admin']['index']['home_module']);
							}
					}
				return	$this->displayRecentlySolutionedBoards_arr;
			}


		/**
		 * DiscussionHandler::getPopularBoards()
		 *
		 * @param integer $limit
		 * @return
		 */
		public function getPopularBoards($limit = 5)
			{
				$sql = 'SELECT q.board_id FROM '.$this->CFG['db']['tbl']['boards'].' AS q'.
						' WHERE q.status IN (\'Active\')  AND EXISTS(SELECT 1 FROM  '.$this->CFG['db']['tbl']['users'].' AS u WHERE u.'.$this->getUserTableField('user_id').' = q.user_id  AND u.'.$this->getUserTableField('user_status').' = \'OK\')'.
						' AND EXISTS(SELECT 1 FROM  '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c, '.$this->CFG['db']['tbl']['users'].' AS ud'.
						' WHERE d.pcat_id=c.cat_id AND c.status=\'Active\' AND d.user_id = ud.'.$this->getUserTableField('user_id').' AND ud.'.$this->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id = q.discussion_id  AND d.status = \'Active\')'.
						' AND total_views > 0 AND latest_viewed >= DATE_SUB(NOW(), INTERVAL '.$this->CFG['admin']['popular_days']['limit'].' DAY)'.
						' ORDER BY total_views DESC LIMIT 0,'.$limit;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
						trigger_db_error($this->dbObj);

				$popular_boards = array();
				while($row = $rs->FetchRow())
					{
						$popular_boards[] = $row['board_id'];
					}
				return $popular_boards;
			}

		/**
		 * DiscussionHandler::displayPopularBoards()
		 *
		 * @param mixed $limit
		 * @param mixed $close
		 * @return
		 */
		public function displayPopularBoards($limit = 5 ,  $close = NULL )
			{
				$this->displayPopularBoards_arr	=	array();
				$this->displayPopularBoards_arr['popular_boards']	=	$popular_boards = $this->getPopularBoards($limit);
				$this->displayPopularBoards_arr['found']	=		$found = false;
				if ($popular_boards)
					{
						$inc	=	0;
						$this->displayPopularBoards_arr['row']	=	array();
						$i = 0;
						foreach($popular_boards as $eachBoard)
							{
								$this->displayPopularBoards_arr['row'][$inc]['boardDetails']	=	$boardDetails = $this->getBoardDetails($eachBoard);
								if (!$boardDetails)
									continue;
								$i++;
								$this->displayPopularBoards_arr['found']	=		$found = true;
								$this->displayPopularBoards_arr['row'][$inc]['clsOddOrEvenBoard']	=	$clsOddOrEvenBoard = 'clsEvenBoard';
								if ($i%2)
									$this->displayPopularBoards_arr['row'][$inc]['clsOddOrEvenBoard']	=	$clsOddOrEvenBoard = 'clsOddBoard';
								$this->displayPopularBoards_arr['row'][$inc]['solution_plural']	=	$solution_plural = $this->LANG['discuzz_common_total_solution'];
								if($boardDetails['total_solutions']!= 1)
									$this->displayPopularBoards_arr['row'][$inc]['solution_plural']	=	$solution_plural = $this->LANG['solutions'];
								$this->displayPopularBoards_arr['row'][$inc]['boardDetails']['image_id']	=	$boardDetails['image_id'] = 'dpq';
								$inc++;
							}
						if ($found)
							{
								$this->displayPopularBoards_arr['boards_url']	=	getUrl('boards', '?view=popular', 'popular/', '', $this->CFG['admin']['index']['home_module']);
							}
					}
					return $this->displayPopularBoards_arr;
			}

		/**
		 * DiscussionHandler::getFeaturedBoards()
		 *
		 * @param integer $limit
		 * @return
		 */
		public function getFeaturedBoards($limit = 5)
			{
				$sql = 'SELECT q.board_id FROM '.$this->CFG['db']['tbl']['boards'].' AS q'.
						' WHERE q.status IN (\'Active\')'.
						' AND EXISTS(SELECT 1 FROM  '.$this->CFG['db']['tbl']['users'].' AS u WHERE u.'.$this->getUserTableField('user_id').' = q.user_id  AND u.'.$this->getUserTableField('user_status').' = \'Ok\')'.
						' AND EXISTS(SELECT 1 FROM  '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c, '.$this->CFG['db']['tbl']['users'].' AS ud'.
						' WHERE d.pcat_id=c.cat_id AND c.status=\'Active\' AND d.user_id = ud.'.$this->getUserTableField('user_id').' AND ud.'.$this->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id = q.discussion_id  AND d.status = \'Active\')'.
						' AND featured = \'Yes\' ORDER BY board_id DESC LIMIT 0,'.$limit;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
						trigger_db_error($this->dbObj);

				$featured_boards = array();
				while($row = $rs->FetchRow())
					{
						$featured_boards[] = $row['board_id'];
					}
				return $featured_boards;
			}

		/**
		 * To display audio boards
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function displayFeaturedBoards($limit = 3 , $close = NULL)
			{
				$this->displayFeaturedBoards_arr	=	array();
				$this->displayFeaturedBoards_arr['featured_boards']	=	$featured_boards = $this->getFeaturedBoards($limit);
				$this->displayFeaturedBoards_arr['have_boards']	=	$have_boards = false;
				if ($featured_boards)
					{
						$inc	=	0;
						$this->displayFeaturedBoards_arr['row']	=	array();
						$i = 0;
						foreach($featured_boards as $eachBoard)
							{
								$this->displayFeaturedBoards_arr['row'][$inc]['boardDetails']	=	$boardDetails = $this->getBoardDetails($eachBoard);
								if (!$boardDetails)
									continue;
								$this->displayFeaturedBoards_arr['have_boards']	=	$have_boards = true;
								$i++;
								$this->displayFeaturedBoards_arr['row'][$inc]['clsOddOrEvenBoard']	=	$clsOddOrEvenBoard = 'clsEvenBoard';
								if ($i%2)
									$this->displayFeaturedBoards_arr['row'][$inc]['clsOddOrEvenBoard']	=	$clsOddOrEvenBoard = 'clsOddBoard';
								$this->displayFeaturedBoards_arr['row'][$inc]['index_rating_lang']	=	$solution_plural = $this->LANG['index_ratings'];
								if($boardDetails['total_stars'] == 1)
									$this->displayFeaturedBoards_arr['row'][$inc]['index_rating_lang']	=	$solution_plural = $this->LANG['index_rating'];
								$this->displayFeaturedBoards_arr['row'][$inc]['boardDetails']['image_id']	=	$boardDetails['image_id'] = 'daq';
								$inc++;
							} //foreach
						if ($have_boards)
							{
								$this->displayFeaturedBoards_arr['boards_url']	=	getUrl('boards', '?view=featured', 'featured/', '', $this->CFG['admin']['index']['home_module']);
							}
					}
				return 	$this->displayFeaturedBoards_arr;
			}

		/**
		 * get user details user_id
		 *
		 * @param 		integer $user_id
		 * @return 		string
		 * @access 		public
		 */
		public function getUserDetails($user_id)
			{
				if (isset($this->_cache_user_details[$user_id]))
					{
						return $this->_cache_user_details[$user_id];
					}
				$row = getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $user_id);
				//cache user details
				$this->_cache_user_details[$user_id] = $row;
				return	$row;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getFeaturedContributorIds($limit)
			{
				$sql = 'SELECT ui.user_id FROM '.$this->CFG['db']['tbl']['users_info'].
						' as ui WHERE ui.featured = \'Yes\''.
						' AND EXISTS(SELECT 1 FROM '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE u.'.$this->getUserTableField('user_id').' =ui.user_id AND '.$this->getUserTableField('user_status').'=\'Ok\')'.
						' ORDER BY RAND() LIMIT 0, '.$limit;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$featured_contributors = array();
				while($row = $rs->FetchRow())
					{
						$featured_contributors[] = $row['user_id'];
					}
				return $featured_contributors;
			}

		/**
		 * To display featured contributor
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function displayFeaturedContributor($limit = 2, $close = NULL)
			{
				$this->displayFeaturedContributor_arr	=	array();
				$this->displayFeaturedContributor_arr['featured_contributors']	=	$featured_contributors = $this->getFeaturedContributorIds($limit);
				$this->displayFeaturedContributor_arr['have_users']	=	$have_users = false;
				if ($featured_contributors)
					{
						$i	=	0;
						$inc	=	0;
						$this->displayFeaturedContributor_arr['row']	=	array();
						foreach($featured_contributors as $eachMember)
						{
							$this->displayFeaturedContributor_arr['row'][$inc]['userDetails']	=	$userDetails = $this->getUserDetails($eachMember);
							if (!$userDetails)
								continue;
							$this->displayFeaturedContributor_arr['have_users']	=	$have_users = true;
							$i++;
							$this->displayFeaturedContributor_arr['row'][$inc]['clsOddOrEvenBoard']	=	$clsOddOrEvenBoard = 'clsEvenBoard';
							if ($i%2)
								$this->displayFeaturedContributor_arr['row'][$inc]['clsOddOrEvenBoard']	=	$clsOddOrEvenBoard = 'clsOddBoard';
							$this->displayFeaturedContributor_arr['row'][$inc]['uid']	=	$uid	=	$userDetails['user_id'];
							$this->displayFeaturedContributor_arr['row'][$inc]['userLog']	=	$userLog 	= $this->getUserLog($uid);
							$this->displayFeaturedContributor_arr['row'][$inc]['uname']	=	$uname 		= $userDetails['name'];
							$this->displayFeaturedContributor_arr['row'][$inc]['userLevelClass']	=	$userLevelClass = '';
							if($this->CFG['admin']['user_levels']['allowed'])
								$this->displayFeaturedContributor_arr['row'][$inc]['userLevelClass']	=	$userLevelClass = getUserLevelClass($userLog['total_points']);
							$this->displayFeaturedContributor_arr['row'][$inc]['mysolutions_url']	=	getMemberUrl($uid, $uname);
							$this->displayFeaturedContributor_arr['row'][$inc]['boards_ques_url']	=	getUrl('boards', '?view=search&amp;uname='.$uname.'&amp;opt=ques', 'search/?uname='.$uname.'&amp;opt=ques', '', $this->CFG['admin']['index']['home_module']);
							$this->displayFeaturedContributor_arr['row'][$inc]['boards_inactive_url']	=	getUrl('boards', '?view=search&amp;uname='.$uname.'&amp;opt=resolve', 'search/?uname='.$uname.'&amp;opt=resolve', '', $this->CFG['admin']['index']['home_module']);
							$this->displayFeaturedContributor_arr['row'][$inc]['boards_ans_url']	=	getUrl('boards', '?view=search&amp;uname='.$uname.'&amp;opt=ans', 'search/?uname='.$uname.'&amp;opt=ans', '', $this->CFG['admin']['index']['home_module']);
							$this->displayFeaturedContributor_arr['row'][$inc]['stripString_display_name']	=	stripString($userDetails['display_name'], 14);
							$inc++;
						} //foreach
					if ($have_users)
						{
							$this->displayFeaturedContributor_arr['topcontributors_url'] = getUrl('topcontributors', '?featured=1', '?featured=1', '', $this->CFG['admin']['index']['home_module']);
						}
					}
				return $this->displayFeaturedContributor_arr;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getTopContributorIds($limit)
			{
				$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users_board_log'].
						' as ul WHERE total_points > 0'.
						' AND EXISTS(SELECT 1 FROM '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE u.'.$this->getUserTableField('user_id').'=ul.user_id AND '.$this->getUserTableField('user_status').'=\'Ok\')'.
						' ORDER BY total_points DESC LIMIT 0, '.$limit;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$top_contributors = array();
				while($row = $rs->FetchRow())
					{
						$top_contributors[] = $row['user_id'];
					}
				return $top_contributors;
			}

		/**
		 * To display top contributors
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function displayTopContributor($limit=3, $close = NULL)
			{
				$this->displayTopContributor_arr	=	array();
				$this->displayTopContributor_arr['top_contributors']	=	$top_contributors = $this->getTopContributorIds($limit);
				$this->displayTopContributor_arr['have_contributors']	=	$have_contributors = false;
				if ($top_contributors)
					{
						$i	=	0;
						$inc	=	0;
						$this->displayTopContributor_arr['row']	=	array();
						foreach($top_contributors as $eachMember)
							{
								$this->displayTopContributor_arr['row'][$inc]['userDetails']	=	$userDetails = $this->getUserDetails($eachMember);
								if (!$userDetails)
									continue;
								$this->displayTopContributor_arr['have_contributors']	=	$have_contributors = true;
								$this->displayTopContributor_arr['row'][$inc]['uid']	=	$uid 		= $userDetails['user_id'];
								$this->displayTopContributor_arr['row'][$inc]['userLog']	=	$userLog 	= $this->getUserLog($uid);
							    $this->displayTopContributor_arr['row'][$inc]['uname']	=	$uname 		= $userDetails['name'];
								$this->displayTopContributor_arr['row'][$inc]['userLevelClass']	=	$userLevelClass = '';

								if($userLog['total_points']<= 100)
									$this->displayTopContributor_arr['row'][$inc]['point_class'] = 'clsUserPoint100';
								elseif($userLog['total_points']<= 500)
									$this->displayTopContributor_arr['row'][$inc]['point_class'] = 'clsUserPoint500';
								else
									$this->displayTopContributor_arr['row'][$inc]['point_class'] = 'clsUserPoint1000';

								if($this->CFG['admin']['user_levels']['allowed'])
									$this->displayTopContributor_arr['row'][$inc]['userLevelClass']	=	$userLevelClass = getUserLevelClass($userLog['total_points']);
								$i++;
								$this->displayTopContributor_arr['row'][$inc]['clsOddOrEvenBoard']	=	$clsOddOrEvenBoard = 'clsEvenBoard';
								if ($i%2)
									$this->displayTopContributor_arr['row'][$inc]['clsOddOrEvenBoard']	=	$clsOddOrEvenBoard = 'clsOddBoard';
								$this->displayTopContributor_arr['row'][$inc]['userDetails']['image_id']	=	$userDetails['image_id'] = 'dta';
								$this->displayTopContributor_arr['row'][$inc]['mysolutions_url']	=	getMemberUrl($uid, $uname);
								$this->displayTopContributor_arr['row'][$inc]['stripString_display_name']	=	stripString($userDetails['display_name'], 16);
								$inc++;
							} //foreach
						if ($have_contributors)
							{
								$this->displayTopContributor_arr['topcontributors_url']	=	getUrl('topcontributors', '', '', '', $this->CFG['admin']['index']['home_module']);
							}
					}
				return $this->displayTopContributor_arr;
			}

		public function chkRightBarSettings()
			{
				if(!$this->CFG['admin']['rightbar']['details'])
				   		return true;
				else
					return false;

			}
		/**
		 * DiscussionHandler::chkIsSolutionPage()
		 *
		 * @return
		 */
		public function chkIsSolutionPage()
			{
				$allowed_pages_array = array('solutions.php');
				if(displayBlock($allowed_pages_array, false, $append_default_pages=false))
					return true;
				return false;
			}
		/**
		 * DiscussionHandler::chkIsIndexPage()
		 *
		 * @return
		 */
		public function chkIsIndexPage()
			{
				$allowed_pages_array = array('index.php');
				if(displayBlock($allowed_pages_array, false, $append_default_pages=false))
					return true;
				return false;
			}
		/**
		 * DiscussionHandler::chkIsBoardPage()
		 *
		 * @return
		 */
		public function chkIsBoardPage()
			{
				$allowed_pages_array = array('boards.php');
				if(displayBlock($allowed_pages_array, false, $append_default_pages=false))
					return true;
				return false;
			}

		public function rightBarSettings($pagingarr='')
		  	{
		  		$discussionHeaderHandler = new HeaderHandler;
		  		$this->_currentPage = $discussionHeaderHandler->_currentPage;

				$sql = 'SELECT * from '.$this->CFG['db']['tbl']['rightbar_settings'].' ORDER BY order_value ASC, sno ASC';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow()) {
							 if($row['title'] == 'user_status')
							 	{
									if(isMember())
										{
											if($this->CFG['admin']['rightbar']['details'])
												$this->showUserInfo();
										}
								}
							 elseif($row['title'] == 'top_contributors' AND $this->_currentPage != 'mysolutions' AND !in_array($this->_currentPage, $this->CFG['admin']['short_sidebar_pages']))
							 	{
									if($this->CFG['admin']['rightbar']['top_contributors'])
			 							$this->showTopContributors();
								}
							 elseif($row['title'] == 'featured_contributors' AND $this->_currentPage != 'mysolutions' AND !in_array($this->_currentPage, $this->CFG['admin']['short_sidebar_pages_1']))
							 	{
									if($this->CFG['admin']['rightbar']['featured_contributors'])
			 							$this->showFeaturedContributors();
								}
							 elseif($row['title'] == 'featured_board' AND $this->_currentPage != 'mysolutions')
							 	{
									if($this->CFG['admin']['rightbar']['featured_board'])
			 							$this->showFeaturedBoard();
								}
						}

						if($this->_currentPage == 'mysolutions' AND isMember())
			 					$this->showUserStatistics();
					}

			}
		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function showUserInfo()
			{
				global $smartyObj;
				$showUserInfo_arr = array();
		  		$discussionHeaderHandler = new HeaderHandler;
		  		$this->_currentPage = $discussionHeaderHandler->_currentPage;

				$showUserInfo_arr['userLog'] = $this->getUserLog($this->CFG['user']['user_id']);
				$showUserInfo_arr['userDetails'] = $userDetails = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $this->CFG['user']['user_id']);
				$showUserInfo_arr['mysolutions']['url'] = getMemberUrl($this->CFG['user']['user_id'], $this->CFG['user']['name']);

				if(isset($this->CFG['user']['user_name']) && $this->CFG['user']['user_name'])
					$display_name = $this->CFG['user']['user_name'];
				else
					$display_name = $this->CFG['user']['name'];

				$showUserInfo_arr['display_name_manual'] = stripString(ucwords($display_name), 25);
				$showUserInfo_arr['inbox'] = $this->countUnReadMail();
				$showUserInfo_arr['favorites'] = $this->getFavoriteBoardsCount($this->CFG['user']['user_id']);
				//$showUserInfo_arr['isOnline'] = $this->isImInOnline($this->CFG['user']['user_id']);
				$showUserInfo_arr['isOnline'] = true;
				$showUserInfo_arr['lastLogged'] = '';
				$showUserInfo_arr['isProfile'] = false;
				if($this->_currentPage == 'mysolutions' AND isset($this->fields_arr['uid']) AND $this->fields_arr['uid'] == $this->CFG['user']['name'])
					{
						$showUserInfo_arr['isProfile'] = true;
						$showUserInfo_arr['lastLogged'] = date('d-M-Y, h:i A',strtotime($this->CFG['user']['last_logged']));
					}

				$showUserInfo_arr['favorites_link'] = getUrl('boards', '?view=search&amp;opt=fav&amp;uname='.$userDetails['name'], 'search/?opt=fav&amp;uname='.$userDetails['name'], '', $this->CFG['admin']['index']['home_module']);
				$showUserInfo_arr['inbox_link'] = getUrl('mail', '?folder=inbox' , 'inbox/' , 'members');
				$showUserInfo_arr['total_postlink'] = getUrl('boards', '?view=search&amp;opt=board&amp;uname='.$userDetails['name'], 'search/?opt=board&amp;uname='.$userDetails['name'], '', $this->CFG['admin']['index']['home_module']);

				$showUserInfo_arr['public_profile'] = getMemberUrl($showUserInfo_arr['userDetails']['user_id'], $showUserInfo_arr['userDetails']['name']);
				$showUserInfo_arr['edit_info'] = getSettingsUrl();
				$smartyObj->assign('showUserInfo_arr', $showUserInfo_arr);
				$smartyObj->assign_by_ref('discussion', $this);
				setTemplateFolder('members/', $this->CFG['admin']['index']['home_module']);
				$smartyObj->display('showUserInfo.tpl');
			}
		/**
		 * function showShortcutDetails()
		 * @return 		void
		 * @access 		public
		 */
		public function showShortcutDetails()
			{
				global $smartyObj;
				$showUserInfo_arr = array();
		  		$discussionHeaderHandler = new HeaderHandler;
		  		$this->_currentPage = $discussionHeaderHandler->_currentPage;

				$showUserInfo_arr['userLog'] = $this->getUserLog($this->CFG['user']['user_id']);
				$showUserInfo_arr['userDetails'] = $userDetails = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $this->CFG['user']['user_id']);
				$showUserInfo_arr['mysolutions']['url'] = getMemberUrl($this->CFG['user']['user_id'], $this->CFG['user']['name']);

				if(isset($this->CFG['user']['user_name']) && $this->CFG['user']['user_name'])
					$display_name = $this->CFG['user']['user_name'];
				else
					$display_name = $this->CFG['user']['name'];

				$showUserInfo_arr['display_name_manual'] = stripString(ucwords($display_name), 25);
				$showUserInfo_arr['inbox'] = $this->countUnReadMail();
				$showUserInfo_arr['favorites'] = $this->getFavoriteBoardsCount($this->CFG['user']['user_id']);
				//$showUserInfo_arr['isOnline'] = $this->isImInOnline($this->CFG['user']['user_id']);
				$showUserInfo_arr['isOnline'] = true;
				$showUserInfo_arr['lastLogged'] = '';
				$showUserInfo_arr['isProfile'] = false;
				if($this->_currentPage == 'mysolutions' AND isset($this->fields_arr['uid']) AND $this->fields_arr['uid'] == $this->CFG['user']['name'])
					{
						$showUserInfo_arr['isProfile'] = true;
						$showUserInfo_arr['lastLogged'] = date('d-M-Y, h:i A',strtotime($this->CFG['user']['last_logged']));
					}

				$showUserInfo_arr['favorites_link'] = getUrl('boards', '?view=search&amp;opt=fav&amp;uname='.$userDetails['name'], 'search/?opt=fav&amp;uname='.$userDetails['name'], '', $this->CFG['admin']['index']['home_module']);
				$showUserInfo_arr['inbox_link'] = getUrl('mail', '?folder=inbox' , 'inbox/' , 'members');
				$showUserInfo_arr['total_postlink'] = getUrl('boards', '?view=search&amp;opt=board&amp;uname='.$userDetails['name'], 'search/?opt=board&amp;uname='.$userDetails['name'], '', $this->CFG['admin']['index']['home_module']);
				if (isset($showUserInfo_arr['userDetails']['user_id'])) {
					$showUserInfo_arr['public_profile'] = getMemberUrl($showUserInfo_arr['userDetails']['user_id'], $showUserInfo_arr['userDetails']['name']);
				}
				$showUserInfo_arr['edit_info'] = getSettingsUrl();
				$smartyObj->assign('showUserInfo_arr', $showUserInfo_arr);
				$smartyObj->assign_by_ref('discussion', $this);
			}

		public function showTopContributors()
			{
				global $smartyObj;
				$form_top_contributor = array();
				$form_top_contributor['displayTopContributor'] = $this->displayTopContributor($this->CFG['admin']['index']['top_contributor_count']);

				$smartyObj->assign('form_top_contributor', $form_top_contributor);
				$smartyObj->assign_by_ref('discussion', $this);
				setTemplateFolder('general/', $this->CFG['admin']['index']['home_module']);
				$smartyObj->display('showTopContributors.tpl');
			}

		public function showFeaturedContributors()
			{
				global $smartyObj;
				$form_featured_contributor = array();
				$form_featured_contributor['displayFeaturedContributor']	=	$this->displayFeaturedContributor($this->CFG['admin']['index']['featured_contributor_count']);

				$smartyObj->assign('form_featured_contributor', $form_featured_contributor);
				$smartyObj->assign_by_ref('discussion', $this);
				setTemplateFolder('general/', $this->CFG['admin']['index']['home_module']);
				$smartyObj->display('featuredContributors.tpl');
			}

		public function showFeaturedBoard()
			{
				global $smartyObj;
				$form_featured_boards = array();
				$form_featured_boards['displayFeaturedboards']	=	$this->displayFeaturedBoards();
				$smartyObj->assign('form_featured_boards', $form_featured_boards);
				setTemplateFolder('general/', $this->CFG['admin']['index']['home_module']);
				$smartyObj->display('featuredBoards.tpl');
			}
		/**
		 * HeaderHandler::getFavoriteBoardsCount()
		 *
		 * @return
		 */
		public function getFavoriteBoardsCount()
			{
				$sql = 'SELECT ub.bookmark_id FROM '.$this->CFG['db']['tbl']['user_bookmarked'].' As ub, '.$this->CFG['db']['tbl']['boards'].' As b'.
						' WHERE ub.content_id = b.board_id AND ub.content_type = \'Board\''.
						' AND b.status = \'Active\''.
						' AND ub.user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$count = 0;
				if ($count=$rs->PO_RecordCount())
					return $count;
				return $count;

			}
		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function showThisWeekExperts($limit=5, $close = NULL)
			{
				$this->showThisWeekExperts_arr	=	array();
				$this->showThisWeekExperts_arr['contributors_this_week_note']	=	$this->LANG['contributors_this_week_note'] = str_ireplace('VAR_REFRESH_TIME',$this->CFG['admin']['week_experts']['refresh'],$this->LANG['contributors_this_week_note']);
				$this->showThisWeekExperts_arr['top_contributors']	=	$top_contributors = $this->thisWeekExperts($limit);
				$this->showThisWeekExperts_arr['have_contributors']	=	$have_contributors = false;
				if ($top_contributors)
					{
						$i=0;
						$inc	=	0;
						$this->showThisWeekExperts_arr['row']	=	array();
						foreach($top_contributors as $eachMember)
							{
								$this->showThisWeekExperts_arr['row'][$inc]['userDetails']	=	$userDetails = $this->getUserDetails($eachMember);
								if (!$userDetails)
									continue;
								$this->showThisWeekExperts_arr['have_contributors']	=	$have_contributors = true;

								$this->showThisWeekExperts_arr['row'][$inc]['uid']	=	$uid	=	$userDetails['user_id'];
								$this->showThisWeekExperts_arr['row'][$inc]['userLog']	=	$userLog 	= $this->getUserLog($uid);
								$this->showThisWeekExperts_arr['row'][$inc]['uname']	=	$uname 		= $userDetails['name'];
								$this->showThisWeekExperts_arr['row'][$inc]['userLevelClass']	=	$userLevelClass = '';
								if($this->CFG['admin']['user_levels']['allowed'])
									$this->showThisWeekExperts_arr['row'][$inc]['userLevelClass']	=	$userLevelClass = getUserLevelClass($userLog['total_points']);
								$i++;
								$this->showThisWeekExperts_arr['row'][$inc]['clsOddOrEvenBoard']	=	$clsOddOrEvenBoard = 'clsEvenBoard';
								if ($i%2)
									$this->showThisWeekExperts_arr['row'][$inc]['clsOddOrEvenBoard']	=	$clsOddOrEvenBoard = 'clsOddBoard';
								$this->showThisWeekExperts_arr['row'][$inc]['userDetails']['image_id']	=	$userDetails['image_id'] = 'stwe';
								$this->showThisWeekExperts_arr['row'][$inc]['mysolutions_url']	=	getMemberUrl($uid, $uname);
								$this->showThisWeekExperts_arr['row'][$inc]['stripString_display_name']	=			stripString($userDetails['display_name'], $this->CFG['username']['short_length']);
								$inc++;
							} //foreach
						if ($have_contributors)
							{
								$this->showThisWeekExperts_arr['topcontributors_url']	=	 getUrl('topcontributors', '?week=1', '?week=1', '', $this->CFG['admin']['index']['home_module']);
							}
					}
				return 	$this->showThisWeekExperts_arr;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function thisWeekExperts($limit=5)
			{
				$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['view_weekly_experts'].
						' as we WHERE week_points>0'.
						' AND EXISTS(SELECT 1 FROM '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE u.'.$this->getUserTableField('user_id').'=we.user_id AND '.$this->getUserTableField('user_status').'=\'Ok\')'.
						' ORDER BY week_points DESC LIMIT 0, '.$limit;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						$user = array();
						$i = 0;
						while($row = $rs->FetchRow()){
							$user[$i] = $row['user_id'];
							$i++;
						}
						return $user;
					}
				return false;
			}

		/**
		 * DiscussionHandler::getLastPostDetails()
		 *
		 * @param string $board_id
		 * @return
		 */
		public function getLastPostDetails($board_id='0')
			{
				$sql = 'SELECT solution_id FROM '.$this->CFG['db']['tbl']['solutions'].
						' WHERE board_id = '.$this->dbObj->Param($board_id).
						' ORDER BY solution_added DESC LIMIT 0, 1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($board_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$solution_arr = array('last_name'=>'', 'date_post'=>'' , 'solutioned_by_link'=>'', 'date_added'=>'');
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$solution_arr = $this->getSolutionDetails($row['solution_id']);
					}
				return $solution_arr;
			}

		//' from formHandler move

		/**
		 * DiscussionHandler::getSeoTitleForDiscussion()
		 *
		 * @param string $discussion_title
		 * @param integer $discussion_id
		 * @return
		 */
		public function getSeoTitleForDiscussion($discussion_title = '', $discussion_id = 0)
			{
				return $this->getSeoTitle($this->CFG['db']['tbl']['discussions'], 'discussion_title' ,$discussion_title , 'discussion_id', $discussion_id);
			}
		/**
		 * DiscussionHandler::getSeoTitleForBoard()
		 *
		 * @param string $board
		 * @param integer $board_id
		 * @return
		 */
		public function getSeoTitleForBoard($board = '', $board_id = 0)
			{
				return $this->getSeoTitle($this->CFG['db']['tbl']['boards'], 'board' ,$board , 'board_id', $board_id);
			}
		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function isAllowedToAsk($owner_id)
		    {
				$uid = $this->CFG['user']['user_id'];
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['block_members'].
						' WHERE block_id ='.$this->dbObj->Param($uid).
						' AND user_id='.$this->dbObj->Param($owner_id);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($uid, $owner_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					return false;
				return true;
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function isFavoriteContent($cid, $ctype)
		    {
				$sql = 'SELECT bookmark_id FROM '.$this->CFG['db']['tbl']['user_bookmarked'].
						' WHERE content_id = '.$this->dbObj->Param('content_id') .' AND'.
						' content_type = '.$this->dbObj->Param('content_type').' AND'.
						' user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cid, $ctype, $this->CFG['user']['user_id']));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$ok = false;
				if ($rs->PO_RecordCount())
					$ok = true;
				return $ok;
		    }
		/**
		 * DiscussionHandler::getContentDetails()
		 *
		 * @param mixed $row
		 * @return
		 */
		public function getContentDetails($row)
			{
				$contentDetails = array();

				switch($row['type_for']){
					case 'Board':
						$contentDetails = $this->getBoardDetails($row['content_id']);
						if ($contentDetails)
							$contentDetails['link'] = $contentDetails['qLink'];
						break;
					case 'Solution':
						$contentDetails = $this->getSolutionDetails($row['content_id']);
						if ($contentDetails)
							$contentDetails['link'] = $contentDetails['aLink'];
						break;

				} // switch

				return $contentDetails;
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function updateBoardViews()
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].
						' SET total_views=total_views+1, latest_viewed=NOW()'.
						' WHERE board_id='.$this->dbObj->Param('qid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
		    }



		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function increaseBestSolutionPoints($uid)
			{
				if ($uid and $this->CFG['admin']['best_solutions']['allowed'])
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
								' SET total_points = total_points + '.$this->CFG['admin']['best_solutions']['points'].
								' , total_best_solution = total_best_solution + 1'.
								' WHERE user_id='.$this->dbObj->Param($uid);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($uid));
						if (!$rs)
							    trigger_db_error($this->dbObj);
					}
			}


		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function populateCategories($access = '')
		    {
				$populateCategories_arr = array();
				$sql = 'SELECT cat_id, cat_name FROM '.$this->CFG['db']['tbl']['category'].' WHERE parent_id=0 AND status=\'Active\'';
				if($access == '')
					$sql.=' AND restricted=\'No\'';
				$sql.=' ORDER BY cat_name';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$populateCategories_arr[$row['cat_id']] = wordWrapManual($row['cat_name'],$this->CFG['admin']['category']['line_length'], $this->CFG['admin']['category']['short_length']);
							} // while
					}
				return $populateCategories_arr;
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function populateSubCategories($cid)
		    {
				if (!$cid)
					return ;
				$populateSubCategories_arr = array();
				$sql = 'SELECT cat_id, cat_name FROM '.
						$this->CFG['db']['tbl']['category'].
						' WHERE parent_id='.$this->dbObj->Param('cid').
						' AND parent_id!=0'.
						' AND status=\'Active\' ORDER BY cat_name';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cid));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$populateSubCategories_arr[$row['cat_id']] = $row['cat_name'];
							} // while
					}
				return $populateSubCategories_arr;

		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function showBoardList()
			{
				global $smartyObj;
				$showBoardList_arr = array();
				$i = 0;

			   $this->ques_type = ucfirst($this->getFormField('board'));
			   if($this->getFormField('type') != 'ask_only')
				   {
				   		$showBoardList_arr['row'] = array();
				   		$inc = 1;
						while($row = $this->fetchResultRecord()) {
							$i++;
							$showBoardList_arr['row'][$inc]['clsOddOrEvenBoard'] = 'clsEvenBoard';
							if ($i%2)
								$showBoardList_arr['row'][$inc]['clsOddOrEvenBoard'] = 'clsOddBoard';

							$ques = strip_tags($row['board']);

							$showBoardList_arr['row'][$inc]['solution']['url'] = getUrl('solutions', '?title='.$row['seo_title'], $row['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']);
							$showBoardList_arr['row'][$inc]['board_manual'] = wordWrapManual($ques, $this->CFG['admin']['board']['line_length'], $this->CFG['admin']['board']['short_length']);
							$inc++;
						}
	                 }
				$showBoardList_arr['form_action'] = getUrl('widgetgenerate', '', '', 'members', $this->CFG['admin']['index']['home_module']);
				$smartyObj->assign('showBoardList_arr', $showBoardList_arr);
				setTemplateFolder('general/');
				$smartyObj->display('showBoardList.tpl');
			}



		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getSeoTitleFordiscussionCategory($cat_name = '', $cat_id = 0)
			{
				return $this->getSeoTitle($this->CFG['db']['tbl']['category'], 'cat_name' ,$cat_name , 'cat_id', $cat_id);
			}


		/**
		 *
		 * @return 		void
		 * @access 		public
		 * @module		common function for html_header.php and index.php
		 */
		public function getPopularAudiosToDisplay($totalViews)
			{
				$returnPopularAudios = array();
				$remainingpopularAudio = array();
				foreach($this->popularAudio as $key=>$eachAudio){
					if ($eachAudio['total_views'] > $totalViews)
						{
							$returnPopularAudios[] = $eachAudio;
						}
					else
						{
							$remainingpopularAudio[] = $eachAudio;
						}
				}
				$this->popularAudio = $remainingpopularAudio;
				return $returnPopularAudios;
			}

		/**
		 * DiscussionHandler::displayDiscussionUserSmallImage()
		 *
		 * @param mixed $img_arr
		 * @param mixed $showPopup
		 * @param mixed $contentDisplay
		 * @param mixed $changePosition
		 * @return
		 */
		public function displayDiscussionUserSmallImage($img_arr, $showPopup = true, $contentDisplay = false, $changePosition = false)
			{
				displayProfileImage($img_arr, 'small', $showPopup, $contentDisplay, $changePosition);
				return ;
			}

		/**
		 * DiscussionHandler::writeLogTable()
		 *
		 * @param mixed $user_id
		 * @param mixed $ip
		 * @param mixed $board_id
		 * @return
		 */
		public function writeLogTable($user_id, $ip, $board_id)
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['view_log'].' '.
						' SET log_userid = '.$this->dbObj->Param('userid').
						' ,log_ip = '.$this->dbObj->Param('ip').
						' ,board_id = '.$this->dbObj->Param('bid').
						' ,date_viewed = NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $ip, $board_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 * DiscussionHandler::chkIsNewPostOnthisBoard()
		 *
		 * @param mixed $user_id
		 * @param mixed $ip
		 * @param mixed $board_id
		 * @param mixed $sol_date
		 * @return
		 */
		public function chkIsNewPostOnthisBoard($user_id, $ip, $board_id, $sol_date)
			{
				if($sol_date == '0000-00-00 00:00:00')
					return false;

				$fields_array = array();
				if(isMember())
					{
						$field_name = 'log_userid';
						$fields_array[] = $user_id;
					}
				else
					{
						$field_name = 'log_ip';
						$fields_array[] = $ip;
					}

				$fields_array[] = $board_id;
				$fields_array[] = $sol_date;

				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['view_log'].
						' WHERE '.$field_name.'='.$this->dbObj->Param('uid').
						' AND board_id='.$this->dbObj->Param('bid').
						' AND date_viewed > '.$this->dbObj->Param('date');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $fields_array);
				if (!$rs)
					    trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						return false;
					}

				return true;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function updateBoaardAndSolutions($discussion_ids, $status)
			{
				if (!in_array($status, array('Active', 'Inactive')))
					return ;

				if($status == 'Inactive')
					 {
					 	$qry_status = 'Active';
						$addsub = '-';
					 }
				else
					 {
						$qry_status = 'Inactive';
						$addsub = '+';
					 }

				//Get board ids of each discussions
				$sql = 'SELECT discussion_id, pcat_id FROM '.$this->CFG['db']['tbl']['discussions'].
						' WHERE discussion_id IN ('.$discussion_ids.') AND status = '.$this->dbObj->Param($qry_status);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($qry_status));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$discussion_ids_new = array();
				if ($rs->PO_RecordCount())
					{
						while ($row = $rs->FetchRow()){
							$discussion_ids_new[] = $row['discussion_id'];
							$pcat_id = $row['pcat_id'];
						}
					}

				if ($discussion_ids_new)
					{

						$discussion_ids = implode(',', $discussion_ids_new);

						$sql = 'SELECT user_id, board_id, best_solution_id, total_solutions FROM '.$this->CFG['db']['tbl']['boards'].
								' WHERE discussion_id IN ('.$discussion_ids.') AND status = \'Active\'';
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
												' WHERE cat_id='.$this->dbObj->Param($pcat_id);

									$cat_stmt = $this->dbObj->Prepare($cat_sql);
									$cat_rs = $this->dbObj->Execute($cat_stmt, array($total_sols, $pcat_id));
									if (!$cat_rs)
									    trigger_db_error($this->dbObj);
									$this->updateParentCategories($pcat_id, $addsub, $total_sols);

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
		 * @return 		void
		 * @access 		public
		 */
		public function updateBoardCountForActiveInactive($board_ids, $status)
			{
				if (!in_array($status, array('Active', 'Inactive')))
					return ;

				if($status == 'Inactive')
					 {
					 	$qry_status = 'Active';
						$addsub = '-';
					 }
				else
					 {
						$qry_status = 'Inactive';
						$addsub = '+';
					 }

				$sql = 'SELECT user_id, board_id, discussion_id, total_solutions, best_solution_id FROM '.$this->CFG['db']['tbl']['boards'].
						' WHERE board_id IN ('.$board_ids.') AND status = '.$this->dbObj->Param($qry_status);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($qry_status));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						while ($row = $rs->FetchRow()){
							//Update discussion table
							$sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].
									' SET total_boards=total_boards'.$addsub.'1'.
									', total_solutions=total_solutions'.$addsub.$this->dbObj->Param($row['total_solutions']).
									' WHERE discussion_id='.$this->dbObj->Param($row['discussion_id']);
							$stmt = $this->dbObj->Prepare($sql);
							$rs_discuss = $this->dbObj->Execute($stmt, array($row['total_solutions'], $row['discussion_id']));
							if (!$rs_discuss)
								    trigger_db_error($this->dbObj);

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
							if ($rs_sol->PO_RecordCount())
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
		/**
		 * DiscussionsFormHandler::getDiscussionsOfActiveCategory()
		 *
		 * @return
		 */

		public function checkDiscussionCategoryActive($discussion_id)
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['discussions'].' As d, '.$this->CFG['db']['tbl']['category'].' As c'.
						' WHERE d.pcat_id=c.cat_id AND d.discussion_id ='.$this->dbObj->Param('discussion_id').
						' AND c.status=\'Active\'';
								$stmt = $this->dbObj->Prepare($sql);

				$rs = $this->dbObj->Execute($stmt, array($discussion_id));
				if (!$rs)
			    	trigger_db_error($this->dbObj);

				return $rs->PO_RecordCount();
			}
		/**
		* DiscussionsFormHandler::updateParentCategories()
		*
		*/
		public function updateParentCategories($cat_id, $addsub, $sols=0, $check_status = false)
			{
				$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE cat_id='.$this->dbObj->Param($cat_id);
				if($check_status == false) $sql.=' AND status=\'Active\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
			    	trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						if($row['parent_id'])
							{
								$input_params = array();
								$upd_sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].' SET total_boards=total_boards'.$addsub.'1';
								if($addsub == '+'){
									$upd_sql .=' ,last_post_user_id='.$this->dbObj->Param('user_id').
												' ,last_post_date=NOW()';
									$input_params[] = $this->CFG['user']['user_id'];
								}
								if($sols > 0){
									$upd_sql.=', total_solutions=total_solutions'.$addsub.$sols;
								}
								$upd_sql.=' WHERE cat_id='.$this->dbObj->Param($row['parent_id']);
								$input_params[] = $row['parent_id'];
								if($addsub == '-') $upd_sql.=' AND total_boards>0';

								$upd_stmt = $this->dbObj->Prepare($upd_sql);
								$upd_rs = $this->dbObj->Execute($upd_stmt, $input_params);
								if (!$upd_rs)
							    	trigger_db_error($this->dbObj);
								$this->updateParentCategories($row['parent_id'], $addsub, $sols, $check_status);
							}
					}
			}
		/**
		* DiscussionsFormHandler::updateSolutionsOfParentCategories()
		*
		*/
		public function updateSolutionsOfParentCategories($cat_id, $addsub)
			{
				$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE cat_id='.$this->dbObj->Param($cat_id).
						' AND status=\'Active\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
			    	trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						if($row['parent_id'])
							{
								$input_params = array();
								$upd_sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].' SET total_solutions=total_solutions'.$addsub.'1';
								if($addsub == '+'){
									$upd_sql .=' ,last_post_user_id='.$this->dbObj->Param('user_id').
												' ,last_post_date=NOW()';
									$input_params[] = $this->CFG['user']['user_id'];
								}

								$upd_sql .=	' WHERE cat_id='.$this->dbObj->Param($row['parent_id']);
								$input_params[] = $row['parent_id'];
								if($addsub == '-') $upd_sql.=' AND total_solutions>0';

								$upd_stmt = $this->dbObj->Prepare($upd_sql);
								$upd_rs = $this->dbObj->Execute($upd_stmt, $input_params);
								if (!$upd_rs)
							    	trigger_db_error($this->dbObj);
						    	$this->updateSolutionsOfParentCategories($row['parent_id'], $addsub);
							}
					}
			}

	/**
	 *
	 * @return 		void
	 * @access 		public
	 */
	public function insertUsersSolutionLog()
		{
			if (isset($_SESSION['is_user_log_available']))
				return ;

			$uid = $this->CFG['user']['user_id'];
			$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users_board_log'].
					' WHERE user_id='.$this->dbObj->Param($uid);
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($uid));
			if (!$rs)
				    trigger_db_error($this->dbObj);
			if (!$rs->PO_RecordCount())
				{
					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['users_board_log'].
							' SET user_id='.$this->dbObj->Param($uid);
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($uid));
					if (!$rs)
						    trigger_db_error($this->dbObj);
				}

			//To know points for viewing updated
			$_SESSION['is_user_log_available'] = true;
		}
	/**
	 *
	 * @access public
	 * @return void
	 **/
	public function updateUsersSolutionLog()
	    {
			if (!isset($this->CFG['user']['user_id']) or empty($this->CFG['user']['user_id']) or (!$this->CFG['admin']['view_solutions']['allowed']) or (isset($_SESSION['view_solutions_points'])))
				return false;

			$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
					' SET total_points=total_points+'.$this->CFG['admin']['view_solutions']['points'].','.
					' date_updated=NOW(), date_viewed=NOW()'.
					' WHERE user_id='.$this->dbObj->Param('uid').
					' AND DATEDIFF(DATE_FORMAT(date_viewed, \'%Y-%m-%d\'), DATE_FORMAT(NOW(), \'%Y-%m-%d\')) != 0';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			if (!$rs)
			        trigger_db_error($this->dbObj);
			//To know points for viewing updated
			$_SESSION['view_solutions_points'] = true;

			if ($this->dbObj->Affected_Rows())
				{
					return true;
				}
			return false;
	    }

	/**
	 *
	 * @return 		void
	 * @access 		public
	 */
	public function getUserOptions()
		{
			$user_options = array('recent_boards'=>'yes', 'popular_boards'=>'yes','recently_solutioned'=>'yes', 'best_of_solution'=>'yes',
								  'solutioned_boards'=>'yes', 'unsolutioned_boards'=>'yes',
								  'top_contributor'=>'yes', 'featured_contributor'=>'yes', 'contributor_weekwise'=>'yes', 'top_discussions'=>'yes');
			if ($uid = $this->CFG['user']['user_id'])
				{
					$sql = 'SELECT index_block FROM '.$this->CFG['db']['tbl']['users_board_log'].
							' WHERE user_id='.$this->dbObj->Param($uid);
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($uid));
					if (!$rs)
						    trigger_db_error($this->dbObj);
					if ($rs->PO_RecordCount())
						{
							$row = $rs->FetchRow();
							if ($row['index_block'])
								{
									$index_blocks = unserialize($row['index_block']);
									foreach($index_blocks as $block=>$value){
										$user_options[$block] = $value;
									}
								}
						}
				}
			return $user_options;
		}
	/**
	 * Function to create week top contributors
	 *
	 * @return 		void
	 * @access 		public
	 */
	public function createWeekExperts()
		{
			$sql = 'SELECT TIMEDIFF(NOW(), date_added) time_diff FROM '.$this->CFG['db']['tbl']['view_weekly_experts'].
					' LIMIT 0, 1';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				    trigger_db_error($this->dbObj);
			if ($rs->PO_RecordCount())
				{
					$row = $rs->FetchRow();
					$time_diff = explode(':', $row['time_diff']);
					$mins_after_created = ($time_diff[0]*60)+($time_diff[1]);
					$mins_after_created = ($time_diff[2])?($mins_after_created+1):$mins_after_created;
					if ($mins_after_created < $this->CFG['admin']['week_experts']['refresh'])
						{
							return ;
						}
				}

			$sql = 'CREATE OR REPLACE VIEW view_boards_expert AS'.
					' SELECT COUNT( board_id ) AS \'total_count\', user_id,'.
					' (COUNT( board_id ) * '.$this->CFG['admin']['ask_solutions']['points'].') AS \'points\''.
					' FROM '.$this->CFG['db']['tbl']['boards'].
					' WHERE DATE_ADD(board_added, INTERVAL 7 DAY) >= NOW()'.
					' GROUP BY user_id';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);

			$sql = 'CREATE OR REPLACE VIEW view_solutions_expert AS'.
					' SELECT COUNT( solution_id ) AS \'total_count\', user_id,'.
					' (COUNT( solution_id ) * '.$this->CFG['admin']['reply_solutions']['points'].') AS \'points\''.
					' FROM '.$this->CFG['db']['tbl']['solutions'].
					' WHERE DATE_ADD(solution_added, INTERVAL 7 DAY) >= NOW()'.
					' GROUP BY user_id';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				    trigger_db_error($this->dbObj);

			$sql = 'CREATE OR REPLACE ALGORITHM=MERGE VIEW view_experts AS'.
					' SELECT * FROM view_boards_expert UNION ALL SELECT * FROM view_solutions_expert';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				    trigger_db_error($this->dbObj);

			$sql = 'TRUNCATE TABLE '.$this->CFG['db']['tbl']['view_weekly_experts'];
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				    trigger_db_error($this->dbObj);

			$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['view_weekly_experts'].
					' SELECT user_id, SUM(points) AS \'week_points\', NOW() FROM view_experts GROUP BY user_id';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				    trigger_db_error($this->dbObj);
		}

	/**
	 *
	 * @access public
	 * @return void
	 **/
	public function showCategoryName($cat_id)
	    {
			if (isset($this->_cache_category_details[$cat_id]))
				{
					$row = $this->_cache_category_details[$cat_id];

					$showCategoryName_val = '<span>'.$this->LANG['discuzz_common_in'].' <a href="'.getUrl('boards', '?cat='.$row['seo_title'], 'dir/'.$row['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']).'">'.$row['cat_name'].'</a></span>';

					return $showCategoryName_val;
				}

			$sql = 'SELECT cat_name, seo_title, cat_id FROM '.$this->CFG['db']['tbl']['category'].' WHERE cat_id='.$this->dbObj->Param('cat_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($cat_id));
			if (!$rs)
				    trigger_db_error($this->dbObj);
			if ($rs->PO_RecordCount())
				{
					$row = $rs->FetchRow();
					//cache category details
					$this->_cache_category_details[$cat_id] = $row;

					$showCategoryName_val = '<span>'.$this->LANG['discuzz_common_in'].' <a href="'.getUrl('boards', '?cat='.$row['seo_title'], 'dir/'.$row['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']).'">'.$row['cat_name'].'</a></span>';

					return $showCategoryName_val;
				}
			return false;
	    }

	/**
	 *
	 * @access public
	 * @return void
	 **/
	public function getEmailOptionsOfUser($uid)
	    {
			$sql = 'SELECT subscribe_keywords, keyword_mail, reply_mail, favorite_mail, best_solution_mail, abuse_mail'.
					' FROM '.$this->CFG['db']['tbl']['users_board_log'].
					' WHERE user_id='.$this->dbObj->Param('uid');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($uid));
			if (!$rs)
			        trigger_db_error($this->dbObj);
			$row = array('subscribe_keywords' => '', 'keyword_mail' => 'Yes', 'reply_mail' => 'Yes',
						 'favorite_mail' => 'Yes', 'best_solution_mail' => 'Yes', 'abuse_mail' => 'Yes');
			if ($rs->PO_RecordCount())
				$row = $rs->FetchRow();
			return $row;
	    }

	/**
	 *
	 * @return 		void
	 * @access 		public
	 */
	public function chkIsIntenalMailAllowed($user_id)
		{
			$sql = 'SELECT internal_mail FROM '.$this->CFG['db']['tbl']['users_board_log'].
					' WHERE user_id='.$this->dbObj->Param($user_id);
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($user_id));
			if (!$rs)
				    trigger_db_error($this->dbObj);
			$ok = true;
			if ($rs->PO_RecordCount())
				{
					$row = $rs->FetchRow();
					if ($row['internal_mail'] == 'No' or !$this->CFG['admin']['module']['mail'])
						$ok = false;
				}
			return $ok;
		}

	/**
	 *
	 * @return 		void
	 * @access 		public
	 */
	public function getUserLog($user_id)
		{
			if (isset($this->_cache_user_log_details[$user_id]))
				{
					return $this->_cache_user_log_details[$user_id];
				}

			$sql = 'SELECT total_board, total_solution, total_best_solution, total_points'.
					', DATE_FORMAT(date_updated,\'%D %b %Y\') as date_updated'.
					' FROM '.$this->CFG['db']['tbl']['users_board_log'].
					' WHERE user_id='.$this->dbObj->Param($user_id);
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($user_id));
			if (!$rs)
			        trigger_db_error($this->dbObj);
			$user_ans_log = array('total_board'=>'0', 'total_solution'=>'0', 'total_best_solution'=>'0', 'total_points'=>'0', 'date_updated'=>'');
			if ($rs->PO_RecordCount())
				$user_ans_log = $rs->FetchRow();

			//cache user log details
			$this->_cache_user_log_details[$user_id] = $user_ans_log;

			return $user_ans_log;
		}

	/**
	 *
	 * @return 		void
	 * @access 		public
	 */
	public function showPostLinks()
		{
			$not_allowed_pages_array = array('error.php');
	  		$discussionHeaderHandler = new HeaderHandler;
	  		$this->_currentPage = $discussionHeaderHandler->_currentPage;

			$this->setFormField('title', '');
			$this->setFormField('view', '');
			$this->sanitizeFormInputs($_REQUEST);

			if(displayBlock($not_allowed_pages_array))
				return;
			if ($this->CFG['html']['current_script_name'] == 'boards' AND isset($this->fields_arr['view']) AND in_array($this->fields_arr['view'], array('search', 'recent', 'popular', 'recentlysolutioned', 'best', 'featured')))
				{
					return;
				}

			global $smartyObj;
			$showPostLinks_arr = array();

			$showPostLinks_arr['link'] = getUrl('adddiscussion', '', '', 'members', $this->CFG['admin']['index']['home_module']);
			$showPostLinks_arr['text'] = $this->LANG['discussion_postnew'];
			$showPostLinks_arr['class'] = '';
			$showPostLinks_arr['showLink'] = true;

			if(!$this->CFG['admin']['discussions']['add_title'])
				$showPostLinks_arr['showLink'] = false;

			if(!isMember())
				{
					$showPostLinks_arr['link'] = getUrl('login', '?light_url='.$showPostLinks_arr['link'], '?light_url='.$showPostLinks_arr['link'], 'root');
					$showPostLinks_arr['class'] = 'lightwindow';
				}

			$highlight_pages = array('boards', 'solutions');
			if(in_array($this->_currentPage, $highlight_pages))
				{
					$showPostLinks_arr['showLink'] = true;
					$view = '';
					if ($this->_currentPage == 'boards') {
							if($this->fields_arr['title'] || !in_array($this->fields_arr['view'], array('ask', 'search', 'popular', 'recentlysolutioned', 'best', 'featured', 'recent')))
								{
									$title = ($this->fields_arr['title'])?$this->fields_arr['title']:$this->fields_arr['view'];
									$view = '?view=ask&amp;title='.$title;
									$showPostLinks_arr['link'] = getUrl('boards', $view, 'ask/?title='.$title, 'members', $this->CFG['admin']['index']['home_module']);
									if(!isMember())
										{
											$discussionsAdd_url = getUrl('adddiscussion', '', '', 'members', $this->CFG['admin']['index']['home_module']);
											$showPostLinks_arr['link'] = getUrl('login', '?light_url='.$showPostLinks_arr['link'], '?light_url='.$showPostLinks_arr['link'], 'root');
											$showPostLinks_arr['class'] = 'lightwindow';
										}
								}
							else
								{
									$showPostLinks_arr['link'] = getUrl('discussions', '', '', '', $this->CFG['admin']['index']['home_module']);
									if(!isMember())
										{
											$discussionsAdd_url = getUrl('adddiscussion', '', '', 'members', $this->CFG['admin']['index']['home_module']);
											$showPostLinks_arr['link'] = getUrl('login', '?light_url='.$showPostLinks_arr['link'], '?light_url='.$showPostLinks_arr['link'], 'root');
											$showPostLinks_arr['class'] = 'lightwindow';
										}
								}
								$showPostLinks_arr['text'] = $this->LANG['board_postnew'];
					}
					elseif ($this->_currentPage == 'solutions')
						{
							if($this->fields_arr['title'] || !in_array($this->fields_arr['view'], array('ask', 'search', 'popular', 'recentlysolutioned', 'best', 'featured', 'recent')))
								{
									$title = ($this->fields_arr['title'])?$this->fields_arr['title']:$this->fields_arr['view'];
									$view = '?action=reply&amp;title='.$title;
									$showPostLinks_arr['link'] = getUrl('replysolution', $view, $title.'/', 'members', $this->CFG['admin']['index']['home_module']);
									if(!isMember())
										{
											$discussionsAdd_url = getUrl('adddiscussion', '', '', 'members', $this->CFG['admin']['index']['home_module']);
											$showPostLinks_arr['link'] = getUrl('login', '?light_url='.$showPostLinks_arr['link'], '?light_url='.$showPostLinks_arr['link'], 'root');
											$showPostLinks_arr['class'] = 'lightwindow';
										}
								}
							else
								{
									$showPostLinks_arr['link'] = getUrl('discussions', '', '', '', $this->CFG['admin']['index']['home_module']);
									if(!isMember())
										{
											$discussionsAdd_url = getUrl('adddiscussion', '', '', 'members', $this->CFG['admin']['index']['home_module']);
											$showPostLinks_arr['link'] = getUrl('login', '?light_url='.$showPostLinks_arr['link'], '?light_url='.$showPostLinks_arr['link'], 'root');
											$showPostLinks_arr['class'] = 'lightwindow';
										}
								}
								$showPostLinks_arr['text'] = $this->LANG['solutions_postnew'];
						}


				}

			$smartyObj->assign('showPostLinks_arr', $showPostLinks_arr);
			setTemplateFolder('general/', $this->CFG['admin']['index']['home_module']);
			$smartyObj->display('showPostLinks.tpl');
		}

		/**
		 * To show solutions search option
		 *
		 * @return 		void
		 * @access 		public
		 */
	public function showDiscussionSearchOption()
		{
			return false;
	  		$discussionHeaderHandler = new HeaderHandler;
	  		$this->_currentPage = $discussionHeaderHandler->_currentPage;

			$allowed_pages_array = array('discussions.php', 'discussionSearch.php', 'addDiscussionTitle.php');

			if(!displayBlock($allowed_pages_array))
				return;

			global $smartyObj;
			$showDiscussionSearchOption_arr = array();

			if($this->getFormField('discussion_title'))
				{
					if(isset($_SESSION['discussion_title']) && $this->_currentPage == 'discussionsearch')
						$showDiscussionSearchOption_arr['discussion_field_value'] = $_SESSION['discussion_title'];
				}
			else if($this->getFormField('search_discussion'))
				{
					if(isset($_SESSION['search_discussion']) && $this->_currentPage == 'discussionsearch')
						$showDiscussionSearchOption_arr['discussion_field_value'] = $_SESSION['search_discussion'];
					else
						{
							$showDiscussionSearchOption_arr['discussion_field_value'] = $this->LANG['header_search_for_discussions'];
						}
				}
			else
				$showDiscussionSearchOption_arr['discussion_field_value'] = $this->LANG['header_search_for_discussions'];

			$showDiscussionSearchOption_arr['defaultText'] = $this->LANG['header_search_for_discussions'];

			$showDiscussionSearchOption_arr['form_action'] = getUrl('discussionsearch', '?view=search', 'search/', '', $this->CFG['admin']['index']['home_module']);
			$showDiscussionSearchOption_arr['advanced_search']['url'] = getUrl('discussionsearch', '?so=adv&amp;view=search', 'search/?so=adv', '', $this->CFG['admin']['index']['home_module']);

			$smartyObj->assign('showDiscussionSearchOption_arr', $showDiscussionSearchOption_arr);
			setTemplateFolder('general/', $this->CFG['admin']['index']['home_module']);
			$smartyObj->display('showDiscussionSearchOption.tpl');
		}

	public function showSolutionSearchOption()
		{
	  		$discussionHeaderHandler = new HeaderHandler;
	  		$this->_currentPage = $discussionHeaderHandler->_currentPage;

			$this->setFormField('more_boards', '');
			$this->setFormField('search_board', $this->LANG['header_search_for_boards']);
			$this->sanitizeFormInputs($_REQUEST);

			$not_allowed_pages_array = array('topContributors.php');

			if(displayBlock($not_allowed_pages_array))
				return;

			global $smartyObj;
			$showSolutionSearchOption_arr = array();

			if($this->_currentPage == 'solutions')
				$showSolutionSearchOption_arr['enclose_div'] = false;
			else
				$showSolutionSearchOption_arr['enclose_div'] = true;

			if($this->getFormField('more_boards'))
				{
					if(isset($_SESSION['more_boards']) && $this->_currentPage == 'boards')
						$showSolutionSearchOption_arr['board_field_value'] = $_SESSION['more_boards'];
				}
			else if($this->getFormField('search_board'))
				{
					if(isset($_SESSION['search_board']) && $this->_currentPage == 'boards')
						$showSolutionSearchOption_arr['board_field_value'] = $_SESSION['search_board'];
					else
						{
							$showSolutionSearchOption_arr['board_field_value'] = $this->LANG['header_search_for_boards'];
						}
				}
			else
				$showSolutionSearchOption_arr['board_field_value'] = $this->LANG['header_search_for_boards'];

			$showSolutionSearchOption_arr['defaultText'] = $this->LANG['header_search_for_boards'];

			$showSolutionSearchOption_arr['form_action'] = getUrl('boards', '?view=search', 'search/', '', $this->CFG['admin']['index']['home_module']);
			$showSolutionSearchOption_arr['advanced_search']['url'] = getUrl('boards', '?so=adv&amp;view=search', 'search/?so=adv', '', $this->CFG['admin']['index']['home_module']);

			$smartyObj->assign('showSolutionSearchOption_arr', $showSolutionSearchOption_arr);
			setTemplateFolder('general/', $this->CFG['admin']['index']['home_module']);
			$smartyObj->display('showSolutionSearchOption.tpl');
		}

	public function showMemberSearchOption()
		{
			$this->setFormField('search_member', '');
			$this->sanitizeFormInputs($_REQUEST);

			$allowed_pages_array = array('topContributors.php');

			if(!displayBlock($allowed_pages_array))
				return;

			global $smartyObj;
			$showMemberSearchOption_arr = array();

			if($this->getFormField('search_member'))
				$showMemberSearchOption_arr['board_field_value'] = $this->getFormField('search_member');
			else
				$showMemberSearchOption_arr['board_field_value'] = $this->LANG['header_search_for_members'];

			$showMemberSearchOption_arr['defaultText'] = $this->LANG['header_search_for_members'];
			$showMemberSearchOption_arr['form_action'] = getUrl('topcontributors', '', '', '', $this->CFG['admin']['index']['home_module']);
			$showMemberSearchOption_arr['advanced_search']['url'] = getUrl('topcontributors', '?so=adv', '?so=adv', '', $this->CFG['admin']['index']['home_module']);

			$smartyObj->assign('showMemberSearchOption_arr', $showMemberSearchOption_arr);
			setTemplateFolder('general/', $this->CFG['admin']['index']['home_module']);
			$smartyObj->display('showMemberSearchOption.tpl');
		}

	/**
	 * DiscussionHandler::showUserStatistics()
	 *
	 * @return
	 */
	public function showUserStatistics()
		{
			global $smartyObj;
			$showUserStatistics_arr = array();
			$showUserStatistics_arr['userLog'] = $this->getUserLog($this->CFG['user']['user_id']);
			$showUserStatistics_arr['userDetails'] = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $this->CFG['user']['user_id']);
			$showUserStatistics_arr['discussions'] = $this->getTotalDiscussion();
			$showUserStatistics_arr['boards'] = $showUserStatistics_arr['userLog']['total_board'];
			$showUserStatistics_arr['solution'] = $showUserStatistics_arr['userLog']['total_solution'];
			$showUserStatistics_arr['rate_recieved'] = $showUserStatistics_arr['userLog']['total_points'];
			$showUserStatistics_arr['online_hours'] = $this->getTotalOnlineHours($this->CFG['user']['user_id']);
			$showUserStatistics_arr['registered'] = date('d-M-Y',strtotime($showUserStatistics_arr['userDetails']['doj']));
			$smartyObj->assign('showUserStatistics_arr', $showUserStatistics_arr);
			setTemplateFolder('members/', $this->CFG['admin']['index']['home_module']);
			$smartyObj->display('showUserStatistics.tpl');
		}

	/**
	 * DiscussionHandler::showUserStatistics()
	 *
	 * @return
	 */
	public function showModuleStatistics()
		{
			global $smartyObj;
			$showModuleStatistics_arr = array();
			$showModuleStatistics_arr['discussions'] = $this->getModuleTotalDiscussion();
			$showModuleStatistics_arr['boards'] = $this->getModuleTotalBoard();
			$showModuleStatistics_arr['solution'] = $this->getModuleTotalSolution();
			$smartyObj->assign('showModuleStatistics_arr', $showModuleStatistics_arr);
		}

	/**
	 * DiscussionHandler::getTotalDiscussion()
	 *
	 * @return
	 */
	public function getTotalDiscussion()
		{
			$sql = 'SELECT discussion_id FROM '.$this->CFG['db']['tbl']['discussions'].
					' WHERE status = \'Active\''.
					' AND user_id = '.$this->dbObj->Param('user_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			if (!$rs)
				    trigger_db_error($this->dbObj);

			$count = 0;
			if ($count=$rs->PO_RecordCount())
				return $count;
			return $count;

		}
	/**
	 * DiscussionHandler::getModuleTotalDiscussion()
	 *
	 * @return
	 */
	public function getModuleTotalDiscussion()
		{
			$sql = 'SELECT discussion_id FROM '.$this->CFG['db']['tbl']['discussions'].
					' WHERE status = \'Active\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				    trigger_db_error($this->dbObj);

			$count = 0;
			if ($count=$rs->PO_RecordCount())
				return $count;
			return $count;

		}
	/**
	 * DiscussionHandler::getModuleTotalBoard()
	 *
	 * @return
	 */
	public function getModuleTotalBoard()
		{
			$sql = 'SELECT board_id FROM '.$this->CFG['db']['tbl']['boards'].
					' WHERE status = \'Active\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				    trigger_db_error($this->dbObj);

			$count = 0;
			if ($count=$rs->PO_RecordCount())
				return $count;
			return $count;
		}
	/**
	 * DiscussionHandler::getModuleTotalSolution()
	 *
	 * @return
	 */
	public function getModuleTotalSolution()
		{
			$sql = 'SELECT solution_id FROM '.$this->CFG['db']['tbl']['solutions'].
					' WHERE status = \'Active\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				    trigger_db_error($this->dbObj);

			$count = 0;
			if ($count=$rs->PO_RecordCount())
				return $count;
			return $count;

		}
	/**
	* Gets the filtered words for searching
	*
	*/
	public function filterWordsForSearching($search_text)
		{
			//Common words
			$common_words_list = $this->getCommonWordList();

			//Remove special chars
			$search_text = trim($this->specialCharsToRemove($search_text));
			//Convert the search text to lower and replace accentuation
			$search_array = $this->arrayValidation($search_text);
			//Find out the diff words
			$resultant_array = array_diff($search_array, $common_words_list);
			//Filter unique words
			$resultant_array = array_unique($resultant_array);

			return $resultant_array;
		}
	/**
	*
	* Removes the special characters and returns the string.
	*/
	public function specialCharsToRemove($text)
		{
			$charsToRemove = array('~', '`', '@', '#', '$', '%', '^', '&amp;', '*', '(', ')', '_', '+', '=', '{', '[', '}', ']', ':', '&quot;', '\'', '|', '\\',
									'&lt;', ',', '&gt;', '.', '?', '/', '!', ';', '-');
			$text = str_replace($charsToRemove, ' ', $text);
		    return $text;
		}

	/**
	* Gets the common words list
	*
	*/
	public function getCommonWordList()
		{
			if ($this->_common_words)
				{
					return $this->_common_words;
				}

			$this->_common_words = array();

			$sql = 'SELECT words FROM '.$this->CFG['db']['tbl']['common_words'].' WHERE id = 1';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				trigger_db_error($this->dbObj);
			if($rs->PO_RecordCount())
				{
					$row = $rs->FetchRow();
					//Convert the common words to lower and replace accentuation
					$this->_common_words = $this->arrayValidation($row['words'], ',');
					//$this->_common_words = $row['words'];
				}
			return $this->_common_words;
		}
	/**
	 *
	 * @return 		void
	 * @access 		public
	 */
	public function arrayValidation($words, $explode_with = ' ', $DISP = false)
		{
			//Create urf8 object
			//$utf8Obj = new utf8();

			//Convert to lower case string
			$words_lower = strtolower($words);
			//Encode to HTML-ENTITIES using mbstring
			$text = mb_convert_encoding($words_lower, 'HTML-ENTITIES');
			//Accentuation array
		    $char_search = array('&#940;', '&#941;', '&#942;', '&#943;', '&#970;', '&#972;', '&#973;', '&#971;', '&#974;', '&#940;', '&#941;', '&#942;',
								 '&#943;', '&#970;', '&#912;', '&#972;', '&#973;', '&#971;', '&#944;', '&#974;', '&Pi');
			//Array to replace accentuation
			$char_replace =array('&alpha;', '&epsilon;', '&eta;', '&iota;', '&iota;', '&omicron;', '&upsilon;', '&upsilon;', '&omega;', '&alpha;', '&epsilon;',
								 '&eta;', '&iota;', '&iota;', '&iota;', '&omicron;', '&upsilon;', '&upsilon;', '&upsilon;', '&omega;', '&pi');
			//Replace accentuation
			$text = str_replace($char_search, $char_replace, $text);
			//Convert the sting to normal string
			$words_lower_accent = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
			//Explode as array
			$words_list = explode($explode_with, $words_lower_accent);
			//Trim the array
			$words_list = array_trim($words_list);
			//return the final array
			return $words_list;
		}
	/**
	*
	* @return 	url
	* @access 	public
	*/
	public function getMemberUrl($uid, $uname)
		{
			return getUrl('mysolutions', '?uid='.$uname, $uname.'/');
		}
	/**
	 *
	 * @return 		void
	 * @access 		public
	 */
	public function isShowIndexBlock($block, $userAllowed='yes')
		{
			$ok = true;
			switch($block){
				case 'no':
					$ok = false;
					break;
				case 'yes':
					if ($userAllowed != 'yes')
						$ok = false;
					break;
			} // switch
			return $ok;
		}
	/**
	 *
	 * @access public
	 * @return void
	 **/
	public function getUserTableField($user_field)
	    {
			return getUserTableField($user_field);
	    }

	/**
	 *
	 * @access public
	 * @return void
	 **/
	public function getUserTableFields($user_fields, $trim=true)
	    {
			return getUserTableFields($user_fields, $trim=true);
	    }
	/**
	 *
	 * @return 		void
	 * @access 		public
	 */
	public function displayProfileImage($img_arr, $img_type, $showPopup = true, $contentDisplay = false)
		{
			displayProfileImage($img_arr, $img_type, $showPopup, $contentDisplay);
		}
	/**
	 * get username for user_id
	 *
	 * @param 		string $user_table
	 * @param 		integer $user_id
	 * @return 		string
	 * @access 		public
	 */
	public function getUserDetailsFromUsersTable($user_table, $user_id)
		{
			if (isset($this->_cache_user_details[$user_id]))
				{
					return $this->_cache_user_details[$user_id];
				}
			$row = getUserDetailsFromUsersTable($user_table, $user_id);
			//cache user detalis
			$this->_cache_user_details[$user_id] = $row;
			return	$row;
		}
	/**
	 *
	 * @return 		void
	 * @access 		public
	 */
	public function getUsersDisplayName($name)
		{
			return getUsersDisplayName($name);
		}
	/**
	 *
	 * @return 		void
	 * @access 		public
	 */
	public function getCSSFormFieldElementClass($field_name)
		{
			$class_name = isset($this->fields_err_tip_arr[$field_name]) ? 'LV_invalid_field' : '';
			return $class_name;
		}

   /**
    * To set the css class for error tip
    *
    * We can set the css error tip class for the form fields
    *
    * @param 		string $class_name Error tip class name
    * @return 		void
	* @access 		public
    */
	public function setCSSFormFieldErrorTipClass($class_name)
		{
			$this->css_class_arr['form_field_err_tip'] = $class_name;
		}

   /**
    * To set the default css class for label
    *
    * @param 		string $class_name default label class
    * @return 		void
	* @access 		public
    */
	public function setCSSFormLabelCellDefaultClass($class_name)
		{
			$this->css_class_arr['form_label_cell_default'] = $class_name;
		}

   /**
    * To set the css class for error label
    *
    * @param 		string $class_name error label class
    * @return 		void
	* @access 		public
    */
	public function setCSSFormLabelCellErrorClass($class_name)
		{
			$this->css_class_arr['form_label_cell_error'] = $class_name;
		}

   /**
    * To set the default css class for form field
    *
    * @param 		string $class_name default form field class
    * @return 		void
	* @access 		public
    */
	public function setCSSFormFieldCellDefaultClass($class_name)
		{
			$this->css_class_arr['form_field_cell_default'] = $class_name;
		}

   /**
    * To set css class for error form fields
    *
    * @param 		string $class_name error form field class
    * @return 		void
	* @access 		public
    */
	public function setCSSFormFieldCellErrorClass($class_name)
		{
			$this->css_class_arr['form_field_cell_error'] = $class_name;
		}

   /**
    * To get the css label class
    *
    * @param 		string $field_name form field
    * @return 		string
	* @access 		public
    */
	public function getCSSFormLabelCellClass($field_name)
		{
			$class_name = isset($this->fields_err_tip_arr[$field_name]) ? 'form_label_cell_error' : 'form_label_cell_default';
			return $this->css_class_arr[$class_name];
		}

   /**
    * To get the css form field class
    *
    * @param 		string $field_name form field name
    * @return 		string
	* @access 		public
    */
	public function getCSSFormFieldCellClass($field_name)
		{
			$class_name = isset($this->fields_err_tip_arr[$field_name]) ? 'form_field_cell_error' : 'form_field_cell_default';
			return $this->css_class_arr[$class_name];
		}
	/**
    * To get the form field error tip
    *
    * @param 		string $field_name form field name
    * @return 		string
	* @access 		public
    */
	public function setFormFieldErrorTip($field_name, $err_tip = '')
		{
			$this->fields_err_tip_arr[$field_name] = $err_tip;
		}

   /**
    * To get the form field error tip
    *
    * @param 		string $field_name form field name
    * @return 		string
	* @access 		public
    */
	public function getFormFieldErrorTip($field_name)
		{
			return (isset($this->fields_err_tip_arr[$field_name]) and $this->fields_err_tip_arr[$field_name]) ? '<span class="'.$this->css_class_arr['form_field_err_tip'].'">'.$this->fields_err_tip_arr[$field_name].'</span>' : '';
		}

	/**
	 * To get the form field error for live validation
	 *
	 * @return 		void
	 * @access 		public
	 */
	public function getFormFieldElementErrorTip($field_name, $select='')
		{
			$span_id = '';
			if(isset($select) && $select !='')
				$span_id = 'id="selectspan"';
			return (isset($this->fields_err_tip_arr[$field_name]) and $this->fields_err_tip_arr[$field_name]) ? '<span '.$span_id.'class="LV_validation_message LV_invalid">'.$this->fields_err_tip_arr[$field_name].'</span>' : '';
		}
	/**
	 *
	 * @return 		void
	 * @access 		public
	 */
	public function getSeoTitle($table_name='', $title_field='', $current_title_value='', $primary_field='', $primary_field_value='')
		{
			if ($primary_field_value)
				{
					$sql = 'SELECT seo_title FROM '.$table_name.
							' WHERE '.$primary_field.'='.$this->dbObj->Param($primary_field_value).
							' AND '.$title_field.'='.$this->dbObj->Param($current_title_value);

					// prepare sql
					$stmt = $this->dbObj->Prepare($sql);

					// execute sql
					$rs = $this->dbObj->Execute($stmt, array($primary_field_value, $current_title_value));

					//raise user error... fatal
					if (!$rs)
						trigger_db_error($this->dbObj);
					if ($rs->PO_RecordCount())
						{
							$row = $rs->FetchRow();
							$seoTitle = trim($row['seo_title']);
							if ($seoTitle)
								{
									return $seoTitle;
								}
						}
				}

			$primaryCheck = '';
			$sql =  ' SELECT COUNT('.$title_field.') AS title_count '.
					' FROM '.$table_name.
					' WHERE '.$title_field.' = '.$this->dbObj->Param($current_title_value);
			$paramFields = array($current_title_value);

			$sql = $sql.$primaryCheck;
			// prepare sql
			$stmt = $this->dbObj->Prepare($sql);
			// execute sql
			$rs = $this->dbObj->Execute($stmt, array($paramFields));
			//raise user error... fatal
			if (!$rs)
				trigger_db_error($this->dbObj);
			$row = $rs->FetchRow();
			$previousEntryCount = $row['title_count'];
			$seoTitle = $current_title_value;
			//Convert charset
			$seoTitle = seoFriendlyText($seoTitle, $this->CFG['site']['charset']);
			//$seoTitle = ereg_replace ('[^a-zA-Z0-9]', '-', trim($seoTitle));
			$seoTitle = preg_replace('/[^a-zA-Z0-9]/', '-', trim($seoTitle));
			$seoTitle = preg_replace('/(-)+$/','',$seoTitle);
			//Removed repeated - symbol
			//$seoTitle = ereg_replace('([-]+)', '-', trim($seoTitle));
			$seoTitle = preg_replace('/([-]+)/', '-', trim($seoTitle));
			$seoTitle = ($seoTitle)?$seoTitle:'1';
			$seoTitle .= $previousEntryCount?'-'.$previousEntryCount:'';

			$seoTitle = $this->getSeoName($table_name, $primary_field, 'seo_title', $seoTitle);

			return $seoTitle;
		}
	/**
	 *
	 * @return 		getDiscussionDetails
	 * @access 		public
	 */
	public function getDiscussionDetails($discussion_id)
		{
			$sql = 'SELECT d.discussion_id, d.discussion_title, d.pcat_id, d.cat_id, d.description, d.visible_to, d.publish_status, TIMEDIFF(NOW(), d.date_added) as date_asked'.
					', '.$this->getUserTableField('display_name').' as asked_by, u.'.$this->getUserTableField('user_id').' as img_user_id,'.getUserTableFields(array('name')).' , d.status, d.user_id'.
					', d.seo_title FROM '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['users'].' AS u'.
					' WHERE d.user_id=u.'.$this->getUserTableField('user_id').' AND d.status = \'Active\''.
					' AND u.'.$this->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id='.$this->dbObj->Param('discussion_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($discussion_id));
			if (!$rs)
			        trigger_db_error($this->dbObj);
			if ($rs->PO_RecordCount())
				{
					$row = $rs->FetchRow();
					$row['discussion_title'] = stripString($row['discussion_title']);
					return $row;
				}
			return false;
		}
	/**
	 *
	 * @return 		getSolutionActivityDetails
	 * @access 		public
	 */
	public function getSolutionActivityDetails($solution_id)
		{
			$sql = 'SELECT b.board_id, b.seo_title, b.board, s.solution FROM '.$this->CFG['db']['tbl']['boards'].' AS b, '.$this->CFG['db']['tbl']['solutions'].' AS s'.
					' WHERE b.board_id = s.board_id AND s.solution_id='.$this->dbObj->Param('solution_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($solution_id));
			if (!$rs)
			        trigger_db_error($this->dbObj);
			if ($rs->PO_RecordCount())
				{
					$row = $rs->FetchRow();
					$row['qLink'] = getUrl('solutions', '?title='.$row['seo_title'], $row['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']);
					$row['board_link']= '<a href="'.$row['qLink'].'" class="clsActivityTopic">'.stripstring($row['board']).'</a>';
					return $row;
				}
			return false;
		}

	public function chkIsAllowedModule($module_arr = array())
		{
			chkAllowedModule($module_arr);
		}

	public function getSeoName($table_name, $primary_key_field, $to_field_name, $str_to_convert)
		{
			$temp_str = $to_str = $str_to_convert;
			if ($check = $this->checkAndRenameString($table_name, $primary_key_field, $to_field_name, $to_str))
			{
				$i = 0;
				while(true)
					{
						$to_str = $temp_str.'-'.++$i;
						if (!$this->checkAndRenameString($table_name, $primary_key_field, $to_field_name, $to_str))
							break;
					}
			}
			return $to_str;
		}

	public function getMailContent($content, $fieldsArr)
		{
			$chkArray = array('VAR_COMMENT', 'VAR_EMAIL','VAR_PASSWORD','VAR_DISPLAYNAME','VAR_USERNAME','VAR_BOARD','VAR_SITENAME', 'VAR_LINK',
							  'VAR_SENDER_NAME', 'VAR_SENDER_COMMENT', 'VAR_DESCRIPTION_OF_QUESTION', 'VAR_DESCRIPTION_OF_COMMENT',
							  'VAR_DISCUSSION', 'VAR_DESCRIPTION_OF_DISCUSSION');
			foreach($chkArray as $value)
				{
					$toReplace = $value;
					if(array_key_exists($value, $fieldsArr))
						$content = str_ireplace($toReplace, $fieldsArr[$value], $content);
					else
						$content = str_ireplace($toReplace, '', $content);
				}
			return $content;
		}
	/**
	 *
	 * @access public
	 * @return void
	 **/
	public function getTimeDiffernceFormat($time)
		{
			if(!$time)
				$time = '000:00:00';
			global $LANG;
			$date_added_pc = explode(':', $time);
			$date_added_pc[0] = intval($date_added_pc[0]);
			$date_added_pc[1] = intval($date_added_pc[1]);
			$date_added_pc[2] = intval($date_added_pc[2]);

			if($date_added_pc[0])
				{
					$day = floor($date_added_pc[0]/24);
					if($day>365)
						{
							$year = floor($day/365);
							if($year == 1)
								$time = $year.' '.$LANG['year_ago'];
							else
								$time = $year.' '.$LANG['years_ago'];
						}
					else if($day>30)
						{
							$month = floor($day/30);
							if($month == 1)
								$time = $month.' '.$LANG['month_ago'];
							else
								$time = $month.' '.$LANG['months_ago'];
						}
					else if($day)
						{
							if($day == 1)
								$time = $day.' '.$LANG['day_ago'];
							else
								$time = $day.' '.$LANG['days_ago'];
						}
					else
						{
							if($date_added_pc[0] == 1)
								$time = $date_added_pc[0].' '.$LANG['hour_ago'];
							else
								$time = $date_added_pc[0].' '.$LANG['hours_ago'];
						}
				}
			else if($date_added_pc[1])
				{
					if($date_added_pc[1] == 1)
						$time = $date_added_pc[1].' '.$LANG['minute_ago'];
					else
						$time = $date_added_pc[1].' '.$LANG['minutes_ago'];
				}
			else
				{
					if($date_added_pc[2] == 1)
						$time = $date_added_pc[2].' '.$LANG['second_ago'];
					else
						$time = $date_added_pc[2].' '.$LANG['seconds_ago'];
				}
			return $time;
		}
	/**
	 *
	 * @access public
	 * @return void
	 **/
	public function appendMetaDetails($text_to_add, $category)
		{
			global $LANG, $CFG;

			$split_string = explode(" ", $text_to_add);
			if($CFG['html']['meta']['min_characters_appendable'] && (count($split_string) > $CFG['html']['meta']['min_characters_appendable']))
				{
					$new_text = '';
					for($inc = 0; $inc < $CFG['html']['meta']['min_characters_appendable']; $inc++)
						{
							$new_text.=$split_string[$inc].' ';
						}
					$text_to_add = $new_text;
				}
			$text_to_add = htmlspecialchars($category.$text_to_add);
			if(isset($LANG['meta_'.strtolower($CFG['html']['current_script_name']).'_keywords']))
				$LANG['meta_'.strtolower($CFG['html']['current_script_name']).'_keywords'] = $text_to_add.', '.$LANG['meta_'.strtolower($CFG['html']['current_script_name']).'_keywords'];
			else
				$CFG['html']['meta']['keywords'] = $text_to_add.', '.$CFG['html']['meta']['keywords'];

			if(isset($LANG['meta_'.strtolower($CFG['html']['current_script_name']).'_description']))
				$LANG['meta_'.strtolower($CFG['html']['current_script_name']).'_description'] = $text_to_add.', '.$LANG['meta_'.strtolower($CFG['html']['current_script_name']).'_description'];
			else
				$CFG['html']['meta']['description'] = $text_to_add.', '.$CFG['html']['meta']['description'];
		}
	/**
	 *
	 * @return 		void
	 * @access 		public
	 */
	public function displayTopContributorSmallImage($img_arr, $showPopup = true, $contentDisplay = false)
		{
			displayTopContributorSmallImage($img_arr, 'small', $showPopup, $contentDisplay);
			return ;
		}
	public function populateTopMenu()
		{
			global $smartyObj;
			$populateTopMenu_arr = array();
			$currentPage = $this->CFG['html']['current_script_name'];
			$cssClassToMainLink = 'clsActiveHeaderMainLink';
			$cssClassToHighlightMainLink = 'clsActiveLink clsHighlightHeaderLink';
			$populateTopMenu_arr['mail']['class'] = $populateTopMenu_arr['login']['class'] = $populateTopMenu_arr['signup']['class'] = $populateTopMenu_arr['logout']['class'] = $cssClassToMainLink;
			$populateTopMenu_arr['boards']['class'] = $cssClassToHighlightMainLink;
			$$currentPage = $cssClassToHighlightMainLink;
			$populateTopMenu_arr['managesettings']['class'] = '';

			if($currentPage == 'manageSettings')
				$populateTopMenu_arr['managesettings']['class'] = 'clsActiveNavMenu';

			$ans_page_arr = array('index', 'signup', 'logout', 'manageSettings', 'staticPage', 'verifyMail', 'activateAccount', 'activateMailAccount', 'forgotPassword');
			if(in_array($currentPage, $ans_page_arr))
				{
					$populateTopMenu_arr['boards']['class'] = $cssClassToMainLink;
				}

			$ans_page_arr = array('mail', 'mailCompose', 'mailRead');
			if(in_array($currentPage, $ans_page_arr))
				{
					$populateTopMenu_arr['boards']['class'] = $cssClassToMainLink;
					$populateTopMenu_arr['mail']['class'] = $cssClassToHighlightMainLink;
				}

			$ans_page_arr = array('login', 'devLogin');
			if(in_array($currentPage, $ans_page_arr))
				{
					$populateTopMenu_arr['boards']['class'] = $cssClassToMainLink;
					$populateTopMenu_arr['login']['class'] = $cssClassToHighlightMainLink;
				}

			$ans_page_arr = array('signup');
			if(in_array($currentPage, $ans_page_arr))
				{
					$populateTopMenu_arr['boards']['class'] = $cssClassToMainLink;
					$populateTopMenu_arr['signup']['class'] = $cssClassToHighlightMainLink;
				}

			$populateTopMenu_arr['boards']['url'] = getUrl('discussions','','','',$this->CFG['admin']['index']['home_module']);
			$populateTopMenu_arr['mail']['url'] = getUrl('mail', '?folder=inbox', 'inbox/', 'members');
			$populateTopMenu_arr['login']['url'] = getUrl('login', '', '', 'root');
			$populateTopMenu_arr['logout']['url'] = getUrl('logout', '', '', 'root');
			$populateTopMenu_arr['signup']['url'] = getUrl('signup', '', '', 'root');

			$populateTopMenu_arr['settings']['url'] = getSettingsUrl();
			$populateTopMenu_arr['help']['url'] = getUrl('static', '?pg=faq', 'faq/', 'root');

			$smartyObj->assign('populateTopMenu_arr', $populateTopMenu_arr);
			setTemplateFolder('general/');
			$smartyObj->display('populateTopMenu.tpl');
		}
	public function displayStaticPageLinks()
		{
			$displayStaticPageLinks_val = '';

			$sql = 'SELECT page_title, seo_title FROM '.$this->CFG['db']['tbl']['static_pages'].
					' WHERE page_status=\'Yes\' AND link_in_footer=\'Yes\'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

			if (!$rs->PO_RecordCount())
				return ;

			while($row = $rs->FetchRow())
				{
					$sPage = $row['page_title'];
					$seoPage = $row['seo_title'];

					$displayStaticPageLinks_val .= '<li><a href="'.getUrl('static', '?pg='.$seoPage, $seoPage.'/').'">'.$sPage.'</a></li>';
				}
			return $displayStaticPageLinks_val;
		}
	public function getDisclaimerText()
		{
			$disclaimer_text = $this->LANG['header_disclaimer_text'];
			$disclaimer_text = str_ireplace('VAR_SITENAME', $this->CFG['site']['name'], $disclaimer_text);
			$disclaimer_text = str_ireplace('VAR_LINK', '<a href="'.getUrl('static', '?pg=terms', 'terms/').'">', $disclaimer_text);
			return $disclaimer_text = str_ireplace('VAR_END_LINK', '</a>', $disclaimer_text);
		}
	/**
	* showWelcomeMsg() :: welcome message
	*/
	public function showWelcomeMsg()
		{
			if(isset($this->CFG['user']['user_name']) && $this->CFG['user']['user_name'])
				$display_name = $this->CFG['user']['user_name'];
			else
				$display_name = $this->CFG['user']['name'];
			$mysolutions_link = getMemberUrl($this->CFG['user']['user_id'], $display_name);
			echo $this->LANG['header_hi'].' <a href="'.$mysolutions_link.'">'.$display_name.'</a>';
		}
		public function populateBoardRatingImages($rating = 0,$imagePrefix='',$condition='',$url='', $module='discussions')
			{
				global $smartyObj;
				if($module!= '')
					$module .= '/';
				$populateRatingImages_arr = array();
				$populateRatingImages_arr['rating'] = $rating;
				$populateRatingImages_arr['condition'] = $condition;
				$populateRatingImages_arr['url'] = $url;
				$populateRatingImages_arr['rating_total'] = $this->CFG['admin']['total_rating'];
				if($populateRatingImages_arr['rating']>$populateRatingImages_arr['rating_total'])
					$populateRatingImages_arr['rating'] = $populateRatingImages_arr['rating_total'];

				$populateRatingImages_arr['bulet_star'] = $this->CFG['site']['url'].$module.'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-'.$imagePrefix.'ratehover.gif';
				$populateRatingImages_arr['bulet_star_empty'] = $this->CFG['site']['url'].$module.'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-'.$imagePrefix.'rate.gif';
				$smartyObj->assign('populateRatingImages_arr', $populateRatingImages_arr);
				setTemplateFolder('general/','discussions');
				$smartyObj->display('populateRatingImages.tpl');
			}
			public function populateSolutionRatingImages($rating = 0,$imagePrefix='',$condition='',$url='', $module='discussions',$solution_id = '')
			{

				global $smartyObj;
				if($module!= '')
					$module .= '/';
				$populateRatingImages_arr = array();
				$populateRatingImages_arr['rating'] = $rating;
				$populateRatingImages_arr['condition'] = $condition;
				$populateRatingImages_arr['url'] = $url;
				$populateRatingImages_arr['solution_id'] = $solution_id;
				$populateRatingImages_arr['rating_total'] = $this->CFG['admin']['total_rating'];
				if($populateRatingImages_arr['rating']>$populateRatingImages_arr['rating_total'])
					$populateRatingImages_arr['rating'] = $populateRatingImages_arr['rating_total'];

				$populateRatingImages_arr['bulet_star'] = $this->CFG['site']['url'].$module.'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-'.$imagePrefix.'ratehover.gif';
				$populateRatingImages_arr['bulet_star_empty'] = $this->CFG['site']['url'].$module.'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-'.$imagePrefix.'rate.gif';
				$smartyObj->assign('populateRatingImages_arr', $populateRatingImages_arr);
				setTemplateFolder('general/','discussions');
				$smartyObj->display('populateSolutionRatingImages.tpl');
			}
	}
?>
