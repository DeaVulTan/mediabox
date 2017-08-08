{if !$CFG.admin.light_window_page}
<?xml version="1.0"?>
{/if}
{if 1 or !$header->chkIsProfilePage()}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
{/if}
<html lang="en-US" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
	<head>
	    <meta http-equiv="content-type" content="application/xhtml+xml; charset={$CFG.site.charset}" />
	    <meta http-equiv="content-Language" content="{$CFG.lang.default}" />
	    <meta name="keywords" content="{$header->getMetaKeywords()}" />
	    <meta name="description" content="{$header->getMetaDescription()}" />
	    <meta name="version" content="{$CFG.version.number}" />
	    <meta name="verify-v1" content="{$CFG.html.meta.verify_v1}" />
	    {if $CFG.html.meta.MSSmartTagsPreventParsing}
	    <!-- Disable MSSmartTags -->
	    <meta name="MSSmartTagsPreventParsing" content="true" />
		{/if}
	    {if $CFG.html.meta.imagetoolbar ne '1' }
	    <!-- Disable IE6 image toolbar? -->
	    <!-- Disable IE6 image toolbar -->
	    <meta http-equiv="imagetoolbar" content="no" />
		{/if}
	    {if $header->_currentPage == 'viewvideo'}
	    	<link rel="image_src" href="{$video_url}" type="image/jpeg" />
		{/if}
		<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('header')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
		<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('footer')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
		<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('form')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
		<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('include')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />


        {assign var=flag_css value=0}
	    {foreach from=$CFG.site.modules_arr item=module_value}
	        {if chkAllowedModule(array($module_value)) and $CFG.site.is_module_page==$module_value}
            	{assign var=flag_css value=1}
	            <link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('general', $module_value)}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
	            <link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('include', $module_value)}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
	        {/if}
	    {/foreach}
        {if $flag_css == 0}
            <link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('general')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
            <link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('common')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
        {/if}
	    {if $header->_currentPage == 'index' and !$CFG.site.is_module_page}
			<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('index')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
        {/if}

	    {*FIX for Search Box image in IE 6 (Lightwindow Pages without <xml> tag)*}
	    {if $CFG.admin.light_window_page}
	    {literal}
			<style type="text/css">
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
	    {$header->populateSearchRelatedJs()}
		<title>{$header->getPageTitle()}</title>
	</head>
<body onload="logInUser();" onunload="logOutUser()" id="{$CFG.html.page_id}">

{* Hack for ie6 issues caused by lightwindow - start *}
    {if $CFG.admin.light_window_page}
        <div class="clsMembersPage">
    {/if}
{* Hack for ie6 issues caused by lightwindow - end *}

{* Profile page background applied by member -start *}
{if $myobj->profile_background && ($myobj->background_color || $myobj->background_image)}
	<div class="clsProfilePageBacground" style="background:{$myobj->background_color}{$myobj->background_image} {if $myobj->background_repeat =='Yes'}repeat{else}no-repeat{/if} center 134px;">
{/if}
{* Profile page background applied by member -end *}

{php}if(isset($this->bodyBackgroundImage) && $this->bodyBackgroundImage){{/php}
<div class="clsBodyBanner" style="background:url({php} echo $this->bodyBackgroundImage{/php}) no-repeat center 230px;">
{php}}{/php}

<!--bodybackground starts-->
<div class="clsBodyBackground">

	<div id="hideScreen" style="z-index: 100; display: none;" class="VeilStyle1c">&nbsp;</div>

   <!-- selpagebody starts-->
	<div id="selPageBody">

		<a href="#" id="alertHyperLink"></a>
		<!-- alert box start -->
		<div id="selAlertbox" title="{$CFG.site.name}" style="display:none;">
			<p id="selAlertMessage"></p>
		</div>
		<!-- alert box end -->
		<!-- login ajax popup div start -->
		<div id="selAjaxLoginWindow" title="{$CFG.site.name}" style="display:none;">
			<div id="selAjaxLoginContent"></div>
		</div>
		<!-- login ajax popup div end -->
		<!-- ajax popup div start -->
		<div id="selAjaxWindow" style="display:none;">
			<div id="selAjaxWindowInnerDiv"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/procesing.gif" alt="{$LANG.common_loading}..." /></div>
			<form name="frmAjaxWindow" action="">
			</form>
		</div>
		<!-- ajax popup div end -->
        <!-- Accessibility Links -->
        <div id="top">
          <ul>
            <li><a href="#main">Skip to main content</a></li>
            <li><a href="#selSubHeader">Skip to Navigation Links</a></li>
            <li><a href="#footer">Skip to Footer</a></li>
          </ul>
        </div>
        <!-- Header -->
