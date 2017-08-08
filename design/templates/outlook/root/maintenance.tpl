<div class="clsMaintenancePage">
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selLogin">
	<div class="clsPageHeading">
    <h2>{$LANG.maintenancefrm_title}</h2></div>
  	{include file='../general/information.tpl'}
    {if $myobj->isShowPageBlock('form_error')}
        <div id="selMsgError">
            <form name="errorForm" id="errorForm" method="post" action="{$myobj->getUrl('login')}" autocomplete="off">
                {$myobj->populateHidden($myobj->form_error.hidden_arr)}
                <input type="hidden" name="code" id="code" value="true" />
                <p>{$LANG.common_msg_error_sorry} {$myobj->getCommonErrorMsg()}</p>
            </form>
        </div>
    {/if}
    { if $myobj->isShowPageBlock('form_maintenance')}
		<div id="selMsgSuccess">
			<p>
				{if isset($CFG.admin.module.site_maintenance_display_text) && $CFG.admin.module.site_maintenance_display_text}
					{$CFG.admin.module.site_maintenance_display_text}
				{else}
					{$LANG.maintenancefrm_site_maintenance_msg}
				{/if}
			</p>
			<p>{$LANG.maintenancefrm_site_maintenance_hint1}&nbsp;<a href="{$myobj->getUrl('maintenance', '?pg=login', '?pg=login', '')}">{$LANG.common_click_here}</a>&nbsp;{$LANG.maintenancefrm_site_maintenance_hint2}</p>
		</div>
	 {/if}
	 <div id="loginfrm">
  	{if $myobj->isShowPageBlock('form_login')}
		<form name="form_login" id="form_login" method="post" action="{$myobj->getUrl('maintenance')}" autocomplete="off">
		<p class="clsMandatoryText">{$LANG.common_mandatory_hint_1}<span class="clsMandatoryFieldIcon">*</span>{$LANG.common_mandatory_hint_2}</p>
        <input type="hidden" name="url" id="url" value="{$myobj->getFormField('url')}" />
			<div class="clsDataTable">
            <table summary="{$LANG.maintenancefrm_tbl_summary}" class="clsTwoColumnTbl clsNoBorder">
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('user_name')}"><label for="user_name">{$myobj->form_login.maintenancefrm_field_label}</label>{$myobj->displayMandatoryIcon('user_name')}</td>
					<td class="{$myobj->getCSSFormFieldCellClass('user_name')}">
						<input type="text" class="clsTextBox" name="user_name" id="user_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('user_name')}" maxlength="{$CFG.fieldsize.username.max}"/>
						{$myobj->getFormFieldErrorTip('user_name')}
                    	{$myobj->ShowHelpTip($myobj->form_login.maintenancefrm_field, 'user_name')}
					</td>
			    </tr>
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('password')}"><label for="password">{$LANG.common_password}</label>{$myobj->displayMandatoryIcon('password')}</td>
					<td class="{$myobj->getCSSFormFieldCellClass('password')}">
						<input type="password" class="clsTextBox" name="password" id="password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('password')}" maxlength="{$CFG.fieldsize.password.max}"/>
						{$myobj->getFormFieldErrorTip('password')}
                    	{$myobj->ShowHelpTip('password')}
					</td>
			    </tr>
			    <tr>
                	<td>&nbsp;</td>
					<td class="{$myobj->getCSSFormFieldCellClass('submit')}"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="maintenancefrm_submit" id="maintenancefrm_submit" tabindex="{smartyTabIndex}" value="{$LANG.maintenancefrm_submit}" /></div></div></td>
		   	  	</tr>
			</table>
            </div>
		</form>
	{/if}
	</div>
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
</div>