<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:37
         compiled from indexPromotionalContent.tpl */ ?>
<!-- START AnythingSlider -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'slider_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="anythingSlider clsIndexSingleSlide">
	<h2><?php echo $this->_tpl_vars['promotional_content']['glider_title']; ?>
</h2>
	<div class="clsLatestFeatureContent">
		<div class="clsImage">
	    	<div class="clsImageContainer clsImageBorder4 cls368x277">
	    		<?php echo $this->_tpl_vars['promotional_content']['main_content']; ?>

	        </div>
	    </div>
	    <div class="clsDetails">
	        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

	        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'featuredetails_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	        	<div class="clsFeatureDetailsContainer">
	            	<div class="clsFeatureDetailsContent">
	            		<?php echo $this->_tpl_vars['promotional_content']['sidebar_content']; ?>

	                </div>
	            </div>
	        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'featuredetails_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	    </div>
	</div>
</div> <!-- END AnythingSlider -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'slider_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>