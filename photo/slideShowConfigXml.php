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
 class XmlCode extends MediaHandler
 {
	/**
	 * XmlCode::getXmlCode()
	 *
	 * @return boolean
	 **/
	public function getXmlCode()
	{
		$slide_arry = explode('~~',$this->fields_arr['slideshow']);
		$refrer_url = $slide_arry[1];
		?>
			<CONFIG>
				<IMAGE_XML source="<?php echo $this->CFG['site']['photo_url'].'slideShowImageConfigXml.php?slideshow='.$this->fields_arr['slideshow'];?>"/>
				<THEMES_XML source="<?php echo $this->CFG['site']['url'].$this->CFG['admin']['slideshow']['skin_path'].$this->CFG['html']['template']['default'].'_themes.xml';?>"/>
				<HOME_URL link="<?php echo $refrer_url; ?>"/>
				<AUTO_PLAY value="<?php echo $this->CFG['admin']['photos']['slide_show']['auto_play'];?>"/>
				<INITIAL_SPEED_MODE value="<?php echo $this->CFG['admin']['photos']['slide_show']['initial_speed_mode'];?>"/>
				<SLOW_MODE value="<?php echo $this->CFG['admin']['photos']['slide_show']['slow_speed'];?>"/>
				<MEDIUM_MODE value="<?php echo $this->CFG['admin']['photos']['slide_show']['medium_speed'];?>"/>
				<FAST_MODE value="<?php echo $this->CFG['admin']['photos']['slide_show']['fast_speed'];?>"/>
				<BG_IMAGE_PATH value="<?php echo $this->CFG['site']['photo_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/bg.png'; ?>"/>
				<LABELS>
						<HEADING><?php echo $this->LANG['slideshow_title'];?></HEADING>
						<BACK_TO><?php echo $this->LANG['slideshow_back_to_button'];?></BACK_TO>
						<HOME><?php echo $this->LANG['slideshow_home_button'];?></HOME>
						<SLOW><?php echo $this->LANG['slideshow_slow_button'];?></SLOW>
						<MEDIUM><?php echo $this->LANG['slideshow_medium_button'];?></MEDIUM>
						<FAST><?php echo $this->LANG['slideshow_fast_button'];?></FAST>
						<SHOW_INFO><?php echo $this->LANG['slideshow_show_info']; ?> </SHOW_INFO>
						<HIDE_INFO><?php echo $this->LANG['slideshow_hide_info']; ?></HIDE_INFO>
						<REPEAT><?php echo $this->LANG['slideshow_repeat']; ?></REPEAT>
						<EXIT><?php echo $this->LANG['slideshow_exit']; ?></EXIT>
				</LABELS>
			</CONFIG>
		<?php
	}
	/**
	 * XmlCode::updateViewSlidelistTable()
	 *
	 * @return boolean
	 **/
	public function updateViewSlidelistTable()
	{
		$slide_arry = explode('_',$this->fields_arr['slideshow']);
		if(isset($slide_arry[1]) && $slide_arry[0]=='pl')
		{
			$photo_playlist_id = $slide_arry[1];
			$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_playlist_viewed'].' SET'.
				   ' user_id='.$this->dbObj->Param('user_id').','.
				   ' photo_playlist_id='.$this->dbObj->Param('photo_playlist_id').','.
			       ' viewed_date=NOW()';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $photo_playlist_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($this->dbObj->Insert_ID())
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_playlist'].' SET'.
						' total_views=total_views+1 WHERE photo_playlist_id='.$this->dbObj->Param('photo_playlist_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($photo_playlist_id));
				if (!$rs)
				   trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				return true;
			}
		}
	}

}
$slideshow = new XmlCode();
$CFG['user']['user_id'] = isset($_SESSION['user']['user_id'])?$_SESSION['user']['user_id']:'0';
$CFG['admin']['is_logged_in'] = isset($_SESSION['admin']['is_logged_in'])?$_SESSION['admin']['is_logged_in']:'0';
$slideshow->makeGlobalize($CFG,$LANG);
$slideshow->setFormField('slideshow', '');
$slideshow->sanitizeFormInputs($_REQUEST);
if($slideshow->getFormField('slideshow')!='')
{
	$slideshow->getXmlCode();
	$slideshow->updateViewSlidelistTable();
}
setHeaderEnd();
?>