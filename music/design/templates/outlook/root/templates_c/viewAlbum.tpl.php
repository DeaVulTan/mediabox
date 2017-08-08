<?php /* Smarty version 2.6.18, created on 2011-12-23 23:56:48
         compiled from viewAlbum.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'viewAlbum.tpl', 11, false),array('modifier', 'truncate', 'viewAlbum.tpl', 41, false),)), $this); ?>
<div id="selViewAlbum">
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
				<table summary="<?php echo $this->_tpl_vars['LANG']['viewalbumlist_confirm_tbl_summary']; ?>
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
							<input type="hidden" name="music_id" id="music_id" />
							<input type="hidden" name="album_id" id="album_id" />
							<input type="hidden" name="action" id="action" />
													</td>
					</tr>
				</table>
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
	<div class="clsViewPlaylistLeftContent">
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('viewAlbum_information_block')): ?>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<div class="clsStatisticsContainer">
			<h3 class="clsH3Heading"><?php echo $this->_tpl_vars['viewAlbumInformation']['album_title']; ?>
</h3>
				<div class="clsOverflow">
					<div class="clsAlbumLeftImage">
						<?php if ($this->_tpl_vars['viewAlbumInformation']['music_path'] != ''): ?>
						<div class="clsLargeThumbImageBackground clsNoLink clsMarginTop10">
						  <p class="ClsImageContainer ClsImageBorder1 Cls132x88">
								<img src="<?php echo $this->_tpl_vars['viewAlbumInformation']['music_path']; ?>
"  title="<?php echo $this->_tpl_vars['viewAlbumInformation']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['viewAlbumInformation']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(134,90,$this->_tpl_vars['viewAlbumInformation']['thumb_width'],$this->_tpl_vars['viewAlbumInformation']['thumb_height']); ?>
/>
						  </p>
						</div>
						<?php else: ?>
						<div class="clsLargeThumbImageBackground clsNoLink clsMarginTop10">
						  <div class="ClsImageContainer ClsImageBorder1 Cls132x88">
							   <img width="132" height="88" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_T.jpg" title="<?php echo $this->_tpl_vars['viewAlbumInformation']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['viewAlbumInformation']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
"/>
						  </div>
						</div>
						<?php endif; ?>
					</div>
					<div class="clsAlbumRightCart">
						<div class="clsAlbumStatisticsTable">
							<table>
								<tr>
									<td class="clsLabel"><span><?php echo $this->_tpl_vars['LANG']['viewalbumlist_plays_label']; ?>
</span>
									:&nbsp;<?php echo $this->_tpl_vars['myobj']->getViewAlbumPlaysTotal($this->_tpl_vars['viewAlbumInformation']['music_album_id']); ?>
</td>
								</tr>
								<tr>
									<td class="clsLabel"><span><?php echo $this->_tpl_vars['LANG']['viewalbumlist_tracks_label']; ?>
</span>
									:&nbsp;<?php echo $this->_tpl_vars['myobj']->getViewAlbumSongTotal($this->_tpl_vars['viewAlbumInformation']['music_album_id']); ?>
</td>
								</tr>
								<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('viewAlbum_tags_block')): ?>
								<tr>
									<td class="clsAlbumTags">
									<p><?php echo $this->_tpl_vars['LANG']['viewalbumlist_artist_label']; ?>

									<?php $this->assign('i', '1'); ?>
									:<?php $_from = $this->_tpl_vars['displayViewAlbum']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicKey'] => $this->_tpl_vars['musicValue']):
?>
									<?php if ($this->_tpl_vars['myobj']->getArtistLink($this->_tpl_vars['musicValue']['music_artist'],true)): ?>
									   <?php echo $this->_tpl_vars['myobj']->getArtistLink($this->_tpl_vars['musicValue']['music_artist'],true); ?>

									   <?php if ($this->_tpl_vars['lastData'] != $this->_tpl_vars['i']): ?>, <?php endif; ?>
									<?php endif; ?>
									<?php $this->assign('i', $this->_tpl_vars['i']+1); ?>
									<?php endforeach; endif; unset($_from); ?></p>
									</td>
								</tr>
								<?php endif; ?>
								<?php if ($this->_tpl_vars['viewAlbumInformation']['album_for_sale'] == 'Yes'): ?>
								<tr>
									<td><p class="clsMusicPriceContainer clsBorderRightMusicPrice"><?php echo $this->_tpl_vars['LANG']['common_album_price']; ?>
 <span><?php echo $this->_tpl_vars['CFG']['currency']; ?>
<?php echo $this->_tpl_vars['viewAlbumInformation']['album_price']; ?>
</span></p>
										<div class="clsAddToCartContainer">
											<?php if ($this->_tpl_vars['viewAlbumInformation']['user_id'] != $this->_tpl_vars['CFG']['user']['user_id'] && isUserAlbumPurchased ( $this->_tpl_vars['viewAlbumInformation']['music_album_id'] ) && isMember ( )): ?>
												<p class="clsStrikeAddToCart"><a href="javascript:void(0)" class="clsStrikeAddToCart clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['musiclist_purchased']; ?>
"><?php echo $this->_tpl_vars['LANG']['musiclist_add_to_cart']; ?>
</a></p>
											<?php elseif ($this->_tpl_vars['viewAlbumInformation']['user_id'] != $this->_tpl_vars['CFG']['user']['user_id'] && ! isUserAlbumPurchased ( $this->_tpl_vars['viewAlbumInformation']['music_album_id'] ) && isMember ( )): ?>
												<p class="clsAddToCart"><a href="javascript:void(0)" onClick="updateAlbumCartCount('<?php echo $this->_tpl_vars['myobj']->getFormField('album_id'); ?>
')" title="<?php echo $this->_tpl_vars['LANG']['musiclist_add_to_cart']; ?>
"><?php echo $this->_tpl_vars['LANG']['musiclist_add_to_cart']; ?>
</a></p>
											<?php elseif (! isMember ( )): ?>
												<p class="clsAddToCart"><a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_add_cart_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->is_not_member_url; ?>
');return false;"><?php echo $this->_tpl_vars['LANG']['musiclist_add_to_cart']; ?>
</a></p>
											<?php endif; ?>
										</div>
									</td>
								</tr>
								<?php endif; ?>
							 </table>
						</div>
					</div>

				</div>
		</div>
	    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('viewAlbum_tags_block')): ?>
			<div class="clsTagsTable">
					<table>
						<tr>
							<td class="clsLabel"><span><?php echo $this->_tpl_vars['LANG']['viewalbumlist_tags_label']; ?>
</span></td>
							<td>: &nbsp; <?php $_from = $this->_tpl_vars['displayViewAlbum']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicKey'] => $this->_tpl_vars['musicValue']):
?>
							<?php echo $this->_tpl_vars['myobj']->getMusicTagsLinks($this->_tpl_vars['musicValue']['music_tags'],2); ?>
  <?php endforeach; endif; unset($_from); ?></td>
						</tr>
					</table>
			</div>
			<!--<div class="clsPlaylistDescriptionBox">
					<p><strong><?php echo $this->_tpl_vars['LANG']['viewalbumlist_artist_label']; ?>
</strong></p>
					<p><?php echo $this->_tpl_vars['myobj']->getArtistLink($this->_tpl_vars['musicValue']['music_artist'],true); ?>
</p>
			</div>-->
		<?php endif; ?>
		<p id="anchor_id"></p>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
	</div>

		        </div>

		<!-- PLAYLIST INFORMATION BLOCK END-->
	<!-- PLAYLIST SONG LIST BLOCK END -->
    <div class="clsViewPlaylistRightContent clsViewPlayListPageContainer">
    <!-- ALBUM SONG LIST BLOCK START -->
          <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('album_songlist_block')): ?>
            				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <div class="clsIndexAudioHeading">
                <h3 class="clsH3Heading">
                    <?php echo $this->_tpl_vars['LANG']['viewAlbum_title']; ?>

                </h3>
                <!--<div id="albumSongs_Head" class="clsAudioCarouselPaging"  style="display:none" >
                </div>-->
                </div>
                <?php echo $this->_tpl_vars['myobj']->populatePlaylist(); ?>
 
                <div id="albumInSongList">
                </div>
                <div  id="loaderMusics" style="display:none">
            	<div class="clsLoader">
                <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/loader.gif" alt="<?php echo $this->_tpl_vars['LANG']['viewAlbum_loading']; ?>
"/><?php echo $this->_tpl_vars['LANG']['viewAlbum_loading']; ?>

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
                    musicAlbumAjaxPaging(\'?ajax_page=true&page=pagenation&album_id='; ?>
<?php echo $this->_tpl_vars['viewAlbumInformation']['music_album_id']; ?>
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
        <!-- ALBUM SONG LIST BLOCK END -->
    </div>
</div>
