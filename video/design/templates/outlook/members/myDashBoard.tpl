{if !isAjax()}
	{$myobj->setTemplateFolder('general/')}
	{include file='box.tpl' opt='display_top'}
{/if}

{if $myobj->isShowPageBlock('videoMainBlock')}
	{if !isAjax()}
		<div id="selMyDashBoard">
	{/if}

{if $myobj->getFormField('block')=='ql'}
	{if !isAjax()}
    	<div class="clsPageHeading"><h2>{$LANG.mydash_board_title}</h2></div>
    {/if}
{else}
	{if !isAjax()}
    	<div class="clsPageHeading"><h2>{$LANG.mydash_board_history_title}</h2></div>
    {/if}
{/if}

{if $myobj->isShowPageBlock('msg_form_error')}
    <div id="selMsgError">
        <p>{$myobj->getCommonErrorMsg()}</p>
     </div>
{/if}

{if !isAjax()}
    <div id="selIndexVideoLink" class="clsTabNavigation">
    <ul>

    {if $CFG.admin.videos.allow_history_links}
    <li class="{$myobj->activeblockcss_historyLinks}">        
            <a href="{$myobj->html_url}?block=hst{$myobj->query_str}"><span class="{$myobj->activeRightblockcss_historyLinks}">{$LANG.mydashboard_type_history_link}</span></a>
    </li>
    {/if}
    {if $CFG.admin.videos.allow_quick_links}
    <li class="{$myobj->activeblockcss_quickLinks}">        
            <a href="{$myobj->html_url}?block=ql{$myobj->query_str}"><span class="{$myobj->activeRightblockcss_quickLinks}">{$LANG.mydashboard_type_quick_link}</span></a>
    </li>
    {/if}
    </ul>
