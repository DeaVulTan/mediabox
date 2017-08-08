<script type="text/javascript">
	removeLoadingBg('indexFeaturedAlbumContainer');
</script>
{if $total_featured_albums_pages}
<div class="clsCarouselContainer">
    <ul id="{$albums_tab}carouselMusicList" class="jcarousel-skin-tango">    	
      	<!-- The content will be dynamically loaded here -->
    </ul>
	<div class="clsIndexViewAllLinks">
			<a title="{$LANG.myhome_music_view_all_albums}" href="{$myobj->view_all_albums_url}">{$LANG.myhome_music_view_all_albums}</a>
	</div>

</div>

<script type="text/javascript">
	var albums_carousel_tab = '{$albums_tab}carouselMusicList';
	{literal}
	jQuery('#' + albums_carousel_tab).jcarousel({
		scroll: 1,
		size: {/literal}{$total_featured_albums_pages}{literal},
		albums_block: '{/literal}{$albums_tab}{literal}',
		itemFallbackDimension: 610,
		itemLoadCallback: featuredAlbumscarousel_itemLoadCallback
	});
	{/literal}
</script>
{else}
<div class="clsNoRecordsFound">{$LANG.sidebar_no_featured_album_found_error_msg}</div>
{/if}