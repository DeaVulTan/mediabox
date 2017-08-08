<?php
/**
 * Manage Group Category
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Admin
 **/
/**
 * configurations
*/
require_once('../../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'music';
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/managePlaylistComments.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header_popup.php';
$CFG['html']['footer'] = 'admin/html_footer_popup.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

//--------------class Comments--------------->>>//
/**
 * @category	Rayzz
 * @package		Comments
 **/
class Comments extends MusicHandler
	{
		/**
		 * set the condition
		 *
		 * @access public
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'playlist_id=\''.addslashes($this->fields_arr['playlist_id']).'\'';
			}

		/**
		 * Comments::buildSortQuery()
		 *
		 * @return
		 */
		public function buildSortQuery()
			{
				$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}

		/**
		 * Comments::populateComments()
		 *
		 * @return
		 */
		public function populateComments()
			{
				global $smartyObj;
				$populateComments_arr = array();
				$this->UserDetails = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						if(!isset($this->UserDetails[$row['comment_user_id']]))
							$this->UserDetails[$row['comment_user_id']] = $this->getUserDetail('user_id', $row['comment_user_id']);

						$profileIcon = getMemberAvatarDetails($this->UserDetails[$row['comment_user_id']]['icon_id'], $this->UserDetails[$row['comment_user_id']]['icon_type'], $row['comment_user_id'], $this->UserDetails[$row['comment_user_id']]['image_ext'], $this->UserDetails[$row['comment_user_id']]['sex']);
						$row['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
					//	$row['comment'] = nl2br($row['comment']);
						$populateComments_arr[$inc]['record'] = $row;
						$populateComments_arr[$inc]['UserDetails'] = $this->UserDetails[$row['comment_user_id']]['user_name'];
						$populateComments_arr[$inc]['profileIcon'] = $profileIcon;
						$inc++;
					}
				$smartyObj->assign('populateComments_arr', $populateComments_arr);
			}

		/**
		 * Comments::updatePlaylistComments()
		 *
		 * @return
		 */
		public function updatePlaylistComments()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_playlist_comments'].
						' SET comment='.$this->dbObj->Param('comment').' WHERE'.
						' playlist_comment_id='.$this->dbObj->Param('playlist_comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['new_comment'], $this->fields_arr['new_cid']));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
	}
//<<<<<<<--------------class Comments---------------//

//--------------------Code begins-------------->>>>>//
$commetns = new Comments();
$commetns->setPageBlockNames(array('form_confirm', 'comments_list'));
$commetns->setAllPageBlocksHide();
$commetns->setFormField('playlist_id', '');
$commetns->setFormField('cid', '');
$commetns->setFormField('new_cid', '');
$commetns->setFormField('new_comment', '');
/*********** Page Navigation Start *********/
$commetns->setFormField('orderby_field', 'playlist_comment_id');
$commetns->setFormField('orderby', 'DESC');
$commetns->setTableNames(array($CFG['db']['tbl']['music_playlist_comments']));
$commetns->setReturnColumns(array('playlist_comment_id', 'comment_user_id', 'comment', 'TIMEDIFF(NOW(), date_added) AS date_added', 'comment_status'));
/************ page Navigation stop *************/
$commetns->setPageBlockShow('comments_list');
$commetns->sanitizeFormInputs($_REQUEST);
if($commetns->isFormPOSTed($_POST, 'updateSubmit'))
	{
		$commetns->updatePlaylistComments();
		$commetns->setPageBlockShow('block_msg_form_success');
		$commetns->setCommonSuccessMsg($LANG['msg_success_updated']);
	}
else if($commetns->isFormPOSTed($_POST, 'delete_add'))
	{
		if($commetns->deletePlaylistComments($commetns->getFormField('cid')))
			{
				$commetns->setPageBlockShow('block_msg_form_success');
				$commetns->setCommonSuccessMsg($LANG['msg_success_deleted']);
			}
	}
//<<<<--------------------Code Ends----------------------//
if ($commetns->isShowPageBlock('comments_list'))
	{
		/****** navigtion continue*********/
		$commetns->buildSelectQuery();
		$commetns->buildConditionQuery();
		$commetns->buildSortQuery();
		$commetns->buildQuery();
		//$commetns->printQuery();
		$commetns->executeQuery();
		if($commetns->isResultsFound())
			{
				$commetns->anchor = 'dAltMlti';
				$commetns->comments_list['hidden_arr'] = array('start', 'playlist_id');
				$commetns->populateComments();
				$paging_arr = array('playlist_id');
				$smartyObj->assign('smarty_paging_list', $commetns->populatePageLinksGET($commetns->getFormField('start'), $paging_arr));
			}
	}
$commetns->left_navigation_div = 'musicMain';
//include the header file
$commetns->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'music');
$smartyObj->display('managePlaylistComments.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirmDelete');
	function changeSubmitText(cid)
		{
			var obj = eval('document.form_comments_list.commentText_'+cid);
			var txt = replace_string(obj.value, '<br>', '\n');
				txt = replace_string(txt, '<br />', '\n');
			document.form_comments_list.new_comment.value = txt;
			document.form_comments_list.new_cid.value = cid;
			return true;
		}
</script>
<?php
$commetns->includeFooter();
?>