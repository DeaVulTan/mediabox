<div id="selLanguageExport">
	<h2>{$LANG.page_title}</h2>
    <div class="clsAdminTopSpace clsLanguageExportMain">
    {$myobj->setTemplateFolder('admin/')}
	{include file="information.tpl"}
	{ if $myobj->isShowPageBlock('block_language_export')}
        <form name="formLanguageExport" id="formLanguageExport" method="post" action="{$myobj->getCurrentUrl(true)}">
            <table>
                <tr>
                    <td class="{$myobj->getCSSFormLabelCellClass('language')}"><label for="language">{$LANG.language_export_language}</label></td>
                    <td class="{$myobj->getCSSFormFieldCellClass('language')}">{$myobj->getFormFieldErrorTip('language')}
                        <select name="language" id="language" tabindex="{smartyTabIndex}">
                            {foreach key=key item=value from=$myobj->CFG.lang.available_languages}
                            <option value="{$key}" {if $key eq $myobj->getFormField('language')}selected="selected"{/if}>{$value}</option>
                            {/foreach}
                        </select>
	                    <input type="hidden" name="folder" id="folder" value="all" />
                    </td>
               </tr>
               <tr>
               	<td></td>
                    <td class="{$myobj->getCSSFormFieldCellClass('default')}" colspan="2"><input type="submit" class="clsSubmitButton" name="export_submit" id="export_submit" tabindex="{smartyTabIndex}" value="{$LANG.language_export_submit}" /></td>
               </tr>
        </table>
	{/if}
	{ if $myobj->isShowPageBlock('block_language_import')}
	<form name="formLanguageImport" id="formLanguageImport" method="post" enctype="multipart/form-data" action="{$myobj->getCurrentUrl(true)}">
        <table>
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('language')}">
					<label for="language">{$LANG.language_export_language}</label>
					{$myobj->displayCompulsoryIcon()}
				</td>
                <td class="{$myobj->getCSSFormFieldCellClass('language')}">{$myobj->getFormFieldErrorTip('language')}
                    <input type="text" name="language" id="language" value="{$myobj->getFormField('language')}" /> {$LANG.language_name_like}
                </td>
            </tr>
            <tr class="clsFormRow">
                <td class="{$myobj->getCSSFormLabelCellClass('language_label')}">
                    <label for="language_label">{$LANG.language_export_language_label}</label>
                    {$myobj->displayCompulsoryIcon()}
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('language_label')}">
                	{$myobj->getFormFieldErrorTip('language_label')}
                    <input type="text" name="language_label" id="language_label" value="{$myobj->getFormField('language_label')}" /> {$myobj->LANG.language_label_like}
                </td>
            </tr>
            <tr class="clsFormRow">
                <td class="{$myobj->getCSSFormLabelCellClass('file')}">
					<label for="language">{$LANG.language_import_file}</label>
					{$myobj->displayCompulsoryIcon()}
				</td>
                <td class="{$myobj->getCSSFormFieldCellClass('file')}">{$myobj->getFormFieldErrorTip('file')}
                    <input type="file" name="file" id="file" />
                </td>
            </tr>
            <tr class="clsFormRow">
            	<td></td>
                <td class="{$myobj->getCSSFormFieldCellClass('default')}" colspan="2"><input type="submit" class="clsSubmitButton" name="import_submit" id="import_submit" tabindex="{smartyTabIndex}" value="{$LANG.language_import_submit}" /></td>
            </tr>
        </table>
	</form>
	{/if}
    </div>
</div>