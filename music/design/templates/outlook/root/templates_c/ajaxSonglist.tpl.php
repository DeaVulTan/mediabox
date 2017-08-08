<?php /* Smarty version 2.6.18, created on 2012-01-31 23:18:32
         compiled from ajaxSonglist.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'ajaxSonglist.tpl', 5, false),array('modifier', 'truncate', 'ajaxSonglist.tpl', 36, false),)), $this); ?>
    <div class="clsViewPlayListPageContainer">
		<?php if ($this->_tpl_vars['myobj']->total_records): ?>
            <form id="playlistManage" name="playlistManage" method="post" action="">
                    <div class="clsSelectAllLinks clsOverflow">
                        <p class="clsListCheckBox"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="CheckAll(document.playlistManage.name, document.playlistManage.check_all.name)"/> </p>


                <input  type="hidden" name="start" id="start" value="<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
" />
                <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" name="add" id="add" value="<?php echo $this->_tpl_vars['LANG']['viewplaylist_add_label']; ?>
" onclick="getMultiCheckBoxValue('playlistManage', 'check_all', '<?php echo $this->_tpl_vars['LANG']['musicManage_err_tip_select_musics']; ?>
');if(multiCheckValue!='') playInPlayListPlayer(multiCheckValue);"/></span></p>

                <?php if (isMember ( )): ?>
                	<?php if ($this->_tpl_vars['myobj']->allow_quick_mixs): ?>
                      <p class="clsCancelButton-l"><span class="clsCancelButton-r" id="quick_mix"><input type="button" value="<?php echo $this->_tpl_vars['LANG']['common_music_add_to_quick_mix']; ?>
" onclick="getMultiCheckBoxValueForQuickMix('playlistManage', 'check_all', '<?php echo $this->_tpl_vars['LANG']['musicManage_err_tip_select_musics']; ?>
');if(quickMixmultiCheckValue!='') updateMusicsQuickMixCount(quickMixmultiCheckValue);"/></span></p>
					<?php endif; ?>
                      <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input  type="button" name="save_playlist" id="save_playlist" value="<?php echo $this->_tpl_vars['LANG']['common_music_add_to_playlist']; ?>
"
                          onclick="getMultiCheckBoxValue('playlistManage', 'check_all', '<?php echo $this->_tpl_vars['LANG']['musicManage_err_tip_select_musics']; ?>
');if(multiCheckValue!='') return populateMyPlayList('<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
', 'select', multiCheckValue);"/></span></p>
                       <?php if ($this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id']): ?>
                          <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" name="button" id="button" value="<?php echo $this->_tpl_vars['LANG']['viewplaylist_delete']; ?>
" onclick="getMultiCheckBoxValue('playlistManage', 'check_all', '<?php echo $this->_tpl_vars['LANG']['musicManage_err_tip_select_musics']; ?>
');if(multiCheckValue!='') return Confirmation('selMsgConfirm', 'msgConfirmform', Array('action','song_id', 'playlist_id', 'confirmMessage'), Array('delete', multiCheckValue,  '<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
', '<?php echo $this->_tpl_vars['LANG']['viewplaylist_delete_confirmation']; ?>
'), Array('value', 'value', 'value', 'innerHTML'), -100, -500);" /></span></p>
                       <?php endif; ?>
                <?php else: ?>
                    <!--<p class="clsLinksButton"><span><input type="submit" name="quick_mix" id="quick_mix" value="<?php echo $this->_tpl_vars['LANG']['viewplaylist_quick_mix_label']; ?>
"  onclick="redirect('<?php echo $this->_tpl_vars['myobj']->is_not_member_url; ?>
')"/></span></p>-->
                    <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input 	 type="button" name="save_playlist" id="save_playlist" value="<?php echo $this->_tpl_vars['LANG']['viewplaylist_save_label']; ?>
"  onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['login_saveplaylist_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->is_not_member_url; ?>
');return false;"/></span></p>
                <?php endif; ?>

                    </div>
                    <div id="clsMsgDisplay_playlist_success" class="clsDisplayNone clsPlaylistSuccess"></div>
					<div class="clsPlayListingMainBlock">
                    <?php $_from = $this->_tpl_vars['displayPlaylistSong_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicKey'] => $this->_tpl_vars['musicValue']):
?>
                        <div class="clsListContents">
                        <div class="clsOverflow">
                            <p class="clsListCheckBox"><input type="checkbox" class="clsCheckRadio" name="song_ids[]" value="<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
" onclick="disableHeading('playlistManage');" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></p>
                            <div class="clsThumb">
                                <div class="clsLargeThumbImageBackground">
                                   <a href="<?php echo $this->_tpl_vars['musicValue']['viewmusic_url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls144x110">
										<?php if ($this->_tpl_vars['musicValue']['music_image_src'] != ''): ?>
										<img src="<?php echo $this->_tpl_vars['musicValue']['music_image_src']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(134,90,$this->_tpl_vars['musicValue']['record']['thumb_width'],$this->_tpl_vars['musicValue']['record']['thumb_height']); ?>
 title="<?php echo $this->_tpl_vars['musicValue']['record']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 10) : smarty_modifier_truncate($_tmp, 10)); ?>
" />
										<?php else: ?>
										<img   src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_T.jpg" title="<?php echo $this->_tpl_vars['musicValue']['record']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 10) : smarty_modifier_truncate($_tmp, 10)); ?>
"/>
										<?php endif; ?>
                                    </a>
                                </div>
								 <div class="clsTime"><!----><?php echo $this->_tpl_vars['musicValue']['record']['playing_time']; ?>
</div>
                            </div>
                            <div class="clsPlayerImage">
							 <div><?php echo $this->_tpl_vars['myobj']->populateMusicRatingImages($this->_tpl_vars['musicValue']['record']['rating'],'audio','','','music'); ?>
</div>
							
							<div class="clsPlayQuickmix clsOverflow clsFloatRight">
							<?php if ($this->_tpl_vars['musicValue']['add_quickmix']): ?>
                                                <?php if ($this->_tpl_vars['musicValue']['is_quickmix_added']): ?>
                                                      <p class="clsQuickMix clsFloatRight" id="quick_mix_added_<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['viewplaylist_added_quick_mix_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_quick_mix']; ?>
</a></p>
                                                <?php else: ?>
                                                      <p class="clsQuickMix clsFloatRight" id="quick_mix_added_<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
" style="display:none"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['viewplaylist_added_quick_mix_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_quick_mix']; ?>
</a></p>

                                                      <p class="clsQuickMix clsFloatRight" id="quick_mix_<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
"><a href="javascript:void(0)" onclick="updateMusicsQuickMixCount('<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['viewplaylist_quick_mix_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_quick_mix']; ?>
</a></p>
                                                <?php endif; ?>
                                           <?php endif; ?>
							</div>
                                    
									
                       
						
                             </div>
                            <div class="clsContentDetails">
                                    <p class="clsHeading" title="<?php echo $this->_tpl_vars['musicValue']['record']['music_title']; ?>
"><a href="<?php echo $this->_tpl_vars['musicValue']['viewmusic_url']; ?>
" title="<?php echo $this->_tpl_vars['musicValue']['record']['music_title']; ?>
"><?php echo $this->_tpl_vars['musicValue']['record']['music_title']; ?>
</a></p>
                                     <p class="clsAlbumLink" title="<?php echo $this->_tpl_vars['musicValue']['record']['album_title']; ?>
"> <?php echo $this->_tpl_vars['LANG']['album_title']; ?>
: <a href="<?php echo $this->_tpl_vars['musicValue']['musiclistalbum_url']; ?>
" title="<?php echo $this->_tpl_vars['musicValue']['record']['album_title']; ?>
"><?php echo $this->_tpl_vars['musicValue']['record']['album_title']; ?>
</a></p>
                                    <p class="clsTrackLink"><?php echo $this->_tpl_vars['LANG']['artist_by']; ?>
 <a href="<?php echo $this->_tpl_vars['musicValue']['viewprofile_url']; ?>
" class="clsLink" title="<?php echo $this->_tpl_vars['musicValue']['record']['user_name']; ?>
"><?php echo $this->_tpl_vars['musicValue']['record']['user_name']; ?>
</a></p>
                                   <p class="clsGeneres" title="<?php echo $this->_tpl_vars['musicValue']['record']['music_category_name']; ?>
"><?php echo $this->_tpl_vars['LANG']['music_genre_in']; ?>
 <a href="<?php echo $this->_tpl_vars['musicValue']['musiccategorylist_url']; ?>
" title="<?php echo $this->_tpl_vars['musicValue']['record']['music_category_name']; ?>
"><?php echo $this->_tpl_vars['musicValue']['record']['music_category_name']; ?>
</a></p>
                                   <?php if ($this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id']): ?>
                                        <p class="clsDeleteIcon clsOverflow clsPhotoVideoEditLinkson"><a href="javascript:void(0);" title="<?php echo $this->_tpl_vars['LANG']['viewplaylist_delete_label']; ?>
"  alt="<?php echo $this->_tpl_vars['LANG']['viewplaylist_delete_label']; ?>
" class="clsPhotoVideoEditLinkson" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('action','song_id', 'playlist_id', 'confirmMessage'), Array('delete', '<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
',  '<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
', '<?php echo $this->_tpl_vars['LANG']['viewplaylist_delete_confirmation']; ?>
'), Array('value', 'value', 'value', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['viewplaylist_delete_label']; ?>
</a></p>
                                    <?php endif; ?>
                             </div>
							</div>
							<div>
							<?php echo '
                                    <script type="text/javascript">										
										$Jq(window).load(function(){
											$Jq("#trigger_'; ?>
<?php echo $this->_tpl_vars['musicValue']['record']['music_in_playlist_id']; ?>
<?php echo '").click(function(){
												displayMusicMoreInfo(\''; ?>
<?php echo $this->_tpl_vars['musicValue']['record']['music_in_playlist_id']; ?>
<?php echo '\');
												return false;
											});
										});										
									</script>
                                    '; ?>

						
							 <div class="clsMoreInfoContainer clsOverflow">
                  <a  id="trigger_<?php echo $this->_tpl_vars['musicValue']['record']['music_in_playlist_id']; ?>
" href="javascript:void(0);" class="clsMoreInformation" onclick="moreInformation('musicDetail_<?php echo $this->_tpl_vars['musicValue']['record']['music_in_playlist_id']; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['viewplaylist_song_detailinformation_helptips']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewplaylist_more_label']; ?>
</span></a></div>
							   <div id="panel_<?php echo $this->_tpl_vars['musicValue']['record']['music_in_playlist_id']; ?>
" class="clsMoreInfoBlock" style="display:none">
                    <div class="clsMoreInfoContent clsOverflow">
                                    <table>
                                        <tr>
                                           <td>
											<span><?php echo $this->_tpl_vars['LANG']['viewplaylist_artist_by_label']; ?>
:</span>
                                             <span class="clsMoreInfodata"><?php echo $this->_tpl_vars['myobj']->getArtistLink($this->_tpl_vars['musicValue']['record']['music_artist'],true,0); ?>
</span>
											</td>
											<td>
                                            <span><?php echo $this->_tpl_vars['LANG']['viewplaylist_added_label']; ?>
</span>
                                           <span class="clsMoreInfodata"><?php echo $this->_tpl_vars['musicValue']['record']['date_added']; ?>
</span>
                                       </td>
                                        </tr>
                                       <tr>
                                           <td>
                                           <span><?php echo $this->_tpl_vars['LANG']['viewplaylist_plays_label']; ?>
:</span>
                                            <span class="clsMoreInfodata"><?php echo $this->_tpl_vars['musicValue']['record']['total_plays']; ?>
</span>
                                        </td>
										 <td>
                                            <span><?php echo $this->_tpl_vars['LANG']['viewplaylist_comments_label']; ?>
</span>
                                             <span class="clsMoreInfodata"><?php echo $this->_tpl_vars['musicValue']['record']['total_comments']; ?>
</span>
                                       </td>
                                        </tr>
                                        <tr>
                                           <td>
                                           <span><?php echo $this->_tpl_vars['LANG']['viewplaylist_songlistfavorited_label']; ?>
:</span>
                                            <span class="clsMoreInfodata"><?php echo $this->_tpl_vars['musicValue']['record']['total_favorites']; ?>
</span>
                                       </td>
									    <td>
                                            <span><?php echo $this->_tpl_vars['LANG']['viewplaylist_rated_label']; ?>
</span>
                                             <span class="clsMoreInfodata"><?php echo $this->_tpl_vars['musicValue']['record']['rating_count']; ?>
</span>
                                    	 </td>
                                        </tr>
                                   </table>
                                    
                                        
                                       
                                        
                                    <p class="clsMoreinfoTags"><?php echo $this->_tpl_vars['LANG']['viewplaylist_tags_label']; ?>
: <?php if ($this->_tpl_vars['musicValue']['record']['music_tags']): ?><?php echo $this->_tpl_vars['myobj']->getMusicTagsLinks($this->_tpl_vars['musicValue']['record']['music_tags'],5); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['common_not_available']; ?>
<?php endif; ?></p>
                                   <p class="clsDescription" title="<?php echo $this->_tpl_vars['musicValue']['record']['music_caption']; ?>
"><span class="clsLabel"><?php echo $this->_tpl_vars['LANG']['viewplaylist_description_label']; ?>
</span> <?php if ($this->_tpl_vars['musicValue']['record']['music_caption']): ?><?php echo $this->_tpl_vars['musicValue']['record']['music_caption']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['common_not_available']; ?>
<?php endif; ?></p>
                            </div>
							</div>
                         </div>
                       
                    </div>
                    <?php endforeach; endif; unset($_from); ?>
					</div>
       				 <input type="hidden" name="start" id="start" value="<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
" />
                     <div class="clsOverflow">
                         <div  id="playlistSongs_Paging" class="clsAudioHorizontalPaging">
                            <ul>
                                <li> <a href="javascript:void(0);" class="<?php echo $this->_tpl_vars['myobj']->activeClsPrevious; ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_previous']; ?>
" <?php if ($this->_tpl_vars['myobj']->isPreviousButton): ?> onclick="musicPlaylistAjaxPaging('?ajax_page=true&amp;page=pagenation&playlist_id=<?php echo $this->_tpl_vars['playlistInformation']['playlist_id']; ?>
&user_id=<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
', 'perv')" <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['viewplaylist_pageing_previous']; ?>
</a>  </li>
                                <li><a href="javascript:void(0);"  class="<?php echo $this->_tpl_vars['myobj']->activeClsNext; ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_next']; ?>
" <?php if ($this->_tpl_vars['myobj']->isNextButton): ?> onclick="musicPlaylistAjaxPaging('?ajax_page=true&amp;page=pagenation&playlist_id=<?php echo $this->_tpl_vars['playlistInformation']['playlist_id']; ?>
&user_id=<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
', 'next')" <?php endif; ?> ><?php echo $this->_tpl_vars['LANG']['viewplaylist_pageing_next']; ?>
</a></li>
                            </ul>
                        </div>
                    </div>
	            </form>
      <?php else: ?>
      	<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['viewplaylist_no_music_found_error_tips']; ?>
</div>
      <?php endif; ?>
    </div>
 <div id="selMsgCartSuccess" class="clsPopupConfirmation" style="display:none;">
						              <p id="selCartAlertSuccess"></p>
						              <form name="msgCartFormSuccess" id="msgConfirmformMulti" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
						                <input type="button" class="clsSubmitButton" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_option_ok']; ?>
"
						                tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks()" />
						              </form>
						            </div>