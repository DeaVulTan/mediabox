{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_top"}
<div id="selMusicUpload" class="clsMusicUploadPage">
<div class="clsOverflow">
	<div class="clsFloatLeft">
        <h3 class="clsH3Heading">
            {if $myobj->chkIsEditMode()}
                {$LANG.musicupload_edit_title}
            {else}
                {$LANG.musicupload_title}
            {/if}
       </h3>
    </div>
	{if $myobj->isShowPageBlock('block_musicupload_step1')}
    	<div class="clsAudioListMenu clsFloatRight">
        <ul>
        	{if $CFG.admin.musics.upload_music_multiupload}
	            <li id="selHeaderMultiUpload"><a href="javascript:void(0);" title="{$LANG.musicupload_multi_upload_title}" onclick="loadUploadType('{$CFG.site.url}music/musicUploadPopUp.php?ajax_page=true&pg=multiupload', 'selMultiUploadContent', 'selHeaderMultiUpload');"><span>{$LANG.musicupload_multi_upload_title}</span></a></li>
            {/if}
        	{if $CFG.admin.musics.upload_music_normalupload}
	            <li id="selHeaderNormalUpload"><a href="javascript:void(0);" title="{$LANG.musicupload_normal_upload_title}" onclick="loadUploadType('{$CFG.site.url}music/musicUploadPopUp.php?ajax_page=true&pg=normal', 'selNormalUploadContent', 'selHeaderNormalUpload');"><span>{$LANG.musicupload_normal_upload_title}</span></a></li>
            {/if}
        	{if $CFG.admin.musics.upload_music_externalupload}
	            <li id="selHeaderExternalUpload"><a href="javascript:void(0);" title="{$LANG.musicupload_external_upload_title}" onclick="loadUploadType('{$CFG.site.url}music/musicUploadPopUp.php?ajax_page=true&pg=external', 'selExternalUploadContent', 'selHeaderExternalUpload');"><span>{$LANG.musicupload_external_upload_title}</span></a></li>
            {/if}
        	{if $CFG.admin.musics.upload_music_recordaudio}
	            <li id="selHeaderRecordAudio"><a href="javascript:void(0);" title="{$LANG.musicupload_record_audio_title}" onclick="loadUploadType('{$CFG.site.url}music/musicUploadPopUp.php?ajax_page=true&pg=record', 'selRecordAudioContent', 'selHeaderRecordAudio');"><span>{$LANG.musicupload_record_audio_title}</span></a></li>
            {/if}
        </ul>
    </div>
	{/if}

	</div>
	{$myobj->setTemplateFolder('general/','music')}
{include file='information.tpl'}
{if $myobj->isShowPageBlock('block_musicupload_step1')}
	<script type="text/javascript">
        var subMenuClassName1='clsActiveTabNavigation';
        var hoverElement1  = '.clsTabNavigation li';
        loadChangeClass(hoverElement1,subMenuClassName1);
    </script>

	<div id="selMultiUploadContent" style="display:none">
    	{if $myobj->show_div == 'selMultiUploadContent'}
            {$myobj->setTemplateFolder('general/', 'music')}
            {include file='multiUpload.tpl'}
      {/if}
	</div>
    <div id="selNormalUploadContent" style="display:none">
    	{if $myobj->show_div == 'selNormalUploadContent'}
            {$myobj->setTemplateFolder('general/', 'music')}
            {include file='normalUpload.tpl'}
      {/if}
    </div>
    <div id="selExternalUploadContent" style="display:none">
    	{if $myobj->show_div == 'selExternalUploadContent'}
            {$myobj->setTemplateFolder('general/', 'music')}
            {include file='externalUpload.tpl'}
      {/if}
    </div>
	<div id="selRecordAudioContent" style="display:none">
    	{if $myobj->show_div == 'selRecordAudioContent'}
            {$myobj->setTemplateFolder('general/', 'music')}
            {include file='recordAudio.tpl'}
      {/if}
    </div>
{/if}

{if $myobj->isShowPageBlock('block_musicupload_step2')}
    {*CONFIRMATION BOX FOR SKIPING STEP 2*}
      <div id="selMsgConfirm"   class="clsPopupConfirmation" style="display:none;">
        <p id="msgConfirmText"></p>
        <form name="selFormCreateAlbum" id="selFormCreateAlbum"></form>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getUrl('musiclist', '?pg=mymusics', 'mymusics/', 'members', 'music')}" autocomplete="off">
            {*<input type="submit" class="clsSubmitButton" name="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
            <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />*}
        </form>
      </div>
	  <div class="clsOverflow">
	<div class="clsStepsBg2 clsFloatLeft"><p><span>{$LANG.musicupload_step1}: <strong>{$LANG.musicupload_music_file}</strong></span></p></div>
	<div class="clsStepsBg1 clsFloatLeft"><p><span>{$LANG.musicupload_step}: <strong>{$LANG.musicupload_step_info}</strong></span></p></div>
