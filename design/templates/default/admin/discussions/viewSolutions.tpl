<div id="selListAll">
	<h2 class="clsOpenBoard">{$myobj->title}</h2>
    <div id="selMisNavLinks">
        <ul>
            <li><a href="discussions.php">{$LANG.discussions}</a></li>
			{foreach key=ckey item=cat_value from=$myobj->category_titles}
		  		<li>{$cat_value.cat_url}</li>
			{/foreach}
	  		<li><a href="manageSolutions.php?did={$myobj->navigation_array.discussion_id}">{$myobj->navigation_array.discussion_title}</a></li>
	  		<li>{$myobj->navigation_array.board_title}</li>
        </ul>
	</div>

{include file='information.tpl'}

{if $myobj->isShowPageBlock('form_board')}

    <div id="selMsgConfirm" class="selMsgConfirm" style="display:none;">
    <p id="confirmation_msg"></p>
    <form name="deleteForm" id="deleteForm" method="post" action="viewSolutions.php?bid={$myobj->getFormField('bid')}" autocomplete="off">
        <table >
            <tr>
                <td>
                    <input type="submit" class="clsSubmitButton" name="delete_add" id="delete_add" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
                    <input type="button" class="clsCancelButton" name="cancel" id="cancel" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks();" />
                    <input type="hidden" name="aid" id="aid" />
                    <input type="hidden" name="act" id="act" />
					<input type="hidden" name="comment_id" id="comment_id" />
                    {$myobj->populateHidden($myobj->form_board.delete_hidden_arr)}
                </td>
            </tr>
        </table>
    </form>
    </div>
    <div id="selDelAttachconfirm" class="clsPopupConfirmation" style="display:none;">
            <p id="msgAttachConfirmText"></p>
            <form name="msgAttachConfirmform" id="msgAttachConfirmform" method="post" action="{$CFG.site.relative_url}viewSolutions.php?bid={$myobj->getFormField('bid')}">
                <table summary="{$LANG.confirm_tbl_summary}">
                    <tr>
                        <td>
                            <p id="brsBtn" {$myobj->form_board.attach_style}><input type="button" class="clsSubmitButton" name="confirm" id="confirm" onclick="deleteSolutionAttachments('{$CFG.site.relative_url}viewSolutions.php?bid={$myobj->getFormField('bid')}', '&amp;ajax_page=true&amp;deletemoreattachments=1'); return hideAllBlocks();" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
                                <input type="button" class="clsCancelButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks();" /></p>
                            <input type="hidden" name="attach_id" id="attach_id" />
                            <input type="hidden" name="attach_content_id" id="attach_content_id" />
                            <input type="hidden" name="attach_name" id="attach_name" />
                            <input type="hidden" name="act" id="act" />
                            {$myobj->populateHidden($myobj->form_board.attach_hidden_arr)}
                        </td>
                    </tr>
                </table>
            </form>
      </div>

{/if}

{if $myobj->isShowPageBlock('form_confirm')}
		  <div id="selMsgConfirm">
		    <form name="selFormConfirm" id="selFormConfirm" method="post" action="{$CFG.site.relative_url}viewSolutions.php?bid={$myobj->getFormField('bid')}">
				<p>{$myobj->confirm_message}</p>
		      <table summary="{$LANG.confirm_tbl_summary}" border="1">
		        <tr>
		          <td>
		            <input type="submit" class="clsSubmitButton" name="{$myobj->action}" id="{$myobj->action}" tabindex="{smartyTabIndex}" value="{$LANG.common_yes_option}" />
				  </td>
				  <td>
				  	<input type="submit" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_no_option}"  />
		          </td>
		        </tr>
			  </table>
			  {$myobj->populateHidden($myobj->hidden_array)}
			</form>
		  </div>
{/if}


