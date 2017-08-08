<?php /* Smarty version 2.6.18, created on 2011-10-17 14:55:34
         compiled from populateMemberBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'populateMemberBlock.tpl', 9, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['opt'] == 'music'): ?>
     <div class="clsAudioIndex clsCategoryHd clsIndexMyMusicContainer">
            <h3><?php echo $this->_tpl_vars['LANG']['sidebar_mymusic_dashboard_label']; ?>
</h3>
            <ul class="clsOverflow" >
              <?php $this->assign('css_temp', ''); ?>
                <?php if ($this->_tpl_vars['flag']): ?>
                    <?php $this->assign('css_temp', ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['myobj']->_currentPage)) ? $this->_run_mod_handler('cat', true, $_tmp, '_') : smarty_modifier_cat($_tmp, '_')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['myobj']->getFormField('pg')) : smarty_modifier_cat($_tmp, $this->_tpl_vars['myobj']->getFormField('pg')))); ?>
                <?php endif; ?>
                                <?php if (isAllowedMusicUpload ( )): ?>
                <li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musicuploadpopup'); ?>
" ><a  class="clsUploadOptionLink" href="<?php echo $this->_tpl_vars['myobj']->getUrl('musicuploadpopup','','','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_uploadaudio_label']; ?>
</a></li>
				<?php endif; ?>
                				<li class="
                <?php if ($this->_tpl_vars['myobj']->_currentPage == 'managemusiccomments'): ?>
                	<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_managemusiccomments'); ?>

                <?php elseif ($this->_tpl_vars['css_temp'] == 'musiclist_mymusics'): ?>
                	<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musiclist_mymusics'); ?>

                <?php elseif ($this->_tpl_vars['css_temp'] == 'musiclist_myfavoritemusics'): ?>
                	<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musiclist_myfavoritemusics'); ?>

                <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'mymusictracker'): ?>
                	<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_mymusictracker'); ?>

                <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'manageartistphoto'): ?>
                	<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_manageartistphoto'); ?>

                <?php endif; ?> " >
                	<?php $this->assign('music_count', 1); ?>


					<div class="clsOverflow">
                            <span class="clsTDLinks clsSidelinkLeft">
                                            			<?php if (isAllowedMusicUpload ( )): ?>
								<a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('musiclist','?pg=mymusics','mymusics/','members','music'); ?>
" onclick=""> <?php echo $this->_tpl_vars['LANG']['sidebar_music_label']; ?>
 </a>
                            <?php else: ?>
                            	<a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('musiclist','?pg=myfavoritemusics','myfavoritemusics/','members','music'); ?>
" onclick="" title="<?php echo $this->_tpl_vars['LANG']['sidebar_music_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_music_label']; ?>
</a>
                            <?php endif; ?>
							</span>
								<span class="clsSidelinkRight">
							<a <?php if ($this->_tpl_vars['myobj']->_currentPage == 'managemusiccomments' || $this->_tpl_vars['css_temp'] == 'musiclist_mymusics' || $this->_tpl_vars['css_temp'] == 'musiclist_myfavoritemusics' || $this->_tpl_vars['myobj']->_currentPage == 'mymusictracker' || $this->_tpl_vars['myobj']->_currentPage == 'manageartistphoto'): ?> class="clsHideSubmenuLinks" <?php else: ?> class="clsShowSubmenuLinks"<?php endif; ?> href="javascript:void(0)" id="mainMusicID<?php echo $this->_tpl_vars['music_count']; ?>
" onclick="showHideMenu('ancPlaylist', 'subMusicID','1','<?php echo $this->_tpl_vars['music_count']; ?>
', 'mainMusicID')"><?php echo $this->_tpl_vars['LANG']['sidebar_show_label']; ?>
</a>
                            </span>
                       </div>
                    <?php /*?><ul  id="subMusicID<?php echo $this->_tpl_vars['music_count']; ?>
" <?php if ($this->_tpl_vars['myobj']->_currentPage == 'managemusiccomments' || $this->_tpl_vars['css_temp'] == 'musiclist_mymusics' || $this->_tpl_vars['css_temp'] == 'musiclist_myfavoritemusics' || $this->_tpl_vars['myobj']->_currentPage == 'mymusictracker' || $this->_tpl_vars['myobj']->_currentPage == 'manageartistphoto'): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
                                        		<?php if (isAllowedMusicUpload ( )): ?>
							<li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musiclist_mymusics'); ?>
"><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_music_label']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->getUrl('musiclist','?pg=mymusics','mymusics/','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_music_label']; ?>
  </a></li>
	                        <li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_managemusiccomments'); ?>
"><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_music_comments_label']; ?>
 " href="<?php echo $this->_tpl_vars['myobj']->getUrl('managemusiccomments','','','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_music_comments_label']; ?>
  </a></li>
                        <?php endif; ?>
						<li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musiclist_myfavoritemusics'); ?>
" ><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_favourite_label']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->getUrl('musiclist','?pg=myfavoritemusics','myfavoritemusics/','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_favourite_label']; ?>
</a></li>
                        <?php if (isMember ( )): ?>
							<li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_mymusictracker'); ?>
"><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_music_viewing_histry_label']; ?>
 " href="<?php echo $this->_tpl_vars['myobj']->getUrl('mymusictracker','','','','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_music_viewing_histry_label']; ?>
 </a></li>
                    	<?php endif; ?>
                    	<?php if (checkValidArtist ( ) && $this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature']): ?>
       	            	<li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_manageartistphoto'); ?>
"><a href="<?php echo $this->_tpl_vars['populateMemberDetail_arr']['artist_member_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_manage_artist_link_label']; ?>
 </a></li>
                    	<?php endif; ?>
					</ul><?php */?>
                </li>
                                <?php if (isAllowedMusicUpload ( )): ?>
                                <li class="<?php if ($this->_tpl_vars['myobj']->_currentPage == 'musicalbummanage'): ?>
                				<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musicalbummanage'); ?>

                           <?php else: ?>
                           		<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_albumlist_myalbums'); ?>

                           <?php endif; ?>"><?php $this->assign('album_count', 1); ?>
              <div class="clsOverflow">
                            <span class="clsTDLinks clsSidelinkLeft">
                        <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('albumlist','?pg=myalbums','myalbums/','members','music'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['sidebar_album_manage_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_album_manage_label']; ?>
 </a>
                       </span>
                        <span class="clsSidelinkRight">
                            <a id="ancAlbum<?php echo $this->_tpl_vars['album_count']; ?>
"  class="" title=""></a>

                              <a <?php if ($this->_tpl_vars['css_temp'] == 'albumlist_myalbums' || $this->_tpl_vars['css_temp'] == 'musicalbummanage'): ?> class="clsHideSubmenuLinks" <?php else: ?> class="clsShowSubmenuLinks" <?php endif; ?> href="javascript:void(0)" id="mainAlbumID<?php echo $this->_tpl_vars['album_count']; ?>
" onclick="showHideMenu('ancAlbum', 'subAlbumID', '1', 'album_count', 'mainAlbumID') " title="$LANG.sidebar_show_label}"><?php echo $this->_tpl_vars['LANG']['sidebar_show_label']; ?>
</a>
                        </span>
                    </div>
                        <ul id="subAlbumID<?php echo $this->_tpl_vars['album_count']; ?>
