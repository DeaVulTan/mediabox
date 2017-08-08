<?php /* Smarty version 2.6.18, created on 2011-10-17 15:10:10
         compiled from ajaxViewAlbum.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'ajaxViewAlbum.tpl', 5, false),array('modifier', 'truncate', 'ajaxViewAlbum.tpl', 35, false),)), $this); ?>
	<div class="clsViewAlbumPageContainer">
		<?php if ($this->_tpl_vars['myobj']->total_records): ?>
            <form id="albumManage" name="albumManage" method="post" action="">
                    <div class="clsSelectAllLinks clsOverflow">
                        <p class="clsListCheckBox"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="CheckAll(document.albumManage.name, document.albumManage.check_all.name)"/> </p>
                <input  type="hidden" name="start" id="start" value="<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
" />
				<?php if (isMember ( )): ?>
			  <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" value="<?php echo $this->_tpl_vars['LANG']['viewalbumlist_add_label']; ?>
" onClick="getMultiCheckBoxValue('albumManage', 'check_all', '<?php echo $this->_tpl_vars['LANG']['viewalbumlist_select_titles']; ?>
');if(multiCheckValue!='') playInPlayListPlayer(multiCheckValue);"/></span></p>
			  <!-- <p class="clsCancelButton-l"><span class="clsCancelButton-r" id="quick_mix"><input type="submit" value="<?php echo $this->_tpl_vars['LANG']['viewalbumlist_add_to_quickmix']; ?>
" onClick="getMultiCheckBoxValue('albumManage', 'check_all', '<?php echo $this->_tpl_vars['LANG']['viewalbumlist_add_to_quickmix']; ?>
');if(multiCheckValue!='') quickMixShowHideDiv();"/></span></p>-->
                                             <!--<p class="clsLinksButton"><span><input type="submit" name="quick_mix" id="quick_mix" value="<?php echo $this->_tpl_vars['LANG']['viewalbumlist_quick_mix_label']; ?>
" /></span></p>-->
            <?php if ($this->_tpl_vars['myobj']->allow_quick_mixs): ?>
		    <p class="clsCancelButton-l"><span class="clsCancelButton-r" id="quick_mix"><input type="button" value="<?php echo $this->_tpl_vars['LANG']['common_music_add_to_quick_mix']; ?>
" onClick="getMultiCheckBoxValueForQuickMix('albumManage', 'check_all', '<?php echo $this->_tpl_vars['LANG']['musicManage_err_tip_select_musics']; ?>
');if(quickMixmultiCheckValue!='') updateMusicsQuickMixCount(quickMixmultiCheckValue);"/></span></p>
            <?php endif; ?>
                <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input  type="button" name="save_playlist" id="save_playlist" value="<?php echo $this->_tpl_vars['LANG']['common_music_add_to_playlist']; ?>
"
                    onClick="getMultiCheckBoxValue('albumManage', 'check_all', '<?php echo $this->_tpl_vars['LANG']['viewalbumlist_select_titles']; ?>
');if(multiCheckValue!='') return populateMyPlayList('<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
', 'select', multiCheckValue);"/></span></p>
                 <?php if ($this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id']): ?>
					<!--<p class="clsLinksButton"><span><input type="button" name="button" id="button" value="<?php echo $this->_tpl_vars['LANG']['viewalbumlist_delete']; ?>
" onClick="getMultiCheckBoxValue('albumManage', 'check_all', '<?php echo $this->_tpl_vars['LANG']['viewalbumlist_select_titles']; ?>
');if(multiCheckValue!='') return Confirmation('selMsgConfirm', 'msgConfirmform', Array('action','song_id', 'album_id', 'confirmMessage'), Array('delete', multiCheckValue,  '<?php echo $this->_tpl_vars['myobj']->getFormField('album_id'); ?>
', '<?php echo $this->_tpl_vars['LANG']['viewalbumlist_delete_confirmation']; ?>
'), Array('value', 'value', 'value', 'innerHTML'), -100, -500);" /></span></p>-->
                 <?php endif; ?>
                <?php else: ?>
                    <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" name="add" id="add" value="<?php echo $this->_tpl_vars['LANG']['viewalbumlist_add_label']; ?>
"  onclick="getMultiCheckBoxValue('albumManage', 'check_all', '<?php echo $this->_tpl_vars['LANG']['viewalbumlist_select_titles']; ?>
');if(multiCheckValue!='') playInPlayListPlayer(multiCheckValue);"/></span></p>
                    <!--<p class="clsLinksButton"><span><input type="submit" name="quick_mix" id="quick_mix" value="<?php echo $this->_tpl_vars['LANG']['viewalbumlist_quick_mix_label']; ?>
"  onclick="redirect('<?php echo $this->_tpl_vars['myobj']->is_not_member_url; ?>
')"/></span></p>-->
                    <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input 	 type="button" name="save_playlist" id="save_playlist" value="<?php echo $this->_tpl_vars['LANG']['viewalbumlist_save_label']; ?>
"  onclick="redirect('<?php echo $this->_tpl_vars['myobj']->is_not_member_url; ?>
')"/></span></p>
                <?php endif; ?>
                    </div>
                    <div id="clsMsgDisplay_playlist_success" class="clsDisplayNone clsPlaylistSuccess"></div>
					<div class="clsAlbumListingMainBlock">
                    <?php $_from = $this->_tpl_vars['displayAlbumSong_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicKey'] => $this->_tpl_vars['musicValue']):
?>
                        <div class="clsListContents"> 
                        <div class="clsOverflow"> 
                            <p class="clsListCheckBox"><input type="checkbox" class="clsCheckRadio" name="song_ids[]" value="<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
" onClick="disableHeading('albumManage');" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></p>
                            <div class="clsThumb">
                                <div class="clsLargeThumbImageBackground">
                                   <a href="<?php echo $this->_tpl_vars['musicValue']['viewmusic_url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls132x88">
                                        <?php if ($this->_tpl_vars['musicValue']['music_image_src'] != ''): ?>
                                        <img src="<?php echo $this->_tpl_vars['musicValue']['music_image_src']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(132,88,$this->_tpl_vars['musicValue']['record']['thumb_width'],$this->_tpl_vars['musicValue']['record']['thumb_height']); ?>
 title="<?php echo $this->_tpl_vars['musicValue']['record']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 10) : smarty_modifier_truncate($_tmp, 10)); ?>
" title="<?php echo $this->_tpl_vars['musicValue']['record']['music_title']; ?>
"/>
                                        <?php else: ?>
                                        <img   width="132" height="88" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_T.jpg" title="<?php echo $this->_tpl_vars['musicValue']['record']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 10) : smarty_modifier_truncate($_tmp, 10)); ?>
" />
                                        <?php endif; ?>
                                    </a>
                                </div>
								<div class="clsTime"><!----><?php echo $this->_tpl_vars['musicValue']['playing_time']; ?>
</div>
                            </div>
                            <div class="clsPlayerImage">
							<div><?php echo $this->_tpl_vars['myobj']->populateMusicRatingImages($this->_tpl_vars['musicValue']['record']['rating'],'audio','','','music'); ?>
</div>
							<div class="clsOverflow clsPlayQuickmix clsFloatRight">
										<div class="clsFloatRight">
                                          <?php if ($this->_tpl_vars['musicValue']['add_quickmix']): ?>
                                                <?php if ($this->_tpl_vars['musicValue']['is_quickmix_added']): ?>
                                                      <p class="clsQuickMix" id="quick_mix_added_<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['viewalbumlist_added_quickMixs']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_quick_mix']; ?>
</a></p>
                                                <?php else: ?>
                                                      <p class="clsQuickMix" id="quick_mix_added_<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
" style="display:none"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['viewalbumlist_added_quickMixs']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_quick_mix']; ?>
</a></p>

                                                      <p class="clsQuickMix" id="quick_mix_<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
"><a href="javascript:void(0)" onClick="updateMusicsQuickMixCount('<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['viewalbumlist_add_to_quickmix']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_quick_mix']; ?>
</a></p>
                                                <?php endif; ?>
                                           <?php endif; ?>
										   </div>
                                        <div class="clsPlayerIcon clsFloatRight">
                                            <a class="clsPlaySong" id="play_music_icon_<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
" onClick="playSelectedSong(<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
)" href="javascript:void(0)" ></a>
                                            <a class="clsStopSong" id="play_playing_music_icon_<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
" onClick="stopSong(<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
)" style="display:none" href="javascript:void(0)"></a>
                                        </div>
										   </div>
										  
                             </div>
                            <div class="clsContentDetails">
                                    <p class="clsHeading" title="<?php echo $this->_tpl_vars['musicValue']['record']['music_title']; ?>
"><a href="<?php echo $this->_tpl_vars['musicValue']['viewmusic_url']; ?>
"><?php echo $this->_tpl_vars['musicValue']['record']['music_title']; ?>
</a></p>
                                    <p class="clsAlbumLink" title="<?php echo $this->_tpl_vars['musicValue']['record']['album_title']; ?>
"><?php echo $this->_tpl_vars['LANG']['album_title']; ?>
:<a href="<?php echo $this->_tpl_vars['musicValue']['musiclistalbum_url']; ?>
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
"><?php echo $this->_tpl_vars['musicValue']['record']['music_category_name']; ?>
</a></p>
                                    
                             </div>
							 </div>
							 <div>
							  <?php echo '
											<script type="text/javascript">										
												$Jq(document).ready(function(){
													$Jq("#trigger_'; ?>
<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
<?php echo '").click(function(){
														displayMusicMoreInfo(\''; ?>
<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
<?php echo '\');
														return false;
													});
												});										
											</script>
                                  		  '; ?>

										   <div class="clsMoreInfoContainer clsOverflow">
											  <a class="clsMoreInformation" id="trigger_<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
" href="javascript:void(0);">
												  <span><?php echo $this->_tpl_vars['LANG']['viewalbumlist_more_label']; ?>
</span>
											  </a>
											 </div>
							<div class="clsMoreInfoBlock" id="panel_<?php echo $this->_tpl_vars['musicValue']['record']['music_id']; ?>
" style="display:none;">
								<div class="clsMoreInfoContent clsOverflow">
								<div class="clsOverflow">
								<p id='anchor_id'></p>
                                       <table>
									   		<tr>
												<td>
                                            <span><?php echo $this->_tpl_vars['LANG']['viewalbumlist_artist_by_label']; ?>
</span>
                                           <span class="clsMoreInfodata"> <?php echo $this->_tpl_vars['myobj']->getArtistLink($this->_tpl_vars['musicValue']['record']['music_artist'],true,0); ?>
</span>
                                       		</td>
											<td>
                                            <span><?php echo $this->_tpl_vars['LANG']['viewalbumlist_added_label']; ?>
</span>
                                           <span class="clsMoreInfodata"> <?php echo $this->_tpl_vars['musicValue']['record']['date_added']; ?>
</span>
                                        </td>
									   </tr>
                                        <tr>
											<td>
                                            <span><?php echo $this->_tpl_vars['LANG']['viewalbumlist_plays_label']; ?>
</span>
                                           <span class="clsMoreInfodata"> <?php echo $this->_tpl_vars['musicValue']['record']['total_plays']; ?>
</span>
                                        </td>
										 <td>
                                            <span><?php echo $this->_tpl_vars['LANG']['viewalbumlist_comments_label']; ?>
</span>
                                           <span class="clsMoreInfodata"> <?php echo $this->_tpl_vars['musicValue']['record']['total_comments']; ?>
</span>
                                        </td>
									   </tr>
                                        <tr>
											<td>
                                            <span><?php echo $this->_tpl_vars['LANG']['viewalbumlist_favorited_label']; ?>
</span>
                                           <span class="clsMoreInfodata"> <?php echo $this->_tpl_vars['musicValue']['record']['total_favorites']; ?>
</span>
                                        </td>
										 <td>
                                            <span><?php echo $this->_tpl_vars['LANG']['viewalbumlist_rated_label']; ?>
</span>
                                           <span class="clsMoreInfodata"> <?php echo $this->_tpl_vars['musicValue']['record']['rating_count']; ?>
</span>
                                        </td>
									   </tr>
                                   </table>
                                   </div>
                                   <p class="clsMoreinfoTags"><?php echo $this->_tpl_vars['LANG']['viewalbumlist_tags_label']; ?>
: <?php if ($this->_tpl_vars['musicValue']['record']['music_tags']): ?><?php echo $this->_tpl_vars['myobj']->getMusicTagsLinks($this->_tpl_vars['musicValue']['record']['music_tags'],5); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['common_not_available']; ?>
<?php endif; ?></p>
                                    <p class="clsDescription" title="<?php echo $this->_tpl_vars['musicValue']['record']['music_caption']; ?>
"><span class="clsLabel"><?php echo $this->_tpl_vars['LANG']['viewalbumlist_description_label']; ?>
</span> <?php if ($this->_tpl_vars['musicValue']['record']['music_caption']): ?><?php echo $this->_tpl_vars['musicValue']['record']['music_caption']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['common_not_available']; ?>
<?php endif; ?></p>
                            </div>
                         </div>
						 </div>
                 </div>
                    <?php endforeach; endif; unset($_from); ?>
					</div>
                    <div id="selMsgCartSuccess" class="clsPopupConfirmation" style="display:none;">
		              <p id="selCartAlertSuccess"></p>
		              <form name="msgCartFormSuccess" id="msgCartFormSuccess" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
		                <input type="button" class="clsSubmitButton" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_option_ok']; ?>
"
		                tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
		              </form>
		            </div>
       				 <input type="hidden" name="start" id="start" value="<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
" />
                     <div class="clsOverflow">
                         <div  id="albumSongs_Paging" class="clsAudioHorizontalPaging">
                            <ul>
                                <li> <a href="javascript:void(0);" class="<?php echo $this->_tpl_vars['myobj']->activeClsPrevious; ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_previous']; ?>
" <?php if ($this->_tpl_vars['myobj']->isPreviousButton): ?> onclick="musicAlbumAjaxPaging('?ajax_page=true&amp;page=pagenation&album_id=<?php echo $this->_tpl_vars['viewAlbumInformation']['music_album_id']; ?>
&user_id=<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
', 'perv')" <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['viewalbumlist_pageing_previous']; ?>
</a>  </li>
                                <li><a href="javascript:void(0);"  class="<?php echo $this->_tpl_vars['myobj']->activeClsNext; ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_next']; ?>
" <?php if ($this->_tpl_vars['myobj']->isNextButton): ?> onclick="musicAlbumAjaxPaging('?ajax_page=true&amp;page=pagenation&album_id=<?php echo $this->_tpl_vars['viewAlbumInformation']['music_album_id']; ?>
&user_id=<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
', 'next')" <?php endif; ?> ><?php echo $this->_tpl_vars['LANG']['viewalbumlist_pageing_next']; ?>
</a></li>
                            </ul>
                        </div>
                    </div>
	            </form>
      <?php else: ?>
      	<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['viewalbumlist_no_record_found_err_tip']; ?>
</div>
      <?php endif; ?>
    </div>
		<div id="view_album_player_div" class="clsHiddenPlayer"><!----></div>