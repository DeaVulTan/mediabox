{assign var="iteration" value="0"}
<div id="selDiscussions" class="clsDiscussions">
	<!--<div class="clsDiscussionView">
		<ul>
		  	<li class="clsNoArrow">{$myobj->discussions_pagetitle}</li>
			{assign var=counter value=0}
			{assign var=nextClass value=''}
		  	{foreach key=ckey item=cat_value from=$myobj->category_titles}
		  		{assign var=counter value=$counter+1}
		  		<li class="{$nextClass}">{$cat_value.cat_url}</li>
		  		{if $counter gt 4}
				  		</ul>
					  <ul>
		  			{assign var=counter value=0}
		  			{assign var=nextClass value='clsNextClass'}
				{/if}
		  	{/foreach}
		</ul>
	</div>-->
  	{include file='../general/information.tpl'}
  	{if $myobj->isShowPageBlock('form_show_discussions')}
	{foreach key=catkey item=catdetails from=$myobj->showDiscussionTitles}
		<div class="clsCommonIndexRoundedCorner clsClearFix">
			<div class="clsCommonTopAnalystRoundedCorner">
		  	<!--rounded corners-->
		 	{$myobj->setTemplateFolder('general/', 'discussions')}
            {include file='box.tpl' opt='topanalyst_top'}
				<!-- tabs start -->
				<div class="clsBoardsLink">
					<h3>
						<a href="{$myobj->getCurrentUrl()}" onclick="Effect.toggle('recently_solutioned{$catdetails.cat_id}', 'BLIND'); return false;" title="{$LANG.click_here_show_hide}">{$catdetails.cat_name}</a>
					</h3>
				</div>
				<!-- tabs end -->
				<div class="clsCommonTableContainer" id="recently_solutioned{$catdetails.cat_id}" style="display: block;">
				<table summary="{$LANG.discussions_tbl_summary}" class="clsCommonTable">
				{if $catdetails.subforum_titles OR $catdetails.discussion_titles}
					<tr>
						<th class="clsIconTittle"> <div class="clsIconDiscussion"></th>
						<th class="">{$LANG.discussions_title}</th>
						<th class="clsLastPostTittle">{$LANG.discussions_last_post}</th>
						<th class="clsViewsTittle">{$LANG.discuzz_common_boards}</th>
						<th class="clsTittleSolutions">{$LANG.discuzz_common_solutions}</th>
					</tr>
					{if isset($catdetails.subforum_titles) AND $catdetails.subforum_titles}
							{foreach key=discussion_key item=subforum_titles from=$catdetails.subforum_titles}
								 <tr class="{if $iteration eq 0}clsOdd{assign var="iteration" value="1"}{elseif $iteration eq 1}clsEven{assign var="iteration" value="0"}{/if}">
									<td class="clsIconValue"><div class="clsIconDiscussion"></div></td>
									<td>
										<p><span class="clsDiscussionLink"><a href="{$subforum_titles.subforum.url}"> {$subforum_titles.cat_name} </a></span></p>
										<p>{$subforum_titles.category_description_manual}</p>
									</td>
									<td class="clsLastPostValue">
									{if $subforum_titles.last_post_date and $subforum_titles.last_post_name neq ''}
										<span class="clsLastPostDate">{$subforum_titles.last_post_date_only},</span>
										<span class="clsLatPostTime">{$subforum_titles.last_post_time_only}</span>
										<p class="clsAskBy"><span class="clsLastAskby">{$LANG.index_by}</span> <a href="{$subforum_titles.lastPost.url}">{$subforum_titles.last_post_name1}</a></p>
									{/if}
									</td>
									<td class="clsTotalBoardsValue">{$subforum_titles.total_boards}</td>
									<td class="clsTotalSolutionsValue">{$subforum_titles.total_solutions}</td>
								</tr>
							{/foreach}
					{/if}
					{if isset($catdetails.discussion_titles) AND $catdetails.discussion_titles}
						{foreach key=discussion_key item=discussion_details from=$catdetails.discussion_titles}
							 <tr class="{if $iteration eq 0}clsOdd{assign var="iteration" value="1"}{elseif $iteration eq 1}clsEven{assign var="iteration" value="0"}{/if}">
								<td class="clsIconValue"><div class="clsIconDiscussion"></div></td>
								<td>
									<p><span class="clsDiscussionLink"><a href="{$discussion_details.discussionBoards.url}"> {$discussion_details.discussionBoards.title} </a></span></p>
									<p class="clsDiscussionDesc">{$discussion_details.discussion_description_manual}</p>
									<p class="clsAskBy">{$LANG.index_by} <a href="{$discussion_details.myanswers.url}">{$discussion_details.post_name}</a></p>
									 {if $discussion_details.user_id == $CFG.user.user_id and $myobj->getFormField('my')}
										<p> {$discussion_details.discussions_unpublished_boards.content}</p>
									 {/if}
								</td>
								<td class="clsLastPostValue">
									{if $discussion_details.last_post_date and $discussion_details.last_post_name neq ''}
										<span class="clsLastPostDate">{$discussion_details.last_post_date_only},</span>
										<span class="clsLatPostTime">{$discussion_details.last_post_time_only}</span>
										<p class="clsAskBy"><span class="clsLastAskby">{$LANG.index_by}</span> <a href="{$discussion_details.lastPost.url}">{$discussion_details.last_post_name1}</a></p>
									{/if}
								</td>
								<td class="clsTotalBoardsValue">{$discussion_details.total_boards}</td>
								<td class="clsTotalSolutionsValue">{$discussion_details.total_solutions}</td>
							</tr>
						{/foreach}
					{/if}
				{else}
					<div id="selMsgAlert">
						<p>{$LANG.discussions_no_titles}. {if $CFG.admin.discussions.add_title}<a class="clsPostNewData" href="{$myobj->discussionsAddTitle_url}">{$LANG.click_here_to_post_new_discussion}</a>{/if}</p>
					</div>
				{/if}
				</table>
				</div>
			{$myobj->setTemplateFolder('general/', 'discussions')}
            {include file='box.tpl' opt='topanalyst_bottom'}								
		  	<!--end of rounded corners-->
			</div>
		</div>
	{foreachelse}
		<div id="selMsgAlert">
			<p>{$LANG.discussions_no_titles}. {if $CFG.admin.discussions.add_title}<a class="clsPostNewData" href="{$myobj->discussionsAddTitle_url}">{$LANG.click_here_to_post_new_discussion}</a>{/if}</p>
		</div>
	{/foreach}
	{/if}
</div>