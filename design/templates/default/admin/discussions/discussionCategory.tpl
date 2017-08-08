{if !isAjax()}
<div id="selEditLinks">
	<h2 class="clsdiscussionCategory">{$myobj->discussionCategoryCommon.title}</h2>
    <div id="selMisNavLinks">
        <ul>
            <li>{$myobj->category_index}</li>
			{foreach key=ckey item=cat_value from=$myobj->categoryNameList}
		  		<li>{$cat_value.url}</li>
			{/foreach}
        </ul>
	</div>

	<div class="clsSubLink">
{/if}


{include file='information.tpl'}

		{if  $myobj->isShowPageBlock('form_add_category')}
			<div id="selEditLinks">
				<form name="formAddCategory" id="formAddCategory" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off">
				<table class="clsCommonTable" summary="{$LANG.category_add_tbl_summary}">
				   <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('category')}"><label for="category">{$LANG.category_name}</label>&nbsp;*&nbsp;</td>
						<td class="{$myobj->getCSSFormFieldCellClass('category')}"><input type="text" class="clsTextBox {$myobj->getCSSFormFieldElementClass('category')}" name="category" id="category" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('category')}" maxlength="60" />{$myobj->getFormFieldElementErrorTip('category')}
						{$myobj->ShowHelpTip('discussions_category', 'category')}
						</td>
				   </tr>
				   <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('description')}"><label for="description">{$LANG.category_description_title}</label>&nbsp;*&nbsp;</td>
						<td class="{$myobj->getCSSFormFieldCellClass('description')}">
						<textarea name="description" id="description" class="clsTextArea" tabindex="{smartyTabIndex}" cols="23" rows="5" maxlength="{$CFG.admin.description.limit}">{$myobj->getFormField('description')}</textarea>
						{$myobj->getFormFieldElementErrorTip('description')}
						</td>
				   </tr>
   				   <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('is_restricted')}"><label for="is_restricted">{$LANG.restrict_allowed}</label>&nbsp;*&nbsp;</td>
						<td class="{$myobj->getCSSFormFieldCellClass('is_restricted')}">
						<input type="radio" name="is_restricted" id="restricted_yes" value="Yes" {$myobj->isCheckedRadio('is_restricted', 'Yes')} tabindex="{smartyTabIndex}" /><label for="restricted_yes">{$LANG.common_yes_option}</label>
                    	<input type="radio" name="is_restricted" id="restricted_no" value="No" {$myobj->isCheckedRadio('is_restricted', 'No')} tabindex="{smartyTabIndex}" /><label for="restricted_no">{$LANG.common_no_option}</label>
						{$myobj->getFormFieldElementErrorTip('is_restricted')}
						</td>
					</tr>
				   <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('status')}"><label for="status_active">{$LANG.common_status}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('status')}">
							<input type="radio" name="status" id="status_active" value="Active" tabindex="{smartyTabIndex}" { if $myobj->getFormField('status') eq 'Active'} CHECKED {/if} />&nbsp;<label for="status_active">{$LANG.common_display_active}</label>
							&nbsp;&nbsp;
							<input type="radio" name="status" id="status_inactive" value="Inactive" tabindex="{smartyTabIndex}" { if $myobj->getFormField('status') eq 'Inactive'} CHECKED {/if} />&nbsp;<label for="status_inactive">{$LANG.common_display_inactive}</label>{$myobj->getFormFieldElementErrorTip('status')}
						</td>
				   </tr>
				   <tr>
				   		<td class="{$myobj->getCSSFormLabelCellClass('submit')}"></td>
						<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
							<input type="submit" class="clsSubmitButton clsMediumSubmitButton" name="add_category" id="add_category" tabindex="{smartyTabIndex}" value="{if  $myobj->getFormField('cat_id')} {$LANG.category_update} {else} {$LANG.category_add} {/if}" />&nbsp;
							<input type="submit" class="clsCancelButton cancel" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" />
						</td>
				   </tr>
				</table>
				{$myobj->populateHiddenFormFields($myobj->form_add_category.hidden_array)}
				</form>
			</div>
			{if $CFG.feature.jquery_validation}
		    	{literal}
					<script language="javascript" type="text/javascript">
						$Jq("#formAddCategory").validate({
							rules: {
								category: {
									required: true
							    }
							},
							messages: {
								category: {
									required: {/literal}"{$LANG.common_err_tip_compulsory}"{literal}
								}
							}
						});
		        	</script>
		    	{/literal}
			{/if}
		{/if}
		{if  $myobj->isShowPageBlock('form_add_sub_category')}
			<div id="selEditLinks">
				<form name="formAddCategory" id="formAddCategory" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off">
				<table class="clsCommonTable" summary="{$LANG.category_add_tbl_summary}">
				   <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('parent_id')}"><label for="parent_id">{$LANG.category_name}</label>&nbsp;*&nbsp;</td>
						<td class="{$myobj->getCSSFormFieldCellClass('parent_id')}">
						<select name="parent_id" id="parent_id" class="{$myobj->getCSSFormFieldElementClass('parent_id')}" tabindex="{smartyTabIndex}">
							<option value="">{$LANG.discuzz_common_select_choose}</option>
							{foreach key=inc item=value from=$myobj->form_add_sub_category.populateCategories}
								<option value="{$value.record.cat_id}" {$value.selected_chk} >{$value.record.cat_name}</option>
							{/foreach}
							{$myobj->populateCategories($myobj->getFormField('parent_id'))}
						</select>{$myobj->getFormFieldElementErrorTip('parent_id')}</td>
				   </tr>
				   <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('category')}"><label for="category">{$LANG.category_sub_name}</label>&nbsp;*&nbsp;</td>
						<td class="{$myobj->getCSSFormFieldCellClass('category')}"><input type="text" class="clsTextBox {$myobj->getCSSFormFieldElementClass('category')}" name="category" id="category" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('category')}" maxlength="60" />{$myobj->getFormFieldElementErrorTip('category')}</td>
				   </tr>
				   <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('status')}"><label for="status_active">{$LANG.common_status}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('status')}">
							<input type="radio" name="status" id="status_active" value="1" tabindex="{smartyTabIndex}" {if $myobj->getFormField('status') eq '1'} CHECKED {/if} />&nbsp;<label for="status_active">{$LANG.common_display_active}</label>
							&nbsp;&nbsp;
							<input type="radio" name="status" id="status_inactive" value="0" tabindex="{smartyTabIndex}" {if $myobj->getFormField('status') eq '0' } CHECKED {/if} />&nbsp;<label for="status_inactive">{$LANG.common_display_inactive}</label>{$myobj->getFormFieldElementErrorTip('status')}
						</td>
				   </tr>
				   <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('submit')}"></td>
						<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
							<input type="submit" class="clsSubmitButton clsMediumSubmitButton" name="add_sub_category" id="add_sub_category" tabindex="{smartyTabIndex}" value="{if  $myobj->getFormField('sub_cat_id')} {$LANG.category_update_sub} {else} {$LANG.category_add_sub} {/if}" />&nbsp;
							<input type="submit" class="clsCancelButton cancel" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" />
						</td>
				   </tr>
				</table>
				{$myobj->populateHiddenFormFields($myobj->form_add_sub_category.hidden_array)}
				</form>
			</div>
			{if $CFG.feature.jquery_validation}
		    	{literal}
					<script language="javascript" type="text/javascript">
						$Jq("#formAddCategory").validate({
							rules: {
								parent_id: {
									required: true
							    },
							    category: {
									required: true
							    }
							},
							messages: {
								parent_id: {
									required: {/literal}"{$LANG.common_err_tip_compulsory}"{literal}
								},
								category: {
									required: {/literal}"{$LANG.common_err_tip_compulsory}"{literal}
							    }
							}
						});
		        	</script>
		    	{/literal}
			{/if}
		{/if}
		{if  $myobj->isShowPageBlock('form_view_category')}
			<!-- Confirmation Div -->
			<div id="selMsgConfirm" class="selMsgConfirm" style="display:none;">
				<form name="formConfirm" id="formConfirm" method="post" action="discussionCategory.php" autocomplete="off">
				<p id="confirmMessage"></p>
				<table class="clsCommonTable" summary="{$LANG.category_confirm_tbl_summary}">
					<tr>
						<td>
							<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" value="{$LANG.common_confirm}" tabindex="{smartyTabIndex}" /> &nbsp;
							<input type="button" class="clsCancelButton cancel" name="cancel" id="cancel" value="{$LANG.common_cancel}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks('formViewCategory');" />
							<input type="hidden" name="cat_ids" />
							<input type="hidden" name="action" />
						</td>
					</tr>
				</table>
				{$myobj->populateHidden($paging_arr)}
				</form>
			</div>

			<div id="selViewLinks">
				<form name="formViewCategory" id="formViewCategory" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off">
					{if !$myobj->form_view_category.showCategory.RecordCount}
						<div id="selMsgAlert">
								<p>{$LANG.no_categories_found}</p>
						</div>
					{else}
						{if $CFG.admin.navigation.top}
							{include file='pagination.tpl'}
						{/if}
						<table class="clsCommonTable clsCategoryTable" cellpadding="0" summary="{$LANG.category_view_tbl_summary}">
						<tr>
							<th>&nbsp;<input type="checkbox" name="checkall" id="checkall" tabindex="{smartyTabIndex}" onclick="selectAll(this.form)"/></th>
							<th class="clsBoards{$myobj->getOrderCss('cat_name')} clsCatName"><a href="#" onclick="return changeOrderbyElements('formViewCategory','cat_name')">{$LANG.category_name}</a></th>
							<th class="clsBoards{$myobj->getOrderCss('cat_name')}">{$LANG.sub_category_count}</th>
							<th class="clsBoards{$myobj->getOrderCss('total_discussions')}"><a href="#" onclick="return changeOrderbyElements('formViewCategory','total_discussions')">{$LANG.category_board_count}</a></th>
							<th class="clsBoards{$myobj->getOrderCss('disporder')}"><a href="#" onclick="return changeOrderbyElements('formViewCategory','disporder')">{$LANG.category_disporder}</a></th>
							<th class="clsBoards{$myobj->getOrderCss('status')}"> <a href="#" onclick="return changeOrderbyElements('formViewCategory','status')">{$LANG.common_status}</a></th>
							<th class="clsBoards{$myobj->getOrderCss('date_added')}"><a href="#" onclick="return changeOrderbyElements('formViewCategory','date_added')">{$LANG.common_date_added}</a></th>
							<th class="clsBoards{$myobj->getOrderCss('restricted')}"><a href="#" onclick="return changeOrderbyElements('formViewCategory','restricted')">{$LANG.is_restricted}</a></th>
							<th>{$LANG.discuzz_common_manage}</th>
						</tr>
						{foreach key=inc item=value from=$myobj->form_view_category.showCategory.row}
							<tr>
								<td>
									<input type="checkbox" name="cat_ids[]" value="{$value.record.cat_id}" onClick="disableHeading('formViewCategory');" tabindex="{smartyTabIndex}" />
								</td>
								<td class="clsCatName"><a href="{$value.discussionCategory_mode_url}"><span id="catNameDiv{$value.record.cat_id}">{$value.record.cat_name}</span></a></td>
								<td class="clsClearFix"><span id="subcat{$value.record.cat_id}" class="clsTotalSub">{$value.subcategory_count}</span>
									<p class="clsAddSub"><span><a id="{$value.linkid}" onclick="return openCategoryAjaxWindow('{$value.add_subcategory_link}');" href="#" title="{$LANG.click_here_to_add_sub_category}">{$LANG.common_add}</a></span></p>
								</td>
								<td>{$value.total_discussions}</td>
								<td class="{$value.record.disporder_formfieldclass}"><input type="text" class="clsTextBox clsSmallTextBox {$value.record.disporder_elementclass}" name="catid_{$value.record.cat_id}" id="catid_{$value.record.cat_id}" tabindex="{smartyTabIndex}" value="{$value.record.disporder}" maxlength="2" /></td>
								<td>{$value.record.status}</td>
								<td>{$value.record.date_added}</td>
								<td><span id="restrict_{$value.record.cat_id}">{$value.record.restricted}</span></td>
								<td class="clsEditGroupLinks"><a id="{$value.linkid}" onclick="return openCategoryAjaxWindow('{$value.discussionCategory_url}');" href="#">{$LANG.common_edit}</a></td>
							</tr>
						{/foreach}

						<tr>
							<td colspan="4"></td>
							<td><input type="submit" class="clsSubmitButton" name="update_order" id="update_order" value="{$LANG.category_update_order}" tabindex="{smartyTabIndex}" /></td>
							<td colspan="4" class="clsButtonAlignment {$myobj->getCSSFormFieldCellClass('action')}">
								<select name="action" id="action" tabindex="{smartyTabIndex}" >
								{foreach key=inc item=value from=$myobj->form_view_category.showCategory.populateFilterList}
									<option value="{$value.key}" {$value.selected_chk}>{$value.name}</option>
								{/foreach}
								</select>
								<a href="#" id="dAltMlti"></a>
								<input type="button" class="clsSubmitButton" name="category_action" id="category_action" onclick="getMultiCheckBoxValue('formViewCategory', 'checkall', '{$LANG.category_err_tip_select_category}');if(multiCheckValue!='') getAction()" value="{$LANG.common_submit}" tabindex="{smartyTabIndex}" />
							</td>
						</tr>
					</table>
				{/if}
				{$myobj->populateHidden($paging_arr)}
				{if $CFG.admin.navigation.bottom}
	   				 	{include file='pagination.tpl'}
   	 			{/if}
			</form>
		</div>

	{/if}

	{if  $myobj->isShowPageBlock('form_view_sub_category')}
		<!-- Confirmation Div -->
		<div id="selMsgConfirm" class="selMsgConfirm" style="display:none;">
			<form name="formConfirm" id="formConfirm" method="post" action="discussionCategory.php?cat_id={$myobj->getFormField('cat_id')}" autocomplete="off">
			<p id="confirmMessage"></p>
			<table class="clsCommonTable" summary="{$LANG.category_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" value="{$LANG.common_confirm}" tabindex="{smartyTabIndex}" /> &nbsp;
						<input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="{$LANG.common_cancel}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks('formViewCategory');" />
						<input type="hidden" name="cat_ids" />
						<input type="hidden" name="action" />
					</td>
				</tr>
			</table>
			{$myobj->populateHiddenFormFields($myobj->form_view_sub_category.hidden_array)}
			</form>
		</div>
		<div id="selViewLinks">
		<form name="formViewCategory" id="formViewCategory" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off">
				{$myobj->populateHidden($paging_arr)}
			{if !$myobj->form_view_sub_category.showSubCategory.RecordCount}
				<div id="selMsgAlert">
					<p>{$LANG.no_categories_found}</p>
				</div>
			{else}
				{if $CFG.admin.navigation.top}
						{include file='pagination.tpl'}
				{/if}
					<table class="clsCommonTable clsCategoryTable"cellpadding="0" summary="{$LANG.category_view_tbl_summary}">
						<tr>
							<th>&nbsp;<input type="checkbox" name="checkall" id="checkall" tabindex="{smartyTabIndex}" onclick="selectAll(this.form)"/></th>
							<th class="clsBoards{$myobj->getOrderCss('cat_name')} clsCatName"><a href="#" onclick="return changeOrderbyElements('formViewCategory','cat_name')">{$LANG.category_sub_name}</a></th>
							<th class="clsBoards">{$LANG.sub_category_count}</th>
							<th class="clsBoards{$myobj->getOrderCss('total_discussions')}"><a href="#" onclick="return changeOrderbyElements('formViewCategory','total_discussions')">{$LANG.category_board_count}</a></th>
							<th class="clsBoards{$myobj->getOrderCss('status')}"><a href="#" onclick="return changeOrderbyElements('formViewCategory','status')">{$LANG.common_status}</a></th>
							<th class="clsBoards{$myobj->getOrderCss('date_added')}"><a href="#" onclick="return changeOrderbyElements('formViewCategory','date_added')">{$LANG.common_date_added}</a></th>
							<th class="clsBoards{$myobj->getOrderCss('restricted')}"><a href="#" onclick="return changeOrderbyElements('formViewCategory','restricted')">{$LANG.is_restricted}</a></th>
							<th>{$LANG.discuzz_common_manage}</th>
						</tr>
					{foreach key=inc item=value from=$myobj->form_view_sub_category.showSubCategory.row}
							<tr>
								<td>
									<input type="checkbox" name="cat_ids[]" value="{$value.record.cat_id}" onClick="disableHeading('formViewCategory');" tabindex="{smartyTabIndex}" />
								</td>
								<td class="clsCatName"><a class="clsEditGroupLink" href="{$value.discussionCategory_mode_url}"><span id="catNameDiv{$value.record.cat_id}">{$value.record.cat_name}</span></a></td>
								<td class="clsClearFix"><span id="subcat{$value.record.cat_id}" class="clsTotalSub">{$value.subcategory_count}</span>
									<p class="clsAddSub"><span><a id="{$value.linkid}" onclick="return openCategoryAjaxWindow('{$value.add_subcategory_link}');" href="#">{$LANG.common_add}</a></span></p>
								</td>
								<td>{$value.total_discussions}</td>
								<td>{$value.record.status}</td>
								<td>{$value.record.date_added}</td>
								<td><span id="restrict_{$value.record.cat_id}">{$value.record.restricted}</span></td>
								<td class="clsEditGroupLinks"><a id="{$value.linkid}" onclick="return openCategoryAjaxWindow('{$value.discussionCategory_url}');" href="#">{$LANG.common_edit}</a></td>
							</tr>
					{/foreach}
						<tr>
							<td colspan="8"  class="clsButtonAlignment {$myobj->getCSSFormFieldCellClass('action')}">
								<select name="action" id="action" tabindex="{smartyTabIndex}" >
								{foreach key=inc item=value from=$myobj->form_view_sub_category.showSubCategory.populateFilterList}
									<option value="{$value.key}" {$value.selected_chk}>{$value.name}</option>
								{/foreach}
								</select>
								<a href="#" id="dAltMlti"></a>
								<input type="button" class="clsSubmitButton" name="category_action" id="category_action" onclick="{$myobj->form_view_sub_category.showSubCategory.getMultiCheckBoxValue}" value="{$LANG.common_submit}" tabindex="{smartyTabIndex}" />
							</td>
						</tr>
					</table>

				{if $CFG.admin.navigation.bottom}
					 {include file='pagination.tpl'}
				{/if}
			{/if}

		</form>
	</div>

	{/if}
{if !isAjax()}
</div>
</div>
{/if}
{if  $myobj->isShowPageBlock('form_add_subcategory')}

		<div id="subCategoryPopup">
			<h2>{$categoryName}</h2>
			<form name="formSubLevel" id="formSubLevel" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off" onSubmit="return false; $('add_category').click();">
				<table class="clsCommonTable" summary="{$LANG.category_add_tbl_summary}">
					   <tr>
							<td class="{$myobj->getCSSFormLabelCellClass('category')}"><label for="category">{$LANG.category_name}</label>&nbsp;*&nbsp;</td>
							<td class="{$myobj->getCSSFormFieldCellClass('category')}"><input type="text" class="clsTextBox {$myobj->getCSSFormFieldElementClass('category')}" name="category" id="category" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('category')}" maxlength="60" />{$myobj->getFormFieldElementErrorTip('category')}
							{$myobj->ShowHelpTip('discussions_category', 'category')}
							<span id="validReply"></span>
							</td>
					   </tr>
					   <tr>
							<td class="{$myobj->getCSSFormLabelCellClass('description')}"><label for="description">{$LANG.category_description_title}</label>&nbsp;*&nbsp;</td>
							<td class="{$myobj->getCSSFormFieldCellClass('description')}">
							<textarea name="description" id="description" class="clsTextArea" tabindex="{smartyTabIndex}" cols="23" rows="5" maxlength="{$CFG.admin.description.limit}">{$myobj->getFormField('description')}</textarea>
							{$myobj->getFormFieldElementErrorTip('description')}
							</td>
				   		</tr>
					   <tr>
							<td class="{$myobj->getCSSFormLabelCellClass('is_restricted')}"><label for="is_restricted">{$LANG.restrict_allowed}</label>&nbsp;*&nbsp;</td>
							<td class="{$myobj->getCSSFormFieldCellClass('is_restricted')}">
							<input type="radio" name="is_restricted" id="restricted_yes" value="Yes" {$myobj->isCheckedRadio('is_restricted', 'Yes')} tabindex="{smartyTabIndex}" /><label for="restricted_yes">{$LANG.common_yes_option}</label>
                        	<input type="radio" name="is_restricted" id="restricted_no" value="No" {$myobj->isCheckedRadio('is_restricted', 'No')} tabindex="{smartyTabIndex}" /><label for="restricted_no">{$LANG.common_no_option}</label>
							{$myobj->getFormFieldElementErrorTip('is_restricted')}
							</td>
				   		</tr>
					   <tr>
					   		<td class="{$myobj->getCSSFormLabelCellClass('submit')}"></td>
							<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
								{if $myobj->getFormField('sub_cat_id') neq 0}
									<input type="button" class="clsSubmitButton clsMediumSubmitButton" name="add_category" id="add_category" tabindex="{smartyTabIndex}" value="{$LANG.category_add}" onclick="ajaxSubmitSubLevelForm('discussionCategory.php?mode=editSubLevel', 'formSubLevel', 'subCategoryPopup')" />&nbsp;
								{else}
									<input type="button" class="clsSubmitButton clsMediumSubmitButton" name="add_category" id="add_category" tabindex="{smartyTabIndex}" value="{$LANG.category_add}" onclick="ajaxSubmitSubLevelForm('discussionCategory.php?mode=addSubLevel', 'formSubLevel', 'subCategoryPopup')" />&nbsp;
								{/if}
								<input type="button" class="clsCancelButton cancel" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" onclick="return hideAllBlocks();" />
							</td>
					   </tr>
					</table>
					<input type="hidden" name="parent_id" value="{$myobj->getFormField('cat_id')}">
					<input type="hidden" name="sub_cat_id" value="{$myobj->getFormField('sub_cat_id')}">
				</form>
			</div>
			{if $CFG.feature.jquery_validation}
		    	{literal}
					<script language="javascript" type="text/javascript">
						$Jq("#formSubLevel").validate({
							rules: {
								category: {
									required: true
							    },
							    description: {
									required: true
							    }
							},
							messages: {
								category: {
									required: {/literal}"{$LANG.common_err_tip_compulsory}"{literal}
								},
								description: {
									required: {/literal}"{$LANG.common_err_tip_compulsory}"{literal}
							    }
							}
						});
		        	</script>
		    	{/literal}
			{/if}
{/if}
{if  $myobj->isShowPageBlock('sublevel_msg_block')}
	<div id="subLevelDiv">
		<h2>{$categoryName}</h2>
		<div class="">
			<p>{$LANG.subcategory_success_message}</p>
		</div>
		<table class="clsCommonTable" summary="{$LANG.category_add_tbl_summary}">
	 	    <tr>
			   	<td class="{$myobj->getCSSFormLabelCellClass('submit')}"><a href="#" onclick="ajaxUpdateDiv('{$myobj->add_category_link}', '', 'subCategoryPopup');">{$LANG.add_subcategory_caption}</a></td>
		  	</tr>
		</table>
	</div>
{/if}
{if  $myobj->isShowPageBlock('form_edit_category_ajax')}
	<div id="addCategoryPopup">
		<h2>{$categoryName}</h2>
		<form name="formCatLevel" id="formCatLevel" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off" onSubmit="return false; $('add_category').click();">
			<table class="clsCommonTable" summary="{$LANG.category_add_tbl_summary}">
			   <tr>
					<td class="{$myobj->getCSSFormLabelCellClass('category')}"><label for="category">{$LANG.category_name}</label>&nbsp;*&nbsp;</td>
					<td class="{$myobj->getCSSFormFieldCellClass('category')}"><input type="text" class="clsTextBox {$myobj->getCSSFormFieldElementClass('category')}" name="category" id="category" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('category')}" maxlength="60" />{$myobj->getFormFieldElementErrorTip('category')}
					{$myobj->ShowHelpTip('discussions_category', 'category')}
					<span id="validReply"></span>
					</td>
			   </tr>
			   <tr>
					<td class="{$myobj->getCSSFormLabelCellClass('description')}"><label for="description">{$LANG.category_description_title}</label>&nbsp;*&nbsp;</td>
					<td class="{$myobj->getCSSFormFieldCellClass('description')}">
					<textarea name="description" id="description" class="clsTextArea" tabindex="{smartyTabIndex}" cols="23" rows="5" maxlength="{$CFG.admin.description.limit}">{$myobj->getFormField('description')}</textarea>
					{$myobj->getFormFieldElementErrorTip('description')}
					</td>
		   		</tr>
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('is_restricted')}"><label for="is_restricted">{$LANG.restrict_allowed}</label>&nbsp;*&nbsp;</td>
					<td class="{$myobj->getCSSFormFieldCellClass('is_restricted')}">
					<input type="radio" name="is_restricted" id="restricted_yes" value="Yes" {$myobj->isCheckedRadio('is_restricted', 'Yes')} tabindex="{smartyTabIndex}" /><label for="restricted_yes">{$LANG.common_yes_option}</label>
					<input type="radio" name="is_restricted" id="restricted_no" value="No" {$myobj->isCheckedRadio('is_restricted', 'No')} tabindex="{smartyTabIndex}" /><label for="restricted_no">{$LANG.common_no_option}</label>
					{$myobj->getFormFieldElementErrorTip('is_restricted')}
					</td>
				</tr>
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('submit')}"></td>
					<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
					<input type="button" class="clsSubmitButton clsMediumSubmitButton" name="add_category" id="add_category" tabindex="{smartyTabIndex}" value="{$LANG.category_add}" onclick="ajaxSubmitSubLevelForm('discussionCategory.php?mode=editParentCategory', 'formCatLevel', 'addCategoryPopup')" />&nbsp;
					<input type="button" class="clsCancelButton cancel" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" onclick="return hideAllBlocks();" />
					</td>
				</tr>
			</table>
			<input type="hidden" name="cat_id" value="{$myobj->getFormField('cat_id')}">
		</form>
	</div>
	{if $CFG.feature.jquery_validation}
    	{literal}
			<script language="javascript" type="text/javascript">
				$Jq("#formCatLevel").validate({
					rules: {
						category: {
							required: true
					    },
					    description: {
							required: true
					    }
					},
					messages: {
						category: {
							required: {/literal}"{$LANG.common_err_tip_compulsory}"{literal}
						},
						description: {
							required: {/literal}"{$LANG.common_err_tip_compulsory}"{literal}
					    }
					}
				});
        	</script>
    	{/literal}
	{/if}
{/if}