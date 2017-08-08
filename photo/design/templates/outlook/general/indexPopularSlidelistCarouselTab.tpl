{if $total_popular_slidelist_pages}
<div class="clsCarouselContainer">
	<div class="clsIndexViewAll">
    	<ul id="{$slidelist_tab}carouselPhotoList" class="jcarousel-skin-tango">
      		<!-- The content will be dynamically loaded here -->
    	</ul>
    	<div class="clsIndexViewAllLinks">
    		<a href="{$myobj->getUrl('photoslidelist', '?pg=slidelistnew', 'slidelistnew/', '', 'photo')}" title="{$LANG.index_photo_view_all_slidelist}">{$LANG.index_photo_view_all_slidelist}</a>
    	</div>
    </div>
</div>
<script type="text/javascript">
	var slidelist_carousel_tab = '{$slidelist_tab}carouselPhotoList';
	{literal}
	jQuery('#' + slidelist_carousel_tab).jcarousel({
		scroll: 1,
		size: {/literal}{$total_popular_slidelist_pages}{literal},
		slidelist_block: '{/literal}{$slidelist_tab}{literal}',
		itemFallbackDimension: 610,
		itemLoadCallback: popularSlidelistcarousel_itemLoadCallback
	});
	{/literal}
</script>
{else}
<div class="clsNoRecordsFound">{$LANG.index_popular_slidelist_block_error_msg}</div>
{/if}