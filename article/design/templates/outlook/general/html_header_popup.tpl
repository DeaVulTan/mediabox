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
<!--default stylesheet-->
	<link rel="stylesheet" type="text/css" href="{$html_stylesheet}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
	<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('general')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
	<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('layout')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
	<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('header')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
	<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('footer')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
	<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('form')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
	<link rel="stylesheet" type="text/css" href="{$CFG.site.url}design/css/print.css" media="print" />
      {foreach from=$CFG.site.modules_arr item=module_value}
        {if chkAllowedModule(array($module_value)) and $CFG.site.is_module_page==$module_value}
            <link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('general', $module_value)}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
             <link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('include', $module_value)}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
        {/if}
      {/foreach}
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
	<link rel="copyright" href="{php}global $CFG;echo getUrl('static', '?pg=copyright', 'copyright/', 'root');{/php}" title="Copyright information" />
	<link rel="author"   href="{php}global $CFG;echo getUrl('static', '?pg=author', 'author/', 'root');{/php}" title="Author information" />
	    {$header->includeJSLanguageFile()}
    {$header->loadJsScriptVariables()}
	<script type="text/javascript" src="{$CFG.site.url}js/lib/prototype.js"></script>
	<script type="text/javascript" src="{$CFG.site.url}js/lib/scriptaculous.js?load=effects"></script>
    <script type="text/javascript" src="{$CFG.site.url}js/lib/jquery.js"></script>
        <script type="text/javascript">
		//Initialize Jquery in $Jq variable
		var $Jq = jQuery.noConflict();
	</script>
	<script type="text/javascript" src="{$CFG.site.url}js/lib/effects.js"></script>
	<script type="text/javascript"	src="{$CFG.site.url}js/lib/calendar/calendar.js"></script>
	<script type="text/javascript"	src="{$CFG.site.url}js/lib/calendar/calendar-en.js"></script>
	<script type="text/javascript"	src="{$CFG.site.url}js/lib/calendar/calendar-setup.js"></script>
	<script type="text/javascript"	src="{$CFG.site.url}js/lib/event-selectors.js"></script>
	<script type="text/javascript"	src="{$CFG.site.url}js/script.js"></script>
	<script type="text/javascript"	src="{$CFG.site.url}js/functions.js"></script>
	<script type="text/javascript"	src="{$CFG.site.url}js/effects.js"></script>
	{if $CFG.admin.light_window_page}
	<script type="text/javascript" src="{$CFG.site.url}js/lib/lightwindow/lightwindow.js"></script>
	{/if}
	<title>{$header->getPageTitle()}</title>
</head>
<body id="{$CFG.html.page_id}" class="clsPopUpBodyBackground" onload="">
	<!-- starting of clsBodyContent -->
	<div class="clsBodyContent">
	<!-- starting of clsInnerBodyContent -->
	<div class="clsInnerBodyContent">
	<!-- for deactivate the page -->
	<div id="hideScreen" style="z-index: 100; display: none;" class="VeilStyle1c">&nbsp;</div>
	<!-- only ajax window -->
	<div id="selAjaxWindow" style="display:none;position:absolute;">
		<p><a href="#" onclick="return hideAllBlocks()">{$LANG.header_close_link}</a></p>
		<span id="selAjaxWindowInnerDiv"></span>
		<form name="frmAjaxWindow" action="">
		</form>
	</div>
	<!-- alert box -->
	<div id="selAlertbox" class="clsPopupAlert" style="display:none;position:absolute;">
	 	<p id="selAlertMessage"></p>
	  	<form name="formAlertBox" id="formAlertBox" action="">
	    	<input type="button" class="clsSubmitButton" name="selAlertOkButton" id="selAlertOkButton" value="{$LANG.header_ok_button}" onclick="return hideAllBlocks();" />
	  	</form>
	</div>
	<!-- Accessibility Links -->
	<div id="top">
	    <ul>
	      <li><a href="#main">{$LANG.header_skip_main_content}</a></li>
	      <li><a href="#selSubHeader">{$LANG.header_skip_navigation_links}</a></li>
	      <li><a href="#footer">{$LANG.header_skip_footer}</a></li>
	    </ul>
	</div>
	<!-- Header -->
	<div class="">
	{$myobj->setTemplateFolder('general/','article')}
    {include file="box.tpl" opt="header_popup_top"}
	<div id="header">
	<div class="clsArticlePopUpWindow">
	  <h1 class="clsNoHeader"><a>{$CFG.site.name}</a></h1>
	</div>
	
	{$myobj->setTemplateFolder('general/','article')}
    {include file="box.tpl" opt="header_popup_bottom"}
	</div>
	<!-- Main -->
	<div id="selOuterMainContent" class="clsPopUpHeaderContent">
	<!-- Header ends -->