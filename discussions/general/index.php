<?php
/**
 * File to handle the logout
 *
 * By clicking the logout link by the logged in user this file will clear
 * the session and redirect the user to the login page with success message.
 *
 * PHP version 5.0
 *
 * @category	###Discuzz###
 * @package		###index default###
 * @author 		Karthiselvam_75ag08
 * @copyright	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:
 * @since 		2008-12-19
 */
/**
 * File having common configuration variables required for the entire project
 */
class IndexHandler extends DiscussionHandler
	{
		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function createAndShowWeekExperts($limit = 5)
			{
				$this->createWeekExperts();
				return $this->showThisWeekExperts($limit);
			}

		/**
		 * IndexHandler::getBestAnsBoards()
		 *
		 * @param integer $limit
		 * @return
		 */
		public function getBestAnsBoards($limit = 5)
			{
				$sql = 'SELECT q.board_id FROM '.$this->CFG['db']['tbl']['boards'].' AS q'.
						' WHERE q.status IN (\'Active\') AND best_solution_id!=0'.
						' AND EXISTS(SELECT 1 FROM  '.$this->CFG['db']['tbl']['users'].' AS u WHERE u.'.$this->getUserTableField('user_id').' = q.user_id  AND u.'.$this->getUserTableField('user_status').'=\'Ok\')'.
						' AND EXISTS(SELECT 1 FROM  '.$this->CFG['db']['tbl']['discussions'].' AS d, '.$this->CFG['db']['tbl']['category'].' AS c, '.$this->CFG['db']['tbl']['users'].' AS ud'.
						' WHERE d.pcat_id=c.cat_id AND c.status=\'Active\' AND d.user_id = ud.'.$this->getUserTableField('user_id').' AND ud.'.$this->getUserTableField('user_status').'=\'Ok\' AND d.discussion_id = q.discussion_id  AND d.status = \'Active\')'.
						' ORDER BY solution_added DESC LIMIT 0,'.$limit;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
						trigger_db_error($this->dbObj);

				$best_ans_boards = array();
				while($row = $rs->FetchRow())
					{
						$best_ans_boards[] = $row['board_id'];
					}
				return $best_ans_boards;
			}

		/**
		 * IndexHandler::displayBestSolutions()
		 *
		 * @param integer $limit
		 * @return
		 */
		public function displayBestSolutions($limit = 5)
			{
				$this->displayBestSolutions_arr	=	array();
				$this->displayBestSolutions_arr['recent_boards']	=	$recent_boards = $this->getBestAnsBoards($limit);
				$this->displayBestSolutions_arr['have_boards']	=	$have_boards = false;
				$this->displayBestSolutions_arr['total_recs'] = 0;
				global $best_solution;
				if ($recent_boards)
				{
					$this->displayBestSolutions_arr['best_solution']	=	$best_solution = true;
					$this->displayBestSolutions_arr['row']	=	array();
					$i = 0;
					$inc	=	0;
					foreach($recent_boards as $eachBoard)
						{
							$this->displayBestSolutions_arr['row'][$inc]['boardDetails']	=	$boardDetails = $this->getBoardDetails($eachBoard);
							if (!$boardDetails)
								continue;
                            $this->displayBestSolutions_arr['row'][$inc]['solutionDetails']	=	$solutionDetails = $this->getSolutionDetails($boardDetails['best_solution_id']);
                    		if (!$solutionDetails)
							{
								$this->displayBestSolutions_arr['row'][$inc]="";
								$inc++;
								continue;
							}
							$this->displayBestSolutions_arr['have_boards']	=	$have_boards = true;
							$i++;
							$this->displayBestSolutions_arr['row'][$inc]['incr']	=	$i;
							$this->displayBestSolutions_arr['row'][$inc]['clsOddOrEvenBoard']	=	$clsOddOrEvenBoard = 'clsEvenBoard';
 							$this->displayBestSolutions_arr['row'][$inc]['solution_plural']	=	$solution_plural = $this->LANG['discuzz_common_total_solution'];
							if($boardDetails['total_solutions']!= 1)
								$this->displayBestSolutions_arr['row'][$inc]['solution_plural']	=	$solution_plural = $this->LANG['solutions'];
							$this->displayBestSolutions_arr['row'][$inc]['image_id']	=	$boardDetails['image_id'] = 'drq';
							$this->displayBestSolutions_arr['row'][$inc]['wordWrapManual_solution']	=	$solutionDetails['solution'];
							$this->displayBestSolutions_arr['row'][$inc]['solution_url']	=	getUrl('solutions','?title='.$boardDetails['seo_title'], $boardDetails['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']);
							$inc++;
							$this->displayBestSolutions_arr['total_recs'] = $inc;
					 	} //foreach
					if ($have_boards)
						{
							$this->displayBestSolutions_arr['boards_url']	=	getUrl('boards', '?view=best', 'best/', '', $this->CFG['admin']['index']['home_module']);
						}
					return $this->displayBestSolutions_arr;
				}
			}
		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function displayTopDiscussions($limit = 3)
			{
			$limit = 3;
				$sql = 'SELECT d.discussion_title, d.discussion_id, d.user_id, u.'.$this->getUserTableField('name').' AS name, d.seo_title, d.description, d.total_boards, d.total_solutions, d.last_post_user_id'.
						', DATE_FORMAT(d.last_post_date, \''.$this->CFG['mysql_format']['date_time_meridian'].'\') AS last_post_date, DATE_FORMAT(d.last_post_date, \''.$this->CFG['mysql_format']['new_date'].'\') AS last_post_date_only'.
						', DATE_FORMAT(d.last_post_date, \'%h:%m %p\') AS last_post_time_only, lp.'.$this->getUserTableField('name').' as last_post_user, lp.'.$this->getUserTableField('display_name').' as last_post_name'.
						', u.'.$this->getUserTableField('name').' as post_user, u.'.$this->getUserTableField('display_name').' as post_name FROM '.$this->CFG['db']['tbl']['discussions'].' AS d'.
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON d.user_id = u.'.$this->getUserTableField('user_id').''.
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS lp on d.last_post_user_id = lp.'.$this->getUserTableField('user_id').', '.$this->CFG['db']['tbl']['category'].' AS c'.
						' WHERE d.pcat_id = c.cat_id AND c.status = \'Active\' AND d.status = \'Active\' AND u.'.$this->getUserTableField('user_status').'=\'Ok\' '.
						' ORDER BY d.total_boards DESC, d.total_solutions DESC LIMIT 0, '.$this->dbObj->Param($limit);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($limit));
				if (!$rs)
					    trigger_db_error($this->dbObj);

				$discussion_titles  = array();
				if ($rs->PO_RecordCount())
					{
						while ($row = $rs->FetchRow()){
							$row['discussionBoards']['url'] = getUrl('boards', '?title='.$row['seo_title'], $row['seo_title'].'/', '', $this->CFG['admin']['index']['home_module']);
							$row['discussionBoards']['title'] = wordWrapManual($row['discussion_title'], 15);
							$row['discussion_description_manual'] = nl2br(wordWrapManual($row['description'], 15));
							$row['myanswers']['url'] = getMemberUrl($row['user_id'], $row['post_user']);
							$row['lastPost']['url'] = getMemberUrl($row['last_post_user_id'], $row['last_post_user']);
							$row['last_post_name1'] = stripString($row['last_post_name'], 20);
							$discussion_titles[] = $row;
						}
					}
				return $discussion_titles;
			}
		/**
		 * $photoIndex::myHomeActivity()
		 *
		 * @return void
		 */
		public function myHomeActivity()
		{
			global $smartyObj;
			setTemplateFolder('members/');
			$smartyObj->display('myHomeActivity.tpl');
		}

	}
