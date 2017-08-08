<?php
/**
 * This file is to manage the post
 *
 * This file is having postManage class to manage the blog posts
 *
 *
 * @category	Rayzz
 * @package		Admin
 *
 **/
require_once('../../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'blog';
$CFG['lang']['include_files'][] = 'languages/%s/blog/admin/postManage.php';
$CFG['lang']['include_files'][] = 'languages/%s/blog/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_BlogHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class postManage begins -------------------->>>>>//
/**
 *
 * @category	rayzz
 * @package		Admin
 **/
class postManage extends BlogHandler
	{
		public $sql_condition = '';
		public $sql_sort = '';
		public $fields_arr = '';
		public $sql='';
		public $blog_category_name = array();

		/**
		 * postManage::buildConditionQuery()
		 *
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = '';
			}

		/**
		 * postManage::buildSortQuery()
		 *
		 * @return void
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'v.blog_post_id DESC';
			}

		/**
		 * postManage::getBlogCategory()
		 *
		 * @param integer $blog_category_id
		 * @return array
		 */
		public function getBlogCategory($blog_category_id)
			{
				if(isset($this->blog_category_name[$blog_category_id]))
					return $this->blog_category_name[$blog_category_id];

				if($blog_category_id == 0)
					return;

				$this->blog_category_name[$blog_category_id] = '';

				$sql = 'SELECT blog_category_name FROM '.$this->CFG['db']['tbl']['blog_category'].
						' WHERE blog_category_id='.$this->dbObj->Param('blog_category_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($blog_category_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->blog_category_name[$blog_category_id] = $row['blog_category_name'];
					}
				return $this->blog_category_name[$blog_category_id];
			}

		/**
		 * postManage::populateAdminBlogCategory()
		 *
		 * @return void
		 */
		public function populateAdminBlogCategory($srch_categories = false)
			{
				$populateAdminBlogCategory = '';
				$sql = 'SELECT blog_category_id, blog_category_name FROM '.$this->CFG['db']['tbl']['blog_category'].
						' WHERE parent_category_id=0 AND blog_category_status=\'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$populateAdminBlogCategory .= '<option value="'.$row['blog_category_id'].'" class="selectBlogCategory"';

								if($srch_categories == $row['blog_category_id'])
									$populateAdminBlogCategory .= ' selected="selected"';

								$populateAdminBlogCategory .= '>'.$row['blog_category_name'].'</option>';
								/*if($this->CFG['admin']['blog']['sub_category'])
									{
										$populateAdminBlogCategory .= $this->populateAdminBlogSubCategory($row['blog_category_id'], $srch_categories);
									}*/
							}
					}
				return $populateAdminBlogCategory;
			}

		/**
		 * postManage::populateAdminBlogSubCategory()
		 *
		 * @return void
		 */
		public function populateAdminBlogSubCategory($category_id, $srch_categories = false)
			{
				$populateAdminBlogSubCategory = '';
				$sql = 'SELECT blog_category_id, blog_category_name FROM '.$this->CFG['db']['tbl']['blog_category'].
						' WHERE parent_category_id='.$category_id.' AND blog_category_status=\'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$populateAdminBlogSubCategory .= '<option value="'.$row['blog_category_id'].'" class="selectBlogSubCategory"';

								if($srch_categories == $row['blog_category_id'])
									$populateAdminBlogSubCategory .= ' selected="selected"';

								$populateAdminBlogSubCategory .= '>'.$row['blog_category_name'].'</option>';
							}
						return $populateAdminBlogSubCategory;
					}
				return;
			}
		/**
		 * postManage::getTotalComments()
		 *
		 * @param mixed $blog_post_id
		 * @return
		 */
		public function getTotalComments($blog_post_id)
			{
				$sql = 'SELECT COUNT(blog_comment_id) AS total_comments FROM '.$this->CFG['db']['tbl']['blog_comments'].
					   ' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($blog_post_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				 if($row = $rs->FetchRow())
				   return $row['total_comments'];
				return 0;
			}
		/**
		 * postManage::displayPostList()
		 * This method helps to display the list of post
		 *
		 * @return void
		 **/
		public function displayPostList()
			{
				global $smartyObj;
				$displaypostList_arr = array();

				$fields_list = array('user_name', 'first_name', 'last_name');
				$displaypostList_arr['row'] = array();
				$inc = 1;
				while($row = $this->fetchResultRecord())
					{
						if(!isset($row['user_name']))
							{
								if(!isset($this->UserDetails[$row['user_id']]))
									$this->getUserDetail('user_id',$row['user_id'], 'user_name');

								$displaypostList_arr['row'][$inc]['name'] = $this->getUserName($row['user_id']);
							}
						else
							{
								$name = $this->CFG['format']['name'];
								$name = str_replace('$first_name', $row['first_name'],$name);
								$name = str_replace('$last_name', $row['last_name'],$name);
								$name = str_replace('$user_name', $row['user_name'],$name);
								$displaypostList_arr['row'][$inc]['name'] = $name;
							}

						$row['flagged_status'] = $row['flagged_status']?$row['flagged_status']:'No';
						$row['featured'] = $row['featured']?$row['featured']:'No';
						$displaypostList_arr['row'][$inc]['comments_text'] = str_replace('{total_comments}', $this->getTotalComments($row['blog_post_id']), $this->LANG['postmanage_post_comments']);

						$displaypostList_arr['row'][$inc]['record'] = $row;
						$inc++;
					}

				$smartyObj->assign('displaypostList_arr', $displaypostList_arr);
			}

		/**
		 * postManage::getSearchCondition()
		 *
		 * @return string
		 */
		public function getSearchCondition()
		    {
				$search_condition = '';
				if ($this->fields_arr['srch_uname'])
					{
						$search_condition .= ' AND u.user_name LIKE \'%'.addslashes($this->fields_arr['srch_uname']).'%\'';
					}
				if ($this->fields_arr['srch_title'])
					{
						$search_condition .= ' AND bp.blog_post_name LIKE \'%'.addslashes($this->fields_arr['srch_title']).'%\'';
					}
				if ($this->fields_arr['srch_flag'] == 'No')
					{
						$search_condition .= ' AND bp.flagged_status != \'Yes\'';
					}
				if ($this->fields_arr['srch_flag'] == 'Yes')
					{
						$search_condition .= ' AND bp.flagged_status = \'Yes\'';
					}
				if ($this->fields_arr['srch_categories'])
					{
						$search_condition .= ' AND (bp.blog_category_id = \''.addslashes($this->fields_arr['srch_categories']).'\' OR bp.blog_sub_category_id = \''.addslashes($this->fields_arr['srch_categories']).'\')';
					}
				if ($this->fields_arr['srch_feature'])
					{
						$search_condition .= ' AND bp.featured = \''.addslashes($this->fields_arr['srch_feature']).'\'';
					}
				if ($this->fields_arr['srch_date_added'])
					{
						$search_condition .= ' AND bp.date_added >= \''.$this->getFormField('srch_date_added').' 00:00:00\'';
						$search_condition .= ' AND bp.date_added <= DATE_ADD(\''.$this->getFormField('srch_date_added').' 00:00:00\', INTERVAL 1 DAY)';
					}
				return $search_condition;
		    }
		public function switchCase($casename, $method)
			{
				$search_condition = $this->getSearchCondition();
			}

		public function deletePost()
			{
				$post_details = explode(',', $this->fields_arr['checkbox']);
				if($this->fields_arr['action']=='Delete')
					{
						foreach($post_details as $post_key=>$post_value)
							{
								$post_arr = explode('-',$post_value);
								$blog_post_id = $post_arr[0];
								$user_id = $post_arr[1];
								$this->deleteBlogPosts(array($blog_post_id), $user_id);
							}
					}
				else if($this->fields_arr['action']=='Flag')
					{
						foreach($post_details as $post_key=>$post_value)
							{
								$post_arr = explode('-',$post_value);
								$flag[] = $post_arr[0];
							}
						$post_list = implode(',',$flag);

						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
								' content_type=\'Blog\' AND content_id IN('.$post_list.')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						   trigger_db_error($this->dbObj);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET flagged_status=\'Yes\''.
								' WHERE blog_post_id IN('.$post_list.')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						    trigger_db_error($this->dbObj);

					}
				else if($this->fields_arr['action']=='UnFlag')
					{
						foreach($post_details as $post_key=>$post_value)
							{
								$post_arr = explode('-',$post_value);
								$flag[] = $post_arr[0];
							}
						$post_list = implode(',',$flag);

						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
								' content_type=\'Blog\' AND content_id IN('.$post_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						    trigger_db_error($this->dbObj);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET flagged_status=\'No\''.
								' WHERE blog_post_id IN('.$post_list.')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						   trigger_db_error($this->dbObj);
					}
				else if($this->fields_arr['action']=='Featured')
					{
						foreach($post_details as $post_key=>$post_value)
							{
								$post_arr = explode('-',$post_value);
								$flag[] = $post_arr[0];
							}
						$post_list = implode(',',$flag);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET featured=\'Yes\''.
								' WHERE blog_post_id IN('.$post_list.')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						   trigger_db_error($this->dbObj);
					}
				else if($this->fields_arr['action']=='UnFeatured')
					{
						foreach($post_details as $post_key=>$post_value)
							{
								$post_arr = explode('-',$post_value);
								$flag[] = $post_arr[0];
							}
						$post_list = implode(',',$flag);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET featured=\'No\''.
								' WHERE blog_post_id IN('.$post_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						   trigger_db_error($this->dbObj);
					}
				else if($this->fields_arr['action']=='Move')
					{
						foreach($post_details as $post_key=>$post_value)
							{
								$post_arr = explode('-',$post_value);
								$flag[] = $post_arr[0];
							}
						$post_list = implode(',',$flag);

						if($parent_id=$this->isParentExists($this->fields_arr['blog_categories']))
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET '.
										' blog_category_id= \''.$parent_id.'\', '.
										' blog_sub_category_id = \''.$this->fields_arr['blog_categories'].'\' '.
										' WHERE blog_post_id IN('.$post_list.')';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
								    trigger_db_error($this->dbObj);
							}
						else
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET '.
										' blog_sub_category_id=0, blog_category_id='.$this->dbObj->Param('blog_categories').
										' WHERE blog_post_id IN('.$post_list.')';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_categories']));
								if (!$rs)
								    trigger_db_error($this->dbObj);
							}
					}
				return true;
			}

		/**
		 * postManage::isParentExists()
		 *
		 * @param Integer $cid
		 * @return boolean
		 */
		public function isParentExists($cid)
			{
				$sql = 'SELECT parent_category_id FROM '.$this->CFG['db']['tbl']['blog_category']. ' WHERE blog_category_id =\''.$cid.'\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						return $row['parent_category_id'];
					}
				return false;
			}
	}
