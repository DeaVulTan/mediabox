<?php /* Smarty version 2.6.18, created on 2011-10-18 14:49:56
         compiled from populateMyBlogBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'populateMyBlogBlock.tpl', 36, false),)), $this); ?>
<?php if ($this->_tpl_vars['CFG']['site']['script_name'] == 'index.php'): ?>
<!-- Blog whats going start -->
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_whatsgoing_top')));
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
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_whatsgoing_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- Blog whats going on ends -->
</div>
<?php endif; ?>


<?php if ($this->_tpl_vars['opt'] == 'blog'): ?>
			<?php $this->assign('css_temp', ''); ?>
             <?php if ($this->_tpl_vars['myobj']->_currentPage == 'blogpostlist'): ?>
                    <?php $this->assign('css_temp', ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['myobj']->_currentPage)) ? $this->_run_mod_handler('cat', true, $_tmp, '_') : smarty_modifier_cat($_tmp, '_')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['myobj']->getFormField('pg')) : smarty_modifier_cat($_tmp, $this->_tpl_vars['myobj']->getFormField('pg')))); ?>
             <?php endif; ?>
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        <p class="
            <?php if ($this->_tpl_vars['myobj']->_currentPage == 'managepostcomments'): ?>
                <?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_managepostcomments'); ?>

            <?php elseif ($this->_tpl_vars['css_temp'] == 'blogpostlist_myposts'): ?>
                <?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_blogpostlist_myposts'); ?>

            <?php elseif ($this->_tpl_vars['css_temp'] == 'blogpostlist_myfavoriteposts'): ?>
                <?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_blogpostlist_myfavoriteposts'); ?>

            <?php endif; ?>    " >
                        <div class="clsSideBarLeft">
                            <p class="clsSideBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['common_sidebar_myblock_mypost_label']; ?>
</p>
                        </div>
                <div class="clsSideBarRight clsNoPadding">
            <?php $this->assign('blog_count', 1); ?>
                   <div class="clsSideBarContent">
						<ul class="clsMyBlogListing" id="subblogID<?php echo $this->_tpl_vars['blog_count']; ?>
">
                             <li class="<?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_bloglist'); ?>
 <?php if ($this->_tpl_vars['myobj']->_currentPage == 'bloglist'): ?>clsActiveLink<?php endif; ?>" >
                                 <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('bloglist','','','','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_manage_all_blogs']; ?>
</a>
                            </li>
                            <li class="<?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_blogpostlist_postnew'); ?>
 <?php if ($this->_tpl_vars['myobj']->_currentPage == 'postnew'): ?>clsActiveLink<?php endif; ?>" >
                             <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('blogpostlist','?pg=postnew','postnew/','','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_allpost']; ?>
</a>
                            </li>
                        </ul>
                    </div>
            </p>
            <input type="hidden" value="1" id="memberCount"  name="memberCount" />
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php endif; ?>