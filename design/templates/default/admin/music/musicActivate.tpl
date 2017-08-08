<div id="selPhotoList">
    <h2><span>{$LANG.musicactivate_title}</span></h2>
    <div id="selMsgConfirmDelete" class="selMsgConfirm clsConfirmPopup" style="display:none;">
        <p id="confirmMsg"></p>
            <form name="confirmationForm" id="confirmationForm" method="post" action="{$_SERVER.PHP_SELF}" autocomplete="off">
                            <input type="submit" class="clsSubmitButton" name="submit_button" id="submit_button" value="{$LANG.act_yes}"  tabindex="{smartyTabIndex}" />&nbsp;
                            <input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="{$LANG.act_no}"  tabindex="{smartyTabIndex}" onClick="return hideAllBlocks();" />
                <input type="hidden" name="action" id="action" />
                <input type="hidden" name="music_id" id="music_id" />

                {$myobj->populateHidden($myobj->hidden)}
            </form>
    </div>
    <!-- information div -->
    {$myobj->setTemplateFolder('admin')}
    {include file='information.tpl'}
    <!-- preview_block start-->
	{if $myobj->isShowPageBlock('preview_block')}
        <div id="selDeleteConfirm">
            <form name="music_delete_form" id="music_delete_form" method="post" action="{$_SERVER.PHP_SELF}" autocomplete="off">
                <table summary="{$LANG.musicactivate_tbl_summary}" class="clsMyPhotosTable clsNoBorder ">
                    <tr>
                        <td colspan="3">
                           	<div id="flashcontent2">
							 {* Music Player Begins *}
                              <script type="text/javascript" src="{$CFG.site.url}js/swfobject.js"></script>
                              {*GENERATE SINGLE PLAYER*}
                                    {$myobj->populateSinglePlayer($music_fields)}
                              {*GENERATE SINGLE PLAYER*}
                          {* Music Player ends *}
							</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="javascript:void(0)" id="{$myobj->preview_block.anchor}"></a>
                            <input type="button" class="clsSubmitButton" name="activate" id="activate" value="{$LANG.musicactivate_activate}" tabindex="{smartyTabIndex}" onClick="Confirmation('selMsgConfirmDelete', 'confirmationForm', Array('music_id', 'action', 'confirmMsg'), Array('{$myobj->getFormField('music_id')}', 'activate', '{$LANG.musicactivate_activate_confirmation}'), Array('value', 'value', 'innerHTML'), 50, -400);" /> &nbsp;
                            <input type="button" class="clsSubmitButton" name="delete" id="delete" value="{$LANG.musicactivate_delete}" tabindex="{smartyTabIndex}" onClick="Confirmation('selMsgConfirmDelete', 'confirmationForm', Array('music_id', 'action', 'confirmMsg'), Array('{$myobj->getFormField('music_id')}', 'delete', '{$LANG.musicactivate_delete_confirmation}'), Array('value', 'value', 'innerHTML'), 50, -400);" /> &nbsp;
                            <input type="submit" class="clsCancelButton" name="cancel" id="cancel" value="{$LANG.musicactivate_cancel}" tabindex="{smartyTabIndex}" />
                            {$myobj->populateHidden($myobj->preview_block.populateHidden)}
                        </td>
                    </tr>
                </table>
            </form>
        </div>
	{/if}
	{if  $myobj->isShowPageBlock('list_music_form')}
        <div id="selMusicList">
        	{if $myobj->isResultsFound()}
                <!-- top pagination start-->
                {if $CFG.admin.navigation.top}
               		{$myobj->setTemplateFolder('admin')}
                {include file='pagination.tpl'}
                {/if}
                <!-- top pagination end-->
                <form name="musicListForm" id="musicListForm" action="{$_SERVER.PHP_SELF}" method="post">
                    <table summary="{$LANG.musicactivate_tbl_summary}">
                        <tr>
                            <th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio"  name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.musicListForm.name, document.musicListForm.check_all.name)" /></th>
                            <th>{$LANG.musicactivate_music_title}</th>
                            <th>{$LANG.musicactivate_music_thumb}</th>
                            <th>{$LANG.musicactivate_user_name}</th>
                            <th>{$LANG.musicactivate_date_added}</th>
                            <th>{$LANG.musicactivate_option}</th>
                        </tr>
                     	{foreach item=disValue from=$myobj->list_music_form.displayMusicList.row}
                            <tr class="{$myobj->getCSSRowClass()}">
                            <td class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="vid[]" id="vid[]" value="{$disValue.record.music_id}" tabindex="{smartyTabIndex}" /></td>
                            <td>{$disValue.record.music_title}</td>
                            <td class="clsHomeDispContents"><p id="selImageBorder"><img src="{$disValue.img_src}" alt="{$disValue.record.music_title}"{$disValue.DISP_IMAGE} /></p></td>
                            <td>{$disValue.record.user_name}</td>
                            <td>{$disValue.record.date_added}</td>
                            <td><span id="preview"><a href="?action=preview&amp;music_id={$disValue.record.music_id}&amp;start={$myobj->getFormField('start')}">{$myobj->LANG.musicactivate_preview}</a></span></td>
                             <input type="hidden" name="user_id" id="user_id" />
							</tr>
                    	{/foreach}
                        <tr>
                            <td colspan="6">
                            <a href="javascript:void(0)" id="{$myobj->list_music_form.anchor}"></a>
                            <input type="button" class="clsSubmitButton" name="activate_button" id="activate_button" value="{$LANG.musicactivate_activate}" onClick="{$myobj->list_music_form.onclick_activate}"/>
                            <input type="button" class="clsSubmitButton" name="delete_button" id="delete_button" value="{$LANG.musicactivate_delete}" onClick="{$myobj->list_music_form.onclick_delete}"/>
                            </td>
                        </tr>
                    </table>
                </form>
                <!-- bottom pagination start-->
                {if $CFG.admin.navigation.bottom}
                {$myobj->setTemplateFolder('admin')}
                {include file='pagination.tpl'}
                {/if}
                <!-- bottom pagination end-->
            {else}
                 <div id="selMsgAlert">
           		{$LANG.musicactivate_no_records_found}
                 </div>
            {/if}
        </div>
	{/if}
</div>

