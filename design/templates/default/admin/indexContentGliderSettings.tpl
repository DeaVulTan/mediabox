{if $myobj->isShowPageBlock('block_form_list_glider_content')}
	<div id="selMsgConfirmWindow" class="clsMsgConfirmWindow" style="display:none;">
		<h3 id="confirmationMsg"></h3>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
	    	<!-- clsFormSection - starts here -->
	      	<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
	      	&nbsp;
	      	<input type="button" class="clsSubmitButton clsCancelButton" name="cancel" id="cancel" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks('selListFeaturedContentForm');" />
	      	{$myobj->populateHidden($myobj->deleteForm_hidden_arr)}
			<!-- clsFormSection - ends here -->
		</form>
	</div>
{/if}

<div id="selFeaturedContent">
	<h2><span>{$LANG.index_glidersetting_title}</span></h2>

    {$myobj->setTemplateFolder('admin')}
	{include file='information.tpl'}
     <h3>{$LANG.index_glidersetting_heading_note}</h3>
	<p><strong>{$LANG.index_glidersetting_max_rollovers_allowed_note}&nbsp;{$myobj->getFormField('max_rollovers_allowed')}</strong></p>
	{if $myobj->isShowPageBlock('block_form_add_glider_content')}
		<h3>
			{if $myobj->chkIsEditMode()}
				{$LANG.index_glidersetting_edit_featured_content}
			{else}
				{$LANG.index_glidersetting_add_featured_content}
			{/if}
		</h3>

		<!-- Add Index Featured Content Glider Block Starts -->
		<div id="selAddFeaturedContentBlock">
			<form id="frmAddContentGlider" name="frmAddContentGlider" method="post" action="{$myobj->getCurrentUrl(false)}" enctype="multipart/form-data">
				<table class="clsNoBorder">
					<tr>
						<td class="clsWidthSmall">
							{$myobj->displayCompulsoryIcon()}<label for="media_type">{$LANG.index_glidersetting_media_type}</label>
						</td>
			    		<td>
							<select name="media_type" id="id_media_type" onchange="showCustomBlock(this.value)" tabindex="{smartyTabIndex}">
			    				<option value='video' {if $myobj->getFormField('media_type')=='video'} selected {/if}>{$LANG.media_type_video}</option>
			        			<option value='music' {if $myobj->getFormField('media_type')=='music'} selected {/if}>{$LANG.media_type_music}</option>
			        			<option value='photo' {if $myobj->getFormField('media_type')=='photo'} selected {/if}>{$LANG.media_type_photo}</option>
			        			<option value='custom' {if $myobj->getFormField('media_type')=='custom'} selected {/if}>{$LANG.media_type_custom}</option>
			    			</select>
			    			<p>{$myobj->getFormFieldErrorTip('media_type')}</p>
			    			<p>{$myobj->ShowHelpTip('indexcontentglider_media_type', 'media_type')}</p>
			    		</td>
					</tr>
					<tr>
						<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('glider_title')}">
							{$myobj->displayCompulsoryIcon()}<label for="glider_title">{$LANG.index_glidersetting_slide_title}</label>
						</td>
			    		<td class="{$myobj->getCSSFormFieldCellClass('glider_title')}">
							<input type="text" class="clsTextBox" name="glider_title" id="id_glider_title" value="{$myobj->getFormField('glider_title')}" tabindex="{smartyTabIndex}" maxlength="{$CFG.admin.glider.slide_title_max_length}"/>&nbsp;
							<p>{$myobj->getFormFieldErrorTip('glider_title')}</p>
							<p>{$myobj->ShowHelpTip('indexcontentglider_glider_title', 'glider_title')}</p>
						</td>
					</tr>
					<tr>
                    	<td colspan="2">
                        	<table id="selMediaId" class="clsNoBorder">
                            	<tr>
                                    <td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('media_id')}">
                                        {$myobj->displayCompulsoryIcon()}<label for="media_id">{$LANG.index_glidersetting_media_id}</label>
                                    </td>
                                    <td class="{$myobj->getCSSFormFieldCellClass('media_id')}">
                                        <input type="text" class="clsTextBox" name="media_id" id="id_media_id" value="{$myobj->getFormField('media_id')}" tabindex="{smartyTabIndex}" {if $myobj->getFormField('media_type') eq 'custom'}disabled="disabled"{/if}/>&nbsp;
                                        <p id="selSearchMedia">
                                            <a id="show_media_search" href="javascript:void(0);">{$LANG.index_glidersetting_search_media_id}</a>
                                        </p>
                                        <p>{$myobj->getFormFieldErrorTip('media_id')}</p>
                                        <p>{$myobj->ShowHelpTip('indexcontentglider_media_id', 'media_id')}</p>
                                    </td>
                                  </tr>
                               </table>
                           </td>
					</tr>
		
                                    <tr>
                                        <td class="{$myobj->getCSSFormFieldCellClass('custom_image')}">
                                            {$myobj->displayCompulsoryIcon()}<label for="custom_image">{$LANG.index_glidersetting_upload_custom_image}</label>
                                        </td>
                                        <td>
                                            <input type="file" class="clsFileBox" name="custom_image" id="id_custom_image" tabindex="{smartyTabIndex}" {if $myobj->getFormField('media_type') ne 'custom'}disabled="disabled"{/if} />
                                            <div class="clsTdDatas">
                                                <p><strong>{$LANG.common_max_file_size}:</strong>&nbsp;{$CFG.admin.glider.custom_image_max_size}&nbsp;{$LANG.common_file_size_in_KB}</p>
                                                <p><strong>{$LANG.common_allowed_file_formats}:</strong>&nbsp;{$myobj->changeArrayToCommaSeparator($CFG.admin.glider.custom_image_format_arr)}</p>
                                                {$myobj->getFormFieldErrorTip('custom_image')}
                                                <p>{$myobj->ShowHelpTip('indexcontentglider_custom_image', 'custom_image')}</p>
                                                {if $myobj->chkIsEditMode() && $myobj->getFormField('media_type') eq 'custom' && $myobj->getFormField('custom_image_ext')!=''}
                                                    <img src="{$myobj->custom_media_image}" alt="{$myobj->getFormField('glider_title')}" /><br/>
                                                {/if}
                                            </div>
                                        </td>
                                </tr>
        
					<tr>
                    	<td colspan="2">
                        	<table id="selCustomTargetUrl" class="clsNoBorder">
                            	<tr>
                                    <td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('custom_image_url')}">
                                        <label for="custom_image_url">{$LANG.index_glidersetting_custom_image_link}</label>
                                    </td>
                                    <td class="{$myobj->getCSSFormFieldCellClass('custom_image_url')}">
                                        <input type="text" class="clsTextBox" name="custom_image_url" id="id_custom_image_url" value="{$myobj->getFormField('custom_image_url')}" maxlength="{$CFG.admin.glider.custom_target_url_max_length}" tabindex="{smartyTabIndex}" {if $myobj->getFormField('media_type') ne 'custom'}disabled="disabled"{/if}/>
                                        <p>{$myobj->getFormFieldErrorTip('custom_image_url')}</p>
                                        <p>{$myobj->ShowHelpTip('indexcontentglider_custom_image_url', 'custom_image_url')}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
					</tr>
					<tr>
	            		<td><label>{$LANG.index_glidersetting_default_content}</label></td>
	          			<td>
						  	<input type="radio" class="clsCheckRadio" name="media_default_content" id="media_default_content1" value="Yes" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('media_default_content','Yes')} onclick="showMediaBlock(this.value)" {if $myobj->getFormField('media_type') eq 'custom'}disabled="disabled"{/if}/>&nbsp;<label for="media_default_content1">{$LANG.common_yes_option}</label>
                        	<input type="radio" class="clsCheckRadio" name="media_default_content" id="media_default_content2" value="No" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('media_default_content','No')} onclick="showMediaBlock(this.value)" {if $myobj->getFormField('media_type') eq 'custom'}disabled="disabled"{/if}/>&nbsp;<label for="media_default_content2">{$LANG.common_no_option}</label>
                        	{*{$myobj->ShowHelpTip('indexcontentglider_use_default_content', 'media_default_content')}*}
						</td>
	      			</tr>
					<tr>
						<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('rollover_text')}">
							<span id="rolloverMandatory" style="display:none;">{$myobj->displayCompulsoryIcon()}</span><label for="rollover_text">{$LANG.index_glidersetting_rollover_text}</label>
						</td>
			    		<td class="{$myobj->getCSSFormFieldCellClass('rollover_text')}">
							<input type="text" class="clsTextBox" name="rollover_text" id="rollover_text" value="{$myobj->getFormField('rollover_text')}" maxlength="{$CFG.admin.glider.rollover_text_max_length}" tabindex="{smartyTabIndex}"/>
							<p>{$myobj->getFormFieldErrorTip('rollover_text')}</p>
							{*<p>{$myobj->ShowHelpTip('indexcontentglider_rollover_text', 'rollover_text')}</p>*}
						</td>
					</tr>
					<tr>
						<td class="{$myobj->getCSSFormLabelCellClass('sidebar_content')}">
                			<span id="sidebarMandatory" style="display:none;">{$myobj->displayCompulsoryIcon()}</span><label for="sidebar_content">{$LANG.index_glidersetting_sidebar_content}</label>
                		</td>
                		<td>
							{if $CFG.feature.html_editor ne 'richtext' && $CFG.feature.html_editor ne 'tinymce'}
								<textarea name="sidebar_content" id="sidebar_content" tabindex="{smartyTabIndex}">{$myobj->getFormField('sidebar_content')}</textarea>
							{/if}
							{$myobj->populateHtmlEditor('sidebar_content')}
							<p>{$myobj->getFormFieldErrorTip('sidebar_content')}</p>
							{*<p>{$myobj->ShowHelpTip('indexcontentglider_sidebar_content', 'sidebar_content')}</p>*}
                		</td>
                	</tr>
	      			<tr>
	      				<td>&nbsp;</td>
						<td class="{$myobj->getCSSFormFieldCellClass('add_submit')}">
							{if $myobj->chkIsEditMode()}
								<input type="submit" class="clsSubmitButton" name="update_submit" id="update_submit" tabindex="{smartyTabIndex}" value="{$LANG.index_glidersetting_update}" />
							{else}
								<input type="submit" class="clsSubmitButton" name="add_submit" id="add_submit" tabindex="{smartyTabIndex}" value="{$LANG.index_glidersetting_save}" />
							{/if}
							<input type="submit" class="clsCancelButton" name="cancel_submit" id="cancel_submit" tabindex="{smartyTabIndex}" value="{$LANG.index_glidersetting_cancle}" />
						</td>
					</tr>
				</table>
				<input type="hidden" id="glider_id" name="glider_id" value="{$myobj->getFormField('glider_id')}" />
				<input type="hidden" id="custom_image_ext" name="custom_image_ext" value="{$myobj->getFormField('custom_image_ext')}" />
			</form>
		</div>
		<!-- Add Index Featured Content Glider Block Ends -->
	{/if}
