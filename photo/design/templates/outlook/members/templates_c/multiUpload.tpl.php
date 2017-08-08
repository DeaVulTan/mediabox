<?php /* Smarty version 2.6.18, created on 2011-10-17 14:53:22
         compiled from multiUpload.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'multiUpload.tpl', 50, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_photoupload_multiupload_form')): ?>
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
        <h3><?php echo $this->_tpl_vars['LANG']['photoupload_multi_upload']; ?>
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
    
            <form id="multi_upload_form" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" method="post" enctype="multipart/form-data">
						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'fieldset_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        <div id="fsUploadProgress1"> 
                        </div>
          				<div class="clsMultiUpload"><?php echo $this->_tpl_vars['myobj']->photoupload_multi_upload_info; ?>
</div>

                                              <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'fieldset_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

            		<div class="clsOverflow">
                                   <p class="clsSubmitButton-l clsAdminUploadButton"><span class="clsSubmitButton-r clsNoPadding"><span id="spanButtonPlaceholder1"></span></span></p>
                                     <p class="clsDeleteButton-l"><span class="clsDeleteButton-r"><input id="btnCancel1" type="button" value="<?php echo $this->_tpl_vars['LANG']['photoupload_multi_upload_cancel_uploads']; ?>
" onclick="cancelQueue(multi_upload);" disabled="disabled" class="clsNoPointer" /></span></p>
                                    <input type="hidden" name="photo_upload_type" value="MultiUpload" />
                            		<p class="clsDeleteButton-l"><span class="clsDeleteButton-r"><input type="submit" class="clsNoPointer" name="upload_photo_multiupload" id="upload_photo_multiupload" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['photoupload_upload_photo_next']; ?>
" disabled="disabled" /></span></p>
                           </div>
                       <!--<textarea id="SWFUpload_Console" style="margin: 5px; overflow: auto; font-family: monospace; width: 700px; height: 350px;" wrap="off"></textarea>  -->
            </form>

<?php endif; ?>