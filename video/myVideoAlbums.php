<?php
/**
 * This file is to display the my albums
 *
 * This file is having MyAlbums class to display the my albums
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: myVideoAlbums.php 2986 2006-12-29 05:25:10Z selvaraj_35ag05 $
 * @since 		2006-05-02
 *
 **/

require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/myVideoAlbums.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MailHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['site']['is_module_page']='video';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include various types of files
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * MyAlbums
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: myVideoAlbums.php 2986 2006-12-29 05:25:10Z selvaraj_35ag05 $
 * @access public
 **/
class MyAlbums extends VideoHandler
	{
		/**
		 * MyAlbums::buildConditionQuery()
		 *
		 * @return
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'user_id=\''.$this->CFG['user']['user_id'].'\'';
			}

		/**
		 * MyAlbums::buildSortQuery()
		 *
		 * @return
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'video_album_id DESC';
			}

		/**
		 * MyAlbums::getAVideoForAlbum()
		 *
		 * @param $album_id
		 * @return
		 **/
		public function getAVideoForAlbum($album_id)
			{
				$sql = 'SELECT COUNT(video_id) AS total_videos,video_id,s_width,s_height,video_server_url'.
						' FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_album_id='.$this->dbObj->Param('video_album_id'). 'AND user_id ='.$this->dbObj->Param('user_id').
						' AND video_status=\'Ok\' GROUP BY video_album_id';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($album_id,$this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$this->total_videos = 0;
				if($row = $rs->FetchRow())
					{
						$this->video_id = $row['video_id'];
						$this->s_width = $row['s_width'];
						$this->s_height = $row['s_height'];
						$this->video_server_url = $row['video_server_url'];
						$this->total_videos = $row['total_videos'];
						return true;
					}
			}

		/**
		 * MyAlbums::showAlbums()
		 *
		 * @return
		 **/
		public function showAlbums()
			{
				$result = array();
				$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				$inc=0;
				while($row = $this->fetchResultRecord())
					{

						$result[$inc]['anchor']= 'dAlt_'.$row['video_album_id'];
						$result[$inc]['video_album_id']=$row['video_album_id'];
						$result[$inc]['album_title']=$row['album_title'];
						if((is_array($this->fields_arr['album_ids'])) && (in_array($row['video_album_id'], $this->fields_arr['album_ids'])))
							{
								$result[$inc]['checked']= "checked";
							}
						else
							{
								$result[$inc]['checked']= "";
							}
						if($total_video = $this->getAVideoForAlbum($row['video_album_id']))
							{
								if($row['video_id'])
									{
										$result[$inc]['video_path'] = $row['video_server_url'].$videos_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
										$result[$inc]['disp_image']=DISP_IMAGE($this->CFG['admin']['videos']['small_width'], $this->CFG['admin']['videos']['small_height'], $row['s_width'], $row['s_height']);
									}
								else
									{
										$result[$inc]['video_path'] = $this->video_server_url.$videos_folder.getVideoImageName($this->video_id).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
										$result[$inc]['disp_image']=DISP_IMAGE($this->CFG['admin']['videos']['small_width'], $this->CFG['admin']['videos']['small_height'], $this->s_width, $this->s_height);
									}
							}
						else
							{
								$result[$inc]['video_path'] = $this->CFG['site']['video_url'].'/design/templates/'.
																$this->CFG['html']['template']['default'].'/root/images/'.
																	$this->CFG['html']['stylesheet']['screen']['default'].
																	'/no_image/noImageVideo_S.jpg';
								$result[$inc]['disp_image']="";
							}
						$result[$inc]['createalbum_edit_url'] = getUrl('createalbum','?module=video&video_album_id='.$row['video_album_id'], '?module=video&video_album_id='.$row['video_album_id'], '', 'video');
						$result[$inc]['total_videos']= $this->total_videos;
						$result[$inc]['videoUpload']= getUrl('videouploadpopup','?album_id='.$row['video_album_id'], '?album_id='.$row['video_album_id'],'','video');
						$result[$inc]['abumvideolist_link']=getUrl('videolist','?pg=myalbumvideolist&album_id='.$row['video_album_id'], 'myalbumvideolist/?album_id='.$row['video_album_id'],'','video');
						$result[$inc]['record']=$row;
						$inc++;
					}
				return $result;
			}

		/**
		 * MyAlbums::chkValidAlbumId()
		 *
		 * @return
		 **/
		public function chkValidAlbumId()
			{
				$sql = 'SELECT COUNT(1) AS count FROM '.$this->CFG['db']['tbl']['video_album'].
						' WHERE video_album_id='.$this->dbObj->Param('video_album_id').
						' AND user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['album_id'], $this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = $rs->FetchRow();
				if($row['count'])
					return true;
				return false;
			}

		/**
		 * MyAlbums::getVideoDetailsFromTable()
		 *
		 * @return
		 **/
		public function getVideoDetailsFromTable($album_id)
			{
				//get videos from videos table
				$sql = 'SELECT video_id FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_album_id='.$this->dbObj->Param('video_album_id').' AND video_status=\'Ok\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($album_id));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$video_id = '';
				$total_images = 0;
				$this->fields_arr['video_ids']  = '';
				$this->fields_arr['total_images'] = '';
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$video_id .= $row['video_id'].',';
								$total_images  += 1;
							}
						$video_id = substr($video_id, 0, strrpos($video_id, ','));
						$this->fields_arr['video_ids'] = $video_id;
						$this->fields_arr['total_images'] = $total_images;
						return true;
					}
				else
					return false;
			}

		/**
		 * MyAlbums::removeAlbum()
		 *
		 * @param string $video_id
		 * @return
		 **/
		public function removeAlbum()
			{
				$album_id_arr = explode(',', $this->fields_arr['album_id']);
				//echo '<pre>';print_r($album_id_arr);echo '</pre>';exit;
				foreach($album_id_arr as $album_id)
					{
						$this->getVideoDetailsFromTable($album_id);
						$total_images = $this->fields_arr['total_images'];
						if($this->fields_arr['video_ids'])
							{
								$video_id_arr = explode(',', $this->fields_arr['video_ids']);
								$this->deleteVideos($video_id_arr, $this->CFG['user']['user_id']);
							}

						//DELETE PHOTO ALBUM
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['video_album'].
								' WHERE video_album_id=\''.addslashes($album_id).'\'';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
			}
	}
