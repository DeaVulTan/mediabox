<?php /* Smarty version 2.6.18, created on 2011-10-18 17:31:50
         compiled from populateMemberBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'populateMemberBlock.tpl', 5, false),array('modifier', 'cat', 'populateMemberBlock.tpl', 36, false),)), $this); ?>
<?php if ($this->_tpl_vars['opt'] == 'photo'): ?>
     <div class="clsSideBarContent clsCategoryHd">
	 		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div class="clsOverflow"><h3 class="clsSideBarLeftTitle"><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['sidebar_myphoto_dashboard_label'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 25) : smarty_modifier_truncate($_tmp, 25)); ?>
</h3></div>
                                   <div class="clsSideBarContent">
            <ul class="clsPhotoSidebarLinks">
              <?php $this->assign('css_temp', ''); ?>
                <?php if ($this->_tpl_vars['flag']): ?>
                    <?php $this->assign('css_temp', ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['myobj']->_currentPage)) ? $this->_run_mod_handler('cat', true, $_tmp, '_') : smarty_modifier_cat($_tmp, '_')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['myobj']->getFormField('pg')) : smarty_modifier_cat($_tmp, $this->_tpl_vars['myobj']->getFormField('pg')))); ?>
                <?php endif; ?>
                                               			    <li class="
                <?php if ($this->_tpl_vars['myobj']->_currentPage == 'managephotocomments'): ?>
                	<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_managephotocomments'); ?>

                <?php elseif ($this->_tpl_vars['css_temp'] == 'photolist_myphotos'): ?>
                	<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photolist_myphotos'); ?>

				<?php elseif ($this->_tpl_vars['css_temp'] == 'photolist_myfavoritephotos'): ?>
                	<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photolist_myfavoritephotos'); ?>

                <?php endif; ?>    clsHasSubMenu" >
                	<?php $this->assign('photo_count', 1); ?>
                     <table>
                        <tr>
                         <td class="clsPhotoLinks">
						 <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('photolist','?pg=myphotos','myphotos/','members','photo'); ?>
" onclick=""><?php echo $this->_tpl_vars['LANG']['sidebar_myphoto_label']; ?>
</a>
                         </td>
                          <td>
                          	<a <?php if ($this->_tpl_vars['myobj']->_currentPage == 'managephotocomments' || $this->_tpl_vars['css_temp'] == 'photolist_myphotos' || $this->_tpl_vars['css_temp'] == 'photolist_myfavoritephotos'): ?> class="clsHideSubmenuLinks" <?php else: ?> class="clsShowSubmenuLinks"<?php endif; ?> href="javascript:void(0)" id="mainphotoID<?php echo $this->_tpl_vars['photo_count']; ?>
" onClick="showHideMenu('ancPlaylist', 'subphotoID','1','<?php echo $this->_tpl_vars['photo_count']; ?>
', 'mainphotoID')"><?php echo $this->_tpl_vars['LANG']['sidebar_show_label']; ?>
</a>
                         </td>

                        </tr>
                    </table>
                    <ul  id="subphotoID<?php echo $this->_tpl_vars['photo_count']; ?>
" <?php if ($this->_tpl_vars['myobj']->_currentPage == 'managephotocomments' || $this->_tpl_vars['css_temp'] == 'photolist_myphotos' || $this->_tpl_vars['css_temp'] == 'photolist_myfavoritephotos'): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
						<li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photolist_myphotos'); ?>
">
							<a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('photolist','?pg=myphotos','myphotos/','members','photo'); ?>
" onclick=""><?php echo $this->_tpl_vars['LANG']['sidebar_myphoto_label']; ?>
</a>
						</li>
						<li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photolist_myfavoritephotos'); ?>
" ><a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('photolist','?pg=myfavoritephotos','myfavoritephotos/','members','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_favourite_photo_label']; ?>
</a></li>
						<li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_managephotocomments'); ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('managephotocomments','','','members','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_photo_comments_label']; ?>
  </a></li>

					</ul>
                </li>
				<!--li class="<?php if ($this->_tpl_vars['myobj']->_currentPage == 'photoslidelistmanage'): ?> <?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photoplaylistmanage'); ?>

                   <?php elseif ($this->_tpl_vars['css_temp'] == 'photoslidelist_myplaylist'): ?><?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photoslidelist_myplaylist'); ?>
<?php endif; ?>"-->
				<li class="<?php if ($this->_tpl_vars['myobj']->_currentPage == 'photoslidelistmanage'): ?>
                		   		<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photoslidelistmanage'); ?>

                   		   <?php else: ?>
                           		<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photoslidelist_myslidelist'); ?>

                           <?php endif; ?> clsHasSubMenu">
                <?php $this->assign('playlist_count', 1); ?>
                 <table>
                        <tr>
                         	<td class="clsPhotoLinks"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photoslidelist','?pg=myslidelist','myslidelist/','members','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_myslidelist_label']; ?>
 </a></td>
                        	<td><a <?php if ($this->_tpl_vars['myobj']->_currentPage == 'photoslidelistmanage' || $this->_tpl_vars['css_temp'] == 'photoslidelist_myslidelist'): ?> class="clsHideSubmenuLinks" <?php else: ?> class="clsShowSubmenuLinks"<?php endif; ?> href="javascript:void(0)" id="mainPlaylistID<?php echo $this->_tpl_vars['playlist_count']; ?>
" onClick="showHideMenu('ancPlaylist', 'subPlaylistID','1','<?php echo $this->_tpl_vars['playlist_count']; ?>
', 'mainPlaylistID')"><?php echo $this->_tpl_vars['LANG']['sidebar_show_label']; ?>
</a></td>
                        </tr>
                    </table>
                    <ul  id="subPlaylistID<?php echo $this->_tpl_vars['playlist_count']; ?>
" <?php if ($this->_tpl_vars['myobj']->_currentPage == 'photoslidelistmanage' || $this->_tpl_vars['css_temp'] == 'photoslidelist_myslidelist'): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
						<li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photoslidelist_myslidelist'); ?>
">
							<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photoslidelist','?pg=myslidelist','myslidelist/','members','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_myslidelist_label']; ?>
 </a>
						</li>
					  	<li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photoslidelistmanage'); ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photoslidelistmanage','','','members','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_manageplaylist_label']; ?>
 </a>
						</li>
				    </ul>
                </li>


                                <li class="<?php if ($this->_tpl_vars['myobj']->_currentPage == 'photoalbummanage'): ?>
                				<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photoalbummanage'); ?>

                           <?php else: ?>
                           		<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_albumlist_myalbums'); ?>

                           <?php endif; ?> clsHasSubMenu <?php if (! isMember ( )): ?>clsNoBorderBottom<?php endif; ?>">
                 <?php $this->assign('album_count', 1); ?>
                 	<table>
                    	<tr>
                        	<td class="clsTDLinks clsPhotoLinks">
                        		<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('albumlist','?pg=myalbums','myalbums/','members','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_manage_photo_albums']; ?>
 </a>
                        	</td>
                        	<td>
                            	<a id="ancAlbum<?php echo $this->_tpl_vars['album_count']; ?>
"  class="" title=""></a>
	                            <a <?php if ($this->_tpl_vars['css_temp'] == 'albumlist_myalbums' || $this->_tpl_vars['myobj']->_currentPage == 'photoalbummanage'): ?> class="clsHideSubmenuLinks" <?php else: ?> class="clsShowSubmenuLinks" <?php endif; ?> href="javascript:void(0)" id="mainAlbumID<?php echo $this->_tpl_vars['album_count']; ?>
" onClick="showHideMenu('ancAlbum', 'subAlbumID', '1', 'album_count', 'mainAlbumID') "><?php echo $this->_tpl_vars['LANG']['sidebar_show_label']; ?>
</a>
                        	</td>
                    	</tr>
                	</table>
                    <ul id="subAlbumID<?php echo $this->_tpl_vars['album_count']; ?>
" <?php if ($this->_tpl_vars['css_temp'] == 'albumlist_myalbums' || $this->_tpl_vars['myobj']->_currentPage == 'photoalbummanage'): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
                    	<li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_albumlist_myalbums'); ?>
" ><a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('albumlist','?pg=myalbums','myalbums/','members','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_album_label']; ?>
</a></li>
                        <li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photoalbummanage'); ?>
" ><a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('photoalbummanage','','','members','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_my_album_manage_label']; ?>
</a></li>
                    </ul>
				</li>
                
                                  <?php if ($this->_tpl_vars['CFG']['admin']['photos']['movie_maker']): ?>
                <li class="<?php if ($this->_tpl_vars['myobj']->_currentPage == 'createmovie'): ?>
                				<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_createmovie'); ?>

                           <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'photomoviemanage'): ?>
                           		<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photomoviemanage'); ?>

                           <?php else: ?>
                           		<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_movielist_mymovies'); ?>

                           <?php endif; ?> clsHasSubMenu <?php if (! isMember ( )): ?>clsNoBorderBottom<?php endif; ?>">
                 <?php $this->assign('movie_maker_count', 1); ?>
                 	<table>
                    	<tr>
                        	<td class="clsTDLinks clsPhotoLinks">
                        		<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('createmovie','','','members','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_moviemaker_title']; ?>
 </a>
                        	</td>
                        	<td>
                            	<a id="ancMoiveMaker<?php echo $this->_tpl_vars['movie_maker_count']; ?>
"  class="" title=""></a>
	                            <a <?php if ($this->_tpl_vars['css_temp'] == 'movielist_mymovies' || $this->_tpl_vars['myobj']->_currentPage == 'createmovie' || $this->_tpl_vars['myobj']->_currentPage == 'photomoviemanage'): ?> class="clsHideSubmenuLinks" <?php else: ?> class="clsShowSubmenuLinks" <?php endif; ?> href="javascript:void(0)" id="mainMoiveMakerID<?php echo $this->_tpl_vars['movie_maker_count']; ?>
" onClick="showHideMenu('ancMoiveMaker', 'subMoiveMakerID', '1', 'movie_maker_count', 'mainMoiveMakerID') "><?php echo $this->_tpl_vars['LANG']['sidebar_show_label']; ?>
</a>
                        	</td>
                    	</tr>
                	</table>
                    <ul id="subMoiveMakerID<?php echo $this->_tpl_vars['movie_maker_count']; ?>
" <?php if ($this->_tpl_vars['css_temp'] == 'movielist_mymovies' || $this->_tpl_vars['myobj']->_currentPage == 'createmovie' || $this->_tpl_vars['myobj']->_currentPage == 'photomoviemanage'): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
                    	<li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_createmovie'); ?>
" ><a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('createmovie','','','members','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_moviemaker_create_movie']; ?>
</a></li>
                        <li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_movielist_mymovies'); ?>
" ><a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('movielist','?pg=mymovies','mymovies/','members','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_moviemaker_my_movies']; ?>
</a></li>
                        <li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photomoviemanage'); ?>
" ><a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('photomoviemanage','','','members','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_moviemaker_manage_movies']; ?>
</a></li>
                    </ul>
				</li>
                <?php endif; ?>
                

				<?php if (isMember ( )): ?>
					                     <?php if (isAllowedphotoUpload ( )): ?>
                     <li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photouploadpopup'); ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photouploadpopup','','','members','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_photo_upload_label']; ?>
</a></li>
					 <li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photodefaultsettings'); ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photodefaultsettings','','','members','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_photo_default_settings_label']; ?>
</a></li>
					<?php endif; ?>
                    <li class="<?php if ($this->_tpl_vars['myobj']->_currentPage == 'peopleonphoto'): ?>
                				<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_peopleonphoto'); ?>
<?php endif; ?> clsHasSubMenu clsNoBorderBottom">
                <?php $this->assign('tagged_count', 1); ?>
                 <table>
                        <tr>
                         	<td class="clsPhotoLinks"><a href="<?php echo $this->_tpl_vars['populateMemberDetail_arr']['photosTaggedByMeUrl']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_photos_tagged_title']; ?>
</a></td>
                        	<td>
                            <a id="ancTagged<?php echo $this->_tpl_vars['tagged_count']; ?>
"  class="" title=""></a>
                            <a <?php if ($this->_tpl_vars['myobj']->_currentPage == 'peopleonphoto'): ?> class="clsHideSubmenuLinks" <?php else: ?> class="clsShowSubmenuLinks"<?php endif; ?> href="javascript:void(0)" id="mainTaggedID<?php echo $this->_tpl_vars['tagged_count']; ?>
" onClick="showHideMenu('ancTagged', 'subTaggedID','1','<?php echo $this->_tpl_vars['tagged_count']; ?>
', 'mainTaggedID')"><?php echo $this->_tpl_vars['LANG']['sidebar_show_label']; ?>
</a></td>
                        </tr>
                    </table>
                    <ul  id="subTaggedID<?php echo $this->_tpl_vars['tagged_count']; ?>
" <?php if ($this->_tpl_vars['myobj']->_currentPage == 'peopleonphoto'): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
                        <li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_peopleonphoto_me'); ?>
"><a href="<?php echo $this->_tpl_vars['populateMemberDetail_arr']['photosTaggedByMeUrl']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_photos_tagged_by_me']; ?>
</a>
                        </li>
						<li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_peopleonphoto_of'); ?>
"><a href="<?php echo $this->_tpl_vars['populateMemberDetail_arr']['taggedPhotosOfMeUrl']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_tagged_photos_of_me']; ?>
</a>
						</li>
					  	<li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_peopleonphoto_all'); ?>
"><a href="<?php echo $this->_tpl_vars['populateMemberDetail_arr']['allPhotoTagsUrl']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_all_photo_tags']; ?>
 </a>
						</li>
				    </ul>
                </li>
				<?php endif; ?>
		    </ul>
            </div>
            <input type="hidden" value="1" id="memberCount"  name="memberCount" >
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
<?php elseif ($this->_tpl_vars['opt'] == 'slidelist'): ?>
     <div class="clsSideBarContent clsCategoryHd" >
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="clsOverflow"><h3 class="clsSideBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['sidebar_playlist_quickmixblock_label']; ?>
</h3></div>
         <ul class="clsPhotoSidebarLinks clsOverflow clsPhotosLastLink">
			<li <?php if ($this->_tpl_vars['cid'] == 0): ?>class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photolist_photonew'); ?>
<?php else: ?>class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass(''); ?>
"<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photolist','?pg=photonew','photonew/','','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_allphotos_label']; ?>
 </a></li>
            <li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_photoslidelist_slidelistnew'); ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photoslidelist','?pg=slidelistnew','slidelistnew/','','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_playlist_label']; ?>
 </a></li>
			<li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_albumlist_albumlistnew'); ?>
"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('albumlist','?pg=albumlistnew','albumlistnew/','','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_album_list_label']; ?>
 </a></li>
            <?php if ($this->_tpl_vars['CFG']['admin']['photos']['movie_maker']): ?>
            <li class="<?php echo $this->_tpl_vars['myobj']->getPhotoNavClass('left_movielist_newmovies'); ?>
 clsNoBorderBottom"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('movielist','?pg=newmovies','newmovies/','','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_movie_list_label']; ?>
 </a></li>
            <?php endif; ?>
         </ul>
		 <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

         <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
<?php endif; ?>