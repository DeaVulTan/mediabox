<?php
/**
 * This file is to manage the photos
 *
 * This file is having photoManage class to manage the photos
 *
 *
 * @category	Rayzz
 * @package		Admin
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 *
 **/
require_once('../../common/configs/config.inc.php');
$CFG['lang']['include_files'][] = 'languages/%s/photo/common.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/photo/admin/photoManage.php';
$CFG['lang']['include_files'][] = 'languages/%s/common/email_notify.inc.php';
$CFG['lang']['include_files'][] = 'languages/%s/lists_array/months_list_array.inc.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ftp.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_ListRecordsHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_PhotoHandler.lib.php';
$CFG['site']['is_module_page']='photo';

if(isset($_REQUEST['type']) and ($_REQUEST['type'] == 'Preview'))
{
	$CFG['html']['header'] = 'general/html_header_no_header.php';
	$CFG['html']['footer'] = 'general/html_footer_no_footer.php';
	$CFG['mods']['is_include_only']['html_header'] = false;
	$CFG['html']['is_use_header'] = false;
	$CFG['admin']['light_window_page'] = true;
}
else
{
	$CFG['html']['header'] = 'admin/html_header.php';
	$CFG['html']['footer'] = 'admin/html_footer.php';
	$CFG['mods']['is_include_only']['html_header'] = false;
	$CFG['html']['is_use_header'] = false;
}
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
/**
 *
 * @category	rayzz
 * @package		Admin photo
 **/
