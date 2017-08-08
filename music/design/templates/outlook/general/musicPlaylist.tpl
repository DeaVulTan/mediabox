{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_top"}    
<div id="musicPlaylist" class="clsAudioPlayListContainer">
        <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}">
            {$myobj->populateMusicListHidden($paging_arr)}
            <div class="clsOverflow">                    
              <div class="clsHeadingLeft">  
                <h2>
                    {if $myobj->page_heading != ''}
                        {$myobj->page_heading}
                    {else}    
                        {$LANG.musicplaylist_title}
                    {/if}
                </h2>
              </div>
              <div class="clsHeadingRight">
                        <input type="hidden" name="default" id="default" value="{$myobj->getFormField('default')}" />
        		{if $myobj->isShowPageBlock('search_playlist_block')}
                        <select id="musicplaylistselect" onchange="loadUrl(this)">	
                        	<option value="{$myobj->getUrl('musicplaylist','?pg=playlistnew','playlistnew/','','music')}" {if $myobj->getFormField('pg')==''} selected {/if} >{$LANG.header_nav_music_music_all}</option>	
                            <option value="{$myobj->getUrl('musicplaylist', '?pg=playlistrecent', 'playlistrecent/','','music')}"
                                {if $myobj->getFormField('pg')=='playlistrecent'} selected {/if} >
                                {$LANG.header_nav_music_new}
                            </option>
                            <option value="{$myobj->getUrl('musicplaylist', '?pg=playlisttoprated', 'playlisttoprated/', '', 'music')}"
                                {if $myobj->getFormField('pg')=='playlisttoprated'} selected {/if} >
                                {$LANG.header_nav_music_top_rated}
                            </option>
                            <option value="{$myobj->getUrl('musicplaylist', '?pg=playlistrecommended', 'playlistrecommended/', '', 'music')}"
                                {if $myobj->getFormField('pg')=='playlistrecommended'} selected {/if} >
                                {$LANG.header_nav_music_most_recommended}
                            </option>
                            <option value="{$myobj->getUrl('musicplaylist', '?pg=playlistmostlistened', 'playlistmostlistened/', '', 'music')}"
                                {if $myobj->getFormField('pg')=='playlistmostlistened'} selected {/if} >
                                {$LANG.header_nav_most_listened}
                            </option>
                            <!--<option value="{$myobj->getUrl('musicplaylist', '?pg=playlistmostviewed', 'playlistmostviewed/', '', 'music')}"
                                {if $myobj->getFormField('pg')=='playlistmostviewed'} selected {/if} >
                                {$LANG.header_nav_most_viewed}
                            </option>-->
                            <option value="{$myobj->getUrl('musicplaylist', '?pg=playlistmostdiscussed', 'playlistmostdiscussed/', '', 'music')}"
                                {if $myobj->getFormField('pg')=='playlistmostdiscussed'} selected {/if} >
                                {$LANG.header_nav_music_most_discussed}
                            </option>
                            <option value="{$myobj->getUrl('musicplaylist', '?pg=playlistmostfavorite', 'playlistmostfavorite/', '', 'music')}"
                                {if $myobj->getFormField('pg')=='playlistmostfavorite'} selected {/if} >
                                {$LANG.header_nav_music_most_favorite}
                            </option>
                            <option value="{$myobj->getUrl('musicplaylist', '?pg=featuredplaylistlist', 'featuredplaylistlist/', '', 'music')}"
                                {if $myobj->getFormField('pg')=='featuredplaylistlist'} selected {/if} >
                                {$LANG.musicplaylist_heading_mostfeaturedmusiclist}
                            </option>
                             <option value="{$myobj->getUrl('musicplaylist', '?pg=playlistmostrecentlyviewed', 'playlistmostrecentlyviewed/', '', 'music')}"
                                {if $myobj->getFormField('pg')=='playlistmostrecentlyviewed'} selected {/if} >
                                {$LANG.header_nav_music_recently_viewed}
                            </option>
                        </select>
             	{/if}
              </div>
             </div>
            {if $myobj->getFormField('pg') == 'playlistmostviewed' or $myobj->getFormField('pg') == 'playlistmostdiscussed' or $myobj->getFormField('pg') == 'playlistmostfavorite' or $myobj->getFormField('pg') == 'playlistmostlistened'}
                <div class="clsAudioListMenu">
             		<ul>
                        <li {$musicActionNavigation_arr.cssli_0}>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_0}')"><span>{$LANG.header_nav_this_all_time}</span></a>
                        </li>
                        <li {$musicActionNavigation_arr.cssli_1}>	
							<a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_1}');"><span>{$LANG.header_nav_members_today}</span></a>
                        </li>
                        <li {$musicActionNavigation_arr.cssli_2}>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_2}');"><span>{$LANG.header_nav_members_yesterday}</span></a>
                        </li>
                        <li {$musicActionNavigation_arr.cssli_3}>
                       		<a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_3}');"><span>{$LANG.header_nav_members_this_week}</span></a>
                        </li>
                        <li {$musicActionNavigation_arr.cssli_4}>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_4}');"><span>{$LANG.header_nav_members_this_month}</span></a>
                        </li>
                        <li {$musicActionNavigation_arr.cssli_5}>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_5}');"><span>{$LANG.header_nav_members_this_year}</span></a>
                        </li>
                    </ul>
                </div>
                {literal}
					<script type="text/javascript">
						function jumpAndSubmitForm(url)
							{
								document.seachAdvancedFilter.start.value = '0';
								document.seachAdvancedFilter.action=url;
								document.seachAdvancedFilter.submit();										
							}
						var subMenuClassName1='clsActiveTabNavigation';
						var hoverElement1  = '.clsTabNavigation li';
						loadChangeClass(hoverElement1,subMenuClassName1);	
					</script>
                 {/literal}
            {/if}   
           <div class="clsOverflow clsAddMusicPlayListLinkHd"  >
        	<div class="clsAdvancedFilterSearch clsAdvancedFilterSearchAlignment">
                <a {if $myobj->chkAdvanceResultFound()}  style="display:none" {/if} onclick="divShowHide('advancedPlaylistSearch', 'show_link', 'hide_link')" class="clsShow"   id="show_link" href="javascript:void(0)"><span>{$LANG.musicplaylist_show_advanced_filters}</span></a>
                <a onclick="divShowHide('advancedPlaylistSearch', 'show_link', 'hide_link')" class="clsHide" {if !$myobj->chkAdvanceResultFound()}  style="display:none" {/if} id="hide_link" href="javascript:void(0)"><span>{$LANG.musicplaylist_hide_advanced_filters}</span></a>
                <a href="{php} echo getUrl('musicplaylist','?pg=playlistnew','playlistnew/','','music'){/php}" id="show_link" class="clsResetFilter">({$LANG.musicplaylist_reset_search})</a>
            </div>
           <div class="clsAddMusicPlayListLink">
            {if $myobj->isResultsFound()}		
				<p class="clsCancelButton-l"><span class="clsCancelButton-r">
					<a href="{$myobj->getUrl('musicplaylistmanage', '', '', 'members', 'music')}">{$LANG.musicplaylist_add_playlist}</a>							
					</span>
					</p>
            {/if}
            </div>
            </div>
            <div id="advancedPlaylistSearch" class="clsAdvancedFilterContainer" {if $myobj->chkAdvanceResultFound()}  style="display:block {else} style="display:none;  {/if}margin:10px 0;">
     			{$myobj->setTemplateFolder('general/', 'music')}
                {include file='box.tpl' opt='form_top'} 
                    <table class="clsAdvancedFilterTable">
                    <tr>
                        <td>
                            <input type="text" class="clsTextBox" name="playlist_title" id="playlist_title"   value="{if $myobj->getFormField('playlist_title') == ''}{$LANG.musicplaylist_playlist_title}{else}{$myobj->getFormField('playlist_title')}{/if}" onblur="setOldValue('playlist_title')"  onfocus="clearValue('playlist_title')"/>                   
                      </td>
                      <td>
                            <input type="text" class="clsTextBox" name="createby" id="createby" onfocus="clearValue('createby')"  onblur="setOldValue('createby')" value="{if $myobj->getFormField('createby') == ''}{$LANG.musicplaylist_createby}{else}{$myobj->getFormField('createby')}{/if}" />                    
                      </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="tracks" id="tracks">
			                  <option value="">{$LANG.musicplaylist_no_of_tracks}</option>
            			      {$myobj->generalPopulateArray($myobj->LANG_SEARCH_TRACK_ARR, $myobj->getFormField('tracks'))}
		                    </select>                                    
