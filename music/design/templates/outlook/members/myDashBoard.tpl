{if !isAjax()}
	{$myobj->setTemplateFolder('general/','music')}
	{include file='box.tpl' opt='audioindex_top'}  
{/if}

{if $myobj->isShowPageBlock('musicMainBlock')}
	{if !isAjax()}
		<div id="selMyDashBoard">
	{/if}

{if $myobj->getFormField('block')=='ql'}
	{if !isAjax()}
    	<div class="clsAudioIndex"><h3>{$LANG.mydash_board_title}</h3></div>
    {/if}
{else}
	{if !isAjax()}
    	<div class="clsAudioIndex"><h3>{$LANG.mydash_board_history_title}</h3></div>
    {/if}
{/if}
     	
{if $myobj->isShowPageBlock('msg_form_error')}
    <div id="selMsgError">
        <p>{$myobj->getCommonErrorMsg()}</p>
     </div>
{/if}  
         
{if !isAjax()}
    <div id="selIndexVideoLink" class="clsAudioListMenu">
    <ul>
    {if $CFG.admin.musics.allow_history_links}
    <li class="{$myobj->activeblockcss_historyLinks}">
            <a href="{$myobj->html_url}?block=hst{$myobj->query_str}"><span>{$LANG.mydashboard_type_history_link}</span></a>
    </li>
    {/if}
    {*if $CFG.admin.musics.allow_quick_mixs*}
   <!-- <li class="{$myobj->activeblockcss_quickLinks}">-->
           <!-- <a href="{$myobj->html_url}?block=ql{$myobj->query_str}"><span>-->{*$LANG.mydashboard_type_quick_link*}<!--</span></a>-->
  <!--  </li>-->
    {*/if*}
   <!-- </ul>-->
