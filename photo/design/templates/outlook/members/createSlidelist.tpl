{if $myobj->isShowPageBlock('create_playlist_block')}
        <!-- information div start-->
        <div id="errorTips" style="display:none" class="clsErrorMessage">
        </div>
        <!-- information div end-->
        <div class="clsOverflow">
        <div class="clsFlagTitle">{$LANG.photoslidelist_label}</div>
        </div>
        <div class="clsInnerPlaylist">
        	<div id="createPlaylist" class="clsCreatePlaylist">
        	<form id="createPlaylistForm" name="createPlaylistForm" method="post">
                <div class="clsRow" id="playlist">
                	<div class="clsTDLabel">
                    	<label for="playlist_name_select">{$LANG.photoslidelist_name}</label>
                    </div>
                	<div class="clsTDText">
                        <select name="playlist_name_select" id="playlist_name_select" onchange="playlistSelectBoxAction(this.value, 'playlistContent')">
	                        <option value="">{$LANG.photoslidelist_select_slidelist}</option>
	                        <option value="0">{$LANG.photoslidelist_create_slidelist}</option>
	                        {$myobj->generalPopulateArrayPlaylist($playlistInfoViewPhoto, $myobj->getFormField('playlist_name_select'), $playlist)}
                        </select>

					{* Commented code used to display slidelist names using div tag and used above select dropdwon to display slidelist names
					<div class="clsOverflow">
						<div class="clsCreateSlideInput">
							<input type="text" class="clsPointer clsCreateSlideBg" onclick="displaySlideList();" name="playlist_name_select_duplicate" id="playlist_name_select_duplicate"  value="{$LANG.viewplaylist_select_titles}"  />
						</div>
					<div>
					{assign var='photoSlideBox' value=70}
                    {assign var='photoSlideScrollBarTracker' value=70}
					<div class="clsCreateSlideScrollBarExternalContainer" id="selSlideDiv" style="display:none">
							<div id="create_slide_scrollbar_container">
								<div id="create_slide_scrollbar_content" style="height:{$photoSlideBox}px;">
									<div id="selSlideListBox">
									<div id="sel0" class="clsPointer" onclick="displayCreateSlideList();">{$LANG.common_create_slidelist}</div>
										{foreach from=$playlistInfo item=result}
											<div id="{$result.slidelist_id}" class="clsPointer" {if !in_array($result.slidelist_id, $playlist)} onclick="displaySlideListValue('{$result.slidelist_id}')" {/if}>{$result.slidelist_name}</div>
										{/foreach}
									</div>
							</div>
						</div>
				   </div>
				   </div>
				   </div> *}

                    </div>
                </div>
                <div id="playlistContent" style="display:none">
                    <div class="clsRow">
                    	<div class="clsTDLabel"><label for="playlist_name">{$LANG.photoslidelist_name}</label><span class="clsCompulsoryField">{$LANG.common_photo_mandatory}</span></div>
                        <div class="clsTDText"><input class="clsFields" type="text" name="playlist_name" id="playlist_name" maxlength="{$CFG.fieldsize.photo_playlist_name.max}"/>{$myobj->getFormFieldErrorTip('playlist_name')}
                        		 <p class="clsNameLimitCharacter">{$myobj->playlist_name_notes}</p>
                        </div>
                    </div>
                    <div class="clsRow">
                    	<div class="clsTDLabel"><label for="playlist_description">{$LANG.photoslidelist_description} </label></div>
                        <div class="clsTDText"><textarea class="clsFields" name="playlist_description" id="playlist_description" cols="45" rows="5"></textarea>{$myobj->getFormFieldErrorTip('playlist_description')}</div>
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
                        <input type="hidden" id="photo_playlist_id" name="photo_playlist_id"  value="{$myobj->getFormField('photo_playlist_id')}"/>
                        <input type="hidden" name="photo_id" id="photo_id" value="{$myobj->getFormField('photo_id')}" />
                         <input type="hidden" name="mode" id="mode" value="{$myobj->getFormField('mode')}" />
						 <input type="hidden" name="playlist_name_select" id="playlist_name_select"  />
                        <p class="clsButton clsSubmitButton-l">
							<span class="clsSubmitButton-r">
                                <input type="button" class="clsPointer" name="playlist_submit" id="playlist_submit" value="{$LANG.photoslidelist_submit_label}" onclick="createPlaylist('{$myobj->playlistUrl}')" />
                           </span>
                        </p>
                    </div>
                </div>
            </form>
        </div></div>
{/if}
