{ if $myobj->isShowPageBlock('block_list_advertisement')}
<div id="selMsgConfirmWindow" class="clsMsgConfirmWindow" style="display:none;">
  <h3 id="confirmation_msg"></h3>
  <form name="deleteForm" id="deleteForm" method="post" action="{$myobj->getCurrentUrl()}">
        <!-- clsFormSection - starts here -->

          <input type="submit" class="clsSubmitButton" name="delete_add" id="delete_add" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />&nbsp;
          <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" onClick="return hideAllBlocks();" />
          {$myobj->populateHidden($myobj->deleteForm_hidden_arr)}
    <!-- clsFormSection - ends here -->
  </form>
</div>
<div id="selMsgPreviewWindow" class="selMsgConfirmWindow" style="display:none;">
  <form name="previewForm" id="previewForm" method="post" action="{$myobj->getCurrentUrl()}">
  	    <p id="selPreviewBanner"></p>
  </form>
</div>
<div id="selCodeForm" class="clsPopupAlert" style="display:none;">
  <h2 id="codeTitle"></h2>
  <form name="codeForm" id="codeForm" method="post" action="{$myobj->getCurrentUrl()}">
        <!-- clsFormSection - starts here -->
    <table class="clsFormSection">

      <tr>
        <td>
          <textarea name="addCode" id="addCode" rows="2" cols="50"  onfocus="this.select()" onclick="this.select()" readonly></textarea>
        </td>
      </tr>
      <tr>
        <td>
          <p>{$LANG.manage_banner_code_instruction}</p>
        </td>
      </tr>
    </table>
    <!-- clsFormSection - ends here -->
  </form>
