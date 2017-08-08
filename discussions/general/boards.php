<?php
//-------------- Class LoginFormHandler begins --------------->>>>>//
/**
 *
 * List all boards
 *
 * @category	Discuzz
 * @package		BoardFormHandler
 * @author 		senthil_52ag05
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2008-12-22
 */
class BoardFormHandler extends DiscussionHandler
	{
		public $discussion_details = array();
		public $board_details = array();
		public $user_details = array();
		public $sql_condition;
		public $solution_attachment_count = 0;
		public $pagingArr = array();
		public $category_titles;
		public $allCategories_arr;
		public $valid_subcategory_array;
		public $iscatgry_not_restricted = false;
		/**
		* BoardFormHandler :: setDiscussionsActivityObject
		* Set the DisucssionsActivityObj
		*/
		public function setDiscussionsActivityObject($discussionsActivityObj)
			{
				$this->discussionsActivityObj = $discussionsActivityObj;
			}
		/**
		 * BoardFormHandler::storeSearchFields()
		 *
		 * @return
		 */
		public function storeSearchFields()
			{
				$allowed_fields_arr = array(
										'more_boards'=>$this->fields_arr['more_boards'],
										'type'=>$this->fields_arr['type'],
										'dname'=>$this->fields_arr['dname'],
										'cat_id'=>$this->fields_arr['cat_id'],
										'cid'=>$this->fields_arr['cid'],
										'total_solution_from'=>$this->fields_arr['total_solution_from'],
										'total_solution_to'=>$this->fields_arr['total_solution_to'],
										'date_limits_to'=>$this->fields_arr['date_limits_to'],
										'discussion_category'=>$this->fields_arr['discussion_category'],
										'with_solution'=>$this->fields_arr['with_solution'],
										);
				$allowed_fields_arr = serialize($allowed_fields_arr);

				if($this->CFG['user']['user_id'] != 0)
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['advanced_search'].' SET'.
								' solution = '.$this->dbObj->Param('solution').' WHERE'.
								' user_id = '.$this->dbObj->Param('user_id');
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($allowed_fields_arr, $this->CFG['user']['user_id']));
						    if (!$rs)
							    trigger_db_error($this->dbObj);
					}
				else
					{
						$_SESSION['advanced_search_values'] = 	$allowed_fields_arr;
					}

					//for text with & symbol fix..
					$_SESSION['more_boards'] = $this->fields_arr['more_boards'];
			}

		/**
		 * BoardFormHandler::populateSearchFields()
		 *
		 * @return
		 */
		public function populateSearchFields()
			{
				if($this->fields_arr['so']=='adv')
					{
						if($this->CFG['user']['user_id'] != 0)
							{

								$sql = 'SELECT solution FROM '.$this->CFG['db']['tbl']['advanced_search'].
										' WHERE user_id='.$this->dbObj->Param('user_id');
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
								    if (!$rs)
									    trigger_db_error($this->dbObj);

								if($row = $rs->FetchRow())
									{
										if($row['solution'])
											{
												$search_fields_arr = unserialize($row['solution']);
												$this->fields_arr = array_merge($this->fields_arr, $search_fields_arr);
											}
									}
							}
						else
							{
								if(isset($_SESSION['advanced_search_values']) and !empty($_SESSION['advanced_search_values']))
									{
											$search_fields_arr = unserialize($_SESSION['advanced_search_values']);
											$this->fields_arr = array_merge($this->fields_arr, $search_fields_arr);
									}
							}
						//for text with & symbol fix..
						$_SESSION['more_boards'] = $this->fields_arr['more_boards'];
					}
			}
		/**
		 * BoardFormHandler::buildConditionQuery()
		 *
		 * @return
		 */
		public function buildConditionQuery()
			{
				if($this->sql_condition)
					return $this->sql_condition;

				$this->sql_condition = 'b.user_id=u.'.$this->getUserTableField('user_id').' AND u.'.$this->getUserTableField('user_status').'=\'Ok\'';

				if ($this->fields_arr['unpublished'] AND $this->discussion_details['user_id'] == $this->CFG['user']['user_id'])
					{
						$this->pagingArr[] = 'unpublished';
						$this->sql_condition .= ' AND (b.status = \'ToActivate\')';
					}
				else
					{
						$this->sql_condition .= ' AND (b.status = \'Active\')';
					}


				$condition = '';
				if($this->fields_arr['view'])
					{
						$this->pagingArr[] = 'view';
					}
				if ($this->fields_arr['view'] == 'best')
					{
						$condition = ' AND b.best_solution_id != 0';
						$condition .= ' AND EXISTS(SELECT 1 FROM '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c, '.$this->CFG['db']['tbl']['users'].' AS ud WHERE d.pcat_id=c.cat_id AND c.status=\'Active\' AND d.user_id = ud.'.$this->getUserTableField('user_id').' AND ud.'.$this->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id = b.discussion_id  AND d.status = \'Active\')';
					}
				if ($this->fields_arr['view'] == 'featured')
					{
						$condition = ' AND b.featured = \'Yes\'';
						$condition .= ' AND EXISTS(SELECT 1 FROM '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c, '.$this->CFG['db']['tbl']['users'].' AS ud WHERE d.pcat_id=c.cat_id AND c.status=\'Active\' AND d.user_id = ud.'.$this->getUserTableField('user_id').' AND ud.'.$this->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id = b.discussion_id  AND d.status = \'Active\')';
					}

				if ($this->fields_arr['view'] == 'popular')
					{
						$condition = ' AND total_views > 0 AND latest_viewed >= DATE_SUB(NOW(), INTERVAL '.$this->CFG['admin']['popular_days']['limit'].' DAY)';
						$condition .= ' AND EXISTS(SELECT 1 FROM '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c, '.$this->CFG['db']['tbl']['users'].' AS ud WHERE d.pcat_id=c.cat_id AND c.status=\'Active\' AND d.user_id = ud.'.$this->getUserTableField('user_id').' AND ud.'.$this->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id = b.discussion_id  AND d.status = \'Active\')';
					}

				if ($this->fields_arr['view'] == 'recent' || $this->fields_arr['view'] == 'recentlysolutioned')
					{
						$condition .= ' AND EXISTS(SELECT 1 FROM '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c, '.$this->CFG['db']['tbl']['users'].' AS ud WHERE d.pcat_id=c.cat_id AND c.status=\'Active\' AND d.user_id = ud.'.$this->getUserTableField('user_id').' AND ud.'.$this->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id = b.discussion_id  AND d.status = \'Active\')';
					}

				if ($this->fields_arr['view'] == 'related' || $this->fields_arr['bid'] != '')
					{
						$board_words = explode(" ", $this->board_details['search_title']);
						$board_words = array_trim($board_words);

						$where_search = '';
						foreach($board_words as $index=>$values)
							{
								if($values != '')
									$where_search .= getSearchBoardExpressionQuery($values, 'search_title').' OR';
							}
						if($where_search != '')
							{
								$where_search = substr($where_search, 0, strlen($where_search)-2);
								$where_search = ' AND ('.$where_search.')';
								$condition .= $where_search;
							}
					}

				if ($this->fields_arr['did'] != '')
					{
						$this->sql_condition .= ' AND b.discussion_id = '.$this->getFormField('did');
						$this->pagingArr[] = $this->fields_arr['did'];
					}

				if ($this->fields_arr['al'])
					{
						$this->pagingArr[] = 'al';
						$case = strtolower(addslashes($this->fields_arr['al']));
						switch($case)
							{
								case '1':
									$condition .= ' AND (board REGEXP \'^[^a-z]\')';
									break;
								case 'all':
									break;
								default:
									$not_allowed_search_array = $this->CFG['admin']['not_allowed_chars'];
									$case = replaceCharacter($not_allowed_search_array, '-', $case);
									$case = addslashes($case);
									$condition .= ' AND (board REGEXP \'^'.$case.'\')';
							}
					}

				$search_conditon = '';
				$search_array = array();

				if ($this->fields_arr['search_board'] && ($this->fields_arr['search_board'] != $this->LANG['search_for_boards']))
					{
						if (strlen($this->getFormField('search_board')) > 1)
			                $search_array = $this->filterWordsForSearching($this->getFormField('search_board'));
			            //if (!$search_array)
			              //  $valid_search_text = false;
						$this->pagingArr[] = 'search_board';
					}

				if ($this->fields_arr['more_boards']) {
		            if (strlen($this->getFormField('more_boards')) > 1)
		                $search_array = $this->filterWordsForSearching($this->getFormField('more_boards'));
		            	//if (!$search_array)
		              		//$valid_search_text = false;
		            $this->pagingArr[] = 'more_boards';
		        }
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
		                $where_search = ' AND (' . $where_search . ')';
		                $search_conditon .= $where_search;
		            }
		        }
				/*
				if ($this->fields_arr['more_boards']){
					$search_conditon .= ' AND '.getSearchBoardExpressionQuery($this->fields_arr['more_boards'], 'search_title');
					$this->pagingArr[] = 'more_boards';
				}
				*/
				if ($this->fields_arr['dname']){
					$this->pagingArr[] = 'dname';
					$search_conditon .= ' AND ('.getSearchRegularExpressionQuery($this->fields_arr['dname'], 'u.'.$this->getUserTableField('display_name'));
					$search_conditon .= ' OR EXISTS(SELECT 1 FROM '.$this->CFG['db']['tbl']['solutions'].' as s, '.$this->CFG['db']['tbl']['users'].' as us'.
										' WHERE us.'.$this->getUserTableField('user_id').'=s.user_id AND s.board_id=b.board_id AND '.getSearchRegularExpressionQuery($this->fields_arr['dname'], 'us.'.$this->getUserTableField('display_name').'').'))';

				}

				if ($this->fields_arr['uname']){
					$this->pagingArr[] = 'uname';
					$search_conditon .= ' AND u.'.$this->getUserTableField('name').' LIKE \''.addslashes($this->fields_arr['uname']).'\'';
				}

				$this->pagingArr[] = 'with_solution';

				if ($this->fields_arr['with_solution'] == 3)
					$search_conditon .= ' AND (b.best_solution_id!=0)';
				else if ($this->fields_arr['with_solution']==2)
					$search_conditon .= ' AND b.total_solutions=0';
				else if($this->fields_arr['with_solution']==1)
					$search_conditon .= ' AND b.total_solutions > 0';

				if ($this->fields_arr['total_solution_from'] >= 0 && $this->fields_arr['total_solution_from']!=''
						&& $this->fields_arr['total_solution_to']>=0 && $this->fields_arr['total_solution_to']!='')
						{
							$total_solution_to = $this->fields_arr['total_solution_to'];
							$total_solution_from = $this->fields_arr['total_solution_from'];
							if ($total_solution_to < $total_solution_from)
								{
									$total_solution_to = $this->fields_arr['total_solution_from'];
									$total_solution_from = $this->fields_arr['total_solution_to'];
								}
							$search_conditon .= ' AND total_solutions>=\''.addslashes($total_solution_from).'\'';
							$search_conditon .= ' AND total_solutions<=\''.addslashes($total_solution_to).'\'';
							$this->pagingArr[] = 'total_solution_from';
							$this->pagingArr[] = 'total_solution_to';
						}

				$date_condtion = '';
				$this->pagingArr[] = 'date_limits_to';
				switch($this->fields_arr['date_limits_to'])
					{
						case $this->LANG['search_option_today']:
							$date_condtion = 'DATE(b.board_added) = date(NOW())';
							break;
						case $this->LANG['search_option_oneday']:
							$date_condtion = 'DATE_ADD(b.board_added, INTERVAL 1 DAY) >= NOW()';
							break;
						case $this->LANG['search_option_oneweek']:
							$date_condtion = 'DATE_ADD(b.board_added, INTERVAL 7 DAY) >= NOW()';
							break;
						case $this->LANG['search_option_onemonth']:
							$date_condtion = 'DATE_ADD(b.board_added, INTERVAL 1 MONTH) >= NOW()';
							break;
						case $this->LANG['search_option_threemonths']:
							$date_condtion = 'DATE_ADD(b.board_added, INTERVAL 3 MONTH) >= NOW()';
							break;
						case $this->LANG['search_option_sixmonths']:
							$date_condtion = 'DATE_ADD(b.board_added, INTERVAL 6 MONTH) >= NOW()';
							break;
						case $this->LANG['search_option_oneyear']:
							$date_condtion = 'DATE_ADD(b.board_added, INTERVAL 1 YEAR) >= NOW()';
							break;
					}

				if($date_condtion)
					$search_conditon .= ' AND '.$date_condtion;

				if ($this->fields_arr['type'])
					{
						$this->pagingArr[] = 'type';
						switch($this->fields_arr['type'])
							{

								case 'with Best Solutions':
									$search_conditon .= ' AND (b.best_solution_id!=0)';
									break;
								case 'Recently Solutioned':
									$search_conditon .= ' AND (b.total_solutions>0)';
									break;
								case 'Popular':
									$search_conditon .= ' AND total_views > 0 AND latest_viewed >= DATE_SUB(NOW(), INTERVAL '.$this->CFG['admin']['popular_days']['limit'].' DAY)';
									break;
							} // switch
					}

				if($this->fields_arr['discussion_category'] && $this->fields_arr['discussion_category']!='EMPTY')
					{
						$this->pagingArr[] = 'discussion_category';
						$search_arr = explode('#', $this->fields_arr['discussion_category']);

						if(isset($search_arr[1]) AND $search_arr[1]!=0)
							{
								$sub_cat_id = $search_arr[1];
								$this->valid_subcategory_array[] = $sub_cat_id;
								$this->getSubCategoriesList($sub_cat_id);
								$sub_cat_ids = implode(",", $this->valid_subcategory_array);
								$search_conditon .= ' AND EXISTS(SELECT 1 FROM '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c WHERE d.pcat_id=c.cat_id AND c.status=\'Active\' AND d.discussion_id = b.discussion_id AND d.pcat_id IN ('.$sub_cat_ids.') )';
							}
						else{
								$search_arr = explode(',', $this->fields_arr['discussion_category']);
								if(isset($search_arr[1]) AND $search_arr[1]!=0)
									$search_conditon .= ' AND b.discussion_id='.$search_arr[1];
						}
					}

				if ($search_conditon)
					{
						$search_conditon .= ' AND EXISTS(SELECT 1 FROM '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c, '.$this->CFG['db']['tbl']['users'].' AS ud WHERE d.pcat_id=c.cat_id AND c.status=\'Active\' AND d.user_id = ud.'.$this->getUserTableField('user_id').' AND ud.'.$this->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id = b.discussion_id  AND d.status = \'Active\')';
						$this->sql_condition .= $search_conditon;
					}
				else
					$this->sql_condition .= $condition;

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
						$row = $rs->FetchRow();
						$cat_id = $row['cat_id'];
						$this->valid_subcategory_array[] = $cat_id;
						$this->getSubCategoriesList($row['cat_id']);
					}
			}

		/**
		 * BoardFormHandler::buildSortQuery()
		 *
		 * To sort the query
		 * @access public
		 * @return void
		 */
		public function buildSortQuery()
			{
				$append_condition = '';
				if($this->fields_arr['orderby_field'] == 'total_solutions')
					$append_condition = ' board_id'.' '.$this->fields_arr['orderby'].', ';

				if ($this->fields_arr['sort'] == 'lp')
					{
						$append_condition = ' solution_added'.' ';
						if ($this->fields_arr['order'] == 'a')
							$append_condition .= 'ASC, ';
						else
							$append_condition .= 'DESC, ';
					}

				if (!$this->isFormPOSTed($_POST, 'orderby_field'))
				{
					if($this->fields_arr['view'] == 'recentlysolutioned' || $this->fields_arr['type'] == 'Recently Solutioned' )
						{
							$this->fields_arr['orderby_field'] = 'solution_added';
						}
					if($this->fields_arr['view'] == 'popular' || $this->fields_arr['type'] == 'Popular' )
						{
							$this->fields_arr['orderby_field'] = 'total_views';
						}
					if($this->fields_arr['view'] == 'recent')
						{
							$this->fields_arr['orderby_field'] = 'board_id';
						}
				}
				$this->sql_sort = $append_condition.' '.$this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}

		/**
		 * BoardFormHandler::displayCategoryName()
		 *
		 * @param string $parent_id
		 * @return
		 */
		public function displayCategoryName($parent_id='')
		    {
				if ($this->fields_arr['cat'])
					{
						if($parent_id)
							{
								$cid = $parent_id;
								$sql = 'SELECT cat_name,seo_title FROM '.$this->CFG['db']['tbl']['category'].' WHERE cat_id='.$this->dbObj->Param('cat');
							}
						else
							{
								$cid = $this->fields_arr['cat'];
								$sql = 'SELECT cat_name,parent_id FROM '.$this->CFG['db']['tbl']['category'].' WHERE seo_title='.$this->dbObj->Param('cat');
							}
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($cid));
						if (!$rs)
							    trigger_db_error($this->dbObj);
						if ($rs->PO_RecordCount())
							{
								$row = $rs->FetchRow();
								return $row;
							}
					}
				return false;
		    }

		/**
		 * BoardFormHandler::chkIsValidBoard()
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
				$sql = 'SELECT b.board_id, b.discussion_id, b.total_solutions, b.visible_to, b.best_solution_id, b.description, b.total_stars, b.search_word'.
						', b.board, b.seo_title, TIMEDIFF(NOW(), board_added) as board_added, b.status, b.publish_status, b.readonly, b.total_views, b.user_id, b.tags'.
						', IF(status=\'Active\', 1, 0) is_open'.
						' FROM '.$this->CFG['db']['tbl']['boards'].' AS b'.
						' WHERE b.status IN (\'Active\')'.
						' AND b.board_id='.$this->dbObj->Param('bid');

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
				$this->board_details['board_title'] = stripString($this->board_details['board']);
				$this->navigation_details['discussion_url'] = '<a href="'.getUrl('boards','?title='.$this->discussion_details['seo_title'], $this->discussion_details['seo_title'].'/','',$this->CFG['admin']['index']['home_module']).'">'.stripString($this->discussion_details['discussion_title']).'</a>';
				if (!$this->board_details['is_open'])
					{
						$this->setCommonErrorMsg($this->LANG['boards_err_not_open_board']);
						return false;
					}
				return true;
		    }

		/**
		 * BoardFormHandler::displayOpenAndResolvedLinks()
		 *
		 * @return
		 */
		public function displayOpenAndResolvedLinks()
		    {
				$displayOpenAndResolvedLinks_arr = array();
				$cidQryN = $cidQryH = '';
				if ($this->fields_arr['cat'])
					{
						$cidQryN .= 'cat='.$this->fields_arr['cat'].'&amp;';
						$cidQryH .= 'cat='.$this->fields_arr['cat'].'&amp;';
					}
				if ($this->fields_arr['al'])
					{
						$cidQryN .= 'al='.$this->fields_arr['al'].'&amp;';
						$cidQryH .= 'al='.$this->fields_arr['al'].'&amp;';
					}
				if ($this->fields_arr['related_board'])
					{
						$cidQryN .= 'related_board='.$this->fields_arr['related_board'].'&amp;';
						$cidQryH .= 'related_board='.$this->fields_arr['related_board'].'&amp;';
					}
				if ($cidQryH)
					$cidQryH = '?'.$cidQryH;
				if ($cidQryN)
					$cidQryN = '&amp;'.$cidQryN;

				$displayOpenAndResolvedLinks_arr['recentlysolutionedLI'] = $displayOpenAndResolvedLinks_arr['recentlysolutionedSPAN'] = $displayOpenAndResolvedLinks_arr['recentlysolutionedA'] = '';
				$clsActiveLinksLeft = 'clsActiveLinksLeft';
				$clsActiveLinksRight = 'clsActiveLinksRight';
				$clsActiveLinksMiddle = 'clsActiveLinksMiddle';
				if ($this->fields_arr['view'] == 'recentlysolutioned')
					{
						$displayOpenAndResolvedLinks_arr['recentlysolutionedLI'] = $clsActiveLinksLeft;
						$displayOpenAndResolvedLinks_arr['recentlysolutionedSPAN'] = $clsActiveLinksRight;
						$displayOpenAndResolvedLinks_arr['recentlysolutionedA'] = $clsActiveLinksMiddle;
					}


				$displayOpenAndResolvedLinks_arr['recentlysolutioned']['url'] = getUrl('boards', '?view=recentlysolutioned'.$cidQryN, 'recentlysolutioned/'.$cidQryH, '', $this->CFG['admin']['index']['home_module']);

				return $displayOpenAndResolvedLinks_arr;
		    }

		/**
		 * BoardFormHandler::displayRecentAndPopularLinks()
		 *
		 * @return
		 */
		public function displayRecentAndPopularLinks()
		    {
				$displayRecentAndPopularLinks_arr = array();
				$displayRecentAndPopularLinks_arr['recentBoardsLI'] = $displayRecentAndPopularLinks_arr['popularBoardsLI'] = '';
				$displayRecentAndPopularLinks_arr['recentBoardsSPAN'] = $displayRecentAndPopularLinks_arr['popularBoardsSPAN'] = '';
				$displayRecentAndPopularLinks_arr['recentBoardsA'] = $displayRecentAndPopularLinks_arr['popularBoardsA'] = '';
				$clsActiveLinksLeft = 'clsActiveLinksLeft';
				$clsActiveLinksRight = 'clsActiveLinksRight';
				$clsActiveLinksMiddle = 'clsActiveLinksMiddle';

				if ($this->fields_arr['view'] == 'recent')
					{
						$displayRecentAndPopularLinks_arr['recentBoardsLI'] = 'clsFirstBoardLink clsLeftActiveBoardsLink';
						$displayRecentAndPopularLinks_arr['recentBoardsSPAN'] = $clsActiveLinksRight;
						$displayRecentAndPopularLinks_arr['recentBoardsA'] = $clsActiveLinksMiddle;
					}
				elseif ($this->fields_arr['view'] == 'popular')
					{
						$displayRecentAndPopularLinks_arr['popularBoardsLI'] = $clsActiveLinksLeft;
						$displayRecentAndPopularLinks_arr['popularBoardsSPAN'] = $clsActiveLinksRight;
						$displayRecentAndPopularLinks_arr['popularBoardsA'] = $clsActiveLinksMiddle;
					}

				$titleQry = '';
				if($this->fields_arr['title'])
					$titleQry = '&title='.$this->fields_arr['title'];

				$displayRecentAndPopularLinks_arr['boards_recent']['url'] = getUrl('boards', '?view=recent'.$titleQry, 'recent/'.$titleQry, '', $this->CFG['admin']['index']['home_module']);
				$displayRecentAndPopularLinks_arr['boards_popular']['url'] = getUrl('boards', '?view=popular'.$titleQry, 'popular/'.$titleQry, '', $this->CFG['admin']['index']['home_module']);

				return $displayRecentAndPopularLinks_arr;
		    }

		/**
		 * BoardFormHandler::populateBoardType()
		 *
		 * @param string $highlight_type
		 * @return
		 */
		public function populateBoardType($highlight_type='')
			{
				$populateBoardType_arr = array();
				$type_array = array('All'=> $this->LANG['search_type_all'],
									'with Best Solutions'=> $this->LANG['search_type_with_best_solution'],
									'Recently Solutioned'=> $this->LANG['search_type_recently_solutioned'],
									'Popular'=> $this->LANG['boards_popular']);

				foreach($type_array as $option=>$eachType)
					{
						$populateBoardType_arr[$option] = $eachType;
					}
				return $populateBoardType_arr;
			}
		/**
		 * BoardFormHandler::displayAllBoards()
		 *
		 * @return
		 */
		public function displayAllBoards()
			{
				global $smartyObj;

				if($this->CFG['feature']['rewrite_mode'] != 'htaccess')
					$this->pagingArr[] = 'view';
				if ($this->getFormField('sort'))
					$this->pagingArr[] = 'sort';
				if ($this->getFormField('title'))
					$this->pagingArr[] = 'title';
				if ($this->getFormField('order'))
					$this->pagingArr[] = 'order';

				$sortQry = '';
				$search_options = array('search_board', 'so', 'adv_search', 'more_boards', 'type', 'uname', 'dname',
										'tags', 'total_solution_from',
										'total_solution_to','al', 'opt');

				foreach($search_options as $eachOption)
					{
						if ($this->fields_arr[$eachOption])
							{
								if ($eachOption == 'more_boards' || $eachOption == 'search_board')
								$this->setFormField($eachOption, preg_replace('/[?]/','',$this->fields_arr[$eachOption]));
								//$this->setFormField($eachOption, ereg_replace('[?]','',$this->fields_arr[$eachOption]));
								$this->pagingArr[] = $eachOption;
								$sortQry .= '&amp;'.$eachOption.'='.$this->fields_arr[$eachOption];
							}
					}

				$view = $this->fields_arr['view'];
				$sort = $this->fields_arr['sort'];
				$order = $this->fields_arr['order'];
				$dateOrder = $ansOrder = 'a';
                $this->clsDate = $this->clsSolution = '';

				if ($this->isShowPageBlock('form_all_boards') AND $this->isResultsFound())
					{
						$reverseOrder = ($order=='a')?'d':'a';
						$dateOrder = $ansOrder = 'd';
						$this->ansOrderClass = $this->date_alt = $this->ans_alt = '';
						$this->dateOrderClass = 'clsAscDesc';
						$orderByClass = ($order=='a')?'clsAsc':'clsDsc';

						if ($sort == 'lp')
							{
								$dateOrder = $reverseOrder;
								$this->clsDate = 'clsActiveViewByLink';
								$this->dateOrderClass = $orderByClass;
							}

						$this->date_alt = 'title="'.$this->LANG['boards_sortby_lastpost_date'].'"';
						$view = ($view)?$view:$this->fields_arr['title'];
						$this->unsolutioned_boards_url = getUrl('boards', '?view='.$view.'&amp;sort=lp&amp;order='.$dateOrder.$sortQry, $view.'/?sort=lp&amp;order='.$dateOrder.$sortQry, '', $this->CFG['admin']['index']['home_module']);
					}

				if (!$this->isResultsFound())
					{
						$this->site_name_manual =  '';
						$this->boards_ask_url = getUrl('boards', '?view=ask&amp;title='.$this->fields_arr['title'], 'ask/?title='.$this->fields_arr['title'], '', $this->CFG['admin']['index']['home_module']);
						return ;
					}
				if($this->fields_arr['tags'])
					{
						$this->updateSearchCount($this->fields_arr['tags']);
					}
				$displayAllBoards_arr = array();
				$req_arr = array('img_path', 'gender', 't_height', 't_width', 's_height', 's_width', 'photo_server_url', 'photo_ext');
				$i = 0;
				$inc=1;

				while($row = $this->fetchResultRecord())
					{
						$i++;
						//getting user info..
						$user_info_details_arr = getUserInfoDetails($req_arr, 'user_id', $row['user_id']);
						$displayAllBoards_arr[$inc]['record'] = array_merge($row, $user_info_details_arr);
						$displayAllBoards_arr[$inc]['last_post_by'] = '<a href="'.getMemberUrl($row['last_post_by'], $row['last_post_user']).'">'.$row['last_post_name'].'</a>';
						$displayAllBoards_arr[$inc]['last_post_on'] = $row['last_post_date'];

						$displayAllBoards_arr[$inc]['clsOddOrEvenBoard'] = 'clsEvenBoard';
						if ($i%2)
							$displayAllBoards_arr[$inc]['clsOddOrEvenBoard'] = 'clsOddBoard';

						$displayAllBoards_arr[$inc]['boldClass'] = 'clsNormal';
						if ($this->display_bold < ($i+1))
							$displayAllBoards_arr[$inc]['boldClass'] = 'clsBold';

						$row['isNewPost'] = $this->chkIsNewPostOnthisBoard($this->CFG['user']['user_id'], $this->CFG['remote_client']['ip'], $row['board_id'], $row['solution_added']);

						$displayAllBoards_arr[$inc]['iconClass'] = $displayAllBoards_arr[$inc]['bestAnsClass'] = '';

						$displayAllBoards_arr[$inc]['bestIcon'] = $displayAllBoards_arr[$inc]['legendIcon'] = '';

						$displayAllBoards_arr[$inc]['appendIcon'] = ' clsAppendNoNewThread';
						if($row['isNewPost'])
							$displayAllBoards_arr[$inc]['appendIcon'] = ' clsAppendNewThread';

						if($row['best_solution_id'])
							{
								$displayAllBoards_arr[$inc]['bestIcon'] = '<img alt="" src="'.$this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['discussion_file'].'/icon-bestsolutionsmall.gif" />';
							}
						if($row['readonly'] == 'Yes')
							{
								$displayAllBoards_arr[$inc]['legendIcon'] = 'clsIconROThread';
							}
						elseif($row['total_solutions'] >= $this->CFG['admin']['hot_board']['limit'])
							{
								$displayAllBoards_arr[$inc]['legendIcon'] = 'clsIconHotThread';
							}
						elseif(isMember() and $this->myPostIncludedBoard($row['board_id']))
							{
								$displayAllBoards_arr[$inc]['legendIcon'] = 'clsIconMyThread';
							}
						elseif($row['isNewPost'])
							{
								$displayAllBoards_arr[$inc]['legendIcon'] = 'clsIconNewThread';
							}
						else
							{
								$displayAllBoards_arr[$inc]['legendIcon'] = 'clsIconNoNewThread';
							}

						$displayAllBoards_arr[$inc]['attach_class'] = '';
						if($this->hasAnyAttachment($row['board_id'],'Board'))
							$displayAllBoards_arr[$inc]['attach_class'] = 'clsBoardAttachment';
						$displayAllBoards_arr[$inc]['solution']['url'] = getUrl('solutions', '?title='.$row['seo_title'], $row['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']);
						$displayAllBoards_arr[$inc]['row_board_manual'] = wordWrapManual($row['board'], $this->CFG['admin']['board']['line_length'], $this->CFG['admin']['board']['short_length']);
						$displayAllBoards_arr[$inc]['solution_plural'] = $this->LANG['discuzz_common_total_solution'];
						$displayAllBoards_arr[$inc]['views_plural'] = $this->LANG['discuzz_common_total_view'];

						if($row['total_solutions']!= 1) $displayAllBoards_arr[$inc]['solution_plural'] = $this->LANG['solutions'];
						if($row['total_views']!= 1) $displayAllBoards_arr[$inc]['views_plural'] = $this->LANG['discuzz_common_total_views'];
						$displayAllBoards_arr[$inc]['mysolutions']['url'] = getMemberUrl($row['user_id'], $row['name']);
						$displayAllBoards_arr[$inc]['row_asked_by_manual'] = stripString($row['asked_by'], $this->CFG['username']['short_length']);

						if($row['last_post_user'])
							$displayAllBoards_arr[$inc]['last_post_by'] = '<a href="'.getMemberUrl($row['last_post_by'], $row['last_post_user']).'">'.stripString($row['last_post_name'], $this->CFG['username']['medium_length']).'</a>';
						else
							$displayAllBoards_arr[$inc]['last_post_by'] = '';

						$displayAllBoards_arr[$inc]['solution_members']['url'] = getUrl('solutions', '?title='.$row['seo_title'], $row['seo_title'].'/', 'members', $this->CFG['admin']['index']['home_module']);
						$displayAllBoards_arr[$inc]['login_solution']['url'] = getUrl('login', '?light_url='.$displayAllBoards_arr[$inc]['solution_members']['url'], '?light_url='.$displayAllBoards_arr[$inc]['solution_members']['url'], 'root');
						$inc++;
					} // while
				//$smartyObj->assign('smarty_paging_list', $this->populatePageLinksGET($this->getFormField('start'), $pagingArr));
				return $displayAllBoards_arr;
			}

		/**
		 * BoardFormHandler::askBoards()
		 *
		 * @return
		 */
		public function askBoards()
		    {
				global $QUES_SUGG_LANG ;
				$askBoards_arr = array();
				//form action url
				$askBoards_arr['form_action_url'] = $_SERVER['REQUEST_URI'];

				$this->LANG['discuzz_common_tag_size'] = str_ireplace('VAR_MIN_SIZE', $this->CFG['admin']['tag_min_size'], $this->LANG['discuzz_common_tag_size']);
				$this->LANG['discuzz_common_tag_size'] = str_ireplace('VAR_MAX_SIZE', $this->CFG['admin']['tag_max_size'], $this->LANG['discuzz_common_tag_size']);

				if($this->CFG['admin']['board']['point_notification'] && $this->CFG['admin']['ask_solutions']['allowed'] && !$this->fields_arr['bid'])
					{
						 $askBoards_arr['earn_points_details_info'] = str_ireplace('VAR_POINTS', $this->CFG['admin']['ask_solutions']['points'], $this->LANG['boards_earn_points_details_info']);
					}

				$askBoards_arr['populateHidden_arr'] = array('rid', 'did');

				if ($this->fields_arr['bid'])
					{
						$askBoards_arr['board_manual'] = wordWrapManual($this->getFormField('board'), 40);
					}

			   if ($this->fields_arr['bid'])
					{
						$askBoards_arr['getAttachments_arr'] = $this->getAttachments();
					}

				$allowed_formats = implode(",",$this->CFG['admin']['attachments']['format_arr']);
				if($allowed_formats == '')
					$allowed_formats = 'jpg,gif,png';
				$allowed_size = $this->CFG['admin']['attachments']['max_size'];

				$askBoards_arr['attach_style'] = '';
				if($this->solution_attachment_count == $this->CFG['admin']['attachments_allowed']['count'])
					$askBoards_arr['attach_style'] = 'style="display:none;"';

				  $askBoards_arr['attachment_allowed_tip_manual'] = str_ireplace('VAR_COUNT', $this->CFG['admin']['attachments_allowed']['count'] ,$this->LANG['attachment_allowed_tip']);
				  $askBoards_arr['attachment_format_tip_manual'] = str_ireplace('VAR_FORMAT', $allowed_formats, $this->LANG['attachment_format_tip']);
  				  $askBoards_arr['attachment_size_tip_manual'] = str_ireplace('VAR_SIZE', $allowed_size, $this->LANG['attachment_size_tip']);
			      $askBoards_arr['descriptions_manual'] = stripslashes($this->getFormField('descriptions'));

				return $askBoards_arr;
		    }

		/**
		 * BoardFormHandler::getAttachments()
		 *
		 * @return
		 */
		public function getAttachments()
			{
				$getAttachments_arr = array();
				$sql = 'SELECT attachment_id, attachment_name FROM '.$this->CFG['db']['tbl']['attachments'].
					' WHERE content_id='.$this->dbObj->Param($this->fields_arr['bid']).' AND content_type=\'Board\' ORDER BY date_added';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['bid']));
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

								$getAttachments_arr[$inc]['anchor'] = 'seldel_'.$row['attachment_id'];
								$getAttachments_arr[$inc]['attachment']['url'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$getAttachments_arr[$inc]['attachment_file_name'];
								$getAttachments_arr[$inc]['attachment']['url_thumb'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$getAttachments_arr[$inc]['attachment_file_name_thumb'];
								$getAttachments_arr[$inc]['extern'] = $extern;
								$getAttachments_arr[$inc]['attachment_name'] = $row['attachment_name'];
								$getAttachments_arr[$inc]['attachment']['original_url'] = $this->CFG['site']['url'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].getImageName($row['attachment_id']).$this->CFG['admin']['ans_pictures']['large_name'].'.'.$extern;
								$getAttachments_arr[$inc]['attachment_id'] = $row['attachment_id'];
								$attach_count++;
								$inc++;
							} // while
						$this->solution_attachment_count = $attach_count;
					}
				return $getAttachments_arr;
			}

		/**
		 * BoardFormHandler::deleteMoreInfos()
		 *
		 * @param mixed $aid
		 * @param mixed $aname
		 * @return
		 */
		public function deleteMoreInfos($aid, $aname)
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['attachments'].
						' WHERE attachment_id='.$this->dbObj->Param('info_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($aid));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				//deleting large and small images
				$small_name = substr($aname, 0, strrpos($aname, '.')-1);
				$extern = strtolower(substr($aname, strrpos($aname, '.')+1));

				// for image formats only
				if(in_array($extern, $this->CFG['admin']['attachments']['image_formats']))
					{
						$attachment_large_file = $this->CFG['site']['project_path'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$aname;
						$attachment_small_file = $this->CFG['site']['project_path'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$small_name.$this->CFG['admin']['ans_pictures']['small_name'].'.'.$extern;
						$attachment_thumbnail_file = $this->CFG['site']['project_path'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$small_name.$this->CFG['admin']['ans_pictures']['thumb_name'].'.'.$extern;
						unlink($attachment_large_file);
						unlink($attachment_small_file);
						unlink($attachment_thumbnail_file);
					}
				else // for other formats like doc,pdf,..
					{
						$attachment_large_file = $this->CFG['site']['project_path'].$this->CFG['admin']['index']['home_module'].'/'.$this->CFG['admin']['ans_attachments_path'].$aname;
						unlink($attachment_large_file);
					}
			}
		/**
		 * BoardFormHandler::chkIsBoardExists()
		 *
		 * @param mixed $field
		 * @param string $err_tip
		 * @return
		 */
		public function chkIsBoardExists($field, $err_tip='')
		    {
				$sql = 'SELECT board_id FROM '.$this->CFG['db']['tbl']['boards'].
						' WHERE board LIKE '.$this->dbObj->Param('board');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr[$field]));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					return true;
				$this->setCommonErrorMsg($err_tip);
				return false;
		    }

		/**
		 * BoardFormHandler::chkFileNameIsNotEmpty()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return
		 **/
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
		 * BoardFormHandler::chkValidFileType()
		 *
		 * @param $field_name
		 * @param $type
		 * @param string $err_tip
		 * @return
		 **/
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
		 * BoardFormHandler::chkValideFileSize()
		 *
		 * @param $field_name
		 * @param $type
		 * @param string $err_tip
		 * @return
		 **/
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
		 * BoardFormHandler::chkErrorInFile()
		 *
		 * @param $field_name
		 * @param $type
		 * @param string $err_tip
		 * @return
		 **/
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
		 * BoardFormHandler::getServerDetailsForPhotos()
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
		 * BoardFormHandler::storeImagesTempServer()
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
		 * BoardFormHandler::addBoard()
		 *
		 * @return
		 */
		public function addBoard()
		    {
				//$this->isCategoryExist();
				$this->setFormField('seo_title', $this->getSeoTitleForBoard($this->fields_arr['board'], $this->fields_arr['bid']));
				$this->fields_arr['content_id'] = $this->insertBoard();

				if($this->CFG['admin']['board_auto_publish']['allowed'] OR (!$this->CFG['admin']['board_auto_publish']['allowed'] AND $this->discussion_details['publish_status'] == 'Yes'))
					{
						$this->updateUserSolutionLog();
						$this->updateTotalBoardCount($this->fields_arr['did']);
						$this->updateCategoryBoardCount();
						$this->updateTags();
					}

				$this->addAttachments();
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
							unlink('../../'.$uploads_arr[$i]);
							unlink($temp_dir.'temp_'.$req_upl[1].'_'.$req_upl[2].'.'.$extern);
					}
			}


		/**
		 * BoardFormHandler::createAttachmentRecord()
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
		 * BoardFormHandler::updateAttachmentRecord()
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
		 * BoardFormHandler::updateTotalBoardCount()
		 *
		 * To update boards count
		 *
		 * @param mixed $cat_id
		 * @return
		 */
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
		 * BoardFormHandler::decreaseCategoryBoardCount()
		 *
		 * @param mixed $cat_id
		 * @return
		 */
		public function decreaseTotalBoardCount($did)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].
						' SET total_boards=total_boards-1'.
						' WHERE discussion_id='.$this->dbObj->Param($did).
						' AND total_boards>0';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($did));
				if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function updateTags()
			{
				$tags = explode(' ', $this->fields_arr['tags']);
				foreach($tags as $eachTag){
					if (trim($eachTag) == '') continue;
					if ($this->isTagExists($eachTag))
						$this->updateTagCount($eachTag);
					else
						$this->insertTagCount($eachTag);
				}
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
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
		 * BoardFormHandler::updateTagCount()
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
		 * BoardFormHandler::updateSearchCount()
		 *
		 * @param mixed $tags
		 * @return
		 */
		public function updateSearchCount($tags)
			{
				$tags = trim($tags);
				while(strpos($tags, '  '))
					{
						$tags = str_replace('  ', ' ', $tags);
					}
				$tags = addslashes($tags);
				$tags_arr = explode(' ', $tags);

				foreach($tags_arr as $tagname)
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['tags'].
								' SET search_count=search_count+1'.
								' WHERE tag_name='.$this->dbObj->Param($tagname);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($tagname));
						if (!$rs)
							    trigger_db_error($this->dbObj);
					}
			}

		/**
		 * BoardFormHandler::insertTagCount()
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
		 * BoardFormHandler::modifyTags()
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
		 * BoardFormHandler::updateBoard()
		 *
		 * @return
		 */
		public function updateBoard()
			{
				$log_activity = false;
				$this->fields_arr['tags'] = removeDuplicateKeywords($this->fields_arr['tags']);
				$this->decreaseTotalBoardCount($this->fields_arr['did']);

				$search_title = $this->filterWordsForSearching($this->fields_arr['seo_title'].' '.$this->fields_arr['descriptions'].' '.$this->fields_arr['tags']);
				$search_title = implode(" ", $search_title);
				$search_title = ' '.$search_title.' ';

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].
						' SET description='.$this->dbObj->Param('descriptions').
						', tags='.$this->dbObj->Param('tags').
						', search_word='.$this->dbObj->Param('search_word').
						', visible_to='.$this->dbObj->Param('visible_to').
						', publish_status='.$this->dbObj->Param('publish').
						', readonly='.$this->dbObj->Param('readonly').
						', discussion_id='.$this->dbObj->Param('did').
						' WHERE board_id='.$this->dbObj->Param('bid').
						' AND user_id='.$this->dbObj->Param('uid');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['descriptions'],
														 $this->fields_arr['tags'],
														 $search_title,
														 $this->fields_arr['visible_to'],
														 $this->fields_arr['publish'],
														 $this->fields_arr['readonly'],
														 $this->fields_arr['did'],
														 $this->fields_arr['bid'],
														 $this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$this->updateTotalBoardCount($this->fields_arr['did']);

				$this->fields_arr['content_id'] = $this->fields_arr['bid'];
				$this->addAttachments();
				$this->modifyTags();
				if($this->CFG['admin']['index']['activity']['show'])
					$log_activity = true;

				//Add Activity
				if($log_activity)
					{
						$activity_arr['action_key'] = 'board_edited';
						$activity_arr['owner_id'] = $this->CFG['user']['user_id'];
						$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
						$activity_arr['board_id'] = $this->fields_arr['bid'];

						$user_details = $this->getUserDetails($this->CFG['user']['user_id']);
						$activity_arr['display_name'] = $user_details['display_name'];
						$this->discussionsActivityObj->addActivity($activity_arr);
					}

				return ;
			}

		/**
		 * BoardFormHandler::insertBoard()
		 *
		 * @return
		 */
		public function insertBoard()
		    {
		    	$log_activity = false;
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
						', discussion_id='.$this->dbObj->Param('did');

				if($this->CFG['admin']['board_auto_publish']['allowed'] OR (!$this->CFG['admin']['board_auto_publish']['allowed'] AND $this->discussion_details['publish_status'] == 'Yes'))
					{
						$sql .= ', board_added=NOW()';
						if($this->CFG['admin']['index']['activity']['show'])
							$log_activity = true;
					}
				else
					{
						$sql .= ', status=\'ToActivate\'';
					}

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
														 $this->fields_arr['did']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				$board_inserted_id = $this->dbObj->Insert_ID();

				//Add Activity
				if($log_activity)
					{
						$activity_arr['action_key'] = 'new_board';
						$activity_arr['owner_id'] = $this->CFG['user']['user_id'];
						$activity_arr['actor_id'] = $this->CFG['user']['user_id'];
						$activity_arr['board_id'] = $board_inserted_id;
						$this->discussionsActivityObj->addActivity($activity_arr);
					}

				return $board_inserted_id;
		    }

		/**
		 * BoardFormHandler::updateUserSolutionLog()
		 *
		 * @return
		 */
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


		/**
		 * BoardFormHandler::generateRandomId()
		 *
		 * @return
		 */
		public function generateRandomId()
			{
				$time = time();
				$this->fields_arr['rid'] = md5($time);
			}

		/**
		 * BoardFormHandler::populateUserDetailsArr()
		 *
		 * @return
		 */
		public function populateUserDetailsArr()
			{
				$sql = 'SELECT '.getUserTableFields(array('name', 'user_id')).
						' FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE '.$this->getUserTableField('name').' = '.$this->dbObj->Param('name').
						' AND '.$this->getUserTableField('user_status').'=\'OK\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['uname']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->user_details = $row;
						return true;
					}
				return false;
			}

		/**
		 * BoardFormHandler::getBestSolutionForBoard()
		 *
		 * @param mixed $bestAnsQuesId
		 * @param mixed $bestAnsId
		 * @param mixed $seo_title
		 * @return
		 */
		public function getBestSolutionForBoard($bestAnsQuesId, $bestAnsId, $seo_title)
			{
				if ($bestAnsId)
					{
						$sql = 'SELECT a.solution_id, a.user_id, a.solution, TIMEDIFF(NOW(), solution_added) as date_solutioned'.
								', u.'.$this->getUserTableField('user_id').' as img_user_id, '.getUserTableFields(array('name'), false).$this->getUserTableField('display_name').' as solutioned_by'.
								' FROM '.$this->CFG['db']['tbl']['solutions'].' AS a , '.$this->CFG['db']['tbl']['users'].' AS u'.
								' WHERE a.user_id=u.'.$this->getUserTableField('user_id').
								' AND u.'.$this->getUserTableField('user_status').'=\'Ok\''.
								' AND a.board_id='.$this->dbObj->Param('bid').
								' AND a.solution_id='.$this->dbObj->Param('aid').
								' ORDER BY a.solution_id DESC';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($bestAnsQuesId, $bestAnsId));
						if (!$rs)
						        trigger_db_error($this->dbObj);

						if (!$rs->PO_RecordCount())
							return ;

						$row = $rs->FetchRow();
						$best_solution_id = $bestAnsId;

						$getBestSolutionForBoard_arr = array();
						$req_arr = array('img_path', 'gender', 't_height', 't_width', 's_height', 's_width', 'photo_server_url', 'photo_ext');
						//getting user info..
						$user_info_details_arr = getUserInfoDetails($req_arr, 'user_id', $row['user_id']);
						$getBestSolutionForBoard_arr['record'] = array_merge($row, $user_info_details_arr);

						$getBestSolutionForBoard_arr['row_solution_manual'] = stripString(wordWrapManual($row['solution'], $this->CFG['admin']['board']['line_length'], $this->CFG['admin']['board']['short_length']), 125);
						$getBestSolutionForBoard_arr['solution']['url'] = getUrl('solutions', '?title='.$seo_title, $seo_title.'/', '', $this->CFG['admin']['index']['home_module']);

						$getBestSolutionForBoard_arr['mysolutions']['url'] = getMemberUrl($row['user_id'], $row['name']);
						$getBestSolutionForBoard_arr['row_solutioned_by_manual'] = stripString($row['solutioned_by'], $this->CFG['username']['short_length']);

						return $getBestSolutionForBoard_arr;
					}
			}
		/**
		 * BoardFormHandler::hasAnyAttachment()
		 *
		 * @param mixed $id
		 * @param mixed $type
		 * @return
		 */
		public function hasAnyAttachment($id,$type)
			{
				$sql = 'SELECT attachment_id FROM '.$this->CFG['db']['tbl']['attachments'].
						' WHERE content_id='.$this->dbObj->Param($id).
						' AND content_type='.$this->dbObj->Param($type);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($id, $type));
						if (!$rs)
						        trigger_db_error($this->dbObj);

						if ($rs->PO_RecordCount())
							return true;
						else
							return false;
			}

		/**
		 * BoardFormHandler::isCategoryExist()
		 *
		 * @return
		 */
		public function isCategoryExist()
			{
				if($this->fields_arr['category'] == 'new')
					{
						$sql = 'SELECT cat_id as count FROM '.$this->CFG['db']['tbl']['category'].' WHERE'.
								' parent_id=0 AND cat_name='.$this->dbObj->Param($this->fields_arr['new_status_hidden']);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['new_status_hidden']));
						if (!$rs)
								trigger_db_error($this->dbObj);

						$row = $rs->FetchRow();
						if ($row['count'])
							{
								$this->fields_arr['category'] = $row['count'];
							}
						else
							{
								$this->setFormField('cat_seo_title', $this->getSeoTitleFordiscussionCategory($this->getFormField('new_status_hidden'), $this->getFormField('category')));
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['category'].
										' SET cat_name='.$this->dbObj->Param('category').
										', seo_title='.$this->dbObj->Param('seo_title').
										', status=\'Active\''.
										', date_added=NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['new_status_hidden'],
																		 $this->fields_arr['cat_seo_title']));
								if (!$rs)
										trigger_db_error($this->dbObj);
								$this->fields_arr['category'] = $this->dbObj->Insert_ID();
							}
					}
				if($this->fields_arr['sub_category'] == 'new')
					{
						$sql = 'SELECT cat_id as count FROM '.$this->CFG['db']['tbl']['category'].' WHERE'.
								' parent_id='.$this->fields_arr['category'].' AND cat_name='.$this->dbObj->Param($this->fields_arr['new_substatus_hidden']);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['new_substatus_hidden']));
						if (!$rs)
								trigger_db_error($this->dbObj);

						$row = $rs->FetchRow();
						if ($row['count'])
							{
								$this->fields_arr['sub_category'] = $row['count'];
							}
						else
							{
								$this->setFormField('subcat_seo_title', $this->getSeoTitleFordiscussionCategory($this->getFormField('new_substatus_hidden'), $this->getFormField('sub_category')));
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['category'].
										' SET cat_name='.$this->dbObj->Param('category').
										', seo_title='.$this->dbObj->Param('seo_title').
										', parent_id='.$this->dbObj->Param('parent_id').
										', status=\'Active\''.
										', date_added=NOW()';
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['new_substatus_hidden'],
																		 $this->fields_arr['subcat_seo_title'],
																		 $this->fields_arr['category']
																		 ));
								if (!$rs)
										trigger_db_error($this->dbObj);
								$this->fields_arr['sub_category'] = $this->dbObj->Insert_ID();

								$has_child = '1';
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
										' SET has_child='.$this->dbObj->Param($has_child).
										' WHERE cat_id='.$this->dbObj->Param($cat_id);
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($has_child, $this->fields_arr['category']));
								if (!$rs)
									    trigger_db_error($this->dbObj);

							}
					}
			}

		public function isValidDiscussionId()
			{
				//if($this->fields_arr['cid'])
					//return true;

				$this->chkIsNotEmpty('title', $this->LANG['err_tip_compulsory']);
				if (!$this->isValidFormInputs())
					{
						$this->setCommonErrorMsg($this->LANG['invalid_board_title']);
						return false;
					}

				$sql = 'SELECT d.discussion_id, d.discussion_title, d.pcat_id, d.cat_id, d.description, d.visible_to, d.publish_status, TIMEDIFF(NOW(), d.date_added) as date_asked, d.redirect_link'.
						', '.$this->getUserTableField('display_name').' as asked_by, u.'.$this->getUserTableField('user_id').' as img_user_id,'.getUserTableFields(array('name')).' , d.status, d.user_id'.
						', d.seo_title FROM '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c, '.$this->CFG['db']['tbl']['users'].' AS u'.
						' WHERE d.pcat_id=c.cat_id AND c.status = \'Active\''.
						' AND d.user_id=u.'.$this->getUserTableField('user_id').' AND d.status = \'Active\''.
						' AND u.'.$this->getUserTableField('user_status').'=\'Ok\' AND d.seo_title='.$this->dbObj->Param('title');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['title']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if (!$rs->PO_RecordCount())
					{
						$this->setCommonErrorMsg($this->LANG['invalid_board_title']);
						return false;
					}

				$this->discussion_details = $rs->FetchRow();
				if($this->discussion_details['redirect_link']!='')
					{
						Redirect2URL($this->discussion_details['redirect_link']);
					}
				$this->discussion_details['discussion_title'] = stripString($this->discussion_details['discussion_title']);
				$this->fields_arr['did'] = $this->discussion_details['discussion_id'];
				$this->fields_arr['seo_title'] = $this->discussion_details['seo_title'];
				$this->iscatgry_not_restricted = $this->chkIfCategoryRestricted($this->discussion_details['pcat_id']);
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
		public function getDiscussionCategoryName()
		    {
		    	if(!isset($this->discussion_details['pcat_id']))
		    		return;

				$CategoryName_value = '';
				$sql = 'SELECT cat_name, seo_title, cat_id, parent_id FROM '.$this->CFG['db']['tbl']['category'].' WHERE cat_id='.$this->dbObj->Param('cat_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->discussion_details['pcat_id']));
				if (!$rs)
					    trigger_db_error($this->dbObj);
				$category_info = array();
				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$CategoryName_value = '<a href="'.getUrl('discussions', '?cat='.$row['seo_title'], 'dir/'.$row['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']).'">'.$row['cat_name'].'</a>';
						$category_info['cat_name'] = $row['cat_name'];
						$category_info['cat_url'] = '<a href="'.getUrl('discussions', '?cat='.$row['seo_title'], 'dir/'.$row['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']).'">'.stripString($row['cat_name']).'</a>';
						$this->category_titles[] = $category_info;
						if($row['parent_id'] > 0)
							$this->getCategoryTitles($row['parent_id']);
					}
				return $CategoryName_value;
		    }

		public function countBoardsTitle($max_allowed, $err_tip='')
			{
				$sql = 'SELECT COUNT(b.board_id) AS cnt '.
						'FROM '.$this->CFG['db']['tbl']['boards'].' AS b '.
						'WHERE b.user_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
						' AND b.discussion_id= '.$this->dbObj->Param('discussion_id').
						' AND DATE_FORMAT(board_added, \''.$this->CFG['mysql_format']['date_time'].'\') >= DATE_FORMAT((select DATE_SUB(now(), INTERVAL 1 DAY)),\''.$this->CFG['mysql_format']['date_time'].'\')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['did']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();

				if ($row['cnt'] < $max_allowed)
					{
						return true;
					}
				$err_tip = str_ireplace('VAR_COUNT', $row['cnt'], $err_tip);
				$this->setCommonErrorMsg($err_tip);
				return false;
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function publishBoard()
			{
				$sql = 'SELECT user_id, board_id, board, seo_title, description, board_id, tags, total_solutions, last_post_by, status FROM '.$this->CFG['db']['tbl']['boards'].
						' WHERE board_id='.$this->dbObj->Param($this->fields_arr['board_id']).
						' AND status=\'ToActivate\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['board_id']));
				if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if ($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['boards'].
								' SET status=\'Active\''.
								', board_added= NOW()'.
								' WHERE board_id = '.$this->dbObj->Param($this->fields_arr['board_id']);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['board_id']));
						if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$params_array = array();

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['users_board_log'].
								' SET total_board=total_board+1';
						if($this->CFG['admin']['ask_solutions']['allowed']){
								$sql .= ', total_points=total_points+'.$this->dbObj->Param($this->CFG['admin']['ask_solutions']['points']);
								$params_array[] =  $this->CFG['admin']['ask_solutions']['points'];
							}
						$sql .= ', date_updated=NOW()'.
								' WHERE user_id='.$this->dbObj->Param($row['user_id']);
						$params_array[] =  $row['user_id'];
						$stmt = $this->dbObj->Prepare($sql);
						$user_logs = $this->dbObj->Execute($stmt, array($row['user_id']));
						if (!$user_logs)
					       	trigger_db_error($this->dbObj);

					    $sql = 'UPDATE '.$this->CFG['db']['tbl']['discussions'].
								' SET total_boards=total_boards+1'.
								', total_solutions=total_solutions+'.$this->dbObj->Param($row['total_solutions']).
								', last_post_user_id='.$this->dbObj->Param($row['last_post_by']).
								', last_post_date=NOW()'.
								' WHERE discussion_id='.$this->dbObj->Param($this->discussion_details['discussion_id']);
					    $stmt = $this->dbObj->Prepare($sql);
					    $rs = $this->dbObj->Execute($stmt, array($row['total_solutions'], $row['last_post_by'], $this->discussion_details['discussion_id']));
					    if (!$rs)
					    	    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if($row['tags'])
							{
								$this->fields_arr['tags'] = $row['tags'];
								$this->updateTags();
							}

						$this->sendPublishedMailAlert($row['user_id'], 'Board', $row['seo_title'], $row['board'], $row['description']);

						return true;

					}
				return false;
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
								$category_info['search_text'] = stripString($row['cat_name']);
								$category_info['search_value'] = $row['cat_id']."#".$row['cat_id'];
								$category_info['tab'] = 0;
								$this->allCategories_arr[] = $category_info;
								$this->fetchSubCategories($row['cat_id'], $tab);
								$this->fetchDiscussionTitles($row['cat_id'], $tab);
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
								$category_info['search_text'] = stripString($row['cat_name']);
								$category_info['search_value'] = $cat_id."#".$row['cat_id'];
								$category_info['tab'] = $tab;
								$this->allCategories_arr[] = $category_info;
								$this->fetchSubCategories($row['cat_id'], $tab+1);
								$this->fetchDiscussionTitles($row['cat_id'], $tab+1);
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
		/**
		 * BoardFormHandler::updateCategoryBoardCount()
		 *
		 * @return
		 */
		public function updateCategoryBoardCount()
		    {
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['category'].
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
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function chkIfCategoryRestricted($cat_id)
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['category'].
						' WHERE cat_id = '.$this->dbObj->Param($cat_id).
						' AND status = \'Active\' AND restricted=\'Yes\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($cat_id));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				if ($rs->PO_RecordCount())
					{
						return false;
					}
				else
					return true;
			}

	}
