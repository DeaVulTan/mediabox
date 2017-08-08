{foreach item=videoValue from=$videoActivity_arr}
    {if $key == $videoValue.parent_id}
    	{if $videoValue.action_key == 'video_uploaded'}
            <div class="clsWhatsGoingUserDetails">
				<div class="clsWhatsGoingBg clsOverflow">
				  <div class="clsFloatLeft">
				  	<a href="{$videoValue.video_uploaded.viewvideo.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						 <img src="{$videoValue.video_uploaded.profileIcon.s_url}" border="0" title="{$videoValue.video_uploaded.user_name}"  {$myobj->DISP_IMAGE(45, 45, $videoValue.video_uploaded.profileIcon.s_width, $videoValue.video_uploaded.profileIcon.s_height)}/>
					</a>
				  </div>
				  <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$videoValue.video_uploaded.uploaded_user.url}">{$videoValue.video_uploaded.user_name}</a>
						</div>
						<div class="clsFloatRight">
							<span>{$videoValue.video_uploaded.date_added}</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}video/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/common/icon-videoupload.gif" border="0" />{$videoValue.video_uploaded.lang} <a href="{$videoValue.video_uploaded.viewvideo.url}"> {$videoValue.video_uploaded.video_title}</a>
					</div>
			       </div>
               </div>
           </div>
        {elseif $videoValue.action_key == 'video_comment'}
           <div class="clsWhatsGoingUserDetails">
				<div class="clsWhatsGoingBg clsOverflow">
				  <div class="clsFloatLeft">
				  	<a href="{$videoValue.video_comment.viewvideo.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						 <img src="{$videoValue.video_comment.profileIcon.s_url}" border="0" title="{$videoValue.video_comment.user_name}"  {$myobj->DISP_IMAGE(45, 45, $videoValue.video_comment.profileIcon.s_width, $videoValue.video_comment.profileIcon.s_height)} />
					</a>
				  </div>
				  <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$videoValue.video_comment.comment_user.url}">{$videoValue.video_comment.user_name}</a>
						</div>
						<div class="clsFloatRight">
							<span>{$videoValue.video_comment.date_added}</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}video/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/common/icon-videocomment.gif" border="0" />{$videoValue.video_comment.lang} <a href="{$videoValue.video_comment.viewvideo.url}">{$videoValue.video_comment.video_title}</a>
					</div>
			       </div>
               </div>
           </div>
		{elseif $videoValue.action_key == 'video_rated'}
              <div class="clsWhatsGoingUserDetails">
				<div class="clsWhatsGoingBg clsOverflow">
				  <div class="clsFloatLeft">
				  	<a href="{$videoValue.video_rated.viewvideo.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						 <img src="{$videoValue.video_rated.profileIcon.s_url}" border="0" title="{$videoValue.video_comment.user_name}"  {$myobj->DISP_IMAGE(45, 45, $videoValue.video_rated.profileIcon.s_width, $videoValue.video_rated.profileIcon.s_height)} />
					</a>
				  </div>
				  <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$videoValue.video_rated.comment_user.url}">{$videoValue.video_rated.user_name}</a>
						</div>
						<div class="clsFloatRight">
							<span>{$videoValue.video_rated.date_added}</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}video/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/common/icon-videorating.gif" border="0" />{$videoValue.video_rated.lang} <a href="{$videoValue.video_rated.viewvideo.url}"> {$videoValue.video_rated.video_title}</a>
					</div>
			       </div>
               </div>
           </div>
         {elseif $videoValue.action_key == 'video_favorite'}
            <div class="clsWhatsGoingUserDetails">
				<div class="clsWhatsGoingBg clsOverflow">
				  <div class="clsFloatLeft">
				  	<a href="{$videoValue.video_favorite.viewvideo.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						 <img src="{$videoValue.video_favorite.profileIcon.s_url}" border="0" title="{$videoValue.video_favorite.user_name}"  {$myobj->DISP_IMAGE(45, 45, $videoValue.video_favorite.profileIcon.s_width, $videoValue.video_favorite.profileIcon.s_height)} />
					</a>
				  </div>
				  <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$videoValue.video_favorite.comment_user.url}">{$videoValue.video_favorite.user_name}</a>
						</div>
						<div class="clsFloatRight">
							<span>{$videoValue.video_favorite.date_added}</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}video/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/common/icon-videofavorite.gif" border="0" />{$videoValue.video_favorite.lang} <a href="{$videoValue.video_favorite.viewvideo.url}"> {$videoValue.video_favorite.video_title}</a>
					</div>
			       </div>
               </div>
           </div>
         {elseif $videoValue.action_key == 'video_featured'}
           <div class="clsWhatsGoingUserDetails">
				<div class="clsWhatsGoingBg clsOverflow">
				  <div class="clsFloatLeft">
				  	<a href="{$videoValue.video_featured.viewvideo.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						 <img src="{$videoValue.video_featured.profileIcon.s_url}" border="0" title="{$videoValue.video_featured.user_name}"   {$myobj->DISP_IMAGE(45, 45, $videoValue.video_featured.profileIcon.s_width, $videoValue.video_featured.profileIcon.s_height)} />
					</a>
				  </div>
				  <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$videoValue.video_featured.comment_user.url}">{$videoValue.video_featured.user_name}</a>
						</div>
						<div class="clsFloatRight">
							<span>{$videoValue.video_featured.date_added}</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
					<img src="{$CFG.site.url}video/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/common/icon-videofeatured.gif" border="0" />{$videoValue.video_featured.lang} <a href="{$videoValue.video_featured.viewvideo.url}"> {$videoValue.video_featured.video_title}</a>
					</div>
			       </div>
               </div>
           </div>
         {elseif $videoValue.action_key == 'video_responded'}
           <div class="clsWhatsGoingUserDetails">
				<div class="clsWhatsGoingBg clsOverflow">
				  <div class="clsFloatLeft">
				  	<a href="{$videoValue.video_responded.viewvideo.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						 <img src="{$videoValue.video_responded.profileIcon.s_url}" border="0" title="{$videoValue.video_responded.responses_user_name}"  {$myobj->DISP_IMAGE(45, 45, $videoValue.video_responded.profileIcon.s_width, $videoValue.video_responded.profileIcon.s_height)} />
					</a>
				  </div>
				  <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$videoValue.video_responded.responses_user.url}">{$videoValue.video_responded.responses_user_name}</a>
						</div>
						<div class="clsFloatRight">
							<span>{$videoValue.video_responded.date_added}</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}video/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/common/icon-videoresponse.gif" border="0" />{$videoValue.video_responded.lang} <a href="{$videoValue.video_responded.viewvideo.url}"> {$videoValue.video_responded.video_title}</a>
					</div>
			       </div>
               </div>
           </div>

         {elseif $videoValue.action_key == 'video_share'}
             <div class="clsWhatsGoingUserDetails">
				<div class="clsWhatsGoingBg clsOverflow">
				  <div class="clsFloatLeft">
				  	<a href="{$videoValue.video_share.viewvideo.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						 <img src="{$videoValue.video_share.profileIcon.s_url}" border="0" title="{$videoValue.video_share.sender_user_name}"  {$myobj->DISP_IMAGE(45, 45, $videoValue.video_share.profileIcon.s_width, $videoValue.video_share.profileIcon.s_height)}/>
					</a>
				  </div>
				  <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$videoValue.video_share.comment_user.url}">{$videoValue.video_share.sender_user_name}</a>
						</div>
						<div class="clsFloatRight">
							<span>{$videoValue.video_share.date_added}</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}video/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/common/icon-videoshared.gif" border="0" />{$videoValue.video_share.lang1} <a href="{$videoValue.video_share.viewvideo.url}"> {$videoValue.video_share.video_title}</a>
					</div>
			       </div>
               </div>
           </div>
        {/if}
 	{/if}
{/foreach}