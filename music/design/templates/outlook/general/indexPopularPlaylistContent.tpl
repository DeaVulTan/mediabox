{if $playlist_block_record_count}
<table class="clsCarouselList">
	{* Assigned to set num. of records in each row *}
	{assign var=row_count value=4}
	{assign var=break_count value=1}
    
    <script type="text/javascript"> 
		original_height = new Array();
		original_width = new Array();
	</script>
	{assign var='array_count' value='1'}
	{foreach key=musicPlaylistKey item=musicplaylist from=$showPlaylists_arr.row}
    {if $break_count == 1}
    <tr>
    {/if}
        <td class="clsFeaturedAlbumCaroselTd">        	
            <div class="clsFeaturedalbumComtainer">
				<div class="clsFeaturedAlbumMultipleImg" onclick="Redirect2URL('{$musicplaylist.view_playlisturl}');">                
                	{if $musicplaylist.getPlaylistImageDetail.total_record gt 0}
                    {foreach key=playlistImageDetailKey item=playlistImageDetailValue from=$musicplaylist.getPlaylistImageDetail.row}
                   	{literal}
					<script language="javascript" type="text/javascript"> 
                        original_height[{/literal}{$array_count}{literal}] = '{/literal}{$playlistImageDetailValue.record.thumb_height}{literal}';
                        original_width[{/literal}{$array_count}{literal}]  = '{/literal}{$playlistImageDetailValue.record.thumb_width}{literal}';
                    </script>
                    {/literal}
                    <table><tr><td>
                    <img title="{$playlistImageDetailValue.record.music_title}" alt="{$playlistImageDetailValue.record.music_title|truncate:3}" id="t{$array_count}{$musicplaylist.record.playlist_id}" style="position:;z-index:999;display:none;" src="{$playlistImageDetailValue.playlist_thumb_path}" onmouseout="playlistImageZoom('Shrink', 's{$array_count}{$musicplaylist.record.playlist_id}', 't{$array_count}{$musicplaylist.record.playlist_id}', {$array_count}); return false;"/>
                    <img title="{$playlistImageDetailValue.record.music_title}" alt="{$playlistImageDetailValue.record.music_title|truncate:3}" id="s{$array_count}{$musicplaylist.record.playlist_id}" src="{$playlistImageDetailValue.playlist_path}" />
                    </td></tr></table>
                    {assign var=array_count value=$array_count+1}
                    {/foreach}
                    {if $musicplaylist.getPlaylistImageDetail.total_record lt 4}
                    {section name=foo start=0 loop=$musicplaylist.getPlaylistImageDetail.noimageCount step=1}
                    <table><tr><td><img title="{$musicplaylist.record.playlist_name}" alt="{$musicplaylist.record.playlist_name|truncate:3}" width="70" src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_S.jpg" /></td></tr></table>
                    {/section}	
                	{/if}
                    {else}    
                    <div class="clsSingleImage"><img title="{$musicplaylist.record.playlist_name}" alt="{$musicplaylist.record.playlist_name|truncate:3}" src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" /></div>
                    {/if}
				</div>
			</div>
            <div class="clsFeaturedAlbumDetails">
                <a href="{$musicplaylist.view_playlisturl}" title="{$musicplaylist.record.playlist_name}"><pre>{$musicplaylist.record.playlist_name}</pre></a>
                <p>{$LANG.myhome_total_tracks}: <span>{$musicplaylist.record.total_tracks}</span></p>
            </div>
        </td>
    {assign var=break_count value=$break_count+1}
    {if $break_count > $row_count}
    </tr>
    {assign var=break_count value=1}
    {/if}
    {/foreach}             
    {if $break_count != 1}
    {* Added to display empty row if last row records < row_count *}
    <td colspan="{math equation=($row_count+1)-$break_count}">&nbsp;</td>
    </tr>
    {/if}
</table>
{else}
<div class="clsNoRecordsFound">{$LANG.sidebar_no_playlist_found_error_msg}</div>
{/if}