{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selVerifyMail">
	<div class="clsPageHeading"><h2>{$LANG.verifymail_title}</h2></div>
	{include file='../general/information.tpl'}
{ if $myobj->isShowPageBlock('form_verifymail') and $CFG.admin.ask_password_to_activation}
	<form name="form_verifymail" id="selFormVerifyMail" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
		<input type="hidden" name="code" id="code" value="{$myobj->getFormField('code')}" />
		<div class="clsDataTable"><table summary="{$LANG.verifymail_tbl_summary}" class="clsTwoColumnTbl">
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('password')}"><label for="password">{$LANG.common_password}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('password')}">{$myobj->getFormFieldErrorTip('password')}<input type="password" class="clsTextBox" name="password" id="password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('password')}" />{$myobj->ShowHelpTip('password')}</td>
		    </tr>
		    <tr>
            	<td></td>
				<td class="{$myobj->getCSSFormFieldCellClass('submit')}"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="verifymail" id="verifymail" tabindex="{smartyTabIndex}" value="{$LANG.verifymail_submit}" /></div></div></td>
			</tr>
		</table></div>
	</form>
{/if}
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}