<div class="clsRightCoolMemberLeft">
		<div class="clsRightCoolMemberRight">
	<div class="clsRightCoolMemberMiddle">
			<div class="clsCoolMemberDetail">
				<p class="clsCoolMemberImage">
					<a href="{$myobj->displayUserDetails_arr.getMemberProfileUrl}">
					{if $myobj->displayUserDetails_arr.icon}
						<img src="{$myobj->displayUserDetails_arr.icon.t_url}" alt="{$myobj->displayUserDetails_arr.record.user_name}" title="{$myobj->displayUserDetails_arr.record.user_name}" {$myobj->DISP_IMAGE(#image_thumb_width#, #image_thumb_height#, $myobj->displayUserDetails_arr.icon.t_width, $myobj->displayUserDetails_arr.icon.t_height)} />
					{else}
						<img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/no_photo.jpg" alt="{$myobj->displayUserDetails_arr.record.user_name}"  />
					{/if}
					</a>
                </p>
               <div class="clsCoolMemberInformation"> <p>
					<a href="{$myobj->displayUserDetails_arr.getMemberProfileUrl}" title="{$myobj->displayUserDetails_arr.record.user_name}">
						{$myobj->displayUserDetails_arr.record.user_name}
					</a>
				</p>
                {if $myobj->displayUserDetails_arr.record.show_dob}
                    <p>
                        {$LANG.common_members_age}: {$myobj->displayUserDetails_arr.record.age}
                    </p>
				{/if}
				<p>
                    {$LANG.common_total_video}: ({$myobj->displayUserDetails_arr.record.total_videos})

             	</p>
                 <p>
                	<ul id="selMemDetails" class="clsMembersList clsClearLeft">
                       {if isMember()}
                           {if $CFG.user.user_id != $myobj->displayUserDetails_arr.uid}
                              <li id="selSendMsg"><a class="clsSendMessage clsPhotoVideoEditLinks" href="{$myobj->displayUserDetails_arr.mailComposeUrl}" title="{$LANG.member_list_send_message}">{$LANG.member_list_send_message}</a></li>
                              {if $myobj->displayUserDetails_arr.friend == 'yes'}
                                  <li id="selAlReadyFriend"><a title="{$LANG.members_list_friend}" class="clsPhotoVideoEditLinks">{$LANG.members_list_friend}</a></li>
                              {else}
                                  <li id="selAddFriend"><a class="clsAddToFriends clsPhotoVideoEditLinks" href="{$myobj->displayUserDetails_arr.friendAddUrl}" title="{$LANG.member_list_add_friend}">{$LANG.member_list_add_friend}</a></li>
                              {/if}
                           {/if}
                        {if $CFG.admin.members_listing.online_status}
                            <li class="clsOnline"><a class="clsPhotoVideoEditLinks {$myobj->displayUserDetails_arr.onlineStatusClass}" title="{$myobj->displayUserDetails_arr.currentStatus}">{$myobj->displayUserDetails_arr.currentStatus}</a></li>
                        {/if}

                       {else}
                              <li id="selSendMsg"><a class="clsSendMessage" href="{$myobj->displayUserDetails_arr.mailComposeUrl}" title="{$LANG.member_list_send_message}">{$LANG.member_list_send_message}</a></li>
                              <li id="selAddFriend"><a class="clsAddToFriends" href="{$myobj->displayUserDetails_arr.friendAddUrl}" title="{$LANG.member_list_add_friend}">{$LANG.member_list_add_friend}</a></li>
                       {/if}
                    </ul>
                </p>
				</div>
			</div>
		</div>
	</div>
</div>