{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selEditPersonalProfile">
<div class="clsPageHeading"><h2>{$LANG.personal_title_basic}</h2></div>
	<div id="selLeftNavigation">
 		{$myobj->setTemplateFolder('general/')}
 		{include file='information.tpl'}
		{if $myobj->isShowPageBlock('form_editprofile')}
			<form name="selFormEditPersonalProfile" id="selFormEditPersonalProfile" enctype="multipart/form-data" method="post" action="{$myobj->getCurrentUrl()}">
            	<p class="ClsMandatoryText">{$LANG.common_mandatory_hint_1}<span class="clsMandatoryFieldIconInText">*</span>{$LANG.common_mandatory_hint_2}</p>
				<div class="clsDataTable">
		        <table summary="{$LANG.personal_profile_tbl_summary}" class="clsProfileEditTbl">
					<tr>
						<td class="{$myobj->getCSSFormLabelCellClass('email')}">{$myobj->displayMandatoryIcon('email')}<label for="email">{$LANG.personal_profile_email}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('email')}">
							<input type="text" class="clsTextBox" name="email" id="email" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('email')}" />
							{$myobj->getFormFieldErrorTip('email')}
		                	{$myobj->ShowHelpTip('update_email','email')}
						</td>
				   </tr>
				   <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('first_name')}">{$myobj->displayMandatoryIcon('first_name')}<label for="first_name">{$LANG.personal_profile_first_name}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('first_name')}">
							<input type="text" class="clsTextBox" name="first_name" id="first_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('first_name')}" />
							{$myobj->getFormFieldErrorTip('first_name')}
							{$myobj->ShowHelpTip('first_name')}
						</td>
				   </tr>
				   <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('last_name')}">{$myobj->displayMandatoryIcon('last_name')}<label for="last_name">{$LANG.personal_profile_last_name}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('last_name')}">
							<input type="text" class="clsTextBox" name="last_name" id="last_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('last_name')}" />
							{$myobj->getFormFieldErrorTip('last_name')}
							{$myobj->ShowHelpTip('last_name')}
						</td>
				   </tr>
				    <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('sex')}">{$myobj->displayMandatoryIcon('sex')}<label for="sex">{$LANG.personal_profile_sex}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('sex')}">
							<select name="sex" id="sex" tabindex="{smartyTabIndex}">
		                		{foreach  key=item item=svalue from=$myobj->populateGender}
		                			<option value="{$svalue.values}" {$svalue.selected}>{$svalue.optionvalue}&nbsp;</option>
		                		{/foreach}
		                	</select>
		                	{$myobj->getFormFieldErrorTip('sex')}
		                	{$myobj->ShowHelpTip('sex')}</td>
				    </tr>
				    <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('dob')}">{$myobj->displayMandatoryIcon('dob')}<label for="dob">{$LANG.personal_profile_dob}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('dob')}">
                        	<input type="text" class="ClsTextBox" name="dob" id="dob" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('dob')}" />
                        	{$myobj->populateDateCalendar('dob', $dob_calendar_opts_arr)}<br/>
                        	{$myobj->getFormFieldErrorTip('dob',true)}
                        	{$myobj->ShowHelpTip('dob')}
                        	<p><input name="show_dob_check" id="show_dob_check" tabindex="{smartyTabIndex}" type="checkbox" class="clsCheckRadio" value="1" {$myobj->dobChecked} onClick="chekc_show_dob()"/>&nbsp;<label for="show_dob_check">{$LANG.personal_profile_show_dob}</label></p>
		                    <input name="show_dob" id="show_dob" tabindex="{smartyTabIndex}" type="hidden" class="clsCheckRadio" value="{$myobj->show_dob_value}" />
                    	</td>
				    </tr>
				    <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('relation_status')}"><label for="relation_status">{$LANG.personal_profile_relation_status}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('relation_status')}">
							<select name="relation_status" id="relation_status" tabindex="{smartyTabIndex}">
								{foreach  key=item item=rvalue from=$myobj->populateUserRelation}
		                		<option value="{$rvalue.values}" {$rvalue.selected}>{$rvalue.optionvalue}&nbsp;</option>
		                        {/foreach}
							</select>
							{$myobj->getFormFieldErrorTip('relation_status')}
		                    {$myobj->ShowHelpTip('relation_status')}
						</td>
				    </tr>
				   <tr>
				   	<td class="{$myobj->getCSSFormLabelCellClass('about_me')}"><label for="about_me">{$LANG.personal_profile_about_me}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('about_me')}">
							<textarea name="about_me" id="about_me" rows="10" cols="50" class="selInputLimiter" maxlimit="{$CFG.fieldsize.aboutme}" tabindex="{smartyTabIndex}" >{$myobj->getFormField('about_me')}</textarea>
							{$myobj->getFormFieldErrorTip('about_me')}
		                	{$myobj->ShowHelpTip('about_me')}
		                </td>
				   </tr>
				   <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('web_url')}"><label for="web_url">{$LANG.personal_profile_web_url}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('web_url')}">
							<input type="text" class="clsTextBox" name="web_url" id="web_url" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('web_url')}" />
							{$myobj->getFormFieldErrorTip('web_url')}
		                	{$myobj->ShowHelpTip('web_url')}
		                </td>
				   </tr>
				   <tr>
				   		<td class="{$myobj->getCSSFormLabelCellClass('profile_tags')}"><label for="profile_tags">{$LANG.personal_profile_tags}</label></td>
                		<td class="{$myobj->getCSSFormFieldCellClass('profile_tags')} clsInputDetails">
							<p><input type="text" class="clsTextBox" name="profile_tags" id="profile_tags" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('profile_tags')}" /></p>
							{$myobj->getFormFieldErrorTip('profile_tags')}
							<p><span>{$LANG.personal_profile_tags_info_1}</span></p>
							<p><span>{$myobj->profile_tag_length_info}</span></p>
                    		{$myobj->ShowHelpTip('profile_tags')}
						</td>
		   		   </tr>
				   <tr>
				   		<th colspan="2"><h3>{$LANG.personal_profile_location_mode}</h3></th>
				   </tr>
				   <tr>
				   		<td class="{$myobj->getCSSFormLabelCellClass('hometown')}"><label for="hometown">{$LANG.personal_profile_hometown}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('hometown')}">
							<input type="text" class="clsTextBox" name="hometown" id="hometown" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('hometown')}"  maxlength="100"/>
							{$myobj->getFormFieldErrorTip('hometown')}
		                	{$myobj->ShowHelpTip('hometown')}
		                </td>
				   </tr>
				   <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('city')}"><label for="city">{$LANG.personal_profile_city}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('city')}">
							<input type="text" class="clsTextBox" name="city" id="city" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('city')}" maxlength="50"/>
							{$myobj->getFormFieldErrorTip('city')}
		                	{$myobj->ShowHelpTip('city')}
		                </td>
				   </tr>
				   <tr>
					<td class="{$myobj->getCSSFormLabelCellClass('postal_code')}">{$myobj->displayMandatoryIcon('postal_code')}<label for="postal_code">{$LANG.personal_profile_postal_code}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('postal_code')}">
							<input type="text" class="clsTextBox" name="postal_code" id="postal_code" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('postal_code')}" maxlength="9"/>
							{$myobj->getFormFieldErrorTip('postal_code')}
		                	{$myobj->ShowHelpTip('postal_code')}
		                </td>
				   </tr>
				   <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('country')}">{$myobj->displayMandatoryIcon('country')}<label for="country">{$LANG.personal_profile_country}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('country')}">
							<select name="country" id="country" tabindex="{smartyTabIndex}">{$myobj->populateCountriesList($myobj->getFormField('country'))}</select>
							{$myobj->getFormFieldErrorTip('country')}
		                	{$myobj->ShowHelpTip('country')}
		                </td>
				   </tr>
				   <tr>
				   		<td>&nbsp;</td>
		                <td class="{$myobj->getCSSFormFieldCellClass('submit')}"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="editprofile_submit" id="editprofile_submit" tabindex="{smartyTabIndex}" value="{$LANG.personal_profile_submit}" /></div></div></td>
					</tr>
				</table>
		    	</div>
			</form>
		{/if}{* end of isShowPageBlock('form_editprofile') *}
	</div>
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}