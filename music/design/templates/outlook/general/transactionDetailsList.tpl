{if $myobj->isShowPageBlock('songlist_block')}
	{if $displayDetails_arr.record_count}
	<div class="clsDataTable clsTransactionPopup">
	<table>
		<tr>
			<td> <div class="clsTransactionHead">{$LANG.transactionlist_album_music_title}</div></td>
			<td>{$displayDetails_arr.title}</td>
		</tr>
		<tr>
			<td> <div class="clsTransactionHead">{$LANG.transactionlist_current_price}</div></td>
			<td>{$CFG.currency}{$displayDetails_arr.price}</td>
		</tr>
		<tr>
			<td> <div class="clsTransactionHead">{$LANG.transactionlist_total_sale_price}</div></td>
			<td>
			{if $displayDetails_arr.music}
				{$CFG.currency}{$myobj->totalMusicSaleAmount($displayDetails_arr.music_id)}
			{else}
				{$CFG.currency}{$myobj->totalAlbumSaleAmount($displayDetails_arr.music_album_id)}
			{/if}
			</td>
		</tr>
		<tr>
			<td> <div class="clsTransactionHead">{$LANG.transactionlist_total_sales}</div></td>
			<td>{$displayDetails_arr.total_purchases}</td>
		</tr>
		<tr>
			<td> <div class="clsTransactionHead">{$LANG.transactionlist_total_plays}</div></td>
			<td>{$displayDetails_arr.total_plays}</td>
		</tr>
		<tr>
			<td> <div class="clsTransactionHead">{$LANG.transactionlist_total_views}</div></td>
			<td>{$displayDetails_arr.total_views}</td>
		</tr>
	</table>
	</div>
	{/if}

	{if $displayMembersList_arr.record_count}
        <div class="clsDataTable clsPopupContent"><table >
             <tr>
                <th>{$LANG.transactionlist_purchased_users}</th>
            </tr>
            <tr>
				<td>

            	{assign var='inc' value='1'}
                {foreach key=memberListKey item=memberListValue from=$displayMembersList_arr.row}
					<strong><a href="{$memberListValue.profile_url}" target="mycartwindow">{$memberListValue.user_name}</a></strong>{if $lastData!=$inc},{/if}&nbsp;
                {assign var='inc' value=$inc+1}
                {/foreach}
               </td>
			   </tr>
        </table></div>
    {else}
     	<div class="clsNoRecordsFound">{$LANG.transactionlist_members_norecords_found}</div>
    {/if}
{else}
	{if $displaySongList_arr.record_count}
                {$myobj->setTemplateFolder('general/','music')}
                {include file='box.tpl' opt='details_top'}
                {assign var='count' value='1'}
                  <div class="clsSongListDetails">
            		{foreach key=songListKey item=songListValue from=$displaySongList_arr.row}
                    	{counter  assign=count}
                    	<p {if $lastDiv == $count}{counter start=0} class="clsNoBorder"{/if}><strong><a href="{$songListValue.getUrl_viewMusic_url}">{$songListValue.wordWrap_mb_ManualWithSpace_music_title}</a></strong>(<span><a href="{$songListValue.get_artist_url}">{$songListValue.wordWrap_mb_ManualWithSpace_artist_name}</a></span>)</p>
                    {/foreach}
                  </div>
                {$myobj->setTemplateFolder('general/','music')}
                {include file='box.tpl' opt='details_bottom'}
     {/if}
{/if}