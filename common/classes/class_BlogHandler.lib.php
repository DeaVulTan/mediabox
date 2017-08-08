<?php
/**
 * BlogHandler
 *
 * @package Photo
 * @author edwin_048at09
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @access public
 */
class BlogHandler extends MediaHandler
{
	public $previousPostLink;

	public $nextPostLink;

	public $checkBlogAdded;

	public $validBlogId=false;

	/**
	 * BlogHandler::__construct()
	 *
	 */
	public function __construct()
	{
		parent::__construct();

	}
	/**
	 * BlogHandler::chkIsAllowedLeftMenu()
	 *
	 * @return
	 */
	public function chkIsAllowedLeftMenu()
	{
		global $HeaderHandler;
		$allowed_pages_array = array();
		$HeaderHandler->headerBlock['left_menu_display'] = displayBlock($allowed_pages_array, false, $append_default_pages=false);
		return $HeaderHandler->headerBlock['left_menu_display'];
	}
	/**
	 * BlogHandler::populateBlogJsVars()
	 *
	 * @return
	 */
	public function populateBlogJsVars()
	{
		echo '<script type="text/javascript">';
		echo 'var blog_blog_file_url = "files/'.$this->CFG['admin']['blog']['folder'].'/'.$this->CFG['admin']['blog']['temp_folder'].'/";';
		echo '</script>';
	}
	/**
	 * BlogHandler::populateMyBlogDetail()
	 *
	 * @param mixed $side_bar_option
	 * @return
	 */
	public function populateMyBlogDetail($side_bar_option)
	{
		global $smartyObj;
		if($side_bar_option == 'blog')
			$allowed_pages_array = array('viewBlog.php');

		if(displayBlock($allowed_pages_array))
			return;

		$this->_currentPage = strtolower($this->CFG['html']['current_script_name']);
		$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsActiveLink;
		$pg = (isset($_REQUEST['pg']))?$_REQUEST['pg']:'';
		$block = (isset($_REQUEST['block']))?$_REQUEST['block']:'';
		if($block != '')
			{
				$page = $this->_currentPage.'_'.strtolower($block);
				$this->_navigationArr['left_'.$page] = $this->_clsActiveLink;
			}
		$flag = false;
		if($pg != '')
		{
			$flag = true;
			$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsInActiveLink;
			$page = $this->_currentPage.'_'.strtolower($pg);
			$this->_navigationArr['left_'.$page] = $this->_clsActiveLink;
		}

		$populateMyBlogDetail_arr = array();

		//CHECK BLOG ADDED//
		$sql = 'SELECT blog_name FROM '.$this->CFG['db']['tbl']['blogs'].' '.
			'WHERE blog_status=\'Active\' AND user_id = '.$this->dbObj->Param('user_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$populateMyBlogDetail_arr['my_blog_url'] ='';
		$result_set = $rs->FetchRow();
		$populateMyBlogDetail_arr['check_blog_added'] = ($result_set['blog_name'])?$result_set['blog_name']:'';
		if($result_set['blog_name'])
		$populateMyBlogDetail_arr['my_blog_url'] = getUrl('viewblog','?blog_name='.$result_set['blog_name'],$result_set['blog_name'].'/','','blog');
		$smartyObj->assign('populateMyBlogDetail_arr', $populateMyBlogDetail_arr);
		$smartyObj->assign('opt', $side_bar_option);
		$smartyObj->assign('flag', $flag);
		setTemplateFolder('general/', 'blog');
		$smartyObj->display('populateMyBlogBlock.tpl');
	}
	/**
	 * BlogHandler::getBlogNavClass()
	 *
	 * @param mixed $identifier
	 * @return
	 */
	public function getBlogNavClass($identifier)
	{
		$identifier = strtolower($identifier);
		return isset($this->_navigationArr[$identifier])?$this->_navigationArr[$identifier]:$this->_clsInActiveLink;
	}
	/**
	 * BlogHandler::populateDateYearValue()
	 *
	 * @param mixed $start_no
	 * @param mixed $end_no
	 * @param string $highlight_value
	 * @return
	 */
	public function populateDateYearValue($start_no, $end_no, $highlight_value='')
	{
	   	       $showOption_arr = array();
		       $inc = 0;
				for($start_no;$start_no<=$end_no;$start_no++)
					{
					   	$showOption_arr[$inc]['values']=$start_no;
						$selected = trim($highlight_value) == trim($start_no)?' selected="selected"':'';
					    $showOption_arr[$inc]['selected']=$selected;
				 	   	$showOption_arr[$inc]['optionvalue']=$start_no;
				 	    $inc++;
				  }
				return $showOption_arr;
	}
	public function addBlogCreatedActivity($blog_id)
	{
		//Start new blog post created activity
		$sql = 'SELECT u.user_name as upload_user_name, b.blog_id, b.user_id as upload_user_id, '.
		        ' b.blog_name FROM '.$this->CFG['db']['tbl']['blogs'].
				' as b, '.$this->CFG['db']['tbl']['users'].' as u '.
				' WHERE u.user_id = b.user_id AND b.blog_id='.$this->dbObj->Param('blog_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($blog_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		$activity_arr = $row;
		$activity_arr['action_key']	= 'blog_created';
		$blogActivityObj = new BlogActivityHandler();
		$blogActivityObj->addActivity($activity_arr);
		//End..
	}
	/**
	 * BlogHandler::deleteBlogs()
	 *
	 * @param mixed $blog_id
	 * @param mixed $user_id
	 * @return
	 */
	public function deleteBlogs($blog_id,$user_id)
	{
	    $blog_post_id_arr = getPostIds($blog_id);
	    if(count($blog_post_id_arr)>0)
		   $blog_post_id = implode(',',$blog_post_id_arr);
		else
		   $blog_post_id=0;

		$sql = 'UPDATE '.$this->CFG['db']['tbl']['blogs'].' SET  blog_status=\'Deleted\''.
				' WHERE blog_id IN('.$blog_id.')';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		//update blog_post table status deleted
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET  status=\'Deleted\''.
				' WHERE blog_id IN('.$blog_id.')';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($affected_rows = $this->dbObj->Affected_Rows())
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
						' total_posts=0'.
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);


				//*********Delete records from Article related tables start*****
				$tablename_arr = array('blog_comments', 'blog_favorite', 'blog_featured', 'blog_viewed', 'blog_rating');
				for($i=0;$i<sizeof($tablename_arr);$i++)
					{
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].
								' WHERE blog_id IN('.$blog_id.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}

				//DELETE FLAGGED CONTENTS
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].
						' WHERE content_type=\'Blog\' AND content_id IN('.$blog_post_id.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				//**********End************

				//blog activity delete start
				$condition = '  SUBSTRING_INDEX(action_value, \'~\', 1 ) IN ('.$blog_id.') AND action_key = \'blog_created\'';

					$sql='SELECT parent_id FROM '.$this->CFG['db']['tbl']['blog_activity'].' WHERE '.$condition;
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

					if ($rs->PO_RecordCount()>0)
					{
						$parent_id ='';
						while($row = $rs->FetchRow())
						{
							if($parent_id=='')
							{
								$parent_id = $row['parent_id'];
							}
							else
							{
								$parent_id = $parent_id.','.$row['parent_id'];
							}
						}
					}
					$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['blog_activity'].' WHERE '.$condition;
					$stmt = $this->dbObj->Prepare($sql);
					$rs   = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

					if(!empty($parent_id))
					{
						$condition_act = '  parent_id IN ('.$parent_id.') ';
						$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['activity'].' WHERE '.$condition_act;
						$stmt = $this->dbObj->Prepare($sql);
						$rs   = $this->dbObj->Execute($stmt);
				    	if (!$rs)
					    	trigger_db_error($this->dbObj);
					}
				//blog activity delete end

