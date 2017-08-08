<?php
/**
* This file is to Feature Music Reorder
*
* This file is having Music Reorder class to reorder the videos
*
*
* @category	Rayzz
* @package		Admin
* @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
*
**/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/admin/videoManage.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['site']['is_module_page']='video';

if(isset($_REQUEST['type']) and ($_REQUEST['type'] == 'video'))
	{
		$CFG['html']['header'] = 'admin/html_header_no_header.php';
		$CFG['html']['footer'] = 'admin/html_footer_no_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
		$CFG['admin']['light_window_page'] = true;
		//To show session expired content inside lightwindow if session got expired
		$CFG['admin']['session_redirect_light_window_page'] = true;
	}
else
	{
	$CFG['html']['header'] = 'admin/html_header.php';
	$CFG['html']['footer'] = 'admin/html_footer.php';
	$CFG['mods']['is_include_only']['html_header'] = false;
	$CFG['html']['is_use_header'] = false;
	}

require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
*
* @category	rayzz
* @package		Admin Music
**/
class FeatureVideoReorder extends MusicHandler
{
	public function getOrganizeVideoList()
	{
		global $smartyObj;
		$getMusicDetail_arr = array();
		$condition='';
		$this->isResultsFound = false;
		$sql='SELECT v.video_id, v.video_title, u.user_id,u.usr_status,
		v.featured, v.flagged_status,
		v.video_status  FROM '.$this->CFG['db']['tbl']['video'].
		' AS v LEFT JOIN users AS u ON v.user_id=u.user_id AND
		u.usr_status=\'Ok\' WHERE v.video_status=\'Ok\' AND v.featured=\'Yes\'';
		if($condition)
		$sql .= ' AND (v.user_id = '.$this->CFG['user']['user_id'].
		' OR v.video_access_type = \'Public\''.
		$this->getAdditionalQuery().') '.$this->getAdultQuery('v.', 'video');
		$sql .= ' ORDER BY v.featured_video_order_id ASC LIMIT 0,25';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$getVideoDetail_arr['total_record'] = $total = $rs->PO_RecordCount();
		$getVideoDetail_arr['row'] = array();
		$inc = 1;
		while($row = $rs->FetchRow())
		{
			$getVideoDetail_arr['row'][$inc]['record'] = $row;
			$this->isResultsFound = true;
			$getVideoDetail_arr['row'][$inc]['video_title'] = $row['video_title'];
			$getVideoDetail_arr['row'][$inc]['video_id'] = $row['video_id'];
			$inc++;
		}
		$smartyObj->assign('getVideoDetail', $getVideoDetail_arr);
		return $getVideoDetail_arr;
	}
	public function updatefeatureVideoOrderId($order_id)
	{
		$video_id_order = explode(',', $order_id);
		foreach($video_id_order as $key=>$value)
		{
			list($video_id,$order_id)=explode('_',$value);
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].
			' SET featured_video_order_id= '.$this->dbObj->Param('order_id').
			' WHERE  video_id='.$this->dbObj->Param('video_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt,array($order_id,$video_id));
			if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		}
	}

}
$featureVideoReorder = new FeatureVideoReorder();
$featureVideoReorder->setPageBlockNames(array('list_order_block','deleted_msg',''));
$featureVideoReorder->setFormField('video_id', '');
$featureVideoReorder->setFormField('order_id', '');
$featureVideoReorder->setFormField('left', '');
$featureVideoReorder->setFormField('right', '');
$featureVideoReorder->setFormField('type', '');
$featureVideoReorder->sanitizeFormInputs($_REQUEST);
$featureVideoReorder->setPageBlockShow('block_videolist_player');
$featureVideoReorder->list_order_block['getOrganizeVideoList'] = $featureVideoReorder->getOrganizeVideoList();
if(isAjaxPage())
{
	if($featureVideoReorder->getFormField('order_id')!= '')
	{
	$featureVideoReorder->updatefeatureVideoOrderId($featureVideoReorder->getFormField('order_id'));
	}
}
$featureVideoReorder->left_navigation_div = 'videoMain';
if(!isAjaxPage())
	{
		$featureVideoReorder->includeHeader();
	}
else
	{
		$featureVideoReorder->includeAjaxHeader();
	}
?>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/reOrder.css">
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/screen_grey/screen_grey.css">
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/yahoo-dom-event.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/animation-min.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/dragdrop-min.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['video_url'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['video_url'];?>js/organizeList.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript" language="javascript">
var site_url = '<?php echo $CFG['site']['url'];?>';
var savePlaylistUrl='<?php echo $CFG['site']['video_url'].'createPlaylist.php?action=save_playlist&light_window=1'; ?>';
var common_playlist='<?php echo $LANG['common_create_playlist']; ?>';
</script>
<script type="text/javascript">
function feturedMusicCancel(url)
{
self.close();
}
var reorder_section_count = 1;
//var modules=Array();
</script>
<style type="text/css">
.draggable
{
border: 2px solid #0090DF;
background-color: #68BFEF;
width: 640px;
height: 160px;
margin: 10px;
}
ul.draglist_alt {
position: relative;
width: 200px;
list-style: none;
margin:0;
padding:0;
/*
The bottom padding provides the cushion that makes the empty
list targetable.  Alternatively, we could leave the padding
off by default, adding it when we detect that the list is empty.
*/
padding-bottom:20px;
}

ul.draglist_alt li {
margin: 1px;
cursor: move;
}
</style>

<?php
setTemplateFolder('admin/', 'video');
$smartyObj->display('videoFeaturedReorder.tpl');
$featureVideoReorder->includeFooter();
?>