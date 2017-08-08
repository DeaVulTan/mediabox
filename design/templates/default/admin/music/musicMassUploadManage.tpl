<div id="selmusicList">
<h2><span>{$LANG.massUploadManage_title}</span></h2>
{$myobj->setTemplateFolder('admin')}
{include file='information.tpl'}
{if $myobj->isShowPageBlock('mass_upload_edit_list')}
    {if $populateUpload_arr.rs_PO_RecordCount}
    	<form name="selFormSubCategory" id="selFormSubCategory" method="post" action="{$myobj->getCurrentUrl(true)}">
        <table>
		{foreach item=pscValue from=$populateUpload_arr.row}
		{if $myobj->isShowPageBlock('view_error_block')}		
			<tr>
			    <td class="{$myobj->getCSSFormLabelCellClass('error')}"><label for="error">{$LANG.massUploadManage_view_error_label}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('error')}">{$pscValue.record.error_log}</td>							
			</tr>		
			{/if}	
		    <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('music_title_mng')}"><label for="music_title_mng">{$LANG.massUploadManage_music_title_label}&nbsp;{$LANG.massUploadManage_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('music_title_mng')}">
				<p><input type="text" class="clsTextBox" name="music_title_mng" id="music_title_mng" value="{$pscValue.record.music_title}" tabindex="{smartyTabIndex}"/></p>
				<p>{$myobj->getFormFieldErrorTip('music_title_mng')}</p>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('album_name_mng')}"><label for="album_name_mng">{$LANG.massUploadManage_album_name_label}&nbsp;{$LANG.massUploadManage_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('album_name_mng')}">
				<p><input type="text" class="clsTextBox" name="album_name_mng" id="album_name_mng" value="{$pscValue.record.album_name}" tabindex="{smartyTabIndex}"/></p>
				<p>{$myobj->getFormFieldErrorTip('album_name_mng')}</p>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('artist_names_mng')}"><label for="artist_names_mng">{$LANG.massUploadManage_artist_names_label}&nbsp;{$LANG.massUploadManage_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('artist_names_mng')}">
				<p><input type="text" class="clsTextBox" name="artist_names_mng" id="artist_names_mng" value="{$pscValue.record.artist_names}" tabindex="{smartyTabIndex}"/></p>
				<p>{$myobj->getFormFieldErrorTip('artist_names_mng')}</p>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('music_year_released_mng')}"><label for="music_year_released_mng">{$LANG.massUploadManage_music_year_released_label}&nbsp;{$LANG.massUploadManage_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('music_year_released_mng')}">
				<p><input type="text" class="clsTextBox" name="music_year_released_mng" id="music_year_released_mng" value="{$pscValue.record.music_year_released}" tabindex="{smartyTabIndex}"/></p>
				<p>{$myobj->getFormFieldErrorTip('music_year_released_mng')}</p>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('music_tags_mng')}"><label for="music_tags_mng">{$LANG.massUploadManage_music_tags_label}&nbsp;{$LANG.massUploadManage_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('music_tags_mng')}">
				<p><input type="text" class="clsTextBox" name="music_tags_mng" id="music_tags_mng" value="{$pscValue.record.music_tags}" tabindex="{smartyTabIndex}"/></p>
				<p>{$myobj->getFormFieldErrorTip('music_tags_mng')}</p>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('music_language')}"><label for="music_language">{$LANG.massUploadManage_Language_label}&nbsp;{$LANG.massUploadManage_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('music_language')}">
				<select name="music_language" id="music_language">
	                    <option value="">{$LANG.massUploadManage_Language_label}</option>
                        {$myobj->generalPopulateArray($myobj->LANG_LANGUAGE_ARR, $myobj->getFormField('music_language'))}
                </select>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('music_category_id')}"><label for="music_category_id">{$LANG.massUploadManage_category_label}&nbsp;{$LANG.massUploadManage_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('music_category_id')}">
				  <div id="selGeneralCategory" style="display:{$myobj->General}">				
				<select name="music_category_id" id="music_category_id" onChange="populateMusicSubCategory(this.value)" tabindex="{smartyTabIndex}" class="clsSelectLarge validate-selection">
                      <option value="">{$LANG.common_select_option}</option>
                      {$myobj->populateMusicCatagory('General')}
                    </select>				
                    {$myobj->getFormFieldErrorTip('music_category_id')} 
					</div>                            
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('music_sub_category_id')}"><label for="music_sub_category_id">{$LANG.massUploadManage_subcategory_label}&nbsp;{$LANG.massUploadManage_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('music_sub_category_id')}">
				 <div id="selSubCategoryBox">
				<select name="music_sub_category_id" id="music_sub_category_id" tabindex="{smartyTabIndex}">
                        <option value="">{$LANG.common_select_option}</option>
                    </select>
					</div>	
                    {$myobj->getFormFieldErrorTip('music_sub_category_id')}                             
				</td>
			</tr>			 
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('music_path_mng')}"><label for="music_path_mng">{$LANG.massUploadManage_music_path_label}&nbsp;{$LANG.massUploadManage_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('music_path_mng')}">
				<p><input type="text" class="clsTextBox" name="music_path_mng" id="music_path_mng" value="{$pscValue.record.music_file_path}" tabindex="{smartyTabIndex}" readonly="true"/></p>
				<p>{$myobj->getFormFieldErrorTip('music_tags_mng')}</p>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('music_image_path_mng')}"><label for="music_image_path_mng">{$LANG.massUploadManage_image_path_label}&nbsp;{$LANG.massUploadManage_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('music_image_path_mng')}">
				<p><input type="text" class="clsTextBox" name="music_image_path_mng" id="music_image_path_mng" value="{$pscValue.record.image_path}" tabindex="{smartyTabIndex}" readonly="true"/></p>
				<p>{$myobj->getFormFieldErrorTip('music_tags_mng')}</p>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('field_1')}"><label for="field_1">{$LANG.massUploadManage_field_1_label}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('field_1')}">
				<p><input type="text" class="clsTextBox" name="field_1" id="field_1" value="{$pscValue.record.field_1}" tabindex="{smartyTabIndex}"/></p>
				<p>{$myobj->getFormFieldErrorTip('music_tags_mng')}</p>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('field_2')}"><label for="field_2">{$LANG.massUploadManage_field_2_label}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('field_2')}">
				<p><input type="text" class="clsTextBox" name="field_2" id="field_2" value="{$pscValue.record.field_2}" tabindex="{smartyTabIndex}"/></p>
				<p>{$myobj->getFormFieldErrorTip('music_tags_mng')}</p>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('field_3')}"><label for="field_3">{$LANG.massUploadManage_field_3_label}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('field_3')}">
				<p><input type="text" class="clsTextBox" name="field_3" id="field_3" value="{$pscValue.record.field_3}" tabindex="{smartyTabIndex}"/></p>
				<p>{$myobj->getFormFieldErrorTip('music_tags_mng')}</p>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('field_4')}"><label for="field_4">{$LANG.massUploadManage_field_4_label}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('field_4')}">
				<p><input type="text" class="clsTextBox" name="field_4" id="field_4" value="{$pscValue.record.field_4}" tabindex="{smartyTabIndex}"/></p>
				<p>{$myobj->getFormFieldErrorTip('music_tags_mng')}</p>
				</td>
			</tr>
		{/foreach}	
		{if !$myobj->getFormField('view_error')}	
            <tr>
                <td colspan="5">
                    <a href="#" id="dAltMltiSub" name="dAltMltiSub"></a>
                    <input type="submit" class="clsSubmitButton" value="{$LANG.massUploadManage_submit}" id="edit_submit" name="edit_submit" />
					<a href="musicMassUploadManage.php?uid={$myobj->getFormField('uid')}" id="dAltMltiSub" name="">{$LANG.massUploadManage_back}</a>
                </td>
            </tr>
		{/if}	
						
        </table>
        </form>
    {else}
        <div id="selMsgAlert">
            <p>{$LANG.managemusiccategory_no_sub_category}</td>
        </div>       
    {/if}

