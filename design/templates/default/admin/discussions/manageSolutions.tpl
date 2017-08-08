<div id="selMembers">

  <h2 class="clsManageSolutions">{$LANG.member_title}</h2>
  <div id="selMisNavLinks">
	  <ul>
	  	  <li><a href="discussions.php">{$LANG.discussions}</a></li>
		  {foreach key=ckey item=cat_value from=$myobj->category_titles}
		  		<li>{$cat_value.cat_url}</li>
		  {/foreach}
		  <li>{$myobj->discussion_details.discussion_title}</li>
	  </ul>
  </div>
  {include file='information.tpl'}

{if $myobj->isShowPageBlock('show_form_confirm')}
  <div id="selMsgError">
    <form name="form_delete_event" id="selFormselDeleteEvents" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
      <table class="clsCommonTable" summary="{$LANG.member_tbl_summary}" >
        <tr>
          <td colspan="2">{$LANG.confirm_message}</td>
        </tr>
        <tr>
          <td class="clsButtonAlignment">{$myobj->populateHidden($myobj->getFormField('board_ids'))}
            <input type="hidden" name="action" value="{$myobj->getFormField('action')}" />
            <input type="submit" class="clsSubmitButton" name="cdelete" id="cdelete" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
          </td>
          <td><input type="submit" class="clsCancelButton" name="dcancel" id="dcancel" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" />
          	{$myobj->populateHidden($myobj->show_form_confirm.hidden_arr)}
          </td>
        </tr>
      </table>
    </form>
  </div>
{/if}

	<div id="selDelInfoconfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="msgInfoConfirmText"></p>
      	<form name="msgInfoConfirmform" id="msgInfoConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
        	<table summary="{$LANG.container_to_get_confirmation}">
	          	<tr>
            		<td>
				  	<input type="button" class="clsSubmitButton" name="confirm" id="confirm" onclick="deleteBoardAttachments('{ $CFG.site.relative_url}manageSolutions.php?bid={$myobj->getFormField('bid')}', '&amp;ajax_page=true&amp;deletemoreattachments=1');chkLimit(); return hideAllBlocks();" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
	              	<input type="button" class="clsCancelButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks();" />
					<input type="hidden" name="info_id" id="info_id" />
					<input type="hidden" name="board_id" id="board_id" />
					<input type="hidden" name="filename" id="filename" />
					<input type="hidden" name="act" id="act" />
					</td>
	          	</tr>
        	</table>
      	</form>
  </div>

