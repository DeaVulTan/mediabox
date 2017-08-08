<?php

/**
 * This file is to edit Member's Personal Information
 *
 * PHP version 5.0
 *
 * @category	Rayzz
 * @package		Members
 * @author		vijayanand39ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: profilePersonal.php 1157 2006-06-09 07:16:00Z vijayanand39ag05 $
 * @since 		2006-04-01
 */

/**
 * To include config file
 */
require_once('../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'common/configs/config_members.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/profileBlog.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/profileTabText.php';
$CFG['mods']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
//Gender List
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/gender_list_array.inc.php';
//Month List
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/profile_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_inputfilter_clean.php';
$CFG['mods']['include_files'][] = 'common/classes/swiftmailer/lib/EasySwift.php';
$CFG['mods']['include_files'][] = 'common/classes/blogger/NgeblogAccess.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
// included SignupAndLoginHandler class since ProfileHandler class extends this class
$CFG['mods']['include_files'][] = 'common/classes/class_SignupAndLoginHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ProfileHandler.lib.php';
$CFG['html']['header'] = 'general/html_header.php';
$CFG['html']['footer'] = 'general/html_footer.php';
$CFG['site']['is_module_page']='video';
//compulsory
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;

/**
 * To include application top file
 */
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 * EditPersonalProfileFormHandler
 *
 * @package
 * @author edwin_90ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
if(class_exists('VideoHandler'))
	{
		class ProfileVideoHandler extends VideoHandler{}
	}
class BloggerHandler extends ProfileVideoHandler
	{
		public function Blogger()
			{
				$blog_ar = getBlogLists('mail2selvaraj@gmail.com', 'ganeshselva');
				echo '<pre>';print_r($blog_ar);echo '</pre>';
			}

		public function chkIsAlreadyAdded()
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['blogger'].' WHERE'.
						' user_id = '.$this->dbObj->Param('user_id').' AND'.
						' blog_site = '.$this->dbObj->Param('blog_site').' AND'.
						' blog_title = '.$this->dbObj->Param('blog_title').' AND'.
						' blogger_id != '.$this->dbObj->Param('bid');

				$data_arr = array($this->CFG['user']['user_id'],
								$this->getFormField('blog_site'),
								$this->getFormField('blog_title'),
								$this->getFormField('bid'));

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $data_arr);
				    if (!$rs)
				        trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						return true;
					}
				return false;
			}

		public function addBlogDetail()
			{
				if(!$this->getFormField('bid'))
					{
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blogger'].' SET'.
								' user_id = '.$this->dbObj->Param('user_id').','.
								' blog_site = '.$this->dbObj->Param('blog_site').','.
								' blog_title = '.$this->dbObj->Param('blog_title').','.
								' blog_user_name = '.$this->dbObj->Param('blog_user_name').','.
								' blog_password = '.$this->dbObj->Param('blog_password').','.
								' date_added = NOW()';

						$data_arr = array($this->CFG['user']['user_id'],
								$this->getFormField('blog_site'),
								$this->getFormField('blog_title'),
								$this->getFormField('blog_user_name'),
								$this->getFormField('blog_password'));

						$this->setCommonSuccessMsg($this->LANG['profileblog_success_added']);
					}
				else
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['blogger'].' SET'.
								' blog_site = '.$this->dbObj->Param('blog_site').','.
								' blog_title = '.$this->dbObj->Param('blog_title').','.
								' blog_user_name = '.$this->dbObj->Param('blog_user_name').','.
								' blog_password = '.$this->dbObj->Param('blog_password').' WHERE'.
								' blogger_id = '.$this->dbObj->Param('blogger_id');


						$data_arr = array($this->getFormField('blog_site'),
								$this->getFormField('blog_title'),
								$this->getFormField('blog_user_name'),
								$this->getFormField('blog_password'),
								$this->getFormField('bid'));

						$this->setCommonSuccessMsg($this->LANG['profileblog_success_updated']);

					}

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $data_arr);
				    if (!$rs)
				        trigger_db_error($this->dbObj);
			}

		public function populateBloggerList()
			{
				$populateBloggerList_arr = array();

				$sql = 'SELECT blogger_id, blog_site, blog_title, blog_user_name, blog_password, status, date_added'.
						' FROM '.$this->CFG['db']['tbl']['blogger'].' WHERE'.
						' user_id = '.$this->dbObj->Param('user_id').' AND'.
						' status = \'Ok\'';


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
				    if (!$rs)
				        trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								$populateBloggerList_arr['record'][$inc] = $row;
								$populateBloggerList_arr['link_url'][$inc] = $row['blog_site']=='blogger'?'http://'.$row['blog_title'].'.blogspot.com/':'#';
								$populateBloggerList_arr['class_name'][$inc] = 'clsBloggerIcon';
								$populateBloggerList_arr['remove_onclick'][$inc] = 'return deleteBlog('.$row['blogger_id'].')';
								$populateBloggerList_arr['modify_onclick'][$inc] = 'return openAddNewBlogWindow('.$row['blogger_id'].')';
								$inc++;
							}
					}
				return $populateBloggerList_arr;
			}

		public function populateBloggerDetail()
			{
				$sql = 'SELECT blogger_id, blog_site, blog_title, blog_user_name, blog_password, status, date_added'.
						' FROM '.$this->CFG['db']['tbl']['blogger'].' WHERE'.
						' blogger_id  = '.$this->dbObj->Param('blogger_id').' AND'.
						' user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('bid'), $this->CFG['user']['user_id']));
				    if (!$rs)
				        trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->setFormField('blog_site', $row['blog_site']);
						$this->setFormField('blog_title', $row['blog_title']);
						$this->setFormField('blog_user_name', $row['blog_user_name']);
						switch($row['blog_site'])
							{
								case 'blogger':
									$this->setPageBlockShow('sub_block_blogger_form');
									break;
							}
						return true;
					}
				$this->setFormField('bid', '');
				return false;
			}

		public function removeBlogger()
			{
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['blogger'].' WHERE'.
						' blogger_id  = '.$this->dbObj->Param('blogger_id').' AND'.
						' user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('bid'), $this->CFG['user']['user_id']));
				    if (!$rs)
				        trigger_db_error($this->dbObj);
			}
	}
