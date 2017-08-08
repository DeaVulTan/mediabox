<div id="selServerSettings">
	<h2><span>{$LANG.server_title}</span></h2>
    <div class="clsServerSettingMain">
	{$myobj->setTemplateFolder('admin/')}
	{include file="information.tpl"}
	{if $myobj->isShowPageBlock('form_addDetails') or $myobj->isShowPageBlock('form_editDetails')}

    <form name="form_addServer" id="selFormAddServer" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
		<table summary="{$LANG.server_add_summary}" class="clsFormTableSection">
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('server_url')}">
					<label for="server_url">{$LANG.server_url}</label>
					{$myobj->displayCompulsoryIcon()}
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('server_url')}">
					<input type="text" class="clsTextBox" name="server_url" id="server_url" maxlength="200" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('server_url')}" />&nbsp;(http://example.test.in/)
					{$myobj->getFormFieldErrorTip('server_url')}
				</td>
		   	</tr>
		   	<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('server_for')}">
                
                {* include file='../general/box.tpl' opt='compulsory_empty' *}
					<label for="server_for">{$LANG.server_for}</label>
					{$myobj->displayCompulsoryIcon()}
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('server_for')}">
					<select name="server_for" id="server_for" tabindex="{smartyTabIndex}" onChange="changeCategory(this.value)">
						{html_options options=$myobj->modules_arr selected=$myobj->getFormField('server_for')}
					</select>
					{$myobj->getFormFieldErrorTip('server_for')}
				</td>
		   	</tr>
		   	<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('server_status')}">
                {* include file='../general/box.tpl' opt='compulsory_empty' *}
                <label for="server_status">{$LANG.server_status}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('server_status')}">
					<select name="server_status" id="server_status" tabindex="{smartyTabIndex}">
						<option {if $myobj->getFormField('server_status') == 'No'}selected{/if} value="No">No</option>
						<option {if $myobj->getFormField('server_status') == 'Yes'}selected{/if} value="Yes">Yes</option>
					</select>
                    {$myobj->getFormFieldErrorTip('server_status')}
				</td>
		   	</tr>
		   	<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('ftp_server')}">
					<label for="ftp_server">{$LANG.server_ftp_server}</label>
					{$myobj->displayCompulsoryIcon()}
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('ftp_server')}">
					<input type="text" class="clsTextBox" name="ftp_server" id="ftp_server" maxlength="200" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('ftp_server')}" />&nbsp;(example.test.in)
                    {$myobj->getFormFieldErrorTip('ftp_server')}
				</td>
		   	</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('ftp_folder')}">
                {* include file='../general/box.tpl' opt='compulsory_empty' *}
					<label for="ftp_folder">{$LANG.server_ftp_folder}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('ftp_folder')}">
					<input type="text" class="clsTextBox" name="ftp_folder" id="ftp_folder" maxlength="200" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('ftp_folder')}" />&nbsp;(/var/www/html/rayzz/media_server/)
                    {$myobj->getFormFieldErrorTip('ftp_folder')}
				</td>
		   	</tr>
		   	<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('ftp_usrename')}">
					<label for="ftp_usrename">{$LANG.server_ftp_username}</label>
					{$myobj->displayCompulsoryIcon()}
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('ftp_usrename')}">
					<input type="text" class="clsTextBox" name="ftp_usrename" id="ftp_usrename" maxlength="200" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('ftp_usrename')}" />
                    {$myobj->getFormFieldErrorTip('ftp_usrename')}
				</td>
		   	</tr>
		   	<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('ftp_password')}">
                {* include file='../general/box.tpl' opt='compulsory_empty' *}
					<label for="ftp_password">{$LANG.server_ftp_password}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('ftp_password')}">
					<input type="text" class="clsTextBox" name="ftp_password" id="ftp_password" maxlength="200" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('ftp_password')}" />
                    {$myobj->getFormFieldErrorTip('ftp_password')}
				</td>
		   	</tr>
			<tr>
            	<td></td>
            	<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
				{if $myobj->isShowPageBlock('form_editDetails')}
					<input type="hidden" name="sid" id="sid" value="{$myobj->getFormField('sid')}" />
					<input type="submit" class="clsSubmitButton" name="edit_submit" id="edit_submit" tabindex="{smartyTabIndex}" value="{$LANG.server_submit_update}" />
					<input type="submit" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.server_submit_cancel}" />

				{else}
					<input type="submit" class="clsSubmitButton" name="add_submit" id="add_submit" tabindex="{smartyTabIndex}" value="{$LANG.server_submit_add}" />
				{/if}
				</td>
			</tr>
		</table>
	</form>
{/if}
{if $myobj->isShowPageBlock('form_details')}
	<div id="selMsgConfirm" class="selMsgConfirm" style="display:none;">
		<form name="form_editprofile" id="selFormEditProfile" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
			<input type="hidden" name="sid" id="sid" />
			<input type="hidden" name="action" id="action" />
			<p id="selConfirmMsg"></p>
			<table summary="{$LANG.server_del_conf_summary}">
			   	<tr>
					<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
						<input type="submit" class="clsSubmitButton" name="act_submit" id="act_submit" tabindex="{smartyTabIndex}" value="{$LANG.server_submit_del}" />
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.server_submit_cancel}" onClick="return hideAllBlocks();" />
					</td>
			   	</tr>
			</table>
		</form>
	</div>
	<form name="form_listServers" id="selFormListServers" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
		<table summary="{$LANG.server_list_summary}">
			<tr>
				<th>{$LANG.server_sno}</th>
				<th>{$LANG.server_url}</th>
				<th>{$LANG.server_for}</th>
				<th>{$LANG.server_status}</th>
				<th>{$LANG.server_ftp_server}</th>
				<th>{$LANG.server_ftp_folder}</th>
				<th>{$LANG.server_ftp_username}</th>
				<th>{$LANG.server_ftp_password}</th>
				<th>{$LANG.server_action}</th>
			</tr>
			{foreach key=spikey item=spivalue from=$myobj->form_details.listServerDetails.record}
				<tr>
					<td>{$spikey}</td>
					<td>{$spivalue.row.server_url}</td>
					<td>{$spivalue.row.server_for}</td>
					<td>{$spivalue.row.server_status}</td>
					<td>{$spivalue.row.ftp_server}</td>
					<td>{$spivalue.row.ftp_folder}</td>
					<td>{$spivalue.row.ftp_usrename}</td>
					<td>{$spivalue.row.ftp_password}</td>
					<td id="selEditDelServer">
						<span class="clsEditServer"><a href="{$spivalue.edit}">{$LANG.server_link_edit}</a></span>
						<span class="clsDeleteServer"><a href="{$myobj->getCurrentUrl(false)}" onClick="{$spivalue.onclick}">{$LANG.server_link_delete}</a></span>
					</td>
				</tr>
			{foreachelse}
			<tr>
				<td colspan="10">
					<div id="selMsgAlert">
						<p>{$LANG.no_servers_found}</p>
					</div>
				</td>
			</tr>
			{/foreach}
		</table>
	</form>
{/if}
{if $myobj->isShowPageBlock('form_already_exist_new')}
	<table cellspacing="0" summary="{$LANG.server_del_summary}">
		<tr><th>{$LANG.server_url}</th><td>{$myobj->getFormField('server_url')}</td></tr>
		<tr><th>{$LANG.server_for}</th><td>{$myobj->getFormField('server_for')}</td></tr>
		<tr><th>{$LANG.server_status}</th><td>{$myobj->getFormField('server_status')}</td></tr>
		<tr><th>{$LANG.server_ftp_server}</th><td>{$myobj->getFormField('ftp_server')}</td></tr>
		<tr><th>{$LANG.server_ftp_folder}</th><td>{$myobj->getFormField('ftp_folder')}</td></tr>
		<tr><th>{$LANG.server_ftp_username}</th><td>{$myobj->getFormField('ftp_usrename')}</td></tr>
		<tr><th>{$LANG.server_ftp_password}</th><td>{$myobj->getFormField('ftp_password')}</td></tr>
	</table>
{/if}
{if $myobj->isShowPageBlock('form_already_exist_add')}
	<div>{$LANG.server_msg_already_exist_select}</div>
	<form name="form_editprofile" id="selFormEditProfile" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
		<input type="hidden" name="sid" id="sid" value="{$myobj->getFormField('sid')}" />
		<input type="hidden" name="server_url" id="sid" value="{$myobj->getFormField('server_url')}" />
		<input type="hidden" name="server_for" id="sid" value="{$myobj->getFormField('server_for')}" />
		<input type="hidden" name="server_status" id="sid" value="{$myobj->getFormField('server_status')}" />
		<input type="hidden" name="ftp_server" id="sid" value="{$myobj->getFormField('ftp_server')}" />
		<input type="hidden" name="ftp_folder" id="sid" value="{$myobj->getFormField('ftp_folder')}" />
		<input type="hidden" name="ftp_usrename" id="sid" value="{$myobj->getFormField('ftp_usrename')}" />
		<input type="hidden" name="ftp_password" id="sid" value="{$myobj->getFormField('ftp_password')}" />

		<table summary="{$LANG.server_del_conf_summary}">
		   	<tr>
				<td class="<{$myobj->getCSSFormFieldCellClass('submit')}">
					<input type="submit" class="clsSubmitButton" name="add_yes_submit" id="add_yes_submit" tabindex="{smartyTabIndex}" value="{$LANG.server_add_and_set_status_yes}" />
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
					<input type="submit" class="clsSubmitButton" name="add_no_submit" id="add_no_submit" tabindex="{smartyTabIndex}" value="{$LANG.server_add_and_set_status_no}" />
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
					<input type="submit" class="clsSubmitButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.server_cancel_dont_add}" />
				</td>
		   	</tr>
		</table>
	</form>
{/if}
{if $myobj->isShowPageBlock('form_already_exist_edit')}
	<div>{$LANG.server_msg_already_exist_reference}</div>
	<form name="form_editprofile" id="selFormEditProfile" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
		<input type="hidden" name="sid" id="sid" value="{$myobj->getFormField('sid')}" />
		<input type="hidden" name="server_url" id="sid" value="{$myobj->getFormField('server_url')}" />
		<input type="hidden" name="server_for" id="sid" value="{$myobj->getFormField('server_for')}" />
		<input type="hidden" name="server_status" id="sid" value="{$myobj->getFormField('server_status')}" />
		<input type="hidden" name="ftp_server" id="sid" value="{$myobj->getFormField('ftp_server')}" />
		<input type="hidden" name="ftp_folder" id="sid" value="{$myobj->getFormField('ftp_folder')}" />
		<input type="hidden" name="ftp_usrename" id="sid" value="{$myobj->getFormField('ftp_usrename')}" />
		<input type="hidden" name="ftp_password" id="sid" value="{$myobj->getFormField('ftp_password')}" />

		<table summary="{$LANG.server_del_conf_summary}">
		   	<tr>
				<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
					<input type="submit" class="clsSubmitButton" name="edit_yes_submit" id="edit_yes_submit" tabindex="{smartyTabIndex}" value="{$LANG.server_update_and_set_status_yes}" />
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
					<input type="submit" class="clsSubmitButton" name="edit_no_submit" id="edit_no_submit" tabindex="{smartyTabIndex}" value="{$LANG.server_update_and_set_status_no}" />
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
					<input type="submit" class="clsSubmitButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.server_cancel_dont_update}" />
				</td>
		   	</tr>
		</table>
	</form>
{/if}
{if $myobj->isShowPageBlock('form_already_exist_old')}
	<hr />
	{$LANG.for_your_reference}
	<table cellspacing="0" summary="{$LANG.server_del_summary}">
		<tr><th>{$LANG.server_sid}</th><td>{$myobj->form_already_exist_old.curr_active.server_id}</td></tr>
		<tr><th>{$LANG.server_url}</th><td>{$myobj->form_already_exist_old.curr_active.server_url}</td></tr>
		<tr><th>{$LANG.server_for}</th><td>{$myobj->form_already_exist_old.curr_active.server_for}</td></tr>
		<tr><th>{$LANG.server_status}</th><td>{$myobj->form_already_exist_old.curr_active.server_status}</td></tr>
		<tr><th>{$LANG.server_ftp_server}</th><td>{$myobj->form_already_exist_old.curr_active.ftp_server}</td></tr>
		<tr><th>{$LANG.server_ftp_folder}</th><td>{$myobj->form_already_exist_old.curr_active.ftp_folder}</td></tr>
		<tr><th>{$LANG.server_ftp_username}</th><td>{$myobj->form_already_exist_old.curr_active.ftp_usrename}</td></tr>
		<tr><th>{$LANG.server_ftp_password}</th><td>{$myobj->form_already_exist_old.curr_active.ftp_password}</td></tr>
	</table>
{/if}
</div>
</div>