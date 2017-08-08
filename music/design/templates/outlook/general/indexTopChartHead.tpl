{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audiocontent_top"}
{* CHANGE THE VALUE OF THIS TO MODIFY THE NO OF RECORDS TO BE SHOWN PER PAGE IN THE CAROUSEL *}
{assign var=top_chart_limit_per_page value=4}
<div class="clsIndexTopChart" id="indexTopChartContainer">
<div class="clsJQCarousel" id="indexTopChartTabs">
		<h3 class="clsJQCarouselHead">{$LANG.sidebar_topchart_label}</h3>
        <ul class="clsJQCarouselTabs clsOverflow">
        	{foreach from=$myobj->sidebar_topchart_block.display_order  key=showKey item=showValue}
            {assign var=topchartDivID value=$showValue.divID}
            <li id="{$showValue.divID}_Head">
                <a href="index.php?top_chart_tab={$showValue.divID}&limit={$top_chart_limit_per_page}"><span>{$showValue.lang}</span></a>
            </li>
       		{/foreach}
        </ul>
    </div>
</div>
<script type="text/javascript">
	addLoadingBg('indexTopChartContainer');
	{literal}
	function topChartCarousel_itemLoadCallback(carousel, state)
	{
		var topChart = carousel.options.topChart;
		var top_chart_item = carousel.first;

		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(top_chart_item)) {
            return;
        }

		jQuery.get(
			music_index_ajax_url,
			{
				start: top_chart_item,
				limit: {/literal}{$top_chart_limit_per_page}{literal},
				topChart: topChart
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(top_chart_item, data);
			}
		);
	};

	$Jq(window).load(function(){
		$Jq("#indexTopChartTabs").tabs({
			cache: true
		});
	});
	{/literal}
</script>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audiocontent_bottom"}