" <?php if ($this->_tpl_vars['css_temp'] == 'albumlist_myalbums' || $this->_tpl_vars['myobj']->_currentPage == 'musicalbummanage'): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
                            <li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_albumlist_myalbums'); ?>
" ><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_album_label']; ?>
"  href="<?php echo $this->_tpl_vars['myobj']->getUrl('albumlist','?pg=myalbums','myalbums/','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_album_label']; ?>
</a></li>
                            <li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musicalbummanage'); ?>
" ><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_music_my_album_manage_label']; ?>
"  href="<?php echo $this->_tpl_vars['myobj']->getUrl('musicalbummanage','','','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_music_my_album_manage_label']; ?>
</a></li>
                        </ul>

				</li>
				<?php endif; ?>
				<li class="<?php if ($this->_tpl_vars['myobj']->_currentPage == 'musicplaylistmanage'): ?> <?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musicplaylistmanage'); ?>

                <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'manageplaylistcomments'): ?> <?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_manageplaylistcomments'); ?>

                <?php elseif ($this->_tpl_vars['css_temp'] == 'musicplaylist_myfavoriteplaylist'): ?> <?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musicplaylist_myfavoriteplaylist'); ?>


                <?php elseif ($this->_tpl_vars['css_temp'] == 'musicplaylist_myplaylist'): ?><?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musicplaylist_myplaylist'); ?>
