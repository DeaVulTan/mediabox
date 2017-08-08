<?php
/**
* This file is to Feature Music Reorder
*
* This file is having Music Reorder class to reorder the musics
*
*
* @category	Rayzz
* @package		Admin
* @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
*
**/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/musicManage.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['site']['is_module_page']='music';

if(isset($_REQUEST['type']) and ($_REQUEST['type'] == 'music'))
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
class FeatureMusicReorder extends MusicHandler
{
	public function getOrganizeMusicList()
	{
		global $smartyObj;
		$getMusicDetail_arr = array();
		$condition='';
		$this->isResultsFound = false;
		$sql='SELECT m.music_id, m.music_title, u.user_id,u.usr_status,
		m.music_featured, m.flagged_status,
		m.music_status  FROM '.$this->CFG['db']['tbl']['music'].
		' AS m LEFT JOIN users AS u ON m.user_id=u.user_id AND
		u.usr_status=\'Ok\' WHERE m.music_status=\'Ok\' AND m.music_featured=\'Yes\'';
		if($condition)
		$sql .= ' AND (m.user_id = '.$this->CFG['user']['user_id'].
		' OR m.music_access_type = \'Public\''.
		$this->getAdditionalQuery().') '.$this->getAdultQuery('m.', 'music');
		$sql .= ' ORDER BY m.featured_music_order_id ASC LIMIT 0,25';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$getMusicDetail_arr['total_record'] = $total = $rs->PO_RecordCount();
		$getMusicDetail_arr['row'] = array();
		$inc = 1;
		while($row = $rs->FetchRow())
		{
			$getMusicDetail_arr['row'][$inc]['record'] = $row;
			$this->isResultsFound = true;
			$getMusicDetail_arr['row'][$inc]['music_title'] = $row['music_title'];
			$getMusicDetail_arr['row'][$inc]['music_id'] = $row['music_id'];
			$inc++;
		}
		$smartyObj->assign('getMusicDetail', $getMusicDetail_arr);
		return $getMusicDetail_arr;
	}
	public function updatefeatureMusicOrderId($order_id)
	{
		$music_id_order = explode(',', $order_id);
		foreach($music_id_order as $key=>$value)
		{
			list($music_id,$order_id)=explode('_',$value);
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].
			' SET featured_music_order_id= '.$this->dbObj->Param('order_id').
			' WHERE  music_id='.$this->dbObj->Param('music_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt,array($order_id,$music_id));
			if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		}
	}

}
$featureMusicReorder = new FeatureMusicReorder();
$featureMusicReorder->setPageBlockNames(array('list_order_block','deleted_msg','block_musiclist_player'));
$featureMusicReorder->setFormField('music_id', '');
$featureMusicReorder->setFormField('order_id', '');
$featureMusicReorder->setFormField('left', '');
$featureMusicReorder->setFormField('right', '');
$featureMusicReorder->setFormField('type', '');
$featureMusicReorder->sanitizeFormInputs($_REQUEST);
$featureMusicReorder->setPageBlockShow('block_musiclist_player');
$featureMusicReorder->list_order_block['getOrganizeMusicList'] = $featureMusicReorder->getOrganizeMusicList();
if($featureMusicReorder->getFormField('order_id')!= '')
{
$featureMusicReorder->updatefeatureMusicOrderId($featureMusicReorder->getFormField('order_id'));
echo $LANG['common_msg_reorder_featured_music_list'];
exit;
}
$featureMusicReorder->left_navigation_div = 'musicMain';
$featureMusicReorder->includeHeader();
?>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/reOrder.css">
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/screen_grey/screen_grey.css">
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/yahoo-dom-event.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/animation-min.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/dragdrop-min.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/organizeList.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript" language="javascript">
var site_url = '<?php echo $CFG['site']['url'];?>';
var savePlaylistUrl='<?php echo $CFG['site']['music_url'].'createPlaylist.php?action=save_playlist&light_window=1'; ?>';
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
setTemplateFolder('admin/', 'music');
$smartyObj->display('musicFeaturedReorder.tpl');
$featureMusicReorder->includeFooter();
?>