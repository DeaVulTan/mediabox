<script type="text/javascript" language="javascript" src="{$CFG.site.project_path_relative}js/AG_ajax_html.js"></script>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti', 'selEditVideoComments', 'selMsgCartSuccess');
	var max_width_value = "{$CFG.admin.musics.get_code_max_size}";
	var delLink_value;
</script>
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
{* TO GENERATE PLAYLIST PLAYER *}
    {$myobj->setTemplateFolder('general/', 'music')}
    {include file="box.tpl" opt="audioindex_top"}
    <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}">
    <input type="hidden" name="advanceFromSubmission" value="1"/>
    {$myobj->populateMusicListHidden($paging_arr)}
      <div class="clsAudioListContainer">
          <div class="clsOverflow">
              <div class="clsHeadingLeft">
                <h2><span>
                {if $myobj->getFormField('pg')=='usermusiclist'}
                  {$LANG.musictracker_title}
                {else}
                  {$LANG.musictracker_title|capitalize:true}
                {/if}
                </span></h2>
              </div>
          </div>
			{if $myobj->isShowPageBlock('form_show_sub_category')}
			{if $populateSubCategories_arr.row}
			{/if}
			<div id="selShowAllShoutouts" class="clsDataTable">
			<table id="selCategoryTable" class="clsSubCategoryTable">
			{foreach key=subCategoryItem item=subCategoryValue from=$populateSubCategories_arr.row}
			{$subCategoryValue.open_tr}
			<td id="selVideoGallery_{$subCategoryItem}" class="clsVideoCategoryCell">
				<div id="selImageDet">
				<h3>
					<div class="clsOverflow"><span class="clsViewThumbImage">
					<a href="{$subCategoryValue.music_tracker_url}">
					<img src="{$subCategoryValue.imageSrc}" /></a>
					</span></div>
					<a href="{$subCategoryValue.music_tracker_url}">
					{$subCategoryValue.music_category_name_manual}
					</a>
				</h3>
				</div>
			</td>
			{$subCategoryValue.end_tr}
			{foreachelse}
            {/foreach}
			</table>
			{/if}
          </form>
          <!--FORM End-->
          <div id="selLeftNavigation">
            <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
              <p id="msgConfirmText"></p>
              <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                      <div><p id="selImageBorder" class="clsPlainImageBorder">
                        <span id="selPlainCenterImage">
                          <img id="selVideoId" border="0" src=""/>
                        </span>
                      </p>
                    </div>
                  <input type="submit" class="clsSubmitButton" name="yes" value="{$LANG.common_yes_option}"
                  tabindex="{smartyTabIndex}" /> &nbsp;
                  <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_no_option}"
                  tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
                  <input type="hidden" name="act" id="act" />
                  <input type="hidden" name="music_id" id="music_id" />
              </form>
            </div>
            <div id="selMsgCartSuccess" class="clsPopupConfirmation" style="display:none;">
              <p id="selCartAlertSuccess"></p>
              <form name="msgCartFormSuccess" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_option_ok}"
                tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
              </form>
            </div>
            <div id="selMsgConfirmMulti" class="clsPopupConfirmation" style="display:none;">
              <p id="msgConfirmTextMulti">{$LANG.musictracker_multi_delete_confirmation}</p>
              <form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                <input type="submit" class="clsSubmitButton" name="yes" value="{$LANG.common_yes_option}"
                tabindex="{smartyTabIndex}" /> &nbsp;
                <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_no_option}"
                tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
                <input type="hidden" name="music_id" id="music_id" />
                <input type="hidden" name="act" id="act" />
              </form>
            </div>
            <form name="musicTrackerForm" id="musicTrackerForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
            <div id="selEditVideoComments" class="clsPopupConfirmation" style="display:none;"></div>
            <div class="clsSelectAllLinks clsOverflow">
              <p class="clsListCheckBox"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onClick="CheckAll(document.musicTrackerForm.name, document.musicTrackerForm.check_all.name)"/></p>
              <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" value="{$LANG.music_tracker_play}" onClick="getMultiCheckBoxValue('musicTrackerForm', 'check_all', '{$LANG.musicManage_err_tip_select_musics}');if(multiCheckValue!='') playInPlayListPlayer(multiCheckValue);"/></span></p>
              {if isMember()}
                      <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" value="{$LANG.music_tracker_add_to_playlist}" onClick="getMultiCheckBoxValue('musicTrackerForm', 'check_all', '{$LANG.musictracker_select_titles}');if(multiCheckValue!='')
                    managePlaylist(multiCheckValue, '{$myobj->savePlaylistUrl}', '{$LANG.common_create_playlist}');" /></span></p>
              {/if}
            </div>
            <div class="clsOverflow clsSortByLinksContainer">
              {if $myobj->isShowPageBlock("my_musics_form")}
                <div class="clsSortByPagination">
                      <div class="clsAudioPaging">
                        <div class="clsPagingList">
                          {if $CFG.admin.navigation.top}
								{$myobj->setTemplateFolder('general/','music')}
                                {include file=pagination.tpl}
                          {/if}
                        </div>
                      </div>
                </div>
            </div>
            <a href="#" id="{$myobj->my_musics_form.anchor}"></a>
			<div class="clsMusicTrackerMainBlock">
              {if $myobj->isResultsFound}
                      {assign var=count value=0}
                      {assign var=song_id value=1}
                      {foreach from=$music_list_result item=result key=inc name=music}
                      {if $smarty.foreach.music.iteration%$myobj->my_musics_form.showMusicTrackerList.musicsPerRow==1}
                      {/if}
                            <div class="clsListContents">
                                    <div class="clsOverflow">
                                      <p class="clsListCheckBox">
                                              <input type='checkbox' name='checkbox[]' id="checkbox[]" value="{$result.record.music_id}" onClick="disableHeading('musicTrackerForm');"/></p>
                                      <div class="clsThumb">
										<div class="clsLargeThumbImageBackground clsNoLink">
											  <a id="{$result.anchor}"></a>
											  {if $result.img_src}
												  <a  href="{$result.view_music_link}" class="ClsImageContainer ClsImageBorder1 Cls144x110"><img src="{$result.img_src}" {$myobj->DISP_IMAGE(142, 108, $result.record.thumb_width, $result.record.thumb_height)}/></a>
											  {else if $myobj->getFormField('pg')=="albumlist"}
											      <p class="ClsImageContainer ClsImageBorder1 Cls132x88"> <img src="{$album_music_count_list[$result.music_album_id].img_src}" {$myobj->DISP_IMAGE(142, 108, $album_music_count_list[$result.music_album_id].thumb_width, $album_music_count_list[$result.music_album_id].thumb_height)}/></p>
											  {/if}
										  </div>
                                      <div class="clsTime"><!---->{$result.playing_time}</div>
                                      </div>
                                      <div class="clsPlayerImage">
									   {if $myobj->populateRatingDetails($result.rating)}
                                            {$myobj->populateMusicRatingImages($result.rating,'music')}
                                        {else}
                                        	{$myobj->populateMusicRatingImages(0,'music')}
                                        {/if}
                                        <span>&nbsp; ( {$result.rating} )</span>
										<div class="clsPlayQuickmix">
                                          <div class="clsPlayerIcon">
                                          	<a class="clsPlaySong" id="play_music_icon_{$result.music_id}" onClick="playSelectedSong({$result.music_id})" href="javascript:void(0)"></a>
                                          	<a class="clsStopSong" id="play_playing_music_icon_{$result.music_id}" onClick="stopSong({$result.music_id})" style="display:none" href="javascript:void(0)"></a>                                        </div>
										</div>
										
										 
									  </div>

                                      <div class="clsContentDetails">
										<p class="clsHeading"><a  href="{$result.view_music_link}" title="{$result.record.music_title}" alt="{$result.record.music_title}" >{$result.record.music_title}</a></p>
                                        <p class="clsAlbumLink">{$LANG.album_title}: <a href="{$result.view_album_link}" title="{$result.record.album_title}">{$result.record.album_title}</a></p>
                                       
                                             <p class="clsLink">{$LANG.musictracker_artist}<a  href="{$result.artist_link}">{$myobj->getArtistLink($result.record.music_artist, true)}</a></p>
                                        
                                        <p class="clsGeneres">{$LANG.music_genre_in}<a  href="{$result.category_link}" title="{$result.record.music_category_name}">{$result.record.music_category_name}</a></p>
                                        
                                        </div>
										</div>
										<div>
										{literal}
                                    <script type="text/javascript">										
										$Jq(window).load(function(){
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
											<div class="clsMoreInfoContent">
												<div class="clsOverflow">
													<table>
                                                    
													<tr> 
                                                    {if $result.record.music_artist}
													<td>
														<span>{$LANG.artist_by}</span>
														 <span class="clsMoreInfodata"><a href="{$myobj->memberProfileUrl[$result.record.user_id]}">{$result.record.user_name}</a></span>
													</td>
                                                     {/if}
                                                     
													 <td>
													 <span>{$LANG.music_tracker_added_date}</span>
													  <span class="clsMoreInfodata">{$result.date_added}</span>
													</td>
													 </tr>
													 <tr>
													<td>
														<span>{$LANG.music_tracker_plays}</span>
														 <span class="clsMoreInfodata">{$result.record.total_plays}</span>
													  </td>
													  <td>
													  <span>{$LANG.music_tracker_commented}</span>
													 <span class="clsMoreInfodata">{$result.record.total_comments}</span>
													</td>
													 </tr>
													 <tr>
													<td>
														<span>{$LANG.music_tracker_favorite}</span>
														 <span class="clsMoreInfodata">{$result.record.total_favorites}</span>
													  </td>
													  <td>
													 <span>{$LANG.music_tracker_ratted}</span>
													  <span class="clsMoreInfodata">{$result.rating} ({$result.total_rating} {$LANG.musictracker_ratted})</span>
													</td>
													 </tr>
													<tr>
													<td>
														 <span>{$LANG.musictracker_music_listened} </span>
														  <span class="clsMoreInfodata">{$result.last_listened}</span>
													 </td>
													 <td>
														 <span>{$LANG.musictracker_language_list}</span>
														  <span class="clsMoreInfodata">{if $result.music_language_val}{$result.music_language_val}{else}{$LANG.common_not_available}{/if}</span>
													</td>
													 </tr>
													<tr>
                                                    	<td colspan="2">
                                                        	<span>{$LANG.musictracker_total_plays}</span>
													  		<span class="clsMoreInfodata">{$result.record.total_play_count}</span>
                                                        </td>
                                                    </tr>
												</table>
											  <p class="clsMoreinfoTags">{$LANG.music_tracker_tags}: {if $result.record.music_tags!=''}{$myobj->getMusicTagsLinks($result.record.music_tags,5)}{else}{$LANG.common_not_available}{/if}</p>
											   <p class="clsDescription"><span class="clsLabel">{$LANG.music_tracker_description}</span>: {if $myobj->getDescriptionForMusicTrackerList($result.record.music_caption)}{$myobj->getDescriptionForMusicTrackerList($result.record.music_caption)}{else}{$LANG.common_not_available}{/if}
											{foreach from=$getDescriptionLink_arr item=descriptionsValue}
												{$descriptionsValue.wordWrap_mb_ManualWithSpace_description_name}
											{/foreach}</p>
						
											</div>
										  </div>
                                    </div>
									
									</div>
               </div>
					{if $smarty.foreach.music.iteration%$myobj->my_musics_form.showMusicTrackerList.musicsPerRow==0}
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
              <div class="clsPagingList">
              <ul>
                {if $CFG.admin.navigation.bottom}
				{$myobj->setTemplateFolder('general/','music')}
                {include file=pagination.tpl}
                {/if}
              </ul>
              </div>
            </div>
                </form>
          </div>
		{$myobj->setTemplateFolder('general/', 'music')}
		{include file="box.tpl" opt="audioindex_bottom"}
</div>