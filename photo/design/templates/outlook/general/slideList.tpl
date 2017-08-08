{if !isAjaxPage()}
<style type="text/css">
{literal}
.clsDisplayNone
{
display:none;
}
{/literal}
</style>
<script language="javascript" type="text/javascript">
	var selectionError ="{$LANG.playlist_selection_error}";
	var invalidPlaylist="{$LANG.playlist_invalid}";
</script>
<div id="viewPhotoSlidelist" class="clsTextAlignLeft clsOverflow clsPlaylistLabel">
	<div id="clsMsgDisplay_playlist_success" class="clsDisplayNone clsPlaylistSuccess"></div>
    <div class="clsViewTopicLeft">
        <div class="clsViewTopicRight">
        	{if isMember()}
            <a href="{$myobj->getCurrentUrl(true)}" onclick="return populateMyPlayList('{$myobj->getCurrentUrl(true)}', 'create');" title="{$LANG.viewphoto_create_new}">{$LANG.viewphoto_create_new}</a>
            {else}
            <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_comment_slidelist_err_msg}','{$myobj->memberviewPhotoUrl}'); return false;" title="{$LANG.viewphoto_create_new}">{$LANG.viewphoto_create_new}</a>
            {/if}
        </div>
    </div>
    <div class="clsViewTopicLeft">
        <div class="clsViewTopicRight">
        	{if isMember()}
            <a href="{$myobj->getCurrentUrl(true)}" onclick="return populateMyPlayList('{$myobj->getCurrentUrl(true)}', 'select');" title="{$LANG.viewphoto_select_from_list}">{$LANG.viewphoto_select_from_list}</a>
            {else}
            <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_comment_slidelist_err_msg}','{$myobj->memberviewPhotoUrl}'); return false;" title="{$LANG.viewphoto_select_from_list}">{$LANG.viewphoto_select_from_list}</a>
            {/if}
        </div>
    </div>
</div>
<div id="loginDiv" class="clsDisplayNone clsTextAlignLeft clsPlaylistLabelPopup">
</div>
<div id="playlistDiv" class="clsDisplayNone clsPhotoListPopup">
	<div class="clsOverflow">
    	<div class="clsFlagTitle">{$LANG.photoslidelist_label}</div>
     </div>
       	<div id="clsMsgDisplay_playlist_failure" class="clsDisplayNone clsPlaylistSuccess clsAddErrorMsg"></div>
     	<div id="playlistFrmDiv" class="clsFlagTable">
	        <form method="post" name="photoListForm" action="{$myobj->getCurrentUrl()}" autocomplete="off" onsubmit="return false">
            <input type="hidden" name="playlist_access_type" id="playlist_access_type" value="{$myobj->getFormField('playlist_access_type')}" />
        <table>
         <tr>
         	&nbsp;
            <td class="clsTDwidth"><label>{$LANG.photoslidelist_name}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
            <td id="selMyPlayListOpt">
{/if}
{if isAjaxPage()}
				<select name="playlist" id="playlist"  onchange="chkPlaylist('playlist')" tabindex="{smartyTabIndex}">
            		<option value="">{$LANG.photoslidelist_select_slidelist}</option>
                    <option value="#new#">{$LANG.photoslidelist_create_slidelist}</option>
                    {$myobj->generalPopulateArrayPlaylist($playlistInfoViewPhoto, $myobj->getFormField('playlist'), $playlist)}
                </select>
{/if}
{if !isAjaxPage()}
            </td>
         </tr>
         </table>
         <div id="createNewPlaylist" style="display:none">
	         <table>
                <tr>
         			&nbsp;
                    <td class="clsTDwidth"><label>{$LANG.photoslidelist_name}&nbsp;<span class="clsCompulsoryField">{$LANG.important}</span></label></td>
                    <td><input class="clsFlagTextBox clsPhotoListPopupField" type="text" name="playlistTitle" id="playlistTitle" value="" tabindex="{smartyTabIndex}" /></td>
                </tr>
                <tr>
                    <td><label>{$LANG.photoslidelist_description}&nbsp;</label></td>
                    <td><textarea name="playlistDesc" id="playlistDesc" cols="5" tabindex="{smartyTabIndex}" class="clsPhotoListPopupField"></textarea></td>
                </tr>
               </table>
            </div>
            <table>

         <tr>
         	<td class="clsTDwidth"><!-- --></td>
         	&nbsp;
            <td><div class="clsFlagButtonLeft"><div class="clsFlagButtonRight"><input type="button" value="{$LANG.photoslidelist_submit_label}" onclick="createPlayList('{$slide_info.playlistUrl}', photo_id, $Jq('#playlist').val())" tabindex="{smartyTabIndex}" /></div></div></td>
         </tr>
        </table>
        </form>
		</div>
</div>
{/if}
