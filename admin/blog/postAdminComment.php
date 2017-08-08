<?php
/**
 * * This file is to manage admin comments about article
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
$CFG['mods']['include_files'][] = 'common/classes/class_Image.lib.php';
$CFG['lang']['include_files'][] = 'languages/%s/blog/admin/postAdminComment.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogHandler.lib.php';
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
class AdminComments extends BlogHandler
	{

		/**
		 * AdminComments::chkIsValidPostId()
		 *
		 * @return boolean
		 **/
		public function chkIsValidPostId()
			{
				$sql ='SELECT COUNT(DISTINCT bp.blog_post_id) AS blog_post_id FROM'.
						' '.$this->CFG['db']['tbl']['blog_posts'].' as bp'.
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u'.
						' ON bp.user_id=u.user_id'.
						' WHERE bp.blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				if($row['blog_post_id'])
					{
						return true;
					}
				return false;
			}

		/**
		 * AdminComments::populatePostDetail()
		 *
		 * @return boolean
		 **/
		public function populatePostDetail()
			{
				global $smartyObj;
				$populatePost_arr = array();
				$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type','image_ext', 'sex');
				$this->UserDetails = array();

				$sql = 'SELECT bp.rating_total, bp.rating_count, bp.user_id, bp.blog_post_name,'.
						' bp.message, bp.blog_admin_comments, DATE_FORMAT(date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
						' u.user_name, u.first_name, u.last_name'.
						' FROM '.$this->CFG['db']['tbl']['blog_posts'].' as bp'.
						' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' as u ON bp.user_id=u.user_id'.
						' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
				if (!$rs)
				        trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
					{
						if(!isset($this->UserDetails[$row['user_id']]))
							$this->getUserDetail('user_id',$row['user_id'], 'user_name');

						$user_name=$this->getUserDetail('user_id',$row['user_id'], 'user_name');
						$profileIcon = getMemberAvatarDetails($row['user_id']);
						$populatePost_arr['user_id'] = $this->fields_arr['user_id'] = $row['user_id'];
						$populatePost_arr['blog_post_name'] = $this->fields_arr['blog_post_name'] = $row['blog_post_name'];
						$populatePost_arr['blog_admin_comments'] = $this->fields_arr['blog_admin_comments'] = $row['blog_admin_comments'];
						$populatePost_arr['date_added'] = $this->fields_arr['date_added'] = ($row['date_added'] != '') ? getTimeDiffernceFormat($row['date_added']) : '';
						$populatePost_arr['UserDetails'] = $user_name;
						$populatePost_arr['profileIcon'] = $profileIcon;
						$populatePost_arr['postOwnerProfileUrl'] = getMemberProfileUrl($row['user_id'], $row['user_name']);
						$smartyObj->assign('populatePost_arr', $populatePost_arr);
						return true;
					}
				$smartyObj->assign('populatePost_arr', $populatePost_arr);
				return false;
			}

		/**
		 * AdminComments::updatePostComments()
		 *
		 * @return boolean
		 **/
		public function updatePostComments()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].
						' SET blog_admin_comments='.$this->dbObj->Param('blog_admin_comments').' WHERE'.
						' blog_post_id='.$this->dbObj->Param('blog_post_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_admin_comments'], $this->fields_arr['blog_post_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				return true;
			}
	}
//<<<<<<<--------------class Comments---------------//

//--------------------Code begins-------------->>>>>//
$admincomments = new AdminComments();
$admincomments->setPageBlockNames(array('form_confirm', 'show_admin_comment'));

$admincomments->setAllPageBlocksHide();
$admincomments->setFormField('blog_post_id', '');
$admincomments->setFormField('blog_admin_comments', '');

$admincomments->setPageBlockShow('show_admin_comment');
$admincomments->sanitizeFormInputs($_REQUEST);

if($admincomments->isFormPOSTed($_POST, 'updateSubmit'))
	{
		$admincomments->chkIsNotEmpty('blog_admin_comments', $admincomments->LANG['common_err_tip_required']);
		if($admincomments->isValidFormInputs())
			{
				$admincomments->updatePostComments();
				$admincomments->setPageBlockShow('block_msg_form_success');
				$admincomments->setCommonSuccessMsg($LANG['postadmincomment_msg_success_updated']);
			}
		else
			{
				$admincomments->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$admincomments->setPageBlockShow('block_msg_form_error');
			}
	}
else if($admincomments->isFormPOSTed($_POST, 'delete_add'))
	{
		if($admincomments->deleteSelectedComments())
			{
				$admincomments->setPageBlockShow('block_msg_form_success');
				$admincomments->setCommonSuccessMsg($LANG['postadmincomment_msg_success_deleted']);
			}
	}

//<<<<--------------------Code Ends----------------------//

if ($admincomments->isShowPageBlock('show_admin_comment'))
	{

		if(!$admincomments->chkIsValidPostId())
			{
				$admincomments->setAllPageBlocksHide();
				$admincomments->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$admincomments->setPageBlockShow('block_msg_form_error');
			}
		else
			{
				$admincomments->populatePostDetail();

			}
	}

//include the header file
$admincomments->includeHeader();

?>
<?php
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'blog');
$smartyObj->display('postAdminComment.tpl');
?>
<?php
/* Added code to validate mandataory fields in photo defaut settings page */
if ($CFG['feature']['jquery_validation'])
{
?>
<script type="text/javascript">
$Jq("#form_comments_list").validate({
	rules: {
	    blog_admin_comments: {
	    	required: true
		 }
	},
	messages: {
		blog_admin_comments: {
			required: "<?php echo $LANG['common_err_tip_required'];?>"
		}
	}
});
</script>
<?php
}
//<<<<<-------------------- Page block templates ends -------------------//
$admincomments->includeFooter();
?>