{if $myobj->isShowPageBlock('form_search')}
    <form name="selBoardSearchs" id="selBoardSearch" method="post" action="{$CFG.site.relative_url}manageSolutions.php" autocomplete="off">
		    <table summary="{$LANG.solutions_tbl_summary}">
		      <tr>
		        <td class="{$myobj->getCSSFormLabelCellClass('search_name')}"><label for="search_name">{$LANG.search}</label></td>
		        <td class="{$myobj->getCSSFormFieldCellClass('search_name')}">
		          <input type="text" class="clsTextBox" name="search_name" id="search_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('search_name')}" />
                  {$myobj->getFormFieldElementErrorTip('search_name')}
                 </td>
		      </tr>
		      <tr>
		        <td class="{$myobj->getCSSFormLabelCellClass('search_cat')}"><label for="search_cat">{$LANG.solutions_search_cat}</label></td>
		        <td class="{$myobj->getCSSFormFieldCellClass('search_cat')}">
		          <select name="search_cat" id="search_cat" tabindex="{smartyTabIndex}">
                  	{$myobj->generalPopulateArray($myobj->search_cat_arr, $myobj->getFormField('search_cat'))}
		          </select>
                  {$myobj->getFormFieldElementErrorTip('search_cat')}
		        </td>
		      </tr>
		      <tr>
		        <td colspan="2"  class="{$myobj->getCSSFormFieldCellClass('submit')}"><input type="submit" class="clsSubmitButton" name="go" tabindex="{smartyTabIndex}" value="{$LANG.common_go}" /></td>
		      </tr>
		    </table>
		</form>
{/if}

