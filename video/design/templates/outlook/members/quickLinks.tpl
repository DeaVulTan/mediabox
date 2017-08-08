{if !isAjaxpage() || $myobj->showRoundedCorner}
{$myobj->setTemplateFolder('general/','video')}
{include file='box.tpl' opt='viewvideodetails_top'}
{/if}
{if $quickLink_arr.display}

    {if !$quickLink_arr.video_id}
        <div class="clsQuickLinks">
            <h3 class="clsQuickListTitle">{$LANG.view_video_quick_links_title}</h3>
            <div id="selVideoQuickListDispManage">
                    <div class="clsOverflow clsPlayIconContainer">
                            <input type="checkbox" onclick="toggleOnViewClearQuickList(this);" name="clear_quick_list" id="clear_quick_list" value="1" {$myobj->quickListChecked} />
                            <label for="clear_quick_list">{$LANG.clear_quick_list_msg}</label>
                    </div>
                    <div class="clsVideoManageLinks clsOverflow">
                    	<div class="clsVideoManageLinksLeft">
                            <span class="clsPlayAllVideo">{$myobj->getNextPlayListQuickLinks($quickLink_arr.in_str, true)}</span>
                            <span class="clsPlayNextVideo">{$myobj->getNextPlayListQuickLinks($quickLink_arr.in_str)}</span>
                        </div>
                        <div class="clsVideoManageLinksRight">
                            <div class="clsManageLinksContainer">
                            	<a class="clsManage clsPhotoVideoEditLinks" title="{$LANG.viewvideo_manage}" href="{$myobj->dashboardUrl}">{$LANG.view_video_quick_list_manage}</a>
                              <a class="clsSave clsPhotoVideoEditLinks" title="{$LANG.viewvideo_save}" href="{$myobj->managePlaylistUrl}">{$LANG.view_video_quick_list_save}</a>
                              <a class="clsClear clsPhotoVideoEditLinks" title="{$LANG.viewvideo_clear}" onClick="clearQuickLinks()">{$LANG.view_video_quick_list_clear}</a>
                            </div>
                         </div>
                    </div>
            </div>
            <div id="selVideoQuickListDisp">
            <ul id="selQuickList">
    {/if}
        {foreach from=$quickLink_arr.display item=quicklink}
         <li id="quick_list_selected_{$quicklink.record.video_id}" class="{$quicklink.className}" >

            <div class="clsQuickLinksContainer">
            <div class="clsQuickLinksLeft">
                    <a href="{$quicklink.playlistUrl}"  class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                	   <img src="{$quicklink.imageSrc}" alt="{$quicklink.record.video_title|truncate:10}"  border="0"{$quicklink.disp_image}/>
                   </a>
                  <span class="clsRunTime">{$quicklink.playing_time}<a class="" onclick="deleteVideoQuickLinks('{$quicklink.record.video_id}')" title="{$LANG.videolist_delete_quicklist_tooltips}"></a></span>
            </div>
            	<div class="clsQuickLinksMiddle">
                    <p id="selMemberName" class="clsFeaturedVideoThumbDetailsTitle">
                        <a href="{$quicklink.playlistUrl}">
                            {$quicklink.video_title}
                        </a>
                    </p>
                    <p><span>{$LANG.common_from}: </span>{$myobj->getUserDetail('user_id',$quicklink.record.user_id, 'user_name')}</p>
                    <p><span>{$LANG.views}: </span>{$quicklink.record.total_views}</p>
                    <p class="clsCloseQuickLink"><a onclick="deleteVideoQuickLinks('{$quicklink.record.video_id}')" title="{$LANG.videolist_delete_quicklist_tooltips}" class="clsPhotoVideoEditLinks">{$LANG.viewvideo_remove_this_video}</a></p>
            	</div>
           </div>
        </li>
        {/foreach}
        {if !$quicklink.video_id}
        </ul>
        {/if}
        </div>
        </div>
        {if $myobj->sellAllVideo}
          <p class="clsViewAllLinks clsSeeMoreQuickLinks"><a onclick="moreVideosQuickList()">{$LANG.see_all_videos}</a></p>
        {/if}
 

{/if}
{if !isAjaxpage() OR $myobj->showRoundedCorner}
{$myobj->setTemplateFolder('general/','video')}
{include file='box.tpl' opt='viewvideodetails_bottom'}
{/if}