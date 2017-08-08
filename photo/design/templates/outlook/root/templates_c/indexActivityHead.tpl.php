<?php /* Smarty version 2.6.18, created on 2011-10-18 17:31:50
         compiled from indexActivityHead.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'whatsgoing_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsWhatgoingHeading clsOverflow">
	<h3><?php echo $this->_tpl_vars['LANG']['sidebar_photo_activities_label']; ?>
</h3>
    <div class="clsWhatgoingRightTab" id="indexActivitesTabs">
        <ul class="clsFloatRight">
        	<?php if (isMember ( )): ?>
            <li><a href="index.php?activity_type=My"><span><?php echo $this->_tpl_vars['LANG']['sidebar_my_label']; ?>
</span></a></li>
            <li><a href="index.php?activity_type=Friends"><span><?php echo $this->_tpl_vars['LANG']['sidebar_friends_label']; ?>
</span></a></li>
            <?php endif; ?>
            <li><a href="index.php?activity_type=All"><span><?php echo $this->_tpl_vars['LANG']['sidebar_photoactivity_all_label']; ?>
</span></a></li>
        </ul>
    </div>
    <script type="text/javascript">
		<?php echo '
		$Jq(window).load(function(){
			attachJqueryTabs(\'indexActivitesTabs\');
		});
		'; ?>

	</script>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'whatsgoing_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>