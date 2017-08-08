<?php
/**
 * File to allow the users to view blog post
 *
 * Provides an interface to view post and
 * post comments, Flag content, Email to Friends, Add to favourites,
 * rate the post and add to bookmarking sites.
 *
 *
 * @category	Rayzz
 * @package		General
 */

/**
 * ViewPost
 *
 * @category	Rayzz
 * @package		General
 */
class ViewPost extends BlogHandler
{
	public $enabled_edit_fields = array();
	public $captchaText = '';
	public $publickey;
	public $privatekey;
	public $error = null;
	public $resp = null;
	public $blog_response_links = '';
	/**
	 * ViewPost::chkValidPostId()
	 *
	 * @return
	 */
	public function chkValidPostId()
		{
			$blog_post_id = $this->fields_arr['blog_post_id'];
			$blog_post_id = is_numeric($blog_post_id)?$blog_post_id:0;
			if (!$blog_post_id)
			    {
			        return false;
			    }
			$userId = $this->CFG['user']['user_id'];

			$blog_logo_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['blog']['folder'].'/'.$this->CFG['admin']['blog']['blog_logo_folder'].'/';

			$condition = ' b.blog_status=\'Active\' AND bp.status!=\'Deleted\' AND bp.blog_post_id='.$this->dbObj->Param($blog_post_id).
						' AND (bp.user_id = '.$this->dbObj->Param($userId).' OR'.
						' bp.blog_access_type = \'Public\''.$this->getAdditionalQuery('bp.').')';

		   $sql = 'SELECT b.blog_id,b.blog_name,b.blog_logo_ext,b.blog_title,b.blog_slogan, bp.total_favorites, bp.total_views, bp.total_comments,'.
					' bp.allow_comments,bp.blog_category_id,bc.blog_category_name,bp.blog_tags,bp.status,'.
					' bp.allow_ratings, bp.rating_total, bp.rating_count, bp.user_id, bp.flagged_status, bp.message,'.
					' (bp.rating_total/bp.rating_count) as rating, bc.blog_category_type, '.
					' bp.blog_post_name, DATE_FORMAT(bp.date_added,\''.$this->CFG['format']['date'].'\') as date_added'.
					' FROM '.$this->CFG['db']['tbl']['blogs'].' AS b JOIN '.$this->CFG['db']['tbl']['blog_posts'].' AS bp ON b.blog_id = bp.blog_id  JOIN '.
					$this->CFG['db']['tbl']['blog_category'].' AS bc ON bc.blog_category_id =bp.blog_category_id'.' WHERE '.$condition.' LIMIT 0,1';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($blog_post_id, $userId));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

