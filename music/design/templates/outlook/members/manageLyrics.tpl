{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_top"}
<div id="selMusicPlaylistManage" class="clsAudioContentContainer">
    <!-- heading -->
    <h3 class="clsH3Heading">
    	{$LANG.managelyrics_title}
    </h3>
    <!-- information div -->
{$myobj->setTemplateFolder('general/','music')}
    	{include file='information.tpl'}

    <!-- Create playlist block -->
    {if $myobj->isShowPageBlock('list_lyrics_block')}

    	 <!-- Single confirmation box -->
        <div id="selMsgConfirmSingle" class="clsPopupConfirmation" style="display:none;">
            <p id="confirmMessageSingle"></p>
            <form name="msgConfirmformSingle" id="msgConfirmformSingle" method="post" action="{$myobj->getCurrentUrl(true)}">
                <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
                &nbsp;
                <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
                <input type="hidden" name="music_lyric_id" id="music_lyric_id" />
                <input type="hidden" name="action" id="action" />
                {$myobj->populateHidden($myobj->hidden_arr)}
            </form>
        </div>
        <!-- confirmation box-->
        <!-- music information -->
    	{$myobj->setTemplateFolder('general/','music')}
    		{include file='musicInformation.tpl'}
         {if $myobj->isResultsFound()}
            {if $CFG.admin.navigation.top}
					{$myobj->setTemplateFolder('general/','music')}
                    <div class="clsAudioPaging">{include file=pagination.tpl}</div>
            {/if}
            <form id="selFormLyrics" name="selFormLyrics" method="post" action="{$myobj->getCurrentUrl(true)}" class="clsDataTable">
                 <table>
                   <tr>
                     <th width="5%" align="center" valign="middle"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.selFormLyrics.name, document.selFormLyrics.check_all.name)"/></th>
                     <th width="30%" align="left" valign="middle">{$LANG.managelyrics_lyrics}</th>
                     <th width="20%" align="left" valign="top">{$LANG.managelyrics_Post_by}</th>
                     <th width="20%" align="left" valign="top">{$LANG.managelyrics_best_lyrics}</th>
                     <th width="10%">{$LANG.managelyrics_status}</th>
                     <th width="10%" align="left" valign="top">{$LANG.managelyrics_delete}</th>
                     <th width="15%" align="left" valign="top">{$LANG.managelyrics_edit}</th>
                   </tr>
                   {foreach key=lyricsKey item=lyricsValue from=$myobj->list_lyrics_block.displayLyrics}
                       <tr>
                         <td width="5%" align="left" valign="middle"><input type="checkbox" class="clsCheckRadio" name="lyrics_ids[]" value="{$lyricsValue.record.music_lyric_id}" onClick="disableHeading('selFormLyrics');" tabindex="{smartyTabIndex}"/></td>
                         <td width="30%" align="left" valign="top"><p title="{$lyricsValue.lyrics}"><a href="{$lyricsValue.viewLyrics_url}">{$lyricsValue.lyrics}</a></p></td>
                         <td width="25%" align="left" valign="top"><a href="{$lyricsValue.lyrics_post_user_url}">{$lyricsValue.record.user_name}</a></td>
                         <td width="20%" align="left" valign="top">
                         	{if $lyricsValue.record.best_lyric == 'Yes'}
                            	<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('remove_best_lyric', '{$lyricsValue.record.music_lyric_id}', '{$LANG.managelyrics_confirm_remove_lyrics}'), Array('value', 'value', 'innerHTML'), -100, -500);">{$LANG.managelyrics_remove_best_lyrics}</a>
                            {else}
	                        	<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('best_lyric', '{$lyricsValue.record.music_lyric_id}', '{$LANG.managelyrics_confirm_best_lyrics}'), Array('value', 'value', 'innerHTML'), -100, -500);">{$LANG.managelyrics_set_best_lyrics}</a>
                            {/if}                         </td>
                         <td width="10%">
                         	{if $lyricsValue.record.lyric_status == 'Yes'}
                            	{$LANG.managelyrics_active_status_label}(<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('Inactive', '{$lyricsValue.record.music_lyric_id}', '{$LANG.managelyrics_inactive_confirm_message}'), Array('value', 'value', 'innerHTML'), -100, -500);">{$LANG.managelyrics_inactive}</a>)
                            {elseif $lyricsValue.record.lyric_status == 'No'}
                            	{$LANG.managelyrics_inactive_status_label}(<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('Active', '{$lyricsValue.record.music_lyric_id}', '{$LANG.managelyrics_active_confirm_message}'), Array('value', 'value', 'innerHTML'), -100, -500);">{$LANG.managelyrics_active}</a>)
                            {elseif $lyricsValue.record.lyric_status == 'ToActivate'}
                            	<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle' ,Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('Active', '{$lyricsValue.record.music_lyric_id}', '{$LANG.managelyrics_approve_confirm_message}'), Array('value', 'value', 'innerHTML'), -100, -500);">{$LANG.managelyrics_photo_approve}</a>
                                /<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('Delete', '{$lyricsValue.record.music_lyric_id}', '{$LANG.managelyrics_disapprove_confirm_message}'), Array('value', 'value', 'innerHTML'), -100, -500);">{$LANG.managelyrics_photo_disapprove}</a>
                            {/if}                         </td>
                         <td width="10%" align="left" valign="top"><a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('Delete', '{$lyricsValue.record.music_lyric_id}', '{$LANG.managelyrics_delete_confirm_message}'), Array('value', 'value', 'innerHTML'), -100, -500);">{$LANG.managelyrics_delete}</a></td>
                         <td width="10%" align="left" valign="top"><a href="{$lyricsValue.editLyrics_url}">{$LANG.managelyrics_edit}</a></td>
					   </tr>
                   {/foreach}
                   <tr>
                         <td colspan="6" align="left" valign="middle">
                         <p class="clsFloatLeft clsSelectAlign"><select name="action_val" id="action_val" tabindex="{smartyTabIndex}">
                        	<option value="">{$LANG.common_select_action}</option>
                        	{$myobj->generalPopulateArray($myobj->list_lyrics_block.action_arr, $myobj->getFormField('action'))}
                        </select></p>
                        <span class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" name="action_button" class="clsSubmitButton" id="action_button" value="{$LANG.managelyrics_submit}" onClick="getMultiCheckBoxValue('selFormLyrics', 'check_all', '{$LANG.common_check_atleast_one}');if(multiCheckValue!='') getAction();"/></span></span></td>
                   </tr>
                  </table>
  </form>
            {if $CFG.admin.navigation.bottom}
                <div id="bottomLinks" class="clsAudioPaging">
					{$myobj->setTemplateFolder('general/','music')}
                    {include file='pagination.tpl'}
                </div>
      	    {/if}
      	{else}
          <div id="selMsgAlert">{$LANG.managelyrics_no_record_found}</div>
       	{/if}
	{/if}
</div>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_bottom"}



