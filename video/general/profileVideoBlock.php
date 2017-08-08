<?php
//require_once($CFG['site']['project_path'].'languages/'.$CFG['lang']['default'].'/video/indexVideoBlock.php');
//require_once($CFG['site']['project_path'].'common/configs/config_video.inc.php');
/**
 * profilePageVideoHandler
 *
 * @package
 * @author edwin_90ag08
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id$
 * @access public
 */
global $CFG;
require_once($CFG['site']['project_path'].'common/classes/class_VideoHandler.lib.php');
require_once($CFG['site']['project_path'].'common/configs/config_video.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_video_player.inc.php');

if(class_exists('VideoHandler'))
	{
		class ProfileVideoHandler extends VideoHandler{}
	}
elseif(class_exists('MediaHandler'))
	{
	 	class ProfileVideoHandler extends MediaHandler{}
	}
class profilePageVideoHandler extends ProfileVideoHandler
 {
  public $isCurrentUser = false;
  public $showEditableLink = false;
  public function getMyVideoBlock($start=0, $videoLimit=3)
		   {
		   	   	global $smartyObj;
				$condition = 'video_status=\'Ok\''.$this->getAdultQuery('v.').' AND user_id=\''.$this->fields_arr['user_id'].'\''.
							' AND (user_id = '.$this->CFG['user']['user_id'].
							' OR video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';

				$sql = 'SELECT video_id, video_ext, t_width, t_height, video_server_url,s_width,s_height,t_width,t_height,l_width,l_height,video_title, TIMEDIFF(NOW(), date_added) as video_date_added, TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time, total_views,is_external_embed_video,embed_video_image_ext '.
						' FROM '.$this->CFG['db']['tbl']['video'].' AS v WHERE '.$condition.' ORDER BY'.
						' video_id DESC LIMIT '.$start.','.$videoLimit;

                // prepare sql
                $stmt = $this->dbObj->Prepare($sql);
                // execute sql
                $rs = $this->dbObj->Execute($stmt);
                //raise user error... fatal
                if (!$rs)
                	trigger_db_error($this->dbObj);
                $this->videoDisplayed = false;

                $video_list_arr = array();
				$inc = 0;
                	if ($rs->PO_RecordCount())
                		{
						 $this->videoDisplayed = true;
					$thumbnail_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/'.$this->CFG['admin']['videos']['thumbnail_folder'].'/';
                    		while($row = $rs->FetchRow())
                			    {
									$video_path = $row['video_server_url'].$thumbnail_folder.getVideoImageName($row['video_id']).$this->CFG['admin']['videos']['small_name'].'.'.$this->CFG['video']['image']['extensions'];
									if (($row['is_external_embed_video'] == 'Yes' && $row['embed_video_image_ext'] == ''))
								    {
                    					$video_path = $this->CFG['site']['url'].'video/design/templates/'.
														$this->CFG['html']['template']['default'].'/root/images/'.
															$this->CFG['html']['stylesheet']['screen']['default'].
																'/no_image/noImageVideo_S.jpg';;
                                    }

									$widthHeightAttr = DISP_IMAGE($this->CFG['admin']['videos']['thumb_width'], $this->CFG['admin']['videos']['thumb_height'], $row['t_width'], $row['t_height']);
									$row['video_date_added'] = getTimeDiffernceFormat($row['video_date_added']);
									$row['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';
									$video_list_arr[$inc]['playing_time']=$row['playing_time'];
									$video_list_arr[$inc]['videoUrl']=getUrl('viewvideo','?video_id='.$row['video_id'].'&title='.$this->changeTitle($row['video_title']), $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/','','video');
									$video_list_arr[$inc]['video_date_added']=$row['video_date_added'];
									$video_list_arr[$inc]['total_views']=$row['total_views'];
									$video_list_arr[$inc]['video_title']=$row['video_title'];
									$video_list_arr[$inc]['video_wrap_title']=wordWrap_mb_Manual($row['video_title'], $this->CFG['admin']['videos']['profile_video_list_title_length'], $this->CFG['admin']['videos']['profile_video_list_title_total_length']);;
									$video_list_arr[$inc]['video_path']=$video_path;
									$video_list_arr[$inc]['t_width']=$row['t_width'];
									$video_list_arr[$inc]['t_height']=$row['t_width'];
									$video_list_arr[$inc]['s_width']=$row['s_width'];
									$video_list_arr[$inc]['s_height']=$row['s_height'];
									$video_list_arr[$inc]['l_width']=$row['l_width'];
									$video_list_arr[$inc]['l_height']=$row['l_height'];
									$video_list_arr[$inc]['widthHeightAttr']=$widthHeightAttr;
									$inc++;

						       } // while

				      }
				else
					{
					$video_list_arr=0;
        			}
        		$smartyObj->assign('videoDisplayed', $this->videoDisplayed);
        		$smartyObj->assign('video_list_arr', $video_list_arr);
        		$uservideolistURL=getUrl('videolist','?pg=uservideolist&user_id='.$this->fields_arr['user_id'], 'uservideolist/?user_id='.$this->fields_arr['user_id'],'','video');
        		$smartyObj->assign('uservideolistURL', $uservideolistURL);
        		$smartyObj->assign('myobj', $this);
        		//$smartyObj->assign('LANG', $LANG);

	    	}

	    public function setUserId()
			{
				$userName = $this->fields_arr['user'];
				$sql = 'SELECT user_id FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_name='.$this->dbObj->Param($userName).' AND usr_status=\'Ok\' LIMIT 1';
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($userName));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = array();
				if ($rs->PO_RecordCount())
					{
				        $row = $rs->FetchRow();
						$this->fields_arr['user_id'] = $row['user_id'];
						$this->isValidUser = true;
						$this->isCurrentUser = (strcmp($this->CFG['user']['user_id'], $this->fields_arr['user_id'])==0);
						$edit = $this->fields_arr['edit'];
						$edit = (strcmp($edit, '1')==0);
						$this->showEditableLink = ($this->isCurrentUser and $edit);
					}
			}
		public function checkUserId()
			{
				$user_id = $this->fields_arr['user_id'];
				$sql = 'SELECT 1 FROM '.$this->CFG['db']['tbl']['users'].' WHERE user_id='.$this->dbObj->Param($user_id);
				// prepare sql
				$stmt = $this->dbObj->Prepare($sql);
				// execute sql
				$rs = $this->dbObj->Execute($stmt, array($user_id));
				//raise user error... fatal
				if (!$rs)
					trigger_db_error($this->dbObj);
				$row = array();
				$this->isValidUser = ($rs->PO_RecordCount() > 0);
				$this->isCurrentUser = (strcmp($this->CFG['user']['user_id'], $user_id)==0);
				$edit = $this->fields_arr['edit'];
				$edit = (strcmp($edit, '1')==0);
				$this->showEditableLink = ($this->isCurrentUser and $edit);
			}
		public function getFeaturedVideoBlock()
		   {
		   	   	global $smartyObj;
				$condition = 'video_status=\'Ok\''.$this->getAdultQuery('v.').' AND vf.user_id=\''.$this->fields_arr['user_id'].'\''.
							' AND (v.user_id = '.$this->CFG['user']['user_id'].
							' OR video_access_type = \'Public\''.$this->getAdditionalQuery('v.').')';

				$sql = 'SELECT v.video_id, video_ext, t_width, t_height, video_server_url,video_title, TIMEDIFF(NOW(), v.date_added) as video_date_added, TIME_FORMAT(playing_time,\'%H:%i:%s\') as playing_time, total_views,is_external_embed_video,video_external_embed_code,embed_video_image_ext '.
						' FROM '.$this->CFG['db']['tbl']['video'].' AS v JOIN '.$this->CFG['db']['tbl']['video_featured'].' as vf ON vf.video_id=v.video_id WHERE '.$condition.' ORDER BY'.
						' video_id DESC';

                // prepare sql
                $stmt = $this->dbObj->Prepare($sql);
                // execute sql
                $rs = $this->dbObj->Execute($stmt);
                //raise user error... fatal
                if (!$rs)
                	trigger_db_error($this->dbObj);
                $this->videoDisplayed = false;
                $featured_video_list_arr = array();
				$this->isFeaturedvideo = false;
				$this->setFormField('video_id',0);
				$featured_video_list_arr['video_id']=0;
                	if ($rs->PO_RecordCount())
                		{
                    		if($row = $rs->FetchRow())
                			    {
                			        $this->isFeaturedvideo = true;
                			      	$featured_video_list_arr['video_title']=wordWrap_mb_Manual($row['video_title'],$this->CFG['profile']['featured_video_title_length'],$this->CFG['profile']['featured_video_title_total_length']);
                			      	$featured_video_list_arr['video_id']=$row['video_id'];
                			      	$featured_video_list_arr['is_external_embed_video']=$row['is_external_embed_video'];
                			      	$featured_video_list_arr['video_external_embed_code']='';
                			      	if($row['is_external_embed_video']=='Yes')
                			      	$featured_video_list_arr['video_external_embed_code']=html_entity_decode($row['video_external_embed_code']);
                			      	$this->setFormField('video_id',$row['video_id']);
                			      	$row['video_date_added'] = getTimeDiffernceFormat($row['video_date_added']);
									$row['playing_time'] = $row['playing_time']?$row['playing_time']:'00:00';
									$featured_video_list_arr['playing_time']=$row['playing_time'];
									$featured_video_list_arr['videoUrl']=getUrl('viewvideo','?video_id='.$row['video_id'].'&title='.$this->changeTitle($row['video_title']), $row['video_id'].'/'.$this->changeTitle($row['video_title']).'/','','video');
									$featured_video_list_arr['video_date_added']=$row['video_date_added'];
									$featured_video_list_arr['total_views']=$row['total_views'];

						       }

				      }

				$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/';
		 	   	$this->populateFlashPlayerConfiguration();
				$this->arguments_play = 'pg=video_'.$featured_video_list_arr['video_id'].'_no_'.getRefererForAffiliate().'_false';
				$this->CFG['admin']['videos']['playList']=false;
				$configXmlUrl=$this->configXmlcode_url.$this->arguments_play;
        		$smartyObj->assign('isFeaturedvideo', $this->isFeaturedvideo);
        		$smartyObj->assign('featured_video_list_arr', $featured_video_list_arr);
        		$smartyObj->assign('flv_player_url', $this->flv_player_url);
        		$smartyObj->assign('configXmlUrl',$configXmlUrl);
        		$smartyObj->assign('myobj', $this);
	    	}




 }

//-------------------- Code begins -------------->>>>>//
$videoBlock = new profilePageVideoHandler();
global $CFG;
//$videoBlock->setFormField('user_id', 0);
$videoBlock->setFormField('user_id', 0);
$videoBlock->setFormField('user', 0);
$videoBlock->setFormField('edit', 0);
if ($videoBlock->isPageGETed($_GET, 'user_id'))
    {
        $videoBlock->sanitizeFormInputs($_GET);
		$videoBlock->checkUserId();
    }

if ($videoBlock->isPageGETed($_GET, 'user'))
    {
        $videoBlock->sanitizeFormInputs($_GET);
		$videoBlock->setUserId();
    }
if (isset($__myProfile)) //its declared in members/myProfile.php
    {
        $videoBlock->setFormField('user_id', $CFG['user']['user_id']);
		$videoBlock->setFormField('edit', '1');
		$videoBlock->checkUserId();
    }
$userId = $videoBlock->getFormField('user_id');
if (!is_numeric($userId))
    {
        $videoBlock->setFormField('user_id', intval($userId));
    }
$videoBlock->getMyVideoBlock(0,$CFG['admin']['videos']['profile_page_total_video']);
$videoBlock->getFeaturedVideoBlock();
?>