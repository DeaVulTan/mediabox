<?php
/**
 * This file is to manage the posts
 *
 * Provides an interface to manage post that are not activated.
 * Post can be activated, can view full post, view comments
 * of the post, post can be edited and deleted.
 *
 * @category	Rayzz
 * @package		Admin
 *
 **/
require_once('../../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'blog';
$CFG['lang']['include_files'][] = 'languages/%s/blog/admin/postActivate.php';
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
//---------------------------- Class postActivate begins -------------------->>>>>//
/**
 * @category	Rayzz
 * @package		Admin
 **/
class postActivate extends BlogHandler
	{
		public $sql_condition = '';
		public $sql_sort = '';
		public $fields_arr = '';
		public $sql='';
		public $blog_category_name = array();

		/**
		 * postActivate::buildConditionQuery()
		 *
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'bp.status=\'ToActivate\'';
			}

		/**
		 * postActivate::buildSortQuery()
		 *
		 * @return void
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'bp.blog_post_id DESC';
			}

		/**
		 * postActivate::getBlogCategory()
		 *
		 * @param Integer $blog_category_id
		 * @return void
		 */
		public function getBlogCategory($blog_category_id)
			{
				if(isset($this->blog_category_name[$blog_category_id]))
					return $this->blog_category_name[$blog_category_id];

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
		 * postActivate::populateThisBlogCategory()
		 *
		 * @return void
		 */
		public function populateThisBlogCategory()
			{
				$sql = 'SELECT blog_category_id, blog_category_name FROM '.$this->CFG['db']['tbl']['blog_category'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$this->blog_category_name[$row['blog_category_id']] = $row['blog_category_name'];
							}
					}
			}

		/**
		 * postActivate::sendMailToUserForDelete()
		 *
		 * @return boolean
		 **/
		public function sendMailToUserForDisapproval($blog_post_id)
			{
				$this->populateBlogPostDetails($blog_post_id);
				$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $this->LANG['blog_post_disapproved_subject']);
				$body = $this->LANG['blog_post_disapproved_content'];
				$blog_post_link = getUrl('viewpost','?blog_post_id='.$this->BLOG_POST_ID.$this->changeTitle($this->BLOG_POST_NAME),
								$this->BLOG_POST_ID.'/'.$this->changeTitle($this->BLOG_POST_NAME).'/', 'root','blog');
				$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
				$body = str_replace('VAR_USER_NAME', $this->BLOG_USER_NAME, $body);
				$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
				$body = str_replace('VAR_BLOG_POST_NAME', $this->BLOG_POST_NAME, $body);
				$body = str_replace('VAR_ADMIN_COMMENTS_FOR_POST_DISAPPORVAL', ($this->BLOG_ADMIN_COMMENTS)?$this->BLOG_ADMIN_COMMENTS:$this->LANG['postactivate_admin_comment_default_msg'], $body);
				$body = str_replace('VAR_BLOG_POST_LINK', '<a href=\''.$blog_post_link.'\'>'.$blog_post_link.'</a>', $body);
				$body=nl2br($body);

				if($this->_sendMail($this->BLOG_USER_EMAIL, $subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']))
					return true;
				else
					return false;
			}

		/**
		 * postActivate::populateBlogPostDetails()
		 *
		 * @return boolean
		 **/
		public function populateBlogPostDetails($blog_post_id)
			{
				$sql = 'SELECT bp.blog_post_id, bp.blog_post_name, bp.blog_category_id, bp.blog_post_id, bp.message,bp.blog_admin_comments, bp.date_of_publish,'.
						'u.user_name, u.email, u.user_id, relation_id FROM '.
						$this->CFG['db']['tbl']['blog_posts'].' as bp LEFT JOIN '.$this->CFG['db']['tbl']['users'].
						' as u ON bp.user_id=u.user_id WHERE'.
						' blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($blog_post_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
				{
					$this->BLOG_POST_ID 		  = $row['blog_post_id'];
					$this->BLOG_POST_NAME 		  = $row['blog_post_name'];
					$this->BLOG_CATEGORY_ID 	  = $row['blog_category_id'];
					$this->BLOG_USER_NAME 		  = $row['user_name'];
					$this->BLOG_USER_EMAIL 		  = $row['email'];
					$this->BLOG_USER_ID 		  = $row['user_id'];
					$this->BLOG_PUBLISH_DATE 	  = $row['date_of_publish'];
					$this->BLOG_ADMIN_COMMENTS 	  = $row['blog_admin_comments'];
					$this->BLOG_RELATION_ID       = $row['relation_id'];
					$this->BLOG_DESCRIPTION       = $row['message'];
					$this->BLOG_DESCRIPTION       = $row['message'];
					return true;
				}
				return false;
			}

		/**
		 * postActivate::displayPostList()
		 * This method helps to display the list of posts
		 *
		 * @return void
		 **/
		public function displayPostList()
			{
				global $smartyObj;
				$displayPostList_arr = array();

				$anchor = 'MultiDelte';
				$fields_list = array('user_name', 'first_name', 'last_name');

				$inc = 0;
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
						$displayPostList_arr[$inc]['name'] = $name;
						$row['flagged_status'] = $row['flagged_status']?$row['flagged_status']:'No';
						$displayPostList_arr[$inc]['record'] = $row;
						$displayPostList_arr[$inc]['comments_text'] = str_replace('{total_comments}', $row['total_comments'], $this->LANG['postactivate_post_comments']);

						$inc++;
					}
				$smartyObj->assign('displayPostList_arr', $displayPostList_arr);
			}


		/**
		 * postActivate::deletePost()
		 * This function is used to set the flag for the posts.
		 *
		 * @return boolean
		 **/
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
				else if($this->fields_arr['action']=='Ok')
					{
						foreach($post_details as $post_key=>$post_value)
							{
								$post_arr = explode('-',$post_value);
								$flag[] = $post_arr[0];

								//$post_list = implode(',',$flag);
								//Code to set posts status as ok or infuture based on publish date
								if($this->populateBlogPostDetails($post_arr[0]))
								{
									$publishDate = $this->BLOG_PUBLISH_DATE;
									$currentDate   = date("Y-m-d");

									if($publishDate > $currentDate)
										$postStatus = 'InFuture';
									else
										$postStatus = 'Ok';

									$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET status=\''.$postStatus.'\''.
											' WHERE blog_post_id IN('.$post_arr[0].')';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt);
									if (!$rs)
								        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

									//Code to send mail, increase post count and update post activty table if post status is set as ok
								    if($postStatus == 'Ok')
									{
										if(!$this->chkPostExistInActivity($this->BLOG_POST_ID))
										{
											$this->increaseTotalBlogPostCount($this->BLOG_USER_ID);
											$this->addPostCreatedActivity($this->BLOG_POST_ID);
											if($this->BLOG_RELATION_ID)
											{
												$this->shareBlogPostDetails($this->BLOG_POST_ID);
											}
										}
										$this->sendMailToUserForActivate($this->BLOG_POST_ID);
									}
								}
					     }
					}
				else if($this->fields_arr['action']=='NotApproved')
					{
						foreach($post_details as $post_key=>$post_value)
							{
								$post_arr = explode('-',$post_value);
								$flag[] = $post_arr[0];
							}
						$post_list = implode(',',$flag);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET status=\'Not Approved\''.
								' WHERE blog_post_id IN('.$post_list.')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
					        trigger_db_error($this->dbObj);

					    //Code to Send mail to post owner about post disappoval
						foreach($post_details as $post_key=>$post_value)
							{
								$post_arr = explode('-',$post_value);
								$this->sendMailToUserForDisapproval($post_arr[0]);
							}

					}
				return true;
			}
	}
