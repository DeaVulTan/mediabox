<?php
require_once($CFG['site']['project_path'].'languages/'.$CFG['lang']['default'].'/music/indexMusicBlock.php');
require_once($CFG['site']['project_path'].'common/configs/config_music.inc.php');
require_once($CFG['site']['project_path'].'common/classes/class_MusicHandler.lib.php');
/**
 * IndexPageMusicHandler
 *
 * @package
 * @author edwin_90ag08
 * @copyright Copyright (c) 2009
 * @version $Id$
 * @access public
 */
class IndexPageMusicHandler extends MusicHandler
	{
	public $chk_for_music_first_block = false;
	  /**
	   * IndexPageMusicHandler::getMusicIndexBlock()
	   *
	   * @param mixed $music_block
	   * @param integer $totalMusicCount
	   * @param integer $start
	   * @return
	   */
	  public function getMusicIndexBlock($music_block, $all = false)
			{
			   	global $smartyObj;
				$this->setFormField('block', $music_block);
				$totalMusicCount = $this->getFormField('total_music_count');
				$start = $this->getFormField('start');

				$default_cond = 'u.usr_status=\'Ok\' AND m.music_status=\'Ok\''.$this->getAdultQuery('m.', 'music').'
				                 AND (m.user_id = '.$this->CFG['user']['user_id'].' OR'.
							     ' m.music_access_type = \'Public\''.$this->getAdditionalQuery().')';

				$default_fields = 'm.user_id, m.music_id, m.music_title, m.music_caption, m.total_views, m.music_server_url,'.
								   ' (rating_total/rating_count) as rating,TIME_FORMAT(m.playing_time,\'%H:%i:%s\') as playing_time, '.
								   ' TIMEDIFF(NOW(), m.date_added) as music_date_added,TIMEDIFF(NOW(),m.last_view_date) as music_last_view_date, music_tags, music_ext,music_thumb_ext,file_name';
				$list_lang='';
				$link_text='';
				$this->music_block=$music_block;
				$order_by = '';
				$userid_arr = array();
				$fields_list = array('user_name', 'first_name', 'last_name');

				switch($music_block)
					{
						case 'recommendedmusic':
						   	$total_row = $this->CFG['admin']['musics']['music_block_total_row_record'];
						   	$record_per_row = $this->CFG['admin']['musics']['recommendedmusic_total_record'];
							$limit = $total_row * $record_per_row;
							$condition = ' '.$default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['music'].' AS m'.
							' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON m.user_id=u.user_id'.
						    ' LEFT JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'.
					   				' WHERE '.$condition.' ORDER BY music_id DESC LIMIT '.$start.','.$limit;
							$all_music_url = getUrl('musiclist','?pg=musicrecommended', 'musicrecommended/','','music');
							break;

						case 'topratedmusic':
						   	$total_row = $this->CFG['admin']['musics']['music_block_total_row_record'];
						   	$record_per_row = $this->CFG['admin']['musics']['topratedmusic_total_record'];
							$limit = $total_row * $record_per_row;
							$condition = 'rating_total>0 AND allow_ratings=\'Yes\' AND '.$default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['music'].' AS m'.
							       ' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON m.user_id=u.user_id'.
						           ' LEFT JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'.
					   				' WHERE '.$condition.' ORDER BY rating DESC LIMIT '.$start.','.$limit;
							$all_music_url = getUrl('musiclist','?pg=musictoprated', 'musictoprated/','','music');
							break;

						case 'newmusic':
						   	$total_row = $this->CFG['admin']['musics']['music_block_total_row_record'];
						   	$record_per_row = $this->CFG['admin']['musics']['newmusic_total_record'];
							$limit = $total_row * $record_per_row;
							$condition = $default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['music'].' AS m'.
							   	    ' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON m.user_id=u.user_id'.
						            ' LEFT JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'.
					   				' WHERE '.$condition.' ORDER BY music_id DESC LIMIT '.$start.','.$limit;
							$all_music_url = getUrl('musiclist','?pg=musicnew', 'musicnew/','','music');
							break;

						case 'recentlyviewedmusic':

						   	$total_row=$this->CFG['admin']['musics']['music_block_total_row_record'];
						   	$record_per_row = $this->CFG['admin']['musics']['recentlyviewedmusic_total_record'];
							$limit = $total_row * $record_per_row;
							$condition = $default_cond;
							$sql = 'SELECT '.$default_fields.' FROM '.$this->CFG['db']['tbl']['music'].' AS m'.
							        ' LEFT JOIN '.$this->CFG['db']['tbl']['users'].' AS u ON m.user_id=u.user_id'.
						            ' LEFT JOIN '.$this->CFG['db']['tbl']['music_files_settings'].' ON music_file_id = thumb_name_id'.
					   				' WHERE '.$condition.' ORDER BY last_view_date DESC LIMIT '.$start.','.$limit;
							$all_music_url = getUrl('musiclist','?pg=musicmostrecentlyviewed', 'musicmostrecentlyviewed/','','music');

							break;


					}

				//echo $sql;
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt);
			    if (!$rs)
				    trigger_error($this->dbObj->ErrorNo().' '.
						$this->dbObj->ErrorMsg(), E_USER_ERROR);

				$record_count = $rs->PO_RecordCount();
				if($all)
					{
						return $record_count;
					}

				$this->musics_per_page=$limit;
				$musicsPerRow = isset($this->CFG['admin']['musics'][$music_block.'_total_record'])?$this->CFG['admin']['musics'][$music_block.'_total_record']:$this->CFG['site']['index_rec_per_row_count'];
				$count = 0;
				$found = false;
				$this->no_of_row=1;
				$allow_quick_links=(isLoggedIn() and $this->CFG['admin']['musics']['allow_quick_links'])?true:false;
				$this->allow_quick_links=$allow_quick_links;
				if ($record_count)
				    {
						$found = true;
						$this->all_music_url=$all_music_url;
						$this->link_text=$link_text;
						$thumbnail_folder = $this->CFG['media']['folder'].'/'.
											$this->CFG['admin']['musics']['folder'].'/'.
											$this->CFG['admin']['musics']['thumbnail_folder'].'/';

						$separator = ':&nbsp;';
						$tag = array();
						$relatedTags = array();
						$musicTags = array();
						$music_list_arr = array();
						$inc = 0;

						while($row = $rs->FetchRow())
						    {
								if(!isset($this->UserDetails[$row['user_id']]))
									$this->UserDetails[$row['user_id']] = $this->getUserDetail('user_id', $row['user_id']);

								if($this->UserDetails[$row['user_id']]['user_name'] != '')
									{
										$name = $this->getUserName($row['user_id']);

										$music_list_arr[$inc]['music_date_added'] = getTimeDiffernceFormat($row['music_date_added']);
										$music_list_arr[$inc]['music_last_view_date'] = getTimeDiffernceFormat($row['music_last_view_date']);
										$music_list_arr[$inc]['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';
										$music_list_arr[$inc]['open_tr']=false;
										if ($count%$musicsPerRow==0)
										    {
											 $music_list_arr[$inc]['open_tr']=true;
											 $this->no_of_row++;
										    }
										$this->allow_quick_links=$allow_quick_links;
										$smartyObj->assign('allow_quick_links', $allow_quick_links);
										$music_list_arr[$inc]['music_url']=getUrl('music','?music_id='.$row['music_id'].'&title='.$this->changeTitle($row['music_title']), $row['music_id'].'/'.$this->changeTitle($row['music_title']).'/','','music');
										$music_list_arr[$inc]['image_url']=$row['music_server_url'].$thumbnail_folder.getMusicImageName($row['music_id']).$this->CFG['admin']['musics']['thumb_name'].'.'.$row['music_thumb_ext'];
										$music_list_arr[$inc]['music_title']=$row['music_title'];
										$row['music_caption']=$row['music_caption'];
										$music_list_arr[$inc]['record']=$row;
										if (!in_array($row['user_id'], $userid_arr))
										$userid_arr[] = $row['user_id'];

										$tags= $this->_parse_tags($row['music_tags']);
										$music_list_arr[$inc]['tags']='';
										if ($tags)
										    {
										        $i = 0;
										        $tags_arr=array();
												foreach($tags as $key=>$value)
													{
														if($this->CFG['admin']['musics']['tags_count_list_page']==$i)
															break;
														$value = strtolower($value);

														if (!in_array($value, $tag) AND !in_array($value, $relatedTags))
															$relatedTags[] = $value;

														if (!in_array($value, $musicTags))
													        $musicTags[] = $value;

													    $tags_arr[$i]['tag_name']=$value;
													    $tags_arr[$i]['tag_url']=getUrl('musiclist','?pg=musicnew&tags='.$value, 'musicnew/?tags='.$value);
														$i++;
													}
												$music_list_arr[$inc]['tags']=$tags_arr;

											 }

										$count++;
										$music_list_arr[$inc]['end_tr']=false;
										if ($count%$musicsPerRow==0)
										    {
												$count = 0;
												$music_list_arr[$inc]['end_tr']=true;
										    }
									  $inc++;
									}
				    		}//while
				    	$this->musicblock_last_tr_close = false;
						if ($found and $count and $count<$musicsPerRow)
						    {
					    		$this->musicblock_last_tr_close  = true;
				  	    		$this->music_per_row=$musicsPerRow-$count;
					    	}
							$musicblock_next_css=(($totalMusicCount-1) > $start)?'clsNextActive next':'next';
							$musicblock_prev_css=(($start > 0))?'clsPreviousActive previous':'previous';
							$this->musicblock_next_css =$musicblock_next_css;
							$this->musicblock_prev_css =$musicblock_prev_css;
							$this->musicblock_next_link=0;
							$this->musicblock_prev_link=0;
							$this->music_block=$music_block;
							if(($totalMusicCount-1) > $start)
							{
							$this->musicblock_next_link=1;
							}
							if($start > 0)
							{
							$this->musicblock_prev_link=1;
							}
							 $this->no_of_row--;
					}
				else
					{
					   $music_list_arr=0;
					}
					if(!isAjaxPage())
					{
					?>
					<script language="javascript" type="text/javascript">
						//for music recently viewed paging
						var music<?php echo $music_block;?> = new paging();
						music<?php echo $music_block;?>.paging_var = 'start';
						music<?php echo $music_block;?>.paging_content_id = 'sel<?php echo $music_block;?>List';
						music<?php echo $music_block;?>.paging_link_id = 'nav_<?php echo $music_block;?>';
						music<?php echo $music_block;?>.page_no_id = 'sel<?php echo $music_block;?>PageNo';
						music<?php echo $music_block;?>.page_no_text = '<?php echo $this->LANG['indexmusicblock_page_number_text'];?>';
						music<?php echo $music_block;?>.total_records = '<?php echo $this->getMusicIndexBlock($music_block, true);?>';
						music<?php echo $music_block;?>.records_per_page = '<?php echo $this->musics_per_page;?>';
						music<?php echo $music_block;?>.class_obj = 'music<?php echo $music_block;?>';
						music<?php echo $music_block;?>.paging_url = '<?php echo getCurrentUrl();?>';
						music<?php echo $music_block;?>.method_type = 'post';
						music<?php echo $music_block;?>.pars = 'block=<?php echo $music_block;?>&module=music';
						//currently simple paging only available
						music<?php echo $music_block;?>.paging_style = 'simple';//simple, extend
						music<?php echo $music_block;?>.carousel = true;
						music<?php echo $music_block;?>.anim_speed = 50;
						music<?php echo $music_block;?>.initPaging();
					</script>
					<?php
						}
					$user_ids = implode(',', $userid_arr);
					$this->getMultiUserDetails($user_ids, $fields_list);

					//return $music_list_arr;
					$smartyObj->assign('LANG', $this->LANG);
					$smartyObj->assign('CFG', $this->CFG);
					$smartyObj->assign('myobj', $this);
					$smartyObj->assign('start', $start);
					$smartyObj->assign('music_list_arr', $music_list_arr);
					setTemplateFolder('general/','music');
					$smartyObj->display('musicListIndexBlock.tpl');
			}

		public function setClassForList()
			{
				if(!isAjaxPage() and chkAllowedModule(array('music')))
					{
						$pag_arr = array('recentlyviewedmusic', 'recommendedmusic', 'newmusic', 'topratedmusic');
						foreach($pag_arr as $music_block)
							{
								if(!$this->chk_for_music_first_block)
									{
										$this->chk_for_music_first_block = $music_block;
									}
								$li = $music_block.'_li_class';
								$span = $music_block.'_span_class';
								$this->$li = ($this->chk_for_music_first_block==$music_block)?'clsActiveIndexLink':'';
								$this->$span = ($this->chk_for_music_first_block==$music_block)?'clsActiveMusicLinkRight':'';
								$this->chk_for_music_block_display = ($this->chk_for_music_first_block==$music_block)?'':'display:none;';
							}
					}
			}

  }
//-------------------- Code begins -------------->>>>>//
$musicIndex = new IndexPageMusicHandler();
$musicIndex->setFormField('start', 0);
$musicIndex->setFormField('total_music_count', 5);
$musicIndex->setFormField('block', 'recentlyviewedmusic');
$musicIndex->setFormField('play_list','0');
$smartyObj->assign('LANG',$LANG);
$smartyObj->assign('musicIndexObj',$musicIndex);
$musicIndex->sanitizeFormInputs($_REQUEST);
$musicIndex->setClassForList();
$CFG['site']['music_url']=$CFG['site']['url'].'music/';
if(isAjaxPage() and $musicIndex->isFormPOSTed($_POST, 'block'))
	{
		$musicIndex->includeAjaxHeaderSessionCheck();
		switch($musicIndex->getFormField('block'))
			{
				default:
					$musicIndex->getMusicIndexBlock($musicIndex->getFormField('block'));
			}
		$musicIndex->includeAjaxFooter();
		exit;
	}
//<<<<--------------------music block javascript start ----------------------------//
?>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG['site']['url'];?>design/templates/<?php echo $CFG['html']['template']['default'];?>/root/css/<?php echo $CFG['html']['stylesheet']['screen']['default'];?>/music.css">
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/index_music.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/musicDetailsToolTip.js"></script>
<?php
 if(chkAllowedModule(array('music')))
		{
			if(!isAjaxPage())
				{
?>
                   	<style>
						/* for carousel */
						.clsMusicListCount ul{
						  margin: 0;
						  padding:0;
						  width: 100000px;
						  position: relative;
						  top: 0;
						  left: 0;
						  height: 150px;
						}

						.clsMusicListCount li {
						  text-align: left;
						  float:left;
						  width:600px;
						}
						.clsCarouselList td{
							text-align:left;
							vertical-align:top;
							padding:5px 7px;
						}
					</style>

<?php
		     }
     }

//<<<<--------------------music block javascript End ----------------------------//
?>
<script language="javascript" type="text/javascript" src="<?php echo $CFG['site']['project_path_relative'];?>js/AG_ajax_html.js"></script>