//<<<<<-------------- Class LoginFormHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$boards = new BoardFormHandler();

if($CFG['admin']['index']['activity']['show'])
	{
		$DiscussionsActivity = new DiscussionsActivityHandler();
		$boards->setDiscussionsActivityObject($DiscussionsActivity);
	}

$boards->setPageBlockNames(array('form_advanced_search', 'form_add', 'form_all_boards'));
//default form fields and values...
$boards->setFormField('board', '');
$boards->setFormField('seo_title', '');
$boards->setFormField('descriptions', '');
$boards->setFormField('search_board', '');
$boards->setFormField('tags', '');
$boards->setFormField('view', '');
$boards->setFormField('orderby_field', '');
$boards->setFormField('orderby', '');
$boards->setFormField('str', '');
$boards->setFormField('msg', '');
$boards->setFormField('cid', '');
$boards->setFormField('bid', '');
$boards->setFormField('did', '');
$boards->setFormField('title', '');
$boards->setFormField('rid', '');
$boards->setFormField('sort', 'date');
$boards->setFormField('order', '');
$boards->setFormField('uname', '');
$boards->setFormField('dname', '');
$boards->setFormField('tags', '');
$boards->setFormField('with', '');
$boards->setFormField('type', '');
$boards->setFormField('discussion_category', '');
$boards->setFormField('more_boards', '');
$boards->setFormField('so', 'min');//min-adv
$boards->setFormField('cat_id', '');
$boards->setFormField('total_solution_from', '');
$boards->setFormField('total_solution_to', '');
$boards->setFormField('date_limits_to', '');
$boards->setFormField('adv_search', '');
$boards->setFormField('opt', '');
$boards->setFormField('al', 'All');
$boards->setFormField('cat', '');
$boards->setFormField('publish', 'Yes');
$boards->setFormField('readonly', 'No');
$boards->setFormField('related_board', '');
$boards->setFormField('attachments', '');
$boards->setFormField('attachment_id', '');
$boards->setFormField('attachment_name', '');
$boards->setFormField('photo_server_url', '');
$boards->setFormField('value', '');
$boards->setFormField('id', '');
$boards->setFormField('usrid', '');
$boards->setFormField('ajax_page', '');
$boards->setFormField('update', '');
$boards->setFormField('ques_priority', 'Normal');
$boards->setFormField('index_board', '');
$boards->setFormField('upl_original', array());
$boards->setFormField('uplarr', array());
$boards->setFormField('visible_to', 'All');
$boards->setFormField('unpublished', '');
$boards->setFormField('board_id', '');
$boards->setFormField('with_solution', '');

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

