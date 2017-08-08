<div class="clsSideBarSections clsClearFix">
  <div class="clsSideBarContents">
    <!--rounded corners-->
	{$myobj->setTemplateFolder('general/', 'discussions')}
	{include file='box.tpl' opt='sidebar_top'}
	  <h3>{$showUserInfo_arr.display_name_manual}</h3>
		<div class="clsUserInfo clsClearFix">

				  {if $showUserInfo_arr.isProfile}
				  <div class="clsUserInfoLeft">
					 {if isUserImageAllowed()}
						{$discussion->displayProfileImage($showUserInfo_arr.userDetails, 'thumb', false)}
					 {/if}
					   </div>
						<div class="clsUserInfoRight">
					 <ul class="clsUserLinks">

						{if $showUserInfo_arr.isOnline}
						<li class="clsOnline"><span >{$LANG.header_online}</span></li>
						{else}
						<li class="clsOffline"><span >{$LANG.header_offline}</span></li>
						{/if}

						<li class="clsProfileView"><a href="{$showUserInfo_arr.public_profile}">{$LANG.header_public_profile}</a></li>
						<li class="clsProfileEdit"><a href="{$showUserInfo_arr.edit_info}">{$LANG.edit_info_text}</a></li>
						</ul>
						<p class="clsUserProfileLastLoged">{$LANG.header_lastlogged}</p>
						<p class="clsUserProfileDate">{$showUserInfo_arr.lastLogged}</p>

					 </div>
				  {else}
				   <div class="clsUserInfoLeft">
					{if isUserImageAllowed()}
						{$discussion->displayProfileImage($showUserInfo_arr.userDetails, 'medium', false)}
					{/if}
					{if $showUserInfo_arr.isOnline}
						<p class="clsOnline">{$LANG.header_online}</p>
					{else}
						<p class="clsOffline">{$LANG.header_offline}</p>
					{/if}
					</div>
					<div class="clsUserInfoRight">
						<ul class="clsUserLinks">
						  {if $myobj->chkAllowedModule(array('mail'))}
							<li class="clsProfileInbox"><a href="{$showUserInfo_arr.inbox_link}">{$LANG.header_total_msg}</a> <span class="clsTotalPoints">(<a href="{$showUserInfo_arr.inbox_link}">{$showUserInfo_arr.inbox}</a>)</span></li>
						  {/if}
						  <li class="clsProfileFav"><a href="{$showUserInfo_arr.favorites_link}">{$LANG.header_total_favs}</a> <span class="clsTotalPoints">(<a href="{$showUserInfo_arr.favorites_link}">{$showUserInfo_arr.favorites}</a>)</span></li>
						  <li class="clsProfilePosts"><a href="{$showUserInfo_arr.total_postlink}">{$LANG.discuzz_common_boards}</a> <span class="clsTotalPoints">(<a href="{$showUserInfo_arr.total_postlink}">{$showUserInfo_arr.userLog.total_board}</a>)</span></li>
						  <li class="clsProfileView"><a href="{$showUserInfo_arr.public_profile}">{$LANG.header_public_profile}</a></li>
						  <li class="clsProfileEdit"><a href="{$showUserInfo_arr.edit_info}">{$LANG.edit_info_text}</a></li>
						 </ul>
					</div>
				{/if}

		</div>
	 {$myobj->setTemplateFolder('general/', 'discussions')}
	{include file='box.tpl' opt='sidebar_bottom'}        
    <!--end of rounded corners-->
  </div>
</div>