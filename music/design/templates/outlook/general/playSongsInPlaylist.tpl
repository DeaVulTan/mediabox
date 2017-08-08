{if $myobj->total_tracks}
<div class="clsPlaysonginPlaylist">
{$myobj->setTemplateFolder('general/','music')}
{include file='information.tpl'}
{* TO GENERATE PLAYLIST PLAYER *}
			{** @param string $div_id
			 * @param string $music_player_id
			 * @param integer $width
			 * @param integer $height
			 * @param string $auto_play
			 * @param boolean $hidden
			 * @param boolean $playlist_auto_play
 		     	 * @param boolean $javascript_enabled *}
{$myobj->populatePlayerWithPlaylist($music_fields)}
</div>
{else}
	<div id="selMsgAlert">
		<p>{$LANG.common_msg_no_playlist_song_added}</p>
	</div>
{/if}