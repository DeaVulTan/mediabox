{assign var="iteration" value="0"}
<div id="selListAll" class="clsAskBoardPopup" >

{* if $myobj->discussion_details}
  <div class="clsCategoryView">
	  <ul>
			<li><a href="{$myobj->discussion_title}">{$LANG.discussions}</a></li>
			{assign var=counter value=0}
			{assign var=nextClass value=''}
		  	{foreach key=ckey item=cat_value from=$myobj->category_titles}
		  		{assign var=counter value=$counter+1}
		  		{if $counter gt 4}
		  			<li class="clsImageNone">{$cat_value.cat_url}</li>
				  		</ul>
					  <ul>
		  			{assign var=counter value=0}
					{assign var=nextClass value='clsNextClass'}
		  		{else}
		  			<li class="{$nextClass}">{$cat_value.cat_url}</li>
					{if $nextClass neq ''}{assign var=nextClass value=''}{/if}
				{/if}
		  	{/foreach}

			{if $myobj->getFormField('cid')}
				<li>{$myobj->navigation_details.discussion_url}</li>
				<li>{$myobj->board_details.board_title}</li>
			{else}
				<li>{$myobj->discussion_details.discussion_title}</li>
			{/if}
	  </ul>
  </div>
{/if *}

{include file='../general/information.tpl'}
  <!-- Confirmation Div -->
  	{if $myobj->getFormField('bid')}
  	<div id="selDelInfoconfirm" class="clsPopupConfirmation" style="display:none;">
		<form name="msgInfoConfirmform" id="msgInfoConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
        	<p id="msgInfoConfirmText"></p>
			<p class="clsCenter">
				<input type="button" class="clsPopupsubmit" name="confirm" id="confirm" onclick="deleteBoardAttachments('{$myobj->deleteBoardAttachments_onclick}', '&amp;ajax_page=true&amp;deletemoreattachments=1');chkLimit(); return hideAllBlocks();" value="{$LANG.discuzz_common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
		        <input type="button" class="clsPopupcancel" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks();" />
				<input type="hidden" name="info_id" id="info_id" />
				<input type="hidden" name="board_id" id="board_id" />
				<input type="hidden" name="filename" id="filename" />
				<input type="hidden" name="act" id="act" />
			</p>
      	</form>
  	</div>
	{/if}
  <div id="selShowBoards">
{if $myobj->isShowPageBlock('form_advanced_search')}
<div class="clsCommonIndexRoundedCorner">
  <!--rounded corners-->
{$myobj->setTemplateFolder('general/', 'discussions')}
{include file='box.tpl' opt='topanalyst_top'}
                <div class="clsBoardsLink">
						<h3>{$LANG.advance_search}</h3>
					</div>
			    <form name="formAdvanceSearch" id="formAdvanceSearch" method="post" action="{$myobj->form_advanced_search_arr.form_action}">
			      <div id="moreSearchOptions"  class="clsAdvanceSearchOption">
			        <table summary="{$LANG.discuzz_common_displaying_more_search_options}"  class="clsLoginTable">
	                  <tr>
				            <th colspan="2">{$LANG.discuzz_common_enter_search_options}</th>
				       </tr>
			        <tr>
			            <td class="{$myobj->getCSSFormLabelCellClass('more_boards')}"><label for="more_boards">{$LANG.boards_search_text}</label></td>
			            <td class="{$myobj->getCSSFormFieldCellClass('more_boards')}">{$myobj->getFormFieldErrorTip('more_boards')}
			              <input type="text" class="clsTextBox" name="more_boards" id="more_boards" value="{$myobj->getFormField('more_boards')}" tabindex="{smartyTabIndex}" />
			            </td>
			        </tr>
					<tr>
			            <td class="{$myobj->getCSSFormLabelCellClass('dname')}"><label for="dname">{$LANG.posts_board}</label>
			            </td>
			            <td class="{$myobj->getCSSFormFieldCellClass('dname')}">{$myobj->getFormFieldErrorTip('dname')}
			              <p><input type="text" class="clsTextBox" name="dname" id="dname" value="{$myobj->getFormField('dname')}" tabindex="{smartyTabIndex}" /></p>
						</td>
			        </tr>
			          <tr>
			            <td class="{$myobj->getCSSFormLabelCellClass('with_solution')}"><label for="with_solution">{$LANG.with_solution_text}</label></td>
			            <td class="{$myobj->getCSSFormFieldCellClass('with_solution')}">{$myobj->getFormFieldErrorTip('with_solution')}
			            	<input type="radio" class="clsChechRadio" name="with_solution" tabindex="{smartyTabIndex}" id="with_solution" value="1" {$myobj->form_advanced_search_arr.with_solution_checked}><label for="with_solution">{$LANG.index_solution}</label>
			            	<input type="radio" class="clsChechRadio" name="with_solution" tabindex="{smartyTabIndex}" id="with_solution1" value="2" {$myobj->form_advanced_search_arr.with_no_solution_checked}><label for="with_solution1">{$LANG.index_no_solution}</label>
			            	<input type="radio" class="clsChechRadio" name="with_solution" tabindex="{smartyTabIndex}" id="with_solution2" value="3" {$myobj->form_advanced_search_arr.with_best_solution_checked}><label for="with_solution2">{$LANG.index_best_solutions}</label>
			            </td>
			          </tr>
					  <tr>
			            <td class="{$myobj->getCSSFormLabelCellClass('discussion_category')}"><label for="discussion_category">{$LANG.boards_search_discussion_category}</label>
			            </td>
			            <td class="{$myobj->getCSSFormFieldCellClass('discussion_category')}">{$myobj->getFormFieldErrorTip('discussion_category')}
			            	<select name="discussion_category" id="discussion_category" tabindex="{smartyTabIndex}">
			              		<option value="">{$LANG.search_anywhere}</option>
				                {foreach key=daqkey item=daqvalue from=$myobj->allCategories_arr}
									<option value="{$daqvalue.search_value}" {if $daqvalue.search_value eq $myobj->getFormField('discussion_category')} selected {/if}>
									{section name=tab start=0 loop=$daqvalue.tab}
									  &nbsp;&nbsp;
									{/section}{if $daqvalue.tab gt 0}&rarr;{/if}
								{$daqvalue.search_text}</option>
				                {/foreach}
			              </select>
			            </td>
			          </tr>

			          <tr>
			            <td class="{$myobj->getCSSFormLabelCellClass('total_solution_from')}"><label for="total_solution_from">{$LANG.total_solution_between}</label></td>
			            <td class="{$myobj->getCSSFormFieldCellClass('total_solution_from')}">
			                <input type="text" class="clsCommonNumberTextBox" name="total_solution_from" id="total_solution_from" value="{$myobj->getFormField('total_solution_from')}" tabindex="{smartyTabIndex}" />
			                 {$LANG.and}
			                <input type="text" class="clsCommonNumberTextBox" name="total_solution_to" id="total_solution_to" value="{$myobj->getFormField('total_solution_to')}" tabindex="{smartyTabIndex}" />
							{$myobj->getFormFieldElementErrorTip('total_solution_from')}
						</td>
			          </tr>
			          <tr>
						<td class="{$myobj->getCSSFormLabelCellClass('date_limits_to')}"><label for="date_limits_to">{$LANG.date_limits_to}</label></td>
						<td class="{$myobj->getCSSFormFieldCellClass('date_limits_to')}">{$myobj->getFormFieldErrorTip('date_limits_to')}
						<select name="date_limits_to" id="date_limits_to" tabindex="{smartyTabIndex}">
								{$myobj->generalPopulateArray($myobj->searchOption_arr, $myobj->getFormField('date_limits_to'))}
						</select>
						</td>
					</tr>
					 <tr>
                     	<td class="clsBorderBottomNone"></td>
					 	<td class="{$myobj->getCSSFormFieldCellClass('submitsearch')}" colspan="2">
			              <div id="submitsearch">
			                   <p class="clsSubmitButton"><span>
							    	<input type="submit" class="clsSearchButtonInput" name="adv_search" id="adv_search" value="{$LANG.search}" tabindex="{smartyTabIndex}" />
								</span></p>
							  	<p class="clsCancelButton"><span>
					            	<input type="button" class="clsCancelButtonInput" name="reset" id="reset" onclick="resetSearchCriteria(this.form);" tabindex="{smartyTabIndex}" value="{$LANG.discuzz_common_reset}" />
								</span></p>
			             </div>
						</td>
					 </tr>
			    </table>
			      </div>
				</form>
	{$myobj->setTemplateFolder('general/', 'discussions')}
{include file='box.tpl' opt='topanalyst_bottom'}	     
  <!--end of rounded corners-->
