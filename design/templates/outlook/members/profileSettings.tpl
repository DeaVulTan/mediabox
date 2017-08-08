{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selEditAccountProfile">
	<div class="clsPageHeading"><h2>{$LANG.account_profile_title}</h2></div>
  	<div id="selLeftNavigation">
 		{$myobj->setTemplateFolder('general/')}
 		{include file='information.tpl'}
		{if $myobj->isShowPageBlock('form_edit_account_profile')}
			<div id="selPomptDialog" title="{$CFG.site.name}" style="display:none;">
				<form action="#">
					<label for="newStatus">{$LANG.account_profile_enter_new_status}</label>
					<input type="text" name="newStatus" id="newStatus" class="text ui-widget-content ui-corner-all" maxlength="20"/>
				</form>
			</div>

			<form name="selFormEditAccountProfile" id="selFormEditAccountProfile" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
				<div class="clsDataTable">
			        <table summary="{$LANG.account_profile_tbl_summary}" class="clsCheckBoxList">
						{if $show_languages}
						<tr>
			            	<td class="{$myobj->getCSSFormLabelCellClass('pref_lang')}">
			                	<label for="pref_lang">{$LANG.account_profile_default_language}</label>
			                </td>
			                <td class="{$myobj->getCSSFormFieldCellClass('current_password')}">
			                	<select name="pref_lang" id="pref_lang" tabindex="{smartyTabIndex}" >
					            	{html_options options=$myobj->getLanguage() selected=$myobj->getFormField('pref_lang')}
								</select>
			                </td>
			            </tr>
			            {/if}
			            {if $show_templates}
			            <tr>
							<td class="{$myobj->getCSSFormLabelCellClass('template')}">
								<label for="template1">{$LANG.account_profile_default_template}</label>
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('template')}">
								<select name="pref_template" id="pref_template" tabindex="{smartyTabIndex}">
								  {foreach key=template item=css_arr from=$template_arr}
									<optgroup label="{$template}">
										{foreach key=css_key item=css from=$css_arr}
											{assign var="smarty_current_template" value="`$template`__`$css`"}
											 <option value="{$smarty_current_template}" {if $myobj->getFormField('pref_template') eq $smarty_current_template}selected="selected"{/if}>{$css}</option>
										{/foreach}
									</optgroup>
								  {/foreach}
								</select>
								{$myobj->getFormFieldErrorTip('template')}
							</td>
					   </tr>
					   {/if}
						<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('privacy')}"><label for="privacyOnline">{$LANG.account_profile_status}</label></td>
							<td class="{$myobj->getCSSFormFieldCellClass('privacy')}">
								<div class="formRadioButtons">
									<p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="privacy" id="privacyOnline" value="Online" onclick="showCustomMsgSelectBox(this.value)" {$myobj->Online} tabindex="{smartyTabIndex}" /></span><label for="privacyOnline">&nbsp;&nbsp;{$LANG.account_profile_status_online}</label></p>
									<p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="privacy" id="privacyOffline"  value="Offline" onclick="showCustomMsgSelectBox(this.value)" {$myobj->Offline} tabindex="{smartyTabIndex}" /></span><label for="privacyOffline">&nbsp;&nbsp;{$LANG.account_profile_status_offline}</label></p>
									<p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="privacy" id="privacyCustom" value="Custom" onclick="showCustomMsgSelectBox(this.value)" {$myobj->Custom} tabindex="{smartyTabIndex}" /></span><label for="privacyCustom">&nbsp;&nbsp;{$LANG.account_profile_status_custom}</label></p>
										<p class="clsInputDetails" id="custom_msg_select" {if $myobj->getFormField('privacy')!='Custom'}style="display:none"{/if}><select name="custom_status" id="custom_status" onchange="addNewStatusMessage(this)">
											<option value="">{$LANG.account_profile_status_custom_select}</option>
			                                {if $myobj->populateStatus!=0}
			                                    {foreach  key=item item=value from=$myobj->populateStatus}
			                                    <option value="{$value.values}" {$value.selected}>{$value.optionvalue}</option>
			                                    {/foreach}
			                                {/if}
											<optgroup label="{$LANG.account_profile_status_new_optgroup}">
												<option value="add">{$LANG.account_profile_status_custom_add}</option>
											</optgroup>
										</select></p>
										{$myobj->getFormFieldErrorTip('privacy')}
										<input type="hidden" name="status_msg_id_old" id="status_msg_id_old" value="{$myobj->getFormField('status_msg_id_old')}" />
										<input type="hidden" name="new_status_hidden" id="new_status_hidden" />
								</div>
							</td>
					   	</tr>
			        	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('show_profile')}"><label>{$LANG.account_profile_show}</label></td>
							<td class="{$myobj->getCSSFormFieldCellClass('show_profile')}">
								<div class="formRadioButtons">
			                    {foreach  key=item item=value from=$myobj->populateShowProfile}
			                        <p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="{$value.field_name}" id="{$value.field_name_id}" {$value.checked} value="{$value.values}"  tabindex="{smartyTabIndex}" /></span><label for ="{$value.field_name_id}">&nbsp;&nbsp;{$value.desc}</label></p>
			                    {/foreach}
			                    </div>
			                    {$myobj->getFormFieldErrorTip('show_profile')}
			                    {$myobj->ShowHelpTip('show_profile')}
							</td>
					   	</tr>

						{if chkAllowedModule(array('photo'))}
					   		<tr>
								<td class="{$myobj->getCSSFormLabelCellClass('icon_use_last_uploaded')}"><label for="icon_use_last_uploaded">{$LANG.account_profile_icon}</label></td>
								<td class="{$myobj->getCSSFormFieldCellClass('icon_use_last_uploaded')}">
									<div class="formRadioButtons">
			                		{foreach  key=item item=value from=$myobj->populateProfileIcon}
			                    		<p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="{$value.field_name}" id="{$value.field_name_id}" {$value.checked} value="{$value.values}"  tabindex="{smartyTabIndex}" /></span><label for ="{$value.field_name_id}">&nbsp;&nbsp;{$value.desc}</label></p>
			                		{/foreach}
			                    	</div>
			                    	{$myobj->getFormFieldErrorTip('icon_use_last_uploaded')}
			                    	{$myobj->ShowHelpTip('icon_use_last_uploaded')}
								</td>
					   		</tr>
						{/if}{* end of chkAllowedModule of photo condition *}

					   	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('allow_comment')}"><label>{$LANG.account_profile_comments}</label></td>
							<td class="{$myobj->getCSSFormFieldCellClass('allow_comment')}">
								<div class="formRadioButtons">
			                    {foreach  key=item item=value from=$myobj->populateAllowComment}
			                        <p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="{$value.field_name}" id="{$value.field_name_id}" {$value.checked} value="{$value.values}"  tabindex="{smartyTabIndex}" /></span><label for ="{$value.field_name_id}">&nbsp;&nbsp;{$value.desc}</label></p>
			                    {/foreach}
			                    </div>
			                    {$myobj->getFormFieldErrorTip('allow_comment')}
			                    {$myobj->ShowHelpTip('allow_comment')}
							</td>
					   	</tr>

						{if chkAllowedModule(array('community', 'bulletin'))}
					   		<tr>
								<td class="{$myobj->getCSSFormLabelCellClass('allow_bulletin')}"><label for="allow_bulletin">{$LANG.account_profile_bulletins}</label></td>
									<td class="{$myobj->getCSSFormFieldCellClass('allow_bulletin')}">
										<div class="formRadioButtons">
					                    {foreach  key=item item=value from=$myobj->populateAllowBulletin}
					                        <p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="{$value.field_name}" id="{$value.field_name_id}" {$value.checked} value="{$value.values}"  tabindex="{smartyTabIndex}" /></span><label for ="{$value.field_name_id}">&nbsp;&nbsp;{$value.desc}</label></p>
					                    {/foreach}
					                    </div>
			                    		{$myobj->getFormFieldErrorTip('allow_bulletin')}
			                    		{$myobj->ShowHelpTip('allow_bulletin')}
									</td>
					   		</tr>
						{/if}{* end of chkAllowedModule of community,bulletin condition *}

						{if chkAllowedModule(array('content_filter'))}
						   	{if isAdultUser('settings')}
							   	<tr>
									<td class="{$myobj->getCSSFormLabelCellClass('content_filter')}"><label>{$LANG.account_profile_content_filter}</label></td>
									<td class="{$myobj->getCSSFormFieldCellClass('content_filter')}">
										<div class="formRadioButtons">
					                    {foreach  key=item item=value from=$myobj->populateContentFilter}
					                        <p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="{$value.field_name}" id="{$value.field_name_id}" {$value.checked} value="{$value.values}"  tabindex="{smartyTabIndex}" /></span><label for ="{$value.field_name_id}">&nbsp;&nbsp;{$value.desc}</label></p>
					                    {/foreach}
					                    </div>
					                    {$myobj->getFormFieldErrorTip('content_filter')}
					                    {$myobj->ShowHelpTip('content_filter')}
									</td>
							   	</tr>
				    	   	{else}
								{$myobj->populateHidden($myobj->populateHidden_arr)}

						    {/if}
						{/if}{* end of chkAllowedModule of content_filter condition *}

						{if $myobj->isFacebookUser()}
						   	<tr>
								<td class="{$myobj->getCSSFormLabelCellClass('facebook_image')}"><label for="facebook_image">{$LANG.account_profile_facebook_image}</label></td>
								<td class="{$myobj->getCSSFormFieldCellClass('facebook_image')}">
									<div class="formRadioButtons">
				                    {foreach  key=item item=value from=$myobj->updateFacebook}
				                        <p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" name="{$value.field_name}" id="{$value.field_name_id}" {$value.checked} value="{$value.values}"  tabindex="{smartyTabIndex}" /></span><label for ="{$value.field_name_id}">&nbsp;&nbsp;{$value.desc}</label></p>
				                    {/foreach}
				                    </div>
				                    {$myobj->getFormFieldErrorTip('facebook_image')}
				                    {$myobj->ShowHelpTip('facebook_image')}
								</td>
						   	</tr>
						{/if}
					   	<tr>
						   	<td></td>
							<td class="{$myobj->getCSSFormFieldCellClass('submit')}"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="account_submit" id="account_submit" tabindex="{smartyTabIndex}" value="{$LANG.account_profile_submit}" /></div></div></td>
			           	</tr>
					</table>
			    </div>
			</form>
		{/if}{* end of isShowPageBlock form_edit_account_profile condition*}
	</div>
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}