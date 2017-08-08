<?php
/**
 * File to allow the users manage the video play list
 *
 * Provides an interface to manage the video play list
 *
 *
 * @category	Rayzz
 * @package		ForumsTopiccreate
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/videoPlaylistManage.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MailHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['site']['is_module_page']='video';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class MyPlaylists--------------->>>//
/**
 * This class is used to manage the video play list
 *
 * @category	Rayzz
 * @package		MyPlaylists
 */
class MyPlaylists extends VideoHandler
	{
		/**
		 * MyPlaylists::buildConditionQuery()
		 *
		 * @return
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'pl.user_id=\''.$this->CFG['user']['user_id'].'\'';
			}

		/**
		 * MyPlaylists::buildSortQuery()
		 *
		 * @return
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'playlist_id DESC';
			}

		/**
		 * MyPlaylists::getAVideoForPlaylist()
		 *
		 * @param $playlist_id
		 * @return
		 **/
		public function getAVideoForPlaylist($Playlist_id)
			{
				$sql = 'SELECT COUNT(video_id) AS total_videos,video_id,video_ext,s_width,s_height,video_server_url'.
						' FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE playlist_id='.$this->dbObj->Param('playlist_id').
						' AND video_status=\'Ok\' GROUP BY playlist_id';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($playlist_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$this->total_videos = 0;
				if($row = $rs->FetchRow())
					{
						$this->video_id = $row['video_id'];
						$this->video_ext = $row['video_ext'];
						$this->s_width = $row['s_width'];
						$this->s_height = $row['s_height'];
						$this->video_server_url = $row['video_server_url'];
						$this->total_videos = $row['total_videos'];
						return true;
					}
			}

		/**
		 * MyPlaylists::showPlaylists()
		 *
		 * @return
		 **/
		public function showPlaylists()
			{
				$result = array();
				$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/';
				$inc=0;
				while($row = $this->fetchResultRecord())
				{

					$result[$inc]['anchor']= 'dAlt_'.$row['playlist_id'];
					$result[$inc]['playlist_id']=$row['playlist_id'];
					$result[$inc]['playlist_name']=$row['playlist_name'];
					if((is_array($this->fields_arr['playlist_ids'])) && (in_array($row['playlist_id'], $this->fields_arr['playlist_ids'])))
						{
							$result[$inc]['checked']= "checked";
						}
					else
						{
							$result[$inc]['checked']= "";
						}
					if($total_video = $row['total_videos'])
						{
							$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
							if($row['video_id'])
								{
									$result[$inc]['video_path'] = $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
									//$row['video_server_url'].$videos_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$row['video_ext'];
									$result[$inc]['disp_image']=DISP_IMAGE($this->CFG['admin']['videos']['small_width'], $this->CFG['admin']['videos']['small_height'], $row['s_width'], $row['s_height']);
								}
							else
								{
									$result[$inc]['video_path'] = $row['video_server_url'].$thumbnail_folder.getVideoImageName($this->video_id).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
									//$result[$inc]['video_path'] = $this->video_server_url.$videos_folder.getVideoImageName($this->video_id).$this->CFG['admin']['videos']['small_name'].'.'.$this->video_ext;
									$result[$inc]['disp_image']=DISP_IMAGE($this->CFG['admin']['videos']['small_width'], $this->CFG['admin']['videos']['small_height'], $this->s_width, $this->s_height);
								}
						}
					else
						{
							$result[$inc]['video_path'] = $result[$inc]['video_path'] = $this->CFG['site']['video_url'].'design/templates/'.
																						  $this->CFG['html']['template']['default'].'/root/images/'.
																						  	$this->CFG['html']['stylesheet']['screen']['default'].
																							  '/no_image/noImageVideo_S.jpg';
							$result[$inc]['disp_image']="";
						}
					$result[$inc]['total_videos']=$row['total_videos'];
					$result[$inc]['playlist_view_link']= getUrl('viewvideoplaylist', '?playlist_id='.$row['playlist_id'], '?playlist_id='.$row['playlist_id'], '', 'video');
					$result[$inc]['playlist_edit_link']=getUrl('videolist','?pg=myplaylist&playlist_id='.$row['playlist_id'], 'myplaylist/?playlist_id='.$row['playlist_id'],'','video');
					$result[$inc]['record']=$row;
				$inc++;
				}
				return $result;
			}

		/**
		 * MyPlaylists::chkValidPlaylistId()
		 *
		 * @return
		 **/
		public function chkValidPlaylistId()
			{
				$sql = 'SELECT COUNT(1) AS count FROM '.$this->CFG['db']['tbl']['video_playlist'].
						' WHERE playlist_id='.$this->dbObj->Param('playlist_id').
						' AND user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id'], $this->CFG['user']['user_id']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = $rs->FetchRow();
				if($row['count'])
					return true;
				return false;
			}

		/**
		 * MyPlaylists::getVideoDetailsFromTable()
		 *
		 * @return
		 **/
		public function getVideoDetailsFromTable($playlist_id)
			{
				//get videos from videos table
				$sql = 'SELECT video_id FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE playlist_id='.$this->dbObj->Param('playlist_id').' AND video_status=\'Ok\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($playlist_id));
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
		 * MyPlaylists::removePlaylist()
		 *
		 * @param string $video_id
		 * @return
		 **/
		public function removePlaylist()
			{
				//var_dump($_POST);

				$playlist_id_arr = explode(',', $this->fields_arr['playlist_id']);
				//echo '<pre>';print_r($playlist_id_arr);echo '</pre>';exit;
				foreach($playlist_id_arr as $playlist_id)
					{
						//DELETE VIDEO Playlist
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['video_playlist'].
								' WHERE playlist_id=\''.addslashes($playlist_id).'\'';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
			}

				/**
		 * VideoUpload::storeImagesTempServer()
		 *
		 * @param $uploadUrl
		 * @param $extern
		 * @return
		 **/
		public function storeImagesTempServer($uploadUrl, $extern)
			{
				//GET LARGE IMAGE
				@chmod($uploadUrl.'.'.$extern, 0777);
				if($this->CFG['admin']['videos']['playlist_height'] or $this->CFG['admin']['videos']['playlist_width'])
					{
						$this->imageObj->resize($this->CFG['admin']['videos']['playlist_width'], $this->CFG['admin']['videos']['playlist_height'], '-');
						$this->imageObj->output_resized($uploadUrl.'.'.$extern, strtoupper($extern));
					}
					else
						{
							$this->imageObj->output_original($uploadUrl.'.'.$extern, strtoupper($extern));
						}
			}


		public function addQuickListToPlayList($playlist_id)
			{

				if(isset($_SESSION['user']['quick_links']) and trim($_SESSION['user']['quick_links']) and $avail_quick_link_video_arr=explode(',',$_SESSION['user']['quick_links']) and is_array($avail_quick_link_video_arr))
					{
						$avail_quick_link_video_arr = array_unique($avail_quick_link_video_arr);
						$count=1;
						foreach($avail_quick_link_video_arr as $index=>$value)
							{
								if($value)
									{
										if($count==1)
											$this->setThisVideoAsThumb($playlist_id, $value);

										$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_in_playlist'].' SET '.
										'playlist_id = '.$this->dbObj->Param($playlist_id).', '.
										'video_id = '.$this->dbObj->Param($value).', '.
										'order_id = '.$this->dbObj->Param($count).', '.
										'date_added = now() ';
										$fields_value_arr = array($playlist_id,
																	$value,
																	$count,
																);
										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
										if (!$rs)
										        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
										$count++;
									}
							}
						if($count > 1)
							{
								$count--;
								$this->updateTotalVideosCount($count, $playlist_id);
							}
					}
					else
						return false;

				return true;

			}
		/**
		 * To check if the playlist exists already
		 *
		 * @param string $playlist
		 * @param string $err_tip
		 * @access public
		 * @return void
		 **/
		public function chkplaylistExits($playlist, $err_tip='')
			{
				$sql = 'SELECT COUNT(playlist_id) AS count FROM '.$this->CFG['db']['tbl']['video_playlist'].' '.
						'WHERE UCASE(playlist_name) = UCASE('.$this->dbObj->Param($this->fields_arr[$playlist]).') '.
						' AND user_id=\''.$this->CFG['user']['user_id'].'\' ';
				$fields_value_arr[] = $this->fields_arr[$playlist];
				if ($this->fields_arr['playlist_id'])
					{
						$sql .= ' AND playlist_id != '.$this->dbObj->Param($this->fields_arr['playlist_id']);
						$fields_value_arr[] = $this->fields_arr['playlist_id'];
				    }
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($fields_value_arr));
				if (!$rs)
				        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				$row = $rs->FetchRow();
				if(!$row['count'])
					{
						return false;
					}
				$this->fields_err_tip_arr['playlist_name'] = $err_tip;
				//$this->setCommonErrorMsg($err_tip);
				return false;
			}


		/**
		 * To Update playlist image ext
		 *
		 * @param string $playlist_ext
		 * @access public
		 * @return void
		 **/
		public function updateplaylistImageExt($playlist_ext)
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_playlist'].' SET '.
						'play_list_ext = '.$this->dbObj->Param($playlist_ext).' '.
						'WHERE playlist_id = '.$this->dbObj->Param($this->playlist_id);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($playlist_ext, $this->playlist_id));
				if (!$rs)
				        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				return true;
			}

			public function setThisVideoAsThumb($playlist_id, $video_id)
			{
				$sql = ' UPDATE '.$this->CFG['db']['tbl']['video_playlist'].' SET '.
						'thumb_video_id = '.$this->dbObj->Param($video_id).' WHERE playlist_id=\''.$playlist_id.'\' ';
						$fields_value_arr = array($video_id);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
						if (!$rs)
						       trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			}


		public function updateTotalVideosCount($count, $playlist_id)
			{
				$sql = ' UPDATE '.$this->CFG['db']['tbl']['video_playlist'].' SET '.
						' total_videos = '.$this->dbObj->Param($count).' WHERE playlist_id=\''.$playlist_id.'\' ';
						$fields_value_arr = array($count);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
						if (!$rs)
						       trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}


	}
