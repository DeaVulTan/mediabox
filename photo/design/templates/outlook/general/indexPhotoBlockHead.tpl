{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="indexphotomain_top"}
<script language="javascript" type="text/javascript">
var photo_tabs_divid_array = new Array();
var module_name_js="photo";
</script>
{* CHANGE THE VALUE OF THIS TO MODIFY THE NO OF RECORDS TO BE SHOWN PER PAGE IN THE CAROUSEL *}
{assign var=photo_limit_per_page value=4}
<div class="clsIndexPhotoContainer">
	<div class="clsJQCarousel" id="photoListTabs">
		<h3 class="clsJQCarouselHead">{$LANG.sidebar_photo_label}</h3>
        <ul class="clsJQCarouselTabs clsOverflow">
        	<li id="mostrecentphoto_Head"><a href="index.php?showtab=mostrecentphoto&limit={$photo_limit_per_page}"><span>{$LANG.sidebar_photo_most_recent}</span></a></li>
        	{*<li id="recommendedphoto_Head"><a href="index.php?showtab=recommendedphoto&limit={$photo_limit_per_page}"><span>{$LANG.sidebar_recommended_label}</span></a></li>
        	<li id="mostfavoritephoto_Head"><a href="index.php?showtab=mostfavoritephoto&limit={$photo_limit_per_page}"><span>{$LANG.sidebar_photo_most_favorite}</span></a></li>*}
            <li id="topratedphoto_Head"><a href="index.php?showtab=topratedphoto&limit={$photo_limit_per_page}"><span>{$LANG.sidebar_top_rating_label}</span></a></li>
        </ul>
    </div>
</div>
<script type="text/javascript">
	var photo_index_ajax_url = '{$CFG.site.photo_url}index.php';

	{literal}
	function photocarousel_itemLoadCallback(carousel, state)
	{
		var block = carousel.blockName();
		var i = carousel.first;

		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(i)) {
            return;
        }

		jQuery.get(
			photo_index_ajax_url,
			{
				start: i,
				limit: {/literal}{$photo_limit_per_page}{literal},
				block: block
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(i, data);
			}
		);
	};

	$Jq(window).load(function(){
		attachJqueryTabs('photoListTabs');
	});
	{/literal}
</script>
{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="indexphotomain_bottom"}