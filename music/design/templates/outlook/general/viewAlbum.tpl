<div id="selViewAlbum">
{$myobj->setTemplateFolder('general/','music')}
	{include file='information.tpl'}
	<!-- Multi confirmation box -->
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
				<p id="confirmMessage"></p>
			<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
				<table summary="{$LANG.viewalbumlist_confirm_tbl_summary}">
					<tr>
						<td>
							<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
							&nbsp;
							<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
							<input type="hidden" name="music_id" id="music_id" />
							<input type="hidden" name="album_id" id="album_id" />
							<input type="hidden" name="action" id="action" />
							{* $myobj->populateHidden($myobj->hidden_arr) *}
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div id="selMsgCartSuccess" class="clsPopupConfirmation" style="display:none;">
          <p id="selCartAlertSuccess"></p>
          <form name="msgCartFormSuccess" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
            <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_option_ok}"
            tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
          </form>
        </div>
	<div class="clsViewPlaylistLeftContent">
    {if $myobj->isShowPageBlock('viewAlbum_information_block')}
    {$myobj->setTemplateFolder('general/', 'music')}
    {include file="box.tpl" opt="sidebar_top"}
		<div class="clsStatisticsContainer">
			<h3 class="clsH3Heading">{$viewAlbumInformation.album_title}</h3>
				<div class="clsOverflow">
					<div class="clsAlbumLeftImage">
						{if $viewAlbumInformation.music_path != ''}
						<div class="clsLargeThumbImageBackground clsNoLink clsMarginTop10">
						  <p class="ClsImageContainer ClsImageBorder1 Cls132x88">
								<img src="{$viewAlbumInformation.music_path}"  title="{$viewAlbumInformation.music_title}" alt="{$viewAlbumInformation.music_title|truncate:5}" {$myobj->DISP_IMAGE(134, 90, $viewAlbumInformation.thumb_width, $viewAlbumInformation.thumb_height)}/>
						  </p>
						</div>
						{else}
						<div class="clsLargeThumbImageBackground clsNoLink clsMarginTop10">
						  <div class="ClsImageContainer ClsImageBorder1 Cls132x88">
							   <img width="132" height="88" src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" title="{$viewAlbumInformation.music_title}" alt="{$viewAlbumInformation.music_title|truncate:5}"/>
						  </div>
						</div>
						{/if}
					</div>
					<div class="clsAlbumRightCart">
						<div class="clsAlbumStatisticsTable">
							<table>
								<tr>
									<td class="clsLabel"><span>{$LANG.viewalbumlist_plays_label}</span>
									:&nbsp;{$myobj->getViewAlbumPlaysTotal($viewAlbumInformation.music_album_id)}</td>
								</tr>
								<tr>
									<td class="clsLabel"><span>{$LANG.viewalbumlist_tracks_label}</span>
									:&nbsp;{$myobj->getViewAlbumSongTotal($viewAlbumInformation.music_album_id)}</td>
								</tr>
								{if $myobj->isShowPageBlock('viewAlbum_tags_block')}
								<tr>
									<td class="clsAlbumTags">
									<p>{$LANG.viewalbumlist_artist_label}
									{assign var='i' value='1'}
									:{foreach key=musicKey item=musicValue from=$displayViewAlbum.row}
									{if $myobj->getArtistLink($musicValue.music_artist, true)}
									   {$myobj->getArtistLink($musicValue.music_artist, true)}
									   {if $lastData != $i}, {/if}
									{/if}
									{assign var='i' value=$i+1}
									{/foreach}</p>
									</td>
								</tr>
								{/if}
								{if $viewAlbumInformation.album_for_sale=='Yes'}
								<tr>
									<td><p class="clsMusicPriceContainer clsBorderRightMusicPrice">{$LANG.common_album_price} <span>{$CFG.currency}{$viewAlbumInformation.album_price}</span></p>
										<div class="clsAddToCartContainer">
											{if $viewAlbumInformation.user_id != $CFG.user.user_id and isUserAlbumPurchased($viewAlbumInformation.music_album_id) and isMember()}
												<p class="clsStrikeAddToCart"><a href="javascript:void(0)" class="clsStrikeAddToCart clsPhotoVideoEditLinks" title="{$LANG.musiclist_purchased}">{$LANG.musiclist_add_to_cart}</a></p>
											{elseif $viewAlbumInformation.user_id != $CFG.user.user_id and !isUserAlbumPurchased($viewAlbumInformation.music_album_id) and isMember()}
												<p class="clsAddToCart"><a href="javascript:void(0)" onClick="updateAlbumCartCount('{$myobj->getFormField('album_id')}')" title="{$LANG.musiclist_add_to_cart}">{$LANG.musiclist_add_to_cart}</a></p>
											{elseif !isMember()}
												<p class="clsAddToCart"><a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_add_cart_err_msg}','{$myobj->is_not_member_url}');return false;">{$LANG.musiclist_add_to_cart}</a></p>
											{/if}
										</div>
									</td>
								</tr>
								{/if}
							 </table>
						</div>
					</div>

				</div>
		</div>
	    {if $myobj->isShowPageBlock('viewAlbum_tags_block')}
			<div class="clsTagsTable">
					<table>
						<tr>
							<td class="clsLabel"><span>{$LANG.viewalbumlist_tags_label}</span></td>
							<td>: &nbsp; {foreach key=musicKey item=musicValue from=$displayViewAlbum.row}
							{$myobj->getMusicTagsLinks($musicValue.music_tags, 2)}  {/foreach}</td>
						</tr>
					</table>
			</div>
			<!--<div class="clsPlaylistDescriptionBox">
					<p><strong>{$LANG.viewalbumlist_artist_label}</strong></p>
					<p>{$myobj->getArtistLink($musicValue.music_artist, true)}</p>
			</div>-->
		{/if}
		<p id="anchor_id"></p>
        {$myobj->setTemplateFolder('general/', 'music')}
		{include file="box.tpl" opt="sidebar_bottom"}
	{/if}
	</div>

		{* STATISTICS SECTION ENDS *}
        </div>

		<!-- PLAYLIST INFORMATION BLOCK END-->
	<!-- PLAYLIST SONG LIST BLOCK END -->
    <div class="clsViewPlaylistRightContent clsViewPlayListPageContainer">
    <!-- ALBUM SONG LIST BLOCK START -->
          {if $myobj->isShowPageBlock('album_songlist_block')}
            {* TRACK LIST SECTION STARTS *}
				{$myobj->setTemplateFolder('general/', 'music')}
                {include file="box.tpl" opt="audioindex_top"}
                <div class="clsIndexAudioHeading">
                <h3 class="clsH3Heading">
                    {$LANG.viewAlbum_title}
                </h3>
                <!--<div id="albumSongs_Head" class="clsAudioCarouselPaging"  style="display:none" >
                </div>-->
                </div>
                {$myobj->populatePlaylist()} 
                <div id="albumInSongList">
                </div>
                <div  id="loaderMusics" style="display:none">
            	<div class="clsLoader">
                <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/loader.gif" alt="{$LANG.viewAlbum_loading}"/>{$LANG.viewAlbum_loading}
          		</div>
            	</div>
                {literal}
                    <script language="javascript" type="text/javascript">
                    function redirect(url)
                        {
                            window.location = url;
                        }
                    var relatedUrl="{/literal}{$myobj->relatedUrl}{literal}";
                    musicAlbumAjaxPaging('?ajax_page=true&page=pagenation&album_id={/literal}{$viewAlbumInformation.music_album_id}{literal}&user_id={/literal}{$myobj->getFormField('user_id')}{literal}', '');
                    </script>
                {/literal}
                {$myobj->setTemplateFolder('general/', 'music')}
                    {include file="box.tpl" opt="audioindex_bottom"}
            {* TRACK LIST SECTION STARTS *}
          {/if}
        <!-- ALBUM SONG LIST BLOCK END -->
    </div>
</div>

