<div id="selViewVideoPlayList">
{$myobj->setTemplateFolder('general')}
{include file='box.tpl' opt='display_top'}
	<div class="clsOverflow"><div class="clsVideoListHeading">
	<h2>{$LANG.videolist_title}</h2>
    </div></div>
	{* <!--  if $myobj->getFormField('search_type')=='video'}
		{if $CFG.admin.videos.list_thumb_detail_view}
			<div class="clsSearchViews">
				{$myobj->showThumbDetailsLinks($paging_arr)}
			</div>
		{/if}
	{/if}--> *}
    <!--- Delete Single Videos --->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
      <p id="msgConfirmText"></p>
      <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
        <table summary="{$LANG.videolist_tbl_summary}" class="clsVideoListTable">
          <tr>
            <td id="selVideoGallery"><p id="selImageBorder" class="clsPlainImageBorder"><span id="selPlainCenterImage"><img id="selVideoId" border="0" /></span></p></td>
          </tr>
          <tr>
            <td><input type="submit" class="clsSubmitButton" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
              &nbsp;
              <input type="button" class="clsSubmitButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
              <input type="hidden" name="act" id="act" />
              <input type="hidden" name="video_id" id="video_id" />
              <input type="hidden" name="playlist_id" value="{$myobj->getFormField('playlist_id')}" />
            </td>
          </tr>
        </table>
      </form>
    </div>
    <!--- Delete Multi Videos --->
    <div id="selMsgConfirmMulti" class="clsPopupConfirmation" style="display:none;">
      <p id="msgConfirmTextMulti">{$LANG.videolist_multi_delete_confirmation}</p>
      <form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
        <table summary="{$LANG.videolist_tbl_summary}" class="clsVideoListTable">
          <tr>
            <td><input type="submit" class="clsSubmitButton" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
              &nbsp;
              <input type="button" class="clsSubmitButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
              <input type="hidden" name="video_id" id="video_id" />
              <input type="hidden" name="act" id="act" />
              <input type="hidden" name="playlist_id" value="{ $myobj->getFormField('playlist_id')}" />
            </td>
          </tr>
        </table>
      </form>
    </div>

    <div id="selEditPhotoComments" class="clsPopupConfirmation" style="display:none;position:absolute;"> </div>

    {if $myobj->isShowPageBlock('my_videos_form')}
    {if $myobj->isResultsFound()}
        <div id="selVideoPlayLIsts" class="clsDataTable clsPlaylistDetailsTable">
            <table>
                <tr>
                   <td class="clsPlayListLeftTd">
                        {$LANG.play_list_name}
                    </td>
                    <td>
                        {$myobj->my_videos_form.listPlayListDetails_arr.play_list_details_arr.play_list_name}&nbsp;
                        <!--{* {if $myobj->my_videos_form.listPlayListDetails_arr.play_list_details_arr.user_id==$CFG.user.user_id }
                            <a class="clsPlayListEdit" href="{$myobj->my_videos_form.listPlayListDetails_arr.videoPlayList_url}">
                                {$LANG.view_video_playlist_edit}
                            </a>
                        {/if} *}-->
                    </td>
                </tr>
                <tr>
                    <td class="clsPlayListLeftTd">
                        {$LANG.play_list_description}
                    </td>
                    <td>
                        {$myobj->my_videos_form.listPlayListDetails_arr.wordWrap_play_list_description}
                    </td>
                </tr>
                <tr>
                    <td class="clsPlayListLeftTd">
                        {$LANG.play_list_user_name}
                    </td>
                    <td>
                        <a href="{$myobj->my_videos_form.listPlayListDetails_arr.getMemberProfileUrl}">{$myobj->my_videos_form.listPlayListDetails_arr.play_list_details_arr.user_name}</a>
                    </td>
                </tr>
                <tr>
                   <td class="clsPlayListLeftTd">
                        {$LANG.play_list_tags}
                    </td>
                    <td>
                        {$myobj->getTagLinks($myobj->my_videos_form.listPlayListDetails_arr.play_list_details_arr.play_list_tags)}
                    </td>
                </tr>
                <tr>
                    <td class="clsPlayListLeftTd">
                        {$LANG.play_list_total_videos}
                    </td>
                    <td>
                        {$myobj->getVideoCount($myobj->my_videos_form.listPlayListDetails_arr.play_list_details_arr.playlist_id)}
                    </td>
                </tr>
            </table>
                <!--{* <tr>
                    <td>
                        <a class="clsPlayListEdit" href="{$myobj->my_videos_form.listPlayListDetails_arr.videoPlayList_url}">
                            {$LANG.play_list_more_videos} {$myobj->my_videos_form.listPlayListDetails_arr.play_list_details_arr.user_name}
                        </a>
                    </td>
                </tr>*} -->
                    <div class="clsPlayAllVideos">
                        {$myobj->getNextPlayListLinks()}
                    </div>
            {if $myobj->my_videos_form.listPlayListDetails_arr.play_list_url_exists}
                <table>
                    <tr>
                        <th>
                            {$LANG.play_list_urls_videos}
                        </th>
                        <td>
                            <input onClick="this.select();"  size="70"  type="text" name="play_list_url" value="{$myobj->my_videos_form.listPlayListDetails_arr.viewVideoPlayList_url}" readonly />
                        </td>
                    </tr>
                    {*<!--<tr>
                    <th>{$LANG.play_list_embed_videos}</th>
                    <td>
                    <textarea class="clsEmbedCodeTextFields" rows="3" style="width:400px" name="image_code" id="image_code" READONLY tabindex="{smartyTabIndex}" onFocus="this.select()" onClick="this.select()" ><embed src="{$flv_player_url}" FlashVars="config={$configXmlcode_url.$arguments_embed}" quality="high" bgcolor="#000000" width="450" height="370" name="flvplayer" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" {$CFG.admin.embed_code.additional_fields} /></textarea>
                    </td>
                    </tr>-->*}
                </table>
            {/if}
        </div>
    {/if}
        {if $myobj->isResultsFound()}
            <!-- top pagination start-->
            {if $CFG.admin.navigation.top}
                {include file='pagination.tpl'}
            {/if}
            <!-- top pagination end-->
            <form name="videoListForm" id="videoListForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                <!--{* {if $myobj->IS_EDIT}
                    <p id="selCheckAllItems">
                        <span class="clsCheckItem">
                            <input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CheckAll(document.videoListForm.name, document.videoListForm.check_all.name)" />
                        </span>
                        <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.delete_submit}" onClick="{$myobj->my_videos_form.confirm_delete}" />
                    </p>
                {/if} *}-->
                    <a href="#" id="{$myobj->my_videos_form.anchor}"></a>
                {assign var='videoPerRow' value='4'}
                {assign var='count' value='0'}
                <div class="clsDataTable clsViewVideoPlaylistTable" id="">
                	<table summary="videolist_tbl_summary" class="clsViewVideoPlaylistTable" id="selDisplayTable">

                    {foreach key=inc item=svlvalue from=$myobj->my_videos_form.showVideoList_arr.row}
                        {if $count%$videoPerRow eq 0}
                            <tr class="{$myobj->getCSSRowClass()}">
                        {/if}
                        {if $myobj->IS_EDIT}
                            <!--<td>
                                <span class="clsCheckItem">
                                    <input type="checkbox" class="clsCheckRadio" name="video_ids[]"  value="{$svlvalue.record.video_id}" tabindex="{smartyTabIndex}" {$svlvalue.checked}/>
                                </span>
                            </td>-->
                        {/if}
                        <td>
                        {if $svlvalue.record.video_encoded_status!='Yes'}
                            <div class="clsCommonSearch">
                                <div class="clsOverflow">
                                      <div class="Cls142x108 ClsImageBorder ClsImageContainer">
                                        <img src="{$svlvalue.video_img_path}" alt="{$svlvalue.record.video_title}" {$svlvalue.video_DISP_IMAGE} />
                                 	  </div>
                                </div>
                                <div  class="clsSearchRight">
                                    <ul id="selVideoLinks" class="clsContentEditLinks">
                                        <!-- {*<li class="clsCheckBox">
                                            <span class="clsCheckItem">
                                                <input type="checkbox" class="clsCheckRadio" name="video_ids[]"  value="{$svlvalue.record.video_id}" tabindex="{smartyTabIndex}" {$svlvalue.checked}/>
                                            </span>
                                        </li>*}-->
                                        <li class="clsDelete">
                                            <a id="{$svlvalue.anchor}"  href="#" class="clsPhotoVideoEditLinks" title="{$LANG.delete_submit}" onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','video_id', 'selVideoId', 'msgConfirmText'), Array('delete','{$svlvalue.record.video_id}', '{$CFG.site.url}images/notActivateVideo_T.jpg', '{$LANG.videolist_delete_confirmation}'), Array('value','value', 'src', 'innerHTML'), -100, -500);">
                                                {$LANG.delete_submit}
                                            </a>
                                        </li>
                                    </ul>
                                    <h3 class="clsTitleLink">
                                        {$svlvalue.wordWrap_video_title}
                                    </h3>
                                    <p class="clsAddedDate">
                                        {$LANG.added} {$svlvalue.record.date_added}
                                    </p>
                                </div>
                            </div>

                        {elseif $svlvalue.record.video_encoded_status=='Yes' && $svlvalue.record.video_status=='Locked'}
                            <div class="clsCommonSearch">
                                <div class="clsOverflow">
                                     <div class="Cls142x108 ClsImageBorder ClsImageContainer">
                                          <img src="{$svlvalue.video_img_path}" alt="{$svlvalue.record.video_title}"{*$svlvalue.video_DISP_IMAGE*} title="{$svlvalue.record.video_title}" />                                     </div>
                                </div>
                                <div  class="clsSearchRight">
                                    <h3 class="clsTitleLink">
                                        {$svlvalue.wordWrap_video_title}
                                    </h3>
                                    <p class="clsAddedDate">
                                        {$LANG.added} {$svlvalue.record.date_added}
                                    </p>
                                </div>
                            </div>

                        {else}
                            <div class="clsCommonSearch">
                                <div class="clsOverflow">
                                <a id="{$svlvalue.anchor}"></a>
                                        <div   class="clsThumbImageOuterContainer clsThumbImageLink">
                                            <a href="{$svlvalue.view_video_link}" class="Cls142x108 ClsImageBorder1 ClsImageContainer clsPointer">
                                           	 <img src="{$svlvalue.video_img_path}" border="0" alt="{$svlvalue.record.video_title}" title="{$svlvalue.record.video_title}" {$svlvalue.video_DISP_IMAGE} />
                                            </a>
                                        </div>
                               </div>
                                {if $myobj->getFormField(thumb)!='yes'}
                                    <div  class="clsSearchRight">
                                        <h3 class="clsTitleLink">
                                            <a href="{$svlvalue.view_video_link}" title="{$svlvalue.wordWrap_video_title}">
                                                {$svlvalue.wordWrap_video_title}
                                            </a>
                                        </h3>
                                        <div class="clsSearchInline">
                                            <p class="clsAddedDate">
                                                {$LANG.added}
                                                <span>
                                                    {$svlvalue.record.date_added}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="clsSearchInline">
                                            <p class="clsUserTitle">
                                                {$LANG.from}
                                                    <a href="{$svlvalue.getMemberProfileUrl}" title="{$svlvalue.name}">
                                                    <span>
                                                        {$svlvalue.name}
                                                    </span>
                                                    </a>
                                            </p>
                                            <p class="clsWatchedDate">
                                                {$LANG.watched}
                                                <span>
                                                    {$svlvalue.record.video_last_view_date}
                                                </span>
                                            </p>
                                        <p class="clsUserViews">
                                            {$LANG.views}
                                            <span>
                                                {$svlvalue.record.total_views}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="clsSearchInline">
                                        <p class="clsUserViews">
                                            {$LANG.playing_time}
                                            <span>
                                                {$svlvalue.record.playing_time}
                                            </span>
                                        </p>
                                        <!--<p>
                                            {*{$svlvalue.search_video_tags}
                                             if $svlvalue.tags}
                                                {foreach $svlvalue.tags as $key=>$value)
                                                    <a href="{$svlvalue.videoList_tag_url}" ><span>{$svlvalue.tag_value}</span></a>
                                                {/foreach}
                                            {/if *}
                                        </p>-->
                                    </div>
                                </div>
                                {/if}
                            </div>
                        {/if}
                         </td>
                        {counter  assign=count}
                        {if $count%$videoPerRow eq 0}
                            {counter start=0}
                            </tr>
                        {/if}
                    {/foreach}
                    {assign var=cols  value=$videoPerRow-$count}
                     {if $count}
                        {section name=foo start=0 loop=$cols step=1}
                            <td>&nbsp;</td>
                        {/section}
                        <tr>
                    {/if}
                        <!--{if $myobj->my_videos_form.showVideoList_arr.found && $count && $count<$videoPerRow}
                            <td colspan="({$videoPerRow-$count})">
                            </td>
                        {/if}
                    </tr>	-->

                </table>
                </div>
            </form>
             <!-- bottom pagination start-->
              {if $CFG.admin.navigation.bottom}
                  {include file='pagination.tpl'}
              {/if}
             <!-- pagination end-->
        {else}
              <div id="selMsgAlert">
                <p>{$LANG.videolist_no_records_found}</p>
              </div>
        {/if}
    {/if}
{include file='box.tpl' opt='display_bottom'}
  </div>
