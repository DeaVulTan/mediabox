{if $total_photo_list_pages}
<div class="clsCarouselContainer">
    <div class="clsIndexViewAll">
    	<ul id="{$showtab}carouselPhotoList" class="jcarousel-skin-tango">
      		<!-- The content will be dynamically loaded here -->
    	</ul>
    	<div class="clsIndexViewAllLinks">
    		{if $showtab eq 'mostrecentphoto'}
				<a href="{$myobj->getUrl('photolist','?pg=photonew','photonew/','','photo')}" title="{$LANG.index_photo_view_all_photos}">{$LANG.index_photo_view_all_photos}</a>
			{elseif $showtab eq 'topratedphoto'}
				<a href="{$myobj->getUrl('photolist','?pg=phototoprated','phototoprated/','','photo')}" title="{$LANG.index_photo_view_all_photos}">{$LANG.index_photo_view_all_photos}</a>
			{/if}
		</div>
	</div>
</div>
<script type="text/javascript">
	var photo_carousel_tab = '{$showtab}carouselPhotoList';
	{literal}
	jQuery('#' + photo_carousel_tab).jcarousel({
		scroll: 1,
		size: {/literal}{$total_photo_list_pages}{literal},
		block: '{/literal}{$showtab}{literal}',
		itemFallbackDimension: 610,
		itemLoadCallback: photocarousel_itemLoadCallback
	});
	{/literal}
</script>
{else}
<div class="clsNoRecordsFound">
	{if $showtab eq 'topratedphoto'}
		{$LANG.index_photo_block_top_rated_error_msg}
	{else}
		{$LANG.index_photo_block_recent_uploads_error_msg}
	{/if}
</div>
{/if}