{/if}
{if $myobj->isShowPageBlock('mass_upload_manage_frm')}
	<form name="selFormUploadList" id="selFormUploadList" method="post" action="{$myobj->getCurrentUrl()}">
    <div id="selShowCategories">
        {if $myobj->isResultsFound()}
		   {if $CFG.admin.navigation.top}
                {$myobj->setTemplateFolder('admin')}
                {include file='pagination.tpl'}
            {/if}                       
            <table summary="{$LANG.massUploadManage_title}">			
                <tr>
                    <th>{$LANG.massUploadManage_music_title_label}</th>										 
					<th>{$LANG.massUploadManage_music_id}</th>									
					<th>{$LANG.massUploadManage_status_label}</th>	
					<th>&nbsp;</th>    
                </tr>
			{foreach key=scKey item=uploadManageValue from=$showUploaderList_arr}               
				<tr>                   
					<td>{$uploadManageValue.record.music_title}</td>
					<td>{if $uploadManageValue.record.music_id!='0'}<a href="{$CFG.site.url}music/listenMusic.php?music_id={$uploadManageValue.record.music_id}&music_title={$uploadManageValue.record.music_title}">{$uploadManageValue.record.music_id}</a>{/if}</td>
					<td>{$uploadManageValue.record.status}</td>										
					<td>{if $uploadManageValue.record.music_id=='0' && $uploadManageValue.record.error_log ==''}<a href="musicMassUploadManage.php?music_title_id={$uploadManageValue.record.music_mass_uploader_record_id}&amp;start={$myobj->getFormField('start')}&uid={$uploadManageValue.record.music_mass_uploader_file_id}">{$LANG.massUploadManage_edit}</a>&nbsp;{/if}{if $uploadManageValue.record.error_log!=''} &nbsp;<a href="musicMassUploadManage.php?music_title_id={$uploadManageValue.record.music_mass_uploader_record_id}&amp;start={$myobj->getFormField('start')}&uid={$uploadManageValue.record.music_mass_uploader_file_id}&view_error=1">{$LANG.massUploadManage_view_error}</a>{/if}</td> 
                </tr>
            {/foreach}					
			</table>            
            {if $CFG.admin.navigation.bottom}
           	    {$myobj->setTemplateFolder('admin')}
                {include file='pagination.tpl'}
            {/if}
        {else}
            <div id="selMsgAlert">
                <p>{$LANG.musicMassUploader_no_uploaded_music}</td>
            </div>
        {/if}
    </div>
	<input type="hidden" name="start" value="{$myobj->getFormField('start')}" />
	</form>    
{/if}
</div>
{if !$myobj->getFormField('music_title_id')}
 <a href="musicMassUploader.php" id="dAltMltiSub" name="dAltMltiSub">{$LANG.massUploadManage_back_label}</a>
{/if}
</div>