//<<<<<-------------- Class IndexHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//
$indexhandler = new IndexHandler();
$indexhandler->setPageBlockNames(array('msg_form_error', 'form_recent_boards', 'form_recently_solutioned_boards', 'form_popular_boards', 'form_week_experts',
									   'form_best_solution', 'form_featured_contributor', 'form_top_contributor', 'form_top_discussion', 'form_recent_activities'));
//form fields
$indexhandler->setFormField('search_board', '');
$indexhandler->setFormField('show', '');
$indexhandler->setFormField('activity_type', '');
$page_id_overwrite = 'indexdefault';
$indexhandler->sanitizeFormInputs($_REQUEST);
//Create widget object
if ($indexhandler->isFormPOSTed($_REQUEST, 'show'))
	{
		$indexhandler->setAllPageBlocksHide();
		$indexhandler->form_recent_boards['recentQStyle']	=	$indexhandler->form_popular_boards['popularQStyle']	=	$indexhandler->form_recently_solutioned_boards['recentSolutionedQStyle'] = $indexhandler->form_top_discussion['topdiscussionQStyle'] = '';
		$indexhandler->form_featured_contributor['featuredBStyle']	=	$indexhandler->form_top_contributor['topBStyle']	=	$indexhandler->form_week_experts['expertBStyle']	=	'';
		ob_start();
		switch($indexhandler->getFormField('show')){
			case 'selPopularBoards':
				$indexhandler->form_popular_boards['displayPopularBoards']	=	$indexhandler->displayPopularBoards($CFG['admin']['index']['popular_boards_count']);
				$indexhandler->setPageBlockShow('form_popular_boards');
				break;
			case 'selRecentlySolutioned':
				$indexhandler->form_recently_solutioned_boards['displayRecentlySolutionedBoards']	=	$indexhandler->displayRecentlySolutionedBoards($CFG['admin']['index']['recently_solutioned_count']);
				$indexhandler->setPageBlockShow('form_recently_solutioned_boards');
				break;
			case 'selTopContributors':
				$indexhandler->form_top_contributor['displayTopContributor']	=	$indexhandler->displayTopContributor($CFG['admin']['index']['top_contributor_count']);
				$indexhandler->setPageBlockShow('form_top_contributor');
				break;
			case 'selWeekContributors':
				$indexhandler->form_week_experts['createAndShowWeekExperts']	=	$indexhandler->createAndShowWeekExperts($CFG['admin']['index']['top_contributor_count_week']);
				$indexhandler->setPageBlockShow('form_week_experts');
				break;
		} // switch
		$indexhandler->includeAjaxHeader();
		setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
		$smartyObj->display('index.tpl');
		$indexhandler->includeAjaxFooter();
		die();
	}
