<?php
set_time_limit(0);
require_once('../common/configs/config.inc.php');
$CFG['benchmark']['is_expose_parse_time'] = false;
$CFG['benchmark']['query_time']['is_expose_query'] = false;
$CFG['benchmark']['query_time']['is_expose'] = false;
$CFG['debug']['is_db_debug_mode'] = false;
$CFG['site']['is_module_page'] = 'music';
$CFG['auth']['is_authenticate'] = 'members';
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/musicUpload.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/email_notify.inc.php';

$CFG['mods']['include_files'][] = 'common/classes/class_MusicActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicUpload.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['mods']['include_files'][] = 'common/classes/php_reader/getMetaData.php';

$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['mods']['is_include_only']['html_header'] = false;
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
class BulkUploadHandler extends MusicUploadLib
	{
		public $music_url = '';
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
				if (!in_array($extern, $this->CFG['admin']['musics']['format_arr']))
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
				if($this->CFG['admin']['musics']['max_size'])
					{
						$max_size = $this->CFG['admin']['musics']['max_size']*1024*1024;
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
$MusicBulkUpload = new BulkUploadHandler();
$MusicBulkUpload->setMediaPath('../');

$MusicBulkUpload->music_uploaded_success = true;
if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

//default form fields and values...
$MusicBulkUpload->resetFieldsArray();
$MusicBulkUpload->setFormField('music_upload_type' ,'MultiUpload');

$MusicBulkUpload->includeAjaxHeader();
//$MusicBulkUpload->HandleError(print_r($_POST)); exit;

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
$upload_name = "music_file";

// Validate the upload
$MusicBulkUpload->chkFileIsNotEmpty($upload_name, $LANG['common_music_err_tip_no_file']) and
$MusicBulkUpload->chkFileNameIsNotEmpty($upload_name, $LANG['common_music_err_tip_required']) and
$MusicBulkUpload->chkValidFileType($upload_name, $LANG['common_music_err_tip_invalid_file_type']) and
$MusicBulkUpload->chkValidFileSize($upload_name, $LANG['common_music_err_tip_invalid_file_size']) and
$MusicBulkUpload->chkErrorInFile($upload_name, $LANG['common_music_err_tip_invalid_file']);

if ($CFG['admin']['musics']['log_upload_error'])
		{
			$MusicBulkUpload->createErrorLogFile('music');
		}
if($MusicBulkUpload->isValidFormInputs())
	{
		$MusicBulkUpload->addNewMusic();
	}
//print_r($_SESSION['new_music_id']);
?>