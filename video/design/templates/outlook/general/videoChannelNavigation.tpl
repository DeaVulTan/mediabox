<div class="clsSideBarMargin">
{$myobj->setTemplateFolder('general/','video')}
	{include file='box.tpl' opt='sidebar_top'}
	<p class="clsCategoryLeftTitle clsTitleTopContributor">{$LANG.header_nav_videochannels_title}</p>
	<div class="clsVideoCategoriesSidebar clsOverflow">
		<ul>
			 {if $videoChannel}
			  {foreach from=$videoChannel item = channel}
			  	<li><a href="{$channel.videoListUrl}">{$channel.video_category_name|truncate:30}</a> <span>({$channel.total_videos})</span></li>
			  {/foreach}
			  {else}
				  <li class="clsNoSideBarData">{$LANG.header_nav_videochannels_no_channels_found}</li>
			  {/if}
		</ul>

	</div>
	<div class="clsOverflow">
		<div class="clsFloatRight">
			<p class="clsViewMore">
				<a href="{$viewChannelUrl}">{$LANG.sidebar_view_all_category}</a>
			</p>
		</div>
	</div>		
{$myobj->setTemplateFolder('general/','video')}
	{include file='box.tpl' opt='sidebar_bottom'}
</div>

