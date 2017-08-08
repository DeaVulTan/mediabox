	<div class="clsViewAlbumPageContainer">
		{if $myobj->total_records}
            <form id="albumManage" name="albumManage" method="post" action="">
                    <div class="clsSelectAllLinks clsOverflow">
                        <p class="clsListCheckBox"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onClick="CheckAll(document.albumManage.name, document.albumManage.check_all.name)"/> </p>
                <input  type="hidden" name="start" id="start" value="{$myobj->getFormField('start')}" />
				{if isMember()}
			  <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" value="{$LANG.viewalbumlist_add_label}" onClick="getMultiCheckBoxValue('albumManage', 'check_all', '{$LANG.viewalbumlist_select_titles}');if(multiCheckValue!='') playInPlayListPlayer(multiCheckValue);"/></span></p>
			  <!-- <p class="clsCancelButton-l"><span class="clsCancelButton-r" id="quick_mix"><input type="submit" value="{$LANG.viewalbumlist_add_to_quickmix}" onClick="getMultiCheckBoxValue('albumManage', 'check_all', '{$LANG.viewalbumlist_add_to_quickmix}');if(multiCheckValue!='') quickMixShowHideDiv();"/></span></p>-->
                                             <!--<p class="clsLinksButton"><span><input type="submit" name="quick_mix" id="quick_mix" value="{$LANG.viewalbumlist_quick_mix_label}" /></span></p>-->
            {if $myobj->allow_quick_mixs}
		    <p class="clsCancelButton-l"><span class="clsCancelButton-r" id="quick_mix"><input type="button" value="{$LANG.common_music_add_to_quick_mix}" onClick="getMultiCheckBoxValueForQuickMix('albumManage', 'check_all', '{$LANG.musicManage_err_tip_select_musics}');if(quickMixmultiCheckValue!='') updateMusicsQuickMixCount(quickMixmultiCheckValue);"/></span></p>
            {/if}
                <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input  type="button" name="save_playlist" id="save_playlist" value="{$LANG.common_music_add_to_playlist}"
                    onClick="getMultiCheckBoxValue('albumManage', 'check_all', '{$LANG.viewalbumlist_select_titles}');if(multiCheckValue!='') return populateMyPlayList('{$myobj->getCurrentUrl(true)}', 'select', multiCheckValue);"/></span></p>
                 {if $myobj->getFormField('user_id') == $CFG.user.user_id}
					<!--<p class="clsLinksButton"><span><input type="button" name="button" id="button" value="{$LANG.viewalbumlist_delete}" onClick="getMultiCheckBoxValue('albumManage', 'check_all', '{$LANG.viewalbumlist_select_titles}');if(multiCheckValue!='') return Confirmation('selMsgConfirm', 'msgConfirmform', Array('action','song_id', 'album_id', 'confirmMessage'), Array('delete', multiCheckValue,  '{$myobj->getFormField('album_id')}', '{$LANG.viewalbumlist_delete_confirmation}'), Array('value', 'value', 'value', 'innerHTML'), -100, -500);" /></span></p>-->
                 {/if}
                {else}
                    <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" name="add" id="add" value="{$LANG.viewalbumlist_add_label}"  onclick="getMultiCheckBoxValue('albumManage', 'check_all', '{$LANG.viewalbumlist_select_titles}');if(multiCheckValue!='') playInPlayListPlayer(multiCheckValue);"/></span></p>
                    <!--<p class="clsLinksButton"><span><input type="submit" name="quick_mix" id="quick_mix" value="{$LANG.viewalbumlist_quick_mix_label}"  onclick="redirect('{$myobj->is_not_member_url}')"/></span></p>-->
                    <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input 	 type="button" name="save_playlist" id="save_playlist" value="{$LANG.viewalbumlist_save_label}"  onclick="redirect('{$myobj->is_not_member_url}')"/></span></p>
                {/if}
                    </div>
                    <div id="clsMsgDisplay_playlist_success" class="clsDisplayNone clsPlaylistSuccess"></div>
					<div class="clsAlbumListingMainBlock">
                    {foreach key=musicKey item=musicValue from=$displayAlbumSong_arr.row}
                        <div class="clsListContents"> 
                        <div class="clsOverflow"> 
                            <p class="clsListCheckBox"><input type="checkbox" class="clsCheckRadio" name="song_ids[]" value="{$musicValue.record.music_id}" onClick="disableHeading('albumManage');" tabindex="{smartyTabIndex}"/></p>
                            <div class="clsThumb">
                                <div class="clsLargeThumbImageBackground">
                                   <a href="{$musicValue.viewmusic_url}" class="ClsImageContainer ClsImageBorder1 Cls132x88">
                                        {if $musicValue.music_image_src !=''}
                                        <img src="{$musicValue.music_image_src}" {$myobj->DISP_IMAGE(132, 88, $musicValue.record.thumb_width, $musicValue.record.thumb_height)} title="{$musicValue.record.music_title}" alt="{$musicValue.record.music_title|truncate:10}" title="{$musicValue.record.music_title}"/>
                                        {else}
                                        <img   width="132" height="88" src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" title="{$musicValue.record.music_title}" alt="{$musicValue.record.music_title|truncate:10}" />
                                        {/if}
                                    </a>
                                </div>
								<div class="clsTime"><!---->{$musicValue.playing_time}</div>
                            </div>
                            <div class="clsPlayerImage">
							<div>{$myobj->populateMusicRatingImages($musicValue.record.rating, 'audio', '', '', 'music')}</div>
							<div class="clsOverflow clsPlayQuickmix clsFloatRight">
										<div class="clsFloatRight">
                                          {if $musicValue.add_quickmix}
                                                {if $musicValue.is_quickmix_added}
                                                      <p class="clsQuickMix" id="quick_mix_added_{$musicValue.record.music_id}"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.viewalbumlist_added_quickMixs}">{$LANG.common_music_quick_mix}</a></p>
                                                {else}
                                                      <p class="clsQuickMix" id="quick_mix_added_{$musicValue.record.music_id}" style="display:none"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.viewalbumlist_added_quickMixs}">{$LANG.common_music_quick_mix}</a></p>

                                                      <p class="clsQuickMix" id="quick_mix_{$musicValue.record.music_id}"><a href="javascript:void(0)" onClick="updateMusicsQuickMixCount('{$musicValue.record.music_id}')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="{$LANG.viewalbumlist_add_to_quickmix}">{$LANG.common_music_quick_mix}</a></p>
                                                {/if}
                                           {/if}
										   </div>
                                        <div class="clsPlayerIcon clsFloatRight">
                                            <a class="clsPlaySong" id="play_music_icon_{$musicValue.record.music_id}" onClick="playSelectedSong({$musicValue.record.music_id})" href="javascript:void(0)" ></a>
                                            <a class="clsStopSong" id="play_playing_music_icon_{$musicValue.record.music_id}" onClick="stopSong({$musicValue.record.music_id})" style="display:none" href="javascript:void(0)"></a>
                                        </div>
										   </div>
										  
                             </div>
                            <div class="clsContentDetails">
                                    <p class="clsHeading" title="{$musicValue.record.music_title}"><a href="{$musicValue.viewmusic_url}">{$musicValue.record.music_title}</a></p>
                                    <p class="clsAlbumLink" title="{$musicValue.record.album_title}">{$LANG.album_title}:<a href="{$musicValue.musiclistalbum_url}">{$musicValue.record.album_title}</a></p>
                                    <p class="clsTrackLink">{$LANG.artist_by}<a href="{$musicValue.viewprofile_url}" class="clsLink" title="{$musicValue.record.user_name}">{$musicValue.record.user_name}</a></p>
                                   <p class="clsGeneres" title="{$musicValue.record.music_category_name}">{$LANG.music_genre_in}<a href="{$musicValue.musiccategorylist_url}">{$musicValue.record.music_category_name}</a></p>
                                    
                             </div>
							 </div>
							 <div>
							  {literal}
											<script type="text/javascript">										
												$Jq(document).ready(function(){
													$Jq("#trigger_{/literal}{$musicValue.record.music_id}{literal}").click(function(){
														displayMusicMoreInfo('{/literal}{$musicValue.record.music_id}{literal}');
														return false;
													});
												});										
											</script>
                                  		  {/literal}
										   <div class="clsMoreInfoContainer clsOverflow">
											  <a class="clsMoreInformation" id="trigger_{$musicValue.record.music_id}" href="javascript:void(0);">
												  <span>{$LANG.viewalbumlist_more_label}</span>
											  </a>
											 </div>
							<div class="clsMoreInfoBlock" id="panel_{$musicValue.record.music_id}" style="display:none;">
								<div class="clsMoreInfoContent clsOverflow">
								<div class="clsOverflow">
								<p id='anchor_id'></p>
                                       <table>
									   		<tr>
												<td>
                                            <span>{$LANG.viewalbumlist_artist_by_label}</span>
                                           <span class="clsMoreInfodata"> {$myobj->getArtistLink($musicValue.record.music_artist, true, 0)}</span>
                                       		</td>
											<td>
                                            <span>{$LANG.viewalbumlist_added_label}</span>
                                           <span class="clsMoreInfodata"> {$musicValue.record.date_added}</span>
                                        </td>
									   </tr>
                                        <tr>
											<td>
                                            <span>{$LANG.viewalbumlist_plays_label}</span>
                                           <span class="clsMoreInfodata"> {$musicValue.record.total_plays}</span>
                                        </td>
										 <td>
                                            <span>{$LANG.viewalbumlist_comments_label}</span>
                                           <span class="clsMoreInfodata"> {$musicValue.record.total_comments}</span>
                                        </td>
									   </tr>
                                        <tr>
											<td>
                                            <span>{$LANG.viewalbumlist_favorited_label}</span>
                                           <span class="clsMoreInfodata"> {$musicValue.record.total_favorites}</span>
                                        </td>
										 <td>
                                            <span>{$LANG.viewalbumlist_rated_label}</span>
                                           <span class="clsMoreInfodata"> {$musicValue.record.rating_count}</span>
                                        </td>
									   </tr>
                                   </table>
                                   </div>
                                   <p class="clsMoreinfoTags">{$LANG.viewalbumlist_tags_label}: {if $musicValue.record.music_tags}{$myobj->getMusicTagsLinks($musicValue.record.music_tags,5)}{else}{$LANG.common_not_available}{/if}</p>
                                    <p class="clsDescription" title="{$musicValue.record.music_caption}"><span class="clsLabel">{$LANG.viewalbumlist_description_label}</span> {if $musicValue.record.music_caption}{$musicValue.record.music_caption}{else}{$LANG.common_not_available}{/if}</p>
                            </div>
                         </div>
						 </div>
                 </div>
                    {/foreach}
					</div>
                    <div id="selMsgCartSuccess" class="clsPopupConfirmation" style="display:none;">
		              <p id="selCartAlertSuccess"></p>
		              <form name="msgCartFormSuccess" id="msgCartFormSuccess" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
		                <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_option_ok}"
		                tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
		              </form>
		            </div>
       				 <input type="hidden" name="start" id="start" value="{$myobj->getFormField('start')}" />
                     <div class="clsOverflow">
                         <div  id="albumSongs_Paging" class="clsAudioHorizontalPaging">
                            <ul>
                                <li> <a href="javascript:void(0);" class="{$myobj->activeClsPrevious}" title="{$LANG.common_previous}" {if $myobj->isPreviousButton} onclick="musicAlbumAjaxPaging('?ajax_page=true&amp;page=pagenation&album_id={$viewAlbumInformation.music_album_id}&user_id={$myobj->getFormField('user_id')}', 'perv')" {/if}>{$LANG.viewalbumlist_pageing_previous}</a>  </li>
                                <li><a href="javascript:void(0);"  class="{$myobj->activeClsNext}" title="{$LANG.common_next}" {if $myobj->isNextButton} onclick="musicAlbumAjaxPaging('?ajax_page=true&amp;page=pagenation&album_id={$viewAlbumInformation.music_album_id}&user_id={$myobj->getFormField('user_id')}', 'next')" {/if} >{$LANG.viewalbumlist_pageing_next}</a></li>
                            </ul>
                        </div>
                    </div>
	            </form>
      {else}
      	<div class="clsNoRecordsFound">{$LANG.viewalbumlist_no_record_found_err_tip}</div>
      {/if}
    </div>
{* FOR ALBUM PLAYER *}
		<div id="view_album_player_div" class="clsHiddenPlayer"><!----></div>
{* FOR GENERATE ALBUM PLAYER *}