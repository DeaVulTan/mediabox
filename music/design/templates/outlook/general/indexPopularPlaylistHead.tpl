{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audiocontent_top"}
{* CHANGE THE VALUE OF THIS TO MODIFY THE NO OF RECORDS TO BE SHOWN PER PAGE IN THE POPULAR PLAYLIST CAROUSEL *}
{assign var=playlist_limit_per_page value=4}
<div class="clsIndexFearuredAlbum" id="indexPopularPlaylistContainer">
	<div class="clsJQCarousel" id="popularPlaylistTabs">
		<h3 class="clsJQCarouselHead">{$LANG.myhome_popular_playlist}</h3>
        <ul class="clsJQCarouselTabs clsOverflow">
            <li><a href="index.php?playlist_tab=playlistmostviewed&limit={$playlist_limit_per_page}"><span style="display:none;">{$LANG.myhome_popular_playlist}</span></a></li>
        </ul>
    </div>
</div>
<script type="text/javascript">
	addLoadingBg('indexPopularPlaylistContainer');
	{literal}
	function popularPlaylistcarousel_itemLoadCallback(carousel, state)
	{
		var playlist_block = carousel.options.playlist_block;
		var playlist_item = carousel.first;
		
		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(playlist_item)) {
            return;
        }

		jQuery.get(
			music_index_ajax_url,
			{
				start: playlist_item,
				limit: {/literal}{$playlist_limit_per_page}{literal},
				playlist_block: playlist_block
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(playlist_item, data);
			}
		);
	};
	
	$Jq(window).load(function(){
		attachJqueryTabs('popularPlaylistTabs');
	});
	
	{/literal}
</script>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audiocontent_bottom"}