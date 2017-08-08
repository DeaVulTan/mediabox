{if $populateRatingImages_arr.condition}
	<a href="{$populateRatingImages_arr.url}" id="ratingLink" alt="{$smarty.section.rating.index}">
{/if}
{section name=rating start=1 loop=$populateRatingImages_arr.rating+1 step=1}
	{if isMember()}
		<img src="{$populateRatingImages_arr.bulet_star}" alt="{$smarty.section.rating.index}"/>
    {else}
		<img src="{$populateRatingImages_arr.bulet_star}" alt="{$smarty.section.rating.index}" onclick="memberBlockLoginConfirmation('{$LANG.common_rate_login_err_message}','{$populateRatingImages_arr.url}');return false;"/>
	{/if}
{/section}
{section name=unrating start=$populateRatingImages_arr.rating loop=$populateRatingImages_arr.rating_total step=1}
	{if isMember()}
		<img src="{$populateRatingImages_arr.bulet_star_empty}" alt="{$smarty.section.unrating.index_next}"/>
     {else}
		<img src="{$populateRatingImages_arr.bulet_star_empty}" alt="{$smarty.section.unrating.index_next}" onclick="memberBlockLoginConfirmation('{$LANG.common_rate_login_err_message}','{$populateRatingImages_arr.url}');return false;"/>
	{/if}
{/section}
{if $populateRatingImages_arr.condition}
</a>
{/if}
