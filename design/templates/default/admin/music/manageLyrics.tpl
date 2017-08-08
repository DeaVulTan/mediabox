{if !$myobj->isShowPageBlock('show_edit_block')}
<div id="selMusicPlaylistManage">
    <!-- heading -->
    <h2>
    	{$LANG.managelyrics_title}
    </h2>
    <br />
    <!-- information div -->
    {$myobj->setTemplateFolder('admin')}
    	{include file='information.tpl'}

    <!-- Create playlist block -->
    {if $myobj->isShowPageBlock('list_lyrics_block')}

    	 <!-- Single confirmation box -->
        <div id="selMsgConfirmSingle" class="clsPopupConfirmation" style="display:none;">
            <p id="confirmMessageSingle"></p>
            <form name="msgConfirmformSingle" id="msgConfirmformSingle" method="post" action="{$myobj->getCurrentUrl(true)}">
                <table summary="{$LANG.managelyrics_lyrics_detail_label}">
                    <tr>
                        <td>
                            <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
                            &nbsp;
                            <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
                            <input type="hidden" name="music_lyric_id" id="music_lyric_id" />
                            <input type="hidden" name="action" id="action" />
                            {$myobj->populateHidden($myobj->hidden_arr)}
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <!-- confirmation box-->
        <!-- music information -->
    	{$myobj->setTemplateFolder('admin/', 'music')}
    		{include file='musicInformation.tpl'}
         {if $myobj->isResultsFound()}
            {if $CFG.admin.navigation.top}
                    {$myobj->setTemplateFolder('admin')}
                    {include file=pagination.tpl}
            {/if}
            <form id="selFormLyrics" name="selFormLyrics" method="post" action="{$myobj->getCurrentUrl(true)}">
                 <table width="100%"  >
                   <tr>
                     <th width="5%" align="center" valign="middle"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.selFormLyrics.name, document.selFormLyrics.check_all.name)"/></th>
                     <th width="30%" align="left" valign="middle">{$LANG.managelyrics_lyrics}</th>
                     <th width="15%" align="left" valign="top">{$LANG.managelyrics_Post_by}</th>
                     <th width="20%" align="left" valign="top">{$LANG.managelyrics_best_lyrics}</th>
                     <th width="10%">{$LANG.managelyrics_status}</th>
                     <th width="10%" align="left" valign="top">{$LANG.managelyrics_delete}</th>
                      <th width="15%" align="left" valign="top">{$LANG.managelyrics_edit}</th>
                   </tr>
                   {foreach key=lyricsKey item=lyricsValue from=$myobj->list_lyrics_block.displayLyrics}
                       <tr>
                         <td width="5%" align="left" valign="middle"><input type="checkbox" class="clsCheckRadio" name="lyrics_ids[]" value="{$lyricsValue.record.music_lyric_id}" onClick="disableHeading('selFormAnnouncement');" tabindex="{smartyTabIndex}"/></td>
                         <td width="30%" align="left" valign="top"><p title="{$lyricsValue.record.lyric}">{$lyricsValue.lyrics}</p></td>
                         <td width="15%" align="left" valign="top"><a href="{$lyricsValue.lyrics_post_user_url}">{$lyricsValue.record.user_name}</a></td>
                         <td width="20%" align="left" valign="top">
                         	{if $lyricsValue.record.best_lyric == 'Yes'}
                            	<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('remove_best_lyric', '{$lyricsValue.record.music_lyric_id}', '{$LANG.managelyrics_confirm_remove_lyrics}'), Array('value', 'value', 'innerHTML'), -100, -500);">{$LANG.managelyrics_remove_best_lyrics}</a>
                            {else}
	                        	<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('best_lyric', '{$lyricsValue.record.music_lyric_id}', '{$LANG.managelyrics_confirm_best_lyrics}'), Array('value', 'value', 'innerHTML'), -100, -500);">{$LANG.managelyrics_set_best_lyrics}</a>
                            {/if}                         </td>
                         <td width="10%">
                         	{if $lyricsValue.record.lyric_status == 'Yes'}
                            	<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('Inactive', '{$lyricsValue.record.music_lyric_id}', '{$LANG.managelyrics_inactive_confirm_message}'), Array('value', 'value', 'innerHTML'), -100, -500);">{$LANG.managelyrics_inactive}</a>
                            {elseif $lyricsValue.record.lyric_status == 'No'}
                            	<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('Active', '{$lyricsValue.record.music_lyric_id}', '{$LANG.managelyrics_active_confirm_message}'), Array('value', 'value', 'innerHTML'), -100, -500);">{$LANG.managelyrics_active}</a>
                            {elseif $lyricsValue.record.lyric_status == 'ToActivate'}
                            	<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle' ,Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('Active', '{$lyricsValue.record.music_lyric_id}', '{$LANG.managelyrics_approve_confirm_message}'), Array('value', 'value', 'innerHTML'), -100, -500);">{$LANG.managelyrics_photo_approve}</a>
                                /<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('Delete', '{$lyricsValue.record.music_lyric_id}', '{$LANG.managelyrics_disapprove_confirm_message}'), Array('value', 'value', 'innerHTML'), -100, -500);">{$LANG.managelyrics_photo_disapprove}</a>
                            {/if}                         </td>
                         <td width="10%" align="left" valign="top"><a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('Delete', '{$lyricsValue.record.music_lyric_id}', '{$LANG.managelyrics_delete_confirm_message}'), Array('value', 'value', 'innerHTML'), -100, -500);">{$LANG.managelyrics_delete}</a></td>
                         <td width="15%" align="left" valign="top"><a href="{$lyricsValue.editLyrics_url}">{$LANG.managelyrics_edit}</a></td>
                       </tr>
                   {/foreach}
                   <tr>
                         <td colspan="6" align="left" valign="middle">
                         <select name="action_val" id="action_val" tabindex="{smartyTabIndex}">
                        	<option value="">{$LANG.common_select_action}</option>
                        	{$myobj->generalPopulateArray($myobj->list_lyrics_block.action_arr, $myobj->getFormField('action'))}
                        </select>
                        <input type="button" name="action_button" class="clsSubmitButton" id="action_button" value="{$LANG.managelyrics_submit}" onClick="getMultiCheckBoxValue('selFormLyrics', 'check_all', '{$LANG.common_check_atleast_one}');if(multiCheckValue!='') getAction();"/>
                        <input type="button" class="clsCancelButton" name="cancel_submit" id="cancel_submit" value="{$LANG.managelyrics_cancel_label}" onclick="Redirect2URL('{$CFG.site.url}admin/music/musicManage.php')"tabindex="{smartyTabIndex}">
                        </td>
                   </tr>
                  </table>
  </form>
            {if $CFG.admin.navigation.bottom}
                <div id="bottomLinks">
                    {include file='pagination.tpl'}
                </div>
      	    {/if}
      	{else}
          <div id="selMsgAlert">{$LANG.managelyrics_no_record_found}</div>
          <input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="{$LANG.managelyrics_cancel_label}" onclick="Redirect2URL('{$CFG.site.url}admin/music/musicManage.php')"tabindex="{smartyTabIndex}">
       	{/if}
	{/if}
