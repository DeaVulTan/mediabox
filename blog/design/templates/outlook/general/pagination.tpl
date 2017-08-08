{if $myobj->isPagingRequired() && $smarty_paging_list}
<div class="clsPagingList">
	<ul>
		<!-- Previous link -->
		{ if $smarty_paging_list.previous.start}
			<li class="clsPrevLinkPage"><a href="{$smarty_paging_list.first.href}" onclick="return {$smarty_paging_list.first.onclick}"><span>{$smarty_paging_list.first.display_text}</span></a></li>
		{else}
			<li class="clsInactivePrevLinkPage clsInActivePageLink"><span>{$smarty_paging_list.first.display_text}</span></li>
		{/if}
		<!-- First link -->
		{ if $smarty_paging_list.first.start}
			<li class="clsFirstPageLink">
				<a href="{$smarty_paging_list.previous.href}" onclick="return {$smarty_paging_list.previous.onclick}">
					<span>{$smarty_paging_list.previous.display_text}</span>
				</a>
			</li>
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
			<li class="clsLastPageLink"><a href="{$smarty_paging_list.next.href}" onclick="return {$smarty_paging_list.next.onclick}"><span>{$smarty_paging_list.next.display_text}</span></a></li>
		{else}
			<li class="clsLastPageLink clsInActiveLastPageLink"><span>{$smarty_paging_list.next.display_text}</span></li>
		{/if}
		<!-- Next link -->
		{ if $smarty_paging_list.next.start}
			<li class="clsNextPageLink"><a href="{$smarty_paging_list.last.href}" onclick="return {$smarty_paging_list.last.onclick}"><span>{$smarty_paging_list.last.display_text}</span></a></li>
		{else}
			<li class="clsInactiveNextPageLink clsInActivePageLink"><span>{$smarty_paging_list.last.display_text}</span></li>
		{/if}
	</ul>
</div>
{/if}