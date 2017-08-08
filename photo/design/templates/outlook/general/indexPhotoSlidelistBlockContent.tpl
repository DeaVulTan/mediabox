{if $photo_block_slide_record_count}
	<table class="clsPhotoCarouselList">
		{* Assigned to set num. of records in each row *}
		{assign var=row_count value=4}
		{assign var=break_count value=1}
		<script type="text/javascript">
			original_height = new Array();
			original_width = new Array();
		</script>
		{assign var='array_count' value='1'}
		{foreach key=upload_photoKey item=upload_playlistValue from=$populateCarousalPhotoSlidelistBlock_arr.row}
			{if $break_count == 1}
	   			<tr>
	    	{/if}
					<td {if $break_count == $row_count} class="clsFinalData" {/if}>
						<div class="clsLargeThumbImageBackground" title="{$upload_playlistValue.photo_playlist_name}" {if ($upload_playlistValue.total_photos - $upload_playlistValue.private_photo) > 0}onclick="Redirect2URL('{$upload_playlistValue.view_playlisturl}')" {/if}>
							{if ($upload_playlistValue.total_photos - $upload_playlistValue.private_photo) > 0}
								<a href="{$upload_playlistValue.view_playlisturl}" title="{$upload_playlistValue.photo_playlist_name}">
							{/if}
	            			{*DISPLAY PHOTOS IN PLAYLIST STARTS HERE*}
	          				{$myobj->displayPhotoList($upload_playlistValue.photo_playlist_id, true, 4)}
	          				{$myobj->setTemplateFolder('general/', 'photo')}
	        				{include file=photosInSlideListForIndex.tpl}
	    					{*DISPLAY PHOTOS IN PLAYLIST ENDS HERE*}
							{if ($upload_playlistValue.total_photos - $upload_playlistValue.private_photo) > 0}
								</a>
							{/if}
						</div>
						<div class="clsPhotoChannelCurrentPhoto">
							<p>{if ($upload_playlistValue.total_photos - $upload_playlistValue.private_photo) > 0}
                            <a href="{$upload_playlistValue.view_playlisturl}" title="{$upload_playlistValue.photo_playlist_name}"><pre>{$upload_playlistValue.photo_playlist_name}</pre></a>{else}<a href="javascript:;" title="{$upload_playlistValue.photo_playlist_name}"><pre>{$upload_playlistValue.photo_playlist_name}</pre></a>{/if}
                            </p>
                        	<p class="clsSlidelistTotal">{$LANG.index_popular_slidelist_total_photos}&nbsp;<span>{$upload_playlistValue.total_photos}</span></p>
						</div>
					</td>
			{assign var=break_count value=$break_count+1}
			{if $break_count > $row_count}
				</tr>
				{assign var=break_count value=1}
			{/if}
		{/foreach}
		{if $break_count != 1}
    		{* Added to display empty row if last row records < row_count *}
    		<td colspan="{math equation=($row_count+1)-$break_count}">&nbsp;</td>
    		</tr>
    	{/if}
	</table>
{else}
	<div class="clsNoRecordsFoundNoPadding">{$LANG.sidebar_no_record_found_error_msg}</div>
{/if}