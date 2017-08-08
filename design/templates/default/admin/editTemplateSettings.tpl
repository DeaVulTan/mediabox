<div id="selGeneralConfiguration">
	<h2 class="clsEditApiConfigTitle">{$LANG.page_title}</h2>
	<div id="selLeftNavigation">
		{$myobj->setTemplateFolder('admin/')}
	{include file="information.tpl"}
		{if  $myobj->isShowPageBlock('show_config_variable')}
			<div id="selUpload">
				<form name="form_config" id="form_config" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off" enctype="multipart/form-data">
					<div id="selUploadBlock">
						<table class="clsCommonTable clsFormTbl" summary="" id="selUploadTbl" >
							<tr>
								<td class="clsFormLabelCellDefault">
									<label for="logo_name">{$LANG.template_change}</label> </td>
								<td>
									<input type="radio" class="clsCheckRadio" name="is_template_change" id="is_template_change" tabindex="{smartyTabIndex}" value="1" {$myobj->isCheckedRadio('is_template_change', "1")} />&nbsp;<label for="animated_logo1">{$LANG.common_yes_option}</label>
          							<input type="radio" class="clsCheckRadio" name="is_template_change" id="is_template_change" tabindex="{smartyTabIndex}" value="0" {$myobj->isCheckedRadio('is_template_change', "0")} />&nbsp;<label for="animated_logo2">{$LANG.common_no_option}</label>
								</td>
							</tr>
						  	<tr>
								<td class="clsFormLabelCellDefault">
									<label for="default_screen">{$LANG.template_default}</label> </td>
							  	<td>
							    	{assign var="smarty_default_template" value="`$CFG.html.template.temp_default`__`$CFG.html.stylesheet.screen.temp_default`"}
									<select name="default_screen" id="default_screen" tabindex="{smartyTabIndex}">
										{foreach key=template item=css_arr from=$template_arr12}
				          					<optgroup label="{$template}">
												{foreach key=css_key item=css from=$css_arr}
													{assign var="smarty_current_template" value="`$template`__`$css`"}
				          							<option value="{$smarty_current_template}" {if $smarty_current_template == $smarty_default_template} selected{/if}>{$css}</option>
												{/foreach}
											</optgroup>
										{/foreach}
				        			</select>
                                </td>
						 	</tr>
						 	<tr>
								<td class="clsFormLabelCellDefault">
									<label for="logo_url">{$LANG.template_allowed}</label> </td>
								<td>
     								<table class="clsFormTable clsTemplateSettingTa">
     									<tr>
	                                    	<th>{$LANG.template_templates}</th>
	                                        <th>{$LANG.template_css}</th>
                                        </tr>
                                        {foreach key=keyvalue item=tempvalue from=$total_details}
                                    		<tr>
                                            	<td>
                                                	<input type="checkbox" name="temp_arr[]" id="temp_arr[]" value="{$tempvalue}" {$myobj->isCheckedCheckBoxArray('temp_arr', $tempvalue)} />{$tempvalue}
                                                </td>
                                                <td>
                                                	{assign var="css_arr" value=$myobj->populateCssDetails($tempvalue)}
                                                  	{foreach key=cssvalue item=cvalue from=$css_arr}
                                                       	{assign var="smarty_current_screen" value="`$tempvalue`__`$cvalue`"}
														<input type="checkbox" name="css_arr[]" id="css_arr[]" value="{$smarty_current_screen}" {$myobj->isCheckedCheckBoxArray('css_arr', $smarty_current_screen)} />{$cvalue|replace:'.css':''}
                                                       	<br/>
                                                  	{/foreach}
                                                </td>
                                            </tr>
                                        {/foreach}
                                   	</table>
                                </td>
							</tr>
							<tr>
                        		<td></td>
								<td class="clsButtonAlignment clsFormFieldCellDefault">
									<input type="submit" class="clsSubmitButton" name="edit_submit" id="edit_submit" tabindex="{smartyTabIndex}" value="{$LANG.common_update}" />
									<input type="reset" class="clsCancelButton" name="reset" id="reset" tabindex="{smartyTabIndex}" value="{$LANG.reset}" />
                            	</td>
							</tr>
						</table>
					</div>
				</form>
			</div>
		{/if}
	</div>
</div>