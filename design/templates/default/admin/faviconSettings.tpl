<div id="selGeneralConfiguration">
    
	<ul class="clsHeadingList">
    	<li><a href="{$myobj->logoSettingUrl}" title="{$LANG.faviconsetting_logo_link}"><span>{$LANG.faviconsetting_logo_link}</span></a></li>
        <li class="clsActive"><a><span>{$LANG.faviconsetting_page_title}</span></a></li>
    </ul>
    
	<div id="selLeftNavigation">
		{include file='information.tpl'}
		{if  $myobj->isShowPageBlock('show_config_variable')}
			<div id="selUpload">
				<form name="form_config" id="form_config" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off" enctype="multipart/form-data">
					<div id="selUploadBlock">
						<table class="clsCommonTable clsFormTbl" summary="" id="selUploadTbl" >
						  	<tr>
								<td class="clsFormLabelCellDefault clsWidth250">
									<label for="default_screen">{$LANG.faviconsetting_select_template}</label>{$myobj->displayCompulsoryIcon()}</td>
							  	<td>
							    	{assign var="smarty_default_template" value="`$CFG.html.template.temp_default`__`$CFG.html.stylesheet.screen.temp_default`"}
									<select name="default_screen" id="default_screen" tabindex="{smartyTabIndex}" onChange="populateFaviconImage(this.value)">
										{foreach key=template item=css_arr from=$template_arr12}
				          					<optgroup label="{$template}">
												{foreach key=css_key item=css from=$css_arr}
													{assign var="smarty_current_template" value="`$template`__`$css`"}
				          							<option value="{$smarty_current_template}" {if $smarty_current_template == $smarty_default_template} selected{/if}>{$css}</option>
												{/foreach}
											</optgroup>
										{/foreach}
				        			</select><br/>
				        			{$myobj->getFormFieldErrorTip('default_screen')}
                                </td>
						 	</tr>
						 	<tr>
								<td class="clsFormLabelCellDefault"><label for="site_favicon">{$LANG.faviconsetting_upload_favicon}</label>{$myobj->displayCompulsoryIcon()}</td>
								<td>
									<input type="file" class="clsFileBox" name="site_favicon" id="site_favicon" tabindex="{smartyTabIndex}"/>
                                    <div class="clsTdDatas">
                                        <p><strong>{$LANG.common_allowed_file_formats}:</strong>&nbsp;{$myobj->changeArrayToCommaSeparator($CFG.admin.site.favicon_image_format_arr)}</p>
                                        <p><strong>{$LANG.faviconsetting_favicon_max_width}:&nbsp;</strong>{$CFG.admin.site.favicon_image_max_width}px</p>
                                        <p><strong>{$LANG.faviconsetting_favicon_max_height}:&nbsp;</strong>{$CFG.admin.site.favicon_image_max_height}px</p>
                                        {$myobj->getFormFieldErrorTip('site_favicon')}
                                    </div>
                                </td>
							</tr>
							<tr>
                        		<td>&nbsp;</td>
								<td class="clsButtonAlignment clsFormFieldCellDefault">
									<input type="submit" class="clsSubmitButton" name="edit_submit" id="edit_submit" tabindex="{smartyTabIndex}" value="{$LANG.faviconsetting_update}" />
                            	</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td id="faviconImage" class="clsButtonAlignment clsFormFieldCellDefault"></td>
							</tr>
								<tr>
								<td>&nbsp;</td>
								<td id="faviconImage" class="clsButtonAlignment clsFormFieldCellDefault"></td>
							</tr>
						</table>
					</div>
				</form>
			</div>
		{/if}
	</div>
</div>