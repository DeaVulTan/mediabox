<?php
/**
 * This file is to manage the blog
 *
 * Provides an interface to manage blog that are not activated.
 * Post can be activated, can view full post, view comments
 * of the post, post can be edited and deleted.
 *
 * @category	Rayzz
 * @package		Admin
 *
 **/
require_once('../../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'blog';
$CFG['lang']['include_files'][] = 'languages/%s/blog/admin/manageBlog.php';
$CFG['lang']['include_files'][] = 'languages/%s/blog/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class manageBlog begins -------------------->>>>>//
/**
 * @category	Rayzz
 * @package		Admin
 **/
class manageBlog extends BlogHandler
	{
		public $sql_condition = '';
		public $sql_sort = '';
		public $fields_arr = '';
		public $file_root_path = '';
		public $sql='';
		public $blog_category_name = array();

		/**
		 * manageBlog::buildConditionQuery()
		 *
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'b.blog_status!=\'Deleted\'';
			}

		/**
		 * manageBlog::buildSortQuery()
		 *
		 * @return void
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'b.blog_id DESC';
			}
		/**
		 * manageBlog::displayPostList()
		 * This method helps to display the list of posts
		 *
		 * @return void
		 **/
		public function displayPostList()
			{
				global $smartyObj;
				$displayBlogList_arr = array();

				$anchor = 'MultiDelte';
				$fields_list = array('user_name', 'first_name', 'last_name');

				$inc = 0;
				$blog_logo_folder = $this->file_root_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['blog']['folder'].'/'.$this->CFG['admin']['blog']['blog_logo_folder'].'/';
				while($row = $this->fetchResultRecord())
					{
						if(!isset($row['user_name']))
							{
								if(!isset($this->UserDetails[$row['user_id']]))
									$this->getUserDetail('user_id',$row['user_id'], 'user_name');

								$name = $this->getUserName($row['user_id']);
							}
						else
							{
								$name = $this->CFG['format']['name'];
								$name = str_replace('$first_name', $row['first_name'],$name);
								$name = str_replace('$last_name', $row['last_name'],$name);
								$name = str_replace('$user_name', $row['user_name'],$name);
							}
						$displayBlogList_arr[$inc]['name'] = $name;
						$displayBlogList_arr[$inc]['record'] = $row;
						$displayBlogList_arr[$inc]['total_post']=getTotalPosts($row['blog_id']);
						$displayBlogList_arr[$inc]['blog_logo_src']='';
					   if($row['blog_logo_ext'])
				          $displayBlogList_arr[$inc]['blog_logo_src'] = $this->CFG['site']['url'].$blog_logo_folder.$row['user_id'].'.'.$row['blog_logo_ext'];

						$inc++;
					}
				$smartyObj->assign('displayBlogList_arr', $displayBlogList_arr);
			}


		/**
		 * manageBlog::deletePost()
		 * This function is used to set the flag for the posts.
		 *
		 * @return boolean
		 **/
		public function updateBlogTable()
			{

				$blog_details = explode(',', $this->fields_arr['checkbox']);

				if($this->fields_arr['action']=='Delete')
					{
						foreach($blog_details as $post_key=>$post_value)
							{
								$post_arr = explode('-',$post_value);
								$blog_id = $post_arr[0];
								$user_id = $post_arr[1];
								$this->deleteBlogs($blog_id, $user_id);
							}
					}
				else if($this->fields_arr['action']=='Active')
					{
						foreach($blog_details as $post_key=>$post_value)
							{
								$post_arr = explode('-',$post_value);
								$flag[] = $post_arr[0];

								 $sql = 'UPDATE '.$this->CFG['db']['tbl']['blogs'].' SET blog_status=\'Active\''.
											' WHERE blog_id IN('.$post_arr[0].')';

								 $stmt = $this->dbObj->Prepare($sql);
								 $rs = $this->dbObj->Execute($stmt);
							  	 if (!$rs)
							        trigger_db_error($this->dbObj);


					      }
					}
				return true;
			}
	}
//<<<<<-------------- Class obj begins ---------------//
//-------------------- Code begins -------------->>>>>//
$manageBlog = new manageBlog();
$manageBlog->setPageBlockNames(array('list_blog_form'));
//default form fields and values...
$manageBlog->setReturnColumns(array());
$manageBlog->setTableNames(array());
$manageBlog->setFormField('list', '');
$manageBlog->setFormField('blog_post_id', '');
$manageBlog->setFormField('submit', '');
$manageBlog->setFormField('subcancel', '');
$manageBlog->setFormField('action', '');
$manageBlog->setFormField('delete', '');
$manageBlog->setFormField('confirmdel', '');
$manageBlog->setFormField('checkbox', array());
$manageBlog->setMonthsListArr($LANG_LIST_ARR['months']);
$manageBlog->setFormField('check_box', '');
$manageBlog->setFormField('post_options', '');
/*********** Page Navigation Start *********/
$manageBlog->setFormField('slno', '1');
$manageBlog->left_navigation_div = 'blogMain';

/************ page Navigation stop *************/
$manageBlog->setAllPageBlocksHide();
/******************************************************/
$manageBlog->setTableNames(array($manageBlog->CFG['db']['tbl']['blogs'].' as b LEFT JOIN '.$manageBlog->CFG['db']['tbl']['users'].' as u ON b.user_id=u.user_id AND u.usr_status=\'Ok\''));
$manageBlog->setReturnColumns(array('b.blog_id', 'b.user_id', 'b.blog_name', 'b.blog_title', 'DATE_FORMAT(b.date_added,\''.$manageBlog->CFG['format']['date'].'\') as date_added', 'u.user_name', 'u.first_name', 'u.last_name', 'b.blog_logo_ext', 'b.blog_status'));
//$manageBlog->sql_sort = '';
//$manageBlog->setAllPageBlocksHide();
$manageBlog->sanitizeFormInputs($_REQUEST);
$manageBlog->setPageBlockShow('list_blog_form');
/******************************************************/

if($manageBlog->isFormGETed($_POST,'confirmdel'))
	{
		if($manageBlog->updateBlogTable())
			{
				$manageBlog->setCommonSuccessMsg($manageBlog->LANG['manageblog_msg_success_delete']);
				$manageBlog->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$manageBlog->setCommonErrorMsg($manageBlog->LANG['manageblog_msg_success_delete_fail']);
				$manageBlog->setPageBlockShow('block_msg_form_error');
			}
	}
//<<<<<-------------------- Code ends----------------------//

$manageBlog->hidden_arr = array('start');

if ($manageBlog->isShowPageBlock('list_blog_form'))
    {
		/****** navigtion continue*********/
		$manageBlog->buildSelectQuery();
		$manageBlog->buildConditionQuery();
		$manageBlog->buildSortQuery();
		$manageBlog->buildQuery();
		//$manageBlog->printQuery();
		$manageBlog->executeQuery();

		/******* Navigation End ********/
		if($manageBlog->isResultsFound())
			{
				$manageBlog->displayPostList();
				$smartyObj->assign('smarty_paging_list', $manageBlog->populatePageLinksPOST($manageBlog->getFormField('start'), 'post_manage_form2'));
				$manageBlog->list_blog_form['hidden_arr'] = array('start');
			}
    }

//include the header file
$manageBlog->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'blog');
$smartyObj->display('manageBlog.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript" >
	var block_arr= new Array('selMsgConfirm');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['manageblog_err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction(act_value)
		{
			if(act_value)
				{
					switch (act_value)
						{
							case 'Active':
								confirm_message = '<?php echo $LANG['manageblog_activate_confirmation'];?>';
								break;
							case 'Delete':
								confirm_message = '<?php echo $LANG['manageblog_delete_confirmation'];?>';
								break;
						}
					$Jq('confirmMessage').html(confirm_message);
					document.msgConfirmform.action.value = act_value;
					Confirmation('selMsgConfirm', 'msgConfirmform', Array('checkbox'), Array(multiCheckValue), Array('value'), -25, -290);
				}
			else
				alert_manual(please_select_action);
		}
	function popupWindow(url)
		{
			 window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
			 return false;
		}
</script>
<?php
$manageBlog->includeFooter();
?>