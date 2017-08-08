{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_top"}
			<div class="clsOverflow">
              <div class="clsHeadingLeft">
                <h2><span>
                {$LANG.musicuserpaymentsettings_title}
				</span></h2>
              </div>
            </div>
{$myobj->setTemplateFolder('general/','music')}
{include file='information.tpl'}
{if $myobj->isShowPageBlock('block_music_payment_settings_form')}
<form name="music_payment_form" id="music_payment_form" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off" onsubmit="return chkMandatoryFields();">
	<table>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('paypal_id')}">
				<label for="paypal_id">{$LANG.musicuserpaymentsettings_paypal_id}</label>&nbsp;
			</td>
			<td class="{$myobj->getCSSFormFieldCellClass('paypal_id')}">
            	<input type="text" class="clsTextBox required" name="paypal_id" id="paypal_id" value="{$myobj->getFormField('paypal_id')}" tabindex="{smartyTabIndex}" />
				{$myobj->getFormFieldErrorTip('paypal_id')}
			</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('threshold_amount')}">
				<label for="paypal_id">{$LANG.musicuserpaymentsettings_threshold_amount}</label>&nbsp;({$CFG.currency})
			</td>
			<td class="{$myobj->getCSSFormFieldCellClass('threshold_amount')}">
            	<input type="text" class="clsTextBox required" name="threshold_amount" id="paypal_id" value="{$myobj->getFormField('threshold_amount')}" tabindex="{smartyTabIndex}" />
				{$myobj->getFormFieldErrorTip('threshold_amount')}
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" class="clsSubmitButton" name="update_payment" id="update_payment" tabindex="{smartyTabIndex}" value="{$LANG.musicuserpaymentsettings_update}" />
			</td>
		</tr>
	</table>
</form>
{literal}
		<script type="text/javascript">
               var valid = new Validation('music_payment_form', {immediate : true});
            </script>
        {/literal}
{/if}
{$myobj->setTemplateFolder('general/','music')}
{include file='box.tpl' opt='audioindex_bottom'}