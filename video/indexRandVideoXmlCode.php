<?php

/**
 * This file is to get xml code
 *
 * This file is having get xml code
 *
 * PHP version 5.0
 *
 * @category	rayzz
 * @package		Index
 * @author 		selvaraj_35ag05
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: $
 * @since 		2006-05-02
 *
 **/

require_once('../common/configs/config.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_video.inc.php');
require_once($CFG['site']['project_path'].'common/configs/config_video_player.inc.php');

$CFG['site']['is_module_page']='video';

$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['mods']['include_files'][] = 'common/classes/class_MediaHandler.lib.php';
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
$CFG['auth']['is_authenticate'] = false;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

/**
 * XmlCode
 *
 * @package
 * @author selvaraj_35ag05
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @version $Id: $
 * @access public
 **/
class PlayerCode extends MediaHandler
	{

	public function getPlayer($video_id)
		{

		 	   	$videos_folder = $this->CFG['media']['folder'].'/'.$this->CFG['admin']['videos']['folder'].'/';
				if($this->CFG['admin']['videos']['SelectedPlayer']=='elite')
				{
					$this->flv_player_url= $this->CFG['site']['url'].$this->CFG['media']['folder'].'/flash/video/flvplayers/flvplayer_elite.swf';
				}
				else
				{
					$this->flv_player_url = $this->CFG['site']['video_url'].'embedPlayer.php?vid='.mvFileRayzz($video_id).'_'.$video_id;
				}

				$this->arguments_play = 'pg=video_'.$video_id.'_no_'.getRefererForAffiliate().'_false_true_false';

				if($this->fields_arr['play_list'] and ($this->fields_arr['play_list']=='pl' OR $this->fields_arr['play_list']=='ql'))
					{
						if($this->fields_arr['play_list']=='ql')
							{
								$in_str = substr($_SESSION['user']['quick_links'], 0, strrpos($_SESSION['user']['quick_links'], ','));
								$this->getNextPlayListQuickLinks($in_str, $show_first_url=false, $shw_url=false);
								$this->arguments_play .= '&next_url='.$this->play_list_next_url.'&play_list=ql';

								$_SESSION['video']['next_url']=$this->play_list_next_url.'&play_list=ql';
								$_SESSION['video']['play_list']='ql';

							}
							elseif(($this->isValidPlayList() and $this->generateNextPlayListURL()))
								{
									$this->arguments_play .= '&next_url='.$this->play_list_next_url.'&play_list=pl&playlist_id='.$this->fields_arr['playlist_id'];
									$_SESSION['video']['next_url']=$this->play_list_next_url;
									$_SESSION['video']['play_list']='pl';
									$_SESSION['video']['playlist_id']=$this->fields_arr['playlist_id'];
								}
					}
				$this->CFG['admin']['videos']['playList']=false;
				$this->arguments_embed = 'pg=video_'.$video_id.'_no_0_extsite';
				if($this->CFG['admin']['videos']['SelectedPlayer']=='elite')
				{
					$this->configXmlcode_url = $this->CFG['site']['video_url'].'elite_videoConfigXmlCode.php?';
				}
				else
				{
					$this->configXmlcode_url = $this->CFG['site']['video_url'].'videoConfigXmlCode.php?';
				}

				$width = 424;
				$height = 354;
				if($this->fields_arr['small_video'] == 'yes')
					{
						$this->arguments_play = 'pg=smallvideo_'.$video_id.'_no_'.getRefererForAffiliate();
						$this->flv_player_url = $this->CFG['site']['url'].$this->CFG['media']['folder'].'/flash/video/flvplayers/mini_flvplayer.swf';
						$this->configXmlcode_url = $this->CFG['site']['video_url'].'videoMiniPlayerConfigXmlCode.php?';
						$width = 298;
						$height = 251;
					}

				?>
                                    var so1 = new SWFObject("<?php echo $this->flv_player_url;?>", "flvplayer", "<?php echo $width; ?>", "<?php echo $height; ?>", "7",  null, true);
                                    so1.addParam("allowFullScreen", "true");
                                    so1.addParam("wmode", "transparent");
                                    so1.addParam("autoplay", "false");
                                    so1.addParam("allowSciptAccess", "always");
                                    so1.addVariable("config", "<?php echo $this->configXmlcode_url.$this->arguments_play;?>");
                                    so1.write("flashcontent2");
				<?php
		}

	}
//<<<<<-------------- Class XmlCode begins ---------------//
//-------------------- Code begins -------------->>>>>//
$PlayerCode = new PlayerCode();
$PlayerCode->setDBObject($db);
$PlayerCode->makeGlobalize($CFG,$LANG);
//default form fields and values...
$PlayerCode->setFormField('video_id', '');
$PlayerCode->setFormField('play_list', '0');
$PlayerCode->setFormField('small_video', '');
$PlayerCode->sanitizeFormInputs($_GET);
//<<<<<-------------------- Code ends----------------------//
//-------------------- Page block templates begins -------------------->>>>>//
if(isAjaxPage() || isset($_REQUEST['ajax_page']))
{

		$PlayerCode->getPlayer($PlayerCode->getFormField('video_id'));
}

?>