//To get users options
$user_options = $indexhandler->getUserOptions();
// Default page block
$indexhandler->setAllPageBlocksHide();
if ($indexhandler->isShowIndexBlock($CFG['admin']['index']['recent_boards'], $user_options['recent_boards']))
	$indexhandler->setPageBlockShow('form_recent_boards');
if ($indexhandler->isShowIndexBlock($CFG['admin']['index']['recently_solutioned'], $user_options['recently_solutioned']))
	$indexhandler->setPageBlockShow('form_recently_solutioned_boards');
if ($indexhandler->isShowIndexBlock($CFG['admin']['index']['popular_boards'], $user_options['popular_boards']))
	$indexhandler->setPageBlockShow('form_popular_boards');
if ($indexhandler->isShowIndexBlock($CFG['admin']['index']['best_of_solution'], $user_options['best_of_solution']))
	$indexhandler->setPageBlockShow('form_best_solution');
if ($indexhandler->isShowIndexBlock($CFG['admin']['index']['top_discussions'], $user_options['top_discussions']))
	$indexhandler->setPageBlockShow('form_top_discussion');

if($CFG['admin']['index']['activity']['show'])
	{
		$indexhandler->setPageBlockShow('form_recent_activities');
		/*$discuzzActivities = new DiscussionsActivityHandler();
		$smartyObj->assign('module_total_records', '0');
		$discuzzActivities->populateActivities($CFG['admin']['index']['activity']['count'], 'discussions');
		$indexhandler->setPageBlockShow('form_recent_activities');
		$activity_view_all_url = getUrl('discuzzActivities', '', '', 'members', $CFG['admin']['index']['home_module']);
		$smartyObj->assign('activity_view_all_url', $activity_view_all_url);*/
	}

