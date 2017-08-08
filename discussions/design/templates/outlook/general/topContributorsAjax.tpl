   {if  $CFG.admin.block_user && $myobj->getFormField('uid') neq $CFG.user.user_id and !$myobj->form_user_details.displayUserDetails.isMutualFriend}
	<li class="" id="selShowIgnoreUser">
		{if isMember()}
			{if  $myobj->isIgnoredUser($myobj->getFormField('uid')) }
			  	<a href="{$myobj->getCurrentUrl('true')}" onClick="{$myobj->form_user_details.displayUserDetails.toggleFavorites1}" class="clsUnblockUser">{$LANG.mysolutions_unignore_user}</a>
			{else}
				<a href="{$myobj->getCurrentUrl('true')}" onClick="{$myobj->form_user_details.displayUserDetails.toggleFavorites1}" class="clsBlockUser">{$LANG.mysolutions_ignore_user}</a>
			{/if}
		{else}
		  	<a href="{$myobj->form_user_details.displayUserDetails.mysolutions_mem_url}" class="clsBlockUser">{$LANG.mysolutions_ignore_user}</a>
		{/if}
	</li>
	{/if}
	{if !$myobj->form_user_details.displayUserDetails.isAmBlocked}
			{if $myobj->getFormField('uid') neq $CFG.user.user_id and $CFG.admin.friends.allowed and isMember()}
				<li id="send_req_{$myobj->getFormField('uid')}" class="clsAddUser" style="{$myobj->form_user_details.displayUserDetails.profile_friend.req}">
					<a href="javascript:void(0);" onClick="ajaxUpdateDiv('{$myobj->form_user_details.displayUserDetails.profile_friend.url}', 'ajax_page=true&sendRequest=1&uid={$myobj->getFormField('uid')}&request_from={$CFG.user.user_id}&request_to={$myobj->getFormField('uid')}', 'upDating');return false;">{$LANG.friend_add}</a>
				</li>
				<li id="remove_fri_{$myobj->getFormField('uid')}" class="clsRemoveUser" style="{$myobj->form_user_details.displayUserDetails.profile_friend.rem}">
					<a href="javascript:void(0);" onClick="ajaxUpdateDiv('{$myobj->form_user_details.displayUserDetails.profile_friend.url}', 'ajax_page=true&removeFriend=1&uid={$myobj->getFormField('uid')}&request_from={$CFG.user.user_id}&request_to={$myobj->getFormField('uid')}', 'upDating');return false;">{$LANG.friend_remove}</a>
				</li>
				<li id="remove_req_{$myobj->getFormField('uid')}" class="clsRemoveUser" style="{$myobj->form_user_details.displayUserDetails.profile_friend.rem_req}">
					<a href="javascript:void(0);" onClick="ajaxUpdateDiv('{$myobj->form_user_details.displayUserDetails.profile_friend.url}', 'ajax_page=true&removeRequest=1&uid={$myobj->getFormField('uid')}&request_from={$CFG.user.user_id}&request_to={$myobj->getFormField('uid')}', 'upDating');return false;">{$LANG.friend_remove_request}</a>
				</li>
			{/if}
			{if $myobj->getFormField('uid') neq $CFG.user.user_id and isMember()}

				    <li id="msg_{$myobj->getFormField('uid')}_msg"><span class="clsProfileMessage">{$myobj->form_user_details.displayUserDetails.profile_friend.msg}</span></li>
					<li id="accept_{$myobj->getFormField('uid')}" class="clsAddUser" style="{$myobj->form_user_details.displayUserDetails.profile_friend.accept}">
						<a href="javascript:void(0);" onClick="ajaxUpdateDiv('{$myobj->form_user_details.displayUserDetails.profile_friend.url}', 'ajax_page=true&acceptRequest=1&uid={$myobj->getFormField('uid')}&request_from={$myobj->getFormField('uid')}&request_to={$CFG.user.user_id}', 'upDating');return false;">{$LANG.friend_accept}</a>
					</li>
					<li id="reject_{$myobj->getFormField('uid')}" class="clsRemoveUser" style="{$myobj->form_user_details.displayUserDetails.profile_friend.rej}">
						<a href="javascript:void(0);" onClick="ajaxUpdateDiv('{$myobj->form_user_details.displayUserDetails.profile_friend.url}', 'ajax_page=true&rejectRequest=1&uid={$myobj->getFormField('uid')}&request_from={$myobj->getFormField('uid')}&request_to={$CFG.user.user_id}', 'upDating');return false;">{$LANG.friend_reject}</a>
					</li>
			{/if}
	{else}
	<li class="clsAddUser"><span><a href="" onclick="alert_manual('{$LANG.friend_request_blocked}');return false;">{$LANG.friend_add}</a></span></li>
	{/if}