class photoManage extends MediaHandler
	{
		public $sql_condition = '';
		public $sql_sort = '';
		public $fields_arr = '';
		public $sql='';
		public $photo_category_name = array();
		/**
		 * photoManage::buildConditionQuery()
		 *
		 * @return void
		 **/
		public function buildConditionQuery()
			{
				$this->sql_condition = '';
			}
		/**
		 * photoManage::buildSortQuery()
		 *
		 * @return void
		 **/
		public function buildSortQuery()
			{
				$this->sql_sort = 'v.photo_id DESC';
			}
		/**
		 * photoManage::getphotoCategory()
		 *
		 * @param integer $photo_category_id
		 * @return array
		 */
		public function getphotoCategory($photo_category_id)
			{

				if(isset($this->photo_category_name[$photo_category_id]))
					return $this->photo_category_name[$photo_category_id];
				$this->photo_category_name[$photo_category_id] = '';
				$sql = 'SELECT photo_category_name FROM '.$this->CFG['db']['tbl']['photo_category'].
						' WHERE photo_category_id='.$this->dbObj->Param('photo_category_id').' AND 	photo_category_status=\'Yes\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($photo_category_id));
				if (!$rs)
					trigger_db_error($this->dbObj);
				if($row = $rs->FetchRow())
					{
						$this->photo_category_name[$photo_category_id] = wordWrap_mb_ManualWithSpace($row['photo_category_name'], $this->CFG['admin']['photos']['admin_photo_channel_title_length']);
					}
				return $this->photo_category_name[$photo_category_id];
			}
		/**
		 * photoManage::populatephotoCategory()
		 *
		 * @return void
		 */
		public function populatephotoCategory($srch_categories = false)
			{
				$sql = 'SELECT photo_category_id, photo_category_name FROM '.$this->CFG['db']['tbl']['photo_category'].' WHERE 	photo_category_status=\'Yes\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);
				$populatephotoCategory='';
				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$populatephotoCategory .= '<option value="'.$row['photo_category_id'].'" class="selectphotoCategory"';

								if($this->fields_arr['srch_categories']  == $row['photo_category_id'])
									$populatephotoCategory .= ' selected="selected"';

								$populatephotoCategory .= '>'.$row['photo_category_name'].'</option>';
								if($this->CFG['admin']['photos']['sub_category'])
									{
										$populatephotoCategory .= $this->populatephotoSubCategory($row['photo_category_id']);
									}

							}
					}
					return $populatephotoCategory;

			}
		/**
		 * photoManage::populatephotoSubCategory()
		 *
		 * @return void
		 */
		public function populatephotoSubCategory($category_id)
			{

				$populatephotoSubCategory = '';
				$sql = 'SELECT photo_category_id, photo_category_name FROM '.$this->CFG['db']['tbl']['photo_category'].
						' WHERE parent_category_id='.$category_id.' AND photo_category_status=\'Yes\'';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_db_error($this->dbObj);

				if($rs->PO_RecordCount())
					{
						while($row = $rs->FetchRow())
							{
								$populatephotoSubCategory .= '<option value="'.$row['photo_category_id'].'" class="selectphotoSubCategory"';
								if($this->fields_arr['srch_categories'] == $row['photo_category_id'])
									$populatephotoSubCategory .= ' selected="selected"';
								$populatephotoSubCategory .= '>'.$row['photo_category_name'].'</option>';
							}
						return $populatephotoSubCategory;
					}
				return ;
			}

		/**
		 * photoManage::displayphotoList()
		 * This method helps to display the list of photos
		 *
		 * @return void
		 **/
		public function displayphotoList()
			{
				global $smartyObj;
				$displayphotoList_arr = array();
				$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
				$fields_list = array('user_name', 'first_name', 'last_name');
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
				$fields_list = array('user_name', 'first_name', 'last_name');
				$displayphotoList_arr['row'] = array();
				$inc = 1;
				while($row = $this->fetchResultRecord())
					{
						if(!isset($row['user_name']))
							{
								if(!isset($this->UserDetails[$row['user_id']]))
									getUserDetail('user_id', $row['user_id'], 'user_name');
								$displayphotoList_arr['row'][$inc]['name'] = getUserDetail('user_id', $row['user_id'], 'user_name');
							}
						else
							{
								$name = $this->CFG['format']['name'];
								$name = str_replace('$first_name', $row['first_name'],$name);
								$name = str_replace('$last_name', $row['last_name'],$name);
								$name = str_replace('$user_name', $row['user_name'],$name);
								$displayphotoList_arr['row'][$inc]['name'] = $name;
							}
						$displayphotoList_arr['row'][$inc]['file_path'] = $row['photo_server_url'].$thumbnail_folder.getphotoName($row['photo_id']).$this->CFG['admin']['photos']['small_name'].'.'.$row['photo_ext'];
						$displayphotoList_arr['row'][$inc]['DISP_IMAGE'] = DISP_IMAGE($this->CFG['admin']['photos']['small_width'], $this->CFG['admin']['photos']['small_height']);
						$row['flagged_status'] = $row['flagged_status']?$row['flagged_status']:'No';
						$row['featured'] = $row['featured']?$row['featured']:'No';
						$displayphotoList_arr['row'][$inc]['comments_text'] = str_replace('{total_comments}', $row['total_comments'], $this->LANG['photo_comments']);
						$row['photo_title']=wordWrap_mb_Manual($row['photo_title'], $this->CFG['admin']['photos']['list_title_length'], $this->CFG['admin']['photos']['list_title_total_length']);
						$displayphotoList_arr['row'][$inc]['photoupload_url']=getUrl('photouploadpopup','?photo_id='.$row['photo_id'].'&title='.$this->changeTitle($row['photo_title']), $row['photo_id'].'/'.$this->changeTitle($row['photo_title']).'/','','photo');
						$displayphotoList_arr['row'][$inc]['record'] = $row;
						$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
						if($row['photo_ext']=='')
							{
								$displayphotoList_arr['row'][$inc]['file_path'] = $this->CFG['site']['url'].'photo/design/templates/'.$this->CFG['html']['template']['default'].'/root/images/'.$this->CFG['html']['stylesheet']['screen']['default'].'/no_image/noImage_photo_S.jpg';
						    }
						else
							{
								$displayphotoList_arr['row'][$inc]['file_path'] = $row['photo_server_url'].$photos_folder.getphotoName($row['photo_id']).$this->CFG['admin']['photos']['small_name'].'.'.$row['photo_ext'];
							}
						//$displayphotoList_arr['row'][$inc]['previewURL'] = $this->CFG['site']['url'].'admin/photo/photoManage.php?ajax=true&photo_id='.$row['photo_id'].'&type=Preview';
						$displayphotoList_arr['row'][$inc]['previewURL'] = $this->CFG['site']['url'].'admin/photo/photoPreview.php?ajax=true&photo_id='.$row['photo_id'].'&type=Preview';
						$inc++;
					}
				$smartyObj->assign('displayphotoList_arr', $displayphotoList_arr);


			}

		/**
		 * photoManage::getSearchCondition()
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
						$search_condition .= ' AND v.photo_title LIKE \'%'.addslashes($this->fields_arr['srch_title']).'%\'';
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
						$search_condition .= ' AND v.featured = \'Yes\'';
					}

				if ($this->fields_arr['srch_feature'] == 'No')
					{
						$search_condition .= ' AND v.featured = \'No\'';
					}

				if ($this->fields_arr['srch_categories'])
					{
						$search_condition .= ' AND v.photo_category_id = \''.addslashes($this->getFormField('srch_categories')).'\'';
					}
				if ($this->fields_arr['srch_date_added'])
					{
						$search_condition .= ' AND v.date_added >= \''.$this->getFormField('srch_date_added').' 00:00:00\'';
						$search_condition .= ' AND v.date_added <= DATE_ADD(\''.$this->getFormField('srch_date_added').' 00:00:00\', INTERVAL 1 DAY)';

					}
				return $search_condition;
		    }
		/**
		 * photoManage::switchCase()
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
						case 'photoListAll';
							$this->setTableNames(array($this->CFG['db']['tbl']['photo'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 'photo_server_url','photo_ext','flagged_status','v.photo_id','v.user_id', 'v.photo_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'photo_category_id', 'photo_sub_category_id'));
							$this->sql_condition = 'v.user_id=u.user_id AND v.photo_status=\'Ok\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'v.photo_id DESC';
							break;
						case 'photoNew';
							$this->setTableNames(array($this->CFG['db']['tbl']['photo'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 'photo_server_url','photo_ext','flagged_status','v.photo_id','v.user_id', 'v.photo_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'photo_category_id', 'photo_sub_category_id'));
							$this->sql_condition = 'v.user_id=u.user_id AND v.photo_status=\'Ok\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'v.date_added DESC';
							break;
						case 'photoTopRated';
							$this->setTableNames(array($this->CFG['db']['tbl']['photo'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 'photo_server_url','photo_ext','flagged_status','v.photo_id','v.user_id', 'v.photo_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', '(v.rating_total/v.rating_count) as rating', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', 'photo_category_id', 'photo_sub_category_id'));
							$this->sql_condition = 'v.user_id=u.user_id AND v.photo_status=\'Ok\' AND v.rating_total>0 AND v.allow_ratings=\'Yes\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'rating DESC';
							break;
						case 'photoRecentlyViewed':
							$this->setTableNames(array($this->CFG['db']['tbl']['photo'].' as v', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 'photo_server_url','photo_ext','flagged_status','v.photo_id','v.user_id', 'v.photo_title', 'DATE_FORMAT(v.date_added,\''.$this->CFG['format']['date'].'\') as date_added', '(v.rating_total/v.rating_count) as rating', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', 'v.last_view_date as max_view_date', 'photo_category_id', 'photo_sub_category_id'));
							$this->sql_condition = 'v.user_id=u.user_id AND v.photo_status=\'Ok\'';
							$this->sql_condition .= $search_condition;
							$this->sql_sort = 'max_view_date DESC';
							break;
						case 'photoMostViewed';
						case 'photoMostViewed-1';
						case 'photoMostViewed-2';
						case 'photoMostViewed-3';
						case 'photoMostViewed-4';
						case 'photoMostViewed-5';
						case 'photoMostViewed-6';
							$this->setTableNames(array($this->CFG['db']['tbl']['photo_viewed'].' as mv LEFT JOIN '.$this->CFG['db']['tbl']['photo'].' as v ON mv.photo_id=v.photo_id', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 'photo_server_url','photo_ext','flagged_status','v.photo_id','v.user_id', 'v.photo_title', 'DATE_FORMAT(mv.last_viewed,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'photo_category_id', 'photo_sub_category_id','SUM(mv.total_views) as sum_total_views'));
							$extra_query = '';
							if($casename == 'photoMostViewed-1' || $casename == 'photoMostViewed')
								{
									$extra_query = '';
								}
							if($casename == 'photoMostViewed-2')
								{
									$extra_query = ' AND DATE_FORMAT(mv.last_viewed,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
								}
							if($casename == 'photoMostViewed-3')
								{
									$extra_query = ' AND DATE_FORMAT(mv.last_viewed,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
								}
							if($casename == 'photoMostViewed-4')
								{
									$extra_query = ' AND DATE_FORMAT(mv.last_viewed,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
								}
							if($casename == 'photoMostViewed-5')
								{
									$extra_query = ' AND DATE_FORMAT(mv.last_viewed,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
								}
							if($casename == 'photoMostViewed-6')
								{
									$extra_query = ' AND DATE_FORMAT(mv.last_viewed,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
								}
							$this->sql_condition = 'v.user_id=u.user_id AND v.photo_status=\'Ok\' AND v.total_views>0'.$extra_query;
							$this->sql_condition .= $search_condition;
							$this->sql_condition .= ' GROUP BY mv.photo_id';
							$this->sql_sort = 'sum_total_views DESC';
							break;
						case 'photoMostDiscussed';
						case 'photoMostDiscussed-1';
						case 'photoMostDiscussed-2';
						case 'photoMostDiscussed-3';
						case 'photoMostDiscussed-4';
						case 'photoMostDiscussed-5';
						case 'photoMostDiscussed-6';
							$this->setTableNames(array($this->CFG['db']['tbl']['photo_comments'].' as ms LEFT JOIN '.$this->CFG['db']['tbl']['photo'].' as v ON ms.photo_id=v.photo_id', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 'photo_server_url','photo_ext','flagged_status','photo_title','v.photo_id','v.user_id', 'DATE_FORMAT(ms.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'photo_category_id', 'photo_sub_category_id','count( ms.photo_comment_id ) as total_comments'));
							$extra_query = '';
							if($casename == 'photoMostDiscussed-1' || $casename == 'photoMostDiscussed')
								{

									$extra_query = '';
								}
							if($casename == 'photoMostDiscussed-2')
								{
									$extra_query = ' AND DATE_FORMAT(ms.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
								}
							if($casename == 'photoMostDiscussed-3')
								{
									$extra_query = ' AND DATE_FORMAT(ms.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
								}
							if($casename == 'photoMostDiscussed-4')
								{
									$extra_query = ' AND DATE_FORMAT(ms.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
								}
							if($casename == 'photoMostDiscussed-5')
								{
									$extra_query = ' AND DATE_FORMAT(ms.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
								}
							if($casename == 'photoMostDiscussed-6')
								{
									$extra_query = ' AND DATE_FORMAT(ms.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
								}
							$this->sql_condition = 'v.user_id=u.user_id AND v.photo_status=\'Ok\' AND comment_status=\'Yes\' AND v.total_comments>0'.$extra_query;
							$this->sql_condition .= $search_condition;
							$this->sql_condition .= ' GROUP BY ms.photo_id';
							$this->sql_sort = 'total_comments DESC, total_views DESC ';
							break;
						case 'photoTopFavorites';
						case 'photoTopFavorites-1';
						case 'photoTopFavorites-2';
						case 'photoTopFavorites-3';
						case 'photoTopFavorites-4';
						case 'photoTopFavorites-5';
						case 'photoTopFavorites-6';
							$this->setTableNames(array($this->CFG['db']['tbl']['photo_favorite'].' as mf LEFT JOIN '.$this->CFG['db']['tbl']['photo'].' as v ON mf.photo_id=v.photo_id', $this->CFG['db']['tbl']['users'].' as u'));
							$this->setReturnColumns(array('v.featured', 'photo_server_url','photo_ext','flagged_status','v.photo_id','v.user_id', 'v.photo_title', 'DATE_FORMAT(mf.date_added,\''.$this->CFG['format']['date'].'\') as date_added', 'v.total_views', 'v.total_comments', 'v.total_favorites', 'v.allow_comments','v.allow_ratings', '(rating_total/rating_count) as rating', 'photo_category_id', 'photo_sub_category_id' ,'count( mf.photo_favorite_id ) as total_favorite'));
							$extra_query = '';
							if($casename == 'photoTopFavorites-1' || $casename == 'photoTopFavorites')
								{
									$extra_query = '';
								}
							if($casename == 'photoTopFavorites-2')
								{
									$extra_query = ' AND DATE_FORMAT(mf.date_added,\'%d-%m-%y\')=DATE_FORMAT(NOW(),\'%d-%m-%y\')';
								}
							if($casename == 'photoTopFavorites-3')
								{
									$extra_query = ' AND DATE_FORMAT(mf.date_added,\'%d-%m-%y\')=DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 DAY),\'%d-%m-%y\')';
								}
							if($casename == 'photoTopFavorites-4')
								{
									$extra_query = ' AND DATE_FORMAT(mf.date_added,\'%u-%y\')=DATE_FORMAT(NOW(),\'%u-%y\')';
								}
							if($casename == 'photoTopFavorites-5')
								{
									$extra_query = ' AND DATE_FORMAT(mf.date_added,\'%m-%y\')=DATE_FORMAT(NOW(),\'%m-%y\')';
								}
							if($casename == 'photoTopFavorites-6')
								{
									$extra_query = ' AND DATE_FORMAT(mf.date_added,\'%y\')=DATE_FORMAT(NOW(),\'%y\')';
								}
						$this->sql_condition = 'v.user_id=u.user_id AND v.photo_status=\'Ok\' AND v.total_favorites>0'.$extra_query;
						$this->sql_condition .= $search_condition;
						$this->sql_condition .= ' GROUP BY mf.photo_id';
						$this->sql_sort = 'total_favorite DESC, total_views DESC ';
						break;
				}
			}

		/**
		 * photoManage::switchCase()
		 * This function is used to set the flag for the photo.
		 *
		 * @return boolean
		 **/
		public function deletephoto()
			{
				$photo_details = explode(',', $this->fields_arr['checkbox']);
				if($this->fields_arr['action']=='Delete')
					{
						foreach($photo_details as $photo_key=>$photo_value)
							{
								$photo_arr = explode('-',$photo_value);
								$photo_id = $photo_arr[0];
								$user_id = $photo_arr[1];
								$photoHandler = new photoHandler();
								$photoHandler->deletePhotos(array($photo_id), $user_id);
							}
					}
				else if($this->fields_arr['action']=='Flag')
					{
						foreach($photo_details as $photo_key=>$photo_value)
							{
								$photo_arr = explode('-',$photo_value);
								$flag[] = $photo_arr[0];
							}
						$photo_list = implode(',',$flag);

						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
								' content_type=\'photo\' AND content_id IN('.$photo_list.')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET flagged_status=\'Yes\''.
								' WHERE photo_id IN('.$photo_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

					}
				else if($this->fields_arr['action']=='UnFlag')
					{
						foreach($photo_details as $photo_key=>$photo_value)
							{
								$photo_arr = explode('-',$photo_value);
								$flag[] = $photo_arr[0];
							}
						$photo_list = implode(',',$flag);

						$sql = 'DELETE FROM '.$this->CFG['db']['tbl']['flagged_contents'].' WHERE'.
								' content_type=\'photo\' AND content_id IN('.$photo_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET flagged_status=\'No\''.
								' WHERE photo_id IN('.$photo_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);
					}
				else if($this->fields_arr['action']=='Featured')
					{

						foreach($photo_details as $photo_key=>$photo_value)
							{
								$photo_arr = explode('-',$photo_value);
								$flag[] = $photo_arr[0];
							}
						$photo_list = implode(',',$flag);
						$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET featured=\'Yes\''.
								' WHERE photo_id IN('.$photo_list.')';
						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);
					}
				else if($this->fields_arr['action']=='UnFeatured')
					{
						foreach($photo_details as $photo_key=>$photo_value)
							{
								$photo_arr = explode('-',$photo_value);
								$flag[] = $photo_arr[0];
							}
						$photo_list = implode(',',$flag);

						$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET featured=\'No\''.
								' WHERE photo_id IN('.$photo_list.')';

						$stmt = $this->dbObj->Prepare($sql);
						$rs = $this->dbObj->Execute($stmt);
						if (!$rs)
							trigger_db_error($this->dbObj);
					}
				else if($this->fields_arr['action']=='Move')
					{
						foreach($photo_details as $photo_key=>$photo_value)
							{
								$photo_arr = explode('-',$photo_value);
								$flag[] = $photo_arr[0];
							}
						$photo_list = implode(',',$flag);

						if($parent_id=$this->isParentExists($this->fields_arr['photo_categories']))
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET '.
										' photo_category_id= \''.$parent_id.'\', '.
										' photo_sub_category_id = \''.$this->fields_arr['photo_categories'].'\' '.
										' WHERE photo_id IN('.$photo_list.')';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt);
								if (!$rs)
									trigger_db_error($this->dbObj);
							}
						else
							{
								$sql = 'UPDATE '.$this->CFG['db']['tbl']['photo'].' SET '.
										' photo_sub_category_id=0, photo_category_id='.$this->dbObj->Param('photo_categories').
										' WHERE photo_id IN('.$photo_list.')';

								$stmt = $this->dbObj->Prepare($sql);
								$rs = $this->dbObj->Execute($stmt, array($this->fields_arr['photo_categories']));
								if (!$rs)
									trigger_db_error($this->dbObj);
							}
					}
				return true;
			}

		/**
		 * photoManage::isParentExists()
		 *
		 * @param Integer $cid
		 * @return boolean
		 */
		public function isParentExists($cid)
			{
				$sql = 'SELECT parent_category_id FROM '.$this->CFG['db']['tbl']['photo_category']. ' WHERE photo_category_id =\''.$cid.'\'';

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
		 * photoManage::getTotalLyric()
		 *
		 * @param mixed $photo_id
		 * @return
		 */
		public function getTotalLyric($photo_id)
			{
				$sql = 'SELECT count(photo_lyric_id) as total_lyrics  FROM '.$this->CFG['db']['tbl']['photo_lyric'].' '.
						'WHERE photo_id = '.$this->dbObj->Param('photo_id');

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array($photo_id));
				if (!$rs)
					trigger_db_error($this->dbObj);

				$row = $rs->FetchRow();
				return $row['total_lyrics'];
			}
	/**
	 * PhotoActivate::displayPhoto()
	 *
	 * @param string $photoId
	 * @return string
	 */
	public function displayPhoto($photoId = '')
	{
		$sql  = 'SELECT photo_id, photo_server_url, photo_ext, l_width, l_height FROM '.$this->CFG['db']['tbl']['photo'].' WHERE photo_id = '.$this->dbObj->Param('photo_id');
		$stmt = $this->dbObj->Prepare($sql);
		$rs   = $this->dbObj->Execute($stmt, array($photoId));
	    if (!$rs)
		    trigger_db_error($this->dbObj);

		$photos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['photos']['folder'].'/'.$this->CFG['admin']['photos']['photo_folder'].'/';
		$imgSrc = '';
		if($row = $rs->FetchRow())
		{
			$imgSrc = $this->media_relative_path.$photos_folder.getPhotoName($row['photo_id']).
															$this->CFG['admin']['photos']['large_name'].'.'.$row['photo_ext'].'?'.time();
?>
			<img src="<?php echo $imgSrc;?>" width="<?php echo $row['l_width'];?>" height="<?php echo $row['l_height'];?>" />

<?php
		}
	}
}
//<<<<<-------------- Class obj begins ---------------//
//-------------------- Code begins -------------->>>>>//
//echo '<pre>'; print_r($_REQUEST); echo '<pre>';
$photoManage = new photoManage();
$photoManage->setMediaPath('../../');