</div>
{/if}

{if $myobj->isShowPageBlock('form_all_boards')}
<!-- top paging div starts -->
	<div class="clsClearFix">
	{if $myobj->isResultsFound()}
	    {if $CFG.admin.navigation.top}
	        {include file='../general/pagination.tpl'}
	    {/if}
	{/if}
		{*<div class="clsPostNew">
		<a class="" href="{$myobj->post_new_link}">
			<span>{$LANG.board_postnew}</span>
		</a>
		</div>*}
		<!-- -->
	</div>
<!-- top paging div ends   -->
<form name="allBoardsFrm" id="allBoardsFrm" method="post" action="">
<div class="clsCommonIndexRoundedCorner">
  <!--rounded corners-->
{$myobj->setTemplateFolder('general/', 'discussions')}
{include file='box.tpl' opt='topanalyst_top'}
					<!-- tabs start -->

                    <div id="selQuickLinks"  class="clsBoardsLink">
                        <h3>
							<span>{$myobj->board_short_title}</span>
                        </h3>
                    </div>
                    <!-- tabs end -->
			        {if $myobj->isResultsFound()}
					 <div class="clsCommonTableContainer clsCommonIndexSection" id = "popular_boards" style="display:block;">
                    <table cellspacing="0" cellpadding="0" class="clsCommonTable">
						  <tr>
		                    <th class="clsIconTittle"><div class="clsIconNewThread"></div></th>
		                    <th class="clsStartByTittle"><span class="{$myobj->getOrderCss('b.board')}"><a href="#" onclick="return changeOrderbyElements('allBoardsFrm','b.board')">{$LANG.index_startedby}</a><span></th>
		                    <th class="clsLastPostTittle"><span class="{$myobj->getOrderCss('b.solution_added')}"><a href="#" onclick="return changeOrderbyElements('allBoardsFrm','b.solution_added')">{$LANG.index_last_posts}</a><span></th>
		                    <th class="clsRepliesTittle"><span class="{$myobj->getOrderCss('b.total_solutions')}"><a href="#" onclick="return changeOrderbyElements('allBoardsFrm','b.total_solutions')">{$LANG.discuzz_common_solutions}</a><span></th>
		                    <th class="clsViewsTittle"><span class="{$myobj->getOrderCss('b.total_views')}"><a href="#" onclick="return changeOrderbyElements('allBoardsFrm','b.total_views')">{$LANG.index_views}</a><span></th>
		                    <th class="clsRatingTittle"><span class="{$myobj->getOrderCss('b.total_stars')}"><a href="#" onclick="return changeOrderbyElements('allBoardsFrm','b.total_stars')"><span class="clsRatingStar">{$LANG.index_ratings}</span></a><span></th>
		                  </tr>
						{foreach key=daqkey item=daqvalue from=$myobj->block_displayAllBoards_arr}
						         <tr class="{if $iteration eq 0}clsOdd{assign var="iteration" value="1"}{elseif $iteration eq 1}clsEven{assign var="iteration" value="0"}{/if}">
                                <td class="clsIconValue {$daqvalue.appendIcon}"><div class="{$daqvalue.legendIcon}"></div></td>
                                <td class="clsStartByValue">
									<p class="clsBoardLink"><span><a href="{$daqvalue.solution.url}">{$daqvalue.row_board_manual}</a>&nbsp;{$daqvalue.bestIcon}</span></p>
                                	<p class="clsAskBy">
										{$LANG.index_by} <a href="{$daqvalue.mysolutions.url}">{$daqvalue.row_asked_by_manual}</a>
                                    	{if $myobj->getFormField('unpublished') AND $myobj->discussion_details.user_id == $CFG.user.user_id}
                                        	&nbsp;-&nbsp;<a href="#" title="{$LANG.publish}" onClick="return Confirmation('selMsgConfirm', 'frmPublishBoard', Array('act', 'board_id', 'confirmation_msg'), Array('publishboard','{$daqvalue.record.board_id}', '{$LANG.publish_board_confirm_message}'), Array('value','value', 'innerHTML'));">{$LANG.publish}</a>
                                    	{/if}
                                    </p>
                                </td>
                                <td class="clsLastPostValue">
                                	{if $daqvalue.last_post_by neq ''}
										<span class="clsLatPostTime">{$daqvalue.last_post_on}</span>
										<p class="clsAskBy"><span class="clsLastAskby">{$LANG.index_by} </span> {$daqvalue.last_post_by}</p>
									{/if}
								</td>
                                <td class="clsRepliesValue">{$daqvalue.record.total_solutions}</td>
                                <td  class="clsViewsValue">{$daqvalue.record.total_views}</td>
                                <td class="clsRatingValue">{$daqvalue.record.rating_count}</td>
                              </tr>
			              {/foreach}
					</table>
					</div>
			    	{else}
			            <div id="selMsgAlert">
			                <p>{$LANG.boards_no_records}</p>
			            </div>
			        {/if}
		{$myobj->setTemplateFolder('general/', 'discussions')}
                {include file='box.tpl' opt='topanalyst_bottom'}		
  <!--end of rounded corners-->