//<<<<<-------------- Class VideoUpload begins ---------------//
//-------------------- Code begins -------------->>>>>//
$MyPlaylists = new MyPlaylists();
if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$MyPlaylists->setPageBlockNames(array('msg_form_error', 'msg_form_success', 'my_playlist_form','msg_form_success_create','msg_form_error_create'));
//default form fields and values...
$MyPlaylists->setFormField('start', '0');
$MyPlaylists->setFormField('playlist_id', '');
$MyPlaylists->setFormField('playlist_id', '');
$MyPlaylists->setFormField('playlist_ids', array());
$MyPlaylists->setFormField('action', '');
$MyPlaylists->setFormField('slno', '1');
$MyPlaylists->setFormField('start', '0');
$MyPlaylists->setFormField('playlist_name', '');
$MyPlaylists->setFormField('playlist_description', '');
$MyPlaylists->setFormField('playlist_tags', '');
$MyPlaylists->setFormField('playlist_access_type', 'public');
$MyPlaylists->setFormField('use', '');
$MyPlaylists->setFormField('numpg', $CFG['data_tbl']['numpg']);
$MyPlaylists->setMinRecordSelectLimit(2);
$MyPlaylists->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$MyPlaylists->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$MyPlaylists->setTableNames(array($CFG['db']['tbl']['video_playlist'].' as pl LEFT JOIN '.$CFG['db']['tbl']['video'].' as p ON pl.thumb_video_id=p.video_id' ));
$MyPlaylists->setReturnColumns(array('pl.playlist_id','pl.playlist_name','pl.date_added','pl.thumb_video_id as video_id','pl.thumb_ext as video_ext','pl.total_videos','p.s_width','p.s_height','p.video_server_url','playlist_access_type'));
/************ page Navigation stop *************/
$MyPlaylists->setAllPageBlocksHide();
$MyPlaylists->setPageBlockShow('my_playlist_form');
$MyPlaylists->sanitizeFormInputs($_REQUEST);

