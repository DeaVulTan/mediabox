<div id="selGeneralConfiguration">
	<ul class="clsHeadingList">
    	<li class="clsActive"><a href="#"><span>{$LANG.logosetting_page_title}</span></a></li>
        <li><a href="{$myobj->faviconSettingUrl}" title="{$LANG.logosetting_favicon_link}"><span>{$LANG.logosetting_favicon_link}</span></a></li>
    </ul>
	<div id="selLeftNavigation">
		{include file='information.tpl'}
		{if  $myobj->isShowPageBlock('show_config_variable')}
			<h3>{$LANG.logosetting_upload_logo_image_note}</h3>
			<div id="selUpload">
				<form name="form_config" id="form_config" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off" enctype="multipart/form-data">
					<div id="selUploadBlock">
						<table class="clsCommonTable clsFormTbl" summary="" id="selUploadTbl" >
						  	<tr>
								<td class="clsFormLabelCellDefault clsWidth250">
									<label for="default_screen">{$LANG.logosetting_select_template}</label>{$myobj->displayCompulsoryIcon()}</td>
							  	<td>
							    	{assign var="smarty_default_template" value="`$CFG.html.template.temp_default`__`$CFG.html.stylesheet.screen.temp_default`"}
									<select name="default_screen" id="default_screen" tabindex="{smartyTabIndex}" onChange="populateLogoImage(this.value)">
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
								<td class="clsFormLabelCellDefault"><label for="site_logo">{$LANG.logosetting_upload_logo}</label>{$myobj->displayCompulsoryIcon()}</td>
								<td>
									<input type="file" class="clsFileBox" name="site_logo" id="site_logo" tabindex="{smartyTabIndex}"/>
                                    <div class="clsTdDatas">
                                        <p><strong>{$LANG.common_max_file_size}:</strong>&nbsp;{$CFG.admin.site.logo_image_max_size}&nbsp;{$LANG.common_file_size_in_KB}</p>
                                        <p><strong>{$LANG.common_allowed_file_formats}:</strong>&nbsp;{$myobj->changeArrayToCommaSeparator($CFG.admin.site.logo_image_format_arr)}</p>
                                        <p><strong>{$LANG.logosetting_logo_max_width}:&nbsp;</strong><span id="logoWidth"></span>px</p>
                                        <p><strong>{$LANG.logosetting_logo_max_height}:&nbsp;</strong><span id="logoHeight"></span>px</p>
                                        {$myobj->getFormFieldErrorTip('site_logo')}
                                    </div>
                                </td>
							</tr>
							<tr>
                        		<td>&nbsp;</td>
								<td class="clsButtonAlignment clsFormFieldCellDefault">
									<input type="submit" class="clsSubmitButton" name="edit_submit" id="edit_submit" tabindex="{smartyTabIndex}" value="{$LANG.logosetting_update}" />
                            	</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td id="logoImage" class="clsButtonAlignment clsFormFieldCellDefault"></td>
							</tr>
						</table>
					</div>
				</form>
			</div>
		{/if}
	</div>
</div>