{if $opt == 'albums'}
{if $populateCarousalTopChartBlock_arr.record_count}
<table class="clsCarouselTopChartList">
	{* Assigned to set num. of records in each row *}
	{assign var=row_count value=2}
	{assign var=break_count value=1}
	{foreach key=musicKey item=musicValue from=$populateCarousalTopChartBlock_arr.row}
	{if $break_count == 1}
    <tr>
    {/if}
    	<td>

                        <div class="clsOverflow">
                            <div class="clsTopChartImage">
                                <a href="{$musicValue.viewalbum_url}" class="ClsImageContainer ClsImageBorder1 Cls106x82">
									{if $musicValue.music_image_src  != ''}
										<img src="{$musicValue.music_image_src}" title="{$musicValue.record.album_title}" {$myobj->DISP_IMAGE(#music_index_topchart_thumb_width#, #music_index_topchart_thumb_height#, $musicValue.thumb_width, $musicValue.thumb_height)} alt="{$musicValue.record.album_title|truncate:5}"/>
									{else}
										<img   src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_M.jpg" title="{$musicValue.record.album_title}" alt="{$musicValue.record.album_title}"/>
									{/if}
                                </a>
                            </div>
							<div class="clsTopChartDetails">
								<div class="clsTopChartTracks">
									<a class="clsTopChartSong" href="{$musicValue.musiclistalbum_url}" title="{$musicValue.record.album_title}"><pre>{$musicValue.record.album_title}</pre></a>
                                    <p class="clsTopchartalbum"><span>{$LANG.sidebar_topchart_ablum_total_label}:</span>{$musicValue.record.total_song}</p>
                                    <p class="clsTopchartalbum"><span>{$LANG.sidebar_topchart_total_plays_label}:</span>{$musicValue.record.total_count}</p>
								</div>
							</div>
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
<div class="clsNoRecordsFound">{$LANG.sidebar_no_topchart_album_found_error_msg}</div>
{/if}
{else if $opt == 'normal'}
{if $populateCarousalTopChartBlock_arr.record_count}
<table class="clsCarouselTopChartList">
	{* Assigned to set num. of records in each row *}
	{assign var=row_count value=2}
	{assign var=break_count value=1}
	{foreach key=musicKey item=musicValue from=$populateCarousalTopChartBlock_arr.row} 
    {if $break_count == 1}
    <tr>
    {/if}
    	<td>

                        <div class="clsOverflow">
                            <div class="clsTopChartImage">
                                <a href="{$musicValue.title_url}" class="ClsImageContainer ClsImageBorder1 Cls106x82">
									{if $musicValue.music_image_src  != ''}
										<img src="{$musicValue.music_image_src}" alt="{$musicValue.record.music_title|truncate:5}" title="{$musicValue.record.music_title}" {$myobj->DISP_IMAGE(#music_index_topchart_thumb_width#, #music_index_topchart_thumb_height#, $musicValue.thumb_width, $musicValue.thumb_height)}/>
									{else}
										<img   src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_M.jpg" title="{$musicValue.record.music_title}" alt="{$musicValue.record.music_title}"/>
									{/if}
                                </a>
                            </div>
							<div class="clsTopChartDetails">
								<div class="clsTopChartTracks">
									<a class="clsTopChartSong" href="{$musicValue.title_url}" title="{$musicValue.record.music_title}"><pre>{$musicValue.record.music_title}</pre></a>
									<p class="clsTopchartalbum"><span>{$LANG.album_title}:</span><a  href="{$musicValue.viewalbum_url}" title="{$musicValue.record.album_title}">{$musicValue.record.album_title}</a></p>
									<p class="clsTopchartGenres"><span>{$LANG.music_genre_in}</span><a  href="{$musicValue.musiccategory_url}" title="{$musicValue.record.music_category_name}">{$musicValue.record.music_category_name}</a></p>
								</div>
								<div class="clsOverflow">
									<div class="clsTopchartPlays">
											  <a class="clsPlaySong" id="{$script_case}_play_music_icon_{$musicValue.record.music_id}" onClick="playSelectedSong({$musicValue.record.music_id}, '{$script_case}')" href="javascript:void(0)"></a>
											  <a class="clsStopSong" id="{$script_case}_play_playing_music_icon_{$musicValue.record.music_id}" onClick="stopSong({$musicValue.record.music_id}, '{$script_case}')" style="display:none" href="javascript:void(0)"></a>
									</div>
									<div class="clsTopchartPlayCount">	
										<p>
											<span>{$LANG.sidebar_posted_plays_label}</span>
											{$musicValue.record.total_count}
										</p>
									</div>
								</div>
							</div>
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
{if $top_chart_tab == 'topChartDownloads'}
<div class="clsNoRecordsFound">{$LANG.sidebar_no_topchart_downloads_found_error_msg}</div>
{else}
<div class="clsNoRecordsFound">{$LANG.sidebar_no_topchart_audio_found_error_msg}</div>
{/if}
{/if}
{/if}