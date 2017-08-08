<div id="selArticleCategory" class="clsArticleCategory">
	<h2><span>{$LANG.manageprofileblock_title}</span></h2>
     <div id="selMsgSuccess">
        	<p>{$LANG.manageprofileblock_note}: {$LANG.manageprofileblock_note_message}</p>
     </div>
   {$myobj->setTemplateFolder('admin/')}
   {include file='information.tpl'}
   <p class="clsBackLink"><a href="reOrderProfileBlock.php">{$LANG.manageprofileblock_back}</a></p>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			<table summary="{$LANG.manageprofileblock_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_yes_option}" />&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_no_option}" onClick="return hideAllBlocks();" />
					</td>
				</tr>
			</table>
			<input type="hidden" name="profile_block_ids" id="profile_block_ids" />
			<input type="hidden" name="action" id="action" />
			{$myobj->populateHidden($myobj->hidden_arr1)}
		</form>
	</div>
	<div class="clsLeftNavigation" id="selLeftNavigation">
{if $myobj->isShowPageBlock('form_create_profile_block')}
	<div id="selCreateCategory">
		<form name="selCreateCategory" id="selCreateCategory" enctype="multipart/form-data" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
		<table class="clsNoBorder" summary="{$LANG.manageprofileblock_create_tbl_summary}">
		   	<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('module_name')}"><label for="module_name">{$LANG.manageprofileblock_module_name}</label>{$myobj->displayCompulsoryIcon()}</td>
				<td class="{$myobj->getCSSFormFieldCellClass('module_name')}">{$myobj->getFormFieldErrorTip('module_name')}
					<input type="text" class="clsTextBox" name="module_name" id="module_name" value="{$myobj->getFormField('module_name')}" tabindex="{smartyTabIndex}" />
				</td>
			</tr>
            <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('block_name')}"><label for="block_name">{$LANG.manageprofileblock_block_name}</label>{$myobj->displayCompulsoryIcon()}</td>
				<td class="{$myobj->getCSSFormFieldCellClass('block_name')}">{$myobj->getFormFieldErrorTip('block_name')}
					<input type="text" class="clsTextBox" name="block_name" id="block_name" value="{$myobj->getFormField('block_name')}" tabindex="{smartyTabIndex}" />
				</td>
			</tr>
             <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('block_description')}"><label for="block_description">{$LANG.manageprofileblock_block_description}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('block_description')}">{$myobj->getFormFieldErrorTip('block_description')}
					<textarea name="block_description" id="block_description" tabindex="{smartyTabIndex}" cols="30" rows="2">{$myobj->getFormField('block_description')}</textarea>
				</td>
			</tr>
            <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('position')}"><label>{$LANG.manageprofileblock_block_position}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('position')}">
					<input type="radio" class="clsCheckRadio" name="position" id="position_left" value="left" {if $myobj->getFormField('position') == 'left'} CHECKED {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="position_left">{$LANG.manageprofileblock_position_left}</label>
					&nbsp;&nbsp;
					<input type="radio" class="clsCheckRadio" name="position" id="position_right" value="right" {if $myobj->getFormField('position') == 'right'} CHECKED {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="position_right">{$LANG.manageprofileblock_position_right}</label>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('display')}"><label>{$LANG.manageprofileblock_block_display}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('display')}">
					<input type="radio" class="clsCheckRadio" name="display" id="display_yes" value="Yes" {if $myobj->getFormField('display') == 'Yes'} CHECKED {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="display_yes">{$LANG.manageprofileblock_display_yes}</label>
					&nbsp;&nbsp;
					<input type="radio" class="clsCheckRadio" name="display" id="display_no" value="No" {if $myobj->getFormField('display') == 'No'} CHECKED {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="display_no">{$LANG.manageprofileblock_display_no}</label>
				</td>
			</tr>
			<tr>
            	<td></td>
				<td class="{$myobj->getCSSFormFieldCellClass('profile_block_submit')}">
			{if $myobj->chkIsEditMode()}
					<input type="submit" class="clsSubmitButton" name="profile_block_submit" id="profile_block_submit" tabindex="{smartyTabIndex}" value="{$LANG.manageprofileblock_update_submit}" />
					<input type="submit" class="clsCancelButton" name="category_cancel" id="category_cancel" tabindex="{smartyTabIndex}" value="{$LANG.manageprofileblock_cancel_submit}" />
			{else}
			        <input type="submit" class="clsSubmitButton" name="profile_block_submit" id="profile_block_submit" tabindex="{smartyTabIndex}" value="{$LANG.manageprofileblock_add_submit}" />
			{/if}

				</td>
			</tr>
		</table>
        {$myobj->populateHidden($myobj->form_create_profile_block.hidden_arr)}
		</form>
	</div>

{/if}

{if $myobj->isShowPageBlock('form_show_profile_block')}
	<form name="selFormCategory" id="selFormCategory" method="post" action="{$myobj->getCurrentUrl()}">
    {$myobj->populateHidden($myobj->form_show_profile_block.hidden_arr)}

    <div id="selShowCategories">
        {if $myobj->isResultsFound()}
            {if $CFG.admin.navigation.top}
                {$myobj->setTemplateFolder('admin/')}
                {include file='pagination.tpl'}
            {/if}

            <table summary="{$LANG.manageprofileblock_tbl_summary}">
                <tr>
                    <th><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.selFormCategory.name, document.selFormCategory.check_all.name)"/></th>
                    <th>{$LANG.manageprofileblock_module_name}</th>
                    <th>{$LANG.manageprofileblock_block_name}</th>
                    <th>{$LANG.manageprofileblock_block_description}</th>
                    <th>{$LANG.manageprofileblock_block_position}</th>
                    {*<!-- <th>{$LANG.manageprofileblock_order_no}</th>-->*}
                    <th>{$LANG.manageprofileblock_block_display}</th>
                    {* <!-- <th>{$LANG.manageprofileblock_status}</th>-->*}
                    <th>{$LANG.manageprofileblock_date_added}</th>
                    <th>&nbsp;</th>
                </tr>
			{foreach key=scKey item=scValue from=$showProfileBlock_arr}
                <tr>
                    <td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="profile_block_ids[]" value="{$scValue.record.profile_block_id}" tabindex="{smartyTabIndex}"  onclick= "deselectCheckBox(document.selFormCategory.name, document.selFormCategory.check_all.name)" {$scValue.checked}/></td>
                   <td> <p>{$scValue.record.module_name}</p></td>
                   <td> <p>{$scValue.record.block_name}</p></td>
                   <td> <p>{$scValue.record.block_description}</p></td>
                   <td> <p>{$scValue.record.position}</p></td>
                   {*<!-- <td> <p>{$scValue.record.order_no}</p></td>-->*}
                   <td> <p>{$scValue.record.display}</p></td>
                   {*  <!--<td> <p>{$scValue.record.active}</p></td>-->*}
                   <td> <p>{$scValue.record.date_added|date_format:#format_datetime#}</p></td>
                    <td>
                        <p id="edit_{$scValue.record.profile_block_id}"><a href="manageProfileBlock.php?profile_block_id={$scValue.record.profile_block_id}&amp;start={$myobj->getFormField('start')}">{$LANG.manageprofileblock_edit}</a></p>
                    </td>
                </tr>
            {/foreach}
				<tr>
					<td colspan="8" class="{$myobj->getCSSFormFieldCellClass('delete')}">
						<a href="#" id="dAltMlti"></a>
						<select name="profile_block_options" id="profile_block_options" tabindex="{smartyTabIndex}" >
							<option value="Enable">{$LANG.manageprofileblock_action_enable}</option>
	  						<option value="Disable">{$LANG.manageprofileblock_action_disable}</option>
	  						<option value="Delete">{$LANG.manageprofileblock_action_delete}</option>
	  					</select>
						<input type="button" class="clsSubmitButton" name="action_submit" id="action_submit" tabindex="{smartyTabIndex}" value="{$LANG.manageprofileblock_submit}" onClick="if(getMultiCheckBoxValue('selFormCategory', 'check_all', '{$LANG.manageprofileblock_err_tip_select_profile_block}', 'dAltMlti', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirm', 'msgConfirmform', Array('profile_block_ids', 'action', 'confirmMessage'), Array(multiCheckValue, document.selFormCategory.profile_block_options.value, '{$LANG.manageprofileblock_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" />
					</td>
				</tr>
			</table>

            {if $CFG.admin.navigation.bottom}
           	    {$myobj->setTemplateFolder('admin/')}
                {include file='pagination.tpl'}
            {/if}
        {else}
            <div id="selMsgAlert">
                <p>{$LANG.manageprofileblock_no_category}</td>
            </div>
        {/if}
    </div>
	</form>
{/if}

	</div>
</div>