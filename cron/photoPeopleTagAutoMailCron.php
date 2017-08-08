<?php
/**
 * This file is to activate the upload the photos
 *
 * This file is having PhotoActivate class to upload the photos
 *
 * @category	rayzz
 * @package		Cron
 *
 **/
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/email_notify.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
set_time_limit(0);
class PhotoPeopleTag extends PhotoHandler
{

	public function PhotoPeopleTagMailDetails()
	{
		$sql  = 'SELECT p.photo_id, p.photo_owner_id, p.tag_name, p.tagged_by_user_id,p.associate_user_id, p.email_id, u.user_name,u.email,pho.photo_title,pho.photo_ext FROM'.
				' '.$this->CFG['db']['tbl']['photo_people_tag'].' as p LEFT JOIN '.$this->CFG['db']['tbl']['users'].
				' as u ON p.photo_owner_id=u.user_id LEFT JOIN '.$this->CFG['db']['tbl']['photo'].
				' as pho ON p.photo_id=pho.photo_id  WHERE pho.photo_status=\'Ok\' '.
				' AND p.date_added < DATE_SUB(now(), INTERVAL 1 DAY)';

		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($rs->PO_RecordCount())
		{
			while($row = $rs->FetchRow())
		    {
		    	$this->PHOTO_ID          = $row['photo_id'];
		    	$this->PHOTO_NAME 		 = getPhotoName($this->PHOTO_ID);
				$this->PHOTO_TITLE       = $row['photo_title'];
				$this->PHOTO_USER_NAME   = $row['user_name'];
				$this->PHOTO_USER_EMAIL  = $row['email'];
				$this->PHOTO_EXT 		 = $row['photo_ext'];
				$this->PHOTO_TAGNAME 	 = $row['tag_name'];
				$this->ASSOCIATE_USER_ID = $row['associate_user_id'];
				$this->PHOTO_EMAIL 	     = $row['email_id'];
				$this->getUserName($row['tagged_by_user_id']);
				if($this->ASSOCIATE_USER_ID)
				{
					$this->getAssociateUserDetails();
					if($this->ASSOCIATE_USER_MAIL)
						$this->sendMailToPhotoAssociatedUserMail();
				}
				$this->sendMailToPhotoMail($this->PHOTO_EMAIL);
			}
		}
	}

