<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:37
         compiled from mainIndexVideoBlock.tpl */ ?>
<?php if (chkAllowedModule ( array ( 'video' ) )): ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'videoblock_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="clsMainIndexVideoBlock">
    	<!--heading and right heading content starts-->
    	<div class="clsOverflow">
        	<h2 class="clsBlockHeading"><?php echo $this->_tpl_vars['LANG']['mainIndex_video']; ?>
</h2>
            <div class="clsBlockHeadingDetails">
            <?php $_from = $this->_tpl_vars['modulestatistics']['video']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['video_stats'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['video_stats']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['caption'] => $this->_tpl_vars['detail']):
        $this->_foreach['video_stats']['iteration']++;
?>
            <?php echo $this->_tpl_vars['detail']['lang']; ?>
: <span><?php echo $this->_tpl_vars['detail']['value']; ?>
</span>
            <?php if (! ($this->_foreach['video_stats']['iteration'] == $this->_foreach['video_stats']['total'])): ?><span class="clsSeperator">&nbsp;</span><?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
            </div>
        </div>
    	<!--heading and right heading content ends-->
        
	<?php if ($this->_tpl_vars['total_video_carousel_pages']): ?>
        <div class="clsOverflow">
        	<!-- Player section starts -->
            <div id="mainIndexVideoPlayer" class="clsPlayerBlock">
            	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mainIndexVideoPlayer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
        	<!-- Player section ends -->
            <div class="clsCarouselBlock">
            	<h3><?php echo $this->_tpl_vars['mainIndexObj']->LANG['mainIndex_video_heading']; ?>
</h3>
            	 <div class="clsIndexMainContainer"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mainIndexVideoBlockHead.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
            </div>
        </div>
    <?php else: ?>
    <div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['mainIndex_video_no_record']; ?>
</div>
    <?php endif; ?>
    </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'videoblock_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>