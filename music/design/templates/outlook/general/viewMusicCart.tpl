<script type="text/javascript">
var block_arr = new Array('selMsgCartConfirmMulti');
</script>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_top"}
			<div class="clsOverflow clsTextAlignLeft">
              <div class="clsHeadingLeft">
                <h2><span>
                {$LANG.viewmusiccart_cart_title}
				</span></h2>
              </div>
              {if !$myobj->getFormField('status')}
              <div class="clsHeadingRight">
                  <a href="javascript:void(0)" onClick="window.close()" id="show_link" class="clsResetFilter">
				  <input type="button" class="clsSubmitButton" name="keepshop" value="Keep Shopping" tabindex="{smartyTabIndex}" />
				  </a>
              </div>
              {/if}
          </div>

{$myobj->setTemplateFolder('general/','music')}
{include file='information.tpl'}
{if $myobj->isShowPageBlock('view_cart_form')}
{if isset($myobj->recordFound) and $myobj->recordFound}
<div class="clsCartPaycontainer">
	<form name="frmMusicCartDetails" id="frmMusicCartDetails" method="post">

	<table class="clsCommonTables clsViewCartTable">
		<tr>
			<th><p class=""><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onClick="CheckAll(document.frmMusicCartDetails.name, document.frmMusicCartDetails.check_all.name)"/></p></th>
			<th>{$LANG.viewmusiccart_music_album_title}</th>
			<th>{$LANG.viewmusiccart_price}</th>
		</tr>

		{if isset($myobj->musicrecordFound) and $myobj->musicrecordFound}
		{foreach from=$music_list_result item=result key=inc name=music}
		<tr>
			<td><input type="checkbox" name="checkbox[]" id="view_cart_checkbox_{$result.record.music_id}" value="music_{$result.record.music_id}" onClick="disableHeading('frmMusicCartDetails');"/></td>
			<td>
			<p> <a onclick="cartRedirectUrl('{$result.view_music_link}')" href="#">{$result.music_title_word_wrap}</a> </p></td>
			<td><span class="clsTransactionPrice">{$CFG.currency}{$result.record.music_price}</span></td>
		</tr>
		{/foreach}
		{/if}


		{if isset($myobj->albumrecordFound) and $myobj->albumrecordFound}
		{foreach from=$album_list_result item=result key=inc name=album}
		<tr>
			<td><input type="checkbox" name="checkbox[]" id="view_cart_checkbox_{$result.record.music_album_id}" value="album_{$result.record.music_album_id}" onClick="disableHeading('frmMusicCartDetails');"/></p></td>
			<td>
			<p>{$LANG.viewmusiccart_album}&nbsp;<a onclick="cartRedirectUrl('{$result.view_album_link}')" href="#">{$result.album_title_word_wrap}</a></p></td>
			<td><span class="clsTransactionPrice">{$CFG.currency}{$result.record.album_price}</span></td>
		</tr>
		{/foreach}
		{/if}
		<tr>
			<td style="width:100px;">
			<div class="clsButtonHolder" style="margin:0;height:20px">
			<p class="clsDeleteButton">
				<span class="">
					<input type="button" class="clsSubmitButton" name="action_submit" id="action_submit" tabindex="{smartyTabIndex}" value="Delete" onClick="if(getMultiCheckBoxValue('frmMusicCartDetails', 'check_all', '{$LANG.viewmusiccart_err_msg_item_select}', -100, 20, 'anchor_id')) {literal} { {/literal} Confirmation('selMsgCartConfirmMulti', 'msgCartConfirmformMulti1', Array('checkbox', 'selCartAlertSuccess'), Array(multiCheckValue,'{$LANG.viewmusiccart_remove_cart_alert_msg}'), Array('value', 'innerHTML'), -100, 20, 'anchor_id'); {literal} } {/literal}" />
				</span>
			</p>
			</div>
			</td>
			<td>{$LANG.viewmusiccart_total_amount}</td>
			<td><span class="clsTransactionPrice">{$CFG.currency}{$total_price}</span></td>
			<input type="hidden" name="pricedetails" value="{$pricedetails}">
		</tr>
	</table>

		{if isMember()}
		<div class="clsButtonHolder" style="height:20px">
			<p class="clsEditButton" style="float:right;">
				<span class="">
					<input type="submit" class="clsSubmitButton" name="confirm_order" id="confirm_order" value="Checkout" tabindex="{smartyTabIndex}" />
				</span>
			</p>
			<input type="hidden" name="checkoutprocess" value="true">
			<input type="hidden" name="total_amount" id="total_amount" value="{$total_price}">
		</div>
		</form>
	</div>
	{else}
		<a href="{$myobj->getUrl('viewmusiccart', '', '', 'members', 'music')}"><input type="button" class="clsSubmitButton" name="confirm_order" id="confirm_order" value="Checkout" tabindex="{smartyTabIndex}" /></a>
	{/if}

{else}
<div class="clsCartPaycontainer clsNoCartMsg">
	{$LANG.viewmusiccart_msg_no_records}
	</div>
{/if}
<p id='anchor_id'></p>

 <div id="selMsgCartConfirmMulti" class="clsPopupConfirmation" style="display:none;">
        <p id="selCartAlertSuccess"></p>
        <form name="msgCartConfirmformMulti1" id="msgCartConfirmformMulti1" method="post" action="{$myobj->getUrl('viewmusiccart','','','','music')}" autocomplete="off">
          <input type="submit" class="clsSubmitButton" name="delete_cart" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
          <input type="button" class="clsSubmitButton" onclick="return hideAllBlocks();" name="delete_cart" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" /> &nbsp;
          <input type="hidden" id="music_id" value="music_id">
          <input type="hidden" name="checkbox" id="checkbox" />
        </form>

{/if}

{if $myobj->isShowPageBlock('form_show_payment')}
<div class="clsCartPaycontainer">
<p class="clsBlackBtn"><a href="javascript:void(0)" onClick="history.back(1)">{$LANG.common_music_back}</a></p>
<p class="clsCartFinalPayment clsTextAlignLeft">{$LANG.viewmusiccart_amount_to_pay}<span class="clsTransactionPrice"> {$CFG.currency}{$payment_details.paypal.net_amount}</span> </p>
<p class="clsCartFinalPayment clsTextAlignLeft">{$LANG.viewmusiccart_click_to_pay}</p>
	{$myobj->setTemplateFolder('members/', 'music')}
	{include file="paypal_form.tpl"}
</div>
{/if}
{$myobj->setTemplateFolder('general/','music')}
{include file='box.tpl' opt='audioindex_bottom'}