//<<<<<---------------class EditPersonalProfileFormHandler------///
//--------------------Code begins-------------->>>>>//
$BloggerHandler = new BloggerHandler();
//$BloggerHandler->Blogger();
$BloggerHandler->setPageBlockNames(array('block_blogger_list', 'block_blog_site_list', 'sub_block_blogger_form', 'block_add_success'));

if(isset($_SERVER['HTTP_REFERER']) AND
		strpos($_SERVER['HTTP_REFERER'],'viewvideo'))
		{
			$_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
		}
// Set the form fields
$BloggerHandler->setFormField('act', '');
$BloggerHandler->setFormField('blog_site', '');
$BloggerHandler->setFormField('blog_title', '');
$BloggerHandler->setFormField('blog_user_name', '');
$BloggerHandler->setFormField('blog_password', '');
$BloggerHandler->setFormField('bid', '');
$BloggerHandler->setFormField('backkey', '');
$BloggerHandler->setFormField('video_id', '');

// Default page block
$BloggerHandler->setAllPageBlocksHide();
$BloggerHandler->setPageBlockShow('block_blogger_list');
$BloggerHandler->blog_site_list_arr = array('blogger'=>'Blogger');
$BloggerHandler->getReferrerUrl(array('profileblog'));
$BloggerHandler->sanitizeFormInputs($_REQUEST);

if($BloggerHandler->getFormField('video_id') != '')
	$BloggerHandler->view_video_url = getUrl('viewvideo', '?video_id='.$BloggerHandler->getFormField('video_id'),
											$BloggerHandler->getFormField('video_id').'/', '', 'video');
if(isAjaxPage())
	{
		if($BloggerHandler->getFormField('act'))
			{
				switch($BloggerHandler->getFormField('act'))
					{
						case 'open_blogger_list':
							$BloggerHandler->setAllPageBlocksHide();
							$BloggerHandler->getFormField('bid') and
								$BloggerHandler->populateBloggerDetail();

							$BloggerHandler->setPageBlockShow('block_blog_site_list');
							break;

						case 'blogger_sub':
							$BloggerHandler->setAllPageBlocksHide();
							$BloggerHandler->setPageBlockShow('block_blog_site_list');
							switch($BloggerHandler->getFormField('blog_site'))
								{
									case 'blogger':
										$BloggerHandler->setPageBlockShow('sub_block_blogger_form');
										break;
								}
							break;

						case 'add_blog':
							$BloggerHandler->setAllPageBlocksHide();
							$BloggerHandler->setPageBlockShow('block_blog_site_list');
							$BloggerHandler->setFormField('blog_password', trim(urldecode($BloggerHandler->getFormField('blog_password'))));
							switch($BloggerHandler->getFormField('blog_site'))
								{
									case 'blogger':
										if(!($blog_list_arr = getBlogLists($BloggerHandler->getFormField('blog_user_name'), $BloggerHandler->getFormField('blog_password'))))
											{
												$BloggerHandler->setFormFieldErrorTip('blog_user_name', $LANG['profileblog_err_tip_invalid_detail']);
												$BloggerHandler->setFormFieldErrorTip('blog_password', $LANG['profileblog_err_tip_invalid_detail']);
											}
										else if(!($blog_detail = chkIsBlogAvailable($blog_list_arr, $BloggerHandler->getFormField('blog_title'))))
											{
												$BloggerHandler->setFormFieldErrorTip('blog_title', $LANG['profileblog_err_tip_not_accessible']);
											}
										else if($BloggerHandler->chkIsAlreadyAdded())
											{
												$BloggerHandler->setFormFieldErrorTip('blog_title', $LANG['profileblog_err_tip_already_exist']);
											}
										$BloggerHandler->setPageBlockShow('sub_block_blogger_form');
										break;
								}
							if ($BloggerHandler->isValidFormInputs())
								{
									$BloggerHandler->setAllPageBlocksHide();
									$BloggerHandler->setPageBlockShow('block_add_success');
									$BloggerHandler->setPageBlockShow('block_msg_form_success');
									$BloggerHandler->addBlogDetail();
								}
							break;
					}
			}
	}
