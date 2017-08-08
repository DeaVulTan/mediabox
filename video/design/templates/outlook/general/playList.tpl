{if !isAjaxPage()}
<script language="javascript" type="text/javascript">
var selectionError ="{$LANG.playlist_selection_error}";
var invalidPlaylist="{$LANG.playlist_invalid}";
</script>
<div id="option-tab-1" class="clsDisplayNone clsTextAlignLeft clsOverflow clsPlaylistLabel">
	<div id="clsMsgDisplay_playlist_success" class="clsDisplayNone clsPlaylistSuccess"></div>
	{if !$playlist.is_external_embededcode}
		<div class="clsViewTopicLeft">
			<div class="clsViewTopicRight">
            	{if isMember()}
				<a href="{$myobj->getCurrentUrl(true)}" onclick="return populateMyPlayList('{$myobj->getCurrentUrl(true)}', 'create');" title="{$LANG.viewvideo_create_new}">{$LANG.viewvideo_create_new}</a>
                {else}
                <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.common_video_login_create_playlist_msg}', '{$myobj->notLoginVideoUrl}');return false;" title="{$LANG.viewvideo_create_new}">{$LANG.viewvideo_create_new}</a>
                {/if}
			</div>
		</div>
		<div class="clsViewTopicLeft">
			<div class="clsViewTopicRight">
            	{if isMember()}
				<a href="{$myobj->getCurrentUrl(true)}" onclick="return populateMyPlayList('{$myobj->getCurrentUrl(true)}', 'select');" title="{$LANG.viewvideo_select_from_list}">{$LANG.viewvideo_select_from_list}</a>
                {else}
                <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.common_video_login_create_playlist_msg}', '{$myobj->notLoginVideoUrl}');return false;" title="{$LANG.viewvideo_select_from_list}">{$LANG.viewvideo_select_from_list}</a>
                {/if}
			</div>
		</div>
	{else}
		<p>{$LANG.externalembeded_playlist_message}</p>
	{/if}
</div>
<div id="loginDiv" class="clsDisplayNone clsTextAlignLeft clsPlaylistLabelPopup">
</div>
<div id="playlistDiv" class="clsDisplayNone clsTextAlignLeft clsPlaylistLabel">
<!--{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='flag_top'}-->
<!--	<div class="clsOverflow">
    	<div class="clsFlagTitle">{$LANG.playlist_title}</div>
     </div> -->
       	<div id="clsMsgDisplay_playlist_failure" class="clsDisplayNone clsPlaylistSuccess"></div>
     	<div id="playlistFrmDiv" class="clsFlagTable">
        {if !$playlist.is_external_embededcode}
	        <form method="post" name="playlistfrm" action="{$myobj->getCurrentUrl()}" autocomplete="off" onsubmit="return false">
            <input type="hidden" name="playlist_access_type" id="playlist_access_type" value="{$myobj->getFormField('playlist_access_type')}" />
        <table class="clsTable100">
         <tr>
            <td class="clsTDwidth"><label>{$LANG.playlist_title}</label></td>
            <td id="selMyPlayListOpt">
        {/if}
{/if}
{if isAjaxPage()}
           <select name="playlist" id="playlist" onchange="chkPlaylist('playlist')" tabindex="{smartyTabIndex}">
                <option value="">{$LANG.playlist_select}</option>
                <option value="#new#">{$LANG.playlist_create}</option>
                {if $playlist.record}
                {foreach from=$playlist.item item=playlistItem}
                <option value="{$playlistItem.playlist_id}">{$playlistItem.playlist_name}</option>
                {/foreach}
                {/if}
                </select>
{/if}
{if !isAjaxPage()}
		{if !$playlist.is_external_embededcode}
            </td>
         </tr>
         </table>
         <div id="createNewPlaylist" style="display:none">
	         <table class="clsTable100">
                <tr>
                    <td class="clsTDwidth"><label>{$LANG.playlist_name}&nbsp;<span class="clsCompulsoryField">{$LANG.important}</span></label></td>
                    <td><input class="clsFlagTextBox" type="text" name="playlistTitle" id="playlistTitle" value="" tabindex="{smartyTabIndex}" /></td>
                </tr>
                <tr>
                    <td><label>{$LANG.playlist_description}</label></td>
                    <td><textarea name="playlistDesc" id="playlistDesc" cols="5" tabindex="{smartyTabIndex}"></textarea></td>
                </tr>
                <tr>
                    <td><label>{$LANG.playlist_tags}&nbsp;<span class="clsCompulsoryField">{$LANG.important}</span></label></td>
                    <td><input class="clsFlagTextBox" type="text" name="playlistTags" id="playlistTags" value="" tabindex="{smartyTabIndex}"/></td>
                </tr>
               </table>
            </div>
            <table class="clsTable100">
                {*<tr>
                    <td><label>{$LANG.playlist_access_type}</label></td>
                    <td>
                        {$LANG.playlist_access_description}&nbsp; <input type="radio" name="playlistAccess" value="Public" checked="checked" class="playlistAccess" tabindex="{smartyTabIndex}"/>{$LANG.common_yes_option} &nbsp; <input type="radio" name="playlistAccess"  value="Private" class="playlistAccess" tabindex="{smartyTabIndex}"/>&nbsp; {$LANG.common_no_option}
                    </td>
                </tr>*}
         <tr>
         	<td class="clsTDwidth"><!-- --></td>
            <td><div class="clsFlagButtonLeft"><div class="clsFlagButtonRight"><input type="button" value="{$LANG.playlist_submit}" onclick="createPlayList('{$playlist.playlistUrl}')" tabindex="{smartyTabIndex}" /></div></div></td>
         </tr>
        </table>
        </form>
       	{else}
        	<p>{$LANG.externalembeded_playlist_message}</p>
        {/if}
		</div>
<!--{include file='box.tpl' opt='flag_bottom'}-->
</div>
<script type="text/javascript">
//slideDiv('playlistDiv');
</script>
{/if}