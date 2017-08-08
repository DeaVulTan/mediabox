{php}if(isset($this->bodyBackgroundImage) && $this->bodyBackgroundImage){{/php}
<div id="selViewVideo" style="margin-top:{$myobj->background_offset}px">
{php}}
else{{/php}
<div id="selViewVideo">
{php}}
{/php}
{if $myobj->isTrimmedVideo()}
<div class="clsTrimmedVideo">
	<h4 class="clsAlert">{$myobj->trimmendMessage}</h4>
</div>
{/if}

{* VIDEO CONTENT STARTS *}
	<div class="clsViewVideoContent">
	{if $myobj->isShowPageBlock('msg_form_error')}
            <div id="selMsgError">
                <p>{$myobj->getCommonErrorMsg()}</p>
            </div>
        {/if}
    {if $myobj->isShowPageBlock('videoMainBlock')}

		<div id="selMsgConfirmWindow" class="clsMsgConfirmWindow" style="display:none;">
			<h3 id="confirmationMsg"></h3>
			<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
		      	<input type="button" class="clsSubmitButton" name="confirm_action" id="confirm_action" onclick="deleteCommandOrReply();" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
		      	&nbsp;
		      	<input type="button" class="clsCancelButton" name="cancel" id="cancel" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks();" />
		      	<input type="hidden" name="comment_id" id="comment_id" />
		      	<input type="hidden" name="maincomment_id" id="maincomment_id" />
		      	<input type="hidden" name="commentorreply" id="commentorreply" />
			</form>
		</div>

        {if $myobj->isShowPageBlock('msg_form_success') OR $myobj->video_response_added}
            <div id="selMsgSuccess">
                <p>{$myobj->video_response_successfully_added}</p>
            </div>
        {/if}

        <!-- flagged video confirmation form -->
        {if $myobj->isShowPageBlock('confirmation_flagged_form')}
            <div id="flaggedForm">
                <p>{$LANG.viewvideo_flagged_msg}</p>
                <p><a href="{$myobj->flaggedVideoUrl}" title="{$LANG.viewvideo_flagged}">{$LANG.viewvideo_flagged}</a></p>
            </div>
        {/if}
        <!-- flagged video confirmation form ends-->

        <!-- Adult video confirmation form -->
        {if $myobj->isShowPageBlock('confirmation_adult_form')}
            <div id="selAdultUserForm">
                <p>{$myobj->replaceAdultText($LANG.confirmation_alert_text)}</p>
                <p><a href="{$myobj->acceptAdultVideoUrl}" title="{$LANG.viewvideo_accept}">{$LANG.viewvideo_accept}</a>&nbsp;&nbsp;
                <a href="{$myobj->acceptThisAdultVideoUrl}" title="{$LANG.viewvideo_accept_this_page_only}">{$LANG.viewvideo_accept_this_page_only}</a>&nbsp;&nbsp;
                <a href="{$myobj->rejectAdultVideoUrl}" title="{$LANG.viewvideo_reject}">{$LANG.viewvideo_reject}</a>&nbsp;&nbsp;
                <a href="{$myobj->rejectThisAdultVideoUrl}" title="{$LANG.viewvideo_reject_this_page_only}">{$LANG.viewvideo_reject_this_page_only}</a> </p>
            </div>
        {/if}
        <!-- Adult video confirmation form ends-->
        <!-- displaying Video -->
        {if $myobj->isShowPageBlock('videos_form') and $myobj->validate}

       
	   	<div class="clsViewVideoHeadingLeft">
			<div class="clsViewVideoHeadingMiddle">
				<div class="clsViewVideoHeadingRight">
	        		<div class="clsOverflow clsVideoPlayerDetails">
						 <div class="clsVideoPlayerHeadingContainer clsFloatLeft">
									<h2 class="clsVideoPlayerHeading">{$myobj->videoTitle}</h2>

								 </div>
						 <div class="clsCaptionMinHeight">
										{* video statistics  begins *}
										<div class="clsOverflow">
											<div class="clsVideoRatingRight">
											{* DISPLAYING RATING FORM BEGINS*}
											{if $myobj->chkAllowRating()}
											<div id="ratingForm">
											 {assign var=tooltip value=""}
											{if !isLoggedIn()}
													{$myobj->populateRatingImages($myobj->total_video_rating, 'viewvideo',$LANG.view_video_login_message,$myobj->notLoginVideoUrl)}
													{assign var=tooltip value=$LANG.view_video_login_message}
													<span> ({$myobj->getFormField('rating_count')})</span>
											{else}
												<div id="selRatingVideo">
														{if $myobj->isMember and $myobj->rankUsersRayzz}
															{$myobj->populateRatingImagesForAjax($myobj->total_video_rating,'viewviewo')}
														{else}
															{$myobj->populateRatingImages($myobj->total_video_rating,'viewvideo',$LANG.viewvideo_rate_yourself,'javascript:void(0);')}
															{assign var=tooltip value=$LANG.viewvideo_rate_yourself}
														{/if}
														   (<span>{$myobj->getFormField('rating_count')}</span>)
												</div>
											{/if}

									<script type="text/javascript">
									  {literal}
									  $Jq(document).ready(function(){
										$Jq('#ratingLink').attr('title','{/literal}{$tooltip}{literal}');
										$Jq('#ratingLink').tooltip({
																track: true,
																delay: 0,
																showURL: false,
																showBody: " - ",
																extraClass: "clsToolTip",
																top: -10
															});
											});
										{/literal}
									  </script>

											{* DISPLAYING RATING FORM ENDS*}
											</div>
											{/if}
											</div>
											<div class="clsVideoPlayerViews">
												<ul>
													<li>
														<span>{$LANG.common_views}:</span>
														<span class="clsVideoViewsRight"><span class="clsVideoViewsLeft">{$myobj->getFormField('total_views')}</span></span>
													</li>
													<li>
														<span>{$LANG.short_favorite}:</span>
														<span class="clsVideoViewsRight"><span class="clsVideoViewsLeft">{$myobj->getFormField('favorited')}</span></span>
													</li>
													<li>
														<span>{$LANG.short_comments}:</span>
														<span class="clsVideoViewsRight"><span class="clsVideoViewsLeft">{$myobj->getFormField('comments')}</span></span>
													</li>
												</ul>
											</div>
										</div>
										{* video statistics  begins ends *}

									 </div>
					 </div>
				</div>
			</div>
		</div>
        {* VIDEO BOTTOM CONTENT STARTS *}
            <div class="clsVideoBottom clsOverflow">
		      <div class="clsViewVideoLeft">
                    {* VIDEO PLAYER ROUNDED CORNERS STARTS *}
                    <div id="playerSection">
			        {* {include file='box.tpl' opt='videoplayer_top'} *}

                        {* Video Player Begins *}
                        <div id="flashcontent2" class="clsVideoPlayerBorder clsViewVideoPlayer">
                           <table>
                           		<tr>
                                	<td>
                                         {if $myobj->checkIsExternalEmebedCode()}
                                         {$myobj->displayEmbededVideo()}
                                         {/if}
                             		</td>
	                             </tr>
                            </table>
                        </div>
                       {if !$myobj->checkIsExternalEmebedCode()}
                        <script type="text/javascript">
                            var so1 = new SWFObject("{$myobj->flv_player_url}", "flvplayer", "{$CFG.admin.videos.minimum_player_width}", "{$CFG.admin.videos.minimum_player_height}", "7",  null, true);
                            so1.addParam("allowFullScreen", "true");
                            so1.addParam("wmode", "transparent");
                            {if $myobj->play_list_next_url}
                            so1.addParam("autoplay", "true");
                            {/if}
                            so1.addParam("allowSciptAccess", "always");
                            so1.addVariable("config", "{$myobj->configXmlcode_url}{$myobj->arguments_play}");
                            so1.write("flashcontent2");
                        </script>
                        {else}
                        	{literal}
                        	<script type="text/javascript">
							var user_agent = navigator.userAgent.toLowerCase();
							if(user_agent.indexOf("msie") != -1)
								{
									// FIX for IE 6 since sometimes dom:loaded not working
									$Jq(document).ready( function(){
										chkExtenalEmbededHeightAndWidth();
									});
								}
							else
								{
									$Jq(document).ready( function(){
										chkExtenalEmbededHeightAndWidth();
									});
								}
							</script>
                            {/literal}
                        {/if}
                        {* Video Player ends *}
                    </div>
                    {* VIDEO PLAYER ROUNDED CORNERS ENDS *}

                        {if $myobj->video_response_links}
                        <div class="clsRespondedVideo">
                           <div class="clsNoVideo"> <p>{$LANG.this_video_response_for_video}
                                {$myobj->video_response_links}
                            </p></div>
                        </div>
                        {/if}

                </div>
              <div class="clsViewVideoRight">
                    {* Displaying Video details begins*}
					                    {$myobj->setTemplateFolder('general',video)}
                    {include file='box.tpl' opt='videoinfo_top'}
					            {* displaying Video Description begin*}
						 {if $CFG.admin.media_description_display}
                                    {if $myobj->getFormField('video_caption')}
									<div id="videoCaption" class="clsVideoSummary">
                                        <p><span>{$LANG.viewvideo_summary}:</span></p>
                                    <div class="clsVideoCaptionHeight" id="videoCaptionSummary">
											<p class="clsVideoDes">{$myobj->videoCaption}</p>
									</div>
                                    {else}
                                    <div id="videoCaption" class="clsVideoSummary">
                                        <p><span>{$LANG.viewvideo_summary_not_available}</span></p>
                                    {/if}

                                    </div>
                                {/if}
                                {* displaying Video Description ends*}
                        <div class="clsOverflow clsVideoUserDetailsTop">
                        	<div class="clsVideoDetailsLeft">
                                <span class="clsMembersImage">
									<a href="{$myobj->memberProfileUrl}" class="ClsImageContainer ClsImageBorder2 Cls47x47"><img src="{$myobj->memberProfileImgSrc.icon.m_url}" alt="{$myobj->getFormField('user_name')}" {$myobj->DISP_IMAGE(45,45, $myobj->memberProfileImgSrc.icon.s_width, $myobj->memberProfileImgSrc.icon.s_height)}/></a></span>
                            </div>
                            <div class="clsVideoDetailsRight">
                                <p class="clsVideoDetailsUserName">
                                    <span class="clsVideoContentTitle">{$LANG.viewvideo_added_by}</span><a href="{$myobj->memberProfileUrl}">{$myobj->addedUserName}</a>
                                </p>
								 <p>
                                      <span class="clsVideoContentTitle">{$LANG.viewvideo_added_date}</span>
                                      <span class="clsFontWhite">{$myobj->getFormField('date_added')}</span>
                                  </p>
						 {*SUBSCRIPTION LINK FOR USER STARTS HERE*}

                           {if chkIsSubscriptionEnabled() and chkIsSubscriptionEnabledForModule()}
					{if isMember()}
                              	{if $myobj->getFormField('user_id') != $CFG.user.user_id}
                                     <p class="clsSubscriptionBtn">
                                          <a href="javascript:void(0);" id="anchor_subscribe" onclick="get_subscription_options({$myobj->getFormField('user_id')}, 50, -300, 'anchor_subscribe');" title="{$LANG.common_subscriptions}">{$LANG.common_subscriptions}</a>
                                     </p>
                                    {/if}
                              {else}
                                     <p class="clsSubscriptionBtn">
                                 		   <a href="javascript:void(0)" onclick="memberBlockLoginConfirmation('{$LANG.common_video_subscribe_subscribe_msg}', '{$myobj->notLoginVideoUrl}')" title="{$LANG.common_subscriptions}">{$LANG.common_subscriptions}</a>
 	                                </p>
                              {/if}
                           {/if}
				   {*SUBSCRIPTION LINK FOR USER ENDS HERE*}
                            </div>
                          </div>
                    {include file='box.tpl' opt='videoinfo_bottom'}
                    {$myobj->setTemplateFolder('general/','video')}
         			{include file='box.tpl' opt='videocontent_top'}
                    <div id="videoDetails">
						<div class="clsOverflow">
                    	<h3 class="clsFloatLeft">{$LANG.viewvideo_details}</h3>
						{if isMember() and $myobj->getFormField('user_id') == $CFG.user.user_id}
                            <div class="clsOverflow clsVideoRatingContainer clsMarginBottom5">

                             	<div class="clsEditVideoLink">
                                	<span><a href="{$myobj->editVideoUrl}" title="{$LANG.viewvideo_edit_video}">{$LANG.viewvideo_edit_video}</a></span>
                                </div>

                            </div>
                            {/if}
							</div>
                        <div class="clsViewVideoDetailsContent">
					<div>
								<div class="clsOverflow">
                             	   <div class="clsVideoInformation">
									<div class="clsLabel">{$LANG.viewvideo_playing_time}</div>
                                    <div class="clsSeparator">:</div>
                                    <div class="clsDetails">{$myobj->getFormField('cur_vid_play_time')}</div>
                                </div>
                                </div>
								<div class="clsOverflow">
                                <div class="clsVideoInformation">
                                    <div class="clsLabel">{$LANG.totalvideos_thisuser}</div>
                                    <div class="clsSeparator">:</div>
                                    <div class="clsDetails">{$myobj->getTotalVideosOfThisUser(1)}</div>
                                </div>
                                </div>
								<div class="clsOverflow">
                                <div class="clsVideoInformation" id="category_container_{$myobj->getFormField('video_category_id')}">
                                    <div class="clsLabel">{$LANG.viewvideo_channel}</div>
                                    <div class="clsSeparator">:</div>
                                    <div class="clsDetails">{$myobj->getChannelOfThisVideo()}</div>
                                </div>
                                </div>
		                    	{* video tags begin*}
								<div class="clsOverflow">
		                        <div class="clsVideoInformation">
									<div class="clsLabel">{$LANG.viewvideo_tags}&nbsp;</div>
                                    <div class="clsSeparator">:</div>
									<div class="clsDetails">{$myobj->getTagsOfThisVideo()}</div>
		                        </div>
                                </div>
		                        {* video tags ends*}

						{* DISPLAY SUB CATEGORY IF FEATURE TURNED ON AND AVAILABLE *}
                            {if $CFG.admin.videos.sub_category and $myobj->getFormField('video_sub_category_id') != 0}
								<div class="clsOverflow">
                                  <div class="clsVideoInformation" id="sub_category_container_{$myobj->getFormField('video_sub_category_id')}">
                                      <div class="clsLabel">{$LANG.viewvideo_sub_channel}</div>
                                      <div class="clsSeparator">:</div>
                                      <div class="clsDetails">{$myobj->getChannelOfThisVideo(true)}</div>
                                  </div>
                                </div>
                            {/if}
                        {*SUB CATEGORY AREA ENDS*}
                                  {if !$myobj->checkIsExternalEmebedCode() and $myobj->chkLinksDisplayAllowedTo()}
                                  {* DISPLAYING LINK BEGIN*}
                                      <a id="anchor_video_block"></a>
                                      <div class="clsVideoInformation">
                                          <div class="clsLabel">{$LANG.viewvideo_links}</div>
                                          <div class="clsSeparator">:</div>
                                          <div class="clsDetails"><a onclick="Confirmation('clsVideoRenders','msgHistoryLink','','');">{$myobj->getTotalRenderList()}</a></div>
                                      </div>
                                  {* DISPLAYING LINK ENDS*}
                                   {/if}
                                </div>

                           <!-- {if isMember() and $myobj->getFormField('user_id') == $CFG.user.user_id}
                            <div class="clsOverflow clsVideoRatingContainer clsMarginBottom5">

                             	<div class="clsEditVideoLink">
                                	<span><a href="{$myobj->editVideoUrl}">{$LANG.viewvideo_edit_video}</a></span>
                                </div>

                            </div>
                            {/if}-->
						<div>
                                          {* video url begin *}
                                         <!-- <p class="clsVideoContentTitle">
                                          <label>{$LANG.viewvideo_video_url}</label></p>-->
                                          <p class="clsUrlBg"> <input type="text" class="clsVideoUrlTextBox" name="video_url" id="video_url" value="{$myobj->viewVideoEmbedUrl}" size="52" tabindex="{smartyTabIndex}" onfocus="this.select()" onclick="this.select()" readonly="readonly" />
                                           </p>
                                          {* video url ends *}

                                          {* VIDEO EMBEDED BEGINS *}
                                          {if $myobj->getFormField('allow_embed')=='Yes' and $CFG.admin.videos.embedable}
