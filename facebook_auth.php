<?php
/**
 * This file to handle facebook authentication
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Members
 */
require_once('common/configs/config.inc.php'); //configurations
if (version_compare(PHP_VERSION,'5','>='))
	{
		require_once ('facebook/client/facebook.php');
	}
else
	{
 		require_once ('facebook/php4client/facebook.php');
  		require_once ('facebook/php4client/facebookapi_php4_restlib.php');
	}
$CFG['lang']['include_files'][] = 'languages/%s/root/facebook_auth.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['include_files'][] = 'common/configs/config_facebook.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_SignupAndLoginHandler.lib.php';

$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'root';

require($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class facebookAuth-------------------->>>
/**
 * facebookAuth
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class facebookAuth extends SignupAndLoginHandler
	{
		public $sreg = array();

		public $user_details_arr = array();

		public $hashcode = '';

		/**
		 * PhotoUpload::setIHObject()
		 *
		 * @param  $imObj
		 * @return
		 */
		public function setIHObject($imObj)
			{
				$this->imageObj = $imObj;
			}

		/**
		 * facebookAuth::chkIsNotDuplicateFacebookIdentity()
		 *
		 * @param mixed $hash
		 * @return
		 */
		public function chkIsNotDuplicateFacebookIdentity($hash)
			{
				$sql = 'SELECT * FROM ' . $this->CFG['db']['tbl']['facebook_identity'] .
				 	   ' WHERE hashcode =\''.$hash.'\''.
					   ' AND user_id != 0 AND status = \'Ok\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
						trigger_db_error($this->dbObj);

				return $rs->PO_RecordCount();
			}

		/**
		 * facebookAuth::chkFacebookIdAlreadyExists()
		 *
		 * @param mixed $hashcode
		 * @param string $status
		 * @return
		 */
		public function  chkFacebookIdAlreadyExists($hashcode, $status= '')
			{
				$sql = 'SELECT * FROM '. $this->CFG['db']['tbl']['facebook_identity'] .
					   	' WHERE hashcode=\''.$hashcode.'\'' ;
				if($status == 'ToActivate')
					{
						$sql .=  ' AND status = \'ToActivate\'';
					}
				elseif($status == 'InActive')
					{
						$sql .=  ' AND status = \'InActive\'';
					}
				else
					{
						$sql .=  ' AND status = \'Ok\'';
					}
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
		    		trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount() != 0)
					{
						$row = $rs->FetchRow();
						return $row['user_id'];
					}
				return(-1);
			}

		/**
		 * facebookAuth::insertIntoFacebookIdentity()
		 *
		 * @param mixed $user_id
		 * @param mixed $hashcode
		 * @param string $status
		 * @return
		 */
		public function insertIntoFacebookIdentity($user_id, $hashcode, $status='')
			{
				$sql =  'INSERT INTO ' . $this->CFG['db']['tbl']['facebook_identity'] .
						' SET user_id = ' . $this->dbObj->Param('user_id') .
						', hashcode = ' . $this->dbObj->Param('hashcode') .
						', status = \'ToActivate\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($user_id, $hashcode));
			    if (!$rs)
		    		trigger_db_error($this->dbObj);

				return $this->dbObj->Insert_ID();

			}

		/**
		 * SignUpFormHandler::updateFacebookIdentityWithHashCode()
		 *
		 * @param mixed $user_id
		 * @param mixed $status
		 * @return
		 */
		public function updateFacebookIdentityWithHashCode($user_id, $status)
			{
				 $sql = 'UPDATE ' . $this->CFG['db']['tbl']['facebook_identity'] .
				 		' SET status = '. $this->dbObj->Param('status') .
						', user_id = ' . $this->dbObj->Param('user_id') .
						' WHERE hashcode = ' . $this->dbObj->Param('hashcode');

				 $stmt = $this->dbObj->Prepare($sql);
				 $rs = $this->dbObj->Execute($this->dbObj->Prepare($sql), array($status, $user_id , $this->getFormField('hashcode')));
				 if (!$rs)
					trigger_db_error($this->dbObj);
			}

		/**
		 * facebookAuth::getUserDetailsThis()
		 *
		 * @return
		 */
		public function getUserDetailsThis()
			{
				if($user_detail = $this->getUserDetail('user_id', $this->getFormField('user_id')))
					{
						$this->user_details_arr = $user_detail;
					}
				if($this->user_details_arr and $this->user_details_arr['usr_status'] == 'Ok')
					{
						return true;
					}
				return false;
			}

		/**
		 * facebookAuth::chkUserName()
		 *
		 * @param mixed $user_name
		 * @return
		 */
		public function chkUserName($user_name)
			{
				$sql = 'SELECT user_id FROM ' . $this->CFG['db']['tbl']['users'] .
				 	   ' WHERE user_name ='.$this->dbObj->Param($user_name);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_name));
				if (!$rs)
						trigger_db_error($this->dbObj);

				$numrows = $rs->PO_RecordCount();
				if($numrows == 0)
					{
				    	$this->setFormField('user_name', $user_name);
					}
				else
					{
						$this->createNewUserName($user_name);
					}
			}

		/**
		 * facebookAuth::createNewUserName()
		 *
		 * @param mixed $user_name
		 * @return
		 */
		public function createNewUserName($user_name)
			{
				$this->setFormField('inc', $this->getFormField('inc')+1);
				$user_name = $user_name.'_'. $this->getFormField('inc');
				$this->chkUserName($user_name);
			}

		/**
		 * PhotoUpload::storeImagesTempServer()
		 *
		 * @param  $uploadUrl
		 * @param  $extern
		 * @return
		 */
		public function storeImagesTempServer($uploadUrl, $extern)
			{
				// GET LARGE IMAGE
				if ($this->CFG['image_large_name'] == 'L')
					{
						if ($this->CFG['image_large_height'] or $this->CFG['image_large_width'])
							{
								$this->imageObj->resize($this->CFG['image_large_width'], $this->CFG['image_large_height'], '-');								$this->imageObj->output_resized($uploadUrl . 'L.' . $extern, strtoupper($extern));
								$image_info = getImageSize($uploadUrl . 'L.' . $extern);
								$this->L_WIDTH = $image_info[0];
								$this->L_HEIGHT = $image_info[1];
							}
						else
							{
								$this->imageObj->output_original($uploadUrl . 'L.' . $extern, strtoupper($extern));
								$image_info = getImageSize($uploadUrl . 'L.' . $extern);
								$this->L_WIDTH = $image_info[0];
								$this->L_HEIGHT = $image_info[1];
							}
					}
				// GET THUMB IMAGE
				if ($this->CFG['image_thumb_name'] == 'T')
					{
						$this->imageObj->resize($this->CFG['image_thumb_width'], $this->CFG['image_thumb_height'], '-');
						$this->imageObj->output_resized($uploadUrl . 'T.' . $extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl . 'T.' . $extern);
						$this->T_WIDTH = $image_info[0];
						$this->T_HEIGHT = $image_info[1];
					}
				// GET SMALL IMAGE
				if ($this->CFG['image_small_name'] == 'S')
					{
						$this->imageObj->resize($this->CFG['image_small_width'], $this->CFG['image_small_height'], '-');
						$this->imageObj->output_resized($uploadUrl . 'S.' . $extern, strtoupper($extern));
						$image_info = getImageSize($uploadUrl . 'S.' . $extern);
						$this->S_WIDTH = $image_info[0];
						$this->S_HEIGHT = $image_info[1];
					}
				$wname = $this->CFG['image_large_name'] . '_WIDTH';
				$hname = $this->CFG['image_large_name'] . '_HEIGHT';
				$this->L_WIDTH = $this->$wname;
				$this->L_HEIGHT = $this->$hname;

				$wname = $this->CFG['image_thumb_name'] . '_WIDTH';
				$hname = $this->CFG['image_thumb_name'] . '_HEIGHT';
				$this->T_WIDTH = $this->$wname;
				$this->T_HEIGHT = $this->$hname;

				$wname = $this->CFG['image_small_name'] . '_WIDTH';
				$hname = $this->CFG['image_small_name'] . '_HEIGHT';
				$this->S_WIDTH = $this->$wname;
				$this->S_HEIGHT = $this->$hname;
			}

		/**
		 * PhotoUpload::getServerDetails()
		 *
		 * @return
		 */
		public function getServerDetails()
			{
				$sql = 'SELECT server_url, ftp_server, ftp_usrename, ftp_password'.
						' FROM '.$this->CFG['db']['tbl']['server_settings'].
						' WHERE server_for=\'avatar\' AND server_status=\'Yes\''.
						' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
					{
						$this->fields_arr['ftp_server'] = $row['ftp_server'];
						$this->fields_arr['ftp_usrename'] = $row['ftp_usrename'];
						$this->fields_arr['ftp_password'] = $row['ftp_password'];
						$this->fields_arr['server_url'] = $row['server_url'];
						return true;
					}
				return false;
			}

		/**
		 * facebookAuth::InsertFacebookProfile()
		 *
		 * @param mixed $uid
		 * @return
		 */
		public function InsertFacebookProfile($uid)
	   		{
		  		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['facebook_profile'].
						' SET user_id ='.$this->dbObj->Param($uid);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($uid));
			    if (!$rs)
			        trigger_db_error($this->dbObj);
		  	}
	}