$CFG['admin']['light_window_page'] = true;

$CFG['browsephotos'] = array('photoListAll'=>$LANG['nav_list_all_photos'],'photoNew'=>$LANG['nav_photo_new'],'photoTopRated'=>$LANG['nav_top_rated'],'photoMostViewed'=>$LANG['nav_most_viewed'],'photoMostDiscussed'=>$LANG['nav_most_discussed'],'photoTopFavorites'=>$LANG['nav_most_favorite'],'photoRecentlyViewed'=>$LANG['nav_recently_viewed']);
$CFG['options'] = array('1'=>$LANG['all_time'],'2'=>$LANG['today'],'3'=>$LANG['yesterday'],'4'=>$LANG['this_week'],'5'=>$LANG['this_month'],'6'=>$LANG['this_year']);
$photoManage->setPageBlockNames(array('browse_photos', 'form_search', 'list_photo_form', 'set_flag'));
$photoManage->setReturnColumns(array());
$photoManage->setTableNames(array());
$photoManage->setFormField('list', '');
$photoManage->setFormField('photo_id', '');
$photoManage->setFormField('submit', '');
$photoManage->setFormField('subcancel', '');
$photoManage->setFormField('action', '');
$photoManage->setFormField('delete', '');
$photoManage->setFormField('confirmdel', '');
$photoManage->setFormField('checkbox', array());
$photoManage->setFormField('srch_uname', '');
$photoManage->setFormField('srch_title', '');
$photoManage->setFormField('srch_flag', '');
$photoManage->setFormField('srch_feature', '');
$photoManage->setFormField('srch_date_added', '');
$photoManage->setFormField('srch_date', '');
$photoManage->setFormField('srch_month', '');
$photoManage->setFormField('srch_year', '');
$photoManage->setFormField('srch_categories', '');
$photoManage->setFormField('photo_categories', '');
$photoManage->setFormField('type', '');
$photoManage->setMonthsListArr($LANG_LIST_ARR['months']);
$photoManage->setFormField('check_box', '');
$photoManage->setFormField('photo_options', '');
/*********** Page Navigation Start *********/
$photoManage->setFormField('slno', '1');
$photoManage->populatephotoCategory();
/************ page Navigation stop *************/
$photoManage->setAllPageBlocksHide();
$photoManage->setPageBlockShow('browse_photos');
/******************************************************/
$photoManage->setTableNames(array($photoManage->CFG['db']['tbl']['photo'].' as v LEFT JOIN '.$photoManage->CFG['db']['tbl']['users'].' as u ON v.user_id=u.user_id AND u.usr_status=\'Ok\''));
$photoManage->setReturnColumns(array('v.photo_id', 'photo_server_url','photo_ext','v.user_id', 'v.photo_title', 'DATE_FORMAT(v.date_added,\''.$photoManage->CFG['format']['date'].'\') as date_added', 'u.user_name', 'u.first_name', 'u.last_name', 'v.featured','v.flagged_status','v.photo_status', 'photo_category_id', 'v.total_comments', 'photo_sub_category_id','v.photo_ext'));
$photoManage->sql_condition = 'v.photo_status=\'Ok\'';
$photoManage->sql_sort = 'v.photo_id DESC';
$photoManage->sanitizeFormInputs($_REQUEST);
$photoManage->setPageBlockShow('list_photo_form');
$photoManage->setPageBlockShow('form_search');
/******************************************************/
/*
if($photoManage->isFormGETed($_GET,'type'))
	{
		$photoManage->includeAjaxHeader();
		$photoManage->sanitizeFormInputs($_REQUEST);
		$block = $photoManage->getFormField('type');


		if(isset($block) && $block == 'Preview')
		{
			$photoManage->displayPhoto($photoManage->getFormField('photo_id'));
		}
		$photoManage->includeAjaxFooter();die;
	}

if(isAjaxPage())
{
	$photoManage->includeAjaxHeader();
	$photoManage->sanitizeFormInputs($_REQUEST);
	$block = $photoManage->getFormField('type');

	if(isset($block) && $block == 'Preview')
	{
		$photoManage->displayPhoto($photoManage->getFormField('photo_id'));
	}
	$photoManage->includeAjaxFooter();

}
*/
if ($photoManage->getFormField('srch_date') || $photoManage->getFormField('srch_month') || $photoManage->getFormField('srch_year'))
	{
		$photoManage->chkIsCorrectDate($photoManage->getFormField('srch_date'), $photoManage->getFormField('srch_month'), $photoManage->getFormField('srch_year'), 'srch_date_added', $LANG['photoManage_err_tip_date_empty'], $LANG['photoManage_err_tip_date_invalid']);
    }
