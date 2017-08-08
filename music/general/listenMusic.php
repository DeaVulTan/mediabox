<?php
/**
 * ViewMusic
 *
 * @package
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
class ViewMusic extends MusicHandler
	{
		public $captchaText = '';
		//public $listened_total_records = 0;
		//public $commentUrl ='';

		public function resultFound(){
			$musicId = $this->fields_arr['music_id'];
			$musicId = is_numeric($musicId)?$musicId:0;
			if (!$musicId)
			    $this->resultFound = false;

			$condition = 'm.music_status=\'Ok\' AND m.music_id='.$this->dbObj->Param($musicId);
			$sql = 'SELECT m.music_title, m.music_caption, music_artist,'.
						' m.total_favorites, m.total_views, m.total_plays, m.total_comments, m.total_downloads,'.
						' m.allow_comments, m.allow_embed, m.allow_ratings, m.allow_lyrics, '.
						' m.music_ext, m.music_album_id, m.playing_time,'.
						' m.music_category_id, m.music_tags, m.rating_total, m.rating_count, m.user_id, m.flagged_status, '.
						' m.music_available_formats, m.music_server_url, m.music_upload_type,m.music_url, '.
						' DATE_FORMAT(m.date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
						' m.large_width, m.large_height, thumb_width, thumb_height, small_width, small_height, '.
						' m.music_category_id, music_sub_category_id'.
						' FROM '.$this->CFG['db']['tbl']['music'].' as m'.
						' WHERE '.$condition.' LIMIT 0,1';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($musicId));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

			if($row = $rs->FetchRow())
				$this->resultFound = true;

		}

		/**
		 * ViewMusic::chkValidMusicId()
		 *
		 * @return boolean
		 */
		public function chkValidMusicId()
			{
				$musicId = $this->fields_arr['music_id'];
				$musicId = is_numeric($musicId)?$musicId:0;
				if (!$musicId)
				    {
				        return false;
				    }
				$userId = $this->CFG['user']['user_id'];

				$condition = 'm.music_status=\'Ok\' AND m.music_id='.$this->dbObj->Param($musicId).
							' AND (m.user_id = '.$this->dbObj->Param($userId).' OR'.
							' m.music_access_type = \'Public\''.$this->getAdditionalQuery('m.').')';

				$sql = 'SELECT m.music_title, m.music_caption, music_artist,'.
						' m.total_favorites, m.total_views, m.total_plays, m.total_comments, m.total_downloads,'.
						' m.allow_comments, m.allow_embed, m.allow_ratings, m.allow_lyrics, '.
						' m.music_ext, m.music_album_id, m.playing_time,'.
						' m.music_category_id, m.music_tags, m.rating_total, m.rating_count, m.user_id, m.flagged_status, '.
						' m.music_available_formats,m.music_price, m.for_sale, m.music_server_url, m.music_upload_type,m.music_url, '.
						' DATE_FORMAT(m.date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
						' m.large_width, m.large_height, thumb_width, thumb_height, small_width, small_height, '.' (m.rating_total/m.rating_count) as rating,'.
						' m.music_category_id, music_sub_category_id'.
						' FROM '.$this->CFG['db']['tbl']['music'].' as m'.
						' WHERE '.$condition.' LIMIT 0,1';


				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($musicId, $userId));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$user_name = $this->getUserDetail('user_id',$row['user_id'],'user_name');
						$music_available_formats_arr = explode(',',$row['music_available_formats']);
						$music_available_formats_arr = array_filter($music_available_formats_arr);
						$name = $user_name;
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->fields_arr['allow_comments'] = $row['allow_comments'];
						$this->fields_arr['allow_ratings'] = $row['allow_ratings'];
						$this->fields_arr['allow_embed'] = $row['allow_embed'];
						$this->fields_arr['allow_lyrics'] = $row['allow_lyrics'];
						$this->fields_arr['music_available_formats'] = $music_available_formats_arr;
						$this->fields_arr['music_ext'] = $row['music_ext'];
						$this->fields_arr['music_server_url'] = $row['music_server_url'];
						$this->fields_arr['music_title'] = $row['music_title'];
						$this->statistics_music_title = nl2br($row['music_title']);
						$this->statistics_music_caption = nl2br($row['music_caption']);

						$this->fields_arr['music_caption'] = $row['music_caption'];
						$this->fields_arr['date_added'] = $row['date_added'];
						$this->fields_arr['user_name'] = $name;
						$this->fields_arr['large_width'] = $row['large_width'];
						$this->fields_arr['large_height'] = $row['large_height'];
						$this->fields_arr['thumb_width'] = $row['thumb_width'];
						$this->fields_arr['thumb_height'] = $row['thumb_height'];
						$this->fields_arr['small_width'] = $row['small_width'];
						$this->fields_arr['small_height'] = $row['small_height'];
						$this->fields_arr['rating_total'] = $row['rating_total'];
						$this->fields_arr['rating_count'] = $row['rating_count'];
						$this->music_rating = round($row['rating']);
						$this->fields_arr['flagged_status'] = $row['flagged_status'];
						$this->fields_arr['comments'] = $row['total_comments']?$row['total_comments']:0;
						$this->fields_arr['music_album_id'] = $row['music_album_id'];
						$this->fields_arr['total_downloads'] = $row['total_downloads'];
						$this->fields_arr['cur_mid_play_time'] = $this->fmtMusicPlayingTime($row['playing_time'])?$row['playing_time']:'00:00';
						$this->fields_arr['cur_mid_total_views'] = $row['total_views'];
						$this->fields_arr['total_favorites'] = $row['total_favorites'];
						$this->fields_arr['total_views'] = $row['total_views'];
						$this->fields_arr['total_plays'] = $row['total_plays'];
						$this->fields_arr['total_comments'] = $row['total_comments'];
						$this->fields_arr['music_category_id'] = $row['music_category_id'];
						$this->fields_arr['music_category_name'] = $this->getMusicCategoryName($row['music_category_id']);
						$this->statistics_music_genre = $this->fields_arr['music_category_name'];
						$this->fields_arr['music_tags'] = $row['music_tags'];
						$this->fields_arr['music_upload_type'] = $row['music_upload_type'];
						$this->fields_arr['music_category_type'] = $this->getCategoryType($row['music_category_id']);
						$this->fields_arr['music_sub_category_id'] = $row['music_sub_category_id'];
						$this->fields_arr['music_category_id'] = $row['music_category_id'];
						$this->fields_arr['music_subcategory_type'] = $this->getCategoryType($row['music_sub_category_id']);
						$this->fields_arr['music_artist'] = $this->getArtistLink($row['music_artist'], true, 0);
						$this->fields_arr['org_music_artist'] = $row['music_artist'];
						$this->fields_arr['album_title'] = $this->getAlbumTitle($musicId);
						$album_details = getMusicAlbumDetails($row['music_album_id']);
						$this->fields_arr['album_for_sale'] = 'No';
						$this->fields_arr['for_sale'] = 'No';
						if($album_details['album_access_type']=='Private'
							and $album_details['album_price']>0
							and $album_details['album_for_sale']=='Yes')
						{
							$this->fields_arr['album_for_sale'] = 'Yes';
							$music_price = strstr($album_details['album_price'], '.');
	                        if(!$music_price)
	                        {
	                          $album_details['album_price']=$album_details['album_price'].'.00';
						    }
							$this->fields_arr['music_price'] = $this->LANG['common_album_price'].' <span>'.$this->CFG['currency'].$album_details['album_price'];
						}
						else if($row['for_sale']=='Yes')
						{
							$this->fields_arr['for_sale'] = 'Yes';
							$music_price = strstr($row['music_price'], '.');
	                        if(!$music_price)
	                        {
	                          $row['music_price']=$row['music_price'].'.00';
						    }
							$this->fields_arr['music_price'] = $this->LANG['common_music_price'].' <span>'.$this->CFG['currency'].$row['music_price'];
						}
						$this->statistics_album_title = nl2br($this->fields_arr['album_title']);
						$this->fields_arr['music_url'] = $row['music_url'];

						if($this->fields_arr['blog_post_title'] == '')
							$this->setFormField('blog_post_title', $row['music_title']);
						if($this->fields_arr['blog_post_text'] == '')
							$this->setFormField('blog_post_text', $row['music_caption']);

						$this->fields_arr['music_lyric_id'] = 0;
						if($row['allow_lyrics'] == 'Yes')
							{
								$this->fields_arr['music_lyric_id'] = $this->getBestLyric();

								if(empty($this->fields_arr['music_lyric_id']))
								{
									$this->fields_arr['music_lyric_id'] = $this->getAnyOneMusicLyric();
									$this->fields_arr['music_best_lyric'] = 0;
								}
								else
								{
									$this->fields_arr['music_best_lyric'] = 1;
								}

								if(empty($this->fields_arr['music_lyric_id']))
								{
									$musicLyricIdCount = $this->getMusicLyricCount();
									if(!empty($musicLyricIdCount))
									{
										$more_lyrics_url = getUrl('morelyrics', '?music_id='.$this->getFormField('music_id'), $this->getFormField('music_id').'/', '', 'music');
										$more_lyrics_url = "<a href=$more_lyrics_url alt=$this->LANG['music_lyrics_view_here']>".$this->LANG['music_lyrics_view_here'].'</a>';
										$this->LANG['music_lyrics_not_found'] = str_replace('VAR_VIEW_HERE', $more_lyrics_url, $this->LANG['music_best_lyrics_not_found']);
									}
								}
							}

							//$this->fields_arr['music_lyric_id'] = $this->getBestLyric();
						/*if(isset($_SESSION['user']['quick_mixs_clear']) and $_SESSION['user']['quick_mixs_clear'])
							mvKLRmRayzz($this->fields_arr['music_id']);
						if($this->CFG['admin']['videos']['allow_history_links'] and isLoggedIn() and isset($_SESSION['user']['quick_history']))
							$_SESSION['user']['quick_history'].=$this->fields_arr['music_id'].',';*/
						return true;
					}
				return false;
			}

		/**
		 * ViewMusic::displayMusic()
		 *
		 * @return void
		 */
		public function displayMusic()
			{
				//$this->arguments_embed = 'pg=music_'.$this->fields_arr['music_id'].'_no_0_extsite';

				$this->music_caption= nl2br($this->fields_arr['music_caption']);

				$this->loginUrl = getUrl('login');

				$this->rankUsersRayzz = false;
				$this->rating='';

				if(rankUsersRayzz($this->CFG['admin']['musics']['allow_self_ratings'], $this->fields_arr['user_id']))
					{
						$this->rankUsersRayzz=true;
						$this->rating = $this->getRating($this->CFG['user']['user_id']);
					}

				$this->ratingDetatils = ($rating=$this->populateRatingDetails())?$rating:0;
				if(isMember())
					{
						$this->share_url = $this->CFG['site']['music_url'].'shareMusic.php?music_id='.
														$this->getFormField('music_id').'&ajaxpage=true&page=sharemusic';
						$this->lyrics_url =  $this->CFG['site']['music_url'].'viewLyrics.php?music_id='.$this->getFormField('music_id').
														'&music_lyric_id='.$this->getFormField('music_lyric_id').'&music_title='.$this->getFormField('music_title');
					}
				else
					{
						$this->share_url = $this->CFG['site']['music_url'].'shareMusic.php?music_id='.
														$this->getFormField('music_id').'&ajaxpage=true&page=sharemusic';
						$this->lyrics_url =  $this->CFG['site']['music_url'].'viewLyrics.php?music_id='.$this->getFormField('music_id').
														'&music_lyric_id='.$this->getFormField('music_lyric_id').'&music_title='.$this->getFormField('music_title');
					}
				$this->blogPostViewMusicUrl = getUrl('viewmusic','?music_id='.$this->fields_arr['music_id'].'&amp;title='.
														$this->changeTitle($this->fields_arr['music_title']), $this->fields_arr['music_id'].
															'/'.$this->changeTitle($this->fields_arr['music_title']).'/','root','music');

				$this->edit_music_url = getUrl('musicuploadpopup','?music_id='.$this->fields_arr['music_id'],
										 	$this->fields_arr['music_id'].'/', 'members','music');

				$this->music_title = $this->fields_arr['music_title'];

				//$this->callAjaxFlagGroupsUrl = $this->CFG['site']['video_url'].'viewVideo.php?ajax_page=true&amp;page=flag&amp;music_id='.$this->fields_arr['video_id'].'&amp;show='.$this->fields_arr['show'];
				$this->favorite = $this->getFavorite();
				$this->featured = $this->getFeatured();

				if(!isMember())
					$this->relatedUrl = $this->CFG['site']['music_url'].'listenMusic.php';
				else
					$this->relatedUrl = $this->CFG['site']['music_url'].'listenMusic.php';


				$this->memberviewMusicUrl = getUrl('viewmusic','?mem_auth=true&music_id='.$this->getFormfield('music_id').'&title='.
																		$this->changeTitle($this->getFormfield('music_title')),
																			$this->getFormfield('music_id').'/'.
																				$this->changeTitle($this->getFormfield('music_title')).
																					'/?mem_auth=true','members', 'music');

				$this->flaggedMusicUrl = getUrl('viewmusic','?music_id='.$this->getFormfield('music_id').'&title='.
														$this->changeTitle($this->getFormfield('music_title')).
															'&flagged_content=show', $this->getFormfield('music_id').'/'.
																$this->changeTitle($this->getFormfield('music_title')).
																	'/?flagged_content=show','members', 'music');

				$this->load_flag_url = $this->CFG['site']['music_url'].'listenMusic.php?music_id='.
											$this->fields_arr['music_id'].'&ajax_page=true&page=load_flag';
				$this->load_blog_url = $this->CFG['site']['music_url'].'listenMusic.php?music_id='.
											$this->fields_arr['music_id'].'&ajax_page=true&page=load_blog';

				//MUSIC OWNER DETAILS
				$total_music = explode(':',getTotalMusics($this->fields_arr['user_id']));
				$this->music_user_details['total_musics'] = $total_music[1];
				$this->music_user_details['total_musics_url'] = getUrl('musiclist','?pg=usermusiclist&user_id='.$this->getFormField('user_id'),'usermusiclist/?user_id='.$this->getFormField('user_id'),'','music');
				$user_name =  $this->getUserDetail('user_id',$this->fields_arr['user_id'],'user_name');
				$this->music_user_details['user_name'] = $user_name;
				$this->music_user_details['icon'] = getMemberAvatarDetails($this->fields_arr['user_id']);
				$this->music_user_details['profile_url'] = getMemberProfileUrl($this->fields_arr['user_id'], $user_name);
				$this->isMember=isMember();

				//Populate single player configuration
				$this->populateSinglePlayerConfiguration();
				$this->configXmlcode_url .= 'pg=music_'.$this->getFormField('music_id');
				$this->playlistXmlcode_url .= 'pg=music_'.$this->getFormField('music_id');
			}

		/**
		 * ViewMusic::getCategoryType()
		 *
		 * @param mixed $category_id
		 * @return string
		 */
		public function getCategoryType($category_id)
			{
				$sql = 'SELECT music_category_type FROM '.$this->CFG['db']['tbl']['music_category'].
						' WHERE music_category_id='.$this->dbObj->Param('music_category_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($category_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$category_type = 'General';
				if($row = $rs->FetchRow())
					{
						$category_type = $row['music_category_type'];
					}
				return $category_type;
			}

		/**
		 * ViewMusic::getBestLyric()
		 *
		 * @return void
		 */
		public function getBestLyric()
			{
				$sql = 'SELECT music_lyric_id FROM '.$this->CFG['db']['tbl']['music_lyric'].
						' WHERE best_lyric = \'Yes\' AND lyric_status = \'Yes\''.
						' AND music_id='.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$music_lyric_id = '';
				if($row = $rs->FetchRow())
					{
						$music_lyric_id = $row['music_lyric_id'];
					}
				return $music_lyric_id;
			}

		/**
		 * ViewMusic::getAnyOneMusicLyric()
		 *
		 * @return void
		 */
		public function getAnyOneMusicLyric()
			{
				$sql = 'SELECT music_lyric_id FROM '.$this->CFG['db']['tbl']['music_lyric'].
						' WHERE lyric_status = \'Yes\''.
						' AND music_id='.$this->dbObj->Param('music_id').
						' ORDER BY RAND() LIMIT 1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$music_lyric_id = '';
				if($row = $rs->FetchRow())
					{
						$music_lyric_id = $row['music_lyric_id'];
					}
				return $music_lyric_id;
			}

		/**
		 * ViewMusic::getMusicLyricCount()
		 *
		 * @return void
		 */
		public function getMusicLyricCount()
			{
				$sql = 'SELECT count(music_lyric_id) as total_lyrics FROM '.$this->CFG['db']['tbl']['music_lyric'].
						' WHERE lyric_status = \'Yes\''.
						' AND music_id='.$this->dbObj->Param('music_id');;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$total_lyrics = '';
				if($row = $rs->FetchRow())
					{
						$total_lyrics = $row['total_lyrics'];
					}
				return $total_lyrics;
			}

		// COMMENT FUNCTION STARTING //
		/**
		 * viewMusic::getEditCommentBlock()
		 *
		 * @return void
		 */
		public function getEditCommentBlock()
			{
				global $smartyObj;
				$replyBlock['comment_id']=$this->fields_arr['comment_id'];
				$replyBlock['name']='addEdit_';
				$replyBlock['sumbitFunction']='addToEdit';
				$replyBlock['cancelFunction']='discardEdit';
				$replyBlock['editReplyUrl']=$this->CFG['site']['music_url'].'listenMusic.php?ajax_page=true&amp;page=update_comment&amp;music_id='.$this->fields_arr['music_id'].'&vpkey='.$this->fields_arr['vpkey'].'&show='.$this->fields_arr['show'];
				$smartyObj->assign('commentEditReply', $replyBlock);
				setTemplateFolder('general/','music');
				$smartyObj->display('musciCommentEditReplyBlock.tpl');
			}

		/**
		 * viewMusic::deleteComment()
		 * purpose to delete the Comment of the music
		 * @return void
		 */
		public function deleteComment()
			{
				$sql = 'SELECT music_id,music_comment_main_id FROM '.$this->CFG['db']['tbl']['music_comments'].' WHERE'.
						' music_comment_id='.$this->dbObj->Param('music_comment_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_comments'].
						' WHERE music_comment_id='.$this->dbObj->Param('music_comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				// DELETE REPLAY //
				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['music_comments'].
						' WHERE music_comment_main_id='.$this->dbObj->Param('music_comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row['music_comment_main_id']==0)
					{
						//if($this->dbObj->Affected_Rows())
							//{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET total_comments = total_comments-1'.
										' WHERE music_id='.$this->dbObj->Param('music_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($row['music_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
							//}
					}

				echo $this->LANG['success_deleted'];
				echo '~~DELMSG~~';
			}

		/**
		 * viewMusic::populateReply()
		 *
		 * @param integer $comment_id
		 * @return array
		 */
		public function populateReply($comment_id)
			{
				$populateReply_arr = array();
				$sql = 'SELECT music_comment_id, music_comment_main_id, comment_user_id,'.
						' comment, TIMEDIFF(NOW(), date_added) as pc_date_added,'.
						' TIME_TO_SEC(TIMEDIFF(NOW(), date_added)) AS date_edit'.
						' FROM '.$this->CFG['db']['tbl']['music_comments'].
						' WHERE comment_status= \'Yes\' AND music_id='.$this->dbObj->Param('music_id').' AND'.
						' music_comment_main_id='.$this->dbObj->Param('music_comment_main_id').
						' ORDER BY music_comment_id DESC';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id'], $comment_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$populateReply_arr['row'] = array();
				$populateReply_arr['rs_PO_RecordCount'] = $rs->PO_RecordCount();
				if($rs->PO_RecordCount())
					{
						$inc = 0;
						while($row = $rs->FetchRow())
							{
								$user_name = $this->getUserDetail('user_id',$row['comment_user_id'],'user_name');
								$populateReply_arr['s_attribute'] = isset($icondetail['icon']['s_attribute'])?$icondetail['icon']['s_attribute']:'';
								$populateReply_arr['row'][$inc]['name'] = $user_name;
								$populateReply_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['comment_user_id']);
								$populateReply_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $user_name);
								$row['pc_date_added'] = getTimeDiffernceFormat($row['pc_date_added']);
								$row['comment'] = $row['comment'];
								$populateReply_arr['row'][$inc]['record'] = $row;

								$populateReply_arr['row'][$inc]['class'] = 'clsNotEditable';
								if($row['comment_user_id']==$this->CFG['user']['user_id'])
									{
										$time = $this->CFG['admin']['musics']['comment_edit_allowed_time'] - $row['date_edit'];
										if($time>2)
											{
												$populateReply_arr['row'][$inc]['class'] = 'clsEditable';
											}
									}
								$populateReply_arr['row'][$inc]['comment_memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $user_name);
								$temp_reply = nl2br(makeClickableLinks($row['comment']));
								$populateReply_arr['row'][$inc]['comment_makeClickableLinks'] = $temp_reply;

								if(isMember() AND $row['comment_user_id'] == $this->CFG['user']['user_id'])
									{
										$populateReply_arr['row'][$inc]['time'] = $this->CFG['admin']['musics']['comment_edit_allowed_time']-$row['date_edit'];
										if($populateReply_arr['row'][$inc]['time'] > 2)
											{
												$this->enabled_edit_fields[$row['music_comment_id']] = $populateReply_arr['row'][$inc]['time'];
											}
									}
								$inc++;
							}
					}
				return $populateReply_arr;
			}

		/**
		 * viewMusic::getCaptchaText()
		 * purpose to getcaptcha text
		 * @return string
		 */
		public function getCaptchaText()
			{
				$captcha_length = 5;
				$this->captchaText = rand(pow(10, $captcha_length-1), pow(10, $captcha_length)-1);
				return $this->captchaText;
			}

		/**
		 * viewMusic::getCommentsBlock()
		 *
		 * @return void
		 */
		public function getCommentsBlock()
			{
				global $smartyObj;
				$getCommentsBlock_arr = array();
				if($this->CFG['admin']['musics']['captcha'] and $this->CFG['admin']['musics']['captcha_method']=='image')
					{
						$getCommentsBlock_arr['captcha_comment_url'] = $this->CFG['site']['url'].'captchaComment.php?captcha_key=musiccomment&amp;captcha_value='.$this->getCaptchaText();
					}
				$smartyObj->assign('getCommentsBlock_arr', $getCommentsBlock_arr);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('getMusicCommentsBlock.tpl');
			}

		/**
		 * viewMusic::getTotalComments()
		 * purpose to get Total Comments og this playlisr
		 * @return integer
		 */
		public function getTotalComments()
			{
				$sql = 'SELECT total_comments FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE music_id='.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $this->fields_arr['total_comments'] = $row['total_comments']?$row['total_comments']:0;
			}

		/**
		 * viewMusic::populateCommentOptionsMusic()
		 * purpose to populate Comment options for the Music
		 * purpose to populate Comment options for the Music
		 * @return void
		 */
		public function populateCommentOptionsMusic()
			{
				$this->CFG['admin']['musics']['total_comments']=$this->fields_arr['show']=='all'?'100000':$this->CFG['admin']['musics']['total_comments'];
				$sql = 'SELECT vc.music_comment_id, vc.comment_user_id,'.
						' vc.comment, TIMEDIFF(NOW(), vc.date_added) as pc_date_added,'.
						' TIME_TO_SEC(TIMEDIFF(NOW(), vc.date_added)) AS date_edit'.
						' FROM '.$this->CFG['db']['tbl']['music_comments'].' AS vc'.
						' WHERE vc.music_id='.$this->dbObj->Param('music_id').' AND'.
						' vc.music_comment_main_id=0 AND'.
						' vc.comment_status=\'Yes\' ORDER BY vc.music_comment_id DESC LIMIT '.$this->CFG['admin']['musics']['total_comments'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$total_comments = $rs->PO_RecordCount();
				$this->fields_arr['total_comments'] = $this->getTotalComments();
				$this->comment_approval = 0;
				if(isMember())
					{
						$this->commentUrl = $this->CFG['site']['music_url'].'listenMusic.php?type=add_comment&music_id='.$this->getFormField('music_id');
					}
				else
					{
						$this->commentUrl =getUrl('viewmusic', '?music_id='.$this->fields_arr['music_id'].'&title='.$this->changeTitle($this->fields_arr['music_title']), $this->fields_arr['music_id'].'/'.$this->changeTitle($this->fields_arr['music_title']).'/', 'members', 'music');
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
						$this->setPageBlockHide('music_comments_block');
					}
		}


		/**
		 * viewMusic::populateCommentOfThisMusic()
		 *
		 * @return void
		 */
		public function populateCommentOfThisMusic()
			{
				global $smartyObj;
				$populateCommentOfThisMusic_arr = array();

                $this->setTableNames(array($this->CFG['db']['tbl']['music_comments'].' AS vc', $this->CFG['db']['tbl']['users'].' AS u'));
                $this->setReturnColumns(array('vc.music_comment_id', 'vc.comment_user_id', 'vc.comment', 'TIMEDIFF(NOW(), vc.date_added) as pc_date_added', 'TIME_TO_SEC(TIMEDIFF(NOW(), vc.date_added)) AS date_edit'));
                $this->sql_condition = 'vc.music_id=\''.$this->fields_arr['music_id'].'\' AND vc.music_comment_main_id=0 AND u.user_id=vc.comment_user_id AND u.usr_status=\'Ok\' AND vc.comment_status=\'Yes\'';
                $this->sql_sort = 'vc.music_comment_id DESC';

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

				$populateCommentOfThisMusic_arr['comment_approval'] = 0;
				if($this->getFormField('allow_comments')=='Kinda')
					{
						$populateCommentOfThisMusic_arr['comment_approval'] = 0;
						if(!isMember())
							{
								$populateCommentOfThisMusic_arr['approval_url'] = getUrl('viewmusic', '?music_id='.$this->fields_arr['music_id'].'&amp;title='.$this->changeTitle($this->fields_arr['music_title']), $this->fields_arr['music_title'].'/'.$this->changeTitle($this->fields_arr['music_title']).'/', 'members', 'music');
							}
					}
				else if($this->getFormField('allow_comments')=='Yes')
					{
						$populateCommentOfThisMusic_arr['comment_approval'] = 1;
						if(!isMember())
							{
								$populateCommentOfThisMusic_arr['post_comment_url'] = getUrl('viewmusic', '?music_id='.$this->fields_arr['music_id'].'&amp;title='.$this->changeTitle($this->fields_arr['music_title']), $this->fields_arr['music_id'].'/'.$this->changeTitle($this->fields_arr['music_title']).'/', 'members', 'music');
							}
					}

				$populateCommentOfThisMusic_arr['row'] = array();
				if($this->isResultsFound())
					{
						$this->fields_arr['ajaxpaging'] = 1;
						$populateCommentOfThisMusic_arr['hidden_arr'] = array('start', 'ajaxpaging');
						$smartyObj->assign('smarty_paging_list', $this->populatePageLinksPOSTViaAjax($this->getFormField('start'), 'frmMusicComments', 'selCommentBlock'));
						$this->fields_arr['total_comments'] = (isset($this->fields_arr['total_comments']) and $this->fields_arr['total_comments'])?$this->fields_arr['total_comments']:$this->getTotalComments();

						$inc = 0;
						while($row = $this->fetchResultRecord())
							{
								$user_name = $this->getUserDetail('user_id',$row['comment_user_id'],'user_name');
								$populateCommentOfThisMusic_arr['s_attribute'] = isset($icondetail['icon']['s_attribute'])?$icondetail['icon']['s_attribute']:'';
								$populateCommentOfThisMusic_arr['row'][$inc]['name'] = $user_name;
								$populateCommentOfThisMusic_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['comment_user_id']);
								$populateCommentOfThisMusic_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $user_name);

								$row['pc_date_added'] = getTimeDiffernceFormat($row['pc_date_added']);

								$populateCommentOfThisMusic_arr['row'][$inc]['class'] = 'clsNotEditable';
								if($row['comment_user_id']==$this->CFG['user']['user_id'])
									{
										$time = $this->CFG['admin']['musics']['comment_edit_allowed_time']-$row['date_edit'];
										if($time>2)
											{
												$populateCommentOfThisMusic_arr['row'][$inc]['class'] = "clsEditable";
											}
									}
								$row['comment'] = $row['comment'];
								$populateCommentOfThisMusic_arr['row'][$inc]['record'] = $row;
								$populateCommentOfThisMusic_arr['row'][$inc]['reply_url']= $this->CFG['site']['music_url'].'listenMusic.php?music_id='.$this->getFormField('music_id').'&vpkey='.$this->getFormField('vpkey').'&show='.$this->getFormField('show').'&comment_id='.$row['music_comment_id'].'&type=comment_reply';

								$populateCommentOfThisMusic_arr['row'][$inc]['comment_member_profile_url'] = getMemberProfileUrl($row['comment_user_id'], $user_name);
								$temp_comment = nl2br(makeClickableLinks($row['comment']));
								$populateCommentOfThisMusic_arr['row'][$inc]['makeClickableLinks'] =  $temp_comment;
								if(isMember() and $row['comment_user_id']==$this->CFG['user']['user_id'])
									{
										$populateCommentOfThisMusic_arr['row'][$inc]['time'] = $this->CFG['admin']['musics']['comment_edit_allowed_time']-$row['date_edit'];
										if($populateCommentOfThisMusic_arr['row'][$inc]['time'] > 2)
											{
												$this->enabled_edit_fields[$row['music_comment_id']] = $populateCommentOfThisMusic_arr['row'][$inc]['time'];
											}
									}
								else
									{
										if(!isMember())
											{
												$populateCommentOfThisMusic_arr['row'][$inc]['comment_reply_url'] = getUrl('viewmusic', '?music_id='.$this->fields_arr['music_id'].'&amp;title='.$this->changeTitle($this->fields_arr['music_title']), $this->fields_arr['music_id'].'/'.$this->changeTitle($this->fields_arr['music_title']).'/', 'members', 'music');
											}
									}
								$populateCommentOfThisMusic_arr['row'][$inc]['populateReply_arr'] = $this->populateReply($row['music_comment_id']);
								$inc++;
							} //while

						if($this->fields_arr['total_comments']>$this->CFG['admin']['musics']['total_comments'])
							{
						  		$populateCommentOfThisMusic_arr['view_all_comments_url'] = getUrl('viewmusic', '?music_id='.$this->fields_arr['music_id'].'&amp;title='.$this->changeTitle($this->fields_arr['music_title']).'&amp;vpkey='.$this->fields_arr['vpkey'].'&amp;show=all', $this->fields_arr['music_id'].'/'.$this->changeTitle($this->fields_arr['music_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&amp;show=all', '', 'music');
								$populateCommentOfThisMusic_arr['view_all_comments'] = sprintf($this->LANG['view_all_comments'],'<span id="total_comments2">'.$this->fields_arr['total_comments'].'</span>');

						  	}
					}

				$smartyObj->assign('populateCommentOfThisMusic_arr', $populateCommentOfThisMusic_arr);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('populateCommentOfThisMusic.tpl');
			}

		/**
		 * viewMusic::insertCommentAndMusicTable()
		 *
		 * @return void
		 **/
		public function insertCommentAndMusicTable()
			{
				$sql = 'SELECT allow_comments FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE music_id='.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$this->fields_arr['allow_comments'] = $row['allow_comments'];
				$comment_status = 'Yes';
				//IF MUSIC OWNER POST COMMENT THEN WE DISPLAY COMMENTS WITHOUT APPROVAL//
				if($row['allow_comments']=='Kinda' and $this->CFG['user']['user_id']!=$this->fields_arr['user_id'])
					$comment_status = 'No';

				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_comments'].' SET'.
						' music_id='.$this->dbObj->Param('music_id').','.
						' music_comment_main_id='.$this->dbObj->Param('music_comment_main_id').','.
						' comment_user_id='.$this->dbObj->Param('comment_user_id').','.
						' comment='.$this->dbObj->Param('comment').','.
						' comment_status='.$this->dbObj->Param('comment_status').','.
						' date_added=NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id'], $this->fields_arr['comment_id'], $this->CFG['user']['user_id'], $this->fields_arr['f'], $comment_status));
				    if (!$rs)
					    trigger_db_error($this->dbObj);

				$next_id = $this->dbObj->Insert_ID();
				if($next_id and $comment_status=='Yes' and (!$this->fields_arr['comment_id']))
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET total_comments = total_comments+1'.
								' WHERE music_id='.$this->dbObj->Param('music_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
						    if (!$rs)
							    trigger_db_error($this->dbObj);
					}

				//SEND MAIL TO MUSIC OWNER
				if($this->CFG['user']['user_id'] != $this->fields_arr['user_id'])
					$this->sendMailToUserForMusicComment();

				//Srart Post music comment activity..
				$sql = 'SELECT mc.music_comment_id, mc.music_id, mc.comment_user_id, u.user_name, '.
						'm.music_title, m.user_id, m.music_server_url, m.music_thumb_ext '.
						'FROM '.$this->CFG['db']['tbl']['music_comments'].' as mc, '.
						$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['music'].' as m '.
						' WHERE u.user_id = mc.comment_user_id AND '.
						'mc.music_id = m.music_id AND mc.music_comment_id = '.$this->dbObj->Param('music_comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($next_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$activity_arr = $row;
				$activity_arr['action_key']	= 'music_comment';
				$musicActivityObj = new MusicActivityHandler();
				$musicActivityObj->addActivity($activity_arr);
				//end

				global $smartyObj;
				if ($this->fields_arr['comment_id'])
					{
						$cmValue['populateReply_arr'] = $this->populateReply($this->fields_arr['comment_id']);
						$smartyObj->assign('cmValue', $cmValue);
						setTemplateFolder('general/', 'music');
						$smartyObj->display('populateReplyForCommentsOfThisMusic.tpl');
					}
				else
					{
						$this->populateCommentOfThisMusic();
					}
			}

		/**
		 *
		 * @return 		void
		 * @access 		public
		 */
		public function populateReplyCommentOfThisMusic()
			{
				global $smartyObj;
				$cmValue['populateReply_arr'] = $this->populateReply($this->fields_arr['maincomment_id']);
				$smartyObj->assign('cmValue', $cmValue);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('populateReplyForCommentsOfThisMusic.tpl');
			}

		/**
		 * viewMusic::updateCommentAndMusicTable()
		 *
		 * @return boolean
		 **/
		public function updateCommentAndMusicTable()
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_comments'].' SET'.
						' comment='.$this->dbObj->Param('comment').
						' WHERE music_comment_id='.$this->dbObj->Param('music_comment_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['f'], $this->fields_arr['comment_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				return true;
			}

		/**
		 * viewMusic::getComment()
		 *
		 * @return
		 **/
		public function getComment()
			{
				$sql = 'SELECT comment FROM '.$this->CFG['db']['tbl']['music_comments'].' WHERE'.
						' music_comment_id='.$this->dbObj->Param('music_comment_id');

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
		 * viewMusic::chkCaptcha()
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

		/**
		 * viewMusic::chkIsNotEmpty()
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
		// MORE CONTENT user, related, top, artist//

		public function processStartValue($pg, $totalMusicCount=0)
			{
				$vdebug = true;
				$videoLimit=$this->CFG['admin']['musics']['total_related_music'];
				$videoIncrement=$this->CFG['admin']['musics']['total_related_music'];

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
								$inc = ($_SESSION['vTopStart'] < $totalMusicCount)?$videoIncrement:0;
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
								$inc = ($_SESSION['vUserStart'] < $totalMusicCount)?$videoIncrement:0;
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
								$inc = ($_SESSION['vTagStart'] < $totalMusicCount)?$videoIncrement:0;
								//echo $totalMusicCount.'------------'.$inc;
								$_SESSION['vTagStart'] += $inc;
						    }
						return $_SESSION['vTagStart'];
					}

				if($pg=='artist')
					{
						if (!isset($_SESSION['vArtistStart']))
					    	$_SESSION['vArtistStart'] = 0;

						if ($this->isPageGETed($_POST, 'vArtistLeft'))
						    {
								$inc = ($_SESSION['vArtistStart'] > 0)?$videoIncrement:0;
								$_SESSION['vArtistStart'] -= $inc;
						    }
						if ($this->isPageGETed($_POST, 'vArtistRight'))
						    {
								$inc = ($_SESSION['vArtistStart'] < $totalMusicCount)?$videoIncrement:0;
								//echo $totalMusicCount.'------------'.$inc;
								$_SESSION['vArtistStart'] += $inc;
						    }
						return $_SESSION['vArtistStart'];
					}

			}

		/**
		 * ViewMusic::getArtistAddtionalQuery()
		 *
		 * @param mixed $music_artist
		 * @return
		 */
		public function getArtistAddtionalQuery($music_artist, $field_name)
			{
				$music_artist_arr = explode(',', $music_artist);
				$condition_str = '( ';
				foreach($music_artist_arr as $value)
					{
						$condition_str .= $field_name.' = '.$value.' ) OR (';
					}
				$condition_str = substr($condition_str, 0, strrpos($condition_str, 'OR'));
				return $condition_str;
			}
		/**
		 * ViewMusic::populateRelatedMusic()
		 *
		 * @param string $pg
		 * @param integer $start
		 * @return
		 */
		public function populateRelatedMusic($pg = 'tag', $start=0)
			{
				global $smartyObj;

				$gloabl_more_music_limit = 20;
				$return = array();
				/*$default_fields = 'TIME_FORMAT(m.playing_time,\'%H:%i:%s\') as playing_time, m.music_id, m.user_id, m.music_title, m.video_caption,'.
								  ' TIMEDIFF(NOW(), date_added) as date_added, m.video_server_url, m.total_views,'.
								  ' m.s_width, m.s_height, m.music_thumb_ext, m.music_tags,is_external_embed_video,embed_video_image_ext';*/

				$default_fields = 'm.music_id, m.music_title, TIME_FORMAT(m.playing_time,\'%H:%i:%s\') as playing_time, m.total_plays, m.music_thumb_ext, m.music_server_url, mfs.file_name, m.thumb_width, m.thumb_height, m.user_id';

				$add_fields = '';
				$order_by = 'm.music_id DESC';
				//$allow_quick_links=(isLoggedIn() and $this->CFG['admin']['music']['allow_quick_mixs'])?true:false;
				switch($pg)
					{
						case 'top':

							$sql_condition = 'm.music_id!=\''.addslashes($this->fields_arr['music_id']).'\''.
										' AND m.rating_total>0 AND m.music_status=\'Ok\''.$this->getAdultQuery('m.', 'music').
										' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
										' m.music_access_type = \'Public\''.$this->getAdditionalQuery().')';

							//$more_link = getUrl('musiclist','?pg=videotoprated', 'videotoprated/');
							break;

						case 'user':

							$sql_condition = 'm.music_id!=\''.addslashes($this->fields_arr['music_id']).'\''.
										' AND m.user_id=\''.$this->fields_arr['user_id'].'\' AND m.music_status=\'Ok\''.$this->getAdultQuery('m.', 'music').
										' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
										' m.music_access_type = \'Public\''.$this->getAdditionalQuery().')';

							$more_link = getUrl('musiclist','?pg=usermusiclist&amp;user_id='.$this->fields_arr['user_id'], 'usermusiclist/?user_id='.$this->fields_arr['user_id']);
							break;

						case 'tag':

							$music_tags = $this->fields_arr['music_tags'];
							$sql_condition = 'm.music_id!=\''.addslashes($this->fields_arr['music_id']).'\' AND'.
									' m.music_status=\'Ok\''.$this->getAdultQuery('m.', 'music').' AND'.
									' '.getSearchRegularExpressionQueryModified($music_tags, 'music_tags', '').
									' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
									' m.music_access_type = \'Public\''.$this->getAdditionalQuery().')';

							$add_fields = '';
							$order_by = 'm.music_id DESC';
							//$more_link = getUrl('musiclist','?pg=musicnew&amp;tags='.$music_tags, 'musicnew/?tags='.$music_tags);
							break;

						case 'artist':
							$music_artist = $this->fields_arr['org_music_artist'];
							$sql_condition = 'm.music_id!=\''.addslashes($this->fields_arr['music_id']).'\' AND'.
									' m.music_status=\'Ok\''.$this->getAdultQuery('m.', 'music').' AND'.
									' '.$this->getArtistAddtionalQuery($music_artist, 'music_artist', '').
									' AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
									' m.music_access_type = \'Public\''.$this->getAdditionalQuery().')';

							$add_fields = '';
							$order_by = 'm.music_id DESC';
							//$more_link = getUrl('musiclist','?pg=musicnew&amp;tags='.$music_artist, 'musicnew/?tags='.$music_tags);
							break;
					}

				$sql_exising='SELECT count(1) count FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id '.
						' WHERE '.$sql_condition.' ';
				$existing_total_records=$this->getExistingRecords($sql_exising);
				$process_start=$this->processStartValue($pg, $existing_total_records);

				$sql = 'SELECT '.$default_fields.$add_fields.' FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id '.
						' WHERE '.$sql_condition.' ORDER BY '.$order_by.
						' LIMIT '.$process_start.', ' . $gloabl_more_music_limit;
						//' LIMIT '.$process_start.', '.$this->CFG['admin']['musics']['total_related_music']

				//------ Next and Prev Links--------------//
				$leftButtonClass = 'clsPreviousDisable';
				$rightButtonClass = 'clsNextDisable';
				$leftButtonExist=false;
				$rightButtonExists=false;
				$this->pg =$pg;
				$nextSetAvailable = ($existing_total_records > ($process_start + $this->CFG['admin']['musics']['total_related_music']));
				if ($nextSetAvailable)
					{
			        	$rightButtonClass = 'clsNext';
						$rightButtonExists=true;
					}
				if ($process_start > 0)
					{
						$leftButtonExist=true;
			        	$leftButtonClass = 'clsPrevious';
					}
				//------ Next and Prev Links--------------//
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$this->total_records = $rs->PO_RecordCount();
				$musicsPerRow=$this->CFG['admin']['musics']['related_music_per_row'];
				$inc=0;
				if ($this->total_records)
			    {
					$musics_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' . $this->CFG['admin']['musics']['thumbnail_folder'] . '/';
					while($row = $rs->FetchRow())
					{
						$user_name = $this->getUserDetail('user_id',$row['user_id'],'user_name');
						$return[$inc]['record'] = $row;
						$return[$inc]['name'] = $user_name;
						$return[$inc]['playing_time'] = $this->fmtMusicPlayingTime($row['playing_time'])?$row['playing_time']:'00:00';
						$return[$inc]['getMemberProfileUrl'] = getMemberProfileUrl($row['user_id'], $user_name);
						// IMAGE //
						if($row['music_thumb_ext'])
						{
							$return[$inc]['music_image_src'] = $row['music_server_url'].$musics_folder.getMusicImageName($row['music_id'], $row['file_name']).$this->CFG['admin']['musics']['thumb_name'].'.'.$row['music_thumb_ext'];
						}
						else
						{
							$return[$inc]['music_image_src'] = '';
						}
						$return[$inc]['music_url']=getUrl('viewmusic','?music_id='.$row['music_id'].'&amp;title='.$this->changeTitle($row['music_title']).'&amp;vpkey='.$this->fields_arr['vpkey'], $row['music_id'].'/'.$this->changeTitle($row['music_title']).'/?vpkey='.$this->fields_arr['vpkey'],'','music');
					    $inc++;
					}
				}
				$this->leftButtonExist=$leftButtonExist;
				$this->rightButtonExists=$rightButtonExists;
				$this->leftButtonClass=$leftButtonClass;
				$this->rightButtonClass=$rightButtonClass;

				$smartyObj->assign('relatedMusic', $return);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('viewMusicMoreContent.tpl');
			}

		/**
		 * ViewMusic::getExistingRecords()
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
		 * ViewMusic::getAlbumTitle()
		 *
		 * @param mixed $music_id
		 * @return
		 */
		public function getAlbumTitle($music_id)
			{
				$sql = 'SELECT ma.album_title FROM '.$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['music'].' AS m '.
						'WHERE ma.music_album_id=m.music_album_id AND m.music_id='.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['album_title'];
			}

		/**
		 * ViewMusic::populatePeopleListened()
		 *
		 * @param string $pg
		 * @param integer $start
		 * @return
		 */
		public function populatePeopleListened($count)
			{
				global $smartyObj;
				$return = array();
				$start = $this->fields_arr['listenedstart'];
				$listener_id = (isset($this->CFG['user']['user_id']) and  ($this->CFG['user']['user_id'])) ? ($this->CFG['user']['user_id']) : 0;
				$listened_default_fields = 'DISTINCT (m.music_id), m.music_title, TIME_FORMAT(m.playing_time,\'%H:%i:%s\') as playing_time, m.total_plays, m.music_thumb_ext, m.music_server_url, mfs.file_name, m.thumb_width, m.thumb_height, m.user_id, m.music_category_id, m.music_album_id ';
				$sql = 'SELECT '.$listened_default_fields.' '.
						'FROM '.$this->CFG['db']['tbl']['music'].' AS m JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' AS mfs ON mfs.music_file_id = m.thumb_name_id, '
						.$this->CFG['db']['tbl']['music_album'].' AS ma, '.$this->CFG['db']['tbl']['users'].' AS u, '.$this->CFG['db']['tbl']['music_listened'].' AS ml '.
						' WHERE ml.user_id IN ( SELECT l.user_id FROM music_listened AS l WHERE l.user_id != '.$listener_id.' AND l.music_id = '.$this->dbObj->Param('music_id').') AND ma.music_album_id=ma.music_album_id AND ml.music_id=m.music_id AND m.user_id=u.user_id AND m.music_id != '.$this->dbObj->Param('music_id').' AND u.usr_status=\'Ok\'';

				if($count)
					$sql .= ' ORDER BY ml.last_listened LIMIT '.$start.', '.$this->CFG['admin']['musics']['total_people_listened_music'];

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id'], $this->fields_arr['music_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$this->listened_total_records = $rs->PO_RecordCount();
				if(!$count)
					{
						return $this->listened_total_records;
					}
				$this->isNextButton = false;
				$this->isPreviousButton = false;
				if($this->listened_total_records)
				{
					$this->activeClsNext = 'clsNextDisable';
					$this->activeClsPrevious = 'clsPreviousDisable';
					// PAGING //
					$total = $this->populatePeopleListened(false);
					if($total > ($start+$this->CFG['admin']['musics']['total_people_listened_music']))
					{
						$this->activeClsNext = 'clsNext';
						$this->isNextButton = true;
					}
					if($start > 0)
					{
						$this->activeClsPrevious = 'clsPrevious';
						$this->isPreviousButton = true;
					}
					$musics_folder = $this->CFG['media']['folder'] . '/' . $this->CFG['admin']['musics']['folder'] . '/' . $this->CFG['admin']['musics']['thumbnail_folder'] . '/';
					$inc = 0;
					while($row = $rs->FetchRow())
					{
						$user_name = $this->getUserDetail('user_id',$row['user_id'],'user_name');
						$return[$inc]['record'] = $row;
						$return[$inc]['name'] = $user_name;
						$return[$inc]['playing_time'] = $this->fmtMusicPlayingTime($row['playing_time'])?$row['playing_time']:'00:00';
						$return[$inc]['getMemberProfileUrl'] = getMemberProfileUrl($row['user_id'], $user_name);
						// IMAGE //
						if($row['music_thumb_ext'])
						{
							$return[$inc]['music_image_src'] = $row['music_server_url'].$musics_folder.getMusicImageName($row['music_id'], $row['file_name']).$this->CFG['admin']['musics']['thumb_name'].'.'.$row['music_thumb_ext'];
						}
						else
						{
							$return[$inc]['music_image_src'] = '';
						}
						$return[$inc]['music_url']=getUrl('viewmusic','?music_id='.$row['music_id'].'&amp;title='.$this->changeTitle($row['music_title']).'&amp;vpkey='.$this->fields_arr['vpkey'], $row['music_id'].'/'.$this->changeTitle($row['music_title']).'/?vpkey='.$this->fields_arr['vpkey'],'','music');
						$album_title = $this->getAlbumTitle($row['music_id']);
						$return[$inc]['album_title'] = $album_title;
						$return[$inc]['viewalbum_url'] = getUrl('viewalbum', '?album_id='.$row['music_album_id'].'&title='.$this->changeTitle($album_title),$row['music_album_id'].'/'.$this->changeTitle($album_title).'/', '', 'music');
						$return[$inc]['music_category_name'] = $this->getMusicCategoryName($row['music_category_id']);
						$return[$inc]['musiccategory_url'] = getUrl('musiclist', '?pg=musicnew&cid='.$row['music_category_id'], 'musicnew/?cid='.$row['music_category_id'], '', 'music');
					    $inc++;
					}
				}
				else
				{
					$this->activeClsNext = 'clsNextDisable';
					$this->activeClsPrevious = 'clsPreviousDisable';
				}
				$smartyObj->assign('peopleListened', $return);
				setTemplateFolder('general/', 'music');
				$smartyObj->display('viewMusicMorePeopleListened.tpl');
			}

		/**
		 * ViewMusic::populatePlaylist()
		 * playlist details will be passed to tpl
		 *
		 * @return void
		 */
		public function populatePlaylist()
		{
			global $smartyObj;
			$playlist_info = array();
			$playlist_info['playlistUrl']=$this->CFG['site']['music_url'].'listenMusic.php?ajax_page=true&page=playlist';
			$this->playlist_name_notes = str_replace('VAR_MIN', $this->CFG['fieldsize']['music_playlist_name']['min'], $this->LANG['playlist_name_notes']);
			$this->playlist_name_notes = str_replace('VAR_MAX', $this->CFG['fieldsize']['music_playlist_name']['max'], $this->playlist_name_notes);
			$this->playlist_tags_notes = str_replace('VAR_MIN', $this->CFG['fieldsize']['music_playlist_tags']['min'], $this->LANG['playlist_tags_notes']);
			$this->playlist_tags_notes = str_replace('VAR_MAX', $this->CFG['fieldsize']['music_playlist_tags']['max'], $this->playlist_tags_notes);
			$this->getPlaylistIdInMusic($this->getFormField('music_id'));
			$this->displayCreatePlaylistInterface();
			$smartyObj->assign('playlist_info', $playlist_info);
			setTemplateFolder('general/','music');
			$smartyObj->display('playList.tpl');
		}

		/**
		 * ViewMusic::populateFlagContent()
		 *
		 * @return void
		 */
		public function populateFlagContent()
			{
				global $smartyObj;
				$flagContent['url'] = $this->CFG['site']['music_url'].'listenMusic.php?ajax_page=true&'.
											'page=flag&music_id='.$this->getFormField('music_id').'&show='.$this->fields_arr['show'];
				$smartyObj->assign('flagContent', $flagContent);
				setTemplateFolder('general/','music');
				$smartyObj->display('musicFlag.tpl');
			}

		/**
		 * ViewMusic::populateBlogContent()
		 *
		 * @return void
		 */
		public function populateBlogContent()
			{
				global $smartyObj;

				$this->musics_form['getBlogList'] = $this->getBlogList();
				if(empty($this->musics_form['getBlogList']))
					{
						$this->musics_form['add_new_blog_info'] = ' ';
						$this->musics_form['post_to_blog'] = ' style="display:none;"';
					}
				else
					{
						$this->musics_form['add_new_blog_info'] = ' style="display:none;"';
						$this->musics_form['post_to_blog'] = '';
					}

				$profile_blog_text = '<a href=\''.getUrl('profileblog', '?music_id='.$this->fields_arr['music_id'], '?music_id='.$this->fields_arr['music_id'], 'members', 'music').'\'>'.$this->LANG['viewmusic_setup_new_blog'].'</a>';
				$this->LANG['viewmusic_blog_post_info'] = str_replace('VAR_SETUP_NEW_BLOG', $profile_blog_text, $this->LANG['viewmusic_blog_post_info']);
				$this->LANG['viewmusic_no_blog'] = str_replace('VAR_SETUP_NEW_BLOG', $profile_blog_text, $this->LANG['viewmusic_no_blog']);
				/*$flagContent['url'] = $this->CFG['site']['music_url'].'listenMusic.php?ajax_page=true&'.
											'page=flag&music_id='.$this->getFormField('music_id').'&show='.$this->fields_arr['show'];
				$smartyObj->assign('flagContent', $flagContent);*/
				setTemplateFolder('general/','music');
				$smartyObj->display('addToBlog.tpl');
			}

		/**
		 * ViewMusic::populateLyricsContent()
		 * lyrics details will be passed to tpl
		 *
		 * @return void
		 */
		public function populateLyricsContent()
		{
			global $smartyObj;
			setTemplateFolder('general/','music');
			$smartyObj->display('populateLyrics.tpl');
		}

		/**
		 * viewMusic::insertFlagMusicTable()
		 * purpose to insert flag content to the table
		 * @return void
		 */
		public function insertFlagMusicTable()
			{
				echo $this->LANG['viewmusic_your_request'];
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
						' content_type=\'Music\' AND'.
						' content_id='.$this->dbObj->Param('content_id').' AND'.
						' reporter_id='.$this->dbObj->Param('reporter_id').' AND'.
						' status=\'Ok\'';

				$fields_value_arr = array($this->fields_arr['music_id'], $this->CFG['user']['user_id']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if(!$rs->PO_RecordCount())
					{
						if($this->fields_arr['flag'])
							{
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['flagged_contents'].' SET'.
										' content_id='.$this->dbObj->Param('content_id').','.
										' content_type=\'Music\', flag='.$this->dbObj->Param('flag').','.
										' flag_comment='.$this->dbObj->Param('flag_comment').','.
										' reporter_id='.$this->dbObj->Param('reporter_id').','.
										' date_added=NOW()';

								$insert_flag_values_arr = array($this->fields_arr['music_id'], $this->fields_arr['flag'],
																$this->fields_arr['flag_comment'], $this->CFG['user']['user_id']);

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $insert_flag_values_arr);
							    if (!$rs)
								    trigger_db_error($this->dbObj);
							}
						else if($this->fields_arr['flag_comment'])
							{
								$this->fields_arr['flag'] = $this->LANG['viewmusic_others_label'];
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['flagged_contents'].' SET'.
										' content_id='.$this->dbObj->Param('content_id').','.
										' content_type=\'Music\', flag='.$this->dbObj->Param('flag').','.
										' flag_comment='.$this->dbObj->Param('flag_comment').','.
										' reporter_id='.$this->dbObj->Param('reporter_id').','.
										' date_added=NOW()';

								$insert_flag_values_arr = array($this->fields_arr['music_id'], $this->fields_arr['flag'], $this->fields_arr['flag_comment'],
																	$this->CFG['user']['user_id']);
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $insert_flag_values_arr);
							    if (!$rs)
								    trigger_db_error($this->dbObj);
							}

							//Inform flagged music to admin through mail\\
							//Subject..
							$flagged_subject = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $this->LANG['music_flagged_subject']);
							$flagged_subject = str_replace('VAR_MUSIC_TITLE', $this->fields_arr['music_title'], $flagged_subject);
							//Content..
							$sql ='SELECT music_server_url, music_title, music_caption, music_thumb_ext'.
									' FROM '.$this->CFG['db']['tbl']['music'].
									' WHERE music_id='.$this->dbObj->Param('music_id').' LIMIT 0,1';

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
							if (!$rs)
								trigger_db_error($this->dbObj);

							$row = $rs->FetchRow();
							//music title
							$flagged_message = str_replace('VAR_MUSIC_TITLE', $row['music_title'], $this->LANG['music_flagged_content']);
							//music image
							$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].
													'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';

							$musiclink = getUrl('viewmusic','?music_id='.$this->fields_arr['music_id'].
											'&amp;title='.$this->changeTitle($row['music_title']), $this->fields_arr['music_id'].'/'.
												$this->changeTitle($row['music_title']).'/', 'root','music');
							if($row['music_thumb_ext'] != '')
								$music_thumbnail = $this->CFG['site']['url'].$musics_folder.
														getMusicImageName($this->fields_arr['music_id']).$this->CFG['admin']['musics']['thumb_name'].
															'.'.$row['music_thumb_ext'];
							else
								$music_thumbnail = $this->CFG['site']['url'].'music/design/templates/'.
														$this->CFG['html']['template']['default'].'/root/images/'.
															$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_T.jpg';

							$music_image = '<a href="'.$musiclink.'"><img border="0" src="'.
													$music_thumbnail.'" alt="'.$row['music_title'].'" title="'.$row['music_title'].'" /></a>';
							$flagged_message = str_replace('VAR_MUSIC_IMAGE', $music_image, $flagged_message);
							//music description
							$music_description = strip_tags($row['music_caption']);
							$flagged_message = str_replace('VAR_MUSIC_DESCRIPTION', $music_description, $flagged_message);
							//flagged title, flagged content
							$admin_link = $this->CFG['site']['url'].'admin/music/manageFlaggedMusic.php';
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
		 * ViewMusic::insertFeaturedMusic()
		 *
		 * @return void
		 */
		public function insertFeaturedMusic()
			{
				if($this->fields_arr['featured'])
					{
						if(getUserType($this->CFG['user']['user_id'])!='Artist')
							$this->deleteFromFeatured(false, $this->fields_arr['music_id']);
						$condition = 'music_id='.$this->dbObj->Param('music_id').' AND user_id='.$this->dbObj->Param('user_id');
						$condtionValue=array($this->fields_arr['music_id'],$this->CFG['user']['user_id']);
						if(!$this->selectFeaturedMusic($condition,$condtionValue))
							{

								/** REMOVE OLD FEATURED MUSIC ***/
								$fav_music_details['id'] = '';
								$sql = 'SELECT music_id FROM '.$this->CFG['db']['tbl']['music_featured'].
										' WHERE user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								if($row = $rs->FetchRow())
								{
									$fav_music_details['id'] = $row['music_id'];;
								}

								if($fav_music_details['id'])
								{
									$this->deleteFromFeatured(false, $fav_music_details['id']);
								}

								/*** INSERT NEW FEATURED MUSIC ***/
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_featured'].' SET'.
									' user_id='.$this->dbObj->Param('user_id').','.
									' music_id='.$this->dbObj->Param('music_id').','.
									' date_added=NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['music_id']));
								if (!$rs)
									trigger_db_error($this->dbObj);

								if($this->dbObj->Insert_ID())
									{
										$featured = $this->dbObj->Insert_ID();
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET total_featured = total_featured+1'.
												' WHERE music_id='.$this->dbObj->Param('music_id');
										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
										if (!$rs)
											trigger_db_error($this->dbObj);

										echo $this->LANG['viewmusic_featured_added_successfully'];

										//Srart Post Music featured Music activity	..
										$sql = 'SELECT mf.music_featured_id, mf.music_id, mf.user_id as featured_user_id,'.
												' u.user_name, m.music_title, m.user_id, m.music_server_url, m.music_thumb_ext '.
												'FROM '.$this->CFG['db']['tbl']['music_featured'].' as mf, '.
												$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['music'].' as m '.
												'WHERE u.user_id = mf.user_id AND mf.music_id = m.music_id AND mf.music_featured_id = '
												.$this->dbObj->Param('music_featured_id');

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($featured));
										if (!$rs)
											trigger_db_error($this->dbObj);

										$row = $rs->FetchRow();
										$activity_arr = $row;
										$activity_arr['action_key']	= 'music_featured';
										$musicActivityObj = new MusicActivityHandler();
										$musicActivityObj->addActivity($activity_arr);
										//end
									}
							}
						}
					else
						echo $this->LANG['viewmusic_featured_added_already'];
				}

		/**
		 * ViewMusic::getFeatured()
		 *
		 * @return array
		 */
		public function getFeatured()
			{
				$featured['added'] = '';
				$featured['id'] = '';
				$featured['url'] = '';
				if(!isMember())
					{
						$featured['url'] = $this->CFG['site']['music_url'].'listenMusic.php?music_id='.
											$this->fields_arr['music_id'].'&ajax_page=true&page=featured';
					}
				else
					{
						$condition= 'music_id='.$this->dbObj->Param('music_id').
								     ' AND user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';
						$condtionValue=array($this->fields_arr['music_id'], $this->CFG['user']['user_id']);
						$featured['url'] = $this->CFG['site']['music_url'].'listenMusic.php?music_id='.
												$this->fields_arr['music_id'].
													'&ajax_page=true&page=featured';

						if($rs = $this->selectFeaturedMusic($condition, $condtionValue, 'full'))
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
		 * ViewMusic::insertFavoriteMusic()
		 *
		 * @return void
		 */
		public function insertFavoriteMusic()
			{
				if($this->fields_arr['favorite'])
					{
						$condition = 'music_id='.$this->dbObj->Param('music_id').' AND user_id='.$this->dbObj->Param('user_id');
						$condtionValue = array($this->fields_arr['music_id'], $this->CFG['user']['user_id']);

						if(!$this->selectFavorite($condition, $condtionValue))
							{
								$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['music_favorite'].' SET'.
									   ' user_id='.$this->dbObj->Param('user_id').','.
									   ' music_id='.$this->dbObj->Param('music_id').','.
								       ' date_added=NOW()';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['music_id']));
								if (!$rs)
									trigger_db_error($this->dbObj);

								if($this->dbObj->Insert_ID())
									{
										$favorite_id = $this->dbObj->Insert_ID();
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET total_favorites = total_favorites+1'.
												' WHERE music_id='.$this->dbObj->Param('music_id');

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
										if (!$rs)
											trigger_db_error($this->dbObj);

										echo $this->LANG['viewmusic_favorite_added_successfully'];

										//Srart Post Music favorite Music activity	..
										$sql = 'SELECT mf.music_favorite_id, mf.music_id, mf.user_id as favorite_user_id, u.user_name, '.
												'm.music_title, m.user_id, m.music_server_url, m.music_thumb_ext '.
												'FROM '.$this->CFG['db']['tbl']['music_favorite'].' as mf, '.$this->CFG['db']['tbl']['users'].
												' as u, '.$this->CFG['db']['tbl']['music'].' as m '.
												' WHERE u.user_id = mf.user_id AND mf.music_id = m.music_id '.
												' AND mf.music_favorite_id = '.$this->dbObj->Param('favorite_id');

										$stmt = $this->dbObj->Prepare($sql);
										$rs = $this->dbObj->Execute($stmt, array($favorite_id));
										if (!$rs)
											trigger_db_error($this->dbObj);
										//todo error in this ..
										if($row = $rs->FetchRow())
										{
											$activity_arr = $row;
											$activity_arr['action_key']	= 'music_favorite';
											$musicActivityObj = new MusicActivityHandler();
											$musicActivityObj->addActivity($activity_arr);
										}
										//end
								}
							}
					}
			}


		/**
		 * ViewMusic::selectFavorite()
		 *
		 * @param string $condition
		 * @param array $value
		 * @param string $returnType
		 * @return mixed
		 */
		public function selectFavorite($condition, $value, $returnType='')
			{
				$sql = 'SELECT music_favorite_id FROM '.$this->CFG['db']['tbl']['music_favorite'].
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

		/**
		 * ViewMusic::getFavorite()
		 *
		 * @return array
		 */
		public function getFavorite()
			{
				$favorite['added']='';
				$favorite['id']='';
				if(!isMember())
					{
						$favorite['url'] = $this->CFG['site']['music_url'].'listenMusic.php?music_id='.
										  $this->fields_arr['music_id'].'&ajax_page=true&page=favorite';
					}
				else
					{
						$condition = 'music_id='.$this->dbObj->Param('music_id').
							 		 ' AND user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';

						$condtionValue = array($this->fields_arr['music_id'], $this->CFG['user']['user_id']);

						$favorite['url'] = $this->CFG['site']['music_url'].'listenMusic.php?music_id='.
											  $this->fields_arr['music_id'].'&ajax_page=true&page=favorite';

						if($rs = $this->selectFavorite($condition, $condtionValue, 'full'))
							{
								if($rs->PO_RecordCount())
									{
										$row = $rs->FetchRow();
										$favorite['added'] = true;
										$favorite['id'] = $row['music_favorite_id'];
									}
							}
					}
				return $favorite;
			}

		/**
		 * ViewMusic::postBlog()
		 *
		 * @return void
		 */
		public function postBlog()
			{
				$sql = 'SELECT blog_site, blog_title, blog_user_name, blog_password FROM '.$this->CFG['db']['tbl']['blogger'].' WHERE'.
						' blogger_id = '.$this->dbObj->Param('blogger_id').' AND'.
						' user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->getFormField('blog_title'), $this->CFG['user']['user_id']));
			    if (!$rs)
			        trigger_db_error($this->dbObj);

				$configXmlcode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['single_player']['config_name'].'.php?';
				$playlistXmlcode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['single_player']['playlist_name'].'.php?';
				$addsXmlCode_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['single_player']['ad_name'].'.php';
				$themesXml_url = $this->CFG['site']['url'].$this->CFG['admin']['musics']['single_player']['theme_path'].
													$this->CFG['admin']['musics']['single_player']['xml_theme'];

				$width = $this->CFG['admin']['musics']['single_player']['width'];
				$height = $this->CFG['admin']['musics']['single_player']['height'];

				$configXmlcode_url .= 'pg=music_'.$this->getFormField('music_id');
				$playlistXmlcode_url .= 'pg=music_'.$this->getFormField('music_id');

				if($row = $rs->FetchRow())
					{
						switch($row['blog_site'])
							{
								case 'blogger':
									if($blog_arr = getBlogLists($row['blog_user_name'], $row['blog_password']))
										{
											if($blog_detail = chkIsBlogAvailable($blog_arr, $row['blog_title']))
												{
													$embed_code = '<embed src="'.$this->CFG['site']['music_url'].'embedMusicPlayer.php?mid='.mvFileRayzz($this->getFormField('music_id')).'" FlashVars="configXmlPath='.
																	$configXmlcode_url.'_no_0_extsite&'.
																	'playListXmlPath='.$playlistXmlcode_url.'&themes='.$themesXml_url.'" quality="high" bgcolor="#000000" width="'.$width.'" height="'.$height.'" name="flvplayer" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />';
													postNewBlog($row['blog_user_name'], $row['blog_password'], $this->getFormField('blog_post_title'), $this->embeded_code_postBlog.'<br><br>'.$this->getFormField('blog_post_text'), $blog_detail['blogid']);
												}
										}
								break;
							}
					}
			}

		/**
		 * ViewMusic::populateRatingDetails()
		 *
		 * @return integer
		 */
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
		 * ViewMusic::getRating()
		 *
		 * @param integer $user_id
		 * @return integer
		 */
		public function getRating($user_id)
			{
				$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['music_rating'].
						' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
						' music_id='.$this->dbObj->Param('music_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id, $this->fields_arr['music_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						return $row['rate'];
					}
				return 0;
			}

		/**
		 * ViewMusic::chkAllowRating()
		 *
		 * @return void
		 */
		public function chkAllowRating()
			{
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE music_id='.$this->dbObj->Param('music_id').
						' AND allow_ratings=\'Yes\' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					return true;
				return false;
			}

		/**
		 * ViewMusic::chkAlreadyRated()
		 *
		 * @return boolean
		 */
		public function chkAlreadyRated()
			{
				$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['music_rating'].
						' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
						' music_id='.$this->dbObj->Param('music_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['music_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					return $row['rate'];
				return false;
			}

		/**
		 * ViewMusic::insertRating()
		 *
		 * @return void
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

								$sql = 'UPDATE '.$this->CFG['db']['tbl']['music_rating'].' SET'.
										' rate='.$this->dbObj->Param('rate').','.
										' date_added=NOW() '.
										' WHERE music_id='.$this->dbObj->Param('music_id').' AND '.
										' user_id='.$this->dbObj->Param('user_id');

								$update_fields_value_arr = array($this->fields_arr['rate'], $this->fields_arr['music_id'],
																$this->CFG['user']['user_id']);
								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, $update_fields_value_arr);
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								if($diff > 0)
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET'.
												' rating_total=rating_total+'.$diff.' '.
												' WHERE music_id='.$this->dbObj->Param('music_id');
									}
								else
									{
										$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET'.
												' rating_total=rating_total'.$diff.' '.
												' WHERE music_id='.$this->dbObj->Param('music_id');
									}

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								//Find rating for rating music activity..
								$sql = 'SELECT rating_id '.
										'FROM '.$this->CFG['db']['tbl']['music_rating'].' '.
										' WHERE music_id='.$this->dbObj->Param('music_id').' AND '.
										' user_id='.$this->dbObj->Param('user_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id'],  $this->CFG['user']['user_id']));
								if (!$rs)
									trigger_db_error($this->dbObj);

								$row = $rs->FetchRow();
								$rating_id = $row['rating_id'];
							}
						else
							{
								$sql =  'INSERT INTO '.$this->CFG['db']['tbl']['music_rating'].
										' (music_id, user_id, rate, date_added ) '.
										' VALUES ( '.
										$this->dbObj->Param('music_id').','.$this->dbObj->Param('user_id').','.$this->dbObj->Param('rate').',NOW()'.
										' ) ';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id'], $this->CFG['user']['user_id'], $this->fields_arr['rate']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);

								$rating_id = $this->dbObj->Insert_ID();

								$sql =  'UPDATE '.$this->CFG['db']['tbl']['music'].' SET'.
										' rating_total=rating_total+'.$this->fields_arr['rate'].','.
										' rating_count=rating_count+1'.
										' WHERE music_id='.$this->dbObj->Param('music_id');

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
							    if (!$rs)
								    trigger_db_error($this->dbObj);
							}


						//Srart Post Music rating Music activity	..
						$sql = 'SELECT mr.rating_id, mr.music_id, mr.user_id as rating_user_id, mr.rate, '.
								'u.user_name, m.music_title, m.user_id, m.music_server_url, m.music_thumb_ext '.
								'FROM '.$this->CFG['db']['tbl']['music_rating'].' as mr, '.
								$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['music'].' as m '.
								' WHERE u.user_id = mr.user_id AND mr.music_id = m.music_id AND mr.rating_id = '.
								$this->dbObj->Param('rating_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($rating_id));
						if (!$rs)
							trigger_db_error($this->dbObj);

						$row = $rs->FetchRow();
						$activity_arr = $row;
						$activity_arr['action_key']	= 'music_rated';
						$musicActivityObj = new MusicActivityHandler();
						$musicActivityObj->addActivity($activity_arr);
						//end
					}
			}

		/**
		 * viewMusic::getTotalRatingImage()
		 * purpose to populate rating images based on the rating of the music
		 * @return void
		 **/
		public function getTotalRatingImage()
			{
				if($this->populateMusiclistDetails())
					{
					    $rating = round($this->fields_arr['rating_total']/$this->fields_arr['rating_count'],0);
						$this->populateRatingImagesForAjax($rating);
						$rating_text = ($this->fields_arr['rating_count'] >1 )?$this->LANG['viewmusic_total_ratings']:$this->LANG['viewmusic_rating'];
						echo '<span>('.$this->fields_arr['rating_count'].' '.$rating_text.')</span>';
					}
			}

		/**
		 * viewMusic::populateRatingImagesForAjax()
		 * purpose to populate images for rating
		 * @param $rating
		 * @return void
		 **/
		public function populateRatingImagesForAjax($rating, $imagePrefix='')
			{
				$rating_total = $this->CFG['admin']['total_rating'];
				for($i=1;$i<=$rating;$i++)
					{
						?>
						<a onclick="return callAjaxRate('<?php echo $this->CFG['site']['music_url'].'listenMusic.php?ajax_page=true&music_id='.
							$this->fields_arr['music_id'].'&'.'rate='.$i;?>&show=<?php echo $this->fields_arr['show'];?>','selRatingMusic')"
							onmouseover="ratingMusicMouseOver(<?php echo $i;?>, 'player')" onmouseout="ratingMusicMouseOut(<?php echo $i;?>)">
							<img id="img<?php echo $i;?>" src="<?php echo $this->CFG['site']['music_url'].'design/templates/'.
							$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
							'/icon-audioratehover1.gif'; ?>" alt="<?php echo $i;?>"  title="<?php echo $i;?>" /></a>
						<?php
					}
				for($i=$rating;$i<$rating_total;$i++)
					{
						?>
						<a onclick="return callAjaxRate('<?php echo $this->CFG['site']['music_url'].'listenMusic.php?ajax_page=true&music_id='.
						$this->fields_arr['music_id'].'&'.'rate='.($i+1);?>&amp;amp;show=<?php echo $this->fields_arr['show'];?>','selRatingMusic')"
						 onmouseover="ratingMusicMouseOver(<?php echo ($i+1);?>, 'player')" onmouseout="ratingMusicMouseOut(<?php echo ($i+1);?>)">
						 <img id="img<?php echo ($i+1);?>" src="<?php echo $this->CFG['site']['music_url'].'design/templates/'.
						 $this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
						 '/icon-audiorate1.gif'; ?>" alt="<?php echo $i;?>" title="<?php echo ($i+1);?>" /></a>
						 <?php
					}
			}

		/**
		 * ViewMusic::populateMusiclistDetails()
		 *
		 * @return boolean
		 */
		public function populateMusiclistDetails()
			{
				$sql = 'SELECT rating_total, rating_count FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE music_id='.$this->dbObj->Param('music_id').' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
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
		 * ViewMusic::populateMusicDetails()
		 *
		 * @return boolean
		 */
		public function populateMusicDetails()
			{
				$sql = 'SELECT music_ext, music_title, music_server_url, thumb_width, thumb_height'.
						' FROM '.$this->CFG['db']['tbl']['music'].
						' WHERE music_id='.$this->dbObj->Param('music_id').' AND'.
						' music_status=\'Ok\' LIMIT 0,1';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						$this->fields_arr['music_ext'] = $row['music_ext'];
						$this->fields_arr['music_title'] = $row['music_title'];
						$this->fields_arr['music_server_url'] = $row['music_server_url'];
						$this->fields_arr['thumb_width'] = $row['thumb_width'];
						$this->fields_arr['thumb_height'] = $row['thumb_height'];
						return true;
					}
				return false;
			}

		/**
		 * ViewMusic::replaceAdultText()
		 *
		 * @param mixed $text
		 * @return
		 */
		public function replaceAdultText($text)
			{
				$text = str_replace('VAR_AGE_LIMIT', $this->CFG['admin']['musics']['adult_minimum_age'], $text);
				$text = str_replace('VAR_SITE_NAME', $this->CFG['site']['name'], $text);
				return nl2br($text);
			}

		/**
		 * ViewMusic::populateMusicDetails()
		 *
		 * @return boolean
		 */
		 public function checkDownloadOption()
			{

				/*if($this->fields_arr['music_upload_type']=='externalsitemusicourl')
				{
					require_once($this->CFG['site']['project_path'].'common/classes/class_ExternalVideoUrlHandler.lib.php');
					$extHandler=new ExternalVideoUrlHandler();
					$checkUrl=$extHandler->chkIsValidExternalSite($this->fields_arr['external_site_music_url'],'',$this->CFG);
					if($checkUrl['external_site']=='youtube')
					{
						if(!$this->CFG['admin']['musics']['download_youtube_musics'])
							return false;
					}
					else if($checkUrl['external_site']=='google')
					{
						if(!$this->CFG['admin']['musics']['download_google_musics'])
							return false;

					}
					else if($checkUrl['external_site']=='dailymotion')
					{
						if(!$this->CFG['admin']['musics']['download_dailymotion_musics'])
							return false;

					}
					else if($checkUrl['external_site']=='myspace')
					{
						if(!$this->CFG['admin']['musics']['download_myspace_musics'])
							return false;

					}
					else if($checkUrl['external_site']=='flvpath')
					{
						if(!$this->CFG['admin']['musics']['download_flvpath_musics'])
							return false;

					}
					return true;
				}*/
				return true;
			}

		/**
		 * ViewMusic::populateOriginalFormatDownloadLink()
		 *
		 * @return
		 */
		public function populateOriginalFormatDownloadLink()
			{
				if($this->CFG['user']['user_id']!=$this->fields_arr['user_id'])
					{
						if(($this->CFG['admin']['musics']['full_length_audio']=='members' AND !isloggedIn())
							OR ($this->CFG['admin']['musics']['full_length_audio']=='paid_members' AND !isPaidMember()))
							{

								return false;
							}
					}

				if($this->CFG['admin']['musics']['download_previlages']=='members' && !isLoggedin())
					$folder='members';
				else
					$folder='';


				if($this->getFormField('music_ext'))
					{
						if(($this->CFG['admin']['musics']['download_previlages']=='members' AND isLoggedin()) OR ($this->CFG['admin']['musics']['download_previlages']=='All'))
							{

							?><li><a href="<?php echo getUrl($this->getDownloadFileName(),'?music_id='.$this->getFormField('music_id').'&amp;music_type=original', 'original/'.$this->getFormField('music_id').'/',$folder,'music');?>" ><?php echo $this->getFormField('music_ext');  ?><?php echo ($total_original_format_downloads=
								$this->getOtherFormatTotalDownload($this->getFormField('music_ext'), $this->getFormField('music_id'))?'('.$total_original_format_downloads:' (0'); echo ' '.$this->LANG['viewmusic_downloads'].')'; ?></a>

						<?php
							}
						else
							{

								?><li><a href="<?php echo getUrl($this->getDownloadFileName(),'?music_id='.$this->getFormField('music_id').'&amp;music_type=original', 'original/'.$this->getFormField('music_id').'/','members','music');?>"><?php echo $this->getFormField('music_ext');  ?><?php echo ($total_original_format_downloads=
								$this->getOtherFormatTotalDownload($this->getFormField('music_ext'), $this->getFormField('music_id'))?'('.$total_original_format_downloads:' (0'); echo ' '.$this->LANG['viewmusic_downloads'].')'; ?></a></li><?php
							}
					}
			}

		/**
		 * ViewMusic::populateOtherFormatDownloadLink()
		 *
		 * @return boolean
		 */
		public function populateOtherFormatDownloadLink()
			{

				if($this->CFG['user']['user_id']!=$this->fields_arr['user_id'])
					{
						if(($this->CFG['admin']['musics']['full_length_audio']=='members' AND !isloggedIn()) OR
							($this->CFG['admin']['musics']['full_length_audio']=='paid_members' AND !isPaidMember()))
							{
								return false;
							}
					}

				if($this->CFG['admin']['musics']['download_previlages']=='members' && !isLoggedin())
					$folder='members';
				else
					$folder='';

				foreach($this->fields_arr['music_available_formats'] as $index=>$type)
					{
						if($type!=$this->getFormField('music_ext'))
							{
							?><li>
								<?php
									if(($this->CFG['admin']['musics']['download_previlages']=='members' AND isLoggedin()) OR ($this->CFG['admin']['musics']['download_previlages']=='All'))
									{

									?><a href="<?php echo getUrl($this->getDownloadFileName(),'?music_id='.$this->fields_arr['music_id'].'&amp;music_type='.$type, $type.'/'.$this->fields_arr['music_id'].'/',$folder,'music');?>" ><?php echo $type ?><?php echo ($total_other_format_downloads=$this->getOtherFormatTotalDownload($type, $this->fields_arr['music_id']))?' ('.$total_other_format_downloads:' (0'; echo ' '.$this->LANG['viewmusic_downloads'].')'; ?></a>
										<?php
									}
									else
									{
										?><a href="<?php echo getUrl($this->getDownloadFileName(),'?music_id='.$this->getFormField('music_id').'&amp;music_type='.$type, $type.'/'.$this->getFormField('music_id').'/','members','music');?>"><?php echo $type ?><?php echo ($total_other_format_downloads=$this->getOtherFormatTotalDownload($type, $this->fields_arr['music_id']))?' ('.$total_other_format_downloads:' (0'; echo ' '.$this->LANG['viewmusic_downloads'].')'; ?></a><?php
									}
								}
								?></li>
							<?php
							}
			}

		/**
		 * ViewMusic::getDownloadFileName()
		 *
		 * @return string
		 */
		public function getDownloadFileName()
			{
				if($this->CFG['admin']['musics']['download_previlages']=='members' || $this->CFG['admin']['musics']['download_previlages']=='paid_members')
					{
						$downloadFileName='membermusicdownload';
					}
				else
					{
						$downloadFileName='musicdownload';
					}
				return $downloadFileName;
			}

		/**
		 * ViewMusic::isTrimmedMusic()
		 *
		 * @return boolean
		 */
		public function isTrimmedMusic()
			{
				$trimmedMusic = false;

				if($this->CFG['user']['user_id']==$this->fields_arr['user_id'])
					{
						return $trimmedMusic;
					}
				if((($this->fields_arr['album_for_sale']=='Yes' AND !isUserAlbumPurchased($this->fields_arr['music_album_id']))
						OR ($this->fields_arr['for_sale']=='Yes' AND !isUserPurchased($this->fields_arr['music_id']))) AND !isloggedIn())
					{
						$link = '<a href="'.getUrl('viewmusic','?mem_auth=true&music_id='.$this->fields_arr['music_id'], $this->fields_arr['music_id'].'/?mem_auth=true','members','music' ).'">'.$this->LANG['viewmusic_trimmed_click_here'].'</a>';
						$this->trimmendMessage = str_replace('VAR_LINK',$link,$this->LANG['viewmusic_trimmed_music_message_purchase_member']);
						$trimmedMusic =true;
					}
				else if(($this->fields_arr['album_for_sale']=='Yes' AND !isUserAlbumPurchased($this->fields_arr['music_album_id']))
						OR ($this->fields_arr['for_sale']=='Yes' AND !isUserPurchased($this->fields_arr['music_id'])))
					{
						$this->trimmendMessage = $this->LANG['viewmusic_trimmed_music_message_purchase'];
						$trimmedMusic =true;
					}
				else if($this->CFG['admin']['musics']['full_length_audio']=='members' AND !isloggedIn())
					{
						$link = '<a href="'.getUrl('signup').'">'.$this->LANG['viewmusic_trimmed_click_here'].'</a>';
						$this->trimmendMessage = str_replace('VAR_LINK',$link,$this->LANG['viewmusic_trimmed_music_message_member']);
						$trimmedMusic =true;
					}

				else if($this->CFG['admin']['musics']['full_length_audio']=='paid_members' AND !isPaidMember())
					{
						$link = '<a href="'.getUrl('upgrademembership','','','members').'">'.$this->LANG['viewmusic_trimmed_click_here'].'</a>';
						$this->trimmendMessage = str_replace('VAR_LINK',$link,$this->LANG['viewmusic_trimmed_music_message_paidmember']);
						$trimmedMusic =true;
					}


				return $trimmedMusic;
			}

		public function getTagsForMusicList($music_tags){
			// change the function for display the tags with some more...
			global $smartyObj;

			$tags_arr = explode(' ', $music_tags);

			$getMusicTags_arr = array();
			for($i=0;$i<count($tags_arr);$i++){
				//if($i<8){
					//decoded first since this adds the length of the html entities too done while sanitizing
					if(strlen(htmlspecialchars_decode($tags_arr[$i])) > 8 and strlen(htmlspecialchars_decode($tags_arr[$i])) > 8+3)
						$getTagsLink_arr[$i]['title_tag_name'] = $getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = $tags_arr[$i];
					else
						$getTagsLink_arr[$i]['title_tag_name'] = $getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = $tags_arr[$i];
					$getTagsLink_arr[$i]['tag_url'] = getUrl('musiclist', '?pg=musicnew&tags='.$tags_arr[$i], 'musicew/?tags='.$tags_arr[$i], '', 'music');
				//}
			}

			$smartyObj->assign('getTagsLink_arr', $getTagsLink_arr);
			setTemplateFolder('general/', 'music');
			$smartyObj->display('populateTagsLinks.tpl');
		}

		/**
		 * viewMusic::chkisMusicOwner()
		 *
		 * @return
		 */
		public function chkisMusicOwner()
			{
				$sql = 'SELECT music_id FROM '.$this->CFG['db']['tbl']['music'].' AS m'.
						' WHERE m.music_id = '.$this->dbObj->Param('music_id').' AND m.user_id = '.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id'], $this->CFG['user']['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();

				if($row['music_id'] != '')
					return true;
				return false;
			}
		/**
		 * viewMusic::checkSameUserInComment()
		 *
		 * @param srting $err_msg
		 * @param boolean $chk_music_owner
		 *
		 * @return boolean
		 */
		public function checkSameUserInComment($err_msg, $chk_music_owner = false)
		{
			if($chk_music_owner)
			{
				$music_owner_status = $this->chkisMusicOwner();
				if($music_owner_status)
				{
					return $music_owner_status;
				}
			}

			$sql = 'SELECT music_comment_id FROM '.$this->CFG['db']['tbl']['music_comments'].' AS m'.
					' WHERE m.music_id = '.$this->dbObj->Param('music_id').
					' AND m.comment_user_id = '.$this->dbObj->Param('comment_user_id').
					' AND m.music_comment_id = '.$this->dbObj->Param('music_comment_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_id'], $this->CFG['user']['user_id'], $this->fields_arr['comment_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);

			$row = $rs->FetchRow();

			if($row['music_comment_id'] != '')
			{
				return true;
			}
			else
			{
				echo $err_msg;
				echo 'ERR~';
				exit;
			}
		}
	}
$viewMusic = new ViewMusic();
$viewMusic->resultFound = false;

if(!chkAllowedModule(array('music')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);

if(isMember())
	$viewMusic->setMediaPath('../');
else
	$viewMusic->setMediaPath('../');


$viewMusic->setPageBlockNames(array('block_viewmusic_musicdetails', 'block_viewmusic_statistics', 'block_view_music_people_listened', 'delete_confirm_form', 'get_code_form',
									'confirmation_flagged_form', 'add_comments', 'add_reply', 'edit_comment', 'block_view_music_more_musics',
									'update_comment', 'rating_image_form', 'add_flag_list', 'add_fovorite_list', 'block_view_music_player',
									'confirmation_adult_form', 'block_view_music_main','block_add_comments','block_image_display', 'music_comments_block'));

//default form fields and values...
$viewMusic->setFormField('music_id', '');
$viewMusic->setFormField('total_downloads', '0');
$viewMusic->setFormField('music_caption', '');
$viewMusic->setFormField('vpkey', '');
$viewMusic->setFormField('action', '');
$viewMusic->setFormField('comment_id', '');
$viewMusic->setFormField('maincomment_id', '');
$viewMusic->setFormField('action', '');
$viewMusic->setFormField('music_code', '');
$viewMusic->setFormField('music_title', '');
$viewMusic->setFormField('user_name', '');
$viewMusic->setFormField('user_id', '');
$viewMusic->setFormField('album_id', '');
$viewMusic->setFormField('album_title', '');
$viewMusic->setFormField('music_subcategory_type', '');
$viewMusic->setFormField('music_category_type', '');
$viewMusic->setFormField('music_sub_category_id', '');
$viewMusic->setFormField('music_category_id', '');
$viewMusic->setFormField('music_category_name', '');
//for ajax
$viewMusic->setFormField('comment_id',0);
$viewMusic->setFormField('f',0);
$viewMusic->setFormField('show','1');
$viewMusic->setFormField('type','');
$viewMusic->setFormField('ajax_page','');
$viewMusic->setFormField('paging','');
$viewMusic->setFormField('rate', '');
$viewMusic->setFormField('flag', '');
$viewMusic->setFormField('page', '');
$viewMusic->setFormField('favorite_id', '');
$viewMusic->setFormField('music_tags', '');
$viewMusic->setFormField('play_list', '');//  This can be "ql" / "pl". means that Quick List and Play List. When play_list. Need play list id
$viewMusic->setFormField('playlist_description', '');
$viewMusic->setFormField('playlist_tags', '');
$viewMusic->setFormField('allow_comments', '');
$viewMusic->setFormField('allow_embed', '');
$viewMusic->setFormField('allow_ratings', '');
$viewMusic->setFormField('playlist_access_type', 'Public');
$viewMusic->setFormField('playlist', '');
$viewMusic->setFormField('playlist_id', '');
$viewMusic->setFormField('playlist_name', '');
$viewMusic->setFormField('flag_comment', '');
$viewMusic->setFormField('favorite', '');
$viewMusic->setFormField('featured', '');
$viewMusic->setFormField('order', '');
$viewMusic->setFormField('blog_title', '');
$viewMusic->setFormField('blog_post_title', '');
$viewMusic->setFormField('blog_post_text', '');
$viewMusic->setFormField('allow_response', '');
$viewMusic->setFormField('flagged_content', '');
$viewMusic->setFormField('recaptcha_challenge_field', '');
$viewMusic->setFormField('recaptcha_response_field', '');
$viewMusic->setFormField('relatedMusic', '');
$viewMusic->setFormField('org_music_artist', '');
$viewMusic->setFormField('msg', '');
$viewMusic->setFormField('peopleListenedMusic', '');
$viewMusic->setFormField('listenedstart', '0');
$viewMusic->setFormField('recaptcha_challenge_field', '');
$viewMusic->setFormField('recaptcha_response_field', '');
$viewMusic->flag_type_arr = $LANG_LIST_ARR['flag']['music'];
// ********** Page Navigation Start ********
$viewMusic->setFormField('start', '0');
$viewMusic->setFormField('numpg', 3);
//$viewMusic->setFormField('numpg', $CFG['data_tbl']['numpg']);

$viewMusic->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$viewMusic->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$viewMusic->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$viewMusic->setTableNames(array());
$viewMusic->setReturnColumns(array());
// *********** page Navigation stop ************


$viewMusic->sanitizeFormInputs($_REQUEST);
$viewMusic->resultFound();

//Added the Config and Playlist xml code vars to populate the Embed
$flv_player_url = $CFG['site']['url'].$CFG['admin']['musics']['single_player']['player_path'].
								$CFG['admin']['musics']['single_player']['swf_name'].'.swf';
$configXmlcode_url = $CFG['site']['url'].$CFG['admin']['musics']['single_player']['config_name'].'.php?';
$playlistXmlcode_url = $CFG['site']['url'].$CFG['admin']['musics']['single_player']['playlist_name'].'.php?';
$addsXmlCode_url = $CFG['site']['url'].$CFG['admin']['musics']['single_player']['ad_name'].'.php';
$themesXml_url = $CFG['site']['url'].$CFG['admin']['musics']['single_player']['theme_path'].
									$CFG['admin']['musics']['single_player']['xml_theme'];
$configXmlcode_url .= 'pg=music_'.$viewMusic->getFormField('music_id').'_extsite';
$playlistXmlcode_url .= 'pg=music_'.$viewMusic->getFormField('music_id');
$musicId=mvFileRayzz($viewMusic->getFormField('music_id'));
$viewMusic->embeded_code = htmlentities('<script type="text/javascript" src="'.$CFG['site']['music_url'].'embedmusic/?mid='.$viewMusic->getFormField('music_id').'"></script>');
//Checked the Embed type, if html is set as embed type it displays the follwing embed code other wise set script type as default
if(isset($CFG['admin']['musics']['embed_method']) and $CFG['admin']['musics']['embed_method']=='html')
	$viewMusic->embeded_code = htmlentities('<embed src="'.$CFG['site']['music_url'].'embedMusicPlayer.php?mid='.$viewMusic->getFormField('music_id').'_'.$musicId.'" FlashVars="configXmlPath='.$configXmlcode_url.'&playListXmlPath='.$playlistXmlcode_url.'&themes='.$themesXml_url.'" quality="high" bgcolor="#000000" width="'.$CFG['admin']['musics']['single_player']['width'].'" height="'.$CFG['admin']['musics']['single_player']['height'].'" name="flvplayer" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" allowFullScreen="true"/>');

if($CFG['admin']['musics']['download_previlages']=='members' && isLoggedin())
	$folder='members';
else
	$folder='';

$profile_blog_text = '<a href=\''.getUrl('profileblog', '?music_id='.$viewMusic->getFormField('music_id'), '?music_id='.$viewMusic->getFormField('music_id'), 'members', 'music').'\'>'.$LANG['viewmusic_setup_new_blog'].'</a>';
$LANG['viewmusic_posted_your_blog'] = str_replace('VAR_SETUP_NEW_BLOG', $profile_blog_text, $LANG['viewmusic_posted_your_blog']);

$viewMusic->musicDownloadUrl	= getUrl($viewMusic->getDownloadFileName(),'?music_id='.$viewMusic->getFormField('music_id').'&music_type=mp3', 'mp3/'.
									   $viewMusic->getFormField('music_id').'/',$folder,'music');

//START SINGLE PLAYER ARRAY FIELDS
$auto_play =  'false';
if($CFG['admin']['musics']['single_player']['AutoPlay'])
	$auto_play = 'true';

$music_fields = array(
	'div_id' => 'flashcontetnt',
	'music_player_id' => 'view_music_player',
	'height' => '',
	'width' => '',
	'auto_play' => $auto_play
);
$smartyObj->assign('music_fields', $music_fields);
//END SINGLE PLAYER ARRAY FIELDS

$viewMusic->memberLoginMusicUrl = getUrl('viewmusic','?mem_auth=true&music_id='.$viewMusic->getFormfield('music_id').'&title='.
																		$viewMusic->changeTitle($viewMusic->getFormfield('music_title')),
																			$viewMusic->getFormfield('music_id').'/'.
																				$viewMusic->changeTitle($viewMusic->getFormfield('music_title')).
																					'/?mem_auth=true','members', 'music');


if(isAjaxPage())
	{
		$viewMusic->includeAjaxHeaderSessionCheck();
		if ($viewMusic->getFormField('action')=='popplaylist')
	    {
	    	$viewMusic->checkLoginStatusInAjax($viewMusic->memberLoginMusicUrl);
			$viewMusic->populatePlaylist();
			die();
	    }
	    if($viewMusic->getFormField('page') != 'playlist')
			$viewMusic->validate = $viewMusic->chkValidMusicId();

		//Add to blog
		if($viewMusic->getFormField('action') and $viewMusic->getFormField('action')=='post_blog')
			{
				if(!$viewMusic->chkIsNotEmpty('blog_post_title') OR !$viewMusic->chkIsNotEmpty('blog_post_text'))
					{
						echo $LANG['mandatory_fields_compulsory'];
						die();
					}

				$viewMusic->embeded_code_postBlog = '<script type="text/javascript" src="'.$CFG['site']['url'].'music/embedmusic/?mid='.$viewMusic->getFormField('music_id').'"></script>';
				$viewMusic->postBlog();
				die();
			}

		//MORE CONTENT START//
		if ($viewMusic->isPageGETed($_POST, 'vUserFetch'))
		    {
				$viewMusic->populateRelatedMusic('user');
				die();
		    }
		if ($viewMusic->isPageGETed($_POST, 'vTagFetch'))
		    {
		    	$viewMusic->populateRelatedMusic('tag');
				die();
		    }
		if ($viewMusic->isPageGETed($_POST, 'vTopFetch'))
		    {
				$viewMusic->populateRelatedMusic('top');
				die();
			}
		if ($viewMusic->isPageGETed($_POST, 'vArtistFetch'))
		    {
				$viewMusic->populateRelatedMusic('artist');
				die();
			}
		if($viewMusic->getFormField('relatedMusic'))
			{
		  		$viewMusic->populateRelatedMusic($viewMusic->getFormField('type'));
				exit;
			}
		if($viewMusic->getFormField('peopleListenedMusic'))
			{
				$viewMusic->populatePeopleListened(true);
				exit;
			}

		if($viewMusic->isFormGETed($_GET, 'rate'))
			{
				if($viewMusic->chkAllowRating())
					{
						$viewMusic->setAllPageBlocksHide();
						$viewMusic->checkLoginStatusInAjax($viewMusic->memberLoginMusicUrl);
						$viewMusic->insertRating();
						$viewMusic->getTotalRatingImage();
						die();
					}
			}
		else if($viewMusic->isFormGETed($_POST, 'flag')
				or $viewMusic->isFormGETed($_POST, 'flag_comment'))
		{
			$viewMusic->setAllPageBlocksHide();
			if(!$viewMusic->chkIsNotEmpty('flag_comment', $LANG['viewmusic_flag_comment_invalid']))
			{
				echo $viewMusic->getFormFieldErrorTip('flag_comment');
				exit;
			}
			$viewMusic->setFormField('flag_comment',trim(urldecode($viewMusic->getFormField('flag_comment'))));
			$viewMusic->checkLoginStatusInAjax($viewMusic->memberLoginMusicUrl);
			$viewMusic->insertFlagMusicTable();
		}
		else if($viewMusic->isFormGETed($_GET, 'favorite'))
		{
			$viewMusic->setAllPageBlocksHide();
			$viewMusic->checkLoginStatusInAjax($viewMusic->memberLoginMusicUrl);
			if($viewMusic->getFormField('favorite'))
			{
				$viewMusic->insertFavoriteMusic();
			}
			else
			{
				$viewMusic->deleteFavoriteMusic($viewMusic->getFormField('music_id'),$CFG['user']['user_id']);
				echo $viewMusic->LANG['viewmusic_favorite_deleted_successfully'];
			}
		}
		else if($viewMusic->isFormGETed($_GET, 'featured'))
		{
			$viewMusic->setAllPageBlocksHide();
			$viewMusic->checkLoginStatusInAjax($viewMusic->memberLoginMusicUrl);
			if($viewMusic->getFormField('featured'))
			{
				$viewMusic->insertFeaturedMusic();
			}
			else
				$viewMusic->deleteFromFeatured(true, $viewMusic->getFormField('music_id'));

		}

		if ($viewMusic->isPageGETed($_POST, 'ajaxpaging'))
		    {
				$viewMusic->populateCommentOfThisMusic();
				ob_end_flush();
				die();
		    }

		if($viewMusic->getFormField('page') != '')
			{
				switch ($viewMusic->getFormField('page'))
					{
						case 'load_flag':
							$viewMusic->populateFlagContent();
							break;

						case 'load_blog':
							$viewMusic->checkLoginStatusInAjax($viewMusic->memberLoginMusicUrl);
							$viewMusic->populateBlogContent();
							exit;
							break;

						case 'post_comment':
							$viewMusic->checkLoginStatusInAjax($viewMusic->memberLoginMusicUrl);
							if($CFG['admin']['musics']['captcha'] AND $CFG['admin']['musics']['captcha_method'] == 'recaptcha'
										AND $CFG['captcha']['public_key'] AND $CFG['captcha']['private_key'])
								{
									$viewMusic->chkIsCaptchaNotEmpty('recaptcha_response_field', $LANG['common_err_tip_compulsory']) AND
										$viewMusic->chkCaptcha('recaptcha_response_field', $LANG['common_err_tip_invalid_captcha']);
								}
							$viewMusic->setAllPageBlocksHide();
							$htmlstring = trim(urldecode($viewMusic->getFormField('f')));
							$htmlstring = strip_tags(html_entity_decode($htmlstring), '<br><br />');
							$viewMusic->setFormField('f',$htmlstring);
							$viewMusic->insertCommentAndMusicTable();
							break;
						case 'deletecomment':
							$viewMusic->checkLoginStatusInAjax($viewMusic->memberLoginMusicUrl);
							$viewMusic->checkSameUserInComment($LANG['common_login_other_user_comment_delete_err_msg'], true);
							$viewMusic->deleteComment();
							$viewMusic->populateCommentOfThisMusic();
							break;

						case 'deletecommentreply':
							$viewMusic->checkLoginStatusInAjax($viewMusic->memberLoginMusicUrl);
							$viewMusic->checkSameUserInComment($LANG['common_login_other_user_comment_delete_err_msg'], true);
							$viewMusic->deleteComment();
							$viewMusic->populateReplyCommentOfThisMusic();
							break;

						case 'comment_edit':
							echo $viewMusic->getFormField('comment_id');
							echo '***--***!!!';
							$viewMusic->checkLoginStatusInAjax($viewMusic->memberLoginMusicUrl);
							$viewMusic->checkSameUserInComment($LANG['common_login_other_user_comment_edit_err_msg']);
							$viewMusic->getEditCommentBlock();
							break;

						case 'update_comment':
							$viewMusic->checkLoginStatusInAjax($viewMusic->memberLoginMusicUrl);
							$viewMusic->checkSameUserInComment($LANG['common_login_other_user_comment_edit_err_msg']);
							$htmlstring = trim(urldecode($viewMusic->getFormField('f')));
							$htmlstring = strip_tags(html_entity_decode($htmlstring), '<br><br />');
							$viewMusic->setFormField('f',$htmlstring);
							$viewMusic->updateCommentAndMusicTable();
							echo $viewMusic->getFormField('comment_id');
							echo '***--***!!!';
							echo $viewMusic->getFormField('f');
							break;

						case 'getcode':
							$viewMusic->setAllPageBlocksHide();
							$viewMusic->setPageBlockShow('get_code_form');
							$viewMusic->setFormField('image_width', $CFG['admin']['musics']['thumb_width']);
							$viewMusic->populateMusicDetails();

							if ($viewMusic->isShowPageBlock('get_code_form'))
							    {
									?>
									<div id="groupAdd">
							  			<h2><span><?php echo $LANG['viewmusic_codes_to_display'];?></span></h2>

							  			<form name="formGetCode" id="formInvite" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
							    		<p class="clsPaddingTop5">
							      			<textarea class="clsEmbedCodeTextFields" rows="5" cols="75" name="image_code" id="image_code" READONLY tabindex="5" onFocus="this.select()" onClick="this.select()" ><?php echo $viewMusic->embeded_code;?></textarea>
							    		</p>
							  			</form>
										<p>
							  			<input class="clsSubmitButton" onClick="return hideAllBlocks();" value="<?php echo $LANG['viewmusic_cancel'];?>" type="button" />
							  			</p>
									</div>
								<?php
								}
							break;
						case 'playlist':

							$viewMusic->setAllPageBlocksHide();
							$viewMusic->checkLoginStatusInAjax($viewMusic->memberLoginMusicUrl);
							# Add music to playlist
							$flag = 1;
							if($viewMusic->getFormField('playlist_name')!= '')
							{
								# Check already exist
								if(!$viewMusic->chkPlaylistExits('playlist_name', $LANG['viewplaylist_tip_alreay_exists']))
								{
									$flag =0;
									echo $viewMusic->getFormFieldErrorTip('playlist_name');
								}
								$subject = str_replace('VAR_MIN', $CFG['fieldsize']['music_playlist_name']['min'], $LANG['viewplaylist_invalid_size']);
								$subject = str_replace('VAR_MAX', $CFG['fieldsize']['music_playlist_name']['max'], $subject);
								if(!$viewMusic->chkIsValidSize('playlist_name', 'music_playlist_name', $subject))
								{
									$flag =0;
									echo $viewMusic->getFormFieldErrorTip('playlist_name');
								}
							}
							if($viewMusic->getFormField('playlist_tags')!= '')
							{
								$subject = str_replace('VAR_MIN', $CFG['fieldsize']['music_playlist_tags']['min'], $LANG['viewplaylist_err_tip_invalid_tag']);
								$subject = str_replace('VAR_MAX', $CFG['fieldsize']['music_playlist_tags']['max'], $subject);
								if(!$viewMusic->chkValidTagList('playlist_tags', 'music_playlist_tags', $subject))
								{
									$flag =0;
									echo $viewMusic->getFormFieldErrorTip('playlist_tags');
								}
							}

							if($flag)
								{
									if($viewMusic->isFormGETed($_POST, 'playlist') && $viewMusic->chkIsNotEmpty('playlist',''))
									{
										$playlist_id = $viewMusic->getFormField('playlist');
										echo sprintf($LANG['viewplaylist_successfully_msg'],$viewMusic->getFormField('playlist_name'));
										echo '#$#'.$playlist_id;
									}
									else
									{
										# Create new playlist
										$playlist_id = $viewMusic->createPlaylist();
										$viewMusic->playlistCreateActivity($playlist_id);
										echo sprintf($LANG['viewplaylist_successfully_msg'],$viewMusic->getFormField('playlist_name'));
										echo '#$#'.$playlist_id;
									}
									# INSERT SONG TO PLAYLIST SONG
									$song_id = explode(',', $viewMusic->getFormField('music_id'));
									for($inc=0;$inc<count($song_id);$inc++)
										$viewMusic->insertSongtoPlaylist($playlist_id, $song_id[$inc]);
								}
							break;
					}
				$viewMusic->includeAjaxFooter();
				exit;
			}
	}
else
	{
		//MORE CONTENT START //
		$_SESSION['vUserStart'] = 0;
		$_SESSION['vTagStart'] = 0;
		$_SESSION['vTopStart'] = 0;
		$_SESSION['vArtistStart'] = 0;
		//MORE CONTENT END //
		$viewMusic->validate = false;
		$viewMusic->IS_USE_AJAX = true;
		$viewMusic->validate = $viewMusic->chkValidMusicId();
		//$LANG['meta_listenmusic_title'] = $viewMusic->getFormField('music_title');

		$LANG['meta_listenmusic_keywords'] = str_replace('{default_tags}', $CFG['html']['meta']['keywords'], $LANG['meta_listenmusic_keywords']);
		$LANG['meta_listenmusic_keywords'] = str_replace('{tags}', $viewMusic->getFormField('music_tags'), $LANG['meta_listenmusic_keywords']);

		$LANG['meta_listenmusic_description'] = str_replace('{default_tags}', $CFG['html']['meta']['description'], $LANG['meta_listenmusic_description']);
		$music_caption = $viewMusic->getFormField('music_caption');
		$LANG['meta_listenmusic_description'] = str_replace('{tags}', $music_caption, $LANG['meta_listenmusic_description']);

		$LANG['meta_listenmusic_title'] = str_replace('{site_title}', $CFG['site']['title'], $LANG['meta_listenmusic_title']);
		$LANG['meta_listenmusic_title'] = str_replace('{module}', $LANG['window_title_music'], $LANG['meta_listenmusic_title']);

		$LANG['meta_listenmusic_title'] = str_replace('{title}', $viewMusic->getFormField('music_title'), $LANG['meta_listenmusic_title']);

		setPageTitle($LANG['meta_listenmusic_title']);
		setMetaKeywords($LANG['meta_listenmusic_keywords']);
		setMetaDescription($LANG['meta_listenmusic_description']);



		if($viewMusic->isFormGETed($_GET, 'action'))
			{
				$display = 'error';
				if(($viewMusic->getFormField('action')=='view' or $viewMusic->getFormField('action')=='accept' or $viewMusic->getFormField('action')=='reject') and $viewMusic->validate)
					{

					if(isAdultUser('allow'))
						$display = 'music';
					else
						{
							if($CFG['admin']['musics']['adult_content_view']!='No')
								$display = 'music';
							else
								$display = 'error';
						}
					switch($display)
						{
							case 'error':
								$viewMusic->setAllPageBlocksHide();
								$viewMusic->setCommonErrorMsg($viewMusic->replaceAdultText($LANG['msg_error_not_allowed']));
								$viewMusic->setPageBlockShow('block_msg_form_error');
								break;

							case 'music':
								switch($viewMusic->getFormField('action'))
									{
										case 'accept':
											$viewMusic->changeMyContentFilterSettings($CFG['user']['user_id'], 'Off');
											break;

										case 'reject':
											if($CFG['user']['user_id'])
												$viewMusic->changeMyContentFilterSettings($CFG['user']['user_id'], 'On');
											Redirect2Url($CFG['site']['url']);
											break;
									}
								$viewMusic->setPageBlockShow('block_viewmusic_musicdetails');
								break;
						}
					}
				else
					{
						$viewMusic->setAllPageBlocksHide();
						$viewMusic->setCommonErrorMsg($LANG['msg_error_sorry']);
						$viewMusic->setPageBlockShow('block_msg_form_error');
					}
			}
		if($viewMusic->validate)
			{
				if(isMember())
					{
						if ($viewMusic->chkisMusicOwner())
							{
								$viewMusic->managelyrics_url = getUrl('managelyrics', '?music_id='.$viewMusic->getFormField('music_id'), $viewMusic->getFormField('music_id').'/', '', 'music');
							}
					}
				$viewMusic->setPageBlockShow('block_viewmusic_statistics');
				$viewMusic->setPageBlockShow('block_view_music_player');
				$viewMusic->setPageBlockShow('block_view_music_main');
				$viewMusic->setPageBlockShow('block_view_music_people_listened');
				$viewMusic->setPageBlockShow('block_view_music_more_musics');
				$viewMusic->setPageBlockShow('music_comments_block');
				$display = 'music';
				if((chkAllowedModule(array('content_filter'))) and ($viewMusic->getFormField('music_category_type')=='Porn'))
					{
						if(isAdultUser())
							{
								$display = 'music';
							}
						else
							{
								if($CFG['admin']['musics']['adult_content_view']=='Confirmation')
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
				if(($viewMusic->getFormfield('flagged_status') == 'Yes') and ($viewMusic->getFormField('flagged_content')!='show'))
					$display = 'flag';

				switch($display)
					{
						case 'error':
							$viewMusic->setAllPageBlocksHide();
							$viewMusic->setCommonErrorMsg($viewMusic->replaceAdultText($LANG['msg_error_not_allowed']));
							$viewMusic->setPageBlockShow('block_msg_form_error');
							break;

						case 'adult':
							$viewMusic->setAllPageBlocksHide();
							$viewMusic->setPageBlockShow('confirmation_adult_form');
							break;

						case 'flag':
							$viewMusic->setAllPageBlocksHide();
							$viewMusic->setPageBlockShow('confirmation_flagged_form');
							break;

						case 'music':
							$viewMusic->setPageBlockShow('block_viewmusic_musicdetails');
							break;
					}
				$viewMusic->displayMusic();

				if(isMember())
					{
						if($viewMusic->getFormField('msg')=='updated')
							{
								$viewMusic->setCommonSuccessMsg($LANG['musicupload_msg_update_success']);
								$viewMusic->setPageBlockShow('block_msg_form_success');
							}
						$viewMusic->musics_form['getBlogList'] = $viewMusic->getBlogList();
						if(empty($viewMusic->musics_form['getBlogList']))
							{
								$viewMusic->musics_form['add_new_blog_info'] = ' ';
								$viewMusic->musics_form['post_to_blog'] = ' style="display:none;"';
							}
						else
							{
								$viewMusic->musics_form['add_new_blog_info'] = ' style="display:none;"';
								$viewMusic->musics_form['post_to_blog'] = '';
							}


						$profile_blog_text = '<a href=\''.getUrl('profileblog','', '', 'members', 'music').'\'>'.$LANG['viewmusic_setup_new_blog'].'</a>';
						$viewMusic->LANG['viewmusic_blog_post_info'] = str_replace('VAR_SETUP_NEW_BLOG', $profile_blog_text, $LANG['viewmusic_blog_post_info']);
						$viewMusic->LANG['viewmusic_no_blog'] = str_replace('VAR_SETUP_NEW_BLOG', $profile_blog_text, $LANG['viewmusic_no_blog']);
					}
				$viewMusic->addlyrics_light_window_url = $CFG['site']['music_url'].'addLyrics.php?music_id='.$viewMusic->getFormField('music_id').'&light_window=1';
				$viewMusic->populateCommentOptionsMusic();
				$viewMusic->musicList_category_url = getUrl('musiclist', '?pg=musicnew&cid='.$viewMusic->getFormField('music_category_id'), 'musicnew/?cid='.$viewMusic->getFormField('music_category_id'), '', 'music');
				$viewMusic->musicList_subcategory_url = getUrl('musiclist', '?pg=musicnew&cid='.$viewMusic->getFormField('music_category_id').'&sid='.$viewMusic->getFormField('music_sub_category_id'), 'musicnew/?cid='.$viewMusic->getFormField('music_category_id').'&sid='.$viewMusic->getFormField('music_sub_category_id'), '', 'music');
				$viewMusic->view_music_embed_url = getUrl('viewmusic','?music_id='.$viewMusic->getFormField('music_id').'&title='.$viewMusic->changeTitle($viewMusic->getFormField('music_title')), $viewMusic->getFormField('music_id').'/'.$viewMusic->changeTitle($viewMusic->getFormField('music_title')).'/', '','music');
				$viewMusic->allow_embed =$viewMusic->getFormField('allow_embed');
				//PLAYLIST COMMENT//
				if($viewMusic->getFormField('type')=='add_comment')
					{
						$viewMusic->setPageBlockShow('block_add_comments');
					}
				if($viewMusic->getFormField('type')=='comment_reply')
					{
						$viewMusic->setPageBlockShow('block_add_comments');
					}


			}
		else
			{
				$viewMusic->setAllPageBlocksHide();
				if($viewMusic->resultFound)
				{
			    	Redirect2URL(getUrl('musiclist', '?pg=private_music', 'private_music/', '', 'music'));
				}
				else
				{
					Redirect2URL(getUrl('musiclist', '?pg=invalid_music_id', 'invalid_music_id/', '', 'music'));
				}

			}
		if ($viewMusic->isShowPageBlock('confirmation_adult_form'))
				{
					$viewMusic->acceptAdultMusicUrl		= getUrl('viewmusic','?music_id='.$viewMusic->getFormfield('music_id').'&title='.$viewMusic->changeTitle($viewMusic->getFormfield('music_title')).'&action=accept&vpkey='.$viewMusic->getFormfield('vpkey'), $viewMusic->getFormfield('music_id').'/'.$viewMusic->changeTitle($viewMusic->getFormfield('music_title')).'/?action=accept&vpkey='.$viewMusic->getFormfield('vpkey'),  'members', 'music');
					$viewMusic->acceptThisAdultMusicUrl	= getUrl('viewmusic','?music_id='.$viewMusic->getFormfield('music_id').'&title='.$viewMusic->changeTitle($viewMusic->getFormfield('music_title')).'&action=view&vpkey='.$viewMusic->getFormfield('vpkey'), $viewMusic->getFormfield('music_id').'/'.$viewMusic->changeTitle($viewMusic->getFormfield('music_title')).'/?action=view&vpkey='.$viewMusic->getFormfield('vpkey'), '', 'music');
					$viewMusic->rejectAdultMusicUrl		= getUrl('viewmusic','?music_id='.$viewMusic->getFormfield('music_id').'&title='.$viewMusic->changeTitle($viewMusic->getFormfield('music_title')).'&action=reject&vpkey='.$viewMusic->getFormfield('vpkey'), $viewMusic->getFormfield('music_id').'/'.$viewMusic->changeTitle($viewMusic->getFormfield('music_title')).'/?action=reject&vpkey='.$viewMusic->getFormfield('vpkey'), 'members', 'music');
					$viewMusic->rejectThisAdultMusicUrl	= getUrl('index','','');
				}
		$viewMusic->setPageBlockShow('block_add_comments');
	}

$viewMusic->includeHeader();
if($viewMusic->validate)
	{
		if(!isAjax())
			{
				if($viewMusic->isShowPageBlock('add_reply') OR $viewMusic->isShowPageBlock('block_add_comments'))
					{
						$viewMusic->replyCommentId=$viewMusic->getFormField('comment_id');
							$viewMusic->replyUrl=$CFG['site']['music_url'].'listenMusic.php?ajax_page=true&music_id='.$viewMusic->getFormField('music_id').'&vpkey='.$viewMusic->getFormField('vpkey').'&show='.$viewMusic->getFormField('show');
						?>
						<script language="javascript" type="text/javascript">
						<?php if($CFG['admin']['musics']['captcha']
									AND $CFG['admin']['musics']['captcha_method'] == 'recaptcha'
										AND $CFG['captcha']['public_key'] AND $CFG['captcha']['private_key'])
								{
						?>
						var captcha_recaptcha = true;
						<?php
								}
								else
								{
						?>
						var captcha_recaptcha = false;
						<?php
								}
						?>

						</script>
						<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/light_comment.js"></script>
						<script language="javascript" type="text/javascript">
							var no_comment_error_msg = "<?php echo $LANG['common_noComment_errorMsg'];?>";
							var dontUse = 0;
							var replyUrl="<?php echo $viewMusic->replyUrl;?>";
							var owner="<?php echo $viewMusic->getFormField('user_id');;?>";
							var reply_comment_id="<?php echo $viewMusic->replyCommentId;?>";
							var reply_user_id="<?php echo $CFG['user']['user_id'];?>";
							$Jq('#comment').focus();
						</script>
						<?php
					}
			}
?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/musicComment.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/shareMusic.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/createPlaylist.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/default/root/css/screen_grey/jquery.jscrollpane.css" media="screen" title="screen_grey" />
<script type="text/javascript">
var deleteConfirmation = "<?php echo $LANG['delete_confirmation'];?>";
var common_delete_login_err_message = "<?php echo $LANG['common_delete_login_err_message'];?>";
var comment_success_deleted_msg='<?php echo $LANG['success_deleted'];?>';
var viewmusic_mandatory_fields = "<?php echo $LANG['viewmusic_mandatory_fields']; ?>";
var kinda_comment_msg = "<?php echo $LANG['comment_approval']; ?>";
var addBlogSuccess = "<?php echo $LANG['viewmusic_posted_your_blog'];?>";
var addBlogFailure = viewmusic_mandatory_fields;
var featured_delete_confirmation = "<?php echo $LANG['viewmusic_featured_delete_confimation'];?>";
var music_id = '<?php echo $viewMusic->getFormField('music_id');?>';
var disPrevButton = 'clsPreviousDisable';
var disNextButton = 'clsNextDisable';
var populatePeopleListened_total_record = '<?php echo $viewMusic->populatePeopleListened(false); ?>';
var populatePeopleListened_limit = '<?php echo $CFG['admin']['musics']['total_people_listened_music']; ?>';
//var populatePeopleListened_start = '<?php echo $viewMusic->getFormField('listenedstart'); ?>';
var pars= 'vLeft=&vFetch=';
var homeUrl = '<?php echo getUrl('viewmusic','?music_id='.$viewMusic->getFormField('music_id'), $viewMusic->getFormField('music_id').'/','','music'); ?>';
var share_url = '<?php echo $viewMusic->share_url; ?>';
var lyrics_url = '<?php echo $viewMusic->lyrics_url; ?>';
var music_id = '<?php echo $viewMusic->getFormField('music_id'); ?>';
var playlist_url = '<?php echo $CFG['site']['url'].'music/createPlaylist.php?action=save_playlist&music_id='.$viewMusic->getFormField('music_id'); ?>';
var favorite_added = '<?php if($viewMusic->favorite['added']=='') echo '1'; else echo ''; ?>';
var favorite_url = '<?php echo $viewMusic->favorite['url'];?>';
var featured_already = '<?php echo $viewMusic->chkMusicFeaturedAlreadyAdded(); ?>';
var featured_added = '<?php if($viewMusic->featured['added']=='') echo '1'; else echo ''; ?>';
var featured_url= '<?php echo $viewMusic->featured['url']; ?>';
var blog_url = '<?php echo $CFG['site']['url'].'music/listenMusic.php?music_id='.$viewMusic->getFormField('music_id'); ?>';
var load_flag_url = '<?php echo $viewMusic->load_flag_url; ?>';
var load_blog_url = '<?php echo $viewMusic->load_blog_url; ?>';
var member_login_url = '<?php echo $viewMusic->memberviewMusicUrl; ?>';
var total_rating_images = '<?php echo $CFG['admin']['total_rating']; ?>';
var rateimage_url = '<?php echo $CFG['site']['url'].'music/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/icon-rate.gif';?>';
var rateimagehover_url = '<?php echo $CFG['site']['url'].'music/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/icon-ratehover.gif';?>';
var view_music_music_ajax_page_loading = '<img alt="<?php echo $LANG['common_music_loading']; ?>" src="<?php echo $CFG['site']['url'].'music/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/loading-viewmusic.gif' ?>" \/>';
var recalculate_scroll_view_music = true;
var downloadUrl='';
var site_url = '<?php echo $CFG['site']['url'];?>';
var enabled_edit_fields = new Array();
var playlist_name_error_msg = '<?php echo $LANG['common_music_playlist_errortip_select_title']; ?>';
var playlist_tag_error_msg = '<?php echo $LANG['musicplaylist_error_tips']; ?>';
var view_music_scroll_loading='<div class="clsLoader">'+view_music_music_ajax_page_loading+'<\/div>';
//Variable decleared to check the Artist feature is on/off
var artist_feature = '<?php echo $CFG['admin']['musics']['music_artist_feature'];?>';
<?php
if(isMember())
	{
		echo "var show_div = 'Playlist';";
	}
else
	{
		echo "var show_div = 'Sharemusic';";
	}
?>

	var current_active_tab_class = 'clsActive';
	var current_first_active_tab_class = 'clsFirstActive';
	var current_last_active_tab_class = 'clsLastActive';
	var show_div_first_active = 'selPlaylistContent';
<?php
if($viewMusic->getFormField('allow_lyrics') == 'Yes')
	{
		echo "var more_tabs_div = new Array('selPlaylistContent', 'selSharemusicContent', 'selFavoritesContent', 'selFlagContent', 'selFeaturedContent', 'selBlogContent', 'selLyricsContent');
		var more_tabs_class = new Array('selHeaderPlaylist', 'selHeaderSharemusic', 'selHeaderFavorites', 'selHeaderFlag', 'selHeaderFeatured', 'selHeaderBlog', 'selHeaderLyrics');";
		echo "var show_div_last_active = 'selLyricsContent';";
	}
else
	{
		echo "var more_tabs_div = new Array('selPlaylistContent', 'selSharemusicContent', 'selFavoritesContent', 'selFlagContent', 'selFeaturedContent', 'selBlogContent');
		var more_tabs_class = new Array('selHeaderPlaylist', 'selHeaderSharemusic', 'selHeaderFavorites', 'selHeaderFlag', 'selHeaderFeatured', 'selHeaderBlog');";
		echo "var show_div_last_active = 'selBlogContent';";
	}
?>
	$Jq(document).ready(function(){
		//To Show the default div and hide the other divs (call ajax if required)
		//getViewMusicMoreContent(show_div);
	});

var getViewMusicMoreContent = function()
{
	var content_id = arguments[0];
	var view_music_more_path;
	var call_viewmusic_ajax = false;
	view_music_content_id = content_id;
	 if(content_id == 'Favorites')
	{
		call_viewmusic_ajax = true;
		if(arguments[1] == 'remove')
		{
			$Jq('#unfavorite').css('display','none');
			$Jq('#favorite_saving').css('display','block');
			var favorite_pars = '&favorite=&music_id='+music_id;
			favorite_added = 1;
		}
		else
		{
			$Jq('#favorite').css('display','none');
			$Jq('#favorite_saving').css('display','block');
			var favorite_pars = '&favorite='+favorite_added+'&music_id='+music_id;
			favorite_added = 0;
		}

		view_music_more_path = favorite_url+favorite_pars;
	}
	else if(content_id == 'Featured')
	{
		call_viewmusic_ajax = true;
		if(featured_already && arguments[1] != 'remove' && arguments[2] != 'conformed')
		{
			document.msgConfirmformMulti1.action = "javascript:getViewMusicMoreContent('Featured', '', 'conformed');";
			if(!Confirmation('selMsgLoginConfirmMulti', 'msgConfirmformMulti1', Array('selAlertLoginMessage'), Array(featured_delete_confirmation), Array('innerHTML')))
			{
				return false;
			}
		}
		else
		{
			hideAllBlocks();
		}
		if(arguments[1] == 'remove')
		{
			$Jq('#unfeatured').css('display','none');
			$Jq('#featured_saving').css('display','block');
			var featured_pars = '&featured=&music_id='+music_id;
			featured_added = 1;
		}
		else
		{
			$Jq('#featured').css('display','none');
			$Jq('#featured_saving').css('display','block');
			var featured_pars = '&featured='+featured_added+'&music_id='+music_id;
			featured_added = 0;
		}
		view_music_more_path = featured_url+featured_pars;
	}
	else if(content_id == 'Blog')
	{
		view_music_more_path = load_blog_url;
		call_viewmusic_ajax = true;
	}
	else if(content_id == 'Lyrics')
		view_music_more_path = lyrics_url;
	if(call_viewmusic_ajax)
	{
		new jquery_ajax(view_music_more_path, '', 'insertViewMusicMoreContent');
	}
}

function insertViewMusicMoreContent(data)
{
	data = data;
	if(data.indexOf('ERR~')>=1)
	{
		if(view_music_content_id == 'Favorites')
		{
			$Jq('#favorite_saving').css('display','none');
			if(favorite_added)
			{
				$Jq('#unfavorite').css('display','block');
			}
			else
			{
				$Jq('#favorite').css('display','block');
			}
			msg = '<?php echo $LANG['sidebar_login_favorite_err_msg'] ?>';
		}
		else if(view_music_content_id == 'Featured')
		{
			$Jq('#featured_saving').css('display','none');
			if(featured_added)
			{
				$Jq('#unfeatured').css('display','block');
			}
			else
			{
				$Jq('#featured').css('display','block');
			}
			msg = '<?php echo $LANG['sidebar_login_featured_err_msg'] ?>';
		}
		memberBlockLoginConfirmation(msg,'<?php echo $viewMusic->memberviewMusicUrl ?>');
		return false;
	}

	//Do the works for other things
	if(view_music_content_id == 'Playlist')
	{

	}
	else if(view_music_content_id == 'Sharemusic')
	{

	}
	else if(view_music_content_id == 'Blog')
	{

	}
	else if(view_music_content_id == 'Favorites')
	{
		if(favorite_added)
		{
			$Jq('#favorite_saving').css('display','none');
			$Jq('#favorite').css('display','block');
		}
		else
		{
			$Jq('#favorite_saving').css('display','none');
			$Jq('#unfavorite').css('display','block');
		}
	}
	else if(view_music_content_id == 'Flag')
	{

	}
	else if(view_music_content_id == 'Featured')
	{

		if(featured_added)
		{
			$Jq('#featured_saving').css('display','none');
			$Jq('#featured').css('display','block');
		}
		else
		{
			$Jq('#featured_saving').css('display','none');
			$Jq('#unfeatured').css('display','block');
		}
	}
	else if(view_music_content_id == 'Lyrics')
	{

	}

	return false;
}

function hideViewMusicMoreTabsDivs(current_div)
	{
		for(var i=0; i<more_tabs_div.length; i++)
			{
				if(more_tabs_div[i] != current_div)
					{
						$Jq('#'+more_tabs_div[i]).hide();
						$Jq('#'+more_tabs_class[i]).removeClass(current_active_tab_class);
						$Jq('#'+more_tabs_class[i]).removeClass(current_first_active_tab_class);
						$Jq('#'+more_tabs_class[i]).removeClass(current_last_active_tab_class);
					}
			}
	}

function showViewMusicMoreTabsDivs(current_div)
	{
		for(var i=0; i<more_tabs_div.length; i++)
			{
				if(more_tabs_div[i] == current_div)
					{

						if($Jq('#'+current_div).css('display') == 'none')
							$Jq('#' + current_div).css('display', 'block');

						$Jq('#'+more_tabs_class[i]).addClass(current_active_tab_class);
						if(show_div_first_active == current_div)
							$Jq('#'+more_tabs_class[i]).addClass(current_first_active_tab_class);
						if(show_div_last_active == current_div)
							$Jq('#'+more_tabs_class[i]).addClass(current_last_active_tab_class);
						break;
					}
			}
	}

//MORE COnTENT START HERE//
function moveMusicSetToLeft(buttonObj, pg)
	{
		if(pg=='tag')
			var pars= 'vTagLeft=&vTagFetch=';
		if(pg=='user')
			var pars= 'vUserLeft=&vUserFetch=';
		if(pg=='top')
			var pars= 'vTopLeft=&vTopFetch=';
		if(pg=='artist')
			var pars= 'vArtistLeft=&vArtistFetch=';
		if(buttonObj.className == disPrevButton)
			{
				return false;
			}
		musicSlider(pars, pg);
	}

var moremusic_button_id = '';
function moveMusicSetToRight(buttonObj, pg)
	{
		if(pg=='tag')
			var pars= 'vTagRight=&vTagFetch=';
		if(pg=='user')
			var pars= 'vUserRight=&vUserFetch=';
		if(pg=='top')
			var pars= 'vTopRight=&vTopFetch=';
		if(pg=='artist')
			var pars= 'vArtistRight=&vArtistFetch=';

		if(buttonObj.className == disNextButton){
			return false;
		}
		moremusic_button_id = 'musicNextButton_'+pg;
		$Jq('#'+moremusic_button_id).attr('disabled',true);
		musicSlider(pars, pg);
	}

function musicSlider(pars, pg)
	{
		if(pg=='resp')
			{
				showDiv('loaderRespVideos');
				new $Jq.ajax(homeUrl, {method:'post',parameters:pars+'&ajax_page=1&music_id=<?php echo $viewMusic->getFormField('music_id'); ?>', onComplete:refreshMusicBlockResp});
				return;
			}
		$Jq('#relatedMusicContent').html() = $Jq('#loaderMusics').html();
		if(pg=='tag')
			new $Jq.ajax(homeUrl, {method:'post',parameters:pars+'&ajax_page=1&music_id=<?php echo $viewMusic->getFormField('music_id'); ?>&music_tags=<?php echo $viewMusic->getFormField('music_tags'); ?>', onComplete:refreshMusicBlock});
		if(pg=='user')
			new $Jq.ajax(homeUrl, {method:'post',parameters:pars+'&ajax_page=1&music_id=<?php echo $viewMusic->getFormField('music_id'); ?>&user_id=<?php echo $viewMusic->getFormField('user_id'); ?>', onComplete:refreshMusicBlock});
		if(pg=='top')
			new $Jq.ajax(homeUrl, {method:'post',parameters:pars+'&ajax_page=1&music_id=<?php echo $viewMusic->getFormField('music_id'); ?>', onComplete:refreshMusicBlock});
		if(pg=='artist')
			new $Jq.ajax(homeUrl, {method:'post',parameters:pars+'&ajax_page=1&music_id=<?php echo $viewMusic->getFormField('music_id'); ?>&music_artist=<?php echo $viewMusic->getFormField('org_music_artist'); ?>', onComplete:refreshMusicBlock});
	}
function refreshMusicBlock(resp)
	{
		$Jq('#'+moremusic_button_id).attr('disabled', false);
		data=resp;
		$Jq('#relatedMusicContent').html(data);
		$Jq('#selNextPrev_top').html()=$Jq('#selNextPrev').html();
	}
//MORE CONTENT END//


function getPeopleListenedMusic(action)
	{
		if(action == '')
			{
				start = 0;
			}
		else
			{
				start = $Jq('#listenedstart').val();
				if(action == 'Previous')
					var  start = parseInt(start) - parseInt(populatePeopleListened_limit);
				if(action == 'Next')
					var  start = parseInt(start) + parseInt(populatePeopleListened_limit);
					$Jq('#listenedstart').val(start);
			}

		var pars='music_id='+music_id+'&ajax_page=true&peopleListenedMusic=true&listenedstart='+start;
		$Jq('#people_listened_content').html('');
		$Jq('#loaderListenedMusics').removeClass('clsDisplayNone');
		$Jq.ajax({
			type: "GET",
			url: listenedUrl,
			data: pars,
			success: ajaxPeopleListenedResult
		 });
		loadChangeClass('.clsMoreMusicNav li','clsActive');
	}

function ajaxPeopleListenedResult(data)
	{
		$Jq('#loaderListenedMusics').addClass('clsDisplayNone');
		data = unescape(data);
		$Jq('#people_listened_content').html(data);
		$Jq('#people_listened_Head').html($Jq('#people_listened_Paging').html());
	}

</script>

<?php
	}
setTemplateFolder('general/', 'music');
$smartyObj->display('viewMusic.tpl');

if($viewMusic->validate)
	{
?>
<script type="text/javascript">
   function closeDownload()
	{
		$Jq('#downloadFormat').css('display','none');
		hideAllBlocks();
	}
</script>
<?php
	}
?>
	<script type="text/javascript">
   function playerReady()
	{
		$Jq('#featured_playlist').addClass('clsfeaturedplaylist');
	}

	var playlist_opt;
function populateMyPlayList(url, opt)
{
	playlist_opt = opt;
	return openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', url, 'action=popplaylist&mem_auth=true', 'populateMyPlayListResponse');
}
function populateMyPlayListResponse(html)
{
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
		if(playlist_opt == 'create')
		{
			jQuery("select#playlist option[selected]").removeAttr("selected");
			jQuery("select#playlist option[value='#new#']").attr("selected", "selected");
			$Jq('#createNewPlaylist').show();
		}
		else
		{
			$Jq('#createNewPlaylist').hide();
		}
		Confirmation('playlistDiv', 'playlistfrm', Array(), Array(), Array());
	}
}
function populateAddLyrics(url)
{
	return openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', url, 'action=add_lyrics', 'populateAddLyricsResponse');
}
function populateAddLyricsResponse(html)
{
	$Jq('#LyricsDiv').html(html);
	$Jq('#LyricsDiv').show();
	Confirmation('LyricsDiv', 'selFormLyrics', Array(), Array(), Array());
}
function populateViewLyrics()
{
	return openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', lyrics_url, '', 'populateViewLyricsResponse');
}
function populateViewLyricsResponse(html)
{
	$Jq('#LyricsDiv').html(html);
	$Jq('#LyricsDiv').show();
	Confirmation('LyricsDiv', '', Array(), Array(), Array());
}
function updateBlogTitle(html)
{
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
</script>
<?php
$viewMusic->includeFooter();
?>