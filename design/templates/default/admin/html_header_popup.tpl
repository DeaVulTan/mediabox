<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="{$CFG.lang.default}" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset={$CFG.site.charset}" />
<meta http-equiv="content-Language" content="{$CFG.lang.default}" />
<meta name="keywords" content="{$CFG.html.meta.keywords}" />
<meta name="description" content="{$CFG.html.meta.description}" />
<meta name="version" content="{$CFG.version.number}" />

{if $CFG.html.meta.MSSmartTagsPreventParsing}
	<!-- Disable MSSmartTags -->
	<meta name="MSSmartTagsPreventParsing" content="true" />
{/if}
{if not $CFG.html.meta.imagetoolbar}
    <!-- Disable IE6 image toolbar? -->
    <!-- Disable IE6 image toolbar -->
    <meta http-equiv="imagetoolbar" content="no" />
{/if}
<!-- default stylesheet -->
<link rel="stylesheet" type="text/css" href="{$html_stylesheet}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
<link rel="stylesheet" type="text/css" href="{$CFG.site.url}design/css/print.css" media="print" />
<link rel="shortcut icon" href="{$CFG.site.url}design/templates/{$CFG.html.template.default}/favicon.ico" type="image/x-icon" />
<!--
//http://www.w3.org/TR/REC-html40/types.html#type-links
//http://www.w3.org/TR/xhtml-modularization/abstraction.html#dt_LinkTypes
//LinkBars: http://webcoder.info/reference/LinkBars.html
//Definitions: http://fantasai.tripod.com/qref/Appendix/LinkTypes/ltdef.html
//List (grabbed from above link) 28: home, begin, end, next, previous, up, top, parent, child, sibling, glossary, definition, footnote, citation, biblioentry, help, navigator, toc, contents, index, search, bookmark, banner, copyright, stylesheet, script, alternate, translation
-->
<!-- for link bar -->
<link rel="Home"     href="{$CFG.site.url}" title="Home page" />
<link rel="Index"    href="{$CFG.site.url}" title="Index" />
<link rel="search"   href="#" title="Search this site" />
<link rel="contents" href="#" title="Site map" />
{$header->includeJsFiles()}
<title>{$CFG.site.title}</title>
</head>
<body class="clsPopupHeader">
<div id="{$CFG.html.page_id}">
<!-- alert box -->
<div id="selAlertbox" class="clsPopupAlert" style="display:none;">
  <p id="selAlertMessage"></p>
  <form name="formAlertBox" id="formAlertBox" action="">
    <input type="button" class="clsSubmitButton" name="selAlertOkButton" id="selAlertOkButton" value="{$LANG.header_ok_button}" onclick="return hideAllBlocks();" />
  </form>
</div>
<!-- Accessibility Links -->
<div id="top">
  <ul>
    <li><a href="#main">Skip to main content</a></li>
    <li><a href="#selSubHeader">Skip to Navigation Links</a></li>
    <li><a href="#footer">Skip to Footer</a></li>
  </ul>
</div>
<!-- Header -->
<div id="header">
  <h1><a href="index.php" title="Browse to homepage">{$CFG.site.name}</a></h1>
</div>
<!-- Main -->
<div id="selOuterMainContent">
<div id="selInnerMainContent">
<div id="selMainContent">
<div id="main">
<!-- Header ends -->
