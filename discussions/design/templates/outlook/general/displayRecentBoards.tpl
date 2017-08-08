<div id="selWidgetRecentBoards" class="clsSideBarSections" style="display:block;">
	 <div class="clsSideBarContents" id="recent_board">
	 {if $myobj->recent_boards.displayRecentBoards.strings.recent_boards}
	 	{foreach key=rqkey item=rqvalue from=$myobj->recent_boards.displayRecentBoards.array}
		<div>
			<div class="{$rqvalue.clsOddOrEvenBoard} clsUserThumbDetails clsDragableBoxLink">
            <p class="clsBoardLink ">{$rqvalue.boardDetails.board_link}</p>
                <div class="clsUserDetails">
					<p>
						<span class="clsUserLink clsNoBorder ">{$LANG.discuzz_common_board_asked_by}
							{if isUserImageAllowed()}
								{$myobj->displayProfileImage($rqvalue.boardDetails, 'tiny', false)}
							{/if}
							{$rqvalue.boardDetails.asked_by_link}
						</span>
					</p>
					<p>
						<span>{$rqvalue.board_added}</span>
						<span class="clsNoBorder">{$rqvalue.boardDetails.total_solutions} {$rqvalue.solution_plural}</span>
					</p>
				</div>

			</div>
		</div>
		{/foreach}
		{if $myobj->recent_boards.displayRecentBoards.strings.have_boards}
			<p class="clsMoreLink">
				<a href="{$myobj->getUrl('boards', '?view=recent', 'recent/')}">{$LANG.common_more}</a>
			</p>
		{/if}
	{/if}
	{if !$myobj->recent_boards.displayRecentBoards.strings.have_boards}
		<div class="clsNoRecords">
			<p>{$LANG.discuzz_common_no_boards}</p>
		</div>
	{/if}
	</div>
</div>