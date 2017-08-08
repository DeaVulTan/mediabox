<?php
/**
* viewPhoto.php
* This file is to view the photo
*
* PHP version 5.0
*
* @category	Framework
* @package
* @author 		edwin_048at09
* @copyright	Copyright (c) 2009 {@link http://www.mediabox.uz Uzdc Infoway}
* @license		http://www.mediabox.uz Uzdc Infoway Licence
* @version		SVN: $Id: viewPhoto.php 656 2010-01-20 edwin_048at09 $
* @since 		2010-01-20
*/
class ViewPhoto extends PhotoHandler
{
	public $allow_quickmixs;
	public $captchaText = '';
	/**
	 * Viewphoto::chkValidPhotoId()
	 *
	 * @return boolean
	 */
	public function chkValidPhotoId()
	{
		$photoId = $this->fields_arr['photo_id'];
		$photoId = is_numeric($photoId)?$photoId:0;
		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$original_photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['original_photo_folder'].'/';

		if (!$photoId)
	    {
	        return false;
	    }
		$userId = $this->CFG['user']['user_id'];
		$condition = 'p.photo_status=\'Ok\' AND p.photo_id='.$this->dbObj->Param($photoId).
					' AND (p.user_id = '.$this->dbObj->Param($userId).' OR'.
					' p.photo_access_type = \'Public\''.$this->getAdditionalQuery('p.').')';

		$sql = 'SELECT p.photo_title, p.photo_caption, p.total_favorites, p.total_views, p.total_comments,'.
				' p.allow_comments, p.allow_embed, p.allow_ratings, p.allow_tags, p.photo_ext, p.photo_album_id,'.
				' p.photo_category_id, p.photo_tags, p.rating_total, p.rating_count, p.user_id, p.flagged_status, '.
				' p.photo_server_url, p.photo_upload_type, p.total_downloads, p.location_recorded,'.
				' DATE_FORMAT(p.date_added,\''.$this->CFG['format']['date'].'\') as date_added,'.
				' p.l_width, p.l_height, t_width, t_height, s_width, s_height, '.' (p.rating_total/p.rating_count) as rating,'.
				' p.photo_category_id, photo_sub_category_id'.
				' FROM '.$this->CFG['db']['tbl']['photo'].' as p'.
				' WHERE '.$condition.' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photoId, $userId));
	    if (!$rs)
		    trigger_db_error($this->dbObj);
		$fields_list = array('user_name', 'first_name', 'last_name');
		if($row = $rs->FetchRow())
		{
			$this->UserDetails = $this->getUserDetail('user_id', $row['user_id'], 'user_name');
			//User Image
			$this->memberProfileImgSrc = $this->getUserPhotoDetail($row['user_id']);
			$this->memberProfileUrl    = getMemberProfileUrl($row['user_id'], $this->UserDetails);


			$name = $this->getUserDetail('user_id', $row['user_id'], 'user_name');
			$this->fields_arr['user_id'] = $row['user_id'];
			$this->fields_arr['allow_comments'] = $row['allow_comments'];
			$this->fields_arr['allow_ratings'] = $row['allow_ratings'];
			$this->fields_arr['allow_tags'] = $row['allow_tags'];
				$this->fields_arr['photo_ext'] = $row['photo_ext'];
			$this->fields_arr['photo_server_url'] = $row['photo_server_url'];

			if($row['photo_ext'])
			{
				$this->photo_path = $row['photo_server_url'].$photos_folder.getPhotoName($photoId).
										$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'];
				$this->original_photo_path = $row['photo_server_url'].$original_photos_folder.getPhotoName($photoId).'.'.$row['photo_ext'];
				$is_original_image=false;
				$original_image_width='';
				$original_image_height='';
				if($row['photo_server_url'] == $this->CFG['site']['url'])
			  	{
					if(file_exists($this->CFG['site']['project_path'].$original_photos_folder.getPhotoName($photoId).'.'.$row['photo_ext']))
					{
					    $is_original_image=true;
						list($original_image_width,$original_image_height)=getimagesize($this->original_photo_path);
					}
				}
				$this->original_photo_path=$this->CFG['site']['photo_url'].'viewOriginalPhoto.php?photo_url='.$this->original_photo_path.'&title='.$row['photo_title'];
				$this->show_original_photo=false;
				if($is_original_image && (($original_image_width> $row['l_width']) || ($original_image_height>$row['l_height'])) && $this->CFG['admin']['photos']['save_original_file_to_download'])
				     $this->show_original_photo=true;

				$this->photo_disp = DISP_IMAGE($this->CFG['admin']['photos']['large_width'], $this->CFG['admin']['photos']['large_height'],
										$row['l_width'], $row['l_height']);
			}
			else
			{
				$this->photo_path = '';
				$this->photo_disp = '';
			}

			$this->fields_arr['photo_title'] = $row['photo_title'];
			$this->statistics_photo_title = $row['photo_title'];
			$this->photo_title_js =addslashes($this->statistics_photo_title);
			$this->statistics_photo_caption = $row['photo_caption'];
			$this->fields_arr['photo_caption'] = $row['photo_caption'];
			$this->fields_arr['date_added'] = $row['date_added'];
			$this->fields_arr['photo_added_by'] = $name;
			$this->fields_arr['location']	= $row['location_recorded'];
			$this->fields_arr['user_name'] = $name;
			$this->fields_arr['large_width'] = $this->large_width = $row['l_width'];
			$this->fields_arr['large_height'] = $this->large_height = $row['l_height'];
			$this->fields_arr['thumb_width'] = $row['t_width'];
			$this->fields_arr['thumb_height'] = $row['t_height'];
			$this->fields_arr['small_width'] = $row['s_width'];
			$this->fields_arr['small_height'] = $row['s_height'];
			$this->fields_arr['rating_total'] = $row['rating_total'];
			$this->fields_arr['rating_count'] = $row['rating_count'];
			$this->photo_rating = round($row['rating']);
			$this->fields_arr['flagged_status'] = $row['flagged_status'];
			$this->fields_arr['comments'] = $row['total_comments']?$row['total_comments']:0;
			$this->fields_arr['photo_album_id'] = $row['photo_album_id'];
			$this->fields_arr['total_downloads'] = $row['total_downloads'];
			$this->fields_arr['total_favorites'] = $row['total_favorites'];
			$this->fields_arr['total_views'] = $row['total_views'];
			$this->fields_arr['total_comments'] = $row['total_comments'];
			$this->fields_arr['photo_category_id'] = $row['photo_category_id'];
			$this->fields_arr['photo_category_name'] = $this->getphotoCategoryName($row['photo_category_id']);
			$this->statistics_photo_genre = $this->fields_arr['photo_category_name'];
			$this->fields_arr['photo_tags'] = $row['photo_tags'];
			$this->fields_arr['photo_upload_type'] = $row['photo_upload_type'];
			$this->fields_arr['allow_embed'] = $row['allow_embed'];
			$this->fields_arr['photo_category_type'] = $this->getphotoCategoryType($row['photo_category_id']);
			$this->fields_arr['photo_sub_category_id'] = $row['photo_sub_category_id'];
			$this->fields_arr['photo_category_id'] = $row['photo_category_id'];
			$this->fields_arr['photo_subcategory_type'] = $this->getphotoCategoryType($row['photo_sub_category_id']);
			$this->fields_arr['album_title'] = getphotoAlbumName($row['photo_album_id']);
			$this->statistics_album_title = nl2br($this->fields_arr['album_title']);

			if($this->fields_arr['blog_post_title'] == '')
				$this->setFormField('blog_post_title', $row['photo_title']);
			if($this->fields_arr['blog_post_text'] == '')
				$this->setFormField('blog_post_text', $row['photo_caption']);
			//echo '<pre>'; print_r($this->fields_arr); echo '</pre>';

			return true;
		}
		return false;
	}

