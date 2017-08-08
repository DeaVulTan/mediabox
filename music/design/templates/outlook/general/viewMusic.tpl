<div class="clsViewAudioPage">
	<script type="text/javascript" language="javascript">
		var block_arr= new Array('selMsgCartSuccess');
	</script>

	{$myobj->setTemplateFolder('general/','music')}
	{include file='information.tpl'}

    {if $myobj->isShowPageBlock('confirmation_flagged_form')}
    {* flagged music confirmation form *}
    <div id="flaggedForm">
        <p>{$LANG.viewmusic_flagged_msg}</p>
        <p><a href="{$myobj->flaggedMusicUrl}">{$LANG.viewmusic_flagged}</a></p>
    </div>
    {* flagged music confirmation form ends *}
    {elseif $myobj->isTrimmedMusic()}
    {* TRIMMED MUSIC MESSAGE BLOCK STARTS *}
    <div class="clsTrimmedMusic">
        <h4>{$myobj->trimmendMessage}</h4>
    </div>
    {* TRIMMED MUSIC MESSAGE BLOCK ENDS *}
    {/if}

    {if $myobj->isShowPageBlock('confirmation_adult_form')}
    {* Adult music confirmation form *}
    <div id="selAdultUserForm">
        <p>{$myobj->replaceAdultText($LANG.confirmation_alert_text)}</p>
        <p><a href="{$myobj->acceptAdultMusicUrl}">{$LANG.viewmusic_accept}</a>&nbsp;&nbsp;
        <a href="{$myobj->acceptThisAdultMusicUrl}">{$LANG.viewmusic_accept_this_page_only}</a>&nbsp;&nbsp;
        <a href="{$myobj->rejectAdultMusicUrl}">{$LANG.viewmusic_reject}</a>&nbsp;&nbsp;
        <a href="{$myobj->rejectThisAdultMusicUrl}">{$LANG.viewmusic_reject_this_page_only}</a> </p>
    </div>
    {* Adult music confirmation form ends *}
    {/if}

	<div class="clsOverflow">
		{* VIEW MUSIC PAGE LEFT SIDE SECTION STARTS *}
		<div class="clsViewAudioLeft">
    		{* MUSIC DETAILS SECTION STARTS *}
			{if $myobj->isShowPageBlock('block_viewmusic_musicdetails')}

			<div id="selMsgConfirmWindow" class="clsMsgConfirmWindow" style="display:none;">
				<h3 id="confirmationMsg"></h3>
				<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			      	<input type="button" class="clsSubmitButton" name="confirm_action" id="confirm_action" onclick="deleteCommandOrReply();" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
			      	&nbsp;
			      	<input type="button" class="clsCancelButton" name="cancel" id="cancel" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks();" />
			      	<input type="hidden" name="comment_id" id="comment_id" />
			      	<input type="hidden" name="maincomment_id" id="maincomment_id" />
			      	<input type="hidden" name="commentorreply" id="commentorreply" />
				</form>
			</div>

			<!-- summary of the music start-->
            {$myobj->setTemplateFolder('general/', 'music')}
            {include file="box.tpl" opt="summary_top"}
			<div class="clsMusicSummary">
            	{if $myobj->music_caption}
				<p class="clsSummaryHead">
					{$LANG.viewmusic_summary_music}:
				</p>
				<div class="clsSummaryDescContainer">
                <p class="clsSummaryDesc" id="listenMusicSummary">
                    {if $myobj->music_caption}{$myobj->music_caption}{else}-{/if}
                </p>
				</div>
                {else}
                <p class="clsSummaryHead">
					{$LANG.viewmusic_no_summary}
				</p>
                {/if}
                <div class="clsSummaryCategory"><p class="clsSummaryGenere">
                    {$LANG.music_genre_in}
                    <span>
                    	<a href="{$myobj->musicList_category_url}">{$myobj->statistics_music_genre}</a>
                    </span>
                </p></div>
                <p class="clsSummaryTags">
                    {$LANG.viewmusic_music_tags}:
                    <span>
                        {$myobj->getMusicTagsLinks($myobj->getFormField('music_tags'),3)}
                    </span>
                </p>
            </div>
			<div class="clsMusicUserDetail clsOverflow">
				<div class="clsMusicUserDetailImage">
					<a href="{$myobj->music_user_details.profile_url}" class="ClsImageContainer ClsImageBorder1 Cls45x45"><img src="{$myobj->music_user_details.icon.t_url}" title="{$myobj->music_user_details.user_name}" alt="{$myobj->music_user_details.user_name}" {$myobj->DISP_IMAGE(45, 45, $myobj->music_user_details.icon.m_width, $myobj->music_user_details.icon.m_height)} /></a>
				</div>
				<div class="clsMusicUserDetailData">
					<ul class="clsOverflow">
                        <li>
                            <p class="clsViewMusicUsername"><span>{$LANG.viewmusic_by}</span><a href="{$myobj->music_user_details.profile_url}">{$myobj->music_user_details.user_name}</a></p>
                        </li>
                        <li>
                            <p class="clsViewMusicDateAdded"><span>{$LANG.on_link}</span> {$myobj->getFormField('date_added')}</p>
                        </li>
					</ul>
					<p class="clsViewMusicByuser"><span>{$LANG.viewmusic_user_music}: </span><a href="{$myobj->music_user_details.total_musics_url}">{$myobj->music_user_details.total_musics}</a></p>
				{if $myobj->getFormField('user_id') == $CFG.user.user_id and isMember()}
				<p class="clsEditThisAudio"><a href="{$myobj->edit_music_url}">{$LANG.viewmusic_edit_music}</a></p>
				{/if}
				</div>
                
			</div>
			{$myobj->setTemplateFolder('general/', 'music')}
			{include file="box.tpl" opt="summary_bottom"}
            <!-- summary of the music end-->

			{if $myobj->isShowPageBlock('block_view_music_main')}
            <!-- playlist, flag, addblog, lyrics  design starts-->
            {$myobj->setTemplateFolder('general/', 'music')}
            {include file="box.tpl" opt="viewaudio_top"}
			<div class="clsCommonTabPopup">
            <div class="clsAudioLinksContainer">
            	<div class="clsViewAudioLinks" id="listenMusicTabs">
                	<ul class="clsOverflow">
                        <li class="clsFirstLink"><a href="#listenMusicPlaylist"><span>{$LANG.viewmusic_playlist}</span></a></li>
                        <li><a href="#listenMusicFlag"><span>{$LANG.viewmusic_flag}</span></a></li>
                        {if $myobj->getFormField('allow_lyrics') == 'Yes'}
                        <li><a href="#listenMusicBlog"><span>{$LANG.viewmusic_add_blog}</span></a></li>
                        <li class="clsLastLink"><a href="#listenMusicLyrics"><span>{$LANG.viewmusic_lyrics}</span></a></li>
                        {else}
                        <li class="clsLastLink"><a href="#listenMusicBlog"><span>{$LANG.viewmusic_add_blog}</span></a></li>
                        {/if}
		            </ul>
                    {$myobj->populatePlaylist()}
                    {$myobj->populateFlagContent()}
                    {$myobj->populateBlogContent()}
                    {if $myobj->getFormField('allow_lyrics') == 'Yes'}
                    {$myobj->populateLyricsContent()}
                    {/if}
        		</div>
                <script type="text/javascript">$Jq("#listenMusicTabs").tabs();</script>
            </div>
			</div>
            {$myobj->setTemplateFolder('general/', 'music')}
            {include file="box.tpl" opt="viewaudio_bottom"}
            <!-- playlist, flag, addblog, lyrics  design ends-->
            {/if}

            {* Added for the share and featured and favorite block *}
			<div class="clsOverflow clsMoreShareOptions">
				<ul>
                    <li id="selHeaderSharemusic" class="clsMusicShare">
                        <a class="shareaudio" onclick="showShareDiv('{$myobj->share_url}')">
                            <span>{$LANG.viewmusic_share_music|capitalize:true}</span>
                        </a>
                    </li>
                    {if $myobj->isMember}
                    <li class="clsMusicFeatured" id='unfeatured' {if !$myobj->featured.added} style="display:none"{/if}>
                        <a class="featured"  href="javascript:void(0);" onclick="getViewMusicMoreContent('Featured', 'remove');"><span>{$LANG.viewmusic_featured|capitalize:true}</span></a>
                    </li>
                    <li class="clsMusicFeatured" id="featured" {if $myobj->featured.added} style="display:none"{/if}>
                        <a class="feature" href="javascript:void(0);" onclick="getViewMusicMoreContent('Featured');"><span>{$LANG.viewmusic_feature|capitalize:true}</span></a>
                    </li>
                    {else}
                    	<li id="selHeaderFeatured" class="clsMusicFeatured"  ><a class="favorited" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_featured_err_msg}', '{$myobj->memberviewMusicUrl}')"><span>{$LANG.feature|capitalize:true}</span></a></li>
                	{/if}
                    <li  class="clsMusicFeatured" id="featured_saving" style="display:none">
                       <a class="featured"><span>{$LANG.viewmusic_saving}</span></a>
                    </li>
             		{if $myobj->isMember}
                    <li class="clsMusicfavorite" id='favorite' {if $myobj->favorite.added} style="display:none"{/if}>
                       <a class="favorites" onclick="getViewMusicMoreContent('Favorites');"> <span>{$LANG.viewmusic_favorites|capitalize:true}</span></a>
                    </li>
                    <li  class="clsMusicfavorite" id="unfavorite" {if !$myobj->favorite.added} style="display:none"{/if}>
                       <a class="favorited" onclick="getViewMusicMoreContent('Favorites', 'remove');"><span>{$LANG.viewmusic_favorited|capitalize:true}</span></a>
                    </li>
                    {else}
                    	<li id='favorite' class="clsMusicfavorite"><a class="favourites" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_favorite_err_msg}', '{$myobj->memberviewMusicUrl}')"><span>{$LANG.favorites|capitalize:true}</span></a></li>
                	{/if}

                  <li  class="clsMusicfavorite" id="favorite_saving" style="display:none">
                       <a class="favorited"><span>{$LANG.viewmusic_saving}</span></a>
                  </li>
                </ul>
            </div>
            <div id="shareDiv" class="clsPopupConfirmation" style="display:none">
                <br />&nbsp;
            </div>
			{* End of added for the share and featured and favorite block *}
			{/if}



        </div>
        {* VIEW MUSIC PAGE LEFT SIDE SECTION ENDS *}



		{if $CFG.admin.musics.download_option && $myobj->checkDownloadOption()}
        <div id="downloadFormat" style="display:none;">

            <div class="clsIndexAudioHeading">
                <h3>{$LANG.viewmusic_downloads_formats}</h3>
                <div class="clsHeadingClose">

                </div>
            </div>
            <div class="clsOverflow clsPopupContainer">
                <ul>
                <li><a href="{$myobj->musicDownloadUrl}">{$LANG.mp3} ({$myobj->getFormField('total_downloads')} {$LANG.viewmusic_downloads}) </a></li>
                <!--
                    commented this in version 1.1.4 for checking in detail the count
                    {if $CFG.admin.musics.save_original_file_to_download and $myobj->getFormField('music_ext')!='mp3'}
                        {$myobj->populateOriginalFormatDownloadLink()}
                    {/if}
                    {if $CFG.admin.musics.music_other_formats_enabled and !$myobj->getFormField('music_server_url')}
                        {$myobj->populateOtherFormatDownloadLink()}
                    {/if} -->
                </ul>
                <p class="clsDownloadNote">{$LANG.viewmusic_savetarget}</p>
            </div>

        </div>
        {/if}


      	{if $myobj->isShowPageBlock('block_view_music_player')}
        {* VIEW MUSIC PAGE RIGHT SIDE SECTION STARTS *}
            <div class="clsViewAudioRight">

                {* MUSIC DETAILS SECTION STARTS *}
      			{$myobj->setTemplateFolder('general/', 'music')}
                {include file="box.tpl" opt="playlist_top"}
                        <div class="clsFeaturedPlaylistContainer clsSinglePlayerContainer">
							<div class="clsOverflow">
                            <h3 class="clsFloatLeft">{$myobj->music_title}</h3>
                        	{* DISPLAYING RATING FORM BEGINS*}
                            <div class="clsFloatRight clsListenRating">
                            {if $myobj->chkAllowRating()}
                              <div id="ratingForm">
                               {assign var=tooltip value=""}
                               {if !isLoggedIn()}
                               {assign var=tooltip value=$LANG.viewmusic_login_message}
                               {elseif !(isMember() and $myobj->rankUsersRayzz)}
                               {assign var=tooltip value=$LANG.viewmusic_rate_yourself}
                               {/if}
                               {if !isLoggedIn()}
                                     {$myobj->populateMusicRatingImages($myobj->music_rating, 'player',$LANG.viewmusic_login_message, $myobj->memberviewMusicUrl, 'music')}
                               {else}
                                  <div id="selRatingMusic">
                                      {if isMember() and $myobj->rankUsersRayzz}
                                              {$myobj->populateRatingImagesForAjax($myobj->music_rating, 'audio')}
                                      {else}
                                          {$myobj->populateMusicRatingImages($myobj->music_rating, 'player', $LANG.viewmusic_rate_yourself, '#', 'music')}
                                      {/if}
                                     <span> ({$myobj->getFormField('rating_count')} {if $myobj->getFormField('rating_count') > 1}{$LANG.viewmusic_total_ratings}{else}{$LANG.viewmusic_total_rating}{/if})</span>
                                   </div>
                              {/if}
                              <script type="text/javascript">
							  {literal}
							  $Jq(document).ready(function(){
							    $Jq('#ratingLink').attr('title','{/literal}{$tooltip}{literal}');
							  	$Jq('#ratingLink').tooltip({
														track: true,
														delay: 0,
														showURL: false,
														showBody: " - ",
														extraClass: "clsToolTip",
														top: -10
													});
									});
								{/literal}
                              </script>
                              {* DISPLAYING RATING FORM ENDS*}
                            </div>
                          	{/if}
                            </div>
							</div>
                            <div class="clsPlayerContainer">
                              {*GENERATE SINGLE PLAYER*}
                              		{$myobj->populateSinglePlayer($music_fields)}
                              {*GENERATE SINGLE PLAYER*}
                            </div>
							<div class="clsPlayerEmbed">
								{$myobj->setTemplateFolder('general/', 'music')}
								{include file="box.tpl" opt="embed_top"}
								<div class="clsEmbedTop clsOverflow">
									<div class="clsEmbedCountDetails clsOverflow">
										<ul>
											<li>
												<span class="clsEmbedCountName">{$LANG.viewmusic_downloads_label}:</span>
												<span class="clsEmbedCountvalueLeft"><span class="clsEmbedCountvalueRight">{$myobj->getFormField('total_downloads')}</span></span>
											</li>
											<li>
												<span class="clsEmbedCountName">{$LANG.viewmusic_total_comments}:</span>
												<span class="clsEmbedCountvalueLeft"><span class="clsEmbedCountvalueRight">{$myobj->getFormField('total_comments')}</span></span>
											</li>
											<li>
												<span class="clsEmbedCountName">{$LANG.viewmusic_total_favourites}:</span>
												<span class="clsEmbedCountvalueLeft"><span class="clsEmbedCountvalueRight">{$myobj->getFormField('total_favorites')}</span></span>
											</li>
										</ul>
									</div>
									<div class="clsTrackDownload">
										<span class="clsPlayingTime">{$LANG.viewmusic_playing_time}: <span>{$myobj->getFormField('cur_mid_play_time')}</span></span>
                                        {if $CFG.admin.musics.download_option}
                                        <a id="anchor_music_download_block"></a>
										<!--music download <span class="clsDownloadTrackLeft"><span class="clsDownloadTrackRight"><a onclick="return Confirmation('downloadFormat', '', Array(), Array(), Array(), 50, 190, 'anchor_music_download_block')">{$LANG.viewmusic_download}</a></span></span>-->
                                        {/if}
									</div>
								</div>
								<div class="clsEmbedBottom clsOverflow">
									<p class="clsMusicurl">
										<input name="" type="text"  value="{$myobj->view_music_embed_url}" onfocus="this.select()" onclick="this.select()" readonly="readonly" />
									</p>
                                    {if $myobj->allow_embed=='Yes'}
									<p class="clsEmbedurl">
										<input name="" value="{$myobj->embeded_code}" type="text" onfocus="this.select()" onclick="this.select()"/>
									</p>
                                    {/if}
								</div>
								{$myobj->setTemplateFolder('general/', 'music')}
								{include file="box.tpl" opt="embed_bottom"}
							</div>
                        </div>
				{$myobj->setTemplateFolder('general/', 'music')}
				{include file="box.tpl" opt="playlist_bottom"}
                {* MUSIC DETAILS SECTION ENDS *}
       		{/if}


        </div>
        {* VIEW MUSIC PAGE RIGHT SIDE SECTION ENDS *}
    </div>

	{$myobj->setTemplateFolder('general/', 'music')}
	{include file="box.tpl" opt="viewaudiobottom_top"}
	<div class="clsOverflow">

        <div class="clsViewAudioComment">
            {* COMMENTS SECTION STARTS *}
            {if $myobj->isShowPageBlock('music_comments_block')}
            {$myobj->setTemplateFolder('general/', 'music')}
            {include file="box.tpl" opt="audioindex_top"}
            <div class="clsAudioCommentsContainer">
                <div class="clsCommentsHeadingContainer">
                    <div class="clsIndexAudioHeading"><h3>{$LANG.viewmusic_comments_label}&nbsp;(<span id="selMusicCommentsCount">{$myobj->getFormField('total_comments')}</span>)</h3></div>
                    <div class="clsComments">
                        {if  $myobj->getFormField('allow_comments') == 'Kinda' OR $myobj->getFormField('allow_comments') == 'Yes'}
                            {if isMember()}
							<div class="clsOverflow">
                                <span id="selViewPostComment" class="clsViewPostComment">
                                    <a href="#" title="{$LANG.viewmusic_post_comments_label}" id="add_comment" onclick="toggleMusicPostCommentOption(); return false;">{$LANG.viewmusic_post_comments_label}</a>
                              	</span>
								</div>
                              	{include file="addComments.tpl"}
                            {else}
							<div class="clsOverflow">
                                <span id="selViewPostComment" class="clsViewPostComment">
                                    <a title="{$LANG.viewmusic_post_comments_label}" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_comment_post_err_msg}','{$myobj->memberviewMusicUrl}');return false;">
                                        {$LANG.viewmusic_post_comments_label} {if $myobj->getFormField('allow_comments') == 'Kinda'}({$LANG.approval}){/if}
                                    </a>
                                </span>
								</div>
                            {/if}
                        {/if}
                    </div>
                </div>
                {if $myobj->getFormField('allow_comments') == 'Kinda' and $myobj->getFormField('user_id')!=$CFG.user.user_id}<div class="clsApprovalRequired">({$LANG.approval})</div>{/if}
                {$myobj->populateCommentOptionsMusic()}
                <div id="selMsgSuccess" style="display:none">
                    <p id="kindaSelMsgSuccess"></p>
                </div>
                <div id="deleteCommentSuccessMsgBlock" style="display:none" class="clsSuccessMessage">
                    <p id="deleteCommentSuccessMsg"></p>
                </div>
                <div id="selCommentBlock" class="clsViewVideoDetailsContent">
                    {$myobj->populateCommentOfThisMusic()}
                </div>
            </div>
            {$myobj->setTemplateFolder('general/', 'music')}
            {include file="box.tpl" opt="audioindex_bottom"}
            {/if}
            {* COMMENTS SECTION STARTS *}
        </div>


        <div class="clsViewAudioMoreVideo">
            {if $myobj->isShowPageBlock('block_view_music_more_musics')}
            {* More Music section Starts *}
            {$myobj->setTemplateFolder('general/', 'music')}
            {include file="box.tpl" opt="audioindex_top"}
            {assign var=more_music_limit value=15}
            <div class="clsIndexMoreAudioContainer">
                <div class="clsIndexAudioHeading clsOverflow">
                    <h3 class="clsViewaudioMoreMusicLeft">{$LANG.viewmusic_more_audios_label}</h3>
                    <div class="clsAudioListMenu clsViewaudioMoreMusicRight">
                        <ul>
                            <li id="selHeaderMusicUser">
                                    <a onclick="getRelatedMusic('user');"><span>{$LANG.viewmusic_user_label}</span></a>
                            </li>
                            <li id="selHeaderMusicRel">
                                    <a onclick="getRelatedMusic('tag')"><span>{$LANG.viewmusic_related_label}</span></a>
                            </li>
                            <li id="selHeaderMusicTop">
                                    <a onclick="getRelatedMusic('top')"><span>{$LANG.viewmusic_top_label}</span></a>
                            </li>
                            {*Checked the condition to disable the artist tab if artist feature is turned on*}
                            {if !$CFG.admin.musics.music_artist_feature}
                            <li id="selHeaderMusicArtist">
                                    <a onclick="getRelatedMusic('artist')"><span>{$LANG.viewmusic_artist_label}</span></a>
                            </li>
                            {/if}
                        </ul>
                    </div>
                    <div id="selNextPrev_top" class="clsAudioCarouselPaging">
                    </div>
                </div>

                <div class="clsSideCaroselContainer clsJQMoreMusic">
					<div class="clsDisplayNone" id="loaderMusics" align="center">
                        <div class="clsLoader">
                            <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/loader.gif" alt="{$LANG.viewmusic_loading}"/>{$LANG.viewmusic_loading}
                        </div>
                    </div>
                    <div  id="relatedMusicContent" >

					</div>

                </div>
            </div>
            <script type="text/javascript">
                var subMenuClassName1='clsActiveMoreMusics';
                var hoverElement1  = '.clsMoreMusicNav li';
                loadChangeClass(hoverElement1,subMenuClassName1);
                var relatedUrl="{$myobj->relatedUrl}";
                getRelatedMusic('tag');
            </script>
            {$myobj->setTemplateFolder('general/', 'music')}
            {include file="box.tpl" opt="audioindex_bottom"}
            {* More Music section ends *}
            {/if}


            {* People listened this song section Starts *}
            {if $myobj->isShowPageBlock('block_view_music_people_listened')}
            {$myobj->setTemplateFolder('general/', 'music')}
            {include file="box.tpl" opt="audioindex_top"}
            <div class="clsPepoleListingAudioContainer">
                <div class="clsIndexAudioHeading">
                    <h3>{$LANG.viewmusic_people_listened_heading}</h3>
                    <div id="people_listened_Head" class="clsAudioCarouselPaging"  >
                    </div>
                </div>
                <div class="clsSideCaroselContainer">
                    <div id="people_listened_content">
                    </div>
                    <div class="clsDisplayNone" id="loaderListenedMusics" align="center">
                        <img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/loader.gif" alt="{$LANG.viewmusic_loading}"/>{$LANG.viewmusic_loading}
                    </div>
                </div>
                <script type="text/javascript">
                    var subMenuClassName1='clsActiveMoreVideos';
                    var hoverElement1  = '.clsMoreMusicNav li';
                    loadChangeClass(hoverElement1,subMenuClassName1);
					var listenedUrl="{$myobj->relatedUrl}";
					getPeopleListenedMusic('');
                </script>
            </div>
            {$myobj->setTemplateFolder('general/', 'music')}
            {include file="box.tpl" opt="audioindex_bottom"}
            {/if}
            {* People listened this song section ends *}

		</div>


	</div>
	{$myobj->setTemplateFolder('general/', 'music')}
	{include file="box.tpl" opt="viewaudiobottom_bottom"}
</div>
{literal}
<script language="javascript" type="text/javascript">
	$Jq(document).ready(function(){
		$Jq('#listenMusicSummary').jScrollPane({showArrows:true, scrollbarWidth:15});
	});
	function toggleMusicPostCommentOption(){
		$Jq("#selEditMainComments").toggle('slow');
	}
</script>
{/literal}