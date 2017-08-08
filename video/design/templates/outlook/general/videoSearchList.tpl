<div id="selVideoList">
<!--rounded corners-->
                  <div id="selLeftNavigation">
                  <!-- Delete Single Videos -->
                  	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
    					<p id="msgConfirmText"></p>
                        <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                                       <div><p id="selImageBorder" class="clsPlainImageBorder">
                                            <span id="selPlainCenterImage">
                                                <img id="selVideoId" border="0" src=""/>
                                            </span>
                                        </p></div>
                                        <input type="submit" class="clsSubmitButton" name="yes" value="{$LANG.common_yes_option}"
                                            tabindex="{smartyTabIndex}" /> &nbsp;
                                        <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_no_option}"
                                            tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
                                        <input type="hidden" name="act" id="act" />
                                        <input type="hidden" name="video_id" id="video_id" />
                        </form>
                    </div>
                    <!-- Delete Multi Videos -->
					<div id="selMsgConfirmMulti" class="clsPopupConfirmation" style="display:none;">
							<p id="msgConfirmTextMulti">{$LANG.videolist_multi_delete_confirmation}</p>
							<form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                                            <input type="submit" class="clsSubmitButton" name="yes" value="{$LANG.common_yes_option}"
                                                tabindex="{smartyTabIndex}" /> &nbsp;
                                            <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_no_option}"
                                                tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
                                            <input type="hidden" name="video_id" id="video_id" />
                                            <input type="hidden" name="act" id="act" />
							</form>
					</div>

                 	<div id="selEditVideoComments" class="clsPopupConfirmation" style="display:none;position:absolute;">
					</div>

                    {if $myobj->isShowPageBlock("msg_form_error")}
                    <div id="selMsgError">
                        <p>{$myobj->msg_form_error.common_error_msg}</p>
                    </div>
                    {/if}

                    {if $myobj->isShowPageBlock("msg_form_success")}
                    <div id="selMsgSuccess">
                        <p>{$myobj->msg_form_success.common_error_msg}</p>
                    </div>
                    {/if}

                    {if $myobj->isShowPageBlock("my_videos_form")}
                    <div id="selVideoListDisplay" class="clsLeftSideDisplayTable">
                        {if $myobj->isResultsFound}
                        <form name="videoListForm" id="videoListForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                        <div id="topLinks">
                            {if $CFG.admin.navigation.top}
                                {$myobj->setTemplateFolder('general/')}
                                {include file=pagination.tpl}
                            {/if}
                        </div>
                        <!-- Chek All item -->
                            {if $myobj->getFormField('pg')=="myvideos" || $myobj->getFormField('pg')=="myfavoritevideos" || $myobj->getFormField('pg')=="myplaylist" }
                                <div id="selCheckAllItems" class="clsOverflow">

                                    <span class="clsVideoListCheckBox">
                                        <input type="checkbox" class="clsCheckRadio" name="check_all" o
                                            onclick="CheckAll(document.videoListForm.name, document.videoListForm.check_all.name)" />
                                    </span>

                                    {if $myobj->getFormField('pg')=='myvideos'}
                                    <div class="clsGreyButtonLeft"><div class="clsGreyButtonRight">
                                        <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                                        tabindex="{smartyTabIndex}" value="{$LANG.common_delete_option}" onClick="deleteMultiCheck('{$LANG.common_check_atleast_one}','{$myobj->my_videos_form.anchor}','{$LANG.videolist_multi_delete_confirmation}','videoListForm','video_id','delete')" />
                                        </div></div>
                                     {/if}

                                     {if $myobj->getFormField('pg')=='myplaylist'}
                                    <div class="clsGreyButtonLeft"><div class="clsGreyButtonRight">
                                        <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                                        tabindex="{smartyTabIndex}" value="{$LANG.common_delete_option}" onClick="deleteVideoMultiCheck('{$LANG.common_check_atleast_one}', '{$myobj->my_videos_form.anchor}', '{$LANG.videolist_multi_delete_confirmation}', 'videoListForm', 'video_id', 'playlist_delete')" />
                                        </div></div>
                                     {/if}

                                     {if $myobj->getFormField('pg')=='myfavoritevideos'}
                                    <div class="clsGreyButtonLeft"><div class="clsGreyButtonRight">
                                        <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                                        tabindex="{smartyTabIndex}" value="{$LANG.videolist_remove_favorite}" onClick="deleteMultiCheck('{$LANG.common_check_atleast_one}','{$myobj->my_videos_form.anchor}','{$LANG.videolist_favorite_multi_delete_confirmation}','videoListForm','video_id','favorite_delete')" />
                                        </div></div>
                                     {/if}

                                </div>
                            {/if}

                        	<p><a href="#" id="{$myobj->my_videos_form.anchor}"></a></p>
                            <div class="clsVideoListVideos">
                            <table summary="{$LANG.videolist_tbl_summary}" class="clsContentsDisplayTbl clsVideoListTable" id="selDisplayTable">
                            {assign var=count value=0}
                                {foreach from=$video_list_result item=result key=inc name=video}
                                    {if $smarty.foreach.video.iteration%$myobj->my_videos_form.showVideoList.videosPerRow==1}
                                        <tr class="{$myobj->getCSSRowClass()}">
                                    {/if}
                                            <td id="selVideoGallery_{$inc}" class="clsModifyItem">
                                                <div class="{$myobj->my_videos_form.showVideoList.clsVideoListCommon}">

                                                    <ul class="cls141x106PXThumbImage">
                                                        <li id="videolist_videoli_{$inc}" class="clsVideoListDisplayVideos">
                                                            <a id="{$result.anchor}"></a>


                                                                  <div class="clsListVideoThumbImage" id="videolist_video_thumb_image_{$inc}">
                                                                      <div class="clsListThumbImageContainer" id="videolist_thumb_image_container_{$inc}">
                                                                        <div class="clsThumbImageContainer">
                                                                              <div>
                                                                                  <div onclick="Redirect2URL('{$result.view_video_link}')" class="clsThumbImageLink clsPointer">
                                                                                   {if $myobj->getFormField('pg')!="albumlist"}
                                                                                      <span class="clsRunTime">{$result.playing_time}</span>
                                                                                   {else}
                                                                                      <span class="clsRunTime">{$result.record.total_album_videos} {$LANG.common_videos}</span>
                                                                                   {/if}
                                                                                    {if $result.img_src}
                                                                                          <div id="videolist_thumb_{$inc}" class="clsThumbImageOuter" {$result.div_onmouseOverText}>
                                                                                              <div class="clsrThumbImageMiddle">
                                                                                                  <div class="clsThumbImageInner">
                                                                                             		<img src="{$result.img_src}" {$result.img_disp_image} {$result.image_onmouseOverText} />
                                                                                                  </div>
                                                                                              </div>
                                                                                           </div>
                                                                                    {else if $myobj->getFormField('pg')=="albumlist"}
                                                                                          <div class="clsThumbImageOuter">
                                                                                              <div class="clsrThumbImageMiddle">
                                                                                                  <div class="clsThumbImageInner">
                                                                                                             <img src="{$album_video_count_list[$result.video_album_id].img_src}"  {$album_video_count_list[$result.video_album_id].img_disp_image} />
                                                                                                   </div>
                                                                                               </div>
	                                                                                     </div>
                                                                                    {/if}
                                                                                  </div>
                                                                              </div>
                                                                        <a href="javascript:void(0)" class="clsInfo clsDisplayNone" id="videolist_info_{$inc}" onmouseover="show_thumb=true;this.className='clsDisplayNone';showVideoDetail(this)"></a>
                                                                        {if $result.add_quicklink}
                                                                          <div class="clsAddQuickVideoMediumImg">
                                                                              <div id="quick_link_{$result.video_id}">
                                                                                  {if $result.is_quicklink_added}
                                                                                  <a class="clsPhotoVideoEditLinks" title="{$LANG.videolist_added_quicklinks}">
                                                                                      <img src="{$CFG.site.video_url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-addvideo.gif"/>
                                                                                  </a>
                                                                                  {else}
                                                                                  <a id="qucik_link_add_{$result.video_id}" onclick="updateVideosQuickLinksCount('{$result.video_id}')" title="{$LANG.videolist_quicklist_tooltips}" class="clsPhotoVideoEditLinks">
                                                                                      <img src="{$CFG.site.video_url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-addvideo_added.gif"/>
                                                                                  </a>
                                                                                  <a id="qucik_link_added_{$result.video_id}" class="clsPhotoVideoEditLinks" title="{$LANG.videolist_added_quicklinks}" style="display:none;">
                                                                                      <img src="{$CFG.site.video_url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-addvideo.gif"/>
                                                                                  </a>

                                                                                  {/if}
                                                                              </div>
                                                                          </div>
                                                                        {/if}
                                                                  </div>
			                                         		     </div>
                                                             		 {* Video Details starts here *}
	                                                               		 <div class="clsVideoDetailsInfo" id="videolist_selVideoDetails_{$inc}" onmouseover="show_thumb=true;showVideoDetail(this)" onmouseout="show_thumb=false;hideVideoDetail(this)">
                                                                        <div class="clsVideoDetailsInfoCont">
                                                                           <div class=" clsVideoBackgroundInfo">
                                                                        <a href="javascript:void(0)" id="clsInfo" class="clsInfo_inside" style="display:none"></a>
                                                                       <div>
                                                                         {if $result.user_id == $CFG.user.user_id && $myobj->getFormField('pg') != 'myvideos'}
                                                                            <ul id="selVideoLinks" class="clsContentEditLinks clsPopUpContentEditLinks">
                                                                                <li class="clsEdit">
                                                                                    <a href="{$result.videoupload_url}" class="clsVideoVideoEditLinks" title="{$LANG.videolist_edit_video}">
                                                                                        {$LANG.videolist_edit_video}
                                                                                    </a>
                                                                                </li>
                                                                                {if $CFG.admin.videos.embedable}
                                                                                    <li class="clsGetCode">
                                                                                        <a href="javascript:void(0)" class="clsVideoVideoEditLinks" title="{$LANG.videolist_get_code}"
                                                                                        onClick="return callAjaxGetCode('{$result.callAjaxGetCode_url}', '{$result.anchor}','selEditVideoComments')">
                                                                                            {$LANG.videolist_get_code}
                                                                                        </a>
                                                                                    </li>
                                                                                {/if}
                                                                                <li class="clsDelete" id="anchor_{$result.video_id}">
                                                                                    <a href="javascript:void(0)" class="clsVideoVideoEditLinks" title="{$LANG.videolist_delete_video}"
                                                                                    onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                                                    Array('act','video_id', 'selVideoId', 'msgConfirmText'), Array('delete','{$result.video_id}', '{$result.img_src}',
                                                                                    '{$LANG.videolist_delete_confirmation}'), Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_{$result.video_id}');">
                                                                                        {$LANG.videolist_delete_video}
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
												 {else}
	                                                                        <p>{$LANG.common_from}: <a href="{$myobj->memberProfileUrl[$result.user_id]}">{$myobj->getUserDetail('user_id', $result.user_id, 'user_name')}</a></p>
                                                                         {/if}
                                                                    {if $myobj->getFormField('pg') != 'albumlist'}
												 <div class="" id="videolist_clsVideoDetails_{$inc}">
                                                                           <div class="">
                                                                              <div class="">
                                                                                    <div class="clsVideoUserDetails">

                                                                                      <p>{$LANG.common_views}:&nbsp;<span>{$result.total_views}</span></p>
                                                                                      {if $myobj->getFormField('pg')=='featuredvideolist'}
                                                                                      	<p>{$LANG.videolist_total_featured}:&nbsp;<span>{$result.total_featured}</span></p>
                                                                                      {/if}

                                                                                      {if $myobj->getFormField('pg')=='videomostfavorite'}
                                                                                      	<p>{$LANG.videolist_total_favorite}:&nbsp;<span>{$result.total_favorite}</span></p>
                                                                                      {/if}

                                                                                      {if $myobj->getFormField('pg')=='videorecommended'}
                                                                                      	<p>{$LANG.videolist_total_recommended}:&nbsp;<span>{$result.record.total_featured}</span></p>
                                                                                      {/if}

                                                                                      {if $myobj->getFormField('pg')=='videomostlinked'}
                                                                                      	<p>{$LANG.videolist_total_linked}:&nbsp;<span>{$result.record.total_linked}</span></p>
                                                                                      {/if}

                                                                                      {if $myobj->getFormField('pg')=='videomostresponded'}
                                                                                      	<p>{$LANG.videolist_total_responded}:&nbsp;<span>{$result.record.total_responded}</span></p>
                                                                                      {/if}

                                                                                      {if $myobj->getFormField('pg')=='videomostdiscussed'}
                                                                                      	<p>{$LANG.videolist_total_discussed}:&nbsp;<span>{$result.total_comments}</span></p>
                                                                                      {/if}
                                                                                      <p>{$LANG.common_added}:&nbsp;<span>{$result.date_added}</span></p>
                                                                                      <p>{$myobj->populateRatingImages($result.rating, 'video')}</p>
                                                                                    </div>
                                                                               </div>
                                                                          </div>
                                                                         </div>
                                                                    {/if}
                                                                    </div>
                                                                     </div>
                                                                     	</div>

                                                            	</div>
                                                                      {* Video Details ends here *}

                                                          		</div>
                                                                   <div id="video_title_{$inc}" class="clsThumbImageTitle">
                                                                          <!-- Thumb yes start -->
                                                                          {if $myobj->getFormField('thumb')=="yes"}
                                                                                  <a href="{$result.view_video_link}">
                                                                                      {$result.video_title_word_wrap}
                                                                                  </a>
                                                                          {/if}
                                                                          <!-- Thumb yes end -->
                                                                   </div>

                                                        </li>
                                                    </ul>

                                                    <div id="selVideosContent_{$result.video_id}" class="{$myobj->my_videos_form.showVideoList.clsVideoListRight}">

                                                        <!-- myvideos start -->
                                                        {if $myobj->getFormField('pg')=="myvideos"}
                                                        <div class="clsContentEditLinksContainer">
                                                        <ul id="selVideoLinks" class="clsContentEditLinks">
                                                            <li class="clsCheckBox">
                                                                <span class="clsCheckItem">
                                                                    <input type="checkbox" class="clsCheckRadio" name="video_ids[]"  value="{$result.video_id}"
                                                                        tabindex="{smartyTabIndex}" {$result.checked} onclick="disableHeading('videoListForm')"/>
                                                                </span>
                                                            </li>
                                                            <li class="clsEdit">
                                                                <a href="{$result.videoupload_url}" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" title="{$LANG.videolist_edit_video}">
                                                                    {$LANG.videolist_edit_video}
                                                                </a>
                                                            </li>
                                                            <li class="clsGetCode">
                                                                <a href="javascript:void(0)" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" title="{$LANG.videolist_get_code}"
                                                                onClick="return callAjaxGetCode('{$result.callAjaxGetCode_url}', '{$result.anchor}','selEditVideoComments')">
                                                                    {$LANG.videolist_get_code}
                                                                </a>
                                                            </li>
                                                            <li class="clsDelete" id="anchor_myvid_{$result.video_id}">
                                                                <a href="javascript:void(0)" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" title="{$LANG.videolist_delete_video}"
                                                                onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                                Array('act','video_id', 'selVideoId', 'msgConfirmText'), Array('delete','{$result.video_id}', '{$result.img_src}',
                                                                '{$LANG.videolist_delete_confirmation}'), Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myvid_{$result.video_id}');">
                                                                    {$LANG.videolist_delete_video}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        </div>
                                                        {/if}
                                                        <!-- myvideos end -->

                                                        <!-- myfavouritevideo start -->
                                                        {if $myobj->getFormField('pg')=="myfavoritevideos"}
                                                        <div class="clsContentEditLinksContainer">
                                                        <ul id="selVideoLinks" class="clsContentEditLinks">
                                                            <li class="clsCheckBox">
                                                                <span class="clsCheckItem">
                                                                    <input type="checkbox" class="clsCheckRadio" name="video_ids[]" value="{$result.video_id}"
                                                                        tabindex="{smartyTabIndex}" {$result.checked} onclick="disableHeading('videoListForm')"/>
                                                                </span>
                                                            </li>
                                                            <li class="clsGetCode">
                                                                <a href="javascript:void(0)" class="clsVideoVideoEditLinks" title="{$LANG.videolist_get_code}"
                                                                onClick="return callAjaxGetCode('{$result.callAjaxGetCode_url}', '{$result.anchor}','selEditVideoComments')">
                                                                    {$LANG.videolist_get_code}
                                                                </a>
                                                            </li>
                                                            <li class="clsDelete" id="anchor_myfav_{$result.video_id}">
                                                                <a href="javascript:void(0)" class="clsVideoVideoEditLinks" title="{$LANG.videolist_remove_favorite}"
                                                                onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                                Array('act','video_id', 'selVideoId', 'msgConfirmText'),
                                                                Array('favorite_delete','{$result.video_id}', '{$result.img_src}', '{$LANG.videolist_favorite_delete_confirmation}'),
                                                                Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myfav_{$result.video_id}');">{$LANG.videolist_delete_video}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        </div>
                                                        {/if}
                                                        <!-- myfavouritevideo end -->

                                                        {if $myobj->getFormField('pg')=="myalbumvideolist"}
                                                        <div class="clsContentEditLinksContainer">
                                                        <ul id="selVideoLinks" class="clsContentEditLinks">
                                                            <li class="clsSetFeatured" id="anchor_myalb_{$result.video_id}">
                                                                <a href="javascript:void(0)" class="clsVideoVideoEditLinks" title="{$LANG.videolist_set_album_profile_image}"
                                                                onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                                Array('act','video_id', 'selVideoId', 'msgConfirmText'),
                                                                Array('set_album_thumb','{$result.video_id}', '{$result.img_src}', '{$LANG.videolist_set_album_profile_image_confirmation}'),
                                                                Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myalb_{$result.video_id}');">
                                                                    {$LANG.videolist_set_album_profile_image}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        </div>
                                                        {/if}
                                                        <!-- myalbumvideolist end -->

                                                        {if $myobj->getFormField('pg')=="myplaylist"}
                                                        <div class="clsContentEditLinksContainer">
                                                        <ul id="selVideoLinks" class="clsContentEditLinks">
                                                            <li class="clsCheckBox">
                                                                    <span class="clsCheckItem">
                                                                        <input type="checkbox" class="clsCheckRadio" name="video_ids[]"  value="{$result.video_id}"
                                                                            tabindex="{smartyTabIndex}" {$result.checked}/>
                                                                    </span>
                                                                </li>
                                                            <li class="clsDelete" id="anchor_myply_{$result.video_id}">
                                                                <a href="javascript:void(0)" class="clsVideoVideoEditLinks" title="{$LANG.videolist_delete_video}"
                                                                onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                                Array('act','video_id', 'selVideoId', 'msgConfirmText'),
                                                                Array('playlist_delete','{$result.video_id}', '{$result.img_src}', '{$LANG.videolist_delete_confirmation}'),
                                                                Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myply_{$result.video_id}');">{$LANG.videolist_set_album_profile_image}
                                                                </a>
                                                            </li>
                                                            <li class="clsSetFeatured" id="anchor_myfea_{$result.video_id}">
                                                                <a href="javascript:void(0)" class="clsVideoVideoEditLinks" title="{$LANG.videolist_set_palylist_thumbnail}"
                                                                onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                                Array('act','video_id', 'selVideoId', 'msgConfirmText'), Array('set_playlist_thumb','{$result.video_id}','{$result.img_src}',
                                                                '{$LANG.videolist_playlist_thumbnail_confirmation}'), Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myfea_{$result.video_id}');">
                                                                    {$LANG.videolist_set_palylist_thumbnail}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        </div>
                                                        {/if}


                                                    </div>
                                                </div>
                                             </td>
                                          {if $smarty.foreach.video.iteration%$myobj->my_videos_form.showVideoList.videosPerRow==0}
                                        		</tr>
	                                   	{/if}
                                {/foreach}
                            </table>
                            </div>

                        <div id="bottomLinks">
                        {if $CFG.admin.navigation.bottom}
		                {$myobj->setTemplateFolder('general/')}
                            {include file='pagination.tpl'}
                        {/if}
                        </div>
                         </form>
                        {else}
                              <div id="selMsgAlert">
                              	<p>{$LANG.common_video_no_records_found}</p>
                              </div>
                        {/if}
                    </div>
                    {/if}
	</div>
</div>