$boards->searchOption_arr = array($LANG['search_option_allresult'] => $LANG['search_option_allresult'],
			  $LANG['search_option_today'] => $LANG['search_option_today'],
			  $LANG['search_option_oneday'] => $LANG['search_option_oneday'],
			  $LANG['search_option_oneweek'] => $LANG['search_option_oneweek'],
			  $LANG['search_option_onemonth'] => $LANG['search_option_onemonth'],
			  $LANG['search_option_threemonths'] => $LANG['search_option_threemonths'],
			  $LANG['search_option_sixmonths'] => $LANG['search_option_sixmonths'],
			  $LANG['search_option_oneyear'] => $LANG['search_option_oneyear']);

$boards->display_bold = 3;
$boards->title = $LANG['boards'];
$boards->board_short_title = '';
$boards->discussion_title = getUrl('discussions', '', '', '', $CFG['admin']['index']['home_module']);

/*************Start navigation******/
$boards->numpg = $CFG['data_tbl']['numpg'];
$boards->setFormField('start', 0);
$boards->setFormField('numpg', $boards->numpg);//$CFG['data_tbl']['numpg']

$boards->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$boards->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$boards->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
//Set tables and fields to return
$boards->setTableNames(array());
$boards->setReturnColumns(array());
//orderby field and orderby
$boards->setFormField('orderby_field', 'board_id');
$boards->setFormField('orderby', 'DESC');
/*************End navigation******/
$boards->sanitizeFormInputs($_REQUEST);

