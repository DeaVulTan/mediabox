<div id="searchSetting">
	<h2>{$LANG.settings_title}</h2>

    {$myobj->setTemplateFolder('admin/')}
	{include file="information.tpl"}
     <!-- confirmation box -->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
	</div>
    <!-- confirmation box-->
	{if !$CFG.admin.photos.watermark_apply}
    <div>{$LANG.watermark_image_note}</div>
	{/if}
    {if $myobj->isShowPageBlock('list_settings_block')}
    	<div style="padding:10px;">
			<div style="width:150px; float:left;"><label >{$LANG.watermark_image_label}</label></div>
			<div >
					<img src="{$imagePath}?t={$smarty.now}" />
					<a href="waterMarkSetting.php?block=edit"><b>{$LANG.watermark_edit}</b></a>
			</div>
		</div>
	{else}
		<div>{$LANG.watermark_no_image_label}</div>
    {/if}
	<div id="selWaterMArkImegeDiv" style="display:{$form_display}">
    <form name="selFormTemplate" id="selFormTemplate" action="waterMarkSetting.php" method="post" enctype="multipart/form-data">
        <table class="clsNoBorder">
        	<tr>
            	<td class="clsSmallWidth {$myobj->getCSSFormLabelCellClass('watermark_type')}"><label for="watermark_type">{$LANG.settings_select_type}</label></td>
                <td class="{$myobj->getCSSFormLabelCellClass('watermark_type')}">
                	<INPUT TYPE="radio" NAME="watermark_type" VALUE="image" onclick="return changeWaterMarkType(this.value);" {if $myobj->getFormField('watermark_type')=='image'} checked {/if}>{$LANG.settings_type_image}
                	<INPUT TYPE="radio" NAME="watermark_type" VALUE="font"  onclick="return changeWaterMarkType(this.value);" {if $myobj->getFormField('watermark_type')=='font'}  checked {/if}>{$LANG.settings_type_font}
                </td>
            </tr>

            <tr>
            	<td colspan="2">
            	{*if $myobj->isShowPageBlock('image_setting_block')*}
            	<div id="selImageMarker" style="display:block">
                	<table class="clsNoBorder">
                    	<tr>
                        	<td class="clsSmallWidth {$myobj->getCSSFormLabelCellClass('watermark_file')}">
                            	{$myobj->displayCompulsoryIcon()}<label for="watermark_file">{$LANG.settings_upload_watermark_file}</label><br />
                                ({$myobj->imageFormat}) &nbsp;{$CFG.admin.watermark.water_mark_max_size} KB
                            </td>
                        	<td class="{$myobj->getCSSFormLabelCellClass('watermark_file')}"><label for="watermark_file"><input type="file" accept="photo/{$myobj->photo_format}" name="photo_file" id="photo_file" tabindex="{smartyTabIndex}" />{$myobj->getFormFieldErrorTip('photo_file')}</label></td>
                    	</tr>
                	</table>
            	</div>
            	{*/if*}
            	{*if $myobj->isShowPageBlock('font_setting_block')*}
            	<div id="selFontMarker" style="display:none">
                	<table class="clsNoBorder">
                    	<tr>
                        	<td class="clsSmallWidth {$myobj->getCSSFormLabelCellClass('watermark_text')}">{$myobj->displayCompulsoryIcon()}<label for="watermark_text">{$LANG.settings_upload_watermark_text}</label></td>
                        	<td class="{$myobj->getCSSFormLabelCellClass('watermark_text')}">
                            	<input type="text" name="water_mark_text" id="water_mark_text" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('water_mark_text')}" />{$myobj->getFormFieldErrorTip('water_mark_text')}
                            </td>
                    	</tr>
                        <tr>
                        	<td class="clsSmallWidth {$myobj->getCSSFormLabelCellClass('back_ground_color')}">{$myobj->displayCompulsoryIcon()}<label for="back_ground_color">{$LANG.background_color}</label></td>
	                        <td>
                                <select name="back_ground_color" id="back_ground_color" tabindex="{smartyTabIndex}" class="validate-selection">
                                {$myobj->generalPopulateColorArray($smarty_color_list, $myobj->getFormField('back_ground_color'))}
                                </select>{$myobj->getFormFieldErrorTip('back_ground_color')}
                            </td>
                        </tr>
                        <tr>
                        	<td class="clsSmallWidth {$myobj->getCSSFormLabelCellClass('text_color')}">{$myobj->displayCompulsoryIcon()}<label for="text_color">{$LANG.text_color}</label></td>
	                        <td>
                                <select name="text_color" id="text_color" tabindex="{smartyTabIndex}" class="validate-selection">
                                {$myobj->generalPopulateColorArray($smarty_color_list, $myobj->getFormField('text_color'))}
                                </select>{$myobj->getFormFieldErrorTip('text_color')}
                            </td>
                        </tr>
                        <tr>
                        	<td class="clsSmallWidth {$myobj->getCSSFormLabelCellClass('text_size')}">{$myobj->displayCompulsoryIcon()}<label for="text_size">{$LANG.text_size}</label></td>
                            <td>
                            	<select name="text_size" id="text_size" tabindex="{smartyTabIndex}" class="validate-selection">
                                {$myobj->generalPopulateTextSizeArray($smarty_text_list, $myobj->getFormField('text_size'))}
                                </select>{$myobj->getFormFieldErrorTip('text_size')}
                            </td>
                        </tr>
                        <tr>
                        	<td class="clsSmallWidth {$myobj->getCSSFormLabelCellClass('water_mark_text_width')}">{$myobj->displayCompulsoryIcon()}<label for="water_mark_text_width">{$LANG.water_mark_text_width}</label></td>
                        	<td class="{$myobj->getCSSFormLabelCellClass('water_mark_text_width')}">
                            	<input type="text" name="water_mark_text_width" id="water_mark_text_width" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('water_mark_text_width')}" />{$myobj->getFormFieldErrorTip('water_mark_text_width')}
                            </td>
                    	</tr>
                    	<tr>
                        	<td class="clsSmallWidth {$myobj->getCSSFormLabelCellClass('water_mark_text_height')}">{$myobj->displayCompulsoryIcon()}<label for="water_mark_text_height">{$LANG.water_mark_text_height}</label></td>
                        	<td class="{$myobj->getCSSFormLabelCellClass('water_mark_text_height')}">
                            	<input type="text" name="water_mark_text_height" id="water_mark_text_height" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('water_mark_text_height')}" />{$myobj->getFormFieldErrorTip('water_mark_text_height')}
                            </td>
                    	</tr>
                        <tr>
                        	<td class="clsSmallWidth {$myobj->getCSSFormLabelCellClass('water_mark_text_xposition')}">{$myobj->displayCompulsoryIcon()}<label for="water_mark_text_xposition">{$LANG.water_mark_text_xposition}</label></td>
                        	<td class="{$myobj->getCSSFormLabelCellClass('water_mark_text_xposition')}">
                            	<input type="text" name="water_mark_text_xposition" id="water_mark_text_xposition" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('water_mark_text_xposition')}" />{$myobj->getFormFieldErrorTip('water_mark_text_xposition')}
                            </td>
                    	</tr>
                    	<tr>
                        	<td class="clsSmallWidth {$myobj->getCSSFormLabelCellClass('water_mark_text_yposition')}">{$myobj->displayCompulsoryIcon()}<label for="water_mark_text_yposition">{$LANG.water_mark_text_yposition}</label></td>
                        	<td class="{$myobj->getCSSFormLabelCellClass('water_mark_text_yposition')}">
                            	<input type="text" name="water_mark_text_yposition" id="water_mark_text_yposition" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('water_mark_text_yposition')}" />{$myobj->getFormFieldErrorTip('water_mark_text_yposition')}
                            </td>
                    	</tr>
                	</table>
            	</div>
            	{*/if*}
            	</td>
            </tr>
        	<tr>
            	<td></td>
            	<td>
                	<input type="submit" class="clsSubmitButton" name="update" id="update" tabindex="{smartyTabIndex}" value="{$LANG.common_update}" />
            	</td>
        	</tr>
        </table>
    </form>
	</div>
</div>