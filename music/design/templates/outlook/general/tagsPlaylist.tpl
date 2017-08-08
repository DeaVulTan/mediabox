<div id="selGroupCreate">
{$myobj->setTemplateFolder('general/','music')}
{include file='box.tpl' opt='audioindex_top'}
	<div class="clsAudioIndex clsTagsDetails"><h3>{$LANG.page_playlist_title}</h3></div>
	<p class="clsTags">{if $myobj->tag_arr.resultFound}
		{foreach from=$myobj->tag_arr.item item=tag}
			<span class="{$tag.class}"><a href="{$tag.url}" {$tag.fontSizeClass}>{$tag.name}</a></span>
		{/foreach}
     {else}
     	<div id="selMsgAlert">
		{$LANG.no_tags_found}
        </div>
	{/if}</p>
{$myobj->setTemplateFolder('general/','music')}
{include file='box.tpl' opt='audioindex_bottom'}
</div>