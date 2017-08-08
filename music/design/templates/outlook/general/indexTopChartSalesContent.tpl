{if !isAjaxPage()}
	<div id="sel{$myobj->getFormField('topChart')}Process"></div>
   <!-- <p class="clsPageNo" id="sel{$myobj->getFormField('topChart')}PageNo"></p>-->
    {assign var = height value=220}
    {assign var = cur_row value=$myobj->no_of_row_topchart-1}
    {assign var = incheight value=$cur_row*100}
    {assign var = heightRow value=$height+$incheight}
    {if $populateCarousalTopChartBlock_arr.record_count}
    	{assign var = heightPx value='390px'}
    {else}
    	{assign var = heightPx value='50px'}
    {/if}
	<div id="container{$myobj->getFormField('topChart')}" style="position:relative;margin-top:7px; width:470px;height:{$heightPx};overflow-y:hidden;">
		<div id="sel{$myobj->getFormField('topChart')}List" style="position:absolute; width:470px;left:0px;top:0px;">
{/if}
{if isAjaxPage()}
    {if $opt == 'albums'}
        {if $populateCarousalTopChartBlock_arr.record_count}
        <table class="clsCarouselTopChartList">
            {foreach key=musicKey item=musicValue from=$populateCarousalTopChartBlock_arr.row}
            	<tr><td>
                <div class="clsCenterContent clsCenterContenWithMusicSale">
					 <div class="clsTopcartNumbers">
						<p class="clsListingNo">{$musicValue.current_position}</p>
						<p class="clsOptionalValus clsPhotoVideoEditLinks {$musicValue.css}" title="{$musicValue.tool_tip}">{$musicValue.position}</p>
					</div>
                    <div class="clsCenterContentImage">
                        <div class="clsThumbImageLink">
                            <div class="clsThumbImageBackground">
                                <a href="{$musicValue.viewalbum_url}" class="ClsImageContainer ClsImageBorder1 Cls76x50">
									{if $musicValue.music_image_src  != ''}
										<img src="{$musicValue.music_image_src}" {$musicValue.music_disp} title="{$musicValue.record.album_title}" />
									{else}
										<img   src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_M.jpg" title="{$musicValue.record.album_title}"/>
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
						{elseif $musicValue.album_for_sale == 'Yes' and $musicValue.record.user_id == $CFG.user.user_id and isMember()}
								<p id="add_cart_{$musicValue.record.music_id}" class="clsAddToCart"><a href="javascript:void(0)" class="clsStrikeAddToCart clsPhotoVideoEditLinks"  onClick="updateMusicsCartCount('{$musicValue.record.music_id}')" title="{$LANG.musiclist_add_to_cart_my_music_added}">{$LANG.musiclist_add_to_cart}</a></p>

							{elseif $musicValue.album_for_sale == 'Yes' and $musicValue.record.user_id!=$CFG.user.user_id and !isUserAlbumPurchased($musicValue.record.music_album_id) and isMember()}
								<p id="add_cart_{$musicValue.record.music_id}" class="clsAddToCart"><a href="javascript:void(0)" onClick="updateMusicsCartCount('{$musicValue.record.music_id}')" title="{$LANG.musiclist_add_to_cart}">{$LANG.musiclist_add_to_cart}</a></p>
	                        {elseif !isMember()}
								<p id="add_cart_{$musicValue.record.music_id}" class="clsAddToCart"><a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_add_cart_err_msg}','{$myobj->getUrl('index','','','members','music')}');return false;">{$LANG.musiclist_add_to_cart}</a></p>
							{/if}
							{else}
							 <div class="clsOverflow">
							 {if $CFG.admin.musics.allowed_usertypes_to_upload_for_sale!='None'}
							<p class="clsMusicPriceContainer clsPriceFloatLeft"><span>{$LANG.common_music_free_label}<span/></p>
							<p class="clsAddToCart clsAddcartFloatRight"><a href="{$musicValue.viewalbum_url}" title="{$LANG.common_music_get_it_label}" >{$LANG.common_music_get_it_label}</a></p>
							{/if}
							</div>
{/if}
                        {*ADDED THE ADD TO CART LINK*}
                    </div>
					  <div class="clsCenterContentDetiails">
                        <p class="clsName"><a href="{$musicValue.viewalbum_url}" title="{$musicValue.record.album_title}">{$musicValue.record.album_title}</a></p>
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
    {elseif $opt == 'artist'}
        {if $populateCarousalTopChartBlock_arr.record_count}
        <table class="clsCarouselTopChartList">
            {foreach key=musicKey item=musicValue from=$populateCarousalTopChartBlock_arr.row}
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
					  	<p class="clsName"><a href="{$musicValue.viewartist_url}" title="{$musicValue.record.artist_name}">{$musicValue.record.artist_name}</a></p>
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

    {elseif $opt == 'normal'}
        {if $populateCarousalTopChartBlock_arr.record_count}
        <table class="clsCarouselTopChartList">
            {foreach key=musicKey item=musicValue from=$populateCarousalTopChartBlock_arr.row}
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
										<img src="{$musicValue.music_image_src}" {$musicValue.music_disp} title="{$musicValue.record.music_title}" alt="{$musicValue.record.music_title}" />
									{else}
										<img   src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_M.jpg" title="{$musicValue.record.music_title}" alt="{$musicValue.record.music_title}"/>
									{/if}
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="clsTopChartPlayer">
						<div class="clsPlayerIcon">
                              <a class="clsPlaySong" id="{$script_case}_play_music_icon_{$musicValue.record.music_id}" onClick="playSelectedSong({$musicValue.record.music_id}, '{$script_case}')" href="javascript:void(0)"></a>
                              <a class="clsStopSong" id="{$script_case}_play_playing_music_icon_{$musicValue.record.music_id}" onClick="stopSong({$musicValue.record.music_id}, '{$script_case}')" style="display:none" href="javascript:void(0)"></a>
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
									{elseif $musicValue.for_sale == 'Yes' and $musicValue.record.user_id == $CFG.user.user_id and isMember()}
								<p id="add_cart_{$musicValue.record.music_id}" class="clsAddToCart"><a href="javascript:void(0)" class="clsStrikeAddToCart clsPhotoVideoEditLinks"   onClick="updateMusicsCartCount('{$musicValue.record.music_id}')" title="{$LANG.musiclist_add_to_cart_my_music_added}">{$LANG.musiclist_add_to_cart}</a></p>
	                        {elseif !isMember()}
								<p id="add_cart_{$musicValue.record.music_id}" class="clsAddToCart"><a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_add_cart_err_msg}','{$myobj->getUrl('index','','','members','music')}');return false;" title="{$LANG.musiclist_add_to_cart}">{$LANG.musiclist_add_to_cart}</a></p>
							{/if}
							{else}
							 <div class="clsOverflow">
							 {if $CFG.admin.musics.allowed_usertypes_to_upload_for_sale!='None'}
							<p class="clsMusicPriceContainer"><span>{$LANG.common_music_free_label}<span/></p>
							<p class="clsAddToCart"><a href="{$musicValue.title_url}" title="{$LANG.common_music_get_it_label}" >{$LANG.common_music_get_it_label}</a></p>
							{/if}
							</div>
                        {/if}
                        {*ADDED THE ADD TO CART LINK*}
                    </div>
                    <div class="clsCenterContentDetiails">
                        <p class="clsName"><a href="{$musicValue.title_url}"  title="{$musicValue.record.music_title}">{$musicValue.record.music_title}</a></p>
                        <p class="clsType" title="{$musicValue.record.category_name}"><a href="{$musicValue.musiccategory_url}" title="{$musicValue.record.category_name}">{$musicValue.record.category_name}</a></p>
                        <p>{if $musicValue.record.total_count!='0' && $musicValue.record.total_count=='1'} {$LANG.sidebar_topchart_play_label}: {else} {$topchartlabel}:{/if} {$musicValue.record.total_count}</p>
                    </div>
                </div>
                </td></tr>
            {/foreach}
         </table>
         {else}
            <div class="clsNoRecordsFound">{$LANG.sidebar_no_audio_found_error_msg}</div>
         {/if}


    {/if}
{/if}
{if !isAjaxPage()}
</div>
</div>
{/if}