{if chkAllowedModule(array('photo'))}
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='photoblock_top'}
<div class="clsMainIndexphotoBlock">
   	<!--heading and right heading content starts-->
   	<div class="clsOverflow">
       	<h2 class="clsBlockHeading">{$LANG.mainIndex_photo}</h2>
        <div class="clsBlockHeadingDetails">
        {foreach from=$modulestatistics.photo item=detail key=caption name="photo_stats"}
        {$detail.lang}: <span>{$detail.value}</span>
        {if !$smarty.foreach.photo_stats.last}<span class="clsSeperator">&nbsp;</span>{/if}
        {/foreach}
        </div>
    </div>
    <!--heading and right heading content ends-->
                {if $total_photo_carousel_pages}
    <div class="clsOverflow">
        <!-- Player section starts -->
        <div class="clsPlayerBlock">
            {if chkAllowedModule(array('photo')) and $myobjFeaturedPhoto->isFeaturedphoto}
			<script src="{$CFG.site.photo_url}js/jquery.cycle.js" type="text/javascript"></script>
            <div class="slideshow">
                {assign var='increment' value=0}
                {foreach key=genresKey item=photoValue from=$featured_photo_list_arr}
				  <div class="clsIndexBlockPlayer">
				  <h3>{$photoValue.photo_title}</h3>
                    <div class="clsIndexPhotoContainer">
                        <img src="{$photoValue.medium_img_src}" alt="{$photoValue.photo_title}" {$myobjFeaturedPhoto->DISP_IMAGE(298, 244, $photoValue.thumb_width, $photoValue.thumb_height)}/>
                    </div>
                </div>
                {/foreach}
             </div>
            {literal}
            <script type="text/javascript">
            $Jq(document).ready(function() {
                $Jq('.slideshow').cycle({
                    fx: 'all' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
                });
            });
            </script>
            {/literal}
            {else}
                <div class="clsNoRecordsFound">{$LANG.mainIndex_photo_no_record}</div>
            {/if}
        </div>
        <!-- Player section ends -->
        <div class="clsCarouselBlock">
            <h3>{$LANG.mainIndex_photo_heading}</h3>
            {include file='box.tpl' opt='photoinner_top'}
            <div class="clsCarouselBlockContent">
    			<ul id="carouselPhotoList" class="jcarousel-skin-tango">
				  	<!-- The content will be dynamically loaded here -->
				</ul>
                <script type="text/javascript">
					var photo_index_ajax_url = '{$CFG.site.url}index.php';
					{literal}
					function mainphotocarousel_itemLoadCallback(carousel, state)
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
								limit: 4,
								mainphotoblock: block
							},
							function(data) {
								//add the returned response from the ajax call as the item
								carousel.add(i, data);
							}
						);
					};
					jQuery('#carouselPhotoList').jcarousel({
							scroll: 1,
							size: {/literal}{$total_photo_carousel_pages}{literal},
							block: '{/literal}{$mainIndexObj->default_photo_block}{literal}',
							itemFallbackDimension: 610,
							itemLoadCallback: mainphotocarousel_itemLoadCallback
						});
					{/literal}
				</script>
            </div>			
			 <div class="clsMainIndexViewAllLinks">
			 	<a href="{$myobj->getUrl('photolist','?pg=photonew','photonew/','','photo')}" title="{$LANG.mainIndex_photo_view_all}">{$LANG.mainIndex_photo_view_all}</a>
			</div>    
        	{include file='box.tpl' opt='photoinner_bottom'}
        </div>        
    </div>
                {else}
                <div class="clsNoRecordsFound">{$LANG.mainIndex_photo_no_record}</div>
                {/if}
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='photoblock_bottom'}
{/if}