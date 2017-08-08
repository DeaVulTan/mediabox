{if !isset($opt)}
	{if !isAjaxPage()}
		{$myobj->setTemplateFolder('general/')}
		{include file='box.tpl' opt='display_top'}
	{/if}
	<div id="selLogin">
		<div class="clsPageHeading"><h2>{$LANG.login_title}</h2></div>
	  	{include file='../general/information.tpl'}
	    {if $myobj->isShowPageBlock('form_error')}
	        <div id="selMsgError">
	            <form name="errorForm" id="errorForm" method="post" action="{$myobj->getUrl('login')}">
	                <input type="hidden" name="user_name" value="{$myobj->getFormField('user_name')}" />
	                <input type="hidden" name="code" id="code" value="true" />
	                <p>{$myobj->getCommonErrorMsg()}</p>
	            </form>
	        </div>
	    {/if}
 {else}
 	<div class="clsPopUpLogin">
	{$myobj->setTemplateFolder('general/')}
	{include file='box.tpl' opt='popuplogin_top'}
{/if}
  	{if $myobj->isShowPageBlock('form_login')}
  		<form name="selFormLogin" id="selFormLogin" method="post" action="{$myobj->getUrl('login')}">
			<input type="hidden" name="url" id="url" value="{$myobj->getFormField('url')}" />
			<div class="clsOverflow">
            <p class="clsMandatoryText">{$LANG.common_mandatory_hint_1}<span class="clsMandatoryFieldIconInText">*</span>{$LANG.common_mandatory_hint_2}</p>
            {if isset($opt)}
            	<div class="clsClosePopUpLogin" onclick="showLoginPopup()"><!--close--></div>
             {/if}
             </div>
             <div class="clsLoginFormTable">
            	<table class="clsTwoColumnTbl">
					<tr>
						<td class="{$myobj->getCSSFormLabelCellClass('user_name')}"><span class="clsMandatoryFieldIcon">{$LANG.common_mandatory_field_icon}</span><label for="user_name">{$myobj->form_login.login_field_label}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('user_name')}">
							{if !isset($opt)}
								<input type="text" class="clsTextBox" name="user_name" id="user_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('user_name')}" maxlength="{$CFG.fieldsize.username.max}" />
							{else}
								<input type="text" class="clsTextBox" name="user_name" id="user_name" tabindex="800" value="{$myobj->getFormField('user_name')}" maxlength="{$CFG.fieldsize.username.max}" />
							{/if}
							{$myobj->getFormFieldErrorTip('user_name')}
                    		{$myobj->ShowHelpTip($myobj->form_login.login_field, 'user_name')}
                    	</td>
			    	</tr>
					<tr>
						<td class="{$myobj->getCSSFormLabelCellClass('password')}"><span class="clsMandatoryFieldIcon">{$LANG.common_mandatory_field_icon}</span><label for="password">{$LANG.common_password}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('password')}">
							{if !isset($opt)}
								<input type="password" class="clsTextBox" name="password" id="password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('password')}" maxlength="{$CFG.fieldsize.password.max}" />
							{else}
								<input type="password" class="clsTextBox" name="password" id="password" tabindex="805" value="{$myobj->getFormField('password')}" maxlength="{$CFG.fieldsize.password.max}" />
							{/if}
							{$myobj->getFormFieldErrorTip('password')}
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
                 	{if !isset($opt)}
						<tr>
	                		<td></td>
							<td class="{$myobj->getCSSFormFieldCellClass('remember')}"><p><span class="clsCheckBox"><input type="checkbox" class="clsCheckRadio" name="remember" id="remember1" tabindex="{smartyTabIndex}" value="1"{$myobj->isCheckedCheckBox('remember')} /></span><label for="remember1">&nbsp;&nbsp;{$LANG.login_remember_login}</label></p></td>
				    	</tr>
				    	<tr>
	                		<td></td>
							<td class="{$myobj->getCSSFormFieldCellClass('submit')}"><div class="clsSubmitLeft"><div class="clsSubmitRight">
								{if isAjaxPage()}
									<input type="button" class="clsSubmitButton" name="login_submit" id="login_submit" onclick="return doAjaxLogin('selFormLogin')" tabindex="{smartyTabIndex}" value="{$LANG.login_submit}" />
								{else}
									<input type="submit" class="clsSubmitButton" name="login_submit" id="login_submit" tabindex="{smartyTabIndex}" value="{$LANG.login_submit}" />
								{/if}
							</div></div></td>
			   	  		</tr>
				    	<tr>
	                		<td></td>
							<td>
	                       		<div class="clsOverflow">
				                	<ul class="clsLoginLinks">
					                	{if $myobj->chkAllowedModule(array('forgotpassword'))}
					                    	<li class="clsForgotLink"><a href="{$myobj->getUrl('forgotpassword')}">{$LANG.login_forgotpassword}</a></li>
					                	{/if}
					                	{if $myobj->chkAllowedModule(array('signup'))}
					                    	<li class="clsNewUser"><a href="{$myobj->getUrl('signup')}">{$LANG.login_register}</a></li>
					                	{/if}
					                	{if $myobj->chkAllowedModule(array('external_login'))}
					                    	<li class="clsExternalLogin"><a href="{$myobj->getUrl('externallogin')}">{$LANG.login_externallogin}</a></li>
					                	{/if}
				            		</ul>
				            	</div>
	             			</td>
			   	  		</tr>
			   	  	{else}
						<tr>
							<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('remember')}"><p><span class="clsCheckBox"><input type="checkbox" class="clsCheckRadio" name="remember" id="remember1" tabindex="810" value="1"{$myobj->isCheckedCheckBox('remember')} /></span><label for="remember1">&nbsp;&nbsp;{$LANG.login_remember_login}</label></p></td>
				    	</tr>
				    	<tr>
							<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
                            <div class="clsLoginSubmitRight">
                                <div class="clsLoginSubmitLeft">
	                                <input type="submit" class="" name="login_submit" id="login_submit" tabindex="815" value="{$LANG.login_submit}" />
                                </div>
                            </div>
                            </td>
							<td>
	                       		<div class="clsOverflow">
				                	<ul class="clsLoginLinks">
					                	{if $myobj->chkAllowedModule(array('forgotpassword'))}
					                    	<li class="clsForgotLink"><a href="{$myobj->getUrl('forgotpassword')}">{$LANG.login_forgotpassword}</a></li>
					                	{/if}
				            		</ul>
				            	</div>
	             			</td>
			   	  		</tr>
			   	  	{/if}
				</table>
        	</div>
		</form>
	{/if}
{if !isset($opt)}
	</div>
	{if !isAjaxPage()}
		{$myobj->setTemplateFolder('general/')}
		{include file='box.tpl' opt='display_bottom'}
	{/if}
{else}
	{$myobj->setTemplateFolder('general/')}
	{include file='box.tpl' opt='popuplogin_bottom'}
	</div>
{/if}
{if $CFG.feature.jquery_validation}
	{literal}
		<script language="javascript" type="text/javascript">
			$Jq("#selFormLogin").validate({
				rules: {
					user_name: {
						required: true
				    },
				    password: {
				    	required: true
				    }
				},
				messages: {
					user_name: {
						required: LANG_JS_REQUIRED
					},
					password: {
						required: LANG_JS_REQUIRED
					}
				}
			});
		</script>
	{/literal}
{/if}