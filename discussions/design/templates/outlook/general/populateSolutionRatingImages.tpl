{if $populateRatingImages_arr.condition}
	<a href="{$populateRatingImages_arr.url}" id="ratingLink{if isset($populateRatingImages_arr.solution_id)}_{$populateRatingImages_arr.solution_id}{/if}">
{/if}
{section name=rating start=1 loop=$populateRatingImages_arr.rating+1 step=1}
	{if isMember()}
		<img src="{$populateRatingImages_arr.bulet_star}" />
	{elseif $myobj->_currentPage == 'index'}
		<img src="{$populateRatingImages_arr.bulet_star}" />
	{else}
		<img src="{$populateRatingImages_arr.bulet_star}" onclick="memberBlockLoginConfirmation('{$LANG.common_rate_login_err_message}','{$populateRatingImages_arr.url}');return false;"/>
	{/if}
{/section}
{section name=unrating start=$populateRatingImages_arr.rating loop=$populateRatingImages_arr.rating_total step=1}
	{if isMember()}
		<img src="{$populateRatingImages_arr.bulet_star_empty}" />
	{elseif $myobj->_currentPage == 'index'}
		<img src="{$populateRatingImages_arr.bulet_star_empty}" />
	{else}
		<img src="{$populateRatingImages_arr.bulet_star_empty}" onclick="memberBlockLoginConfirmation('{$LANG.common_rate_login_err_message}','{$populateRatingImages_arr.url}');return false;" />
	{/if}
{/section}
{if $populateRatingImages_arr.condition}
</a>
{/if}
