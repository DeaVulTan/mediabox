<?php /* Smarty version 2.6.18, created on 2012-02-01 18:04:27
         compiled from albumList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'albumList.tpl', 139, false),array('modifier', 'truncate', 'albumList.tpl', 151, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgCartSuccess');
</script>
<div class="clsAudioListContainer clsAudioPlayListContainer">
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('search_albumlist_block')): ?>
        <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
            <input type="hidden" name="advanceFromSubmission" value="1"/>
            <input type="hidden" name="start" value="1"/>
            <input type="hidden" name="music_id" id="music_id" />
            <div class="clsOverflow">
                    <div class="clsHeadingLeft">
                        <h2>
                        	<span>
                            <?php if ($this->_tpl_vars['myobj']->page_heading != ''): ?>
                                <?php echo $this->_tpl_vars['myobj']->page_heading; ?>

                            <?php else: ?>
                                <?php echo $this->_tpl_vars['LANG']['musicalbumList_title']; ?>

                            <?php endif; ?>
                            </span>
                        </h2>
                    </div>
                    <div class="clsHeadingRight clsVideoListHeadingRightLink clsAlphaShortListing">
                    <h2><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('albumsortlist','','','','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['musicalbumList_album_sort_list_title']; ?>
 </a></h2>
                                            </div>
                </div>
            				 <div class="clsOverflow clsshowhidefiltersblock">
        	<div class="clsAdvancedFilterSearch clsOverflow clsFloatLeft">
                        <a onclick="divShowHide('advancedAlbumlistSearch', 'show_link', 'hide_link')" class="clsShow"  id="show_link" href="javascript:void(0)"><span><?php echo $this->_tpl_vars['LANG']['musicalbumList_show_advanced_filters']; ?>
</span></a>
                        <a onclick="divShowHide('advancedAlbumlistSearch', 'show_link', 'hide_link')" class="clsHide"  style="display:none" id="hide_link" href="javascript:void(0)"><span><?php echo $this->_tpl_vars['LANG']['musicalbumList_hide_advanced_filters']; ?>
</span></a>
                    </div>
					</div>

			    <div id="advancedAlbumlistSearch" class="clsAdvancedFilterTable clsOverflow" <?php if ($this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:block <?php else: ?> style="display:none;  <?php endif; ?>margin:10px 0;"  >
					<div class="clsAdvanceSearchIcon">
                        <table class="">
                            <tr>
                                <td>
                                    <input class="clsTextBox" type="text" name="albumlist_title" id="albumlist_title"   value="<?php if ($this->_tpl_vars['myobj']->getFormField('albumlist_title') == ''): ?><?php echo $this->_tpl_vars['LANG']['musicalbumList_albumList_title']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('albumlist_title'); ?>
<?php endif; ?>" onblur="setOldValue('albumlist_title')"  onfocus="clearValue('albumlist_title')"/>
                                </td>
                                <td>
                                    <input class="clsTextBox" type="text" name="artist" id="artist" onfocus="clearValue('artist')"  onblur="setOldValue('artist')" value="<?php if ($this->_tpl_vars['myobj']->getFormField('artist') == ''): ?><?php echo $this->_tpl_vars['LANG']['musicalbumList_no_of_artist']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('artist'); ?>
<?php endif; ?>"/>
                                </td>
                            </tr>
                            <tr><td colspan="2">
                                    <input class="clsTextBox" type="text" name="music_title" id="music_title" onfocus="clearValue('music_title')"  onblur="setOldValue('music_title')" value="<?php if ($this->_tpl_vars['myobj']->getFormField('music_title') == ''): ?><?php echo $this->_tpl_vars['LANG']['musicalbumList_no_of_music_title']; ?>
 <?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('music_title'); ?>
<?php endif; ?>" />
                                </td>
                            </tr>
                        </table>
						</div>
						<div class="clsAdvancedSearchBtn">
						<table>
							 <tr>
                            <td>
                                <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="search" id="search" value="<?php echo $this->_tpl_vars['LANG']['musicalbumList_search']; ?>
" onclick="document.seachAdvancedFilter.start.value = '0';" /></span></div>
								</td></tr>
								<tr>
								<td>
                               <div class="clsCancelButton1-l"><span class="clsCancelButton1-r"><input type="submit" value="Reset" id="avd_reset" name="avd_reset"/></span></div>
                        	</td>
                        </tr>
						</table>
						</div>
                 </div>
               </form>

                <?php endif; ?>
                <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_albumlist_block')): ?>
                    <div id="selMusicPlaylistManageDisplay" class="clsLeftSideDisplayTable">
                        <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
                          <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                                      <div class="clsAudioPaging">
				   					  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                                      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                      </div>
                          <?php endif; ?>
                        <!-- top pagination end-->
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
                            <form name="musicListForm" id="musicListForm" action="<?php echo $this->_tpl_vars['_SERVER']['PHP_SELF']; ?>
" method="post">
                            <?php $_from = $this->_tpl_vars['myobj']->list_albumlist_block['showAlbumlists']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicAlbumlistKey'] => $this->_tpl_vars['musicalbumlist']):
?>
                                <div class="clsListContents">
                                    <div class="clsOverflow">
                                                <div class="clsThumb">
                                                    <input type="hidden" name="music_album_id" id="music_album_id" value="<?php echo $this->_tpl_vars['musicalbumlist']['record']['music_album_id']; ?>
" />
                                                    <div class="clsLargeThumbImageBackground clsNoLink">
                                                      <a href="<?php echo $this->_tpl_vars['musicalbumlist']['getUrl_viewAlbum_url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls132x88">
                                                                <?php if ($this->_tpl_vars['musicalbumlist']['music_image_src'] != ''): ?>
                                                                    <img src="<?php echo $this->_tpl_vars['musicalbumlist']['music_image_src']; ?>
" title="<?php echo $this->_tpl_vars['musicalbumlist']['record']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['musicalbumlist']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 10) : smarty_modifier_truncate($_tmp, 10)); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(132,88,$this->_tpl_vars['musicalbumlist']['record']['thumb_width'],$this->_tpl_vars['musicalbumlist']['record']['thumb_height']); ?>
/>
                                                                <?php else: ?>
                                                                    <img   width="132" height="88" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_T.jpg" title="<?php echo $this->_tpl_vars['musicalbumlist']['record']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['musicalbumlist']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 10) : smarty_modifier_truncate($_tmp, 10)); ?>
"/>
                                                                <?php endif; ?>
                                                       </a>
                                                      </div>
                                                </div>
                                                <div class="clsPlayerImage">
													<span>(<?php if ($this->_tpl_vars['musicalbumlist']['total_song'] <= 1): ?><?php echo $this->_tpl_vars['LANG']['musicalbumList_song']; ?>
:&nbsp;<?php echo $this->_tpl_vars['musicalbumlist']['total_song']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['musicalbumList_songs']; ?>
:&nbsp;<?php echo $this->_tpl_vars['musicalbumlist']['total_song']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['musicalbumlist']['private_song'] > 0): ?>&nbsp;|&nbsp;<?php echo $this->_tpl_vars['LANG']['musicalbumList_private']; ?>
:&nbsp;<?php echo $this->_tpl_vars['musicalbumlist']['private_song']; ?>
<?php endif; ?>)</span>
                                                    <p class="clsSongListLink"><a href="javascript:void(0)" id="albumlist_light_window_<?php echo $this->_tpl_vars['musicAlbumlistKey']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['musicalbumList_allsongdetail_helptips']; ?>
"><?php echo $this->_tpl_vars['LANG']['musicalbumList_song_list']; ?>
</a></p>
                                                    													<script type="text/javascript">
                                                    <?php echo '
                                                    $Jq(window).load(function() {
                                                        $Jq(\'#albumlist_light_window_'; ?>
<?php echo $this->_tpl_vars['musicAlbumlistKey']; ?>
<?php echo '\').fancybox({
                                                            \'width\'				: 550,
                                                            \'height\'			: 350,
                                                            \'autoScale\'     	: false,
                                                            \'href\'              : \''; ?>
<?php echo $this->_tpl_vars['musicalbumlist']['light_window_url']; ?>
<?php echo '\',
                                                            \'transitionIn\'		: \'none\',
                                                            \'transitionOut\'		: \'none\',
                                                            \'type\'				: \'iframe\'
                                                        });
                                                    });
                                                    '; ?>

                                                    </script>
                                                														<?php if ($this->_tpl_vars['musicalbumlist']['record']['album_for_sale'] == 'Yes' && isMember ( ) && isUserAlbumPurchased ( $this->_tpl_vars['musicalbumlist']['record']['music_album_id'] ) && $this->_tpl_vars['musicalbumlist']['record']['user_id'] != $this->_tpl_vars['CFG']['user']['user_id']): ?>
														<p id="add_cart_<?php echo $this->_tpl_vars['musicalbumlist']['record']['music_album_id']; ?>
" class="clsStrikeAddToCart"><a href="javascript:void(0)" class="clsStrikeAddToCart clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['musiclist_purchased']; ?>
"><?php echo $this->_tpl_vars['LANG']['musiclist_add_to_cart']; ?>
</a></p>
													<?php elseif ($this->_tpl_vars['musicalbumlist']['record']['album_for_sale'] == 'Yes' && isMember ( ) && ! isUserAlbumPurchased ( $this->_tpl_vars['musicalbumlist']['record']['music_album_id'] ) && $this->_tpl_vars['musicalbumlist']['record']['user_id'] != $this->_tpl_vars['CFG']['user']['user_id']): ?>
														<p id="add_cart_<?php echo $this->_tpl_vars['musicalbumlist']['record']['music_album_id']; ?>
" class="clsAddToCart"><a href="javascript:void(0)" onclick="updateAlbumCartCount('<?php echo $this->_tpl_vars['musicalbumlist']['record']['music_album_id']; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['musiclist_add_to_cart']; ?>
"><?php echo $this->_tpl_vars['LANG']['musiclist_add_to_cart']; ?>
</a></p>
                                                    <?php elseif ($this->_tpl_vars['musicalbumlist']['record']['album_for_sale'] == 'Yes' && ! isMember ( )): ?>
                                                    	<p id="add_cart_<?php echo $this->_tpl_vars['musicalbumlist']['record']['music_album_id']; ?>
" class="clsAddToCart"><a title="<?php echo $this->_tpl_vars['LANG']['musiclist_add_to_cart']; ?>
" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_add_cart_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->getUrl('albumlist','','','members','music'); ?>
');return false;"><?php echo $this->_tpl_vars['LANG']['musiclist_add_to_cart']; ?>
</a></p>
													<?php endif; ?>

													<?php if ($this->_tpl_vars['musicalbumlist']['record']['album_for_sale'] == 'Yes'): ?>
													<p class="clsMusicPriceContainer">
                                                    <?php echo $this->_tpl_vars['LANG']['musicalbumList_album_price']; ?>
 <span><?php echo $this->_tpl_vars['CFG']['currency']; ?>
<?php echo $this->_tpl_vars['musicalbumlist']['album_price']; ?>
</span>
													</p>
                                                    <?php endif; ?>

													
                                                                                                        <?php if ($this->_tpl_vars['musicalbumlist']['record']['user_id'] == $this->_tpl_vars['CFG']['user']['user_id']): ?>
                                                    <p class="clsManageAlbum"><a href="<?php echo $this->_tpl_vars['musicalbumlist']['getUrl_editAlbum_url']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['musicalbumList_manage_album']; ?>
"><?php echo $this->_tpl_vars['LANG']['musicalbumList_manage_album']; ?>
</a></p>
                                                    <?php endif; ?>
                                                    
												</div>

                                                <div class="clsContentDetails">
                                                    <p class="clsHeading">
                                                        <a  href="<?php echo $this->_tpl_vars['musicalbumlist']['getUrl_viewAlbum_url']; ?>
" title="<?php echo $this->_tpl_vars['musicalbumlist']['word_wrap_album_title']; ?>
"><?php echo $this->_tpl_vars['musicalbumlist']['word_wrap_album_title']; ?>
</a>

								    </p>
                                                    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('displaysonglist_block')): ?>
                                                        <?php echo $this->_tpl_vars['myobj']->displayAlbumSongList($this->_tpl_vars['musicalbumlist']['record']['music_album_id']); ?>

                                                    <?php else: ?>
                                                        <?php echo $this->_tpl_vars['myobj']->displayAlbumSongList($this->_tpl_vars['musicalbumlist']['record']['music_album_id'],true,3); ?>

                                                    <?php endif; ?>

                                                    <?php if ($this->_tpl_vars['musicalbumlist']['total_song'] >= 1): ?>
                                                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                                                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "albumSongList.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                                     <p><?php if ($this->_tpl_vars['musicalbumlist']['record']['total_plays'] <= 1): ?><?php echo $this->_tpl_vars['LANG']['musicalbumList_total_play']; ?>
:<?php else: ?><?php echo $this->_tpl_vars['LANG']['musicalbumList_total_plays']; ?>
:<?php endif; ?>&nbsp;<?php echo $this->_tpl_vars['musicalbumlist']['record']['total_plays']; ?>
&nbsp;|&nbsp;<?php if ($this->_tpl_vars['musicalbumlist']['record']['total_views'] <= 1): ?><?php echo $this->_tpl_vars['LANG']['musicalbumList_view']; ?>
:<?php else: ?><?php echo $this->_tpl_vars['LANG']['musicalbumList_plays']; ?>
:<?php endif; ?>&nbsp;<?php echo $this->_tpl_vars['musicalbumlist']['record']['total_views']; ?>
</p>
                                                    <?php endif; ?>
                                                </div>

                                       </div>
                                </div>
                                <?php endforeach; endif; unset($_from); ?>
                                <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                                <div id="bottomLinks" class="clsAudioPaging">
									<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                </div>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                        <div id="selMsgAlert">
                            <p><?php if ($_POST && $_POST['search']): ?><?php echo $this->_tpl_vars['LANG']['musicalbumList_no_records_found']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->musicalbumList_no_records_found; ?>
<?php endif; ?></p>
                        </div>
                    <?php endif; ?>
                        </div>
                    <?php endif; ?>
    </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>