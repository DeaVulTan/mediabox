<?php
/**
* profilePagePhotoHandler
*
* @package
* @author
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
* @persion $Id$
* @access public
*/
global $CFG;
require_once($CFG['site']['project_path'].'common/classes/class_FormHandler.lib.php');
require_once($CFG['site']['project_path'].'common/classes/class_MediaHandler.lib.php');
require_once($CFG['site']['project_path'].'common/classes/class_PhotoHandler.lib.php');
require_once($CFG['site']['project_path'].'common/configs/config_photo.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/profilePhotoBlock.php';
class profilePagePhotoHandler extends PhotoHandler
{
	public $isCurrentUser = false;
	public $showEditableLink = false;
	/**
	* profilePagePhotoHandler::getMyPhotoBlock()
	*
	* @param integer $start
	* @param integer $photoLimit
	* @return void
	*/
	public function getMyPhotoBlock($start=0, $photoLimit=4)
	{
		global $smartyObj;
		$condition = 'p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').' AND p.user_id=\''.$this->fields_arr['user_id'].'\''.
					 ' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR p.photo_access_type = \'Public\''.$this->getAdditionalQuery('p.').')';
		$sql = 'SELECT pa.photo_album_title,pa.photo_album_id,p.photo_id,p.photo_title,p.photo_ext, p.s_width, p.s_height, '.
				' p.m_width, p.m_height, p.t_width, p.t_height, p.photo_server_url,p.photo_title, TIMEDIFF(NOW(), p.date_added) as date_added,'.
				' p.total_views,p.photo_ext '.
				' FROM '.$this->CFG['db']['tbl']['photo'].' AS p LEFT JOIN '.$this->CFG['db']['tbl']['photo_album'] .' AS pa ON pa.photo_album_id=p.photo_album_id WHERE '.$condition.' ORDER BY'.
		' p.photo_id DESC LIMIT '.$start.','.$photoLimit;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);
		$this->photoDisplayed = false;
		$photo_list_arr = array();
		$inc = 0;
		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		if ($rs->PO_RecordCount())
		{
			$this->photoDisplayed = true;
			while($row = $rs->FetchRow())
			{
			    $photo_path = $row['photo_server_url'].$photos_folder.getPhotoName($row['photo_id']).
								$this->CFG['admin']['photos']['small_name'].'.'.$row['photo_ext'];

				if ($row['photo_ext'] == '')
				{
					$photo_path = $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].
									'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_photo_S.jpg';
				}
				$widthHeightAttr = DISP_IMAGE($this->CFG['admin']['photos']['small_width'],
								$this->CFG['admin']['photos']['small_height'],
									$row['s_width'], $row['s_height']);
				$row['date_added'] = getTimeDiffernceFormat($row['date_added']);
				$photo_list_arr[$inc]['photoUrl']=getUrl('viewphoto','?photo_id='.$row['photo_id'].'&title='.$this->changeTitle($row['photo_title']), $row['photo_id'].'/'.$this->changeTitle($row['photo_title']).'/','','photo');
				$photo_list_arr[$inc]['photo_album_id']=$row['photo_album_id'];
				$photo_list_arr[$inc]['date_added']=$row['date_added'];
				$photo_list_arr[$inc]['total_views']=$row['total_views'];
				$photo_list_arr[$inc]['wrap_photo_title']=$row['photo_title'];
				$photo_list_arr[$inc]['wrap_album_title']=$row['photo_album_title'];
				$photo_list_arr[$inc]['photo_path']=$photo_path;
				$photo_list_arr[$inc]['widthHeightAttr']=$widthHeightAttr;
				$photo_list_arr[$inc]['s_width']=$row['s_width'];
				$photo_list_arr[$inc]['s_height']=$row['s_height'];
				$inc++;
			} // while
		}
		else
		{
			$photo_list_arr=0;
		}
		$smartyObj->assign('photoDisplayed', $this->photoDisplayed);
		$smartyObj->assign('photo_list_arr', $photo_list_arr);
		$userphotolistURL=getUrl('photolist','?pg=userphotolist&user_id='.$this->fields_arr['user_id'], 'userphotolist/?user_id='.$this->fields_arr['user_id'],'','photo');
		$smartyObj->assign('userphotolistURL', $userphotolistURL);
		$smartyObj->assign('myobj', $this);
	}

	/**
	* profilePagePhotoHandler::getMyPhotoBlock()
	*
	* @param integer $start
	* @param integer $photoLimit
	* @return void
	*/
	public function getMyPhotoAlbumBlock($start=0, $photoLimit=3)
	{
		global $smartyObj;
		$condition = 'p.user_id = u.user_id AND  p.photo_access_type = \'Public\' AND pa.user_id='.$this->fields_arr['user_id'].' AND (pa.album_access_type = \'Public\' OR pa.album_access_type = \'Private\' ) AND p.photo_status = \'OK\' AND u.usr_status=\'Ok\''.
				     ' GROUP BY pa.photo_album_id';

		$sql = 'SELECT pa.photo_album_id,pa.photo_album_title,pa.thumb_photo_id as photo_id,pa.total_album_views as total_views, p.photo_title,'.
				' MAX(p.photo_id) as photoid, p.photo_server_url, count( p.photo_id ) AS total_photos, p.s_width, p.s_height, p.t_width, p.t_height, pa.user_id, '.
				' TIMEDIFF(NOW(), pa.date_added) as date_added, p.photo_ext '.
				' FROM '.$this->CFG['db']['tbl']['photo'].' AS p LEFT JOIN '.$this->CFG['db']['tbl']['photo_album'] .' AS pa ON pa.photo_album_id=p.photo_album_id '.
				' , users AS u WHERE '.$condition.' ORDER BY'.' pa.photo_album_id DESC, p.photo_id DESC LIMIT '.$start.','.$photoLimit;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);

		if (!$rs)
			trigger_db_error($this->dbObj);
		$this->photoAlbumDisplayed = false;
		$photo_album_list_arr = array();
		$inc = 0;
		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		if ($rs->PO_RecordCount())
		{
			$this->photoAlbumDisplayed = true;
			while($row = $rs->FetchRow())
			{
				$photo_path = $row['photo_server_url'].$photos_folder.getPhotoName($row['photoid']).
								$this->CFG['admin']['photos']['small_name'].'.'.$row['photo_ext'];

				if ($row['photo_ext'] == '')
				{
					$photo_path = $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].
									'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_photo_S.jpg';
				}
				$widthHeightAttr = DISP_IMAGE($this->CFG['admin']['photos']['small_width'],
								$this->CFG['admin']['photos']['small_height'],
									$row['s_width'], $row['s_height']);
				$row['date_added'] = getTimeDiffernceFormat($row['date_added']);
				$photo_album_list_arr[$inc]['photoUrl'] = getUrl('viewphoto','?photo_id='.$row['photoid'].'&title='.$this->changeTitle($row['photo_title']), $row['photoid'].'/'.$this->changeTitle($row['photo_title']).'/','','photo');
				$photo_album_list_arr[$inc]['albumUrl'] = getUrl('photolist', '?pg=albumphotolist&album_id='.$row['photo_album_id'], 'albumphotolist/?album_id=' . $row['photo_album_id'], '', 'photo');
				$photo_album_list_arr[$inc]['photo_album_id']=$row['photo_album_id'];
				$photo_album_list_arr[$inc]['date_added']=$row['date_added'];
				$photo_album_list_arr[$inc]['total_views']=$row['total_views'];
				$photo_album_list_arr[$inc]['total_photos']=$row['total_photos'];
				$photo_album_list_arr[$inc]['wrap_photo_title']=$row['photo_title'];
				$photo_album_list_arr[$inc]['wrap_album_title']=$row['photo_album_title'];
				$photo_album_list_arr[$inc]['photo_path']=$photo_path;
				$photo_album_list_arr[$inc]['widthHeightAttr']=$widthHeightAttr;
				$photo_album_list_arr[$inc]['s_width']=$row['s_width'];
				$photo_album_list_arr[$inc]['s_height']=$row['s_height'];
				$inc++;
			} // while
		}
		else
		{
			$photo_album_list_arr=0;
		}
		$smartyObj->assign('photoAlbumDisplayed', $this->photoAlbumDisplayed);
		$smartyObj->assign('photo_album_list_arr', $photo_album_list_arr);

		$userphotoalbumlistURL=getUrl('albumlist','?pg=useralbums&user_id='.$this->fields_arr['user_id'], 'useralbums/?user_id='.$this->fields_arr['user_id'],'','photo');
		$smartyObj->assign('userphotoalbumlistURL', $userphotoalbumlistURL);

		$smartyObj->assign('myobj', $this);
	}

	/**
	* profilePagePhotoHandler::setUserId()
	*
	* @return void
	*/
	public function setUserId()
	{
		$userName = $this->fields_arr['user'];
		$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_name='.$this->dbObj->Param($userName).' AND usr_status=\'Ok\' LIMIT 1';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($userName));
		if (!$rs)
			trigger_db_error($this->dbObj);
		$row = array();
		if ($rs->PO_RecordCount())
		{
			$row = $rs->FetchRow();
			$this->fields_arr['user_id'] = $row['user_id'];
			$this->isValidUser = true;
			$this->isCurrentUser = (strcmp($this->CFG['user']['user_id'], $this->fields_arr['user_id'])==0);
			$edit = $this->fields_arr['edit'];
			$edit = (strcmp($edit, '1')==0);
			$this->showEditableLink = ($this->isCurrentUser and $edit);
		}
	}

	public function checkUserId()
	{
		$user_id = $this->fields_arr['user_id'];
		$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id='.$this->dbObj->Param($user_id);
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($user_id));
		if (!$rs)
			trigger_db_error($this->dbObj);
		$row = array();
		$this->isValidUser = ($rs->PO_RecordCount() > 0);
		$this->isCurrentUser = (strcmp($this->CFG['user']['user_id'], $user_id)==0);
		$edit = $this->fields_arr['edit'];
		$edit = (strcmp($edit, '1')==0);
		$this->showEditableLink = ($this->isCurrentUser and $edit);
	}

	/**
	* profilePagePhotoHandler::getFeaturedPhotoBlock()
	*
	* @return void
	*/
	public function getMyFeaturedPhotoBlock()
	{
		// echo 'sdfsdfsd';exit;
		global $smartyObj;
		$condition = 'photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').' AND pf.user_id=\''.$this->fields_arr['user_id'].'\''.
		' AND (p.user_id = '.$this->CFG['user']['user_id'].
		' OR photo_access_type = \'Public\''.$this->getAdditionalQuery('p.').')';
		$sql = 'SELECT p.photo_id,p.photo_title, p.l_width, p.l_height, photo_ext, photo_server_url,photo_title,'.
				' pa.photo_album_title,photo_ext FROM '.$this->CFG['db']['tbl']['photo'].' AS p JOIN '.
				$this->CFG['db']['tbl']['photo_featured'].' as pf ON pf.photo_id=p.photo_id '.
				' LEFT JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa on pa.photo_album_id=p.photo_album_id '.
				' WHERE '.$condition.' ORDER BY photo_id DESC';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_db_error($this->dbObj);

		$this->photoDisplayed = false;
		$this->isFeaturedphoto = false;
		$result_arr = array();
		$featured_photo_list_arr['isFeaturedphoto']='false';
		$this->setFormField('photo_id',0);
		$featured_photo_list_arr['photo_id']=0;
		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';

		if ($rs->PO_RecordCount())
		{
			$this->isFeaturedphoto = true;
			$inc = 0;
			while($row = $rs->FetchRow())
			{
				  $result_arr[$inc]['photo_title'] = $row['photo_title'];
				  $result_arr[$inc]['l_width'] = $row['l_width'];
				  $result_arr[$inc]['l_height'] = $row['l_height'];
				  $photo_name = getphotoName($row['photo_id']);
				  $result_arr[$inc]['thumb_img_src'] = $row['photo_server_url'] . $photos_folder.$photo_name.$this->CFG['admin']['photos']['thumb_name'].'.'.$row['photo_ext'];
				  $result_arr[$inc]['medium_img_src'] = $row['photo_server_url'] . $photos_folder.$photo_name.$this->CFG['admin']['photos']['medium_name'].'.'.$row['photo_ext'];
				  $result_arr[$inc]['view_photo_link'] = getUrl('viewphoto', '?photo_id=' . $row['photo_id'] . '&title=' . $this->changeTitle($row['photo_title']), $row['photo_id'] . '/' . $this->changeTitle($row['photo_title']) . '/', '', 'photo');
				  $inc++;
			}
		}
		$this->configPath = $this->CFG['site']['url'].'files/flash/photo/';
		$this->configxmlPath = $this->CFG['site']['photo_url'].'myFeaturedPhotoConfigXml.php?user_id='.$this->fields_arr['user_id'];

		//echo '<pre>'; print_r($featured_photo_list_arr); echo '</pre>';
		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/';
		//Populate playlist player configuration
		$smartyObj->assign('isFeaturedphoto', $this->isFeaturedphoto);
		$smartyObj->assign('featured_photo_list_arr', $result_arr);
		$smartyObj->assign('myobjFeaturedPhoto', $this);
	}
}
$photoBlock = new profilePagePhotoHandler();
global $CFG;

$photoBlock->setFormField('user_id', 0);
$photoBlock->setFormField('user', 0);
$photoBlock->setFormField('edit', 0);
if ($photoBlock->isPageGETed($_GET, 'user_id'))
	{
		$photoBlock->sanitizeFormInputs($_GET);
		$photoBlock->checkUserId();
	}
if ($photoBlock->isPageGETed($_GET, 'user'))
	{
		$photoBlock->sanitizeFormInputs($_GET);
		$photoBlock->setUserId();
	}
if (isset($__myProfile)) //its declared in members/myProfile.php
	{
		$photoBlock->setFormField('user_id', $CFG['user']['user_id']);
		$photoBlock->setFormField('edit', '1');
		$photoBlock->checkUserId();
	}
$userId = $photoBlock->getFormField('user_id');
if (!is_numeric($userId))
	{
		$photoBlock->setFormField('user_id', intval($userId));
	}
$photoBlock->getMyPhotoBlock(0,$CFG['admin']['photos']['profile_page_total_photo']);
$photoBlock->getMyFeaturedPhotoBlock();
$photoBlock->getMyPhotoAlbumBlock(0,$CFG['admin']['photos']['profile_page_total_photo_album']);
?>