<div id="selMusicPlaylistManageDisplay" class="clsLeftSideDisplayTable">
<form name="selSearchForm" id="selSearchForm" action="{$_SERVER.PHP_SELF}" method="post">
<table class="clsTransactionDetailSearch">
	<tr>
		<td>
		<input type="text" class="clsTextBox" name="from_date" id="from_date" tabindex="{smartyTabIndex}" onblur="setOldValue('from_date')" value="{if $myobj->getFormField('from_date')==''}{$LANG.transactionlist_from_date_select} {else}{$myobj->getFormField('from_date')}{/if}" />&nbsp;	<button class="clsSubmitButton" type="reset" id="f_trigger_from_date">...</button>
		{$myobj->populateCalendar('from_date', 'f_trigger_from_date', false)}
		</td>
		<td>
		<input type="text" class="clsTextBox" name="to_date" id="to_date" tabindex="{smartyTabIndex}" onblur="setOldValue('to_date')" value="{if $myobj->getFormField('to_date')==''}{$LANG.transactionlist_to_date_select} {else}{$myobj->getFormField('to_date')}{/if}" />&nbsp;	<button class="clsSubmitButton" type="reset" id="f_trigger_to_date">...</button>
		{$myobj->populateCalendar('to_date', 'f_trigger_to_date', false)}
		</td>
		<td>
		<div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" value="submit"></span></div>
		{$myobj->populateHidden($myobj->hidden_array)}
		</td>
	</tr>
</table>
</form>
{if $myobj->isResultsFound()}
  {if $CFG.admin.navigation.top}
              <div class="clsAudioPaging">
			   {$myobj->setTemplateFolder('general/','music')}
              {include file=pagination.tpl}
              </div>
  {/if}
<!-- top pagination end-->
<form name="transactionHistoryForm" id="transactionHistoryForm" action="{$_SERVER.PHP_SELF}" method="post">

		<table class="clsCommonTables clsTransactionListTable clsWidth85">
			<tr>
				<th>{$LANG.transactionlist_paypal_id}</th>
				<th>{$LANG.transactionlist_disbursed_amount}</th>
				<th>{$LANG.transactionlist_transaction_id}</th>
				<th>{$LANG.transactionlist_transaction_status}</th>
				<th>{$LANG.transactionlist_transaction_date}</th>
			</tr>
			{foreach key=transactionHistoryKey item=transactionHistory from=$showHistory_arr.row}
			<tr>
				<td>{$transactionHistory.paypal_id}</td>
				<td>{$CFG.currency}{$transactionHistory.disbursement_amount}</td>
				<td>{$transactionHistory.txn_id}</td>
				<td>{$transactionHistory.payment_status}</td>
				<td>{$transactionHistory.date_added}</td>
			</tr>
			{/foreach}
			{$myobj->populateHidden($myobj->hidden_array)}
		</table>

</form>
{else}
<div id="selMsgAlert">
    <p>{$LANG.transactionlist_no_transactions}</p>
</div>
{/if}
</div>

