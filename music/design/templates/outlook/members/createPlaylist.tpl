{if $myobj->isShowPageBlock('create_playlist_block')}
        <!-- information div start-->
        <div id="errorTips" style="display:none" class="clsErrorMessage">
        </div>
        <!-- information div end-->
        <div class="clsInnerPlaylist">
        	<div id="createPlaylist" class="clsCreatePlaylist">
        	<form id="createPlaylistForm" name="createPlaylistForm" method="post">
                <div class="clsRow" id="playlist">
                	<div class="clsTDLabel">
                    	{$LANG.viewplaylist_playlist_label}
                    </div>
                	<div class="clsTDText">
                        <select name="playlist_name_select" id="playlist_name_select" onchange="playlistSelectBoxAction(this.value, 'playlistContent')">
                        <option value="">{$LANG.viewplaylist_select_titles}</option>
                        <option value="0">{$LANG.viewplaylist_create_playlist_label}</option>
                        {$myobj->generalPopulateArrayPlaylist($playlistInfo, $myobj->getFormField('playlist_name_select'), $playlist)}
                        </select>
                    </div>
                </div>
                <div id="playlistContent" style="display:none">
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
                            <p><input type="radio" name="allow_comments" id="allow_comments" value="Yes" {$myobj->isCheckedRadio('allow_comments','Yes')}  /> <strong>{$LANG.musicplaylist_yes}</strong>{$LANG.musicplaylist_comments_yes}</p>
                            <p><input type="radio" name="allow_comments" id="allow_comments" value="No" {$myobj->isCheckedRadio('allow_comments','No')} /> <strong>{$LANG.musicplaylist_no}</strong>{$LANG.musicplaylist_comments_no}</p>
                            <p><input type="radio" name="allow_comments" id="allow_comments" value="Kinda" {$myobj->isCheckedRadio('allow_comments','Kinda')} /> <strong>{$LANG.musicplaylist_kinda}</strong>{$LANG.musicplaylist_comments_kinda} </p>
                        </div>
                    </div>
                    <div class="clsRow">
                        <div class="clsTDLabel"><label for="allow_ratings">{$LANG.musicplaylist_allow_ratings}</label></div>
                        <div class="clsTDText">
                            <p><input type="radio" name="allow_ratings" id="allow_ratings" value="Yes" {$myobj->isCheckedRadio('allow_ratings','Yes')} /> <strong>{$LANG.musicplaylist_yes}</strong>{$LANG.musicplaylist_ratings_yes}</p>
                            <p><input type="radio" name="allow_ratings" id="allow_ratings" value="No" {$myobj->isCheckedRadio('allow_ratings','No')} /> <strong>{$LANG.musicplaylist_no}</strong>{$LANG.musicplaylist_ratings_no} </p>
                        	{$LANG.musicplaylist_ratings_helptips}
                        </div>
                    </div>
                    <div class="clsRow">
                        <div class="clsTDLabel"><label for="allow_embed">{$LANG.musicplaylist_allow_embed}</label></div>
                        <div class="clsTDText">
                            <p><input type="radio" name="allow_embed" id="allow_embed" value="Yes" {$myobj->isCheckedRadio('allow_embed','Yes')} /> <strong>{$LANG.musicplaylist_enabled_embed}:</strong> {$LANG.musicplaylist_embed_yes}</p>
                            <p><input type="radio" name="allow_embed" id="allow_embed" value="No" {$myobj->isCheckedRadio('allow_embed','No')} /> <strong>{$LANG.musicplaylist_disabled_embed}:</strong> {$LANG.musicplaylist_embed_no} </p>
                        </div>
                    </div>
                </div>
                <div class="clsRow" style="display:none" id="playlist_loader_row">
                	<div class="clsTDLabel"><!----></div>
                    <div class="clsTDText">
                    	<div id="playlist_submitted"></div>
                    </div>
                  </div>
                <div class="clsRow">
                	<div class="clsTDLabel"><!----></div>
                    <div class="clsTDText">
                        <input type="hidden" id="playlist_id" name="playlist_id"  value="{$myobj->getFormField('playlist_id')}"/>
                        <input type="hidden" name="music_id" id="music_id" value="{$myobj->getFormField('music_id')}" />
                         <input type="hidden" name="mode" id="mode" value="{$myobj->getFormField('mode')}" />
                        <p class="clsButton">
                            <span>
                            	<input type="button" name="playlist_submit" id="playlist_submit" value="{$LANG.common_playlistsubmit_label}" onclick="createPlaylist('{$myobj->playlistUrl}')" />                            </span>
                        </p>
                    </div>
                </div>
            </form>
        </div></div>
{/if}