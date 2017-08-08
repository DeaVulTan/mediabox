<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en-US" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset={$CFG.site.charset}" />
	<meta http-equiv="content-Language" content="en-US" />
	<meta name="keywords" content="{$header->getMetaKeywords()}" />
	<meta name="description" content="{$header->getMetaDescription()}" />
	<meta name="version" content="{$CFG.version.number}" />
	{if $CFG.html.meta.MSSmartTagsPreventParsing}
		<!-- Disable MSSmartTags -->
		<meta name="MSSmartTagsPreventParsing" content="true" />
	{/if}
	{ if $CFG.html.meta.imagetoolbar ne '1' } <!-- Disable IE6 image toolbar? -->
		<!-- Disable IE6 image toolbar -->
		<meta http-equiv="imagetoolbar" content="no" />
	{/if}
	<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('footer')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
	<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('form')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
	<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('layout')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
	<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('general')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
	<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('include')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
    {foreach from=$CFG.site.modules_arr item=module_value}
        {if chkAllowedModule(array($module_value)) and $CFG.site.is_module_page==$module_value}
            <link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('general', $module_value)}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
            <link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('include', $module_value)}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
        {/if}
    {/foreach}
    {*FIX for Search Box image in IE 6 (Lightwindow Pages without <xml> tag)*}
    {if $CFG.admin.light_window_page}
    {literal}
		<style type="text/css">
        * html .clsSearchBoxBg,* html .clsFooterSearchBoxBg{
            width:202px !important;
        }
        </style>
    {/literal}
    {/if}
	<link rel="shortcut icon" href="{$CFG.site.url}design/templates/{$CFG.html.template.default}/favicon.ico" type="image/x-icon" />
<!-- for link bar -->
	<link rel="Home"     href="{$CFG.site.url}" title="Home page" />
	<link rel="Index"    href="{$CFG.site.url}" title="Index" />
	<link rel="search"   href="#" title="Search this site" />
	<link rel="contents" href="#" title="Site map" />
	<link rel="copyright" href="{php}global $CFG;echo getUrl('static', '?pg=copyright', 'copyright/', 'root');{/php}" title="Copyright information" />
	<link rel="author"   href="{php}global $CFG;echo getUrl('static', '?pg=author', 'author/', 'root');{/php}" title="Author information" />
    {$header->includeJsFiles()}
	{$header->loadJsScriptVariables()}
	<script type="text/javascript" src="{$CFG.site.url}js/lib/controls.js"></script>
	<script type="text/javascript" src="{$CFG.site.url}js/lib/slider.js"></script>
	<script type="text/javascript"	src="{$CFG.site.url}js/lib/calendar/calendar.js"></script>
	<script type="text/javascript"	src="{$CFG.site.url}js/lib/calendar/calendar-en.js"></script>
	<script type="text/javascript"	src="{$CFG.site.url}js/lib/calendar/calendar-setup.js"></script>
	<script type="text/javascript"	src="{$CFG.site.url}js/lib/event-selectors.js"></script>
	<script type="text/javascript"	src="{$CFG.site.url}js/script.js"></script>
	<script type="text/javascript"	src="{$CFG.site.url}js/functions.js"></script>
	<title>{$header->getPageTitle()}</title>
    <script type="text/javascript">
	var blog_ajax_page_loading = '<img alt="{$LANG.common_blog_loading}"       src="{$CFG.site.url}blog/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/loader.gif" />';
	var blog_site_url = '{$CFG.site.blog_url}';
	</script>
     <script src="{$CFG.site.blog_url}js/functions.js" type="text/javascript"></script>
</head>
<body>
<div class="clsBlogMain">
<div class="clsPostHeader">
  <div class="clsBlogHeader">
  	  <h1><a href="{$CFG.site.blog_url}">Logo</a></h1>
      <div class="clsPreviousNextLinks">
		  <ul>
			  {if !$myobj->previousPostLink}
				<li class="clsPrevInActive"><a>{$LANG.common_header_previous_post_link}</a></li>
			  {else}
				<li class="clsPrevActive"><a href="{$myobj->previousPostLink}">{$LANG.common_header_previous_post_link}</a></li>
			  {/if}
			 <li class="clsStripTopHeader">|</li>
			  {if !$myobj->nextPostLink}
				 <li class="clsNextInActive"> <a>{$LANG.common_header_next_post_link}</a></li>

			  {else}
				 <li class="clsNextActive"><a href="{$myobj->nextPostLink}">{$LANG.common_header_next_post_link}</a></li>
			  {/if}
		  </ul>
	    </div>
	    <div  class="clsViewBlogRightHeader">
			  <ul class="clsViewBlogHeaderLinks">
				  {if $myobj->checkBlogAdded}
						<li class="clsCreateBlog"><a  href="{$myobj->getUrl('manageblog', '', '', 'members', 'blog')}"><span>{$LANG.common_manage_edit_blog}</span></a></li>
				 {else}
						<li class="clsCreateBlog"><a  href="{$myobj->getUrl('manageblog', '', '', 'members', 'blog')}"><span>{$LANG.common_manage_add_blog}</span></a></li>
				 {/if}

				 {if isMember()}
						<li class="clsSignIn"><a class="" href="{$header->getUrl('logout', '', '', 'root')}" title="{$LANG.header_logout_link}"><span>{$LANG.header_logout_link}</span></a></li>
				 {else}
						<li class="clsSignIn"><a href="{$header->getUrl('login', '', '', 'root')}" title="{$LANG.header_login_link}"><span>{$LANG.header_login_link}</span></a></li>
				 {/if}
			  </ul>
		  </div>
 	 </div>
</div>
<div  class="clsBodyContent clsViewBlogList">
<div class="clsViewPostBanner clsOverflow">
             <div class="clsViewBlogLogo">
             		<a href="{$myobj->getFormField('blog_url')}" class="ClsImageContainer ClsImageBorder1 cls150px90px"><img src="{$myobj->getFormField('blog_logo_src')}" alt="{$myobj->getFormField('blog_title')}" title="{$myobj->getFormField('blog_title')}" /></a>
             </div>
              <div class="clsViewBlogTitle">
              	<p><span>{$myobj->getFormField('blog_title')}</span></p>
                <p class="clsViewBlogSubTitle">{$myobj->getFormField('blog_slogan')}</p>
              </div>
       </div>

<!--SIDEBAR-->

