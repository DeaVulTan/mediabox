<div id="sellogoupload">
    <h2>
    	<span>
			{$LANG.page_title}
        </span>
    </h2>
    <div id="selLeftNavigation">
        <!-- information -->

        {$myobj->setTemplateFolder('admin/')} {include file='information.tpl'}
        {if $myobj->isShowPageBlock('logo_upload_form')}
            <div id="selUpload">
                <form name="logo_video_upload_form" id="logo_video_upload_form" method="post" action="videoLogo.php" autocomplete="off" enctype="multipart/form-data">
                    <div id="selUploadBlock">
                        <table class="clsNoBorder clsUploadBlock"summary="{$LANG.logoupload_tbl_summary}" id="selUploadTbl">
                            <tr>
                                <td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('logo_name')}">
                                    <label for="logo_name">
                                        {$LANG.logo_name}
                                    </label>
                                </td>
                                <td class="{$myobj->getCSSFormFieldCellClass('logo_name')}">
                                    {$myobj->getFormFieldErrorTip('logo_name')}
                                    <input type="text" class="clsTextBox" name="logo_name" id="logo_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('logo_name')}" />
                                </td>
                            </tr>
                            <tr>
                                <td class="{$myobj->getCSSFormLabelCellClass('logo_description')}">
                                    <label for="logo_description">{$LANG.logo_description}</label>
                                </td>
                                    <td class="{$myobj->getCSSFormFieldCellClass('logo_description')}">{$myobj->getFormFieldErrorTip('logo_description')}
                                        <textarea name="logo_description" id="logo_description" tabindex="{smartyTabIndex}">{$myobj->getFormField('logo_description')}</textarea>
                                    </td>
                            </tr>
                            <tr>
                                <td class="{$myobj->getCSSFormLabelCellClass('logo_url')}">
                                    <label for="logo_url">{$LANG.logo_url}</label>
                                </td>
                                <td class="{$myobj->getCSSFormFieldCellClass('logo_url')}">{$myobj->getFormFieldErrorTip('logo_url')}
                                    <input type="text" class="clsTextBox" name="logo_url" id="logo_url" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('logo_url')}" /><p>http://www.example.com</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="{$myobj->getCSSFormLabelCellClass('logo_position')}">
                                    <label for="logo_position">{$LANG.logo_position}</label>
                                </td>
                                <td class="{$myobj->getCSSFormFieldCellClass('logo_position')}">{$myobj->getFormFieldErrorTip('logo_position')}
                                    <select name="logo_position" id="logo_position" tabindex="{smartyTabIndex}">
                                   {$myobj->generalPopulateArray($myobj->logo_upload_form.logo_position_array, $myobj->getFormField('logo_position'))}
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="{$myobj->getCSSFormLabelCellClass('logo_transparency')}">
                                    <label for="logo_transparency">{$LANG.logo_transparency}</label>
                                </td>
                                <td class="{$myobj->getCSSFormFieldCellClass('logo_transparency')}">
                                	{$myobj->getFormFieldErrorTip('logo_transparency')}
                                    <input type="text" class="clsTextBox" name="logo_transparency" id="logo_transparency" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('logo_transparency')}" />&nbsp;({$LANG.recommended} 30)
                                </td>
                            </tr>
                            <tr>
                                <td class="{$myobj->getCSSFormLabelCellClass('logo_rollover_transparency')}">
                                    <label for="logo_rollover_transparency">{$LANG.logo_rollover_transparency}</label>
                                </td>
                                <td class="{$myobj->getCSSFormFieldCellClass('logo_rollover_transparency')}">{$myobj->getFormFieldErrorTip('logo_rollover_transparency')}
                                    <input type="text" class="clsTextBox" name="logo_rollover_transparency" id="logo_rollover_transparency" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('logo_rollover_transparency')}" />&nbsp;({$LANG.recommended} 80)
                                </td>
                            </tr>
                            <tr>
                                <td class="{$myobj->getCSSFormLabelCellClass('animated_logo')}">
                                    <label for="animated_logo1">{$LANG.animated_logo}</label>
                                </td>
                                <td class="{$myobj->getCSSFormFieldCellClass('animated_logo')}">
                                	{$myobj->getFormFieldErrorTip('animated_logo')}
                                    <input type="radio" class="clsCheckRadio" name="animated_logo" id="animated_logo1" tabindex="{smartyTabIndex}" value="yes" {$myobj->isCheckedRadio('animated_logo', 'yes')} />&nbsp;<label for="animated_logo1">{$LANG.yes}</label>
                                    <input type="radio" class="clsCheckRadio" name="animated_logo" id="animated_logo2" tabindex="{smartyTabIndex}" value="no" {$myobj->isCheckedRadio('animated_logo', 'no')} />&nbsp;<label for="animated_logo2">{$LANG.no}</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="{$myobj->getCSSFormLabelCellClass('video_logo_file')}">
                                    <label for="video_logo_file">{$LANG.logoupload_logo_file}&nbsp;[{$myobj->logo_upload_form.implode_logo_format_arr}]</label>
                                </td>
                                <td class="{$myobj->getCSSFormFieldCellClass('video_logo_file')}">{$myobj->getFormFieldErrorTip('video_logo_file')}
                                    <div id="selLeftPlainImage">
                                        <p id="selImageBorder"><span id="selPlainCenterImage">{$myobj->getLogoImage()}</span></p>
                                    </div>
                                    <input type="file" class="clsFileBox"  name="video_logo_file" id="video_logo_file" tabindex="{smartyTabIndex}" />
                                ({$CFG.admin.videos.logo_max_size}&nbsp;KB)
                                </td>
                            </tr>
                            <tr>
                                <td class="{$myobj->getCSSFormLabelCellClass('main_logo')}">
                                    <label for="main_logo1">{$LANG.main_logo}</label>
                                </td>
                                <td class="{$myobj->getCSSFormFieldCellClass('main_logo')}">
                                	{$myobj->getFormFieldErrorTip('main_logo')}
                                    <input type="radio" class="clsCheckRadio" name="main_logo" id="main_logo1" tabindex="{smartyTabIndex}" value="yes" {$myobj->isCheckedRadio('main_logo', 'yes')} />&nbsp;<label for="main_logo1">{$LANG.on}</label>
                                    <input type="radio" class="clsCheckRadio" name="main_logo" id="main_logo2" tabindex="{smartyTabIndex}" value="no" {$myobj->isCheckedRadio('main_logo', 'no')} />&nbsp;<label for="main_logo2">{$LANG.off}</label>
                               </td>
                            </tr>
                           {* <tr>
                                <td class="{$myobj->getCSSFormLabelCellClass('mini_logo_file')}">
                                    <label for="mini_logo_file">{$LANG.logoupload_mini_logo_file}</label>
                                </td>
                                <td class="{$myobj->getCSSFormFieldCellClass('mini_logo_file')}">
                                    {$myobj->getFormFieldErrorTip('mini_logo_file')}
                                    <div id="selLeftPlainImage">
                                        <p id="selImageBorder">
                                            <span id="selPlainCenterImage">
                                                {$myobj->getMiniLogoImage()}
                                            </span>
                                        </p>
                                    </div>
                                    <input type="file" class="clsFileBox" accept="image/{$myobj->logo_upload_form.implode_mini_logo_format_arr}" name="mini_logo_file" id="mini_logo_file" tabindex="{smartyTabIndex}" />
                                    ({$CFG.admin.videos.mini_logo_max_size}&nbsp;KB)
                                </td>
                            </tr>
                            <tr>
                                <td class="{$myobj->getCSSFormLabelCellClass('mini_logo')}">
                                <label for="mini_logo1">{$LANG.mini_logo}</label> </td>
                                <td class="{$myobj->getCSSFormFieldCellClass('mini_logo')}">
                                    {$myobj->getFormFieldErrorTip('mini_logo')}
                                    <input type="radio" class="clsCheckRadio" name="mini_logo" id="mini_logo1" tabindex="{smartyTabIndex}" value="1" {$myobj->isCheckedRadio('mini_logo', '1')} />&nbsp;<label for="mini_logo1">{$LANG.on}</label>
                                    <input type="radio" class="clsCheckRadio" name="mini_logo" id="mini_logo2" tabindex="{smartyTabIndex}" value="0" {$myobj->isCheckedRadio('mini_logo', '0')} />&nbsp;<label for="mini_logo2">{$LANG.off}</label>
                                </td>
                            </tr>*}
                            <tr>
                                <td colspan="2" class="clsFormFieldCellDefault">
                                    {$myobj->populateHidden($myobj->logo_upload_form.hidden_array)}
                                    <input type="submit" class="clsSubmitButton" name="upload" id="upload" tabindex="{smartyTabIndex}" value="{$LANG.upload}" />
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        {/if}
	</div>
</div>