</div>
<div class="clsUploadHeading"><span>{$LANG.musicupload_basic_info}</span></div>
<div class="clsNoteContainer">
		<div class="clsNoteContainerLeft">
			<div class="clsNoteContainerRight clsOverflow">
				<div class="clsFloatLeft">
					<p class="clsNote">{$LANG.common_music_note}:</p>
				</div>
				<div class="clsFloatLeft clsMusicUploadnoteMusic">
					<p><span class="clsBold">{$LANG.musicupload_music_image}</span>: [{$LANG.musicupload_max_file_size}:&nbsp;{$CFG.admin.musics.image_max_size}&nbsp;{$LANG.common_kilobyte}]&nbsp;[{$LANG.musicupload_allowed_formats}:&nbsp;{$myobj->music_image_format}]</p>
        <p><span class="clsBold">
        	{if $CFG.admin.musics.music_artist_feature}
	        	{$LANG.musicupload_music_cast}
	        {else}
				{$LANG.musicupload_music_artist}
			{/if}
		</span>:&nbsp;{$myobj->musicupload_artist_note_msg}</p>
			</div>
				<div class="clsFloatLeft">
					 <p class="clsCheckboxNote"><span>{$LANG.musicupload_music_album}</span>:&nbsp;
					{if $CFG.admin.musics.allowed_usertypes_to_upload_for_sale != 'None'}
						{$LANG.musicupload_album_price_note_msg}
					{/if}
					{$LANG.musicupload_album_note_msg}</p>
			</div>
			</div>
		</div>
	</div>
    <div id="selUpload">
    <div class="clsMusicDetailHdMain clsOverflow">

    {if $myobj->isShowPageBlock('block_musicupload_step2')}
	
    {/if}

    {if !$myobj->chkIsEditMode()}
     {*   <div class="clsSkipBtn">
            <input type="button" name="skip" id="skip" tabindex="{smartyTabIndex}" value="{$LANG.musicupload_skip_step2}" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('msgConfirmText'), Array('{$LANG.musicupload_skip_message}'), Array('innerHTML'), 100, 150, 'anchor_upload');" />
        </div> *}
    {/if}

    </div>
        <form name="music_upload_form" id="music_upload_form" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off" enctype="multipart/form-data">
          <a id="anchor_upload"></a>

    <div id="selUploadBlock">


        {assign var="i" value="0"}
             {section name=audioDetails loop=$myobj->getFormField('total_musics')}
                {assign var=id_field_name value=music_id_$i}
                {assign var=title_field_name value=music_title_$i}
                {assign var=album_field_name value=music_album_$i}
                {assign var=album_id_field_name value=music_album_id_$i}
                {assign var=album_sale_field_name value=album_for_sale_$i}
                {assign var=album_price_field_name value=music_album_price_$i}
                {assign var=artist_field_name value=music_artist_$i}
                {assign var=caption_field_name value=music_caption_$i}
                {assign var=thumb_field_name value=music_thumb_ext_$i}
                {assign var=thumb_folder value=music_thumb_folder_$i}
                {assign var=thumb_image_field_name value=music_thumb_image_$i}
                {assign var=year_field_name value=music_year_released_$i}
                {assign var=music_status value=music_status_$i}
                {assign var=for_sale_field_name value=for_sale_$i}
                {assign var=music_price_field_name value=music_price_$i}
                {assign var=preview_start_field_name value=preview_start_$i}
                {assign var=preview_end_field_name value=preview_end_$i}
                {assign var=album_access_type_field_name value=album_access_type_$i}
                {if $myobj->getFormField($thumb_field_name) != ''}
	                {assign var=image_container_div_show value=''}
	                {assign var=image_upload_div_show value=' style="display:none"'}
                {else}
	                {assign var=image_container_div_show value=' style="display:none"'}
	                {assign var=image_upload_div_show value=''}
                {/if}
        <table summary="{$LANG.musicupload_tbl_summary}" id="selUploadTbl" class="clsStepsTable clsMultiUploadTb" style="margin-bottom:2px;">
        	{if $myobj->getFormField('total_musics')>1}
			<tr><th colspan="5">{$LANG.musicupload_music} {$i+1}</th></tr>
			{/if}
            <tr>
                <th>
            	  {$LANG.musicupload_music_image}
                </th>
                <th>
                    {$LANG.musicupload_music_title}&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.common_music_mandatory}</span>
                </th>
                <th>
                    {$LANG.musicupload_music_album}
                    {if $CFG.admin.musics.music_upload_album_name_compulsory}&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.common_music_mandatory}</span>{/if}
                </th>
               <th>
                    {$LANG.musicupload_music_artist}
                    {if $CFG.admin.musics.music_upload_artist_name_compulsory}&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.common_music_mandatory}</span>{/if}
                </th>
                <th>
                    {$LANG.musicupload_year_released}
                    {if $CFG.admin.musics.music_upload_release_year_compulsory}&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.common_music_mandatory}</span>{/if}
                </th>
				 <th>
				 	{$LANG.musicupload_music_description}
                </th>
            </tr>

                <tr>
			<td class="clsUploadAudioImage">
                    	<div id="image_container_{$i}"{$image_container_div_show}>
                        	{if $myobj->getFormField($thumb_field_name) != ''}
		                        <span>
                                    <img src="{$myobj->getFormField($thumb_folder)}{$myobj->getMusicImageName($myobj->getFormField($id_field_name))}M.{$myobj->getFormField($thumb_field_name)}" />
                                    <input type="hidden" name="music_thumb_ext_{$i}" id="music_thumb_ext_{$i}" tabindex="{smartyTabIndex}" value="{$myobj->getFormField($thumb_field_name)}" />
                                    <input type="hidden" name="music_thumb_folder_{$i}" id="music_thumb_folder_{$i}" tabindex="{smartyTabIndex}" value="{$myobj->getFormField($thumb_folder)}" />
                                </span>
                              {/if}
                        </div>
                        <div id="image_upload_{$i}"{$image_upload_div_show}>
                        	<input type="file" class="clsFile" name="music_thumb_image_{$i}" id="music_thumb_image_{$i}" tabindex="{smartyTabIndex}" size="5" />
                              {$myobj->getFormFieldErrorTip($thumb_image_field_name)}
                        </div>
                        {if $myobj->getFormField($thumb_field_name) != ''}
	                        <a href="javascript:void(0)" onclick="toggleUploadImage({$i});" id="change_image_anchor_{$i}" title="{$LANG.musicupload_change_image}">{$LANG.musicupload_change_image}</a>
                        {/if}
                    </td>
                    <td>
                        <span>
	                        <input type="text" class="clsTextField clsTitleField" name="music_title_{$i}" id="music_title_{$i}" tabindex="{smartyTabIndex}" value="{$myobj->getFormField($title_field_name)}" maxlength="{$CFG.admin.musics.title_max_length}" /><input type="hidden" name="music_status_{$i}" id="music_status_{$i}" tabindex="{smartyTabIndex}" value="{$myobj->getFormField($music_status)}" />
                              {$myobj->getFormFieldErrorTip($title_field_name)}
	                    </span>
                    </td>
                    <td class="clsUploadAlumMusic">
					<div class="clsUploadAlumMusicDiv">
							{if isset($CFG.admin.musics.allow_members_to_set_price_for_album) and $CFG.admin.musics.allow_members_to_set_price_for_album}
                        	<input type="checkbox" class="clsCheckRadio clsAlbumCheckBox clsPhotoVideoEditLinks" name="album_access_type_{$i}" id="album_access_type_{$i}" value="Private" title="{$LANG.musicupload_album_checkbox_msg}" onclick="checkIsPublic({$i});" tabindex="{smartyTabIndex}"
                        	{if $myobj->getFormField($album_access_type_field_name)=='Private'} checked {/if} />

                        	<span id="selAlbumName_{$i}" style="display:{if $myobj->getFormField($album_access_type_field_name)=='Private'} none {else} block {/if}" class="clsAlbumNameEdit">
                            {/if}
							<input type="text" class="clsTextField clsTitleField" name="music_album_{$i}" id="music_album_{$i}" tabindex="{smartyTabIndex}" value="{$myobj->getFormField($album_field_name)}" maxlength="{$CFG.admin.musics.album_max_length}" />
							{if isset($CFG.admin.musics.allow_members_to_set_price_for_album) and $CFG.admin.musics.allow_members_to_set_price_for_album}
							</span>
							{/if}
	                        {$myobj->getFormFieldErrorTip($album_field_name)}
						{if isset($CFG.admin.musics.allow_members_to_set_price_for_album) and $CFG.admin.musics.allow_members_to_set_price_for_album}
                        <span id="selAlbumId_{$i}" style="display:{if $myobj->getFormField($album_access_type_field_name)=='Private'} block {else} none {/if}" class="clsAlbumNameEdit">
						<select name="music_album_id_{$i}" id="music_album_id_{$i}"  tabindex="{smartyTabIndex}" onchange="getAlbumPrice(this.value, 'music_price_{$i}', 'for_sale_{$i}')" class="clsSelectLarge">
                          <option value="">{$LANG.common_select_option}</option>
                          {$myobj->populateMusicAlbum('Private',$CFG.user.user_id, $myobj->getFormField($album_id_field_name))}
                          </select>
						  {$myobj->getFormFieldErrorTip($album_id_field_name)}
						  <input type="hidden" id="album_for_sale_{$i}" name="album_for_sale_{$i}" value="{$myobj->getFormField($album_sale_field_name)}">
						  <p id="selAlbumNew_{$i}">
						  <a href="#" onClick="return callAjaxAlbum('{$myobj->getUrl('createalbum','','','members','music')}','selMsgConfirm','music_album_id_{$i}', '{$myobj->getFormField('total_musics')}')" title="{$LANG.musicupload_new_album}">{$LANG.musicupload_new_album}</a></p>
						</span>
                        {/if}
					</div>
                    </td>
                    <td>
                        <span>
      	                  <input type="text" class="clsTextField clsTitleField" name="music_artist_{$i}" id="music_artist_{$i}" tabindex="{smartyTabIndex}" value="{$myobj->getFormField($artist_field_name)}" maxlength="{$CFG.admin.musics.artist_max_length}" />
                              {$myobj->getFormFieldErrorTip($artist_field_name)}
	                        <input type="hidden" name="music_old_artist_{$i}" id="music_old_artist_{$i}" tabindex="{smartyTabIndex}" value="{$myobj->getFormField($artist_field_name)}" />
                    </span>
                    </td>
                    <td>
                        <span>
	                        <input type="text" class="clsTextField clsYearField" name="music_year_released_{$i}" id="music_year_released_{$i}" tabindex="{smartyTabIndex}" value="{$myobj->getFormField($year_field_name)}" maxlength="4" />
                              {$myobj->getFormFieldErrorTip($year_field_name)}
                        </span>
                    </td>
					<td class="{$myobj->getCSSFormFieldCellClass('music_caption')}">

                    <textarea name="music_caption_{$i}" id="music_caption_{$i}" tabindex="{smartyTabIndex}" cols="50">{$myobj->getFormField($caption_field_name)}</textarea>
                    {$myobj->getFormFieldErrorTip('music_caption')}
                </td>
                </tr>
                
            {if $myobj->chkIsAllowedForSale()}
            <tr id="selMusicPriceDetails_{$i}">
                <td class="{$myobj->getCSSFormLabelCellClass('music_caption')} clsAudioUploadLabel">
                    <label for="music_caption">{$LANG.musicupload_price_info}</label> <span class="clsMandatoryFieldIcon">{$LANG.common_music_mandatory}</span>
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('for_sale')} clsUploadDetailField">
                		<p>{$LANG.musicupload_for_sale}</p>
                        <input type="radio" class="clsCheckRadio" name="for_sale_{$i}" id="for_sale_{$i}_1" value="Yes" onClick="enabledFormFields(Array('music_price_{$i}','preview_start_{$i}', 'preview_end_{$i}'))" tabindex="{smartyTabIndex}"
                        {$myobj->isCheckedRadio($for_sale_field_name,'Yes')} />&nbsp;<label for="for_sale1">{$LANG.musicupload_yes}
                        </label>
                        <input type="radio" class="clsCheckRadio" name="for_sale_{$i}" id="for_sale_{$i}_2" value="No" onClick="disabledFormFields(Array('music_price_{$i}','preview_start_{$i}', 'preview_end_{$i}'))" tabindex="{smartyTabIndex}"
                        {$myobj->isCheckedRadio($for_sale_field_name,'No')} />&nbsp;<label for="for_sale2">{$LANG.musicupload_no}
                        </label>
                </td>
               {if isset($CFG.admin.musics.allow_members_to_choose_the_preview) and $CFG.admin.musics.allow_members_to_choose_the_preview}
                <td class="clsUploadDetailField">
                        <span>
                        <p>{$LANG.musicupload_preview_start}</p>
	                        <input type="text" class="clsTextField clsTitleField" name="preview_start_{$i}" id="preview_start_{$i}" tabindex="{smartyTabIndex}" value="{$myobj->getFormField($preview_start_field_name)}" maxlength="4" />
                              {$myobj->getFormFieldErrorTip($preview_start_field_name)}
                        </span>
                </td>
                <td class="clsUploadDetailField">
                        <span>
                        <p>{$LANG.musicupload_preview_end}</p>
	                        <input type="text" class="clsTextField clsTitleField" name="preview_end_{$i}" id="preview_end_{$i}" tabindex="{smartyTabIndex}" value="{$myobj->getFormField($preview_end_field_name)}" maxlength="4" />
                              {$myobj->getFormFieldErrorTip($preview_end_field_name)}
                        </span>
                </td>
                {/if}
                <td class="clsUploadDetailField" {if isset($CFG.admin.musics.allow_members_to_choose_the_preview) and !$CFG.admin.musics.allow_members_to_choose_the_preview} colspan="3" {/if}>
                        <span >
                        	<p id="selPriceDetails">{$LANG.musicupload_music_price}&nbsp;({$CFG.currency})</p>
	                        <input type="text" class="clsTextField clsYearField" name="music_price_{$i}" id="music_price_{$i}" tabindex="{smartyTabIndex}" value="{$myobj->getFormField($music_price_field_name)}" maxlength="4" />
                              {$myobj->getFormFieldErrorTip($music_price_field_name)}
                        </span>
                </td>

            </tr>
            {/if}

         </table>
                {if $myobj->getFormField($for_sale_field_name)=='No'}
                {literal}
                <script type="text/javascript">
				disabledFormFields(Array('music_price_{/literal}{$i}{literal}'));
				</script>
                {/literal}
                {/if}
				{if $myobj->getFormField($for_sale_field_name)=='No' and ($myobj->getFormField($album_id_field_name) and $myobj->getFormField($album_sale_field_name)=='No')}
				{literal}
                <script type="text/javascript">
				disabledFormFields(Array('preview_start_{/literal}{$i}{literal}', 'preview_end_{/literal}{$i}{literal}'));
				</script>
                {/literal}
                {/if}
                {if $myobj->getFormField($album_id_field_name) and $myobj->getFormField($album_access_type_field_name)=='Private'}
                {literal}
                    <script type="text/javascript">
					getAlbumPrice({/literal}{$myobj->getFormField($album_id_field_name)}{literal}, 'music_price_{/literal}{$i}{literal}', 'for_sale_{/literal}{$i}{literal}')
					</script>
				{/literal}
                {/if}

         {assign var=i value=$i+1}
          {/section}
         {literal}
         <script type="text/javascript">
		{/literal}
		{assign var="i" value="0"}
		{assign var="del" value=","}
		{section name=audioDetails loop=$myobj->getFormField('total_musics')}

		{assign var=i value=$i+1}
		{/section}
		{literal}
		//var uploaded_image = '{/literal}{$myobj->getFormField($thumb_field_name)}{literal}';
		//alert(uploaded_image);
		function toggleUploadImage(song_no)
			{
				if($Jq('#image_upload_'+song_no).css('display') == 'none')
					{
						$Jq('#image_upload_'+song_no).show();
						$Jq('#image_container_'+song_no).hide();
						if($Jq('#change_image_anchor_'+song_no))
							$Jq('#change_image_anchor_'+song_no).html(lang_keep_old_image);
					}
				else
					{
						$Jq('#image_container_'+song_no).show();
						$Jq('#image_upload_'+song_no).hide();
						if($Jq('#change_image_anchor_'+song_no))
							$Jq('#change_image_anchor_'+song_no).html(lang_change_image);
					}
			}
		 </script>
         {/literal}
	<div class="clsUploadHeading"><span>Other Info</span></div>
         {* COMMON FIELDS STARTS HERE *}
         <div class="">
         <table class="clsOtherinfotable">
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
                    <label for="music_category_id_general">{$LANG.musicupload_music_category}</label>&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.common_music_mandatory}</span>&nbsp;
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('music_category_id')}">
                <div id="selGeneralCategory" style="display:{$myobj->General}">
                    <select name="music_category_id_general" id="music_category_id_general" {if $CFG.admin.musics.sub_category} onChange="populateMusicSubCategory(this.value)" {/if} tabindex="{smartyTabIndex}" class="clsSelectLarge validate-selection">
                      <option value="">{$LANG.common_select_option}</option>
                      {$myobj->populateMusicCatagory('General')}
                    </select>
                    {$myobj->getFormFieldErrorTip('music_category_id')}
                    {$myobj->getFormFieldErrorTip('music_category_id_general')}
                    {$myobj->ShowHelpTip('musicupload_category_id_general')}
                    <p class="clsSelectNote clsUploadnotesmall">{$LANG.musicupload_select_category}</p>
                </div>
                {if $myobj->content_filter and isAdultUser('', 'music')}
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
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('music_tags')}">
                    <label for="music_tags">{$LANG.musicupload_music_tags}</label>&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.common_music_mandatory}</span>&nbsp;
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('music_tags')}">
                    <input type="text" class="clsTextBox" name="music_tags" id="music_tags" value="{$myobj->getFormField('music_tags')}" tabindex="{smartyTabIndex}" />
                    {$myobj->getFormFieldErrorTip('music_tags')}
                    {$myobj->ShowHelpTip('music_tags')}
                    <p class="clsMusictagnote clsUploadnotesmall">{$myobj->musicUpload_tags_msg}</p>
                </td>
            </tr>
        </table>
		 </div>
        {* OTHER UPLOAD OPTIONS STARTS HERE *}
		<div class="clsUploadHeading">
        <div id="musicsThumsDetailsLinks" class="clsShowHideFilter">
            <a href="javascript:void(0)" id="show_link" class="clsShowFilterSearch" onclick="divShowHide('otherUploadOption', 'show_link', 'hide_link')" title="{$LANG.musicupload_show_other_option}"><span>{$LANG.musicupload_show_other_option}</span></a>
            <a href="javascript:void(0)" id="hide_link" style="display:none;" class="clsHideFilterSearch"  onclick="divShowHide('otherUploadOption', 'show_link', 'hide_link')"><span>{$LANG.musicupload_hide_other_option}</span></a>
        </div>
		</div>
        <div id="otherUploadOption" style="display:none" class="clsDataTable">
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
                <tr>
                    <th>{$LANG.common_sharing}</th>
                    <th>&nbsp;</th>
                </tr>
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
                        <p class="clsSelectHighlightNote">{$LANG.musicupload_only_viewable_you_email}:</p>
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
                    <p id="selDisableNote">{$LANG.musicupload_disallow_ratings_note}</p>
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
                    <p id="selLyricsNote">{$LANG.musicupload_lyrics_note}</p>
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
        </form>
    </div>


{/if}
{*<!--#############	UPLOAD FORM ENDS HERE   		  #############-->*}

</div>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_bottom"}
