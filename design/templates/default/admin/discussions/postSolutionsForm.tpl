<div class="clsReplySolutions">
    <form name="selFormReplySolutions" id="selFormReplySolutions" method="post" action="{$postSolutionsForm_arr.form_action}" autocomplete="off" enctype="multipart/form-data">
    {$myobj->populateHidden($postSolutionsForm_arr.hidden_arr)}
        <table summary="">
            <tr>
                <td colspan="2" class="{$myobj->getCSSFormFieldCellClass('board')}"><span class="clsBold">{$postSolutionsForm_arr.board_manual}</span></td>
            </tr>
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('solution')}"><label for="solution">{$LANG.your_solution}</label>&nbsp;*&nbsp;
                {$myobj->ShowHelpTip('solutions', 'solution')}
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('solution')}">
                	<script>edToolbar('solution'); </script>
                    <textarea name="solution" id="solution" class="{$myobj->getCSSFormFieldElementClass('solution')} selInputLimiter" cols="23" rows="5" tabindex="{smartyTabIndex}" maxlength="{$CFG.admin.solutions.limit}" maxlimit="{$CFG.admin.solutions.limit}">{$myobj->getFormField('solution')}</textarea>
                    {$myobj->getFormFieldElementErrorTip('solution')}
                </td>
            </tr>
            <!-- add documents block1 -->
			{if $CFG.admin.attachments_solutions.allowed && $CFG.admin.attachments_allowed.count > 0}
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('attachments')}"><label for="attachments">{$LANG.boards_your_attachments}</label>
                {$myobj->ShowHelpTip('attachments')}
                </td>
                <td id="tdID" class="{$myobj->getCSSFormFieldCellClass('attachments')}">
                    <div></div>
					<p id="brsBtn"></p>
                    <div class="clsDetailsImgUpload">
                    <p>{$postSolutionsForm_arr.attachments_allowed_manual}</p>
                    <p>{$postSolutionsForm_arr.allowed_formats_manual}</p>
					<p>{$postSolutionsForm_arr.allowed_size}</p>
                    </div>
					  {$myobj->getFormFieldErrorTip('attachments')}
					{if $myobj->getFormField('aid')}
					    <div id="uploaded_images" class="uploadOverflow clsClearFix">
	                    {foreach key=gAkey item=gAvalue from=$postSolutionsForm_arr.getAttachments}
	                    {if (in_array($gAvalue.extern, $CFG.admin.attachments.image_formats))}
	                    	<span class="clsAskUploadImg" id="attach_{$gAvalue.record.attachment_id}"class="clsFloatLeft">
                            	<div class="clsThumbImageOuter cls90x90thumbImage clsFormAttachImage clsFloatLeft"><div class="clsrThumbImageMiddle"><div class="clsThumbImageInner">
	                        		<a href="{$gAvalue.attachment.url}" class="lightwindow"><img src="{$gAvalue.attachment.url_thumb}"  alt="{$gAvalue.record.attachment_name}" /></a>
								</div></div></div>
	                        	<span><a href="#" id="{$gAvalue.anchor}" title="{$LANG.header_remove}" onClick="return Confirmation('selDelAttachconfirm', 'msgAttachConfirmform', Array('act','attach_id', 'attach_content_id', 'attach_name', 'msgAttachConfirmText'), Array('deletemoreattachments','{$gAvalue.record.attachment_id}','{$myobj->getFormField('aid')}', '{$gAvalue.attachment_file_name}', '{$LANG.confirm_remove_info_message}'), Array('value','value','value', 'value','innerHTML'));" class="clsAttachmentRemove"></a></span>
	                    	</span>
	                    {/if}
						{/foreach}
	                    {foreach key=gAkey item=gAvalue from=$postSolutionsForm_arr.getAttachments}
	                    {if (!in_array($gAvalue.extern, $CFG.admin.attachments.image_formats))}
	                    	<span class="clsAskUploadImgDoc" id="attach_{$gAvalue.record.attachment_id}"class="clsFloatLeft">
	                        	<span class="clsDocText"><a href="{$gAvalue.attachment.original_url}">{$gAvalue.attachment_name}</a></span>
	                        	<span class="clsRemoveImgDisp"><a href="#" id="{$gAvalue.anchor}" title="{$LANG.header_remove}" onClick="return Confirmation('selDelAttachconfirm', 'msgAttachConfirmform', Array('act','attach_id', 'attach_content_id', 'attach_name', 'msgAttachConfirmText'), Array('deletemoreattachments','{$gAvalue.record.attachment_id}','{$myobj->getFormField('aid')}', '{$gAvalue.attachment_file_name}', '{$LANG.confirm_remove_fileinfo_message}'), Array('value','value','value', 'value','innerHTML'));" class="clsAttachmentRemove"></a></span>
	                    	</span>
	                    {/if}
						{/foreach}
					  </div>
					{/if}

			<div id="content">
				<div id="image_uploads" class="{$myobj->getCSSFormFieldCellClass('attachments')}" style="display:block;">
					<span id="spanButtonPlaceholder"></span>
				</div>
				<div id="divFileProgressContainer" style="height: 75px; display:none;"></div>
				<div id="thumbnails" style="width:500px;margin:0px 0 0 0"></div>
				<div id="hiddenvals"></div>
				<div id="hiddenoriginalvals"></div>
			</div>
			</td>
		</tr>
	 {/if}
	   <!-- ends add attachment block1 -->
		<tr>
            <tr>
            	<td></td>
                <td class="{$myobj->getCSSFormFieldCellClass('submit')}">
				     {if $myobj->getFormField('aid')}
                        <input type="submit" class="clsSubmitButton clsMediumSubmitButton" name="update_solution" id="submit" tabindex="{smartyTabIndex}" value="{$LANG.common_update}" onclick="return updatelengthMine(this.form.solution);" />
                     {else}
                        <input type="submit" class="clsSubmitButton clsMediumSubmitButton" name="submit" id="submit" tabindex="{smartyTabIndex}" value="{$LANG.common_add}" onclick="return updatelengthMine(this.form.solution);" />
                     {/if}
                    &nbsp;&nbsp;
                    <input type="submit" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" />
                </td>
            </tr>
        </table>
        <input type="hidden" name="aid" value="{$myobj->getFormField('aid')}" />
        <input type="hidden" name="bid" value="{$myobj->getFormField('bid')}" />
        <input type="hidden" name="did" value="{$myobj->getFormField('did')}" />
    </form>
