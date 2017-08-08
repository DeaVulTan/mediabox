{if $displaySongList_arr.record_count}
	{assign var='count' value='1'}
	<div class="clsAlbumShotListDetails">
		<table width="100%">
			<tr>
				{foreach key=sortListKey item=sortListValue from=$displaySongList_arr.row}
				{if $sortListValue.open_tr!=''}{$sortListValue.open_tr} {/if}
			        {$sortListValue.album_title_wrap}{$sortListValue.song_count}{$sortListValue.album_title_end}
				{if $sortListValue.close_tr!=''}{$sortListValue.close_tr}{/if}
				{/foreach}
			</tr>
		</table>
	</div>
{/if}
