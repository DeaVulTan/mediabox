{ if $myobj->isPagingRequired()}

<div class="clsPagingList">
<div class="clsPagingListLeft">
<div class="clsPagination">
	<ul>
		<!-- First link -->
		{ if $smarty_paging_list.first.start}
			<li class="clsFirstPage"><a href="{$smarty_paging_list.first.href}" onclick="return {$smarty_paging_list.first.onclick}">{$smarty_paging_list.first.display_text}</a></li>
		{else}
			<li class="clsFirstPageLink">{$smarty_paging_list.first.display_text}</li>
		{/if}
		<!-- Previous link -->
		{ if $smarty_paging_list.previous.start}
			<li class="clsPrevLinkPage"><a href="{$smarty_paging_list.previous.href}" onclick="return {$smarty_paging_list.previous.onclick}">{$smarty_paging_list.previous.display_text}</a></li>
		{else}
			<li class="clsInactivePrevLinkPage">{$smarty_paging_list.previous.display_text}</li>
		{/if}
		<!-- paging list start -->
		{foreach key=key item=start from=$smarty_paging_list.list.start}
			{ if $smarty_paging_list.list.start.$key}
				<li class="clsPagingLink"><a href="{$smarty_paging_list.list.href.$key}" onclick="return {$smarty_paging_list.list.onclick.$key}">{$smarty_paging_list.list.display_text.$key}</a></li>
			{else}
				<li class="clsCurrPageLink clsInActivePageLink">{$smarty_paging_list.list.display_text.$key}</li>
			{/if}
		{/foreach}
		<!-- pagin list end -->
		<!-- Next link -->
		{ if $smarty_paging_list.next.start}
			<li class="clsNextPageLink"><a href="{$smarty_paging_list.next.href}" onclick="return {$smarty_paging_list.next.onclick}">{$smarty_paging_list.next.display_text}</a></li>
		{else}
			<li class="clsInnactiveNextPageLink">{$smarty_paging_list.next.display_text}</li>
		{/if}
		<!-- Last Link -->
		{ if $smarty_paging_list.last.start}
			<li class="clsLastPage"><a href="{$smarty_paging_list.last.href}" onclick="return {$smarty_paging_list.last.onclick}">{$smarty_paging_list.last.display_text}</a></li>
		{else}
			<li class="clsLastPageLink">{$smarty_paging_list.last.display_text}</li>
		{/if}
	</ul>
</div>
</div>
</div>
{/if}