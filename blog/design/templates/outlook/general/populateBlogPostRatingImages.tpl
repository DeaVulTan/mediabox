{section name=rating start=1 loop=$populateRatingImages_arr.rating+1 step=1}
	<img src="{$populateRatingImages_arr.bulet_star}" alt="Blog post rating"/>
{/section}
{if $populateRatingImages_arr.condition}
	<a href="{$populateRatingImages_arr.url}" id="ratingLink">
{/if}
{section name=unrating start=$populateRatingImages_arr.rating loop=$populateRatingImages_arr.rating_total step=1}
	<img src="{$populateRatingImages_arr.bulet_star_empty}" alt="Blog post rating"/>
{/section}
{if $populateRatingImages_arr.condition}
</a>
{/if}
