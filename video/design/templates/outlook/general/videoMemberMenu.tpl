{if isLoggedin()}
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='sidebar_top'}
<div class="clsSideBarLinks">
	<div class="clsSideBar">
    	<div class="clsOverflow">
            <p class="clsSideBarLeftTitle">{$LANG.header_nav_video_my_dash_board_videos}</p>

        </div>
    	<div class="clsSideBarRight">
            <div class="clsSideBarContent">
                <ul>
                	<!--<li class="{$myobj->getVideoNavClass('left_videouploadpopup')}"><a href="{php} echo getUrl('videouploadpopup','','','members','video'); {/php}">{$LANG.header_nav_video_upload_my_video}</a></li>-->
	                <li class="{$myobj->getVideoNavClass('left_videolist_videonew')}"><a href="{php} echo getUrl('videolist', '?pg=videonew', 'videonew/','','video'); {/php}">{$LANG.header_nav_video_all_videos}</a></li>
                    <!--<li class="{$myobj->getVideoNavClass('left_videolist_myvideos')}"><a href="{php} echo getUrl('videolist', '?pg=myvideos', 'myvideos/','members','video'); {/php}">{$LANG.header_nav_video_my_videos}</a></li>-->
                    <li class="{$myobj->getVideoNavClass('left_videolist_myfavoritevideos')}">
                        <a href="{php} echo getUrl('videolist', '?pg=myfavoritevideos', 'myfavoritevideos/','members','video'); {/php}">
                        {$LANG.header_nav_video_my_favorites}
                        </a>
                    </li>
                    <li class="{$myobj->getVideoNavClass('left_myvideoalbums')}"><a href="{php} echo getUrl('myvideoalbums','','','members','video') {/php}">{$LANG.header_nav_video_my_video_albums}</a></li>
                    <li class="{$myobj->getVideoNavClass('left_managecomments')}">
                        <a href="{php} echo getUrl('managecomments', '', '','members','video'); {/php}">{$LANG.header_nav_video_manage_video_comments}</a>
                    </li>
                    <!--<li class="{$myobj->getVideoNavClass('left_managevideoresponses')}"><a href="{php} echo getUrl('managevideoresponses', '', '', 'members', 'video'); {/php}">{$LANG.header_lang_my_video_responses}</a></li>-->
                    {if $CFG.user.is_upload_background_image=="Yes"}
                     <li class="{$myobj->getVideoNavClass('left_managebackground')}"><a href="{php} echo getUrl('managebackground', '', '','members','video'); {/php}">{$LANG.header_nav_video_manage_background}</a></li>
                    {/if}
                    {if $header->isAffiliateMember()}
                    <li class="{$myobj->getVideoNavClass('left_videoadvertisement')}"><a href="{php} echo getUrl('videoadvertisement','','members','video'); {/php}">{$LANG.header_nav_video_manage_video_advertisemet}</a></li>
                    {/if}
                </ul>
            </div>
    	</div>
    </div>
</div>
{include file='box.tpl' opt='sidebar_bottom'}
{if  $myobj->_currentPage != 'index'}
{if $CFG.admin.videos.allow_quick_links OR $CFG.admin.videos.allow_play_list OR $CFG.admin.videos.allow_history_links}
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='sidebar_top'}
<div class="clsSideBarLinks">
	<div class="clsSideBar">
    	<div class="clsSideBarLeft">
            <p class="clsSideBarLeftTitle">{$LANG.header_nav_video_manage_video_my_playlist_quicklinks_title}</p>
            </div>
    	<div class="clsSideBarRight">
        	<div class="clsSideBarContent">
    			<ul>
	{if $CFG.admin.videos.allow_play_list}
					<li class="{$myobj->getVideoNavClass('left_videoplaylist')}"><a href="{php} echo getUrl('videoplaylist', '', '', '', 'video'); {/php}">{$LANG.header_nav_video_manage_video_playlist_list}</a></li>
                    <li class="{$myobj->getVideoNavClass('left_videoplaylistmanage')}"><a href="{php} echo getUrl('videoplaylistmanage', '', '', '', 'video');{/php}">{$LANG.header_nav_video_manage_video_playlist}</a></li>
                {/if}
                {if $CFG.admin.videos.allow_quick_links}
                    <li class="{$myobj->getVideoNavClass('left_mydashboard_ql')}"><a href="{php} echo getUrl('mydashboard', '?block=ql', '?block=ql','','video');{/php}">{$LANG.header_nav_video_manage_video_my_quicklinks}</a></li>
                {/if}
                {if $CFG.admin.videos.allow_history_links}
                    <li class="{$myobj->getVideoNavClass('left_mydashboard_hst')}"><a href="{php} echo getUrl('mydashboard', '?block=hst', '?block=hst','','video'); {/php}">{$LANG.header_nav_video_manage_video_my_views_histories}</a>
                    </li>
                {/if}
           		 </ul>
            </div>
    	</div>
    </div>
</div>
{include file='box.tpl' opt='sidebar_bottom'}
{/if}
{/if}
{/if}


