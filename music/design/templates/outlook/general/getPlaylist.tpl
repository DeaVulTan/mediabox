{if !isAjaxPage()}
<script type="text/javascript">
	var selectionError ="{$LANG.playlist_selection_error}";
	var invalidPlaylist="{$LANG.playlist_invalid}";
</script>
<div id="loginDiv" class="clsDisplayNone clsTextAlignLeft clsPlaylistLabelPopup">
</div>
<div id="playlistDiv" class="clsDisplayNone clsTextAlignLeft clsPlaylistLabelPopup">
	<div class="clsOverflow">
    	<div class="clsFlagTitle">{$LANG.playlist_title}</div>
	</div>
    <div id="clsMsgDisplay_playlist_failure" class="clsDisplayNone clsPlaylistSuccess"></div>
    <div id="playlistFrmDiv" class="clsFlagTable">
        <input type="hidden" name="playlist_access_type" id="playlist_access_type" value="{$myobj->getFormField('playlist_access_type')}" />        
       	<div class="clsRow" id="selMyPlayListOpt">
{/if}
{if isAjaxPage()}
<script type="text/javascript">
	{if $playlist_option == 'playlist'}
		var music_id ="{$myobj->getFormField('song_id')}";
	{else}
		var music_id ="{$myobj->getFormField('music_id')}";
	{/if}
</script>				
    	    <div class="clsTDLabel">{$LANG.playlist_title}</div>
            <div class="clsTDText">
                <select name="playlist" id="playlist" onchange="chkPlaylist('playlist')" tabindex="{smartyTabIndex}">
                    <option value="">{$LANG.playlist_select}</option>
                    <option value="#new#">{$LANG.playlist_create}</option>
                    {$myobj->generalPopulateArrayPlaylist($playlistInfo, $myobj->getFormField('playlist'), $playlist)}
                </select>
            </div>        
{/if}
{if !isAjaxPage()}
		</div>      
        <div id="createNewPlaylist" style="display:none">        	
            <div class="clsRow">
                <div class="clsTDLabel"><label for="playlist_name">{$LANG.common_playlistname_label}</label><span class="clsCompulsoryField">{$LANG.common_music_mandatory}</span></div>
                <div class="clsTDText"><input class="clsFields" type="text" name="playlist_name" id="playlist_name" />{$myobj->getFormFieldErrorTip('playlist_name')}
                         <p>{$myobj->playlist_name_notes}</p>
                </div>
            </div>
            <div class="clsRow">
                <div class="clsTDLabel"><label for="playlist_description">{$LANG.viewplaylist_description_label} </label></div>
                <div class="clsTDText"><textarea class="clsFields" name="playlist_description" id="playlist_description" cols="45" rows="5"></textarea>{$myobj->getFormFieldErrorTip('playlist_description')}</div>
            </div>
            <div class="clsRow">
                <div class="clsTDLabel"><label for="playlist_tags">{$LANG.common_playlisttags_label}</label><span class="clsCompulsoryField">{$LANG.common_music_mandatory}</span></div>
                <div class="clsTDText"><input class="clsFields" type="text" name="playlist_tags" id="playlist_tags" />{$myobj->getFormFieldErrorTip('playlist_tags')}
                <p>{$myobj->playlist_tags_notes}</p>
                </div>
            </div>
            <div class="clsRow">
                <div class="clsTDLabel"><label for="allow_comments">{$LANG.musicplaylist_allow_comments} </label></div>
                <div class="clsTDText">
                    <p><input type="radio" name="allow_comments" value="Yes" {$myobj->isCheckedRadio('allow_comments','Yes')}  /> <strong>{$LANG.musicplaylist_yes}</strong>{$LANG.musicplaylist_comments_yes}</p>
                    <p><input type="radio" name="allow_comments" value="No" {$myobj->isCheckedRadio('allow_comments','No')} /> <strong>{$LANG.musicplaylist_no}</strong>{$LANG.musicplaylist_comments_no}</p>
                    <p><input type="radio" name="allow_comments" value="Kinda" {$myobj->isCheckedRadio('allow_comments','Kinda')} /> <strong>{$LANG.musicplaylist_kinda}</strong>{$LANG.musicplaylist_comments_kinda} </p>
                </div>
            </div>
            <div class="clsRow">
                <div class="clsTDLabel"><label for="allow_ratings">{$LANG.musicplaylist_allow_ratings}</label></div>
                <div class="clsTDText">
                    <p><input type="radio" name="allow_ratings" value="Yes" {$myobj->isCheckedRadio('allow_ratings','Yes')} /> <strong>{$LANG.musicplaylist_yes}</strong>{$LANG.musicplaylist_ratings_yes}</p>
                    <p><input type="radio" name="allow_ratings" value="No" {$myobj->isCheckedRadio('allow_ratings','No')} /> <strong>{$LANG.musicplaylist_no}</strong>{$LANG.musicplaylist_ratings_no} </p>
                    {$LANG.musicplaylist_ratings_helptips}
                </div>
            </div>
            <div class="clsRow">
                <div class="clsTDLabel"><label for="allow_embed">{$LANG.musicplaylist_allow_embed}</label></div>
                <div class="clsTDText">
                    <p><input type="radio" name="allow_embed" value="Yes" {$myobj->isCheckedRadio('allow_embed','Yes')} /> <strong>{$LANG.musicplaylist_enabled_embed}:</strong> {$LANG.musicplaylist_embed_yes}</p>
                    <p><input type="radio" name="allow_embed" value="No" {$myobj->isCheckedRadio('allow_embed','No')} /> <strong>{$LANG.musicplaylist_disabled_embed}:</strong> {$LANG.musicplaylist_embed_no} </p>
                </div>
            </div>
		</div>
        <div class="clsRow">
            <div class="clsTDLabel"><!----></div>
            <div class="clsTDText">
                <p class="clsButton">
                    <span><input type="button" value="{$LANG.playlist_submit}" onclick="createPlayList('{$playlist_info.playlistUrl}', music_id, $Jq('#playlist').val())" tabindex="{smartyTabIndex}" /></span>
                </p>
            </div>
        </div>
	</div>
</div>
{/if}