{*<!--#############	NORMAL UPLOAD FORM STARTS  HERE   #############-->*}
{if $myobj->isShowPageBlock('block_musicupload_normalupload_form')}
<!--    <div id="selmusicUploadRules" class="clsmusicUploadRules">
      <h3>{$LANG.musicupload_file_type}&nbsp;{$myobj->music_format}</h3>
      <h3>{$LANG.musicupload_file_size}
{$CFG.admin.musics.max_size} {$LANG.common_megabyte}</p>
    </div>-->
	
<div class="clsOverflow">
    <div class="clsStepsBg1 clsFloatLeft"><p><span>{$LANG.musicupload_step}: <strong>{$LANG.musicupload_step_info}</strong></span></p></div>
	<div class="clsStepsBg2 clsFloatLeft"><p><span>{$LANG.musicupload_step2}: <strong>{$LANG.musicupload_step2_info}</strong></span></p></div>
</div>
<div class="clsUploadHeading"><span>{$LANG.musicupload_normal_upload_title}</span></div>
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
    <div id="selUploadNormal">
    <form name="music_upload_form_normal" id="music_upload_form_normal" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off" enctype="multipart/form-data">
        {$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="fieldset_top"}
    <div class="clsDataTable">
    <table summary="{$LANG.musicupload_tbl_summary}" id="selUploadTbl" class="clsFormTableSection clsUploadBlock">
        <tr class="clsmusicUploadFile">
            <td class="{$myobj->getCSSFormLabelCellClass('music_file')}">
                <label for="music_file">{$LANG.musicupload_music_file}</label>&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.common_music_mandatory}</span>&nbsp;
                <input type="hidden" name="max_file_size" value="{$CFG.admin.musics.max_size*1024*1024}" />
                {$myobj->ShowHelpTip('music_file')}
            </td>
            <td class="{$myobj->getCSSFormFieldCellClass('music_file')}">
                <input type="file" class="clsFile" name="music_file" id="music_file" tabindex="{smartyTabIndex}" />
                {$myobj->getFormFieldErrorTip('music_file')}
                
            </td>
        </tr>
    </table>
    </div>
        {$myobj->setTemplateFolder('general/', 'music')}
        {include file="box.tpl" opt="fieldset_bottom"}
            	<input type="hidden" name="music_upload_type" value="Normal" />
				<div class="clsOverflow clsCancelFlash">
                        <p class="clsSkipButton-l"><span class="clsSkipButton-r">
                			<input type="submit" class="clsmusicUploadButton" name="upload_music_normal" id="upload_music_normal" tabindex="{smartyTabIndex}" value="{$LANG.musicupload_upload_music}" />
                         </span></p>
                 </div>
    </form>
    </div>
    
<script type="text/javascript">
{literal}
	$Jq("#music_upload_form_normal").validate({
		rules: {
			music_file: {
				required: true,
				accept: "{/literal}{'|'|implode:$CFG.admin.musics.format_arr}{literal}"
		    }
		},
		messages: {
			music_file: {
				required: "{/literal}{$LANG.common_err_tip_required}{literal}",
				accept: "{/literal}{$LANG.common_err_tip_invalid_file_type}{literal}"
			}
		}
	});
{/literal}
</script>
{/if}
{*<!--#############	NORMAL UPLOAD FORM ENDS  HERE     #############-->*}