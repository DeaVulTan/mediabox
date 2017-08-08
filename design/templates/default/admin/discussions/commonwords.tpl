<div id="selEditableMessages">
	<h2 class="clsManageStaticPageHeading">{$LANG.commonwords_title}</h2>
	{include file='information.tpl'}
	{if $myobj->isShowPageBlock('form_commonwords')}
		<form name="commonwordsfrm" id="commonwordsfrm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
			<table summary="{$LANG.editable_messages_tbl_summary}" class="clsStaticContentTbl">
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('common_words')}"><label for="common_words">{$LANG.discuzz_commonwords_caption}</label></td>
					<td class="{$myobj->getCSSFormFieldCellClass('common_words')}">
						<textarea name="common_words" id="common_words" tabindex="{smartyTabIndex}">{$myobj->getCommonWordList()}</textarea>
					</td>
  		       </tr>
			   <tr>
               <td>&nbsp;</td>
		   			<td><input type="submit" class="clsSubmitButton" name="words_submit" id="add_hot_searches" tabindex="{smartyTabIndex}" value="{$LANG.common_update}" />
				</tr>
			</table>
		</form>
	{/if}
</div>