</div>
{/if}
<div id="selAdvertisement">
  <h2><span>{$LANG.manage_banner_title}</span></h2>
  {$myobj->setTemplateFolder('admin/')} {include file='information.tpl'}
  { if $myobj->isShowPageBlock('block_add_advertisement')}
  <h3>{$LANG.manage_banner_page_add_edit_title}</h3>
  <div id="selAddAdvertisementBlock">
    <form name="selAddAdvertisementForm" id="selAddAdvertisementForm" method="post" action="{$myobj->getCurrentUrl(false)}">
          <!-- clsFormSection - starts here -->
    <table class="clsFormSection clsNoBorder">
        <tr>
          <td class="{$myobj->getCSSFormLabelCellClass('block')} clsSmallWidth">
            <label for="block">{$LANG.manage_banner_label_block}</label>
            {$myobj->displayCompulsoryIcon()}
          </td>
          <td class="{$myobj->getCSSFormFieldCellClass('block')}"> {$myobj->getFormFieldErrorTip('block')}
            <input type="text" class="clsTextBox" name="block" id="block" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('block')}" />
            <p class="clsHelpBanner"><a href="javascript:void(0)" onclick="return popupWindow('{$CFG.site.url}bannerPosition.php', '580', '490')">{$LANG.manage_banner_banner_position}</a> &nbsp;<a href="javascript:void(0)" onclick="return popupWindow('{$CFG.site.url}admin/bannerDetails.php', '580', '400')">{$LANG.manage_banner_banner_details}</a></p>

        {$myobj->ShowHelpTip('banner_block', 'block')}
          </td></tr>
        <tr>
          <td class="{$myobj->getCSSFormLabelCellClass('source')}">
            <label for="source">{$LANG.manage_banner_label_source}</label>
            {$myobj->displayCompulsoryIcon()}
          </td>
          <td class="{$myobj->getCSSFormFieldCellClass('source')}"> {$myobj->getFormFieldErrorTip('source')}
            <textarea name="source" id="source" tabindex="{smartyTabIndex}">{$myobj->getFormField('source')}</textarea>
            <p><a href="javascript:void(0)" onclick="{$myobj->confrimation_preview_onclick}">{$LANG.manage_banner_preview}</a></p>
        {$myobj->ShowHelpTip('banner_html_source', 'source')}
          </td></tr>
        <tr>
          <td class="{$myobj->getCSSFormLabelCellClass('about')}">
            <label for="about">{$LANG.manage_banner_label_about}</label>
            {$myobj->displayCompulsoryIcon()}
          </td>
          <td class="{$myobj->getCSSFormFieldCellClass('about')}"> {$myobj->getFormFieldErrorTip('about')}
            <textarea name="about" id="about" tabindex="{smartyTabIndex}">{$myobj->getFormField('about')}</textarea>
       {$myobj->ShowHelpTip('banner_about_advertisement', 'about')}
          </td> </tr>
        {if $CFG.admin.banner.impressions_date}
        <tr>
          <td class="{$myobj->getCSSFormLabelCellClass('start_date')}">
            <label for="start_date">{$LANG.manage_banner_label_start_date}</label>
            {$myobj->displayCompulsoryIcon()}
          </td>
          <td class="{$myobj->getCSSFormFieldCellClass('start_date')}">{$myobj->getFormFieldErrorTip('start_date')}
            <input type="text" class="clsTextBox" name="start_date" id="start_date" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('start_date')}" />
            {$myobj->populateDateCalendar('start_date', $calendar_opts_arr)}
       		{$myobj->ShowHelpTip('banner_start_date', 'start_date')}  </td></tr>
        <tr>
          <td class="{$myobj->getCSSFormLabelCellClass('end_date')}">
            <label for="end_date">{$LANG.manage_banner_label_end_date}</label>
            {$myobj->displayCompulsoryIcon()}
          </td>
          <td class="{$myobj->getCSSFormFieldCellClass('end_date')}">{$myobj->getFormFieldErrorTip('end_date')}
            <input type="text" class="clsTextBox" name="end_date" id="end_date" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('end_date')}" />
			{$myobj->populateDateCalendar('end_date', $calendar_opts_arr)}
       {$myobj->ShowHelpTip('banner_end_date', 'end_date')}</td> </tr>
        <tr>
          <td class="{$myobj->getCSSFormLabelCellClass('allowed_impressions')}">
            <label for="allowed_impressions">{$LANG.manage_banner_label_allowed_impressions}</label>
          </td>
          <td class="{$myobj->getCSSFormFieldCellClass('allowed_impressions')}"> {$myobj->getFormFieldErrorTip('allowed_impressions')}
            <input type="text" class="clsTextBox" name="allowed_impressions" id="allowed_impressions" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('allowed_impressions')}" />
        {$myobj->ShowHelpTip('banner_allowed_impressions', 'allowed_impressions')}
          </td></tr>
        {/if}
        <tr>
          <td class="{$myobj->getCSSFormLabelCellClass('status')}">
            <label for="status_opt_1">{$LANG.manage_banner_label_status}</label>
          </td>
          <td class="{$myobj->getCSSFormFieldCellClass('status')}"> {$myobj->getFormFieldErrorTip('status')}
            <input type="radio" class="clsRadioButton" name="status" id="status_opt_1" tabindex="{smartyTabIndex}" value="activate"{$myobj->isCheckedRadio('status', 'activate')} />
            <label for="status_opt_1">{$LANG.manage_banner_status_activate}</label>
            <input type="radio" class="clsRadioButton" name="status" id="status_opt_2" tabindex="{smartyTabIndex}" value="toactivate"{$myobj->isCheckedRadio('status', 'toactivate')} />
            <label for="status_opt_2">{$LANG.manage_banner_status_toactivate}</label>
        {$myobj->ShowHelpTip('banner_status', 'status')}
          </td></tr>
        <tr>
          <td class="{$myobj->getCSSFormLabelCellClass('default')}">&nbsp;</td>
          <td class="{$myobj->getCSSFormFieldCellClass('default')}">
            { if $myobj->isShowPageBlock('block_edit_advertisement')}
            {$myobj->populateHidden($myobj->selAddAdvertisementForm_hidden_arr1)}
            <input type="submit" class="clsSubmitButton" name="update_submit" id="update_submit" tabindex="{smartyTabIndex}" value="{$LANG.manage_banner_update_submit}" />
            <input type="submit"  class="clsCancelButton" name="cancel_submit" id="cancel_submit" tabindex="{smartyTabIndex}" value="{$LANG.manage_banner_cancel_submit}" />
            {else}
            <input type="submit" class="clsSubmitButton" name="add_submit" id="add_submit" tabindex="{smartyTabIndex}" value="{$LANG.manage_banner_add_submit}" />
            {/if}
     {$myobj->populateHidden($myobj->selAddAdvertisementForm_hidden_arr)}</td> </tr>
        </table>
    <!-- clsFormSection - ends here -->
    </form>
  </div>
  {/if}
  { if $myobj->isShowPageBlock('block_search')}
  <div id="selSearchBlock">
   <h3>{$LANG.manage_banner_page_search_title}</h3>
  <form name="selSearchForm" id="selSearchForm" method="post" action="{$myobj->getCurrentUrl()}">
          <!-- clsFormSection - starts here -->
    <table class="clsFormSection clsNoBorder">

        <tr>
          <td class="{$myobj->getCSSFormLabelCellClass('user_name')} clsSmallWidth">
            <label for="user_name">{$LANG.manage_banner_label_user_name}</label>
          </td>
          <td class="{$myobj->getCSSFormFieldCellClass('user_name')}"> {$myobj->getFormFieldErrorTip('user_name')}
            <input type="text" class="clsTextBox" name="user_name" id="user_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('user_name')}" />
		  {$myobj->ShowHelpTip('banner_post_by', 'user_name')}
          </td>
		  </tr>
          <tr>
        <td class="{$myobj->getCSSFormLabelCellClass('block_search')}">
            <label for="block_search">{$LANG.manage_banner_label_block}</label>
          </td>
          <td class="{$myobj->getCSSFormFieldCellClass('block_search')}"> {$myobj->getFormFieldErrorTip('block_search')}
            <input type="text" class="clsTextBox" name="block_search" id="block_search" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('block_search')}" />
     {$myobj->ShowHelpTip('banner_block', 'block_search')}
          </td>
	 </tr>
	 <tr>     <td colspan="2" class="{$myobj->getCSSFormFieldCellClass('default')}">
            <input type="submit" class="clsSubmitButton" name="search_submit" id="search_submit" tabindex="{smartyTabIndex}" value="{$LANG.manage_banner_search_submit}" />
          </td>
        </tr>
      </table>

    <!-- clsFormSection - ends here -->
   </form>
  </div>
  {/if}
  { if $myobj->isShowPageBlock('block_list_advertisement')}
  <div>
      <div>
            <label for="template_name">{$LANG.manage_banner_template}</label>:
            <select name="template_name" id="template_name" onchange="tempalteNav()">
            	{foreach from=$CFG.html.template.allowed item=allowed_templates}
                  	<option value="{$allowed_templates}"{if $allowed_templates==$myobj->getFormField('template_name')} selected="selected"{/if}>{$allowed_templates}</option>
                  {/foreach}
            </select>
      </div>
    {if $CFG.admin.navigation.top}
      {$myobj->setTemplateFolder('admin/')} {include file='pagination.tpl'}
    {/if}
    <form name="selListAdvertisementForm" id="selListAdvertisementForm" method="post" action="{$myobj->getCurrentUrl()}">
          <!-- clsDataDisplaySection - starts here -->
    <div class="clsDataDisplaySection">
        <div class="clsDataHeadSection">
          <table>
            <tr>
			<th class="clsSelectColumn"><input type="checkbox" class="clsCheckBox" name="check_all" onclick= "CheckAll(document.selListAdvertisementForm.name, document.selListAdvertisementForm.check_all.name)" tabindex="{smartyTabIndex}" /></th>
            <th>{$LANG.manage_banner_th_banner_id}</th>
            <th>{$LANG.manage_banner_th_block}</th>
            <th class="clsBannerDescription">{$LANG.manage_banner_th_about}</th>
            {if $CFG.admin.banner.impressions_date}
            <th><p>{$LANG.manage_banner_allowed_impressions}</p><p>{$LANG.manage_banner_completed_impressions}</p></th>
            {/if}
            <th>{$LANG.manage_banner_th_added_by}</th>
            <th>{$LANG.manage_banner_th_status}</th>
             <th class="clsDateColumn">
			 	{if $CFG.admin.banner.impressions_date}
				 	<p>{$LANG.manage_banner_th_start_date}</p>
            		<p>{$LANG.manage_banner_th_end_date}</p>
            	{/if}
           		<p>{$LANG.manage_banner_th_date_added}</p>
			</th>
            <th>&nbsp;</th>