else
	{
		if($BloggerHandler->getFormField('act'))
			{
				switch($BloggerHandler->getFormField('act'))
					{
						case 'delete_blogger_list':
							$BloggerHandler->removeBlogger();
							$BloggerHandler->setPageBlockShow('block_msg_form_success');
							$BloggerHandler->setCommonSuccessMsg($LANG['profileblog_success_deleted']);
							break;

						case 'redirect':
							$BloggerHandler->redirectReferrerUrl();
							break;
					}
			}
	}
//<<<<--------------------Code Ends----------------------//
//--------------------Page block templates begins-------------------->>>>>//

if ($BloggerHandler->isShowPageBlock('block_blogger_list'))
	{
		$BloggerHandler->block_blogger_list['add_new_blog_onclick'] = 'return openAddNewBlogWindow()';
		$BloggerHandler->block_blogger_list['confirm_form_hidden_arr'] = array('backkey');
		$BloggerHandler->block_blogger_list['populateBloggerList'] = $BloggerHandler->populateBloggerList();
	}
//--------------------Page block templates begins-------------------->>>>>//
//include the header file
if(isAjaxPage())
	{
		$BloggerHandler->includeAjaxHeaderSessionCheck();
	}
else
	{
		$BloggerHandler->includeHeader();
?>
<script type="text/javascript" language="javascript">
	var referer = '<?php if(isset($_SESSION['referer'])) echo $_SESSION['referer']; ?>';
	var block_arr= new Array('selMsgAddNewBlog', 'selMsgConfirmWindow');
	function deleteBlog(bid){
		Confirmation('selMsgConfirmWindow', 'actForm', Array('act_confirmation_msg', 'bid', 'act'), Array('<?php echo $LANG['profileblog_delete_blog'];?>', bid, 'delete_blogger_list'), Array('innerHTML', 'value', 'value'));
		return false;
	}

	var openAddNewBlogWindow = function(){
		var add_pars = '';
		$Jq('#confirmation_msg').html('<?php echo $LANG['profileblog_add_new_blog'];?>');
		if(arguments.length>0){
			$Jq('#confirmation_msg').html('<?php echo $LANG['profileblog_update_blog'];?>');
			add_pars = 'bid='+arguments[0]+'&';
		}
		url = '<?php echo $CFG['site']['video_url'].'profileBlog.php';?>';
		pars = add_pars+'act=open_blogger_list&backkey=<?php echo $BloggerHandler->getFormField('backkey');?>';
		$Jq.ajax({
			type: "GET",
			url: url,
			data: pars,
			success: openAddNewBlogWindowResponse
		 });
	}

	function openAddNewBlogWindowResponse(originalRequest){
		data = originalRequest;
		Confirmation('selMsgAddNewBlog', 'formMsgAddNewBlog', Array('selAddNewBlogContent'), Array(data), Array('innerHTML'));
	}

	function showBlogDetailForm(){
		var url = '<?php echo $CFG['site']['video_url'].'profileBlog.php';?>';
		var pars = 'act=blogger_sub&'+makeQueryAsFormFieldValues('formMsgAddNewBlog');
		//result_div = 'selAddNewBlogContent'
		path = url+'?'+pars;
		new jquery_ajax(path, '', 'showBlogDetailFormResult');
		//getHTML(url, pars, 'selAddNewBlogContent', 'post');
		}

	function showBlogDetailFormResult(data)
		{
			data = unescape(data);
			var obj = $Jq('#selAddNewBlogContent');
			obj.html(data);
		}

	function addNewBlog(){

		var url = '<?php echo $CFG['site']['video_url'].'profileBlog.php';?>';
		var pars = 'act=add_blog&'+makeQueryAsFormFieldValues('formMsgAddNewBlog');
		path = url+'?'+pars;
		new jquery_ajax(path, '', 'newBlogResult');
		//getHTML(url, pars, 'selAddNewBlogContent', 'post');
	}

	function newBlogResult(data)
		{

			data = unescape(data);
			var obj = $Jq('#selAddNewBlogContent');			

			/*if(data.indexOf(session_check)>=1)
				{
					data = data.replace(session_check_replace,'');
				}
			else
				{
					return;
				}*/
			obj.html(data);
			//if(referer)
				//setTimeout('Redirect2URL(referer);', 1000);
		}
</script>
<?php
	}
//include the content of the page
setTemplateFolder('members/','video');
$smartyObj->display('profileBlog.tpl');
//<<<<<<--------------------Page block templates Ends--------------------//$smartyObj->display('viewProfile.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
if(isAjaxPage())
	{
		$BloggerHandler->includeAjaxFooter();
	}
else
	{
		$BloggerHandler->includeFooter();
	}
?>
