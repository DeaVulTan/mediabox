{* TO GENERATE PLAYLIST PLAYER *}
			{** @param string $div_id
			 * @param string $music_player_id
			 * @param integer $width
			 * @param integer $height
			 * @param string $auto_play
			 * @param boolean $hidden
			 * @param boolean $playlist_auto_play
	     	 * @param boolean $javascript_enabled
             * @param boolean $player_ready_enabled *}
	{$myobj->populatePlayerWithPlaylist($music_fields)}
	<input type="hidden" name="hidden_player_status" id="hidden_player_status" value="" />
{* TO GENERATE PLAYLIST PLAYER *}
{if $myobj->isShowPageBlock('songlist_block')}
	{if $displaySongList_arr.record_count}
    <div class="clsDataTable clsPopupContent"><table >
        <tr>
            <th class="clsSerialNo">{$LANG.musicplaylist_admin_songlist_id}</th>
            <th>{$LANG.musicplaylist_admin_songlist_songtitle}</th>
            <th>
					{* to populate the volume control taken from music main.tpl *}
                	<div class="clsVolumeBar">
                			<div id="volume_container" class="clsVolumeDisabled" onmouseover="show_what_is_this()">
       					   <div id="volume_speaker" onclick="mute_volume()" class="clsSpeakerOn"></div>
            			   <div class="clsVolumeAdjust">
                				<div id="volume_slider" class="slider">
                  					<div id="volume_slider_bg" class="clsActiveVolume"></div>
                				</div>
            				</div>
								{* had an empty div for what is this *}
            				  <div id="volume_what_is_this" class="" onmouseover="" onmouseout="" style="visibility:hidden;"></div>
					</div>
				</th>
        </tr>
            {foreach key=songListKey item=songListValue from=$displaySongList_arr.row}
                <tr>
                    <td>{$songListKey}</td>
                    <td>
                    {if $songListValue.song_status}
	                    <p title="{$songListValue.record.music_title}"><strong>{$songListValue.wordWrap_mb_ManualWithSpace_music_title}</strong>{if $songListValue.wordWrap_mb_ManualWithSpace_album_title != ''}(<span title="{$songListValue.record.album_title}" >{$songListValue.wordWrap_mb_ManualWithSpace_album_title}</span>){/if}</p>
                   	{else}
                    	<p><strong>{$LANG.musicplaylist_private_label}</strong></p>
                    {/if}
                    </td>
                    <td><div class="clsPlayerIcon">
                      	<a class="clsPlaySong" id="play_music_icon_{$songListValue.record.music_id}" onClick="playSelectedSong({$songListValue.record.music_id})" title="Play"  href="javascript:void(0)"></a>
                      	<a class="clsStopSong" id="play_playing_music_icon_{$songListValue.record.music_id}" onClick="stopSong({$songListValue.record.music_id})" Title="Pause" style="display:none" href="javascript:void(0)"></a></div>
                   </td>
                </tr>
            {/foreach}
    </table></div>
    {else}
           <div class="clsNoRecordsFound">{$LANG.musicplaylist_admin_songlist_norecords_found}</div>
    {/if}
{else}
	{if $displaySongList_arr.record_count}
                {$myobj->setTemplateFolder('general/','music')}
                {include file='box.tpl' opt='details_top'}
                {assign var='count' value='1'}
                  <div class="clsSongListDetails">
            		{foreach key=songListKey item=songListValue from=$displaySongList_arr.row}
                    	{counter  assign=count}
                    	<p {if $lastDiv == $count} {counter start=0} class="clsNoBorder"{/if}title="{$songListValue.record.music_title}"><strong><a href="{$songListValue.viewmusic_url}">{$songListValue.wordWrap_mb_ManualWithSpace_music_title}</a></strong>{if $songListValue.wordWrap_mb_ManualWithSpace_album_title != ''}(<span title="{$songListValue.record.album_title}" ><a href="{$songListValue.viewmusic_url}">{$songListValue.wordWrap_mb_ManualWithSpace_album_title}</a></span>){/if}</p>
                    {/foreach}
                  </div>
                {$myobj->setTemplateFolder('general/','music')}
                {include file='box.tpl' opt='details_bottom'}
     {/if}
{/if}
{* FOR ALBUM PLAYER *}
		<div id="view_album_player_div" class="clsHiddenPlayer" style="display:none"><!----></div>
{* FOR GENERATE ALBUM PLAYER *}
<script type="text/javascript">
{literal}
var volume_slider = $Jq("#volume_slider").slider({
			min: 0,
			max: 100,
			value: playlist_player_volume,
			disabled: true,
			slide: function(event, ui) {
				playlist_player_volume = ui.value;
				//TO CHANGE MUTE CONTROL AND VOLUME CONTROL BACKGROUND
				toggle_volume_control(ui.value);
				setVolume(ui.value);
			},
			change: function(event, ui) {
				playlist_player_volume = ui.value;
				//TO CHANGE MUTE CONTROL AND VOLUME CONTROL BACKGROUND
				toggle_volume_control(ui.value);
				//FOR MUTE CONTROL
				//if(playlist_player_volume_mute_prev != playlist_player_volume_mute_cur)
					{
						playlist_player_volume_mute_prev = playlist_player_volume_mute_cur;
						playlist_player_volume_mute_cur = ui.value;
					}
				setVolume(ui.value);
				store_volume_in_session(ui.value);
	      	}
		});
$Jq(document).ready(function(){
	//TO CHANGE MUTE CONTROL AND VOLUME CONTROL BACKGROUND
	toggle_volume_control(playlist_player_volume);
});
{/literal}
</script>
