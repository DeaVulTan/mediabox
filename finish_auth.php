<?php
/**
 * File to handle the openid authentication
 *
 * @category	RAYZZ
 * @package		ROOT
 */
require_once('common/configs/config.inc.php');
require_once($CFG['site']['project_path'].'common/classes/class_openid/common.php');
require_once($CFG['site']['project_path'].'common/classes/class_openid/Auth/OpenID/Consumer.php');
require_once($CFG['site']['project_path'].'common/classes/class_openid/Auth/OpenID/FileStore.php');
require_once($CFG['site']['project_path'].'common/classes/class_openid/Auth/OpenID/SReg.php');
require_once($CFG['site']['project_path'].'common/classes/class_openid/Auth/OpenID/PAPE.php');
$CFG['mods']['include_files'][] = 'common/classes/class_SignupAndLoginHandler.lib.php';

$CFG['lang']['include_files'][] = 'languages/%s/root/finish_auth.php';
$CFG['mods']['include_files'][] = 'common/classes/class_openid/common.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';

//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'root';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class finishAuth--------------->>>//
/**
 * finishAuth
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class finishAuth extends SignupAndLoginHandler
	{
		public $sreg = array();

		public $user_details_arr = array();

		public $hashcode = '';

		/**
		 * finishAuth::chkIsNotDuplicateIdentity()
		 *
		 * @param mixed $table_name
		 * @param mixed $hash
		 * @return
		 */
		public function chkIsNotDuplicateIdentity($table_name, $hash)
			{
				$sql = 'SELECT * FROM '.$table_name.
						' WHERE hashcode ='.$this->dbObj->Param($hash).
						' AND user_id != 0';
				// prepare query
				$stmt = $this->dbObj->Prepare($sql);
				// execute query
				$rs = $this->dbObj->Execute($stmt, array($hash));
				//raise user error... fatal
				if (!$rs)
						trigger_db_error($this->dbObj);
				// counts number of rows
				$numrows = $rs->PO_RecordCount();
				// finds row exists
				return $numrows;
			}

		/**
		 * finishAuth::final_run()
		 *
		 * @return
		 */
		public function final_run()
			{
				$consumer = getConsumer();
				$esc_identity = '';

				// Complete the authentication process using the server's
				// response.
				$return_to = getReturnTo();
				$response = $consumer->complete($return_to);
				// Check the response status.
				if ($response->status == Auth_OpenID_CANCEL)
					{
						//This means the authentication was cancelled.
						$msg = $this->LANG['verification_denied'];
						Redirect2URL(getUrl('externallogin', '?msg='.$msg, '?msg='.$msg, 'root'));
					}
				else if ($response->status == Auth_OpenID_FAILURE)
					{
						// Authentication failed; display the error message.
						$msg = $this->LANG['authorization_failure'];
						Redirect2URL(getUrl('externallogin', '?msg='.$msg, '?msg='.$msg, 'root'));
					}
				else if ($response->status == Auth_OpenID_SUCCESS)
					{
						// This means the authentication succeeded; extract the
						// identity URL and Simple Registration data (if it was
						// returned).
						$openid = $response->getDisplayIdentifier();
						$this->esc_identity = htmlspecialchars($openid, ENT_QUOTES);
						$sreg_resp = Auth_OpenID_SRegResponse::fromSuccessResponse($response);
						$this->sreg = $sreg_resp->contents();
						$id = $this->chkAlreadySignedIn($this->esc_identity);
						$id1 = $this->chkAlreadySignedIn($this->esc_identity, 'ToActivate');
						$id2 = $this->chkAlreadySignedIn($this->esc_identity, 'InActive');
						if(($id == -1 && $id1 == -1) || ($id == -1 && $id1 != -1) || ($id == -1 && $id2 != -1))
							{
								$this->hashcode = md5($this->esc_identity);
								$info =  @$this->sreg;
								$_SESSION['info'] = $info;

								if($id1 == -1)
									{
										$this->insertIntoUserIdentity(0);
									}
								$normal = 'id=' . $this->hashcode;
								$htaccess = $this->hashcode . '/openid/register/';
								$cnt = $this->chkIsNotDuplicateIdentity($this->CFG['db']['tbl']['user_identity'],$this->hashcode );
								if($cnt!=0)
									{
										$msg = $this->LANG['user_status_blocked'];
										Redirect2URL(getUrl('externallogin', '?msg='.$msg, '?msg='.$msg, 'root'));
									}
								else
									Redirect2URL(getUrl('signupexternal', '?id='.$this->hashcode, '?id='.$this->hashcode, 'root'));
							}
						if($this->user_details_arr = getUserDetail('user_id', $id))
							{
								if($this->user_details_arr['usr_status'] !='Ok')
									{
										Redirect2URL(getUrl('externallogin', '?user_id='.$this->user_details_arr['user_id'], '?user_id='.$this->user_details_arr['user_id'], 'root'));
									}
								$this->updateUserLog($this->CFG['db']['tbl']['users'],
										$this->CFG['remote_client']['ip'],
										session_id());

								$this->saveUserVarsInSession($this->CFG['remote_client']['ip']);

								if ($this->chkIsFirstVisit())
								    {
								        Redirect2URL(getUrl('mail', '?folder=inbox', 'inbox/', 'members'));
								    }
								else
									{
										Redirect2URL(getUrl($this->CFG['auth']['members_url']['file_name'], '', '', 'members'));
									}
							}
							else
								die('invalid');
					}
			}

		/**
		 * finishAuth::insertIntoUserIdentity()
		 *
		 * @param mixed $user_id
		 * @param string $status
		 * @return
		 */
		public function insertIntoUserIdentity($user_id, $status='')
			{
				$sql =  'INSERT INTO ' . $this->CFG['db']['tbl']['user_identity'] .
						' SET user_id = ' . $this->dbObj->Param('user_id') .
						', identity = ' . $this->dbObj->Param('identity') .
						', hashcode = ' . $this->dbObj->Param('hashcode') .
						', status = \'ToActivate\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt,array($user_id, $this->esc_identity, $this->hashcode));
			    if (!$rs)
		    		trigger_db_error($this->dbObj);

				return $this->dbObj->Insert_ID();
			}
	}
$obj = new finishAuth();
$obj->setDBObject($db);
$obj->makeGlobalize($CFG,$LANG);
$obj->setFormField('url', (isset($_SESSION['url']) ? $_SESSION['url'] : ''));
$obj->setFormField('remember', '');
$obj->final_run();
?>