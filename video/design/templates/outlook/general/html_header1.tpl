{$myobj->getTpl('general','header.tpl')}
<iframe name="facebook_logout" id="facebook_logout" style="display:none"></iframe>
<script type="text/javascript">
var loader_image = '<div class="clsLoader"><img src="{$CFG.site.video_url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/loader.gif" alt="{$LANG.common_loading}"/>{$LANG.common_loading}</div>';
var subscription_loader_image = '<div class=""><img src="{$CFG.site.video_url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/loader.gif" alt="{$LANG.common_loading}"/></div>';

</script>
<script src="{$CFG.site.video_url}js/jquery.fancybox.js" type="text/javascript"></script>
<script src="{$CFG.site.video_url}js/functions.js" type="text/javascript"></script>
{* GENERATE BLOG RELATED JS VARIABLES -start *}
    {* $myobj->populateBlogJsVars() *}
{* GENERATE BLOG RELATED JS VARIABLES -end *}

<div id="header" class="clsHeaderContainer">
    <div class="clsHeaderShadowImage">
        <div class="clsHeaderBlock">
            <div class="clsMainLogo">
                <h1>
                    <a href="{$header->index_page_link}"><img src="{$header->logo_url}" alt="{$CFG.site.name}" title="{$CFG.site.name}" /></a>
                </h1>
            </div>
            <div class="clsHeaderContents">
                <!-- Top header menu Begins -->
                <div class="clsTopHeaderLinks">
                	{$myobj->getTpl('general','topMenu.tpl')}
                </div>
                <!-- End of Top header menu -->
                <div class="clsTopHeader">
				
				{* BANNER SECTION STARTS *}
					<div class="cls468pxTopBanner">
						<div>{php}getAdvertisement('top_banner_468x60'){/php}</div>
					</div>
				{* BANNER SECTION ENDS *}
				
				<div id="selRightHeader" class="clsSearchUploadContainer">
					{$myobj->getTpl('general','topUpload.tpl')}
					{$myobj->getTpl('general','topSearch.tpl')}
				</div>
				
              </div>
            </div>
            <div class="clsNavigationStatsContainer">
                <div class="clsMainNavMiddle">
                    <div class="clsMainNavLeft">
                        <div class="clsMainNavRight">
                            <!-- Start of Main Menu -->
                            {$myobj->getTopMenu('general','mainMenu.tpl')}
                            <!-- end of Main Menu -->
                            <!-- stats starts -->
                            {$header->populateSiteStatistics()}
                            <!-- stats ends -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

   	{if $header->isUserStyle()}
    	<div class="clsBodyContent profileBodyContent">
    {else}
		<div class="clsBodyContent">
	{/if}
