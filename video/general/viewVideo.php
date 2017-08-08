<?php
/**
* >>> mature warning functionalites provided below
*	1. If admin set "Display adult content to members" as "No"
*		>>> adult user can view the content
*		>>> non adult user can not view the content
*		>>> adult user can turn off / turn on the mature warning
*
*	2. If admin set "Display adult content to members" as "Yes"
*		>>> adult user can view the content with confirmation
*		>>> non adult user can view the content
*		>>> adult and non adult user can turn off / turn on the mature warning
*
*	2. If admin set "Display adult content to members" as "Confirmation"
*		>>> adult user can view the content with confirmation
*		>>> non adult user can view the content with confirmation
*		>>> adult and non adult user can turn off / turn on the mature warning
**/
/**
* Added code to increase the player size by checking player size is less than the div's height and width
* -> (height<flash_content_div_height || width<flash_content_div_width)
*  Player size will increase only if
*     $CFG['admin']['videos']['increase_embedplayer_size_viewvideo'] is true
* /
/**
 * ViewVideo
 *
 * @package
 * @author vijay_84ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class ViewVideo extends VideoHandler
	{
		public $enabled_edit_fields = array();
		public $captchaText = '';
		public $publickey;
		public $privatekey;
		public $error = null;
		public $resp = null;
		public $video_response_links = '';

		/**
		 * ViewVideo::deleteComment()
		 * purpose to delete the Comment of the video
		 * @return
		 */
		public function deleteComment()
			{
				$sql = 'SELECT video_id,video_comment_main_id FROM '.$this->CFG['db']['tbl']['video_comments'].' WHERE'.
						' video_comment_id='.$this->dbObj->Param('video_comment_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['video_comments'].
						' WHERE video_comment_id='.$this->dbObj->Param('video_comment_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
				    if (!$rs)
					   trigger_db_error($this->dbObj);

				if($row['video_comment_main_id']==0)
				{
					if($this->dbObj->Affected_Rows())
						{
							$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET total_comments = total_comments-1'.
									' WHERE video_id='.$this->dbObj->Param('video_id');

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($row['video_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
						}
				}

				echo '<div id="selMsgSuccess">'.$this->LANG['success_deleted'].'</div>';
			}

		/**
		 * ViewVideo::getVideoTitle()
		 * purpose to getVideo title with wordwrap
		 * @param mixed $video_id
		 * @return
		 */
		public function getVideoTitle($video_id)
			{
				$sql = 'SELECT video_title FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_id='.$this->dbObj->Param('video_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['video_title'];
				return;
			}


		/**
		 * ViewVideo::insertFavoriteVideoTable()
		 * purpose to insert favorite Video
		 * @return
		 */
		public function insertFavoriteVideoTable()
			{
				if($this->fields_arr['favorite'])
					{
						$condition='video_id='.$this->dbObj->Param('video_id').' AND video_id='.$this->dbObj->Param('user_id');
						$condtionValue=array($this->fields_arr['video_id'],$this->CFG['user']['user_id']);

						if(!$this->selectFavorite($condition,$condtionValue))
							{
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_favorite'].' SET'.
									' user_id='.$this->dbObj->Param('user_id').','.
									' video_id='.$this->dbObj->Param('video_id').','.
									' date_added=NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['video_id']));
								if (!$rs)
									trigger_db_error($this->dbObj);
                                $favorite_id = $this->dbObj->Insert_ID();
								if($favorite_id!='')
									{
										$favorite_id = $this->dbObj->Insert_ID();
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET total_favorites = total_favorites+1'.
												' WHERE video_id='.$this->dbObj->Param('video_id');

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
										if (!$rs)
											trigger_db_error($this->dbObj);

										echo $this->LANG['viewvideo_favorite_added_successfully'];

										//Srart Post video favorite Video activity	..
										$sql = 'SELECT vf.video_favorite_id, vf.video_id, vf.user_id as favorite_user_id, u.user_name, v.video_title, v.user_id, v.video_server_url, v.is_external_embed_video, v.embed_video_image_ext '.
												'FROM '.$this->CFG['db']['tbl']['video_favorite'].' as vf, '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['video'].' as v '.
												' WHERE u.user_id = vf.user_id AND vf.video_id = v.video_id AND vf.video_favorite_id = \''.$this->dbObj->Param('favorite_id').'\'';

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($favorite_id));
										if (!$rs)
											trigger_db_error($this->dbObj);

										$row = $rs->FetchRow();
										$activity_arr = $row;
										$activity_arr['action_key']	= 'video_favorite';
										$videoActivityObj = new VideoActivityHandler();
										$videoActivityObj->addActivity($activity_arr);
										//end
								}
							}
						else
							 echo $this->LANG['favorite_added_already'];
					}
			}

		/**
		 * ViewVideo::getVideoCategoryType()
		 * purpose to get the video category type from the video id
		 * @param mixed $video_id
		 * @return
		 */
		public function getVideoCategoryType($video_id)
			{
				$sql = 'SELECT video_category_id FROM '.$this->CFG['db']['tbl']['video'].' WHERE'.
						' video_id='.$this->dbObj->Param('video_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_id));
				    if (!$rs)
					   trigger_db_error($this->dbObj);

				$type = 'General';
				if($row = $rs->FetchRow())
					{
						$sql = 'SELECT video_category_type FROM '.$this->CFG['db']['tbl']['video_category'].
								' WHERE video_category_id='.$this->dbObj->Param('video_category_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($row['video_category_id']));
						    if (!$rs)
							    trigger_db_error($this->dbObj);

						if($row = $rs->FetchRow())
							{
								$type = $row['video_category_type'];
							}
					}
				return $type;
			}


		/**
		 * ViewVideo::getCaptchaText()
		 * purpose to getcaptcha text
		 * @return
		 */
		public function getCaptchaText()
			{
				$captcha_length = 5;
				$this->captchaText = rand(pow(10, $captcha_length-1), pow(10, $captcha_length)-1);
				return $this->captchaText;
			}



		/**
		 * ViewVideo::populateVideolistDetails()
		 * purpose to populate video list details
		 * @return
		 **/
		public function populateVideolistDetails()
			{
				$sql = 'SELECT rating_total, rating_count FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_id='.$this->dbObj->Param('video_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['rating_total'] = $row['rating_total'];
						$this->fields_arr['rating_count'] = $row['rating_count'];
						return true;
					}
				return false;
			}

		/**
		 * ViewVideo::chkAllowRating()
		 * purpose to check the rating is allowed or not
		 * @return
		 **/

		public function chkAllowRating()
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_id='.$this->dbObj->Param('video_id').
						' AND allow_ratings=\'Yes\' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					return true;
				return false;
			}


		public function getCommentsBlock()
		{
			global $smartyObj;
			$getCommentsBlock_arr = array();


			if($this->CFG['admin']['videos']['captcha'] and $this->CFG['admin']['videos']['captcha_method']=='image')
				{
					$getCommentsBlock_arr['captcha_comment_url'] = $this->CFG['site']['url'].'captchaComment.php?captcha_key=videocomment&amp;captcha_value='.$this->getCaptchaText();
				}

			$smartyObj->assign('getCommentsBlock_arr', $getCommentsBlock_arr);
			setTemplateFolder('general/', 'video');
			$smartyObj->display('getCommentsBlock.tpl');
		}



		/**
		 * ViewVideo::getChannelOfThisVideo()
		 * purpose to get Channael name of the video
		 * @return
		 **/
		public function getChannelOfThisVideo($sub_category = false)
			{
				$category_id = $this->fields_arr['video_category_id'];
				$anchor_id = 'video_category_';
				if($sub_category)
					{
						$category_id = $this->fields_arr['video_sub_category_id'];
						$anchor_id = 'video_sub_category_';

					}
				$sql = 'SELECT video_category_name FROM '.$this->CFG['db']['tbl']['video_category'].
						' WHERE video_category_id='.$this->dbObj->Param('video_category_id').
						' AND video_category_status=\'Yes\' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$url = getUrl('videolist','?pg=videonew&amp;cid='.$this->fields_arr['video_category_id'], 'videonew/?cid='.$this->fields_arr['video_category_id'],'','video');
						if($sub_category)
							$url = getUrl('videolist','?pg=videonew&amp;cid='.$this->fields_arr['video_category_id'].'&amp;sid='.$category_id, 'videonew/?cid='.$this->fields_arr['video_category_id'].'&amp;sid='.$category_id,'','video');
?>
<a id="<?php echo $anchor_id.$category_id; ?>"
<?php
if (isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule())
	echo 'onmouseover="getSubscriptionOption(\''.$category_id.'\', \''.$this->CFG['site']['is_module_page'].'\', \'Category\', \'pos_'.$category_id.'\')"';
?>
 href="<?php echo $url; ?>"><?php echo $row['video_category_name'];?></a>
 <span id="pos_<?php echo $category_id; ?>">&nbsp;</span>
<?php

					}
			}

		/**
		 * ViewVideo::getTagsOfThisVideo()
		 * purpose to get tags of the video
		 * @return
		 **/
		public function getTagsOfThisVideo($tag='')
			{
				$tags_arr = explode(' ',$this->fields_arr['video_tags']);
				foreach($tags_arr as $tags)
					{
						?>
						<span>
						<a id="video_tag_<?php echo $tags; ?>"
						<?php
							if (isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule())
								echo 'onmouseover="getSubscriptionOption(\''.$tags.'\', \''.$this->CFG['site']['is_module_page'].'\', \'Tag\', \'pos_'.$tags.'\')"';
							?>
								href="<?php echo getUrl('videolist','?pg=videonew&amp;tags='.$tags, 'videonew/?tags='.$tags,'','video');?>"><?php echo $tags;?></a>
						<span id="pos_<?php echo $tags; ?>">&nbsp;</span>
						</span>

						<?php
					}
			}


		/**
		 * ViewVideo::getCategoryType()
		 * purpose to get category type from the category Id
		 * @param mixed $category_id
		 * @return
		 */
		public function getCategoryType($category_id)
			{
				$sql = 'SELECT video_category_type FROM '.$this->CFG['db']['tbl']['video_category'].
						' WHERE video_category_id='.$this->dbObj->Param('video_category_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$category_type = 'General';
				if($row = $rs->FetchRow())
					{
						$category_type = $row['video_category_type'];
					}
				return $category_type;
			}

		/**
		 * ViewVideo::getNoOfFavouritedTimes()
		 *
		 * @return
		 */
		public function getNoOfFavouritedTimes()
			{

				$videoId = $this->fields_arr['video_id'];
				$videoId = is_numeric($videoId)?$videoId:0;
				if (!$videoId)
				    {
				    	$this->setCommonErrorMsg($this->LANG['viewvideo_invalid_video_id']);
						return false;
				    }

				$sql = 'SELECT COUNT(*) as favCount FROM '.$this->CFG['db']['tbl']['video_favorite'].
						' WHERE video_id='.$this->dbObj->Param('video_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($videoId));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['favCount'];
				return 0;

			}

		/**
		 * ViewVideo::chkValidVideoId()
		 * purpose to check the video is valid video id
		 * @return
		 **/
		public function chkValidVideoId()
			{
				$videoId = $this->fields_arr['video_id'];
				$videoId = is_numeric($videoId)?$videoId:0;
				if (!$videoId)
				    {
				        return false;
				    }
				$userId = $this->CFG['user']['user_id'];

				$condition = 'p.video_status=\'Ok\' AND p.video_id='.$this->dbObj->Param($videoId).
							' AND (p.user_id = '.$this->dbObj->Param($userId).' OR'.
							' p.video_access_type = \'Public\''.$this->getAdditionalQuery('p.').')';

				$sql = 'SELECT p.total_favorites,p.total_views, p.total_comments, p.video_album_id, p.total_downloads,'.
						' p.video_ext, p.allow_comments,p.video_category_id,p.video_tags,p.allow_embed,p.video_sub_category_id,'.
						' TIME_FORMAT(p.playing_time,\'%H:%i:%s\') as playing_time,p.total_views,'.
						' p.allow_ratings, p.rating_total, p.rating_count, p.user_id, p.flagged_status, p.video_caption,'.
						' p.video_title,p.video_available_formats, DATE_FORMAT(date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
						' p.video_server_url, p.l_width, p.l_height,video_flv_url, flv_upload_type,external_site_video_url,'.
						' p.is_external_embed_video,p.video_external_embed_code,form_upload_type,t_width,t_height,'.
						' s_width,s_height,p.allow_response, p.embed_video_image_ext, (p.rating_total/p.rating_count) as rating, '.
						' p.video_page_title, p.video_meta_keyword, p.video_meta_description FROM '.$this->CFG['db']['tbl']['video'].' as p'.
						' WHERE '.$condition.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($videoId, $userId));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$fields_list = array('user_name', 'first_name', 'last_name');
				if($row = $rs->FetchRow())
					{
						/*if(!isset($this->UserDetails[$row['user_id']]))
							$this->getUserDetails($row['user_id'], $fields_list);*/
						$name = $this->getUserDetail('user_id', $row['user_id'], 'user_name');

						$video_available_formats_arr = explode(',',$row['video_available_formats']);
						$video_available_formats_arr = array_filter($video_available_formats_arr);
						//$name = $this->getUserDetails($row['user_id'], 'user_name');
						$name = $this->getUserDetail('user_id', $row['user_id'], 'user_name');
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['allow_comments'] = $row['allow_comments'];
						$this->fields_arr['allow_ratings'] = $row['allow_ratings'];
						$this->fields_arr['video_available_formats'] = $video_available_formats_arr;
						$this->fields_arr['allow_embed'] = $row['allow_embed'];
						$this->fields_arr['video_ext'] = $row['video_ext'];
						$this->fields_arr['video_server_url'] = $row['video_server_url'];
						$this->fields_arr['l_width'] = $row['l_width'];
						$this->fields_arr['l_height'] = $row['l_height'];
						$this->fields_arr['video_title'] = $row['video_title'];
						$this->fields_arr['video_caption'] = $row['video_caption'];
						$this->fields_arr['date_added'] = $row['date_added'];
						$this->fields_arr['user_name'] = $name;
						$this->fields_arr['rating_total'] = $row['rating_total'];
						//round off total_video_rating
						$this->total_video_rating = round($row['rating']);
						$this->fields_arr['video_flv_url'] = $row['video_flv_url'];
						$this->fields_arr['t_width']=$row['t_width'];
						$this->fields_arr['t_height']=$row['t_height'];
						$this->fields_arr['s_width']=$row['s_width'];
						$this->fields_arr['s_height']=$row['s_height'];
						$this->fields_arr['is_external_embed_video'] = $row['is_external_embed_video'];
						$this->fields_arr['video_external_embed_code'] = stripslashes($row['video_external_embed_code']);
						$this->fields_arr['video_external_embed_code']= str_replace('<embed','<embed wmode="transparent"',$this->getFormField('video_external_embed_code'));
						$this->fields_arr['video_external_embed_code']= str_replace('&lt;embed','&lt;embed wmode=&quot;transparent&quot;',$this->getFormField('video_external_embed_code'));

						$this->fields_arr['external_site_video_url'] = $row['external_site_video_url'];
						$this->fields_arr['rating_count'] = $row['rating_count'];
						$this->fields_arr['flagged_status'] = $row['flagged_status'];
						$this->fields_arr['comments'] = $row['total_comments']?$row['total_comments']:0;
						$this->fields_arr['video_album_id'] = $row['video_album_id'];
						$this->fields_arr['total_downloads'] = $row['total_downloads'];
						$this->fields_arr['cur_vid_play_time'] = $row['playing_time'];
						$this->fields_arr['cur_vid_total_views'] = $row['total_views'];
						$this->fields_arr['favorited'] = $row['total_favorites'];
						$this->fields_arr['total_views'] = $row['total_views'];
						$this->fields_arr['total_comments'] = $row['total_comments'];
						$this->fields_arr['video_category_id'] = $row['video_category_id'];
						$this->fields_arr['video_sub_category_id'] = $row['video_sub_category_id'];
						$this->fields_arr['video_tags'] = $row['video_tags'];
						$this->fields_arr['form_upload_type'] = $row['form_upload_type'];
						$this->fields_arr['video_category_type'] = $this->getCategoryType($row['video_category_id']);
						$this->fields_arr['embed_video_image_ext'] = $this->getCategoryType($row['embed_video_image_ext']);
						$this->fields_arr['video_page_title'] = $row['video_page_title'];
						$this->fields_arr['video_meta_keyword'] = $row['video_meta_keyword'];
						$this->fields_arr['video_meta_description'] = $row['video_meta_description'];

						if($this->fields_arr['blog_post_title'] == '')
							$this->setFormField('blog_post_title', $row['video_title']);
						if($this->fields_arr['blog_post_text'] == '')
							$this->setFormField('blog_post_text', $row['video_caption']);
						$this->setFormField('allow_response', $row['allow_response']);
						if(isset($_SESSION['user']['quick_list_clear']) and $_SESSION['user']['quick_list_clear'])
							mvKLRmRayzz($this->fields_arr['video_id']);
						if($this->CFG['admin']['videos']['allow_history_links'] and isLoggedIn() and isset($_SESSION['user']['quick_history']))
							$_SESSION['user']['quick_history'].=$this->fields_arr['video_id'].',';
						return true;
					}
				return false;
			}

			/**
		 * ViewVideo::insertRating()
		 * purpose to insert the rating of user to table
		 * @return
		 **/
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
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_rating'].' SET'.
										' rate='.$this->dbObj->Param('rate').','.
										' date_added=NOW() '.
										' WHERE video_id='.$this->dbObj->Param('video_id').' AND '.
										' user_id='.$this->dbObj->Param('user_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['rate'], $this->fields_arr['video_id'], $this->CFG['user']['user_id']));
							    if (!$rs)
								   trigger_db_error($this->dbObj);

								if($diff > 0)
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET'.
												' rating_total=rating_total+'.$diff.' '.
												' WHERE video_id='.$this->dbObj->Param('video_id');
									}
								else
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET'.
												' rating_total=rating_total'.$diff.' '.
												' WHERE video_id='.$this->dbObj->Param('video_id');
									}

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								//Find rating for rating video activity..
								$sql = 'SELECT rating_id '.
										'FROM '.$this->CFG['db']['tbl']['video_rating'].' '.
										' WHERE video_id='.$this->dbObj->Param('video_id').' AND '.
										' user_id='.$this->dbObj->Param('user_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id'],  $this->CFG['user']['user_id']));
								if (!$rs)
								    trigger_db_error($this->dbObj);

								$row = $rs->FetchRow();
								$rating_id = $row['rating_id'];
							}
						else
							{
								$sql =  ' INSERT INTO '.$this->CFG['db']['tbl']['video_rating'].
										' (video_id, user_id, rate, date_added ) '.
										' VALUES ( '.
										$this->dbObj->Param('video_id').','.$this->dbObj->Param('user_id').','.$this->dbObj->Param('rate').',NOW()'.
										' ) ';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id'], $this->CFG['user']['user_id'], $this->fields_arr['rate']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								$rating_id = $this->dbObj->Insert_ID();

								$sql =  ' UPDATE '.$this->CFG['db']['tbl']['video'].' SET'.
										' rating_total=rating_total+'.$this->fields_arr['rate'].','.
										' rating_count=rating_count+1'.
										' WHERE video_id='.$this->dbObj->Param('video_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
							}


						//Srart Post video rating Video activity	..
						$sql = 'SELECT vr.rating_id, vr.video_id, vr.user_id as rating_user_id, vr.rate, u.user_name, v.video_title, v.user_id, v.video_server_url, v.is_external_embed_video, v.embed_video_image_ext '.
								'FROM '.$this->CFG['db']['tbl']['video_rating'].' as vr, '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['video'].' as v '.
								' WHERE u.user_id = vr.user_id AND vr.video_id =v.video_id AND vr.rating_id = '.$this->dbObj->Param('rating_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($rating_id));
						if (!$rs)
							trigger_db_error($this->dbObj);

						$row = $rs->FetchRow();
						$activity_arr = $row;
						$activity_arr['action_key']	= 'video_rated';
						$videoActivityObj = new VideoActivityHandler();
						$videoActivityObj->addActivity($activity_arr);
						//end
					}
			}

		/**
		 * ViewVideo::getTotalRatingImage()
		 * purpose to populate rating images based on the rating of the video
		 * @return
		 **/
		public function getTotalRatingImage()
			{
				if($this->populateVideolistDetails())
					{
						$rating = round($this->fields_arr['rating_total']/$this->fields_arr['rating_count'],0);
						$this->populateRatingImagesForAjax($rating);
						$rating_text = ($this->fields_arr['rating_count'] >1 )?$this->LANG['viewvideo_ratings']:$this->LANG['viewvideo_rating'];
						echo '<span>('.$this->fields_arr['rating_count'].' '.$rating_text.')</span>';
					}
			}

		/**
		 * ViewVideo::populateRatingImagesForAjax()
		 * purpose to populate images for rating
		 * @param $rating
		 * @return
		 **/
		public function populateRatingImagesForAjax($rating,$imagePrefix='')
		{
			$rating_total = $this->CFG['admin']['total_rating'];
			for($i=1;$i<=$rating;$i++)
			{
				?>
				<a onClick="return callAjaxRate('<?php echo $this->CFG['site']['video_url'].'viewVideo.php?ajax_page=true&video_id='.$this->fields_arr['video_id'].'&'.'rate='.$i;?>&show=<?php echo $this->fields_arr['show'];?>','selRatingVideo')" onMouseOver="ratingMouseOver(<?php echo $i;?>)" onMouseOut="ratingMouseOut(<?php echo $i;?>)"><img id="img<?php echo $i;?>" src="<?php echo $this->CFG['site']['url'].'video/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-viewvideoratehover.gif'; ?>"  title="<?php echo $i;?>" /></a>
				<?php
			}
			for($i=$rating;$i<$rating_total;$i++)
			{
				?>
				<a onClick="return callAjaxRate('<?php echo $this->CFG['site']['video_url'].'viewVideo.php?ajax_page=true&video_id='.$this->fields_arr['video_id'].'&'.'rate='.($i+1);?>&amp;amp;show=<?php echo $this->fields_arr['show'];?>','selRatingVideo')" onMouseOver="ratingMouseOver(<?php echo ($i+1);?>)" onMouseOut="ratingMouseOut(<?php echo ($i+1);?>)"><img id="img<?php echo ($i+1);?>" src="<?php echo $this->CFG['site']['url'].'video/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-viewvideorate.gif'; ?>"  title="<?php echo ($i+1);?>" /></a>
				<?php
			}
		}



		/**
		 * ViewVideo::chkAlreadyRated()
		 * purpose to check the video is already rated or not
		 * @return
		 **/
		public function chkAlreadyRated()
			{
				$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['video_rating'].
						' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
						' video_id='.$this->dbObj->Param('video_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['video_id']));
				    if (!$rs)
					   trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['rate'];
				return false;
			}

		/**
		 * ViewVideo::populateRatingDetails()
		 * purpose to populate rating details of the particular video
		 * @return
		 **/
		public function populateRatingDetails()
			{
				if($this->fields_arr['rating_count'])
					{
						$rating = 0;
						if($this->fields_arr['rating_count'])
							$rating = round($this->fields_arr['rating_total']/$this->fields_arr['rating_count'],0);
						return $rating;
					}
			}

		/**
		 * PostComment::getRating()
		 * purpose to getRating details of the particular user
		 * param $user_id
		 * @return
		 **/
		public function getRating($user_id)
			{
				$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['video_rating'].
						' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
						' video_id='.$this->dbObj->Param('video_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $this->fields_arr['video_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						return $row['rate'];
					}
				return 0;
			}

		public function populateReply($comment_id)
			{
				$populateReply_arr = array();
				$sql = 'SELECT video_comment_id, video_comment_main_id, comment_user_id,'.
						' comment, TIMEDIFF(NOW(), date_added) as pc_date_added,'.
						' TIME_TO_SEC(TIMEDIFF(NOW(), date_added)) AS date_edit'.
						' FROM '.$this->CFG['db']['tbl']['video_comments'].
						' WHERE video_id='.$this->dbObj->Param('video_id').' AND'.
						' video_comment_main_id='.$this->dbObj->Param('video_comment_main_id').
						' AND comment_status=\'Yes\' '.
						' ORDER BY video_comment_id DESC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id'], $comment_id));
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
								$populateReply_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $user_name);
								$populateReply_arr['row'][$inc]['icon'] = getMemberAvatarDetails($user_name);

								$row['pc_date_added'] = getTimeDiffernceFormat($row['pc_date_added']);
								$row['comment'] = $row['comment'];
								$populateReply_arr['row'][$inc]['record'] = $row;

								$populateReply_arr['row'][$inc]['class'] = 'clsNotEditable';
								if($row['comment_user_id']==$this->CFG['user']['user_id'])
									{
										$time = $this->CFG['admin']['videos']['comment_edit_allowed_time'] - $row['date_edit'];
										if($time>2)
											{
												$populateReply_arr['row'][$inc]['class'] = 'clsEditable';
											}
									}

								$populateReply_arr['row'][$inc]['comment_memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $this->UserDetails[$row['comment_user_id']]['user_name']);
								$populateReply_arr['row'][$inc]['comment_makeClickableLinks'] = nl2br(makeClickableLinks($row['comment']));

								if(isMember() AND $row['comment_user_id'] == $this->CFG['user']['user_id'])
									{
										$populateReply_arr['row'][$inc]['time'] = $this->CFG['admin']['videos']['comment_edit_allowed_time']-$row['date_edit'];
										if($populateReply_arr['row'][$inc]['time'] > 2)
											{
												$this->enabled_edit_fields[$row['video_comment_id']] = $populateReply_arr['row'][$inc]['time'];
											}
									}
								$inc++;
							}
					}
				return $populateReply_arr;
			}

		/**
		 * ViewVideo::getTotalComments()
		 * purpose to get Total Comments og this video
		 * @return
		 */

		public function getTotalComments()
			{
				$sql = 'SELECT total_comments FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_id='.$this->dbObj->Param('video_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $this->fields_arr['total_comments'] = $row['total_comments']?$row['total_comments']:0;
			}

		/**
		 * ViewVideo::processResponsesStartValue()
		 *
		 * @param integer $totalVideoCount
		 * @return
		 */
		public function processResponsesStartValue($totalVideoCount=0)
			{
				$vdebug = true;
				$videoLimit=$this->CFG['admin']['videos']['total_related_video'];
				$videoIncrement=$this->CFG['admin']['videos']['total_related_video'];

				if (!isset($_SESSION['vRespStart']))
			    	$_SESSION['vRespStart'] = 0;

				if ($this->isPageGETed($_POST, 'vRespLeft'))
				    {
						$inc = ($_SESSION['vRespStart'] > 0)?$videoIncrement:0;
						$_SESSION['vRespStart'] -= $inc;
				    }
				if ($this->isPageGETed($_POST, 'vRespRight'))
				    {
						$inc = ($_SESSION['vRespStart'] < $totalVideoCount)?$videoIncrement:0;
						$_SESSION['vRespStart'] += $inc;
				    }
				return $_SESSION['vRespStart'];
			}



		/**
		 * ViewVideo::populateCommentOptionsVideo()
		 * purpose to populate Comment options for the video
		 * purpose to populate Comment options for the video
		 * @return
		 */
		public function populateCommentOptionsVideo()
			{
				$this->CFG['admin']['videos']['total_comments']=$this->fields_arr['show']=='all'?'100000':$this->CFG['admin']['videos']['total_comments'];

				$sql = 'SELECT vc.video_comment_id, vc.comment_user_id,'.
						' vc.comment, TIMEDIFF(NOW(), vc.date_added) as pc_date_added,'.
						' TIME_TO_SEC(TIMEDIFF(NOW(), vc.date_added)) AS date_edit'.
						' FROM '.$this->CFG['db']['tbl']['video_comments'].' AS vc'.
						' WHERE vc.video_id='.$this->dbObj->Param('video_id').' AND'.
						' vc.video_comment_main_id=0 AND'.
						' vc.comment_status=\'Yes\' ORDER BY vc.video_comment_id DESC LIMIT '.$this->CFG['admin']['videos']['total_comments'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$total_comments = $rs->PO_RecordCount();
				$this->fields_arr['total_comments'] = $this->getTotalComments();
				$this->comment_approval = 0;
				if(isMember())
					{
						$this->commentUrl = $this->CFG['site']['video_url'].'viewVideo.php?type=add_comment&video_id='.$this->getFormField('video_id');
					}
				else
					{
						$this->commentUrl =getUrl('viewvideo','?mem_auth=true&video_id='.$this->fields_arr['video_id'].'&title='.$this->changeTitle($this->fields_arr['video_title']), $this->fields_arr['video_id'].'/'.$this->changeTitle($this->fields_arr['video_title']).'/?mem_auth=true', '','video');
					}
				if($this->getFormField('allow_comments')=='Kinda')
					{
						$this->comment_approval = 0;

					}
				else if($this->getFormField('allow_comments')=='Yes')
					{
						$this->comment_approval = 1;
					}
			}

		/**
		 * ViewVideo::populateCommentOfThisVideo()
		 *
		 * @return
		 */
		public function populateCommentOfThisVideo()
			{
				global $smartyObj;
				//Array to store video comments
				$populateCommentOfThisVideo_arr = array();

                $this->setTableNames(array($this->CFG['db']['tbl']['video_comments'].' AS vc', $this->CFG['db']['tbl']['users'].' AS u'));
                $this->setReturnColumns(array('vc.video_comment_id', 'vc.comment_user_id', 'vc.comment', 'TIMEDIFF(NOW(), vc.date_added) as pc_date_added', 'TIME_TO_SEC(TIMEDIFF(NOW(), vc.date_added)) AS date_edit'));
                $this->sql_condition = 'vc.video_id=\''.$this->fields_arr['video_id'].'\' AND vc.video_comment_main_id=0 AND u.user_id=vc.comment_user_id AND u.usr_status=\'Ok\' AND vc.comment_status=\'Yes\'';
                $this->sql_sort = 'vc.video_comment_id DESC';

			    /**
			     * ***** navigtion continue********
			     */
			    $this->buildSelectQuery();
			    $this->buildQuery();
			    $this->executeQuery();
			    /**
			     * ****** Navigation End *******
			     */
				$paging_arr = array();
			    $smartyObj->assign('paging_arr', $paging_arr);

				$populateCommentOfThisVideo_arr['comment_approval'] = 0;
				if($this->getFormField('allow_comments')=='Kinda')
					{
						$populateCommentOfThisVideo_arr['comment_approval'] = 0;
						if(!isMember())
							{
								$populateCommentOfThisVideo_arr['approval_url'] = getUrl('viewvideo', '?video_id='.$this->fields_arr['video_id'].'&amp;title='.$this->changeTitle($this->fields_arr['video_title']), $this->fields_arr['video_id'].'/'.$this->changeTitle($this->fields_arr['video_title']), '', 'video');
							}
					}
				else if($this->getFormField('allow_comments')=='Yes')
					{
						$populateCommentOfThisVideo_arr['comment_approval'] = 1;
						if(!isMember())
							{
								$populateCommentOfThisVideo_arr['post_comment_url'] = getUrl('viewvideo', '?video_id='.$this->fields_arr['video_id'].'&amp;title='.$this->changeTitle($this->fields_arr['video_title']), $this->fields_arr['video_id'].'/'.$this->changeTitle($this->fields_arr['video_title']), '', 'video');
							}
					}

				$populateCommentOfThisVideo_arr['row'] = array();
			    if ($this->isResultsFound())
					{
						$this->fields_arr['ajaxpaging'] = 1;
						$populateCommentOfThisVideo_arr['hidden_arr'] = array('start', 'ajaxpaging');
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

								$populateCommentOfThisVideo_arr['row'][$inc]['name'] = $this->getUserDetail('user_id',$row['comment_user_id'], 'user_name');
								$populateCommentOfThisVideo_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['comment_user_id']);
								$populateCommentOfThisVideo_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $user_name);

								$row['pc_date_added'] = getTimeDiffernceFormat($row['pc_date_added']);

								$populateCommentOfThisVideo_arr['row'][$inc]['class'] = 'clsNotEditable';
								if($row['comment_user_id']==$this->CFG['user']['user_id'])
									{
										$time = $this->CFG['admin']['videos']['comment_edit_allowed_time']-$row['date_edit'];
										if($time>2)
											{
												$populateCommentOfThisVideo_arr['row'][$inc]['class'] = "clsEditable";
											}
									}
								$row['comment'] = $row['comment'];
								$populateCommentOfThisVideo_arr['row'][$inc]['record'] = $row;
								$populateCommentOfThisVideo_arr['row'][$inc]['reply_url']= $this->CFG['site']['url'].'video/viewVideo.php?video_id='.$this->getFormField('video_id').'&vpkey='.$this->getFormField('vpkey').'&show='.$this->getFormField('show').'&comment_id='.$row['video_comment_id'].'&type=comment_reply';
								$populateCommentOfThisVideo_arr['row'][$inc]['delete_comment_url'] = getUrl('viewvideo', '?video_id='.$this->fields_arr['video_id'].'&title='.$this->changeTitle($this->fields_arr['video_title']).'&comment_id='.$row['video_comment_id'].'&ajax_page=true&page=deletecomment', $this->fields_arr['video_id'].'/'.$this->changeTitle($this->fields_arr['video_title']).'/?comment_id='.$row['video_comment_id'].'&ajax_page=true&page=deletecomment', '', 'video');
								$populateCommentOfThisVideo_arr['row'][$inc]['comment_member_profile_url'] = getMemberProfileUrl($row['comment_user_id'], $user_name);

								$populateCommentOfThisVideo_arr['row'][$inc]['makeClickableLinks'] = nl2br(makeClickableLinks($row['comment']));
								if(isMember() and $row['comment_user_id']==$this->CFG['user']['user_id'])
									{
										$populateCommentOfThisVideo_arr['row'][$inc]['time'] = $this->CFG['admin']['videos']['comment_edit_allowed_time']-$row['date_edit'];
										if($populateCommentOfThisVideo_arr['row'][$inc]['time'] > 2)
											{
												$this->enabled_edit_fields[$row['video_comment_id']] = $populateCommentOfThisVideo_arr['row'][$inc]['time'];
											}
									}
								else
									{
										if(!isMember())
											{
												$populateCommentOfThisVideo_arr['row'][$inc]['comment_reply_url'] = getUrl('viewvideo', '?video_id='.$this->fields_arr['video_id'].'&amp;title='.$this->changeTitle($this->fields_arr['video_title']), $this->fields_arr['video_id'].'/'.$this->changeTitle($this->fields_arr['video_title']), '', 'video');
											}
									}
								$populateCommentOfThisVideo_arr['row'][$inc]['populateReply_arr'] = $this->populateReply($row['video_comment_id']);
								$inc++;
							} //while

						if($this->fields_arr['total_comments']>$this->CFG['admin']['videos']['total_comments'])
							{
						  		$populateCommentOfThisVideo_arr['view_all_comments_url'] = getUrl('viewvideo', '?video_id='.$this->fields_arr['video_id'].'&amp;title='.$this->changeTitle($this->fields_arr['video_title']).'&amp;vpkey='.$this->fields_arr['vpkey'].'&amp;show=all', $this->fields_arr['video_id'].'/'.$this->changeTitle($this->fields_arr['video_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&amp;show=all', '', 'video');
								$populateCommentOfThisVideo_arr['view_all_comments'] = sprintf($this->LANG['view_all_comments'],'<span id="total_comments2">'.$this->fields_arr['total_comments'].'</span>');
						  	}
				    }
				$smartyObj->assign('populateCommentOfThisVideo_arr', $populateCommentOfThisVideo_arr);
				setTemplateFolder('general/', 'video');
				$smartyObj->display('populateCommentOfThisVideo.tpl');
			}

		/**
		 * PostComment::insertCommentAndVideoTable()
		 *
		 * @return
		 **/
		public function insertCommentAndVideoTable()
			{
				$sql = 'SELECT allow_comments FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_id='.$this->dbObj->Param('video_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				    if (!$rs)
					   trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$this->fields_arr['allow_comments'] = $row['allow_comments'];
				$comment_status = 'Yes';

				if($row['allow_comments']=='Kinda')
					$comment_status = 'No';

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_comments'].' SET'.
						' video_id='.$this->dbObj->Param('video_id').','.
						' video_comment_main_id='.$this->dbObj->Param('video_comment_main_id').','.
						' comment_user_id='.$this->dbObj->Param('comment_user_id').','.
						' comment='.$this->dbObj->Param('comment').','.
						' comment_status='.$this->dbObj->Param('comment_status').','.
						' date_added=NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id'], $this->fields_arr['comment_id'], $this->CFG['user']['user_id'], $this->fields_arr['f'], $comment_status));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$next_id = $this->dbObj->Insert_ID();
				if($next_id and $comment_status=='Yes' and (!$this->fields_arr['comment_id']))
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET total_comments = total_comments+1'.
								' WHERE video_id='.$this->dbObj->Param('video_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
						    if (!$rs)
							    trigger_db_error($this->dbObj);
					}

				//SEND MAIL TO VIDEO OWNER
				if($this->CFG['user']['user_id'] != $this->fields_arr['user_id'])
					$this->sendMailToUserForVideoComment();

				//Srart Post video comment activity..
				$sql = 'SELECT vc.video_comment_id, vc.video_id, vc.comment_user_id, u.user_name, '.
						'v.video_title, v.user_id, v.video_server_url, v.is_external_embed_video, '.
						' v.embed_video_image_ext FROM '.$this->CFG['db']['tbl']['video_comments'].' as vc, '.
						$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['video'].' as v '.
						' WHERE u.user_id = vc.comment_user_id AND vc.video_id =v.video_id AND '.
						' vc.video_comment_id = '.$this->dbObj->Param('next_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($next_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$activity_arr = $row;
				$activity_arr['action_key']	= 'video_comment';
				$videoActivityObj = new VideoActivityHandler();
				$videoActivityObj->addActivity($activity_arr);

				//end
				global $smartyObj;
				if ($this->fields_arr['comment_id'])
					{
						$cmValue['populateReply_arr'] = $this->populateReply($this->fields_arr['comment_id']);
						$smartyObj->assign('cmValue', $cmValue);
						setTemplateFolder('general/', 'video');
						$smartyObj->display('populateReplyForCommentsOfThisVideo.tpl');
					}
				else
					{
						$this->populateCommentOfThisVideo();
					}
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function populateReplyCommentOfThisVideo()
			{
				global $smartyObj;
				$cmValue['populateReply_arr'] = $this->populateReply($this->fields_arr['maincomment_id']);
				$smartyObj->assign('cmValue', $cmValue);
				setTemplateFolder('general/', 'video');
				$smartyObj->display('populateReplyForCommentsOfThisVideo.tpl');
			}

		/**
		 * ViewVideo::updateCommentAndVideoTable()
		 *
		 * @return
		 **/
		public function updateCommentAndVideoTable()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video_comments'].' SET'.
						' comment='.$this->dbObj->Param('comment').
						' WHERE video_comment_id='.$this->dbObj->Param('video_comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['f'], $this->fields_arr['comment_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$this->setPageBlockShow('update_comment');
			}

		/**
		 * ViewVideo::getComment()
		 *
		 * @return
		 **/
		public function getComment()
			{
				$sql = 'SELECT comment FROM '.$this->CFG['db']['tbl']['video_comments'].' WHERE'.
						' video_comment_id='.$this->dbObj->Param('video_comment_id');

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
		 * ViewVideo::getTotalvideosOfThisUser()
		 *
		 * @return
		 **/
		public function getTotalVideosOfThisUser($with_link=false)
			{
				$sql = 'SELECT total_videos FROM '.$this->CFG['db']['tbl']['users'].' WHERE'.
						' user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['user_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						if($with_link)
							{
								$member_video_list_url = '<a href="'.getUrl('videolist', '?pg=uservideolist&amp;user_id='.$this->fields_arr['user_id'], 'uservideolist/?user_id='.$this->fields_arr['user_id'],'','video').'">'.$row['total_videos'].'</a>';
								return $member_video_list_url;
							}
						return $row['total_videos'];
					}
			}

		/**
		 * ViewVideo::selectFavorite()
		 *
		 * @param mixed $condition
		 * @param mixed $value
		 * @param string $returnType
		 * @return
		 */
		public function selectFavorite($condition,$value,$returnType='')
			{
				$sql = 'SELECT video_favorite_id FROM '.$this->CFG['db']['tbl']['video_favorite'].
							' WHERE '.$condition;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value);
				if (!$rs)
					trigger_db_error($this->dbObj);
				if(!$returnType)
					return $rs->PO_RecordCount();
				else
					return $rs;
			}

		public function getFavorite()
			{
				$favorite['added']='';
				$favorite['id']='';
				if(!isMember())
				{
					$favorite['url']=getUrl('viewvideo', '?video_id='.$this->fields_arr['video_id'].'&amp;title='.$this->changeTitle($this->fields_arr['video_title']), $this->fields_arr['video_id'].'/'.$this->changeTitle($this->fields_arr['video_title']).'/', '', 'video');
					//getUrl('viewvideo','?video_id='.$this->fields_arr['video_id'].'&amp;title='.$this->changeTitle($this->fields_arr['video_title']), $this->fields_arr['video_id'].'/'.$this->changeTitle($this->fields_arr['video_title']), '','video');
				}
				else
				{

					$condition='video_id='.$this->dbObj->Param('video_id').
							' AND user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';
					$condtionValue=array($this->fields_arr['video_id'], $this->CFG['user']['user_id']);
					$favorite['url']=$this->CFG['site']['video_url'].'viewVideo.php?video_id='.$this->fields_arr['video_id'].'&amp;ajax_page=true&amp;page=favorite';
					if($rs=$this->selectFavorite($condition,$condtionValue,'full'))
					{
						if($rs->PO_RecordCount())
						{
							$row = $rs->FetchRow();
							$favorite['added']=true;
							$favorite['id']=$row['video_favorite_id'];
						}
					}

				}
				return $favorite;
			}

		/**
		 * ViewVideo::getExistingRecords()
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
		 * ViewVideo::processStartValue()
		 *
		 * @param mixed $pg
		 * @param integer $totalVideoCount
		 * @return
		 */
		public function processStartValue($pg, $totalVideoCount=0)
			{
				$vdebug = true;
				$videoLimit=$this->CFG['admin']['videos']['total_related_video'];
				$videoIncrement=$this->CFG['admin']['videos']['total_related_video'];

				if($pg=='top')
					{
						if (!isset($_SESSION['vTopStart']))
					    	$_SESSION['vTopStart'] = 0;

						if ($this->isPageGETed($_POST, 'vTopLeft'))
						    {
								$inc = ($_SESSION['vTopStart'] > 0)?$videoIncrement:0;
								$_SESSION['vTopStart'] -= $inc;
						    }
						if ($this->isPageGETed($_POST, 'vTopRight'))
						    {
								$inc = ($_SESSION['vTopStart'] < $totalVideoCount)?$videoIncrement:0;
								$_SESSION['vTopStart'] += $inc;
						    }
						return $_SESSION['vTopStart'];
					}

				if($pg=='user')
					{
						if (!isset($_SESSION['vUserStart']))
					    	$_SESSION['vUserStart'] = 0;

						if ($this->isPageGETed($_POST, 'vUserLeft'))
						    {
								$inc = ($_SESSION['vUserStart'] > 0)?$videoIncrement:0;
								$_SESSION['vUserStart'] -= $inc;
						    }
						if ($this->isPageGETed($_POST, 'vUserRight'))
						    {
								$inc = ($_SESSION['vUserStart'] < $totalVideoCount)?$videoIncrement:0;
								$_SESSION['vUserStart'] += $inc;
						    }
						return $_SESSION['vUserStart'];
					}

				if($pg=='tag')
					{
						if (!isset($_SESSION['vTagStart']))
					    	$_SESSION['vTagStart'] = 0;

						if ($this->isPageGETed($_POST, 'vTagLeft'))
						    {
								$inc = ($_SESSION['vTagStart'] > 0)?$videoIncrement:0;
								$_SESSION['vTagStart'] -= $inc;
						    }
						if ($this->isPageGETed($_POST, 'vTagRight'))
						    {
								$inc = ($_SESSION['vTagStart'] < $totalVideoCount)?$videoIncrement:0;
								//echo $totalVideoCount.'------------'.$inc;
								$_SESSION['vTagStart'] += $inc;
						    }
						return $_SESSION['vTagStart'];
					}

			}

		/**
		 * ViewVideo::getTotalRenderList()
		 *
		 * @return
		 */
		public function getTotalRenderList()
			{
				$sql = 'SELECT count(DISTINCT referer_render) count FROM '.$this->CFG['db']['tbl']['video_render'].' WHERE '.
						' video_id='.$this->dbObj->Param('video_id');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
				$row = $rs->FetchRow();
				echo $row['count'];
			}

		/**
		 * ViewVideo::getVideoServerURL()
		 *
		 * @param mixed $video_id
		 * @return
		 */
		public function getVideoServerURL($video_id)
			{
				$sql = 'SELECT video_server_url FROM '.$this->CFG['db']['tbl']['video'].' WHERE '.
						' video_id='.$this->dbObj->Param('video_id').' ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_id));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				$count=0;
				if($row = $rs->FetchRow())
					return $row['video_server_url'];
			}
		/**
		 * ViewVideo::getLinksHistory()
		 *
		 * @return
		 */
		public function getLinksHistory()
			{

				$sql = 'SELECT count(video_id) count, referer_render FROM '.$this->CFG['db']['tbl']['video_render'].' WHERE '.
						' video_id='.$this->dbObj->Param('video_id').' GROUP BY referer_render  ';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				$count=0;
				while($row = $rs->FetchRow())
					{
						$count++;
?>
					<li>
						<span><?php echo makeClickableLinks($row['referer_render']) ?></span>
					</li>
<?php
					}
				if(!$count)
					{
?>
					<li>
						<span><?php echo $this->LANG['view_video_no_records_found']; ?></span>
					</li>
<?php
					}
			}

		/**
		 * ViewVideo::populateRleatedVideo()
		 *
		 * @param string $pg
		 * @param integer $start
		 * @return
		 */
		public function populateRleatedVideo($pg = 'tag', $start=0)
			{
				global $smartyObj;
				$return = array();
				$default_fields = 'TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, v.video_id, v.user_id, v.video_title, v.video_caption,'.
								  ' TIMEDIFF(NOW(), date_added) as date_added, v.video_server_url, v.total_views,'.
								  ' v.s_width, v.s_height, v.video_ext, v.video_tags,is_external_embed_video,embed_video_image_ext';

				$add_fields = '';
				$order_by = 'v.video_id DESC';
				$allow_quick_links=(isLoggedIn() and $this->CFG['admin']['videos']['allow_quick_links'])?true:false;
				switch($pg)
					{
						case 'top':
							$sql_condition = 'v.video_id!=\''.addslashes($this->fields_arr['video_id']).'\''.
										' AND v.rating_total>0 AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
										' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
										' v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';

							$more_link = getUrl('videolist','?pg=videotoprated', 'videotoprated/');
							break;

						case 'user':
							$sql_condition = 'v.video_id!=\''.addslashes($this->fields_arr['video_id']).'\''.
										' AND v.user_id=\''.$this->fields_arr['user_id'].'\' AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
										' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
										' v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';

							$more_link = getUrl('videolist','?pg=uservideolist&amp;user_id='.$this->fields_arr['user_id'], 'uservideolist/?user_id='.$this->fields_arr['user_id']);
							break;

						case 'tag':
							$video_tags = $this->fields_arr['video_tags'];
							$sql_condition = 'v.video_id!=\''.addslashes($this->fields_arr['video_id']).'\' AND'.
									' v.video_status=\'Ok\''.$this->getAdultQuery('v.').' AND'.
									' '.getSearchRegularExpressionQueryModified($video_tags, 'video_tags', '').
									' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
									' v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';

							$add_fields = '';
							$order_by = 'v.video_id DESC';
							$more_link = getUrl('videolist','?pg=videonew&amp;tags='.$video_tags, 'videonew/?tags='.$video_tags);
							break;
					}


				$sql_exising='SELECT count(1) count FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
						' WHERE '.$sql_condition.' ';
				$existing_total_records=$this->getExistingRecords($sql_exising);
				$process_start=$this->processStartValue($pg, $existing_total_records);

				$sql = 'SELECT '.$default_fields.$add_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
						' WHERE '.$sql_condition.' ORDER BY '.$order_by.
						' LIMIT '.$process_start.', '.$this->CFG['admin']['videos']['total_related_video'];

				//------ Next and Prev Links--------------//
				$leftButtonClass = 'disabledPrevButton';
				$rightButtonClass = 'disabledNextButton';
				$leftButtonExist=false;
				$rightButtonExists=false;
				$this->pg =$pg;
				$nextSetAvailable = ($existing_total_records > ($process_start + $this->CFG['admin']['videos']['total_related_video']));
				if ($nextSetAvailable)
					{
			        	$rightButtonClass = 'enabledNextButton';
						$rightButtonExists=true;
					}
				if ($process_start > 0)
					{
						$leftButtonExist=true;
			        	$leftButtonClass = 'enabledPrevButton';
					}
				//------ Next and Prev Links--------------//

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$this->total_records = $rs->PO_RecordCount();
				$videosPerRow=$this->CFG['admin']['videos']['related_video_per_row'];
				$inc=0;
				$count=0;
				if ($this->total_records)
				    {
						$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
						$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type', 'sex');
						while($row = $rs->FetchRow())
							{
							$return[$inc]['open_tr']=false;
				      		if ($count%$videosPerRow==0)
					    		{
						 			$return[$inc]['open_tr']=true;
					    		}
								if(!isset($this->UserDetails[$row['user_id']]))
									$this->getUserDetail('user_id',$row['user_id'], 'user_name');

								$return[$inc]['record'] = $row;
								$return[$inc]['name'] = $this->getUserDetail('user_id',$row['user_id'], 'user_name');
								$return[$inc]['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';
								if($row['is_external_embed_video']=='Yes')
   	  							{
   	  								if($row['embed_video_image_ext']=='')
   	  								{
	   	  								$return[$inc]['imageSrc']=$this->CFG['site']['url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/external_video.jpg';
   	  								}
   	  								else
   	  								{
										 $return[$inc]['imageSrc']=$row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$row['embed_video_image_ext'];
									}
								}
								else
								{

									$return[$inc]['imageSrc']=$row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
								}

								$return[$inc]['videoLink']=getUrl('viewvideo','?video_id='.$row['video_id'].'&amp;title='.$this->changeTitle($row['video_title']).'&amp;vpkey='.$this->fields_arr['vpkey'], $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/?vpkey='.$this->fields_arr['vpkey'],'','video');

								$return[$inc]['imageDisp']=DISP_IMAGE($this->CFG['admin']['videos']['small_width'], $this->CFG['admin']['videos']['small_height'], $row['s_width'], $row['s_height']);
								$return[$inc]['allow_quick_links']=$allow_quick_links;
								if($allow_quick_links)
								$return[$inc]['quickLinkId']='quick_link_'.$pg.'_'.$row['video_id'];
								$return[$inc]['video_title']=$row['video_title'];

								$count++;
								$return[$inc]['end_tr']='';
								if ($count%$videosPerRow==0)
							    {
									$count = 0;
									$return[$inc]['end_tr']=true;
							    }
							    $inc++;
							}

					}
					$this->leftButtonExist=$leftButtonExist;
					$this->rightButtonExists=$rightButtonExists;
					$this->leftButtonClass=$leftButtonClass;
					$this->rightButtonClass=$rightButtonClass;

				$smartyObj->assign('relatedVideo', $return);
				setTemplateFolder('general/','video');
				$smartyObj->display('relatedVideo.tpl');


			}

		public function isCearQuickListChecked()
			{
				if(isset($_SESSION['user']['quick_list_clear']) and $_SESSION['user']['quick_list_clear']==true)
					return true;
				return false;
			}

		public function getNextPlayListQuickLinks($in_str='', $getfirst_link=false, $show_url=true)
			{
				if(!trim($in_str))
					return false;
				$condition = ' 1 '.
								' AND video_id IN('.$in_str.') AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
								' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')'.
								' AND v.video_id > \''.$this->fields_arr['video_id'].'\' ';

				$sql = 'SELECT MIN(v.video_id) as video_id FROM '.$this->CFG['db']['tbl']['video'].' as v'.
						' WHERE '.$condition.' LIMIT 0,1';


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				if($row = $rs->FetchRow() and $row['video_id'] and !$getfirst_link)
					{
						$video_server_url=$this->getVideoServerURL($row['video_id']);
						$row['video_title'] = $this->getVideoTitle($row['video_id']);
						$link = getUrl('viewvideo','?video_id='.$row['video_id'].'&amp;title='.$this->changeTitle($row['video_title']).'&amp;vpkey='.$this->fields_arr['vpkey'].'&amp;album_id='.$this->fields_arr['album_id'].'&amp;play_list=ql',
						$row['video_id'].'/'.$this->changeTitle($row['video_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&amp;album_id='.$this->fields_arr['album_id'].'&amp;play_list=ql','','video');
						$this->play_list_next_url=$link;
						if($show_url)
							{
?>
						<a href="<?php echo $link;?>" title="<?php echo $this->LANG['view_video_play_next_list']; ?>">
						<?php echo  $this->LANG['view_video_play_next_list']; ?>
						</a>
<?php
							}
						return;
					}
				else
					{
						$condition = ' 1 '.
								' AND video_id IN('.$in_str.') AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
								' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')'.
								' ';

						$sql2 = 'SELECT v.video_id as video_id FROM '.$this->CFG['db']['tbl']['video'].' as v'.
								' WHERE '.$condition.' LIMIT 0,1';
						//echo $sql2;
						$stmt = $this->dbObj->Prepare($sql2);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							   trigger_db_error($this->dbObj);

						if($row = $rs->FetchRow() and $row['video_id'])
							{
								$row['video_title'] = $this->getVideoTitle($row['video_id']);
								$link = getUrl('viewvideo','?video_id='.$row['video_id'].'&amp;title='.$this->changeTitle($row['video_title']).'&amp;vpkey='.$this->fields_arr['vpkey'].'&amp;album_id='.$this->fields_arr['album_id'].'&amp;play_list=ql',
								$row['video_id'].'/'.$this->changeTitle($row['video_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&amp;album_id='.$this->fields_arr['album_id'].'&amp;play_list=ql','','video');
								$this->play_list_next_url=$link;
						if($show_url)
							{
?>
								<a href="<?php echo $link;?>" title="<?php echo $this->LANG['view_video_play_next_list']; ?>"><?php echo ($getfirst_link)?$this->LANG['view_video_play_this_list']:$this->LANG['view_video_play_next_list']; ?></a>
<?php
							}
								return;
							}
?>
						<span><?php echo  $this->LANG['view_video_play_no_list']; ?></span>
<?php
					}
			}

		public function populateQuickLinkVideos($limit=true, $video_id='')
			{

				$start=0;
				global $smartyObj;
				$quickLink=array();
				$quickLink['video_id']=$video_id;
				$quickLink['display']='';
				$total_records=0;
				if(isset($_SESSION['user']['quick_links']) and trim($_SESSION['user']['quick_links'])
						and $avail_quick_link_video_arr=explode(',',$_SESSION['user']['quick_links'])
						and is_array($avail_quick_link_video_arr) and count($avail_quick_link_video_arr)> 1)
					{
						$in_str = substr($_SESSION['user']['quick_links'], 0, strrpos($_SESSION['user']['quick_links'], ','));

						$quickLink['in_str']=$in_str;

						$default_fields = 'TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, v.video_id, v.user_id, v.video_title, v.video_caption,'.
										  ' TIMEDIFF(NOW(), date_added) as date_added, v.video_server_url, v.total_views,'.
										  ' v.s_width, v.s_height, v.video_ext, v.video_tags';

						$add_fields = '';
						$order_by = 'v.video_id ';
						$allow_quick_links=isLoggedIn() and $this->CFG['admin']['videos']['allow_quick_links'];
						$sql_condition = ' 1 '.
										' AND video_id IN('.$in_str.') AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
										' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
										' v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';
						$this->video_id=$video_id;
						if($video_id)
							$sql_condition.=' AND v.video_id=\''.$video_id.'\'';

						$more_link = getUrl('videolist','?pg=videotoprated', 'videotoprated/','','video');

						$sql_exising='SELECT count(1) count FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
								' WHERE '.$sql_condition.' ';

						$existing_total_records=$this->getExistingRecords($sql_exising);

						$sql = 'SELECT '.$default_fields.$add_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v'.
								' WHERE '.$sql_condition.' ORDER BY '.$order_by;
						if($limit)
							$sql.=' LIMIT '.$start.', '.$this->CFG['admin']['videos']['total_related_video'];



						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						    if (!$rs)
							    trigger_db_error($this->dbObj);

						$total_records = $rs->PO_RecordCount();


						if ($total_records)
						    {
								$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
									if(!$video_id)
									{
										$this->dashboardUrl=getUrl('mydashboard','?block=ql','?block=ql','','video');
										$this->managePlaylistUrl=getUrl('videoplaylistmanage','?use=ql','?use=ql','','video');
										$this->quickListChecked=$this->isCearQuickListChecked()?'checked':'';

									}
									$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type', 'sex');
									$video_count=0;
									$userid_arr = array();
									$inc=0;
									while($row = $rs->FetchRow())
									{
										if(!in_array($row['user_id'],$userid_arr))
										{
											$userid_arr[]=$row['user_id'];

										}
										$quickLink['display'][$inc]['record']=$row;
										$quickLink['display'][$inc]['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';
										$quickLink['display'][$inc]['video_id']	= $row['video_id'];
										$quickLink['display'][$inc]['className']	= ($this->fields_arr['video_id']==$row['video_id'])?'clsActiveQuickList':'';
										$quickLink['display'][$inc]['playlistUrl']=getUrl('viewvideo','?video_id='.$row['video_id'].'&amp;title='.$this->changeTitle($row['video_title']).'&amp;vpkey='.$this->fields_arr['vpkey'].'&amp;play_list=ql', $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&amp;play_list=ql','','video');

										$quickLink['display'][$inc]['imageSrc']=$row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
										$quickLink['display'][$inc]['video_title']=$row['video_title'];
										$quickLink['display'][$inc]['disp_image']=DISP_IMAGE($this->CFG['admin']['videos']['small_width'], $this->CFG['admin']['videos']['small_height'], $row['s_width'], $row['s_height']);
										$inc++;
									}
									$userids=implode(',',$userid_arr);
									$this->getMultiUserDetails($userids, $fields_list);


							}
							$this->showRoundedCorner=false;
							if(!isset($_SESSION['quicklinks_top_display']) or $this->getFormField('show_complete_quick_list') == 1)
							{
								$this->showRoundedCorner=true;
								$_SESSION['quicklinks_top_display']=true;
							}
							$this->sellAllVideo=false;
							if($total_records>=$this->CFG['admin']['videos']['total_related_video'] and !$video_id and $limit)
							{
								$this->sellAllVideo=true;
							}

					}
					if ($total_records)
					{
						$smartyObj->assign('quickLink_arr',$quickLink);
						setTemplateFolder('members/','video');
						$smartyObj->display('quickLinks.tpl');
					}

			}

		public function isValidPlayList()
			{
				$condition = ' playlist_id='.$this->dbObj->Param('playlist_id').' AND'.
							' (p.user_id = '.$this->dbObj->Param('user_id').' OR'.
							' p.playlist_access_type = \'Public\''.$this->getAdditionalQuery('p.').') AND u.user_id=p.user_id ';

				$sql = 'SELECT p.playlist_name, u.user_name, p.playlist_id,   p.user_id, p.playlist_description, p.playlist_tags, p.total_videos, p.thumb_video_id  FROM '.$this->CFG['db']['tbl']['video_playlist'].' as p'.', '.$this->CFG['db']['tbl']['users'].' u '.
						' WHERE '.$condition.' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['playlist_id'], $this->CFG['user']['user_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						if($row['user_id']==$this->CFG['user']['user_id'])
							$this->IS_EDIT=true;
						$this->play_list_details_arr=$row;
						return true;
					}
				return false;

			}

		public function generateNextPlayListURL($getfirst_link=false)
			{
				$condition = ' 1 '.
								' AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
								' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')'.
								' AND c.order_id > \''.$this->fields_arr['order'].'\' AND c.video_id=v.video_id AND c.playlist_id=\''.$this->fields_arr['playlist_id'].'\' ';

				 $sql = 'SELECT MIN(c.video_id) as video_id, c.order_id FROM '.$this->CFG['db']['tbl']['video'].' as v, '.$this->CFG['db']['tbl']['video_in_playlist'].' as c '.
						' WHERE '.$condition.' GROUP BY c.playlist_id ORDER BY c.order_id ASC LIMIT 0,1 ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				if($row = $rs->FetchRow() and $row['video_id'] and !$getfirst_link)
					{
						$row['video_title'] = $this->getVideoTitle($row['video_id']);
						$link = getUrl('viewvideo','?video_id='.$row['video_id'].'&amp;title='.$this->changeTitle($row['video_title']).'&amp;vpkey='.$this->fields_arr['vpkey'].'&amp;album_id='.$this->fields_arr['album_id'].'&amp;play_list=pl&amp;playlist_id='.$this->fields_arr['playlist_id'].'&amp;order='.$row['order_id'],
						$row['video_id'].'/'.$this->changeTitle($row['video_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&amp;album_id='.$this->fields_arr['album_id'].'&amp;play_list=pl&amp;playlist_id='.$this->fields_arr['playlist_id'].'&amp;order='.$row['order_id'], '', 'video');
						$this->play_list_next_url=$link;
						return true;
					}
				else
					{
						$condition = ' 1 '.
								' AND v.video_status=\'Ok\''.$this->getAdultQuery('v.').
								' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' v.video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')'.
								' AND c.order_id = \''.$this->fields_arr['order'].'\' AND 1 AND c.video_id=v.video_id AND c.playlist_id=\''.$this->fields_arr['playlist_id'].'\' ';

						$sql = 'SELECT c.video_id FROM '.$this->CFG['db']['tbl']['video'].' as v, '.$this->CFG['db']['tbl']['video_in_playlist'].' as c '.
							' WHERE '.$condition.' LIMIT 0,1';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

						if($row = $rs->FetchRow() and $row['video_id'])
							{
								$row['video_title'] = $this->getVideoTitle($row['video_id']);
								$link = getUrl('viewvideo','?video_id='.$row['video_id'].'&amp;title='.$this->changeTitle($row['video_title']).'&amp;vpkey='.$this->fields_arr['vpkey'].'&amp;album_id='.$this->fields_arr['album_id'].'&amp;play_list=ql&amp;playlist_id='.$this->fields_arr['playlist_id'].'&amp;amp;order='.$this->fields_arr['order'],
								$row['video_id'].'/'.$this->changeTitle($row['video_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&amp;album_id='.$this->fields_arr['album_id'].'&amp;play_list=ql&amp;playlist_id='.$this->fields_arr['playlist_id'].'&amp;amp;order='.$this->fields_arr['order'], '', 'video');
								$this->play_list_next_url=$link;
								return true;
							}
					}
				return false;
			}

		/**
		 * ViewVideo::displayVideo()
		 *
		 * @return
		 **/
		public function displayVideo()
			{

				$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/';
				$this->populateFlashPlayerConfiguration();

				if($this->fields_arr['play_list'] and ($this->fields_arr['play_list']=='pl' OR $this->fields_arr['play_list']=='ql'))
				{

						if($this->fields_arr['play_list']=='ql' && isset($_SESSION['user']['quick_links']))
							{

								$in_str = substr($_SESSION['user']['quick_links'], 0, strrpos($_SESSION['user']['quick_links'], ','));
								$this->getNextPlayListQuickLinks($in_str, $show_first_url=false, $shw_url=false);

								$_SESSION['video']['next_url']=$this->play_list_next_url;
								$_SESSION['video']['play_list']='ql';
								$sizeOfQuickLink=explode(",",$_SESSION['user']['quick_links']);
								$sizeOfQuickLink=array_filter($sizeOfQuickLink);

								$quickVideoId=explode(',',$_SESSION['user']['quick_links']);

								if(($quickVideoId[0]*1)==$this->fields_arr['video_id'])
								{
									$_SESSION['video']['next_url']='';
									$_SESSION['video']['play_list']='';
									$this->arguments_play.='&autoplay=true';

								}
								else
								{
									$this->arguments_play .= '&amp;play_list=ql';
								}


							}
							elseif(($this->isValidPlayList() and $this->generateNextPlayListURL($show_first_url=false)))
								{
									$this->arguments_play .= '&amp;play_list=pl&amp;order='.$this->fields_arr['order'].'&amp;playlist_id='.$this->fields_arr['playlist_id'];
									$_SESSION['video']['next_url']=$this->play_list_next_url;
									$_SESSION['video']['play_list']='pl';
									$_SESSION['video']['playlist_id']=$this->fields_arr['playlist_id'];
								}
				}

				$this->arguments_embed = 'pg=video_'.$this->fields_arr['video_id'].'_no_0_extsite';
				$user_name=$this->getUserDetail('user_id',$this->fields_arr['user_id'], 'user_name');
				$this->addedUserName=$user_name;
				$this->videoCaption=$this->fields_arr['video_caption'];
				$this->loginUrl=getUrl('login','','');
				$this->isMember=isMember();
				$this->rankUsersRayzz=false;
				$this->rating='';
				if(rankUsersRayzz($this->CFG['admin']['videos']['allow_self_ratings'], $this->fields_arr['user_id']))
				{
					$this->rankUsersRayzz=true;
					$this->rating = $this->getRating($this->CFG['user']['user_id']);
				}

				$this->ratingDetatils=($rating=$this->populateRatingDetails())?$rating:0;
				if(isMember())
				{
						$this->shareUrl=$this->CFG['site']['video_url'].'shareVideo.php?video_id='.$this->fields_arr['video_id'].'&amp;ajaxpage=true&amp;page=sharevideo';
				}
				else
				{
					$this->shareUrl=$this->CFG['site']['video_url'].'shareVideo.php?video_id='.$this->fields_arr['video_id'].'&amp;ajaxpage=true&amp;page=sharevideo';

				}
				$this->blogPostViewVideoUrl=getUrl('viewvideo','?video_id='.$this->fields_arr['video_id'].'&amp;title='.$this->changeTitle($this->fields_arr['video_title']), $this->fields_arr['video_id'].'/'.$this->changeTitle($this->fields_arr['video_title']).'/','root','video');

				$this->callAjaxFlagGroupsUrl=$this->CFG['site']['video_url'].'viewVideo.php?ajax_page=true&amp;page=flag&amp;video_id='.$this->fields_arr['video_id'].'&amp;show='.$this->fields_arr['show'];
				$this->favorite=$this->getFavorite();

			}

		/**
		 * ViewVideo::chkAuthorizedUser()
		 *
		 * @return
		 **/
		public function chkAuthorizedUser()
			{
				if(!$this->fields_arr['comment_id'])
					return false;

				$sql = 'SELECT count(1) as count FROM '.$this->CFG['db']['tbl']['video_comments'].
						' WHERE video_comment_id='.$this->dbObj->Param('video_comment_id').
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
		 * ViewVideo::changeLastViewDateAndVideoViewed()
		 *
		 * @return
		 **/
		public function changeLastViewDateAndVideoViewed()
			{

				$sql = 	' SELECT video_viewed_id FROM '.$this->CFG['db']['tbl']['video_viewed'].
						' WHERE video_id='.$this->dbObj->Param('video_id').' AND user_id='.$this->dbObj->Param('user_id').' AND'.
						' DATE_FORMAT(view_date, \'%Y-%m-%d\') = CURDATE()';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id'], $this->CFG['user']['user_id']));

			    if (!$rs)
				    trigger_db_error($this->dbObj);
				if($rs->PO_RecordCount())
				{

					//$total_views_update .= ', total_views = total_views + 1 ';
						$row = $rs->FetchRow();//$rs->Free();
						$video_viewed_id = $row['video_viewed_id'];
						$sql =  ' UPDATE '.$this->CFG['db']['tbl']['video_viewed'].' SET'.
	 							' view_date=NOW() ,'.
	 							' total_views=total_views+1'.
								' WHERE video_viewed_id='.$this->dbObj->Param('video_viewed_id');

	 					$stmt = $this->dbObj->Prepare($sql);
	 					$rs = $this->dbObj->Execute($stmt, array($video_viewed_id));
 					    if (!$rs)
 						    trigger_db_error($this->dbObj);

 				}
 				else
 				{
				 		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_viewed'].' SET'.
			 					' user_id='.$this->dbObj->Param('user_id').','.
								' video_id='.$this->dbObj->Param('video_id').','.
								' total_views=1 ,'.
			 					' view_date=NOW()';
	 					$stmt = $this->dbObj->Prepare($sql);
	 					$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['video_id']));
 					    if (!$rs)
					    trigger_db_error($this->dbObj);


				 }

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET'.
						' total_views=total_views+1, last_view_date=NOW()'.
						' WHERE video_id='.$this->dbObj->Param('video_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);



			}

		/**
		 * GetCode::populateVideoDetails()
		 *
		 * @return
		 **/
		public function populateVideoDetails()
			{
				$sql = 'SELECT video_ext, video_title, video_server_url, t_width, t_height'.
						' FROM '.$this->CFG['db']['tbl']['video'].
						' WHERE video_id='.$this->dbObj->Param('video_id').' AND'.
						' video_status=\'Ok\' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['video_ext'] = $row['video_ext'];
						$this->fields_arr['video_title'] = $row['video_title'];
						$this->fields_arr['video_server_url'] = $row['video_server_url'];
						$this->fields_arr['t_width'] = $row['t_width'];
						$this->fields_arr['t_height'] = $row['t_height'];
						return true;
					}
				return false;
			}

		public function postVideoResponse($video_resp_id='')
			{
				$sql = 'SELECT count(1) as count FROM '.$this->CFG['db']['tbl']['video_responses'].
						' WHERE video_responses_video_id=\''.$video_resp_id.'\' '.
						' AND video_id=\''.$this->fields_arr['video_id'].'\' ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				if($row['count'])
					return false;
				$video_responses_status = 'Yes';
				$this->video_response_successfully_added = $this->LANG['video_response_successfully_added'];
				if($this->fields_arr['allow_response'] == 'Kinda' and $this->CFG['user']['user_id'] != $this->fields_arr['user_id'])
				{
					$video_responses_status = 'No';
					$this->video_response_successfully_added = $this->LANG['video_response_kinda_successfully_added'];
				}

				$sql = ' INSERT INTO  '.$this->CFG['db']['tbl']['video_responses'].' SET  '.
						' video_responses_video_id=\''.$video_resp_id.'\',  '.
						' video_id=\''.$this->fields_arr['video_id'].'\', '.
						' video_responses_status=\''.$video_responses_status.'\', '.
						' responder_id=\''.$this->CFG['user']['user_id'].'\', '.
						' date_added=now() ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$responses = $this->dbObj->Insert_ID();

		 		$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].
		 				' SET total_responded = total_responded + 1 '.
		 				' WHERE video_id = '.$this->dbObj->Param('videoid');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
				if (!$rs)
				   trigger_db_error($this->dbObj);


				//Srart Post video Response Video activity	..
				$sql = 'SELECT vr.video_responses_id, vr.video_id, vr.video_responses_video_id, '.
						' v.user_id, u.user_name, v.video_title, v.video_server_url, v.is_external_embed_video, v.embed_video_image_ext '.
			 			' FROM '.$this->CFG['db']['tbl']['video_responses'].' as vr, '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['video'].' as v'.
						' WHERE u.user_id = v.user_id AND v.video_id = vr.video_responses_video_id AND vr.video_responses_id = \''.$this->dbObj->Param('responses').'\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($responses));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$activity_arr = $row;
				$activity_arr['action_key']	= 'video_responded';
				$activity_arr['responses_user_id'] = $this->CFG['user']['user_id'];
				$activity_arr['responses_name'] = $this->CFG['user']['user_name'];
				$activity_arr['old_video_id'] = $this->fields_arr['video_id'];
				$activity_arr['old_video_title'] = $this->fields_arr['video_title'];
				/*echo '<pre>';
				print_r($activity_arr);
				echo '</pre>';
				die();*/
				//SEND MAIL TO VIDEO OWNER FOR RESPONSE
				if($this->CFG['user']['user_id'] != $this->fields_arr['user_id'])
					$this->sendMailToUserForVideoResponse($activity_arr);
				$videoActivityObj = new VideoActivityHandler();
				$videoActivityObj->addActivity($activity_arr);
				//end
				return true;
			}

		public function chkVideoResponse()
			{

				$default_fields = 'TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, v.video_id, v.user_id, v.video_title, v.video_caption,'.
								  ' TIMEDIFF(NOW(), v.date_added) as date_added, v.video_server_url, v.total_views,'.
								  ' v.s_width, v.s_height, v.video_ext, v.video_tags';
				$add_fields = '';
				$return = array();
				$order_by = ' ORDER BY vr.video_responses_id DESC';
				$sql_condition = ' vr.video_responses_video_id=\''.addslashes($this->fields_arr['video_id']).'\''.
							' AND vr.video_id != vr.video_responses_video_id '.
							' AND v.video_status=\'Ok\' '.$this->getAdultQuery('v.').
							' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
							' v.video_access_type = \'Public\') AND vr.video_id=v.video_id AND vr.video_responses_status = \'Yes\' ';

				$sql = 'SELECT '.$default_fields.$add_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v, '.$this->CFG['db']['tbl']['video_responses'].' vr  '.
						' WHERE '.$sql_condition.$order_by;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				$is_response_video = false;
				$response_videos_str = '';
				while($row = $rs->FetchRow())
					{
						$is_response_video = true;
						$return['videoLink']=getUrl('viewvideo','?video_id='.$row['video_id'].'&amp;title='.$this->changeTitle($row['video_title']), $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/','','video');
					    $return['video_title']=$row['video_title'];
						$response_videos_str .= '<a href="'.$return['videoLink'].'" alt="'.$return['video_title'].'">'.$return['video_title'].'</a>,';
					}
				if($is_response_video)
				{
					return substr($response_videos_str, 0, strrpos($response_videos_str, ','));
				}
				else
					return false;

			}

		public function replaceAdultText($text)
			{
				$text = str_replace('{age_limit}', $this->CFG['admin']['videos']['adult_minimum_age'], $text);
				$text = str_replace('{site_name}', $this->CFG['site']['name'], $text);
				return nl2br($text);
			}

		public function populatePlaylist()
		{
			global $smartyObj;
			$playlist = array();
			if(isMember())
			{
				$playlist['playlistUrl']=$this->CFG['site']['video_url'].'viewVideo.php?ajax_page=true&amp;page=playlist';
			}

			$condition='user_id='.$this->dbObj->Param('user_id');
			$condition='user_id='.$this->dbObj->Param('user_id');
			$playlist['record']=0;
			if($rs=$this->selectPlaylist($condition,array($this->CFG['user']['user_id']),'full'))
			{
				$inc=0;
				$playlist['record']=$rs->PO_RecordCount();
				while($row = $rs->FetchRow())
				{
					$playlist['item'][$inc]=$row;
					$inc++;
				}
			}
			$playlist['is_external_embededcode']=false;
			if ($this->checkIsExternalEmebedCode())
			{

				$playlist['is_external_embededcode']=true;
			}

			$smartyObj->assign('playlist', $playlist);
			setTemplateFolder('general/','video');
			$smartyObj->display('playList.tpl');
		}



		public function populateFlagContent()
			{
				global $smartyObj;
				$flagContent['url']		= $this->CFG['site']['video_url'].'viewVideo.php?ajax_page=true&amp;page=flag&amp;video_id='.$this->getFormField('video_id').'&amp;show='.$this->fields_arr['show'];
				$smartyObj->assign('flagContent',$flagContent);
				setTemplateFolder('general/','video');
				$smartyObj->display('videoFlag.tpl');
			}

		/**
		 * ViewVideo::insertFlagVideoTable()
		 * purpose to insert flag content to the table
		 * @return
		 */
		public function insertFlagVideoTable()
			{
				echo $this->LANG['viewvideo_your_request'];
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
						' content_type=\'Video\' AND'.
						' content_id='.$this->dbObj->Param('content_id').' AND'.
						' reporter_id='.$this->dbObj->Param('reporter_id').' AND'.
						' status=\'Ok\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id'], $this->CFG['user']['user_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if(!$rs->PO_RecordCount())
					{
						if($this->fields_arr['flag'])
							{
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['flagged_contents'].' SET'.
										' content_id='.$this->dbObj->Param('content_id').','.
										' content_type=\'Video\', flag='.$this->dbObj->Param('flag').','.
										' flag_comment='.$this->dbObj->Param('flag_comment').','.
										' reporter_id='.$this->dbObj->Param('reporter_id').','.
										' date_added=NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id'], $this->fields_arr['flag'], $this->fields_arr['flag_comment'], $this->CFG['user']['user_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
							}
						else if($this->fields_arr['flag_comment'])
							{
								$this->fields_arr['flag'] = 'Others';
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['flagged_contents'].' SET'.
										' content_id='.$this->dbObj->Param('content_id').','.
										' content_type=\'Video\', flag=\'Others\','.
										' flag_comment='.$this->dbObj->Param('flag_comment').','.
										' reporter_id='.$this->dbObj->Param('reporter_id').','.
										' date_added=NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id'], $this->fields_arr['flag_comment'], $this->CFG['user']['user_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
							}

						//Inform flagged video to admin through mail\\
							//Subject..
							$flagged_subject = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $this->LANG['video_flagged_subject']);
							$flagged_subject = str_replace('VAR_VIDEO_TITLE', $this->fields_arr['video_title'], $flagged_subject);
							//Content..
							$sql ='SELECT video_server_url, video_title, video_caption, video_id '.
									' FROM '.$this->CFG['db']['tbl']['video'].
									' WHERE video_id='.$this->dbObj->Param('video_id').' LIMIT 0,1';

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
							if (!$rs)
								trigger_db_error($this->dbObj);

							$row = $rs->FetchRow();
							//video title
							$flagged_message = str_replace('VAR_VIDEO_TITLE', $row['video_title'], $this->LANG['video_flagged_content']);
							//video image
							$videos_folder =$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
							$videolink = getUrl('viewvideo','?video_id='.$this->fields_arr['video_id'].'&amp;title='.$this->changeTitle($row['video_title']), $this->fields_arr['video_id'].'/'.$this->changeTitle($row['video_title']).'/', 'root','video');
							$video_image = '<a href="'.$videolink.'">'.'<img border="0" src="'.$row['video_server_url'].$videos_folder.getVideoImageName($this->fields_arr['video_id']).$this->CFG['admin']['videos']['thumb_name'].'.'.$this->CFG['video']['image']['extensions'].'" alt="'.$row['video_title'].'" title="'.$row['video_title'].'" />'.'</a>';
							$flagged_message = str_replace('{video_image}', $video_image, $flagged_message);
							//video description
							$video_description = strip_tags($row['video_caption']);
							$flagged_message = str_replace('{video_description}', $video_description, $flagged_message);
							//flagged title, flagged content
							$admin_link = $this->CFG['site']['url'].'admin/video/manageFlaggedVideo.php';
							$flagged_title = '<a href="'.$admin_link.'">'.$this->fields_arr['flag'].'</a>';
							$flagged_message = str_replace('VAR_FLAGGED_TITLE', $flagged_title, $flagged_message);
							$flagged_message = str_replace('VAR_FLAGGED_CONTENT', $this->fields_arr['flag_comment'], $flagged_message);
							//User name
							$flagged_message = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $flagged_message);
							//site name
							$flagged_message = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $flagged_message);
							$is_ok = $this->_sendMail($this->CFG['site']['webmaster_email'], $flagged_subject, $flagged_message, $this->CFG['site']['noreply_name'], $this->CFG['site']['noreply_email']);
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

		public function insertFeaturedVideoTable()
			{
					if($this->fields_arr['featured'])
						{
							$this->deleteFromFeatured(false);
							$condition='video_id='.$this->dbObj->Param('video_id').' AND user_id='.$this->dbObj->Param('user_id');
							$condtionValue=array($this->fields_arr['video_id'],$this->CFG['user']['user_id']);
							if(!$this->selectFeatured($condition,$condtionValue))
								{
									$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['video_featured'].' SET'.
										' user_id='.$this->dbObj->Param('user_id').','.
										' video_id='.$this->dbObj->Param('video_id').','.
										' date_added=NOW()';

									$stmt = $this->dbObj->Prepare($sql);
									$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['video_id']));
									if (!$rs)
										trigger_db_error($this->dbObj);
									$featured = $this->dbObj->Insert_ID();
									if($featured!='')
										{
											$featured = $this->dbObj->Insert_ID();
											$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET total_featured = total_featured+1'.
													' WHERE video_id='.$this->dbObj->Param('video_id');

											$stmt = $this->dbObj->Prepare($sql);
											$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id']));
											if (!$rs)
												trigger_db_error($this->dbObj);

											//echo $this->LANG['viewvideo_featured_added_successfully'];

											//Srart Post video featured Video activity	..
											$sql = 'SELECT vfe.video_featured_id, vfe.video_id, vfe.user_id as featured_user_id, u.user_name, v.video_title, v.user_id, v.video_server_url, v.is_external_embed_video, v.embed_video_image_ext '.
													'FROM '.$this->CFG['db']['tbl']['video_featured'].' as vfe, '.$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['video'].' as v '.
													'WHERE u.user_id = vfe.user_id AND vfe.video_id =v.video_id AND vfe.video_featured_id = \''.$this->dbObj->Param('video_favorite_id').'\'';


											$stmt = $this->dbObj->Prepare($sql);
											$rs = $this->dbObj->Execute($stmt, array($featured));
											if (!$rs)
												trigger_db_error($this->dbObj);

											$row = $rs->FetchRow();
											$activity_arr = $row;
											$activity_arr['action_key']	= 'video_featured';
											$videoActivityObj = new VideoActivityHandler();
											$videoActivityObj->addActivity($activity_arr);
											//end
										}
								}
						}
					//else
						//echo $this->LANG['viewvideo_featured_added_already'];
				}

		public function getFeatured()
		{
			$featured['added']='';
			$featured['id']='';
			$featured['url']='';
			if(!isMember())
			{
				$featured['url']=getUrl('viewvideo', '?video_id='.$this->fields_arr['video_id'].'&amp;title='.$this->changeTitle($this->fields_arr['video_title']), $this->fields_arr['video_id'].'/'.$this->changeTitle($this->fields_arr['video_title']).'/', '', 'video');
				//getUrl('viewvideo','?video_id='.$this->fields_arr['video_id'].'&amp;title='.$this->changeTitle($this->fields_arr['video_title']), $this->fields_arr['video_id'].'/'.$this->changeTitle($this->fields_arr['video_title']), '','video');
			}
			else
			{
				$condition='video_id='.$this->dbObj->Param('video_id').
						' AND user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';
				$condtionValue=array($this->fields_arr['video_id'], $this->CFG['user']['user_id']);
				$featured['url']=$this->CFG['site']['video_url'].'viewVideo.php?video_id='.$this->fields_arr['video_id'].'&amp;ajax_page=true&amp;page=featured';
				if($rs=$this->selectFeatured($condition,$condtionValue,'full'))
				{
					if($rs->PO_RecordCount())
					{
						$row = $rs->FetchRow();
						$featured['added']=true;
					}
				}

			}
			return $featured;
		}
		public function populateOriginalFormatDownloadLink()
		{

		if($this->CFG['user']['user_id']!=$this->fields_arr['user_id'])
			{
				if(($this->CFG['admin']['videos']['full_length_video']=='members' AND !isloggedIn()) OR ($this->CFG['admin']['videos']['full_length_video']=='paid_members' AND !isPaidMember()))
				{
					return false;
				}
			}

			if($this->CFG['admin']['videos']['download_previlages']=='members' && !isLoggedin())
				$folder='members';
			else
				$folder='';
			$video_download_format_arr=array('wmv','3gp');
            $type=$this->getFormField('video_ext');
				if($this->getFormField('video_ext'))
				{
					if(($this->CFG['admin']['videos']['download_previlages']=='members' AND isLoggedin()) OR ($this->CFG['admin']['videos']['download_previlages']=='All'))
					{
						//$wmv_file =$this->getVideoServerURL($this->fields_arr['video_id']).$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['other_videoformat_folder'].'/'.getVideoName($this->fields_arr['video_id']).'.wmv';onclick="alert('<?php echo $this->LANG['viewvideo_savetarget'];);return false;"
					?><li><a target="_blank" class="cls<?php if(in_array($type, $video_download_format_arr)) echo $type; else echo 'playerdownloaddefault'; ?>"   href="<?php echo getUrl($this->getDownloadFileName(),'?video_id='.$this->getFormField('video_id').'&amp;video_type=original', 'original/'.$this->getFormField('video_id').'/',$folder,'video');?>" title="<?php echo $this->getVideoDownLoadDetails($type); ?>"><?php echo $this->getFormField('video_ext');  ?></a>

				<?php
					}
					else
					{
						?><li><a target="_blank" class="cls<?php if(in_array($type, $video_download_format_arr)) echo $type; else echo 'playerdownloaddefault'; ?>"   href="<?php echo getUrl($this->getDownloadFileName(),'?video_id='.$this->getFormField('video_id').'&amp;video_type=original', 'original/'.$this->getFormField('video_id').'/','members','video');?>" title="<?php echo $this->getVideoDownLoadDetails($type); ?>" ><?php echo $this->getFormField('video_ext');  ?></a></li><?php
					}
				}
			//	}
		}
		public function populateOtherFormatDownloadLink()
		{

			if($this->CFG['user']['user_id']!=$this->fields_arr['user_id'])
			{
				if(($this->CFG['admin']['videos']['full_length_video']=='members' AND !isloggedIn()) OR ($this->CFG['admin']['videos']['full_length_video']=='paid_members' AND !isPaidMember()))
				{
					return false;
				}
			}

			if($this->CFG['admin']['videos']['download_previlages']=='members' && !isLoggedin())
				$folder='members';
			else
				$folder='';

			foreach($this->fields_arr['video_available_formats'] as $index=>$type)
			{
			if($type!=$this->getFormField('video_ext'))
			{
			$video_download_format_arr=array('wmv','3gp');
			?><li>
				<?php
					if(($this->CFG['admin']['videos']['download_previlages']=='members' AND isLoggedin()) OR ($this->CFG['admin']['videos']['download_previlages']=='All'))
					{
					//	$wmv_file =$this->getVideoServerURL($this->fields_arr['video_id']).$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['other_videoformat_folder'].'/'.getVideoName($this->fields_arr['video_id']).'.wmv';
					?><a target="_blank"  class="cls<?php if(in_array($type, $video_download_format_arr)) echo $type; else echo 'playerdownloaddefault'; ?>" href="<?php echo getUrl($this->getDownloadFileName(),'?video_id='.$this->fields_arr['video_id'].'&amp;video_type='.$type, $type.'/'.$this->fields_arr['video_id'].'/',$folder,'video');?>" title="<?php echo $this->getVideoDownLoadDetails($type); ?>" ><?php echo $type ?></a>
						<?php //echo '<br/><span>('.$this->LANG['viewvideo_savetarget'].')</span>';
					}
					else
					{
						?><a target="_blank" class="cls<?php if(in_array($type, $video_download_format_arr)) echo $type; else echo 'playerdownloaddefault'; ?>" href="<?php echo getUrl($this->getDownloadFileName(),'?video_id='.$this->getFormField('video_id').'&amp;video_type='.$type, $type.'/'.$this->getFormField('video_id').'/','members','video');?>" title="<?php echo $this->getVideoDownLoadDetails($type); ?>" ><?php echo $type ?></a><?php
					}
			//	}
				?></li>
			<?php
			}}
		}
		public function getThumbImage()
		{
		if(!$this->CFG['admin']['videos']['show_available_thumbs'])
			return false;

		$video_name = getVideoImageName($this->getFormField('video_id'));
		$return = array();
		$video_server_url=$this->fields_arr['video_server_url'];
		$host=$_SERVER["HTTP_HOST"];
		$pattern='/'.$host.'/';
		$localServerMatch=false;
		$oldServerUrl=$video_server_url;
		if(preg_match($pattern,$video_server_url))
		{
			$video_server_url=$this->media_relative_path;
			$localServerMatch=true;
		}
		$video_folder =$video_server_url.$this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'];
		$gif_animation_path = $video_folder.'/'.$video_name.'_gif/';

		$available_thumb = array();
		$inc=0;

		$total_gif_frame=$this->CFG['admin']['videos']['rotating_thumbnail_max_frames'];
		for($i=1; $i<=$total_gif_frame;$i++)
			{
				$path=$gif_animation_path.$i.'.'.$this->CFG['video']['image']['extensions'];
				$pass=false;
				if(!$localServerMatch)
					{
						if(getHeadersManual($path))
							{
								$pass=true;
							}
					}
				else
					{
						if(file_exists($path))
							{
								$pass=true;
							}
					}
				if($pass)
					{
						if($localServerMatch)
							{
								$path=str_replace($this->media_relative_path,$oldServerUrl,$path);
							}
						$available_thumb[$inc]['src'] =$path;
						$available_thumb[$inc]['id']=$i;
						$inc++;
					}
			}
		if(!$this->CFG['admin']['videos']['rotating_thumbnail_feature'] OR empty($available_thumb))
		{
			if($localServerMatch)
				{
					$video_folder=str_replace($this->media_relative_path,$oldServerUrl,$video_folder);
				}

			for($i=1; $i<=$this->CFG['admin']['videos']['total_frame'];$i++)
			{
					$available_thumb[$inc]['src'] =$video_folder.'/'.$video_name.'_'.$i.'.'.$this->CFG['video']['image']['extensions'];
					$available_thumb[$inc]['id']=$i;
					$inc++;
			}
		}
		$this->screenShot_width = round($this->fields_arr['s_width']/1.40);
		$this->screenShot_height = round($this->fields_arr['s_height']/1.40);

		$i=0;
		$totalScreenPerRow=$this->CFG['admin']['videos']['video_screen_per_row'];
		$available_thumb=array_filter($available_thumb);
		$count = sizeof($available_thumb);
		$maxRow=ceil($count/$totalScreenPerRow);
		$inc=0;

		foreach($available_thumb as $imageSrc)
		{
			if($imageSrc['src'])
			{
					$return[$inc]['opentr']='';
					if($i==0)
					{
						$return[$inc]['opentr']=true;
					}
					$i++;
					$count--;
					$return[$inc]['imageSrc']=$imageSrc['src'];


					if($maxRow==1 && !$count)
					{
						$return[$inc]['closetr']='';
						$remainingTdCount = $totalScreenPerRow-$i;
						for($remainingTdCount;$remainingTdCount>0;$remainingTdCount--)
						{
							$inc++;
							$return[$inc]['imageSrc']='';
							$return[$inc]['closetr']='';
							$return[$inc]['opentr']='';
						}

					}
					$return[$inc]['closetr']='';
					if($i==$totalScreenPerRow)
					{
						$i=0;
						$maxRow--;
						$return[$inc]['closetr']=true;
					}
					$inc++;

				}
				else
				{
					$count--;
				}
				if($inc>=$this->CFG['admin']['videos']['video_screen_total_count'])
				{
					return $return;
				}
			}
			return $return;
		}

		public function getEditCommentBlock()
			{
				global $smartyObj;
				$replyBlock['comment_id']=$this->fields_arr['comment_id'];
				$replyBlock['name']='addEdit_';
				$replyBlock['sumbitFunction']='addToEdit';
				$replyBlock['cancelFunction']='discardEdit';
				$replyBlock['editReplyUrl']=$this->CFG['site']['video_url'].'viewVideo.php?ajax_page=true&amp;video_id='.$this->fields_arr['video_id'].'&vpkey='.$this->fields_arr['vpkey'].'&show='.$this->fields_arr['show'];
				$smartyObj->assign('commentEditReply', $replyBlock);
				setTemplateFolder('general/','video');
				$smartyObj->display('commentEditReplyBlock.tpl');
			}

		public function checkDownloadOption()
		{

			if($this->fields_arr['form_upload_type']=='externalsitevideourl')
			{
				require_once($this->CFG['site']['project_path'].'common/classes/class_ExternalVideoUrlHandler.lib.php');
				$extHandler=new ExternalVideoUrlHandler();
				$checkUrl=$extHandler->chkIsValidExternalSite($this->fields_arr['external_site_video_url'],'',$this->CFG);
				if($checkUrl['external_site']=='youtube')
				{
					if(!$this->CFG['admin']['videos']['download_youtube_videos'])
						return false;
				}
				else if($checkUrl['external_site']=='google')
				{
					if(!$this->CFG['admin']['videos']['download_google_videos'])
						return false;

				}
				else if($checkUrl['external_site']=='dailymotion')
				{
					if(!$this->CFG['admin']['videos']['download_dailymotion_videos'])
						return false;

				}
				else if($checkUrl['external_site']=='myspace')
				{
					if(!$this->CFG['admin']['videos']['download_myspace_videos'])
						return false;

				}
				else if($checkUrl['external_site']=='flvpath')
				{
					if(!$this->CFG['admin']['videos']['download_flvpath_videos'])
						return false;

				}
				return true;
			}
			return true;
		}

		public function getDownloadFileName()
		{

			if($this->CFG['admin']['videos']['download_previlages']=='members')
			{
				$downloadFileName='membervideodownload';

			}
			else
			{
				$downloadFileName='videodownload';
			}

			return $downloadFileName;

		}

		public function populateVideoCommentsOfThisVideo($start=0)
			{
				global $smartyObj;
				$default_fields = 'TIME_FORMAT(v.playing_time,\'%H:%i:%s\') as playing_time, v.video_id, v.user_id, v.video_title, v.video_caption,'.
								  ' TIMEDIFF(NOW(), v.date_added) as date_added, v.video_server_url, v.total_views,'.
								  ' v.s_width, v.s_height, v.video_ext, v.video_tags';
				$add_fields = '';
				$order_by = 'v.video_id DESC';
				$sql_condition = ' vr.video_id=\''.addslashes($this->fields_arr['video_id']).'\''.
							' AND vr.video_responses_video_id !=\''.addslashes($this->fields_arr['video_id']).'\''.
							' AND v.video_status=\'Ok\' '.$this->getAdultQuery('v.').
							' AND (v.user_id = '.$this->CFG['user']['user_id'].' OR'.
							' v.video_access_type = \'Public\') AND vr.video_responses_video_id=v.video_id AND video_responses_status =\'Yes\'';

				$sql_exising='SELECT count(1) count FROM '.$this->CFG['db']['tbl']['video'].' AS v, '.
							$this->CFG['db']['tbl']['video_responses'].' AS vr '.
							' WHERE '.$sql_condition.' ';

				$existing_total_records=$this->getExistingRecords($sql_exising);
				$process_start=$this->processResponsesStartValue($existing_total_records);

				$sql = 'SELECT '.$default_fields.$add_fields.' FROM '.$this->CFG['db']['tbl']['video'].' AS v, '.$this->CFG['db']['tbl']['video_responses'].' vr  '.
						' WHERE '.$sql_condition.' ORDER BY '.$order_by.
						' LIMIT '.$process_start.', '.$start;


				$responseVideo = array();
				$responseVideo['leftButtonClass'] = 'disabledPrevButton';
				$responseVideo['rightButtonClass'] = 'disabledNextButton';
				$responseVideo['leftButtonExist']=false;
				$responseVideo['rightButtonExists']=false;
				$nextSetAvailable = ($existing_total_records > ($process_start + $this->CFG['admin']['videos']['total_related_video']));
				if ($nextSetAvailable)
					{
			        	$responseVideo['rightButtonClass'] = 'enabledNextButton';
						$responseVideo['rightButtonExists']=true;
					}
				if ($process_start > 0)
					{
						$responseVideo['leftButtonExist']=true;
			        	$responseVideo['leftButtonClass'] = 'enabledPrevButton';
					}
				//------ Next and Prev Links--------------//

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				$responseVideo['total_records']=$total_records = $rs->PO_RecordCount();
				$responseVideo['pg']='resp';
				$responseVideo['more_link'] = getUrl('videolist','?pg=videoresponseslist&video_id='.$this->fields_arr['video_id'], 'videoresponseslist/?video_id='.$this->fields_arr['video_id'], '', 'video');
				if ($total_records)
				    {
					$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
					$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type', 'sex');
					$userid_arr=array();
					$inc=0;
							while($row = $rs->FetchRow())
							{
								/*if(!in_array($row['user_id'],$userid_arr))
								{
									$userid_arr[]=$row['user_id'];
								}*/
								$responseVideo['video'][$inc]['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';
								$responseVideo['video'][$inc]['viewUrl']=getUrl('viewvideo','?video_id='.$row['video_id'].'&title='.$this->changeTitle($row['video_title']).'&vpkey='.$this->fields_arr['vpkey'], $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/?vpkey='.$this->fields_arr['vpkey'], '', 'video');
								$responseVideo['video'][$inc]['image']=$row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
								$responseVideo['video'][$inc]['small_width']=$row['s_width'];
								$responseVideo['video'][$inc]['small_height']=$row['s_height'];
								$responseVideo['video'][$inc]['disp_image']=DISP_IMAGE(93, 70, $row['s_width'], $row['s_height']);
								$responseVideo['video'][$inc]['alt_tag']=$responseVideo['video'][$inc]['video_title']=$row['video_title'];
								$inc++;
							}
							/*$user_ids = implode(',', $userid_arr);
        					$this->getMultiUserDetails($user_ids, $fields_list);*/

					}
					$smartyObj->assign('myobj', $this);
					$smartyObj->assign('responseVideo', $responseVideo);
					setTemplateFolder('general/', 'video');
					$smartyObj->display('responseVideo.tpl');
			}

		public function postBlog()
			{
				$sql = 'SELECT blog_site, blog_title, blog_user_name, blog_password FROM '.$this->CFG['db']['tbl']['blogger'].' WHERE'.
						' blogger_id = '.$this->dbObj->Param('blogger_id').' AND'.
						' user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('blog_title'), $this->CFG['user']['user_id']));
				    if (!$rs)
				        trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						switch($row['blog_site'])
							{
								case 'blogger':
									if($blog_arr = getBlogLists($row['blog_user_name'], $row['blog_password']))
										{
											if($blog_detail = chkIsBlogAvailable($blog_arr, $row['blog_title']))
												{
													//$embed_code = '<embed src="'.$this->CFG['site']['url'].'embedPlayer.php?vid='.mvFileRayzz($this->getFormField('video_id')).'" FlashVars="config='.$this->CFG['site']['video_url'].'videoConfigXmlCode.php?pg=video_'.$this->getFormField('video_id').'_no_0_extsite" quality="high" bgcolor="#000000"width="450" height="370" name="flvplayer" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"  />';
													postNewBlog($row['blog_user_name'], $row['blog_password'], $this->getFormField('blog_post_title'), $this->embeded_code_postBlog.'<br><br>'.$this->getFormField('blog_post_text'), $blog_detail['blogid']);
												}
										}
								break;
							}
					}
			}
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
				$user_name=$this->getUserDetail('user_id',$row['user_id'], 'user_name');

				return getMemberAvatarDetails($user_name);

			}

			public function checkIsExternalEmebedCode()
			{
				if(isset($this->fields_arr['is_external_embed_video']))
				{
					if($this->fields_arr['is_external_embed_video']=='Yes')
						{
							return true;
						}
				}
					return false;
			}

		/**
		 * ViewVideo::chkLinksDisplayAllowedTo()
		 *   To check displaying link details to whom
		 *
		 * @return boolean
		 */
		public function chkLinksDisplayAllowedTo()
			{
				if($this->CFG['admin']['videos']['display_link_details_to'] == 'Owner')
					{
						if($this->CFG['user']['user_id'] == $this->fields_arr['user_id'])
							return true;
						else
							return false;

					}
				elseif($this->CFG['admin']['videos']['display_link_details_to'] == 'All')
					return true;
			}

			/**
			 * ViewVideo::displayEmbededVideo()
			 *
			 * @return
			 */
			public function displayEmbededVideo()
			{
				echo html_entity_decode($this->getFormField('video_external_embed_code'));
			}

		/**
		 * ViewVideo::chkIsNotEmpty()
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
		 * ViewVideo::chkCaptcha()
		 *
		 * @param string $field_name
		 * @param string $err_tip
		 * @return boolean
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

		public function isTrimmedVideo()
		{

			$trimmedVideo = false;

			if($this->checkIsExternalEmebedCode())
			{
				return false;
			}

			if($this->CFG['user']['user_id']==$this->fields_arr['user_id'])
			{
				return $trimmedVideo;
			}
			if($this->CFG['admin']['videos']['full_length_video']=='members' AND !isloggedIn())
			{
				$link = '<a href="'.getUrl('signup').'">'.$this->LANG['trimmed_click_here'].'</a>';
				$this->trimmendMessage = str_replace('{link}',$link,$this->LANG['trimmed_video_message_member']);
				$trimmedVideo =true;
			}
			else if($this->CFG['admin']['videos']['full_length_video']=='paid_members' AND !isPaidMember())
			{
				$link = '<a href="'.getUrl('upgrademembership','','','members').'">'.$this->LANG['trimmed_click_here'].'</a>';
				$this->trimmendMessage = str_replace('{link}',$link,$this->LANG['trimmed_video_message_paidmember']);
				$trimmedVideo =true;
			}

			return $trimmedVideo;
		}

		/**
		 * ViewVideo::generateEmbedCode()
		 *
		 * @return void
		 */
		public function generateEmbedCode()
		{
			global $CFG;

			$this->embeded_code = htmlentities('<script type="text/javascript" src="'.$CFG['site']['video_url'].'embededvideo/?vid='.$this->getFormField('video_id').'"></script>');
			$this->embeded_code_default = '<script type="text/javascript" src="'.$CFG['site']['video_url'].'embededvideo/?vid='.$this->getFormField('video_id').'"><\/script>';
			$this->embeded_code_js = '<script type="text/javascript" src="'.$CFG['site']['video_url'].'embededvideo/?vid='.$this->getFormField('video_id').'&width={$width}&height={$height}"><\/script>';

			if($CFG['admin']['videos']['SelectedPlayer']=='premium')
				{
					$flv_player_url = $CFG['site']['url'].$CFG['media']['folder'].'/flash/video/flvplayers/'.$CFG['admin']['videos']['elite_player']['swf_name'].'.swf';
					$configXmlcode_url = $CFG['site']['video_url'].$CFG['admin']['videos']['premium_player']['config_name'].'.php?';
				}
			else if($CFG['admin']['videos']['SelectedPlayer']=='elite')
				{
					$configXmlcode_url = $CFG['site']['video_url'].$CFG['admin']['videos']['elite_player']['config_name'].'.php?';
				}

			if($CFG['admin']['videos']['embed_method'] == 'html')
				{
					$width = $CFG['admin']['videos']['minimum_player_width'];
					$height = $CFG['admin']['videos']['minimum_player_height'];
					$videoId = mvFileRayzz($this->getFormField('video_id'));
					//$ViewVideo->embeded_code = '<embed src="'.$CFG['site']['video_url'].'embedUrl.php?vid='.$ViewVideo->getFormField('video_id').'"></embed>';
					$this->embeded_code = htmlentities('<embed width="'.$width.'" height="'.$height.'" src="'.$CFG['site']['video_url'].'embedPlayer.php?vid='.$videoId.'_'.$this->getFormField('video_id').'" FlashVars="config='.$configXmlcode_url.'pg=video_'.$this->getFormField('video_id').'_no_0_extsite" quality="high" bgcolor="#000000" name="flvplayer" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" allowFullScreen="true" />');
					$this->embeded_code_default = '<embed width="'.$width.'" height="'.$height.'" src="'.$CFG['site']['video_url'].'embedPlayer.php?vid='.$videoId.'_'.$this->getFormField('video_id').'" FlashVars="config='.$configXmlcode_url.'pg=video_'.$this->getFormField('video_id').'_no_0_extsite" quality="high" bgcolor="#000000" name="flvplayer" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" allowFullScreen="true" />';
					$this->embeded_code_js = '<embed width="{$width}" height="{$height}" src="'.$CFG['site']['video_url'].'embedPlayer.php?vid='.$videoId.'_'.$this->getFormField('video_id').'" FlashVars="config='.$configXmlcode_url.'pg=video_'.$this->getFormField('video_id').'_no_0_extsite" quality="high" bgcolor="#000000" name="flvplayer" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" allowFullScreen="true" />';
				}
		}

		public function populateVideoBlog()
			{
				global $smartyObj;
				$this->videos_form['getBlogList'] = $this->getBlogList();
				setTemplateFolder('general/', 'video');
				$smartyObj->display('videoBlog.tpl');
			}
		/**
		* ViewVideo::chkBlogAdded()
		* Function To Check Blog Already Added by User
		* @return boolean
		*/
		public function chkBlogAdded()
		{
			$sql = 'SELECT blogger_id, blog_title FROM '
			  	   .$this->CFG['db']['tbl']['blogger'].' WHERE'.
				   ' user_id = '.$this->dbObj->Param('user_id').' AND'.
				   ' status = \'Ok\'';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
			if (!$rs)
			trigger_db_error($this->dbObj);
			if ($row = $rs->FetchRow())
			{
				return true;
			}
			return false;
		}
		public function getVideoDownLoadDetails($video_type)
		{

			$sql = 'SELECT total_downloads FROM '
				  	   .$this->CFG['db']['tbl']['video_other_format_downloads'].' WHERE'.
					   ' video_id = '.$this->dbObj->Param('video_id').' AND'.
					   ' video_type = '.$this->dbObj->Param('video_type');
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_id'],$video_type));
				if (!$rs)
				trigger_db_error($this->dbObj);
				if ($row = $rs->FetchRow())
				{
					return $video_type.'('.$row['total_downloads'].' '.$this->LANG['viewvideo_downloads'].' )';
				}
				else
				{
                   return $video_type.'(0 Downloads )';
				}
		}


	}
//<<<<<-------------- Class ViewVideo begins ---------------//
//-------------------- Code begins -------------->>>>>//
$ViewVideo = new ViewVideo();
$ViewVideo->setDBObject($db);

//To set Player size according to template
$CFG['admin']['videos']['minimum_player_width'] = 642;
$CFG['admin']['videos']['minimum_player_height'] = 512;

$ViewVideo->setMediaPath('../');
if(isMember())
	$ViewVideo->setMediaPath('../../');

$ViewVideo->makeGlobalize($CFG,$LANG);
if(!chkAllowedModule(array('video')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

$ViewVideo->setPageBlockNames(array('msg_form_error', 'msg_form_success', 'videos_form', 'delete_confirm_form', 'get_code_form',
									'confirmation_flagged_form', 'add_comments', 'add_reply', 'edit_comment',
									'update_comment', 'rating_image_form', 'add_flag_list', 'add_fovorite_list',
									'confirmation_adult_form', 'videoMainBlock','block_add_comments','block_image_display'));

//default form fields and values...
$ViewVideo->setFormField('video_id', '');
$ViewVideo->setFormField('total_downloads', '0');
$ViewVideo->setFormField('video_caption', '');
$ViewVideo->setFormField('vpkey', '');
$ViewVideo->setFormField('action', '');
$ViewVideo->setFormField('comment_id', '');
$ViewVideo->setFormField('action', '');
$ViewVideo->setFormField('video_code', '');
$ViewVideo->setFormField('video_title', '');
$ViewVideo->setFormField('user_name', '');
$ViewVideo->setFormField('user_id', '');
$ViewVideo->setFormField('album_id', '');
//for ajax
$ViewVideo->setFormField('f',0);
$ViewVideo->setFormField('show','1');
$ViewVideo->setFormField('comment_id',0);
$ViewVideo->setFormField('maincomment_id',0);
$ViewVideo->setFormField('type','');
$ViewVideo->setFormField('ajax_page','');
$ViewVideo->setFormField('paging','');
$ViewVideo->setFormField('rate', '');
$ViewVideo->setFormField('flag', '');
$ViewVideo->setFormField('page', '');
$ViewVideo->setFormField('favorite_id', '');
$ViewVideo->setFormField('video_tags', '');
$ViewVideo->setFormField('play_list', '');//  This can be "ql" / "pl". means that Quick List and Play List. When play_list. Need play list id
$ViewVideo->setFormField('playlist_id', '');
$ViewVideo->setFormField('playlist_name', '');
$ViewVideo->setFormField('playlist_description', '');
$ViewVideo->setFormField('playlist_tags', '');
$ViewVideo->setFormField('playlist_access_type', 'Public');
$ViewVideo->setFormField('playlist', '');
$ViewVideo->setFormField('flag_comment', '');
$ViewVideo->setFormField('favorite', '');
$ViewVideo->setFormField('featured', '');
$ViewVideo->setFormField('relatedVideo', '');
$ViewVideo->setFormField('order', '');
$ViewVideo->setFormField('blog_title', '');
$ViewVideo->setFormField('blog_post_title', '');
$ViewVideo->setFormField('blog_post_text', '');
$ViewVideo->setFormField('allow_response', '');
$ViewVideo->setFormField('flagged_content', '');
$ViewVideo->setFormField('recaptcha_challenge_field', '');
$ViewVideo->setFormField('recaptcha_response_field', '');
$ViewVideo->setFormField('show_complete_quick_list', '');
// ********** Page Navigation Start ********
$ViewVideo->setFormField('start', '0');
//$ViewVideo->setFormField('numpg', 3);
$ViewVideo->setFormField('numpg', $CFG['data_tbl']['numpg']);

$ViewVideo->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$ViewVideo->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$ViewVideo->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$ViewVideo->setTableNames(array());
$ViewVideo->setReturnColumns(array());
// *********** page Navigation stop ************

$ViewVideo->flag_type_arr = $LANG_LIST_ARR['flag']['video'];
$ViewVideo->video_response_added=false;

$ViewVideo->play_list_next_url='';

$ViewVideo->sanitizeFormInputs($_REQUEST);

$ViewVideo->generateEmbedCode();

$ViewVideo->load_blog_url = $ViewVideo->CFG['site']['video_url'].'viewvideo.php?video_id='.
											$ViewVideo->getFormfield('video_id').'&ajax_page=true&page=load_blog';

$ViewVideo->memberLoginVideoUrl = getUrl('viewvideo','?mem_auth=true&music_id='.$ViewVideo->getFormfield('video_id').'&title='.
																		$ViewVideo->changeTitle($ViewVideo->getFormfield('video_title')),
																			$ViewVideo->getFormfield('video_id').'/'.
																				$ViewVideo->changeTitle($ViewVideo->getFormfield('video_title')).
																				'/?mem_auth=true','members', 'video');


if(isAjax())
{
	$ViewVideo->includeAjaxHeaderSessionCheck();
	if ($ViewVideo->getFormField('action')=='popplaylist')
	    {
			$ViewVideo->checkLoginStatusInAjax($ViewVideo->memberLoginVideoUrl);
			$ViewVideo->populatePlaylist();
			die();
	    }
	if ($ViewVideo->getFormField('action')=='popblogtitle')
	    {

			$ViewVideo->checkLoginStatusInAjax($ViewVideo->memberLoginVideoUrl);
			$ViewVideo->populateVideoBlog();
			die();
	    }

	if($ViewVideo->getFormField('action') and $ViewVideo->getFormField('action')=='post_blog')
		{
			if(!$ViewVideo->chkIsNotEmpty('blog_post_title') OR !$ViewVideo->chkIsNotEmpty('blog_post_text'))
				{
					echo $LANG['mandatory_fields_compulsory'];
					die();
				}
			$ViewVideo->validate = $ViewVideo->chkValidVideoId();
			if(!$ViewVideo->checkIsExternalEmebedCode())
				{
					$ViewVideo->embeded_code_postBlog	=  '<script type="text/javascript" src="'.$CFG['site']['video_url'].'embededvideo/?vid='.$ViewVideo->getFormField('video_id').'"></script>';
				}
			else
				{
					$ViewVideo->embeded_code_postBlog = html_entity_decode($ViewVideo->getFormField('video_external_embed_code'));
				}
			$ViewVideo->postBlog();
		}

	$ViewVideo->validate = $ViewVideo->chkValidVideoId();
	if ($ViewVideo->isPageGETed($_POST, 'vUserFetch'))
	    {
			$ViewVideo->populateRleatedVideo('user');
			die();
	    }
	if ($ViewVideo->isPageGETed($_POST, 'vTagFetch'))
	    {
			$ViewVideo->populateRleatedVideo('tag');
			die();
	    }
	if ($ViewVideo->isPageGETed($_POST, 'vTopFetch'))
	    {
			$ViewVideo->populateRleatedVideo('top');
			die();
		}
	if($ViewVideo->getFormField('relatedVideo'))
		{
	  		$ViewVideo->populateRleatedVideo($ViewVideo->getFormField('type'));
			exit;
		}
	if ($ViewVideo->isPageGETed($_POST, 'show_qucik_link_text_id') || $ViewVideo->isPageGETed($_GET, 'show_qucik_link_text_id'))
	 	{
			$ViewVideo->populateQuickLinkVideos(true, $_GET['show_qucik_link_text_id']);
			die();
		}

	if ($ViewVideo->isPageGETed($_POST, 'show_complete_quick_list') || $ViewVideo->isPageGETed($_GET, 'show_complete_quick_list'))
	    {
	    	$ViewVideo->setFormField('show_complete_quick_list', 1);
			$ViewVideo->populateQuickLinkVideos($limit=false);
			die();
		}
	if($ViewVideo->getFormField('type')=='edit')
		{
			$ViewVideo->setPageBlockShow('edit_comment');
		}
	else if($ViewVideo->isFormGETed($_GET, 'comment_id'))
		{
			$ViewVideo->setPageBlockShow('add_reply');
		}
	else if(!$ViewVideo->getFormField('paging'))
		{
			$ViewVideo->setPageBlockShow('add_comments');
		}

	if ($ViewVideo->isPageGETed($_POST, 'ajaxpaging'))
	    {
			$ViewVideo->populateCommentOfThisVideo();
			ob_end_flush();
			die();
	    }

	if($ViewVideo->isFormGETed($_REQUEST, 'f') and $ViewVideo->getFormField('type')=='edit')
		{
			$ViewVideo->setAllPageBlocksHide();
			$htmlstring = trim(urldecode($ViewVideo->getFormField('f')));
			$htmlstring = strip_tags(html_entity_decode($htmlstring), '<br><br />');
			$ViewVideo->setFormField('f',$htmlstring);
			$ViewVideo->checkLoginStatusInAjax($ViewVideo->memberLoginVideoUrl);
			$ViewVideo->updateCommentAndVideoTable();
		}
	else if($ViewVideo->isFormGETed($_REQUEST, 'f'))
		{
			if($CFG['admin']['videos']['captcha']
					AND $CFG['admin']['videos']['captcha_method'] == 'recaptcha'
						AND $CFG['captcha']['public_key'] AND $CFG['captcha']['private_key'])
					{
						$ViewVideo->chkIsCaptchaNotEmpty('recaptcha_response_field', $LANG['common_err_tip_compulsory']) AND
							$ViewVideo->chkCaptcha('recaptcha_response_field', $LANG['common_err_tip_invalid_captcha']);
					}
			$ViewVideo->setAllPageBlocksHide();
			$htmlstring = trim(urldecode($ViewVideo->getFormField('f')));
			$htmlstring = strip_tags(html_entity_decode($htmlstring), '<br><br />');
			$ViewVideo->setFormField('f',$htmlstring);
			$ViewVideo->checkLoginStatusInAjax($ViewVideo->memberLoginVideoUrl);
			$ViewVideo->insertCommentAndVideoTable();
			die();
		}
	else if($ViewVideo->isFormGETed($_GET, 'rate'))
		{
			if($ViewVideo->chkAllowRating())
			{
				$ViewVideo->setAllPageBlocksHide();
				$ViewVideo->insertRating();
				$ViewVideo->getTotalRatingImage();
			}
		}
	else if($ViewVideo->isFormGETed($_POST, 'flag'))
		{
			$ViewVideo->setAllPageBlocksHide();
			if(!$ViewVideo->chkIsNotEmpty('flag_comment',$LANG['flag_comment_invalid']))
			{
				echo $ViewVideo->getFormFieldErrorTip('flag_comment');
				exit;
			}
			$ViewVideo->setFormField('flag_comment',trim(urldecode($ViewVideo->getFormField('flag_comment'))));
			$ViewVideo->checkLoginStatusInAjax($ViewVideo ->memberLoginVideoUrl);
			$ViewVideo->insertFlagVideoTable();
		}
	else if($ViewVideo->isFormGETed($_GET, 'favorite') || $ViewVideo->isFormGETed($_POST, 'favorite'))
	{
		$ViewVideo->setAllPageBlocksHide();
		$ViewVideo->checkLoginStatusInAjax($ViewVideo->memberLoginVideoUrl);
		if($ViewVideo->getFormField('favorite'))
		{
			$ViewVideo->insertFavoriteVideoTable();
		}
		else
		{
			$ViewVideo->deleteFavoriteVideo($ViewVideo->getFormField('video_id'),$CFG['user']['user_id']);
			echo $ViewVideo->LANG['viewvideo_favorite_deleted_successfully'];

		}
	}
	else if($ViewVideo->isFormGETed($_GET, 'featured') || $ViewVideo->isFormGETed($_POST, 'featured'))
	{
		$ViewVideo->setAllPageBlocksHide();
		$ViewVideo->checkLoginStatusInAjax($ViewVideo->memberLoginVideoUrl);
		if($ViewVideo->getFormField('featured'))
		{
			$ViewVideo->insertFeaturedVideoTable();
		}
		else
			$ViewVideo->deleteFromFeatured(true);
	}
	else if($ViewVideo->getFormField('page')=='getcode')
		{
			$ViewVideo->setAllPageBlocksHide();
			$ViewVideo->setPageBlockShow('get_code_form');
			$ViewVideo->setFormField('image_width', $CFG['admin']['videos']['thumb_width']);
			$ViewVideo->populateVideoDetails();
		}
	else if($ViewVideo->getFormField('page')=='deletecomment')
		{
			$ViewVideo->setAllPageBlocksHide();
			$ViewVideo->checkLoginStatusInAjax($ViewVideo->memberLoginVideoUrl);
			$ViewVideo->deleteComment();
			$ViewVideo->populateCommentOfThisVideo();
		}
	else if($ViewVideo->getFormField('page')=='deletecommentreply')
		{
			$ViewVideo->setAllPageBlocksHide();
			$ViewVideo->deleteComment();
			$ViewVideo->populateReplyCommentOfThisVideo();
		}
	else if($ViewVideo->getFormField('page')=='playlist')
	{
		$ViewVideo->setAllPageBlocksHide();
		if($ViewVideo->isFormGETed($_POST, 'playlist'))
		{

			if($ViewVideo->chkIsNotEmpty('playlist',''))
				$ViewVideo->updatePlaylist($ViewVideo->getFormField('playlist'));
			else
				echo $LANG['playlist_selection_error'];

		}
		else
		{
			$flag=true;
			//$ViewVideo->chkIsNotEmpty('playlist_access_type','')
			$LANG['playlistname_invalid_size']=str_replace(array('{min}','{max}'),array($CFG['fieldsize']['playlist_name']['min'],$CFG['fieldsize']['playlist_name']['max']),$LANG['playlistname_invalid_size']);
			if(!$ViewVideo->chkIsNotEmpty('playlist_name','') || !$ViewVideo->chkIsValidSize('playlist_name','playlist_name',$LANG['playlistname_invalid_size']))
			{
				echo $ViewVideo->getFormFieldErrorTip('playlist_name');

			$flag=false;
			}
			if(!$ViewVideo->chkIsNotEmpty('playlist_tags','') || !$ViewVideo->chkValidTagList('playlist_tags','tags',$LANG['playlist_err_tip_invalid_tag']))
			{

					echo $ViewVideo->getFormFieldErrorTip('playlist_tags');
					$flag=false;
			}
			if(!$flag)
			{

				exit;
			}
			$id=$ViewVideo->createPlaylist();
			if($id)
				$ViewVideo->updatePlaylist($id);
			else
				echo sprintf($LANG['playlist_create_failure'],$ViewVideo->getFormField('playlist_name'));

		}
		exit;
	}
	if($ViewVideo->isShowPageBlock('add_reply'))
	{
		echo $ViewVideo->getFormField('comment_id');
		echo '***--***!!!';
		$ViewVideo->getReplyBlock();
	}
	if($ViewVideo->isShowPageBlock('edit_comment'))
	{
		echo $ViewVideo->getFormField('comment_id');
		echo '***--***!!!';
		$ViewVideo->getEditCommentBlock();
	}
	if($ViewVideo->isShowPageBlock('update_comment'))
	{
		echo $ViewVideo->getFormField('comment_id');
		echo '***--***!!!';
		echo $ViewVideo->getFormField('f');
	}

	if ($ViewVideo->isShowPageBlock('get_code_form') and 1)
    {
		$videos_folder = $CFG['media']['folder'].'/'.$CFG['admin']['videos']['folder'].'/';
		##we can now integrate elite player in embededPlayer.php also
		/*if($CFG['admin']['videos']['SelectedPlayer']=='elite')
		{
			$flv_player_url= $CFG['site']['url'].'flvplayer_elite.swf';
		}else{
			$flv_player_url = $CFG['site']['url'].'embedPlayer.php?vid='.mvFileRayzz($ViewVideo->getFormField('video_id')).'';
		}*/

	/*	$flv_player_url = $CFG['site']['url'].'embedPlayer.php?vid='.mvFileRayzz($ViewVideo->getFormField('video_id')).'';

		if($CFG['admin']['videos']['SelectedPlayer']=='elite')
		{
			$configXmlcode_url = $CFG['site']['url'].$CFG['admin']['videos']['elite_player']['config_name'].'.php?pg=video_'.$ViewVideo->getFormField('video_id').'_0_extsite';
		}
		else{
			$configXmlcode_url = $CFG['site']['url'].$CFG['admin']['videos']['premium_player']['config_name'].'.php?pg=video_'.$ViewVideo->getFormField('video_id').'_0_extsite';
		}*/
		?>
		<div id="groupAdd">
  			<h2><span><?php echo $LANG['viewvideo_codes_to_display'];?></span></h2>
  			<p>
  			<input class="clsSubmitButton" onClick="return hideAllBlocks();" value="<?php echo $LANG['viewvideo_cancel'];?>" type="button" />
  			</p>
  			<form name="formGetCode" id="formInvite" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
    		<p class="clsPaddingTop5">
      			<textarea class="clsEmbedCodeTextFields" rows="5" cols="75" name="image_code" id="image_code" READONLY tabindex="5" onFocus="this.select()" onClick="this.select()" ><?php echo $ViewVideo->embeded_code;?></textarea>
    		</p>
  			</form>
		</div>
	<?php
	}
	$ViewVideo->includeAjaxFooter();
}

$_SESSION['vUserStart'] = 0;
$_SESSION['vTagStart'] = 0;
$_SESSION['vTopStart'] = 0;
$_SESSION['vRespStart'] = 0;
if(!isAjax() or $ViewVideo->getFormField('paging'))
	{
		$ViewVideo->validate = false;
		$ViewVideo->IS_USE_AJAX = true;
		$ViewVideo->validate = $ViewVideo->chkValidVideoId();
		if($ViewVideo->validate)
		{
			if(isset($_SESSION['download_type']))
			{
				$ViewVideo->downloadUrl=getUrl('membervideodownload','?video_id='.$ViewVideo->getFormField('video_id').'&video_type='.$_SESSION['download_type'], $_SESSION['download_type'].'/'.$ViewVideo->getFormField('video_id').'/','members','video');
			}

			if($ViewVideo->chkIsUserHasRights($ViewVideo->getFormField('user_id')))
			{
				$ViewVideo->getUploadedBackground($ViewVideo->getFormField('user_id'));
				if($ViewVideo->background_path)
				{
					if(isMember())
					$ViewVideo->background_path=str_replace('../../',$CFG['site']['url'],$ViewVideo->background_path);
					else
					$ViewVideo->background_path=str_replace('../',$CFG['site']['url'],$ViewVideo->background_path);
				}
				$smartyObj->bodyBackgroundImage=$ViewVideo->background_path;
			}
			$ViewVideo->setPageBlockShow('videoMainBlock');
			$ViewVideo->setPageBlockShow('block_add_comments');
			if($ViewVideo->isFormGETed($_GET, 'action'))
				{
					$display = 'error';
					if(($ViewVideo->getFormField('action')=='view' or $ViewVideo->getFormField('action')=='accept' or $ViewVideo->getFormField('action')=='reject') and $validate)
						{

							if(isAdultUser('allow'))
								$display = 'video';
							else
								{
									if($CFG['admin']['videos']['adult_content_view']!='No')
										$display = 'video';
									else
										$display = 'error';
								}
							switch($display)
								{
									case 'error':
										$ViewVideo->setAllPageBlocksHide();
										$ViewVideo->setCommonErrorMsg($ViewVideo->replaceAdultText($LANG['msg_error_not_allowed']));
										$ViewVideo->setPageBlockShow('msg_form_error');
										break;

									case 'video':
										switch($ViewVideo->getFormField('action'))
											{
												case 'accept':
													$ViewVideo->changeMyContentFilterSettings($CFG['user']['user_id'], 'Off');
													break;

												case 'reject':
													if($CFG['user']['user_id'])
														$ViewVideo->changeMyContentFilterSettings($CFG['user']['user_id'], 'On');
													Redirect2Url($CFG['site']['url']);
													break;
											}
										$ViewVideo->changeLastViewDateAndVideoViewed();
										$ViewVideo->setPageBlockShow('videos_form');
										break;
								}
						}
					else
						{
							$ViewVideo->setAllPageBlocksHide();
							$ViewVideo->setCommonErrorMsg($LANG['msg_error_sorry']);
							$ViewVideo->setPageBlockShow('msg_form_error');
						}
				}
		else if($ViewVideo->isFormPOSTed($_REQUEST, 'video_id'))
			{
				if($ViewVideo->isFormPOSTed($_POST, 'select_response_video'))
				{
					list($video_resp_id)=array_keys($_POST['select_response_video']);
					if($ViewVideo->postVideoResponse($video_resp_id))
						{
							$ViewVideo->setPageBlockShow('msg_form_success');
							$ViewVideo->video_response_added=true;
						}
				}

				if(!$ViewVideo->validate)
					{
						$ViewVideo->setAllPageBlocksHide();
						$ViewVideo->setCommonErrorMsg($LANG['msg_error_sorry_access_denied']);
						$ViewVideo->setPageBlockShow('msg_form_error');
					}
				else
					{
						$display = 'video';
						if((chkAllowedModule(array('content_filter'))) and ($ViewVideo->getFormField('video_category_type')=='Porn'))
							{
								if(isAdultUser())
									{
										$display = 'video';
									}
								else
									{
										if($CFG['admin']['videos']['adult_content_view']=='Confirmation')
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
						if(($ViewVideo->getFormField('flagged_status')=='Yes') and ($ViewVideo->getFormField('flagged_content')!='show'))
							$display = 'flag';

						switch($display)
							{
								case 'error':
									$ViewVideo->setAllPageBlocksHide();
									$ViewVideo->setCommonErrorMsg($ViewVideo->replaceAdultText($LANG['msg_error_not_allowed']));
									$ViewVideo->setPageBlockShow('msg_form_error');
									break;

								case 'adult':
									$ViewVideo->setAllPageBlocksHide();
									$ViewVideo->setPageBlockShow('confirmation_adult_form');
									break;

								case 'flag':
									$ViewVideo->setAllPageBlocksHide();
									$ViewVideo->setPageBlockShow('confirmation_flagged_form');
									break;

								case 'video':
									$ViewVideo->changeLastViewDateAndVideoViewed();
									$ViewVideo->setPageBlockShow('videos_form');
									break;
							}
					}
			}
		else
			{
				$ViewVideo->setAllPageBlocksHide();
				$ViewVideo->setCommonErrorMsg($LANG['msg_error_sorry']);
				$ViewVideo->setPageBlockShow('msg_form_error');
			}
	}
}
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if(!isAjax())
	{
		if($ViewVideo->isShowPageBlock('add_reply'))
			{
				$ViewVideo->includeHeader();
				setTemplateFolder('general/', 'video');
				$smartyObj->display('videoAjax.tpl');
			}
	}


if($ViewVideo->isShowPageBlock('videoMainBlock') OR !$ViewVideo->validate)
{
if(!isAjax())
	{
		$LANG['meta_viewvideo_keywords'] = str_replace('{default_tags}', $CFG['html']['meta']['keywords'], $LANG['meta_viewvideo_keywords']);
		if($ViewVideo->getFormField('video_meta_keyword') != '')
			$LANG['meta_viewvideo_keywords'] = str_replace('{tags}', $ViewVideo->getFormField('video_meta_keyword'), $LANG['meta_viewvideo_keywords']);
		else
			$LANG['meta_viewvideo_keywords'] = str_replace('{tags}', $ViewVideo->getFormField('video_tags'), $LANG['meta_viewvideo_keywords']);

		$LANG['meta_viewvideo_description'] = str_replace('{default_tags}', $CFG['html']['meta']['description'], $LANG['meta_viewvideo_description']);
		if($ViewVideo->getFormField('video_meta_description') != '')
			$LANG['meta_viewvideo_description'] = str_replace('{tags}', $ViewVideo->getFormField('video_meta_description'), $LANG['meta_viewvideo_description']);
		else
			{
				$video_caption = substr($ViewVideo->getFormField('video_caption'), 0, $CFG['fieldsize']['video_meta_description']['max']);
				$LANG['meta_viewvideo_description'] = str_replace('{tags}', $video_caption, $LANG['meta_viewvideo_description']);
			}

		$LANG['meta_viewvideo_title'] = str_replace('{site_title}', $CFG['site']['title'], $LANG['meta_viewvideo_title']);
		$LANG['meta_viewvideo_title'] = str_replace('{module}', $LANG['window_title_video'], $LANG['meta_viewvideo_title']);
		if($ViewVideo->getFormField('video_page_title') != '')
			$LANG['meta_viewvideo_title'] = str_replace('{title}', $ViewVideo->getFormField('video_page_title'), $LANG['meta_viewvideo_title']);
		else
			$LANG['meta_viewvideo_title'] = str_replace('{title}', $ViewVideo->getFormField('video_title'), $LANG['meta_viewvideo_title']);

		setPageTitle($LANG['meta_viewvideo_title']);
		setMetaKeywords($LANG['meta_viewvideo_keywords']);
		setMetaDescription($LANG['meta_viewvideo_description']);

		$thumbnail_folder = $CFG['media']['folder'].'/'.$CFG['admin']['videos']['folder'].'/'.$CFG['admin']['videos']['thumbnail_folder'].'/';
		if($ViewVideo->getFormField('is_external_embed_video')=='Yes')
   	  		{
				if($ViewVideo->getFormField('embed_video_image_ext')=='')
					{
						$video_url = $CFG['site']['url'].'design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/external_video.jpg';
					}
				else
					{
						$video_url = $ViewVideo->getFormField('video_server_url').$thumbnail_folder.getVideoImageName($ViewVideo->getFormField('video_id')).$CFG['admin']['videos']['small_name'].'.'.$ViewVideo->getFormField('embed_video_image_ext');
					}
			}
		else
			{
				$video_url = $ViewVideo->getFormField('video_server_url').$thumbnail_folder.getVideoImageName($ViewVideo->getFormField('video_id')).$CFG['admin']['videos']['small_name'].'.'.$CFG['video']['image']['extensions'];
			}
		$smartyObj->assign('video_url', $video_url);

		if($ViewVideo->validate)
			{

				$ViewVideo->isMember		= isMember();
				$ViewVideo->populateCommentOptionsVideo();
				$ViewVideo->videoTitle		= $ViewVideo->getFormField('video_title');
				$ViewVideo->user_title		= ($ViewVideo->getFormField('user_name'))?$ViewVideo->getFormField('user_name').$LANG['viewvideo_title']:'';
				$ViewVideo->memberviewVideoUrl=$ViewVideo->flaggedVideoUrl	= getUrl('viewvideo','?video_id='.$ViewVideo->getFormfield('video_id').'&title='.$ViewVideo->changeTitle($ViewVideo->getFormfield('video_title')).'&flagged_content=show', $ViewVideo->getFormfield('video_id').'/'.$ViewVideo->changeTitle($ViewVideo->getFormfield('video_title')).'/?flagged_content=show','members','video');
				//when the video is flagged and is playing playlist or quick mix, need to add those to the QString
				$additional_qs = '';
				if($ViewVideo->getFormField('play_list'))
				{
					$additional_qs = '&amp;vpkey='.$ViewVideo->getFormField('vpkey').'&amp;album_id='.$ViewVideo->getFormField('album_id').'&amp;play_list='.$ViewVideo->getFormField('play_list');
				 	if($ViewVideo->getFormField('play_list') == 'pl')
				 	{
				 		$additional_qs .= '&playlist_id='.$ViewVideo->getFormField('playlist_id');
					}
					$additional_qs .= ($ViewVideo->getFormField('order'))? '&amp;order='.$ViewVideo->getFormField('order') : '';
					$ViewVideo->flaggedVideoUrl	                           = getUrl('viewvideo','?video_id='.$ViewVideo->getFormfield('video_id').'&title='.$ViewVideo->changeTitle($ViewVideo->getFormfield('video_title')).'&flagged_content=show'. $additional_qs, $ViewVideo->getFormfield('video_id').'/'.$ViewVideo->changeTitle($ViewVideo->getFormfield('video_title')).'/?flagged_content=show'.$additional_qs,'members','video');
					//echo $ViewVideo->flaggedVideoUrl;
				}

				$ViewVideo->relatedUrl		= $CFG['site']['video_url'].'viewVideo.php';

				$ViewVideo->favorite		= $ViewVideo->getFavorite();
				$ViewVideo->featured		= $ViewVideo->getFeatured();
				$ViewVideo->playlistUrl		= $ViewVideo->flaggedVideoUrl;

				$ViewVideo->editVideoUrl	= getUrl('videouploadpopup', '?video_id='.$ViewVideo->getFormField('video_id'), $ViewVideo->getFormField('video_id').'/', 'members', 'video');


				//User image..
				$ViewVideo->memberProfileImgSrc['icon'] = getMemberAvatarDetails($ViewVideo->getFormField('user_id'));
				$ViewVideo->memberProfileUrl= getMemberProfileUrl($ViewVideo->getFormField('user_id'), $ViewVideo->getUserDetail('user_id', $ViewVideo->getFormField('user_id'), 'user_name'));

				$folder='';
				if($CFG['admin']['videos']['download_previlages']=='members' && isLoggedin())
					$folder='members';

				$ViewVideo->flvDownloadUrl	= getUrl($ViewVideo->getDownloadFileName(),'?video_id='.$ViewVideo->getFormField('video_id').'&video_type=flv', 'flv/'.$ViewVideo->getFormField('video_id').'/',$folder,'video');
				$ViewVideo->notLoginVideoUrl = getUrl('viewvideo','?mem_auth=true&video_id='.$ViewVideo->getFormfield('video_id').'&title='.$ViewVideo->changeTitle($ViewVideo->getFormfield('video_title')), $ViewVideo->getFormfield('video_id').'/'.$ViewVideo->changeTitle($ViewVideo->getFormfield('video_title')).'/?mem_auth=true', '','video');
				$viewVideo_Url = '<a href="'.$ViewVideo->notLoginVideoUrl.'">'.$LANG['login'].'</a>';
				$member_join_msg = '';
				$member_join_msg = str_replace('{site_link}', '<a href="'.getUrl('signup', '', '', 'root').'">'.$CFG['site']['name'].'</a>', $LANG['member_join_msg']);
				$ViewVideo->member_join_msg = str_replace('{login_link}', $viewVideo_Url, $member_join_msg);

				### TOT DO NEED TO PLACCE REFFER URL #####
				$ViewVideo->viewVideoEmbedUrl=getUrl('viewvideo','?video_id='.$ViewVideo->getFormField('video_id').'&title='.$ViewVideo->changeTitle($ViewVideo->getFormField('video_title')), $ViewVideo->getFormField('video_id').'/'.$ViewVideo->changeTitle($ViewVideo->getFormField('video_title')).'/', '','video');
				$ViewVideo->screenShot = $ViewVideo->getThumbImage();

			if ($ViewVideo->isShowPageBlock('confirmation_adult_form'))
				{
					$ViewVideo->acceptAdultVideoUrl		= getUrl('viewvideo','?video_id='.$ViewVideo->getFormfield('video_id').'&title='.$ViewVideo->changeTitle($ViewVideo->getFormfield('video_title')).'&', $ViewVideo->getFormfield('video_id').'/'.$ViewVideo->changeTitle($ViewVideo->getFormfield('video_title')).'/?action=accept&vpkey='.$ViewVideo->getFormfield('vpkey'), 'members','video');
					$ViewVideo->acceptThisAdultVideoUrl	= getUrl('viewvideo','?video_id='.$ViewVideo->getFormfield('video_id').'&title='.$ViewVideo->changeTitle($ViewVideo->getFormfield('video_title')).'&', $ViewVideo->getFormfield('video_id').'/'.$ViewVideo->changeTitle($ViewVideo->getFormfield('video_title')).'/?action=view&vpkey='.$ViewVideo->getFormfield('vpkey'),'','video');
					$ViewVideo->rejectAdultVideoUrl		= getUrl('viewvideo','?video_id='.$ViewVideo->getFormfield('video_id').'&title='.$ViewVideo->changeTitle($ViewVideo->getFormfield('video_title')).'&', $ViewVideo->getFormfield('video_id').'/'.$ViewVideo->changeTitle($ViewVideo->getFormfield('video_title')).'/?action=reject&vpkey='.$ViewVideo->getFormfield('vpkey'),'members','video');
					$ViewVideo->rejectThisAdultVideoUrl	= getUrl('index','','');
				}
			if ($ViewVideo->isShowPageBlock('videos_form') and $ViewVideo->validate)
				{
					$ViewVideo->displayVideo();
					$profile_blog_text = '<a href=\''.getUrl('profileblog','?video_id='.$ViewVideo->getFormfield('video_id'), '?video_id='.$ViewVideo->getFormfield('video_id'), 'members','video').'\'>'.$LANG['viewvideo_setup_new_blog'].'</a>';
					$ViewVideo->LANG['viewvideo_blog_post_info'] = str_replace('{setup_new_blog}', $profile_blog_text, $LANG['viewvideo_blog_post_info']);
					$ViewVideo->LANG['viewvideo_no_blog_msg'] = str_replace('{setup_new_blog}', $profile_blog_text, $LANG['viewvideo_no_blog_msg']);
					if(isMember())
						{
							$ViewVideo->videos_form['getBlogList'] = $ViewVideo->getBlogList();
						}
						if($ViewVideo->chkBlogAdded())
						{
							$ViewVideo->videos_form['no_blog_added']=' style="display:none;"';
					    	$ViewVideo->videos_form['blog_added']=' style="display:block;"';
						}
						else
						{
							$ViewVideo->videos_form['no_blog_added']=' style="display:block;"';;
                            $ViewVideo->videos_form['blog_added']=' style="display:none;"';
						}
				}
			$ViewVideo->video_response_links=$ViewVideo->chkVideoResponse();
		}
		else
		{


			if($ViewVideo->chkIsPrivateVideo($ViewVideo->getFormField('video_id')))
			{
                Redirect2URL($ViewVideo->getUrl('videolist','?pg=privatevideo', 'privatevideo/','','video'));
				$LANG['msg_error_sorry'] = $LANG['msg_private_video'];
			}

			$ViewVideo->setCommonErrorMsg($LANG['msg_error_video_notfound']);
			$ViewVideo->setPageBlockShow('msg_form_error');
		}
		//include the header file
		$ViewVideo->includeHeader();

if(!isAjax())
	{
		if($ViewVideo->isShowPageBlock('add_reply') OR $ViewVideo->isShowPageBlock('block_add_comments'))
			{
				$ViewVideo->replyCommentId=$ViewVideo->getFormField('comment_id');
				$ViewVideo->replyUrl=$CFG['site']['video_url'].'viewVideo.php?ajax_page=true&video_id='.$ViewVideo->getFormField('video_id').'&vpkey='.$ViewVideo->getFormField('vpkey').'&show='.$ViewVideo->getFormField('show');
				?>
				<script language="javascript" type="text/javascript">
				<?php if($CFG['admin']['videos']['captcha']
							AND $CFG['admin']['videos']['captcha_method'] == 'recaptcha'
								AND $CFG['captcha']['public_key'] AND $CFG['captcha']['private_key'])
						{
				?>
				var captcha_recaptcha = true;
				<?php
						}
				?>
				</script>
				<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['video_url'];?>js/light_comment.js"></script>
				<script language="javascript" type="text/javascript">
					var no_comment_error_msg = "<?php echo $LANG['common_noComment_errorMsg'];?>";
					var dontUse = 0;
					var replyUrl="<?php echo $ViewVideo->replyUrl;?>";
					var reply_comment_id="<?php echo $ViewVideo->replyCommentId;?>";;
					var reply_user_id="<?php echo $CFG['user']['user_id'];?>";
					var owner="<?php echo $CFG['user']['user_id'];?>";
				</script>
				<?php
			}
	}
	?>
	<script type="text/javascript" src="<?php echo $CFG['site']['video_url'];?>js/viewVideo.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['video_url'];?>js/functions.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['video_url'];?>js/videoComment.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['video_url'];?>js/shareVideo.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/AG_ajax_html.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
	<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/tooltip.js"></script>
	<script type="text/javascript">
	var video_id="<?php echo $ViewVideo->getFormField('video_id');?>";
	var playerActualHeight=512;
	var playerActualWidth=642;
	var kinda_comment_msg = "<?php echo $LANG['comment_approval']; ?>";
	function chkValidHeightAndWidth(ele)
		{

			flash_content_div_width = $Jq('#flashcontent2').css('width');
			flash_content_div_height = $Jq('#flashcontent2').css('height');

			height=parseInt($Jq(ele).css('height'));
			width=parseInt($Jq(ele).css('width'));
			if((height>playerActualHeight || width >playerActualWidth))
				{

					$Jq(ele).css('height', playerActualHeight);
					$Jq(ele).css('width', playerActualWidth);
				}
		}
	function chkExtenalEmbededHeightAndWidth()
	  {
		var embeded_ele=$Jq('#flashcontent2 embed').length;
		if(embeded_ele)
			{
				$Jq('#flashcontent2 embed').each(function(ele)
					{
					   	chkValidHeightAndWidth($Jq(this));
					});
			}
		object_ele=$Jq('#flashcontent2 object').length;
		if(object_ele)
			{

				$Jq('#flashcontent2 object').each(function(ele)
					{
					   	chkValidHeightAndWidth($Jq(this));
					});

			}
	  }
	</script>
	<?php
	//include the content of the page
	setTemplateFolder('general/','video');
	$smartyObj->display('viewVideo.tpl');
	//includ the footer of the page
	//<<<<<<--------------------Page block templates Ends--------------------//

?>
<script language="javascript" type="text/javascript">
	var site_url = '<?php echo $CFG['site']['url'];?>';
	var enabled_edit_fields = new Array();
	var template_default = '<?php echo $CFG['html']['template']['default']; ?>';
	var stylesheet_default = '<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>';
	var block_arr = new Array('selEditVideoComments',
	 'clsDownloadSectionThis','clsVideoRenders', 'selVideoResposeLinks', 'selMsgConfirm',
	 'selUploadingDialog',
	 'selMsgConfirm', 'selUploadingDialog',  'selEditVideoComments', 'selMsgAddNewBlog', 'selMsgLoginConfirmMulti', 'selMsgConfirmCommon', 'flagDiv', 'blogDiv');
	var viewvideo_codes_to_display = "<?php echo $LANG['viewvideo_codes_to_display'];?>";
	var viewvideo_session_expired = "<?php echo $LANG['viewvideo_session_expired'];?>";
	var viewvideo_close_code = "<?php echo $LANG['viewvideo_close_code'];?>";
	var total_images = "<?php echo  $CFG['admin']['total_rating'];?>";
	var replace_url = '<?php echo getUrl('login','','');?>';
	var minimum_counts = <?php echo $CFG['admin']['videos']['total_comments'];?>;
	var deleteConfirmation = "<?php echo $LANG['delete_confirmation'];?>";
	var download_count = <?php echo $ViewVideo->getFormField('total_downloads');?>;
	var curr_video_id='';
	var curr_sel_video_id='';
	var currUrl = '<?php echo getUrl('viewvideo','?video_id='.$ViewVideo->getFormField('video_id'), $ViewVideo->getFormField('video_id').'/','','video');?>';
	var favoriteUrl="<?php echo $ViewVideo->favorite['url'];?>";
	var featuredAlready = "<?php echo $ViewVideo->chkVideoFeaturedAlreadyAdded();?>";
	var featuredUrl="<?php echo $ViewVideo->featured['url'];?>";
	var curr_side_bar_pg='tag';
	var featuredDeleteConfirmation = "<?php echo $LANG['viewview_featured_delete_confimation'];?>";
	var rateimage_url = "<?php echo $CFG['site']['video_url'].'design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/icon-viewvideorate.gif';?>";
	var rateimagehover_url = "<?php echo $CFG['site']['video_url'].'design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/icon-viewvideoratehover.gif';?>";
	var downloadUrl='';
	var loading="<div class='clsLoader'><img src='"+site_url+"/video/design/templates/"+template_default+"/root/images/<?php echo $CFG['html']['stylesheet']['screen']['default']; ?>/viewvideo_loader.gif"+"' alt='<?php echo $LANG['loading'];?>'\/>  <?php echo $LANG['loading'];?><\/div>";
	var embed_code_js = '<?php echo $ViewVideo->embeded_code_js; ?>';
	var embed_code_default = '<?php echo $ViewVideo->embeded_code_default; ?>';
	var featured_added = '<?php if($ViewVideo->featured['added']=='') echo '1'; else echo ''; ?>';
	var favorite_added = '<?php if($ViewVideo->favorite['added']=='') echo '1'; else echo ''; ?>';

	function setDesicriptionHeight()
	{
		 //if($Jq('HvideoCaption').getDimensions().height>=50)
		 //{
		 	//$Jq('HvideoCaption').addClass('clsMainVideoDescription');
		 //}

	}
	function popupWindow(url){
		 window.open (url, "","status=0,toolbar=0,resizable=0,scrollbars=1");
		 return false;
	}
	function setClass(li_id, li_class){
		document.getElementById(li_id).setAttribute('className',li_class);
		document.getElementById(li_id).setAttribute('class',li_class);
	}
	function showDiv(element)
		{
			if(obj = document.getElementById(element))
				obj.style.display = '';
		}
	function hideDiv(element){
		if(obj = document.getElementById(element))
			obj.style.display = 'none';
	}

	function updateVideosQuickLinksCount(video_id, pg)
		{
			var url = '<?php echo $CFG['site']['video_url'];?>videoUpdateQuickLinks.php';
			var pars = '?video_id='+video_id;
			var path=url+pars;
			curr_side_bar_pg=pg;
			curr_video_id=video_id;
			jquery_ajax(path, '', 'getQuickLinkCode');
			refreshSideBarLinks(video_id, 'deactivate');
		}

	function getQuickLinkCode(data)
		{

			if($Jq('#quick_link_tag_'+curr_video_id+'_add'))
				{
					$Jq('#quick_link_tag_'+curr_video_id+'_add').hide();
					$Jq('#quick_link_tag_'+curr_video_id+'_added').show();
				}
			if($Jq('#quick_link_user_'+curr_video_id+'_add'))
				{
					$Jq('#quick_link_user_'+curr_video_id+'_add').hide();
					$Jq('#quick_link_user_'+curr_video_id+'_added').show();
				}
			if($Jq('quick_link_top_'+curr_video_id+'_add'))
				{
					$Jq('#quick_link_top_'+curr_video_id+'_add').hide();
					$Jq('#quick_link_top_'+curr_video_id+'_added').show();
				}

			if($Jq('selQuickList'))
			{

				 addBlocksForQuickLinks();
			}
			else
			{

				   moreVideosQuickList();
			}

		}

	function deleteVideoQuickLinks(video_id)
		{
			var url = '<?php echo $CFG['site']['video_url'];?>videoUpdateQuickLinks.php';
			var pars = '?video_id='+video_id+'&remove_it';
			var path=url+pars;
			curr_sel_video_id=video_id;
			jquery_ajax(path, '', 'hideQuickLinkCode');
			refreshSideBarLinks(video_id, 'activate');
		}

	function hideQuickLinkCode(data)
		{
			//alert('quick_list_selected_'+curr_sel_video_id);
			hideDiv('quick_list_selected_'+curr_sel_video_id);
			removeElement('quick_list_selected_'+curr_sel_video_id);
		}

	function removeElement(divNum)
		{
		  var d = document.getElementById('selQuickList');
		  var olddiv = document.getElementById(divNum);
		  d.removeChild(olddiv);
		}

	function addBlocksForQuickLinks()
		{

			var pars = '&ajax_page=1&show_qucik_link_text_id='+curr_video_id;
			$Jq.ajax({
			type: "GET",
			url: currUrl,
			data: pars,
			success: refreshQucikLinkBlockTag
		 });
		 }

	function refreshQucikLinkBlockTag(resp)
		{
			data = unescape(resp);
			$Jq('#selQuickList').html(data);
			//listen_balloon_using_container('#selQuickList a');
		}

	function moreVideosQuickList()
		{

			var pars = '&ajax_page=1&show_complete_quick_list=1';
			$Jq.ajax({
				type: "GET",
				url: currUrl,
				data: pars,
				success: refreshQucikLinkBlockTagAll
		    });
		}

	function refreshQucikLinkBlockTagAll(resp)
	{
			data = unescape(resp);
			$Jq('#selVideoQuickLinks').html(data);
			listen_balloon_using_container('#selVideoQuickLinks a');
			jquery_ajax(path, '', 'hideQuickLinkCode');
	}

	function refreshSideBarLinks(video_id, action)
		{
			if(action=='activate')
				{
					if($Jq('#quick_link_tag_'+curr_video_id+'_add'))
						{
							$Jq('#quick_link_tag_'+curr_video_id+'_added').hide();
							$Jq('#quick_link_tag_'+curr_video_id+'_add').show();
						}
					if($Jq('#quick_link_user_'+curr_video_id+'_add'))
						{
							$Jq('#quick_link_user_'+curr_video_id+'_added').hide();
							$Jq('#quick_link_user_'+curr_video_id+'_add').show();
						}
					if($Jq('#quick_link_top_'+curr_video_id+'_add'))
						{
							$Jq('#quick_link_top_'+curr_video_id+'_added').hide();
							$Jq('#quick_link_top_'+curr_video_id+'_add').show();
						}
				}
			else
				{
					if($Jq('#quick_link_tag_'+curr_video_id+'_add'))
						{
							$Jq('#quick_link_tag_'+curr_video_id+'_add').hide();
							$Jq('#quick_link_tag_'+curr_video_id+'_added').show();
						}
					if($Jq('#quick_link_user_'+curr_video_id+'_add'))
						{
							$Jq('#quick_link_user_'+curr_video_id+'_add').hide();
							$Jq('#quick_link_user_'+curr_video_id+'_added').show();
						}
					if($Jq('#quick_link_top_'+curr_video_id+'_add'))
						{
							$Jq('#quick_link_top_'+curr_video_id+'_add').hide();
							$Jq('#quick_link_top_'+curr_video_id+'_added').show();
						}
				}
			$Jq('#balloon').hide();
		}

	function toggleOnViewClearQuickList(obj)
		{
			var url = '<?php echo $CFG['site']['video_url'];?>videoUpdateQuickLinks.php';
			if(obj.checked)
				var pars = '?clear_on_view=1';
				else
					var pars = '?clear_on_view=0';
			var path=url+pars;

			//new AG_ajax(path,'setToggleQuickList');
			jquery_ajax(path, '', 'setQuickClearList');
		}

	function clearQuickLinks()
		{
			var url = '<?php echo $CFG['site']['video_url'];?>videoUpdateQuickLinks.php';
			var pars = '?clear_list=1';
			var path=url+pars;
			//alert(path);
			jquery_ajax(path, '', 'setQuickClearList');

		}

	function setQuickClearList(resp)
		{

			$Jq('#selVideoQuickLinks').show();
			//$Jq('#balloon').hide();
		}

	function setToggleQuickList(resp)
		{
			return true;
		}

	function postVideoResponse()
		{
			var video_resp_url='<?php echo $CFG['site']['video_url'].'videoResponsePopUp.php?video_id='.$ViewVideo->getFormField('video_id');?>';
			var pars = 'ajax_page=1';
			//var path=video_resp_url+'&'+pars;
			//new prototype_ajax(path,'setVideoRespose');
			$Jq.ajax({
				type: "GET",
				url: video_resp_url,
				data: pars,
				success: setVideoRespose
			 });
			//new Ajax.Request(video_resp_url, {method:'post',parameters:'&ajax_page=1', onComplete:setVideoRespose,evalJS:true,evalScripts:true});
		}

	function setVideoRespose(resp)
		{
			data = unescape(resp);
			/*alert(data.indexOf('type="text/javascript"'));
			if(data.indexOf('type="text/javascript"') > 1);
				alert('Test');
			return false;*/
			//alert(data);
			//setAndExecute('selVideoResposeLinks', data);
			$Jq('#selVideoResposeLinks').html(data);
			//$('selVideoResposeLinks').innerHTML.evalScripts();
			Confirmation('selVideoResposeLinks', '', Array(), Array(), Array(), 0, 0, 'anchor_video_response_block');
		}

	var ConfirmationBlock = function(){
		var obj, inc, form_field;
		hideAllBlocks();

		var place = arguments[0];
		var block = arguments[1];
		var add_left_position = arguments[2];
		var add_top_position = arguments[3];
		if(fromObj = $Jq('#'+block))
			changePosition(fromObj, $(place), add_top_position, add_left_position);
		return false;
	}
var vLoader_res = 'loaderVideos_res';
var homeUrl_res = '<?php echo $CFG['site']['video_url'].'videoResponsePopUp.php?video_id='.$ViewVideo->getFormField('video_id');?>';
var pars= 'vLeft=&vFetch=';
var curr_slide_pg='';
var playlist_video_id_arr = new Array();

function moveVideoSetToLeft_res(buttonObj, pg)
{
	if(pg=='tag')
		var pars= 'vTagLeft_res=&vTagFetch_res=';
	if(pg=='user')
		var pars= 'vUserLeft_res=&vUserFetch_res=';
	if(pg=='top')
		var pars= 'vTopLeft_res=&vTopFetch_res=';
	if(pg=='resp')
		var pars= 'vRespLeft=&vRespFetch_res=';

	if(buttonObj.className ==disPrevButton)
	{
		return false;
	}
	videoSlider_res(pars, pg);
}
var button_id = '';
function moveVideoSetToRight_res(buttonObj, pg){

	//alert('RIGHT----'+pg);
	if(pg=='tag')
		var pars= 'vTagRight_res=&vTagFetch_res=';
	if(pg=='user')
		var pars= 'vUserRight_res=&vUserFetch_res=';
	if(pg=='top')
		var pars= 'vTopRight_res=&vTopFetch_res=';
	if(pg=='resp')
		var pars= 'vRespRight=&vRespFetch_res=';

	if(buttonObj.className ==disNextButton){
		return false;
	}
	button_id = 'videoNextButton_'+pg;
	//document.getElementById(button_id).disabled = true;
	videoSlider_res(pars, pg);
}

function videoSlideShow_res(video_id, pg)
	{
		//ConfirmationBlock('anchor','slideShowBlock',300,200);
		curr_slide_pg=pg;
		var pars = 'ajax_page=1&process_slide=1&video_id='+video_id+'&curr_slide='+curr_slide_pg;
        $Jq.ajax({
			type: "GET",
			url: homeUrl_res,
			data: pars,
			success: slideShowProcess_res
		 });
		return;
	}

function slideShowProcess_res(resp)
	{
		if($Jq(button_id))
		$Jq(button_id).css('display', 'none');
		data = unescape(resp);
		$Jq('#slideShowBlock_'+curr_slide_pg).html(data);
		//ConfirmationBlock_res('slideShowBlock_anchor','slideShowBlock',-300,-200);
	}

function videoSlider_res(pars, pg)
	{
		if(pg=='resp')
			{
				showDiv('loaderRespVideos');
				var par = '&ajax_page=1&video_id=<?php echo $ViewVideo->getFormField('video_id'); ?>';
				var param=pars+par;
				new jquery_ajax(homeUrl_res, param, 'refreshVideoBlockResp_res');
				return;
			}

		showDiv('loaderVideos_res');
		if(pg=='tag')
	    {
			var par = '&ajax_page=1&video_id=<?php echo $ViewVideo->getFormField('video_id'); ?>&video_tags=<?php echo $ViewVideo->getFormField('video_tags') ?>';
	    	var param=pars+par;
			new jquery_ajax(homeUrl_res, param, 'refreshVideoBlockTag_res');
		}
		if(pg=='user')
		{
			var par= '&ajax_page=1&video_id=<?php echo $ViewVideo->getFormField('video_id'); ?>&user_id=<?php echo $ViewVideo->getFormField('user_id') ?>';
	        var param=pars+par;
			new jquery_ajax(homeUrl_res, param, 'refreshVideoBlockUser_res');
		}
		if(pg=='top')
		{
			var par = '&ajax_page=1&video_id=<?php echo $ViewVideo->getFormField('video_id'); ?>';
			var param=pars+par;
			new jquery_ajax(homeUrl_res, param, 'refreshVideoBlockTop_res');
		}
	}

refreshVideoBlockTag_res = function(resp)
	{
		data = unescape(resp);
		$Jq('#selRelatedContent_res').html(data);
		$Jq('#loaderVideos_res').css('display', 'none');
	}

refreshVideoBlockTop_res = function(resp)
	{
		data = unescape(resp);
		//alert(resp.responseText);
		//$('selTopContent_res').innerHTML='';
		$Jq('#selTopContent_res').html(data);
		$Jq('#loaderVideos_res').css('display', 'none');
	}
refreshVideoBlockUser_res = function(resp)
	{
		data = unescape(resp);
		//alert(resp.responseText)
		$Jq('#selUserContent_res').html(data);
		$Jq('#loaderVideos_res').css('display', 'none');
	}

refreshVideoBlockResp_res = function(resp)
	{
		data = unescape(resp);
		$Jq('#selUserContent_resResp').html(data);
		$Jq('#loaderRespVideos').css('display', 'none');
	}

//Display confirmation Block
//place, block, add_top_position, add_left_position --- optional
var ConfirmationBlock_res = function(){
	var obj, inc, form_field;
	hideAllBlocks();

	var place = arguments[0];
	var block = arguments[1];
	var add_left_position = arguments[2];
	var add_top_position = arguments[3];
	if(fromObj = $(block))
		changePosition(fromObj, $(place), add_top_position, add_left_position);
	return false;
}
</script>
<script language="javascript" type="text/javascript">
	var max_timer = <?php echo $CFG['admin']['videos']['comment_edit_allowed_time'];?>;
	var dontUse = 0;
</script>
<script language="javascript" type="text/javascript">
var vLoader = 'loaderVideos';

var homeUrl = '<?php echo getUrl('viewvideo','?video_id='.$ViewVideo->getFormField('video_id'), $ViewVideo->getFormField('video_id').'/','','video');?>';
var disPrevButton = 'disabledPrevButton';
var disNextButton = 'disabledNextButton';
var pars= 'vLeft=&vFetch=';

var maxiPlayerWidth="<?php echo $CFG['admin']['videos']['maximum_player_width']?>px";
var maxiPlayerHeight="<?php echo $CFG['admin']['videos']['maximum_player_height']?>px";
var miniPlayerWidth="<?php echo $CFG['admin']['videos']['minimum_player_width']?>px";
var miniPlayerHeight="<?php echo $CFG['admin']['videos']['minimum_player_height']?>px";
var embed_req ="<?php echo $LANG['viewvideo_embed_required'];?>";
var embed_int ="<?php echo $LANG['viewvideo_embed_integers'];?>";

function moveVideoSetToLeft(buttonObj, pg)
{
	if(pg=='tag')
		var pars= 'vTagLeft=&vTagFetch=';
	if(pg=='user')
		var pars= 'vUserLeft=&vUserFetch=';
	if(pg=='top')
		var pars= 'vTopLeft=&vTopFetch=';
	if(pg=='resp')
		var pars= 'vRespLeft=&vRespFetch=';

	if(buttonObj.className ==disPrevButton)
	{
		return false;
	}
	videoSlider(pars, pg);
}
var morevideo_button_id = '';
function moveVideoSetToRight(buttonObj, pg){

	//alert('RIGHT----'+pg);
	if(pg=='tag')
		var pars= 'vTagRight=&vTagFetch=';
	if(pg=='user')
		var pars= 'vUserRight=&vUserFetch=';
	if(pg=='top')
		var pars= 'vTopRight=&vTopFetch=';
	if(pg=='resp')
		var pars= 'vRespRight=&vRespFetch=';

	if(buttonObj.className ==disNextButton){
		return false;
	}
	morevideo_button_id = 'videoNextButton_'+pg;
    $Jq('#'+morevideo_button_id).attr("disabled","disabled");
	videoSlider(pars, pg);
}
function videoSlider(pars, pg)
	{
		if(pg=='resp')
			{
				var par = '&ajax_page=1&video_id=<?php echo $ViewVideo->getFormField('video_id'); ?>';
				var param=pars+par;
				showDiv('loaderRespVideos');
				new jquery_ajax(homeUrl, param, 'refreshVideoBlockResp');
				return;
			}
		 $Jq('#relatedVideoContent').html($Jq('#loaderVideos').html());
		//showDiv(''');
		if(pg=='tag')
		{
            var par= '&ajax_page=1&video_id=<?php echo $ViewVideo->getFormField('video_id'); ?>&video_tags=<?php echo $ViewVideo->getFormField('video_tags') ?>';
            var param=pars+par;
            new jquery_ajax(homeUrl, param, 'refreshVideoBlock');
		}
		if(pg=='user')
		{
		   var par= '&ajax_page=1&video_id=<?php echo $ViewVideo->getFormField('video_id'); ?>&user_id=<?php echo $ViewVideo->getFormField('user_id') ?>';
           var param=pars+par;
		   new jquery_ajax(homeUrl, param, 'refreshVideoBlock');
		}
		if(pg=='top')
	    {
			var par = '&ajax_page=1&video_id=<?php echo $ViewVideo->getFormField('video_id'); ?>';
			var param=pars+par;
			new jquery_ajax(homeUrl, param, 'refreshVideoBlock');
		}
	}

function refreshVideoBlock(resp)
	{
		$Jq('#'+morevideo_button_id).removeAttr("disabled");
		data=resp
		$Jq('#relatedVideoContent').html(data);
		$Jq('#selNextPrev_top').html($Jq('#selNextPrev').html());
	}

refreshVideoBlockResp = function(resp)
	{
		data = unescape(resp);
		$Jq('#selUserContentResp').html(data);
		//$('selUserContent').update(resp.responseText);
		hideDiv('loaderRespVideos');
	}

function enlargeVideoPlayer()
{

	if($Jq('#maximisePlayer').hasClass('clsMaximisePlayer'))
	{
		$Jq('#videoPlayerSection').removeClass('clsSmallVideo');
		$Jq('#videoPlayerSection').addClass('clsLargeVideo');
		$Jq('#maximisePlayer').removeClass('clsMaximisePlayer');
		$Jq('#maximisePlayer').addClass('clsMinimisePlayer');
		$Jq('#maximisePlayer').title='<?php echo $LANG['viewvideo_min_player_tooltip'];?>';
		<?php
		if(!$ViewVideo->checkIsExternalEmebedCode())
		{?>
		$Jq('#flvplayer').writeAttribute('width',maxiPlayerWidth);
		$Jq('#flvplayer').writeAttribute('height',maxiPlayerHeight);
		<?php }?>
	}
	else
	{
		$Jq('#videoPlayerSection').removeClass('clsLargeVideo');
		$Jq('#videoPlayerSection').addClass('clsSmallVideo');
		$Jq('#maximisePlayer').removeClass('clsMinimisePlayer');
		$Jq('#maximisePlayer').addClass('clsMaximisePlayer');
		$Jq('#maximisePlayer').title='<?php echo $LANG['viewvideo_max_player_tooltip'];?>';
		<?php
		if(!$ViewVideo->checkIsExternalEmebedCode())
		{?>
		$Jq('#flvplayer').writeAttribute('width',miniPlayerWidth);
		$Jq('#flvplayer').writeAttribute('height',miniPlayerHeight);
		<?php }?>
	}
}

var playlist_opt;
function populateMyPlayList(url, opt){
	playlist_opt = opt;
	return openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', url, 'action=popplaylist&mem_auth=true', 'populateMyPlayListResponse');
}
function populateMyPlayListResponse(html){
	data = unescape(html);
	if(data.indexOf('ERR~')>=1)
	{
		data = data.replace('ERR~','');
		$Jq('#clsMsgDisplay_playlist_success').html(data);
		$Jq('#clsMsgDisplay_playlist_success').show();
		return false;
	}

	if(data.indexOf('selLogin') > 0)
	{
		$Jq('#loginDiv').html(html);
		Confirmation('loginDiv', 'selFormLogin', Array(), Array(), Array());
	}
else
	{
		$Jq('#selMyPlayListOpt').html(html);
		if(playlist_opt == 'create'){
			jQuery("select#playlist option[selected]").removeAttr("selected");
			jQuery("select#playlist option[value='#new#']").attr("selected", "selected");
			$Jq('#createNewPlaylist').show();
		}
		else{
			$Jq('#createNewPlaylist').hide();
		}
		Confirmation('playlistDiv', 'playlistfrm', Array(), Array(), Array());
   }
}
var addBlogSuccess ="<?php echo $LANG['viewvideo_posted_your_blog'];?>";
var addBlogFailure ="<?php echo $LANG['mandatory_fields_compulsory'];?>";

function postThisVideo(){
	var blog_text = $Jq('#blog_post_text').val();
	var blog_post_title = $Jq('#blog_post_title').val();
	var blog_title=$Jq('#blog_title').val();

	if(blog_text && blog_title){
		blog_post_title=encodeURIComponent(blog_post_title);
		blog_title=encodeURIComponent(blog_title);
		blog_text = encodeURIComponent(blog_text);
		var url = '<?php echo $CFG['site']['url'].'video/viewVideo.php';?>';
		var pars = 'video_id=<?php echo $ViewVideo->getFormField('video_id');?>&action=post_blog&blog_post_text='+blog_text+'&blog_post_title='+blog_post_title+'&blog_title='+blog_title;
		$Jq('#selAddNewBlogSuccess').html(loading);
		$Jq('#selAddNewBlogSuccess').show();
		openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', url, pars, 'addBlogResult');
		hideAllBlocks();
	}
	else{
		$Jq('#selAddNewBlogFailure').css('display',  '');
		$Jq('#selAddNewBlogFailure').html('<p>'+addBlogFailure+'<\/p>');
	}
}

function addBlogResult(resp){
	$Jq('#selAddNewBlogSuccess').html('<p>'+addBlogSuccess+'<\/p>');
	return;
}

function updateBlogTitle(html){

	data = unescape(html);
	if(data.indexOf('ERR~')>=1)
	{
		data = data.replace('ERR~','');
		$Jq('#selAddNewBlogSuccess').html(data);
		$Jq('#selAddNewBlogSuccess').show();
		return false;
	}
	$Jq('#selBlogTitle').html(html);
	Confirmation('blogDiv', 'formMsgAddNewBlog', Array(), Array(), Array());
}

var customizeEmbedOptions = function()
	{
		if(arguments[0] && arguments[0] == 'default')
			{
				$Jq('#image_code').val(embed_code_default);
				$Jq('#embed_width').val('');
				$Jq('#embed_height').val('');
				return true;
			}

		var embed_width = $Jq('#embed_width').val();
		var embed_height = $Jq('#embed_height').val();

		if(embed_width == '' || embed_height =='')
			{
				$Jq('#embed_error_msg').html(embed_req);
				$Jq('#embed_error_msg').show();
				return true;
			}
		else if(isNaN(embed_width) || isNaN(embed_height))
			{
				$Jq('#embed_error_msg').html(embed_int);
				$Jq('#embed_error_msg').show();
				return true;
			}
		$Jq('#embed_error_msg').hide();
		var embed_code_new = embed_code_js;
		embed_code_new = embed_code_new.replace("{$width}", embed_width);
		embed_code_new = embed_code_new.replace("{$height}", embed_height);
		$Jq('#image_code').val(embed_code_new);
		$Jq('#embed_width').val('');
		$Jq('#embed_height').val('');
		return false;
	}

$Jq("#embed_options_key").click(function(){
		$Jq('#embed_width').val('');
		$Jq('#embed_height').val('');
		$Jq('#embed_error_msg').html();
		$Jq('#embed_error_msg').hide();
		$Jq("#customize_embed_size").animate({
	      "height": "toggle"
	    }, { duration: "slow" });
    });

$Jq("#close_embed_options").click(function(){
		$Jq('#embed_width').val('');
		$Jq('#embed_height').val('');
		$Jq('#embed_error_msg').html();
		$Jq('#embed_error_msg').hide();
		$Jq("#customize_embed_size").animate({
	      "height": "toggle"
	    }, { duration: "slow" });
    });

var getViewVideoMoreContent = function()
{
	var content_id = arguments[0];
	var view_video_more_path;
	var call_viewvideo_ajax = false;
	view_video_content_id = content_id;
	playlist_video_id_arr.push(view_video_content_id);
	var div_id = 'sel'+content_id+'Content';
	var more_li_id = 'selHeader'+content_id;
	//var more_li_id = 'selHeader'+content_id;
	var div_value = $Jq('#'+div_id).html();
	div_value = $Jq.trim(div_value);

	if(content_id == 'Favorites')
		{
			call_viewvideo_ajax = true;

			if(arguments[1] == 'remove')
				{
					$Jq('#added_favorite').css('display','none');
					$Jq('#favorite_saving').css('display','block');
					var favorite_pars = '&favorite=&video_id='+video_id;
					favorite_added = 1;
				}
			else
			{
				$Jq('#add_favorite').css('display','none');
				$Jq('#favorite_saving').css('display','block');
				var favorite_pars = '&favorite='+favorite_added+'&video_id='+video_id;
				favorite_added = 0;
			}

			view_video_more_path = featuredUrl+favorite_pars;
		}
	else if(content_id == 'Featured')
		{
			call_viewvideo_ajax = true;
			if(arguments[1] == 'remove')
				{
					$Jq('#added_featured').css('display','none');
					$Jq('#featured_saving').css('display','block');
					var featured_pars = '&featured=&video_id='+video_id;
					featured_added = 1;
				}
			else
			{
				var featured_pars = '&featured='+featured_added+'&video_id='+video_id;
				$Jq('#add_featured').css('display','none');
				$Jq('#featured_saving').css('display','block');
				featured_added = 0;
			}

			view_video_more_path = favoriteUrl+featured_pars;
		}

	result_div = div_id;
	if(div_value == '' || call_viewvideo_ajax)
		{
			new jquery_ajax(view_video_more_path, '', 'insertViewVideoMoreContent');
		}

}
function insertViewVideoMoreContent(data)
{
	data = data;
	if(data.indexOf('ERR~')>=1)
		{
			if(view_video_content_id == 'Favorites')
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
			else if(view_video_content_id == 'Featured')
			{

				if(featured_added)
				{
					$Jq('#added_featured').css('display','block');
				}
				else
				{
					$Jq('#add_featured').css('display','block');
				}
				msg = '<?php echo $LANG['sidebar_login_featured_err_msg'] ?>';
			}
			memberBlockLoginConfirmation(msg,'<?php echo $ViewVideo->memberviewVideoUrl ?>');
			return false;
		}
		else if(view_video_content_id == 'Favorites')
			{
				if(favorite_added)
				{
					var favorite_added='';
					$Jq('#unfavorite').bind('click', unfavorite);
					$Jq('#clsMsgDisplay').css('display', 'none');
				}
				else
				{
					var favorite_added='1';
					$Jq('#favorite').bind('click', favorite);
					$Jq('#clsMsgDisplay').css('display', 'none');
				}

			}
		else if(view_video_content_id == 'Featured')
			{
				if(featured_added)
				{
					var featured_added='';
					$Jq('#unfeatured').bind('click', unfeatured);
					$Jq('#clsMsgDisplay').css('display', 'none');
				}
				else
				{
					var featured_added='1';
					$Jq('#featured').bind('click', featured);
					$Jq('#clsMsgDisplay').css('display', 'none');
				}
			}
}
</script>
<?php
$ViewVideo->includeFooter();
}
}
?>
