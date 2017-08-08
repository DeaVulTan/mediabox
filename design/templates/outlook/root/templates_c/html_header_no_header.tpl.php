<?php /* Smarty version 2.6.18, created on 2012-01-21 09:06:50
         compiled from ../general/html_header_no_header.tpl */ ?>
<?php echo '<?xml'; ?>
 version="1.0"<?php echo '?>'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en-US" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
	<head>
	    <meta http-equiv="content-type" content="application/xhtml+xml; charset=<?php echo $this->_tpl_vars['CFG']['site']['charset']; ?>
" />
	    <meta http-equiv="content-Language" content="<?php echo $this->_tpl_vars['CFG']['lang']['default']; ?>
" />
	    <meta name="keywords" content="<?php echo $this->_tpl_vars['header']->getMetaKeywords(); ?>
" />
	    <meta name="description" content="<?php echo $this->_tpl_vars['header']->getMetaDescription(); ?>
" />
	    <meta name="version" content="<?php echo $this->_tpl_vars['CFG']['version']['number']; ?>
" />
	    <meta name="verify-v1" content="<?php echo $this->_tpl_vars['CFG']['html']['meta']['verify_v1']; ?>
" />
	    <?php if ($this->_tpl_vars['CFG']['html']['meta']['MSSmartTagsPreventParsing']): ?>
	    <!-- Disable MSSmartTags -->
	    <meta name="MSSmartTagsPreventParsing" content="true" />
		<?php endif; ?>
	    <?php if ($this->_tpl_vars['CFG']['html']['meta']['imagetoolbar'] != '1'): ?>
	    <!-- Disable IE6 image toolbar? -->
	    <!-- Disable IE6 image toolbar -->
	    <meta http-equiv="imagetoolbar" content="no" />
		<?php endif; ?>
	    <?php if ($this->_tpl_vars['header']->_currentPage == 'viewvideo'): ?>
	    	<link rel="image_src" href="<?php echo $this->_tpl_vars['video_url']; ?>
" type="image/jpeg" />
		<?php endif; ?>
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
       
        
        <?php $this->assign('flag_css', 0); ?> 
	    <?php $_from = $this->_tpl_vars['CFG']['site']['modules_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module_value']):
?>
	        <?php if (chkAllowedModule ( array ( $this->_tpl_vars['module_value'] ) ) && $this->_tpl_vars['CFG']['site']['is_module_page'] == $this->_tpl_vars['module_value']): ?>
            	<?php $this->assign('flag_css', 1); ?> 
	            <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['myobj']->getDefaultCssUrl('general',$this->_tpl_vars['module_value']); ?>
" media="screen" title="<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
" />
	            <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['myobj']->getDefaultCssUrl('include',$this->_tpl_vars['module_value']); ?>
" media="screen" title="<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
" />
	        <?php endif; ?>
	    <?php endforeach; endif; unset($_from); ?>
        <?php if ($this->_tpl_vars['flag_css'] == 0): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['myobj']->getDefaultCssUrl('general'); ?>
" media="screen" title="<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
" />
            <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['myobj']->getDefaultCssUrl('common'); ?>
" media="screen" title="<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
" />
        <?php endif; ?>
        
                <?php if ($this->_tpl_vars['CFG']['site']['script_name'] == 'flashShow.php'): ?>
        <?php echo '
			<style type="text/css">
                html, body {
                  height: 100%;
                  width: 100%;
                  margin: 0;
                  padding: 0;
                }
            </style>
        '; ?>

        <?php endif; ?>
        
		<link rel="shortcut icon" href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/favicon.ico" type="image/x-icon" />
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

		<title><?php echo $this->_tpl_vars['header']->getPageTitle(); ?>
</title>
	</head>
<body class="clsLightWindowBackground">