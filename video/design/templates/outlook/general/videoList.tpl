<div id="selVideoList">
<!--rounded corners-->
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
				  <div id="selVideoTitle">
                  <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}">
                  <input type="hidden" name="advanceFromSubmission" value="1"/>
		       {$myobj->populateVideoListHidden($paging_arr)}
                  <div class="clsOverflow">
                    {*VIDEO LIST TITLE STARTS*}
                  	<div class="clsVideoListHeading clsVideoLisPageTitle">
                              <h2><span>
                              {if $myobj->getFormField('pg')=='uservideolist' || $myobj->getFormField('pg')=='videoresponseslist' }
                                    {$LANG.videolist_title}
                              {else}
                                    {$LANG.videolist_title}
                              {/if}
                               </span></h2>
				</div>
                    {*VIDEO LIST TITLE ENDS*}
                    {*SELECT BOX TO LOAD VIDEO LIST FILTER OPTIONS STARTS*}

                    <div class="clsVideoListHeadingRight">
	                  <input type="hidden" name="default" id="default" value="{$myobj->getFormField('default')}" />
                    	<select onchange="loadUrl(this)" id="videoselect">
                        	<option value="{php} echo getUrl('videolist','?pg=videonew','videonew/','','video'){/php}"
                            {if $myobj->getFormField('pg')=='videonew'} selected {/if} >
    	                       {$LANG.header_nav_video_video_new}
                            </option>
{* NOT DISPLAYED RANDOM VIDEOS
                        	<option value="{php} echo getUrl('videolist','?pg=randomvideo','randomvideo/','','video'){/php}"
                            {if $myobj->getFormField('pg')=='randomvideo'} selected {/if} >
    	                        {$LANG.header_nav_video_video_random}
                            </option>
*}
                        	<option value="{php} echo getUrl('videolist','?pg=videotoprated','videotoprated/','','video'){/php}"
                            {if $myobj->getFormField('pg')=='videotoprated'} selected {/if} >
	                           {$LANG.header_nav_video_top_rated}</option>
                        	<option value="{php} echo getUrl('videolist','?pg=videorecommended','videorecommended/','','video'){/php}"
                            {if $myobj->getFormField('pg')=='videorecommended'} selected {/if} >
                                {$LANG.header_nav_video_most_recommended}</option>
                        	<option value="{php} echo getUrl('videolist','?pg=videomostviewed','videomostviewed/','','video'){/php}"
                            {if $myobj->getFormField('pg')=='videomostviewed'} selected {/if} >
                                {$LANG.header_nav_video_most_viewed}</option>
                        	<option value="{php} echo getUrl('videolist','?pg=videomostdiscussed','videomostdiscussed/','','video'){/php}"
                            {if $myobj->getFormField('pg')=='videomostdiscussed'} selected {/if} >
    	                        {$LANG.header_nav_video_most_discussed}</option>
                        	<option value="{php} echo getUrl('videolist','?pg=videomostfavorite','videomostfavorite/','','video'){/php}"
                            {if $myobj->getFormField('pg')=='videomostfavorite'} selected {/if} >
	                            {$LANG.header_nav_video_most_favorite}</option>
                        	<option value="{php} echo getUrl('videolist','?pg=videomostrecentlyviewed','videomostrecentlyviewed/','','video'){/php}"
                            {if $myobj->getFormField('pg')=='videomostrecentlyviewed'} selected {/if} >
    	                        {$LANG.header_nav_video_recently_viewed}</option>
                        	<option value="{php} echo getUrl('videolist','?pg=featuredvideolist','featuredvideolist/','','video'){/php}"
                            {if $myobj->getFormField('pg')=='featuredvideolist'} selected {/if} >
                            {$LANG.header_nav_video_most_featuredvideolist}</option>
                        	<option value="{php} echo getUrl('videolist','?pg=videomostlinked','videomostlinked/','','video'){/php}"
                            {if $myobj->getFormField('pg')=='videomostlinked'} selected {/if} >
                            {$LANG.header_most_linked}</option>
                        	<option value="{php} echo getUrl('videolist','?pg=videomostresponded','videomostresponded/','','video'){/php}"
                            {if $myobj->getFormField('pg')=='videomostresponded'} selected {/if} >
	                           {$LANG.header_most_responded}</option>
                           <option value="{php} echo getUrl('videolist','?pg=albumlist','albumlist/','','video'){/php}"
                           {if $myobj->getFormField('pg')=='albumlist'} selected {/if} >
                                {$LANG.header_nav_video_album_list}
                            </option>
                        </select>
                    </div>
                   {*SELECT BOX TO LOAD VIDEO LIST FILTER OPTIONS ENDS*}
                  </div>
                    {if $myobj->isShowPageBlock('form_show_sub_category')}
                    		{if $populateSubCategories_arr.row}
                                <h2>
                                    {$LANG.videolist_sub_categories_label}
                                </h2>
                            {/if}
                            <div id="selShowAllShoutouts" class="clsDataTable">
                            	<table id="selCategoryTable" class="clsSubCategoryTable">
                                {foreach key=subCategoryItem item=subCategoryValue from=$populateSubCategories_arr.row}

                                     {$subCategoryValue.open_tr}
                                        <td id="selVideoGallery_{$subCategoryItem}" class="clsVideoCategoryCell">
                                            <div id="selImageDet">
                                            <h3>
                                            	<div class="clsOverflow"><span class="clsViewThumbImage">
                                                <a href="{$subCategoryValue.video_list_url}">
                                                <img src="{$subCategoryValue.imageSrc}" /></a>
                                                </span></div>
                                                <a href="{$subCategoryValue.video_list_url}">
                                                {$subCategoryValue.video_category_name_manual}
                                                </a>
                                            </h3>
                                            </div>
                                        </td>
                                     {$subCategoryValue.end_tr}

                                {foreachelse}
                                    	{*<!--<div id="selMsgError">
                                            <p>
                                                {$LANG.videolist_no_sub_categories_found}
                                            </p>
                                    	</div>    -->  *}
                                {/foreach}
                                </table>
                            </div>
                        {/if}

                       {if $myobj->getFormField('pg') == 'videomostviewed'
                       		OR $myobj->getFormField('pg') == 'videomostdiscussed'
                            	OR $myobj->getFormField('pg') == 'videomostfavorite'}
                                <div class="clsTabNavigation">
                                    <ul>
                                        <li{$videoActionNavigation_arr.videoMostViewed_0}><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$videoActionNavigation_arr.video_list_url_0}');"><span>{$LANG.header_nav_members_all_time}</span></a></li>
                                        <li{$videoActionNavigation_arr.videoMostViewed_1}><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$videoActionNavigation_arr.video_list_url_1}');"><span>{$LANG.header_nav_members_today}</span></a></li>
                                        <li{$videoActionNavigation_arr.videoMostViewed_2}><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$videoActionNavigation_arr.video_list_url_2}');"><span>{$LANG.header_nav_members_yesterday}</span></a></li>
                                        <li{$videoActionNavigation_arr.videoMostViewed_3}><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$videoActionNavigation_arr.video_list_url_3}');"><span>{$LANG.header_nav_members_this_week}</span></a></li>
                                        <li{$videoActionNavigation_arr.videoMostViewed_4}><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$videoActionNavigation_arr.video_list_url_4}');"><span>{$LANG.header_nav_members_this_month}</span></a></li>
                                        <li{$videoActionNavigation_arr.videoMostViewed_5}><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$videoActionNavigation_arr.video_list_url_5}');"><span>{$LANG.header_nav_members_this_year}</span></a></li>
                                    </ul>
                                </div>
                              {literal}
                             <script type="text/javascript">
						function jumpAndSubmitForm(url)
							{
								document.seachAdvancedFilter.start.value = '0';
								document.seachAdvancedFilter.action=url;
								document.seachAdvancedFilter.submit();
							}
                                    var subMenuClassName1='clsActiveTabNavigation';
                                    var hoverElement1  = '.clsTabNavigation li';
                                    loadChangeClass(hoverElement1,subMenuClassName1);
                             </script>
                             {/literal}
                        {/if}

                    {if $myobj->getFormField('pg')!='albumlist' }
                        <div id="videosThumsDetailsLinks" class="clsVideoRight clsShowHideFilter clsOverflow">
                            <a href="javascript:void(0)" id="show_link" class="clsShowFilterSearch"  {if $myobj->chkAdvanceResultFound()}  style="display:none" {/if} onclick="divShowHide('advanced_search', 'show_link', 'hide_link')"><span>{$LANG.videolist_show_adv_search}</span></a>
                       		<a href="javascript:void(0)" id="hide_link" {if !$myobj->chkAdvanceResultFound()}  style="display:none" {/if} class="clsHideFilterSearch"  onclick="divShowHide('advanced_search', 'show_link', 'hide_link')"><span>{$LANG.videolist_hide_adv_search}</span></a>
                        </div>
                     <div id="advanced_search" style="{if $myobj->chkAdvanceResultFound()}display:block;{else}display:none;{/if}margin:0 0 10px 0;" class="clsAdvancedFilterTable clsOverflow">                  	 	<div class="clsAdvanceSearchIcon">
                            <table>
                            	 <tr>
                                    <td>
                                    	<input class="clsTextBox" type="text" name="keyword" id="keyword" value="{if $myobj->getFormField('keyword') != ''}{$myobj->getFormField('keyword')}{elseif $header->getFormField('tags') != ''}{$header->getFormField('tags')}{else}{$LANG.videolist_keyword}{/if}" onblur="setOldValue('keyword')"  onfocus="clearValue('keyword')"/>
                                    </td>
                                    <td>
                                    	<input class="clsTextBox" type="text" name="video_owner" id="video_owner" value="{if $myobj->getFormField('video_owner') == ''} {$LANG.videolist_user_name}{else}{$myobj->getFormField('video_owner')}{/if}" onblur="setOldValue('video_owner')"  onfocus="clearValue('video_owner')" />
                                   </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select  name="video_country" id="video_country">
                                            <option value="">{$LANG.videolist_country_list}</option>
                                            {$myobj->generalPopulateArray($myobj->LANG_COUNTRY_ARR, $myobj->getFormField('video_country'))}
                                        </select>                                    </td>
                                    <td>
                                        <select name="video_language" id="video_language">
                                            <option value="">{$LANG.videolist_language_list}</option>
                                            {$myobj->generalPopulateArray($myobj->LANG_LANGUAGE_ARR, $myobj->getFormField('video_language'))}
                                        </select>                                    </td>
                                </tr>
                                 <tr>
                                    <td>
                                        <select name="run_length" id="run_length">
                                       		<option value="">{$LANG.videolist_run_length}</option>
                                            {$myobj->generalPopulateArray($myobj->VIDEORUN_LENGTH_ARR, $myobj->getFormField('run_length'))}
                                        </select>                                    </td>
                                    <td>
                                    	<select name="added_within" id="added_within">
                                        	<option value="">{$LANG.videolist_added_within}</option>
                                            {$myobj->generalPopulateArray($myobj->ADDED_WITHIN_ARR, $myobj->getFormField('added_within'))}
                                        </select>                                    </td>
                                </tr>

                            </table>
						</div>
						<div class="clsAdvancedSearchBtn">
						<table>
							<tr>
                                    <td>
                                         <div class="clsSubmitLeft">
                                         <div class="clsSubmitRight">
                                             <input type="submit" name="avd_search" id="avd_search" value="{$LANG.videolist_search_categories_videos_submit}" />
                                         </div>
                                         </div>
										</td>
								<tr>
                                    <td>
                                         <div class="clsCancelMargin clsCancelLeft"><div class="clsCancelRight">
                                         	<input type="submit" name="avd_reset" id="avd_reset" value="{$LANG.videolist_reset_submit}" />
                                         </div>
                                         </div>

                                    </td>
                                </tr>
							</table>
                    </div>
                    {/if}
                    </form>
                  </div>

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

                 	<div id="selEditVideoComments" class="clsPopupConfirmation" style="display:none;">
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
                                {$myobj->setTemplateFolder('general/','video')}
                                {include file=pagination.tpl}
                            {/if}
                        </div>
                        <!-- Chek All item -->
                            {if $myobj->getFormField('pg')=="myvideos" || $myobj->getFormField('pg')=="myfavoritevideos" || $myobj->getFormField('pg')=="myplaylist" }
                            	<div class="clsShowHideSeparator">
	                                <div id="selCheckAllItems" class="clsOverflow clsDeleteSeparator">

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
                                                                                  <div class="clsThumbImageLink clsPointer">
                                                                                   {if $myobj->getFormField('pg')!="albumlist"}
                                                                                      <span class="clsRunTime">{$result.playing_time}</span>
                                                                                   {else}
                                                                                      <span class="clsRunTime">{$result.record.total_album_videos} {$LANG.common_videos}</span>
                                                                                   {/if}
                                                                                    {if $result.img_src}
                                                                                          <div id="videolist_thumb_{$inc}" {$result.div_onmouseOverText}>
                                                                                                   <a  href="{$result.view_video_link}" class="Cls142x108 ClsImageBorder1 ClsImageContainer" title="{$result.video_title}" >
                                                                                             		<img src="{$result.img_src}" title="{$result.video_title}" alt="{$result.video_title|truncate:15}" {$result.img_disp_image} {$result.image_onmouseOverText} {$myobj->DISP_IMAGE(142, 108, $result.record.t_width, $result.record.t_height)} />
                                                                                                    </a>
                                                                                           </div>
                                                                                    {else if $myobj->getFormField('pg')=="albumlist"}
                                                                                          <div class="clsThumbImageOuter">
                                                                                              <div class="clsrThumbImageMiddle">
                                                                                                  <div class="clsThumbImageInner">
                                                                                                             <img src="{$album_video_count_list[$result.video_album_id].img_src}"  {$album_video_count_list[$result.video_album_id].img_disp_image} {$myobj->DISP_IMAGE(142, 108, $result.record.t_width, $result.record.t_height)} />
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
                                                                                  <p><a href="{$result.view_video_link}" class="clsBlueColor">
                                                                                      {$result.video_title_word_wrap}
                                                                                  </a></p>
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
		                {$myobj->setTemplateFolder('general/','video')}
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
		{include file='box.tpl' opt='display_bottom'}
	</div>
</div>
