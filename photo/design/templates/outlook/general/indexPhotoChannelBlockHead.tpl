{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="indexphotomain_top"}
<script language="javascript" type="text/javascript">
var module_name_js="photo";
</script>
{assign var=category_limit_per_page value=2}
{assign var=photo_limit_per_category value=4}
{assign var=total_category value=$myobj->getTotalCategoryListPages('mostrecentphoto', $category_limit_per_page)}
<div class="clsPhotoCategoryContainer">
<div class="clsIndexPhotoChannelContainer">
    <div class="clsIndexPhotoCategoryHeading clsIndexCategoryHeading">
        <h3><span>{$LANG.sidebar_photo_channel_label}</span></h3>
    </div>
</div>
{if $total_category}
	<div class="clsIndexPhotoCategory">
	    <div class="clsCarouselContainer">
	    	<div class="clsIndexViewAll">
	    		<ul id="carouselChannelList" class="jcarousel-skin-tango">
	      			<!-- The content will be dynamically loaded here -->
	    		</ul>
	    		<div class="clsIndexViewAllLinks">
	    			<a href="{$myobj->getUrl('photocategory', '', '', '', 'photo')}" title="{$LANG.index_photo_view_all_categories}">{$LANG.index_photo_view_all_categories}</a>
	    		</div>
	    	</div>
		</div>
	</div>
{else}
	<div class="clsNoRecordsFound">{$LANG.index_photo_categories_block_error_msg}</div>
{/if}
</div>
<script type="text/javascript">
	var photo_index_ajax_url = '{$CFG.site.photo_url}index.php';
	{literal}

	function photochannelcarousel_itemLoadCallback(carousel, state)
	{
		var block = carousel.blockName();
		var i = carousel.first;
		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(i)) {
            return;
        }

		jQuery.get(
			photo_index_ajax_url,
			{
				start: i,
				limit: {/literal}{$category_limit_per_page}{literal},
				photo_limit: {/literal}{$photo_limit_per_category}{literal},
				photoChannel: block
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(i, data);
			}
		);
	};
	jQuery('#carouselChannelList').jcarousel({
			scroll: 1,
			size: {/literal}{$total_category}{literal},
			block: 'mostrecentphoto',
			itemFallbackDimension: 610,
			itemLoadCallback: photochannelcarousel_itemLoadCallback
		});

{/literal}
</script>

{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="indexphotomain_bottom"}