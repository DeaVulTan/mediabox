<div id="selmusicList">
  	<h2><span>{$LANG.musicMassUploader_title}</span></h2>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			<table summary="">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_yes_option}" />&nbsp;
						<input type="submit" class="clsSubmitButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_no_option}" onClick="return hideAllUploadListBlocks();" />
						<input type="hidden" name="checkbox" id="checkbox" />
						<input type="hidden" name="action" id="action" />
						<input type="hidden" name="upload_file_ids" id="upload_file_ids" />
						<input type="hidden" name="music_categories" id="music_categories" />						
						{$myobj->populateHidden($myobj->hidden_arr)}
					</td>
				</tr>
			</table>
		</form>
	</div>
{$myobj->setTemplateFolder('admin')}
{include file='information.tpl'}
{if $myobj->isShowPageBlock('edit_path_block')}
	<div id="selShowSearchGroup">
		<form name="selEditFormSearch" id="selEditFormSearch" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">		
			<table class="clsNoBorder clsMusicTable" summary="{$LANG.musicMassUploader_tbl_summary}">
			{foreach key=scKey item=uploaderEditValue from=$showUploaderEditList_arr}
			<input type="hidden" name="edit_path" id="edit_path"  value="{$uploaderEditValue.record.music_mass_uploader_file_id}"/>	
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('edit_upload_title')}"><label for="edit_upload_title">{$LANG.musicMassUploader_upload_title_label}&nbsp;{$LANG.musicMassUploader_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('edit_upload_title')}">
				<p><input type="text" class="clsTextBox" name="edit_upload_title" id="edit_upload_title" value="{$uploaderEditValue.record.music_mass_upload_title}" tabindex="{smartyTabIndex}"/></p>
				<p>{$myobj->getFormFieldErrorTip('edit_upload_title')}</p>
				</td>
			</tr>
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('edit_added_by')}"><label for="name">{$LANG.musicMassUploader_added_by_title_label}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('edit_added_by')}">
				<p><input type="text" class="clsTextBox" name="edit_added_by" id="edit_added_by" value="{$uploaderEditValue.record.added_by}" tabindex="{smartyTabIndex}"/></p>
				<p>{$myobj->getFormFieldErrorTip('added_by')}</p>			
				</td>
			</tr>				
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('edit_csv_file_path')}"><label for="edit_csv_file_path">{$LANG.musicMassUploader_file_path_label}&nbsp;{$LANG.musicMassUploader_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('edit_csv_file_path')}">
				<p><input type="text" class="clsTextBox" name="edit_csv_file_path" id="edit_csv_file_path" value="{$uploaderEditValue.record.file_name}" tabindex="{smartyTabIndex}"/></p>
				<p>{$myobj->getFormFieldErrorTip('edit_csv_file_path')}</p>
				{$LANG.musicMassUploader_file_path}
				</td>
			</tr>
			<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('edit_form_upload_status')}"><label for="edit_form_upload_status">{$LANG.musicMassUploader_status_label}&nbsp;{$LANG.musicMassUploader_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('edit_form_upload_status')}">
				<p><select name="edit_form_upload_status" id="edit_form_upload_status" tabindex="{smartyTabIndex}">
                  <option value="">{$LANG.musicMassUploader_action_select}</option>
                  <option value="Active" {if  $uploaderEditValue.record.status == 'Active'} SELECTED {/if}>{$LANG.musicMassUploader_activate_lbl}</option>                  
				  <option value="Deactivated" {if $uploaderEditValue.record.status == 'Deactivated'} SELECTED {/if}>{$LANG.musicMassUploader_deactivate_lbl}</option>	
                </select>
				&nbsp;</p>
				<p>{$myobj->getFormFieldErrorTip('edit_form_upload_status')}</p>
				</td>				
			<tr>	
					
			<td class="{$myobj->getCSSFormFieldCellClass('musicMassUploader_submit_label')}" colspan="2">
			<input type="submit" class="clsSubmitButton" value="{$LANG.musicMassUploader_submit_label}" id="edit_upload_submit" name="edit_upload_submit" tabindex="{smartyTabIndex}" /></td>
			</tr>
			{/foreach}	
			</table>
			{*$myobj->populateHidden($myobj->form_search.hidden_arr)*}			
		</form>
	</div>
{/if}
{if $myobj->isShowPageBlock('form_search')}
	<div id="selShowSearchGroup">
		<form name="selFormSearch" id="selFormSearch" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
			<table class="clsNoBorder clsMusicTable" summary="{$LANG.musicMassUploader_tbl_summary}">
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('upload_title')}"><label for="upload_title">{$LANG.musicMassUploader_upload_title_label}&nbsp;{$LANG.musicMassUploader_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('upload_title')}">
				<p><input type="text" class="clsTextBox" name="upload_title" id="upload_title" value="{$myobj->getFormField('upload_title')}" tabindex="{smartyTabIndex}"/></p>
				<p>{$myobj->getFormFieldErrorTip('upload_title')}</p>
				</td>
			</tr>
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('added_by')}"><label for="name">{$LANG.musicMassUploader_added_by_title_label}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('added_by')}">
				<p><input type="text" class="clsTextBox" name="added_by" id="added_by" value="{$myobj->getFormField('added_by')}" tabindex="{smartyTabIndex}"/></p>
				<p>{$myobj->getFormFieldErrorTip('added_by')}</p>			
				</td>
			</tr>			
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('csv_file_path')}"><label for="csv_file_path">{$LANG.musicMassUploader_file_path_label}&nbsp;{$LANG.musicMassUploader_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('csv_file_path')}">
				<p><input type="text" class="clsTextBox" name="csv_file_path" id="csv_file_path" value="{$myobj->getFormField('csv_file_path')}" tabindex="{smartyTabIndex}"/></p>
				<p>{$myobj->getFormFieldErrorTip('csv_file_path')}</p>
				{$LANG.musicMassUploader_file_path}
				</td>
			</tr>
			<tr>
			<td class="{$myobj->getCSSFormLabelCellClass('form_upload_status')}"><label for="form_upload_status">{$LANG.musicMassUploader_status_label}&nbsp;{$LANG.musicMassUploader_important}&nbsp;</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('form_upload_status')}">
				<p><select name="form_upload_status" id="form_upload_status" tabindex="{smartyTabIndex}">
                  <option value="">{$LANG.musicMassUploader_action_select}</option>
                  <option value="Active" {if $myobj->getFormField('form_upload_status') == 'Active'} SELECTED {/if}>{$LANG.musicMassUploader_activate_lbl}</option>                  
				  <option value="Deactivated" {if $myobj->getFormField('form_upload_status') == 'Deactivated'} SELECTED {/if}>{$LANG.musicMassUploader_deactivate_lbl}</option>	
                </select>
				&nbsp;</p>
				<p>{$myobj->getFormFieldErrorTip('form_upload_status')}</p>
				</td>				
			<tr>
				<td class="{$myobj->getCSSFormFieldCellClass('musicMassUploader_submit_label')}" colspan="2">
				<input type="submit" class="clsSubmitButton" value="{$LANG.musicMassUploader_submit_label}" id="upload_submit" name="upload_submit" tabindex="{smartyTabIndex}" /></td>
			</tr>
			</table>
			{*$myobj->populateHidden($myobj->form_search.hidden_arr)*}			
		</form>
	</div>
{/if}
{if $myobj->isShowPageBlock('uploader_list_form')}
	<form name="selFormUploadList" id="selFormUploadList" method="post" action="{$myobj->getCurrentUrl()}">
    <div id="selShowCategories">
        {if $myobj->isResultsFound()}
		   {if $CFG.admin.navigation.top}
                {$myobj->setTemplateFolder('admin')}
                {include file='pagination.tpl'}
            {/if}                       
            <table summary="{$LANG.musicMassUploader_tbl_summary}">
                <tr>
				    <th>{$LANG.musicMassUploader_music_title_list}</th>                   
                    <th>{$LANG.musicMassUploader_total_songs_count}/{$LANG.musicMassUploader_total_songs_moved_list}</th>   
					<th>{$LANG.massUploadManage_file_path_label}</th>	                 
					<th>{$LANG.musicMassUploader_status_list}</th>					
                    <th>{$LANG.musicMassUploader_action_list}</th>   
                </tr>
			{foreach key=scKey item=uploaderValue from=$showUploaderList_arr}
                <tr>  
				                   
                    <td>{$uploaderValue.record.music_mass_upload_title}</td>                    
                    <td>{$uploaderValue.record.total_songs}/{$uploaderValue.record.total_songs_moved}</td> 
					<td>{$uploaderValue.record.file_name}</td> 
					<td>{$uploaderValue.record.status}</td> 
					<td><a href="musicMassUploadManage.php?uid={$uploaderValue.record.music_mass_uploader_file_id}">{$LANG.musicMassUploader_manage}</a>{if $uploaderValue.record.status=='Active' || $uploaderValue.record.status=='Deactivated'}&nbsp;/&nbsp;<a href="musicMassUploader.php?edit_path={$uploaderValue.record.music_mass_uploader_file_id}">{$LANG.musicMassUploader_edit}</a>{/if} </td> 
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
</div>
