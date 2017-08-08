{$myobj->setTemplateFolder('general/','article')}
{include file="box.tpl" opt="display_top"}
<div id="selArticlePlayListContainer">
   <div class="clsOverflow">
    	<div class="clsArticleListHeading">
   			<h2>{$LANG.page_article_tags_title}</h2>
		</div>
	</div>
	<div class="clsTags clsOverflow">
		{if $myobj->tag_arr.resultFound}
			{foreach from=$myobj->tag_arr.item item=tag}
				<div class="clsFloatLeft clsMarginRight10"><div class="{$tag.class}"><a href="{$tag.url}" {$tag.fontSizeClass}>{$tag.name}</a></div></div>
			{/foreach}
     	{else}
     		<div id="selMsgAlert">
				{$LANG.no_tags_found}
        	</div>
		{/if}
	</div>
</div>
{$myobj->setTemplateFolder('general/','article')}
{include file='box.tpl' opt='display_bottom'}