			$fields_list = array('user_name', 'first_name', 'last_name');
			if($row = $rs->FetchRow())
				{
					$this->fields_arr['blog_logo_src']=$this->CFG['site']['blog_url'].'design/templates/'.$this->CFG['html']['template']['default'].
				 									'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/default-logo.jpg';
					if($row['blog_logo_ext'])
				      $this->fields_arr['blog_logo_src'] = $this->CFG['site']['url'].$blog_logo_folder.$row['blog_id'].'.'.$row['blog_logo_ext'];

					$this->fields_arr['blog_name'] = $row['blog_name'];
					$this->fields_arr['blog_title'] = $row['blog_title'];
					$this->fields_arr['blog_slogan'] = $row['blog_slogan'];
					$this->fields_arr['blog_url']=getUrl('viewblog','?blog_name='.$row['blog_name'],$row['blog_name'].'/','root','blog');
					$this->fields_arr['blog_rss_url']=getUrl('rssblog','?blog_name='.$row['blog_name'],$row['blog_name'].'/','root','blog');
					$this->fields_arr['blog_id'] = $row['blog_id'];
					$this->fields_arr['user_id'] = $row['user_id'];
					$this->fields_arr['allow_comments'] = $row['allow_comments'];
					$this->fields_arr['allow_ratings'] = $row['allow_ratings'];
					$this->fields_arr['blog_post_name'] = $row['blog_post_name'];
					$this->fields_arr['message'] = strip_selected_blog_tags(stripslashes($row['message']));
					$this->fields_arr['date_added'] = $row['date_added'];
					$this->fields_arr['rating_total'] = $row['rating_total'];
					$this->fields_arr['status'] = $row['status'];
					$this->fields_arr['rating_count'] = $row['rating_count'];
					$this->post_rating = round($row['rating']);
					$this->fields_arr['flagged_status'] = $row['flagged_status'];
					$this->fields_arr['comments'] = $row['total_comments']?$row['total_comments']:0;
					$this->category = $row['blog_category_name'];
					$this->date_added = $row['date_added'];
					$this->category_link= getUrl('blogpostlist', '?pg=postnew&amp;cid='.$row['blog_category_id'], 'postnew/?cid='.$row['blog_category_id'], '', 'blog');
					$this->fields_arr['favorited'] = $row['total_favorites'];
					$this->fields_arr['total_views'] = $row['total_views'];
					$this->fields_arr['blog_category_type'] = $row['blog_category_type'];
					$this->fields_arr['total_comments'] = $row['total_comments'];
					$this->fields_arr['blog_category_id'] = $row['blog_category_id'];
					$this->fields_arr['blog_tags'] = $row['blog_tags'];

					$this->validBlogId = true;
					return true;
				}
			return false;
		}

		/**
		 * ViewPost::changeLastViewDateAndPostViewed()
		 *
		 * @return
		 */
		public function changeLastViewDateAndPostViewed()
		{

			$sql = 	' SELECT blog_viewed_id,blog_id FROM '.$this->CFG['db']['tbl']['blog_viewed'].
					' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').' AND user_id='.$this->dbObj->Param('user_id').' AND'.
					' DATE_FORMAT(view_date, \'%Y-%m-%d\') = CURDATE()';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id'], $this->CFG['user']['user_id']));

		    if (!$rs)
			    trigger_db_error($this->dbObj);
			if($rs->PO_RecordCount())
				{
					$row = $rs->FetchRow();//$rs->Free();
					$blog_viewed_id = $row['blog_viewed_id'];
					$blog_id = $row['blog_id'];
					$sql =  ' UPDATE '.$this->CFG['db']['tbl']['blog_viewed'].' SET'.
 							' view_date=NOW() ,'.
 							' total_views=total_views+1 ,'.
 							' blog_id= '.$this->dbObj->Param('blog_id').
							' WHERE blog_viewed_id='.$this->dbObj->Param('blog_viewed_id');

 					$stmt = $this->dbObj->Prepare($sql);
 					$rs = $this->dbObj->Execute($stmt, array($blog_id,$blog_viewed_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				}
			else
				{
					$sql =  ' INSERT INTO '.$this->CFG['db']['tbl']['blog_viewed'].' '.
 							' (user_id, blog_post_id, total_views, view_date,blog_id)'.
 							' VALUES('.$this->dbObj->Param('user_id').','.
							$this->dbObj->Param('blog_post_id').', 1, '.
 							' NOW(),'.$this->dbObj->Param('blog_id').')';

 					$stmt = $this->dbObj->Prepare($sql);
 					$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['blog_post_id'],$this->fields_arr['blog_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				}

			$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET'.
					' total_views=total_views+1, last_view_date=NOW()'.
					' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

		}
		/**
		 * ViewPost::replaceAdultText()
		 *
		 * @param mixed $text
		 * @return
		 */
		public function replaceAdultText($text)
		{
			$text = str_replace('{age_limit}', $this->CFG['admin']['blog']['adult_minimum_age'], $text);
			$text = str_replace('{site_name}', $this->CFG['site']['name'], $text);
			return nl2br($text);
		}
		/**
		 * ViewPost::displayPost()
		 *
		 * @return
		 */
		public function displayPost()
		{
			global $smartyObj;
			$displayPost_arr = array();

			$this->rankUsersRayzz = false;
			$this->rating='';

			$fields_list = array('user_name', 'first_name', 'last_name');
				if(!isset($this->UserDetails[$this->getFormField('user_id')]))
					$this->getUserDetail('user_id',$this->fields_arr['user_id'], 'user_name');

			if(rankUsersRayzz($this->CFG['admin']['blog']['allow_self_ratings'], $this->fields_arr['user_id']))
			{
				$this->rankUsersRayzz=true;
				$this->rating = $this->getRating($this->CFG['user']['user_id']);
			}

			$this->ratingDetatils = ($rating=$this->populateRatingDetails($this->fields_arr['rating_count']))?$rating:0;

			$displayPost_arr['message'] =$this->fields_arr['message'];

			if(isMember())
			{
				$this->memberviewPostUrl = getUrl('viewpost',
															 '?blog_post_id='.$this->getFormfield('blog_post_id').'&title='.$this->changeTitle($this->getFormfield('blog_post_name')),
															 $this->getFormfield('blog_post_id').'/'.$this->changeTitle($this->getFormfield('blog_post_name')).
															'/','members', 'blog');
			}
			else
			{

				$this->memberviewPostUrl = getUrl('viewpost','?mem_auth=true&blog_post_id='.$this->getFormfield('blog_post_id').'&title='.$this->changeTitle($this->getFormfield('blog_post_name')),
															 $this->getFormfield('blog_post_id').'/'.$this->changeTitle($this->getFormfield('blog_post_name')).
															'/?mem_auth=true&','members', 'blog');
			}

			$displayPost_arr['getTagsOfThisPost_arr'] = $this->getTagsOfThisPost();

			if($this->fields_arr['allow_ratings'] == 'Yes')
				{
					if(!isMember())
						{
							$displayPost_arr['view_post_url'] = getUrl('viewpost', '?blog_post_id='.$this->fields_arr['blog_post_id'].'&amp;title='.$this->changeTitle($this->fields_arr['blog_post_name']), $this->fields_arr['blog_post_id'].'/'.$this->changeTitle($this->fields_arr['blog_post_name']).'/', 'members', 'blog');
						}
					else
						{
							$displayPost_arr['rankUsersRayzz'] = rankUsersRayzz($this->CFG['admin']['blog']['allow_self_ratings'], $this->fields_arr['user_id']);
							if($displayPost_arr['rankUsersRayzz'])
								{
									$displayPost_arr['rating'] = $this->getRating($this->CFG['user']['user_id']);
								}
						}
				}
			$username=$this->getUserDetail('user_id',$this->fields_arr['user_id'], 'user_name');
			$this->memberProfileUrl = getMemberProfileUrl($this->getFormField('user_id'), $username);
			$this->profileUserName  = $this->getUserDetail('user_id',$this->getFormField('user_id'), 'user_name');
			$displayPost_arr['getCategoryOfThisPost_arr'] = $this->getCategoryOfThisPost();

			if(!isMember())
				{
					$displayPost_arr['flag_post_url'] = getUrl('viewpost', '?blog_post_id='.$this->fields_arr['blog_post_id'].'&amp;title='.$this->changeTitle($this->fields_arr['blog_post_name']), $this->fields_arr['blog_post_id'].'/'.$this->changeTitle($this->fields_arr['blog_post_name']).'/', 'members', 'blog');
				}

			$displayPost_arr['getFavoriteLink_arr'] = $this->getFavoriteLink();


      		if(isMember())
			{
				$this->share_url = $this->CFG['site']['blog_url'].'sharePost.php?blog_post_id='.
												$this->getFormField('blog_post_id').'&ajaxpage=true&page=sharepost';
			}
			else
			{
				$this->share_url = $this->CFG['site']['blog_url'].'sharePost.php?blog_post_id='.
												$this->getFormField('blog_post_id').'&ajaxpage=true&page=sharepost';
			}

			$this->favorite = $this->getFavorite();
	        $this->featured = $this->getFeatured();

	        $this->flaggedPostUrl = getUrl('viewpost','?blog_post_id='.$this->getFormfield('blog_post_id').'&title='.
											$this->changeTitle($this->getFormfield('blog_post_name')).
												'&flagged_content=show', $this->getFormfield('blog_post_id').'/'.
													$this->changeTitle($this->getFormfield('blog_post_name')).
														'/?flagged_content=show','members', 'blog');

			$this->load_flag_url = $this->CFG['site']['blog_url'].'viewPost.php?blog_post_id='.
								$this->fields_arr['blog_post_id'].'&ajax_page=true&page=load_flag';


			$displayPost_arr['blog_post_url'] = getUrl('viewpost', '?blog_post_id='.$this->fields_arr['blog_post_id'].'&amp;title='.$this->changeTitle($this->fields_arr['blog_post_name']), $this->fields_arr['blog_post_id'].'/'.$this->changeTitle($this->fields_arr['blog_post_name']).'/', '', 'blog');

			$displayPost_arr['blog_post_posting_url_ok'] = '';
			if($this->fields_arr['user_id'] == $this->CFG['user']['user_id'])
				{
					$displayPost_arr['blog_post_posting_url_ok'] = getUrl('manageblogpost', '?blog_post_id='.$this->fields_arr['blog_post_id'], $this->fields_arr['blog_post_id'].'/', '', 'blog');
				}

			$smartyObj->assign('displayPost_arr', $displayPost_arr);
		}
		/**
		 * ViewPost::getTagsOfThisPost()
		 *
		 * @return
		 */
		public function getTagsOfThisPost()
		{
			$getTagsOfThisPost_arr = array();
			$tags_arr = explode(' ',$this->fields_arr['blog_tags']);
			$inc = 0;
			$music_tag_count=count($tags_arr);
			foreach($tags_arr as $tags)
				{
					$getTagsOfThisPost_arr[$inc]['url'] = getUrl('blogpostlist', '?pg=postnew&amp;tags='.$tags, 'postnew/?tags='.$tags, '', 'blog');
					$getTagsOfThisPost_arr[$inc]['tags'] = $tags;
					$getTagsOfThisPost_arr[$inc]['music_total_tag_count'] = $music_tag_count;
					$inc++;
				}

			return $getTagsOfThisPost_arr;
		}
		/**
		 * ViewPost::getCategoryOfThisPost()
		 *
		 * @return
		 */
		public function getCategoryOfThisPost()
		{
			$getChannelOfThisArticle_arr = array();
			$sql = 'SELECT blog_category_name FROM '.$this->CFG['db']['tbl']['blog_category'].
					' WHERE blog_category_id='.$this->dbObj->Param('blog_category_id').
					' AND blog_category_status=\'Yes\' LIMIT 0,1';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_category_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

			if($row = $rs->FetchRow())
				{
					$getChannelOfThisArticle_arr['category_url'] = getUrl('blogpostlist', '?pg=postnew&amp;cid='.$this->fields_arr['blog_category_id'], 'postnew/?cid='.$this->fields_arr['blog_category_id'], '', 'blog');
					$getChannelOfThisArticle_arr['blog_category_name'] = $row['blog_category_name'];
				}
			return $getChannelOfThisArticle_arr;
		}
		/**
		 * ViewPost::getFavoriteLink()
		 *
		 * @return
		 */
		public function getFavoriteLink()
		{
			$getFavoriteLink_arr = array();
			if(!isMember())
				{
					$getFavoriteLink_arr['view_blog_post_url'] = getUrl('viewpost', '?blog_post_id='.$this->fields_arr['blog_post_id'].'&amp;title='.$this->changeTitle($this->fields_arr['blog_post_name']), $this->fields_arr['blog_post_id'].'/'.$this->changeTitle($this->fields_arr['blog_post_name']).'/', 'members', 'blog');
				}
			$sql = 'SELECT count(1) as count FROM '.$this->CFG['db']['tbl']['blog_favorite'].
					' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').
					' AND user_id='.$this->dbObj->Param('user_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id'], $this->CFG['user']['user_id']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

			$row = $rs->FetchRow();
			$getFavoriteLink_arr['row'] = $row;
			return $getFavoriteLink_arr;
		}
		/**
		 * ViewPost::getRating()
		 *
		 * @param mixed $user_id
		 * @return
		 */
		public function getRating($user_id)
		{
			$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['blog_rating'].
					' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
					' blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($user_id, $this->fields_arr['blog_post_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

			if($row = $rs->FetchRow())
				{
					return $row['rate'];
				}
			return 0;
		}
		/**
		 * ViewPost::populateRatingDetails()
		 *
		 * @param mixed $rating
		 * @return
		 */
		public function populateRatingDetails($rating)
		{
			$rating = round($rating,0);
			return $rating;
		}
		/**
		 * ViewPost::populateRatingImagesForAjax()
		 *
		 * @param mixed $rating
		 * @return
		 */
		public function populateRatingImagesForAjax($rating, $imagePrefix='')
		{
			$rating_total = $this->CFG['admin']['total_rating'];

			for($i=1;$i<=$rating;$i++)
			{
				?>
				<a <?php if($this->fields_arr['status']=='Ok')
				    {
				    ?>onClick="return callAjaxRate('<?php echo $this->CFG['site']['blog_url'].'viewPost.php?ajax_page=true&blog_post_id='.
					$this->fields_arr['blog_post_id'].'&'.'rate='.$i;?>&show=<?php echo $this->fields_arr['show'];?>','selRatingBlog','postRating')"
					 <?php }?>
					onMouseOver="ratingPostMouseOver(<?php echo $i;?>, 'blog')" onMouseOut="ratingPostMouseOut(<?php echo $i;?>)">
					<img id="img<?php echo $i;?>" src="<?php echo $this->CFG['site']['blog_url'].'design/templates/'.
					$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
					'/icon-blogratehover.gif'; ?>"  title="<?php echo $i;?>" /></a>
				<?php
			}
		    ?>
		    <?php
			for($i=$rating;$i<$rating_total;$i++)
			{
				?>
				<a <?php if($this->fields_arr['status']=='Ok')
				    {
				    ?>onClick="return callAjaxRate('<?php echo $this->CFG['site']['blog_url'].'viewPost.php?ajax_page=true&blog_post_id='.
				$this->fields_arr['blog_post_id'].'&'.'rate='.($i+1);?>&amp;amp;show=<?php echo $this->fields_arr['show'];?>','selRatingBlog','postRating')"
				<?php }?>
				 onMouseOver="ratingPostMouseOver(<?php echo ($i+1);?>, 'blog')" onMouseOut="ratingPostMouseOut(<?php echo ($i+1);?>)">
				 <img id="img<?php echo ($i+1);?>" src="<?php echo $this->CFG['site']['blog_url'].'design/templates/'.
				 $this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
				 '/icon-blograte.gif'; ?>"  title="<?php echo ($i+1);?>" /></a>
				 <?php
			}

		}
		/**
		 * ViewPost::populateCommentOfThisPost()
		 *
		 * @return
		 */
		public function populateCommentOfThisPost()
			{
				global $smartyObj;
				//Array to store video comments
				$populateCommentOfThisPost_arr = array();
//				$this->CFG['admin']['blog']['total_comments']=$this->fields_arr['show']=='all'?'100000':$this->CFG['admin']['blog']['total_comments'];

                $this->setTableNames(array($this->CFG['db']['tbl']['blog_comments'].' AS vc', $this->CFG['db']['tbl']['users'].' AS u'));
                $this->setReturnColumns(array('vc.blog_comment_id', 'vc.comment_user_id', 'vc.comment', 'TIMEDIFF(NOW(), vc.date_added) as pc_date_added', 'TIME_TO_SEC(TIMEDIFF(NOW(), vc.date_added)) AS date_edit'));
                $this->sql_condition = 'vc.blog_post_id=\''.$this->fields_arr['blog_post_id'].'\' AND vc.blog_comment_main_id=0 AND u.user_id=vc.comment_user_id AND u.usr_status=\'Ok\' AND vc.comment_status=\'Yes\'';
                $this->sql_sort = 'vc.blog_comment_id DESC';


			    /**
			     * ***** navigtion continue********
			     */
			    $this->buildSelectQuery();
			    $this->buildQuery();
			    $this->executeQuery();
			    //$this->printQuery();
			    /**
			     * ****** Navigation End *******
			     */
			    $paging_arr = array();
			    $smartyObj->assign('paging_arr', $paging_arr);

				$populateCommentOfThisPost_arr['comment_approval'] = 0;


				if($this->getFormField('allow_comments')=='Kinda')
					{
						$populateCommentOfThisPost_arr['comment_approval'] = 0;
						if(!isMember())
							{
								$populateCommentOfThisPost_arr['approval_url'] = getUrl('viewpost', '?blog_post_id='.$this->fields_arr['blog_post_id'].'&amp;title='.$this->changeTitle($this->fields_arr['blog_post_name']), $this->fields_arr['blog_post_name'].'/'.$this->changeTitle($this->fields_arr['blog_post_name']).'/', 'members', 'blog');
							}
					}
				else if($this->getFormField('allow_comments')=='Yes')
					{
						$populateCommentOfThisPost_arr['comment_approval'] = 1;
						if(!isMember())
							{
								$populateCommentOfThisPost_arr['post_comment_url'] = getUrl('viewpost', '?blog_post_id='.$this->fields_arr['blog_post_id'].'&amp;title='.$this->changeTitle($this->fields_arr['blog_post_name']), $this->fields_arr['blog_post_id'].'/'.$this->changeTitle($this->fields_arr['blog_post_name']).'/', 'members', 'blog');
							}
					}

				$populateCommentOfThisPost_arr['row'] = array();
			    if ($this->isResultsFound())
					{
						$this->fields_arr['ajaxpaging'] = 1;
						$populateCommentOfThisPost_arr['hidden_arr'] = array('start', 'ajaxpaging');
						$smartyObj->assign('smarty_paging_list', $this->populatePageLinksPOSTViaAjax($this->getFormField('start'), 'frmVideoComments', 'selCommentBlock'));
						$this->fields_arr['total_comments'] = (isset($this->fields_arr['total_comments']) and $this->fields_arr['total_comments'])?$this->fields_arr['total_comments']:$this->getTotalComments();

						$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type', 'sex');
						$this->UserDetails = array();
						$inc = 0;

						while($row = $this->fetchResultRecord())
							{
								if(!isset($this->UserDetails[$row['comment_user_id']]))
									$this->getUserDetail('user_id', $row['comment_user_id'], 'user_name');
								$user_name= $this->getUserDetail('user_id',$row['comment_user_id'], 'user_name');
								$populateCommentOfThisPost_arr['row'][$inc]['name'] = $this->getUserDetail('user_id',$row['comment_user_id'], 'user_name');
								$populateCommentOfThisPost_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['comment_user_id']);
								$populateCommentOfThisPost_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $user_name);
								$row['pc_date_added'] = getTimeDiffernceFormat($row['pc_date_added']);
								$populateCommentOfThisPost_arr['row'][$inc]['class'] = 'clsNotEditable';

								if($row['comment_user_id']==$this->CFG['user']['user_id'])
									{
										$time = $this->CFG['admin']['blog']['comment_edit_allowed_time']-$row['date_edit'];
										if($time>2)
											{
												$populateCommentOfThisPost_arr['row'][$inc]['class'] = "clsEditable";
											}
									}

								$row['comment'] = $row['comment'];
								$populateCommentOfThisPost_arr['row'][$inc]['record'] = $row;
					$populateCommentOfThisPost_arr['row'][$inc]['reply_url']= $this->CFG['site']['blog_url'].'viewPost.php?blog_post_id='.$this->getFormField('blog_post_id').'&vpkey='.$this->getFormField('vpkey').'&show='.$this->getFormField('show').'&comment_id='.$row['blog_comment_id'].'&type=comment_reply';
								$populateCommentOfThisPost_arr['row'][$inc]['delete_comment_url']= "delete URL";
							//	$populateCommentOfThisPost_arr['row'][$inc]['delete_comment_url'] = getUrl('viewPost', '?blog_post_id='.$this->fields_arr['blog_post_id'].'&title='.$this->changeTitle($this->fields_arr['blog_title']).'&comment_id='.$row['blog_comment_id'].'&ajax_page=true&page=deletecomment', $this->fields_arr['blog_post_id'].'/'.$this->changeTitle($this->fields_arr['blog_post_name']).'/?comment_id='.$row['blog_comment_id'].'&ajax_page=true&page=deletecomment', '', 'blog');
								$populateCommentOfThisPost_arr['row'][$inc]['comment_member_profile_url'] = getMemberProfileUrl($row['comment_user_id'], $user_name);

								$populateCommentOfThisPost_arr['row'][$inc]['makeClickableLinks'] = nl2br(makeClickableLinks($row['comment']));



								if(isMember() and $row['comment_user_id']==$this->CFG['user']['user_id'])
									{
									  $populateCommentOfThisPost_arr['row'][$inc]['time'] = $this->CFG['admin']['blog']['comment_edit_allowed_time']-$row['date_edit'];
										if($populateCommentOfThisPost_arr['row'][$inc]['time'] > 2)
											{
												$this->enabled_edit_fields[$row['blog_comment_id']] = $populateCommentOfThisPost_arr['row'][$inc]['time'];
											}
									}
								else
									{
										if(!isMember())
											{
												$populateCommentOfThisPost_arr['row'][$inc]['comment_reply_url'] = getUrl('viewpost', '?blog_post_id='.$this->fields_arr['blog_post_id'].'&amp;title='.$this->changeTitle($this->fields_arr['blog_post_name']), $this->fields_arr['blog_post_id'].'/'.$this->changeTitle($this->fields_arr['blog_post_name']).'/', 'members', 'blog');
											}
									}

								$populateCommentOfThisPost_arr['row'][$inc]['populateReply_arr'] = $this->populateReply($row['blog_comment_id']);
								$inc++;
							} //while

						if($this->fields_arr['total_comments']>$this->CFG['admin']['blog']['total_comments'])
							{
						  		$populateCommentOfThisPost_arr['view_all_comments_url'] = getUrl('viewpost', '?blog_post_id='.$this->fields_arr['blog_post_id'].'&amp;title='.$this->changeTitle($this->fields_arr['blog_post_name']).'&amp;vpkey='.$this->fields_arr['vpkey'].'&amp;show=all', $this->fields_arr['blog_post_id'].'/'.$this->changeTitle($this->fields_arr['blog_post_name']).'/?vpkey='.$this->fields_arr['vpkey'].'&amp;show=all', '', 'blog');
								$populateCommentOfThisPost_arr['view_all_comments'] = sprintf($this->LANG['viewpost_view_all_comments'],'<span id="total_comments2">'.$this->fields_arr['total_comments'].'</span>');
						  	}
				    }


				$smartyObj->assign('populateCommentOfThisPost_arr', $populateCommentOfThisPost_arr);
				setTemplateFolder('general/', 'blog');
				$smartyObj->display('populateCommentOfThisPost.tpl');
			}




		/**
		 * ViewPost::getTotalComments()
		 *
		 * @return
		 */
		public function getTotalComments()
		{
			$sql = 'SELECT total_comments FROM '.$this->CFG['db']['tbl']['blog_posts'].
					' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

			$row = $rs->FetchRow();
			return $this->fields_arr['total_comments'] = $row['total_comments']?$row['total_comments']:0;
		}
		/**
		 * ViewPost::chkIsCaptchaNotEmpty()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkIsCaptchaNotEmpty($field_name, $err_tip='')
		{
			$is_ok = (is_string($this->fields_arr[$field_name])) ?
							($this->fields_arr[$field_name]!='') : (!empty($this->fields_arr[$field_name]));
			if (!$is_ok)
				{
					echo 'ERR~'.$err_tip;
					exit;
				}
			return $is_ok;
		}
		/**
		 * ViewPost::chkCaptcha()
		 *
		 * @param mixed $field_name
		 * @param string $err_tip
		 * @return
		 */
		public function chkCaptcha($field_name, $err_tip='')
		{
			if ($this->fields_arr["recaptcha_response_field"])
			{
	    		$resp = recaptcha_check_answer ($this->CFG['captcha']['private_key'],
			 					$_SERVER["REMOTE_ADDR"],
			 					$this->fields_arr["recaptcha_challenge_field"],
								$this->fields_arr["recaptcha_response_field"]);

	        	if ($resp->is_valid)
			 	{
	    			return true;
	            }
				else
				{
				    echo 'ERR~'.$err_tip;
					exit;
				}
			}

		}
		/**
		 * ViewPost::populateCommentOptionsPost()
		 *
		 * @return
		 */
		public function populateCommentOptionsPost()
		{
			$this->CFG['admin']['blog']['total_comments']=$this->fields_arr['show']=='all'?'100000':$this->CFG['admin']['blog']['total_comments'];
			$sql = 'SELECT bc.blog_comment_id, bc.comment_user_id,'.
					' bc.comment, TIMEDIFF(NOW(), bc.date_added) as pc_date_added,'.
					' TIME_TO_SEC(TIMEDIFF(NOW(), bc.date_added)) AS date_edit'.
					' FROM '.$this->CFG['db']['tbl']['blog_comments'].' AS bc'.
					' WHERE bc.blog_post_id='.$this->dbObj->Param('blog_post_id').' AND'.
					' bc.blog_comment_main_id=0 AND'.
					' bc.comment_status=\'Yes\' ORDER BY bc.blog_comment_id DESC LIMIT '.$this->CFG['admin']['blog']['total_comments'];

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

			$total_comments = $rs->PO_RecordCount();
			$this->fields_arr['total_comments'] = $this->getTotalComments();
			$this->comment_approval = 0;
			if(isMember())
			{
				$this->commentUrl = $this->CFG['site']['blog_url'].'viewPost.php?type=add_comment&blog_post_id='.$this->getFormField('blog_post_id');
			}
			else
			{
				$this->commentUrl =getUrl('viewpost', '?mem_auth=true&blog_post_id='.$this->fields_arr['blog_post_id'].'&title='.$this->changeTitle($this->fields_arr['blog_post_name']), $this->fields_arr['blog_post_id'].'/'.$this->changeTitle($this->fields_arr['blog_post_name']).'/?mem_auth=true', '', 'blog');
			}
			if($this->getFormField('allow_comments')=='Kinda')
			{
				$this->comment_approval = 0;
				if($this->fields_arr['user_id'] == $this->CFG['user']['user_id'])
					$this->comment_approval = 1;
			}
			else if($this->getFormField('allow_comments')=='Yes')
			{
				$this->comment_approval = 1;
			}
			else if($this->getFormField('allow_comments')=='No')
			{
				$this->setPageBlockHide('blog_comments_block');
			}
		}
		/**
		 * ViewPost::insertCommentAndBlogPostTable()
		 *
		 * @return
		 */
		public function insertCommentAndBlogPostTable()
			{


				$sql = 'SELECT allow_comments FROM '.$this->CFG['db']['tbl']['blog_posts'].
					' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
				    if (!$rs)
					   trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$this->fields_arr['allow_comments'] = $row['allow_comments'];
				$comment_status = 'Yes';

				if($row['allow_comments']=='Kinda')
					$comment_status = 'No';

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_comments'].' SET'.
					' blog_post_id='.$this->dbObj->Param('blog_post_id').','.
					' blog_id='.$this->dbObj->Param('blog_id').','.
					' blog_comment_main_id='.$this->dbObj->Param('blog_comment_main_id').','.
					' comment_user_id='.$this->dbObj->Param('comment_user_id').','.
					' comment='.$this->dbObj->Param('comment').','.
					' comment_status='.$this->dbObj->Param('comment_status').','.
					' date_added=NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id'],$this->fields_arr['blog_id'], $this->fields_arr['comment_id'], $this->CFG['user']['user_id'], $this->fields_arr['f'], $comment_status));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$next_id = $this->dbObj->Insert_ID();
				if($next_id and $comment_status=='Yes' and (!$this->fields_arr['comment_id']))
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET total_comments = total_comments+1'.
							' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
						    if (!$rs)
							    trigger_db_error($this->dbObj);
					}

