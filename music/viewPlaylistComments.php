<?php
/**
 * This file is to manage the comment of my playlist
 *
 * This file is having ManageComments class to manage the comment of my playlist
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
				$sql = 'SELECT playlist_comment_id, comment,user_name,playlist_name, v.playlist_id,'.
						'DATE_FORMAT(vc.date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
						'thumb_music_id,thumb_ext,vc.playlist_id FROM '.
						$this->CFG['db']['tbl']['music_playlist_comments']. ' as vc JOIN '.
						$this->CFG['db']['tbl']['users']. ' as u ON u.user_id = vc.comment_user_id JOIN '.
						$this->CFG['db']['tbl']['music_playlist'].' as v ON v.playlist_id = vc.playlist_id '.
						' WHERE playlist_comment_id = '.$this->dbObj->Param('comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$showComments_arr['playlist_name'] = $row['playlist_name'];
				$showComments_arr['comments_by'] = $row['user_name'];
				$showComments_arr['music_path'] = '';
				$showComments_arr['comment_date'] = $row['date_added'];
				$showComments_arr['comments'] = wordWrap_mb_ManualWithSpace($row['comment'], $this->CFG['admin']['musics']['member_music_playlist_comments_length']);
				$showComments_arr['getPlaylistImageDetail'] = $this->getPlaylistImageDetail($row['playlist_id']);// This function return playlist image detail array..//
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
$smartyObj->display('viewPlaylistComments.tpl');
$viewComment->includeFooter();
?>