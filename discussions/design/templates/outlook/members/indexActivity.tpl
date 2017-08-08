<form name="activitiesFrm" action="" method="post">
	{if $CFG.admin.navigation.top && $CFG.site.script_name != 'index.php' && $activities_count gt $CFG.data_tbl.numpg}
		{include file='../general/pagination.tpl'}
	{/if}
<div class="clsResentActivityContainer clsClearFix">
<!--rounded corners-->
	<!-- tabs start -->
	<div class="clsResentActivityBoardsLink">
		<h3>
			<a id="selRecentBoardsLI" href="#">{$LANG.recent_activities_title}</a>
		</h3>
	</div>
	<div id="selActivities" class="clsCommonIndexSection">
		<div id="selWidgetPopularBoards" class="">
			<table cellspacing="0" cellpadding="0" class="clsResentActivityCommonTable">
				{if $module_total_records gt 0}
					{include file='../members/discuzzActivities.tpl'}
					{$myobj->populateHidden($pagingArr)}
				{else}
					<div class="clsNoRecords">{$LANG.no_recent_activities}</div>
				{/if}
			</table>
			{if $CFG.site.script_name == 'index.php' && $module_total_records gt 0 }
				<div class="clsMoreGreen">
					<span><a href="{$activity_view_all_url}">{$LANG.view_all_link}</a></span>
				</div>
			{/if}
		</div>
	</div>
</div>
	{if $CFG.admin.navigation.bottom && $CFG.site.script_name != 'index.php' && $activities_count gt $CFG.data_tbl.numpg}
		{include file='../general/pagination.tpl'}
	{/if}
</form>