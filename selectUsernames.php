<?php
/**
 * This file is to select usernames to send message
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Members
 * @author 		senthil_52ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: selectUsernames.php 6360 2007-04-24 11:44:28Z vidhya_29ag04 $
 * @since 		2006-06-20
 *
 **/
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/selectUsernames.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
if(isset($_REQUEST['ajax_page']) and $_REQUEST['ajax_page'])
	{
		$CFG['mods']['is_include_only']['non_html_header_files'] = true;
	}
else
	{
		$CFG['html']['header'] = 'general/html_header_no_header.php';
		$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
		$CFG['mods']['is_include_only']['html_header'] = false;
		$CFG['html']['is_use_header'] = false;
	}
$CFG['auth']['is_authenticate'] = 'members';
/**
 * To include application top file
 */
require($CFG['site']['project_path'].'common/application_top.inc.php');
//--------------class MailComposeFormHandler--------------->>>//
/**
/**
 * SelectUsername
 *
 * @package
 * @author senthil_52ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: selectUsernames.php 6360 2007-04-24 11:44:28Z vidhya_29ag04 $
 * @access public
 **/
class SelectUsername extends HeaderHandler
	{
		public $EMAIL_ADDRESS;

		/**
		 * SelectUsername::populateContactLists()
		 *
		 * @return
		 */
		public function populateContactLists()
			{
				$sql = 'SELECT relation_id, relation_name ,total_contacts '.
						' FROM '.$this->CFG['db']['tbl']['friends_relation_name'].
						' WHERE user_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).
						' AND total_contacts > 0'.
						' ORDER BY relation_name ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$highlight_value = $this->fields_arr['relation_id'];
				$relation=array();
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$relation[$row['relation_id']] = $row['relation_name'].'('.$row['total_contacts'].')';
							}
					}
				return $relation;
			}

		/**
		 * SelectUsername::populateCheckBoxForRelation()
		 *
		 * @return
		 */
		public function populateCheckBoxForRelation()
			{
				$sql = 'SELECT relation_id, relation_name ,total_contacts '.
						' FROM '.$this->CFG['db']['tbl']['friends_relation_name'].
						' WHERE user_id = '.$this->dbObj->Param('user_id').
						' AND total_contacts > 0'.
						' ORDER BY relation_name ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				$data_arr = array();
				$inc = 0;
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$data_arr[$inc] = $row;
								$data_arr[$inc]['relation_name'] = $row['relation_name'];
								$data_arr[$inc]['relation_label'] = $row['relation_name'].'('.$row['total_contacts'].')';
								$inc++;
							}
					}
				return $data_arr;
			}

		/**
		 * SelectUsername::populateCheckBoxForFriendsList()
		 *
		 * @return
		 */
		public function populateCheckBoxForFriendsList()
			{
				$sql = 'SELECT u.user_name, u.first_name, u.last_name, fl.friend_id AS friend, fl.id as friendship_id'.
						' FROM '.$this->CFG['db']['tbl']['friends_list'].' AS fl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u'.
						' ON (u.user_id = fl.friend_id AND u.usr_status=\'Ok\')'.
						' WHERE fl.owner_id='.$this->dbObj->Param('fl3_user_id').
						' ORDER BY u.user_name';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				if (!$rs)
			        trigger_db_error($this->dbObj);

				$data_arr = array();
				$inc = 0;
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$data_arr[$inc] = $row;
								$data_arr[$inc]['user_name'] = getUserDisplayName($row);
								$inc++;
							}
					}
				return $data_arr;
			}

		/**
		 * SelectUsername::chkIsNotEmptyLocal()
		 *
		 * @param mixed $field_name
		 * @return
		 */
		public function chkIsNotEmptyLocal($field_name)
			{
				$is_ok = (is_string($this->fields_arr[$field_name])) ?
								($this->fields_arr[$field_name]!='') : (!empty($this->fields_arr[$field_name]));
				if (!$is_ok)
					{
						$this->common_error_message = $this->LANG['err_tip_compulsory'];
						return false;
					}
				return true;
			}

		/**
		 * SelectUsername::chkIsValidEmailLocal()
		 *
		 * @param mixed $value
		 * @return
		 */
		public function chkIsValidEmailLocal($value)
			{
				$is_ok = (preg_match("/^\S+@\S+\.\S+$/i", $value));
				if (!$is_ok)
					{
						$err_tip = str_replace('VAR_EMAIL',$value,$this->LANG['err_tip_invalid_email']);
						$this->common_error_message = $err_tip;
						return false;
					}
				return true;
			}

		/**
		 * SelectUsername::getEmailAddressOfFriend()
		 *
		 * @param mixed $friend
		 * @return
		 */
		public function getEmailAddressOfFriend($friend)
			{
				$sql = 'SELECT u.email, fl.friend_id AS friend, fl.id as friendship_id'.
						' FROM '.$this->CFG['db']['tbl']['friends_list'].' AS fl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u'.
						' ON (u.user_id = fl.friend_id AND u.usr_status=\'Ok\')'.
						' WHERE fl.owner_id='.$this->dbObj->Param($this->CFG['user']['user_id']).
						' AND u.user_name='.$this->dbObj->Param($friend).' LIMIT 0, 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $friend));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$value = trim($row['email']);
						if($value)
							$this->EMAIL_ADDRESS[] = $value;
						return true;
					}
				return false;
			}

		/**
		 * SelectUsername::getEmailAddressOfRelation()
		 *
		 * @param mixed $value
		 * @return
		 */
		public function getEmailAddressOfRelation($value)
			{
				$sql = 'SELECT relation_id FROM '.$this->CFG['db']['tbl']['friends_relation_name'].
						' WHERE relation_name='.$this->dbObj->Param($value);

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($value));
				if (!$rs)
				        trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$sql = 'SELECT u.email FROM '.$this->CFG['db']['tbl']['friends_relation'].' AS fr'.
								', '.$this->CFG['db']['tbl']['friends_list'].' AS fl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u'.
								' ON (u.user_id = fl.friend_id AND u.usr_status=\'Ok\' AND fl.owner_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).')'.
								' WHERE (fr.relation_id='.$this->dbObj->Param($row['relation_id']).' AND fl.id=fr.friendship_id)';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $row['relation_id']));
						if (!$rs)
						        trigger_db_error($this->dbObj);

						if($rs->PO_RecordCount())
							{
								while($row = $rs->FetchRow())
									{
										$value = trim($row['email']);
										if($value)
											$this->EMAIL_ADDRESS[] = $value;
									}
							}
						return true;
					}
				return false;
			}

		/**
		 * SelectUsername::getUsersForRelation()
		 *
		 * @param mixed $value
		 * @return
		 */
		public function getUsersForRelation($value)
			{
				global $smartyObj;
				$getUsersForRelation_arr = array();

				$sql = 'SELECT fr.friendship_id, u.user_name, u.first_name, u.last_name, fl.friend_id AS friend, fl.id as friendship_id'.
						' FROM '.$this->CFG['db']['tbl']['friends_relation'].' AS fr, '.$this->CFG['db']['tbl']['friends_list'].' AS fl LEFT JOIN users AS u'.
						' ON (u.user_id = fl.friend_id AND u.usr_status=\'Ok\' AND fl.owner_id = '.$this->dbObj->Param($this->CFG['user']['user_id']).')'.
						' WHERE (fr.relation_id='.$this->dbObj->Param('relation_id').' AND fl.id=fr.friendship_id)'.
						' ORDER BY u.user_name asc';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $value));
				if (!$rs)
				    trigger_db_error($this->dbObj);

				$getUsersForRelation_arr['row'] = array();
				if($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								$getUsersForRelation_arr['row'][$inc]['record'] = $row;
								$getUsersForRelation_arr['row'][$inc]['user_name'] = getUserDisplayName($row);
								$inc++;
							}
					}
				$smartyObj->assign('populateCheckBoxForRelationList_arr', $getUsersForRelation_arr);
			}

		/**
		 * SelectUsername::isAjaxpage()
		 *
		 * @return
		 */
		public function isAjaxpage()
			{
				isAjaxpage();
			}
	}
