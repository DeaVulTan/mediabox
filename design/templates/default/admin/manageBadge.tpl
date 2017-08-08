<div id="selContactUs">
  <h2>{$LANG.manage_badge_title}</h2>
  

  {$myobj->setTemplateFolder('admin/')}
{include file="information.tpl"}						
							  
  {if $myobj->isShowPageBlock('block_manage_badge')}
      <form name="selmanageBadgeForm" id="selmanageBadgeForm" method="post" action="{$myobj->getCurrentUrl()}">
	  
		  <table class="clsFormTable clsNoBorder" summary="{$LANG.manage_badge_table_summary}">
		  	<tr>
				<td class="clsWidthSmall">
					{$myobj->getFormFieldErrorTip('company_name')}
					<label for="company_name">{$LANG.manage_badge_companyname}</label>
				</td>
				<td>
					<input type="text" class="clsTextBox" name="company_name" id="company_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('company_name')}" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table class="clsFormTable clsManageBadge clsNoBorder" summary="{$LANG.manage_badge_table_summary}">
					<tr>
						<td>
							{$myobj->getFormFieldErrorTip('item')}
							<label for="company_name">{$LANG.manage_badge_item}</label>
						</td>
						<td>
							<select name="item_left" id="item_left" style="width: 200px;" size="20" multiple>
							{foreach key=key item=value from=$item_left}
    							<option value="{$key}">{$value}</option>
  							{/foreach}

							</select>
						</td>
						<td>
							<input name="for" type="button" class="clsSubmitButton clsSelectButton" value=" --> " onclick="addlist('item_left','item_right');" /><br /><br />
							<input name="bac" type="button" class="clsSubmitButton clsDeselectButton" value=" <-- " onclick="addlist('item_right','item_left');" /><br />						
						</td>
						<td>
							<select name="item_right" id="item_right" style="width: 200px;" size="20" multiple>
							{foreach key=key item=item from=$item}
    							<option value="{$key}">{$item}</option>
  							{/foreach}
							</select>						
						</td>						
					</tr>
					</table>					
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" class="clsSubmitButton" name="badge_update" id="badge_update" tabindex="{smartyTabIndex}" value="{$LANG.manage_badge_update_submit}" onclick=" return setValues();" />
					<input type="hidden" name="item" value="" />
					<input type="hidden" name="badge_id" value="{$myobj->getFormField('badge_id')}" />
				</td>
				
			</tr>
			</table>
			
	  </form>
  {/if}
</div>