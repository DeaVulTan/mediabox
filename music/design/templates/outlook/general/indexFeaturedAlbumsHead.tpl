{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audiocontent_top"}
{* CHANGE THE VALUE OF THIS TO MODIFY THE NO OF RECORDS TO BE SHOWN PER PAGE IN THE FEATURED ALBUMS CAROUSEL *}
{assign var=albums_limit_per_page value=4}
<div class="clsIndexFearuredAlbum" id="indexFeaturedAlbumContainer">
	<div class="clsJQCarousel" id="featuredAlbumsTabs">
		<h3 class="clsJQCarouselHead">{$LANG.myhome_featured_albums}</h3>
        <ul class="clsJQCarouselTabs clsOverflow">
            <li><a href="index.php?albums_tab=featured&limit={$albums_limit_per_page}"><span style="display:none;">{$LANG.myhome_featured_albums}</span></a></li>
        </ul>
    </div>
</div>
<script type="text/javascript">
	addLoadingBg('indexFeaturedAlbumContainer');
	{literal}
	function featuredAlbumscarousel_itemLoadCallback(carousel, state)
	{
		var albums_block = carousel.options.albums_block;
		var albums_item = carousel.first;
		
		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(albums_item)) {
            return;
        }

		jQuery.get(
			music_index_ajax_url,
			{
				start: albums_item,
				limit: {/literal}{$albums_limit_per_page}{literal},
				albums_block: albums_block
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(albums_item, data);
			}
		);
	};
	
	$Jq(window).load(function(){
		attachJqueryTabs('featuredAlbumsTabs');
	});
	
	{/literal}
</script>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audiocontent_bottom"}