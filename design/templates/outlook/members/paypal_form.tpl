<form name="form_register" id="selFormRegister" action="{if $CFG.payment.paypal.test_mode}{$CFG.payment.paypal.test_url}{else}{$CFG.payment.paypal.url}{/if}" method="post">
	<input type="hidden" name="cmd" value="_xclick" />
	<input type="hidden" name="business" value="{$CFG.payment.paypal.merchant_email}" />
	<input type="hidden" name="item_name" value="{$payment_details.paypal.item_detail}" />
	<input type="hidden" name="currency_code" value="{$CFG.payment.paypal.currency_code}" />
	<input type="hidden" name="return" value="{$payment_details.paypal.success_url}" />
	<input type="hidden" name="cancel_return" value="{$payment_details.paypal.cancel_url}" />
	<input type="hidden" name="notify_url" value="{$payment_details.paypal.notify_url}" />

	<input type="hidden" name="amount" value="{$payment_details.paypal.net_amount}" />
	<input type="hidden" name="undefined_quantity" value="0" />
	<input type="hidden" name="no_shipping" value="1" />
	<input type="hidden" name="no_note" value="0" />
	<!-- os0 holds the value of ADV_ID. It will be fetched as "option_selection1" in IPN script -->
	{counter start=0 skip=1 assign="inc"}
	{foreach key=key item=value from=$payment_details.paypal.user_defined}	
	<input type="hidden" name="on{$inc}" value="{$key}" />
	<input type="hidden" name="os{$inc}" value="{$value}" />
	{counter}
	{/foreach}	
	<input name="pay_paypal" id="pay_paypal" type="submit" value="{$payment_details.paypal.submit_value}">
</form>