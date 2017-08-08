<?php /* Smarty version 2.6.18, created on 2011-12-29 18:48:35
         compiled from viewMusic.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'viewMusic.tpl', 45, false),array('modifier', 'capitalize', 'viewMusic.tpl', 146, false),)), $this); ?>
<div class="clsViewAudioPage">
	<script type="text/javascript" language="javascript">
		var block_arr= new Array('selMsgCartSuccess');
	</script>

	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('confirmation_flagged_form')): ?>
        <div id="flaggedForm">
        <p><?php echo $this->_tpl_vars['LANG']['viewmusic_flagged_msg']; ?>
</p>
        <p><a href="<?php echo $this->_tpl_vars['myobj']->flaggedMusicUrl; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_flagged']; ?>
</a></p>
    </div>
        <?php elseif ($this->_tpl_vars['myobj']->isTrimmedMusic()): ?>
        <div class="clsTrimmedMusic">
        <h4><?php echo $this->_tpl_vars['myobj']->trimmendMessage; ?>
</h4>
    </div>
        <?php endif; ?>

    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('confirmation_adult_form')): ?>
        <div id="selAdultUserForm">
        <p><?php echo $this->_tpl_vars['myobj']->replaceAdultText($this->_tpl_vars['LANG']['confirmation_alert_text']); ?>
</p>
        <p><a href="<?php echo $this->_tpl_vars['myobj']->acceptAdultMusicUrl; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_accept']; ?>
</a>&nbsp;&nbsp;
        <a href="<?php echo $this->_tpl_vars['myobj']->acceptThisAdultMusicUrl; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_accept_this_page_only']; ?>
</a>&nbsp;&nbsp;
        <a href="<?php echo $this->_tpl_vars['myobj']->rejectAdultMusicUrl; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_reject']; ?>
</a>&nbsp;&nbsp;
        <a href="<?php echo $this->_tpl_vars['myobj']->rejectThisAdultMusicUrl; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_reject_this_page_only']; ?>
</a> </p>
    </div>
        <?php endif; ?>

	<div class="clsOverflow">
				<div class="clsViewAudioLeft">
    					<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_viewmusic_musicdetails')): ?>

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

			<!-- summary of the music start-->
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'summary_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<div class="clsMusicSummary">
            	<?php if ($this->_tpl_vars['myobj']->music_caption): ?>
				<p class="clsSummaryHead">
					<?php echo $this->_tpl_vars['LANG']['viewmusic_summary_music']; ?>
:
				</p>
				<div class="clsSummaryDescContainer">
                <p class="clsSummaryDesc" id="listenMusicSummary">
                    <?php if ($this->_tpl_vars['myobj']->music_caption): ?><?php echo $this->_tpl_vars['myobj']->music_caption; ?>
<?php else: ?>-<?php endif; ?>
                </p>
				</div>
                <?php else: ?>
                <p class="clsSummaryHead">
					<?php echo $this->_tpl_vars['LANG']['viewmusic_no_summary']; ?>

				</p>
                <?php endif; ?>
                <div class="clsSummaryCategory"><p class="clsSummaryGenere">
                    <?php echo $this->_tpl_vars['LANG']['music_genre_in']; ?>

                    <span>
                    	<a href="<?php echo $this->_tpl_vars['myobj']->musicList_category_url; ?>
"><?php echo $this->_tpl_vars['myobj']->statistics_music_genre; ?>
</a>
                    </span>
                </p></div>
                <p class="clsSummaryTags">
                    <?php echo $this->_tpl_vars['LANG']['viewmusic_music_tags']; ?>
:
                    <span>
                        <?php echo $this->_tpl_vars['myobj']->getMusicTagsLinks($this->_tpl_vars['myobj']->getFormField('music_tags'),3); ?>

                    </span>
                </p>
            </div>
			<div class="clsMusicUserDetail clsOverflow">
				<div class="clsMusicUserDetailImage">
					<a href="<?php echo $this->_tpl_vars['myobj']->music_user_details['profile_url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls45x45"><img src="<?php echo $this->_tpl_vars['myobj']->music_user_details['icon']['t_url']; ?>
" title="<?php echo $this->_tpl_vars['myobj']->music_user_details['user_name']; ?>
" alt="<?php echo $this->_tpl_vars['myobj']->music_user_details['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['myobj']->music_user_details['icon']['m_width'],$this->_tpl_vars['myobj']->music_user_details['icon']['m_height']); ?>
 /></a>
				</div>
				<div class="clsMusicUserDetailData">
					<ul class="clsOverflow">
                        <li>
                            <p class="clsViewMusicUsername"><span><?php echo $this->_tpl_vars['LANG']['viewmusic_by']; ?>
</span><a href="<?php echo $this->_tpl_vars['myobj']->music_user_details['profile_url']; ?>
"><?php echo $this->_tpl_vars['myobj']->music_user_details['user_name']; ?>
</a></p>
                        </li>
                        <li>
                            <p class="clsViewMusicDateAdded"><span><?php echo $this->_tpl_vars['LANG']['on_link']; ?>
</span> <?php echo $this->_tpl_vars['myobj']->getFormField('date_added'); ?>
</p>
                        </li>
					</ul>
					<p class="clsViewMusicByuser"><span><?php echo $this->_tpl_vars['LANG']['viewmusic_user_music']; ?>
: </span><a href="<?php echo $this->_tpl_vars['myobj']->music_user_details['total_musics_url']; ?>
"><?php echo $this->_tpl_vars['myobj']->music_user_details['total_musics']; ?>
</a></p>
				<?php if ($this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id'] && isMember ( )): ?>
				<p class="clsEditThisAudio"><a href="<?php echo $this->_tpl_vars['myobj']->edit_music_url; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_edit_music']; ?>
</a></p>
				<?php endif; ?>
				</div>
                
			</div>
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'summary_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <!-- summary of the music end-->

			<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_view_music_main')): ?>
            <!-- playlist, flag, addblog, lyrics  design starts-->
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'viewaudio_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<div class="clsCommonTabPopup">
            <div class="clsAudioLinksContainer">
            	<div class="clsViewAudioLinks" id="listenMusicTabs">
                	<ul class="clsOverflow">
                        <li class="clsFirstLink"><a href="#listenMusicPlaylist"><span><?php echo $this->_tpl_vars['LANG']['viewmusic_playlist']; ?>
</span></a></li>
                        <li><a href="#listenMusicFlag"><span><?php echo $this->_tpl_vars['LANG']['viewmusic_flag']; ?>
</span></a></li>
                        <?php if ($this->_tpl_vars['myobj']->getFormField('allow_lyrics') == 'Yes'): ?>
                        <li><a href="#listenMusicBlog"><span><?php echo $this->_tpl_vars['LANG']['viewmusic_add_blog']; ?>
</span></a></li>
                        <li class="clsLastLink"><a href="#listenMusicLyrics"><span><?php echo $this->_tpl_vars['LANG']['viewmusic_lyrics']; ?>
</span></a></li>
                        <?php else: ?>
                        <li class="clsLastLink"><a href="#listenMusicBlog"><span><?php echo $this->_tpl_vars['LANG']['viewmusic_add_blog']; ?>
</span></a></li>
                        <?php endif; ?>
		            </ul>
                    <?php echo $this->_tpl_vars['myobj']->populatePlaylist(); ?>

                    <?php echo $this->_tpl_vars['myobj']->populateFlagContent(); ?>

                    <?php echo $this->_tpl_vars['myobj']->populateBlogContent(); ?>

                    <?php if ($this->_tpl_vars['myobj']->getFormField('allow_lyrics') == 'Yes'): ?>
                    <?php echo $this->_tpl_vars['myobj']->populateLyricsContent(); ?>

                    <?php endif; ?>
        		</div>
                <script type="text/javascript">$Jq("#listenMusicTabs").tabs();</script>
            </div>
			</div>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'viewaudio_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <!-- playlist, flag, addblog, lyrics  design ends-->
            <?php endif; ?>

            			<div class="clsOverflow clsMoreShareOptions">
				<ul>
                    <li id="selHeaderSharemusic" class="clsMusicShare">
                        <a class="shareaudio" onclick="showShareDiv('<?php echo $this->_tpl_vars['myobj']->share_url; ?>
')">
                            <span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['viewmusic_share_music'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</span>
                        </a>
                    </li>
                    <?php if ($this->_tpl_vars['myobj']->isMember): ?>
                    <li class="clsMusicFeatured" id='unfeatured' <?php if (! $this->_tpl_vars['myobj']->featured['added']): ?> style="display:none"<?php endif; ?>>
                        <a class="featured"  href="javascript:void(0);" onclick="getViewMusicMoreContent('Featured', 'remove');"><span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['viewmusic_featured'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</span></a>
                    </li>
                    <li class="clsMusicFeatured" id="featured" <?php if ($this->_tpl_vars['myobj']->featured['added']): ?> style="display:none"<?php endif; ?>>
                        <a class="feature" href="javascript:void(0);" onclick="getViewMusicMoreContent('Featured');"><span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['viewmusic_feature'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</span></a>
                    </li>
                    <?php else: ?>
                    	<li id="selHeaderFeatured" class="clsMusicFeatured"  ><a class="favorited" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_featured_err_msg']; ?>
', '<?php echo $this->_tpl_vars['myobj']->memberviewMusicUrl; ?>
')"><span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['feature'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</span></a></li>
                	<?php endif; ?>
                    <li  class="clsMusicFeatured" id="featured_saving" style="display:none">
                       <a class="featured"><span><?php echo $this->_tpl_vars['LANG']['viewmusic_saving']; ?>
</span></a>
                    </li>
             		<?php if ($this->_tpl_vars['myobj']->isMember): ?>
                    <li class="clsMusicfavorite" id='favorite' <?php if ($this->_tpl_vars['myobj']->favorite['added']): ?> style="display:none"<?php endif; ?>>
                       <a class="favorites" onclick="getViewMusicMoreContent('Favorites');"> <span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['viewmusic_favorites'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</span></a>
                    </li>
                    <li  class="clsMusicfavorite" id="unfavorite" <?php if (! $this->_tpl_vars['myobj']->favorite['added']): ?> style="display:none"<?php endif; ?>>
                       <a class="favorited" onclick="getViewMusicMoreContent('Favorites', 'remove');"><span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['viewmusic_favorited'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</span></a>
                    </li>
                    <?php else: ?>
                    	<li id='favorite' class="clsMusicfavorite"><a class="favourites" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_favorite_err_msg']; ?>
', '<?php echo $this->_tpl_vars['myobj']->memberviewMusicUrl; ?>
')"><span><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['favorites'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</span></a></li>
                	<?php endif; ?>

                  <li  class="clsMusicfavorite" id="favorite_saving" style="display:none">
                       <a class="favorited"><span><?php echo $this->_tpl_vars['LANG']['viewmusic_saving']; ?>
</span></a>
                  </li>
                </ul>
            </div>
            <div id="shareDiv" class="clsPopupConfirmation" style="display:none">
                <br />&nbsp;
            </div>
						<?php endif; ?>



        </div>
        


		<?php if ($this->_tpl_vars['CFG']['admin']['musics']['download_option'] && $this->_tpl_vars['myobj']->checkDownloadOption()): ?>
        <div id="downloadFormat" style="display:none;">

            <div class="clsIndexAudioHeading">
                <h3><?php echo $this->_tpl_vars['LANG']['viewmusic_downloads_formats']; ?>
</h3>
                <div class="clsHeadingClose">

                </div>
            </div>
            <div class="clsOverflow clsPopupContainer">
                <ul>
                <li><a href="<?php echo $this->_tpl_vars['myobj']->musicDownloadUrl; ?>
"><?php echo $this->_tpl_vars['LANG']['mp3']; ?>
 (<?php echo $this->_tpl_vars['myobj']->getFormField('total_downloads'); ?>
 <?php echo $this->_tpl_vars['LANG']['viewmusic_downloads']; ?>
) </a></li>
                <!--
                    commented this in version 1.1.4 for checking in detail the count
                    <?php if ($this->_tpl_vars['CFG']['admin']['musics']['save_original_file_to_download'] && $this->_tpl_vars['myobj']->getFormField('music_ext') != 'mp3'): ?>
                        <?php echo $this->_tpl_vars['myobj']->populateOriginalFormatDownloadLink(); ?>

                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['CFG']['admin']['musics']['music_other_formats_enabled'] && ! $this->_tpl_vars['myobj']->getFormField('music_server_url')): ?>
                        <?php echo $this->_tpl_vars['myobj']->populateOtherFormatDownloadLink(); ?>

                    <?php endif; ?> -->
                </ul>
                <p class="clsDownloadNote"><?php echo $this->_tpl_vars['LANG']['viewmusic_savetarget']; ?>
</p>
            </div>

        </div>
        <?php endif; ?>


      	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_view_music_player')): ?>
                    <div class="clsViewAudioRight">

                      			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'playlist_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        <div class="clsFeaturedPlaylistContainer clsSinglePlayerContainer">
							<div class="clsOverflow">
                            <h3 class="clsFloatLeft"><?php echo $this->_tpl_vars['myobj']->music_title; ?>
</h3>
                        	                            <div class="clsFloatRight clsListenRating">
                            <?php if ($this->_tpl_vars['myobj']->chkAllowRating()): ?>
                              <div id="ratingForm">
                               <?php $this->assign('tooltip', ""); ?>
                               <?php if (! isLoggedIn ( )): ?>
                               <?php $this->assign('tooltip', $this->_tpl_vars['LANG']['viewmusic_login_message']); ?>
                               <?php elseif (! ( isMember ( ) && $this->_tpl_vars['myobj']->rankUsersRayzz )): ?>
                               <?php $this->assign('tooltip', $this->_tpl_vars['LANG']['viewmusic_rate_yourself']); ?>
                               <?php endif; ?>
                               <?php if (! isLoggedIn ( )): ?>
                                     <?php echo $this->_tpl_vars['myobj']->populateMusicRatingImages($this->_tpl_vars['myobj']->music_rating,'player',$this->_tpl_vars['LANG']['viewmusic_login_message'],$this->_tpl_vars['myobj']->memberviewMusicUrl,'music'); ?>

                               <?php else: ?>
                                  <div id="selRatingMusic">
                                      <?php if (isMember ( ) && $this->_tpl_vars['myobj']->rankUsersRayzz): ?>
                                              <?php echo $this->_tpl_vars['myobj']->populateRatingImagesForAjax($this->_tpl_vars['myobj']->music_rating,'audio'); ?>

                                      <?php else: ?>
                                          <?php echo $this->_tpl_vars['myobj']->populateMusicRatingImages($this->_tpl_vars['myobj']->music_rating,'player',$this->_tpl_vars['LANG']['viewmusic_rate_yourself'],'#','music'); ?>

                                      <?php endif; ?>
                                     <span> (<?php echo $this->_tpl_vars['myobj']->getFormField('rating_count'); ?>
 <?php if ($this->_tpl_vars['myobj']->getFormField('rating_count') > 1): ?><?php echo $this->_tpl_vars['LANG']['viewmusic_total_ratings']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['viewmusic_total_rating']; ?>
<?php endif; ?>)</span>
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
							</div>
                            <div class="clsPlayerContainer">
                                                            		<?php echo $this->_tpl_vars['myobj']->populateSinglePlayer($this->_tpl_vars['music_fields']); ?>

                                                          </div>
							<div class="clsPlayerEmbed">
								<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

								<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'embed_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
								<div class="clsEmbedTop clsOverflow">
									<div class="clsEmbedCountDetails clsOverflow">
										<ul>
											<li>
												<span class="clsEmbedCountName"><?php echo $this->_tpl_vars['LANG']['viewmusic_downloads_label']; ?>
:</span>
												<span class="clsEmbedCountvalueLeft"><span class="clsEmbedCountvalueRight"><?php echo $this->_tpl_vars['myobj']->getFormField('total_downloads'); ?>
</span></span>
											</li>
											<li>
												<span class="clsEmbedCountName"><?php echo $this->_tpl_vars['LANG']['viewmusic_total_comments']; ?>
:</span>
												<span class="clsEmbedCountvalueLeft"><span class="clsEmbedCountvalueRight"><?php echo $this->_tpl_vars['myobj']->getFormField('total_comments'); ?>
</span></span>
											</li>
											<li>
												<span class="clsEmbedCountName"><?php echo $this->_tpl_vars['LANG']['viewmusic_total_favourites']; ?>
:</span>
												<span class="clsEmbedCountvalueLeft"><span class="clsEmbedCountvalueRight"><?php echo $this->_tpl_vars['myobj']->getFormField('total_favorites'); ?>
</span></span>
											</li>
										</ul>
									</div>
									<div class="clsTrackDownload">
										<span class="clsPlayingTime"><?php echo $this->_tpl_vars['LANG']['viewmusic_playing_time']; ?>
: <span><?php echo $this->_tpl_vars['myobj']->getFormField('cur_mid_play_time'); ?>
</span></span>
                                        <?php if ($this->_tpl_vars['CFG']['admin']['musics']['download_option']): ?>
                                        <a id="anchor_music_download_block"></a>
										<!--music download <span class="clsDownloadTrackLeft"><span class="clsDownloadTrackRight"><a onclick="return Confirmation('downloadFormat', '', Array(), Array(), Array(), 50, 190, 'anchor_music_download_block')"><?php echo $this->_tpl_vars['LANG']['viewmusic_download']; ?>
</a></span></span>-->
                                        <?php endif; ?>
									</div>
								</div>
								<div class="clsEmbedBottom clsOverflow">
									<p class="clsMusicurl">
										<input name="" type="text"  value="<?php echo $this->_tpl_vars['myobj']->view_music_embed_url; ?>
" onfocus="this.select()" onclick="this.select()" readonly="readonly" />
									</p>
                                    <?php if ($this->_tpl_vars['myobj']->allow_embed == 'Yes'): ?>
									<p class="clsEmbedurl">
										<input name="" value="<?php echo $this->_tpl_vars['myobj']->embeded_code; ?>
" type="text" onfocus="this.select()" onclick="this.select()"/>
									</p>
                                    <?php endif; ?>
								</div>
								<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

								<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'embed_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
							</div>
                        </div>
				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'playlist_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                       		<?php endif; ?>


        </div>
            </div>

	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'viewaudiobottom_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="clsOverflow">

        <div class="clsViewAudioComment">
                        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('music_comments_block')): ?>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div class="clsAudioCommentsContainer">
                <div class="clsCommentsHeadingContainer">
                    <div class="clsIndexAudioHeading"><h3><?php echo $this->_tpl_vars['LANG']['viewmusic_comments_label']; ?>
&nbsp;(<span id="selMusicCommentsCount"><?php echo $this->_tpl_vars['myobj']->getFormField('total_comments'); ?>
</span>)</h3></div>
                    <div class="clsComments">
                        <?php if ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda' || $this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Yes'): ?>
                            <?php if (isMember ( )): ?>
							<div class="clsOverflow">
                                <span id="selViewPostComment" class="clsViewPostComment">
                                    <a href="#" title="<?php echo $this->_tpl_vars['LANG']['viewmusic_post_comments_label']; ?>
" id="add_comment" onclick="toggleMusicPostCommentOption(); return false;"><?php echo $this->_tpl_vars['LANG']['viewmusic_post_comments_label']; ?>
</a>
                              	</span>
								</div>
                              	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "addComments.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                            <?php else: ?>
							<div class="clsOverflow">
                                <span id="selViewPostComment" class="clsViewPostComment">
                                    <a title="<?php echo $this->_tpl_vars['LANG']['viewmusic_post_comments_label']; ?>
" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_comment_post_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->memberviewMusicUrl; ?>
');return false;">
                                        <?php echo $this->_tpl_vars['LANG']['viewmusic_post_comments_label']; ?>
 <?php if ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda'): ?>(<?php echo $this->_tpl_vars['LANG']['approval']; ?>
)<?php endif; ?>
                                    </a>
                                </span>
								</div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda' && $this->_tpl_vars['myobj']->getFormField('user_id') != $this->_tpl_vars['CFG']['user']['user_id']): ?><div class="clsApprovalRequired">(<?php echo $this->_tpl_vars['LANG']['approval']; ?>
)</div><?php endif; ?>
                <?php echo $this->_tpl_vars['myobj']->populateCommentOptionsMusic(); ?>

                <div id="selMsgSuccess" style="display:none">
                    <p id="kindaSelMsgSuccess"></p>
                </div>
                <div id="deleteCommentSuccessMsgBlock" style="display:none" class="clsSuccessMessage">
                    <p id="deleteCommentSuccessMsg"></p>
                </div>
                <div id="selCommentBlock" class="clsViewVideoDetailsContent">
                    <?php echo $this->_tpl_vars['myobj']->populateCommentOfThisMusic(); ?>

                </div>
            </div>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
                    </div>


        <div class="clsViewAudioMoreVideo">
            <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_view_music_more_musics')): ?>
                        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php $this->assign('more_music_limit', 15); ?>
            <div class="clsIndexMoreAudioContainer">
                <div class="clsIndexAudioHeading clsOverflow">
                    <h3 class="clsViewaudioMoreMusicLeft"><?php echo $this->_tpl_vars['LANG']['viewmusic_more_audios_label']; ?>
</h3>
                    <div class="clsAudioListMenu clsViewaudioMoreMusicRight">
                        <ul>
                            <li id="selHeaderMusicUser">
                                    <a onclick="getRelatedMusic('user');"><span><?php echo $this->_tpl_vars['LANG']['viewmusic_user_label']; ?>
</span></a>
                            </li>
                            <li id="selHeaderMusicRel">
                                    <a onclick="getRelatedMusic('tag')"><span><?php echo $this->_tpl_vars['LANG']['viewmusic_related_label']; ?>
</span></a>
                            </li>
                            <li id="selHeaderMusicTop">
                                    <a onclick="getRelatedMusic('top')"><span><?php echo $this->_tpl_vars['LANG']['viewmusic_top_label']; ?>
</span></a>
                            </li>
                                                        <?php if (! $this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature']): ?>
                            <li id="selHeaderMusicArtist">
                                    <a onclick="getRelatedMusic('artist')"><span><?php echo $this->_tpl_vars['LANG']['viewmusic_artist_label']; ?>
</span></a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div id="selNextPrev_top" class="clsAudioCarouselPaging">
                    </div>
                </div>

                <div class="clsSideCaroselContainer clsJQMoreMusic">
					<div class="clsDisplayNone" id="loaderMusics" align="center">
                        <div class="clsLoader">
                            <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/loader.gif" alt="<?php echo $this->_tpl_vars['LANG']['viewmusic_loading']; ?>
"/><?php echo $this->_tpl_vars['LANG']['viewmusic_loading']; ?>

                        </div>
                    </div>
                    <div  id="relatedMusicContent" >

					</div>

                </div>
            </div>
            <script type="text/javascript">
                var subMenuClassName1='clsActiveMoreMusics';
                var hoverElement1  = '.clsMoreMusicNav li';
                loadChangeClass(hoverElement1,subMenuClassName1);
                var relatedUrl="<?php echo $this->_tpl_vars['myobj']->relatedUrl; ?>
";
                getRelatedMusic('tag');
            </script>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        <?php endif; ?>


                        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_view_music_people_listened')): ?>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div class="clsPepoleListingAudioContainer">
                <div class="clsIndexAudioHeading">
                    <h3><?php echo $this->_tpl_vars['LANG']['viewmusic_people_listened_heading']; ?>
</h3>
                    <div id="people_listened_Head" class="clsAudioCarouselPaging"  >
                    </div>
                </div>
                <div class="clsSideCaroselContainer">
                    <div id="people_listened_content">
                    </div>
                    <div class="clsDisplayNone" id="loaderListenedMusics" align="center">
                        <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/loader.gif" alt="<?php echo $this->_tpl_vars['LANG']['viewmusic_loading']; ?>
"/><?php echo $this->_tpl_vars['LANG']['viewmusic_loading']; ?>

                    </div>
                </div>
                <script type="text/javascript">
                    var subMenuClassName1='clsActiveMoreVideos';
                    var hoverElement1  = '.clsMoreMusicNav li';
                    loadChangeClass(hoverElement1,subMenuClassName1);
					var listenedUrl="<?php echo $this->_tpl_vars['myobj']->relatedUrl; ?>
";
					getPeopleListenedMusic('');
                </script>
            </div>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
            
		</div>


	</div>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'viewaudiobottom_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<?php echo '
<script language="javascript" type="text/javascript">
	$Jq(document).ready(function(){
		$Jq(\'#listenMusicSummary\').jScrollPane({showArrows:true, scrollbarWidth:15});
	});
	function toggleMusicPostCommentOption(){
		$Jq("#selEditMainComments").toggle(\'slow\');
	}
</script>
'; ?>