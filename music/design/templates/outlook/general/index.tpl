<div class="clsOverflow">
	{* ----------------------Right Side Content Starts ---------------------- *}
	<div class="clsMusicIndexRight">

    {* ----------------------Activities Content Starts ---------------------- *}
	{if $myobj->isShowPageBlock('sidebar_activity_block')}
        {$myobj->setTemplateFolder('general/', 'music')}
	    {include file="indexActivityHead.tpl"}
    {/if}
	{* ----------------------Activities Content ends ---------------------- *}
    
    {* MY MUSIC SECTION STARTS *}
	   {$myobj->populateMemberDetail('music')}
   	{* MY MUSIC SECTION ENDS *} 

	{* MY MUSIC SECTION STARTS *}
	   {$myobj->populateMemberDetail('playlist')}
   	{* MY MUSIC SECTION ENDS *}

    {* TOP CONTRIBUTORS SECTION STARTS *}
    	{if $myobj->isShowPageBlock('sidebar_topcontributors_block')}
        	{$myobj->topContributors()}
        {/if}
   	{* TOP CONTRIBUTORS SECTION ENDS *}

    {* POPULAR ARTIST SECTION STARTS *}
    {*** ASSIGNED FOR TOTAL POPULAR ARTIST DISPLAY - CAN CHANGE BASED ON TEMPLATE DESIGN ***}
    {assign var=index_total_popular_artist value='4'}
    
	{if isset($CFG.admin.musics.music_artist_feature) and $CFG.admin.musics.music_artist_feature}
    	{$myobj->populatePopularMemberArtist($index_total_popular_artist)}
    {else}
		{$myobj->populatePopularArtist($index_total_popular_artist)}
	{/if}
    {* POPULAR ARTIST SECTION ENDS *}

    {* Audio tracker SECTION STARTS *}
	    {$myobj->populateAudioTracker()}
    {* AUDIO TRACKER SECTION ENDS *}

    {* GENRES SECTION STARTS *}
    	{$myobj->populateGenres()}
    {* GENRES SECTION ENDS *}

    {* BANNER SECTION STARTS *}
    <div class="cls336pxBanner">
        <div>{php}global $CFG; getAdvertisement('sidebanner1_336x280'){/php}</div>
    </div>
    {* BANNER SECTION ENDS *}

	{* ARTIST CLOUDS SECTION STARTS *}
        <div class="clsTagsRightTab" id="cloudTabs">
        	{assign var=music_cloud_display value=$myobj->populateSidebarClouds('music', 'music_tags')}
            {assign var=artist_cloud_display value=$myobj->populateSidebarClouds('artist', 'music_artist')}
            <ul class="clsOverflow">
                {if $music_cloud_display}<li><a href="#tagCloudsmusic">{$LANG.common_music_cloud_music}</a></li>{/if}
                {if $artist_cloud_display}<li><a href="#tagCloudsartist">{$LANG.common_music_cloud_artist}</a></li>{/if}
            </ul>          
        </div>        
        <script type="text/javascript">
            {literal}
            $Jq(window).load(function(){
				attachJqueryTabs('cloudTabs');
            });
            {/literal}
        </script>
    {* ARTIST CLOUDS SECTION ENDS *}

	</div>
    {* ----------------------Right Side Content ends ---------------------- *}


	{* ----------------------Left Side Content Starts ---------------------- *}
	<div class="clsMusicIndexLeft">

		{* ----------------------Featured playlist section Starts ---------------------- *}
		{if $myobj->isShowPageBlock('block_feartured_musiclist')}
			{$myobj->setTemplateFolder('general/', 'music')}
			{include file="box.tpl" opt="playlist_top"}
				<div class="clsFeaturedPlaylistContainer">
					<h3>{$featured_list_title}</h3>
					<div class="clsplayerContainer">
                    <div class="clsPlayerPreLoaderContainer" id="indexMusicPlayerLoader">
                        <div class="clsPlayerPreLoader"></div>
                    </div>
					<div class="clsAudioPlayer" id="indexMusicPlayer" style="display:none;">
                        {** @param string $div_id
                         * @param string $music_player_id
                         * @param integer $width
                         * @param integer $height
                         * @param string $auto_play
                         * @param boolean $hidden
                         * @param boolean $playlist_auto_play
                         * @param boolean $javascript_enabled *}
                        {$myobj->populatePlayerWithPlaylist($music_fields)}
					</div>
					</div>
				</div>
			{$myobj->setTemplateFolder('general/', 'music')}
			{include file="box.tpl" opt="playlist_bottom"}
		{/if}
		{* ----------------------Featured playlist section ends ---------------------- *}

		{* ----------------------Featured content glider Content Starts ---------------------- *}
		{if $featured_content_module_enabled eq 'true'}
			{if $myobj->isShowPageBlock('block_feartured_content_glider')}
				{$myobj->setTemplateFolder('general/', 'music')}
		        {include file="indexFeaturedContentGlider.tpl"}
		    {/if}
		{/if}
		{* ----------------------Featured content glider Content ends ---------------------- *}

		{* ----------------------Hidden Player starts ---------------------- *}
		{$myobj->populateHiddenPlayer()}
		{* ----------------------Hidden Player ends ---------------------- *}

		{* ----------------------Audio carosel section Starts ---------------------- *}
		{if $myobj->isShowPageBlock('sidebar_audio_block')}
    	    {$myobj->setTemplateFolder('general/', 'music')}
    		{include file="indexAudioBlockHead.tpl"}
	    {/if}
		{* ----------------------Audio carosel section ends ---------------------- *}

		{* ----------------------Featured Albums Content Starts ---------------------- *}
	    {if $myobj->isShowPageBlock('block_featured_albums')}
    	    {$myobj->setTemplateFolder('general/', 'music')}
    		{include file="indexFeaturedAlbumsHead.tpl"}
	    {/if}
		{* ----------------------Featured Albums Content ends ---------------------- *}
        
        {* ----------------------Top chart Content Starts ---------------------- *}
    	{if $myobj->isShowPageBlock('sidebar_topchart_block')}
        	{$myobj->setTemplateFolder('general/', 'music')}
	    	{include file="indexTopChartHead.tpl"}
    	{/if}
		{* ----------------------Top chart Content ends ---------------------- *}

		{* ----------------------Popular Playlist Content Starts ---------------------- *}
	    {if $myobj->isShowPageBlock('block_popular_playlist')}
    	    {$myobj->setTemplateFolder('general/', 'music')}
    		{include file="indexPopularPlaylistHead.tpl"}
	    {/if}
		{* ----------------------Popular Playlist Content ends ---------------------- *}
        
        {* BANNER SECTION STARTS *}
        <div class="cls468pxBanner">
            <div>{php}global $CFG; getAdvertisement('bottom_banner_468x60'){/php}</div>
        </div>
        {* BANNER SECTION ENDS *}

    </div>
    {* ----------------------Left Side Content ends ---------------------- *}
</div>