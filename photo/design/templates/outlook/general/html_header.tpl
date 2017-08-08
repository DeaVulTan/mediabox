
{$myobj->getTpl('general','header.tpl')}
<script type="text/javascript">
var photo_ajax_page_loading = '<img alt="{$LANG.common_photo_loading}" src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/loader.gif" />';
var subscription_loader_image = '<div class=""><img alt="{$LANG.common_photo_loading}" src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/loader.gif" /></div>';
var photo_site_url = '{$CFG.site.photo_url}';
var photo_stack_confirmation_msg='{$LANG.header_photo_stack_clear_confirmation_msg}';
var photo_stack_ajax_url="{$myobj->getUrl('photostackajax','','','root','photo')}";
var photo_count_sting=' {$LANG.header_photo_stack_photo_count}';
var photos_count_sting=' {$LANG.header_photo_stack_photos_count}';
var photos_no_stack_msg=' {$LANG.header_photo_stack_no_photos_msg}';
var quick_mix_photo_id_arr = new Array();
{if $CFG.admin.photos.movie_maker}
var movie_queue_photo_id_arr = new Array();
var movie_queue_added_already ='{$LANG.common_movie_queue_added_already}';
var movie_queue_added_success_msg ='{$LANG.common_movie_queue_added_success_msg}';
{/if}
</script>
<script src="{$CFG.site.photo_url}js/photoStack.js" type="text/javascript"></script>

{* GENERATE PHOTO RELATED JS VARIABLES -start *}
	{$myobj->populatePhotoJsVars()}
{* GENERATE PHOTO RELATED JS VARIABLES -end *}
<script src="{$CFG.site.photo_url}js/functions.js" type="text/javascript"></script>


<div id="header" class="clsHeaderContainer">
    <div class="clsHeaderShadowImage">
        <div class="clsHeaderBlock">
            <div class="clsMainLogo">
                <h1>
                    <a href="{$header->index_page_link}"><img src="{$header->logo_url}" alt="{$CFG.site.name}" title="{$CFG.site.name}" /></a>
                </h1>
            </div>
            <div class="clsHeaderContents">
                <!-- Top header menu Begins -->
                <div class="clsTopHeaderLinks">
                	{$myobj->getTpl('general','topMenu.tpl')}
                </div>
                <!-- End of Top header menu -->
                <div class="clsTopHeader">
				
				{* BANNER SECTION STARTS *}
					<div class="cls468pxTopBanner">
						<div>{php}getAdvertisement('top_banner_468x60'){/php}</div>
					</div>
				{* BANNER SECTION ENDS *}
				
				<div id="selRightHeader" class="clsSearchUploadContainer">
					{$myobj->getTpl('general','topUpload.tpl')}
					{$myobj->getTpl('general','topSearch.tpl')}
				</div>
				
              </div>
            </div>
            <div class="clsNavigationStatsContainer">
                <div class="clsMainNavMiddle">
                    <div class="clsMainNavLeft">
                        <div class="clsMainNavRight">
                            <!-- Start of Main Menu -->
                            {$myobj->getTopMenu('general','mainMenu.tpl')}
                            <!-- end of Main Menu -->
                            <!-- stats starts -->
                            {$header->populateSiteStatistics()}
                            <!-- stats ends -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


   	{if $header->isUserStyle()}
    	<div class="clsBodyContent profileBodyContent">
    {else}
		<div class="clsBodyContent">
	{/if}

    <div class="clsOverflow">
	<div class="clsMainPhotosHeadLeft">
		<div class="clsMainPhotosHeadDetLeft">
			<a href="{$myobj->getUrl('index','','','','photo')}" title="{$LANG.common_index_photos}">{$LANG.common_index_photos}</a>
		</div>
		<div class="clsMainPhotosHeadDetRight">
			<p>
				{php} echo getTotalPhotosInSite() {/php}
				<span>{$LANG.common_photo_total_photos},</span>
				{php} echo getTotalPhotoSlidelistInSite() {/php}
				<span>{$LANG.common_photo_total_slidelists},</span>
				{php} echo getPhotoRelatedStats() {/php}
				<span>{$LANG.common_photo_total_photo_views}</span>
			</p>
		</div>
	</div>
	<div class="clsMainPhotosHeadRight">
           <div class="clsQuickMixLink">
               {if isMember() && $CFG.admin.photos.allow_quick_mixs}
                    <div class="clsQuickMixLeft">
                        <div class="clsQuickMixRight">
                            <li class=""><a href="javascript:void(0)" onclick="quickMixPlayer();" title="{$LANG.header_open_quick_mix}">{$LANG.header_open_quick_mix}</a></li>
                        </div>
                    </div>
               {/if}
           </div>
           {if isMember()}
	           <div class="clsMyMusicShortcut clsOverflow">
	            <ul>
	                <li class="selDropDownLink">
	                    <div class="clsMyPhotoShortcutLeft">
	                        <div class="clsMyPhotoShortcutRight">
	                            <a href="#" title="{$LANG.my_photo_shortcuts}">{$LANG.my_photo_shortcuts}</a>
	                        </div>
	                    </div>
	                    <ul class="clsMyshortcutDropdown">
						{$myobj->setTemplateFolder('general/', 'photo')}
						{include file="box.tpl" opt="listdropdown_top"}
							{*CHECKED THE CONDITION IF ALLOWED THE photo UPLOAD FOR FAN MEMBER*}
	                     	{if isAllowedphotoUpload()}
	                     		<li>
									<a href="{$myobj->getUrl('photouploadpopup', '', '', 'members', 'photo')}" title="{$LANG.photo_shortcuts_upload_photo}">{$LANG.photo_shortcuts_upload_photo}</a>
								</li>
							{/if}
							<li>
								<a href="{$myobj->getUrl('photolist', '?pg=myphotos', 'myphotos/', 'members', 'photo')}" title="{$LANG.photo_shortcuts_myphotos}">{$LANG.photo_shortcuts_myphotos}</a>
							</li>
							<li>
								<a href="{$myobj->getUrl('photoslidelist', '?pg=myslidelist', 'myslidelist/', 'members', 'photo')}" title="{$LANG.photo_shortcuts_myslidelist}">{$LANG.photo_shortcuts_myslidelist}</a>
							</li>
							<li>
								<a href="{$myobj->getUrl('albumlist', '?pg=myalbums', 'myalbums/', 'members', 'photo')}" title="{$LANG.photo_shortcuts_myphotoalbums}">{$LANG.photo_shortcuts_myphotoalbums}</a>
							</li>
							<li>
								<a href="{php} echo getUrl('peopleonphoto','?tagged_by='.$CFG['user']['user_name'].'&block=me', '?tagged_by='.$CFG['user']['user_name'].'&block=me','','photo'){/php}" title="{$LANG.photo_shortcuts_tagged_photos}">{$LANG.photo_shortcuts_tagged_photos}</a>
							</li>
	                     	{if isAllowedphotoUpload()}
								<li>
									<a href="{$myobj->getUrl('photodefaultsettings', '', '', 'members', 'photo')}" title="{$LANG.photo_shortcuts_photo_default_settings}">{$LANG.photo_shortcuts_photo_default_settings}</a>
								</li>
							{/if}
						{$myobj->setTemplateFolder('general/', 'photo')}
						{include file="box.tpl" opt="listdropdown_bottom"}
					</ul>
	                </li>
	            </ul>
	        </div>
	      {/if}
   </div>
