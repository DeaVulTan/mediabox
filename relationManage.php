<?php
/**
 * This file is lists friends of the member and manage relations
 *
 * @category	Rayzz
 * @package		ManageRelationsListHandler
 */
require_once('./common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/members/relationManage.php';
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
		public function buildConditionQuery($condition='')
			{
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
		 * print the query for development
		 *
		 * @return
		 **/
		public function printQuery()
			{
				print 'Query: '.$this->sql.'<br>';
				print 'Query: '.$this->sql_count.'<br>';
			}

		/**
		 * To populate the relations
		 *
		 * @param integer $highlight_relation
		 * @access public
		 * @return void
		 **/
		public function populateRelations($highlight_relation='')
			{
				if ($this->myRelation)
				    {
						foreach($this->myRelation as $id=>$name)
							{
?>
	<option value="<?php echo $id;?>"<?php echo ($highlight_relation == $id)? 'SELECTED' : '';?>><?php echo $name;?></option>
<?php
			 			    }
					}
			}

		/**
		 * ManageRelationsListHandler::populateMoveToRelations()
		 *
		 * @param integer $friendship_id
		 * @param array $inRelation
		 * @return
		 */
		public function populateMoveToRelations($friendship_id=0, $inRelation = array())
			{
				$allRelation = $this->myRelation;
				if ($inRelation)
				    {
?>
<optgroup label="Delete From List"></optgroup>
<?php
				        foreach($inRelation as $id=>$name)
							{
								$value = 'delete_'.$friendship_id.'_'.$id;
?>
	<option style="padding-left:1em;" value="<?php echo $value;?>"><?php echo $name;?></option>
<?php
								if(isset($allRelation[$id]))
									{
										unset($allRelation[$id]);
									}
							}
				    }
				if ($allRelation)
				    {
?>
<optgroup label="Add to List"></optgroup>
<?php
						foreach($allRelation as $id=>$name)
							{
								$value = 'add_'.$friendship_id.'_'.$id;
?>
	<option style="padding-left:1em;" value="<?php echo $value;?>"><?php echo $name;?></option>
<?php
			 			    }
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
						$displayMyFriends_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['user_id']);
						$row['friend_name'] = $row['user_name'];
						$row['relation_id'] = 0;
						$relation = $this->getRelation($row['friendship_id']);
						$row['relation_name'] = implode(',', array_values($relation));
						if(empty($relation))
							{
								$row['relation_name'] = '-';
							}
						$row['friend_id'] = $row['friend'];
						$displayMyFriends_arr['row'][$inc]['relation'] = $relation;
						$displayMyFriends_arr['row'][$inc]['record'] = $row;
						$displayMyFriends_arr['row'][$inc]['friendProfileUrl'] = getMemberProfileUrl($row['friend_id'], $row['friend_name']);
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
						' FROM '.$this->CFG['db']['tbl']['friends_relation_name'].' AS r, '.$this->CFG['db']['tbl']['friends_relation'].' as v '.
						' WHERE v.friendship_id='.$this->dbObj->Param($fId).
						' AND r.relation_id=v.relation_id'.
						' AND r.user_id='.$this->dbObj->Param($currentUserId);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($fId, $currentUserId));
				//raise user error... fatal
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
		 * To move the selected friends to selected relations
		 *
		 * @access public
		 * @return void
		 **/
		public function moveToRelation()
			{
				$relation_id = $this->fields_arr['relation_id'];
				if (strcmp($relation_id,'new')==0 && $this->fields_arr['new_relation'])
					{
						$relation_id = $this->addNewRelation();
				    }
				if (is_numeric($relation_id))
					{
						$this->moveSelectedFriends($relation_id);
						return true;
				    }
				$this->setCommonErrorMsg($this->LANG['managerelations_not_moved']);
				return false;
			}

		/**
		 * To add new relation
		 *
		 * @access public
		 * @return void
		 **/
		public function addNewRelation()
			{
				$currentUserId = $this->CFG['user']['user_id'];
				$newRelation = $this->fields_arr['new_relation'];
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['friends_relation_name'].
						' SET user_id = '.$this->dbObj->Param($currentUserId).
						', relation_name = '.$this->dbObj->Param($newRelation);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($currentUserId, $newRelation));
				//raise user error... fatal
				if (!$rs)
				    trigger_db_error($this->dbObj);

				return $this->dbObj->Insert_ID();
			}

		/**
		 * ManageRelationsListHandler::hasAtleastOneFriend()
		 *
		 * @return
		 */
		public function hasAtleastOneFriend()
			{
				$currentUserId = $this->CFG['user']['user_id'];
				$sql = 'SELECT total_friends FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id='.$this->dbObj->Param($currentUserId);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($currentUserId));
				//raise user error... fatal
				if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['total_friends'];
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
		 * ManageRelationsListHandler::buildSearchConditionQuery()
		 *
		 * @return
		 */
		public function buildSearchConditionQuery()
			{
				$this->sql_condition .= ' ';
				if (!$this->isEmpty($this->fields_arr['uname']))
				    {
						$this->sql_condition .= 'AND u.user_name LIKE \'%'.addslashes($this->fields_arr['uname']).'%\' ';
						$this->linkFieldsArray[] = 'uname';
				    }
				if (!$this->isEmpty($this->fields_arr['email']))
				    {
						$this->sql_condition .= 'AND u.email LIKE \'%'.addslashes($this->fields_arr['email']).'%\' ';
						$this->linkFieldsArray[] = 'email';
				    }
				if (!$this->isEmpty($this->fields_arr['tagz']))
				    {
						$this->sql_condition .= 'AND '.getSearchRegularExpressionQueryModified($this->fields_arr['tagz'], 'u.profile_tags', '');
						$this->linkFieldsArray[] = 'tagz';
				    }
				if (!$this->isEmpty($this->fields_arr['srch_relation']))
				    {
						$this->sql_condition .= 'AND (fr.relation_id='.$this->fields_arr['srch_relation'].' AND fl.id=fr.friendship_id)';
						$this->linkFieldsArray[] = 'srch_relation';
				    }
			}

		/**
		 * ManageRelationsListHandler::performOperationsNow()
		 *
		 * @return
		 */
		public function performOperationsNow()
			{
				$select = $this->getFormField('singleSelect');
				arsort($select);
				$option  = array_shift($select);
				if (is_numeric(strpos($option, 'delete')))
				    {
				        $value = explode('_',  $option);
						$relationId = $value[2];
						$friendshipId = $value[1];
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['friends_relation'].
								' WHERE relation_id='.$this->dbObj->Param($relationId).' AND friendship_id='.$this->dbObj->Param($friendshipId);
						// prepare sql
						$stmt = $this->dbObj->Prepare($sql);
						// execute sql
						$rs = $this->dbObj->Execute($stmt, array($relationId, $friendshipId));
						//raise user error... fatal
						if (!$rs)
						    trigger_db_error($this->dbObj);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['friends_relation_name'].
								' SET total_contacts = total_contacts - 1 WHERE relation_id='.$this->dbObj->Param($relationId).' AND total_contacts > 0';
						// prepare sql
						$stmt = $this->dbObj->Prepare($sql);
						// execute sql
						$rs = $this->dbObj->Execute($stmt, array($relationId));
						//raise user error... fatal
						if (!$rs)
						    trigger_db_error($this->dbObj);
						$this->setMyRelations();
				    }
				else if (is_numeric(strpos($option, 'add')))
			    	{
			        	$value = explode('_',  $option);
						$relationId = $value[2];
						$friendshipId = $value[1];
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['friends_relation'].
								' SET relation_id='.$this->dbObj->Param($relationId).', friendship_id='.$this->dbObj->Param($friendshipId);
						// prepare sql
						$stmt = $this->dbObj->Prepare($sql);
						// execute sql
						$rs = $this->dbObj->Execute($stmt, array($relationId, $friendshipId));
						//raise user error... fatal
						if (!$rs)
						    trigger_db_error($this->dbObj);
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['friends_relation_name'].
								' SET total_contacts = total_contacts + 1 WHERE relation_id='.$this->dbObj->Param($relationId);
						// prepare sql
						$stmt = $this->dbObj->Prepare($sql);
						// execute sql
						$rs = $this->dbObj->Execute($stmt, array($relationId));
						//raise user error... fatal
						if (!$rs)
						    trigger_db_error($this->dbObj);
						$this->setMyRelations();
				    }
			}

		/**
		 * ManageRelationsListHandler::setNewRelationValues()
		 *
		 * @return
		 */
		public function setNewRelationValues()
			{
				$newRelation = $this->fields_arr['new_relation'];
				$newRelation = trim($newRelation);
				if ($newRelation)
				    {
						if(!in_array($newRelation, $this->myRelation))
							{
								$newRelationId = $this->addNewRelation();
							}
						else
							{
								$relationIds = array_flip($this->myRelation);
								$newRelationId = $relationIds[$newRelation];
							}
						if ($newRelationId)
						    {
						        $this->setFormField('relation_id', $newRelationId);
						    }
				    }
			}

		/**
		 * ManageRelationsListHandler::copyRelationShip()
		 *
		 * @return
		 */
		public function copyRelationShip()
			{
				$this->setNewRelationValues();
				$friendship = $this->fields_arr['friendship_ids'];
				$relation_id = $this->fields_arr['relation_id'];
				$affected = false;
				while($friendship_id = array_shift($friendship))
				    {
					    $sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['friends_relation'].
								' WHERE relation_id='.$this->dbObj->Param($relation_id).' AND friendship_id='.$this->dbObj->Param($friendship_id);
						// prepare sql
						$stmt = $this->dbObj->Prepare($sql);
						// execute sql
						$rs = $this->dbObj->Execute($stmt, array($relation_id, $friendship_id));
						//raise user error... fatal
						if (!$rs)
						trigger_db_error($this->dbObj);
						$row = array();
						if (!$rs->PO_RecordCount())
							{
								$affected = true;
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['friends_relation'].
										' SET relation_id='.$this->dbObj->Param($relation_id).', friendship_id='.$this->dbObj->Param($friendship_id);
								// prepare sql
								$stmt = $this->dbObj->Prepare($sql);
								// execute sql
								$rs = $this->dbObj->Execute($stmt, array($relation_id, $friendship_id));
								//raise user error... fatal
								if (!$rs)
								    trigger_db_error($this->dbObj);

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['friends_relation_name'].
										' SET total_contacts = total_contacts + 1 WHERE relation_id='.$this->dbObj->Param($relation_id);
								// prepare sql
								$stmt = $this->dbObj->Prepare($sql);
								// execute sql
								$rs = $this->dbObj->Execute($stmt, array($relation_id));
								//raise user error... fatal
								if (!$rs)
								    trigger_db_error($this->dbObj);
							}
				    } // while
				if ($affected)
				    {
						$this->setMyRelations();
				    }
			}
	}
