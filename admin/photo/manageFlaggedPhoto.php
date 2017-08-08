<?php
/**
* This file is to manage the Flagged Photo
*
* This file is having manage the Flagged Photo
*
*
* @category	    Rayzz PhotoSharing
* @package		Admin
* @copyright 	Copyright (c) 2010 {@link http://www.mediabox.uz Uzdc Infoway}
* @license		http://www.mediabox.uz Uzdc Infoway Licence
**/

require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/admin/manageFlaggedPhoto.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/help.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';

if(isset($_REQUEST['type']) and ($_REQUEST['type'] == 'Preview'))
{
	$CFG['html']['header'] = 'general/html_header_no_header.php';
	$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
	$CFG['mods']['is_include_only']['html_header'] = false;
	$CFG['html']['is_use_header'] = false;
	$CFG['admin']['light_window_page'] = true;
}
else
{
	$CFG['html']['header'] = 'admin/html_header.php';
	$CFG['html']['footer'] = 'admin/html_footer.php';
	$CFG['mods']['is_include_only']['html_header'] = false;
	$CFG['html']['is_use_header'] = false;
}

$CFG['site']['is_module_page'] = 'photo';
require_once($CFG['site']['project_path'] . 'common/application_top.inc.php');

class ManageFlaggedPhoto extends MediaHandler{
   /**
	* ManageFlaggedPhoto::buildConditionQuery()
	*
	* @return void
	**/
	public function buildConditionQuery()
	{
		$this->sql_condition = 'F.status=\'Ok\' AND F.content_type=\'Photo\' AND P.photo_status=\'Ok\' AND P.flagged_status<>\'Yes\' GROUP BY F.content_id ';
	}

	/**
	* ManageFlaggedPhoto::buildSortQuery()
	*
	* @return void
	**/
	public function buildSortQuery()
	{
		$this->sql_sort = 'total_requests DESC';
	}

   /**
	* ManageFlaggedPhoto::displayFlaggedList()
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
		' WHERE F.content_id='.$this->dbObj->Param($this->fields_arr['photo_id']).
		' AND F.status=\'Ok\' ORDER BY F.date_added DESC';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);
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
	* ManageFlaggedPhoto::displayPhotoList()
	*
	* @return void
	**/
	public function displayPhotoList()
	{
		global $smartyObj;
		$displayPhotoList_arr = array();
		$photo_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/';
		$inc = 0;
		while($row = $this->fetchResultRecord())
		{
			$displayPhotoList_arr[$inc]['checked'] = '';
			if((is_array($this->fields_arr['photo_ids'])) && (in_array($row['photo_id'], $this->fields_arr['photo_ids'])))
			$displayPhotoList_arr[$inc]['checked']    = "checked";
			$displayPhotoList_arr[$inc]['record'] 	  = $row;
			$displayPhotoList_arr[$inc]['previewURL'] = $this->CFG['site']['url'].'admin/photo/manageFlaggedPhoto.php?ajax_page=true&photo_id='.$row['photo_id'].'&type=Preview';
			$inc++;
		}
		$smartyObj->assign('displayPhotoList_arr', $displayPhotoList_arr);
	}

