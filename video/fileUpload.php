<?php
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_video.inc.php');
function chkAndCreateFolder($folderName)
	{
		$folder_arr = explode('/', $folderName);
		$folderName = '';
		foreach($folder_arr as $key=>$value)
			{
				$folderName .= $value.'/';
				if($value == '..' or $value == '.')
					continue;
				if (!is_dir($folderName))
					{
						mkdir($folderName);
						@chmod($folderName, 0777);
					}
			}
	}
$temp_dir = '../'.$CFG['media']['folder'].'/'.$CFG['temp_media']['folder'].'/'.$CFG['admin']['videos']['temp_folder'].'/';
chkAndCreateFolder($temp_dir);
$temp_file = $temp_dir.$_GET['file_name'];
foreach ($_FILES as $fieldName => $file) {
	$extern = strtolower(substr($file['name'], strrpos($file['name'], '.')+1));
	move_uploaded_file($file['tmp_name'], $temp_file.'.'.$extern);
}
echo true;exit;
?>