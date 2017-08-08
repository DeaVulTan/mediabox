<?php /* Smarty version 2.6.18, created on 2011-10-25 10:25:16
         compiled from populateProfileRightNavigation.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="clsSideBarLinks" id="selProfileHome">
	<div class="clsSideBar"><div >
	<p class="clsSideBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['header_nav_profile_home']; ?>
</p>
</div>

<div class="clsSideBarRight">
 <div class="clsSideBarContent">
  <ul>
  	<li ><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('myprofile'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_profile_myprofile_page']; ?>
</a></li>
    <li class="<?php echo $this->_tpl_vars['profileAvatar_class']; ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('profileavatar'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_profile_avatar']; ?>
</a></li>
    <li class="<?php echo $this->_tpl_vars['profileBasic_class']; ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('profilebasic'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_profile_basic']; ?>
</a></li>
    <?php $_from = $this->_tpl_vars['profile_li_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
		<li class="<?php echo $this->_tpl_vars['value']['profileInfo_class']; ?>
"><a href="<?php echo $this->_tpl_vars['value']['profileInfo_link']; ?>
"><?php echo $this->_tpl_vars['value']['profileInfo_record']['title']; ?>
</a></li>
	<?php endforeach; endif; unset($_from); ?>
    <li class="<?php echo $this->_tpl_vars['profileSettings_class']; ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('profilesettings'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_profile_settings']; ?>
</a></li>
    <li class="<?php echo $this->_tpl_vars['notificationSettings_class']; ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('notificationsettings'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_email_notification_settings']; ?>
</a></li>
<?php if ($this->_tpl_vars['CFG']['profile']['set_background']): ?>
    <li class="<?php echo $this->_tpl_vars['profileBackground_class']; ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('profilebackground'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_profile_background']; ?>
</a></li>
<?php endif; ?>
<?php if ($this->_tpl_vars['userDetails']['openid_used'] == 'No'): ?>
    <li class="<?php echo $this->_tpl_vars['profilePassword_class']; ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('profilepassword'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_password']; ?>
</a></li>
<?php endif; ?>
<?php if (chkAllowedModule ( array ( 'customize_profile' ) )): ?>
    <li class="<?php echo $this->_tpl_vars['profileThemeDesign_class']; ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('profilethemedesign'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_profile_customize']; ?>
</a></li>
    <li class="<?php echo $this->_tpl_vars['profileTheme_class']; ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('profiletheme','?block=myscraps','?block=myscraps'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_profile_theme']; ?>
</a>
		<?php if ($this->_tpl_vars['profile_theme_arr']): ?>
        	<ul>
            	<?php $_from = $this->_tpl_vars['profile_theme_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['profile_theme']):
?>
					<li class="<?php echo $this->_tpl_vars['profile_theme']['class']; ?>
"><a href="<?php echo $this->_tpl_vars['profile_theme']['url']; ?>
"><?php echo $this->_tpl_vars['profile_theme']['lang']; ?>
</a></li>
                <?php endforeach; endif; unset($_from); ?>
            </ul>
        <?php endif; ?>
    </li>
   <?php endif; ?>
  </ul>

</div></div></div></div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>