<?php
/**
 * update the video view count in the video table
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Index
 * @author		palani_34ag07
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: viewCount.php 2883 2008-02-21 03:22:00Z
 * @since 	 2008-02-21
 */
/**
 * File having common configuration variables required for the entire project
 */
require_once('./common/configs/config.inc.php');
$CFG['db']['is_use_db'] = true;
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
$CFG['site']['is_module_page']='video';
/**
 * File to include the header file, database access file, session management file, help file and necessary functions
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------- Class VideoViewCountHandler begins --------------->>>>>//
/**
 *
 * @category	Rayzz
 * @package		Index
 * @author 		palani_34ag07
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2006-05-01
 */
class VideoViewCountHandler extends FormHandler
	{
		/**
		 * ViewVideo::updateViewDateAndViewCount()
		 *
		 * @return
		 **/
		public function updateViewDateAndViewCount()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET'.
						' total_views=total_views+1, last_view_date=NOW()'.
						' WHERE video_id='.$this->dbObj->Param('video_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($this->dbObj->Affected_Rows())
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_viewed'].' SET'.
	 							' user_id='.$this->dbObj->Param('vvuid').', total_views=total_views+1, '.
								' video_owner_id='.$this->dbObj->Param('vouid').','.
	 							' view_date=NOW() WHERE video_id='.$this->dbObj->Param('video_id');

	 					$stmt = $this->dbObj->Prepare($sql);
	 					//$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['user_id'], $this->fields_arr['video_id']));
	 					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['vvuid'], $this->fields_arr['vouid'], $this->fields_arr['video_id']));
	 					    if (!$rs)
	 						    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if(!$this->dbObj->Affected_Rows())
							{
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_viewed'].' SET'.
			 							' user_id='.$this->dbObj->Param('vvuid').', total_views=1, '.
										' video_owner_id='.$this->dbObj->Param('vouid').','.
										' video_id='.$this->dbObj->Param('video_id').','.
			 							' view_date=NOW()';
			 					$stmt = $this->dbObj->Prepare($sql);
			 					//$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['user_id'], $this->fields_arr['video_id']));
			 					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['vvuid'], $this->fields_arr['vouid'], $this->fields_arr['video_id']));
			 					    if (!$rs)
			 						    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
							}
					}
			}


	}
//<<<<<-------------- Class VideoViewCountHandler begins ---------------//
//-------------------- Code begins -------------->>>>>//



$viewCount = new VideoViewCountHandler();
$viewCount->setDBObject($db);
$viewCount->makeGlobalize($CFG,$LANG);
$viewCount->setFormField('video_id', '');
$viewCount->setFormField('vouid', '');//video Owner ID
$viewCount->setFormField('vvuid', '');// video Visitor User ID

if($viewCount->isFormGETed($_GET, 'video_id'))
	{
		$viewCount->sanitizeFormInputs($_GET);
		$viewCount->updateViewDateAndViewCount();

	}
//<<<<<-------------------- Page block templates ends --------------------//
/**
 * File to include the footer file and show benchmarking for developer
 */
//require_once($CFG['site']['project_path'].'common/application_bottom.inc.php');
?>

