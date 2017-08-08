<div id="selLanguageDefault">
	<h2>{$LANG.page_title}</h2>
	{$myobj->setTemplateFolder('admin/')}
	{include file="information.tpl"}
	{if $myobj->isShowPageBlock('block_language_default')}
	<form name="formLanguageDefault" id="formLanguageDefault" method="post" action="{$myobj->getCurrentUrl(true)}">
		    <!-- clsFormSection - starts here -->
    {include file='../general/box.tpl' opt='form_top'}
    <table class="clsFormSection clsNoBorder">

			<tr class="clsFormRow">
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('language')}"><label for="language">{$LANG.set_default_language_list}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('language')}">{$myobj->getFormFieldErrorTip('language')}
					<select name="language" id="language" tabindex="{smartyTabIndex}">
		  				{foreach key=key item=value from=$smarty_available_languages}
						<option value="{$key}" {if $key eq $myobj->getFormField('language')}selected="selected"{/if}>{$value}</option>
		  				{/foreach}
        			</select>
                    <input type="hidden" name="folder" id="folder" value="all" />
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormFieldCellClass('default')}"><input type="submit" class="clsSubmitButton" name="add_submit" id="add_submit" tabindex="{smartyTabIndex}" value="{$LANG.set_default_language_submit}" /></td>
			</tr>
		</table>
    {include file='../general/box.tpl' opt='form_bottom'}
    <!-- clsFormSection - ends here -->
	</form>
	{/if}
</div>