<?php /* Smarty version 2.6.18, created on 2011-10-18 15:30:22
         compiled from index.tpl */ ?>
<!--SIDEBAR-->
  	<div class="clsVideoIndexRight">

	<!-- Static content What's Going On -->
	<div class="clsSideBarMargin">
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sidebar_whatsgoing_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="clsWhatgoingHeading clsOverflow">
		<div class="clsFloatLeft" id="indexActivitesTabs">
			<div class="clsTagsRightTab">
					<h3 class="clsFloatLeft"><?php echo $this->_tpl_vars['LANG']['header_nav_whats_goingon_activity_title_lbl']; ?>
</h3>
					<ul class="clsFloatRight">
					<?php if (isMember ( )): ?>
						<li><a href="index.php?activity_type=My"><?php echo $this->_tpl_vars['LANG']['header_nav_whats_goingon_activity_my']; ?>
</a></li>
						<li><a href="index.php?activity_type=Friends"><?php echo $this->_tpl_vars['LANG']['header_nav_whats_goingon_activity_friends']; ?>
</a></li>
					<?php endif; ?>
						<li><a href="index.php?activity_type=All"><?php echo $this->_tpl_vars['LANG']['header_nav_whats_goingon_activity_all']; ?>
</a></li>
					</ul>
				</div>
		</div>
	</div>
	<script type="text/javascript">
	<?php echo '
	$Jq(window).load(function(){
		attachJqueryTabs(\'indexActivitesTabs\');
	});
	'; ?>

	</script>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sidebar_whatsgoing_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
	<!-- Static content What's Going On -->

	<?php echo $this->_tpl_vars['myobj']->populateVideoMemberMenu(); ?>


    <?php echo $this->_tpl_vars['header']->displayLoginFormRightNavigation(); ?>


    <?php if ($this->_tpl_vars['index_block_settings_arr']['RandomVideo'] == 'sidebar'): ?>
	<?php echo $this->_tpl_vars['myobj']->getRandomVideoForSideBar(); ?>

    <?php endif; ?>
	<?php if ($this->_tpl_vars['index_block_settings_arr']['RandomVideo'] == 'mainblock'): ?>
        <?php echo $this->_tpl_vars['header']->populateTopContributorsRightNavigation(); ?>

    <?php endif; ?>

	<!-- category bock start -->
	<?php echo $this->_tpl_vars['myobj']->populateVideoChannelsRightNavigation(); ?>

	<!-- category bock end -->

	<div class="cls336pxBanner">		
        <div><?php getAdvertisement('sidebanner1_336x280') ?></div>	  
    </div>

	<!--Start Tag Clouds -->

	<?php echo $this->_tpl_vars['myobj']->populateVideoTagsRightNavigation(); ?>


	<!-- End Tag Clouds -->


	</div>
<!--end of SIDEBAR-->

<!-- Main -->
<div class="clsVideoIndexLeft">
<!-- Header ends -->