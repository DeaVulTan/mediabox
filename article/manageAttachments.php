<?php
/**
 * File to allow the users to manage attachments in the article
 *
 * Provides an interface to get attachment and to view added attachments.
 * If valid, attachment is added to the site. Attachments can be deleted
 * using the delete link near the attachment.
 *
 * If not activated, activation mail will be sent again
 *
 * @category	Rayzz
 * @package		Members
 */
require_once('../common/configs/config.inc.php');
$CFG['site']['is_module_page'] = 'article';
$CFG['lang']['include_files'][] = 'languages/%s/article/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/help.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/article/manageAttachments.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ArticleHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = 'members';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * This class is used to manage attachments
 *
 * @category	Rayzz
 * @package		Members
 */
class ManageAttachments extends ArticleHandler
	{
		public $file_root_path = '../';

		/**
		 * ManageAttachments::fileUpload()
		 *
		 * @return boolean
		 */
		public function fileUpload()
			{
				$article_id = $this->fields_arr['article_id'];
				if($this->chkFileUploaded())
					{
						$file_name = $_FILES['article_file']['name'];
						$this->setFormField('file_type', $_FILES['article_file']['type']);
						$this->setFormField('file_size', $_FILES['article_file']['size']);
						$extern = strtolower(substr($_FILES['article_file']['name'], strrpos($_FILES['article_file']['name'], '.')+1));
						$this->setFormField('article_ext',$extern);
						$temp_dir = $this->file_root_path.$this->CFG['media']['folder'].'/'.$this->CFG['temp_media']['folder'].'/'.$this->CFG['admin']['articles']['temp_folder'].'/';
						$this->chkAndCreateFolder($temp_dir);
						$temp_file = $temp_dir.'/'.$file_name;
						move_uploaded_file($_FILES['article_file']['tmp_name'],$temp_file);

						if($this->getServerDetails())
							{
								if($FtpObj = new FtpHandler($this->fields_arr['ftp_server'],$this->fields_arr['ftp_usrename'],$this->fields_arr['ftp_password']))
									{
										if($this->fields_arr['ftp_folder'])
											$FtpObj->changeDirectory($this->fields_arr['ftp_folder']);

										$dir = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['articles']['folder'].'/'.$article_id.'/';

										$FtpObj->makeDirectory($dir);

										if(is_file($temp_file))
											{
												if(!file_exists($dir.$file_name))
													{
														$FtpObj->moveTo($temp_file, $dir.$file_name);
														unlink($temp_file);
													}
												else
													{
														$this->setCommonErrorMsg($this->LANG['manageAttachments_msg_file_exists']);
														$this->setPageBlockShow('block_msg_form_error');
														return false;
													}
											}

										$this->setFormField('server_url',$this->fields_arr['server_url']);
										$this->updateArticleTable('add');
										$this->updateArticleAttachmentsTable();
										return;
									}
							}
						$dir = $this->file_root_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['articles']['folder'].'/'.$article_id.'/';
						$this->chkAndCreateFolder($dir);
						$uploadUrl = $dir.$file_name;
						if(is_file($temp_file))
							{
								if(!file_exists($uploadUrl))
									{
										copy($temp_file, $uploadUrl);
										unlink($temp_file);
									}
								else
									{
										$this->setCommonErrorMsg($this->LANG['manageAttachments_msg_file_exists']);
										$this->setPageBlockShow('block_msg_form_error');
										return false;
									}
							}
						$this->setFormField('server_url',$this->CFG['site']['url']);
						$this->setFormField('file_name',$file_name);
						$this->updateArticleTable('add');
						$this->updateArticleAttachmentsTable();
						return true;
					}
			}

		/**
		 * ManageAttachments::updateArticleTable()
		 *
		 * @param string $act
		 * @return void
		 */
		public function updateArticleTable($act)
			{
				if($act == 'add')
					$this->fields_arr['article_attachment'] = $this->fields_arr['article_attachment'] + 1;
				elseif($act == 'delete')
					$this->fields_arr['article_attachment'] = $this->fields_arr['article_attachment'] - 1;

				$default_status=($this->CFG['admin']['articles']['auto_activate'])?'Ok':'ToActivate';
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['article'].' SET '.
						'article_attachment='.$this->fields_arr['article_attachment'].' '.
						'WHERE article_id='.$this->dbObj->Param('article_id');

				$stmt = $this->dbObj->Prepare($sql);

				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

			}

		/**
		 * ManageAttachments::updateArticleAttachmentsTable()
		 *
		 * @return void
		 */
		public function updateArticleAttachmentsTable()
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['article_attachments'].' SET '.
						'article_id='.$this->dbObj->Param('article_id').', file_name='.$this->dbObj->Param('file_name').', '.
						'file_ext='.$this->dbObj->Param('file_ext').', file_type='.$this->dbObj->Param('file_type').', '.
						'server_url='.$this->dbObj->Param('server_url').', date_added=now()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id'], $this->fields_arr['file_name'], $this->fields_arr['article_ext'], $this->fields_arr['file_type'], $this->fields_arr['server_url']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * ManageAttachments::deleteFromArticleAttachmentsTable()
		 *
		 * @return void
		 */
		public function deleteFromArticleAttachmentsTable()
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['article_attachments'].' '.
						'WHERE article_id='.$this->dbObj->Param('article_id').' '.
						'AND attachment_id='.$this->dbObj->Param('attachment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id'], $this->fields_arr['attachment_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}

		/**
		 * ManageAttachments::chkValidArticleId()
		 *
		 * @return boolean
		 */
		public function chkValidArticleId()
			{
				$articleId = $this->fields_arr['article_id'];
				$articleId = is_numeric($articleId)?$articleId:0;
				if (!$articleId)
				    {
				        return false;
				    }
				$userId = $this->CFG['user']['user_id'];

				$condition = 'p.article_status IN (\'Ok\', \'Draft\', \'ToActivate\', \'Not Approved\', \'InFuture\') AND p.article_id='.$this->dbObj->Param('article_id').
							' AND p.user_id = '.$this->dbObj->Param('user_id');

				$sql = 'SELECT p.article_attachment, p.total_favorites, p.total_views, p.total_comments, p.total_downloads, article_server_url,'.
						' p.allow_comments,p.article_category_id,p.article_tags,'.
						' p.allow_ratings, p.rating_total, p.rating_count, p.user_id, p.flagged_status, p.article_caption,'.
						' p.article_title, DATE_FORMAT(date_added,\''.$this->CFG['format']['date'].'\') as date_added'.
						' FROM '.$this->CFG['db']['tbl']['article'].' as p WHERE '.$condition.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($articleId, $userId));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$fields_list = array('user_name', 'first_name', 'last_name');
				if($row = $rs->FetchRow())
					{
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['article_server_url'] = $row['article_server_url'];
						$this->fields_arr['article_title'] = $row['article_title'];
						$this->fields_arr['article_category_id'] = $row['article_category_id'];
						$this->fields_arr['date_added'] = $row['date_added'];

						$this->fields_arr['article_attachment'] = $row['article_attachment'];
						return true;
					}
				return false;
			}

		/**
		 * ManageAttachments::getAdditionalQuery()
		 *
		 * @param string $alias
		 * @return string
		 */
		public function getAdditionalQuery($alias = '')
			{
				$additional = '';
				if(isMember())
					{
						$user_id = $this->CFG['user']['user_id'];
						if ($total_friends = $this->getTotalFriends($user_id))
						    {
								$this->getFriendsList($user_id, $total_friends);

								if(!($this->FriendsListIds and $this->FriendsList))
									return $additional;

								/*$additional = ' OR ((relation_id=\'\' AND  '.$alias.'user_id IN('.$this->FriendsList.')) OR ( SELECT fr.relation_id FROM'.
												' '.$this->CFG['db']['tbl']['friends_relation'].' AS fr	WHERE FIND_IN_SET(fr.relation_id, '.$alias.'relation_id) > 0 '.
												' AND friendship_id IN ('.$this->FriendsListIds.') LIMIT 1'.
												' ))';*/

								$additional = ' OR (( SELECT fr.relation_id FROM'.
												' '.$this->CFG['db']['tbl']['friends_relation'].' AS fr	WHERE FIND_IN_SET(fr.relation_id, '.$alias.'relation_id) > 0 '.
												' AND friendship_id IN ('.$this->FriendsListIds.') LIMIT 1'.
												' ))';
						    }
					}
				return $additional;
			}

		/**
		 * ManageAttachments::getTotalFriends()
		 *
		 * @param Integer $owner_id
		 * @return Integer
		 */
		public function getTotalFriends($owner_id)
			{
				if(isset($this->TotalFriends_arr[$owner_id]))
					{
						return $this->TotalFriends_arr[$owner_id];
					}
				$sql = 'SELECT total_friends FROM '.$this->CFG['db']['tbl']['users'].
						' WHERE user_id='.$this->dbObj->Param('owner_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($owner_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if ($row = $rs->FetchRow())
				    {
				        $this->TotalFriends_arr[$owner_id] = $row['total_friends'];
						return $row['total_friends'];
				    }
				$this->TotalFriends_arr[$owner_id] = 0;
				return 0;
			}

		/**
		 * ManageAttachments::getAttachmentDetails()
		 *
		 * @return void
		 */
		public function getAttachmentDetails()
			{
				global $smartyObj;
				$getAttachmentDetails_arr = array();

				$getAttachmentDetails['row'] = array();
				$inc = 1;
				//while($row = $rs->FetchRow())
				while($row = $this->fetchResultRecord())
					{
						$getAttachmentDetails['row'][$inc]['record'] = $row;
						$getAttachmentDetails['row'][$inc]['sno'] = $inc + $this->fields_arr['start'];
						$getAttachmentDetails['row'][$inc]['delete_url'] = getUrl('manageattachments', '?article_id='.$this->fields_arr['article_id'].'&amp;attachment_id='.$row['attachment_id'].'&amp;action=delete', $this->fields_arr['article_id'].'/?attachment_id='.$row['attachment_id'].'&amp;action=delete', 'members', 'article');
						$inc++;
					}

				$smartyObj->assign('getAttachmentDetails', $getAttachmentDetails);
			}

		/**
		 * ManageAttachments::getAttachment()
		 *
		 * @param string $act
		 * @return void
		 */
		public function getAttachment($act)
			{
				$sql = 'SELECT file_name, file_ext, file_type, '.
						' DATE_FORMAT(date_added,\''.$this->CFG['format']['date'].'\') as date_added'.
						' FROM '.$this->CFG['db']['tbl']['article_attachments'].''.
						' WHERE article_id='.$this->dbObj->Param('attahcment_article_id').' AND attachment_id='.$this->dbObj->Param('attahcment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id'], $this->fields_arr['attachment_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						if($act == 'download')
							$this->downloadAttachment($row['file_name'], $row['file_type']);
						elseif($act == 'delete')
							$this->deleteAttachment($row['file_name']);
					}
			}


		/**
		 * ManageAttachments::deleteAttachment()
		 *
		 * @param string $file_name
		 * @return void
		 */
		public function deleteAttachment($file_name)
			{
				$dir = $this->file_root_path.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['articles']['folder'].'/'.$this->fields_arr['article_id'].'/';
				$file_name = $dir.$file_name;
				unlink($file_name);
				$this->updateArticleTable('delete');
				$this->deleteFromArticleAttachmentsTable();
				echo $this->fields_arr['article_attachment'].' attachment';
				if($this->fields_arr['article_attachment'] == 0)
					{
						rmdir($dir);
					}
			}

		/**
		 * ManageAttachments::buildCondQuery()
		 *
		 * @param mixed $manage_attachments_sql_condition
		 * @return void
		 */
		public function buildCondQuery($manage_attachments_sql_condition)
			{
				$this->sql_condition = $manage_attachments_sql_condition;
			}

		/**
		 * ManageAttachments::buildSortQuery()
		 *
		 * @return void
		 */
		public function buildSortQuery()
			{
				$this->sql_sort = $this->fields_arr['orderby_field'].' '.$this->fields_arr['orderby'];
			}


		/**
		 * ManageAttachments::allowAddattachment()
		 *
		 * @return boolean
		 */
		public function allowAddattachment()
		{
			$sql  = 'SELECT article_status FROM '.$this->CFG['db']['tbl']['article'].' WHERE article_id = '.$this->dbObj->Param('article_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs   = $this->dbObj->Execute($stmt, array($this->fields_arr['article_id']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

			if($row = $rs->FetchRow())
			{
				if($row['article_status'] == 'Ok' || $row['article_status'] == 'Draft' || $row['article_status'] == 'InFuture' || $row['article_status'] == 'Not Approved' || $row['article_status'] == 'ToActivate')
					return true;
			}
			return false;
		}
	}
//<<<<<-------------- Class ArticleUpload begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ManageAttachments = new ManageAttachments();

if(!chkAllowedModule(array('article')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$ManageAttachments->setPageBlockNames(array('article_attachments', 'add_article_attachments'));

$ManageAttachments->setFormField('article_id', '');
$ManageAttachments->setFormField('article_title', '');
$ManageAttachments->setFormField('attachment_id', '');
$ManageAttachments->setFormField('article_category_id', '');
$ManageAttachments->setFormField('article_ext', '');
$ManageAttachments->setFormField('action', '');
$ManageAttachments->setFormField('msg', '');

$ManageAttachments->setFormField('orderby_field', 'attachment_id');
$ManageAttachments->setFormField('orderby', 'ASC');
$ManageAttachments->setTableNames(array($CFG['db']['tbl']['article_attachments']));
$ManageAttachments->setReturnColumns(array('attachment_id', 'file_name', 'DATE_FORMAT(date_added,\''.$CFG['format']['date'].'\') as date_added'));

$ManageAttachments->sanitizeFormInputs($_REQUEST);

if($ManageAttachments->getFormField('article_id'))
	{
		$ManageAttachments->validate = $ManageAttachments->chkValidArticleId();
		if($ManageAttachments->validate)
			{
				$ManageAttachments->setAllPageBlocksHide();
				if($ManageAttachments->isFormGETed($_GET, 'action'))
					{
						if($ManageAttachments->getFormField('action')=='delete')
							{
								$ManageAttachments->getAttachment('delete');
								Redirect2URL(getUrl('manageattachments', '?article_id='.$ManageAttachments->getFormField('article_id').'&msg=delete', $ManageAttachments->getFormField('article_id').'/?msg=delete', 'members', 'article'));
							}
					}

				if($ManageAttachments->isFormPOSTed($_POST, 'submit_attachment'))
					{
						if($CFG['admin']['articles']['article_attachment'])
							{
								if($ManageAttachments->chkFileNameIsNotEmpty('article_file', $LANG['common_err_tip_required']))
									{
										$ManageAttachments->chkValidFileType('article_file', $CFG['admin']['articles']['attachment_format_arr'], $LANG['manageAttachments_err_tip_invalid_file_type']) and
										$ManageAttachments->chkValideFileSize('article_file',$LANG['manageAttachments_err_tip_invalid_file_size']) and
										$ManageAttachments->chkErrorInFile('article_file',$LANG['manageAttachments_err_tip_invalid_file']);
									}
							}

						if($ManageAttachments->isValidFormInputs())
							{
								if($ManageAttachments->fileUpload())
									{
										Redirect2URL(getUrl('manageattachments', '?article_id='.$ManageAttachments->getFormField('article_id').'&msg=attachment', $ManageAttachments->getFormField('article_id').'/?msg=attachment', 'members', 'article'));
									}
							}
						else
							{
								$ManageAttachments->setCommonErrorMsg($LANG['common_msg_error_sorry']);
								$ManageAttachments->setPageBlockShow('block_msg_form_error');
							}
					}
				$ManageAttachments->setPageBlockShow('article_attachments');
				if($ManageAttachments->allowAddattachment())
				{
					if($CFG['admin']['articles']['allow_edit_article_attachment'])
						$ManageAttachments->setPageBlockShow('add_article_attachments');
					else
					{
						$ManageAttachments->setCommonErrorMsg($LANG['manageAttachments_admin_not_allowed_edit_atachments']);
						$ManageAttachments->setPageBlockShow('block_msg_form_error');
					}
				}
				else
				{
						$ManageAttachments->setPageBlockShow('add_article_attachments');
				}

			}
			else
			{
				$ManageAttachments->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				$ManageAttachments->setPageBlockShow('block_msg_form_error');

			}
	}
if($ManageAttachments->isFormGETed($_GET, 'msg'))
	{
		switch($ManageAttachments->getFormField('msg'))
			{
				case 'delete':
					$ManageAttachments->setCommonSuccessMsg($LANG['manageAttachments_msg_delete_success']);
					$ManageAttachments->setPageBlockShow('block_msg_form_success');
					break;

				case 'attachment':
					$ManageAttachments->setCommonSuccessMsg($LANG['manageAttachments_msg_success_attachment']);
					$ManageAttachments->setPageBlockShow('block_msg_form_success');
					break;

				case 'error':
					$ManageAttachments->setCommonErrorMsg($LANG['common_msg_error_sorry']);
					$ManageAttachments->setPageBlockShow('block_msg_form_error');
					break;
			}
	}

//<<<<<-------------------- Code ends----------------------//
$ManageAttachments->view_article_url = getUrl('viewarticle', '?article_id='.$ManageAttachments->getFormField('article_id').'&article_title='.$ManageAttachments->changeTitle($ManageAttachments->getFormField('article_title')), $ManageAttachments->getFormField('article_id').'/'.$ManageAttachments->changeTitle($ManageAttachments->getFormField('article_title')).'/', 'members', 'article');
if ($ManageAttachments->isShowPageBlock('article_attachments'))
	{
		$condition = 'article_id='.$ManageAttachments->getFormField('article_id');
		$ManageAttachments->buildSelectQuery();
		$ManageAttachments->buildCondQuery($condition);
		$ManageAttachments->buildSortQuery();
		$ManageAttachments->buildQuery();
		//$ManageAttachments->printQuery();
		$ManageAttachments->executeQuery();

        if ($ManageAttachments->isResultsFound())
        	{
        		$ManageAttachments->getAttachmentDetails();
				$paging_arr = array('article_id');
				$smartyObj->assign('smarty_paging_list', $ManageAttachments->populatePageLinksGET($ManageAttachments->getFormField('start'), $paging_arr));
			}
	}
if ($ManageAttachments->isShowPageBlock('add_article_attachments'))
	{
		$ManageAttachments->add_article_attachments['hidden_arr'] = array('article_id');
		$ManageAttachments->add_article_attachments['form_action'] = getUrl('manageattachments', '?article_id='.$ManageAttachments->getFormField('article_id'), $ManageAttachments->getFormField('article_id').'/', 'members', 'article');
	}

setPageTitle($LANG['manageAttachments_title']);
setMetaKeywords('Manage Attachments');
setMetaDescription('Manage Attachments');
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$ManageAttachments->includeHeader();
//include the content of the page
setTemplateFolder('members/', 'article');
$smartyObj->display('manageAttachments.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
//Added jquery validation for aticle attachment page
if ($ManageAttachments->isShowPageBlock('add_article_attachments') and $CFG['feature']['jquery_validation'])
	{
		$allowed_file_formats = implode("|", $CFG['admin']['articles']['attachment_format_arr']);
?>
		<script type="text/javascript">
			$Jq("#manage_attachments_form").validate({
				rules: {

				    article_file: {
				    	required: true,
				    	isValidFileFormat: "<?php echo $allowed_file_formats; ?>"
				    }
				},
				messages: {
				    article_file: {
				    	required: "<?php echo $LANG['common_err_tip_required'];?>",
				    	isValidFileFormat: "<?php echo $LANG['common_err_tip_invalid_file_type']; ?>"
				    }
				}
			});
		</script>
<?php
	}
$ManageAttachments->includeFooter();
?>