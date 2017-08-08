{foreach from=$getTagsLink_arr item=tagsValue}
	<a href="{$tagsValue.tag_url}" title="{$tagsValue.title_tag_name}">{$tagsValue.wordWrap_mb_ManualWithSpace_tag_name}</a>
{/foreach}