{if $myobj->isShowPageBlock('form_edit')}
	<form name="selFormAskBoard" id="selFormAskBoard" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off" enctype="multipart/form-data">
	<div id="selBoardEdit">
		{$myobj->populateHidden($myobj->form_edit.hidden_arr)}
		<table class="clsCommonTable" summary="{$LANG.post_your_board}">
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('board')}"><label for="board">{$LANG.board}</label>&nbsp;*&nbsp;</td>
				<td class="{$myobj->getCSSFormFieldCellClass('board')}">
					<input type="text" class="clsTextBox" name="board" id="board" maxlength="250" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('board')}" />
                    {$myobj->getFormFieldElementErrorTip('board')}
				</td>
			</tr>
			<!-- add documents block1 -->
			{if $CFG.admin.attachments_boards.allowed && $CFG.admin.attachments_allowed.count > 0}
			<tr>
			      <td class="{$myobj->getCSSFormLabelCellClass('attachments')}">
			        <label for="attachments">{$LANG.boards_your_attachments}</label>
			       </td>
			      <td id="tdID" class="{$myobj->getCSSFormFieldCellClass('attachments')}">
			      <div ></div>
				   <p id="brsBtn"></p>
                  {$myobj->getFormFieldElementErrorTip('attachments')}
			      <p>{$myobj->form_edit.attachment_allowed_tip_manual}</p>
			      <p>{$myobj->form_edit.attachment_format_tip_manual}</p>
				  <p>{$myobj->form_edit.attachment_size_tip_manual}</p>
                  {if $myobj->getFormField('bid')}
  				   <div id="uploaded_images" class="uploadOverflow">
                        {foreach key=gAkey item=gAvalue from=$myobj->form_edit.getAttachments_arr}
                        	{if (in_array($gAvalue.extern, $CFG.admin.attachments.image_formats))}
                            <span class="clsEditAttachment clsAskUploadImg clsFloatLeft" id="attach_{$gAvalue.record.attachment_id}">
							<div class="clsThumbImageOuter cls90x90thumbImage clsFormAttachImage clsFloatLeft">
								<div class="clsThumbImageMiddle">
									<div class="clsThumbImageInner">
                                		<a href="{$gAvalue.attachment.url}" target="_blank" class="lightwindow" rel="gallery['{$gAvalue.gallery}']"><img src="{$gAvalue.attachment.url_thumb}"  alt="{$gAvalue.record.attachment_name}" /></a>
									</div>
								</div>
							</div>
                            <span><a href="#" id="{$gAvalue.anchor}" title="{$LANG.header_remove}" onClick="return Confirmation('selDelInfoconfirm', 'msgInfoConfirmform', Array('act','info_id', 'board_id', 'filename', 'msgInfoConfirmText'), Array('deletemoreattachments','{$gAvalue.record.attachment_id}','{$myobj->getFormField('bid')}', '{$gAvalue.attachment_file_name}', '{$LANG.confirm_remove_info_message}'), Array('value','value','value', 'value','innerHTML'));" class="clsAttachmentRemove"></a></span>
                            </span>
                            {/if}
                        {/foreach}
                        {foreach key=gAkey item=gAvalue from=$myobj->form_edit.getAttachments_arr}
                        	{if (!in_array($gAvalue.extern, $CFG.admin.attachments.image_formats))}
                            <span class="clsAskUploadImgDoc" id="attach_{$gAvalue.record.attachment_id}">
                        		<span class="clsDocText"><a href="{$gAvalue.attachment.original_url}" target="_blank">{$gAvalue.attachment_name}</a></span>
                            	<span class="clsRemoveImgDisp"><a href="#" id="{$gAvalue.anchor}" title="{$LANG.header_remove}" onClick="return Confirmation('selDelInfoconfirm', 'msgInfoConfirmform', Array('act','info_id', 'board_id', 'filename', 'msgInfoConfirmText'), Array('deletemoreattachments','{$gAvalue.record.attachment_id}','{$myobj->getFormField('bid')}', '{$gAvalue.attachment_file_name}', '{$LANG.confirm_remove_fileinfo_message}'), Array('value','value','value', 'value','innerHTML'));" class="clsAttachmentRemove"></a></span>
                            </span>
                            {/if}
                        {/foreach}
				   </div>
                  {/if}
			      </td>
			</tr>
			<tr>
			<td></td>
			<td>
			<div id="content">
				<div id="image_uploads" class="{$myobj->getCSSFormFieldCellClass('attachments')}" style="display:block;">
					<span id="spanButtonPlaceholder"></span>
				</div>
				<div id="divFileProgressContainer" style="height:75px;display:none;"></div>
				<div id="thumbnails"></div>
				<div id="hiddenvals"></div>
				<div id="hiddenoriginalvals"></div>
			</div>
			</td>
		</tr>
		{/if}
			   <!-- ends add document block1 -->
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('descriptions')}"><label for="descriptions">{$LANG.add_details}</label>&nbsp;*&nbsp;</td>
				<td class="{$myobj->getCSSFormFieldCellClass('descriptions')}">
					<script>edToolbar('descriptions'); </script>
					<textarea name="descriptions" id="descriptions" class="selInputLimiter" maxlength="{$CFG.admin.description.limit}" maxlimit="{$CFG.admin.description.limit}" tabindex="{smartyTabIndex}">{$myobj->form_edit.description_manual}</textarea>
                    {$myobj->getFormFieldElementErrorTip('descriptions')}
					 <div id="ss" class="clsZeroColour"><span> {$LANG.header_remainig} :</span> <span class="clsCharacterLimit">{literal}<script language="javascript" type="text/javascript">var c = ques_des_max_len - document.getElementById('descriptions').value.length;document.write(c);</script>{/literal}</span></div>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('tags')}"><label for="tags">{$LANG.tags_for_boards}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('tags')}">
					<input type="text" class="clsTextBox" name="tags" id="tags" maxlength="20" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('tags')}" />
                    {$myobj->getFormFieldElementErrorTip('tags')}
            		<p class="clsFormInfo">{$LANG.boards_subscribe_keywords_info}&nbsp;{$LANG.discuzz_common_tag_size}&nbsp;{$LANG.boards_subscribe_keywords_invalid}</p>
				</td>
			</tr>
	        {if $CFG.admin.friends.allowed and $CFG.admin.boards.visibility.needed}
	        <tr>
	        	<td class="{$myobj->getCSSFormLabelCellClass('visible_to')}"><label for="status_all">{$myobj->LANG.boards_visible_to}</label>
	            {$myobj->ShowHelpTip('visible_to')}
	            </td>
	            <td class="{$myobj->getCSSFormFieldCellClass('visible_to')}">
				<div class="clsRadioBtn">
	            	<input type="radio" name="visible_to" id="status_all" value="All" {$myobj->isCheckedRadio('visible_to', 'All')} tabindex="{smartyTabIndex}" /><label for="status_all">{$LANG.discuzz_common_all_option}</label>
	                <input type="radio" name="visible_to" id="status_friends" value="Friends" {$myobj->isCheckedRadio('visible_to', 'Friends')} tabindex="{smartyTabIndex}" /><label for="status_friends">{$LANG.discuzz_common_friends_option}</label>
	                <input type="radio" name="visible_to" id="status_none" value="None" {$myobj->isCheckedRadio('visible_to', 'None')} tabindex="{smartyTabIndex}" /><label for="status_none">{$LANG.discuzz_common_none_option}</label>
					</div>
	                <p class="clsFormInfo">{$LANG.boards_msg_board_visible_to_help}</p>{$myobj->getFormFieldElementErrorTip('visible_to')}
	            </td>
	        </tr>
	    	{/if}

			{if !$CFG.admin.board_auto_publish.allowed}
                <tr>
                    <td class="{$myobj->getCSSFormLabelCellClass('publish')}"><label for="status_yes">{$LANG.board_publish_allsolutions}</label></td>
                    <td class="{$myobj->getCSSFormFieldCellClass('publish')}">
                        <input type="radio" name="publish" id="status_yes" value="Yes"{$myobj->isCheckedRadio('publish', 'Yes')} tabindex="{smartyTabIndex}" /><label for="status_yes">{$LANG.common_yes_option}</label>
                        <input type="radio" name="publish" id="status_no" value="No"{$myobj->isCheckedRadio('publish', 'No')} tabindex="{smartyTabIndex}" /><label for="status_no">{$LANG.common_no_option}</label>
                        {$myobj->getFormFieldElementErrorTip('publish')}
                    </td>
                </tr>
			{/if}

			{if $CFG.admin.read_only_board.allowed}
                <tr>
                    <td class="{$myobj->getCSSFormLabelCellClass('readonly')}"><label for="readonly_no">{$LANG.board_read_only}</label></td>
                    <td class="{$myobj->getCSSFormFieldCellClass('readonly')}">
                        <input type="radio" name="readonly" id="readonly_yes" value="Yes"{$myobj->isCheckedRadio('readonly', 'Yes')} tabindex="{smartyTabIndex}" /><label for="readonly_yes">{$LANG.common_yes_option}</label>
                        <input type="radio" name="readonly" id="readonly_no" value="No"{$myobj->isCheckedRadio('readonly', 'No')} tabindex="{smartyTabIndex}" /><label for="readonly_no">{$LANG.common_no_option}</label>
                        {$myobj->getFormFieldElementErrorTip('readonly')}
                    </td>
                </tr>
			{/if}
			<tr>
                <td class="{$myobj->getCSSFormLabelCellClass('isredirect')}"><label for="isredirect">{$myobj->LANG.discussion_isredirect_allowed}</label>
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('isredirect')}">
                	<input type="radio" name="isredirect" id="redirect_yes" value="Yes" {$myobj->isCheckedRadio('isredirect', 'Yes')} tabindex="{smartyTabIndex}" onclick="showLinkDiv();" /><label for="redirect_yes">{$LANG.common_yes_option}</label>
                	<input type="radio" name="isredirect" id="redirect_no" value="No" {$myobj->isCheckedRadio('isredirect', 'No')} tabindex="{smartyTabIndex}" /><label for="redirect_no">{$LANG.common_no_option}</label>
					{$myobj->getFormFieldElementErrorTip('isredirect')}
                </td>
             </tr>
             <tr id="redirectDiv">
                <td class="{$myobj->getCSSFormLabelCellClass('redirect_link')}"><label for="redirect_link">{$myobj->LANG.discussion_redirect_link}</label>
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('redirect_link')}">
                	<input type="text" class="clsTextBox {$myobj->getCSSFormFieldElementClass('redirect_link')}" name="redirect_link" id="redirect_link" maxlength="200" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('redirect_link')}" />
                	<p>{$myobj->LANG.redirect_example_url}</p>
					{$myobj->getFormFieldElementErrorTip('redirect_link')}
                </td>
             </tr>
			<tr>
				<td></td>
				<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
					{if $myobj->getFormField('mode') == 'add'}
						<input type="submit" class="clsSubmitButton" name="add_submit" id="submit" tabindex="{smartyTabIndex}" value="{$LANG.common_add}" onclick="return updatelengthMine(this.form.descriptions);" />
					{else}
						<input type="submit" class="clsSubmitButton" name="submit" id="submit" tabindex="{smartyTabIndex}" value="{$LANG.common_update}" onclick="return updatelengthMine(this.form.descriptions);" />
					{/if}
					&nbsp;&nbsp;
					<input type="submit" class="clsCancelButton cancel" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" />
				</td>
			</tr>
		</table>
		<input type="hidden" name="bid" value="{$myobj->getFormField('bid')}" />
		<input type="hidden" name="mode" value="{$myobj->getFormField('mode')}" />
	</div>
	</form>
		{if $CFG.feature.jquery_validation}
	    	{literal}
				<script language="javascript" type="text/javascript">
					$Jq("#selFormAskBoard").validate({
						rules: {
							board: {
								required: true
						    },
						    descriptions: {
								required: true
						    }
						},
						messages: {
							board: {
								required: {/literal}"{$LANG.common_err_tip_compulsory}"{literal}
							},
						    descriptions: {
								required: {/literal}"{$LANG.common_err_tip_compulsory}"{literal}
						    }
						}
					});
	        	</script>
	    	{/literal}
		{/if}
{/if}

