{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="sidebar_top"}
{if $opt == 'music'}
     <div class="clsAudioIndex clsCategoryHd clsIndexMyMusicContainer">
            <h3>{$LANG.sidebar_mymusic_dashboard_label}</h3>
            <ul class="clsOverflow" >
              {assign var=css_temp value=''}
                {if $flag}
                    {assign var=css_temp value=$myobj->_currentPage|cat:'_'|cat:$myobj->getFormField('pg')}
                {/if}
                {*CHECKED THE CONDITION IF ALLOWED THE MUSIC UPLOAD FOR FAN MEMBER*}
                {if isAllowedMusicUpload()}
                <li class="{$myobj->getMusicNavClass('left_musicuploadpopup')}" ><a  class="clsUploadOptionLink" href="{$myobj->getUrl('musicuploadpopup', '', '', 'members', 'music')}">{$LANG.sidebar_uploadaudio_label}</a></li>
				{/if}
                {*CHECKED THE CONDITION IF ALLOWED THE MUSIC UPLOAD FOR FAN MEMBER*}
				<li class="
                {if $myobj->_currentPage ==  'managemusiccomments'}
                	{$myobj->getMusicNavClass('left_managemusiccomments')}
                {elseif $css_temp ==  'musiclist_mymusics'}
                	{$myobj->getMusicNavClass('left_musiclist_mymusics')}
                {elseif $css_temp ==  'musiclist_myfavoritemusics'}
                	{$myobj->getMusicNavClass('left_musiclist_myfavoritemusics')}
                {elseif $myobj->_currentPage ==  'mymusictracker'}
                	{$myobj->getMusicNavClass('left_mymusictracker')}
                {elseif $myobj->_currentPage ==  'manageartistphoto'}
                	{$myobj->getMusicNavClass('left_manageartistphoto')}
                {/if} " >
                	{assign var=music_count value=1}


					<div class="clsOverflow">
                            <span class="clsTDLinks clsSidelinkLeft">
                            {*CHECKED THE CONDITION IF ALLOWED THE MUSIC UPLOAD FOR FAN MEMBER*}
                			{if isAllowedMusicUpload()}
								<a  href="{$myobj->getUrl('musiclist', '?pg=mymusics', 'mymusics/', 'members', 'music')}" onclick=""> {$LANG.sidebar_music_label} </a>
                            {else}
                            	<a  href="{$myobj->getUrl('musiclist', '?pg=myfavoritemusics', 'myfavoritemusics/', 'members', 'music')}" onclick="" title="{$LANG.sidebar_music_label}">{$LANG.sidebar_music_label}</a>
                            {/if}
							</span>
								<span class="clsSidelinkRight">
							<a {if $myobj->_currentPage == 'managemusiccomments' || $css_temp == 'musiclist_mymusics' || $css_temp == 'musiclist_myfavoritemusics' || $myobj->_currentPage == 'mymusictracker' || $myobj->_currentPage == 'manageartistphoto'} class="clsHideSubmenuLinks" {else} class="clsShowSubmenuLinks"{/if} href="javascript:void(0)" id="mainMusicID{$music_count}" onclick="showHideMenu('ancPlaylist', 'subMusicID','1','{$music_count}', 'mainMusicID')">{$LANG.sidebar_show_label}</a>
                            </span>
                       </div>
                    <ul  id="subMusicID{$music_count}" {if $myobj->_currentPage == 'managemusiccomments' || $css_temp == 'musiclist_mymusics' || $css_temp == 'musiclist_myfavoritemusics' || $myobj->_currentPage == 'mymusictracker' || $myobj->_currentPage == 'manageartistphoto'}style="display:block;"{else}style="display:none;"{/if}>
                        {*CHECKED THE CONDITION IF ALLOWED THE MUSIC UPLOAD FOR FAN MEMBER*}
                		{if isAllowedMusicUpload()}
							<li class="{$myobj->getMusicNavClass('left_musiclist_mymusics')}"><a title="{$LANG.sidebar_music_label}" href="{$myobj->getUrl('musiclist', '?pg=mymusics', 'mymusics/', 'members', 'music')}">{$LANG.sidebar_music_label}  </a></li>
	                        <li class="{$myobj->getMusicNavClass('left_managemusiccomments')}"><a title="{$LANG.sidebar_music_comments_label} " href="{$myobj->getUrl('managemusiccomments', '', '', 'members', 'music')}">{$LANG.sidebar_music_comments_label}  </a></li>
                        {/if}
						<li class="{$myobj->getMusicNavClass('left_musiclist_myfavoritemusics')}" ><a title="{$LANG.sidebar_favourite_label}" href="{$myobj->getUrl('musiclist', '?pg=myfavoritemusics', 'myfavoritemusics/', 'members', 'music')}">{$LANG.sidebar_favourite_label}</a></li>
                        {if isMember()}
							<li class="{$myobj->getMusicNavClass('left_mymusictracker')}"><a title="{$LANG.sidebar_music_viewing_histry_label} " href="{$myobj->getUrl('mymusictracker', '', '', '', 'music')}">{$LANG.sidebar_music_viewing_histry_label} </a></li>
                    	{/if}
                    	{if checkValidArtist() and $CFG.admin.musics.music_artist_feature}
       	            	<li class="{$myobj->getMusicNavClass('left_manageartistphoto')}"><a href="{$populateMemberDetail_arr.artist_member_url}">{$LANG.sidebar_manage_artist_link_label} </a></li>
                    	{/if}
					</ul>
                </li>
                {*CHECKED THE CONDITION IF ALLOWED THE MUSIC UPLOAD FOR FAN MEMBER*}
                {if isAllowedMusicUpload()}
                {* MY ALBUMS BLOCK STARTS *}
                <li class="{if $myobj->_currentPage == 'musicalbummanage'}
                				{$myobj->getMusicNavClass('left_musicalbummanage')}
                           {else}
                           		{$myobj->getMusicNavClass('left_albumlist_myalbums')}
                           {/if}">{assign var=album_count value=1}
              <div class="clsOverflow">
                            <span class="clsTDLinks clsSidelinkLeft">
                        <a  href="{$myobj->getUrl('albumlist', '?pg=myalbums', 'myalbums/', 'members', 'music')}" title="{$LANG.sidebar_album_manage_label}">{$LANG.sidebar_album_manage_label} </a>
                       </span>
                        <span class="clsSidelinkRight">
                            <a id="ancAlbum{$album_count}"  class="" title=""></a>

                              <a {if $css_temp == 'albumlist_myalbums' || $css_temp == 'musicalbummanage'} class="clsHideSubmenuLinks" {else} class="clsShowSubmenuLinks" {/if} href="javascript:void(0)" id="mainAlbumID{$album_count}" onclick="showHideMenu('ancAlbum', 'subAlbumID', '1', 'album_count', 'mainAlbumID') " title="$LANG.sidebar_show_label}">{$LANG.sidebar_show_label}</a>
                        </span>
                    </div>
                        <ul id="subAlbumID{$album_count}" {if $css_temp == 'albumlist_myalbums' || $myobj->_currentPage == 'musicalbummanage'}style="display:block;"{else}style="display:none;"{/if}>
                            <li class="{$myobj->getMusicNavClass('left_albumlist_myalbums')}" ><a title="{$LANG.sidebar_album_label}"  href="{$myobj->getUrl('albumlist', '?pg=myalbums', 'myalbums/', 'members', 'music')}">{$LANG.sidebar_album_label}</a></li>
                            <li class="{$myobj->getMusicNavClass('left_musicalbummanage')}" ><a title="{$LANG.sidebar_music_my_album_manage_label}"  href="{$myobj->getUrl('musicalbummanage', '', '', 'members', 'music')}">{$LANG.sidebar_music_my_album_manage_label}</a></li>
                        </ul>

				</li>
				{/if}
				<li class="{if $myobj->_currentPage ==  'musicplaylistmanage'} {$myobj->getMusicNavClass('left_musicplaylistmanage')}
                {elseif $myobj->_currentPage ==  'manageplaylistcomments'} {$myobj->getMusicNavClass('left_manageplaylistcomments')}
                {elseif $css_temp ==  'musicplaylist_myfavoriteplaylist'} {$myobj->getMusicNavClass('left_musicplaylist_myfavoriteplaylist')}

                {elseif $css_temp ==  'musicplaylist_myplaylist'}{$myobj->getMusicNavClass('left_musicplaylist_myplaylist')}{/if}">
                {assign var=playlist_count value=1}
               <div class="clsOverflow">
                            <span class="clsTDLinks clsSidelinkLeft">
                        <a href="{$myobj->getUrl('musicplaylist', '?pg=myplaylist', 'myplaylist/', 'members', 'music')}" title="{$LANG.sidebar_myplaylist_label}">{$LANG.sidebar_myplaylist_label} </a>
                       </span>
                       <span class="clsSidelinkRight">
                            <a id="ancPlaylist{$playlist_count}" title=""></a>
                            <a {if $myobj->_currentPage == 'musicplaylistmanage' || $myobj->_currentPage == 'manageplaylistcomments' || $css_temp == 'musicplaylist_myfavoriteplaylist'} class="clsHideSubmenuLinks" {else} class="clsShowSubmenuLinks"{/if} href="javascript:void(0)" id="mainPlaylistID{$playlist_count}" onclick="showHideMenu('ancPlaylist', 'subPlaylistID','1','{$playlist_count}', 'mainPlaylistID')">{$LANG.sidebar_show_label}</a>
                       </span>
                    </div>
                    <ul  id="subPlaylistID{$playlist_count}" {if $myobj->_currentPage == 'musicplaylistmanage' || $myobj->_currentPage == 'manageplaylistcomments' || $css_temp == 'musicplaylist_myfavoriteplaylist'}style="display:block;"{else}style="display:none;"{/if}>
                        <li class="{$myobj->getMusicNavClass('left_musicplaylistmanage')}"><a title="{$LANG.sidebar_music_manageplaylist_label}" href="{$myobj->getUrl('musicplaylistmanage', '', '', 'members', 'music')}">{$LANG.sidebar_music_manageplaylist_label} </a></li>
                        <li class="{$myobj->getMusicNavClass('left_manageplaylistcomments')}"><a title="{$LANG.sidebar_music_playlist_comments_label}" href="{$myobj->getUrl('manageplaylistcomments', '', '', 'members', 'music')}">{$LANG.sidebar_music_playlist_comments_label} </a></li>
						{if isMember() && $myobj->getMyFeaturedPlaylist($CFG.user.user_id)}
							<li class="{$myobj->getMusicNavClass('left_viewplaylist')}"><a title="{$LANG.sidebar_myfeaturedplaylist_label}" href="{$myobj->getMyFeaturedPlaylist($CFG.user.user_id)}">{$LANG.sidebar_myfeaturedplaylist_label} </a></li>
						{/if}
						<li class="{$myobj->getMusicNavClass('left_musicplaylist_myfavoriteplaylist')}" ><a title="{$LANG.sidebar_favourite_label}"  href="{$myobj->getUrl('musicplaylist', '?pg=myfavoriteplaylist', 'myfavoriteplaylist/', 'members', 'music')}">{$LANG.sidebar_favourite_label}</a></li>
                    </ul>
                </li>
               
				{if isMember()}
					 <!--li class="{$myobj->getMusicNavClass('left_mymusictracker_musictracker')}"><a href="{$myobj->getUrl('mymusictracker', '?pg=musictracker', 'musictracker/', '', 'music')}">{$LANG.sidebar_viewing_histry_label} </a></li-->
					 {*CHECKED THE CONDITION IF ALLOWED THE MUSIC UPLOAD FOR FAN MEMBER*}
                     {if isAllowedMusicUpload()}
						 <li class="{$myobj->getMusicNavClass('left_musicdefaultsettings')}"><a title="{$LANG.sidebar_music_default_settings_label}" href="{$myobj->getUrl('musicdefaultsettings', '', '', '', 'music')}">{$LANG.sidebar_music_default_settings_label} </a></li>
						 {if isset($CFG.admin.musics.allowed_usertypes_to_upload_for_sale) and $CFG.admin.musics.allowed_usertypes_to_upload_for_sale!= 'None'}
						 	<li class="{$myobj->getMusicNavClass('left_transactionlist')}"><a title="{$LANG.sidebar_transaction_list_label}" href="{$myobj->getUrl('transactionlist', '', '', 'members', 'music')}">{$LANG.sidebar_transaction_list_label} </a></li>
						 {/if}
					 {/if}
					 {if isset($CFG.admin.musics.allowed_usertypes_to_upload_for_sale) and $CFG.admin.musics.allowed_usertypes_to_upload_for_sale!= 'None'}
					 	<li class="{$myobj->getMusicNavClass('left_listenertransactionlist')}"><a title="{$LANG.sidebar_listener_transaction_list_label}" href="{$myobj->getUrl('listenertransactionlist', '', '', 'members', 'music')}">{$LANG.sidebar_listener_transaction_list_label} </a></li>
					 {/if}
				{/if}
		    </ul>
            <input type="hidden" value="1" id="memberCount"  name="memberCount" />
        </div>
{elseif $opt == 'playlist'}
     <div class="clsAudioIndex clsCategoryHd" >
        <h3>{$LANG.sidebar_music_playlist_quickmixblock_label}</h3>
         <ul class="clsSiderbarMusicContainer clsOverflow">
			<li class="{$myobj->getMusicNavClass('left_musiclist_musicnew')}"><a title="{$LANG.sidebar_allmusics_label}" href="{$myobj->getUrl('musiclist', '?pg=musicnew', 'musicnew/', '', 'music')}">{$LANG.sidebar_allmusics_label} </a></li>
            <li class="{$myobj->getMusicNavClass('left_musicplaylist_playlistnew')}"><a title="{$LANG.sidebar_music_playlist_label}" href="{$myobj->getUrl('musicplaylist', '?pg=playlistnew', 'playlistnew/', '', 'music')}">{$LANG.sidebar_music_playlist_label} </a></li>
			<li class="{if $myobj->_currentPage == 'albumsortlist'}
							{$myobj->getMusicNavClass('left_albumsortlist')}
			           {else}
			           		{$myobj->getMusicNavClass('left_albumlist_albumlistnew')}
			           {/if}">{assign var=album_sort_count value=1}
					 <div class="clsOverflow">
                            <span class="clsTDLinks clsSidelinkLeft">
					        <a  href="{$myobj->getUrl('albumsortlist', '', '','','music')}" title="{$LANG.sidebar_album_list_label}">{$LANG.sidebar_album_list_label} </a>
					       </span>
					        <span class="clsSidelinkRight">
					            <a id="ancSortAlbum{$album_sort_count}"  class="" title=""></a>

					              <a {if $css_temp == 'albumlist_albumlistnew' || $css_temp == 'albumsortlist'} class="clsHideSubmenuLinks" {else} class="clsShowSubmenuLinks" {/if} href="javascript:void(0)" id="mainSortAlbumID{$album_sort_count}" onclick="showHideMenu('ancSortAlbum', 'subAlbumSortID', '1', 'album_sort_count', 'mainSortAlbumID') ">{$LANG.sidebar_show_label}</a>
					       </span>
					    </div>
			        <ul id="subAlbumSortID{$album_sort_count}" {if $css_temp == 'albumlist_albumlistnew' || $myobj->_currentPage == 'albumsortlist'}style="display:block;"{else}style="display:none;"{/if}>
			            <li class="{$myobj->getMusicNavClass('left_albumsortlist')}" ><a title="{$LANG.sidebar_alphabetical_album_label}"  href="{$myobj->getUrl('albumsortlist', '', '','','music')}">{$LANG.sidebar_alphabetical_album_label}</a></li>
			            <li class="{$myobj->getMusicNavClass('left_albumlist_albumlistnew')}" ><a title="{$LANG.sidebar_normal_album_label}"  href="{$myobj->getUrl('albumlist', '?pg=albumlistnew', 'albumlistnew/', '', 'music')}">{$LANG.sidebar_normal_album_label}</a></li>
			        </ul>

			</li>
			{if isset($CFG.admin.musics.music_artist_feature) and $CFG.admin.musics.music_artist_feature}
			<li class="{$myobj->getMusicNavClass('left_artistmemberslist')}">
			<a href="{$myobj->getUrl('artistmemberslist', '', '', '', 'music')}">
			{else}
			<li class="{$myobj->getMusicNavClass('left_artistlist')}">
			<a class="clsUploadOptionLink" href="{$myobj->getUrl('artistlist', '', '', '', 'music')}" title="{$LANG.sidebar_artist_list_label}">{/if}{$LANG.sidebar_artist_list_label}</li></a>
         </ul>
        </div>
{/if}
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="sidebar_bottom"}