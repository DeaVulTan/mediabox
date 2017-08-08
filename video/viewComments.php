<?php
/**
 * This file is to manage the comment of my videos
 *
 * This file is having ManageComments class to manage the comment of my videos
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_video.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['html']['header'] = 'general/html_header_no_header.php';
$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='video';
require($CFG['site']['project_path'].'common/application_top.inc.php');
class viewComment extends VideoHandler
	{
		public function showComments()
			{
				$showComments_arr = array();
				$sql = 'SELECT video_comment_id, comment,user_name,video_title,'.
						'DATE_FORMAT(vc.date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
						'video_server_url,embed_video_image_ext,vc.video_id FROM '.
						$this->CFG['db']['tbl']['video_comments']. ' as vc JOIN '.
						$this->CFG['db']['tbl']['users']. ' as u ON u.user_id = vc.comment_user_id JOIN '.
						$this->CFG['db']['tbl']['video'].' as v ON v.video_id = vc.video_id '.
						' WHERE video_comment_id = '.$this->dbObj->Param('comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$showComments_arr['video_title'] = $row['video_title'];
				$showComments_arr['comments_by'] = $row['user_name'];
				if($row['embed_video_image_ext'])
				$showComments_arr['img_src'] = $row['video_server_url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/'.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['thumb_name'].'.'.$row['embed_video_image_ext'];
				else
				$showComments_arr['img_src'] = $row['video_server_url'].$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/'.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['thumb_name'].'.'.$this->CFG['video']['image']['extensions'];

				$showComments_arr['comment_date'] = $row['date_added'];
				$showComments_arr['comments'] = wordWrap_mb_ManualWithSpace($row['comment'], $this->CFG['admin']['videos']['member_video_comments_length']);
				return $showComments_arr;
			}
	}
$viewComment = new viewComment();
$viewComment->setPageBlockNames(array('block_view_commets'));
$viewComment->setFormField('comment_id', '');
$viewComment->sanitizeFormInputs($_REQUEST);
$viewComment->setPageBlockShow('block_view_commets');
if ($viewComment->isShowPageBlock('block_view_commets'))
	{
		$viewComment->announcement_list['showComments'] = $viewComment->showComments();
	}
$viewComment->includeHeader();
setTemplateFolder('members/','video');
$smartyObj->display('viewComments.tpl');
$viewComment->includeFooter();
?>