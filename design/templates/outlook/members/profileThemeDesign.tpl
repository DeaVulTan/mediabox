{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selCustomizeProfile">
	<div class="clsPageHeading"><h2>{$LANG.profile_theme_title}</h2></div>
	<div id="selLeftNavigation">
	{$myobj->setTemplateFolder('general/')}
	{include file='information.tpl'}
		{if $myobj->isShowPageBlock('block_msg_form_success')}
			<p class="clsMsgAdditionalText"><a href="{$myobj->getUrl('myprofile')}">{$LANG.profile_theme_link_view_profile}</a></p>
		{/if}
	{if $myobj->isShowPageBlock('form_add_layout')}	
	<form name="formAddLayout" id="formAddLayout" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
		<div class="clsDataTable">
			<table summary="{$LANG.profile_theme_tbl_summary}" class="clsProfileEditTbl">
			<tr>
				<td class="clsFormLabelCellDefault"><label for="layout">{$LANG.profile_theme_layout_code}</label></td>
				<td class="clsFormFieldCellDefault">
				   <textarea class="clsEmbedTextArea" id="layout" name="layout" rows="10" cols="60" tabindex="{smartyTabIndex}">{$myobj->getFormField('layout')}</textarea>
				</td>
			</tr>
			<tr>
				<td><!-- --></td>
				<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
				{$myobj->populateHidden($myobj->poulatehidden_arr)}
					<div class="clsSubmitLeft">
						<div class="clsSubmitRight">
							<input type="button" class="clsSubmitButton" name="layout_submit_preview" id="layout_submit_preview" tabindex="{smartyTabIndex}" value="{$LANG.profile_theme_layout_submit}" onClick="return popupWindow('{$myobj->MemberProfileUrl}')" />
						</div>
					</div>
					
					<div class="clsCancelMargin">
						<div class="clsSubmitLeft">
						  <div class="clsSubmitRight">
						    <input type="submit" class="clsSubmitButton" name="save_layout" id="save_layout" value="{$LANG.customize_preview_submit_save_layout}" />
						  </div>
					    </div>
					</div>
					
					<div class="clsCancelMargin clsSubmitLeft clsMarginBottom10">
						<div class="clsSubmitRight">
							<input class="clsSubmitButton" type="button" name="preview_css" id="preview_css" value="{$LANG.profile_preview_css_style}" onclick="window.open('{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/css/{$CFG.html.stylesheet.screen.default}/profile.css','','menubar=yes,width:50,height:50,scrollbars=yes')"/>
						</div>
					</div>
					
					<div class="clsCancelMargin">
					  	<div class="clsSubmitLeft">
							<div class="clsSubmitRight">
								<input class="clsSubmitButton" type="submit" name="reset_layout" id="reset_layout" value="{$LANG.profile_theme_reset}" />
							</div>
						</div>
					</div>
				
					<div class="clsCancelMargin">
					 	<div class="clsCancelLeft">
							<div class="clsCancelRight">
								<a id="cancel_layout" onclick="Redirect2URL('{$myobj->getUrl('myprofile')}')">{$LANG.customize_preview_submit_return}</a>
							</div>
						</div>
					</div>
				</td>
			</tr>
			</table>
		</div>
	</form>
	{/if}	
  </div>
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}