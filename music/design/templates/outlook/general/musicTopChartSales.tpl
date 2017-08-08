{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audiocontent_top"}
    <div class="clsAudioContentHeadingContainer">
        <div class="clsAudioContentHeading">
            <h3>{$LANG.sidebar_topchart_label}</h3>
        </div>
        <div class="clsAudioContentLinks">
            <ul>
	            <li id="selHeaderMusicList"><a href="javascript:void(0);" onclick="loadChartType('{$CFG.site.url}music/musicTopChartSales.php?ajax_page=true&pg=topChartSongs', 'selMusicListContent', 'selHeaderMusicList');"><span>Songs</span></a></li>
	            <li id="selHeaderAlbumList"><a href="javascript:void(0);" onclick="loadChartType('{$CFG.site.url}music/musicTopChartSales.php?ajax_page=true&pg=topChartAlbums', 'selAlbumListContent', 'selHeaderAlbumList');"><span>Album</span></a></li>
	            <li id="selHeaderArtistList"><a href="javascript:void(0);" onclick="loadChartType('{$CFG.site.url}music/musicTopChartSales.php?ajax_page=true&pg=topChartArtists', 'selArtistListContent', 'selHeaderArtistList');"><span>Artist</span></a></li>
            </ul>
        </div>
    </div>
{* ----------------------Hidden Player starts ---------------------- *}
      {$myobj->populateHiddenPlayer()}
{* ----------------------Hidden Player ends ---------------------- *}
    <div id="selMusicListContent">
	{if $populateCarosulTopChartBlock_arr.record_count}
        <table class="clsCarouselTopChartList">
        	<tr>
        		<td><div class="clsDateStartEnd">{$date_started}</div></td>
        	</tr>
            {foreach key=musicKey item=musicValue from=$populateCarosulTopChartBlock_arr.row}
                <tr><td>

                <div class="clsCenterContent clsCenterContenWithMusicSale">
					 <div class="clsTopcartNumbers">
						<p class="clsListingNo">{$musicValue.current_position}</p>
						<p class="clsOptionalValus clsPhotoVideoEditLinks {$musicValue.css}" title="{$musicValue.tool_tip}">{$musicValue.position}</p>
					</div>
                    <div class="clsCenterContentImage">
                        <div class="clsThumbImageLink">
                            <div class="clsThumbImageBackground">
                                <a href="{$musicValue.title_url}" class="ClsImageContainer ClsImageBorder1 Cls76x50">
									{if $musicValue.music_image_src  != ''}
										<img src="{$musicValue.music_image_src}" {$musicValue.music_disp} title="{$musicValue.wordWrap_mb_ManualWithSpace_music_title}" />
									{else}
										<img   src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_M.jpg" title="{$musicValue.wordWrap_mb_ManualWithSpace_music_title}"/>
									{/if}
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="clsTopChartPlayer">
						<div class="clsPlayerIcon">
                              <a class="clsPlaySong" id="music_top_chart_play_music_icon_{$musicValue.record.music_id}" onClick="playSelectedSong({$musicValue.record.music_id}, 'music_top_chart')" href="javascript:void(0)"></a>
                              <a class="clsStopSong" id="music_top_chart_play_playing_music_icon_{$musicValue.record.music_id}" onClick="stopSong({$musicValue.record.music_id}, 'music_top_chart')" style="display:none" href="javascript:void(0)"></a>
                        </div>
                    </div>
					 <div class="clsMusicSaleOption">
                    {*ADDED THE ADD TO CART LINK*}
						{if $musicValue.sale}
							<p class="clsMusicPriceContainer">{$musicValue.music_price}</p>
	                        {if $musicValue.for_sale == 'Yes' and $musicValue.record.user_id!=$CFG.user.user_id and isUserPurchased($musicValue.record.music_id) and isMember()}
								<p id="add_cart_{$musicValue.record.music_id}" class="clsStrickedCart"><a href="javascript:void(0)" class="clsStrikeAddToCart clsPhotoVideoEditLinks" title="{$LANG.musiclist_purchased}">{$LANG.musiclist_add_to_cart}</a></p>
							{elseif $musicValue.for_sale == 'Yes' and $musicValue.record.user_id!=$CFG.user.user_id and !isUserPurchased($musicValue.record.music_id) and isMember()}
								<p id="add_cart_{$musicValue.record.music_id}" class="clsAddToCart"><a href="javascript:void(0)" onClick="updateMusicsCartCount('{$musicValue.record.music_id}')" title="{$LANG.musiclist_add_to_cart}">{$LANG.musiclist_add_to_cart}</a></p>
	                        {elseif !isMember()}
								<p id="add_cart_{$musicValue.record.music_id}" class="clsAddToCart"><a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_add_cart_err_msg}','{$myobj->getUrl('index','','','members','music')}');return false;">{$LANG.musiclist_add_to_cart}</a></p>
							{/if}
                        {/if}
                        {*ADDED THE ADD TO CART LINK*}
                    </div>
                    <div class="clsCenterContentDetiails">
                        <p class="clsName"><a href="{$musicValue.title_url}"  title="{$musicValue.wordWrap_mb_ManualWithSpace_music_title}">{$musicValue.wordWrap_mb_ManualWithSpace_music_title}</a></p>
                        <p class="clsType" title="{$musicValue.wordWrap_mb_ManualWithSpace_category_name}"><a href="{$musicValue.musiccategory_url}">{$musicValue.wordWrap_mb_ManualWithSpace_category_name}</a></p>
                        <p>{if $musicValue.record.total_count!='0' && $musicValue.record.total_count=='1'} {$LANG.sidebar_topchart_play_label}: {else} {$topchartlabel}:{/if} {$musicValue.record.total_count}</p>
                    </div>
                </div>
                </td></tr>
            {/foreach}
         </table>
         {else}
            <div class="clsNoRecordsFound">{$LANG.sidebar_no_audio_found_error_msg}</div>
         {/if}
	</div>
    <div id="selAlbumListContent" style="display:none">
	{if $populateTopChartBlock_arr.record_count}
        <table class="clsCarouselTopChartList">
        	<tr>
        		<td><div class="clsDateStartEnd">{$date_started}</div></td>
        	</tr>
            {foreach key=musicKey item=musicValue from=$populateTopChartBlock_arr.row}
            	<tr><td>
                <div class="clsCenterContent clsCenterContenWithMusicSale">
					 <div class="clsTopcartNumbers">
						<p class="clsListingNo">{$musicValue.current_position}</p>
						<p class="clsOptionalValus clsPhotoVideoEditLinks {$musicValue.css}" title="{$musicValue.tool_tip}">{$musicValue.position}</p>
					</div>
                    <div class="clsCenterContentImage">
                        <div class="clsThumbImageLink">
                            <div class="clsThumbImageBackground">
                                <a href="{$musicValue.musiclistalbum_url}" class="ClsImageContainer ClsImageBorder1 Cls76x50">
									{if $musicValue.music_image_src  != ''}
										<img src="{$musicValue.music_image_src}" {$musicValue.music_disp} title="{$musicValue.wordWrap_mb_ManualWithSpace_album_title}" />
									{else}
										<img   src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_M.jpg" title="{$musicValue.wordWrap_mb_ManualWithSpace_album_title}"/>
									{/if}
                                </a>
                            </div>
                        </div>
                    </div>


                   <div class="clsMusicSaleOption">
                    {*ADDED THE ADD TO CART LINK*}
						{if $musicValue.sale}
							<p class="clsMusicPriceContainer">{$musicValue.music_price}</p>
	                        {if $musicValue.album_for_sale == 'Yes' and $musicValue.record.user_id!=$CFG.user.user_id and isUserAlbumPurchased($musicValue.record.music_album_id) and isMember()}
								<p id="add_cart_{$musicValue.record.music_album_id}" class="clsStrickedCart"><a href="javascript:void(0)" class="clsStrikeAddToCart clsPhotoVideoEditLinks" title="{$LANG.musiclist_purchased}">{$LANG.musiclist_add_to_cart}</a></p>
							{elseif $musicValue.album_for_sale == 'Yes' and $musicValue.record.user_id!=$CFG.user.user_id and !isUserAlbumPurchased($musicValue.record.music_album_id) and isMember()}
								<p id="add_cart_{$musicValue.record.music_id}" class="clsAddToCart"><a href="javascript:void(0)" onClick="updateMusicsCartCount('{$musicValue.record.music_id}')" title="{$LANG.musiclist_add_to_cart}">{$LANG.musiclist_add_to_cart}</a></p>
	                        {elseif !isMember()}
								<p id="add_cart_{$musicValue.record.music_id}" class="clsAddToCart"><a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_add_cart_err_msg}','{$myobj->getUrl('index','','','members','music')}');return false;">{$LANG.musiclist_add_to_cart}</a></p>
							{/if}
                        {/if}
                        {*ADDED THE ADD TO CART LINK*}
                    </div>
					  <div class="clsCenterContentDetiails">
                        <p class="clsName"><a href="{$musicValue.viewalbum_url}" title="{$musicValue.wordWrap_mb_ManualWithSpace_album_title}">{$musicValue.wordWrap_mb_ManualWithSpace_album_title}</a></p>
						{if $musicValue.record.total_song !='0'}<p>{if $musicValue.record.total_song=='1'}{$LANG.sidebar_topchart_ablum_song_label}:{else}{$LANG.sidebar_topchart_ablum_total_label}:{/if} {$musicValue.record.total_song}</p>{/if}
                        {if $musicValue.record.total_count!='0'}<p>{if $musicValue.record.total_count=='1'}{$LANG.sidebar_topchart_total_play_label}:{else}{$LANG.sidebar_topchart_total_plays_label}:{/if} {$musicValue.record.total_count}</p>{/if}
                    </div>

                </div>
               </td></tr>
            {/foreach}
        </table>
         {else}
            <div class="clsNoRecordsFound">{$LANG.sidebar_no_audio_found_error_msg} </div>
         {/if}
	</div>
    <div id="selArtistListContent" style="display:none">
	{if $populateArtistTopChartBlock_arr.record_count}
        <table class="clsCarouselTopChartList">
        	<tr>
        		<td><div class="clsDateStartEnd">{$date_started}</div></td>
        	</tr>
            {foreach key=musicKey item=musicValue from=$populateArtistTopChartBlock_arr.row}
            	<tr><td>
                <div class="clsCenterContent clsCenterContenWithMusicSale">
					 <div class="clsTopcartNumbers">
						<p class="clsListingNo">{$musicValue.current_position}</p>
						<p class="clsOptionalValus clsPhotoVideoEditLinks {$musicValue.css}" title="{$musicValue.tool_tip}">{$musicValue.position}</p>
					</div>
                    <div class="clsCenterContentImage">
                        <div class="clsThumbImageLink">
                            <div class="clsThumbImageBackground">
                                <a class="ClsImageContainer ClsImageBorder1 Cls76x50" href="{$musicValue.musiclistalbum_url}">
									{if $musicValue.music_path != ''}
									<img src="{$musicValue.music_path}" {$musicValue.disp_image} title="{$musicValue.record.artist_name}" />
									{else}
										<img  src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_artist_M.jpg"/>
									{/if}
                                </a>
                            </div>
                        </div>
                    </div>
					  <div class="clsCenterContentDetiails">
					  	<p class="clsName"><a href="{$musicValue.viewartist_url}">{$musicValue.record.artist_name}</a></p>
						{if $musicValue.record.total_song !='0'}<p>{if $musicValue.record.total_song=='1'}{$LANG.sidebar_topchart_ablum_song_label}:{else}{$LANG.sidebar_topchart_ablum_total_label}:{/if} {$musicValue.record.total_song}</p>{/if}
                        {if $musicValue.record.total_count!='0'}<p>{if $musicValue.record.total_count=='1'}{$LANG.sidebar_topchart_total_play_label}:{else}{$LANG.sidebar_topchart_total_plays_label}:{/if} {$musicValue.record.total_count}</p>{/if}
                    </div>

                </div>
               </td></tr>
            {/foreach}
        </table>
         {else}
            <div class="clsNoRecordsFound">{$LANG.sidebar_no_artist_found_error_msg} </div>
         {/if}
	</div>

{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audiocontent_bottom"}
