<div id="musicPlaylist">
    <h2>
    	{*<!--{if $myobj->page_heading != ''}
        	{$myobj->page_heading}
        {else}
        	{$LANG.musicplaylist_title}
        {/if}--> *}
        {$LANG.musicplaylist_manage_playlist}
  </h2>
   <!-- information div -->
    {$myobj->setTemplateFolder('admin')}
    	{include file='information.tpl'}
    <br />
   	{if $myobj->isShowPageBlock('search_playlist_block')}

        <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}">
        	{*<!--<div class="clsVideoListHeadingRight" >
                <select onchange="loadUrl(this)">
                    <option value="{$myobj->getUrl('musicplaylist', '?pg=playlistnew', 'playlistnew/','','music')}"
                        {if $myobj->getFormField('pg')=='playlistnew'} selected {/if} >
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
                    <option value="{$myobj->getUrl('musicplaylist', '?pg=playlistmostviewed', 'playlistmostviewed/', '', 'music')}"
                        {if $myobj->getFormField('pg')=='playlistmostviewed'} selected {/if} >
                        {$LANG.header_nav_most_viewed}
                    </option>
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
       		 </div>
            {if $myobj->getFormField('pg') == 'playlistmostviewed' or $myobj->getFormField('pg') == 'playlistmostdiscussed' or $myobj->getFormField('pg') == 'playlistmostfavorite' or $myobj->getFormField('pg') == 'playlistmostlistened'}
                <div class="clsTabNavigation">
             		<ul>
                        <li {$musicActionNavigation_arr.cssli_0}>
                        	<span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_0}')">{$LANG.common_search_all_time}</a></span>
                        </li>
                        <li {$musicActionNavigation_arr.cssli_1}>
							<span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_1}');">{$LANG.header_nav_members_today}</a></span>
                        </li>
                        <li {$musicActionNavigation_arr.cssli_2}>
                        	<span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_2}');">{$LANG.header_nav_members_yesterday}</a></span>
                        </li>
                        <li {$musicActionNavigation_arr.cssli_3}>
                       		<span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_3}');">{$LANG.header_nav_members_this_week}</a></span>
                        </li>
                        <li {$musicActionNavigation_arr.cssli_4}>
                        	<span><a href="javascript:void(0);" onclick="jumpAndSubmitForm('{$musicActionNavigation_arr.music_list_url_4}');">{$LANG.header_nav_members_this_month}</a></span>
                        </li>
                        <li {$musicActionNavigation_arr.cssli_5}>
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
            {/if}
              -->*}
			<a onclick="divShowHide('advancedPlaylistSearch', 'show_link', 'hide_link')"  style="display:none" id="show_link" href="javascript:void(0)">{$LANG.musicplaylist_show_advanced_filters}</a>
            <a onclick="divShowHide('advancedPlaylistSearch', 'show_link', 'hide_link')"   id="hide_link" href="javascript:void(0)">{$LANG.musicplaylist_hide_advanced_filters}</a>
            <div id="advancedPlaylistSearch" >
                    <table class="clsNoBorder" >
                    <tr>
						<td class="clsWidthSmall clsFormLabelCellDefault">
							<label>{$LANG.musicplaylist_playlist_title}</label>
						</td>
                        <td class="clsFormFieldCellDefault">
                            <input type="text" name="playlist_title" id="playlist_title"   value="{if $myobj->getFormField('playlist_title') == ''}{$LANG.musicplaylist_playlist_title}{else}{$myobj->getFormField('playlist_title')}{/if}" onblur="setOldValue('playlist_title')"  onfocus="clearValue('playlist_title')" class="clsTextBox"/>
                      </td>
					</tr>
					<tr>
						<td class="clsWidthSmall clsFormLabelCellDefault">
							<label>{$LANG.musicplaylist_createby}</label>
						</td>
                      <td class="clsFormFieldCellDefault">
                            <input type="text" name="createby" id="createby" onfocus="clearValue('createby')"  onblur="setOldValue('createby')" value="{if $myobj->getFormField('createby') == ''}{$LANG.musicplaylist_createby}{else}{$myobj->getFormField('createby')}{/if}" class="clsTextBox" />
                      </td>
                    </tr>
                    <tr>
						<td class="clsWidthSmall clsFormLabelCellDefault">
							<label>{$LANG.musicplaylist_no_of_tracks}</label>
						</td>
                        <td class="clsFormFieldCellDefault">
                            <input type="text" name="tracks" id="tracks" onfocus="clearValue('tracks')"  onblur="setOldValue('tracks')" value="{if $myobj->getFormField('tracks') == ''}{$LANG.musicplaylist_no_of_tracks}{else}{$myobj->getFormField('tracks')}{/if}" class="clsTextBox" />
                        </td>
					</tr>
					<tr>
						<td class="clsWidthSmall clsFormLabelCellDefault">
							<label>{$LANG.musicplaylist_no_of_plays}</label>
						</td>
                        <td class="clsFormFieldCellDefault">
                            <input type="text" name="plays" id="plays" onfocus="clearValue('plays')"  onblur="setOldValue('plays')" value="{if $myobj->getFormField('plays') == ''}{$LANG.musicplaylist_no_of_plays} {else}{$myobj->getFormField('plays')}{/if}" class="clsTextBox" />
                        </td>
                    </tr>
                    <tr>
                    <td><input type="submit" name="search" id="search" value="{$LANG.musicplaylist_search}" class="clsSubmitButton" />
                      <input type="submit" value="Reset" id="avd_reset" name="avd_reset" class="clsSubmitButton"/>
                      </td>
                    </tr>
                    </table>
            </div>
        </form>
    {/if}
   <!-- Single confirmation box -->
        <div id="selMsgConfirmSingle" class="clsPopupConfirmation" style="display:none;">
            <p id="confirmMessageSingle"></p>
            <form name="msgConfirmformSingle" id="msgConfirmformSingle" method="post" action="{$myobj->getCurrentUrl(true)}">
                <table summary="{$LANG.musicplaylist_admin_conform_box}" class="clsNoBorder">
                    <tr>
                        <td>
                            <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
                            &nbsp;
                            <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
                            <input type="hidden" name="playlist_id" id="playlist_id" />
                            <input type="hidden" name="featured" id="featured" />
                            <input type="hidden" name="confirm" id="confirm" />
                            {$myobj->populateHidden($myobj->hidden_array)}
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <!-- confirmation box-->
	{if $myobj->isShowPageBlock('list_playlist_block')}
    	<div id="selMusicPlaylistManageDisplay" class="clsLeftSideDisplayTable">
    	{*Commented the Crate playlist link as per Ticket #26 in collab*}
		<!--
            <div>
                <p><a href="{$CFG.site.url}admin/music/musicPlaylistManage.php">{$LANG.musicplaylist_create_playlist_label}</a></p>
            </div>-->
		    {if $myobj->isResultsFound()}
            	{if $CFG.admin.navigation.top}
                        {$myobj->setTemplateFolder('admin')}
                        {include file=pagination.tpl}
                {/if}

                    <table>
                    <th>{$LANG.musicplaylist_image}</th>
                    <th>{$LANG.musicplaylist_name}</th>
                    <th>{$LANG.musicplaylist_totla_music}</th>
                    <th colspan="4" class="clsUserActionTh">{$LANG.musicplaylist_user_action}</th>
					{foreach key=musicPlaylistKey item=musicplaylist from=$myobj->list_playlist_block.showPlaylists.row}
                      <tr>
                        <td class="clsSmallWidth">

                        	<div class="clsMultipleImage clsPointer" onclick="Redirect2URL('{$musicplaylist.view_playlisturl}')" title="{$musicplaylist.record.playlist_name}">
                                {if $musicplaylist.getPlaylistImageDetail.total_record gt 0}
                                    {foreach key=playlistImageDetailKey item=playlistImageDetailValue from=$musicplaylist.getPlaylistImageDetail.row}
                                       <table><tr><td><img src="{$playlistImageDetailValue.playlist_path}"/></td></tr></table>
                                    {/foreach}
                                    {if $musicplaylist.getPlaylistImageDetail.total_record lt 4}
                                        {section name=foo start=0 loop=$musicplaylist.getPlaylistImageDetail.noimageCount step=1}
                                            <table><tr><td><img  width="65" height="44" src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/admin/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_S.jpg" /></td></tr></table>
                                        {/section}
                                    {/if}
                                {else}
                                    <div class="clsSingleImage"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/admin/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" /></div>
                                {/if}
                        </div>
                        </td>
                        <td>
                            <p><a href="{$musicplaylist.view_playlisturl}" target="_blank">{$musicplaylist.record.playlist_name}</a> ({$musicplaylist.record.total_tracks} {$LANG.musicplaylist_tracks} {if $musicplaylist.private_song gt 0} - {$LANG.musicplaylist_private_label}: {$musicplaylist.private_song}{/if})</p>
                            <p>{$LANG.musicplaylist_postby}<a href="{$musicplaylist.getMemberProfileUrl}">{$musicplaylist.record.user_name}</a></p>
                            <p><a id="play_music_icon_{$musicplaylist.record.playlist_id}" onClick="playlistInPlayListPlayer('{$musicplaylist.record.playlist_id}')" href="javascript:void(0)" title="{$LANG.musicplaylist_playallsong_helptips}">{$LANG.musicplaylist_playall_label}</a> </p>
                             <p><a href="{$musicplaylist.view_playlisturl}">{$LANG.musicplaylist_admin_view_song}</a> </p>
                        </td>
                        <td class="clsSmallWidth">
                            <p>{$LANG.musicplaylist_plays} {$musicplaylist.record.total_views}</p>
                            <p>{$LANG.musicplaylist_comments} {$musicplaylist.record.total_comments}</p>
                            <p>{$LANG.musicplaylist_favorites} {$musicplaylist.record.total_favorites}</p>
                            <p>{$LANG.musicplaylist_featured} {$musicplaylist.record.total_featured}   </p >                        </td>
                        <td class="clsSmallWidth">
                        {*Commented the Crate playlist link as per Ticket #26 in collab*}
                        	<!--<p>
                            	<a href="{$CFG.site.url}admin/music/musicPlaylistManage.php?playlist_id={$musicplaylist.record.playlist_id}" >{$LANG.musicplaylist_edit_label}</a>
                            </p>
                        	<p>
                            {if	$musicplaylist.record.featured == 'Yes'}
	                      		<a href="javascript:void(0)"  onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('confirm', 'playlist_id', 'featured', 'confirmMessageSingle'), Array('featured', '{$musicplaylist.record.playlist_id}', 'No', '{$LANG.musicplaylist_admin_remove_featured}'), Array('value', 'value', 'value', 'innerHTML'), -100, -500);" >{$LANG.musicplaylist_remove_featured}</a>
            				{else}
                              <a href="javascript:void(0)"  onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('confirm', 'playlist_id', 'featured', 'confirmMessageSingle'), Array('featured', '{$musicplaylist.record.playlist_id}', 'Yes', '{$LANG.musicplaylist_admin_set_featured}'), Array('value', 'value', 'value', 'innerHTML'), -100, -500);" >{$LANG.musicplaylist_set_featured}</a>
                            {/if}
                           </p>-->
                         <p><a href="javascript:void(0)" onclick="popupWindow('{$CFG.site.url}admin/music/managePlaylistComments.php?playlist_id={$musicplaylist.record.playlist_id}')" title="{$LANG.musicplaylist_manage_playlist_comment}">{$LANG.musicplaylist_manage_comment}({$musicplaylist.record.total_comments})</a></p>
                        </td>
                      </tr>
               		 {/foreach}
          			</table>

              {if $CFG.admin.navigation.bottom}
                    <div id="bottomLinks">
                        {include file='pagination.tpl'}
                    </div>
                {/if}
             {else}
             	<div id="selMsgAlert">
             		{$LANG.musicplaylist_no_records_found}
                </div>
            {/if}
        </div>
    {/if}
</div>