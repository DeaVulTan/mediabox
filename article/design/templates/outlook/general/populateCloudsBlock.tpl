{if $opt eq 'article'}
	<div class="clsSideBarLeft">
		<div class="clsSideBar">
        	<p class="clsTagsHeading">{$LANG.sidebar_article_tags_heading_label}</p>
        	<span class=""></span>
    	</div>
{$myobj->setTemplateFolder('general/','article')}
	{include file="box.tpl" opt="sidebartags_top"}
    	<div class="clsSideBarRight">
			<div class="clsSideBarContent">
	    		{if $populateCloudsBlock.resultFound}
	        		<p class="clsArticleTags">
	            		{foreach from=$populateCloudsBlock.item item=tag}
	                		<span class="{$tag.class}"><a style="font-size: 13px;" href="{$tag.url}" title="{$tag.name}">{$tag.wordWrap_mb_ManualWithSpace_tag}</a></span>
	                	{/foreach}
	            	</p>
	            	<div class="clsOverflow">
	            		<div class="clsViewMoreLinks">
	             			<p class="clsMoreTags"><a href="{$moreclouds_url}">{$LANG.sidebar_more_label}</a></p>
	            		</div>
	           		</div>
	        	{else}
	        		<div><p class="clsNoRecordsFound">{$LANG.sidebar_no_articletags_found_error_msg}</p></div>
				{/if}
			</div>
		</div>
	</div>
    {$myobj->setTemplateFolder('general/','article')}
	{include file="box.tpl" opt="sidebartags_bottom"}
{/if}
