{ if $myobj->isPagingRequired()}
<div class="clsPagingList">
	<ul>
		<!-- Previous link -->
		{ if $smarty_paging_list.previous.start}
			<li class="clsPrevLinkPage"><a href="{$smarty_paging_list.first.href}" onclick="return {$smarty_paging_list.first.onclick}">{$smarty_paging_list.first.display_text}</a></li>
		{else}
			<li class="clsInactivePrevLinkPage clsInActivePageLink">{$smarty_paging_list.first.display_text}</li>
		{/if}
		<!-- First link -->
		{ if $smarty_paging_list.first.start}
			<li class="clsFirstPageLink"><a href="{$smarty_paging_list.previous.href}" onclick="return {$smarty_paging_list.previous.onclick}">{$smarty_paging_list.previous.display_text}</a></li>
		{else}
			<li class="clsFirstPageLink clsInActivePageLink">{$smarty_paging_list.previous.display_text}</li>
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
		<!-- Last Link -->
		{ if $smarty_paging_list.last.start}
			<li class="clsLastPageLink"><a href="{$smarty_paging_list.next.href}" onclick="return {$smarty_paging_list.next.onclick}">{$smarty_paging_list.next.display_text}</a></li>
		{else}
			<li class="clsLastPageLink clsInActivePageLink">{$smarty_paging_list.next.display_text}</li>
		{/if}
		<!-- Next link -->
		{ if $smarty_paging_list.next.start}
			<li class="clsNextPageLink"><a href="{$smarty_paging_list.last.href}" onclick="return {$smarty_paging_list.last.onclick}">{$smarty_paging_list.last.display_text}</a></li>
		{else}
			<li class="clsInactiveNextPageLink clsInActivePageLink">{$smarty_paging_list.last.display_text}</li>
		{/if}
	</ul>
</div>
{/if}