{$myobj->getTpl('general','header.tpl')}
<script type="text/javascript">
var article_ajax_page_loading = '<img alt="{$LANG.common_article_loading}" src="{$CFG.site.url}article/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/loader.gif" />';
var article_site_url = '{$CFG.site.article_url}';
</script>
<script src="{$CFG.site.article_url}js/jquery.fancybox.js" type="text/javascript"></script>
<script src="{$CFG.site.article_url}js/functions.js" type="text/javascript"></script>


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

<div class="clsBredcumHeader">
	<div class="clsMainArticleHeadLeft">
		<div class="clsMainArticleHeadDetLeft">
			<a href="{$myobj->getUrl('index','','','','article')}">{$LANG.myhome_count_articles}</a>
		</div>
		<div class="clsMainArticleHeadDetRight">
			<p>
            	<a href="{$myobj->getUrl('articlelist', '?pg=articlenew', 'articlenew/','','article')}">{$myobj->articleTotalCount()}</a>
                <span>{$LANG.myhome_count_articles} </span>
			</p>
		</div>
	</div>
	<div class="clsMainArticleHeadRight">
	           <div class="clsMyArticleShortcut clsOverflow">
	            <ul>
	                <li class="selDropDownLink">
	                    <div class="clsMyArticlehortcutLeft">
	                        <div class="clsMyArticlehortcutRight">
	                            <a href="#">{$LANG.common_article_head_article_shortcuts}</a>
	                        </div>
	                    </div>
	                    <ul class="clsMyshortcutDropdown">
						{$myobj->setTemplateFolder('general/', 'article')}
						{include file="box.tpl" opt="listdropdown_top"}
							<li>
								<a href="{$myobj->getUrl('articlewriting', '', '','','article')}">{$LANG.common_article_head_upload_article}</a>
							</li>
							<li>
								<a href="{$myobj->getUrl('articlelist', '?pg=articlenew', 'articlenew/','','article')}">{$LANG.common_article_head_all_article}</a>
							</li>

							<li>
								<a href="{$myobj->getUrl('articlelist', '?pg=myarticles', 'myarticles/','','article')}">{$LANG.common_article_head_my_article}</a>
							</li>
                            <li>
                                <a href="{$myobj->getUrl('managearticlecomments', '', '','','article')}">{$LANG.common_article_head_manage_article_comments}</a>
                            </li>
						{$myobj->setTemplateFolder('general/', 'article')}
						{include file="box.tpl" opt="listdropdown_bottom"}
						</ul>
	                </li>
	            </ul>
	        </div>
   </div>
</div>
<div class="clsBreadcum">
	<p>
		<a href="{$myobj->getUrl('index','','','','')}" title="{$LANG.common_article_link_home}">{$LANG.common_article_link_home}</a>
    	{if $myobj->_currentPage == 'index'}
    		<span>{$LANG.common_article_link_article}</span>
    	{else}
	    	<a href="{$myobj->getUrl('index','','','','article')}" title="{$LANG.common_article_link_article}"><span>{$LANG.common_article_link_article}</span></a>
	        {if $myobj->_currentPage == 'articlelist'}
	        	<span>{$LANG.common_article_link_view_all_article}</span>
	        {elseif $myobj->_currentPage == 'articlewriting'}
	        	<span>{$LANG.common_article_link_upload_article}</span>
	        {elseif $myobj->_currentPage == 'manageattachments'}
	        	<span>{$LANG.common_article_link_article_attachments}</span>
	        {elseif $myobj->_currentPage == 'viewarticle'}
	        	<span>{$LANG.common_article_link_view_article}</span>
	        {elseif $myobj->_currentPage == 'managearticlecomments'}
	        	<span>{$LANG.common_article_link_manage_article_comments}</span>
	        {elseif $myobj->_currentPage == 'articlecategory'}
	        	<span>{$LANG.common_article_link_article_categories}</span>
	        {elseif $myobj->_currentPage == 'tags'}
	        	<span>{$LANG.common_article_link_article_tags}</span>
	        {/if}
	    {/if}
	</p>
</div>


{if !$myobj->chkIsAllowedLeftMenu()}
    <!--SIDEBAR-->

<!--SIDEBAR-->
<div id="sideBar">
  <!--SIDEBAR1-->
  <div class="sideBar1">
    <div class="clsSideBar1Article" id="sideBarArticle">

		{* ARTICLE RECENT ACTIVITIES STARTS *}
		{if  $myobj->_currentPage == 'index'}
        {$myobj->setTemplateFolder('general/', 'article')}
        <div class="clsIndexMainContainer">{include file="indexActivityHead.tpl"}</div>
        {/if}
		{* ARTICLE RECENT ACTIVITIES STARTS *}

		{* ----------------------Activities Content ends ---------------------- *}

         {* MY article SECTION STARTS *}
            {$myobj->populateMemberDetail('article')}
         {* MY article SECTION ENDS *}

         {if $myobj->_currentPage == 'index'}
                {* TOP WRITTERS SECTION STARTS *}
                    {if $myobj->isShowPageBlock('sidebar_topcontributors_block')}
                        {$myobj->topWritters()}
                    {/if}
                {* TOP WRITTERSS SECTION ENDS *}
        {/if}

         {* GENRES SECTION STARTS *}
             {$myobj->populateGenres()}
         {* GENRES SECTION ENDS *}

		 {* BANNER SECTION STARTS *}
		 {if $myobj->_currentPage=='index'}
		   <div class="cls336pxBanner">
			   <div>{php}getAdvertisement('sidebanner1_336x280'){/php}</div>
		   </div>
		  {/if} 
		 {* BANNER SECTION ENDS *}

         {* ARTICLE TAG SECTION STARTS *}
             	{$myobj->populateSidebarClouds('article', 'article_tags')}
         {* ARTICLE TAG SECTION ENDS *}
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