$srch_condition = $photoManage->getSearchCondition();
if ($srch_condition)
	$photoManage->sql_condition .= $srch_condition;
if($photoManage->isFormGETed($_GET,'list') && !$photoManage->isFormGETed($_GET,'action'))
	{
		$casename = $_GET['list'];
		$photoManage->switchCase($casename, 'get');
	}
if($photoManage->isFormGETed($_POST,'submit'))
	{
		$casename = $_POST['list'];
		$photoManage->switchCase($casename, 'post');
	}
if($photoManage->isFormGETed($_POST,'search'))
	{
		$casename = $_POST['list'];
		$photoManage->switchCase($casename, 'post');
	}

if($photoManage->isFormGETed($_POST,'start'))
	{
		$casename = $_POST['list'];
		$photoManage->switchCase($casename, 'post');
	}
if($photoManage->isFormGETed($_GET,'list') && $photoManage->isFormGETed($_GET,'action'))
	{
		$photoManage->setAllPageBlocksHide();
		$photoManage->setPageBlockShow('set_flag');
	}
if($photoManage->isFormGETed($_POST,'subcancel'))
	{
		$casename = $_POST['list'];
		$photoManage->switchCase($casename, 'post');
	}
if($photoManage->isFormGETed($_POST,'confirmdel'))
	{
		$casename = $_POST['list'];
		$photoManage->switchCase($casename, 'post');
		if($photoManage->deletephoto())
			{
				$photoManage->setCommonSuccessMsg($LANG['photoManage_msg_success_delete']);
				$photoManage->setPageBlockShow('block_msg_form_success');
			}
		else
			{
				$photoManage->setCommonErrorMsg($LANG['photoManage_msg_success_delete_fail']);
				$photoManage->setPageBlockShow('block_msg_form_error');
			}
	}


