<?php /* Smarty version 2.6.18, created on 2011-10-18 17:31:50
         compiled from html_header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'html_header.tpl', 271, false),)), $this); ?>

<?php echo $this->_tpl_vars['myobj']->getTpl('general','header.tpl'); ?>

<script type="text/javascript">
var photo_ajax_page_loading = '<img alt="<?php echo $this->_tpl_vars['LANG']['common_photo_loading']; ?>
" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/loader.gif" />';
var subscription_loader_image = '<div class=""><img alt="<?php echo $this->_tpl_vars['LANG']['common_photo_loading']; ?>
" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/loader.gif" /></div>';
var photo_site_url = '<?php echo $this->_tpl_vars['CFG']['site']['photo_url']; ?>
';
var photo_stack_confirmation_msg='<?php echo $this->_tpl_vars['LANG']['header_photo_stack_clear_confirmation_msg']; ?>
';
var photo_stack_ajax_url="<?php echo $this->_tpl_vars['myobj']->getUrl('photostackajax','','','root','photo'); ?>
";
var photo_count_sting=' <?php echo $this->_tpl_vars['LANG']['header_photo_stack_photo_count']; ?>
';
var photos_count_sting=' <?php echo $this->_tpl_vars['LANG']['header_photo_stack_photos_count']; ?>
';
var photos_no_stack_msg=' <?php echo $this->_tpl_vars['LANG']['header_photo_stack_no_photos_msg']; ?>
';
var quick_mix_photo_id_arr = new Array();
<?php if ($this->_tpl_vars['CFG']['admin']['photos']['movie_maker']): ?>
var movie_queue_photo_id_arr = new Array();
var movie_queue_added_already ='<?php echo $this->_tpl_vars['LANG']['common_movie_queue_added_already']; ?>
';
var movie_queue_added_success_msg ='<?php echo $this->_tpl_vars['LANG']['common_movie_queue_added_success_msg']; ?>
';
<?php endif; ?>
</script>
<script src="<?php echo $this->_tpl_vars['CFG']['site']['photo_url']; ?>
js/photoStack.js" type="text/javascript"></script>

	<?php echo $this->_tpl_vars['myobj']->populatePhotoJsVars(); ?>

<script src="<?php echo $this->_tpl_vars['CFG']['site']['photo_url']; ?>
js/functions.js" type="text/javascript"></script>


<div id="header" class="clsHeaderContainer">
    <div class="clsHeaderShadowImage">
        <div class="clsHeaderBlock">
            <div class="clsMainLogo">
                <h1>
                    <a href="<?php echo $this->_tpl_vars['header']->index_page_link; ?>
"><img src="<?php echo $this->_tpl_vars['header']->logo_url; ?>
" alt="<?php echo $this->_tpl_vars['CFG']['site']['name']; ?>
" title="<?php echo $this->_tpl_vars['CFG']['site']['name']; ?>
" /></a>
                </h1>
            </div>
            <div class="clsHeaderContents">
                <!-- Top header menu Begins -->
                <div class="clsTopHeaderLinks">
                	<?php echo $this->_tpl_vars['myobj']->getTpl('general','topMenu.tpl'); ?>

                </div>
                <!-- End of Top header menu -->
                <div class="clsTopHeader">
				
									<div class="cls468pxTopBanner">
						<div><?php getAdvertisement('top_banner_468x60') ?></div>
					</div>
								
				<div id="selRightHeader" class="clsSearchUploadContainer">
					<?php echo $this->_tpl_vars['myobj']->getTpl('general','topUpload.tpl'); ?>

					<?php echo $this->_tpl_vars['myobj']->getTpl('general','topSearch.tpl'); ?>

				</div>
				
              </div>
            </div>
            <div class="clsNavigationStatsContainer">
                <div class="clsMainNavMiddle">
                    <div class="clsMainNavLeft">
                        <div class="clsMainNavRight">
                            <!-- Start of Main Menu -->
                            <?php echo $this->_tpl_vars['myobj']->getTopMenu('general','mainMenu.tpl'); ?>

                            <!-- end of Main Menu -->
                            <!-- stats starts -->
                            <?php echo $this->_tpl_vars['header']->populateSiteStatistics(); ?>

                            <!-- stats ends -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


   	<?php if ($this->_tpl_vars['header']->isUserStyle()): ?>
    	<div class="clsBodyContent profileBodyContent">
    <?php else: ?>
		<div class="clsBodyContent">
	<?php endif; ?>

    <div class="clsOverflow">
	<div class="clsMainPhotosHeadLeft">
		<div class="clsMainPhotosHeadDetLeft">
			<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','','photo'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_index_photos']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_index_photos']; ?>
</a>
		</div>
		<div class="clsMainPhotosHeadDetRight">
			<p>
				<?php  echo getTotalPhotosInSite()  ?>
				<span><?php echo $this->_tpl_vars['LANG']['common_photo_total_photos']; ?>
,</span>
				<?php  echo getTotalPhotoSlidelistInSite()  ?>
				<span><?php echo $this->_tpl_vars['LANG']['common_photo_total_slidelists']; ?>
,</span>
				<?php  echo getPhotoRelatedStats()  ?>
				<span><?php echo $this->_tpl_vars['LANG']['common_photo_total_photo_views']; ?>
</span>
			</p>
		</div>
	</div>
	<div class="clsMainPhotosHeadRight">
           <div class="clsQuickMixLink">
               <?php if (isMember ( ) && $this->_tpl_vars['CFG']['admin']['photos']['allow_quick_mixs']): ?>
                    <div class="clsQuickMixLeft">
                        <div class="clsQuickMixRight">
                            <li class=""><a href="javascript:void(0)" onclick="quickMixPlayer();" title="<?php echo $this->_tpl_vars['LANG']['header_open_quick_mix']; ?>
"><?php echo $this->_tpl_vars['LANG']['header_open_quick_mix']; ?>
</a></li>
                        </div>
                    </div>
               <?php endif; ?>
           </div>
           <?php if (isMember ( )): ?>
	           <div class="clsMyMusicShortcut clsOverflow">
	            <ul>
	                <li class="selDropDownLink">
	                    <div class="clsMyPhotoShortcutLeft">
	                        <div class="clsMyPhotoShortcutRight">
	                            <a href="#" title="<?php echo $this->_tpl_vars['LANG']['my_photo_shortcuts']; ?>
"><?php echo $this->_tpl_vars['LANG']['my_photo_shortcuts']; ?>
</a>
	                        </div>
	                    </div>
	                    <ul class="clsMyshortcutDropdown">
						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'listdropdown_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
								                     	<?php if (isAllowedphotoUpload ( )): ?>
	                     		<li>
									<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photouploadpopup','','','members','photo'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['photo_shortcuts_upload_photo']; ?>
"><?php echo $this->_tpl_vars['LANG']['photo_shortcuts_upload_photo']; ?>
</a>
								</li>
							<?php endif; ?>
							<li>
								<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photolist','?pg=myphotos','myphotos/','members','photo'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['photo_shortcuts_myphotos']; ?>
"><?php echo $this->_tpl_vars['LANG']['photo_shortcuts_myphotos']; ?>
</a>
							</li>
							<li>
								<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photoslidelist','?pg=myslidelist','myslidelist/','members','photo'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['photo_shortcuts_myslidelist']; ?>
"><?php echo $this->_tpl_vars['LANG']['photo_shortcuts_myslidelist']; ?>
</a>
							</li>
							<li>
								<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('albumlist','?pg=myalbums','myalbums/','members','photo'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['photo_shortcuts_myphotoalbums']; ?>
"><?php echo $this->_tpl_vars['LANG']['photo_shortcuts_myphotoalbums']; ?>
</a>
							</li>
							<li>
								<a href="<?php  echo getUrl('peopleonphoto','?tagged_by='.$CFG['user']['user_name'].'&block=me', '?tagged_by='.$CFG['user']['user_name'].'&block=me','','photo') ?>" title="<?php echo $this->_tpl_vars['LANG']['photo_shortcuts_tagged_photos']; ?>
"><?php echo $this->_tpl_vars['LANG']['photo_shortcuts_tagged_photos']; ?>
</a>
							</li>
	                     	<?php if (isAllowedphotoUpload ( )): ?>
								<li>
									<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photodefaultsettings','','','members','photo'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['photo_shortcuts_photo_default_settings']; ?>
"><?php echo $this->_tpl_vars['LANG']['photo_shortcuts_photo_default_settings']; ?>
</a>
								</li>
							<?php endif; ?>
						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'listdropdown_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					</ul>
	                </li>
	            </ul>
	        </div>
	      <?php endif; ?>
   </div>
</div>
<div class="clsBreadcum">
	<p>
       <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','',''); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_photo_link_home']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_photo_link_home']; ?>
</a>
    	<?php if ($this->_tpl_vars['myobj']->_currentPage == 'index'): ?>
    		<span><?php echo $this->_tpl_vars['LANG']['common_photo_link_photo']; ?>
</span>
    	<?php else: ?>
	    	<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','','photo'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_photo_link_photo']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['common_photo_link_photo']; ?>
</span></a>
	        <?php if ($this->_tpl_vars['myobj']->_currentPage == 'photolist'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_photo_link_view_all_photo']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'photouploadpopup'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_photo_link_upload_photo']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'photoslidelist'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_photo_link_slide_list']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'photoslidelistmanage'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_photo_link_slidelist_manage']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'albumlist'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_photo_link_album_list']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'photoalbummanage'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_photo_link_photo_album_manage']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'photodefaultsettings'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_photo_link_photo_default_settings']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'managephotocomments'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_photo_link_manage_photo_comments']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'viewphoto'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_photo_link_view_photo']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'peopleonphoto'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_photo_link_tagged_photos']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'photocategory'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_photo_link_photo_categories']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'tags'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_photo_link_photo_tags']; ?>
</span>
	        <?php endif; ?>
	    <?php endif; ?>
	</p>
</div>

<?php if (! $this->_tpl_vars['myobj']->chkIsAllowedLeftMenu()): ?>
    <!--SIDEBAR-->
	  <div class="clsSideBar1Photo" id="sideBarPhoto">

      	<!--<div class="clsHeaderUpLoadPhoto">
               <div class="clsUploadPhotoButton">
                                <?php if (isAllowedPhotoUpload ( )): ?>
                <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photouploadpopup','','','members','photo'); ?>
"><span><?php echo $this->_tpl_vars['LANG']['common_photo_upload']; ?>
</span></a>
                <?php endif; ?>
                              </div>
        </div>-->

		 			<?php echo $this->_tpl_vars['myobj']->populateMemberDetail('photo'); ?>

		 
                <div class="clsSideBarContent clsCategoryHd">
          <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
             <div class="clsOverflow">
                <h3 id="photoCategoryHeader" class="clsSideBarLeftTitle clsPaddingLeft5">
                    <!--<a onClick="showPhotoSidebarTab('photoCategory','photoTags');">--><?php echo $this->_tpl_vars['LANG']['sidebar_genres_heading_label']; ?>
<!--</a>-->
                </h3>
            </div>
           <div  id="photoCategoryContent"> <?php echo $this->_tpl_vars['myobj']->populateGenres(); ?>
 </div>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
       </div>
       
              	<?php if ($this->_tpl_vars['myobj']->_currentPage == 'photolist'): ?>
   	   		<div class="cls336pxBanner">
       			<div><?php getAdvertisement('sidebanner1_336x280') ?></div>
   			</div>
   		<?php endif; ?>
  	   
	          <div class="clsSideBarContent clsCategoryHd">
            <div class="clsOverflow clsTagsHeading">
                <h3 id="photoTagsHeader" class="clsSideBarLeftTitle clsPaddingLeft5">
                    <!--<a onClick="showPhotoSidebarTab('photoTags','photoCategory');">--><?php echo $this->_tpl_vars['LANG']['sidebar_photo_tags_heading_label']; ?>
<!--</a> -->
                </h3>
             </div>

           <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

           <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'phototags_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                 <div  id="photoTagsContent"> <?php echo $this->_tpl_vars['myobj']->populateSidebarClouds('photo','photo_tags',20); ?>
 </div>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'phototags_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
         </div>
      
	  	  <?php if ($this->_tpl_vars['myobj']->_currentPage == 'photolist'): ?>
   	  	<div class="cls336pxBanner">
       		<div><?php getAdvertisement('sidebanner2_336x280') ?></div>
   		</div>
   	  <?php endif; ?>
  	  
	  </div>
    <!--end of SIDEBAR-->
<?php endif; ?>

<!-- Main -->
<div id="mainPhoto" class="<?php echo $this->_tpl_vars['CFG']['main']['class_name']; ?>
 <?php echo $this->_tpl_vars['header']->headerBlock['banner']['class']; ?>
">
<!-- Header ends -->

<?php if ($this->_tpl_vars['header']->chkIsProfilePage()): ?>
	<div class="clsProfilePageStyles">
<?php endif; ?>

<!-- logout confirmation starts -->
<div id="selLogoutMsgConfirm" class="clsPopupConfirmation" style="display:none;">
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupbox_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <p id="logoutMsgConfirmText"><?php echo $this->_tpl_vars['LANG']['header_logout_confirmation_msg']; ?>
</p>
      <form name="logoutMsgConfirmform" id="logoutMsgConfirmform" autocomplete="off">
        <input type="button" class="clsPopUpButtonSubmit" name="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
"
                  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="doLogout('<?php echo $this->_tpl_vars['header']->getUrl('logout','','','root'); ?>
')" />
        &nbsp;
        <input type="button" class="clsPopUpButtonReset" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
"
                  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideLogoutBlock()" />
      </form>
	  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupbox_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<!-- logout confirmation ends -->

<div id="selQuickslideMsgConfirm" class="clsPopupConfirmation" style="display:none;">
      <p id="quickSlideMsgConfirmText"></p>
      <form name="quickSlideMsgConfirmform" id="quickSlideMsgConfirmform" autocomplete="off">
        <input type="button" class="clsPopUpButtonSubmit" name="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
"
                  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="clearAllQuickSlide()" />
        &nbsp;
        <input type="button" class="clsPopUpButtonReset" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
"
                  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideQuickSlideBlock()" />
        <input type="hidden" name="quick_slide_clear_act" id="quick_slide_clear_act" />
      </form>
</div>