// Default page block
$boards->setAllPageBlocksHide();

if(!$boards->getFormField('rid'))
	$boards->generateRandomId();
$isDiscussionValid = 1;
if(isMember())
	$CFG['admin']['new_post_day'] = $CFG['user']['last_active'];
else
	$CFG['admin']['new_post_day'] = '0000-00-00 00:00:00';

if ($boards->isFormPOSTed($_REQUEST, 'deletemoreattachments'))
	{
		if (!isMember())
			{
				echo 'Session Expired. <a href="'.$CFG['auth']['login_url']['url'].'?r">Login to continue..!</a>';
				die();
			}
		ob_start();

		$comment_id = $boards->getFormField('attachment_id');
		$attachment_name = $boards->getFormField('attachment_name');
		$boards->deleteMoreInfos($comment_id, $attachment_name);

		die();
	}
if($boards->getFormField('view') == 'related')
	{
		if(!$boards->chkIsValidBoard())
			Redirect2URL(getUrl('discussions', '', '', '', $CFG['admin']['index']['home_module']));

		$boards->setPageBlockShow('form_all_boards');
	}
else if($boards->isFormGETed($_REQUEST, 'title') or $boards->getFormField('view') == 'ask')
	{
		if(!$boards->isValidDiscussionId()){
				Redirect2Page(getUrl('discussions', '', '', '', $CFG['admin']['index']['home_module']));
		}
		else
			{
				$boards->setPageBlockShow('form_all_boards');
			}
		//			Redirect2URL(getUrl('discussions', '', '', '', $CFG['admin']['index']['home_module']));
	}
