<?php /* Smarty version 2.6.18, created on 2013-07-02 16:28:07
         compiled from flashShow.tpl */ ?>
<script src="<?php echo $this->_tpl_vars['CFG']['site']['photo_url']; ?>
js/AC_RunActiveContent.js" type="text/javascript"></script>
  <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_photo_slide_show')): ?>
  <?php echo '
 <script language="javascript">
	if (AC_FL_RunContent == 0) {
		alert("This page requires AC_RunActiveContent.js.");
	} else {
		AC_FL_RunContent(
			\'codebase\', \'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0\',
			\'FlashVars\',
			\'configPath='; ?>
<?php echo $this->_tpl_vars['myobj']->configxmlPath; ?>
<?php echo '\',
			\'width\', \'100%\',
			\'height\', \'100%\',
			\'src\', \''; ?>
<?php echo $this->_tpl_vars['myobj']->configPath; ?>
<?php echo $this->_tpl_vars['myobj']->default_template; ?>
slideshow<?php echo '\',
			\'quality\', \'high\',
			\'pluginspage\', \'http://www.macromedia.com/go/getflashplayer\',
			\'align\', \'middle\',
			\'play\', \'true\',
			\'loop\', \'true\',
			\'scale\', \'noscale\',
			\'wmode\', \'window\',
			\'devicefont\', \'false\',
			\'id\', \'slideshow\',
			\'bgcolor\', \'#000000\',
			\'name\', \'slideshow\',
			\'menu\', \'true\',
			\'allowFullScreen\', \'true\',
			\'allowScriptAccess\',\'always\',
			\'movie\', \''; ?>
<?php echo $this->_tpl_vars['myobj']->configPath; ?>
<?php echo $this->_tpl_vars['myobj']->default_template; ?>
slideshow<?php echo '\',
			\'salign\', \'lt\'
			); //end AC code
	}
	
</script>
'; ?>

  <?php endif; ?>