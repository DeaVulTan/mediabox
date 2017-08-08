<div id="seladvertisement">
	<h2><span>{$LANG.page_title}</span></h2>
	{if $myobj->getFormField('act')!='add'}
  		<p class="clsPageLink"><a href="videoAdvertisement.php?act=add">{$LANG.add_new_advertisement}</a></p>
	{/if}
    <div id="selLeftNavigation">

    {$myobj->setTemplateFolder('admin/')} {include file='information.tpl'}
  	{if $myobj->isShowPageBlock('advertisement_upload_form')}
    	<div id="selUpload">
            <form name="video_advertisement_upload_form" id="video_advertisement_upload_form" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off" enctype="multipart/form-data">
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
                                {$LANG.video_advertisement_ex_url}
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
                    {if $CFG.admin.video_advertisement_impressions}
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('month')}">
                            	<label for="month">{$LANG.advertisement_expiry_date}</label>
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('advertisement_expiry_date')}">
                                {$myobj->getFormFieldErrorTip('month')}
                                <!--<input type="text" class="clsTextBox" name="advertisement_expiry_date" id="advertisement_expiry_date" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('advertisement_expiry_date')}" />&nbsp;(YYYY-MM-DD HH:MM:SS)-->
                                <select name="month" id="month" tabindex="{smartyTabIndex}">
                                <option value="">{$LANG.select_month}</option>
                                {$myobj->populateBWNumbers(1,12,$myobj->getFormField('month'))}
                                </select>
                                <select name="day" id="day" tabindex="{smartyTabIndex}">
                                <option value="">{$LANG.select_day}</option>
                                {$myobj->populateBWNumbers(1,31,$myobj->getFormField('day'))}
                                </select>
                                <select name="year" id="year" tabindex="{smartyTabIndex}">
                                <option value="">{$LANG.select_year}</option>
                                {$myobj->populateBWNumbers($myobj->advertisement_upload_form.datem, $myobj->advertisement_upload_form.datep, $myobj->getFormField('year'))}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('advertisement_impressions')}">
                            	<label for="advertisement_impressions">{$LANG.advertisement_impressions}</label>
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('advertisement_impressions')}">
                                {$myobj->getFormFieldErrorTip('advertisement_impressions')}
                                <input type="text" class="clsTextBox" name="advertisement_impressions" id="advertisement_impressions" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('advertisement_impressions')}" />
                            </td>
                        </tr>
                    {/if}
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('advertisement_channel')}">
                            	<label for="advertisement_channel">{$LANG.advertisement_channel}</label>
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('advertisement_channel')}">
                                {$myobj->getFormFieldErrorTip('advertisement_channel')}
                                {$myobj->populateVideoCatagory()}
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
                            <td class="{$myobj->getCSSFormLabelCellClass('video_advertisement_file')}">
                            	<label for="video_advertisement_file">{$LANG.advertisement_file} </label> <span class="clsMandatoryFieldIcon">*</span>
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('video_advertisement_file')}">
                                {$myobj->getFormFieldErrorTip('video_advertisement_file')}
                                {if $myobj->chkIsEditMode()}
                                    <div id="selLeftPlainImage">
                                   		<p id="selImageBorder"><span id="selPlainCenterImage">{$myobj->getadvertisementImage()}</span></p>
                                    </div>
                                {/if}
                                <input type="file" class="clsFileBox" name="video_advertisement_file" id="video_advertisement_file" tabindex="{smartyTabIndex}" />
                                ({$CFG.admin.videos.advertisement_max_size}&nbsp;KB)
                            </td>
                        </tr>
                    {if chkAllowedModule(array('affiliate'))}
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('views_revenue')}">
                            	<label for="views_revenue">{$LANG.views_revenue}</label>
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('views_revenue')}">
                                {$myobj->getFormFieldErrorTip('views_revenue')}
                                {$CFG.admin.affiliate.currency}<input type="text" class="clsTextBox" name="views_revenue" id="views_revenue" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('views_revenue')}" />
                                </td>
                        </tr>
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('clicks_revenue')}">
                            	<label for="clicks_revenue">{$LANG.clicks_revenue}</label>
                        	</td>
                            <td class="{$myobj->getCSSFormFieldCellClass('clicks_revenue')}">
                                {$myobj->getFormFieldErrorTip('clicks_revenue')}
                                {$CFG.admin.affiliate.currency}<input type="text" class="clsTextBox" name="clicks_revenue" id="clicks_revenue" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('clicks_revenue')}" />
                            </td>
                        </tr>
                    {/if}
                    {if chkAllowedModule(array('content_filter'))}
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('add_type')}">
                            	<label for="add_type1">{$LANG.add_type}</label>
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('add_type')}">
                                {$myobj->getFormFieldErrorTip('add_type')}
                                <input type="radio" class="clsCheckRadio" name="add_type" id="add_type1" tabindex="{smartyTabIndex}" value="General"{$myobj->isCheckedRadio('add_type', 'General')} />
                                <label for="add_type1">{$LANG.add_type_general}</label>
                                <input type="radio" class="clsCheckRadio" name="add_type" id="add_type2" tabindex="{smartyTabIndex}" value="Porn"{$myobj->isCheckedRadio('add_type', 'Porn')} />
                                <label for="add_type2">{$LANG.add_type_porn}</label>
                            </td>
                        </tr>
                    {/if}
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

                        {$myobj->setTemplateFolder('admin/')} {include file='pagination.tpl'}
                    {/if}
                    <table summary="{$LANG.advertisement_tbl_summary}">
                        <tr>
                            <th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.listAddForm.name, document.listAddForm.check_all.name)" /></th>
                            <th class="{$myobj->getOrderCss('advertisement_id')}"><p>{$LANG.advertisement_id}</p></th>
                            <th class="{$myobj->getOrderCss('advertisement_name')}"><p>{$LANG.advertisement_name}</p></th>
                            <th class="{$myobj->getOrderCss('user_id')}"><p>{$LANG.advertisement_user}</p></th>
                            <th class="{$myobj->getOrderCss('advertisement_show_at')}"><p>{$LANG.advertisement_show_at}</p></th>
                            <th class="{$myobj->getOrderCss('advertisement_duration')}"><p>{$LANG.advertisement_duration}</p></th>
                        {if $CFG.admin.video_advertisement_impressions}
                            <th class="{$myobj->getOrderCss('advertisement_impressions')}"><p>{$LANG.advertisement_impressions}</p></th>
                            <th class="{$myobj->getOrderCss('advertisement_current_impressions')}"><p>{$LANG.advertisement_current_impressions}</p></th>
                            <th class="{$myobj->getOrderCss('advertisement_expiry_date')}"><p>{$LANG.advertisement_expiry_date}</p></th>
                        {/if}
                        {if chkAllowedModule(array('affiliate'))}
                            <th class="{$myobj->getOrderCss('views_revenue')}"><p>{$LANG.views_revenue}</p></th>
                            <th class="{$myobj->getOrderCss('clicks_revenue')}"><p>{$LANG.clicks_revenue}</p></th>
                            <th class="{$myobj->getOrderCss('site_earnings')}"><p>{$LANG.site_earnings}</p></th>
                            <th class="{$myobj->getOrderCss('members_earnings')}"><p>{$LANG.members_earnings}</p></th>
                        {/if}
                            <th class="{$myobj->getOrderCss('add_type')}"><p>{$LANG.add_type}</p></th>
                            <th class="{$myobj->getOrderCss('advertisement_status')}"><p>{$LANG.advertisement_status}</p></th>
                            <th>&nbsp;</th>
                        </tr>
                       {foreach key=palKey item=palValue from=$myobj->advertisement_list.populateAdvertisementList}
                        <tr>
                            <td>
                                <input type="checkbox" class="clsCheckRadio" name="aid[]"  value="{$palValue.record.advertisement_id}" tabindex="{smartyTabIndex}" onClick="disableHeading('listAddForm');"/>                            </td>
                            <td>{$palValue.record.advertisement_id}</td>
                            <td>
                                {$palValue.record.advertisement_name}                            </td>
                            <td>
                                {$myobj->getUserName($palValue.record.user_id)}                            </td>
                            <td>
                                {$palValue.record.advertisement_show_at}                            </td>
                            <td>
                                {$palValue.record.advertisement_duration}                            </td>
                        {if $CFG.admin.video_advertisement_impressions}
                            <td>
                                {$palValue.record.advertisement_impressions}                            </td>
                            <td>
                                {$palValue.record.advertisement_current_impressions}                            </td>
                            <td>
                                {$palValue.record.advertisement_expiry_date}                            </td>
                        {/if}
                        {if chkAllowedModule(array('affiliate'))}
                            <td>
                                {$CFG.admin.affiliate.currency.$palValue.record.views_revenue}                            </td>
                            <td>
                                {$CFG.admin.affiliate.currency.$palValue.record.clicks_revenue}                            </td>
                            <td>
                                {$CFG.admin.affiliate.currency.$palValue.record.site_earnings}                            </td>
                            <td>
                                {$CFG.admin.affiliate.currency.$palValue.record.members_earnings}                            </td>
                       {/if}
                            <td>
                                {$palValue.record.add_type}                            </td>
                            <td>
                                {$palValue.lang_status}                            </td>
                            <td>
                                <a href="videoAdvertisement.php?act=edit&amp;aid={ $palValue.record.advertisement_id}&amp;start={$myobj->getFormField('start')}">
                                    {$myobj->LANG.edit}                                </a>                            </td>
                        </tr>
                       {/foreach}
                        <tr>
                            <td class="{$myobj->getCSSFormFieldCellClass('privacy_status')}" colspan="16">
                                {$myobj->populateHidden($myobj->advertisement_list.populateHidden)}
                                <a href="#" id="{$myobj->advertisement_list.anchor}"></a>
                                <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.delete}" onClick="{$myobj->advertisement_list.onClick_Delete}" />
                                <input type="button" class="clsSubmitButton" name="activate_submit" id="activate_submit" tabindex="{smartyTabIndex}" value="{$LANG.activate}" onClick="{$myobj->advertisement_list.onClick_Activate}" />
                                <input type="button" class="clsSubmitButton" name="inactivate_submit" id="inactivate_submit" tabindex="{smartyTabIndex}" value="{$LANG.inactivate}" onClick="{$myobj->advertisement_list.onClick_Inactivate}" />                            </td>
                        </tr>
                    </table>
                  {if $CFG.admin.navigation.bottom}
                        {$myobj->setTemplateFolder('admin/')} {include file='pagination.tpl'}
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