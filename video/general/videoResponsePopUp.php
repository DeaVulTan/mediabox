<?php
/**
* >>> mature warning functionalites provided below
*	1. If admin set "Display adult content to members" as "No"
*		>>> adult user can view the content
*		>>> non adult user can not view the content
*		>>> adult user can turn off / turn on the mature warning
*
*	2. If admin set "Display adult content to members" as "Yes"
*		>>> adult user can view the content with confirmation
*		>>> non adult user can view the content
*		>>> adult and non adult user can turn off / turn on the mature warning
*
*	2. If admin set "Display adult content to members" as "Confirmation"
*		>>> adult user can view the content with confirmation
*		>>> non adult user can view the content with confirmation
*		>>> adult and non adult user can turn off / turn on the mature warning
**/
/**
 * ViewVideo
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: viewVideo.php 2986 2006-12-29 05:25:10Z selvaraj_35ag05 $
 * @access public
 **/
class ViewVideo extends MediaHandler
	{
		public $enabled_edit_fields = array();
		public $captchaText = '';


		public function getExistingRecords($sql)
			{
				$stmt = $this->dbObj->Prepare($sql);
				//echo $sql.'<br />';
				$rs = $this->dbObj->Execute($stmt);
				 if (!$rs)
				   trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				return 	$row['count'];
			}

		public function processStartValue($pg, $totalVideoCount=0)
			{
				$vdebug = true;
				$videoLimit=$this->CFG['admin']['videos']['total_response_video'];
				$videoIncrement=$this->CFG['admin']['videos']['total_response_video'];

				if($pg=='top')
					{
						if (!isset($_SESSION['vTopStart_res']))
					    	$_SESSION['vTopStart_res'] = 0;

						if ($this->isPageGETed($_POST, 'vTopLeft_res'))
						    {
								$inc = ($_SESSION['vTopStart_res'] > 0)?$videoIncrement:0;
								$_SESSION['vTopStart_res'] -= $inc;
						    }
						if ($this->isPageGETed($_POST, 'vTopRight_res'))
						    {
								$inc = ($_SESSION['vTopStart_res'] < $totalVideoCount)?$videoIncrement:0;
								$_SESSION['vTopStart_res'] += $inc;
						    }
						return $_SESSION['vTopStart_res'];
					}

				if($pg=='user')
					{
						if (!isset($_SESSION['vUserStart_res']))
					    	$_SESSION['vUserStart_res'] = 0;

						if ($this->isPageGETed($_POST, 'vUserLeft_res'))
						    {
								$inc = ($_SESSION['vUserStart_res'] > 0)?$videoIncrement:0;
								$_SESSION['vUserStart_res'] -= $inc;
						    }
						if ($this->isPageGETed($_POST, 'vUserRight_res'))
						    {
								$inc = ($_SESSION['vUserStart_res'] < $totalVideoCount)?$videoIncrement:0;
								$_SESSION['vUserStart_res'] += $inc;
						    }
						return $_SESSION['vUserStart_res'];
					}

				if($pg=='tag')
					{
						if (!isset($_SESSION['vTagStart_res']))
					    	$_SESSION['vTagStart_res'] = 0;

						if ($this->isPageGETed($_POST, 'vTagLeft_res'))
						    {
								$inc = ($_SESSION['vTagStart_res'] > 0)?$videoIncrement:0;
								$_SESSION['vTagStart_res'] -= $inc;
						    }
						if ($this->isPageGETed($_POST, 'vTagRight_res'))
						    {
								$inc = ($_SESSION['vTagStart_res'] < $totalVideoCount)?$videoIncrement:0;
								//echo $totalVideoCount.'------------'.$inc;
								$_SESSION['vTagStart_res'] += $inc;
						    }
						return $_SESSION['vTagStart_res'];
					}

			}


		public function getQuickCaptureForm()
			{
?>
			<form name="quickCaptureForm" id="quickCaptureform" method="post" action="<?php echo getUrl('videouploadpopup', '','','members','video');?>">
			<input type="hidden" name="use_vid" value="<?php echo $this->fields_arr['video_id']; ?>" />
			<div class="clsNoVideo">
					<p><?php echo $this->LANG['use_this_link_video_response']; ?></p>
					<p><input type="submit" name="video_upload_submit" id="video_upload_submit" value="<?php echo $this->LANG['upload_capture_video']; ?>" /></p>
			</div>
			</form>
<?php
			}

		public function populateRleatedVideo($pg = 'tag', $start=0)
			{
				$default_fields = ' TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, v.video_id, v.user_id, v.video_title, v.video_caption,'.
								  ' TIMEDIFF(NOW(), v.date_added) as date_added, v.video_server_url, v.total_views,'.
								  ' v.s_width, v.s_height, v.video_ext, v.video_tags';
				$add_fields = '';
				$order_by = 'v.video_id DESC';
				$videos_frm=$this->CFG['db']['tbl']['video'].' AS v';
				switch($pg)
					{
						case 'top'://Qucik Capture
							$this->getQuickCaptureForm();
							return;
							break;

						case 'user'://My Videos
							$sql_condition = 'v.video_id!=\''.addslashes($this->fields_arr['video_id']).'\''.
										' AND v.user_id=\''.$this->CFG['user']['user_id'].'\' AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
										' AND (v.user_id = '.$this->CFG['user']['user_id'].' )';
							$more_link = getUrl('videolist','?pg=uservideolist&user_id='.$this->fields_arr['user_id'], 'uservideolist/?user_id='.$this->fields_arr['user_id'],'','video');
							break;

						case 'tag'://My Favourites
							$video_tags = $this->fields_arr['video_tags'];

							$videos_frm=$this->CFG['db']['tbl']['video_favorite'].' as f LEFT JOIN '.$this->CFG['db']['tbl']['video'].' as v ON f.video_id=v.video_id ';

							$sql_condition='v.video_id!=\''.addslashes($this->fields_arr['video_id']).'\''.
										' AND f.user_id='.$this->CFG['user']['user_id'].$this->getAdultQuery('v.').
							' AND v.video_status=\'Ok\' AND v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.');

							$add_fields = '';
							$order_by = 'v.video_id DESC';
							break;
					}

				$sql_condition.= ' AND v.video_id NOT IN ( SELECT video_responses_video_id FROM '. $this->CFG['db']['tbl']['video_responses'].' AS vr where vr.video_id=\''.addslashes($this->fields_arr['video_id']).'\' ) ';

				$sql_exising='SELECT count(1) count FROM '.$videos_frm.
						' WHERE '.$sql_condition.' ';
				$existing_total_records=$this->getExistingRecords($sql_exising);
				$process_start=$this->processStartValue($pg, $existing_total_records);

				$sql = 'SELECT '.$default_fields.$add_fields.' FROM '.$videos_frm.
						' WHERE '.$sql_condition.' ORDER BY '.$order_by.
						' LIMIT '.$process_start.', '.$this->CFG['admin']['videos']['total_response_video'];

				//echo $sql;

				$leftButtonClass = 'disabledPrevButton';
				$rightButtonClass = 'disabledNextButton';
				$leftButtonExist=false;
				$rightButtonExists=false;
				$nextSetAvailable = ($existing_total_records > ($process_start + $this->CFG['admin']['videos']['total_response_video']));
				if ($nextSetAvailable)
					{
			        	$rightButtonClass = 'enabledNextButton';
						$rightButtonExists=true;
					}
				if ($process_start > 0)
					{
						$leftButtonExist=true;
			        	$leftButtonClass = 'enabledPrevButton';
					}

					$return['leftButtonExist']=$leftButtonExist;
					$return['leftButtonClass']=$leftButtonClass;
					$return['rightButtonExists']=$rightButtonExists;
					$return['rightButtonClass']=$rightButtonClass;

				//------ Next and Prev Links--------------//
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$total_records = $rs->PO_RecordCount();
				$this->relatedViewVideoUrl=getUrl('viewvideo','?video_id='.$this->fields_arr['video_id'].'&video_title='.$this->fields_arr['video_title'], $this->fields_arr['video_id'].'/'.$this->fields_arr['video_title'].'/','','video');
				$return['total_records']=0;
				if ($total_records)
				    {
						$return['total_records']=1;
						$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
						$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type', 'sex');
						$return['pg']=$pg;
						$inc=0;
						while($row = $rs->FetchRow())
							{
								$return['display'][$inc]['record']=$row;
								if(!isset($this->UserDetails[$row['user_id']]))
									$this->getUserDetail('user_id',$row['user_id'], 'user_name');
								$return['display'][$inc]['name'] = $this->getUserDetail('user_id',$row['user_id'], 'user_name');
								$return['display'][$inc]['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';
								$return['display'][$inc]['videoLink']=getUrl('viewvideo','?video_id='.$row['video_id'].'&title='.$this->changeTitle($row['video_title']).'&vpkey='.$this->fields_arr['vpkey'], $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/?vpkey='.$this->fields_arr['vpkey'],'','video');
								$return['display'][$inc]['imageSrc']=$row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
								$return['display'][$inc]['video_title']= wordWrap_mb_ManualWithSpace($row['video_title'], $this->CFG['admin']['videos']['responsevideo_title_list_length'],$this->CFG['admin']['videos']['responsevideo_title_list_totallength']);
								$return['display'][$inc]['small_width']=$row['s_width'];
								$return['display'][$inc]['small_height']=$row['s_height'];
								$return['display'][$inc]['disp_image']=DISP_IMAGE(93,70, $row['s_width'], $row['s_height']);
								$inc++;
							}

					}
					return $return;
			}


		/**
		 * ViewVideo::chkValidVideoId()
		 *
		 * @return
		 **/
		public function chkValidVideoId()
			{
				$videoId = $this->fields_arr['video_id'];
				$videoId = is_numeric($videoId)?$videoId:0;
				if (!$videoId)
				    {
				        return false;
				    }
				$userId = $this->CFG['user']['user_id'];

				$condition = 'p.video_status=\'Ok\' AND p.video_id='.$this->dbObj->Param($videoId).
							' AND (p.user_id = '.$this->dbObj->Param($userId).' OR'.
							' p.video_access_type = \'Public\''.$this->getAdditionalQuery('p.').')';

				$sql = 'SELECT p.total_favorites,p.total_views, p.video_server_url, p.video_title, p.total_comments, p.video_album_id, p.total_downloads,'.
						' p.video_ext, p.allow_comments,p.video_category_id,p.video_tags,p.allow_embed,'.
						' p.allow_ratings, p.rating_total, p.rating_count, p.user_id, p.flagged_status, p.video_caption,'.
						' p.video_title, DATE_FORMAT(date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
						' p.video_server_url, p.l_width, p.l_height, s_width, s_height FROM '.$this->CFG['db']['tbl']['video'].' as p'.
						' WHERE '.$condition.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($videoId, $userId));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$fields_list = array('user_name', 'first_name', 'last_name');
				if($row = $rs->FetchRow())
					{
						if(!isset($this->UserDetails[$row['user_id']]))
						$this->getUserDetail('user_id',$row['user_id'], 'user_name');

						$name = $this->getUserDetail('user_id',$row['user_id'], 'user_name');

						$this->fields_arr['video_title'] = $row['video_title'];
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['allow_comments'] = $row['allow_comments'];
						$this->fields_arr['allow_ratings'] = $row['allow_ratings'];
						$this->fields_arr['allow_embed'] = $row['allow_embed'];
						$this->fields_arr['video_ext'] = $row['video_ext'];
						$this->fields_arr['video_server_url'] = $row['video_server_url'];
						$this->fields_arr['l_width'] = $row['l_width'];
						$this->fields_arr['l_height'] = $row['l_height'];
						$this->fields_arr['video_title'] = $row['video_title'];
						$this->fields_arr['video_caption'] = $row['video_caption'];
						$this->fields_arr['date_added'] = $row['date_added'];
						$this->fields_arr['user_name'] = $name;
						$this->fields_arr['rating_total'] = $row['rating_total'];
						$this->fields_arr['rating_count'] = $row['rating_count'];
						$this->fields_arr['flagged_status'] = $row['flagged_status'];
						$this->fields_arr['comments'] = $row['total_comments']?$row['total_comments']:0;
						$this->fields_arr['video_album_id'] = $row['video_album_id'];
						$this->fields_arr['total_downloads'] = $row['total_downloads'];

						$this->fields_arr['favorited'] = $row['total_favorites'];
						$this->fields_arr['total_views'] = $row['total_views'];
						$this->fields_arr['total_comments'] = $row['total_comments'];
						$this->fields_arr['video_category_id'] = $row['video_category_id'];
						$this->fields_arr['video_tags'] = $row['video_tags'];
						$this->fields_arr['name'] = $name;
						$this->fields_arr['s_width'] = $row['s_width'];
						$this->fields_arr['s_height'] = $row['s_height'];

						$this->fields_arr['video_category_type'] = $this->getCategoryType($row['video_category_id']);
						return true;
					}
				return false;
			}

		public function getCategoryType($category_id)
			{
				$sql = 'SELECT video_category_type FROM '.$this->CFG['db']['tbl']['video_category'].
						' WHERE video_category_id='.$this->dbObj->Param('video_category_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$category_type = 'General';
				if($row = $rs->FetchRow())
					{
						$category_type = $row['video_category_type'];
					}
				return $category_type;
			}

		public function getVideoCategoryType($video_id)
			{
				$sql = 'SELECT video_category_id FROM '.$this->CFG['db']['tbl']['video'].' WHERE'.
						' video_id='.$this->dbObj->Param('video_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$type = 'General';
				if($row = $rs->FetchRow())
					{
						$sql = 'SELECT video_category_type FROM '.$this->CFG['db']['tbl']['video_category'].
								' WHERE video_category_id='.$this->dbObj->Param('video_category_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($row['video_category_id']));
						    if (!$rs)
							   trigger_db_error($this->dbObj);

						if($row = $rs->FetchRow())
							{
								$type = $row['video_category_type'];
							}
					}
				return $type;
			}

		public function getRandVideo($video_id)
			{
				$userId = $this->CFG['user']['user_id'];
				$condition = 'p.video_id=\''.$video_id.'\' AND p.video_status=\'Ok\''.' AND (p.user_id = '.$this->dbObj->Param($userId).' OR'.
							' p.video_access_type = \'Public\')';
				$sql = 'SELECT video_id,video_title,is_external_embed_video,video_external_embed_code FROM '.$this->CFG['db']['tbl']['video'].' as p'.
						' WHERE '.$condition.' ORDER BY video_id LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($userId));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/';
						$flv_player_url = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/flash/video/flvplayers/mini_flvplayer.swf';
						$arguments_play = 'pg=smallvideo_'.$row['video_id'].'_no_'.getRefererForAffiliate();
						$configXmlcode_url = $this->CFG['site']['video_url'].'videoMiniPlayerConfigXmlCode.php?';
						$embed_code=$row['video_external_embed_code'];
						$patterns_width = '/width=&quot;([0-9]+)&quot;/';
						$patterns_height = '/height=&quot;([0-9]+)&quot;/';
						$replacements_width= 'width=280';
						$replacements_height= 'height=240';
						$embed_code=preg_replace($patterns_width, $replacements_width, $embed_code);
						$embed_code=preg_replace($patterns_height, $replacements_height, $embed_code);


						$arguments_embed = 'pg=video_'.$video_id.'_no_0&ext_site=';
?>
				<div class="clsPreviewResponsePlayer"><div id="selVideoPlayer23">
				<h2><?php echo wordWrap_mb_ManualWithSpace($row['video_title'], 20, 30); ?></h2>
				<?if($row['is_external_embed_video']=='No'){?>
				<embed src="<?php echo $flv_player_url;?>" FlashVars="config=<?php echo $configXmlcode_url.$arguments_embed;?>" quality="high" bgcolor="#000000" width="320" height="240" name="flvplayer" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" <?php echo $this->CFG['admin']['embed_code']['additional_fields'];?> />
				<?}else
					echo html_entity_decode($embed_code);
				?>
				<div class="clsOverflow clsMarginTop5"><div class="clsSubmitLeft"><div class="clsSubmitRight">
				  <input type="submit" name="select_response_video[<?php echo $video_id; ?>]" id="select_video" value="<?php echo $this->LANG['select_this_video']; ?>" />
				</div></div><div class="clsCancelLeft"><div class="clsCancelRight">
				  <input type="button" value="<?php echo $this->LANG['close'];?>" onclick="removeMiniPlayer()" />
				</div></div></div>
				</div>

<?php
					}
					exit;
			}

		public function displayVideoDetails()
			{
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				$return['videoLink']=getUrl('viewvideo','?video_id='.$this->fields_arr['video_id'].'&title='.$this->changeTitle($this->fields_arr['video_title']), $this->fields_arr['video_id'].'/'.$this->changeTitle($this->fields_arr['video_title']).'/','','video');
				$return['imageSrc']=$this->fields_arr['video_server_url'].$thumbnail_folder.getVideoImageName($this->fields_arr['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
				$return['disp_image']=DISP_IMAGE(93,70, $this->fields_arr['s_width'], $this->fields_arr['s_height']);
				return $return;
			}

	}
//<<<<<-------------- Class ViewVideo begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ViewVideo = new ViewVideo();

if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$ViewVideo->setPageBlockNames(array('msg_form_error', 'videos_form', 'delete_confirm_form', 'get_code_form',
									'confirmation_flagged_form', 'add_comments', 'add_reply', 'edit_comment',
									'update_comment', 'rating_image_form', 'add_flag_list', 'add_fovorite_list',
									'confirmation_adult_form', 'videoMainBlock'));


//default form fields and values...
$ViewVideo->setFormField('video_id', '');
$ViewVideo->setFormField('total_downloads', '0');
$ViewVideo->setFormField('vpkey', '');
$ViewVideo->setFormField('action', '');
$ViewVideo->setFormField('comment_id', '');
$ViewVideo->setFormField('action', '');
$ViewVideo->setFormField('video_code', '');
$ViewVideo->setFormField('video_title', '');
$ViewVideo->setFormField('user_name', '');
$ViewVideo->setFormField('user_id', '');
$ViewVideo->setFormField('album_id', '');
//for ajax
$ViewVideo->setFormField('f',0);
$ViewVideo->setFormField('show','1');
$ViewVideo->setFormField('comment_id',0);
$ViewVideo->setFormField('type','');
$ViewVideo->setFormField('ajax_page','');
$ViewVideo->setFormField('paging','');
$ViewVideo->setFormField('rate', '');
$ViewVideo->setFormField('flag', '');
$ViewVideo->setFormField('page', '');
$ViewVideo->setFormField('favorite_id', '');
$ViewVideo->setFormField('video_tags', '');

$ViewVideo->sanitizeFormInputs($_REQUEST);
if($ViewVideo->chkValidVideoId())
	{
		$ViewVideo->setPageBlockShow('videoMainBlock');
	}
else
	{
		$ViewVideo->setPageBlockShow('msg_form_error');
	}

if(isAjax())
	{
		$ViewVideo->includeAjaxHeaderSessionCheck();
		if ($ViewVideo->isPageGETed($_POST, 'vUserFetch_res'))
		    {
				$ViewVideo->userRelatedVideo=$ViewVideo->populateRleatedVideo('user');
				setTemplateFolder('members/','video');
				$smartyObj->display('selUserContent_res.tpl');
				$ViewVideo->includeAjaxFooter();
				die();
		    }
		if ($ViewVideo->isPageGETed($_POST, 'vTagFetch_res'))
		    {
				$ViewVideo->tagRelatedVideo=$ViewVideo->populateRleatedVideo('tag');
				setTemplateFolder('members/','video');
				$smartyObj->display('selRelatedContent_res.tpl');
				$ViewVideo->includeAjaxFooter();
				die();
			}

		/*
		if ($ViewVideo->isPageGETed($_POST, 'vTopFetch_res'))
		    {
				$ViewVideo->populateRleatedVideo('top');
				setTemplateFolder('members/','video');
				$smartyObj->display('videoResponsePopUp.tpl');
				$ViewVideo->includeAjaxFooter();
				die();

			}
		if ($ViewVideo->isPageGETed($_POST, 'vRespFetch_res'))
		    {
				$ViewVideo->populateVideoCommentsOfThisVideo();
				setTemplateFolder('members/','video');
				$smartyObj->display('videoResponsePopUp.tpl');
				$ViewVideo->includeAjaxFooter();
				die();
			}
		*/
	}
if ($ViewVideo->isPageGETed($_GET, 'process_slide'))
{

	$ViewVideo->includeAjaxHeader();
	$ViewVideo->getRandVideo($ViewVideo->getFormField('video_id'));
	setTemplateFolder('members/','video');
	if($_POST['curr_slide']=='user')
		{
			$ViewVideo->userRelatedVideo=array();
			$ViewVideo->userRelatedVideo['total_records'] = 0;
			$smartyObj->display('selUserContent_res.tpl');
		}
	else
		{
			$ViewVideo->tagRelatedVideo=array();
			$ViewVideo->tagRelatedVideo['total_records'] = 0;
			$smartyObj->display('selRelatedContent_res.tpl');
		}
	$ViewVideo->includeAjaxFooter();
	die();
}
$_SESSION['vUserStart_res'] = 0;
$_SESSION['vTagStart_res'] = 0;
$_SESSION['vTopStart_res'] = 0;
$_SESSION['vRespStart'] = 0;
$ViewVideo->video_title_wordWrap = wordWrap_mb_ManualWithSpace($ViewVideo->getFormField('video_title'), $CFG['admin']['videos']['responsevideo_videoHeading_list_length'],$CFG['admin']['videos']['responsevideo_videoHeading_list_totallength']);

//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
/*$CFG['html']['meta']['keywords'] = str_replace('{default_tags}', $CFG['html']['meta']['keywords'], $LANG['photo_video_group_meta_tag']);
$CFG['html']['meta']['keywords'] = str_replace('{tags}', $ViewVideo->getFormField('video_tags'), $CFG['html']['meta']['keywords']);
$CFG['site']['title'] = str_replace('{site_title}', $CFG['site']['title'], $LANG['photo_video_group_top_title']);
$CFG['site']['title'] = str_replace('{title}', $ViewVideo->getFormField('video_title'), $CFG['site']['title']);
$CFG['site']['title'] = str_replace('{module}', $LANG['window_title_video'], $CFG['site']['title']);
*/
if(!isAjax())
	{

?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/functions.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/AG_ajax_html.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['video_url'];?>js/viewVideo.js"></script>
<script language="javascript">
var vLoader_res = 'loaderVideos_res';
var homeUrl_res = '<?php echo $CFG['site']['video_url'].'videoResponsePopUp.php?video_id='.$ViewVideo->getFormField('video_id');?>';
var disPrevButton = 'disabledPrevButton';
var disNextButton = 'disabledNextButton';
var pars= 'vLeft=&vFetch=';
var curr_slide_pg='';
var block_arr= new Array('selMsgConfirm', 'selUploadingDialog', 'slideShowBlock', 'selEditPhotoComments');

function popupWindow(url){
		 window.open (url, "","status=0,toolbar=0,resizable=0,scrollbars=1");
		 return false;
	}
	function setClass(li_id, li_class){
		document.getElementById(li_id).setAttribute('className',li_class);
		document.getElementById(li_id).setAttribute('class',li_class);
	}
	function showDiv(element){
		if(obj = document.getElementById(element))
			obj.style.display = '';

	}
	function hideDiv(element){
		if(obj = document.getElementById(element))
			obj.style.display = 'none';
	}

function moveVideoSetToLeft_res(buttonObj, pg)
{
	if(pg=='tag')
		var pars= 'vTagLeft_res=&vTagFetch_res=';
	if(pg=='user')
		var pars= 'vUserLeft_res=&vUserFetch_res=';
	if(pg=='top')
		var pars= 'vTopLeft_res=&vTopFetch_res=';
	if(pg=='resp')
		var pars= 'vRespLeft=&vRespFetch_res=';

	if(buttonObj.className ==disPrevButton)
	{
		return false;
	}
	videoSlider_res(pars, pg);
}
function moveVideoSetToRight_res(buttonObj, pg){

	//alert('RIGHT----'+pg);
	if(pg=='tag')
		var pars= 'vTagRight_res=&vTagFetch_res=';
	if(pg=='user')
		var pars= 'vUserRight_res=&vUserFetch_res=';
	if(pg=='top')
		var pars= 'vTopRight_res=&vTopFetch_res=';
	if(pg=='resp')
		var pars= 'vRespRight=&vRespFetch_res=';

	if(buttonObj.className ==disNextButton){
		return false;
	}
	videoSlider_res(pars, pg);
}

function videoSlideShow_res(video_id, pg)
	{


		/*var a= new Ajax.Updater('slideShowBlock', homeUrl_res,
		{
		method:'post',
		parameters:'?ajax_page=1&process_slide=1&video_id='+video_id,
		asynchronous:true,
		evalScripts:true,
		onComplete: slideShowProcess_res
		});
		alert($('slideShowBlock').innerHTML);
		return;*/

		//ConfirmationBlock('anchor','slideShowBlock',300,200);
		curr_slide_pg=pg;
		var pars = 'ajax_page=1&process_slide=1&video_id='+video_id;
		$Jq.ajax({
			type: "GET",
			url: homeUrl_res,
			data: pars,
			success: slideShowProcess_res
		 });
		return;
	}

function slideShowProcess_res(resp)
	{

		data = unescape(resp);
		$Jq('#slideShowBlock_'+curr_slide_pg).html(data);
		//ConfirmationBlock_res('anchor','slideShowBlock_'+curr_slide_pg,100,100);
	}

function videoSlider_res(pars, pg)
	{
		if(pg=='resp')
			{
				showDiv('loaderRespVideos');
				var pars = '&ajax_page=1&video_id=<?php echo $ViewVideo->getFormField('video_id'); ?>';
				$Jq.ajax({
					type: "GET",
					url: homeUrl_res,
					data: pars,
					success: refreshVideoBlockResp_res
				 });
				return;
			}
		showDiv('loaderVideos_res');
		if(pg=='tag')
		{
				var pars = '&ajax_page=1&video_id=<?php echo $ViewVideo->getFormField('video_id'); ?>&video_tags=<?php echo $ViewVideo->getFormField('video_tags') ?>';
				$Jq.ajax({
					type: "GET",
					url: homeUrl_res,
					data: pars,
					success: refreshVideoBlockTag_res
				 });
		}
		if(pg=='user')
		{
          		var pars = '&ajax_page=1&video_id=<?php echo $ViewVideo->getFormField('video_id'); ?>&user_id=<?php echo $ViewVideo->getFormField('user_id') ?>';
				$Jq.ajax({
					type: "GET",
					url: homeUrl_res,
					data: pars,
					success: refreshVideoBlockUser_res
				 });


		}
		if(pg=='top')
		{

				var pars = '&ajax_page=1&video_id=<?php echo $ViewVideo->getFormField('video_id'); ?>';
				$Jq.ajax({
					type: "GET",
					url: homeUrl_res,
					data: pars,
					success: refreshVideoBlockTop_res
				 });
		}
	}

refreshVideoBlockTag_res = function(resp)
	{
		data = unescape(resp);
		$Jq('#selRelatedContent_res').html(data);
		hideDiv('loaderVideos_res');
		//$('loaderVideos_res').display='none';
	}

refreshVideoBlockTop_res = function(resp)
	{
		data = unescape(resp);
		$Jq('#selTopContent_res').html(data);
		hideDiv('loaderVideos_res');
	}
refreshVideoBlockUser_res = function(resp)
	{
		data = unescape(resp);
		$Jq('#selUserContent_res').html(data);
		//$('selUserContent_res').update(resp.responseText);
		hideDiv('loaderVideos_res');
	}

refreshVideoBlockResp_res = function(resp)
	{
		data = unescape(resp);
		$Jq('#selUserContent_resResp').html(data);
		//$('selUserContent_res').update(resp.responseText);
		hideDiv('loaderRespVideos');
	}

//Display confirmation Block
//place, block, add_top_position, add_left_position --- optional
var ConfirmationBlock_res = function(){
	var obj, inc, form_field;
	//hideAllBlocks();

	var place = arguments[0];
	var block = arguments[1];
	var add_left_position = arguments[2];
	var add_top_position = arguments[3];
	if(fromObj = $(block))
		changePosition(fromObj, $(place), add_top_position, add_left_position);
	return false;
}
</script>
<?php
    	}
//<<<<<-------------------- Page block templates ends -------------------//
$ViewVideo->videoDetail=$ViewVideo->displayVideoDetails();
$ViewVideo->quickCaptureUrl=getUrl('videouploadpopup','','','','video');
if(isAjax())
	{
		$ViewVideo->tagRelatedVideo=$ViewVideo->populateRleatedVideo('tag');
		$ViewVideo->userRelatedVideo=$ViewVideo->populateRleatedVideo('user');
		setTemplateFolder('members/','video');
		$smartyObj->display('videoResponsePopUp.tpl');
		$ViewVideo->includeAjaxFooter();
	}
?>