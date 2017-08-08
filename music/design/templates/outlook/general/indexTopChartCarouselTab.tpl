<script type="text/javascript">
	removeLoadingBg('indexTopChartContainer');
</script>
{if $total_top_chart_pages}
<div class="ClsTopChartListCarouselContainer">
    <ul id="{$top_chart_tab}carouselTopChartList" class="jcarousel-skin-tango">    	
      	<!-- The content will be dynamically loaded here -->
    </ul>
    {if $top_chart_tab == 'topChartAlbums'}
    <div class="clsIndexViewAllLinks">
			<a title="{$LANG.myhome_music_view_all_albums}" href="{$myobj->view_all_albums_url}">{$LANG.myhome_music_view_all_albums}</a>
	</div>
    {else}
	<div class="clsIndexViewAllLinks">
			<a title="{$LANG.myhome_music_view_all_music}" href="{$myobj->view_all_music_url}">{$LANG.myhome_music_view_all_music}</a>
	</div>
    {/if}
</div>
<script type="text/javascript">
	var top_chart_carousel_tab = '{$top_chart_tab}carouselTopChartList';
	{literal}
	jQuery('#' + top_chart_carousel_tab).jcarousel({
		scroll: 1,
		size: {/literal}{$total_top_chart_pages}{literal},
		topChart: '{/literal}{$top_chart_tab}{literal}',
		itemFallbackDimension: 60,
		itemLoadCallback: topChartCarousel_itemLoadCallback
	});
	{/literal}
</script>
{else}
{if $top_chart_tab == 'topChartAlbums'}
<div class="clsNoRecordsFound">{$LANG.sidebar_no_topchart_album_found_error_msg}</div>
{elseif $top_chart_tab == 'topChartDownloads'}
<div class="clsNoRecordsFound">{$LANG.sidebar_no_topchart_downloads_found_error_msg}</div>
{else}
<div class="clsNoRecordsFound">{$LANG.sidebar_no_topchart_audio_found_error_msg}</div>
{/if}
{/if}