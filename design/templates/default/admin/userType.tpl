<div id="selManagementuserType">
	<h2>{$LANG.usertype_title}</h2>
	 <!-- information div -->
    {$myobj->setTemplateFolder('admin/')}
    {include file='information.tpl'}

    {if $myobj->isShowPageBlock('usertype_form')}
    	<form name="form1" id="form1" action="{$myobj->getCurrentUrl(false)}" method="post">
            <table class="clsNoBorder">
            	<tr>
                	<td class="{$myobj->getCSSFormLabelCellClass('type_name')}">
				  		<label for="type_name"> {$LANG.usertype_name}</label>
						{$myobj->displayCompulsoryIcon()}
                  	</td>
                  	<td>
				  		<input type="text" class="clsTextBox" name="type_name" id="type_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('type_name')}" />
						{$myobj->getFormFieldErrorTip('type_name')}
	                  	{$myobj->ShowHelpTip('usertype_name', 'type_name')}
                  	</td>
                </tr>
		        <tr>
		          	<td class="{$myobj->getCSSFormLabelCellClass('type_status')}">
		            	<label for="status_activate">{$LANG.usertype_status}</label>
		          	</td>
		          	<td class="{$myobj->getCSSFormFieldCellClass('type_status')}"> {$myobj->getFormFieldErrorTip('type_status')}
		            	<input type="radio" class="clsRadioButton" name="type_status" id="status_activate" tabindex="{smartyTabIndex}" value="Active"{$myobj->isCheckedRadio('type_status', 'Active')} />
		            	<label for="status_activate">{$LANG.usertype_active}</label>
		            	<input type="radio" class="clsRadioButton" name="type_status" id="status_inactivate" tabindex="{smartyTabIndex}" value="Inactive"{$myobj->isCheckedRadio('type_status', 'Inactive')} />
		            	<label for="status_inactivate">{$LANG.usertype_inactive}</label>
		        		{$myobj->ShowHelpTip('usertype_status', 'type_status')}
		          	</td>
				</tr>
				<tr>
					<th colspan="2">{$LANG.usertype_available_permissions}</th>
				</tr>
				<tr>
					<td colspan="2">{$LANG.usertype_info_for_giving_permission}</td>
				</tr>
				{if $myobj->user_actions}
					{foreach key=action_key item=action from=$myobj->user_actions}
						{if $action.action_type == "checkbox"}
					        <tr>
					          	<td class="{$myobj->getCSSFormLabelCellClass($action.action_name)}">
					            	<label for="{$action.element_id.0}">{$action.action_heading_lang}</label>
					          	</td>
					          	<td class="{$myobj->getCSSFormFieldCellClass($action.action_name)}">
					          		{foreach key=value_key item=action_value from=$action.action_values}
						          		<input type="checkbox" name="{$action.element_id.$value_key}" id="{$action.element_id.$value_key}" value="{$action_value}" {$myobj->isCheckedCheckBox($action.element_id.$value_key)}/>
						          		<label for="{$action.element_id.$value_key}">{$action.action_lang.$value_key}</label>
						          	{/foreach}
						        </td>
							</tr>
						{elseif $action.action_type == "radio"}
					        <tr>
					          	<td class="{$myobj->getCSSFormLabelCellClass($action.action_name)}">
					            	<label for="{$action.element_id.0}">{$action.action_heading_lang}</label>
					          	</td>
					          	<td class="{$myobj->getCSSFormFieldCellClass($action.action_name)}">
					          		{foreach key=value_key item=action_value from=$action.action_values}
						          		<input type="radio" name="{$action.action_name}" id="{$action.element_id.$value_key}" value="{$action_value}" {$myobj->isCheckedRadio($action.action_name, $action_value)} />
						          		<label for="{$action.element_id.$value_key}">{$action.action_lang.$value_key}</label>
						        	{/foreach}
								</td>
							</tr>
						{elseif $action.action_type == "textbox"}
					        <tr>
					          	<td class="{$myobj->getCSSFormLabelCellClass($action.action_name)}">
					            	<label for="{$action.element_id}">{$action.action_lang}</label>
					          	</td>
					          	<td class="{$myobj->getCSSFormFieldCellClass($action.action_name)}">
					          		<input type="textbox" name="{$action.element_id}" id="{$action.element_id}" value="{$myobj->getFormField($action.action_name)}" />
					          	</td>
							</tr>
					   	{/if}
					{/foreach}
				{else}
					<tr>
						<td colspan="2">{$LANG.usertype_no_permissions_available}</th>
					</tr>
				{/if}
               	<tr>
                	<td colspan="2" class="{$myobj->getCSSFormLabelCellClass('usertype_submit')}">
                        <input type="submit" class="clsSubmitButton" name="usertype_submit" id="usertype_submit" value="{if $myobj->getFormField('type_id') == ''}{$LANG.usertype_add}{else}{$LANG.usertype_update}{/if}" />
                       	<input type="submit" class="clsCancelButton" name="usertype_cancel" id="usertype_cancel" value="{$LANG.usertype_cancel}" />
                    </td>
                </tr>
            </table>
            <input type="hidden" value="{$myobj->getFormField('type_id')}" name="type_id" id="type_id" />
  		</form>
  	{/if}

  	{if $myobj->isShowPageBlock('usertype_list')}
    	{if $CFG.admin.navigation.top}
        	{$myobj->setTemplateFolder('admin/')}
        	{include file='pagination.tpl'}
    	{/if}

	    <!-- confirmation box -->
	    <div id="selMsgConfirm" style="display:none;">
			<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
				<table summary="{$LANG.confirm_tbl_summary}">
					<tr>
						<td colspan="2"><p id="confirmMessage"></p></td>
			        </tr>
			        <tr>
						<td>
							<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
							&nbsp;
							<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="$Jq('#selMsgConfirm').dialog('close');" />
						</td>
					</tr>
				</table>
				<input type="hidden" name="type_ids" id="type_ids" />
				<input type="hidden" name="action" id="action" />
				{$myobj->populateHidden($myobj->hidden_arr)}
			</form>
		</div>
	    <!-- confirmation box-->

	  	<form name="selFormUserType" id="selFormUserType" method="post" action="userType.php">
	  		<table>
	            {if $myobj->usertype_list.showUserTypes.record_count}
		            <tr>
		                <th class="clsSelectAll">
		                    <input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.selFormUserType.name, document.selFormUserType.check_all.name)"/>
						</th>
		                <th>{$LANG.usertype_name}</th>
		                <th>{$LANG.usertype_total_used}</th>
		                <th>{$LANG.usertype_added_date}</th>
		                <th>{$LANG.usertype_status}</th>
		                <th>{$LANG.usertype_default}</th>
		                <th>{$LANG.usertype_action}</th>
		            </tr>
	            	{foreach key=salKey item=salValue from=$myobj->usertype_list.showUserTypes.row}
	                    <tr>
	                        <td>
	                        	<input type="checkbox" class="clsCheckRadio" name="user_type_ids[]" value="{$salValue.record.type_id}" onClick="disableHeading('selFormUserType');" tabindex="{smartyTabIndex}"/>
	                       	</td>
		                    <td>{$salValue.record.type_name}</td>
		                    <td>{$myobj->getUserTypeUsedCount($salValue.record.type_id)}</td>
		                    <td>{$salValue.record.type_added_date|date_format:#format_date_year#}</td>
	                    	<td>
	                        	{if $salValue.record.type_status == 'Active'}
	                            	{$LANG.usertype_active}
	                            {else}
	                             	{$LANG.usertype_inactive}
	                            {/if}
	                        </td>
	                    	<td>
	                        	{if $salValue.record.default_type == 'Yes'}
	                            	{$LANG.common_yes_option}
	                            {else}
	                             	{$LANG.common_no_option}
	                            {/if}
	                        </td>
	                    	<td>
	                    		<a href="{$salValue.edit_url}">{$LANG.usertype_edit}</a>
	                    		{if $salValue.record.default_type == 'No'}
	                    			<a href="{$myobj->getCurrentUrl()}" onclick="getAction('Default', {$salValue.record.type_id}); return false;">{$LANG.usertype_set_default}</a>
	                    		{/if}
							</td>
	                	</tr>
	                {/foreach}
	                <tr>
	                    <td colspan="6">
	                        <select name="action_val" id="action_val" tabindex="{smartyTabIndex}">
		                        <option value="">{$LANG.common_select_action}</option>
		                        {$myobj->generalPopulateArray($myobj->usertype_list.action_arr, $myobj->getFormField('action'))}
	                        </select>
	                    	<input type="button" name="action_button" class="clsSubmitButton" id="action_button" value="{$LANG.usertype_submit}" onClick="getMultiCheckBoxValue('selFormUserType', 'check_all', '{$LANG.usertype_err_tip_select_titles}');if(multiCheckValue!='') getAction()"/>
						</td>
	                </tr>
	            {else}
		            <tr>
		            	<td align="center">{$LANG.usertype_no_record} &nbsp; <a href="userType.php?action=add">{$LANG.usertype_add}</a></td>
		            </tr>
	            {/if}
	        </table>
	  	</form>
	    {if $CFG.admin.navigation.bottom}
	    	{include file='pagination.tpl'}
	    {/if}
  	{/if}
</div>