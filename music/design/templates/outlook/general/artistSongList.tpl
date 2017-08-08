{if $myobj->isShowPageBlock('artistl_songlist_block')}
    <table >
        <tr>
            <th>{$LANG.musicplaylist_admin_songlist_id}</th>
            <th>{$LANG.musicplaylist_admin_songlist_songtitle}</th>
        </tr>
        {if $getArtistSongList_arr.record_count}
            {foreach key=songListKey item=songListValue from=$getArtistSongList_arr.row}
                <tr>
                    <td>{$songListKey}</td>
                    <td><p title="{$songListValue.record.music_title}"><strong>{$songListValue.wordWrap_mb_ManualWithSpace_music_title}</strong>(<span title="{$songListValue.record.album_title}" >{$songListValue.wordWrap_mb_ManualWithSpace_album_title}</span>)</p></td>
                </tr>
            {/foreach}   
        {else} 
            <tr>
                <td colspan="2">{$LANG.musicplaylist_admin_songlist_norecords_found}</td>
            </tr>
        {/if}    
    </table>
{else}   
	{if $getArtistSongList_arr.record_count}
            {foreach key=songListKey item=songListValue from=$getArtistSongList_arr.row}
	         	<p title="{$songListValue.record.music_title}"><strong>{$songListValue.wordWrap_mb_ManualWithSpace_music_title}</strong>(<span title="{$songListValue.record.album_title}" >{$songListValue.wordWrap_mb_ManualWithSpace_album_title}</span>)</p>
            {/foreach}   
     {/if} 
{/if}