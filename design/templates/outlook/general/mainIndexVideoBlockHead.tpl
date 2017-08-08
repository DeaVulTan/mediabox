{include file='box.tpl' opt='videoinner_top'}
<script language="javascript" type="text/javascript">
var module_name_js="video";
</script>
<div class="clsCarouselBlockContent">
    <ul id="carouselVideoList" class="jcarousel-skin-tango">
      	<!-- The content will be dynamically loaded here -->
    </ul>
	<script type="text/javascript">
        var video_index_ajax_url = '{$CFG.site.url}index.php';
        {literal}
    
        function mainvideocarousel_itemLoadCallback(carousel, state)
        {
            var block = carousel.blockName();
            var i = carousel.first;
    
            // need not call ajax again if the carousel page is already fetched
            if (carousel.has(i)) {
                return;
            }
    
            jQuery.get(
                video_index_ajax_url,
                {
                    start: i,
                    limit: 4,
                    mainvideoblock: block
                },
                function(data) {
                    //add the returned response from the ajax call as the item
                    carousel.add(i, data);
                }
            );
        };
        jQuery('#carouselVideoList').jcarousel({
                scroll: 1,
                size: {/literal}{$total_video_carousel_pages}{literal},
                block: '{/literal}{$mainIndexObj->default_video_block}{literal}',
                itemFallbackDimension: 610,
                itemLoadCallback: mainvideocarousel_itemLoadCallback
            });
    
    </script>
    {/literal}
 </div> 
<div class="clsMainIndexViewAllLinks">
	<a href="{$myobj->getUrl('videolist','?pg=videonew','videonew/','','video')}" title="{$LANG.mainIndex_video_view_all}">{$LANG.mainIndex_video_view_all}</a>
</div>            
{include file='box.tpl' opt='videoinner_bottom'}