{if $isFeaturedmusic}
{$myobj->chkTemplateImagePathForModuleAndSwitch('music', $CFG.html.template.default, $CFG.html.stylesheet.screen.default)}
<script type="text/javascript" src="{$CFG.site.url}music/js/functions.js"></script>
<div class="clsFeaturedMusicBlockTable">
  {if $featured_music_list_arr.music_id}
	  <div class="clsProfileBlockContainer">
		<h3><a href="{$featured_music_list_arr.musicUrl}" title="{$featured_music_list_arr.music_title}">{$featured_music_list_arr.music_title}</a></h3>
		  <div class="clsSongDetailContainer" >
				{* Music Player Begins *}
					  <script type="text/javascript" src="{$CFG.site.url}js/JSFCommunicator.js"></script>
					  <script type="text/javascript" src="{$CFG.site.url}js/swfobject.js"></script>
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
							{$myobjFeaturedMusic->populatePlayerWithPlaylist($music_fields)}
							<input type="hidden" name="hidden_player_status" id="hidden_player_status" value="" />
					  {* TO GENERATE PLAYLIST PLAYER *}
				{* Music Player ends *}
		  </div>
	  </div>
 {/if}
</div>
 {else}
		<div class="clsOverflow">
			<div class="clsNoRecordsFound">{$LANG.myprofile_featuredmusic_no_records}</div>
	  </div>	
 {/if}