{if $myobj->isShowPageBlock('form_board')}
	{if $myobj->form_board.displayBoardDetails_arr}   {*if $myobj->board_details*}

				<div id="selQuickLinks">
		            <div class="clsSolnPrevNext">
						{$myobj->showAnotherBoard()}{$myobj->showAnotherBoard(1)}
					</div>
				<form name="boardDetails" id="boardDetails" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
				<table summary="display board details" id="selAuthorTbl">
					<tr>
						<td>
						<p class="clsBold"><strong>{$myobj->form_board.displayBoardDetails_arr.board_manual}</strong></p>
						<p class="clsDesc">{$myobj->form_board.displayBoardDetails_arr.description_manual}</p>
						<div>
							<span>{$LANG.discuzz_common_board_asked_by} <a href="{$CFG.site.relative_url}../viewMembers.php?uid={$myobj->board_details.user_id}">{$myobj->board_details.asked_by}</a></span>
							&nbsp;-&nbsp;
							<span>{$myobj->board_details.total_solutions}&nbsp;{$LANG.solutions}</span>
							&nbsp;-&nbsp;
							<span>
							{if $myobj->board_details.board_added}
								{$myobj->getTimeDiffernceFormat($myobj->board_details.board_added)}
                            {/if}

							</span>
							&nbsp;-&nbsp;
							<span><a href="manageSolutions.php?did={$myobj->getFormField('did')}&bid={$myobj->board_details.board_id}&amp;f=v">{$LANG.common_edit}</a></span>
							&nbsp;-&nbsp;
							<span><a id="anchorDelBoard"  href="#" title="{$LANG.common_delete}" onClick="return Confirmation('selMsgConfirm', 'deleteForm', Array('act','aid', 'confirmation_msg'), Array('deleteBoard','{$myobj->form_board.displayBoardDetails_arr.bid}', '{$LANG.confirm_deleteboard_message}'), Array('value','value', 'innerHTML'));">{$LANG.common_delete}</a></span>
						  <!--start-->
							   <div id="allAttachments">
								<div  class="clsReplies">
									{if $myobj->hasMoreAttachments($myobj->board_details.board_id)}
										<div class="clsViewReplies">
                                            {foreach key=fmaKey item=fmaValue from=$myobj->form_board.displayBoardDetails_arr.fetchMoreAttachments.row}
                                            {if (in_array($fmaValue.extern, $CFG.admin.attachments.image_formats))}
                                                <div class="clsDivReply">
                                                    <ul class="clsDisplayLinks">
                                                        <li class="clsLastInfo"></li>
                                                        <li id="attach_{$fmaValue.record.attachment_id}" class="clsFloatLeft">
																<div class="clsThumbImageOuter cls90x90thumbImage clsFormAttachImage clsFloatLeft">
																<div class="clsThumbImageMiddle">
																<div class="clsThumbImageInner">

																<a href="{$fmaValue.attachment_path}" class="lightwindow" rel="gallery['{$fmaValue.gallery}']" title="{$fmaValue.attachment_name}" ><img alt="" src="{$fmaValue.image_path}"/></a>
																	</div></div></div>
                                                            	<span class="clsRemoveImgDisp"><a href="#" id="{$fmaValue.anchor}" onClick="return Confirmation('selDelAttachconfirm', 'msgAttachConfirmform', Array('act', 'attach_id', 'attach_content_id', 'attach_name', 'msgAttachConfirmText'), Array('deletemoreattachments', '{$fmaValue.record.attachment_id}', '{$fmaValue.record.content_id}', '{$fmaValue.attachment_file_name}', '{$LANG.confirm_remove_info_message}'), Array('value', 'value', 'value', 'value', 'innerHTML'));" class="more" title="{$LANG.common_remove_attachments}"></a></span>

                                                        </li>
                                                    </ul>
                                                </div>
                                            {/if}
                                            {/foreach}
                                            {foreach key=fmaKey item=fmaValue from=$myobj->form_board.displayBoardDetails_arr.fetchMoreAttachments.row}
                                            {if (!in_array($fmaValue.extern, $CFG.admin.attachments.image_formats))}
												<span id="attach_{$fmaValue.record.attachment_id}" class="clsAskUploadImgDoc">
													<span class="clsDocText"><a href="{$fmaValue.attachment_original_path}" target="_blank">{$fmaValue.attachment_name}</a></span>
													<span class="clsRemoveImgDisp"><a href="#" id="{$fmaValue.anchor}" onClick="return Confirmation('selDelAttachconfirm', 'msgAttachConfirmform', Array('act', 'attach_id', 'attach_content_id', 'attach_name', 'msgAttachConfirmText'), Array('deletemoreattachments', '{$fmaValue.record.attachment_id}', '{$fmaValue.record.content_id}', '{$fmaValue.attachment_file_name}', '{$LANG.confirm_remove_fileinfo_message}'), Array('value', 'value', 'value', 'value', 'innerHTML'));" class="clsAttachmentRemove" title="{$LANG.common_remove_attachments}"></a></span>
												</span>
                                            {/if}
                                            {/foreach}
                                        </div>
									{/if}
								</div>
							  </div>
						       <!--end-->
						</div>
						</td>
					</tr>

                    {if $myobj->form_board.displayBoardDetails_arr.displayBestSolution_arr}

                        <tr>
                            <td>
                            <div class="clsSolutions">
                                <p><strong>{$LANG.solutions_accepted}</strong></p>
                                <p>{$myobj->form_board.displayBoardDetails_arr.displayBestSolution_arr.row_solution_manual}</p>
                                <div>
                                    <span>{$LANG.discuzz_common_board_solutioned_by} <a href="{$CFG.site.relative_url}../viewMembers.php?uid={$myobj->form_board.displayBoardDetails_arr.displayBestSolution_arr.record.user_id}">{$myobj->form_board.displayBoardDetails_arr.displayBestSolution_arr.record.solutioned_by}</a></span>
                                    &nbsp;-&nbsp;
                                    <span>{$myobj->getTimeDiffernceFormat($myobj->form_board.displayBoardDetails_arr.displayBestSolution_arr.record.solution_added)}</span>
                                    &nbsp;-&nbsp;
                                    <a id="anchorRemoveBest"  href="#" title="{$LANG.delete_best_solution}" onClick="return Confirmation('selMsgConfirm', 'deleteForm', Array('act','aid', 'confirmation_msg'), Array('deleteBestSolution','{$myobj->form_board.displayBoardDetails_arr.displayBestSolution_arr.record.solution_id}', '{$LANG.confirm_delete_best_solution_message}'), Array('value','value', 'innerHTML'));">{$LANG.delete_best_solution}</a>
                                    &nbsp;-&nbsp;
                                    <a id="anchorDeleteSolution"  href="#" title="{$LANG.common_delete}" onClick="return Confirmation('selMsgConfirm', 'deleteForm', Array('act','aid', 'confirmation_msg'), Array('deleteSolution','{$myobj->form_board.displayBoardDetails_arr.displayBestSolution_arr.record.solution_id}', '{$LANG.confirm_delete_message}'), Array('value','value', 'innerHTML'));">{$LANG.common_delete}</a>

                                    {if isset($myobj->form_board.displayBoardDetails_arr.displayBestSolution_arr.fetchMoreAttachments.row)}
										<div class="clsViewReplies">
                                            {foreach key=fmaaKey item=fmaaValue from=$myobj->form_board.displayBoardDetails_arr.displayBestSolution_arr.fetchMoreAttachments.row}
                                            {if (in_array($fmaaValue.extern, $CFG.admin.attachments.image_formats))}
                                                <div class="clsBlogReply">
                                                    <ul class="clsBlogDisplayLinks">
                                                        <li class="clsLastBlogInfo"></li>
                                                        <li id="attach_{$fmaaValue.record.attachment_id}">
                                                            <p class="">
															<div class="clsThumbImageOuter cls90PXthumbImage"><div class="clsrThumbImageMiddle"><div class="clsThumbImageInner">
																<a href="{$fmaaValue.attachment_path}" class="lightwindow" rel="gallery['{$fmaaValue.gallery}']" title="{$fmaaValue.attachment_name}" ><img alt="" src="{$fmaaValue.image_path}" /></a>
															</div></div></div>
                                                            <a href="#" id="{$fmaaValue.anchor}" onClick="return Confirmation('selDelAttachconfirm', 'msgAttachConfirmform', Array('act', 'attach_id', 'attach_content_id', 'attach_name', 'msgAttachConfirmText'), Array('deletemoreattachments', '{$fmaaValue.record.attachment_id}', '{$fmaaValue.record.content_id}', '{$fmaaValue.attachment_file_name}', '{$LANG.confirm_remove_info_message}'), Array('value', 'value', 'value', 'value', 'innerHTML'));" class="clsAttachmentRemove">{$LANG.common_remove_attachments}</a></p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            {/if}
                                            {/foreach}
                                            {foreach key=fmaaKey item=fmaaValue from=$myobj->form_board.displayBoardDetails_arr.displayBestSolution_arr.fetchMoreAttachments.row}
	                                          {if (!in_array($fmaaValue.extern, $CFG.admin.attachments.image_formats))}
                                                   <span class="clsAskUploadImgDoc" id="attach_{$fmaaValue.record.attachment_id}">
														<span class="clsDocText"><a href="{$fmaaValue.attachment_original_path}">{$fmaaValue.attachment_name}</a></span>
                                                        <span class="clsRemoveImgDisp"><a href="#" id="{$fmaaValue.anchor}" onClick="return Confirmation('selDelAttachconfirm', 'msgAttachConfirmform', Array('act', 'attach_id', 'attach_content_id', 'attach_name', 'msgAttachConfirmText'), Array('deletemoreattachments', '{$fmaaValue.record.attachment_id}', '{$fmaaValue.record.content_id}', '{$fmaaValue.attachment_file_name}', '{$LANG.confirm_remove_fileinfo_message}'), Array('value', 'value', 'value', 'value', 'innerHTML'));" class="clsAttachmentRemove">{$LANG.common_remove_attachments}</a></span>
                                                    </span>
                                            {/if}
                                            {/foreach}
                                       </div>
                                    {/if}

                                </div>
                            </div>
                            </td>
                        </tr>
						 {if $CFG.admin.solutions_comment.allowed}
						  {if $myobj->form_board.displayBoardDetails_arr.displayBestSolution_arr.populateCommentList}
						 <tr>
							<td>
							{foreach key=farlkey item=farlvalue from=$myobj->form_board.displayBoardDetails_arr.displayBestSolution_arr.populateCommentList}
							  <div  class="clsCommentSolutionDisplay">
								<div id="{$farlvalue.commentSpanIDId}">
									<p><span>{$LANG.common_comment_posted_by}</span> : <a href="{$farlvalue.mysolutions.url}">{$farlvalue.user_details.display_name}</a></p>
									<p><span>{$LANG.common_date_added}</span> : {$farlvalue.record.date_added|date_format}</p>
									<p>{$farlvalue.record.comment}</p>
								</div>
							  </div>
							{/foreach}
							</td>
						</tr>
						{/if}
						{/if}
				   {/if}

				</table>
				</form>
				</div>
				<span class="clsSolutionBoard"><a {$myobj->form_board.displayBoardDetails_arr.onclick_action} href="{$myobj->form_board.displayBoardDetails_arr.reply_solution.url}">{$LANG.post_new_solution}</a></span>

	{/if}

