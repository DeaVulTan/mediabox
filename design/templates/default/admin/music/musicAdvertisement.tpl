<div id="seladvertisement">
	<h2><span>{$LANG.page_title}</span></h2>
	{if $myobj->getFormField('act')!='add'}
  		<p class="clsPageLink"><a href="musicAdvertisement.php?act=add">{$LANG.add_new_advertisement}</a></p>
	{/if}
    <div id="selLeftNavigation">
    {$myobj->setTemplateFolder('admin')}
    {include file='information.tpl'}
  	{if $myobj->isShowPageBlock('advertisement_upload_form')}
    	<div id="selUpload">
            <form name="advertisement_upload_form" id="advertisement_upload_form" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off" enctype="multipart/form-data">
                <div id="selUploadBlock">
                    <table summary="{$LANG.advertisement_tbl_summary}" id="selUploadTbl" class=" clsNoBorder clsUploadBlock">
                        <tr>
                            <td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('advertisement_name')}">
                            	<label for="advertisement_name">{$LANG.advertisement_name}</label>
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('advertisement_name')}">
                            	{$myobj->getFormFieldErrorTip('advertisement_name')}
                           		<input type="text" class="clsTextBox" name="advertisement_name" id="advertisement_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('advertisement_name')}" />
                            </td>
                        </tr>
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('advertisement_description')}">
                            	<label for="advertisement_description">{$LANG.advertisement_description}</label>
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('advertisement_description')}">
                            	{$myobj->getFormFieldErrorTip('advertisement_description')}
                            	<textarea name="advertisement_description" id="advertisement_description" tabindex="{smartyTabIndex}">{$myobj->getFormField('advertisement_description')}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('advertisement_url')}">
                            	<label for="advertisement_url">{$LANG.advertisement_url}</label>
                                {$LANG.music_advertisement_ex_url}
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('advertisement_url')}">
                            	{$myobj->getFormFieldErrorTip('advertisement_url')}
                           		<input type="text" class="clsTextBox" name="advertisement_url" id="advertisement_url" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('advertisement_url')}" />
                            </td>
                        </tr>
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('advertisement_duration')}">
                            	<label for="advertisement_duration">{$LANG.advertisement_duration}</label>
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('advertisement_duration')}">
                                {$myobj->getFormFieldErrorTip('advertisement_duration')}
                                <input type="text" class="clsTextBox" name="advertisement_duration" id="advertisement_duration" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('advertisement_duration')}" />&nbsp;{$LANG.seconds}
                            </td>
                        </tr>
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('advertisement_channel')}">
                            	<label for="advertisement_channel">{$LANG.advertisement_channel}</label>
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('advertisement_channel')}">
                                {$myobj->getFormFieldErrorTip('advertisement_channel')}
                                {$myobj->populateMusicCatagory()}
                            </td>
                        </tr>
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('advertisement_show_at')}">
                           		<label for="advertisement_show_at">{$LANG.advertisement_show_at}</label>
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('advertisement_show_at')}">
                                {$myobj->getFormFieldErrorTip('advertisement_show_at')}
                                <input type="radio" class="clsCheckRadio" name="advertisement_show_at" id="advertisement_show_at1" tabindex="{smartyTabIndex}" value="Begining" {$myobj->isCheckedRadio('advertisement_show_at', 'Begining')} />&nbsp;<label for="advertisement_show_at1">{$LANG.begining}</label>
                                <input type="radio" class="clsCheckRadio" name="advertisement_show_at" id="advertisement_show_at2" tabindex="{smartyTabIndex}" value="Ending" {$myobj->isCheckedRadio('advertisement_show_at', 'Ending')} />&nbsp;<label for="advertisement_show_at2">{$LANG.ending}</label>
                                <input type="radio" class="clsCheckRadio" name="advertisement_show_at" id="advertisement_show_at3" tabindex="{smartyTabIndex}" value="Both" {$myobj->isCheckedRadio('advertisement_show_at', 'Both')} />&nbsp;<label for="advertisement_show_at3">{$LANG.both}</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('advertisement_audio_file')}">
                            	<label for="advertisement_file">{$LANG.advertisement_audio_file} ({$audio_format})</label>
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('advertisement_audio_file')}">
                                {$myobj->getFormFieldErrorTip('advertisement_audio_file')}
                                {if $myobj->chkIsEditMode() && $myobj->getFormField('advertisement_audio_ext') != '' }
                                    <div id="selLeftPlainImage">
                                   		<p id="selImageBorder"><span id="selPlainCenterImage">{$myobj->getadvertisementAudioImage()}</span><span><input type="checkbox" class="clsCheckRadio" name="remove_audio" id="remove_audio" tabindex="{smartyTabIndex}" value="1" {$myobj->isCheckedRadio('remove_audio', '1')} />&nbsp;<label for="remove_audio">{$LANG.remove_audio}</label></span></p>
                                    </div>
                                {/if}
                                <input type="file" class="clsFileBox" accept="audio/basic" name="advertisement_audio_file" id="advertisement_audio_file" tabindex="{smartyTabIndex}" />
                                ({$CFG.admin.musics.advertisement_audio_max_size}&nbsp;MB)
                            </td>
                        </tr>
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('advertisement_file')}">
                            	<label for="advertisement_file">{$LANG.advertisement_file} ({$image_format})</label>
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('advertisement_file')}">
                                {$myobj->getFormFieldErrorTip('advertisement_file')}
                                {if $myobj->chkIsEditMode() && $myobj->getFormField('advertisement_image_ext') != '' }
                                    <div id="selLeftPlainImage">
                                   		<p id="selImageBorder"><span id="selPlainCenterImage">{$myobj->getadvertisementImage()}</span><span><input type="checkbox" class="clsCheckRadio" name="remove_image" id="remove_image" tabindex="{smartyTabIndex}" value="1" {$myobj->isCheckedRadio('remove_image', '1')} />&nbsp;<label for="remove_image">{$LANG.remove_image}</label></span></p>
                                    </div>
                                {/if}
                                <input type="file" class="clsFileBox" accept="image/{$myobj->advertisement_upload_form.implode_advertisement_format_arr}" name="advertisement_file" id="advertisement_file" tabindex="{smartyTabIndex}" />
                                ({$CFG.admin.musics.advertisement_max_size}&nbsp;KB)
                            </td>
                        </tr>
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('advertisement_status')}">
                            	<label for="advertisement_status">{$LANG.advertisement_status}</label>
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('advertisement_status')}">{$myobj->getFormFieldErrorTip('advertisement_status')}
                                <select name="advertisement_status" id="advertisement_status" tabindex="{smartyTabIndex}">
                                {$myobj->generalPopulateArray($myobj->advertisement_upload_form.advertisement_status_array, $myobj->getFormField('advertisement_status'))}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="clsFormFieldCellDefault">
                            {if $myobj->chkIsEditMode()}
                          		{$myobj->populateHidden($myobj->advertisement_upload_form.populateHidden)}
                            	<input type="submit" class="clsSubmitButton" name="update" id="update" tabindex="{smartyTabIndex}" value="{$LANG.update}" />
                            {else}
                            	<input type="submit" class="clsSubmitButton" name="add" id="add" tabindex="{smartyTabIndex}" value="{$LANG.add}" />
                            {/if}
                            	<input type="submit" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.cancel}" />
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
    </div>
    {/if}
    {if $myobj->isShowPageBlock('advertisement_list')}
    	{if $myobj->isResultsFound()}
            <div id="selMsgConfirm" class="clsMsgConfirm" style="display:none;">
                <p id="selMsgText"></p>
                <form name="actionForm" id="actionForm" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off">

                                <input type="submit" class="clsSubmitButton" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
                                <input type="button" class="clsSubmitButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks();" />
                                <input type="hidden" name="aid" id="aid" />
                                <input type="hidden" name="act" id="act" />
                                {*$myobj->populateHidden($myobj->advertisement_upload_form.populateHidden)*}

                </form>
            </div>
            <div id="advertisementListBlock">
                <form name="listAddForm" id="listAddForm" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off">
                    {if $CFG.admin.navigation.top}
                        {$myobj->setTemplateFolder('admin')}
                        {include file='pagination.tpl'}
                    {/if}
                    <table summary="{$LANG.advertisement_tbl_summary}">
                        <tr>
                            <th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.listAddForm.name, document.listAddForm.check_all.name)" /></th>
                            <th class="{$myobj->getOrderCss('advertisement_name')}"><p>{$LANG.advertisement_name}</p></th>
                            <th class="{$myobj->getOrderCss('user_id')}"><p>{$LANG.advertisement_user}</p></th>
                            <th class="{$myobj->getOrderCss('advertisement_show_at')}"><p>{$LANG.advertisement_show_at}</p></th>
                            <th class="{$myobj->getOrderCss('advertisement_duration')}"><p>{$LANG.advertisement_duration}</p></th>
                            <th class="{$myobj->getOrderCss('advertisement_status')}"><p>{$LANG.advertisement_status}</p></th>
                            <th>&nbsp;</th>
                        </tr>
                       {foreach key=palKey item=palValue from=$myobj->advertisement_list.populateAdvertisementList}
                        <tr>
                            <td>
                                <input type="checkbox" class="clsCheckRadio" name="aid[]"  value="{$palValue.record.advertisement_id}" tabindex="{smartyTabIndex}" onClick="disableHeading('listAddForm');"/>
                            </td>
                            <td>
                                {$palValue.record.advertisement_name}
                            </td>
                            <td>
                                {$myobj->getUserName($palValue.record.user_id)}
                            </td>
                            <td>
                                {$palValue.record.advertisement_show_at}
                            </td>
                            <td>
                                {$palValue.record.advertisement_duration}
                            </td>
                            <td>
                                {$palValue.record.advertisement_status}
                            </td>
                            <td>
                                <a href="musicAdvertisement.php?act=edit&amp;aid={ $palValue.record.advertisement_id}&amp;start={$myobj->getFormField('start')}">
                                    {$myobj->LANG.edit}
                                </a>
                            </td>
                        </tr>
                       {/foreach}
                        <tr>
                            <td class="{$myobj->getCSSFormFieldCellClass('privacy_status')}" colspan="15">
                                {$myobj->populateHidden($myobj->advertisement_list.populateHidden)}
                                <a href="#" id="{$myobj->advertisement_list.anchor}"></a>
                                <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.delete}" onClick="{$myobj->advertisement_list.onClick_Delete}" />
                                <input type="button" class="clsSubmitButton" name="activate_submit" id="activate_submit" tabindex="{smartyTabIndex}" value="{$LANG.activate}" onClick="{$myobj->advertisement_list.onClick_Activate}" />
                                <input type="button" class="clsSubmitButton" name="inactivate_submit" id="inactivate_submit" tabindex="{smartyTabIndex}" value="{$LANG.inactivate}" onClick="{$myobj->advertisement_list.onClick_Inactivate}" />
                            </td>
                        </tr>
                    </table>
                    {if $CFG.admin.navigation.bottom}
                        {include file='pagination.tpl'}
                    {/if}
                   </form>
                  </div>
            {else}
                <div id="selMsgAlert">
                    <p>{$LANG.no_records_found}</p>
                </div>
			{/if}
      {/if}
  </div>
</div>