</div>
    <script>
        var subMenuClassName1='clsActiveTabNavigation';
        var hoverElement1  = '.clsTabNavigation li';
        loadChangeClass(hoverElement1,subMenuClassName1);
    </script>

    <div id="selSearchList">
    <div id="selVideoSearchListTitle">
{/if}
    {if $myobj->getFormField('block')=='ql'}

        {if isLoggedIn() and $CFG.admin.videos.allow_quick_links}

            <div id="selVideoQuickLinks">
            {if !$myobj->video_id}
                {*<h3 class="clsQuickLinksTitle">{$LANG.view_video_quick_links_title}</h3>*}
                <div id="selVideoQuickListDisp">
                    <ul id="selQuickList" class="clsMyQuickLinks">
            {/if}
            {foreach from=$myobj->quickLinkVideo item=quickLinkItem key=inc}
                <li id="quick_list_selected_{$quickLinkItem.record.video_id}" class="{$quickLinkItem.className}{if $inc==0} clsNoBorder{/if}" >
                    <div class="clsQuickVideoInformation">
                        <div class="clsRelVideoImg">
                            <p id="selImageBorder" class="clsViewThumbImage">
                                <div  class="clsThumbImageLink clsPointer">
                                
                                          	<a href="{$quickLinkItem.viewVideoUrl}" class="Cls107x80 ClsImageBorder1 ClsImageContainer">
		                                    <img border="0" src="{$quickLinkItem.imageSrc}" alt="{$quickLinkItem.record.video_title|truncate:15}" {$quickLinkItem.disp_image}/>
                                            </a>
                                         
                                </div>
                            </p>
                        </div>
                        <div class="clsOuickVideoDetails">
                            <p id="selMemberName">
                            <a href="{$quickLinkItem.viewVideoUrl}">{$quickLinkItem.wrap_video_title}</a></p>
                            <p>{$LANG.common_from}: {$myobj->getUserDetail('user_id',$quickLinkItem.record.user_id, 'user_name')}</p>
                            <p>{$LANG.common_views}: {$quickLinkItem.record.total_views}</p>
                                 <p>{$quickLinkItem.record.playing_time}
                                    <a class="" onclick="deleteVideoQuickLinks('{$quickLinkItem.record.video_id}')" title="{$LANG.videolist_delete_quicklist_tooltips}"></a>
                                 </p>
                        </div>
                        <div class="clsDeleteVideo">
                               <div class="clsQuickLinksRight">
                                    <p><a onclick="deleteVideoQuickLinks('{$quickLinkItem.record.video_id}')" title="{$LANG.videolist_delete_quicklist_tooltips}">{$LANG.quicklink_remove_this_video}</a></p>
                                </div>
                        </div>
                  </div>
                </li>
            {/foreach}

            {if $myobj->seeAllVideos}
                <li class="clsViewAllFriends">
                    <p><a onclick="moreVideosQuickList()">{$LANG.see_all_videos}</a></p>
                </li>
            {/if}

            {if !$myobj->video_id}
                </ul>
                    <div class="clsVideoManageLinks clsOverflow" {if $myobj->quickLinkTip} style="display:none" {/if}>
                        <div class="clsVideoManageLinksLeft">
                              <input type="checkbox" onclick="toggleOnViewClearQuickList(this);" name="clear_quick_list" id="clear_quick_list" value="1"
                              {$myobj->clear_quick_checked} />
                              <label for="clear_quick_list">{$LANG.clear_quick_list_msg}</label>
                        </div>
                        <div class="clsVideoManageLinksRight">
                                {$myobj->getNextPlayListQuickLinks($myobj->in_str, true)}
                                    <a href="{$myobj->videoManageplaylistUrl}">{$LANG.view_video_quick_list_save}</a>
                                    <a onClick="clearQuickLinks()">{$LANG.view_video_quick_list_clear}</a>
                        </div>
                    </div>
                </div>
            {/if}
            </div>
        {/if}

            <div id="selMsg" class="clsNoQuickLink"  {if !$myobj->quickLinkTip} style="display:none" {/if}>
            	<p>{$LANG.mydashboard_quick_links_no_records}</p>
                <p class="clsNormal">{$LANG.mydashboard_quick_links_tip}</p></div>
            </div>

    {elseif $myobj->getFormField('block')=='hst' and isLoggedIn() and $myobj->CFG.admin.videos.allow_history_links}
        <div id="selVideoHistoryLinks">
        {if $myobj->video_id}
            <h3>{$myobj->LANG.view_video_quick_history_title}</h3>
        {/if}
        <div id="selVideoQuickListDisp">
            <ul id="selQuickList" class="clsMyQuickLinks">

                {if !$myobj->historyLinkTip}

                    {foreach from=$myobj->historyVideos item=viewingHistory  key=inc}
                        <li id="quick_list_selected_{$viewingHistory.record.video_id}" class="{if $inc==0} clsNoBorder{/if}" >
                            <div class="clsQuickVideoInformation">
                                <div class="clsRelVideoImg">
                                    <p id="selImageBorder" class="clsViewThumbImage">
                                         <div  class="clsThumbImageLink clsPointer">                                             
                                                      	<a href="{$viewingHistory.viewVideoUrl}" class="Cls107x80 ClsImageBorder1 ClsImageContainer">
                                                        <img src="{$viewingHistory.imageSrc}" alt="{$viewingHistory.record.video_title|truncate:15}" border="0" {$viewingHistory.disp_image} />
                                                        </a>
                                        	</div>
                                    </p>
                                </div>
                                <div class="clsOuickVideoDetails">
                                    <p id="selMemberName"><a href="{$viewingHistory.viewVideoUrl}"> {$viewingHistory.wrap_video_title}</a> </p>
                                    <p>{$myobj->LANG.from} {$myobj->getUserDetail('user_id',$viewingHistory.record.user_id, 'user_name')}</p>
                                    <p>{$myobj->LANG.views} {$viewingHistory.record.total_views}</p>
                                            <p>{$viewingHistory.record.playing_time}
                                                <a class="" onclick="deleteVideoQuickHistoryLinks('{$viewingHistory.record.video_id}')" title="{$LANG.videolist_history_quicklist_tooltips}">
                                                </a>
                                            </p>
                                </div>
                                <div class="clsDeleteVideo">
                                        <div class="clsQuickLinksRight">
                                            <p>
                                                <a onclick="deleteVideoQuickHistoryLinks('{$viewingHistory.record.video_id}')" title="{$LANG.videolist_history_quicklist_tooltips}">
                                                {$myobj->LANG.histroyLinks_remove_this_video}
                                                </a>
                                            </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    {/foreach}

                    {if $myobj->seeAllHistoryVideos}
                        <li class="clsViewAllFriends">
                        <p><a onclick="moreVideosQuickHistoryList()">{$LANG.see_all_videos}</a></p>

                    </li>
                    {/if}
                    <li>
                    <h4><a onClick="clearQuickHistoryLinks();">{$LANG.view_video_quick_clear_history}</a></h4>
                    </li>

             </ul>
           		<div id="selMsgSuccess">
                             <p>{$LANG.mydashboard_quick_history_tip_msg}</p>
            </div>
       	</div>


        {else}
            <div id="selMsg">{$LANG.mydashboard_quick_history_tip}</div>
        {/if}

      </div>
    {/if}

{if !isAjax()}
    </div>
    </div>
{/if}

{/if}

{if !isAjax()}
</div>
</div>

{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
{/if}