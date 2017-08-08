{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_top"}
<div id="selMusicPlaylistManage">
	<!-- heading -->
	<div class="clsAudioIndex"><h3>
    	{$LANG.commin_music_manage_albums_label}    	
    </h3></div>
     <!-- information div -->
    {$myobj->setTemplateFolder('general/','music')}
    {include file='information.tpl'}
    <!-- Multi confirmation box -->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
                <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
                &nbsp;
                <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onclick="return hideAllBlocks('selFormForums');" />
                <input type="hidden" name="music_album_ids" id="music_album_ids" />
                <input type="hidden" name="action" id="action" />
                {$myobj->populateHidden($myobj->hidden_arr)}
		</form>
	</div>
    <!-- confirmation box-->
    <!-- Single confirmation box -->
    <div id="selMsgConfirmSingle" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessageSingle"></p>
		<form name="msgConfirmformSingle" id="msgConfirmformSingle" method="post" action="{$myobj->getCurrentUrl(false)}">
                <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
                &nbsp;
                <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onclick="return hideAllBlocks('selFormForums');" />
                <input type="hidden" name="music_album_ids" id="music_album_ids" />
                <input type="hidden" name="action" id="action" />
                {$myobj->populateHidden($myobj->hidden_arr)}
		</form>
	</div>
    <!-- confirmation box-->
    <!-- Create album block -->
	{if $myobj->isShowPageBlock('create_album_block')}
		<p class="clsStepsTitle">
        	{if $myobj->getFormField('music_album_id') != ''}
                {$LANG.musicalbum_update_album_label}
            {else}
                {$LANG.musicalbum_createlist}
            {/if}
        </p>
        <form id="frmMusicAlbumManage" name="frmMusicAlbumManage" method="post" action="{$myobj->getCurrentUrl()}" >
        	<div class="clsNoteContainerblock">
        		<p class="clsNotehead">{$LANG.common_music_note}:</p>
        		{if $CFG.admin.musics.allowed_usertypes_to_upload_for_sale != 'None'}
        		<p>{$LANG.musicalbum_album_note_msg1}</p>
        		{/if}
        		<p>{$LANG.musicalbum_album_note_msg2}</p>
        	</div>
            <div class="clsDataTable"><table class="clsCreateAlbumTable">
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<label for="album_title">{$LANG.musicalbum_title}</label>
                </td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<input type="text" name="album_title" id="album_title" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('album_title')}" />
                   	{$myobj->getFormFieldErrorTip('album_title')}
                   {$myobj->ShowHelpTip('music_album_title', 'album_title')}
                 </td>
              </tr>
				<tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault"><label for="album_access_private">{$LANG.musicalbum_album_access_type}</label></td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                <input type="radio" name="album_access_type" id="album_access_private" onclick="enabledFormFields(Array('album_price'))"  value="Private" {$myobj->isCheckedRadio('album_access_type','Private')} /> <label for="album_access_private"><strong>{$LANG.common_yes_option}</strong></label>
                <input type="radio" name="album_access_type" id="album_access_public" onclick="disabledFormFields(Array('album_price'))"  value="Public" {$myobj->isCheckedRadio('album_access_type','Public')}  /> <label for="album_access_public"><strong>{$LANG.common_no_option}</strong></label>
                </td>
              </tr>
              {if $CFG.admin.musics.allowed_usertypes_to_upload_for_sale != 'None'}
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<label for="album_price">
                    	{$LANG.musicalbum_price}                   </label>                </td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	({$CFG.currency}) <input type="text" name="album_price" id="album_price" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('album_price')}" />
                   {$myobj->getFormFieldErrorTip('album_price')}
                   {$myobj->ShowHelpTip('music_album_price', 'album_price')}
                </td>
              </tr>
              {/if}
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">&nbsp;</td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                    <input  type="hidden" class="clsSubmitButton" name="music_album_id" id="music_album_id" value="{$myobj->getFormField('music_album_id')}" />
                  <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" class="clsSubmitButton" name="album_submit" id="album_submit" value="{if $myobj->getFormField('music_album_id') != ''}{$LANG.musicalbum_update_album_label}{else}{$LANG.musicalbum_create_palylist}{/if}" tabindex="{smartyTabIndex}" /></span></div>
                {if $myobj->chkIsAdminSide()}
                	<div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="{$LANG.musicalbum_Cancel_label}" onclick="Redirect2URL('{$CFG.site.url}admin/music/musicPlaylist.php')"tabindex="{smartyTabIndex}" /></span></div>
                {else}
                	<div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="{$LANG.musicalbum_Cancel_label}" onclick="Redirect2URL('{$myobj->createalbum_url}')"tabindex="{smartyTabIndex}" /></span></div>
                {/if}
                </td>
              </tr>
            </table>
          </div>
  </form>
  {/if}
    {if $myobj->isShowPageBlock('list_album_block') && !$myobj->chkIsAdminSide()}
    	<div id="selMusicPlaylistManageDisplay" class="clsLeftSideDisplayTable">

            {if $myobj->isResultsFound()}
                {if $CFG.admin.navigation.top}
                        {$myobj->setTemplateFolder('general/','music')}
                        <div class="clsAudioPaging">{include file=pagination.tpl}</div>
                {/if}
                <form id="deleMusicForm" name="deleMusicForm" method="post" action="{$myobj->getCurrentUrl(false)}">
                    <div class="clsDataTable">
                        <table class="clsMyMusicPlaylistTbl clsAlbumManageTable">
                            <tr>
                                <th><input type="checkbox" name="check_all" id="check_all" onclick="CheckAll(document.deleMusicForm.name, document.deleMusicForm.check_all.name)" /></th>
                                 <th class="{$myobj->getOrderCss('album_title')} clsAlbumNameWidth"><a href="javascript:void(0)" onclick="return changeOrderbyElements('deleMusicForm','album_title')" title="{$LANG.musicalbum_title}">{$LANG.musicalbum_title}</a></th>
                                <th>{$LANG.musicalbum_totla_music}</th>
                                <th class="{$myobj->getOrderCss('album_access_type')}"><a href="javascript:void(0)" onclick="return changeOrderbyElements('deleMusicForm','album_access_type')">{$LANG.musicalbum_access_type}</a></th>
                                {if $CFG.admin.musics.allowed_usertypes_to_upload_for_sale != 'None'}
                                <th class="{$myobj->getOrderCss('album_price')}"><a href="javascript:void(0)" onclick="return changeOrderbyElements('deleMusicForm','album_price')">{$LANG.musicalbum_album_price}</a></th>
								{/if}
                                <th colspan="4" class="clsUserActionTh">{$LANG.musicalbum_user_action}</th>
                            </tr>
                            {foreach key=musicPlaylistKey item=musicalbum from=$myobj->list_album_block.showAlbums}
                            <tr>
                                <td><input type="checkbox" name="music_album_ids[]" id="check_{$musicalbum.music_album_id}" tabindex="{smartyTabIndex}" value="{$musicalbum.music_album_id}" onclick="disableHeading('deleMusicForm');"/></td>
                                <td class="clsAlbumNameWidth"><a href="{$musicalbum.album_view_link}" title="{$musicalbum.album_title}">{$musicalbum.album_wrap_title}</a></td>
								<td>{$myobj->getMusicCount($musicalbum.music_album_id)}</td>
								<td>{$musicalbum.album_access_type}</td>
                                {if $CFG.admin.musics.allowed_usertypes_to_upload_for_sale != 'None'}
								<td>{$CFG.currency}{$musicalbum.album_price}</td>
                                {/if}
								{if $musicalbum.edit_link != ''}
								    <td class="clsOverflow">
                                    <span class="clsEditAlbum"><a href="{$musicalbum.edit_link}" title="{$LANG.musicalbum_edit_album}">{$LANG.musicalbum_edit_album}</a></span>
									<span class="clsDeleteAlbumList"><a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action','music_album_ids','confirmMessageSingle'), Array('delete','{$musicalbum.music_album_id}', '{$LANG.musicalbum_delete_confirmation}'), Array('value','value','innerHTML'), -100, -500);" title="{$LANG.musicalbum_delete_album}">{$LANG.musicalbum_delete_album}</a></span></td>
								{else}
									<td colspan = "2"> {$LANG.musicalbum_default_album }</td>
								{/if}
                             </tr>
                            {/foreach}
                            <tr>
                            {$myobj->populateHidden($myobj->hidden_arr)}
                                <td>&nbsp;</td>
                                <td colspan="6">
                                <div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" class="clsSubmitButton" name="button" id="button" value="{$LANG.musicalbum_delete}" onclick="getMultiCheckBoxValue('deleMusicForm', 'check_all', '{$LANG.musicalbum_err_tip_select_titles}');if(multiCheckValue!='') getAction('delete')"/></span></div>                                </td>
                            </tr>
                        </table>
                  </div>
                </form>
                {if $CFG.admin.navigation.bottom}
                    <div id="bottomLinks" class="clsAudioPaging">
                        {$myobj->setTemplateFolder('general/','music')}
                        {include file='pagination.tpl'}
                    </div>
                {/if}
              {else}
                 <div id="selMsgAlert">
                    <p>{$LANG.musicalbum_no_records_found}</p>
                 </div>
               {/if}
        </div>
    {/if}
</div>
{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_bottom"}