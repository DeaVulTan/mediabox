<?php
/**
 * This file is lists friends of the member and manage relations
 *
 * @category	Rayzz
 * @package		ManageRelationsListHandler
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/relationView.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
/**
 * To include application top file
 */
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//-------------------------class ManageRelationsListHandler ----------------------->>>
/**
 * ManageRelationsListHandler
 *
 * @package
 * @author Senthil
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class ManageRelationsListHandler extends ListRecordsHandler
	{
		public $linkFieldsArray = array();

		public $myRelation = array();

		public $myRelationCount = array();

		/**
		 * set the condition
		 *
		 * @access public
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$condition = '(fr.relation_id='.$this->getFormField('relation').' AND fl.id=fr.friendship_id)';
				$this->sql_condition = $condition;
			}

		/**
		 * To sort the query
		 *
		 * @access public
		 * @return void
		 **/
		public function checkSortQuery($field, $sort='asc')
			{
				if(!($this->sql_sort))
					{
						$this->sql_sort = $field . ' ' . $sort;
					}
			}

		/**
		 * ManageRelationsListHandler::setMyRelations()
		 *
		 * @return
		 */
		public function setMyRelations()
			{
				$userId = $this->CFG['user']['user_id'];
				$sql = 'SELECT relation_id, relation_name ,total_contacts '.
						' FROM '.$this->CFG['db']['tbl']['friends_relation_name'].
						' where user_id = '.$this->dbObj->Param($userId).
						' ORDER BY relation_name ';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($userId));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = array();
				$relation = array();
				$relationCount = array();
				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$relation[$row['relation_id']] = $row['relation_name'];
								$relationCount[$row['relation_id']] = $row['total_contacts'];
	 					    }
					}
				$this->myRelation = $relation;
				$this->myRelationCount = $relationCount;
			}

		/**
		 * ManageRelationsListHandler::displayMyFriends()
		 *
		 * @return
		 */
		public function displayMyFriends()
			{
				global $smartyObj;
				$displayMyFriends_arr = array();
				$found = false;
				$displayMyFriends_arr['row'] = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
				    {
						$displayMyFriends_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['friend']);
						$row['friend_name'] = $row['user_name'];
						$row['friend_id'] = $row['friend'];
						//$relationshipId = $row['relationship_id'];
						$displayMyFriends_arr['row'][$inc]['friendProfileUrl'] = getMemberProfileUrl($row['friend_id'], $row['friend_name']);
						$displayMyFriends_arr['row'][$inc]['record'] = $row;
						$inc++;
					}
				$smartyObj->assign('displayMyFriends_arr', $displayMyFriends_arr);
			}

		/**
		 * ManageRelationsListHandler::getRelation()
		 *
		 * @param integer $fId
		 * @return
		 */
		public function getRelation($fId=0)
			{
				$currentUserId = $this->CFG['user']['user_id'];
				$sql = 	'SELECT r.relation_id as relation_id, r.relation_name as relation_name'.
						' FROM '.$this->CFG['db']['tbl']['friends_relation_name'].' AS r , '.$this->CFG['db']['tbl']['friends_relation'].' AS v'.
						' WHERE v.friendship_id='.$this->dbObj->Param($fId).
						' AND r.relation_id=v.relation_id'.
						' AND r.user_id='.$this->dbObj->Param($currentUserId);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($fId, $currentUserId));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$relation = array();
				if ($rs->PO_RecordCount())
					{
			    		while($row = $rs->FetchRow())
						    {
								$relation[$row['relation_id']] = $row['relation_name'];
							}
					}
				return $relation;
			}

		/**
		 * ManageRelationsListHandler::isEmpty()
		 *
		 * @param mixed $value
		 * @return
		 */
		public function isEmpty($value)
			{
				$is_not_empty = is_string($value)?trim($value)=='':empty($value);
				return $is_not_empty;
			}

		/**
		 * ManageRelationsListHandler::removeContactFromList()
		 *
		 * @param integer $relationship_id
		 * @return
		 */
		public function removeContactFromList($relationship_id=0)
			{
			    $relationship_id=str_replace(',','\',\'' ,$relationship_id);
			    $relationship_id='\''.$relationship_id.'\'';
				 $sql = 'DELETE FROM '.$this->CFG['db']['tbl']['friends_relation'].' WHERE id IN ('.$relationship_id.')';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt);
				//raise user error... fatal
				if (!$rs)
				    trigger_db_error($this->dbObj);

				if ($affected = $this->dbObj->Affected_Rows())
				    {
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['friends_relation_name'].
								' SET total_contacts = total_contacts - '.$affected.
								' WHERE relation_id='.$this->dbObj->Param($this->fields_arr['relation']);
						// prepare sql
						$stmt = $this->dbObj->Prepare($sql);
						// execute sql
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['relation']));
						//raise user error... fatal
						if (!$rs)
						    trigger_db_error($this->dbObj);

						$this->setMyRelations();
						return true;
				    }
				else
					{
						return false;
					}
			}
	}
//<<<<<---------------class ManageRelationsListHandler------///
//--------------------Code begins-------------->>>>>//
$managerelations = new ManageRelationsListHandler();
$managerelations->setPageBlockNames(array('msg_form_info', 'form_list_friends', 'form_search_friend'));
$managerelations->setAllPageBlocksHide();

// To set the DB object
$managerelations->setMyRelations();

