{*<!--#############	MULTI UPLOAD STARTS  HERE #############-->*}
{if $myobj->isShowPageBlock('block_musicupload_multiupload_form')}
<div class="clsOverflow">
    <div class="clsStepsBg1 clsFloatLeft"><p><span>{$LANG.musicupload_step}: <strong>{$LANG.musicupload_step_info}</strong></span></p></div>
	<div class="clsStepsBg2 clsFloatLeft"><p><span>{$LANG.musicupload_step2}: <strong>{$LANG.musicupload_step2_info}</strong></span></p></div>
</div>
	<div class="clsUploadHeading">
	 <span>{$LANG.musicupload_multi_upload}</span>
	</div>
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
            <form id="multi_upload_form" action="{$myobj->getCurrentUrl(false)}" method="post" enctype="multipart/form-data">
                        {$myobj->setTemplateFolder('general/', 'music')}
                        {include file="box.tpl" opt="fieldset_top"}
							<div class="clsMaxUpload">{$myobj->musicupload_multi_upload_info}</div>
                            <div>
                                <div id="fsUploadProgress1" class="clsEmptyProgressBar">
                                   
                                </div>
                            </div>
							<div class="clsOverflow clsUploadF1lashButton">
                            <p class="clsSubmitButton-l clsAdminUploadButton"><span class="clsSubmitButton-r"><span id="spanButtonPlaceholder1"></span></span></p>
							</div>
                        {$myobj->setTemplateFolder('general/', 'music')}
                        {include file="box.tpl" opt="fieldset_bottom"}
                       
                          <!--  <textarea id="SWFUpload_Console" style="margin: 5px; overflow: auto; font-family: monospace; width: 700px; height: 350px;" wrap="off"/>                -->
            		
                                   <div class="clsSelectAllLinks clsOverflow clsCancelFlash">
                                    <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input id="btnCancel1" type="button" value="{$LANG.musicupload_multi_upload_cancel_uploads}" onclick="cancelQueue(multi_upload);" disabled="disabled" class="" /></span></p>
                            <input type="hidden" name="music_upload_type" value="MultiUpload" />
							<p class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" name="btnSkip" id="btnSkip"
							tabindex="{smartyTabIndex}" value="{$LANG.musicupload_upload_music_skip}" onclick="skipRedirect();"  disabled="disabled" /></span>
							 <p class="clsSkipButton-l"><span class="clsSkipButton-r"><input id="upload_music_multiupload" name="upload_music_multiupload"
							 type="submit" tabindex="{smartyTabIndex}"  value="{$LANG.musicupload_upload_music_next}"  disabled="disabled" /></span></p>
                           </div>
            </form>
{/if}
{*<!--#############	MULTI UPLOAD ENDS HERE   #############-->*}
