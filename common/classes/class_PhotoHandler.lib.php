<?php
/**
 * photoHandler
 *
 * @package Photo
 * @author shankar_044at09
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @access public
 */
class PhotoHandler extends MediaHandler
{
	/**
	 * photoHandler::__construct()
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		if(isMember())
		{
			$this->quickMixPhotoUrl = $this->CFG['site']['photo_url'].'members/getPhotoDetails.php?ajax_page=true&action=quickmix';
			$this->createAlbumUrl = $this->CFG['site']['photo_url'].'members/createAlbup.php';
		}
		else
		{
			$this->quickMixPhotoUrl = $this->CFG['site']['photo_url'].'getPhotoDetails.php?ajax_page=true&action=quickmix';
			$this->createAlbumUrl = $this->CFG['site']['photo_url'].'members/createAlbum.php';

		}
		$this->playQuickMixUrl = getUrl('flashshow', '?slideshow=ql', 'ql/', '', 'photo');
		$this->updatePhotosToSlideUrl = $this->CFG['site']['photo_url'].'updatePhotosToSlide.php';
		//Quick Mixed photos
		$this->quick_mix_photo_id_arr = array();
		if(isset($_SESSION['user']['photo_quick_mixs']))
			$this->quick_mix_photo_id_arr = explode(',', $_SESSION['user']['photo_quick_mixs']);


		if($this->CFG['admin']['photos']['movie_maker'])
		{
			//Movie Queue photos
			$this->movie_queue_photo_id_arr = array();
			if(isset($_SESSION['user']['movie_photo_queue']))
				$this->movie_queue_photo_id_arr = explode(',', $_SESSION['user']['movie_photo_queue']);
		}

	}


	/**
	 * PhotoHandler::getPhotoName()
	 *
	 * @param Integer $text
	 * @return void
	 */
	public function getPhotoName($text)
	{
		return getPhotoName($text);
	}

	/**
	 * PhotoHandler::getPhotoImageName()
	 *
	 * @param Integer $text
	 * @return void
	 */
	public function getPhotoImageName($text, $thumb_name='')
	{
		return getPhotoImageName($text, $thumb_name);
	}

	/**
	 * PhotoHandler::populateDefaultPhotoDetails()
	 *
	 * @param Integer $text
	 * @return void
	 */
	public function populateDefaultPhotoDetails()
	{
		$sql = 'SELECT album_id,photo_category_id,photo_sub_category_id,photo_tags, photo_access_type,allow_comments,'.
	  			' allow_ratings,allow_embed,allow_tags,relation_id FROM '.$this->CFG['db']['tbl']['photo_user_default_setting'].
	  			' WHERE user_id='.$this->dbObj->Param('user_id');
	  	$stmt = $this->dbObj->Prepare($sql);
	  	$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
	  	if(!$rs)
	  		trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
		{
			$this->fields_arr['photo_tags'] = $row['photo_tags'];
			$this->fields_arr['photo_category_id'] = $row['photo_category_id'];
			$this->fields_arr['photo_sub_category_id'] = $row['photo_sub_category_id'];
			$this->fields_arr['allow_comments'] = $row['allow_comments'];
			$this->fields_arr['allow_ratings'] = $row['allow_ratings'];
			$this->fields_arr['photo_access_type'] = $row['photo_access_type'];
			$this->fields_arr['album_id'] = $row['album_id'];
			$this->fields_arr['allow_embed'] = $row['allow_embed'];
			$this->fields_arr['allow_tags'] = $row['allow_tags'];
			if($row['relation_id'])
				$this->fields_arr['relation_id'] = explode(',',$row['relation_id']);
		}
	}
	/**
	 * PhotoHandler::getPhotoCategoryType()
	 *
	 * @param Integer $text
	 * @return void
	 */
	public function getPhotoCategoryType()
	{
		$sql = 'SELECT photo_category_type FROM '.$this->CFG['db']['tbl']['photo_category'].
	  			' WHERE photo_category_id='.$this->dbObj->Param('photo_category_id');
	  	$stmt = $this->dbObj->Prepare($sql);
	  	$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_category_id']));
	  	if(!$rs)
	  		trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
		{
			$this->fields_arr['photo_category_type'] = $row['photo_category_type'];
			return $row['photo_category_type'];
		}
	}

	/**
	 * PhotoHandler::selectFeaturedPhoto()
	 *
	 * @param string $condition
	 * @param array $value
	 * @param string $returnType
	 * @return mixed
	 */
	public function selectFeaturedPhoto($condition, $value, $returnType='')
	{
		$sql = 'SELECT photo_featured_id FROM '.$this->CFG['db']['tbl']['photo_featured'].
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
     * PhotoHandler::deleteFromFeatured()
     *
     * @param mixed $displayMsg
     * @param mixed $photo_id
     * @return
     */
    public function deleteFromFeatured($displayMsg, $photo_id)
	{
		//Start delete photo featured Photo activity..
		$sql = 'SELECT pf.photo_featured_id, pf.user_id as featured_user_id, p.user_id '.
				' FROM '.$this->CFG['db']['tbl']['photo_featured'].' as pf, '.
				$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['photo'].' as p '.
				' WHERE u.user_id = pf.user_id AND pf.photo_id = p.photo_id AND pf.user_id = '.
				$this->dbObj->Param('user_id').' AND pf.photo_id = '.$this->dbObj->Param('photo_id');

		$fields_value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['photo_id']);

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $fields_value_arr);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		if(!empty($row))
			{
				$activity_arr = $row;
				$activity_arr['action_key']	= 'delete_photo_featured';
				$photoActivityObj = new PhotoActivityHandler();
				$photoActivityObj->addActivity($activity_arr);
			}
		//end
		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_featured'].
				' WHERE user_id='.$this->dbObj->Param('user_id').
				' and photo_id='.$this->dbObj->Param('photo_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id'], $photo_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($this->dbObj->Affected_Rows())
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET total_featured = total_featured-1'.
						' WHERE photo_id='.$this->dbObj->Param('photo_id');
				$stmt = $this->dbObj->Prepare($sql);

