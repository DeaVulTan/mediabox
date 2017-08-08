<div id="selVideoUpload" class="clsVideoUploadPopUpPage">
{$myobj->setTemplateFolder('general/',video)}
{include file='box.tpl' opt='display_top'}
<div class="clsPageHeading">
	<h2>
	    {if $myobj->chkIsEditMode()}
        	{$LANG.videoupload_edit_title}
        {else}
         {$myobj->VideoUploadTitle}
         {/if}
   </h2>
</div>
	<div id="selLeftNavigation">
	{if $myobj->isShowPageBlock('msg_form_error')}
		<div id="selMsgError">
			<p>{$myobj->getCommonErrorMsg()}</p>
		</div>
     {/if}
	{if $myobj->isShowPageBlock('msg_form_success')}
  	   <div id="selMsgSuccess">
	   <p>{$myobj->getCommonErrorMsg()}</p>
       {if !$myobj->chkIsEditMode()}
	   <p>{$myobj->uploadAnother}</p>
       {/if}
		{if !$myobj->chkIsEditMode()}

			<script language="javascript" type="text/javascript">
				//alert("{$myobj->videoupload_msg_success_uploaded}");
			</script>
         {/if}
       </div>
   {/if}

<div class="clsOverflow">

{*<!--#############	UPLOAD FORM STARTS HERE   		  #############-->*}
{if $myobj->isShowPageBlock('video_upload_form')}
<div id="selUpload" class="clsDataTable clsNoBorder">
	{if $myobj->chkIsEditMode()}
	<form name="video_update_form" id="video_update_form" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
	<div id="selCenterPlainImage">
            	<div id="selImageBorder">
                <div class="clsOverflow">
                    <p class="clsViewThumbImage">
                        {if $myobj->getFormField('is_external_embed_video')=='Yes' && $myobj->getFormField('embed_video_image_ext')==''}
                            <span><img src="{$CFG.site.url}images/no-video.jpg" alt="{$myobj->getFormField('video_title')}" {$myobj->disp_image} /></span>
                        {else}
                            <span><img src="{$myobj->imageSrc}" alt="{$myobj->getFormField('video_title')}" {$myobj->disp_image} /></span>
                        {/if}
                    </p>
                </div>
                <strong><a href="{$myobj->changeThumbUrl}">{$LANG.videoupload_change_thumbnail}</a></strong>
            	</div>
	</div>
	{else}
	<form name="video_upload_form" id="video_upload_form" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off"
    enctype="multipart/form-data" onsubmit="return chkMandatoryFields();">
	{/if}
    <input type="hidden" name="use_vid" value="{$myobj->getFormField('use_vid')}" />
	<div id="selUploadBlock">
	<table summary="{$LANG.videoupload_tbl_summary}" id="selUploadTbl" class="clsFormTableSection clsUploadBlock clsNoBorder">
	<tr>
		<td class="clsVideoUploadLabel {$myobj->getCSSFormLabelCellClass('video_album_id')}">
			<label for="video_album_id">{$LANG.videoupload_video_album_id}</label></td>
		<td class="{$myobj->getCSSFormFieldCellClass('video_album_id')}">
		<select name="video_album_id" id="video_album_id" tabindex="{smartyTabIndex}" class="clsSelectLarge">
			<option value="">{$LANG.videoupload_select_album}</option>
			{$myobj->populateVideoAlbums()}
		</select>
            {$myobj->getFormFieldErrorTip('video_album_id')}
	      {$myobj->ShowHelpTip('video_album_id')}
		{if !$myobj->chkIsEditMode()}
		<p id="selCreateAlbum"><a href="{$myobj->createAlbumUrl}" tabindex="{smartyTabIndex}">{$LANG.videoupload_create_album}</a></p>
		{/if}    	</td>
	</tr>
	<tr>
		<td class="{$myobj->getCSSFormLabelCellClass('video_title')}">
			<label for="video_title">{$LANG.videoupload_video_title}</label>&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.videoupload_important}&nbsp;	</span>	</td>
		<td class="{$myobj->getCSSFormFieldCellClass('video_title')}">
			<input type="text" class="clsTextBox" name="video_title" id="video_title" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('video_title')}" maxlength="{$CFG.admin.videos.title_max_length}" />
                  {$myobj->getFormFieldErrorTip('video_title')}
            	{$myobj->ShowHelpTip('video_title')}
            </td>
	</tr>
	<tr>
		<td class="{$myobj->getCSSFormLabelCellClass('video_caption')}">
			<label for="video_caption">{$LANG.videoupload_video_caption}</label>		</td>
		<td class="{$myobj->getCSSFormFieldCellClass('video_caption')}">
			<textarea name="video_caption" id="video_caption" tabindex="{smartyTabIndex}">{$myobj->getFormField('video_caption')}</textarea>
                  {$myobj->getFormFieldErrorTip('video_caption')}
            	{$myobj->ShowHelpTip('video_caption')}
            </td>
	</tr>
	<tr>
        <td class="{$myobj->getCSSFormLabelCellClass('video_tags')}">
            <label for="video_tags">{$LANG.videoupload_video_tags}</label>&nbsp; <span class="clsMandatoryFieldIcon">{$LANG.videoupload_important}&nbsp; </span>       </td>
        <td class="{$myobj->getCSSFormFieldCellClass('video_tags')}">
           <p><input type="text" class="clsTextBox" name="video_tags" id="video_tags" value="{$myobj->getFormField('video_tags')}" tabindex="{smartyTabIndex}" /></p>
            <p>{$myobj->getFormFieldErrorTip('video_tags')}</p>
            <p>{$myobj->ShowHelpTip('video_tags')}</p>
            <p>{$myobj->videoupload_tags_msg}</p>
        </td>
	</tr>
    {if $myobj->content_filter}
	<tr id="selDateLocationRow" class="clsAllowOptions">
        <td class="{$myobj->getCSSFormLabelCellClass('video_category_type')}">
            <label for="video_category_type">{$LANG.videoupload_video_category_type}</label>        </td>
        <td class="{$myobj->getCSSFormFieldCellClass('video_category_type')}">
            <input type="radio" class="clsCheckRadio" name="video_category_type" id="video_category_type1" value="Porn" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('video_category_type','Porn')} onclick="document.getElementById('selGeneralCategory').style.display='none';document.getElementById('selPornCategory').style.display='';" />
            &nbsp;<label for="video_category_type1" class="clsBold">{$LANG.common_porn}</label>
            &nbsp;&nbsp;
            <input type="radio" class="clsCheckRadio" name="video_category_type" id="video_category_type2" value="General" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('video_category_type','General')} onclick="document.getElementById('selGeneralCategory').style.display='';document.getElementById('selPornCategory').style.display='none';" />
            &nbsp;<label for="video_category_type2" class="clsBold">{$LANG.common_general}</label>
            {$myobj->getFormFieldErrorTip('video_category_type')}
            {$myobj->ShowHelpTip('video_category_type')}
        </td>
	</tr>
   	{/if}
	<tr id="selCategoryBlock">
        <td class="{$myobj->getCSSFormLabelCellClass('video_category_id')}">
            <label for="video_category_id_general">{$LANG.videoupload_video_category_id}</label>&nbsp; <span class="clsMandatoryFieldIcon">{$LANG.videoupload_important}&nbsp;</span>
        </td>
        <td class="{$myobj->getCSSFormFieldCellClass('video_category_id')}">
        <div id="selGeneralCategory" style="display:{$myobj->General}">
        	<select name="video_category_id_general" id="video_category_id_general" {if $CFG.admin.videos.sub_category} onChange="populateSubCategory(this.value)" {/if} tabindex="{smartyTabIndex}" class="clsSelectLarge">
              <option value="">{$LANG.common_select_option}</option>
            {$myobj->populateVideoCatagory('General')}
            </select>
			{$myobj->getFormFieldErrorTip('video_category_id')}
            {$myobj->ShowHelpTip('video_category_id_general')}
            <p class="clsSelectNote">{$LANG.videoupload_select_a_category}</p>
        </div>
        {if $myobj->content_filter and isAdultUser('video')}
        <div id="selPornCategory" style="display:{$myobj->Porn}">
                	<select name="video_category_id_porn" id="video_category_id_porn" {if $CFG.admin.videos.sub_category} onChange="populateSubCategory(this.value)" {/if} tabindex="{smartyTabIndex}" class="clsSelectLarge">
                    <option value="">{$LANG.common_select_option}</option>
		            {$myobj->populateVideoCatagory('Porn')}
            </select>
            {$myobj->ShowHelpTip('video_category_id')}
		    <p class="clsSelectNote">{$LANG.videoupload_select_a_category}</p>
        </div>
        {/if}
        </td>
	</tr>
    {if $CFG.admin.videos.sub_category}
	<tr id="selDateLocationRow">
		<td class="{$myobj->getCSSFormLabelCellClass('video_sub_category_id')}">
		<label for="video_sub_category_id">{$LANG.videoupload_video_sub_category_id}</label>
            </td>
		<td class="{$myobj->getCSSFormFieldCellClass('video_sub_category_id')}">
              <div id="selSubCategoryBox">
              <select name="video_sub_category_id" id="video_sub_category_id" tabindex="{smartyTabIndex}">
                  <option value="">{$LANG.common_select_option}</option>
              </select>
		</div>
              {$myobj->getFormFieldErrorTip('video_sub_category_id')}
	        {$myobj->ShowHelpTip('video_sub_category_id')}
        	</td>
	</tr>
    {/if}
    </table>
    <div id="videosThumsDetailsLinks" class="clsVideoRight clsShowHideFilter">
    <a href="javascript:void(0)" id="show_link" class="clsShowFilterSearch" onclick="divShowHide('otherUploadOption', 'show_link', 'hide_link')"><span>{$LANG.videoupload_show_other_option}</span></a>
                       		<a href="javascript:void(0)" id="hide_link" style="display:none;" class="clsHideFilterSearch"  onclick="divShowHide('otherUploadOption', 'show_link', 'hide_link')"><span>{$LANG.videoupload_hide_other_option}</span></a>
                        </div>
        <div id="otherUploadOption" style="{$myobj->other_upload_option_display}">
    <table summary="{$LANG.videoupload_tbl_summary}" id="selUploadTbl_otherOption" class="clsFormTableSection clsUploadBlock clsNoBorder">
   <tr>
        <th class="clsVideoUploadLabel">{$LANG.videoupload_search_optmization}</th>
        <th>&nbsp;</th>
    </tr>
    <tr class="clsAllowOptions">
	  <td class="{$myobj->getCSSFormLabelCellClass('video_page_title')}">
      	<label for="video_page_title">{$LANG.videoupload_page_title}</label>
      </td>
	  <td class="{$myobj->getCSSFormFieldCellClass('video_page_title')}">
      	<input name="video_page_title" id="video_page_title" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('video_page_title')}" class="clsTextBox" maxlength="{$CFG.fieldsize.video_page_title.max}" />
            {$myobj->getFormFieldErrorTip('video_page_title')}
        	{$myobj->ShowHelpTip('video_page_title')}
        </td>
	  </tr>
      <tr class="clsAllowOptions">
	  <td class="{$myobj->getCSSFormLabelCellClass('video_meta_keyword')}">
      	<label for="video_meta_keyword">{$LANG.videoupload_meta_keywords}</label>
        </td>
	  <td class="{$myobj->getCSSFormFieldCellClass('video_meta_keyword')}">
      	<textarea name="video_meta_keyword" id="video_meta_keyword" tabindex="{smartyTabIndex}">{$myobj->getFormField('video_meta_keyword')}</textarea>
            {$myobj->getFormFieldErrorTip('video_meta_keyword')}
        	{$myobj->ShowHelpTip('video_meta_keyword')}
        </td>
	  </tr>
      <tr class="clsAllowOptions">
	  <td class="{$myobj->getCSSFormLabelCellClass('video_meta_description')}">
      	<label for="video_meta_description">{$LANG.videoupload_meta_description}</label>
        </td>
	  <td class="{$myobj->getCSSFormFieldCellClass('video_meta_description')}">
      	<textarea name="video_meta_description" id="video_meta_description" tabindex="{smartyTabIndex}">{$myobj->getFormField('video_meta_description')}</textarea>
            {$myobj->getFormFieldErrorTip('video_meta_description')}
        	{$myobj->ShowHelpTip('video_meta_description')}
        </td>
	  </tr>
    <tr>
        <th class="clsVideoUploadLabel">{$LANG.videoupload_region_language}</th>
        <th>&nbsp;</th>
    </tr>
    <tr class="clsAllowOptions">
	  <td class="{$myobj->getCSSFormLabelCellClass('allow_embed')}">
      	<label for="video_country">{$LANG.videoupload_country}</label>
      </td>
	  <td class="{$myobj->getCSSFormFieldCellClass('allow_embed')}">
      	<select name="video_country" id="video_country" tabindex="{smartyTabIndex}">
              <option value="0">{$LANG.videoupload_sel_country}</option>
                  {$myobj->generalPopulateArray($myobj->LANG_COUNTRY_ARR, $myobj->getFormField('video_country'))}
              </select>
            {$myobj->ShowHelpTip('video_country')}
        </td>
	  </tr>
	<tr class="clsAllowOptions">
	  <td class="{$myobj->getCSSFormLabelCellClass('allow_embed')}">
      	<label for="video_language">{$LANG.videoupload_language}</label>
      </td>
	  <td class="{$myobj->getCSSFormFieldCellClass('allow_embed')}">
      	<select name="video_language" id="video_language"  tabindex="{smartyTabIndex}">
              <option value="0">{$LANG.videoupload_sel_language}</option>
                  {$myobj->generalPopulateArray($myobj->LANG_LANGUAGE_ARR, $myobj->getFormField('video_language'))}
              </select>
            {$myobj->ShowHelpTip('video_language')}
        </td>
	  </tr>
	<tr>
        <th>{$LANG.common_sharing}</th>
        <th>&nbsp;</th>
    </tr>
    <tr id="selDateLocationRow">
        <td class="{$myobj->getCSSFormLabelCellClass('video_access_type')}">
            <label for="video_access_type1">{$LANG.videoupload_video_access_type}</label>        </td>
        <td class="{$myobj->getCSSFormFieldCellClass('video_access_type')}">
            <p><input type="radio" class="clsCheckRadio" name="video_access_type" id="video_access_type1" value="Public" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('video_access_type','Public')} />&nbsp;<label for="video_access_type1" class="clsBold">{$LANG.videoupload_public}
            </label>{$LANG.videoupload_share_your_video_world}</p>
            <p><input type="radio" class="clsCheckRadio" name="video_access_type" id="video_access_type2" value="Private" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('video_access_type','Private')} />&nbsp;<label for="video_access_type2" class="clsBold">{$LANG.videoupload_private}
            </label>{$LANG.videoupload_only_viewable_you}</p>
            <p class="clsSelectHighlightNote">{$LANG.videoupload_only_viewable_you_email}</p>
            <br />{$myobj->populateCheckBoxForRelationList()}
		{$myobj->getFormFieldErrorTip('video_access_type')}
            {$myobj->ShowHelpTip('video_access_type')}
         </td>
	</tr>
	<tr id="selDateLocationRow" class="clsAllowOptions">
        <td class="{$myobj->getCSSFormLabelCellClass('allow_comments')}">
            <label for="allow_comments1">{$LANG.videoupload_allow_comments}</label>        </td>
        <td class="{$myobj->getCSSFormFieldCellClass('allow_comments')}">
		<p>
        <input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments1" value="Yes" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('allow_comments','Yes')} />&nbsp;	<label for="allow_comments1" class="clsBold">{$LANG.common_yes_option}</label>
        {$LANG.videoupload_allow_comments_world}</p>
		<p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments2" value="No" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('allow_comments','No')} />&nbsp;<label for="allow_comments2" class="clsBold">{$LANG.common_no_option}</label>&nbsp;{$LANG.videoupload_disallow_comments}        </p>
		<p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments3" value="Kinda" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('allow_comments','Kinda')} />&nbsp;<label for="allow_comments3" class="clsBold">{$LANG.common_kinda}</label>
        {$LANG.videoupload_approval_comments}       	</p>
        {$myobj->getFormFieldErrorTip('allow_comments')}
        {$myobj->ShowHelpTip('allow_comments')}
        </td>
    </tr>
    <tr id="selDateLocationRow" class="clsAllowOptions">
        <td class="{$myobj->getCSSFormLabelCellClass('allow_ratings')}">
        	<label for="allow_ratings">{$LANG.videoupload_allow_ratings}</label>		</td>
		<td class="{$myobj->getCSSFormFieldCellClass('allow_ratings')}">
		<p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings1" value="Yes" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('allow_ratings','Yes')} />&nbsp;<label for="allow_ratings1" class="clsBold">{$LANG.common_yes_option}</label>
        	{$LANG.videoupload_allow_ratings_world}</p>
		<p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings2" value="No" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('allow_ratings','No')} />&nbsp;<label for="allow_ratings2" class="clsBold">{$LANG.common_no_option}</label>&nbsp;{$LANG.videoupload_disallow_ratings}</p>
		<p id="selDisableNote">{$LANG.videoupload_disallow_ratings1}</p>
	      {$myobj->getFormFieldErrorTip('allow_ratings')}
            {$myobj->ShowHelpTip('allow_ratings')}
        </td>
   	</tr>
	<tr id="selDateLocationRow" class="clsAllowOptions">
   		<td class="{$myobj->getCSSFormLabelCellClass('allow_embed')}">
			<label for="allow_embed1">{$LANG.videoupload_allow_embed}</label>		</td>
		<td class="{$myobj->getCSSFormFieldCellClass('allow_embed')}">
			<p><input type="radio" class="clsCheckRadio" name="allow_embed" id="allow_embed1" value="Yes" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('allow_embed','Yes')} />&nbsp;<label for="allow_embed1" class="clsBold">{$LANG.videoupload_enabled}</label>
            {$LANG.videoupload_allow_embed_external}</p>
			<p><input type="radio" class="clsCheckRadio" name="allow_embed" id="allow_embed2" value="No" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('allow_embed','No')} />&nbsp;<label for="allow_embed2" class="clsBold">{$LANG.videoupload_disabled}</label>
            {$LANG.videoupload_disallow_embed_external}</p>
		{$myobj->getFormFieldErrorTip('allow_embed')}
            {$myobj->ShowHelpTip('allow_embed')}
            </td>
	</tr>
	<tr class="clsAllowOptions">
	  <td class="{$myobj->getCSSFormLabelCellClass('allow_response')}">
	        <label for="allow_response">
        {$LANG.videoupload_allow_response}</label>
      </td>
	  <td class="{$myobj->getCSSFormFieldCellClass('allow_response')}">
    	<p>
            <input type="radio" class="clsCheckRadio" name="allow_response" id="allow_response1" value="Yes" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('allow_response','Yes')} />&nbsp;
            <label for="allow_ratings1" class="clsBold">{$LANG.common_yes_option}</label>
            {$LANG.videoupload_allow_response_world}
        </p>
        <p>
            <input type="radio" class="clsCheckRadio" name="allow_response" id="allow_response2" value="No" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('allow_response','No')} />&nbsp;
            <label for="allow_ratings1" class="clsBold">{$LANG.common_no_option}</label>
            {$LANG.videoupload_notallow_response_world}
        </p>
        <p>
            <input type="radio" class="clsCheckRadio" name="allow_response" id="allow_response3" value="Kinda" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('allow_response','Kinda')} />&nbsp;
            <label for="allow_ratings1" class="clsBold">{$LANG.common_kinda}</label>
            {$LANG.videoupload_kinda_response_world}
        </p>
        {$myobj->ShowHelpTip('allow_response')}
      </td>
	  </tr>

	</table>
    </div>
    <table summary="{$LANG.videoupload_tbl_summary}" id="selUploadTbl_otherOption" class="clsFormTableSection clsUploadBlock clsNoBorder">
    <tr id="selDateLocationRow">
    	<td class="clsVideoUploadLabel"></td>
		<td class="clsAdminSubmitLeft clsBrowseUploadButton">
            {*$myobj->populateHidden(array('gpukey')*}
            {if !$myobj->chkIsEditMode()}
            	<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsBold" name="upload_video_file" id="upload_video_file" tabindex="{smartyTabIndex}"
            value="{$LANG.videoupload_upload_video_file}" /></div></div>
            {else}
            {*$myobj->populateHidden(array('video_server_url', 't_width', 't_height'))*}
			 	<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsVideoUploadButton" name="update" id="update" tabindex="{smartyTabIndex}" value="{$LANG.videoupload_update}" /></div></div>
			 	<div class="clsCancelMargin"><div class="clsCancelLeft"><div class="clsCancelRight"><input type="button" onClick="javascript:window.location='{php}echo (isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:getUrl('videolist','?pg=myvideos','myvideos/','','video'));{/php}'"class="clsVideoUploadButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.videoupload_cancel}" /></div></div></div>
            {/if}		</td>
    </tr>
    </table>
	</div>
	</form>
	{if !$myobj->chkIsEditMode()}
	<div id="selTimer">
	</div>
    {/if}
</div>
{/if}
{*<!--#############	UPLOAD FORM ENDS HERE   		  #############-->*}

{*<!--#############	NORMAL UPLOAD FORM STARTS  HERE   #############-->*}
{if $myobj->isShowPageBlock('video_upload_form_file')}
    <div id="selVideoUploadRules" class="clsVideoUploadRules">
      <p></p>
    </div>
	<div class="clsNoteInfoLeft">
		<div class="clsNoteInfoRight">
			<div class="clsNoteInfoCenter">
		 		<div class="clsUploadNotes">NOTES:</div><div class="clsUploadInfo">[{$CFG.admin.videos.max_size} MB]&nbsp;&nbsp;&nbsp;&nbsp;[{$myobj->imageFormat}]</div>
		 	</div>
		</div>	
	</div>
	{$myobj->setTemplateFolder('general/',video)}
	{include file='box.tpl' opt='otherupload_top'}
	<div class="clsUploadSection" id="selUploadFlash" style="display:{$myobj->selUploadFlash_display}">
	<form name="video_upload_form" id="video_upload_form" method="post" action="{$myobj->getCurrentUrl(false)}?upload={$myobj->session_variable}"
    autocomplete="off" enctype="multipart/form-data" onsubmit="return chkMandatoryFields();">
	<!--p>
    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
    codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="400" height="155" id="fileuploader"
    align="middle">
        <param name="allowScriptAccess" value="sameDomain" />
        <param name="movie" value="{$myobj->swf_path}?config={$myobj->config_path}" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#ffffff" />
        <embed src="{$myobj->swf_path}?config={$myobj->config_path}" quality="high" bgcolor="#ffffff" width="400" height="155" name="fileuploader"
        align="middle" allowDomain="always" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"
        pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent"/>
	</object>

	</p->
    <div>
        <div class="fieldset flash" id="fsUploadProgress1">
            <span class="legend">{*$LANG.multi_video_upload*}</span>
        </div>
        <div style="padding-left: 5px;">
            <span id="spanButtonPlaceholder1"></span>
            <input id="btnCancel1" type="button" value="{$LANG.videoupload_cancel}" onclick="cancelQueue(multi_upload);" disabled="disabled" style="margin-left: 2px; height: 22px; font-size: 8pt;" />
            <input type="hidden" name="flv_upload_type" value="MultiUpload" />
            <br />
        </div>
    </div><br />-->
    <div>
    <table class="clsBrowseFileTable"><tr>
        <td>{$LANG.videoupload_select_file}: <input type="text" id="txtFileName" disabled="true" class="clsTextBox" /></td>
        <td class="clsPlaceHolderButton"><p class="clsSubmitButton-l clsAdminUploadButton"><span class="clsSubmitButton-r"><span id="spanButtonPlaceholder1"></span></span></p></td>       
    </tr></table>
    </div>
    <div class="flash" id="fsUploadProgress">
        <!-- This is where the file progress gets shown.  SWFUpload doesn't update the UI directly.
                    The Handlers (in handlers.js) process the upload events and make the UI updates -->
    </div>


	<div class="clsOverflow clsBrowseUploadButton">
    	<div class="clsSubmitLeft">
        	<div class="clsSubmitRight">
			<input type="button" value="{$LANG.videoupload_upload_video}" id="btnSubmit" name="video_upload_flash" class="clsSubmitButton"/>
		    <!--<input class="clsVideoUploadButton" type="Button" Name="Upload" id="Upload" Value="{$LANG.videoupload_upload_video}" onClick="onClickThis()"/>-->
		    </div>
        </div><p class="clsPaddingTop5"><a href="javascript:void(0);" onclick="return showNormalUpload()">{$LANG.common_click_here}</a> {$LANG.videoupload_proble_uploader}</p>
   </div>
    <input type="hidden" name="file_extern" id="file_extern" />
    <input type="hidden" name="upload_video" id="upload_video" />
	</form>
	
	</div>
	<div id="selUploadNormal" class="clsUploadSection" style="display:{$myobj->selUploadNormal_display}">
	<form name="video_upload_form_normal" id="video_upload_form_normal" method="post" action="{$myobj->getCurrentUrl(false)}?upload={$myobj->session_variable}"
    autocomplete="off" enctype="multipart/form-data" onsubmit="return chkMandatoryFields();">
	<div class="clsDataTable">
    <table summary="{$LANG.videoupload_tbl_summary}" id="selUploadTbl" class="clsFormTableSection clsUploadBlock">
		<tr class="clsVideoUploadFile">
			<td class="{$myobj->getCSSFormLabelCellClass('video_file')}">
				<label for="video_file">{$LANG.videoupload_video_file}</label>&nbsp;{$LANG.videoupload_important}&nbsp;
				<input type="hidden" name="max_file_size" value="{$CFG.admin.videos.max_size*1024*1024}">
                {$myobj->ShowHelpTip('video_file')}
			</td>
		    <td class="{$myobj->getCSSFormFieldCellClass('video_file')}">
				<input type="file" class="clsFileBox" accept="video/{$myobj->changeArrayToCommaSeparator($CFG.admin.videos.format_arr)}" name="video_file" id="video_file" tabindex="{smartyTabIndex}" />
                        {$myobj->getFormFieldErrorTip('video_file')}
			</td>
		</tr>
		<tr>        	
			<td colspan="2" class="clsBrowseUploadButton">
				<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="upload_video_normal" id="upload_video_normal" tabindex="{smartyTabIndex}"
                value="{$LANG.videoupload_upload_video}" /></div></div>
				<p class="clsPaddingTop5"><a href="javascript:void(0);" onclick="return showFlashUpload()">{$LANG.common_click_here}</a> {$LANG.videoupload_show_flash_uploader}</p>
	        </td>
    	</tr>
	</table>
    </div>
	</form>    
	</div>
	{$myobj->setTemplateFolder('general/',video)}
	{include file='box.tpl' opt='otherupload_bottom'}
    {if !$myobj->chkIsEditMode()}
<script>
createJSFCommunicatorObject(thisMovie("fileuploader"));
</script>
{/if}
{/if}
{*<!--#############	NORMAL UPLOAD FORM ENDS  HERE     #############-->*}
{*<!--#############	EXTERNAL UPLOAD FORM START  HERE  #############-->*}
{if $myobj->isShowPageBlock('video_upload_form_external')}
<div class="clsUploadSection">
	<form name="video_upload_form" id="video_upload_form" method="post" action="{$myobj->getCurrentUrl(false)}?upload={$myobj->session_variable}"
    autocomplete="off" onsubmit="return chkMandatoryFields();">
	<div class="clsDataTable">
    <table summary="{$LANG.videoupload_tbl_summary}" id="selUploadTbl" class="clsFormTableSection clsUploadBlock">
	    <tr class="clsVideoUploadFile">
    	    <td class="{$myobj->getCSSFormLabelCellClass('externalsite_viewvideo_url')}">
	            <label for="video_external_url">{$LANG.videoupload_externalsite_viewvideo_url}</label>&nbsp;{$LANG.videoupload_important}&nbsp;
        	</td>
   			<td class="{$myobj->getCSSFormFieldCellClass('externalsite_viewvideo_url')}">
				<input type="text" class="clsTextBox" name="externalsite_viewvideo_url" id="externalsite_viewvideo_url" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('externalsite_viewvideo_url')}" />
                        {$myobj->getFormFieldErrorTip('externalsite_viewvideo_url')}
	                {$myobj->ShowHelpTip('externalsite_viewvideo_url')}
			</td>
	    </tr>
		<tr>
        	<td></td>
			<td class="clsBrowseUploadButton">
				<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsBold" name="upload_video" id="upload_video" tabindex="{smartyTabIndex}"
                value="{ $LANG.videoupload_externalvideourl}" /></div></div>
			</td>
		</tr>
	</table>
    </div>
	</form>
</div>
{/if}
{*<!--############# EXTERNAL UPLOAD FORM ENDS  HERE   #############-->*}

{*<!--############# VIDEO CAPTURE FORM STARTS HERE    #############-->*}
{if $myobj->isShowPageBlock('video_upload_form_capture')}
<div class="clsUploadSection">

	<form name="video_upload_form" id="video_upload_form" method="post" action="{$myobj->getCurrentUrl(false)}?upload={$myobj->session_variable}" autocomplete="off" >
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
    codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="460" height="390" id="QuickRecorder"
    align="middle">
        <param name="allowScriptAccess" value="sameDomain" />
        <param name="movie" value="{$myobj->quick_recorder_path}" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#ffffff" />
        <embed src="{$myobj->quick_recorder_path}" quality="high" bgcolor="#ffffff" width="460" height="390" name="QuickRecorder"
        align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
    </form>
</div>
{/if}
{*<!--############# VIDEO CAPTURE FORM ENDS HERE      #############-->*}

{*<!--############# VIDEO EMBEDED FORM STARTS HERE    #############-->*}
{if $myobj->isShowPageBlock('upload_video_embed_code_form')}
<div class="clsUploadSection">
	<form name="video_upload_form" id="video_upload_form"  method="post" action="{$myobj->getCurrentUrl(false)}?upload={ $myobj->session_variable}"
    autocomplete="off" enctype="multipart/form-data" onsubmit="return chkMandatoryFields();">
	<div class="clsDataTable">
    <table summary="{$LANG.videoupload_tbl_summary}" id="selUploadTbl" class="clsFormTableSection clsUploadBlock">
		<tr class="clsVideoUploadFile">
	    	<td class="{$myobj->getCSSFormLabelCellClass('video_external_embed_code')}">
				<label for="video_external_embed_code">{$LANG.videoupload_upload_external_embed_code}</label>&nbsp;{$LANG.videoupload_important}&nbsp;<br />
                {$myobj->embededcode_optimum_dimension}
			</td>
	   		<td class="{$myobj->getCSSFormFieldCellClass('video_external_embed_code')}">
	       		<textarea name="video_external_embed_code" id="video_external_embed_code" tabindex="{smartyTabIndex}" cols="50" rows="5">{$myobj->getFormField('video_external_embed_code')}</textarea>
                        {$myobj->getFormFieldErrorTip('video_external_embed_code')}
                        {$myobj->ShowHelpTip('video_external_embed_code')}
			</td>
	    </tr>
		<tr>
	    	<td class="{$myobj->getCSSFormLabelCellClass('embed_video_image')}">
	        	<label for="embed_video_image">{$LANG.videoupload_embed_video_image} &nbsp;{$LANG.videoupload_important}&nbsp;<br /> {$LANG.upload_image_type}({$myobj->imageFormat})</label>
            </td>
	        <td class="{$myobj->getCSSFormFieldCellClass('embed_video_image')}">
	        	<input type="file" class="clsFileBox" name="embed_video_image" id="embed_video_image" tabindex="{smartyTabIndex}" accept="{$myobj->imageFormat}"/>
                  {$myobj->getFormFieldErrorTip('embed_video_image')}
                  {$myobj->ShowHelpTip('embed_video_image')}
	        </td>
	    </tr>
        <tr>
	    	<td class="{$myobj->getCSSFormLabelCellClass('embed_playing_time')}">
	        	<label for="embed_playing_time">{$LANG.videoupload_embed_playingtime} &nbsp;{$LANG.videoupload_important}&nbsp;</label>
            </td>
	        <td class="{$myobj->getCSSFormFieldCellClass('embed_playing_time')}">
	        	<input type="text" class="clsFileBox" name="embed_playing_time" id="embed_playing_time" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('embed_playing_time')}"/>
                  {$myobj->getFormFieldErrorTip('embed_playing_time')}
                  {$myobj->ShowHelpTip('embed_playing_time', 'embed_playing_time')}
	        </td>
	    </tr>
		<tr>
        	<td></td>
			<td class="clsBrowseUploadButton">
				<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsVideoUploadButton clsBold" name="upload_video_embed_code" id="upload_video_embed_code" tabindex="{smartyTabIndex}"
                value="{$LANG.videoupload_upload_video}" /></div></div>
			</td>
		</tr>
	</table>
    </div>
	</form>
</div>
{/if}
{*<!--############# VIDEO EMBEDED FORM ENDS HERE      #############-->*}
{if $myobj->upload_video_type}
<div class="clsOtherUploadOptionsBg">
	<table class="clsAdminSwitchoverTable clsOtherUploadedVideos">
		<tr>
			<th>{$LANG.other_video_upload_options}</th>
		</tr>
		<tr>
			<td>
				<div class="clsSwitchOver clsOverflow clsMarginTop5 clsBrowseUploadButton">
					<form name="switch_over_form" id="switch_over_form" method="post" action="{$myobj->getCurrentUrl(false)}?upload={$myobj->session_variable}"
					autocomplete="off">
					{if $myobj->upload_video_type!='Normal'}
					<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton clsBold" name="upload_video_file" id="upload_video_file" tabindex="{smartyTabIndex}" value="{$LANG.videoupload_upload_video_file}" /></div></div>
					{/if}
					{if $myobj->upload_video_type!='externalsitevideourl' && $CFG.admin.upload_youtube_flv}
					<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton clsBold" name="upload_video_external" id="upload_video_external" tabindex="{smartyTabIndex}" value="{$LANG.videoupload_upload_external}" /></div></div>
					{/if}
					{if $CFG.admin.upload_capture_flv && $myobj->upload_video_type!='Capture'}
					<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton clsBold" name="upload_video_capture" id="upload_video_capture" tabindex="{smartyTabIndex}" value="{$LANG.videoupload_upload_capture}" /></div></div>
					{/if}
					{if $CFG.admin.upload_video_embed_code && $myobj->upload_video_type!='embedcode'}
					<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton clsBold" name="upload_video_embed_code" id="upload_video_embed_code" tabindex="{smartyTabIndex}" value="{$LANG.videoupload_upload_external_embed_code}" /></div></div>
					{/if}
					<div class="clsCancelLeft"><div class="clsCancelRight"><input type="button"  class="clsSubmitButton clsBold" onClick="javascript:window.location='{php} echo getUrl('videolist','?pg=myvideos','myvideos/','','video');{/php}'" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.videoupload_cancel}" /></div></div>
				
					<input type="hidden" name="switch_over" id="switch_over" value="switch_over" />
					</form>
				</div>
			</td>
		</tr>
	</table>
</div>	
{/if}

</div>
	</div>
{$myobj->setTemplateFolder('general/','video')}
{include file='box.tpl' opt='display_bottom'}
</div>
