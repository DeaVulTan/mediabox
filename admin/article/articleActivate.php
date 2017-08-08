<?php
/**
 * This file is to manage the toactivate articles
 *
 * Provides an interface to manage articles that are not activated.
 * Articles can be activated, can view full article, view comments
 * of the article, article can be edited and deleted.
 *
 * @category	Rayzz
 * @package		Admin
 *
 **/
require_once('../../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'article';
$CFG['lang']['include_files'][] = 'languages/%s/article/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/admin/articleActivate.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleActivityHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleHandler.lib.php';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class articleActivate begins -------------------->>>>>//
/**
 * @category	Rayzz
 * @package		Admin
 **/
class articleActivate extends ArticleHandler
	{
		public $sql_condition = '';
		public $sql_sort = '';
		public $fields_arr = '';
		public $sql='';
		public $article_category_name = array();

		/**
		 * articleActivate::buildConditionQuery()
		 *
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = 'v.article_status=\'ToActivate\'';
			}

		/**
		 * articleActivate::buildSortQuery()
		 *
		 * @return void
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'v.article_id DESC';
			}

		/**
		 * articleActivate::getArticleCategory()
		 *
		 * @param Integer $article_category_id
		 * @return void
		 */
		public function getArticleCategory($article_category_id)
			{
				if(isset($this->article_category_name[$article_category_id]))
					return $this->article_category_name[$article_category_id];

				$this->article_category_name[$article_category_id] = '';

				$sql = 'SELECT article_category_name FROM '.$this->CFG['db']['tbl']['article_category'].
						' WHERE article_category_id='.$this->dbObj->Param('article_category_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($article_category_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->article_category_name[$article_category_id] = $row['article_category_name'];
					}
				return $this->article_category_name[$article_category_id];
			}

		/**
		 * articleActivate::populateArticleCategory()
		 *
		 * @return void
		 */
		public function populateArticleCategory()
			{
				$sql = 'SELECT article_category_id, article_category_name FROM '.$this->CFG['db']['tbl']['article_category'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$this->article_category_name[$row['article_category_id']] = $row['article_category_name'];
							}
					}
			}

		/**
		 * articleActivate::sendMailToUserForDelete()
		 *
		 * @return boolean
		 **/
		public function sendMailToUserForDisapproval($article_id)
			{
				$this->populateArticleDetails($article_id);
				$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $this->LANG['article_disapproved_subject']);
				$body = $this->LANG['article_disapproved_content'];
				$article_link = getUrl('viewarticle','?article_id='.$this->ARTICLE_ID.$this->changeTitle($this->ARTICLE_TITLE),
								$this->ARTICLE_ID.'/'.$this->changeTitle($this->ARTICLE_TITLE).'/', 'root','article');
				$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
				$body = str_replace('VAR_USER_NAME', $this->ARTICLE_USER_NAME, $body);
				$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
				$body = str_replace('VAR_ARTICLE_TITLE', $this->ARTICLE_TITLE, $body);
				$body = str_replace('VAR_ARTICLE_ADMIN_COMMENT_FOR_DISAPPROVAL', ($this->ARTICLE_ADMIN_COMMENT)?$this->ARTICLE_ADMIN_COMMENT:$this->LANG['article_admin_comment_default_msg'], $body);
				$body = str_replace('VAR_ARTICLE_LINK', '<a href=\''.$article_link.'\'>'.$article_link.'</a>', $body);
				$body=nl2br($body);

				if($this->_sendMail($this->ARTICLE_USER_EMAIL, $subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']))
					return true;
				else
					return false;
			}

		/**
		 * articleActivate::populateArticleDetails()
		 *
		 * @return boolean
		 **/
		public function populateArticleDetails($article_id)
			{
				$sql = 'SELECT a.article_id, a.article_title, a.article_category_id, a.article_id, a.article_caption, a.article_admin_comments, a.date_of_publish,'.
						'u.user_name, u.email, u.user_id, relation_id FROM '.
						$this->CFG['db']['tbl']['article'].' as a LEFT JOIN '.$this->CFG['db']['tbl']['users'].
						' as u ON a.user_id=u.user_id WHERE'.
						' article_id='.$this->dbObj->Param('article_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($article_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
				{
					$this->ARTICLE_ID 				 = $row['article_id'];
					$this->ARTICLE_TITLE 			 = $row['article_title'];
					$this->ARTICLE_CATEGORY_ID 		 = $row['article_category_id'];
					$this->ARTICLE_USER_NAME 		 = $row['user_name'];
					$this->ARTICLE_USER_EMAIL 		 = $row['email'];
					$this->ARTICLE_USER_ID 			 = $row['user_id'];
					$this->ARTICLE_ADMIN_COMMENT 	 = $row['article_admin_comments'];
					$this->ARTICLE_PUBLISH_DATE 	 = $row['date_of_publish'];
					$this->ARTICLE_RELATION_ID 		 = $row['relation_id'];
					$this->ARTICLE_DESCRIPTION       = $row['article_caption'];
					return true;
				}
				return false;
			}

		/**
		 * articleActivate::displayArticleList()
		 * This method helps to display the list of articles
		 *
		 * @return void
		 **/
		public function displayarticleList()
			{
				global $smartyObj;
				$displayarticleList_arr = array();

				$anchor = 'MultiDelte';
				$fields_list = array('user_name', 'first_name', 'last_name');

				$inc = 0;
				while($row = $this->fetchResultRecord())
					{
						if(!isset($row['user_name']))
							{
								if(!isset($this->UserDetails[$row['user_id']]))
									getUserDetail('user_id', $row['user_id'], 'user_name');

								$name = getUserDetail('user_id', $row['user_id'], 'user_name');
							}
						else
							{
								$name = $this->CFG['format']['name'];
								$name = str_replace('$first_name', $row['first_name'],$name);
								$name = str_replace('$last_name', $row['last_name'],$name);
								$name = str_replace('$user_name', $row['user_name'],$name);
							}
						$displayarticleList_arr[$inc]['name'] = $name;
						$row['flagged_status'] = $row['flagged_status']?$row['flagged_status']:'No';
						$displayarticleList_arr[$inc]['record'] = $row;
						$displayarticleList_arr[$inc]['comments_text'] = str_replace('{total_comments}', $row['total_comments'], $this->LANG['article_comments']);
						$displayarticleList_arr[$inc]['view_article_link'] = getUrl('viewarticle', '?article_id='.$row['article_id'].'&amp;title='.$this->changeTitle($row['article_title']), $row['article_id'].'/'.$this->changeTitle($row['article_title']).'/', 'members', 'article');

						$inc++;
					}
				$smartyObj->assign('displayarticleList_arr', $displayarticleList_arr);
			}


		/**
		 * articleActivate::deleteArticle()
		 * This function is used to set the flag for the article.
		 *
		 * @return boolean
		 **/
		public function deleteArticle()
			{

				$article_details = explode(',', $this->fields_arr['checkbox']);

				if($this->fields_arr['action']=='Delete')
					{
						foreach($article_details as $article_key=>$article_value)
							{
								$article_arr = explode('-',$article_value);
								$article_id = $article_arr[0];
								$user_id = $article_arr[1];
								$this->deleteArticles(array($article_id), $user_id);
							}
					}
				else if($this->fields_arr['action']=='Ok')
					{
						foreach($article_details as $article_key=>$article_value)
							{
								$article_arr = explode('-',$article_value);
								$flag[] = $article_arr[0];

								//$article_list = implode(',',$flag);
								//Code to set article status as ok or infuture based on publish date
								if($this->populateArticleDetails($article_arr[0]))
								{
									$publishDate = $this->ARTICLE_PUBLISH_DATE;
									$currentDate   = date("Y-m-d");

									if($publishDate > $currentDate)
										$articleStatus = 'InFuture';
									else
										$articleStatus = 'Ok';

									$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET article_status=\''.$articleStatus.'\''.
											' WHERE article_id IN('.$article_arr[0].')';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt);
									if (!$rs)
								        trigger_db_error($this->dbObj);

									//Code to send mail, increase article count and update article activty table if article status is set as ok
								    if($articleStatus == 'Ok')
									{
										if(!$this->chkArticleExistInActivity($this->ARTICLE_ID))
										{
											$this->increaseTotalArticleCount($this->ARTICLE_USER_ID);
											$this->addArticleUploadActivity($this->ARTICLE_ID);
											if($this->ARTICLE_RELATION_ID)
											{
												$this->shareArticleDetails($this->ARTICLE_ID);
											}
										}
										$this->sendMailToUserForActivate($this->ARTICLE_ID);
									}
								}
					     }
					}
				else if($this->fields_arr['action']=='NotApproved')
					{
						foreach($article_details as $article_key=>$article_value)
							{
								$article_arr = explode('-',$article_value);
								$flag[] = $article_arr[0];

								$this->populateArticleDetails($article_arr[0]);

								//Condition to set default admin comment message if admin comment is empty
									$article_admin_comment = '';
									$article_admin_comment	= trim($this->ARTICLE_ADMIN_COMMENT);
									if(empty($article_admin_comment))
									{
										$article_admin_comment = $this->LANG['article_admin_comment_default_msg'];
									}
									else
									{
										$article_admin_comment = $this->ARTICLE_ADMIN_COMMENT;
									}


								$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET article_status=\'Not Approved\', article_admin_comments =\''.$article_admin_comment.'\''.
								' WHERE article_id IN('.$article_arr[0].')';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
					        		trigger_db_error($this->dbObj);

					        	//Code to Send mail to article owner about article disappoval
					        		$this->sendMailToUserForDisapproval($article_arr[0]);
							}
						/*$article_list = implode(',',$flag);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET article_status=\'Not Approved\''.
								' WHERE article_id IN('.$article_list.')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
					        trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);*/

					    //Code to Send mail to article owner about article disappoval
						/*foreach($article_details as $article_key=>$article_value)
							{
								$article_arr = explode('-',$article_value);
								$this->sendMailToUserForDisapproval($article_arr[0]);
							}*/

					}
				return true;
			}
	}
//<<<<<-------------- Class obj begins ---------------//
//-------------------- Code begins -------------->>>>>//
$articleActivate = new articleActivate();
$articleActivate->setPageBlockNames(array('list_article_form'));
//default form fields and values...
$articleActivate->setReturnColumns(array());
$articleActivate->setTableNames(array());
$articleActivate->setFormField('list', '');
$articleActivate->setFormField('article_id', '');
$articleActivate->setFormField('submit', '');
$articleActivate->setFormField('subcancel', '');
$articleActivate->setFormField('action', '');
$articleActivate->setFormField('delete', '');
$articleActivate->setFormField('confirmdel', '');
$articleActivate->setFormField('checkbox', array());
$articleActivate->setFormField('article_categories', '');
$articleActivate->setMonthsListArr($LANG_LIST_ARR['months']);
$articleActivate->setFormField('check_box', '');
$articleActivate->setFormField('article_options', '');
/*********** Page Navigation Start *********/
$articleActivate->setFormField('slno', '1');
$articleActivate->left_navigation_div = 'articleMain';

$articleActivate->populateArticleCategory();
/************ page Navigation stop *************/
$articleActivate->setAllPageBlocksHide();
/******************************************************/
$articleActivate->setTableNames(array($articleActivate->CFG['db']['tbl']['article'].' as v LEFT JOIN '.$articleActivate->CFG['db']['tbl']['users'].' as u ON v.user_id=u.user_id AND u.usr_status=\'Ok\''));
$articleActivate->setReturnColumns(array('v.article_id', 'article_server_url', 'v.user_id', 'v.article_title', 'DATE_FORMAT(v.date_added,\''.$articleActivate->CFG['format']['date'].'\') as date_added', 'u.user_name', 'u.first_name', 'u.last_name', 'v.flagged_status', 'v.article_status', 'article_category_id', 'v.total_comments'));
//$articleActivate->sql_condition = 'v.article_status=\'ToActivate\'';
//$articleActivate->sql_sort = '';
//$articleActivate->setAllPageBlocksHide();
$articleActivate->sanitizeFormInputs($_REQUEST);
$articleActivate->setPageBlockShow('list_article_form');
/******************************************************/

if($articleActivate->isFormGETed($_POST,'confirmdel'))
	{
		if($articleActivate->deleteArticle())
			{
				$articleActivate->setCommonSuccessMsg($articleActivate->LANG['msg_success_delete']);
				$articleActivate->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$articleActivate->setCommonErrorMsg($articleActivate->LANG['msg_success_delete_fail']);
				$articleActivate->setPageBlockShow('block_msg_form_error');
			}
	}
//<<<<<-------------------- Code ends----------------------//

$articleActivate->hidden_arr = array('start');

if ($articleActivate->isShowPageBlock('list_article_form'))
    {
		/****** navigtion continue*********/
		$articleActivate->buildSelectQuery();
		$articleActivate->buildConditionQuery();
		$articleActivate->buildSortQuery();
		$articleActivate->buildQuery();
		//$articleActivate->printQuery();
		$articleActivate->executeQuery();

		/******* Navigation End ********/
		if($articleActivate->isResultsFound())
			{
				$articleActivate->displayarticleList();
				$smartyObj->assign('smarty_paging_list', $articleActivate->populatePageLinksPOST($articleActivate->getFormField('start'), 'article_manage_form2'));
				$articleActivate->list_article_form['hidden_arr'] = array('start');
			}
    }

//include the header file
$articleActivate->includeHeader();
//--------------------Page block templates begins-------------------->>>>>//
//include the content of the page
setTemplateFolder('admin/', 'article');
$smartyObj->display('articleActivate.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript" >
	var block_arr= new Array('selMsgConfirm');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['articleActivate_err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction(act_value)
		{
			//var act_value = document.article_manage_form2.article_options.value;
			if(act_value)
				{
					switch (act_value)
						{
							case 'Ok':
								confirm_message = '<?php echo $LANG['articleactivate_activate_confirmation'];?>';
								break;
							case 'Delete':
								confirm_message = '<?php echo $LANG['articleactivate_delete_confirmation'];?>';
								break;
							case 'NotApproved':
								confirm_message = '<?php echo $LANG['articleActivate_disapprove_comment_confirmation_msg'].'<br/><br/>'.$LANG['articleActivate_disapprove_confirmation'];?>';
								break;
						}
					$Jq('#confirmMessage').html(confirm_message);
					document.msgConfirmform.action.value = act_value;
					Confirmation('selMsgConfirm', 'msgConfirmform', Array('checkbox'), Array(multiCheckValue), Array('value'), -25, -290);
				}
			else
				{
				alert_manual(please_select_action);
				}
		}

	function popupWindow(url)
		{
			 window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
			 return false;
		}
</script>
<?php
$articleActivate->includeFooter();
?>