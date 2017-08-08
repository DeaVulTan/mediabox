{if $myobj->isShowPageBlock('solution_rating')}
	{if $myobj->solution_rating.addSolutionRating.rating_link}
		<span class="clsRateSpan">
			<a onmouseover="showRateToolTip('solution_{$myobj->solution_rating.addSolutionRating.solution_id}')" onmouseout="hideRateToolTip('solution_{$myobj->solution_rating.addSolutionRating.solution_id}')" onclick="getRatingDetails('{$myobj->solution_rating.addSolutionRating.rating_url}', '', 'selSolutionsRatingContent{$myobj->solution_rating.addSolutionRating.id_cnt}');">
			 	<img src="{$myobj->solution_rating.addSolutionRating.rate_img}" alt="" />
			</a>
			<div id="solution_{$myobj->solution_rating.addSolutionRating.solution_id}" class="clsDisplayNone">{$myobj->solution_rating.addSolutionRating.alt_text}</div>
			<p><span>{$myobj->solution_rating.addSolutionRating.total_rating}</span> {$LANG.index_rating_lang}</p>
	{else}
		<span class="clsRateSpan">
			<a onmouseover="showRateToolTip('solution_{$myobj->solution_rating.addSolutionRating.solution_id}')" onmouseout="hideRateToolTip('solution_{$myobj->solution_rating.addSolutionRating.solution_id}')" class="clsNoLink" href="javascript:void(0);">
			 	<img src="{$myobj->solution_rating.addSolutionRating.rate_img}" alt="" />
			</a>
			<div id="solution_{$myobj->solution_rating.addSolutionRating.solution_id}" class="clsDisplayNone">{$myobj->solution_rating.addSolutionRating.alt_text}</div>
			<p><span>{$myobj->solution_rating.addSolutionRating.total_rating}</span> {$LANG.index_rating_lang}</p>
	{/if}
{/if}

{if $myobj->isShowPageBlock('board_rating')}
	{if $myobj->board_rating.addBoardRating.rating_link}
	    <span class="clsRateSpan">
			<a onmouseover="showRateToolTip('board_{$myobj->board_rating.addBoardRating.board_id}')" onmouseout="hideRateToolTip('board_{$myobj->board_rating.addBoardRating.board_id}')" onclick="getBoardRatingDetails('{$myobj->board_rating.addBoardRating.rating_url}', '', 'selBoardRatingContent');">
				<img src="{$myobj->board_rating.addBoardRating.rate_img}" alt="" />
			</a>
			<div id="board_{$myobj->board_rating.addBoardRating.board_id}" class="clsDisplayNone">{$myobj->board_rating.addBoardRating.alt_text}</div>
			<p><span>{$myobj->board_rating.addBoardRating.total_rating}</span> {$LANG.index_rating_lang}</p>
	{else}
		<span class="clsRateSpan">
			<a onmouseover="showRateToolTip('board_{$myobj->board_rating.addBoardRating.board_id}')" onmouseout="hideRateToolTip('board_{$myobj->board_rating.addBoardRating.board_id}')" class="clsNoLink" href="javascript:void(0);">
			 	<img src="{$myobj->board_rating.addBoardRating.rate_img}" alt="" />
			</a>
			<div id="board_{$myobj->board_rating.addBoardRating.board_id}" class="clsDisplayNone">{$myobj->board_rating.addBoardRating.alt_text}</div>
			<p><span>{$myobj->board_rating.addBoardRating.total_rating}</span> {$LANG.index_rating_lang}</p>
	{/if}
{/if}