<!--                            <input type="text" class="clsTextBox" name="tracks" id="tracks" onfocus="clearValue('tracks')"  onblur="setOldValue('tracks')" value="{if $myobj->getFormField('tracks') == ''}{$LANG.musicplaylist_no_of_tracks}{else}{$myobj->getFormField('tracks')}{/if}"/>-->
                        </td>
                        <td>
                            <select name="plays" id="plays">
			                  <option value="">{$LANG.musicplaylist_no_of_plays}</option>
            			      {$myobj->generalPopulateArray($myobj->LANG_SEARCH_PLAY_ARR, $myobj->getFormField('plays'))}
		                    </select>                        
                           <!-- <input type="text" class="clsTextBox" name="plays" id="plays" onfocus="clearValue('plays')"  onblur="setOldValue('plays')" value="{if $myobj->getFormField('plays') == ''}{$LANG.musicplaylist_no_of_plays} {else}{$myobj->getFormField('plays')}{/if}" />   -->                 
                        </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                      <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="search" id="search" value="{$LANG.musicplaylist_search}" /></span></div>
                      <div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="submit" value="Reset" id="avd_reset" name="avd_reset"/></span></div>
                      </td>
                    </tr>
                    </table>
     			{$myobj->setTemplateFolder('general/', 'music')}
                {include file='box.tpl' opt='form_bottom'} 
            </div>
            <!--<input type="hidden" name="short_by_playlist" id="short_by_playlist" value="{$myobj->getFormField('short_by_playlist')}" />-->
        </form> 
    
   	
	{if $myobj->isShowPageBlock('list_playlist_block')}
    	<div id="selMusicPlaylistManageDisplay" class="clsPlaylistPageContents">
        {if $myobj->isResultsFound()}
            <div class="clsOverflow clsSortByLinksContainer">
                {*<div class="clsSortByLinks">
				<ul>
					<li>{$LANG.musicplaylist_short_by}</li>
					<li><a  href="javascript:void(0)"  onclick="shortOrder('title')"  {if $myobj->getFormField('short_by_playlist') == 'title'} class="clsActive" {/if}>{$LANG.musicplaylist_title_label}</a></li>
					<li> | </li>
					<li><a href="javascript:void(0)" onclick="shortOrder('song')" {if $myobj->getFormField('short_by_playlist') == 'song'} class="clsActive" {/if}>{$LANG.musicplaylist_song}</a>
					</li>
					</ul></div>*}
                    {if $CFG.admin.navigation.top}
                        <div class="clsSortByPagination">
                            <div class="clsAudioPaging">
								{$myobj->setTemplateFolder('general/','music')}
                                {include file=pagination.tpl}
                            </div>
                        </div>
                    {/if}
            </div>
            	<script language="javascript" type="text/javascript"> 
					original_height = new Array();
					original_width = new Array();
				</script>
				<div class="clsFavMusicplaylist">
				{assign var='array_count' value='1'} 
                {foreach key=musicPlaylistKey item=musicplaylist from=$myobj->list_playlist_block.showPlaylists.row}
                 <div class="clsListContents">
                     <div class="clsOverflow">
                     	<div class="clsThumb">
                     		<div class="clsMultipleImage clsPointer" onclick="Redirect2URL('{$musicplaylist.view_playlisturl}')" title="{$musicplaylist.record.playlist_name}">
                                {if $musicplaylist.getPlaylistImageDetail.total_record gt 0}
                                    {foreach key=playlistImageDetailKey item=playlistImageDetailValue from=$musicplaylist.getPlaylistImageDetail.row}
                                    	{literal}
                                       	<script language="javascript" type="text/javascript"> 
											original_height[{/literal}{$array_count}{literal}] = '{/literal}{$playlistImageDetailValue.record.thumb_height}{literal}';
											original_width[{/literal}{$array_count}{literal}]  = '{/literal}{$playlistImageDetailValue.record.thumb_width}{literal}';
									    </script>
                                       {/literal}
                                       <table><tr><td  >
                                       <img  id="t{$array_count}{$musicplaylist.record.playlist_id}" style="position:;z-index:999;display:none;" src="{$playlistImageDetailValue.playlist_thumb_path}" onmouseout="playlistImageZoom('Shrink', 's{$array_count}{$musicplaylist.record.playlist_id}', 't{$array_count}{$musicplaylist.record.playlist_id}', {$array_count}); return false;"/>
                                       <img  id="s{$array_count}{$musicplaylist.record.playlist_id}" src="{$playlistImageDetailValue.playlist_path}" />
                                       </td></tr></table>
                                       {assign var=array_count value=$array_count+1}
                                    {/foreach}
                                    {if $musicplaylist.getPlaylistImageDetail.total_record lt 4}
                                        {section name=foo start=0 loop=$musicplaylist.getPlaylistImageDetail.noimageCount step=1}
                                            <table><tr><td><img  width="65" height="44" src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_S.jpg" /></td></tr></table>
                                        {/section}	
                                    {/if}
                                {else}    
                                    <div class="clsSingleImage"><img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" /></div>
                                {/if}    
                        </div>
                        </div>
                         <div class="clsPlayerImage">
                                <div class="clsPlayerIcon" >
                                    <a class="clsPlaySong" id="play_music_icon_{$musicplaylist.record.playlist_id}" onClick="playlistInPlayListPlayer('{$musicplaylist.record.playlist_id}')" href="javascript:void(0)" title="{$LANG.musicplaylist_playallsong_helptips}"></a>
                                    <a class="clsStopSong" id="play_playing_music_icon_{$musicplaylist.record.playlist_id}" onClick="stopSong({$musicplaylist.record.playlist_id})" style="display:none" href="javascript:void(0)" title="{$LANG.musicplaylist_stop_helptips}"></a>                                        
                                </div>
                                <p class="clsSongListLink"><a href="#" id="musicplaylist_light_window_{$musicplaylist.record.playlist_id}">{$LANG.musicplaylist_song_list}</a></p>
                                {* Added code to display fancy box *}
								<script type="text/javascript">
                                {literal}
                                $Jq(window).load(function() {
                                    $Jq('#musicplaylist_light_window_{/literal}{$musicplaylist.record.playlist_id}{literal}').fancybox({
                                        'width'				: 550,
                                        'height'			: 350,
                                        'autoScale'     	: false,
                                        'href'              : '{/literal}{$musicplaylist.light_window_url}{literal}',
                                        'transitionIn'		: 'none',
                                        'transitionOut'		: 'none',
                                        'type'				: 'iframe'
                                    });
                                });
                                {/literal}
                                </script>  
								
								 {*<div class="clsMoreInfoContainer clsOverflow">
                        <div class="clsMoreInformation">
                        	<p>
                            	<a  id="moreInfoPlaylist_ahref_{$musicplaylist.record.playlist_id}"  href="javascript:void(0)"  onclick="moreInformation('moreInfoPlaylist_{$musicplaylist.record.playlist_id}')">
                                	<span>{$LANG.musicplaylist_more_info}</span>
                                </a>
                            </p>
                        </div>
                     </div>*}
					                 
                                                      
                         </div>
                        <div class="clsContentDetails">
                            <p class="clsHeading"><a href="{$musicplaylist.view_playlisturl}" title="{$musicplaylist.record.playlist_name}">{$musicplaylist.wordWrap_mb_ManualWithSpace_playlist_title}</a> 
							</p>
							<p>
								<span>({if $musicplaylist.record.total_tracks<=1}{$LANG.musicplaylist_track}{else}{$LANG.musicplaylist_tracks}{/if}:&nbsp;{$musicplaylist.record.total_tracks}{if $musicplaylist.private_song gt 0}&nbsp;|&nbsp;{$LANG.musicplaylist_private_label}:&nbsp;{$musicplaylist.private_song}{/if})</span>
							</p>
							
							{if $myobj->isShowPageBlock('songlist_block')}
							<p>
                            {*DISPLAY SONGS IN PLAYLIST STARTS HERE*}
                                  {$myobj->displaySongList($musicplaylist.record.playlist_id, true, 3)}
                                  {$myobj->setTemplateFolder('general/', 'music')}
	                            {include file=songList.tpl}                                  
                            {*DISPLAY SONGS IN PLAYLIST ENDS HERE*}    
							</p>                                                    
							{/if}
                             {if $musicplaylist.record.allow_ratings == 'Yes'}         
                                 <p>
                                    {$myobj->populateMusicRatingImages($musicplaylist.record.rating, 'audio', '', '', 'music')}
                                </p>
                             {/if}
                         </div>
						 </div>
						 <div>
						  {literal}
					<script type="text/javascript">										
						$Jq(window).load(function(){
							$Jq("#trigger_{/literal}{$musicplaylist.record.playlist_id}{literal}").click(function(){
								displayMusicMoreInfo('{/literal}{$musicplaylist.record.playlist_id}{literal}');
								return false;
							});
						});										
					</script>
                    {/literal}
					 <div class="clsMoreInfoContainer clsOverflow">
						  <a  id="trigger_{$musicplaylist.record.playlist_id}" class="clsMoreInformation" href="javascript:void(0)"  onclick="moreInformation('moreInfoPlaylist_{$musicplaylist.record.playlist_id}')">
                                	<span>{$LANG.musicplaylist_more_info}</span>
                          </a>
					</div>            
						 <div class="clsMoreInfoBlock" id="panel_{$musicplaylist.record.playlist_id}" style="display:none;" >
								<div class="clsMoreInfoContent">
								<div class="clsOverflow">
										 <table>
												<tr>
													<td>
														<span>{$LANG.musicplaylist_postby}</span>
														<span class="clsMoreInfodata"><a href="{$musicplaylist.getMemberProfileUrl}">{$musicplaylist.record.user_name}</a></span>
													</td>
													<td>
														<span>{$LANG.musicplaylist_added}</span>
														<span class="clsMoreInfodata">{$musicplaylist.record.date_added}</span>
													</td>
												</tr>
												<tr>
													<td>
														<span>{$LANG.musicplaylist_plays}</span>
														<span class="clsMoreInfodata">{$musicplaylist.record.total_views}</span>
													</td>
													<td>
														<span>{$LANG.musicplaylist_comments}</span>
														<span class="clsMoreInfodata">{$musicplaylist.record.total_comments}</span>
													</td>
												</tr>
												<tr>
												<td>
													<span>{$LANG.musicplaylist_favorites}</span>
													<span class="clsMoreInfodata">{$musicplaylist.record.total_favorites}</span>
												</td> 
												<td>
													{if $musicplaylist.record.allow_ratings == 'Yes'}  
														<span>{$LANG.musicplaylist_rated_label}</span> 
														<span class="clsMoreInfodata">{$musicplaylist.record.rating_count}</span>
													{/if}
												</td>
												</tr>
												</table>
											   
										 </div>
										 {if $myobj->getFormField('tags') != '' }
												{assign var=music_tag value=$myobj->getFormField('tags')}
											{else}
												{assign var=music_tag value=''}
											{/if}
										 <p class="clsMoreinfoTags">{$LANG.musicplaylist_tags_label} {if $musicplaylist.record.playlist_tags || $music_tag}{$myobj->getTagsLinkForPlaylist($musicplaylist.record.playlist_tags,5,$musicplaylist.record.playlist_id,$music_tag)}{else}{$LANG.common_not_available}{/if}</p>
										<p title="{$musicplaylist.wordWrap_mb_ManualWithSpace_playlist_description}" class="clsDescription"><span class="clsLabel">{$LANG.musicplaylist_description_label}</span> {if $musicplaylist.wordWrap_mb_ManualWithSpace_playlist_description}{$musicplaylist.wordWrap_mb_ManualWithSpace_playlist_description}{else}{$LANG.common_not_available}{/if}</p>
									 </div>  
					 </div>  
                  </div>
                 </div>
				 
                {/foreach} 
				</div>
              {if $CFG.admin.navigation.bottom}
                    <div id="bottomLinks" class="clsAudioPaging">
						{$myobj->setTemplateFolder('general/','music')}
                        {include file='pagination.tpl'}
                    </div>
                {/if}  
             {else}   
             	<div id="selMsgAlert">
             		<p>{$LANG.musicplaylist_no_records_found}</p>
                </div>    
            {/if}    
        </div>
    {/if}
</div>
{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_bottom"}    
