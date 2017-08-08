{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selSignUp">
	<div class="clsPageHeading"><h2>{$LANG.signup_artist_title}</h2></div>

	{include file='../general/information.tpl'}

	{if $myobj->isShowPageBlock('form_signup') }
		    <!-- clsFormSection - starts here -->
		<form name="form_signup" id="form_signup" method="post" action="{$myobj->getUrl('signup')}" autocomplete="off">
		<input type="hidden" name="music_user_type" id="music_user_type" value="Artist">
		{if $CFG.signup.captcha and $CFG.signup.captcha_method == 'honeypot'}
			{hpSolutionsRayzz}
		{/if}

		<p class="clsMandatoryText">{$LANG.signup_mandatory_hint_1}<span class="clsMandatoryFieldIcon">*</span>{$LANG.signup_mandatory_hint_2}</p>
		<div class="clsDataTable">
        <table summary="{$LANG.signup_tbl_summary}">
		   	<tr>
				<td class="clsSignUpLabel"><label for="username">{$myobj->form_signup.signup_user_name}</label><span class="clsMandatoryFieldIcon">{$myobj->displayMandatoryIcon('user_name')}</span></td>
				<td class="{$myobj->getCSSFormFieldCellClass('user_name')}">{$myobj->getFormFieldErrorTip('user_name')}<input type="text" class="clsTextBox validate-alphanum validate-username" name="user_name" id="username" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('user_name')}" maxlength="{$CFG.fieldsize.username.max}"/>{$myobj->ShowHelpTip('signup_username','username')}</td>
		   	</tr>
		    <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('password')}"><label for="user_password">{$myobj->form_signup.signup_password}</label><span class="clsMandatoryFieldIcon">{$myobj->displayMandatoryIcon('password')}</span></td>
				<td class="{$myobj->getCSSFormFieldCellClass('password')}">{$myobj->getFormFieldErrorTip('password')}<input type="password" class="clsTextBox validate-password" name="password" id="user_password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('password')}" maxlength="{$CFG.fieldsize.password.max}"/>
	                {$myobj->ShowHelpTip('signup_password', 'user_password')}
				</td>
		    </tr>
		    <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('confirm_password')}"><label for="confirm_password">{$LANG.signup_confirm_password}</label><span class="clsMandatoryFieldIcon">{$myobj->displayMandatoryIcon('confirm_password')}</span></td>
				<td class="{$myobj->getCSSFormFieldCellClass('confirm_password')}">{$myobj->getFormFieldErrorTip('confirm_password')}<input type="password" class="clsTextBox required validate-password-confirm" name="confirm_password" id="confirm_password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('confirm_password')}"  maxlength="{$CFG.fieldsize.password.max}"/>{$myobj->ShowHelpTip('confirmpassword','confirm_password')}</td>
		    </tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('email')}"><label for="email">{$LANG.signup_email}</label><span class="clsMandatoryFieldIcon">{$myobj->displayMandatoryIcon('email')}</span></td>
				<td class="{$myobj->getCSSFormFieldCellClass('email')}">{$myobj->getFormFieldErrorTip('email')}<input type="text" class="clsTextBox required validate-email" name="email" id="email" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('email')}" />{$myobj->ShowHelpTip('signup_email','email')}</td>
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
		    <tr id="selCategoryBlock">
                <td class="{$myobj->getCSSFormLabelCellClass('music_artist_category_id')}">
                    <label for="music_artist_category_id">{$LANG.signup_music_artist_category}</label>&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.common_music_mandatory}</span>&nbsp;
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('music_category_id')}">
                <div id="selGeneralCategory">
                    <select name="music_artist_category_id" id="music_artist_category_id" {if $CFG.admin.musics.artist_sub_category} onChange="populateMusicArtistSubCategory(this.value)" {/if} tabindex="{smartyTabIndex}" class="clsSelectLarge validate-selection">
                      <option value="">{$LANG.common_select_option}</option>
                      {$myobj->populateMusicArtistCatagory('General')}
                    </select>
                    {$myobj->getFormFieldErrorTip('music_artist_category_id')}
                    {$myobj->ShowHelpTip('music_artist_category_id')}
                    <p class="clsSelectNote">{$LANG.signup_artist_select_category}</p>
                </div>
               </td>
            </tr>
            {if isset($CFG.admin.musics.artist_sub_category) and $CFG.admin.musics.artist_sub_category}
            <tr id="selSubCategoryBlock">
                <td class="{$myobj->getCSSFormLabelCellClass('music_artist_sub_category_id')}">
                <label for="music_artist_sub_category_id">{$LANG.signup_artist_music_sub_category}</label>
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('music_artist_sub_category_id')}">
                <div id="selSubCategoryBox">
                    <select name="music_artist_sub_category_id" id="music_artist_sub_category_id" tabindex="{smartyTabIndex}">
                        <option value="">{$LANG.common_select_option}</option>
                    </select>
                    {$myobj->getFormFieldErrorTip('music_artist_sub_category_id')}
                    {$myobj->ShowHelpTip('music_artist_sub_category_id')}
                </div>
               </td>
            </tr>
            {/if}
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
	{if $myobj->getFormField('agreement')== 1}
		{assign var=check value='checked'}
	{else}
		{assign var=check value= ''}
	{/if}
		<tr>
        	<td></td>
			<td class="{$myobj->getCSSFormFieldCellClass('agreement')}">
				{$myobj->getFormFieldErrorTip('agreement')}<input type="checkbox" class="clsCheckRadio" name="agreement" {$check} id="agreement" tabindex="{smartyTabIndex}" value="1" />
				<label for="agreement">{$myobj->form_signup.signup_agreement}</label>
			</td>
	    </tr>
	    <tr>
        	<td></td>
			<td class="{$myobj->getCSSFormFieldCellClass('submit')}"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="signup_submit" id="signup_submit" tabindex="{smartyTabIndex}" value="{$LANG.signup_submit}" /></div></div><input type="hidden" name="invitation_id" value="{$myobj->getFormField('invitation_id')}" />
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
							notEqualToField : 'username'
						}],
						['validate-password-confirm', '{/literal}{$LANG.common_err_tip_invalid_passwordmatch}{literal}', {
							equalToField : 'user_password',
							notEqualToField : 'username'
						}],
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