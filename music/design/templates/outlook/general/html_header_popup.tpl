{if !$CFG.admin.light_window_page}
<?xml version="1.0"?>
{/if}
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
	<link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('include')}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
      {foreach from=$CFG.site.modules_arr item=module_value}
        {if chkAllowedModule(array($module_value)) and $CFG.site.is_module_page==$module_value}
            <link rel="stylesheet" type="text/css" href="{$myobj->getDefaultCssUrl('general', $module_value)}" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
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
	{$header->includeJsFiles()}
	<script type="text/javascript">
        {if $CFG.site.jserror_block}
        {literal}
        function blockError(){ return true; }
        window.onerror = blockError;
		{/literal}
        {/if}
    </script>
	<title>{$header->getPageTitle()}</title>
</head>
<body id="{$CFG.html.page_id}" class="clsPopUpBodyBackground" onload="">
	<!-- starting of clsBodyContent -->
	<div class="clsPopUpHeaderWidth">
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
	<div id="selAlertbox" class="clsPopupAlert clsPopupConfirmation" style="display:none;">
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

        <div class="{if $CFG.html.current_script_name=='playSongsInPlaylist' || $CFG.html.current_script_name=='organizePlaylist'}clsButtonHeader{/if}">
            <div id="header" class="clsHeaderContainer">
    <div class="clsHeaderShadowImage">
        <div class="clsHeaderBlock">
            <div class="clsMainLogo">
                <h1>
                    <a href="{$header->index_page_link}"><img src="{$header->logo_url}" alt="{$CFG.site.name}" title="{$CFG.site.name}" /></a>
                </h1>
            </div>
        </div>
    </div>
</div>
            {if $CFG.html.current_script_name=='playSongsInPlaylist' || $CFG.html.current_script_name=='organizePlaylist'}
            <div class="clsHeaderButtonHolder">
			<!--Edit Link Visible only when Playlist PopUp Clicked-->
            	{if $CFG.html.current_script_name=='playSongsInPlaylist' && $myobj->getFormField('playlist_id')}
                	{if $myobj->total_tracks && isMember()}
                        <p class="clsPopupSave" id="save_quick_mix">
                        <span><a href="javascript:void(0)" onclick="playlistReorderRedirect('{$myobj->getFormField('playlist_id')}');return false;">{$LANG.common_msg_edit_playlist}</a></span></p>
                    {/if}
                        <p class="clsPopupCancel"><span><a href="javascript:void(0)" onclick="addQuickMixRedirect('{$myobj->getFormField('playlist_id')}');return false;">{$LANG.common_msg_cancel_playlist}</a></span></p>
                {/if}
            	{if $CFG.html.current_script_name=='organizePlaylist'}
                	{if $myobj->isResultsFound}
                    <form name="reorder_frm" action="{$myobj->getCurrentUrl()}" method="post">
                        <p class="clsPopupSave"><span>
                        	<input type="button" onclick="saveDragDropNodes('{$myobj->getFormField('playlist_id')}')" value="Save">
                        </span></p>
                        <p class="clsPopupCancel"><span>
                        	<input type="button" onclick="playlistEditRedirect('{$myobj->getFormField('playlist_id')}');" value="{$LANG.common_msg_cancel_playlist}">
                        </span></p>
                    </form>
                    {/if}
                {/if}
            </div>
            {/if}
        </div>

    </div>

	<!-- Main -->
	<div id="selOuterMainContent" class="clsPopUpHeaderContent">
	<!-- Header ends -->