{/if}

{if $myobj->isShowPageBlock('form_solutions')}
    {if $myobj->isResultsFound()}
        {if $CFG.admin.navigation.top}
                {include file='pagination.tpl'}
        {/if}

            <form name="selListAdvertisementForm" id="selListAdvertisementForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                <table summary="{$LANG.display_all_solutions}">
                <tr>
                    <td>
                    	<a href="#" id="{$myobj->da_anchor}"></a>
                    	<input type="checkbox" class="clsCheckRadio" id="checkall" onclick="selectAll(this.form)" name="checkall" tabindex="{smartyTabIndex}" />
                    </td>
                    <td>
                    	<input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.common_delete}" onClick="if(getMultiCheckBoxValue('selListAdvertisementForm', 'checkall', '{$LANG.select_a_solution}'))Confirmation('selMsgConfirm', 'deleteForm', Array('aid', 'act', 'confirmation_msg'), Array(multiCheckValue, 'delete', '{$myobj->form_solutions.confirm_delete}'), Array('value', 'value', 'innerHTML'));" />
                    </td>
                </tr>
                {foreach key=daKey item=daValue from=$myobj->form_solutions.displayAllSolutions_arr}
                        <tr id="{$daValue.solution_id}">
                            <td><input type="checkbox" class="clsCheckRadio" name="aid[]" value="{$daValue.record.solution_id}" tabindex="{smartyTabIndex}" onClick="disableHeading('selListAdvertisementForm');" /></td>
                            <td>
                            <div class="clsSolutions">
                                {$daValue.row_solution_manual}
                                <div>
                                    <span>{$LANG.discuzz_common_board_solutioned_by} <a href="{$CFG.site.relative_url}../viewMembers.php?uid={$daValue.record.user_id}">{$daValue.row_solutioned_by_manual}</a></span>
                                    &nbsp;-&nbsp;
                                    <span>{$myobj->getTimeDiffernceFormat($daValue.record.solution_added)}</span>
                                    {if $CFG.admin.abuse_solutions.allowed AND $CFG.user.user_id != $daValue.record.user_id}
                                        &nbsp;-&nbsp;
                                        <span>({$LANG.common_abuse_count} <a href="manageAbuseContent.php?aid={$daValue.record.solution_id}&bid={$daValue.record.board_id}" class="lightwindow" params="lightwindow_width=820">{$daValue.record.abuse_count}</a>)</span>
                                    {/if}
                                    {if $CFG.admin.best_solutions.allowed AND $myobj->board_details.best_solution_id == 0 AND $daValue.record.status !='ToActivate'}
                                        &nbsp;-&nbsp;
                                        <a href="#" title="{$LANG.best_solution}" onClick="return Confirmation('selMsgConfirm', 'deleteForm', Array('act','aid', 'confirmation_msg'), Array('bestsolution','{$daValue.record.solution_id}', '{$LANG.best_solution_confirm_message}'), Array('value','value', 'innerHTML'));">{$LANG.best_solution}</a>
                                    {/if}
                                    &nbsp;-&nbsp;
									<a href="viewSolutions.php?bid={$myobj->board_details.board_id}&did={$myobj->board_details.discussion_id}&aid={$daValue.record.solution_id}&action=edit"  title="{$LANG.edit_comment}">{$LANG.edit_comment}</a>

									{if $daValue.record.status =='ToActivate'}
                                        &nbsp;-&nbsp;
                                        <a href="#" title="{$LANG.publish}" onClick="return Confirmation('selMsgConfirm', 'deleteForm', Array('act','aid', 'confirmation_msg'), Array('publishsolution','{$daValue.record.solution_id}', '{$LANG.publish_solution_confirm_message}'), Array('value','value', 'innerHTML'));">{$LANG.publish}</a>
                                    {/if}
                                    <p  class="clsAttachment">
                                    {if $myobj->hasMoreAttachments($daValue.record.solution_id, 'Solution')}
										<div class="clsViewReplies clsClearFix">
                                            {foreach key=fmaaKey item=fmaaValue from=$daValue.fetchMoreAttachments.row}
                                            {if (in_array($fmaaValue.extern, $CFG.admin.attachments.image_formats))}
                                                <div class="clsDivReply">
                                                    <ul class="clsDisplayLinks">
                                                        <li id="attach_{$fmaaValue.record.attachment_id}" class="clsFloatLeft">
                                                            <div class="clsThumbImageOuter cls90x90thumbImage clsFormAttachImage clsFloatLeft"><div class="clsThumbImageMiddle"><div class="clsThumbImageInner">
																<a class="clsSolutionImage lightwindow" href="{$fmaaValue.attachment_path}" rel="gallery['{$fmaaValue.gallery}']" title="{$fmaaValue.attachment_name}" > <img alt="" src="{$fmaaValue.image_path}" /></a>
															</div></div></div>
                                                            <span class="clsRemoveImgDisp"><a href="#" id="{$fmaaValue.anchor}" onClick="return Confirmation('selDelAttachconfirm', 'msgAttachConfirmform', Array('act', 'attach_id', 'attach_content_id', 'attach_name', 'msgAttachConfirmText'), Array('deletemoreattachments', '{$fmaaValue.record.attachment_id}', '{$fmaaValue.record.content_id}', '{$fmaaValue.attachment_file_name}', '{$LANG.confirm_remove_info_message}'), Array('value', 'value', 'value', 'value', 'innerHTML'));" class="more" title="{$LANG.common_remove_attachments}"></a></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            {/if}
                                            {/foreach}
                                            {foreach key=fmaaKey item=fmaaValue from=$daValue.fetchMoreAttachments.row}
                                            {if (!in_array($fmaaValue.extern, $CFG.admin.attachments.image_formats))}
                                                        <span class="clsAskUploadImgDoc" id="attach_{$fmaaValue.record.attachment_id}" class="clsFloatLeft">
															<span class="clsDocText"><a href="{$fmaaValue.attachment_original_path}">{$fmaaValue.attachment_name}</a></span>
                                                            <span class="clsRemoveImgDisp"><a href="#" id="{$fmaaValue.anchor}" onClick="return Confirmation('selDelAttachconfirm', 'msgAttachConfirmform', Array('act', 'attach_id', 'attach_content_id', 'attach_name', 'msgAttachConfirmText'), Array('deletemoreattachments', '{$fmaaValue.record.attachment_id}', '{$fmaaValue.record.content_id}', '{$fmaaValue.attachment_file_name}', '{$LANG.confirm_remove_fileinfo_message}'), Array('value', 'value', 'value', 'value', 'innerHTML'));" class="more" title="{$LANG.common_remove_attachments}"></a></span>
                                                        </span>
                                            {/if}
                                            {/foreach}
                                       </div>
                                    {/if}
                                    </p>
                                </div>
                            </div>

							<div id="msg{$daValue.commentSpanIDId}">
								{if $CFG.admin.solutions_comment.allowed}
									{if $daValue.populateCommentList}
										{foreach key=farlkey item=farlvalue from=$daValue.populateCommentList}
		                                	<div class="clsCommentSolutionDisplay">
												<div id="{$farlvalue.commentSpanIDId}">
													<p><span>{$LANG.common_comment_posted_by}</span> : <a href="{$farlvalue.mysolutions.url}">{$farlvalue.user_details.display_name}</a></p>
													<p><span>{$LANG.common_date_added}</span> : {$farlvalue.record.date_added|date_format}</p>
													<p>{$farlvalue.record.comment}</p>
												</div>
												<p><a  href="#" title="{$LANG.common_delete}" onClick="return Confirmation('selMsgConfirm', 'deleteForm', Array('act','comment_id', 'confirmation_msg'), Array('deletecomment','{$farlvalue.record.comment_id}', '{$LANG.confirm_delete_message_comment}'), Array('value','value', 'innerHTML'));">{$LANG.common_delete}</a></p>
		                                	</div>
										{/foreach}
									{/if}
								{/if}
						   	</div>
                            </td>
                        </tr>
                {/foreach}


            </table>
            </form>

        {if $CFG.admin.navigation.bottom}
            {include file='pagination.tpl'}
        {/if}

    {else}
        <div id="selMsgAlert">
            <p>{$LANG.solutions_not_added}</p>
        </div>
    {/if}

{/if}
{if $myobj->isShowPageBlock('form_add')}
	{$myobj->postSolutionsForm('main')}
{/if}
</div>
{if $myobj->isShowPageBlock('form_add')}
	{literal}
	<script language="javascript" type="text/javascript">
	function chkLimit(){
		var uploaded_images = document.getElementById("uploaded_images");
		if(uploaded_images == null) {
			var d = 0;
		} else {
			items_uploaded = uploaded_images.getElementsByTagName("img");
			var d  =  items_uploaded.length;
			if(d >= file_upload_limit){
				document.getElementById("image_uploads").style.display = "none";
			} else {
				document.getElementById("image_uploads").style.display = "block";
			}
	   }
	}
	chkLimit();
	</script>
	{/literal}
{/if}