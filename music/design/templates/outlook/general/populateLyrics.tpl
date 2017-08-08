{if !isAjaxPage()}
<div id="listenMusicLyrics" class="clsDisplayNone clsTextAlignLeft clsOverflow clsPlaylistLabel">
	<div id="clsMsgDisplay_lyrics_success" class="clsDisplayNone"></div>
    <div class="clsViewTopicLeft">
        <div class="clsViewTopicRight">
        	{if $myobj->isMember}
            <a href="{$myobj->getCurrentUrl(true)}" onclick="return populateAddLyrics('{$myobj->addlyrics_light_window_url}');" title="{$LANG.common_music_lyrics_add}">{$LANG.common_music_lyrics_add}</a>
            {else}
            <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_comment_lyrics_err_msg}','{$myobj->memberviewMusicUrl}');return false;" title="{$LANG.common_music_lyrics_add}">{$LANG.common_music_lyrics_add}</a>
            {/if}
        </div>
    </div>
    {if $myobj->getFormField('music_lyric_id')}
    <div class="clsViewTopicLeft">
        <div class="clsViewTopicRight">
            <a href="{$myobj->getCurrentUrl(true)}" onclick="return populateViewLyrics();" title="{if $myobj->getFormField('music_best_lyric')}{$LANG.viewmusic_view_bestlyrics}{else}{$LANG.viewmusic_view_lyrics}{/if}">{if $myobj->getFormField('music_best_lyric')}{$LANG.viewmusic_view_bestlyrics}{else}{$LANG.viewmusic_view_lyrics}{/if}</a>
        </div>
    </div>
    {/if}    	    
    {if isMember() && $myobj->chkisMusicOwner()}
    <div class="clsViewTopicLeft">
        <div class="clsViewTopicRight">
            <a href="{$myobj->managelyrics_url}" title="{$LANG.viewmusic_manage_lyrics_label}">{$LANG.viewmusic_manage_lyrics_label}</a>
        </div>
    </div>
    {/if}	
</div>
<div id="LyricsDiv" class="clsDisplayNone clsTextAlignLeft clsPlaylistLabel"></div>
{/if}