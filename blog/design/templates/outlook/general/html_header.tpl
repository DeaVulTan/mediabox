{$myobj->getTpl('general','header.tpl')}
<script type="text/javascript">
var blog_ajax_page_loading = '<img alt="{$LANG.common_blog_loading}" src="{$CFG.site.url}blog/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/loader.gif" />';
var blog_site_url = '{$CFG.site.blog_url}';
</script>
<script src="{$CFG.site.blog_url}js/jquery.fancybox.js" type="text/javascript"></script>

{* GENERATE BLOG RELATED JS VARIABLES -start *}
    {* $myobj->populateBlogJsVars() *}
{* GENERATE BLOG RELATED JS VARIABLES -end *}

<script src="{$CFG.site.blog_url}js/functions.js" type="text/javascript"></script>

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
	<div class="clsHeadTopBlogLeft">
		<div class="clsBlogHeadDetailLeft">
			<a href="{$myobj->getUrl('index','','','','blog')}">{$LANG.common_header_home_blog_title}</a>
		</div>
		<div class="clsBlogHeadDetailRight">
			<p>
				{$myobj->indexPageTotalBlogsInSite()}
				<span>{$LANG.common_header_home_blog_title},</span>
				{$myobj->indexPageTotalPostsInSite()}
				<span>{$LANG.common_header_home_posts_title}</span>
			</p>
		</div>
	</div>
	<div class="clsHeadTopBlogRight">
	<div class="clsMyBlogShortcut clsOverflow">
	<div class="clsFloatRight">
		<ul>
			<li class="selDropDownLink">		
				<div class="clsMyBlogShortcutLeft">
					<div class="clsMyBlogShortcutRight">
						<a href="#">{$LANG.common_header_home_my_shortcuts_title}</a>
					</div>

				<ul class="clsMyshortcutDropdown">
					{$myobj->setTemplateFolder('general/', 'blog')}
					{include file="box.tpl" opt="blogdrop_top"}
						<li>
							{if $myobj->chkBlogsAdded()}
                             <a  href="{$myobj->getUrl('manageblog', '', '', 'members', 'blog')}">{$LANG.common_manage_edit_blog}</a>
                             {else}
                             <a  href="{$myobj->getUrl('manageblog', '', '', 'members', 'blog')}">{$LANG.common_manage_add_blog}</a>
                             {/if}
                         </li>
						 {if $myobj->chkBlogsAdded()}
                        <li>
                             <a  href="{$myobj->chkBlogsAdded()}">{$LANG.common_manage_my_blog}</a>
                        </li>
 						{/if}
						<li>
							<a  href="{$myobj->getUrl('blogpostlist', '?pg=myposts', 'myposts/', 'members', 'blog')}">{$LANG.common_sidebar_mypost_label}</a>
						</li>
						<li>
							<a  href="{$myobj->getUrl('manageblogpost', '', '', 'members', 'blog')}">{$LANG.common_blog_new_post}</a>
                        </li>
					{$myobj->setTemplateFolder('general/', 'blog')}
					{include file="box.tpl" opt="blogdrop_bottom"}
				</ul>
				</div>
			</li>
		</ul>
		</div>
	</div>
  </div>
</div>
<div class="clsBreadcum">
		<ul>
			<li><a href="{$myobj->getUrl('index', '', '','','')}">{$LANG.common_header_home_index_title}</a></li>
			{if  $myobj->_currentPage == 'index'}
			<li>{$LANG.common_header_home_blog_title}</li>
			{else}
			<li><a href="{$myobj->getUrl('bloglist', '', '', '', 'blog')}"> {$LANG.common_header_home_blog_title}</a></li>
			{if $myobj->_currentPage == 'managepostcomments'}
			<li>{$LANG.common_blog_link_manage_post_comments}</li>
			{elseif $myobj->_currentPage == 'manageblog'}
			<li>{$LANG.common_blog_link_manage_blog}</li>
			{elseif $myobj->_currentPage == 'blogpostlist'}
			<li>{$LANG.common_blog_link_manage_blog_postlist}</li>
			{elseif $myobj->_currentPage == 'manageblogpost'}
			<li>{$LANG.common_blog_link_manage_blog_post}</li>
			{elseif $myobj->_currentPage == 'blogcategory'}
			<li>{$LANG.common_blog_link_manage_blog_category}</li>
			{elseif $myobj->_currentPage == 'tags'}
			<li>{$LANG.common_blog_link_blog_tags}</li>
			{elseif $myobj->_currentPage == 'bloglist'}
			<li>{$LANG.common_blog_link_blog_list}</li>
			{/if}{/if}
		</ul>
</div>
{if !$myobj->chkIsAllowedLeftMenu()}
<!--SIDEBAR-->
<div class="clsOverflow">
<div id="sideBar">
  <!--SIDEBAR1-->
  <div class="sideBar1">
    <div class="clsSideBar1Blog" id="sideBarBlog">

		 {* MY BLOG SECTION STARTS *}
            {$myobj->populateMyBlogDetail('blog')}
         {* MY BLOG SECTION ENDS *}

        {if isMember()}
         {* MY DASH BOARD BLOG SECTION STARTS *}
            {$myobj->populateMyBlogDashBoardDetail('blog')}
         {* MY DASH BOARD SECTION ENDS *}
        {/if}

         {* CATEGORY SECTION STARTS *}
             {$myobj->populateBlogCategory()}
         {* CATEGORY SECTION ENDS *}

		{* BANNER SECTION STARTS *}
			 {if $myobj->_currentPage=='index'}
			   <div class="cls336pxBanner">
				   <div>{php}getAdvertisement('sidebanner1_336x280'){/php}</div>
			   </div>
			  {/if} 
		{* BANNER SECTION ENDS *}
	
         {* BLOG CLOUDS SECTION STARTS *}
            {$myobj->populateSidebarClouds('blog', 'blog_tags')}
         {* BLOG CLOUDS SECTION ENDS *}
    </div>

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
