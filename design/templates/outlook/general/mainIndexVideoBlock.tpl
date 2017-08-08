{if chkAllowedModule(array('video'))}
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='videoblock_top'}
	<div class="clsMainIndexVideoBlock">
    	<!--heading and right heading content starts-->
    	<div class="clsOverflow">
        	<h2 class="clsBlockHeading">{$LANG.mainIndex_video}</h2>
            <div class="clsBlockHeadingDetails">
            {foreach from=$modulestatistics.video item=detail key=caption name=video_stats}
            {$detail.lang}: <span>{$detail.value}</span>
            {if !$smarty.foreach.video_stats.last}<span class="clsSeperator">&nbsp;</span>{/if}
            {/foreach}
            </div>
        </div>
    	<!--heading and right heading content ends-->
        
	{if $total_video_carousel_pages}
        <div class="clsOverflow">
        	<!-- Player section starts -->
            <div id="mainIndexVideoPlayer" class="clsPlayerBlock">
            	{include file="mainIndexVideoPlayer.tpl"}
            </div>
        	<!-- Player section ends -->
            <div class="clsCarouselBlock">
            	<h3>{$mainIndexObj->LANG.mainIndex_video_heading}</h3>
            	 <div class="clsIndexMainContainer">{include file="mainIndexVideoBlockHead.tpl"}</div>
            </div>
        </div>
    {else}
    <div class="clsNoRecordsFound">{$LANG.mainIndex_video_no_record}</div>
    {/if}
    </div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='videoblock_bottom'}
{/if}