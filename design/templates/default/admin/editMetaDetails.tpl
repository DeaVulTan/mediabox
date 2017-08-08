<div id="selHelpLangEdit">
	<div id="selManageLaguageFile">
    	<h2>{$LANG.langedit_lang_editing}</h2>
    	{include file="information.tpl"}
		{if $myobj->isShowPageBlock('form_edit_phrases')}
    	<div id="selEditForm">
      		<form name="editFrm" id="editFrm" method="post" action="{$myobj->getCurrentUrl(false)}">
        		<table class="clsFormSection clsNoBorder">
          			<tr>
            			<th class="clsFormLabelCellDefault">{$LANG.langedit_variable_name}</th>
            			<th class="clsFormFieldCellDefault">{$LANG.langedit_new_value}</th>
          			</tr>
          			{foreach key=key item=value from=$myobj->form_edit_phrases.LANG}
          			<tr>
            			<td class="clsWidthMedium {$myobj->getCSSFormLabelCellClass('varable')}">
              				<label for="{$key}">{$key}</label>
            			</td>
            			<td class="{$myobj->getCSSFormFieldCellClass('phrase')}">
              				<textarea name="{$key}" id="{$key}" tabindex="{smartyTabIndex}" rows="3" cols="50">{$myobj->stripslashesNew($value)}</textarea>
            			</td>
          			</tr>
          			{/foreach}
          			<tr>
            			<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('submit')}">
              				<input type="submit" class="clsSubmitButton" name="submit_phrases" id="selSubmitPhrases" value="{$LANG.langedit_update}" tabindex="{smartyTabIndex}" />
			  				<input type="submit" class="clsCancelButton" name="cancel_submit" id="cancel_submit" value="{$LANG.langedit_cancel_submit}" tabindex="{smartyTabIndex}" />
            			</td>
          			</tr>
        		</table>
      		</form>
    	</div>
		{/if}
  	</div>
</div>