//<<<<<-------------------- Code ends----------------------//
$photoManage->hidden_arr = array('list', 'srch_uname', 'srch_categories', 'srch_title', 'srch_flag', 'srch_feature', 'srch_date', 'srch_month', 'srch_year', 'start');
$photoManage->current_year = date('Y');
if ($photoManage->isShowPageBlock('browse_photos'))
    {
    	$photoManage->browse_photos['list'] = '';
		foreach($CFG['browsephotos'] as $key=>$val)
			{
				if($key == $photoManage->getFormField('list'))
					{
						$selected = 'selected';
					}
				else
					{
						$selected = '';
					}
				$photoManage->browse_photos['list'] .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
				if($key == 'photoMostViewed')
					{
						foreach($CFG['options'] as $optkey=>$optval)
							{
								if($key.'-'.$optkey == $photoManage->getFormField('list'))
									{
										$selected = 'selected';
									}
								else
									{
										$selected = '';
									}
								$photoManage->browse_photos['list'] .= '<option value="'.$key.'-'.$optkey.'" '.$selected.'>&nbsp;&nbsp;&nbsp;'.$optval.'</option>';
							}
					}
				if($key == 'photoMostDiscussed')
					{
						foreach($CFG['options'] as $optkey=>$optval)
							{
								if($key.'-'.$optkey == $photoManage->getFormField('list'))
									{
										$selected = 'selected';
									}
								else
									{
										$selected = '';
									}
								$photoManage->browse_photos['list'] .= '<option value="'.$key.'-'.$optkey.'" '.$selected.'>&nbsp;&nbsp;&nbsp;'.$optval.'</option>';
							}
					}
				if($key == 'photoTopFavorites')
					{
						foreach($CFG['options'] as $optkey=>$optval)
							{
								if($key.'-'.$optkey == $photoManage->getFormField('list'))
									{
										$selected = 'selected';
									}
								else
									{
										$selected = '';
									}
								$photoManage->browse_photos['list'] .= '<option value="'.$key.'-'.$optkey.'" '.$selected.'>&nbsp;&nbsp;&nbsp;'.$optval.'</option>';

							}
					}
			}
    }
