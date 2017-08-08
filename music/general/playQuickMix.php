<?php
/**
 * PlayQuickMix
 *
 * @category	Rayzz
 * @package		General
 * @author 		shankar_044at09
 * @copyright 	Copyright (c) 2009 - 2010 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 */
class PlayQuickMix extends MusicHandler
	{

	}

$playQuickmixs = new PlayQuickMix();
$playQuickmixs->setPageBlockNames(array('block_music_playlist_player', 'block_music_add_quickmix'));

if(isset($_SESSION['user']['music_quick_mixs']) && !empty($_SESSION['user']['music_quick_mixs']))
	$playQuickmixs->setFormField('music_id', $_SESSION['user']['music_quick_mixs']);
else
	$playQuickmixs->setFormField('music_id', '');
//START TO GENERATE THE QUICKMIX PLAYER ARRAY FIELDS
$auto_play =  'false';
if($CFG['admin']['musics']['playlist_player']['QuickmixPlayerAutoPlay'])
	$auto_play =  'true';

$playlist_auto_play =  false;
if($CFG['admin']['musics']['playlist_player']['QuickmixPlaylistPlayerAutoPlay'])
	$playlist_auto_play =  true;

$music_fields = array(
	'div_id'               => 'flashcontent',
	'music_player_id'      => 'quickMix_Songs',
	'width'  		       => '598',
	'height'               => '174',
	'auto_play'            => $auto_play,
	'hidden'               => false,
	'playlist_auto_play'   => $playlist_auto_play
);

$smartyObj->assign('music_fields',$music_fields);
//END TO GENERATE THE QUICKMIX PLAYER ARRAY FIELDS

$playQuickmixs->setFormField('playlist_id', 0);
$playQuickmixs->setFormField('clearall', '');
$playQuickmixs->setAllPageBlocksHide();

if(isset($_SESSION['user']['music_quick_mixs']) && !empty($_SESSION['user']['music_quick_mixs']))
	$playQuickmixs->setPageBlockShow('block_music_playlist_player');
else
	$playQuickmixs->setPageBlockShow('block_music_add_quickmix');

$playQuickmixs->sanitizeFormInputs($_REQUEST);

if($playQuickmixs->getFormField('clearall'))
{
	$playQuickmixs->setCommonSuccessMsg($LANG['common_msg_quickmix_remove']);
	$playQuickmixs->setPageBlockShow('block_msg_form_success');
}
//$smartyObj->assign('error_message',$error_message);
if ($playQuickmixs->isShowPageBlock('block_music_playlist_player'))
	{
		//Initializing Playlist Player Configuaration
		$playQuickmixs->populatePlayerWithPlaylistConfiguration();
		$playQuickmixs->configXmlcode_url .= 'pg=music';
		//$playQuickmixs->playlistXmlcode_url .= 'pg=music_'.$playQuickmixs->getFormField('playlist_id').'_'.implode(',', $MusicList->player_music_id);
		$playQuickmixs->playlistXmlcode_url .= 'pg=music_'.$playQuickmixs->getFormField('playlist_id').
															'_'.$playQuickmixs->getFormField('music_id');

	}
$playQuickmixs->savePlaylistUrl = $CFG['site']['music_url'].'createPlaylist.php?action=save_playlist&light_window=1&qm=true';

$playQuickmixs->includeHeader();
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript" language="javascript">
var site_url = '<?php echo $CFG['site']['music_url'];?>';
//To handle window opener object
function saveHandle()
	{
	    if (!window.opener.quickMixPopupWindow)
			{
		        window.opener.quickMixPopupWindow = this;
		    }
		setTimeout("saveHandle()",1000);
	}
setTimeout("saveHandle()",1000);
</script>
<?php
setTemplateFolder('general/', 'music');
$smartyObj->display('playQuickMix.tpl');
$playQuickmixs->includeFooter();
?>