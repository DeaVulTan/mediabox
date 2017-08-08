<div id="selEditProfile">
	<h2>{$page_title}</h2>
	{$myobj->setTemplateFolder('admin/')}
{include file="information.tpl"}
	{ if $myobj->isShowPageBlock('block_form_editprofile')}
	<form name="form_editprofile" id="form_editprofile" method="post" action="{$myobj->getCurrentUrl()}">
		{$myobj->populateHidden($myobj->form_editprofile_hidden_arr)}
		    <!-- clsFormSection - starts here -->
    <table class="clsNoBorder">

		{if not $myobj->getFormField('user_id')}
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('user_name')}"><label for="user_name">{$LANG.editprofile_user_name}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('user_name')}">{$myobj->getFormFieldErrorTip('user_name')}<input type="text" class="clsTextBox" name="user_name" id="user_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('user_name')}" />
		  {$myobj->ShowHelpTip('username', 'user_name')}</td> </tr>
		   <tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('password')}"><label for="password">{$LANG.common_password}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('password')}">{$myobj->getFormFieldErrorTip('password')}<input type="text" class="clsTextBox" name="password" id="password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('password')}" />
		   {$myobj->ShowHelpTip('password')}</td></tr>
		{else}
			<tr>
				<td class="clsWidthSmall clsFormLabelCellDefault">{$LANG.editprofile_user_name}</td>
				<td class="clsFormFieldCellDefault">{$myobj->getFormField('user_name')}
			{$myobj->ShowHelpTip('username', 'user_name')}</td></tr>
			<tr>
				<td class="clsWidthSmall clsFormLabelCellDefault">{$LANG.common_password}</td>
				<td class="clsFormFieldCellDefault">{$myobj->getFormField('password')}
			{$myobj->ShowHelpTip('password')}</td></tr>
		{/if}
		   <tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('first_name')}"><label for="first_name">{$LANG.editprofile_first_name}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('first_name')}">{$myobj->getFormFieldErrorTip('first_name')}<input type="text" class="clsTextBox" name="first_name" id="first_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('first_name')}" />
		   {$myobj->ShowHelpTip('firstname', 'first_name')}</td></tr>
		   <tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('last_name')}"><label for="last_name">{$LANG.editprofile_last_name}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('last_name')}">{$myobj->getFormFieldErrorTip('last_name')}<input type="text" class="clsTextBox" name="last_name" id="last_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('last_name')}" />
		  {$myobj->ShowHelpTip('lastname', 'last_name')} </td></tr>
		   <tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('dob')}"><label for="dob">{$LANG.editprofile_dob}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('dob')}">{$myobj->getFormFieldErrorTip('dob')}
					<input type="text" class="clsTextBox" name="dob" id="dob" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('dob')}" readonly />
					<button class="clsSubmitButton" type="reset" id="f_trigger_b">...</button>
					{$myobj->populateCalendar('dob', 'f_trigger_b')}
		   {$myobj->ShowHelpTip('dob')}
				</td> </tr>
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('gender')}"><label for="gender_m">{$LANG.editprofile_gender}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('gender')}">{$myobj->getFormFieldErrorTip('gender')}
					<input type="radio" class="clsRadioButton" name="gender" id="gender_opt_m" tabindex="{smartyTabIndex}" value="m" {$myobj->isCheckedRadio('gender', 'm')} /><label for="gender_opt_m">{$LANG.common_male_option}</label>
					<input type="radio" class="clsRadioButton" name="gender" id="gender_opt_f" tabindex="{smartyTabIndex}" value="f" {$myobj->isCheckedRadio('gender', 'f')} /><label for="gender_opt_f">{$LANG.common_female_option}</label>
		    {$myobj->ShowHelpTip('gender')}
				</td></tr>
		   <tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('email')}"><label for="email">{$LANG.editprofile_email}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('email')}">{$myobj->getFormFieldErrorTip('email')}<input type="text" class="clsTextBox" name="email" id="email" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('email')}" />
		   {$myobj->ShowHelpTip('email')}</td></tr>
		   <tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('phone')}"><label for="phone">{$LANG.editprofile_phone}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('phone')}">{$myobj->getFormFieldErrorTip('phone')}<input type="text" class="clsTextBox" name="phone" id="phone" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('phone')}" />
		   {$myobj->ShowHelpTip('phone')}</td></tr>
		   <tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('fax')}"><label for="fax">{$LANG.editprofile_fax}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('fax')}">{$myobj->getFormFieldErrorTip('fax')}<input type="text" class="clsTextBox" name="fax" id="fax" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('fax')}" />
		   {$myobj->ShowHelpTip('fax')}</td></tr>
		   <tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('address')}"><label for="address">{$LANG.editprofile_address}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('address')}">{$myobj->getFormFieldErrorTip('address')}<input type="text" class="clsTextBox" name="address" id="address" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('address')}" />
		   {$myobj->ShowHelpTip('address')}</td></tr>
		   <tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('city')}"><label for="city">{$LANG.editprofile_city}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('city')}">{$myobj->getFormFieldErrorTip('city')}<input type="text" class="clsTextBox" name="city" id="city" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('city')}" />
		   {$myobj->ShowHelpTip('city')}</td></tr>
		   <tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('state')}"><label for="state">{$LANG.editprofile_state}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('state')}">{$myobj->getFormFieldErrorTip('state')}<input type="text" class="clsTextBox" name="state" id="state" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('state')}" />
		   {$myobj->ShowHelpTip('state')}</td></tr>
		   <tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('country')}"><label for="country">{$LANG.editprofile_country}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('country')}">{$myobj->getFormFieldErrorTip('country')}
					<select name="country" id="country_profile" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.common_select_option}</option>
						{$myobj->generalPopulateArray($CFG.lists_array.countries, $myobj->getFormField('country'))}
					</select>
		   	{$myobj->ShowHelpTip('country', 'country_profile')}
				</td></tr>
		{if ($myobj->getFormField('user_id')) &&  ($myobj->getFormField('usr_status') ne 'Ok')}
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('usr_status')}"><label for="usr_status">{$LANG.editprofile_usr_status}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('usr_status')}">{$myobj->getFormFieldErrorTip('usr_status')}
					<select name="usr_status" id="usr_status" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.common_select_option}</option>
						{$myobj->generalPopulateArray($status_arr, $myobj->getFormField('usr_status'))}
					</select>
		   {$myobj->ShowHelpTip('country')}
				</td>	</tr>
				<tr id="activate_user_block">
					<td class="clsWidthSmall clsFormLabelCellDefault">{$LANG.editprofile_activation_date}</td>
					<td class="clsFormFieldCellDefault">{$current_date}</td>
				</tr>
		{/if}
		  	<tr>
				<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('default')}">
				<input type="submit" class="clsSubmitButton" name="{$submit_button_name}" id="{$submit_button_name}" tabindex="{smartyTabIndex}" value="{$submit_button_value}" />
				<input type="submit" class="clsCancelButton" name="cancel" tabindex="{smartyTabIndex}" value="{$LANG.editprofile_cancel}" />
				</td>				
			</tr>
		</table>
    <!-- clsFormSection - ends here -->
	</form>
	{/if}	
</div>