{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_top"}
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgCartSuccess');
</script>
<div class="clsAudioListContainer clsAudioPlayListContainer">
    {if $myobj->isShowPageBlock('search_albumlist_block')}
        <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}">
            <input type="hidden" name="advanceFromSubmission" value="1"/>
            <input type="hidden" name="start" value="1"/>
            <input type="hidden" name="music_id" id="music_id" />
            <div class="clsOverflow">
                    <div class="clsHeadingLeft">
                        <h2>
                        	<span>
                            {if $myobj->page_heading != ''}
                                {$myobj->page_heading}
                            {else}
                                {$LANG.musicalbumList_title}
                            {/if}
                            </span>
                        </h2>
                    </div>
                    <div class="clsHeadingRight clsVideoListHeadingRightLink clsAlphaShortListing">
                    <h2><a href="{$myobj->getUrl('albumsortlist', '', '','','music')}">{$LANG.musicalbumList_album_sort_list_title} </a></h2>
                        {*	<div class="clsAudioListMenu">
                                <select onchange="loadUrl(this)">
                                <option value="{$myobj->getUrl('albumlist', '?pg=albumlistnew', 'albumlistnew/','','music')}"
                                {if $myobj->getFormField('pg')=='albumlistnew'} selected {/if} >
                                {$LANG.header_nav_music_new}
                                </option>
                                <option value="{$myobj->getUrl('albumlist', '?pg=albummostlistened', 'albummostlistened/', '', 'music')}"
                                {if $myobj->getFormField('pg')=='albummostlistened'} selected {/if} >
                                {$LANG.header_nav_most_listened}
                                </option>
                                <option value="{$myobj->getUrl('albumlist', '?pg=albummostviewed', 'albummostviewed/', '', 'music')}"
                                {if $myobj->getFormField('pg')=='albummostviewed'} selected {/if} >
                                {$LANG.header_nav_most_viewed}
                                </option>
                                <option value="{$myobj->getUrl('albumlist', '?pg=albummostrecentlyviewed', 'albummostrecentlyviewed/', '', 'music')}"
                                {if $myobj->getFormField('pg')=='albummostrecentlyviewed'} selected {/if} >
                                {$LANG.header_nav_music_recently_viewed}
                                </option>
                                </select>
                            </div> *}
                    </div>
                </div>
            {*	{if $myobj->getFormField('pg') == 'albummostlistened' or $myobj->getFormField('pg') == 'albummostviewed'}
                    <div class="clsTabNavigation">
                        <ul>
                            <li{$musicActionNavigation_arr.cssli_0}>
                                <span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_0}')">{$LANG.header_nav_members_all_time}</a></span>
                            </li>
                            <li{$musicActionNavigation_arr.cssli_1}>
                                <span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_1}');">{$LANG.header_nav_members_today}</a></span>
                            </li>
                            <li{$musicActionNavigation_arr.cssli_2}>
                                <span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_2}');">{$LANG.header_nav_members_yesterday}</a></span>
                            </li>
                            <li{$musicActionNavigation_arr.cssli_3}>
                                <span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_3}');">{$LANG.header_nav_members_this_week}</a></span>
                            </li>
                            <li{$musicActionNavigation_arr.cssli_4}>
                                <span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_4}');">{$LANG.header_nav_members_this_month}</a></span>
                            </li>
                            <li{$musicActionNavigation_arr.cssli_5}>
                                <span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_5}');">{$LANG.header_nav_members_this_year}</a></span>
                            </li>
                        </ul>
                    </div>
                {literal}
					<script type="text/javascript">
                    function jumpAndSubmitForm(url)
                        {
                            document.seachAdvancedFilter.action=url;
                            document.seachAdvancedFilter.submit();
                        }
                    var subMenuClassName1='clsActiveTabNavigation';
                    var hoverElement1  = '.clsTabNavigation li';
                    loadChangeClass(hoverElement1,subMenuClassName1);
                    </script>
                    {/literal}
                    {/if}   *}
				 <div class="clsOverflow clsshowhidefiltersblock">
        	<div class="clsAdvancedFilterSearch clsOverflow clsFloatLeft">
                        <a onclick="divShowHide('advancedAlbumlistSearch', 'show_link', 'hide_link')" class="clsShow"  id="show_link" href="javascript:void(0)"><span>{$LANG.musicalbumList_show_advanced_filters}</span></a>
                        <a onclick="divShowHide('advancedAlbumlistSearch', 'show_link', 'hide_link')" class="clsHide"  style="display:none" id="hide_link" href="javascript:void(0)"><span>{$LANG.musicalbumList_hide_advanced_filters}</span></a>
                    </div>
					</div>

			    <div id="advancedAlbumlistSearch" class="clsAdvancedFilterTable clsOverflow" {if $myobj->chkAdvanceResultFound()}  style="display:block {else} style="display:none;  {/if}margin:10px 0;"  >
					<div class="clsAdvanceSearchIcon">
                        <table class="">
                            <tr>
                                <td>
                                    <input class="clsTextBox" type="text" name="albumlist_title" id="albumlist_title"   value="{if $myobj->getFormField('albumlist_title') == ''}{$LANG.musicalbumList_albumList_title}{else}{$myobj->getFormField('albumlist_title')}{/if}" onblur="setOldValue('albumlist_title')"  onfocus="clearValue('albumlist_title')"/>
                                </td>
                                <td>
                                    <input class="clsTextBox" type="text" name="artist" id="artist" onfocus="clearValue('artist')"  onblur="setOldValue('artist')" value="{if $myobj->getFormField('artist') == ''}{$LANG.musicalbumList_no_of_artist}{else}{$myobj->getFormField('artist')}{/if}"/>
                                </td>
                            </tr>
                            <tr><td colspan="2">
                                    <input class="clsTextBox" type="text" name="music_title" id="music_title" onfocus="clearValue('music_title')"  onblur="setOldValue('music_title')" value="{if $myobj->getFormField('music_title') == ''}{$LANG.musicalbumList_no_of_music_title} {else}{$myobj->getFormField('music_title')}{/if}" />
                                </td>
                            </tr>
                        </table>
						</div>
						<div class="clsAdvancedSearchBtn">
						<table>
							 <tr>
                            <td>
                                <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="search" id="search" value="{$LANG.musicalbumList_search}" onclick="document.seachAdvancedFilter.start.value = '0';" /></span></div>
								</td></tr>
								<tr>
								<td>
                               <div class="clsCancelButton1-l"><span class="clsCancelButton1-r"><input type="submit" value="Reset" id="avd_reset" name="avd_reset"/></span></div>
                        	</td>
                        </tr>
						</table>
						</div>
                 </div>
               </form>

                {/if}
                {if  $myobj->isShowPageBlock('list_albumlist_block')}
                    <div id="selMusicPlaylistManageDisplay" class="clsLeftSideDisplayTable">
                        {if $myobj->isResultsFound()}
                          {if $CFG.admin.navigation.top}
                                      <div class="clsAudioPaging">
				   					  {$myobj->setTemplateFolder('general/','music')}
                                      {include file=pagination.tpl}
                                      </div>
                          {/if}
                        <!-- top pagination end-->
                            <div id="selMsgCartSuccess" class="clsPopupConfirmation" style="display:none;">
                              <p id="selCartAlertSuccess"></p>
                              <form name="msgCartFormSuccess" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                                <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_option_ok}"
                                tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
                              </form>
                            </div>
                            <form name="musicListForm" id="musicListForm" action="{$_SERVER.PHP_SELF}" method="post">
                            {foreach key=musicAlbumlistKey item=musicalbumlist from=$myobj->list_albumlist_block.showAlbumlists.row}
                                <div class="clsListContents">
                                    <div class="clsOverflow">
                                                <div class="clsThumb">
                                                    <input type="hidden" name="music_album_id" id="music_album_id" value="{$musicalbumlist.record.music_album_id}" />
                                                    <div class="clsLargeThumbImageBackground clsNoLink">
                                                      <a href="{$musicalbumlist.getUrl_viewAlbum_url}" class="ClsImageContainer ClsImageBorder1 Cls132x88">
                                                                {if $musicalbumlist.music_image_src !=''}
                                                                    <img src="{$musicalbumlist.music_image_src}" title="{$musicalbumlist.record.music_title}" alt="{$musicalbumlist.record.music_title|truncate:10}" {$myobj->DISP_IMAGE(132, 88, $musicalbumlist.record.thumb_width, $musicalbumlist.record.thumb_height)}/>
                                                                {else}
                                                                    <img   width="132" height="88" src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" title="{$musicalbumlist.record.music_title}" alt="{$musicalbumlist.record.music_title|truncate:10}"/>
                                                                {/if}
                                                       </a>
                                                      </div>
                                                </div>
                                                <div class="clsPlayerImage">
													<span>({if $musicalbumlist.total_song <= 1}{$LANG.musicalbumList_song}:&nbsp;{$musicalbumlist.total_song}{else}{$LANG.musicalbumList_songs}:&nbsp;{$musicalbumlist.total_song}{/if}{if $musicalbumlist.private_song gt 0}&nbsp;|&nbsp;{$LANG.musicalbumList_private}:&nbsp;{$musicalbumlist.private_song}{/if})</span>
                                                    <p class="clsSongListLink"><a href="javascript:void(0)" id="albumlist_light_window_{$musicAlbumlistKey}" title="{$LANG.musicalbumList_allsongdetail_helptips}">{$LANG.musicalbumList_song_list}</a></p>
                                                    {* Added code to display to display fancy box*}
													<script type="text/javascript">
                                                    {literal}
                                                    $Jq(window).load(function() {
                                                        $Jq('#albumlist_light_window_{/literal}{$musicAlbumlistKey}{literal}').fancybox({
                                                            'width'				: 550,
                                                            'height'			: 350,
                                                            'autoScale'     	: false,
                                                            'href'              : '{/literal}{$musicalbumlist.light_window_url}{literal}',
                                                            'transitionIn'		: 'none',
                                                            'transitionOut'		: 'none',
                                                            'type'				: 'iframe'
                                                        });
                                                    });
                                                    {/literal}
                                                    </script>
                                                	{*ADDED THE ADD TO CART LINK*}
													{if $musicalbumlist.record.album_for_sale == 'Yes' and isMember() and isUserAlbumPurchased($musicalbumlist.record.music_album_id) and $musicalbumlist.record.user_id!=$CFG.user.user_id}
														<p id="add_cart_{$musicalbumlist.record.music_album_id}" class="clsStrikeAddToCart"><a href="javascript:void(0)" class="clsStrikeAddToCart clsPhotoVideoEditLinks" title="{$LANG.musiclist_purchased}">{$LANG.musiclist_add_to_cart}</a></p>
													{elseif $musicalbumlist.record.album_for_sale == 'Yes' and isMember() and !isUserAlbumPurchased($musicalbumlist.record.music_album_id) and $musicalbumlist.record.user_id!=$CFG.user.user_id}
														<p id="add_cart_{$musicalbumlist.record.music_album_id}" class="clsAddToCart"><a href="javascript:void(0)" onclick="updateAlbumCartCount('{$musicalbumlist.record.music_album_id}')" title="{$LANG.musiclist_add_to_cart}">{$LANG.musiclist_add_to_cart}</a></p>
                                                    {elseif $musicalbumlist.record.album_for_sale == 'Yes' and !isMember()}
                                                    	<p id="add_cart_{$musicalbumlist.record.music_album_id}" class="clsAddToCart"><a title="{$LANG.musiclist_add_to_cart}" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_add_cart_err_msg}','{$myobj->getUrl('albumlist','','','members','music')}');return false;">{$LANG.musiclist_add_to_cart}</a></p>
													{/if}

													{if $musicalbumlist.record.album_for_sale == 'Yes'}
													<p class="clsMusicPriceContainer">
                                                    {$LANG.musicalbumList_album_price} <span>{$CFG.currency}{$musicalbumlist.album_price}</span>
													</p>
                                                    {/if}

													{*ADDED THE ADD TO CART LINK*}

                                                    {*ADDED THE MANAGE ALBUM LINK*}
                                                    {if $musicalbumlist.record.user_id==$CFG.user.user_id}
                                                    <p class="clsManageAlbum"><a href="{$musicalbumlist.getUrl_editAlbum_url}" title="{$LANG.musicalbumList_manage_album}">{$LANG.musicalbumList_manage_album}</a></p>
                                                    {/if}
                                                    {*ADDED THE MANAGE ALBUM LINK*}

												</div>

                                                <div class="clsContentDetails">
                                                    <p class="clsHeading">
                                                        <a  href="{$musicalbumlist.getUrl_viewAlbum_url}" title="{$musicalbumlist.word_wrap_album_title}">{$musicalbumlist.word_wrap_album_title}</a>

								    </p>
                                                    {if $myobj->isShowPageBlock('displaysonglist_block')}
                                                        {$myobj->displayAlbumSongList($musicalbumlist.record.music_album_id)}
                                                    {else}
                                                        {$myobj->displayAlbumSongList($musicalbumlist.record.music_album_id, true, 3)}
                                                    {/if}

                                                    {if $musicalbumlist.total_song >= 1}
                                                    {$myobj->setTemplateFolder('general/', 'music')}
                                                    {include file=albumSongList.tpl}
                                                     <p>{if $musicalbumlist.record.total_plays <= 1}{$LANG.musicalbumList_total_play}:{else}{$LANG.musicalbumList_total_plays}:{/if}&nbsp;{$musicalbumlist.record.total_plays}&nbsp;|&nbsp;{if $musicalbumlist.record.total_views <= 1}{$LANG.musicalbumList_view}:{else}{$LANG.musicalbumList_plays}:{/if}&nbsp;{$musicalbumlist.record.total_views}</p>
                                                    {/if}
                                                </div>

                                       </div>
                                </div>
                                {/foreach}
                                {if $CFG.admin.navigation.bottom}
                                <div id="bottomLinks" class="clsAudioPaging">
									{$myobj->setTemplateFolder('general/','music')}
                                    {include file='pagination.tpl'}
                                </div>
                                </form>
                            {/if}
                        {else}
                        <div id="selMsgAlert">
                            <p>{if $smarty.post && $smarty.post.search}{$LANG.musicalbumList_no_records_found}{else}{$myobj->musicalbumList_no_records_found}{/if}</p>
                        </div>
                    {/if}
                        </div>
                    {/if}
    </div>
{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_bottom"}
