{foreach item=musicValue from=$musicActivity_arr}
{if $key == $musicValue.parent_id}
 	
	{$myobj->chkTemplateImagePathForModuleAndSwitch('music', $CFG.html.template.default, $CFG.html.stylesheet.screen.default)}		
	
    {if $musicValue.action_key == 'music_uploaded'}      
		<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="{$musicValue.music_uploaded.uploaded_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						<img src="{$musicValue.music_uploaded.profileIcon.s_url}" border="0" title="{$musicValue.music_uploaded.user_name}" alt="{$musicValue.music_uploaded.user_name}" {$myobj->DISP_IMAGE(#music_index_activity_thumb_width#, #music_index_activity_thumb_height#, $musicValue.music_uploaded.profileIcon.s_width, $musicValue.music_uploaded.profileIcon.s_height)}/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$musicValue.music_uploaded.uploaded_user.url}">{$musicValue.music_uploaded.user_name|ucwords}</a>
						</div>	
						<div class="clsFloatRight">
							<span>{$musicValue.music_uploaded.date_added}</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/music_upload.gif" alt="" border="0" />
                        {$musicValue.music_uploaded.lang}
						<a href="{$musicValue.music_uploaded.viewmusic.url}">{$musicValue.music_uploaded.music_title}</a>
					</div>	
				</div>	
			</div>	
		</div>
	{elseif $musicValue.action_key == 'music_comment'}    
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="{$musicValue.music_comment.comment_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="{$musicValue.music_comment.profileIcon.s_url}" border="0" title="{$musicValue.music_comment.user_name}"  alt="{$musicValue.music_comment.user_name}" {$myobj->DISP_IMAGE(#music_index_activity_thumb_width#, #music_index_activity_thumb_height#, $musicValue.music_comment.profileIcon.s_width, $musicValue.music_comment.profileIcon.s_height)}/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$musicValue.music_comment.comment_user.url}">{$musicValue.music_comment.user_name|ucwords}</a>
						</div>	
						<div class="clsFloatRight">
							<span>{$musicValue.music_comment.date_added}</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/music_comment.gif" alt="" border="0" />
                        {$musicValue.music_comment.lang}
                        <a href="{$musicValue.music_comment.viewmusic.url}">{$musicValue.music_comment.music_title}</a>
					</div>	
				</div>	
			</div>	
		</div>
	{elseif $musicValue.action_key == 'music_rated'}
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="{$musicValue.music_rated.comment_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="{$musicValue.music_rated.profileIcon.s_url}" border="0" title="{$musicValue.music_rated.user_name}"  alt="{$musicValue.music_rated.user_name}" {$myobj->DISP_IMAGE(#music_index_activity_thumb_width#, #music_index_activity_thumb_height#, $musicValue.music_rated.profileIcon.s_width, $musicValue.music_rated.profileIcon.s_height)}/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$musicValue.music_rated.comment_user.url}">{$musicValue.music_rated.user_name|ucwords}</a>
						</div>	
						<div class="clsFloatRight">
							<span>{$musicValue.music_rated.date_added}</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/music_rated.gif" alt="" border="0" />
                        {$musicValue.music_rated.lang}
						<a href="{$musicValue.music_rated.viewmusic.url}">{$musicValue.music_rated.music_title}</a>
					</div>	
				</div>	
			</div>	
		</div>
	{elseif $musicValue.action_key == 'music_favorite'}
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="{$musicValue.music_favorite.comment_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="{$musicValue.music_favorite.profileIcon.s_url}" border="0" title="{$musicValue.music_favorite.user_name}"  alt="{$musicValue.music_favorite.user_name}" {$myobj->DISP_IMAGE(#music_index_activity_thumb_width#, #music_index_activity_thumb_height#, $musicValue.music_favorite.profileIcon.s_width, $musicValue.music_favorite.profileIcon.s_height)}/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$musicValue.music_favorite.comment_user.url}">{$musicValue.music_favorite.user_name|ucwords}</a>
						</div>	
						<div class="clsFloatRight">
							<span>{$musicValue.music_favorite.date_added}</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/music_favorite.gif" alt="" border="0" />
                        {$musicValue.music_favorite.lang}
						<a href="{$musicValue.music_favorite.viewmusic.url}">{$musicValue.music_favorite.music_title}</a>
					</div>	
				</div>	
			</div>	
		</div>
	{elseif $musicValue.action_key == 'music_featured'}
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="{$musicValue.music_featured.comment_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="{$musicValue.music_featured.profileIcon.s_url}" border="0" title="{$musicValue.music_featured.user_name}"  alt="{$musicValue.music_featured.user_name}" {$myobj->DISP_IMAGE(#music_index_activity_thumb_width#, #music_index_activity_thumb_height#, $musicValue.music_featured.profileIcon.s_width, $musicValue.music_featured.profileIcon.s_height)}/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$musicValue.music_featured.comment_user.url}">{$musicValue.music_featured.user_name|ucwords}</a>
						</div>	
						<div class="clsFloatRight">
							<span>{$musicValue.music_featured.date_added}</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/music_featured.gif" alt="" border="0" />
                        {$musicValue.music_featured.lang}
						<a href="{$musicValue.music_featured.viewmusic.url}">{$musicValue.music_featured.music_title}</a>
					</div>	
				</div>	
			</div>	
		</div>
	{elseif $musicValue.action_key == 'music_responded'}
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="{$musicValue.music_responded.responses_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="{$musicValue.music_responded.profileIcon.s_url}" border="0" title="{$musicValue.music_responded.user_name}"  alt="{$musicValue.music_responded.user_name}" {$myobj->DISP_IMAGE(#music_index_activity_thumb_width#, #music_index_activity_thumb_height#, $musicValue.music_responded.profileIcon.s_width, $musicValue.music_responded.profileIcon.s_height)}/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$musicValue.music_responded.responses_user.url}">{$musicValue.music_responded.responses_user_name|ucwords}</a>
						</div>	
						<div class="clsFloatRight">
							<span>{$musicValue.music_responded.date_added}</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/music_responded.gif" alt="" border="0" />
                        {$musicValue.music_responded.lang}
						<a href="{$musicValue.music_responded.old_viewmusic.url}">{$musicValue.music_responded.old_music_title}</a>
					</div>	
				</div>	
			</div>	
		</div>
	{elseif $musicValue.action_key == 'music_share'}
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="{$musicValue.music_share.sender.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="{$musicValue.music_share.profileIcon.s_url}" border="0" title="{$musicValue.music_share.user_name}"  alt="{$musicValue.music_share.user_name}" {$myobj->DISP_IMAGE(#music_index_activity_thumb_width#, #music_index_activity_thumb_height#, $musicValue.music_share.profileIcon.s_width, $musicValue.music_share.profileIcon.s_height)}/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$musicValue.music_share.sender.url}">{$musicValue.music_share.sender_user_name|ucwords}</a>
						</div>	
						<div class="clsFloatRight">
							<span>{$musicValue.music_share.date_added}</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/music_share.gif" alt="" border="0" />
                        {$musicValue.music_share.lang1}
                        {$musicValue.music_share.lang2}
                        {foreach item=firendList from=$musicValue.music_share.firend_list}
                        <a href="{$firendList.url}">{$firendList.firend_name}</a>
                        {/foreach}
					</div>	
				</div>	
			</div>	
		</div>
	{elseif $musicValue.action_key == 'playlist_comment'}
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="{$musicValue.playlist_comment.comment_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="{$musicValue.playlist_comment.profileIcon.s_url}" border="0" title="{$musicValue.playlist_comment.user_name}"  alt="{$musicValue.playlist_comment.user_name}" {$myobj->DISP_IMAGE(#music_index_activity_thumb_width#, #music_index_activity_thumb_height#, $musicValue.playlist_comment.profileIcon.s_width, $musicValue.playlist_comment.profileIcon.s_height)}/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$musicValue.playlist_comment.comment_user.url}">{$musicValue.playlist_comment.user_name|ucwords}</a>
						</div>	
						<div class="clsFloatRight">
							<span>{$musicValue.playlist_comment.date_added}</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/music_comment.gif" alt="" border="0" />
                        {$musicValue.playlist_comment.lang}
                        <a href="{$musicValue.playlist_comment.viewmusic.url}">{$musicValue.playlist_comment.playlist_name}</a>
					</div>	
				</div>	
			</div>	
		</div>
	{elseif $musicValue.action_key == 'playlist_rated'}
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">{* $musicValue.playlist_rated.comment_user.url *}
					<a href="{$musicValue.playlist_rated.rate_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="{$musicValue.playlist_rated.profileIcon.s_url}" border="0" title="{$musicValue.playlist_rated.user_name}" alt="{$musicValue.playlist_rated.user_name}" {$myobj->DISP_IMAGE(#music_index_activity_thumb_width#, #music_index_activity_thumb_height#, $musicValue.playlist_rated.profileIcon.s_width, $musicValue.playlist_rated.profileIcon.s_height)}/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$musicValue.playlist_rated.rate_user.url}">{$musicValue.playlist_rated.user_name|ucwords}</a>
						</div>	
						<div class="clsFloatRight">
							<span>{$musicValue.playlist_rated.date_added}</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/music_rated.gif" alt="" border="0" />
                        {$musicValue.playlist_rated.lang}
						<a href="{$musicValue.playlist_rated.viewmusic.url}">{$musicValue.playlist_rated.playlist_name}</a>
					</div>	
				</div>	
			</div>	
		</div>
	{elseif $musicValue.action_key == 'playlist_featured'}
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="{$musicValue.playlist_featured.comment_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="{$musicValue.playlist_featured.profileIcon.s_url}" border="0" title="{$musicValue.playlist_featured.user_name}" o alt="{$musicValue.playlist_featured.user_name}" {$myobj->DISP_IMAGE(#music_index_activity_thumb_width#, #music_index_activity_thumb_height#, $musicValue.playlist_featured.profileIcon.s_width, $musicValue.playlist_featured.profileIcon.s_height)}/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$musicValue.playlist_featured.comment_user.url}">{$musicValue.playlist_featured.user_name|ucwords}</a>
						</div>	
						<div class="clsFloatRight">
							<span>{$musicValue.playlist_featured.date_added}</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/music_featured.gif" alt="" border="0" />
                        {$musicValue.playlist_featured.lang}
						<a href="{$musicValue.playlist_featured.viewmusic.url}">{$musicValue.playlist_featured.playlist_name}</a>
					</div>	
				</div>	
			</div>	
		</div>
    {elseif $musicValue.action_key == 'playlist_favorite'}
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="{$musicValue.playlist_favorite.comment_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="{$musicValue.playlist_favorite.profileIcon.s_url}" border="0" title="{$musicValue.playlist_favorite.user_name}"  alt="{$musicValue.playlist_favorite.user_name}" {$myobj->DISP_IMAGE(#music_index_activity_thumb_width#, #music_index_activity_thumb_height#, $musicValue.playlist_favorite.profileIcon.s_width, $musicValue.playlist_favorite.profileIcon.s_height)}/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$musicValue.playlist_favorite.comment_user.url}">{$musicValue.playlist_favorite.user_name|ucwords}</a>
						</div>	
						<div class="clsFloatRight">
							<span>{$musicValue.playlist_favorite.date_added}</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/music_favorite.gif" alt="" border="0" />
                        {$musicValue.playlist_favorite.lang}
						<a href="{$musicValue.playlist_favorite.viewmusic.url}">{$musicValue.playlist_favorite.playlist_name}</a>
					</div>	
				</div>	
			</div>	
		</div>
    {elseif $musicValue.action_key == 'playlist_share'}
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="{$musicValue.playlist_share.sender.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="{$musicValue.playlist_share.profileIcon.s_url}" border="0" title="{$musicValue.playlist_share.user_name}"  alt="{$musicValue.playlist_share.user_name}" {$myobj->DISP_IMAGE(#music_index_activity_thumb_width#, #music_index_activity_thumb_height#, $musicValue.playlist_share.profileIcon.s_width, $musicValue.playlist_share.profileIcon.s_height)}/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$musicValue.playlist_share.sender.url}">{$musicValue.playlist_share.sender_user_name|ucwords}</a>
						</div>	
						<div class="clsFloatRight">
							<span>{$musicValue.playlist_share.date_added}</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/music_share.gif" alt="" border="0" />
                        {$musicValue.playlist_share.lang1}
                        {$musicValue.playlist_share.lang2}
                        {foreach item=firendList from=$musicValue.playlist_share.firend_list}
                        <a href="{$firendList.url}">{$firendList.firend_name}</a>
                        {/foreach}
                        <a href="{$musicValue.playlist_share.viewmusic.url}">{$musicValue.playlist_share.playlist_name}</a>
					</div>	
				</div>	
			</div>	
		</div>
    {elseif $musicValue.action_key == 'playlist_create'}
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="{$musicValue.playlist_create.uploaded_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="{$musicValue.playlist_create.profileIcon.s_url}" border="0" title="{$musicValue.playlist_create.user_name}"  alt="{$musicValue.playlist_create.user_name}" {$myobj->DISP_IMAGE(#music_index_activity_thumb_width#, #music_index_activity_thumb_height#, $musicValue.playlist_create.profileIcon.s_width, $musicValue.playlist_create.profileIcon.s_height)}/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="{$musicValue.playlist_create.uploaded_user.url}">{$musicValue.playlist_create.user_name|ucwords}</a>
						</div>	
						<div class="clsFloatRight">
							<span>{$musicValue.playlist_create.date_added}</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/music_upload.gif" alt="" border="0" />
                        {$musicValue.playlist_create.lang}
						<a href="{$musicValue.playlist_create.viewmusic.url}">{$musicValue.playlist_create.playlist_name}</a>
					</div>	
				</div>	
			</div>	
		</div>              
    {/if}
            
{/if}
{/foreach}