<div id="selManageAbuseContent">
	{if $myobj->showTitle}
		<h2>{$LANG.manageabusecontent_title}-<span>{$myobj->board_title}</span></h2>
	{/if}
	{include file='information.tpl'}
	{if $myobj->isShowPageBlock('form_abuse_content')}
		<div id="selShowAbuseContent">
			{if $myobj->form_abuse_content.showAbuseContent_arr}
				<form name="form_abuse_content" id="form_abuse_content" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off">
				{foreach key=mbcKey item=mbcValue from=$myobj->form_abuse_content.showAbuseContent_arr}
					<div class="{$mbcValue.record.oddevenclass}">
						<p class="clsDesc">{$mbcValue.record.reason}</p>
						<p>
							<span>Abused by: {$mbcValue.record.reporter} on {$mbcValue.record.date_abused}</span>
							<span><a href="{$myobj->getCurrentUrl(true)}" onclick="{$mbcValue.record.onclick}; return false;">{$LANG.common_delete}</a></span>
						</p>
					</div>
				{/foreach}
				</form>
			{else}
				<div id="selMsgAlert">
					<p>{$LANG.common_no_records_found}</p>
				</div>
			{/if}
		</div>
	{/if}
	<literal>
		<script type="text/javascript">
			hideSuccessDiv();
		</script>
	</literal>
</div>

