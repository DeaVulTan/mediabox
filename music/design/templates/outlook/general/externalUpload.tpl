{*<!--#############	EXTERNAL UPLOAD FORM STARTS  HERE   #############-->*}
{if $myobj->isShowPageBlock('block_musicupload_externalupload_form')}
<div class="clsOverflow">
    <div class="clsStepsBg1 clsFloatLeft"><p><span>{$LANG.musicupload_step}: <strong>{$LANG.musicupload_step_info}</strong></span></p></div>
	<div class="clsStepsBg2 clsFloatLeft"><p><span>{$LANG.musicupload_step2}: <strong>{$LANG.musicupload_step2_info}</strong></span></p></div>
</div>
<div class="clsUploadHeading"><span>{$LANG.musicupload_external_upload_title}</span></div>
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
    <div id="selUploadExternal">
    <form name="music_upload_form_external" id="music_upload_form_external" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off" enctype="multipart/form-data">
        {$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="fieldset_top"}
    <div class="clsDataTable">
    <table summary="{$LANG.musicupload_tbl_summary}" id="selUploadTbl" class="clsFormTableSection clsUploadBlock">
        <tr class="clsmusicUploadFile">
            <td class="{$myobj->getCSSFormLabelCellClass('music_external_file')}">
                <label for="music_file">{$LANG.musicupload_music_external_file}</label>&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.common_music_mandatory}</span>&nbsp;
                {$myobj->ShowHelpTip('music_external_file')}
            </td>
            <td class="{$myobj->getCSSFormFieldCellClass('music_external_file')}">
                <input type="textbox" class="clsTextBox" name="music_external_file" id="music_external_file" tabindex="{smartyTabIndex}" />
                {$myobj->getFormFieldErrorTip('music_external_file')}
                <div class="clsMaxUpload">
                <p>[{$LANG.musicupload_external_upload_info}:&nbsp;http://www.example.com/test/test.mp3]</p>
				</div>
            </td>
        </tr>
    </table>
    </div>
        {$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="fieldset_bottom"}
            	<input type="hidden" name="music_upload_type" value="External" />
				<div class="clsOverflow clsCancelFlash">
                        <p class="clsSkipButton-l"><span class="clsSkipButton-r"><input type="submit" class="clsmusicUploadButton" name="upload_music_external" id="upload_music_external" tabindex="{smartyTabIndex}" value="{$LANG.musicupload_upload_music}" /></span></p>
                </div>
    </form>
    </div>
    
{/if}
<script type="text/javascript">
{literal}
$Jq("#music_upload_form_external").validate({
	rules: {
		music_external_file: {
			required: true
		}
	},
	messages: {
		music_external_file: {
			required: "{/literal}{$LANG.common_err_tip_required}{literal}"
		}
	}
});
{/literal}
</script>
{*<!--#############	EXTERNAL UPLOAD FORM ENDS  HERE     #############-->*}