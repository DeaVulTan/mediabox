<?php
require_once('../common/configs/config.inc.php');
populateConfigData('config_data_discussions');

$CFG['admin']['attachments']['image_formats'] = array('jpg', 'gif', 'png', 'bmp', 'jpeg');
// Code for Session Cookie workaround
	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	} else if (isset($_GET["PHPSESSID"])) {
		session_id($_GET["PHPSESSID"]);
	}

	session_start();

// Check post_max_size
	$POST_MAX_SIZE = ini_get('post_max_size');
	$unit = strtoupper(substr($POST_MAX_SIZE, -1));
	$multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

	if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
		header("HTTP/1.1 500 Internal Server Error"); // This will trigger an uploadError event in SWFUpload
		echo "POST exceeded maximum allowed size.";
		exit(0);
	}

// Settings
	//$save_path = getcwd() . "/uploads/";				// The path were we will save the file (getcwd() may not be reliable and should be tested in your environment)
	$save_path = '../'.$CFG['admin']['index']['home_module']."/files/uploads/";
	$display_path = $CFG['admin']['index']['home_module']."/files/uploads/";
	$upload_name = "Filedata";
	$max_file_size_in_bytes = 2147483647;				// 2GB in bytes
	$extension_whitelist = $CFG['admin']['attachments']['format_arr'];	// Allowed file extensions
	$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';				// Characters allowed in the file name (in a Regular Expression format)

	$extern = strtolower(substr($_FILES[$upload_name]["name"], strrpos($_FILES[$upload_name]["name"], '.')+1));


// Other variables
	$MAX_FILENAME_LENGTH = 260;
	$file_name = "";
	$file_extension = "";
	$uploadErrors = array(
        0=>"There is no error, the file uploaded with success",
        1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
        2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        3=>"The uploaded file was only partially uploaded",
        4=>"No file was uploaded",
        6=>"Missing a temporary folder"
	);


// Validate the upload
	if (!isset($_FILES[$upload_name])) {
		HandleError("No upload found in \$_FILES for " . $upload_name);
		exit(0);
	} else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
		HandleError($uploadErrors[$_FILES[$upload_name]["error"]]);
		exit(0);
	} else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
		HandleError("Upload failed is_uploaded_file test.");
		exit(0);
	} else if (!isset($_FILES[$upload_name]['name'])) {
		HandleError("File has no name.");
		exit(0);
	}

// Validate the file size (Warning: the largest files supported by this code is 2GB)
	$file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
	if (!$file_size || $file_size > $max_file_size_in_bytes) {
		HandleError("File exceeds the maximum allowed size");
		exit(0);
	}

	if ($file_size <= 0) {
		HandleError("File size outside allowed lower bound");
		exit(0);
	}


// Validate file name (for our purposes we'll just remove invalid characters)
	$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($_FILES[$upload_name]['name']));
	if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
		HandleError("Invalid file name");
		exit(0);
	}


// Validate that we won't over-write an existing file
	if (file_exists($save_path . $file_name)) {
		HandleError("File with this name already exists");
		exit(0);
	}

// Validate file extension

	$path_info = pathinfo($_FILES[$upload_name]['name']);
	$file_extension = $path_info["extension"];
	$is_valid_extension = false;
	foreach ($extension_whitelist as $extension) {
		if (strcasecmp($file_extension, $extension) == 0) {
			$is_valid_extension = true;
			break;
		}
	}
	if (!$is_valid_extension) {
		HandleError("Invalid file extension");
		exit(0);
	}

	$file_data = explode(".", $_FILES[$upload_name]["name"]);
	$name_array = explode("_", $file_data[0]);
	$orgfile_name = '';
	foreach($name_array as $values)
		{
			$orgfile_name.=$values;
		}
	$file_name = 'temp_'.$orgfile_name.'_'.md5(time()).'.'.$file_extension;

	if (!@copy($_FILES[$upload_name]["tmp_name"], $save_path.$file_name)) {
		HandleError("File could not be saved.");
		exit(0);
	}
	//saving thumbnail inside the folder..
	$save_path = '../'.$CFG['admin']['index']['home_module']."/files/uploads/thumbs/";
	$display_path = $CFG['admin']['index']['home_module']."/files/uploads/thumbs/";
	$file_name = 'temp_'.$orgfile_name.'_'.md5(time()).'_thumb.'.$file_extension;
	$file_name_original  = $_FILES[$upload_name]["name"];

	//for uploading images.
	if(in_array($extern, $CFG['admin']['attachments']['image_formats']))
	{
		// Get the image and create a thumbnail
		if($extern == 'jpeg' || $extern == 'jpg')
			$img = imagecreatefromjpeg($_FILES["Filedata"]["tmp_name"]);
		elseif ($extern == 'png' )
			$img = imagecreatefrompng($_FILES["Filedata"]["tmp_name"]);
		elseif ($extern == 'gif')
			$img = imagecreatefromgif($_FILES["Filedata"]["tmp_name"]);
		if (!$img )
		    {
				echo "ERROR:could not create image handle ". $_FILES["Filedata"]["tmp_name"];
				exit(0);
			}

		$width = imageSX($img);
		$height = imageSY($img);

		if (!$width || !$height) {
			echo "ERROR:Invalid width or height";
			exit(0);
		}

		// Build the thumbnail ..................
		$target_width = 100;
		$target_height = 100;
		$target_ratio = $target_width / $target_height;

		$img_ratio = $width / $height;

		if ($target_ratio > $img_ratio) {
			$new_height = $target_height;
			$new_width = $img_ratio * $target_height;
		} else {
			$new_height = $target_width / $img_ratio;
			$new_width = $target_width;
		}

		if ($new_height > $target_height) {
			$new_height = $target_height;
		}
		if ($new_width > $target_width) {
			$new_height = $target_width;
		}

		$new_img = ImageCreateTrueColor(90, 90);
		if (!@imagefilledrectangle($new_img, 0, 0, $target_width-1, $target_height-1, 0)) {	// Fill the image black
			echo "ERROR:Could not fill new image";
			exit(0);
		}

		if (!@imagecopyresampled($new_img, $img, ($target_width-$new_width)/2, ($target_height-$new_height)/2, 0, 0, $new_width, $new_height, $width, $height)) {
			echo "ERROR:Could not resize image";
			exit(0);
		}

		if (!@imagejpeg($new_img, $save_path.$file_name)) {
			HandleError("File could not be saved.");
			exit(0);
		}
	}
	else {
		if (!@copy($_FILES[$upload_name]["tmp_name"], $save_path.$file_name)) {
			HandleError("File could not be saved.");
			exit(0);
		}
	}

	$file_id = $display_path.$file_name;
	echo "FILEID:" . $file_id.'#'.$file_name_original;	// Return the file id to the script

function HandleError($message) {
	echo $message;
}
?>