<?php endif; ?>">
                <?php $this->assign('playlist_count', 1); ?>
               <div class="clsOverflow">
                            <span class="clsTDLinks clsSidelinkLeft">
                        <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylist','?pg=myplaylist','myplaylist/','members','music'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['sidebar_myplaylist_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_myplaylist_label']; ?>
 </a>
                       </span>
                       <span class="clsSidelinkRight">
                            <a id="ancPlaylist<?php echo $this->_tpl_vars['playlist_count']; ?>
" title=""></a>
                            <a <?php if ($this->_tpl_vars['myobj']->_currentPage == 'musicplaylistmanage' || $this->_tpl_vars['myobj']->_currentPage == 'manageplaylistcomments' || $this->_tpl_vars['css_temp'] == 'musicplaylist_myfavoriteplaylist'): ?> class="clsHideSubmenuLinks" <?php else: ?> class="clsShowSubmenuLinks"<?php endif; ?> href="javascript:void(0)" id="mainPlaylistID<?php echo $this->_tpl_vars['playlist_count']; ?>
" onclick="showHideMenu('ancPlaylist', 'subPlaylistID','1','<?php echo $this->_tpl_vars['playlist_count']; ?>
', 'mainPlaylistID')"><?php echo $this->_tpl_vars['LANG']['sidebar_show_label']; ?>
</a>
                       </span>
                    </div>
                    <ul  id="subPlaylistID<?php echo $this->_tpl_vars['playlist_count']; ?>
" <?php if ($this->_tpl_vars['myobj']->_currentPage == 'musicplaylistmanage' || $this->_tpl_vars['myobj']->_currentPage == 'manageplaylistcomments' || $this->_tpl_vars['css_temp'] == 'musicplaylist_myfavoriteplaylist'): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
                        <li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musicplaylistmanage'); ?>
"><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_music_manageplaylist_label']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylistmanage','','','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_music_manageplaylist_label']; ?>
 </a></li>
                        <li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_manageplaylistcomments'); ?>
"><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_music_playlist_comments_label']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->getUrl('manageplaylistcomments','','','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_music_playlist_comments_label']; ?>
 </a></li>
						<?php if (isMember ( ) && $this->_tpl_vars['myobj']->getMyFeaturedPlaylist($this->_tpl_vars['CFG']['user']['user_id'])): ?>
							<li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_viewplaylist'); ?>
"><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_myfeaturedplaylist_label']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->getMyFeaturedPlaylist($this->_tpl_vars['CFG']['user']['user_id']); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_myfeaturedplaylist_label']; ?>
 </a></li>
						<?php endif; ?>
						<li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musicplaylist_myfavoriteplaylist'); ?>
" ><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_favourite_label']; ?>
"  href="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylist','?pg=myfavoriteplaylist','myfavoriteplaylist/','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_favourite_label']; ?>
</a></li>
                    </ul>
                </li>
               
				<?php if (isMember ( )): ?>
					 <!--li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_mymusictracker_musictracker'); ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mymusictracker','?pg=musictracker','musictracker/','','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_viewing_histry_label']; ?>
 </a></li-->
					                      <?php if (isAllowedMusicUpload ( )): ?>
						 <li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musicdefaultsettings'); ?>
