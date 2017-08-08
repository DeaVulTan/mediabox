<div id="selNotificationSettings">
	<div>
  		<h2>{$LANG.notificationSettings_title}</h2>
		{$myobj->setTemplateFolder('admin/')}
		{include file="information.tpl"}
		{if $myobj->isShowPageBlock('block_notification_edit')}
			<div class="clsDataTable">
				<form name="form_editnotification" id="form_editnotification" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
			        <table summary="{$LANG.notificationSettings_tbl_summary}">
			        	<tr>
			        		<th>{$LANG.notificationSettings_notification}</th>
			        		<th>{$LANG.notificationSettings_module}</th>
			        		<th>{$LANG.notificationSettings_default_status}</th>
			        		<th>{$LANG.notificationSettings_changeable_by_user}</th>
			        	</tr>
			        	{foreach key=pnkey item=pnvalue from=$myobj->block_notification_edit.populateNotification}
					   	<tr>
							<td>{$pnvalue.notification_text}</td>
							<td>{$pnvalue.module_text}</td>
							<td class="{$myobj->getCSSFormFieldCellClass($pnvalue.default_status_id)}">
								<input type="radio" name="{$pnvalue.default_status_id}" id="{$pnvalue.default_status_id}Yes" tabindex="{smartyTabIndex}" value="Yes" {$myobj->isCheckedRadio($pnvalue.default_status_id, 'Yes')} /> <label for="{$pnvalue.default_status_id}Yes">{$LANG.common_yes_option}</label>
								<input type="radio" name="{$pnvalue.default_status_id}" id="{$pnvalue.default_status_id}No" tabindex="{smartyTabIndex}" value="No" {$myobj->isCheckedRadio($pnvalue.default_status_id, 'No')} /> <label for="{$pnvalue.default_status_id}No">{$LANG.common_no_option}</label>
			                </td>
			                <td class="{$myobj->getCSSFormFieldCellClass($pnvalue.changeable_by_user_id)}">
								<input type="radio" name="{$pnvalue.changeable_by_user_id}" id="{$pnvalue.changeable_by_user_id}Yes" tabindex="{smartyTabIndex}" value="Yes" {$myobj->isCheckedRadio($pnvalue.changeable_by_user_id, 'Yes')} /> <label for="{$pnvalue.changeable_by_user_id}Yes">{$LANG.common_yes_option}</label>
								<input type="radio" name="{$pnvalue.changeable_by_user_id}" id="{$pnvalue.changeable_by_user_id}No" tabindex="{smartyTabIndex}" value="No" {$myobj->isCheckedRadio($pnvalue.changeable_by_user_id, 'No')} /> <label for="{$pnvalue.changeable_by_user_id}No">{$LANG.common_no_option}</label>
			                </td>
					   	</tr>
					   	{/foreach}
					   	<tr>
							<td class="{$myobj->getCSSFormFieldCellClass('submit')}" colspan="4">
								<input type="submit" class="clsSubmitButton" name="update_submit" id="update_submit" tabindex="{smartyTabIndex}" value="{$LANG.common_update}" />
							</td>
						</tr>
					</table>
				</form>
		   	</div>
		{/if}
	</div>
</div>