<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgCartSuccess');
</script>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="sidebar_top"}
    <div class="clsAudioIndex clsAudioTrackerBlock">
    	<h3>{$LANG.sidebar_audio_tracker_label}</h3>
        {if $populateAudioTracker_arr.record_count}
           {foreach item=trackerValue from=$populateAudioTracker_arr.row }
                <div class="clsAudioTrackerContainer">
                    <div class="clsATDetials">
                        <p class="clsATName" title="{$trackerValue.record.music_title}"><a href="{$trackerValue.viewmusic_url}" alt="{$trackerValue.record.music_title}" title="{$trackerValue.record.music_title}">{$trackerValue.record.music_title}</a><span class="clsATDay">{$trackerValue.getTimeDiffernceFormat_last_viewed}</span></p>
						<p class="clsTopchartalbum"><span>{$LANG.myhome_my_music_tracker_album}</span><a href="{$trackerValue.viewalbum_url}" alt="{$trackerValue.record.album_title}" title="{$trackerValue.record.album_title}">{$trackerValue.record.album_title}</a></p>
                    </div>
                  <div class="clsPlayerIcon">
				   
                        <a class="clsPlaySong" id="music_tracker_play_music_icon_{$trackerValue.record.music_id}" onclick="playSelectedSong({$trackerValue.record.music_id}, 'music_tracker')" href="javascript:void(0)" title="{$LANG.common_play}" alt="{$LANG.common_play}"></a>
                        <a class="clsStopSong" id="music_tracker_play_playing_music_icon_{$trackerValue.record.music_id}" onclick="stopSong({$trackerValue.record.music_id}, 'music_tracker')" style="display:none" href="javascript:void(0)" title="{$LANG.common_stop}" alt="{$LANG.common_stop}"></a>
                  </div>
                </div>
            {/foreach}
            <p class="clsViewMore"><a href="{$audiotracker_url}" alt="{$LANG.sidebar_music_more_label}" title="{$LANG.sidebar_music_more_label}">{$LANG.sidebar_music_more_label}</a></p>
         {else}
         	<div class="clsNoRecordsFound"> {$LANG.sidebar_no_audio_found_error_msg}</div>
         {/if}

    </div>
    <div id="selMsgCartSuccess" class="clsPopupConfirmation" style="display:none;">
              <p id="selCartAlertSuccess"></p>
              <form name="msgCartFormSuccess" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_option_ok}"
                tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
              </form>
            </div>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="sidebar_bottom"}