				//blog post activity tables.
				$action_key = array('blog_post_created', 'blog_post_comment', 'blog_post_rated', 'blog_post_favorite', 'blog_post_featured');
				for($inc=0;$inc<count($action_key);$inc++)
				{
					$condition = '  SUBSTRING_INDEX(action_value, \'~\', 1 ) IN ('.$blog_post_id.') AND action_key = \''.$action_key[$inc].'\'';

					$sql='SELECT parent_id FROM '.$this->CFG['db']['tbl']['blog_activity'].' WHERE '.$condition;
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

					if ($rs->PO_RecordCount()>0)
					{
						$parent_id ='';
						while($row = $rs->FetchRow())
						{
							if($parent_id=='')
							{
								$parent_id = $row['parent_id'];
							}
							else
							{
								$parent_id = $parent_id.','.$row['parent_id'];
							}
						}
					}
					$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['blog_activity'].' WHERE '.$condition;
					$stmt = $this->dbObj->Prepare($sql);
					$rs   = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

					if(!empty($parent_id))
					{
						$condition_act = '  parent_id IN ('.$parent_id.') ';
						$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['activity'].' WHERE '.$condition_act;
						$stmt = $this->dbObj->Prepare($sql);
						$rs   = $this->dbObj->Execute($stmt);
				    	if (!$rs)
					    	trigger_db_error($this->dbObj);
					}
				}
			}

		return true;
	}
	/**
	 * BlogHandler::increaseTotalBlogPostCount()
	 *
	 * @param mixed $blog_post_user_id
	 * @return
	 */
	public function increaseTotalBlogPostCount($blog_post_user_id)
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET total_posts=total_posts+1'.
				' WHERE user_id='.$this->dbObj->Param('user_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($blog_post_user_id));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
	}
	/**
	 * BlogHandler::shareBlogPostDetails()
	 *
	 * @param mixed $blog_post_id
	 * @return
	 */
	public function shareBlogPostDetails($blog_post_id)
	 {
	 	$this->BLOG_POST_ID = $blog_post_id;
	 	$this->populateBlogPostDetails($blog_post_id);
		$this->getEmailAddressOfRelation($this->BLOG_RELATION_ID);
		$this->sendEmailToAll();
	 }
	 /**
	  * BlogHandler::populateBlogPostDetails()
	  *
	  * @param mixed $blog_post_id
	  * @return
	  */
	 public function populateBlogPostDetails($blog_post_id)
	 {
		$sql = 'SELECT b.blog_post_name, b.blog_category_id, b.blog_post_id, b.message, '.
				'u.user_name, u.email, u.user_id, relation_id FROM '.
				$this->CFG['db']['tbl']['blog_posts'].' as b LEFT JOIN '.$this->CFG['db']['tbl']['users'].
				' as u ON b.user_id=u.user_id WHERE'.
				' blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($blog_post_id));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
		{
			$this->BLOG_POST_NAME 			 = $row['blog_post_name'];
			$this->BLOG_CATEGORY_ID 		 = $row['blog_category_id'];
			$this->BLOG_USER_NAME 			 = $row['user_name'];
			$this->BLOG_USER_EMAIL 			 = $row['email'];
			$this->BLOG_USER_ID 			 = $row['user_id'];
			$this->BLOG_RELATION_ID 		 = $row['relation_id'];
			$this->BLOG_DESCRIPTION      	 = $row['message'];
			$this->fields_arr['relation_id'] = $row['relation_id'];

			return true;
		}
		return false;
	}
	/**
	 * BlogHandler::getEmailAddressOfRelation()
	 *
	 * @param mixed $value
	 * @return
	 */
	public function getEmailAddressOfRelation($value)
	{
	    $relation_id = $value?$value:0;
 	    $sql = 'SELECT u.email FROM '.$this->CFG['db']['tbl']['friends_relation'].' AS fr,'.
				' '.$this->CFG['db']['tbl']['friends_list'].' AS fl LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u'.
				' ON (u.user_id = IF(fl.owner_id='.$this->dbObj->Param('owner_id').',fl.friend_id, fl.owner_id)'.
				' AND u.usr_status=\'Ok\' ) WHERE (fr.relation_id IN('.$relation_id.') AND fl.id=fr.friendship_id)';

	    $stmt = $this->dbObj->Prepare($sql);
	    $rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
	    if (!$rs)
	    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

	    if($rs->PO_RecordCount())
	    {
			while($row = $rs->FetchRow())
			{
		  	  	$value = trim($row['email']);
			  	$this->EMAIL_ADDRESS[] = $value;
			}
	    }
	   return true;
 	}
	public function getSharePostMailDetails()
		{
			$sql = 'SELECT blog_post_name, '.
					' message FROM '.$this->CFG['db']['tbl']['blog_posts'].
					' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($row = $rs->FetchRow())
				{
					$this->BLOG_POST_NAME = $row['blog_post_name'];
					$this->BLOG_DESCRIPTION = wordWrap_mb_Manual(strip_tags($row['message']),
												$this->CFG['admin']['blog']['message_share_blog_post_length'],
													$this->CFG['admin']['blog']['message_share_blog_post_total_length']);
					return true;
				}
			return false;
		}
 	/**
 	 * BlogHandler::sendEmailToAll()
 	 *
 	 * @return
 	 */
 	public function sendEmailToAll()
	{
		$this->EMAIL_ADDRESS = array_unique($this->EMAIL_ADDRESS);
		if($this->EMAIL_ADDRESS)
			{
				if($this->getSharePostMailDetails())
					{

								foreach($this->EMAIL_ADDRESS as $email)
									{
										$mailSent = false;
										$subject = $this->LANG['blog_post_share_subject'];
										$subject = str_replace('VAR_USER_NAME', $this->CFG['user']['name'], $subject);
										$body = $this->LANG['blog_post_share_content'];
										if(isMember())
											{
												$postlink = $this->getAffiliateUrl(getUrl('viewpost', '?blog_post_id='.$this->fields_arr['blog_post_id'].'&title='.
																$this->changeTitle($this->BLOG_POST_NAME), $this->fields_arr['blog_post_id'].'/'.
																	$this->changeTitle($this->BLOG_POST_NAME).'/', 'root', 'blog'));
												//$this->setEmailTemplateValue('user_name', $this->CFG['user']['name']);
												//$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
												$body = str_replace('VAR_USER_NAME', $this->CFG['user']['name'], $body);
												$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
											}
										else
											{
												$postlink = $this->getAffiliateUrl(getUrl('viewpost', '?blog_post_id='.$this->fields_arr['blog_post_id'].'&title='.$this->changeTitle($this->BLOG_POST_NAME), $this->fields_arr['blog_post_id'].'/'.$this->changeTitle($this->BLOG_POST_NAME).'/', 'root', 'blog'));
												//$this->setEmailTemplateValue('user_name', $this->fields_arr['first_name']);
												//$this->setEmailTemplateValue('site_name', $this->CFG['site']['name']);
												$body = str_replace('VAR_USER_NAME', $this->CFG['user']['name'], $body);
												$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
											}

										$body = str_replace('BLOG_POST_NAME', $this->BLOG_POST_NAME, $body);
										$body = str_replace('BLOG_POST_DESCRIPTION', $this->BLOG_DESCRIPTION, $body);
										$body = str_replace('PERSONAL_MESSAGE', $this->fields_arr['personal_message'], $body);
										$body = str_replace('VAR_SITE_URL', $postlink, $body);
										$body = str_replace('VIEW_BLOG_POST', $this->getAffiliateUrl($this->CFG['site']['url']), $body);

								if(isMember())
									{
										$mail->FromName = $this->CFG['user']['name'];
										$mail->From = $mail->Sender = $this->CFG['user']['email'];
									}
								else
									{
										$mail->FromName = $this->fields_arr['first_name'];
										$mail->From = $mail->Sender = $this->CFG['site']['noreply_email'];
									}

								$this->_sendMail($email, $subject, $body, $mail->FromName, $mail->From);
							}
						return true;
					}
				return false;
			}
	}
	/**
	 * BlogHandler::addBlogPostCreatedActivity()
	 *
	 * @param mixed $blog_post_id
	 * @return
	 */
	public function addBlogPostCreatedActivity($blog_post_id)
	{
		//Start new blog post created activity
		$sql = 'SELECT u.user_name as upload_user_name, b.blog_post_id, b.user_id as upload_user_id, '.
		        ' b.blog_post_name FROM '.$this->CFG['db']['tbl']['blog_posts'].
				' as b, '.$this->CFG['db']['tbl']['users'].' as u '.
				' WHERE u.user_id = b.user_id AND b.blog_post_id='.$this->dbObj->Param('blog_post_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($blog_post_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		$activity_arr = $row;
		$activity_arr['action_key']	= 'blog_post_created';
		$blogActivityObj = new BlogActivityHandler();
		$blogActivityObj->addActivity($activity_arr);
		//End..
	}
	/**
	 * BlogHandler::sendMailToUserForActivate()
	 *
	 * @param mixed $blog_post_id
	 * @return
	 */
	public function sendMailToUserForActivate($blog_post_id)
	{
		$this->populateBlogPostDetails($blog_post_id);
		$subject = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $this->LANG['blog_post_activate_subject']);
		$body = $this->LANG['blog_post_activate_content'];
		$blog_post_link = getUrl('viewpost','?blog_post_id='.$this->BLOG_POST_ID.$this->changeTitle($this->BLOG_POST_NAME),
						$this->BLOG_POST_ID.'/'.$this->changeTitle($this->BLOG_POST_NAME).'/', 'root','blog');
		$body = str_replace('VAR_LINK', '<a href=\''.$this->CFG['site']['url'].'\'>'.$this->CFG['site']['url'].'</a>', $body);
		$body = str_replace('VAR_USER_NAME', $this->BLOG_USER_NAME, $body);
		$body = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $body);
		$body = str_replace('VAR_BLOG_POST_NAME', $this->BLOG_POST_NAME, $body);
		$body = str_replace('VAR_BLOG_POST_LINK', '<a href=\''.$blog_post_link.'\'>'.$blog_post_link.'</a>', $body);
		$body=nl2br($body);

		if($this->_sendMail($this->BLOG_USER_EMAIL, $subject, $body, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']))
			return true;
		else
			return false;
	}
	/**
	 * BlogHandler::populateBlogListHidden()
	 *
	 * @param mixed $hidden_field
	 * @return
	 */
	public function populateBlogListHidden($hidden_field)
	{
		foreach($hidden_field as $hidden_name)
		{
			//when submit the form through javascript and if not submit in IE,then check hidden input with the name set as "action", obviously this confused IE.
			//refer http://bytes.com/topic/javascript/answers/92323-form-action-help-needed
			if($hidden_name == 'action')
				$hidden_name = 'action_new';
?>
			<input type="hidden" name="<?php echo $hidden_name;?>" value="<?php echo isset($this->fields_arr[$hidden_name])?$this->fields_arr[$hidden_name]:'';?>" />
<?php
		}
	}
	/**
	 * BlogHandler::getBlogPostDetails()
	 *
	 * @return
	 */
	public function getBlogPostDetails()
	{
		$sql = 'SELECT blog_post_name, message'.
				' FROM '.$this->CFG['db']['tbl']['blog_posts'].
				' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
			{
				$this->BLOG_POST_NAME = $row['blog_post_name'];
				$this->BLOG_POST_DESCRIPTION = wordWrap_mb_Manual(strip_tags($row['message']), $this->CFG['admin']['blog']['message_share_blog_post_length'], $this->CFG['admin']['articles']['message_share_blog_post_total_length']);

				$this->view_blog_post_link = getUrl('viewblogpost', '?blog_post_id='.$this->fields_arr['blog_post_id'].'&amp;title='.$this->changeTitle($row['blog_post_name']), $this->fields_arr['blog_post_id'].'/'.$this->changeTitle($row['blog_post_name']).'/', 'root', 'blog');
				return true;
			}
		return false;
	}
	/**
	 * BlogHandler::populateBlogRatingImages()
	 *
	 * @param integer $rating
	 * @param string $imagePrefix
	 * @param string $condition
	 * @param string $url
	 * @return
	 */
	public function populateBlogRatingImages($rating = 0,$imagePrefix='',$condition='',$url='')
	{

		$rating = round($rating,0);
		global $smartyObj;
		$populateRatingImages_arr = array();
		$populateRatingImages_arr['rating'] = $rating;
		$populateRatingImages_arr['condition'] = $condition;
		$populateRatingImages_arr['url'] = $url;
		$populateRatingImages_arr['rating_total'] = $this->CFG['admin']['total_rating'];
		if($populateRatingImages_arr['rating']>$populateRatingImages_arr['rating_total'])
			$populateRatingImages_arr['rating'] = $populateRatingImages_arr['rating_total'];
		$populateRatingImages_arr['bulet_star'] = $this->CFG['site']['blog_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-'.$imagePrefix.'ratehover.gif';
		$populateRatingImages_arr['bulet_star_empty'] = $this->CFG['site']['blog_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-'.$imagePrefix.'rate.gif';
		$smartyObj->assign('populateRatingImages_arr', $populateRatingImages_arr);
		setTemplateFolder('general/', 'blog');
		$smartyObj->display('populateBlogPostRatingImages.tpl');
	}
	/**
	 * BlogHandler::getBlogPostsTagsLinks()
	 *
	 * @param mixed $blog_post_tags
	 * @param mixed $taglimit
	 * @param string $tag_serach_word
	 * @return
	 */
	public function getBlogPostsTagsLinks($blog_post_tags,$taglimit,$tag_serach_word='')
	{
		// change the function for display the tags with some more...
		global $smartyObj;
		$tags_arr = explode(' ', $blog_post_tags);

		if(count($tags_arr)>$taglimit)
		{
			$blog_post_tag_size=$taglimit;
		}
		else
		{
			$blog_post_tag_size=count($tags_arr);
		}
		for($i=0;$i<$blog_post_tag_size;$i++)
		{
			if($i<$this->CFG['admin']['blog']['member_blog_post_tags_name_total_length'])
			{
				if(strlen($tags_arr[$i]) > $this->CFG['admin']['blog']['member_blog_post_tags_keyword_total_length'])
					$getTagsLink_arr[$i]['title_tag_name'] = $getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = wordWrap_mb_Manual($tags_arr[$i], 5, $this->CFG['admin']['blog']['member_blog_post_tags_keyword_total_length'], true);
				else
					$getTagsLink_arr[$i]['title_tag_name'] = $getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = $tags_arr[$i];
				if(!empty($tag_serach_word))
					$getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = highlightWords($getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'], $tag_serach_word);
			    $getTagsLink_arr[$i]['tag_url'] = getUrl('blogpostlist', '?pg=blogpostnew&tags='.$tags_arr[$i], 'blogpostnew/?tags='.$tags_arr[$i], '', 'blog');
				if($i%2==0)
				{
					$getTagsLink_arr[$i]['class']='clsTagsDefalult';
				}
				else
				{
					$getTagsLink_arr[$i]['class']='clsTagsAlternate';
				}
				if($i<($blog_post_tag_size-1))
					$getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'].=',';
			}

		}

		$smartyObj->assign('getTagsLink_arr', $getTagsLink_arr);
		setTemplateFolder('general/', 'blog');
		$smartyObj->display('populateTagsLinks.tpl');
	}
	/**
	 * BlogHandler::deleteBlogPosts()
	 *
	 * @param array $blog_post_id_arr
	 * @param mixed $user_id
	 * @return
	 */
	public function deleteBlogPosts($blog_post_id_arr = array(), $user_id)
	{
		$blog_post_id = implode(',',$blog_post_id_arr);

		$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET status=\'Deleted\''.
				' WHERE blog_post_id IN('.$blog_post_id.')';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($affected_rows = $this->dbObj->Affected_Rows())
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
						' total_posts=total_posts-'.$affected_rows.
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);


				//*********Delete records from Article related tables start*****
				$tablename_arr = array('blog_comments', 'blog_favorite', 'blog_viewed', 'blog_rating');
				for($i=0;$i<sizeof($tablename_arr);$i++)
					{
						$sql = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].
								' WHERE blog_post_id IN('.$blog_post_id.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}

				//DELETE FLAGGED CONTENTS
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].
						' WHERE content_type=\'Blog\' AND content_id IN('.$blog_post_id.')';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				//**********End************

				//activity tables.
				$action_key = array('blog_post_created', 'blog_post_comment', 'blog_post_rated', 'blog_post_favorite', 'blog_post_featured');
				for($inc=0;$inc<count($action_key);$inc++)
				{
					$condition = '  SUBSTRING_INDEX(action_value, \'~\', 1 ) IN ('.$blog_post_id.') AND action_key = \''.$action_key[$inc].'\'';

					$sql='SELECT parent_id FROM '.$this->CFG['db']['tbl']['blog_activity'].' WHERE '.$condition;
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

					if ($rs->PO_RecordCount()>0)
					{
						$parent_id ='';
						while($row = $rs->FetchRow())
						{
							if($parent_id=='')
							{
								$parent_id = $row['parent_id'];
							}
							else
							{
								$parent_id = $parent_id.','.$row['parent_id'];
							}
						}
					}
					$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['blog_activity'].' WHERE '.$condition;
					$stmt = $this->dbObj->Prepare($sql);
					$rs   = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

					if(!empty($parent_id))
					{
						$condition_act = '  parent_id IN ('.$parent_id.') ';
						$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['activity'].' WHERE '.$condition_act;
						$stmt = $this->dbObj->Prepare($sql);
						$rs   = $this->dbObj->Execute($stmt);
				    	if (!$rs)
					    	trigger_db_error($this->dbObj);
					}
				}
			}

		return true;
	}
	/**
	 * BlogHandler::deleteFavoriteBlogPost()
	 *
	 * @param mixed $blog_post_id
	 * @param mixed $user_id
	 * @return
	 */
	public function deleteFavoriteBlogPost($blog_post_id, $user_id)
	{
		$sql = 'SELECT bf.blog_favorite_id, bf.user_id as favorite_user_id, bp.user_id '.
				' FROM '.$this->CFG['db']['tbl']['blog_favorite'].' as bf, '.
				$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['blog_posts'].' as bp '.
				' WHERE u.user_id = bf.user_id AND bf.blog_post_id = bp.blog_post_id AND bf.user_id = '.
				$this->dbObj->Param('user_id').' AND bf.blog_post_id = '.$this->dbObj->Param('blog_post_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($user_id, $blog_post_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		$activity_arr = $row;
		$activity_arr['action_key']	= 'delete_blog_post_favorite';
		$photoActivityObj = new PhotoActivityHandler();
		$photoActivityObj->addActivity($activity_arr);

		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['blog_favorite'].' WHERE'.
				' user_id=' . $this->dbObj->Param('user_id') . ' AND' . ' blog_post_id=' . $this->dbObj->Param('blog_post_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($user_id, $blog_post_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($this->dbObj->Affected_Rows())
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET total_favorites = total_favorites-1'.
		 			' WHERE blog_post_id=' . $this->dbObj->Param('blog_post_id');

			$stmt   = $this->dbObj->Prepare($sql);
			$rs     = $this->dbObj->Execute($stmt, array($blog_post_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		}
	}
	/**
	 * BlogHandler::selectFeaturedPost()
	 *
	 * @param mixed $condition
	 * @param mixed $value
	 * @param string $returnType
	 * @return
	 */
	public function selectFeaturedPost($condition, $value, $returnType='')
	{
		$sql = 'SELECT blog_featured_id FROM '.$this->CFG['db']['tbl']['blog_featured'].
					' WHERE '.$condition;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $value);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if(!$returnType)
			return $rs->PO_RecordCount();
		else
			return $rs;
	}
	/**
	 * BlogHandler::selectFavoritePost()
	 *
	 * @param mixed $condition
	 * @param mixed $value
	 * @param string $returnType
	 * @return
	 */
	public function selectFavoritePost($condition, $value, $returnType='')
	{
		$sql = 'SELECT blog_favorite_id FROM '.$this->CFG['db']['tbl']['blog_favorite'].
					' WHERE '.$condition;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $value);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if(!$returnType)
			return $rs->PO_RecordCount();
		else
			return $rs;
	}
	/**
	 * BlogHandler::deleteFavoritePost()
	 *
	 * @param mixed $blog_post_id
	 * @param mixed $user_id
	 * @return
	 */
	public function deleteFavoritePost($blog_post_id, $user_id)
	{
		$sql = 'SELECT bf.blog_favorite_id, bf.user_id as favorite_user_id, bp.user_id '.
				' FROM '.$this->CFG['db']['tbl']['blog_favorite'].' as bf, '.
				$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['blog_posts'].' as bp '.
				' WHERE u.user_id = bf.user_id AND bf.blog_post_id = bp.blog_post_id AND bf.user_id = '.
				$this->dbObj->Param('user_id').' AND bf.blog_post_id = '.$this->dbObj->Param('blog_post_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($user_id, $blog_post_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		$activity_arr = $row;
		$activity_arr['action_key']	= 'delete_blog_post_favorite';
		$blogActivityObj = new BlogActivityHandler();
		$blogActivityObj->addActivity($activity_arr);

		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['blog_favorite'].' WHERE'.
				' user_id=' . $this->dbObj->Param('user_id') . ' AND' . ' blog_post_id=' . $this->dbObj->Param('blog_post_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($user_id, $blog_post_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($this->dbObj->Affected_Rows())
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET total_favorites = total_favorites-1'.
		 			' WHERE blog_post_id=' . $this->dbObj->Param('blog_post_id');

			$stmt   = $this->dbObj->Prepare($sql);
			$rs     = $this->dbObj->Execute($stmt, array($blog_post_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		}
	}
	/**
	 * BlogHandler::deleteFromFeatured()
	 *
	 * @param mixed $displayMsg
	 * @param mixed $blog_post_id
	 * @return
	 */
	public function deleteFromFeatured($displayMsg, $blog_post_id)
	{
		//Start delete post featured blog activity..
		$sql = 'SELECT bf.blog_featured_id, bf.user_id as featured_user_id, bp.user_id '.
				' FROM '.$this->CFG['db']['tbl']['blog_featured'].' as bf, '.
				$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['blog_posts'].' as bp '.
				' WHERE u.user_id = bf.user_id AND bf.blog_post_id = bp.blog_post_id AND bf.user_id = '.
				$this->dbObj->Param('user_id').' AND bf.blog_post_id = '.$this->dbObj->Param('blog_post_id');

		$fields_value_arr = array($this->CFG['user']['user_id'], $blog_post_id);

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		if(!empty($row))
			{
				$activity_arr = $row;
				$activity_arr['action_key']	= 'delete_blog_post_featured';
				$blogActivityObj = new BlogActivityHandler();
				$blogActivityObj->addActivity($activity_arr);
			}
		//end
		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['blog_featured'].
				' WHERE user_id='.$this->dbObj->Param('user_id').
				' and blog_post_id='.$this->dbObj->Param('blog_post_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $blog_post_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($this->dbObj->Affected_Rows())
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET total_featured = total_featured-1'.
						' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id');
				$stmt = $this->dbObj->Prepare($sql);

				$rs = $this->dbObj->Execute($stmt, array($blog_post_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($displayMsg)
					echo $this->LANG['viewpost_featured_deleted_successfully'];
			}
	}
	/**
	 * BlogHandler::getArchiveBlogYearDetails()
	 *
	 * @param mixed $blog_id
	 * @return
	 */
	public function getArchiveBlogYearDetails($blog_id,$blog_name)
	{
		global $smartyObj;
		$sql = 'SELECT COUNT( blog_post_id ) AS year_total_post, YEAR(date_added) AS year '.
				' FROM '.$this->CFG['db']['tbl']['blog_posts'].
				' WHERE  status=\'Ok\' AND blog_id = '.$this->dbObj->Param('blog_id').
				' GROUP BY year ORDER BY year DESC ';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt,array($blog_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$inc=0;
		$archive_year=array();
		if(!$rs->PO_RecordCount())
		  return false;

        while($row = $rs->FetchRow())
        {
			$archive_year[$inc]['year']			   = $row['year'];
			$archive_year[$inc]['blog_link']	   = getUrl('viewblog','?blog_name='.$blog_name.'&y='.$row['year'],$blog_name.'/?y='.$row['year'],'','blog');
			$archive_year[$inc]['year_total_post'] = $row['year_total_post'];
			$archive_year[$inc]['month_archive']   = $this->getArchiveBlogMonthDetails($blog_id,$blog_name,$row['year']);
			$inc++;
		}
		$smartyObj->assign('archive_year', $archive_year);
		setTemplateFolder('general/', 'blog');
		$smartyObj->display('populateBlogArchiveBlock.tpl');
	}
	/**
	 * BlogHandler::getArchiveBlogMonthDetails()
	 *
	 * @param mixed $blog_id
	 * @param mixed $year
	 * @return
	 */
	public function getArchiveBlogMonthDetails($blog_id,$blog_name,$year)
	{
		$sql = 'SELECT COUNT(blog_post_id) AS month_total_post, MONTHNAME(date_added) AS month_name, MONTH(date_added) AS month '.
				' FROM '.$this->CFG['db']['tbl']['blog_posts'].
				' WHERE blog_id = '.$this->dbObj->Param('blog_id').
				' AND status=\'Ok\' AND YEAR(date_added) = '.$year.' GROUP BY month_name ORDER BY month DESC ';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt,array($blog_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$inc=0;
		$archive_month=array();
		if(!$rs->PO_RecordCount())
		  return false;

        while($row = $rs->FetchRow())
        {
			$archive_month[$inc]['month_name']	  = $row['month_name'];
			$archive_month[$inc]['blog_link']	  = getUrl('viewblog','?blog_name='.$blog_name.'&y='.$year.'&m='.$row['month_name'],$blog_name.'/?y='.$year.'&m='.$row['month_name'],'','blog');
			$archive_month[$inc]['month_total_post']	=$row['month_total_post'];
			$inc++;
		}
		return $archive_month;
	}
	/**
	 * BlogHandler::getPreviousPostLink()
	 *
	 * @param mixed $blog_id
	 * @param mixed $blog_post_id
	 * @return
	 */
	public function getPreviousPostLink($blog_id,$blog_post_id)
	{
		$sub = 'bp.user_id=\''.$this->fields_arr['user_id'].'\'';

		$condition = 'b.blog_status=\'Active\' AND b.blog_id=bp.blog_id AND bp.blog_id ='.$blog_id.
		             ' AND bp.status=\'Ok\' AND bp.blog_post_id<\''.addslashes($blog_post_id).'\''.' AND '.$sub.' AND'.
					' (bp.user_id = '.$this->CFG['user']['user_id'].' OR bp.blog_access_type = \'Public\''.
					 $this->getAdditionalQuery('bp.').')';

		$sql = 'SELECT bp.blog_post_id, blog_post_name'.
		       ' FROM '.$this->CFG['db']['tbl']['blogs'].' as b ,'.$this->CFG['db']['tbl']['blog_posts'].' as bp'.
			   ' WHERE '.$condition.' ORDER BY blog_post_id DESC LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
       $this->previousPostLink='';
		if($row = $rs->FetchRow() and $row['blog_post_id'])
			{
				$this->previousPostLink = getUrl('viewpost', '?blog_post_id='.$row['blog_post_id'].'&amp;title='.$this->changeTitle($row['blog_post_name']), $row['blog_post_id'].'/'.$this->changeTitle($row['blog_post_name']).'/', '', 'blog');
			}
	}
	/**
	 * BlogHandler::getNextPostLink()
	 *
	 * @param mixed $blog_id
	 * @param mixed $blog_post_id
	 * @return
	 */
	public function getNextPostLink($blog_id,$blog_post_id)
	{
		$sub = 'bp.user_id=\''.$this->fields_arr['user_id'].'\'';

		$condition = 'b.blog_status=\'Active\' AND b.blog_id=bp.blog_id AND bp.blog_id ='.$blog_id.
		             ' AND bp.status=\'Ok\' AND bp.blog_post_id>\''.addslashes($blog_post_id).'\''.' AND '.$sub.' AND'.
					' (bp.user_id = '.$this->CFG['user']['user_id'].' OR bp.blog_access_type = \'Public\''.
					 $this->getAdditionalQuery('bp.').')';

		$sql = 'SELECT bp.blog_post_id, blog_post_name'.
		       ' FROM '.$this->CFG['db']['tbl']['blogs'].' as b ,'.$this->CFG['db']['tbl']['blog_posts'].' as bp'.
			   ' WHERE '.$condition.' ORDER BY blog_post_id DESC LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
       $this->nextPostLink='';
		if($row = $rs->FetchRow() and $row['blog_post_id'])
			{
				$this->nextPostLink = getUrl('viewpost', '?blog_post_id='.$row['blog_post_id'].'&amp;title='.$this->changeTitle($row['blog_post_name']), $row['blog_post_id'].'/'.$this->changeTitle($row['blog_post_name']).'/', '', 'blog');
			}
	}
	/**
	 * BlogHandler::chkThisUserAllowedToPost()
	 *
	 * @return
	 */
	public function chkThisUserAllowedToPost()
	{
		$sql = 'SELECT blog_id FROM '.
				$this->CFG['db']['tbl']['blogs'].
				' WHERE  blog_status=\'Active\''.
				' AND user_id='.$this->dbObj->Param('user_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if(!$rs->PO_RecordCount())
		   return false;

		if($row = $rs->FetchRow())
		  {
			$this->BLOG_ID=$row['blog_id'];
			return true;
		  }

	}
	public function populateBlogCategory($blog_id=0,$blog_name='')
	 {
		global $smartyObj;
		$populateBlogCategory_arr = array();
		$populateBlogCategory_arr['record_count'] = false;

		$allowed_pages_array = array();
		if(displayBlock($allowed_pages_array))
			return;

		//Category LIST priority vise or blog_category_name//
		if($this->CFG['admin']['blog']['blog_category_list_priority'])
			$short_by = 'priority';
		else
			$short_by = 'blog_category_name';

		$addtional_condition = '';

		$limit='';
		if(!$blog_id)
		 $limit =' LIMIT 0, '.$this->CFG['admin']['blog']['sidebar_category_num_record'];

		$sql = 'SELECT blog_category_id, blog_category_name FROM '.$this->CFG['db']['tbl']['blog_category'].'  '.
				'WHERE '.$addtional_condition.' parent_category_id = \'0\' AND blog_category_status = \'Yes\' ORDER BY '.$short_by.
				' ASC'.$limit;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$populateBlogCategory_arr['row'] = array();
		$inc = 0;
		While($categoryDetail = $rs->FetchRow())
		{
			$populateBlogCategory_arr['record_count'] = true;
			$populateBlogCategory_arr['row'][$inc]['blog_category_name'] = wordWrap_mb_ManualWithSpace($categoryDetail['blog_category_name'],
																		$this->CFG['admin']['blog']['sidebar_category_name_length'],
																		$this->CFG['admin']['blog']['sidebar_category_name_total_length']);
			$populateBlogCategory_arr['row'][$inc]['record'] 				  = $categoryDetail;
			$populateBlogCategory_arr['row'][$inc]['postCount'] 		  = $this->blogCount($categoryDetail['blog_category_id'],$blog_id);
			$populateBlogCategory_arr['row'][$inc]['populateSubCategory'] 	  = $this->populateSubCategory($categoryDetail['blog_category_id'],$blog_id,$blog_name);
			$populateBlogCategory_arr['row'][$inc]['blogpostlist_url'] 		  = getUrl('blogpostlist', '?pg=postnew&amp;cid='.$categoryDetail['blog_category_id'],
																		'postnew/?cid='.$categoryDetail['blog_category_id'], '', 'blog');
			if($blog_id)
				$populateBlogCategory_arr['row'][$inc]['blogpostlist_url']= getUrl('viewblog', '?blog_name='.$blog_name.'&cid='.$categoryDetail['blog_category_id'],
																		$blog_name.'/?cid='.$categoryDetail['blog_category_id'], '', 'blog');
			$inc++;
		}
		$smartyObj->assign('morecategory_url', getUrl('blogcategory', '', '', '', 'blog'));
		if($blog_id)
		  $smartyObj->assign('morecategory_url', '');

		$smartyObj->assign('populateBlogCategory_arr', $populateBlogCategory_arr);
		$smartyObj->assign('cid', isset($_GET['cid'])?$_GET['cid']:'0');
		$smartyObj->assign('sid', isset($_GET['sid'])?$_GET['sid']:'0');
		setTemplateFolder('general/', 'blog');
		$smartyObj->display('populateCategoryBlock.tpl');
	 }
	 public function blogCount($category=0,$blog_id=0)
	 {
		if($category)
			$condition = 'AND ( blog_category_id = '.$category.' OR blog_sub_category_id = '.$category.')';

		if($blog_id)
		   	$condition .= ' AND blog_id = '.$blog_id;

		$sql = 'SELECT count(blog_post_id) as total FROM '.$this->CFG['db']['tbl']['blog_posts'].
				' WHERE status = \'Ok\' AND ( user_id = ' . $this->CFG['user']['user_id']. ' OR blog_access_type = \'Public\' ) '.$condition;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		return $row['total'];
	}
	public function populateSubCategory($category_id,$blog_id=0,$blog_name='')
	 {
		$populateSubCategory = array();
		$populateSubCategory['record_count'] = false;
		//SUBCATEGORY LIST priority vise or blog_category_name//
		if($this->CFG['admin']['blog']['blog_category_list_priority'])
			$short_by = 'priority';
		else
			$short_by = 'blog_category_name';

		  $limit='';
	      if(!$blog_id)
		      $limit =' LIMIT 0, '.$this->CFG['admin']['blog']['sidebar_category_num_record'];

		$sql  = 'SELECT blog_category_id, blog_category_name FROM '.$this->CFG['db']['tbl']['blog_category'].'  '.
			    'WHERE parent_category_id = \''.$category_id.'\' AND blog_category_status = \'Yes\' ORDER BY '.$short_by.
			    ' ASC '.$limit;

		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$populateSubCategory['row'] = array();
		$inc = 0;
		While($categoryDetail = $rs->FetchRow())
			{
				$populateSubCategory['record_count'] = true;
				$populateSubCategory['row'][$inc]['blog_category_name'] = wordWrap_mb_ManualWithSpace($categoryDetail['blog_category_name'],
																		   $this->CFG['admin']['blog']['sidebar_category_name_length'],
																		   $this->CFG['admin']['blog']['sidebar_category_name_total_length']);
				$populateSubCategory['row'][$inc]['record'] 				 = $categoryDetail;
				$populateSubCategory['row'][$inc]['postCount'] 		 = $this->blogCount($categoryDetail['blog_category_id'],$blog_id);
				$populateSubCategory['row'][$inc]['blogpostlist_url'] 		 = getUrl('blogpostlist', '?pg=postnew&amp;cid='.$category_id.'&amp;sid='.$categoryDetail['blog_category_id'], 'postnew/?cid='.$category_id.'&amp;sid='.$categoryDetail['blog_category_id'], '', 'blog');

				if($blog_id)
				$populateSubCategory['row'][$inc]['blogpostlist_url']= getUrl('viewblog', '?blog_name='.$blog_name.'cid='.$category_id.'&amp;sid='.$categoryDetail['blog_category_id'],
																		$blog_name.'/?cid='.$category_id.'&amp;sid='.$categoryDetail['blog_category_id'], '', 'blog');
				$inc++;
			}
		return $populateSubCategory;
	 }
	 /**
	  * BlogHandler::deletePostComments()
	  *
	  * @param mixed $ids
	  * @return
	  */
	 public function deletePostComments($ids)
	 {
		$comment_id = explode(',', $ids);
		for($inc=0;$inc<count($comment_id);$inc++)
		{
			//FETCH RECORD FOR comment_status //
			$sql = 'SELECT comment_status, blog_post_id FROM '.$this->CFG['db']['tbl']['blog_comments'].' WHERE'.
					' blog_comment_id ='.$comment_id[$inc];

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$commentDetail = $rs->FetchRow();

			//DELETE COMMENTS//
			$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['blog_comments'].' WHERE'.
					' blog_comment_id ='.$comment_id[$inc];

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			//CONTROL: IF comment_status = yes THEN WE REDUCES THE  total_comments//
			if($commentDetail['comment_status'] == 'Yes')
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET total_comments=total_comments-1'.
						' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($commentDetail['blog_post_id']));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		}
	 }
	 /**
	  * BlogHandler::chkPostExistInActivity()
	  *
	  * @param mixed $blog_post_id
	  * @return
	  */
	 public function chkPostExistInActivity($blog_post_id)
	{

		$action_key = 'blog_post_created';
		$condition = ' SUBSTRING_INDEX(action_value, \'~\', 1 ) IN ('.$blog_post_id.') AND action_key = \''.$action_key.'\'';

		$sql = 'SELECT parent_id FROM '.$this->CFG['db']['tbl']['blog_activity'].' WHERE '.$condition;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount()>0)
		{
			return true;
		}
		return false;
	}
	/**
	 * BlogHandler::addPostCreatedActivity()
	 *
	 * @param mixed $blog_post_id
	 * @return
	 */
	public function addPostCreatedActivity($blog_post_id)
	{
		//Start new post created activity
		$sql = 'SELECT u.user_name as upload_user_name, bp.blog_post_id, bp.user_id as upload_user_id, '.
		        ' bp.blog_post_name FROM '.$this->CFG['db']['tbl']['blog_posts'].
				' as bp, '.$this->CFG['db']['tbl']['users'].' as u '.
				' WHERE u.user_id = bp.user_id AND bp.blog_post_id='.$this->dbObj->Param('blog_post_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($blog_post_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		$activity_arr = $row;
		$activity_arr['action_key']	= 'blog_post_created';
		$blogActivityObj = new BlogActivityHandler();
		$blogActivityObj->addActivity($activity_arr);
		//End..
	}
	/**
	 * BlogHandler::populateSidebarClouds()
	 *
	 * @param mixed $module
	 * @param mixed $tags_table
	 * @return
	 */
	public function populateSidebarClouds($module, $tags_table,$blog_id=0,$blog_name='')
	{
		global $smartyObj;
		$return = array();
		$return['resultFound']=false;

		$allowed_pages_array = array();
		if(displayBlock($allowed_pages_array))
			return;
		$condition='';
		if($blog_id)
		  $condition=' AND blog_id='.$blog_id.' ';

		if($this->CFG['admin']['tagcloud_based_search_count'])
		{
			$sql = 'SELECT tag_name, search_count FROM '.$this->CFG['db']['tbl'][$tags_table].
					' WHERE search_count>0 '.$condition.' ORDER BY search_count DESC, result_count DESC, tag_name DESC'.
					' LIMIT 0, '.$this->CFG['admin']['blog']['sidebar_clouds_num_record'];
		}
		else
		{
			$sql = 'SELECT tag_name, result_count AS search_count FROM'.
					' '.$this->CFG['db']['tbl'][$tags_table].
					' WHERE result_count>0 '.$condition.' ORDER BY result_count DESC, tag_name DESC'.
					' LIMIT 0, '.$this->CFG['admin']['blog']['sidebar_clouds_num_record'];
		}

		$searchUrl = getUrl('blogpostlist', '?pg=postnew&tags=%s', 'postnew/?tags=%s', '', 'blog');
		$moreclouds_url = getUrl('tags', '?pg=blog', 'blog/', '', 'blog');

		if($blog_id)
		  {
			  $searchUrl = getUrl('viewblog', '?blog_name='.$blog_name.'&tags=%s', $blog_name.'/?tags=%s', '', 'blog');
			  $moreclouds_url = getUrl('blogtags', '?blog_id='.$blog_id.'&blog_name='.$blog_name, $blog_id.'/'.$blog_name.'/', '', 'blog');
		  }


		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount()>0)
		{
			$return['resultFound']=true;
			$classes = array('clsBlogTagStyleGrey', 'clsBlogTagStyleGreen');
			$tagClassArray = array();
			while($row = $rs->FetchRow())
			{
					$tagArray[$row['tag_name']] = $row['search_count'];
					$class = $classes[rand(0, count($classes))%count($classes)];
					$tagClassArray[$row['tag_name']] = $class;
			}
			$tagArray = $this->setBlogFontSizeInsteadOfSearchCountSidebar($tagArray);
			ksort($tagArray);
			$inc=0;
			foreach($tagArray as $tag=>$fontSize)
			{
				$url 	= sprintf($searchUrl, $tag);
				$class 	= $tagClassArray[$tag];
				$fontSizeClass= 'style="font-size:'.$fontSize.'px"';
				$return['item'][$inc]['url']=$url;
				$return['item'][$inc]['class']=$class;
				$return['item'][$inc]['fontSizeClass']=$fontSizeClass;
				$return['item'][$inc]['wordWrap_mb_ManualWithSpace_tag']= wordWrap_mb_ManualWithSpace($tag, $this->CFG['admin']['blog']['sidebar_clouds_name_length'], $this->CFG['admin']['blog']['sidebar_clouds_name_total_length']);
				$return['item'][$inc]['name']=$tag;
				$inc++;
			}
		}
		$smartyObj->assign('moreclouds_url', $moreclouds_url);
		$smartyObj->assign('opt', $module);
		$smartyObj->assign('populateCloudsBlock', $return);
		setTemplateFolder('general/', 'blog');
		$smartyObj->display('populateCloudsBlock.tpl');
	}
	/**
	 * BlogHandler::setFontSizeInsteadOfSearchCountSidebar()
	 *
	 * @param array $tag_array
	 * @return
	 */
	public function setBlogFontSizeInsteadOfSearchCountSidebar($tag_array=array())
	{
		return $this->setFontSizeInsteadOfSearchCountSidebar($tag_array);
	}
	/**
	 * BlogHandler::getPreviousBlogLink()
	 *
	 * @param mixed $blog_id
	 * @return
	 */
	public function getPreviousBlogLink($blog_id)
	{

	   $condition = ' blog_status=\'Active\' AND blog_id<\''.addslashes($blog_id).'\'';

	    $sql = 'SELECT blog_id, blog_name FROM '.$this->CFG['db']['tbl']['blogs'].
			   ' WHERE '.$condition.' ORDER BY blog_id DESC LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
       $this->previousPostLink='';
		if($row = $rs->FetchRow())
			{
				$this->previousPostLink = getUrl('viewblog', '?blog_name='.$row['blog_name'], $row['blog_name'].'/', '', 'blog');
			}
	}
	/**
	 * BlogHandler::getNextBlogLink()
	 *
	 * @param mixed $blog_id
	 * @return
	 */
	public function getNextBlogLink($blog_id)
	{

		$condition = ' blog_status=\'Active\' AND blog_id >\''.addslashes($blog_id).'\'';

	    $sql = 'SELECT blog_id, blog_name FROM '.$this->CFG['db']['tbl']['blogs'].
			   ' WHERE '.$condition.' ORDER BY blog_id DESC LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
       $this->nextPostLink='';
		if($row = $rs->FetchRow())
			{
				$this->nextPostLink = getUrl('viewblog', '?blog_name='.$row['blog_name'], $row['blog_name'].'/', '', 'blog');
			}
	}
	/**
	 * BlogHandler::getBlogDetails()
	 *
	 * @param mixed $blog_id
	 * @return
	 */
	public function getBlogDetails($blog_id)
	{
		global $smartyObj;

		$sql = 'SELECT blog_id,blog_name,blog_title, blog_slogan, user_id,blog_logo_ext,width,height,DATE_FORMAT(date_added,\''.$this->CFG['format']['date'].'\') as date_added FROM '.$this->CFG['db']['tbl']['blogs'].
				' WHERE blog_id='.$this->dbObj->Param('blog_id').
				' AND blog_status=\'Active\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($blog_id));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$blogDetail=array();
		$fields_list = array('user_name', 'first_name', 'last_name');
		if($row = $rs->FetchRow())
			{
				if(!isset($this->UserDetails[$row['user_id']]))
					$this->getUserDetail('user_id',$row['user_id'], 'user_name');

				$user_name=$this->getUserDetail('user_id',$row['user_id'], 'user_name');
			    $blogDetail['total_post']   = getTotalPosts($blog_id);
			    $blogDetail['user_name']    = $this->getUserDetail('user_id',$row['user_id'], 'user_name');
			    $blogDetail['profile_url']  = getMemberProfileUrl($row['user_id'], $user_name);
			    $blogDetail['profile_img']  = $this->getUserPhotoDetail($row['user_id']);
			    $blogDetail['profileIcon']= getMemberAvatarDetails($row['user_id']);
			    $blogDetail['width']= $row['width'];
			    $blogDetail['height']= $row['height'];
			    $blogDetail['date_added']= $row['date_added'];

			}
		$smartyObj->assign('blogDetail', $blogDetail);
		setTemplateFolder('general/', 'blog');
		$smartyObj->display('populateBlogUserInfo.tpl');
	}
	/**
	 * BlogHandler::getUserPhotoDetail()
	 *
	 * @param mixed $user_id
	 * @return
	 */
	public function getUserPhotoDetail($user_id)
	{
		$getUserDetail_arr = array();
		$sql = 'SELECT user_id, icon_id, icon_type, image_ext '.
				'FROM '.$this->CFG['db']['tbl']['users'].' WHERE usr_status=\'Ok\' AND user_id='.$user_id;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$getUserDetail['record']  = $rs->FetchRow();
		return getMemberAvatarDetails($getUserDetail['record']['icon_id'], $getUserDetail['record']['icon_type'], $getUserDetail['record']['user_id'], $getUserDetail['record']['image_ext']);

	}


		/**
		 * BlogHandler::populateBlogRecentBlock()
		 *
		 * @return array
		 */
		public function populateBlogRecentBlock($case, $start = 0, $all = false,$current_id ='' )
		{

			global $smartyObj;
			if ($current_id != '') {
				$userBlogCondition = ' AND u. user_id ='.$current_id;
			}
			else
				$userBlogCondition = '';
			$UserDetails = array();
			$fields_list = array('user_name', 'first_name', 'last_name');
			$populateBlogRecentBlock_arr = array();
			$populateBlogRecentBlock_arr['record_count'] = false;
			$populateBlogRecentBlock_arr['row'] = array();
			$blogPostTags = array();
			$tag = array();
			$blogPerRow = $this->CFG['admin']['blog']['list_per_line_total_blog_post'];
			$relatedTags = array();
			$limit = '';
			$userCondition = 'bp.user_id = '.  $this->CFG['user']['user_id'] . ' OR bp.blog_access_type = \'Public\'' . $this->getAdditionalQuery('bp.');
			$default_cond = 'bp.status=\'Ok\' AND b.blog_status=\'Active\' AND u.usr_status=\'Ok\''.$this->getAdultQuery('bp.', 'blog').
								' AND ( ' . $userCondition . ' ) '.$userBlogCondition;
			$default_fields = 'distinct(b.blog_id),b.blog_name, bp.message, bp.blog_post_id, bp.user_id, bp.blog_access_type, DATE_FORMAT(bp.date_of_publish, "%d %b %Y") as published_date,
									  bp.relation_id, bp.blog_post_name, bp.date_added, NOW() as date_current, bp.total_favorites,
									  DATE_FORMAT(bp.date_added, "%d %b %Y") as added_date, bp.total_views, (bp.rating_total/bp.rating_count) as rating,
									  blog_tags, status, TIMEDIFF(NOW(), last_view_date) as blog_last_view_date, total_comments,
									  bc.blog_category_name';
			$default_table = $this->CFG['db']['tbl']['blogs'] . ' AS b '.' JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id JOIN '.$this->CFG['db']['tbl']['users'] . ' AS u ON bp.user_id = u.user_id'.' JOIN '.$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id';
			$limit = 5;
			$this->setFormField('block', $case);
			switch($case)
			{
				case 'blogrecent':
					$order_by = 'bp.date_added DESC';
					$condition = $default_cond;
					$sql = 'SELECT '.$default_fields.' '.
							'FROM '.$default_table.' '.
							'WHERE '.$condition.' ORDER BY '.$order_by;
				break;
			}
			if(!$all)
				$sql .= ' LIMIT '.$start.', '.$limit;
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
				trigger_db_error($this->dbObj);

			$record_count = $rs->PO_RecordCount();
			if($all)
				{
					return $record_count;
				}
			$inc = 1;
			$this->no_of_row=1;
			$count=0;
			$found = false;

			while($blog_detail = $rs->FetchRow())
			{
				$populateBlogRecentBlock_arr['row'][$inc]['user_id'] = $blog_detail['user_id'];

				//To Display the number of days blog post added
				$blog_detail['date_added'] = ($blog_detail['date_added'] != '') ? getTimeDiffernceFormat($blog_detail['date_added']) : '';
				$blog_detail['blog_last_view_date'] = ($blog_detail['blog_last_view_date'] != '') ? getTimeDiffernceFormat($blog_detail['blog_last_view_date']) : '';

				//To Display Blog Post's Added Date in DD MMM YYYY (01 Jan 2009) Format
				$blog_detail['date_added'] = $blog_detail['added_date'];
				$blog_detail['date_published'] = $blog_detail['published_date'];
				$populateBlogRecentBlock_arr['row'][$inc]['record'] = $blog_detail;

				if(!isset($this->UserDetails[$blog_detail['user_id']]))
					$this->getUserDetail('user_id',$blog_detail['user_id'], 'user_name');

				$populateBlogRecentBlock_arr['row'][$inc]['name'] = $this->getUserDetail('user_id',$blog_detail['user_id'], 'user_name');
				$populateBlogRecentBlock_arr['row'][$inc]['view_blog_post_link'] = getUrl('viewpost', '?blog_post_id='.$blog_detail['blog_post_id'].'&amp;title='.$this->changeTitle($blog_detail['blog_post_name']), $blog_detail['blog_post_id'].'/'.$this->changeTitle($blog_detail['blog_post_name']).'/', '', 'blog');
				$populateBlogRecentBlock_arr['row'][$inc]['view_blog_link'] = getUrl('viewblog', '?blog_name='.$blog_detail['blog_name'], $blog_detail['blog_name'].'/', '', 'blog');
				$found = true;
				$populateBlogRecentBlock_arr['row'][$inc]['open_tr'] = false;
				if ($count%$blogPerRow==0)
		    	{
					$populateBlogRecentBlock_arr['row'][$inc]['open_tr'] = false;
		    	}
				$populateBlogRecentBlock_arr['row'][$inc]['anchor'] = 'dAlt_'.$blog_detail['blog_post_id'];

				if($blog_detail['status']=='Locked')
				{
					$populateBlogRecentBlock_arr['row'][$inc]['row_blog_post_name_manual'] = wordWrap_mb_Manual($blog_detail['blog_post_name'],
					  																	$this->CFG['admin']['blog']['title_length_list_view']);

					$populateBlogRecentBlock_arr['row'][$inc]['blog_post_ids_checked'] = '';
				}
				else
				{
					$populateBlogRecentBlock_arr['row'][$inc]['blog_post_posting_url_ok'] = getUrl('manageblogpost', '?blog_post_id='.$blog_detail['blog_post_id'], $blog_detail['blog_post_id'].'/', '', 'blog');

					$populateBlogRecentBlock_arr['row'][$inc]['row_blog_post_name_manual'] = wordWrap_mb_Manual($blog_detail['blog_post_name'],
																						$this->CFG['admin']['blog']['title_length_list_view'], $this->CFG['admin']['blog']['title_total_length_list_view']);

					$populateBlogRecentBlock_arr['row'][$inc]['row_blog_category_name_manual'] = wordWrap_mb_Manual($blog_detail['blog_category_name'], $this->CFG['admin']['blog']['blog_list_category_title'], $this->CFG['admin']['blog']['blog_list_category_title_total_length'], 0);
					$user_name=$this->getUserDetail('user_id',$blog_detail['user_id'], 'user_name');
					$populateBlogRecentBlock_arr['row'][$inc]['member_icon'] =  getMemberAvatarDetails($blog_detail['user_id']);
					$populateBlogRecentBlock_arr['row'][$inc]['userDetails'] = $user_name;
					$populateBlogRecentBlock_arr['row'][$inc]['member_profile_url'] = getMemberProfileUrl($blog_detail['user_id'], $user_name);
					//$populateBlogRecentBlock_arr['row'][$inc]['message']=wordWrap_mb_Manual($blog_detail['message'],$this->CFG['admin']['blog']['blog_post_list_message_length'],$this->CFG['admin']['blog']['blog_post_list_message_total_length']);
					$populateBlogRecentBlock_arr['row'][$inc]['message']=truncateByCheckingHtmlTags(strip_selected_blog_tags($blog_detail['message']),$this->CFG['admin']['blog']['blog_post_list_message_total_length'],'...',true,true);

					$tags= $this->_parse_tags($blog_detail['blog_tags']);
					$populateBlogRecentBlock_arr['row'][$inc]['tags'] = $tags;
					$search_word='';
					if ($tags)
				    {
				    	$populateBlogRecentBlock_arr['row'][$inc]['tags_arr'] = array();
				        $i = 0;
						foreach($tags as $key=>$value)
						{
							if($this->CFG['admin']['blog']['tags_count_list_page']==$i)
								break;
							$value = strtolower($value);
							if (!in_array($value, $tag)  AND !in_array($value, $relatedTags))
								$relatedTags[] = $value;
							if (!in_array($value, $blogPostTags))
						        $blogPostTags[] = $value;

							$populateBlogRecentBlock_arr['row'][$inc]['tags_arr'][$i]['url'] = getUrl('blogpostlist', '?pg=postnew&amp;tags='.$value, 'postnew/?tags='.$value, '', 'blog');
							$populateBlogRecentBlock_arr['row'][$inc]['tags_arr'][$i]['value'] = highlightWords($value, $search_word);
							$i++;
						}
					 }
				}
				$count++;
				$populateBlogRecentBlock_arr['row'][$inc]['end_tr'] = false;
				if ($count%$blogPerRow==0)
			    {
					$count = 0;
					$populateBlogRecentBlock_arr['row'][$inc]['end_tr'] = true;
		    	}
			    $inc++;

			}
			$populateBlogRecentBlock_arr['extra_td_tr'] = '';
			if ($found and $count and $count<$blogPerRow)
		    {
		    	$colspan = $blogPerRow-$count;
				$populateBlogRecentBlock_arr['extra_td_tr'] = '<td colspan="'.$colspan.'">&nbsp;</td></tr>';
		    }
		    $populateBlogRecentBlock_arr['blog_url'] = getUrl('index','','','','blog');
			return $populateBlogRecentBlock_arr;

		}
		public function chkBlogsAdded()
		{

			global $smartyObj;
			$sql = 'SELECT blog_name FROM '.$this->CFG['db']['tbl']['blogs'].' '.
				'WHERE blog_status=\'Active\' AND user_id = '.$this->dbObj->Param('user_id');
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			if($row = $rs->FetchRow())
			{
			   return getUrl('viewblog','?blog_name='.$row['blog_name'],$row['blog_name'].'/','','blog');
			}
			else
			{
              return '';
			}
		}
		/**
		* BlogHandler::indexPageTotalPostsInSite()
		* To get blog post total count
		* @param
		* @return
		*/
		public function indexPageTotalPostsInSite()
		{

			global $CFG;
			global $db;
			$sql =	'SELECT SUM(total_posts) AS total_posts'.
					' FROM '.$CFG['db']['tbl']['users'].' WHERE usr_status='
					.$this->dbObj->Param('usr_status');

			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt, array('OK'));
			if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
			$db->ErrorMsg(), E_USER_ERROR);
			if ($rs->PO_RecordCount())
			{
				if($row = $rs->FetchRow())
				{
					if($row['total_posts'])
					{
						$all_post_url = getUrl('blogpostlist','?pg=postnew','postnew/','','blog');
						return '<a href="'.$all_post_url.'">'.$row['total_posts'].'</a>';
					}
				}
			}
			return 0;
		}
		/**
		* BlogHandler::indexPageTotalBlogsInSite()
		* To get blog count
		* @param
		* @return
		*/
		public function indexPageTotalBlogsInSite()
		{

			global $CFG;
			global $db;
			$sql = 'SELECT COUNT(blog_id) AS total_blog_count FROM '
					.$this->CFG['db']['tbl']['blogs'].' WHERE blog_status= '
					.$this->dbObj->Param('blog_status');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt,array('Active'));
			if (!$rs)
			trigger_db_error($this->dbObj);

			if ($rs->PO_RecordCount())
			{
				if($row = $rs->FetchRow())
				{
					if($row['total_blog_count'])
					{
						$all_blog_url = getUrl('bloglist', '', '', '', 'blog');
						return '<a href="'.$all_blog_url.'">'.number_format($row['total_blog_count']).'</a>';
					}
				}
			}
			return 0;
		}
		public function populateMyBlogDashBoardDetail($side_bar_option)
		{
			global $smartyObj;
			if($side_bar_option == 'blog')
				$allowed_pages_array = array('viewBlog.php');

			if(displayBlock($allowed_pages_array))
				return;

			$this->_currentPage = strtolower($this->CFG['html']['current_script_name']);
			$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsActiveLink;
			$pg = (isset($_REQUEST['pg']))?$_REQUEST['pg']:'';
			$block = (isset($_REQUEST['block']))?$_REQUEST['block']:'';
			if($block != '')
				{
					$page = $this->_currentPage.'_'.strtolower($block);
					$this->_navigationArr['left_'.$page] = $this->_clsActiveLink;
				}
			$flag = false;
			if($pg != '')
			{
				$flag = true;
				$this->_navigationArr['left_'.$this->_currentPage] = $this->_clsInActiveLink;
				$page = $this->_currentPage.'_'.strtolower($pg);
				$this->_navigationArr['left_'.$page] = $this->_clsActiveLink;
			}

			$populateMyBlogDetail_arr = array();

			//CHECK BLOG ADDED//
			$sql = 'SELECT blog_name FROM '.$this->CFG['db']['tbl']['blogs'].' '.
				'WHERE blog_status=\'Active\' AND user_id = '.$this->dbObj->Param('user_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$populateMyBlogDetail_arr['my_blog_url'] ='';
			$result_set = $rs->FetchRow();
			$populateMyBlogDetail_arr['check_blog_added'] = ($result_set['blog_name'])?$result_set['blog_name']:'';
			if($result_set['blog_name'])
			$populateMyBlogDetail_arr['my_blog_url'] = getUrl('viewblog','?blog_name='.$result_set['blog_name'],$result_set['blog_name'].'/','','blog');
			$smartyObj->assign('populateMyBlogDetail_arr', $populateMyBlogDetail_arr);
			$smartyObj->assign('opt', $side_bar_option);
			$smartyObj->assign('flag', $flag);
			setTemplateFolder('general/', 'blog');
			$smartyObj->display('populateMyBlogDashBoardBlock.tpl');
		}

}
?>