<div id="selWidgetPopularBoards" class="clsSideBarSections"  style="display: block;">
  <div class="clsSideBarContents" id = "popular_boards" >
   {if $myobj->popular_boards.displayPopularBoards.strings.popular_boards}
		{foreach key=pqkey item=pqvalue from=$myobj->popular_boards.displayPopularBoards.array}
			<div>
			  <div class="{$pqvalue.clsOddOrEvenBoard} clsUserThumbDetails clsDragableBoxLink">
               <p class="clsBoardLink clsDragableBoxLink">{$pqvalue.boardDetails.board_link}</p>
                <div class="clsUserDetails">

				  <p> <span class="clsUserLink clsNoBorder ">{$LANG.discuzz_common_board_asked_by}
					{if isUserImageAllowed()}
						{$myobj->displayProfileImage($pqvalue.boardDetails, 'tiny', false)}
					{/if}
					{$pqvalue.boardDetails.asked_by_link}</span> </p>
				  <p> <span>{$pqvalue.board_added}</span> <span class="clsNoBorder">{$pqvalue.boardDetails.total_solutions} {$pqvalue.solution_plural}</span> </p>
				</div>

			  </div>
			</div>
		{/foreach}
		{if $myobj->popular_boards.displayPopularBoards.strings.found}
			<p class="clsMoreLink"> <a href="{$myobj->getUrl('boards', '?view=popular', 'popular/')}">{$LANG.common_more}</a> </p>
		{/if}
    {/if}
    {if !$myobj->popular_boards.displayPopularBoards.strings.found}
		<div class="clsNoRecords">
		  <p>{$LANG.discuzz_common_no_boards}</p>
		</div>
    {/if}
  </div>
</div>