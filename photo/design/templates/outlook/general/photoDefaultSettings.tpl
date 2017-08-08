<div class="clsOverflow">
{$myobj->setTemplateFolder('general/', 'photo')}
{include file="box.tpl" opt="photomain_top"}
<div id="selphotoupload" class="clsPhotoUploadPage">
	<div class="clsMainBarHeading">
        <h3>
            {$LANG.photoupload_default_settings}
       </h3>
    </div>
{$myobj->setTemplateFolder('general/', 'photo')}
{include file='information.tpl'}
{if $myobj->isShowPageBlock('block_photo_default_form')}
    {*CONFIRMATION BOX FOR SKIPING STEP 2*}
      <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
      {$myobj->setTemplateFolder('general/','photo')}
 	  {include file='box.tpl' opt='popupbox_top'}
        <p id="msgConfirmText"></p>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getUrl('photolist', '?pg=myphotos', 'myphotos/', '', 'photo')}" autocomplete="off">
            <input type="submit" class="clsPopUpButtonSubmit" name="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
            <input type="button" class="clsPopUpButtonReset" name="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
        </form>
		{$myobj->setTemplateFolder('general/','photo')}
      {include file='box.tpl' opt='popupbox_bottom'}
      </div>
      <div id="selUpload">
		{if !$myobj->chkIsEditMode()}
     {*   <div class="clsSkipBtn">
            <input type="button" name="skip" id="skip" tabindex="{smartyTabIndex}" value="{$LANG.photoupload_skip_step2}" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('msgConfirmText'), Array('{$LANG.photoupload_skip_message}'), Array('innerHTML'), 100, 150, 'anchor_upload');" />
        </div> *}
    {/if}

    </div>
      <div class="clsFieldContainer clsNotesDesgin clsOverflow">
                {$myobj->setTemplateFolder('general/', 'photo')}
                {include file="box.tpl" opt="notesupload_top"}
        <p class="clsNote">
        <span class="clsNotes">{$LANG.common_photo_note}: </span>
        <span class="clsNotesDet">{$LANG.potoupload_default_note_msg}</span></p>
                {$myobj->setTemplateFolder('general/', 'photo')}
                {include file="box.tpl" opt="notesupload_bottom"}
    </div>
      <form name="photo_upload_form" id="photo_upload_form" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off" enctype="multipart/form-data" >
   <div id="selUploadBlock">
   <p class="clsStepsTitle">{$LANG.photoupload_default_settings_general_info}</p>
          {* COMMON FIELDS STARTS HERE *}
         <div class="clsNoteContainer clsTableBackground">
         <table>
		 	<tr>
                <td class="{$myobj->getCSSFormLabelCellClass('photo_album_type')}">
                    <label for="photo_album_type">{$LANG.photoupload_private} {$LANG.photoupload_photo_album}</label>&nbsp;
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('photo_album_type')}">
                    <p><input type="checkbox" class="clsCheckRadio clsRadioButtonBorder" name="photo_album_type" id="photo_album_type" value="Private" onclick="checkPublic();" tabindex="{smartyTabIndex}"
                        {if $myobj->getFormField('photo_album_type')=='Private'} checked {/if} /></p>
                    {$myobj->getFormFieldErrorTip('photo_album_type')}
                    {$myobj->ShowHelpTip('photo_album_type')}
                    <p class="clsFieldComments">{$LANG.photoupload_photo_album_type}</p>
                </td>
            </tr>
			  {literal}
			  <script type="text/javascript">
				var old_photo_album_name = '{/literal}{$myobj->getFormField('photo_album')}{literal}';
			  </script>
			  {/literal}
		 	<tr>
                <td class="{$myobj->getCSSFormLabelCellClass('photo_album')}">
                    <label for="photo_album">{$LANG.photoupload_photo_album}</label>&nbsp;
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('photo_album')}">
					<span id="selAlbumName" style="display:{if $myobj->getFormField('photo_album_type')=='Private'} none {else} block {/if}">
                    	<span id='selPhotoAlbumTextBox'><input type="text" class="clsTextBox" name="photo_album" id="photo_album" value="{$myobj->getFormField('photo_album')}" tabindex="{smartyTabIndex}" /></span>
					</span>
					<span id="selAlbumId" style="display:{if $myobj->getFormField('photo_album_type')=='Private'} block {else} none {/if}">
						<select name="album_id" id="album_id"  tabindex="{smartyTabIndex}" class="clsSelectMedium">
                          <option value="">{$LANG.common_select_option}</option>
                          {$myobj->populatePhotoAlbum('Private',$CFG.user.user_id)}
                          </select>
                          <div class="clsOverflow">
                           <div id="selAlbumNew" class="clsNewAlbum" ><a href="javascript:void(0);" onclick="changToText();"><span>{$LANG.photoupload_new_album}</span></a></div>
                          </div>
					</span>
                    {$myobj->getFormFieldErrorTip('photo_album')}
                    {$myobj->ShowHelpTip('photo_album_name')}
                    <p class="clsFieldComments">{$LANG.photoupload_photo_album_name}</p>
                </td>
            </tr>
			{if $myobj->content_filter}
            <tr id="selDateLocationRow" class="clsAllowOptions">
                <td class="{$myobj->getCSSFormLabelCellClass('photo_category_type')}">
                    <label for="photo_category_type1">{$LANG.photoupload_photo_category_type}</label>
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('photo_category_type')}">
                    <input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="photo_category_type" id="photo_category_type1" value="Porn" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('photo_category_type','Porn')} onclick="document.getElementById('selGeneralCategory').style.display='none';document.getElementById('selPornCategory').style.display='';" />
                    &nbsp;<label for="photo_category_type1" class="clsBold">{$LANG.common_porn}</label>
                    &nbsp;&nbsp;
                    <input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="photo_category_type" id="photo_category_type2" value="General" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('photo_category_type','General')}
                    onClick="document.getElementById('selGeneralCategory').style.display='';document.getElementById('selPornCategory').style.display='none';" />
                    &nbsp;<label for="photo_category_type2" class="clsBold">{$LANG.common_general}</label>
                    {$myobj->getFormFieldErrorTip('photo_category_type')}
                    {$myobj->ShowHelpTip('photo_category_type1')} {$myobj->ShowHelpTip('photo_category_type2')}       </td>
            </tr>
			{/if}

            <tr id="selCategoryBlock">
                <td class="{$myobj->getCSSFormLabelCellClass('photo_category_id')}">
                    <label for="photo_category_id">{$LANG.photoupload_photo_category}</label>&nbsp;<span class="clsBgMandatory">{$LANG.common_photo_mandatory}</span>&nbsp;
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('photo_category_id')}">
                <div id="selGeneralCategory" style="display:{$myobj->General}">
                    <select name="photo_category_id" id="photo_category_id" {if $CFG.admin.photos.sub_category} onChange="populatePhotoSubCategory(this.value)" {/if} tabindex="{smartyTabIndex}" class="clsSelectMedium">
                      <option value="">{$LANG.common_select_option}</option>
                      {$myobj->populatePhotoCatagory('General')}
                    </select>
                    {$myobj->getFormFieldErrorTip('photo_category_id')}
                    {$myobj->ShowHelpTip('photo_category_id')}
                    <p class="clsSelectNote clsFieldComments">{$LANG.photoupload_select_category}</p>
                </div>
                {if $myobj->content_filter and isAdultUser('', 'photo')}
                      <div id="selPornCategory" style="display:{$myobj->Porn}">
                          <select name="photo_category_id_porn" id="photo_category_id_porn" {if $CFG.admin.photos.sub_category} onChange="populatePhotoSubCategory(this.value)" {/if} tabindex="{smartyTabIndex}" class="clsSelectMedium">
                          <option value="">{$LANG.common_select_option}</option>
                          {$myobj->populatePhotoCatagory('Porn')}
                          </select>
						  {$myobj->getFormFieldErrorTip('photo_category_id_porn')}
                          {$myobj->ShowHelpTip('photo_category_id')}
                          <p class="clsSelectNote clsFieldComments">{$LANG.photoupload_select_a_category}</p>
                      </div>
                {/if}
               </td>
            </tr>
            {if $CFG.admin.photos.sub_category}
            <tr id="selSubCategoryBlock">
                <td class="{$myobj->getCSSFormLabelCellClass('photo_sub_category_id')}">
                <label for="photo_sub_category_id">{$LANG.photoupload_photo_sub_category}</label>
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('photo_sub_category_id')}">
                <div id="selSubCategoryBox">
                    <select name="photo_sub_category_id" id="photo_sub_category_id" class="clsSelectMedium" tabindex="{smartyTabIndex}">
                        <option value="">{$LANG.common_select_option}</option>
                    </select>
                    {$myobj->getFormFieldErrorTip('photo_sub_category_id')}
                </div>
                {$myobj->ShowHelpTip('photo_sub_category_id')}
               </td>
            </tr>
            {/if}

            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('photo_tags')}">
                    <label for="photo_tags">{$LANG.photoupload_photo_tags}</label>&nbsp;<span class="clsBgMandatory">{$LANG.common_photo_mandatory}</span>&nbsp;
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('photo_tags')}">
                    <input type="text" class="clsTextBox" name="photo_tags" id="photo_tags" value="{$myobj->getFormField('photo_tags')}" tabindex="{smartyTabIndex}" />
                    {$myobj->getFormFieldErrorTip('photo_tags')}
                    {$myobj->ShowHelpTip('photo_tags')}
                    <p class="clsFieldComments">{$myobj->photoUpload_tags_msg}</p>
                    <p class="clsFieldComments">{$LANG.photoupload_tags_msg2}</p>
                </td>
            </tr>
        </table>
		 </div>
        {* OTHER UPLOAD OPTIONS STARTS HERE *}
        <div id="otherUploadOption" class="clsDataTable">
        <p class="clsStepsTitle">{$LANG.common_sharing}</p>
        <div class="clsNoteContainerTop">
            <table summary="{$LANG.photoupload_tbl_summary}" id="selUploadTbl_otherOption">
                <tr id="selAccessTypeRow">
                    <td class="{$myobj->getCSSFormLabelCellClass('photo_access_type')}">
                        <label for="photo_access_type1">{$LANG.photoupload_photo_access_type}</label>
                    </td>
                    <td class="{$myobj->getCSSFormFieldCellClass('photo_access_type')}">
                        <p><input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="photo_access_type" id="photo_access_type1" value="Public" tabindex="{smartyTabIndex}"
                        {$myobj->isCheckedRadio('photo_access_type','Public')} />&nbsp;<label for="photo_access_type1">{$LANG.photoupload_public}
                        </label>{$LANG.photoupload_share_your_photo_world}</p>
                        <p><input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="photo_access_type" id="photo_access_type2" value="Private" tabindex="{smartyTabIndex}"
                        {$myobj->isCheckedRadio('photo_access_type','Private')} />&nbsp;<label for="photo_access_type2">{$LANG.photoupload_private}
                        </label>{$LANG.photoupload_only_viewable_by_you}</p>
                        <p class="clsSelectHighlightNote clsUploadSharing">{$LANG.photoupload_only_viewable_you_email}:</p>
                        {$myobj->populateCheckBoxForRelationList()}
                        {$myobj->getFormFieldErrorTip('photo_access_type')}
                        {$myobj->ShowHelpTip('photo_access_type')}
                     </td>
                </tr>
                <tr id="selAllowCommentsRow">
                    <td class="{$myobj->getCSSFormLabelCellClass('allow_comments')}">
                        <label for="allow_comments1">{$LANG.photoupload_allow_comments}</label>        </td>
                    <td class="{$myobj->getCSSFormFieldCellClass('allow_comments')}">
                    <p>
                    <input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="allow_comments" id="allow_comments1" value="Yes" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_comments','Yes')} />&nbsp;<label for="allow_comments1" class="clsBold">{$LANG.common_yes_option}</label>
                    {$LANG.photoupload_allow_comments_world}</p>
                    <p><input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="allow_comments" id="allow_comments2" value="No" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_comments','No')} />&nbsp;<label for="allow_comments2" class="clsBold">{$LANG.common_no_option}</label>&nbsp;{$LANG.photoupload_disallow_comments}        </p>
                    <p><input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="allow_comments" id="allow_comments3" value="Kinda" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_comments','Kinda')} />&nbsp;<label for="allow_comments3" class="clsBold">{$LANG.common_kinda}</label>
                    {$LANG.photoupload_approval_comments}       	</p>
                    {$myobj->getFormFieldErrorTip('allow_comments')}
                    {$myobj->ShowHelpTip('allow_comments')}	</td>
                </tr>
                <tr id="selDateLocationRow" class="clsAllowOptions">
                    <td class="{$myobj->getCSSFormLabelCellClass('allow_ratings')}">
                        <label for="allow_ratings1">{$LANG.photoupload_allow_ratings}</label>		</td>
                    <td class="{$myobj->getCSSFormFieldCellClass('allow_ratings')}">
                    <p><input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="allow_ratings" id="allow_ratings1" value="Yes" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_ratings','Yes')} />&nbsp;<label for="allow_ratings1" class="clsBold">{$LANG.common_yes_option}</label>
                    {$LANG.photoupload_allow_ratings_world}</p>
                    <p><input type="radio" class="clsCheckRadio clsRadioButtonBorder" name="allow_ratings" id="allow_ratings2" value="No" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_ratings','No')} />&nbsp;<label for="allow_ratings2" class="clsBold">{$LANG.common_no_option}</label>&nbsp;{$LANG.photoupload_disallow_ratings}             </p>
                    <p id="selDisableNote" class="clsUploadSharing">{$LANG.photoupload_disallow_ratings_note}</p>
                    {$myobj->getFormFieldErrorTip('allow_ratings')}
                    {$myobj->ShowHelpTip('allow_ratings')}
                    </td>
                </tr>
				<tr id="selDateLocationRow">
                    <td class="{$myobj->getCSSFormLabelCellClass('allow_tags')}">
                        <label for="allow_tags1">{$LANG.photoupload_allow_tags}</label>		</td>
                    <td class="{$myobj->getCSSFormFieldCellClass('allow_tags')}">
                        <p><input type="radio" name="allow_tags" id="allow_tags1" class="clsRadioButtonBorder" value="Yes" tabindex="{smartyTabIndex}"
                        {$myobj->isCheckedRadio('allow_tags','Yes')} />&nbsp;<label for="allow_tags1" class="clsBold">{$LANG.common_yes_option}</label>
                        {$LANG.photoupload_allow_tags_others}</p>
                        <p><input type="radio" name="allow_tags" id="allow_tags2" class="clsRadioButtonBorder" value="No" tabindex="{smartyTabIndex}"
                        {$myobj->isCheckedRadio('allow_tags','No')} />&nbsp;<label for="allow_tags2" class="clsBold">{$LANG.common_no_option}</label>
                        {$LANG.photoupload_disallow_tags_others}</p>
                        {$myobj->getFormFieldErrorTip('allow_tags')}
                        {* $myobj->ShowHelpTip('allow_tags') *}
                        </td>
                </tr>
            </table>
        </div>
        </div>
        {* OTHER UPLOAD OPTIONS ENDS HERE *}

                {$myobj->populateHidden($myobj->hidden_arr)}
                {$myobj->populateHidden($myobj->multi_hidden_arr)}
				{if !$myobj->chkIsEditMode()}
                    <div class="clsOverflow clsManageCommentsBtn">
                        <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" class="clsSubmitButton clsphotoUploadButton" name="upload_photo" id="upload_photo" tabindex="{smartyTabIndex}" value="{$LANG.photoupload_submit}" />
                        </span></p>
                    </div>
                {else}
                    <div class="clsOverflow clsManageCommentsBtn">
                         <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="upload_photo" id="upload_photo" tabindex="{smartyTabIndex}" value="{$LANG.photoupload_update}" /></span></p>
                         <p class="clsDeleteButton-l"><span class="clsDeleteButton-r"><input type="button" onClick="javascript:window.location='{php}echo (isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:getUrl('photolist','?pg=myphotos','myphotos/','','photo'));{/php}'"class="clsphotoUploadButton" name="cancel" tabindex="{smartyTabIndex}" value="{$LANG.photoupload_cancel}" /></span></p>
                     </div>
                {/if}
        	</div>
    	</div>
  	</form>
{/if}

{*<!--#############	UPLOAD FORM ENDS HERE   		  #############-->*}

</div>
{$myobj->setTemplateFolder('general/', 'photo')}
{include file="box.tpl" opt="photomain_bottom"}
</div>