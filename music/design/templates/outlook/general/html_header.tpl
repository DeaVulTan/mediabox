{$myobj->getTpl('general','header.tpl')}
<iframe name="facebook_logout" id="facebook_logout" style="display:none"></iframe>
<script type="text/javascript">
window.name="mycartwindow";
</script>
<script type="text/javascript">
var music_ajax_page_loading = '<img alt="{$LANG.common_music_loading}" src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/loader.gif" />';
var music_site_url = '{$CFG.site.music_url}';
</script>
{* GENERATE MUSIC RELATED JS VARIABLES -start *}
	{$myobj->populateMusicJsVars()}
{* GENERATE MUSIC RELATED JS VARIABLES -end *}


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


<div class="clsOverflow">
	<div class="clsHeadTopMusicLeft">
		<div class="clsMusicHeadDetailLeft">        
			<a href="{$myobj->getUrl('index','','','','music')}" title="{$LANG.common_music_head}">{$LANG.common_music_head}</a>
		</div>
		<div class="clsMusicHeadDetailRight">
			<p>
				<a href="{$myobj->getUrl('musiclist','?pg=musicnew','musicnew/','members','music')}" title="{$LANG.common_music_head_tracks}">{$myobj->getTotalSongs()}</a>
				<span>{$LANG.common_music_head_tracks},</span>                
				<a href="{$myobj->getUrl('musiclist','?pg=musicmostviewed','musicmostviewed/','','music')}" title="{$LANG.common_music_head_listened}">{$myobj->totalSongsListened()}</a>
				<span>{$LANG.common_music_head_listened},</span>
				<span>{$myobj->totalSongsDonwloads()} {$LANG.common_music_head_downloads},</span>
                <a href="{$myobj->getUrl('musicplaylist','?pg=playlistnew','playlistnew/','members','music')}" title="{$LANG.common_music_head_playlists}">{$myobj->getTotalPlaylists()}</a>
				<span>{$LANG.common_music_head_playlists}</span>
			</p>
		</div>
	</div>
	<div class="clsHeadTopMusicRight">
	{if isMember()}
    	{if (isLoggedIn() and $CFG.admin.musics.allow_quick_mixs)}
		<div class="clsQuickMixLink">
			<div class="clsQuickMixLeft">
				<div class="clsQuickMixRight">
					<a href="javascript:void(0)" onclick="quickMixPlayer();">{$LANG.header_music_open_quick_mix}</a>
				</div>
			</div>
		</div>
        {/if}
	{/if}
	{if $CFG.admin.musics.individual_song_play}
		<div class="clsVolumeBar">
			<div id="volume_container" class="clsVolumeDisabled" onmouseover="show_what_is_this()">
				<div id="volume_speaker" onclick="mute_volume()" class="clsSpeakerOn"></div>
				<div class="clsVolumeAdjust">
					<div id="volume_slider" class="slider">
					</div>
				</div>
			</div>
		</div>
		<!--<div id="volume_what_is_this" class="clsVolumeHelp" onmouseover="show_volume_help_tip()" onmouseout="hide_volume_help_tip()" style="visibility:hidden;"></div>-->
	{/if}
	<div class="clsMyMusicShortcut clsOverflow">
    {assign var=css_temp value=''}
		<ul>
			<li class="selDropDownLink">
				<div class="clsMyMusicShortcutLeft">
					<div class="clsMyMusicShortcutRight">
						<a href="#">{$LANG.common_music_head_music_shortcuts}</a>
					</div>
				</div>
				<ul class="clsMyshortcutDropdown">
					{$myobj->setTemplateFolder('general/', 'music')}
					{include file="box.tpl" opt="musicdrop_top"}
						<!--<li>
							<a  href="{$myobj->getUrl('musicuploadpopup', '', '', 'members', 'music')}">{$LANG.common_music_head_upload_music}</a>
						</li>
						<li>
							<a href="{$myobj->getUrl('musiclist', '?pg=mymusics', 'mymusics/', 'members', 'music')}">{$LANG.common_music_head_my_music}</a>
						</li>
						<li>                
							 <a  href="{$myobj->getUrl('musicalbummanage', '', '', 'members', 'music')}">{$LANG.common_music_head_manage_album}</a>
						</li>-->
						<li>
							<a href="{$myobj->getUrl('musicplaylist', '?pg=myplaylist', 'myplaylist/', 'members', 'music')}">{$LANG.common_music_head_my_playlist}</a>
						</li>
                        
                        <li>
							<a href="{$myobj->getUrl('musicplaylist', '?pg=myplaylist', 'myplaylist/', 'members', 'music')}">{$LANG.common_music_head_my_playlist}</a>
						</li>
                                              
						<!--<li>
							<a href="{$myobj->getUrl('musicdefaultsettings', '', '', '', 'music')}">{$LANG.common_music_head_music_setting}</a>
						</li>-->
					{$myobj->setTemplateFolder('general/', 'music')}
					{include file="box.tpl" opt="musicdrop_bottom"}
				</ul>
			</li>
		</ul>
	</div>
  </div>
