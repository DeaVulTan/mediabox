{$myobj->setTemplateFolder('general/','blog')}
{include file="box.tpl" opt="display_top"}
<div id="selGroupCreate">
   <div class="clsOverflow clsPageHeading"><h2>{$LANG.tags_page_title}</h2></div>
	<p class="clsTags clsOverflow">{if $myobj->tag_arr.resultFound}
		{foreach from=$myobj->tag_arr.item item=tag}
			<span class="{$tag.class}"><a href="{$tag.url}" {$tag.fontSizeClass}>{$tag.name}</a></span>
		{/foreach}
     {else}
     	<div id="selMsgAlert">
		{$LANG.tags_no_tags_found}
        </div>
	{/if}</p>
    </div>
{$myobj->setTemplateFolder('general/','blog')}
{include file='box.tpl' opt='display_bottom'}
