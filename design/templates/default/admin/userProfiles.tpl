{ if $myobj->isShowPageBlock('block_user_list')}
<div id="selMsgConfirmWindow" class="clsPopupAlert" style="display:none;">
  <h3 id="confirmation_msg"></h3>
  <form name="msgConfirmForm" id="msgConfirmForm" method="post" action="{$myobj->getCurrentUrl()}">
    <input type="submit" class="clsSubmitButton" name="confirm_act" id="confirm_act" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
    &nbsp;
    <input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks();" />
    {$myobj->populateHidden($myobj->msgConfirmForm_hidden_arr)}
  </form>
</div>
{/if}
<div id="selUserProfiles">
  <h2><span>{$LANG.userprofiles_title}</span></h2>
  {$myobj->setTemplateFolder('admin/')}
{include file="information.tpl"}
  <h3><span>{$LANG.userprofiles_search_title}</span></h3>
  { if $myobj->isShowPageBlock('block_user_search')}
	<form name="userSearchForm" id="userSearchForm" method="post" action="{$myobj->getCurrentUrl()}">
		<table class="clsNoBorder">
        <tr>
			<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('user_name')}"><label for="user_name">{$LANG.userprofiles_user_name}</label></td>
			<td class="{$myobj->getCSSFormFieldCellClass('user_name')}">{$myobj->getFormFieldErrorTip('user_name')}<input type="text" class="clsTextBox" name="user_name" id="user_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('user_name')}" />
		   	{$myobj->ShowHelpTip('username', 'user_name')}</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('email')}"><label for="email">{$LANG.userprofiles_email}</label></td>
			<td class="{$myobj->getCSSFormFieldCellClass('email')}">{$myobj->getFormFieldErrorTip('email')}<input type="text" class="clsTextBox" name="email" id="email" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('email')}" />
		    {$myobj->ShowHelpTip('email')}</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('gender')}"><label for="gender_m">{$LANG.userprofiles_gender}</label></td>
			<td class="{$myobj->getCSSFormFieldCellClass('gender')}">{$myobj->getFormFieldErrorTip('gender')}
				<input type="radio" class="clsRadioButton" name="gender" id="gender_b" tabindex="{smartyTabIndex}" value="" {$myobj->isCheckedRadio('gender', '')} /><label for="gender_m">{$LANG.userprofiles_both}</label>
				<input type="radio" class="clsRadioButton" name="gender" id="gender_m" tabindex="{smartyTabIndex}" value="m" {$myobj->isCheckedRadio('gender', 'm')} /><label for="gender_m">{$LANG.common_male_option}</label>
				<input type="radio" class="clsRadioButton" name="gender" id="gender_f" tabindex="{smartyTabIndex}" value="f" {$myobj->isCheckedRadio('gender', 'f')} /><label for="gender_f">{$LANG.common_female_option}</label>
	    	{$myobj->ShowHelpTip('gender', 'gender_m')}
			
			</td>
        </tr>
		<tr">
			<td class="{$myobj->getCSSFormLabelCellClass('dob_from')}"><label for="dob_from">{$LANG.userprofiles_dob_from}</label></td>
			<td class="{$myobj->getCSSFormFieldCellClass('dob_from')}">{$myobj->getFormFieldErrorTip('dob_from')}
				<input type="text" class="clsTextBox" name="dob_from" id="dob_from" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('dob_from')}" readonly />
				<button class="clsSubmitButton" type="reset" id="f_trigger_dob_from">...</button>
				{$myobj->populateCalendar('dob_from', 'f_trigger_dob_from')}
			{$myobj->ShowHelpTip('dob', 'dob_from')}
			</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('dob_to')}"><label for="dob_to">{$LANG.userprofiles_dob_to}</label></td>
			<td class="{$myobj->getCSSFormFieldCellClass('dob_to')}">{$myobj->getFormFieldErrorTip('dob_to')}
				<input type="text" class="clsTextBox" name="dob_to" id="dob_to" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('dob_to')}" readonly />
				<button class="clsSubmitButton" type="reset" id="f_trigger_dob_to">...</button>
				{$myobj->populateCalendar('dob_to', 'f_trigger_dob_to')}
			{$myobj->ShowHelpTip('dob', 'dob_to')}
			</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('doj_from')}"><label for="doj_from">{$LANG.userprofiles_doj_from}</label></td>
			<td class="{$myobj->getCSSFormFieldCellClass('doj_from')}">{$myobj->getFormFieldErrorTip('doj_from')}
				<input type="text" class="clsTextBox" name="doj_from" id="doj_from" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('doj_from')}" readonly />
				<button class="clsSubmitButton" type="reset" id="f_trigger_doj_from">...</button>
				{$myobj->populateCalendar('doj_from', 'f_trigger_doj_from')}
			{$myobj->ShowHelpTip('doj', 'doj_from')}
			</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('doj_to')}"><label for="doj_to">{$LANG.userprofiles_doj_to}</label></td>
			<td class="{$myobj->getCSSFormFieldCellClass('doj_to')}">{$myobj->getFormFieldErrorTip('doj_to')}
				<input type="text" class="clsTextBox" name="doj_to" id="doj_to" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('doj_to')}" readonly />
				<button class="clsSubmitButton" type="reset" id="f_trigger_doj_to">...</button>
				{$myobj->populateCalendar('doj_to', 'f_trigger_doj_to')}
			{$myobj->ShowHelpTip('doj', 'doj_to')}
			</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('group_name')}"><label for="group_name">{$LANG.userprofiles_group_name}</label></td>
			<td class="{$myobj->getCSSFormFieldCellClass('group_name')}">{$myobj->getFormFieldErrorTip('group_name')}<input type="text" class="clsTextBox" name="group_name" id="group_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('group_name')}" />
		    {$myobj->ShowHelpTip('group_name')}</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('usr_status')}"><label for="usr_status">{$LANG.userprofiles_usr_status}</label></td>
			<td class="{$myobj->getCSSFormFieldCellClass('usr_status')}">{$myobj->getFormFieldErrorTip('usr_status')}
				<select name="usr_status" id="usr_status" tabindex="{smartyTabIndex}" >
					{$myobj->generalPopulateArray($usr_status_arr, $field_value_usr_status)}
                </select>
		    {$myobj->ShowHelpTip('usr_status')}
			</td>
		</tr>
		<tr>
			<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('default')}">
				<input type="submit" class="clsSubmitButton" name="search_submit" id="search_submit" tabindex="{smartyTabIndex}" value="{$LANG.userprofiles_search_submit}" />
			</td>
		</tr>
        </table>
	</form>
  {/if}
  <p class="clsAddContentMainLink"><a href="userProfilesEdit.php?act=add">{$LANG.userprofiles_add_new_user}</a></p>
  { if $myobj->isShowPageBlock('block_user_list')}
  <form name="userListForm" id="userListForm" method="post" action="{$myobj->getCurrentUrl()}">
    {if $CFG.admin.navigation.top}
    {$myobj->setTemplateFolder('admin/')}{include file='pagination.tpl'}
    {/if}
        <!-- clsDataDisplaySection - starts here -->

    <div class="clsDataDisplaySection">
        <table><tr>
          <th>
            <input type="checkbox" class="clsCheckBox" name="check_all" onclick= "CheckAll(document.userListForm.name, document.userListForm.check_all.name)" tabindex="{smartyTabIndex}" />
          </th>
          <th class="clsUserNameColumn {$myobj->getOrderCss('user_name')}"><a href="#" onclick="return changeOrderbyElements('userListForm','user_name')">{$LANG.userprofiles_user_name}</a> </th>
          <th class="clsEmailColumn{$myobj->getOrderCss('email')}"><a href="#" onclick="return changeOrderbyElements('userListForm','email')">{$LANG.userprofiles_email}</a> </th>
          <th>{$LANG.userprofiles_name}</th>
		  <th class="clsEmailColumn{$myobj->getOrderCss('group_name')}"><a href="#" onclick="return changeOrderbyElements('userListForm','group_name')">{$LANG.userprofiles_group_name}</a> </th>
          <th class="clsStatusColumn{$myobj->getOrderCss('usr_status')}"><a href="#" onclick="return changeOrderbyElements('userListForm','usr_status')">{$LANG.userprofiles_usr_status}</a> </th>
          <th class="clsDateColumn{$myobj->getOrderCss('user_id')}"><a href="#" onclick="return changeOrderbyElements('userListForm','user_id')">{$LANG.userprofiles_doj}</a> </th>
          <th class="clsManageColumn">{$LANG.userprofiles_action}</th>
        </tr>
	  {foreach key=inc item=value from=$populateUserProfiles_arr}
          <tr>
            <td class="clsSelectColumn">
              <input type="checkbox" class="clsCheckBox" name="pid[]" value="{$populateUserProfiles_arr.$inc.user_id}" tabindex="{smartyTabIndex}" onClick="disableHeading('userListForm');"/>
            </td>
            <td class="clsUserNameColumn"><a href="{$populateUserProfiles_arr.$inc.profile_link}">{$myobj->getTableData($populateUserProfiles_arr.$inc.user_name)}</a></td>
            <td class="clsEmailColumn">{$myobj->getTableData($populateUserProfiles_arr.$inc.email)}</td>
            <td>{$myobj->getTableData($populateUserProfiles_arr.$inc.name)}</td>
            <td class="clsGroupNameColumn">{$myobj->getTableData($populateUserProfiles_arr.$inc.group_name)}</td>
			<td class="clsStatusColumn">{$myobj->getTableData($populateUserProfiles_arr.$inc.usr_status_text)}</td>
            <td class="clsDateColumn">{$myobj->getTableData($populateUserProfiles_arr.$inc.doj)}</td>
            <td class="clsManageColumn"><ul>
