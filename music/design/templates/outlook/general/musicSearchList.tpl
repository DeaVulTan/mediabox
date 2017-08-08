{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_top"}
<div class="clsAudioListContainer">
<script type="text/javascript" language="javascript" src="{$CFG.site.project_path_relative}js/AG_ajax_html.js"></script>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti', 'selEditMusicComments','selMsgCartSuccess');
	var max_width_value = "{$CFG.admin.musics.get_code_max_size}";
	var delLink_value;
</script>
{if $myobj->isResultsFound}
{* TO GENERATE PLAYLIST PLAYER *}
			{** @param string $div_id
			 * @param string $music_player_id
			 * @param integer $width
			 * @param integer $height
			 * @param string $auto_play
			 * @param boolean $hidden
			 * @param boolean $playlist_auto_play
 		     	 * @param boolean $javascript_enabled
                   * @param boolean $player_ready_enabled *}
	{$myobj->populatePlayerWithPlaylist($music_fields)}
	<input type="hidden" name="hidden_player_status" id="hidden_player_status" value="" />
    {/if}
          <!--FORM End-->
          <div id="selLeftNavigation">
            <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
              <p id="msgConfirmText"></p>
              <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                      <div><p id="selImageBorder" class="clsPlainImageBorder">
                       <span id="delete_music_msg_id"> </span>
					    <p id="selPlainCenterImage">
                          <img id="selVideoId" border="0" src="" alt=""/>
                        </p>
                      </p>
                    </div>
                  <input type="submit" class="clsSubmitButton" name="yes" value="{$LANG.common_yes_option}"
                  tabindex="{smartyTabIndex}" /> &nbsp;
                  <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_no_option}"
                  tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
                  <input type="hidden" name="act" id="act" />
                  <input type="hidden" name="music_id" id="music_id" />
              </form>
            </div>
            <div id="selMsgConfirmMulti" class="clsPopupConfirmation" style="display:none;">
              <p id="msgConfirmTextMulti">{$LANG.musiclist_multi_delete_confirmation}</p>
              <form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                <input type="submit" class="clsSubmitButton" name="yes" value="{$LANG.common_yes_option}"
                tabindex="{smartyTabIndex}" /> &nbsp;
                <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_no_option}"
                tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
                <input type="hidden" name="music_id" id="music_id" />
                <input type="hidden" name="act" id="act" />
              </form>
            </div>
            <div id="selMsgCartSuccess" class="clsPopupConfirmation" style="display:none;">
              <p id="selCartAlertSuccess"></p>
              <form name="msgCartFormSuccess" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_option_ok}"
                tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
              </form>
            </div>
            <div id="selEditMusicComments" class="clsPopupConfirmation" style="display:none;"></div>
            <form name="musicListForm" id="musicListForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
            <div class="clsSelectAllLinks clsOverflow">
              {if $myobj->getFormField('pg')=="mymusics" || $myobj->getFormField('pg')=="myfavoritemusics" || $myobj->getFormField('pg')=="myplaylist" || $myobj->getFormField('pg')=="pending" }
                {if $myobj->getFormField('pg')=='mymusics' || $myobj->getFormField('pg')=="pending"}
                  <a href="javascript:void(0)" id="dAltMulti"></a>
                  <p class="clsCancelButton-l"><span class="clsCancelButton-r">
                  <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.common_delete_option}" onclick="deleteMultiCheck('{$LANG.musiclist_select_titles}','{$myobj->my_musics_form.anchor}','{$LANG.musiclist_delete_confirmation}','musicListForm','music_id','mymusicdelete');"/></span></p>
                {/if}
                {if $myobj->getFormField('pg')=='myplaylist'}
                 <p class="clsCancelButton-l"><span class="clsCancelButton-r">
                    <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                    tabindex="{smartyTabIndex}" value="{$LANG.common_delete_option}" onclick="deleteMultiCheck('{$LANG.musiclist_select_titles}','{$myobj->my_musics_form.anchor}','{$LANG.musiclist_delete_confirmation}','musicListForm','music_id','myPlaylistMusicDelete');" /></span></p>
                {/if}
                {if $myobj->getFormField('pg')=='myfavoritemusics'}
                   <p class="clsCancelButton-l"><span class="clsCancelButton-r">
                  <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                  tabindex="{smartyTabIndex}" value="{$LANG.common_delete_option}" onclick="deleteMultiCheck('{$LANG.musiclist_select_titles}','{$myobj->my_musics_form.anchor}','{$LANG.musiclist_favorite_delete_confirmation}','musicListForm','music_id','myFavoriteMusicsDelete');" /></span></p>
                {/if}
              {/if}
              </div>
            <div class="clsOverflow clsSortByLinksContainer">
              {if $myobj->isShowPageBlock("my_musics_form")}
                <div class="clsSortByPagination">
                      <div class="clsAudioPaging">
                          {if $CFG.admin.navigation.top}
								{$myobj->setTemplateFolder('general/','music')}
                                {include file=pagination.tpl}
                          {/if}
                      </div>
                </div>
            </div>
            <a href="javascript:void(0)" id="{$myobj->my_musics_form.anchor}"></a>
			<div class="clsMusicSearchList">
              {if $myobj->isResultsFound}
                      {assign var=count value=0}
                      {assign var=song_id value=1}
                      {foreach from=$music_list_result item=result key=inc name=music}
                      {if $smarty.foreach.music.iteration%$myobj->my_musics_form.showMusicSearchList.musicsPerRow==1}
                      {/if}
                            <div class="clsListContents">
                                    <div class="clsOverflow">
                                      <div class="clsThumb">
                                                <div class="clsLargeThumbImageBackground clsNoLink">
													  <a id="{$result.anchor}"></a>
                                                      {if $result.img_src}
                                                      <a  href="{$result.view_music_link}" class="ClsImageContainer ClsImageBorder1 Cls144x110"><img src="{$result.img_src}" alt=""/></a>
                                                      {else if $myobj->getFormField('pg')=="albumlist"}
                                                      <p class="ClsImageContainer ClsImageBorder1 Cls132x88"><img src="{$album_music_count_list[$result.music_album_id].img_src}"  {$album_music_count_list[$result.music_album_id].img_disp_image} alt=""/></p>
                                              {/if}
                                        </div>
                                      <div class="clsTime"><!---->{$result.playing_time}</div>

                                      </div>
                                      <div class="clsPlayerImage">
									  <p>
									  {if $result.record.allow_ratings == 'Yes'}
                                        	{if $myobj->populateRatingDetails($result.rating)}
                                                {$myobj->populateMusicRatingImages($result.rating,'music')}
                                            {else}
                                               	{$myobj->populateMusicRatingImages(0,'music')}
                                            {/if}	<span>&nbsp; ( {$result.record.rating_count} )</span>
                                         {/if}
										 </p>
										 <div class="clsOverflow clsFloatRight clsPlayQuickmix">
                                          {if $result.add_quickmix}
										<div class="clsFloatRight">
                                                {if $result.is_quickmix_added}
                                                      <p class="clsQuickMix" id="quick_mix_added_{$result.music_id}"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.music_list_added_to_quickmix}" >{$LANG.common_music_quick_mix}</a></p>
                                                {else}
                                                      <p class="clsQuickMix" id="quick_mix_added_{$result.music_id}" style="display:none"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.music_list_added_to_quickmix}">{$LANG.common_music_quick_mix}</a></p>

                                                      <p class="clsQuickMix" id="quick_mix_{$result.music_id}"><a href="javascript:void(0)" onclick="updateMusicsQuickMixCount('{$result.music_id}')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="{$LANG.music_list_add_to_quickmix}">{$LANG.common_music_quick_mix}</a></p>
                                               {/if}
											   </div>
                                         {/if}
										 <div class="clsPlayerIcon">
                                          	<a class="clsPlaySong" id="play_music_icon_{$result.music_id}" onclick="playSelectedSong({$result.music_id})" href="javascript:void(0)"></a>
                                          	<a class="clsStopSong" id="play_playing_music_icon_{$result.music_id}" onclick="stopSong({$result.music_id})" style="display:none" href="javascript:void(0)"></a>                                        </div> 
                                       
									   </div>

                                    
                                      </div>

                                      <div class="clsContentDetails">

										<p class="clsHeading"><a  href="{$result.view_music_link}">{$result.music_title_word_wrap}</a></p>
                                       <p class="clsAlbumLink">{$LANG.album_title}:<a  href="{$result.view_album_link}">{$result.album_title_word_wrap}</a></p>
										<p>	{if $result.record.music_artist}
														{$LANG.music_list_added_by_artist} 
														{if $CFG.admin.musics.music_artist_feature}
															<a href="{$myobj->memberProfileUrl[$result.record.user_id]}">{$result.record.user_name}</a>
														{else}
											{$myobj->getArtistLink($result.record.music_artist, true, 0, $myobj->getFormField('artist'))}
										{/if}
												  {/if}
												</p>
                                       <p class="clsGeneres">{$LANG.music_genre_in}<a href="{$result.music_category_link}">{$result.music_category_name_word_wrap}</a></p>
                                          {if ($myobj->getFormField('pg')=="mymusics" || $myobj->getFormField('pg')=="pending" || $result.user_id == $CFG.user.user_id) && $myobj->getFormField('myfavoritemusic') != "Yes"}
                                      <ul class="selMusicLinks clsContentEditLinks">
                                       {* ADDED THE MANAGE LYRIC LINK *}
                                          <li class="clsDelete" id="anchor_myvid_{$result.music_id}">
                                             <a href="javascript:void(0)" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" title="{$LANG.musiclist_delete_music}"
                                             onclick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                             Array('act','music_id', 'selVideoId', 'delete_music_msg_id'), Array('delete','{$result.music_id}', '{$result.img_src}',
                                             '{$result.delete_music_title}'), Array('value','value', 'src', 'innerHTML'), -100, -500,'anchor_myvid_{$result.music_id}');">
                                             </a>
                                          </li>
                                          <li class="clsGetCode" id="anchor_getcode_{$result.music_id}">
                                              <a href="javascript:void(0)" class="clsPhotoVideoEditLinks" title="{$LANG.musiclist_get_code}"
                                              onclick="return getAjaxGetCode('{$result.callAjaxGetCode_url}', '{$result.anchor}','selEditMusicComments','anchor_getcode_{$result.music_id}')">
                                              </a>
                                          </li>
                                          <li class="clsEdit">
                                              <a href="{$result.musicupload_url}" class="clsPhotoVideoEditLinks" title="{$LANG.musiclist_edit_music}">
                                              </a>
                                          </li>
									   {if $myobj->getTotalManageLyricCount($result.music_id)>0}
											<li class="clsManageLyrics">
	                                           <a href="{$result.manage_lyrics_url}" title="{$LANG.musiclist_manage_lyrics}"></a>
	                                        </li>
                                        {/if}
                                      </ul>
                                      {/if}
                                      {if $myobj->getFormField('myfavoritemusic')=="Yes"}
                                      <ul id="selVideoLinks" class="clsContentEditLinks">
                                          <li class="clsDelete" id="anchor_myfav_{$result.music_id}">
                                            <a href="javascript:void(0)" class="clsPhotoVideoEditLinks" title="{$LANG.musiclist_delete_music}"
                                            onclick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                            Array('act','music_id', 'selVideoId', 'delete_music_msg_id'),
                                            Array('favorite_delete','{$result.music_id}', '{$result.img_src}', '{$result.delete_music_title}'),
                                            Array('value','value', 'src', 'innerHTML'), -100, -500,'anchor_myfav_{$result.music_id}');">
                                            </a>
                                          </li>
                                          <li class="clsGetCode" id="anchor_getcode_{$result.music_id}">
                                            <a href="javascript:void(0)" class="clsPhotoVideoEditLinks" title="{$LANG.musiclist_get_code}"
                                            onclick="return getAjaxGetCode('{$result.callAjaxGetCode_url}', '{$result.anchor}','selEditMusicComments','anchor_getcode_{$result.music_id}')">
                                            </a>
                                          </li>
                                      </ul>
                                      {/if}
                                        </div>
                                    </div>
									<div>
									 {literal}
                                    <script type="text/javascript">										
										$Jq(document).ready(function(){
											$Jq("#trigger_{/literal}{$result.music_id}{literal}").click(function(){
												displayMusicMoreInfo('{/literal}{$result.music_id}{literal}');												
												return false;
											});
										});										
									</script>
                                    {/literal}
									<div class="clsMoreInfoContainer clsOverflow">
									  <a class="clsMoreInformation" id="trigger_{$result.music_id}">
										  <span>{$LANG.header_nav_more_info}</span>
									  </a>
									  </div>

               				  <div class="clsMoreInfoBlock" id="panel_{$result.music_id}" style="display:none;" >
										<div class="clsMoreInfoContent clsOverflow">
											<div class="clsOverflow">
                            <table>
                           <tr><td>
                                <p class="clsLeft">{if $CFG.admin.musics.music_artist_feature} {$LANG.music_list_more_cast} {else} {$LANG.music_list_added_by} {/if}</p>
                                <p class="clsRight">
								   {if $CFG.admin.musics.music_artist_feature}{$myobj->getArtistLink($result.record.music_artist, true, 0, $myobj->getFormField('artist'))}
                                          {else}
									 <a href="{$myobj->memberProfileUrl[$result.record.user_id]}">{$result.record.user_name}</a>
								 {/if}
								</p>
                            </td>
							 <td>
                             <span>{$LANG.music_list_added_date}</span>
                             <span class="clsMoreInfodata">{$result.date_added}</span>
                            </td>
							</tr>
                            <tr><td>
                                <span>{$LANG.music_list_plays}</span>
                               <span class="clsMoreInfodata">{$result.record.total_plays}</span>
                              </td>
							   <td>
                              <span>{$LANG.music_list_commented}</span>
                              <span class="clsMoreInfodata">{$result.record.total_comments}</span>
                            </td>
							  </tr>
                              <tr><td>
                               <span>{$LANG.music_list_favorite}</span>
                               <span class="clsMoreInfodata">{$result.record.total_favorites}</span>
                              </td>
							  <td>
                                  <span>{$LANG.musiclist_language_list}: </span>
                                  <span class="clsMoreInfodata">{$result.music_language_val}</span>
                            </td>
							  </tr>
                             <tr><td>
                               <span>{$LANG.music_list_year_released}</span>
                                <span class="clsMoreInfodata">{$result.record.music_year_released}</span>
                              </td>
							   {if $result.record.allow_ratings == 'Yes'}
                                 <td>
                                  <span>{$LANG.music_list_ratted}</span>
                                  <span class="clsMoreInfodata">{$result.rating} ({$result.total_rating} {$LANG.musiclist_ratted})</span>
                                </td>
                            {/if}</tr>
                           </table>
                     
                          
                            
                           
                             
                          
                        </div>
                    	{if $myobj->getFormField('music_tags') != ''}
							{assign var=music_tag value=$myobj->getFormField('music_tags')}
						{elseif $myobj->getFormField('tags') != '' }
							{assign var=music_tag value=$myobj->getFormField('tags')}
						{else}
							{assign var=music_tag value=''}
						{/if}
					   <p class="clsMoreinfoTags">{$LANG.music_list_tags}:{if $result.record.music_tags!=''}{$myobj->getMusicTagsLinks($result.record.music_tags,5, $music_tag)}{/if}</p>
					   <p class="clsDescription"><span class="clsLabel">{$LANG.music_list_description}</span>:{$myobj->getDescriptionForMusicSearchList($result.record.music_caption)}
					{foreach from=$getDescriptionLink_arr item=descriptionsValue}
						{$descriptionsValue.wordWrap_mb_ManualWithSpace_description_name}
					{/foreach}</p>

                    </div>
                  </div>
				</div>
               </div>
					{if $smarty.foreach.music.iteration%$myobj->my_musics_form.showMusicSearchList.musicsPerRow==0}
					{/if}
						{assign var=song_id value=$song_id+1}
					{/foreach}
					{else}
					<div id="selMsgAlert">
					  <p>{$LANG.common_music_no_records_found}</p>
					</div>
					{/if}
            {/if}
			</div>
            <div class="clsAudioPaging">
                {if $CFG.admin.navigation.bottom}
				{$myobj->setTemplateFolder('general/','music')}
                {include file=pagination.tpl}
                {/if}
            </div>
                </form>
          </div>
</div>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_bottom"}
