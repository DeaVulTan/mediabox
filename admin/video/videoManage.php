<?php
/**
 * This file is to manage the videos
 *
 * This file is having videoManage class to manage the videos
 *
 *
 * @category	Rayzz
 * @package		Admin
 *
 **/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/video/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/video/admin/videoManage.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/countries_list_array.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/language_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_VideoHandler.lib.php';
$CFG['site']['is_module_page']='video';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//---------------------------- Class videoManage begins -------------------->>>>>//
/**
 *
 * @category	rayzz
 * @package		Admin
 **/
class videoManage extends MediaHandler
	{
		public $sql_condition = '';
		public $sql_sort = '';
		public $fields_arr = '';
		public $sql='';
		public $video_category_name = array();
		public $demo_site = false;

		/**
		 * videoManage::buildConditionQuery()
		 *
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = '';
			}

		/**
		 * videoManage::buildSortQuery()
		 *
		 * @return void
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'v.video_id DESC';
			}

		/**
		 * videoManage::getVideoCategory()
		 *
		 * @param integer $video_category_id
		 * @return array
		 */
		public function getVideoCategory($video_category_id)
			{
				if(isset($this->video_category_name[$video_category_id]))
					return $this->video_category_name[$video_category_id];

				$this->video_category_name[$video_category_id] = '';

				$sql = 'SELECT video_category_name FROM '.$this->CFG['db']['tbl']['video_category'].
						' WHERE video_category_id='.$this->dbObj->Param('video_category_id').' AND 	video_category_status=\'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($video_category_id));
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						$this->video_category_name[$video_category_id] = wordWrap_mb_ManualWithSpace($row['video_category_name'], $this->CFG['admin']['videos']['admin_video_channel_title_length']);
					}
				return $this->video_category_name[$video_category_id];
			}

		/**
		 * videoManage::populateVideoCategory()
		 *
		 * @return void
		 */
		public function populateVideoCategory($srch_categories = false)
			{
				$sql = 'SELECT video_category_id, video_category_name FROM '.$this->CFG['db']['tbl']['video_category'].' WHERE 	video_category_status=\'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$populateVideoCategory='';
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$populateVideoCategory .= '<option value="'.$row['video_category_id'].'" class="selectVideoCategory"';

								if($this->fields_arr['srch_categories']  == $row['video_category_id'])
									$populateVideoCategory .= ' selected="selected"';

								$populateVideoCategory .= '>'.$row['video_category_name'].'</option>';
								if($this->CFG['admin']['videos']['sub_category'])
									{
										$populateVideoCategory .= $this->populateVideoSubCategory($row['video_category_id']);
									}

							}
					}
					return $populateVideoCategory;

			}
		/**
		 * videoManage::populateVideoSubCategory()
		 *
		 * @return void
		 */
		public function populateVideoSubCategory($category_id)
			{

				$populatevideoSubCategory = '';
				$sql = 'SELECT video_category_id, video_category_name FROM '.$this->CFG['db']['tbl']['video_category'].
						' WHERE parent_category_id='.$category_id.' AND video_category_status=\'Yes\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$populatevideoSubCategory .= '<option value="'.$row['video_category_id'].'" class="selectvideoSubCategory"';
								if($this->fields_arr['srch_categories'] == $row['video_category_id'])
									$populatevideoSubCategory .= ' selected="selected"';
								$populatevideoSubCategory .= '>'.$row['video_category_name'].'</option>';
							}
						return $populatevideoSubCategory;
					}
				return ;
			}

		/**
		 * videoManage::displayVideoList()
		 * This method helps to display the list of videos
		 *
		 * @return void
		 **/
		public function displayvideoList()
			{
				global $smartyObj;
				$displayvideoList_arr = array();
				$fields_list = array('user_name', 'first_name', 'last_name');
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				$fields_list = array('user_name', 'first_name', 'last_name');
				//$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/';
				$displayvideoList_arr['row'] = array();
				$inc = 1;
				while($row = $this->fetchResultRecord())
					{
						if(!isset($row['user_name']))
							{
								if(!isset($this->UserDetails[$row['user_id']]))
									$this->getUserDetail('user_id',$row['user_id'], 'user_name');
								$displayvideoList_arr['row'][$inc]['name'] = $this->getUserDetail('user_id',$row['user_id'], 'user_name');
							}
						else
							{
								$name = $this->CFG['format']['name'];
								$name = str_replace('$first_name', $row['first_name'],$name);
								$name = str_replace('$last_name', $row['last_name'],$name);
								$name = str_replace('$user_name', $row['user_name'],$name);
								$displayvideoList_arr['row'][$inc]['name'] = $name;
							}
						$displayvideoList_arr['row'][$inc]['file_path'] = $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
						$displayvideoList_arr['row'][$inc]['DISP_IMAGE'] = DISP_IMAGE($this->CFG['admin']['videos']['small_width'], $this->CFG['admin']['videos']['small_height'], $row['s_width'], $row['s_height']);
						$row['flagged_status'] = $row['flagged_status']?$row['flagged_status']:'No';
						$row['featured'] = $row['featured']?$row['featured']:'No';
						$displayvideoList_arr['row'][$inc]['comments_text'] = str_replace('{total_comments}', $row['total_comments'], $this->LANG['video_comments']);
						$row['video_title']=wordWrap_mb_Manual($row['video_title'], $this->CFG['admin']['videos']['list_title_length'], $this->CFG['admin']['videos']['list_title_total_length']);
						$displayvideoList_arr['row'][$inc]['record'] = $row;
						$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/';
						$displayvideoList_arr['row'][$inc]['img_src']		= $row['video_server_url'].$videos_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$row['video_ext'];
						$displayvideoList_arr['row'][$inc]['large_img_src']		= $row['video_server_url'].$videos_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['large_name'].'.'.$row['video_ext'];
						$displayvideoList_arr['row'][$inc]['large_img_src']		= $row['video_server_url'].$videos_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['large_name'].'.'.$row['video_ext'];
						$inc++;
					}
				$smartyObj->assign('displayvideoList_arr', $displayvideoList_arr);
			}

		/**
		 * videoManage::getSearchCondition()
		 *
		 * @return string
		 */
		public function getSearchCondition()
		    {
				$search_condition = '';
				if ($this->fields_arr['srch_uname'])
					{
						$search_condition .= ' AND u.user_name LIKE \'%'.addslashes($this->fields_arr['srch_uname']).'%\'';
					}
				if ($this->fields_arr['srch_title'])
					{
						$search_condition .= ' AND v.video_title LIKE \'%'.addslashes($this->fields_arr['srch_title']).'%\'';
					}
				if ($this->fields_arr['srch_flag'] == 'No')
					{
						$search_condition .= ' AND v.flagged_status != \'Yes\'';
					}
				if ($this->fields_arr['srch_flag'] == 'Yes')
					{
						$search_condition .= ' AND v.flagged_status = \'Yes\'';
					}
				if ($this->fields_arr['srch_categories'])
					{
						$search_condition .= ' AND v.video_category_id = \''.addslashes($this->fields_arr['srch_categories']).'\'';
					}
				if ($this->fields_arr['srch_feature'])
					{
						$search_condition .= ' AND v.featured = \''.addslashes($this->fields_arr['srch_feature']).'\'';
					}
				if ($this->fields_arr['srch_date_added'])
					{
						$search_condition .= ' AND v.date_added >= \''.$this->getFormField('srch_date_added').' 00:00:00\'';
						$search_condition .= ' AND v.date_added <= DATE_ADD(\''.$this->getFormField('srch_date_added').' 00:00:00\', INTERVAL 1 DAY)';
					}
				if ($this->fields_arr['srch_country'])
					{
						$search_condition .= ' AND v.video_country = \''.$this->getFormField('srch_country').'\'';
					}
				if ($this->fields_arr['srch_language'])
					{
						$search_condition .= ' AND v.video_language = \''.$this->getFormField('srch_language').'\'';
					}
				return $search_condition;
		    }


		/**
		 * videoManage::switchCase()
		 * This function handles the switch case statement to extract the values according to the options selected by the admin in the
		 * drop down box.
		 * @param string $casename
		 * @param string $method
		 *
		 * @return void
		 **/
		public function switchCase($casename, $method)
			{
				$search_condition = $this->getSearchCondition();
				switch ($casename)
					{
						case 'videoListAll';
							$this->setTableNames(array($this->CFG['db']['tbl']['video'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 't_width', 't_height', 'video_server_url','video_ext','flagged_status','v.video_id','v.user_id', 'v.video_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'video_category_id', 'video_sub_category_id', 's_height', 's_width', 'is_external_embed_video'));
							$this->sql_condition = 'v.user_id=u.user_id AND v.video_status=\'Ok\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'v.video_id DESC';
							break;

						case 'videoListFeatured';
							$this->setTableNames(array($this->CFG['db']['tbl']['video'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 't_width', 't_height', 'video_server_url','video_ext','flagged_status','v.video_id','v.user_id', 'v.video_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'video_category_id', 'video_sub_category_id', 's_height', 's_width', 'is_external_embed_video'));
							$this->sql_condition = 'v.user_id=u.user_id AND v.video_status=\'Ok\' AND v.featured=\'Yes\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'v.video_id DESC';
							break;

						case 'videoNew';
							$this->setTableNames(array($this->CFG['db']['tbl']['video'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 't_width', 't_height', 'video_server_url','video_ext','flagged_status','v.video_id','v.user_id', 'v.video_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'video_category_id', 'video_sub_category_id', 's_height', 's_width', 'is_external_embed_video'));
							$this->sql_condition = 'v.user_id=u.user_id AND v.video_status=\'Ok\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'v.video_id DESC';
							break;

						case 'videoTopRated';
							$this->setTableNames(array($this->CFG['db']['tbl']['video'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 't_width', 't_height', 'video_server_url','video_ext','flagged_status','v.video_id','v.user_id', 'v.video_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', '(v.rating_total/v.rating_count) as rating', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', 'video_category_id', 'video_sub_category_id', 's_height', 's_width', 'is_external_embed_video'));
							$this->sql_condition = 'v.user_id=u.user_id AND v.video_status=\'Ok\' AND v.rating_total>0 AND v.allow_ratings=\'Yes\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'rating DESC';
							break;

						case 'videoRecentlyViewed':
							$this->setTableNames(array($this->CFG['db']['tbl']['video'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 't_width', 't_height', 'video_server_url','video_ext','flagged_status','v.video_id','v.user_id', 'v.video_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', '(v.rating_total/v.rating_count) as rating', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', 'v.last_view_date as max_view_date', 'video_category_id', 'video_sub_category_id', 's_height', 's_width', 'is_external_embed_video'));

							$this->sql_condition = 'v.user_id=u.user_id AND v.video_status=\'Ok\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'max_view_date DESC';
							break;

						case 'videoMostViewed';
						case 'videoMostViewed-1';
						case 'videoMostViewed-2';
						case 'videoMostViewed-3';
						case 'videoMostViewed-4';
						case 'videoMostViewed-5';
						case 'videoMostViewed-6';
							$this->setTableNames(array($this->CFG['db']['tbl']['video_viewed'].' as vv LEFT JOIN '.$this->CFG['db']['tbl']['video'].' as v ON vv.video_id=v.video_id', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 't_width', 't_height', 'video_server_url','video_ext','flagged_status','v.video_id','v.user_id', 'v.video_title', 'DATE_FORMAT(vv.view_date,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'video_category_id', 'video_sub_category_id','SUM(vv.total_views) as sum_total_views', 's_height', 's_width', 'is_external_embed_video'));

							$extra_query = '';
							if($casename == 'videoMostViewed-1' || $casename == 'videoMostViewed')
								{
									$extra_query = '';
								}
							if($casename == 'videoMostViewed-2')
								{
									$extra_query = ' AND DATE_FORMAT(vv.view_date,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
								}
							if($casename == 'videoMostViewed-3')
								{
									$extra_query = ' AND DATE_FORMAT(vv.view_date,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
								}
							if($casename == 'videoMostViewed-4')
								{
									$extra_query = ' AND DATE_FORMAT(vv.view_date,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
								}
							if($casename == 'videoMostViewed-5')
								{
									$extra_query = ' AND DATE_FORMAT(vv.view_date,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
								}
							if($casename == 'videoMostViewed-6')
								{
									$extra_query = ' AND DATE_FORMAT(vv.view_date,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
								}

							$this->sql_condition = 'v.user_id=u.user_id AND v.video_status=\'Ok\' AND v.total_views>0'.$extra_query;
							$this->sql_condition .= $search_condition;
							$this->sql_condition .= ' GROUP BY vv.video_id';
							$this->sql_sort = 'sum_total_views DESC';
							break;

						case 'videoMostDiscussed';
						case 'videoMostDiscussed-1';
						case 'videoMostDiscussed-2';
						case 'videoMostDiscussed-3';
						case 'videoMostDiscussed-4';
						case 'videoMostDiscussed-5';
						case 'videoMostDiscussed-6';
							$this->setTableNames(array($this->CFG['db']['tbl']['video_comments'].' as vc LEFT JOIN '.$this->CFG['db']['tbl']['video'].' as v ON vc.video_id=v.video_id', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 't_width', 't_height', 'video_server_url','video_ext','flagged_status','video_title','v.video_id','v.user_id', 'DATE_FORMAT(vc.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'video_category_id', 'video_sub_category_id','count( vc.video_comment_id ) as total_comments', 's_height', 's_width', 'is_external_embed_video'));
							$extra_query = '';
							if($casename == 'videoMostDiscussed-1' || $casename == 'videoMostDiscussed')
								{

									$extra_query = '';
								}
							if($casename == 'videoMostDiscussed-2')
								{
									$extra_query = ' AND DATE_FORMAT(vc.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
								}
							if($casename == 'videoMostDiscussed-3')
								{
									$extra_query = ' AND DATE_FORMAT(vc.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
								}
							if($casename == 'videoMostDiscussed-4')
								{
									$extra_query = ' AND DATE_FORMAT(vc.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
								}
							if($casename == 'videoMostDiscussed-5')
								{
									$extra_query = ' AND DATE_FORMAT(vc.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
								}
							if($casename == 'videoMostDiscussed-6')
								{
									$extra_query = ' AND DATE_FORMAT(vc.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
								}
							$this->sql_condition = 'v.user_id=u.user_id AND v.video_status=\'Ok\' AND comment_status=\'Yes\' AND v.total_comments>0'.$extra_query;
							$this->sql_condition .= $search_condition;
							$this->sql_condition .= ' GROUP BY vc.video_id';
							$this->sql_sort = 'total_comments DESC, total_views DESC ';
							break;

						case 'videoTopFavorites';
						case 'videoTopFavorites-1';
						case 'videoTopFavorites-2';
						case 'videoTopFavorites-3';
						case 'videoTopFavorites-4';
						case 'videoTopFavorites-5';
						case 'videoTopFavorites-6';
							$this->setTableNames(array($this->CFG['db']['tbl']['video_favorite'].' as vf LEFT JOIN '.$this->CFG['db']['tbl']['video'].' as v ON vf.video_id=v.video_id', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 't_width', 't_height', 'video_server_url','video_ext','flagged_status','v.video_id','v.user_id', 'v.video_title', 'DATE_FORMAT(vf.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'video_category_id', 'video_sub_category_id' ,'count( vf.video_favorite_id ) as total_favorite', 's_height', 's_width', 'is_external_embed_video'));
							$extra_query = '';
							if($casename == 'videoTopFavorites-1' || $casename == 'videoTopFavorites')
								{
									$extra_query = '';
								}
							if($casename == 'videoTopFavorites-2')
								{
									$extra_query = ' AND DATE_FORMAT(vf.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
								}
							if($casename == 'videoTopFavorites-3')
								{
									$extra_query = ' AND DATE_FORMAT(vf.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
								}
							if($casename == 'videoTopFavorites-4')
								{
									$extra_query = ' AND DATE_FORMAT(vf.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
								}
							if($casename == 'videoTopFavorites-5')
								{
									$extra_query = ' AND DATE_FORMAT(vf.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
								}
							if($casename == 'videoTopFavorites-6')
								{
									$extra_query = ' AND DATE_FORMAT(vf.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
								}
						$this->sql_condition = 'v.user_id=u.user_id AND v.video_status=\'Ok\' AND v.total_favorites>0'.$extra_query;
						$this->sql_condition .= $search_condition;
						$this->sql_condition .= ' GROUP BY vf.video_id';
						$this->sql_sort = 'total_favorite DESC, total_views DESC ';
						break;
				}


			}

		/**
		 * videoManage::switchCase()
		 * This function is used to set the flag for the video.
		 *
		 * @return boolean
		 **/
		public function deleteVideo()
			{
				$video_details = explode(',', $this->fields_arr['checkbox']);
				if($this->fields_arr['action']=='Delete')
					{
						if ($this->CFG['admin']['is_demo_site'])
							{
								$this->setCommonSuccessMsg($this->LANG['general_config_not_allow_demo_site']);
								$this->setPageBlockShow('block_msg_form_success');
								$this->demo_site = true;
								return false;
							}
						else
							{
								foreach($video_details as $video_key=>$video_value)
									{
										$video_arr = explode('-',$video_value);
										$video_id = $video_arr[0];
										$user_id = $video_arr[1];
										$videoHandler = new VideoHandler();
										$videoHandler->deleteVideos(array($video_id), $user_id);
									}
							}
					}
				else if($this->fields_arr['action']=='Flag')
					{
						foreach($video_details as $video_key=>$video_value)
							{
								$video_arr = explode('-',$video_value);
								$flag[] = $video_arr[0];
							}
						$video_list = implode(',',$flag);

						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
								' content_type=\'Video\' AND content_id IN('.$video_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET flagged_status=\'Yes\''.
								' WHERE video_id IN('.$video_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

					}
				else if($this->fields_arr['action']=='UnFlag')
					{
						foreach($video_details as $video_key=>$video_value)
							{
								$video_arr = explode('-',$video_value);
								$flag[] = $video_arr[0];
							}
						$video_list = implode(',',$flag);

						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
								' content_type=\'Video\' AND content_id IN('.$video_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET flagged_status=\'No\''.
								' WHERE video_id IN('.$video_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
				else if($this->fields_arr['action']=='Featured')
					{
						foreach($video_details as $video_key=>$video_value)
							{
								$video_arr = explode('-',$video_value);
								$flag[] = $video_arr[0];
							}
						$video_list = implode(',',$flag);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET featured=\'Yes\''.
								' WHERE video_id IN('.$video_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
				else if($this->fields_arr['action']=='UnFeatured')
					{
						foreach($video_details as $video_key=>$video_value)
							{
								$video_arr = explode('-',$video_value);
								$flag[] = $video_arr[0];
							}
						$video_list = implode(',',$flag);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET featured=\'No\''.
								' WHERE video_id IN('.$video_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
					}
				else if($this->fields_arr['action']=='Move')
					{
						foreach($video_details as $video_key=>$video_value)
							{
								$video_arr = explode('-',$video_value);
								$flag[] = $video_arr[0];
							}
						$video_list = implode(',',$flag);

						if($parent_id=$this->isParentExists($this->fields_arr['video_categories']))
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET '.
										' video_category_id= \''.$parent_id.'\', '.
										' video_sub_category_id = \''.$this->fields_arr['video_categories'].'\' '.
										' WHERE video_id IN('.$video_list.')';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
							}
						else
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['video'].' SET '.
										' video_sub_category_id=0, video_category_id='.$this->dbObj->Param('video_categories').
										' WHERE video_id IN('.$video_list.')';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['video_categories']));
								if (!$rs)
									trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
							}
					}
				return true;
			}

		/**
		 * videoManage::isParentExists()
		 *
		 * @param Integer $cid
		 * @return boolean
		 */
		public function isParentExists($cid)
			{
				$sql = 'SELECT parent_category_id FROM '.$this->CFG['db']['tbl']['video_category']. ' WHERE video_category_id =\''.$cid.'\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);

				if($row = $rs->FetchRow())
					{
						return $row['parent_category_id'];
					}
				return false;
			}
	}
//<<<<<-------------- Class obj begins ---------------//
//-------------------- Code begins -------------->>>>>//
$obj = new videoManage();
$CFG['browsevideos'] = array('videoListAll'=>$LANG['nav_list_all_videos'], 'videoListFeatured'=>$LANG['nav_list_featured_videos'], 'videoNew'=>$LANG['nav_video_new'],'videoTopRated'=>$LANG['nav_top_rated'],'videoMostViewed'=>$LANG['nav_most_viewed'],'videoMostDiscussed'=>$LANG['nav_most_discussed'],'videoTopFavorites'=>$LANG['nav_most_favorite'],'videoRecentlyViewed'=>$LANG['nav_recently_viewed']);
$CFG['options'] = array('1'=>$LANG['all_time'],'2'=>$LANG['today'],'3'=>$LANG['yesterday'],'4'=>$LANG['this_week'],'5'=>$LANG['this_month'],'6'=>$LANG['this_year']);
$obj->setPageBlockNames(array('browse_videos', 'form_search', 'list_video_form', 'set_flag'));
//default form fields and values...
$obj->setReturnColumns(array());
$obj->setTableNames(array());
$obj->setFormField('list', '');
$obj->setFormField('video_id', '');
$obj->setFormField('submit', '');
$obj->setFormField('subcancel', '');
$obj->setFormField('action', '');
$obj->setFormField('delete', '');
$obj->setFormField('confirmdel', '');
$obj->setFormField('checkbox', array());
$obj->setFormField('srch_uname', '');
$obj->setFormField('srch_title', '');
$obj->setFormField('srch_flag', '');
$obj->setFormField('srch_feature', '');
$obj->setFormField('srch_date_added', '');
$obj->setFormField('srch_date', '');
$obj->setFormField('srch_month', '');
$obj->setFormField('srch_year', '');
$obj->setFormField('srch_categories', '');
$obj->setFormField('srch_country', '');
$obj->setFormField('srch_language', '');
$obj->setFormField('video_categories', '');
$obj->setMonthsListArr($LANG_LIST_ARR['months']);
$obj->setFormField('check_box', '');
$obj->setFormField('video_options', '');
/*********** Page Navigation Start *********/
$obj->setFormField('slno', '1');
$obj->populateVideoCategory();
/************ page Navigation stop *************/
$obj->setAllPageBlocksHide();
$obj->setPageBlockShow('browse_videos');
/******************************************************/

$obj->LANG_COUNTRY_ARR = $LANG_LIST_ARR['countries'];
$obj->LANG_LANGUAGE_ARR = $LANG_LIST_ARR['language'];

$obj->setTableNames(array($obj->CFG['db']['tbl']['video'].' as v LEFT JOIN '.$obj->CFG['db']['tbl']['users'].' as u ON v.user_id=u.user_id AND u.usr_status=\'Ok\''));
$obj->setReturnColumns(array('v.video_id', 't_width', 't_height', 'video_server_url','video_ext','v.user_id', 'v.video_title', 'DATE_FORMAT(v.date_added,\''.$obj->CFG['format']['date'].'\') as date_added', 'u.user_name', 'u.first_name', 'u.last_name', 'v.featured','v.flagged_status','v.video_status', 'video_category_id', 'v.total_comments', 'video_sub_category_id', 's_height', 's_width', 'is_external_embed_video'));
$obj->sql_condition = 'v.video_status=\'Ok\'';
$obj->sql_sort = 'v.video_id DESC';
//					$obj->setAllPageBlocksHide();
$obj->sanitizeFormInputs($_REQUEST);
$obj->setPageBlockShow('list_video_form');
$obj->setPageBlockShow('form_search');
/******************************************************/
if ($obj->getFormField('srch_date') || $obj->getFormField('srch_month') || $obj->getFormField('srch_year'))
	{
		$obj->chkIsCorrectDate($obj->getFormField('srch_date'), $obj->getFormField('srch_month'), $obj->getFormField('srch_year'), 'srch_date_added', $LANG['videoManage_err_tip_date_empty'], $LANG['videoManage_err_tip_date_invalid']);
    }
$srch_condition = $obj->getSearchCondition();
if ($srch_condition)
	$obj->sql_condition .= $srch_condition;
if($obj->isFormGETed($_GET,'list') && !$obj->isFormGETed($_GET,'action'))
	{
		$casename = $_GET['list'];
		$obj->switchCase($casename, 'get');
	}

if($obj->isFormGETed($_POST,'submit'))
	{
		$casename = $_POST['list'];
		$obj->switchCase($casename, 'post');
	}
if($obj->isFormGETed($_POST,'search'))
	{
		$casename = $_POST['list'];
		$obj->switchCase($casename, 'post');
	}

if($obj->isFormGETed($_POST,'start'))
	{
		$casename = $_POST['list'];
		$obj->switchCase($casename, 'post');
	}
if($obj->isFormGETed($_GET,'list') && $obj->isFormGETed($_GET,'action'))
	{
		$obj->setAllPageBlocksHide();
		$obj->setPageBlockShow('set_flag');
	}
if($obj->isFormGETed($_POST,'subcancel'))
	{
		$casename = $_POST['list'];
		$obj->switchCase($casename, 'post');
	}
if($obj->isFormGETed($_POST,'confirmdel'))
	{

		$casename = $_POST['list'];
		$obj->switchCase($casename, 'post');
		if($obj->deleteVideo())
			{
				$obj->setCommonSuccessMsg($LANG['videoManage_msg_success_delete']);
				$obj->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				if(!$obj->demo_site)
					{
						$obj->setCommonErrorMsg($LANG['videoManage_msg_success_delete_fail']);
						$obj->setPageBlockShow('block_msg_form_error');
					}
			}
	}
//<<<<<-------------------- Code ends----------------------//
$obj->hidden_arr = array('list', 'srch_uname', 'srch_categories', 'srch_title', 'srch_flag', 'srch_feature', 'srch_date', 'srch_month', 'srch_year', 'start');
$obj->current_year = date('Y');
if ($obj->isShowPageBlock('browse_videos'))
    {
    	$obj->browse_videos['list'] = '';
		foreach($CFG['browsevideos'] as $key=>$val)
			{
				if($key == $obj->getFormField('list'))
					{
						$selected = 'selected';
					}
				else
					{
						$selected = '';
					}
				$obj->browse_videos['list'] .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
				if($key == 'videoMostViewed')
					{
						foreach($CFG['options'] as $optkey=>$optval)
							{
								if($key.'-'.$optkey == $obj->getFormField('list'))
									{
										$selected = 'selected';
									}
								else
									{
										$selected = '';
									}
								$obj->browse_videos['list'] .= '<option value="'.$key.'-'.$optkey.'" '.$selected.'>&nbsp;&nbsp;&nbsp;'.$optval.'</option>';
							}
					}
				if($key == 'videoMostDiscussed')
					{
						foreach($CFG['options'] as $optkey=>$optval)
							{
								if($key.'-'.$optkey == $obj->getFormField('list'))
									{
										$selected = 'selected';
									}
								else
									{
										$selected = '';
									}
								$obj->browse_videos['list'] .= '<option value="'.$key.'-'.$optkey.'" '.$selected.'>&nbsp;&nbsp;&nbsp;'.$optval.'</option>';
							}
					}
				if($key == 'videoTopFavorites')
					{
						foreach($CFG['options'] as $optkey=>$optval)
							{
								if($key.'-'.$optkey == $obj->getFormField('list'))
									{
										$selected = 'selected';
									}
								else
									{
										$selected = '';
									}
								$obj->browse_videos['list'] .= '<option value="'.$key.'-'.$optkey.'" '.$selected.'>&nbsp;&nbsp;&nbsp;'.$optval.'</option>';

							}
					}
			}
    }
if ($obj->isShowPageBlock('form_search'))
	{
		$obj->form_search['hidden_arr'] = array('list');
	}
if ($obj->isShowPageBlock('list_video_form'))
    {
		/****** navigtion continue*********/
		$obj->buildSelectQuery();
		$obj->buildQuery();
		$obj->buildSortQuery();
		//$obj->printQuery();
		if($obj->isGroupByQuery())
			$obj->homeExecuteQuery();
		else
			$obj->executeQuery();
		/******* Navigation End ********/
		if($obj->isResultsFound())
			{
				$obj->displayvideoList();
				$smartyObj->assign('smarty_paging_list', $obj->populatePageLinksPOST($obj->getFormField('start'), 'video_manage_form2'));
				$obj->list_video_form['hidden_arr'] = array('list', 'srch_uname', 'srch_categories', 'srch_title',  'srch_flag', 'srch_feature', 'srch_date', 'srch_month', 'srch_year', 'start');
			}
    }
$obj->left_navigation_div = 'videoMain';
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$obj->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'video');
$smartyObj->display('videoManage.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript" >
	var block_arr= new Array('selMsgConfirm');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['videoManage_err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction()
		{
			var act_value = document.video_manage_form2.video_options.value;
			if(act_value)
				{
					switch (act_value)
						{
							case 'Delete':
								confirm_message = '<?php echo $LANG['videoManage_delete'];?>';
								break;
							case 'Flag':
								confirm_message = '<?php echo $LANG['videoManage_status'];?>';
								break;
							case 'UnFlag':
								confirm_message = '<?php echo $LANG['videoManage_status'];?>';
								break;
							case 'Featured':
								confirm_message = '<?php echo $LANG['videoManage_featured'];?>';
								break;
							case 'UnFeatured':
								confirm_message = '<?php echo $LANG['videoManage_unfeatured'];?>';
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
//<<<<<-------------------- Page block templates ends -------------------//
$obj->includeFooter();
?>