<?php
/**
* This file is to Feature Photo Reorder
*
* This file is having Photo Reorder class to reorder the photos
*
*
* @category	Rayzz
* @package		Admin
* @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
*
**/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/admin/photoManage.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['site']['is_module_page']='photo';
if(isset($_REQUEST['type']) and ($_REQUEST['type'] == 'photo'))
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
* @package		Admin Photo
**/
class FeaturePhotoReorder extends PhotoHandler
{
	public function getOrganizePhotoList()
	{
		global $smartyObj;
		$getPhotoDetail_arr = array();
		$condition='';
		$this->isResultsFound = false;
		$sql='SELECT p.photo_id, p.photo_title, u.user_id,u.usr_status,
		p.featured, p.flagged_status,
		p.photo_status  FROM '.$this->CFG['db']['tbl']['photo'].
		' AS p LEFT JOIN users AS u ON p.user_id=u.user_id AND
		u.usr_status=\'Ok\' WHERE p.photo_status=\'Ok\' AND p.featured=\'Yes\'';
		if($condition)
		$sql .= ' AND (p.user_id = '.$this->CFG['user']['user_id'].
		' OR p.photo_access_type = \'Public\''.
		$this->getAdditionalQuery().') '.$this->getAdultQuery('p.', 'photo');
		$sql .= ' ORDER BY p.featured_photo_order_id ASC LIMIT 0,25';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		trigger_db_error($this->dbObj);
		$getPhotoDetail_arr['total_record'] = $total = $rs->PO_RecordCount();
		$getPhotoDetail_arr['row'] = array();
		$inc = 1;
		while($row = $rs->FetchRow())
		{
			$getPhotoDetail_arr['row'][$inc]['record'] = $row;
			$this->isResultsFound = true;
			$getPhotoDetail_arr['row'][$inc]['photo_title'] = $row['photo_title'];
			$getPhotoDetail_arr['row'][$inc]['photo_id'] = $row['photo_id'];
			$inc++;
		}
		$smartyObj->assign('getPhotoDetail', $getPhotoDetail_arr);
		return $getPhotoDetail_arr;
	}
	public function updatefeaturePhotoOrderId($order_id)
	{
		$photo_id_order = explode(',', $order_id);
		foreach($photo_id_order as $key=>$value)
		{
			list($photo_id,$order_id)=explode('_',$value);
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].
			' SET featured_photo_order_id= '.$this->dbObj->Param('order_id').
			' WHERE  photo_id='.$this->dbObj->Param('photo_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt,array($order_id,$photo_id));
			if (!$rs)
			trigger_db_error($this->dbObj);
		}
	}

}
$featurePhotoReorder = new FeaturePhotoReorder();
$featurePhotoReorder->setPageBlockNames(array('list_order_block','deleted_msg','block_photolist_player'));
$featurePhotoReorder->setFormField('photo_id', '');
$featurePhotoReorder->setFormField('order_id', '');
$featurePhotoReorder->setFormField('left', '');
$featurePhotoReorder->setFormField('right', '');
$featurePhotoReorder->setFormField('type', '');
$featurePhotoReorder->sanitizeFormInputs($_REQUEST);
$featurePhotoReorder->setPageBlockShow('block_photolist_player');
$featurePhotoReorder->list_order_block['getOrganizePhotoList'] = $featurePhotoReorder->getOrganizePhotoList();
if($featurePhotoReorder->getFormField('order_id')!= '')
{
$featurePhotoReorder->updatefeaturePhotoOrderId($featurePhotoReorder->getFormField('order_id'));
}
$featurePhotoReorder->left_navigation_div = 'photoMain';
$featurePhotoReorder->includeHeader();
?>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/reOrder.css">
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/admin/css/screen_grey/screen_grey.css">
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/yahoo-dom-event.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/animation-min.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/dragdrop-min.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['photo_url'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['photo_url'];?>js/organizeList.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript" language="javascript">
var site_url = '<?php echo $CFG['site']['url'];?>';
var savePlaylistUrl='<?php echo $CFG['site']['photo_url'].'createSlidelist.php?action=save_playlist&light_window=1'; ?>';
var common_playlist='<?php echo $LANG['common_create_playlist']; ?>';
</script>
<script type="text/javascript">
function feturedPhotoCancel(url)
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
setTemplateFolder('admin/', 'photo');
$smartyObj->display('photoFeaturedReorder.tpl');
$featurePhotoReorder->includeFooter();
?>