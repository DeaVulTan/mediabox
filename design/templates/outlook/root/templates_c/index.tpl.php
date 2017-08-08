<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:37
         compiled from index.tpl */ ?>
<!--Latest feature and whats going on section starts-->
<div class="clsLatestFeatureActivitiesSection clsOverflow">

	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_feartured_content_glider')): ?>
		<!--Latest feature section starts-->
	    <div class="clsLatestFeatureContainer">
	    	<?php echo $this->_tpl_vars['myobj']->getFeaturedContent(); ?>

	    </div>
	    <!--Latest feature section ends-->
    <?php endif; ?>

    <!--Whats going on section starts-->
    <div class="clsWhatsGoingOnContainer">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'whatsGoingOn.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
    <!--Whats going on section ends-->

</div>


<!--Latest feature and whats going on section ends-->
<?php echo $this->_tpl_vars['header']->populateModuleStatistics(); ?>

<!--Video block section starts-->
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'mainIndexVideoBlock.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--Video block section ends-->

<!--music block section starts-->
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'mainIndexMusicBlock.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--music block section ends-->

<!--Photo block section starts-->
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'mainIndexPhotoBlock.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--Photo block section ends-->

<div class="clsOverflow">
	<div class="clsIndexBottomLeft">
	
		<!--Forums, blogs, article block section starts-->
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'mainIndexOtherBlocks.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<!--Forums, blogs, article block section ends-->

    </div>
    
    <div class="clsIndexBottomRight">
	
		<!--Tags Clouds section starts-->
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'mainIndexTagsBlocks.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<!--Tags Clouds section ends-->
		
				   <div class="cls336pxBanner">
			   <div><?php getAdvertisement('sidebanner1_336x280') ?></div>
		   </div>
		  
    </div>    
    
</div>

<!--Backlinks by Abror Ahmedov-->
<p style="position:absolute; top:-7px;">
<a style="color:#074c76;" href="http://goal.uz/">Футбол на Goal.Uz</a>
<a style="color:#074c76;" href="http://forza.uz/">Forza.Uz</a>
</p>
<!--Backlinks by Abror Ahmedov end-->