<div id="selDiscussions" class="clsDiscussions">
  <div class="clsDiscussionMyTitleHeading">
    <div class="clsDiscussionTitleHeading">
      <h2 id="selDiscussionTitle">{$LANG.discussions_pagetitle}</h2>
	    <!-- starts confirmation -->
		<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
			<p id="confirmMessage"></p>
			<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
				<table>
					<tr>
						<td>
							<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
							&nbsp;
							<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks();" />
							<input type="hidden" name="discussion_ids" id="forum_ids" />
							<input type="hidden" name="action" id="action" />
							 {$myobj->populateHidden($paging_arr)}
						</td>
					</tr>
				</table>
			</form>
		</div>
		<!-- ends confirmation -->
    </div>
  </div>
  <br>
  {include file='information.tpl'}
  <!-- search form starts -->
   {if $myobj->isShowPageBlock('form_show_search')}
   <form name="formAdvanceSearch" id="formAdvanceSearch" method="post" action="{$myobj->advanced_search_action}">
		<div id="moreSearchOptions">
		  <table summary="{$LANG.common_displaying_more_search_options}">
			<tr>
			  <td class="{$myobj->getCSSFormLabelCellClass('discussion_title')}"><label for="discussion_title">{$LANG.discussion_search_title}</label>
			  </td>
			  <td class="{$myobj->getCSSFormFieldCellClass('discussion_title')}">
				<input type="text" class="clsCommonTextBox" name="discussion_title" id="discussion_title" value="{$myobj->getFormField('discussion_title')}" tabindex="{smartyTabIndex}" />
			  </td>
			</tr>
			<tr>
			  <td class="{$myobj->getCSSFormLabelCellClass('dname')}"><label for="dname">{$LANG.search_username}</label>
			  </td>
			  <td class="{$myobj->getCSSFormFieldCellClass('dname')}">{$myobj->getFormFieldErrorTip('dname')}
				<p>
				  <input type="text" class="clsCommonTextBox" name="dname" id="dname" value="{$myobj->getFormField('dname')}" tabindex="{smartyTabIndex}" />
				</p></td>
			</tr>
			<tr>
	            <td class="{$myobj->getCSSFormLabelCellClass('cat_id')}"><label for="cat_id">{$LANG.discuzz_common_category}</label></td>
	            <td class="{$myobj->getCSSFormFieldCellClass('cat_id')}">
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
			  <td class="{$myobj->getCSSFormLabelCellClass('date_limits_to')}"><label for="date_limits_to">{$LANG.discussion_search_date_limits_to}</label></td>
			  <td class="{$myobj->getCSSFormFieldCellClass('date_limits_to')}"><label for="date_limits_to">{$myobj->getFormFieldErrorTip('date_limits_to')}</label>
				<select name="date_limits_to" id="date_limits_to" tabindex="{smartyTabIndex}">
					{$myobj->generalPopulateArray($myobj->searchOption_arr, $myobj->getFormField('date_limits_to'))}
				</select>
			  </td>
			</tr>
			<tr>
			 	<td></td>
			 	<td>
				 	<input type="submit" class="clsSubmitButton" name="search" id="search" value="{$LANG.search}" tabindex="{smartyTabIndex}" />&nbsp;
				 	<input type="reset" class="clsCancelButton" name="reset" id="reset" value="{$LANG.discuzz_common_reset}" tabindex="{smartyTabIndex}" />
			  </td>
			</tr>
		  </table>
		</div>
	</form>
	{/if}
   <!-- search form ends -->
  {if $myobj->isShowPageBlock('form_show_discussions')}
  	    {if $CFG.admin.navigation.top}
            {include file='../../general/pagination.tpl'}
        {/if}
  	<form name="discussionsFrm" id="discussionsFrm" method="post" action="">
  	   {if $myobj->isResultsFound()}
		<table border="1" {$LANG.discussions_tbl_summary}" class="clsDataDisplaySection">
			<tr>
				<th class="">{$LANG.discussions_title}</th>
				<th class="clsLastPostTittle">{$LANG.discuzz_common_category}</th>
			  	<th class="clsLastPostTittle">{$LANG.discussions_last_post}</th>
			  	<th class="clsViewsTittle">{$LANG.discuzz_common_boards}</th>
			  	<th class="clsTittleSolutions">{$LANG.discuzz_common_solutions}</th>
			  	<th class="clsTittleSolutions">{$LANG.discuzz_common_manage}</th>
			</tr>
       	{foreach key=discussion_key item=discussion_details from=$myobj->form_show_discussions_arr}
            <tr>
				<td>
					<p><span class="clsDiscussionLink"><a href="{$discussion_details.discussionBoards.url}"> {$discussion_details.discussionBoards.title} </a></span></p>
					<p class="clsDiscussionDesc">{$discussion_details.discussion_description_manual}</p>
					<p class="clsAskBy">{$LANG.index_by} <a href="{$discussion_details.myanswers.url}">{$discussion_details.post_name}</a></p>
					{if $discussion_details.user_id == $CFG.user.user_id and $myobj->getFormField('my')}
						<p> {$discussion_details.discussions_unpublished_boards.content}</p>
					{/if}
				</td>
				<td class="clsTotalSolutionsValue">{$discussion_details.category_name}</td>
				<td class="clsLastPostValue">
					{if $discussion_details.last_post_date and $discussion_details.last_post_name neq ''}
						<span class="clsLastPostDate">{$discussion_details.last_post_date_only},</span>
						<span class="clsLatPostTime">{$discussion_details.last_post_time_only}</span>
						<p class="clsAskBy"><span class="clsLastAskby">{$LANG.index_by}</span> <a href="{$discussion_details.lastPost.url}">{$discussion_details.last_post_name1}</a></p>
					{/if}
				</td>
				<td class="clsTotalBoardsValue">{$discussion_details.total_boards}</td>
				<td class="clsTotalSolutionsValue">{$discussion_details.total_solutions}</td>
				<td class="clsTotalSolutionsValue">
					<a href="{$discussion_details.edit.url}">{$LANG.common_edit}</a>&nbsp;&nbsp;
					<a id="anchorDelDiscussion"  href="#" title="{$LANG.common_delete}" onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('action', 'discussion_ids', 'confirmMessage'), Array('deleteDiscussion','{$discussion_details.discussion_id}', '{$LANG.confirm_delete_message}'), Array('value','value', 'innerHTML'));">{$LANG.common_delete}</a>
					<p><a id="anchorDelDiscussion"  href="#" title="{$discussion_details.action_text}" onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('action', 'discussion_ids', 'confirmMessage'), Array('{$discussion_details.action_link}','{$discussion_details.discussion_id}', '{$discussion_details.confirm_msg}'), Array('value','value', 'innerHTML'));">{$discussion_details.action_text}</a></p>
				</td>
			</tr>
        {/foreach}
        </table>
   		{else}
			<div id="selMsgAlert">
				<p>{$LANG.discussions_no_titles}</p>
			</div>
		{/if}

   {/if}
   {$myobj->populateHidden($paging_arr)}
   </form>
   {if $CFG.admin.navigation.bottom}
        {include file='../../general/pagination.tpl'}
   {/if}
 </div>