<?php /* Smarty version 2.6.18, created on 2012-01-21 07:54:30
         compiled from profileBackground.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'profileBackground.tpl', 17, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="clsPageHeading">
	<h2><?php echo $this->_tpl_vars['LANG']['profilebackground_pg_title']; ?>
</h2>
</div>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<p class="clsNoteMessange"><span><?php echo $this->_tpl_vars['LANG']['profilebackground_note']; ?>
</span>:&nbsp;<?php echo $this->_tpl_vars['LANG']['profilebackground_description']; ?>
</p>

<!-- confirmation box start-->
<div id="selMsgConfirm" style="display:none;">
	<p id="confirmMessage"></p>
	<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
		<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
		&nbsp;
		<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks('selFormForums');" />
		<input type="hidden" name="action" id="action" value="delete" />
	</form>
	</div>
<!-- End -->
<form action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" id="selFormEditProfileBackground" name="selFormEditProfileBackground"  method="post" enctype="multipart/form-data">
    <div class="clsDataTable">
        <table summary="<?php echo $this->_tpl_vars['LANG']['profilebackground_tbl_summary']; ?>
">
      <tr>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('profile_background_color'); ?>
"><label><?php echo $this->_tpl_vars['LANG']['profilebackground_color_title']; ?>
</label></td>
            <td>
                  <input type="color" text="hidden" name="profile_background_color" id="profile_background_color" value="<?php echo $this->_tpl_vars['myobj']->getFormField('profile_background_color'); ?>
" class="color" />
				              </td>
      </tr>
        <tr>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('profile_background_image'); ?>
 clsManageBackgroundLabel"><label for="profile_background_image"><?php echo $this->_tpl_vars['LANG']['profilebackground_image_title']; ?>
</label></td>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('profile_background_image'); ?>
">
            <input type="file" class="clsFileBox" name="profile_background_image" id="profile_background_image" />
            <p>[<?php echo $this->_tpl_vars['LANG']['profilebackground_image_allowed']; ?>
:&nbsp;<?php echo $this->_tpl_vars['myobj']->imageFormat; ?>
]</p>
            <p>[<?php echo $this->_tpl_vars['LANG']['profilebackground_maxsize']; ?>
:&nbsp;<?php echo $this->_tpl_vars['CFG']['profile']['background_image_max_size']; ?>
&nbsp;KB]</p>
            <div><!-- -->
            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('profile_background_image'); ?>

            </div>
            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('profile_background_image'); ?>

            </td>
        </tr>

        <tr>
        	<td><!-- --></td>
        	<td>
                <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_image_display')): ?>
                    <div class="clsOverflow">
                        <p class="clsViewThumbImage"><span><img src="<?php echo $this->_tpl_vars['myobj']->background_path; ?>
" alt="<?php echo $this->_tpl_vars['LANG']['profilebackground_alttag']; ?>
"<?php if ($this->_tpl_vars['myobj']->image_width > 250): ?> width="250"<?php endif; ?>></span></p>
                    </div>
                    <div class="clsDeleteBackground">
                    	<a href="javascript:void(0)" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('confirmMessage'), Array('<?php echo $this->_tpl_vars['LANG']['profilebackground_deleted_confirm_message']; ?>
'), Array('innerHTML'));"><?php echo $this->_tpl_vars['LANG']['profilebackground_delete_background']; ?>
</a>
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('profile_background_offset'); ?>
"><label for="profile_background_offset"><?php echo $this->_tpl_vars['LANG']['profilebackground_backgroundoffset']; ?>
&nbsp;<a onclick="showImageTip()" title="<?php echo $this->_tpl_vars['LANG']['profilebackground_offset_tooltip']; ?>
"><?php echo $this->_tpl_vars['LANG']['profilebackground_help']; ?>
</a></label>

            </td>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('background_offset'); ?>
" >
            	<input type="text"  name="profile_background_offset" id="profile_background_offset" value="<?php echo $this->_tpl_vars['myobj']->getFormField('profile_background_offset'); ?>
" onfocus="hideImageTip()">
                  <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('profile_background_offset'); ?>

                  <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('profile_background_offset'); ?>

            </td>
        </tr>
	 <tr>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('profile_background_repeat'); ?>
"><label><?php echo $this->_tpl_vars['LANG']['profilebackground_repeat']; ?>
</label>

            </td>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('profile_background_repeat'); ?>
" >
            	<input type="radio" class="clsCheckRadio" name="profile_background_repeat" id="profile_background_repeat" value="Yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('profile_background_repeat','Yes'); ?>
  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
            	<label for="profile_background_repeat"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
            	<input type="radio" class="clsCheckRadio" name="profile_background_repeat" id="profile_background_repeat_opt_no" value="No" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('profile_background_repeat','No'); ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/>
            	<label for="profile_background_repeat_opt_no"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>
                <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('profile_background_repeat'); ?>

            </td>
        </tr>
        <tr>
        	<td></td>
            <td ><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" name="uploadBackground" value="<?php echo $this->_tpl_vars['LANG']['profilebackground_submit']; ?>
"></div></div>
                 <div class="clsCancelMargin">
				   <div class="clsCancelLeft">
				     <div class="clsCancelRight">
					    <a id="cancel_layout" onclick="Redirect2URL('<?php echo $this->_tpl_vars['myobj']->getUrl('myprofile','','','members'); ?>
')"><?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
</a>
					 </div>
				   </div>
				 </div>
            </td>
        </tr>
        </table>
        <table>
        <tr>
        <td>
         <div id="imageTip" style="display:none;">
		   <div class="clsCloseOffsetImage">
		    <div class="clsOffsetHeader clsOverflow"><span><?php echo $this->_tpl_vars['LANG']['common_my_profile_offset']; ?>
</span> <a onclick="showImageTip()" title="<?php echo $this->_tpl_vars['LANG']['common_close']; ?>
" class="clsCloseWindow"></a></div>
            <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/profileoffset.jpg" /></div>
            </div>
        </td> </tr>
        </table>
    </div>
</form>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>