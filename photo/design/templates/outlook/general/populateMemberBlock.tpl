{if $opt == 'photo'}
     <div class="clsSideBarContent clsCategoryHd">
	 		{$myobj->setTemplateFolder('general/','photo')}
            {include file="box.tpl" opt="sidebar_top"}
            <div class="clsOverflow"><h3 class="clsSideBarLeftTitle">{$LANG.sidebar_myphoto_dashboard_label|truncate:25}</h3></div>
            {*if $header->_currentPage == 'index' && isMember()}
                <div class="clsphotoMemberContainer clsNoBorder">
                    <div class="clsphotoMemberThumb">
                        <div class="clsThumbImageLink">
                            <div class="cls49x49 clsUserThumbImageOuter clsImageHolder clsPointer" >
                            	<a href="{$populateMemberDetail_arr.memberProfileUrl}" class="cls49x49 clsUserThumbImageOuter clsImageHolder clsPointer">
                                 <img src="{$populateMemberDetail_arr.icon.m_url}" title="{$populateMemberDetail_arr.name}" border="0" />
                                 </a>
                            </div>
                        </div>
                    </div>
                    <div class="clsphotoMemberDetails ">
                        <p class="clsBold clsMyphotoUser"><a href="{$populateMemberDetail_arr.memberProfileUrl}" title="{$populateMemberDetail_arr.name}">{$populateMemberDetail_arr.name}</a></p>
                        <p>{$LANG.sidebar_totalphoto_label}<span><a href="{$myobj->getUrl('photolist', '?pg=myphoto', 'myphoto/', 'members', 'photo')}">{$populateMemberDetail_arr.total_photo}</a></span></p>
                    </div>
                </div>
           {/if*}
           {*if !isMember()}
                <!--div class="clsphotoMemberContainer clsNoBorder">
                    <div class="clsphotoMemberDetails">
                    	<p class="clsSignUpLink">
                             <a href="{$myobj->getUrl('signup')}">{$LANG.common_signup_label}</a>&nbsp; {$LANG.common_or_label} &nbsp;<a href="{$myobj->getUrl('login')}">{$LANG.common_login_label}</a>
                         </p>
                    </div>
                </div-->
           {/if*}
            <div class="clsSideBarContent">
            <ul class="clsPhotoSidebarLinks">
              {assign var=css_temp value=''}
                {if $flag}
                    {assign var=css_temp value=$myobj->_currentPage|cat:'_'|cat:$myobj->getFormField('pg')}
                {/if}
               {*CHECKED THE CONDITION IF ALLOWED THE PHOTO UPLOAD FOR FAN MEMBER*}
                {*if isAllowedPhotoUpload()}
                <li class="{$myobj->getPhotoNavClass('left_photouploadpopup')}" ><a  href="{$myobj->getUrl('photouploadpopup', '', '', 'members', 'photo')}">{$LANG.common_photo_upload}</a></li>
				{/if*}
                {*CHECKED THE CONDITION IF ALLOWED THE Photo UPLOAD FOR FAN MEMBER*}
			    <li class="
                {if $myobj->_currentPage ==  'managephotocomments'}
                	{$myobj->getPhotoNavClass('left_managephotocomments')}
                {elseif $css_temp == 'photolist_myphotos'}
                	{$myobj->getPhotoNavClass('left_photolist_myphotos')}
				{elseif $css_temp == 'photolist_myfavoritephotos'}
                	{$myobj->getPhotoNavClass('left_photolist_myfavoritephotos')}
                {/if}    clsHasSubMenu" >
                	{assign var=photo_count value=1}
                     <table>
                        <tr>
                         <td class="clsPhotoLinks">
						 <a  href="{$myobj->getUrl('photolist', '?pg=myphotos', 'myphotos/', 'members', 'photo')}" onclick="">{$LANG.sidebar_myphoto_label}</a>
                         </td>
                          <td>
                          	<a {if $myobj->_currentPage == 'managephotocomments' || $css_temp == 'photolist_myphotos' || $css_temp == 'photolist_myfavoritephotos'} class="clsHideSubmenuLinks" {else} class="clsShowSubmenuLinks"{/if} href="javascript:void(0)" id="mainphotoID{$photo_count}" onClick="showHideMenu('ancPlaylist', 'subphotoID','1','{$photo_count}', 'mainphotoID')">{$LANG.sidebar_show_label}</a>
                         </td>

                        </tr>
                    </table>
                    <ul  id="subphotoID{$photo_count}" {if $myobj->_currentPage == 'managephotocomments' || $css_temp == 'photolist_myphotos' || $css_temp == 'photolist_myfavoritephotos'}style="display:block;"{else}style="display:none;"{/if}>
						<li class="{$myobj->getPhotoNavClass('left_photolist_myphotos')}">
							<a  href="{$myobj->getUrl('photolist', '?pg=myphotos', 'myphotos/', 'members', 'photo')}" onclick="">{$LANG.sidebar_myphoto_label}</a>
						</li>
						<li class="{$myobj->getPhotoNavClass('left_photolist_myfavoritephotos')}" ><a  href="{$myobj->getUrl('photolist', '?pg=myfavoritephotos', 'myfavoritephotos/', 'members', 'photo')}">{$LANG.sidebar_favourite_photo_label}</a></li>
						<li class="{$myobj->getPhotoNavClass('left_managephotocomments')}"><a href="{$myobj->getUrl('managephotocomments', '', '', 'members', 'photo')}">{$LANG.sidebar_photo_comments_label}  </a></li>

					</ul>
                </li>
				<!--li class="{if $myobj->_currentPage ==  'photoslidelistmanage'} {$myobj->getPhotoNavClass('left_photoplaylistmanage')}
                   {elseif $css_temp ==  'photoslidelist_myplaylist'}{$myobj->getPhotoNavClass('left_photoslidelist_myplaylist')}{/if}"-->
				<li class="{if $myobj->_currentPage ==  'photoslidelistmanage'}
                		   		{$myobj->getPhotoNavClass('left_photoslidelistmanage')}
                   		   {else}
                           		{$myobj->getPhotoNavClass('left_photoslidelist_myslidelist')}
                           {/if} clsHasSubMenu">
                {assign var=playlist_count value=1}
                 <table>
                        <tr>
                         	<td class="clsPhotoLinks"><a href="{$myobj->getUrl('photoslidelist', '?pg=myslidelist', 'myslidelist/', 'members', 'photo')}">{$LANG.sidebar_myslidelist_label} </a></td>
                        	<td><a {if $myobj->_currentPage == 'photoslidelistmanage' || $css_temp == 'photoslidelist_myslidelist'} class="clsHideSubmenuLinks" {else} class="clsShowSubmenuLinks"{/if} href="javascript:void(0)" id="mainPlaylistID{$playlist_count}" onClick="showHideMenu('ancPlaylist', 'subPlaylistID','1','{$playlist_count}', 'mainPlaylistID')">{$LANG.sidebar_show_label}</a></td>
                        </tr>
                    </table>
                    <ul  id="subPlaylistID{$playlist_count}" {if $myobj->_currentPage == 'photoslidelistmanage' || $css_temp == 'photoslidelist_myslidelist'}style="display:block;"{else}style="display:none;"{/if}>
						<li class="{$myobj->getPhotoNavClass('left_photoslidelist_myslidelist')}">
							<a href="{$myobj->getUrl('photoslidelist', '?pg=myslidelist', 'myslidelist/', 'members', 'photo')}">{$LANG.sidebar_myslidelist_label} </a>
						</li>
					  	<li class="{$myobj->getPhotoNavClass('left_photoslidelistmanage')}"><a href="{$myobj->getUrl('photoslidelistmanage', '', '', 'members', 'photo')}">{$LANG.sidebar_manageplaylist_label} </a>
						</li>
				    </ul>
                </li>


                {* MY ALBUMS BLOCK STARTS *}
                <li class="{if $myobj->_currentPage == 'photoalbummanage'}
                				{$myobj->getPhotoNavClass('left_photoalbummanage')}
                           {else}
                           		{$myobj->getPhotoNavClass('left_albumlist_myalbums')}
                           {/if} clsHasSubMenu {if !isMember()}clsNoBorderBottom{/if}">
                 {assign var=album_count value=1}
                 	<table>
                    	<tr>
                        	<td class="clsTDLinks clsPhotoLinks">
                        		<a href="{$myobj->getUrl('albumlist', '?pg=myalbums', 'myalbums/', 'members', 'photo')}">{$LANG.sidebar_manage_photo_albums} </a>
                        	</td>
                        	<td>
                            	<a id="ancAlbum{$album_count}"  class="" title=""></a>
	                            <a {if $css_temp == 'albumlist_myalbums' || $myobj->_currentPage == 'photoalbummanage'} class="clsHideSubmenuLinks" {else} class="clsShowSubmenuLinks" {/if} href="javascript:void(0)" id="mainAlbumID{$album_count}" onClick="showHideMenu('ancAlbum', 'subAlbumID', '1', 'album_count', 'mainAlbumID') ">{$LANG.sidebar_show_label}</a>
                        	</td>
                    	</tr>
                	</table>
                    <ul id="subAlbumID{$album_count}" {if $css_temp == 'albumlist_myalbums' || $myobj->_currentPage == 'photoalbummanage'}style="display:block;"{else}style="display:none;"{/if}>
                    	<li class="{$myobj->getPhotoNavClass('left_albumlist_myalbums')}" ><a  href="{$myobj->getUrl('albumlist', '?pg=myalbums', 'myalbums/', 'members', 'photo')}">{$LANG.sidebar_album_label}</a></li>
                        <li class="{$myobj->getPhotoNavClass('left_photoalbummanage')}" ><a  href="{$myobj->getUrl('photoalbummanage', '', '', 'members', 'photo')}">{$LANG.sidebar_my_album_manage_label}</a></li>
                    </ul>
				</li>
                {* MY ALBUMS BLOCK ENDS *}

                 {*----------------------------------- MOVIE MAKER BLOCK STARTS -----------------------------------------*}
                 {if $CFG.admin.photos.movie_maker}
                <li class="{if $myobj->_currentPage == 'createmovie'}
                				{$myobj->getPhotoNavClass('left_createmovie')}
                           {elseif  $myobj->_currentPage == 'photomoviemanage'}
                           		{$myobj->getPhotoNavClass('left_photomoviemanage')}
                           {else}
                           		{$myobj->getPhotoNavClass('left_movielist_mymovies')}
                           {/if} clsHasSubMenu {if !isMember()}clsNoBorderBottom{/if}">
                 {assign var=movie_maker_count value=1}
                 	<table>
                    	<tr>
                        	<td class="clsTDLinks clsPhotoLinks">
                        		<a href="{$myobj->getUrl('createmovie', '', '', 'members', 'photo')}">{$LANG.common_sidebar_moviemaker_title} </a>
                        	</td>
                        	<td>
                            	<a id="ancMoiveMaker{$movie_maker_count}"  class="" title=""></a>
	                            <a {if $css_temp == 'movielist_mymovies' || $myobj->_currentPage == 'createmovie' || $myobj->_currentPage == 'photomoviemanage'} class="clsHideSubmenuLinks" {else} class="clsShowSubmenuLinks" {/if} href="javascript:void(0)" id="mainMoiveMakerID{$movie_maker_count}" onClick="showHideMenu('ancMoiveMaker', 'subMoiveMakerID', '1', 'movie_maker_count', 'mainMoiveMakerID') ">{$LANG.sidebar_show_label}</a>
                        	</td>
                    	</tr>
                	</table>
                    <ul id="subMoiveMakerID{$movie_maker_count}" {if $css_temp == 'movielist_mymovies' || $myobj->_currentPage == 'createmovie'  || $myobj->_currentPage == 'photomoviemanage'}style="display:block;"{else}style="display:none;"{/if}>
                    	<li class="{$myobj->getPhotoNavClass('left_createmovie')}" ><a  href="{$myobj->getUrl('createmovie', '', '', 'members', 'photo')}">{$LANG.common_sidebar_moviemaker_create_movie}</a></li>
                        <li class="{$myobj->getPhotoNavClass('left_movielist_mymovies')}" ><a  href="{$myobj->getUrl('movielist', '?pg=mymovies', 'mymovies/', 'members', 'photo')}">{$LANG.common_sidebar_moviemaker_my_movies}</a></li>
                        <li class="{$myobj->getPhotoNavClass('left_photomoviemanage')}" ><a  href="{$myobj->getUrl('photomoviemanage', '', '', 'members', 'photo')}">{$LANG.common_sidebar_moviemaker_manage_movies}</a></li>
                    </ul>
				</li>
                {/if}
                {*---------------------------------------- MOVIE MAKER BLOCK ENDS ----------------------------------------- *}


				{if isMember()}
					{*CHECKED THE CONDITION IF ALLOWED THE photo UPLOAD FOR FAN MEMBER*}
                     {if isAllowedphotoUpload()}
                     <li class="{$myobj->getPhotoNavClass('left_photouploadpopup')}"><a href="{$myobj->getUrl('photouploadpopup', '', '', 'members', 'photo')}">{$LANG.sidebar_photo_upload_label}</a></li>
					 <li class="{$myobj->getPhotoNavClass('left_photodefaultsettings')}"><a href="{$myobj->getUrl('photodefaultsettings', '', '', 'members', 'photo')}">{$LANG.sidebar_photo_default_settings_label}</a></li>
					{/if}
                    <li class="{if $myobj->_currentPage == 'peopleonphoto'}
                				{$myobj->getPhotoNavClass('left_peopleonphoto')}{/if} clsHasSubMenu clsNoBorderBottom">
                {assign var=tagged_count value=1}
                 <table>
                        <tr>
                         	<td class="clsPhotoLinks"><a href="{$populateMemberDetail_arr.photosTaggedByMeUrl}">{$LANG.sidebar_photos_tagged_title}</a></td>
                        	<td>
                            <a id="ancTagged{$tagged_count}"  class="" title=""></a>
                            <a {if $myobj->_currentPage == 'peopleonphoto'} class="clsHideSubmenuLinks" {else} class="clsShowSubmenuLinks"{/if} href="javascript:void(0)" id="mainTaggedID{$tagged_count}" onClick="showHideMenu('ancTagged', 'subTaggedID','1','{$tagged_count}', 'mainTaggedID')">{$LANG.sidebar_show_label}</a></td>
                        </tr>
                    </table>
                    <ul  id="subTaggedID{$tagged_count}" {if $myobj->_currentPage == 'peopleonphoto'}style="display:block;"{else}style="display:none;"{/if}>
                        <li class="{$myobj->getPhotoNavClass('left_peopleonphoto_me')}"><a href="{$populateMemberDetail_arr.photosTaggedByMeUrl}">{$LANG.sidebar_photos_tagged_by_me}</a>
                        </li>
						<li class="{$myobj->getPhotoNavClass('left_peopleonphoto_of')}"><a href="{$populateMemberDetail_arr.taggedPhotosOfMeUrl}">{$LANG.sidebar_tagged_photos_of_me}</a>
						</li>
					  	<li class="{$myobj->getPhotoNavClass('left_peopleonphoto_all')}"><a href="{$populateMemberDetail_arr.allPhotoTagsUrl}">{$LANG.sidebar_all_photo_tags} </a>
						</li>
				    </ul>
                </li>
				{/if}
		    </ul>
            </div>
            <input type="hidden" value="1" id="memberCount"  name="memberCount" >
			{$myobj->setTemplateFolder('general/','photo')}
            {include file="box.tpl" opt="sidebar_bottom"}
        </div>
{elseif $opt == 'slidelist'}
     <div class="clsSideBarContent clsCategoryHd" >
		{$myobj->setTemplateFolder('general/','photo')}
        {include file="box.tpl" opt="sidebar_top"}
	<div class="clsOverflow"><h3 class="clsSideBarLeftTitle">{$LANG.sidebar_playlist_quickmixblock_label}</h3></div>
         <ul class="clsPhotoSidebarLinks clsOverflow clsPhotosLastLink">
			<li {if $cid==0}class="{$myobj->getPhotoNavClass('left_photolist_photonew')}{else}class="{$myobj->getPhotoNavClass('')}"{/if}"><a href="{$myobj->getUrl('photolist', '?pg=photonew', 'photonew/', '', 'photo')}">{$LANG.sidebar_allphotos_label} </a></li>
            <li class="{$myobj->getPhotoNavClass('left_photoslidelist_slidelistnew')}"><a href="{$myobj->getUrl('photoslidelist', '?pg=slidelistnew', 'slidelistnew/', '', 'photo')}">{$LANG.sidebar_playlist_label} </a></li>
			<li class="{$myobj->getPhotoNavClass('left_albumlist_albumlistnew')}"><a href="{$myobj->getUrl('albumlist', '?pg=albumlistnew', 'albumlistnew/', '', 'photo')}">{$LANG.sidebar_album_list_label} </a></li>
            {if $CFG.admin.photos.movie_maker}
            <li class="{$myobj->getPhotoNavClass('left_movielist_newmovies')} clsNoBorderBottom"><a href="{$myobj->getUrl('movielist', '?pg=newmovies', 'newmovies/', '', 'photo')}">{$LANG.common_sidebar_movie_list_label} </a></li>
            {/if}
         </ul>
		 {$myobj->setTemplateFolder('general/','photo')}
         {include file="box.tpl" opt="sidebar_bottom"}
        </div>
{/if}
