{if $videoIndexObj->total_video_list_pages}
<div class="clsCarouselContainer">
    <ul id="{$showtab}carouselMusicList" class="jcarousel-skin-tango">
      	<!-- The content will be dynamically loaded here -->
    </ul>
	<div class="clsViewMoreChannels"><a href="{$videoIndexObj->getUrl('videolist', '?pg=videonew', 'videonew/','','video')}">{$LANG.index_page_video_block_viewall_link}</a></div>
</div>
<script type="text/javascript">
	var music_carousel_tab = '{$showtab}carouselMusicList';
	{literal}
	jQuery('#' + music_carousel_tab).jcarousel({
		scroll: 1,
		size:  '{/literal}{$total_video_list_pages}{literal}',
		block: '{/literal}{$showtab}{literal}',
		itemFallbackDimension: 610,
		itemLoadCallback: videocarousel_itemLoadCallback
	});
	{/literal}
</script>
{else}
<div id="video_no_records">
	<div id="selMsgAlert"><p>{if $showtab=='newvideo'}{$LANG.index_page_video_block_recent_video_err_msg}{else}{$LANG.index_page_video_block_top_rate_video_err_msg}{/if}</p></div>
</div>
{/if}