</div>
{/if}
{if $myobj->isShowPageBlock('show_edit_block')}
<div id="editselMusicPlaylistManage" class="clsAudioContentContainer">
    <!-- heading -->
    <h3 class="clsH3Heading">
    	{$LANG.managelyrics_edit_title}
    </h3>
    <!-- information div -->
    {$myobj->setTemplateFolder('admin/')}
    	{include file='information.tpl'}
    	{$myobj->setTemplateFolder('admin/', 'music')}
    		{include file='musicInformation.tpl'}
		<div id="advancedPlaylistSearch" >
		{foreach key=lyricsKey item=lyricsValues from=$myobj->show_edit_block.edit_displayLyrics}
		<table class="clsNoBorder" >
			<tr><td><p class="clsLyricsPostedBy">{$LANG.managelyrics_Post_by}: <a href="{$lyricsValues.lyrics_post_user_url}">{$lyricsValues.user_name}</a></p></td>
				<td>&nbsp;</td>
			</tr>

			<td>&nbsp;</td></tr>
		</table>
		{/foreach}
		</div>

	<form id="editFormLyrics" name="editFormLyrics" method="post" action="{$myobj->getCurrentUrl(true)}" class="clsDataTable">
	    	  <table class="clsFormTableSection" width="100%" >
					<tr>
						<td class="{$myobj->getCSSFormLabelCellClass('edit_lyrics')}"><label for="edit_lyrics">{$LANG.managelyrics_lyrics_label}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('edit_lyrics')}">{$myobj->getFormFieldErrorTip('edit_lyrics')}
							<textarea name="edit_lyrics" id="edit_lyrics" tabindex="{smartyTabIndex}" rows="10" cols="50">{$myobj->showEditLyrics()}</textarea>
						</td>
				   	</tr>
				   	<tr>
				   	<td>
					   	<input type="submit" class="clsSubmitButton" name="edit_submit" id="edit_submit" tabindex="{smartyTabIndex}" value="{$LANG.managelyrics_edit_submit_label}"/></td>
	                    <input type="hidden" class="clsSubmitButton" name="music_lyric_id" id="music_lyric_id" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('music_lyric_id')}"/></td>
					</tr>

				   </table>
				   <a href="{$CFG.site.url}admin/music/manageLyrics.php?music_id={$myobj->getFormField('music_id')}">{$LANG.managelyrics_edit_back_label}</a>
	</form>

{/if}