<?php
//--------------class DiscussionHandler--------------->>>//
/**
 * @category	Discuzz
 * @package		discussionsResponsesFormHandler
 * @author 		shankar_76ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:
 * @since 		2008-11-04
 **/

class discussionHandlers extends DiscussionHandler
	{
		//Variable to store discussion details
		public $paging_arr;

		/**
		 * DiscussionHandler::storeSearchFields()
		 *
		 * @return
		 */
		public function storeSearchFields()
			{

				$allowed_fields_arr = array(
										'discussion_title'=>$this->fields_arr['discussion_title'],
										'dname'=>$this->fields_arr['dname'],
										'cat_id'=>$this->fields_arr['cat_id'],
										'date_limits_to'=>$this->fields_arr['date_limits_to'],
										);
				$allowed_fields_arr = serialize($allowed_fields_arr);

				if($this->CFG['user']['user_id'] != 0)
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['advanced_search'].' SET'.
								' discussion = '.$this->dbObj->Param('discussion').' WHERE'.
								' user_id = '.$this->dbObj->Param('user_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($allowed_fields_arr, $this->CFG['user']['user_id']));
							if (!$rs)
								trigger_db_error($this->dbObj);
					}
				else
					{
						$_SESSION['advanced_search_values_for_discussions'] = 	$allowed_fields_arr;
					}
					//to fix search top box value populate..
					$_SESSION['discussion_title'] = $this->fields_arr['discussion_title'];
			}

		/**
		 * DiscussionHandler::populateSearchFields()
		 *
		 * @return
		 */
		public function populateSearchFields()
			{

				if($this->fields_arr['so']=='adv')
					{
						if($this->CFG['user']['user_id'] != 0)
							{

								$sql = 'SELECT discussion FROM '.$this->CFG['db']['tbl']['advanced_search'].
										' WHERE user_id='.$this->dbObj->Param('user_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
									if (!$rs)
										trigger_db_error($this->dbObj);

								if($row = $rs->FetchRow())
									{
										if($row['discussion'])
											{
												$search_fields_arr = unserialize($row['discussion']);
												$this->fields_arr = array_merge($this->fields_arr, $search_fields_arr);
											}
									}
							}
						else
							{
								if(isset($_SESSION['advanced_search_values_for_discussions']) and !empty($_SESSION['advanced_search_values_for_discussions']))
									{
											$search_fields_arr = unserialize($_SESSION['advanced_search_values_for_discussions']);
											$this->fields_arr = array_merge($this->fields_arr, $search_fields_arr);
									}

							}
							//to fix search top box value populate..
							$_SESSION['discussion_title'] = $this->fields_arr['discussion_title'];
					}
			}
		/**
		 * set the condition
		 *
		 * @access public
		 * @return void
		 **/
		public function buildConditionQuery($condition='')
			{

				$this->sql_condition = $condition;

				if($this->fields_arr['search_discussion'] && ($this->fields_arr['search_discussion'] != $this->LANG['header_search_for_discussions']))
					{
						$this->sql_condition .= ' AND ('.getSearchRegularExpressionQuery($this->fields_arr['search_discussion'], 'd.discussion_title').')';
						$this->paging_arr[] = 'search_discussion';
					}

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
				if ($this->fields_arr['uname'])
					{
						$this->sql_condition .= ' AND u.'.$this->getUserTableField('name').' LIKE \''.addslashes($this->fields_arr['uname']).'%\'';
						$this->paging_arr[] = 'uname';
					}
				if ($this->fields_arr['uid'])
					{
						$this->sql_condition .= ' AND d.user_id=\''.$this->fields_arr['uid'].'\'';
						$this->paging_arr[] = 'uid';
					}

				if ($this->fields_arr['cat_id'])
					{
						$this->sql_condition .= ' AND d.pcat_id=\''.$this->fields_arr['cat_id'].'\'';
						$this->paging_arr[] = 'uid';
					}

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
						default:
							$date_condtion = 'd.date_added <= NOW()';
							break;

					}

				$this->paging_arr[] = 'date_limits_to';
				$this->sql_condition .= ' AND '.$date_condtion;
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
					$this->sql_sort = $field . ' ' . $sort;
				}
			}
		/**
		 * To display the discussions titles
		 *
		 * @access public
		 * @return void
		 **/
		public function showDiscussionSearchResult()
			{

				$showDiscussionTitles_arr = array();
				$inc = 1;
				while($row = $this->fetchResultRecord())
					{
						$showDiscussionTitles_arr[$inc]['record'] = $row;
						$showDiscussionTitles_arr[$inc]['discussionBoards']['url'] = getUrl('boards', '?title='.$row['seo_title'], $row['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']);
						$showDiscussionTitles_arr[$inc]['discussionBoards']['title'] = wordWrapManual($row['discussion_title'], 15);
						$showDiscussionTitles_arr[$inc]['discussion_description_manual'] = nl2br(wordWrapManual($row['description'], 15));
						$showDiscussionTitles_arr[$inc]['myanswers']['url'] = getUrl('mysolutions', '?uid='.$row['post_user'], $row['post_user'].'/');
						$showDiscussionTitles_arr[$inc]['lastPost']['url'] = getUrl('mysolutions', '?uid='.$row['last_post_user'], $row['last_post_user'].'/');
						$inc++;
					}

					return $showDiscussionTitles_arr;
			}

	}