/*
				//SEND MAIL TO VIDEO OWNER
				if($this->CFG['user']['user_id'] != $this->fields_arr['user_id'])
					$this->sendMailToUserForVideoComment();
*/

			//Srart Post blog comment activity..
			$sql = 'SELECT bc.blog_comment_id, bc.blog_post_id, bc.comment_user_id, u.user_name, '.
					'bp.blog_post_name, bp.user_id '.
					'FROM '.$this->CFG['db']['tbl']['blog_comments'].' as bc, '.
					$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['blog_posts'].' as bp '.
					' WHERE u.user_id = bc.comment_user_id AND '.
					'bc.blog_post_id = bp.blog_post_id AND bc.blog_comment_id = '.$this->dbObj->Param('next_id');

		//		echo "<br>", $sql;

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($next_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$row = $rs->FetchRow();
			$activity_arr = $row;
			$activity_arr['action_key']	= 'blog_post_comment';
			$blogActivityObj = new BlogActivityHandler();
			$blogActivityObj->addActivity($activity_arr);

				//end
				global $smartyObj;
				if ($this->fields_arr['comment_id'] && $this->fields_arr['comment_id']!='0')
					{
						$cmValue['populateReply_arr'] = $this->populateReply($this->fields_arr['comment_id']);
						$smartyObj->assign('cmValue', $cmValue);
						setTemplateFolder('general/', 'blog');
						$smartyObj->display('populateReplyForCommentsOfThisPost.tpl');
					}
				else
					{
						$this->populateCommentOfThisPost();
					}
			}


		public function populateReplyCommentOfThisPost()
			{
				global $smartyObj;


				$cmValue['populateReply_arr'] = $this->populateReply($this->fields_arr['maincomment_id']);
				$smartyObj->assign('cmValue', $cmValue);
				setTemplateFolder('general/', 'blog');
				$smartyObj->display('populateReplyForCommentsOfThisPost.tpl');
			}

		/**
		 * ViewPost::updateCommentAndBlogPostTable()
		 *
		 * @return
		 */
		public function updateCommentAndBlogPostTable()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_comments'].' SET'.
						' comment='.$this->dbObj->Param('comment').
						' WHERE blog_comment_id='.$this->dbObj->Param('blog_comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['f'], $this->fields_arr['comment_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
			//	return true;
				$this->setPageBlockShow('update_comment');
			}
		/**
		 * ViewPost::deleteComment()
		 *
		 * @return
		 */

		public function deleteComment()
			{
				$sql = 'SELECT blog_post_id,blog_comment_main_id FROM '.$this->CFG['db']['tbl']['blog_comments'].' WHERE'.
					' blog_comment_id='.$this->dbObj->Param('blog_comment_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['blog_comments'].
						' WHERE blog_comment_id='.$this->dbObj->Param('blog_comment_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				    if (!$rs)
					   trigger_db_error($this->dbObj);

				if($row['blog_comment_main_id']==0)
				{
					if($this->dbObj->Affected_Rows())
						{
							$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET total_comments = total_comments-1'.
									' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id');

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($row['blog_post_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
						}
				}

				echo '<div id="selMsgSuccess">'.$this->LANG['success_deleted'].'</div>';
			}


		/**
		 * ViewPost::populateReply()
		 *
		 * @param mixed $comment_id
		 * @return
		 */
			public function populateReply($comment_id)
			{
				$populateReply_arr = array();
				$sql = 'SELECT blog_comment_id, comment_user_id, blog_comment_main_id ,'.
					' comment, TIMEDIFF(NOW(), date_added) as bc_date_added,'.
					' TIME_TO_SEC(TIMEDIFF(NOW(), date_added)) AS date_edit'.
					' FROM '.$this->CFG['db']['tbl']['blog_comments'].
					' WHERE comment_status= \'Yes\' AND blog_post_id='.$this->dbObj->Param('blog_post_id').' AND'.
					' blog_comment_main_id='.$this->dbObj->Param('blog_comment_main_id').
					' ORDER BY blog_comment_id DESC';


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id'], $comment_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$populateReply_arr['row'] = array();
				$populateReply_arr['rs_PO_RecordCount'] = $rs->PO_RecordCount();
				if($rs->PO_RecordCount())
					{

						$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type', 'sex');

						$inc = 0;
						while($row = $rs->FetchRow())
							{

								if(!isset($this->UserDetails[$row['comment_user_id']]))
									$this->UserDetails[$row['comment_user_id']] = $this->getUserDetail('user_id',$row['comment_user_id']);

                                $user_name=$this->UserDetails[$row['comment_user_id']]['user_name'];
								$populateReply_arr['row'][$inc]['name'] = $user_name;
								/*$populateReply_arr['row'][$inc]['icon'] = $rayzz->getProfileIconDetails($this->UserDetails[$row['comment_user_id']]['icon_id'], $this->UserDetails[$row['comment_user_id']]['icon_type'], $this->UserDetails[$row['comment_user_id']]['sex']);*/


								$populateReply_arr['s_attribute'] = isset($icondetail['icon']['s_attribute'])?$icondetail['icon']['s_attribute']:'';
								$populateReply_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['comment_user_id']);
								$populateReply_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $this->UserDetails[$row['comment_user_id']]['user_name']);
								$row['bc_date_added'] = getTimeDiffernceFormat($row['bc_date_added']);
								//$row['comment'] = wordWrap_mb_ManualWithSpace($row['comment'], $this->CFG['admin']['blog']['member_post_comments_length']);
								$populateReply_arr['row'][$inc]['class'] = 'clsNotEditable';



								$row['pc_date_added'] = getTimeDiffernceFormat($row['bc_date_added']);
								$row['comment'] = $row['comment'];
								$populateReply_arr['row'][$inc]['record'] = $row;

								$populateReply_arr['row'][$inc]['class'] = 'clsNotEditable';
								if($row['comment_user_id']==$this->CFG['user']['user_id'])
									{
										$time = $this->CFG['admin']['blog']['comment_edit_allowed_time'] - $row['date_edit'];
										if($time>2)
											{
												$populateReply_arr['row'][$inc]['class'] = 'clsEditable';
											}
									}

								$populateReply_arr['row'][$inc]['comment_memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $this->UserDetails[$row['comment_user_id']]['user_name']);
								$temp_reply = nl2br(makeClickableLinks($row['comment']));
								$populateReply_arr['row'][$inc]['comment_makeClickableLinks'] = nl2br(makeClickableLinks($row['comment']));
//								$populateReply_arr['row'][$inc]['comment_makeClickableLinks'] = wordWrap_mb_Manual($temp_reply, 120, strlen($temp_reply), 0);

								if(isMember() AND $row['comment_user_id'] == $this->CFG['user']['user_id'])
									{
										$populateReply_arr['row'][$inc]['time'] = $this->CFG['admin']['blog']['comment_edit_allowed_time']-$row['date_edit'];
										if($populateReply_arr['row'][$inc]['time'] > 2)
											{
												$this->enabled_edit_fields[$row['blog_comment_id']] = $populateReply_arr['row'][$inc]['time'];
											}
									}
								$inc++;
							}
					}
				return $populateReply_arr;
			}


		/**
		 * ViewPost::getEditCommentBlock()
		 *
		 * @return
		 */
		public function getEditCommentBlock()
			{
				global $smartyObj;
				$replyBlock['comment_id']=$this->fields_arr['comment_id'];
				$replyBlock['name']='addEdit_';
				$replyBlock['sumbitFunction']='addToEdit';
				$replyBlock['cancelFunction']='discardEdit';
				$replyBlock['editReplyUrl']=$this->CFG['site']['blog_url'].'viewPost.php?ajax_page=true&amp;page=update_comment&amp;blog_post_id='.$this->fields_arr['blog_post_id'].'&vpkey='.$this->fields_arr['vpkey'].'&show='.$this->fields_arr['show'];
				$smartyObj->assign('commentEditReply', $replyBlock);
				setTemplateFolder('general/','blog');
				$smartyObj->display('postCommentEditReplyBlock.tpl');
			}

		/**
		 * ViewPost::chkLinksDisplayAllowedTo()
		 *
		 * @return
		 */
		public function chkLinksDisplayAllowedTo()
			{
				if($this->CFG['admin']['blog']['display_link_details_to'] == 'Owner')
					{
						if($this->CFG['user']['user_id'] == $this->fields_arr['user_id'])
							return true;
						else
							return false;

					}
				elseif($this->CFG['admin']['blog']['display_link_details_to'] == 'All')
					return true;
			}
		/**
		 * ViewPost::getUserPhotoDetail()
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
					trigger_db_error($this->dbObj);

				$getUserDetail['record']  = $rs->FetchRow();
				$row = $rs->FetchRow();
				$user_name=$this->getUserDetail('user_id',$row['user_id'], 'user_name');

				return getMemberAvatarDetails($user_name);

			}
		/**
		 * ViewPost::getComment()
		 *
		 * @return
		 */
		public function getComment()
			{
				$sql = 'SELECT comment FROM '.$this->CFG['db']['tbl']['blog_comments'].' WHERE'.
						' blog_comment_id='.$this->dbObj->Param('blog_comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
				{
					return $row['comment'];
				}
			}

		/**
		 * ViewPost::getExistingRecords()
		 *
		 * @param mixed $sql
		 * @return
		 */
		public function getExistingRecords($sql)
			{
				$stmt = $this->dbObj->Prepare($sql);
				//echo $sql.'<br />';
				$rs = $this->dbObj->Execute($stmt);
				 if (!$rs)
				    trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				return 	$row['count'];
			}

		/**
		 * ViewPost::chkAuthorizedUser()
		 *
		 * @return
		 */
		public function chkAuthorizedUser()
			{
				if(!$this->fields_arr['comment_id'])
					return false;

				$sql = 'SELECT count(1) as count FROM '.$this->CFG['db']['tbl']['blog_comments'].
						' WHERE blog_comment_id='.$this->dbObj->Param('blog_comment_id').
						' AND comment_user_id='.$this->dbObj->Param('comment_user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id'], $this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if($row['count'])
					return true;
				return false;
			}
		/**
		 * ViewPost::chkisPostOwner()
		 *
		 * @return
		 */
		public function chkisPostOwner()
		{
			$sql = 'SELECT blog_post_id FROM '.$this->CFG['db']['tbl']['blog_posts'].' AS bp'.
					' WHERE bp.blog_post_id = '.$this->dbObj->Param('blog_post_id').' AND bp.user_id = '.$this->dbObj->Param('user_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id'], $this->CFG['user']['user_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);

			$row = $rs->FetchRow();

			if($row['blog_post_id'] != '')
				return true;
			return false;
		}
		/**
		 * ViewPost::getFavorite()
		 *
		 * @return
		 */
		public function getFavorite()
		{
			$favorite['added']='';
			$favorite['id']='';
			if(!isMember())
			{
				$favorite['url'] = getUrl('viewpost', '?blog_post_id='.
									$this->fields_arr['blog_post_id'].'&title='.$this->changeTitle($this->fields_arr['blog_post_name']),
										$this->fields_arr['blog_post_id'].'/'.$this->changeTitle($this->fields_arr['blog_post_name']).'/', 'members', 'blog');
			}
			else
			{
				$condition = 'blog_post_id='.$this->dbObj->Param('blog_post_id').
					 		 ' AND user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';

				$condtionValue = array($this->fields_arr['blog_post_id'], $this->CFG['user']['user_id']);

				$favorite['url'] = $this->CFG['site']['blog_url'].'viewPost.php?blog_post_id='.
									  $this->fields_arr['blog_post_id'].'&ajax_page=true&page=favorite';

				if($rs = $this->selectFavoritePost($condition, $condtionValue, 'full'))
				{
					if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$favorite['added'] = true;
						$favorite['id'] = $row['blog_favorite_id'];
					}
				}
			}
			return $favorite;
		}
		/**
		 * ViewPost::getFeatured()
		 *
		 * @return
		 */
		public function getFeatured()
		{
			$featured['added'] = '';
			$featured['id'] = '';
			$featured['url'] = '';
			if(!isMember())
			{
				$featured['url'] = getUrl('viewpost', '?blog_post_id='.$this->fields_arr['blog_post_id'].'&title='.
										$this->changeTitle($this->fields_arr['blog_post_name']),
											$this->fields_arr['blog_post_id'].'/'.
												$this->changeTitle($this->fields_arr['blog_post_name']).'/', 'members', 'blog');
			}
			else
			{
				$condition= 'blog_post_id='.$this->dbObj->Param('blog_post_id').
						     ' AND user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';
				$condtionValue=array($this->fields_arr['blog_post_id'], $this->CFG['user']['user_id']);
				$featured['url'] = $this->CFG['site']['blog_url'].'viewPost.php?blog_post_id='.
										$this->fields_arr['blog_post_id'].
											'&ajax_page=true&page=featured';

				if($rs = $this->selectFeaturedPost($condition, $condtionValue, 'full'))
				{
					if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$featured['added'] = true;
					}
				}

			}
			return $featured;
		}
		/**
		 * ViewPost::insertFavoritePost()
		 *
		 * @return
		 */
		public function insertFavoritePost()
		{
			if($this->fields_arr['favorite'])
			{
				$condition = 'blog_post_id='.$this->dbObj->Param('blog_post_id').' AND user_id='.$this->dbObj->Param('user_id');
				$condtionValue = array($this->fields_arr['blog_post_id'], $this->CFG['user']['user_id']);

				if(!$this->selectFavoritePost($condition, $condtionValue))
				{
					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_favorite'].' SET'.
						   ' user_id='.$this->dbObj->Param('user_id').','.
						   ' blog_id='.$this->dbObj->Param('blog_id').','.
						   ' blog_post_id='.$this->dbObj->Param('blog_post_id').','.
					       ' date_added=NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['blog_id'],$this->fields_arr['blog_post_id']));
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.
							$this->dbObj->ErrorMsg(), E_USER_ERROR);

					if($this->dbObj->Insert_ID())
					{
						$favorite_id = $this->dbObj->Insert_ID();
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET total_favorites = total_favorites+1'.
								' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						echo $this->LANG['viewpost_favorite_added_successfully'];

						//Srart Post blog post favorite blog activity	..
						$sql = 'SELECT bf.blog_favorite_id, bf.blog_post_id, bf.user_id as favorite_user_id, u.user_name, '.
								'bp.blog_post_name, bp.user_id '.
								'FROM '.$this->CFG['db']['tbl']['blog_favorite'].' as bf, '.$this->CFG['db']['tbl']['users'].
								' as u, '.$this->CFG['db']['tbl']['blog_posts'].' as bp '.
								' WHERE u.user_id = bf.user_id AND bf.blog_post_id = bp.blog_post_id '.
								' AND bf.blog_favorite_id = '.$this->dbObj->Param('blog_favorite_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($favorite_id));
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$row = $rs->FetchRow();
						$activity_arr = $row;
						$activity_arr['action_key']	= 'blog_post_favorite';
						$blogActivityObj = new BlogActivityHandler();
						$blogActivityObj->addActivity($activity_arr);
						//end
					}
				}
			}
		}
		/**
		 * ViewPost::insertFeaturedPost()
		 *
		 * @return
		 */
		public function insertFeaturedPost()
		{
			if($this->fields_arr['featured'])
			{
				$condition = 'blog_post_id='.$this->dbObj->Param('blog_post_id').' AND user_id='.$this->dbObj->Param('user_id');
				$condtionValue=array($this->fields_arr['blog_post_id'],$this->CFG['user']['user_id']);
				if(!$this->selectFeaturedPost($condition,$condtionValue))
				{
					$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['blog_featured'].' SET'.
						' user_id='.$this->dbObj->Param('user_id').','.
						' blog_id='.$this->dbObj->Param('blog_id').','.
						' blog_post_id='.$this->dbObj->Param('blog_post_id').','.
						' date_added=NOW()';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['blog_id'],$this->fields_arr['blog_post_id']));
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo().' '.
							$this->dbObj->ErrorMsg(), E_USER_ERROR);

					if($this->dbObj->Insert_ID())
					{
						$featured = $this->dbObj->Insert_ID();
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET total_featured = total_featured+1'.
								' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						echo $this->LANG['viewpost_featured_added_successfully'];

						//Srart Post blog post featured blog activity	..
						$sql = 'SELECT bf.blog_featured_id, bf.blog_post_id, bf.user_id as featured_user_id,'.
								' u.user_name, bp.blog_post_name, bp.user_id '.
								'FROM '.$this->CFG['db']['tbl']['blog_featured'].' as bf, '.
								$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['blog_posts'].' as bp '.
								'WHERE u.user_id = bf.user_id AND bf.blog_post_id = bp.blog_post_id AND bf.blog_featured_id = '
								.$this->dbObj->Param('blog_featured_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($featured));
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$row = $rs->FetchRow();
						$activity_arr = $row;
						$activity_arr['action_key']	= 'blog_post_featured';
						$blogActivityObj = new BlogActivityHandler();
						$blogActivityObj->addActivity($activity_arr);
						//end
					}
				}
			}

		}
		public function insertFlagPostTable()
		{
			echo $this->LANG['viewpost_your_request'];
			$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
					' content_type=\'Blog\' AND'.
					' content_id='.$this->dbObj->Param('content_id').' AND'.
					' reporter_id='.$this->dbObj->Param('reporter_id').' AND'.
					' status=\'Ok\'';

			$fields_value_arr = array($this->fields_arr['blog_post_id'], $this->CFG['user']['user_id']);
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if(!$rs->PO_RecordCount())
				{
					if($this->fields_arr['flag'])
						{
							$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['flagged_contents'].' SET'.
									' content_id='.$this->dbObj->Param('content_id').','.
									' content_type=\'Blog\', flag='.$this->dbObj->Param('flag').','.
									' flag_comment='.$this->dbObj->Param('flag_comment').','.
									' reporter_id='.$this->dbObj->Param('reporter_id').','.
									' date_added=NOW()';

							$insert_flag_values_arr = array($this->fields_arr['blog_post_id'], $this->fields_arr['flag'],
															$this->fields_arr['flag_comment'], $this->CFG['user']['user_id']);

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, $insert_flag_values_arr);
						    if (!$rs)
							    trigger_db_error($this->dbObj);
						}
					else if($this->fields_arr['flag_comment'])
						{
							$this->fields_arr['flag'] = $this->LANG['viewpost_others_label'];
							$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['flagged_contents'].' SET'.
									' content_id='.$this->dbObj->Param('content_id').','.
									' content_type=\'Blog\', flag='.$this->dbObj->Param('flag').','.
									' flag_comment='.$this->dbObj->Param('flag_comment').','.
									' reporter_id='.$this->dbObj->Param('reporter_id').','.
									' date_added=NOW()';

							$insert_flag_values_arr = array($this->fields_arr['blog_post_id'], $this->fields_arr['flag'], $this->fields_arr['flag_comment'],
																$this->CFG['user']['user_id']);
							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, $insert_flag_values_arr);
						    if (!$rs)
							   trigger_db_error($this->dbObj);
						}

						//Inform flagged blog post to admin through mail\\
						//Subject..
						$flagged_subject = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $this->LANG['blog_post_flagged_subject']);
						$flagged_subject = str_replace('VAR_BLOG_POST_NAME', $this->fields_arr['blog_post_name'], $flagged_subject);
						//Content..
						$sql ='SELECT blog_post_name, message '.
								' FROM '.$this->CFG['db']['tbl']['blog_posts'].
								' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.
								$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$row = $rs->FetchRow();
						//blog post title
						$flagged_message = str_replace('VAR_BLOG_POST_NAME', $row['blog_post_name'], $this->LANG['blog_post_flagged_content']);

						$postlink = getUrl('viewpost','?blog_post_id='.$this->fields_arr['blog_post_id'].
										'&amp;title='.$this->changeTitle($row['blog_post_name']), $this->fields_arr['blog_post_id'].'/'.
											$this->changeTitle($row['blog_post_name']).'/', 'root','blog');

						//blog post description
						$post_description =strip_tags($row['message']);
						$flagged_message = str_replace('VAR_BLOG_POST_DESCRIPTION', $post_description, $flagged_message);
						//flagged title, flagged content
						$admin_link = $this->CFG['site']['url'].'admin/blog/manageFlaggedPost.php';
						$flagged_title = '<a href="'.$admin_link.'">'.$this->fields_arr['flag'].'</a>';
						$flagged_message = str_replace('VAR_FLAGGED_TITLE', $flagged_title, $flagged_message);
						$flagged_message = str_replace('VAR_FLAGGED_CONTENT', $this->fields_arr['flag_comment'], $flagged_message);
						//User name
						$flagged_message = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $flagged_message);
						//site name
						$flagged_message = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $flagged_message);
						$is_ok = $this->_sendMail($this->CFG['site']['webmaster_email'],
									$flagged_subject, $flagged_message, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
				}
		}

		/**
		 * To send email
		 *
		 * @param 		string $to_email to email id
		 * @param 		string $subject subject
		 * @param		string $body mail body
		 * @param 		string $sender_name sender name
		 * @param 		string $sender_email sender email
		 * @return 		void
		 * @access 		private
		 */
		public function _sendMail($to_email, $subject, $body, $sender_name, $sender_email)
			{
			    /*echo '$to_email : '.$to_email,'<br>';
				echo '$subject : '.$subject,'<br>';
				echo '$body : '.$body,'<br>';
				echo '$sender_name : '.$sender_name,'<br>';
				echo '$sender_email : '.$sender_email,'<br>';*/
				$this->buildEmailTemplate($subject, $body, false, true);
				$EasySwift = new EasySwift($this->getSwiftConnection());
				$EasySwift->flush();
				$EasySwift->addPart($this->getEmailContent(), "text/html");
				$from_address = $sender_name.'<'.$sender_email.'>';
				return $EasySwift->send($to_email, $from_address, $this->getEmailSubject());
			}

		public function populatePostRateDetails()
		{
			$sql = 'SELECT rating_total, rating_count FROM '.$this->CFG['db']['tbl']['blog_posts'].
					' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($row = $rs->FetchRow())
				{
					$this->fields_arr['rating_total'] = $row['rating_total'];
					$this->fields_arr['rating_count'] = $row['rating_count'];
					return true;
				}
			return false;
		}
		/**
		 * ViewPost::getTotalRatingImage()
		 *
		 * @return
		 */
		public function getTotalRatingImage()
		{
			if($this->populatePostRateDetails())
			{
			    $rating = round($this->fields_arr['rating_total']/$this->fields_arr['rating_count'],0);
				$this->populateRatingImagesForAjax($rating);
				$rating_text = $this->LANG['viewpost_rated'];
				$getPostRating = $this->getPostRating($this->fields_arr['blog_post_id']);
				echo '&nbsp;(<span>'.$this->fields_arr['rating_count'].'</span>)';
			}
		}
		/**
		 * ViewPost::getPostRating()
		 *
		 * @param string $blog_post_id
		 * @return
		 */
		public function getPostRating($blog_post_id = '')
		{
			$rating = 0;
			$sql  = 'SELECT (rating_total/rating_count) as rating FROM '.$this->CFG['db']['tbl']['blog_posts'].' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';
			$stmt = $this->dbObj->Prepare($sql);
			$rs   = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
		    if (!$rs)
				trigger_db_error($this->dbObj);

			if($row = $rs->FetchRow())
				return round($row['rating']);
			return $rating;
		}

		 /**
		 * chkAllowRating()
		 *
		 * @return
		 */
		public function chkAllowRating()
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['blog_posts'].
						' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').
						' AND allow_ratings=\'Yes\' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					return true;
				return false;
			}
		/**
		 * ViewPost::chkAlreadyRated()
		 *
		 * @return
		 */
		public function chkAlreadyRated()
		{
			$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['blog_rating'].
					' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
					' blog_post_id='.$this->dbObj->Param('blog_post_id').' LIMIT 0,1';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['blog_post_id']));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($row = $rs->FetchRow())
				return $row['rate'];
			return false;
		}
		/**
		 * ViewPost::insertRating()
		 *
		 * @return
		 */
		public function insertRating()
		{
			if($this->fields_arr['rate'])
			{
				$rate_old = $this->chkAlreadyRated();
				$rate_new = $this->fields_arr['rate'];
				if($rate_new==1 && $rate_old==1)
				return true;

				if($rate_old > 0)
				{
					$rating_id = '';
					$diff = $rate_new - $rate_old;
					if($diff==0)
						return true;

					$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_rating'].' SET'.
							' rate='.$this->dbObj->Param('rate').','.
							' date_added=NOW() '.
							' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').' AND '.
							' user_id='.$this->dbObj->Param('user_id');

					$update_fields_value_arr = array($this->fields_arr['rate'], $this->fields_arr['blog_post_id'],
													$this->CFG['user']['user_id']);
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, $update_fields_value_arr);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

					if($diff > 0)
						{
							$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET'.
									' rating_total=rating_total+'.$diff.' '.
									' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id');
						}
					else
						{
							$sql = 'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET'.
									' rating_total=rating_total'.$diff.' '.
									' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id');
						}

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

					//Find rating for rating blog post activity..
					$sql = 'SELECT blog_rating_id '.
							'FROM '.$this->CFG['db']['tbl']['blog_rating'].' '.
							' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').' AND '.
							' user_id='.$this->dbObj->Param('user_id');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id'],  $this->CFG['user']['user_id']));
					if (!$rs)
						trigger_db_error($this->dbObj);

					$row = $rs->FetchRow();
					$rating_id = $row['blog_rating_id'];
				}
				else
				{
					$sql =  'INSERT INTO '.$this->CFG['db']['tbl']['blog_rating'].
							' (blog_post_id, blog_id, user_id, rate, date_added ) '.
							' VALUES ( '.
							$this->dbObj->Param('blog_post_id').','.$this->dbObj->Param('blog_id').','.$this->dbObj->Param('user_id').','.$this->dbObj->Param('rate').',NOW()'.
							' ) ';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id'],$this->fields_arr['blog_id'], $this->CFG['user']['user_id'], $this->fields_arr['rate']));
				    if (!$rs)
					   trigger_db_error($this->dbObj);

					$rating_id = $this->dbObj->Insert_ID();

					$sql =  'UPDATE '.$this->CFG['db']['tbl']['blog_posts'].' SET'.
							' rating_total=rating_total+'.$this->fields_arr['rate'].','.
							' rating_count=rating_count+1'.
							' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				}


				//Srart Post blog post rating blog activity	..
				$sql = 'SELECT br.blog_rating_id, br.blog_post_id, br.user_id as rating_user_id, br.rate, '.
						'u.user_name, bp.blog_post_name, bp.user_id '.
						'FROM '.$this->CFG['db']['tbl']['blog_rating'].' as br, '.
						$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['blog_posts'].' as bp '.
						' WHERE u.user_id = br.user_id AND br.blog_post_id = bp.blog_post_id AND br.blog_rating_id = '.
						$this->dbObj->Param('blog_rating_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($rating_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$activity_arr = $row;
				$activity_arr['action_key']	= 'blog_post_rated';
				$blogActivityObj = new BlogActivityHandler();
				$blogActivityObj->addActivity($activity_arr);
				//end
			}
		}
		/**
		 * ViewPost::populateFlagContent()
		 *
		 * @return
		 */
		public function populateFlagContent()
			{
				global $smartyObj;
				$flagContent['url'] = $this->CFG['site']['blog_url'].'viewPost.php?ajax_page=true&'.
											'page=flag&blog_post_id='.$this->getFormField('blog_post_id').'&show='.$this->fields_arr['show'];
				$smartyObj->assign('flagContent', $flagContent);
				setTemplateFolder('general/','blog');
				$smartyObj->display('postFlag.tpl');
			}
		/**
		 * ViewPost::getCommentsBlock()
		 *
		 * @return
		 */
		public function getCommentsBlock()
			{
				global $smartyObj;
				$getCommentsBlock_arr = array();


				if($this->CFG['admin']['blog']['captcha'] and $this->CFG['admin']['blog']['captcha_method']=='image')
					{
						$getCommentsBlock_arr['captcha_comment_url'] = $this->CFG['site']['url'].'captchaComment.php?captcha_key=photocomment&amp;captcha_value='.$this->getCaptchaText();
					}

				$smartyObj->assign('getCommentsBlock_arr', $getCommentsBlock_arr);
				setTemplateFolder('general/', 'blog');
				$smartyObj->display('getCommentsBlock.tpl');
			}


	    /**
	     * ViewPost::getCaptchaText()
	     *
	     * @return
	     */
	    public function getCaptchaText()
			{
				$captcha_length = 5;
				$this->captchaText = rand(pow(10, $captcha_length-1), pow(10, $captcha_length)-1);
				return $this->captchaText;
			}
		/**
	     * ViewPost::chkPostStatus()
	     * To Check post status
	     * @return true or false
	     */
		public function chkPostStatus()
			{
				$sql = 'SELECT status,blog_post_id FROM '.$this->CFG['db']['tbl']['blog_posts'].
					   ' WHERE blog_post_id='.$this->dbObj->Param('blog_post_id').
					   ' AND status='.$this->dbObj->Param('status').'LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['blog_post_id'],'Ok'));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
				if($rs->PO_RecordCount())
				 return true;
				else
				 return false;
			}
		public function displayPostRatingImage($post_id)
		{

			$sql = 'SELECT (bp.rating_total/bp.rating_count) as rating FROM '.
				   $this->CFG['db']['tbl']['blog_posts'].' AS bp '.
				   ' WHERE bp.status=\'Ok\' AND bp.blog_id='.$this->dbObj->Param('blog_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($post_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			$row = $rs->FetchRow();
			{

			   if($row['rating']!='')
			   {


					return $this->populateBlogRatingImages($row['rating'],'blog');
			   }
			   else
			   {
			   		return $this->populateBlogRatingImages(0,'blog');
			   }
			}
		}

}
$ViewPost = new ViewPost();
$ViewPost->setDBObject($db);