//<<<<<-------------- Class obj begins ---------------//
//-------------------- Code begins -------------->>>>>//
$postmanage = new postManage();
$postmanage->setPageBlockNames(array('browse_posts', 'form_search', 'list_post_form', 'set_flag'));

//default form fields and values...
$postmanage->setReturnColumns(array());
$postmanage->setTableNames(array());
$postmanage->setFormField('list', '');
$postmanage->setFormField('blog_post_id', '');
$postmanage->setFormField('submit', '');
$postmanage->setFormField('subcancel', '');

$postmanage->setFormField('action', '');
$postmanage->setFormField('delete', '');
$postmanage->setFormField('confirmdel', '');
$postmanage->setFormField('checkbox', array());

$postmanage->setFormField('srch_uname', '');
$postmanage->setFormField('srch_title', '');
$postmanage->setFormField('srch_flag', '');
$postmanage->setFormField('srch_feature', '');
$postmanage->setFormField('srch_date_added', '');
$postmanage->setFormField('srch_date', '');
$postmanage->setFormField('srch_month', '');
$postmanage->setFormField('srch_year', '');
$postmanage->setFormField('srch_categories', '');
$postmanage->setFormField('blog_categories', '');
$postmanage->setMonthsListArr($LANG_LIST_ARR['months']);
$postmanage->setFormField('numpg', $CFG['blog_tbl']['numpg']);

