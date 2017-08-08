<div id="selFeaturedboards" class="clsSideBarSections clsClearFix">
{$myobj->setTemplateFolder('general/', 'discussions')}
	{include file='box.tpl' opt='sidebar_top'}
	<h3>{$LANG.discuzz_common_featured_board_title}</h3>
	<div id = "featured_boards" class="clsSidebarFeatured" style="display:block;">
		{if $form_featured_boards.displayFeaturedboards.featured_boards}
			{foreach key=inc item=value from=$form_featured_boards.displayFeaturedboards.row}
				<div class="clsFeaturedContainer">
					<div class="clsFeaturedContent">
				  		<p class="clsBoardLink">{$value.boardDetails.board_link}</p>
						<p class=""> <span class="clsPostBy">{$LANG.index_posted_by} {$value.boardDetails.asked_by_link1}</span>
						<span class="clsRatingDefault">{$value.boardDetails.total_stars} {$value.index_rating_lang}</span>
						</p>
					</div>
				</div>
			{/foreach}
			{if $form_featured_boards.displayFeaturedboards.have_boards}
				<div class="clsMoreGreen"><span><a href="{$form_featured_boards.displayFeaturedboards.boards_url}">{$LANG.common_more}</a></span></div>
			{/if}
		{/if}
		{if !$form_featured_boards.displayFeaturedboards.have_boards}
			<div class="clsNoRecords">
				<p>{$LANG.discuzz_common_no_boards}</p>
			</div>
		{/if}
	</div>
			{$myobj->setTemplateFolder('general/', 'discussions')}
	{include file='box.tpl' opt='sidebar_bottom'}  
</div>