switch($boards->getFormField('view'))
	{
		case 'ask':
			if (!isset($CFG['user']['user_id']) or empty($CFG['user']['user_id']))
				{
					$_SESSION['url'] = getUrl('boards', '?view=ask&amp;title='.$boards->getFormField('title'), 'ask/?title='.$boards->getFormField('title'), '', $CFG['admin']['index']['home_module']);
					Redirect2URL(getUrl('login'));
				}
			if ($boards->isAllowedToAsk($boards->discussion_details['user_id']))
				{
					$boards->setAllPageBlocksHide();
					$boards->setPageBlockShow('form_add');
				}
			else
				{
					$boards->setPageBlockShow('block_msg_form_error');
					$boards->setCommonErrorMsg($LANG['info_not_allowed_to_ask']);
				}

			if(!$boards->countBoardsTitle($CFG['admin']['discussions']['board']['max_allowed'], $LANG['boards_err_tip_cannot_create_board']))
				{
					$boards->setAllPageBlocksHide();
					$boards->setPageBlockShow('block_msg_form_error');
				}
			$boards->title = $LANG['ask_a_board'];
			break;
		case 'search':
			$boards->board_short_title = $boards->title = $LANG['search_results'];
			$uname = $boards->getUsersDisplayName($boards->getFormField('uname'));
			$opt = $boards->getFormField('opt');
			if ($uname and $opt)
				{
					$my_title = $uname.'\'s ';

					if($CFG['user']['user_id'])
						{
							if($CFG['user']['display_name'] == $uname)
								$my_title = $LANG['discuzz_common_my'].' ';
						}

					switch($opt)
						{
							case 'sol':
								$boards->search_home = $LANG['solutioned_boards'];
								$boards->title = $my_title.$LANG['solutioned_boards'];
								$boards->board_short_title = $my_title.$LANG['solutioned_boards'];
								break;
							case 'bestsol':
								$boards->search_home = $LANG['bestsolutioned_boards'];
								$boards->title = $my_title.$LANG['bestsolutioned_boards'];
								$boards->board_short_title = $my_title.$LANG['bestsolutioned_boards'];
								break;
							case 'board':
								$boards->search_home = $LANG['asked_boards'];
								$boards->title = $my_title.$LANG['asked_boards'];
								$boards->board_short_title = $my_title.$LANG['asked_boards'];
								break;
							case 'fav':
								$boards->search_home = $LANG['favorite_boards'];
								$boards->title = $my_title.$LANG['favorite_boards'];
								$boards->board_short_title = $my_title.$LANG['favorite_boards'];
								break;
						} // switch
				}
			$boards->setPageBlockShow('form_all_boards');
			break;
		case 'popular':
			$boards->title = $LANG['discuzz_common_popular_board_title'];
			$boards->board_short_title = $LANG['discuzz_common_popular_board_title'];
			$boards->setPageBlockShow('form_all_boards');
			break;
		case 'recentlysolutioned':
			$boards->title = $LANG['discuzz_common_recently_solutioned_board_title'];
			$boards->board_short_title = $LANG['discuzz_common_recently_solutioned_board_title'];
			$boards->setPageBlockShow('form_all_boards');
			break;
		case 'best':
			$boards->title = $LANG['search_type_with_best_solution'];
			$boards->board_short_title = $LANG['search_type_with_best_solution'];
			$boards->setPageBlockShow('form_all_boards');
			break;
		case 'featured':
			$boards->title = $LANG['discuzz_common_featured_board_title'];
			$boards->board_short_title = $LANG['discuzz_common_featured_board_title'];
			$boards->setPageBlockShow('form_all_boards');
			break;
		case 'recent':
			$boards->title = $LANG['discuzz_common_recent_board_title'];
			$boards->board_short_title = $LANG['discuzz_common_recent_board_title'];
			$boards->setPageBlockShow('form_all_boards');
			break;
		case 'related':
			$boards->title = $LANG['discuzz_common_related_board_title'];
			$boards->board_short_title = $LANG['discuzz_common_related_board_title'];
			$boards->setPageBlockShow('form_all_boards');
			break;
		default:
			if ($boards->getFormField('title') == '')
				{
					$boards->setFormField('title', $boards->getFormField('view'));
					if(!$boards->isValidDiscussionId())
						Redirect2URL(getUrl('discussions', '', '', '', $CFG['admin']['index']['home_module']));
					$boards->setPageBlockShow('form_all_boards');
				}
			else
				{
					$boards->title = $LANG['discuzz_common_recent_board_title'];
					$boards->board_short_title = $LANG['discuzz_common_recent_board_title'];
					$boards->setPageBlockShow('form_all_boards');
				}
			break;
	} // switch

