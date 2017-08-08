
{if $myobj->isShowPageBlock('form_translist_all')}
<div class="clsTranslateAllHeading">
<h2>{$LANG.addletter_translation_title}</h2></div>
{include file='../general/information.tpl'}
<div class="clsTranslateAllAjax">
		<div id="selWaitMsg" style="display:none">{$LANG.addletter_wait_msg}</div>
		<form name="form_langList" id="selFormLangList" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off">
			<input type="hidden" id="newlg" name="newlg" value="{$myobj->getFormField('newlg')}" />
			<table summary="{$LANG.addletter_tbl_summary}" class="clsFormTbl">
				<tr align="center">
			        <td align="center">{$LANG.addletter_sno}</td>
			        <td align="center">{$LANG.addletter_path}</td>
			        <td align="center" colspan="2">{$LANG.addletter_status}</td>
			    </tr>
                {foreach key=key item=value from=$translateAllAjax}
                	<tr>
	                    <td>{$value.counter} </td>
    	            	<td>{$value.folder}</td>
    	            	<td>
							<span id="action_{$value.stepCounter}" class="clsNotTranslated">{$LANG.addletter_no_files_found}</span>
                        </td>
                        <td id="step_{$value.stepCounter}" class="clsNotTranslated">
                        	{if !$CFG.admin.is_demo_site}
								<input class="clsSubmitButton" type="button" name="submit_translate" value="{$LANG.addletter_action_translate}" onClick="startTranslateAll('{$myobj->getFormField('newlg')}', {$value.stepCounter})"/>
							{else}
								<input class="clsSubmitButton" type="button" name="submit_translate" value="{$LANG.addletter_action_translate}" onClick="return false" />
	                        {/if}
						</td>
                    </tr>
                {/foreach}
			</table>
                             <div id="selButtonRow">
					<div class="clsTranslateConfirm">
                    <table class="clsTranslateAllTbl">
                    <tr>
                    <td><span class="clsLetterCancellation">{$LANG.addletter_cancellation}</span></td>
                    </tr>
                    <td>
					<input class="clsSubmitButton" type="button" name="submit_cancel" value="{$LANG.addletter_yes}" tabindex="{smartyTabIndex}" onClick="return setRefresh();" />                   </td>
                    </tr>
                    </table>
					</div>

{/if}
</div>