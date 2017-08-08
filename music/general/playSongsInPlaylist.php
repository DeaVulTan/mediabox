<?php
//--------------class musicLyricsAdd--------------->>>//
/**
 * This class is used to manage music Lyrics
 *
 * @category	Rayzz
 * @package		manage music Lyrics
 */
class PlaySongsInPlaylist extends MusicHandler
	{

	}

$playSongsInPlaylist = new PlaySongsInPlaylist();
$playSongsInPlaylist->setPageBlockNames(array('block_music_playlist_player'));
//START TO GENERATE THE PLAYLIST PLAYER ARRAY FIELDS
$auto_play =  'false';
if($CFG['admin']['musics']['playlist_player']['PlaylistPlayerAutoPlay'])
	$auto_play =  'true';

$playlist_auto_play =  false;
if($CFG['admin']['musics']['playlist_player']['PlaylistAutoPlay'])
	$playlist_auto_play =  true;

$music_fields = array(
	'div_id'               => 'flashcontent',
	'music_player_id'      => 'playsongs_playlist',
	'width'  		       => $CFG['admin']['musics']['playlist_player']['width'],
	'height'               => $CFG['admin']['musics']['playlist_player']['height'],
	'auto_play'            => $auto_play,
	'hidden'               => false,
	'playlist_auto_play'   => $playlist_auto_play,
	'javascript_enabled'   => false,
	'informCSSWhenPlayerReady' => true
);

$smartyObj->assign('music_fields',$music_fields);
//END TO GENERATE THE PLAYLIST PLAYER ARRAY FIELDS

$playSongsInPlaylist->setFormField('music_id', '');
$playSongsInPlaylist->setFormField('playlist_id', 0);

$playSongsInPlaylist->setAllPageBlocksHide();
$playSongsInPlaylist->setPageBlockShow('block_music_playlist_player');

$playSongsInPlaylist->sanitizeFormInputs($_REQUEST);
if($playSongsInPlaylist->getFormField('playlist_id'))
	$playSongsInPlaylist->total_tracks = $playSongsInPlaylist->getPlaylistTotalSong($playSongsInPlaylist->getFormField('playlist_id'));
else
{
	$playSongsInPlaylist->total_tracks = ($playSongsInPlaylist->getFormField('music_id'))?count(explode(',', $playSongsInPlaylist->getFormField('music_id'))):0;
}

if ($playSongsInPlaylist->isShowPageBlock('block_music_playlist_player'))
	{
		//Initializing Playlist Player Configuaration
		$playSongsInPlaylist->populatePlayerWithPlaylistConfiguration();
		$playSongsInPlaylist->configXmlcode_url .= 'pg=music';
		//$playSongsInPlaylist->playlistXmlcode_url .= 'pg=music_'.$playSongsInPlaylist->getFormField('playlist_id').'_'.implode(',', $MusicList->player_music_id);
		if($playSongsInPlaylist->getFormField('playlist_id') != '')
			$playSongsInPlaylist->playlistXmlcode_url .= 'pg=music_'.$playSongsInPlaylist->getFormField('playlist_id').'_0';
		else
			$playSongsInPlaylist->playlistXmlcode_url .= 'pg=music_'.$playSongsInPlaylist->getFormField('playlist_id').
															'_'.$playSongsInPlaylist->getFormField('music_id');

	}

$playSongsInPlaylist->includeHeader();
?>
<script type="text/javascript" src="<?php echo $CFG['site']['music_url'];?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/JSFCommunicator.js"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['url'];?>js/swfobject.js"></script>
<script type="text/javascript">
var site_url = '<?php echo $CFG['site']['music_url'];?>';
function flashToCSS_PlayerReady()
{
	$Jq('#playsongs_playlist').addClass('clspopupplayerplaylist');
}
</script>
<?php
setTemplateFolder('general/', 'music');
$smartyObj->display('playSongsInPlaylist.tpl');
$playSongsInPlaylist->includeFooter();
?>