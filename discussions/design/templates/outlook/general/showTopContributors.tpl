
<div id="selTopContributor" class="clsSideBarSections clsClearFix">
{$myobj->setTemplateFolder('general/', 'discussions')}
	{include file='box.tpl' opt='sidebar_top'}
		<h3>{$LANG.discuzz_common_top_contributor_title} : {$LANG.contributors_all_time}</h3>
		<div class="clsSideBarContents" id="top_contributors" style="display:block;">
			{if $form_top_contributor.displayTopContributor.top_contributors}

					{foreach key=inc item=value from=$form_top_contributor.displayTopContributor.row}
						<div class="{$value.clsOddOrEvenBoard} clsTopContributor">
                        	<div class="clsUserImage">
								{if isUserImageAllowed()}
                                	{$discussion->displayProfileImage($value.userDetails, 'small', false)}
								{/if}
							</div>
							<div>
							<p class="clsTopName"><a href="{$value.mysolutions_url}">{$value.stripString_display_name}</a></p>
							<div class="clsClearFix">
								<p class="clsFloatLeft"><span class="clsTopText">{$LANG.discuzz_common_boards}: </span> <span class="clsBold">{$value.userLog.total_board}</span></p>
								<p class="clsFloatLeft clsTopcartBestCount"><span class="clsTopText">{$LANG.index_best_solutions}: </span> <span class="clsBold">{$value.userLog.total_best_solution}</span></p>
							</div>
							</div>
							<div class="{$value.clsOddOrEvenBoard} clsUserPoints {$value.point_class} clsPNGImage">
								 <p>{$value.userLog.total_points}</p>
							</div>
						</div>
					{/foreach}

				{*if $form_top_contributor.displayTopContributor.have_contributors}
					<div class="clsMoreGreen"><span><a href="{$form_top_contributor.displayTopContributor.topcontributors_url}">{$LANG.discuzz_common_more_top_contributors}</a></span></div>
				{/if*}
			{/if}
			{if !$form_top_contributor.displayTopContributor.have_contributors}
				<div class="clsNoRecords">
					<p>{$LANG.discuzz_common_no_contributors}</p>
				</div>
			{/if}
		</div>
		{$myobj->setTemplateFolder('general/', 'discussions')}
	{include file='box.tpl' opt='sidebar_bottom'}       
</div>



