{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="indexphotomain_top"}
<script language="javascript" type="text/javascript">
var module_name_js="photo";
</script>
{assign var=slidelist_limit_per_page value=4}
<div class="clsIndexPopularSlideList">
	<div class="clsJQCarousel" id="popularSlidelistTabs">
		<h3 class="clsJQCarouselHead">{$LANG.index_popular_slidelist}</h3>
        <ul class="clsJQCarouselTabs clsOverflow">
            <li><a href="index.php?slidelist_tab=slidelistmostviewed&slidelist_limit={$slidelist_limit_per_page}"><span style="display:none;">{$LANG.index_popular_slidelist}</span></a></li>
        </ul>
    </div>
</div>
<script type="text/javascript">
	{literal}
	function popularSlidelistcarousel_itemLoadCallback(carousel, state)
	{
		var slidelist_block = carousel.options.slidelist_block;
		var slidelist_item = carousel.first;

		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(slidelist_item)) {
            return;
        }

		jQuery.get(
			photo_index_ajax_url,
			{
				slidelist_start: slidelist_item,
				slidelist_limit: {/literal}{$slidelist_limit_per_page}{literal},
				slidelist_block: slidelist_block
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(slidelist_item, data);
			}
		);
	};

	$Jq(window).load(function(){
		attachJqueryTabs('popularSlidelistTabs');
	});

	{/literal}
</script>
{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="indexphotomain_bottom"}