"><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_music_default_settings_label']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->getUrl('musicdefaultsettings','','','','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_music_default_settings_label']; ?>
 </a></li>
						 <?php if (isset ( $this->_tpl_vars['CFG']['admin']['musics']['allowed_usertypes_to_upload_for_sale'] ) && $this->_tpl_vars['CFG']['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None'): ?>
						 	<li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_transactionlist'); ?>
"><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_transaction_list_label']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->getUrl('transactionlist','','','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_transaction_list_label']; ?>
 </a></li>
						 <?php endif; ?>
					 <?php endif; ?>
					 <?php if (isset ( $this->_tpl_vars['CFG']['admin']['musics']['allowed_usertypes_to_upload_for_sale'] ) && $this->_tpl_vars['CFG']['admin']['musics']['allowed_usertypes_to_upload_for_sale'] != 'None'): ?>
					 	<li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_listenertransactionlist'); ?>
"><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_listener_transaction_list_label']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->getUrl('listenertransactionlist','','','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_listener_transaction_list_label']; ?>
 </a></li>
					 <?php endif; ?>
				<?php endif; ?>
		    </ul>
            <input type="hidden" value="1" id="memberCount"  name="memberCount" />
        </div>
<?php elseif ($this->_tpl_vars['opt'] == 'playlist'): ?>
     <div class="clsAudioIndex clsCategoryHd" >
        <h3><?php echo $this->_tpl_vars['LANG']['sidebar_music_playlist_quickmixblock_label']; ?>
</h3>
         <ul class="clsSiderbarMusicContainer clsOverflow">
			<li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musiclist_musicnew'); ?>
"><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_allmusics_label']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->getUrl('musiclist','?pg=musicnew','musicnew/','','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_allmusics_label']; ?>
 </a></li>
            <li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musicplaylist_playlistnew'); ?>
"><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_music_playlist_label']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylist','?pg=playlistnew','playlistnew/','','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_music_playlist_label']; ?>
 </a></li>
			<li class="<?php if ($this->_tpl_vars['myobj']->_currentPage == 'albumsortlist'): ?>
							<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_albumsortlist'); ?>

			           <?php else: ?>
			           		<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_albumlist_albumlistnew'); ?>

			           <?php endif; ?>"><?php $this->assign('album_sort_count', 1); ?>
					 <div class="clsOverflow">
                            <span class="clsTDLinks clsSidelinkLeft">
					        <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('albumsortlist','','','','music'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['sidebar_album_list_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_album_list_label']; ?>
 </a>
					       </span>
					        <span class="clsSidelinkRight">
					            <a id="ancSortAlbum<?php echo $this->_tpl_vars['album_sort_count']; ?>
"  class="" title=""></a>

					              <a <?php if ($this->_tpl_vars['css_temp'] == 'albumlist_albumlistnew' || $this->_tpl_vars['css_temp'] == 'albumsortlist'): ?> class="clsHideSubmenuLinks" <?php else: ?> class="clsShowSubmenuLinks" <?php endif; ?> href="javascript:void(0)" id="mainSortAlbumID<?php echo $this->_tpl_vars['album_sort_count']; ?>
" onclick="showHideMenu('ancSortAlbum', 'subAlbumSortID', '1', 'album_sort_count', 'mainSortAlbumID') "><?php echo $this->_tpl_vars['LANG']['sidebar_show_label']; ?>
</a>
					       </span>
					    </div>
			        <ul id="subAlbumSortID<?php echo $this->_tpl_vars['album_sort_count']; ?>
" <?php if ($this->_tpl_vars['css_temp'] == 'albumlist_albumlistnew' || $this->_tpl_vars['myobj']->_currentPage == 'albumsortlist'): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
			            <li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_albumsortlist'); ?>
" ><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_alphabetical_album_label']; ?>
"  href="<?php echo $this->_tpl_vars['myobj']->getUrl('albumsortlist','','','','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_alphabetical_album_label']; ?>
</a></li>
			            <li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_albumlist_albumlistnew'); ?>
" ><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_normal_album_label']; ?>
"  href="<?php echo $this->_tpl_vars['myobj']->getUrl('albumlist','?pg=albumlistnew','albumlistnew/','','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_normal_album_label']; ?>
</a></li>
			        </ul>

			</li>
			<?php if (isset ( $this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature'] ) && $this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature']): ?>
			<li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_artistmemberslist'); ?>
">
			<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('artistmemberslist','','','','music'); ?>
">
			<?php else: ?>
			<li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_artistlist'); ?>
">
			<a class="clsUploadOptionLink" href="<?php echo $this->_tpl_vars['myobj']->getUrl('artistlist','','','','music'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['sidebar_artist_list_label']; ?>
"><?php endif; ?><?php echo $this->_tpl_vars['LANG']['sidebar_artist_list_label']; ?>
</li></a>
         </ul>
        </div>
<?php endif; ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>