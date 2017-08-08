<?php
/**
* This file is to manage flagged music
*
* @category	rayzz
* @package		Admin
*
**/
require_once('../../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'music';
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/manageFlaggedMusic.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['site']['is_module_page']='music';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
* ManageFlagged Music
*
* @category	rayzz
* @package		Admin
**/
class ManageFlagged extends MusicHandler
	{
		/**
		* ManageFlagged::buildConditionQuery()
		*
		* @return void
		**/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'F.status=\'Ok\' AND F.content_type=\'Music\' AND P.music_status=\'Ok\' AND P.flagged_status<>\'Yes\' GROUP BY F.content_id ';
			}
		/**
		* musicList::buildSortQuery()
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
						return $name;
					}
			}
		/**
		* ManageFlagged::getCountOfRequests()
		*
		* @param Integer $music_id
		* @return void
		*/
		public function getCountOfRequests($music_id)
			{		
				global $smartyObj;
				$displayCountRequestList_arr = array();
				$sql = 'SELECT COUNT(1) as total_count, flag FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
				' content_type=\'Music\' AND content_id='.$this->dbObj->Param($music_id).
				' AND status=\'Ok\' GROUP BY flag order by flag';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				while($row = $rs->FetchRow())
					{
						return $row['flag'].' : '.$row['total_count'];
					}
			}
		/**
		* ManageFlagged::displaymusicList()
		*
		* @return void
		**/
		public function displayMusicList()
			{
				global $smartyObj;
				$displayMusicList_arr = array();
				$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/';
				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						$displayMusicList_arr[$inc]['checked'] = '';
						if((is_array($this->fields_arr['music_ids'])) && (in_array($row['music_id'], $this->fields_arr['music_ids'])))
						$displayMusicList_arr[$inc]['checked'] = "checked";
						$displayMusicList_arr[$inc]['record'] = $row;
						$inc++;
					}
				$smartyObj->assign('displayMusicList_arr', $displayMusicList_arr);
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
				' WHERE F.content_id='.$this->dbObj->Param($this->fields_arr['music_id']).
				' AND F.status=\'Ok\' ORDER BY F.date_added DESC';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
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
		* MusicUpload::populatemusicDetails()
		*
		* @return boolean
		**/
		public function populateMusicDetails()
			{
				$sql = 'SELECT P.music_title, U.user_name, U.email, U.user_id FROM'.
				' '.$this->CFG['db']['tbl']['music'].' as P LEFT JOIN '.$this->CFG['db']['tbl']['users'].
				' AS U ON P.user_id=U.user_id WHERE'.
				' music_id='.$this->dbObj->Param($this->fields_arr['music_id']).' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				if($row = $rs->FetchRow())
					{
						$this->MUSIC_TITLE = $row['music_title'];
						$this->MUSIC_USER_NAME = $row['user_name'];
						$this->MUSIC_USER_EMAIL = $row['email'];
						$this->MUSIC_USER_ID = $row['user_id'];
						return true;
					}
				return false;
			}
		/**
		* ManageFlagged::activateFlaggedMusic()
		* To UnFlag a Flagged music (To disaprove flags)
		*
		* @return void
		**/
		public function activateFlaggedMusic()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['flagged_contents'].' '.
				' SET status=\'Deleted\' WHERE'.
				' content_id IN('.$this->fields_arr['music_ids'].') AND content_type=\'Music\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		/**
		* ManageFlagged::flagFlaggedMusic()
		* To Flag a Flagged music (To approve flag)
		*
		* @return void
		**/
		public function flagFlaggedMusic()
			{
				$this->populateMusicDetails();
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET flagged_status=\'Yes\''.
				' WHERE music_id IN('.$this->fields_arr['music_ids'].')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['flagged_contents'].' '.
				' SET status=\'Deleted\' WHERE'.
				' content_id IN('.$this->fields_arr['music_ids'].') AND content_type=\'Music\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		/**
		* ManageFlagged::deleteFlaggedmusic()
		* To delete flag, other music related contents and will apply 'Delete' Status to music
		*
		*
		* @return boolean
		**/
		public function deleteFlaggedMusic()
			{
				$sql = 'SELECT user_id, music_id FROM '.$this->CFG['db']['tbl']['music'].' WHERE music_id IN('.$this->fields_arr['music_ids'].')';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				while($row = $rs->FetchRow())
					{
						$user_details[$row['music_id']] = $row['user_id'];
					}
				$music_id = explode(',',$this->fields_arr['music_ids']);
				foreach($music_id as $key=>$value)
					{
						$this->deleteMusics(array($value), $user_details[$value]);
					}
				return true;
		    }
}
//<<<<<-------------- Class ManageFlagged begins ---------------//

$ManageFlaggedMusic = new ManageFlagged();
$ManageFlaggedMusic->setPageBlockNames(array('confirmation_block', 'list_flagged_music_form', 'flagged_details_form', 'activate_confirmation_form', 'flag_confirmation_form', 'delete_confirmation_form'));
$action_arr = array('delete'=>$LANG['manageflagged_delete'], 'flag'=>$LANG['manageflagged_flag'], 'activate'=>$LANG['manageflagged_activate']);
$ManageFlaggedMusic->setFormField('music_id', '');
$ManageFlaggedMusic->setFormField('action', '');
$ManageFlaggedMusic->setFormField('action_select', '');
$ManageFlaggedMusic->setFormField('music_ids', array());
/*********** Page Navigation Start *********/
$ManageFlaggedMusic->setFormField('slno', '1');
$ManageFlaggedMusic->setTableNames(array($CFG['db']['tbl']['flagged_contents'].' AS F LEFT JOIN '.$CFG['db']['tbl']['music'].' as P ON F.content_id=P.music_id'));
$ManageFlaggedMusic->setReturnColumns(array('P.music_id', 'P.thumb_width', 'P.thumb_height', 'music_server_url','music_ext','P.user_id','P.music_title', 'P.user_id', 'COUNT(F.content_id) AS total_requests'));
/************ page Navigation stop *************/
$ManageFlaggedMusic->setAllPageBlocksHide();
$ManageFlaggedMusic->setPageBlockShow('list_flagged_music_form');
$ManageFlaggedMusic->sanitizeFormInputs($_REQUEST);
//print_r($_POST); exit;
if($ManageFlaggedMusic->isFormGETed($_GET, 'action'))
	{
		if($ManageFlaggedMusic->getFormField('action')=='detail')
			{
				$ManageFlaggedMusic->setAllPageBlocksHide();
				$ManageFlaggedMusic->setPageBlockShow('flagged_details_form');
			}
	}
if($ManageFlaggedMusic->isFormGETed($_POST, 'music_submit'))
	{
		$ManageFlaggedMusic->chkIsNotEmpty('music_ids', $LANG['err_tip_compulsory']);
		if($ManageFlaggedMusic->isValidFormInputs())
			{
				$music_ids = $ManageFlaggedMusic->getFormField('music_ids');
				$music_id = '';
				foreach($music_ids as $value)
				$music_id .= $value.',';
				$music_id = substr($music_id, 0, strrpos($music_id, ','));
				$ManageFlaggedMusic->setFormField('music_id', $music_id);
				$value = $ManageFlaggedMusic->getFormField('action_select').'_confirmation';
				$LANG['confirmation'] = $LANG[$value];
				$ManageFlaggedMusic->setPageBlockShow('confirmation_block');
			}
		else
			{
				$ManageFlaggedMusic->setCommonErrorMsg($LANG['err_tip_select_category']);
				$ManageFlaggedMusic->setPageBlockShow('block_msg_form_error');
			}
	}

if($ManageFlaggedMusic->isFormGETed($_POST, 'back_submit'))
	{
		$ManageFlaggedMusic->setAllPageBlocksHide();
		$ManageFlaggedMusic->setPageBlockShow('list_flagged_music_form');
	}
if($ManageFlaggedMusic->isFormGETed($_POST, 'yes'))
	{
	switch($ManageFlaggedMusic->getFormField('action'))
		{
		case 'Unflag':
		$ManageFlaggedMusic->activateFlaggedMusic();
		$ManageFlaggedMusic->setCommonSuccessMsg($LANG['msg_success_acivate']);
		$ManageFlaggedMusic->setPageBlockShow('block_msg_form_success');
		break;
		case 'Flag':
		$ManageFlaggedMusic->flagFlaggedMusic();
		$ManageFlaggedMusic->setCommonSuccessMsg($LANG['msg_success_flag']);
		$ManageFlaggedMusic->setPageBlockShow('block_msg_form_success');
		break;
		case 'Delete':
		$ManageFlaggedMusic->deleteFlaggedMusic();
		$ManageFlaggedMusic->setCommonSuccessMsg($LANG['msg_success_delete']);
		$ManageFlaggedMusic->setPageBlockShow('block_msg_form_success');
		break;
		}
	}
//<<<<<-------------------- Code ends----------------------//
$ManageFlaggedMusic->hidden_arr = array('start');
if ($ManageFlaggedMusic->isShowPageBlock('flagged_details_form'))
	{
		$ManageFlaggedMusic->displayFlaggedList();
	}
if ($ManageFlaggedMusic->isShowPageBlock('list_flagged_music_form'))
	{
		/****** navigtion continue*********/
		$ManageFlaggedMusic->buildSelectQuery();
		$ManageFlaggedMusic->buildConditionQuery();
		$ManageFlaggedMusic->buildSortQuery();
		$ManageFlaggedMusic->buildQuery();
		//$ManageFlaggedMusic->printQuery();
		if($ManageFlaggedMusic->isGroupByQuery())
		$ManageFlaggedMusic->homeExecuteQuery();
		else
		$ManageFlaggedMusic->executeQuery();
		/******* Navigation End ********/
		if($ManageFlaggedMusic->isResultsFound())
			{
				$paging_arr = array();
				$ManageFlaggedMusic->displayMusicList();
				$smartyObj->assign('smarty_paging_list', $ManageFlaggedMusic->populatePageLinksGET($ManageFlaggedMusic->getFormField('start'), $paging_arr));
			}
	}
$ManageFlaggedMusic->left_navigation_div = 'musicMain';	
//include the header file
$ManageFlaggedMusic->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
setTemplateFolder('admin/', 'music');
$smartyObj->display('manageFlaggedMusic.tpl');
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
$ManageFlaggedMusic->includeFooter();
?>