	/**
	 * ViewPhoto::getUserPhotoDetail()
	 *
	 * @param mixed $user_id
	 * @return string
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
		return getMemberAvatarDetails($getUserDetail['record']['user_id']);

	}

	/**
	 * viewphoto::chkisphotoOwner()
	 *
	 * @return
	 */
	public function chkisPhotoOwner()
	{
		$sql = 'SELECT photo_id FROM '.$this->CFG['db']['tbl']['photo'].' AS p'.
				' WHERE p.photo_id = '.$this->dbObj->Param('photo_id').' AND p.user_id = '.$this->dbObj->Param('photo_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id'], $this->CFG['user']['user_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();

		if($row['photo_id'] != '')
			return true;
		return false;
	}
	/**
	 * Viewphoto::getRating()
	 *
	 * @param integer $user_id
	 * @return integer
	 */
	public function getRating($user_id)
	{
		$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['photo_rating'].
				' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
				' photo_id='.$this->dbObj->Param('photo_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($user_id, $this->fields_arr['photo_id']));
	    if (!$rs)
		    trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow())
		{
			return $row['rate'];
		}
		return 0;
	}
	/**
	 * Viewphoto::populateRatingDetails()
	 *
	 * @return void
	 */
	public function populateRatingDetails($rating)
	{
		$rating = round($rating,0);
		return $rating;
	}

	/**
	 * Viewphoto::displayPhoto()
	 *
	 * @return void
	 */
	public function displayPhoto()
	{
		//$this->arguments_embed = 'pg=photo_'.$this->fields_arr['photo_id'].'_no_0_extsite';

		$this->photo_caption= nl2br($this->fields_arr['photo_caption']);
		$this->loginUrl = getUrl('login');

		$this->rankUsersRayzz = false;
		$this->rating='';

		if(rankUsersRayzz($this->CFG['admin']['photos']['allow_self_ratings'], $this->fields_arr['user_id']))
		{
			$this->rankUsersRayzz=true;
			$this->rating = $this->getRating($this->CFG['user']['user_id']);
		}

		$this->ratingDetatils = ($rating=$this->populateRatingDetails($this->fields_arr['rating_count']))?$rating:0;
		if(isMember())
		{
			$this->share_url = $this->CFG['site']['photo_url'].'sharePhoto.php?photo_id='.
											$this->getFormField('photo_id').'&ajaxpage=true&page=sharephoto';
		}
		else
		{
			$this->share_url = $this->CFG['site']['photo_url'].'sharePhoto.php?photo_id='.
											$this->getFormField('photo_id').'&ajaxpage=true&page=sharephoto';
		}
		$this->blogPostViewphotoUrl = getUrl('viewphoto','?photo_id='.$this->fields_arr['photo_id'].'&amp;title='.
												$this->changeTitle($this->fields_arr['photo_title']), $this->fields_arr['photo_id'].
													'/'.$this->changeTitle($this->fields_arr['photo_title']).'/','root','photo');

		$this->edit_photo_url = getUrl('photouploadpopup','?photo_id='.$this->fields_arr['photo_id'],
								 	$this->fields_arr['photo_id'].'/', '','photo');

		$this->photo_title = $this->fields_arr['photo_title'];

		//$this->callAjaxFlagGroupsUrl = $this->CFG['site']['video_url'].'members/viewVideo.php?ajax_page=true&amp;page=flag&amp;photo_id='.$this->fields_arr['video_id'].'&amp;show='.$this->fields_arr['show'];
		$this->favorite = $this->getFavorite();
		$this->featured = $this->getFeatured();

		if(!isMember())
			$this->relatedUrl = $this->CFG['site']['photo_url'].'viewPhoto.php';
		else
			$this->relatedUrl = $this->CFG['site']['photo_url'].'viewPhoto.php';



		$this->memberviewPhotoUrl = getUrl('viewphoto','?mem_auth=true&photo_id='.$this->getFormfield('photo_id').'&title='.
																$this->changeTitle($this->getFormfield('photo_title')),
																	$this->getFormfield('photo_id').'/'.
																		$this->changeTitle($this->getFormfield('photo_title')).
																			'/?mem_auth=true','', 'photo');

		$this->flaggedPhotoUrl = getUrl('viewphoto','?photo_id='.$this->getFormfield('photo_id').'&title='.
												$this->changeTitle($this->getFormfield('photo_title')).
													'&flagged_content=show', $this->getFormfield('photo_id').'/'.
														$this->changeTitle($this->getFormfield('photo_title')).
															'/?flagged_content=show','', 'photo');

		$this->load_flag_url = $this->CFG['site']['photo_url'].'viewPhoto.php?photo_id='.
									$this->fields_arr['photo_id'].'&ajax_page=true&page=load_flag';
		$this->load_blog_url = $this->CFG['site']['photo_url'].'viewPhoto.php?photo_id='.
									$this->fields_arr['photo_id'].'&ajax_page=true&page=load_blog';

		//Quick mix functionality
		$this->allow_quickmixs   = ($this->CFG['admin']['photos']['allow_quick_mixs'])?true:false;
		$this->is_quickmix_added = (rayzzPhotoQuickMix($this->getFormfield('photo_id')))?true:false;

		//Photo embed url
		$this->viewPhotoEmbedUrl = getUrl('viewphoto','?photo_id='.$this->getFormfield('photo_id').'&title='.
									$this->changeTitle($this->getFormfield('photo_title')).'/', $this->getFormfield('photo_id').'/'.
									$this->changeTitle($this->getFormfield('photo_title')).'/','', 'photo');
		//$this->embeded_code 	 = htmlentities('<script type="text/javascript" src="'.$this->CFG['site']['photo_url'].'embedphoto/?pid='.
									//$this->getFormField('photo_id').'"></script>');

		//photo OWNER DETAILS
		$this->photo_user_details['total_photos'] = getTotalPhotos($this->fields_arr['user_id']);
		$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type');
		$user_details_arr = $this->getUserDetail('user_id', $this->fields_arr['user_id'], 'user_name');
		$this->photo_user_details['user_name'] = $user_details_arr;
		$this->photo_user_details['icon'] = getMemberAvatarDetails($this->fields_arr['user_id']);
		$this->photo_user_details['profile_url'] = getMemberProfileUrl($this->fields_arr['user_id'], $user_details_arr);

	}
	/**
	 * Viewphoto::selectFavorite()
	 *
	 * @param string $condition
	 * @param array $value
	 * @param string $returnType
	 * @return mixed
	 */
	public function selectFavorite($condition, $value, $returnType='')
	{
		$sql = 'SELECT photo_favorite_id FROM '.$this->CFG['db']['tbl']['photo_favorite'].
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
	 * Viewphoto::getFavorite()
	 *
	 * @return array
	 */
	public function getFavorite()
	{
		$favorite['added']='';
		$favorite['id']='';
		if(!isMember())
		{
			$favorite['url'] = getUrl('viewphoto', '?photo_id='.
								$this->fields_arr['photo_id'].'&title='.$this->changeTitle($this->fields_arr['photo_title']),
									$this->fields_arr['photo_id'].'/'.$this->changeTitle($this->fields_arr['photo_title']).'/', 'members', 'photo');
		}
		else
		{
			$condition = 'photo_id='.$this->dbObj->Param('photo_id').
				 		 ' AND user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';

			$condtionValue = array($this->fields_arr['photo_id'], $this->CFG['user']['user_id']);

			$favorite['url'] = $this->CFG['site']['photo_url'].'viewPhoto.php?photo_id='.
								  $this->fields_arr['photo_id'].'&ajax_page=true&page=favorite';

			if($rs = $this->selectFavorite($condition, $condtionValue, 'full'))
			{
				if($rs->PO_RecordCount())
				{
					$row = $rs->FetchRow();
					$favorite['added'] = true;
					$favorite['id'] = $row['photo_favorite_id'];
				}
			}
		}
		return $favorite;
	}
	/**
	 * Viewphoto::insertFavoritePhoto()
	 *
	 * @return void
	 */
	public function insertFavoritePhoto()
	{
		if($this->fields_arr['favorite'])
		{
			$condition = 'photo_id='.$this->dbObj->Param('photo_id').' AND user_id='.$this->dbObj->Param('user_id');
			$condtionValue = array($this->fields_arr['photo_id'], $this->CFG['user']['user_id']);

			if(!$this->selectFavorite($condition, $condtionValue))
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_favorite'].' SET'.
					   ' user_id='.$this->dbObj->Param('user_id').','.
					   ' photo_id='.$this->dbObj->Param('photo_id').','.
				       ' date_added=NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['photo_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($this->dbObj->Insert_ID())
				{
					$favorite_id = $this->dbObj->Insert_ID();
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET total_favorites = total_favorites+1'.
							' WHERE photo_id='.$this->dbObj->Param('photo_id');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
					if (!$rs)
						trigger_db_error($this->dbObj);

					echo $this->LANG['viewphoto_favorite_added_successfully'];

					//Srart Post photo favorite photo activity	..
					$sql = 'SELECT pf.photo_favorite_id, pf.photo_id, pf.user_id as favorite_user_id, u.user_name, '.
							'p.photo_title, p.user_id, p.photo_server_url, p.photo_ext '.
							'FROM '.$this->CFG['db']['tbl']['photo_favorite'].' as pf, '.$this->CFG['db']['tbl']['users'].
							' as u, '.$this->CFG['db']['tbl']['photo'].' as p '.
							' WHERE u.user_id = pf.user_id AND pf.photo_id = p.photo_id '.
							' AND pf.photo_favorite_id = '.$this->dbObj->Param('favorite_id');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($favorite_id));
					if (!$rs)
						trigger_db_error($this->dbObj);

					$row = $rs->FetchRow();
					$activity_arr = $row;
					$activity_arr['action_key']	= 'photo_favorite';
					$photoActivityObj = new photoActivityHandler();
					$photoActivityObj->addActivity($activity_arr);
					//end
				}
			}
		}
	}
	public function insertFlagPhotoTable()
	{
		echo $this->LANG['viewphoto_your_request'];
		$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
				' content_type=\'Photo\' AND'.
				' content_id='.$this->dbObj->Param('content_id').' AND'.
				' reporter_id='.$this->dbObj->Param('reporter_id').' AND'.
				' status=\'Ok\'';

		$fields_value_arr = array($this->fields_arr['photo_id'], $this->CFG['user']['user_id']);
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
								' content_type=\'Photo\', flag='.$this->dbObj->Param('flag').','.
								' flag_comment='.$this->dbObj->Param('flag_comment').','.
								' reporter_id='.$this->dbObj->Param('reporter_id').','.
								' date_added=NOW()';

						$insert_flag_values_arr = array($this->fields_arr['photo_id'], $this->fields_arr['flag'],
														$this->fields_arr['flag_comment'], $this->CFG['user']['user_id']);

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $insert_flag_values_arr);
					    if (!$rs)
						    trigger_db_error($this->dbObj);
					}
				else if($this->fields_arr['flag_comment'])
					{
						$this->fields_arr['flag'] = $this->LANG['viewphoto_others_label'];
						$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['flagged_contents'].' SET'.
								' content_id='.$this->dbObj->Param('content_id').','.
								' content_type=\'Photo\', flag='.$this->dbObj->Param('flag').','.
								' flag_comment='.$this->dbObj->Param('flag_comment').','.
								' reporter_id='.$this->dbObj->Param('reporter_id').','.
								' date_added=NOW()';

						$insert_flag_values_arr = array($this->fields_arr['photo_id'], $this->fields_arr['flag'], $this->fields_arr['flag_comment'],
															$this->CFG['user']['user_id']);
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, $insert_flag_values_arr);
					    if (!$rs)
						    trigger_db_error($this->dbObj);
					}

					//Inform flagged photo to admin through mail\\
					//Subject..
					$flagged_subject = str_replace('VAR_USER_NAME', $this->CFG['user']['user_name'], $this->LANG['photo_flagged_subject']);
					$flagged_subject = str_replace('VAR_PHOTO_TITLE', $this->fields_arr['photo_title'], $flagged_subject);
					//Content..
					$sql ='SELECT photo_server_url, photo_title, photo_caption, photo_ext'.
							' FROM '.$this->CFG['db']['tbl']['photo'].
							' WHERE photo_id='.$this->dbObj->Param('photo_id').' LIMIT 0,1';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
					if (!$rs)
						trigger_db_error($this->dbObj);

					$row = $rs->FetchRow();
					//photo title
					$flagged_message = str_replace('VAR_PHOTO_TITLE', $row['photo_title'], $this->LANG['photo_flagged_content']);
					//photo image
					$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';

					$photolink = getUrl('viewphoto','?photo_id='.$this->fields_arr['photo_id'].
									'&amp;title='.$this->changeTitle($row['photo_title']), $this->fields_arr['photo_id'].'/'.
										$this->changeTitle($row['photo_title']).'/', 'root','photo');

					$photo_thumbnail = $this->CFG['site']['url'].$photos_folder.
												getPhotoName($this->fields_arr['photo_id']).$this->CFG['admin']['photos']['thumb_name'].
													'.'.$row['photo_ext'];


					$photo_image = '<a href="'.$photolink.'"><img border="0" src="'.
											$photo_thumbnail.'" alt="'.$row['photo_title'].'" title="'.$row['photo_title'].'" /></a>';
					$flagged_message = str_replace('VAR_PHOTO_IMAGE', $photo_image, $flagged_message);
					//photo description
					$photo_description = strip_tags($row['photo_caption']);
					$flagged_message = str_replace('VAR_PHOTO_DESCRIPTION', $photo_description, $flagged_message);
					//flagged title, flagged content
					$admin_link = $this->CFG['site']['url'].'admin/photo/manageFlaggedPhoto.php';
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
	 * Viewphoto::insertFeaturedphoto()
	 *
	 * @return void
	 */
	public function insertFeaturedPhoto()
	{
		if($this->fields_arr['featured'])
		{
			$condition = 'photo_id='.$this->dbObj->Param('photo_id').' AND user_id='.$this->dbObj->Param('user_id');
			$condtionValue=array($this->fields_arr['photo_id'],$this->CFG['user']['user_id']);
			if(!$this->selectFeaturedPhoto($condition,$condtionValue))
			{
				$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_featured'].' SET'.
					' user_id='.$this->dbObj->Param('user_id').','.
					' photo_id='.$this->dbObj->Param('photo_id').','.
					' date_added=NOW()';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['photo_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($this->dbObj->Insert_ID())
				{
					$featured = $this->dbObj->Insert_ID();
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET total_featured = total_featured+1'.
							' WHERE photo_id='.$this->dbObj->Param('photo_id');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
					if (!$rs)
						trigger_db_error($this->dbObj);

					echo $this->LANG['viewphoto_featured_added_successfully'];

					//Srart Post photo featured photo activity	..
					$sql = 'SELECT pf.photo_featured_id, pf.photo_id, pf.user_id as featured_user_id,'.
							' u.user_name, p.photo_title, p.user_id, p.photo_server_url, p.photo_ext '.
							'FROM '.$this->CFG['db']['tbl']['photo_featured'].' as pf, '.
							$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['photo'].' as p '.
							'WHERE u.user_id = pf.user_id AND pf.photo_id = p.photo_id AND pf.photo_featured_id = '
							.$this->dbObj->Param('photo_featured_id');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($featured));
					if (!$rs)
						trigger_db_error($this->dbObj);

					$row = $rs->FetchRow();
					$activity_arr = $row;
					$activity_arr['action_key']	= 'photo_featured';
					$photoActivityObj = new PhotoActivityHandler();
					$photoActivityObj->addActivity($activity_arr);
					//end
				}
			}
		}

	}
	/**
	 * Viewphoto::getFeatured()
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
			$featured['url'] = getUrl('viewphoto', '?photo_id='.$this->fields_arr['photo_id'].'&title='.
									$this->changeTitle($this->fields_arr['photo_title']),
										$this->fields_arr['photo_id'].'/'.
											$this->changeTitle($this->fields_arr['photo_title']).'/', '', 'photo');
		}
		else
		{
			$condition= 'photo_id='.$this->dbObj->Param('photo_id').
					     ' AND user_id='.$this->dbObj->Param('user_id').' LIMIT 0,1';
			$condtionValue=array($this->fields_arr['photo_id'], $this->CFG['user']['user_id']);
			$featured['url'] = $this->CFG['site']['photo_url'].'viewPhoto.php?photo_id='.
									$this->fields_arr['photo_id'].
										'&ajax_page=true&page=featured';

			if($rs = $this->selectFeaturedPhoto($condition, $condtionValue, 'full'))
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
	 * viewPhoto::populateCommentOptionsPhoto()
	 * purpose to populate Comment options for the Photo
	 * purpose to populate Comment options for the Photo
	 * @return void
	 */
	public function populateCommentOptionsPhoto()
	{
		$this->CFG['admin']['photos']['total_comments']=$this->fields_arr['show']=='all'?'100000':$this->CFG['admin']['photos']['total_comments'];
		$sql = 'SELECT vc.photo_comment_id, vc.photo_comment_main_id, vc.comment_user_id,'.
				' vc.comment, TIMEDIFF(NOW(), vc.date_added) as pc_date_added,'.
				' TIME_TO_SEC(TIMEDIFF(NOW(), vc.date_added)) AS date_edit'.
				' FROM '.$this->CFG['db']['tbl']['photo_comments'].' AS vc'.
				' WHERE vc.photo_id='.$this->dbObj->Param('photo_id').' AND'.
				' vc.photo_comment_main_id=0 AND'.
				' vc.comment_status=\'Yes\' ORDER BY vc.photo_comment_id DESC LIMIT '.$this->CFG['admin']['photos']['total_comments'];

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		$total_comments = $rs->PO_RecordCount();
		$this->fields_arr['total_comments'] = $this->getTotalComments();
		$this->comment_approval = 0;
		if(isMember())
		{
			$this->commentUrl = $this->CFG['site']['photo_url'].'viewPhoto.php?type=add_comment&photo_id='.$this->getFormField('photo_id');
		}
		else
		{
			$this->commentUrl =getUrl('viewphoto', '?mem_auth=true&photo_id='.$this->fields_arr['photo_id'].'&title='.$this->changeTitle($this->fields_arr['photo_title']), $this->fields_arr['photo_id'].'/'.$this->changeTitle($this->fields_arr['photo_title']).'/?mem_auth=true', '', 'photo');
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
			$this->setPageBlockHide('photo_comments_block');
		}
	}
	/**
	 * viewPhoto::getTotalComments()
	 * purpose to get Total Comments og this playlisr
	 * @return integer
	 */
	public function getTotalComments()
	{
		$sql = 'SELECT total_comments FROM '.$this->CFG['db']['tbl']['photo'].
				' WHERE photo_id='.$this->dbObj->Param('photo_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();
		return $this->fields_arr['total_comments'] = $row['total_comments']?$row['total_comments']:0;
	}


	/**
	 * viewPhoto::populateCommentOfThisPhoto()
	 *
	 * @return void
	 */
	public function populateCommentOfThisPhoto()
	{
		global $smartyObj;
		$populateCommentOfThisPhoto_arr = array();

        $this->setTableNames(array($this->CFG['db']['tbl']['photo_comments'].' AS vc', $this->CFG['db']['tbl']['users'].' AS u'));
        $this->setReturnColumns(array('vc.photo_comment_id', 'vc.comment_user_id', 'vc.comment', 'TIMEDIFF(NOW(), vc.date_added) as pc_date_added', 'TIME_TO_SEC(TIMEDIFF(NOW(), vc.date_added)) AS date_edit'));
        $this->sql_condition = 'vc.photo_id=\''.$this->fields_arr['photo_id'].'\' AND vc.photo_comment_main_id=0 AND u.user_id=vc.comment_user_id AND u.usr_status=\'Ok\' AND vc.comment_status=\'Yes\'';
        $this->sql_sort = 'vc.photo_comment_id DESC';

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

		$populateCommentOfThisPhoto_arr['comment_approval'] = 0;
		if($this->getFormField('allow_comments')=='Kinda')
		{
			$populateCommentOfThisPhoto_arr['comment_approval'] = 0;
			if(!isMember())
			{
				$populateCommentOfThisPhoto_arr['approval_url'] = getUrl('viewphoto', '?photo_id='.$this->fields_arr['photo_id'].'&amp;title='.$this->changeTitle($this->fields_arr['photo_title']), $this->fields_arr['photo_title'].'/'.$this->changeTitle($this->fields_arr['photo_title']).'/', '', 'photo');
			}
		}
		else if($this->getFormField('allow_comments')=='Yes')
		{
			$populateCommentOfThisPhoto_arr['comment_approval'] = 1;
			if(!isMember())
			{
				$populateCommentOfThisPhoto_arr['post_comment_url'] = getUrl('viewphoto', '?photo_id='.$this->fields_arr['photo_id'].'&amp;title='.$this->changeTitle($this->fields_arr['photo_title']), $this->fields_arr['photo_id'].'/'.$this->changeTitle($this->fields_arr['photo_title']).'/', '', 'photo');
			}
		}

		$populateCommentOfThisPhoto_arr['row'] = array();
		if($this->isResultsFound())
		{
			$this->fields_arr['ajaxpaging'] = 1;
			$populateCommentOfThisPhoto_arr['hidden_arr'] = array('start', 'ajaxpaging');
			$smartyObj->assign('smarty_paging_list', $this->populatePageLinksPOSTViaAjax($this->getFormField('start'), 'frmPhotoComments', 'selCommentBlock'));
			$this->fields_arr['total_comments'] = (isset($this->fields_arr['total_comments']) and $this->fields_arr['total_comments'])?$this->fields_arr['total_comments']:$this->getTotalComments();

			$this->UserDetails = array();
			$inc = 0;
			while($row = $this->fetchResultRecord())
			{
				$this->UserDetails = $this->getUserDetail('user_id', $row['comment_user_id'], 'user_name');
				$populateCommentOfThisPhoto_arr['s_attribute'] = isset($icondetail['icon']['s_attribute'])?$icondetail['icon']['s_attribute']:'';
				$populateCommentOfThisPhoto_arr['row'][$inc]['name'] = $this->getUserDetail('user_id', $row['comment_user_id'], 'user_name');
				$populateCommentOfThisPhoto_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['comment_user_id']);
				$populateCommentOfThisPhoto_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $this->UserDetails);

				$row['pc_date_added'] = getTimeDiffernceFormat($row['pc_date_added']);

				$populateCommentOfThisPhoto_arr['row'][$inc]['class'] = 'clsNotEditable';
				if($row['comment_user_id']==$this->CFG['user']['user_id'])
				{
					$time = $this->CFG['admin']['photos']['comment_edit_allowed_time']-$row['date_edit'];
					if($time>2)
					{
						$populateCommentOfThisPhoto_arr['row'][$inc]['class'] = "clsEditable";
					}
				}
				$row['comment'] = $row['comment'];
				$populateCommentOfThisPhoto_arr['row'][$inc]['record'] = $row;
				$populateCommentOfThisPhoto_arr['row'][$inc]['reply_url']= $this->CFG['site']['photo_url'].'viewPhoto.php?photo_id='.$this->getFormField('photo_id').'&vpkey='.$this->getFormField('vpkey').'&show='.$this->getFormField('show').'&comment_id='.$row['photo_comment_id'].'&type=comment_reply';

				$populateCommentOfThisPhoto_arr['row'][$inc]['comment_member_profile_url'] = getMemberProfileUrl($row['comment_user_id'], $this->UserDetails);
				$temp_comment = nl2br(makeClickableLinks($row['comment']));
				$populateCommentOfThisPhoto_arr['row'][$inc]['makeClickableLinks'] =  $temp_comment;
				if(isMember() and $row['comment_user_id']==$this->CFG['user']['user_id'])
				{
					$populateCommentOfThisPhoto_arr['row'][$inc]['time'] = $this->CFG['admin']['photos']['comment_edit_allowed_time']-$row['date_edit'];
					if($populateCommentOfThisPhoto_arr['row'][$inc]['time'] > 2)
					{
						$this->enabled_edit_fields[$row['photo_comment_id']] = $populateCommentOfThisPhoto_arr['row'][$inc]['time'];
					}
				}
				else
				{
					if(!isMember())
					{
						$populateCommentOfThisPhoto_arr['row'][$inc]['comment_reply_url'] = getUrl('viewphoto', '?photo_id='.$this->fields_arr['photo_id'].'&amp;title='.$this->changeTitle($this->fields_arr['photo_title']), $this->fields_arr['photo_id'].'/'.$this->changeTitle($this->fields_arr['photo_title']).'/', '', 'photo');
					}
				}
				$populateCommentOfThisPhoto_arr['row'][$inc]['populateReply_arr'] = $this->populateReply($row['photo_comment_id']);
				$inc++;
			} //while

			if($this->fields_arr['total_comments']>$this->CFG['admin']['photos']['total_comments'])
			{
		  		$populateCommentOfThisPhoto_arr['view_all_comments_url'] = getUrl('viewphoto', '?photo_id='.$this->fields_arr['photo_id'].'&amp;title='.$this->changeTitle($this->fields_arr['photo_title']).'&amp;vpkey='.$this->fields_arr['vpkey'].'&amp;action='.$this->fields_arr['action'].'&amp;flagged_content='.$this->fields_arr['flagged_content'].'&amp;show=all', $this->fields_arr['photo_id'].'/'.$this->changeTitle($this->fields_arr['photo_title']).'/?vpkey='.$this->fields_arr['vpkey'].'&amp;action='.$this->fields_arr['action'].'&amp;flagged_content='.$this->fields_arr['flagged_content'].'&amp;show=all', '', 'photo');
				$populateCommentOfThisPhoto_arr['view_all_comments'] = sprintf($this->LANG['viewphoto_view_all_comments'],'<span id="total_comments2">'.$this->fields_arr['total_comments'].'</span>');

		  	}
		}

		$smartyObj->assign('populateCommentOfThisPhoto_arr', $populateCommentOfThisPhoto_arr);
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('populateCommentOfThisPhoto.tpl');
	}

	/**
	 * viewPhoto::insertCommentAndPhotoTable()
	 *
	 * @return void
	 **/
	public function insertCommentAndPhotoTable()
	{
		$sql = 'SELECT allow_comments FROM '.$this->CFG['db']['tbl']['photo'].
				' WHERE photo_id='.$this->dbObj->Param('photo_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();
		$this->fields_arr['allow_comments'] = $row['allow_comments'];
		$comment_status = 'Yes';
		//IF PHOTO OWNER POST COMMENT THEN WE DISPLAY COMMENTS WITHOUT APPROVAL//
		if($row['allow_comments']=='Kinda' and $this->CFG['user']['user_id']!=$this->fields_arr['user_id'])
			$comment_status = 'No';

		$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_comments'].' SET'.
				' photo_id='.$this->dbObj->Param('photo_id').','.
				' photo_comment_main_id='.$this->dbObj->Param('photo_comment_main_id').','.
				' comment_user_id='.$this->dbObj->Param('comment_user_id').','.
				' comment='.$this->dbObj->Param('comment').','.
				' comment_status='.$this->dbObj->Param('comment_status').','.
				' date_added=NOW()';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id'], $this->fields_arr['comment_id'], $this->CFG['user']['user_id'], $this->fields_arr['f'], $comment_status));
		    if (!$rs)
			    trigger_db_error($this->dbObj);

		$next_id = $this->dbObj->Insert_ID();
		if($next_id and $comment_status=='Yes' and (!$this->fields_arr['comment_id']))
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET total_comments = total_comments+1'.
						' WHERE photo_id='.$this->dbObj->Param('photo_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
				    if (!$rs)
					    trigger_db_error($this->dbObj);
			}

		//Srart Post photo comment activity..
		$sql = 'SELECT pc.photo_comment_id, pc.photo_id, pc.comment_user_id, u.user_name, '.
				'p.photo_title, p.user_id, p.photo_server_url, p.photo_ext '.
				'FROM '.$this->CFG['db']['tbl']['photo_comments'].' as pc, '.
				$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['photo'].' as p '.
				' WHERE u.user_id = pc.comment_user_id AND '.
				'pc.photo_id = p.photo_id AND pc.photo_comment_id = '.$this->dbObj->Param('photo_comment_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($next_id));
		if (!$rs)
			trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();
		$activity_arr = $row;
		$activity_arr['action_key']	= 'photo_comment';
		$photoActivityObj = new PhotoActivityHandler();
		$photoActivityObj->addActivity($activity_arr);
		//end

		global $smartyObj;
		if ($this->fields_arr['comment_id'])
			{
				$cmValue['populateReply_arr'] = $this->populateReply($this->fields_arr['comment_id']);
				$smartyObj->assign('cmValue', $cmValue);
				setTemplateFolder('general/', 'photo');
				$smartyObj->display('populateReplyForCommentsOfThisPhoto.tpl');
			}
		else
			{
				$this->populateCommentOfThisPhoto();
			}
	}

	/**
	 *
	 * @return 		void
	 * @access 		public
	 */
	public function populateReplyCommentOfThisPhoto()
		{
			global $smartyObj;
			$cmValue['populateReply_arr'] = $this->populateReply($this->fields_arr['maincomment_id']);
			$smartyObj->assign('cmValue', $cmValue);
			setTemplateFolder('general/', 'photo');
			$smartyObj->display('populateReplyForCommentsOfThisPhoto.tpl');
		}

	/**
	 * viewPhoto::updateCommentAndPhotoTable()
	 *
	 * @return boolean
	 **/
	public function updateCommentAndPhotoTable()
	{
		$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_comments'].' SET'.
				' comment='.$this->dbObj->Param('comment').
				' WHERE photo_comment_id='.$this->dbObj->Param('photo_comment_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['f'], $this->fields_arr['comment_id']));
		    if (!$rs)
			    trigger_db_error($this->dbObj);
		return true;
	}

	/**
	 * viewPhoto::getComment()
	 *
	 * @return
	 **/
	public function getComment()
	{
		$sql = 'SELECT comment FROM '.$this->CFG['db']['tbl']['photo_comments'].' WHERE'.
				' photo_comment_id='.$this->dbObj->Param('photo_comment_id');

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
	 * ViewPhoto::chkIsCaptchaNotEmpty()
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
	 * viewPhoto::chkCaptcha()
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
	 * viewPhoto::populateRatingImagesForAjax()
	 * purpose to populate images for rating
	 * @param $rating
	 * @return void
	 **/
	public function populateRatingImagesForAjax($rating, $imagePrefix='')
	{
		$rating_total = $this->CFG['admin']['total_rating'];
		?>
		<div class="clsViewPhotoRatingLeft">
		<?php
		for($i=1;$i<=$rating;$i++)
		{
			?>
			<a onClick="return callAjaxRate('<?php echo $this->CFG['site']['photo_url'].'viewPhoto.php?ajax_page=true&photo_id='.
				$this->fields_arr['photo_id'].'&'.'rate='.$i;?>&show=<?php echo $this->fields_arr['show'];?>','selRatingPhoto','photoRating')"
				onMouseOver="ratingPhotoMouseOver(<?php echo $i;?>, 'photo')" onMouseOut="ratingPhotoMouseOut(<?php echo $i;?>)" id="ratingLink">
				<img id="img<?php echo $i;?>" src="<?php echo $this->CFG['site']['photo_url'].'design/templates/'.
				$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
				'/icon-photoratehover.gif'; ?>"  title="<?php echo $i;?>" /></a>
			<?php
		}
	    ?>
	    <?php
		for($i=$rating;$i<$rating_total;$i++)
		{
			?>
			<a onClick="return callAjaxRate('<?php echo $this->CFG['site']['photo_url'].'viewPhoto.php?ajax_page=true&photo_id='.
			$this->fields_arr['photo_id'].'&'.'rate='.($i+1);?>&amp;amp;show=<?php echo $this->fields_arr['show'];?>','selRatingPhoto','photoRating')"
			 onMouseOver="ratingPhotoMouseOver(<?php echo ($i+1);?>, 'photo')" onMouseOut="ratingPhotoMouseOut(<?php echo ($i+1);?>)" id="ratingLink">
			 <img id="img<?php echo ($i+1);?>" src="<?php echo $this->CFG['site']['photo_url'].'design/templates/'.
			 $this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].
			 '/icon-photorate.gif'; ?>"  title="<?php echo ($i+1);?>" /></a>
			 <?php
		}
		?>
	    </div>
	    <?php
	}
	/**
	 * ViewPhoto::chkAllowRating()
	 *
	 * @return void
	 */
	public function chkAllowRating()
	{
		$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['photo'].
				' WHERE photo_id='.$this->dbObj->Param('photo_id').
				' AND allow_ratings=\'Yes\' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		if($rs->PO_RecordCount())
			return true;
		return false;
	}

	/**
	 * ViewPhoto::chkAlreadyRated()
	 *
	 * @return boolean
	 */
	public function chkAlreadyRated()
	{
		$sql = 'SELECT rate FROM '.$this->CFG['db']['tbl']['photo_rating'].
				' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
				' photo_id='.$this->dbObj->Param('photo_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $this->fields_arr['photo_id']));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
			return $row['rate'];
		return false;
	}

	/**
	 * ViewPhoto::insertRating()
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

				$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_rating'].' SET'.
						' rate='.$this->dbObj->Param('rate').','.
						' date_added=NOW() '.
						' WHERE photo_id='.$this->dbObj->Param('photo_id').' AND '.
						' user_id='.$this->dbObj->Param('user_id');

				$update_fields_value_arr = array($this->fields_arr['rate'], $this->fields_arr['photo_id'],
												$this->CFG['user']['user_id']);
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $update_fields_value_arr);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($diff > 0)
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET'.
								' rating_total=rating_total+'.$diff.' '.
								' WHERE photo_id='.$this->dbObj->Param('photo_id');
					}
				else
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET'.
								' rating_total=rating_total'.$diff.' '.
								' WHERE photo_id='.$this->dbObj->Param('photo_id');
					}

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				//Find rating for rating photo activity..
				$sql = 'SELECT photo_rating_id '.
						'FROM '.$this->CFG['db']['tbl']['photo_rating'].' '.
						' WHERE photo_id='.$this->dbObj->Param('photo_id').' AND '.
						' user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id'],  $this->CFG['user']['user_id']));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				$rating_id = $row['photo_rating_id'];
			}
			else
			{
				$sql =  'INSERT INTO '.$this->CFG['db']['tbl']['photo_rating'].
						' (photo_id, user_id, rate, date_added ) '.
						' VALUES ( '.
						$this->dbObj->Param('photo_id').','.$this->dbObj->Param('user_id').','.$this->dbObj->Param('rate').',NOW()'.
						' ) ';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id'], $this->CFG['user']['user_id'], $this->fields_arr['rate']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				$rating_id = $this->dbObj->Insert_ID();

				$sql =  'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET'.
						' rating_total=rating_total+'.$this->fields_arr['rate'].','.
						' rating_count=rating_count+1'.
						' WHERE photo_id='.$this->dbObj->Param('photo_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
			    if (!$rs)
				    trigger_db_error($this->dbObj);
			}


			//Srart Post Photo rating Photo activity	..
			$sql = 'SELECT pr.photo_rating_id, pr.photo_id, pr.user_id as rating_user_id, pr.rate, '.
					'u.user_name, p.photo_title, p.user_id, p.photo_server_url, p.photo_ext '.
					'FROM '.$this->CFG['db']['tbl']['photo_rating'].' as pr, '.
					$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['photo'].' as p '.
					' WHERE u.user_id = pr.user_id AND pr.photo_id = p.photo_id AND pr.photo_rating_id = '.
					$this->dbObj->Param('photo_rating_id');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($rating_id));
			if (!$rs)
				trigger_db_error($this->dbObj);

			$row = $rs->FetchRow();
			$activity_arr = $row;
			$activity_arr['action_key']	= 'photo_rated';
			$photoActivityObj = new PhotoActivityHandler();
			$photoActivityObj->addActivity($activity_arr);
			//end
		}
	}

	/**
	 * viewPhoto::getTotalRatingImage()
	 * purpose to populate rating images based on the rating of the photo
	 * @return void
	 **/
	public function getTotalRatingImage()
	{
		if($this->populatePhotolistDetails())
		{
		    $rating = round($this->fields_arr['rating_total']/$this->fields_arr['rating_count'],0);
			$this->populateRatingImagesForAjax($rating);
			$rating_text = $this->LANG['viewphoto_rated'];
			$getPhotoRating = $this->getPhotoRating($this->fields_arr['photo_id']);
			echo '<div class="clsViewPhotoRatingRight">&nbsp;(<span> <span>'.$this->fields_arr['rating_count'].'</span></span> )</div>@'.$getPhotoRating;
		}
	}

	public function getPhotoRating($photoId = '')
	{
		$rating = 0;
		$sql  = 'SELECT (rating_total/rating_count) as rating FROM '.$this->CFG['db']['tbl']['photo'].' WHERE photo_id='.$this->dbObj->Param('photo_id').' LIMIT 0,1';
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
	    if (!$rs)
			trigger_db_error($this->dbObj);

		if($row = $rs->FetchRow())
			return round($row['rating']);
		return $rating;
	}

	public function populatePhotolistDetails()
	{
		$sql = 'SELECT rating_total, rating_count FROM '.$this->CFG['db']['tbl']['photo'].
				' WHERE photo_id='.$this->dbObj->Param('photo_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
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
	public function replaceAdultText($text)
	{
		$text = str_replace('{age_limit}', $this->CFG['admin']['photos']['adult_minimum_age'], $text);
		$text = str_replace('{site_name}', $this->CFG['site']['name'], $text);
		return nl2br($text);
	}

	/**
	 * ViewPhoto::populateFlagContent()
	 *
	 * @return void
	 */
	public function populateFlagContent()
	{
		global $smartyObj;
		$flagContent['url'] = $this->CFG['site']['photo_url'].'viewPhoto.php?ajax_page=true&'.
									'page=flag&photo_id='.$this->getFormField('photo_id').'&show='.$this->fields_arr['show'];
		$smartyObj->assign('flagContent', $flagContent);
		setTemplateFolder('general/','photo');
		$smartyObj->display('photoFlag.tpl');
	}


	/**
	 * ViewPhoto::populateSlidelistContent()
	 * playlist details will be passed to tpl
	 *
	 * @return void
	 */
	public function populateSlidelistContent()
	{
		global $smartyObj;
		$slide_info = array();
		$slide_info['playlistUrl']=$this->CFG['site']['photo_url'].'viewPhoto.php?ajax_page=true&page=playlist';
		$this->getPlaylistIdInPhoto($this->getFormField('photo_id'));
		$this->displayCreatePlaylistInterface();
		$smartyObj->assign('slide_info', $slide_info);
		setTemplateFolder('general/','photo');
		$smartyObj->display('slideList.tpl');
	}


    public function populatePeopleOnPhoto()
    {
            global $smartyObj;
			$sql = 'SELECT ppt.photo_people_tag_id, ppt.photo_owner_id, ppt.tag_name, ppt.x, ppt.y, ppt.width, ppt.height, ppt.tagged_by_user_id,u.user_name,u.email,u.user_id AS user_id '.
					' FROM '.$this->CFG['db']['tbl']['photo_people_tag'].' AS ppt LEFT JOIN  '.
					$this->CFG['db']['tbl']['users'].' AS u ON (ppt.associate_user_id=u.user_id) AND u.usr_status=\'Ok\''.
					'WHERE ppt.photo_id = '.$this->dbObj->Param('photo_id').' ORDER BY photo_people_tag_id DESC';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
			if (!$rs)
				trigger_db_error($this->dbObj);

			$populatePeopleOnPhoto_arr=array();
			$photo_tag=false;
			$tag_ids='';
			if($rs->PO_RecordCount())
			{
				$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type', 'sex');
				$inc = 0;
				while($row = $rs->FetchRow())
			    {
			    	$populatePeopleOnPhoto_arr[$inc]['photo_people_tag_id']=$row['photo_people_tag_id'];
			    	$populatePeopleOnPhoto_arr[$inc]['photo_owner_id']=$row['photo_owner_id'];
			    	$populatePeopleOnPhoto_arr[$inc]['tag_name']=$row['tag_name'];
			    	$populatePeopleOnPhoto_arr[$inc]['left']=$row['x'];
			    	$populatePeopleOnPhoto_arr[$inc]['top']=$row['y'];
			    	$populatePeopleOnPhoto_arr[$inc]['width']=$row['width'];
			    	$populatePeopleOnPhoto_arr[$inc]['height']=$row['height'];
			    	$populatePeopleOnPhoto_arr[$inc]['email']=$row['email'];
			    	$populatePeopleOnPhoto_arr[$inc]['user_name']=$row['user_name'];
			    	$populatePeopleOnPhoto_arr[$inc]['tagged_by_user_id']=$row['tagged_by_user_id'];
			    	$populatePeopleOnPhoto_arr[$inc]['tagged_user_name'] = $this->getUserDetail('user_id',$row['tagged_by_user_id'], 'user_name');
			    	$populatePeopleOnPhoto_arr[$inc]['default_icon'] = true;
			    	$populatePeopleOnPhoto_arr[$inc]['tagging_href'] = getUrl('peopleonphoto','?tag_name='.$row['tag_name'].'&tag=all&block=all', '?tag_name='.$row['tag_name'].'&tag=all&block=all','','photo');
			    	$tag_ids.=$row['photo_people_tag_id'].',';
			    	if($row['user_name'])
					{
				        $user_details_arr = $this->getUserDetail('user_id', $row['user_id'], 'user_name');
				        $populatePeopleOnPhoto_arr[$inc]['tagged_icon']= getMemberAvatarDetails($row['user_id']);
				        $populatePeopleOnPhoto_arr[$inc]['default_icon'] = false;
				        $populatePeopleOnPhoto_arr[$inc]['tag_name']= $user_details_arr;
				        $populatePeopleOnPhoto_arr[$inc]['tagging_href'] = getUrl('peopleonphoto','?people='.$row['user_name'].'&tag=all&block=all', '?people='.$row['user_name'].'&tag=all&block=all','','photo');
					}
					else
					$populatePeopleOnPhoto_arr[$inc]['tagged_icon']=$this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/canvas/noPeople.gif';
					$inc++;
			    }
			    	$photo_tag=true;

			}
			if($photo_tag)
			  $tag_ids=substr($tag_ids,0,strlen($tag_ids));
			else
			{
				if(!isMember())
					$photo_tag=false;
				else{
					$userStatus = false;
					$allowTags  = false;
					$sql  = 'SELECT photo_id,user_id,photo_access_type,allow_tags FROM '.$this->CFG['db']['tbl']['photo'].' WHERE photo_id = '.$this->dbObj->Param('photo_id');
					$stmt = $this->dbObj->Prepare($sql);
					$rs   = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
					if (!$rs)
						trigger_db_error($this->dbObj);
					if($row = $rs->FetchRow())
					{
						$userStatus = ($row['user_id'] == $this->CFG['user']['user_id'])?true:false;
						$allowTags  = ($row['allow_tags'] == 'Yes')?true:false;
					}
					$photo_tag = ($userStatus)?true:($allowTags)?true:false;
				}
			}

			$this->is_peole_photo_tag=$photo_tag;
			$this->photo_tag_ids=$tag_ids;
			$this->populatePeopleOnPhoto_arr=$populatePeopleOnPhoto_arr;
	}

	/**
	 * ViewPhoto::checkIsExternalEmebedCode()
	 *
	 * @return boolean
	 */
	public function checkIsExternalEmebedCode()
	{
		if((isset($this->fields_arr['photo_upload_type']) && $this->fields_arr['photo_upload_type'] == 'external') &&
		   (isset($this->fields_arr['external_photo_url']) && $this->fields_arr['external_photo_url'] != '')
		  )
			return true;
		return false;
	}
	public function getEditCommentBlock()
	{
		global $smartyObj;
		$replyBlock['comment_id']=$this->fields_arr['comment_id'];
		$replyBlock['name']='addEdit_';
		$replyBlock['sumbitFunction']='addToEdit';
		$replyBlock['cancelFunction']='discardEdit';
		$replyBlock['editReplyUrl']=$this->CFG['site']['photo_url'].'viewPhoto.php?ajax_page=true&amp;page=update_comment&amp;photo_id='.$this->fields_arr['photo_id'].'&vpkey='.$this->fields_arr['vpkey'].'&show='.$this->fields_arr['show'];
		$smartyObj->assign('commentEditReply', $replyBlock);
		setTemplateFolder('general/','photo');
		$smartyObj->display('photoCommentEditReplyBlock.tpl');
	}
	public function deleteComment()
	{
		$sql = 'SELECT photo_id,photo_comment_main_id FROM '.$this->CFG['db']['tbl']['photo_comments'].' WHERE'.
				' photo_comment_id='.$this->dbObj->Param('photo_comment_id').' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();

		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_comments'].
				' WHERE photo_comment_id='.$this->dbObj->Param('photo_comment_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		// DELETE REPLAY //
		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_comments'].
				' WHERE photo_comment_main_id='.$this->dbObj->Param('photo_comment_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['comment_id']));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		if($row['photo_comment_main_id']==0)
			{
				//if($this->dbObj->Affected_Rows())
					//{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET total_comments = total_comments-1'.
								' WHERE photo_id='.$this->dbObj->Param('photo_id');

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt, array($row['photo_id']));
					    if (!$rs)
						    trigger_db_error($this->dbObj);
					//}
			}
		echo '<div id="selMsgSuccess" class="clsSuccessMsg">'.$this->LANG['success_deleted'].'</div>';
	}
	public function populateReply($comment_id)
	{
		$populateReply_arr = array();
		$sql = 'SELECT photo_comment_id, photo_comment_main_id, comment_user_id,'.
				' comment, TIMEDIFF(NOW(), date_added) as pc_date_added,'.
				' TIME_TO_SEC(TIMEDIFF(NOW(), date_added)) AS date_edit'.
				' FROM '.$this->CFG['db']['tbl']['photo_comments'].
				' WHERE comment_status= \'Yes\' AND photo_id='.$this->dbObj->Param('photo_id').' AND'.
				' photo_comment_main_id='.$this->dbObj->Param('photo_comment_main_id').
				' ORDER BY photo_comment_id DESC';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id'], $comment_id));
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
						$this->UserDetails = $this->getUserDetail('user_id', $row['comment_user_id'], 'user_name');
						$populateReply_arr['s_attribute'] = isset($icondetail['icon']['s_attribute'])?$icondetail['icon']['s_attribute']:'';
						$populateReply_arr['row'][$inc]['name'] = $this->getUserDetail('user_id', $row['comment_user_id'], 'user_name');
						$populateReply_arr['row'][$inc]['icon'] = getMemberAvatarDetails($row['comment_user_id']);
						$populateReply_arr['row'][$inc]['memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $this->UserDetails);
						$row['pc_date_added'] = getTimeDiffernceFormat($row['pc_date_added']);
						$row['comment'] = $row['comment'];
						$populateReply_arr['row'][$inc]['record'] = $row;

						$populateReply_arr['row'][$inc]['class'] = 'clsNotEditable';
						if($row['comment_user_id']==$this->CFG['user']['user_id'])
							{
								$time = $this->CFG['admin']['photos']['comment_edit_allowed_time'] - $row['date_edit'];
								if($time>2)
									{
										$populateReply_arr['row'][$inc]['class'] = 'clsEditable';
									}
							}
						$populateReply_arr['row'][$inc]['comment_memberProfileUrl'] = getMemberProfileUrl($row['comment_user_id'], $this->UserDetails);
						$temp_reply = nl2br(makeClickableLinks($row['comment']));
						$populateReply_arr['row'][$inc]['comment_makeClickableLinks'] = $temp_reply;

						if(isMember() AND $row['comment_user_id'] == $this->CFG['user']['user_id'])
							{
								$populateReply_arr['row'][$inc]['time'] = $this->CFG['admin']['photos']['comment_edit_allowed_time']-$row['date_edit'];
								if($populateReply_arr['row'][$inc]['time'] > 2)
									{
										$this->enabled_edit_fields[$row['photo_comment_id']] = $populateReply_arr['row'][$inc]['time'];
									}
							}
						$inc++;
					}
			}
		return $populateReply_arr;
	 }

	/**
	 * viewPhoto::getCaptchaText()
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
	 * ViewPhoto::getCommentsBlock()
	 *
	 * @return void
	 */
	public function getCommentsBlock()
	{
		global $smartyObj;
		$getCommentsBlock_arr = array();
		if($this->CFG['admin']['photos']['captcha'] and $this->CFG['admin']['photos']['captcha_method']=='image')
			$getCommentsBlock_arr['captcha_comment_url'] = $this->CFG['site']['url'].'captchaComment.php?captcha_key=photocomment&amp;captcha_value='.$this->getCaptchaText();
		$smartyObj->assign('getCommentsBlock_arr', $getCommentsBlock_arr);
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('addPhotoComments.tpl');
	}
	public function getPhotoTitle($photo_id)
	{
		$sql = 'SELECT photo_title FROM ' . $this->CFG['db']['tbl']['photo'] . ' WHERE photo_id=' . $this->dbObj->Param('photo_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photo_id));
		if (!$rs)
			trigger_db_error($this->dbObj);
		if ($row = $rs->FetchRow())
		{
			return $row['photo_title'];
		}
	}
	public function getPreviousLink()
	{
		$default_fields = 'MAX(p.photo_id) as prv_photo_id ';
		$group_by = ' group by p.user_id ';
		$this->previous_photo_link = '';
		$this->prev_photo_title = '';
		$sql_condition = ' p.photo_status=\'Ok\' ';
		if($this->CFG['admin']['photos']['photo_next_prev'])
		{
				if($this->CFG['admin']['photos']['photo_next_prev_type'] == 'user')
				{
					$sql_condition = 'p.photo_id<\''.addslashes($this->fields_arr['photo_id']).'\''.
								' AND p.user_id=\''.$this->fields_arr['user_id'].'\' AND p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').
								' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')';
					$group_by = ' group by p.user_id ';
					$this->prev_photo_title = $this->LANG['viewphoto_prev_user'];
				}
				elseif($this->CFG['admin']['photos']['photo_next_prev_type'] == 'related')
				{
					$photo_tags = $this->fields_arr['photo_tags'];
					$sql_condition = 'p.photo_id<\''.addslashes($this->fields_arr['photo_id']).'\' AND'.
							' p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').' AND'.
							' '.getSearchRegularExpressionQueryModified($photo_tags, 'photo_tags', '').
							' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
							' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')';
					$group_by = ' group by p.photo_tags ';
					$this->prev_photo_title = $this->LANG['viewphoto_prev_related'];
				}
				elseif($this->CFG['admin']['photos']['photo_next_prev_type'] == 'album')
				{
					$sql_condition = 'p.photo_id<\''.addslashes($this->fields_arr['photo_id']).'\' AND'.
							' p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').' AND'.
							' p.photo_album_id=\''.addslashes($this->fields_arr['photo_album_id']).'\''.
							' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
							' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')';
					$group_by = ' group by p.photo_album_id ';
					$this->prev_photo_title = $this->LANG['viewphoto_prev_album'];
				}
		}
		$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['photo'].' AS p '.
				' WHERE '.$sql_condition.$group_by.' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		   trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow() and $row['prv_photo_id'])
		{
			$this->previous_photo_link =getUrl('viewphoto', '?photo_id=' . $row['prv_photo_id'] . '&title=' . $this->changeTitle($this->getPhotoTitle($row['prv_photo_id'])), $row['prv_photo_id'] . '/' . $this->changeTitle($this->getPhotoTitle($row['prv_photo_id'])) . '/', '', 'photo');
		}
		else
		{
			$this->previous_photo_link = '';
		}

	}
	public function getNextLink()
	{
		$default_fields = 'MIN(p.photo_id) as nxt_photo_id, p.photo_title';
		$group_by = ' group by p.user_id ';
		$this->next_photo_link = '';
		$this->next_photo_title = '';
		$sql_condition = ' p.photo_status=\'Ok\' ';
		if($this->CFG['admin']['photos']['photo_next_prev'])
		{
			if($this->CFG['admin']['photos']['photo_next_prev_type'] == 'user')
			{
				$sql_condition = 'p.photo_id > \''.addslashes($this->fields_arr['photo_id']).'\''.
							' AND p.user_id=\''.$this->fields_arr['user_id'].'\' AND p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').
							' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
							' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')';
				$group_by = ' group by p.user_id ';
				$this->next_photo_title = $this->LANG['viewphoto_next_user'];
			}
			elseif($this->CFG['admin']['photos']['photo_next_prev_type'] == 'related')
			{
				$photo_tags = $this->fields_arr['photo_tags'];
				$sql_condition = 'p.photo_id > \''.addslashes($this->fields_arr['photo_id']).'\' AND'.
						' p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').' AND'.
						' '.getSearchRegularExpressionQueryModified($photo_tags, 'photo_tags', '').
						' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
						' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')';
				$group_by = ' group by p.photo_tags ';
				$this->next_photo_title = $this->LANG['viewphoto_next_related'];
			}
			elseif($this->CFG['admin']['photos']['photo_next_prev_type'] == 'album')
			{
				$sql_condition = 'p.photo_id > \''.addslashes($this->fields_arr['photo_id']).'\' AND'.
						' p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').' AND'.
						' p.photo_album_id=\''.addslashes($this->fields_arr['photo_album_id']).'\''.
						' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
						' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')';
				$group_by = ' group by p.photo_album_id ';
				$this->next_photo_title = $this->LANG['viewphoto_next_album'];
			}
		}
		$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['photo'].' AS p '.
				' WHERE '.$sql_condition.$group_by.' LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
		   trigger_db_error($this->dbObj);
		if($row = $rs->FetchRow() and $row['nxt_photo_id'])
		{
			$this->next_photo_link =getUrl('viewphoto', '?photo_id=' . $row['nxt_photo_id'] . '&title=' . $this->changeTitle($row['photo_title']), $row['nxt_photo_id'] . '/' . $this->changeTitle($row['photo_title']) . '/', '', 'photo');
		}
		else
		{
			$this->next_photo_link = '';
		}
	}
	public function populateRelatedPhoto($pg = 'tag', $start=0)
	{
		global $smartyObj;
		$return = array();

		$default_fields = 'p.photo_id, p.photo_title, p.total_views, p.photo_ext, p.photo_server_url, p.s_width, p.s_height, p.t_width, p.t_height, p.user_id,(p.rating_total/p.rating_count) as rating';

		$add_fields = '';
		$order_by = 'p.photo_id DESC';
		switch($pg)
			{
				case 'user':

					$sql_condition = 'p.photo_id!=\''.addslashes($this->fields_arr['photo_id']).'\''.
								' AND p.user_id=\''.$this->fields_arr['user_id'].'\' AND p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').
								' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
								' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')';

					$more_link = getUrl('photolist','?pg=userphotolist&amp;user_id='.$this->fields_arr['user_id'], 'userphotolist/?user_id='.$this->fields_arr['user_id']);
					break;

				case 'tag':

					$photo_tags = $this->fields_arr['photo_tags'];
					$sql_condition = 'p.photo_id!=\''.addslashes($this->fields_arr['photo_id']).'\' AND'.
							' p.photo_status=\'Ok\''.$this->getAdultQuery('p.', 'photo').' AND'.
							' '.getSearchRegularExpressionQueryModified($photo_tags, 'photo_tags', '').
							' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR'.
							' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().')';

					$add_fields = '';
					$order_by = 'p.photo_id DESC';
					//$more_link = getUrl('photolist','?pg=photonew&amp;tags='.$photo_tags, 'photonew/?tags='.$photo_tags);
					break;

			}

		$sql_exising='SELECT count(1) count FROM '.$this->CFG['db']['tbl']['photo'].' AS p '.
				' WHERE '.$sql_condition.' ';
		$existing_total_records=$this->getExistingRecords($sql_exising);
		$process_start=$this->processStartValue($pg, $existing_total_records);

		$sql = 'SELECT '.$default_fields.$add_fields.' FROM '.$this->CFG['db']['tbl']['photo'].' AS p '.
				' WHERE '.$sql_condition.' ORDER BY '.$order_by.
				' LIMIT '.$process_start.', '.$this->CFG['admin']['photos']['total_related_photo'];

		//------ Next and Prev Links--------------//
		$leftButtonClass = 'clsPreviousDisable';
		$rightButtonClass = 'clsNextDisable';
		$leftButtonExist=false;
		$rightButtonExists=false;
		$this->pg =$pg;
		$nextSetAvailable = ($existing_total_records > ($process_start + $this->CFG['admin']['photos']['total_related_photo']));
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
		$photosPerRow=$this->CFG['admin']['photos']['related_photo_per_row'];
		$inc=0;
		if ($this->total_records)
		    {
				$photos_folder = 'files/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
				$fields_list = array('user_name', 'first_name', 'last_name', 'icon_id', 'icon_type', 'sex');
				while($row = $rs->FetchRow())
					{
						$this->UserDetails = $this->getUserDetail('user_id', $row['user_id'], 'user_name');
						$return[$inc]['record'] = $row;
						$return[$inc]['name'] = $this->getUserDetail('user_id', $row['user_id'], 'user_name');
						$return[$inc]['getMemberProfileUrl'] = getMemberProfileUrl($row['user_id'], $this->UserDetails);

						// IMAGE //
						$return[$inc]['photo_image_src'] = $row['photo_server_url'].$photos_folder.getphotoName($row['photo_id']).$this->CFG['admin']['photos']['thumb_name'].'.'.$row['photo_ext'];
						$return[$inc]['photo_disp'] = DISP_IMAGE($this->CFG['admin']['photos']['thumb_width'], $this->CFG['admin']['photos']['thumb_height'], $row['t_width'], $row['t_height']);

						$return[$inc]['photo_url']=getUrl('viewphoto','?photo_id='.$row['photo_id'].'&amp;title='.$this->changeTitle($row['photo_title']).'&amp;vpkey='.$this->fields_arr['vpkey'], $row['photo_id'].'/'.$this->changeTitle($row['photo_title']).'/?vpkey='.$this->fields_arr['vpkey'],'','photo');
						$return[$inc]['photo_title']= $row['photo_title'];
						$return[$inc]['rating']=($row['rating'])?round($row['rating']):0;
					    $inc++;
					}
			}
			$this->leftButtonExist=$leftButtonExist;
			$this->rightButtonExists=$rightButtonExists;
			$this->leftButtonClass=$leftButtonClass;
			$this->rightButtonClass=$rightButtonClass;
		/*echo '<pre>';
		print_r($return);
		echo '</pre>';*/
		$smartyObj->assign('relatedPhoto', $return);
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('viewPhotoMoreContent.tpl');
	}
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
	public function processStartValue($pg, $totalPhotoCount=0)
	{
		$vdebug = true;
		$photoLimit=$this->CFG['admin']['photos']['total_related_photo'];
		$photoIncrement=$this->CFG['admin']['photos']['total_related_photo'];

		if($pg=='user')
			{
				if (!isset($_SESSION['pUserStart']))
			    	$_SESSION['pUserStart'] = 0;

				if ($this->isPageGETed($_POST, 'pUserLeft'))
				    {
						$inc = ($_SESSION['pUserStart'] > 0)?$photoIncrement:0;
						$_SESSION['pUserStart'] -= $inc;
				    }
				if ($this->isPageGETed($_POST, 'pUserRight'))
				    {
						$inc = ($_SESSION['pUserStart'] < $totalPhotoCount)?$photoIncrement:0;
						$_SESSION['pUserStart'] += $inc;
				    }
				return $_SESSION['pUserStart'];
			}

		if($pg=='tag')
			{
				if (!isset($_SESSION['pTagStart']))
			    	$_SESSION['pTagStart'] = 0;

				if ($this->isPageGETed($_POST, 'pTagLeft'))
				    {
						$inc = ($_SESSION['pTagStart'] > 0)?$photoIncrement:0;
						$_SESSION['pTagStart'] -= $inc;
				    }
				if ($this->isPageGETed($_POST, 'pTagRight'))
				    {
						$inc = ($_SESSION['pTagStart'] < $totalPhotoCount)?$photoIncrement:0;
						//echo $totalPhotoCount.'------------'.$inc;
						$_SESSION['pTagStart'] += $inc;
				    }
				return $_SESSION['pTagStart'];
			}


	}
	public function getPhotoMetaDetails()
	{
		$sql = 'SELECT meta_data FROM ' . $this->CFG['db']['tbl']['photo_meta_data'] . ' WHERE photo_id=' . $this->dbObj->Param('photo_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);

        $meta_details=array();
        $inc=0;
        $this->is_meta_details=false;
		if ($row = $rs->FetchRow())
		    {
		      $details=explode('#~',$row['meta_data']);
		      foreach($details as $value)
			  {
				$meta_arr=explode('~#',$value);
				$label=str_replace(' ','_' ,$meta_arr[0]);
				$label=strtolower($label);
				$meta_details[$inc]['label']=(isset($this->LANG[$meta_arr[0]])?$this->LANG[$meta_arr[0]]:$meta_arr[0]);
				$meta_details[$inc]['value']=$meta_arr[1];
				//for time convertion
				/*if($meta_arr[0]=='photo_photo_created_date' || $meta_arr[0]=='photo_photo_added_date' || $meta_arr[0]=='photo_photo_modified_date' )
                  {
				  $date_time_arr=explode(' ',$meta_arr[1]);
				  $date_arr=explode(':',$date_time_arr[0]);
				  $time_arr=explode(':',$date_time_arr[1]);
				  $datetime=mktime($time_arr[0],$time_arr[1],$time_arr[2],$date_arr[1],$date_arr[2],$date_arr[0]);
				  $meta_details[$inc]['value']=date('jS M Y',$datetime);
				  }
				*/
				$inc++;
		      }
             $this->is_meta_details=true;
			}
		$this->meta_details_arr=$meta_details;
	}
	public function getPhotoLocation()
	{
		$sql = 'SELECT google_map_latitude,google_map_longtitude,location_recorded ' . 'FROM ' . $this->CFG['db']['tbl']['photo'] . ' WHERE photo_status = \'Ok\' AND photo_id= ' . $this->dbObj->Param('photo_id');
        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
        if (!$rs)
        	trigger_db_error($this->dbObj);
        $this->getGoogleMap=false;
        if($row = $rs->FetchRow())
        {
        	$this->fields_arr['latitude'] = $row['google_map_latitude'];
			$this->fields_arr['longitude'] = $row['google_map_longtitude'];
			$this->fields_arr['address'] = $row['location_recorded'];
			if($row['location_recorded'])
			    $this->getGoogleMap=true;
		}
	}
	public function updatePhotoLocation()
	{

		$sql = 'UPDATE '. $this->CFG['db']['tbl']['photo'] .'  SET ';
			if(!empty($this->fields_arr['latitude'])&&!empty($this->fields_arr['longitude'])&&!empty($this->fields_arr['address']))
			{
				$sql_update = ' google_map_latitude = '.$this->dbObj->Param('latitude').
							  ', google_map_longtitude = '.$this->dbObj->Param('longitude').
							  ', location_recorded = '.$this->dbObj->Param('address');
				$inser_val_arr = array($this->fields_arr['latitude'],$this->fields_arr['longitude'],$this->fields_arr['address'],$this->fields_arr['photo_id']);
			}
			elseif(!empty($this->fields_arr['location']))
			{
				$sql_update = ' location_recorded = '.$this->dbObj->Param('location');
				$inser_val_arr = array($this->fields_arr['location'],$this->fields_arr['photo_id']);
			}
		$sql =$sql.$sql_update.' WHERE photo_status = \'Ok\' AND photo_id= '.$this->dbObj->Param('photo_id');
        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt, $inser_val_arr);
        if (!$rs)
        	trigger_db_error($this->dbObj);
        if ($this->dbObj->Affected_Rows() > 0)
		{
			return true;
		}
		return false;
	}
	public function removePhotoLocation()
	{

		$sql = 'UPDATE '. $this->CFG['db']['tbl']['photo'] .'  SET '.
			 	' location_recorded = "" WHERE photo_status = \'Ok\' AND photo_id= '.$this->dbObj->Param('photo_id');
        $stmt = $this->dbObj->Prepare($sql);
        $rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
        if (!$rs)
        	trigger_db_error($this->dbObj);
        if ($this->dbObj->Affected_Rows() > 0)
		{
			return true;
		}
		return false;
	}
	/**
	 * Viewphoto::getTagsOfThisPhoto()
	 * purpose to get tags of the photo
	 * @return
	 **/
	public function getTagsOfThisPhoto($tag='')
		{
			$tags_arr = explode(' ',$this->fields_arr['photo_tags']);
			foreach($tags_arr as $tags)
				{
					?>
					<span>
					<a id="photo_tag_<?php echo $tags; ?>"
					<?php
						if (isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule())
							echo 'onmouseover="getSubscriptionOption(\''.addslashes($tags).'\', \''.$this->CFG['site']['is_module_page'].'\', \'Tag\', \'pos_'.$this->changeTitle($tags).'\')"';
						?>
							href="<?php echo getUrl('photolist','?pg=photonew&amp;tags='.$tags, 'photonew/?tags='.$tags,'','photo');?>"><?php echo $tags;?></a>
					<span id="pos_<?php echo $this->changeTitle($tags); ?>">&nbsp;</span>
					</span>

					<?php
				}
		}
	public function populateMySubTags()
	{
		$sql = 'SELECT tag_name FROM '.$this->CFG['db']['tbl']['subscription'].
			    ' WHERE status=\'Yes\' AND module = \'photo\''.
				' AND subscriber_id='.$this->CFG['user']['user_id'].
				' ORDER BY tag_name ASC';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_db_error($this->dbObj);
		if ($rs->PO_RecordCount()>0)
	    {
	    	$mySubTagArray = array();
	    	while($row = $rs->FetchRow())
	        {
	        	if($row['tag_name']<>'')
					$mySubTagArray[] = $row['tag_name'];
			}
			return $mySubTagArray;
	    }
	}
	/**
	 * Viewphoto::getTagsOfThisPhoto()
	 * purpose to get tags of the photo
	 * @return
	 **/
	public function populateTagsOfThisPhoto($tag='')
	{
		global $smartyObj;
		$subscription_tag_list = array();
		$mySubTagArr = array();
		$tags_arr = explode(' ',$this->fields_arr['photo_tags']);
		$searchUrl = getUrl('photolist', '?pg=photonew&tags=%s','photonew/?tags=%s','','photo');
		$inc=0;
		if(isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule())
		{
			$mySubTagArr = array();
    		$mySubTagArr=$this->populateMySubTags();
    	}
		foreach($tags_arr as $tag)
		{
			$url 	= sprintf($searchUrl, $tag);
			$subscription_tag_list['item'][$inc]['url']=$url;
			$subscription_tag_list['item'][$inc]['name']=$tag;
			$subscription_tag_list['item'][$inc]['add_slash_name']=addslashes($tag);
			if(isMember() and chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule())
			{
				$subscription_tag_list['item'][$inc]['subscription']=false;
				if(!empty($mySubTagArr))
				{
					if(in_array($tag,$mySubTagArr))
					{
						$subscription_tag_list['item'][$inc]['subscription']=true;
					}
				}
			}
			$inc++;
		}
		//echo '<pre>'; print_r($subscription_tag_list); echo '</pre>';
		$smartyObj->assign('subscription_tag_list', $subscription_tag_list);
	}

	/**
	 * viewPhorto::checkSameUserInComment()
	 *
	 * @return
	 */
	public function checkSameUserInComment($err_msg, $chk_photo_owner = false)
	{

		if($chk_photo_owner)
		{
			$photo_owner_status = $this->chkisPhotoOwner();
			if($photo_owner_status)
			{
				return $photo_owner_status;
			}
		}

		$sql = 'SELECT photo_comment_id FROM '.$this->CFG['db']['tbl']['photo_comments'].' AS p'.
				' WHERE p.photo_id = '.$this->dbObj->Param('photo_id').
				' AND p.comment_user_id = '.$this->dbObj->Param('comment_user_id').
				' AND p.photo_comment_id = '.$this->dbObj->Param('photo_comment_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id'], $this->CFG['user']['user_id'], $this->fields_arr['comment_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);

		$row = $rs->FetchRow();

		if($row['photo_comment_id'] != '')
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
//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
$viewphoto = new Viewphoto();
if(!chkAllowedModule(array('photo')))
	Redirect2URL($CFG['redirect']['dsabled_module_url']);
$viewphoto->setPageBlockNames(array('block_viewphoto_photodetails', 'block_viewphoto_statistics',
									 'delete_confirm_form',
									'get_code_form','confirmation_flagged_form', 'add_comments',
									'add_reply', 'edit_comment', 'block_view_photo_more_photos',
									'update_comment', 'rating_image_form', 'add_flag_list',
									'add_fovorite_list', 'block_view_photo_player',
									'confirmation_adult_form', 'block_view_photo_main',
									'block_add_comments','block_image_display', 'photo_comments_block', 'block_confirmation',
									'block_people_on_photos','block_view_photo_meta_details',
									'block_add_location','block_view_photo','block_display_banners','block_viewphoto_action_tabs'
									));
//default form fields and values...
$viewphoto->setFormField('show','');
$viewphoto->setFormField('msg','');
$viewphoto->setFormField('type','');
$viewphoto->setFormField('vpkey', '');
$viewphoto->setFormField('action', '');
$viewphoto->setFormField('comment_id',0);
$viewphoto->setFormField('maincomment_id',0);
$viewphoto->setFormField('f',0);
$viewphoto->setFormField('user_id', '');
$viewphoto->setFormField('page', '');
$viewphoto->setFormField('ajax_page','');
$viewphoto->setFormField('photo_id', '');
$viewphoto->setFormField('photo_title', '');
$viewphoto->setFormField('type', '');
$viewphoto->setFormField('allow_embed', '');
$viewphoto->setFormField('large_width', '');
$viewphoto->setFormField('large_height', '');

$viewphoto->setFormField('blog_post_title', '');
$viewphoto->setFormField('blog_post_text', '');

$viewphoto->setFormField('relatedPhoto', '');
$viewphoto->setFormField('playlist_description', '');
$viewphoto->setFormField('favorite', '');
$viewphoto->setFormField('favorite_id', '');
$viewphoto->setFormField('flag_comment', '');
$viewphoto->setFormField('flag', '');
$viewphoto->setFormField('flagged_content', '');
$viewphoto->setFormField('featured', '');
$viewphoto->setFormField('rate', '');
$viewphoto->setFormField('latitude', '');
$viewphoto->setFormField('longitude', '');
$viewphoto->setFormField('address', '');
$viewphoto->setFormField('location', '');
$viewphoto->setFormField('photo_tags', '');
$viewphoto->setFormField('photo_caption', '');
$viewphoto->setFormField('recaptcha_challenge_field', '');
$viewphoto->setFormField('recaptcha_response_field', '');
$viewphoto->setFormField('playlist', '');
$viewphoto->setFormField('playlist_name', '');
$viewphoto->setFormField('photo_playlist_id', '');
$viewphoto->setFormField('playlist_access_type', 'Public');
// ********** Page Navigation Start ********
$viewphoto->setFormField('start', '0');
$viewphoto->setFormField('numpg', 3);
//$viewphoto->setFormField('numpg', $CFG['data_tbl']['numpg']);

$viewphoto->setMinRecordSelectLimit($CFG['data_tbl']['min_record_select_limit']);
$viewphoto->setMaxRecordSelectLimit($CFG['data_tbl']['max_record_select_limit']);
$viewphoto->setNumPerPageListArr($CFG['data_tbl']['numperpage_list_arr']);
$viewphoto->setTableNames(array());
$viewphoto->setReturnColumns(array());
// *********** page Navigation stop ************


$viewphoto->flag_type_arr = $LANG_LIST_ARR['flag']['photo'];
$LANG['viewphoto_canvas_error_message']=str_replace('{height}', $CFG['admin']['photos']['canvas_add_tag_allowed_height'] ,$LANG['viewphoto_canvas_error_message']);
$LANG['viewphoto_canvas_error_message']=str_replace('{width}', $CFG['admin']['photos']['canvas_add_tag_allowed_width'] ,$LANG['viewphoto_canvas_error_message']);
$viewphoto->viewphoto_canvas_error_message=$LANG['viewphoto_canvas_error_message'];
$viewphoto->sanitizeFormInputs($_REQUEST);
$viewphoto->location_url = $CFG['site']['photo_url'].'photoList.php?type=add_location&photo_id='.$viewphoto->getFormField('photo_id').'&page=viewphoto';
$viewphoto->memberLoginPhotoUrl = getUrl('viewphoto','?mem_auth=true&photo_id='.$viewphoto->getFormfield('photo_id').'&title='.
																		$viewphoto->changeTitle($viewphoto->getFormfield('photo_title')),
																			$viewphoto->getFormfield('photo_id').'/'.
																				$viewphoto->changeTitle($viewphoto->getFormfield('photo_title')).
																					'/?mem_auth=true','members', 'photo');
if(isAjaxPage())
	{
	$viewphoto->includeAjaxHeaderSessionCheck();
	$viewphoto->validate = $viewphoto->chkValidPhotoId();
	if ($viewphoto->getFormField('action')=='popplaylist')
	    {
	    	$viewphoto->checkLoginStatusInAjax($viewphoto->memberLoginPhotoUrl);
			$viewphoto->populateSlidelistContent();
			die();
	    }
	   //RELATED PHOTOS CONTENT START//
		if ($viewphoto->isPageGETed($_POST, 'pUserFetch'))
		    {
				$viewphoto->populateRelatedPhoto('user');
				die();
		    }
		if ($viewphoto->isPageGETed($_POST, 'pTagFetch'))
		    {
		    	$viewphoto->populateRelatedPhoto('tag');
				die();
		    }
		if($viewphoto->getFormField('relatedPhoto'))
			{
		  		$viewphoto->populateRelatedPhoto($viewphoto->getFormField('type'));
				exit;
			}
		if($viewphoto->isFormGETed($_GET, 'rate'))
			{
				if($viewphoto->chkAllowRating())
					{
						$viewphoto->setAllPageBlocksHide();
						$viewphoto->checkLoginStatusInAjax($viewphoto->memberLoginPhotoUrl);
						$viewphoto->insertRating();
						$viewphoto->getTotalRatingImage();
						die();
					}
			}
		else if($viewphoto->isFormGETed($_POST, 'flag')
				or $viewphoto->isFormGETed($_POST, 'flag_comment'))
			{
				$viewphoto->setAllPageBlocksHide();
				if(!$viewphoto->chkIsNotEmpty('flag_comment', $LANG['viewphoto_flag_comment_invalid']))
					{
						echo $viewphoto->getFormFieldErrorTip('flag_comment');
						exit;
					}
				$viewphoto->setFormField('flag_comment',trim(urldecode($viewphoto->getFormField('flag_comment'))));
				$viewphoto->checkLoginStatusInAjax($viewphoto->memberLoginPhotoUrl);
				$viewphoto->insertFlagPhotoTable();
			}
		else if($viewphoto->isFormGETed($_GET, 'favorite'))
			{
				$viewphoto->setAllPageBlocksHide();
				$viewphoto->checkLoginStatusInAjax($viewphoto->memberLoginPhotoUrl);
				if($viewphoto->getFormField('favorite'))
					{
						$viewphoto->insertFavoritePhoto();
					}
				else
					{
						$viewphoto->deleteFavoritePhoto($viewphoto->getFormField('photo_id'),$CFG['user']['user_id']);
						echo $viewphoto->LANG['viewphoto_favorite_deleted_successfully'];
					}
			}
		else if($viewphoto->isFormGETed($_GET, 'featured'))
			{
				$viewphoto->setAllPageBlocksHide();
				$viewphoto->checkLoginStatusInAjax($viewphoto->memberLoginPhotoUrl);
				if($viewphoto->getFormField('featured'))
				{
					$viewphoto->insertFeaturedPhoto();
				}
				else
				{
					$viewphoto->deleteFromFeatured(true, $viewphoto->getFormField('photo_id'));
				}

			}
		if($viewphoto->getFormField('type') == 'update_location')
			{
						$viewphoto->setAllPageBlocksHide();
						$viewphoto->updatePhotoLocation();
						exit;
			}
		  elseif($viewphoto->getFormField('type') == 'remove_location')
			{
						$viewphoto->setAllPageBlocksHide();
						$viewphoto->removePhotoLocation();
						exit;
			}



	if($viewphoto->getFormField('page') == 'playlist')
	{
		$viewphoto->setAllPageBlocksHide();
		$viewphoto->checkLoginStatusInAjax($viewphoto->memberLoginPhotoUrl);
		# Add photo to playlist
		$flag = 1;
		if($viewphoto->getFormField('playlist_name')!= '')
		{
			# Check already exist
			if(!$viewphoto->chkPlaylistExits('playlist_name', $LANG['viewplaylist_tip_alreay_exists']))
			{
				$flag =0;
				echo $viewphoto->getFormFieldErrorTip('playlist_name');
			}
			$subject = str_replace('VAR_MIN', $CFG['fieldsize']['photo_playlist_name']['min'], $LANG['viewplaylist_invalid_size']);
			$subject = str_replace('VAR_MAX', $CFG['fieldsize']['photo_playlist_name']['max'], $subject);
			if(!$viewphoto->chkIsValidSize('playlist_name', 'photo_playlist_name', $subject))
			{
				$flag =0;
				echo $viewphoto->getFormFieldErrorTip('playlist_name');
			}
		}

		if($flag)
			{
				if($viewphoto->isFormGETed($_POST, 'playlist') && $viewphoto->chkIsNotEmpty('playlist',''))
				{
					$playlist_id = $viewphoto->getFormField('playlist');
					echo sprintf($LANG['viewplaylist_successfully_msg'],$viewphoto->getFormField('playlist_name'));
					echo '#$#'.$playlist_id;
				}
				else
				{
					# Create new playlist
					$playlist_id = $viewphoto->createPlaylist();
					$viewphoto->playlistCreateActivity($playlist_id);
					echo sprintf($LANG['viewplaylist_successfully_msg'],$viewphoto->getFormField('playlist_name'));
					echo '#$#'.$playlist_id;
				}
				# INSERT SONG TO PLAYLIST SONG
				$song_id = explode(',', $viewphoto->getFormField('photo_id'));
				for($inc=0;$inc<count($song_id);$inc++)
					$viewphoto->insertPhototoPlaylist($playlist_id, $song_id[$inc]);
			}
	}


		if ($viewphoto->isPageGETed($_POST, 'ajaxpaging'))
		    {
				$viewphoto->populateCommentOfThisPhoto();
				ob_end_flush();
				die();
		    }

	if($viewphoto->getFormField('page') != '')
			{
				switch ($viewphoto->getFormField('page'))
					{
						case 'load_flag':
							$viewphoto->populateFlagContent();
						break;

						case 'load_blog':
							$viewphoto->checkLoginStatusInAjax($viewphoto->memberLoginPhotoUrl);
							$viewphoto->populateBlogContent();
						break;

						case 'post_comment':
							$viewphoto->checkLoginStatusInAjax($viewphoto->memberLoginPhotoUrl);
							if($CFG['admin']['photos']['captcha'] AND $CFG['admin']['photos']['captcha_method'] == 'recaptcha'
										AND $CFG['captcha']['public_key'] AND $CFG['captcha']['private_key'])
								{
									$viewphoto->chkIsCaptchaNotEmpty('recaptcha_response_field', $LANG['common_err_tip_compulsory']) AND
										$viewphoto->chkCaptcha('recaptcha_response_field', $LANG['common_err_tip_invalid_captcha']);
								}
							$viewphoto->setAllPageBlocksHide();
							$viewphoto->setPageBlockShow('block_add_comments');
							$htmlstring = trim(urldecode($viewphoto->getFormField('f')));
							$htmlstring = strip_tags(html_entity_decode($htmlstring), '<br><br />');
							$viewphoto->setFormField('f',$htmlstring);
							$viewphoto->insertCommentAndPhotoTable();
						break;

						case 'deletecomment':
							$viewphoto->checkLoginStatusInAjax($viewphoto->memberLoginPhotoUrl);
							$viewphoto->checkSameUserInComment($LANG['common_login_other_user_comment_delete_err_msg'], true);
							$viewphoto->setPageBlockShow('block_add_comments');
							$viewphoto->setPageBlockHide('block_confirmation');
							$viewphoto->setPageBlockShow('block_add_comments');
							$viewphoto->deleteComment();
							$viewphoto->populateCommentOfThisPhoto();
						break;

						case 'deletecommentreply':
							$viewphoto->checkLoginStatusInAjax($viewphoto->memberLoginPhotoUrl);
							$viewphoto->checkSameUserInComment($LANG['common_login_other_user_comment_delete_err_msg'], true);
							$viewphoto->deleteComment();
							$viewphoto->populateReplyCommentOfThisPhoto();
							break;

						case 'comment_edit':
							echo $viewphoto->getFormField('comment_id');
							echo '***--***!!!';
							$viewphoto->checkLoginStatusInAjax($viewphoto->memberLoginPhotoUrl);
							$viewphoto->checkSameUserInComment($LANG['common_login_other_user_comment_edit_err_msg']);
							$viewphoto->getEditCommentBlock();
						break;

						case 'update_comment':
							$viewphoto->checkLoginStatusInAjax($viewphoto->memberLoginPhotoUrl);
							$viewphoto->checkSameUserInComment($LANG['common_login_other_user_comment_edit_err_msg']);
							$htmlstring = trim(urldecode($viewphoto->getFormField('f')));
							$htmlstring = strip_tags(html_entity_decode($htmlstring), '<br><br />');
							$viewphoto->setFormField('f',$htmlstring);
							$viewphoto->updateCommentAndPhotoTable();
							echo $viewphoto->getFormField('comment_id');
							echo '***--***!!!';
							echo $viewphoto->getFormField('f');
						break;

						case 'getcode':
							$viewphoto->setAllPageBlocksHide();
							$viewphoto->setPageBlockShow('get_code_form');
							$viewphoto->setFormField('image_width', $CFG['admin']['photos']['thumb_width']);
							$viewphoto->populatePhotoDetails();

							if ($viewphoto->isShowPageBlock('get_code_form'))
							    {
									?>
									<div id="groupAdd">
							  			<h2><span><?php echo $LANG['viewphoto_codes_to_display'];?></span></h2>

							  			<form name="formGetCode" id="formInvite" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
							    		<p class="clsPaddingTop5">
							      			<textarea class="clsEmbedCodeTextFields" rows="5" cols="75" name="image_code" id="image_code" READONLY tabindex="5" onFocus="this.select()" onClick="this.select()" ><?php echo $viewphoto->embeded_code;?></textarea>
							    		</p>
							  			</form>
										<p>
							  			<input class="clsSubmitButton" onClick="return hideAllBlocks();" value="<?php echo $LANG['viewphoto_cancel'];?>" type="button" />
							  			</p>
									</div>
								<?php
								}
						break;


					}
				$viewphoto->includeAjaxFooter();
				exit;
			}

}
else
{
    $_SESSION['pUserStart'] = 0;
	$_SESSION['pTagStart'] = 0;

    $viewphoto->validate = false;
	$viewphoto->IS_USE_AJAX = true;
	$viewphoto->validate = $viewphoto->chkValidPhotoId();
	$viewphoto->getNextLink();
	$viewphoto->getPreviousLink();
	$viewphoto->populateTagsOfThisPhoto();

	$LANG['meta_viewphoto_keywords'] = str_replace('{default_tags}', $CFG['html']['meta']['keywords'], $LANG['meta_viewphoto_keywords']);
	$LANG['meta_viewphoto_keywords'] = str_replace('{tags}', $viewphoto->getFormField('photo_tags'), $LANG['meta_viewphoto_keywords']);

	$LANG['meta_viewphoto_description'] = str_replace('{default_tags}', $CFG['html']['meta']['description'], $LANG['meta_viewphoto_description']);
	$LANG['meta_viewphoto_description'] = str_replace('{tags}', $viewphoto->getFormField('photo_caption'), $LANG['meta_viewphoto_description']);

	$LANG['meta_viewphoto_title'] = str_replace('{site_title}', $CFG['site']['title'], $LANG['meta_viewphoto_title']);
	$LANG['meta_viewphoto_title'] = str_replace('{module}', $LANG['window_title_photo'], $LANG['meta_viewphoto_title']);
	$LANG['meta_viewphoto_title'] = str_replace('{title}', $viewphoto->getFormField('photo_title'), $LANG['meta_viewphoto_title']);

	setPageTitle($LANG['meta_viewphoto_title']);
	setMetaKeywords($LANG['meta_viewphoto_keywords']);
	setMetaDescription($LANG['meta_viewphoto_description']);


	if($viewphoto->isFormGETed($_GET, 'action'))
	{
		$display = 'error';
		if(($viewphoto->getFormField('action')=='view' or $viewphoto->getFormField('action')=='accept' or $viewphoto->getFormField('action')=='reject') and $viewphoto->validate)
			{

			if(isAdultUser('allow'))
				$display = 'photo';
			else
				{
					if($CFG['admin']['photos']['adult_content_view']!='No')
						$display = 'photo';
					else
						$display = 'error';
				}
			switch($display)
				{
					case 'error':
						$viewphoto->setAllPageBlocksHide();
						$viewphoto->setCommonErrorMsg($viewphoto->replaceAdultText($LANG['msg_error_not_allowed']));
						$viewphoto->setPageBlockShow('block_msg_form_error');
						break;

					case 'photo':
						switch($viewphoto->getFormField('action'))
							{
								case 'accept':
									$viewphoto->changeMyContentFilterSettings($CFG['user']['user_id'], 'Off');
									break;

								case 'reject':
									if($CFG['user']['user_id'])
										$viewphoto->changeMyContentFilterSettings($CFG['user']['user_id'], 'On');
									Redirect2Url($CFG['site']['url']);
									break;
							}
						$viewphoto->setPageBlockShow('block_viewphoto_photodetails');
						break;
				}
			}
		elseif($viewphoto->getFormField('flagged_content')=='show')
		{
			$display = 'photo';
		}
		else
			{
				$viewphoto->setAllPageBlocksHide();
				//$viewphoto->setCommonErrorMsg($LANG['common_msg_error_sorry']);
				//$viewphoto->setPageBlockShow('block_msg_form_error');
			}
	}
  if($viewphoto->validate)
	{
		$viewphoto->photoOwner = false;
		if(isMember())
		{
			if ($viewphoto->chkisPhotoOwner())
			{
			    $viewphoto->photoOwner = true;
				$viewphoto->managephoto_url = getUrl('photouploadpopup', '?photo_id='.$viewphoto->getFormField('photo_id'), $viewphoto->getFormField('photo_id').'/', '', 'photo');
			}
		}


		$display = 'photo';
		if((chkAllowedModule(array('content_filter'))) and ($viewphoto->getFormField('photo_category_type')=='Porn'))
		{
			if(isAdultUser())
			{
				$display = 'photo';
			}
			else
			{
				if($CFG['admin']['photos']['adult_content_view']=='Confirmation')
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
		if(($viewphoto->getFormfield('flagged_status') == 'Yes') and ($viewphoto->getFormField('flagged_content')!='show'))
			$display = 'flag';

		if(($display == 'adult') and ($viewphoto->getFormField('action')=='view'))
			$display = 'photo';

		switch($display)
		{
			case 'error':
				$viewphoto->setAllPageBlocksHide();
				$viewphoto->setCommonErrorMsg($viewphoto->replaceAdultText($LANG['msg_error_not_allowed']));
				$viewphoto->setPageBlockShow('block_msg_form_error');
				break;

			case 'adult':
				$viewphoto->setAllPageBlocksHide();
				$viewphoto->setPageBlockShow('confirmation_adult_form');
				break;

			case 'flag':
				$viewphoto->setAllPageBlocksHide();
				$viewphoto->setPageBlockShow('confirmation_flagged_form');
				break;

			case 'photo':
			    updatePhotoTotalViews($viewphoto->getFormfield('photo_id'));
			    changePhotoViewed($viewphoto->getFormfield('photo_id'),$viewphoto->getFormfield('user_id'));
				$viewphoto->setPageBlockShow('block_viewphoto_photodetails');
				$viewphoto->setPageBlockShow('block_view_photo');
				$viewphoto->setPageBlockShow('block_people_on_photos');
				$viewphoto->setPageBlockShow('block_viewphoto_statistics');
				$viewphoto->setPageBlockShow('block_view_photo_player');
				$viewphoto->setPageBlockShow('block_view_photo_main');
				$viewphoto->setPageBlockShow('block_view_photo_more_photos');
				$viewphoto->setPageBlockShow('photo_comments_block');
				$viewphoto->setPageBlockShow('block_display_banners');
				$viewphoto->setPageBlockShow('block_viewphoto_action_tabs');
				break;
		}
		$viewphoto->displayPhoto();
		$viewphoto->populatePeopleOnPhoto();
		$viewphoto->getPhotoMetaDetails();
		$viewphoto->getPhotoLocation();

		if($viewphoto->is_meta_details && $CFG['admin']['photos']['photo_meta_data'] && $display=='photo')
		   $viewphoto->setPageBlockShow('block_view_photo_meta_details');

		if((($viewphoto->getGoogleMap && $viewphoto->getFormField('latitude') && $viewphoto->getFormField('longitude')) || $viewphoto->getFormField('user_id')==$CFG['user']['user_id'] || isAdmin()) && $display=='photo')
	   	     $viewphoto->setPageBlockShow('block_add_location');

		if(isMember())
		{
			if($viewphoto->getFormField('msg')=='updated')
			{
				$viewphoto->setCommonSuccessMsg($LANG['photoupload_msg_update_success']);
				$viewphoto->setPageBlockShow('block_msg_form_success');
			}
			$viewphoto->photos_form['getBlogList'] = $viewphoto->getBlogList();
			if(empty($viewphoto->photos_form['getBlogList']))

			{
				$viewphoto->photos_form['add_new_blog_info'] = ' ';
				$viewphoto->photos_form['post_to_blog'] = ' style="display:none;"';
			}
			else
			{
				$viewphoto->photos_form['add_new_blog_info'] = ' style="display:none;"';
				$viewphoto->photos_form['post_to_blog'] = '';
			}


			//$profile_blog_text = '<a href=\''.getUrl('profileblog','', '', 'members', 'photo').'\'>'.$LANG['viewphoto_setup_new_blog'].'</a>';
			//$viewphoto->LANG['viewphoto_blog_post_info'] = str_replace('{setup_new_blog}', $profile_blog_text, $LANG['viewphoto_blog_post_info']);
			//$viewphoto->LANG['viewphoto_no_blog'] = str_replace('{setup_new_blog}', $profile_blog_text, $LANG['viewphoto_no_blog']);
		}
		$viewphoto->populateCommentOptionsPhoto();
		$viewphoto->photoList_category_url = getUrl('photolist', '?pg=photonew&cid='.$viewphoto->getFormField('photo_category_id'), 'photonew/?cid='.$viewphoto->getFormField('photo_category_id'), '', 'photo');
		$viewphoto->photoList_subcategory_url = getUrl('photolist', '?pg=photonew&cid='.$viewphoto->getFormField('photo_category_id').'&sid='.$viewphoto->getFormField('photo_sub_category_id'), 'photonew/?cid='.$viewphoto->getFormField('photo_category_id').'&sid='.$viewphoto->getFormField('photo_sub_category_id'), '', 'photo');
		$viewphoto->view_photo_embed_url = getUrl('viewphoto','?photo_id='.$viewphoto->getFormField('photo_id').'&title='.$viewphoto->changeTitle($viewphoto->getFormField('photo_title')), $viewphoto->getFormField('photo_id').'/'.$viewphoto->changeTitle($viewphoto->getFormField('photo_title')).'/', '','photo');
		$viewphoto->allow_embed =$viewphoto->getFormField('allow_embed');
	    $viewphoto->embeded_code = htmlentities('<a href="'.$viewphoto->view_photo_embed_url.'" title="'.$viewphoto->statistics_photo_title.'"><img src="'.$viewphoto->photo_path.'" alt="'.$viewphoto->statistics_photo_title.'" width="'.$viewphoto->getFormField('large_width').'" height="'.$viewphoto->getFormField('large_height').'" border="0" /></a>');
	    $viewphoto->embeded_code_default = '<a href="'.$viewphoto->view_photo_embed_url.'" title="'.$viewphoto->statistics_photo_title.'"><img src="'.$viewphoto->photo_path.'" alt="'.$viewphoto->statistics_photo_title.'" width="'.$viewphoto->getFormField('large_width').'" height="'.$viewphoto->getFormField('large_height').'" border="0" /></a>';
	    $viewphoto->embeded_code_js = '<a href="'.$viewphoto->view_photo_embed_url.'" title="'.$viewphoto->statistics_photo_title.'"><img src="'.$viewphoto->photo_path.'" alt="'.$viewphoto->statistics_photo_title.'" width="{$width}" height="{$height}" border="0" /></a>';

		//PHOTO COMMENT//
		$viewphoto->setPageBlockShow('block_add_comments');
		$viewphoto->setPageBlockShow('block_confirmation');

	}
	else
	{
		$viewphoto->setAllPageBlocksHide();
		if($viewphoto->resultFound)
		{
	    	Redirect2URL(getUrl('photolist', '?pg=private_photo', 'private_photo/', '', 'photo'));
		}
		else
		{
			Redirect2URL(getUrl('photolist', '?pg=invalid_photo_id', 'invalid_photo_id/', '', 'photo'));
		}

	}
	if ($viewphoto->isShowPageBlock('confirmation_adult_form'))
		{
			$viewphoto->acceptAdultPhotoUrl		= getUrl('viewphoto','?photo_id='.$viewphoto->getFormfield('photo_id').'&title='.$viewphoto->changeTitle($viewphoto->getFormfield('photo_title')).'&action=accept&vpkey='.$viewphoto->getFormfield('vpkey'), $viewphoto->getFormfield('photo_id').'/'.$viewphoto->changeTitle($viewphoto->getFormfield('photo_title')).'/?action=accept&vpkey='.$viewphoto->getFormfield('vpkey'),  '', 'photo');
			$viewphoto->acceptThisAdultPhotoUrl	= getUrl('viewphoto','?photo_id='.$viewphoto->getFormfield('photo_id').'&title='.$viewphoto->changeTitle($viewphoto->getFormfield('photo_title')).'&action=view&vpkey='.$viewphoto->getFormfield('vpkey'), $viewphoto->getFormfield('photo_id').'/'.$viewphoto->changeTitle($viewphoto->getFormfield('photo_title')).'/?action=view&vpkey='.$viewphoto->getFormfield('vpkey'), '', 'photo');
			$viewphoto->rejectAdultPhotoUrl		= getUrl('viewphoto','?photo_id='.$viewphoto->getFormfield('photo_id').'&title='.$viewphoto->changeTitle($viewphoto->getFormfield('photo_title')).'&action=reject&vpkey='.$viewphoto->getFormfield('vpkey'), $viewphoto->getFormfield('photo_id').'/'.$viewphoto->changeTitle($viewphoto->getFormfield('photo_title')).'/?action=reject&vpkey='.$viewphoto->getFormfield('vpkey'), '', 'photo');
			$viewphoto->rejectThisAdultPhotoUrl	= getUrl('index','','');
		}

}

$viewphoto->includeHeader();
//code added for subscription module.
?>
<script type="text/javascript">
var block_arr = new Array('selMsgConfirmCommon', 'flagDiv');
</script>
<?php
if($viewphoto->validate)
{
?>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['photo_url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default'];?>/viewOriginalPhoto.css">
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['photo_url'];?>js/photoComment.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['photo_url'];?>js/sharePhoto.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['photo_url'];?>js/createPlaylist.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/tooltip.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/lib/prototype.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['photo_url'];?>js/annotationDrag.js"></script>
<!--[if IE]><script type="text/javascript" src="<?php echo $CFG['site']['photo_url'];?>js/excanvas.js"></script><![endif]-->
<script type="text/javascript">
var ajax_photo_tagging_url = '<?php echo getUrl('ajaxphototagging','', '','','photo'); ?>';
var ajax_photo_contact_url = '<?php echo getUrl('ajaxphotocontact','', '','','photo'); ?>';
var people_photo_tagged_url = '<?php echo getUrl('peopleonphoto','', '','','photo'); ?>';
var delete_photo_tag_icon  = "<?php echo $CFG['site']['url'].'photo/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/canvas/delete.gif' ?>";
var associate_tag_icon  = "<?php echo $CFG['site']['url'].'photo/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/canvas/trash.gif' ?>";
var search_loader_icon  = "<?php echo $CFG['site']['url'].'photo/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/canvas/indicator.gif' ?>";
var no_people_photo_icon  = "<?php echo $CFG['site']['url'].'photo/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/canvas/noPeople.gif' ?>";
var photo_owner_id = <?php echo $viewphoto->getFormField('user_id');?>;

var annotation_lang_error_occured = "<?php echo $LANG['viewphoto_err_tip_error_occured'];?>";
var annotation_lang_highlight_all = "<?php echo $LANG['viewphoto_highlight_all'];?>";
var annotation_lang_unhighlight_all = "<?php echo $LANG['viewphoto_unhighlight_all'];?>";
var annotation_lang_contact_name = "<?php echo $LANG['viewphoto_annotation_contact_name'];?>";
var annotation_lang_add_new = "<?php echo $LANG['viewphoto_annotation_add_new'];?>";
var annotation_lang_associate_user = "<?php echo $LANG['viewphoto_annotation_associate_user'];?>";
var annotation_lang_find_contact = "<?php echo $LANG['viewphoto_annotation_find_contact'];?>";
var annotation_lang_contact_loading = "<?php echo $LANG['viewphoto_annotation_contact_loading'];?>";
var annotation_lang_search_note = "<?php echo $LANG['viewphoto_annotation_search_note'];?>";
var annotation_lang_email = "<?php echo $LANG['viewphoto_annotation_email'];?>";
var annotation_lang_button_save = "<?php echo $LANG['viewphoto_annotation_button_save'];?>";
var annotation_lang_button_cancel = "<?php echo $LANG['viewphoto_annotation_button_cancel'];?>";
var annotation_lang_canvas_delete = "<?php echo $LANG['viewphoto_annotation_delete'];?>";
var annotation_lang_assoc_delete = "<?php echo $LANG['viewphoto_annotation_remove_associate'];?>";
var canvas_tag_width = "<?php echo $CFG['admin']['photos']['canvas_tag_width'];?>";
var canvas_tag_height = "<?php echo $CFG['admin']['photos']['canvas_tag_height'];?>";
var annotation_tag__maxlength = "<?php echo $CFG['fieldsize']['photo_people_on_photo_tags']['max'];?>";
</script>
<script type="text/javascript" src="<?php echo $CFG['site']['photo_url'];?>js/annotation.js"></script>
<script type="text/javascript">
var deleteConfirmation = "<?php echo $LANG['viewphoto_comment_delete_confirmation'];?>";
var common_delete_login_err_message = "<?php echo $LANG['common_delete_login_err_message'];?>";
var member_login_url = '<?php echo $viewphoto->memberviewPhotoUrl; ?>';
var comment_success_deleted_msg='<?php echo $LANG['viewphoto_comment_success_deleted'];?>';
var viewphoto_mandatory_fields = "<?php echo $LANG['viewphoto_mandatory_fields']; ?>";
var kinda_comment_msg = "<?php echo $LANG['viewphoto_comment_approval']; ?>";
var disPrevButton = 'clsPreviousDisable';
var disNextButton = 'clsNextDisable';
var pars= 'pLeft=&pFetch=';
var homeUrl = '<?php echo getUrl('viewphoto','?photo_id='.$viewphoto->getFormField('photo_id'), $viewphoto->getFormField('photo_id').'/','','photo'); ?>';
var slidelist_url = '<?php echo $CFG['site']['url'].'photo/createSlidelist.php?action=save_playlist&page=viewphoto&photo_id='.$viewphoto->getFormField('photo_id'); ?>';
var playlist_name_error_msg = '<?php echo $LANG['common_photo_playlist_errortip_select_title']; ?>';
var playlist_tag_error_msg = '<?php echo $LANG['photoplaylist_error_tips']; ?>';
var share_url = '<?php echo $viewphoto->share_url; ?>';
var photo_id = '<?php echo $viewphoto->getFormField('photo_id'); ?>';
var view_photo_ajax_page_loading = '<img alt="<?php echo $LANG['common_photo_loading']; ?>" src="<?php echo $CFG['site']['url'].'photo/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/loading-viewphoto.gif' ?>" \/>';
var view_photo_scroll_loading='<div class="clsLoader">'+view_photo_ajax_page_loading+'<\/div>';
var recalculate_scroll_view_photo = true;
var site_url = '<?php echo $CFG['site']['url'];?>';
var enabled_edit_fields = new Array();
var favorite_added = '<?php if($viewphoto->favorite['added']=='') echo '1'; else echo ''; ?>';
var favorite_url = '<?php echo $viewphoto->favorite['url'];?>';
var load_flag_url = '<?php echo $viewphoto->load_flag_url; ?>';
var featured_added = '<?php if($viewphoto->featured['added']=='') echo '1'; else echo ''; ?>';
var featured_url= '<?php echo $viewphoto->featured['url']; ?>';
var total_rating_images = '<?php echo $CFG['admin']['total_rating']; ?>';
var rateimage_url = '<?php echo $CFG['site']['url'].'photo/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/icon-photorate.gif';?>';
var rateimagehover_url = '<?php echo $CFG['site']['url'].'photo/design/templates/'.$CFG['html']['template']['default'].'/root/images/'.$CFG['html']['stylesheet']['screen']['default'].'/icon-photoratehover.gif';?>';
var embed_req ="<?php echo $LANG['viewphoto_embed_required'];?>";
var embed_int ="<?php echo $LANG['viewphoto_embed_integers'];?>";
var embeded_code_default ='<?php echo $viewphoto->embeded_code_default;?>';
var embeded_code_js ='<?php echo $viewphoto->embeded_code_js;?>';
var photolink_Slidelist="<?php echo $LANG['viewphoto_slidelist'];?>";
var photolink_SharePhoto="<?php echo $LANG['viewphoto_share_photo'];?>";
var photolink_Favorites="<?php echo $LANG['viewphoto_favorite'];?>";
var photolink_Flag="<?php echo $LANG['viewphoto_flag'];?>";
var photolink_Featured="<?php echo $LANG['viewphoto_feature'];?>";
var photolink_Quickslide="<?php echo $LANG['viewphoto_quickslide'];?>";
var view_photo_quickslide_added="<?php echo $LANG['viewphoto_quickslide_added_successfully'];?>";
var view_photo_quickslide_deleted="<?php echo $LANG['viewphoto_quickslide_deleted_successfully'];?>";

<?php
if(isMember())
{
	echo "var show_div = 'Slidelist';";
}
else
{
	echo "var show_div = 'SharePhoto';";
}
?>
var current_active_tab_class = 'clsActive';
var current_first_active_tab_class = 'clsFirstActive';
var current_last_active_tab_class = 'clsLastActive';
var show_div_first_active = 'selSlidelistContent';
<?php
	if($viewphoto->allow_quickmixs)
	{
		echo "var more_tabs_div = new Array('selQuickslideContent','selSlidelistContent', 'selSharePhotoContent', 'selFavoritesContent', 'selFlagContent', 'selFeaturedContent');";
		echo "var more_tabs_class = new Array('selHeaderQuickslide', 'selHeaderSlidelist', 'selHeaderSharePhoto', 'selHeaderFavorites', 'selHeaderFlag', 'selHeaderFeatured');";
	}
	else
	{
		echo "var more_tabs_div = new Array('selSlidelistContent', 'selSharePhotoContent', 'selFavoritesContent', 'selFlagContent', 'selFeaturedContent');";
		echo "var more_tabs_class = new Array('selHeaderSlidelist', 'selHeaderSharePhoto', 'selHeaderFavorites', 'selHeaderFlag', 'selHeaderFeatured');";
	}
	echo "var show_div_last_active = 'selFeaturedContent';";
?>

$Jq(document).ready(function() {
		//To Show the default div and hide the other divs (call ajax if required)
		//getViewPhotoMoreContent(show_div);
		getCanvasImages();
	});
	var closeShareSlider = function()
	{
	  if($Jq('#selHeaderQuickslide').get(0))
	  $Jq('#selHeaderQuickslide').removeClass('clsActive');
	  $Jq('#selHeaderSlidelist').removeClass('clsActive');
	  $Jq('#selHeaderSharePhoto').removeClass('clsActive');
	  $Jq('#selHeaderFavorites').removeClass('clsActive');
	  $Jq('#selHeaderFlag').removeClass('clsActive');
	  $Jq('#selHeaderFeatured').removeClass('clsActive');
	  $Jq("#selSlideContainer").hide();
	}
	var getViewPhotoMoreContent = function()
		{
			var content_id = arguments[0];

            $Jq('#selPhotoLinkTitle').html(eval('photolink_'+content_id));

			if($Jq('#selSlideContainer').css('display') == 'none')
		       $Jq("#selSlideContainer").slideToggle("slow");

			var view_photo_more_path;
			var call_viewphoto_ajax = false;
			view_photo_content_id = content_id;
			var div_id = 'sel'+content_id+'Content';
			var more_li_id = 'selHeader'+content_id;
			//var more_li_id = 'selHeader'+content_id;
			var div_value = $Jq('#'+div_id).html();
			div_value = $Jq.trim(div_value);

			if(content_id == 'Quickslide')
				{
					if(arguments[1] == 'remove')
					  {
					  	  $Jq('#quick_mix_added_' + photo_id).css('display','none');
					  	  $Jq('#quick_mix_saving_' + photo_id).css('display','block');
						  removePhotosQuickMixCount(photo_id);
						  $Jq('#'+div_id).html(view_photo_quickslide_deleted);
					  }
					else
					  {
					  	  $Jq('#quick_mix_' + photo_id).css('display','none');
					  	  $Jq('#quick_mix_saving_' + photo_id).css('display','block');
						  updatePhotosQuickMixCount(photo_id);
						  $Jq('#'+div_id).html(view_photo_quickslide_added);
					  }
					div_value = $Jq('#'+div_id).html();
				}
			else if(content_id == 'Slidelist')
				{
					view_photo_more_path = slidelist_url;
					call_viewphoto_ajax = true;
				}
			else if(content_id == 'SharePhoto')
				{
					view_photo_more_path = share_url;
					call_viewphoto_ajax = true;
				}
			else if(content_id == 'Flag')
				{
					view_photo_more_path = load_flag_url;
					call_viewphoto_ajax = true;
				}
			else if(content_id == 'Favorites')
				{
					call_viewphoto_ajax = true;

					if(arguments[1] == 'remove')
						{
							$Jq('#added_favorite').css('display','none');
							$Jq('#favorite_saving').css('display','block');
							var favorite_pars = '&favorite=&photo_id='+photo_id;
							favorite_added = 1;
						}
					else
					{
						$Jq('#add_favorite').css('display','none');
						$Jq('#favorite_saving').css('display','block');
						var favorite_pars = '&favorite='+favorite_added+'&photo_id='+photo_id;
						favorite_added = 0;
					}

					view_photo_more_path = favorite_url+favorite_pars;
				}
			else if(content_id == 'Featured')
				{
					call_viewphoto_ajax = true;
					if(arguments[1] == 'remove')
						{
							$Jq('#added_featured').css('display','none');
							$Jq('#featured_saving').css('display','block');
							var featured_pars = '&featured=&photo_id='+photo_id;
							featured_added = 1;
						}
					else
					{
						var featured_pars = '&featured='+featured_added+'&photo_id='+photo_id;
						$Jq('#add_featured').css('display','none');
						$Jq('#featured_saving').css('display','block');
						featured_added = 0;
					}

					view_photo_more_path = featured_url+featured_pars;
				}

			result_div = div_id;
			if(div_value == '' || call_viewphoto_ajax)
				{
					hideViewPhotoMoreTabsDivs(div_id);
					showViewPhotoMoreTabsDivs(div_id);
					$Jq('#'+div_id).html(view_photo_scroll_loading);
					new jquery_ajax(view_photo_more_path, '', 'insertViewPhotoMoreContent');
				}
			else
				{
					hideViewPhotoMoreTabsDivs(div_id);
					showViewPhotoMoreTabsDivs(div_id);
				}

		}
	function insertViewPhotoMoreContent(data)
	{
		data = data
		if(data.indexOf('ERR~')>=1)
		{
			if(view_photo_content_id == 'Favorites')
			{
				$Jq('#favorite_saving').css('display','none');
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
			else if(view_photo_content_id == 'Featured')
			{
				$Jq('#featured_saving').css('display','none');
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
			memberBlockLoginConfirmation(msg,'<?php echo $viewphoto->memberviewPhotoUrl ?>');
			return false;
		}
		//Do the works for other things
		if(view_photo_content_id == 'Slidelist')
			{

			}
		else if(view_photo_content_id == 'SharePhoto')
			{

			}
		else if(view_photo_content_id == 'Flag')
			{

			}
		else if(view_photo_content_id == 'Favorites')
			{
				if(favorite_added)
				{
					$Jq('#favorite_saving').css('display','none');
					$Jq('#add_favorite').css('display','block');
				}
				else
				{
					$Jq('#favorite_saving').css('display','none');
					$Jq('#added_favorite').css('display','block');
				}

				/*if($Jq('#added_favorite').css('display') == 'none')
					{
						$Jq('#selFavoritesContent').removeClass('clsUserActionAdded');
						$Jq('#selFavoritesContent').addClass('clsUserActionDeleted');
					}
				else
					{
						$Jq('#selFavoritesContent').removeClass('clsUserActionDeleted');
						$Jq('#selFavoritesContent').addClass('clsUserActionAdded');
					}
				//scrollbar.recalculateLayout();
				scrollDiv();
				return false;*/

			}
		else if(view_photo_content_id == 'Featured')
			{

				if(featured_added)
				{
					$Jq('#featured_saving').css('display','none');
					$Jq('#add_featured').css('display','block');
				}
				else
				{
					$Jq('#featured_saving').css('display','none');
					$Jq('#added_featured').css('display','block');
				}

				/*$Jq('#add_featured').toggle();
				$Jq('#added_featured').toggle();
				$Jq('#'+result_div).html(data);
				if($Jq('#added_featured').css('display') == 'none')
					{
						$Jq('#selFeaturedContent').removeClass('clsUserActionAdded');
						$Jq('#selFeaturedContent').addClass('clsUserActionDeleted');
					}
				else
					{
						$Jq('#selFeaturedContent').removeClass('clsUserActionDeleted');
						$Jq('#selFeaturedContent').addClass('clsUserActionAdded');
					}
				//scrollbar.recalculateLayout();
				scrollDiv();
				return false;*/
			}

		//document.getElementById(result_div).innerHTML = data;
		$Jq('#'+result_div).html(data);
		//scrollbar.recalculateLayout();
		scrollDiv();
		//parent.scrollbarslide.recalculateLayout();
		//scrollbar.scrollTo('top');
		return false;
	}
	function hideViewPhotoMoreTabsDivs(current_div)
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
	function showViewPhotoMoreTabsDivs(current_div)
	{
		for(var i=0; i<more_tabs_div.length; i++)
			{
				if(more_tabs_div[i] == current_div)
					{
						//$(current_div).show();
						if($Jq("#"+current_div).css('display') == 'none')
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

//MORE CONTENT START HERE//
function movePhotoSetToLeft(buttonObj, pg)
{
	if(pg=='tag')
		var pars= 'pTagLeft=&pTagFetch=';
	if(pg=='user')
		var pars= 'pUserLeft=&pUserFetch=';
	if(buttonObj.className == disPrevButton)
		return false;
	photoSlider(pars, pg);
}

var morephoto_button_id = '';
function movePhotoSetToRight(buttonObj, pg)
{
	if(pg=='tag')
		var pars= 'pTagRight=&pTagFetch=';
	if(pg=='user')
		var pars= 'pUserRight=&pUserFetch=';
	if(buttonObj.className == disNextButton)
		return false;

	morephoto_button_id = 'photoNextButton_'+pg;
	$Jq('#'+morephoto_button_id).attr("disabled","disabled");
	photoSlider(pars, pg);
}

function photoSlider(pars, pg)
{
	$Jq('#relatedPhotoContent').html($Jq('#loaderPhotos').html());
	if(pg=='tag')
	{
		var pars = pars+'&ajax_page=1&photo_id=<?php echo $viewphoto->getFormField('photo_id'); ?>&photo_tags=<?php echo addslashes($viewphoto->getFormField('photo_tags')); ?>';
		new jquery_ajax(homeUrl, pars, 'refreshPhotoBlock');
	}
	if(pg=='user')
	{
		var pars = pars+'&ajax_page=1&photo_id=<?php echo $viewphoto->getFormField('photo_id'); ?>&user_id=<?php echo $viewphoto->getFormField('user_id'); ?>';
		new jquery_ajax(homeUrl, pars, 'refreshPhotoBlock');
	}
}

function refreshPhotoBlock(resp)
{
	$Jq('#'+morephoto_button_id).removeAttr("disabled");
	data=resp
	$Jq('#relatedPhotoContent').html(data);
	$Jq('#selNextPrev_top').html($Jq('#selNextPrev').html());
}
//MORE CONTENT END//
</script>
<script type="text/javascript">
function getCanvasImages()
{
	var img =  document.getElementById('photo_'+tag.photo.id);
	for(var i=0;i<tag.photo.contactAnnotations.length;i++)
	{
		var profileImg=document.getElementById('tag_canvas_img_'+tag.photo.contactAnnotations[i].id);
		var canvasEle=profileImg.innerHTML;
		canvasEle=canvasEle.toLowerCase();
	    var canvasTagName =canvasEle.indexOf('<canvas');
		if(canvasTagName!=-1)
		{
		    var ctx = document.getElementById('canvas_'+tag.photo.contactAnnotations[i].id).getContext('2d');
	    	var canvasRect=tag.photo.contactAnnotations[i].annotation.rect;
	    	var leftPos=parseInt(canvasRect.left);
	    	var topPos=parseInt(canvasRect.top);
	    	var canvasWidth=parseInt(canvasRect.width);
	    	var canvasHeight=parseInt(canvasRect.height);
	    	ctx.drawImage(img,leftPos,topPos,canvasWidth,canvasHeight,0,0,50,50);
		}
	}
}

var customizeEmbedOptions = function()
	{
		if(arguments[0] && arguments[0] == 'default')
			{
				$Jq('#image_code').val(embeded_code_default);
				$Jq('#embed_width').val('');
				$Jq('#embed_height').val('');
				$Jq("#customize_embed_size").hide();
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
		var embed_code_new = embeded_code_js;
		embed_code_new = embed_code_new.replace("{$width}", embed_width);
		embed_code_new = embed_code_new.replace("{$height}", embed_height);
		$Jq('#image_code').val(embed_code_new);
		$Jq('#embed_width').val('');
		$Jq('#embed_height').val('');
		$Jq("#customize_embed_size").hide();
		return false;
	}
var toggleEmbedCustomize =function(){
		$Jq('#embed_width').val('');
		$Jq('#embed_height').val('');
		$Jq('#embed_error_msg').html();
		$Jq('#embed_error_msg').hide();
		$Jq("#customize_embed_size").slideToggle('slow');
};
var showAddPhotoComment=function(){
$Jq('#cancel_comment').css('display', 'block');
$Jq('#add_comment').css('display', 'none');
$Jq('#comment').val('');
$Jq('#photo_comment_add_block').toggle();
if(document.getElementById('photo_comment_add_block').style.display!='none')
    $Jq('#comment').focus();
}
var showCancelPhotoComment=function(){
$Jq('#add_comment').css('display', 'block');
$Jq('#cancel_comment').css('display', 'none');
$Jq('#comment').val('');
$Jq('#photo_comment_add_block').toggle();
if(document.getElementById('photo_comment_add_block').style.display!='none')
    $Jq('#comment').focus();
}
</script>
<?php
     // goodle map section start here
	if ($viewphoto->isShowPageBlock('block_add_location') && $CFG['admin']['photos']['add_photo_location'])
	{
	    ?>
	    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
	    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=<?php echo $CFG['admin']['photos']['google_map_key'];?>" type="text/javascript"></script>
	    <script type="text/javascript">
			var map
		 	var address
		 	var marker
		 	var geocoder;
			//Initialize the google map api and also set defalt marker.
	     	function initialize()
			{
		  		//document.getElementById('results').innerHTML = '';
	      		if (GBrowserIsCompatible())
				{
	        		map = new GMap2(document.getElementById("map_canvas"));
	        		<?php
						if($viewphoto->getFormField('latitude') == 0 && $viewphoto->getFormField('longitude') == 0)
						{
					?>
		        			var center = new GLatLng(<?php echo $CFG['admin']['photos']['default_latitude'];?>,<?php echo $CFG['admin']['photos']['default_longitude'];?>);
		        	<?php
		        		}
		        		else
		        		{
		        	?>
							var center = new GLatLng(<?php echo $viewphoto->getFormField('latitude');?>,<?php echo $viewphoto->getFormField('longitude');?>);
					<?php
						}
					?>

		        	geocoder = new GClientGeocoder();
					map.setCenter(center, 13);
					map.setUIToDefault();
					<?php
						if($viewphoto->getFormField('address')!='' && $viewphoto->getFormField('latitude')!=0 && $viewphoto->getFormField('longitude')!=0)
						{
					?>
							$Jq('#selSeletedArea').html('<?php echo $viewphoto->getFormField('address');?>');
		        			setMarker(center);
		        	<?php
		        		}
		        		else
		        		{
					?>
	        				//setMarker(center);
				   <?php
						}
		        	?>
	      		}
	    	}
			//set marker using lat and lan.
			function setMarker(center)
			{
				marker = new GMarker(center, {draggable: false});
				GEvent.addListener(marker, "dragstart", function() {
					map.closeInfoWindow();
				});
				// add a drag listener to the map
				GEvent.addListener(marker, "dragend", function() {
					var point = marker.getPoint();
					map.panTo(point);
					var latlng ='('+point.lat()+','+point.lng()+')';
					geocoder.getLocations(latlng, showAddress);
				});
				map.addOverlay(marker);
			}
			// in change the marker place give the place address.
	    	function showAddress(response)
			{
		    	map.clearOverlays();
	      		if (!response || response.Status.code != 200)
				{
	        		alert("Status Code:" + response.Status.code);
	      		}
				else
				{
	        		place = response.Placemark[0];
	        		point = new GLatLng(place.Point.coordinates[1],
	                place.Point.coordinates[0]);
	                map.setCenter(point, 13);
	        		setMarker(point);
		        	marker.openInfoWindowHtml('<b>Address:</b>' + place.address + '<br>');
		        	$Jq('#selSeletedArea').css('display', 'block');
		        	$Jq('#selSeletedArea').html(place.address);
	      		}
	    	}
	    	function reInitialize(lat,long,adrs)
			{
				if (GBrowserIsCompatible())
				{
	        		map = new GMap2(document.getElementById("map_canvas"));

						if(lat == 0 && long == 0)
						{
		        			var center = new GLatLng(<?php echo $CFG['admin']['photos']['default_latitude'];?>,<?php echo $CFG['admin']['photos']['default_longitude'];?>);
		        		}
		        		else
		        		{
							var center = new GLatLng(lat,long);
						}


		        	geocoder = new GClientGeocoder();
					map.setCenter(center, 13);
					map.setUIToDefault();
						if(lat != 0 && lat != '' && long != 0 && long != '')
						{
							$Jq('#selSeletedArea').html(adrs);
							$Jq('#selLocationDiv').css('display', 'block');
							$Jq('#selLocationValue').html(adrs);

		        			setMarker(center);
						}
		        		else
		        		{
	        				$Jq('#selSeletedArea').html(adrs);
	        				$Jq('#selLocationDiv').css('display', 'block');
							$Jq('#selLocationValue').html(adrs);
						}

	      		}
	    	}
	    	/**
	    	 *
	    	 * @access public
	    	 * @return void
	    	 **/
	    	function removeLocation(){
					$Jq('#selSeletedArea').html('');
					$Jq('#selLocationValue').html('');
					$Jq('#selLocationDiv').css('display', 'none');

	    	}
		</script>
		<?php
	}
}
if ($viewphoto->isShowPageBlock('block_add_comments'))
{
	$viewphoto->replyCommentId=$viewphoto->getFormField('comment_id');
		$viewphoto->replyUrl=$CFG['site']['photo_url'].'viewPhoto.php?ajax_page=true&photo_id='.$viewphoto->getFormField('photo_id').'&vpkey='.$viewphoto->getFormField('vpkey').'&show='.$viewphoto->getFormField('show');
	?>
	<script language="javascript" type="text/javascript">
	<?php if($CFG['admin']['photos']['captcha']
				AND $CFG['admin']['photos']['captcha_method'] == 'recaptcha'
					AND $CFG['captcha']['public_key'] AND $CFG['captcha']['private_key'])
			{
	?>
	var captcha_recaptcha = true;
	<?php
			}
	?>
	</script>
	<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['photo_url'];?>js/light_comment.js"></script>
	<script language="javascript" type="text/javascript">
		var no_comment_error_msg = "<?php echo $LANG['common_noComment_errorMsg'];?>";
		var dontUse = 0;
		var replyUrl="<?php echo $viewphoto->replyUrl;?>";
		var owner="<?php echo $viewphoto->getFormField('user_id');;?>";
		var reply_comment_id="<?php echo $viewphoto->replyCommentId;?>";;
		var reply_user_id="<?php echo $CFG['user']['user_id'];?>";
	//	$('comment').focus();
	</script>
	<?php
}
setTemplateFolder('general/', $CFG['site']['is_module_page']);
$smartyObj->display('viewPhoto.tpl');
if($viewphoto->validate)
	{
?>
<script type="text/javascript">
   function closeDownload()
	{
		$Jq('#downloadFormat').css('display', 'none');
		hideAllBlocks();
	}
</script>
<?php
	}
$viewphoto->includeFooter();
?>