</div>
<div class="clsBreadcum">
	<p>
       <a href="{$myobj->getUrl('index','','','','')}" title="{$LANG.common_photo_link_home}">{$LANG.common_photo_link_home}</a>
    	{if $myobj->_currentPage == 'index'}
    		<span>{$LANG.common_photo_link_photo}</span>
    	{else}
	    	<a href="{$myobj->getUrl('index','','','','photo')}" title="{$LANG.common_photo_link_photo}"><span>{$LANG.common_photo_link_photo}</span></a>
	        {if $myobj->_currentPage == 'photolist'}
	        	<span>{$LANG.common_photo_link_view_all_photo}</span>
	        {elseif $myobj->_currentPage == 'photouploadpopup'}
	        	<span>{$LANG.common_photo_link_upload_photo}</span>
	        {elseif $myobj->_currentPage == 'photoslidelist'}
	        	<span>{$LANG.common_photo_link_slide_list}</span>
	        {elseif $myobj->_currentPage == 'photoslidelistmanage'}
	        	<span>{$LANG.common_photo_link_slidelist_manage}</span>
	        {elseif $myobj->_currentPage == 'albumlist'}
	        	<span>{$LANG.common_photo_link_album_list}</span>
	        {elseif $myobj->_currentPage == 'photoalbummanage'}
	        	<span>{$LANG.common_photo_link_photo_album_manage}</span>
	        {elseif $myobj->_currentPage == 'photodefaultsettings'}
	        	<span>{$LANG.common_photo_link_photo_default_settings}</span>
	        {elseif $myobj->_currentPage == 'managephotocomments'}
	        	<span>{$LANG.common_photo_link_manage_photo_comments}</span>
	        {elseif $myobj->_currentPage == 'viewphoto'}
	        	<span>{$LANG.common_photo_link_view_photo}</span>
	        {elseif $myobj->_currentPage == 'peopleonphoto'}
	        	<span>{$LANG.common_photo_link_tagged_photos}</span>
	        {elseif $myobj->_currentPage == 'photocategory'}
	        	<span>{$LANG.common_photo_link_photo_categories}</span>
	        {elseif $myobj->_currentPage == 'tags'}
	        	<span>{$LANG.common_photo_link_photo_tags}</span>
	        {/if}
	    {/if}
	</p>
</div>

