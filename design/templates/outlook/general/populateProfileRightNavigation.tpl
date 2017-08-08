{include file="box.tpl" opt="sidebar_top"}

<div class="clsSideBarLinks" id="selProfileHome">
	<div class="clsSideBar"><div >
	<p class="clsSideBarLeftTitle">{$LANG.header_nav_profile_home}</p>
</div>

<div class="clsSideBarRight">
 <div class="clsSideBarContent">
  <ul>
  	<li ><a href="{$myobj->getUrl('myprofile')}">{$LANG.header_nav_profile_myprofile_page}</a></li>
    <li class="{$profileAvatar_class}"><a href="{$myobj->getUrl('profileavatar')}">{$LANG.header_nav_profile_avatar}</a></li>
    <li class="{$profileBasic_class}"><a href="{$myobj->getUrl('profilebasic')}">{$LANG.header_nav_profile_basic}</a></li>
    {foreach key=inc item=value from=$profile_li_arr}
		<li class="{$value.profileInfo_class}"><a href="{$value.profileInfo_link}">{$value.profileInfo_record.title}</a></li>
	{/foreach}
    <li class="{$profileSettings_class}"><a href="{$myobj->getUrl('profilesettings')}">{$LANG.header_nav_profile_settings}</a></li>
    <li class="{$notificationSettings_class}"><a href="{$myobj->getUrl('notificationsettings')}">{$LANG.header_nav_email_notification_settings}</a></li>
{if $CFG.profile.set_background}
    <li class="{$profileBackground_class}"><a href="{$myobj->getUrl('profilebackground')}">{$LANG.header_nav_profile_background}</a></li>
{/if}
{if $userDetails.openid_used == 'No'}
    <li class="{$profilePassword_class}"><a href="{$myobj->getUrl('profilepassword')}">{$LANG.common_password}</a></li>
{/if}
{if chkAllowedModule(array('customize_profile'))}
    <li class="{$profileThemeDesign_class}"><a href="{$myobj->getUrl('profilethemedesign')}">{$LANG.header_nav_profile_customize}</a></li>
    <li class="{$profileTheme_class}"><a href="{$myobj->getUrl('profiletheme', '?block=myscraps', '?block=myscraps')}">{$LANG.header_nav_profile_theme}</a>
		{if $profile_theme_arr}
        	<ul>
            	{foreach item=profile_theme from=$profile_theme_arr}
					<li class="{$profile_theme.class}"><a href="{$profile_theme.url}">{$profile_theme.lang}</a></li>
                {/foreach}
            </ul>
        {/if}
    </li>
   {/if}
  </ul>

</div></div></div></div>

{include file="box.tpl" opt="sidebar_bottom"}