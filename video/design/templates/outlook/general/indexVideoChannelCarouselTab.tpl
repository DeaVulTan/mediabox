{if $videoIndexObj->total_channel_list_page}
<!-- ** -->
<div class="clsCarouselContainer">
    <ul id="{$show_catgeroy}carouselMusicList1" class="jcarousel-skin-tango">
      	<!-- The content will be dynamically loaded here -->
    </ul>
    	<div class="clsViewMoreChannels"><a href="{$videoIndexObj->getUrl('videocategory','','','','video')}">{$LANG.index_page_channel_block_viewall_link}</a></div>
</div>
<script type="text/javascript">
	var music_carousel_tab1 = '{$show_catgeroy}carouselMusicList1';
	{literal}
	jQuery('#' + music_carousel_tab1).jcarousel({
		scroll: 1,
		size: {/literal}{$videoIndexObj->total_channel_list_page}{literal},
		block_video: '{/literal}{$show_catgeroy}{literal}',
		itemFallbackDimension: 610,
		itemLoadCallback: videoChannelCarousel_ItemLoadCallback
	});
	{/literal}
</script>
{else}
<div id="video_category_no_records">
	<div id="selMsgAlert">
            <p>
				{$LANG.sidebar_no_category_found_error_msg}
			</p>
	</div>			
</div>
{/if}