{if $myobj->isShowPageBlock('show_form_search')}

		 <form name="searchSolutionForm" id="searchSolutionForm" method="post" action="{$myobj->getCUrrentUrl()}" autocomplete="off">
   			 <table class="clsCommonTable" summary="{$LANG.member_tbl_summary}">
				  <tr>
					<td class="{$myobj->getCSSFormLabelCellClass('search_name')}"><label for="search_name">{$LANG.search}</label></td>
					<td class="{$myobj->getCSSFormFieldCellClass('search_name')}">
					  <input type="text" class="clsTextBox" name="search_name" id="search_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('search_name')}" />{$myobj->getFormFieldElementErrorTip('search_name')}</td>
				  </tr>
				  <tr>
					<td class="{$myobj->getCSSFormLabelCellClass('search_cat')}"><label for="search_cat">{$LANG.member_search_cat}</label></td>
					<td class="{$myobj->getCSSFormFieldCellClass('search_cat')}">
					  <select class="clsCommonListBox" name="search_cat" id="search_cat" tabindex="{smartyTabIndex}" >
                        {$myobj->generalPopulateArray($myobj->populateSearchOptions_arr, $myobj->getFormField('search_cat'))}
					  </select>{$myobj->getFormFieldElementErrorTip('search_cat')}
					</td>
				  </tr>
				  <tr>
				  	<td></td>
					<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
						<input type="submit" class="clsSubmitButton" name="go" tabindex="{smartyTabIndex}" value="{$LANG.discuzz_common_go}" />
						&nbsp;
						<input type="reset" class="clsCancelButton" name="reset" tabindex="{smartyTabIndex}" value="{$LANG.discuzz_common_reset}" />
					</td>
				  </tr>
				</table>
				<input type="hidden" name="did" value="{$myobj->getFormField('did')}">
  		</form>

