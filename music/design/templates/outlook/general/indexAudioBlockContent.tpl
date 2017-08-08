{if $music_block_record_count}
<table class="clsCarouselList">
	{* Assigned to set num. of records in each row *}
	{assign var=row_count value=4}
	{assign var=break_count value=1}
	{foreach key=upload_musicKey item=upload_musicValue from=$populateCarousalMusicBlock_arr.row}
    {if $break_count == 1}
    <tr>
    {/if}
        <td {if $break_count == $row_count}class="clsFinalData"{/if}>
            {*<div class="clsPlayCurrentAudio">
                <a href="{$upload_musicValue.viewmusic_url}" title="{$upload_musicValue.record.music_title}"> <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-play.gif" /></a>
            </div>*}
            <div class="clsLargeThumbImageBackground">
                <a href="{$upload_musicValue.viewmusic_url}" class="ClsImageContainer ClsImageBorder1 Cls144x110">
                    {if $upload_musicValue.music_image_src != ''}
                        <img src="{$upload_musicValue.music_image_src}" alt="{$upload_musicValue.record.music_title|truncate:10}" title="{$upload_musicValue.music_title} {$upload_musicValue.extra_music_details}" {$myobj->DISP_IMAGE(#image_music_thumb_width#, #image_music_thumb_height#, $upload_musicValue.thumb_width, $upload_musicValue.thumb_height)}/>
                    {else}
                        <img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" alt="{$upload_musicValue.record.music_title|truncate:10}" title="{$upload_musicValue.record.music_title} {$upload_musicValue.extra_music_details}"/>
                    {/if}
                </a>
                <div class="clsTime">{$upload_musicValue.playing_time}</div>
            </div>
            <div class="clsAudioIndexCauroselListContent">
                <a href="{$upload_musicValue.viewmusic_url}" title="{$upload_musicValue.music_title}"><pre>{$upload_musicValue.music_title}</pre></a>
				<p class="clsMusicalbum"><span>{$LANG.in|capitalize}: </span><a href="{$upload_musicValue.get_viewalbum_url}" title="{$LANG.album_title}: {$upload_musicValue.album_title}">{$upload_musicValue.album_title}</a></p>
                {if isset($upload_musicValue.sale)}
               	{* <div class="clsOverflow clsMusicPriceCart">
                    <p class="clsNormal clsMusicPriceLeft">{$upload_musicValue.music_price}</p>
                    <!-- ADDED THE ADD TO CART LINK -->
                    {if ($upload_musicValue.for_sale=='Yes' or $upload_musicValue.album_for_sale=='Yes') and $upload_musicValue.record.user_id != $CFG.user.user_id and (isUserPurchased($upload_musicValue.record.music_id) or isUserAlbumPurchased($upload_musicValue.record.music_album_id)) and isMember()}
                    <p id="add_cart_{$upload_musicValue.record.music_id}" class="clsStrikeAddToCart clsMusiccartRight"><a href="javascript:void(0)" class="clsStrikeAddToCart clsPhotoVideoEditLinks" title="{$LANG.musiclist_purchased}">{$LANG.musiclist_add_to_cart}</a></p>
                    {elseif ($upload_musicValue.for_sale == 'Yes' or $upload_musicValue.album_for_sale == 'Yes') and $upload_musicValue.record.user_id == $CFG.user.user_id and isMember()}
                    <p id="add_cart_{$upload_musicValue.record.music_id}" class="clsStrikeAddToCart clsMusiccartRight"><a href="javascript:void(0)" class="clsStrikeAddToCart clsPhotoVideoEditLinks" title="{$LANG.musiclist_add_to_cart_my_music_added}">{$LANG.musiclist_add_to_cart}</a></p>
                    {elseif $upload_musicValue.album_for_sale=='Yes' and $upload_musicValue.record.user_id != $CFG.user.user_id and !isUserAlbumPurchased($upload_musicValue.record.music_album_id) and isMember()}
                    <p id="add_cart_{$upload_musicValue.record.music_album_id}" class="clsAddToCart clsMusiccartRight"><a href="javascript:void(0)" onClick="updateAlbumCartCount('{$upload_musicValue.record.music_album_id}')" title="{$LANG.musiclist_add_to_cart}">{$LANG.musiclist_add_to_cart}</a></p>
                    {elseif $upload_musicValue.for_sale=='Yes' and $upload_musicValue.record.user_id != $CFG.user.user_id and !isUserPurchased($upload_musicValue.record.music_id) and isMember()}
                    <p id="add_cart_{$upload_musicValue.record.music_id}" class="clsAddToCart clsMusiccartRight"><a href="javascript:void(0)" onClick="updateMusicsCartCount('{$upload_musicValue.record.music_id}')" title="{$LANG.musiclist_add_to_cart}">{$LANG.musiclist_add_to_cart}</a></p>
                    {elseif $upload_musicValue.for_sale=='Yes' and !isMember()}
                    <p id="add_cart_{$upload_musicValue.record.music_id}" class="clsAddToCart clsMusiccartRight"><a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_add_cart_err_msg}','{$myobj->is_not_member_url}');return false;" title="{$LANG.musiclist_add_to_cart}">{$LANG.musiclist_add_to_cart}</a></p>
                    {/if}
                </div>*}
                {else}
                {* <div class="clsOverflow clsMusicPriceCart">
                    {if $CFG.admin.musics.allowed_usertypes_to_upload_for_sale!='None'}
                    <p class="clsNormal clsMusicPriceLeft">{$LANG.common_music_free_label}</p>
                    <p class="clsAddToCart clsMusiccartRight"><a href="{$upload_musicValue.viewmusic_url}" title="{$LANG.common_music_get_it_label}">{$LANG.common_music_get_it_label}</a></p>
                    {/if}
                </div> *}
                {/if}
            </div>
        </td>
    {assign var=break_count value=$break_count+1}
    {if $break_count > $row_count}
    </tr>
    {assign var=break_count value=1}
    {/if}
    {/foreach}             
    {if $break_count != 1}
    {* Added to display empty row if last row records < row_count *}
    <td colspan="{math equation=($row_count+1)-$break_count}">&nbsp;</td>
    </tr>
    {/if}
</table>
{else}
{if $showtab == 'topratedmusic'}
<div class="clsNoRecordsFound">{$LANG.sidebar_no_audio_rated_error_msg}</div>
{else}
<div class="clsNoRecordsFound">{$LANG.sidebar_no_audio_found_error_msg}</div>
{/if}
{/if}