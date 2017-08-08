<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgCartSuccess');
</script>
<div class="clsTabNavigation">

<div class="clsAudioListContainer clsAudioPlayListContainer">
        <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}">
            <input type="hidden" name="advanceFromSubmission" value="1"/>
            <input type="hidden" name="start" value="1"/>
            <div class="clsOverflow">
                    <div class="clsHeadingLeft">
                        <h2>
                            {if $myobj->page_heading != ''}
                                {$myobj->page_heading}
                            {else}
                                {$LANG.musicalbumList_title}
                            {/if}
                        </h2>
                    </div>
                </div>
            <p class="clsBackLink">
<a href="manageTransactionDetails.php">Back</a>
</p>
    {if isset($paymentList_arr.record_found) and $paymentList_arr.record_found}
	<table class="clsCommonTables">
	<tr>
		<td>{$LANG.transactionlist_total_earcnings} </td>
		<td><span class="clsTransactionPrice">${$paymentList_arr.total_revenue}</span></td>
	</tr>
	<tr>
		<td>{$LANG.transactionlist_commission_amount} </td>
		<td><span class="clsTransactionPrice">${$paymentList_arr.commission_amount}</span></td>
	</tr>
	<tr>
		<td>{$LANG.transactionlist_disbursement_amount} </td>
		<td> <span class="clsTransactionPrice">${$paymentList_arr.withdrawl_amount}</span> &nbsp;(<a href="transactionHistory.php?user_id={$myobj->getFormField('user_id')}" title="{$LANG.musicalbumList_allsongdetail_helptips}">View Details</a>)</td>
	</tr>
	<tr>
		<td>{$LANG.transactionlist_pending_amount} </td>
		<td><span class="clsTransactionPrice">${$paymentList_arr.pending_amount}</span></td>
	</tr>
	</table>
	{/if}
			<div class="clsAudioListMenu">
                <ul>
                <li id="selMusicTransaction" class="{$music_class}"><a href="{$CFG.site.url}admin/music/transactionList.php?transaction_type=music&user_id={$myobj->getFormField('user_id')}"><span>{$LANG.transactionlist_music_transaction}</span></a></li>
  				<li id="selAlbumTransaction" class="{$album_class}"><a href="{$CFG.site.url}admin/music/transactionList.php?transaction_type=album&user_id={$myobj->getFormField('user_id')}"><span>{$LANG.transactionlist_album_transaction}</span></a></li>
				</ul>
			</div>
				{if $myobj->isShowPageBlock('search_albumlist_block')}


                <div id="advancedAlbumlistSearch" class="clsAdvancedFilterContainer clsMarginTop5"  >
                        <table class="clsAdvancedFilterTable clsTransactionAdvancedFilter">
                            <tr>
                                <td>
                                    <input class="clsTextBox" type="text" name="albumlist_title" id="albumlist_title"   value="{if $myobj->getFormField('albumlist_title') == ''}{$LANG.musicalbumList_albumList_title}{else}{$myobj->getFormField('albumlist_title')}{/if}" onblur="setOldValue('albumlist_title')"  onfocus="clearValue('albumlist_title')"/>
                                </td>
                                <td>
                                    <input class="clsTextBox" type="text" name="music_title" id="music_title" onfocus="clearValue('music_title')"  onblur="setOldValue('music_title')" value="{if $myobj->getFormField('music_title') == ''}{$LANG.musicalbumList_no_of_music_title} {else}{$myobj->getFormField('music_title')}{/if}" />
                                </td>

                            </tr>
                            	<td>
                                    <input class="clsTextBox" type="text" name="from_date" id="from_date" onblur="setOldValue('from_date')" value="{if $myobj->getFormField('from_date')==''}{$LANG.transactionlist_from_date_select} {else}{$myobj->getFormField('from_date')}{/if}"/>&nbsp;	<button class="clsSubmitButton" type="reset" id="f_trigger_from_date">...</button>
									{$myobj->populateCalendar('from_date', 'f_trigger_from_date', false)}
                                </td>
                                <td>
                                    <input class="clsTextBox" type="text" name="to_date" id="to_date" onblur="setOldValue('to_date')" value="{if $myobj->getFormField('to_date')==''}{$LANG.transactionlist_to_date_select} {else}{$myobj->getFormField('to_date')}{/if}" />&nbsp;	<button class="clsSubmitButton" type="reset" id="f_trigger_to_date">...</button>
									{$myobj->populateCalendar('to_date', 'f_trigger_to_date', false)}
                                </td>
                            <tr>
                            </tr>
                        <tr>
                            <td colspan="2">
                                <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="search" id="search" value="{$LANG.musicalbumList_search}" onclick="document.seachAdvancedFilter.start.value = '0';" /></span></div>
                                <div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="submit" value="Reset" id="avd_reset" name="avd_reset"/></span></div>
                        	</td>
                        </tr>
                        </table>
                 </div>
               </form>

                {/if}
				<div id="selAlbumTransactionContent">

                {if  $myobj->isShowPageBlock('list_albumlist_block')}

                    <div id="selMusicPlaylistManageDisplay" class="clsLeftSideDisplayTable">
                        {if $myobj->isResultsFound()}
                          {if $CFG.admin.navigation.top}
                                      <div class="clsAudioPaging">
                                      {$myobj->setTemplateFolder('admin')}
                                      {include file=pagination.tpl}
                                      </div>
                          {/if}
                        <!-- top pagination end-->
                        <form name="musicListForm" id="musicListForm" action="{$_SERVER.PHP_SELF}" method="post">

								<table class="clsCommonTables clsTransactionListTable">
									<tr>
										<th>{$LANG.transactionlist_album_title}</th>
										<th>{$LANG.transactionlist_price}</th>
										<th>{$LANG.transactionlist_total_sales}</th>
										<th></th>
									</tr>
									{foreach key=musicAlbumlistKey item=musicalbumlist from=$myobj->list_albumlist_block.showAlbumlists.row}
									<tr>
										<td>{$musicalbumlist.word_wrap_album_title}</td>
										<td><span class="clsTransactionPrice">{$CFG.currency}{$musicalbumlist.album_price}</span></td>
										<td>{$musicalbumlist.total_purchases}</td>
										<td><a href="javascript:void(0)" onclick="javascript: myLightWindow.activateWindow({literal}{{/literal}type:'external',href:'{$musicalbumlist.light_window_url}',title:'{$LANG.transactionlist_details_list}',width:550,height:350{literal}}{/literal});" title="{$LANG.musicalbumList_allsongdetail_helptips}">{$LANG.transactionlist_details_list}</a></td>
									</tr>
									{/foreach}
								</table>

						</form>
                        {else}
                        <div id="selMsgAlert">
                            <p>{$LANG.transactionlist_no_album_purchased}</p>
                            <p>{$myobj->music_purchase_url}</p>
                        </div>
                    {/if}
                        </div>
                    {/if}
				</div>
				{if  $myobj->isShowPageBlock('list_musiclist_block')}
				<div id="selMusicTransactionContent">
				{if $myobj->isResultsFound()}
                          {if $CFG.admin.navigation.top}
                                      <div class="clsAudioPaging">
                                      {$myobj->setTemplateFolder('admin')}
                                      {include file=pagination.tpl}
                                      </div>
                          {/if}
				<form name="musicListForm" id="musicListForm" action="{$_SERVER.PHP_SELF}" method="post">

								<table class="clsCommonTables clsTransactionListTable">
									<tr>
										<th>{$LANG.transactionlist_music_title}</th>
										<th>{$LANG.transactionlist_price}</th>
										<th>{$LANG.transactionlist_total_sales}</th>
										<th></th>
									</tr>
									{if $myobj->list_musiclist_block.showMusiclists}
									{foreach key=musiclistKey item=musiclist from=$myobj->list_musiclist_block.showMusiclists.row}
									<tr>
										<td>{$musiclist.word_wrap_music_title}</td>
										<td><span class="clsTransactionPrice">{$CFG.currency}{$musiclist.music_price}</span></td>
										<td>{$musiclist.total_purchases}</td>
										<td><a href="javascript:void(0)" onclick="javascript: myLightWindow.activateWindow({literal}{{/literal}type:'external',href:'{$musiclist.light_window_url}',title:'{$LANG.transactionlist_details_list}',width:550,height:350{literal}}{/literal});" title="{$LANG.musicalbumList_allsongdetail_helptips}">{$LANG.transactionlist_details_list}</a></td>
									</tr>
									{/foreach}
									{/if}
								</table>

						</form>
				</div>
				{else}
                        <div id="selMsgAlert">
                            <p>{$LANG.transactionlist_no_music_purchased}</p>
                            <p>{$myobj->album_purchase_url}</p>
                        </div>
				{/if}
				{/if}


    </div>
