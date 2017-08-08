{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_top"}
<div id="selMusicUpload" class="clsMusicUploadPage clsMusicDefaultSetting">
	<div class="clsOverflow">
	<div class="clsFloatLeft">
        <h3 class="clsH3Heading clsMusicDefaltSettingHead">
            {$LANG.musicupload_default_settings}
       </h3>
    </div>

<div class="clsAudioListMenu clsFloatRight">
	<ul>
		<li id="selDefaultSettings" class="{$default_class}"><a href="{$CFG.site.url}music/musicDefaultSettings.php" title="{$LANG.musicupload_default_settings}"><span>{$LANG.musicupload_default_settings}</span></a></li>
 {*Added the user_name field if artist feature is turned on*}
{if $CFG.admin.musics.music_artist_feature}
		<li id="selArtistDefaultSettings" class="{$artist_class}"><a href="{$CFG.site.url}music/musicDefaultSettings.php?page=artist" title="{$LANG.musicupload_artist_promo_default_settings}"><span>{$LANG.musicupload_artist_promo_default_settings}</span></a></li>

{/if}
	</ul>
</div>
</div>
{$myobj->setTemplateFolder('general/','music')}
{include file='information.tpl'}
{if $myobj->isShowPageBlock('block_music_default_form')}
    {*CONFIRMATION BOX FOR SKIPING STEP 2*}
      <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
        <p id="msgConfirmText"></p>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getUrl('musiclist', '?pg=mymusics', 'mymusics/', 'members', 'music')}" autocomplete="off">
            <input type="submit" class="clsSubmitButton" name="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
            <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
        </form>
      </div>
    <div id="selUpload">
    <div class="clsMusicDetailHdMain clsOverflow">


    {if !$myobj->chkIsEditMode()}
     {*   <div class="clsSkipBtn">
            <input type="button" name="skip" id="skip" tabindex="{smartyTabIndex}" value="{$LANG.musicupload_skip_step2}" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('msgConfirmText'), Array('{$LANG.musicupload_skip_message}'), Array('innerHTML'), 100, 150, 'anchor_upload');" />
        </div> *}
    {/if}

    </div>
        <form name="music_upload_form" id="music_upload_form" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off" enctype="multipart/form-data">
          <a id="anchor_upload"></a>

{if $CFG.admin.musics.allowed_usertypes_to_upload_for_sale != 'None'}
    <div id="selUploadBlock">

        <div class="">
		<p class="clsStepsTitle">{$LANG.musicuserpaymentsettings_title}</p>
		<div class="clsNoteContainerblock">
		<p>{$LANG.musicupdatepaymentsettings_note_msg}</p>
		<p>{$LANG.musicupdatepaymentsettings_note_msg2}</p>
		<p>{$LANG.musicupdatepaymentsettings_note_msg3}</p>
		</div>
		<div class="clsDataTable">
		<table>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('paypal_id')}">
				<label for="paypal_id">{$LANG.musicuserpaymentsettings_paypal_id}</label>&nbsp;
			</td>
			<td class="{$myobj->getCSSFormFieldCellClass('paypal_id')}">
            	<input type="text" class="clsTextBox" name="paypal_id" id="paypal_id" value="{$myobj->getFormField('paypal_id')}" tabindex="{smartyTabIndex}" />
				{$myobj->getFormFieldErrorTip('paypal_id')}
				{$myobj->ShowHelpTip('paypal_id')}
			</td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('threshold_amount')}">
				<label for="threshold_amount">{$LANG.musicuserpaymentsettings_threshold_amount}</label>&nbsp;({$CFG.currency})</label>&nbsp;
			</td>
			<td class="{$myobj->getCSSFormFieldCellClass('threshold_amount')}">
            	<input type="text" class="clsTextBox" name="threshold_amount" id="threshold_amount" value="{$myobj->getFormField('threshold_amount')}" tabindex="{smartyTabIndex}" />&nbsp; ({$LANG.musicupdatepaymentsettings_minimum}{$CFG.currency}{$CFG.admin.musics.minimum_threshold_amount})
				{$myobj->getFormFieldErrorTip('threshold_amount')}
				{$myobj->ShowHelpTip('threshold_amount')}
			</td>
		</tr>

	  </table>
		</div>

