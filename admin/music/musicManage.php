<?php
/**
 * This file is to manage the musics
 *
 * This file is having musicManage class to manage the musics
 *
 *
 * @category	Rayzz
 * @package		Admin
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 *
 **/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/music/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/music/admin/musicManage.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MusicHandler.lib.php';
$CFG['site']['is_module_page']='music';
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 *
 * @category	rayzz
 * @package		Admin Music
 **/
class musicManage extends MediaHandler
	{
		public $sql_condition = '';
		public $sql_sort = '';
		public $fields_arr = '';
		public $sql='';
		public $music_category_name = array();
		/**
		 * musicManage::buildConditionQuery()
		 *
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = '';
			}
		/**
		 * musicManage::buildSortQuery()
		 *
		 * @return void
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'v.music_id DESC';
			}
		/**
		 * musicManage::getMusicCategory()
		 *
		 * @param integer $music_category_id
		 * @return array
		 */
		public function getMusicCategory($music_category_id)
			{

				if(isset($this->music_category_name[$music_category_id]))
					return $this->music_category_name[$music_category_id];
				$this->music_category_name[$music_category_id] = '';
				$sql = 'SELECT music_category_name FROM '.$this->CFG['db']['tbl']['music_category'].
						' WHERE music_category_id='.$this->dbObj->Param('music_category_id').' AND 	music_category_status=\'Yes\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_category_id));
				if (!$rs)
					trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
					{
						$this->music_category_name[$music_category_id] = wordWrap_mb_ManualWithSpace($row['music_category_name'], $this->CFG['admin']['musics']['admin_music_channel_title_length']);
					}
				return $this->music_category_name[$music_category_id];
			}
		/**
		 * musicManage::populateMusicCategory()
		 *
		 * @return void
		 */
		public function populateMusicCategory($srch_categories = false)
			{
				$sql = 'SELECT music_category_id, music_category_name FROM '.$this->CFG['db']['tbl']['music_category'].' WHERE 	music_category_status=\'Yes\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);
				$populateMusicCategory='';
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$populateMusicCategory .= '<option value="'.$row['music_category_id'].'" class="selectMusicCategory"';

								if($this->fields_arr['srch_categories']  == $row['music_category_id'])
									$populateMusicCategory .= ' selected="selected"';

								$populateMusicCategory .= '>'.$row['music_category_name'].'</option>';
								if($this->CFG['admin']['musics']['sub_category'])
									{
										$populateMusicCategory .= $this->populateMusicSubCategory($row['music_category_id']);
									}

							}
					}
					return $populateMusicCategory;

			}
		/**
		 * musicManage::populateMusicSubCategory()
		 *
		 * @return void
		 */
		public function populateMusicSubCategory($category_id)
			{

				$populateMusicSubCategory = '';
				$sql = 'SELECT music_category_id, music_category_name FROM '.$this->CFG['db']['tbl']['music_category'].
						' WHERE parent_category_id='.$category_id.' AND music_category_status=\'Yes\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$populateMusicSubCategory .= '<option value="'.$row['music_category_id'].'" class="selectmusicSubCategory"';
								if($this->fields_arr['srch_categories'] == $row['music_category_id'])
									$populateMusicSubCategory .= ' selected="selected"';
								$populateMusicSubCategory .= '>'.$row['music_category_name'].'</option>';
							}
						return $populateMusicSubCategory;
					}
				return ;
			}

		/**
		 * musicManage::displaymusicList()
		 * This method helps to display the list of musics
		 *
		 * @return void
		 **/
		public function displaymusicList()
			{
				global $smartyObj;
				$displaymusicList_arr = array();
				$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
				$displaymusicList_arr['row'] = array();
				$inc = 1;
				while($row = $this->fetchResultRecord())
					{
						if(!isset($row['user_name']))
							{
								$displaymusicList_arr['row'][$inc]['name'] = $this->getUserDetail('user_id', $row['user_id'], 'user_name');
							}
						else
							{
								$name = $this->CFG['format']['name'];
								$name = str_replace('$first_name', $row['first_name'],$name);
								$name = str_replace('$last_name', $row['last_name'],$name);
								$name = str_replace('$user_name', $row['user_name'],$name);
								$displaymusicList_arr['row'][$inc]['name'] = $name;
							}
						$displaymusicList_arr['row'][$inc]['file_path'] = $row['music_server_url'].$thumbnail_folder.getMusicImageName($row['music_id']).$this->CFG['admin']['musics']['small_name'].'.'.$row['music_thumb_ext'];
						$displaymusicList_arr['row'][$inc]['DISP_IMAGE'] = DISP_IMAGE($this->CFG['admin']['musics']['small_width'], $this->CFG['admin']['musics']['small_height'], $row['small_width'], $row['small_height']);
						$row['flagged_status'] = $row['flagged_status']?$row['flagged_status']:'No';
						$row['music_featured'] = $row['music_featured']?$row['music_featured']:'No';
						$displaymusicList_arr['row'][$inc]['comments_text'] = str_replace('{total_comments}', $row['total_comments'], $this->LANG['music_comments']);
						$row['music_title']=wordWrap_mb_Manual($row['music_title'], $this->CFG['admin']['musics']['list_title_length'], $this->CFG['admin']['musics']['list_title_total_length']);
						$displaymusicList_arr['row'][$inc]['musicupload_url']=getUrl('musicuploadpopup','?music_id='.$row['music_id'].'&title='.$this->changeTitle($row['music_title']), $row['music_id'].'/'.$this->changeTitle($row['music_title']).'/','','music');
						$displaymusicList_arr['row'][$inc]['record'] = $row;
						$displaymusicList_arr['row'][$inc]['music_price'] = '';
						if($row['music_price'] > 0)
						$displaymusicList_arr['row'][$inc]['music_price'] = $this->CFG['currency'].$row['music_price'];
						$musics_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['musics']['folder'].'/'.$this->CFG['admin']['musics']['thumbnail_folder'].'/';
						if($row['music_thumb_ext']=='')
							{
								$displaymusicList_arr['row'][$inc]['file_path'] = $this->CFG['site']['url'].'design/templates/'.$this->CFG['html']['template']['default'].'/admin/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_audio_S.jpg';
						    }
						else
							{
								$displaymusicList_arr['row'][$inc]['file_path'] = $row['music_server_url'].$musics_folder.getMusicImageName($row['music_id']).$this->CFG['admin']['musics']['small_name'].'.'.$row['music_thumb_ext'];
							}
						$inc++;
					}
				$smartyObj->assign('displaymusicList_arr', $displaymusicList_arr);


			}

		/**
		 * musicManage::getSearchCondition()
		 *
		 * @return string
		 */
		public function getSearchCondition()
		    {
				$search_condition = '';
				if ($this->fields_arr['srch_uname'])
					{
						$search_condition .= ' AND u.user_name LIKE \'%'.addslashes($this->getFormField('srch_uname')).'%\'';
					}
				if ($this->fields_arr['srch_title'])
					{
						$search_condition .= ' AND v.music_title LIKE \'%'.addslashes($this->getFormField('srch_title')).'%\'';
					}
				if ($this->fields_arr['srch_flag'] == 'No')
					{
						$search_condition .= ' AND v.flagged_status != \'Yes\'';
					}
				if ($this->fields_arr['srch_flag'] == 'Yes')
					{
						$search_condition .= ' AND v.flagged_status = \'Yes\'';
					}
				if ($this->fields_arr['srch_feature'] == 'Yes')
					{
						$search_condition .= ' AND v.music_featured = \'Yes\'';
					}

				if ($this->fields_arr['srch_feature'] == 'No')
					{
						$search_condition .= ' AND v.music_featured = \'No\'';
					}

				if ($this->fields_arr['srch_categories'])
					{
						$search_condition .= ' AND v.music_category_id = \''.addslashes($this->getFormField('srch_categories')).'\'';
					}
				if ($this->fields_arr['srch_date_added'])
					{
						$search_condition .= ' AND v.date_added >= \''.$this->getFormField('srch_date_added').' 00:00:00\'';
						$search_condition .= ' AND v.date_added <= DATE_ADD(\''.$this->getFormField('srch_date_added').' 00:00:00\', INTERVAL 1 DAY)';

					}
				return $search_condition;
		    }
		/**
		 * musicManage::switchCase()
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
						case 'musicListAll';
							$this->setTableNames(array($this->CFG['db']['tbl']['music'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.music_featured', 'v.thumb_width', 'v.thumb_height', 'music_server_url','music_ext','flagged_status','v.music_id','v.user_id', 'v.music_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'music_category_id', 'music_sub_category_id', 'v.small_height', 'v.small_width', 'v.music_price'));
							$this->sql_condition = 'v.user_id=u.user_id AND v.music_status=\'Ok\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'v.music_id DESC';
							break;
						case 'musicNew';
							$this->setTableNames(array($this->CFG['db']['tbl']['music'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.music_featured', 'v.thumb_width', 'v.thumb_height', 'music_server_url','music_ext','flagged_status','v.music_id','v.user_id', 'v.music_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'music_category_id', 'music_sub_category_id', 'v.small_height', 'v.small_width', 'v.music_price'));
							$this->sql_condition = 'v.user_id=u.user_id AND v.music_status=\'Ok\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'v.date_added DESC';
							break;
						case 'musicTopRated';
							$this->setTableNames(array($this->CFG['db']['tbl']['music'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.music_featured', 'v.thumb_width', 'v.thumb_height', 'music_server_url','music_ext','flagged_status','v.music_id','v.user_id', 'v.music_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', '(v.rating_total/v.rating_count) as rating', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', 'music_category_id', 'music_sub_category_id', 'v.small_height', 'v.small_width', 'v.music_price'));
							$this->sql_condition = 'v.user_id=u.user_id AND v.music_status=\'Ok\' AND v.rating_total>0 AND v.allow_ratings=\'Yes\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'rating DESC';
							break;
						case 'musicRecentlyViewed':
							$this->setTableNames(array($this->CFG['db']['tbl']['music'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.music_featured', 'v.thumb_width', 'v.thumb_height', 'music_server_url','music_ext','flagged_status','v.music_id','v.user_id', 'v.music_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', '(v.rating_total/v.rating_count) as rating', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', 'v.last_view_date as max_view_date', 'music_category_id', 'music_sub_category_id', 'v.small_height', 'v.small_width', 'v.music_price'));
							$this->sql_condition = 'v.user_id=u.user_id AND v.music_status=\'Ok\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'max_view_date DESC';
							break;
						case 'musicMostViewed';
						case 'musicMostViewed-1';
						case 'musicMostViewed-2';
						case 'musicMostViewed-3';
						case 'musicMostViewed-4';
						case 'musicMostViewed-5';
						case 'musicMostViewed-6';
							$this->setTableNames(array($this->CFG['db']['tbl']['music_viewed'].' as mv LEFT JOIN '.$this->CFG['db']['tbl']['music'].' as v ON mv.music_id=v.music_id', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.music_featured', 'v.thumb_width', 'v.thumb_height', 'music_server_url','music_ext','flagged_status','v.music_id','v.user_id', 'v.music_title', 'DATE_FORMAT(mv.last_viewed,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'music_category_id', 'music_sub_category_id','SUM(mv.total_views) as sum_total_views', 'v.small_height', 'v.small_width', 'v.music_price'));
							$extra_query = '';
							if($casename == 'musicMostViewed-1' || $casename == 'musicMostViewed')
								{
									$extra_query = '';
								}
							if($casename == 'musicMostViewed-2')
								{
									$extra_query = ' AND DATE_FORMAT(mv.last_viewed,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
								}
							if($casename == 'musicMostViewed-3')
								{
									$extra_query = ' AND DATE_FORMAT(mv.last_viewed,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
								}
							if($casename == 'musicMostViewed-4')
								{
									$extra_query = ' AND DATE_FORMAT(mv.last_viewed,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
								}
							if($casename == 'musicMostViewed-5')
								{
									$extra_query = ' AND DATE_FORMAT(mv.last_viewed,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
								}
							if($casename == 'musicMostViewed-6')
								{
									$extra_query = ' AND DATE_FORMAT(mv.last_viewed,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
								}
							$this->sql_condition = 'v.user_id=u.user_id AND v.music_status=\'Ok\' AND v.total_views>0'.$extra_query;
							$this->sql_condition .= $search_condition;
							$this->sql_condition .= ' GROUP BY mv.music_id';
							$this->sql_sort = 'sum_total_views DESC';
							break;
						case 'musicMostDiscussed';
						case 'musicMostDiscussed-1';
						case 'musicMostDiscussed-2';
						case 'musicMostDiscussed-3';
						case 'musicMostDiscussed-4';
						case 'musicMostDiscussed-5';
						case 'musicMostDiscussed-6';
							$this->setTableNames(array($this->CFG['db']['tbl']['music_comments'].' as ms LEFT JOIN '.$this->CFG['db']['tbl']['music'].' as v ON ms.music_id=v.music_id', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.music_featured', 'v.thumb_width', 'v.thumb_height', 'music_server_url','music_ext','flagged_status','music_title','v.music_id','v.user_id', 'DATE_FORMAT(ms.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'music_category_id', 'music_sub_category_id','count( ms.music_comment_id ) as total_comments', 'v.small_height', 'v.small_width', 'v.music_price'));
							$extra_query = '';
							if($casename == 'musicMostDiscussed-1' || $casename == 'musicMostDiscussed')
								{

									$extra_query = '';
								}
							if($casename == 'musicMostDiscussed-2')
								{
									$extra_query = ' AND DATE_FORMAT(ms.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
								}
							if($casename == 'musicMostDiscussed-3')
								{
									$extra_query = ' AND DATE_FORMAT(ms.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
								}
							if($casename == 'musicMostDiscussed-4')
								{
									$extra_query = ' AND DATE_FORMAT(ms.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
								}
							if($casename == 'musicMostDiscussed-5')
								{
									$extra_query = ' AND DATE_FORMAT(ms.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
								}
							if($casename == 'musicMostDiscussed-6')
								{
									$extra_query = ' AND DATE_FORMAT(ms.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
								}
							$this->sql_condition = 'v.user_id=u.user_id AND v.music_status=\'Ok\' AND comment_status=\'Yes\' AND v.total_comments>0'.$extra_query;
							$this->sql_condition .= $search_condition;
							$this->sql_condition .= ' GROUP BY ms.music_id';
							$this->sql_sort = 'total_comments DESC, total_views DESC ';
							break;
						case 'musicTopFavorites';
						case 'musicTopFavorites-1';
						case 'musicTopFavorites-2';
						case 'musicTopFavorites-3';
						case 'musicTopFavorites-4';
						case 'musicTopFavorites-5';
						case 'musicTopFavorites-6';
							$this->setTableNames(array($this->CFG['db']['tbl']['music_favorite'].' as mf LEFT JOIN '.$this->CFG['db']['tbl']['music'].' as v ON mf.music_id=v.music_id', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.music_featured', 'v.thumb_width', 'v.thumb_height', 'music_server_url','music_ext','flagged_status','v.music_id','v.user_id', 'v.music_title', 'DATE_FORMAT(mf.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'music_category_id', 'music_sub_category_id' ,'count( mf.music_favorite_id ) as total_favorite', 'v.small_height', 'v.small_width', 'v.music_price'));
							$extra_query = '';
							if($casename == 'musicTopFavorites-1' || $casename == 'musicTopFavorites')
								{
									$extra_query = '';
								}
							if($casename == 'musicTopFavorites-2')
								{
									$extra_query = ' AND DATE_FORMAT(mf.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
								}
							if($casename == 'musicTopFavorites-3')
								{
									$extra_query = ' AND DATE_FORMAT(mf.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
								}
							if($casename == 'musicTopFavorites-4')
								{
									$extra_query = ' AND DATE_FORMAT(mf.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
								}
							if($casename == 'musicTopFavorites-5')
								{
									$extra_query = ' AND DATE_FORMAT(mf.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
								}
							if($casename == 'musicTopFavorites-6')
								{
									$extra_query = ' AND DATE_FORMAT(mf.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
								}
						$this->sql_condition = 'v.user_id=u.user_id AND v.music_status=\'Ok\' AND v.total_favorites>0'.$extra_query;
						$this->sql_condition .= $search_condition;
						$this->sql_condition .= ' GROUP BY mf.music_id';
						$this->sql_sort = 'total_favorite DESC, total_views DESC ';
						break;
				}
			}

		/**
		 * musicManage::switchCase()
		 * This function is used to set the flag for the music.
		 *
		 * @return boolean
		 **/
		public function deleteMusic()
			{
				$music_details = explode(',', $this->fields_arr['checkbox']);
				if($this->fields_arr['action']=='Delete')
					{
						foreach($music_details as $music_key=>$music_value)
							{
								$music_arr = explode('-',$music_value);
								$music_id = $music_arr[0];
								$user_id = $music_arr[1];
								$musicHandler = new MusicHandler();
								$musicHandler->deleteMusics(array($music_id), $user_id);
							}
					}
				else if($this->fields_arr['action']=='Flag')
					{
						foreach($music_details as $music_key=>$music_value)
							{
								$music_arr = explode('-',$music_value);
								$flag[] = $music_arr[0];
							}
						$music_list = implode(',',$flag);

						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
								' content_type=\'Music\' AND content_id IN('.$music_list.')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET flagged_status=\'Yes\''.
								' WHERE music_id IN('.$music_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

					}
				else if($this->fields_arr['action']=='UnFlag')
					{
						foreach($music_details as $music_key=>$music_value)
							{
								$music_arr = explode('-',$music_value);
								$flag[] = $music_arr[0];
							}
						$music_list = implode(',',$flag);

						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
								' content_type=\'Music\' AND content_id IN('.$music_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET flagged_status=\'No\''.
								' WHERE music_id IN('.$music_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);
					}
				else if($this->fields_arr['action']=='Move')
					{
						foreach($music_details as $music_key=>$music_value)
							{
								$music_arr = explode('-',$music_value);
								$flag[] = $music_arr[0];
							}
						$music_list = implode(',',$flag);

						if($parent_id=$this->isParentExists($this->fields_arr['music_categories']))
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET '.
										' music_category_id= \''.$parent_id.'\', '.
										' music_sub_category_id = \''.$this->fields_arr['music_categories'].'\' '.
										' WHERE music_id IN('.$music_list.')';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							}
						else
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET '.
										' music_sub_category_id=0, music_category_id='.$this->dbObj->Param('music_categories').
										' WHERE music_id IN('.$music_list.')';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['music_categories']));
								if (!$rs)
									trigger_db_error($this->dbObj);
							}
					}
				return true;
			}

		/**
		 * musicManage::isParentExists()
		 *
		 * @param Integer $cid
		 * @return boolean
		 */
		public function isParentExists($cid)
			{
				$sql = 'SELECT parent_category_id FROM '.$this->CFG['db']['tbl']['music_category']. ' WHERE music_category_id =\''.$cid.'\'';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				if($row = $rs->FetchRow())
					{
						return $row['parent_category_id'];
					}
				return false;
			}
		/**
		 * musicManage::getTotalLyric()
		 *
		 * @param mixed $music_id
		 * @return
		 */
		public function getTotalLyric($music_id)
			{
				$sql = 'SELECT count(music_lyric_id) as total_lyrics  FROM '.$this->CFG['db']['tbl']['music_lyric'].' '.
						'WHERE music_id = '.$this->dbObj->Param('music_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($music_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['total_lyrics'];
			}
	public function chkFeatureMusicStatus()
			{
				$music_details = explode(',', $this->fields_arr['checkbox']);
				foreach($music_details as $music_key=>$music_value)
				{
					$music_arr = explode('-',$music_value);
					$flag[] = $music_arr[0];
				}
				$music_list = implode(',',$flag);
				$inc=1;
				foreach($flag as $key=>$val)
				{
					$sql = 'SELECT music_featured FROM '.$this->CFG['db']['tbl']['music'].
					' WHERE music_id='.$val;
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
					trigger_db_error($this->dbObj);
					if($row = $rs->FetchRow())
					{
						$music_featured=$row['music_featured'];
					}
					if($music_featured=='Yes')
					{
						return false;
					}
					else
					{
					   return true;
					}
				}
			}
		public function chkFeatureMusicCounts()
			{

				global $CFG;
				$music_details = explode(',', $this->fields_arr['checkbox']);
				foreach($music_details as $music_key=>$music_value)
				{
					$music_arr = explode('-',$music_value);
					$flag[] = $music_arr[0];
				}
				$cnt=count($flag);
				if($cnt>$CFG['admin']['musics']['music_manage_count'])
				{
					return false;
				}
				$sql = 'SELECT count(music_id) as total_count FROM '.$this->CFG['db']['tbl']['music'].
				' WHERE music_featured=\'Yes\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
				trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
				{
					$count=$row['total_count'];
				}
				if($count<=$CFG['admin']['musics']['music_manage_count'])
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		public function chkFeaturedMusic()
		{

			global $CFG;
			$featured_count='';
			$count='';
			$music_details = explode(',', $this->fields_arr['checkbox']);
			foreach($music_details as $music_key=>$music_value)
			{
				$music_arr = explode('-',$music_value);
				$flag[] = $music_arr[0];
			}
			$music_list = implode(',',$flag);
			$sql = 'SELECT count(music_id) as total_count,max(featured_music_order_id) as featured_count FROM '
			.$this->CFG['db']['tbl']['music'].' WHERE music_featured=\'Yes\' GROUP BY music_id';
			$stmt = $this->dbObj->Prepare($sql);
			$rs = $this->dbObj->Execute($stmt);
			if (!$rs)
			trigger_db_error($this->dbObj);
			if($row = $rs->FetchRow())
			{
				$count=$row['total_count'];
				$featured_count=$row['featured_count'];
			}
			if($count<=$CFG['admin']['musics']['music_manage_count'])
			{
				$inc=1;
				foreach($flag as $key=>$val)
				{
					$featuredcnt=$featured_count+$inc;
					$sql = 'SELECT featured_music_order_id FROM '
					.$this->CFG['db']['tbl']['music'].' WHERE music_id=('.$val.')';
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
					trigger_db_error($this->dbObj);
					if($row = $rs->FetchRow())
					{
						$featured_count_status=$row['featured_music_order_id'];
					}
					if($featured_count_status=='' || $featured_count_status=='0')
					{
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET music_featured=\'Yes\',
						featured_music_order_id= '.$featuredcnt. ' WHERE music_id=('.$val.')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
						trigger_db_error($this->dbObj);
					}
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET music_featured=\'Yes\'
					WHERE music_id=('.$val.')';
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
					trigger_db_error($this->dbObj);
					$inc++;
				}

				return true;
			}
			else
			{
				return false;
			}
		}
		public function chkUpdateFeaturedMusic()
		{
			$music_details = explode(',', $this->fields_arr['checkbox']);
			foreach($music_details as $music_key=>$music_value)
			{
				$music_arr = explode('-',$music_value);
				$flag[] = $music_arr[0];
			}
			$music_list = implode(',',$flag);
			$status=0;
			$inc=0;
			foreach($flag as $key=>$val)
				{
					$sql = 'UPDATE '.$this->CFG['db']['tbl']['music'].' SET music_featured=\'No\', featured_music_order_id= '.$status.
					       ' WHERE music_id='.$val;
					$stmt = $this->dbObj->Prepare($sql);
					$rs = $this->dbObj->Execute($stmt);
					if (!$rs)
					trigger_db_error($this->dbObj);
					$inc++;
		        }
		}
}
//<<<<<-------------- Class obj begins ---------------//
//-------------------- Code begins -------------->>>>>//
$musicManage = new musicManage();
$CFG['browsemusics'] = array('musicListAll'=>$LANG['nav_list_all_musics'],'musicNew'=>$LANG['nav_music_new'],'musicTopRated'=>$LANG['nav_top_rated'],'musicMostViewed'=>$LANG['nav_most_viewed'],'musicMostDiscussed'=>$LANG['nav_most_discussed'],'musicTopFavorites'=>$LANG['nav_most_favorite'],'musicRecentlyViewed'=>$LANG['nav_recently_viewed']);
$CFG['options'] = array('1'=>$LANG['all_time'],'2'=>$LANG['today'],'3'=>$LANG['yesterday'],'4'=>$LANG['this_week'],'5'=>$LANG['this_month'],'6'=>$LANG['this_year']);
$musicManage->setPageBlockNames(array('browse_musics', 'form_search', 'list_music_form', 'set_flag'));
$musicManage->setReturnColumns(array());
$musicManage->setTableNames(array());
$musicManage->setFormField('list', '');
$musicManage->setFormField('music_id', '');
$musicManage->setFormField('submit', '');
$musicManage->setFormField('subcancel', '');
$musicManage->setFormField('action', '');
$musicManage->setFormField('delete', '');
$musicManage->setFormField('confirmdel', '');
$musicManage->setFormField('checkbox', array());
$musicManage->setFormField('srch_uname', '');
$musicManage->setFormField('srch_title', '');
$musicManage->setFormField('srch_flag', '');
$musicManage->setFormField('srch_feature', '');
$musicManage->setFormField('srch_date_added', '');
$musicManage->setFormField('srch_date', '');
$musicManage->setFormField('srch_month', '');
$musicManage->setFormField('srch_year', '');
$musicManage->setFormField('srch_categories', '');
$musicManage->setFormField('music_categories', '');
$musicManage->setMonthsListArr($LANG_LIST_ARR['months']);
$musicManage->setFormField('check_box', '');
$musicManage->setFormField('music_options', '');
/*********** Page Navigation Start *********/
$musicManage->setFormField('slno', '1');
$musicManage->populateMusicCategory();
/************ page Navigation stop *************/
$musicManage->setAllPageBlocksHide();
$musicManage->setPageBlockShow('browse_musics');
/******************************************************/
$musicManage->setTableNames(array($musicManage->CFG['db']['tbl']['music'].' as v LEFT JOIN '.$musicManage->CFG['db']['tbl']['users'].' as u ON v.user_id=u.user_id AND u.usr_status=\'Ok\''));
$musicManage->setReturnColumns(array('v.music_id','v.thumb_width','v.thumb_height', 'music_server_url','music_ext','v.user_id', 'v.music_title', 'DATE_FORMAT(v.date_added,\''.$musicManage->CFG['format']['date'].'\') as date_added', 'u.user_name', 'u.first_name', 'u.last_name', 'v.music_featured','v.flagged_status','v.music_status', 'music_category_id', 'v.total_comments', 'music_sub_category_id','v.small_height','v.small_width','v.music_thumb_ext','v.music_price'));
$musicManage->sql_condition = 'v.music_status=\'Ok\'';
$musicManage->sql_sort = 'v.music_id DESC';
$musicManage->sanitizeFormInputs($_REQUEST);
$musicManage->setPageBlockShow('list_music_form');
$musicManage->setPageBlockShow('form_search');
/******************************************************/
if ($musicManage->getFormField('srch_date') || $musicManage->getFormField('srch_month') || $musicManage->getFormField('srch_year'))
	{
		$musicManage->chkIsCorrectDate($musicManage->getFormField('srch_date'), $musicManage->getFormField('srch_month'), $musicManage->getFormField('srch_year'), 'srch_date_added', $LANG['musicManage_err_tip_date_empty'], $LANG['musicManage_err_tip_date_invalid']);
    }
$srch_condition = $musicManage->getSearchCondition();
if ($srch_condition)
	$musicManage->sql_condition .= $srch_condition;
if($musicManage->isFormGETed($_GET,'list') && !$musicManage->isFormGETed($_GET,'action'))
	{
		$casename = $_GET['list'];
		$musicManage->switchCase($casename, 'get');
	}
if($musicManage->isFormGETed($_POST,'submit'))
	{
		$casename = $_POST['list'];
		$musicManage->switchCase($casename, 'post');
	}
if($musicManage->isFormGETed($_POST,'search'))
	{
		$casename = $_POST['list'];
		$musicManage->switchCase($casename, 'post');
	}

if($musicManage->isFormGETed($_POST,'start'))
	{
		$casename = $_POST['list'];
		$musicManage->switchCase($casename, 'post');
	}
if($musicManage->isFormGETed($_GET,'list') && $musicManage->isFormGETed($_GET,'action'))
	{
		$musicManage->setAllPageBlocksHide();
		$musicManage->setPageBlockShow('set_flag');
	}
if($musicManage->isFormGETed($_POST,'subcancel'))
	{
		$casename = $_POST['list'];
		$musicManage->switchCase($casename, 'post');
	}
if($musicManage->isFormGETed($_POST,'confirmdel'))
{
	$casename = $_POST['list'];
	$musicManage->switchCase($casename, 'post');
	if($musicManage->getFormField('action')=='Featured' )
	{

		if($musicManage->chkFeatureMusicStatus())
		{
			if($musicManage->chkFeatureMusicCounts())
			{
				$musicManage->chkFeaturedMusic();
				$musicManage->setCommonSuccessMsg($LANG['musicManage_msg_success_delete']);
				$musicManage->setPageBlockShow('block_msg_form_success');
			}
			else
			{
				$featured_music_limit = str_replace('{featuredcount}', $CFG['admin']['musics']['music_manage_count'],
													$LANG['musicManage_manage_featured_limit']);
				$musicManage->setCommonSuccessMsg($featured_music_limit);
				$musicManage->setPageBlockShow('block_msg_form_success');
			}
		}
		else
		{
				$musicManage->setCommonSuccessMsg($LANG['musicManage_manage_featured_music_already_featured']);
				$musicManage->setPageBlockShow('block_msg_form_success');
		}
	}
	if($musicManage->getFormField('action')=='UnFeatured')
	{
		$musicManage->chkUpdateFeaturedMusic();
		$musicManage->setCommonSuccessMsg($LANG['musicManage_msg_success_delete']);
		$musicManage->setPageBlockShow('block_msg_form_success');
	}
	if($musicManage->getFormField('action')!='Featured')
	{
		if($musicManage->deleteMusic())
		{
			$musicManage->setCommonSuccessMsg($LANG['musicManage_msg_success_delete']);
			$musicManage->setPageBlockShow('block_msg_form_success');
		}
		else
		{
			$musicManage->setCommonErrorMsg($LANG['musicManage_msg_success_delete_fail']);
			$musicManage->setPageBlockShow('block_msg_form_error');
		}
	}
}
//<<<<<-------------------- Code ends----------------------//
$musicManage->hidden_arr = array('list', 'srch_uname', 'srch_categories', 'srch_title', 'srch_flag', 'srch_feature', 'srch_date', 'srch_month', 'srch_year', 'start');
$musicManage->current_year = date('Y');
if ($musicManage->isShowPageBlock('browse_musics'))
    {
    	$musicManage->browse_musics['list'] = '';
		foreach($CFG['browsemusics'] as $key=>$val)
			{
				if($key == $musicManage->getFormField('list'))
					{
						$selected = 'selected';
					}
				else
					{
						$selected = '';
					}
				$musicManage->browse_musics['list'] .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
				if($key == 'musicMostViewed')
					{
						foreach($CFG['options'] as $optkey=>$optval)
							{
								if($key.'-'.$optkey == $musicManage->getFormField('list'))
									{
										$selected = 'selected';
									}
								else
									{
										$selected = '';
									}
								$musicManage->browse_musics['list'] .= '<option value="'.$key.'-'.$optkey.'" '.$selected.'>&nbsp;&nbsp;&nbsp;'.$optval.'</option>';
							}
					}
				if($key == 'musicMostDiscussed')
					{
						foreach($CFG['options'] as $optkey=>$optval)
							{
								if($key.'-'.$optkey == $musicManage->getFormField('list'))
									{
										$selected = 'selected';
									}
								else
									{
										$selected = '';
									}
								$musicManage->browse_musics['list'] .= '<option value="'.$key.'-'.$optkey.'" '.$selected.'>&nbsp;&nbsp;&nbsp;'.$optval.'</option>';
							}
					}
				if($key == 'musicTopFavorites')
					{
						foreach($CFG['options'] as $optkey=>$optval)
							{
								if($key.'-'.$optkey == $musicManage->getFormField('list'))
									{
										$selected = 'selected';
									}
								else
									{
										$selected = '';
									}
								$musicManage->browse_musics['list'] .= '<option value="'.$key.'-'.$optkey.'" '.$selected.'>&nbsp;&nbsp;&nbsp;'.$optval.'</option>';

							}
					}
			}
    }
if ($musicManage->isShowPageBlock('form_search'))
	{
		$musicManage->form_search['hidden_arr'] = array('list');
	}
if ($musicManage->isShowPageBlock('list_music_form'))
    {
		/****** navigtion continue*********/
		$musicManage->buildSelectQuery();
		$musicManage->buildQuery();
		$musicManage->buildSortQuery();
		//$musicManage->printQuery();
		if($musicManage->isGroupByQuery())
			$musicManage->homeExecuteQuery();
		else
			$musicManage->executeQuery();
		//$musicManage->printQuery();
		/******* Navigation End ********/
		if($musicManage->isResultsFound())
			{
				$musicManage->displaymusicList();
				$smartyObj->assign('smarty_paging_list', $musicManage->populatePageLinksPOST($musicManage->getFormField('start'), 'music_manage_form2'));
				$musicManage->list_music_form['hidden_arr'] = array('list', 'srch_uname', 'srch_categories', 'srch_title',  'srch_flag', 'srch_feature', 'srch_date', 'srch_month', 'srch_year', 'start');
			}
    }
$musicManage->left_navigation_div = 'musicMain';
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$musicManage->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'music');
$smartyObj->display('musicManage.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript" >
	var block_arr= new Array('selMsgConfirm');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['musicManage_err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction()
		{
			var act_value = document.music_manage_form2.music_options.value;
			if(act_value)
				{
					switch (act_value)
						{
							case 'Delete':
								confirm_message = '<?php echo $LANG['musicManage_delete'];?>';
								break;
							case 'Flag':
								confirm_message = '<?php echo $LANG['musicManage_status'];?>';
								break;
							case 'UnFlag':
								confirm_message = '<?php echo $LANG['musicManage_status'];?>';
								break;
							case 'Featured':
								confirm_message = '<?php echo $LANG['musicManage_featured'];?>';
								break;
							case 'UnFeatured':
								confirm_message = '<?php echo $LANG['musicManage_unfeatured'];?>';
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
$musicManage->includeFooter();
?>