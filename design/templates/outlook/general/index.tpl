<!--Latest feature and whats going on section starts-->
<div class="clsLatestFeatureActivitiesSection clsOverflow">

	{if $myobj->isShowPageBlock('block_feartured_content_glider')}
		<!--Latest feature section starts-->
	    <div class="clsLatestFeatureContainer">
	    	{$myobj->getFeaturedContent()}
	    </div>
	    <!--Latest feature section ends-->
    {/if}

    <!--Whats going on section starts-->
    <div class="clsWhatsGoingOnContainer">
        {include file='whatsGoingOn.tpl'}
    </div>
    <!--Whats going on section ends-->

</div>
<!--Latest feature and whats going on section ends-->
{$header->populateModuleStatistics()}
<!--Video block section starts-->
        { include file='mainIndexVideoBlock.tpl' }
<!--Video block section ends-->

<!--music block section starts-->
        {include file='mainIndexMusicBlock.tpl'}
<!--music block section ends-->

<!--Photo block section starts-->
        {include file='mainIndexPhotoBlock.tpl'}
<!--Photo block section ends-->

<div class="clsOverflow">
	<div class="clsIndexBottomLeft">
	
		<!--Forums, blogs, article block section starts-->
        {include file='mainIndexOtherBlocks.tpl'}
		<!--Forums, blogs, article block section ends-->

    </div>
    
    <div class="clsIndexBottomRight">
	
		<!--Tags Clouds section starts-->
        {include file='mainIndexTagsBlocks.tpl'}
		<!--Tags Clouds section ends-->
		
		{* BANNER SECTION STARTS *}
		   <div class="cls336pxBanner">
			   <div>{php}getAdvertisement('sidebanner1_336x280'){/php}</div>
		   </div>
		{* BANNER SECTION ENDS *}
  
    </div>    
</div>

