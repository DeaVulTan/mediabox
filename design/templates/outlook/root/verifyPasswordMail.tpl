{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selForgotPassword">
	<div class="clsPageHeading"><h2>{$LANG.verifymail_title}</h2></div>
	{include file='../general/information.tpl'}

	{ if $myobj->isShowPageBlock('form_username')}
		<div id="selUsername">
			<form name="form_verifymail" id="selFormVerifyMail" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
                <p class="ClsMandatoryText">{$LANG.common_mandatory_hint_1}<span class="clsMandatoryFieldIconInText">*</span>{$LANG.common_mandatory_hint_2}</p>
				<input type="hidden" name="code" id="code" value="{$myobj->getFormField('code')}" />
				<div class="clsDataTable"><table summary="$LANG.verifymail_tbl_summary" class="clsTwoColumnTbl">
					<tr>
						<td class="{$myobj->getCSSFormLabelCellClass('username')}">{$myobj->displayMandatoryIcon('username')}<label for="username">{$LANG.common_username}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('username')}">
							<input type="text" class="clsTextBox" name="username" id="username" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('username')}" maxlength="{$CFG.fieldsize.username.max}"/>
							{$myobj->getFormFieldErrorTip('username')}
							{$myobj->ShowHelpTip('username')}
						</td>
					</tr>
					<tr>
                    	<td></td>
						<td class="{$myobj->getCSSFormFieldCellClass('submit')}"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="verifyUsername" id="verifyUsername" tabindex="{smartyTabIndex}" value="{$LANG.verifyUsername_submit}"/></div></div></td>
					</tr>
				</table></div>
			</form>
		</div>
	 {/if}

	{ if $myobj->isShowPageBlock('form_verifymail')}
	<form name="form_verifymail" id="selFormVerifyMail" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
	<p class="ClsMandatoryText">{$LANG.common_mandatory_hint_1}<span class="clsMandatoryFieldIconInText">*</span>{$LANG.common_mandatory_hint_2}</p>
		<table summary="{$LANG.verifymail_tbl_summary}" class="clsTwoColumnTbl">
			 <tr>
					<td class="{$myobj->getCSSFormLabelCellClass('password')}">{$myobj->displayMandatoryIcon('password')}<label for="password">{$LANG.common_password}</label></td>
					<td class="{$myobj->getCSSFormFieldCellClass('password')}">
						<input type="password" class="clsTextBox" name="password" id="password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('password')}" maxlength="{$CFG.fieldsize.password.max}"/>
						{$myobj->getFormFieldErrorTip('password')}
						{$myobj->ShowHelpTip('password')}
					</td>
			    </tr>
			    <tr>
					<td class="{$myobj->getCSSFormLabelCellClass('confirm_password')}">{$myobj->displayMandatoryIcon('confirm_password')}<label for="confirm_password">{$LANG.verifymail_confirm_password}</label></td>
					<td class="{$myobj->getCSSFormFieldCellClass('confirm_password')}">
						<input type="password" class="clsTextBox" name="confirm_password" id="confirm_password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('confirm_password')}" maxlength="{$CFG.fieldsize.password.max}"/>
						{$myobj->getFormFieldErrorTip('confirm_password')}
						{$myobj->ShowHelpTip('confirmpassword','confirm_password')}
					</td>
			    </tr>
		    <tr>
				<td class="{$myobj->getCSSFormFieldCellClass('submit')}" colspan="2">
					<input type="hidden" name="user_id" id="user_id" value="{$myobj->getFormField('user_id')}" />
					<input type="hidden" name="username" value="{$myobj->getFormField('username')}" />
					<input type="hidden" name="code" id="code" value="{$myobj->getFormField('code')}" />
					<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="verifymail" id="verifymail" tabindex="{smartyTabIndex}" value="{$LANG.verifymail_submit}" /></div></div>
				</td>
			</tr>
		</table>
	</form>
	 {/if}
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}