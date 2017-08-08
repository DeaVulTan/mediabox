<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
        
        {*FIX for Photos Module Viewslidelist Flashplayer width and height *}
        {if $CFG.site.script_name =='flashShow.php'}
        {literal}
			<style type="text/css">
                html, body {
                  height: 100%;
                  width: 100%;
                  margin: 0;
                  padding: 0;
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
		<title>{$header->getPageTitle()}</title>
	</head>
<body class="clsLightWindowBackground">
