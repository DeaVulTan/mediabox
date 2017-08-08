<?php /* Smarty version 2.6.18, created on 2012-01-13 22:18:29
         compiled from html_header.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->getTpl('general','header.tpl'); ?>

<script type="text/javascript">
var blog_ajax_page_loading = '<img alt="<?php echo $this->_tpl_vars['LANG']['common_blog_loading']; ?>
" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
blog/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/loader.gif" />';
var blog_site_url = '<?php echo $this->_tpl_vars['CFG']['site']['blog_url']; ?>
';
</script>
<script src="<?php echo $this->_tpl_vars['CFG']['site']['blog_url']; ?>
js/jquery.fancybox.js" type="text/javascript"></script>

    
<script src="<?php echo $this->_tpl_vars['CFG']['site']['blog_url']; ?>
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
	<div class="clsHeadTopBlogLeft">
		<div class="clsBlogHeadDetailLeft">
			<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_header_home_blog_title']; ?>
</a>
		</div>
		<div class="clsBlogHeadDetailRight">
			<p>
				<?php echo $this->_tpl_vars['myobj']->indexPageTotalBlogsInSite(); ?>

				<span><?php echo $this->_tpl_vars['LANG']['common_header_home_blog_title']; ?>
,</span>
				<?php echo $this->_tpl_vars['myobj']->indexPageTotalPostsInSite(); ?>

				<span><?php echo $this->_tpl_vars['LANG']['common_header_home_posts_title']; ?>
</span>
			</p>
		</div>
	</div>
	<div class="clsHeadTopBlogRight">
	<div class="clsMyBlogShortcut clsOverflow">
	<div class="clsFloatRight">
		<ul>
			<li class="selDropDownLink">		
				<div class="clsMyBlogShortcutLeft">
					<div class="clsMyBlogShortcutRight">
						<a href="#"><?php echo $this->_tpl_vars['LANG']['common_header_home_my_shortcuts_title']; ?>
</a>
					</div>

				<ul class="clsMyshortcutDropdown">
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'blogdrop_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						<li>
							<?php if ($this->_tpl_vars['myobj']->chkBlogsAdded()): ?>
                             <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('manageblog','','','members','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_manage_edit_blog']; ?>
</a>
                             <?php else: ?>
                             <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('manageblog','','','members','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_manage_add_blog']; ?>
</a>
                             <?php endif; ?>
                         </li>
						 <?php if ($this->_tpl_vars['myobj']->chkBlogsAdded()): ?>
                        <li>
                             <a  href="<?php echo $this->_tpl_vars['myobj']->chkBlogsAdded(); ?>
"><?php echo $this->_tpl_vars['LANG']['common_manage_my_blog']; ?>
</a>
                        </li>
 						<?php endif; ?>
						<li>
							<a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('blogpostlist','?pg=myposts','myposts/','members','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_mypost_label']; ?>
</a>
						</li>
						<li>
							<a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('manageblogpost','','','members','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_blog_new_post']; ?>
</a>
                        </li>
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'blogdrop_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</ul>
				</div>
			</li>
		</ul>
		</div>
	</div>
  </div>
</div>
<div class="clsBreadcum">
		<ul>
			<li><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','',''); ?>
"><?php echo $this->_tpl_vars['LANG']['common_header_home_index_title']; ?>
</a></li>
			<?php if ($this->_tpl_vars['myobj']->_currentPage == 'index'): ?>
			<li><?php echo $this->_tpl_vars['LANG']['common_header_home_blog_title']; ?>
</li>
			<?php else: ?>
			<li><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('bloglist','','','','blog'); ?>
"> <?php echo $this->_tpl_vars['LANG']['common_header_home_blog_title']; ?>
</a></li>
			<?php if ($this->_tpl_vars['myobj']->_currentPage == 'managepostcomments'): ?>
			<li><?php echo $this->_tpl_vars['LANG']['common_blog_link_manage_post_comments']; ?>
</li>
			<?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'manageblog'): ?>
			<li><?php echo $this->_tpl_vars['LANG']['common_blog_link_manage_blog']; ?>
</li>
			<?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'blogpostlist'): ?>
			<li><?php echo $this->_tpl_vars['LANG']['common_blog_link_manage_blog_postlist']; ?>
</li>
			<?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'manageblogpost'): ?>
			<li><?php echo $this->_tpl_vars['LANG']['common_blog_link_manage_blog_post']; ?>
</li>
			<?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'blogcategory'): ?>
			<li><?php echo $this->_tpl_vars['LANG']['common_blog_link_manage_blog_category']; ?>
</li>
			<?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'tags'): ?>
			<li><?php echo $this->_tpl_vars['LANG']['common_blog_link_blog_tags']; ?>
</li>
			<?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'bloglist'): ?>
			<li><?php echo $this->_tpl_vars['LANG']['common_blog_link_blog_list']; ?>
</li>
			<?php endif; ?><?php endif; ?>
		</ul>
</div>
<?php if (! $this->_tpl_vars['myobj']->chkIsAllowedLeftMenu()): ?>
<!--SIDEBAR-->
<div class="clsOverflow">
<div id="sideBar">
  <!--SIDEBAR1-->
  <div class="sideBar1">
    <div class="clsSideBar1Blog" id="sideBarBlog">

		             <?php echo $this->_tpl_vars['myobj']->populateMyBlogDetail('blog'); ?>

         
        <?php if (isMember ( )): ?>
                     <?php echo $this->_tpl_vars['myobj']->populateMyBlogDashBoardDetail('blog'); ?>

                 <?php endif; ?>

                      <?php echo $this->_tpl_vars['myobj']->populateBlogCategory(); ?>

         
					 <?php if ($this->_tpl_vars['myobj']->_currentPage == 'index'): ?>
			   <div class="cls336pxBanner">
				   <div><?php getAdvertisement('sidebanner1_336x280') ?></div>
			   </div>
			  <?php endif; ?> 
			
                     <?php echo $this->_tpl_vars['myobj']->populateSidebarClouds('blog','blog_tags'); ?>

             </div>

     </div>
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