<?php
/**
 * This file is to Music Lyrics Activate
 *
 * This file is having Music Lyrics Activate
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Admin
 * @author
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 **/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/musicLyricsActivate.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['lang']['include_files'][] = 'common/music_common_functions.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicUpload.lib.php';
$CFG['site']['is_module_page']='music';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');


class MusicLyricsActivate extends MediaHandler
	{
		/**
		* MusicLyricsActivate::buildConditionQuery()
		*
		* @return
		**/
		public function buildConditionQuery()
		{
			$this->sql_condition = 'ml.lyric_status=\'No\' ';
		}
		/**
		* MusicLyricsActivate::buildSortQuery()
		*
		* @return
		**/
		public function buildSortQuery()
		{
			$this->sql_sort = 'ml.music_lyric_id DESC';
		}
		/**
		* MusicLyricsActivate::displaymusicList()
		*
		* @return
		**/
		public function displaymusicList()
		{
			global $smartyObj;
			$displayMusicList_arr = array();
			$inc = 0;
			while($row = $this->fetchResultRecord())
			{
				$row['music_title'] = wordWrap_mb_ManualWithSpace($row['music_title'], $this->CFG['admin']['musics']['music_lyric_title_length'], $this->CFG['admin']['musics']['music_lyric_title_length'], $this->CFG['admin']['musics']['music_lyric_title_total_length']);
				$displayMusicList_arr['row'][$inc]['record'] = $row;
				$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
				$displayMusicList_arr['row'][$inc]['music_lyric_id']=$row['music_lyric_id'];
				$displayMusicList_arr['row'][$inc]['user_name']=$row['user_name'];
				$displayMusicList_arr['row'][$inc]['lyric']=wordWrap_mb_ManualWithSpace($row['lyric'], $this->CFG['admin']['musics']['music_lyric_title_length'], $this->CFG['admin']['musics']['music_lyric_title_length'], $this->CFG['admin']['musics']['music_lyric_title_total_length']);
				$displayMusicList_arr['row'][$inc]['viewLyrics_url'] = $this->CFG['site']['url'].'admin/music/manageLyrics.php?music_id='.$row['music_id'].'&amp;music_lyric_id='.$row['music_lyric_id'].'&amp;action=Edit';
				$displayMusicList_arr['row'][$inc]['setBestLyrics_url'] = $this->CFG['site']['url'].'admin/music/manageLyrics.php?music_id='.$row['music_id'];
				$displayMusicList_arr['row'][$inc]['DISP_IMAGE'] = DISP_IMAGE($this->CFG['admin']['musics']['small_width'], $this->CFG['admin']['musics']['small_height'], $row['small_width'], $row['small_height']);
				$inc++;
			}
			$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/';
			return 	$displayMusicList_arr;
		}
		/**
		* MusicLyricsActivate::UpdateMusicStatus()
		*
		* @return
		**/
		public function UpdateMusicStatus($music_id)
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_lyric'].' '.
			' SET lyric_status =\'Yes\' '.
			' WHERE music_lyric_id = '.$this->dbObj->Param('music_lyric_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($music_id));
			if (!$rs)
			trigger_db_error($this->dbObj);
			return true;
		}
		/**
		* MusicLyricsActivate::selectedMusicActivate()
		*
		* @return
		**/
		public function selectedMusicActivate()
		{
			$music_id = $this->getFormField('music_lyric_id');
			$music_id = explode(',', $music_id);
			foreach($music_id as $key=>$value)
			{
				$this->UpdateMusicStatus($value);
			}
			$this->setCommonSuccessMsg($this->LANG['msg_success_activated']);
			$this->setPageBlockShow('block_msg_form_success');
		}
		/**
		* MusicLyricsActivate::selectedMusicDelete()
		*
		* @param mixed $music_id
		* @return
		*/
		public function selectedMusicDelete()
		{
			$music_lyric_id = $this->getFormField('music_lyric_id');
			$music_lyric_id = explode(',', $music_lyric_id);
			foreach($music_lyric_id as $key=>$value)
			{
			 $this->deleteMusicStatus($value);
			}
			$this->setCommonSuccessMsg($this->LANG['msg_success_deleted']);
			$this->setPageBlockShow('block_msg_form_success');
		}
		public function deleteMusicStatus($music_lyric_id)
		{
			$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_lyric'].' WHERE'.' music_lyric_id='
			.$this->dbObj->Param($this->fields_arr['music_lyric_id']);
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($music_lyric_id));
			if (!$rs)
			trigger_db_error($this->dbObj);
		}

	}