<div class="clsVideoTopHeadingDetails">
	<div class=" clsOverflow">
	<div class="clsFloatLeft">
		<a href="{$myobj->getUrl('index','','','','video')}"><h3 class="clsFloatLeft">{$LANG.common_video_index_title}</h3></a>
		<div class="clsMusicHeadDetailRight">
			<p>
				{$myobj->indexPageTotalVideosInSite()}
				<span>{$LANG.common_video_total_tracks}, </span>

				{$myobj->indexPageTotalVideoWatched()}
				<span>{$LANG.common_video_total_watched}, </span>

				{$myobj->indexPageTotalVideoDownload()}
				<span>{$LANG.common_video_total_downloads}</span>
			</p>
		</div>
	</div>
	<div class="clsOverflow">
	<ul class="clsDropDownRight">
	<li class="selDropDownLink clsWidth200">
	<div class="clsMyshortPopRight">
		<div class="clsMyShortCutLeft">
			<div class="clsMyShortCutRight">
				<a href="#">{$LANG.my_video_shortcuts}</a>

			</div>
		</div><ul class="clsMyshortcutDropdown clsFloatRight">
					{$myobj->setTemplateFolder('general/', 'music')}
					{include file="box.tpl" opt="musicdrop_top"}
						<li>
							<a href="{$myobj->getUrl('videouploadpopup','','','members','video')}">{$LANG.video_shortcuts_uploadvideo}</a>
						</li>
						<li>
							<a href="{$myobj->getUrl('videolist', '?pg=myvideos', 'myvideos/','members','video')}">{$LANG.video_shortcuts_myvideos}</a>
						</li>
						<li>
							<a href="{$myobj->getUrl('videolist', '?pg=myfavoritevideos', 'myfavoritevideos/','members','video')}"> {$LANG.header_nav_video_my_favorites}</a>
						</li>
						<li>
							<a href="{$myobj->getUrl('videoplaylist', '', '', '', 'video')}">{$LANG.header_nav_video_manage_video_my_playlist}</a>
						</li>
						<li>
							<a href="{$myobj->getUrl('mydashboard', '?block=ql', '?block=ql','','video')}">{$LANG.header_nav_video_manage_video_my_quicklinks}</a>
						</li>
					{$myobj->setTemplateFolder('general/', 'music')}
					{include file="box.tpl" opt="musicdrop_bottom"}
				</ul>
	</div>

				</li></ul>
	</div>
	</div>
	<div class="clsBreadcum">
		<ul>
			<li><a href="{$myobj->getUrl('index','','','','')}">{$LANG.common_video_home_title}</a></li>
			{if  $myobj->_currentPage == 'index'}
			<li>{$LANG.common_video_link_video}</li>
            {else}
            <li><a href="{$myobj->getUrl('index', '', '','','video')} ">{$LANG.common_video_link_video}</a></li>
			{if $myobj->_currentPage == 'videouploadpopup'}
	        <li>{$LANG.common_video_link_upload_video}</li>
	        {elseif $myobj->_currentPage == 'videolist'}
        	 <li>{$LANG.common_video_link_view_all_video}</li>
        	{elseif $myobj->_currentPage == 'myvideoalbums'}
        	 <li>{$LANG.common_video_link_myvideo_album}</li>
        	{elseif $myobj->_currentPage == 'managecomments'}
        	 <li>{$LANG.common_video_link_manage_video_comments}</li>
        	{elseif $myobj->_currentPage == 'managevideoresponses'}
        	 <li>{$LANG.common_video_link_manage_video_response}</li>
        	{elseif $myobj->_currentPage == 'managebackground'}
        	 <li>{$LANG.common_video_link_manage_video_manage_background}</li>
        	{elseif $myobj->_currentPage == 'videoplaylist'}
        	 <li>{$LANG.common_video_link_manage_video_playlist}</li>
        	{elseif $myobj->_currentPage == 'videoplaylistmanage'}
        	 <li>{$LANG.common_video_link_manage_video_playlist_manage}</li>
        	{elseif $myobj->_currentPage == 'mydashboard'}
        	 <li>{$LANG.common_video_link_manage_video_my_quicklinks}</li>
	        {/if}
			{/if}
		</ul>
	</div>
</div>
    {if !$myobj->chkIsAllowedLeftMenu()}
    <!--SIDEBAR-->
        <div class="sideBar1">

        {*  ## Video Menu For MEMBERS *}
        {$myobj->setTemplateFolder('general/','video')}

        {$myobj->populateVideoMemberMenu()}
        {$myobj->populateVideoChannelsRightNavigation()}
		
		{* BANNER SECTION STARTS *}
			{if $myobj->_currentPage == 'videolist'}
				<div class="cls336pxBanner">
					<div>{php}getAdvertisement('sidebanner1_336x280'){/php}</div>
				</div>
			{/if}
	   {* BANNER SECTION ENDS *}	
		
        {$myobj->populateVideoTagsRightNavigation()}

        </div>
    <!--end of SIDEBAR-->
    {/if}

<!-- Main -->
<div id="main" class="{$CFG.main.class_name} {$header->headerBlock.banner.class}">
<!-- Header ends -->

{if $header->chkIsProfilePage()}
	<div class="clsProfilePageStyles">
{/if}
