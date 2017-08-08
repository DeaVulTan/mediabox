{if $channel_block_record_count}
<div class="ClsMusicListCarouselContainer">
	<div class="ClsMusicListCarousel">
<div class="clsIndexVideosCategory">
{foreach key=inc item=value from=$videoIndexObj_category->video_channels_category}
<div class="clsMainCategory">
<div class="clsVideoSubCategeroy">
	<h3>{$value.video_category_name} <span>({$value.total_video_count})</span></h3>
</div>
<table class="clsCarouselList">
	{if $value.video_category_id}
		<tr>
			{$videoIndexObj_category->populateCarouselCategoryVideo($value.video_category_id)}
		</tr>
	{/if}
</table>
</div>
{/foreach}
</div>
</div>
</div>
{/if}