//<<<<<<<--------------class DiscussionHandler---------------//

//--------------------Code begins-------------->>>>>//
$discussionSearch = new discussionHandlers();
$discussionSearch->setPageBlockNames(array('form_advanced_search', 'form_discussion_title', 'form_show_topics', 'form_confirm'));
$discussionSearch->setAllPageBlocksHide();
//default form fields and values...
$discussionSearch->setFormField('uid', '');
$discussionSearch->setFormField('discussion_id', '');
$discussionSearch->setFormField('title', '');
$discussionSearch->setFormField('search_discussion', '');
$discussionSearch->setFormField('uname', '');
$discussionSearch->setFormField('dname', '');
$discussionSearch->setFormField('cat_id', '');
$discussionSearch->setFormField('discussion_title', '');
$discussionSearch->setFormField('date_limits_to', '');
$discussionSearch->setFormField('adv_search', '');
$discussionSearch->setFormField('so', 'min');

$discussionSearch->setFormField('numpg',0);
$discussionSearch->setFormField('start',0);
/***********set form field for navigation****/
$discussionSearch->setFormField('asc', 'ft.discussion_topic');
$discussionSearch->setFormField('dsc', '');
/*************Start navigation******/
//fetch number of records show in the result--numpg
$condition = '';
$discussionSearch->numpg = $CFG['data_tbl']['numpg'];
$discussionSearch->setFormField('start', 0);
$discussionSearch->setFormField('numpg', $CFG['data_tbl']['numpg']);

$discussionSearch->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$discussionSearch->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$discussionSearch->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
//Set tables and fields to return
$discussionSearch->setTableNames(array());
$discussionSearch->setReturnColumns(array());

$discussionSearch->sanitizeFormInputs($_REQUEST);
$discussionSearch->search_title = $LANG['search_results'];
$title = $LANG['discussion_search_discussion'];
$discussionSearch->searchOption_arr = array($LANG['search_option_allresult'] => $LANG['search_option_allresult'],
											  $LANG['search_option_today'] => $LANG['search_option_today'],
											  $LANG['search_option_oneday'] => $LANG['search_option_oneday'],
											  $LANG['search_option_oneweek'] => $LANG['search_option_oneweek'],
											  $LANG['search_option_onemonth'] => $LANG['search_option_onemonth'],
											  $LANG['search_option_threemonths'] => $LANG['search_option_threemonths'],
											  $LANG['search_option_sixmonths'] => $LANG['search_option_sixmonths'],
											  $LANG['search_option_oneyear'] => $LANG['search_option_oneyear']);
$discussionSearch->populateCategories_arr = $discussionSearch->populateCategories();
/*************End navigation******/

$discussionSearch->setPageBlockShow('form_show_topics');
$discussionSearch->discussionsAddTitle_url = getUrl('adddiscussion', '', '', 'members', $CFG['admin']['index']['home_module']);

if($CFG['admin']['discussions']['order'] == 'ASC')
	{
		$discussionSearch->setFormField('asc', 'd.date_added');
	}

if($discussionSearch->getFormField('so')=='adv' and !$discussionSearch->isFormPOSTed($_REQUEST, 'adv_search'))
	{
		$discussionSearch->populateSearchFields();
		$discussionSearch->setPageBlockHide('form_show_topics');
		$discussionSearch->setPageBlockShow('form_advanced_search');
		$discussionSearch->search_title = $LANG['advanced_search'];
	}
if($discussionSearch->isFormGETed($_GET, 'adv_search'))
	{
		$discussionSearch->populateSearchFields();
		$discussionSearch->setAllPageBlocksHide();
		$discussionSearch->setPageBlockShow('form_show_topics');
	}
if($discussionSearch->getFormField('uname'))
	{
		$uname = $discussionSearch->getUsersDisplayName($discussionSearch->getFormField('uname'));
		$discussionSearch->search_title = $uname.' - '.$LANG['discussions'];
		$title = $uname.'\'s '.$LANG['discussions'];
		if($CFG['user']['user_id'])
			{
				if($CFG['user']['display_name'] == $uname)
					{
						$discussionSearch->search_title =  $LANG['discussion_search_mydiscussion'];
						$title = $LANG['discussion_search_mydiscussion'];
					}
			}
	}
