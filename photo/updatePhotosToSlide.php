<?php
/**
 * This file is to increase the total view for photoids.
 *
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 * @author
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id:
 * @since 		2007-24-07
 *
 **/

require_once('../common/configs/config.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['is_public_profile'] = false;
$CFG['auth']['is_authenticate'] = false;
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
class PhotoDetail extends PhotoHandler
	{
		public function populateQuickMixPhotos()
		{

			$sql = 'SELECT p.photo_id,  p.location_recorded, p.user_id, u.user_name, p.photo_ext,'.
			       'p.photo_tags, p.photo_title, photo_caption, p.photo_server_url,'.
			       'TIMEDIFF(NOW(), p.date_added) as date_added, p.total_views, (p.rating_total/p.rating_count) as rating '.
			       'FROM '.$this->CFG['db']['tbl']['photo'].' as p LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u '.
			       'ON p.user_id=u.user_id WHERE p.photo_status=\'Ok\' AND u.usr_status=\'Ok\' AND (p.user_id = '.
				    $this->dbObj->Param('user_id').' OR p.photo_access_type = \'Public\') AND photo_id ='.$this->dbObj->Param('photo_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt,array($this->CFG['user']['user_id'],$this->fields_arr['photo_id']));

			if($rs->PO_RecordCount())
				{
					if($row = $rs->FetchRow())
						{
						  $photo_name = getphotoName($row['photo_id']);
						   echo $photo_name.'L.'.$row['photo_ext'];
						   echo $row['photo_title'];
						}
				}
			return false;

		}
	}
$photodetails = new PhotoDetail();
$photodetails->setFormField('photo_id','');
$photodetails->sanitizeFormInputs($_REQUEST);
$photodetails->populateQuickMixPhotos();
?>