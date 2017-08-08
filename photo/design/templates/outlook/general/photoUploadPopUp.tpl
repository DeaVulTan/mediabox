<div class="clsOverflow">
{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="photomain_top"}
<div id="selPhotoUpload">
	<div class="clsMainBarHeading clsOverflow clsUploadPopupHeader">
        <h3>
            {if $myobj->chkIsEditMode()}
                {$LANG.photoupload_edit_title}
            {else}
                {$LANG.photoupload_title}
            {/if}
       </h3>
       {if $myobj->isShowPageBlock('block_photoupload_step1') && $myobj->paidmembership_upgrade_form==0}
       <ul>
        	{if $CFG.admin.photos.upload_photo_multiupload}
	            <li id="selHeaderMultiUpload"><a href="javascript:void(0);" onclick="loadUploadType('{$CFG.site.url}photo/photoUploadPopUp.php?ajax_page=true&pg=multiupload', 'selMultiUploadContent', 'selHeaderMultiUpload');"><span>{$LANG.photoupload_multi_upload_title}</span></a></li>
            {/if}
        	{if $CFG.admin.photos.upload_photo_normalupload}
	            <li id="selHeaderNormalUpload"><a href="javascript:void(0);" onclick="loadUploadType('{$CFG.site.url}photo/photoUploadPopUp.php?ajax_page=true&pg=normal', 'selNormalUploadContent', 'selHeaderNormalUpload');"><span>{$LANG.photoupload_normal_upload_title}</span></a></li>
            {/if}
        	{if $CFG.admin.photos.upload_photo_externalupload}
	            <li id="selHeaderExternalUpload"><a href="javascript:void(0);" onclick="loadUploadType('{$CFG.site.url}photo/photoUploadPopUp.php?ajax_page=true&pg=external', 'selExternalUploadContent', 'selHeaderExternalUpload');"><span>{$LANG.photoupload_external_upload_title}</span></a></li>
            {/if}
        	{if $CFG.admin.photos.upload_photo_capture && $myobj->mugshot_licence_validation}
	            <li id="selHeaderCapturePhoto"><a href="javascript:void(0);" onclick="loadUploadType('{$CFG.site.url}photo/photoUploadPopUp.php?ajax_page=true&pg=capture', 'selCaptureContent', 'selHeaderCapturePhoto');"><span>{$LANG.photoupload_capture_photo_title}</span></a></li>
            {/if}
        </ul>
        {/if}
    </div>
{$myobj->setTemplateFolder('general/', 'photo')}
{include file='information.tpl'}
{if $myobj->isShowPageBlock('block_photoupload_step1') && $myobj->paidmembership_upgrade_form==0}
    
	<script type="text/javascript">
        var subMenuClassName1='clsActiveTabNavigation';
        var hoverElement1  = '.clsTabNavigation li';
        loadChangeClass(hoverElement1,subMenuClassName1);
    </script>

	<div id="selMultiUploadContent" style="display:none">
    	{if $myobj->show_div == 'selMultiUploadContent'}
            {$myobj->setTemplateFolder('general/', 'photo')}
            {include file='multiUpload.tpl'}
      {/if}
	</div>
    <div id="selNormalUploadContent" style="display:none">
		{if $myobj->show_div == 'selNormalUploadContent'}
		{$myobj->setTemplateFolder('general/', 'photo')}
		{include file='normalUpload.tpl'}
		{/if}
	</div>
    <div id="selExternalUploadContent" style="display:none">
    	{if $myobj->show_div == 'selExternalUploadContent'}
            {$myobj->setTemplateFolder('general/', 'photo')}
            {include file='externalUpload.tpl'}
      {/if}
    </div>
	<!--div id="selCaptureContent" style="display:block">
    	{if $myobj->show_div == 'selCaptureContent'}
            {$myobj->setTemplateFolder('general/', 'photo')}
            {include file='capturePhoto.tpl'}
      {/if}
    </div-->
	{if $CFG.admin.photos.upload_photo_capture && $myobj->mugshot_licence_validation}
	<div id="selCaptureContent" style="display:none">
    	{$myobj->setTemplateFolder('general/', 'photo')}
        {include file='capturePhoto.tpl'}
    </div>
	{/if}


{/if}