if ($boards->isFormPOSTed($_POST, 'submit'))
	{

		//$boards->chkIsValidBoard();
		if($CFG['admin']['board']['duplicates'])
			$boards->chkIsNotEmpty('board', $LANG['err_tip_compulsory']);
		else
			$boards->chkIsNotEmpty('board', $LANG['err_tip_compulsory']) and $boards->chkIsBoardExists('board', $LANG['boards_err_exists_already']);

		if ($CFG['admin']['description']['mandatory'])
			$boards->chkIsNotEmpty('descriptions', $LANG['err_tip_compulsory']);
		if (!$boards->isAllowedToAsk($boards->discussion_details['user_id']))
			$boards->setCommonErrorMsg($LANG['info_not_allowed_to_ask']);
		if(!$boards->iscatgry_not_restricted)
			$boards->setCommonErrorMsg($LANG['restricted_to_post']);
		if ($boards->isValidFormInputs())
			{
				$descriptions = stripString($boards->getFormField('descriptions'), $CFG['admin']['description']['limit']);
				$boards->setFormField('descriptions', $descriptions);
				//Insert board details
				$boards->addBoard();
				$boards->setCommonSuccessMsg($LANG['boards_added_successfully']);
				$boards->setPageBlockShow('block_msg_form_success');
				Redirect2URL(getUrl('boards', '?title='.$boards->discussion_details['seo_title'].'&msg=1', $boards->discussion_details['seo_title'].'/?msg=1', '', $CFG['admin']['index']['home_module']));
			}
		else
			{
				$boards->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry'].' '.$boards->getCommonErrorMsg());
				$boards->setPageBlockShow('block_msg_form_error');
			}
	}
