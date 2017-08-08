{if chkAllowedModule(array('music'))}
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='musicblock_top'}
<div class="clsMainIndexmusicBlock">
   	<!--heading and right heading content starts-->
   	<div class="clsOverflow">
       	<h2 class="clsBlockHeading">{$LANG.mainIndex_music}</h2>
        <div class="clsBlockHeadingDetails">
            {foreach from=$modulestatistics.music item=detail key=caption name=music_stats}
            {$detail.lang}: <span>{$detail.value}</span>
            {if !$smarty.foreach.music_stats.last}<span class="clsSeperator">&nbsp;</span>{/if}
            {/foreach}
        </div>
    </div>
    <!--heading and right heading content ends-->
    
        {if $total_music_carousel_pages}
            <div class="clsOverflow">
                <!-- Player section starts -->
                <div class="clsPlayerBlock" id="clsIndexMusicBlockPlayer">
                        {$myobj->setTemplateFolder('general/')}
                        {include file="mainIndexMusicPlayer.tpl"}
                </div>
                <!-- Player section ends -->
                
                <div class="clsCarouselBlock">
                    <h3>{$mainIndexObj->LANG.mainIndex_music_heading}</h3>
                    {include file='box.tpl' opt='musicinner_top'}
                    <div class="clsCarouselBlockContent">
                        <ul id="carouselMusicList" class="jcarousel-skin-tango">
                            <!-- The content will be dynamically loaded here -->
                        </ul>
                        <script type="text/javascript">
                            var music_index_ajax_url = '{$CFG.site.url}index.php';
                            {literal}			
                            function mainmusiccarousel_itemLoadCallback(carousel, state)
                            {
                                var block = carousel.blockName();
                                var i = carousel.first;
                        
                                // need not call ajax again if the carousel page is already fetched
                                if (carousel.has(i)) {
                                    return;
                                }
                        
                                jQuery.get(
                                    music_index_ajax_url,
                                    {
                                        start: i,
                                        limit: 4,
                                        mainmusicblock: block
                                    },
                                    function(data) {
                                        //add the returned response from the ajax call as the item
                                        carousel.add(i, data);
                                    }
                                );
                            };
                            jQuery('#carouselMusicList').jcarousel({
                                    scroll: 1,
                                    size: {/literal}{$total_music_carousel_pages}{literal},
                                    block: '{/literal}{$mainIndexObj->default_music_block}{literal}',
                                    itemFallbackDimension: 610,
                                    itemLoadCallback: mainmusiccarousel_itemLoadCallback
                                });
                            {/literal}
                        </script>
                    </div>
                    <div class="clsMainIndexViewAllLinks">
						<a href="{$myobj->getUrl('musiclist','?pg=musicnew','musicnew/','','music')}" title="{$LANG.mainIndex_music_view_all}">&nbsp; {$LANG.mainIndex_music_view_all}</a>
					</div>            
                    {include file='box.tpl' opt='musicinner_bottom'}                
                </div>
            </div>
        {else}
            <div class="clsNoRecordsFound">{$LANG.mainIndex_music_no_record}</div>
        {/if}
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='musicblock_bottom'}
{/if}