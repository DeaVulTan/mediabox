<?php
 /**
 * viewPhoto.php
 * This file is to post ajax photo tag value
 *
 * PHP version 5.0
 *
 * @category	Framework
 * @package
 * @author 		edwin_048at09
 * @copyright	Copyright (c) 2009 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: ajaxPhotoTagging.php 656 2010-02-05 edwin_048at09 $
 * @since 		2010-02-05
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/ajaxPhotoTagging.php';
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
class PhotoTagging extends PhotoHandler
	{

		/**
		 * PhotoTagging::chkUserNameAvailable()
		 *
		 * @return
		 */
		public function chkUserNameAvailable()
		{
			$sql = 'SELECT user_id, user_name, email '.
					'FROM '.$this->CFG['db']['tbl']['users'].' '.
					'WHERE usr_status =\'Ok\' AND (user_name = '.$this->dbObj->Param('user_name').' OR email='.$this->dbObj->Param('email').')';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['identity_text'],$this->fields_arr['email']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
			  	{
					$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type');
					$user_details_arr = $this->getUserDetail('user_id', $row['user_id']);
					$this->photo_user_details['user_name'] = $user_details_arr['user_name'];
					$this->photo_user_details['icon'] = getMemberAvatarDetails($row['user_id']);
					$this->setFormField('identity_text_new',$user_details_arr['user_name']);
					$this->setFormField('user_name',$row['user_name']);
					$this->setFormField('associate_user_id',$row['user_id']);
			     	return true;
			  	}
			return false;

		}

		/**
		 * PhotoTagging::inserPhotoTag()
		 *
		 * @return
		 */
		public function inserPhotoTag()
		{
			$this->tagNameAsUserName=false;
		    if($this->fields_arr['associate']==1 && $this->chkUserNameAvailable())
		     {
			  $this->tagNameAsUserName=true;
			 }
			$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_people_tag'].' SET'.
					' photo_id='.$this->dbObj->Param('photo_id').','.
					' photo_owner_id='.$this->dbObj->Param('photo_owner_id').','.
					' tag_name='.$this->dbObj->Param('tag_name').','.
					' x='.$this->dbObj->Param('x').','.
					' y='.$this->dbObj->Param('y').','.
					' width='.$this->dbObj->Param('width').','.
					' height='.$this->dbObj->Param('height').','.
					' email_id='.$this->dbObj->Param('email_id').','.
					' associate_user_id='.$this->dbObj->Param('associate_user_id').','.
					' tagged_by_user_id='.$this->dbObj->Param('tagged_by_user_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id'], $this->fields_arr['photo_owner_id'],$this->fields_arr['identity_text'],
			                      $this->fields_arr['coord_x'],$this->fields_arr['coord_y'],$this->fields_arr['width'],$this->fields_arr['height'],
								  $this->fields_arr['email'],$this->fields_arr['associate_user_id'],$this->CFG['user']['user_id']));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			return $this->dbObj->Insert_ID();
		}
	    /**
	     * PhotoTagging::chkTagNameExists()
	     *
	     * @return
	     */
	    public function chkTagNameExists()
	    {
			$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['photo_people_tag'].' '.
					'WHERE tag_name='.$this->dbObj->Param('tag_name').' AND photo_id='.$this->dbObj->Param('photo_id').' ';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['identity_text'],$this->fields_arr['photo_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
			   return true;
			 return false;
		}
		/**
		 * PhotoTagging::deleteTagName()
		 *
		 * @return
		 */
		public function deleteTagName()
		{
			$sql = 'DELETE  FROM '.$this->CFG['db']['tbl']['photo_people_tag'].' '.
					'WHERE photo_people_tag_id='.$this->dbObj->Param('photo_people_tag_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['tag_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

		}
		public function removeAssociate()
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_people_tag'].' '.
					'SET associate_user_id=0 WHERE photo_people_tag_id='.$this->dbObj->Param('photo_people_tag_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['tag_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

		    $sql = 'SELECT tag_name,x,y,width,height FROM '.$this->CFG['db']['tbl']['photo_people_tag'].' '.
					'WHERE photo_people_tag_id='.$this->dbObj->Param('photo_people_tag_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['tag_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
			   {
			   $imgIcon= $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/canvas/noPeople.gif';
?>
{"tag_id":"<?php echo $this->fields_arr['tag_id'];?>","tagged_identity_id":"<?php echo $this->fields_arr['tag_id'];?>","tagged_username":"","identity_text":"<?php echo $row['tag_name'];?>","photo_url":"<?php echo $imgIcon;?>","mcookie":"<?php echo time();?>","coord_x":"<?php echo $row['x'];?>","coord_y":"<?php echo $row['y'];?>","width":"<?php echo $row['width'];?>","height":"<?php echo $row['height'];?>"}
<?php
			   }
			 return false;

		}
	}
$phototagging = new PhotoTagging();
$phototagging->setFormField('action','');
$phototagging->setFormField('coord_x','');
$phototagging->setFormField('coord_y','');
$phototagging->setFormField('height','');
$phototagging->setFormField('width','');
$phototagging->setFormField('identity_text','');
$phototagging->setFormField('photo_id','');
$phototagging->setFormField('email','');
$phototagging->setFormField('associate','');
$phototagging->setFormField('tagged_identity_id','');
$phototagging->setFormField('tag_id','');
$phototagging->setFormField('magic_cookie','');
$phototagging->setFormField('photo_owner_id','');
$phototagging->setFormField('user_name','');
$phototagging->setFormField('associate_user_id',0);
$phototagging->sanitizeFormInputs($_REQUEST);
$phototagging->setFormField('identity_text_new',$phototagging->getFormField('identity_text'));

if($phototagging->getFormField('action')=='save_identity_tag')
{
   if(!$phototagging->chkTagNameExists())
   {
	$tag_id=$phototagging->inserPhotoTag();
	$imgIcon= $CFG['site']['url'].'photo/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/canvas/noPeople.gif';
	if($phototagging->tagNameAsUserName)
	   {
	    $icon_arr=$phototagging->photo_user_details['icon'];
	    $imgIcon = $icon_arr['m_url'];
	   }
?>
{"tag_id":"<?php echo $tag_id;?>","tagged_identity_id":"<?php echo $tag_id;?>","tagged_username":"<?php echo $phototagging->getFormField('user_name');?>","identity_text":"<?php echo $phototagging->getFormField('identity_text_new');?>","photo_url":"<?php echo $imgIcon;?>","mcookie":"<?php echo time();?>","coord_x":"<?php echo $phototagging->getFormField('coord_x');?>","coord_y":"<?php echo $phototagging->getFormField('coord_y');?>","width":"<?php echo $phototagging->getFormField('width');?>","height":"<?php echo $phototagging->getFormField('height');?>"}
<?php
   }
   else
   {
	 echo $LANG['ajaxphototagging_already_exists'];
   }
}
elseif ($phototagging->getFormField('action')=='remove_identity_tag')
{
	$phototagging->deleteTagName();
	echo '1';
}
elseif($phototagging->getFormField('action')=='remove_associate')
{
$phototagging->removeAssociate();
}
?>