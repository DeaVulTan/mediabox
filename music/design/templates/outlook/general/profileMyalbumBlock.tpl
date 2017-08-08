{if chkAllowedModule(array('music')) and $fanblock}
{$myobj->chkTemplateImagePathForModuleAndSwitch('music', $CFG.html.template.default, $CFG.html.stylesheet.screen.default)}
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgCartSuccess');
</script>
<div class="clsAlbumShelfTable">
<table>
	<tr>
	  <th colspan="2">
		  <div class="clsProfileAlbumBlockTitle"> <span>{$LANG.myprofile_shelf_album}</span></div>
	  </th>
	</tr>
	<tr>
		<td>
			<div class="clsAlbumShelfContainer">
				<table>
				{if $albumDisplayed}
				{assign var=i value=1}
				{foreach key=item item=value from=$albumlist_arr}
					{if $i%2==0}
						{assign var=extclass value="clsCenterContent clsBackgroundNone"}
					{else}
						{assign var=extclass value="clsCenterContent"}
					{/if}
					<tr>
						<td>
						  <div class="{$extclass}">
								<div class="clsCenterContentImage">
									<div class="clsThumbImageLink">
										<div href="{$value.viewalbum_url}">
												{if $value.music_image_src !=''}
													<a href="{$value.viewalbum_url}" class="ClsImageContainer ClsImageBorder1 ClsMusicAlbum45x45"><img src="{$value.music_image_src}" alt="{$value.music_disp}" title="{$value.record.album_title}" {$myobj->DISP_IMAGE(45, 45, $value.small_width, $value.small_height)} /></a>
												{else}
													<a href="{$value.viewalbum_url}" class="ClsImageContainer ClsImageBorder1 ClsMusicAlbum45x45"><img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_S.jpg" title="{$value.record.album_title}" {$myobj->DISP_IMAGE(45, 45, 71, 54)} /></a>
												{/if}
										</div>
									</div>
								</div>
								<div class="clsAlbumAddtoCartContainer">
								<div class="clsAlbumAddtoCart">
								{if $value.album_for_sale == 'Yes' and isMember() and !isUserAlbumPurchased($value.music_album_id) and $value.user_id!=$CFG.user.user_id}
									<p id="add_cart_{$value.music_album_id}"><a href="javascript:void(0)" onClick="updateAlbumCartCount('{$value.music_album_id}')" title="{$LANG.musiclist_add_to_cart}">{$LANG.musiclist_add_to_cart}</a></p>
								{elseif $value.album_for_sale == 'Yes' and isMember() and isUserAlbumPurchased($value.music_album_id) and $value.user_id!=$CFG.user.user_id}
									<p id="add_cart_{$value.music_album_id}" class="clsMusicPurchased"><a href="javascript:void(0)" class="clsStrikeAddToCart clsPhotoVideoEditLinks" title="{$LANG.musiclist_purchased}">{$LANG.musiclist_add_to_cart}</a></p>
                                {elseif $value.album_for_sale == 'Yes' and !isMember()}
                                	<p id="add_cart_{$value.music_album_id}"><a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_add_cart_err_msg}','{$value.member_url}');return false;" title="{$LANG.musiclist_add_to_cart}">{$LANG.musiclist_add_to_cart}</a></p>
								{/if}
								</div>
								{if $value.album_for_sale == 'Yes'}
								<p class="clsMusicPriceContainer">{$LANG.common_album_price} <span>{$CFG.currency}{$value.album_price}</span></p>
								{/if}
								</div>
								<div class="clsCenterContentDetiails">
									<p><a href="{$value.viewalbum_url}" title="{$value.album_title}">{$value.album_title}</a><span> ( {$LANG.myprofile_shelf_songs} <span class="clsBlack">{$value.total_songs}</span> )</span></p>
									<p class="clsMarginBtm0"><span class="clsBorderInnerSpan">{$LANG.myprofile_shelf_total_plays} <span class="clsBlack"> {$value.total_plays}</span></span> <span>{$LANG.myprofile_shelf_total_views} <span class="clsBlack"> {$value.total_album_views}</span> </span></p>
								</div>
							</div>
						</td>
						<p id='anchor_id'>
					</tr>
				{assign var=i value=$i+1}
				{/foreach}
				{else}
					<tr>
			          <td colspan="2"><div class="clsProfileTableInfo"><div id="selMsgAlert" class=""><p> {$LANG.myprofile_albums_no_msg}</p></div></div></td>
			        </tr>
				{/if}
				</table>
			</div>
		</td>
	</tr>
	<td colspan="2" class="clsMoreBgMusicCols">
	  {if $albumDisplayed}
	  	<div class="clsMusicViewMoreLink"><a href="{$viewalbum_url}" title="{$LANG.myprofile_link_view_albums}">{$LANG.myprofile_link_view_albums}</a></div>
	  {/if}
	</td>
</table>

<div id="selMsgCartSuccess" class="clsPopupConfirmation" style="display:none;">
<p id="selCartAlertSuccess"></p>
<form name="msgCartFormSuccess" id="msgCartFormSuccess" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
<input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_option_ok}"
tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
</form>
</div>

{*CONFIRMATION BOX FOR NAVIGATING TO LOGIN PAGE FOR NON MEMBERS STARTS HERE*}
 <div id="selMsgLoginConfirmMulti" class="clsPopupConfirmation" style="display:none;">
        <p id="selAlertLoginMessage">{$LANG.sidebar_login_err_msg}</p>
        <form name="msgConfirmformMulti1" id="msgConfirmformMulti1" method="post" action="" autocomplete="off">
          <input type="submit" class="clsSubmitButton" name="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
          <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hidingBlocks()" />
        </form>
 </div>
{*CONFIRMATION BOX FOR NAVIGATING TO LOGIN PAGE FOR NON MEMBERS ENDS HERE*}
</div>
{/if}