//<<<<<-------------- Class MusicActivate begins ---------------//
//-------------------- Code begins -------------->>>>>//
$MusicLyricsActivate = new MusicLyricsActivate();
$MusicLyricsActivate->setMediaPath('../../');
$MusicLyricsActivate->setPageBlockNames(array('list_music_form', 'preview_block'));
$MusicLyricsActivate->setFormField('music_id', '');
$MusicLyricsActivate->setFormField('user_id', '');
$MusicLyricsActivate->setFormField('action', '');
$MusicLyricsActivate->setFormField('music_lyric_id', '');
/*********** Page Navigation Start *********/
$MusicLyricsActivate->setFormField('start', '0');
$MusicLyricsActivate->setFormField('playing_time', '0');
$MusicLyricsActivate->setFormField('slno', '1');
$MusicLyricsActivate->setFormField('numpg', $CFG['data_tbl']['numpg']);
$MusicLyricsActivate->setMinRecordSelectLimit(2);
$MusicLyricsActivate->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$MusicLyricsActivate->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$MusicLyricsActivate->setTableNames(array($CFG['db']['tbl']['music'].' as v LEFT JOIN '.$CFG['db']['tbl']['music_lyric'].' as ml ON v.music_id=ml.music_id JOIN  '.$CFG['db']['tbl']['users'].' as u ON ml.user_id=u.user_id'));
$MusicLyricsActivate->setReturnColumns(array('v.music_id','ml.user_id','v.music_title', 'v.date_added', 'v.music_server_url', 'u.user_name', 'u.first_name', 'u.last_name','v.small_height','v.small_width','v.thumb_width','v.thumb_height','u.user_id','v.music_thumb_ext','v.music_encoded_status','ml.music_lyric_id','ml.lyric_status','ml.lyric'));
/************ page Navigation stop *************/
$MusicLyricsActivate->setAllPageBlocksHide();
$MusicLyricsActivate->setPageBlockShow('list_music_form');
$MusicLyricsActivate->sanitizeFormInputs($_REQUEST);
if($MusicLyricsActivate->isFormPOSTed($_POST, 'action'))
{
	if($MusicLyricsActivate->getFormField('action')=='activate')
	{
		$MusicLyricsActivate->getFormField('music_lyric_id');
		$MusicLyricsActivate->selectedMusicActivate();
	}
	else if($MusicLyricsActivate->getFormField('action')=='delete')
	{
		$MusicLyricsActivate->selectedMusicDelete();
	}
}
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
$MusicLyricsActivate->hidden = array('start');
if ($MusicLyricsActivate->isShowPageBlock('list_music_form'))
{
	/****** navigtion continue*********/
	$MusicLyricsActivate->buildSelectQuery();
	$MusicLyricsActivate->buildConditionQuery();
	$MusicLyricsActivate->buildSortQuery();
	$MusicLyricsActivate->buildQuery();
	$MusicLyricsActivate->executeQuery();
	/******* Navigation End ********/
	if($MusicLyricsActivate->isResultsFound())
	{
		$MusicLyricsActivate->list_music_form['anchor'] = 'MultiDelte';
		$smartyObj->assign('smarty_paging_list', $MusicLyricsActivate->populatePageLinksGET($MusicLyricsActivate->getFormField('start'), array()));
		$MusicLyricsActivate->list_music_form['displayMusicList'] = $MusicLyricsActivate->displayMusicList();
		$MusicLyricsActivate->list_music_form['onclick_activate'] = 'if(getMultiCheckBoxValue(\'musicListForm\', \'check_all\', \''.$LANG['check_atleast_one'].'\')){Confirmation(\'selMsgConfirmDelete\', \'confirmationForm\', Array(\'music_lyric_id\', \'action\', \'confirmMsg\'), Array(multiCheckValue, \'activate\', \''.$LANG['musiclyrics_activate_activate_confirmation'].'\'), Array(\'value\', \'value\', \'innerHTML\'), -100, -200);}return false;';
		$MusicLyricsActivate->list_music_form['onclick_delete'] = 'if(getMultiCheckBoxValue(\'musicListForm\', \'check_all\', \''.$LANG['check_atleast_one'].'\')){Confirmation(\'selMsgConfirmDelete\', \'confirmationForm\', Array(\'music_lyric_id\', \'action\', \'confirmMsg\'), Array(multiCheckValue, \'delete\', \''.$LANG['musiclyrics_activate_delete_confirmation'].'\'), Array(\'value\', \'value\', \'innerHTML\'), -100, -200);}return false;';
	}
}
$MusicLyricsActivate->left_navigation_div = 'musicMain';
//include the header file
$MusicLyricsActivate->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'music');
$smartyObj->display('musicLyricsActivate.tpl');
?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/AG_ajax_html.js"></script>
 <script type="text/javascript" src="{$CFG.site.url}js/swfobject.js"></script>
<script language="javascript" type="text/javascript" >
	var block_arr= new Array('selMsgConfirmDelete');
</script>
<?php
//<<<<<-------------------- Page block templates ends -------------------//
$MusicLyricsActivate->includeFooter();
?>
