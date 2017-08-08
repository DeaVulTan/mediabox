<?php /* Smarty version 2.6.18, created on 2013-08-19 14:53:28
         compiled from viewVideo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'viewVideo.tpl', 26, false),array('modifier', 'capitalize', 'viewVideo.tpl', 428, false),)), $this); ?>
<?php if(isset($this->bodyBackgroundImage) && $this->bodyBackgroundImage){ ?>
<div id="selViewVideo" style="margin-top:<?php echo $this->_tpl_vars['myobj']->background_offset; ?>
px">
<?php }
else{ ?>
<div id="selViewVideo">
<?php }
 ?>
<?php if ($this->_tpl_vars['myobj']->isTrimmedVideo()): ?>
<div class="clsTrimmedVideo">
	<h4 class="clsAlert"><?php echo $this->_tpl_vars['myobj']->trimmendMessage; ?>
</h4>
</div>
<?php endif; ?>

	<div class="clsViewVideoContent">
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_error')): ?>
            <div id="selMsgError">
                <p><?php echo $this->_tpl_vars['myobj']->getCommonErrorMsg(); ?>
</p>
            </div>
        <?php endif; ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('videoMainBlock')): ?>

		<div id="selMsgConfirmWindow" class="clsMsgConfirmWindow" style="display:none;">
			<h3 id="confirmationMsg"></h3>
			<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
		      	<input type="button" class="clsSubmitButton" name="confirm_action" id="confirm_action" onclick="deleteCommandOrReply();" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
		      	&nbsp;
		      	<input type="button" class="clsCancelButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks();" />
		      	<input type="hidden" name="comment_id" id="comment_id" />
		      	<input type="hidden" name="maincomment_id" id="maincomment_id" />
		      	<input type="hidden" name="commentorreply" id="commentorreply" />
			</form>
		</div>

        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_success') || $this->_tpl_vars['myobj']->video_response_added): ?>
            <div id="selMsgSuccess">
                <p><?php echo $this->_tpl_vars['myobj']->video_response_successfully_added; ?>
</p>
            </div>
        <?php endif; ?>

        <!-- flagged video confirmation form -->
        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('confirmation_flagged_form')): ?>
            <div id="flaggedForm">
                <p><?php echo $this->_tpl_vars['LANG']['viewvideo_flagged_msg']; ?>
</p>
                <p><a href="<?php echo $this->_tpl_vars['myobj']->flaggedVideoUrl; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_flagged']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewvideo_flagged']; ?>
</a></p>
            </div>
        <?php endif; ?>
        <!-- flagged video confirmation form ends-->

        <!-- Adult video confirmation form -->
        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('confirmation_adult_form')): ?>
            <div id="selAdultUserForm">
                <p><?php echo $this->_tpl_vars['myobj']->replaceAdultText($this->_tpl_vars['LANG']['confirmation_alert_text']); ?>
</p>
                <p><a href="<?php echo $this->_tpl_vars['myobj']->acceptAdultVideoUrl; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_accept']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewvideo_accept']; ?>
</a>&nbsp;&nbsp;
                <a href="<?php echo $this->_tpl_vars['myobj']->acceptThisAdultVideoUrl; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_accept_this_page_only']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewvideo_accept_this_page_only']; ?>
</a>&nbsp;&nbsp;
                <a href="<?php echo $this->_tpl_vars['myobj']->rejectAdultVideoUrl; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_reject']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewvideo_reject']; ?>
</a>&nbsp;&nbsp;
                <a href="<?php echo $this->_tpl_vars['myobj']->rejectThisAdultVideoUrl; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_reject_this_page_only']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewvideo_reject_this_page_only']; ?>
</a> </p>
            </div>
        <?php endif; ?>
        <!-- Adult video confirmation form ends-->
        <!-- displaying Video -->
        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('videos_form') && $this->_tpl_vars['myobj']->validate): ?>

       <?php /*?> off "Сайты со ссылками на это видео" by Abror Ahmedov
                <?php if (! $this->_tpl_vars['myobj']->checkIsExternalEmebedCode()): ?>
            <div style="display:none;position:absolute;" id="clsVideoRenders" class="clsCommonPopupDiv">
                 <form name="msgHistoryLink" id="msgHistoryLink" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
              <table class="clsTable100">
                  <tr>
                      <th><h4><?php echo $this->_tpl_vars['LANG']['viewvideo_site_links']; ?>
</h4></th>
                      <th><input class="clsCloseWindow" onClick="return hideAllBlocks()" name="cancel_submit" /></th>
                  </tr>
                  <tr>
                      <td colspan="2">
                          <ul class="clsLinkingSites">
                              <?php echo $this->_tpl_vars['myobj']->getLinksHistory(); ?>

                          </ul>
                      </td>
                  </tr>
              </table>
              </form>
            </div>
          <?php endif; ?><?php */?>
              
	   	<div class="clsViewVideoHeadingLeft">
			<div class="clsViewVideoHeadingMiddle">
				<div class="clsViewVideoHeadingRight">
	        		<div class="clsOverflow clsVideoPlayerDetails">
						 <div class="clsVideoPlayerHeadingContainer clsFloatLeft">
									<h2 class="clsVideoPlayerHeading"><?php echo $this->_tpl_vars['myobj']->videoTitle; ?>