{/if}
{if $myobj->isShowPageBlock('list_records')}

  <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
      <p id="msgConfirmText"></p>
      <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCUrrentUrl()}" autocomplete="off">
        <table class="clsCommonTable" summary="{$LANG.member_tbl_summary}">
          <tr>
            <td>
		 	<input type="submit" class="clsSubmitButton" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
              	&nbsp;
              	<input type="button" class="clsCancelButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks('selManageSolutionForm')" />
              	<input type="hidden" name="act" id="act" />
              	<input type="hidden" name="bid" id="bid" />
              	<input type="hidden" name="board_ids" id="board_id" />
				<input type="hidden" name="sort_act" id="sort_act" value="1" />
				<input type="hidden" name="action" id="action" />
              	<input type="hidden" name="search_name" id="search_name" value="{$myobj->getFormField('search_name')}"/>
              	<input type="hidden" name="search_cat" id="search_cat" value="{$myobj->getFormField('search_cat')}" />
				{$myobj->populateHidden($myobj->list_records_confirm_arr)}
            </td>
          </tr>
        </table>
      </form>
  </div>

    {if $myobj->isResultsFound()}
         <form name="selManageSolutionForm" id="selManageSolutionForm" method="post" action="{$myobj->getCUrrentUrl()}?did={$myobj->getFormField('did')}" autocomplete="off">

            {if $CFG.admin.navigation.top}
                {include file='pagination.tpl'}
            {/if}

        <a href="#" id="dAltMlti"></a>
        <table class="clsCommonTable" summary="{$LANG.member_tbl_summary}" border="1">
          <tr>
            <th>&nbsp;<input type="checkbox" class="clsCheckRadio" id="checkall" onclick="selectAll(this.form)" name="checkall" tabindex="{smartyTabIndex}" /></th>
            <th class="clsBoards{$myobj->getOrderCss('board')}"><a href="#" onclick="return changeOrderbyElements('selManageSolutionForm','board')">{$LANG.board}</a></th>
            <th class="clsTags{$myobj->getOrderCss('tags')}"><a href="#" onclick="return changeOrderbyElements('selManageSolutionForm','tags')">{$LANG.search_type_tags}</a></th>
			<th class="clsMembers{$myobj->getOrderCss('display_name')}"><a href="#" onclick="return changeOrderbyElements('selManageSolutionForm','display_name')">{$LANG.discuzz_common_board_asked_by}</a></th>
            <th class="clsSolutions{$myobj->getOrderCss('total_solutions')}"><a href="#" onclick="return changeOrderbyElements('selManageSolutionForm','total_solutions')">{$LANG.solutions}</a></th>
            <th class="clsAbuse{$myobj->getOrderCss('abuse_count')}"><a href="#" onclick="return changeOrderbyElements('selManageSolutionForm','abuse_count')">{$LANG.common_abuse_count}</a></th>
            <th class="clsPortCount{$myobj->getOrderCss('status')}"><a href="#" onclick="return changeOrderbyElements('selManageSolutionForm','status')">{$LANG.common_status}</a></th>
            <th class="clsDate{$myobj->getOrderCss('board_added')}"><a href="#" onclick="return changeOrderbyElements('selManageSolutionForm','board_added')">{$LANG.member_board_added}</a></th>
            <th>{$LANG.manage}</th>
          </tr>

            {foreach key=lrKey item=lrValue from=$myobj->list_records}
                  <tr>
                    <td class="clsSelectAllMember"><input type="checkbox" class="clsCheckRadio" name="board_ids[]" tabindex="{smartyTabIndex}" value="{$lrValue.board_id}" onClick="disableHeading('selManageSolutionForm');"/></td>
                    <td>
                        <a class="clsUser" href="viewSolutions.php?bid={$lrValue.board_id}&did={$myobj->getFormField('did')}">{$lrValue.board_manual}</a>
                    </td>
                    <td>{$lrValue.tags}</td>
					<td>{$lrValue.display_name_manual}</td>
                    <td>
                        {$lrValue.total_solutions}
                    </td>
                    <td>
                    	{if $lrValue.abuse_count gt 0}
						<a href="manageAbuseContent.php?did={$myobj->getFormField('did')}&bid={$lrValue.board_id}" class="lightwindow" params="lightwindow_width=820">{$lrValue.abuse_count}</a>
						{else}{$lrValue.abuse_count}{/if}
					</td>
                    <td class="clsPortCount">
						{$lrValue.status}
						{if $lrValue.featured eq 'Yes'}
							<p>({$LANG.display_feature})</p>
						{/if}
					</td>
                    <td>
                        {if $lrValue.board_added}
                            {$myobj->getTimeDiffernceFormat($lrValue.board_added)}
                        {/if}
                    </td>
                    <td class="clsEditDeleteBoard">
                      <p>  <a href="manageSolutions.php?bid={$lrValue.board_id}&did={$myobj->getFormField('did')}">{$LANG.common_edit}</a></p>
                    </td>
                  </tr>
            {/foreach}

              <tr>
                <td colspan="9"  class="clsButtonAlignment {$myobj->getCSSFormFieldCellClass('submit')}">
                    <select class="clsCommonListBox" name="action" id="action" tabindex="{smartyTabIndex}" >
                    	<option value="">{$LANG.common_select_action}</option>
                        {$myobj->generalPopulateArray($myobj->action_arr, $myobj->getFormField('action'))}
                  </select>
                  &nbsp;
                  <input type="button" class="clsSubmitButton" name="todo" id="todo" onclick="getMultiCheckBoxValue('selManageSolutionForm', 'checkall', '{$LANG.select_a_board}');if(multiCheckValue!='')getAction()" value="{$LANG.discuzz_common_go}" tabindex="{smartyTabIndex}" />
                </td>
              </tr>
            </table>
			{$myobj->populateHiddenFormFields($myobj->list_records_confirm_arr)}
            {if $CFG.admin.navigation.bottom}
                {include file='pagination.tpl'}
            {/if}
		</form>

    {else}
          <div id="selMsgAlert">
                <p>{$LANG.boards_no_records_found}</p>
          </div>
    {/if}

{/if}
</div>
{literal}
	<script language="javascript" type="text/javascript">
function chkLimit()
	{
		var uploaded_images = document.getElementById("uploaded_images");
		if(uploaded_images == null)
			var d = 0;
		else
			{
				items_uploaded = uploaded_images.getElementsByTagName("img");
				var d  =  items_uploaded.length;
				if(d >= file_upload_limit)
						{
							document.getElementById("image_uploads").style.display = "none";
						}
					else
						{
							document.getElementById("image_uploads").style.display = "block";
						}
		   }

	}
chkLimit();
</script>
{/literal}