</tr>
			{foreach key=inc item=value from=$populateAdds_arr}
           <tr>
 			<td class="clsSelectColumn">
              <input type="checkbox" class="clsCheckBox" name="aid[]" value="{$populateAdds_arr.$inc.add_id}" tabindex="{smartyTabIndex}" onClick="disableHeading('selListAdvertisementForm');"/>
            </td>
            <td>{$populateAdds_arr.$inc.add_id}</td>
            <td>{$populateAdds_arr.$inc.block}</td>
            <td class="clsBannerDescription">{$populateAdds_arr.$inc.about}</td>
            {if $CFG.admin.banner.impressions_date}
            <td><p>{$populateAdds_arr.$inc.allowed_impressions}</p>
            <p>{$populateAdds_arr.$inc.completed_impressions}</p></td>
            {/if}
            <td><a href="{$populateAdds_arr.$inc.profile_link}">{$populateAdds_arr.$inc.name}</a></td>
            <td>{$populateAdds_arr.$inc.status}</td>
            <td class="clsDateColumn">
            	{if $CFG.admin.banner.impressions_date}
					<p>{$populateAdds_arr.$inc.start_date|date_format:#format_datetime#}</p>
		            <p>{$populateAdds_arr.$inc.end_date|date_format:#format_datetime#}</p>
	            {/if}
				<p>{$populateAdds_arr.$inc.date_added|date_format:#format_datetime#}</p>
			</td>
            <td> <a href="{$populateAdds_arr.$inc.edit_link}">{$LANG.manage_banner_edit}</a>
              <div class="clsPreviewBanner" id="selPreview{$populateAdds_arr.$inc.add_id}" style="display:none;">{$populateAdds_arr.$inc.source}</div>
              <a href="javascript:void(0)" onClick="{$populateAdds_arr.$inc.preview_onclick}">{$LANG.manage_banner_preview}</a> <a href="javascript:void(0)" onclick="return populateCode('{$populateAdds_arr.$inc.block}')">{$LANG.manage_banner_code}</a> </td>
</tr>
          {/foreach}
          <tr>
            <td colspan="9"><input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.manage_banner_add_delete}" onclick="{$delete_submit_onclick}" />
            <input type="button" class="clsSubmitButton" name="activate_submit" id="activate_submit" tabindex="{smartyTabIndex}" value="{$LANG.manage_banner_add_activate}" onclick="{$activate_submit_onclick}" />
            <input type="button" class="clsSubmitButton" name="toactivate_submit" id="toactivate_submit" tabindex="{smartyTabIndex}" value="{$LANG.manage_banner_add_toactivate}" onclick="{$inactivate_submit_onclick}" /></td>
          </tr>
        </table>
      </div>
	 </div>
        <!-- clsDataDisplaySection - ends here -->
    </form>
    {if $CFG.admin.navigation.bottom}
    {$myobj->setTemplateFolder('admin/')} {include file='pagination.tpl'}
    {/if} </div>
  {/if} </div>
{literal}
  <script type="text/javascript">
	function tempalteNav()
		{
			bannerUrl = {/literal}'{$CFG.site.url}admin/manageBanner.php';{literal}
			bannerUrl = bannerUrl+'?template_name='+document.getElementById('template_name').value;
			window.location = bannerUrl;
		}
  </script>
{/literal}
