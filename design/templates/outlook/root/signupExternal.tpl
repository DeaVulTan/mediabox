{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selSignUp">
	<div class="clsPageHeading"><h2>{$LANG.signup_title}</h2></div>

	{include file='../general/information.tpl'}

	{if $myobj->isShowPageBlock('form_signup') }
	<h2>{$LANG.welcome_message}</h2>
	<br/>
	{$LANG.welcome_content}
		    <!-- clsFormSection - starts here -->
		{if $myobj->getFormField('signup_facebook') == 'No'}
			<form name="form_signup" id="form_signup" method="post" action="{$myobj->getUrl('signupexternal')}?id={$myobj->getFormField('id')}" autocomplete="off">
		{else}
			<form name="form_signup" id="form_signup" method="post" action="{$myobj->getUrl('signupexternal')}?hashcode={$myobj->getFormField('hashcode')}" autocomplete="off">
		{/if}

		{if $CFG.signup.captcha and $CFG.signup.captcha_method == 'honeypot'}
			{hpSolutionsRayzz}
		{/if}

		<p>{$LANG.common_mandatory_hint_1}<span class="clsMandatoryFieldIcon">*</span>{$LANG.common_mandatory_hint_2}</p>
		<div class="clsDataTable">
		<table summary="{$LANG.signup_tbl_summary}">
		   	<tr>
				<td class="clsSignUpLabel"><label for="username">{$myobj->form_signup.signup_user_name}</label><span class="clsMandatoryFieldIcon">{$myobj->displayMandatoryIcon('user_name')}</span></td>
				<td class="{$myobj->getCSSFormFieldCellClass('user_name')}">{$myobj->getFormFieldErrorTip('user_name')}<input type="text" class="clsTextBox validate-alphanum validate-username" name="user_name" id="username" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('user_name')}" maxlength="15"/>{$myobj->ShowHelpTip('signup_username','username')}</td>
		   	</tr>

			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('email')}"><label for="email">{$LANG.signup_email}</label><span class="clsMandatoryFieldIcon">{$myobj->displayMandatoryIcon('email')}</span></td>
				<td class="{$myobj->getCSSFormFieldCellClass('email')}">{$myobj->getFormFieldErrorTip('email')}<input type="text" class="clsTextBox required validate-email" name="email" id="email" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('email')}" />{$myobj->ShowHelpTip('email')}</td>
		    </tr>
		   	<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('first_name')}"><label for="first_name">{$LANG.signup_first_name}</label><span class="clsMandatoryFieldIcon">{$myobj->displayMandatoryIcon('first_name')}</span></td>
				<td class="{$myobj->getCSSFormFieldCellClass('first_name')}">{$myobj->getFormFieldErrorTip('first_name')}<input type="text" class="clsTextBox validate-first_name" name="first_name" id="first_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('first_name')}" />{$myobj->ShowHelpTip('first_name')}
				</td>
		   	</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('last_name')}"><label for="last_name">{$LANG.signup_last_name}</label><span class="clsMandatoryFieldIcon">{$myobj->displayMandatoryIcon('last_name')}</span></td>
				<td class="{$myobj->getCSSFormFieldCellClass('last_name')}">{$myobj->getFormFieldErrorTip('last_name')}<input type="text" class="clsTextBox validate-last_name" name="last_name" id="last_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('last_name')}" />{$myobj->ShowHelpTip('last_name')}
				</td>
		    </tr>

			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('sex')}"><label for="sex">{$LANG.signup_sex}</label><span class="clsMandatoryFieldIcon">{$myobj->displayMandatoryIcon('sex')}</span></td>
				<td class="{$myobj->getCSSFormFieldCellClass('sex')}">
					{foreach key=ssokey item=ssovalue from=$myobj->form_signup.showSexOptionButtons}
					&nbsp;&nbsp;<input type="radio" class="clsCheckRadio{if $ssokey==0} validate-one-required{/if}" id="sex_opt_{$ssovalue.value}" name="sex" {$ssovalue.checked} value="{$ssovalue.value}"  tabindex="{smartyTabIndex}" />{$ssovalue.description}
					{/foreach}
				</td>
		    </tr>

            <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('dob')}"><label for="dob">{$LANG.signup_dob}</label>&nbsp;<span>(YYYY-MM-DD) </span><span class="clsMandatoryFieldIcon">{$myobj->displayMandatoryIcon('dob')}</span></td>
				<td class="{$myobj->getCSSFormFieldCellClass('dob')}">{$myobj->getFormFieldErrorTip('dob')}

					<input type="text" class="clsTextBox required" name="dob" id="dob" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('dob')}" />	<button class="clsSubmitButton" type="reset" id="f_trigger_dob">...</button>
					{$myobj->populateCalendar('dob', 'f_trigger_dob', false)}
				</td>
		    </tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('country')}"><label for="country">{$LANG.signup_country}</label><span class="clsMandatoryFieldIcon">{$myobj->displayMandatoryIcon('country')}</span></td>
				<td class="{$myobj->getCSSFormFieldCellClass('country')}">{$myobj->getFormFieldErrorTip('country')}
					<select name="country" id="country" tabindex="{smartyTabIndex}" class="validate-selection">
						{$myobj->generalPopulateArray($smarty_country_list, $myobj->getFormField('country'))}
          			</select>
				{$myobj->ShowHelpTip('country')}
				</td>
		    </tr>


		    <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('postal_code')}"><label for="postal_code">{$LANG.signup_postal_code}</label><span class="clsMandatoryFieldIcon">{$myobj->displayMandatoryIcon('postal_code')}</span></td>
				<td class="{$myobj->getCSSFormFieldCellClass('postal_code')}">{$myobj->getFormFieldErrorTip('postal_code')}<input type="text" class="clsTextBox required" name="postal_code" id="postal_code" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('postal_code')}" />{$myobj->ShowHelpTip('postal_code')}</td>
		    </tr>
	{if $CFG.signup.captcha}
        {if $CFG.signup.captcha_method == 'recaptcha' and $CFG.captcha.public_key and $CFG.captcha.private_key}
	        <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('captcha')}">
                    <label for="recaptcha_response_field">{$LANG.signup_captcha}</label><span class="clsMandatoryFieldIcon">{$myobj->displayMandatoryIcon('country')}</span>
                </td>
                <td class="clsOverwriteRecaptcha {$myobj->getCSSFormLabelCellClass('captcha')}">
                    {$myobj->getFormFieldErrorTip('recaptcha_response_field')}
                    {$myobj->recaptcha_get_html()}
                    {$myobj->ShowHelpTip('captcha', 'recaptcha_response_field')}
                </td>
            </tr>
		{elseif $CFG.signup.captcha_method == 'image'}
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('captcha')}"><label for="captcha">{$LANG.signup_captcha}</label><span class="clsMandatoryFieldIcon">{$myobj->displayMandatoryIcon('captcha')}</span></td>
                <td class="{$myobj->getCSSFormFieldCellClass('captcha')}">{$myobj->getFormFieldErrorTip('captcha')}
                    <input type="text" class="clsTextBox required" name="captcha" id="captcha" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('captcha')}" /><br/><img id="captchaImage" src="{$CFG.site.url}captchaSignup.php" alt="{$LANG.signup_captcha_alt}" title="{$LANG.signup_captcha_title}" />
                        <a href="javascript:void(0)" onClick="return changeCaptchaImage()">{$LANG.new_code}</a>
                    {$myobj->ShowHelpTip('captcha')}
                </td>
            </tr>
		{/if}
    {/if}
		<tr>
			<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('agreement')}">
				{$myobj->getFormFieldErrorTip('agreement')}<input type="checkbox" class="clsCheckRadio" name="agreement" id="agreement" tabindex="{smartyTabIndex}" value="1" checked />
				<label for="agreement">{$myobj->form_signup.signup_agreement}</label>
			</td>
	    </tr>
	    <tr>
			<td class="{$myobj->getCSSFormFieldCellClass('submit')}" colspan="2"><input type="submit" class="clsSubmitButton" name="signup_submit" id="signup_submit" tabindex="{smartyTabIndex}" value="{$LANG.signup_submit}" /><input type="hidden" name="invitation_id" value="{$myobj->getFormField('invitation_id')}" />
			<input type="hidden" name="signup_facebook" value="{$myobj->getFormField('signup_facebook')}" />
			</td>
		</tr>
	</table>
		</div>
	</form>
	{if !$CFG.admin.allow_other_languages}
        {literal}
			<script type="text/javascript">
               var valid = new Validation('form_signup', {immediate : true});

               	Validation.addAllThese([
						['validate-username', '{/literal}{$myobj->LANG.signup_user_name_errormsg}{literal}', {
							minLength : {/literal}{$CFG.fieldsize.username.min}{literal},
							maxLength : {/literal}{$CFG.fieldsize.username.max}{literal}
						}],
						['validate-password', '{/literal}{$myobj->LANG.signup_password_errormsg}{literal}', {
							minLength : {/literal}{$CFG.fieldsize.password.min}{literal},
							maxLength : {/literal}{$CFG.fieldsize.password.max}{literal},
							notOneOf : ['password','PASSWORD','123456','012345'],
							notEqualToField : 'username'
						}],
						['validate-password-confirm', '{/literal}{$LANG.common_err_tip_invalid_passwordmatch}{literal}', {
							equalToField : 'user_password',
							notEqualToField : 'username'
						}]
						['validate-first_name', '{/literal}{$myobj->LANG.signup_first_name_errormsg}{literal}', {
							minLength : {/literal}{$CFG.fieldsize.first_name.min}{literal},
							maxLength : {/literal}{$CFG.fieldsize.first_name.max}{literal}
						}],
						['validate-last_name', '{/literal}{$myobj->LANG.signup_last_name_errormsg}{literal}', {
							minLength : {/literal}{$CFG.fieldsize.last_name.min}{literal},
							maxLength : {/literal}{$CFG.fieldsize.last_name.max}{literal}
						}]
					]);
            </script>
        {/literal}
	{/if}
{/if}
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}