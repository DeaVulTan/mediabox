<?php /* Smarty version 2.6.18, created on 2011-10-17 14:55:46
         compiled from normalUpload.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'normalUpload.tpl', 40, false),array('modifier', 'implode', 'normalUpload.tpl', 64, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_musicupload_normalupload_form')): ?>
<!--    <div id="selmusicUploadRules" class="clsmusicUploadRules">
      <h3><?php echo $this->_tpl_vars['LANG']['musicupload_file_type']; ?>
&nbsp;<?php echo $this->_tpl_vars['myobj']->music_format; ?>
</h3>
      <h3><?php echo $this->_tpl_vars['LANG']['musicupload_file_size']; ?>

<?php echo $this->_tpl_vars['CFG']['admin']['musics']['max_size']; ?>
 <?php echo $this->_tpl_vars['LANG']['common_megabyte']; ?>
</p>
    </div>-->
	
<div class="clsOverflow">
    <div class="clsStepsBg1 clsFloatLeft"><p><span><?php echo $this->_tpl_vars['LANG']['musicupload_step']; ?>
: <strong><?php echo $this->_tpl_vars['LANG']['musicupload_step_info']; ?>
</strong></span></p></div>
	<div class="clsStepsBg2 clsFloatLeft"><p><span><?php echo $this->_tpl_vars['LANG']['musicupload_step2']; ?>
: <strong><?php echo $this->_tpl_vars['LANG']['musicupload_step2_info']; ?>
</strong></span></p></div>
</div>
<div class="clsUploadHeading"><span><?php echo $this->_tpl_vars['LANG']['musicupload_normal_upload_title']; ?>
</span></div>
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
    <div id="selUploadNormal">
    <form name="music_upload_form_normal" id="music_upload_form_normal" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off" enctype="multipart/form-data">
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'fieldset_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div class="clsDataTable">
    <table summary="<?php echo $this->_tpl_vars['LANG']['musicupload_tbl_summary']; ?>
" id="selUploadTbl" class="clsFormTableSection clsUploadBlock">
        <tr class="clsmusicUploadFile">
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('music_file'); ?>
">
                <label for="music_file"><?php echo $this->_tpl_vars['LANG']['musicupload_music_file']; ?>
</label>&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span>&nbsp;
                <input type="hidden" name="max_file_size" value="<?php echo $this->_tpl_vars['CFG']['admin']['musics']['max_size']*1024*1024; ?>
" />
                <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('music_file'); ?>

            </td>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('music_file'); ?>
">
                <input type="file" class="clsFile" name="music_file" id="music_file" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('music_file'); ?>

                
            </td>
        </tr>
    </table>
    </div>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'fieldset_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            	<input type="hidden" name="music_upload_type" value="Normal" />
				<div class="clsOverflow clsCancelFlash">
                        <p class="clsSkipButton-l"><span class="clsSkipButton-r">
                			<input type="submit" class="clsmusicUploadButton" name="upload_music_normal" id="upload_music_normal" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['musicupload_upload_music']; ?>
" />
                         </span></p>
                 </div>
    </form>
    </div>
    
<script type="text/javascript">
<?php echo '
	$Jq("#music_upload_form_normal").validate({
		rules: {
			music_file: {
				required: true,
				accept: "'; ?>
<?php echo ((is_array($_tmp='|')) ? $this->_run_mod_handler('implode', true, $_tmp, $this->_tpl_vars['CFG']['admin']['musics']['format_arr']) : implode($_tmp, $this->_tpl_vars['CFG']['admin']['musics']['format_arr'])); ?>
<?php echo '"
		    }
		},
		messages: {
			music_file: {
				required: "'; ?>
<?php echo $this->_tpl_vars['LANG']['common_err_tip_required']; ?>
<?php echo '",
				accept: "'; ?>
<?php echo $this->_tpl_vars['LANG']['common_err_tip_invalid_file_type']; ?>
<?php echo '"
			}
		}
	});
'; ?>

</script>
<?php endif; ?>