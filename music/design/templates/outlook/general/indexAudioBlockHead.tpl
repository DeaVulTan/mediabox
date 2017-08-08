{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audiocontent_top"}
{* CHANGE THE VALUE OF THIS TO MODIFY THE NO OF RECORDS TO BE SHOWN PER PAGE IN THE CAROUSEL *}
{assign var=music_limit_per_page value=4}
<div class="clsIndexAudioContainer" id="indexAudioContainer">
    <div class="clsJQCarousel" id="musicListTabs">
		<h3 class="clsJQCarouselHead">{$LANG.sidebar_audio_label}</h3>
        <ul class="clsJQCarouselTabs clsOverflow">
            <li id="newmusic_Head"><a href="index.php?showtab=newmusic&limit={$music_limit_per_page}" title="{$LANG.sidebar_recently_upldated_label}"><span>{$LANG.sidebar_recently_upldated_label}</span></a></li>
            <li id="topratedmusic_Head"><a href="index.php?showtab=topratedmusic&limit={$music_limit_per_page}" title="{$LANG.sidebar_top_rating_label}"><span>{$LANG.sidebar_top_rating_label}</span></a></li>
        </ul>
    </div>
</div>
<script type="text/javascript">
	var music_index_ajax_url = '{$CFG.site.music_url}index.php';
	addLoadingBg('indexAudioContainer');
	{literal}
	function musiccarousel_itemLoadCallback(carousel, state)
	{
		var block = carousel.blockName();
		var i = carousel.first;

		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(i)) {
            return;
        }

		jQuery.get(
			music_index_ajax_url,
			{
				start: i,
				limit: {/literal}{$music_limit_per_page}{literal},
				block: block
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(i, data);
			}
		);
	};

	$Jq(window).load(function(){
		attachJqueryTabs('musicListTabs');
	});
	{/literal}
</script>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audiocontent_bottom"}