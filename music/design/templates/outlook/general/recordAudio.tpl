{*<!--#############	RECORD AUDIO UPLOAD FORM STARTS  HERE   #############-->*}
{if $myobj->isShowPageBlock('block_musicupload_recordaudio_form')}
<div class="clsOverflow">
    <div class="clsStepsBg1 clsFloatLeft"><p><span>{$LANG.musicupload_step}: <strong>{$LANG.musicupload_step_info}</strong></span></p></div>
	<div class="clsStepsBg2 clsFloatLeft"><p><span>{$LANG.musicupload_step2}: <strong>{$LANG.musicupload_step2_info}</strong></span></p></div>
</div>
<div class="clsUploadHeading"><span>{$LANG.musicupload_record_audio_title}</span></div>
<div class="clsNoteContainer">
		<div class="clsNoteContainerLeft">
			<div class="clsNoteContainerRight clsOverflow">
				<div class="clsFloatLeft">
					<p class="clsNote">{$LANG.common_music_note}:</p>
				</div>
				<div class="clsFloatLeft">
					<p>{$LANG.musicupload_default_settings_note_msg}</p>
					<p class="clsMaxUpload">[{$LANG.musicupload_max_file_size}:&nbsp;{$CFG.admin.musics.max_size}&nbsp;{$LANG.common_megabyte}]&nbsp;[{$LANG.musicupload_allowed_formats}:&nbsp;{$myobj->music_format}]</p>
				</div>
			</div>
		</div>
	</div>
    <form name="music_upload_form_record" id="music_upload_form_record" method="post" action="{$myobj->getCurrentUrl(false)}?upload={$myobj->record_filename}" autocomplete="off" enctype="multipart/form-data">
        {$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="fieldset_top"}
      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="382" height="390" id="QuickRecorder" align="middle">      
      <param name="allowScriptAccess" value="sameDomain" />
      <param name="movie" value="{$myobj->audio_recorder_path}" />      
      <param name="quality" value="high" />      
      <param name="bgcolor" value="#ffffff" />
	<param name="wmode" value="transparent">       
      <embed src="{$myobj->audio_recorder_path}" quality="high" bgcolor="#ffffff" width="382" height="390" name="QuickRecorder" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" />
      </object>
      
      <script language="JavaScript">
	//make sure this object JSFCommunicator is created only when Object or Embed tags are initialized.
		//createJSFCommunicatorObject(thisMovie("QuickRecorder"));
      </script>
     <input type="hidden" name="music_upload_type" value="Record" />
        {$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="fieldset_bottom"}
    </form>
{/if}
{*<!--#############	RECORD AUDIO UPLOAD FORM ENDS  HERE     #############-->*}      