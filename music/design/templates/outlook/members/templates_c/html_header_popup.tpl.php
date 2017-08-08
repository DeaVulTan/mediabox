<?php /* Smarty version 2.6.18, created on 2011-10-24 16:50:56
         compiled from ../general/html_header_popup.tpl */ ?>
<?php if (! $this->_tpl_vars['CFG']['admin']['light_window_page']): ?>
<?php echo '<?xml'; ?>
 version="1.0"<?php echo '?>'; ?>

<?php endif; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en-US" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=<?php echo $this->_tpl_vars['CFG']['site']['charset']; ?>
" />
	<meta http-equiv="content-Language" content="en-US" />
	<meta name="keywords" content="<?php echo $this->_tpl_vars['header']->getMetaKeywords(); ?>
" />
	<meta name="description" content="<?php echo $this->_tpl_vars['header']->getMetaDescription(); ?>
" />
	<meta name="version" content="<?php echo $this->_tpl_vars['CFG']['version']['number']; ?>
" />
	<?php if ($this->_tpl_vars['CFG']['html']['meta']['MSSmartTagsPreventParsing']): ?>
		<!-- Disable MSSmartTags -->
		<meta name="MSSmartTagsPreventParsing" content="true" />
	<?php endif; ?>
	<?php if ($this->_tpl_vars['CFG']['html']['meta']['imagetoolbar'] != '1'): ?> <!-- Disable IE6 image toolbar? -->
		<!-- Disable IE6 image toolbar -->
		<meta http-equiv="imagetoolbar" content="no" />
	<?php endif; ?>
<!--default stylesheet-->
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['html_stylesheet']; ?>
" media="screen" title="<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['myobj']->getDefaultCssUrl('general'); ?>
" media="screen" title="<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['myobj']->getDefaultCssUrl('layout'); ?>
" media="screen" title="<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['myobj']->getDefaultCssUrl('header'); ?>
" media="screen" title="<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['myobj']->getDefaultCssUrl('footer'); ?>
" media="screen" title="<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['myobj']->getDefaultCssUrl('form'); ?>
" media="screen" title="<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['myobj']->getDefaultCssUrl('include'); ?>
" media="screen" title="<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
" />
      <?php $_from = $this->_tpl_vars['CFG']['site']['modules_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module_value']):
?>
        <?php if (chkAllowedModule ( array ( $this->_tpl_vars['module_value'] ) ) && $this->_tpl_vars['CFG']['site']['is_module_page'] == $this->_tpl_vars['module_value']): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['myobj']->getDefaultCssUrl('general',$this->_tpl_vars['module_value']); ?>
" media="screen" title="<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
" />
        <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?>
	<link rel="shortcut icon" href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/favicon.ico" type="image/x-icon" />
<!--
	//http://www.w3.org/TR/REC-html40/types.html#type-links
	//http://www.w3.org/TR/xhtml-modularization/abstraction.html#dt_LinkTypes
	//LinkBars: http://webcoder.info/reference/LinkBars.html
	//Definitions: http://fantasai.tripod.com/qref/Appendix/LinkTypes/ltdef.html
	//List (grabbed from above link) 28: home, begin, end, next, previous, up, top, parent, child, sibling, glossary, definition, footnote, citation, biblioentry, help, navigator, toc, contents, index, search, bookmark, banner, copyright, stylesheet, script, alternate, translation
-->
<!-- for link bar -->
	<link rel="Home"     href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
" title="Home page" />
	<link rel="Index"    href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
" title="Index" />
	<link rel="search"   href="#" title="Search this site" />
	<link rel="contents" href="#" title="Site map" />
	<link rel="copyright" href="<?php global $CFG;echo getUrl('static', '?pg=copyright', 'copyright/', 'root'); ?>" title="Copyright information" />
	<link rel="author"   href="<?php global $CFG;echo getUrl('static', '?pg=author', 'author/', 'root'); ?>" title="Author information" />
	<?php echo $this->_tpl_vars['header']->includeJsFiles(); ?>

	<script type="text/javascript">
        <?php if ($this->_tpl_vars['CFG']['site']['jserror_block']): ?>
        <?php echo '
        function blockError(){ return true; }
        window.onerror = blockError;
		'; ?>

        <?php endif; ?>
    </script>
	<title><?php echo $this->_tpl_vars['header']->getPageTitle(); ?>