if($CFG['user']['user_id'])
	$page_id_overwrite = 'membersindexdefault';
//<<<<<-------------------- Code ends ----------------------//
//--------------------Page block templates begins-------------------->>>>>//
$indexhandler->form_recent_boards['recentQStyle']	=	$indexhandler->form_popular_boards['popularQStyle']	 =	$indexhandler->form_recently_solutioned_boards['recentSolutionedQStyle'] =	$indexhandler->form_top_discussion['topdiscussionQStyle'] = '';

if ($indexhandler->isShowPageBlock('form_top_discussion'))
	{
		$indexhandler->form_top_discussion['displayTopDiscussions']	=	$indexhandler->displayTopDiscussions($CFG['admin']['discussions']['index_page']['limit']);
	   	$indexhandler->form_top_discussion['discussions_url']	=  getUrl('discussions', '', '', '', $CFG['admin']['index']['home_module']);
	}
if ($indexhandler->isShowPageBlock('form_best_solution'))
	{
		$indexhandler->form_best_solution['displayBestSolutions']	=	$indexhandler->displayBestSolutions($CFG['admin']['index']['best_ans_boards_count']);
	}
if ($indexhandler->isShowPageBlock('form_recent_boards'))
	{
	   	$indexhandler->form_recent_boards['displayRecentBoards']	=	$indexhandler->displayRecentBoards($CFG['admin']['index']['recent_boards_count']);
	}
if ($indexhandler->isShowPageBlock('form_recently_solutioned_boards'))
	{
	   if (!$indexhandler->form_recently_solutioned_boards['recentSolutionedQStyle'])
		$indexhandler->form_recently_solutioned_boards['displayRecentlySolutionedBoards']	=	$indexhandler->displayRecentlySolutionedBoards($CFG['admin']['index']['recently_solutioned_count']);
	}
if ($indexhandler->isShowPageBlock('form_popular_boards'))
	{
		if (!$indexhandler->form_popular_boards['popularQStyle'])
			$indexhandler->form_popular_boards['displayPopularBoards']	=	$indexhandler->displayPopularBoards($CFG['admin']['index']['popular_boards_count']);
	}