{if $myobj->isShowPageBlock('block_photoupload_step2')}
    {*CONFIRMATION BOX FOR SKIPING STEP 2*}
      <div id="selMsgConfirm" style="display:none;">
      $myobj->setTemplateFolder('general/','photo')}
 	 {include file='box.tpl' opt='popupbox_top'}
        <p id="msgConfirmText"></p>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getUrl('photolist', '?pg=myphotos', 'myphotos/', 'members', 'photo')}" autocomplete="off">
            <input type="submit" class="clsPopUpButtonSubmit" name="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
            <input type="button" class="clsPopUpButtonReset" name="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
        </form>
		{$myobj->setTemplateFolder('general/','photo')}
     {include file='box.tpl' opt='popupbox_bottom'}
      </div>

    <div id="selUpload">
        <div class="clsPhotoDetailHdMain clsOverflow">
            <div class="clsOverflow">
                <div class="clsStepDisableLeft">
                    <div class="clsStepDisableRight">
                      <span>{$LANG.photoupload_step1}: <strong>{$LANG.photoupload_step1_info}</strong></span>
                   </div>
                </div>
            {if $myobj->isShowPageBlock('block_photoupload_step2')}
                  <div class="clsStepsBg">
                    <div class="clsStepOneLeft">
                        <div class="clsStepOneRight">
                         	 <span>{$LANG.photoupload_step}: <strong>{$LANG.photoupload_step_info}</strong></span>
                          </div>
                      </div>
                  </div>
            {/if}
            </div>

            {if !$myobj->chkIsEditMode()}
               {* <div class="clsSkipBtn">
                    <input type="button" name="skip" id="skip" tabindex="{smartyTabIndex}" value="{$LANG.photoupload_skip_step2}" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('msgConfirmText'), Array('{$LANG.photoupload_skip_message}'), Array('innerHTML'), 100, 150, 'anchor_upload');" />
                </div> *}
            {/if}
        </div>
        <form name="photo_upload_form" id="photo_upload_form" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off" enctype="multipart/form-data">
          <a id="anchor_upload"></a>

    <div id="selUploadBlock" class="clsUploadBlock">
        <p class="clsStepsTitle">{$LANG.photoupload_basic_info}</p>
        <div class="clsFieldContainer clsNotesDesginStepTwo clsOverflow">
                {$myobj->setTemplateFolder('general/', 'photo')}
                {include file="box.tpl" opt="notesupload_top"}
            <p class="clsNote"><span class="clsNotes">{$LANG.common_photo_note}:</span>
            <p  class="clsNotesDet">{if !$myobj->chkIsEditMode()}<span>{$LANG.photoupload_default_setting_applied_msg}</span>{/if}
            {if $myobj->chkIsEditMode()}<span>{$LANG.photoupload_photo_album_type_step2_edit}</span>{else}<br/>
            <span>{$LANG.photoupload_photo_album_type_step2}</span>{/if}</p></p>
                {$myobj->setTemplateFolder('general/', 'photo')}
                {include file="box.tpl" opt="notesupload_bottom"}
        </div>
        <div class="clsNoteContainer">
          {assign var="i" value="0"}
             {section name=photoDetails loop=$myobj->getFormField('total_photos')}
                {assign var=id_field_name value=photo_id_$i}
                {assign var=title_field_name value=photo_title_$i}
                {assign var=album_field_name value=photo_album_$i}
                {assign var=caption_field_name value=photo_caption_$i}
				{assign var=photo_status value=photo_status_$i}
				{assign var=photo_small_img value=small_img_src_$i}
                {assign var=photo_album_type_field_name value=photo_album_type_$i}
         <div class="clsTableUploadPopUp clsTableUploadPopUpSeperator">
		<table summary="{$LANG.photoupload_tbl_summary}" id="selUploadTbl" class="clsPhotoUploadStepTwo">
			{literal}
			  <script type="text/javascript">
				var old_photo_album_name_{/literal}{$i}{literal} = '{/literal}{$myobj->getFormField('photo_album')}{literal}';
			  </script>
			  {/literal}
			<tr>
            	<th class="clsNoBG"><!--&nbsp;--></th>

				{if $CFG.admin.photos.photo_auto_activate || $myobj->chkIsEditMode()}
				<th class="{$myobj->getCSSFormLabelCellClass('photo_image')} clsNoBgColor clsStep2Title1">{$LANG.photoupload_photo_image}</th>
				{/if}
				<th class="{$myobj->getCSSFormLabelCellClass('photo_title')} clsNoBgColor clsStep2Title3"><label for="photo_title_{$i}">{$LANG.photoupload_photo_title}&nbsp;</label><span>{$LANG.common_photo_mandatory}</span></th>
				<th class="{$myobj->getCSSFormLabelCellClass('photo_album_type')} clsNoBgColor clsStep2Title3"><label for="photo_album_type_{$i}">{$LANG.photoupload_photo_album_type_label}</label></th>
				<th class="{$myobj->getCSSFormLabelCellClass('photo_album')} clsNoBgColor clsStep2Title2"><label for="photo_album_{$i}">{$LANG.photoupload_photo_album}</label></th>

            	<th class="{$myobj->getCSSFormLabelCellClass('photo_caption')} clsNoBorder">
                    <label for="photo_caption_{$i}">{$LANG.photoupload_photo_description}</label>
                </th>
			</tr>
			<tr>
                {*{if $myobj->getFormField('total_photos')>1}*}
                <td class="clsPhotoCountTitle clsNoBG">{*{$LANG.photoupload_photo}*} {$i+1}</td>
                {*{/if}*}
				{if $CFG.admin.photos.photo_auto_activate || $myobj->chkIsEditMode()}
               		<td class="clsUploadImg" rowspan="4">
					<img src="{$myobj->getFormField($photo_small_img)}" />
					<input type="hidden" name="small_img_src_{$i}"  value="{$myobj->getFormField($photo_small_img)}"/>
				</td>
				{/if}
                <td>
                    <input type="text" name="photo_title_{$i}" id="photo_title_{$i}" class="clsSelectMidSmall" tabindex="{smartyTabIndex}" value="{$myobj->getFormField($title_field_name)}" maxlength="{$CFG.admin.photos.title_max_length}" /><input type="hidden" name="photo_status_{$i}" id="photo_status_{$i}" tabindex="{smartyTabIndex}" value="{$myobj->getFormField($photo_status)}" />
                              {$myobj->getFormFieldErrorTip($title_field_name)}
                </td>
				<td >
                    <input type="radio" name="photo_album_type_{$i}" id="photo_album_type_{$i}_1" class="clsRadioButtonBorder" value="Private" tabindex="{smartyTabIndex}" onclick="checkPublic({$i});"
                    {$myobj->isCheckedRadio($photo_album_type_field_name,'Private')}/>&nbsp;<label for="photo_album_type_{$i}_1" class="">{$LANG.photoupload_private}</label>

                    <input type="radio" name="photo_album_type_{$i}" id="photo_album_type_{$i}_2" class="clsRadioButtonBorder" value="Public" tabindex="{smartyTabIndex}" onclick="checkPublic({$i});"
                    {$myobj->isCheckedRadio($photo_album_type_field_name,'Public')} />&nbsp;<label for="photo_album_type_{$i}_2" class="">{$LANG.photoupload_public}</label>

                </td>
				<td>
					<span id="selAlbumName_{$i}" style="display:{if $myobj->getFormField($photo_album_type_field_name)=='Private'} none {else} block {/if}">
						<span id='selPhotoAlbumTextBox_{$i}' >
							<input type="text" name="photo_album_{$i}" id="photo_album_{$i}" class="clsSelectMidMedium" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('photo_album')}" maxlength="{$CFG.admin.photos.album_max_length}" /></span>
							<span id="selLoadImg_{$i}" style="display:none"></span>
                          <div class="clsOverflow">
                             <div class="clsUploadAlbumCreate">
								<span id="selAlbumOk_{$i}" class="clsNewAlbum" style="display:none"><a href="javascript:void(0);" onclick="savePublicAlbum(document.getElementById('photo_album_{$i}').value,{$i},{$myobj->getFormField('total_photos')});"><span>{$LANG.potoupload_ok}</span></a></span>
                              </div>
                              <div class="clsUploadAlbumCancel">
                    			<span id="selAlbumNewCancel_{$i}" class="clsCancelAlbum" style="display:none"><a href="javascript:void(0);" onclick="cancelCreateNewAlbum({$i});"><span>{$LANG.photoupload_new_album_cancel}</span></a></span>
                              </div>
                          </div>
						</span>
					<span id="selAlbumId_{$i}" style="display:{if $myobj->getFormField($photo_album_type_field_name)=='Private'} block {else} none {/if}">
						<select name="album_id_{$i}" id="album_id_{$i}"  tabindex="{smartyTabIndex}" class="clsSelectBoxMidMedium" onchange="chkAlbumValue(this.value,{$i});">
                          <option value="">{$LANG.common_select_option}</option>
						  <option value="new">{$LANG.photoupload_create_new_album}</option>
                          {$myobj->populatePhotoAlbum('Private',$CFG.user.user_id)}
                          </select>
					</span>
                    {$myobj->getFormFieldErrorTip('photo_album')}
                </td>

            	<td class="{$myobj->getCSSFormFieldCellClass('photo_caption')} clsNoBorder">
                    <textarea name="photo_caption_{$i}" id="photo_caption_{$i}" tabindex="{smartyTabIndex}">{$myobj->getFormField($caption_field_name)}</textarea>
                    {$myobj->getFormFieldErrorTip($caption_field_name)}
                </td>
            </tr>

         </table>
         </div>
         {assign var=i value=$i+1}
          {/section}
         {literal}
         <script type="text/javascript">
		{/literal}
		{assign var="i" value="0"}

		{literal}

		 </script>
         {/literal}
 </div>
        <p class="clsStepsTitle">Other Info</p>
         {* COMMON FIELDS STARTS HERE *}
         <div class="clsNoteContainerTop clsTableUploadPopUp clsEditPhotoBlock2">
         <table>
            {if $myobj->content_filter}
            <tr id="selDateLocationRow">
                <td class="{$myobj->getCSSFormLabelCellClass('photo_category_type')}">
                    <label for="photo_category_type1">{$LANG.photoupload_photo_category_type}</label>
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('photo_category_type')}">
                    <input type="radio" name="photo_category_type" id="photo_category_type1" class="clsRadioButtonBorder" value="Porn" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('photo_category_type','Porn')} onclick="document.getElementById('selGeneralCategory').style.display='none';document.getElementById('selPornCategory').style.display='';" />
                    &nbsp;<label for="photo_category_type1" class="clsBold">{$LANG.common_porn}</label>
                    &nbsp;&nbsp;
                    <input type="radio" name="photo_category_type" id="photo_category_type2" class="clsRadioButtonBorder" value="General" tabindex="{smartyTabIndex}"
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
                <div id="selGeneralCategory" style="display:{$myobj->General}" class="clsOverflow">
                <div class="clsUploadAlbumCreate">
                    <select name="photo_category_id" id="photo_category_id" class="clsSelectMidSmall" {if $CFG.admin.photos.sub_category} onChange="populatePhotoSubCategory(this.value)" {/if} tabindex="{smartyTabIndex}">
                      <option value="">{$LANG.common_select_option}</option>
                      {$myobj->populatePhotoCatagory('General')}
                    </select>
                   {$myobj->getFormFieldErrorTip('photo_category_id')}
                   {$myobj->ShowHelpTip('photo_category_id')}
                    </div>
                </div>
                {if $myobj->content_filter and isAdultUser('', 'photo') }
                      <div id="selPornCategory" style="display:{$myobj->Porn}">
                          <select name="photo_category_id_porn" class="clsSelectMidSmall" id="photo_category_id_porn" {if $CFG.admin.photos.sub_category} onChange="populatePhotoSubCategory(this.value)" {/if} tabindex="{smartyTabIndex}">
                          <option value="">{$LANG.common_select_option}</option>
                          {$myobj->populatePhotoCatagory('Porn')}
                          </select>
						  {$myobj->getFormFieldErrorTip('photo_category_id_porn')}
                          {$myobj->ShowHelpTip('photo_category_id')}
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
                    <select name="photo_sub_category_id" id="photo_sub_category_id" class="clsSelectMidSmall" tabindex="{smartyTabIndex}">
                        <option value="">{$LANG.common_select_option}</option>
                    </select>
                    {$myobj->getFormFieldErrorTip('photo_sub_category_id')}
                </div>
                {$myobj->ShowHelpTip('photo_sub_category_id')}
               </td>
            </tr>
            {/if}
			<tr>
                <td class="{$myobj->getCSSFormLabelCellClass('location_recorded')}">
                    <label for="location_recorded">{$LANG.potoupload_photo_location}</label>
                </td>
				{if $CFG.admin.photos.add_photo_location}
					 <td class="{$myobj->getCSSFormFieldCellClass('location_recorded')}">
                <div class="clsOverflow">
                  <div class="clsUploadAlbumCreate">
                    <div class="clsContentLeft">
                     <input type="text" name="location_recorded" id="location_recorded" class="clsSelectMidSmall" value="{$myobj->getFormField('location_recorded')}" tabindex="{smartyTabIndex}" readonly/>
                    {$myobj->getFormFieldErrorTip('location_recorded')}
                    {$myobj->ShowHelpTip('location_recorded')}
                    </div>
                      <div class="clsContentLeft">
					 <span class="clsUpdatePopUpLocation"><a class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" id="update_photo_location" href="javascript:;" title="{$LANG.potoupload_update_photo_location}" ></a></span>
                    </div>
                 </div>
                </div>
                </td>
				{else}
                <td class="{$myobj->getCSSFormFieldCellClass('location_recorded')}">
                <div class="clsOverflow">
                  <div class="clsUploadAlbumCreate">
                    <input type="text" name="location_recorded" id="location_recorded" class="clsSelectMidSmall" value="{$myobj->getFormField('location_recorded')}" tabindex="{smartyTabIndex}" />
                    {$myobj->getFormFieldErrorTip('location_recorded')}
                    {$myobj->ShowHelpTip('location_recorded')}
                 </div>
                </div>
                </td>
			   {/if}
            </tr>
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('photo_tags')}">
                    <label for="photo_tags">{$LANG.photoupload_photo_tags}</label>&nbsp;<span class="clsBgMandatory">{$LANG.common_photo_mandatory}</span>&nbsp;
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('photo_tags')}">
                <div class="clsOverflow">
                  <div class="clsUploadAlbumCreate">
                    <input type="text" name="photo_tags" id="photo_tags" class="clsSelectMidSmall" value="{$myobj->getFormField('photo_tags')}" tabindex="{smartyTabIndex}" />
                 	<div class="clsFieldComments">{$myobj->photoUpload_tags_msg} {$LANG.photoupload_tags_msg2}</div>
                    {$myobj->getFormFieldErrorTip('photo_tags')}
                    {$myobj->ShowHelpTip('photo_tags')}
                 </div>
                  <div class="clsUploadAlbumCreate clsSelectMidLarge">
                  </div>
                </div>
                </td>
            </tr>
        </table>
		 </div>

        {* OTHER UPLOAD OPTIONS STARTS HERE *}
        <div id="photosThumsDetailsLinks" class="clsShowHideFilterPopUp clsOverflow">
            <a href="javascript:void(0)" id="show_link" class="clsShowFilterSearch" onclick="divShowHide('otherUploadOption', 'show_link', 'hide_link')"><span>{$LANG.photoupload_show_other_option}</span></a>
            <a href="javascript:void(0)" id="hide_link" style="display:none;" class="clsHideFilterSearch" onclick="divShowHide('otherUploadOption', 'show_link', 'hide_link')"><span>{$LANG.photoupload_hide_other_option}</span></a>
        </div>
       <div id="otherUploadOption" style="display:none" class="clsDataTable">
        <p class="clsStepsTitle">{$LANG.common_sharing}</p>
        <div class="clsNoteContainerTop">
            <table summary="{$LANG.photoupload_tbl_summary}" id="selUploadTbl_otherOption">
                <tr id="selAccessTypeRow">
                    <td class="{$myobj->getCSSFormLabelCellClass('photo_access_type')}">
                        <label for="photo_access_type1">{$LANG.photoupload_photo_access_type}</label>
                    </td>
                    <td class="{$myobj->getCSSFormFieldCellClass('photo_access_type')}">
                        <p class="clsNoBorder"><input type="radio" name="photo_access_type" id="photo_access_type1" class="clsRadioButtonBorder" value="Public" tabindex="{smartyTabIndex}"
                        {$myobj->isCheckedRadio('photo_access_type','Public')} />&nbsp;<label for="photo_access_type1">{$LANG.photoupload_public}
                        </label>{$LANG.photoupload_share_your_photo_world}</p>
                        <p class="clsNoBorder"><input type="radio" name="photo_access_type" id="photo_access_type2" class="clsRadioButtonBorder" value="Private" tabindex="{smartyTabIndex}"
                        {$myobj->isCheckedRadio('photo_access_type','Private')} />&nbsp;<label for="photo_access_type2">{$LANG.photoupload_private}
                        </label>{$LANG.photoupload_only_viewable_by_you}</p>
                        <p class="clsUploadSharing">{$LANG.photoupload_only_viewable_you_email}:</p>
                        {$myobj->populateCheckBoxForRelationList()}
                        {$myobj->getFormFieldErrorTip('photo_access_type')}
                        {* $myobj->ShowHelpTip('photo_access_type') *}
                     </td>
                </tr>
                <tr id="selAllowCommentsRow">
                    <td class="{$myobj->getCSSFormLabelCellClass('allow_comments')}">
                        <label for="allow_comments1">{$LANG.photoupload_allow_comments}</label>        </td>
                    <td class="{$myobj->getCSSFormFieldCellClass('allow_comments')}">
                    <p>
                    <input type="radio" name="allow_comments" id="allow_comments1" class="clsRadioButtonBorder" value="Yes" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_comments','Yes')} />&nbsp;<label for="allow_comments1" class="clsBold">{$LANG.common_yes_option}</label>
                    {$LANG.photoupload_allow_comments_world}</p>
                    <p><input type="radio" name="allow_comments" id="allow_comments2" class="clsRadioButtonBorder" value="No" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_comments','No')} />&nbsp;<label for="allow_comments2" class="clsBold">{$LANG.common_no_option}</label>&nbsp;{$LANG.photoupload_disallow_comments}        </p>
                    <p><input type="radio" name="allow_comments" id="allow_comments3" class="clsRadioButtonBorder" value="Kinda" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_comments','Kinda')} />&nbsp;<label for="allow_comments3" class="clsBold">{$LANG.common_kinda}</label>
                    {$LANG.photoupload_approval_comments}       	</p>
                    {$myobj->getFormFieldErrorTip('allow_comments')}
                    {* $myobj->ShowHelpTip('allow_comments') *}	</td>
                </tr>
                <tr id="selDateLocationRow">
                    <td class="{$myobj->getCSSFormLabelCellClass('allow_ratings')}">
                        <label for="allow_ratings">{$LANG.photoupload_allow_ratings}</label>		</td>
                    <td class="{$myobj->getCSSFormFieldCellClass('allow_ratings')}">
                    <p><input type="radio" name="allow_ratings" id="allow_ratings1" class="clsRadioButtonBorder" value="Yes" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_ratings','Yes')} />&nbsp;<label for="allow_ratings1" class="clsBold">{$LANG.common_yes_option}</label>
                    {$LANG.photoupload_allow_ratings_world}</p>
                    <p><input type="radio" name="allow_ratings" id="allow_ratings2" class="clsRadioButtonBorder" value="No" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_ratings','No')} />&nbsp;<label for="allow_ratings2" class="clsBold">{$LANG.common_no_option}</label>&nbsp;{$LANG.photoupload_disallow_ratings}             </p>
                    <p id="selDisableNote" class="clsUploadSharing">{$LANG.photoupload_disallow_ratings_note}</p>
                    {$myobj->getFormFieldErrorTip('allow_ratings')}
                    {* $myobj->ShowHelpTip('allow_ratings') *}
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

                {*$myobj->populateHidden(array('gpukey')*}
                {$myobj->populateHidden($myobj->hidden_arr)}
                {$myobj->populateHidden($myobj->multi_hidden_arr)}
                {if !$myobj->chkIsEditMode()}
                         <div class="clsManageCommentsBtn clsOverflow">
                          <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" class="clsSubmitButton clsphotoUploadButton" name="upload_photo" id="upload_photo" tabindex="{smartyTabIndex}" value="{$LANG.photoupload_submit}" /></span></p>
                    </div>
                {else}
                  <div class="clsManageCommentsBtn clsOverflow">
                         <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="upload_photo" id="upload_photo" tabindex="{smartyTabIndex}" value="{$LANG.photoupload_update}" /></span></p>
                         <p class="clsDeleteButton-l"><span class="clsDeleteButton-r"><input type="button" onClick="javascript:window.location='{php}echo (isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:getUrl('photolist','?pg=myphotos','myphotos/','','photo'));{/php}'"class="clsphotoUploadButton" name="cancel" tabindex="{smartyTabIndex}" value="{$LANG.photoupload_cancel}" /></span></p>
                     </div>
                {/if}

        </div>
        </form>
    </div>
{/if}
{if $myobj->isShowPageBlock('block_photoupload_paidmembership_upgrade_form') || $myobj->paidmembership_upgrade_form==1}
<div>{$myobj->potoupload_upgrade_membership}</div>
{/if}
{*<!--#############	UPLOAD FORM ENDS HERE   		  #############-->*}
</div>

{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="photomain_bottom"}
</div>
{* Added code to display to display fancy box to update photo location *}
<script>
{literal}
$Jq(document).ready(function() {
	$Jq('#update_photo_location').fancybox({
		'width'				: 560,
		'height'			: 420,
		'padding'			:  0,
		'autoScale'     	: false,
		'href'              : '{/literal}{$myobj->location_url}{literal}',
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
});
{/literal}
</script>