</div>
<div class="clsBreadcum">
<p>
    <a href="{$myobj->getUrl('index','','','','')}" alt="{$LANG.common_music_link_home}" title="{$LANG.common_music_link_home}">{$LANG.common_music_link_home}</a>
    {if  $myobj->_currentPage == 'index'}
    	{$LANG.common_music_link_music}
    {else}
        <a href="{$myobj->getUrl('index','','','','music')}" alt="{$LANG.common_music_link_music}" title="{$LANG.common_music_link_music}">{$LANG.common_music_link_music}</a>    
        {if $myobj->_currentPage == 'musiclist'}
        	{$LANG.common_music_link_view_all_music}
        {elseif $myobj->_currentPage == 'musicuploadpopup'}
        	{$LANG.common_music_link_upload_music}
        {elseif $myobj->_currentPage == 'mymusictracker'}
        	{$LANG.common_music_link_my_music_tracker}
        {elseif $myobj->_currentPage == 'albumlist' || $myobj->_currentPage == 'albumsortlist'}
        	{$LANG.common_music_link_album_list}
        {elseif $myobj->_currentPage == 'musicalbummanage'}
        	{$LANG.common_music_link_music_album_manage}
        {elseif $myobj->_currentPage == 'musicplaylist'}
        	{$LANG.common_music_link_music_playlist}
        {elseif $myobj->_currentPage == 'musicplaylistmanage'}
        	{$LANG.common_music_link_music_playlist_manage}
        {elseif $myobj->_currentPage == 'manageplaylistcomments'}
        	{$LANG.common_music_link_manage_playlist_comments}
        {elseif $myobj->_currentPage == 'musicdefaultsettings'}
        	{$LANG.common_music_link_music_default_settings}
        {elseif $myobj->_currentPage == 'transactionlist'}
        	{$LANG.common_music_link_transaction_list}
        {elseif $myobj->_currentPage == 'managemusiccomments'}
        	{$LANG.common_music_link_manage_music_comments}
        {elseif $myobj->_currentPage == 'listenmusic'}
        	{$LANG.common_music_link_listen_music}
        {elseif $myobj->_currentPage == 'viewalbum'}
        	{$LANG.common_music_link_view_album}
        {elseif $myobj->_currentPage == 'viewplaylist'}
        	{$LANG.common_music_link_view_playlist}
        {elseif $myobj->_currentPage == 'artistlist'}
        	{$LANG.common_music_link_artist_list}
        {elseif $myobj->_currentPage == 'artistphoto'}
        	{$LANG.common_music_link_artist_photo}
        {elseif $myobj->_currentPage == 'musicdownload'}
        	{$LANG.common_music_link_download_music}  
        {/if} 
       
    {/if}
	 </p>
</div>


