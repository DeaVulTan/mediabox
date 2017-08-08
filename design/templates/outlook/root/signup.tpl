{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selSignUp">
	<div class="clsPageHeading"><h2>{$LANG.signup_title}</h2></div>

	{include file='../general/information.tpl'}
	{if $myobj->isShowPageBlock('memberadd_form_success')}
		<div id="selMsgSuccess" class="clsLineHeight22">
			<p>{$LANG.signup_memberadd_success}</p>
			<p class="clsMsgAdditionalText">{$LANG.signup_link_view_new_member}</p>
			<p class="clsMsgAdditionalText"><a href="{$myobj->getCurrentUrl(false)}">{$LANG.signup_link_add_member}</a></p>
		</div>
	{/if}
	{if $myobj->isShowPageBlock('activation_mail_details_block')}
		{if $resend_activation_message_step == 'step1' }
			<div id="selMsgSuccess" class="clsSignConfirmationMail">
			  <div class="clsSignUpSuccess">
	           	<p>{$LANG.signup_resend_code_message_mail_sent}</p>
				    {$myobj->getFormField('email')}
	        	<p>{$LANG.signup_resend_code_message_mail_verify}</p>
	        	<p>{$LANG.signup_resend_code_message_mail_change}</p>

	            <form name="errorForm" id="errorForm" method="post" action="{$myobj->getCurrentUrl(false)}">
	                <input type="text" name="new_email" id="new_email" value="{$myobj->getFormField('new_email')}" />
                    {$myobj->getFormFieldErrorTip('new_email')}
	                <input type="hidden" name="code" id="code" value="true" />
   	                <input type="hidden" name="email" value="{$myobj->getFormField('email')}" />
                    <input type="hidden" name="user_id" value="{$myobj->getFormField('user_id')}" />
                    <input type="hidden" name="user_name" value="{$myobj->getFormField('new_username')}" />
	                <p>{$resend_activation_link}</p>
	            </form>
	            <p class="clsBold">{$LANG.signup_resend_code_message_spam}</p>
              </div>
	         </div>
	     {/if}
		 {if $resend_activation_message_step == 'step2' }
		  	<div id="selMsgError" class="clsSignConfirmationMail">
				{$resend_activation_message}
				<p>{$LANG.signup_resend_code_message_mail_verify}</p>
				<p>{$LANG.signup_resend_code_message_spam}</p>
		  	</div>
         {/if}

    {/if}
	{if $myobj->isShowPageBlock('form_signup') }
		    <!-- clsFormSection - starts here -->
    <form name="form_signup" id="form_signup" class="" method="post" action="{$myobj->getCurrentUrl(false)}">

    {if !isAdmin()}
		{if $CFG.signup.captcha and $CFG.signup.captcha_method == 'honeypot'}
	    	{hpSolutionsRayzz}
	    {/if}
    {/if}

    <p class="ClsMandatoryText">{$LANG.common_mandatory_hint_1}<span class="clsMandatoryFieldIconInText">*</span>{$LANG.common_mandatory_hint_2}</p>
        <div class="ClsForm">
            <table summary="{$LANG.signup_tbl_summary}">
                <tr>
                    <td class="ClsSignUpLabel {$myobj->getCSSFormLabelCellClass('user_name')}">
                    	{$myobj->displayMandatoryIcon('user_name')}<label for="user_name">{$myobj->form_signup.signup_user_name}</label>
                    </td>
                    <td class="{$myobj->getCSSFormFieldCellClass('user_name')}">
                    {if $myobj->isShowPageBlock('form_edit_member')}
                    	{$myobj->getFormField('user_name')}
                    {else}
                        <input type="text" class="ClsTextBox" name="user_name" id="user_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('user_name')}" maxlength="{$CFG.fieldsize.username.max}"/>
                        {$myobj->getFormFieldErrorTip('user_name')}
                        {$myobj->ShowHelpTip('signup_username','user_name')}
                    {/if}
                    </td>
                </tr>
                <tr>
                	<td class="{$myobj->getCSSFormLabelCellClass('password')}">
						{if !$myobj->isShowPageBlock('form_edit_member')}
						{$myobj->displayMandatoryIcon('password')}
						{/if}
						<label for="password">{$myobj->form_signup.signup_password}</label>
					</td>
                    <td class="{$myobj->getCSSFormFieldCellClass('password')}">
                        <input type="password" class="ClsTextBox" name="password" id="password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('password')}" maxlength="{$CFG.fieldsize.password.max}"/>
                        {$myobj->getFormFieldErrorTip('password')}
                        {$myobj->ShowHelpTip('signup_password', 'password')}
                    </td>
                </tr>
                <tr>
                	<td class="{$myobj->getCSSFormLabelCellClass('confirm_password')}">
                        {if !$myobj->isShowPageBlock('form_edit_member')}
						{$myobj->displayMandatoryIcon('confirm_password')}
						{/if}
                        <label for="confirm_password">{$LANG.signup_confirm_password}</label>
                    </td>
               		<td class="{$myobj->getCSSFormFieldCellClass('confirm_password')}">
                        <input type="password" class="ClsTextBox" name="confirm_password" id="confirm_password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('confirm_password')}"  maxlength="{$CFG.fieldsize.password.max}"/>
                        {$myobj->getFormFieldErrorTip('confirm_password')}
                        {$myobj->ShowHelpTip('confirmpassword','confirm_password')}
                	</td>
                </tr>
                <tr>
                	<td class="{$myobj->getCSSFormLabelCellClass('email')}">
                        {$myobj->displayMandatoryIcon('email')}
                    	<label for="email">{$LANG.signup_email}</label>
                    </td>
                    <td class="{$myobj->getCSSFormFieldCellClass('email')}">
                        <input type="text" class="ClsTextBox" name="email" id="email" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('email')}" />
                        {$myobj->getFormFieldErrorTip('email')}
                        {$myobj->ShowHelpTip('signup_email','email')}
                    </td>
                </tr>
				{if isAdmin()}
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('usr_type')}">
						{$myobj->displayCompulsoryIcon()}
						<label for="usr_access">{$LANG.signup_personal_usr_type}</label>
					</td>
					<td class="{$myobj->getCSSFormFieldCellClass('usr_type')}">
						<select name="usr_type" id="usr_type" tabindex="{smartyTabIndex}">
							<option value="">{$LANG.signup_choose}</option>
							{$myobj->generalPopulateArray($myobj->user_types, $myobj->getFormField('usr_type'))}
						</select>
						{$myobj->getFormFieldErrorTip('usr_type')}
                        {$myobj->ShowHelpTip('usr_type')}
					</td>
				</tr>
				{/if}
                <tr>
                	<td class="{$myobj->getCSSFormLabelCellClass('first_name')}">
                    	{$myobj->displayMandatoryIcon('first_name')}
                    	<label for="first_name">{$LANG.signup_first_name}</label>
                    </td>
                	<td class="{$myobj->getCSSFormFieldCellClass('first_name')}">
                		<input type="text" class="ClsTextBox" name="first_name" id="first_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('first_name')}"  maxlength="{$CFG.fieldsize.first_name.max}"/>
                        {$myobj->getFormFieldErrorTip('first_name')}
                        {$myobj->ShowHelpTip('first_name')}
                	</td>
                </tr>
                <tr>
                	<td class="{$myobj->getCSSFormLabelCellClass('last_name')}">
                    	{$myobj->displayMandatoryIcon('last_name')}
                    	<label for="last_name">{$LANG.signup_last_name}</label>
                    </td>
                    <td class="{$myobj->getCSSFormFieldCellClass('last_name')}">
                        <input type="text" class="ClsTextBox" name="last_name" id="last_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('last_name')}"  maxlength="{$CFG.fieldsize.last_name.max}"/>
                        {$myobj->getFormFieldErrorTip('last_name')}
                        {$myobj->ShowHelpTip('last_name')}
                    </td>
                </tr>
                <tr>
                	<td class="{$myobj->getCSSFormLabelCellClass('sex')}">
                        {$myobj->displayMandatoryIcon('sex')}
                    	<label for="sex">{$LANG.signup_sex}</label>
                    </td>
                    <td class="{$myobj->getCSSFormFieldCellClass('sex')}">
                        {foreach key=ssokey item=ssovalue from=$myobj->form_signup.showSexOptionButtons}
                        	<input type="radio" class="ClsCheckRadio" id="sex_opt_{$ssovalue.value}" name="sex" {$ssovalue.checked} value="{$ssovalue.value}"  tabindex="{smartyTabIndex}" />&nbsp;<label for="sex_opt_{$ssovalue.value}">{$ssovalue.description}</label>&nbsp;&nbsp;
                        {/foreach}
                    </td>
                </tr>

                <tr>
                	<td class="{$myobj->getCSSFormLabelCellClass('dob')}">
                    	{$myobj->displayMandatoryIcon('dob')}
                    	<label for="dob">{$LANG.signup_dob}</label>
                    </td>
                    <td class="{$myobj->getCSSFormFieldCellClass('dob')}">
                        <input type="text" class="ClsTextBox" name="dob" id="dob" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('dob')}" />
                        {$myobj->populateDateCalendar('dob', $dob_calendar_opts_arr)}
                        {$myobj->getFormFieldErrorTip('dob', true)}
                        {$myobj->ShowHelpTip('dob')}
                    </td>
                </tr>
                <tr>
                	<td class="{$myobj->getCSSFormLabelCellClass('country')}">
                        {$myobj->displayMandatoryIcon('country')}
                    	<label for="country">{$LANG.signup_country}</label>
                    </td>
                    <td class="{$myobj->getCSSFormFieldCellClass('country')}">
                        <select name="country" id="country" tabindex="{smartyTabIndex}" class="validate-selection">
                        {$myobj->generalPopulateArray($smarty_country_list, $myobj->getFormField('country'))}
                        </select>
                        {$myobj->getFormFieldErrorTip('country')}
                        {$myobj->ShowHelpTip('country')}
                    </td>
                </tr>
                <tr>
                	<td class="{$myobj->getCSSFormLabelCellClass('postal_code')}">
                        {$myobj->displayMandatoryIcon('postal_code')}
                    	<label for="postal_code">{$LANG.signup_postal_code}</label>
                    </td>
                    <td class="{$myobj->getCSSFormFieldCellClass('postal_code')}">
                        <input type="text" class="ClsTextBox" name="postal_code" id="postal_code" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('postal_code')}" maxlength="9"/>
                        {$myobj->getFormFieldErrorTip('postal_code')}
                        {$myobj->ShowHelpTip('postal_code')}
                    </td>
                </tr>
            {if !isAdmin() && $CFG.signup.captcha}
                {if $CFG.signup.captcha_method == 'recaptcha' and $CFG.captcha.public_key and $CFG.captcha.private_key}
                    <tr>
                        <td class="{$myobj->getCSSFormLabelCellClass('captcha')}">
                            {$myobj->displayMandatoryIcon('country')}
                        	<label for="recaptcha_response_field">{$LANG.signup_captcha}</label>
                        </td>
                        <td class="clsOverwriteRecaptcha {$myobj->getCSSFormLabelCellClass('captcha')}">
                            {$myobj->recaptcha_get_html()}
                            {$myobj->getFormFieldErrorTip('recaptcha_response_field')}
                            {$myobj->ShowHelpTip('captcha', 'recaptcha_response_field')}
                        </td>
                    </tr>
                {elseif !isAdmin() && $CFG.signup.captcha_method == 'image'}
                    <tr>
                    	<td class="{$myobj->getCSSFormLabelCellClass('captcha')}">
                            {$myobj->displayMandatoryIcon('captcha')}
                        	<label for="captcha">{$LANG.signup_captcha}</label>
                        </td>
                    	<td class="{$myobj->getCSSFormFieldCellClass('captcha')}">
                    		<input type="text" class="ClsTextBox required" name="captcha" id="captcha" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('captcha')}" /><br/><img id="captchaImage" src="{$CFG.site.url}captchaSignup.php" alt="{$LANG.signup_captcha_alt}" title="{$LANG.signup_captcha_title}" />
                            <a href="javascript:void(0)" onClick="return changeCaptchaImage()">{$LANG.new_code}</a>
                            {$myobj->getFormFieldErrorTip('captcha')}
                            {$myobj->ShowHelpTip('captcha')}
                    	</td>
                    </tr>
                {/if}
            {/if}
            	{if !isAdmin()}
		            {if $myobj->getFormField('agreement')== 1}
		                {assign var=check value='checked="checked"'}
		            {else}
		                {assign var=check value= ''}
		            {/if}
                <tr>
                	<td></td>
                    <td class="{$myobj->getCSSFormFieldCellClass('agreement')}">
                        <input type="checkbox" class="ClsCheckRadio" name="agreement" {$check} id="agreement" tabindex="{smartyTabIndex}" value="1" />
                        <label for="agreement">{$myobj->form_signup.signup_agreement}</label>
                        {$myobj->getFormFieldErrorTip('agreement')}
                    </td>
                </tr>
            	{/if}
                <tr>
                <td></td>
                <td class="{$myobj->getCSSFormFieldCellClass('submit')}">
                    <div class="ClsSubmitLeft">
                        <div class="ClsSubmitRight">
                            {if $myobj->isShowPageBlock('form_edit_member')}
								<input type="submit" class="ClsSubmitButton" name="signup_update" id="signup_update" tabindex="{smartyTabIndex}" value="{$LANG.common_update}" />
								<input type="hidden" name="user_id" value="{$myobj->getFormField('user_id')}" />
							{else}
								<input type="submit" class="ClsSubmitButton" name="signup_submit" id="signup_submit" tabindex="{smartyTabIndex}" value="{$LANG.signup_submit}" />
							{/if}
                        </div>
                    </div>
                    <input type="hidden" name="invitation_id" value="{$myobj->getFormField('invitation_id')}" />
                </td>
                </tr>
            </table>
        </div>
    </form>
        {literal}

        {/literal}

{/if}
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
