{if !isAjaxPage()}
	<div id="tabsview">
		<ul>
			{foreach key=cakey item=cavalue from=$myobj->cname_array}
				{assign var="label_name" value="config_data_$cakey"}
				{if $CFG.user.usr_access == 'Admin'}
					<li><a href="{$myobj->getCurrentUrl(false)}?cname={$cakey}&module={$myobj->module}">{$LANG.$label_name}</a></li>
				{/if}
			{/foreach}
		</ul>
	</div>
{else}
	<div id="seldevManageConfig">
		<div>
	  		<h2>{$LANG.editconfigdata_title}</h2>
			{$myobj->setTemplateFolder('admin/')}
			{include file="information.tpl"}
			{if $myobj->isShowPageBlock('block_config_edit')}
				<div class="clsDataTable">
					{assign var="c_name" value=$myobj->getFormField('cname')}
					<form name="form_editconfig_{$myobj->getFormField('cname')}" id="form_editconfig_{$myobj->getFormField('cname')}" method="post" action="{$myobj->getCurrentUrl(false)}" onsubmit="" autocomplete="off">
				        <table summary="{$LANG.editconfigdata_tbl_summary}">
				        	{foreach key=cvkey item=cvvalue from=$myobj->block_config_edit.populateConfig}
				        		{if $cvvalue.config_section}
						        	<tr>
						        		<th colspan="2">{$cvvalue.config_section}</td>
									</tr>
				        		{/if}
							   	<tr>
									<td class="{$myobj->getCSSFormLabelCellClass('dim1')}">
										{if $cvvalue.config_type eq 'Boolean'}
											<label for="{$cvvalue.label_id}1">{$cvvalue.description}</label>
										{else}
											<label for="{$cvvalue.label_id}">{$cvvalue.description}</label>
										{/if}
									</td>
									<td class="{$myobj->getCSSFormFieldCellClass('dim1')}">
										{if $cvvalue.config_type eq 'Boolean'}
											<input type="radio" name="{$cvvalue.label_id}" id="{$cvvalue.label_id}1" tabindex="{smartyTabIndex}" value="1" {$myobj->isCheckedRadio($cvvalue.label_id, '1')} /> <label for="{$cvvalue.label_id}1">{$LANG.common_yes_option}</label>
											<input type="radio" name="{$cvvalue.label_id}" id="{$cvvalue.label_id}0" tabindex="{smartyTabIndex}" value="0" {$myobj->isCheckedRadio($cvvalue.label_id, '0')} /> <label for="{$cvvalue.label_id}0">{$LANG.common_no_option}</label>
					                    {else}
					                    	<input type="text" class="clsTextBox" name="{$cvvalue.label_id}" id="{$cvvalue.label_id}" tabindex="{smartyTabIndex}" value="{$myobj->getFormField($cvvalue.label_id)}" />
					                    {/if}
					                    {$myobj->getFormFieldErrorTip($cvvalue.label_id)}
					                    {if $cvvalue.help_text}
					                    	{$myobj->ShowHelpTip($cvvalue.help_text,$cvvalue.label_id)}
					                    {/if}
					                </td>
							   	</tr>
						   	{/foreach}
						   	<tr>
								<td class="{$myobj->getCSSFormFieldCellClass('submit')}" colspan="2">
									<input type="submit" class="clsSubmitButton" name="add_submit" id="add_submit" tabindex="{smartyTabIndex}" value="{$LANG.common_update}" onClick="$Jq('#act_{$myobj->getFormField('cname')}').val('add_submit'); return postAjaxForm('form_editconfig_{$myobj->getFormField('cname')}', 'ui-tabs-{$myobj->cname_array.$c_name}')" />
								</td>
							</tr>
						</table>
						<input type="hidden" name="cname" value="{$myobj->getFormField('cname')}" />
						<input type="hidden" name="module" value="{$myobj->getFormField('module')}" />
						<input type="hidden" name="act" id="act_{$myobj->getFormField('cname')}" value="" />

					</form>
			   	</div>
			{/if}
		</div>
	</div>
{/if}