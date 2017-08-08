<div{if $myobj->profile_background && $myobj->background_offset} style="margin-top:{$myobj->background_offset}px;"{/if}>
	<div class="clsViewProfileContent">
        {include file='information.tpl'}
        {if $myobj->isShowPageBlock('form_show_profile')}

		    <!-- confirmation box -->
		    <div id="selMsgConfirm" style="display:none;">
				<p id="confirmMessage"></p>
				<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
					<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
					&nbsp;
					<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onclick="$Jq('#selMsgConfirm').dialog('close');" />
					<input type="hidden" name="block_id" id="block_id" />
					<input type="hidden" name="action" id="action" />
				</form>
			</div>
		    <!-- confirmation box-->

        	{include file='box.tpl' opt='profilebox_top'}
        		<div class="clsOverflow">
				
				    <div class="clsProfileTopContent">					
					  <div class="clsProfileTopLeftContent">
						<div class="clsViewProfileTitle">
                        	<div style="display:none" id="userLayout">
                           		{$myobj->form_show_profile.style}
                        		</div>
                        		<span class="clsUserProfileName">{$myobj->form_show_profile.user_details_arr.user_name}</span>

								{*SUBSCRIPTION LINK FOR USER STARTS HERE*}
                           		{if chkIsSubscriptionEnabled()}
									{if isMember()}
                              			{if $myobj->getFormField('user_id') != $CFG.user.user_id}
                                          	<p class="clsSubscriptionBtn">
                                          		<a href="javascript:void(0);" id="anchor_subscribe" onclick="get_subscription_options({$myobj->getFormField('user_id')}, 50, -10, 'anchor_subscribe');">{$LANG.common_subscriptions}</a>
                                          	</p>
                                    	{/if}
                              		{/if}
                           		{/if}
				   				{*SUBSCRIPTION LINK FOR USER ENDS HERE*}                          	
                     	</div>
					  </div>
					  
					  <div class="clsProfileTopRightContent">	
					   <div class="clsLoginDate">				
						<span>{$LANG.user_details_since} <span class="clsBold">{$myobj->form_show_profile.user_details_arr.doj|date_format:#format_datetime#}</span>
						 <span>&nbsp; | &nbsp;</span>
						 {$LANG.myprofile_last_logged}: 
						<span>
						 {if $myobj->form_show_profile.user_details_arr.last_logged neq '0000-00-00 00:00:00'}
						   {$myobj->form_show_profile.user_details_arr.last_logged|date_format:#format_datetime#}
						{else}
						  {$LANG.myprofile_first_logged}
						{/if}
					     </span>
						</span>
						{if isMember() && $myobj->form_show_profile.currentAccount}
						  <span class="clsViewProfileEdit">
							<span><a href="{$myobj->form_show_profile.displayBasicEditLink}" >{$LANG.viewProfile_edit_profile_basic_link}</a></span>
							   <span>&nbsp; | &nbsp;</span>
							<span><a href="{$myobj->form_show_profile.displayAvatarEditLink}" >{$LANG.viewProfile_edit_profile_avatar_link}</a></span>
						  </span> 
						{/if}
					  </div>
					  	
					{if !$myobj->form_show_profile.currentAccount}
					   <span id="selProfileLinks">
						{if !$myobj->form_show_profile.NextProfile}
						  <span id="selProfileNext" class="clsNextProfile"><a href="{$myobj->form_show_profile.NextProfileUrl}">{$LANG.profile_navi_next_profile}</a></span>
						{/if}
					   </span>
				   {/if}	
						
				  </div>	
				
				</div>
				
				<div class="clsProfileMainBarContent">
       		 		<div class="clsProfileLeftContent">
             			<div class="clsViewProfileImage">
                      		<p id="selImageBorder">
                        		<span id="selPlainCenterImage">
                        			<a href="{$myobj->form_show_profile.user_details_arr.profile_url}" class="ClsProfileImageContainer ClsProfileImageBorder ClsProfile90x90">
                            			<img src="{$myobj->form_show_profile.userIcon.t_url}" alt="{$myobj->form_show_profile.user_details_arr.user_name|truncate:9}" border="0" {$myobj->DISP_IMAGE(#image_thumb_width#, #image_thumb_height#, $myobj->form_show_profile.userIcon.t_width, $myobj->form_show_profile.userIcon.t_height)} />
                            		</a>
                        		</span>
                      		</p>
             			</div>

                		<div class="clsUserProfileDetails">
                    		{$myobj->form_show_profile.defaultBlockTitle}
                    		<div class="clsUserDetailLinks clsUserDetailLinksBg">
                    			<ul>
                    				{if !empty($myobj->form_show_profile.myprofile_age)}
                    					<li>{$myobj->form_show_profile.myprofile_age.caption}:&nbsp; <span>{$myobj->form_show_profile.myprofile_age.text}</span></li>
                    				{/if}
                    				{if !empty($myobj->form_show_profile.gender)}
                    					<li>{$myobj->form_show_profile.gender.caption}:&nbsp; <span class="{$myobj->form_show_profile.gender_class}" id="{$myobj->form_show_profile.gender_id}">{$myobj->form_show_profile.gender.text}</span></li>
                    				{/if}
                    				{if $myobj->form_show_profile.show_dob}
                    					<li>{$LANG.myprofile_birthday}:&nbsp; <span id="{$myobj->form_show_profile.birthday_id}" class="{$myobj->form_show_profile.birthday_class}">{$myobj->form_show_profile.user_details_arr.dob|date_format:#format_date#}</span></li>
                    				{/if}
								</ul>
                    		</div>
                    		<div class="clsUserDetailLinks clsUserDetailLinksMore">
								<ul>
                    				{if !empty($myobj->form_show_profile.myprofile_country)}
                    					<li>{$myobj->form_show_profile.myprofile_country.caption}:&nbsp; <span class="{$myobj->form_show_profile.country_class}" id="{$myobj->form_show_profile.country_id}">{$myobj->form_show_profile.myprofile_country.text}</span></li>
                    				{/if}
                    				{if !empty($myobj->form_show_profile.myprofile_relation_status)}
                    					<li>{$myobj->form_show_profile.myprofile_relation_status.caption}:&nbsp; <span class="{$myobj->form_show_profile.relation_class}" id="{$myobj->form_show_profile.relation_id}">{$myobj->form_show_profile.myprofile_relation_status.text}</span></li>
                    				{/if}
									{if $myobj->form_show_profile.show_dob}
                    					<li>{$LANG.myprofile_zodiac}:&nbsp; <span>{$myobj->form_show_profile.dob_zodiac}</span></li>
                    				{/if}
                    			</ul>
                    		</div>
                		</div>
             		</div>

             		<div class="clsProfileRightContent">                    	
                    	<div class="clsUrlTitleContainer">
                        	<table class="clsURLTable">
								<tr>
									<th><span class="clsUrlTitle">{$LANG.myprofile_url}</span></th>
                        			<td><div class="clsUrlTextBox" id="purl" onclick="fnSelect('purl')" >{$myobj->form_show_profile.myProfileUrl}</div></td>
								</tr>
								{if $myobj->form_show_profile.myweburl}
							         <tr>
							          <th><span class="clsUrlTitle">{$LANG.myprofile_web_url}</span></th>
							          <td><div class="clsUrlTextBox {$myobj->form_show_profile.myweburl_class}" id="{$myobj->form_show_profile.myweburl_id}">{$myobj->form_show_profile.myweburl}</div></td>
							        </tr>
							    {/if}
							</table>
                    	</div>
						{if !$myobj->form_show_profile.currentAccount}
            			<div class="clsCurrentUserLinks">
                			<div class="clsProfileLinksMain">
                        			<ul class="clsUserActionsLinks">
                        				{if chkAllowedModule(array('community', 'groups'))}
                            				<li id="selAddGp"><a href="{$myobj->form_show_profile.profileAddToGroup}" id="selAddToGroupLinkId" >{$LANG.profile_navi_add_to_group}</a></li>
                        				{/if}
                         				{if isLoggedIn() && !$myobj->chkAlreadyBlock()}
                            				<li id="selAddBlock" class="clsBlockUser {if !chkAllowedModule(array('mail'))}clsViewProfileNoBorder{/if}" ><a href="{$myobj->getCurrentUrl()}" id="selBlockLinkId" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('block_id', 'action', 'confirmMessage'), Array({$myobj->getFormField('user_id')}, 'Block', '{$LANG.viewprofile_block_confirm_message}'), Array('value', 'value', 'html'));">{$LANG.profile_navi_block_user}</a></li>
                         				{/if}
                         				{if isLoggedIn() && $myobj->chkAlreadyBlock()}
                            				<li id="selAddBlock" class="clsBlockUser {if !chkAllowedModule(array('mail'))}clsViewProfileNoBorder{/if}" ><a href="{$myobj->getCurrentUrl()}" id="selUnblockLinkId" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('block_id', 'action', 'confirmMessage'), Array({$myobj->getFormField('user_id')}, 'Unblock', '{$LANG.viewprofile_unblock_confirm_message}'), Array('value', 'value', 'html'));">{$LANG.profile_navi_un_block_user}</a></li>
                         				{/if}
                         				{if isLoggedIn()}
                         				<li><a href="javascript:void(0);" onclick="return openAjaxWindow('true', 'ajaxupdate', 'reportUser', '{$myobj->reportLink}');">{$LANG.report_user}</a></li>
                         				{/if}
                        				{if chkAllowedModule(array('mail'))}
                            				<li id="selForward" class="clsForwardToFriend"><a href="{$myobj->form_show_profile.profileMailCompose}" id="selForwardLinkId">{$LANG.profile_navi_forward_to_friend}</a></li>
                        				{/if}
										
                           				{if !$myobj->form_show_profile.AlreadyFriend}
                           					<li id="selProfileAddFriend" class="clsAddToFriends"><a href="{$myobj->form_show_profile.AddFriendUrl}" id="selAddFriendLinkId">{$LANG.profile_navi_add_to_friends}</a></li>
                           				{/if}
                           				<li id="selProfileSendMail" class="clsSendMessage clsViewProfileNoBorder"><a href="{$myobj->form_show_profile.SendMessage}" id="selSendMessageLinkId">{$LANG.profile_navi_send_message}</a></li>
                  					</ul>
                				</div>
            			</div>
        			{/if}
				 
				
					<form name="form_profile_block" id="form_profile_block" method="post" action="{$myobj->getCurrentUrl()}">
	        		{if $CFG.profile_block.re_order && isMember() && $myobj->form_show_profile.currentAccount && $myobj->isMyProfilPage}
					  <div class="clsUpdateOrder">
	        			<div id="user_actions" class="clsFloatLeft">
	        				<input id="left"  type="hidden" name="left" />
	        				<input id="right"  type="hidden" name="right" />
							<input id="showButton" value="{$LANG.viewprofile_update_order}" name="update_order" type="submit" />
	        			</div>
	        			<div class="clsUpdateOrderContent">{$LANG.viewprofile_reorder_block_user_message}</div>
					 </div>
	        		{/if}
	        	</form>
				
			</div>
				</div>				
					
        		</div>
			{include file='box.tpl' opt='profilebox_bottom'}

	        	
	        <div>

		        <div class="clsProfilePageLeftContent">
		          	<ul id="ul1" class="clsDraglist">
		          		{if $myobj->left_arr}
		               		{foreach key=item  item=Lvalue from=$myobj->show_profile_block.profile_block.left}
		                 		{if $Lvalue.include_filename!=''}
		                     		{if $Lvalue.module_folder=='default'}
		                     			{$myobj->setTemplateFolder('general/')}
		                     		{else}
		                     			{$myobj->setTemplateFolder('general/',$Lvalue.module_folder)}
		                     		{/if}
		                 			<li id="{$Lvalue.block_name}">{include file=$Lvalue.include_filename selected_category=$Lvalue.sel_category}</li>
		                  		{/if}
		               		{/foreach}
		          		{/if}
		          	</ul>
		        </div>

		        <div class="clsProfilePageRightContent">
		          	<ul id="ul2" class="clsDraglist">
		          		{if $myobj->right_arr}
		               		{foreach key=item item=Rvalue from=$myobj->show_profile_block.profile_block.right}
		                 		{if $Rvalue.include_filename!=''}
		                 			{if $Rvalue.module_folder=='default'}
		                 				{$myobj->setTemplateFolder('general/')}
		                 			{else}
		                 				{$myobj->setTemplateFolder('general/',$Rvalue.module_folder)}
		                 			{/if}
		                			<li id="{$Rvalue.block_name}">{include file=$Rvalue.include_filename selected_category=$Rvalue.sel_category}</li>
		                 		{/if}
		               		{/foreach}
		          		{/if}
		          	</ul>
        		</div>
    		</div>
        {/if}{* end of show_profile_block *}
    </div>
</div>