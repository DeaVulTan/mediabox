{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_top"}
<div id="selMusicPlaylistManage">
	<!-- heading -->
	<div class="clsAudioIndex"><h3>
    	{$LANG.musicplaylist_title}    	
    </h3></div>
     <!-- information div -->
    {$myobj->setTemplateFolder('general/', 'music')}
    {include file='information.tpl'}
    <!-- Multi confirmation box -->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
                <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
                &nbsp;
                <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
                <input type="hidden" name="playlist_ids" id="playlist_ids" />
                <input type="hidden" name="action" id="action" />
                {$myobj->populateHidden($myobj->hidden_arr)}
		</form>
	</div>
    <!-- confirmation box-->
    <!-- Single confirmation box -->
    <div id="selMsgConfirmSingle" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessageSingle"></p>
		<form name="msgConfirmformSingle" id="msgConfirmformSingle" method="post" action="{$myobj->getCurrentUrl(true)}">
                <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
                &nbsp;
                <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
                <input type="hidden" name="playlist_ids" id="playlist_ids" />
                <input type="hidden" name="action" id="action" />
                {$myobj->populateHidden($myobj->hidden_arr)}
		</form>
	</div>
    <!-- confirmation box-->
    <!-- Create playlist block -->
	{if $myobj->isShowPageBlock('create_playlist_block')}
        <form name="musicPlayListManage" id="musicPlayListManage" method="post" action="{$myobj->getCurrentUrl()}" >
        <p class="clsStepsTitle">
        	{if $myobj->getFormField('playlist_id') != ''}
                {$LANG.musicplaylist_update_playlist_label}
            {else}
                {$LANG.musicplaylist_createlist}
            {/if}
        </p>
            <div class="clsDataTable"><table class="clsCreateAlbumTable">
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<label for="playlist_name">
                    	{$LANG.musicplaylist_name}                    </label> <span class="clsMandatoryFieldIcon">*</span>               </td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">

                	<input type="text" name="playlist_name" id="playlist_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('playlist_name')}">
                	<p>{$myobj->getFormFieldErrorTip('playlist_name')}</p>
                   <p>{$myobj->ShowHelpTip('music_playlist_name', 'playlist_name')} </p></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<label for="playlist_description">
                    	{$LANG.musicplaylist_description}                    </label>  <span class="clsMandatoryFieldIcon">*</span>              </td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">

                	<textarea name="playlist_description" id="playlist_description" cols="45" rows="5" tabindex="{smartyTabIndex}">{$myobj->getFormField('playlist_description')}</textarea>
                    <p>{$myobj->getFormFieldErrorTip('playlist_description')}</p><p>{$myobj->ShowHelpTip('music_playlist_description', 'playlist_description')} </p></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<label for="playlist_tags">
                    	{$LANG.musicplaylist_tags}                    </label><span class="clsMandatoryFieldIcon">*</span>                </td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<input type="text" name="playlist_tags" id="playlist_tags" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('playlist_tags')}">
                   <p>{$myobj->getFormFieldErrorTip('playlist_tags')}</p>
                    <p>{$myobj->ShowHelpTip('music_playlist_tags', 'playlist_tags')}</p></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault"><label for="allow_comments">{$LANG.musicplaylist_allow_comments}</label></td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                <input type="radio" name="allow_comments" id="allow_comments" value="Yes" {$myobj->isCheckedRadio('allow_comments','Yes')}  /> <strong>{$LANG.musicplaylist_yes}</strong>{$LANG.musicplaylist_comments_yes}
                <br />

                <input type="radio" name="allow_comments" id="allow_comments" value="No" {$myobj->isCheckedRadio('allow_comments','No')} /> <strong>{$LANG.musicplaylist_no}</strong>{$LANG.musicplaylist_comments_no}
                <br />
                <input type="radio" name="allow_comments" id="allow_comments" value="Kinda" {$myobj->isCheckedRadio('allow_comments','Kinda')} /> <strong>{$LANG.musicplaylist_kinda}</strong>{$LANG.musicplaylist_comments_kinda}                </td>
              </tr>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault"><label for="allow_ratings">{$LANG.musicplaylist_allow_ratings}</label></td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                <input type="radio" name="allow_ratings" id="allow_ratings" value="Yes" {$myobj->isCheckedRadio('allow_ratings','Yes')} /> <strong>{$LANG.musicplaylist_yes}</strong>{$LANG.musicplaylist_ratings_yes}
                <br />
                <input type="radio" name="allow_ratings" id="allow_ratings" value="No" {$myobj->isCheckedRadio('allow_ratings','No')} />
                <strong>{$LANG.musicplaylist_no}</strong>{$LANG.musicplaylist_ratings_no}
                <br />
                {$LANG.musicplaylist_ratings_helptips}                 </td>
              </tr>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">{$LANG.musicplaylist_allow_embed}</td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                <input type="radio" name="allow_embed" id="allow_embed" value="Yes" {$myobj->isCheckedRadio('allow_embed','Yes')} /> <strong>{$LANG.musicplaylist_enabled_embed}:</strong> {$LANG.musicplaylist_embed_yes}
                <br />
                <input type="radio" name="allow_embed" id="allow_embed" value="No" {$myobj->isCheckedRadio('allow_embed','No')} />
                <strong>{$LANG.musicplaylist_disabled_embed}:</strong> {$LANG.musicplaylist_embed_no}
               </td>
              </tr>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">&nbsp;</td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">

                    <input  type="hidden" class="clsSubmitButton" name="playlist_id" id="playlist_id" value="{$myobj->getFormField('playlist_id')}" />
                  <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" class="clsSubmitButton" name="playlist_submit" id="playlist_submit" value="{if $myobj->getFormField('playlist_id') != ''}{$LANG.musicplaylist_update_playlist_label}{else}{$LANG.musicplaylist_create_palylist}{/if}" tabindex="{smartyTabIndex}"></span></div>
                {if $myobj->chkIsAdminSide()}
                	<div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="{$LANG.musicplaylist_Cancel_label}" onclick="Redirect2URL('{$CFG.site.url}admin/music/musicPlaylist.php')"tabindex="{smartyTabIndex}"></span></div>
                {else}
                	<div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="{$LANG.musicplaylist_Cancel_label}" onclick="Redirect2URL('{$myobj->createplaylist_url}')"tabindex="{smartyTabIndex}"></span></div>
                {/if} 
                </td>
              </tr>
            </table>
          </div>
  </form>
  {/if}
    {if $myobj->isShowPageBlock('list_playlist_block') && !$myobj->chkIsAdminSide()}
    	<div id="selMusicPlaylistManageDisplay" class="clsLeftSideDisplayTable">
        	<p class="clsStepsTitle">{$LANG.musicplaylist_title}</p>
            {if $myobj->isResultsFound()}
                {if $CFG.admin.navigation.top}
						{$myobj->setTemplateFolder('general/','music')}
                        <div class="clsAudioPaging">{include file=pagination.tpl}</div>
                {/if}
                <form id="deleMusicForm" name="deleMusicForm" method="post" action="{$myobj->getCurrentUrl(true)}">
                    <div class="clsDataTable">
                        <table class="clsMyMusicPlaylistTbl">
                            <tr>
                                <th><input type="checkbox" name="check_all" id="check_all" onclick="CheckAll(document.deleMusicForm.name, document.deleMusicForm.check_all.name)" /></th>
                                <th>{$LANG.musicplaylist_image}</th>
                                <th>{$LANG.musicplaylist_name}</th>
                                <th>{$LANG.musicplaylist_totla_music}</th>
                                <th colspan="4" class="clsUserActionTh">{$LANG.musicplaylist_user_action}</th>
                            </tr>
                            {foreach key=musicPlaylistKey item=musicplaylist from=$myobj->list_playlist_block.showPlaylists}
                            <tr>
                                <td><input type="checkbox" name="forum_ids[]" id="check" tabindex="{smartyTabIndex}" value="{$musicplaylist.playlist_id}" onClick="disableHeading('deleMusicForm');"/></td>
                                <td>
                                    <div class="clsMultipleImage clsPointer" onclick="Redirect2URL('{$musicplaylist.playlist_view_link}')" title="{$musicplaylist.playlist_name}">
                                        {if $musicplaylist.getPlaylistImageDetail.total_record gt 0}
                                            {foreach key=playlistImageDetailKey item=playlistImageDetailValue from=$musicplaylist.getPlaylistImageDetail.row}
                                                <table><tr><td><img src="{$playlistImageDetailValue.playlist_path}" /></td></tr></table>
                                            {/foreach}
                                            {if $musicplaylist.getPlaylistImageDetail.total_record lt 4}
                                            	{section name=foo start=0 loop=$musicplaylist.getPlaylistImageDetail.noimageCount step=1}
                                           			<table><tr><td><img  width="65" height="44" src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_M.jpg" /></td></tr></table>
                                        		{/section}	
                                            {/if}
                                        {else}    
                                            <div class="clsSingleImage"><img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" /></div>
                                        {/if}    
                                    </div>
                               	</td>
                                <td><a href="{$musicplaylist.playlist_view_link}" title="{$musicplaylist.playlist_name}" >{$musicplaylist.playlist_name}</a></td>
                                <td>{$musicplaylist.total_tracks}</td>
                                <td><a href="{$musicplaylist.playlist_view_link}" title="{$LANG.musicplaylist_manage_music}" >{$LANG.musicplaylist_manage_music}</a></td>
                                <td><a href="{$musicplaylist.edit_link}" title="{$LANG.musicplaylist_edit_playlist}">{$LANG.musicplaylist_edit_playlist}</a></td>                                
								<td><a href="javascript:void(0);" title="{$LANG.musicplaylist_delete_playlist}" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action','playlist_ids', 'confirmMessageSingle'), Array('delete','{$musicplaylist.playlist_id}', '{$LANG.musicplaylist_delete_confirmation}'), Array('value','value', 'innerHTML'), -100, -500);">{$LANG.musicplaylist_delete_playlist}</a></td>                            
								<td><a href="javascript:void(0);" onclick="managePlaylistReorder('{$musicplaylist.record.playlist_id}')" title="{$LANG.musicplaylist_organize_playlist}">{$LANG.musicplaylist_organize_playlist}</a></td></tr>
                            {/foreach}
                            <tr>
                                <td>&nbsp;</td>
                                <td colspan="6">
                                <div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" class="clsSubmitButton" name="button" id="button" value="{$LANG.musicplaylist_delete}" onClick="getMultiCheckBoxValue('deleMusicForm', 'check_all', '{$LANG.musicplaylist_err_tip_select_titles}');if(multiCheckValue!='') getAction('delete')"/></span></div>                                </td>
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
                    <p>{$LANG.musicplaylist_no_records_found}</p>
                 </div>
               {/if}
        </div>
    {/if}
</div>
{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_bottom"}