$common_err_tip_invalid_tag_min = str_replace('VAR_MIN', $CFG['fieldsize']['tags']['min'],
													$LANG['common_err_tip_invalid_tag']);
$MyPlaylists->LANG['common_err_tip_invalid_tag'] = str_replace('VAR_MAX', $CFG['fieldsize']['tags']['max'],
													$common_err_tip_invalid_tag_min);

$LANG['videoplaylist_playlist_name_lbl'] = str_replace('{min_count}', $CFG['fieldsize']['playlist_name']['min'], $LANG['videoplaylist_playlist_name_lbl']);
$LANG['videoplaylist_playlist_name_lbl'] = str_replace('{max_count}', $CFG['fieldsize']['playlist_name']['max'], $LANG['videoplaylist_playlist_name_lbl']);
$MyPlaylists->LANG['videoplaylist_playlist_name_lbl'] =$LANG['videoplaylist_playlist_name_lbl'];
$MyPlaylists->videoplaylist_playlist_name_lang=$LANG['videoplaylist_playlist_name_lbl'];

$LANG['videoplaylist_name_with_size'] = str_replace('{min_count}', $CFG['fieldsize']['playlist_name']['min'], $LANG['videoplaylist_name_with_size']);
$LANG['videoplaylist_name_with_size'] = str_replace('{max_count}', $CFG['fieldsize']['playlist_name']['max'], $LANG['videoplaylist_name_with_size']);
$MyPlaylists->LANG['help']['playlist_name'] =$LANG['videoplaylist_name_with_size'];