   /**
	* ManageFlaggedPhoto::getUserName()
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
			trigger_db_error($this->dbObj);
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
	* ManageFlaggedPhoto::getCountOfRequests()
	*
	* @param Integer $photo_id
	* @return void
	*/
	public function getCountOfRequests($photo_id)
	{
		global $smartyObj;
		$displayCountRequestList_arr = array();
		$sql = 'SELECT COUNT(1) as total_count, flag FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
		' content_type=\'Photo\' AND content_id='.$this->dbObj->Param('photo_id').' AND status=\'Ok\' GROUP BY flag order by flag';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photo_id));
		if (!$rs)
			trigger_db_error($this->dbObj);
		while($row = $rs->FetchRow())
		{
			return $row['flag'].' : '.$row['total_count'];
		}
	}

   /**
	* ManageFlaggedPhoto::populatePhotoDetails()
	*
	* @return boolean
	**/
	public function populatePhotoDetails()
	{
		$sql = 'SELECT P.photo_title, U.user_name, U.email, U.user_id FROM'.
		' '.$this->CFG['db']['tbl']['photo'].' as P LEFT JOIN '.$this->CFG['db']['tbl']['users'].
		' AS U ON P.user_id=U.user_id WHERE'.
		' photo_id='.$this->dbObj->Param($this->fields_arr['photo_id']).' LIMIT 0,1';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
			{
				$this->PHOTO_TITLE 		= $row['photo_title'];
				$this->PHOTO_USER_NAME  = $row['user_name'];
				$this->PHOTO_USER_EMAIL = $row['email'];
				$this->PHOTO_USER_ID    = $row['user_id'];
				return true;
			}
		return false;
	}

   /**
	* ManageFlaggedPhoto::activateFlaggedPhoto()
	* To UnFlag a Flagged photo (To disaprove flags)
	*
	* @return void
	**/
	public function activateFlaggedPhoto()
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['flagged_contents'].' '.
		' SET status=\'Deleted\' WHERE'.
		' content_id IN('.$this->fields_arr['photo_ids'].') AND content_type=\'Photo\'';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);
	}

   /**
	* ManageFlaggedPhoto::flagFlaggedPhoto()
	* To Flag a Flagged photo (To approve flag)
	*
	* @return void
	**/
	public function flagFlaggedPhoto()
	{
		$this->populatePhotoDetails();
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET flagged_status=\'Yes\''.
		' WHERE photo_id IN('.$this->fields_arr['photo_ids'].')';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['flagged_contents'].' '.
		' SET status=\'Deleted\' WHERE'.
		' content_id IN('.$this->fields_arr['photo_ids'].') AND content_type=\'Photo\'';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);
	}

   /**
	* ManageFlaggedPhoto::deleteFlaggedPhoto()
	* To delete flag, other photo related contents and will apply 'Delete' Status to photo
	*
	*
	* @return boolean
	**/
	public function deleteFlaggedPhoto()
	{
		$sql = 'SELECT user_id, photo_id FROM '.$this->CFG['db']['tbl']['photo'].' WHERE photo_id IN('.$this->fields_arr['photo_ids'].')';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);
		while($row = $rs->FetchRow())
		{
			$user_details[$row['photo_id']] = $row['user_id'];
		}
		$photo_id = explode(',',$this->fields_arr['photo_ids']);
		foreach($photo_id as $key=>$value)
		{
			$this->deletePhotos(array($value), $user_details[$value]);
		}
		return true;
    }

	/**
	 * PhotoActivate::displayPhoto()
	 *
	 * @param string $photoId
	 * @return string
	 */
	public function displayPhoto($photoId = '')
	{
		$sql  = 'SELECT photo_id, photo_server_url, photo_ext, l_width, l_height FROM '.$this->CFG['db']['tbl']['photo'].' WHERE photo_id = '.$this->dbObj->Param('photo_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt, array($photoId));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$imgSrc = '';
		if($row = $rs->FetchRow())
		{
			$imgSrc = $this->media_relative_path.$photos_folder.getPhotoName($row['photo_id']).
															$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'];
?>
			<img src="<?php echo $imgSrc;?>" width="<?php echo $row['l_width'];?>" height="<?php echo $row['l_height'];?>" />

<?php
		}
	}
}
//<<<<<-------------- Class obj begins ---------------//
$manageflaggedphoto = new ManageFlaggedPhoto();
$manageflaggedphoto->setMediaPath('../../');
$manageflaggedphoto->setPageBlockNames(array('confirmation_block', 'list_flagged_photo_form', 'flagged_details_form', 'activate_confirmation_form', 'flag_confirmation_form', 'delete_confirmation_form'));
$action_arr = array('delete'=>$LANG['manageflagged_delete'], 'flag'=>$LANG['manageflagged_flag'], 'activate'=>$LANG['manageflagged_activate']);
$manageflaggedphoto->setFormField('photo_id', '');
$manageflaggedphoto->setFormField('action', '');
$manageflaggedphoto->setFormField('action_select', '');
$manageflaggedphoto->setFormField('photo_ids', array());
$manageflaggedphoto->setFormField('type', '');
/*********** Page Navigation Start *********/
$manageflaggedphoto->setFormField('slno', '1');
$manageflaggedphoto->setTableNames(array($CFG['db']['tbl']['flagged_contents'].' AS F LEFT JOIN '.$CFG['db']['tbl']['photo'].' as P ON F.content_id=P.photo_id'));
$manageflaggedphoto->setReturnColumns(array('P.photo_id', 'P.t_width', 'P.t_height', 'photo_server_url','photo_ext','P.user_id','P.photo_title', 'P.user_id', 'COUNT(F.content_id) AS total_requests'));
/************ page Navigation stop *************/
$manageflaggedphoto->setAllPageBlocksHide();
$manageflaggedphoto->setPageBlockShow('list_flagged_photo_form');
$manageflaggedphoto->sanitizeFormInputs($_REQUEST);
//print_r($_POST); exit;