{/if}

        <p class="clsStepsTitle">{$LANG.musicupload_music_file_settings}</p>
         {* COMMON FIELDS STARTS HERE *}
         <div class="clsNoteContainerblock">
		<p>{$LANG.musicupload_default_note_msg}</p>
		</div>
         <div class="clsDataTable">
         <table class="clsMusicDefaltSettingTable">
			{if $myobj->content_filter}
            <tr id="selDateLocationRow" class="clsAllowOptions">
                <td class="{$myobj->getCSSFormLabelCellClass('music_category_type')}">
                    <label for="music_category_type">{$LANG.musicupload_music_category_type}</label>
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('music_category_type')}">
                    <input type="radio" class="clsCheckRadio" name="music_category_type" id="music_category_type1" value="Porn" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('music_category_type','Porn')} onclick="document.getElementById('selGeneralCategory').style.display='none';document.getElementById('selPornCategory').style.display='';" />
                    &nbsp;<label for="music_category_type1" class="">{$LANG.common_porn}</label>
                    &nbsp;&nbsp;
                    <input type="radio" class="clsCheckRadio" name="music_category_type" id="music_category_type2" value="General" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('music_category_type','General')}
                    onClick="document.getElementById('selGeneralCategory').style.display='';document.getElementById('selPornCategory').style.display='none';" />
                    &nbsp;<label for="music_category_type2" class="">{$LANG.common_general}</label>
                    {$myobj->getFormFieldErrorTip('music_category_type')}
                    {$myobj->ShowHelpTip('musicupload_category_type')}        </td>
            </tr>
			{/if}
            <tr id="selCategoryBlock">
                <td class="{$myobj->getCSSFormLabelCellClass('music_category_id')}">
                    <label for="music_category_id_general">{$LANG.musicupload_music_category}</label>&nbsp;
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('music_category_id')}">
                <div id="selGeneralCategory" style="display:{$myobj->General}">
                    <select name="music_category_id" id="music_category_id" {if $CFG.admin.musics.sub_category} onChange="populateMusicSubCategory(this.value)" {/if} tabindex="{smartyTabIndex}" class="clsSelectLarge">
                      <option value="">{$LANG.common_select_option}</option>
                      {$myobj->populateMusicCatagory('General')}
                    </select>
                    {$myobj->getFormFieldErrorTip('music_category_id')}
                    {$myobj->ShowHelpTip('musicupload_category_id_general')}
                    <p class="clsSelectNote clsUploadnotesmall">{$LANG.musicupload_select_category}</p>
                </div>
                {if isAdultUser('', 'music') and $myobj->content_filter}
                      <div id="selPornCategory" style="display:{$myobj->Porn}">
                          <select name="music_category_id_porn" id="music_category_id_porn" {if $CFG.admin.musics.sub_category} onChange="populateMusicSubCategory(this.value)" {/if} tabindex="{smartyTabIndex}" class="clsSelectLarge">
                          <option value="">{$LANG.common_select_option}</option>
                          {$myobj->populateMusicCatagory('Porn')}
                          </select>
                          {$myobj->ShowHelpTip('musicupload_category_id')}
                          <p class="clsSelectNote clsUploadnotesmall">{$LANG.musicupload_select_a_category}</p>
                      </div>
                {/if}
               </td>
            </tr>
            {if $CFG.admin.musics.sub_category}
            <tr id="selSubCategoryBlock">
                <td class="{$myobj->getCSSFormLabelCellClass('music_sub_category_id')}">
                <label for="music_sub_category_id">{$LANG.musicupload_music_sub_category}</label>
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('music_sub_category_id')}">
                <div id="selSubCategoryBox">
                    <select name="music_sub_category_id" id="music_sub_category_id" tabindex="{smartyTabIndex}">
                        <option value="">{$LANG.common_select_option}</option>
                    </select>
                    {$myobj->getFormFieldErrorTip('music_sub_category_id')}
                </div>
                {$myobj->ShowHelpTip('music_sub_category_id')}
               </td>
            </tr>
            {/if}
			{if $myobj->chkIsAllowedForSale()}
			<tr>
                <td class="{$myobj->getCSSFormLabelCellClass('for_sale')}">
                    <label for="for_sale">{$LANG.musicupload_for_sale}</label>&nbsp;
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('for_sale')}">
                    <input type="radio" name="for_sale" id="for_sale1" value="Yes" onclick="enabledFormFields(Array('music_price', 'preview_start', 'preview_end'));" tabindex="{smartyTabIndex}"
					{$myobj->isCheckedRadio('for_sale','Yes')}/> &nbsp;{$LANG.musicupload_yes}&nbsp;
                    <input type="radio" name="for_sale" id="for_sale2" value="No" onclick="disabledFormFields(Array('music_price', 'preview_start', 'preview_end'));" tabindex="{smartyTabIndex}"
					 {$myobj->isCheckedRadio('for_sale','No')}/> &nbsp;{$LANG.musicupload_no}
                </td>
            </tr>
			<tr>
                <td class="{$myobj->getCSSFormLabelCellClass('music_price')}">
                    <label for="music_tags">{$LANG.musicupload_music_price}</label>&nbsp;({$CFG.currency})
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('music_price')}">
                    <input type="text" class="clsTextBox" name="music_price" id="music_price" value="{$myobj->getFormField('music_price')}" tabindex="{smartyTabIndex}" />
                    {$myobj->getFormFieldErrorTip('music_price')}
                    {$myobj->ShowHelpTip('music_price')}
                </td>
            </tr>
            {if isset($CFG.admin.musics.allow_members_to_choose_the_preview) and $CFG.admin.musics.allow_members_to_choose_the_preview}
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('preview_start')}">
                    <label for="preview_start">{$LANG.musicupload_preview_start}</label>&nbsp;
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('preview_start')}">
                    <input type="text" class="clsTextBox" name="preview_start" id="preview_start" value="{$myobj->getFormField('preview_start')}" tabindex="{smartyTabIndex}" />
                    {$myobj->getFormFieldErrorTip('preview_start')}
                    {$myobj->ShowHelpTip('preview_start')}
                    <p>{$LANG.musicupload_preview_start_time_note_msg}</p>
                </td>
            </tr>
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('preview_end')}">
                    <label for="preview_end">{$LANG.musicupload_preview_end}</label>&nbsp;
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('preview_end')}">
                    <input type="text" class="clsTextBox" name="preview_end" id="preview_end" value="{$myobj->getFormField('preview_end')}" tabindex="{smartyTabIndex}" />
                    {$myobj->getFormFieldErrorTip('preview_end')}
                    {$myobj->ShowHelpTip('preview_end')}
                </td>
            </tr>
            {/if}
            {/if}
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('music_tags')}">
                    <label for="music_tags">{$LANG.musicupload_music_tags}</label>&nbsp;
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('music_tags')}">
                    <input type="text" class="clsTextBox" name="music_tags" id="music_tags" value="{$myobj->getFormField('music_tags')}" tabindex="{smartyTabIndex}" />
                    {$myobj->getFormFieldErrorTip('music_tags')}
                    {$myobj->ShowHelpTip('music_tags')}
                    <p class="clsUploadnotesmall">{$myobj->musicUpload_tags_msg}</p>
                    <p class="clsUploadnotesmall">{$LANG.musicupload_tags_msg2}</p>
                </td>
            </tr>
        </table>
		 </div>
        {* OTHER UPLOAD OPTIONS STARTS HERE *}
		<p class="clsStepsTitle">{$LANG.musicupload_music_other_upload_settings}</p>
        <div class="clsDataTable">
            <table summary="{$LANG.musicupload_tbl_summary}" id="selUploadTbl_otherOption">
                <tr class="clsAllowOptions">
                  <td class="{$myobj->getCSSFormLabelCellClass('music_language')} clsAudioUploadLabel">
                    <label for="music_language">{$LANG.musicupload_language}</label>
                  </td>
                  <td class="{$myobj->getCSSFormFieldCellClass('music_language')}">
                    <select name="music_language" id="music_language"  tabindex="{smartyTabIndex}">
                    <option value="0">{$LANG.musicupload_sel_language}</option>
                        {$myobj->generalPopulateArray($myobj->LANG_LANGUAGE_ARR, $myobj->getFormField('music_language'))}
                    </select>
                    {$myobj->ShowHelpTip('music_language')}
                    </td>
                  </tr>
				  </table>
				  
                <p class="clsStepsTitle">{$LANG.common_sharing}</p>
			<table summary="{$LANG.musicupload_tbl_summary}" id="selUploadTbl_otherOption" class="clsMusicDefaltSettingTable">
                <tr id="selAccessTypeRow">
                    <td class="{$myobj->getCSSFormLabelCellClass('music_access_type')}">
                        <label for="music_access_type1">{$LANG.musicupload_music_access_type}</label>
                    </td>
                    <td class="{$myobj->getCSSFormFieldCellClass('music_access_type')}">
                        <p><input type="radio" class="clsCheckRadio" name="music_access_type" id="music_access_type1" value="Public" tabindex="{smartyTabIndex}"
                        {$myobj->isCheckedRadio('music_access_type','Public')} />&nbsp;<label for="music_access_type1">{$LANG.musicupload_public}
                        </label>{$LANG.musicupload_share_your_music_world}</p>
                        <p><input type="radio" class="clsCheckRadio" name="music_access_type" id="music_access_type2" value="Private" tabindex="{smartyTabIndex}"
                        {$myobj->isCheckedRadio('music_access_type','Private')} />&nbsp;<label for="music_access_type2">{$LANG.musicupload_private}
                        </label>{$LANG.musicupload_only_viewable_by_you}</p>
                        <p class="clsUploadnotesmall">{$LANG.musicupload_only_viewable_you_email_default}:</p>
                        {$myobj->populateCheckBoxForRelationList()}
                        {$myobj->getFormFieldErrorTip('music_access_type')}
                        {$myobj->ShowHelpTip('music_access_type')}
                     </td>
                </tr>
                <tr id="selAllowCommentsRow">
                    <td class="{$myobj->getCSSFormLabelCellClass('allow_comments')}">
                        <label for="allow_comments1">{$LANG.musicupload_allow_comments}</label>        </td>
                    <td class="{$myobj->getCSSFormFieldCellClass('allow_comments')}">
                    <p>
                    <input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments1" value="Yes" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_comments','Yes')} />&nbsp;<label for="allow_comments1" class="clsBold">{$LANG.common_yes_option}</label>
                    {$LANG.musicupload_allow_comments_world}</p>
                    <p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments2" value="No" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_comments','No')} />&nbsp;<label for="allow_comments2" class="clsBold">{$LANG.common_no_option}</label>&nbsp;{$LANG.musicupload_disallow_comments}        </p>
                    <p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments3" value="Kinda" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_comments','Kinda')} />&nbsp;<label for="allow_comments3" class="clsBold">{$LANG.common_kinda}</label>
                    {$LANG.musicupload_approval_comments}       	</p>
                    {$myobj->getFormFieldErrorTip('allow_comments')}
                    {$myobj->ShowHelpTip('allow_comments')}	</td>
                </tr>
                <tr id="selDateLocationRow" class="clsAllowOptions">
                    <td class="{$myobj->getCSSFormLabelCellClass('allow_ratings')}">
                        <label for="allow_ratings">{$LANG.musicupload_allow_ratings}</label>		</td>
                    <td class="{$myobj->getCSSFormFieldCellClass('allow_ratings')}">
                    <p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings1" value="Yes" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_ratings','Yes')} />&nbsp;<label for="allow_ratings1" class="clsBold">{$LANG.common_yes_option}</label>
                    {$LANG.musicupload_allow_ratings_world}</p>
                    <p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings2" value="No" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_ratings','No')} />&nbsp;<label for="allow_ratings2" class="clsBold">{$LANG.common_no_option}</label>&nbsp;{$LANG.musicupload_disallow_ratings}             </p>
                    <p id="selDisableNote" class="clsUploadnotesmall">{$LANG.musicupload_disallow_ratings_note}</p>
                    {$myobj->getFormFieldErrorTip('allow_ratings')}
                    {$myobj->ShowHelpTip('allow_ratings')}
                    </td>
                </tr>
                <tr id="selDateLocationRow" class="clsAllowOptions">
                    <td class="{$myobj->getCSSFormLabelCellClass('allow_lyrics')}">
                        <label for="allow_ratings">{$LANG.musicupload_allow_lyrics}</label>		</td>
                    <td class="{$myobj->getCSSFormFieldCellClass('allow_lyrics')}">
                    <p><input type="radio" class="clsCheckRadio" name="allow_lyrics" id="allow_lyrics1" value="Yes" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_lyrics','Yes')} />&nbsp;<label for="allow_lyrics1" class="clsBold">{$LANG.common_yes_option}</label>
                    {$LANG.musicupload_allow_lyrics_world}</p>
                    <p><input type="radio" class="clsCheckRadio" name="allow_lyrics" id="allow_lyrics2" value="No" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_lyrics','No')} />&nbsp;<label for="allow_lyrics2" class="clsBold">{$LANG.common_no_option}</label>&nbsp;{$LANG.musicupload_disallow_lyrics}             </p>
                    <p id="selLyricsNote" class="clsUploadnotesmall">{$LANG.musicupload_lyrics_note}</p>
                    {$myobj->getFormFieldErrorTip('allow_lyrics')}
                    {$myobj->ShowHelpTip('allow_lyrics')}
                    </td>
                </tr>
                <tr id="selDateLocationRow" class="clsAllowOptions">
                    <td class="{$myobj->getCSSFormLabelCellClass('allow_embed')}">
                        <label for="allow_embed1">{$LANG.musicupload_allow_embed}</label>		</td>
                    <td class="{$myobj->getCSSFormFieldCellClass('allow_embed')}">
                        <p><input type="radio" class="clsCheckRadio" name="allow_embed" id="allow_embed1" value="Yes" tabindex="{smartyTabIndex}"
                        {$myobj->isCheckedRadio('allow_embed','Yes')} />&nbsp;<label for="allow_embed1" class="clsBold">{$LANG.musicupload_enable}</label>
                        {$LANG.musicupload_allow_embed_external}</p>
                        <p><input type="radio" class="clsCheckRadio" name="allow_embed" id="allow_embed2" value="No" tabindex="{smartyTabIndex}"
                        {$myobj->isCheckedRadio('allow_embed','No')} />&nbsp;<label for="allow_embed2" class="clsBold">{$LANG.musicupload_disable}</label>
                        {$LANG.musicupload_disallow_embed_external}</p>
                        {$myobj->getFormFieldErrorTip('allow_embed')}
                        {$myobj->ShowHelpTip('allow_embed')}
                        </td>
                </tr>
            </table>
        </div>
        {* OTHER UPLOAD OPTIONS ENDS HERE *}

                {*$myobj->populateHidden(array('gpukey')*}
                {$myobj->populateHidden($myobj->hidden_arr)}
                {$myobj->populateHidden($myobj->multi_hidden_arr)}
                {if !$myobj->chkIsEditMode()}
                    <div class="clsOverflow">
                        <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" class="clsSubmitButton clsmusicUploadButton" name="upload_music" id="upload_music" tabindex="{smartyTabIndex}" value="{$LANG.musicupload_submit}" />
                        </span></p>
                    </div>
                {else}
                    <div class="clsOverflow">
                         <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="upload_music" id="upload_music" tabindex="{smartyTabIndex}" value="{$LANG.musicupload_update}" /></span></p>
                         <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" onClick="javascript:window.location='{php}echo (isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:getUrl('musiclist','?pg=mymusics','mymusics/','','music'));{/php}'"class="clsmusicUploadButton" name="cancel" tabindex="{smartyTabIndex}" value="{$LANG.musicupload_cancel}" /></span></p>
                     </div>
                {/if}

        </div>
		</div>
        </form>
    </div>
		{if $myobj->getFormField('for_sale')=='No'}
            {literal}
	            <script type="text/javascript">
					disabledFormFields(Array('music_price', 'preview_start', 'preview_end'));
				</script>
            {/literal}
        {/if}
{/if}
{if $myobj->isShowPageBlock('block_music_artist_default_form')}
<div>
		<form name="music_upload_form" id="music_upload_form" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off" enctype="multipart/form-data">
		<p class="clsStepsTitle">Promo Settings</p>
		<div class="clsNoteContainerblock">
		<p>{$LANG.musicupload_artist_promo_note_msg}</p>
		<p>{$LANG.musicupload_artist_promo_note_msg2}</p>
		</div>
		<div class="clsDataTable clsMarginBtm1px">
		<table>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('artist_promo_file')}">
				<label for="artist_promo_file">{$LANG.musicartist_promo_image}&nbsp;({$myobj->image_format})({$CFG.admin.musics.artist_promo_image_size} KB)</label>&nbsp;
			</td>
			<td class="{$myobj->getCSSFormFieldCellClass('artist_promo_file')}">
                <input type="file" class="clsFile" accept="music/{$myobj->music_format}" name="artist_promo_file" id="artist_promo_file" tabindex="{smartyTabIndex}" />
                {$myobj->getFormFieldErrorTip('artist_promo_file')}
            </td>
		</tr>
		<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('artist_promo_caption')}">
				<label for="artist_promo_caption">{$LANG.musicartist_promo_caption}</label>&nbsp;
			</td>
			<td class="{$myobj->getCSSFormFieldCellClass('artist_promo_caption')}">
            	<textarea name="artist_promo_caption" id="artist_promo_caption" tabindex="{smartyTabIndex}">{$myobj->getFormField('artist_promo_caption')}</textarea>
				{$myobj->getFormFieldErrorTip('artist_promo_caption')}
			</td>
		</tr>
		<tr>
			<td>
				<!--empty td-->
			</td>
			<td>
				<div class="clsOverflow">
                         <p class="clsSubmitButton-l clsPaddingbm0"><span class="clsSubmitButton-r"><input type="submit" name="upload" id="upload" tabindex="{smartyTabIndex}" value="{$LANG.musicupload_update}" /></span></p>
                         <p class="clsCancelButton-l clsPaddingbm0"><span class="clsCancelButton-r"><input type="button" onClick="javascript:window.location='{php}echo (isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:getUrl('musiclist','?pg=mymusics','mymusics/','','music'));{/php}'"class="clsmusicUploadButton" name="cancel" tabindex="{smartyTabIndex}" value="{$LANG.musicupload_cancel}" /></span></p>
                     </div>
			</td>
		</tr>
		<input type="hidden" name="page" id="page" value="artist" />

	  </table>
	  </div>
        </form>

		{if $myobj->getFormField('artist_promo_image')}
			<div class="clsArtistInfoTable">
			  <table>
				<tr>
				  <th colspan="2" class="text clsProfileTitle"><span class="whitetext12">Preview</span></th>
				</tr>
				<tr>
				  <td colspan="2">
				  <div class="clsArtistInfoContainer">
						<div class="clsArtistInfoImage">
							<div class="clsOverflow">
							  <div class="clsThumbImageLink">
								<a href="{$artist_info_arr.memberProfileUrl}" class="ClsImageContainer ClsImageBorder1 Cls455x305">
									<img src="{$myobj->getFormField('artist_promo_image')}" />
								 </a>
							   </div>
						   </div>
						</div>
					</div>
					</td>
				 </tr>
			  </table>
		   </div>
		{/if}

		</div>
{/if}
{*<!--#############	UPLOAD FORM ENDS HERE   		  #############-->*}

</div>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_bottom"}