$ViewPost->makeGlobalize($CFG,$LANG);


if(!chkAllowedModule(array('blog')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$ViewPost->setPageBlockNames(array('msg_form_error', 'msg_form_success','blog_post_form','delete_confirm_form',
					        'add_comments','add_reply',  'edit_comment', 'update_comment','confirmation_flagged_form',
							'rating_image_form','add_flag_list','add_fovorite_list','confirmation_adult_form','postMainBlock',
							'block_add_comments','blog_comments_block','share_fav_falg_block','invalid_posts_block'
							 ));

$CFG['admin']['blog']['captcha_method'] = "honeypot"; // For test ing purpose added
//default form fields and values...
$ViewPost->setFormField('blog_post_id', '');
$ViewPost->setFormField('blog_id', '');
$ViewPost->setFormField('blog_name', '');
$ViewPost->setFormField('blog_title', '');
$ViewPost->setFormField('blog_slogan', '');
$ViewPost->setFormField('title', '');
$ViewPost->setFormField('status', '');
$ViewPost->setFormField('vpkey', '');
$ViewPost->setFormField('action', '');
$ViewPost->setFormField('paging', '');
$ViewPost->setFormField('blog_logo_src', '');
$ViewPost->setFormField('blog_title', '');
$ViewPost->setFormField('blog_url', '');
$ViewPost->setFormField('blog_rss_url', '');
$ViewPost->setFormField('showall', '');
$ViewPost->setFormField('user_name', '');

$ViewPost->setFormField('user_id', '');
$ViewPost->setFormField('post_keyword', '');
$ViewPost->setFormField('postSearchFromSubmission', '');

//for ajax
$ViewPost->setFormField('f',0);
$ViewPost->setFormField('show','1');
$ViewPost->setFormField('comment_id',0);
$ViewPost->setFormField('maincomment_id','');

$ViewPost->setFormField('type','');
$ViewPost->setFormField('ajax_page','');
$ViewPost->setFormField('paging','');
$ViewPost->setFormField('rate', '');
$ViewPost->setFormField('flag', '');
$ViewPost->setFormField('flag_comment', '');
$ViewPost->setFormField('page', '');
$ViewPost->setFormField('favorite_id', '');
$ViewPost->setFormField('favorite', '');
$ViewPost->setFormField('flag', '');
$ViewPost->setFormField('flagged_content', '');
$ViewPost->setFormField('featured', '');
$ViewPost->setFormField('rate', '');
$ViewPost->setFormField('blog_tags', '');
$ViewPost->setFormField('view','');
$ViewPost->setFormField('recaptcha_challenge_field', '');
$ViewPost->setFormField('recaptcha_response_field', '');
$ViewPost->setFormField('blog_category_type', '');
$ViewPost->setFormField('msg', '');
$ViewPost->setFormField('blog_category_id ', '');
$ViewPost->setFormField('blog_sub_category_id ', '');
$ViewPost->setFormField('y', '');
$ViewPost->setFormField('m', '');
$ViewPost->setFormField('order', '');
$ViewPost->setFormField('blog_post_name', '');

// ********** Page Navigation Start ********
$ViewPost->setFormField('start', '0');
$ViewPost->setFormField('numpg', 3);


$ViewPost->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$ViewPost->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$ViewPost->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$ViewPost->setTableNames(array());
$ViewPost->setReturnColumns(array());
$ViewPost->memberLoginBlogUrl = getUrl('viewpost', '?blog_post_id='.$ViewPost->getFormfield('blog_post_id').'&amp;title='.$ViewPost->changeTitle($ViewPost->getFormfield('blog_post_name')), $ViewPost->getFormfield('blog_post_id').'/'.$ViewPost->changeTitle($ViewPost->getFormfield('blog_post_name')).'/?mem_auth=true', 'members', 'blog');

$ViewPost->sanitizeFormInputs($_REQUEST);
$check_posts_status=$ViewPost->chkPostStatus();
if($check_posts_status=='' && !$CFG['admin']['is_logged_in'])
{
	$ViewPost->setAllPageBlocksHide();
	$ViewPost->setPageBlockShow('invalid_posts_block');
	$ViewPost->setPageBlockHide('blog_comments_block');
}
$ViewPost->flag_type_arr = $LANG_LIST_ARR['flag']['blog'];

if($ViewPost->getFormField('ajax_page')=='true' && $ViewPost->getFormField('page')=='flag')
{
	global $smartyObj;
	$flagContent['url'] = $ViewPost->CFG['site']['blog_url'].'viewPost.php?ajax_page=true&'.
								'page=flag&blog_post_id='.$ViewPost->getFormField('blog_post_id').'&show='.$ViewPost->getFormField('show');
	$smartyObj->assign('flagContent', $flagContent);
	$smartyObj->assign('myobj', $ViewPost);
	setTemplateFolder('general/','blog');
	$smartyObj->assign('LANG', $ViewPost->LANG);
	$smartyObj->display('postFlag.tpl');
}

if(isAjaxpage())
{
/*
	echo "<pre>";
			print_r($_REQUEST);
		echo "</pre>";
*/


	   $ViewPost->includeAjaxHeaderSessionCheck();
	   $ViewPost->validate = $ViewPost->chkValidPostId();
	    if($ViewPost->getFormField('status')=='Ok' || $CFG['admin']['is_logged_in'])
	     	$ViewPost->setPageBlockShow('share_fav_falg_block');

		// new code added for ajax comments

		if($ViewPost->getFormField('type')=='edit')
			{
				$ViewPost->setPageBlockShow('edit_comment');
			}
		else if($ViewPost->isFormGETed($_GET, 'comment_id'))
			{
				$ViewPost->setPageBlockShow('add_reply');
			}
		else if(!$ViewPost->getFormField('paging'))
			{
				$ViewPost->setPageBlockShow('add_comments');
			}

		if ($ViewPost->isPageGETed($_POST, 'ajaxpaging'))
		    {
				$ViewPost->populateCommentOfThisPost();
				ob_end_flush();
				die();
		    }
		if($ViewPost->isFormGETed($_GET, 'f') and $ViewPost->getFormField('type')=='edit')
			{
				$ViewPost->setAllPageBlocksHide();
				$htmlstring = trim(urldecode($ViewPost->getFormField('f')));
				$htmlstring = strip_tags(html_entity_decode($htmlstring), '<br><br />');
				$ViewPost->setFormField('f',$htmlstring);
				$ViewPost->checkLoginStatusInAjax($ViewPost->memberLoginBlogUrl);
				$ViewPost->updateCommentAndBlogPostTable();
			}
		else if($ViewPost->isFormGETed($_GET, 'f'))
			{
				if($CFG['admin']['blog']['captcha']
						AND $CFG['admin']['blog']['captcha_method'] == 'recaptcha'
							AND $CFG['captcha']['public_key'] AND $CFG['captcha']['private_key'])
						{
							$ViewPost->chkIsCaptchaNotEmpty('recaptcha_response_field', $LANG['common_err_tip_compulsory']) AND
								$ViewPost->chkCaptcha('recaptcha_response_field', $LANG['common_err_tip_invalid_captcha']);
						}
				$ViewPost->setAllPageBlocksHide();
				$htmlstring = trim(urldecode($ViewPost->getFormField('f')));
				$htmlstring = strip_tags(html_entity_decode($htmlstring), '<br><br />');
				$ViewPost->setFormField('f',$htmlstring);
				$ViewPost->checkLoginStatusInAjax($ViewPost->memberLoginBlogUrl);
				$ViewPost->insertCommentAndBlogPostTable();
				die;
			}
		else if($ViewPost->getFormField('page')=='deletecomment')
			{
				$ViewPost->setAllPageBlocksHide();
				$ViewPost->checkLoginStatusInAjax($ViewPost->memberLoginBlogUrl);
				$ViewPost->deleteComment();
				$ViewPost->populateCommentOfThisPost();
			}
		else if($ViewPost->getFormField('page')=='deletecommentreply')
			{
				$ViewPost->setAllPageBlocksHide();
				$ViewPost->deleteComment();
				$ViewPost->populateReplyCommentOfThisPost();
			}


		// new code ends for ajax comments

		if($ViewPost->isFormGETed($_GET, 'rate'))
			{
				if($ViewPost->chkAllowRating())
					{
						$ViewPost->setAllPageBlocksHide();
						$ViewPost->insertRating();
						$ViewPost->getTotalRatingImage();
						die();
					}
			}
		else if($ViewPost->isFormGETed($_GET, 'flag')
				or $ViewPost->isFormGETed($_GET, 'flag_comment'))
			{
				$ViewPost->setAllPageBlocksHide();
				if(!$ViewPost->chkIsNotEmpty('flag_comment', $LANG['viewpost_flag_comment_invalid']))
					{
						$ViewPost->getFormFieldErrorTip('flag_comment');
						exit;
					}
				$ViewPost->setFormField('flag_comment',trim(urldecode($ViewPost->getFormField('flag_comment'))));
				$ViewPost->checkLoginStatusInAjax($ViewPost ->memberLoginBlogUrl);
				$ViewPost->insertFlagPostTable();
			}
		else if($ViewPost->isFormGETed($_GET, 'favorite'))
			{
				$ViewPost->setAllPageBlocksHide();
				$ViewPost->checkLoginStatusInAjax($ViewPost ->memberLoginBlogUrl);
				if($ViewPost->getFormField('favorite'))
					{
						$ViewPost->insertFavoritePost();
					}
				else
					{
						$ViewPost->deleteFavoritePost($ViewPost->getFormField('blog_post_id'),$CFG['user']['user_id']);
						echo $ViewPost->LANG['viewpost_favorite_deleted_successfully'];
					}
			}
		else if($ViewPost->isFormGETed($_GET, 'featured'))
			{
				$ViewPost->setAllPageBlocksHide();
				if($ViewPost->getFormField('featured'))
				{
					$ViewPost->insertFeaturedPost();
				}
				else
				{
					$ViewPost->deleteFromFeatured(true, $ViewPost->getFormField('blog_post_id'));
				}
			}

		if($ViewPost->getFormField('page') != '')
			{
				switch ($ViewPost->getFormField('page'))
					{
						case 'load_flag':
							$ViewPost->populateFlagContent();
						break;

						case 'post_comment':
							if($CFG['admin']['blog']['captcha'] AND $CFG['admin']['blog']['captcha_method'] == 'recaptcha'
										AND $CFG['captcha']['public_key'] AND $CFG['captcha']['private_key'])
								{
									$ViewPost->chkIsCaptchaNotEmpty('recaptcha_response_field', $LANG['common_err_tip_compulsory']) AND
										$ViewPost->chkCaptcha('recaptcha_response_field', $LANG['common_err_tip_invalid_captcha']);
								}
							$ViewPost->setAllPageBlocksHide();
							$ViewPost->setPageBlockShow('block_add_comments');
							$htmlstring = trim(urldecode($ViewPost->getFormField('f')));
							$htmlstring = strip_tags(html_entity_decode($htmlstring), '<br><br />');
							$ViewPost->setFormField('f',$htmlstring);
							$ViewPost->insertCommentAndBlogPostTable();
						break;

						case 'deletecomment':
							$ViewPost->setPageBlockShow('block_add_comments');
							//$ViewPost->deleteComment();
						break;

						case 'comment_edit':
							echo $ViewPost->getFormField('comment_id');
							echo '***--***!!!';
							$ViewPost->getEditCommentBlock();
						break;

						case 'update_comment':
							$htmlstring = trim(urldecode($ViewPost->getFormField('f')));
							$htmlstring = strip_tags(html_entity_decode($htmlstring), '<br><br />');
							$ViewPost->setFormField('f',$htmlstring);
							$ViewPost->checkLoginStatusInAjax($ViewPost->memberLoginBlogUrl);
							$ViewPost->updateCommentAndBlogPostTable();
							echo $ViewPost->getFormField('comment_id');
							echo '***--***!!!';
							echo $ViewPost->getFormField('f');
						break;

					}
				$ViewPost->includeAjaxFooter();
				exit;
			}
		if($ViewPost->isShowPageBlock('add_reply'))
			{
				echo $ViewPost->getFormField('comment_id');
				echo '***--***!!!';
				$ViewPost->getReplyBlock();
			}
		if($ViewPost->isShowPageBlock('edit_comment'))
			{
				echo $ViewPost->getFormField('comment_id');
				echo '***--***!!!';
				$ViewPost->getEditCommentBlock();
				die;
			}
		if($ViewPost->isShowPageBlock('update_comment'))
			{
				echo $ViewPost->getFormField('comment_id');
				echo '***--***!!!';
				echo $ViewPost->getFormField('f');
				die;
			}
}
else
{
	$ViewPost->validate = false;
	$ViewPost->IS_USE_AJAX = true;
	$ViewPost->validate = $ViewPost->chkValidPostId();


	$LANG['meta_viewpost_keywords'] = str_replace('{default_tags}', $CFG['html']['meta']['keywords'], $LANG['meta_viewpost_keywords']);
	$LANG['meta_viewpost_keywords'] = str_replace('{tags}', $ViewPost->getFormField('blog_tags'), $LANG['meta_viewpost_keywords']);

	$LANG['meta_viewpost_description'] = str_replace('{default_tags}', $CFG['html']['meta']['description'], $LANG['meta_viewpost_description']);
	$LANG['meta_viewpost_description'] = str_replace('{tags}', $ViewPost->getFormField('blog_slogan'), $LANG['meta_viewpost_description']);

	$LANG['meta_viewpost_title'] = str_replace('{title}', $ViewPost->getFormField('blog_title').' : '.$ViewPost->getFormField('blog_post_name'), $LANG['meta_viewpost_title']);
	$LANG['meta_viewpost_title'] = str_replace('{module}', $LANG['window_title_blog'], $LANG['meta_viewpost_title']);

	setPageTitle($LANG['meta_viewblog_title']);
	setMetaKeywords($LANG['meta_viewblog_keywords']);
	setMetaDescription($LANG['meta_viewblog_description']);


	if($ViewPost->isFormGETed($_GET, 'action'))
	{
		$display = 'error';
		if(($ViewPost->getFormField('action')=='view' or $ViewPost->getFormField('action')=='accept' or $ViewPost->getFormField('action')=='reject') and $ViewPost->validate)
			{

			if(isAdultUser('allow'))
				$display = 'blog';
			else
				{
					if($CFG['admin']['blogs']['adult_content_view']!='No')
						$display = 'blog';
					else
						$display = 'error';
				}
			switch($display)
				{
					case 'error':
						$ViewPost->setAllPageBlocksHide();
						$ViewPost->setCommonErrorMsg($ViewPost->replaceAdultText($LANG['msg_error_not_allowed']));
						$ViewPost->setPageBlockShow('block_msg_form_error');
						break;

					case 'blog':
						switch($ViewPost->getFormField('action'))
							{
								case 'accept':
									$ViewPost->changeMyContentFilterSettings($CFG['user']['user_id'], 'Off');
									break;

								case 'reject':
									if($CFG['user']['user_id'])
										$ViewPost->changeMyContentFilterSettings($CFG['user']['user_id'], 'On');
									Redirect2Url($CFG['site']['url']);
									break;
							}
						$ViewPost->setPageBlockShow('block_viewphoto_photodetails');
						break;
				}
			}
		elseif($ViewPost->getFormField('flagged_content')=='show')
		{
			$display = 'blog';
		}
		else
			{
				$ViewPost->setAllPageBlocksHide();
			}
	}
	if($ViewPost->validate)
	{
		$ViewPost->postOwner = false;
		if(isMember())
		{
			if ($ViewPost->chkisPostOwner())
			{
			    $ViewPost->postOwner = true;
				$ViewPost->managepost_url = getUrl('manageblogpost', '?blog_post_id='.$ViewPost->getFormField('blog_post_id'), $ViewPost->getFormField('blog_post_id').'/', '', 'blog');
			}
		}


		$display = 'blog';
		if((chkAllowedModule(array('content_filter'))) and ($ViewPost->getFormField('blog_category_type')=='Porn'))
		{
			if(isAdultUser())
			{
				$display = 'blog';
			}
			else
			{
				if($CFG['admin']['blogs']['adult_content_view']=='Confirmation')
				{
					if($CFG['user']['content_filter']=='On')
					{
						$LANG['confirmation_alert_text'] = $LANG['confirmation_contet_filter_by_user'];
					}
					$display = 'adult';
				}
				else
				{
					if($CFG['user']['content_filter']=='On')
					{
						$LANG['confirmation_alert_text'] = $LANG['confirmation_contet_filter_by_user'];
						$display = 'adult';
					}
					else
						$display = 'error';
				}
			}
		}
		if(($ViewPost->getFormfield('flagged_status') == 'Yes') and ($ViewPost->getFormField('flagged_content')!='show'))
			$display = 'flag';

		if(($display == 'adult') and ($ViewPost->getFormField('action')=='view'))
			$display = 'blog';

		switch($display)
		{
			case 'error':
				$ViewPost->setAllPageBlocksHide();
				$ViewPost->setCommonErrorMsg($ViewPost->replaceAdultText($LANG['msg_error_not_allowed']));
				$ViewPost->setPageBlockShow('block_msg_form_error');
				break;

			case 'adult':
				$ViewPost->setAllPageBlocksHide();
				$ViewPost->setPageBlockShow('confirmation_adult_form');
				break;

			case 'flag':
				$ViewPost->setAllPageBlocksHide();
				$ViewPost->setPageBlockShow('confirmation_flagged_form');
				break;

			case 'blog':
                if($ViewPost->getFormField('status')=='Ok')
                {
                	$ViewPost->changeLastViewDateAndPostViewed();
				}
				$ViewPost->setPageBlockShow('blog_post_form');
			    $ViewPost->setPageBlockShow('postMainBlock');
			    $ViewPost->setPageBlockShow('blog_comments_block');
				break;
		}
	   $ViewPost->displayPost();
	    if($ViewPost->getFormField('status')=='Ok' || $CFG['admin']['is_logged_in'])
	      $ViewPost->setPageBlockShow('share_fav_falg_block');
	   $ViewPost->getPreviousPostLink($ViewPost->getFormField('blog_id'),$ViewPost->getFormField('blog_post_id'));
	   $ViewPost->getNextPostLink($ViewPost->getFormField('blog_id'),$ViewPost->getFormField('blog_post_id'));
	   $ViewPost->checkBlogAdded = $ViewPost->chkThisUserAllowedToPost();
	   if ($ViewPost->getFormField('post_keyword')!= $LANG['common_search_text'] AND $ViewPost->getFormField('post_keyword'))
		{
			Redirect2URL(getUrl('viewblog','?blog_name='.$ViewPost->getFormField('blog_name').'&tags='.$ViewPost->getFormField('post_keyword'),$ViewPost->getFormField('blog_name').'/?tags='.$ViewPost->getFormField('post_keyword'),'','blog'));
		}
		if(isMember())
		{
			if($ViewPost->getFormField('msg')=='updated')
			{
				$ViewPost->setCommonSuccessMsg($LANG['photoupload_msg_update_success']);
				$ViewPost->setPageBlockShow('block_msg_form_success');
			}
		}
		$ViewPost->populateCommentOptionsPost();
		//$ViewPost->postList_category_url = getUrl('blogpostlist', '?pg=postnew&cid='.$ViewPost->getFormField('blog_category_id'), 'postnew/?cid='.$ViewPost->getFormField('blog_category_id'), '', 'blog');
		//$ViewPost->postList_subcategory_url = getUrl('blogpostlist', '?pg=postnew&cid='.$ViewPost->getFormField('blog_category_id').'&sid='.$ViewPost->getFormField('blog_sub_category_id'), 'postnew/?cid='.$ViewPost->getFormField('blog_category_id').'&sid='.$ViewPost->getFormField('blog_sub_category_id'), '', 'blog');

		//Post COMMENT//
		$ViewPost->setPageBlockShow('postMainBlock');
		$ViewPost->setPageBlockShow('block_add_comments');



	}
	else
	{
		$ViewPost->setAllPageBlocksHide();
		if($ViewPost->resultFound)
		{
	    	Redirect2URL(getUrl('blogpostlist', '?pg=private_post', 'private_post/', '', 'blog'));
		}
		else
		{
			Redirect2URL(getUrl('blogpostlist', '?pg=invalid_blog_post_id', 'invalid_blog_post_id/', '', 'blog'));
		}

	}
	if ($ViewPost->isShowPageBlock('confirmation_adult_form'))
		{
			$ViewPost->acceptAdultPostUrl		= getUrl('viewpost','?blog_post_id='.$ViewPost->getFormfield('blog_post_id').'&title='.$ViewPost->changeTitle($ViewPost->getFormfield('blog_post_name')).'&action=accept&vpkey='.$ViewPost->getFormfield('vpkey'), $ViewPost->getFormfield('blog_post_id').'/'.$ViewPost->changeTitle($ViewPost->getFormfield('blog_post_name')).'/?action=accept&vpkey='.$ViewPost->getFormfield('vpkey'),  'members', 'blog');
			$ViewPost->acceptThisAdultPostUrl	= getUrl('viewpost','?blog_post_id='.$ViewPost->getFormfield('blog_post_id').'&title='.$ViewPost->changeTitle($ViewPost->getFormfield('blog_post_name')).'&action=view&vpkey='.$ViewPost->getFormfield('vpkey'), $ViewPost->getFormfield('blog_post_id').'/'.$ViewPost->changeTitle($ViewPost->getFormfield('blog_post_name')).'/?action=view&vpkey='.$ViewPost->getFormfield('vpkey'), '', 'blog');
			$ViewPost->rejectAdultPostUrl		= getUrl('viewpost','?blog_post_id='.$ViewPost->getFormfield('blog_post_id').'&title='.$ViewPost->changeTitle($ViewPost->getFormfield('blog_post_name')).'&action=reject&vpkey='.$ViewPost->getFormfield('vpkey'), $ViewPost->getFormfield('blog_post_id').'/'.$ViewPost->changeTitle($ViewPost->getFormfield('blog_post_name')).'/?action=reject&vpkey='.$ViewPost->getFormfield('vpkey'), 'members', 'blog');
			$ViewPost->rejectThisAdultPostUrl	= getUrl('index','','');
		}

}

/*
if(!isAjax())
	{
		if($ViewPost->isShowPageBlock('add_reply'))
			{
				$ViewPost->includeHeader();
				setTemplateFolder('general/', 'blog');
				$ViewPost->display('videoAjax.tpl');
			}
	}
*/

$ViewPost->includeHeader();

if(!isAjax())
	{
		if($ViewPost->isShowPageBlock('add_reply') OR $ViewPost->isShowPageBlock('block_add_comments'))
			{
				$ViewPost->replyCommentId=$ViewPost->getFormField('comment_id');

				$ViewPost->replyUrl=$CFG['site']['blog_url'].'viewPost.php?ajax_page=true&blog_id='.$ViewPost->getFormField('blog_id').'&vpkey='.$ViewPost->getFormField('vpkey').'&show='.$ViewPost->getFormField('show');
				?>
				<script language="javascript" type="text/javascript">
				<?php if($CFG['admin']['blog']['captcha']
							AND $CFG['admin']['blog']['captcha_method'] == 'recaptcha'
								AND $CFG['captcha']['public_key'] AND $CFG['captcha']['private_key'])
						{
				?>
				var captcha_recaptcha = true;
				<?php
						}
				?>
				</script>
				<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['blog_url'];?>js/light_comment.js"></script>
				<script language="javascript" type="text/javascript">
					var no_comment_error_msg = "<?php echo $LANG['common_noComment_errorMsg'];?>";
					var dontUse = 0;
					var replyUrl="<?php echo $ViewPost->replyUrl;?>";
					var reply_comment_id="<?php echo $ViewPost->replyCommentId;?>";;
					var reply_user_id="<?php echo $CFG['user']['user_id'];?>";
					var owner="<?php echo $CFG['user']['user_id'];?>";
				</script>
				<?php
			}

	}
	?>


	<script type="text/javascript" src="<?php echo $CFG['site']['blog_url'];?>js/viewBlog.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['blog_url'];?>js/functions.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['blog_url'];?>js/blogComment.js"></script>
		<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/AG_ajax_html.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/tooltip.js"></script>

	<?php
if($ViewPost->validate)
{
?>

<!--<script type="text/javascript" src="<?php echo $CFG['site']['url'].'js/lib/photo/lightwindow/lightwindow.js';?>"></script>-->
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['blog_url'];?>js/sharePost.js"></script>
<!--<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['blog_url'];?>js/postComment.js"></script>-->
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/tooltip.js"></script>
<script language="javascript" type="text/javascript">
var site_url = '<?php echo $CFG['site']['url'];?>';
var pars= 'pLeft=&pFetch=';
var template_default = '<?php echo $CFG['html']['template']['default']; ?>';
var stylesheet_default = '<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>';
var total_rating_images = '<?php echo $CFG['admin']['total_rating']; ?>';
var rateimage_url = '<?php echo $CFG['site']['url'].'blog/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/icon-blograte.gif';?>';
var rateimagehover_url = '<?php echo $CFG['site']['url'].'blog/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/icon-blogratehover.gif';?>';
var replace_url = '<?php echo getUrl('login', '', '', 'root');?>';
var minimum_counts = <?php echo $CFG['admin']['blog']['total_comments'];?>;
var deleteConfirmation = "<?php echo $LANG['viewpost_comment_delete_confirmation'];?>";
var comment_success_deleted_msg='<?php echo $LANG['viewpost_comment_success_deleted'];?>';
var viewpost_mandatory_fields = "<?php echo $LANG['viewpost_mandatory_fields']; ?>";
var kinda_comment_msg = "<?php echo $LANG['viewpost_comment_approval']; ?>";
var blog_post_id = '<?php echo $ViewPost->getFormField('blog_post_id'); ?>';
var view_post_ajax_page_loading = '<img alt="<?php echo $LANG['common_blog_loading']; ?>" src="<?php echo $CFG['site']['url'].'blog/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/loading-viewblog.gif' ?>" \/>';
var view_post_scroll_loading='<div class="clsLoader">'+view_post_ajax_page_loading+'<\/div>';
var viewpost_valid_login='<?php echo $LANG['viewpost_not_allowed_comments']; ?>';
var load_flag_url = '<?php echo $ViewPost->load_flag_url; ?>';
var favorite_url = '<?php echo $ViewPost->favorite['url'];?>';
var featured_url= '<?php echo $ViewPost->featured['url']; ?>';
var share_url = '<?php echo $ViewPost->share_url; ?>';
var favorite_added = '<?php if($ViewPost->favorite['added']=='') echo '1'; else echo ''; ?>';
var featured_added = '<?php if($ViewPost->featured['added']=='') echo '1'; else echo ''; ?>';

var current_active_tab_class = 'clsActive';
var current_first_active_tab_class = 'clsFirstActive';
var current_last_active_tab_class = 'clsLastActive';
var show_div_first_active = 'selSlidelistContent';
<?php
	echo "var more_tabs_div = new Array('selFlagContent', 'selFavoritesContent', 'selFeaturedContent', 'selSharePostContent');";
	echo "var more_tabs_class = new Array('selHeaderFlag', 'selHeaderFavorites', 'selHeaderFeatured', 'selHeaderSharePost');";
	echo "var show_div_last_active = 'selSharePostContent';";
?>


var showAddPostComment=function(){
$Jq('#cancel_comment').css('display', 'block');
$Jq('#add_comment').css('display', 'none');
$Jq('#comment').val('');
$Jq('#post_comment_add_block').toggle();
if($Jq('#post_comment_add_block').css('display') !='none')
    $Jq('#comment').focus();
}



var showCancelPostComment=function(){
$Jq('#add_comment').css('display', 'block');
$Jq('#cancel_comment').css('display', 'none');
$Jq('#selMsgError').css('display', 'none');
$Jq('#comment').val('');
$Jq('#post_comment_add_block').toggle();
if($Jq('#post_comment_add_block').css('display') !='none')
    $Jq('#comment').focus();
}


var getViewPostMoreContent = function(){
	var content_id = arguments[0];
	var view_post_more_path;
	var call_viewpost_ajax = false;
	view_post_content_id = content_id;
	var div_id = 'sel'+content_id+'Content';
	var more_li_id = 'selHeader'+content_id;
	var div_value = $Jq('#'+div_id).html('');

    if(content_id == 'SharePost')
		{
			view_post_more_path = share_url;
			call_viewpost_ajax = true;
		}
	else if(content_id == 'Flag')
		{
			view_post_more_path = load_flag_url;
			call_viewpost_ajax = true;
		}
	else if(content_id == 'Favorites')
		{
			call_viewpost_ajax = true;
			$Jq('#selFavoritesContent').removeClass('clsUserActionAdded');
			$Jq('#selFavoritesContent').removeClass('clsUserActionDeleted');
			$Jq('#closeViewPostMoreContent').css('display', 'none');
			if(arguments[1] == 'remove')
				{
					var favorite_pars = '&favorite=&blog_post_id='+blog_post_id;
					favorite_added = 1;
				}
			else
				var favorite_pars = '&favorite='+favorite_added+'&blog_post_id='+blog_post_id;

			view_post_more_path = favorite_url+favorite_pars;
		}
	else if(content_id == 'Featured')
		{
			call_viewpost_ajax = true;
			$Jq('#selFeaturedContent').removeClass('clsUserActionAdded');
			$Jq('#selFeaturedContent').removeClass('clsUserActionDeleted');
			if(arguments[1] == 'remove')
				{
					var featured_pars = '&featured=&blog_post_id='+blog_post_id;
					featured_added = 1;
				}
			else
				var featured_pars = '&featured='+featured_added+'&blog_post_id='+blog_post_id;
		     	view_post_more_path = featured_url+featured_pars;
		}

	result_div = div_id;
	if(div_value == '' || call_viewpost_ajax)
		{
			$Jq('#'+div_id).html(view_post_scroll_loading);
			new jquery_ajax(view_post_more_path, '', 'insertViewPostMoreContent');
		}
	else
		{

		}
		$Jq('#closeViewPostMoreContent').hide();

}
function insertViewPostMoreContent(data)
{
	data = data;
	if(data.indexOf('ERR~')>=1)
	{
			if(view_post_content_id == 'Favorites')
			{
				if(favorite_added)
				{
					$Jq('#added_favorite').css('display','block');
				}
				else
				{
					$Jq('#add_favorite').css('display','block');
				}
				msg = '<?php echo $LANG['sidebar_login_favorite_err_msg'] ?>';
			}
		memberBlockLoginConfirmation(msg,'<?php echo $ViewPost->memberLoginBlogUrl ?>');
		return false;
	}
	else
	{
		if(view_post_content_id == 'SharePost')
			{

			}
		else if(view_post_content_id == 'Flag')
			{

			}
		else if(view_post_content_id == 'Favorites')
			{
				$Jq('#add_favorite').toggle();
				$Jq('#added_favorite').toggle();
				$Jq('#'+result_div).html(data);
				if($Jq('#added_favorite').css('display') =='none')
					{
						$Jq('#selFavoritesContent').removeClass('clsUserActionAdded');
						$Jq('#selFavoritesContent').addClass('clsUserActionDeleted');
					}
				else
					{
						$Jq('#selFavoritesContent').removeClass('clsUserActionDeleted');
						$Jq('#selFavoritesContent').addClass('clsUserActionAdded');
					}
				return false;

			}
		else if(view_post_content_id == 'Featured')
			{
				$Jq('#add_featured').toggle();
				$Jq('#added_featured').toggle();
				$Jq('#'+result_div).html(data);
				if($Jq('#added_featured').css('display') =='none')
					{
						$Jq('#selFeaturedContent').removeClass('clsUserActionAdded');
						$Jq('#selFeaturedContent').addClass('clsUserActionDeleted');
					}
				else
					{
						$Jq('#selFeaturedContent').removeClass('clsUserActionDeleted');
						$Jq('#selFeaturedContent').addClass('clsUserActionAdded');
					}
				return false;
			}
		$Jq('#'+result_div).html(data);
		return false;
	}

}
function hideViewPostMoreTabsDivs(current_div)
{
	for(var i=0; i<more_tabs_div.length; i++)
		{
			if(more_tabs_div[i] != current_div)
				{
					//Effect.Fade(more_tabs_div[i], { duration: 3.0 });
					$Jq('#'+more_tabs_div[i]).hide();
					$Jq('#'+more_tabs_class[i]).removeClass(current_active_tab_class);
					$Jq('#'+more_tabs_class[i]).removeClass(current_first_active_tab_class);
					$Jq('#'+more_tabs_class[i]).removeClass(current_last_active_tab_class);
				}
		}
}
function showViewPostMoreTabsDivs(current_div)
{
	for(var i=0; i<more_tabs_div.length; i++)
		{
			if(more_tabs_div[i] == current_div)
				{

					if(document.getElementById(current_div).style.display == 'none')
							$Jq("#"+current_div).slideToggle();
					$Jq('#'+more_tabs_class[i]).addClass(current_active_tab_class);
					if(show_div_first_active == current_div)
						$Jq('#'+more_tabs_class[i]).addClass(current_first_active_tab_class);
					if(show_div_last_active == current_div)
						$Jq('#'+more_tabs_class[i]).addClass(current_last_active_tab_class);
					break;
				}
		}
}
/**
 *
 * @access public
 * @return void
 **/
function hideViewPostMoreContent(){
	for(var i=0; i<more_tabs_div.length; i++)
	{
		$Jq('#'+more_tabs_div[i]).hide();
		$Jq('#'+more_tabs_class[i]).removeClass(current_active_tab_class);
		$Jq('#'+more_tabs_class[i]).removeClass(current_first_active_tab_class);
		$Jq('#'+more_tabs_class[i]).removeClass(current_last_active_tab_class);
	}
$Jq('#closeViewPostMoreContent').hide();
}
</script>
<?php
}
if ($ViewPost->isShowPageBlock('block_add_comments'))
{
	$ViewPost->replyCommentId=$ViewPost->getFormField('comment_id');
	//	$ViewPost->replyUrl=$CFG['site']['blog_url'].'viewPost.php?ajax_page=true&blog_post_id='.$ViewPost->getFormField('blog_post_id').'&vpkey='.$ViewPost->getFormField('vpkey').'&show='.$ViewPost->getFormField('show');
		$ViewPost->replyUrl=$CFG['site']['blog_url'].'viewPost.php?ajax_page=true&blog_id='.$ViewPost->getFormField('blog_id').'&blog_post_id='.$ViewPost->getFormField('blog_post_id').'&vpkey='.$ViewPost->getFormField('vpkey').'&show='.$ViewPost->getFormField('show');
	?>
	<script language="javascript" type="text/javascript">
	<?php if($CFG['admin']['blog']['captcha']
				AND $CFG['admin']['blog']['captcha_method'] == 'recaptcha'
					AND $CFG['captcha']['public_key'] AND $CFG['captcha']['private_key'])
			{
	?>
	var captcha_recaptcha = true;
	<?php
			}
	?>
	</script>
	<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['blog_url'];?>js/light_comment.js"></script>
	<script language="javascript" type="text/javascript">
		var no_comment_error_msg = "<?php echo $LANG['common_noComment_errorMsg'];?>";
		var dontUse = 0;
		var replyUrl="<?php echo $ViewPost->replyUrl;?>";
		var owner="<?php echo $ViewPost->getFormField('user_id');;?>";
		var reply_comment_id="<?php echo $ViewPost->replyCommentId;?>";;
		var reply_user_id="<?php echo $CFG['user']['user_id'];?>";
	</script>
	<?php
}
?>
<script type="text/javascript">
	var form_name_array = new Array('postSearch');
	function clearValue(id)
	{
		$Jq('#'+id).val('');
	}
	function setOldValue(id)
	{
		if (($Jq('#'+id).value=="") && (id == 'post_keyword') )
			$Jq('#'+id).value = '<?php echo $LANG['common_search_text']?>';
	}
</script>
<?php
//include the content of the page
setTemplateFolder('general/', 'blog');
$smartyObj->display('viewPost.tpl');
$ViewPost->includeFooter();
?>