$facebookAuth = new facebookAuth();
//set form fields
$facebookAuth->setFormField('hashcode', '');
$facebookAuth->setFormField('signup_ip', '' );
$facebookAuth->setFormField('ip', '');
$facebookAuth->setFormField('usr_status', '');
$facebookAuth->setFormField('openid_used', '');
$facebookAuth->setFormField('user_name', '');
$facebookAuth->setFormField('openid_type', '');
$facebookAuth->setFormField('first_name', '');
$facebookAuth->setFormField('last_name', '');
$facebookAuth->setFormField('sex', '');
$facebookAuth->setFormField('email', '');
$facebookAuth->setFormField('inc', 0);
$facebookAuth->setFormField('user_id', '');
$facebookAuth->setFormField('photo_ext', '');
$facebookAuth->setFormField('about_me', '');
$facebookAuth->setFormField('url', (isset($_SESSION['url']) ? $_SESSION['url'] : ''));

$facebookAuth->sanitizeFormInputs($_REQUEST);
$facebookAuth->setFormField('hashcode', md5($facebookAuth->getFormField('hashcode')));

$id = $facebookAuth->chkFacebookIdAlreadyExists($facebookAuth->getFormField('hashcode'));
$id1 = $facebookAuth->chkFacebookIdAlreadyExists($facebookAuth->getFormField('hashcode'), 'ToActivate');
if(($id == -1 && $id1 == -1) || ($id == -1 && $id1 != -1))
	{
		if($id1 == -1)
			{
				$facebookAuth->insertIntoFacebookIdentity(0, $facebookAuth->getFormField('hashcode'));
			}
		Redirect2URL(getUrl('signupexternal', '?hashcode='.$facebookAuth->getFormField('hashcode'), '?hashcode='.$facebookAuth->getFormField('hashcode'), 'root'));
	}
