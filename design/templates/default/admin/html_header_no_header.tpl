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

        <link rel="stylesheet" type="text/css" href="{$html_stylesheet}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
        <link rel="stylesheet" type="text/css" href="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/css/{$CFG.html.stylesheet.screen.default}/print.css" media="print" />
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
