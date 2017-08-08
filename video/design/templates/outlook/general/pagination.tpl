{if $myobj->isPagingRequired() && $smarty_paging_list}
<div class="clsPagingList">
	<ul>
		<!-- Previous link -->
		{ if $smarty_paging_list.previous.start}
			<li class="clsPrevLinkPage"><span><a href="{$smarty_paging_list.first.href}" title="{$LANG.common_paging_first}" onclick="return {$smarty_paging_list.first.onclick}">{$smarty_paging_list.first.display_text}</a></span></li>
		{else}
			<li class="clsInactivePrevLinkPage clsInActivePageLink"><span>{$smarty_paging_list.first.display_text}</span></li>
		{/if}
		<!-- First link -->
		{ if $smarty_paging_list.first.start}
			<li class="clsFirstPageLink"><span><a href="{$smarty_paging_list.previous.href}" title="{$LANG.common_paging_previous}" onclick="return {$smarty_paging_list.previous.onclick}">{$smarty_paging_list.previous.display_text}</a></span></li>
		{else}
			<li class="clsFirstPageLink clsInActiveFirstPageLink"><span>{$smarty_paging_list.previous.display_text}</span></li>
		{/if}
		<!-- paging list start -->
		{foreach key=key item=start from=$smarty_paging_list.list.start}
			{ if $smarty_paging_list.list.start.$key}
				<li class="clsPagingLink"><a href="{$smarty_paging_list.list.href.$key}" onclick="return {$smarty_paging_list.list.onclick.$key}">{$smarty_paging_list.list.display_text.$key}</a></li>
			{else}
				<li class="clsCurrPageLink clsInActivePageLink"><span>{$smarty_paging_list.list.display_text.$key}</span></li>
			{/if}
		{/foreach}
		<!-- pagin list end -->
		<!-- Last Link -->
		{ if $smarty_paging_list.last.start}
			<li class="clsLastPageLink"><span><a href="{$smarty_paging_list.next.href}" title="{$LANG.common_paging_next}" onclick="return {$smarty_paging_list.next.onclick}">{$smarty_paging_list.next.display_text}</a></span></li>
		{else}
			<li class="clsLastPageLink clsLastInActivePageLink"><span>{$smarty_paging_list.next.display_text}</span></li>
		{/if}
		<!-- Next link -->
		{ if $smarty_paging_list.next.start}
			<li class="clsNextPageLink"><span><a href="{$smarty_paging_list.last.href}" title="{$LANG.common_paging_last}" onclick="return {$smarty_paging_list.last.onclick}">{$smarty_paging_list.last.display_text}</a></span></li>
		{else}
			<li class="clsInactiveNextPageLink clsInActivePageLink"><span>{$smarty_paging_list.last.display_text}</span></li>
		{/if}
	</ul>
</div>
{/if}