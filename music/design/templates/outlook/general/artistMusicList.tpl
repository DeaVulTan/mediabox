{if $displaySongList_arr.record_count}
	{$myobj->setTemplateFolder('general/','music')}
	{include file='box.tpl' opt='details_top'}
	{assign var='count' value='1'}
	  <div class="clsSongListDetails">
		{foreach key=songListKey item=songListValue from=$displaySongList_arr.row}
			{counter  assign=count}
			<p {if $lastDiv == $count} {counter start=0} class="clsNoBorder"{/if}title="{$songListValue.record.music_title}"><strong><a  href="{$songListValue.getUrl_viewMusic_url}">{$songListValue.wordWrap_mb_ManualWithSpace_music_title}</a></strong>(<span title="{$songListValue.record.album_title}" ><a href="{$songListValue.get_album_url}">{$songListValue.wordWrap_mb_ManualWithSpace_album_title}</a></span>)</p>
		{/foreach}
	  </div>
	{$myobj->setTemplateFolder('general/','music')}
	{include file='box.tpl' opt='details_bottom'}
{/if}
