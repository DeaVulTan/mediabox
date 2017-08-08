<?php /* Smarty version 2.6.18, created on 2012-02-15 11:36:11
         compiled from html_header.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->getTpl('general','header.tpl'); ?>

<iframe name="facebook_logout" id="facebook_logout" style="display:none"></iframe>
<script type="text/javascript">
var loader_image = '<div class="clsLoader"><img src="<?php echo $this->_tpl_vars['CFG']['site']['video_url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/loader.gif" alt="<?php echo $this->_tpl_vars['LANG']['common_loading']; ?>
"/><?php echo $this->_tpl_vars['LANG']['common_loading']; ?>
</div>';
var subscription_loader_image = '<div class=""><img src="<?php echo $this->_tpl_vars['CFG']['site']['video_url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/loader.gif" alt="<?php echo $this->_tpl_vars['LANG']['common_loading']; ?>
"/></div>';

</script>
<script src="<?php echo $this->_tpl_vars['CFG']['site']['video_url']; ?>
js/jquery.fancybox.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['CFG']['site']['video_url']; ?>
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
<div class="clsVideoTopHeadingDetails">
	<div class=" clsOverflow">
	<div class="clsFloatLeft">
		<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','','video'); ?>
"><h3 class="clsFloatLeft"><?php echo $this->_tpl_vars['LANG']['common_video_index_title']; ?>
</h3></a>
		<div class="clsMusicHeadDetailRight">
			<p>
				<?php echo $this->_tpl_vars['myobj']->indexPageTotalVideosInSite(); ?>

				<span><?php echo $this->_tpl_vars['LANG']['common_video_total_tracks']; ?>
, </span>

				<?php echo $this->_tpl_vars['myobj']->indexPageTotalVideoWatched(); ?>

				<span><?php echo $this->_tpl_vars['LANG']['common_video_total_watched']; ?>
, </span>

				<?php echo $this->_tpl_vars['myobj']->indexPageTotalVideoDownload(); ?>

				<span><?php echo $this->_tpl_vars['LANG']['common_video_total_downloads']; ?>
</span>
			</p>
		</div>
	</div>
	<div class="clsOverflow">
	<ul class="clsDropDownRight">
	<li class="selDropDownLink clsWidth200">
	<div class="clsMyshortPopRight">
		<div class="clsMyShortCutLeft">
			<div class="clsMyShortCutRight">
				<a href="#"><?php echo $this->_tpl_vars['LANG']['my_video_shortcuts']; ?>
</a>

			</div>
		</div><ul class="clsMyshortcutDropdown clsFloatRight">
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'musicdrop_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						<li>
							<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('videouploadpopup','','','members','video'); ?>
"><?php echo $this->_tpl_vars['LANG']['video_shortcuts_uploadvideo']; ?>
</a>
						</li>
						<li>
							<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('videolist','?pg=myvideos','myvideos/','members','video'); ?>
"><?php echo $this->_tpl_vars['LANG']['video_shortcuts_myvideos']; ?>
</a>
						</li>fgfgfg
						<li>
							<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('videolist','?pg=myfavoritevideos','myfavoritevideos/','members','video'); ?>
"> <?php echo $this->_tpl_vars['LANG']['header_nav_video_my_favorites']; ?>
</a>
						</li>
						<li>
							<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('videoplaylist','','','','video'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_video_manage_video_my_playlist']; ?>
</a>
						</li>
						<li>
							<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mydashboard','?block=ql','?block=ql','','video'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_video_manage_video_my_quicklinks']; ?>
</a>
						</li>
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'musicdrop_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</ul>
	</div>

				</li></ul>
	</div>
	</div>
	<div class="clsBreadcum">
		<ul>
			<li><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','',''); ?>
"><?php echo $this->_tpl_vars['LANG']['common_video_home_title']; ?>
</a></li>
			<?php if ($this->_tpl_vars['myobj']->_currentPage == 'index'): ?>
			<li><?php echo $this->_tpl_vars['LANG']['common_video_link_video']; ?>
</li>
            <?php else: ?>
            <li><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','','video'); ?>
 "><?php echo $this->_tpl_vars['LANG']['common_video_link_video']; ?>
</a></li>
			<?php if ($this->_tpl_vars['myobj']->_currentPage == 'videouploadpopup'): ?>
	        <li><?php echo $this->_tpl_vars['LANG']['common_video_link_upload_video']; ?>
</li>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'videolist'): ?>
        	 <li><?php echo $this->_tpl_vars['LANG']['common_video_link_view_all_video']; ?>
</li>
        	<?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'myvideoalbums'): ?>
        	 <li><?php echo $this->_tpl_vars['LANG']['common_video_link_myvideo_album']; ?>
</li>
        	<?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'managecomments'): ?>
        	 <li><?php echo $this->_tpl_vars['LANG']['common_video_link_manage_video_comments']; ?>
</li>
        	<?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'managevideoresponses'): ?>
        	 <li><?php echo $this->_tpl_vars['LANG']['common_video_link_manage_video_response']; ?>
</li>
        	<?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'managebackground'): ?>
        	 <li><?php echo $this->_tpl_vars['LANG']['common_video_link_manage_video_manage_background']; ?>
</li>
        	<?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'videoplaylist'): ?>
        	 <li><?php echo $this->_tpl_vars['LANG']['common_video_link_manage_video_playlist']; ?>
</li>
        	<?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'videoplaylistmanage'): ?>
        	 <li><?php echo $this->_tpl_vars['LANG']['common_video_link_manage_video_playlist_manage']; ?>
</li>
        	<?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'mydashboard'): ?>
        	 <li><?php echo $this->_tpl_vars['LANG']['common_video_link_manage_video_my_quicklinks']; ?>
</li>
	        <?php endif; ?>
			<?php endif; ?>
		</ul>
	</div>
</div>
    <?php if (! $this->_tpl_vars['myobj']->chkIsAllowedLeftMenu()): ?>
    <!--SIDEBAR-->
        <div class="sideBar1">

                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>


        <?php echo $this->_tpl_vars['myobj']->populateVideoMemberMenu(); ?>

        <?php echo $this->_tpl_vars['myobj']->populateVideoChannelsRightNavigation(); ?>

		
					<?php if ($this->_tpl_vars['myobj']->_currentPage == 'videolist'): ?>
				<div class="cls336pxBanner">
					<div><?php getAdvertisement('sidebanner1_336x280') ?></div>
				</div>
			<?php endif; ?>
	   	
		
        <?php echo $this->_tpl_vars['myobj']->populateVideoTagsRightNavigation(); ?>


        </div>
    <!--end of SIDEBAR-->
    <?php endif; ?>

<!-- Main -->
<div id="main" class="<?php echo $this->_tpl_vars['CFG']['main']['class_name']; ?>
 <?php echo $this->_tpl_vars['header']->headerBlock['banner']['class']; ?>
">
<!-- Header ends -->

<?php if ($this->_tpl_vars['header']->chkIsProfilePage()): ?>
	<div class="clsProfilePageStyles">
<?php endif; ?>