</div>
   <script type="text/javascript" language="javascript">
        var subMenuClassName1='clsActiveTabNavigation';
        var hoverElement1  = '.clsTabNavigation li';
        loadChangeClass(hoverElement1,subMenuClassName1);
    </script> 
                
    <div id="selSearchList">
    <div id="selVideoSearchListTitle">
{/if}
    {if $myobj->getFormField('block')=='ql'}

        {if isLoggedIn() and $CFG.admin.musics.allow_quick_mixs}
        
            <div id="selVideoQuickLinks">
            {if !$myobj->music_id}
                {*<h3 class="clsQuickLinksTitle">{$LANG.view_music_quick_links_title}</h3>*}
                <div id="selVideoQuickListDisp">
                    <ul id="selQuickList" class="clsMyQuickLinks">
            {/if}
            
            {foreach from=$myobj->quickLinkMusic item=quickLinkItem}
                <li id="quick_list_selected_{$quickLinkItem.record.music_id}" class="{$quickLinkItem.className}" >
                    <div class="clsQuickVideoInformation">
                        <div class="clsRelVideoImg">
                            <p id="selImageBorder" class="clsViewThumbImage">
                                <div  class="clsThumbImageLink clsPointer">
                                  <div class="ClsImageContainer ClsImageBorder1 Cls66x6">       
                                  	<a href="{$quickLinkItem.viewMusicUrl}"   class="ClsImageContainer ClsImageBorder1 Cls66x6"  >       
		                             <img border="0" src="{$quickLinkItem.imageSrc}" alt="{$quickLinkItem.record.music_title}" {$quickLinkItem.disp_image}/>
                                     </a>
                                  </div>
                                </div>
                            </p>
                        </div>
                        <div class="clsOuickVideoDetails">
                            <p id="selMemberName">
                            <a  href="{$quickLinkItem.viewMusicUrl}"><span class="clsHeading" >{$quickLinkItem.wrap_music_title}</span></a></p>
                            <p>{$LANG.common_from}: {$myobj->getUserName($quickLinkItem.record.user_id)}</p>
                            <p>{$LANG.common_views}: {$quickLinkItem.record.total_views}</p>
                                 <p>{$quickLinkItem.record.playing_time}
                                    <a class="clsQuickLinksRight" onclick="deleteMusicQuickLinks('{$quickLinkItem.record.music_id}')" title="{$LANG.musiclist_delete_quicklist_tooltips}"></a>
                                 </p>
                        </div>
                        <div class="clsDeleteVideo">
                               <div class="clsQuickLinksRight">
                                    <p><a   class="clsQuickLinksRight" onclick="deleteMusicQuickLinks('{$quickLinkItem.record.music_id}')" title="{$LANG.musiclist_delete_quicklist_tooltips}"><span class="clsQuickLinksRight">{$LANG.quicklink_remove_this_music}</span></a></p>
                                </div>
                        </div>
                  </div>
                </li>
            {/foreach}
                    
            {if $myobj->seeAllMusics}
                <li class="clsPlayAll">
                    <p><a onclick="moreMusicsQuickList()">{$LANG.see_all_musics}</a></p>
                </li>
            {/if}
            
            {if !$myobj->music_id}
                </ul>
                    <div class="clsVideoManageLinks clsOverflow">
                        <div class="clsVideoManageLinksLeft">
                              <input type="checkbox" onclick="toggleOnViewClearQuickList(this);" name="clear_quick_list" id="clear_quick_list" value="1" 
                              {$myobj->clear_quick_checked} />
                              <label for="clear_quick_list">{$LANG.clear_quick_list_msg}</label>
                        </div>
                        <div class="clsVideoManageLinksRight">
                                {$myobj->getNextPlayListQuickLinks($myobj->in_str, true)} 
                                    <a href="{$myobj->musicManageplaylistUrl}">{$LANG.view_music_quick_list_save}</a>
                                    <a onClick="clearQuickLinks()">{$LANG.view_music_quick_list_clear}</a>
                        </div>
                    </div>
                </div>
            {/if}
            </div>
        {/if}

            <!--<div id="selMsg" class="clsNoQuickLink"  {*if !$myobj->quickLinkTip*} style="display:none" {*/if*}>-->
            	<!--<p>{*$LANG.mydashboard_quick_links_no_records*}</p>-->
               <!-- <p class="clsNormal">{*$LANG.mydashboard_quick_links_tip*}</p></div>-->
          <!--  </div>-->
   
    {elseif $myobj->getFormField('block')=='hst' and isLoggedIn() and $myobj->CFG.admin.musics.allow_history_links}
        <div id="selVideoHistoryLinks">
        {if $myobj->music_id}
            <h3>{$myobj->LANG.view_music_quick_history_title}</h3>
        {/if}
        <div id="selVideoQuickListDisp">
            <ul id="selQuickList" class="clsMyQuickLinks">
            
                {if !$myobj->historyLinkTip}
                
                    {foreach from=$myobj->historyMusics item=viewingHistory}
                        <li id="quick_list_selected_{$viewingHistory.record.music_id}" >
                            <div class="clsQuickVideoInformation">
                                <div class="clsRelVideoImg">
                                    <p id="selImageBorder" class="clsViewThumbImage">
                                         <div  class="clsThumbImageLink clsPointer">
                                              <div class="ClsImageContainer ClsImageBorder1 Cls66x66"> 
                                              	<a href="{$viewingHistory.viewMusicUrl}"   class="ClsImageContainer ClsImageBorder1 Cls66x66" >                     
													<img src="{$viewingHistory.imageSrc}" border="0" alt="{$viewingHistory.record.music_title}"	{$viewingHistory.disp_image} /></a>
                                               </div>
                                        	</div>
                                    </p>
                                </div>
                                <div class="clsOuickVideoDetails">
                                    <p id="selMemberName"><a href="{$viewingHistory.viewMusicUrl}"> {$viewingHistory.wrap_music_title}</a> </p>
                                    <p>{$myobj->LANG.from} {$myobj->getUserName($viewingHistory.record.user_id)}</p>
                                    <p>{$myobj->LANG.views} {$viewingHistory.record.total_views}</p>
                                            <p>{$viewingHistory.record.playing_time}
                                                <a class="" onclick="deleteMusicQuickHistoryLinks('{$viewingHistory.record.music_id}')" title="{$LANG.musiclist_history_quicklist_tooltips}">
                                                </a>
                                            </p>
                                </div>
                                <div class="clsDeleteVideo">
                                        <div class="clsQuickLinksRight">
                                            <p>
                                                <a onclick="deleteMusicQuickHistoryLinks('{$viewingHistory.record.music_id}')" title="{$LANG.musiclist_history_quicklist_tooltips}">
                                                {$myobj->LANG.histroyLinks_remove_this_music}
                                                </a>
                                            </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    {/foreach}
                     
                    {if $myobj->seeAllHistoryMusics}
                        <li>
                        <p><a onclick="moreMusicsQuickHistoryList()">{$LANG.see_all_musics}</a></p>
                        
                    </li>
                    {/if}
                    <li>
                    <h4><a onClick="clearQuickHistoryLinks();">{$LANG.view_music_quick_clear_history}</a></h4>
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

{$myobj->setTemplateFolder('general/','music')}
{include file='box.tpl' opt='audioindex_bottom'}  
{/if}