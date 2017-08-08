{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selLogin">
	<div class="clsPageHeading"><h2>{$LANG.login_title}</h2></div>
  {include file='../general/information.tpl'}


    {if $myobj->isShowPageBlock('form_error')}
        <div id="selMsgError">
            <form name="errorForm" id="errorForm" method="post" action="{$myobj->getUrl('adminlogin')}" autocomplete="off">
                {$myobj->populateHidden($myobj->form_error.hidden_arr)}
                <input type="hidden" name="code" id="code" value="true" />
                <p>{$LANG.common_msg_error_sorry} {$myobj->getCommonErrorMsg()}</p>
            </form>
        </div>
    {/if}

  {if $myobj->isShowPageBlock('form_login')}
		<form name="form_login" id="form_login" method="post" action="{$myobj->getUrl('adminlogin')}" autocomplete="off">
		<p class="clsMandatoryText">{$LANG.common_mandatory_hint_1}<span class="clsMandatoryFieldIcon">*</span>{$LANG.common_mandatory_hint_2}</p>
			<input type="hidden" name="url" id="url" value="{$myobj->getFormField('url')}" />
			<div class="clsDataTable">
            <table summary="{$LANG.login_tbl_summary}" class="clsTwoColumnTbl">
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('user_name')}"><label for="user_name">{$LANG.common_username}</label>{$myobj->displayMandatoryIcon('user_name')}</td>
					<td class="{$myobj->getCSSFormFieldCellClass('user_name')}"><input type="text" class="clsTextBox" name="user_name" id="user_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('user_name')}" maxlength="{$CFG.fieldsize.username.max}"/>{$myobj->getFormFieldErrorTip('user_name')}
                    {$myobj->ShowHelpTip($myobj->form_login.login_field, 'user_name')}
                    </td>
			    </tr>
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('password')}"><label for="password">{$LANG.common_password}</label>{$myobj->displayMandatoryIcon('password')}</td>
					<td class="{$myobj->getCSSFormFieldCellClass('password')}"><input type="password" class="clsTextBox" name="password" id="password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('password')}" maxlength="{$CFG.fieldsize.password.max}" />{$myobj->getFormFieldErrorTip('password')}
                    {$myobj->ShowHelpTip('password')}
                    </td>
			    </tr>
			    {if $CFG.login.captcha}
			    	{if $CFG.login.login_captcha_method =='recaptcha' and $CFG.captcha.public_key and $CFG.captcha.private_key}
					    <tr>
							<td class="{$myobj->getCSSFormLabelCellClass('captcha')}">
								<label for="recaptcha_response_field">{$LANG.login_captcha}</label>
							</td>
							<td class="clsOverwriteRecaptcha {$myobj->getCSSFormLabelCellClass('captcha')}">
								{$myobj->getFormFieldErrorTip('recaptcha_response_field')}
								{$myobj->recaptcha_get_html()}
                                {$myobj->ShowHelpTip('captcha', 'recaptcha_response_field')}
							</td>
					    </tr>
                     {/if}
                 {/if}

				<tr>
                	<td></td>
					<td class="{$myobj->getCSSFormFieldCellClass('remember')} clsCheckBoxList"><p><span class="clsCheckBox"><input type="checkbox" class="clsCheckRadio" name="remember" id="remember1" tabindex="{smartyTabIndex}" value="1"{$myobj->isCheckedCheckBox('remember')} /></span><label for="remember1">&nbsp;&nbsp;{$LANG.login_remember_login}</label></p></td>
			    </tr>
			    <tr>
                	<td></td>
					<td class="{$myobj->getCSSFormFieldCellClass('submit')}"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="login_submit" id="login_submit" tabindex="{smartyTabIndex}" value="{$LANG.login_submit}" /></div></div></td>
		   	  	</tr>
			</table>
            </div>
		</form>
{/if}
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}