$managerelations->setFormField('user_id', $CFG['user']['user_id']);
$managerelations->setFormField('relation', 0);
$managerelations->setFormField('relation_name', '');
$managerelations->setFormField('numpg', $CFG['data_tbl']['numpg']);
$managerelations->setFormField('start', 0);
$managerelations->setFormField('action', '');
$managerelations->setFormField('relationship_ids', '');
$managerelations->setMinRecordSelectLimit(2);
$managerelations->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$managerelations->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$managerelations->setReturnColumns(array());
$managerelations->sanitizeFormInputs($_POST);
if ($managerelations->isPageGETed($_GET, 'start'))
    {
		$managerelations->sanitizeFormInputs($_GET);
		$start = $managerelations->getFormField('start');
		if (!is_numeric($start))
		    {
		        $managerelations->setFormField('start', 0);
		    }
    }

if ($managerelations->isPageGETed($_GET, 'relation'))
    {
        $managerelations->sanitizeFormInputs($_GET);
		$relation = $managerelations->getFormField('relation');

		if($managerelations->getFormField('action') == 'Remove')
		    {
		        $managerelations->setFormField('relationship_id','');
				$managerelations->sanitizeFormInputs($_POST);
				$removeFriend = $managerelations->getFormField('relationship_id');
				$managerelations->removeContactFromList($removeFriend);
				$managerelations->setCommonSuccessMsg($LANG['managerelations_removed_success_message']);
				$managerelations->setPageBlockShow('block_msg_form_success');
		    }
		if($managerelations->getFormField('action') == 'removeSelected')
		    {
				$managerelations->sanitizeFormInputs($_POST);
				$removeFriend = $managerelations->getFormField('relationship_ids');
				$managerelations->chkIsNotEmpty('relationship_ids', $LANG['managerelations_err_tip_compulsory'])or
				$managerelations->setCommonErrorMsg($LANG['managerelations_select_message']);
				if ($managerelations->isValidFormInputs())
				    {
						$managerelations->removeContactFromList($removeFriend);
						$managerelations->setCommonSuccessMsg($LANG['managerelations_removed_selected_success_message']);
						$managerelations->setPageBlockShow('block_msg_form_success');
				    }
				else
					{
						$managerelations->setCommonErrorMsg($LANG['managerelations_err_tip_not_select_message']);
						$managerelations->setPageBlockShow('block_msg_form_error');
					}
		    }
		$myRelation = $managerelations->myRelation;
		if ($myRelation)
		    {
				$myRelation = array_keys($myRelation);
		        if (!in_array($relation, $myRelation))
		            {
						$relation = array_shift($myRelation);
						$managerelations->setFormField('relation', $relation);
					}
				$managerelations->setFormField('relation_name', $managerelations->myRelation[$relation]);
				$managerelations->setTableNames(array($CFG['db']['tbl']['friends_relation'].' AS fr, '.$CFG['db']['tbl']['friends_list'].' AS fl LEFT JOIN '.$CFG['db']['tbl']['users'].' AS u ON (u.user_id = fl.friend_id AND u.usr_status=\'Ok\' AND fl.owner_id='.$CFG['user']['user_id'].' )'));
				$managerelations->setReturnColumns(array('fr.id as relationship_id, u.user_name, u.icon_id, u.icon_type, u.image_ext, fl.friend_id AS friend, fl.id as friendship_id'));
				$managerelations->buildSelectQuery();
				$managerelations->buildConditionQuery();
				$managerelations->buildSortQuery();
				$managerelations->checkSortQuery('u.user_name', 'asc');
				$managerelations->buildQuery();
				$managerelations->executeQuery();
		        $managerelations->setPageBlockShow('form_list_friends');
		    }
		else
			{
		        $managerelations->setPageBlockShow('msg_form_info');
			}
    }
else
	{
		Redirect2URL(getUrl($CFG['admin']['profile_urls']['relation_manage']['normal'], $CFG['admin']['profile_urls']['relation_manage']['htaccess']));
	}
//<<<<--------------------Code Ends----------------------//
if ($managerelations->isShowPageBlock('form_list_friends'))
	{
		$managerelations->form_list_friends['totalFriends'] = $managerelations->getResultsTotalNum();
		if ($managerelations->form_list_friends['totalFriends'])
		    {
		    	$managerelations->paging_arr = array('relation');
		    	$smartyObj->assign('smarty_paging_list', $managerelations->populatePageLinksGET($managerelations->getFormField('start'), $managerelations->paging_arr));
				$managerelations->form_list_friends['form_action'] = getUrl('relationview', '?relation='.$managerelations->getFormField('relation'), '?relation='.$managerelations->getFormField('relation'), 'members');
				$managerelations->displayMyFriends();
			}
	}

$managerelations->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
setTemplateFolder('members/');
$smartyObj->display('relationView.tpl');
?>
<script language="javascript" type="text/javascript">
	var block_arr= new Array('selMsgConfirm');
	var please_select_action = '<?php echo $LANG['err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction()
		{
			$Jq('#confirmMessage').html('<?php echo $LANG['managerelations_selectblock_confirm_message'];?>');
			document.msgConfirmform.action.value = 'Remove';
			Confirmation('selMsgConfirm', 'msgConfirmform', Array('relationship_ids', 'action'), Array(multiCheckValue, 'removeSelected'), Array('value', 'value'),'selFormForums');
		}
</script>
<?php
//<<<<<<--------------------Page block templates Ends--------------------//
$managerelations->includeFooter();
?>