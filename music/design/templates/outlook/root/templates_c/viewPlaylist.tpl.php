<?php /* Smarty version 2.6.18, created on 2012-01-31 23:18:31
         compiled from viewPlaylist.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'viewPlaylist.tpl', 12, false),)), $this); ?>
<div id="selViewLyrics">
    <!-- information div -->
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

    	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	 <!-- Multi confirmation box -->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
		  <table summary="<?php echo $this->_tpl_vars['LANG']['viewplaylist_confirm_tbl_summary']; ?>
">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
						&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks('selFormForums');" />
					  <input type="hidden" name="song_id" id="song_id" />
                        <input type="hidden" name="playlist_id" id="playlist_id" />
						<input type="hidden" name="action" id="action" />

											</td>
				</tr>
		  </table>
		</form>
	</div>
    <!-- confirmation box-->
    <div class="clsViewPlaylistLeftContent clsViewPlaylistRightBlock">
    <!-- PLAYLIST INFORMATION BLOCK START-->
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('playlist_information_block')): ?>

                	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'box_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div class="clsOverflow">
            	<div class="clsInformationLeft">
                <div class="clsMultipleImage" title="<?php echo $this->_tpl_vars['myobj']->page_title; ?>
">
                        <?php if ($this->_tpl_vars['playlistInformation']['getPlaylistImageDetail']['total_record'] > 0): ?>
                            <?php $_from = $this->_tpl_vars['playlistInformation']['getPlaylistImageDetail']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['playlistImageDetailKey'] => $this->_tpl_vars['playlistImageDetailValue']):
?>
                               <table><tr><td><img src="<?php echo $this->_tpl_vars['playlistImageDetailValue']['playlist_path']; ?>
"/></td></tr></table>
                            <?php endforeach; endif; unset($_from); ?>
                            <?php if ($this->_tpl_vars['playlistInformation']['getPlaylistImageDetail']['total_record'] < 4): ?>
                                <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['playlistInformation']['getPlaylistImageDetail']['noimageCount']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
                                    <table><tr><td><img  width="65" height="44" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_S.jpg" /></td></tr></table>
                                <?php endfor; endif; ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="clsSingleImage"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_T.jpg" /></div>
                        <?php endif; ?>
                </div>
                </div>
                <div class="clsInformationRight">
                    <p class="clsInformationTitle"><?php echo $this->_tpl_vars['myobj']->page_title; ?>
</p>
                    <p class="clsByName"><?php echo $this->_tpl_vars['LANG']['viewplaylist_post_by_label']; ?>
: <a href="<?php echo $this->_tpl_vars['playlistInformation']['playlist_owner_url']; ?>
" title="<?php echo $this->_tpl_vars['playlistInformation']['user_name']; ?>
" alt="<?php echo $this->_tpl_vars['playlistInformation']['user_name']; ?>
"><?php echo $this->_tpl_vars['playlistInformation']['user_name']; ?>
</a></p>
                    <div class="clsInformationRating">
                        						<?php if ($this->_tpl_vars['playlistInformation']['total_tracks'] > 0): ?>
                            <?php if ($this->_tpl_vars['playlistInformation']['allow_ratings'] == 'Yes'): ?>
                                <div id="ratingForm">
                                    <p class="clsRateThisHd"><?php echo $this->_tpl_vars['LANG']['viewplaylist_rate_this_label']; ?>
:  </p>
                                    <?php $this->assign('tooltip', ""); ?>
                                    <?php if (! isLoggedIn ( )): ?>
                                    <?php $this->assign('tooltip', $this->_tpl_vars['LANG']['viewplaylist_login_message']); ?>                               
                                    <?php elseif (! ( isMember ( ) && $this->_tpl_vars['playlistInformation']['rankUsersRayzz'] )): ?>
                                    <?php $this->assign('tooltip', $this->_tpl_vars['LANG']['viewplaylist_rate_yourself']); ?>
                                    <?php endif; ?>
                                    <?php if (! isLoggedIn ( )): ?>
                                    	<?php echo $this->_tpl_vars['myobj']->populateMusicRatingImages($this->_tpl_vars['playlistInformation']['rating'],'player',$this->_tpl_vars['LANG']['viewplaylist_login_message'],$this->_tpl_vars['myobj']->is_not_member_url,'music'); ?>

                                    <?php else: ?>
                                        <div id="selRatingPlaylist">
                                            <?php if (isMember ( ) && $this->_tpl_vars['playlistInformation']['rankUsersRayzz']): ?>
                                                <?php if ($this->_tpl_vars['playlistInformation']['rating']): ?>
                                                    <?php echo $this->_tpl_vars['myobj']->populateRatingImagesForAjax($this->_tpl_vars['playlistInformation']['rating'],'audio'); ?>

                                                <?php else: ?>
                                                    <?php echo $this->_tpl_vars['myobj']->populateRatingImagesForAjax($this->_tpl_vars['playlistInformation']['rating'],'audio'); ?>

                                                <?php endif; ?>
                                            <?php else: ?>
                                            	<?php echo $this->_tpl_vars['myobj']->populateMusicRatingImages($this->_tpl_vars['playlistInformation']['rating'],'player',$this->_tpl_vars['LANG']['viewplaylist_rate_yourself'],'#','music'); ?>

                                            <?php endif; ?>
                                            <span> (<?php echo $this->_tpl_vars['myobj']->getFormField('rating_count'); ?>
 <?php echo $this->_tpl_vars['LANG']['viewplaylist_rating']; ?>
)</span>
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
                        <?php endif; ?>
                     </div>
                </div>
             </div>
        	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'box_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        		
               	    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>
	
        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            	<div class="clsStatisticsContainer">
                    <h3 class="clsH3Heading"><?php echo $this->_tpl_vars['LANG']['viewplaylist_statistics_label']; ?>
</h3>
                    <div class="clsOverflow clsStatisticsTable">
                        <div class="clsStatisticsLeftLinks">
                        	<table>
                                <tr><td class="clsLabel"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_plays_label']; ?>
</span></td> <td>: <?php echo $this->_tpl_vars['playlistInformation']['total_palys']; ?>
</td></tr>
                                <tr><td class="clsLabel"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_views_label']; ?>
</span></td> <td>: <?php echo $this->_tpl_vars['playlistInformation']['total_views']; ?>
</td></tr>
                                <tr><td class="clsLabel"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_create_date_label']; ?>
</span></td><td>: <?php echo $this->_tpl_vars['playlistInformation']['date_added']; ?>
</td></tr>
                            </table>
                        </div>
                        <div class="clsStatisticsRightLinks">
                        	<table>
                                <tr><td class="clsLabel"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_last_played_label']; ?>
</span></td> <td>: <?php echo $this->_tpl_vars['playlistInformation']['last_viewed_date']; ?>
</td></tr>
                                <tr><td class="clsLabel"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_tracks_label']; ?>
</span></td> <td>: <?php echo $this->_tpl_vars['playlistInformation']['total_tracks']; ?>
 <?php if ($this->_tpl_vars['playlistInformation']['private_song'] > 0): ?>(<?php echo $this->_tpl_vars['playlistInformation']['private_song']; ?>
 <?php echo $this->_tpl_vars['LANG']['viewplaylist_private_label']; ?>
)<?php endif; ?></td></tr>
                                <tr><td class="clsLabel"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_comments_label']; ?>
</span></td> <td>: <?php echo $this->_tpl_vars['playlistInformation']['total_comments']; ?>
</td></tr>
                            </table>
                        </div>
                    </div>
                    <div class="clsTagsTable">
                        <table>
                            <tr>
                                <td class="clsLabel"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_tags_label']; ?>
</span></td>
                                <td>: <?php echo $this->_tpl_vars['myobj']->getTagsLinkForPlaylist($this->_tpl_vars['playlistInformation']['playlist_tags'],3,$this->_tpl_vars['playlistInformation']['playlist_id']); ?>
</td>
                            </tr>
                        </table>
                    </div>
                    <?php if ($this->_tpl_vars['playlistInformation']['allow_embed'] == 'Yes' && $this->_tpl_vars['playlistInformation']['total_tracks'] > 0): ?>
                        <div class="clsUrlTextBox clsPlaylistUrlTextBox">
                            <span><?php echo $this->_tpl_vars['LANG']['viewplaylist_url_label']; ?>
 </span>
                            <input type="text" value="<?php echo $this->_tpl_vars['myobj']->embeded_code; ?>
"
                            onclick="this.select()" onfocus="this.select()" readonly="" id="playlist_url" name="playlist_url" class=""/>
                        </div>
                    <?php endif; ?>
                    <div class="clsPlaylistDescriptionBox">
                            <p><strong><?php echo $this->_tpl_vars['LANG']['viewplaylist_description_label']; ?>
</strong> </p>
                            <p><?php echo $this->_tpl_vars['playlistInformation']['playlist_description']; ?>
</p>
                    </div>
                </div>
       		 <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

      	  	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
    <!-- PLAYLIST INFORMATION BLOCK END-->
    
    
	<!-- PLAYLIST FEATURES BLOCK STARTS -->
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('playlist_features_block')): ?>
                <div class="clsOverflow clsMoreShareOptions">
            <ul>
                <li class="clsMusicShare">
                    <a class="shareaudio" onclick="showShareDiv('<?php echo $this->_tpl_vars['myobj']->shareUrl; ?>
')"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_share_musicplaylist_label']; ?>
</span></a>
                </li>
                <?php if (isMember ( )): ?>                                        
                <li class="clsMusicFeatured" id='unfeatured' <?php if (! $this->_tpl_vars['myobj']->chkPlaylistFeatured()): ?> style="display:none" <?php endif; ?>>
                    <a class="featured"  href="javascript:void(0);" onclick="ajaxUpdatePlaylist('?ajax_page=true&amp;page=featured&playlist_id=<?php echo $this->_tpl_vars['playlistInformation']['playlist_id']; ?>
&featured=0', 'unfeatured')"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_featured_label']; ?>
</span></a>
                </li>
                <li class="clsMusicFeatured" id="featured" <?php if ($this->_tpl_vars['myobj']->chkPlaylistFeatured()): ?> style="display:none" <?php endif; ?>>
                    <a class="feature" href="javascript:void(0);" onclick="ajaxUpdatePlaylist('?ajax_page=true&amp;page=featured&playlist_id=<?php echo $this->_tpl_vars['playlistInformation']['playlist_id']; ?>
&featured=1', 'featured')"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_feature_label']; ?>
</span></a>
                </li>
                <li  class="clsMusicFeatured" id="featured_saving" style="display:none">
                   <a class="featured"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_saving_label']; ?>
</span></a>
                </li>
                <li class="clsMusicfavorite" id='favorite' <?php if ($this->_tpl_vars['myobj']->chkPlaylistFavorite()): ?> style="display:none" <?php endif; ?>}>
                   <a class="favorites" onclick="ajaxUpdatePlaylist('?ajax_page=true&amp;page=favorite&playlist_id=<?php echo $this->_tpl_vars['playlistInformation']['playlist_id']; ?>
&favorite=1', 'favorite')"> <span><?php echo $this->_tpl_vars['LANG']['viewplaylist_favorites_label']; ?>
</span></a>
                </li>
                <li  class="clsMusicfavorite" id="unfavorite" <?php if (! $this->_tpl_vars['myobj']->chkPlaylistFavorite()): ?> style="display:none" <?php endif; ?>}>
                   <a class="favorited" onclick="ajaxUpdatePlaylist('?ajax_page=true&amp;page=favorite&playlist_id=<?php echo $this->_tpl_vars['playlistInformation']['playlist_id']; ?>
&favorite=0', 'unfavorite')"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_favorited_label']; ?>
</span></a>
                </li>
                <li  class="clsMusicfavorite" id="favorite_saving" style="display:none">
                   <a class="favorited"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_saving_label']; ?>
</span></a>
                </li>
                <?php else: ?>
                <li id="selHeaderFeatured" class="clsMusicFeatured">
                	<a class="feature" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['playlist_login_featured_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->is_not_member_url; ?>
');return false;"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_feature_label']; ?>
</span></a>                    
                </li>
                <li id='favorite' class="clsMusicfavorite">
                    <a class="favorite" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['playlist_login_favorite_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->is_not_member_url; ?>
');return false;"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_favorites_label']; ?>
</span></a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <div id="shareDiv" class="clsPopupConfirmation" style="display:none">
            <br />&nbsp;
        </div>
          	<?php endif; ?>
	<!-- PLAYLIST FEATURES BLOCK ENDS -->

    <!-- PLAYLIST COMMENT BLOCK START -->
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('playlist_comments_block')): ?>    
    
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div class="clsAudioCommentsContainer clsSideBarComments">
    	
            	<div class="clsCommentsHeadingContainer">
        	<h3 class="clsH3Heading"><?php echo $this->_tpl_vars['LANG']['viewplaylist_comments_label']; ?>
</h3>
            <div class="clsComments">
            	<?php if ($this->_tpl_vars['playlistInformation']['allow_comments'] == 'Kinda' || $this->_tpl_vars['playlistInformation']['allow_comments'] == 'Yes'): ?>
                	
                    <?php if (isMember ( )): ?>
                    <div class="clsOverflow">
                    	<span id="selViewPostComment" class="clsViewPostComment">
                        	<a href="javascript:void(0);" title="<?php echo $this->_tpl_vars['LANG']['viewplaylist_post_comments_label']; ?>
" id="add_comment" onclick="toggleMusicPostCommentOption(); return false;"><?php echo $this->_tpl_vars['LANG']['viewplaylist_post_comments_label']; ?>
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
                            <a title="<?php echo $this->_tpl_vars['LANG']['viewplaylist_post_comments_label']; ?>
" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_comment_post_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->commentUrl; ?>
');return false;">
                            <?php echo $this->_tpl_vars['LANG']['viewplaylist_post_comments_label']; ?>

                            </a>
                        </span>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
                
        
        
                            <?php if ($this->_tpl_vars['playlistInformation']['allow_comments'] == 'Kinda' || $this->_tpl_vars['playlistInformation']['allow_comments'] == 'Yes'): ?>
                                <?php if (isMember ( )): ?>
								<div class="clsOverflow">
                                    <p class="clsApprovalRequired" id="selViewPostComment">
                                        <?php if ($this->_tpl_vars['playlistInformation']['allow_comments'] == 'Kinda' && $this->_tpl_vars['myobj']->getFormField('user_id') != $this->_tpl_vars['CFG']['user']['user_id']): ?>(<?php echo $this->_tpl_vars['LANG']['approval']; ?>
)<?php endif; ?>
                                    </p>
									</div>
                                <?php else: ?>
								<div class="clsOverflow">
                                    <p class="clsApprovalRequired" id="selViewPostComment">
                                        <?php if ($this->_tpl_vars['playlistInformation']['allow_comments'] == 'Kinda'): ?>(<?php echo $this->_tpl_vars['LANG']['approval']; ?>
)<?php endif; ?>
                                    </p>
									</div>
                                <?php endif; ?>
                            <?php endif; ?>
                    <?php echo $this->_tpl_vars['myobj']->populateCommentOptionsPlaylist(); ?>

                    <div id="selMsgSuccess" style="display:none">
                        <p id="kindaSelMsgSuccess"></p>
                    </div>
                    <div id="selCommentBlock" class="clsViewVideoDetailsContent">
                        <?php echo $this->_tpl_vars['myobj']->populateCommentOfThisPlaylist(); ?>

                    </div>
                </div>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
    <!-- PLAYLIST COMMENT BLOCK END -->

    </div>

    <div class="clsViewPlaylistRightContent clsViewPlaylistLeftBlock">

	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_playlist_player')): ?>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'playlist_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div class="clsFeaturedPlaylistContainer">
            	<h3><?php echo $this->_tpl_vars['myobj']->page_title; ?>
</h3>
                <div class="clsAudioPlayer clsPlaylistPlayer">
					<?php echo $this->_tpl_vars['myobj']->populatePlayerWithPlaylist($this->_tpl_vars['music_fields']); ?>

                </div>
            </div>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'playlist_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>

    
    <!-- PLAYLIST SONG LIST BLOCK START -->
      <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('playlist_songlist_block')): ?>
            	    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div class="clsIndexAudioHeading">
            <h3 class="clsH3Heading">
                <?php echo $this->_tpl_vars['LANG']['viewplaylist_tracks_list_label']; ?>

            </h3>
            <!--<div id="playlistSongs_Head" class="clsAudioCarouselPaging"  style="display:none" >
            </div>-->
            </div>
            <?php echo $this->_tpl_vars['myobj']->populatePlaylist(); ?>

            <div id="playlistInSongList">
            </div>
            <div  id="loaderMusics" style="display:none">
            	<div class="clsLoader">
                <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/loader.gif" alt="<?php echo $this->_tpl_vars['LANG']['viewplaylist_loading']; ?>
"/><?php echo $this->_tpl_vars['LANG']['viewplaylist_loading']; ?>

          		</div>
            </div>
            <?php echo '
                <script language="javascript" type="text/javascript">
                function redirect(url)
                    {
                        window.location = url;
                    }
				var relatedUrl="'; ?>
<?php echo $this->_tpl_vars['myobj']->relatedUrl; ?>
<?php echo '";
                musicPlaylistAjaxPaging(\'?ajax_page=true&page=pagenation&playlist_id='; ?>
<?php echo $this->_tpl_vars['playlistInformation']['playlist_id']; ?>
<?php echo '&user_id='; ?>
<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
<?php echo '\', \'\');
			    </script>
            '; ?>

            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

        		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
              <?php endif; ?>
    <!-- PLAYLIST SONG LIST BLOCK END -->
    </div>
<script type="text/javascript">
	<?php echo '
	function toggleMusicPostCommentOption(){
		$Jq("#selEditMainComments").toggle(\'slow\');
	}
	'; ?>

</script>
</div>