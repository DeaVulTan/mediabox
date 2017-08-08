<div id="selPhotoList">
    <h2><span>{$LANG.musiclyrics_activate_title}</span></h2>
    <div id="selMsgConfirmDelete" class="selMsgConfirm clsConfirmPopup" style="display:none;">
        <p id="confirmMsg"></p>
            <form name="confirmationForm" id="confirmationForm" method="post" action="{$_SERVER.PHP_SELF}" autocomplete="off">
                            <input type="submit" class="clsSubmitButton" name="submit_button" id="submit_button" value="{$LANG.act_yes}"  tabindex="{smartyTabIndex}" />&nbsp;
                            <input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="{$LANG.act_no}"  tabindex="{smartyTabIndex}" onClick="return hideAllBlocks();" />
                <input type="hidden" name="action" id="action" />
                <input type="hidden" name="music_id" id="music_id" />
                <input type="hidden" name="music_lyric_id" id="music_lyric_id" />
                {$myobj->populateHidden($myobj->hidden)}
            </form>
    </div>
    <!-- information div -->
    {$myobj->setTemplateFolder('admin')}
    {include file='information.tpl'}

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
                    <table summary="{$LANG.musiclyrics_activate_tbl_summary}">
                        <tr>
                            <th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio"  name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.musicListForm.name, document.musicListForm.check_all.name)" /></th>
                            <th>{$LANG.musiclyrics_lyric_title}</th>
							<th>{$LANG.musiclyrics_activate_music_title}</th>
                            <th>{$LANG.musiclyrics_activate_music_status}</th>
                            <th>{$LANG.musiclyrics_activate_user_name}</th>
                            <th>{$LANG.musiclyrics_activate_date_added}</th>
                            <th>{$LANG.musiclyrics_best_lyrics}</th>
                        </tr>
                     	{foreach item=disValue from=$myobj->list_music_form.displayMusicList.row}
                            <tr class="{$myobj->getCSSRowClass()}">
                            <td class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="vid[]" id="vid[]" value="{$disValue.record.music_lyric_id}" tabindex="{smartyTabIndex}" /></td>
                            <td><a href="{$disValue.viewLyrics_url}">{$disValue.lyric}</a></td>
							<td>{$disValue.record.music_title}</td>
                            <td>{$disValue.record.lyric_status}</td>
                            <td>{$disValue.record.user_name}</td>
                            <td>{$disValue.record.date_added}</td>
                            <td><a href="{$disValue.setBestLyrics_url}">{$LANG.musiclyrics_set_best_lyrics}</a></td>
                            </tr>
                    	{/foreach}
                        <tr>
                            <td colspan="6">
                            <a href="javascript:void(0)" id="{$myobj->list_music_form.anchor}"></a>
                            <input type="button" class="clsSubmitButton" name="activate_button" id="activate_button" value="{$LANG.musiclyrics_activate_activate}" onClick="{$myobj->list_music_form.onclick_activate}"/>
                            <input type="button" class="clsSubmitButton" name="delete_button" id="delete_button" value="{$LANG.musiclyrics_activate_delete}" onClick="{$myobj->list_music_form.onclick_delete}"/>
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
           		{$LANG.musiclyrics_activate_no_records_found}
                 </div>
            {/if}
        </div>
	{/if}
</div>