</div>

<!--  Reorder Feature conntent starts here -->
{if $myobj->isShowPageBlock('block_form_reorder_glider_content')}
	{if $myobj->reorder_keys}
		<h3>{$LANG.index_glidersetting_reorder_featured_content}</h3>
		<table class="clsNoBorder">
			<tr>
				<td>
					<form name="selReorderFeaturedContentForm" id="selReorderFeaturedContentForm" method="post" action="{$myobj->getCurrentUrl()}">
			      		<div class="menuOrderSection">
			      			<div class="workarea">
			          			<ul class="draglist" id="ul1">
			            			{foreach from=$myobj->reorder_keys item=reorder_id}
			                  			<li id="{$reorder_id}" class="list1">{$myobj->reorder_arr.$reorder_id.glider_title|capitalize:true}</li>
			            			{/foreach}
			            		</ul>
			      			</div>
				    	</div>
				    	<div id="user_actions" style="clear:left;">
					    	<input type="submit" class="clsSubmitButton" name="update_order" value="{$LANG.index_glidersetting_update}" id="showButton" />
				    	</div>
				    	<input type="hidden" name="left" id="left" />
			    	</form>
    			</td>
    		</tr>
    	</table>
	{/if}
{/if}
<!--  Reorder Feature conntent ends here -->