//<<<<<-------------- Class SelectUsername begins ---------------//
//-------------------- Code begins -------------->>>>>//
$selectusername = new SelectUsername();
$selectusername->setPageBlockNames(array('msg_form_error', 'msg_form_success', 'select_username'));

//default form fields and values...
$selectusername->setFormField('photo_id', '');
$selectusername->setFormField('email_address', '');
$selectusername->setFormField('personal_message', '');
$selectusername->setFormField('relation_id', '');
$selectusername->setFormField('friend_id', '');
$selectusername->setFormField('ajax_page', '');
$selectusername->setFormField('relation_name', '');

$selectusername->sanitizeFormInputs($_REQUEST);
if($selectusername->getFormField('ajax_page'))
	{
		if($selectusername->getFormField('relation_id') == 0)
			{
				$selectusername->includeAjaxHeaderSessionCheck();
				$smartyObj->assign('populateCheckBoxForRelation_arr', $selectusername->populateCheckBoxForRelation());
				$smartyObj->assign('populateCheckBoxForFriendsList_arr', $selectusername->populateCheckBoxForFriendsList());
				$smartyObj->assign('populateContactLists', $selectusername->populateContactLists());
				$selectusername->select_username['hidden_fields'] = array('photo_id');
				$smartyObj->assign('select_username_url',getUrl('selectusernames','?ajax_page=true&amp;relation_id=', '?ajax_page=true&amp;relation_id=', 'members'));
				setTemplateFolder('members/');
				$smartyObj->display('selectUsernames.tpl');
				$selectusername->includeAjaxFooter();
				exit;
			}
		else
			{
				$selectusername->includeAjaxHeaderSessionCheck();
				$selectusername->getUsersForRelation($selectusername->getFormField('relation_id'));
				setTemplateFolder('members/');
				$smartyObj->display('selectUsernames.tpl');
				$selectusername->includeAjaxFooter();
				exit;
			}
	}
//Default page Block
$selectusername->setAllPageBlocksHide();
$selectusername->setPageBlockShow('select_username');
$smartyObj->assign('populateCheckBoxForRelation_arr', $selectusername->populateCheckBoxForRelation());
$smartyObj->assign('populateCheckBoxForFriendsList_arr', $selectusername->populateCheckBoxForFriendsList());
$smartyObj->assign('populateContactLists', $selectusername->populateContactLists());
//$smartyObj->assign('populateContactLists', $selectusername->populateContactLists());
$selectusername->select_username['hidden_fields'] = array('photo_id');
$smartyObj->assign('select_username_url',getUrl('selectusernames','?ajax_page=true&amp;relation_id=', '?ajax_page=true&amp;relation_id=', 'members'));
//<<<<<-------------------- Code ends----------------------//
$selectusername->includeHeader();
//include the content of the page
setTemplateFolder('members/');
$smartyObj->display('selectUsernames.tpl');
?>
<script type="text/javascript" language="javascript">

	document.formEmailList.email_address.value = parent.document.form_compose.username.value;
	setFullScreenBrowser();
</script>
<?php
$selectusername->includeFooter();
?>