else
	{
		if($facebookAuth->chkIsNotDuplicateFacebookIdentity($facebookAuth->getFormField('hashcode')))
			{
				if($facebookAuth->user_details_arr = getUserDetail('user_id', $id))
					{
						if($facebookAuth->user_details_arr['usr_status'] !='Ok')
							{
								Redirect2URL(getUrl('externallogin', '?user_id='.$facebookAuth->user_details_arr['user_id'], '?user_id='.$facebookAuth->user_details_arr['user_id'], 'root'));
							}

						$facebookAuth->updateUserLog($CFG['db']['tbl']['users'],
													$CFG['remote_client']['ip'],
													session_id());
						$facebookAuth->saveUserVarsInSession($CFG['remote_client']['ip']);
						$_SESSION['facebook_hashcode'] = $facebook_userid;
						if($facebookAuth->user_details_arr['facebook_image']=='Yes')
							{
								$facebook = new Facebook($CFG['facebook']['api_key'], $CFG['facebook']['appsecret']);
								$facebook_userid = $facebook->require_login();
								$user_details = $facebook->api_client->users_getInfo($facebook_userid, array('last_name','first_name','name','sex', 'pic', 'pic_with_logo', 'pic_small'));
								$facebookAuth->chkIsFaceBookImageUploaded($user_details[0]['pic_with_logo'], $_SESSION['user']['user_id']);
							}
						if ($facebookAuth->chkIsFirstVisit())
						    {
						        Redirect2URL(getUrl('mail', '?folder=inbox', 'inbox/', 'members'));
						    }
						else
							{
								Redirect2URL(getUrl($CFG['auth']['members_url']['file_name'], '', '', 'members'));
							}
					}
			}
		else
			{
				$msg = $facebookAuth->LANG['user_status_blocked'];
				Redirect2URL(getUrl('externallogin', '?msg='.$msg, '?msg='.$msg, 'root'));
			}
	}
die('coming here');
?>