</div>
	<!-- top paging div starts -->
	<div class="clsClearFix">
	{if $myobj->isResultsFound()}
	    {if $CFG.admin.navigation.bottom}
            {include file='../general/pagination.tpl'}
        {/if}
	{/if}
		{*<div class="clsPostNew">
		<a class="" href="{$myobj->post_new_link}">
			<span>{$LANG.board_postnew}</span>
		</a>
		</div>*}
	</div>
	<!-- top paging div ends   -->
	{$myobj->populateHidden($pagingArr)}
	</form>
{/if}
	
</div>

{if $myobj->isShowPageBlock('form_add')}
 <div class="clsCommonIndexRoundedCorner clsClearFix">
  <!--rounded corners-->
 {$myobj->setTemplateFolder('general/', 'discussions')}
 {include file='box.tpl' opt='topanalyst_top'}
				 <div class="clsBoardsLink">
						<h3>
							{$LANG.boards_port_your}
						</h3>
					</div>

{if $myobj->CFG.admin.board.point_notification && $myobj->CFG.admin.ask_solutions.allowed && !$myobj->getFormField('bid')}
		<p class="clsEarnPoint">{$myobj->form_add.askBoards_arr.earn_points_details_info}</p>
	{else}
		<p class="clsEarnPoint">&nbsp;</p>
	{/if}
	<div class="clsInboxReadTbl">
    <form name="selFormAskBoard" id="selFormAskBoard" method="post" action="{$myobj->form_add.askBoards_arr.form_action_url}" autocomplete="off" enctype="multipart/form-data">
      {$myobj->populateHidden($myobj->form_add.askBoards_arr.populateHidden_arr)}
      <table class="clsLoginTable clsSolutionAddBox" summary="{$LANG.boards_port_your}">
        <tr>
          <td class="{$myobj->getCSSFormLabelCellClass('board')}">
              {if $myobj->getFormField('bid')}
                {$LANG.boards_your_board}
              {else}
                <label for="board">{$LANG.boards_enter_board}</label><span class="clsRequired">*</span>
              {/if}
              {$myobj->ShowHelpTip('board')}
          </td>
          <td class="{$myobj->getCSSFormFieldCellClass('board')}">
            {if $myobj->getFormField('bid')}
	             <input type="hidden" class="clsTextBox" name="board" id="board" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('board')}" />
    	         <strong>{$myobj->form_add.askBoards_arr.board_manual}</strong>
            {else}
                 <input type="text" class="clsTextBox {$myobj->getCSSFormFieldElementClass('board')}" name="board" id="board" maxlength="250" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('board')}" />
            {/if}
          {$myobj->getFormFieldElementErrorTip('board')}
          </td>
        </tr>
        <!-- add documents block1 -->
		{if $CFG.admin.attachments_boards.allowed && $CFG.admin.attachments_allowed.count > 0}
        <tr>
          <td class="{$myobj->getCSSFormLabelCellClass('attachments')}" style="border:none;">
            <label for="attachments">{$LANG.boards_your_attachments}</label>
            {$myobj->ShowHelpTip('attachments')}
           </td>
          <td id="tdID" class="{$myobj->getCSSFormFieldCellClass('attachments')}"  style="border:none;">
		<div ></div>
		    <p id="brsBtn"></p>
          <div class="clsDetailsImgUpload">
          <p class="clsFormInfo">{$myobj->form_add.askBoards_arr.attachment_allowed_tip_manual}</p>
          <p class="clsFormInfo">{$myobj->form_add.askBoards_arr.attachment_format_tip_manual}</p>
		  <p class="clsFormInfo">{$myobj->form_add.askBoards_arr.attachment_size_tip_manual}</p>
          </div>
          {if $myobj->getFormField('bid')}
				 <div id="uploaded_images" class="uploadOverflow">
					{foreach key=gAkey item=gAvalue from=$myobj->form_add.askBoards_arr.getAttachments_arr}
					{if (in_array($gAvalue.extern, $CFG.admin.attachments.image_formats))}
                    	<span class="clsAskUploadImg" id="attach_{$gAvalue.record.attachment_id}">
							<div class="clsThumbImageOuter cls90x90thumbImage clsFormAttachImage">
								<div class="clsThumbImageMiddle">
									<div class="clsThumbImageInner">
                        				<a href="{$gAvalue.attachment.url}" id="attachmentcontent{$gAvalue.attachment_id}" ><img src="{$gAvalue.attachment.url_thumb}"  alt="{$gAvalue.record.attachment_name}" /></a>
                                         {literal}
											<script>
                                            $Jq(document).ready(function() {
                                            
                                                            $Jq('#attachmentcontent'+{/literal}{$gAvalue.attachment_id}{literal}).fancybox({
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
                        	<span class=""><a href="#" id="{$gAvalue.anchor}" title="{$LANG.header_remove}" onClick="return Confirmation('selDelInfoconfirm', 'msgInfoConfirmform', Array('act','info_id', 'board_id', 'filename', 'msgInfoConfirmText'), Array('deletemoreattachments','{$gAvalue.record.attachment_id}','{$myobj->getFormField('bid')}', '{$gAvalue.attachment_file_name}', '{$LANG.confirm_remove_info_message}'), Array('value','value','value', 'value','innerHTML'));" class="clsAttachmentRemove"></a></span>
                    	</span>
                    {/if}
					{/foreach}
					{foreach key=gAkey item=gAvalue from=$myobj->form_add.askBoards_arr.getAttachments_arr}
					{if (!in_array($gAvalue.extern, $CFG.admin.attachments.image_formats))}
                    	<span class="clsAskUploadImg" id="attach_{$gAvalue.record.attachment_id}">
            				<span class="clsDocText"><a href="{$gAvalue.attachment.original_url}" target="_blank">{$gAvalue.attachment_name}</a></span>
                        	<span class=""><a href="#" id="{$gAvalue.anchor}" title="{$LANG.header_remove}" onClick="return Confirmation('selDelInfoconfirm', 'msgInfoConfirmform', Array('act','info_id', 'board_id', 'filename', 'msgInfoConfirmText'), Array('deletemoreattachments','{$gAvalue.record.attachment_id}','{$myobj->getFormField('bid')}', '{$gAvalue.attachment_file_name}', '{$LANG.confirm_remove_fileinfo_message}'), Array('value','value','value', 'value','innerHTML'));" class="clsAttachmentRemove"></a></span>
                    	</span>
                    {/if}
					{/foreach}
				</div>
    	  {/if}

          {$myobj->getFormFieldErrorTip('attachments')}
          </td>
        </tr>

       <!-- ends add document block1 -->

       <!-- starts add attachment block1 -->
        <tr>
			<td><!-- --></td>
			<td class="clsFormFieldCellDefault">
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
	   <!-- ends add attachment block1 -->
		<tr>
          <td class="{$myobj->getCSSFormLabelCellClass('descriptions')}"><label for="descriptions">{$LANG.discuzz_common_details}</label>{if $CFG.admin.description.mandatory}<span class="clsRequired">*</span>{/if}
          	{$myobj->ShowHelpTip('board_descriptions', 'descriptions')}
          </td>
          <td class="{$myobj->getCSSFormFieldCellClass('descriptions')}">
		  <div class="clsAdvSolution">
          	<script>edToolbar('descriptions'); </script>
    	  	<textarea class="{$myobj->getCSSFormFieldElementClass('descriptions')} clsSolnTextArea selInputLimiter"  name="descriptions" id="descriptions" cols="15" rows="5" maxlength="{$CFG.admin.description.limit}" tabindex="{smartyTabIndex}" maxlimit="{$myobj->CFG.admin.description.limit}">{$myobj->form_add.askBoards_arr.descriptions_manual}</textarea>
    	  	<a class="clsSolutionTabIncres" href="javascript:makeBigger(0, document.getElementById('descriptions'))" title="{$LANG.smaller_tip}"></a>
			<a class="clsSolutionTabDecres" href="javascript:makeBigger(1, document.getElementById('descriptions'))" title="{$LANG.bigger_tip}"></a>
			</div>
	      	{$myobj->getFormFieldElementErrorTip('descriptions')}
          </td>
        </tr>
        <tr>
          <td class="{$myobj->getCSSFormLabelCellClass('tags')}"><label for="tags">{$LANG.search_type_tags}</label>
          {$myobj->ShowHelpTip('board_tag', 'tags')}
          </td>
          <td class="{$myobj->getCSSFormFieldCellClass('tags')}">
            <input type="text" class="clsTextBox" name="tags" id="tags" maxlength="250" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('tags')}" />
            {$myobj->getFormFieldErrorTip('tags')}
            <p class="clsCaption">{$LANG.boards_subscribe_keywords_info}&nbsp;{$LANG.discuzz_common_tag_size}&nbsp;{$LANG.boards_subscribe_keywords_invalid}</p>
          </td>
        </tr>
        {if $CFG.admin.friends.allowed and $CFG.admin.boards.visibility.needed}
        <tr>
        	<td class="{$myobj->getCSSFormLabelCellClass('visible_to')}"><label for="status_all">{$myobj->LANG.boards_visible_to}</label>
            {$myobj->ShowHelpTip('visible_to')}
            </td>
            <td class="{$myobj->getCSSFormFieldCellClass('visible_to')}">
			<div class="clsRadioBtn">
            	<input type="radio" name="visible_to" id="status_all" value="All" {$myobj->isCheckedRadio('visible_to', 'All')} tabindex="{smartyTabIndex}" />  
				<label for="status_all">{$LANG.discuzz_common_all_option}</label>
                <input type="radio" name="visible_to" id="status_friends" value="Friends" {$myobj->isCheckedRadio('visible_to', 'Friends')} tabindex="{smartyTabIndex}" />  
				<label for="status_friends">{$LANG.discuzz_common_friends_option}</label>
                <input type="radio" name="visible_to" id="status_none" value="None" {$myobj->isCheckedRadio('visible_to', 'None')} tabindex="{smartyTabIndex}" />  
				<label for="status_none">{$LANG.discuzz_common_none_option}</label>
				</div>
                <p class="clsCaption">{$LANG.boards_msg_board_visible_to_help}</p>{$myobj->getFormFieldElementErrorTip('visible_to')}
            </td>
        </tr>
    	{/if}

        {if !$CFG.admin.board_auto_publish.allowed}
            <tr>
            <td class="{$myobj->getCSSFormLabelCellClass('publish')}"><label for="status_yes">{$LANG.board_publish_allsolutions}</label>
            {$myobj->ShowHelpTip('publish')}
            </td>
            <td class="{$myobj->getCSSFormFieldCellClass('publish')}">
                <input type="radio" name="publish" id="status_yes" value="Yes"{$myobj->isCheckedRadio('publish', 'Yes')}  tabindex="{smartyTabIndex}" />
				  <label for="status_yes">{$LANG.discuzz_common_yes_option}</label>
                <input type="radio" name="publish" id="status_no" value="No"{$myobj->isCheckedRadio('publish', 'No')}  tabindex="{smartyTabIndex}" />
				  <label for="status_no">{$LANG.common_no_option}</label>
                {$myobj->getFormFieldErrorTip('publish')}
                <p class="clsCaption">{$LANG.discuzz_common_msg_solution_publish_help}</p>
            </td>
           </tr>
       {/if}

		{if $CFG.admin.read_only_board.allowed}
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('readonly')}"><label for="readonly_no">{$LANG.board_read_only}</label>{$myobj->ShowHelpTip('readonly')}</td>
                <td class="{$myobj->getCSSFormFieldCellClass('readonly')}">
                    <input type="radio" name="readonly" id="readonly_yes" value="Yes"{$myobj->isCheckedRadio('readonly', 'Yes')} tabindex="{smartyTabIndex}" />
					  <label for="readonly_yes">{$LANG.discuzz_common_yes_option}</label>
                    <input type="radio" name="readonly" id="readonly_no" value="No"{$myobj->isCheckedRadio('readonly', 'No')} tabindex="{smartyTabIndex}" />
					  <label for="readonly_no">{$LANG.common_no_option}</label>
                    {$myobj->getFormFieldElementErrorTip('readonly')}
                </td>
            </tr>
		{/if}
        <tr>
		<td></td>
          <td class="clsButtonAlignment {$myobj->getCSSFormFieldCellClass('submit')}" colspan="2">
	        <span id="showProcessDiv" style="display:none;"></span>
			<div id="hideButtons">
			  {if $myobj->getFormField('bid')}
			  <p class="clsSubmitButton">
				<span>
	            <input type="submit" class="clsSearchButtonInput" onclick="return updatelengthMine(this.form.descriptions, 'true');"  name="update_board" id="submit" tabindex="{smartyTabIndex}" value="{$LANG.boards_update_button}" />
				</span></p>
	            <input type="hidden" name="bid" id="bid" value="{$myobj->getFormField('bid')}" />
	          {else}
			   <p class="clsSubmitButton">
				<span>
	            <input type="submit" class="clsSearchButtonInput" onclick="return updatelengthMine(this.form.descriptions, 'true');"  name="submit" id="submit" tabindex="{smartyTabIndex}" value="{$LANG.ask_a_board}" />
				</span>
				</p>
	          {/if}
			  <p class="clsCancelButton">
				<span>
					{if $myobj->getFormField('bid')}
	            		<a href="{$myobj->solutions_url}"><input type="submit" class="clsCancelButtonInput" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" /></a>
	            	{else}
						<a href="{$myobj->boards_url}"><input type="submit" class="clsCancelButtonInput cancel" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" /></a>
	            	{/if}
				</span>
			  </p>
			</div>
          </td>
        </tr>
      </table> </form>
	  </div>
{$myobj->setTemplateFolder('general/', 'discussions')}
{include file='box.tpl' opt='topanalyst_bottom'}
  <!--end of rounded corners-->
</div>
		{if $CFG.feature.jquery_validation}
			{if !$myobj->getFormField('bid')}
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
			{else}
		    	{literal}
					<script language="javascript" type="text/javascript">
						$Jq("#selFormAskBoard").validate({
							rules: {
							    descriptions: {
									required: true
							    }
							},
							messages: {
							    descriptions: {
									required: {/literal}"{$LANG.common_err_tip_compulsory}"{literal}
							    }
							}
						});
		        	</script>
		    	{/literal}
			{/if}
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
<script language="javascript" type="text/javascript">
</script>
{/literal}
