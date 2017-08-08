<!-- Static content Tag Clouds -->
<div class="clsSideBarLinks">
	<div class="clsSideBarMargin">
		<div class="clsTagsHeading clsOverflow">
			<div class="clsTagsLeftHead">
				<h3>{$LANG.header_nav_videotags_cloud_tags}</h3>
			</div>
			<div class="clsTagsRightTab">
				
			</div>
		</div>
{include file='box.tpl' opt='cloudstag_top'}
		  <div class="clsSideBarRight">
			  <div class="clsSideBarContent">
				<div class="clsCloudsTagsContainer">
                  {if $tags}<div class="clsOverflow">
					   	<p class="clsVideoTags">
							{foreach from=$tags item=tag}
							<a  style="font-size: 13px;" href="{$tag.url}" class="{$tag.class}" >{$tag.name}</a>
          					{/foreach}
			  			</p>
					   </div>
					   <div class="clsOverflow">
					   	<div class="clsFloatRight">
				      <p class="clsViewMore"><a href="{$viewTagUrl}">{$LANG.sidebar_view_all_label_tags}</a></p>
					  	</div>
					</div>	
				      {else}
						<p class="clsNoDatas">{$LANG.header_nav_videotags_no_tags_found}</p>
    				{/if}

                    </div>
			</div>
		  </div>{include file='box.tpl' opt='cloudstag_bottom'}
		</div>
</div>
<!-- End Static content Tag Clouds -->

