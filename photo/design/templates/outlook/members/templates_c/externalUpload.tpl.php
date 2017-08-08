<?php /* Smarty version 2.6.18, created on 2011-10-17 14:54:05
         compiled from externalUpload.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'externalUpload.tpl', 49, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_photoupload_externalupload_form')): ?>

    <div id="selUploadExternal">
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
        <h3><?php echo $this->_tpl_vars['LANG']['photoupload_external_upload']; ?>
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
    <form name="photo_upload_form_external" id="photo_upload_form_external" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
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
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('photo_external_file'); ?>
">
                <label for="photo_file"><?php echo $this->_tpl_vars['LANG']['photoupload_photo_external_file']; ?>
</label>&nbsp;<span><?php echo $this->_tpl_vars['LANG']['common_photo_mandatory']; ?>
</span>&nbsp;
                <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('photo_external_file'); ?>

            </td>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('photo_external_file'); ?>
">
                <input type="textbox" name="photo_external_file" id="photo_external_file" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsTextBox"/>
                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_external_file'); ?>

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
            	<input type="hidden" name="photo_upload_type" value="External" />
				<div class="clsOverflow">
                        <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" class="clsphotoUploadButton" name="upload_photo_external" id="upload_photo_external" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['photoupload_upload_photo']; ?>
" /></span></p>
                </div>
    </form>
    </div>

		<?php if ($this->_tpl_vars['CFG']['feature']['jquery_validation']): ?>
		<?php echo '
		<script type="text/javascript">
			$Jq("#photo_upload_form_external").validate({
				rules: {
					photo_external_file: {
						required: true
		    		}
				},
				messages: {
					photo_external_file: {
						required: "'; ?>
<?php echo $this->_tpl_vars['LANG']['common_err_tip_required']; ?>
<?php echo '"
					}
				}
		});
		</script>
		'; ?>

	<?php endif; ?>
<?php endif; ?>