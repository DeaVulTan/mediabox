<div id="selWidgetRecentlySolutioned" class="clsSideBarSections"  style="display: block;">
  <div class="clsSideBarContents" id = "recently_solutioned" >
   {if $myobj->recently_solutioned.displayRecentlySolutionedBoards.strings.recently_solutioned}
		{foreach key=raqkey item=raqvalue from=$myobj->recently_solutioned.displayRecentlySolutionedBoards.array}
			<div>
			  <div class="{$raqvalue.clsOddOrEvenBoard} clsUserThumbDetails clsDragableBoxLink">
               <p class="clsBoardLink ">{$raqvalue.boardDetails.board_link}</p>
                 <div class="clsUserDetails">
				  <p> <span class="clsUserLink clsNoBorder ">{$LANG.discuzz_common_board_asked_by}
					{if isUserImageAllowed()}
						{$myobj->displayProfileImage($raqvalue.boardDetails, 'tiny', false)}
					{/if}
					{$raqvalue.boardDetails.asked_by_link}</span> </p>
				  <p> <span>{$raqvalue.board_added}</span> <span class="clsNoBorder">{$raqvalue.boardDetails.total_solutions} {$raqvalue.solution_plural}</span> </p>
				</div>
			  </div>
			</div>
		{/foreach}
		{if $myobj->recently_solutioned.displayRecentlySolutionedBoards.strings.have_boards}
			<p class="clsMoreLink"> <a href="{$myobj->getUrl('boards', '?view=recentlysolutioned', 'recentlysolutioned/')}">{$LANG.common_more}</a> </p>
		{/if}
    {/if}
    {if !$myobj->recently_solutioned.displayRecentlySolutionedBoards.strings.have_boards}
		<div class="clsNoRecords">
		  <p>{$LANG.discuzz_common_no_boards}</p>
		</div>
    {/if}
  </div>
</div>