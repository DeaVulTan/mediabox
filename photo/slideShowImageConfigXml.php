<?php
/**
 * PlaySlideShow
 *
 * @category    Rayzz
 * @package     General
 * @author      shankar_044at09
 * @copyright   Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license     http://www.mediabox.uz Uzdc Infoway Licence
 */
 require_once('../common/configs/config.inc.php');
 require_once('../common/configs/config_photo.inc.php');
 require_once('../common/configs/config_photo_slideshow.inc.php');

 $CFG['site']['is_module_page']='photo';

 $CFG['lang']['include_files'][] = 'languages/%s/photo/common.inc.php';
 $CFG['lang']['include_files'][] = 'languages/%s/photo/flashSlideShowConfiguration.php';
 $CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
 $CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
 $CFG['mods']['is_include_only']['non_html_header_files'] = true;
 $CFG['auth']['is_authenticate'] = false;
 require_once($CFG['site']['project_path'].'common/application_top.inc.php');
 class PlaySlideShow extends MediaHandler
 {

	/**
	 * PlaySlideShow::chkIsValidFileUrl()
	 *
	 * @param string $file_url
	 * @return
	 */

	public function chkIsValidFileUrl($file_url)
	{
		if(preg_match('/http/', $file_url) and chkIsValidUrlUsingCurl($file_url))
			return true;
		return false;
	}

	/**
	 * PlaySlideShow::populateQuickMixPhotos()
	 *
	 * @param mixed $photo_ids
	 * @return
	 */
	public function populateQuickMixPhotos($photo_ids)
	{
		$photo_ids = '\''.str_replace(',','\',\'' ,$photo_ids).'\'';

		$sql = 'SELECT p.photo_id,  p.location_recorded, p.user_id, u.user_name, p.photo_ext,'.
			   'p.photo_tags, p.photo_title, photo_caption, p.photo_server_url,'.
			   'TIMEDIFF(NOW(), p.date_added) as date_added, p.total_views, p.total_comments, (p.rating_total/p.rating_count) as rating '.
			   'FROM '.$this->CFG['db']['tbl']['photo'].' as p LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u '.
			   'ON p.user_id=u.user_id WHERE p.photo_status=\'Ok\' AND u.usr_status=\'Ok\' AND photo_id IN('.$photo_ids.')';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);

		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$cssImage_folder = $this->CFG['site']['url'].'/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/';
		$original_photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['original_photo_folder'].'/';
		$inc=0;
		$result_arr = array();

		if($rs->PO_RecordCount())
		{
			while($row = $rs->FetchRow())
			{
			  $result_arr[$inc]['photo_title'] = $row['photo_title'];
			  $result_arr[$inc]['photo_caption'] = $row['photo_caption'];
			  $photo_name = getphotoName($row['photo_id']);
			  $result_arr[$inc]['slideshow_img_src'] = $row['photo_server_url'] . $photos_folder.$photo_name.$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'];
			  if($row['photo_server_url'] == $this->CFG['site']['url'])
			  {
			 	if(file_exists($this->CFG['site']['project_path'].$original_photos_folder.$photo_name.'.'.$row['photo_ext']))
			  	{
			  		$result_arr[$inc]['large_img_src'] = $row['photo_server_url'].$original_photos_folder.$photo_name.'.'.$row['photo_ext'];
			  	}
				else
				{
					$result_arr[$inc]['large_img_src'] = $row['photo_server_url'].$photos_folder.$photo_name.$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'];
				}
			  }
			  elseif($this->chkIsValidFileUrl($row['photo_server_url'] . $original_photos_folder.$photo_name.'.'.$row['photo_ext']))
			  {
			  		$result_arr[$inc]['large_img_src'] = $row['photo_server_url'].$original_photos_folder.$photo_name.'.'.$row['photo_ext'];
			  }
			  else
			  {
			  		$result_arr[$inc]['large_img_src'] = $row['photo_server_url'].$photos_folder.$photo_name.$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'];
			  }
			  $result_arr[$inc]['small_img_src'] = $row['photo_server_url'] . $photos_folder.$photo_name.$this->CFG['admin']['photos']['small_name'].'.'.$row['photo_ext'];
			  $result_arr[$inc]['user_name'] = $row['user_name'];
			  $result_arr[$inc]['total_views'] = $row['total_views'];
			  $result_arr[$inc]['total_comments'] = $row['total_comments'];
			  $result_arr[$inc]['rating'] = $row['rating'];
			  $inc++;
			}
			return $result_arr;
		}
		return false;

	}
	/**
	 * PlaySlideShow::populatePlayListPhotos()
	 *
	 * @return
	 */
	public function populatePlayListPhotos()
	{
		$content_filter = '';
		if(isset($_SESSION['user']['content_filter']) &&  $_SESSION['user']['content_filter']=='On')
			$content_filter = $this->getAdultQuery('p.', 'photo');
		$public_condition = ' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR p.photo_access_type = \'Public\''.
								$this->getAdditionalQuery('p.').')'.$content_filter;

		$sql = 'SELECT p.photo_id, p.photo_title,p.location_recorded, p.photo_server_url, p.photo_ext, u.user_name,photo_caption, '.
				' TIMEDIFF(NOW(), p.date_added) as date_added, p.total_views, p.total_comments, (p.rating_total/p.rating_count) as rating '.
				' FROM '.$this->CFG['db']['tbl']['photo_in_playlist'].' as ppl LEFT JOIN '.$this->CFG['db']['tbl']['photo'].
				' AS p ON ppl.photo_id=p.photo_id LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
				' ON p.user_id = u.user_id '.
				' WHERE ppl.photo_playlist_id = '.$this->dbObj->Param('photo_playlist_id'). ' AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\''.$public_condition.
				' ORDER BY ppl.order_id ASC';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$cssImage_folder = $this->CFG['site']['url'].'/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/';
		$original_photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['original_photo_folder'].'/';
		$inc = 0;
		$result_arr = array();

		if($rs->PO_RecordCount())
		{
			while($row = $rs->FetchRow())
			{
				  $result_arr[$inc]['photo_title'] = $row['photo_title'];
				  $result_arr[$inc]['photo_caption'] = $row['photo_caption'];
				  $photo_name = getphotoName($row['photo_id']);
				  $result_arr[$inc]['slideshow_img_src'] = $row['photo_server_url'] . $photos_folder.$photo_name.$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'];
				  if($row['photo_server_url'] == $this->CFG['site']['url'])
				  {
				 	if(file_exists($this->CFG['site']['project_path'].$original_photos_folder.$photo_name.'.'.$row['photo_ext']))
				  	{
				  		$result_arr[$inc]['large_img_src'] = $row['photo_server_url'].$original_photos_folder.$photo_name.'.'.$row['photo_ext'];
				  	}
					else
					{
						$result_arr[$inc]['large_img_src'] = $row['photo_server_url'].$photos_folder.$photo_name.$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'];
					}
				  }
				  elseif($this->chkIsValidFileUrl($row['photo_server_url'] . $original_photos_folder.$photo_name.'.'.$row['photo_ext']))
				  {
				  		$result_arr[$inc]['large_img_src'] = $row['photo_server_url'].$original_photos_folder.$photo_name.'.'.$row['photo_ext'];
				  }
				  else
				  {
				  		$result_arr[$inc]['large_img_src'] = $row['photo_server_url'].$photos_folder.$photo_name.$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'];
				  }
				  $result_arr[$inc]['small_img_src'] = $row['photo_server_url'] . $photos_folder.$photo_name.$this->CFG['admin']['photos']['small_name'].'.'.$row['photo_ext'];
				  $result_arr[$inc]['user_name'] = $row['user_name'];
				  $result_arr[$inc]['total_views'] = $row['total_views'];
				  $result_arr[$inc]['total_comments'] = $row['total_comments'];
				  $result_arr[$inc]['rating'] = $row['rating'];
				  $inc++;
			}
			return $result_arr;
		 }
		 return false;
	}

	/**
	 * PlaySlideShow::populateAlbumListPhotos()
	 *
	 * @return void
	 */
	public function populateAlbumListPhotos()
	{
		$content_filter = '';
		if(isset($_SESSION['user']['content_filter']) && $_SESSION['user']['content_filter']=='On')
			$content_filter = $this->getAdultQuery('p.', 'photo');
		$public_condition = ' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR p.photo_access_type = \'Public\''.
								$this->getAdditionalQuery('p.').')'.$content_filter;

		$sql  = 'SELECT p.photo_id, p.photo_title,p.location_recorded, p.photo_server_url, p.photo_ext, u.user_name, '.
				'photo_caption, p.total_views, p.total_comments, (p.rating_total/p.rating_count) as rating '.
				' FROM '.$this->CFG['db']['tbl']['photo_album'].' as pa LEFT JOIN '.$this->CFG['db']['tbl']['photo'].
				' AS p ON pa.photo_album_id = p.photo_album_id LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u '.
				' ON p.user_id = u.user_id  WHERE pa.photo_album_id = '.$this->dbObj->Param('photo_album_id').
				' AND u.usr_status=\'Ok\' AND p.photo_status=\'Ok\' '.$public_condition.' ORDER BY p.photo_id DESC';

		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$cssImage_folder = $this->CFG['site']['url'].'/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/';
		$original_photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['original_photo_folder'].'/';
		$inc = 0;
		$result_arr = array();

		if($rs->PO_RecordCount())
		{
			while($row = $rs->FetchRow())
			{
				 $result_arr[$inc]['photo_title'] = $row['photo_title'];
				  $result_arr[$inc]['photo_caption'] = $row['photo_caption'];
				  $photo_name = getphotoName($row['photo_id']);
				  if($row['photo_server_url'] == $this->CFG['site']['url'])
				  {
				 	if(file_exists($this->CFG['site']['project_path'].$original_photos_folder.$photo_name.'.'.$row['photo_ext']))
				  	{
				  		$result_arr[$inc]['large_img_src'] = $row['photo_server_url'].$original_photos_folder.$photo_name.'.'.$row['photo_ext'];
				  	}
					else
					{
						$result_arr[$inc]['large_img_src'] = $row['photo_server_url'].$photos_folder.$photo_name.$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'];
					}
				  }
				  elseif($this->chkIsValidFileUrl($row['photo_server_url'] . $original_photos_folder.$photo_name.'.'.$row['photo_ext']))
				  {
				  		$result_arr[$inc]['large_img_src'] = $row['photo_server_url'].$original_photos_folder.$photo_name.'.'.$row['photo_ext'];
				  }
				  else
				  {
				  		$result_arr[$inc]['large_img_src'] = $row['photo_server_url'].$photos_folder.$photo_name.$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'];
				  }
				  $result_arr[$inc]['slideshow_img_src'] = $row['photo_server_url'] . $photos_folder.$photo_name.$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'];

				  $result_arr[$inc]['small_img_src'] = $row['photo_server_url'] . $photos_folder.$photo_name.$this->CFG['admin']['photos']['small_name'].'.'.$row['photo_ext'];
				  $result_arr[$inc]['user_name'] = $row['user_name'];
				  $result_arr[$inc]['total_views'] = $row['total_views'];
				  $result_arr[$inc]['total_comments'] = $row['total_comments'];
				  $result_arr[$inc]['rating'] = $row['rating'];
				  $inc++;
			}
			return $result_arr;
		 }
		 return false;
	}
	public function getXmlCode()
	{
		//$result_arr = array();
		$slide_arry = explode('_',$this->fields_arr['slideshow']);
		$this->fields_arr['slideshow'] = $slide_arry[0];
		if(isset($slide_arry[1]))
			$this->fields_arr['playlist'] = $slide_arry[1];
		switch($this->fields_arr['slideshow'])
		{
			case 'pl':
				$result_arr = $this->populatePlayListPhotos();
				break;
			case 'al':
				$result_arr = $this->populateAlbumListPhotos();
				break;
			case 'ql':
				if(isset($_SESSION['user']['photo_quick_mixs']) && !empty($_SESSION['user']['photo_quick_mixs']))
				{
					$result_arr = $this->populateQuickMixPhotos($_SESSION['user']['photo_quick_mixs']);
				}
				break;
			default:
				break;
		}
		if($result_arr)
		{
		?>
			<IMAGES>
			<?php
				//echo '<pre>'; print_r($result_arr); echo '</pre>';
				foreach($result_arr as $photokey=>$photovalue)
				{
					//echo '<pre>'; print_r($photovalue); echo '</pre>';
			?>
			<PHOTO>
			  <SOURCE_BIG><?php echo $photovalue['large_img_src']; ?></SOURCE_BIG>
			  <SOURCE_THUMB><?php echo $photovalue['small_img_src']; ?></SOURCE_THUMB>
			  <SHOW_INFO_TXT>
				<IMAGE_DETAILS label="<?php echo $this->LANG['slideshow_photo_title']; ?>" value="<?php echo wordWrapManual($photovalue['photo_title'], 15, 15, true); ?>"/>
				<IMAGE_DETAILS label="<?php echo $this->LANG['slideshow_photo_added_by']; ?>" value="<?php echo $photovalue['user_name']; ?>"/>
				<IMAGE_DETAILS label="<?php echo $this->LANG['slideshow_photo_views']; ?>" value="<?php echo $photovalue['total_views']; ?>"/>
				<IMAGE_DETAILS label="<?php echo $this->LANG['slideshow_photo_comments']; ?>" value="<?php echo $photovalue['total_comments']; ?>"/>
				<IMAGE_DETAILS label="<?php echo $this->LANG['slideshow_photo_rating']; ?>" value="<?php echo $photovalue['rating']; ?>"/>
				<IMAGE_DETAILS label="<?php echo $this->LANG['slideshow_photo_description']; ?>" value="<?php echo $photovalue['photo_caption']; ?>"/>
			  </SHOW_INFO_TXT>
			</PHOTO>
			<?php
				}
			?>
			</IMAGES>
		<?php
		}
	}

}
$slideshow = new PlaySlideShow();
$CFG['user']['user_id'] = isset($_SESSION['user']['user_id'])?$_SESSION['user']['user_id']:'0';
$CFG['admin']['is_logged_in'] = isset($_SESSION['admin']['is_logged_in'])?$_SESSION['admin']['is_logged_in']:'0';
$slideshow->makeGlobalize($CFG,$LANG);
$slideshow->setFormField('slideshow', '');
$slideshow->setFormField('playlist', '');
$slideshow->sanitizeFormInputs($_REQUEST);
if($slideshow->getFormField('slideshow')!='')
{
	$slideshow->getXmlCode();
}
setHeaderEnd();
?>