//<<<<<-------------- Class VideoUpload begins ---------------//
//-------------------- Code begins -------------->>>>>//
$MyAlbums = new MyAlbums();
$MyAlbums->setDBObject($db);
$MyAlbums->makeGlobalize($CFG,$LANG);

if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$MyAlbums->setPageBlockNames(array('msg_form_error', 'msg_form_success', 'my_albums_form'));
$MyAlbums->setCSSFormFieldErrorTipClass('clsFormFieldErrTip');
$MyAlbums->setCSSFormLabelCellDefaultClass('clsFormLabelCellDefault');
$MyAlbums->setCSSFormFieldCellDefaultClass('clsFormFieldCellDefault');
$MyAlbums->setCSSFormLabelCellErrorClass('clsFormLabelCellError');
$MyAlbums->setCSSFormFieldCellErrorClass('clsFormFieldCellError');

//default form fields and values...
$MyAlbums->setFormField('start', '0');
$MyAlbums->setFormField('video_album_id', '');
$MyAlbums->setFormField('album_id', '');
$MyAlbums->setFormField('album_ids', array());
$MyAlbums->setFormField('action', '');
$MyAlbums->setFormField('slno', '1');
$MyAlbums->setFormField('numpg', $CFG['data_tbl']['numpg']);
$MyAlbums->setCSSColumnHeaderCellAscSortClasses(array('clsColumnHeaderCellAscSort1',
																		'clsColumnHeaderCellAscSort2',
																		'clsColumnHeaderCellAscSort3',
																		'clsColumnHeaderCellAscSort4',
																		'clsColumnHeaderCellAscSort5')
																);
$MyAlbums->setCSSColumnHeaderCellDefaultClass('clsColumnHeaderCellDefault');
$MyAlbums->setCSSColumnHeaderCellDescSortClasses(array('clsColumnHeaderCellDscSort1',
													'clsColumnHeaderCellDscSort2',
													'clsColumnHeaderCellDscSort3',
													'clsColumnHeaderCellDscSort4',
													'clsColumnHeaderCellDscSort5')
											);
$MyAlbums->setMinRecordSelectLimit(2);
$MyAlbums->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$MyAlbums->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);

$MyAlbums->setTableNames(array($CFG['db']['tbl']['video_album']));
$MyAlbums->setReturnColumns(array('video_album_id','album_title','date_added','video_id','s_width','s_height','video_server_url'));

/************ page Navigation stop *************/
$MyAlbums->setAllPageBlocksHide();
$MyAlbums->setPageBlockShow('my_albums_form');
$MyAlbums->sanitizeFormInputs($_REQUEST);

if($MyAlbums->isFormPOSTed($_POST, 'delete'))
{
	$MyAlbums->removeAlbum();
	$MyAlbums->setPageBlockShow('msg_form_success');
	$MyAlbums->setCommonErrorMsg($LANG['msg_success_delete']);
}
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//

if ($MyAlbums->isShowPageBlock('my_albums_form'))
{
	/****** navigtion continue*********/
	$MyAlbums->buildSelectQuery();
	$MyAlbums->buildConditionQuery();
	$MyAlbums->buildSortQuery();
	$MyAlbums->buildQuery();
	$MyAlbums->executeQuery();
	/******* Navigation End ********/
	$MyAlbums->videoalbum_create_link=getUrl('createalbum','?module=video', '?module=video', '', 'video');
	if($MyAlbums->isResultsFound())
	{
		//$MyAlbums->populatePageLinks($MyAlbums->getFormField('start'), array());

		$MyAlbums->my_albums_form=$MyAlbums->showAlbums();

		$smartyObj->assign('smarty_paging_list', $MyAlbums->populatePageLinksGET($MyAlbums->getFormField('start'), array()));
	}
}


//include the header file
$MyAlbums->includeHeader();
//include the content of the page
setTemplateFolder('members/','video');
$smartyObj->display('myVideoAlbums.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$MyAlbums->includeFooter();
