{$myobj->getTpl('general', 'header.tpl')}
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
	<div class="clsHeadTopDiscussLeft">
		<div class="clsDiscussHeadDetailLeft">

			<a href="{$myobj->getUrl('index','','','','discussions')}">{$LANG.common_boards}</a>
		</div>
		<div class="clsDiscussHeadDetailRight">
			<p>

				<a href="{$myobj->getUrl('boards','?view=recent','recent/','','discussions')}">{$discussion->getModuleTotalBoard()}</a> <span>{$LANG.boards},</span>
				<a href="{$myobj->getUrl('discussions','','','','discussions')}">{$discussion->getModuleTotalDiscussion()}</a> <span>{$LANG.discussions},</span>
				<a href="{$myobj->getUrl('boards', '?view=recentlysolutioned', 'recentlysolutioned/', '', 'discussions')}">{$discussion->getModuleTotalSolution()}</a> <span>{$LANG.solutions}</span>
			</p>
		</div>
	</div>
	<div class="clsHeadTopDiscussRight">
    {$discussion->showSolutionSearchOption()}
	{$discussion->showPostLinks()}
    {$discussion->showShortcutDetails()}
	<div class="clsMyDiscussShortcut clsOverflow">
    {assign var=css_temp value=''}
		<ul>
			<li class="selDropDownLink">
				<div class="clsMyDiscussShortcutLeft">
					<div class="clsMyDiscussShortcutRight">
						<a href="#">My Shortcuts</a>
					</div>
				</div>
				<ul class="clsMyshortcutDropdown">
					{$myobj->setTemplateFolder('general/', 'music')}
					{include file="box.tpl" opt="musicdrop_top"}

						  <li class="clsProfileFav"><a href="{$showUserInfo_arr.favorites_link}">{$LANG.header_total_favs} <span class="clsTotalPoints">({$showUserInfo_arr.favorites})</span></a></li>
						  <li class="clsProfilePosts"><a href="{$showUserInfo_arr.total_postlink}">{$LANG.discuzz_common_boards} <span class="clsTotalPoints">({$showUserInfo_arr.userLog.total_board})</span></a></li>
						  <li class="clsProfileEdit"><a href="{$showUserInfo_arr.edit_info}">{$LANG.edit_info_text}</a></li>

					{$myobj->setTemplateFolder('general/', 'music')}
					{include file="box.tpl" opt="musicdrop_bottom"}
				</ul>
			</li>
		</ul>
	</div>
  </div>
</div>
<div class="clsBreadcum">
		<p>
		<a href="{$myobj->getUrl('index','','','','discussions')}" alt="{$LANG.common_music_link_home}" title="{$LANG.common_music_link_home}">{$LANG.common_music_link_home}</a>

		{if isset($myobj->category_titles) && ($myobj->category_titles) || $discussion->chkIsBoardPage() || $discussion->chkIsSolutionPage()}

        	{if $discussion->chkIsBoardPage()}
                {if ($myobj->getFormField('so') != 'adv') && !$myobj->getFormField('search_board')}
                    <a href="{$myobj->getUrl('discussions','','','','discussions')}" alt="{$LANG.discussions}" title="{$LANG.discussions}">{$LANG.discussions}</a>
                 {else}
                    {$LANG.discussions}
                {/if}
            {else}
            	<a href="{$myobj->getUrl('discussions','','','','discussions')}" alt="{$LANG.discussions}" title="{$LANG.discussions}">{$LANG.discussions}</a>
            {/if}
         {else}
			{$LANG.discussions}
         {/if}
             {assign var=counter value=0}
                {assign var=nextClass value=''}
                {if isset($myobj->category_titles) && ($myobj->category_titles)}
                    {foreach key=ckey item=cat_value from=$myobj->category_titles}
                        {assign var=counter value=$counter+1}
                        {if $counter gt 4}
                            {if ($cat_value.cat_url) } {$cat_value.cat_url}{/if}
                            {assign var=counter value=0}
                            {assign var=nextClass value='clsNextClass'}
                        {else}
                            {if ($cat_value.cat_url) } {$cat_value.cat_url}{/if}
                            {if $nextClass neq ''}{assign var=nextClass value=''}{/if}
                        {/if}
                    {/foreach}
                 {/if}
                     {if $discussion->chkIsBoardPage()}
                        {if $myobj->getFormField('cid')}
                            {if ($myobj->navigation_details.discussion_url)} {$myobj->navigation_details.discussion_url}{/if}
                            {$myobj->board_details.board_title}
                        {else}
                            {if isset($myobj->discussion_details) && ($myobj->discussion_details)}  <span>{$myobj->discussion_details.discussion_title}</span>{/if}
                        {/if}
                     {/if}
                     {if $discussion->chkIsSolutionPage()}
                       {if ($myobj->navigation_details.discussion_url)}   {$myobj->navigation_details.discussion_url}{/if}
                       {if ($myobj->navigation_details.navigation_board_title)} <span>{$myobj->navigation_details.navigation_board_title}</span>{/if}
                    {/if}
					</p>
</div>
{if !$discussion->chkIsSolutionPage()}
    <!--SIDEBAR-->
    <div id="sideBar">
        <!--SIDEBAR1-->
        <div class="sideBar1" id="sideBar1">

			{if $discussion->chkIsIndexPage()}
            	{if $myobj->isShowPageBlock('form_recent_activities')}
              {$myobj->setTemplateFolder('general/', 'discussions')}
                {include file='box.tpl' opt='sidebar_whatsgoing_top'}
              <div class="clsWhatsGoingOnContainer">{include file="indexActivityHead.tpl"}</div>
			  {$myobj->setTemplateFolder('general/', 'discussions')}
                {include file='box.tpl' opt='sidebar_whatsgoing_bottom'}
              {/if}
             {/if}
            {$header->populateTopContributorsRightNavigation()}
            {$header->displayFeaturedMemberRightNavigation()}
            {$discussion->rightBarSettings()}
            {if $discussion->chkIsBoardPage()}
            {include file="showLegends.tpl" opt="musicdrop_top"}
            {/if}

			{* BANNER SECTION STARTS *}
			 {if $myobj->_currentPage=='index'}
			   <div class="cls336pxBanner">
				   <div>{php}getAdvertisement('sidebanner1_336x280'){/php}</div>
			   </div>
			  {/if}
			{* BANNER SECTION ENDS *}

        </div>
    </div>
    <!--end of SIDEBAR-->
{/if}
<!-- Main -->
<div id="main" class="{$CFG.main.class_name} {$header->headerBlock.banner.class}">
<!-- Header ends -->
{if $header->chkIsProfilePage()}
	<div class="clsProfilePageStyles">
{/if}