$postmanage->setFormField('check_box', '');
$postmanage->setFormField('post_options', '');
/*********** Page Navigation Start *********/
$postmanage->setFormField('slno', '1');
//$postmanage->populateAdminBlogCategory();
/************ page Navigation stop *************/
$postmanage->setAllPageBlocksHide();
$postmanage->setPageBlockShow('browse_posts');
/******************************************************/
$postmanage->setTableNames(array($postmanage->CFG['db']['tbl']['blog_posts'].' as bp LEFT JOIN '.$postmanage->CFG['db']['tbl']['users'].' as u ON bp.user_id=u.user_id AND u.usr_status=\'Ok\''));
$postmanage->setReturnColumns(array('bp.blog_post_id', 'bp.user_id', 'bp.blog_post_name', 'DATE_FORMAT(bp.date_added,\''.$postmanage->CFG['format']['date'].'\') as date_added', 'u.user_name', 'u.first_name', 'u.last_name', 'bp.featured','bp.flagged_status','bp.status', 'blog_category_id', 'bp.total_comments', 'blog_sub_category_id'));
$postmanage->sql_condition = 'bp.status=\'Ok\'';
$postmanage->sql_sort = '';

$postmanage->left_navigation_div = 'blogMain';

//					$postmanage->setAllPageBlocksHide();
$postmanage->sanitizeFormInputs($_REQUEST);
$postmanage->setPageBlockShow('list_post_form');
$postmanage->setPageBlockShow('form_search');
/******************************************************/
if ($postmanage->getFormField('srch_date') || $postmanage->getFormField('srch_month') || $postmanage->getFormField('srch_year'))
	{
		$postmanage->chkIsCorrectDate($postmanage->getFormField('srch_date'), $postmanage->getFormField('srch_month'), $postmanage->getFormField('srch_year'), 'srch_date_added', $LANG['postmanage_err_tip_date_empty'], $LANG['postmanage_err_tip_date_invalid']);
    }
