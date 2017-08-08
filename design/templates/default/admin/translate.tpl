<div class="clsCommonAdminTbl">
{if !isAjaxPage()}
<div id="selMsgConfirm" class="clsMsgAlert" style="display:none;">
    {include file='../general/box.tpl' opt='successrounded_top'}
    <form name="formConfirm" id="formConfirm" method="post" action="{$myobj->getCurrentUrl()}">
		<p id="selMsgContent"></p>
      	<table>
        	<tr>
          		<td>
					<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}"/>
					<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" onClick="return hideAllBlocks();" />
				</td>
        	</tr>
      	</table>
      	{$myobj->populateHidden($myobj->translateCommon.populate_hiden_array)}
    </form>
            {include file='../general/box.tpl' opt='successrounded_bottom'}
</div>

<div id="selAddNewsLetter" class="clsNewsTranslateMain">
     {include file='../general/box.tpl' opt='adminrounded_top'}
	<h2 class="clsManageAnswers">{$LANG.addletter_translation_title}</h2>
    {include file='../general/information.tpl'}
{/if}
	{if  $myobj->isShowPageBlock('form_folder_permission')}
		<div>
			<h3>Write permission</h3>
			<div>
				<table>
					<tr>
						<th>Name</th><th>File/Folder</th><th>Status</th>
					</tr>
					{if $myobj->form_folder_permission.chkIsWritableAll.output}
						{foreach key=inc item=value from=$myobj->form_folder_permission.chkIsWritableAll.row}
							<tr>
								<td>{$value.folder_name_file}</td>
								<td>{$value.folder_or_file}</td>
								<td>{$value.msg}</td>
							</tr>
						{/foreach}
					{/if}
				</table>
			</div>
			<form name="form_index" id="selFormIndex" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
				<input type="submit" name="showtrans" class="clsGoButton" id="showtrans" value="Next" />
			</form>
		</div>
	{/if}
	{if  $myobj->isShowPageBlock('form_lang_add')}
		<h3 class="clsAdminAddEditLink">{$LANG.addletter_add_language}</h3>
		<div id="selAddForm" class="clsAddFormTranslate">
			<form name="frmAddLanguage" id="frmAddLanguage" method="post" action="{$myobj->getCurrentUrl()}">
					{if $myobj->form_lang_add.getLanguageLists }
						<span><select name="language_name" id="language_name" class="">
						<option value="">{$LANG.addletter_select}</option>
							{$myobj->generalPopulateArray($myobj->form_lang_add.getLanguageLists, $myobj->getFormField('language_name'))}
						</select></span>
                        <span>
                        						<input class="clsSubmitButton clsLanguageSubmitButton" type="submit" name="submit_add_lang" id="submit_add_lang" value="{$LANG.addletter_add_submit}" tabindex="{smartyTabIndex}" /></span>
					{else}
						<p>{$LANG.no_languages_to_add}</p>
					{/if}
			</form>
		</div>
	{/if}
	{if  $myobj->isShowPageBlock('form_langList')}
        <form name="form_langList" id="selFormLangList" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
				<table summary="{$LANG.addletter_tbl_summary}" class="clsFormTbl">
					<tr>
						<th>{$LANG.addletter_language}</th>
						<th>{$LANG.addletter_status}</th>
						<th>{$LANG.addletter_action}</th>
					</tr>
					{foreach key=key item=item from=$myobj->getLangList($CFG.lang, $CFG.trans, $CFG.site.project_path)}
						<tr>
							<td>
								<img src="{$myobj->getLangList.language_img.$key}" />
								{$item}({$key})
							</td>
							<td>
								{if $myobj->getLangList.translated.$key}
									{$myobj->addTranslatedLanguage($key)}
									<span class="clsTranslated">{$LANG.addletter_translated}</span>
								{else}
									{$myobj->addTranslatedLanguage($key,'false')}
									<span class="clsNotTranslated">{$LANG.addletter_problem}</span>
								{/if}
							 </td>
							<td class="clsTranslateAll">
								{if $key eq $CFG.lang.default}
									-
								{else}
									<a id='anchor_{$key}' href='{$CFG.site.relative_url}translate.php?newlg={$key}&all=0&ajax_page=1' onClick="return testOpenAjaxWindow('anchor_{$key}', -360, -200)">{$LANG.addletter_translate_all}</a> &nbsp;
									<a id="anchor1_{$key}" href="{$CFG.site.relative_url}translate.php?newlg={$key}&all=1&ajax_page=1" onClick="return testOpenAjaxWindow('anchor1_{$key}', -460, -200)">{$LANG.addletter_translate}</a>
									{if $key != $CFG.lang.default}
										 &nbsp;<a id="anchor_delete{$key}" href="" onclick="return getLangConfirmation('anchor_delete{$key}', '{$key}','delete', '{$LANG.addletter_confirmation_delete_language}')">{$LANG.addletter_delete}</a>
                                         {if $myobj->getLangList.translated.$key}
											 {if !isset($CFG.published_languages.$key) || (isset($CFG.published_languages.$key) && $CFG.published_languages.$key == 'false')}
												 &nbsp;<a id="anchor_publish{$key}" href="" onclick="return getLangConfirmation('anchor_publish{$key}', '{$key}', 'publish', '{$LANG.addletter_confirmation_publish_language}')">{$LANG.addletter_publish}</a>
											 {else if  $CFG.published_languages.$key == 'true'}
												&nbsp;<a id="anchor_publish{$key}" href="" onclick="return getLangConfirmation('anchor_publish{$key}', '{$key}', 'unpublish', '{$LANG.addletter_confirmation_unpublish_language}')">{$LANG.addletter_unpublish}</a>
											 {/if}
										 {/if}
									{/if}
								{/if}
							</td>
						</tr>
					{/foreach}
				</table>
			</form>
</div>
{/if}
     {include file='../general/box.tpl' opt='adminrounded_bottom'}
</div>