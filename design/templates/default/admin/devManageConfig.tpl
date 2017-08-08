{if isAjaxPage()}
	{if $myobj->isShowPageBlock('block_config_section')}
		<div class="clsDownArrow"><!--<a href="#">{$LANG.common_select_option}</a>--></div>
		<ul class="clsSubLists">
			{foreach key=pskey item=psvalue from=$myobj->block_config_section.populateSectionList}
				<li><a href="#" onClick="changeConfigSection('{$psvalue}');return false;">{$psvalue|ucwords}</a></li>
			{/foreach}
		</ul>
	{/if}
{else}
<div id="seldevManageConfig">
	<div>
  		<h2>{$LANG.devmanageconfig_title}</h2>
		{$myobj->setTemplateFolder('admin/')}
		{include file="information.tpl"}
		{if $myobj->isShowPageBlock('block_sql_display')}
			<div>{$myobj->return_sql}</div>
		{/if}
		{if $myobj->isShowPageBlock('block_config_list')}
			<p class="clsAddNewVariable"><a href="{$myobj->getCurrentUrl(false)}?act=add">{$LANG.devmanageconfig_add_new_variable}</a></p>
			<a name="toppage"></a>

            <div class="clsInputSelectDropDownList">
                <div class="clsDropDownInput"><div class="clsDuplicateInput">{$LANG.devmanageconfig_focus}</div></div>
                <div class="clsDownArrowContainer">
                    <ul>
                        <li class="selDropDownLinkClick">
                            <div class="clsDownArrow"><!--{$LANG.devmanageconfig_focus}--></div>
                            <ul class="clsSubLists">
                            {foreach key=pmckey item=pmcvalue from=$myobj->block_config_list.populateMainCategories}
                                <li><a href="#{$pmcvalue}">{$pmcvalue|ucwords}</a></li>
                            {/foreach}
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

			{if $myobj->block_config_list.populateConfig }
				<div>
					<table>
						<tr>
							<th>{$LANG.devmanageconfig_cfg_variable}</th>
							<th>{$LANG.devmanageconfig_config_type}</th>
							<th>{$LANG.devmanageconfig_config_category}</th>
							<th>{$LANG.devmanageconfig_config_section}</th>
							<th>{$LANG.devmanageconfig_config_section_order}</th>
							<th>{$LANG.devmanageconfig_editable}</th>
							<th>{$LANG.devmanageconfig_description}</th>
							<th>&nbsp</th>
						</tr>
					{foreach key=pckey item=pcvalue from=$myobj->block_config_list.populateConfig}
						{if $pcvalue.record.display_config_category}
							<tr>
								<th colspan="7" class="clsAddNewVariable">{$pcvalue.record.display_config_category} <span>|</span> 
									<a name="{$pcvalue.record.config_category}"></a>
									<a href="{$myobj->getCurrentUrl(false)}?act=add&config_category={$pcvalue.record.config_category}">{$LANG.devmanageconfig_add_new_variable}</a>
								</th>
								<th>
									<a href="#toppage">{$LANG.devmanageconfig_top}</a>
								</th>
							</tr>
						{/if}
						<tr class="{$pcvalue.css_class}">
							<td>
								{$pcvalue.display_var}
							</td>
							<td>
								{$pcvalue.record.config_type}
							</td>
							<td>
								{$pcvalue.record.config_category}
							</td>
							<td>
								{$pcvalue.record.config_section}
							</td>
							<td>
								{$pcvalue.record.config_section_order}
							</td>
							<td>
								{$pcvalue.record.editable}
							</td>
							<td>
								{$pcvalue.record.description}
							</td>
							<td>
								<span><a href="{$pcvalue.edit_url}">{$LANG.common_edit}</a></span>
								<span><a href="{$pcvalue.delete_url}">{$LANG.common_delete}</a></span>
							</td>
						</tr>
					{/foreach}
					</table>
				</div>
			{else}
		        <div id="selMsgAlert">
		        	<p>{$LANG.latestnews_no_records_found}</p>
		        </div>
		    {/if}
		{/if}
		{if $myobj->isShowPageBlock('block_config_add')}
			<div class="clsDataTable">
				<form name="form_addconfig" id="form_addconfig" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
			        <table summary="{$LANG.devmanageconfig_tbl_summary}">
					   	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('dim1')}">
								<label for="dim1">{$myobj->LANG.devmanageconfig_dim}1</label>
								{$myobj->displayCompulsoryIcon()}
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('dim1')}">
			                    <input type="text" class="clsTextBox" name="dim1" id="dim1" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('dim1')}" />
			                    {$myobj->getFormFieldErrorTip('dim1')}
			                </td>
					   	</tr>
					   	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('dim2')}">
								<label for="dim2">{$myobj->LANG.devmanageconfig_dim}2</label>
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('dim2')}">
			                    <input type="text" class="clsTextBox" name="dim2" id="dim2" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('dim2')}" />
			                    {$myobj->getFormFieldErrorTip('dim2')}
			                </td>
					   	</tr>
					   	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('dim3')}">
								<label for="dim3">{$myobj->LANG.devmanageconfig_dim}3</label>
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('dim3')}">
			                    <input type="text" class="clsTextBox" name="dim3" id="dim3" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('dim3')}" />
			                    {$myobj->getFormFieldErrorTip('dim3')}
			                </td>
					   	</tr>
					   	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('dim4')}">
								<label for="dim4">{$myobj->LANG.devmanageconfig_dim}4</label>
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('dim4')}">
			                    <input type="text" class="clsTextBox" name="dim4" id="dim4" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('dim4')}" />
			                    {$myobj->getFormFieldErrorTip('dim4')}
			                </td>
					   	</tr>
					   	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('config_type')}">
								<label for="config_type">{$myobj->LANG.devmanageconfig_config_type}</label>
								{$myobj->displayCompulsoryIcon()}
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('config_type')}">
			                    <select class="validate-selection" name="config_type" id="config_type" tabindex="{smartyTabIndex}">
			                    	{$myobj->generalPopulateArray($myobj->block_config_add.config_type_arr, $myobj->getFormField('config_type'))}
			                    </select>
			                    {$myobj->getFormFieldErrorTip('config_type')}
			                </td>
					   	</tr>
					   	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('config_value')}">
								<label for="config_value">{$myobj->LANG.devmanageconfig_config_value}</label>
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('config_value')}">
			                    <input type="text" class="clsTextBox" name="config_value" id="config_value" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('config_value')}" />
			                    {$myobj->getFormFieldErrorTip('config_value')}
			                </td>
					   	</tr>
					   	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('config_category')}">
								<label for="config_category">{$myobj->LANG.devmanageconfig_config_category}</label>
								{$myobj->displayCompulsoryIcon()}
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('config_category')}">
			                    <div class="clsInputSelectDropDownList">
                                    <div class="clsDropDownInput"><input type="text" class="clsTextBox" name="config_category" id="config_category" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('config_category')}" /></div>
                                    <div class="clsDownArrowContainer">
                                        <ul>
                                            <li class="selDropDownLinkClick">
                                                <div class="clsDownArrow"><!--{$LANG.devmanageconfig_focus}--></div>
                                                <ul class="clsSubLists">
                                                    {foreach key=pmckey item=pmcvalue from=$myobj->block_config_add.populateMainCategories}
                                                        <li><a href="#" onClick="changeConfigCategory('{$pmcvalue}');return false;">{$pmcvalue|ucwords}</a></li>
                                                    {/foreach}
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
			                    {$myobj->getFormFieldErrorTip('config_category')}
			                </td>
					   	</tr>
					   	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('config_section')}">
								<label for="config_section">{$myobj->LANG.devmanageconfig_config_section}</label>
								{$myobj->displayCompulsoryIcon()}
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('config_section')}">
                             	<div class="clsInputSelectDropDownList">
			                    	<div class="clsDropDownInput"><input type="text" class="clsTextBox" name="config_section" id="config_section" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('config_section')}" /></div>
                                    <div class="clsDownArrowContainer">
                                        <ul>
                                            <li class="selDropDownLinkClick" id="selConfigSectionList">
                                                <div class="clsDownArrow"><!--<a href="#">{$LANG.common_select_option}</a>--></div>
                                            </li>
			                    	</ul>
								</div>
			                    {$myobj->getFormFieldErrorTip('config_section')}
			                </td>
					   	</tr>
					   	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('config_section_order')}">
								<label for="config_section_order">{$myobj->LANG.devmanageconfig_config_section_order}</label>
								{$myobj->displayCompulsoryIcon()}
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('config_section_order')}">
			                    <input type="text" class="clsTextBox" name="config_section_order" id="config_section_order" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('config_section_order')}" />
			                    {$myobj->getFormFieldErrorTip('config_section_order')}
			                </td>
					   	</tr>
					   	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('editable')}">
								<label for="editable">{$myobj->LANG.devmanageconfig_editable}</label>
								{$myobj->displayCompulsoryIcon()}
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('editable')}">
			                    <input type="radio" name="editable" id="editable_no" tabindex="{smartyTabIndex}" value="No" {$myobj->isCheckedRadio('editable', 'No')} /> <label for="editable_no">{$LANG.common_no_option}</label>
			                    <input type="radio" name="editable" id="editable_yes" tabindex="{smartyTabIndex}" value="Yes" {$myobj->isCheckedRadio('editable', 'Yes')} /> <label for="editable_yes">{$LANG.common_yes_option}</label>
			                    {$myobj->getFormFieldErrorTip('editable')}
			                </td>
					   	</tr>
					   	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('edit_order')}">
								<label for="edit_order">{$myobj->LANG.devmanageconfig_edit_order}</label>
								{$myobj->displayCompulsoryIcon()}
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('edit_order')}">
			                    <input type="text" class="clsTextBox" name="edit_order" id="edit_order" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('edit_order')}" />
			                    {$myobj->getFormFieldErrorTip('edit_order')}
			                </td>
					   	</tr>
					   	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('description')}">
								<label for="description">{$myobj->LANG.devmanageconfig_description}</label>
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('description')}">
			                    <input type="text" class="clsTextBox" name="description" id="description" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('description')}" />
			                    {$myobj->getFormFieldErrorTip('description')}
			                </td>
					   	</tr>
					   	<tr>
							<td class="{$myobj->getCSSFormLabelCellClass('help_text')}">
								<label for="help_text">{$myobj->LANG.devmanageconfig_help_text}</label>
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('help_text')}">
			                    <input type="text" class="clsTextBox" name="help_text" id="help_text" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('help_text')}" />
			                    {$myobj->getFormFieldErrorTip('help_text')}
			                </td>
					   	</tr>
					   	<tr>
							<td class="{$myobj->getCSSFormFieldCellClass('submit')}" colspan="2">
								<input type="submit" class="clsSubmitButton" name="add_submit" id="add_submit" tabindex="{smartyTabIndex}" value="{if $myobj->isShowPageBlock('block_config_edit')}{$LANG.common_update}{else}{$LANG.common_add}{/if}" />
								<input type="submit" class="clsCancelButton" name="cancel_submit" id="cancel_submit" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" />
								<input type="hidden" name="cid" value="{$myobj->getFormField('cid')}" />
							</td>
						</tr>
					</table>
				</form>
		   	</div>
		{/if}
	</div>
</div>
{/if}