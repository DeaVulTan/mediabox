    <div class="clsViewPlayListPageContainer">
		{if $myobj->total_records}
            <form id="playlistManage" name="playlistManage" method="post" action="">
                    <div class="clsSelectAllLinks clsOverflow">
                        <p class="clsListCheckBox"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.playlistManage.name, document.playlistManage.check_all.name)"/> </p>


                <input  type="hidden" name="start" id="start" value="{$myobj->getFormField('start')}" />
                <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" name="add" id="add" value="{$LANG.viewplaylist_add_label}" onclick="getMultiCheckBoxValue('playlistManage', 'check_all', '{$LANG.musicManage_err_tip_select_musics}');if(multiCheckValue!='') playInPlayListPlayer(multiCheckValue);"/></span></p>

                {if isMember()}
                	{if $myobj->allow_quick_mixs}
                      <p class="clsCancelButton-l"><span class="clsCancelButton-r" id="quick_mix"><input type="button" value="{$LANG.common_music_add_to_quick_mix}" onclick="getMultiCheckBoxValueForQuickMix('playlistManage', 'check_all', '{$LANG.musicManage_err_tip_select_musics}');if(quickMixmultiCheckValue!='') updateMusicsQuickMixCount(quickMixmultiCheckValue);"/></span></p>
					{/if}
                      <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input  type="button" name="save_playlist" id="save_playlist" value="{$LANG.common_music_add_to_playlist}"
                          onclick="getMultiCheckBoxValue('playlistManage', 'check_all', '{$LANG.musicManage_err_tip_select_musics}');if(multiCheckValue!='') return populateMyPlayList('{$myobj->getCurrentUrl(true)}', 'select', multiCheckValue);"/></span></p>
                       {if $myobj->getFormField('user_id') == $CFG.user.user_id}
                          <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" name="button" id="button" value="{$LANG.viewplaylist_delete}" onclick="getMultiCheckBoxValue('playlistManage', 'check_all', '{$LANG.musicManage_err_tip_select_musics}');if(multiCheckValue!='') return Confirmation('selMsgConfirm', 'msgConfirmform', Array('action','song_id', 'playlist_id', 'confirmMessage'), Array('delete', multiCheckValue,  '{$myobj->getFormField('playlist_id')}', '{$LANG.viewplaylist_delete_confirmation}'), Array('value', 'value', 'value', 'innerHTML'), -100, -500);" /></span></p>
                       {/if}
                {else}
                    <!--<p class="clsLinksButton"><span><input type="submit" name="quick_mix" id="quick_mix" value="{$LANG.viewplaylist_quick_mix_label}"  onclick="redirect('{$myobj->is_not_member_url}')"/></span></p>-->
                    <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input 	 type="button" name="save_playlist" id="save_playlist" value="{$LANG.viewplaylist_save_label}"  onclick="memberBlockLoginConfirmation('{$LANG.login_saveplaylist_err_msg}','{$myobj->is_not_member_url}');return false;"/></span></p>
                {/if}

                    </div>
                    <div id="clsMsgDisplay_playlist_success" class="clsDisplayNone clsPlaylistSuccess"></div>
					<div class="clsPlayListingMainBlock">
                    {foreach key=musicKey item=musicValue from=$displayPlaylistSong_arr.row}
                        <div class="clsListContents">
                        <div class="clsOverflow">
                            <p class="clsListCheckBox"><input type="checkbox" class="clsCheckRadio" name="song_ids[]" value="{$musicValue.record.music_id}" onclick="disableHeading('playlistManage');" tabindex="{smartyTabIndex}"/></p>
                            <div class="clsThumb">
                                <div class="clsLargeThumbImageBackground">
                                   <a href="{$musicValue.viewmusic_url}" class="ClsImageContainer ClsImageBorder1 Cls144x110">
										{if $musicValue.music_image_src !=''}
										<img src="{$musicValue.music_image_src}" {$myobj->DISP_IMAGE(134, 90, $musicValue.record.thumb_width, $musicValue.record.thumb_height)} title="{$musicValue.record.music_title}" alt="{$musicValue.record.music_title|truncate:10}" />
										{else}
										<img   src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" title="{$musicValue.record.music_title}" alt="{$musicValue.record.music_title|truncate:10}"/>
										{/if}
                                    </a>
                                </div>
								 <div class="clsTime"><!---->{$musicValue.record.playing_time}</div>
                            </div>
                            <div class="clsPlayerImage">
							 <div>{$myobj->populateMusicRatingImages($musicValue.record.rating, 'audio', '', '', 'music')}</div>
							
							<div class="clsPlayQuickmix clsOverflow clsFloatRight">
							{if $musicValue.add_quickmix}
                                                {if $musicValue.is_quickmix_added}
                                                      <p class="clsQuickMix clsFloatRight" id="quick_mix_added_{$musicValue.record.music_id}"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.viewplaylist_added_quick_mix_label}">{$LANG.common_music_quick_mix}</a></p>
                                                {else}
                                                      <p class="clsQuickMix clsFloatRight" id="quick_mix_added_{$musicValue.record.music_id}" style="display:none"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.viewplaylist_added_quick_mix_label}">{$LANG.common_music_quick_mix}</a></p>

                                                      <p class="clsQuickMix clsFloatRight" id="quick_mix_{$musicValue.record.music_id}"><a href="javascript:void(0)" onclick="updateMusicsQuickMixCount('{$musicValue.record.music_id}')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="{$LANG.viewplaylist_quick_mix_label}">{$LANG.common_music_quick_mix}</a></p>
                                                {/if}
                                           {/if}
							</div>
                                    
									
                       
						
                             </div>
                            <div class="clsContentDetails">
                                    <p class="clsHeading" title="{$musicValue.record.music_title}"><a href="{$musicValue.viewmusic_url}" title="{$musicValue.record.music_title}">{$musicValue.record.music_title}</a></p>
                                     <p class="clsAlbumLink" title="{$musicValue.record.album_title}"> {$LANG.album_title}: <a href="{$musicValue.musiclistalbum_url}" title="{$musicValue.record.album_title}">{$musicValue.record.album_title}</a></p>
                                    <p class="clsTrackLink">{$LANG.artist_by} <a href="{$musicValue.viewprofile_url}" class="clsLink" title="{$musicValue.record.user_name}">{$musicValue.record.user_name}</a></p>
                                   <p class="clsGeneres" title="{$musicValue.record.music_category_name}">{$LANG.music_genre_in} <a href="{$musicValue.musiccategorylist_url}" title="{$musicValue.record.music_category_name}">{$musicValue.record.music_category_name}</a></p>
                                   {if $myobj->getFormField('user_id') == $CFG.user.user_id}
                                        <p class="clsDeleteIcon clsOverflow clsPhotoVideoEditLinkson"><a href="javascript:void(0);" title="{$LANG.viewplaylist_delete_label}"  alt="{$LANG.viewplaylist_delete_label}" class="clsPhotoVideoEditLinkson" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('action','song_id', 'playlist_id', 'confirmMessage'), Array('delete', '{$musicValue.record.music_id}',  '{$myobj->getFormField('playlist_id')}', '{$LANG.viewplaylist_delete_confirmation}'), Array('value', 'value', 'value', 'innerHTML'), -100, -500);">{$LANG.viewplaylist_delete_label}</a></p>
                                    {/if}
                             </div>
							</div>
							<div>
							{literal}
                                    <script type="text/javascript">										
										$Jq(window).load(function(){
											$Jq("#trigger_{/literal}{$musicValue.record.music_in_playlist_id}{literal}").click(function(){
												displayMusicMoreInfo('{/literal}{$musicValue.record.music_in_playlist_id}{literal}');
												return false;
											});
										});										
									</script>
                                    {/literal}
						
							 <div class="clsMoreInfoContainer clsOverflow">
                  <a  id="trigger_{$musicValue.record.music_in_playlist_id}" href="javascript:void(0);" class="clsMoreInformation" onclick="moreInformation('musicDetail_{$musicValue.record.music_in_playlist_id}')" title="{$LANG.viewplaylist_song_detailinformation_helptips}"><span>{$LANG.viewplaylist_more_label}</span></a></div>
							   <div id="panel_{$musicValue.record.music_in_playlist_id}" class="clsMoreInfoBlock" style="display:none">
                    <div class="clsMoreInfoContent clsOverflow">
                                    <table>
                                        <tr>
                                           <td>
											<span>{$LANG.viewplaylist_artist_by_label}:</span>
                                             <span class="clsMoreInfodata">{$myobj->getArtistLink($musicValue.record.music_artist, true, 0)}</span>
											</td>
											<td>
                                            <span>{$LANG.viewplaylist_added_label}</span>
                                           <span class="clsMoreInfodata">{$musicValue.record.date_added}</span>
                                       </td>
                                        </tr>
                                       <tr>
                                           <td>
                                           <span>{$LANG.viewplaylist_plays_label}:</span>
                                            <span class="clsMoreInfodata">{$musicValue.record.total_plays}</span>
                                        </td>
										 <td>
                                            <span>{$LANG.viewplaylist_comments_label}</span>
                                             <span class="clsMoreInfodata">{$musicValue.record.total_comments}</span>
                                       </td>
                                        </tr>
                                        <tr>
                                           <td>
                                           <span>{$LANG.viewplaylist_songlistfavorited_label}:</span>
                                            <span class="clsMoreInfodata">{$musicValue.record.total_favorites}</span>
                                       </td>
									    <td>
                                            <span>{$LANG.viewplaylist_rated_label}</span>
                                             <span class="clsMoreInfodata">{$musicValue.record.rating_count}</span>
                                    	 </td>
                                        </tr>
                                   </table>
                                    
                                        
                                       
                                        
                                    <p class="clsMoreinfoTags">{$LANG.viewplaylist_tags_label}: {if $musicValue.record.music_tags}{$myobj->getMusicTagsLinks($musicValue.record.music_tags,5)}{else}{$LANG.common_not_available}{/if}</p>
                                   <p class="clsDescription" title="{$musicValue.record.music_caption}"><span class="clsLabel">{$LANG.viewplaylist_description_label}</span> {if $musicValue.record.music_caption}{$musicValue.record.music_caption}{else}{$LANG.common_not_available}{/if}</p>
                            </div>
							</div>
                         </div>
                       
                    </div>
                    {/foreach}
					</div>
       				 <input type="hidden" name="start" id="start" value="{$myobj->getFormField('start')}" />
                     <div class="clsOverflow">
                         <div  id="playlistSongs_Paging" class="clsAudioHorizontalPaging">
                            <ul>
                                <li> <a href="javascript:void(0);" class="{$myobj->activeClsPrevious}" title="{$LANG.common_previous}" {if $myobj->isPreviousButton} onclick="musicPlaylistAjaxPaging('?ajax_page=true&amp;page=pagenation&playlist_id={$playlistInformation.playlist_id}&user_id={$myobj->getFormField('user_id')}', 'perv')" {/if}>{$LANG.viewplaylist_pageing_previous}</a>  </li>
                                <li><a href="javascript:void(0);"  class="{$myobj->activeClsNext}" title="{$LANG.common_next}" {if $myobj->isNextButton} onclick="musicPlaylistAjaxPaging('?ajax_page=true&amp;page=pagenation&playlist_id={$playlistInformation.playlist_id}&user_id={$myobj->getFormField('user_id')}', 'next')" {/if} >{$LANG.viewplaylist_pageing_next}</a></li>
                            </ul>
                        </div>
                    </div>
	            </form>
      {else}
      	<div class="clsNoRecordsFound">{$LANG.viewplaylist_no_music_found_error_tips}</div>
      {/if}
    </div>
 <div id="selMsgCartSuccess" class="clsPopupConfirmation" style="display:none;">
						              <p id="selCartAlertSuccess"></p>
						              <form name="msgCartFormSuccess" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
						                <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_option_ok}"
						                tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
						              </form>
						            </div>