if($MyPlaylists->isFormPOSTed($_POST, 'delete'))
	{
		$MyPlaylists->removePlaylist();
		$MyPlaylists->setPageBlockShow('msg_form_success');
		$MyPlaylists->setCommonErrorMsg($LANG['msg_success_delete']);
	}

if($MyPlaylists->isFormPOSTed($_POST, 'playlist_submit'))
	{
		$playlist_faliure_message=sprintf($LANG['playlist_err_tip_alreay_exists'],$MyPlaylists->getFormField('playlist_name'));
		$LANG['playlist_create_failure']=sprintf($LANG['playlist_create_failure'],$MyPlaylists->getFormField('playlist_name'));
		$MyPlaylists->chkIsNotEmpty('playlist_name', $LANG['playlist_err_tip_compulsory'])and
		$MyPlaylists->chkIsValidSize('playlist_name','playlist_name',$LANG['playlistname_invalid_size'])and
		$MyPlaylists->chkplaylistExits('playlist_name', $playlist_faliure_message);
		$MyPlaylists->chkIsNotEmpty('playlist_tags', $LANG['playlist_err_tip_compulsory']);
		$MyPlaylists->chkIsNotEmpty('playlist_description', $LANG['playlist_err_tip_compulsory']);
		$MyPlaylists->chkValidTagList('playlist_tags','tags', $LANG['playlist_err_tip_invalid_tag']);

		if($MyPlaylists->isValidFormInputs())
			{
				$id=$MyPlaylists->createplaylist();
				if($MyPlaylists->getFormField('use')=='ql')
					{
						if($MyPlaylists->addQuickListToPlayList($id))
							{
								$MyPlaylists->setPageBlockShow('msg_form_success_create');
								$MyPlaylists->setCommonSuccessMsg($LANG['playlist_created_successfully']);
								$MyPlaylists->setFormField('use', '');

							}
						else
							{
								$MyPlaylists->setPageBlockShow('msg_form_error_create');
								$MyPlaylists->setCommonErrorMsg($LANG['playlist_create_failure']);
							}

					}
				$MyPlaylists->setFormField('playlist_name', '');
				$MyPlaylists->setFormField('playlist_description', '');
				$MyPlaylists->setFormField('playlist_tags', '');
			}
		else
			{
					$MyPlaylists->setPageBlockShow('msg_form_error_create');
					$MyPlaylists->setCommonErrorMsg($LANG['common_msg_error_sorry']);
			}

	}
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if ($MyPlaylists->isShowPageBlock('my_playlist_form'))
	{
		/****** navigtion continue*********/
		$MyPlaylists->buildSelectQuery();
		$MyPlaylists->buildConditionQuery();
		$MyPlaylists->buildSortQuery();
		$MyPlaylists->buildQuery();
		$MyPlaylists->executeQuery();
		/******* Navigation End ********/
		if($MyPlaylists->isResultsFound())
			{
				//$MyPlaylists->populatePageLinks($MyPlaylists->getFormField('start'), array());
				$MyPlaylists->videoPlaylist_create_link='';
				$MyPlaylists->my_playlists_form=$MyPlaylists->showPlaylists();
			}
	}
$smartyObj->assign('smarty_paging_list', $MyPlaylists->populatePageLinksGET($MyPlaylists->getFormField('start'), array()));
//include the header file
$MyPlaylists->includeHeader();
//include the content of the page
setTemplateFolder('members/','video');
$smartyObj->display('videoPlaylistManage.tpl');
?>
<?php
/* Added code to validate mandataory fields in video defaut settings page */
if ($CFG['feature']['jquery_validation'])
{

?>
<script type="text/javascript">
var tag_min='<?php echo $CFG['fieldsize']['tags']['min']; ?>';
var tag_max='<?php echo $CFG['fieldsize']['tags']['max']; ?>';
$Jq("#videoPlaylistManageFrm").validate({
	rules: {
	    playlist_name: {
	    	required: true,
	    	minlength: <?php echo $CFG['fieldsize']['playlist_name']['min']; ?>,
			maxlength: <?php echo $CFG['fieldsize']['playlist_name']['max']; ?>
		 },
		 playlist_description: {
	    	required: true
		 },
		 playlist_tags: {
	    	required: true,
			chkValidTags: Array(tag_min, tag_max)
		 }
	},
	messages: {
		playlist_name: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		playlist_description: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		},
		playlist_tags: {
			required: "<?php echo $LANG['common_err_tip_required'];?>",
			chkValidTags: "<?php echo $MyPlaylists->LANG['common_err_tip_invalid_tag'];?>"
		}
	}
});
</script>
<?php
}
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$MyPlaylists->includeFooter();

?>