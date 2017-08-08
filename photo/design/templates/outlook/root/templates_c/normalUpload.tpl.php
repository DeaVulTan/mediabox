<?php /* Smarty version 2.6.18, created on 2011-12-30 00:45:46
         compiled from normalUpload.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'normalUpload.tpl', 49, false),array('modifier', 'implode', 'normalUpload.tpl', 73, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_photoupload_normalupload_form')): ?>
<div class="clsStepsBg">
    <div class="clsStepOneLeft">
        <div class="clsStepOneRight">
             <span><?php echo $this->_tpl_vars['LANG']['photoupload_step']; ?>
:<strong> <?php echo $this->_tpl_vars['LANG']['photoupload_step_info']; ?>
</strong></span>
        </div>
    </div>
    <div class="clsStepDisableLeft">
        <div class="clsStepDisableRight">
          <span><?php echo $this->_tpl_vars['LANG']['photoupload_step2']; ?>
: <strong><?php echo $this->_tpl_vars['LANG']['photoupload_step2_info']; ?>
</strong></span>
       </div>
    </div>
</div>

	<div class="clsEmptyProgressBar">
        <h3><?php echo $this->_tpl_vars['LANG']['photoupload_normal_upload']; ?>
</h3>
    </div>
    <div class="clsPhotoListMenu">
        <div class="clsFieldContainer clsNotesDesgin">
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'notesupload_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div class="clsNote">
              <span class="clsNotes"><?php echo $this->_tpl_vars['LANG']['common_photo_note']; ?>
: </span>
              <div class="clsNotesDet">
                  <p><?php echo $this->_tpl_vars['LANG']['photoupload_default_setting_applied_msg_step1']; ?>
</p>
                  <p class="clsBold">[<?php echo $this->_tpl_vars['LANG']['photoupload_max_file_size']; ?>
:&nbsp;<?php echo $this->_tpl_vars['CFG']['admin']['photos']['max_size']; ?>
&nbsp;<?php echo $this->_tpl_vars['LANG']['common_megabyte']; ?>
]&nbsp;
                  [<?php echo $this->_tpl_vars['LANG']['photoupload_allowed_formats']; ?>
:&nbsp;<?php echo $this->_tpl_vars['myobj']->photo_format; ?>
]</p>
                  <p><?php echo $this->_tpl_vars['LANG']['photoupload_external_upload_info']; ?>
:&nbsp;http://www.example.com/test/test.jpg</p>
              </div>
            </div>
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'notesupload_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
    </div>
    <div id="selUploadNormal">
    <form name="photo_upload_form_normal" id="photo_upload_form_normal" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off" enctype="multipart/form-data" onsubmit="return chkMandatoryFields();">
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'fieldset_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div class="clsDataTable">
    <table summary="<?php echo $this->_tpl_vars['LANG']['photoupload_tbl_summary']; ?>
" id="selUploadTbl">
        <tr>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_file'); ?>
">
                <label for="photo_file"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_file']; ?>
</label>&nbsp;<span><?php echo $this->_tpl_vars['LANG']['common_photo_mandatory']; ?>
</span>&nbsp;
                <input type="hidden" name="max_file_size" value="<?php echo $this->_tpl_vars['CFG']['admin']['photos']['max_size']*1024*1024; ?>
" />
                <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_file'); ?>

            </td>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('photo_file'); ?>
">
                <input type="file" accept="photo/<?php echo $this->_tpl_vars['myobj']->photo_format; ?>
" name="photo_file" id="photo_file" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_file'); ?>

            </td>
        </tr>
    </table>
    </div>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'fieldset_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            	<input type="hidden" name="photo_upload_type" value="Normal" />
				<div class="clsOverflow">
                        <p class="clsSubmitButton-l"><span class="clsSubmitButton-r">
                			<input type="submit" class="clsphotoUploadButton" name="upload_photo_normal" id="upload_photo_normal" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['photoupload_upload_photo']; ?>
" />
				 </span></p>
                 </div>
    </form>
    </div>
        <?php if ($this->_tpl_vars['CFG']['feature']['jquery_validation']): ?>
	    <?php echo '
	    <script type="text/javascript">
			$Jq("#photo_upload_form_normal").validate({
				rules: {
					photo_file: {
						required: true,
						accept: "'; ?>
<?php echo ((is_array($_tmp='|')) ? $this->_run_mod_handler('implode', true, $_tmp, $this->_tpl_vars['CFG']['admin']['photos']['format_arr']) : implode($_tmp, $this->_tpl_vars['CFG']['admin']['photos']['format_arr'])); ?>
<?php echo '"
				    }
				},
				messages: {
					photo_file: {
						required: "'; ?>
<?php echo $this->_tpl_vars['LANG']['common_err_tip_required']; ?>
<?php echo '",
						accept: "'; ?>
<?php echo $this->_tpl_vars['LANG']['common_err_tip_invalid_image_format']; ?>
<?php echo '"
					}
				}
			});
		</script>
		'; ?>

	<?php endif; ?>
<?php endif; ?>