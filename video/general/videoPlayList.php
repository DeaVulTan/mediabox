<?php
//--------------class Playlist--------------->>>//
/**
 * This class is used to view the video play list
 *
 * @category	Rayzz
 * @package		Forums
 */
class Playlist extends VideoHandler
	{
		public $UserDetails = array();
		/**
		 * Playlist::resetFields()
		 *
		 * @return
		 */
		public function resetFields()
			{
				$this->setFormField('module', 'video');
				$this->setFormField('pg', '');
			}

		/**
		 * Playlist::setTableAndColumns()
		 *
		 * @return
		 */
		public function setTableAndColumns()
			{
				if($this->fields_arr['pg'] = 'playlistnew')
					{

						$this->fields_arr['pg'] = 'myplaylist';
					}
				switch($this->fields_arr['module'])
					{

						default:
							$this->setReturnColumns(array('p.playlist_id','p.user_id','p.playlist_name', 'p.playlist_description', 'p.playlist_tags', 'TIMEDIFF(NOW(), p.date_added) as date_added','NOW() as date_current','p.date_added as date_created','(p.rating_total/p.rating_count) as rating', 'p.total_views','p.total_videos','TIMEDIFF(NOW(), p.last_viewed_date) as last_played','p.thumb_video_id','p.thumb_ext','ph.t_width','ph.t_height','ph.video_server_url'));
							switch($this->fields_arr['pg'])
								{
									case 'myplaylist':
										$additional_query='';
										$this->setTableNames(array($this->CFG['db']['tbl']['video_playlist'] .' as p' , $this->CFG['db']['tbl']['video'] .' as ph'));
										$this->fields_arr['tags'];
										if($this->fields_arr['tags'])
											$additional_query = '('.getSearchRegularExpressionQueryModified($this->fields_arr['tags'], 'p.playlist_tags', 'OR').' playlist_name LIKE\'%'.addslashes($this->fields_arr['tags']).'%\') AND ';
										$this->sql_condition = $additional_query.'p.playlist_status=\'Yes\' AND p.user_id = '.$this->CFG['user']['user_id'].' AND ph.video_id=p.thumb_video_id';
										$this->sql_sort = 'playlist_name DESC';

										break;

									default:
										$this->setTableNames(array($this->CFG['db']['tbl']['video_playlist'] .' as p' , $this->CFG['db']['tbl']['video'] .' as ph'));
										$this->sql_condition = 'p.playlist_status=\'Yes\' AND (p.user_id = '.$this->CFG['user']['user_id'].' OR p.playlist_access_type = \'Public\''.$this->getAdditionalQuery('p.').') AND ph.video_id=p.thumb_video_id';
										$this->sql_sort = 'rating DESC';

									} // switch
						break;
					} // switch
			}

		/**
		 * Playlist::showPlaylist()
		 *
		 * @return
		 */
		public function showPlaylist()
			{
				$showPlaylist=array();
				$inc=0;
				$userid_arr=array();
				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				while($row = $this->fetchResultRecord())
					{
						$row['playlist_name']= $row['playlist_name'];
						$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/';
						$fields_list = array('user_name','first_name','last_name');
						//if(!isset($this->UserDetails[$row['user_id']]))
						//	$this->getUserDetails($row['user_id'], $fields_list);
						if(!in_array($row['user_id'],$userid_arr))
							$userid_arr[]=$row['user_id'];
						$row['playlist_description'] = $row['playlist_description'];
						$showPlaylist['record'][$inc]=$row;
						$showPlaylist['record'][$inc]['date_added'] 	= ($row['date_added'] != '') ? getTimeDiffernceFormat(getDateTimeDiff($row['date_created'],$row['date_current'])) : '';
						$showPlaylist['record'][$inc]['last_played'] 	= ($row['last_played'] != '') ? getTimeDiffernceFormat($row['last_played']) : '';

						$showPlaylist['record'][$inc]['t_width'] 	= $row['t_width'];
						$showPlaylist['record'][$inc]['t_height'] 	= $row['t_height'];

						$showPlaylist['record'][$inc]['url']			= getUrl('viewvideoplaylist', '?playlist_id='.$row['playlist_id'], '?playlist_id='.$row['playlist_id'], '', 'video');
						$showPlaylist['record'][$inc]['imageSrc']		= $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['thumb_video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];//.$this->CFG['admin']['videos']['thumb_name'].'.'.$row['thumb_ext'];
						$showPlaylist['record'][$inc]['user_name'] 		= $this->getUserDetail('user_id',$row['user_id'], 'user_name');;
						$showPlaylist['record'][$inc]['playlist_tags']	= $this->getTagLinks($row['playlist_tags']);
						$inc++;
					}
				$user_ids=implode(',',$userid_arr);
				$this->getMultiUserDetails($user_ids, $fields_list);
				return $showPlaylist;
			}


		/**
		 * VideoList::getTagLinks()
		 *
		 * @param mixed $tags
		 * @return
		 */
		public function getTagLinks($tags='')
			{

				$tags_arr = explode(' ',$tags);
				$inc=0;
				foreach($tags_arr as $tags)
					{
						$return[$inc]['tag_url'] = getUrl('videoplaylist', '?pg=playlistnew&amp;tags='.$tags, '?pg=playlistnew&amp;tags='.$tags, '', 'video');
						$return[$inc]['tag']=$tags;
					}
				return $return;

			}

		/**
		 * VideoList::getNextPlayListLinks()
		 *
		 * @return
		 */
		public function getNextPlayListLinks($playlist_id)
			{
				$condition=' playlist_id=\''.$playlist_id.'\' ';
				$sql = 'SELECT video_id as video_id, order_id FROM '.$this->CFG['db']['tbl']['video_in_playlist'].' as v'.
						' WHERE '.$condition.' ORDER BY order_id LIMIT 0,2';

				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
				if (!$rs)
					trigger_db_error($this->dbObj);

				$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
				$count=1;
				$this->play_list_url_exists=false;
				while($row = $rs->FetchRow() and $row['video_id'])
					{
						$this->play_list_url_exists=true;
						$link = getUrl('viewvideo', '?video_id='.$row['video_id'].'&amp;vpkey='.$this->fields_arr['vpkey'].'&amp;play_list=pl&amp;playlist_id='.$playlist_id.''.'&amp;order='.$row['order_id'], $row['video_id'].'//?vpkey='.$this->fields_arr['vpkey'].'&play_list=pl&playlist_id='.$playlist_id.'&amp;order='.$row['order_id'], '', 'video');
						$this->play_list_next_url=$link;
						if($count==1)
							{
								$this->play_list_id=$row['video_id'];
?>
								<a class="clsPlayListEdit" href="<?php echo $link;?>" title="<?php echo $this->LANG['videolist_play']; ?>"><?php echo $this->LANG['videolist_play']; ?></a>
<?php
							}
							else
								$this->play_list_next_url=$link;
						$count++;
					}
			}

		public function getPageTitle()
			{
				$pg_title = $this->LANG['playlistnew_title'];

				switch($this->fields_arr['pg'])
					{
						case 'myplaylists':
							$pg_title = $this->LANG['myplaylists_title'];
							break;

						case 'userplaylist':
							$pg_title = $this->LANG['userplaylist_title'];

							$fields_list = array('user_name', 'first_name', 'last_name');
							if(!isset($this->UserDetails[$this->fields_arr['user_id']]))
								$this->getUserDetail('user_id',$this->fields_arr['user_id'], 'user_name');
							$name = $this->getUserDetail('user_id',$this->fields_arr['user_id'], 'user_name');

							$pg_title = str_replace('{user_name}', $name, $pg_title);
							break;

						default://playlistnew
							$pg_title = $this->LANG['playlistnew_title'];
							/*if($this->fields_arr['cid'])
								{
									$pg_title = $this->LANG['categoryplay_list_name'];
									$name = $this->getCategoryName();
									$pg_title = str_replace('{category_name}', $name, $pg_title);
								}*/
							if($this->fields_arr['tags'])
								{
									//$pg_title = $this->LANG['tagsplay_list_name'];
									$name = $this->fields_arr['tags'];
									$pg_title = str_replace('{tags_name}', $name, $pg_title);
								}
							break;
					}
				return $pg_title;
			}
	}
$playlist = new Playlist();
$playlist->resetFields();
$playlist->setFormField('tags', '');
$playlist->sanitizeFormInputs($_REQUEST);
$playlist->setTableAndColumns();
$playlist->buildSelectQuery();
$playlist->buildQuery();
$playlist->executeQuery();
//$playlist->printQuery();
$playlist->setFormField('vpkey', '');

if(!isMember())
	Redirect2URL($playlist->getUrl('login','',''));

if($playlist->isResultsFound())
	{
		if($CFG['feature']['rewrite_mode']!='normal')
				$paging_arr = array();
			else
				$paging_arr = array();
		$smartyObj->assign('smarty_paging_list', $playlist->populatePageLinksGET($playlist->getFormField('start'), $paging_arr));
		$playlist->showPlaylist=$playlist->showPlaylist();
	}
$LANG['play_list_name'] = $playlist->getPageTitle();
//include the header file
$playlist->includeHeader();
//include the content of the page
setTemplateFolder('general/','video');
$smartyObj->display('videoPlayList.tpl');
//includ the footer of the page
//<<<<<<--------------------Page block templates Ends--------------------//
$playlist->includeFooter();
?>