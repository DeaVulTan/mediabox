<?php
/**
 * frp conect, upload file and delete file
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Common
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: class_ftp.lib.php 1025 2006-06-03 06:05:36Z selvaraj_35ag05 $
 * @since 		2006-05-02
 **/

/**
 * FtpHandler
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: class_ftp.lib.php 1025 2006-06-03 06:05:36Z selvaraj_35ag05 $
 * @access public
 **/
class FtpHandler
	{
		public $CONN_ID;

		/**
		 * FtpHandler::FtpHandler()
		 *
		 * @param $ftp_server
		 * @param $user_name
		 * @param $password
		 * @return
		 **/
		public function FtpHandler($ftp_server, $user_name, $password)
			{

				$this->CONN_ID = @ftp_connect($ftp_server);
				$login_result = @ftp_login($this->CONN_ID, $user_name, $password);
				// check connection
				if ($this->CONN_ID and $login_result)
				   return true;
				else
				   return false;
			}

		/**
		 * FtpHandler::changeDirectory()
		 *
		 * @param $dir
		 * @return
		 **/
		public function changeDirectory($dir)
			{
				if(@ftp_chdir($this->CONN_ID, $dir))
					{
						return true;
					}
				return false;
			}

			/**
		 * FtpHandler::chkIsFileExist()
		 *
		 * @param $dir
		 * @return
		 **/
		public function chkIsFileExist($video_path,$video_name)
			{
				$video_name = $video_path.$video_name;
				//stores the file name listed in the given directory
				//check if given video name is exist
				$contents = ftp_nlist($this->CONN_ID, $video_path);
//				echo "<PRE>";
//				print_r($contents);
//				echo "</pre>";

				if(in_array("$video_name", $contents))
					return true;

				return false;

			}

		/**
		 * FtpHandler::makeDirectory()
		 *
		 * @param $dir
		 * @param $mode
		 * @return
		 **/
		public function makeDirectory($dir, $mode=0777)
			{
				$folder_arr = explode('/', $dir);
				$folderName = '';
				foreach($folder_arr as $key=>$value)
					{
						$folderName .= $value.'/';
						if($value == '..' or $value == '.')
							continue;

						if(@ftp_mkdir($this->CONN_ID, $folderName))
							{
								@ftp_chmod($this->CONN_ID, $mode, $folderName);
							}
					}
			}

		/**
		 * FtpHandler::moveTo()
		 *
		 * @param $source_file
		 * @param $destination_file
		 * @param string $mode
		 * @return
		 **/
		public function moveTo($source_file, $destination_file, $mode=0777)
			{
				if(@ftp_put($this->CONN_ID, $destination_file, $source_file, FTP_BINARY))
					{
						@ftp_chmod($this->CONN_ID, $mode, $destination_file);
						return true;
					}
				return false;
			}


		public function copyFrom($local_file, $server_file, $mode=0777)
			{
				if (ftp_get($this->CONN_ID, $local_file, $server_file, FTP_BINARY)) {
				    echo "Successfully written to $local_file\n";
				    return true;
				} else {
				    echo "There was a problem\n";
				    return false;
				}

			}

		/**
		 * FtpHandler::deleteFile()
		 *
		 * @param $file
		 * @return
		 **/
		public function deleteFile($file)
			{
				if (@ftp_delete($this->CONN_ID, $file))
					return true;
				else
					return false;
			}

		/**
		 * FtpHandler::ftpClose()
		 *
		 * @return
		 **/
		public function ftpClose()
			{
				if(@ftp_close($this->CONN_ID))
					return true;
				return false;
			}

		public function removeFolder($dir)
		{
			$contents = @ftp_nlist($this->CONN_ID, $dir);
				foreach($contents as $key=>$files)
				{
					if($files != '..' or $files != '.')
					{
						$this->deleteFile($dir.$files);
					}
				}
			if (@ftp_rmdir($this->CONN_ID, $dir))
				return true;
			return false;
		}
		/**
		 * FtpHandler::ftpGet()
		 *
		 * @param $ftpfile
		 * @param $downloadfile
		 * @return
		 **/
		public function ftpGet($ftpfile, $downloadfile)
			{
				if(ftp_get($this->CONN_ID, $downloadfile, $ftpfile, FTP_BINARY))
					return true;
				return false;
			}
	}
?>