else if ($boards->isFormPOSTed($_POST, 'update_board'))
	{
		$boards->LANG['boards_port_your'] = $LANG['edit_your_board'];
		$boards->chkIsValidBoard();
		if ($CFG['admin']['description']['mandatory'])
			$boards->chkIsNotEmpty('descriptions', $LANG['err_tip_compulsory']);
		if(!$boards->iscatgry_not_restricted)
			$boards->setCommonErrorMsg($LANG['restricted_to_post']);
		if ($boards->isValidFormInputs())
			{
				$descriptions = stripString($boards->getFormField('descriptions'), $CFG['admin']['description']['limit']);
				$boards->setFormField('descriptions', $descriptions);
				$boards->setFormField('seo_title', $boards->board_details['seo_title']);
				//Update board details
				$boards->updateBoard();
				$boards->setCommonSuccessMsg($LANG['boards_updated_successfully']);
				$boards->setPageBlockShow('block_msg_form_success');
				Redirect2URL(getUrl('solutions', '?title='.$boards->getFormField('seo_title').'&msg=5', $boards->getFormField('seo_title').'/?msg=5', '', $CFG['admin']['index']['home_module']));
			}
		else
			{
				$boards->setCommonErrorMsg($LANG['discuzz_common_msg_error_sorry']);
				$boards->setPageBlockShow('block_msg_form_error');
				$boards->setFormField('board', $boards->board_details['board']);
			}
	}
else if ($boards->isFormGETed($_GET, 'cid'))
	{
		$boards->setAllPageBlocksHide();
		if ($boards->getFormField('view') == 'ask')
			{
				$boards->LANG['boards_port_your'] = $LANG['edit_your_board'];
				$boards->setFormField('bid', $boards->getFormField('cid'));
				$boards->chkIsValidBoard();
				if ($boards->isValidFormInputs())
					{
						$boards->setPageBlockShow('form_add');
						$boards->setFormField('board', $boards->board_details['board']);
						$boards->setFormField('seo_title', $boards->board_details['seo_title']);
						$boards->setFormField('descriptions', $boards->board_details['description']);
						$boards->setFormField('tags', $boards->board_details['tags']);
						$boards->setFormField('visible_to', $boards->board_details['visible_to']);
						$boards->setFormField('publish', $boards->board_details['publish_status']);
						$boards->setFormField('readonly', $boards->board_details['readonly']);
						$boards->setFormField('did', $boards->board_details['discussion_id']);
					}
				else
					{
						$boards->setPageBlockShow('block_msg_form_error');
					}
			}
	}
if (isset($boards->board_details['seo_title'])) {
	$boards->solutions_url = getUrl('solutions', '?title='.$boards->board_details['seo_title'], $boards->board_details['seo_title'].'/', '', $CFG['admin']['index']['home_module']);
}
else {
	$boards->solutions_url = getUrl('solutions', '?title='.$boards->getFormField('seo_title'), $boards->getFormField('seo_title').'/', '', $CFG['admin']['index']['home_module']);
}
$boards->boards_url = getUrl('boards','?title='.$boards->getFormField('seo_title'),$boards->getFormField('seo_title').'/','',$CFG['admin']['index']['home_module']);
if ($boards->isFormGETed($_GET, 'msg'))
	{
		switch($boards->getFormField('msg'))
			{
				case '1':
					if($CFG['admin']['board_auto_publish']['allowed'] OR (!$CFG['admin']['board_auto_publish']['allowed'] AND $boards->discussion_details['publish_status'] == 'Yes'))
						$boards->setCommonSuccessMsg($LANG['boards_added_successfully']);
					else
						$boards->setCommonSuccessMsg($LANG['boards_waiting_for_pubish']);
					break;
				case '2':
					$boards->setCommonSuccessMsg($LANG['boards_updated_successfully']);
					break;
				case '3':
					$boards->setCommonSuccessMsg($LANG['boards_deleted_successfully']);
					break;
				case 'published':
					$boards->setCommonSuccessMsg($LANG['boards_published_successfully']);
					break;
			} // switch
		$boards->setPageBlockShow('block_msg_form_success');
		if ($boards->getFormField('msg') == 'invalidboard')
			{
				$boards->setCommonErrorMsg($LANG['err_tip_invalid_board']);
				$boards->setPageBlockHide('block_msg_form_success');
				$boards->setPageBlockShow('block_msg_form_error');
			}
	}

if($boards->getFormField('so')=='adv' and !$boards->isFormPOSTed($_REQUEST, 'adv_search'))
	{
		$boards->populateSearchFields();
		$boards->setPageBlockHide('form_all_boards');
		$boards->setAllPageBlocksHide();
		$boards->setPageBlockShow('form_advanced_search');
	}
if($boards->getFormField('so')=='adv' and $boards->getFormField('view')=='recent')
	{
		Redirect2URL(getUrl('boards', '?so=adv&view=search', 'search/?so=adv', '', $CFG['admin']['index']['home_module']));
	}
if($boards->isFormGETed($_GET, 'adv_search'))
	{
		$boards->populateSearchFields();
		$boards->setAllPageBlocksHide();
		$boards->setPageBlockShow('form_all_boards');
	}
if($boards->isFormPOSTed($_POST, 'adv_search'))
	{
		$boards->getFormField('total_solution_from') AND
			$boards->chkIsNumeric('total_solution_from', $LANG['discuzz_common_err_tip_numeric']);

		if ($boards->getFormField('total_solution_to'))
			{
				if (!$boards->chkIsNumeric('total_solution_to', $LANG['discuzz_common_err_tip_numeric']))
					$boards->setFormFieldErrorTip('total_solution_from', $LANG['discuzz_common_err_tip_numeric']);
			}
		if($boards->getFormField('total_solution_to') < $boards->getFormField('total_solution_from'))
			$boards->setFormFieldErrorTip('total_solution_to', $LANG['to_solution_search_error']);

		if ($boards->isValidFormInputs())
			{
				$boards->setAllPageBlocksHide();
				$boards->storeSearchFields();
				$boards->setPageBlockShow('form_all_boards');
				$advanced_search_link = '<a href="'.getUrl('boards', '?so=adv&amp;view=search', 'search/?so=adv', '', $CFG['admin']['index']['home_module']).'">'.$LANG['advanced_search'].'</a>';
			   	$lang_advance_search = str_ireplace('VAR_ADVANCED_SEARCH', $advanced_search_link, $LANG['click_for_advance_search']);
			   	$boards->LANG['boards_no_records'] = $LANG['boards_no_records'].'. '.$lang_advance_search;
			}
		else
			{
				$boards->setAllPageBlocksHide();
				$boards->setPageBlockShow('form_advanced_search');
				$boards->setPageBlockShow('block_msg_form_error');
				$boards->setCommonErrorMsg($LANG['err_msg_invalid_search_option']);
			}
	}


if(!$boards->isFormGETed($_GET, 'search_board'))
	{
	   	$_SESSION['search_board'] = $LANG['header_search_for_boards'];
	}
if($boards->isFormPOSTed($_POST, 'search_board'))
	{
		$_SESSION['search_board'] = $boards->getFormField('search_board');
		$advanced_search_link = '<a href="'.getUrl('boards', '?so=adv&amp;view=search', 'search/?so=adv', '', $CFG['admin']['index']['home_module']).'">'.$LANG['advanced_search'].'</a>';
	   	$lang_advance_search = str_ireplace('VAR_ADVANCED_SEARCH', $advanced_search_link, $LANG['click_for_advance_search']);
	   	$boards->LANG['boards_no_records'] = $LANG['boards_no_records'].'. '.$lang_advance_search;
	}
if($boards->isFormGETed($_GET, 'search_board'))
	{
	    if(isset($_SESSION['search_board']) and $_SESSION['search_board'])
		    $boards->setFormField('search_board', $_SESSION['search_board']);
	}

