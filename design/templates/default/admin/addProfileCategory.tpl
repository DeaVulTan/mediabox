<div id="selArticleCategory" class="clsArticleCategory">
	<h2><span>{$LANG.addprofilecategory_title}</span></h2>
	<div id="selMsgConfirm" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			<table summary="{$LANG.addprofilecategory_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_yes_option}" />&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_no_option}" onclick="return hideAllBlocks();" />						<input type="hidden" name="category_ids" id="category_ids" />
                        <input type="hidden" name="action" id="action" />
                        {$myobj->populateHidden($myobj->hidden_arr1)}
					</td>
				</tr>
			</table>			
		</form>
	</div>
	<div class="clsLeftNavigation" id="selLeftNavigation">

  {$myobj->setTemplateFolder('admin/')}
  {include file='information.tpl'}

{if $myobj->isShowPageBlock('form_create_category')}
	<div id="selCreateCategory">
		<form name="selCreateCategory" id="selCreateCategory" enctype="multipart/form-data" method="post" action="{$myobj->getCurrentUrl(false)}">
		<table class="clsNoBorder" summary="{$LANG.addprofilecategory_create_tbl_summary}">
        	<tr>
            	<td colspan="2">
                	<div>
						<p>{$LANG.addprofilecategory_note}: {$LANG.addprofilecategory_search_form_notes}</p>
					</div>
                </td>
            </tr>
		   	<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('category')}"><label for="category">{$LANG.addprofilecategory_category_name}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('category')}">{$myobj->getFormFieldErrorTip('category')}
					<input type="text" class="clsTextBox" maxlength="50" name="category" id="category" value="{$myobj->getFormField('category')}" tabindex="{smartyTabIndex}" />
				</td>
			</tr>
            <tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('description')}"><label for="description">{$LANG.addprofilecategory_category_description}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('description')}">{$myobj->getFormFieldErrorTip('description')}
					<textarea  name="description" id="description" tabindex="{smartyTabIndex}" cols="100" rows="4">{$myobj->getFormField('description')}</textarea>
				</td>
			</tr>
            <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('search_field_status')}"><label for="search_field_status_yes">{$LANG.addprofilecategory_search_field_status}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('search_field_status')}">
					<input type="radio" class="clsCheckRadio" name="search_field_status" id="search_field_status_yes" value="Yes" {if $myobj->getFormField('search_field_status') == 'Yes'} checked="checked" {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="search_field_status_yes">{$LANG.addprofilecategory_search_field_status_yes}</label>
					&nbsp;&nbsp;
					<input type="radio" class="clsCheckRadio" name="search_field_status" id="search_field_status_no" value="No" {if $myobj->getFormField('search_field_status') == 'No'} checked="checked" {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="search_field_status_no">{$LANG.addprofilecategory_search_field_status_no}</label>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('status')}"><label for="status_yes">{$LANG.addprofilecategory_category_status}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('status')}">
					<input type="radio" class="clsCheckRadio" name="status" id="status_yes" value="Yes" {if $myobj->getFormField('status') == 'Yes'} checked="checked" {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="status_yes">{$LANG.addprofilecategory_status_yes}</label>
					&nbsp;&nbsp;
					<input type="radio" class="clsCheckRadio" name="status" id="status_no" value="No" {if $myobj->getFormField('status') == 'No'} checked="checked" {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="status_no">{$LANG.addprofilecategory_status_no}</label>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('category_submit')}">
			{if $myobj->chkIsEditMode()}
					<input type="submit" class="clsSubmitButton" name="category_submit" id="category_submit" tabindex="{smartyTabIndex}" value="{$LANG.addprofilecategory_update_submit}" />
					<input type="submit" class="clsCancelButton" name="category_cancel" id="category_cancel" tabindex="{smartyTabIndex}" value="{$LANG.addprofilecategory_cancel_submit}" />
			{else}
			        <input type="submit" class="clsSubmitButton" name="category_submit" id="category_submit" tabindex="{smartyTabIndex}" value="{$LANG.addprofilecategory_add_submit}" />
			{/if}
					{$myobj->populateHidden($myobj->form_create_category.hidden_arr)}
				</td>
			</tr>
		</table>
		</form>
	</div>

{/if}
{if $myobj->isShowPageBlock('form_show_category')}
	<form name="selFormCategory" id="selFormCategory" method="post" action="{$myobj->getCurrentUrl()}">
    <div id="selShowCategories">
        {if $myobj->isResultsFound()}
            {if $CFG.admin.navigation.top}
                {$myobj->setTemplateFolder('admin/')}
                {include file='pagination.tpl'}
            {/if}

            <table summary="{$LANG.addprofilecategory_tbl_summary}">
                <tr>
                    <th><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.selFormCategory.name, document.selFormCategory.check_all.name)"/></th>
                    <th>{$LANG.addprofilecategory_category_name}</th>
                    <th>{$LANG.addprofilecategory_category_description}</th>
                    <th>{$LANG.addprofilecategory_allow_search}</th>
                    <th>{$LANG.addprofilecategory_status}</th>
                    <th>{$LANG.addprofilecategory_date_added}</th>
                    <th>{$LANG.addprofilecategory_manage_question}</th>
                    {if $myobj->isShowPageBlock('form_create_category')}
                    <th>&nbsp;</th>
                    {/if}
                </tr>
			{foreach key=scKey item=scValue from=$showCategories_arr}
                <tr>
                    <td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="category_ids[]" value="{$scValue.record.id}" tabindex="{smartyTabIndex}" onclick="deselectCheckBox('selFormCategory', 'check_all');" {$scValue.checked} /></td>
                   <td> <p>{$scValue.record.title}</p></td>
                   <td> <p>{$scValue.record.description}</p></td>
                   <td> <p>{$scValue.record.search_field_status}</p></td>
                   <td> <p>{$scValue.record.status}</p></td>
                    <td> <p>{$scValue.record.date_added|date_format:#format_date_year#}</p></td>
                    <td>
                        <p class="edit"><a href="manageQuestions.php?id={$scValue.record.id}">{$LANG.addprofilecategory_manage_question}</a></p>
                    </td>
                    {if $myobj->isShowPageBlock('form_create_category')}
                    <td>
                        <p class="edit"><a href="addProfileCategory.php?category_id={$scValue.record.id}&amp;start={$myobj->getFormField('start')}">{$LANG.addprofilecategory_edit}</a></p>
                    </td>
                    {/if}
                </tr>
            {/foreach}
				<tr>
					<td colspan="9" class="{$myobj->getCSSFormFieldCellClass('delete')}">
						<a href="#" id="dAltMlti"></a>
						<select name="article_options" id="article_options" tabindex="{smartyTabIndex}" >
							<option value="Enable">{$LANG.addprofilecategory_action_enable}</option>
	  						<option value="Disable">{$LANG.addprofilecategory_action_disable}</option>
                            {if $myobj->isShowPageBlock('form_create_category')}
	  						<option value="Delete">{$LANG.addprofilecategory_action_delete}</option>
                            {/if}
	  					</select>
						<input type="button" class="clsSubmitButton" name="action_submit" id="action_submit" tabindex="{smartyTabIndex}" value="{$LANG.addprofilecategory_submit}" onclick="if(getMultiCheckBoxValue('selFormCategory', 'check_all', '{$LANG.addprofilecategory_err_tip_select_category}', 'dAltMlti', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirm', 'msgConfirmform', Array('category_ids', 'action', 'confirmMessage'), Array(multiCheckValue, document.selFormCategory.article_options.value, '{$LANG.addprofilecategory_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" />
                        {$myobj->populateHidden($myobj->form_show_category.hidden_arr)}
					</td>
				</tr>
			</table>

            {if $CFG.admin.navigation.bottom}
           	    {$myobj->setTemplateFolder('admin/')}
                {include file='pagination.tpl'}
            {/if}
        {else}
            <div id="selMsgAlert">
                <p>{$LANG.addprofilecategory_no_category}</td>
            </div>
        {/if}
    </div>
	</form>
{/if}

	</div>
</div>