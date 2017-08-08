{foreach item=blogValue from=$blogActivity_arr}
   {if $key == $blogValue.parent_id}
   		{if $blogValue.action_key == 'blog_created'}
		<div class="clsWhatsGoingUserDetails">
				<div class="clsWhatsGoingBg clsOverflow">
					<div class="clsFloatLeft">
						<a href="{$blogValue.blog_created.viewpost.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
							<img src="{$blogValue.blog_created.profileIcon.s_url}" border="0" title="{$blogValue.blog_created.user_name}"  {$myobj->DISP_IMAGE(45, 45, $blogValue.blog_created.profileIcon.s_width, $blogValue.blog_created.profileIcon.s_height)}/>
						</a>
					</div>
					<div class="clsUserDetailsFriends">
						<div class="clsOverflow clsWhatsGoingUser">
							<div class="clsFloatLeft">
								<a href="{$blogValue.blog_created.uploaded_user.url}">{$blogValue.blog_created.user_name}</a>
							</div>
							<div class="clsFloatRight">
								<span>{$blogValue.blog_created.date_added}</span>
							</div>
						</div>
						<div class="clsUserActivityWhtsgoing">
							<img src="{$CFG.site.url}blog/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-blog_created-add.gif" border="0" />{$blogValue.blog_created.lang}
							<a href="{$blogValue.blog_created.viewblog.url}">{$blogValue.blog_created.blog_name}</a>
						</div>
					</div>
				</div>
			</div>
    	{elseif $blogValue.action_key == 'blog_post_created'}
		<div class="clsWhatsGoingUserDetails">
			<div class="clsWhatsGoingBg clsOverflow">
				<div class="clsFloatLeft">
					<a href="{$blogValue.blog_post_created.viewpost.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						<img src="{$blogValue.blog_post_created.profileIcon.s_url}" border="0" title="{$blogValue.blog_post_created.user_name}"  {$myobj->DISP_IMAGE(45, 45, $blogValue.blog_post_created.profileIcon.s_width, $blogValue.blog_post_created.profileIcon.s_height)}/>
					</a>
				</div>
				<div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$blogValue.blog_post_created.uploaded_user.url}">{$blogValue.blog_post_created.user_name}</a>
						</div>
						<div class="clsFloatRight">
							<span>{$blogValue.blog_post_created.date_added}</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}blog/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-blog_post_comment.gif" border="0" />{$blogValue.blog_post_created.lang}
						<a href="{$blogValue.blog_post_created.viewpost.url}">{$blogValue.blog_post_created.blog_post_name}</a>
					</div>
				</div>
			</div>
		</div>
        {elseif $blogValue.action_key == 'blog_post_comment'}
		<div class="clsWhatsGoingUserDetails">
			<div class="clsWhatsGoingBg clsOverflow">
				<div class="clsFloatLeft">
					<a href="{$blogValue.blog_post_comment.viewpost.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						<img src="{$blogValue.blog_post_comment.profileIcon.s_url}" border="0" title="{$blogValue.blog_post_comment.user_name}"  {$myobj->DISP_IMAGE(45, 45, $blogValue.blog_post_comment.profileIcon.s_width, $blogValue.blog_post_comment.profileIcon.s_height)} />
					</a>
				</div>
				<div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$blogValue.blog_post_comment.comment_user.url}">{$blogValue.blog_post_comment.user_name}</a>
						</div>
						<div class="clsFloatRight">
							<span>{$blogValue.blog_post_comment.date_added}</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}blog/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-blog_post_comment.gif" border="0" />{$blogValue.blog_post_comment.lang}
						<a href="{$blogValue.blog_post_comment.viewpost.url}">{$blogValue.blog_post_comment.blog_post_name}</a>
					</div>
				</div>
			</div>
		</div>
		{elseif $blogValue.action_key == 'blog_post_rated'}
		<div class="clsWhatsGoingUserDetails">
			<div class="clsWhatsGoingBg clsOverflow">
				<div class="clsFloatLeft">
					<a href="{$blogValue.blog_post_rated.viewpost.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						<img src="{$blogValue.blog_post_rated.profileIcon.s_url}" border="0" title="{$blogValue.blog_post_rated.user_name}"  {$myobj->DISP_IMAGE(45, 45, $blogValue.blog_post_rated.profileIcon.s_width, $blogValue.blog_post_rated.profileIcon.s_height)} />
					</a>
				</div>
				<div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$blogValue.blog_post_rated.comment_user.url}">{$blogValue.blog_post_rated.user_name|ucwords}</a>
						</div>
						<div class="clsFloatRight">
							<span>{$blogValue.blog_post_rated.date_added}</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}blog/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-blog_post_share.gif" border="0" />{$blogValue.blog_post_rated.lang2}
						<a href="{$blogValue.blog_post_rated.viewpost.url}"> {$blogValue.blog_post_rated.blog_post_name}</a>
					</div>
				</div>
			</div>
		</div>
         {elseif $blogValue.action_key == 'blog_post_favorite'}
		 <div class="clsWhatsGoingUserDetails">
			<div class="clsWhatsGoingBg clsOverflow">
				<div class="clsFloatLeft">
					<a href="{$blogValue.blog_post_favorite.viewpost.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						<img src="{$blogValue.blog_post_favorite.profileIcon.s_url}" border="0" title="{$blogValue.blog_post_favorite.user_name}"  {$myobj->DISP_IMAGE(45, 45, $blogValue.blog_post_favorite.profileIcon.s_width, $blogValue.blog_post_favorite.profileIcon.s_height)} />
					</a>
				</div>
				<div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$blogValue.blog_post_favorite.comment_user.url}">{$blogValue.blog_post_favorite.user_name|ucwords}</a>
						</div>
						<div class="clsFloatRight">
							<span>{$blogValue.blog_post_favorite.date_added}</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}blog/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-blog_post_favorite.gif" border="0" />{$blogValue.blog_post_favorite.lang1}
						<a href="{$blogValue.blog_post_favorite.viewpost.url}">{$blogValue.blog_post_favorite.blog_post_name}</a>
					</div>
				</div>
			</div>
		</div>
         {elseif $blogValue.action_key == 'blog_post_featured'}
		 <div class="clsWhatsGoingUserDetails">
			<div class="clsWhatsGoingBg clsOverflow">
				<div class="clsFloatLeft">
					<a href="{$blogValue.blog_post_featured.viewpost.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						<img src="{$blogValue.blog_post_featured.profileIcon.s_url}" border="0" title="{$blogValue.blog_post_featured.user_name}"  {$myobj->DISP_IMAGE(45, 45, $blogValue.blog_post_featured.profileIcon.s_width, $blogValue.blog_post_featured.profileIcon.s_height)} />
					</a>
				</div>
				<div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$blogValue.blog_post_featured.comment_user.url}">{$blogValue.blog_post_featured.user_name|ucwords}</a>
						</div>
						<div class="clsFloatRight">
							<span>{$blogValue.blog_post_featured.date_added}</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}blog/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-blog_post_featured.gif" border="0" />{$blogValue.blog_post_featured.lang1}
						<a href="{$blogValue.blog_post_featured.viewpost.url}">{$blogValue.blog_post_featured.blog_post_name}</a>
					</div>
				</div>
			</div>
		</div>
         {elseif $blogValue.action_key == 'blog_post_share'}
		 <div class="clsWhatsGoingUserDetails">
			<div class="clsWhatsGoingBg clsOverflow">
				<div class="clsFloatLeft">
					<a href="{$blogValue.blog_post_share.viewpost.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						<img src="{$blogValue.blog_post_share.profileIcon.s_url}" border="0" title="{$blogValue.blog_post_share.user_name}" {$myobj->DISP_IMAGE(45, 45, $blogValue.blog_post_share.profileIcon.s_width, $blogValue.blog_post_share.profileIcon.s_height)} />
					</a>
				</div>
				<div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$blogValue.blog_post_share.sender.url}">{$blogValue.blog_post_share.sender_user_name}</a>
						</div>
						<div class="clsFloatRight">
							<span>{$blogValue.blog_post_share.date_added}</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}blog/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-blog_post_share.gif" border="0" />{$blogValue.blog_post_share.lang1}
						<a href="{$blogValue.blog_post_share.viewpost.url}">{$blogValue.blog_post_share.blog_post_name}</a>
					</div>
				</div>
			</div>
		</div>
        {/if}
 	{/if}
{/foreach}