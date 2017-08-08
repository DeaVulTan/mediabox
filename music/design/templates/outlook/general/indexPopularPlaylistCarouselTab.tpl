<script type="text/javascript">
	removeLoadingBg('indexPopularPlaylistContainer');
</script>
{if $total_popular_playlist_pages}
<div class="clsCarouselContainer">
    <ul id="{$playlist_tab}carouselMusicList" class="jcarousel-skin-tango">    	
      	<!-- The content will be dynamically loaded here -->
    </ul>
	<div class="clsIndexViewAllLinks">
			<a title="{$LANG.myhome_music_view_all_playlist}" href="{$myobj->view_all_playlist_url}">{$LANG.myhome_music_view_all_playlist}</a>
	</div>
</div>
<script type="text/javascript">
	var playlist_carousel_tab = '{$playlist_tab}carouselMusicList';
	{literal}
	jQuery('#' + playlist_carousel_tab).jcarousel({
		scroll: 1,
		size: {/literal}{$total_popular_playlist_pages}{literal},
		playlist_block: '{/literal}{$playlist_tab}{literal}',
		itemFallbackDimension: 610,
		itemLoadCallback: popularPlaylistcarousel_itemLoadCallback
	});
	{/literal}
</script>
{else}
<div class="clsNoRecordsFound">{$LANG.sidebar_no_playlist_found_error_msg}</div>
{/if}