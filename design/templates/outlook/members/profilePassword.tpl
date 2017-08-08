{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selEditPasswordProfile">
	<div class="clsPageHeading"><h2>{$LANG.profile_password_title}</h2></div>
	{$myobj->setTemplateFolder('general/')}
	{include file='information.tpl'}
	<div id="selLeftNavigation">
		{if $myobj->isShowPageBlock('form_change_password')}
			<form name="selFormEditProfile" id="selFormEditProfile" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
            <p class="ClsMandatoryText">{$LANG.common_mandatory_hint_1}<span class="clsMandatoryFieldIconInText">*</span>{$LANG.common_mandatory_hint_2}</p>
				<div class="clsDataTable">
				<table summary="{$LANG.profile_password_tbl_summary}" class="clsProfileEditTbl">
				    <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('current_password')}">{$myobj->displayMandatoryIcon('current_password')}<label for="current_password">{$LANG.profile_password_current_password}</label></td>
						<td class="<?php echo $password->getCSSFormFieldCellClass('current_password');?>">
							<input type="password" class="clsTextBox" name="current_password" id="current_password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('current_password')}" maxlength="{$CFG.fieldsize.password.max}"/>
							{$myobj->getFormFieldErrorTip('current_password')}
		                	{$myobj->ShowHelpTip('current_password')}
		                </td>
				    </tr>
				    <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('password_new')}">{$myobj->displayMandatoryIcon('password_new')}<label for="password_new">{$myobj->form_change_password.password_label}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('password_new')}">
							<input type="password" class="clsTextBox" name="password_new" id="password_new" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('password_new')}" maxlength="{$CFG.fieldsize.password.max}"/>
							{$myobj->getFormFieldErrorTip('password_new')}
		                	{$myobj->ShowHelpTip('password_new')}
		                </td>
				    </tr>
				    <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('confirm_password')}">{$myobj->displayMandatoryIcon('confirm_password')}<label for="confirm_password">{$LANG.profile_password_confirm_password}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('confirm_password')}">
							<input type="password" class="clsTextBox" name="confirm_password" id="confirm_password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('confirm_password')}" maxlength="{$CFG.fieldsize.password.max}"/>
							{$myobj->getFormFieldErrorTip('confirm_password')}
		                	{$myobj->ShowHelpTip('confirm_password')}
		                </td>
				    </tr>
				    <tr>
						<td>&nbsp;</td>
						<td class="{$myobj->getCSSFormFieldCellClass('submit')}"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="password_submit" id="password_submit" tabindex="{smartyTabIndex}" value="{$LANG.profile_password_submit}" /></div></div></td>
				   </tr>
				</table>
		        </div>
			</form>
		{/if}
	</div>
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}