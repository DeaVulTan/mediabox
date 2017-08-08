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
 //$CFG['lang']['include_files'][] = 'languages/%s/photo/flashSlideShowConfiguration.php';
 $CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
 $CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
 $CFG['mods']['is_include_only']['non_html_header_files'] = true;
 $CFG['auth']['is_authenticate'] = false;
 require_once($CFG['site']['project_path'].'common/application_top.inc.php');
 class FeaturedMyPhotoSlideShow extends MediaHandler
 {

	/**
	 * PlaySlideShow::populatePlayListPhotos()
	 *
	 * @return
	 */
	public function populatePlayListPhotos()
	{
		$condition = 'photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').' AND pf.user_id=\''.$this->fields_arr['user_id'].'\''.
		' AND (p.user_id = '.$this->CFG['user']['user_id'].
		' OR photo_access_type = \'Public\''.$this->getAdditionalQuery('p.').')';
		$sql = 'SELECT p.photo_id,p.photo_title, photo_ext, photo_server_url,photo_title,'.
				' pa.photo_album_title,photo_ext FROM '.$this->CFG['db']['tbl']['photo'].' AS p JOIN '.
				$this->CFG['db']['tbl']['photo_featured'].' as pf ON pf.photo_id=p.photo_id '.
				' LEFT JOIN '.$this->CFG['db']['tbl']['photo_album'].' AS pa on pa.photo_album_id=p.photo_album_id '.
				' WHERE '.$condition.' ORDER BY'.
				' photo_id DESC';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$photos_folder = 'files/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$inc = 0;
		$result_arr = array();

		if($rs->PO_RecordCount())
		{
			while($row = $rs->FetchRow())
			{
				  $result_arr[$inc]['photo_title'] = $row['photo_title'];
				  $photo_name = getphotoName($row['photo_id']);
				  $result_arr[$inc]['thumb_img_src'] = $row['photo_server_url'] . $photos_folder.$photo_name.$this->CFG['admin']['photos']['thumb_name'].'.'.$row['photo_ext'];
				  $result_arr[$inc]['large_img_src'] = $row['photo_server_url'] . $photos_folder.$photo_name.$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'];
				  $result_arr[$inc]['view_photo_link'] = getUrl('viewphoto', '?photo_id=' . $row['photo_id'] . '&title=' . $this->changeTitle($row['photo_title']), $row['photo_id'] . '/' . $this->changeTitle($row['photo_title']) . '/', '', 'photo');
				  $inc++;
			}
			return $result_arr;
		 }
		 return false;
	}


	public function getXmlCode()
	{
		$this->configPath = $this->CFG['site']['url'].'files/flash/photo/';
		$result_arr = $this->populatePlayListPhotos();
		if($result_arr)
		{
		?>
			<ALBUM Music="" Volume="" Speed="" Rows="" AutoPlay="" refresh="">
			<?php
				//echo '<pre>'; print_r($result_arr); echo '</pre>';
				foreach($result_arr as $photokey=>$photovalue)
				{
					//echo '<pre>'; print_r($photovalue); echo '</pre>';
			?>
			<IMG Image="<?php echo $photovalue['large_img_src']; ?>"  Desc="<?php echo $photovalue['photo_title']; ?>" Thumbnail="<?php echo $photovalue['thumb_img_src']; ?>" Weburl="<?php echo $photovalue['view_photo_link'];?>"   Window="_parent"/>
			<?php
				}
			?>
			<Settings>
				<!--border Url="<?php echo $this->configPath; ?>Assets/border_alpha.swf" />
				 <effects>
				    <effect objurl="<?php echo $this->configPath; ?>Assets/Bubbles.swf" />
				    <effect objurl="<?php echo $this->configPath; ?>Assets/leavesfalling.swf" />
					<effect objurl="<?php echo $this->configPath; ?>Assets/fish_anim.swf" />
					<effect objurl="<?php echo $this->configPath; ?>Assets/butterflies.swf" />
					<effect objurl="<?php echo $this->configPath; ?>Assets/heartsflling.swf" />
					<effect objurl="<?php echo $this->configPath; ?>Assets/3.swf" />
				</effects-->
				<Control Name="Logo" Value="false" Url="http://u2lab.com/buy-sale-service/images/minilogo.swf" Transparency="50"  RollOverTransparency="100" LogoPosition="RB" hspace="10" vspace="10" TargetUrl="http://www.mediabox.uz" Target="_blank" />
			</Settings>
			</ALBUM>
		<?php
		}
	}

}
$featuredslideshow = new FeaturedMyPhotoSlideShow();
$CFG['user']['user_id'] = isset($_SESSION['user']['user_id'])?$_SESSION['user']['user_id']:'0';
$CFG['admin']['is_logged_in'] = isset($_SESSION['admin']['is_logged_in'])?$_SESSION['admin']['is_logged_in']:'0';
$featuredslideshow->makeGlobalize($CFG,$LANG);
$featuredslideshow->setFormField('user_id', '');
$featuredslideshow->sanitizeFormInputs($_REQUEST);
if($featuredslideshow->getFormField('user_id')!='')
{
	$featuredslideshow->getXmlCode();
}
setHeaderEnd();
?>