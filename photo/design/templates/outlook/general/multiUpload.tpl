{*<!--#############	MULTI UPLOAD STARTS  HERE #############-->*}
{if $myobj->isShowPageBlock('block_photoupload_multiupload_form')}
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
        <h3>{$LANG.photoupload_multi_upload}</h3>
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
    
            <form id="multi_upload_form" action="{$myobj->getCurrentUrl(false)}" method="post" enctype="multipart/form-data">
						{$myobj->setTemplateFolder('general/', 'photo')}
                        {include file="box.tpl" opt="fieldset_top"}
                        <div id="fsUploadProgress1"> 
                        </div>
          				<div class="clsMultiUpload">{$myobj->photoupload_multi_upload_info}</div>

                                              {$myobj->setTemplateFolder('general/', 'photo')}
                        {include file="box.tpl" opt="fieldset_bottom"}

            		<div class="clsOverflow">
                                   <p class="clsSubmitButton-l clsAdminUploadButton"><span class="clsSubmitButton-r clsNoPadding"><span id="spanButtonPlaceholder1"></span></span></p>
                                     <p class="clsDeleteButton-l"><span class="clsDeleteButton-r"><input id="btnCancel1" type="button" value="{$LANG.photoupload_multi_upload_cancel_uploads}" onclick="cancelQueue(multi_upload);" disabled="disabled" class="clsNoPointer" /></span></p>
                                    <input type="hidden" name="photo_upload_type" value="MultiUpload" />
                            		<p class="clsDeleteButton-l"><span class="clsDeleteButton-r"><input type="submit" class="clsNoPointer" name="upload_photo_multiupload" id="upload_photo_multiupload" tabindex="{smartyTabIndex}" value="{$LANG.photoupload_upload_photo_next}" disabled="disabled" /></span></p>
                           </div>
                       <!--<textarea id="SWFUpload_Console" style="margin: 5px; overflow: auto; font-family: monospace; width: 700px; height: 350px;" wrap="off"></textarea>  -->
            </form>

{/if}
{*<!--#############	MULTI UPLOAD ENDS HERE   #############-->*}
