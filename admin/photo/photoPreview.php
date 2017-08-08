<?php
/**
 * This file is to manage the photos
 *
 * This file is having photoManage class to manage the photos
 *
 *
 * @category	Rayzz
 * @package		Admin
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 *
 **/



 require_once('../../common/configs/config.inc.php');
$CFG['site']['is_module_page']='photo';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header_no_header.php';
$CFG['html']['footer'] = 'admin/html_footer_no_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');


/*
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/admin/photoManage.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
*/



/**
 *
 * @category	rayzz
 * @package		Admin photo
 **/
class photoPreview extends MediaHandler
	{
		public $sql_condition = '';
		public $sql_sort = '';
		public $fields_arr = '';
		public $sql='';

		/**
		 * photoPreview::displayPhoto()
		 *
		 * @param string $photoId
		 * @return
		 */
		public function displayPhoto($photoId = '')
			{
				global $objSmarty;

				$sql  = 'SELECT photo_id, photo_server_url, photo_ext, l_width, l_height FROM '.$this->CFG['db']['tbl']['photo'].' WHERE photo_id = '.$this->dbObj->Param('photo_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs   = $this->dbObj->Execute($stmt, array($photoId));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
				$imgSrc = '';
				if($row = $rs->FetchRow())
				{
					$imgSrc = $this->media_relative_path.$photos_folder.getPhotoName($row['photo_id']).
																	$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'].'?'.time();
					$this->fields_arr['image'] =$imgSrc;
					$this->fields_arr['l_width'] =$row['l_width'];;
					$this->fields_arr['l_height'] =$row['l_height'];;

				//	$objSmarty->assign("photo",$imgSrc);
					return true;
				}
				return false;
			}
	}




$photoPreview = new photoPreview();
$photoPreview->setMediaPath('../../');


$photoPreview->setPageBlockNames(array('view_photo_form'));

//default form fields and values...
$photoPreview->setFormField('photo_id', '');
$photoPreview->setFormField('user_id', '');
$photoPreview->setFormField('user_name', '');
$photoPreview->setFormField('image', '');

$photoPreview->IS_USE_AJAX = true;

$CFG['admin']['light_window_page'] = true;


if($photoPreview->isFormGETed($_REQUEST, 'photo_id'))
	{
		$photoPreview->sanitizeFormInputs($_REQUEST);
		$photo_id = $photoPreview->getFormField('photo_id');
		if($photoPreview->displayPhoto($photo_id))
			{
				$photoPreview->setPageBlockShow('view_photo_form');
			}
		else
			{
				$photoPreview->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$photoPreview->setPageBlockShow('block_msg_form_error');
			}

	}
else
	{
		$photoPreview->setAllPageBlocksHide();
		$photoPreview->setCommonErrorMsg($LANG['common_msg_error_sorry']);
		$photoPreview->setPageBlockShow('block_msg_form_error');
	}

//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$photoPreview->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'photo');
$smartyObj->display('photoPreview.tpl');

$photoPreview->includeFooter();
?>