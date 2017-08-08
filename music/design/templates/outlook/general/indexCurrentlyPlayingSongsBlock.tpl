{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="playing_top"}
    <div class="clsCurrentlyPlayingSection">
        <h3>{$LANG.sidebar_currentlyplaying_label}</h3>
          {if $myobj->sidebar_currently_playing_block.populateCurrentlyPlayingSongsDetail.record_count}
                  <div class="clsCurrentlyPlayingContent">
                        <div id="currently_playing_musics"></div>
                        <script type="text/javascript">
                              var so1 = new SWFObject("{$myobj->recentmusic_flv_player_url}", "playList", "236", "250", "5",  null, true);
                              so1.addParam("allowSciptAccess", "always");
                              so1.addParam("wmode", "transparent");
                              so1.addVariable("xmlpath", "{$myobj->recentmusic_configXmlcode_url}");
                              so1.addVariable("listCounts", "{$CFG.admin.musics.index_page_music_list_total_thumbnail}");
                              so1.write("currently_playing_musics");
                        </script>
                  </div>
        {else}
        	<div class="clsNoRecordsFound">
            	{$LANG.sidebar_no_audio_found_error_msg}
		</div>
        {/if}                  
 </div>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="playing_bottom"}