</div>
<div id="selDelAttachconfirm" class="clsPopupConfirmation" style="display:none;">
            <p id="msgAttachConfirmText"></p>
            <form name="msgAttachConfirmform" id="msgAttachConfirmform" method="post" action="{$CFG.site.relative_url}viewSolutions.php?bid={$myobj->getFormField('bid')}">
                <table summary="{$LANG.confirm_tbl_summary}">
                    <tr>
                        <td>
                            <p id="brsBtn" {$postSolutionsForm_arr.attach_style}><input type="button" class="clsSubmitButton" name="confirm" id="confirm" onclick="deleteSolutionAttachments('{$CFG.site.relative_url}viewSolutions.php?bid={$myobj->getFormField('bid')}', '&amp;ajax_page=true&amp;deletemoreattachments=1'); return hideAllBlocks();" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
                                <input type="button" class="clsCancelButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks();" /></p>
                            <input type="hidden" name="attach_id" id="attach_id" />
                            <input type="hidden" name="attach_content_id" id="attach_content_id" />
                            <input type="hidden" name="attach_name" id="attach_name" />
                            <input type="hidden" name="act" id="act" />
                            {$myobj->populateHidden($postSolutionsForm_arr.attach_hidden_arr)}
                        </td>
                    </tr>
                </table>
            </form>
      </div>