<!-- List Glider setting featured content starts here -->
{if $myobj->isShowPageBlock('block_form_list_glider_content')}
	{if $myobj->isResultsFound()}
	<h3>{$LANG.index_glidersetting_featured_content_title}</h3>
	<div>
		{if $CFG.admin.navigation.top}
			{$myobj->setTemplateFolder('admin')}
			{include file='pagination.tpl'}
		{/if}
		<form name="selListFeaturedContentForm" id="selListFeaturedContentForm" method="post" action="{$myobj->getCurrentUrl()}">
	    	<!-- clsDataDisplaySection - starts here -->
	        <div class="clsDataDisplaySection">
	        	<div class="clsDataHeadSection">
	          		<table>
	            		<tr>
	            			<th class="clsSelectColumn"><input type="checkbox" class="clsCheckBox" name="check_all" onclick= "CheckAll(document.selListFeaturedContentForm.name, document.selListFeaturedContentForm.check_all.name)" tabindex="{smartyTabIndex}" /></th>
	            			<th>{$LANG.index_glidersetting_list_media_type}</th>
	            			<th>{$LANG.index_glidersetting_list_media_id}</th>
	            			<th>{$LANG.index_glidersetting_list_slide_title}</th>
	            			<th>{$LANG.index_glidersetting_list_status}</th>
	            			<th>&nbsp;</th>
	        			</tr>
	            		{foreach key=inc item=value from=$populateContent_arr}
	           				<tr>
	            				<td class="clsSelectColumn">
	              					<input type="checkbox" class="clsCheckBox" name="aid[]" value="{$populateContent_arr.$inc.glider_id}" tabindex="{smartyTabIndex}" onClick="disableHeading('selListFeaturedContentForm');"/>
	            				</td>
	            				<td class="clsBannerDescription">{$populateContent_arr.$inc.media_type}</td>
	            				<td>{$populateContent_arr.$inc.media_id}</td>
	            				<td>{$populateContent_arr.$inc.glider_title}</td>
	            				<td>{$populateContent_arr.$inc.status}</td>
	            				<td><a href="{$populateContent_arr.$inc.edit_link}">{$LANG.index_glidersetting_edit}</a></td>
	        				</tr>
	          			{/foreach}
	          			<tr>
	            			<td colspan="6">
	            				<input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.index_glidersetting_delete}" onclick="{$delete_submit_onclick}" />
	            				<input type="button" class="clsSubmitButton" name="activate_submit" id="activate_submit" tabindex="{smartyTabIndex}" value="{$LANG.index_glidersetting_activate}" onclick="{$activate_submit_onclick}" />
	            				<input type="button" class="clsSubmitButton" name="deactivate_submit" id="deactivate_submit" tabindex="{smartyTabIndex}" value="{$LANG.index_glidersetting_deactivate}" onclick="{$deactivate_submit_onclick}" />
							</td>
	          			</tr>
	        		</table>
	        	</div>
	        </div>
	    	<!-- clsDataDisplaySection - ends here -->
		</form>
		{if $CFG.admin.navigation.bottom}
	    {$myobj->setTemplateFolder('admin')}
	    {include file='pagination.tpl'}
	    {/if}
	</div>
	{else}
		<div id="selMsgAlert"><p><strong>{$LANG.index_glidersetting_no_records_found}</strong></p></div>
	{/if}
{/if}
<!-- List Glider setting featured content ends here -->
</div>

{* Added code to display to display fancy box to update photo location *}
{literal}
<script>
var mediaType = $Jq('#id_media_type').val();
if(mediaType == 'custom')
{
	$Jq('#selCustomImage').css('display', 'block');
	$Jq('#selCustomTargetUrl').css('display', 'block');
	$Jq('#selMediaId').css('display', 'none');
}
else
{
	$Jq('#selCustomImage').css('display', 'none');
	$Jq('#selCustomTargetUrl').css('display', 'none');
}
$Jq(document).ready(function() {
	$Jq('#show_media_search').fancybox({
		'width'				: 865,
		'height'			: '100%',
		'padding'			:  0,
		'autoScale'     	: false,
		'href'              : '{/literal}{$CFG.site.url}{literal}admin/indexContentGliderSettings.php?act=search',
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
});
</script>
{/literal}