<li><a href="{$populateUserProfiles_arr.$inc.edit_link}">{$LANG.userprofiles_edit}</a></li>
</ul></td>
          </tr>
        {/foreach}
            <tr>
              <td colspan="8">
                <select name="act" id="act" tabindex="{smartyTabIndex}" >
							{$myobj->generalPopulateArray($action_arr, $field_value_act)}
                </select>
                <input type="button" class="clsSubmitButton" value="{$LANG.userprofiles_submit}" tabindex="{smartyTabIndex}" onclick="{$submit_onclick}" />
				<select name="group" id="group" tabindex="{smartyTabIndex}">
					<option value="">{$LANG.userprofiles_select_group}</option>
					{foreach key=group_key item=group_value from=$groups_list_arr}
						<option value="{$group_key}">{$group_value.name}</option>
						{if isset($group_value.child)}
							{foreach key=child_key item=child_value from=$group_value.child}
								<option value="{$child_key}">&nbsp;&nbsp;&nbsp;{$child_value.name}</option>
							{/foreach}
						{/if}
					{/foreach}
				</select>
				<input type="button" class="clsSubmitButton" value="{$LANG.userprofiles_move_group}" tabindex="{smartyTabIndex}" onclick="{$move_group_onclick}" />
              </td>
            </tr>
          </table>
    </div>

        <!-- clsDataDisplaySection - ends here -->
    {if $CFG.admin.navigation.bottom}
    {$myobj->setTemplateFolder('admin/')}{include file='pagination.tpl'}
    {/if}
    {$myobj->populateHidden($myobj->userListForm_hidden_arr)}
  </form>
  {/if} </div>
