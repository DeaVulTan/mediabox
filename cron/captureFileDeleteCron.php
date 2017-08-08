<?php
/**
 * This file is to manage deleted unused flv capture files
 *
 * This file is having ManageDeleted class to manage deleted files
 *
 * @category	Rayzz
 * @package		Cron
 *
 **/
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
$CFG['auth']['is_authenticate'] = false;
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
/**
 * To include application top file
 */
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class ConfigEdit begins -------------------->>>>>//
/**
 * ManageDeleted
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: $
 * @access public
 **/

set_time_limit(0);
class ManageDeleted extends FormHandler
	{
		/**
		 * ManageDeleted::removeFiles()
		 *
		 * @param $file
		 * @return
		 **/
		public function removeFiles($file)
			{
				if(is_file($file))
					{
						echo $file;
						unlink($file);
						return true;
					}
				return false;
			}
		public 	function getTimeDiffernce($date1)
			{
				//current date.
				$date2 = date("Y-m-d H:i:s", time());
				//calculate the difference in seconds.
				$difference = abs(strtotime($date2) - strtotime($date1));
				//calculate the number of hours
				$days = round(((($difference/60)/60)), 0);
				return $days;
			}
		public function deleteNotUsedFiles()
			{
				$dir = $this->CFG['admin']['video']['red5_flv_path'];
				if(!is_dir($dir))
					{
						echo 'directory does not exist';
						return;
					}
				if ($handle = opendir($dir))
					{
					    while (false !== ($file = readdir($handle)))
							{
						        if ($file != "." && $file != "..")
									{
							          //echo $file;
									 $stat = stat($dir.$file);
									 $date1 = date("F d Y H:i:s.",$stat['mtime']);
								     $diff =  $this->getTimeDiffernce( $date1);
									 if($diff >= $this->CFG['admin']['videos']['clean_up_capture_files'])
											{
												$this->removeFiles($dir.$file);
											}


							        }
						    }
					    closedir($handle);
					}
			}
	}
//<<<<<-------------- Class ManageDeleted begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ManageDeleted = new ManageDeleted();
$ManageDeleted->deleteNotUsedFiles();
?>