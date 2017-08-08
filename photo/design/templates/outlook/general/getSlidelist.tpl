{if !isAjaxPage()}
<script type="text/javascript">
	var selectionError ="{$LANG.playlist_selection_error}";
	var invalidPlaylist="{$LANG.playlist_invalid}";
</script>
<div id="loginDiv" class="clsDisplayNone clsTextAlignLeft clsPlaylistLabelPopup">
</div>
<div id="playlistDiv" class="clsDisplayNone clsTextAlignLeft clsPlaylistLabelPopup">
	<div class="clsOverflow">
    	<div class="clsFlagTitle">{$LANG.photoslidelist_label}</div>
	</div>
    <div id="clsMsgDisplay_playlist_failure" class="clsDisplayNone clsPlaylistSuccess"></div>
    <div id="playlistFrmDiv" class="clsFlagTable">
        <input type="hidden" name="playlist_access_type" id="playlist_access_type" value="{$myobj->getFormField('playlist_access_type')}" />
       	<div class="clsRow" id="selMyPlayListOpt">
{/if}
{if isAjaxPage()}
<script type="text/javascript">
	var photo_id ="{$myobj->getFormField('photo_id')}";
</script>
    	    <div class="clsTDLabel">{$LANG.photoslidelist_name}</div>
            <div class="clsTDText">
                <select name="playlist" id="playlist" onchange="chkPlaylist('playlist')" tabindex="{smartyTabIndex}">
                    <option value="">{$LANG.photoslidelist_select_slidelist}</option>
                    <option value="#new#">{$LANG.photoslidelist_create_slidelist}</option>
                    {$myobj->generalPopulateArrayPlaylist($playlistInfoViewPhoto, $myobj->getFormField('playlist'), $playlist)}
                </select>
            </div>
{/if}
{if !isAjaxPage()}
		</div>
        <div id="createNewPlaylist" style="display:none">
            <div class="clsRow">
                <div class="clsTDLabel"><label for="playlist_name">{$LANG.photoslidelist_name}</label><span class="clsCompulsoryField">{$LANG.common_photo_mandatory}</span></div>
                <div class="clsTDText"><input class="clsFields" type="text" name="playlistTitle" id="playlistTitle" />{$myobj->getFormFieldErrorTip('playlist_name')}
                         <p>{$myobj->playlist_name_notes}</p>
                </div>
            </div>
            <div class="clsRow">
                <div class="clsTDLabel"><label for="playlist_description">{$LANG.photoslidelist_description} </label></div>
                <div class="clsTDText"><textarea class="clsFields" name="playlistDesc" id="playlistDesc" cols="45" rows="5"></textarea>{$myobj->getFormFieldErrorTip('playlist_description')}</div>
            </div>
		</div>
        <div class="clsRow">
            <div class="clsTDLabel"><!----></div>
            <div class="clsTDText">
                <p class="clsButton clsSubmitButton-l">
					<span class="clsSubmitButton-r">
                    	<input type="button" value="{$LANG.photoslidelist_submit_label}" onclick="createPlayList('{$playlist_info.playlistUrl}', photo_id, $Jq('#playlist').val())" tabindex="{smartyTabIndex}" />
					</span>
                </p>
            </div>
        </div>
	</div>
</div>
{/if}