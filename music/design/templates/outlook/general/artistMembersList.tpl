{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_top"}
<div id="musicArtistList" class="clsAudioListContainer clsArtistListContainer">
   <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}">
   <input type="hidden" name="advanceFromSubmission" value="1"/>
	<input type="hidden" name="start" value="1"/>
    <div class="clsOverflow">
      <div class="clsHeadingLeft">
        <h2><span>
            {if $myobj->page_heading != ''}
                {$myobj->page_heading}
            {else}
                {$LANG.musicArtistList_title}
            {/if}
            </span>
        </h2>
      </div>
   	{if $myobj->isShowPageBlock('search_artistlist_block')}
        <div class="clsHeadingRight" >

       		 </div>
             </div>
			 <div class="clsOverflow clsshowhidefiltersblock">
        	<div class="clsAdvancedFilterSearch clsOverflow clsFloatLeft">
                <a title="{$LANG.musicArtistList_show_advanced_filters}" onclick="divShowHide('advancedArtistlistSearch', 'show_link', 'hide_link')" class="clsShow"   id="show_link" href="javascript:void(0)"><span>{$LANG.musicArtistList_show_advanced_filters}</span></a>
                <a onclick="divShowHide('advancedArtistlistSearch', 'show_link', 'hide_link')" class="clsHide"  style="display:none" id="hide_link" href="javascript:void(0)"><span>{$LANG.musicArtistList_hide_advanced_filters}</span></a>
            </div>
			</div>
            <div id="advancedArtistlistSearch" class="clsAdvancedFilterTable clsOverflow" {if $myobj->chkAdvanceResultFound()}  style="display:block {else} style="display:none;  {/if}margin:10px 0;"  >
				<div class="clsAdvanceSearchIcon">
                <table class="">
                    <tr>
                        <td>
                            <input class="clsTextBox" type="text" name="artistlist_title" id="artistlist_title"   value="{if $myobj->getFormField('artistlist_title') == ''}{$LANG.musicArtistList_artistList_title}{else}{$myobj->getFormField('artistlist_title')}{/if}" onblur="setOldValue('artistlist_title')"  onfocus="clearValue('artistlist_title')"/>
                        </td>
						<td>
                            <input class="clsTextBox" type="text" name="album_title" id="album_title"   value="{if $myobj->getFormField('album_title') == ''}{$LANG.musicArtistList_album_title}{else}{$myobj->getFormField('album_title')}{/if}" onblur="setOldValue('album_title')"  onfocus="clearValue('album_title')"/>
                        </td>
                    </tr>
					  <tr>
                        <td>
                            <input class="clsTextBox" type="text" name="music_title" id="music_title"   value="{if $myobj->getFormField('music_title') == ''}{$LANG.musicArtistList_music_title}{else}{$myobj->getFormField('music_title')}{/if}" onblur="setOldValue('music_title')"  onfocus="clearValue('music_title')"/>
                        </td>
						<td>
                            <input class="clsTextBox" type="text" name="total_plays" id="total_plays"   value="{if $myobj->getFormField('total_plays') == ''}{$LANG.musicArtistList_total_plays}{else}{$myobj->getFormField('total_plays')}{/if}" onblur="setOldValue('total_plays')"  onfocus="clearValue('total_plays')"/>
                        </td>
                    </tr>
                </table>
				</div>
				<div class="clsAdvancedSearchBtn">
				<table>
				 <tr>
					<td>
						<div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="search" id="search" value="{$LANG.musicArtistList_search}" onclick="document.seachAdvancedFilter.start.value = '0';"/></span></div>
						  <div class="clsCancelButton1-l"><span class="clsCancelButton1-r"><input type="submit" value="Reset" id="avd_reset" name="avd_reset"/></span></div>
					</td>
				</tr>
				</table></div>
          </div>
        </form>
    {/if}

	{if $myobj->isShowPageBlock('list_artistlist_block')}
    	<div id="selmusicArtistListManageDisplay" class="clsLeftSideDisplayTable">
		    {if $myobj->isResultsFound()}
            	{if $CFG.admin.navigation.top}
                        <div class="clsOverflow clsSortByLinksContainer clsLinksBorder">
                        	<div class="clsAudioPaging">
							{$myobj->setTemplateFolder('general/','music')}
							{include file=pagination.tpl}
							</div>
                        </div>
                {/if}
                {foreach key=musicArtistListKey item=musicArtistList from=$myobj->list_artistlist_block.showArtistlists.row}
                    <div class="clsListContents clsLargeImageListContent">
                     <div class="clsOverflow">
                        <div class="clsThumb">
							<a href="{$musicArtistList.memberProfileUrl}" class="ClsImageContainer ClsImageBorder1 Cls90x90">
								<img src="{$musicArtistList.profileIcon.t_url}" alt="{$musicArtistList.record.artist_name}" title="{$musicArtistList.record.artist_name}"/>
							</a>
                         </div>
                        <div class="clsPlayerImage">
	                        <ul class="clsAdditionalLinks">
                                <li><a href="{$musicArtistList.getUrl_viewartist_url}">{if $musicArtistList.total_photos<=1}{$LANG.musicArtistList_manageartistphoto_label}{else} {$LANG.musicArtistList_manage_more_artistphoto_label} {/if}</a> ({$musicArtistList.total_photos})</li>
								<input type="hidden" name="music_artist_id" id="music_artist_id" value="{$musicArtistList.record.music_artist_id}" />

                            </ul>
                        </div>
                        <div class="clsContentDetails">
                            <p class="clsHeading" title="{$musicArtistList.record.artist_name}"><a href="{$musicArtistList.memberProfileUrl}">{$musicArtistList.wordWrap_mb_Manual_artist_name}</a>&nbsp;<a href="{$musicArtistList.getUrl_musiclist_url}">({if $musicArtistList.total_songs <=1}{$LANG.musicArtistList_song_label}{else}{$LANG.musicArtistList_songs_label}{/if}:&nbsp;{$musicArtistList.total_songs})</a></p>
                               {$myobj->displayArtistSongList($musicArtistList.record.music_artist_id, 3)}
                               {$myobj->setTemplateFolder('general/', 'music')}
                               {include file=artistMusicList.tpl}

                            <p>{if $musicArtistList.record.sum_plays<=1}{$LANG.musicArtistList_play_label}{else}{$LANG.musicArtistList_plays_label}{/if}:&nbsp;{$musicArtistList.record.sum_plays}</p>

                      </div>
                    </div>
                   </div>
                {/foreach}
          {if $CFG.admin.navigation.bottom}
                    <div id="bottomLinks">
                        <div class="clsAudioPaging">
						{$myobj->setTemplateFolder('general/','music')}
						{include file='pagination.tpl'}
						</div>
          </div>
                {/if}
             {else}
             	<div id="selMsgAlert">
             		<p>{$LANG.musicArtistList_no_records_found}</p>
          </div>
            {/if}
        </div>
    {/if}

</div>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_bottom"}