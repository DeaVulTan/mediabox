<?php
/**
 * This file is to manage flagged video
 *
 * Provides an interface to view the number of flags given to the
 * video, and to view the flags given to the video abd to give
 * Flag status, to Unflag it, and to delete video.
 * the video.
 *
 *
 * @category	rayzz
 * @package		Admin
 *
 **/
require_once('../../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'video';
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/admin/manageFlaggedVideo.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['site']['is_module_page']='video';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class ConfigEdit begins -------------------->>>>>//
/**
 * ManageFlagged
 *
 * @category	rayzz
 * @package		Admin
 **/
class ManageFlagged extends MediaHandler
	{
		/**
		 * ManageFlagged::buildConditionQuery()
		 *
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'F.status=\'Ok\' AND F.content_type=\'Video\' AND P.video_status=\'Ok\' AND P.flagged_status<>\'Yes\' GROUP BY F.content_id ';
			}

		/**
		 * VideoList::buildSortQuery()
		 *
		 * @return void
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'total_requests DESC';
			}

		/**
		 * ManageFlagged::getUserName()
		 *
		 * @param $user_id
		 * @return void
		 **/
		public function getUserName($user_id)
			{
				$sql = 'SELECT user_name, first_name, last_name FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param($user_id).' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$name = $this->CFG['format']['name'];
						$name = str_replace('$first_name', $row['first_name'],$name);
						$name = str_replace('$last_name', $row['last_name'],$name);
						$name = str_replace('$user_name', $row['user_name'],$name);
						echo $name;
					}
			}

		/**
		 * ManageFlagged::getCountOfRequests()
		 *
		 * @param Integer $video_id
		 * @return void
		 */
		public function getCountOfRequests($video_id)
			{
				$sql = 'SELECT COUNT(1) as total_count, flag FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
						' content_type=\'Video\' AND content_id='.$this->dbObj->Param($video_id).
						' AND status=\'Ok\' GROUP BY flag order by flag';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				while($row = $rs->FetchRow())
					{
?>
					<span id="clsBold"><?php echo $row['flag'],' : ';?></span><?php echo $row['total_count'];?><br />
<?php
					}
			}

		/**
		 * ManageFlagged::displayVideoList()
		 *
		 * @return void
		 **/
		public function displayVideoList()
			{
				global $smartyObj;
				$displayVideoList_arr = array();

				$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/';
				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						$displayVideoList_arr[$inc]['checked'] = '';
					 	if((is_array($this->fields_arr['video_ids'])) && (in_array($row['video_id'], $this->fields_arr['video_ids'])))
							$displayVideoList_arr[$inc]['checked'] = "checked";

						$displayVideoList_arr[$inc]['record'] = $row;
						//$this->getUserName($row['user_id']);
					  	//$this->getCountOfRequests($row['video_id']);

						$inc++;
					}
				$smartyObj->assign('displayVideoList_arr', $displayVideoList_arr);
			}

		/**
		 * ManageFlagged::displayFlaggedList()
		 *
		 * @return void
		 **/
		public function displayFlaggedList()
			{
				global $smartyObj;
				$displayFlaggedList_arr = array();
				$sql = 'SELECT F.flag, F.flag_comment, F.date_added, U.user_name, U.first_name, U.last_name FROM'.
						' '.$this->CFG['db']['tbl']['flagged_contents'].' AS F LEFT JOIN'.
						' '.$this->CFG['db']['tbl']['users'].' AS U ON U.user_id=F.reporter_id'.
						' WHERE F.content_id='.$this->dbObj->Param($this->fields_arr['video_id']).
						' AND F.status=\'Ok\' ORDER BY F.date_added DESC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$displayFlaggedList_arr['rs_PO_RecordCount'] = $rs->PO_RecordCount();
				if($rs->PO_RecordCount())
					{
						$displayFlaggedList_arr['row'] = array();
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								$name = $this->CFG['format']['name'];
								$name = str_replace('$first_name', $row['first_name'],$name);
								$name = str_replace('$last_name', $row['last_name'],$name);
								$name = str_replace('$user_name', $row['user_name'],$name);
								$displayFlaggedList_arr['row'][$inc]['name'] = $name;
								$displayFlaggedList_arr['row'][$inc]['record'] = $row;
								$inc++;
							}
					}
				$smartyObj->assign('displayFlaggedList_arr', $displayFlaggedList_arr);
			}

		/**
		 * VideoUpload::populateVideoDetails()
		 *
		 * @return boolean
		 **/
		public function populateVideoDetails()
			{
				$sql = 'SELECT P.video_title, U.user_name, U.email, U.user_id FROM'.
						' '.$this->CFG['db']['tbl']['video'].' as P LEFT JOIN '.$this->CFG['db']['tbl']['users'].
						' AS U ON P.user_id=U.user_id WHERE'.
						' video_id='.$this->dbObj->Param($this->fields_arr['video_id']).' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->VIDEO_TITLE = $row['video_title'];
						$this->VIDEO_USER_NAME = $row['user_name'];
						$this->VIDEO_USER_EMAIL = $row['email'];
						$this->VIDEO_USER_ID = $row['user_id'];
						return true;
					}
				return false;
			}

		/**
		 * ManageFlagged::activateFlaggedVideo()
		 * To UnFlag a Flagged Video (To disaprove flags)
		 *
		 * @return void
		 **/
		public function activateFlaggedVideo()
			{
				/*$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
						' content_id IN('.$this->fields_arr['video_ids'].')'.
						' AND content_type=\'Video\'';*/

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['flagged_contents'].' '.
						' SET status=\'Deleted\' WHERE'.
						' content_id IN('.$this->fields_arr['video_ids'].') AND content_type=\'Video\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		/**
		 * ManageFlagged::flagFlaggedVideo()
		 * To Flag a Flagged Video (To approve flag)
		 *
		 * @return void
		 **/
		public function flagFlaggedVideo()
			{
				$this->populateVideoDetails();
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET flagged_status=\'Yes\''.
						' WHERE video_id IN('.$this->fields_arr['video_ids'].')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				/*$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
						' content_id IN('.$this->fields_arr['video_ids'].') AND content_type=\'Video\'';*/
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['flagged_contents'].' '.
						' SET status=\'Deleted\' WHERE'.
						' content_id IN('.$this->fields_arr['video_ids'].') AND content_type=\'Video\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}

		/**
		 * ManageFlagged::deleteFlaggedVideo()
		 * To delete flag, other video related contents and will apply 'Delete' Status to Video
		 *
		 *
		 * @return boolean
		 **/
		public function deleteFlaggedVideo()
			{
				$sql = 'SELECT user_id, video_id FROM '.$this->CFG['db']['tbl']['video'].' WHERE video_id IN('.$this->fields_arr['video_ids'].')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				while($row = $rs->FetchRow())
				    {
					    $user_details[$row['video_id']] = $row['user_id'];
				    }
				$video_id = explode(',',$this->fields_arr['video_ids']);
				foreach($video_id as $videokey=>$videovalue)
					{
						$videoHandler = new VideoHandler();
						$videoHandler->deleteVideos(array($videovalue), $user_details[$videovalue]);
					}
				return true;
			}
	}
//<<<<<-------------- Class ManageFlagged begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ManageFlagged = new ManageFlagged();
$ManageFlagged->setPageBlockNames(array('confirmation_block', 'list_flagged_video_form', 'flagged_details_form', 'activate_confirmation_form', 'flag_confirmation_form', 'delete_confirmation_form'));
//default form fields and values...
$action_arr = array('delete'=>$LANG['manageflagged_delete'], 'flag'=>$LANG['manageflagged_flag'], 'activate'=>$LANG['manageflagged_activate']);
$ManageFlagged->setFormField('video_id', '');
$ManageFlagged->setFormField('action', '');
$ManageFlagged->setFormField('action_select', '');
$ManageFlagged->setFormField('video_ids', array());
/*********** Page Navigation Start *********/
$ManageFlagged->setFormField('slno', '1');
$ManageFlagged->setTableNames(array($CFG['db']['tbl']['flagged_contents'].' AS F LEFT JOIN '.$CFG['db']['tbl']['video'].' as P ON F.content_id=P.video_id'));
$ManageFlagged->setReturnColumns(array('P.video_id', 't_width', 't_height', 'video_server_url','video_ext','P.user_id','P.video_title', 'P.user_id', 'COUNT(F.content_id) AS total_requests'));
/************ page Navigation stop *************/
$ManageFlagged->setAllPageBlocksHide();
$ManageFlagged->setPageBlockShow('list_flagged_video_form');
$ManageFlagged->sanitizeFormInputs($_REQUEST);
//print_r($_POST); exit;
if($ManageFlagged->isFormGETed($_GET, 'action'))
	{
		if($ManageFlagged->getFormField('action')=='detail')
			{
				$ManageFlagged->setAllPageBlocksHide();
				$ManageFlagged->setPageBlockShow('flagged_details_form');
			}
	}
if($ManageFlagged->isFormGETed($_POST, 'video_submit'))
	{
		$ManageFlagged->chkIsNotEmpty('video_ids', $LANG['err_tip_compulsory']);
		if($ManageFlagged->isValidFormInputs())
			{
				$video_ids = $ManageFlagged->getFormField('video_ids');
				$video_id = '';
				foreach($video_ids as $value)
					$video_id .= $value.',';
				$video_id = substr($video_id, 0, strrpos($video_id, ','));

				$ManageFlagged->setFormField('video_id', $video_id);
				$value = $ManageFlagged->getFormField('action_select').'_confirmation';
				$LANG['confirmation'] = $LANG[$value];
				$ManageFlagged->setPageBlockShow('confirmation_block');
			}
		else
			{
				$ManageFlagged->setCommonErrorMsg($LANG['err_tip_select_category']);
				$ManageFlagged->setPageBlockShow('block_msg_form_error');
			}
	}
if($ManageFlagged->isFormGETed($_POST, 'yes'))
	{
		switch($ManageFlagged->getFormField('action'))
			{
				case 'Unflag':
					$ManageFlagged->activateFlaggedVideo();
					$ManageFlagged->setCommonSuccessMsg($LANG['msg_success_acivate']);
					$ManageFlagged->setPageBlockShow('block_msg_form_success');
					break;

				case 'Flag':
					$ManageFlagged->flagFlaggedVideo();
					$ManageFlagged->setCommonSuccessMsg($LANG['msg_success_flag']);
					$ManageFlagged->setPageBlockShow('block_msg_form_success');
					break;

				case 'Delete':
					$ManageFlagged->deleteFlaggedVideo();
					$ManageFlagged->setCommonSuccessMsg($LANG['msg_success_delete']);
					$ManageFlagged->setPageBlockShow('block_msg_form_success');
					break;
			}
	}
//<<<<<-------------------- Code ends----------------------//
$ManageFlagged->hidden_arr = array('start');
if ($ManageFlagged->isShowPageBlock('flagged_details_form'))
    {
    	$ManageFlagged->displayFlaggedList();
	}
if ($ManageFlagged->isShowPageBlock('list_flagged_video_form'))
    {
		/****** navigtion continue*********/
		$ManageFlagged->buildSelectQuery();
		$ManageFlagged->buildConditionQuery();
		$ManageFlagged->buildSortQuery();
		$ManageFlagged->buildQuery();
		//$ManageFlagged->printQuery();
		if($ManageFlagged->isGroupByQuery())
			$ManageFlagged->homeExecuteQuery();
		else
			$ManageFlagged->executeQuery();
		/******* Navigation End ********/
		if($ManageFlagged->isResultsFound())
			{
				$paging_arr = array();
				$ManageFlagged->displayVideoList();
				$smartyObj->assign('smarty_paging_list', $ManageFlagged->populatePageLinksGET($ManageFlagged->getFormField('start'), $paging_arr));
			}
    }
$ManageFlagged->left_navigation_div = 'videoMain';
//include the header file
$ManageFlagged->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'video');
$smartyObj->display('manageFlaggedVideo.tpl');
//-------------------- Page block templates begins -------------------->>>>>//
?>
<script language="javascript" type="text/javascript">
	var block_arr= new Array('selMsgConfirm');
	function popupWindow(url)
		{
			 window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
			 return false;
		}
</script>
<?php
//<<<<<-------------------- Page block templates ends -------------------//
$ManageFlagged->includeFooter();
?>