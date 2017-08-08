<ul class="clsTopWelcomeLinks">
	<!--  Member links Starts  -->
	{if isMember()}
    	<li class="clsBlock"><a class="{$header->getNavClass('left_index')} clsBlock" href="{$header->index_page_link}">{$LANG.header_lang_home}</a></li>

        {if $header->contentFilterTopLink() != ''}
            <li class="clsFilterStatusAlert clsBlock">
                  <span class="clsFilterStatus clsBlock">{$LANG.header_mature_warning}</span><span id="selContentFilterStatus" class="clsBlock">{$header->contentFilterTopLink}</span>
            </li>
        {/if}

        <li class="selDropDownLink clsBlock clsWelcomeSubMenuHead">
            <a class="clsBlock" href="{$header->my_profile_link}">{$CFG.user.user_name}</a>
            <ul>
                <li>
                    <div class="clsWelcomeSubMenuLinksContainer">
                        <ul class="clsWelcomeSubMenuLinks">
                            {foreach item=savalue from=$header->show_shortcuts_arr}
                                <li><a href="{$savalue.Link}">{$savalue.Link_Name}</a></li>
                            {/foreach}
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        {if $header->chkAllowedModule(array('mail'))}
            <li class="clsNewMail clsBlock">
                <a class="clsBlock" href="{$header->getUrl('mail', '?folder=inbox', 'inbox/', 'members')}" title="{$header->newMail}&nbsp;{if $header->newMail eq 1}{$LANG.header_new_mail}{else}{$LANG.header_new_mails}{/if}" >({$header->newMail})</a>
            </li>
        {/if}

        <li class="clsBlock clsInviteFriendLink">
            <a href="{$header->getUrl('membersinvite')}" class="{$header->getNavClass('left_invite')} clsBlock" title="{$LANG.header_link_members_invite}"><!----></a>
        </li>

        <li class="clsBlock">
            <a class="clsBlock clsDashboardLink" href="#" onclick="showDashboardPopup(); return false;" title="{$LANG.header_users_my_dshboard_msg_title}"><!----></a>
            <div style="display:none;" id="selDashBoard">
            {$myobj->setTemplateFolder('general/')}
            {include file='box.tpl' opt='popuplogin_top'}
                <div class="clsHeadingClose">
                    <div class="clsDashBoardHeading"><h3>{$LANG.header_users_dshboard_title}</h3></div>
                    <div class="clsClosePopUpLogin" onclick="showDashboardPopup();"> <!--<p>{$LANG.header_users_dshboard_cls_text}</p>--></div>
                </div>
                <div class="classDashBoardLinks">
                    {$header->populateMyHotLinks()}
                </div>
                {$myobj->setTemplateFolder('general/')}
                {include file='box.tpl' opt='popuplogin_bottom'}
            </div>
        </li>

        <li class="clsBlock clsStatusPickerLink">
        	{assign var=current_status value=$header->getCurrentStatus()}
            <a class="clsBlock" href="#" onclick="vj();return false" id="statusAnchor"><span class="status clsBlock" id="onlineStatusSpan" title="{$current_status.status}">{$current_status.wrapped_status}</span> </a>
            <span class="status clsBlock" id="onlineStatusFull" style="display:none">{$current_status.status}</span>
            <span onclick="pickStatus(this)" class="clsUserStatusIcon clsBlock"><!----></span>
        </li>

        {if isAdmin()}
        	<li class="adminIndex clsBlock"><a class="clsBlock" href="{$CFG.site.url}admin/index.php">{$LANG.header_admin_link}</a></li>
        {/if}

        {if $myobj->isFacebookUser()}
        	<li class="clsBlock"><a class="" href="{$header->getUrl('logout', '', '', 'root')}" onclick="return facebookLogout();">{$LANG.header_logout_link}</a></li>
        {else}
            <li class="clsBlock"><a class="" href="{$header->getUrl('logout', '', '', 'root')}">{$LANG.header_logout_link}</a></li>
        {/if}
   	{/if}
	<!--  Member links ends  -->

   	{if !isMember()}
       	{if $header->chkAllowedModule(array('login'))}
       		{if $CFG.html.current_script_name|lower neq 'login'}
       			<li class="clsBlock clsLoginLink"><a class="clsBlock" href="{$header->getUrl('login', '', '', 'root')}" onclick="showLoginPopup(); return false;">{$LANG.header_login_link}</a></li>
       		{else}
			   <li class="clsBlock clsLoginLink"><a class="clsBlock" href="{$header->getUrl('login', '', '', 'root')}">{$LANG.header_login_link}</a></li>
       		{/if}
       	{/if}
       	{if $header->chkAllowedModule(array('signup'))}
      		<li class="clsBlock clsSignupLink"><a class="clsBlock" href="{$header->getUrl('signup', '', '', 'root')}">{$LANG.header_signup_link}</a></li>
       	{/if}
   	{/if}

    <!-- End of Stylesheet switcher -->
    {$myobj->getTpl('general','styleSheetSwitcher.tpl')}
    <!-- End of Stylesheet switcher -->

    <!-- start of Multi-language support -->
    {$myobj->getTpl('general','multiLanguage.tpl')}
    <!-- End of Multi-language support -->
</ul>
{if !isMember() and $header->chkAllowedModule(array('login')) and $CFG.html.current_script_name|lower neq 'login'}
	<div id="selHeaderLoginPopup" style="display:none">
		{$header->populateLoginFormFields($myobj)}
		{$myobj->setTemplateFolder('root/')}
		{include file='loginpopup.tpl' opt='popup'}
	</div>
	{literal}
		<script language="javascript" type="text/javascript">
			var showLoginPopup = function(){
				$Jq('#selHeaderLoginPopup').slideToggle('slow');
			};
		</script>
	{/literal}
{/if}

{if isMember()}
	{literal}
		<script language="javascript" type="text/javascript">
			var showDashboardPopup = function(){
				$Jq('#selDashBoard').slideToggle('slow');
			};
		</script>
	{/literal}
{/if}

