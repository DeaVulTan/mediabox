<div id="selFeaturedContributor" class="clsFeaturedContributor clsSideBarSections clsClearFix">
{$myobj->setTemplateFolder('general/', 'discussions')}
	{include file='box.tpl' opt='sidebar_top'}
		<h3>{$LANG.discuzz_common_featured_contributor_title}</h3>
		<div class="clsSideBarContents" id="featured_contributors" style="display:block;">
			{if  $form_featured_contributor.displayFeaturedContributor.featured_contributors}
				<div class="clsFeaturedContributors clsClearFix">
				{foreach key=inc item=value from=$form_featured_contributor.displayFeaturedContributor.row}
						<div class="clsFeaturedUser">
						{if isUserImageAllowed()}
							{$discussion->displayProfileImage($value.userDetails, 'small', false)}
						{/if}
						<p class="clsUserName"><a href="{$value.mysolutions_url}">{$value.stripString_display_name}</a></p>
						</div>
				{/foreach}
				</div>
			{if $form_featured_contributor.displayFeaturedContributor.have_users}
				<div class="clsMoreGreen"><span><a href="{$form_featured_contributor.displayFeaturedContributor.topcontributors_url}">{$LANG.common_more}</a></span></div>
			{/if}
			{/if}
			{if !$form_featured_contributor.displayFeaturedContributor.have_users}
				<div class="clsNoRecords">
					<p>{$LANG.discuzz_common_no_contributors}</p>
				</div>
			{/if}
		</div>
		{$myobj->setTemplateFolder('general/', 'discussions')}
	{include file='box.tpl' opt='sidebar_bottom'}  
</div>