//<<<<<---------------class ManageRelationsListHandler------///
//--------------------Code begins-------------->>>>>//
$managerelations = new ManageRelationsListHandler();
$managerelations->setPageBlockNames(array('msg_form_info', 'form_list_friends', 'form_search_friend'));
$managerelations->setAllPageBlocksHide();

$managerelations->setMyRelations();

$managerelations->setFormField('user_id', $CFG['user']['user_id']);

$managerelations->setFormField('friendship_ids', array());
$managerelations->setFormField('relation_id', '');
$managerelations->setFormField('new_relation', '');
$managerelations->setFormField('search_enable', '');
$managerelations->setFormField('fsrch', '1');
$managerelations->setFormField('uname', '');
$managerelations->setFormField('email', '');
$managerelations->setFormField('tagz', '');
$managerelations->setFormField('srch_relation', '');
$managerelations->setFormField('singleSelect', array());
$managerelations->setMinRecordSelectLimit(2);
$managerelations->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$managerelations->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$managerelations->sanitizeFormInputs($_POST);
$relations_name_min_length = 3;
$relations_name_max_length = 25;

if($managerelations->getFormField('srch_relation') != '')
	$managerelations->setTableNames(array($CFG['db']['tbl']['friends_relation'].' AS fr, '.$CFG['db']['tbl']['friends_list'].' AS fl LEFT JOIN '.$CFG['db']['tbl']['users'].' AS u ON (u.user_id = fl.friend_id AND u.usr_status=\'Ok\' AND fl.owner_id='.$CFG['user']['user_id'].')'));
