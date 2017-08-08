<script language="javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti');
</script>
<div id="selMyPlaylists">
{$myobj->setTemplateFolder('general/','video')}
{include file='box.tpl' opt='display_top'}
	<div>
    <div class="clsPageHeading">
    <h2>{$LANG.playlist_create}</h2>
    </div>
    {if $myobj->isShowPageBlock('msg_form_success_create')}
     <div id="selMsgSuccess">
        <p>{$myobj->getCommonSuccessMsg()}</p>
     </div>
    {/if}
    {if $myobj->isShowPageBlock('msg_form_error_create')}
         <div id="selMsgError">
        <p>{$myobj->getCommonErrorMsg()}</p>
     </div>
    {/if}
    <div class="clsDataTable" id="selUploadBlock">
    <form id="videoPlaylistManageFrm" name="videoPlaylistManagefrm" action="{$myobj->getCurrentUrl(false)}" method="post" >
    <input type="hidden" name="use" value="{$myobj->getFormField('use')}" />
    <table class="clsCreateAlbumTable">
                <tr>
                    <td class="clsFormFieldCellDefault"><label for="playlist_name">{$myobj->videoplaylist_playlist_name_lang}{$myobj->displayCompulsoryIcon()}</label></td>
                    <td class="clsFormFieldCellDefault">{$myobj->getFormFieldErrorTip('playlist_name')}
                    <input class="clsTextBox" type="text" name="playlist_name" id="playlist_name" value="{$myobj->getFormField('playlist_name')}" tabindex="{smartyTabIndex}">
                     {$myobj->ShowHelpTip('playlist_name')}
                    </td>
                </tr>
                <tr>
                    <td class="clsFormFieldCellDefault"><label for="playlist_description">{$LANG.playlist_description}{$myobj->displayCompulsoryIcon()}</label></td>
                    <td class="clsFormFieldCellDefault">{$myobj->getFormFieldErrorTip('playlist_description')}
                    <textarea type="text" name="playlist_description" id="playlist_description" cols="20" tabindex="{smartyTabIndex}">{$myobj->getFormField('playlist_description')}</textarea>
                    {$myobj->ShowHelpTip('playlist_description')}
                    </td>
                </tr>
                <tr>
                     <td class="clsFormFieldCellDefault"><label for="playlist_tags">{$LANG.playlist_tags}{$myobj->displayCompulsoryIcon()}</label></td>
                    <td class="clsFormFieldCellDefault">{$myobj->getFormFieldErrorTip('playlist_tags')}
                    <input class="clsTextBox" type="text" name="playlist_tags" id="playlist_tags"  value="{$myobj->getFormField('playlist_tags')}" tabindex="{smartyTabIndex}"/>
                    {$myobj->ShowHelpTip('playlist_tags')}
                    </td>
                </tr>
                {*<tr>
                    <td><label>{$LANG.playlist_access_type}</label></td>
                    <td>
                        {$LANG.playlist_access_description}&nbsp; <input type="radio" name="playlistAccess" value="Public" checked="checked" class="playlistAccess" tabindex="{smartyTabIndex}"/>{$LANG.common_yes_option} &nbsp; <input type="radio" name="playlistAccess"  value="Private" class="playlistAccess" tabindex="{smartyTabIndex}"/>&nbsp; {$LANG.common_no_option}
                    </td>
                </tr>*}

                <tr>
                	<td></td><td>   <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="playlist_submit" id="playlist_submit" tabindex="{smartyTabIndex}" value="{$LANG.playlist_create}"/></div></div>
                    </td>
                </tr>

                </table>
               </form>
            </div>
    </div>
	{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div class="clsPageHeading">
  	<h2>{$LANG.videoplaylist_title}</h2>
</div>

    {if $myobj->isResultsFound()}
	<!--- Delete Single Playlists --->
	<div id="selLeftNavigation">
		<div id="selMsgConfirm" style="display:none;" class="clsPopupConfirmation">
    		<p>{$LANG.videoplaylist_delete_confirmation}</p>
	      	<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">

							<p id="selImageBorder" class="clsPlainImageBorder">
                                <span id="selPlainCenterImage">
                                    <img id="selVideoId" border="0" />
                                </span>
                            </p>

						  	<p><input type="submit" class="clsSubmitButton" name="delete" id="delete" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
			              	 <input type="button" class="clsSubmitButton" name="no" id="no" value="{$LANG.common_no_option}"
                                            tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
			              	<input type="hidden" name="playlist_id" id="playlist_id"/></p>
							{*$myobj->populateHidden(array('start'))*}

	      	</form>
	    </div>
		<!--- Delete Multi Videos --->
		<div id="selMsgConfirmMulti" style="display:none;" class="clsMsgConfirm">
    		<p>{$LANG.videoplaylist_multi_delete_confirmation}</p>
	      	<form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">

						  	<p><input type="submit" class="clsSubmitButton" name="delete" id="delete" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
			              	<input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}"
                             onClick="return hideAllBlocks()" />
			              	<input type="hidden" name="playlist_id" id="playlist_id"/></p>
							{*$myobj->populateHidden(array('start'))*}

	      	</form>
	    </div>
		{if $myobj->isShowPageBlock('msg_form_error')}
		<div id="selMsgError">
			<p>{$myobj->getCommonErrorMsg()}</p>
		</div>
        {/if}
        {if $myobj->isShowPageBlock('msg_form_success')}
    	<div id="selMsgSuccess">
			<p>{$myobj->getCommonErrorMsg()}</p>
		</div>
        {/if}
		{if $myobj->isShowPageBlock('my_playlist_form')}
            <div id="selMyPlaylistsDisplay" class="clsLeftSideDisplayTable">
            {if $myobj->isResultsFound()}
                {if $CFG.admin.navigation.top}
                    {$myobj->setTemplateFolder('general/')}
                    {include file=pagination.tpl}
                 {/if}
                <form name="deleVideoForm" id="deleVideoForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                    <div class="clsDataTable">
                        <table summary="" class="clsMyVideoPlaylistTbl">
                            <tr>
                                <th>
                                <input type="checkbox" class="clsCheckRadio" name="check_all"
                                onclick="CheckAll(document.deleVideoForm.name, document.deleVideoForm.check_all.name)" />
                                </th>
                                <th>{$LANG.videoplaylist_playlist_image}</th>
                                <th>{$LANG.videoplaylist_playlist_name}</th>
                                <th class="clsPlaylistVideos">{$LANG.videoplaylist_videos}</th>
	                            {*<th >{$LANG.videoplaylist_access_type}</th>*}
                                <th class="clsUserActionTd">{$LANG.videoplaylist_user_action}</th>
                            </tr>
                            {foreach from=$myobj->my_playlists_form item=playlist}
                            <tr>
                                <td class="clsWidth20">
                                    <input type="checkbox" class="clsCheckRadio" name="playlist_ids[]" value="{$playlist.playlist_id}" tabindex="{smartyTabIndex}"
                                    {$playlist.checked} onClick="disableHeading('deleVideoForm');"/>
                                </td>
                                {if $playlist.video_path}
                                <td id="selVideoGallery" class="clsWidth90">
                                    <a id="{$playlist.anchor}" href="#"></a>
                                    <p id="selImageBorder" class="clsViewThumbImage">
                                        <div  class="clsThumbImageLink clsPointer">
                                            <a href="{$playlist.playlist_view_link}" class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                                          	  <img src="{$playlist.video_path}" {$playlist.disp_image} border="0" />
                                            </a>
                                        </div>
                                    </p>
                                </td>
                                {else}
                                <td id="selVideoGallery">
                                    <a id="{$anchor}" href="#"></a>
                                    <p id="selImageBorder">
                                        <div onclick="return false;" class="clsThumbImageLink clsPointer">
                                           <div class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
			                                   <img src="{$playlist.video_path}" width="{$CFG.admin.videos.small_width}" />
                                           </div>
		                             </div>
                                    </p>
                                </td>
                                {/if}
                                <td id="selPlaylistName">
                                    <p>
                                        <a href="{$playlist.playlist_view_link}">{$playlist.playlist_name}</a>
                                    </p>
                                </td>
                                <td class="clsPlaylistVideos">{$playlist.total_videos}</td>
                               {* <td class="clsPlaylistType">{$playlist.record.playlist_access_type}</td>*}
                                <td class="clsUserPlaylistActions">
                                    <p class="clsEdit">
                                        <span><a href="{$playlist.playlist_edit_link}">{$LANG.playlist_edit}</a></span>
                                    </p>
                                    <p class="clsDelete">
                                    <span><a onclick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                    Array('act','playlist_id', 'selVideoId', 'msgConfirmText'), Array('delete','{$playlist.playlist_id}', '{$playlist.video_path}','{$LANG.videoplaylist_delete_confirmation}'), Array('value','value', 'src', 'innerHTML'), -100, -500);" title="{$LANG.videoplaylist_delete_playlist}" class="clsVideoVideoEditLinks" href="#">{$LANG.videoplaylist_delete_playlist}</a></span>
                                    </p>
                                </td>
                            </tr>
                            {/foreach}
                            <tr>
                                <td></td><td colspan="5">
                                    <a href="#" id="dAltMulti"></a>
                                     <div class="clsGreyButtonLeft">
                                         <div class="clsGreyButtonRight">
                                             <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.common_delete_option}" onClick="return deleteVideoMultiCheck('{$LANG.common_check_atleast_one}','dAltMulti','{$LANG.videoplaylist_multi_delete_confirmation}','deleVideoForm','playlist_id')" />
                                         </div>
                                     </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
                {if $CFG.admin.navigation.bottom}
                    <div id="bottomLinks">
                       {include file='pagination.tpl'}
                     </div>
                {else}
                    <div id="selMsgAlert">
                    <p>{$LANG.videoplaylist_no_records_found}</p>
                </div>
                {/if}
            {/if}
            </div>
        {/if}
	</div>
    {else}
    	 <div id="selMsgAlert">
            <p>{$LANG.common_video_no_records_found}</p>
        </div>
   	{/if}
{$myobj->setTemplateFolder('general/', 'video')}
{include file='box.tpl' opt='display_bottom'}
</div>