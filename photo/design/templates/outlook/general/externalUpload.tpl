{*<!--#############	EXTERNAL UPLOAD FORM STARTS  HERE   #############-->*}
{if $myobj->isShowPageBlock('block_photoupload_externalupload_form')}

    <div id="selUploadExternal">
    <div class="clsStepsBg">
        <div class="clsStepOneLeft">
        	<div class="clsStepOneRight">
                <span>{$LANG.photoupload_step}:<strong> {$LANG.photoupload_step_info}</strong></span>
            </div>	
       </div>
       <div class="clsStepDisableLeft">
        	<div class="clsStepDisableRight">
     	 	  <span>{$LANG.photoupload_step2}: <strong>{$LANG.photoupload_step2_info}</strong></span>
           </div>
        </div>
    </div>
    
	<div class="clsEmptyProgressBar">
        <h3>{$LANG.photoupload_external_upload}</h3>
    </div>
    <div class="clsPhotoListMenu">
        <div class="clsFieldContainer clsNotesDesgin">
                {$myobj->setTemplateFolder('general/', 'photo')}
                {include file="box.tpl" opt="notesupload_top"}
            <div class="clsNote">
              <span class="clsNotes">{$LANG.common_photo_note}: </span>
              <div class="clsNotesDet">
                  <p>{$LANG.photoupload_default_setting_applied_msg_step1}</p>
                  <p class="clsBold">[{$LANG.photoupload_max_file_size}:&nbsp;{$CFG.admin.photos.max_size}&nbsp;{$LANG.common_megabyte}]&nbsp;
                  [{$LANG.photoupload_allowed_formats}:&nbsp;{$myobj->photo_format}]</p>
                  <p>{$LANG.photoupload_external_upload_info}:&nbsp;http://www.example.com/test/test.jpg</p>
              </div>
            </div>
                {$myobj->setTemplateFolder('general/', 'photo')}
                {include file="box.tpl" opt="notesupload_bottom"}
        </div>
    </div>
    <form name="photo_upload_form_external" id="photo_upload_form_external" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off" enctype="multipart/form-data" onsubmit="return chkMandatoryFields();">
	{$myobj->setTemplateFolder('general/', 'photo')}
    {include file="box.tpl" opt="fieldset_top"}
    <div class="clsDataTable">
    <table summary="{$LANG.photoupload_tbl_summary}" id="selUploadTbl">
        <tr>
            <td class="{$myobj->getCSSFormLabelCellClass('photo_external_file')}">
                <label for="photo_file">{$LANG.photoupload_photo_external_file}</label>&nbsp;<span>{$LANG.common_photo_mandatory}</span>&nbsp;
                {$myobj->ShowHelpTip('photo_external_file')}
            </td>
            <td class="{$myobj->getCSSFormFieldCellClass('photo_external_file')}">
                <input type="textbox" name="photo_external_file" id="photo_external_file" tabindex="{smartyTabIndex}" class="clsTextBox"/>
                {$myobj->getFormFieldErrorTip('photo_external_file')}
            </td>
        </tr>
    </table>
    </div>
    {$myobj->setTemplateFolder('general/', 'photo')}
    {include file="box.tpl" opt="fieldset_bottom"}
            	<input type="hidden" name="photo_upload_type" value="External" />
				<div class="clsOverflow">
                        <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" class="clsphotoUploadButton" name="upload_photo_external" id="upload_photo_external" tabindex="{smartyTabIndex}" value="{$LANG.photoupload_upload_photo}" /></span></p>
                </div>
    </form>
    </div>

	{* Added jquery validation for photo external upload form *}
	{if $CFG.feature.jquery_validation}
		{literal}
		<script type="text/javascript">
			$Jq("#photo_upload_form_external").validate({
				rules: {
					photo_external_file: {
						required: true
		    		}
				},
				messages: {
					photo_external_file: {
						required: "{/literal}{$LANG.common_err_tip_required}{literal}"
					}
				}
		});
		</script>
		{/literal}
	{/if}
{/if}
{*<!--#############	EXTERNAL UPLOAD FORM ENDS  HERE     #############-->*}