{if $myobj->isShowPageBlock('myHotLinks')}
	<div id="selMyDashBoardShortLinks">
		<h3>{$LANG.mydashboard_short_links}</h3>
  		<ul>
    	{if $myobj->chkAllowedModule(array('video'))}
			<li class="{$myobj->videoUploadPopUp_Page}"><a href="{$myobj->videoUploadPopUpUrl}">{$LANG.dashboard_video_upload_my_video}</a></li>
   			<li class="{$myobj->videoList_pg_myvideos}"><a href="{$myobj->myVideoUrl}">{$LANG.mydashboard_videos}</a></li>
    	{/if}
		{if $myobj->chkAllowedModule(array('article')) and $myobj->chkThisUserAllowedToPostArticle()}
        	<li class="{$myobj->articleList_pg_myarticles}"><a href="{$myobj->myArticleUrl}">{$LANG.mydashboard_articles}</a></li>
    	{/if}
	    {if $myobj->chkAllowedModule(array('music'))}
    		<li class="{$myobj->musicList_pg_mymusics}"><a href="{$myobj->myMusicUrl}">{$LANG.mydashboard_audio}</a></li>
        {/if}
	    {if $myobj->chkAllowedModule(array('photo'))}
    		<li class="{$myobj->photoList_pg_myphotos}"><a href="{$myobj->myPhotoUrl}">{$LANG.mydashboard_photos}</a></li>
        {/if}
    	{if $myobj->chkAllowedModule(array('game'))}
    		<li class="{$myobj->gameList_pg_mygames}"><a href="{$myobj->myGameUrl}">{$LANG.mydashboard_games}</a></li>
        {/if}
    		<li class="{$myobj->myFriends}"><a href="{$myobj->myFriendsUrl}">{$LANG.mydashboard_friends}</a></li>
	    {if $myobj->chkAllowedModule(array('affiliate'))}
		    <li class="{$myobj->memberBlock}"><a href="{$myobj->memberListUrl}">{$LANG.mydashboard_my_referrals}</a></li>
        {/if}
  	   	{if $myobj->chkAllowedModule(array('mail'))}
		    <li class="{$myobj->mail_pg_inbox}"><a href="{$myobj->inboxUrl}">{$LANG.mydashboard_inbox}</a></li>
        {/if}
    	{if $myobj->chkAllowedModule(array('community', 'groups')) and allowedGroupCreate()}
    		<li class="{$myobj->groupMy}"><a href="{$myobj->mygroupUrl}">{$LANG.mydashboard_groups}</a></li>
        {/if}
    		<li class="{$myobj->myProfile}"><a href="{$myobj->myProfileUrl}">{$LANG.mydashboard_profile}</a></li>
    	{if $myobj->chkAllowedModule(array('members_banner', 'members_post_banner'))}
			<li class="{$myobj->manageBanner}"><a href="{$myobj->manageBannerUrl}">{$LANG.mydashboard_manage_banner}</a></li>
        {/if}
	    {if $myobj->chkAllowedModule(array('blog'))}
		    <li class="{$myobj->manageBlog}"><a href="{$myobj->manageBlogUrl}">{$LANG.mydashboard_my_blogs}</a></li>
        {/if}
	    {if $myobj->chkAllowedModule(array('affiliate'))}
		    <li class="{$myobj->earnings}"><a href="{$myobj->myEarningsUrl}">{$LANG.mydashboard_my_earnings}</a></li>
        {/if}
    	{if $myobj->chkAllowedModule(array('affiliate'))}
		    <li class="{$myobj->List_pg_referrals}"><a href="{$myobj->pageRefferalUrl}">{$LANG.mydashboard_my_referrals}</a></li>
        {/if}
  		</ul>	
	</div>
	<div id="selMyDashBoardShortLinks">
		<h3>{$LANG.mydashboard_stats}</h3>
		<ul>
		    <li>{$LANG.mydashboard_videos_watched}: <span>{$this->getTotalVideosWatched()}</span></li>
		    <li>{$LANG.mydashboard_total_videos}: <span>{$this->getTotalVideos()}</span></li>
		    <li>{$LANG.mydashboard_total_favourites}: <span>{$this->getTotalVideosFavourite()}</span></li>
		    <li>{$LANG.mydashboard_video_views}: <span>{$this->getTotalVideosViews()}</span></li>
		    <li>{$LANG.mydashboard_menu_friends}: <span>{$this->getTotalFriendsNew() ?></span></li>
		</ul>
	</div>
{/if}