				$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_id']));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($displayMsg)
					echo $this->LANG['viewphoto_featured_deleted_successfully'];
			}
	}

	/**
	 * PhotoHandler::getPhotoCategoryType()
	 *
	 * @param Integer $text
	 * @return void
	 */
	public function getPhotoCategoryName()
	{
		$sql = 'SELECT photo_category_name FROM '.$this->CFG['db']['tbl']['photo_category'].
	  			' WHERE photo_category_id='.$this->dbObj->Param('photo_category_id');
	  	$stmt = $this->dbObj->Prepare($sql);
	  	$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_category_id']));
	  	if(!$rs)
	  		trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
		{
			return $row['photo_category_name'];
		}
	}

	/**
	 * PhotoHandler::populatePhotoAlbum()
	 *
	 * @param string $type
	 * @param string $err_tip
	 * @return boolean
	 */
	public function populatePhotoAlbum($type='Public', $user_id='')
	{
		$sql = 'SELECT photo_album_id, photo_album_title FROM '.
				$this->CFG['db']['tbl']['photo_album'].
				' WHERE  album_access_type='.$this->dbObj->Param('album_access_type');
		if($user_id!='')
		{
			$sql= $sql.' AND user_id='.$this->dbObj->Param('user_id');
			$value_arr= array($type,$user_id);
		}
		else
		{
			$value_arr= array($type);
		}

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, $value_arr);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if(!$rs->PO_RecordCount())
			return;

		$names = array('photo_album_title');
		$value = 'photo_album_id';
		$highlight_value = $this->fields_arr['album_id'];

		$inc = 0;
		while($row = $rs->FetchRow())
		{
			$out = '';
			foreach($names as $name)
				$out .= $row[$name];
			$selected = $highlight_value == $row[$value]?' selected':'';
			?><option value="<?php echo $row[$value];?>" <?php echo $selected;?>><?php echo $out;?></option><?php
			$inc++;
		}
	}

	/**
	 * PhotoHandler::populatePhotoCatagory()
	 *
	 * @param string $type
	 * @param string $err_tip
	 * @return boolean
	 */
	public function populatePhotoCatagory($type = 'General', $err_tip='')
	{
		$sql = 'SELECT photo_category_id, photo_category_name FROM '.
				$this->CFG['db']['tbl']['photo_category'].
				' WHERE parent_category_id=0'.
				' AND photo_category_status=\'Yes\''.
				' AND photo_category_type='.$this->dbObj->Param('photo_category_type').
				' AND allow_post=\'Yes\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($type));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if(!$rs->PO_RecordCount())
			return;

		$names = array('photo_category_name');
		$value = 'photo_category_id';
		$highlight_value = $this->fields_arr['photo_category_id'];

		$inc = 0;
		while($row = $rs->FetchRow())
		{
			$out = '';
			foreach($names as $name)
				$out .= $row[$name];
			$selected = $highlight_value == $row[$value]?' selected':'';
			?><option value="<?php echo $row[$value];?>" <?php echo $selected;?>><?php echo $out;?></option><?php
			$inc++;
		}
	}

	/**
	 * PhotoHandler::populatePhotoSubCatagory()
	 *
	 * @param integer $cid
	 * @return void
	 */
	public function populatePhotoSubCatagory($cid)
	{
		$sql = 'SELECT photo_category_id, photo_category_name FROM '.
				$this->CFG['db']['tbl']['photo_category'].
				' WHERE parent_category_id='.$this->dbObj->Param('parent_category_id').
				' AND parent_category_id!=\'\' AND photo_category_status=\'Yes\' AND allow_post=\'Yes\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($cid));
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$names = array('photo_category_name');
		$value = 'photo_category_id';
		$highlight_value = $this->fields_arr['photo_sub_category_id'];
		?><select class="clsSelectMedium" name="photo_sub_category_id" id="photo_sub_category_id" tabindex="1050">
			<option value=""><?php echo $this->LANG['common_select_option'];?></option>
		<?php

		while($row = $rs->FetchRow())
		{
			$out = '';
			$selected = $highlight_value == $row[$value]?' selected':'';
			foreach($names as $name)
				$out .= $row[$name].' ';
			?>
			<option value="<?php echo $row[$value];?>"<?php if($this->fields_arr['photo_sub_category_id']==$row[$value]){ echo " selected";}?>><?php echo $out;?></option>
			<?php
		}
		?></select><?php
	}
	/**
	 * PhotoHandler::populatePhotoJsVars()
	 *
	 * @return void
	 */
	public function populatePhotoJsVars()
	{
		echo '<script type="text/javascript">';
		echo 'var play_quickMix_url = "'.$this->playQuickMixUrl.'";
			  var create_album_url = "'.$this->createAlbumUrl.'";
			  var qucikmix_added_already = "'.$this->LANG['common_quickmix_added_already'].'";
			  var update_photos_to_Slide_url = "'.$this->updatePhotosToSlideUrl.'";
			  var photos_file_url = "files/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/";
			  var quickMixPhoto_url = "'.$this->quickMixPhotoUrl.'";';
	    	//echo '//Photo Quick Mix JS ARRAY';
			foreach($this->quick_mix_photo_id_arr as $quick_mix)
				{
					echo 'quick_mix_photo_id_arr.push('.$quick_mix.');';
				}
			 if($this->CFG['admin']['photos']['movie_maker'])
			   {
					foreach($this->movie_queue_photo_id_arr as $queue_photo)
					{
						echo 'movie_queue_photo_id_arr.push('.$queue_photo.');';
					}
			   }
		echo '</script>';
	}
	 /**
	 * PhotoHandler::getTagsForphotoList()
	 * Display tags
	 * @param mixed $photo_tags,$taglimit
	 * @param tag_serach_word is used for highlight the search_tag_word.
	 * @return
	 */
	public function getPhotoTagsLinks($photo_tags,$taglimit,$tag_serach_word='')
	{
		// change the function for display the tags with some more...
		global $smartyObj;
		$tags_arr = explode(' ', $photo_tags);
		//Condition commented to display all tags in photo list page(display values controlled through css)
		/*if(count($tags_arr)>$taglimit)
		{
			$photo_tag_size=$taglimit;
		}
		else
		{
			$photo_tag_size=count($tags_arr);
		}*/
		$photo_tag_size=count($tags_arr);
		for($i=0;$i<$photo_tag_size;$i++)
		{
			$getTagsLink_arr[$i]['title_tag_name'] = $getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = $tags_arr[$i];
			if(!empty($tag_serach_word))
				$getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'] = highlightWords($getTagsLink_arr[$i]['wordWrap_mb_ManualWithSpace_tag_name'], $tag_serach_word);
		    $getTagsLink_arr[$i]['tag_url'] = getUrl('photolist', '?pg=photonew&tags='.$tags_arr[$i], 'photonew/?tags='.$tags_arr[$i], '', 'photo');
			if($i%2==0)
			{
				$getTagsLink_arr[$i]['class']='clsTagsDefalult';
			}
			else
			{
				$getTagsLink_arr[$i]['class']='clsTagsAlternate';
			}

		}
		$smartyObj->assign('getTagsLink_arr', $getTagsLink_arr);
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('populateTagsLinks.tpl');
	}
	/**
	 * PhotoHandler::getEmailAddressOfRelation()
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
	/**
	 * PhotoHandler::populateMemberDetail()
	 * // IF THE FUNCTION RUN WE NEED TO INCLUDE class_RayzzHandler.lib.php FILE//
	 * @return
	 */
	public function populateMemberDetail($side_bar_option)
	{
		global $smartyObj;
		if($side_bar_option == 'photo')
			$allowed_pages_array = array('viewPhoto.php', 'viewSlidelist.php');
		elseif($side_bar_option == 'slidelist')
			$allowed_pages_array = array('viewPhoto.php', 'viewSlidelist.php', 'PhotoUploadPopUp.php');
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

		$populateMemberDetail_arr = array();
		$icondetail = getMemberAvatarDetails($this->CFG['user']['user_id']);
		$populateMemberDetail_arr['s_attribute'] = isset($icondetail['icon']['s_attribute'])?$icondetail['icon']['s_attribute']:'';
		$populateMemberDetail_arr['memberProfileUrl'] = getMemberProfileUrl($this->CFG['user']['user_id'], $this->CFG['user']['user_name']);
		$populateMemberDetail_arr['name'] = $this->CFG['user']['user_name'];
		$populateMemberDetail_arr['icon'] = $icondetail;
		$populateMemberDetail_arr['photosTaggedByMeUrl'] = getUrl('peopleonphoto','?tagged_by='.$this->CFG['user']['user_name'].'&block=me', '?tagged_by='.$this->CFG['user']['user_name'].'&block=me','','photo');
		$populateMemberDetail_arr['taggedPhotosOfMeUrl'] = getUrl('peopleonphoto','?tagged_of='.$this->CFG['user']['user_name'].'&block=of', '?tagged_of='.$this->CFG['user']['user_name'].'&block=of','','photo');
		$populateMemberDetail_arr['allPhotoTagsUrl'] = getUrl('peopleonphoto','?tag=all&block=all', '?tag=all&block=all','','photo');
		//TOTAL photo //
		$sql = 'SELECT COUNT( m.photo_id ) AS total_photo '.
			'FROM '.$this->CFG['db']['tbl']['photo'].' AS m '.
			'WHERE photo_status=\'Ok\' AND user_id = '.$this->dbObj->Param('user_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$result_set = $rs->FetchRow();
		$populateMemberDetail_arr['total_photo'] = $result_set['total_photo'];
		$smartyObj->assign('populateMemberDetail_arr', $populateMemberDetail_arr);
		$smartyObj->assign('opt', $side_bar_option);
		$smartyObj->assign('flag', $flag);
		$smartyObj->assign('cid', isset($_GET['cid'])?$_GET['cid']:'0');
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('populateMemberBlock.tpl');
	}
	/**
	 * PhotoHandler::getPhotoNavClass()
	 *
	 * @param mixed $identifier
	 * @return boolean
	 */
	public function getPhotoNavClass($identifier)
	{
		$identifier = strtolower($identifier);
		return isset($this->_navigationArr[$identifier])?$this->_navigationArr[$identifier]:$this->_clsInActiveLink;
	}
	/**
	  * photoHandler::populateGenres()
	  * //WE USE THIS FUNCTION INDEX, photo LIST, PLAYLIST pages
	  * @return
	  */
	 public function populateGenres()
	 {
		global $smartyObj;
		$populateGenres_arr = array();
		$populateGenres_arr['record_count'] = false;

		$allowed_pages_array = array('viewPhoto.php', 'viewSlidelist.php');
		if(displayBlock($allowed_pages_array))
			return;

		//GENRES LIST priority vise or photo_category_name//
		if($this->CFG['admin']['photos']['photo_category_list_priority'])
			$short_by = 'priority';
		else
			$short_by = 'photo_category_name';

		//$addtional_condition = 'photo_category_type!=\'Porn\' AND ';
		$addtional_condition = '';

		$sql = 'SELECT photo_category_id, photo_category_name FROM '.$this->CFG['db']['tbl']['photo_category'].'  '.
				'WHERE '.$addtional_condition.' parent_category_id = \'0\' AND photo_category_status = \'Yes\' ORDER BY '.$short_by.' ASC LIMIT 0, '.$this->CFG['admin']['photos']['sidebar_genres_num_record'];

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$populateGenres_arr['row'] = array();
		$inc = 0;
		While($genresDetail = $rs->FetchRow())
		{
			$populateGenres_arr['record_count'] = true;
			$populateGenres_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_photo_category_name'] = $genresDetail['photo_category_name'];
			$populateGenres_arr['row'][$inc]['record'] = $genresDetail;
			$populateGenres_arr['row'][$inc]['photoCount'] = $this->photoCount($genresDetail['photo_category_id']);
			$populateGenres_arr['row'][$inc]['populateSubGenres'] = $this->populateSubGenres($genresDetail['photo_category_id']);
			$populateGenres_arr['row'][$inc]['photolist_url'] = getUrl('photolist', '?pg=photonew&cid='.$genresDetail['photo_category_id'], 'photonew/?cid='.$genresDetail['photo_category_id'], '', 'photo');
			$inc++;
		}
		$smartyObj->assign('moregenres_url', getUrl('photocategory', '', '', '', 'photo'));
		$smartyObj->assign('populateGenres_arr', $populateGenres_arr);
		$smartyObj->assign('cid', isset($_GET['cid'])?$_GET['cid']:'0');
		$smartyObj->assign('sid', isset($_GET['sid'])?$_GET['sid']:'0');
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('populateGenresBlock.tpl');
	 }
	 /**
	  * photoHandler::populateGenres()
	  * //WE USE THIS FUNCTION INDEX, photo LIST, PLAYLIST pages
	  * @return
	  */
	 public function populateFeaturedPhoto()
	 {
		global $smartyObj;
		$populate_featured_photo_arr = array();
		$populate_featured_photo_arr['record_count'] = false;

		$allowed_pages_array = array('viewPhoto.php');
		if(displayBlock($allowed_pages_array))
			return;

		//GENRES LIST priority vise or photo_category_name//
		if($this->CFG['admin']['photos']['photo_index_featured_list'])
			$short_by = 'photo_id';
		else
			$short_by = 'photo_title';

		$addtional_condition = 'featured=\'Yes\' AND';

		$sql = 'SELECT photo_id, photo_title,photo_caption,t_width,t_height,photo_server_url,photo_ext FROM '.$this->CFG['db']['tbl']['photo'].'  '.
				'WHERE '.$addtional_condition.' photo_access_type = \'Public\' AND photo_status = \'Ok\' ORDER BY '.$short_by.' ASC LIMIT 0, '.$this->CFG['admin']['photos']['photo_index_featured_num_record'];

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$populate_featured_photo_arr['row'] = array();
		$inc = 0;
		While($populate_featured_photoDetail = $rs->FetchRow())
		{
			$populate_featured_photo_arr['record_count'] = true;
			$populate_featured_photo_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_photo_title'] = $populate_featured_photoDetail['photo_title'];
			$populate_featured_photo_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_photo_caption'] = $populate_featured_photoDetail['photo_caption'];
			$populate_featured_photo_arr['row'][$inc]['record'] = $populate_featured_photoDetail;
			$populate_featured_photo_arr['row'][$inc]['small_img_url'] = $this->CFG['site']['url'].$populate_featured_photoDetail;

			//$populate_featured_photo_arr['row'][$inc]['photolist_url'] = getUrl('photolist', '?pg=photonew&cid='.$populate_featured_photoDetail['photo_category_id'], 'photonew/?cid='.$populate_featured_photoDetail['photo_category_id'], '', 'photo');
			$inc++;
		}
		//echo '<pre>'; print_r($populate_featured_photo_arr); echo '</pre>';
		$smartyObj->assign('populate_featured_photo_arr', $populate_featured_photo_arr);
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('populateFeaturedPhotoBlock.tpl');
	 }
	 /**
	  * photoHandler::photoCount()
	  *
	  * @param integer $category
	  * @return $total
	  */
	public function photoCount($category=0)
	{
		if($category)
			$condition = 'AND ( photo_category_id = '.$category.' OR photo_sub_category_id = '.$category.')';

		$sql = 'SELECT count(photo_id) as total FROM '.$this->CFG['db']['tbl']['photo'].
				' WHERE photo_status = \'Ok\' AND ( user_id = ' . $this->CFG['user']['user_id']. ' OR photo_access_type = \'Public\' ) '.$condition;

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		return $row['total'];
	}
	/**
	  * photoHandler::populateSubGenres()
	  * //WE USE THIS FUNCTION INDEX, photo LIST, PLAYLIST pages
	  * param $category_id
	  * @return
	  */
	 public function populateSubGenres($category_id)
	 {
		$populateSubGenres = array();
		$populateSubGenres['record_count'] = false;
		//SUBGENRES LIST priority vise or photo_category_name//
		if($this->CFG['admin']['photos']['photo_category_list_priority'])
			$short_by = 'priority';
		else
			$short_by = 'photo_category_name';

		$sql = 'SELECT photo_category_id, photo_category_name FROM '.$this->CFG['db']['tbl']['photo_category'].'  '.
				'WHERE parent_category_id = \''.$category_id.'\' AND photo_category_status = \'Yes\' ORDER BY '.$short_by.' ASC LIMIT 0, '.$this->CFG['admin']['photos']['sidebar_genres_num_record'];

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$populateSubGenres['row'] = array();
		$inc = 0;
		While($genresDetail = $rs->FetchRow())
			{
				$populateSubGenres['record_count'] = true;
				$populateSubGenres['row'][$inc]['wordWrap_mb_ManualWithSpace_photo_category_name'] = $genresDetail['photo_category_name'];
				$populateSubGenres['row'][$inc]['record'] = $genresDetail;
				$populateSubGenres['row'][$inc]['photoCount'] = $this->photoCount($genresDetail['photo_category_id']);
				$populateSubGenres['row'][$inc]['photolist_url'] = getUrl('photolist', '?pg=photonew&cid='.$category_id.'&sid='.$genresDetail['photo_category_id'], 'photonew/?cid='.$category_id.'&sid='.$genresDetail['photo_category_id'], '', 'photo');
				$inc++;
			}
		return $populateSubGenres;
	 }
	 /**
	 * Tag::populateTags()
	 *
	 * @return
	 **/
	public function populateSidebarClouds($module, $tags_table,$limit = 20,$returnValue = false)
	{
		global $smartyObj;
		$return = array();
		$return['resultFound']=false;
		if($module=='playlist')
		{
			$allowed_pages_array = array('listenphoto.php', 'viewPlaylist.php', 'photoList.php', 'photoUploadPopUp.php', 'myDashboard.php');
			if(displayBlock($allowed_pages_array))
				return;
			if($this->CFG['admin']['tagcloud_based_search_count'])
			{
				$sql = 'SELECT tag_name, search_count FROM '.$this->CFG['db']['tbl'][$tags_table].
						' WHERE search_count>0 ORDER BY search_count DESC, result_count DESC, tag_name ASC'.
						' LIMIT 0, '.$limit;
			}
			else
			{
				$sql = 'SELECT tag_name, result_count AS search_count FROM'.
						' '.$this->CFG['db']['tbl'][$tags_table].
						' WHERE result_count>0 ORDER BY result_count DESC, tag_name ASC'.
						' LIMIT 0, '.$limit;
			}

			$searchUrl = getUrl('photoplaylist', '?pg=slidelistnew&tags=%s', 'slidelistnew/?tags=%s', '', 'photo');
			$moreclouds_url = getUrl('tagsplaylist', '', '', '', 'photo');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if ($rs->PO_RecordCount()>0)
			{
				$return['resultFound']=true;
				$classes = array('clsPhotoTagStyleGrey', 'clsPhotoTagStyleGreen');
				$tagClassArray = array();
				while($row = $rs->FetchRow())
				{
						$tagArray[$row['tag_name']] = $row['search_count'];
						$class = $classes[rand(0, count($classes))%count($classes)];
						$tagClassArray[$row['tag_name']] = $class;
				}
				$tagArray = $this->setPhotoFontSizeInsteadOfSearchCountSidebar($tagArray);
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
					//$return['item'][$inc]['wordWrap_mb_ManualWithSpace_tag']= wordWrap_mb_ManualWithSpace($tag, $this->CFG['admin']['photos']['sidebar_clouds_name_length'], $this->CFG['admin']['photos']['sidebar_clouds_name_total_length']);
					$return['item'][$inc]['name']=$tag;
					$inc++;
				}
			}
		}
		else
		{
			$allowed_pages_array = array('viewPhoto.php', 'viewSlidelist.php');
			if(displayBlock($allowed_pages_array))
				return;
			if($this->CFG['admin']['tagcloud_based_search_count'])
			{
				$sql = 'SELECT tag_name, search_count FROM '.$this->CFG['db']['tbl'][$tags_table].
						' WHERE search_count>0 ORDER BY search_count DESC, result_count DESC, tag_name DESC'.
						' LIMIT 0, '.$limit;
			}
			else
			{
				$sql = 'SELECT tag_name, result_count AS search_count FROM'.
						' '.$this->CFG['db']['tbl'][$tags_table].
						' WHERE result_count>0 ORDER BY result_count DESC, tag_name DESC'.
						' LIMIT 0, '.$limit;
			}

			$searchUrl = getUrl('photolist', '?pg=photonew&tags=%s', 'photonew/?tags=%s', '', 'photo');
			$moreclouds_url = getUrl('tags', '?pg=photo', 'photo/', '', 'photo');

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if ($rs->PO_RecordCount()>0)
			{
				$return['resultFound']=true;
				$classes = array('clsPhotoTagStyleGrey', 'clsPhotoTagStyleGreen');
				$tagClassArray = array();
				while($row = $rs->FetchRow())
				{
						$tagArray[$row['tag_name']] = $row['search_count'];
						$class = $classes[rand(0, count($classes))%count($classes)];
						$tagClassArray[$row['tag_name']] = $class;
				}
				$tagArray = $this->setPhotoFontSizeInsteadOfSearchCountSidebar($tagArray);
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
					//$return['item'][$inc]['wordWrap_mb_ManualWithSpace_tag']= wordWrap_mb_ManualWithSpace($tag, $this->CFG['admin']['photos']['sidebar_clouds_name_length'], $this->CFG['admin']['photos']['sidebar_clouds_name_total_length']);
					$return['item'][$inc]['name']=$tag;
					$inc++;
				}
			}
		}
		$smartyObj->assign('moreclouds_url', $moreclouds_url);
		$smartyObj->assign('opt', $module);
		$smartyObj->assign('populateCloudsBlock', $return);
		if (!$returnValue) {
			setTemplateFolder('general/', 'photo');
			$smartyObj->display('populateCloudsBlock.tpl');
		}

	}
	 /**
	 * photoHandler::setPhotoFontSizeInsteadOfSearchCountSidebar()
	 *
	 * @return
	 **/
	public function setPhotoFontSizeInsteadOfSearchCountSidebar($tag_array=array())
	{
		return $this->setFontSizeInsteadOfSearchCountSidebar($tag_array);
	}
	/**
	 * photoHandler::populatePhotoRatingImages()
	 * // GET Populate Rating images for Photo List \\
	 * @param mixed
	 * @return
	 */
	public function populatePhotoRatingImages($rating = 0,$imagePrefix='',$condition='',$url='')
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
		$populateRatingImages_arr['bulet_star'] = $this->CFG['site']['photo_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-photoratingover.gif';
		$populateRatingImages_arr['bulet_star_empty'] = $this->CFG['site']['photo_url'].'design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/icon-photorating.gif';
		$smartyObj->assign('populateRatingImages_arr', $populateRatingImages_arr);
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('populatePhotoRatingImages.tpl');
	}
	/**
	 * PhotoHandler::myPhotoListDelete()
	 *
	 * @param array $photo_id_arr
	 * @param mixed $user_id
	 * @return
	 */
	public function myPhotoListDelete($photo_id_arr = array(), $user_id)
    {
		$photo_id	= implode(',',$photo_id_arr);
		$sqlstatus= 'SELECT  photo_status FROM '.$this->CFG['db']['tbl']['photo'].' WHERE '.
					' photo_status = \'Locked\' AND photo_id= '.$this->dbObj->Param('photo_id');
		$stmtstatus  = $this->dbObj->Prepare($sqlstatus);
		$rsstatus    = $this->dbObj->Execute($stmtstatus, array($photo_id));
		if (!$rsstatus)
			trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($rsstatus->PO_RecordCount()>0)
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET photo_status=\'Deleted\''.
					' WHERE photo_id IN('.$photo_id.')';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($affected_rows = $this->dbObj->Affected_Rows())
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
						' total_photos=total_photos-'.$affected_rows.
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				if (!$rs)
				   trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		}
		else
		{
			//$this->deletePhotoPlaylistTag($photo_id);
			$this->deletePhotoTag($photo_id);
			$sql        = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET photo_status=\'Deleted\'' . ' WHERE photo_id IN(' . $photo_id . ')' ;
			$stmt     = $this->dbObj->Prepare($sql);
			$rs       = $this->dbObj->Execute($stmt);
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
			if($affected_rows = $this->dbObj->Affected_Rows())
			{

				$sql= 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
					' total_photos=total_photos-' . $affected_rows . ' WHERE user_id=' . $this->dbObj->Param('user_id').' AND total_photos>0';
				$stmt   = $this->dbObj->Prepare($sql);
				$rs     = $this->dbObj->Execute($stmt, array($user_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
				$tablename_arr = array('photo_comments', 'photo_favorite', 'photo_viewed', 'photo_rating');
				for($i=0;$i<sizeof($tablename_arr);$i++)
				{
					$sql  = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].
							 ' WHERE photo_id IN(' . $photo_id . ')';
					$stmt = $this->dbObj->Prepare($sql);
					$rs   = $this->dbObj->Execute($stmt);
					if (!$rs)
						trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
				}
				$sql = 'DELETE FROM ' . $this->CFG['db']['tbl']['flagged_contents'] . ' WHERE content_type=\'photo\' AND content_id IN(' . $photo_id . ')';
				$stmt   = $this->dbObj->Prepare($sql);
				$rs     = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
				$sql = 'DELETE FROM ' . $this->CFG['db']['tbl']['photo_viewed'] . ' WHERE  photo_id IN(' . $photo_id . ')'.'AND user_id=' . $this->dbObj->Param('user_id');
				$stmt   = $this->dbObj->Prepare($sql);
				$rs     = $this->dbObj->Execute($stmt,array($user_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);


				//delete photo play list related datas.
				$total_photo = count($photo_id_arr);
				for($p=0;$p<$total_photo;$p++)
				{
					$sqlplay= 'SELECT  photo_playlist_id FROM '.$this->CFG['db']['tbl']['photo_in_playlist'].' WHERE '.
							' photo_id= '.$this->dbObj->Param('photo_id').' GROUP BY photo_playlist_id ';
					$stmtplay   = $this->dbObj->Prepare($sqlplay);
					$rsplay     = $this->dbObj->Execute($stmtplay, array($photo_id_arr[$p]));
					if (!$rsplay)
						trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
					if($rsplay->PO_RecordCount()>0)
					{
						while($rowplay = $rsplay->FetchRow())
						{
							$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_in_playlist'].' WHERE  photo_id = '.$this->dbObj->Param('photo_id').
									' AND photo_playlist_id = '.$this->dbObj->Param('photo_playlist_id');
							$stmt   = $this->dbObj->Prepare($sql);
							$rs     = $this->dbObj->Execute($stmt,array($photo_id_arr[$p],$rowplay['photo_playlist_id']));
							if (!$rs)
								trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);

							$sql= 'UPDATE '.$this->CFG['db']['tbl']['photo_playlist'].' SET'.
									' total_photos=total_photos - 1 WHERE photo_playlist_id IN ('.$rowplay['photo_playlist_id'].') AND total_photos>0';
							$stmt   = $this->dbObj->Prepare($sql);
							$rs     = $this->dbObj->Execute($stmt);
							if (!$rs)
								trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
						}
					}
				}

				//activity tables.
				$action_key = array('photo_uploaded', 'photo_comment', 'photo_rated', 'photo_favorite', 'photo_featured', 'photo_share');
				for($inc=0;$inc<count($action_key);$inc++)
				{
					//$condition = ' SUBSTRING(action_value, 1, 1 ) IN ('.substr($this->deletedPhotoIds,0,-1).') AND action_key = \''.$action_key[$inc].'\'';
					//$condition = '  content_id IN ('.$photo_id.') AND action_key = \''.$action_key[$inc].'\'';
					$condition = '  SUBSTRING_INDEX(action_value, \'~\', 1 ) IN ('.$photo_id.') AND action_key = \''.$action_key[$inc].'\'';
					$sql='SELECT parent_id FROM '.$this->CFG['db']['tbl']['photo_activity'].' WHERE '.$condition;
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
					$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_activity'].' WHERE '.$condition;
					$stmt = $this->dbObj->Prepare($sql);
					$rs   = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);
					$condition_act = '  parent_id IN ('.$parent_id.') ';
					$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['activity'].' WHERE '.$condition_act;
					$stmt = $this->dbObj->Prepare($sql);
					$rs   = $this->dbObj->Execute($stmt);
				    if (!$rs)
					    trigger_db_error($this->dbObj);
				}

				// **********End************
			}
		}
    	return true;
	}
	/**
	 * photoHandler::deletePhotoPlaylistTag()
	 *
	 * @param mixed $photo_playlist_id
	 * @return
	 */
	public function deletePhotoPlaylistTag($photo_playlist_id)
	{
		// DELETE TAGS
		$sql='SELECT playlist_tags FROM '.$this->CFG['db']['tbl']['photo_playlist'].
			 ' WHERE photo_playlist_id IN('.$photo_playlist_id.')';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		while($tag_row = $rs->FetchRow())
    	{
    		$tag=explode(' ',$tag_row['playlist_tags']);
    		for($i=0;$i<count($tag);$i++)
			{
				 $sql='SELECT photo_playlist_id FROM '.$this->CFG['db']['tbl']['photo_playlist'].
				 	   ' WHERE concat( \' \', playlist_tags, \' \' ) LIKE "% '.$tag[$i].' %" AND photo_playlist_id NOT IN('.$photo_playlist_id.')';

				 $stmt = $this->dbObj->Prepare($sql);
			     $rs_tag = $this->dbObj->Execute($stmt);
				 if (!$rs_tag)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				 if(!$row = $rs_tag->FetchRow())
				 {
				 	$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_playlist_tags'].
							' WHERE tag_name=\''.$tag[$i].'\'';
					$stmt = $this->dbObj->Prepare($sql);
					$rs_delete = $this->dbObj->Execute($stmt);
					if (!$rs_delete)
						trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				 }
			 }
		}
		// DELETE TAG END
	}
	/**
	 * photoHandler::deletePhotoTag()
	 *
	 * @param mixed $photo_id
	 * @acces public
	 */
	public function deletePhotoTag($photo_id)
	{
		// DELETE TAGS
		$sql='SELECT photo_tags FROM '.$this->CFG['db']['tbl']['photo'].' WHERE photo_id IN('.$photo_id.')';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		while($tag_row = $rs->FetchRow())
		{
    		$tag=explode(' ',$tag_row['photo_tags']);
    		for($i=0;$i<count($tag);$i++)
			{
				 $sql='SELECT photo_id FROM '.$this->CFG['db']['tbl']['photo'].
						 	  ' WHERE concat( \' \', photo_tags, \' \' ) LIKE "% '.$tag[$i].' %" AND photo_id NOT IN('.$photo_id.')'.' AND photo_status!=\'Deleted\'';
				 $stmt = $this->dbObj->Prepare($sql);
			     $rs_tag = $this->dbObj->Execute($stmt);
				 if (!$rs_tag)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				 if(!$row = $rs_tag->FetchRow())
				 {
				 	$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_tags'].
					' WHERE tag_name=\''.$tag[$i].'\'';
					$stmt = $this->dbObj->Prepare($sql);
					$rs_delete = $this->dbObj->Execute($stmt);
					if (!$rs_delete)
					    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
				 }
			 }
		}
		// DELETE TAG END
	}
	/**
	 * photoHandler::deleteFavoritePhoto()
	 *
	 * @param purpose $ To delete the selected favorite photo of the particular user
	 * @param mixed $photo_id
	 * @param mixed $user_id
	 * @return void
	 */
	public function deleteFavoritePhoto($photo_id, $user_id)
	{
		$sql = 'SELECT pf.photo_favorite_id, pf.user_id as favorite_user_id, p.user_id '.
				' FROM '.$this->CFG['db']['tbl']['photo_favorite'].' as pf, '.
				$this->CFG['db']['tbl']['users'].' as u, '.$this->CFG['db']['tbl']['photo'].' as p '.
				' WHERE u.user_id = pf.user_id AND pf.photo_id = p.photo_id AND pf.user_id = '.
				$this->dbObj->Param('user_id').' AND pf.photo_id = '.$this->dbObj->Param('photo_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($user_id, $photo_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		$activity_arr = $row;
		$activity_arr['action_key']	= 'delete_photo_favorite';
		$photoActivityObj = new PhotoActivityHandler();
		$photoActivityObj->addActivity($activity_arr);

		$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_favorite'].' WHERE'.
				' user_id=' . $this->dbObj->Param('user_id') . ' AND' . ' photo_id=' . $this->dbObj->Param('photo_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($user_id, $photo_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($this->dbObj->Affected_Rows())
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET total_favorites = total_favorites-1'.
		 			' WHERE photo_id=' . $this->dbObj->Param('photo_id');

			$stmt   = $this->dbObj->Prepare($sql);
			$rs     = $this->dbObj->Execute($stmt, array($photo_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		}
	}

	/**
	 * photoHandler::deletePhotoComments()
	 *
	 * @return
	 */
	public function deletePhotoComments($ids)
	{
		$comment_id = explode(',', $ids);
		for($inc=0;$inc<count($comment_id);$inc++)
		{
			//FETCH RECORD FOR comment_status //
			$sql = 'SELECT comment_status, photo_id FROM '.$this->CFG['db']['tbl']['photo_comments'].' WHERE'.
					' photo_comment_id ='.$comment_id[$inc];

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$commentDetail = $rs->FetchRow();

			//DELETE COMMENTS//
			$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_comments'].' WHERE'.
					' photo_comment_id ='.$comment_id[$inc];

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			//CONTROL: IF comment_status = yes THEN WE REDUCES THE  total_comments//
			if($commentDetail['comment_status'] == 'Yes')
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET total_comments=total_comments-1'.
						' WHERE photo_id='.$this->dbObj->Param('photo_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($commentDetail['photo_id']));
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		}
	}


	/**
	 * PhotoHandler::chkIsAllowedLeftMenu()
	 *
	 * @return
	 */
	public function chkIsAllowedLeftMenu()
	{
		global $HeaderHandler;
		$allowed_pages_array = array('index.php', 'viewPlaylist.php');
		$HeaderHandler->headerBlock['left_menu_display'] = displayBlock($allowed_pages_array, false, $append_default_pages=false);
		return $HeaderHandler->headerBlock['left_menu_display'];
	}
	/**
	 * photoHandler::getPlaylistIdInMusic()
	 *
	 * @param string $page
	 * @return
	 */
	public function getPlaylistIdInPhoto($photo_id)
	{
		global $smartyObj;
		$playlist = array();
		$smartyObj->assign('playlist', $playlist);
    	if(strstr($photo_id,','))
			return true;
		$sql = 'SELECT photo_playlist_id FROM '.
                $this->CFG['db']['tbl']['photo_in_playlist'].
				' WHERE photo_id = '.$this->dbObj->Param('photo_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt,array($photo_id));
		if (!$rs)
			trigger_db_error($this->dbObj);

		while($row = $rs->FetchRow())
		{
			$playlist[$row['photo_playlist_id']] = $row['photo_playlist_id'];
		}
		$smartyObj->assign('playlist', $playlist);

	}
	/**
	 * photoHandler::displayCreatePlaylistInterface()
	 *
	 * @param string $page
	 * @return
	 */
	public function displayCreatePlaylistInterface($page='')
	{
		global $smartyObj;
		$sql = 'SELECT photo_playlist_name, photo_playlist_id  FROM '.$this->CFG['db']['tbl']['photo_playlist'].' '.
				'WHERE photo_playlist_status = \'Yes\' AND  created_by_user_id = '.$this->dbObj->Param('user_id');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($this->CFG['user']['user_id']));
		if (!$rs)
			trigger_db_error($this->dbObj);

		$playlistInfo = array();
		$playlistInfoviewphoto = array();
		$inc = 0;
		while($row = $rs->FetchRow())
		{
			$playlistInfoviewphoto[$row['photo_playlist_id']] = $row['photo_playlist_name'];
			$playlistInfo[$inc]['slidelist_name'] = $row['photo_playlist_name'];
			$playlistInfo[$inc]['slidelist_id'] = $row['photo_playlist_id'];
			$inc++;

		}
		$smartyObj->assign('playlistInfoViewPhoto', $playlistInfoviewphoto);
		$smartyObj->assign('playlistInfo', $playlistInfo);
	}
	/**
	 * photoSlidelistManage::generalPopulateArrayPlaylist()
	 *
	 * @param mixed $list
	 * @param int $highlight_value,$photo_playlist_id
	 * @return
	 */
	public function generalPopulateArrayPlaylist($list, $highlight_value='', $photo_playlist_id='')
	{
		foreach($list as $key=>$value)
		{
			$disabled = in_array($key,$photo_playlist_id)?'disabled="disabled"':'';
			$selected = trim($highlight_value) == trim($key)?' selected="selected"':'';
?>
<option value="<?php echo $key;?>"<?php echo $selected;?><?php echo $disabled;?>><?php echo $value;?></option>
<?php
		}
	}

	/**
	 * photoSlidelistManage::chkplaylistExits()
	 *
	 * @param mixed $playlist
	 * @param string $err_tip
	 * @return
	 */
	public function chkPlaylistExits($playlist, $err_tip='')
	{
		$sql = 'SELECT COUNT(photo_playlist_id) AS count FROM '.$this->CFG['db']['tbl']['photo_playlist'].' '.
					'WHERE UCASE(photo_playlist_name) = UCASE('.$this->dbObj->Param($this->fields_arr[$playlist]).') '.
					' AND created_by_user_id=\''.$this->CFG['user']['user_id'].'\' ';

		$fields_value_arr[] = $this->fields_arr[$playlist];

		if ($this->fields_arr['photo_playlist_id'])
		{
			$sql .= ' AND photo_playlist_id != '.$this->dbObj->Param($this->fields_arr['photo_playlist_id']);
			$fields_value_arr[] = $this->fields_arr['photo_playlist_id'];
	    }

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($fields_value_arr));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();

		if(!$row['count'])
			{
				return true;
			}
		$this->fields_err_tip_arr['playlist_name'] = $err_tip;
		return false;
	}
	/**
	 * photoHandler::createplaylist()
	 *
	 * @return
	 */
	public function createplaylist()
	{
		if(isset($this->fields_arr['photo_playlist_id']) and $this->fields_arr['photo_playlist_id'] != '')
		{

/*
$sql = 'SELECT photo_playlist_tags FROM '.$this->CFG['db']['tbl']['photo_playlist'].
					' WHERE photo_playlist_id ='.$this->dbObj->Param('photo_playlist_id').'';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_playlist_id']));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
*/

			//$row = $rs->FetchRow();
			//Update photo_playlist detail
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_playlist'].
					' SET photo_playlist_name='.$this->dbObj->Param('playlist_name').', photo_playlist_description='.$this->dbObj->Param('playlist_description');
			//$sql .= ', allow_comments='.$this->dbObj->Param('allow_comments').', allow_ratings='.$this->dbObj->Param('allow_ratings').', allow_embed='.$this->dbObj->Param('allow_embed').'';
			$sql .= ' WHERE  photo_playlist_id='.$this->dbObj->Param('playlist_id');
			//$value_arr = array($this->fields_arr['playlist_name'], $this->fields_arr['playlist_description'], $this->fields_arr['playlist_tags'], $this->fields_arr['allow_comments'], $this->fields_arr['allow_ratings'], $this->fields_arr['allow_embed'], $this->fields_arr['photo_playlist_id']);
			$value_arr = array($this->fields_arr['playlist_name'], $this->fields_arr['playlist_description'],$this->fields_arr['photo_playlist_id']);

			if (!$this->chkIsAdminSide())
			{
				$sql .= ' AND created_by_user_id='.$this->dbObj->Param('user_id');
				$value_arr[] = $this->CFG['user']['user_id'];
			}

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, $value_arr);
		    if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$photo_playlist_id = $this->fields_arr['photo_playlist_id'];
			//Edit photo playList tags
			//$this->editMusicPlaylistTags($row['playlist_tags']);
		}
		else
		{
			//Create Playlis detail

/*
$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_playlist'].
					' SET user_id='.$this->dbObj->Param('user_id').', playlist_name='.$this->dbObj->Param('playlist_name').', playlist_description='.$this->dbObj->Param('playlist_description').
					', allow_comments='.$this->dbObj->Param('allow_comments').', allow_ratings='.$this->dbObj->Param('allow_ratings').', allow_embed='.$this->dbObj->Param('allow_embed').
					', playlist_tags='.$this->dbObj->Param('playlist_tags').', date_added=NOW()';
*/
			$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_playlist'].
					' SET created_by_user_id='.$this->dbObj->Param('user_id').', photo_playlist_name='.$this->dbObj->Param('playlist_name').', photo_playlist_description='.$this->dbObj->Param('playlist_description').
					', date_added=NOW()';

			//$value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['playlist_name'], $this->fields_arr['playlist_description'], $this->fields_arr['allow_comments'], $this->fields_arr['allow_ratings'], $this->fields_arr['allow_embed'], $this->fields_arr['playlist_tags']);
			$value_arr = array($this->CFG['user']['user_id'], $this->fields_arr['playlist_name'], $this->fields_arr['playlist_description']);

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, $value_arr);
		    if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		 	$photo_playlist_id = $this->dbObj->Insert_ID();

			if($this->_currentPage != 'createslidelist')
				$this->playlistCreateActivity($photo_playlist_id);
			//Create photo playlist tags
			//$this->addMusicPlaylistTag();
		}
		return $photo_playlist_id;
	}
	/**
	 * photoHandler::playlistCreateActivity()
	 *
	 * @param mixed $photo_playlist_id
	 * @return
	 */
	public function playlistCreateActivity($photo_playlist_id)
	{
		//Start playlist create photo playlist activity..
		$sql = 'SELECT pl.photo_playlist_id, u.user_name, pl.photo_playlist_name, pl.created_by_user_id '.
				'FROM '.$this->CFG['db']['tbl']['photo_playlist'].' as pl, '.$this->CFG['db']['tbl']['users'].' as u '.
				'WHERE u.user_id = pl.created_by_user_id AND pl.photo_playlist_id = \''.$this->dbObj->Param('photo_playlist_id').'\'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photo_playlist_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$row = $rs->FetchRow();
		$activity_arr = $row;
		$activity_arr['action_key']	= 'playlist_create';
		$createplaylist_image_array = $this->getPlaylistImageName($photo_playlist_id);
		if(empty($createplaylist_image_array))
		{
			$activity_arr['photo_id'] = '';
			$activity_arr['photo_server_url'] = '';
			$activity_arr['photo_ext'] = '';
		}
		else
		{
			$activity_arr['photo_id'] = $createplaylist_image_array['photo_id'];;
			$activity_arr['photo_server_url'] = $createplaylist_image_array['photo_server_url'];
			$activity_arr['photo_ext'] = $createplaylist_image_array['photo_ext'];
		}
		$playlistActivityObj = new PhotoActivityHandler();
		$playlistActivityObj->addActivity($activity_arr);
		//end
	}
	/**
	 * photoHandler::getPlaylistImageName()
	 *
	 * @param integer $photo_playlist_id
	 * @return array
	 */
	public function getPlaylistImageName($photo_playlist_id)
	{
		$sql = 'SELECT m.photo_id, m.photo_server_url, m.photo_ext, mfs.file_name, m.t_width, m.t_height FROM '.$this->CFG['db']['tbl']['photo_in_playlist'].' '.
				'AS mip JOIN '.$this->CFG['db']['tbl']['photo'].' AS m ON m.photo_id=mip.photo_id  JOIN '.$this->CFG['db']['tbl']['photo_files_settings'].' AS mfs '.
				'ON mfs.photo_file_id = m.photo_file_name_id, '.$this->CFG['db']['tbl']['users'].' AS u WHERE mip.photo_playlist_id ='.$this->dbObj->Param('photo_playlist_id').' '.
				' AND m.user_id=u.user_id AND u.usr_status = \'Ok\' AND m.photo_status = \'Ok\''.$this->getAdultQuery('m.', 'photo').' AND '.
				' m.photo_access_type = \'Public\' AND m.photo_ext!=" " LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photo_playlist_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		return $row;
	}
	/**
	 * photoHandler::insertSongtoPlaylist()
	 *
	 * @param mixed $photo_playlist_id
	 * @param mixed $photo_id
	 * @return
	 */
	public function insertPhototoPlaylist($photo_playlist_id, $photo_id)
	{
		if($photo_id==0)
			return;

		//CHECK photo IS ALREADY IN PLAYLIST //

		$sql = 'SELECT photo_in_playlist_id FROM '.$this->CFG['db']['tbl']['photo_in_playlist'].' '.
				'WHERE photo_playlist_id ='.$this->dbObj->Param('photo_playlist_id').' AND '.
				'photo_id ='.$this->dbObj->Param('photo_id').'';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photo_playlist_id, $photo_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		if($row['photo_in_playlist_id'] == '' or !isset($row['photo_in_playlist_id']))
		{
			// FIND ORDER SONG IN PLAYLIST //

			$sql = 'SELECT order_id FROM '.$this->CFG['db']['tbl']['photo_in_playlist'].' '.
					'WHERE photo_playlist_id ='.$this->dbObj->Param('photo_playlist_id');


			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($photo_playlist_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$row = $rs->FetchRow();
			$order_id = $row['order_id'] + 1;

			//INSERT SONG INTO PLAYLIST //

			$sql = 'INSERT INTO '.$this->CFG['db']['tbl']['photo_in_playlist'].' '.
					'SET photo_playlist_id='.$this->dbObj->Param('photo_playlist_id').', photo_id='.$this->dbObj->Param('photo_id').', '.
					'order_id='.$this->dbObj->Param('order_id').', date_added=NOW()';

			$value_arr = array($photo_playlist_id, $photo_id, $order_id);
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, $value_arr);
		    if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			//UPDATE PLAYLIST TABLE total_tracks
			$this->updatePlaylistTable($photo_playlist_id);
		}
		return true;
	}
	/**
	 * photoHandler::updatePlaylistTable()
	 *
	 * @param mixed $photo_playlist_id
	 * @return
	 */
	public function updatePlaylistTable($photo_playlist_id, $affected_count = 0)
	{
		if($affected_count)
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_playlist'].
					' SET total_photos=total_photos - '.$affected_count.' WHERE  photo_playlist_id='.$this->dbObj->Param('photo_playlist_id').'';
		}
		else
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo_playlist'].
					' SET total_photos=total_photos+1 WHERE  photo_playlist_id='.$this->dbObj->Param('photo_playlist_id').'';
		}
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photo_playlist_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		return true;
	}
	/**
	 * PhotoUploadLib::populateMusicListHidden()
	 * @param array $hidden_field
	 * @return void
	 */
	public function populatePhotoListHidden($hidden_field)
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
	 * photoHandler::getAlbumImageName()
	 * // GET ALBUM IMAGE FROM TOP RATED PHOTO \\
	 * @param mixed $album_id
	 * @return string
	 */
	public function getAlbumImageName($album_id)
	{
		$sql = 'SELECT p.l_width, p.l_height, p.t_width, p.t_height, p.m_width, p.m_height, p.photo_id, p.photo_server_url, p.photo_ext'.' '.
				'FROM '.$this->CFG['db']['tbl']['photo'].' AS p,'.$this->CFG['db']['tbl']['photo_album'].' AS pa, '.$this->CFG['db']['tbl']['users'].' AS u '.
				'WHERE u.user_id = p.user_id AND p.photo_album_id = pa.photo_album_id AND u.usr_status = \'Ok\'
				AND p.photo_status = \'Ok\' AND p.photo_ext <> " " AND pa.photo_album_id = \''.$album_id.'\''.$this->getAdultQuery('p.', 'photo').' '.
				'AND (p.user_id = '.$this->CFG['user']['user_id'].' OR  p.photo_access_type = \'Public\''.$this->getAdditionalQuery().') LIMIT 0 , 1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$album_image = $rs->FetchRow();
		return $album_image;
	}

	/**
	 * PhotoHandler::chkPrivatePhoto()
	 *
	 * @param mixed $photo_id
	 * @return string
	 */
	public function chkPrivatePhoto($photo_id)
	{
		$sql = 'SELECT p.photo_id  FROM '.$this->CFG['db']['tbl']['photo'].' as p'.
				' WHERE p.photo_id= '.$this->dbObj->Param('photo_id').' AND (p.user_id = '.
				$this->CFG['user']['user_id'].' OR p.photo_access_type = \'Public\''.
				$this->getAdditionalQuery().') '.$this->getAdultQuery('p.', 'photo');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($photo_id));
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		return $rs->PO_RecordCount();
	}

	/**
	 * photoHandler::getTagsLink()
	 *
	 * @param mixed $tag_srting, $tagoption
	 * @return
	 */
	public function getTagsLink($tag_srting, $tagoption='photo')
	{
		global $smartyObj;
		$getTagsLink_arr = array();
		$tag_array = explode(' ', $tag_srting);
		$inc = 1;
		foreach($tag_array as $tag_name)
		{
			$getTagsLink_arr[$inc]['wordWrap_mb_ManualWithSpace_tag_name'] = $tag_name;
			$getTagsLink_arr[$inc]['title_tag_name'] = $tag_name;
			if($tagoption == 'photo')
				$getTagsLink_arr[$inc]['tag_url'] = getUrl('photolist', '?pg=photonew&tags='.$tag_name, 'photonew/?tags='.$tag_name, '', 'photo');
		}
		$smartyObj->assign('getTagsLink_arr', $getTagsLink_arr);
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('populateTagsLinks.tpl');
	}

	public function getPlaylistTotalPhotos($photo_playlist_id)
	{
		$sql = 'SELECT count(photo_in_playlist_id) AS total '.
		 		'FROM '.$this->CFG['db']['tbl']['photo_in_playlist'].' as ppl JOIN '.$this->CFG['db']['tbl']['photo'].' as p ON ppl.photo_id=p.photo_id'.', '.$this->CFG['db']['tbl']['users'] . ' as u '.
				'WHERE u.user_id = p.user_id AND p.photo_status = \'Ok\' AND u.usr_status = \'Ok\' AND ppl.photo_playlist_id = '.$photo_playlist_id.' '.
				'AND (p.user_id = '.$this->CFG['user']['user_id'].' OR '.' p.photo_access_type = \'Public\''.$this->getAdditionalQuery().') '.$this->getAdultQuery('p.', 'photo').' ORDER BY ppl.order_id ASC';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$row = $rs->FetchRow();
		return $row['total'];
	}
    public function displayPhotoList($photo_playlist_id='', $condition=false, $limit='')
	{
		global $smartyObj;
		$displayPhotoList_arr = array();
		$sql = 'SELECT p.photo_id, p.photo_title, pa.photo_album_title, p.photo_server_url, p.photo_ext  '.
		 		'FROM '.$this->CFG['db']['tbl']['photo_in_playlist'].' as ppl JOIN '.
				 $this->CFG['db']['tbl']['photo'].' as p ON ppl.photo_id=p.photo_id'.', '.
				 $this->CFG['db']['tbl']['users'] . ' as u, '.
				 $this->CFG['db']['tbl']['photo_album'].' AS pa '.
				'WHERE pa.photo_album_id = p.photo_album_id AND '.
				'u.user_id = p.user_id AND p.photo_status = \'Ok\' '.
				'AND u.usr_status = \'Ok\' AND ppl.photo_playlist_id = '.$photo_playlist_id;

		if($condition)
			$sql .= ' AND (p.user_id = '.$this->CFG['user']['user_id'].
					' OR p.photo_access_type = \'Public\''.
					$this->getAdditionalQuery().') '.$this->getAdultQuery('p.', 'photo');

		$sql .= ' ORDER BY ppl.order_id ASC';
		//commented this condition for get photo ids for movie maker module.
		//if($limit!='')
		//	$sql .= ' LIMIT 0, '.$limit;
		//echo $sql;
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$displayPhotoList_arr['record_count'] = 0;
		$displayPhotoList_arr['row'] = array();
		$displayPhotoIds_arr = array();
		$photos_folder = 'files/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$inc = 1;

		$displayPhotoList_arr['total_record'] = $total = $rs->PO_RecordCount();
		$displayPhotoList_arr['noimageCount'] = 0;
		if($total < 4)
			$displayPhotoList_arr['noimageCount'] = 4-$total;

		while($photoDetail = $rs->FetchRow())
			{
				$displayPhotoList_arr['record_count'] = 1;
				$displayPhotoList_arr['row'][$inc]['record'] = $photoDetail;
				$displayPhotoList_arr['row'][$inc]['photo_status'] = 1;
				/*if(!$condition and !$this->chkIsAdminSide())
					$displayPhotoList_arr['row'][$inc]['photo_status'] = $this->chkPrivatePhoto($photoDetail['photo_id']);*/
				$displayPhotoList_arr['row'][$inc]['viewphoto_url'] = getUrl('viewphoto', '?photo_id='.$photoDetail['photo_id'].'&title='.$this->changeTitle($photoDetail['photo_title']), $photoDetail['photo_id'].'/'.$this->changeTitle($photoDetail['photo_title']).'/', '', 'photo');
				$displayPhotoList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_photo_title'] = $photoDetail['photo_title'];
				$displayPhotoList_arr['row'][$inc]['wordWrap_mb_ManualWithSpace_album_title'] = $photoDetail['photo_album_title'];
				$photo_name = getphotoName($photoDetail['photo_id']);
				$displayPhotoList_arr['row'][$inc]['photo_img_src'] = $photoDetail['photo_server_url'].$photos_folder.$photo_name.$this->CFG['admin']['photos']['small_name'].'.'.$photoDetail['photo_ext'];

				//added this condition for get photo ids for movie maker module.
				$displayPhotoIds_arr[] = $photoDetail['photo_id'];
				if($limit>$inc && $limit!='')
				{
					$inc++;
				}
				else if($limit=='')
				{
				  	$inc++;
				}
			}
		$photo_ids=implode(',',$displayPhotoIds_arr);
		$smartyObj->assign('displayPhotoList_arr', $displayPhotoList_arr);
		$smartyObj->assign('photo_ids', $photo_ids);
		$smartyObj->assign('lastDiv', $$inc=$inc-1);
	}

	/**
	 * Tag::populateTags()
	 *
	 * @return
	 **/
	public function populateSidebarTags()
	{
		global $smartyObj;
		$return = array();
		$return['resultFound']=false;
		$allowed_pages_array = array('viewPhoto.php');
		if(displayBlock($allowed_pages_array))
			return;

		if($this->CFG['admin']['tagcloud_based_search_count'])
		{
			$sql = 'SELECT tag_name, search_count FROM '.$this->CFG['db']['tbl']['photo_tags'].
				   ' WHERE search_count>0 ORDER BY search_count DESC, result_count DESC, tag_name ASC'.
				   ' LIMIT 0, '.$this->CFG['admin']['photos']['sidebar_clouds_num_record'];
		}
		else
		{
			$sql = 'SELECT tag_name, result_count AS search_count FROM'.
					' '.$this->CFG['db']['tbl']['photo_tags'].
				    ' WHERE result_count>0 ORDER BY result_count DESC, tag_name ASC'.
				    ' LIMIT 0, '.$this->CFG['admin']['photos']['sidebar_clouds_num_record'];
		}

		$searchUrl 	  = getUrl('photolist', '?pg=photonew&tags=%s', 'photonew/?tags=%s', '', 'photo');
		$moretags_url = getUrl('tags', '?pg=photo', 'photo/', '', 'photo');

		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if ($rs->PO_RecordCount()>0)
	    {
	    	$return['resultFound']=true;
			$classes 	   = array('clsAudioTagStyleGrey', 'clsAudioTagStyleGreen');
			$tagClassArray = array();
	        while($row = $rs->FetchRow())
	        {
				$tagArray[$row['tag_name']] = $row['search_count'];
				$class = $classes[rand(0, count($classes))%count($classes)];
				$tagClassArray[$row['tag_name']] = $class;
			}
			$tagArray = $this->setPhotoFontSizeInsteadOfSearchCountSidebar($tagArray);
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
				$return['item'][$inc]['wordWrap_mb_ManualWithSpace_tag']= $tag;
				$return['item'][$inc]['name']=$tag;
				$inc++;
			}
	    }
		$smartyObj->assign('moretags_url', $moretags_url);
		$smartyObj->assign('populateTagsBlock', $return);
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('populateTagsBlock.tpl');
	}

	/**
		 * photoHandler::getPlaylistImageDetail()
		 * @ get 4 image
		 * @param integer $playlist_id
		 * @param boolean $condition - to add accesstype and additional query, adult query
		 * @return array
		 */
	public function getPlaylistImageDetail($playlist_id, $condition=true)
		{
			$getPlaylistImageDetail_arr = array();
			$playlist_thumbnail_folder = $this->CFG['media']['folder'].'/'.
											$this->CFG['admin']['photos']['folder'].'/'.
												$this->CFG['admin']['photos']['folder'].'/';

			$sql = 'SELECT p.photo_id, p.photo_title, p.photo_server_url, p.photo_ext, pfs.file_name, '.
						' p.s_width, p.s_height, p.t_width, p.t_height FROM '.
						$this->CFG['db']['tbl']['photo_in_playlist'].' AS pip JOIN '.
						$this->CFG['db']['tbl']['photo'].' AS p ON p.photo_id=pip.photo_id  JOIN '.
						$this->CFG['db']['tbl']['photo_files_settings'].' AS pfs '.
						'ON pfs.photo_file_id = p.photo_file_name_id, '.$this->CFG['db']['tbl']['users'].
						' AS u WHERE pip.photo_playlist_id ='.$this->dbObj->Param('playlist_id').' '.
						' AND p.user_id=u.user_id AND u.usr_status = \'Ok\' AND p.photo_status = \'Ok\' AND '.
						' p.photo_ext!=" "';

			if($condition)
				$sql .= ' AND (p.user_id = '.$this->CFG['user']['user_id'].
						' OR p.photo_access_type = \'Public\''.
						$this->getAdditionalQuery().') '.$this->getAdultQuery('p.', 'photo');

			$sql .= ' ORDER BY p.photo_id DESC LIMIT 0,4';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt, array($playlist_id));
			if (!$rs)
				trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$getPlaylistImageDetail_arr['total_record'] = $total = $rs->PO_RecordCount();
			$getPlaylistImageDetail_arr['noimageCount'] = 0;
			if($total < 4)
				$getPlaylistImageDetail_arr['noimageCount'] = 4-$total;
			$getPlaylistImageDetail_arr['row'] = array();
			$inc = 1;
			while($row = $rs->FetchRow())
				{
					$getPlaylistImageDetail_arr['row'][$inc]['record'] = $row;
					$getPlaylistImageDetail_arr['row'][$inc]['photo_title_word_wrap'] = $row['photo_title'];
					$getPlaylistImageDetail_arr['row'][$inc]['playlist_thumb_path'] = $row['photo_server_url'].$playlist_thumbnail_folder.getPhotoImageName($row['photo_id']).$this->CFG['admin']['photos']['thumb_name'].'.'.$row['photo_ext'];
					$getPlaylistImageDetail_arr['row'][$inc]['disp_thumb_image']= DISP_IMAGE($this->CFG['admin']['photos']['thumb_width'], $this->CFG['admin']['photos']['thumb_height'], $row['t_width'], $row['t_height']);
					$getPlaylistImageDetail_arr['row'][$inc]['playlist_path'] = $row['photo_server_url'].$playlist_thumbnail_folder.getPhotoImageName($row['photo_id']).$this->CFG['admin']['photos']['small_name'].'.'.$row['photo_ext'];
					$getPlaylistImageDetail_arr['row'][$inc]['disp_image']= DISP_IMAGE($this->CFG['admin']['photos']['small_width'], $this->CFG['admin']['photos']['small_height'], $row['s_width'], $row['s_height']);
					$inc++;
				}

			return $getPlaylistImageDetail_arr;
		}

	/**
		 * photoHandler::deletePhotoPlaylist()
		 * Here we deleted playlist related table , activity & playlist table
		 * @return
		 */
	public function deletePhotoPlaylist()
			{
				$playlist_ids = $this->fields_arr['photo_playlist_ids'];
				//DELETED PLAYLIST TAGS//
				//$this->deletePhotoPlaylistTag($playlist_ids);
				// *********Delete records from PLAYLIST related tables start*****
				//$tablename_arr = array('photo_playlist_comments', 'photo_playlist_favorite', 'photo_playlist_listened', 'photo_playlist_featured', 'photo_playlist_viewed', 'photo_playlist_rating');
				$tablename_arr = array('photo_playlist_viewed', 'photo_in_playlist');
				for($i=0;$i<sizeof($tablename_arr);$i++)
					{
						$sql  = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].' WHERE photo_playlist_id IN(' . $playlist_ids . ')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs   = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
					}

				//DELETE PLAYLIST RELATED ACTIVITY //
				$action_key = array('playlist_create', 'playlist_comment', 'playlist_rated', 'playlist_featured', 'playlist_favorite', 'playlist_share');
				for($inc=0;$inc<count($action_key);$inc++)
					{
						//$condition = '  SUBSTRING(action_value, 1, 1 ) IN ('.$playlist_ids.') AND action_key = \''.$action_key[$inc].'\'';
						//$condition = '  content_id IN ('.$playlist_ids.') AND action_key = \''.$action_key[$inc].'\'';
						$condition = '  SUBSTRING_INDEX(action_value, \'~\', 1 ) IN ('.$playlist_ids.') AND action_key = \''.$action_key[$inc].'\'';

						$sql='SELECT parent_id FROM '.$this->CFG['db']['tbl']['photo_activity'].' WHERE '.$condition;
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

						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_activity'].
						' WHERE '.$condition;

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$condition_act = '  parent_id IN ('.$parent_id.') ';
						$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['activity'].' WHERE '.$condition_act;
						$stmt = $this->dbObj->Prepare($sql);
						$rs   = $this->dbObj->Execute($stmt);
			    		if (!$rs)
				    		trigger_db_error($this->dbObj);
				    	}

					}

				$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_playlist'].
						' WHERE photo_playlist_id IN ('.$playlist_ids.')' ;

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				return true;
			}

	/**
		 * photoPlaylistManage::getPhotoPlaylist()
		 *
		 * @return
		 */
		public function getPhotoPlaylist()
			{
				$sql ='SELECT photo_playlist_id, photo_playlist_name, photo_playlist_description FROM '.$this->CFG['db']['tbl']['photo_playlist'].
						' WHERE photo_playlist_id='.$this->dbObj->Param('playlist_id').' ';

				$value_arr = array($this->fields_arr['photo_playlist_id']);
				 if (!$this->chkIsAdminSide())
				 	{
						$sql .= 'AND created_by_user_id='.$this->dbObj->Param('user_id');
						$value_arr[] = $this->CFG['user']['user_id'];
					}

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, $value_arr);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$row = $rs->FetchRow();
				if(isset($row['photo_playlist_id']))
					{
						$this->fields_arr['playlist_name'] = $row['photo_playlist_name'];
						$this->fields_arr['playlist_description'] = $row['photo_playlist_description'];
						return true;
					}
				else
					{
						return false;
					}

			}
	/**
		 * photoHandler::chkIsAdminSide()
		 * Checks whether the requested url is admin site
		 * @return
		 */
	public function chkIsAdminSide()
		{
			$url_arr = explode('/', $_SERVER['REQUEST_URI']);
			if(in_array('admin', $url_arr))
				return true;
			else
				return false;
		}
	public function getQuickMixLastImg()
	{
	    global $smartyObj;
		$smartyObj->assign('display_stach_block',false);
		if(isset($_SESSION['user']['photo_quick_mixs']) && $_SESSION['user']['photo_quick_mixs'])
		{
		$session_last_photo_ids=$_SESSION['user']['photo_quick_mixs'];
		$session_last_photo_ids_arr=explode(',',$_SESSION['user']['photo_quick_mixs']);
		$session_last_photo_id=$session_last_photo_ids_arr[count($session_last_photo_ids_arr)-1];
		$session_last_img_url=getPhotoUrl($session_last_photo_id);
		$smartyObj->assign('display_stach_block',true);
		$smartyObj->assign('photo_ids',$session_last_photo_ids);
		$smartyObj->assign('session_last_img_url',str_replace('/','\/',$session_last_img_url));
		}
		setTemplateFolder('general/', 'photo');
		$smartyObj->display('photoStack.tpl');

	}
	/**
	 * photoHandler::populatephotoCategoriesForSubscription()
	 *   Generate Categories for Subscription option
	 *
	 * @return array
	 */
	public function populatePhotoCategoriesForSubscription()
		{
			if(!isMember())
				$_SESSION['user']['content_filter'] ='On';

			if($_SESSION['user']['content_filter'] =='On')
				$_photoType=' AND photo_category_type = \'General\'';
			else
				$_photoType='';

			//photo catagory List order by Priority on / off features
			if($this->CFG['admin']['photos']['photo_category_list_priority'])
				$order_by = 'priority';
			else
				$order_by = 'photo_category_name';

			$sql = 'SELECT photo_category_id, photo_category_name '.
					'FROM '.$this->CFG['db']['tbl']['photo_category'].' '.
					'WHERE parent_category_id=0 AND photo_category_status = \'Yes\' '.$_photoType.
					'ORDER BY '.$order_by.' ASC';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.
					$this->dbObj->ErrorMsg(), E_USER_ERROR);

			$channel=array();
			$inc=0;
			if($rs->PO_RecordCount())
				{
					while($row = $rs->FetchRow())
						{
							$channel[$inc]['id'] = $row['photo_category_id'];
							$channel[$inc]['name'] = $row['photo_category_name'];
							$inc++;
						}

				}
			return $channel;
		}

	/**
	 * photoHandler::populatephotoSubCategoriesForSubscription()
	 *   Generate Categories for Subscription option
	 *
	 * @return array
	 */
	public function populatePhotoSubCategoriesForSubscription($category_id)
	{
		if(!isMember())
			$_SESSION['user']['content_filter'] ='On';

		if($_SESSION['user']['content_filter'] =='On')
			$_photoType=' AND photo_category_type = \'General\'';
		else
			$_photoType='';

		//photo catagory List order by Priority on / off features
		if($this->CFG['admin']['photos']['photo_category_list_priority'])
			$order_by = 'priority';
		else
			$order_by = 'photo_category_name';

		$sql = 'SELECT photo_category_id, photo_category_name '.
				'FROM '.$this->CFG['db']['tbl']['photo_category'].' '.
				'WHERE parent_category_id='.$category_id.' AND photo_category_status = \'Yes\' '.$_photoType.
				'ORDER BY '.$order_by.' ASC';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$channel=array();
		$inc=0;
		if($rs->PO_RecordCount())
			{
				while($row = $rs->FetchRow())
					{
						$channel[$inc]['id'] = $row['photo_category_id'];
						$channel[$inc]['name'] = $row['photo_category_name'];
						$inc++;
					}

			}
		return $channel;
	}


	/**
	 * photoHandler::populatephotoCategoriesListForSubscription()
	 *
	 *
	 * @return void
	 */
	public function populatePhotoCategoriesListForSubscription()
	{
		global $CFG, $smartyObj;

		$catergoryPerRow = $this->CFG['admin']['photos']['catergory_list_per_row'];
		$rowInc=0;

		if(!isMember())
			$_SESSION['user']['content_filter'] ='On';

		if($_SESSION['user']['content_filter'] =='On')
			$_photoType=' AND photo_category_type = \'General\'';
		else
			$_photoType='';

		//photo catagory List order by Priority on / off features
		if($this->CFG['admin']['photos']['photo_category_list_priority'])
			$order_by = 'priority';
		else
			$order_by = 'photo_category_name';

		$sql = 'SELECT gc.photo_category_id, gc.photo_category_name,'.
				'gc.photo_category_type, photo_category_description,'.
				'gc.photo_category_status, gc.photo_category_ext, gc.date_added FROM '.
				$CFG['db']['tbl']['photo_category'].' as gc JOIN '.
				$CFG['db']['tbl']['subscription'].' as s ON gc.photo_category_id = s.category_id '.
				' WHERE  photo_category_status = \'Yes\' '.
				' AND s.module = \'photo\' AND s.subscriber_id='.$this->CFG['user']['user_id'].
				' AND s.status=\'Yes\' '.$_photoType.
				' ORDER BY '.$order_by.' ASC';


		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);

		$channel=array();
		$inc=0;
		$found = false;
		if($rs->PO_RecordCount())
			{
				while($row = $rs->FetchRow())
					{
						$channel[$inc]['open_tr'] = false;
						$found = true;
						if ($rowInc%$catergoryPerRow==0)
					   		{
								$channel[$inc]['open_tr'] = true;
						    }

						if(chkAllowedModule(array('content_filter')))
							{
								$channel[$inc]['content_filter'] = true;
							}
						else
							{
								$channel[$inc]['content_filter'] = false;
							}

						$channel[$inc]['photo_category_id'] = $row['photo_category_id'];
						$channel[$inc]['category_name'] = $row['photo_category_name'];
						if($row['photo_category_ext'])
							{
								$channel[$inc]['category_image'] 	= $this->CFG['site']['project_path'].$this->CFG['admin']['photos']['category_folder'].$row['photo_category_id'].'.'.$row['photo_category_ext'];
							}
						else
							{
								$channel[$inc]['category_image'] = '';
							}
						if(!file_exists($channel[$inc]['category_image']))
							{
								$channel[$inc]['category_image'] =  $this->CFG['site']['photo_url'].'design/templates/'.
																		$this->CFG['html']['template']['default'].'/root/images/'.
																			$this->CFG['html']['stylesheet']['screen']['default'].
																				'/no_image/icon-nosubcategory.jpg';

							}
						else
							{
								$channel[$inc]['category_image']  = str_replace($this->CFG['site']['project_path'], $this->CFG['site']['url'],$channel[$inc]['category_image']);
							}
						$channel[$inc]['photo_link'] = getUrl('photolist','?pg=photonew&cid='.$row['photo_category_id'], 'photonew/?cid='.$row['photo_category_id'],'','photo');
						$rowInc++;
						$channel[$inc]['end_tr'] = false;
						if ($rowInc%$catergoryPerRow==0)
						    {
								$rowInc = 0;
								$channel[$inc]['end_tr'] = true;
				    		}
						$inc++;
					}

			}
		$subscription_category_list['extra_td_tr'] = false;
		if ($found and $rowInc and $rowInc<$catergoryPerRow)
		    {
				$subscription_category_list['extra_td_tr'] = true;
				$subscription_category_list['records_per_row'] = $catergoryPerRow - $rowInc;
			}

		$smartyObj->assign('categories_list_subscription_arr', $channel);
		$smartyObj->assign('subscription_category_list', $subscription_category_list);
		setTemplateFolder('members/', 'photo');
		$smartyObj->display('subscriptionPhotoCategory.tpl');
	}


	/**
	 * photoHandler::populatePhotoTagListForSubscription()
	 *
	 * @return void
	 */
	public function populatePhotoTagListForSubscription()
	{
		global $CFG, $smartyObj;

		$subscription_tag_list['resultFound'] = false;
		$sql = 'SELECT s.tag_name FROM '.$this->CFG['db']['tbl']['subscription'].' as s '.
			    ' WHERE s.status=\'Yes\' AND s.module = \'photo\''.
				' AND s.subscriber_id='.$this->CFG['user']['user_id'].
				' AND subscription_type=\'Tag\'';

		$searchUrl = getUrl('photolist', '?pg=photonew&tags=%s','photonew/?tags=%s','','photo');

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt);
	    if (!$rs)
		    trigger_error($this->dbObj->ErrorNo().' '.
				$this->dbObj->ErrorMsg(), E_USER_ERROR);
		if ($rs->PO_RecordCount()>0)
		    {
		    	$subscription_tag_list['resultFound']=true;
				$classes = array('clsTagStyleOrange', 'clsTagStyleGrey');
				$tagClassArray = array();
		        while($row = $rs->FetchRow())
		        	{
						$tagArray[$row['tag_name']] = $row['tag_name'];
					}
				ksort($tagArray);
				$inc=0;
				foreach($tagArray as $tag)
					{
						$url 	= sprintf($searchUrl, $tag);
						$subscription_tag_list['item'][$inc]['url']=$url;
						$subscription_tag_list['item'][$inc]['name']=$tag;
						$subscription_tag_list['item'][$inc]['add_slash_name']=addslashes($tag);
						$subscription_tag_list['item'][$inc]['change_title_name']=$this->changeTitle($tag);
						$inc++;
					}
		    }

		$smartyObj->assign('subscription_tag_list', $subscription_tag_list);
		setTemplateFolder('members/', 'photo');
		$smartyObj->display('subscriptionPhotoTag.tpl');
	}

	/**
	 * photoHandler::deletePhotos()
	 * @param array $photo_id_arr, integer $user_id
	 *
	 * @return boolean
	 */
	public function deletePhotos($photo_id_arr = array(), $user_id)
	{
		//Condition to check user is logged in while deleting photo
		$delCond = ' AND user_id = '.$user_id;

		$photo_id = implode(',',$photo_id_arr);
		$sqlstatus= 'SELECT  photo_status FROM '.$this->CFG['db']['tbl']['photo'].' WHERE '.
					' photo_status = \'Locked\' AND photo_id= '.$this->dbObj->Param('photo_id').$delCond;

		$stmtstatus  = $this->dbObj->Prepare($sqlstatus);
		$rsstatus    = $this->dbObj->Execute($stmtstatus, array($photo_id));
		if (!$rsstatus)
			trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
		if($rsstatus->PO_RecordCount()>0)
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET photo_status=\'Deleted\''.
					' WHERE photo_id IN('.$photo_id.')';

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($affected_rows = $this->dbObj->Affected_Rows())
			{
				$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
						' total_photos=total_photos-'.$affected_rows.
						' WHERE user_id='.$this->dbObj->Param('user_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				if (!$rs)
				   trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
			}
		}
		else
		{
			$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET photo_status=\'Deleted\''.
					' WHERE photo_id IN('.$photo_id.')'.$delCond;

			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

			if($affected_rows = $this->dbObj->Affected_Rows())
				{
					$this->deletePhotoTag($photo_id);
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['users'].' SET'.
							' total_photos=total_photos-'.$affected_rows.
							' WHERE user_id='.$this->dbObj->Param('user_id');

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt, array($user_id));
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

					//$_SESSION['user']['total_photos'] = $_SESSION['user']['total_photos']-$affected_rows;
					//*********Delete records from Photo related tables start*****
					$tablename_arr = array('photo_comments', 'photo_favorite', 'photo_viewed', 'photo_rating');
					for($i=0;$i<sizeof($tablename_arr);$i++)
						{
							$sql = 'DELETE FROM '.$this->CFG['db']['tbl'][$tablename_arr[$i]].
									' WHERE photo_id IN('.$photo_id.')';

							$stmt = $this->dbObj->Prepare($sql);
							$rs = $this->dbObj->Execute($stmt);
							    if (!$rs)
								    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
						}

					//DELETE FLAGGED CONTENTS
					$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].
							' WHERE content_type=\'Photo\' AND content_id IN('.$photo_id.')';

					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					//**********End************

					if($this->chkIsFeaturedPhoto($photo_id_arr, $user_id))
						{
							$new_photo = $this->getNewFeaturedPhoto($user_id);
							$this->setFeatureThisImage($new_photo, $user_id);
						}

						//delete photo play list related datas.
						$total_photo = count($photo_id_arr);
						for($p=0;$p<$total_photo;$p++)
						{
							$sqlplay= 'SELECT  photo_playlist_id FROM '.$this->CFG['db']['tbl']['photo_in_playlist'].' WHERE '.
									' photo_id= '.$this->dbObj->Param('photo_id').' GROUP BY photo_playlist_id ';
							$stmtplay   = $this->dbObj->Prepare($sqlplay);
							$rsplay     = $this->dbObj->Execute($stmtplay, array($photo_id_arr[$p]));
							if (!$rsplay)
								trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
							if($rsplay->PO_RecordCount()>0)
							{
								while($rowplay = $rsplay->FetchRow())
								{
									$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_in_playlist'].' WHERE  photo_id = '.$this->dbObj->Param('photo_id').
											' AND photo_playlist_id = '.$this->dbObj->Param('photo_playlist_id');
									$stmt   = $this->dbObj->Prepare($sql);
									$rs     = $this->dbObj->Execute($stmt,array($photo_id_arr[$p],$rowplay['photo_playlist_id']));
									if (!$rs)
										trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);

									$sql= 'UPDATE '.$this->CFG['db']['tbl']['photo_playlist'].' SET'.
											' total_photos=total_photos - 1 WHERE photo_playlist_id IN ('.$rowplay['photo_playlist_id'].') AND total_photos>0';
									$stmt   = $this->dbObj->Prepare($sql);
									$rs     = $this->dbObj->Execute($stmt);
									if (!$rs)
										trigger_error($this->dbObj->ErrorNo() . ' ' . $this->dbObj->ErrorMsg(), E_USER_ERROR);
								}
							}
						}

					//activity tables.
					$action_key = array('photo_uploaded', 'photo_comment', 'photo_rated', 'photo_favorite', 'photo_featured', 'photo_share');
					for($inc=0;$inc<count($action_key);$inc++)
					{
						//$condition = ' SUBSTRING(action_value, 1, 1 ) IN ('.substr($this->deletedPhotoIds,0,-1).') AND action_key = \''.$action_key[$inc].'\'';
						//$condition = '  content_id IN ('.$photo_id.') AND action_key = \''.$action_key[$inc].'\'';
						$condition = '  SUBSTRING_INDEX(action_value, \'~\', 1 ) IN ('.$photo_id.') AND action_key = \''.$action_key[$inc].'\'';

						$sql='SELECT parent_id FROM '.$this->CFG['db']['tbl']['photo_activity'].' WHERE '.$condition;
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
						$sql  = 'DELETE FROM '.$this->CFG['db']['tbl']['photo_activity'].' WHERE '.$condition;
						$stmt = $this->dbObj->Prepare($sql);
						$rs   = $this->dbObj->Execute($stmt);
					    if (!$rs)
						    trigger_db_error($this->dbObj);
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
	 * photoHandler::chkIsFeaturedPhoto()
	 * @param array $photo_id_arr, integer $user_id
	 *
	 * @return boolean
	*/
	public function chkIsFeaturedPhoto($photo_id_arr=array(), $user_id)
	{
		$photo_id = implode(',',$photo_id_arr);

		$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users'].
				' WHERE user_id='.$this->dbObj->Param('user_id').' AND'.
				' icon_type=\'Photo\' AND icon_id IN('.$photo_id.') LIMIT 0,1';

		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array($user_id));
		    if (!$rs)
			    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

		if($row = $rs->FetchRow())
			return true;
		return false;
	}
}
?>