</h2>

								 </div>
						 <div class="clsCaptionMinHeight">
																				<div class="clsOverflow">
											<div class="clsVideoRatingRight">
																						<?php if ($this->_tpl_vars['myobj']->chkAllowRating()): ?>
											<div id="ratingForm">
											 <?php $this->assign('tooltip', ""); ?>
											<?php if (! isLoggedIn ( )): ?>
													<?php echo $this->_tpl_vars['myobj']->populateRatingImages($this->_tpl_vars['myobj']->total_video_rating,'viewvideo',$this->_tpl_vars['LANG']['view_video_login_message'],$this->_tpl_vars['myobj']->notLoginVideoUrl); ?>

													<?php $this->assign('tooltip', $this->_tpl_vars['LANG']['view_video_login_message']); ?>
													<span> (<?php echo $this->_tpl_vars['myobj']->getFormField('rating_count'); ?>
)</span>
											<?php else: ?>
												<div id="selRatingVideo">
														<?php if ($this->_tpl_vars['myobj']->isMember && $this->_tpl_vars['myobj']->rankUsersRayzz): ?>
															<?php echo $this->_tpl_vars['myobj']->populateRatingImagesForAjax($this->_tpl_vars['myobj']->total_video_rating,'viewviewo'); ?>

														<?php else: ?>
															<?php echo $this->_tpl_vars['myobj']->populateRatingImages($this->_tpl_vars['myobj']->total_video_rating,'viewvideo',$this->_tpl_vars['LANG']['viewvideo_rate_yourself'],'javascript:void(0);'); ?>

															<?php $this->assign('tooltip', $this->_tpl_vars['LANG']['viewvideo_rate_yourself']); ?>
														<?php endif; ?>
														   (<span><?php echo $this->_tpl_vars['myobj']->getFormField('rating_count'); ?>
</span>)
												</div>
											<?php endif; ?>

									<script type="text/javascript">
									  <?php echo '
									  $Jq(document).ready(function(){
										$Jq(\'#ratingLink\').attr(\'title\',\''; ?>
<?php echo $this->_tpl_vars['tooltip']; ?>
<?php echo '\');
										$Jq(\'#ratingLink\').tooltip({
																track: true,
																delay: 0,
																showURL: false,
																showBody: " - ",
																extraClass: "clsToolTip",
																top: -10
															});
											});
										'; ?>

									  </script>

																						</div>
											<?php endif; ?>
											</div>
											<div class="clsVideoPlayerViews">
												<ul>
													<li>
														<span><?php echo $this->_tpl_vars['LANG']['common_views']; ?>
:</span>
														<span class="clsVideoViewsRight"><span class="clsVideoViewsLeft"><?php echo $this->_tpl_vars['myobj']->getFormField('total_views'); ?>
</span></span>
													</li>
													<li>
														<span><?php echo $this->_tpl_vars['LANG']['short_favorite']; ?>
:</span>
														<span class="clsVideoViewsRight"><span class="clsVideoViewsLeft"><?php echo $this->_tpl_vars['myobj']->getFormField('favorited'); ?>
</span></span>
													</li>
													<li>
														<span><?php echo $this->_tpl_vars['LANG']['short_comments']; ?>
:</span>
														<span class="clsVideoViewsRight"><span class="clsVideoViewsLeft"><?php echo $this->_tpl_vars['myobj']->getFormField('comments'); ?>
