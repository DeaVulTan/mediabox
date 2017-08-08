	<div class="clsViewAlbumPageContainer">
		{if $myobj->total_records}
            <form id="albumManage" name="albumManage" method="post" action="">
            	<div class="clsSelectAllLinks clsOverflow">
                	<p class="clsListCheckBox"><input type="checkbox" class="clsCheckRadio clsRadioButtonBorder" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onClick="CheckAll(document.albumManage.name, document.albumManage.check_all.name)"/> </p>  
                	<input  type="hidden" name="start" id="start" value="{$myobj->getFormField('start')}" />
					{if isMember()}			  
		                <p class="clsCancelButton-l"><span class="clsCancelButton-r" id="quick_mix"><input type="button" value="{$LANG.common_photo_add_to_quick_view}" onClick="getMultiCheckBoxValueForQuickMix('albumManage', 'check_all', '{$LANG.viewalbumlist_select_titles}');if(quickMixmultiCheckValue!='') updatePhotosQuickMixCount(quickMixmultiCheckValue);"/></span></p>
		                <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" value="{$LANG.common_photo_add_to_slidelist}" onClick="getMultiCheckBoxValue('albumManage','check_all','{$LANG.viewalbumlist_select_titles}');if(multiCheckValue!='') manageSlideList(multiCheckValue, '{$myobj->savePlaylistUrl}', '{$LANG.common_create_slidelist}');" /></span></p>
                        
                        <!--p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" value="{$LANG.viewalbumlist_add_label}" onClick="getMultiCheckBoxValue('albumManage', 'check_all', '{$LANG.viewalbumlist_select_titles}');if(multiCheckValue!='') playInPlayListPlayer(multiCheckValue);"/></span></p-->  
                	{else}
                    	<!--p class="clsSubmitButton-l">
                        	<span class="clsSubmitButton-r">
                            	<input type="submit" name="add" id="add" value="{$LANG.viewalbumlist_add_label}"  onclick="redirect('{$myobj->is_not_member_url}')"/>
                            </span>
                        </p-->
                    	<p class="clsCancelButton-l">
                        	<span class="clsCancelButton-r">
                            	<input 	 type="button" name="save_playlist" id="save_playlist" value="{$LANG.viewalbumlist_save_label}"  onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_err_msg}');return false;"/>
                            </span>
                        </p>
                	{/if}
                </div>
                    {foreach key=photoKey item=photoValue from=$displayAlbumPhoto_arr.row}
                        <div class="clsListContents">
                        <div class="clsOverflow"> 
                            <p class="clsListCheckBox"><input type="checkbox" class="clsCheckRadio clsRadioButtonBorder" name="photo_ids[]" value="{$photoValue.record.photo_id}" onClick="disableHeading('albumManage');" tabindex="{smartyTabIndex}"/></p>
                            <div class="clsThumb">
                                <div class="clsLargeThumbImageBackground">
                                   <div class="cls132x88PXthumbImage clsThumbImageOuter" onclick="Redirect2URL('{$photoValue.viewphoto_url}')">
                                        <div class="clsrThumbImageMiddle">
                                            <div class="clsThumbImageInner">
                                                {if $photoValue.photo_image_src !=''}
                                                <img src="{$photoValue.photo_image_src}" {$photoValue.photo_disp} title="{$photoValue.record.photo_title}" />
                                                {else}
                                                <img   src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" title="{$photoValue.record.photo_title}"/> 
                                                {/if} 	
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <div class="clsPlayerImage">
                                        <div class="clsPlayerIcon">
                                            <a class="clsPlayPhoto" id="play_photo_icon_{$photoValue.record.photo_id}" onClick="playSelectedPhoto({$photoValue.record.photo_id})" href="javascript:void(0)" ></a>
                                            <a class="clsStopPhoto" id="play_playing_photo_icon_{$photoValue.record.photo_id}" onClick="stopPhoto({$photoValue.record.photo_id})" style="display:none" href="javascript:void(0)"></a>                                        
                                        </div>
                                 {if $photoValue.add_quickmix} 		           
                                    {if $photoValue.is_quickmix_added}
                                          <p class="clsQuickMix" id="quick_mix_added_{$photoValue.record.photo_id}"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.viewalbumlist_added_quickMixs}">{$LANG.common_photo_quick_mix}</a></p>                                                
                                    {else}
                                          <p class="clsQuickMix" id="quick_mix_added_{$photoValue.record.photo_id}" style="display:none"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.viewalbumlist_added_quickMixs}">{$LANG.common_photo_quick_mix}</a></p>                                                
                                    
		                                  <p class="clsQuickMix" id="quick_mix_{$photoValue.record.photo_id}"><a href="javascript:void(0)" onClick="updatePhotosQuickMixCount('{$photoValue.record.photo_id}')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="{$LANG.viewalbumlist_add_to_quickmix}">{$LANG.common_photo_quick_mix}</a></p>
                                    {/if}
                                 {/if}       
                             </div>
                            <div class="clsContentDetails">
                                    <p class="clsHeading" title="{$photoValue.record.photo_title}"><a href="{$photoValue.viewphoto_url}">{$photoValue.wordWrap_mb_ManualWithSpace_photo_title}</a></p>
                                    <p class="clsAlbumLink" title="{$photoValue.record.photo_album_title}"><strong>{$LANG.album_in}<a href="{$photoValue.photolistalbum_url}">{$photoValue.wordWrap_mb_ManualWithSpace_album_title}</a></strong></p>
                                    <p class="clsType" title="{$photoValue.record.photo_category_name}">{$LANG.genre_in}<a href="{$photoValue.photocategorylist_url}">{$photoValue.wordWrap_mb_ManualWithSpace_photo_category_name}</a></p> 
                                    <div>{$myobj->populateRatingImages($photoValue.record.rating, 'audio', '', '', 'photo')}</div>
                             </div>
                         </div>
                        <div class="clsMoreInfoContainer clsOverflow">
                            <div class="clsMoreInformation"><p><a  id="photoDetail_ahref_{$photoValue.record.photo_id}" href="javascript:void(0);" onClick="moreInformation('photoDetail_{$photoValue.record.photo_id}')" title="{$LANG.viewalbumlist_photo_detailinformation_helptips}"><span>{$LANG.viewalbumlist_more_label}</span></a></p></div>                  
                            <div id="photoDetail_{$photoValue.record.photo_id}" class="clsMoreInfoContent clsOverflow" style="display:none">
                                    <div class="clsMoreInfoContent-l">
                                        <div>
                                            <p class="clsLeft">{$LANG.viewalbumlist_post_by_label}:</p>
                                            <p class="clsRight"><a href="{$photoValue.viewprofile_url}" title="{$photoValue.record.user_name}">{$photoValue.record.user_name}</a></p>
                                        </div>
                                        <div>
                                            <p class="clsLeft">{$LANG.viewalbumlist_favorited_label}</p>
                                            <p class="clsRight">{$photoValue.record.total_favorites}</p>
                                        </div>
                                    </div>
                                    <div class="clsMoreInfoContent-r">
                                        <div>
                                            <p class="clsLeft">{$LANG.viewalbumlist_added_label}</p>
                                            <p class="clsRight">{$photoValue.record.date_added}</p>
                                        </div>
                                        <div>
                                            <p class="clsLeft">{$LANG.viewalbumlist_comments_label}</p>
                                            <p class="clsRight">{$photoValue.record.total_comments}</p>
                                        </div>
                                        <div>
                                            <p class="clsLeft">{$LANG.viewalbumlist_rated_label}</p>
                                            <p class="clsRight">{$photoValue.record.rating_count}</p>
                                        </div>
                                     </div>
                                    <p class="clsTags">{$LANG.viewalbumlist_tags_label}: {$myobj->getTagsLink($photoValue.record.photo_tags)}</p>
                                    <p class="clsDescription" title="{$photoValue.wordWrap_mb_ManualWithSpace_photo_caption}"><span class="clsLabel">{$LANG.viewalbumlist_description_label}</span> {$photoValue.wordWrap_mb_ManualWithSpace_photo_caption}</p>
                            </div> 
                        </div>
                    </div>
                    {/foreach}
       				 <input type="hidden" name="start" id="start" value="{$myobj->getFormField('start')}" />
                     <div class="clsOverflow">
                         <div  id="albumphotos_Paging" class="clsAudioHorizontalPaging">
                            <ul>
                                <li> <a href="javascript:void(0);" class="{$myobj->activeClsPrevious}" title="{$LANG.common_previous}" {if $myobj->isPreviousButton} onclick="photoAlbumAjaxPaging('?ajax_page=true&amp;page=pagenation&album_id={$viewAlbumInformation.photo_album_id}&user_id={$myobj->getFormField('user_id')}', 'perv')" {/if}>{$LANG.viewalbumlist_pageing_previous}</a>  </li>
                                <li><a href="javascript:void(0);"  class="{$myobj->activeClsNext}" title="{$LANG.common_next}" {if $myobj->isNextButton} onclick="photoAlbumAjaxPaging('?ajax_page=true&amp;page=pagenation&album_id={$viewAlbumInformation.photo_album_id}&user_id={$myobj->getFormField('user_id')}', 'next')" {/if} >{$LANG.viewalbumlist_pageing_next}</a></li>
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