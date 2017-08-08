{if $albums_block_record_count}
<table class="clsCarouselList">
	{* Assigned to set num. of records in each row *}
	{assign var=row_count value=4}
	{assign var=break_count value=1}
    
    <script type="text/javascript"> 
		original_height = new Array();
		original_width = new Array();
	</script>
	{assign var='array_count' value='1'}
	{foreach key=musicAlbumlistKey item=musicalbumlist from=$showAlbumlists_arr.row}
    {if $break_count == 1}
    <tr>
    {/if}
        <td class="clsFeaturedAlbumCaroselTd">        	
            <div class="clsFeaturedalbumComtainer">
            	<div class="clsFeaturedAlbumMultipleImg" onclick="Redirect2URL('{$musicalbumlist.viewAlbum_url}');">                
                	{if $musicalbumlist.getAlbumImageDetail.total_record gt 0}
                    {foreach key=albumImageDetailKey item=albumImageDetailValue from=$musicalbumlist.getAlbumImageDetail.row}
                   	{literal}
					<script language="javascript" type="text/javascript"> 
                        original_height[{/literal}{$array_count}{literal}] = '{/literal}{$albumImageDetailValue.record.thumb_height}{literal}';
                        original_width[{/literal}{$array_count}{literal}]  = '{/literal}{$albumImageDetailValue.record.thumb_width}{literal}';
                    </script>
                    {/literal}
                    <table><tr><td>
                    <img title="{$albumImageDetailValue.record.music_title}" alt="{$albumImageDetailValue.record.music_title|truncate:3}" id="album_t{$array_count}{$musicalbumlist.record.music_album_id}" style="position:;z-index:999;display:none;" src="{$albumImageDetailValue.album_thumb_path}" onmouseout="playlistImageZoom('Shrink', 'album_s{$array_count}{$musicalbumlist.record.music_album_id}', 'album_t{$array_count}{$musicalbumlist.record.music_album_id}', {$array_count}); return false;"/>
                    <img title="{$albumImageDetailValue.record.music_title}" alt="{$albumImageDetailValue.record.music_title|truncate:3}"  id="album_s{$array_count}{$musicalbumlist.record.music_album_id}" src="{$albumImageDetailValue.album_path}" />
                    </td></tr></table>
                    {assign var=array_count value=$array_count+1}
                    {/foreach}
                    {if $musicalbumlist.getAlbumImageDetail.total_record lt 4}
                    {section name=foo start=0 loop=$musicalbumlist.getAlbumImageDetail.noimageCount step=1}
                    <table><tr><td><img title="{$musicalbumlist.record.album_title}" alt="{$musicalbumlist.record.album_title|truncate:3}" width="70" src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_S.jpg" /></td></tr></table>
                    {/section}	
                	{/if}
                    {else}    
                    <div class="clsSingleImage">
					<a href="{$musicalbumlist.viewAlbum_url}" class="Cls144x110 ClsImageContainer">
					<img title="{$musicalbumlist.record.album_title}" alt="{$musicalbumlist.record.album_title|truncate:3}" src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" /> </a></div>
                    {/if}
				</div>
			</div>
            <div class="clsFeaturedAlbumDetails">
                <a href="{$musicalbumlist.viewAlbum_url}" title="{$musicalbumlist.record.album_title}"><pre>{$musicalbumlist.record.album_title}</pre></a>
                <p>{$LANG.myhome_total_tracks}: <span>{$musicalbumlist.record.total_tracks}</span></p>
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
<div class="clsNoRecordsFound">{$LANG.sidebar_no_featured_album_found_error_msg}</div>
{/if}