</span></span>
													</li>
												</ul>
											</div>
										</div>
										
									 </div>
					 </div>
				</div>
			</div>
		</div>
                    <div class="clsVideoBottom clsOverflow">
		      <div class="clsViewVideoLeft">
                                        <div id="playerSection">
			        
                                                <div id="flashcontent2" class="clsVideoPlayerBorder clsViewVideoPlayer">
                           <table>
                           		<tr>
                                	<td>
                                         <?php if ($this->_tpl_vars['myobj']->checkIsExternalEmebedCode()): ?>
                                         <?php echo $this->_tpl_vars['myobj']->displayEmbededVideo(); ?>

                                         <?php endif; ?>
                             		</td>
	                             </tr>
                            </table>
                        </div>
                       <?php if (! $this->_tpl_vars['myobj']->checkIsExternalEmebedCode()): ?>
                        <script type="text/javascript">
                            var so1 = new SWFObject("<?php echo $this->_tpl_vars['myobj']->flv_player_url; ?>
", "flvplayer", "<?php echo $this->_tpl_vars['CFG']['admin']['videos']['minimum_player_width']; ?>
", "<?php echo $this->_tpl_vars['CFG']['admin']['videos']['minimum_player_height']; ?>
", "7",  null, true);
                            so1.addParam("allowFullScreen", "true");
                            so1.addParam("wmode", "transparent");
                            <?php if ($this->_tpl_vars['myobj']->play_list_next_url): ?>
                            so1.addParam("autoplay", "true");
                            <?php endif; ?>
                            so1.addParam("allowSciptAccess", "always");
                            so1.addVariable("config", "<?php echo $this->_tpl_vars['myobj']->configXmlcode_url; ?>
<?php echo $this->_tpl_vars['myobj']->arguments_play; ?>
");
                            so1.write("flashcontent2");
                        </script>
                        <?php else: ?>
                        	<?php echo '
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
                            '; ?>

                        <?php endif; ?>
                                            </div>
                    
                        <?php if ($this->_tpl_vars['myobj']->video_response_links): ?>
                        <div class="clsRespondedVideo">
                           <div class="clsNoVideo"> <p><?php echo $this->_tpl_vars['LANG']['this_video_response_for_video']; ?>

                                <?php echo $this->_tpl_vars['myobj']->video_response_links; ?>

                            </p></div>
                        </div>
                        <?php endif; ?>

                </div>
              <div class="clsViewVideoRight">
                    					                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general','video'); ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'videoinfo_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					            						 <?php if ($this->_tpl_vars['CFG']['admin']['media_description_display']): ?>
                                    <?php if ($this->_tpl_vars['myobj']->getFormField('video_caption')): ?>
									<div id="videoCaption" class="clsVideoSummary">
                                        <p><span><?php echo $this->_tpl_vars['LANG']['viewvideo_summary']; ?>
:</span></p>
                                    <div class="clsVideoCaptionHeight" id="videoCaptionSummary">
											<p class="clsVideoDes"><?php echo $this->_tpl_vars['myobj']->videoCaption; ?>
</p>
									</div>
                                    <?php else: ?>
                                    <div id="videoCaption" class="clsVideoSummary">
                                        <p><span><?php echo $this->_tpl_vars['LANG']['viewvideo_summary_not_available']; ?>
</span></p>
                                    <?php endif; ?>

                                    </div>
                                <?php endif; ?>
                                                        <div class="clsOverflow clsVideoUserDetailsTop">
                        	<div class="clsVideoDetailsLeft">
                                <span class="clsMembersImage">
									<a href="<?php echo $this->_tpl_vars['myobj']->memberProfileUrl; ?>
" class="ClsImageContainer ClsImageBorder2 Cls47x47"><img src="<?php echo $this->_tpl_vars['myobj']->memberProfileImgSrc['icon']['m_url']; ?>
" alt="<?php echo $this->_tpl_vars['myobj']->getFormField('user_name'); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['myobj']->memberProfileImgSrc['icon']['s_width'],$this->_tpl_vars['myobj']->memberProfileImgSrc['icon']['s_height']); ?>
/></a></span>
                            </div>
                            <div class="clsVideoDetailsRight">
                                <p class="clsVideoDetailsUserName">
                                    <span class="clsVideoContentTitle"><?php echo $this->_tpl_vars['LANG']['viewvideo_added_by']; ?>
</span><a href="<?php echo $this->_tpl_vars['myobj']->memberProfileUrl; ?>
"><?php echo $this->_tpl_vars['myobj']->addedUserName; ?>
</a>
                                </p>
								 <p>
                                      <span class="clsVideoContentTitle"><?php echo $this->_tpl_vars['LANG']['viewvideo_added_date']; ?>
</span>
                                      <span class="clsFontWhite"><?php echo $this->_tpl_vars['myobj']->getFormField('date_added'); ?>
</span>
                                  </p>
						 
                           <?php if (chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
					<?php if (isMember ( )): ?>
                              	<?php if ($this->_tpl_vars['myobj']->getFormField('user_id') != $this->_tpl_vars['CFG']['user']['user_id']): ?>
                                     <p class="clsSubscriptionBtn">
                                          <a href="javascript:void(0);" id="anchor_subscribe" onclick="get_subscription_options(<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
, 50, -300, 'anchor_subscribe');" title="<?php echo $this->_tpl_vars['LANG']['common_subscriptions']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_subscriptions']; ?>
</a>
                                     </p>
                                    <?php endif; ?>
                              <?php else: ?>
                                     <p class="clsSubscriptionBtn">
                                 		   <a href="javascript:void(0)" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['common_video_subscribe_subscribe_msg']; ?>
', '<?php echo $this->_tpl_vars['myobj']->notLoginVideoUrl; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['common_subscriptions']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_subscriptions']; ?>
</a>
 	                                </p>
                              <?php endif; ?>
                           <?php endif; ?>
				                               </div>
                          </div>
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'videoinfo_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

         			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'videocontent_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <div id="videoDetails">
						<div class="clsOverflow">
                    	<h3 class="clsFloatLeft"><?php echo $this->_tpl_vars['LANG']['viewvideo_details']; ?>
</h3>
						<?php if (isMember ( ) && $this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id']): ?>
                            <div class="clsOverflow clsVideoRatingContainer clsMarginBottom5">

                             	<div class="clsEditVideoLink">
                                	<span><a href="<?php echo $this->_tpl_vars['myobj']->editVideoUrl; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_edit_video']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewvideo_edit_video']; ?>
</a></span>
                                </div>

                            </div>
                            <?php endif; ?>
							</div>
                        <div class="clsViewVideoDetailsContent">
					<div>
								<div class="clsOverflow">
                             	   <div class="clsVideoInformation">
									<div class="clsLabel"><?php echo $this->_tpl_vars['LANG']['viewvideo_playing_time']; ?>
</div>
                                    <div class="clsSeparator">:</div>
                                    <div class="clsDetails"><?php echo $this->_tpl_vars['myobj']->getFormField('cur_vid_play_time'); ?>
</div>
                                </div>
                                </div>
								<div class="clsOverflow">
                                <div class="clsVideoInformation">
                                    <div class="clsLabel"><?php echo $this->_tpl_vars['LANG']['totalvideos_thisuser']; ?>
</div>
                                    <div class="clsSeparator">:</div>
                                    <div class="clsDetails"><?php echo $this->_tpl_vars['myobj']->getTotalVideosOfThisUser(1); ?>
</div>
                                </div>
                                </div>
								<div class="clsOverflow">
                                <div class="clsVideoInformation" id="category_container_<?php echo $this->_tpl_vars['myobj']->getFormField('video_category_id'); ?>
">
                                    <div class="clsLabel"><?php echo $this->_tpl_vars['LANG']['viewvideo_channel']; ?>
</div>
                                    <div class="clsSeparator">:</div>
                                    <div class="clsDetails"><?php echo $this->_tpl_vars['myobj']->getChannelOfThisVideo(); ?>
</div>
                                </div>
                                </div>
		                    									<div class="clsOverflow">
		                        <div class="clsVideoInformation">
									<div class="clsLabel"><?php echo $this->_tpl_vars['LANG']['viewvideo_tags']; ?>
&nbsp;</div>
                                    <div class="clsSeparator">:</div>
									<div class="clsDetails"><?php echo $this->_tpl_vars['myobj']->getTagsOfThisVideo(); ?>
</div>
		                        </div>
                                </div>
		                        
						                            <?php if ($this->_tpl_vars['CFG']['admin']['videos']['sub_category'] && $this->_tpl_vars['myobj']->getFormField('video_sub_category_id') != 0): ?>
								<div class="clsOverflow">
                                  <div class="clsVideoInformation" id="sub_category_container_<?php echo $this->_tpl_vars['myobj']->getFormField('video_sub_category_id'); ?>
">
                                      <div class="clsLabel"><?php echo $this->_tpl_vars['LANG']['viewvideo_sub_channel']; ?>
</div>
                                      <div class="clsSeparator">:</div>
                                      <div class="clsDetails"><?php echo $this->_tpl_vars['myobj']->getChannelOfThisVideo(true); ?>
</div>
                                  </div>
                                </div>
                            <?php endif; ?>
                                                          <?php if (! $this->_tpl_vars['myobj']->checkIsExternalEmebedCode() && $this->_tpl_vars['myobj']->chkLinksDisplayAllowedTo()): ?>
                                                                        <a id="anchor_video_block"></a>
                                      <div class="clsVideoInformation">
                                          <div class="clsLabel"><?php echo $this->_tpl_vars['LANG']['viewvideo_links']; ?>
</div>
                                          <div class="clsSeparator">:</div>
                                          <div class="clsDetails"><a onclick="Confirmation('clsVideoRenders','msgHistoryLink','','');"><?php echo $this->_tpl_vars['myobj']->getTotalRenderList(); ?>
</a></div>
                                      </div>
                                                                     <?php endif; ?>
                                </div>

                           <!-- <?php if (isMember ( ) && $this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id']): ?>
                            <div class="clsOverflow clsVideoRatingContainer clsMarginBottom5">

                             	<div class="clsEditVideoLink">
                                	<span><a href="<?php echo $this->_tpl_vars['myobj']->editVideoUrl; ?>
"><?php echo $this->_tpl_vars['LANG']['viewvideo_edit_video']; ?>
</a></span>
                                </div>

                            </div>
                            <?php endif; ?>-->
						<div>
                                                                                   <!-- <p class="clsVideoContentTitle">
                                          <label><?php echo $this->_tpl_vars['LANG']['viewvideo_video_url']; ?>
</label></p>-->
                                          <p class="clsUrlBg"> <input type="text" class="clsVideoUrlTextBox" name="video_url" id="video_url" value="<?php echo $this->_tpl_vars['myobj']->viewVideoEmbedUrl; ?>
" size="52" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onfocus="this.select()" onclick="this.select()" readonly="readonly" />
                                           </p>
                                          
                                                                                    <?php if ($this->_tpl_vars['myobj']->getFormField('allow_embed') == 'Yes' && $this->_tpl_vars['CFG']['admin']['videos']['embedable']): ?>
<!--                                          <p class="clsVideoContentTitle">
                                          <label><?php echo $this->_tpl_vars['LANG']['viewvideo_embeddable_player']; ?>
</label></p>-->
                                          <form name="formGetCode" id="formGetCode" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
                                          <?php if ($this->_tpl_vars['myobj']->checkIsExternalEmebedCode()): ?>
                                                 <p class="clsEmdedUrlBg"><input type="text" class="clsVideoUrlTextBox" name="image_code" id="image_code" readonly="readonly" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onfocus="this.select()" onclick="this.select()" value="<?php echo $this->_tpl_vars['myobj']->getFormField('video_external_embed_code'); ?>
" /></p>
                                          <?php else: ?>
                                                                                               <div class="clsOverflow">
											    <p class="clsEmdedUrlBg"><input type="text" class="clsVideoUrlTextBox" name="image_code" id="image_code" readonly="readonly" onfocus="this.select()" onClick="this.select()" value="<?php echo $this->_tpl_vars['myobj']->embeded_code; ?>
" />&nbsp;</p><p class="clsEmbededDropContainer"><a class="clsEmbededDrop" href="javascript:void(0)" id="embed_options_key" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_customize_tooltip']; ?>
"></a></p>
												</div>
                                           <?php endif; ?>
                                          </form>
                                          <?php endif; ?>
                                          <div id="customize_embed_size" style="display:none">
										  <div class="clsEmbededDropDown">
										  	<div  class="clsEmbededDropDownArrow">
                                                <p><span><?php echo $this->_tpl_vars['LANG']['viewvideo_note']; ?>
:</span>&nbsp;&nbsp;<?php echo $this->_tpl_vars['LANG']['viewvideo_customize_embed']; ?>
</p>
											</div>
                                            	<div>
                                                	<div id="embed_error_msg" class="clsEmbededError" style="display:none"></div>
                                                	<form name="form_customize_embed" id="form_customize_embed" autocomplete="off">
										<div class="clsOverflow">
											<div class="clsEmedWidthLeft"><span><label for="embed_width"><?php echo $this->_tpl_vars['LANG']['viewvideo_customize_width']; ?>
</label>:</span>&nbsp;
												<input type="text" name="embed_width" id="embed_width" class="validate-embed validate-embed-num" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" maxlength="4" />
											</div>
											<div class="clsEmedHeightRight"><span><label for="embed_height"><?php echo $this->_tpl_vars['LANG']['viewvideo_customize_height']; ?>
</label>:</span>&nbsp;
												<input type="text" name="embed_height" id="embed_height" class="validate-embed validate-embed-num" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" maxlength="4" />
											</div>
										</div>

									  <div class="clsOverflow clsEmbedBtns">
										<div class="clsEmbdButtonLeft"><div class="clsEmbdButtonRight">
											<input type="button" name="change_embed_code" id="change_embed_code" value="<?php echo $this->_tpl_vars['LANG']['viewvideo_customize_apply']; ?>
" onclick="customizeEmbedOptions();" />
										</div></div>
										<div class="clsEmbdButtonLeftdefault"><div class="clsEmbdButtonRightdefault">
											<a href="javascript:void(0)" onclick="customizeEmbedOptions('default')" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_customize_default_size']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewvideo_customize_default_size']; ?>
</a>
										</div></div>
										<a class="clsEmbdClose" href="javascript:void(0)" id="close_embed_options" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_customize_close']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewvideo_customize_close']; ?>
</a>
									</div>
									</form>
                                                </div>
                                          </div>
                                           </div>
                                                                             </div>
                        </div>
                    </div>
                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

         			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'videocontent_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    
					    					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideoplay_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<div class="clsCommonTabPopup">
				   	<div id="tabs" class="clsVideoFeaturesList">
						<ul class="clsOverflow">
                        	<?php if ($this->_tpl_vars['CFG']['admin']['videos']['allow_play_list']): ?>
							<li id="videoPlaylistLi" <?php if ($this->_tpl_vars['CFG']['admin']['videos']['allow_play_list'] == false): ?> style="display:none" <?php endif; ?>>
								<span><a class="clsVideoPlaylist" href="#option-tab-1" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['playlist'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['playlist'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</a></span>
							</li>
							<?php endif; ?>
                        	<li id="videoFlagLi">
								<span><a class="clsVideoflag" href="#option-tab-2" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['viewvideo_flag_content'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['viewvideo_flag_content'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</a></span>
							</li>
							<li id="selAddBlogLink">
                            	<span><a class="" href="#option-tab-3" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_add_to_blog']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewvideo_add_to_blog']; ?>
</a></span>
                        	</li>
                        </ul>
					 <div>
                    	<?php if ($this->_tpl_vars['CFG']['admin']['videos']['allow_play_list']): ?>
	                    <?php echo $this->_tpl_vars['myobj']->populatePlaylist(); ?>

                        <?php endif; ?>
                        <?php echo $this->_tpl_vars['myobj']->populateFlagContent(); ?>

                        <?php echo $this->_tpl_vars['myobj']->populateVideoBlog(); ?>

                    </div>
				</div>
				 <script type="text/javascript">
                        	var subMenuClassName1='clsActiveVideoLink';
                        	var hoverElement1  = '.clsVideoFeaturesList';
							loadChangeClass(hoverElement1, 'li', subMenuClassName1);
                        </script>
					 </div>
					   <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideoplay_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<div class="clsOverflow">
						<ul class="clsShareVideoTab">
                         <?php if ($this->_tpl_vars['myobj']->isMember): ?>
                           <li id="slideVideoLi">
						   		<a class="clsVideoShare" onclick="showShareDiv('<?php echo $this->_tpl_vars['myobj']->shareUrl; ?>
')" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['viewvideo_share_video'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
">
									<span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['viewvideo_share_video'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</span>
								</a>
							</li>
                            <li id='unfeatured' <?php if (! $this->_tpl_vars['myobj']->featured['added']): ?> style="display:none"<?php endif; ?>>
                                <a class="clsVideofeatured" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['featured'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
" onclick="getViewVideoMoreContent('Featured');"><span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['featured'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</span></a>
                            </li>
                            <li id="featured" <?php if ($this->_tpl_vars['myobj']->featured['added']): ?> style="display:none"<?php endif; ?>>
                                <a class="clsVideofeature" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['feature'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
" onclick="getViewVideoMoreContent('Featured', 'remove');" ><span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['feature'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</span></a>
                            </li>
							<li id='unfavorite' <?php if (! $this->_tpl_vars['myobj']->favorite['added']): ?> style="display:none"<?php endif; ?>>
                               <a class="clsVideofavourite" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['favorited'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
" onclick="getViewVideoMoreContent('Favorites');" > <span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['favorited'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</span></a>
                            </li>
                            <li id="favorite" <?php if ($this->_tpl_vars['myobj']->favorite['added']): ?> style="display:none"<?php endif; ?>>
                               <a class="clsVideofavourited" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['favorites'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
" onclick="getViewVideoMoreContent('Favorites','remove');" ><span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['favorites'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</span></a>
                            </li>
						<?php else: ?>
							<li id="slideVideoLi"><a class="clsVideoShare" onclick="showShareDiv('<?php echo $this->_tpl_vars['myobj']->shareUrl; ?>
')" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['viewvideo_share_video'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
"><span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['viewvideo_share_video'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</span></a></li>
                            <li id="featured" ><a class="clsVideofeature" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['common_video_login_featured_msg']; ?>
', '<?php echo $this->_tpl_vars['myobj']->notLoginVideoUrl; ?>
')" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['feature'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
"><span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['feature'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</span></a></li>
							 <li id='favorite'><a class="clsVideofavourite" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['common_video_login_favorite_msg']; ?>
', '<?php echo $this->_tpl_vars['myobj']->notLoginVideoUrl; ?>
')" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['favorites'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
"><span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['favorites'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</span></a></li>
                        <?php endif; ?>
                        </ul>
					</div>
                        <div id="shareDiv" class="clsPopupConfirmation" style="display:none">
                            <br />&nbsp;
                        </div>
                        <div id="clsMsgDisplay" class="clsDisplayNone clsFeaturedContent clsAddErrorMsg">
                    </div><div class="clsOverflow">

                                <div class="clsRightUrl" style="display:none">
                                    <!--<div class="clsVideoBookmarkIcons">
                                                                                <p class="clsPostVideo">
                                            <?php echo $this->_tpl_vars['myobj']->populateBlogPost($this->_tpl_vars['myobj']->blogPostViewVideoUrl,$this->_tpl_vars['myobj']->getFormField('video_title'),$this->_tpl_vars['LANG']['view_video_video_upload']); ?>

                                        </p>
                                                                            </div>-->
                                </div>
	                        </div> <div class="clsPlayerDownload clsOverflow">
		                    <?php if ($this->_tpl_vars['CFG']['admin']['videos']['download_option'] && $this->_tpl_vars['myobj']->checkDownloadOption() && ! $this->_tpl_vars['myobj']->checkIsExternalEmebedCode()): ?>
							   	<ul>
							   		<li class="clsPlayerDownloadtext"><?php echo $this->_tpl_vars['LANG']['viewvideo_download']; ?>
:</li>
			                        <?php if ($this->_tpl_vars['CFG']['admin']['videos']['save_original_file_to_download'] && $this->_tpl_vars['myobj']->getFormField('video_ext') != 'flv'): ?>
			                        	<?php echo $this->_tpl_vars['myobj']->populateOriginalFormatDownloadLink(); ?>

			                        <?php endif; ?>
			                        <?php if ($this->_tpl_vars['CFG']['admin']['videos']['video_other_formats_enabled'] && ! $this->_tpl_vars['myobj']->getFormField('video_flv_url')): ?>
			                            <?php echo $this->_tpl_vars['myobj']->populateOtherFormatDownloadLink(); ?>

			                        <?php endif; ?>
								  	<li class="clsNoBorder"><a class="clsflv" href="<?php echo $this->_tpl_vars['myobj']->flvDownloadUrl; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['myobj']->getVideoDownLoadDetails('flv'); ?>
"><?php echo $this->_tpl_vars['LANG']['flv']; ?>
</a></li>
								</ul>
							<?php endif; ?>
						</div>
				    </div>


                    <!-- playlist section -->

                    
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
				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

			 	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideobottom_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			 	<div class="clsOverflow clsViewVideoBottom">
					<div class="clsViewVideoLeft">


							                    <?php if ($this->_tpl_vars['CFG']['admin']['videos']['show_available_thumbs'] && $this->_tpl_vars['myobj']->screenShot && ! $this->_tpl_vars['myobj']->checkIsExternalEmebedCode()): ?>
	                    	<div class="clsVideoScreenShotContainer">
								<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

	         			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideodetails_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	                    		<h3><?php echo $this->_tpl_vars['LANG']['available_thumbnail']; ?>
</h3>
	                    		<div class="clsViewVideoDetailsContent">
									<div id="videoDetailsList" class="clsVideoDetailsList">
	                    				<ul class="clsVideoScreenShotThumbnail">
	                        				<?php $_from = $this->_tpl_vars['myobj']->screenShot; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['thumbnail']):
?>
					                            <li>
					                                <?php if ($this->_tpl_vars['thumbnail']['imageSrc']): ?>
						                                <div class="Cls93x70 ClsImageBorder1 ClsImageContainer">
															<img src="<?php echo $this->_tpl_vars['thumbnail']['imageSrc']; ?>
" width="<?php echo $this->_tpl_vars['myobj']->screenShot_width; ?>
" height="<?php echo $this->_tpl_vars['myobj']->screenShot_height; ?>
"/>
														</span>
					                                <?php endif; ?>
					                            </li>
					                        <?php endforeach; endif; unset($_from); ?>
										</ul>
	                    			</div>
								</div>
									<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

	         			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideodetails_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	                    	</div>
						<?php endif; ?>
	                    
												<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

	         			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideodetails_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	                    <div class="clsPaddingBottom5">
	                    	<div class="clsHeadingPostComment clsOverflow">
	                            <div class="clsViewVideoDetailsHeading">
	                                <h3><?php echo $this->_tpl_vars['LANG']['comments']; ?>
&nbsp;(<span class="clsCommentsCount" id="selVideoCommentsCount"><?php echo $this->_tpl_vars['myobj']->getFormField('total_comments'); ?>
</span>)</h3>
	                            </div>
	                            <div class="clsPostCommentHeading clsOverflow">
		                            <?php if ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda' || $this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Yes'): ?>
		                            	<?php if (isMember ( )): ?>
										 <div class="clsOverflow">
		                                	<span id="selViewPostComment" class="clsViewPostComment">
		                                    	<a class="" id="selPostVideoComment" href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" onclick="toggleVideoPostCommentOption(); return false;" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_post_comment']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewvideo_add_comment']; ?>
</span></a>
		                              		</span>
											  <?php if (isMember ( )): ?>
	                        	<?php if ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda'): ?>
	                               <span>(<?php echo $this->_tpl_vars['LANG']['approval']; ?>
)</span>
	                            <?php endif; ?>
	                        <?php endif; ?>
										</div>
			                            <?php else: ?>
			                                <div class="clsOverflow">   <span id="selViewPostComment" class="clsViewPostComment">
			                                    <a class="" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['common_video_login_post_comment_msg']; ?>
', '<?php echo $this->_tpl_vars['myobj']->commentUrl; ?>
')">
			                                    	<span><?php echo $this->_tpl_vars['LANG']['viewvideo_post_comment']; ?>
</span> <?php if ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda'): ?>(<?php echo $this->_tpl_vars['LANG']['approval']; ?>
)<?php endif; ?>
			                                    </a>
			                                </span>
											</div>
			                            <?php endif; ?>
										<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addComments.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		                            <?php endif; ?>
	                            </div>
	                        </div>



	                    	<?php echo $this->_tpl_vars['myobj']->populateCommentOptionsVideo(); ?>

	                        <div id="selMsgSuccess" style="display:none">
	                        	<p id="kindaSelMsgSuccess"></p>
	                        </div>
	                        <div id="selCommentBlock" class="clsViewVideoDetailsContent">
	                            <?php echo $this->_tpl_vars['myobj']->populateCommentOfThisVideo(); ?>

	                        </div>
	                    </div>
	         			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideodetails_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
											</div>

				<div class="clsViewVideoRight">
					                          <?php if (isLoggedIn ( ) && $this->_tpl_vars['CFG']['admin']['videos']['allow_quick_links']): ?>
                            <div id="selVideoQuickLinks">
                                <?php echo $this->_tpl_vars['myobj']->populateQuickLinkVideos(); ?>

                            </div>
                        <?php endif; ?>
                    					                     <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

         			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideodetails_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        <div class="clsOverflow">
                            <div class="clsViewMoreVideoHeading"><h3>
                            <?php echo $this->_tpl_vars['LANG']['view_videos_more_videos']; ?>
</h3></div>
                            <!--<div id="selNextPrev_top" class="clsRelatedPreviousNext">
                                <input type="button" class="enabledPrevButton" />
                                <input type="button" class="enabledNextButton" />
                            </div>-->
					  <div class="clsMoreVideosNav">
                        <ul class="clsFloatRight">
                            <li id="selHeaderVideoUser">
                                <span>
                                    <a class=""  onClick="getRelatedVideo('user');" title="<?php echo $this->_tpl_vars['LANG']['view_videos_more_videos_user']; ?>
"><?php echo $this->_tpl_vars['LANG']['view_videos_more_videos_user']; ?>
</a>
                                </span>
                            </li>
                            <li id="selHeaderVideoRel">
                                <span>
                                    <a onClick="getRelatedVideo('tag')" title="<?php echo $this->_tpl_vars['LANG']['view_videos_more_videos_related']; ?>
"><?php echo $this->_tpl_vars['LANG']['view_videos_more_videos_related']; ?>
</a>
                                </span>
                            </li>
                            <li id="selHeaderVideoTop">
                                <span>
                                    <a  onClick="getRelatedVideo('top')" title="<?php echo $this->_tpl_vars['LANG']['view_videos_more_videos_top']; ?>
"><?php echo $this->_tpl_vars['LANG']['view_videos_more_videos_top']; ?>
</a>
                                </span>
                            </li>
                        </ul>
                        </div>
                        </div>
                        <div class="clsMoreVideosContent">
                            <div class="clsUserContent" id="relatedVideoContent">
                            </div>
                            <div class="clsDisplayNone clsLoaderImagePosition" id="loaderVideos" align="center">
                            <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/loader.gif" alt="<?php echo $this->_tpl_vars['LANG']['loading']; ?>
"/><?php echo $this->_tpl_vars['LANG']['loading']; ?>

                            </div>
                        </div>

                        <script type="text/javascript">
                        var subMenuClassName1='clsActiveMoreVideos';
                        var hoverElement1  = '.clsMoreVideosNav li';
						loadChangeClass(hoverElement1,subMenuClassName1);
                        </script>
                        <script type="text/javascript">
                        var relatedUrl="<?php echo $this->_tpl_vars['myobj']->relatedUrl; ?>
";
                        getRelatedVideo('tag');
						</script>
                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

         			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideodetails_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
														  <a id="anchor_video_response_block"></a>
				                     <div style="display:none;" id="selVideoResposeLinks" class="clsPopupViewVideo"></div>
                    <div id="slideShowBlock_anchor"></div>
                    <span id="loaderRespVideos" style="display:none">
                        <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/foxLoader.gif" alt="" title="" />
                    </span>
         			<div class="">
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideodetails_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <div class="clsOverflow">
                        <div class="clsViewVideoDetailsHeading clsVideVideoHeadingLeft">
                            <h3><?php echo $this->_tpl_vars['LANG']['video_responses_title']; ?>
</h3>
                        </div>
                        <div class="clsPostCommentHeading clsVideVideoHeadingRight">
                        <?php if (isLoggedIn ( )): ?>
                        	 <?php if ($this->_tpl_vars['myobj']->getFormField('allow_response') == 'Kinda' || $this->_tpl_vars['myobj']->getFormField('allow_response') == 'Yes'): ?>
                                <a class="clsButton2" onclick="postVideoResponse();" ><span><?php echo $this->_tpl_vars['LANG']['post_video_response']; ?>
</span></a>
                            <?php endif; ?>
                        <?php else: ?>
                             <a class="clsButton2" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['common_video_login_post_video_response_msg']; ?>
', '<?php echo $this->_tpl_vars['myobj']->notLoginVideoUrl; ?>
')"><span><?php echo $this->_tpl_vars['LANG']['post_video_response']; ?>
</span></a>
                        <?php endif; ?>

                        </div>

                     </div>

                        <?php if (isLoggedIn ( )): ?>
                        	 <?php if ($this->_tpl_vars['myobj']->getFormField('allow_response') == 'Kinda'): ?>
                               <div class="clsOverflow">
                        		<div class="clsPostCommentHeading clsVideVideoHeadingRight">(<?php echo $this->_tpl_vars['LANG']['approval']; ?>
)</div></div>
                            <?php endif; ?>
                        <?php endif; ?>

                    <div id="selUserContentResp" class="clsViewVideoDetailsResponse clsOverflow">
                        <?php echo $this->_tpl_vars['myobj']->populateVideoCommentsOfThisVideo(3); ?>

                    </div>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideodetails_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    </div>

					

				</div>
			</div>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideobottom_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        
    	<?php endif; ?>
    <?php endif; ?>
    </div>

<script type="text/javascript" language="javascript">

</script>
<?php echo '
<script language="javascript" type="text/javascript">
	function toggleVideoPostCommentOption(){
		$Jq("#selEditMainComments").toggle(\'slow\');
	}
	$Jq("#tabs").tabs();
</script>
'; ?>

<script>
<?php echo '
$Jq(\'#videoCaptionSummary\').jScrollPane({showArrows:true,scrollbarWidth:10, scrollbarMargin:10});
'; ?>

</script>

