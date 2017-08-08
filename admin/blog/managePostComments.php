<?php
/**
 * * This file is to manage post comments
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
$CFG['site']['is_module_page'] = 'blog';
$CFG['lang']['include_files'][] = 'languages/%s/blog/admin/managePostComments.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header_no_header.php';
$CFG['html']['footer'] = 'admin/html_footer_no_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

//--------------class Comments--------------->>>//
/**
 * @category	Rayzz
 * @package		Comments
 **/
class Comments extends BlogHandler
	{
		/**
		 * set the condition
		 *
		 * @access public
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'blog_post_id=\''.addslashes($this->fields_arr['blog_post_id']).'\'';
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
				$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type','image_ext', 'sex');
				$this->UserDetails = array();

				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						if(!isset($this->UserDetails[$row['comment_user_id']]))
							$this->getUserDetail('user_id',$row['comment_user_id'], 'user_name');

						$name = $this->getUserDetail('user_id',$row['comment_user_id'], 'user_name');
						$profileIcon = getMemberAvatarDetails($row['comment_user_id']);
						$row['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
						$populateComments_arr[$inc]['record'] = $row;
						$populateComments_arr[$inc]['UserDetails'] = $name;
						$populateComments_arr[$inc]['profileIcon'] = $profileIcon;
						$populateComments_arr[$inc]['commentUserProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $name);
						$inc++;
					}

				$smartyObj->assign('populateComments_arr', $populateComments_arr);
			}
		/**
		 * Comments::deleteSelectedComments()
		 *
		 * @return
		 */
		public function deleteSelectedComments()
			{
				if($this->fields_arr['cid'])
					{
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['blog_comments'].' WHERE'.
								' blog_comment_id IN('.$this->fields_arr['cid'].')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						if($affect = $this->dbObj->Affected_Rows())
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET total_comments=total_comments-'.$affect.
										' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
								    if (!$rs)
									    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

								return true;
							}
					}
				return false;
			}
		/**
		 * Comments::updatePostComments()
		 *
		 * @return
		 */
		public function updatePostComments()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_comments'].
						' SET comment='.$this->dbObj->Param('comment').' WHERE'.
						' blog_comment_id='.$this->dbObj->Param('blog_comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['new_comment'], $this->fields_arr['new_cid']));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
	}
//<<<<<<<--------------class Comments---------------//

//--------------------Code begins-------------->>>>>//
$comments = new Comments();
$comments->setPageBlockNames(array('form_confirm', 'comments_list'));

$comments->setAllPageBlocksHide();
$comments->setFormField('blog_post_id', '');
$comments->setFormField('cid', '');
$comments->setFormField('new_cid', '');
$comments->setFormField('new_comment', '');

/*********** Page Navigation Start *********/
$comments->setFormField('orderby_field', 'blog_comment_id');
$comments->setFormField('orderby', 'DESC');

$comments->setTableNames(array($CFG['db']['tbl']['blog_comments']));
$comments->setReturnColumns(array('blog_comment_id', 'comment_user_id', 'comment', 'TIMEDIFF(NOW(), date_added) AS date_added'));
/************ page Navigation stop *************/

$comments->setPageBlockShow('comments_list');
$comments->sanitizeFormInputs($_REQUEST);

if($comments->isFormPOSTed($_POST, 'updateSubmit'))
	{
		$comments->updatePostComments();
		$comments->setPageBlockShow('block_msg_form_success');
		$comments->setCommonSuccessMsg($LANG['managepostcomments_msg_success_updated']);
	}
else if($comments->isFormPOSTed($_POST, 'delete_add'))
	{
		if($comments->deleteSelectedComments())
			{
				$comments->setPageBlockShow('block_msg_form_success');
				$comments->setCommonSuccessMsg($LANG['managepostcomments_msg_success_deleted']);
			}
	}

//<<<<--------------------Code Ends----------------------//

if ($comments->isShowPageBlock('comments_list'))
	{
		/****** navigtion continue*********/
		$comments->buildSelectQuery();
		$comments->buildConditionQuery();
		$comments->buildSortQuery();
		$comments->buildQuery();
		//$comments->printQuery();
		$comments->executeQuery();

		if($comments->isResultsFound())
			{
				$comments->anchor = 'dAltMlti';
				$comments->comments_list['hidden_arr'] = array('start', 'blog_post_id');
				$comments->populateComments();
				$paging_arr = array('blog_post_id');
				$smartyObj->assign('smarty_paging_list', $comments->populatePageLinksGET($comments->getFormField('start'), $paging_arr));
			}
	}

//include the header file
$comments->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'blog');
$smartyObj->display('managePostComments.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirmDelete');
	function changeSubmitText(cid)
		{
			var obj = eval('document.form_comments_list.commentText_'+cid);
			document.form_comments_list.new_comment.value = obj.value;
			document.form_comments_list.new_cid.value = cid;
			return true;
		}
</script>
<?php
$comments->includeFooter();
?>