{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='myhomesidebar_top'}
<div id="selActivities" class="clsAllActivitiesBar">
<div class="clsOverflow">
  <div class="clsFloatLeft"><h2 class="clsMyHomeBarLeftTitle">{$LANG.myhome_recent_activities_title}</h2></div>
    <div id="selActivityLinks" class="clsTabNavigation clsRecentActivities">
        <ul>
            <li id="selHeaderActivityMy"><span><a href="{$myobj->activity_my_url}">{$LANG.myhome_recent_activities_my}</a></span></li>
            <li id="selHeaderActivityFriends"><span><a href="{$myobj->activity_friends_url}">{$LANG.myhome_recent_activities_friends}</a></span></li>
            <li id="selHeaderActivityAll"><span><a href="{$myobj->activity_all_url}">{$LANG.myhome_recent_activities_all}</a></span></li>
        </ul>
    </div>
 </div>	
    <script type="text/javascript">
		var subMenuClassName1='clsActiveTabNavigation';
		var hoverElement1  = '.clsTabNavigation';
		var selector = 'li';
		loadChangeClass(hoverElement1, selector, subMenuClassName1);
	</script>


  {include file='../general/information.tpl'}

{if $myobj->isShowPageBlock('block_activities')}
    {if $CFG.admin.show_recent_activities}
    	{if $myobj->isResultsFound()}
            <!--Recent Activities Starts here -->
              <div class="clsRecentActivityContent">
                    <div id="selActivityContent" class="clsMembersListActivity">
                        {if $CFG.admin.navigation.top}
						  <div class="clsPaddingTopBottom">
                            {$myobj->setTemplateFolder('general/')}
                            {include file='../general/pagination.tpl'}
						  </div>	
                        {/if}

                           {$myobj->myHomeActivity(10)}

                        {if $CFG.admin.navigation.bottom}
						 <div class="clsPaddingTop5">
                            {$myobj->setTemplateFolder('general/')}
                            {include file='pagination.tpl'}
						  </div>	
                        {/if}

                    </div>
              </div>
            <!--Recent Activities Ends here -->
	    {/if}
	{/if}
{/if}
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='myhomesidebar_bottom'}