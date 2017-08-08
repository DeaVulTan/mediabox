<?php

class PhotoDetails extends PhotoHandler
{
	//public $commentUrl ='';
	public function chkValidPhotoId()
	{
		$photoId = $this->fields_arr['photo_id'];
		$photoId = is_numeric($photoId)?$photoId:0;
		if (!$photoId)
	    {
	        return false;
	    }
		$userId = $this->CFG['user']['user_id'];

		$condition = 'p.photo_status=\'Ok\' AND p.photo_id='.$this->dbObj->Param($photoId).
					' AND (p.user_id = '.$this->dbObj->Param($userId).' OR'.
					' p.photo_access_type = \'Public\''.$this->getAdditionalQuery('p.').')';

		$sql = 'SELECT p.photo_title, p.photo_caption,'.
				' p.total_favorites, p.total_views, p.total_comments, p.total_downloads,'.
				' p.allow_comments, p.allow_embed, p.allow_ratings, p.allow_tags, '.
				' p.photo_ext, p.photo_album_id,'.
				' p.photo_category_id, p.photo_tags, p.rating_total, p.rating_count, p.user_id, p.flagged_status, '.
				' p.photo_available_formats, p.photo_server_url, p.photo_upload_type, '.
				' ma.album_access_type, '.
				' DATE_FORMAT(p.date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
				' ma.album_title, p.total_plays,'.
				' p.large_width, p.large_height, p.thumb_width, p.thumb_height, p.small_width, p.small_height '.
				' FROM '.$this->CFG['db']['tbl']['photo'].' as p'.
				' JOIN ' . $this->CFG['db']['tbl']['users'] . ' as u on p.user_id = u.user_id'.
				' JOIN '.$this->CFG['db']['tbl']['photo_files_settings'].' ON photo_file_id = thumb_name_id '.
				' JOIN '.$this->CFG['db']['tbl']['photo_album'].' as ma ON ma.photo_album_id = p.photo_album_id'.
				' JOIN '.$this->CFG['db']['tbl']['photo_category'].' as mc ON mc.photo_category_id = p.photo_category_id'.
				' WHERE '.$condition.' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photoId, $userId));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$fields_list = array('user_name', 'first_name', 'last_name');
		if($row = $rs->FetchRow())
		{
			if(!isset($this->UserDetails[$row['user_id']]))
				$this->getUserDetails($row['user_id'], $fields_list);
			$name = $this->getUserName($row['user_id']);
			$this->fields_arr['user_id'] = $row['user_id'];
			$this->fields_arr['photo_ext'] = $row['photo_ext'];
			$this->fields_arr['photo_server_url'] = $row['photo_server_url'];
			$this->fields_arr['photo_title'] = $row['photo_title'];
			$this->fields_arr['photo_album'] = $row['album_title'];
			$this->fields_arr['photo_caption'] = $row['photo_caption'];
			$this->fields_arr['photo_ext'] = $row['photo_ext'];
			$this->fields_arr['date_added'] = $row['date_added'];
			$this->fields_arr['user_name'] = $name;
			$this->fields_arr['large_width'] = $row['large_width'];
			$this->fields_arr['large_height'] = $row['large_height'];
			$this->fields_arr['thumb_width'] = $row['thumb_width'];
			$this->fields_arr['thumb_height'] = $row['thumb_height'];
			$this->fields_arr['small_width'] = $row['small_width'];
			$this->fields_arr['small_height'] = $row['small_height'];
			$this->fields_arr['rating_total'] = $row['rating_total'];
			$this->fields_arr['rating_count'] = $row['rating_count'];
			$this->fields_arr['flagged_status'] = $row['flagged_status'];
			$this->fields_arr['comments'] = $row['total_comments']?$row['total_comments']:0;
			$this->fields_arr['photo_album_id'] = $row['photo_album_id'];
			$this->fields_arr['total_downloads'] = $row['total_downloads'];
			$this->fields_arr['cur_mid_total_views'] = $row['total_views'];
			$this->fields_arr['total_favorites'] = $row['total_favorites'];
			$this->fields_arr['total_views'] = $row['total_views'];
			$this->fields_arr['total_plays'] = $row['total_plays'];
			$this->fields_arr['total_comments'] = $row['total_comments'];
			$this->fields_arr['photo_category_id'] = $row['photo_category_id'];
			$this->fields_arr['photo_tags'] = $row['photo_tags'];
			$this->fields_arr['photo_upload_type'] = $row['photo_upload_type'];
			$this->fields_arr['photo_category_type'] = $this->getCategoryType($row['photo_category_id']);
			return true;
		}
		return false;
	}

	public function getCategoryType($category_id)
	{
		$sql = 'SELECT photo_category_type FROM '.$this->CFG['db']['tbl']['photo_category'].
				' WHERE photo_category_id='.$this->dbObj->Param('photo_category_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($category_id));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$category_type = 'General';
		if($row = $rs->FetchRow())
		{
			$category_type = $row['photo_category_type'];
		}
		return $category_type;
	}

	public function generatePhotoDetailsForQuickMIX()
	{
		$photo_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.
							$this->CFG['admin']['photos']['photo_folder'].'/';
		$photo_path = $this->fields_arr['photo_server_url'].
		 					$photo_folder.getphotoName($this->fields_arr['photo_id']).'.'.$this->fields_arr['photo_ext'];

		if($this->fields_arr['photo_ext'] != '')
		{
			$thumbnail = $this->fields_arr['photo_server_url'].$this->CFG['media']['folder'].'/'.
							$this->CFG['admin']['photos']['folder'].'/'.
								$this->CFG['admin']['photos']['photo_folder'].'/'.
										getphotoName($this->fields_arr['photo_id']).
											$this->CFG['admin']['photos']['medium_name'].'.'.
												$this->fields_arr['photo_ext'];
		}
		else
		{
			$thumbnail = $this->CFG['site']['url'].'photo/design/templates/'.
							$this->CFG['html']['template']['default'].'/root/images/'.
								$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_photo_M.jpg';
		}

		$photoTitlePath = '';
		if(!empty($this->fields_arr['photo_id']))
			$photoTitlePath = getUrl('viewphoto', '?photo_id='.$this->fields_arr['photo_id'], $this->fields_arr['photo_id'].'/', '', 'photo');
	}
}
$photodetails = new photoDetails();

if(!chkAllowedModule(array('photo')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

if(isMember())
	$photodetails->setMediaPath('../../');
else
	$photodetails->setMediaPath('../');


$photodetails->setPageBlockNames(array('photo_comments_block'));

//default form fields and values...
$photodetails->setFormField('photo_id', '');
$photodetails->setFormField('action', '');
$photodetails->setFormField('photo_title', '');
$photodetails->setFormField('user_name', '');
$photodetails->setFormField('user_id', '');
$photodetails->setFormField('type','');
$photodetails->setFormField('ajax_page','');

$photodetails->sanitizeFormInputs($_REQUEST);

if(isAjaxPage())
{
	if($photodetails->chkValidphotoId())
	{
		if($photodetails->getFormField('action') == 'quickmix')
		{
			$photodetails->includeAjaxHeaderSessionCheck();
			$photodetails->generatePhotoDetailsForQuickMIX();
			$photodetails->includeAjaxFooter();
			exit;
		}
	}
}
	//else{
//	echo '<br>test12';exit;
//	}
?>