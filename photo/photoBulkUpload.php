<?php
set_time_limit(0);
ini_set('display_errors', 1);
require_once('../common/configs/config.inc.php');
$CFG['benchmark']['is_expose_parse_time'] = false;
$CFG['benchmark']['query_time']['is_expose_query'] = false;
$CFG['benchmark']['query_time']['is_expose'] = false;
$CFG['debug']['is_db_debug_mode'] = false;
$CFG['site']['is_module_page'] = 'photo';
$CFG['lang']['include_files'][] = 'languages/%s/photo/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/photoUpload.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/getPhotoMetaData.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_CreateTextImage.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_WaterMark.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoMetaData.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoUpload.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';

$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
$CFG['html']['is_use_header'] = false;
$CFG['html']['is_use_footer'] = false;

require($CFG['site']['project_path'].'common/application_top.inc.php');

/**
 * BulkUploadHandler
 *
 * @package
 * @author shankar_044at09
 * @copyright Copyright (c) 2009
 * @version $Id$
 * @access public
 */
class BulkUploadHandler extends PhotoUploadLib
{
	public $photo_url = '';
	public $hidden_arr = array();
	public $fp = false;

	/* Handles the error output. This error message will be sent to the
		uploadSuccess event handler.  The event handler
		will have to check for any error messages and react as needed. */
	function HandleError($message)
	{
		echo $message;
	}

	/**
	 * BulkUploadHandler::chkFileIsNotEmpty()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return void
	 */
	public function chkFileIsNotEmpty($field_name, $err_tip = '')
	{
		if(!isset($_FILES[$field_name]))
		{
			$this->HandleError($err_tip);
			exit(0);
		}
	}

	/**
	 * BulkUploadHandler::chkFileNameIsNotEmpty()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return void
	 */
	public function chkFileNameIsNotEmpty($field_name, $err_tip = '')
	{
		if(!$_FILES[$field_name]['name'])
		{
			$this->HandleError($err_tip);
			exit(0);
		}
	}

	/**
	 * BulkUploadHandler::chkValidFileType()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return void
	 */
	public function chkValidFileType($field_name, $err_tip = '')
	{
		$extern = strtolower(substr($_FILES[$field_name]['name'], strrpos($_FILES[$field_name]['name'], '.')+1));
		if (!in_array($extern, $this->CFG['admin']['photos']['format_arr']))
		{
			$this->HandleError($err_tip);
			exit(0);
		}
	}

	/**
	 * BulkUploadHandler::chkValidFileSize()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return void
	 */
	public function chkValidFileSize($field_name, $err_tip='')
	{
		if($this->CFG['admin']['photos']['max_size'])
		{
			echo $max_size = $this->CFG['admin']['photos']['max_size']*1024*1024;
			if ($_FILES[$field_name]['size'] > $max_size)
			{
				$this->HandleError($err_tip);
				exit(0);
			}
		}
	}


	/**
	 * BulkUploadHandler::chkErrorInFile()
	 *
	 * @param string $field_name
	 * @param string $err_tip
	 * @return  void
	 */
	public function chkErrorInFile($field_name, $err_tip='')
	{
		if($_FILES[$field_name]['error'])
		{
			$this->HandleError($err_tip);
			exit(0);
		}
	}

}
$PhotoBulkUpload = new BulkUploadHandler();
$PhotoBulkUpload->setMediaPath('../');

$PhotoBulkUpload->photo_uploaded_success = true;
if(!chkAllowedModule(array('photo')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

//default form fields and values...
$PhotoBulkUpload->resetFieldsArray();
$PhotoBulkUpload->setFormField('photo_upload_type' ,'MultiUpload');

$PhotoBulkUpload->includeAjaxHeader();
//$PhotoBulkUpload->HandleError(print_r($_POST)); exit;

/*
This is an upload script for SWFUpload that attempts to properly handle uploaded files
in a secure way.

Notes:

	SWFUpload doesn't send a MIME-TYPE. In my opinion this is ok since MIME-TYPE is no better than
	 file extension and is probably worse because it can vary from OS to OS and browser to browser (for the same file).
	 The best thing to do is content sniff the file but this can be resource intensive, is difficult, and can still be fooled or inaccurate.
	 Accepting uploads can never be 100% secure.

	You can't guarantee that SWFUpload is really the source of the upload.  A malicious user
	 will probably be uploading from a tool that sends invalid or false metadata about the file.
	 The script should properly handle this.

	The script should not over-write existing files.

	The script should strip away invalid characters from the file name or reject the file.

	The script should not allow files to be saved that could then be executed on the webserver (such as .php files).
	 To keep things simple we will use an extension whitelist for allowed file extensions.  Which files should be allowed
	 depends on your server configuration. The extension white-list is _not_ tied your SWFUpload file_types setting

	For better security uploaded files should be stored outside the webserver's document root.  Downloaded files
	 should be accessed via a download script that proxies from the file system to the webserver.  This prevents
	 users from executing malicious uploaded files.  It also gives the developer control over the outgoing mime-type,
	 access restrictions, etc.  This, however, is outside the scope of this script.

	SWFUpload sends each file as a separate POST rather than several files in a single post. This is a better
	 method in my opinions since it better handles file size limits, e.g., if post_max_size is 100 MB and I post two 60 MB files then
	 the post would fail (2x60MB = 120MB). In SWFupload each 60 MB is posted as separate post and we stay within the limits. This
	 also simplifies the upload script since we only have to handle a single file.

	The script should properly handle situations where the post was too large or the posted file is larger than
	 our defined max.  These values are not tied to your SWFUpload file_size_limit setting.

*/
//POST NAME
$upload_name = "photo_file";

// Validate the upload
$PhotoBulkUpload->chkFileIsNotEmpty($upload_name, $LANG['common_photo_err_tip_no_file']) and
$PhotoBulkUpload->chkFileNameIsNotEmpty($upload_name, $LANG['common_photo_err_tip_required']) and
$PhotoBulkUpload->chkValidFileType($upload_name, $LANG['common_photo_err_tip_invalid_file_type']) and
$PhotoBulkUpload->chkValidFileSize($upload_name, $LANG['common_photo_err_tip_invalid_file_size']) and
$PhotoBulkUpload->chkErrorInFile($upload_name, $LANG['common_photo_err_tip_invalid_file']);


if ($CFG['admin']['photos']['log_upload_error'])
{
	$PhotoBulkUpload->createErrorLogFile('photo');
}
if($PhotoBulkUpload->isValidFormInputs())
{
	$PhotoBulkUpload->addNewPhoto();
}
//print_r($_SESSION['new_photo_id']);
?>