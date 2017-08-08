<?php
require_once('../common/configs/config.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
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
 * @copyright Copyright (c) 2009 - 2010
 * @version $Id: $
 * @access public
 **/

set_time_limit(0);
class ManageDeleted extends FormHandler
	{
		public function daysDifference($endDate, $beginDate)
			{

			   //explode the date by "-" and storing to array
			   $date_parts1=explode("-", $beginDate);
			   $date_parts2=explode("-", $endDate);
			   //gregoriantojd() Converts a Gregorian date to Julian Day Count
			   $start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
			   $end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
			   return $end_date - $start_date;
			}
		public function removeTempFiles($path)
			{
				if ($handle = opendir($path))
					{
						while (false !== ($file = readdir($handle)))
							 {
								if ($file != "." && $file != "..")
									{
										$fName = $file;
										$file = $path.'/'.$file;
										if(is_file($file))
											{
												$file_mod =  date ("Ymd", filemtime($file));
												$current_date = date ("F d Y H:i:s.");
												$date_diff =$this->daysDifference(date("Ymd"), $file_mod);
												if($date_diff >= 2)
													unlink($file);
											}
									};
							};
						closedir($handle);
					};
			}
	}

$path = $CFG['site']['project_path'].'files/uploads';
$path1 = $CFG['site']['project_path'].'files/uploads/thumbs';
$ManageDeleted = new ManageDeleted();
$ManageDeleted->removeTempFiles($path);
$ManageDeleted->removeTempFiles($path1);
?>