if ($photoManage->isShowPageBlock('form_search'))
	{
		$photoManage->form_search['hidden_arr'] = array('list');
	}
if ($photoManage->isShowPageBlock('list_photo_form'))
    {
		/****** navigtion continue*********/
		$photoManage->buildSelectQuery();
		$photoManage->buildQuery();
		$photoManage->buildSortQuery();
		//$photoManage->printQuery();
		if($photoManage->isGroupByQuery())
			$photoManage->homeExecuteQuery();
		else
			$photoManage->executeQuery();
		/******* Navigation End ********/
		if($photoManage->isResultsFound())
			{
				$photoManage->displayphotoList();
				$smartyObj->assign('smarty_paging_list', $photoManage->populatePageLinksPOST($photoManage->getFormField('start'), 'photo_manage_form2'));
				$photoManage->list_photo_form['hidden_arr'] = array('list', 'srch_uname', 'srch_categories', 'srch_title',  'srch_flag', 'srch_feature', 'srch_date', 'srch_month', 'srch_year', 'start');
			}
    }
$photoManage->left_navigation_div = 'photoMain';
//-------------------- Page block templates begins -------------------->>>>>//
//include the header file
$photoManage->includeHeader();
//include the content of the page
setTemplateFolder('admin/', 'photo');
$smartyObj->display('photoManage.tpl');
//<<<<<-------------------- Page block templates ends -------------------//
?>
<script language="javascript" type="text/javascript" >
	var block_arr= new Array('selMsgConfirm');
	var replace_url = '<?php echo $CFG['site']['url'];?>login.php';
	var please_select_action = '<?php echo $LANG['photoManage_err_tip_select_action'];?>';
	var confirm_message = '';
	function getAction()
		{
			var act_value = document.photo_manage_form2.photo_options.value;
			if(act_value)
				{
					switch (act_value)
						{
							case 'Delete':
								confirm_message = '<?php echo $LANG['photoManage_delete'];?>';
								break;
							case 'Flag':
								confirm_message = '<?php echo $LANG['photoManage_status'];?>';
								break;
							case 'UnFlag':
								confirm_message = '<?php echo $LANG['photoManage_status'];?>';
								break;
							case 'Featured':
								confirm_message = '<?php echo $LANG['photoManage_featured'];?>';
								break;
							case 'UnFeatured':
								confirm_message = '<?php echo $LANG['photoManage_unfeatured'];?>';
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
$photoManage->includeFooter();
?>