if($discussionSearch->isFormPOSTed($_POST, 'adv_search'))
	{
		if ($discussionSearch->isValidFormInputs())
			{
				$discussionSearch->storeSearchFields();
			}
		else
			{
				$discussionSearch->setPageBlockHide('form_show_topics');
				$discussionSearch->setPageBlockShow('form_advanced_search');
				$discussionSearch->setPageBlockShow('block_msg_form_error');
				$discussionSearch->setCommonErrorMsg($LANG['err_msg_invalid_search_option']);
			}
	}

if(!$discussionSearch->isFormGETed($_GET, 'search_discussion'))
	{
	   $_SESSION['search_discussion'] = $LANG['header_search_for_discussions'];
	}
if($discussionSearch->isFormPOSTed($_POST, 'search_discussion'))
	{
	   $_SESSION['search_discussion'] = $discussionSearch->getFormField('search_discussion');
	}
if($discussionSearch->isFormGETed($_GET, 'search_discussion'))
	{
	    if(isset($_SESSION['search_discussion']) and $_SESSION['search_discussion'])
		    $discussionSearch->setFormField('search_discussion', $_SESSION['search_discussion']);
	}

if ($discussionSearch->isValidFormInputs())
	{
		if ($discussionSearch->isShowPageBlock('form_show_topics'))
			{
				$discussionSearch->setTableNames(array($CFG['db']['tbl']['discussions'].' as d LEFT JOIN '.$CFG['db']['tbl']['users'].' AS u on d.user_id = u.'.$discussionSearch->getUserTableField('user_id').' LEFT JOIN '.$CFG['db']['tbl']['category'].' AS c on d.pcat_id = c.cat_id LEFT JOIN '.$CFG['db']['tbl']['users'].' AS lp on d.last_post_user_id = lp.'.$discussionSearch->getUserTableField('user_id')));
				$discussionSearch->setReturnColumns(array('d.discussion_title', 'c.cat_name', 'u.'.$discussionSearch->getUserTableField('name').' AS name', 'd.seo_title', 'd.description', 'd.total_boards', 'd.total_solutions', 'DATE_FORMAT(last_post_date, \''.$CFG['mysql_format']['new_date'].'\') as last_post_date_only', 'DATE_FORMAT(last_post_date, \'%h:%m %p\') as last_post_time_only', 'DATE_FORMAT(last_post_date, \''.$CFG['mysql_format']['date_time_meridian'].'\') as last_post_date', 'lp.'.$discussionSearch->getUserTableField('name').' as last_post_user', 'lp.'.$discussionSearch->getUserTableField('display_name').' as last_post_name', 'u.'.$discussionSearch->getUserTableField('name').' as post_user', 'u.'.$discussionSearch->getUserTableField('display_name').' as post_name'));
				//Condition of the query
				$condition = 'd.status = \'Active\'';
				$discussionSearch->buildSelectQuery();
				$discussionSearch->buildConditionQuery($condition);
				$discussionSearch->buildSortQuery();
				$discussionSearch->buildQuery();
				//$discussionSearch->printQuery();
				$discussionSearch->executeQuery();
				/*************End navigation******/
				$discussionSearch->setPageBlockShow('form_discussion_title');
				if($discussionSearch->getFormField('adv_search'))
					$discussionSearch->paging_arr[] = 'adv_search';
				if($discussionSearch->getFormField('so'))
					$discussionSearch->paging_arr[] = 'so';
				if ($discussionSearch->isResultsFound())
					{
						$discussionSearch->form_show_topics_arr = $discussionSearch->showDiscussionSearchResult();
						$smartyObj->assign('smarty_paging_list', $discussionSearch->populatePageLinksGET($discussionSearch->getFormField('start'), $discussionSearch->paging_arr));
					}
			}
	}
else
	{
		$discussionSearch->setPageBlockShow('block_msg_form_error');
		//now redirect to discussions main page...
		Redirect2URL(getUrl('discussions','','','',$CFG['admin']['index']['home_module']));
	}

if ($discussionSearch->isFormPOSTed($_GET, 'msg'))
	{
		$discussionSearch->setCommonSuccessMsg($LANG['discussions_topic_created_successfully']);
		$discussionSearch->setPageBlockShow('block_msg_form_success');
	}
$discussionSearch->discussions_url = getUrl('discussions','','','',$CFG['admin']['index']['home_module']);
$discussionSearch->advanced_search_action = getUrl('discussionsearch', '?so=adv', '?so=adv', '', $CFG['admin']['index']['home_module']);
//<<<<--------------------Code Ends----------------------//
$CFG['site']['title'] = $title.' - '.$CFG['site']['title'];
//--------------------Page block templates begins-------------------->>>>>//
//include the header file
$discussionSearch->includeHeader();
//include the content of the page
setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
$smartyObj->display('discussionSearch.tpl');
//include the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$discussionSearch->includeFooter();
?>