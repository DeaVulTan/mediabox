{if isset($recentDiscussionBoards.row) && ($recentDiscussionBoards.row)}
 <ul>
   {foreach from=$recentDiscussionBoards.row item=detail key=caption}
	 <li class="clsProfileBlockContentList">
			<p class="clsSubscribersInfoTitle">{$detail.boardDetails.board_link}</p>						
			<p class="clsSubscriberDetails">{$LANG.common_publishon} <span>{$detail.boardDetails.pubdate}</span>
			   <span class="clsSubscribeMembersName">by <a href="{$detail.member_profile_url}">{$detail.boardDetails.name}</a></span>
			</p>
	 </li>
   {/foreach}
 </ul>  
{else}
		<div class="clsNoRecordsFound">{$LANG.common_no_records_found}</div>
{/if}
{if isset($recentDiscussionBoards.row) && ($recentDiscussionBoards.row)}
<div class="clsRecentViewAllMain">
	<a href="{$recentDiscussionBoards.boards_url}">{$LANG.common_viewall_boards}</a>
</div>
{/if}
