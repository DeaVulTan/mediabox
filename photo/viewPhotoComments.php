<?php
/**
 * This file is to manage the comment of photo
 *
 * This file is having ManageComments class to manage the comment of photo
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 **/
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_photo.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/common.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['html']['header'] = 'general/html_header_no_header.php';
$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='photo';
$CFG['auth']['is_authenticate'] = 'members';
require($CFG['site']['project_path'].'common/application_top.inc.php');
class viewComment extends PhotoHandler
	{
		public function showComments()
			{
				$showComments_arr = array();
				$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
				$sql = 'SELECT pc.photo_comment_id, pc.comment, u.user_name,p.photo_title, p.photo_ext, p.photo_server_url, p.t_width, p.t_height, '.
						'DATE_FORMAT(pc.date_added,\''.$this->CFG['format']['date'].'\') as date_added, pfs.file_name, '.
						'pc.photo_id FROM '.$this->CFG['db']['tbl']['photo_comments']. ' as pc JOIN '.
						$this->CFG['db']['tbl']['users']. ' as u ON u.user_id = pc.comment_user_id JOIN '.
						$this->CFG['db']['tbl']['photo'].' as p ON p.photo_id = pc.photo_id JOIN '.
						$this->CFG['db']['tbl']['photo_files_settings'].' AS pfs ON pfs.photo_file_id = p.photo_file_name_id '.
						'WHERE photo_comment_id = '.$this->dbObj->Param('comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$showComments_arr['photo_title'] = $row['photo_title'];
				$showComments_arr['comments_by'] = $row['user_name'];
				$showComments_arr['photo_path'] = '';
				$showComments_arr['photo_disp'] = '';
				if($row['photo_ext'] != '')
					{
						$showComments_arr['photo_path'] = $row['photo_server_url'].$photos_folder.getPhotoName($row['photo_id']).$this->CFG['admin']['photos']['thumb_name'].'.'.$row['photo_ext'];
						$showComments_arr['photo_disp'] = DISP_IMAGE($this->CFG['admin']['photos']['thumb_width'], $this->CFG['admin']['photos']['thumb_height'], $row['t_width'], $row['t_height']);
					}
				$showComments_arr['comment_date'] = $row['date_added'];
				$showComments_arr['comments'] = $row['comment'];
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
setTemplateFolder('members/','photo');
$smartyObj->display('viewPhotoComments.tpl');
$viewComment->includeFooter();
?>