{assign var="iteration" value="0"}
{if !isAjax()}
<div id="selIndex">
{/if}
	{include file='../general/information.tpl'}
	{if  $myobj->isShowPageBlock('form_best_solution')}
		<div id="selWidget">
		   	<div class="clsCommonIndexRoundedCorner"> <!--rounded corners-->
				{$myobj->setTemplateFolder('general/', 'discussions')}
                {include file='box.tpl' opt='bestsolution_top'}
                	<!-- tabs start -->
					<div class="clsBestBoardLink">
						<h3>
							<span id="selBestBoardsLI" class="clsBestSolutions">{$LANG.discuzz_common_best_boards}</span>
						</h3><span id="paginate-slider1" class="pagination" ></span>
					</div>
					<!-- tabs end -->
 					<div class="clsIndexPopular">
  						<div class="" id="sliderbestSolutions">
							{if $myobj->form_best_solution.displayBestSolutions.recent_boards}

								<div id="slider1" class="sliderwrapper">
									<div class="contentdiv">
									{foreach key=inc item=value from=$myobj->form_best_solution.displayBestSolutions.row}
									{if isset($value.boardDetails)}
											<div class="clsBestSolutionContainer">
												<div class="clsBestSolutionContent">
											  		<p class="clsPNGImage"><span class="clsBestLink">{$value.boardDetails.best_board_link}</span> -
													  <span class="clsBestPostedBy">{$LANG.index_posted_by} {$value.boardDetails.asked_by_link}</span>
 													  <span class="clsRatingBlock">{$discussion->populateBoardRatingImages($value.boardDetails.rating_count, 'board','', '#', 'discussions')}{$value.boardDetails.rating_count} {$LANG.index_ratings}</span>
                                                      <!--<span class="clsRatingDefault"></span>-->
													</p>


													<p class="clsSolutionContainer"><span class="clsSolution">{$LANG.index_solution}:</span> {$value.wordWrapManual_solution|truncate:70}<span class="clsSolutionMore"> <a href="{$value.solution_url}">{$LANG.common_more}</a></span></p>
													<p class="">
                                                    <span class="clsAddedBy">{$LANG.index_added_by} {$value.solutionDetails.solutioned_by_link} {$LANG.index_on}
                                                    {$myobj->getTimeDiffernceFormat($value.solutionDetails.solution_added)}</span>
                                                    <span class="clsRatingBlock">{$discussion->populateSolutionRatingImages($value.solutionDetails.rating_count, 'solution','', '#', 'discussions',$value.solutionDetails.solution_id)}{$value.solutionDetails.rating_count} {$LANG.index_ratings}</span>
                                                   <!-- <span class="clsRatingGreen"></span>-->

                                                    </p>
												</div>

                                            </div>
								  		{if $value.incr mod $CFG.admin.index.best_ans_boards_display_count eq '0'}
								  			{if $myobj->form_best_solution.displayBestSolutions.total_recs gt $value.incr}
										  		</div>
												<div class="contentdiv">
											{/if}
										{/if}
									{/if}
						 			{/foreach}
						 				</div>
								</div>
								<div id="pag" class="pagination"></div>
								{if  $myobj->form_best_solution.displayBestSolutions.have_boards}
									<div class="clsMoreGreen"> <span><a href="{$myobj->form_best_solution.displayBestSolutions.boards_url}">{$LANG.discuzz_common_more_best_solutions}</a></span>
                                    </div>
								{/if}
							{/if}
							{if !$myobj->form_best_solution.displayBestSolutions.have_boards}
								<div class="clsNoRecords"><p>{$LANG.discuzz_common_no_best_boards}</p></div>
							{/if}
						</div>
					</div>
				{$myobj->setTemplateFolder('general/', 'discussions')}
                {include file='box.tpl' opt='bestsolution_bottom'}
		   	</div> <!--end of rounded corners-->
		</div>
	{/if}
	{if  $myobj->isShowPageBlock('form_top_discussion')}
	<div class="clsCommonIndexRoundedCorner clsClearFix">
	{$myobj->setTemplateFolder('general/', 'discussions')}
     {include file='box.tpl' opt='topanalyst_top'}
	<div class="clsBoardsLink">
		<h3>
			<a id="selTopDiscussionsLI" href="{$myobj->getCurrentUrl()}" onclick="$Jq('#selTopDiscussions').toggle('slow'); return false;" title="{$LANG.click_here_show_hide}">{$LANG.discuzz_common_top_discussions_title}</a>
		</h3>
	</div>
	<div id="selTopDiscussions" class="clsCommonIndexSection" {$myobj->form_top_discussion.topdiscussionQStyle}>
		<div id="selWidgetTopdiscussions" class="">
			{if $myobj->form_top_discussion.displayTopDiscussions}
                <div class="clsCommonTableContainer" id="top_discussions" style="display: block;">
                <table cellspacing="0" cellpadding="0" class="clsCommonTable">
					  <tr>
	                    <th class="clsIconTittle"><div class="clsIconDiscussion"></div></th>
	                    <th class="clsStartByTittle">{$LANG.index_startedby}</th>
	                    <th  class="clsLastPostTittle">{$LANG.index_last_posts}</th>
	                    <th  class="clsViewsTittle">{$LANG.discuzz_common_boards}</th>
	                    <th  class="clsRepliesTittle">{$LANG.discuzz_common_solutions}</th>
	                  </tr>
					{foreach key=inc item=value from=$myobj->form_top_discussion.displayTopDiscussions}
                       <tr class="{if $iteration eq 0}clsOdd{assign var="iteration" value="1"}{elseif $iteration eq 1}clsEven{assign var="iteration" value="0"}{/if}">
							<td class="clsIconValue"><div class="clsIconDiscussion"></div></td>
    	                    <td class="clsStartByValue"><p class="clsBoardLink"><span class=""><a href="{$value.discussionBoards.url}"> {$value.discussionBoards.title}</a>&nbsp;</span></p>
                          	<p class="clsAskBy">{$LANG.index_by}&nbsp;<a href="{$value.myanswers.url}">{$value.post_name}</a></p>
                            </td>
                            <td class="clsLastPostValue">
                            {if $value.last_post_user neq ''}
                              <span class="clsLastPostDate">{$value.last_post_date_only},</span>
							  <span class="clsLatPostTime">{$value.last_post_time_only}</span>
							  <p class="clsAskBy"><span class="clsLastAskby">{$LANG.index_by} </span> <a href="{$value.lastPost.url}">{$value.last_post_user}</a></p>
							{/if}
							</td>
                            <td class="clsViewsValue">{$value.total_boards}</td>
							<td class="clsRepliesValue">{$value.total_solutions}</td>
                        </tr>
					{/foreach}
 				</table>
					{if $myobj->form_top_discussion.displayTopDiscussions}
                        <div class="clsMoreGreen"><span><a href="{$myobj->form_top_discussion.discussions_url}">{$LANG.discuzz_common_more_top_discussion}</a></span></div>
					{/if}
                    </div>
				{/if}
				{if !$myobj->form_top_discussion.displayTopDiscussions}
             		<div class="clsNoRecords"><p>{$LANG.discuzz_common_no_dicussions_added}</p>
					</div>
				{/if}
            </div>
		</div>
		{$myobj->setTemplateFolder('general/', 'discussions')}
                {include file='box.tpl' opt='topanalyst_bottom'}
		</div>
	{/if}

	{if  $myobj->isShowPageBlock('form_recent_boards')}
		{if !isAjax()}
        	<div class="clsCommonIndexRoundedCorner clsClearFix clsIndexBoardContainer">
          	<!--rounded corners-->
    			{$myobj->setTemplateFolder('general/', 'discussions')}
                {include file='box.tpl' opt='topanalyst_top'}
					<!-- tabs start -->
					<div class="clsBoardsLink clsIndexBoardsHead">
						<h3>
							<a id="selRecentBoardsLI" href="{$myobj->getCurrentUrl()}" onclick="$Jq('#selRecentBoards').toggle('slow'); return false;" title="{$LANG.click_here_show_hide}">{$LANG.discuzz_common_recent_board_title}</a>
						</h3>
					</div>
					<!-- tabs end -->
		{/if}
	{/if}

	{if  $myobj->isShowPageBlock('form_recent_boards') || $myobj->isShowPageBlock('form_popular_boards')}
		<div id="selRecentBoards" class="clsCommonIndexSection" {$myobj->form_recent_boards.recentQStyle}>
                <ul class="clsJQCarouselTabs clsOverflow clsOtherTabs clsIndexBoardsTab">
                    {if  $myobj->isShowPageBlock('form_recent_boards')}
                    <li><a href="#selWidgetRecentBoards"><span class="clsOuter"><span class="clsForums">{$LANG.discuzz_common_recent_board_title}</span></span></a></li>
                    {/if}
                    {if  $myobj->isShowPageBlock('form_popular_boards')}
                    <li><a href="#selWidgetPopularBoards"><span class="clsOuter"><span class="clsBlogs">{$LANG.discuzz_common_popular_board_title}</span></span></a></li>
                    {/if}
                </ul>
                {if  $myobj->isShowPageBlock('form_recent_boards')}
                    <div id="selWidgetRecentBoards" class="clsClearLeft">
                        {if $myobj->form_recent_boards.displayRecentBoards.recent_boards}
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
        
                                    {foreach key=inc item=value from=$myobj->form_recent_boards.displayRecentBoards.row}
        
                                              <tr class="{if $iteration eq 0}clsOdd{assign var="iteration" value="1"}{elseif $iteration eq 1}clsEven{assign var="iteration" value="0"}{/if}">
                                        <td class="clsIconValue {$value.boardDetails.appendIcon}"><div class="{$value.boardDetails.legendIcon}"></div></td>
                                        <td class="clsStartByValue"><p class="clsBoardLink"><span  class="">{$value.boardDetails.board_link}&nbsp;{$value.boardDetails.bestIcon}</span></p>
                                                                    <p class="clsAskBy">{$LANG.index_by} {$value.boardDetails.asked_by_link}</p>
                                        </td>
                                        <td class="clsLastPostValue">
                                                {if $value.boardDetails.last_post_by neq ''}
                                                 <span class="clsLastPostDate">{$value.boardDetails.last_post_date_only},</span>
                                                 <span class="clsLatPostTime">{$value.boardDetails.last_post_time_only}</span>
                                                 <p class="clsAskBy"><span class="clsLastAskby">{$LANG.index_by} </span> {$value.boardDetails.last_post_by}</p>
                                                {/if}</td>
                                        <td class="clsRepliesValue">{$value.boardDetails.total_solutions}</td>
                                        <td  class="clsViewsValue">{$value.boardDetails.total_views}</td>
                                        <td class="clsRatingValue">{$value.boardDetails.rating_count}</td>
                                      </tr>
                                    {/foreach}
                        </table>
        
                            {if $myobj->form_recent_boards.displayRecentBoards.have_boards}
        
                                        <div class="clsMoreGreen"><span><a href="{$myobj->form_recent_boards.displayRecentBoards.boards_url}">{$LANG.discuzz_common_more_recent_boards}</a></span></div>
                            {/if}
                            </div>
                        {/if}
                        {if !$myobj->form_recent_boards.displayRecentBoards.have_boards}
                            <div class="clsNoRecords"><p>{$LANG.discuzz_common_no_recent_boards}</p>
                            </div>
                        {/if}
        
        
                    </div>
            	{/if}
                {if  $myobj->isShowPageBlock('form_popular_boards')}
                    <div id="selWidgetPopularBoards" class="clsClearLeft">
                            {if $myobj->form_popular_boards.displayPopularBoards.popular_boards}
                            <div class="clsCommonTableContainer" id = "popular_boards" style="display:block;">
                            <table cellspacing="0" cellpadding="0" class="clsCommonTable">
                                  <tr>
                            <th class="clsIconTittle"><div class="clsIconNewThread"></div></th>
                            <th class="clsStartByTittle">{$LANG.index_startedby}</th>
                            <th  class="clsLastPostTittle">{$LANG.index_last_posts}</th>
                            <th  class="clsRepliesTittle">{$LANG.discuzz_common_solutions}</th>
                            <th  class="clsViewsTittle">{$LANG.index_views}</th>
                            <th  class="clsRatingTittle"><span class="clsRatingStar">{$LANG.index_ratings}</span></th>
                          </tr>
        
        
                                    {foreach key=inc item=value from=$myobj->form_popular_boards.displayPopularBoards.row}
        
                                        <tr class="{if $iteration eq 0}clsOdd{assign var="iteration" value="1"}{elseif $iteration eq 1}clsEven{assign var="iteration" value="0"}{/if}">
										
                                        <td class="clsIconValue {$value.boardDetails.appendIcon}"><div class="{$value.boardDetails.legendIcon}"></div></td>
                                        <td class="clsStartByValue"><p class="clsBoardLink"><span>{$value.boardDetails.board_link}&nbsp;{$value.boardDetails.bestIcon}</span></p>
                                                                    <p class="clsAskBy">{$LANG.index_by} {$value.boardDetails.asked_by_link}</p>
                                        </td>
                                        <td class="clsLastPostValue">
                                                {if $value.boardDetails.last_post_by neq ''}
                                                <span class="clsLastPostDate">{$value.boardDetails.last_post_date_only},</span>
                                                 <span class="clsLatPostTime">{$value.boardDetails.last_post_time_only}</span>
                                                 <p class="clsAskBy"><span class="clsLastAskby">{$LANG.index_by} </span> {$value.boardDetails.last_post_by}</p>
                                                {/if}</td>
                                        <td class="clsRepliesValue">{$value.boardDetails.total_solutions}</td>
                                        <td  class="clsViewsValue">{$value.boardDetails.total_views}</td>
                                        <td class="clsRatingValue">{$value.boardDetails.rating_count}</td>
                                      </tr>
        
                                    {/foreach}
                                    </table>
        
                                {if $myobj->form_popular_boards.displayPopularBoards.found}
                                  <div class="clsMoreGreen"><span class="clsMoreLink"><a href="{$myobj->form_popular_boards.displayPopularBoards.boards_url}">{$LANG.discuzz_common_more_popular_boards}</a></span></div>
        
                                {/if}
                                </div>
                            {/if}
        
                            {if !$myobj->form_popular_boards.displayPopularBoards.found}
                                <div class="clsNoRecords"><p>{$LANG.discuzz_common_no_popular_boards}</p></div>
        
                            {/if}
        
        
                    </div>
            	{/if}
		</div>
        <script type="text/javascript">
			{literal}
				$Jq(window).load(function(){
					 attachJqueryTabs('selRecentBoards');
				});
			{/literal}
		</script>
	{/if}

	{if  $myobj->isShowPageBlock('form_recent_boards')}
		{if !isAjax()}
            	{$myobj->setTemplateFolder('general/', 'discussions')}
                {include file='box.tpl' opt='topanalyst_bottom'}
    		<!--end of rounded corners-->
    		</div>
		{/if}
	{/if}

	<!-- code for third -->
	{if  $myobj->isShowPageBlock('form_recently_solutioned_boards')}
		{if !isAjax()}
        	<div class="clsCommonIndexRoundedCorner clsClearFix">
          	<!--rounded corners-->
    			{$myobj->setTemplateFolder('general/', 'discussions')}
                {include file='box.tpl' opt='topanalyst_top'}

					<!-- tabs start -->
					<div class="clsBoardsLink">
						<h3>
							<a id="selRecentlySolutionedLI" href="{$myobj->getCurrentUrl()}" onclick="$Jq('#selRecentlySolutioned').toggle('slow'); return false;" title="{$LANG.click_here_show_hide}">{$LANG.discuzz_common_recently_solutioned_board_title}</a>
						</h3>
					</div>
					<!-- tabs end -->
		{/if}
	{/if}

	{if  $myobj->isShowPageBlock('form_recently_solutioned_boards')}
		{if !isAjax()}
			<div id="selRecentlySolutioned" class="clsCommonIndexSection" {$myobj->form_recently_solutioned_boards.recentSolutionedQStyle}>
		{/if}
		{if !$myobj->form_recently_solutioned_boards.recentSolutionedQStyle}
		  <div id="selWidgetRecentlySolutioned" class="">

				{if $myobj->form_recently_solutioned_boards.displayRecentlySolutionedBoards.recently_solutioned}
                <div class="clsCommonTableContainer" id="recently_solutioned" style="display: block;">
                 <table cellspacing="0" cellpadding="0" class="clsCommonTable">
                  <tr>
                    <th class="clsIconTittle"><div class="clsIconNewThread"></div></th>
                    <th class="clsStartByTittle">{$LANG.index_startedby}</th>
                    <th  class="clsLastPostTittle">{$LANG.index_last_posts}</th>
                    <th  class="clsRepliesTittle">{$LANG.discuzz_common_solutions}</th>
                    <th  class="clsViewsTittle">{$LANG.index_views}</th>
                    <th  class="clsRatingTittle"><span class="clsRatingStar">{$LANG.index_ratings}</span></th>
                  </tr>
							{foreach key=inc item=value from=$myobj->form_recently_solutioned_boards.displayRecentlySolutionedBoards.row}
                             <tr class="{if $iteration eq 0}clsOdd{assign var="iteration" value="1"}{elseif $iteration eq 1}clsEven{assign var="iteration" value="0"}{/if}"> 
                                <td class="clsIconValue {$value.boardDetails.appendIcon}"><div class="{$value.boardDetails.legendIcon}"></div></td>
                                <td class="clsStartByValue"><p class="clsBoardLink"><span>{$value.boardDetails.board_link}&nbsp;{$value.boardDetails.bestIcon}</span></p>
                                							<p class="clsAskBy">{$LANG.index_by} {$value.boardDetails.asked_by_link}</p>
                                </td>
                                <td class="clsLastPostValue">
                                		{if $value.boardDetails.last_post_by neq ''}
                                        <span class="clsLastPostDate">{$value.boardDetails.last_post_date_only},</span>
										 <span class="clsLatPostTime">{$value.boardDetails.last_post_time_only}</span>
										 <p class="clsAskBy"><span class="clsLastAskby">{$LANG.index_by} </span> {$value.boardDetails.last_post_by}</p>
										{/if}</td>
                                <td class="clsRepliesValue">{$value.boardDetails.total_solutions}</td>
                                <td  class="clsViewsValue">{$value.boardDetails.total_views}</td>
                                <td class="clsRatingValue">{$value.boardDetails.rating_count}</td>
                              </tr>
							{/foreach}
                            </table>

					{if $myobj->form_recently_solutioned_boards.displayRecentlySolutionedBoards.have_recently_solutioned}
                      <div class="clsMoreGreen"><span><a href="{$myobj->form_recently_solutioned_boards.displayRecentlySolutionedBoards.boards_url}">{$LANG.discuzz_common_more_recent_solutions}</a></span></div>

					{/if}
                   </div>
				{/if}
				{if !$myobj->form_recently_solutioned_boards.displayRecentlySolutionedBoards.have_recently_solutioned}
					 		<div class="clsNoRecords"><p>{$LANG.discuzz_common_no_boards_with_recent_solutions}</p>
					</div>

				{/if}

		  </div>
		{/if}
		{if !isAjax()}
			</div>
		{/if}
	{/if}

	{if  $myobj->isShowPageBlock('form_recently_solutioned_boards')}
		{if !isAjax()}
            	{$myobj->setTemplateFolder('general/', 'discussions')}
                {include file='box.tpl' opt='topanalyst_bottom'}
    		<!--end of rounded corners-->
    		</div>
		{/if}
	{/if}
	{*if $myobj->isShowPageBlock('form_recent_activities') && isMember()}
		{include file='../members/indexActivity.tpl'}
	{/if*}

{if !isAjax()}
</div>
{/if}