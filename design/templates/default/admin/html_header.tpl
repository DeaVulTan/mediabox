{if !$CFG.admin.light_window_page}
<?xml version="1.0"?>
{/if}
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
<!-- alternate stylesheets -->
<!-- default stylesheet -->
<link rel="stylesheet" type="text/css" href="{$html_stylesheet}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
<link rel="stylesheet" type="text/css" href="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/css/{$CFG.html.stylesheet.screen.default}/print.css" media="print" />
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
{$header->includeJsFiles()}
<title>{$CFG.site.title}</title>
</head><body onload="adminMenuNavigation('{$myobj->left_navigation_div}')">
<!-- starting of clsBodyContent -->
<div id="{$CFG.html.page_id}" class="clsBodyContent">
<!-- starting of clsInnerBodyContent -->
<div class="clsInnerBodyContent">
<!-- for deactivate the page -->
<div id="hideScreen" style="z-index: 100;display:none;" class="VeilStyle1c">&nbsp;</div>
<!-- only ajax window -->
<div id="selAjaxWindow" style="display:none;">
  <span id="selAjaxWindowInnerDiv"></span>
  <form name="frmAjaxWindow" id="frmAjaxWindow" action="">
  </form>
</div>
<!-- alert box start -->
<div id="selAlertbox" title="{$CFG.site.name}" style="display:none;">
	<p id="selAlertMessage"></p>
</div>
<!-- alert box end -->
<!-- Accessibility Links -->
<div id="top">
  <ul>
    <li><a href="#main">{$LANG.header_skip_main_content}</a></li>
    <li><a href="#selSubHeader">{$LANG.header_skip_navigation_links}</a></li>
    <li><a href="#footer">{$LANG.header_skip_footer}</a></li>
  </ul>
</div>
<iframe name="facebook_logout" id="facebook_logout" style="display:none"></iframe>
<!-- Header -->
<div id="header" class="clsOverflow">
  <h1><a href="{$CFG.site.url}admin/index.php" title="Browse to homepage">{$CFG.site.name}</a></h1>
  <!-- clsLangStyleSwitcher -->
  <div class="clsLangStyleSwitcher">
   	<div class="clsAdminUserName"><h3>{$header->populateUserName()}</h3></div>
 </div>
  <!-- End of clsLangStyleSwitcher -->
</div>
<!-- End of header -->
<!-- selSubHeader -->
<div id="selSubHeader">
  <!-- selNavigation -->
  <div id="selNavigation">
    <!-- selNavigationContent -->
    <div id="selNavigationContent">
      <!-- selNav -->
      <div id="selNav" class="clsMenu">
        {$header->populateAdminTopNavigation()}
      </div>
      <!-- End of selNav -->
    </div>
    <!-- End of selNavigationContent -->
  </div>
  <!-- End of selNavigation -->
</div>
<!-- End of selSubHeader -->
<!-- SideBar -->
<div class="clsAdminTableContainer">
<table class="clsAdminTable"><tr><td class="clsAdminTableSideBar">
<div id="sideBar">
<!-- SideBar1 -->
    <div class="sideBar1">
        <div id="selAdminNavLinks">
          {$header->populateAdminDefaultLeftNavigation()}
        </div>
    </div>
</div></td>
<!-- Main -->
<td class="clsAdminTableMain"><div id="main">
<div id="selMainContent">
<!-- Header ends -->
<div id="selLoading" style="display:none;"><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/admin/images/{$CFG.html.stylesheet.screen.default}/loading.gif" /></div>