//<<<<<-------------- Class obj begins ---------------//
//-------------------- Code begins -------------->>>>>//
$postActivate = new postActivate();
$postActivate->setPageBlockNames(array('list_blog_form'));
//default form fields and values...
$postActivate->setReturnColumns(array());
$postActivate->setTableNames(array());
$postActivate->setFormField('list', '');
$postActivate->setFormField('blog_post_id', '');
$postActivate->setFormField('submit', '');
$postActivate->setFormField('subcancel', '');
$postActivate->setFormField('action', '');
$postActivate->setFormField('delete', '');
$postActivate->setFormField('confirmdel', '');
$postActivate->setFormField('checkbox', array());
$postActivate->setFormField('post_categories', '');
$postActivate->setMonthsListArr($LANG_LIST_ARR['months']);
$postActivate->setFormField('check_box', '');
$postActivate->setFormField('post_options', '');
/*********** Page Navigation Start *********/
$postActivate->setFormField('slno', '1');
$postActivate->left_navigation_div = 'blogMain';

$postActivate->populateThisBlogCategory();
/************ page Navigation stop *************/
$postActivate->setAllPageBlocksHide();
/******************************************************/
$postActivate->setTableNames(array($postActivate->CFG['db']['tbl']['blog_posts'].' as bp LEFT JOIN '.$postActivate->CFG['db']['tbl']['users'].' as u ON bp.user_id=u.user_id AND u.usr_status=\'Ok\''));
$postActivate->setReturnColumns(array('bp.blog_post_id', 'bp.user_id', 'bp.blog_post_name', 'DATE_FORMAT(bp.date_added,\''.$postActivate->CFG['format']['date'].'\') as date_added', 'u.user_name', 'u.first_name', 'u.last_name', 'bp.flagged_status', 'bp.status', 'blog_category_id', 'bp.total_comments'));
//$postActivate->sql_sort = '';
//$postActivate->setAllPageBlocksHide();
$postActivate->sanitizeFormInputs($_REQUEST);
$postActivate->setPageBlockShow('list_blog_form');
/******************************************************/

