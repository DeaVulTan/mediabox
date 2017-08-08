<div id="selAddNewsLetter">
	<h2 class="clsNewsLetterTitle">{$LANG.addletter_title}</h2>
	{$myobj->setTemplateFolder('admin/')}
	{include file="information.tpl"}
	<!-- confirmation box -->
    <div id="selMsgConfirm" style="display:none;">
    	<h3 id="confirmMessage"></h3>
    	<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
    		<table class="clsFormSection clsNoBorder">
				<tr>
					<td>
						<input type="button" class="clsSubmitButton" name="submit_confirm" id="submit_confirm" tabindex="{smartyTabIndex}" value="{$LANG.addletter_yes}" onclick="submitform();" />&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.addletter_no}" onClick="return hideAllBlocks();" />
					</td>
				</tr>
			</table>
			<input type="hidden" name="action" id="action" />
		{$myobj->populateHidden($form_search_ad_hidden_arr)}
    	</form>
	</div>
	<!-- confirmation box -->

	{ if (not $myobj->isShowPageBlock('block_form_confirm')) && ($myobj->isShowPageBlock('block_form_add_letter'))}
	<form name="form_editBuySelltype" id="form_editBuySelltype" method="post" action="{$myobj->getCurrentUrl()}">
    	<table class="clsFormSection clsNoBorder">
		<tr>
			<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('default')}">
				<p>
                <strong>
                {$LANG.addletter_special_code_title}
                </strong>
				</p>
				{literal}
					<span>VAR_EMAIL</span>
					<span>VAR_USERNAME</span>
				{/literal}
				</ul>
			</td>
		</tr>
	    <tr class="clsFormRow">
	        	<td class="clsSmallWidth {$myobj->getCSSFormLabelCellClass('uname')}"><label for="uname">{$LANG.common_username}</label></td>
	        	<td class="{$myobj->getCSSFormFieldCellClass('uname')}">{$myobj->getFormFieldErrorTip('uname')}<input type="text" class="clsTextBox" name="uname" id="uname" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('uname')}" />
			{$myobj->ShowHelpTip('username', 'uname')}</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('fname')}"><label for="fname">{$LANG.addletter_search_first_name}</label></td>
		        <td class="{$myobj->getCSSFormFieldCellClass('fname')}">{$myobj->getFormFieldErrorTip('fname')}<input type="text" class="clsTextBox" name="fname" id="fname" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('fname')}" />
			{$myobj->ShowHelpTip('first_name', 'fname')}</td>
		</tr>
       		<tr>
		        <td class="{$myobj->getCSSFormLabelCellClass('lname')}"><label for="lname">{$LANG.addletter_search_last_name}</label></td>
		        <td class="{$myobj->getCSSFormFieldCellClass('lname')}">{$myobj->getFormFieldErrorTip('lname')}<input type="text" class="clsTextBox" name="lname" id="lname" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('lname')}" />
			{$myobj->ShowHelpTip('last_name', 'lname')}</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('email')}"><label for="email">{$LANG.addletter_search_email}</label></td>
		    	<td class="{$myobj->getCSSFormFieldCellClass('email')}">{$myobj->getFormFieldErrorTip('email')}<input type="text" class="clsTextBox" name="email" id="email" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('email')}" />
			{$myobj->ShowHelpTip('email', 'email')}</td>
        	</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('gender')}"><label for="gender">{$LANG.addletter_search_sex}</label></td>
			<td class="{$myobj->getCSSFormFieldCellClass('gender')}">{$myobj->getFormFieldErrorTip('gender')}
				<select name="gender" id="gender" tabindex="{smartyTabIndex}">
					<option value="">{$LANG.addletter_search_sex_option_both}</option>
					{$myobj->generalPopulateArray($gender_list_arr, $myobj->getFormField('gender'))}
				</select>
			{$myobj->ShowHelpTip('gender')}
			</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('doj_start')}"><label for="doj_start">{$LANG.addletter_search_doj}</label></td>
			<td class="{$myobj->getCSSFormFieldCellClass('doj_start')}">
					<label for="doj_start">{$LANG.addletter_search_results_label_doj_from}</label>
					{$myobj->getFormFieldErrorTip('doj_start')}
					<input type="text" class="clsTextBox clsDateSelectTextBox" name="doj_start" id="doj_start" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('doj_start')}" />
					{$myobj->populateDateCalendar('doj_start', $calendar_opts_arr)}

					<label for="doj_end">{$LANG.addletter_search_results_label_doj_to}</label>
					{$myobj->getFormFieldErrorTip('doj_end')}
					<input type="text" class="clsTextBox clsDateSelectTextBox" name="doj_end" id="doj_end" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('doj_end')}" />
					{$myobj->populateDateCalendar('doj_end', $calendar_opts_arr)}
			</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('dob_start')}"><label for="dob_start">{$LANG.addletter_search_dob}</label></td>
			<td class="{$myobj->getCSSFormFieldCellClass('dob_start')}">
					<label for="dob_start">{$LANG.addletter_search_results_label_dob_from}</label>
					{$myobj->getFormFieldErrorTip('dob_start')}
					<input type="text" class="clsTextBox clsDateSelectTextBox" name="dob_start" id="dob_start" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('dob_start')}" />
					{$myobj->populateDateCalendar('dob_start', $calendar_opts_arr)}

					<label for="dob_end">{$LANG.addletter_search_results_label_dob_to}</label>
					{$myobj->getFormFieldErrorTip('dob_end')}
					<input type="text" class="clsTextBox clsDateSelectTextBox" name="dob_end" id="dob_end" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('dob_end')}" />
					{$myobj->populateDateCalendar('dob_end', $calendar_opts_arr)}
			</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('login_start')}"><label for="login_start">{$LANG.addletter_search_results_label_last_logged}</label></td>
				<td  class="{$myobj->getCSSFormFieldCellClass('login_start')}">
					<label for="login_start"></label>
						{$myobj->getFormFieldErrorTip('login_start')}
						<input type="text" class="clsTextBox clsDateSelectTextBox" name="login_start" id="login_start" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('login_start')}" />
						{$myobj->populateDateCalendar('login_start', $calendar_opts_arr)}
			{$myobj->ShowHelpTip('last_login_date', 'login_start')}
				</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('user_status_Ok')}"><label for="user_status_Ok">{$LANG.addletter_search_results_label_status}</label></td>
		 		<td  class="{$myobj->getCSSFormFieldCellClass('user_status_Ok')}">
				 	<span><input type="checkbox" class="clsCheckBox" value="Ok" id="user_status_Ok" name="user_status_Ok"  {$myobj->isCheckedCheckBox('user_status_Ok')} tabindex="{smartyTabIndex}"/><label for="user_status_Ok">{$LANG.addletter_search_results_label_status_active}</label></span>
					<span><input type="checkbox" class="clsCheckBox" value="ToActivate" id="user_status_ToActivate" name="user_status_ToActivate" {$myobj->isCheckedCheckBox('user_status_ToActivate')} tabindex="{smartyTabIndex}"/><label for="user_status_ToActivate">{$LANG.addletter_search_results_label_status_in_active}</label></span>
					<span><input type="checkbox" class="clsCheckBox" value="Locked" id="user_status_Locked" name="user_status_Locked" {$myobj->isCheckedCheckBox('user_status_Locked')} tabindex="{smartyTabIndex}"/><label for="user_status_Locked">{$LANG.addletter_search_results_label_status_locked}</label></span>
			{$myobj->ShowHelpTip('user_status', 'user_status_Ok')}
		 		</td>
	        </tr>
            <tr>
			<td class="{$myobj->getCSSFormLabelCellClass('subject')}"><label for="subject">{$LANG.addletter_subject}</label>{$myobj->displayCompulsoryIcon()}</td>
			<td class="{$myobj->getCSSFormFieldCellClass('subject')}">{$myobj->getFormFieldErrorTip('subject')}<input type="text" class="clsTextBox" name="subject" id="subject" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('subject')|stripslashes}" />
			{$myobj->ShowHelpTip('news_letter_subject', 'subject')}</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('body')}"><label for="body">{$LANG.addletter_body}</label>{$myobj->displayCompulsoryIcon()}</td>
			<td class="{$myobj->getCSSFormFieldCellClass('body')}">{$myobj->getFormFieldErrorTip('body')}
					<textarea name="body" id="body" tabindex="{smartyTabIndex}">{$myobj->getFormField('body')|stripslashes}</textarea>
			{$myobj->ShowHelpTip('news_letter_body', 'body')}
			</td>
		</tr>
		<tr>
        <td></td>
		<td class="{$myobj->getCSSFormFieldCellClass('default')}">
					<a href="#" id="dAltMlti"></a>
					<input type="button" class="clsSubmitButton" name="addstock" id="addstock" tabindex="{smartyTabIndex}" value="{$LANG.addletter_add}" onClick="getAction();" />
		</td>
		</tr>
		</table>
		<input type="hidden" name="submit_confirm" id="submit_confirm"/>
	</form>
	{/if}
</div>