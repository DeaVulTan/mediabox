{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selForgotPassword" class="clsForgotPassword">
	<div class="clsPageHeading"><h2>{$LANG.forgot_title}</h2></div>
	{include file='../general/information.tpl'}
    {if $myobj->isShowPageBlock('msg_form_error')}
        <div id="selMsgError">
            <form name="errorForm" id="errorForm" method="post" action="{$myobj->getUrl('forgotpassword')}" autocomplete="off">
                {$myobj->populateHidden($myobj->form_error.hidden_arr)}
                <input type="hidden" name="code" id="code" value="true" />
                <p>{$LANG.common_msg_error_sorry} {$myobj->getCommonErrorMsg()}</p>
            </form>
        </div>
    {/if}
	{if $myobj->isShowPageBlock('block_Forgotpassword')}
		<div class="clsPadding10">{$LANG.forgot_password_note}</div>
		<form name="form_Forgotpassword" id="form_Forgotpassword"  method="post" action="{$myobj->getCurrentUrl()}">
		<!-- clsFormSection - starts here -->
	    	<div class="clsDataTable">
				<table>
			    	<tr>
				    	<td class="{$myobj->getCSSFormLabelCellClass('email')}">{$myobj->displayMandatoryIcon('email')}<label for="email">{$LANG.forgot_email}</label></td>
	         	      	<td class="{$myobj->getCSSFormFieldCellClass('email')}">
						   	<input type="text" class="clsTextBox" name="email" id="email" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('email')}" />
	         	      		{$myobj->getFormFieldErrorTip('email')}
			     			{$myobj->ShowHelpTip('forgot_password_email','email')}
						</td>
				 	</tr>
				 	<tr>
		            	<td colspan="2">
					   		<div class="clsSubmitLeft">
								<div class="clsSubmitRight">
									<input type="submit" class="clsSubmitButton" name="forgot_submit" id="forgot_submit" tabindex="{smartyTabIndex}" value="{$LANG.forgot_submit}" />
								</div>
						 	</div>
				     	</td>
	             	</tr>
	            </table>
			</div>
	    <!-- clsFormSection - ends here -->
		</form>
	{/if}
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}