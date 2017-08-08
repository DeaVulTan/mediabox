{if $myobj->getFormField('show') eq 'selSolutionedBoards'}
	<div id="selWidgetRecentBoards">
		{if !$myobj->form_solution_details.displaySolutionDetails.displaySolutionedBoards.RecordCount}
			<div class="clsNoRecords">
				<p>
					{$LANG.mysolutions_no_solutioned_board}
				</p>
			</div>
		{else}
		 <div class="clsCommonTableContainer" id="recent_board" style="display: block;">
		  <table cellspacing="0" cellpadding="0" class="clsCommonTable">
					 <tr>
                    <th class="clsIconTittle"><div class="clsIconNewThread"></div></th>
                    <th class="clsStartByTittle">{$LANG.index_startedby}</th>
                    <th  class="clsLastPostTittle">{$LANG.index_last_posts}</th>
                    <th  class="clsRepliesTittle">{$LANG.discuzz_common_solutions}</th>
                    <th  class="clsViewsTittle">{$LANG.index_views}</th>
                    <th  class="clsRatingTittle"><span class="clsRatingStar">{$LANG.index_ratings}</span></th>
                  </tr>


				{foreach key=inc item=value from=$myobj->form_solution_details.displaySolutionDetails.displaySolutionedBoards.displayBoards}

                                 <tr>
                                <td class="clsIconValue {$value.boardDetails.appendIcon}"><div class="{$value.boardDetails.legendIcon}"></div></td>
                                <td class="clsStartByValue">
									<p class="clsBoardLink"><span>{$value.boardDetails.board_link}&nbsp;{$value.boardDetails.bestIcon}</span></p>
                                	<p class="clsAskBy">
										{$LANG.mysolutions_posted_on}
										<span class="clsLastPostDate">{$value.boardDetails.board_added_date},</span>
										<span class="clsLatPostTime">{$value.boardDetails.board_added_time}</span>
									</p>
                                </td>
                                <td class="clsLastPostValue">
                                		{if $value.boardDetails.last_post_by neq ''}
                                        <span class="clsLastPostDate">{$value.boardDetails.last_post_date_only},</span>
										 <span class="clsLatPostTime">{$value.boardDetails.last_post_time_only}</span>
										 <p class="clsAskBy"><span class="clsLastAskby">{$LANG.index_by} </span> {$value.boardDetails.last_post_by}</p>
										{/if}</td>
                                <td class="clsRepliesValue">{$value.boardDetails.total_solutions}</td>
                                <td  class="clsViewsValue">{$value.boardDetails.total_views}</td>
                                <td class="clsRatingValue">{$value.boardDetails.total_stars}</td>
                              </tr>

				{/foreach}
			</table>
				{if $myobj->form_solution_details.displaySolutionDetails.displaySolutionedBoards.limit_chk}
					<div class="clsMoreGreen"><span><a href="{$myobj->form_solution_details.displaySolutionDetails.displaySolutionedBoards.boards_url}">{$LANG.common_more}</a></span></div>
				{/if}
			</div>

		{/if}

	</div>
{/if}
{if $myobj->getFormField('show') eq 'selAskedBoards'}
	<div id="selWidgetRecentBoards">
		{if !$myobj->selAskedBoards.displayAskedBoards.RecordCount}
			<div class="clsNoRecords">
				<p>
					{$LANG.mysolutions_no_asked_board}
				</p>
			</div>
		{else}
			 <div class="clsCommonTableContainer" id="recent_board" style="display: block;">
		  <table cellspacing="0" cellpadding="0" class="clsCommonTable">
					 <tr>
                    <th class="clsIconTittle"><div class="clsIconNewThread"></div></th>
                    <th class="clsStartByTittle">{$LANG.index_startedby}</th>
                    <th  class="clsLastPostTittle">{$LANG.index_last_posts}</th>
                    <th  class="clsRepliesTittle">{$LANG.discuzz_common_solutions}</th>
                    <th  class="clsViewsTittle">{$LANG.index_views}</th>
                    <th  class="clsRatingTittle"><span class="clsRatingStar">{$LANG.index_ratings}</span></th>
                  </tr>
				{foreach key=inc item=value from=$myobj->selAskedBoards.displayAskedBoards.displayBoards}
				 <tr>
                                <td class="clsIconValue {$value.boardDetails.appendIcon}"><div class="{$value.boardDetails.legendIcon}"></div></td>
                                <td class="clsStartByValue">
									<p class="clsBoardLink"><span>{$value.boardDetails.board_link}&nbsp;{$value.boardDetails.bestIcon}</span></p>
                                	<p class="clsAskBy">
										{$LANG.mysolutions_posted_on}
										<span class="clsLastPostDate">{$value.boardDetails.board_added_date},</span>
										<span class="clsLatPostTime">{$value.boardDetails.board_added_time}</span>
									</p>
                                </td>
                                <td class="clsLastPostValue">
                                		{if $value.boardDetails.last_post_by neq ''}
                                        <span class="clsLastPostDate">{$value.boardDetails.last_post_date_only},</span>
										 <span class="clsLatPostTime">{$value.boardDetails.last_post_time_only}</span>
										 <p class="clsAskBy"><span class="clsLastAskby">{$LANG.index_by} </span> {$value.boardDetails.last_post_by}</p>
										{/if}</td>
                                <td class="clsRepliesValue">{$value.boardDetails.total_solutions}</td>
                                <td  class="clsViewsValue">{$value.boardDetails.total_views}</td>
                                <td class="clsRatingValue">{$value.boardDetails.total_stars}</td>
                              </tr>

				{/foreach}
			</table>
				{if $myobj->selAskedBoards.displayAskedBoards.RecordCountGTlimit}
				<div class="clsMoreGreen"><span><a href="{$myobj->selAskedBoards.displayAskedBoards.boards_url}">{$LANG.common_more}</a></span></div>
				{/if}
			</div>

		{/if}
	</div>
{/if}
{if	$myobj->getFormField('show') eq 'selFavoriteBoards'}
	<div id="selWidgetRecentBoards">
		{if !$myobj->selFavoriteBoards.displayFavoriteBoards.RecordCount}
			<div class="clsNoRecords">
				<p>
					{$LANG.mysolutions_no_favorite_board}
				</p>
			</div>
		{else}
			 <div class="clsCommonTableContainer" id="recent_board" style="display: block;">
		  <table cellspacing="0" cellpadding="0" class="clsCommonTable">
					 <tr>
                    <th class="clsIconTittle"><div class="clsIconNewThread"></div></th>
                    <th class="clsStartByTittle">{$LANG.index_startedby}</th>
                    <th  class="clsLastPostTittle">{$LANG.index_last_posts}</th>
                    <th  class="clsRepliesTittle">{$LANG.discuzz_common_solutions}</th>
                    <th  class="clsViewsTittle">{$LANG.index_views}</th>
                    <th  class="clsRatingTittle"><span class="clsRatingStar">{$LANG.index_ratings}</span></th>
                  </tr>
				{foreach key=inc item=value from=$myobj->selFavoriteBoards.displayFavoriteBoards.displayBoards}
					<tr>
                                <td class="clsIconValue {$value.boardDetails.appendIcon}"><div class="{$value.boardDetails.legendIcon}"></div></td>
                                <td class="clsStartByValue">
									<p class="clsBoardLink"><span>{$value.boardDetails.board_link}&nbsp;{$value.boardDetails.bestIcon}</span></p>
                                	<p class="clsAskBy">
										{$LANG.mysolutions_posted_on}
										<span class="clsLastPostDate">{$value.boardDetails.board_added_date},</span>
										<span class="clsLatPostTime">{$value.boardDetails.board_added_time}</span>
									</p>
                                </td>
                                <td class="clsLastPostValue">
                                		{if $value.boardDetails.last_post_by neq ''}
                                       <span class="clsLastPostDate">{$value.boardDetails.last_post_date_only},</span>
										 <span class="clsLatPostTime">{$value.boardDetails.last_post_time_only}</span>
										 <p class="clsAskBy"><span class="clsLastAskby">{$LANG.index_by} </span> {$value.boardDetails.last_post_by}</p>
										{/if}</td>
                                <td class="clsRepliesValue">{$value.boardDetails.total_solutions}</td>
                                <td  class="clsViewsValue">{$value.boardDetails.total_views}</td>
                                <td class="clsRatingValue">{$value.boardDetails.total_stars}</td>
                              </tr>
				{/foreach}
			</table>
				{if $myobj->selFavoriteBoards.displayFavoriteBoards.RecordCountGTlimit}
					<div class="clsMoreGreen"><span><a href="{$myobj->selFavoriteBoards.displayFavoriteBoards.boards_url}">{$LANG.common_more}</a></span></div>
				{/if}
			</div>
		{/if}
	</div>
{/if}