if($boards->getFormField('title') != '')
	{
		if($CFG['admin']['friends']['allowed'] and $CFG['admin']['discussions']['visibility']['needed'])
			{
				if($boards->discussion_details['visible_to'] == 'None' and $boards->discussion_details['user_id'] != $CFG['user']['user_id'])
					{
						$boards->setAllPageBlocksHide();
						$boards->setPageBlockShow('block_msg_form_error');
						$boards->setCommonErrorMsg($LANG['discuzz_common_err_invisible_title']);
					}
				elseif($boards->discussion_details['visible_to'] == 'Friends' and $boards->discussion_details['user_id'] != $CFG['user']['user_id'])
					{
						$owner_id = $boards->discussion_details['user_id'];
						$user_id = $CFG['user']['user_id'];
						if(!$boards->areMutualFriends($owner_id, $user_id))
							{
								$boards->setAllPageBlocksHide();
								$boards->setPageBlockShow('block_msg_form_error');
								$boards->setCommonErrorMsg($LANG['discuzz_common_err_onlyfriends_title']);
							}
					}
			}
	}

if($boards->isFormPOSTed($_REQUEST, 'opt'))
	{
		if($boards->populateUserDetailsArr())
			{
				switch($boards->getFormField('opt'))
					{
						case 'sol':
							$boards->sql_condition = 'b.user_id=u.'.$boards->getUserTableField('user_id').' AND b.status IN (\'Active\') AND u.'.$boards->getUserTableField('user_status').'=\'Ok\'';
							$boards->sql_condition .= ' AND EXISTS (SELECT board_id FROM '.$CFG['db']['tbl']['solutions'].' AS a WHERE a.user_id=\''.addslashes($boards->user_details['user_id']).'\' AND b.board_id = a.board_id)';
							$boards->sql_condition .= ' AND EXISTS(SELECT 1 FROM '.$CFG['db']['tbl']['discussions'].' AS d, '.$CFG['db']['tbl']['category'].' AS c, '.$CFG['db']['tbl']['users'].' AS ud WHERE d.pcat_id=c.cat_id AND c.status=\'Active\' AND d.user_id = ud.'.$boards->getUserTableField('user_id').' AND ud.'.$boards->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id = b.discussion_id  AND d.status = \'Active\')';
							break;
						case 'bestsol':
							$boards->sql_condition = 'b.user_id=u.'.$boards->getUserTableField('user_id').' AND b.status IN (\'Active\') AND u.'.$boards->getUserTableField('user_status').'=\'Ok\'';
							$boards->sql_condition .= ' AND EXISTS (SELECT board_id FROM '.$CFG['db']['tbl']['solutions'].' AS a WHERE a.user_id=\''.addslashes($boards->user_details['user_id']).'\' AND b.board_id = a.board_id AND a.solution_id = b.best_solution_id)';
							$boards->sql_condition .= ' AND EXISTS(SELECT 1 FROM '.$CFG['db']['tbl']['discussions'].' AS d, '.$CFG['db']['tbl']['category'].' AS c, '.$CFG['db']['tbl']['users'].' AS ud WHERE d.pcat_id=c.cat_id AND c.status=\'Active\' AND d.user_id = ud.'.$boards->getUserTableField('user_id').' AND ud.'.$boards->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id = b.discussion_id  AND d.status = \'Active\')';
							break;
						case 'fav':
							$boards->sql_condition = 'b.user_id=u.'.$boards->getUserTableField('user_id').' AND b.status IN (\'Active\') AND u.'.$boards->getUserTableField('user_status').'=\'Ok\'';
							$boards->sql_condition .= ' AND EXISTS (SELECT content_id FROM '.$CFG['db']['tbl']['user_bookmarked'].' AS uf WHERE uf.user_id=\''.addslashes($boards->user_details['user_id']).'\' AND b.board_id = uf.content_id AND uf.content_type=\'Board\')';
							$boards->sql_condition .= ' AND EXISTS(SELECT 1 FROM '.$CFG['db']['tbl']['discussions'].' AS d, '.$CFG['db']['tbl']['category'].' AS c, '.$CFG['db']['tbl']['users'].' AS ud WHERE d.pcat_id=c.cat_id AND c.status=\'Active\' AND d.user_id = ud.'.$boards->getUserTableField('user_id').' AND ud.'.$boards->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id = b.discussion_id  AND d.status = \'Active\')';
							break;
					}
			}

	}

if ($boards->isShowPageBlock('form_all_boards'))
	{
		$boards->setTableNames(array($CFG['db']['tbl']['boards'].' as b LEFT JOIN '.$CFG['db']['tbl']['users'].' as lp ON lp.'.$boards->getUserTableField('user_id').'=b.last_post_by',
									$CFG['db']['tbl']['users'].' as u'));

		$boards->setReturnColumns(array('board_id', 'b.board', 'b.rating_total', 'b.rating_count', 'b.last_post_by', 'b.seo_title', 'best_solution_id',
										'b.solution_added', 'DATE_FORMAT(solution_added, \''.$CFG['mysql_format']['date_time_meridian'].'\') as last_post_date', 'b.readonly', 'b.visible_to', 'b.total_solutions',
										'b.total_views', 'b.status', 'b.user_id',
										'u.'.$boards->getUserTableField('display_name').' as asked_by',
										'lp.'.$boards->getUserTableField('display_name').' as last_post_name',
										'lp.'.$boards->getUserTableField('name').' as last_post_user',
										'u.'.$boards->getUserTableFields(array('name'), false),
										'board','total_stars', 'TIMEDIFF(NOW(), board_added) as board_added'));

		$boards->buildSelectQuery();
		$boards->buildConditionQuery();
		$boards->buildSortQuery();
		$boards->buildQuery();
		//$boards->printQuery();
		$boards->executeQuery();
		$boards->block_displayAllBoards_arr = array();
		$boards->block_displayAllBoards_arr = $boards->displayAllBoards();

		$boards->pagingArr[] = 'start';
		$boards->pagingArr[] = 'orderby_field';
		$boards->pagingArr[] = 'orderby';

		$smartyObj->assign('pagingArr', $boards->pagingArr);
		$smartyObj->assign('smarty_paging_list', $boards->populatePageLinksPOST($boards->getFormField('start'), 'allBoardsFrm'));

		if(isset($boards->discussion_details['discussion_title']) and $boards->discussion_details['discussion_title'] != '')
			{
				$boards->title = $boards->discussion_details['discussion_title'];
				$boards->board_short_title = stripString($boards->discussion_details['discussion_title'], $CFG['admin']['board']['short_length']);
				if ($boards->getFormField('unpublished') AND $boards->discussion_details['user_id'] == $CFG['user']['user_id'])
					{
						$boards->board_short_title .= ' - '.$LANG['unpublished_boards'];
					}
			}
	}
$boards->getDiscussionCategoryName();
if(is_array($boards->category_titles)) $boards->category_titles = array_reverse($boards->category_titles);

if ($boards->isShowPageBlock('form_add'))
	{
		if(!$boards->iscatgry_not_restricted)
			{
				//$board_url = getUrl('boards', '?title='.$boards->getFormField('title'), $boards->getFormField('title').'/', '', $CFG['admin']['index']['home_module']);
				$boards->setCommonErrorMsg($LANG['restricted_to_post']);
				$boards->setAllPageBlocksHide();
				$boards->setPageBlockShow('block_msg_form_error');
			}
		$boards->form_add['askBoards_arr'] = $boards->askBoards();
	}

if ($boards->isShowPageBlock('form_advanced_search'))
	{
		$boards->form_advanced_search_arr['populateBoardType'] = $boards->populateBoardType();
		$boards->form_advanced_search_arr['discussionCategories_arr'] = $boards->fetchAllCategories();

		$boards->form_advanced_search_arr['with_best_solution_checked'] = '';
		$boards->form_advanced_search_arr['with_no_solution_checked'] = '';
		$boards->form_advanced_search_arr['with_solution_checked'] = '';
		$with_solution_checked = 'checked';
		if($boards->getFormField('with_solution') == 3)
			$boards->form_advanced_search_arr['with_best_solution_checked'] = $with_solution_checked;
		else if($boards->getFormField('with_solution') == 2)
			$boards->form_advanced_search_arr['with_no_solution_checked'] = $with_solution_checked;
		if($boards->getFormField('with_solution') == 1)
			$boards->form_advanced_search_arr['with_solution_checked'] = $with_solution_checked;

		$boards->form_advanced_search_arr['form_action'] = getUrl('boards', '?so=adv&amp;view=search', 'search/?so=adv', '', $CFG['admin']['index']['home_module']);
	}

$boards->deleteBoardAttachments_onclick = getUrl('boards', '?view=ask&amp;cid='.$boards->getFormField('bid'), 'ask/'.$boards->getFormField('bid').'/', '', $CFG['admin']['index']['home_module']);
$boards->post_new_link = getUrl('boards', '?view=ask&amp;title='.$boards->getFormField('title'), 'ask/?title='.$boards->getFormField('title'), 'members', $CFG['admin']['index']['home_module']);
$board_url = getUrl('boards', '?view='.$boards->getFormField('view'),  '?view='.$boards->getFormField('view'), '', $CFG['admin']['index']['home_module']);
$boards->login = getUrl('login', '?light_url='.$board_url, '?light_url='.$board_url);


//<<<<--------------------Code Ends----------------------//
$CFG['html']['page_id'] .= $boards->getFormField('view');
$CFG['site']['title'] = $boards->title.' - '.$CFG['site']['title'];
//--------------------Page block templates begins-------------------->>>>>//
//include the header file
if($CFG['is']['ajax_page'] == true)
	{
		$boards->includeAjaxHeader();
	}
else
	$boards->includeHeader();
//include the content of the page
?>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>tools/bbcode/ed.js"></script>
<?php
setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
$smartyObj->display('boards.tpl');
?>
<script language="javascript" type="text/javascript">
var block_arr= new Array('selMsgConfirm', 'selDelInfoconfirm');
</script>
<script language="javascript" type="text/javascript">
	var confrimRemove = function(){
		var act_value = arguments[0];
		var anchorLink = arguments[1];
		var confirm_message = arguments[2];

		$Jq('#confirmMessage').html(confirm_message);
		document.formConfirm.action.value = act_value;
		Confirmation('selMsgConfirm', 'formConfirm', Array(), Array(), Array());

		return false;
	}

	var removeId = 0;
	function add_more_upload(lang) {

		var id = removeId++;
		var ptags = $Jq('p', '#tdID');
		var len = ptags.length;

		if(len > <?php echo $CFG['admin']['attachments_allowed']['count']+1;?>)
			$Jq('#brsBtn').css('display', 'none');

		if(len > <?php echo $CFG['admin']['attachments_allowed']['count']+2;?>)
			return;

		var rowTemplate = '<p class="clsAttachments" id="p_'+id+'"><input type="file" name="attachments[]" value=""> <a class="clsRemoveAttachment" href="#" onClick="removeThis('+id+');return false;">'+lang+'<\/a><\/p>';

		new Insertion.Before('brsBtn', rowTemplate);
	}

	function removeThis(id)	{
		var remId = id;
		$Jq('#p_'+remId).remove();
		$Jq('#brsBtn').css('display', '');
	}
</script>
<?php
if ($boards->isShowPageBlock('form_add'))
	{?>
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
			button_text_style : '.button { text-align:center; font-family: Helvetica, Arial, sans-serif; font-size: 12pt; font-weight:bold;color:#ffffff;padding-top:5px} .buttonSmall { font-size: 10pt; }',
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
if(count($boards->getFormField('uplarr')) != 0 )
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
//include the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
if($CFG['is']['ajax_page'] == true)
	{
		//include the header file
		$boards->includeAjaxFooter();
	}
else
	{
		//includd the footer of the page
		$boards->includeFooter();
	}
?>