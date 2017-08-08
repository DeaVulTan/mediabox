{$myobj->getTpl('general','header.tpl')}
<iframe name="facebook_logout" id="facebook_logout" style="display:none"></iframe>

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
<!-- Header ends -->

<!--body content starts-->
   	{if $header->isUserStyle()}
    	<div class="clsBodyContent profileBodyContent">
    {else}
		<div class="clsBodyContent">
	{/if}
    
 {if $header->chkIsAllMemberPage()}   
        <div class="clsOverflow">
            <div class="clsMainModuleHeadLeft">
                <div class="clsMainModuleHeadDetLeft">
                    <a href="{$myobj->getUrl('memberslist','','','','')}" title="{$LANG.common_member}">{$LANG.common_member}</a>
                </div>
                <div class="clsMainModuleHeadDetRight">
                    <p>
                       <a href="{$myobj->getUrl('memberslist','','?browse=viewAllMembers','','')}"> {$header->getTotalMembers()}</a><span> {$LANG.common_member_total},</span> 
                       <a href="{$myobj->getUrl('memberslist','','?browse=onlineMembers','','')}"> {$header->getTotalOnlineMembers()}</a><span> {$LANG.common_member_online}</span> 
                    </p>
                </div>
            </div>
        </div>
        <div class="clsModuleBreadcum">
            <p>
                <a href="{$myobj->getUrl('index','','','','')}" title="{$LANG.common_home}">{$LANG.common_home}</a>
				<a href="{$myobj->getUrl('memberslist','','','','')}" title="{$LANG.common_member}"><span>{$LANG.common_member}</span></a>
            </p>
        </div>
{/if}

 {if $header->chkIsAllMailPage()}   
        <div class="clsOverflow clsModuleMail">
            <div class="clsMainModuleHeadLeft">
                <div class="clsMainModuleHeadDetLeft">
                    <a href="{$myobj->getUrl('mail','','','','')}" title="{$LANG.common_mail}">{$LANG.common_mail}</a>
                </div>
                <div class="clsMainModuleHeadDetRight">
                    <p>
                      <a href="{$myobj->getUrl('mail', '?folder=inbox', 'inbox/')}"> {$myobj->countUnReadMail()}</a><span> {$LANG.common_mail_new},</span>
                      <a href="{$myobj->getUrl('mail', '?folder=request', 'request/')}"> {$myobj->countUnReadMailByType('Request')}</a><span> {$LANG.common_mail_request}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="clsModuleBreadcum">
            <p>
                <a href="{$myobj->getUrl('index','','','','')}" title="{$LANG.common_home}">{$LANG.common_home}</a>
                <a href="{$myobj->getUrl('mail','','','','')}" title="{$LANG.common_mail}"><span>{$LANG.common_mail}</span></a>
            </p>
        </div>
{/if}

 {if $header->chkIsAllFriendPage()}   
        <div class="clsOverflow clsModuleFriends">
            <div class="clsMainModuleHeadLeft">
                <div class="clsMainModuleHeadDetLeft">
                    <a href="{$myobj->getUrl('myfriends','','','','')}" title="{$LANG.common_friend}">{$LANG.common_friend}</a>
                </div>
                <div class="clsMainModuleHeadDetRight">
                    <p>
                       <a href="{$myobj->getUrl('myfriends','','','','')}"> {$header->getTotalFriendsNew()}</a><span> {$LANG.common_friend_total},</span> 
                       <a href="{$myobj->getUrl('mail', '?folder=request', 'request/')}"> {$header->newMail}</a><span> {$LANG.common_friend_request}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="clsModuleBreadcum">
            <p>
                <a href="{$myobj->getUrl('index','','','','')}" title="{$LANG.common_home}">{$LANG.common_home}</a>
                <a href="{$myobj->getUrl('myfriends','','','','')}"  title="{$LANG.common_friend}"><span>{$LANG.common_friend}</span></a>
            </p>
        </div>
{/if}

 {if $header->chkIsAllProfilePage()}   
        <div class="clsOverflow clsModuleProfile">
            <div class="clsMainModuleHeadLeft">
                <div class="clsMainModuleHeadDetLeft">
                    <a href="{$myobj->getUrl('profilebasic','','','','')}" title="{$LANG.common_profile}">{$LANG.common_profile}</a>
                </div>
                <div class="clsMainModuleHeadDetRight">
                    <p>
                      {$header->populateSiteUserStatistics()} {section name=count loop=$userstatistics}                
        {$userstatistics[count].value}<span> {$userstatistics[count].lang}, </span> {/section} <a href="{$myobj->getUrl('myfriends', '', '', 'members')}">{$header->getTotalFriendsNew()}</a> <span>{$LANG.common_total_friend},</span> <a href="{$profileCommentURL}">{$header->getTotalComments()}</a> <span>{$LANG.common_total_comments}</span> 
                    </p>
                </div>
            </div>
        </div>
        <div class="clsModuleBreadcum">
            <p>
                <a href="{$myobj->getUrl('index','','','','')}" title="{$LANG.common_home}">{$LANG.common_home}</a>
                <a href="{$myobj->getUrl('profilebasic','','','','')}" title="{$LANG.common_profile}"><span>{$LANG.common_profile}</span></a>
            </p>
        </div>
{/if}

{if !$header->headerBlock.left_menu_display}
<!--SIDEBAR-->
<div id="sideBar">
  <!--SIDEBAR1-->
  <div class="sideBar1">
    {$header->populateProfileRightNavigation()}
    {$header->populateTopContributorsRightNavigation()}
    {$header->displayFeaturedMemberRightNavigation()}
    {$header->populateMailRightNavigation()}
    {$header->populateRelationRightNavigation()}
	
	{* BANNER SECTION STARTS *}
		{if $header->chkIsAllMemberPage() || $header->chkIsNoSidebarPage()}   
			<div class="cls336pxBanner">{php}getAdvertisement('sidebanner1_336x280'){/php}</div>
			<div class="cls336pxBanner">{php}getAdvertisement('sidebanner2_336x280'){/php}</div>
        {elseif $header->chkIsAllMailPage() || $header->chkIsAllFriendPage() || $header->chkIsAllProfilePage()}
        	<div class="cls336pxBanner">{php}getAdvertisement('sidebanner1_336x280'){/php}</div>
		{/if} 
	{* BANNER SECTION ENDS *}  
	 
  </div>
</div>
<!--end of SIDEBAR-->
{/if}
<!-- Main  starts-->
<div id="main" class="{$CFG.main.class_name} {$header->headerBlock.banner.class}">

{if $header->chkIsProfilePage()}
	<div class="clsProfilePageStyles">
{/if}