<!--                                          <p class="clsVideoContentTitle">
                                          <label>{$LANG.viewvideo_embeddable_player}</label></p>-->
                                          <form name="formGetCode" id="formGetCode" method="post" action="{$myobj->getCurrentUrl()}">
                                          {if $myobj->checkIsExternalEmebedCode()}
                                                 <p class="clsEmdedUrlBg"><input type="text" class="clsVideoUrlTextBox" name="image_code" id="image_code" readonly="readonly" tabindex="{smartyTabIndex}" onfocus="this.select()" onclick="this.select()" value="{$myobj->getFormField('video_external_embed_code')}" /></p>
                                          {else}
                                                {*<p><input type=text" class="clsVideoUrlTextBox" name="image_code" id="image_code" READONLY onFocus="this.select()" onClick="this.select()" value="&lt;embed src=&quot;{$myobj->flv_player_url_embed}&quot; FlashVars=&quot;       config={$myobj->configXmlcode_url}{$myobj->arguments_embed}&quot; quality=&quot;high&quot; bgcolor=&quot;#000000&quot;width=&quot;450&quot; height=&quot;370&quot; name=&quot;flvplayer&quot; align=&quot;middle&quot; allowScriptAccess=&quot;always&quot; type=&quot;application/x-shockwave-flash&quot; pluginspage=&quot;http://www.macromedia.com/go/getflashplayer&quot; {php}global $CFG;htmlentities($CFG['admin']['embed_code']['additional_fields']){/php} /&gt;" /></p>*}
                                               <div class="clsOverflow">
											    <p class="clsEmdedUrlBg"><input type="text" class="clsVideoUrlTextBox" name="image_code" id="image_code" readonly="readonly" onfocus="this.select()" onClick="this.select()" value="{$myobj->embeded_code}" />&nbsp;</p><p class="clsEmbededDropContainer"><a class="clsEmbededDrop" href="javascript:void(0)" id="embed_options_key" title="{$LANG.viewvideo_customize_tooltip}"></a></p>
												</div>
                                           {/if}
                                          </form>
                                          {/if}
                                          <div id="customize_embed_size" style="display:none">
										  <div class="clsEmbededDropDown">
										  	<div  class="clsEmbededDropDownArrow">
                                                <p><span>{$LANG.viewvideo_note}:</span>&nbsp;&nbsp;{$LANG.viewvideo_customize_embed}</p>
											</div>
                                            	<div>
                                                	<div id="embed_error_msg" class="clsEmbededError" style="display:none"></div>
                                                	<form name="form_customize_embed" id="form_customize_embed" autocomplete="off">
										<div class="clsOverflow">
											<div class="clsEmedWidthLeft"><span><label for="embed_width">{$LANG.viewvideo_customize_width}</label>:</span>&nbsp;
												<input type="text" name="embed_width" id="embed_width" class="validate-embed validate-embed-num" tabindex="{smartyTabIndex}" maxlength="4" />
											</div>
											<div class="clsEmedHeightRight"><span><label for="embed_height">{$LANG.viewvideo_customize_height}</label>:</span>&nbsp;
												<input type="text" name="embed_height" id="embed_height" class="validate-embed validate-embed-num" tabindex="{smartyTabIndex}" maxlength="4" />
											</div>
										</div>

									  <div class="clsOverflow clsEmbedBtns">
										<div class="clsEmbdButtonLeft"><div class="clsEmbdButtonRight">
											<input type="button" name="change_embed_code" id="change_embed_code" value="{$LANG.viewvideo_customize_apply}" onclick="customizeEmbedOptions();" />
										</div></div>
										<div class="clsEmbdButtonLeftdefault"><div class="clsEmbdButtonRightdefault">
											<a href="javascript:void(0)" onclick="customizeEmbedOptions('default')" title="{$LANG.viewvideo_customize_default_size}">{$LANG.viewvideo_customize_default_size}</a>
										</div></div>
										<a class="clsEmbdClose" href="javascript:void(0)" id="close_embed_options" title="{$LANG.viewvideo_customize_close}">{$LANG.viewvideo_customize_close}</a>
									</div>
									</form>
                                                </div>
                                          </div>
                                           </div>
                                          {* VIDEO EMBEDED ENDS *}
                                   </div>
                        </div>
                    </div>
                    {$myobj->setTemplateFolder('general/','video')}
         			{include file='box.tpl' opt='videocontent_bottom'}
                    {* Displaying Video details ends*}

					    {* DISPLAYING PLAYLIST, FAVORITE , FEATURED , FLAG CONTENT , SHARE VIDEO BEGIN*}
					{$myobj->setTemplateFolder('general/','video')}
                    {include file='box.tpl' opt='viewvideoplay_top'}
					<div class="clsCommonTabPopup">
				   	<div id="tabs" class="clsVideoFeaturesList">
						<ul class="clsOverflow">
                        	{if $CFG.admin.videos.allow_play_list}
							<li id="videoPlaylistLi" {if $CFG.admin.videos.allow_play_list==false} style="display:none" {/if}>
								<span><a class="clsVideoPlaylist" href="#option-tab-1" title="{$LANG.playlist|capitalize:true}">{$LANG.playlist|capitalize:true}</a></span>
							</li>
							{/if}
                        	<li id="videoFlagLi">
								<span><a class="clsVideoflag" href="#option-tab-2" title="{$LANG.viewvideo_flag_content|capitalize:true}">{$LANG.viewvideo_flag_content|capitalize:true}</a></span>
							</li>
							<li id="selAddBlogLink">
                            	<span><a class="" href="#option-tab-3" title="{$LANG.viewvideo_add_to_blog}">{$LANG.viewvideo_add_to_blog}</a></span>
                        	</li>
                        </ul>
					 <div>
                    	{if $CFG.admin.videos.allow_play_list}
	                    {$myobj->populatePlaylist()}
                        {/if}
                        {$myobj->populateFlagContent()}
                        {$myobj->populateVideoBlog()}
                    </div>
				</div>
				 <script type="text/javascript">
                        	var subMenuClassName1='clsActiveVideoLink';
                        	var hoverElement1  = '.clsVideoFeaturesList';
							loadChangeClass(hoverElement1, 'li', subMenuClassName1);
                        </script>
					 </div>
					   {$myobj->setTemplateFolder('general/','video')}
					{include file='box.tpl' opt='viewvideoplay_bottom'}
					<div class="clsOverflow">
						<ul class="clsShareVideoTab">
                         {if $myobj->isMember}
                           <li id="slideVideoLi">
						   		<a class="clsVideoShare" onclick="showShareDiv('{$myobj->shareUrl}')" title="{$LANG.viewvideo_share_video|capitalize:true}">
									<span>{$LANG.viewvideo_share_video|capitalize:true}</span>
								</a>
							</li>
                            <li id='unfeatured' {if !$myobj->featured.added} style="display:none"{/if}>
                                <a class="clsVideofeatured" title="{$LANG.featured|capitalize:true}" onclick="getViewVideoMoreContent('Featured');"><span>{$LANG.featured|capitalize:true}</span></a>
                            </li>
                            <li id="featured" {if $myobj->featured.added} style="display:none"{/if}>
                                <a class="clsVideofeature" title="{$LANG.feature|capitalize:true}" onclick="getViewVideoMoreContent('Featured', 'remove');" ><span>{$LANG.feature|capitalize:true}</span></a>
                            </li>
							<li id='unfavorite' {if !$myobj->favorite.added} style="display:none"{/if}>
                               <a class="clsVideofavourite" title="{$LANG.favorited|capitalize:true}" onclick="getViewVideoMoreContent('Favorites');" > <span>{$LANG.favorited|capitalize:true}</span></a>
                            </li>
                            <li id="favorite" {if $myobj->favorite.added} style="display:none"{/if}>
                               <a class="clsVideofavourited" title="{$LANG.favorites|capitalize:true}" onclick="getViewVideoMoreContent('Favorites','remove');" ><span>{$LANG.favorites|capitalize:true}</span></a>
                            </li>
						{else}
							<li id="slideVideoLi"><a class="clsVideoShare" onclick="showShareDiv('{$myobj->shareUrl}')" title="{$LANG.viewvideo_share_video|capitalize:true}"><span>{$LANG.viewvideo_share_video|capitalize:true}</span></a></li>
                            <li id="featured" ><a class="clsVideofeature" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('{$LANG.common_video_login_featured_msg}', '{$myobj->notLoginVideoUrl}')" title="{$LANG.feature|capitalize:true}"><span>{$LANG.feature|capitalize:true}</span></a></li>
							 <li id='favorite'><a class="clsVideofavourite" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('{$LANG.common_video_login_favorite_msg}', '{$myobj->notLoginVideoUrl}')" title="{$LANG.favorites|capitalize:true}"><span>{$LANG.favorites|capitalize:true}</span></a></li>
                        {/if}
                        </ul>
					</div>
                        <div id="shareDiv" class="clsPopupConfirmation" style="display:none">
                            <br />&nbsp;
                        </div>
                        <div id="clsMsgDisplay" class="clsDisplayNone clsFeaturedContent clsAddErrorMsg">
                    </div><div class="clsOverflow">

                                <div class="clsRightUrl" style="display:none">
                                    <!--<div class="clsVideoBookmarkIcons">
                                        {* DISPLAYING BOOKMARK LINK BEGIN *}
                                        <p class="clsPostVideo">
                                            {$myobj->populateBlogPost($myobj->blogPostViewVideoUrl, $myobj->getFormField('video_title'),$LANG.view_video_video_upload)}
                                        </p>
                                        {* DISPLAYING BOOKMARK LINK ENDS*}
                                    </div>-->
                                </div>
	                        </div> <div class="clsPlayerDownload clsOverflow">
		                    {if $CFG.admin.videos.download_option && $myobj->checkDownloadOption() && !$myobj->checkIsExternalEmebedCode()}
							   	<ul>
							   		<li class="clsPlayerDownloadtext">{$LANG.viewvideo_download}:</li>
			                        {if $CFG.admin.videos.save_original_file_to_download and $myobj->getFormField('video_ext')!='flv'}
			                        	{$myobj->populateOriginalFormatDownloadLink()}
			                        {/if}
			                        {if $CFG.admin.videos.video_other_formats_enabled and !$myobj->getFormField('video_flv_url')}
			                            {$myobj->populateOtherFormatDownloadLink()}
			                        {/if}
								  	<li class="clsNoBorder"><a class="clsflv" href="{$myobj->flvDownloadUrl}" target="_blank" title="{$myobj->getVideoDownLoadDetails('flv')}">{$LANG.flv}</a></li>
								</ul>
							{/if}
						</div>
				    </div>


                    <!-- playlist section -->

                    {* DISPLAYING PLAYLIST, FAVORITE , FEATURED , FLAG CONTENT , SHARE VIDEO ENDS*}

                   <!--<div class="clsvideoFeaturesMiddle">
					<div class="clsvideoFeaturesLeft"><div class="clsvideoFeaturesRight"><div class="clsVideoFeaturesList clsOverflow">
						<div class="clsVideoRatingLeft"><ul>
                        </ul></div>

                        <script type="text/javascript">
                        	var subMenuClassName1='clsActiveVideoLink';
                        	var hoverElement1  = '.clsVideoFeaturesList';
							loadChangeClass(hoverElement1, 'li', subMenuClassName1);
                        </script>
                    </div></div></div></div> -->

                		</div>
		    		</div>
				{$myobj->setTemplateFolder('general/','video')}
			 	{include file='box.tpl' opt='viewvideobottom_top'}
			 	<div class="clsOverflow clsViewVideoBottom">
					<div class="clsViewVideoLeft">


						{* VIDEO SCREEN SHOT BEGINS *}
	                    {if $CFG.admin.videos.show_available_thumbs AND $myobj->screenShot AND !$myobj->checkIsExternalEmebedCode()}
	                    	<div class="clsVideoScreenShotContainer">
								{$myobj->setTemplateFolder('general/','video')}
	         			{include file='box.tpl' opt='viewvideodetails_top'}
	                    		<h3>{$LANG.available_thumbnail}</h3>
	                    		<div class="clsViewVideoDetailsContent">
									<div id="videoDetailsList" class="clsVideoDetailsList">
	                    				<ul class="clsVideoScreenShotThumbnail">
	                        				{foreach from=$myobj->screenShot item=thumbnail}
					                            <li>
					                                {if $thumbnail.imageSrc}
						                                <div class="Cls93x70 ClsImageBorder1 ClsImageContainer">
															<img src="{$thumbnail.imageSrc}" width="{$myobj->screenShot_width}" height="{$myobj->screenShot_height}"/>
														</span>
					                                {/if}
					                            </li>
					                        {/foreach}
										</ul>
	                    			</div>
								</div>
									{$myobj->setTemplateFolder('general/','video')}
	         			{include file='box.tpl' opt='viewvideodetails_bottom'}
	                    	</div>
						{/if}
	                    {* VIDEO SCREEN SHOT ENDS *}

						{* Comment List Start *}
						{$myobj->setTemplateFolder('general/','video')}
	         			{include file='box.tpl' opt='viewvideodetails_top'}
	                    <div class="clsPaddingBottom5">
	                    	<div class="clsHeadingPostComment clsOverflow">
	                            <div class="clsViewVideoDetailsHeading">
	                                <h3>{$LANG.comments}&nbsp;(<span class="clsCommentsCount" id="selVideoCommentsCount">{$myobj->getFormField('total_comments')}</span>)</h3>
	                            </div>
	                            <div class="clsPostCommentHeading clsOverflow">
		                            {if $myobj->getFormField('allow_comments')=='Kinda' OR $myobj->getFormField('allow_comments')=='Yes'}
		                            	{if isMember()}
										 <div class="clsOverflow">
		                                	<span id="selViewPostComment" class="clsViewPostComment">
		                                    	<a class="" id="selPostVideoComment" href="{$myobj->getCurrentUrl()}" onclick="toggleVideoPostCommentOption(); return false;" title="{$LANG.viewvideo_post_comment}"><span>{$LANG.viewvideo_add_comment}</span></a>
		                              		</span>
											  {if isMember()}
	                        	{if $myobj->getFormField('allow_comments')=='Kinda'}
	                               <span>({$LANG.approval})</span>
	                            {/if}
	                        {/if}
										</div>
			                            {else}
			                                <div class="clsOverflow">   <span id="selViewPostComment" class="clsViewPostComment">
			                                    <a class="" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('{$LANG.common_video_login_post_comment_msg}', '{$myobj->commentUrl}')">
			                                    	<span>{$LANG.viewvideo_post_comment}</span> {if $myobj->getFormField('allow_comments')=='Kinda'}({$LANG.approval}){/if}
			                                    </a>
			                                </span>
											</div>
			                            {/if}
										{include file='addComments.tpl'}
		                            {/if}
	                            </div>
	                        </div>



	                    	{$myobj->populateCommentOptionsVideo()}
	                        <div id="selMsgSuccess" style="display:none">
	                        	<p id="kindaSelMsgSuccess"></p>
	                        </div>
	                        <div id="selCommentBlock" class="clsViewVideoDetailsContent">
	                            {$myobj->populateCommentOfThisVideo()}
	                        </div>
	                    </div>
	         			{include file='box.tpl' opt='viewvideodetails_bottom'}
						{* Comment List end *}
					</div>

				<div class="clsViewVideoRight">
					  {* DISPLAYING QUICK LINK BEGINS*}
                        {if isLoggedIn() and $CFG.admin.videos.allow_quick_links}
                            <div id="selVideoQuickLinks">
                                {$myobj->populateQuickLinkVideos()}
                            </div>
                        {/if}
                    {* DISPLAYING QUICK LINK ENDS*}
					 {* DISPLAYING MORE RELATED VIDEOS BEGIN*}
                    {$myobj->setTemplateFolder('general/','video')}
         			{include file='box.tpl' opt='viewvideodetails_top'}
                        <div class="clsOverflow">
                            <div class="clsViewMoreVideoHeading"><h3>
                            {$LANG.view_videos_more_videos}</h3></div>
                            <!--<div id="selNextPrev_top" class="clsRelatedPreviousNext">
                                <input type="button" class="enabledPrevButton" />
                                <input type="button" class="enabledNextButton" />
                            </div>-->
					  <div class="clsMoreVideosNav">
                        <ul class="clsFloatRight">
                            <li id="selHeaderVideoUser">
                                <span>
                                    <a class=""  onClick="getRelatedVideo('user');" title="{$LANG.view_videos_more_videos_user}">{$LANG.view_videos_more_videos_user}</a>
                                </span>
                            </li>
                            <li id="selHeaderVideoRel">
                                <span>
                                    <a onClick="getRelatedVideo('tag')" title="{$LANG.view_videos_more_videos_related}">{$LANG.view_videos_more_videos_related}</a>
                                </span>
                            </li>
                            <li id="selHeaderVideoTop">
                                <span>
                                    <a  onClick="getRelatedVideo('top')" title="{$LANG.view_videos_more_videos_top}">{$LANG.view_videos_more_videos_top}</a>
                                </span>
                            </li>
                        </ul>
                        </div>
                        </div>
                        <div class="clsMoreVideosContent">
                            <div class="clsUserContent" id="relatedVideoContent">
                            </div>
                            <div class="clsDisplayNone clsLoaderImagePosition" id="loaderVideos" align="center">
                            <img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/loader.gif" alt="{$LANG.loading}"/>{$LANG.loading}
                            </div>
                        </div>

                        <script type="text/javascript">
                        var subMenuClassName1='clsActiveMoreVideos';
                        var hoverElement1  = '.clsMoreVideosNav li';
						loadChangeClass(hoverElement1,subMenuClassName1);
                        </script>
                        <script type="text/javascript">
                        var relatedUrl="{$myobj->relatedUrl}";
                        getRelatedVideo('tag');
						</script>
                    {$myobj->setTemplateFolder('general/','video')}
         			{include file='box.tpl' opt='viewvideodetails_bottom'}
					{* DISPLAYING MORE RELATED VIDEOS ENDS*}
									  <a id="anchor_video_response_block"></a>
				 {* DISPLAYING VIDEO RESPONSE BEGIN*}
                    <div style="display:none;" id="selVideoResposeLinks" class="clsPopupViewVideo"></div>
                    <div id="slideShowBlock_anchor"></div>
                    <span id="loaderRespVideos" style="display:none">
                        <img src="{$CFG.site.url}/design/templates/{$CFG.html.template.default}/images/foxLoader.gif" alt="" title="" />
                    </span>
         			<div class="">
                    {include file='box.tpl' opt='viewvideodetails_top'}
                    <div class="clsOverflow">
                        <div class="clsViewVideoDetailsHeading clsVideVideoHeadingLeft">
                            <h3>{$LANG.video_responses_title}</h3>
                        </div>
                        <div class="clsPostCommentHeading clsVideVideoHeadingRight">
                        {if isLoggedIn()}
                        	 {if $myobj->getFormField('allow_response')=='Kinda' OR $myobj->getFormField('allow_response')=='Yes'}
                                <a class="clsButton2" onclick="postVideoResponse();" ><span>{$LANG.post_video_response}</span></a>
                            {/if}
                        {else}
                             <a class="clsButton2" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('{$LANG.common_video_login_post_video_response_msg}', '{$myobj->notLoginVideoUrl}')"><span>{$LANG.post_video_response}</span></a>
                        {/if}

                        </div>

                     </div>

                        {if isLoggedIn()}
                        	 {if $myobj->getFormField('allow_response')=='Kinda'}
                               <div class="clsOverflow">
                        		<div class="clsPostCommentHeading clsVideVideoHeadingRight">({$LANG.approval})</div></div>
                            {/if}
                        {/if}

                    <div id="selUserContentResp" class="clsViewVideoDetailsResponse clsOverflow">
                        {$myobj->populateVideoCommentsOfThisVideo(3)}
                    </div>

                    {include file='box.tpl' opt='viewvideodetails_bottom'}
                    </div>

					{* DISPLAYING VIDEO RESPONSE ENDS *}


				</div>
			</div>
			{include file='box.tpl' opt='viewvideobottom_bottom'}
        {* VIDEO BOTTOM CONTENT ENDS *}

    	{/if}
    {/if}
    </div>
{* VIDEO CONTENT ENDS *}

<script type="text/javascript" language="javascript">

</script>
{literal}
<script language="javascript" type="text/javascript">
	function toggleVideoPostCommentOption(){
		$Jq("#selEditMainComments").toggle('slow');
	}
	$Jq("#tabs").tabs();
</script>
{/literal}
<script>
{literal}
$Jq('#videoCaptionSummary').jScrollPane({showArrows:true,scrollbarWidth:10, scrollbarMargin:10});
{/literal}
</script>

