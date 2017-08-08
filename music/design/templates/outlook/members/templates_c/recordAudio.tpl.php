<?php /* Smarty version 2.6.18, created on 2011-10-24 16:16:46
         compiled from recordAudio.tpl */ ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_musicupload_recordaudio_form')): ?>
<div class="clsOverflow">
    <div class="clsStepsBg1 clsFloatLeft"><p><span><?php echo $this->_tpl_vars['LANG']['musicupload_step']; ?>
: <strong><?php echo $this->_tpl_vars['LANG']['musicupload_step_info']; ?>
</strong></span></p></div>
	<div class="clsStepsBg2 clsFloatLeft"><p><span><?php echo $this->_tpl_vars['LANG']['musicupload_step2']; ?>
: <strong><?php echo $this->_tpl_vars['LANG']['musicupload_step2_info']; ?>
</strong></span></p></div>
</div>
<div class="clsUploadHeading"><span><?php echo $this->_tpl_vars['LANG']['musicupload_record_audio_title']; ?>
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
    <form name="music_upload_form_record" id="music_upload_form_record" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
?upload=<?php echo $this->_tpl_vars['myobj']->record_filename; ?>
" autocomplete="off" enctype="multipart/form-data">
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'fieldset_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="382" height="390" id="QuickRecorder" align="middle">      
      <param name="allowScriptAccess" value="sameDomain" />
      <param name="movie" value="<?php echo $this->_tpl_vars['myobj']->audio_recorder_path; ?>
" />      
      <param name="quality" value="high" />      
      <param name="bgcolor" value="#ffffff" />
	<param name="wmode" value="transparent">       
      <embed src="<?php echo $this->_tpl_vars['myobj']->audio_recorder_path; ?>
" quality="high" bgcolor="#ffffff" width="382" height="390" name="QuickRecorder" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" />
      </object>
      
      <script language="JavaScript">
	//make sure this object JSFCommunicator is created only when Object or Embed tags are initialized.
		//createJSFCommunicatorObject(thisMovie("QuickRecorder"));
      </script>
     <input type="hidden" name="music_upload_type" value="Record" />
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'fieldset_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </form>
<?php endif; ?>
      