if(isAjaxPage())
{
	$indexhandler->sanitizeFormInputs($_REQUEST);
	$indexhandler->includeAjaxHeaderSessionCheck();
	if($indexhandler->getFormField('activity_type')!= '')
	{
		if($indexhandler->getFormField('activity_type') == 'Friends' and !$indexhandler->getTotalFriends($CFG['user']['user_id']))
		{
			echo '<div class="clsNoRecordsFound">'.$LANG['index_activities_no_friends'].'</div>';
			exit;
		}
		$activity_view_all_url = getUrl('activity', '?pg='.strtolower($indexhandler->getFormField('activity_type')), strtolower($indexhandler->getFormField('activity_type')).'/updates/', '');
		$smartyObj->assign('activity_view_all_url', $activity_view_all_url);
		$Activity = new ActivityHandler();
		$Activity->setActivityType(strtolower($indexhandler->getFormField('activity_type')), 'discussions');
		$indexhandler->myHomeActivity();
		exit;
	}
}
//include the header file
$indexhandler->includeHeader();
//include the content of the page
setTemplateFolder('general/', $CFG['admin']['index']['home_module']);
$smartyObj->display('index.tpl');
//includ the footer of the page
	?>
	<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>discussions/js/contentslider.js"></script>
	<script language="javascript" type="text/javascript">
        var fad_time_delay = 3500;
		var alreadyClicked = false;
		var src_previousImage = SITE_URL + 'discussions/design/templates/'+SITE_TEMPLATE+'/images/rewind.gif';
		var src_nextImage = SITE_URL + 'discussions/design/templates/'+SITE_TEMPLATE+'/images/forward.gif';
		var statusplay = "play";
		featuredcontentslider.init({
			id: "slider1",  //id of main slider DIV
			contentsource: ["inline", ""],  //Valid values: ["inline", ""] or ["ajax", "path_to_file"]
			toc: "#increment",  //Valid values: "#increment", "markup", ["label1", "label2", etc]
			nextprev: ["", ""],  //labels for "prev" and "next" links. Set to "" to hide.
			nextprevbottom: ["<img src= "+src_previousImage+ " />", "<img src= "+src_nextImage+ " />"],  //labels for "prev" and "next" links. Set to "" to hide.
			revealtype: "click", //Behavior of pagination links to reveal the slides: "click" or "mouseover"
			enablefade: [true, 0.2],  //[true/false, fadedegree]
			autorotate: [true, fad_time_delay],  //[true/false, pausetime]
			onChange: function(previndex, curindex){  //event handler fired whenever script changes slide
				//previndex holds index of last slide viewed b4 current (1=1st slide, 2nd=2nd etc)
				//curindex holds index of currently shown slide (1=1st slide, 2nd=2nd etc)
			}
		})
	</script>
	<script type="text/javascript" language="javascript">
		var ajax_url = '<?php echo getUrl('index','','','',$CFG['admin']['index']['home_module']);?>';
		var hideBlocks = function(){
			for(var i=0;i<arguments.length;i++){
				var objName = arguments[i];
				var liName = objName+'LI';
				var spanName = objName+'SPAN';
				var aName = objName+'A';
				if(obj = $Jq('#'+objName)){
					obj.css('display', 'none');
					$Jq('#'+liName).attr('className', 'clsLeftInActiveBoardsLink');
					$Jq('#'+spanName).attr('className', 'clsRightInActiveBoardsLink');
					$Jq('#'+aName).attr('className', 'clsMiddleInActiveBoardsLink');
				}
			}
		}
		var showBlocks = function(){
			for(var i=0;i<arguments.length;i++) {
				var objName = arguments[i];
				var liName = objName+'LI';
				var spanName = objName+'SPAN';
				var aName = objName+'A';
				if(obj = $Jq('#'+objName)) {
					obj.css('display', '');
					if (objName == 'selRecentBoards' || objName == 'selFeaturedContributors')
						$Jq('#'+liName).attr('className', 'clsFirstBoardLink clsLeftActiveBoardsLink');
					else if (objName == 'selPopularBoards' && !($Jq('#selRecentBoards')))
						$Jq('#'+liName).attr('className', 'clsFirstBoardLink clsLeftActiveBoardsLink');
					else if (objName == 'selTopContributors' && !($Jq('#selFeaturedContributors')))
						$Jq('#'+liName).attr('className', 'clsFirstBoardLink clsLeftActiveBoardsLink');
					else if (objName == 'selRecentlySolutioned' && !($Jq('#selRecentlySolutioned')))
						$Jq('#'+liName).attr('className', 'clsFirstBoardLink clsLeftActiveBoardsLink');
					else
						$Jq('#'+liName).attr('className', 'clsLeftActiveBoardsLink');
					$Jq('#'+spanName).attr('className', 'clsRightActiveBoardsLink');
					$Jq('#'+aName).attr('className', 'clsMiddleActiveBoardsLink');
				}
			}
		}
	</script>
<?php
//<<<<<<--------------------Page block templates Ends--------------------//
$indexhandler->includeFooter();
?>