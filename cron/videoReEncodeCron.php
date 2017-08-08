<?php

/**
 *
 *
 * @version $Id$
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 */
require_once('../common/configs/config.inc.php');
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
require_once('../common/application_top.inc.php');
require_once('../common/configs/config_video.inc.php');
require_once('../common/classes/class_FormHandler.lib.php');
require_once('../common/classes/class_MediaHandler.lib.php');
require_once('../common/classes/class_EncodeHandler.lib.php');
require_once('../common/classes/class_ftp.lib.php');

class videoReEncodeCron extends EncodeHandler
{

	public function getVideoId()
	{
		$rs=$this->selectEncodeCron();
		if($rs->PO_RecordCount())
		{
		$row = $rs->FetchRow();
		$move=false;
		$this->video_id=$row['video_id'];
		$this->encode_id=$row['encode_id'];
		$this->mencoder_command=$row['encode_command'];
		if($row['move'] =='Yes')
			{
				$move =true;
			}
		$output=$this->videoEncode($this->mencoder_command,true,$move);
		echo $output;
		}
	}

}

$obj = new videoReEncodeCron();
$obj->setDBObject($db);
$obj->makeGlobalize($CFG,$LANG);
$obj->setMediaPath('../');
$obj->getVideoId();

?>