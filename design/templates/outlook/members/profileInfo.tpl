{if $myobj->block_show_htmlfields}
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selProfileOtherInfo">
	<div class="clsPageHeading"><h2>{$myobj->page_title}</h2></div>
    {$myobj->setTemplateFolder('general/')}
	{include file='information.tpl'}
	{if $myobj->isShowPageBlock('block_show_htmlfields')}
	<div class="clsDataTable clsProfileInfoTable">
	    <form name="selFormEditOtherInfoProfile" id="selFormEditOtherInfoProfile" method="post" action="" autocomplete="off">
	    <div id="selUploadBlock">
	    <table>
	     {foreach key=inc item=value from=$myobj->block_show_htmlfields}
	     {if $value.question_type=='text'}
	     <tr>
	     	<td class="{$value.label_cell_class}"><label for="{$value.id}">{$value.question}</label></td>
	        <td class="{$value.field_cell_class}">
	        <input type="text" class="clsTextBox" name="{$value.id}" id="{$value.question}" tabindex="{smartyTabIndex}" value="{$value.answer_result}" maxlength="{$value.max_length}" style="{$value.width}"/>
	        {$myobj->getFormFieldErrorTip($value.id)}
	        <div class="clsHelpText" id="{$value.id}_Help" style="visibility:hidden">{$value.instruction}</div>
	        </td>
	     </tr>
	     {/if}
	     {if $value.question_type=='textarea'}
	     <tr>
	        <td class="{$value.label_cell_class}"><label for="{$value.id}">{$value.question}</label></td>
	        <td class="{$value.field_cell_class}">
	        <textarea name="{$value.id}" id="{$value.id}" tabindex="{smartyTabIndex}" rows="{$value.rows}" style="{$value.width}" class="selInputLimiter" maxlimit="{$CFG.fieldsize.profile.info_description}" maxlength="50"/>{$value.answer_result}</textarea>
	        {$myobj->getFormFieldErrorTip($value.id)}
	        <div class="clsHelpText" id="{$value.id}_Help" style="visibility:hidden">{$value.instruction}</div>
	        </td>
	     </tr>
	     {/if}
	     {if $value.question_type=='password'}
	     <tr>
	        <td class="{$value.label_cell_class}"><label for="{$value.id}">{$value.question}</label></td>
	        <td class="{$value.field_cell_class}">
	        <input type="password" class="clsTextBox" name="{$value.id}" id="{$value.question}" tabindex="{smartyTabIndex}" value="{$value.answer_result}" maxlength="{$value.max_length}"/>
	        {$myobj->getFormFieldErrorTip($value.id)}
	        <div class="clsHelpText" id="{$value.id}_Help" style="visibility:hidden">{$value.instruction}</div>
	        </td>
	     </tr>
	     {/if}
	     {if $value.question_type=='radio'}
	     <tr>
	        <td class="{$value.label_cell_class}"><label for="opt_{$value.id}">{$value.question}</label></td>
	        <td class="{$value.field_cell_class} clsCheckBoxList">
	        {foreach key=ssokey item=ssovalue from=$value.option_arr}
	        	<p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" id="opt_{$value.id}_{$ssokey}" name="{$value.id}"  {$value.$ssovalue} value="{$ssovalue}"  tabindex="{smartyTabIndex}" /></span><label for="opt_{$value.id}_{$ssokey}">{$ssovalue}{$value.display}</label></p>
	        {/foreach}
	        {$myobj->getFormFieldErrorTip($value.id)}
	        <div class="clsHelpText" id="opt_{$value.id}_Help" style="visibility:hidden">{$value.instruction}</div>
	        </td>
	     </tr>
	     {/if}
	     {if $value.question_type=='checkbox'}
	     <tr>
	        <td class="{$value.label_cell_class}"><label>{$value.question}</label></td>
	        <td class="{$value.field_cell_class} clsCheckBoxList" align="left">
	        {foreach key=ssokey item=ssovalue from=$value.option_arr}
	        	<p><span class="clsCheckBox"><input type="checkbox" class="clsCheckRadio" id="opt_{$value.id}_{$ssokey}" name="{$value.id}[]"  {$value.checked.$ssokey} value="{$ssovalue}"  tabindex="{smartyTabIndex}" /></span><label for="opt_{$value.id}_{$ssokey}">{$ssovalue}{$value.display}</label></p>
	        {/foreach}
	        {$myobj->getFormFieldErrorTip($value.id)}
	        <div class="clsHelpText" id="opt_{$value.id}_Help" style="visibility:hidden">{$value.instruction}</div>
	        </td>
	     </tr>
	     {/if}
	     {if $value.question_type=='select'}
	     <tr>
	        <td class="{$value.label_cell_class}"><label for="{$value.id}">{$value.question}</label></td>
	        <td class="{$value.field_cell_class}">
	        <select name="{$value.id}" id="{$value.id}" tabindex="{smartyTabIndex}">
	           <option value="">Select</option>
	          {$myobj->generalPopulateArray($value.option_arr,$value.answer_result)}
	        </select>
	        {$myobj->getFormFieldErrorTip($value.id)}
	        <div class="clsHelpText" id="{$value.id}_Help" style="visibility:hidden">{$value.instruction}</div>
	        </td>
	     </tr>
	     {/if}
	     {/foreach}
	     <tr>
		 	<td>&nbsp;</td>
	        <td class="{$myobj->getCSSFormFieldCellClass('update_submit')}"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="update_submit" id="update_submit" tabindex="{smartyTabIndex}" value="{$LANG.common_update}" /></div></div></td>
	     </tr>
	    </table>
	    </div>
	    </form>
	</div>
	{/if}
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
{/if}