if($postActivate->isFormGETed($_POST,'confirmdel'))
	{
		if($postActivate->deletePost())
			{
				$postActivate->setCommonSuccessMsg($postActivate->LANG['postactivate_msg_success_delete']);
				$postActivate->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$postActivate->setCommonErrorMsg($postActivate->LANG['postactivate_msg_success_delete_fail']);
				$postActivate->setPageBlockShow('block_msg_form_error');
			}
	}
//<<<<<-------------------- Code ends----------------------//

$postActivate->hidden_arr = array('start');

if ($postActivate->isShowPageBlock('list_blog_form'))
    {
		/****** navigtion continue*********/
		$postActivate->buildSelectQuery();
		$postActivate->buildConditionQuery();
		$postActivate->buildSortQuery();
		$postActivate->buildQuery();
		//$postActivate->printQuery();
		$postActivate->executeQuery();

		/******* Navigation End ********/
		if($postActivate->isResultsFound())
			{
				$postActivate->displayPostList();
				$smartyObj->assign('smarty_paging_list', $postActivate->populatePageLinksPOST($postActivate->getFormField('start'), 'post_manage_form2'));
				$postActivate->list_blog_form['hidden_arr'] = array('start');
			}
    }

//include the header file
$postActivate->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'blog');
$smartyObj->display('postActivate.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript" >
	var block_arr= new Array('selMsgConfirm');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['postactivate_err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction(act_value)
		{
			if(act_value)
				{
					switch (act_value)
						{
							case 'Ok':
								confirm_message = '<?php echo $LANG['postactivate_activate_confirmation'];?>';
								break;
							case 'Delete':
								confirm_message = '<?php echo $LANG['postactivate_delete_confirmation'];?>';
								break;
							case 'NotApproved':
								confirm_message = '<?php echo $LANG['postactivate_disapprove_confirmation'];?>';
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
$postActivate->includeFooter();
?>