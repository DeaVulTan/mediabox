<?php
/**
 * This file is to manage the comment of my music
 *
 * This file is having ManageComments class to manage the comment of my music
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_music.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['html']['header'] = 'general/html_header_no_header.php';
$CFG['html']['footer'] = 'general/html_footer_no_footer.php';

$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='music';
$CFG['auth']['is_authenticate'] = 'members';
require($CFG['site']['project_path'].'common/application_top.inc.php');
class viewComment extends MusicHandler
	{
		public function showComments()
			{
				$showComments_arr = array();
				$musics_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' .
									$this->CFG['admin']['musics']['thumbnail_folder'] . '/';
				$sql = 'SELECT vc.music_comment_id, vc.comment, u.user_name,v.music_title, v.music_thumb_ext, v.music_server_url, v.thumb_width, v.thumb_height, '.
						'DATE_FORMAT(vc.date_added,\''.$this->CFG['format']['date'].'\') as date_added, mfs.file_name, '.
						'vc.music_id FROM '.$this->CFG['db']['tbl']['music_comments']. ' as vc JOIN '.
						$this->CFG['db']['tbl']['users']. ' as u ON u.user_id = vc.comment_user_id JOIN '.
						$this->CFG['db']['tbl']['music'].' as v ON v.music_id = vc.music_id JOIN '.
						$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = v.thumb_name_id '.
						'WHERE music_comment_id = '.$this->dbObj->Param('comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$showComments_arr['music_title'] = $row['music_title'];
				$showComments_arr['comments_by'] = $row['user_name'];
				$showComments_arr['music_path'] = '';
				$showComments_arr['music_disp'] = '';
				if($row['music_thumb_ext'] != '')
					{
						$showComments_arr['music_path'] = $row['music_server_url'].$musics_folder.getMusicImageName($row['music_id'], $row['file_name']).$this->CFG['admin']['musics']['thumb_name'].'.'.$row['music_thumb_ext'];
						$showComments_arr['music_disp'] = DISP_IMAGE($this->CFG['admin']['musics']['thumb_width'], $this->CFG['admin']['musics']['thumb_height'], $row['thumb_width'], $row['thumb_height']);
					}
				$showComments_arr['comment_date'] = $row['date_added'];
				$showComments_arr['comments'] = wordWrap_mb_ManualWithSpace($row['comment'], $this->CFG['admin']['musics']['member_music_comments_length']);
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
		$viewComment->block_view_commets['showComments'] = $viewComment->showComments();
	}
$viewComment->includeHeader();
setTemplateFolder('members/','music');
$smartyObj->display('viewMusicComments.tpl');
$viewComment->includeFooter();
?>