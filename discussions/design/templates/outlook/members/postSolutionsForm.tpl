{if $myobj->isAllowedToAsk($myobj->board_details.user_id)}
    <div class="clsCommonIndexRoundedCorner clsClearFix">
	<!--rounded corners-->
	{$myobj->setTemplateFolder('general/', 'discussions')}
	{include file='box.tpl' opt='topanalyst_top'}
		<div class="clsBoardsLink">
			<h3>{$postSolutionsForm_arr.solution_caption}</h3>
		</div>
        {if $CFG.admin.solutions.point_notification && $CFG.admin.reply_solutions.allowed && !$myobj->getFormField('aid')}
            <p class="clsEarnPoint">{$postSolutionsForm_arr.earn_points_details_info}</p>
        {/if}
<div class="clsFullPadding">
    <form name="selFormReplySolutions" id="selFormReplySolutions" method="post" action="{$postSolutionsForm_arr.form_action}" autocomplete="off" enctype="multipart/form-data" onSubmit="showSubmitProcess();">
    {$myobj->populateHidden($postSolutionsForm_arr.hidden_arr)}
	<p class="clsSolutionQuestionBox">{$postSolutionsForm_arr.board_manual}</p>
        <table summary="{$LANG.post_your_solutions}" class="clsLoginTable clsSolutionAddBox">
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('solution')}"><label for="solution">{$LANG.your_solution}</label><span class="clsRequired">*</span>
                {$myobj->ShowHelpTip('solutions', 'solution')}
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('solution')}">
				<div class="clsAdvSolution">
                	<script>edToolbar('solution'); </script>
                    <textarea name="solution" id="solution" class="{$myobj->getCSSFormFieldElementClass('solution')} clsSolnTextArea selInputLimiter" cols="23" rows="5" tabindex="{smartyTabIndex}" maxlength="{$CFG.admin.solutions.limit}" maxlimit="{$CFG.admin.solutions.limit}">{$myobj->getFormField('solution')}</textarea>
					 <a class="clsSolutionTabIncres" href="javascript:makeBigger(0, document.getElementById('solution'))" title="{$LANG.smaller_tip}"></a>
					 <a class="clsSolutionTabDecres" href="javascript:makeBigger(1, document.getElementById('solution'))" title="{$LANG.bigger_tip}"></a>
					</div>
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
                    <div class="clsDetailsImgUpload clsPaddingBottom10px">
                    <p class="clsZeroColour">{$postSolutionsForm_arr.attachments_allowed_manual}</p>
                    <p class="clsZeroColour">{$postSolutionsForm_arr.allowed_formats_manual}</p>
					<p class="clsZeroColour">{$postSolutionsForm_arr.allowed_size}</p>
                    </div>
					  {$myobj->getFormFieldErrorTip('attachments')}
					{if $myobj->getFormField('aid')}
					    <div id="uploaded_images" class="uploadOverflow clsClearFix">
	                    {foreach key=gAkey item=gAvalue from=$postSolutionsForm_arr.getAttachments}
	                    {if (in_array($gAvalue.extern, $CFG.admin.attachments.image_formats))}
		                    <span class="clsAskUploadImg" id="attach_{$gAvalue.record.attachment_id}">
								<div class="clsThumbImageOuter cls90x90thumbImage clsFormAttachImage">
									<div class="clsThumbImageMiddle">
										<div class="clsThumbImageInner">
		                        			<a href="{$gAvalue.attachment.url}" id="attachmentform{$gAvalue.record.attachment_id}" target="_blank"><img src="{$gAvalue.attachment.url_thumb}"  alt="{$gAvalue.record.attachment_name}" /></a>
                                            {literal}
											<script>
                                            $Jq(document).ready(function() {
                                            
                                                            $Jq('#attachmentform'+{/literal}{$gAvalue.record.attachment_id}{literal}).fancybox({
                                                                'width'				: 815,
                                                                'height'			: 620,
                                                                'padding'			:  0,
                                                                'autoScale'     	: false,
                                                                'transitionIn'		: 'none',
                                                                'transitionOut'		: 'none',
                                                                'type'				: 'iframe'
                                                            });
                                             });
                                            </script> 
                                         {/literal}
										</div>
									</div>
								</div>
		                        <span class=""><a href="#" id="{$gAvalue.anchor}" title="{$LANG.header_remove}" onClick="return Confirmation('selDelAttachconfirm', 'msgAttachConfirmform', Array('act','attach_id', 'attach_content_id', 'attach_name', 'msgAttachConfirmText'), Array('deletemoreattachments','{$gAvalue.record.attachment_id}','{$myobj->getFormField('aid')}', '{$gAvalue.attachment_file_name}', '{$LANG.confirm_remove_info_message}'), Array('value','value','value', 'value','innerHTML'));"  class="clsAttachmentRemove"></a></span>
		                    </span>
	                    {/if}
						{/foreach}
	                    {foreach key=gAkey item=gAvalue from=$postSolutionsForm_arr.getAttachments}
	                    {if (!in_array($gAvalue.extern, $CFG.admin.attachments.image_formats))}
		                    <span class="clsAskUploadImg" id="attach_{$gAvalue.record.attachment_id}">
	                			<span class="clsDocText"><a href="{$gAvalue.attachment.original_url}" target="_blank">{$gAvalue.attachment_name}</a></span>
		                        <span class="clsRemoveImg"><a href="#" id="{$gAvalue.anchor}" title="{$LANG.header_remove}" onClick="return Confirmation('selDelAttachconfirm', 'msgAttachConfirmform', Array('act','attach_id', 'attach_content_id', 'attach_name', 'msgAttachConfirmText'), Array('deletemoreattachments','{$gAvalue.record.attachment_id}','{$myobj->getFormField('aid')}', '{$gAvalue.attachment_file_name}', '{$LANG.confirm_remove_fileinfo_message}'), Array('value','value','value', 'value','innerHTML'));"  class="clsAttachmentRemove"></a></span>
		                    </span>
	                    {/if}
						{/foreach}
					  </div>
					{/if}

			<div id="content">
				<div id="image_uploads" class="{$myobj->getCSSFormFieldCellClass('attachments')}" style="display:block;width:200px;">
					<span id="spanButtonPlaceholder"></span>
				</div>
				<div id="divFileProgressContainer" style="height:75px;display:none;"></div>
				<div id="thumbnails" style="width:500px;margin:0px 0 0 0"></div>
				<div id="hiddenvals"></div>
				<div id="hiddenoriginalvals"></div>
			</div>
			</td>
		</tr>
	 {/if}
	   <!-- ends add attachment block1 -->
            <tr>
			<td></td>
                <td class="{$myobj->getCSSFormFieldCellClass('submit')}" colspan="2">
				     <span id="showProcessDiv" style="display:none;"></span>
					 <div id="hideButtons">
						 {if $myobj->getFormField('aid')}
					 <p class="clsSubmitButton">
					<span>
                        <input type="submit" class="clsSearchButtonInput" name="update_solution" id="submit" tabindex="{smartyTabIndex}" value="{$LANG.solutions_update_yours}" onclick="return updatelengthMine(this.form.solution);" />
						</span></p>
                     {else}
					 <p class="clsSubmitButton">
					<span>
                        <input type="submit" class="clsSearchButtonInput" name="solution_submit" id="submit" tabindex="{smartyTabIndex}" value="{$LANG.solutions_submit_yours}" onclick="return updatelengthMine(this.form.solution);" />
						</span></p>
                     {/if}
					  {if $postSolutionsForm_arr.for=='main'}

						<p class="clsCancelButton">
						<span>
                        <a href="{$myobj->solutions_Url}"><input type="button" class="clsCancelButtonInput" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" /></a>
						</span></p>
                    {else}
					<p class="clsCancelButton">
					<span>

                        <a href="{$myobj->solutions_Url}"><input type="button" class="clsCancelButtonInput cancel" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" onClick="solutionCancel({$CFG.admin.solutions.limit}); Effect.toggle('subAnsPostForm', 'BLIND'); return false;" /></a>
						</span></p>
                    {/if}
                    </div>

                </td>
            </tr>
        </table>
        <input type="hidden" name="aid" value="{$myobj->getFormField('aid')}" />
        <input type="hidden" name="visible_to" value="All" />
    </form>
		{if $CFG.feature.jquery_validation}
	    	{literal}
				<script language="javascript" type="text/javascript">
					$Jq("#selFormReplySolutions").validate({
						rules: {
							solution: {
								required: true
						    }
						},
						messages: {
							solution: {
								required: {/literal}"{$LANG.common_err_tip_compulsory}"{literal}
							}
						}
					});
	        	</script>
	    	{/literal}
		{/if}
    <!-- solution listing starts -->
    <div>
		{$myobj->showReplies()}
    </div>
    <!-- solution listing ends -->
	</div>
	

	{$myobj->setTemplateFolder('general/', 'discussions')}
	{include file='box.tpl' opt='topanalyst_bottom'}
		<!--rounded corners-->
    </div>
{else}
    <div id="selMsgAlert">
        <p>{$LANG.info_not_allowed_to_ask}</p>
    </div>
{/if}