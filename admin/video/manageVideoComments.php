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
$CFG['site']['is_module_page'] = 'video';
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/admin/manageVideoComments.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
//$CFG['html']['header'] = 'admin/html_header_popup.php';
$CFG['html']['header'] = 'admin/html_header_no_header.php';
//$CFG['html']['footer'] = 'admin/html_footer_popup.php';
$CFG['html']['footer'] = 'admin/html_footer_no_footer.php';

$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

//--------------class Comments--------------->>>//
/**
 * @category	Rayzz
 * @package		Comments
 **/
class Comments extends MediaHandler
	{
		/**
		 * set the condition
		 *
		 * @access public
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'video_id=\''.addslashes($this->fields_arr['video_id']).'\'';
			}

		public function buildSortQuery()
			{
				$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}

		public function populateComments()
			{
				global $smartyObj;
				$populateComments_arr = array();
				//$rayzz = new RayzzHandler($this->dbObj, $this->CFG);
				$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type','image_ext', 'sex');
				$this->UserDetails = array();
				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						if(!isset($this->UserDetails[$row['comment_user_id']]))
							$this->getUserDetail('user_id',$row['comment_user_id'], 'user_name');

						$name = $this->getUserDetail('user_id',$row['comment_user_id'], 'user_name');;
						//$profileIcon = $rayzz->getProfileIconDetails($this->UserDetails[$row['comment_user_id']]['icon_id'], $this->UserDetails[$row['comment_user_id']]['icon_type'], $row['comment_user_id'], $this->UserDetails[$row['comment_user_id']]['image_ext'], $this->UserDetails[$row['comment_user_id']]['sex']);
						$profileIcon =getMemberAvatarDetails($name);
						$row['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
					//	$row['comment'] = nl2br($row['comment']);
						$populateComments_arr[$inc]['record'] = $row;
						$populateComments_arr[$inc]['UserDetails'] = $name;
						$populateComments_arr[$inc]['profileIcon'] = $profileIcon;
						$inc++;
					}
				$smartyObj->assign('populateComments_arr', $populateComments_arr);
			}

		public function deleteSelectedComments()
			{
				if($this->fields_arr['cid'])
					{
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['video_comments'].' WHERE'.
								' video_comment_id IN('.$this->fields_arr['cid'].')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if($affect = $this->dbObj->Affected_Rows())
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET total_comments=total_comments-'.$affect.
										' WHERE video_id='.$this->dbObj->Param('video_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
								    if (!$rs)
									    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

								return true;
							}
					}
				return false;
			}

		public function updateVideoComments()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_comments'].
						' SET comment='.$this->dbObj->Param('comment').' WHERE'.
						' video_comment_id='.$this->dbObj->Param('video_comment_id');

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
$commetns->setFormField('video_id', '');
$commetns->setFormField('cid', '');
$commetns->setFormField('new_cid', '');
$commetns->setFormField('new_comment', '');

/*********** Page Navigation Start *********/
$commetns->setFormField('orderby_field', 'video_comment_id');
$commetns->setFormField('orderby', 'DESC');

$commetns->setTableNames(array($CFG['db']['tbl']['video_comments']));
$commetns->setReturnColumns(array('video_comment_id', 'comment_user_id', 'comment', 'TIMEDIFF(NOW(), date_added) AS date_added'));
/************ page Navigation stop *************/

$commetns->setPageBlockShow('comments_list');
$commetns->sanitizeFormInputs($_REQUEST);

if($commetns->isFormPOSTed($_POST, 'updateSubmit'))
	{
		$commetns->updateVideoComments();
		$commetns->setPageBlockShow('block_msg_form_success');
		$commetns->setCommonSuccessMsg($LANG['msg_success_updated']);
	}
else if($commetns->isFormPOSTed($_POST, 'delete_add'))
	{
		if($commetns->deleteSelectedComments())
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
				$commetns->comments_list['hidden_arr'] = array('start', 'video_id');
				$commetns->populateComments();
				$paging_arr = array('video_id');
				$smartyObj->assign('smarty_paging_list', $commetns->populatePageLinksGET($commetns->getFormField('start'), $paging_arr));
			}
	}
$commetns->left_navigation_div = 'videoMain';
//include the header file
$commetns->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'video');
$smartyObj->display('manageVideoComments.tpl');
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