$srch_condition = $postmanage->getSearchCondition();
if ($srch_condition)
	$postmanage->sql_condition .= $srch_condition;

if($postmanage->isFormGETed($_POST,'reset'))
	{
			Redirect2URL($CFG['site']['url'].'admin/blog/postManage.php');
	}

if($postmanage->isFormGETed($_POST,'submit'))
	{
		$casename = $_POST['list'];
		$postmanage->switchCase($casename, 'post');
	}

if($postmanage->isFormGETed($_POST,'search'))
	{
		$casename = $_POST['list'];
		$postmanage->switchCase($casename, 'post');
	}

if($postmanage->isFormGETed($_POST,'start'))
	{
		$casename = $_POST['list'];
		$postmanage->switchCase($casename, 'post');
	}

if($postmanage->isFormGETed($_GET,'list') && !$postmanage->isFormGETed($_GET,'action'))
	{
		$casename = $_GET['list'];
		$postmanage->switchCase($casename, 'get');
	}

if($postmanage->isFormGETed($_GET,'list') && $postmanage->isFormGETed($_GET,'action'))
	{
		$postmanage->setAllPageBlocksHide();
		$postmanage->setPageBlockShow('set_flag');
	}

if($postmanage->isFormGETed($_POST,'subcancel'))
	{
		$casename = $_POST['list'];
		$postmanage->switchCase($casename, 'post');
	}
if($postmanage->isFormGETed($_POST,'confirmdel'))
	{
		$casename = $_POST['list'];
		$postmanage->switchCase($casename, 'post');
		if($postmanage->deletePost())
			{
				$postmanage->setCommonSuccessMsg($LANG['postmanage_msg_success_delete']);
				$postmanage->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$postmanage->setCommonErrorMsg($LANG['postmanage_msg_success_delete_fail']);
				$postmanage->setPageBlockShow('block_msg_form_error');
			}
	}
//<<<<<-------------------- Code ends----------------------//

$postmanage->hidden_arr = array('list', 'srch_uname', 'srch_categories', 'srch_title', 'srch_flag', 'srch_feature', 'srch_date', 'srch_month', 'srch_year', 'start');
$postmanage->current_year = date('Y');

if ($postmanage->isShowPageBlock('form_search'))
	{
		$postmanage->form_search['hidden_arr'] = array('list');
	}

if ($postmanage->isShowPageBlock('list_post_form'))
    {
		/****** navigtion continue*********/
		$postmanage->buildSelectQuery();
		$postmanage->buildQuery();
		//$postmanage->printQuery();
		if($postmanage->isGroupByQuery())
			$postmanage->homeExecuteQuery();
		else
			$postmanage->executeQuery();

		/******* Navigation End ********/
		if($postmanage->isResultsFound())
			{
				$postmanage->displayPostList();
				$smartyObj->assign('smarty_paging_list', $postmanage->populatePageLinksPOST($postmanage->getFormField('start'), 'post_manage_form2'));
				$postmanage->list_post_form['hidden_arr'] = array('list', 'srch_uname', 'srch_categories', 'srch_title',  'srch_flag', 'srch_feature', 'srch_date', 'srch_month', 'srch_year', 'start');
			}
    }
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$postmanage->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'blog');
$smartyObj->display('postManage.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript" >
	var block_arr= new Array('selMsgConfirm');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['postmanage_err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction()
		{
			var act_value = document.post_manage_form2.post_options.value;
			if(act_value)
				{
					switch (act_value)
						{
							case 'Delete':
								confirm_message = '<?php echo $LANG['postmanage_delete_confirm'];?>';
								break;
							case 'Flag':
								confirm_message = '<?php echo $LANG['postmanage_status_confirm'];?>';
								break;
							case 'UnFlag':
								confirm_message = '<?php echo $LANG['postmanage_status_confirm'];?>';
								break;
							case 'Featured':
								confirm_message = '<?php echo $LANG['postmanage_featured_confirm'];?>';
								break;
							case 'UnFeatured':
								confirm_message = '<?php echo $LANG['postmanage_unfeatured_confirm'];?>';
								break;
						}
					$Jq('#confirmMessage').html(confirm_message);
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
//<<<<<-------------------- Page block templates ends -------------------//
$postmanage->includeFooter();
?>