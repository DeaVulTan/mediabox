{if $myobj->isShowPageBlock('form_translist')}
<div class="clsTranslateAllHeading">
    <h2>{$LANG.addletter_translation_title}</h2></div>
    {include file='../general/information.tpl'}
<div class="clsTranslateAllAjax">
    <div id="selWaitMsg" style="display:none">
    {$LANG.addletter_wait_msg}</div>
    <form name="form_langList" id="selFormLangList" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off">
        <input type="hidden" id="newlg" name="newlg" value="{$myobj->getFormField('newlg')}" />
        <table summary="{$LANG.addletter_tbl_summary}" class="clsFormTbl">
            <tr>
                <th>{$LANG.addletter_sno}</th>
                <th>{$LANG.addletter_path}</th>
                <th>{$LANG.addletter_type}</th>
                <th>{$LANG.addletter_status}</th>
            </tr>
            {foreach key=key item=value from=$translateOneAjax}
                <tr>
					<td>{$value.counter}</td>
					<td>{$value.file_newlg}</td>
					<td>{$LANG.addletter_folder}</td>
					<td id="step_{$value.inc}" class="clsTranslateAction">{$LANG.addletter_problem}</th>
				</tr>
            {/foreach}
            {*foreach key=key item=value from=$translateOneAjaxFile}
				<tr>
					<td>{$value.counter}</td>
					<td>{$value.file_newlg}</td>
					<td>{$LANG.addletter_file}</td>
					<td id="step_{$value.inc}" class="clsTranslateAction">{$LANG.addletter_action}</th>
				</tr>
            {/foreach*}
        </table>

    </form>
            <div id="selButtonRow">
					<div class="clsTranslateConfirm">
                    <table>
                    <td>
					<div class="clsClearFix">
					{if !$CFG.admin.is_demo_site}
						<div class="clsFloatLeft clsTranslateBtn">
                        <input class="clsSubmitButton" type="button" name="submit_confirm" value="{$LANG.addletter_translate_all}" tabindex="{smartyTabIndex}" onClick="startTranslate('{$myobj->getFormField('newlg')}', 0)" /></div>
					{else}
						<div class="clsFloatLeft"><input class="clsSubmitButton" type="button" name="submit_confirm" value="{$LANG.addletter_translate_all}" tabindex="{smartyTabIndex}" onClick="return false" /></div>
					{/if}
</div></td>
</tr>
</table>
					</div>
				</div>

</div>
{/if}
