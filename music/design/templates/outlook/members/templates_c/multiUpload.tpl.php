<?php /* Smarty version 2.6.18, created on 2011-10-17 14:55:34
         compiled from multiUpload.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'multiUpload.tpl', 44, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_musicupload_multiupload_form')): ?>
<div class="clsOverflow">
    <div class="clsStepsBg1 clsFloatLeft"><p><span><?php echo $this->_tpl_vars['LANG']['musicupload_step']; ?>
: <strong><?php echo $this->_tpl_vars['LANG']['musicupload_step_info']; ?>
</strong></span></p></div>
	<div class="clsStepsBg2 clsFloatLeft"><p><span><?php echo $this->_tpl_vars['LANG']['musicupload_step2']; ?>
: <strong><?php echo $this->_tpl_vars['LANG']['musicupload_step2_info']; ?>
</strong></span></p></div>
</div>
	<div class="clsUploadHeading">
	 <span><?php echo $this->_tpl_vars['LANG']['musicupload_multi_upload']; ?>
</span>
	</div>
	<div class="clsNoteContainer">
		<div class="clsNoteContainerLeft">
			<div class="clsNoteContainerRight clsOverflow">
				<div class="clsFloatLeft">
					<p class="clsNote"><?php echo $this->_tpl_vars['LANG']['common_music_note']; ?>
:</p>
				</div>
				<div class="clsFloatLeft">
					<p><?php echo $this->_tpl_vars['LANG']['musicupload_default_settings_note_msg']; ?>
</p>
					<p class="clsMaxUpload">[<?php echo $this->_tpl_vars['LANG']['musicupload_max_file_size']; ?>
:&nbsp;<?php echo $this->_tpl_vars['CFG']['admin']['musics']['max_size']; ?>
&nbsp;<?php echo $this->_tpl_vars['LANG']['common_megabyte']; ?>
]&nbsp;[<?php echo $this->_tpl_vars['LANG']['musicupload_allowed_formats']; ?>
:&nbsp;<?php echo $this->_tpl_vars['myobj']->music_format; ?>
]</p>
				</div>
			</div>
		</div>
	</div>
            <form id="multi_upload_form" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" method="post" enctype="multipart/form-data">
                        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'fieldset_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
							<div class="clsMaxUpload"><?php echo $this->_tpl_vars['myobj']->musicupload_multi_upload_info; ?>
</div>
                            <div>
                                <div id="fsUploadProgress1" class="clsEmptyProgressBar">
                                   
                                </div>
                            </div>
							<div class="clsOverflow clsUploadF1lashButton">
                            <p class="clsSubmitButton-l clsAdminUploadButton"><span class="clsSubmitButton-r"><span id="spanButtonPlaceholder1"></span></span></p>
							</div>
                        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'fieldset_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                       
                          <!--  <textarea id="SWFUpload_Console" style="margin: 5px; overflow: auto; font-family: monospace; width: 700px; height: 350px;" wrap="off"/>                -->
            		
                                   <div class="clsSelectAllLinks clsOverflow clsCancelFlash">
                                    <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input id="btnCancel1" type="button" value="<?php echo $this->_tpl_vars['LANG']['musicupload_multi_upload_cancel_uploads']; ?>
" onclick="cancelQueue(multi_upload);" disabled="disabled" class="" /></span></p>
                            <input type="hidden" name="music_upload_type" value="MultiUpload" />
							<p class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" name="btnSkip" id="btnSkip"
							tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['musicupload_upload_music_skip']; ?>
" onclick="skipRedirect();"  disabled="disabled" /></span>
							 <p class="clsSkipButton-l"><span class="clsSkipButton-r"><input id="upload_music_multiupload" name="upload_music_multiupload"
							 type="submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"  value="<?php echo $this->_tpl_vars['LANG']['musicupload_upload_music_next']; ?>
"  disabled="disabled" /></span></p>
                           </div>
            </form>
<?php endif; ?>