{if !$myobj->chkIsAllowedLeftMenu()}
    <!--SIDEBAR-->
	  <div class="clsSideBar1Photo" id="sideBarPhoto">

      	<!--<div class="clsHeaderUpLoadPhoto">
               <div class="clsUploadPhotoButton">
                {*CHECKED THE CONDITION IF ALLOWED THE Photo UPLOAD FOR FAN MEMBER*}
                {if isAllowedPhotoUpload()}
                <a href="{$myobj->getUrl('photouploadpopup', '', '', 'members', 'photo')}"><span>{$LANG.common_photo_upload}</span></a>
                {/if}
                {*CHECKED THE CONDITION IF ALLOWED THE Photo UPLOAD FOR FAN MEMBER*}
              </div>
        </div>-->

		 {* MY photo SECTION STARTS *}
			{$myobj->populateMemberDetail('photo')}
		 {* MY photo SECTION ENDS *}

        {* photo CATEGORY SECTION STARTS *}
        <div class="clsSideBarContent clsCategoryHd">
          {$myobj->setTemplateFolder('general/','photo')}
          {include file="box.tpl" opt="sidebar_top"}
             <div class="clsOverflow">
                <h3 id="photoCategoryHeader" class="clsSideBarLeftTitle clsPaddingLeft5">
                    <!--<a onClick="showPhotoSidebarTab('photoCategory','photoTags');">-->{$LANG.sidebar_genres_heading_label}<!--</a>-->
                </h3>
            </div>
           <div  id="photoCategoryContent"> {$myobj->populateGenres()} </div>
        {$myobj->setTemplateFolder('general/','photo')}
        {include file="box.tpl" opt="sidebar_bottom"}
       </div>
       {* photo CATEGORY SECTION ENDS *}

       {* BANNER SECTION STARTS *}
       	{if $myobj->_currentPage == 'photolist'}
   	   		<div class="cls336pxBanner">
       			<div>{php}getAdvertisement('sidebanner1_336x280'){/php}</div>
   			</div>
   		{/if}
  	   {* BANNER SECTION ENDS *}

	   {* photo TAGS SECTION STARTS *}
       <div class="clsSideBarContent clsCategoryHd">
            <div class="clsOverflow clsTagsHeading">
                <h3 id="photoTagsHeader" class="clsSideBarLeftTitle clsPaddingLeft5">
                    <!--<a onClick="showPhotoSidebarTab('photoTags','photoCategory');">-->{$LANG.sidebar_photo_tags_heading_label}<!--</a> -->
                </h3>
             </div>

           {$myobj->setTemplateFolder('general/','photo')}
           {include file="box.tpl" opt="phototags_top"}
                 <div  id="photoTagsContent"> {$myobj->populateSidebarClouds('photo', 'photo_tags',20)} </div>
            {$myobj->setTemplateFolder('general/','photo')}
            {include file="box.tpl" opt="phototags_bottom"}
         </div>
      {* photo TAGS SECTION ENDS *}

	  {* BANNER SECTION STARTS *}
	  {if $myobj->_currentPage == 'photolist'}
   	  	<div class="cls336pxBanner">
       		<div>{php}getAdvertisement('sidebanner2_336x280'){/php}</div>
   		</div>
   	  {/if}
  	  {* BANNER SECTION ENDS *}

	  </div>
    <!--end of SIDEBAR-->
{/if}

<!-- Main -->
<div id="mainPhoto" class="{$CFG.main.class_name} {$header->headerBlock.banner.class}">
<!-- Header ends -->

{if $header->chkIsProfilePage()}
	<div class="clsProfilePageStyles">
{/if}

<!-- logout confirmation starts -->
<div id="selLogoutMsgConfirm" class="clsPopupConfirmation" style="display:none;">
	{$myobj->setTemplateFolder('general/','photo')}
    {include file='box.tpl' opt='popupbox_top'}
      <p id="logoutMsgConfirmText">{$LANG.header_logout_confirmation_msg}</p>
      <form name="logoutMsgConfirmform" id="logoutMsgConfirmform" autocomplete="off">
        <input type="button" class="clsPopUpButtonSubmit" name="yes" value="{$LANG.common_yes_option}"
                  tabindex="{smartyTabIndex}" onclick="doLogout('{$header->getUrl('logout', '', '', 'root')}')" />
        &nbsp;
        <input type="button" class="clsPopUpButtonReset" name="no" value="{$LANG.common_no_option}"
                  tabindex="{smartyTabIndex}" onClick="return hideLogoutBlock()" />
      </form>
	  {$myobj->setTemplateFolder('general/','photo')}
      {include file='box.tpl' opt='popupbox_bottom'}
</div>
<!-- logout confirmation ends -->

<div id="selQuickslideMsgConfirm" class="clsPopupConfirmation" style="display:none;">
      <p id="quickSlideMsgConfirmText"></p>
      <form name="quickSlideMsgConfirmform" id="quickSlideMsgConfirmform" autocomplete="off">
        <input type="button" class="clsPopUpButtonSubmit" name="yes" value="{$LANG.common_yes_option}"
                  tabindex="{smartyTabIndex}" onclick="clearAllQuickSlide()" />
        &nbsp;
        <input type="button" class="clsPopUpButtonReset" name="no" value="{$LANG.common_no_option}"
                  tabindex="{smartyTabIndex}" onClick="return hideQuickSlideBlock()" />
        <input type="hidden" name="quick_slide_clear_act" id="quick_slide_clear_act" />
      </form>
</div>
