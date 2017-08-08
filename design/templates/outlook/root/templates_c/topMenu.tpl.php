<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:36
         compiled from topMenu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'lower', 'topMenu.tpl', 75, false),)), $this); ?>
<ul class="clsTopWelcomeLinks">
	<!--  Member links Starts  -->
	<?php if (isMember ( )): ?>
    	<li class="clsBlock"><a class="<?php echo $this->_tpl_vars['header']->getNavClass('left_index'); ?>
 clsBlock" href="<?php echo $this->_tpl_vars['header']->index_page_link; ?>
"><?php echo $this->_tpl_vars['LANG']['header_lang_home']; ?>
</a></li>

        <?php if ($this->_tpl_vars['header']->contentFilterTopLink() != ''): ?>
            <li class="clsFilterStatusAlert clsBlock">
                  <span class="clsFilterStatus clsBlock"><?php echo $this->_tpl_vars['LANG']['header_mature_warning']; ?>
</span><span id="selContentFilterStatus" class="clsBlock"><?php echo $this->_tpl_vars['header']->contentFilterTopLink; ?>
</span>
            </li>
        <?php endif; ?>

        <li class="selDropDownLink clsBlock clsWelcomeSubMenuHead">
            <a class="clsBlock" href="<?php echo $this->_tpl_vars['header']->my_profile_link; ?>
"><?php echo $this->_tpl_vars['CFG']['user']['user_name']; ?>
</a>
            <ul>
                <li>
                    <div class="clsWelcomeSubMenuLinksContainer">
                        <ul class="clsWelcomeSubMenuLinks">
                            <?php $_from = $this->_tpl_vars['header']->show_shortcuts_arr; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['savalue']):
?>
                                <li><a href="<?php echo $this->_tpl_vars['savalue']['Link']; ?>
"><?php echo $this->_tpl_vars['savalue']['Link_Name']; ?>
</a></li>
                            <?php endforeach; endif; unset($_from); ?>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php if ($this->_tpl_vars['header']->chkAllowedModule ( array ( 'mail' ) )): ?>
            <li class="clsNewMail clsBlock">
                <a class="clsBlock" href="<?php echo $this->_tpl_vars['header']->getUrl('mail','?folder=inbox','inbox/','members'); ?>
" title="<?php echo $this->_tpl_vars['header']->newMail; ?>
&nbsp;<?php if ($this->_tpl_vars['header']->newMail == 1): ?><?php echo $this->_tpl_vars['LANG']['header_new_mail']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['header_new_mails']; ?>
<?php endif; ?>" >(<?php echo $this->_tpl_vars['header']->newMail; ?>
)</a>
            </li>
        <?php endif; ?>

        <li class="clsBlock clsInviteFriendLink">
            <a href="<?php echo $this->_tpl_vars['header']->getUrl('membersinvite'); ?>
" class="<?php echo $this->_tpl_vars['header']->getNavClass('left_invite'); ?>
 clsBlock" title="<?php echo $this->_tpl_vars['LANG']['header_link_members_invite']; ?>
"><!----></a>
        </li>

        <li class="clsBlock">
            <a class="clsBlock clsDashboardLink" href="#" onclick="showDashboardPopup(); return false;" title="<?php echo $this->_tpl_vars['LANG']['header_users_my_dshboard_msg_title']; ?>
"><!----></a>
            <div style="display:none;" id="selDashBoard">
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popuplogin_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <div class="clsHeadingClose">
                    <div class="clsDashBoardHeading"><h3><?php echo $this->_tpl_vars['LANG']['header_users_dshboard_title']; ?>
</h3></div>
                    <div class="clsClosePopUpLogin" onclick="showDashboardPopup();"> <!--<p><?php echo $this->_tpl_vars['LANG']['header_users_dshboard_cls_text']; ?>
</p>--></div>
                </div>
                <div class="classDashBoardLinks">
                    <?php echo $this->_tpl_vars['header']->populateMyHotLinks(); ?>

                </div>
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popuplogin_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
        </li>

        <li class="clsBlock clsStatusPickerLink">
        	<?php $this->assign('current_status', $this->_tpl_vars['header']->getCurrentStatus()); ?>
            <a class="clsBlock" href="#" onclick="vj();return false" id="statusAnchor"><span class="status clsBlock" id="onlineStatusSpan" title="<?php echo $this->_tpl_vars['current_status']['status']; ?>
