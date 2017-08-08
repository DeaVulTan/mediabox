<div id="selViewLyrics">
    <!-- information div -->
	{$myobj->setTemplateFolder('general/','music')}
    	{include file='information.tpl'}
	 <!-- Multi confirmation box -->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
		  <table summary="{$LANG.viewplaylist_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
						&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
					  <input type="hidden" name="song_id" id="song_id" />
                        <input type="hidden" name="playlist_id" id="playlist_id" />
						<input type="hidden" name="action" id="action" />

						{* $myobj->populateHidden($myobj->hidden_arr) *}
					</td>
				</tr>
		  </table>
		</form>
	</div>
    <!-- confirmation box-->
    <div class="clsViewPlaylistLeftContent clsViewPlaylistRightBlock">
    <!-- PLAYLIST INFORMATION BLOCK START-->
    {if $myobj->isShowPageBlock('playlist_information_block')}

        {* INFORMATION SECTION STARTS *}
        	{$myobj->setTemplateFolder('general/', 'music')}
        	{include file="box.tpl" opt="box_top"}
            <div class="clsOverflow">
            	<div class="clsInformationLeft">
                <div class="clsMultipleImage" title="{$myobj->page_title}">
                        {if $playlistInformation.getPlaylistImageDetail.total_record gt 0}
                            {foreach key=playlistImageDetailKey item=playlistImageDetailValue from=$playlistInformation.getPlaylistImageDetail.row}
                               <table><tr><td><img src="{$playlistImageDetailValue.playlist_path}"/></td></tr></table>
                            {/foreach}
                            {if $playlistInformation.getPlaylistImageDetail.total_record lt 4}
                                {section name=foo start=0 loop=$playlistInformation.getPlaylistImageDetail.noimageCount step=1}
                                    <table><tr><td><img  width="65" height="44" src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_S.jpg" /></td></tr></table>
                                {/section}
                            {/if}
                        {else}
                            <div class="clsSingleImage"><img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" /></div>
                        {/if}
                </div>
                </div>
                <div class="clsInformationRight">
                    <p class="clsInformationTitle">{$myobj->page_title}</p>
                    <p class="clsByName">{$LANG.viewplaylist_post_by_label}: <a href="{$playlistInformation.playlist_owner_url}" title="{$playlistInformation.user_name}" alt="{$playlistInformation.user_name}">{$playlistInformation.user_name}</a></p>
                    <div class="clsInformationRating">
                        {* DISPLAYING RATING FORM BEGINS*}
						{if $playlistInformation.total_tracks gt 0}
                            {if $playlistInformation.allow_ratings == 'Yes'}
                                <div id="ratingForm">
                                    <p class="clsRateThisHd">{$LANG.viewplaylist_rate_this_label}:  </p>
                                    {assign var=tooltip value=""}
                                    {if !isLoggedIn()}
                                    {assign var=tooltip value=$LANG.viewplaylist_login_message}                               
                                    {elseif !(isMember() and $playlistInformation.rankUsersRayzz)}
                                    {assign var=tooltip value=$LANG.viewplaylist_rate_yourself}
                                    {/if}
                                    {if !isLoggedIn()}
                                    	{$myobj->populateMusicRatingImages($playlistInformation.rating, 'player',$LANG.viewplaylist_login_message, $myobj->is_not_member_url, 'music')}
                                    {else}
                                        <div id="selRatingPlaylist">
                                            {if isMember() and $playlistInformation.rankUsersRayzz}
                                                {if $playlistInformation.rating}
                                                    {$myobj->populateRatingImagesForAjax($playlistInformation.rating, 'audio')}
                                                {else}
                                                    {$myobj->populateRatingImagesForAjax($playlistInformation.rating, 'audio')}
                                                {/if}
                                            {else}
                                            	{$myobj->populateMusicRatingImages($playlistInformation.rating, 'player', $LANG.viewplaylist_rate_yourself, '#', 'music')}
                                            {/if}
                                            <span> ({$myobj->getFormField('rating_count')} {$LANG.viewplaylist_rating})</span>
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
                        {/if}
                     </div>
                </div>
             </div>
        	{$myobj->setTemplateFolder('general/', 'music')}
        	{include file="box.tpl" opt="box_bottom"}
        {* INFORMATION SECTION ENDS *}
		
        {* STATISTICS SECTION STARTS *}
       	    {$myobj->setTemplateFolder('general/', 'music')}	
        	{include file="box.tpl" opt="sidebar_top"}
            	<div class="clsStatisticsContainer">
                    <h3 class="clsH3Heading">{$LANG.viewplaylist_statistics_label}</h3>
                    <div class="clsOverflow clsStatisticsTable">
                        <div class="clsStatisticsLeftLinks">
                        	<table>
                                <tr><td class="clsLabel"><span>{$LANG.viewplaylist_plays_label}</span></td> <td>: {$playlistInformation.total_palys}</td></tr>
                                <tr><td class="clsLabel"><span>{$LANG.viewplaylist_views_label}</span></td> <td>: {$playlistInformation.total_views}</td></tr>
                                <tr><td class="clsLabel"><span>{$LANG.viewplaylist_create_date_label}</span></td><td>: {$playlistInformation.date_added}</td></tr>
                            </table>
                        </div>
                        <div class="clsStatisticsRightLinks">
                        	<table>
                                <tr><td class="clsLabel"><span>{$LANG.viewplaylist_last_played_label}</span></td> <td>: {$playlistInformation.last_viewed_date}</td></tr>
                                <tr><td class="clsLabel"><span>{$LANG.viewplaylist_tracks_label}</span></td> <td>: {$playlistInformation.total_tracks} {if $playlistInformation.private_song gt 0}({$playlistInformation.private_song} {$LANG.viewplaylist_private_label}){/if}</td></tr>
                                <tr><td class="clsLabel"><span>{$LANG.viewplaylist_comments_label}</span></td> <td>: {$playlistInformation.total_comments}</td></tr>
                            </table>
                        </div>
                    </div>
                    <div class="clsTagsTable">
                        <table>
                            <tr>
                                <td class="clsLabel"><span>{$LANG.viewplaylist_tags_label}</span></td>
                                <td>: {$myobj->getTagsLinkForPlaylist($playlistInformation.playlist_tags,3,$playlistInformation.playlist_id)}</td>
                            </tr>
                        </table>
                    </div>
                    {if $playlistInformation.allow_embed == 'Yes' && $playlistInformation.total_tracks gt 0}
                        <div class="clsUrlTextBox clsPlaylistUrlTextBox">
                            <span>{$LANG.viewplaylist_url_label} </span>
                            <input type="text" value="{$myobj->embeded_code}"
                            onclick="this.select()" onfocus="this.select()" readonly="" id="playlist_url" name="playlist_url" class=""/>
                        </div>
                    {/if}
                    <div class="clsPlaylistDescriptionBox">
                            <p><strong>{$LANG.viewplaylist_description_label}</strong> </p>
                            <p>{$playlistInformation.playlist_description}</p>
                    </div>
                </div>
       		 {$myobj->setTemplateFolder('general/', 'music')}
      	  	{include file="box.tpl" opt="sidebar_bottom"}
        {* STATISTICS SECTION ENDS *}
    {/if}
    <!-- PLAYLIST INFORMATION BLOCK END-->
    
    
	<!-- PLAYLIST FEATURES BLOCK STARTS -->
    {if $myobj->isShowPageBlock('playlist_features_block')}
        {* Share, favourites, featured section starts *}
        <div class="clsOverflow clsMoreShareOptions">
            <ul>
                <li class="clsMusicShare">
                    <a class="shareaudio" onclick="showShareDiv('{$myobj->shareUrl}')"><span>{$LANG.viewplaylist_share_musicplaylist_label}</span></a>
                </li>
                {if isMember()}                                        
                <li class="clsMusicFeatured" id='unfeatured' {if !$myobj->chkPlaylistFeatured()} style="display:none" {/if}>
                    <a class="featured"  href="javascript:void(0);" onclick="ajaxUpdatePlaylist('?ajax_page=true&amp;page=featured&playlist_id={$playlistInformation.playlist_id}&featured=0', 'unfeatured')"><span>{$LANG.viewplaylist_featured_label}</span></a>
                </li>
                <li class="clsMusicFeatured" id="featured" {if $myobj->chkPlaylistFeatured()} style="display:none" {/if}>
                    <a class="feature" href="javascript:void(0);" onclick="ajaxUpdatePlaylist('?ajax_page=true&amp;page=featured&playlist_id={$playlistInformation.playlist_id}&featured=1', 'featured')"><span>{$LANG.viewplaylist_feature_label}</span></a>
                </li>
                <li  class="clsMusicFeatured" id="featured_saving" style="display:none">
                   <a class="featured"><span>{$LANG.viewplaylist_saving_label}</span></a>
                </li>
                <li class="clsMusicfavorite" id='favorite' {if $myobj->chkPlaylistFavorite()} style="display:none" {/if}}>
                   <a class="favorites" onclick="ajaxUpdatePlaylist('?ajax_page=true&amp;page=favorite&playlist_id={$playlistInformation.playlist_id}&favorite=1', 'favorite')"> <span>{$LANG.viewplaylist_favorites_label}</span></a>
                </li>
                <li  class="clsMusicfavorite" id="unfavorite" {if !$myobj->chkPlaylistFavorite()} style="display:none" {/if}}>
                   <a class="favorited" onclick="ajaxUpdatePlaylist('?ajax_page=true&amp;page=favorite&playlist_id={$playlistInformation.playlist_id}&favorite=0', 'unfavorite')"><span>{$LANG.viewplaylist_favorited_label}</span></a>
                </li>
                <li  class="clsMusicfavorite" id="favorite_saving" style="display:none">
                   <a class="favorited"><span>{$LANG.viewplaylist_saving_label}</span></a>
                </li>
                {else}
                <li id="selHeaderFeatured" class="clsMusicFeatured">
                	<a class="feature" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('{$LANG.playlist_login_featured_err_msg}','{$myobj->is_not_member_url}');return false;"><span>{$LANG.viewplaylist_feature_label}</span></a>                    
                </li>
                <li id='favorite' class="clsMusicfavorite">
                    <a class="favorite" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('{$LANG.playlist_login_favorite_err_msg}','{$myobj->is_not_member_url}');return false;"><span>{$LANG.viewplaylist_favorites_label}</span></a>
                </li>
                {/if}
            </ul>
        </div>
        <div id="shareDiv" class="clsPopupConfirmation" style="display:none">
            <br />&nbsp;
        </div>
        {* Share, favourites, featured section ends *}
  	{/if}
	<!-- PLAYLIST FEATURES BLOCK ENDS -->

    <!-- PLAYLIST COMMENT BLOCK START -->
    {if $myobj->isShowPageBlock('playlist_comments_block')}    
    
    {$myobj->setTemplateFolder('general/', 'music')}
    {include file="box.tpl" opt="sidebar_top"}
    <div class="clsAudioCommentsContainer clsSideBarComments">
    	
        {* POST COMMENTS SECTION STARTS *}
    	<div class="clsCommentsHeadingContainer">
        	<h3 class="clsH3Heading">{$LANG.viewplaylist_comments_label}</h3>
            <div class="clsComments">
            	{if  $playlistInformation.allow_comments == 'Kinda' OR $playlistInformation.allow_comments == 'Yes'}
                	
                    {if isMember()}
                    <div class="clsOverflow">
                    	<span id="selViewPostComment" class="clsViewPostComment">
                        	<a href="javascript:void(0);" title="{$LANG.viewplaylist_post_comments_label}" id="add_comment" onclick="toggleMusicPostCommentOption(); return false;">{$LANG.viewplaylist_post_comments_label}</a>
                        </span>
                    </div>
                    {include file="addComments.tpl"}
                    {else}
                    <div class="clsOverflow">
                        <span id="selViewPostComment" class="clsViewPostComment">
                            <a title="{$LANG.viewplaylist_post_comments_label}" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_comment_post_err_msg}','{$myobj->commentUrl}');return false;">
                            {$LANG.viewplaylist_post_comments_label}
                            </a>
                        </span>
                    </div>
                    {/if}
                {/if}
            </div>
        </div>
        {* POST COMMENTS SECTION ENDS *}
        
        
        
                            {if  $playlistInformation.allow_comments == 'Kinda' OR $playlistInformation.allow_comments == 'Yes'}
                                {if isMember()}
								<div class="clsOverflow">
                                    <p class="clsApprovalRequired" id="selViewPostComment">
                                        {if $playlistInformation.allow_comments == 'Kinda' and $myobj->getFormField('user_id')!=$CFG.user.user_id}({$LANG.approval}){/if}
                                    </p>
									</div>
                                {else}
								<div class="clsOverflow">
                                    <p class="clsApprovalRequired" id="selViewPostComment">
                                        {if $playlistInformation.allow_comments == 'Kinda'}({$LANG.approval}){/if}
                                    </p>
									</div>
                                {/if}
                            {/if}
                    {$myobj->populateCommentOptionsPlaylist()}
                    <div id="selMsgSuccess" style="display:none">
                        <p id="kindaSelMsgSuccess"></p>
                    </div>
                    <div id="selCommentBlock" class="clsViewVideoDetailsContent">
                        {$myobj->populateCommentOfThisPlaylist()}
                    </div>
                </div>
        {$myobj->setTemplateFolder('general/', 'music')}
        	{include file="box.tpl" opt="sidebar_bottom"}
        {* COMMENTS SECTION ENDS *}
    {/if}
    <!-- PLAYLIST COMMENT BLOCK END -->

    </div>

    <div class="clsViewPlaylistRightContent clsViewPlaylistLeftBlock">