else
	$managerelations->setTableNames(array($CFG['db']['tbl']['friends_list'].' AS fl LEFT JOIN '.$CFG['db']['tbl']['users'].' AS u ON (u.user_id = fl.friend_id AND u.usr_status=\'Ok\' AND fl.owner_id='.$CFG['user']['user_id'].')'));
$managerelations->setReturnColumns(array('DISTINCT u.user_id, u.user_name, u.icon_id, u.icon_type, u.image_ext, u.sex, fl.friend_id AS friend, fl.id as friendship_id'));
$condition = 'fl.owner_id='.$CFG['user']['user_id'];

if ($managerelations->isPageGETed($_GET, 'start'))
    {
		$managerelations->sanitizeFormInputs($_GET);
		$start = $managerelations->getFormField('start');
		if (!is_numeric($start))
		    {
		        $managerelations->setFormField('start', 0);
		    }
    }
if ($managerelations->isFormPOSTed($_POST, 'singleSelect') AND !$managerelations->isFormPOSTed($_POST, 'managerelations_submit'))
    {
        $managerelations->sanitizeFormInputs($_POST);
		$managerelations->performOperationsNow();
    }
if ($managerelations->isFormPOSTed($_POST,'managerelations_submit'))
	{
		$managerelations->sanitizeFormInputs($_POST);
		$managerelations->chkIsNotEmpty('relation_id', $LANG['managerelations_err_tip_compulsory'])or
			$managerelations->setCommonErrorMsg($LANG['managerelations_select_relation']);
		$managerelations->chkIsNotEmpty('friendship_ids', $LANG['managerelations_err_tip_compulsory'])or
			$managerelations->setCommonErrorMsg($LANG['managerelations_select_friends']);
		$managerelations->setAllPageBlocksHide();
		if ($managerelations->isValidFormInputs())
			{
				$managerelations->setFormField('user_ids', array());
				$managerelations->setPageBlockShow('msg_form_success');
				$managerelations->copyRelationShip();
				$managerelations->setFormField('relation_id', '');
			}
		else
			{
				$managerelations->setPageBlockShow('msg_form_error');
			}
	}

