<?php /* Smarty version 2.6.18, created on 2012-02-01 00:03:04
         compiled from myMusicTracker.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'myMusicTracker.tpl', 32, false),array('function', 'smartyTabIndex', 'myMusicTracker.tpl', 75, false),)), $this); ?>
<script type="text/javascript" language="javascript" src="<?php echo $this->_tpl_vars['CFG']['site']['project_path_relative']; ?>
js/AG_ajax_html.js"></script>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti', 'selEditVideoComments', 'selMsgCartSuccess');
	var max_width_value = "<?php echo $this->_tpl_vars['CFG']['admin']['musics']['get_code_max_size']; ?>
";
	var delLink_value;
</script>
				<?php echo $this->_tpl_vars['myobj']->populatePlayerWithPlaylist($this->_tpl_vars['music_fields']); ?>

	<input type="hidden" name="hidden_player_status" id="hidden_player_status" value="" />
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
    <input type="hidden" name="advanceFromSubmission" value="1"/>
    <?php echo $this->_tpl_vars['myobj']->populateMusicListHidden($this->_tpl_vars['paging_arr']); ?>

      <div class="clsAudioListContainer">
          <div class="clsOverflow">
              <div class="clsHeadingLeft">
                <h2><span>
                <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'usermusiclist'): ?>
                  <?php echo $this->_tpl_vars['LANG']['musictracker_title']; ?>

                <?php else: ?>
                  <?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['musictracker_title'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>

                <?php endif; ?>
                </span></h2>
              </div>
          </div>
			<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_show_sub_category')): ?>
			<?php if ($this->_tpl_vars['populateSubCategories_arr']['row']): ?>
			<?php endif; ?>
			<div id="selShowAllShoutouts" class="clsDataTable">
			<table id="selCategoryTable" class="clsSubCategoryTable">
			<?php $_from = $this->_tpl_vars['populateSubCategories_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subCategoryItem'] => $this->_tpl_vars['subCategoryValue']):
?>
			<?php echo $this->_tpl_vars['subCategoryValue']['open_tr']; ?>

			<td id="selVideoGallery_<?php echo $this->_tpl_vars['subCategoryItem']; ?>
" class="clsVideoCategoryCell">
				<div id="selImageDet">
				<h3>
					<div class="clsOverflow"><span class="clsViewThumbImage">
					<a href="<?php echo $this->_tpl_vars['subCategoryValue']['music_tracker_url']; ?>
">
					<img src="<?php echo $this->_tpl_vars['subCategoryValue']['imageSrc']; ?>
" /></a>
					</span></div>
					<a href="<?php echo $this->_tpl_vars['subCategoryValue']['music_tracker_url']; ?>
">
					<?php echo $this->_tpl_vars['subCategoryValue']['music_category_name_manual']; ?>

					</a>
				</h3>
				</div>
			</td>
			<?php echo $this->_tpl_vars['subCategoryValue']['end_tr']; ?>

			<?php endforeach; else: ?>
            <?php endif; unset($_from); ?>
			</table>
			<?php endif; ?>
          </form>
          <!--FORM End-->
          <div id="selLeftNavigation">
            <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
              <p id="msgConfirmText"></p>
              <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                      <div><p id="selImageBorder" class="clsPlainImageBorder">
                        <span id="selPlainCenterImage">
                          <img id="selVideoId" border="0" src=""/>
                        </span>
                      </p>
                    </div>
                  <input type="submit" class="clsSubmitButton" name="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
"
                  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
                  <input type="button" class="clsSubmitButton" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
"
                  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
                  <input type="hidden" name="act" id="act" />
                  <input type="hidden" name="music_id" id="music_id" />
              </form>
            </div>
            <div id="selMsgCartSuccess" class="clsPopupConfirmation" style="display:none;">
              <p id="selCartAlertSuccess"></p>
              <form name="msgCartFormSuccess" id="msgConfirmformMulti" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                <input type="button" class="clsSubmitButton" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_option_ok']; ?>
"
                tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
              </form>
            </div>
            <div id="selMsgConfirmMulti" class="clsPopupConfirmation" style="display:none;">
              <p id="msgConfirmTextMulti"><?php echo $this->_tpl_vars['LANG']['musictracker_multi_delete_confirmation']; ?>
</p>
              <form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                <input type="submit" class="clsSubmitButton" name="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
"
                tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
                <input type="button" class="clsSubmitButton" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
"
                tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
                <input type="hidden" name="music_id" id="music_id" />
                <input type="hidden" name="act" id="act" />
              </form>
            </div>
            <form name="musicTrackerForm" id="musicTrackerForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
            <div id="selEditVideoComments" class="clsPopupConfirmation" style="display:none;"></div>
            <div class="clsSelectAllLinks clsOverflow">
              <p class="clsListCheckBox"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="CheckAll(document.musicTrackerForm.name, document.musicTrackerForm.check_all.name)"/></p>
              <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" value="<?php echo $this->_tpl_vars['LANG']['music_tracker_play']; ?>
" onClick="getMultiCheckBoxValue('musicTrackerForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['musicManage_err_tip_select_musics']; ?>
');if(multiCheckValue!='') playInPlayListPlayer(multiCheckValue);"/></span></p>
              <?php if (isMember ( )): ?>
                      <p class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" value="<?php echo $this->_tpl_vars['LANG']['music_tracker_add_to_playlist']; ?>
" onClick="getMultiCheckBoxValue('musicTrackerForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['musictracker_select_titles']; ?>
');if(multiCheckValue!='')
                    managePlaylist(multiCheckValue, '<?php echo $this->_tpl_vars['myobj']->savePlaylistUrl; ?>
', '<?php echo $this->_tpl_vars['LANG']['common_create_playlist']; ?>
');" /></span></p>
              <?php endif; ?>
            </div>
            <div class="clsOverflow clsSortByLinksContainer">
              <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('my_musics_form')): ?>
                <div class="clsSortByPagination">
                      <div class="clsAudioPaging">
                        <div class="clsPagingList">
                          <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
								<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                          <?php endif; ?>
                        </div>
                      </div>
                </div>
            </div>
            <a href="#" id="<?php echo $this->_tpl_vars['myobj']->my_musics_form['anchor']; ?>
"></a>
			<div class="clsMusicTrackerMainBlock">
              <?php if ($this->_tpl_vars['myobj']->isResultsFound): ?>
                      <?php $this->assign('count', 0); ?>
                      <?php $this->assign('song_id', 1); ?>
                      <?php $_from = $this->_tpl_vars['music_list_result']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['music'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['music']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['result']):
        $this->_foreach['music']['iteration']++;
?>
                      <?php if ($this->_foreach['music']['iteration']%$this->_tpl_vars['myobj']->my_musics_form['showMusicTrackerList']['musicsPerRow'] == 1): ?>
                      <?php endif; ?>
                            <div class="clsListContents">
                                    <div class="clsOverflow">
                                      <p class="clsListCheckBox">
                                              <input type='checkbox' name='checkbox[]' id="checkbox[]" value="<?php echo $this->_tpl_vars['result']['record']['music_id']; ?>
" onClick="disableHeading('musicTrackerForm');"/></p>
                                      <div class="clsThumb">
										<div class="clsLargeThumbImageBackground clsNoLink">
											  <a id="<?php echo $this->_tpl_vars['result']['anchor']; ?>
"></a>
											  <?php if ($this->_tpl_vars['result']['img_src']): ?>
												  <a  href="<?php echo $this->_tpl_vars['result']['view_music_link']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls144x110"><img src="<?php echo $this->_tpl_vars['result']['img_src']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(142,108,$this->_tpl_vars['result']['record']['thumb_width'],$this->_tpl_vars['result']['record']['thumb_height']); ?>
/></a>
											  <?php else: ?>
											      <p class="ClsImageContainer ClsImageBorder1 Cls132x88"> <img src="<?php echo $this->_tpl_vars['album_music_count_list'][$this->_tpl_vars['result']['music_album_id']]['img_src']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(142,108,$this->_tpl_vars['album_music_count_list'][$this->_tpl_vars['result']['music_album_id']]['thumb_width'],$this->_tpl_vars['album_music_count_list'][$this->_tpl_vars['result']['music_album_id']]['thumb_height']); ?>
/></p>
											  <?php endif; ?>
										  </div>
                                      <div class="clsTime"><!----><?php echo $this->_tpl_vars['result']['playing_time']; ?>
</div>
                                      </div>
                                      <div class="clsPlayerImage">
									   <?php if ($this->_tpl_vars['myobj']->populateRatingDetails($this->_tpl_vars['result']['rating'])): ?>
                                            <?php echo $this->_tpl_vars['myobj']->populateMusicRatingImages($this->_tpl_vars['result']['rating'],'music'); ?>

                                        <?php else: ?>
                                        	<?php echo $this->_tpl_vars['myobj']->populateMusicRatingImages(0,'music'); ?>

                                        <?php endif; ?>
                                        <span>&nbsp; ( <?php echo $this->_tpl_vars['result']['rating']; ?>
 )</span>
										<div class="clsPlayQuickmix">
                                          <div class="clsPlayerIcon">
                                          	<a class="clsPlaySong" id="play_music_icon_<?php echo $this->_tpl_vars['result']['music_id']; ?>
" onClick="playSelectedSong(<?php echo $this->_tpl_vars['result']['music_id']; ?>
)" href="javascript:void(0)"></a>
                                          	<a class="clsStopSong" id="play_playing_music_icon_<?php echo $this->_tpl_vars['result']['music_id']; ?>
" onClick="stopSong(<?php echo $this->_tpl_vars['result']['music_id']; ?>
)" style="display:none" href="javascript:void(0)"></a>                                        </div>
										</div>
										
										 
									  </div>

                                      <div class="clsContentDetails">
										<p class="clsHeading"><a  href="<?php echo $this->_tpl_vars['result']['view_music_link']; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['music_title']; ?>
" alt="<?php echo $this->_tpl_vars['result']['record']['music_title']; ?>
" ><?php echo $this->_tpl_vars['result']['record']['music_title']; ?>
</a></p>
                                        <p class="clsAlbumLink"><?php echo $this->_tpl_vars['LANG']['album_title']; ?>
: <a href="<?php echo $this->_tpl_vars['result']['view_album_link']; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['album_title']; ?>
"><?php echo $this->_tpl_vars['result']['record']['album_title']; ?>
</a></p>
                                       
                                             <p class="clsLink"><?php echo $this->_tpl_vars['LANG']['musictracker_artist']; ?>
<a  href="<?php echo $this->_tpl_vars['result']['artist_link']; ?>
"><?php echo $this->_tpl_vars['myobj']->getArtistLink($this->_tpl_vars['result']['record']['music_artist'],true); ?>
</a></p>
                                        
                                        <p class="clsGeneres"><?php echo $this->_tpl_vars['LANG']['music_genre_in']; ?>
<a  href="<?php echo $this->_tpl_vars['result']['category_link']; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['music_category_name']; ?>
"><?php echo $this->_tpl_vars['result']['record']['music_category_name']; ?>
</a></p>
                                        
                                        </div>
										</div>
										<div>
										<?php echo '
                                    <script type="text/javascript">										
										$Jq(window).load(function(){
											$Jq("#trigger_'; ?>
<?php echo $this->_tpl_vars['result']['music_id']; ?>
<?php echo '").click(function(){
												displayMusicMoreInfo(\''; ?>
<?php echo $this->_tpl_vars['result']['music_id']; ?>
<?php echo '\');
												return false;
											});
										});										
									</script>
                                    '; ?>

            					   <div class="clsMoreInfoContainer clsOverflow">
									  <a class="clsMoreInformation" id="trigger_<?php echo $this->_tpl_vars['result']['music_id']; ?>
">
										  <span><?php echo $this->_tpl_vars['LANG']['header_nav_more_info']; ?>
</span>
									  </a>
									   </div>
										 <div class="clsMoreInfoBlock" id="panel_<?php echo $this->_tpl_vars['result']['music_id']; ?>
" style="display:none;" >
											<div class="clsMoreInfoContent">
												<div class="clsOverflow">
													<table>
                                                    
													<tr> 
                                                    <?php if ($this->_tpl_vars['result']['record']['music_artist']): ?>
													<td>
														<span><?php echo $this->_tpl_vars['LANG']['artist_by']; ?>
</span>
														 <span class="clsMoreInfodata"><a href="<?php echo $this->_tpl_vars['myobj']->memberProfileUrl[$this->_tpl_vars['result']['record']['user_id']]; ?>
"><?php echo $this->_tpl_vars['result']['record']['user_name']; ?>
</a></span>
													</td>
                                                     <?php endif; ?>
                                                     
													 <td>
													 <span><?php echo $this->_tpl_vars['LANG']['music_tracker_added_date']; ?>
</span>
													  <span class="clsMoreInfodata"><?php echo $this->_tpl_vars['result']['date_added']; ?>
</span>
													</td>
													 </tr>
													 <tr>
													<td>
														<span><?php echo $this->_tpl_vars['LANG']['music_tracker_plays']; ?>
</span>
														 <span class="clsMoreInfodata"><?php echo $this->_tpl_vars['result']['record']['total_plays']; ?>
</span>
													  </td>
													  <td>
													  <span><?php echo $this->_tpl_vars['LANG']['music_tracker_commented']; ?>
</span>
													 <span class="clsMoreInfodata"><?php echo $this->_tpl_vars['result']['record']['total_comments']; ?>
</span>
													</td>
													 </tr>
													 <tr>
													<td>
														<span><?php echo $this->_tpl_vars['LANG']['music_tracker_favorite']; ?>
</span>
														 <span class="clsMoreInfodata"><?php echo $this->_tpl_vars['result']['record']['total_favorites']; ?>
</span>
													  </td>
													  <td>
													 <span><?php echo $this->_tpl_vars['LANG']['music_tracker_ratted']; ?>
</span>
													  <span class="clsMoreInfodata"><?php echo $this->_tpl_vars['result']['rating']; ?>
 (<?php echo $this->_tpl_vars['result']['total_rating']; ?>
 <?php echo $this->_tpl_vars['LANG']['musictracker_ratted']; ?>
)</span>
													</td>
													 </tr>
													<tr>
													<td>
														 <span><?php echo $this->_tpl_vars['LANG']['musictracker_music_listened']; ?>
 </span>
														  <span class="clsMoreInfodata"><?php echo $this->_tpl_vars['result']['last_listened']; ?>
</span>
													 </td>
													 <td>
														 <span><?php echo $this->_tpl_vars['LANG']['musictracker_language_list']; ?>
</span>
														  <span class="clsMoreInfodata"><?php if ($this->_tpl_vars['result']['music_language_val']): ?><?php echo $this->_tpl_vars['result']['music_language_val']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['common_not_available']; ?>
<?php endif; ?></span>
													</td>
													 </tr>
													<tr>
                                                    	<td colspan="2">
                                                        	<span><?php echo $this->_tpl_vars['LANG']['musictracker_total_plays']; ?>
</span>
													  		<span class="clsMoreInfodata"><?php echo $this->_tpl_vars['result']['record']['total_play_count']; ?>
</span>
                                                        </td>
                                                    </tr>
												</table>
											  <p class="clsMoreinfoTags"><?php echo $this->_tpl_vars['LANG']['music_tracker_tags']; ?>
: <?php if ($this->_tpl_vars['result']['record']['music_tags'] != ''): ?><?php echo $this->_tpl_vars['myobj']->getMusicTagsLinks($this->_tpl_vars['result']['record']['music_tags'],5); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['common_not_available']; ?>
<?php endif; ?></p>
											   <p class="clsDescription"><span class="clsLabel"><?php echo $this->_tpl_vars['LANG']['music_tracker_description']; ?>
</span>: <?php if ($this->_tpl_vars['myobj']->getDescriptionForMusicTrackerList($this->_tpl_vars['result']['record']['music_caption'])): ?><?php echo $this->_tpl_vars['myobj']->getDescriptionForMusicTrackerList($this->_tpl_vars['result']['record']['music_caption']); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['common_not_available']; ?>
<?php endif; ?>
											<?php $_from = $this->_tpl_vars['getDescriptionLink_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['descriptionsValue']):
?>
												<?php echo $this->_tpl_vars['descriptionsValue']['wordWrap_mb_ManualWithSpace_description_name']; ?>

											<?php endforeach; endif; unset($_from); ?></p>
						
											</div>
										  </div>
                                    </div>
									
									</div>
               </div>
					<?php if ($this->_foreach['music']['iteration']%$this->_tpl_vars['myobj']->my_musics_form['showMusicTrackerList']['musicsPerRow'] == 0): ?>
					<?php endif; ?>
						<?php $this->assign('song_id', $this->_tpl_vars['song_id']+1); ?>
					<?php endforeach; endif; unset($_from); ?>
					<?php else: ?>
					<div id="selMsgAlert">
					  <p><?php echo $this->_tpl_vars['LANG']['common_music_no_records_found']; ?>
</p>
					</div>
					<?php endif; ?>
            <?php endif; ?>
			</div>
            <div class="clsAudioPaging">
              <div class="clsPagingList">
              <ul>
                <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php endif; ?>
              </ul>
              </div>
            </div>
                </form>
          </div>
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>