{* ----------------------Playlist Player section Starts ---------------------- *}
	{if $myobj->isShowPageBlock('block_playlist_player')}
        {$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="playlist_top"}
            <div class="clsFeaturedPlaylistContainer">
            	<h3>{$myobj->page_title}</h3>
                <div class="clsAudioPlayer clsPlaylistPlayer">
					{$myobj->populatePlayerWithPlaylist($music_fields)}
                </div>
            </div>
        {$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="playlist_bottom"}
	{/if}
{* ----------------------Playlist Player section ends ---------------------- *}

    
    <!-- PLAYLIST SONG LIST BLOCK START -->
      {if $myobj->isShowPageBlock('playlist_songlist_block')}
        {* TRACK LIST SECTION STARTS *}
    	    {$myobj->setTemplateFolder('general/', 'music')}
        	{include file="box.tpl" opt="audioindex_top"}
            <div class="clsIndexAudioHeading">
            <h3 class="clsH3Heading">
                {$LANG.viewplaylist_tracks_list_label}
            </h3>
            <!--<div id="playlistSongs_Head" class="clsAudioCarouselPaging"  style="display:none" >
            </div>-->
            </div>
            {$myobj->populatePlaylist()}
            <div id="playlistInSongList">
            </div>
            <div  id="loaderMusics" style="display:none">
            	<div class="clsLoader">
                <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/loader.gif" alt="{$LANG.viewplaylist_loading}"/>{$LANG.viewplaylist_loading}
          		</div>
            </div>
            {literal}
                <script language="javascript" type="text/javascript">
                function redirect(url)
                    {
                        window.location = url;
                    }
				var relatedUrl="{/literal}{$myobj->relatedUrl}{literal}";
                musicPlaylistAjaxPaging('?ajax_page=true&page=pagenation&playlist_id={/literal}{$playlistInformation.playlist_id}{literal}&user_id={/literal}{$myobj->getFormField('user_id')}{literal}', '');
			    </script>
            {/literal}
            {$myobj->setTemplateFolder('general/', 'music')}
        		{include file="box.tpl" opt="audioindex_bottom"}
        {* TRACK LIST SECTION STARTS *}
      {/if}
    <!-- PLAYLIST SONG LIST BLOCK END -->
    </div>
<script type="text/javascript">
	{literal}
	function toggleMusicPostCommentOption(){
		$Jq("#selEditMainComments").toggle('slow');
	}
	{/literal}
</script>
</div>