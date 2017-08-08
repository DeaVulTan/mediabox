{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selReportBugs"  class="clsCommonContent clsReportbugsMain">
	{include file='box.tpl' opt='page_top'}
	<div class="clsPageHeading"><h2>{$LANG.reportbugs_title}</h2></div>
   		<div class="clsCommonInsideContent">
  			{include file='../general/information.tpl'}
  			{if $myobj->isShowPageBlock('block_reportbugs')}
            <div class="clsDataTable">
  				<form name="form_reportbugs_show" id="form_reportbugs_show" method="post" action="{$myobj->getCurrentUrl()}">
                <p class="clsMandatoryText">{$LANG.common_mandatory_hint_1}<span class="clsMandatoryFieldIconInText">*</span>{$LANG.common_mandatory_hint_2}</p>
        		<!-- clsFormSection - starts here -->
    			<div class="clsReportBugs">
	  	  			<table>
	      				<tr class="clsFormRow">
	        				<td class="{$myobj->getCSSFormLabelCellClass('username')}">
	          					{include file='../general/box.tpl' opt='compulsory_empty'}<label for="username">{$LANG.reportbugs_username}</label>
	        				</td>
	        				<td class="{$myobj->getCSSFormFieldCellClass('username')}">
	          					<input type="text" class="clsTextBox" name="username" id="username" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('username')}" />
	          					{$myobj->getFormFieldErrorTip('username')}
	        				</td>
	        			</tr>
		  				<tr class="clsFormRow">
	        				<td class="{$myobj->getCSSFormLabelCellClass('useremail')}">
	          					{include file='../general/box.tpl' opt='compulsory_empty'}<label for="useremail">{$LANG.reportbugs_user_email}</label>
	        				</td>
	        				<td class="{$myobj->getCSSFormFieldCellClass('useremail')}">
	          					<input type="text" class="clsTextBox" name="useremail" id="useremail" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('useremail')}" />
	          					{$myobj->getFormFieldErrorTip('useremail')}
	        				</td>
	        			</tr>
	      				<tr class="clsFormRow">
	        				<td class="{$myobj->getCSSFormLabelCellClass('subject')}">
	          					{include file='../general/box.tpl' opt='compulsory_empty'}<label for="subject">{$LANG.reportbugs_subject}</label>
	        				</td>
	        				<td class="{$myobj->getCSSFormFieldCellClass('subject')}">
	          					<select name="subject" id="subject" tabindex="{smartyTabIndex}">
	          						<option value="">{$LANG.reportbugs_select_option}</option>
			  						{$myobj->generalPopulateArray($LANG_LIST_ARR.bug_category, $myobj->getFormField('subject'))}
			  					</select>
			  					{$myobj->getFormFieldErrorTip('subject')}
	        				</td>
	        			</tr>
	      				<tr class="clsFormRow">
	        				<td class="{$myobj->getCSSFormLabelCellClass('message')}">
	        					{$myobj->displayCompulsoryIcon()}
	          					<label for="message">{$LANG.reportbugs_message}</label>
	        				</td>
	        				<td class="{$myobj->getCSSFormFieldCellClass('message')}">
	          					<textarea name="message" id="message" tabindex="{smartyTabIndex}" rows="4" cols="45" class="selInputLimiter" maxlimit="{$CFG.fieldsize.reportus.description}" >{$myobj->getFormField('message')}</textarea>
	          					{$myobj->getFormFieldErrorTip('message')}
	        				</td>
	       				</tr>
	       				{if $CFG.reportbugs.captcha}
	  						{if $CFG.reportbugs.reportbugs_captcha_method =='recaptcha' and $CFG.captcha.public_key and $CFG.captcha.private_key}
	    						<tr>
									<td class="{$myobj->getCSSFormLabelCellClass('captcha')}">
										<label for="recaptcha_response_field">{$LANG.reportbugs_captcha}</label>
									</td>
									<td class="clsOverwriteRecaptcha {$myobj->getCSSFormLabelCellClass('captcha')}">
										{$myobj->recaptcha_get_html()}
										{$myobj->getFormFieldErrorTip('recaptcha_response_field')}
                						{$myobj->ShowHelpTip('captcha', 'recaptcha_response_field')}
									</td>
	    						</tr>
     						{/if}
 						{/if}
	      				<tr>
	        				<td class="clsButtonAlignment {$myobj->getCSSFormFieldCellClass('default')}"></td>
	        				<td>
								 <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="submit_reportbugs" id="submit_reportbugs" value="{$LANG.reportbugs_submit}" tabindex="{smartyTabIndex}" /></div></div>
	          				</td>
	      				</tr>
	    			</table>
    			</div>
    			<!-- clsFormSection - ends here -->
  			</form>
            </div>
  		{/if}
	</div>
{include file='box.tpl' opt='page_bottom'}
</div>

{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}