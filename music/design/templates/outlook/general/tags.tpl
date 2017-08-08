<div id="selGroupCreate">
{$myobj->setTemplateFolder('general/','music')}
{include file='box.tpl' opt='audioindex_top'}
	<div class="clsAudioIndex clsTagsDetails"><h3>{$LANG.page_playlist_title}</h3></div>
	<div class="clsTags clsOverflow">{if $myobj->tag_arr.resultFound}
		{foreach from=$myobj->tag_arr.item item=tag}
			<div class="{$tag.class} clsFloatLeft"><a href="{$tag.url}" {$tag.fontSizeClass}>{$tag.name}</a></div>
		{/foreach}
     {else}
     	<div id="selMsgAlert">
		{$LANG.no_tags_found}
        </div>
	{/if}</div>
{$myobj->setTemplateFolder('general/','music')}
{include file='box.tpl' opt='audioindex_bottom'}
</div>