	public function sendMailToPhotoAssociatedUserMail()
	{

		if($this->ASSOCIATE_USER_MAIL)
		{
			$photo_folder = $this->CFG['media']['folder'].'/'.
								$this->CFG['admin']['photos']['folder'].'/'.
									$this->CFG['admin']['photos']['photo_folder'].'/';
			if(!empty($this->PHOTO_EXT))
				$photo_url = $this->CFG['site']['url'].$photo_folder.getPhotoName($this->PHOTO_ID).
									$this->CFG['admin']['photos']['thumb_name'].'.'.$this->PHOTO_EXT;
			else
				$photo_url = $this->CFG['site']['url'].'photo/design/templates/'.
									$this->CFG['html']['template']['default'].'/root/images/'.
											$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_photo_T.jpg';
			$photo_image = '<img border="0" src="'.$photo_url.'" alt="'.$this->PHOTO_TITLE.'" title="'.$this->PHOTO_TITLE.'" />';

			$photolink = getUrl('viewphoto','?photo_id='.$this->PHOTO_ID.'&title='.$this->changeTitle($this->PHOTO_TITLE), $this->PHOTO_ID.'/'.$this->changeTitle($this->PHOTO_TITLE).'/','root', 'photo');

			$subject = str_replace('VAR_USER_NAME', $this->PHOTO_TAGGED_BY_USER_NAME, $this->LANG['photo_tagged_associated_subject']);
			$body = str_replace('VAR_USER_NAME', $this->PHOTO_TAGGED_BY_USER_NAME, $this->LANG['photo_tagged_associated_content']);
			$body = str_replace('VAR_PHOTO_IMAGE', '<a href="'.$photolink.'">'.$photo_image.'</a>', $body);
			$body = str_replace('VAR_PHOTO_LINK', $photolink, $body);
			$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
			$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
			$body=nl2br($body);
			$is_ok = $this->_sendMail($this->ASSOCIATE_USER_MAIL, $subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
	   }
		return true;
	}
	public function sendMailToPhotoMail($email)
	{

		if($email)
		{
			$photo_folder = $this->CFG['media']['folder'].'/'.
								$this->CFG['admin']['photos']['folder'].'/'.
									$this->CFG['admin']['photos']['photo_folder'].'/';
			if(!empty($this->PHOTO_EXT))
				$photo_url = $this->CFG['site']['url'].$photo_folder.getPhotoName($this->PHOTO_ID).
									$this->CFG['admin']['photos']['thumb_name'].'.'.$this->PHOTO_EXT;
			else
				$photo_url = $this->CFG['site']['url'].'photo/design/templates/'.
									$this->CFG['html']['template']['default'].'/root/images/'.
											$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_photo_T.jpg';
			$photo_image = '<img border="0" src="'.$photo_url.'" alt="'.$this->PHOTO_TITLE.'" title="'.$this->PHOTO_TITLE.'" />';

			$photolink = getUrl('viewphoto','?photo_id='.$this->PHOTO_ID.'&title='.$this->changeTitle($this->PHOTO_TITLE), $this->PHOTO_ID.'/'.$this->changeTitle($this->PHOTO_TITLE).'/','root', 'photo');

			$subject = str_replace('VAR_USER_NAME', $this->PHOTO_TAGGED_BY_USER_NAME, $this->LANG['photo_tagged_associated_subject']);
			$body = str_replace('VAR_USER_NAME', $this->PHOTO_TAGGED_BY_USER_NAME, $this->LANG['photo_tagged_associated_content']);
			$body = str_replace('VAR_PHOTO_IMAGE', '<a href="'.$photolink.'">'.$photo_image.'</a>', $body);
			$body = str_replace('VAR_PHOTO_LINK', $photolink, $body);
			$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
			$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
			$body=nl2br($body);
			$is_ok = $this->_sendMail($email, $subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
	   }
		return true;
	}
	public function getUserName($added_by_user_id)
	{
		$sql = 'SELECT user_name,email FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id = '.$this->dbObj->Param('added_by_user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($added_by_user_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if ($row = $rs->FetchRow())
		{
			$this->PHOTO_TAGGED_BY_USER_NAME = $row['user_name'];
			$this->PHOTO_TAGGED_BY_USER_MAIL = $row['email'];
		}
	}
	public function getAssociateUserDetails()
	{
		$sql = 'SELECT user_name,email FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id = '.$this->dbObj->Param('associate_user_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->ASSOCIATE_USER_ID));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if ($row = $rs->FetchRow())
		{
			$this->ASSOCIATE_USER_NAME = $row['user_name'];
			$this->ASSOCIATE_USER_MAIL = $row['email'];
		}
	}
	public function PhotoPeopleTagMailtoPhotoOwner()
	{
		$sql  = 'SELECT p.photo_owner_id, u.user_name,u.email FROM'.
				' '.$this->CFG['db']['tbl']['photo_people_tag'].' as p LEFT JOIN '.$this->CFG['db']['tbl']['users'].
				' as u ON p.photo_owner_id=u.user_id  WHERE  p.date_added < DATE_SUB(now(), INTERVAL 1 DAY) group by p.photo_owner_id';

		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($rs->PO_RecordCount())
		{
			while($row = $rs->FetchRow())
		    {
				$this->PHOTO_OWNER_ID   = $row['photo_owner_id'];
				$this->PHOTO_USER_NAME   = $row['user_name'];
				$this->PHOTO_USER_EMAIL  = $row['email'];
				$this->sendMailToPhotoMailtoOwner($this->PHOTO_USER_EMAIL);
			}
		}
	}
	public function sendMailToPhotoMailtoOwner($email)
	{

		if($email)
		{
			$photo_folder = $this->CFG['media']['folder'].'/'.
								$this->CFG['admin']['photos']['folder'].'/'.
									$this->CFG['admin']['photos']['photo_folder'].'/';
			$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $this->LANG['photo_tagged_subject']);
			$body = str_replace('VAR_USER_NAME', $this->PHOTO_USER_NAME, $this->LANG['photo_tagged_content']);
			$sql = 'SELECT p.photo_id,p.photo_ext,p.photo_title FROM '.$this->CFG['db']['tbl']['photo'].' as p JOIN '.$this->CFG['db']['tbl']['photo_people_tag'].
				' as pp ON pp.photo_owner_id=p.user_id  WHERE pp.photo_owner_id = '.$this->dbObj->Param('photo_owner_id').'  and pp.photo_id=p.photo_id  group by pp.photo_id';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->PHOTO_OWNER_ID));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			$photoz ='';
			while($row = $rs->FetchRow())
			{
				if(!empty($row['photo_ext']))
					$photo_url = $this->CFG['site']['url'].$photo_folder.getPhotoName($row['photo_id']).
										$this->CFG['admin']['photos']['thumb_name'].'.'.$row['photo_ext'];
				else
					$photo_url = $this->CFG['site']['url'].'photo/design/templates/'.
										$this->CFG['html']['template']['default'].'/root/images/'.
												$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_photo_T.jpg';
				$photo_image = '<img border="0" src="'.$photo_url.'" alt="'.$row['photo_title'].'" title="'.$row['photo_title'].'" />';

				$photolink = getUrl('viewphoto','?photo_id='.$row['photo_id'].'&title='.$this->changeTitle($row['photo_title']), $row['photo_id'].'/'.$this->changeTitle($row['photo_title']).'/','root', 'photo');
				$photoz .=  '<span><a href="'.$photolink.'">'.$photo_image.'</a></span>&nbsp;';
			}
			$body = str_replace('VAR_PHOTO_LINK', $photoz, $body);
			$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
			$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
			$body=nl2br($body);
			$is_ok = $this->_sendMail($email, $subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
	   }
		return true;
	}
}
//-------------------- Code begins -------------->>>>>//

$PhotoPeopleTag = new PhotoPeopleTag();
$PhotoPeopleTag->setDBObject($db);
$PhotoPeopleTag->makeGlobalize($CFG, $LANG);
$PhotoPeopleTag->setMediaPath('../');
$PhotoPeopleTag->PhotoPeopleTagMailDetails();
$PhotoPeopleTag->PhotoPeopleTagMailtoPhotoOwner();
?>