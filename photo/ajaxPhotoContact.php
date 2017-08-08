<?php
 /**
 * viewPhoto.php
 * This file is to get photo contacts name
 *
 * PHP version 5.0
 *
 * @category	Framework
 * @package
 * @author 		edwin_048at09
 * @copyright	Copyright (c) 2009 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: ajaxPhotoContact.php 656 2010-02-05 edwin_048at09 $
 * @since 		2010-02-05
 */
require_once('../common/configs/config.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['site']['is_module_page']='photo';
$CFG['db']['is_use_db'] = true;
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = 'members';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * PhotoTagging
 *
 * @package
 * @author edwin_048at09
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class PhotoContact extends PhotoHandler
	{
		public function getPhotoContacts()
		{

		   $sql = 'SELECT ppt.photo_people_tag_id, ppt.photo_owner_id, ppt.tag_name,ppt.tagged_by_user_id,u.user_name,u.email,u.user_id'.
					' FROM '.$this->CFG['db']['tbl']['photo_people_tag'].' AS ppt LEFT JOIN  '.
					$this->CFG['db']['tbl']['users'].' AS u ON (ppt.associate_user_id=u.user_id) AND u.usr_status=\'Ok\''.
					'WHERE ppt.tagged_by_user_id = '.$this->dbObj->Param('tagged_by_user_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($total_rec=$rs->PO_RecordCount())
			{
				$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type', 'sex');
			   	$inc=0;
?>[<?php
			 	while($row = $rs->FetchRow())
			    {
			    	$user_name='';
			    	if($row['user_name'])
			    	{
			    		$user_name=$row['user_name'];
			    		$detail = $this->getUserDetail('user_id', $row['user_id']);
						$icon = getMemberAvatarDetails($row['user_id']);
					}
					else
						$icon=$this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/canvas/noPeople.gif';
					$source_icon=$this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/favicon.ico';
					$inc++;
?>
{"text":"<?php echo $row['tag_name'];?>","user_name":"<?php echo $user_name;?>","source":"<?php echo str_replace('/','\/',$this->CFG['site']['url']);?>","source_icon":"<?php echo str_replace('/','\/',$source_icon);?>","id":"<?php echo $row['photo_people_tag_id'];?>","pic_url":"<?php echo str_replace('/','\/',$icon);?>"}
<?php if($total_rec>$inc)
{
?>,
<?php
}
			    }
?>]
<?php
			}
			else
			{
			?>[]<?php
			}
		}
	}
$photocontac = new PhotoContact();
$photocontac->getPhotoContacts();
?>