if ($managerelations->hasAtleastOneFriend())
    {
		$managerelations->buildSelectQuery();
		$managerelations->buildConditionQuery($condition);

		if ($managerelations->isFormPOSTed($_POST, 'friendSearch') || $managerelations->getFormField('search_enable'))
		    {
		        $managerelations->sanitizeFormInputs($_POST);
				$managerelations->setFormField('search_enable', 1);
				$managerelations->buildSearchConditionQuery();
		    }
		$managerelations->buildSortQuery();
		$managerelations->checkSortQuery('u.user_name', 'asc');
		$managerelations->buildQuery();
		//$managerelations->printQuery();
		$managerelations->executeQuery();
		$managerelations->setPageBlockShow('form_search_friend');
        $managerelations->setPageBlockShow('form_list_friends');
    }
else
	{
        $managerelations->setPageBlockShow('msg_form_info');
	}

$managerelations->setFormField('user_id', $CFG['user']['user_id']);
//<<<<--------------------Code Ends----------------------//

if ($managerelations->isShowPageBlock('form_list_friends'))
	{
		$managerelations->form_list_friends['totalFriends'] = $managerelations->getResultsTotalNum();
		if ($managerelations->form_list_friends['totalFriends'])
		    {
				$smartyObj->assign('smarty_paging_list', $managerelations->populatePageLinksGET($managerelations->getFormField('start'), $managerelations->linkFieldsArray));
				$managerelations->displayMyFriends();
			}
	}
$LANG['managerelations_exceeds_length'] = str_replace('VAR_MAX_LENGTH', $relations_name_min_length, $LANG['managerelations_exceeds_length']);
//--------------------Page block templates begins-------------------->>>>>//
$managerelations->includeHeader();
setTemplateFolder('members/');
$smartyObj->display('relationManage.tpl');
?>
<script language="javascript" type="text/javascript">
	function addNewRelation(selObj ){
		var val = selObj.value;
		var sample = '<?php echo $LANG['managerelations_sample'];?>';
		var exceedsMsg = '<?php echo $LANG['managerelations_exceeds_length'];?>';
		var selectFriendsMsg = '<?php echo $LANG['managerelations_select_friends']; ?>';

		if( val.indexOf('add')==0){

			getMultiCheckBoxValue('form_show_friends', 'check_all');
			if(multiCheckValue == '')
				{
					alert_manual(selectFriendsMsg);
					selObj.value = '';
					return false;
				}

			$Jq('#selPomptDialog').dialog({
				open: true,
				height: 100,
				width: 350,
				modal: true,
				buttons: {
					Cancel: function() {
						$Jq(this).dialog('close');
						document.form_show_friends.relation_id.options[0].selected = 'selected';
					},
					'Ok': function() {
						var bValid = true;

						bValid = bValid && checkLength(newRelation,"newRelation", <?php echo $relations_name_min_length?>, <?php echo $relations_name_max_length?>);
						bValid = bValid && notExists(newRelation.val());

						if (bValid) {
							$Jq('#relation_id').append('<option value="new" selected="selected">'+newRelation.val()+'</option>');
							$Jq('#new_relation').val(newRelation.val());
							$Jq(this).dialog('close');
						}
					}
				},
				close: function() {
					allFields.val('').removeClass('ui-state-error');
					if( document.form_show_friends.relation_id.options[document.form_show_friends.relation_id.selectedIndex].value == 'add')
						document.form_show_friends.relation_id.options[0].selected = 'selected';
				}
			});
		}
	}

	var newRelation = $Jq("#newRelation"),
		allFields = $Jq([]).add(newRelation);

	function checkLength(o, n ,min,max) {
		if ( o.val().length > max || o.val().length < min ) {
			//o.addClass('ui-state-error');
			alert_manual(LANG_JS_relation_name_length+" "+min+" "+LANG_JS_and+" "+max+".");
			return false;
		} else {
			return true;
		}
	}

	function notExists(newRelation) {
		var existsMsg = '<?php echo $LANG['managerelations_already_exists'];?>';
		for ( var i = 0; i < index; i++ ) {
			if ( document.form_show_friends.relation_id.options[i].text.toUpperCase() == newRelation.toUpperCase()) {
				alert_manual(existsMsg);
				document.form_show_friends.relation_id.options[0].selected = 'selected';
				return false;
			}
		}
		return true;
	}
</script>
<?php
$managerelations->includeFooter();
?>
