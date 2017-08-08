<!--SIDEBAR-->
  	<div class="clsVideoIndexRight">

	<!-- Static content What's Going On -->
	<div class="clsSideBarMargin">
	{$myobj->setTemplateFolder('general/','video')}
	{include file='box.tpl' opt='sidebar_whatsgoing_top'}
	<div class="clsWhatgoingHeading clsOverflow">
		<div class="clsFloatLeft" id="indexActivitesTabs">
			<div class="clsTagsRightTab">
					<h3 class="clsFloatLeft">{$LANG.header_nav_whats_goingon_activity_title_lbl}</h3>
					<ul class="clsFloatRight">
					{if isMember()}
						<li><a href="index.php?activity_type=My">{$LANG.header_nav_whats_goingon_activity_my}</a></li>
						<li><a href="index.php?activity_type=Friends">{$LANG.header_nav_whats_goingon_activity_friends}</a></li>
					{/if}
						<li><a href="index.php?activity_type=All">{$LANG.header_nav_whats_goingon_activity_all}</a></li>
					</ul>
				</div>
		</div>
	</div>
	<script type="text/javascript">
	{literal}
	$Jq(window).load(function(){
		attachJqueryTabs('indexActivitesTabs');
	});
	{/literal}
	</script>
	{include file='box.tpl' opt='sidebar_whatsgoing_bottom'}
	</div>
	<!-- Static content What's Going On -->

	{$myobj->populateVideoMemberMenu()}

    {$header->displayLoginFormRightNavigation()}

    {if $index_block_settings_arr.RandomVideo == 'sidebar'}
	{$myobj->getRandomVideoForSideBar()}
    {/if}
	{if $index_block_settings_arr.RandomVideo == 'mainblock'}
        {$header->populateTopContributorsRightNavigation()}
    {/if}

	<!-- category bock start -->
	{$myobj->populateVideoChannelsRightNavigation()}
	<!-- category bock end -->

	<div class="cls336pxBanner">		
        <div>{php}getAdvertisement('sidebanner1_336x280'){/php}</div>	  
    </div>

	<!--Start Tag Clouds -->

	{$myobj->populateVideoTagsRightNavigation()}

	<!-- End Tag Clouds -->


	</div>
<!--end of SIDEBAR-->

<!-- Main -->
<div class="clsVideoIndexLeft">
<!-- Header ends -->