"><?php echo $this->_tpl_vars['current_status']['wrapped_status']; ?>
</span> </a>
            <span class="status clsBlock" id="onlineStatusFull" style="display:none"><?php echo $this->_tpl_vars['current_status']['status']; ?>
</span>
            <span onclick="pickStatus(this)" class="clsUserStatusIcon clsBlock"><!----></span>
        </li>

        <?php if (isAdmin ( )): ?>
        	<li class="adminIndex clsBlock"><a class="clsBlock" href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/index.php"><?php echo $this->_tpl_vars['LANG']['header_admin_link']; ?>
</a></li>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['myobj']->isFacebookUser()): ?>
        	<li class="clsBlock"><a class="" href="<?php echo $this->_tpl_vars['header']->getUrl('logout','','','root'); ?>
" onclick="return facebookLogout();"><?php echo $this->_tpl_vars['LANG']['header_logout_link']; ?>
</a></li>
        <?php else: ?>
            <li class="clsBlock"><a class="" href="<?php echo $this->_tpl_vars['header']->getUrl('logout','','','root'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_logout_link']; ?>
</a></li>
        <?php endif; ?>
   	<?php endif; ?>
	<!--  Member links ends  -->

   	<?php if (! isMember ( )): ?>
       	<?php if ($this->_tpl_vars['header']->chkAllowedModule ( array ( 'login' ) )): ?>
       		<?php if (((is_array($_tmp=$this->_tpl_vars['CFG']['html']['current_script_name'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) != 'login'): ?>
       			<li class="clsBlock clsLoginLink"><a class="clsBlock" href="<?php echo $this->_tpl_vars['header']->getUrl('login','','','root'); ?>
" onclick="showLoginPopup(); return false;"><?php echo $this->_tpl_vars['LANG']['header_login_link']; ?>
</a></li>
       		<?php else: ?>
			   <li class="clsBlock clsLoginLink"><a class="clsBlock" href="<?php echo $this->_tpl_vars['header']->getUrl('login','','','root'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_login_link']; ?>
</a></li>
       		<?php endif; ?>
       	<?php endif; ?>
       	<?php if ($this->_tpl_vars['header']->chkAllowedModule ( array ( 'signup' ) )): ?>
      		<li class="clsBlock clsSignupLink"><a class="clsBlock" href="<?php echo $this->_tpl_vars['header']->getUrl('signup','','','root'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_signup_link']; ?>
</a></li>
       	<?php endif; ?>
   	<?php endif; ?>

    <!-- End of Stylesheet switcher -->
    <?php echo $this->_tpl_vars['myobj']->getTpl('general','styleSheetSwitcher.tpl'); ?>

    <!-- End of Stylesheet switcher -->

    <!-- start of Multi-language support -->
    <?php echo $this->_tpl_vars['myobj']->getTpl('general','multiLanguage.tpl'); ?>

    <!-- End of Multi-language support -->
</ul>
<?php if (! isMember ( ) && $this->_tpl_vars['header']->chkAllowedModule ( array ( 'login' ) ) && ((is_array($_tmp=$this->_tpl_vars['CFG']['html']['current_script_name'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) != 'login'): ?>
	<div id="selHeaderLoginPopup" style="display:none">
		<?php echo $this->_tpl_vars['header']->populateLoginFormFields($this->_tpl_vars['myobj']); ?>

		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('root/'); ?>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'loginpopup.tpl', 'smarty_include_vars' => array('opt' => 'popup')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
	<?php echo '
		<script language="javascript" type="text/javascript">
			var showLoginPopup = function(){
				$Jq(\'#selHeaderLoginPopup\').slideToggle(\'slow\');
			};
		</script>
	'; ?>

<?php endif; ?>

<?php if (isMember ( )): ?>
	<?php echo '
		<script language="javascript" type="text/javascript">
			var showDashboardPopup = function(){
				$Jq(\'#selDashBoard\').slideToggle(\'slow\');
			};
		</script>
	'; ?>

<?php endif; ?>