</title>
</head>
<body id="<?php echo $this->_tpl_vars['CFG']['html']['page_id']; ?>
" class="clsPopUpBodyBackground" onload="">
	<!-- starting of clsBodyContent -->
	<div class="clsPopUpHeaderWidth">
	<!-- starting of clsInnerBodyContent -->
	<div class="clsInnerBodyContent">
	<!-- for deactivate the page -->
	<div id="hideScreen" style="z-index: 100; display: none;" class="VeilStyle1c">&nbsp;</div>
	<!-- only ajax window -->
	<div id="selAjaxWindow" style="display:none;position:absolute;">
		<p><a href="#" onclick="return hideAllBlocks()"><?php echo $this->_tpl_vars['LANG']['header_close_link']; ?>
</a></p>
		<span id="selAjaxWindowInnerDiv"></span>
		<form name="frmAjaxWindow" action="">
		</form>
	</div>
	<!-- alert box -->
	<div id="selAlertbox" class="clsPopupAlert clsPopupConfirmation" style="display:none;">
	 	<p id="selAlertMessage"></p>
	  	<form name="formAlertBox" id="formAlertBox" action="">
	    	<input type="button" class="clsSubmitButton" name="selAlertOkButton" id="selAlertOkButton" value="<?php echo $this->_tpl_vars['LANG']['header_ok_button']; ?>
" onclick="return hideAllBlocks();" />
	  	</form>
	</div>
	<!-- Accessibility Links -->
	<div id="top">
	    <ul>
	      <li><a href="#main"><?php echo $this->_tpl_vars['LANG']['header_skip_main_content']; ?>
</a></li>
	      <li><a href="#selSubHeader"><?php echo $this->_tpl_vars['LANG']['header_skip_navigation_links']; ?>
</a></li>
	      <li><a href="#footer"><?php echo $this->_tpl_vars['LANG']['header_skip_footer']; ?>
</a></li>
	    </ul>
	</div>
	<!-- Header -->
    <div class="">

        <div class="<?php if ($this->_tpl_vars['CFG']['html']['current_script_name'] == 'playSongsInPlaylist' || $this->_tpl_vars['CFG']['html']['current_script_name'] == 'organizePlaylist'): ?>clsButtonHeader<?php endif; ?>">
            <div id="header" class="clsHeaderContainer">
    <div class="clsHeaderShadowImage">
        <div class="clsHeaderBlock">
            <div class="clsMainLogo">
                <h1>
                    <a href="<?php echo $this->_tpl_vars['header']->index_page_link; ?>
"><img src="<?php echo $this->_tpl_vars['header']->logo_url; ?>
" alt="<?php echo $this->_tpl_vars['CFG']['site']['name']; ?>
" title="<?php echo $this->_tpl_vars['CFG']['site']['name']; ?>
" /></a>
                </h1>
            </div>
        </div>
    </div>
</div>
            <?php if ($this->_tpl_vars['CFG']['html']['current_script_name'] == 'playSongsInPlaylist' || $this->_tpl_vars['CFG']['html']['current_script_name'] == 'organizePlaylist'): ?>
            <div class="clsHeaderButtonHolder">
			<!--Edit Link Visible only when Playlist PopUp Clicked-->
            	<?php if ($this->_tpl_vars['CFG']['html']['current_script_name'] == 'playSongsInPlaylist' && $this->_tpl_vars['myobj']->getFormField('playlist_id')): ?>
                	<?php if ($this->_tpl_vars['myobj']->total_tracks && isMember ( )): ?>
                        <p class="clsPopupSave" id="save_quick_mix">
                        <span><a href="javascript:void(0)" onclick="playlistReorderRedirect('<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
');return false;"><?php echo $this->_tpl_vars['LANG']['common_msg_edit_playlist']; ?>
</a></span></p>
                    <?php endif; ?>
                        <p class="clsPopupCancel"><span><a href="javascript:void(0)" onclick="addQuickMixRedirect('<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
');return false;"><?php echo $this->_tpl_vars['LANG']['common_msg_cancel_playlist']; ?>
</a></span></p>
                <?php endif; ?>
            	<?php if ($this->_tpl_vars['CFG']['html']['current_script_name'] == 'organizePlaylist'): ?>
                	<?php if ($this->_tpl_vars['myobj']->isResultsFound): ?>
                    <form name="reorder_frm" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" method="post">
                        <p class="clsPopupSave"><span>
                        	<input type="button" onclick="saveDragDropNodes('<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
')" value="Save">
                        </span></p>
                        <p class="clsPopupCancel"><span>
                        	<input type="button" onclick="playlistEditRedirect('<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
');" value="<?php echo $this->_tpl_vars['LANG']['common_msg_cancel_playlist']; ?>
">
                        </span></p>
                    </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

    </div>

	<!-- Main -->
	<div id="selOuterMainContent" class="clsPopUpHeaderContent">
	<!-- Header ends -->