{if !$myobj->chkIsAllowedLeftMenu()}
    <!--SIDEBAR-->
          <div class="clsSideBar1Audio" id="sideBarAudio">
             {* MY MUSIC SECTION STARTS *}
            	{$myobj->populateMemberDetail('music')}
             {* MY MUSIC SECTION ENDS *}
             
          	 {* MY MUSIC SECTION STARTS *}
            	{$myobj->populateMemberDetail('playlist')}
             {* MY MUSIC SECTION ENDS *}

			 {* BANNER SECTION STARTS *}
				{if $myobj->_currentPage == 'musiclist'}
					<div class="cls336pxBanner">
						<div>{php}getAdvertisement('sidebanner1_336x280'){/php}</div>
					</div>
				{/if}
		  	 {* BANNER SECTION ENDS *}	

             {* GENRES SECTION STARTS *}
                 {$myobj->populateGenres()}
             {* GENRES SECTION ENDS *}
		
            <div class="clsTagsRightTab" id="cloudTabs">
            	{assign var=music_cloud_display value=$myobj->populateSidebarClouds('music', 'music_tags')}
                {assign var=artist_cloud_display value=$myobj->populateSidebarClouds('artist', 'music_artist')}                
                {assign var=playlist_cloud_display value=$myobj->populateSidebarClouds('playlist', 'music_playlist_tags')}
                <ul class="clsOverflow">
                    {if $music_cloud_display}<li><a href="#tagCloudsmusic">{$LANG.common_music_cloud_music}</a></li>{/if}
                    {if $artist_cloud_display}<li><a href="#tagCloudsartist">{$LANG.common_music_cloud_artist}</a></li>{/if}
                    {if $playlist_cloud_display}<li><a href="#tagCloudsplaylist">{$LANG.common_music_cloud_playlist}</a></li>{/if}
                </ul>                
            </div> 
			       
            <script type="text/javascript">
                {literal}
                $Jq(window).load(function(){
					attachJqueryTabs('cloudTabs');
                });
                {/literal}
            </script>

			{* BANNER SECTION STARTS *}
				{if $myobj->_currentPage == 'musiclist'}
					<div class="cls336pxBanner">
						<div>{php}getAdvertisement('sidebanner2_336x280'){/php}</div>
					</div>
				{/if}
		  	 {* BANNER SECTION ENDS *}	

          </div>
    <!--end of SIDEBAR-->
{/if}

<!-- Main -->
<div id="main" class="{$CFG.main.class_name} {$header->headerBlock.banner.class}">
<!-- Header ends -->
{if $header->chkIsProfilePage()}
	<div class="clsProfilePageStyles">
{/if}

{literal}
<script type="text/javascript">
var volume_slider = $Jq("#volume_slider").slider({
			min: 0,
			max: 100,
			value: playlist_player_volume,
			disabled: true,
			slide: function(event, ui) {
				playlist_player_volume = ui.value;
				//TO CHANGE MUTE CONTROL AND VOLUME CONTROL BACKGROUND
				toggle_volume_control(ui.value);
				setVolume(ui.value);
			},
			change: function(event, ui) {
				playlist_player_volume = ui.value;
				//TO CHANGE MUTE CONTROL AND VOLUME CONTROL BACKGROUND
				toggle_volume_control(ui.value);
				//FOR MUTE CONTROL
				//if(playlist_player_volume_mute_prev != playlist_player_volume_mute_cur)
					{
						playlist_player_volume_mute_prev = playlist_player_volume_mute_cur;
						playlist_player_volume_mute_cur = ui.value;
					}
				setVolume(ui.value);
				store_volume_in_session(ui.value);
	      	}
		});


$Jq(document).ready(function(){
	//TO CHANGE MUTE CONTROL AND VOLUME CONTROL BACKGROUND
	toggle_volume_control(playlist_player_volume);

	var menuLi = $Jq('.clsMenu li');
	menuLi.each(function(li)
	{
		$Jq(this).bind('mouseover', function()
		{
			$Jq(this).addClass('clsHoverMenu');
		});
		$Jq(this).bind('mouseout', function()
		{
			$Jq(this).removeClass('clsHoverMenu');
		});
	});

	{/literal}
	{section loop=$menu.main start=0 step=1 name=sec max=$mainMenuMax}
		{literal}listen('mouseover', {/literal}'{$menu.main[sec].id}'{literal}, function(){
			{/literal}
			{if $mainmenu_more}
				{literal}
				allowMenuMoreHide=true;
				hideMenuMore();
				{/literal}
			{/if}
			{if $menu_channel}
				{literal}
				allowChannelHide=true;
				hideChannel();
				{/literal}
			{/if}
			{literal}
		});
	{/literal}
	{/section}
	{literal}
});
function openPopupWindow(url){
  	window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
}
</script>
{/literal}