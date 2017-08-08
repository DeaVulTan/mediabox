<div id="selMyHome">
  <div class="clsMyhomeUserBlock clsOverflow">
    <p class="clsMyHomeAvatar"> <a class="ClsImageContainer ClsImageBorder2 Cls66x66" href="{$myobj->getUserDetail('user_id', $CFG.user.user_id, 'profile_url')}"> <img src="{$myobj->icon.t_url}" alt="{$CFG.user.user_name|truncate:7}" title="{$CFG.user.user_name}" {$myobj->DISP_IMAGE(66, 66, $myobj->icon.t_width, $myobj->icon.t_height)} /> </a> </p>
    <div class="clsFloatRight clsMyHomeUrlcontainer">
      <div class="clsMyHomeUrlTextBox" id="purl" onclick="fnSelect('purl')">
        <div class="clsMyHomeUrlTextBoxInner">{$myobj->profile_url_wbr}</div>
      </div>
      <div class="clsDashboardRightlinks">
        <ul class="clsOverflow">
          <li class="selDropDownLink clsMyHomeShortcut "> <a class="clsMainShortcutMenu" href="#">{$LANG.myhome_myshortcuts_title}</a>
            <ul class="clsMyHomeDropDownMenu">
              {$myobj->setTemplateFolder('general/', '')}
              {include file="box.tpl" opt="myhomedrop_top"}
              <li><a href="{$myobj->myshortcuts_arr.viewprofile_url}">{$LANG.myhome_myshortcuts_profile}</a></li>
              <li><a href="{$myobj->getUrl('myfriends', '', '', 'members')}">{$LANG.myhome_myshortcuts_friends}</a></li>
              {if $myobj->myshortcuts_arr.is_shortcut_module}
              {foreach key=module  item=linkmodule from=$myobj->myshortcuts_arr.shortcut_module_arr}
              {if $myobj->myshortcuts_arr.shortcut_module_arr.$module}
              <li><a href="{$myobj->myshortcuts_arr.shortcut_module_arr.$module.viewmy.link_url}">{$myobj->myshortcuts_arr.shortcut_module_arr.$module.viewmy.link_name|capitalize}</a></li>
              {/if}
              {/foreach}
              {/if}
              {if chkIsSubscriptionEnabled()}
              <li><a href="{$myobj->getUrl('mysubscription', '?pg=member_subscription', 'member_subscription/', 'members')}">{$LANG.myhome_myshortcuts_subscriptions}</a></li>
              {/if}
              <li><a href="{$myobj->getUrl('profilebasic', '', '', 'members')}">{$LANG.myhome_myshortcuts_edit_profile}</a></li>
              <li><a href="{$myobj->getUrl('profilesettings', '', '', 'members')}">{$LANG.myhome_myshortcuts_account_settings}</a></li>
              {$myobj->setTemplateFolder('general/', '')}
              {include file="box.tpl" opt="myhomedrop_bottom"}
            </ul>
          </li>
          <li class="selDropDownLink clsMyHomeInvite"> <a class="clsMainShortcutMenu" href="{$myobj->getUrl('membersinvite', '', '', 'members')}">{$LANG.nav_friends_invite_friends}</a>
            <ul class="clsMyHomeInviteDropDownMenu">
              {$myobj->setTemplateFolder('general/', '')}
              {include file="box.tpl" opt="invitedrop_top"}
              {if $myobj->userDetails.new_requests}
              <li><a class="clsFriendsRequest" href="{$myobj->getUrl('mail', '?folder=request', 'request/', 'members')}">{$myobj->userDetails.new_requests}&nbsp;{if $myobj->userDetails.new_requests > 1}{$LANG.nav_friends_friends_requests}{else}{$LANG.nav_friends_friends_request}{/if}</a></li>
              {/if}
              {if $myobj->userDetails.video_mails}
              <li><a class="clsVideoMail" href="{$myobj->getUrl('mail', '?folder=video', 'video/', 'members')}">{$myobj->userDetails.video_mails}&nbsp;{if $myobj->userDetails.new_requests > 1}{$LANG.nav_friends_video_mails}{else}{$LANG.nav_friends_video_mail}{/if}</a></li>
              {/if}
              <li><a class="clsInviteFriends" href="{$myobj->getUrl('membersinvite', '', '', 'members')}">{$LANG.nav_friends_invite_friends}</a></li>
              <li><a class="clsInvitationHistory" href="{$myobj->getUrl('invitationhistory', '', '', 'members')}">{$LANG.nav_friends_invitation_history}</a></li>
              {$myobj->setTemplateFolder('general/', '')}
              {include file="box.tpl" opt="invitedrop_bottom"}
            </ul>
          </li>
        </ul>
      </div>
    </div>
    <div class="clsDashboardUserdetails">
	 <div class="clsOverflow">
      	<div class="clsFloatLeft"><p class="clsMydashboardHeading"> My Dashboard </p> </div>
		<div class="clsFloatLeft">
			{if $myobj->showUpgradeMembershipButton()}
			  <div class="clsUpgradeMembership">
				 <p><a href="{$myobj->getUrl('upgrademembership')}">{$LANG.myhome_upgrademembership}</a></p>
			  </div>
			{/if}
		</div>
	 </div>	
      <p class="clsDashboardUsername clsOverflow"> 
      	<span class="clsUsername">
        	<a href="{$myobj->profile_url}">{if $CFG.admin.display_first_last_name}{$myobj->userDetails.first_name}&nbsp;{$myobj->userDetails.last_name}{else}{$CFG.user.user_name}{/if}</a>
        </span> 
        <span> {$LANG.myhome_subtitle_last_login}:</span>
        <span> 
        {if $myobj->userDetails.last_logged neq '0000-00-00 00:00:00'}
           {$myobj->userDetails.last_logged|date_format:#format_datetime#}
        {else}
          {$LANG.myhome_subtitle_first_login}
        {/if}
        </span> 
      </p>
      <p class="clsUserDatacount"> {$header->populateSiteUserStatistics()} {section name=count loop=$userstatistics}                
        {$userstatistics[count].value}<span> {$userstatistics[count].lang}, </span> {/section} <a href="{$myobj->getUrl('myfriends', '', '', 'members')}">{$header->getTotalFriendsNew()}</a> <span>{$LANG.myhome_total_friends},</span> <a href="{$profileCommentURL}">{$header->getTotalComments()}</a> <span>{$LANG.myhome_total_comments}</span> </p>
    </div>
  </div>
  <div class="clsBreadcum">
    <p><a href="{$myobj->getUrl('myhome', '', '', '')}">{$LANG.common_home}</a> {$LANG.myhome_title_myhome}</p>
  </div>
  <!-- Left side content of myHome -->
  <div id="selLeftContents" class="clsMyHomeLeftContent"> {if $CFG.admin.show_recent_activities && $CFG.admin.display_myhome_recent_activities}
    <!--Recent Activities Starts here -->
    {$myobj->setTemplateFolder('general/')}
    {include file='box.tpl' opt='myhomesidebar_top'}
    <div class="clsActivitiesSection clsMyHomeSideBar">
      <div class="clsActivitiesSectionLeft">
	  <div class="clsOverflow">
        <div class="clsFloatLeft">
          <p class="clsMyHomeBarLeftTitle">{$LANG.myhome_recent_activities_title}</p>
		</div>  
          <div class="clsTabNavigation clsRecentActivities">
            <ul>
              <li id="selHeaderActivityFriends"><span><a href="javascript:void(0);" onclick="getMoreContent('{$CFG.site.url}myHome.php?ajax_page=true&amp;activity_type=friends', 'selActivityFriendsContent', 'selHeaderActivityFriends'); return false;">{$LANG.myhome_recent_activities_friends}</a></span></li>
              <li id="selHeaderActivityMy"><span><a href="javascript:void(0);" onclick="getMoreContent('{$CFG.site.url}myHome.php?ajax_page=true&amp;activity_type=my', 'selActivityMyContent', 'selHeaderActivityMy'); return false;">{$LANG.myhome_recent_activities_my}</a></span></li>
              <li id="selHeaderActivityAll"><span><a href="javascript:void(0);" onclick="getMoreContent('{$CFG.site.url}myHome.php?ajax_page=true&amp;activity_type=all', 'selActivityAllContent', 'selHeaderActivityAll'); return false;">{$LANG.myhome_recent_activities_all}</a></span></li>
            </ul>
          </div>
		</div>
          <script type="text/javascript">
							var subMenuClassName1='clsActiveTabNavigation';
							var hoverElement1  = '.clsTabNavigation';
							var selector = 'li';
							loadChangeClass(hoverElement1, selector, subMenuClassName1);
						</script>
          <div id="selActivityFriendsContent" class="clsRecentActivityContent clsMembersListActivity" style="display:none"> {if $myobj->userDetails.total_friends}
            {if $CFG.admin.myhome.recent_activity_default_content == 'Friends'}
            {$myobj->myHomeActivity(10)}
            {/if}
            {else}
			<div class="clsOverflow">
              <div class="clsNoRecordsFound"> {$LANG.myhome_recent_activities_no_friends} </div>
			</div>  
            {/if} </div>
          <div id="selActivityMyContent" class="clsRecentActivityContent clsMembersListActivity" style="display:none"> {if $CFG.admin.myhome.recent_activity_default_content == 'My'}
            {$myobj->myHomeActivity(10)}
            {/if} </div>
          <div id="selActivityAllContent" class="clsRecentActivityContent clsMembersListActivity" style="display:none"> {if $CFG.admin.myhome.recent_activity_default_content == 'All'}
            {$myobj->myHomeActivity(10)}
            {/if} </div>
      </div>
    </div>
    {$myobj->setTemplateFolder('general/')}
    {include file='box.tpl' opt='myhomesidebar_bottom'}
    <!--Recent Activities Ends here -->
    {/if}
    
    {*  {if $myobj->CFG.admin.myhome.show_profile_hi}
    {$myobj->setTemplateFolder('general/')}
    {include file='box.tpl' opt='myhomesidebar_top'}
    <div class="clsMyHomeSideBar">
      <div id="selUserProfileIcon">
        <div>
          <p class="clsMyHomeBarLeftTitle">{$LANG.myhome_profile_hi}<strong class="clsUserName">{if $CFG.admin.display_first_last_name}{$myobj->userDetails.first_name}&nbsp;{$myobj->userDetails.last_name}{else}{$CFG.user.user_name}{/if}!</strong></p>
        </div>
        <div>
          <div class="clsWelcomeMember">
            <p class="clsMyHomeAvatar"> <a class="ClsImageContainer ClsImageBorder2 Cls90x90" href="{$myobj->getUserDetail('user_id', $CFG.user.user_id, 'profile_url')}"> <img src="{$myobj->icon.t_url}" alt="{$CFG.user.user_name|truncate:9}" title="{$CFG.user.user_name}" {$myobj->DISP_IMAGE(#image_thumb_width#, #image_thumb_height#, $myobj->icon.t_width, $myobj->icon.t_height)} /> </a> </p>
            <div id="selUserProfileIndexDetails">
              <h5 class="clsMyHomeUserName"><a href="{$myobj->profile_url}">{if $CFG.admin.display_first_last_name}{$myobj->userDetails.first_name}&nbsp;{$myobj->userDetails.last_name}{else}{$CFG.user.user_name}{/if}</a></h5>
              <p><span class="clsLastLogin">{$LANG.myhome_subtitle_last_login}:</span> {$myobj->userDetails.last_logged|date_format:#format_datetime#}</p>
            </div>
            <div id="indexUserRayzzUrl" class="clsClearLeft">
              <h5>{$myobj->site_name}</h5>
              <p>
              <div class="clsMyHomeUrlTextBox" id="purl" onclick="fnSelect('purl')">{$myobj->profile_url_wbr}</div>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    {include file='box.tpl' opt='myhomesidebar_bottom'}
    {/if}
    
    {if $myobj->CFG.admin.myhome.show_shortcuts}
    {$myobj->setTemplateFolder('general/')}
    {include file='box.tpl' opt='myhomesidebar_top'}
    <div class="clsMyHomeSideBar">
      <div>
        <p class="clsMyHomeBarLeftTitle">{$LANG.myhome_myshortcuts_title}</p>
      </div>
      <div class="clsSideBarRight">
        <div class="clsSideBarContent">
          <div id="shortcuts_myview" class="clsMyShortcutLeftList">
            <p>{$LANG.myhome_myshortcuts_view_my}</p>
            <ul>
              <li><a href="{$myobj->myshortcuts_arr.viewprofile_url}">{$LANG.myhome_myshortcuts_profile}</a></li>
              <li><a href="{$myobj->getUrl('myfriends', '', '', 'members')}">{$LANG.myhome_myshortcuts_friends}</a></li>
              {if $myobj->myshortcuts_arr.is_shortcut_module}
              {foreach key=module  item=linkmodule from=$myobj->myshortcuts_arr.shortcut_module_arr}
              {if $myobj->myshortcuts_arr.shortcut_module_arr.$module}
              <li><a href="{$myobj->myshortcuts_arr.shortcut_module_arr.$module.viewmy.link_url}">{$myobj->myshortcuts_arr.shortcut_module_arr.$module.viewmy.link_name|capitalize}</a></li>
              {/if}
              {/foreach}
              {/if}
              {if chkIsSubscriptionEnabled()}
              <li><a href="{$myobj->getUrl('mysubscription', '?pg=member_subscription', 'member_subscription/', 'members')}">{$LANG.myhome_myshortcuts_subscriptions}</a></li>
              {/if}
            </ul>
          </div>
          <div id="shortcuts_settings" class="clsMyShortcutRightList">
            <p>{$LANG.myhome_myshortcuts_settings}</p>
            <ul>
              <li><a href="{$myobj->getUrl('profilebasic', '', '', 'members')}">{$LANG.myhome_myshortcuts_edit_profile}</a></li>
              <li><a href="{$myobj->getUrl('profilesettings', '', '', 'members')}">{$LANG.myhome_myshortcuts_account_settings}</a></li>
              {if $myobj->myshortcuts_arr.is_shortcut_module}
              {foreach key=module  item=linkmodule from=$myobj->myshortcuts_arr.shortcut_module_arr}
              {if $myobj->myshortcuts_arr.shortcut_module_arr.$module}
              <li><a href="{$myobj->myshortcuts_arr.shortcut_module_arr.$module.setting.link_url}">{$myobj->myshortcuts_arr.shortcut_module_arr.$module.setting.link_name|capitalize}</a></li>
              {/if}
              {/foreach}
              {/if}
            </ul>
          </div>
        </div>
        <!-- End of div for rounded corners -->
      </div>
    </div>
    {include file='box.tpl' opt='myhomesidebar_bottom'}
    {/if}
    
    {if $myobj->CFG.admin.myhome.show_requests}
    {$myobj->setTemplateFolder('general/')}
    {include file='box.tpl' opt='myhomesidebar_top'}
    <div class="clsMyHomeSideBar">
      <div>
        <p class="clsMyHomeBarLeftTitle">{$LANG.myhome_requests_title}</p>
      </div>
      <div class="clsSideBarRight">
        <div class="clsSideBarContent">
          <ul class="clsRequestList">
            {if $myobj->userDetails.new_requests}
            <li><a class="clsFriendsRequest" href="{$myobj->getUrl('mail', '?folder=request', 'request/', 'members')}">{$myobj->userDetails.new_requests}&nbsp;{if $myobj->userDetails.new_requests > 1}{$LANG.nav_friends_friends_requests}{else}{$LANG.nav_friends_friends_request}{/if}</a></li>
            {/if}
            {if $myobj->userDetails.video_mails}
            <li><a class="clsVideoMail" href="{$myobj->getUrl('mail', '?folder=video', 'video/', 'members')}">{$myobj->userDetails.video_mails}&nbsp;{if $myobj->userDetails.new_requests > 1}{$LANG.nav_friends_video_mails}{else}{$LANG.nav_friends_video_mail}{/if}</a></li>
            {/if}
            <li><a class="clsInviteFriends" href="{$myobj->getUrl('membersinvite', '', '', 'members')}">{$LANG.nav_friends_invite_friends}</a></li>
            <li><a class="clsInvitationHistory" href="{$myobj->getUrl('invitationhistory', '', '', 'members')}">{$LANG.nav_friends_invitation_history}</a></li>
          </ul>
        </div>
        <!-- End of div for rounded corners -->
      </div>
    </div>
    {include file='box.tpl' opt='myhomesidebar_bottom'}
    {/if}
    
    {if $CFG.admin.myhome.show_stats}
    {$myobj->setTemplateFolder('general/')}
    {include file='box.tpl' opt='myhomesidebar_top'}
    <div class="clsMyHomeSideBar">
      <div>
        <p class="clsMyHomeBarLeftTitle">{$LANG.myhome_statsbox_title}</p>
      </div>
      <div class="clsSideBarRight">
        <ul class="clsStatsList">
          {foreach item=stats from=$myobj->show_stats_arr}
          <li>{$stats.lang_value}:&nbsp;{$stats.stats_value}</li>
          {/foreach}
          <li>{$LANG.myhome_total_profile_comments}:&nbsp;<a href="{$profileCommentURL}">{$myobj->userDetails.total_profile_comments}</a></li>
        </ul>
        <!-- End of div for rounded corners -->
      </div>
    </div>
    {include file='box.tpl' opt='myhomesidebar_bottom'}
    {/if} *}
    
    {if $myobj->CFG.admin.myhome.upcoming_birthdays}
     {*{$myobj->setTemplateFolder('general/')}
    {include file='box.tpl' opt='myhomedetails_top'}
    {<div class="clsUpcomingBirthday">
      <div class="clsMyHomeRecentVisitonsTitleLeft">
        <h3>{$LANG.myhome_upcoming_birthdays_title}</h3>
      </div>
      <div class="clsSideBarRight clsMyHomeBirthdayContent">
        <div class="clsSideBarContent">
          <table class="clsBirthdayTable">
            {foreach item=birthdayValue from=$upcomingBirthdayList_arr.row}
            <tr>
              <td><div class="clsFloatLeft clsMarginRight10"> <a class="ClsImageContainer ClsImageBorder2 Cls66x66" href="{$birthdayValue.friendProfileUrl}"> <img  src="{$birthdayValue.icon.s_url}" alt="{$birthdayValue.record.friend_name|truncate:7}"  title="{$birthdayValue.record.friend_name}" {$myobj->DISP_IMAGE(#image_small_width#, #image_small_height#, $birthdayValue.icon.s_width, $birthdayValue.icon.s_height)} /> </a> </div>
                <p id="selMemberName" class="clsProfileThumbImg"><a href="{$birthdayValue.friendProfileUrl}" {$birthdayValue.online}>{$birthdayValue.display_name}</a> </p>
                {if $birthdayValue.record.dob_comp}
                <p>{$birthdayValue.record.dob}</p>
                {else}
                <p>{$birthdayValue.record.dob|date_format:#format_date#}</p>
                {/if} </td>
            </tr>
            {foreachelse}
            <tr>
              <td class="clsNoBirthdays">{$LANG.myhome_upcoming_birthdays_no_records}</td>
            </tr>
            {/foreach}
          </table>
        </div>
        <!-- End of div for rounded corners -->
      </div>
    </div>
    {include file='box.tpl' opt='myhomedetails_bottom'}*}
   
 	<div class="ClsUpcomingBirthdaysCarouselContainer"> 
    	{$myobj->setTemplateFolder('general/')}
      {include file='box.tpl' opt='myhomedetails_top'}
      <div class="clsOverflow">
        <div class="clsMyHomeRecentVisitonsTitleLeft">
          <h3>{$LANG.myhome_upcoming_birthdays_title}</h3>
        </div>
      </div>
      <div class="ClsUpcomingBirthdaysCarousel">
	  {if isset($upcomingBirthdayList_arr.row) && ($upcomingBirthdayList_arr.row)} 
        <ul id="carouselUpcomingBirthday" class="jcarousel-skin-tango">
          {foreach item=birthdayValue from=$upcomingBirthdayList_arr.row}
          <li> <div class="clsFloatLeft"> <a class="ClsImageContainer ClsImageBorder2 Cls45x45" href="{$birthdayValue.friendProfileUrl}"> <img  src="{$birthdayValue.icon.s_url}" alt="{$birthdayValue.record.friend_name|truncate:5}"  title="{$birthdayValue.record.friend_name}" {$myobj->DISP_IMAGE(45, 45, $birthdayValue.icon.s_width, $birthdayValue.icon.s_height)} /> </a> </div>
		   
		   <div class="clsUpcomingBirthdaysContent">
            <p id="selMemberName" class="clsProfileThumbImg clsPaddingBottom5"><a href="{$birthdayValue.friendProfileUrl}" {$birthdayValue.online}>{$birthdayValue.display_name}</a> </p>
                {if $birthdayValue.record.dob_comp}
                <p>{$birthdayValue.record.dob}</p>
                {else}
                <p>{$birthdayValue.record.dob|date_format:#format_date#}</p>
                {/if}
		    </div>		
          </li>
          {/foreach}
        </ul>
		{else}
		 <div class="clsOverflow">
          <div class="clsNoListDatas"> {$LANG.myhome_upcoming_birthdays_no_records} </div>
		 </div> 
		{/if}
      </div>
      {include file='box.tpl' opt='myhomedetails_bottom'} </div>
    {literal}
    <script type="text/javascript">
                // <![CDATA[
                  jQuery(document).ready(function() {
					    jQuery('#carouselUpcomingBirthday').jcarousel({
					        // Configuration goes here
					    });
					});
                // ]]>
                </script>
    {/literal}    
    
    {/if} </div>
  <!-- End of Left side content of myHome -->
  <!-- Right side content of myHome -->
  <div id="selRightContents" class="clsMyHomeRightContent">   
    {if $CFG.admin.myhome.show_profile_visitors}
    <div class="ClsRecentVisitorCarouselContainer"> {$myobj->setTemplateFolder('general/')}
      {include file='box.tpl' opt='myhomedetails_top'}
      <div class="clsOverflow">
        <div class="clsMyHomeRecentVisitonsTitleLeft">
          <h3>{$LANG.myhome_profile_visitors_title}</h3>
        </div>
      </div>
      <div class="ClsRecentVisitorCarousel">
	  {if isset($displayMyProfileVisitors_arr.row) && ($displayMyProfileVisitors_arr.row)}
        <ul id="carouselRecentVisitors" class="jcarousel-skin-tango">
          {foreach key=pKey item=profileVisitors from=$displayMyProfileVisitors_arr.row}
          <li> <a class="ClsImageContainer Cls66x66 ClsImageBorder1 ClsImageMargin" href="{$profileVisitors.memberProfileUrl}" id="{$profileVisitors.anchor_id}"> <img src="{$profileVisitors.icon.s_url}" alt="{$profileVisitors.visitor_name|truncate:7}" title="{$profileVisitors.visitor_name}" id="{$profileVisitors.image_id}"  {$myobj->DISP_IMAGE(#image_small_width#, #image_small_height#, $profileVisitors.icon.s_width, $profileVisitors.icon.s_height)}/> </a>
            <p class="ClsMembersName"><a href="{$profileVisitors.memberProfileUrl}">{$profileVisitors.visitor_name}</a></p>
          </li>
          {/foreach}
        </ul>
         {else}
		  <div class="clsNoRecordPadding">
          	<div class="clsNoListDatas"> {$LANG.myhome_profile_visitors_no_records} </div>
		 </div>	
		{/if}  
      </div>
      {if !isset($displayMyProfileVisitors_arr.row) && !($displayMyProfileVisitors_arr.row)}
          <div class="clsMyHomeRecentVisitonsTitleRight clsOverflow">
            <p><span>{$LANG.common_total}:&nbsp;{$myobj->getProfileViewCounts()}</span></p>
            <p>{$LANG.common_since}&nbsp;{$myobj->userDetails.profile_since_date}:&nbsp;{$myobj->userDetails.profile_hits_count_by}</p>
          </div>
      {/if}
      {include file='box.tpl' opt='myhomedetails_bottom'} </div>
    {literal}
    <script type="text/javascript">
                // <![CDATA[
                  jQuery(document).ready(function() {
					    jQuery('#carouselRecentVisitors').jcarousel({
					        // Configuration goes here
					    });
					});
                // ]]>
                </script>
    {/literal}
    {/if}
    
    
    {if $myobj->CFG.admin.myhome.show_my_friends}
    
    {*** ASSIGNED TO DISPLAY TOTAL NO. OF FRIENDS IN FRIENDS BLOCK - CAN CHANGE BASED ON TEMPLATE DESIGN ***}
    {assign var='myhome_total_friends_display' value='14'}    
    {if $myobj->userDetails.total_friends}
        {$myobj->displayMyFriends($myobj->userDetails.total_friends, 0, $myhome_total_friends_display)}
    {/if}
        
    {$myobj->setTemplateFolder('general/')}
    {include file='box.tpl' opt='myhomedetails_top'}
    <div id="selMyFriendsContent" class="">
      	<div class="clsMyHomeRecentVisitonsTitleLeft">
        	<h3>{$LANG.myhome_my_friends_title}</h3>
      	</div>
      	<div class="clsMyHomeFriendListing">
        	<ul class="clsMyHomeFriends clsOverflow">
        		{if $myobj->userDetails.total_friends}        
              		
                {foreach item=myFriendsValue from=$displayMyFriends_arr.row}
                <li id="selPhotoGallery"> <a class="ClsImageContainer ClsImageBorder2 Cls32x32" href="{$myFriendsValue.memberProfileUrl}" id="{$myFriendsValue.anchor_id}"> <img src="{$myFriendsValue.icon.s_url}" alt="{$myFriendsValue.friendName|truncate:3}" title="{$myFriendsValue.friendName}" id="{$myFriendsValue.image_id}" {$myobj->DISP_IMAGE(30, 30, $myFriendsValue.icon.s_width, $myFriendsValue.icon.s_height)}  /> </a>
                <!--  <p id="selMemberName" class="clsProfileThumbImg"><a class="clsFriendsName" href="{$myFriendsValue.memberProfileUrl}">{$myFriendsValue.friendName}</a></p>-->
                </li>
                {foreachelse}
                <div class="clsNoRecordsFound">{$LANG.myhome_my_friends_no_records}</div>
                {/foreach}
            	
                {else}
                <div class="clsNoRecordsFound">{$LANG.myhome_my_friends_no_records}</div>
            	{/if}
        	</ul>
        	
            {if $myobj->userDetails.total_friends > $myhome_total_friends_display}
        	<p class="clsViewAllFriends"><a href="{$myobj->getUrl('myfriends', '', '', 'members')}" title="{$LANG.myhome_link_friends_view_all}">{$LANG.myhome_link_friends_view_all}</a></p>
        	{/if}
		</div>
    </div>
    {include file='box.tpl' opt='myhomedetails_bottom'}
    {/if}
    
    {if $CFG.admin.myhome.show_friend_suggestions}
    <div class="ClsFriendsSuggestionCarouselContainer"> {$myobj->setTemplateFolder('general/')}
      {include file='box.tpl' opt='myhomedetails_top'}
      <div class="clsOverflow">
        <div class="clsMyHomeRecentVisitonsTitleLeft">
          <h3>{$LANG.myhome_friends_suggestion_title}</h3>
        </div>
      </div>
      <div class="ClsFriendsSuggestionCarousel">
	  {if isset($populateFriendSuggestions_arr.row) && ($populateFriendSuggestions_arr.row)}
        <ul id="carouselFriendSuggestions" class="jcarousel-skin-tango">
          {foreach item=friendSuggestions from=$populateFriendSuggestions_arr.row}
          <li id="suggestion_{$friendSuggestions.friend_id}">
             <div> <a class="ClsImageContainer Cls66x66 ClsImageBorder1 ClsImageMargin" href="{$friendSuggestions.memberProfileUrl}" id="{$friendSuggestions.anchor_id}"> 
			   <img src="{$friendSuggestions.icon.s_url}" alt="{$friendSuggestions.user_friend_name|truncate:7}" title="{$friendSuggestions.user_friend_name}" id="{$friendSuggestions.image_id}" {$myobj->DISP_IMAGE(#image_small_width#, #image_small_height#, $friendSuggestions.icon.s_width, $friendSuggestions.icon.s_height)}/> 
			  </a>
              <p id="selMemberName" class="ClsSuggestionName clsPaddingBottom5"><a href="{$friendSuggestions.memberProfileUrl}">{$friendSuggestions.user_friend_name}</a></p>
              <p class="ClsFriendsSuggestion"><a href="{$friendSuggestions.friend_add_url}">{$LANG.myhome_friends_suggestion_add_friend}</a></p>
             {* <p class="ClsDeleteList"><a title="Close" onclick="return openAjaxWindow('true', 'ajaxupdate', 'removeFriendSuggestion', '{$CFG.site.url}myHome.php?ajax_page=true', '{$friendSuggestions.friend_id}');">Close</a></p>*}
            </div>
          </li>
          {/foreach}
        </ul>
		{else}
          <div class="clsNoListDatas">{$LANG.myhome_friends_suggestion_no_records}</div>
		{/if}		
      </div>
      {include file='box.tpl' opt='myhomedetails_bottom'} </div>
    {literal}
    <script type="text/javascript">
                // <![CDATA[
                  jQuery(document).ready(function() {
					    jQuery('#carouselFriendSuggestions').jcarousel({
					        // Configuration goes here
					    });
					});
                // ]]>
                </script>
    {/literal}
    {/if}
    {if $CFG.admin.myhome.show_announcement}
    {if $populateAnnouncement_arr.row}
    {$myobj->setTemplateFolder('general/')}
    {include file='box.tpl' opt='myhomesidebar_top'}
    <div class="clsMyHomeSideBar">
      <div>
        <p class="clsMyHomeBarLeftTitle">{$LANG.myhome_announcement_title}</p>
      </div>
      <div class="clsSideBarRight">
        <div class="clsSideBarContent">
          <div style="height:{$myobj->announcment_height}px" onmouseover='stopScroll=1' onmouseout='stopScroll=0;scrollMe()' id="announcement_content"> {foreach key=announcementKey item=announcementValue from=$populateAnnouncement_arr.row}
            <div id="announcment_{$announcementKey}">{$announcementValue.description}</div>
            <br />
            <br />
            <hr style="background-color:#666666;border:1px solid #666666" size="2" />
            <br />
            <br />
            {/foreach} </div>
          {if $populateAnnouncement_arr.row}
          <div class="clsAnnouncementButtonContainer" id="announcement_controls" style="display:none"> <a class="clsAnnouncementPrevious" href="javascript:void(0);" onclick="stopScroll=0;scrollBack();" title="{$LANG.myhome_announcement_prev}">&nbsp;</a> <a class="clsAnnouncementPlay" href="javascript:void(0);" onclick="stopScroll=0;scrollMe();" title="{$LANG.myhome_announcement_play}">&nbsp;</a> <a class="clsAnnouncementStop" href="javascript:void(0);" onclick="stopScroll=1;" title="{$LANG.myhome_announcement_stop}">&nbsp;</a> </div>
          {/if} </div>
        <!-- End of div for rounded corners -->
      </div>
    </div>
    {include file='box.tpl' opt='myhomesidebar_bottom'}
    {else}
    <div class="clsMyHomeSideBanner">
	</div>
    {/if}
    {/if} </div>
  <!-- End of Right side content of myHome -->
</div>
