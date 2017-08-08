<?php
//-------------- Class SolutionFormHandler begins --------------->>>>>//
/**
 *
 * @category	###Visual Solutions###
 * @package		###solutions###
 * @author 		shankar_76ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:  $
 * @since 		2008-12-19
 */
class SolutionFormHandler extends DiscussionHandler
	{
		public $board_details = array();
		public $board_attachmentsArray = array();
		public $navigation_details = array();
		public $best_nav = array();
		public $solution_attachment_count = 0;
		public $option_divs = array();
		public $category_titles;
		public $rankUsersRayzz = false;
		public $board_rating;

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function chkIsValidBoard()
		    {
				$this->chkIsNotEmpty('title', $this->LANG['err_tip_compulsory']);

				if (!$this->isValidFormInputs())
					{
						$this->setCommonErrorMsg($this->LANG['err_tip_invalid_board']);
						return false;
					}
				//Query to display recent and popular boards
				$sql = 'SELECT b.board_id, b.discussion_id, b.visible_to, b.total_solutions, b.best_solution_id, b.description, b.total_stars, b.tags, b.total_views'.
						', b.publish_status, b.readonly, b.rating_count,b.rating_total, b.board, TIMEDIFF(NOW(), board_added) as board_added, b.search_word, b.redirect_link'.
						', DATE_FORMAT(board_added, \''.$this->CFG['mysql_format']['date_time_meridian'].'\') as date_posted'.
						', '.$this->getUserTableField('display_name').' as asked_by, u.'.$this->getUserTableField('user_id').' as img_user_id'.
						', u.'.$this->getUserTableField('name').' AS name, b.status, b.user_id, IF(status=\'Active\', 1, 0) is_open'.
						', b.seo_title FROM '.$this->CFG['db']['tbl']['boards'].' AS b, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE b.user_id=u.'.$this->getUserTableField('user_id').' AND b.status IN (\'Active\')'.
						' AND u.'.$this->getUserTableField('user_status').'=\'Ok\' AND b.seo_title='.$this->dbObj->Param('title');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['title']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					{
						$this->setCommonErrorMsg($this->LANG['err_tip_invalid_board']);
						return false;
					}

				$board_details = $rs->FetchRow();
				if($board_details['redirect_link']!='')
					{
						Redirect2URL($board_details['redirect_link']);
					}
				$board_details['board_wrap'] = wordWrapManual($board_details['board'], $this->CFG['admin']['solution']['line_length']);
				//getting user info
				$req_arr = array('t_height', 't_width', 's_height', 's_width','photo_server_url', 'photo_ext', 'img_path', 'gender');
				$user_info_details_arr = getUserInfoDetails($req_arr, 'user_id', $board_details['img_user_id']);

				$this->board_details = array_merge($board_details, $user_info_details_arr);
				$this->getNavDetails($board_details['discussion_id']);
				$this->fields_arr['did'] = $board_details['discussion_id'];
				$this->fields_arr['qid'] = $this->board_details['board_id'];
				$this->fields_arr['bid'] = $this->board_details['board_id'];
				$this->fields_arr['seo_title'] = $this->board_details['seo_title'];
				$this->fields_arr['board_rating_total'] = $this->board_details['rating_total'];
				$this->fields_arr['board_rating_count'] = $this->board_details['rating_count'];
				$this->option_divs[] = 'showhideoptions';
				$this->post_new_link = getUrl('replysolution', '?action=reply&amp;title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'members', $this->CFG['admin']['index']['home_module']);

				$this->board_rating='';
				if(rankUsersRayzz(false, $this->board_details['user_id']))
				{
					$this->rankUsersRayzz=true;
					$this->board_rating = $this->getBoardRating($this->CFG['user']['user_id']);
				}

				return true;
		    }

		public function getNavDetails($discussion_id=0)
			{
				$sql = 'SELECT d.discussion_title, d.pcat_id, d.seo_title, c.cat_name, c.seo_title as cat_seo'.
						' FROM '.$this->CFG['db']['tbl']['discussions'].' AS d'.
						', '.$this->CFG['db']['tbl']['category'].' AS c'.
						' WHERE d.pcat_id=c.cat_id AND d.status=\'Active\' AND c.status=\'Active\''.
						' AND d.discussion_id='.$this->dbObj->Param('did');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($discussion_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					{
						$this->setCommonErrorMsg($this->LANG['err_tip_invalid_discussion']);
						return false;
					}

				$row = $rs->FetchRow();
				$this->board_details['discussion_title'] = $row['seo_title'];
				$this->navigation_details['discussion_index'] = '<a href="'.getUrl('discussions','','','',$this->CFG['admin']['index']['home_module']).'">'.$this->LANG['discussions'].'</a>';
				//$this->navigation_details['category_index'] = '<a href="'.getUrl('discussions','?cat='.$row['cat_seo'], 'dir/'.$row['cat_seo'].'/','',$this->CFG['admin']['index']['home_module']).'">'.stripString($row['cat_name'], $this->CFG['admin']['board']['tiny_length']).'</a>';
				$this->getCategoryTitles($row['pcat_id']);
				if(is_array($this->category_titles)) $this->category_titles = array_reverse($this->category_titles);
				$this->navigation_details['discussion_url'] = '<a href="'.getUrl('boards','?title='.$row['seo_title'], $row['seo_title'].'/','',$this->CFG['admin']['index']['home_module']).'">'.stripString($row['discussion_title']).'</a>';
				$this->navigation_details['board_title'] = stripString($this->board_details['board'], $this->CFG['admin']['board']['tiny_length']);
				$this->navigation_details['navigation_board_title'] = stripString($this->board_details['board']);
				$this->navigation_details['board_title_manual'] = stripString($this->board_details['board'], $this->CFG['admin']['board']['inter_length']);
				$this->navigation_details['post_thread'] = getUrl('replysolution', '?action=reply&amp;title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'members', $this->CFG['admin']['index']['home_module']);
				return true;
			}
		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function getCategoryTitles($cat_id)
			{
				$sql = 'SELECT cat_name, seo_title, parent_id FROM '.$this->CFG['db']['tbl']['category'].
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
						$catqryN = '?cat='.$row['seo_title'];
						$catqryH = 'dir/'.$row['seo_title'].'/';
						$category_info['cat_url'] = '<a href="'.getUrl('discussions', $catqryN, $catqryH, '', $this->CFG['admin']['index']['home_module']).'">'.stripString($row['cat_name']).'</a>';
						$this->category_titles[] = $category_info;
						if($row['parent_id'] > 0)
							$this->getCategoryTitles($row['parent_id']);
					}
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function chkIsValidSolution()
		    {
					$this->chkIsNotEmpty('aid', $this->LANG['err_tip_compulsory']);
					if (!$this->isValidFormInputs())
						{
							$this->setCommonErrorMsg($this->LANG['err_tip_invalid_solution']);
							return false;
						}

				//Query to display recent and popular boards
				$sql = 'SELECT a.board_id, a.visible_to, a.user_id, a.solution, a.rating_total, a.rating_count'.
						' FROM '.$this->CFG['db']['tbl']['solutions'].' AS a'.
						', '.$this->CFG['db']['tbl']['boards'].' AS b, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE a.board_id=b.board_id AND a.user_id=u.'.$this->getUserTableField('user_id').' AND b.status IN (\'Active\')'.
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
				$this->fields_arr['qid'] = $this->solution_details['board_id'];
				$this->fields_arr['solution_rating_total'] = $this->solution_details['rating_total'];
				$this->fields_arr['solution_rating_count'] = $this->solution_details['rating_count'];
				return true;
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function displayBestSolution()
		    {

				if ($this->board_details['best_solution_id'])
					{
						$displayBestSolution_arr = array();
						$req_arr = array('img_path', 't_height', 't_width', 's_height', 's_width', 'photo_server_url', 'photo_ext', 'gender');

						$sql = 'SELECT a.solution_id, a.user_id, a.solution, TIMEDIFF(NOW(), solution_added) as date_solutioned'.
								', u.'.$this->getUserTableField('user_id').' as img_user_id, '.$this->getUserTableFields(array('name'), false).$this->getUserTableField('display_name').' as solutioned_by'.
								' FROM '.$this->CFG['db']['tbl']['solutions'].' AS a'.
								', '.$this->CFG['db']['tbl']['users'].' AS u'.
								' WHERE a.user_id=u.'.$this->getUserTableField('user_id').
								' AND u.'.$this->getUserTableField('user_status').'=\'Ok\''.
								' AND a.board_id='.$this->dbObj->Param('qid').
								' AND a.solution_id='.$this->dbObj->Param('aid').
								' ORDER BY a.solution_id DESC';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['qid'], $this->board_details['best_solution_id']));
						if (!$rs)
						        trigger_db_error($this->dbObj);

						if (!$rs->PO_RecordCount())
							return ;
						$row = $rs->FetchRow();
						$displayBestSolution_arr['best_solution_id'] = $this->board_details['best_solution_id'];

						//getting user info..
						$user_info_details_arr = getUserInfoDetails($req_arr, 'user_id', $row['img_user_id']);
						$displayBestSolution_arr['record'] = array_merge($row, $user_info_details_arr);

						$displayBestSolution_arr['populateCommentList'] = $this->populateCommentList($this->board_details['best_solution_id']);
						//BBCODE PARSING
						$bbcode = new BBCode;
						$parsed_output = $bbcode->Parse($row['solution']);
						$displayBestSolution_arr['row_solution_manual'] = $parsed_output;
						$displayBestSolution_arr['mysolutions']['url'] = getMemberUrl($row['user_id'], $row['name']);
						$displayBestSolution_arr['row_solutioned_by_manual'] = stripString($row['solutioned_by'], $this->CFG['username']['short_length']);

						return $displayBestSolution_arr;
					}
				return false;
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
						' WHERE board_id'.$condition.$this->dbObj->Param('qid').
						' AND discussion_id='.$this->dbObj->Param($this->discussion_details['discussion_id']).
						' AND status=\'Active\''.
						' ORDER BY board_id '.$orderby.' LIMIT 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['qid'], $this->discussion_details['discussion_id']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$showAnotherBoard_val = '<span class="'.$clsActive.'"><a href="'.getUrl('solutions', '?title='.$row['seo_title'], $row['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']).'">'.$caption.'</a></span>';
					}
				else
					{

						$showAnotherBoard_val = '<span class="'.$clsInActive.'">'.$caption.'</span>';
					}

				return $showAnotherBoard_val;
		    }

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function isBoardOpen()
			{
				return ($this->board_details['is_open'])?true:false;
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function displayBoardDetails()
		    {
				//To display open and resolved boards

				if (!$this->board_details)
					return false;

				$displayBoardDetails_arr = array();

				$displayBoardDetails_arr['solution_plural'] = $this->LANG['discuzz_common_total_solution'];
				$displayBoardDetails_arr['views_plural'] = $this->LANG['discuzz_common_total_view'];
				$displayBoardDetails_arr['bestAnsClass'] = '';

				if($this->board_details['total_solutions']!= 1) $displayBoardDetails_arr['solution_plural'] = $this->LANG['solutions'];
				if($this->board_details['total_views']!= 1) $displayBoardDetails_arr['views_plural'] = $this->LANG['discuzz_common_total_views'];
				if($this->board_details['best_solution_id'])	$displayBoardDetails_arr['bestAnsClass'] = 'clsBestSolutionBoard';

				$common_solution_url = getUrl('solutions', '?title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'members', $this->CFG['admin']['index']['home_module']);

				$displayBoardDetails_arr['replySpanQuesIDId'] = 'replySpanQuesID_'.$this->board_details['board_id'];
				$displayBoardDetails_arr['viewSpanQuesId'] = 'viewSpanQuesId'.$this->board_details['board_id'];
				$displayBoardDetails_arr['selReplyQuesId'] = 'selReplyQuesId'.$this->board_details['board_id'];
				$displayBoardDetails_arr['selViewReplyQuesId'] = 'selViewReplyQuesId'.$this->board_details['board_id'];
				$displayBoardDetails_arr['quickSolutionId'] = 'quickSolutionId_'.$this->board_details['board_id'];
				$this->board_details['image_id'] = 'boards';

				$displayBoardDetails_arr['fetchMoreAttachments'] = '';
				if ($this->hasMoreAttachments($this->board_details['board_id']))
					{
						$displayBoardDetails_arr['fetchMoreAttachments'] = $this->fetchMoreAttachments($this->board_details['board_id']);
					}

				$displayBoardDetails_arr['board_manual'] = stripString(wordWrapManual($this->board_details['board'], 45), $this->CFG['admin']['board']['short_length']);
				//BBCODE PARSING
				$bbcode = new BBCode;
				$parsed_output = $bbcode->Parse($this->board_details['description']);

				$displayBoardDetails_arr['description_manual'] = (wordWrapManual($parsed_output, $this->CFG['admin']['description']['line_length']));
				//$displayBoardDetails_arr['description_manual'] = $parsed_output;

	          	$displayBoardDetails_arr['anchor'] = 'resolve';

				$displayBoardDetails_arr['mysolutions']['url'] = getMemberUrl($this->board_details['user_id'], $this->board_details['name']);
				$displayBoardDetails_arr['asked_by_manual'] = stripString($this->board_details['asked_by'], $this->CFG['username']['short_length']);
				$displayBoardDetails_arr['member_image'] = getMemberAvatarDetails($this->board_details['user_id']);

				$displayBoardDetails_arr['solution']['url'] = getUrl('solutions', '?action=view&itle='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']);

				$displayBoardDetails_arr['email_solutions']['url'] = getUrl('emailsolutions', '?ajaxpage=true&page=shareboards&title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/?ajaxpage=true&page=shareboards', '', $this->CFG['admin']['index']['home_module']);

				$displayBoardDetails_arr['solution_member']['url'] = getUrl('solutions', '?title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'members', $this->CFG['admin']['index']['home_module']);

				$displayBoardDetails_arr['favorite_solutions']['url'] = getUrl('favoritesolutions','','','',$this->CFG['admin']['index']['home_module']);

				$displayBoardDetails_arr['login_solution_member']['url'] = getUrl('login', '?light_url='.$displayBoardDetails_arr['solution_member']['url'], '?light_url='.$displayBoardDetails_arr['solution_member']['url']);

				$displayBoardDetails_arr['boards_member']['url'] = getUrl('boards', '?view=ask&amp;cid='.$this->fields_arr['qid'].'&amp;title='.$this->board_details['discussion_title'], 'ask/'.$this->fields_arr['qid'].'/?title='.$this->board_details['discussion_title'], 'members', $this->CFG['admin']['index']['home_module']);

				$displayBoardDetails_arr['boardBadgeUrl'] = getBoardBadgeUrl($this->fields_arr['qid']);

				if ($displayBoardDetails_arr['boardBadgeUrl'])
					{
						$displayBoardDetails_arr['badgeUrlWithoutScript'] = getBoardBadgeUrl($this->fields_arr['qid'], false);
						$displayBoardDetails_arr['badgeUrlWithoutScript'] .= ($this->CFG['feature']['rewrite_mode']== 'htaccess')?('?content=2'):('&amp;content=2');
						$displayBoardDetails_arr['solutions_badge_embed_hint'] = str_ireplace('VAR_SITENAME', $this->CFG['site']['name'], $this->LANG['solutions_badge_embed_hint']);
					}

				if ($this->CFG['admin']['board']['ratings'])
					{
						$displayBoardDetails_arr['board_url'] = getUrl('solutions', '?title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']);

						$displayBoardDetails_arr['getBoardRatings'] = $this->getBoardRatings($this->CFG['db']['tbl']['users_stared_board'],
																								$this->fields_arr['qid'],
																								$this->board_details['user_id'],
																								$this->CFG['site']['project_path_relative'],
																								$this->CFG['site']['relative_url'],
																								$displayBoardDetails_arr['board_url']);
					}

				$userDisplay_arr = $this->userDisplayDetails($this->board_details['user_id']);
				$displayBoardDetails_arr['user_doj'] = date('d-M-Y', strtotime( $userDisplay_arr['doj']));
				$displayBoardDetails_arr['total_posts'] = $userDisplay_arr['total_solution'];
				$displayBoardDetails_arr['onclick_action'] = '';
				if ($this->CFG['user']['user_id'])
					$displayBoardDetails_arr['onclick_action'] = 'onClick="Effect.toggle(\'subAnsPostForm\', \'BLIND\'); return false;"';
				$solution_reply_url = getUrl('replysolution', '?action=reply&amp;title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'members', $this->CFG['admin']['index']['home_module']);
				$displayBoardDetails_arr['solution_reply']['url'] = $solution_reply_url;
				$displayBoardDetails_arr['login_solution_reply']['url'] = getUrl('login', '?light_url='.$common_solution_url, '?light_url='.$common_solution_url, 'root');
				if ($this->board_details['total_solutions'])
					{
						$displayBoardDetails_arr['submit_solution_text'] = $this->LANG['solutions_this_board'];

					}
				else
					{
						$displayBoardDetails_arr['submit_solution_text'] = $this->LANG['be_the_first_one'];
					}

				return $displayBoardDetails_arr;
		    }

		public function postSolutionsForm($for)
			{
				global $smartyObj;

				$postSolutionsForm_arr = array();
				$postSolutionsForm_arr['for'] = $for;

				if($this->CFG['admin']['solutions']['point_notification'] && $this->CFG['admin']['reply_solutions']['allowed'] && !$this->fields_arr['aid'])
					{
						$postSolutionsForm_arr['earn_points_details_info'] = str_ireplace('VAR_POINTS', $this->CFG['admin']['reply_solutions']['points'], $this->LANG['earn_points_details_info']);
					}

				$postSolutionsForm_arr['form_action'] = getUrl('replysolution', '?action=reply&amp;title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'members', $this->CFG['admin']['index']['home_module']);

			    $postSolutionsForm_arr['hidden_arr'] = array('rid');

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

		      	if($this->fields_arr['action'] == 'edit')
					$postSolutionsForm_arr['solution_caption'] = $this->LANG['solutions_edit_your_solution2'];
				else
					$postSolutionsForm_arr['solution_caption'] = $this->LANG['solutions_postnew'];

				$smartyObj->assign('postSolutionsForm_arr', $postSolutionsForm_arr);
				setTemplateFolder('members/', $this->CFG['admin']['index']['home_module']);
				$smartyObj->display('postSolutionsForm.tpl');

			}
		/**
		*  showReplies()
		*
		*/
		public function showReplies()
			{
				global $smartyObj;

				$showReplies_arr = array();
				// board details
				$showReplies_arr['displayBoardDetails_arr'] = $this->displayBoardDetails();
				// solution details - replies
				$this->setTableNames(array($this->CFG['db']['tbl']['solutions'].' as a', $this->CFG['db']['tbl']['users'].' as u'));
				$this->setReturnColumns(array('a.solution_id', 'a.user_id', 'a.rating_total', 'a.rating_count','a.solution', 'a.status', 'DATE_FORMAT(solution_added, \''.$this->CFG['mysql_format']['date_time_meridian'].'\') as date_replied', 'TIMEDIFF(NOW(), solution_added) as date_solutioned', 'u.'.$this->getUserTableField('user_id').' as img_user_id', 'u.'.$this->getUserTableField('name').' AS name', $this->getUserTableField('display_name').' as solutioned_by'));
				$this->setFormField('orderby_field', 'a.solution_id');

				$order_col = 'DESC';
				if($this->CFG['admin']['solution']['order'] != 'DESC')
					$order_col = 'ASC';

				$this->setFormField('orderby', $order_col);
				$this->buildSelectQuery();
				$this->buildConditionQuery();
				$this->buildSortQuery();
				$this->buildQuery();
				//$solutions->printQuery();
				$this->executeQuery();
				$showReplies_arr['displayAllSolutions_arr'] = $this->displayAllSolutions();
				if($this->CFG['feature']['rewrite_mode'] == 'htaccess')
					$pagingArr = array();
				else
					$pagingArr = array('title');
				$pagingArr[] = 'action';
				$smartyObj->assign('smarty_paging_list', $this->populatePageLinksGET($this->getFormField('start'), $pagingArr));

				$smartyObj->assign('showReplies_arr', $showReplies_arr);
				setTemplateFolder('members/', $this->CFG['admin']['index']['home_module']);
				$smartyObj->display('showReplies.tpl');

			}

		/**
		 * set the condition
		 *
		 * @access public
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'a.user_id=u.'.$this->getUserTableField('user_id').' AND u.'.$this->getUserTableField('user_status').'=\'Ok\'';
				$this->sql_condition .= ' AND a.board_id=\''.addslashes($this->fields_arr['qid']).'\'';

				if($this->board_details['user_id'] != $this->CFG['user']['user_id'])
						$this->sql_condition .= ' AND a.status=\'Active\'';
			}

		/**
		 * To sort the query
		 *
		 * @access public
		 * @return void
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function displayAllSolutions()
			{
				$this->writeLogTable($this->CFG['user']['user_id'], $this->CFG['remote_client']['ip'], $this->board_details['board_id']);
				//Query to display recent and popular boards
				if (!$this->isResultsFound())
					{
						return ;
					}
				$displayAllSolutions_arr = array();
				$req_arr = array('img_path', 't_height', 't_width', 's_height', 's_width', 'photo_server_url', 'photo_ext', 'gender');
				$id_cnt = $this->fields_arr['start'];
				$i = 0;
				$inc=1;

				while($row = $this->fetchResultRecord())
					{
						$i++;
						//getting user info..
						$this->option_divs[] = 'showhideoptions_'.$row['solution_id'];
						$user_info_details_arr = getUserInfoDetails($req_arr, 'user_id', $row['user_id']);
						$displayAllSolutions_arr[$inc]['record'] = array_merge($row, $user_info_details_arr);

						$userDisplay_arr = $this->userDisplayDetails($row['user_id']);
						$displayAllSolutions_arr[$inc]['user_doj'] = date('d-M-Y', strtotime( $userDisplay_arr['doj']));
						$displayAllSolutions_arr[$inc]['total_posts'] = $userDisplay_arr['total_solution'];

						$displayAllSolutions_arr[$inc]['clsOddOrEvenBoard'] = 'clsEvenBoard';
						if ($i%2)
							$displayAllSolutions_arr[$inc]['clsOddOrEvenBoard'] = 'clsOddBoard';

						$displayAllSolutions_arr[$inc]['row_class'] = 'clsViewSolution';
						$displayAllSolutions_arr[$inc]['clsBestSolutionBadge'] = '';
						$is_best = 0;
						if ($this->board_details['best_solution_id'] == $row['solution_id'])
							{
								$is_best = 1;
								$displayAllSolutions_arr[$inc]['row_class'] = 'clsAcceptedSolution';
								$displayAllSolutions_arr[$inc]['clsBestSolutionBadge'] = ' clsBestSolutionBadge';
							}

						$displayAllSolutions_arr[$inc]['anchor'] = 'abuseSolution'.$row['solution_id'];
						$displayAllSolutions_arr[$inc]['ansId'] = $row['solution_id'];
						$displayAllSolutions_arr[$inc]['populateCommentList'] = $this->populateCommentList($row['solution_id']);
						//BBCODE PARSING
						$bbcode = new BBCode;
						$parsed_output = $bbcode->Parse($row['solution']);
						$displayAllSolutions_arr[$inc]['row_solution_manual'] = (wordWrapManual($parsed_output, $this->CFG['admin']['solution']['line_length']));

						$displayAllSolutions_arr[$inc]['mysolutions']['url'] = getMemberUrl($row['user_id'], $row['name']);
						$displayAllSolutions_arr[$inc]['member_image'] = getMemberAvatarDetails($row['user_id']);
						$displayAllSolutions_arr[$inc]['row_solutioned_by_manual'] = stripString($row['solutioned_by'], $this->CFG['username']['short_length']);

						$displayAllSolutions_arr[$inc]['solution']['url'] = getUrl('solutions', '?action=view&amp;title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']);
	          			if ($this->CFG['admin']['abuse_solutions']['allowed'] AND $this->CFG['user']['user_id'] != $row['user_id'] AND $this->isBoardOpen())
						  	{
		          				if (!$this->CFG['user']['user_id'])
								  	{
								  		$displayAllSolutions_arr[$inc]['solution_members']['url'] = getUrl('solutions', '?action=view&amp;title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'members', $this->CFG['admin']['index']['home_module']);
		          					}
							}
      					if ($row['user_id'] == $this->CFG['user']['user_id'])
						  	{
      							if ($this->CFG['admin']['solution']['edit'])
								  	{
	        							$displayAllSolutions_arr[$inc]['solution_edit']['url'] = getUrl('editsolution', '?action=edit&amp;title='.$this->board_details['seo_title'].'&amp;aid='.$row['solution_id'], $this->board_details['seo_title'].'/?aid='.$row['solution_id'], 'members', $this->CFG['admin']['index']['home_module']);
    								}
    							if ($this->CFG['admin']['solution']['delete'])
									{
    									$displayAllSolutions_arr[$inc]['solution_delete']['url'] = getUrl('solutions', '?title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']);
    								}
    						}

						$displayAllSolutions_arr[$inc]['fetchMoreAttachments'] = '';
						if ($this->hasMoreAttachments($row['solution_id'], 'Solution'))
							{
								$displayAllSolutions_arr[$inc]['fetchMoreAttachments'] = $this->fetchMoreAttachments($row['solution_id']);
							}

						$displayAllSolutions_arr[$inc]['id_cnt'] = $id_cnt;

			    		if ($this->CFG['admin']['solution']['ratings'])
							{

								$displayAllSolutions_arr[$inc]['board_url'] = getUrl('solutions', '?title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'members', $this->CFG['admin']['index']['home_module']);
								$displayAllSolutions_arr[$inc]['getSolutionsRatings'] = $this->getSolutionsRatings($this->CFG['db']['tbl']['users_stared_solution'],
																									$this->CFG['db']['tbl']['solutions'],
																									$row['solution_id'], $row['user_id'],
																									$this->CFG['site']['project_path_relative'],
																									$this->CFG['site']['relative_url'], $id_cnt,
																									$displayAllSolutions_arr[$inc]['board_url'],$is_best);
								$id_cnt += 4;
			    			}
						$displayAllSolutions_arr[$inc]['commentSpanIDId'] = 'commentSpanID_'.$row['solution_id'];

						$showOptions = false;
						if($this->CFG['admin']['abuse_solutions']['allowed'] && $this->CFG['user']['user_id']!=$row['user_id'])
							$showOptions = true;
						else if($this->CFG['user']['user_id'] == $row['user_id'] && ($this->CFG['admin']['solution']['edit'] || $this->CFG['admin']['solution']['delete']))
							$showOptions = true;
						else if($this->board_details['user_id'] == $this->CFG['user']['user_id'] && $row['status'] == 'ToActivate')
							$showOptions = true;
						$displayAllSolutions_arr[$inc]['showOptions'] = $showOptions;

						$displayAllSolutions_arr[$inc]['rating'] = '';
						$displayAllSolutions_arr[$inc]['rankUsersRayzz'] = false;
						$displayAllSolutions_arr[$inc]['solution_rating_count'] = $row['rating_count'];
						if(rankUsersRayzz(false, $row['user_id'] ))
						{
							$displayAllSolutions_arr[$inc]['rankUsersRayzz'] = true;
							$displayAllSolutions_arr[$inc]['rating'] = $this->getSolutionRating($this->CFG['user']['user_id'],$row['solution_id']);
						}

						$inc++;
					} // while


				return $displayAllSolutions_arr;
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function updateAbuseBoard()
		    {
				$sql = 'SELECT abuse_id FROM '.$this->CFG['db']['tbl']['abuse_boards'].
						' WHERE board_id='.$this->dbObj->Param('qid').
						' AND reported_by='.$this->dbObj->Param('rid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['qid'],
														 $this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['abuse_boards'].
								' SET board_id='.$this->dbObj->Param('qid').
								', reported_by='.$this->dbObj->Param('rid').
								', reason='.$this->dbObj->Param('reason').
								', date_abused=NOW()';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['qid'],
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
		 *
		 * @access public
		 * @return void
		 **/
		public function updateBoardAbuseCount()
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].' SET abuse_count=abuse_count+1'.
						' WHERE board_id='.$this->dbObj->Param('qid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['qid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function updateAbuseSolution()
		    {
				$sql = 'SELECT abuse_id FROM '.$this->CFG['db']['tbl']['abuse_solutions'].
						' WHERE solution_id='.$this->dbObj->Param('aid').
						' AND reported_by='.$this->dbObj->Param('uid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid'],
														 $this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['abuse_solutions'].
								' SET board_id='.$this->dbObj->Param('qid').
								', solution_id='.$this->dbObj->Param('aid').
								', reported_by='.$this->dbObj->Param('uid').
								', reason='.$this->dbObj->Param('reason').
								', date_abused=NOW()';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['qid'],
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
		 *
		 * @access public
		 * @return void
		 **/
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
		 *
		 * @access public
		 * @return void
		 **/
		public function updateAbuseUserPoints($config_abuse, $uid, $points)
		    {
				if (!$config_abuse or $points == 0 or !isset($this->CFG['user']['user_id']) or empty($this->CFG['user']['user_id']))
					return ;
				//update users_board_log table
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
						' SET total_points=total_points+'.$this->dbObj->Param($points).
						', date_updated=NOW()'.
						' WHERE user_id='.$this->dbObj->Param('uid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($points, $uid));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				return ;
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function updateBestSolution()
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].' SET best_solution_id='.$this->dbObj->Param('aid').
						' WHERE board_id='.$this->dbObj->Param('qid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid'], $this->fields_arr['qid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($this->dbObj->Affected_Rows())
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
									$this->discussionsActivityObj->addActivity($activity_arr);
								}
					}
		    }
		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function removeBestSolution()
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].' SET best_solution_id=0'.
						' WHERE board_id='.$this->dbObj->Param('qid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['qid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($this->dbObj->Affected_Rows())
					{
						$this->sendMailToRemovedBestSolutioner($this->fields_arr['aid']);
						if ($this->chkIsValidSolution($this->fields_arr['aid']))
							$this->decreaseBestSolutionPoints($this->solution_details['user_id']);
						//Add Activity
						if($this->CFG['admin']['index']['activity']['show'])
							{
								$activity_arr['action_key'] = 'remove_bestsolution';
								$activity_arr['owner_id'] = $this->solution_details['user_id'];
								$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
								$activity_arr['solution_id'] = $this->fields_arr['aid'];
								$this->discussionsActivityObj->addActivity($activity_arr);
							}
					}
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
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

						// To increase the total solution count for that solutioner
						$usr_sql = 'SELECT a.solution_id, a.user_id, a.solution, a.board_id, '.$this->getUserTableFields(array('email', 'display_name'), false).
								' ,a.status FROM '.$this->CFG['db']['tbl']['solutions'].' AS a, '.$this->CFG['db']['tbl']['users'].' AS u'.
								' WHERE a.user_id=u.'.$this->getUserTableField('user_id').
								' AND u.'.$this->getUserTableField('user_status').'=\'Ok\''.
								' AND a.board_id='.$this->dbObj->Param('qid').
								' AND a.solution_id='.$this->dbObj->Param('aid').
								' ORDER BY a.solution_id DESC';

						$usr_stmt = $this->dbObj->Prepare($usr_sql);
						$usr_rs = $this->dbObj->Execute($usr_stmt, array($this->fields_arr['qid'], $this->fields_arr['aid']));
						if (!$usr_rs)
						        trigger_db_error($this->dbObj);

						$row = $usr_rs->FetchRow();

						$update_sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
										' SET total_solution=total_solution+1';
						if($this->CFG['admin']['reply_solutions']['allowed'])
							$update_sql .=	', total_points=total_points+'.$this->CFG['admin']['reply_solutions']['points'];
						$update_sql .=	', date_updated=NOW()'.
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
								$activity_arr['owner_id'] = $this->CFG['user']['user_id'];
								$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
								$activity_arr['solution_id'] = $this->fields_arr['aid'];
								$this->discussionsActivityObj->addActivity($activity_arr);
							}
					}
		    	}

		public function sendPublishedMailAlert($toEmail, $reciever_name, $content_description)
			{
				$site_link = "<a target=\"_blank\" href=\"".URL($this->CFG['site']['url'])."\">".URL($this->CFG['site']['url'])."</a>";
				$url_link = getUrl('solutions', '?title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'root', $this->CFG['admin']['index']['home_module']);
				$quesiton_link = "<a target=\"_blank\" href=\"".$url_link."\"><strong>".$this->board_details['board']."</strong></a>";
				$subject = $this->getMailContent($this->LANG['solution_publish_subject'], array('VAR_USERNAME'=>$reciever_name, 'VAR_SITENAME'=>$this->CFG['site']['name'], 'VAR_DESCRIPTION_OF_QUESTION'=>$content_description, 'VAR_BOARD'=>$quesiton_link, 'VAR_LINK'=>$site_link));
				$content = $this->getMailContent($this->LANG['solution_publish_message'], array('VAR_USERNAME'=>$reciever_name, 'VAR_SITENAME'=>$this->CFG['site']['name'], 'VAR_DESCRIPTION_OF_QUESTION'=>$content_description, 'VAR_BOARD'=>$quesiton_link, 'VAR_LINK'=>$site_link));

				$this->_sendMail($toEmail,
								$subject,
								$content,
								$this->CFG['site']['noreply_name'],
								$this->CFG['site']['noreply_email']);
			}
		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function deleteBoard()
			{
				$this->deleteBoardsComment();

				//Delete board
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['boards'].
						' WHERE board_id='.$this->dbObj->Param('qid').
						' AND user_id='.$this->dbObj->Param('uid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['qid'], $this->CFG['user']['user_id']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				//Decrement the total_solution count and points for users who posted solution against this board and attachment delete
				$this->decreasePostersAnsCount($this->fields_arr['qid']);
				//Delete solutions
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['solutions'].
						' WHERE board_id='.$this->dbObj->Param('qid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['qid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				//Decrement total_board,points from users_board_log
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
						' SET total_board=total_board-1';
					if($this->CFG['admin']['ask_solutions']['allowed'])
						$sql .= ', total_points=total_points-'.$this->CFG['admin']['ask_solutions']['points'];
				$sql .=	' WHERE user_id='.$this->dbObj->Param('uid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				//Delete Attachments for board
				$this->fetchAndDeleteAttachments('Board', $this->fields_arr['qid']);
				//Decrement tag_count
				$this->updateDeletedBoardsTagCount($this->board_details['tags']);
				//Add Activity
				if($this->CFG['admin']['index']['activity']['show'])
					{
						$activity_arr['action_key'] = 'board_deleted';
						$activity_arr['owner_id'] = $this->CFG['user']['user_id'];
						$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
						$activity_arr['board_id'] = $this->fields_arr['qid'];

						$user_details = $this->getUserDetails($this->CFG['user']['user_id']);
						$activity_arr['display_name'] = $user_details['display_name'];
						$this->discussionsActivityObj->addActivity($activity_arr);
					}
			}

		public function fetchAndDeleteAttachments($type, $content_id)
		     {
                $sql = 'SELECT attachment_id, attachment_name FROM '.$this->CFG['db']['tbl']['attachments'].
	                      ' WHERE content_id = '.$this->dbObj->Param('content_id').
	                      ' AND content_type = '.$this->dbObj->Param('type');
                $stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($content_id, $type));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				if ($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow()){
                           	$extern = strtolower(substr($row['attachment_name'], strrpos($row['attachment_name'], '.')+1));
							$attach_name = getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['large_name'].'.'.$extern;
                           	$this->deleteMoreAttachments($row['attachment_id'], $attach_name);
						} // while
					}

		     }

		public function decreasePostersAnsCount($board_id)
			{
				$sql = 'SELECT solution_id, user_id FROM '.$this->CFG['db']['tbl']['solutions'].
						' WHERE board_id='.$this->dbObj->Param('qid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($board_id));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				if ($tot_sols=$rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow()){

							$update_cond = '';
							if($row['solution_id']==$this->board_details['best_solution_id'])
								$update_cond = ', total_best_solution=total_best_solution-1';

							$ans_sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
									' SET total_solution=total_solution-1'.$update_cond.
									' WHERE user_id='.$this->dbObj->Param('uid');
							$ans_stmt = $this->dbObj->Prepare($ans_sql);
							$ans_rs = $this->dbObj->Execute($ans_stmt, array($row['user_id']));
							if (!$ans_rs)
								    trigger_db_error($this->dbObj);

							//Delete Attachment for each solution while deleting a board
                            $this->fetchAndDeleteAttachments('Solution', $row['solution_id']);

						} // while
					}

				//to_do#decrease total_board,total_solution count in discussion table..

					$dis_sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].
								' SET total_solutions=total_solutions-'.$this->dbObj->Param($tot_sols).
								', total_boards=total_boards-1'.
								' WHERE discussion_id='.$this->dbObj->Param('did');

					$dis_stmt = $this->dbObj->Prepare($dis_sql);
					$dis_rs = $this->dbObj->Execute($dis_stmt, array($tot_sols, $this->fields_arr['did']));
					if (!$dis_rs)
					    trigger_db_error($this->dbObj);

				//to_do#decrease total_board,total_solution count in category table..

					$cat_sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
								' SET total_solutions=total_solutions-'.$this->dbObj->Param($tot_sols).
								', total_boards=total_boards-1'.
								' WHERE cat_id='.$this->dbObj->Param($this->discussion_details['pcat_id']);

					$cat_stmt = $this->dbObj->Prepare($cat_sql);
					$cat_rs = $this->dbObj->Execute($cat_stmt, array($tot_sols, $this->discussion_details['pcat_id']));
					if (!$cat_rs)
					    trigger_db_error($this->dbObj);
					$this->updateParentCategories($this->discussion_details['pcat_id'], '-', $tot_sols);
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
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
		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function updateSolution()
			{
				$solution_text = $this->fields_arr['solution'];
		    	$search_title = $this->filterWordsForSearching($solution_text);
				$search_title = implode(" ", $search_title);
				$search_title = ' '.$search_title.' ';

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['solutions'].
						' SET solution='.$this->dbObj->Param('solution').
						', search_word='.$this->dbObj->Param('search_word').
						', visible_to='.$this->dbObj->Param('visible_to').
						' WHERE user_id='.$this->dbObj->Param('uid').
						' AND board_id='.$this->dbObj->Param('qid').
						' AND solution_id='.$this->dbObj->Param('aid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['solution'],
														 $search_title,
														 $this->fields_arr['visible_to'],
														 $this->CFG['user']['user_id'],
														 $this->fields_arr['qid'],
														 $this->fields_arr['aid']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$this->fields_arr['content_id'] = $this->fields_arr['aid'];
				$this->addAttachments();

				//Add Activity
				if($this->CFG['admin']['index']['activity']['show'])
					{
						$activity_arr['action_key'] = 'solution_edited';
						$activity_arr['owner_id'] = $this->board_details['user_id'];
						$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
						$activity_arr['solution_id'] = $this->fields_arr['aid'];
						$this->discussionsActivityObj->addActivity($activity_arr);
					}
				return ;
			}

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function addSolution()
		    {
				if ($this->isBoardOpen())
					{
						$this->fields_arr['content_id'] = $this->insertSolution();
						if($this->board_details['publish_status']=='Yes')
							{
								$this->updateBoard();
								$this->updateUserSolutionLog();
							}
						$this->addAttachments();
						$this->sendMailToAsker();
					}
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function insertSolution()
		    {
		    	$solution_text = $this->fields_arr['solution'];
		    	$search_title = $this->filterWordsForSearching($solution_text);
				$search_title = implode(" ", $search_title);
				$search_title = ' '.$search_title.' ';
				$log_activity = false;

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['solutions'].
						' SET user_id='.$this->dbObj->Param('uid').
						', board_id='.$this->dbObj->Param('qid').
						', solution='.$this->dbObj->Param('solution').
						', search_word='.$this->dbObj->Param('search_word').
						', visible_to='.$this->dbObj->Param('visible_to').
						', solution_added=NOW()';


				if($this->board_details['publish_status'] == 'No')
					{
						$sql.=	', status=\'ToActivate\'';
					}
				else
					{
						if($this->CFG['admin']['index']['activity']['show'])
							$log_activity = true;
					}

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'],
														 $this->fields_arr['qid'],
														 $this->fields_arr['solution'],
														 $search_title,
														 $this->fields_arr['visible_to']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				$solution_inserted_id = $this->dbObj->Insert_ID();

				//Add Activity
				if($log_activity)
					{
						$activity_arr['action_key'] = 'new_solution';
						$activity_arr['owner_id'] = $this->board_details['user_id'];
						$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
						$activity_arr['solution_id'] = $solution_inserted_id;
						$this->discussionsActivityObj->addActivity($activity_arr);
					}

				return $solution_inserted_id;
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function updateBoard()
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].
						' SET total_solutions=total_solutions+1'.
						' WHERE discussion_id='.$this->dbObj->Param('did');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['did']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].
						' SET total_solutions=total_solutions+1'.
						', email_sent=\'No\', solution_added=NOW()'.
						', last_post_by='.$this->dbObj->Param('uid').
						' WHERE board_id='.$this->dbObj->Param('qid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['qid']));
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
		 * @access public
		 * @return void
		 **/
		public function updateUserSolutionLog()
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
						' SET total_solution=total_solution+1';
				$params_arr = array();
				if($this->CFG['admin']['reply_solutions']['allowed']){
					$sql .= ', total_points=total_points+'.$this->dbObj->Param($this->CFG['admin']['reply_solutions']['points']);
					$params_arr[] = $this->CFG['admin']['reply_solutions']['points'];
				}
				$sql .= ', date_updated=NOW()'.
						' WHERE user_id='.$this->dbObj->Param('uid');
				$params_arr[] = $this->CFG['user']['user_id'];
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $params_arr);
				if (!$rs)
				        trigger_db_error($this->dbObj);
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
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

						$solutions_reply_content = str_ireplace('VAR_USERNAME', '<a href="'.getMemberUrl($this->board_details['user_id'], $this->board_details['name'], 'root').'">'.$asker_details['display_name'].'</a>', $this->LANG['solutions_reply_email_content']);
						$sender_name = '<a href="'.getMemberUrl($this->CFG['user']['user_id'], $this->CFG['user']['name'], 'root').'">'.$this->CFG['user']['display_name'].'</a>';
						$solutions_reply_content = str_ireplace('VAR_SENDER_NAME', $sender_name, $solutions_reply_content);
						$solutions_reply_content = str_ireplace('VAR_SITENAME', $this->CFG['site']['name'], $solutions_reply_content);
						$solutions_reply_content = str_ireplace('VAR_BOARD_POSTED', '<strong>'.$this->board_details['board'].'</strong>', $solutions_reply_content);
						$solutions_reply_content = str_ireplace('VAR_BOARD_REPLY', nl2br($this->fields_arr['solution']), $solutions_reply_content);
						$board_link = getUrl('solutions', '?title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'root', $this->CFG['admin']['index']['home_module']);
						$solutions_reply_content = str_ireplace('VAR_LINK', '<a href="'.$board_link.'">'.$board_link.'</a>', $solutions_reply_content);

						$this->_sendMail($asker_details['email'],
										 $solutions_reply_subject,
										 $solutions_reply_content,
										 $this->CFG['site']['noreply_name'],
										 $this->CFG['site']['noreply_email']);
					}
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function sendMailToSolutioner()
		    {
				if ($this->board_details['user_id'] != $this->CFG['user']['user_id'])
						return ;

				$solution_details = $this->getSolutionDetails($this->fields_arr['aid']);
				$email_options = $this->getEmailOptionsOfUser($solution_details['user_id']);

				if ($email_options['best_solution_mail'] == 'Yes')
					{
						$solutioner_details = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $solution_details['user_id']);
						$best_solutions_subject = str_ireplace('VAR_USERNAME', $solutioner_details['display_name'], $this->LANG['best_solution_email_subject']);

						$best_solutions_content = str_ireplace('VAR_USERNAME', '<a href="'.getMemberUrl($solutioner_details['user_id'], $solutioner_details['name'], 'root').'">'.$solutioner_details['display_name'].'</a>', $this->LANG['best_solution_email_content']);
						$sender_name = '<a href="'.getMemberUrl($this->CFG['user']['user_id'], $this->CFG['user']['name'], 'root').'">'.$this->CFG['user']['display_name'].'</a>';
						$best_solutions_content = str_ireplace('VAR_SENDER_NAME', $sender_name, $best_solutions_content);
						$best_solutions_content = str_ireplace('VAR_SITENAME', $this->CFG['site']['name'], $best_solutions_content);
						$best_solutions_content = str_ireplace('VAR_BOARD_POSTED', '<strong>'.$this->board_details['board'].'</strong>', $best_solutions_content);
						$best_solutions_content = str_ireplace('VAR_BOARD_REPLY', nl2br($solution_details['solution']), $best_solutions_content);
						$board_link = getUrl('solutions', '?title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'root', $this->CFG['admin']['index']['home_module']);
						$best_solutions_content = str_ireplace('VAR_LINK', '<a href="'.$board_link.'">'.$board_link.'</a>', $best_solutions_content);

						$this->_sendMail($solutioner_details['email'],
										 $best_solutions_subject,
										 $best_solutions_content,
										 $this->CFG['site']['noreply_name'],
										 $this->CFG['site']['noreply_email']);
					}
		    }
		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function sendMailToRemovedBestSolutioner($solution_id)
		    {
				if ($this->board_details['user_id'] != $this->CFG['user']['user_id'])
						return ;

					$solution_details = $this->getSolutionDetails($solution_id);

					$solutioner_details = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $solution_details['user_id']);

					$remove_best_solutions_subject = str_ireplace('VAR_USERNAME', $solutioner_details['display_name'], $this->LANG['remove_best_solution_email_subject']);
					$remove_best_solutions_content = str_ireplace('VAR_USERNAME', '<a href="'.getMemberUrl($solutioner_details['user_id'], $solutioner_details['name'], 'root').'">'.$solutioner_details['display_name'].'</a>', $this->LANG['remove_best_solution_email_content']);
					$sender_name = '<a href="'.getMemberUrl($this->CFG['user']['user_id'], $this->CFG['user']['name'], 'root').'">'.$this->CFG['user']['display_name'].'</a>';
					$remove_best_solutions_content = str_ireplace('VAR_SENDER_NAME', $sender_name, $remove_best_solutions_content);
					$remove_best_solutions_content = str_ireplace('VAR_SITENAME', $this->CFG['site']['name'], $remove_best_solutions_content);
					$remove_best_solutions_content = str_ireplace('VAR_BOARD_POSTED', '<strong>'.$this->board_details['board'].'</strong>', $remove_best_solutions_content);
					$remove_best_solutions_content = str_ireplace('VAR_BOARD_REPLY', nl2br($solution_details['solution']), $remove_best_solutions_content);
					$board_link = getUrl('solutions', '?title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'root', $this->CFG['admin']['index']['home_module']);
					$remove_best_solutions_content = str_ireplace('VAR_LINK', '<a href="'.$board_link.'">'.$board_link.'</a>', $remove_best_solutions_content);

					$this->_sendMail($solutioner_details['email'],
									 $remove_best_solutions_subject,
									 $remove_best_solutions_content,
									 $this->CFG['site']['noreply_name'],
									 $this->CFG['site']['noreply_email']);
		    }
		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function getSolutionDetails($aid)
		    {
				$sql = 'SELECT user_id, solution FROM '.$this->CFG['db']['tbl']['solutions'].' WHERE solution_id='.$this->dbObj->Param('aid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($aid));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				return $row;
		    }

		/**
		 *
		 * @access public
		 * @return void
		 **/
		public function sendAbuseMailToAsker()
		    {
				$email_options = $this->getEmailOptionsOfUser($this->board_details['user_id']);
				if ($email_options['abuse_mail'] == 'Yes')
					{
						$asker_details = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $this->board_details['user_id']);
						$abuse_board_subject = str_ireplace('VAR_USERNAME', $asker_details['display_name'], $this->LANG['abuse_board_email_subject']);

						$abuse_board_content = str_ireplace('VAR_USERNAME', '<a href="'.getMemberUrl($this->board_details['user_id'], $this->board_details['name'], 'root').'">'.$asker_details['display_name'].'</a>', $this->LANG['abuse_board_email_content']);
						$sender_name = '<a href="'.getMemberUrl($this->CFG['user']['user_id'], $this->CFG['user']['name'], 'root').'">'.$this->CFG['user']['display_name'].'</a>';
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
		 *
		 * @access public
		 * @return void
		 **/
		public function sendAbuseMailToSolutioner()
		    {
				$email_options = $this->getEmailOptionsOfUser($this->solution_details['user_id']);
				if ($email_options['abuse_mail'] == 'Yes')
					{
						$solutioner_details = $this->getUserDetailsFromUsersTable($this->CFG['db']['tbl']['users'], $this->solution_details['user_id']);
						$abuse_solutions_subject = str_ireplace('VAR_USERNAME', $solutioner_details['display_name'], $this->LANG['abuse_solution_email_subject']);

						$abuse_solutions_content = str_ireplace('VAR_USERNAME', '<a href="'.getMemberUrl($this->solution_details['user_id'], $solutioner_details['name'], 'root').'">'.$solutioner_details['display_name'].'</a>', $this->LANG['abuse_solution_email_content']);
						$sender_name = '<a href="'.getMemberUrl($this->CFG['user']['user_id'], $this->CFG['user']['name'], 'root').'">'.$this->CFG['user']['display_name'].'</a>';
						$abuse_solutions_content = str_ireplace('VAR_SENDER_NAME', $sender_name, $abuse_solutions_content);
						$abuse_solutions_content = str_ireplace('VAR_SITENAME', $this->CFG['site']['name'], $abuse_solutions_content);
						$abuse_solutions_content = str_ireplace('VAR_BOARD_POSTED', '<strong>'.$this->board_details['board'].'</strong>', $abuse_solutions_content);
						$abuse_solutions_content = str_ireplace('VAR_BOARD_REPLY', nl2br($this->solution_details['solution']), $abuse_solutions_content);
						$board_link = getUrl('solutions', '?title='.$this->board_details['seo_title'], $this->board_details['seo_title'].'/', 'root', $this->CFG['admin']['index']['home_module']);
						$abuse_solutions_content = str_ireplace('VAR_LINK', '<a href="'.$board_link.'">'.$board_link.'</a>', $abuse_solutions_content);

						$this->_sendMail($solutioner_details['email'],
										 $abuse_solutions_subject,
										 $abuse_solutions_content,
										 $this->CFG['site']['noreply_name'],
										 $this->CFG['site']['noreply_email']);
					}
		    }

		/**
		 * get solutions rating
		 *
		 * @param 		String $users_stared_board_table
		 * @param 		String $board_table
		 * @param 		integer $board_id
		 * @param 		integer $user_id
		 * @param 		String $cfg_project_path_relative
		 * @return 		void
		 * @access 		public
		 */
		public function getBoardRatings($users_stared_board_table, $board_id, $user_id, $cfg_project_path_relative, $relative_path, $board_url)
			{

				$getBoardRatings_arr = array();
				$getBoardRatings_arr['rating_url'] = '';
				$getBoardRatings_arr['rating_link'] = false;

				$rateimg['rateit_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/board_icon-rateit.gif';
				$rateimg['rateitdisable_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/board_icon-rateitdisable.gif';
				$rateimg['unrateit_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/board_icon-unrateit.gif';
				$rateimg['unrateitdisable_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/board_icon-unrateitdisable.gif';

				if (!isMember())
					{
						$getBoardRatings_arr['rating_url'] = getUrl('login', '?light_url='.$board_url, '?light_url='.$board_url);
						$getBoardRatings_arr['rating_alt'] = $this->LANG['solutions_login_to_rate'];
						$getBoardRatings_arr['rating_link'] = true;
						$getBoardRatings_arr['rate_img'] = $rateimg['rateit_img'];
					}
				elseif($this->CFG['user']['user_id'] == $user_id)
					{
					 	$getBoardRatings_arr['rating_alt'] = $this->LANG['solutions_its_yours_board'];
					 	$getBoardRatings_arr['rate_img'] = $rateimg['rateitdisable_img'];
					}
				else
					{
						$sql = 'SELECT rating FROM '.$users_stared_board_table.' WHERE board_id = '.$this->dbObj->Param($board_id).
							   ' AND user_id = '.$this->dbObj->Param($this->CFG['user']['user_id']);

						$stmt = $this->dbObj->Prepare($sql);
						$result = $this->dbObj->Execute($stmt, array($board_id, $this->CFG['user']['user_id']));
						if (!$result)
								trigger_db_error($this->dbObj);

						if ($result->PO_RecordCount())
							{
								if ($this->CFG['admin']['board']['unrate'])
									{
										$getBoardRatings_arr['rating_link'] = true;
										$getBoardRatings_arr['rate_img'] = $rateimg['unrateit_img'];
										$getBoardRatings_arr['rating_alt'] = $this->LANG['solutions_unrate_it'];
										$getBoardRatings_arr['rating_url'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/ratingSolution.php?action=board&amp;bid='.$board_id.'&amp;uid='.$this->board_details['user_id'].'&amp;rating=-'.$this->CFG['admin']['rate']['points'];
									}
								else
									{
										$getBoardRatings_arr['rate_img'] = $rateimg['unrateitdisable_img'];
										$getBoardRatings_arr['rating_alt'] = $this->LANG['solutions_rated_it'];
									}
							}
						else
							{
								$getBoardRatings_arr['rating_link'] = true;
								$getBoardRatings_arr['rate_img'] = $rateimg['rateit_img'];
								$getBoardRatings_arr['rating_alt'] = $this->LANG['solutions_rate_it'];
								$getBoardRatings_arr['rating_url'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/ratingSolution.php?action=board&amp;bid='.$board_id.'&amp;uid='.$this->board_details['user_id'].'&amp;rating='.$this->CFG['admin']['rate']['points'];

							}
					}

				$rating_count = 0;
				$sql = 'SELECT SUM(rating) as cnt FROM '.$users_stared_board_table.' WHERE board_id = '.$this->dbObj->Param($board_id);
				$stmt = $this->dbObj->Prepare($sql);
				$result = $this->dbObj->Execute($stmt, array($board_id));
				if (!$result)
						trigger_db_error($this->dbObj);
				// returns record id
				$row=$result->FetchRow();
				if($row['cnt'] != '')
					$rating_count = $row['cnt'];

				$getBoardRatings_arr['rating_count'] = $rating_count;
				$this->LANG['index_rating_lang'] = ($rating_count==1)?$this->LANG['index_rating']:$this->LANG['index_ratings'];
				return $getBoardRatings_arr;
			}

		/**
		 * get solutions rating
		 *
		 * @param 		String $users_stared_solution_table
		 * @param 		String $solutions_table
		 * @param 		integer $solution_id
		 * @param 		integer $user_id
		 * @param 		String $cfg_project_path_relative
		 * @return 		void
		 * @access 		public
		 */
		public function getSolutionsRatings($users_stared_solution_table, $solutions_table, $solution_id, $user_id, $cfg_project_path_relative, $relative_path, $id_cnt, $board_url, $is_best=0)
			{
				$getSolutionsRatings_arr = array();
				$getSolutionsRatings_arr['rating_url'] = '';
				$getSolutionsRatings_arr['rating_link'] = false;

				$rateimg['rateit_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/icon-rateit.gif';
				$rateimg['rateitdisable_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/icon-rateitdisable.gif';
				$rateimg['unrateit_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/icon-unrateit.gif';
				$rateimg['unrateitdisable_img'] = $this->CFG['site']['url'].'discussions/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/icon-unrateitdisable.gif';

				if (!isMember())
					{
						$getSolutionsRatings_arr['rating_url'] = getUrl('login', '?light_url='.$board_url, '?light_url='.$board_url);
						$getSolutionsRatings_arr['rating_alt'] = $this->LANG['solutions_login_to_rate'];
						$getSolutionsRatings_arr['rating_link'] = true;
						$getSolutionsRatings_arr['rate_img'] = $rateimg['rateit_img'];

					}
				elseif($this->CFG['user']['user_id'] == $user_id)
					{
						$getSolutionsRatings_arr['rating_alt'] = $this->LANG['solutions_its_yours'];
					 	$getSolutionsRatings_arr['rate_img'] = $rateimg['rateitdisable_img'];
					}
				else
					{
						$sql = 'SELECT rating FROM '.$users_stared_solution_table.' WHERE solution_id = '.$this->dbObj->Param($solution_id).
							   ' AND user_id = '.$this->dbObj->Param($this->CFG['user']['user_id']);

						$stmt = $this->dbObj->Prepare($sql);
						$result = $this->dbObj->Execute($stmt, array($solution_id, $this->CFG['user']['user_id']));
						if (!$result)
								trigger_db_error($this->dbObj);

						if ($result->PO_RecordCount())
							{
								if ($this->CFG['admin']['solution']['unrate'])
									{
										$getSolutionsRatings_arr['rating_link'] = true;
										$getSolutionsRatings_arr['rate_img'] = $rateimg['unrateit_img'];
										$getSolutionsRatings_arr['rating_alt'] = $this->LANG['solutions_unrate_it'];
										$getSolutionsRatings_arr['rating_url'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/ratingSolution.php?action=solutions&amp;sid='.$solution_id.'&amp;uid='.$user_id.'&amp;rating=-'.$this->CFG['admin']['rate']['points'].'&amp;is_best='.$is_best.'&amp;id_cnt='.$id_cnt;
									}
								else
									{
										$getSolutionsRatings_arr['rate_img'] = $rateimg['unrateitdisable_img'];
										$getSolutionsRatings_arr['rating_alt'] = $this->LANG['solutions_rated_it'];
									}
							}
						else
							{
								$getSolutionsRatings_arr['rating_link'] = true;
								$getSolutionsRatings_arr['rate_img'] = $rateimg['rateit_img'];
								$getSolutionsRatings_arr['rating_alt'] = $this->LANG['solutions_rate_it'];
								$getSolutionsRatings_arr['rating_url'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/ratingSolution.php?action=solutions&amp;sid='.$solution_id.'&amp;uid='.$user_id.'&amp;rating='.$this->CFG['admin']['rate']['points'].'&amp;is_best='.$is_best.'&amp;id_cnt='.$id_cnt;
							}
					}

				$rating_count = 0;
				$sql = 'SELECT SUM(rating) as cnt FROM '.$users_stared_solution_table.' WHERE solution_id = '.$this->dbObj->Param($solution_id);
				$stmt = $this->dbObj->Prepare($sql);
				$result = $this->dbObj->Execute($stmt, array($solution_id));
				if (!$result)
						trigger_db_error($this->dbObj);
				// returns record id
				$row=$result->FetchRow();
				if($row['cnt'] != '')
					$rating_count = $row['cnt'];

				$getSolutionsRatings_arr['rating_count'] = $rating_count;
				$this->LANG['index_rating_lang'] = ($rating_count==1)?$this->LANG['index_rating']:$this->LANG['index_ratings'];
				return $getSolutionsRatings_arr;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function chkIsSolutionOwner($err_tip='')
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['solutions'].
						' WHERE solution_id='.$this->dbObj->Param($this->fields_arr['aid']).
						' AND user_id='.$this->dbObj->Param($this->CFG['user']['user_id']).
						' AND board_id='.$this->dbObj->Param($this->fields_arr['qid']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid'],
														 $this->CFG['user']['user_id'],
														 $this->fields_arr['qid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				$ok = true;
				if (!$rs->PO_RecordCount())
					{
						$ok = false;
						$this->setCommonErrorMsg($err_tip);
					}
				return $ok;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function deleteSolution()
			{
				$this->deleteSolutionsComment();

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['solutions'].
						' WHERE solution_id='.$this->dbObj->Param($this->fields_arr['aid']).
						' AND user_id='.$this->dbObj->Param($this->CFG['user']['user_id']).
						' AND board_id='.$this->dbObj->Param($this->fields_arr['qid']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid'],
														 $this->CFG['user']['user_id'],
														 $this->fields_arr['qid']));
				if (!$rs)
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

				//Decrement total_solutions in discussions table
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].
						' SET total_solutions=total_solutions-1'.
						' WHERE discussion_id='.$this->dbObj->Param($this->fields_arr['did']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['did']));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				//Decrement total_solutions in boards table
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].
						' SET total_solutions=total_solutions-1'.
						' WHERE board_id='.$this->dbObj->Param($this->fields_arr['qid']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['qid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				//Reset best solution id in boards table
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].
						' SET best_solution_id=0'.
						' WHERE board_id='.$this->dbObj->Param($this->fields_arr['qid']).
						' AND best_solution_id='.$this->dbObj->Param('best_solution_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['qid'], $this->fields_arr['aid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				//Decrement tot_ans in users_board_log table
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
						' SET total_solution=total_solution-1'.
						' WHERE user_id='.$this->dbObj->Param($this->CFG['user']['user_id']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				if ($this->CFG['admin']['reply_solutions']['allowed'])
					{
						//Decrement total_points in users_board_log table
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
								' SET total_points=total_points-'.$this->CFG['admin']['reply_solutions']['points'].
								' WHERE user_id='.$this->dbObj->Param($this->CFG['user']['user_id']);
								#.' AND total_points >= '.$this->CFG['admin']['reply_solutions']['points'];
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
						if (!$rs)
							    trigger_db_error($this->dbObj);
					}

				//Delete Attachement for each deleted solution
				$this->fetchAndDeleteAttachments('Solution', $this->fields_arr['aid']);
			}
		public function deleteSolutionsComment()
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['board_comment'].
						' WHERE solution_id='.$this->dbObj->Param($this->fields_arr['aid']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		public function deleteBoardsComment()
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['board_comment'].
						' WHERE board_id='.$this->dbObj->Param($this->fields_arr['qid']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['qid']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		public function generateRandomId()
			{
				$time = time();
				$this->fields_arr['rid'] = md5($time);
			}

		public function fetchMoreAttachments()
			{
				if (!$this->repliesArray) return ;
				$fetchMoreAttachments_val = '';
				$inc=1;
				foreach($this->repliesArray as $row)
					{
						$anchor = 'replyQues'.$row['attachment_id'];

						$row['date_added'] = ($row['date_added'] != '') ? $this->getTimeDiffernceFormat($row['date_added']) : '';
						$extern = strtolower(substr($row['attachment_name'], strrpos($row['attachment_name'], '.')+1));
						$attachment_file_name = getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['thumb_name'].'.'.$extern;
						$attachment_original_file_name = getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['large_name'].'.'.$extern;
						$fetchMoreAttachments_val[$inc]['attachment_id'] = $row['attachment_id'];
						$fetchMoreAttachments_val[$inc]['attachment_path'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$attachment_original_file_name;
						$fetchMoreAttachments_val[$inc]['gallery'] = $row['gallary'];
						$fetchMoreAttachments_val[$inc]['attachment_name'] = $row['attachment_name'];
						$fetchMoreAttachments_val[$inc]['attachment_original_path'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['large_name'].'.'.$extern;
						$fetchMoreAttachments_val[$inc]['extern'] = $extern;
						$fetchMoreAttachments_val[$inc]['image_path'] = $row['photo_server_url'].$this->CFG['admin']['ans_attachments_path'].$attachment_file_name;
						$fetchMoreAttachments_val[$inc]['date_added'] = $row['date_added'];
						$inc++;

					}
				return $fetchMoreAttachments_val;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function hasMoreAttachments($mainSolution_id, $type='Board')
			{
				$sql = 'SELECT attachment_id, attachment_name, photo_server_url, content_id, CONCAT(\''.$type.'_\',content_id) as gallary, TIMEDIFF(NOW(), date_added) AS date_added'.
						' FROM '.$this->CFG['db']['tbl']['attachments'].' AS bc'.
						' WHERE content_id='.$this->dbObj->Param('qid').
						' AND content_type='.$this->dbObj->Param($type).
						' ORDER BY attachment_id DESC';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($mainSolution_id, $type));

				if (!$rs)
				    trigger_db_error($this->dbObj);

				$this->repliesArray = array();

				while($row = $rs->FetchRow())
					{
						$this->repliesArray[] = $row;
					}
				return $this->repliesArray;
			}

		public function getAttachments()
			{
				$getAttachments_val = '';
				$getAttachments_arr = array();
				$sql = 'SELECT attachment_id, attachment_name FROM '.$this->CFG['db']['tbl']['attachments'].
						' WHERE content_id='.$this->dbObj->Param($this->fields_arr['aid']).' AND content_type=\'Solution\' ORDER BY date_added';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid']));
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
		 * PhotoUpload::storeImagesTempServer()
		 *
		 * @param $uploadUrl
		 * @param $extern
		 * @return
		 **/
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
						//echo '<br>size<br>'.$image_info[1];
						//die('hard');

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

		/**
		 * BoardFormHandler::addAttachments()
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
						$temp_dir = '../discussions/files/uploads/';
						$def_req = $temp_dir.'temp_'.$req_upl[1].'_'.$req_upl[2].'.'.$extern;
						$imageObj = new ImageHandler($def_req);
						$this->setIHObject($imageObj);
						$temp_file =$temp_dir.'temp_'.$req_upl[1].'_'.$req_upl[2];
						if(in_array($extern, $this->CFG['admin']['attachments']['image_formats']))
							$this->storePicturesTempServer($temp_file, $extern);

						$uploaded = false;
						$local_upload = true;
						$dir = $this->CFG['admin']['ans_attachments_path'];
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
								$dir = '../discussions/'.$this->CFG['admin']['ans_attachments_path'];
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
							unlink('../'.$uploads_arr[$i]);
							unlink($temp_dir.'temp_'.$req_upl[1].'_'.$req_upl[2].'.'.$extern);
					}
			}

		public function createAttachmentRecord($size)
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['attachments'].
						' SET content_type=\'Solution\''.
						', content_id='.$this->dbObj->Param('board').
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
						' SET attachment_name='.$this->dbObj->Param('board').
						' ,photo_server_url='.$this->dbObj->Param('server_url').
						' WHERE attachment_id='.$this->dbObj->Param('id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($file_path, $this->fields_arr['server_url'], $aid));
				if (!$rs)
				        trigger_db_error($this->dbObj);
			}
		public function addBoardComment($for)
			{

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['board_comment'].
						' SET board_id='.$this->dbObj->Param('c_qid').
						', solution_id='.$this->dbObj->Param('c_solution_id').
						', user_id='.$this->CFG['user']['user_id'].
						', comment='.$this->dbObj->Param('user_comment').
						', date_added=NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('c_qid'), $this->getFormField('c_solution_id'),addslashes($this->getFormField('user_comment'))));
				if (!$rs)
				        trigger_db_error($this->dbObj);
			}

		public function populateCommentList($c_ansid)
			{
				$sql = 'SELECT comment_id, solution_id, user_id, comment ,status,  DATE_FORMAT(date_added, \''.$this->CFG['mysql_format']['date_time_meridian'].'\') AS date_added'.
						' FROM '.$this->CFG['db']['tbl']['board_comment'].' WHERE'.
						' solution_id = '.$this->dbObj->Param('c_solution_id').'ORDER BY  comment_id ASC';

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
								$row['comment'] = nl2br(wordWrapManual(strip_slashes($row['comment']), $this->CFG['admin']['solution']['line_length']));
								//$row['comment'] = html_entity_decode($row['comment'], ENT_QUOTES);
								$populateCommentList_arr[$inc]['record'] = $row;
								$populateCommentList_arr[$inc]['commentSpanIDId'] = 'commentSpanID_'.$row['comment_id'];
								$populateCommentList_arr[$inc]['user_details'] = $this->getUserDetails($row['user_id']);

								$populateCommentList_arr[$inc]['mysolutions']['url'] = getMemberUrl($populateCommentList_arr[$inc]['user_details']['user_id'], $populateCommentList_arr[$inc]['user_details']['name']);
								$populateCommentList_arr[$inc]['msg'] = 'msg_'.$row['solution_id'];
								$populateCommentList_arr[$inc]['anchor'] = 'deleteComment'.$row['comment_id'];
								$inc++;
							}
					}
				return $populateCommentList_arr;
			}
		public function populateAjaxCommentList($c_ansid)
			{
				global $smartyObj, $LANG,$CFG ;
				$sql = 'SELECT comment_id, solution_id, user_id, comment ,status,  DATE_FORMAT(date_added, \''.$this->CFG['mysql_format']['date_time_meridian'].'\') AS date_added'.
						' FROM '.$this->CFG['db']['tbl']['board_comment'].' WHERE'.
						' solution_id = '.$this->dbObj->Param('c_solution_id').'ORDER BY  comment_id ASC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($c_ansid));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$populateAjaxCommentList_arr = array();
				$smartyObj->assign('solutionsurl', getUrl('solutions', '?action=view&title='.$this->getFormField('c_seo_title'), $this->getFormField('c_seo_title').'/', '', $this->CFG['admin']['index']['home_module']));
				if($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								$row['comment'] = nl2br(wordWrapManual(strip_slashes($row['comment']), $this->CFG['admin']['solution']['line_length']));
								//$row['comment'] = html_entity_decode($row['comment'], ENT_QUOTES);
								$populateAjaxCommentList_arr[$inc]['record'] = $row;
								$populateAjaxCommentList_arr[$inc]['user_details'] = $this->getUserDetails($row['user_id']);
								$populateAjaxCommentList_arr[$inc]['commentSpanIDId'] = 'commentSpanID_'.$row['comment_id'];
								$populateAjaxCommentList_arr[$inc]['user_details'] = $this->getUserDetails($row['user_id']);
								$populateAjaxCommentList_arr[$inc]['mysolutions']['url'] = getMemberUrl($populateAjaxCommentList_arr[$inc]['user_details']['user_id'], $populateAjaxCommentList_arr[$inc]['user_details']['name']);
								$populateAjaxCommentList_arr[$inc]['anchor'] = 'deleteComment'.$row['comment_id'];
								$inc++;
							}
					}
			if($this->getFormField('success') == 'success')
				$smartyObj->assign('success','success');
			else
				$smartyObj->assign('success','');
			$smartyObj->assign('LANG',$LANG);
			$smartyObj->assign('myobj',$this);
			$smartyObj->assign('CFG',$CFG);
			$smartyObj->assign('populateAjaxCommentList_arr',$populateAjaxCommentList_arr);
			setTemplateFolder('general/', $this->CFG['admin']['index']['home_module']);
			$smartyObj->display('commentSolutionsAjaxList.tpl');

			}

		public function checkIfCommentAdded($solution_id)
			{
				$sql = 'SELECT comment_id FROM '.$this->CFG['db']['tbl']['board_comment'].' WHERE'.
				      	' solution_id = '.$this->dbObj->Param('solution_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($solution_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				$count = $rs->PO_RecordCount();
				if($count > 0)
					return true;
				else
					return false;

			}

		public function checkIfReplyAllowed($board_id, $solution_id)
			{
				$sql = 'SELECT comment_id FROM '.$this->CFG['db']['tbl']['board_comment'].' WHERE'.
				      ' board_id = '.$this->dbObj->Param('board_id').''.
					  ' AND solution_id = '.$this->dbObj->Param('solution_id').''.
					  ' AND user_id = '.$this->CFG['user']['user_id'];
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($board_id, $solution_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				$count = $rs->PO_RecordCount();
				if($count < $this->CFG['admin']['number_of_comments']['allowed'])
					return true;
				else
					return false;

			}

		public function isSolutionOwner($solution_id)
			{
				$sql = 'SELECT user_id  FROM '.$this->CFG['db']['tbl']['solutions'].' WHERE'.
				      ' solution_id = '.$this->dbObj->Param('solution_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($solution_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				if($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								if ($row['user_id'] == $this->CFG['user']['user_id'])
									return true;
							}
					}
				return false;
			}

		public function deleteComment($comment_id)
			{
				$sql = 'DELETE from '.$this->CFG['db']['tbl']['board_comment'].''.
				       ' WHERE comment_id = '.$this->dbObj->Param($comment_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($comment_id));
				if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		public function getTotalBoardComments($qid, $solution_id)
			{
				$sql = 'SELECT comment_id FROM '.$this->CFG['db']['tbl']['board_comment'].' WHERE'.
				      ' board_id = '.$this->dbObj->Param('qid').' AND solution_id = '.$this->dbObj->Param('solution_id').''.
					  ' AND user_id = '.$this->dbObj->Param($this->CFG['user']['user_id']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($qid, $solution_id, $this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				$count = $rs->PO_RecordCount();
				if($count < $this->CFG['admin']['number_of_comments']['allowed'])
					return true;
				else
					return false;
			}

		public function getTotalSolutionComments($solution_id)
	   		{
				$sql = 'SELECT comment_id FROM '.$this->CFG['db']['tbl']['board_comment'].' WHERE'.
				      ' solution_id = '.$this->dbObj->Param('solution_id').
					  ' AND user_id = '.$this->dbObj->Param($this->CFG['user']['user_id']);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($solution_id, $this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				$count = $rs->PO_RecordCount();
				if($count < $this->CFG['admin']['number_of_comments']['allowed'])
					return true;
				else
					return false;
			}

		public function chkBoardOwnerPostedComments($solution_id)
	   		{
				$sql = 'SELECT comment_id FROM '.$this->CFG['db']['tbl']['board_comment'].' WHERE'.
				      	' solution_id = '.$this->dbObj->Param('solution_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($solution_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				$count = $rs->PO_RecordCount();
				if($count > 0)
					return true;
				else
					return false;
			}

		public function getViewBestSolutionLink()
			{
				$sql = explode('LIMIT', $this->sql);
				$sql = $sql[0];
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_db_error($this->dbObj);
				$count = $rs->PO_RecordCount();
				$this->best_nav['url'] = '';
				if($count)
					{
						$i = $link = $start = 0;
						$pg = $this->CFG['data_tbl']['numpg'];
						$sol_id = '';
						$start = '';
						$startH = '?start=0';
						while($row = $rs->FetchRow())
							{
								$i++;
								if($this->board_details['best_solution_id'] == $row['solution_id'])
									{
										$sol_id = '#solutionmore'.$row['solution_id'];
										$start = (ceil($i/$pg) - 1) * $pg;
										$startH = '?'.$start;

										if($this->fields_arr['start'] == '0' && $i <= $pg)
											{
												$q_str = explode('&',$_SERVER['QUERY_STRING']);
												if($q_str[0] == 'start=0')
													{
														$startH = '?start='.$start;
														$start = 'start='.$start.'&';
													}
												else
													{
														$start = '';
														$startH = '?start=0';
													}
											}
										else
											{
												$startH = '?start='.$start;
												$start = 'start='.$start.'&';
											}
									}

							}
						$this->best_nav['url'] = getUrl('solutions', '?'.$start.'title='.$this->board_details['seo_title'].$sol_id, $this->board_details['seo_title'].'/'.$startH.$sol_id, '', $this->CFG['admin']['index']['home_module']);
					}
			}

		public function userDisplayDetails($userId=0)
			{
				$sql = 'SELECT u.'.$this->getUserTableField('doj').' AS doj, ub.total_solution'.
						' FROM '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['users_board_log'].' as ub'.
						' WHERE u.'.$this->getUserTableField('user_id').' = ub.user_id'.
					  	' AND u.'.$this->getUserTableField('user_id').' = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($userId));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				$row = array('doj'=>'', 'total_solution'=>'');
				if($rs->PO_RecordCount())
					$row = $rs->FetchRow();

				return $row;
			}

		public function isValidDiscussionId()
			{
				$sql = 'SELECT d.discussion_id, d.discussion_title, d.visible_to, d.pcat_id, d.cat_id, d.description, d.visible_to, d.publish_status, TIMEDIFF(NOW(), d.date_added) as date_asked'.
						', '.$this->getUserTableField('display_name').' as asked_by, u.'.$this->getUserTableField('user_id').' as img_user_id,'.$this->getUserTableFields(array('name')).' , d.status, d.user_id'.
						', d.seo_title FROM '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE d.pcat_id=c.cat_id AND c.status = \'Active\''.
						' AND d.user_id=u.'.$this->getUserTableField('user_id').' AND d.status = \'Active\''.
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
				return true;

			}
		/**
		*
		* Get the related boards
		*
		*/
		public function relatedBoards($limit = 3)
			{
				global $smartyObj;
				$this->form_board['related_more_link'] = '';
				$displayRelatedBoards_arr = array();
				if($this->board_details['search_word']!='')
					{
						//board words after removing special chars and common words
						$board_words = $this->filterWordsForSearching($this->board_details['search_word']);
						$board_words = array_trim($board_words);

						$where_search = '';
						foreach($board_words as $index=>$values)
							{
								if($values != '' AND strlen($values) > 1)
									$where_search .= getSearchBoardExpressionQuery($values, 'search_word').' OR';
							}

						if($where_search != '')
							{
								$where_search = substr($where_search, 0, strlen($where_search)-2);
								$where_search = ' AND ('.$where_search.')';

								$sql = 'SELECT board_id, b.board, b.last_post_by, b.seo_title, best_solution_id, b.solution_added, DATE_FORMAT(solution_added, \''.$this->CFG['mysql_format']['date_time_meridian'].'\') as last_post_date'.
										', b.readonly, b.visible_to, b.total_solutions, b.total_views, b.status, b.user_id'.
										', u.'.$this->getUserTableField('display_name').' as asked_by, lp.'.$this->getUserTableField('display_name').' as last_post_name, u.'.$this->getUserTableField('name').' as name'.
										', lp.'.$this->getUserTableField('name').' as last_post_user, total_stars, TIMEDIFF(NOW(), board_added) as board_added'.
										' FROM '.$this->CFG['db']['tbl']['boards'].' AS b LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS lp ON lp.'.$this->getUserTableField('user_id').'=b.last_post_by, '.$this->CFG['db']['tbl']['users'].' as u'.
										' WHERE b.user_id=u.'.$this->getUserTableField('user_id').' AND b.status IN (\'Active\')'.
										' AND EXISTS(SELECT 1 FROM '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c, '.$this->CFG['db']['tbl']['users'].' AS ud WHERE d.pcat_id=c.cat_id AND c.status=\'Active\' AND d.user_id = ud.'.$this->getUserTableField('user_id').' AND ud.'.$this->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id = b.discussion_id  AND d.status = \'Active\')'.
										' AND u.'.$this->getUserTableField('user_status').'=\'Ok\' '.
										' AND b.board_id!='.$this->dbObj->Param('board_id').$where_search;

								$sql.=' ORDER BY RAND() LIMIT 0, '.$this->dbObj->Param('limit');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->board_details['board_id'], $limit));
								if (!$rs)
								        trigger_db_error($this->dbObj);

								if($related_boards_cnt = $rs->PO_RecordCount())
									{
										$inc = 0;
										while($row = $rs->FetchRow()) {
											$displayRelatedBoards_arr[$inc]['record'] = $row;
											$displayRelatedBoards_arr[$inc]['solution']['url'] = getUrl('solutions', '?title='.$row['seo_title'], $row['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']);
											$displayRelatedBoards_arr[$inc]['row_board_manual'] = wordWrapManual($row['board'], $this->CFG['admin']['board']['line_length'], $this->CFG['admin']['board']['short_length']);

											$displayRelatedBoards_arr[$inc]['last_post_by'] = '<a href="'.getMemberUrl($row['last_post_by'], $row['last_post_user']).'">'.$row['last_post_name'].'</a>';
											$displayRelatedBoards_arr[$inc]['last_post_on'] = $row['last_post_date'];

											$row['isNewPost'] = $this->chkIsNewPostOnthisBoard($this->CFG['user']['user_id'], $this->CFG['remote_client']['ip'], $row['board_id'], $row['solution_added']);

											$displayRelatedBoards_arr[$inc]['iconClass'] = $displayRelatedBoards_arr[$inc]['bestAnsClass'] = '';

											$displayRelatedBoards_arr[$inc]['bestIcon'] = $displayRelatedBoards_arr[$inc]['legendIcon'] = '';

											$displayRelatedBoards_arr[$inc]['appendIcon'] = ' clsAppendNoNewThread';
											if($row['isNewPost'])
												$displayRelatedBoards_arr[$inc]['appendIcon'] = ' clsAppendNewThread';

											if($row['best_solution_id'])
												{
													$displayRelatedBoards_arr[$inc]['bestIcon'] = '<img alt="" src="'.$this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/icon-bestsolutionsmall.gif" />';
												}
											if($row['readonly'] == 'Yes')
												{
													$displayRelatedBoards_arr[$inc]['legendIcon'] = 'clsIconROThread';
												}
											elseif($row['total_solutions'] >= $this->CFG['admin']['hot_board']['limit'])
												{
													$displayRelatedBoards_arr[$inc]['legendIcon'] = 'clsIconHotThread';
												}
											elseif(isMember() and $this->myPostIncludedBoard($row['board_id']))
												{
													$displayRelatedBoards_arr[$inc]['legendIcon'] = 'clsIconMyThread';
												}
											elseif($row['isNewPost'])
												{
													$displayRelatedBoards_arr[$inc]['legendIcon'] = 'clsIconNewThread';
												}
											else
												{
													$displayRelatedBoards_arr[$inc]['legendIcon'] = 'clsIconNoNewThread';
												}

											$displayRelatedBoards_arr[$inc]['mysolutions']['url'] = getMemberUrl($row['user_id'], $row['name']);
											$displayRelatedBoards_arr[$inc]['row_asked_by_manual'] = stripString($row['asked_by'], $this->CFG['username']['short_length']);

											if($row['last_post_user'])
												$displayRelatedBoards_arr[$inc]['last_post_by'] = '<a href="'.getMemberUrl($row['last_post_by'], $row['last_post_user']).'">'.stripString($row['last_post_name'], $this->CFG['username']['medium_length']).'</a>';
											else
												$displayRelatedBoards_arr[$inc]['last_post_by'] = '';

											$displayRelatedBoards_arr[$inc]['solution_members']['url'] = getUrl('solutions', '?title='.$row['seo_title'], $row['seo_title'].'/', 'members', $this->CFG['admin']['index']['home_module']);
											$displayRelatedBoards_arr[$inc]['login_solution']['url'] = getUrl('login', '?light_url='.$displayRelatedBoards_arr[$inc]['solution_members']['url'], '?light_url='.$displayRelatedBoards_arr[$inc]['solution_members']['url'], 'root');
											$inc++;
										}

										if($related_boards_cnt > $limit)
											$this->form_board['related_more_link'] = getUrl('boards', '?view=related&amp;bid='.$this->board_details['board_id'], 'related/?bid='.$this->board_details['board_id'], '', $this->CFG['admin']['index']['home_module']);

										//return $displayRelatedBoards_arr;
									}
							}

					}
					$this->form_board['displayRelatedBoards_arr'] = $displayRelatedBoards_arr;
					setTemplateFolder('general/', $this->CFG['admin']['index']['home_module']);
					$smartyObj->display('relatedBoards.tpl');
			}
			/**
			 * Viewphoto::getBoardRating()
			 *
			 * @param integer $user_id
			 * @return integer
			 */
			public function getBoardRating($user_id)
			{
				$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['discuzz_board_rating'].
						' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
						' board_id='.$this->dbObj->Param('board_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $this->fields_arr['bid']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
				{
					return $row['rate'];
				}
				return 0;
			}
			/**
			 * Viewphoto::populateBoardRatingDetails()
			 *
			 * @return void
			 */
			public function populateBoardRatingDetails($rating)
			{
				$rating = round($rating,0);
				return $rating;
			}

			/**
			 * viewPhoto::populateBoardRatingImagesForAjax()
			 * purpose to populate images for rating
			 * @param $rating
			 * @return void
			 **/
			public function populateBoardRatingImagesForAjax($rating, $imagePrefix='')
			{
				$rating_total = $this->CFG['admin']['total_rating'];
				?>
				<div class="clsSolutionRatingLeft">
				<?php
				for($i=1;$i<=$rating;$i++)
				{
					?>
					<a onClick="return callDiscuzzAjaxRate('<?php echo $this->CFG['site']['discussions_url'].'solutions.php?ajax_page=true&bid='.
						$this->fields_arr['bid'].'&'.'rate='.$i;?>&show=<?php echo $this->fields_arr['show'];?>&title=<?php echo $this->fields_arr['title'];?>','selRatingPhoto','photoRating')"
						onMouseOver="ratingBoardMouseOver(<?php echo $i;?>, 'board')" onMouseOut="ratingBoardMouseOut(<?php echo $i;?>)" id="ratingLink">
						<img id="img<?php echo $i;?>" src="<?php echo $this->CFG['site']['discussions_url'].'design/templates/'.
						$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
						'/icon-boardratehover.gif'; ?>"  title="<?php echo $i;?>" /></a>
					<?php
				}
			    ?>
			    <?php
				for($i=$rating;$i<$rating_total;$i++)
				{
					?>
					<a onClick="return callDiscuzzAjaxRate('<?php echo $this->CFG['site']['discussions_url'].'solutions.php?ajax_page=true&bid='.
					$this->fields_arr['bid'].'&'.'rate='.($i+1);?>&show=<?php echo $this->fields_arr['show'];?>&title=<?php echo $this->fields_arr['title'];?>','selRatingPhoto','photoRating')"
					 onMouseOver="ratingBoardMouseOver(<?php echo ($i+1);?>, 'board')" onMouseOut="ratingBoardMouseOut(<?php echo ($i+1);?>)" id="ratingLink">
					 <img id="img<?php echo ($i+1);?>" src="<?php echo $this->CFG['site']['discussions_url'].'design/templates/'.
					 $this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
					 '/icon-boardrate.gif'; ?>"  title="<?php echo ($i+1);?>" /></a>
					 <?php
				}
				?>
			    </div>
			    <?php
			}
			/**
			 * Solution::chkAllowBoardRating()
			 *
			 * @return void
			 */
			public function chkAllowBoardRating()
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['boards'].
						' WHERE board_id='.$this->dbObj->Param('board_id').
						' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					return true;
				return false;
			}

			/**
			 * Solution::chkAlreadyBoardRated()
			 *
			 * @return boolean
			 */
			public function chkAlreadyBoardRated()
			{
				$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['discuzz_board_rating'].
						' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
						' board_id='.$this->dbObj->Param('board_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['bid']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['rate'];
				return false;
			}

			/**
			 * Solution::insertBoardRating()
			 *
			 * @return void
			 */
			public function insertBoardRating()
			{
				if($this->fields_arr['rate'])
				{
					$rate_old = $this->chkAlreadyBoardRated();
					$rate_new = $this->fields_arr['rate'];
					if($rate_new==1 && $rate_old==1)
					return true;

					if($rate_old > 0)
					{
						$rating_id = '';
						$diff = $rate_new - $rate_old;
						if($diff==0)
							return true;

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['discuzz_board_rating'].' SET'.
								' rate='.$this->dbObj->Param('rate').','.
								' date_added=NOW() '.
								' WHERE board_id='.$this->dbObj->Param('board_id').' AND '.
								' user_id='.$this->dbObj->Param('user_id');

						$update_fields_value_arr = array($this->fields_arr['rate'], $this->fields_arr['bid'],
														$this->CFG['user']['user_id']);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $update_fields_value_arr);
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						if($diff > 0)
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].' SET'.
										' rating_total=rating_total+'.$diff.' '.
										' WHERE board_id='.$this->dbObj->Param('board_id');
							}
						else
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].' SET'.
										' rating_total=rating_total'.$diff.' '.
										' WHERE board_id='.$this->dbObj->Param('board_id');
							}

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						//Find rating for rating photo activity..
						$sql = 'SELECT board_rating_id '.
								'FROM '.$this->CFG['db']['tbl']['discuzz_board_rating'].' '.
								' WHERE board_id='.$this->dbObj->Param('board_id').' AND '.
								' user_id='.$this->dbObj->Param('user_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid'],  $this->CFG['user']['user_id']));
						if (!$rs)
							trigger_db_error($this->dbObj);

						$row = $rs->FetchRow();
						$rating_id = $row['board_rating_id'];
					}
					else
					{
						$sql =  'INSERT INTO '.$this->CFG['db']['tbl']['discuzz_board_rating'].
								' (board_id, user_id, rate, date_added ) '.
								' VALUES ( '.
								$this->dbObj->Param('board_id').','.$this->dbObj->Param('user_id').','.$this->dbObj->Param('rate').',NOW()'.
								' ) ';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid'], $this->CFG['user']['user_id'], $this->fields_arr['rate']));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						$rating_id = $this->dbObj->Insert_ID();

						$sql =  'UPDATE '.$this->CFG['db']['tbl']['boards'].' SET'.
								' rating_total=rating_total+'.$this->fields_arr['rate'].','.
								' rating_count=rating_count+1'.
								' WHERE board_id='.$this->dbObj->Param('board_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
					    if (!$rs)
						    trigger_db_error($this->dbObj);
					}


					//Srart Post Photo rating Photo activity	..
					$sql = 'SELECT pr.board_rating_id, pr.board_id, pr.user_id as rating_user_id, pr.rate, '.
							'u.user_name, p.seo_title, p.user_id '.
							'FROM '.$this->CFG['db']['tbl']['discuzz_board_rating'].' as pr, '.
							$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['boards'].' as p '.
							' WHERE u.user_id = pr.user_id AND pr.board_id = p.board_id AND pr.board_rating_id = '.
							$this->dbObj->Param('board_rating_id');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($rating_id));
					if (!$rs)
						trigger_db_error($this->dbObj);

					$row = $rs->FetchRow();
					$activity_arr = $row;
					//end
				}
			}

			/**
			 * viewPhoto::getTotalBoardRatingImage()
			 * purpose to populate rating images based on the rating of the photo
			 * @return void
			 **/
			public function getTotalBoardRatingImage()
			{

				if ($this->chkIsValidBoard()) {
				    $rating = round($this->fields_arr['board_rating_total']/$this->fields_arr['board_rating_count'],0);
					$this->populateBoardRatingImagesForAjax($rating);
					$rating_text = $this->LANG['discuzz_rating'];
					$getDiscuzzRating = $this->getBoardRating($this->CFG['user']['user_id']);
					echo '<div class="clsDiscuzzBoardRatingRight">&nbsp;(<span>'.$this->fields_arr['board_rating_count'].'</span> )</div>@'.$getDiscuzzRating;
				}
			}




			/**
			 * Viewphoto::getSolutionRating()
			 *
			 * @param integer $user_id
			 * @return integer
			 */
			public function getSolutionRating($user_id,$solution_id)
			{
				$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['discuzz_solution_rating'].
						' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
						' solution_id='.$this->dbObj->Param('solution_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $solution_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
				{
					return $row['rate'];
				}
				return 0;
			}
			/**
			 * Viewphoto::populateSolutionRatingDetails()
			 *
			 * @return void
			 */
			public function populateSolutionRatingDetails($rating)
			{
				$rating = round($rating,0);
				return $rating;
			}

			/**
			 * viewPhoto::populateSolutionRatingImagesForAjax()
			 * purpose to populate images for rating
			 * @param $rating
			 * @return void
			 **/
			public function populateSolutionRatingImagesForAjax($rating, $imagePrefix='',$solutions_id='')
			{
				$rating_total = $this->CFG['admin']['total_rating'];
				?>
				<div class="clsSolutionRatingLeft">
				<?php
				for($i=1;$i<=$rating;$i++)
				{
					?>
					<a onClick="return callDiscuzzAjaxRate('<?php echo $this->CFG['site']['discussions_url'].'solutions.php?ajax_page=true&aid='.
						$solutions_id .'&'.'solutionrate='.$i;?>&show=<?php echo $this->fields_arr['show'];?>','selRatingPhoto<?php echo $solutions_id;?>','photoRating')"
						onMouseOver="ratingSolutionMouseOver(<?php echo $i;?>, 'solution', <?php echo $solutions_id ?>)" onMouseOut="ratingSolutionMouseOut(<?php echo $i;?>, <?php echo $solutions_id ?>)" id="ratingLink">
						<img id="img<?php echo $i;?>_<?php echo $solutions_id;?>" src="<?php echo $this->CFG['site']['discussions_url'].'design/templates/'.
						$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
						'/icon-solutionratehover.gif'; ?>"  title="<?php echo $i;?>" /></a>
					<?php
				}
			    ?>
			    <?php
				for($i=$rating;$i<$rating_total;$i++)
				{
					?>
					<a onClick="return callDiscuzzAjaxRate('<?php echo $this->CFG['site']['discussions_url'].'solutions.php?ajax_page=true&aid='.
					$solutions_id .'&'.'solutionrate='.($i+1);?>&show=<?php echo $this->fields_arr['show'];?>','selRatingPhoto<?php echo $solutions_id;?>','photoRating')"
					 onMouseOver="ratingSolutionMouseOver(<?php echo ($i+1);?>, 'solution', <?php echo $solutions_id ?>)" onMouseOut="ratingSolutionMouseOut(<?php echo ($i+1);?>, <?php echo $solutions_id ?>)" id="ratingLink">
					 <img id="img<?php echo ($i+1);?>_<?php echo $solutions_id;?>" src="<?php echo $this->CFG['site']['discussions_url'].'design/templates/'.
					 $this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
					 '/icon-solutionrate.gif'; ?>"  title="<?php echo ($i+1);?>" /></a>
					 <?php
				}
				?>
			    </div>
			    <?php
			}
			/**
			 * Solution::chkAllowSolutionRating()
			 *
			 * @return void
			 */
			public function chkAllowSolutionRating($sid)
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['solutions'].
						' WHERE solution_id='.$this->dbObj->Param('solution_id').
						' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($sid));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					return true;
				return false;
			}

			/**
			 * Solution::chkAlreadySolutionRated()
			 *
			 * @return boolean
			 */
			public function chkAlreadySolutionRated()
			{
				$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['discuzz_solution_rating'].
						' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
						' solution_id='.$this->dbObj->Param('solution_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['aid']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['rate'];
				return false;
			}

			/**
			 * Solution::insertSolutionRating()
			 *
			 * @return void
			 */
			public function insertSolutionRating()
			{
				if($this->fields_arr['solutionrate'])
				{
					$rate_old = $this->chkAlreadySolutionRated();
					$rate_new = $this->fields_arr['solutionrate'];
					if($rate_new==1 && $rate_old==1)
					return true;

					if($rate_old > 0)
					{
						$rating_id = '';
						$diff = $rate_new - $rate_old;
						if($diff==0)
							return true;

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['discuzz_solution_rating'].' SET'.
								' rate='.$this->dbObj->Param('rate').','.
								' date_added=NOW() '.
								' WHERE solution_id='.$this->dbObj->Param('solution_id').' AND '.
								' user_id='.$this->dbObj->Param('user_id');

						$update_fields_value_arr = array($this->fields_arr['solutionrate'], $this->fields_arr['aid'],
														$this->CFG['user']['user_id']);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $update_fields_value_arr);
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						if($diff > 0)
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['solutions'].' SET'.
										' rating_total=rating_total+'.$diff.' '.
										' WHERE solution_id='.$this->dbObj->Param('solution_id');
							}
						else
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['solutions'].' SET'.
										' rating_total=rating_total'.$diff.' '.
										' WHERE solution_id='.$this->dbObj->Param('solution_id');
							}

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid']));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						//Find rating for rating photo activity..
						$sql = 'SELECT solution_rating_id '.
								'FROM '.$this->CFG['db']['tbl']['discuzz_solution_rating'].' '.
								' WHERE solution_id='.$this->dbObj->Param('solution_id').' AND '.
								' user_id='.$this->dbObj->Param('user_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid'],  $this->CFG['user']['user_id']));
						if (!$rs)
							trigger_db_error($this->dbObj);

						$row = $rs->FetchRow();
						$rating_id = $row['solution_rating_id'];
					}
					else
					{
						$sql =  'INSERT INTO '.$this->CFG['db']['tbl']['discuzz_solution_rating'].
								' (solution_id, user_id, rate, date_added ) '.
								' VALUES ( '.
								$this->dbObj->Param('solution_id').','.$this->dbObj->Param('user_id').','.$this->dbObj->Param('rate').',NOW()'.
								' ) ';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid'], $this->CFG['user']['user_id'], $this->fields_arr['solutionrate']));
					    if (!$rs)
						    trigger_db_error($this->dbObj);

						$rating_id = $this->dbObj->Insert_ID();

						$sql =  'UPDATE '.$this->CFG['db']['tbl']['solutions'].' SET'.
								' rating_total=rating_total+'.$this->fields_arr['solutionrate'].','.
								' rating_count=rating_count+1'.
								' WHERE solution_id='.$this->dbObj->Param('solution_id');
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['aid']));
					    if (!$rs)
						    trigger_db_error($this->dbObj);
					}


					//Srart Post Photo rating Photo activity	..
					$sql = 'SELECT pr.solution_rating_id, pr.solution_id, pr.user_id as rating_user_id, pr.rate, '.
							'u.user_name, p.user_id '.
							'FROM '.$this->CFG['db']['tbl']['discuzz_solution_rating'].' as pr, '.
							$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['solutions'].' as p '.
							' WHERE u.user_id = pr.user_id AND pr.solution_id = p.solution_id AND pr.solution_rating_id = '.
							$this->dbObj->Param('solution_rating_id');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($rating_id));
					if (!$rs)
						trigger_db_error($this->dbObj);

					$row = $rs->FetchRow();
					$activity_arr = $row;
					//end
				}
			}

			/**
			 * viewPhoto::getTotalSolutionRatingImage()
			 * purpose to populate rating images based on the rating of the photo
			 * @return void
			 **/
			public function getTotalSolutionRatingImage()
			{

				if ($this->chkIsValidSolution($this->fields_arr['aid'])) {
				    $rating = round($this->fields_arr['solution_rating_total']/$this->fields_arr['solution_rating_count'],0);
					$this->populateSolutionRatingImagesForAjax($rating,'',$this->fields_arr['aid']);
					$rating_text = $this->LANG['discuzz_rating'];
					$getDiscuzzRating = $this->getSolutionRating($this->CFG['user']['user_id'],$this->fields_arr['aid']);
					echo '<div class="clsDiscuzzSolutionRatingRight">&nbsp;(<span>'.$this->fields_arr['solution_rating_count'].'</span> )</div>@'.$getDiscuzzRating;
				}
			}

	}
//<<<<<-------------- Class SolutionFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
//print_r($_POST);//die();
$solutions = new SolutionFormHandler();
if($CFG['admin']['index']['activity']['show'])
	{
		$DiscussionsActivity = new DiscussionsActivityHandler();
		$solutions->discussionsActivityObj = $DiscussionsActivity;
	}
$CFG['comments']['expand_collapse'] = false;
$solutions->setPageBlockNames(array('form_add', 'form_abuse_board', 'form_abuse_solution', 'form_confirm', 'form_board', 'form_solutions', 'form_invisible_board', 'form_best_solution', 'show_option_to_comment' , 'cancel_option_to_comment' , 'post_your_comment', 'from_related_boards'));

//default form fields and values...
$solutions->setFormField('did', '');
$solutions->setFormField('bid', '');
$solutions->setFormField('qid', '');
$solutions->setFormField('aid', '');
$solutions->setFormField('search_board', '');
$solutions->setFormField('solution', '');
$solutions->setFormField('action', '');
$solutions->setFormField('content_id', '');
$solutions->setFormField('reason', '');
$solutions->setFormField('str', '');
$solutions->setFormField('msg', '');
$solutions->setFormField('rid', '');
$solutions->setFormField('title', '');
$solutions->setFormField('seo_title', '');
$solutions->setFormField('attachments', '');
$solutions->setFormField('attachment_id', '');
$solutions->setFormField('attach_content_id', '');
$solutions->setFormField('attachment_name', '');
$solutions->setFormField('c_solution_id', '');
$solutions->setFormField('user_comment', '');
$solutions->setFormField('c_seo_title', '');
$solutions->setFormField('c_qid', '');
$solutions->setFormField('reply', '');
$solutions->setFormField('user_reply', '');
$solutions->setFormField('comment_id', '');
$solutions->setFormField('value', '');
$solutions->setFormField('id', '');
$solutions->setFormField('usrid', '');
$solutions->setFormField('ajax_page', '');
$solutions->setFormField('update', '');
$solutions->setFormField('upl_original', array());
$solutions->setFormField('uplarr', array());
$solutions->setFormField('visible_to', 'All');
$solutions->setFormField('board_rating_count', '');
$solutions->setFormField('board_rating_total', '');
$solutions->setFormField('rate', '');
$solutions->setFormField('solution_rating_count', '');
$solutions->setFormField('solution_rating_total', '');
$solutions->setFormField('solutionrate', '');
$solutions->setFormField('show', '');


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
$solutions->setFormField('numpg', $CFG['data_tbl']['numpg']);//$CFG['data_tbl']['numpg']
$solutions->CFG['feature']['display_links'] = 3;
$solutions->CFG['feature']['display_links_expect'] = 6;

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
$smartyObj->assign('reply', '');
if ($solutions->isFormPOSTed($_REQUEST, 'showOptionToComment'))
	{
		ob_start();
		$solutions->sanitizeFormInputs($_REQUEST);
		$showOptionToComment_arr = array();
		$c_solution_id = $solutions->getFormField('c_solution_id');
		$commentSpanIDId = 'commentSpanID_'.$solutions->getFormField('c_solution_id');
		if($solutions->getFormField('reply') == 'reply')
			$showOptionToComment_arr['submit']['onclick'] =  getUrl('solutions', '?action=view&ajax_page=true&reply=reply&c_qid='.$solutions->getFormField('c_qid').'&postYourComment=1&title='.$solutions->getFormField('c_seo_title'), $solutions->getFormField('c_seo_title').'/?action=view&ajax_page=true&postYourComment=1', 'members', $CFG['admin']['index']['home_module']);
		else
			$showOptionToComment_arr['submit']['onclick'] =  getUrl('solutions', '?action=view&ajax_page=true&postYourComment=1&title='.$solutions->getFormField('c_seo_title'), $solutions->getFormField('c_seo_title').'/?action=view&ajax_page=true&postYourComment=1', 'members', $CFG['admin']['index']['home_module']);
		$showOptionToComment_arr['cancel']['onclick'] = getUrl('solutions', '?action=view&title='.$solutions->getFormField('c_seo_title'),$solutions->getFormField('c_seo_title').'/', 'members', $CFG['admin']['index']['home_module']);

		$solutions->setAllPageBlocksHide();
		$solutions->setPageBlockShow('show_option_to_comment');
		$solutions->includeAjaxHeader();
		$smartyObj->assign('showOptionToComment_arr', $showOptionToComment_arr);
		$smartyObj->assign('c_solution_id', $c_solution_id);
		$smartyObj->assign('commentSpanIDId', $commentSpanIDId);
		setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
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
		$solutions->includeAjaxHeader();
		setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
		$smartyObj->display('commentSolutionsAjax.tpl');
		$solutions->includeAjaxFooter();
		die();
	}
if ($solutions->isFormPOSTed($_REQUEST, 'postYourComment'))
	{
		ob_start();
		$solutions->sanitizeFormInputs($_REQUEST);
			if($solutions->getFormField('reply') == '')
			{
				$descriptions = stripString($solutions->getFormField('user_comment'), $CFG['admin']['description']['limit']);
				$solutions->setFormField('user_comment', $descriptions);

				$solutions->addBoardComment('Solution');
				if(!$solutions->getTotalSolutionComments($solutions->getFormField('c_solution_id')))
					{?>
						<script defer="defer" language="javascript" type="text/javascript">
			function hideAddCommentBox()
				{
					var a =  <?php echo $solutions->getFormField('c_solution_id');?>;
					if($Jq("#addComment_"+a))
						{
							$Jq("#addComment_"+a).html('');
							$Jq("#addComment_"+a).attr('className', '');
						}
					else
						$Jq("#addReply_"+a).html('');
				}
			hideAddCommentBox();
		</script>
					<?php }

			}
		else
			{
				$solutions->addBoardComment('Board');
				if(!$solutions->getTotalBoardComments($solutions->getFormField('c_qid'), $solutions->getFormField('c_solution_id')))
					{?>
						<script defer="defer" language="javascript" type="text/javascript">
			function hideAddReplyBox()
				{
					var a =  <?php echo $solutions->getFormField('c_solution_id');?>;
					if($Jq("#addReply_"+a))
						$Jq("#addReply_"+a).html('');
					else
						$Jq("#addComment_"+a).html('');
				}
			hideAddReplyBox();
		</script>
					<?php }
			}
		$solutions->setFormField('success', 'success');
		$solutions->setCommonSuccessMsg($LANG['solution_comments_success']);
		$solutions->setPageBlockShow('block_msg_form_success');
		$solutions->populateAjaxCommentList($solutions->getFormField('c_solution_id'));
		?>
		<script defer="defer" language="javascript" type="text/javascript">
			function hideMsgBox()
				{
					var a =  <?php echo $solutions->getFormField('c_solution_id');?>;

					$Jq("#commentSpanID_"+ a).html('');
				}
			hideMsgBox();
		</script>
		<?php

		$solutions->includeAjaxHeader();
		setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
		$smartyObj->display('commentSolutionsAjax.tpl');
		$solutions->includeAjaxFooter();
		die();

	}
if(!$solutions->getFormField('rid'))
	$solutions->generateRandomId();
// Default page block
$solutions->setAllPageBlocksHide();

$solutions->title = $LANG['open_board'];
$cfg_title = $solutions->title;
$valid_board = false;
if(isAjaxPage())
	{
	$solutions->includeAjaxHeaderSessionCheck();
			if($solutions->isFormGETed($_GET, 'rate'))
			{
				if($solutions->chkAllowBoardRating())
					{
						$solutions->setAllPageBlocksHide();
						//$solutions->checkLoginStatusInAjax($solutions->memberLoginPhotoUrl);
						$solutions->insertBoardRating();
						$solutions->getTotalBoardRatingImage();
						die();
					}
			}
			if($solutions->isFormGETed($_GET, 'solutionrate'))
			{
				if($solutions->chkAllowSolutionRating($solutions->getFormField('aid')))
					{
						$solutions->setAllPageBlocksHide();
						//$solutions->checkLoginStatusInAjax($solutions->memberLoginPhotoUrl);
						$solutions->insertSolutionRating();
						$solutions->getTotalSolutionRatingImage();
						die();
					}
			}
		$solutions->includeAjaxFooter();
		exit;
	}
if ($solutions->chkIsValidBoard())
	{
		if(!$solutions->isValidDiscussionId())
			Redirect2Page(getUrl('discussions', '', '', '', $CFG['admin']['index']['home_module']));


		if ($solutions->isFormGETed($_GET, 'aid'))
			$solutions->chkIsValidSolution();

		$valid_board = true;
		$cfg_title = $solutions->board_details['board'];

		$solutions->setPageBlockShow('form_board');
		$solutions->setPageBlockShow('form_solutions');

		if ($solutions->isFormPOSTed($_REQUEST, 'deletemoreattachments'))
			{
				if (!isMember())
					{
						echo 'Session Expired. <a href="'.$CFG['auth']['login_url']['url'].'?r">Login to continue..!</a>';
						die();
					}
				ob_start();
				$comment_id = $solutions->getFormField('attachment_id');
				$attachment_name = $solutions->getFormField('attachment_name');
				$solutions->deleteMoreAttachments($comment_id, $attachment_name);
				die();
			}

		if ($solutions->isFormPOSTed($_POST, 'update_solution'))
			{
				$solutions->title = $LANG['solutions_edit_your_solution'];
				$cfg_title = $solutions->title;
				$solutions->chkIsNotEmpty('solution', $LANG['err_tip_compulsory']);
				if (!$solutions->isBoardOpen())
					$solutions->setCommonErrorMsg($LANG['solutions_err_not_open']);

				if ($solutions->isValidFormInputs())
					{
						$solution = stripString($solutions->getFormField('solution'), $CFG['admin']['solutions']['limit']);
						$solutions->setFormField('solution', $solution);
						//Update solution details
						$solutions->updateSolution();
						$solutions->setCommonSuccessMsg($LANG['solutions_updated_successfully']);
						$solutions->setPageBlockShow('block_msg_form_success');
						$solutions->setFormField('title', $solutions->board_details['seo_title']);
						$solutions->setFormField('msg', '7');
						$solutions->setFormField('view', '');
						Redirect2Page(getUrl('solutions', '?title='.$solutions->board_details['seo_title'].'&msg=7', $solutions->board_details['seo_title'].'/?msg=7', '', $CFG['admin']['index']['home_module']));
					}
					else
						{
							$solutions->setPageBlockHide('form_board');
							$solutions->setPageBlockHide('form_solutions');
							$solutions->setPageBlockShow('form_add');
							$solutions->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
							$solutions->setPageBlockShow('block_msg_form_error');
						}
			}
		else if ($solutions->isFormPOSTed($_POST, 'confirm_action'))
			{
				switch($solutions->getFormField('action')){
					case 'delete':
						if ($solutions->board_details['user_id'] == $CFG['user']['user_id'])
							{
								$solutions->deleteBoard();
								Redirect2Page(getUrl('boards', '?title='.$solutions->discussion_details['seo_title'].'&msg=3', $solutions->discussion_details['seo_title'].'/?msg=3', '', $CFG['admin']['index']['home_module']));
							}
							else
								{
									$solutions->setAllPageBlocksHide();
									$solutions->setPageBlockShow('block_msg_form_error');
									$solutions->setCommonErrorMsg($LANG['err_tip_invalid_action']);
								}
						break;
					case 'abuseboard':
						$solutions->chkIsNotEmpty('reason', $LANG['err_tip_compulsory']);
						$solutions->title = $LANG['report_abuse'];
						$cfg_title = $solutions->title;
						if ($solutions->isValidFormInputs() and $solutions->board_details['user_id'] != $CFG['user']['user_id'])
							{
								$solutions->updateAbuseBoard();
								$solutions->setPageBlockShow('block_msg_form_success');
								$solutions->setPageBlockShow('form_board');
								$solutions->setPageBlockShow('form_solutions');
								$solutions->setCommonSuccessMsg($LANG['solutions_board_abused_successfully']);
								Redirect2Page(getUrl('solutions', '?title='.$solutions->board_details['seo_title'].'&msg=2', $solutions->board_details['seo_title'].'/?msg=2', '', $CFG['admin']['index']['home_module']));
							}
							else
								{
									$solutions->setPageBlockShow('block_msg_form_error');
								}
						break;
					case 'abusesolution':
						$solutions->chkIsNotEmpty('reason', $LANG['err_tip_compulsory']);
						$solutions->title = $LANG['report_abuse'];
						$cfg_title = $solutions->title;
						$solutions->setFormField('aid', $solutions->getFormField('content_id'));
						$solutions->chkIsValidSolution();
						if ($solutions->isValidFormInputs())
							{
								$solutions->updateAbuseSolution();
								$solutions->setPageBlockShow('block_msg_form_success');
								$solutions->setPageBlockShow('form_board');
								$solutions->setPageBlockShow('form_solutions');
								$solutions->setCommonSuccessMsg($LANG['solutions_solution_abused_successfully']);
								Redirect2Page(getUrl('solutions', '?title='.$solutions->board_details['seo_title'].'&msg=3', $solutions->board_details['seo_title'].'/?msg=3', '', $CFG['admin']['index']['home_module']));
							}
							else
								{
									$solutions->setPageBlockShow('block_msg_form_error');
								}
						break;
					case 'deletesolution':
						$solutions->chkIsNotEmpty('aid', $LANG['err_tip_compulsory'])and
							$solutions->chkIsSolutionOwner($LANG['err_tip_invalid_action']);
						if ($solutions->isValidFormInputs() AND $CFG['admin']['solution']['delete'])
							{
								$solutions->chkIsValidSolution();
								$solutions->deleteSolution();
								$solutions->setPageBlockShow('block_msg_form_success');
								$solutions->setCommonSuccessMsg($LANG['solutions_solution_deleted_successfully']);
								Redirect2Page(getUrl('solutions', '?title='.$solutions->board_details['seo_title'].'&msg=6', $solutions->board_details['seo_title'].'/?msg=6', '', $CFG['admin']['index']['home_module']));
							}
							else
								{
									$solutions->setPageBlockShow('block_msg_form_error');
								}

						break;
					case 'bestsolutions':
						$solutions->chkIsNotEmpty('aid', $LANG['err_tip_compulsory']);
						$solutions->title = $LANG['best_solution'];
						$cfg_title = $solutions->title;
						if ($solutions->isValidFormInputs() and $CFG['user']['user_id'] == $solutions->board_details['user_id'])
							{
								$solutions->updateBestSolution();
								if($solutions->board_details['best_solution_id'])
									{
										$solutions->sendMailToRemovedBestSolutioner($solutions->board_details['best_solution_id']);
										$solution_details = $solutions->getSolutionDetails($solutions->board_details['best_solution_id']);
										$solutions->decreaseBestSolutionPoints($solution_details['user_id']);
									}
								$solutions->setPageBlockShow('block_msg_form_success');
								$solutions->setPageBlockShow('form_board');
								$solutions->setPageBlockShow('form_solutions');
								$solutions->setCommonSuccessMsg($LANG['solutions_best_solution_added_successfully']);
								Redirect2Page(getUrl('solutions', '?title='.$solutions->board_details['seo_title'].'&msg=4', $solutions->board_details['seo_title'].'/?msg=4', '', $CFG['admin']['index']['home_module']));
							}
						else
							{
								$solutions->setPageBlockShow('block_msg_form_error');
							}
						break;
					case 'removebestsolutions':
						$solutions->chkIsNotEmpty('aid', $LANG['err_tip_compulsory']);
						$solutions->title = $LANG['best_solution'];
						$cfg_title = $solutions->title;
						if ($solutions->isValidFormInputs() and $CFG['user']['user_id'] == $solutions->board_details['user_id']  AND $solutions->board_details['best_solution_id'] > 0)
							{
								$solutions->removeBestSolution();
								$solutions->setPageBlockShow('block_msg_form_success');
								$solutions->setPageBlockShow('form_board');
								$solutions->setPageBlockShow('form_solutions');
								$solutions->setCommonSuccessMsg($LANG['solutions_best_solution_removed_successfully']);
								Redirect2Page(getUrl('solutions', '?title='.$solutions->board_details['seo_title'].'&msg=11', $solutions->board_details['seo_title'].'/?msg=11', '', $CFG['admin']['index']['home_module']));
							}
						else
							{
								$solutions->setPageBlockShow('block_msg_form_error');
							}
						break;
					case 'publishsolution':
						$solutions->chkIsNotEmpty('aid', $LANG['err_tip_compulsory']);
						if ($solutions->isValidFormInputs() and $CFG['user']['user_id'] == $solutions->board_details['user_id'] AND $solutions->board_details['publish_status'] == 'No')
							{
								$solutions->publishSolution();
								$solutions->setPageBlockShow('block_msg_form_success');
								$solutions->setPageBlockShow('form_board');
								$solutions->setPageBlockShow('form_solutions');
								$solutions->setCommonSuccessMsg($LANG['solutions_published_successfully']);
								Redirect2Page(getUrl('solutions', '?title='.$solutions->board_details['seo_title'].'&msg=9', $solutions->board_details['seo_title'].'/?msg=9', '', $CFG['admin']['index']['home_module']));
							}
							else
								{
									$solutions->setPageBlockShow('block_msg_form_error');
								}
						break;
				    case 'deletecomment':
								$comment_id = $solutions->getFormField('comment_id');
								$solutions->deleteComment($comment_id);
								$solutions->setPageBlockShow('block_msg_form_success');
								$solutions->setCommonSuccessMsg($LANG['solutions_solution_deleted_successfully']);
								Redirect2Page(getUrl('solutions', '?title='.$solutions->board_details['seo_title'].'&msg=10', $solutions->board_details['seo_title'].'/?msg=10', '', $CFG['admin']['index']['home_module']));

						break;
				} // switch
			}
		else if ($solutions->isFormPOSTed($_POST, 'solution_submit'))
			{
				$solutions->title = $LANG['solutions_what_is_your_solution'];
				$cfg_title = $solutions->title;
				$solutions->chkIsNotEmpty('solution', $LANG['err_tip_compulsory']);
			    if (!$solutions->isAllowedToAsk($solutions->board_details['user_id']))
					$solutions->setCommonErrorMsg($LANG['info_not_allowed_to_ask']);

				if ($solutions->isValidFormInputs())
					{
						$solution = stripString($solutions->getFormField('solution'), $CFG['admin']['solutions']['limit']);
						$solutions->setFormField('solution', $solution);
						$solutions->addSolution();
						$solutions->setCommonSuccessMsg($LANG['solutions_added_successfully']);
						$solutions->setPageBlockShow('block_msg_form_success');
						$solutions->setFormField('title', $solutions->board_details['seo_title']);
						$solutions->setFormField('msg', '1');
						Redirect2Page(getUrl('solutions', '?title='.$solutions->board_details['seo_title'].'&msg=1', $solutions->board_details['seo_title'].'/?msg=1', '', $CFG['admin']['index']['home_module']));
					}
				else
					{
						$solutions->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
						$solutions->setPageBlockShow('block_msg_form_error');
					}
			}

		if ($solutions->isFormGETed($_GET, 'action'))
			{
				if (!isMember())
					Redirect2Page(getUrl('login'));

				switch($solutions->getFormField('action')){
					case 'reply':
								$solutions->setPageBlockHide('form_board');
								$solutions->setPageBlockHide('form_solutions');
								if ($solutions->isAllowedToAsk($solutions->board_details['user_id']))
									$solutions->setPageBlockShow('form_add');
								else
									{
										$solutions->setPageBlockShow('block_msg_form_error');
										$solutions->setCommonErrorMsg($LANG['info_not_allowed_to_ask']);
									}
								$solutions->title = $LANG['solutions_what_is_your_solution'];
								$cfg_title = $solutions->title;

						break;
					case 'edit':
						if ($solutions->isValidFormInputs() AND $solutions->solution_details['user_id'] == $CFG['user']['user_id'])
							{
								$solutions->setPageBlockHide('form_board');
								$solutions->setPageBlockHide('form_solutions');
								$solutions->setPageBlockShow('form_add');

								$solutions->setFormField('solution', $solutions->solution_details['solution']);
								$solutions->setFormField('visible_to', $solutions->solution_details['visible_to']);

								$solutions->title = $LANG['solutions_edit_your_solution'];
								$cfg_title = $solutions->title;
							}
						else
							{
								$solutions->setPageBlockShow('block_msg_form_error');
								$solutions->setCommonErrorMsg($LANG['err_tip_invalid_action']);
							}
						break;
				} // switch
			}
//		if ($solutions->isFormPOSTed($_POST, 'cancel'))
//			{
				 $solutions->solutions_Url =  getUrl('solutions', '?title='.$solutions->board_details['seo_title'], $solutions->board_details['seo_title'].'/', '', $CFG['admin']['index']['home_module']);
				//Redirect2URL(getUrl('solutions', '?title='.$solutions->board_details['seo_title'], $solutions->board_details['seo_title'].'/', '', $CFG['admin']['index']['home_module']));
//			}
		if ($solutions->isFormGETed($_REQUEST, 'msg'))
			{
				switch($solutions->getFormField('msg')){
					case 2:
						$solutions->setCommonSuccessMsg($LANG['solutions_board_abused_successfully']);
						break;
					case 3:
						$solutions->setCommonSuccessMsg($LANG['solutions_solution_abused_successfully']);
						break;
					case 4:
						$solutions->setCommonSuccessMsg($LANG['solutions_best_solution_added_successfully']);
						break;
					case 5:
						$solutions->setCommonSuccessMsg($LANG['solutions_updated_board_successfully']);
						break;
					case 6:
						$solutions->setCommonSuccessMsg($LANG['solutions_solution_deleted_successfully']);
						break;
					case 7:
						$solutions->setCommonSuccessMsg($LANG['solutions_updated_successfully']);
						break;
					case 9:
						$solutions->setCommonSuccessMsg($LANG['solutions_published_successfully']);
						break;
					case 10:
						$solutions->setCommonSuccessMsg($LANG['comments_deleted_successfully']);
						break;
					case 11:
						$solutions->setCommonSuccessMsg($LANG['solutions_best_solution_removed_successfully']);
						break;
					default:
						if($solutions->board_details['publish_status'] == 'No')
							$solutions->setCommonSuccessMsg($LANG['solutions_waiting_for_publish']);
						else
							$solutions->setCommonSuccessMsg($LANG['solutions_added_successfully']);
						break;
				} // switch
				$solutions->setPageBlockShow('block_msg_form_success');
			}

		if($CFG['admin']['discussions']['visibility']['needed'])
			{
				if($solutions->discussion_details['visible_to'] == 'None' and $solutions->discussion_details['user_id'] != $CFG['user']['user_id'])
					{
						$solutions->setAllPageBlocksHide();
						$solutions->setPageBlockShow('block_msg_form_error');
						$solutions->setPageBlockShow('form_invisible_board');
						$solutions->setCommonErrorMsg($LANG['discuzz_common_err_invisible_title']);
					}
				elseif($solutions->discussion_details['visible_to'] == 'Friends' and $solutions->discussion_details['user_id'] != $CFG['user']['user_id'])
					{
						$owner_id = $solutions->discussion_details['user_id'];
						$user_id = $CFG['user']['user_id'];
						if(!$solutions->areMutualFriends($owner_id, $user_id))
							{
								$solutions->setAllPageBlocksHide();
								$solutions->setPageBlockShow('block_msg_form_error');
								$solutions->setPageBlockShow('form_invisible_board');
								$solutions->setCommonErrorMsg($LANG['discuzz_common_err_onlyfriends_title']);
							}
					}
			}

		if($CFG['admin']['friends']['allowed'] and $CFG['admin']['boards']['visibility']['needed'])
			{
						if($solutions->board_details['visible_to'] == 'None' and $solutions->board_details['user_id'] != $CFG['user']['user_id'])
							{
								$solutions->setAllPageBlocksHide();
								$solutions->setPageBlockShow('block_msg_form_error');
								$solutions->setPageBlockShow('form_invisible_board');
								$solutions->setCommonErrorMsg($LANG['discuzz_common_err_invisible_board']);
							}
						elseif($solutions->board_details['visible_to'] == 'Friends' and $solutions->board_details['user_id'] != $CFG['user']['user_id'])
							{
								$owner_id = $solutions->board_details['user_id'];
								$user_id = $CFG['user']['user_id'];
								if(!$solutions->areMutualFriends($owner_id, $user_id))
									{
										$solutions->setAllPageBlocksHide();
										$solutions->setPageBlockShow('block_msg_form_error');
										$solutions->setPageBlockShow('form_invisible_board');
										$solutions->setCommonErrorMsg($LANG['discuzz_common_err_onlyfriends_board']);
									}
							}
			}

		if($CFG['admin']['read_only_board']['allowed'] AND $solutions->getFormField('action') == 'reply')
			{
				if ($solutions->board_details['readonly'] == 'Yes' and $solutions->board_details['user_id'] != $CFG['user']['user_id'])
					{
						$solutions->setAllPageBlocksHide();
						$solutions->setPageBlockShow('block_msg_form_error');
						$solutions->setPageBlockShow('form_invisible_board');
						$solutions->setCommonErrorMsg($LANG['discuzz_common_err_readonly_board']);
					}
			}
		$solutions->confirm['form_action'] = getUrl('solutions', '?title='.$solutions->board_details['seo_title'], $solutions->board_details['seo_title'].'/', '', $CFG['admin']['index']['home_module']);
		$solutions->confirm['onclick_url'] = getUrl('solutions', '?title='.$solutions->board_details['seo_title'].'&amp;tid=1', $solutions->board_details['seo_title'].'/1/?', '', $CFG['admin']['index']['home_module']);
		$board_url = getUrl('solutions', '?title='.$solutions->board_details['seo_title'], $solutions->board_details['seo_title'].'/', '', $CFG['admin']['index']['home_module']);
		$solutions->login = getUrl('login', '?light_url='.$board_url, '?light_url='.$board_url);
	}
else
	{
		$solutions->setCommonErrorMsg($LANG['err_tip_invalid_board']);
		$solutions->setPageBlockShow('block_msg_form_error');
		$cfg_title = '';
	}
//--------------------Page block templates begins-------------------->>>>>//
$CFG['site']['title'] = ($cfg_title)?($cfg_title.' - '.$CFG['site']['title']):$cfg_title;

if ($solutions->isShowPageBlock('form_solutions'))
	{
		if($solutions->getFormField('msg') == '')
		{
			$solutions->updateBoardViews();
		}
		$solutions->setTableNames(array($CFG['db']['tbl']['solutions'].' as a', $CFG['db']['tbl']['users'].' as u'));
		$solutions->setReturnColumns(array('a.solution_id', 'a.user_id', 'a.solution', 'a.rating_total','a.rating_count', 'a.status', 'DATE_FORMAT(solution_added, \''.$CFG['mysql_format']['date_time_meridian'].'\') as date_replied', 'TIMEDIFF(NOW(), solution_added) as date_solutioned', 'u.'.$solutions->getUserTableField('user_id').' as img_user_id', 'u.'.$solutions->getUserTableField('name').' AS name', $solutions->getUserTableField('display_name').' as solutioned_by'));
		$solutions->setFormField('orderby_field', 'a.solution_id');

		$order_col = 'DESC';
		if($CFG['admin']['solution']['order'] != 'DESC')
			$order_col = 'ASC';

		$solutions->setFormField('orderby', $order_col);
		$solutions->buildSelectQuery();
		$solutions->buildConditionQuery();
		$solutions->buildSortQuery();
		$solutions->buildQuery();
		//$solutions->printQuery();
		$solutions->executeQuery();
		$solutions->getViewBestSolutionLink();
		$solutions->form_solutions['displayAllSolutions_arr'] = $solutions->displayAllSolutions();
		if($solutions->CFG['feature']['rewrite_mode'] == 'htaccess')
			$pagingArr = array();
		else
			$pagingArr = array('title');

		$smartyObj->assign('smarty_paging_list', $solutions->populatePageLinksGET($solutions->getFormField('start'), $pagingArr));
	}

$solutions->confirm['hidden_arr1'] = array('action', 'aid', 'comment_id');

$solutions->confirm['hidden_arr2'] = array('start','qid');
$solutions->confirm['hidden_arr'] = array('action', 'content_id');

if ($solutions->isShowPageBlock('form_board'))
	{
		$solutions->form_board['displayBoardDetails_arr'] = $solutions->displayBoardDetails();
		if($CFG['admin']['related_boards']['allowed'])
			$solutions->setPageBlockShow('from_related_boards');
	}

if($CFG['html']['meta']['appendable'] && $valid_board == true)
	{
		$board_category_title = '';//$solutions->getCategoryInfo($cat_ids);
		$text_to_add = html_entity_decode($solutions->board_details['board']);

		$solutions->appendMetaDetails($text_to_add, $board_category_title);
	}
if ($solutions->isShowPageBlock('form_add'))
	{
		$solutions->form_board['displayBoardDetails_arr'] = $solutions->displayBoardDetails();

	}

//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$solutions->includeHeader();
//include the content of the page
setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
$smartyObj->display('solution.tpl');
?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'].$CFG['admin']['index']['home_module'];?>/js/shareDiscussions.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'].$CFG['admin']['index']['home_module'];?>/js/script.js"></script>
<script language="javascript" type="text/javascript">
var photo_ajax_page_loading = '<img alt="<?php echo $LANG['common_photo_loading']; ?>" src="<?php echo $CFG['site']['url'].'photo/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/loading-viewphoto.gif' ?>" \/>';
var photo_site_url = '<?php echo $CFG['site']['discussions_url']; ?>';
var total_rating_images = '<?php echo $CFG['admin']['total_rating']; ?>';
var rateimage_url = '<?php echo $CFG['site']['url'].'discussions/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/icon-boardrate.gif';?>';
var rateimagehover_url = '<?php echo $CFG['site']['url'].'discussions/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/icon-boardratehover.gif';?>';

var divs_array = new Array();
<?php
foreach($solutions->option_divs as $key=>$opt_divs)
	{
?>
		divs_array[<?php echo $key;?>] = '<?php echo $opt_divs;?>';
<?php
	}
?>
var no_need;
var block_arr= new Array('selMsgConfirm', 'selDelMsgConfirm', 'selMsgAbuseConfirm', 'selDelAttachconfirm');
document.getElementsByTagName("body")[0].onclick=function(e)
	{
		for(i=0;i<divs_array.length;i++)
			{
				if(no_need != divs_array[i])
					{
						if($Jq('#'+divs_array[i]))
							$Jq('#'+divs_array[i]).hide();
					}
			}

		no_need = '';
	};

function showHideOptions(opt_div, opt_list)
	{
		no_need = opt_div;
		var optList = opt_list;
		var optDiv = opt_div;
		var ul = document.getElementById(optList);
		var k=0, total_options_li =0;
		while(ul.getElementsByTagName('li')[k++]) total_options_li++;
		if(total_options_li<=0)return false;
		$Jq('#'+optDiv).toggle();
	}

function toggleSolution(spanObj, ansID){
	var moreObj = 'solutionmore'+ansID;
	var lessObj = 'solutionless'+ansID;

	if ($Jq('#'+lessObj).css('display') == 'none'){
		$Jq('#'+moreObj).hide();
		$Jq('#'+lessObj).show();
	}else{
		$Jq('#'+moreObj).show();
		$Jq('#'+lessObj).hide();
	}
	toggleNavBar();
}
var expand = true;
var clicked = true;
var toggleExpandSolutions = function(){
	if (clicked){
		//	clicked = false;
     	for (var i=1; i<=commentsArray.length; i++){
     		moreObj = 'solutionmore'+commentsArray[i];
     		lessObj = 'solutionless'+commentsArray[i];
     		if ($Jq('#'+moreObj)){
     			if (expand){
     					$Jq('#'+moreObj).hide();
     					$Jq('#'+lessObj).show();
     				}else{
     					$Jq('#'+moreObj).show();
     					$Jq('#'+lessObj).hide();
     				}
     		}
     	}
		expand = (expand)?false:true;
		toggleNavBar();
	}
}
var changeClickedStatus = function(){
	toggleNavBar();
	clicked = true;
}

function chkMessage(message,form){
	var comm = document.getElementById(message).value
	if(comm=='' || comm == null)
		{
			alert_manual("Enter Proper messsage");
		}
	else
		return 0;
}
function showQuickSolutionDiv(qid){
	if($Jq('#quickSolutionId_'+qid).css('display') == 'none')
		$Jq('#quickSolutionId_'+qid).css('display', 'block');
	else if($Jq('#quickSolutionId_'+qid).css('display') == 'block')
		$Jq('#quickSolutionId_'+qid).css('display', 'none');
}
</script>
<?php
if(isMember() and $solutions->isShowPageBlock('form_add'))
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
			button_image_url : "<?php echo $CFG['site']['url'].'blank.gif';?>",
			button_placeholder_id : "spanButtonPlaceholder",
			button_width: 140,
			button_height: 24,
			button_text_top_padding: 3,
			button_text : '<span class="button"><?php echo $LANG['discuzz_common_choose_files'];?><span class="buttonSmall"></span></span>',
			button_text_style : '.button { text-align:center; font-family: Helvetica, Arial, sans-serif; font-size: 12pt; font-weight:bold;color:#ffffff;padding-top:5px} .buttonSmall { font-size: 10pt; }',			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
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
//include the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$solutions->includeFooter();
?>