if(isAjaxPage())
{
	$manageflaggedphoto->includeAjaxHeader();
	$manageflaggedphoto->sanitizeFormInputs($_REQUEST);
	$block = $manageflaggedphoto->getFormField('type');

	if(isset($block) && $block == 'Preview')
	{
		$manageflaggedphoto->displayPhoto($manageflaggedphoto->getFormField('photo_id'));
	}
	$manageflaggedphoto->includeAjaxFooter();
	exit;
}


if($manageflaggedphoto->isFormGETed($_GET, 'action'))
{
	if($manageflaggedphoto->getFormField('action')=='detail')
	{
		$manageflaggedphoto->setAllPageBlocksHide();
		$manageflaggedphoto->setPageBlockShow('flagged_details_form');
	}
}
if($manageflaggedphoto->isFormGETed($_POST, 'photo_submit'))
{
	$manageflaggedphoto->chkIsNotEmpty('photo_ids', $LANG['err_tip_compulsory']);
	if($manageflaggedphoto->isValidFormInputs())
	{
		$photo_ids = $manageflaggedphoto->getFormField('photo_ids');
		$photo_id = '';
		foreach($photo_ids as $value)
		$photo_id .= $value.',';
		$photo_id = substr($photo_id, 0, strrpos($photo_id, ','));
		$manageflaggedphoto->setFormField('photo_id', $photo_id);
		$value = $manageflaggedphoto->getFormField('action_select').'_confirmation';
		$LANG['confirmation'] = $LANG[$value];
		$manageflaggedphoto->setPageBlockShow('confirmation_block');
	}
	else
	{
		$manageflaggedphoto->setCommonErrorMsg($LANG['err_tip_select_category']);
		$manageflaggedphoto->setPageBlockShow('block_msg_form_error');
	}
}

if($manageflaggedphoto->isFormGETed($_POST, 'back_submit'))
{
	$manageflaggedphoto->setAllPageBlocksHide();
	$manageflaggedphoto->setPageBlockShow('list_flagged_photo_form');
}
if($manageflaggedphoto->isFormGETed($_POST, 'yes'))
{
	switch($manageflaggedphoto->getFormField('action'))
	{
		case 'Unflag':
		$manageflaggedphoto->activateFlaggedPhoto();
		$manageflaggedphoto->setCommonSuccessMsg($LANG['msg_success_acivate']);
		$manageflaggedphoto->setPageBlockShow('block_msg_form_success');
		break;
		case 'Flag':
		$manageflaggedphoto->flagFlaggedPhoto();
		$manageflaggedphoto->setCommonSuccessMsg($LANG['msg_success_flag']);
		$manageflaggedphoto->setPageBlockShow('block_msg_form_success');
		break;
		case 'Delete':
		$manageflaggedphoto->deleteFlaggedPhoto();
		$manageflaggedphoto->setCommonSuccessMsg($LANG['msg_success_delete']);
		$manageflaggedphoto->setPageBlockShow('block_msg_form_success');
		break;
	}
}

$manageflaggedphoto->hidden_arr = array('start');
if ($manageflaggedphoto->isShowPageBlock('flagged_details_form'))
{
	$manageflaggedphoto->displayFlaggedList();
}
if ($manageflaggedphoto->isShowPageBlock('list_flagged_photo_form'))
{
	/****** navigtion continue*********/
	$manageflaggedphoto->buildSelectQuery();
	$manageflaggedphoto->buildConditionQuery();
	$manageflaggedphoto->buildSortQuery();
	$manageflaggedphoto->buildQuery();
	//$manageflaggedphoto->printQuery();
	if($manageflaggedphoto->isGroupByQuery())
	$manageflaggedphoto->homeExecuteQuery();
	else
	$manageflaggedphoto->executeQuery();
	/******* Navigation End ********/
	if($manageflaggedphoto->isResultsFound())
	{
		$paging_arr = array();
		$manageflaggedphoto->displayPhotoList();
		$smartyObj->assign('smarty_paging_list', $manageflaggedphoto->populatePageLinksGET($manageflaggedphoto->getFormField('start'), $paging_arr));
	}
}
$manageflaggedphoto->left_navigation_div = 'photoMain';
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$manageflaggedphoto->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'photo');
$smartyObj->display('manageFlaggedPhoto.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
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
$manageflaggedphoto->includeFooter();
?>