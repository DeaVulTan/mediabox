{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selNotificationSettings">
	<div class="clsPageHeading"><h2>{$LANG.notificationSettings_title}</h2></div>
  		<div id="selLeftNavigation">
 		{$myobj->setTemplateFolder('general/')}
 		{include file='information.tpl'}
		{if $myobj->isShowPageBlock('block_notification_edit')}
			<div class="clsDataTable">
				<form name="form_editnotification" id="form_editnotification" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
                <p class="clsMandatoryText">{$LANG.notificationSettings_general_notes}</p>
			        <table summary="{$LANG.notificationSettings_tbl_summary}">
			        	{foreach key=pnkey item=pnvalue from=$myobj->block_notification_edit.populateNotification}
					   	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('password')}">
								<label>{$pnvalue.notification_text}</label>
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass($pnvalue.default_status_id)}">
								<input type="radio" name="{$pnvalue.default_status_id}" id="{$pnvalue.default_status_id}Yes" tabindex="{smartyTabIndex}" value="Yes" {$myobj->isCheckedRadio($pnvalue.default_status_id, 'Yes')} /> <label for="{$pnvalue.default_status_id}Yes">{$LANG.common_yes_option}</label>
								<input type="radio" name="{$pnvalue.default_status_id}" id="{$pnvalue.default_status_id}No" tabindex="{smartyTabIndex}" value="No" {$myobj->isCheckedRadio($pnvalue.default_status_id, 'No')} /> <label for="{$pnvalue.default_status_id}No">{$LANG.common_no_option}</label>
			                </td>
					   	</tr>
					   	{/foreach}

					   	<tr>
                    		<td></td>
                    		<td class="{$myobj->getCSSFormFieldCellClass('update_submit')}"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="update_submit" id="update_submit" tabindex="{smartyTabIndex}" value="{$LANG.common_update}" /></div></div></td>
               			</tr>
					</table>
				</form>
		   	</div>
		{/if}
</div>
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}