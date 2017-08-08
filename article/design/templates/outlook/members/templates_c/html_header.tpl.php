<?php /* Smarty version 2.6.18, created on 2011-10-18 14:49:59
         compiled from html_header.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->getTpl('general','header.tpl'); ?>

<script type="text/javascript">
var article_ajax_page_loading = '<img alt="<?php echo $this->_tpl_vars['LANG']['common_article_loading']; ?>
" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
article/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/loader.gif" />';
var article_site_url = '<?php echo $this->_tpl_vars['CFG']['site']['article_url']; ?>
';
</script>
<script src="<?php echo $this->_tpl_vars['CFG']['site']['article_url']; ?>
js/jquery.fancybox.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['CFG']['site']['article_url']; ?>
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

<div class="clsBredcumHeader">
	<div class="clsMainArticleHeadLeft">
		<div class="clsMainArticleHeadDetLeft">
			<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_count_articles']; ?>
</a>
		</div>
		<div class="clsMainArticleHeadDetRight">
			<p>
            	<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlelist','?pg=articlenew','articlenew/','','article'); ?>
"><?php echo $this->_tpl_vars['myobj']->articleTotalCount(); ?>
</a>
                <span><?php echo $this->_tpl_vars['LANG']['myhome_count_articles']; ?>
 </span>
			</p>
		</div>
	</div>
	<div class="clsMainArticleHeadRight">
	           <div class="clsMyArticleShortcut clsOverflow">
	            <ul>
	                <li class="selDropDownLink">
	                    <div class="clsMyArticlehortcutLeft">
	                        <div class="clsMyArticlehortcutRight">
	                            <a href="#"><?php echo $this->_tpl_vars['LANG']['common_article_head_article_shortcuts']; ?>
</a>
	                        </div>
	                    </div>
	                    <ul class="clsMyshortcutDropdown">
						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'listdropdown_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
							<li>
								<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlewriting','','','','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_article_head_upload_article']; ?>
</a>
							</li>
							<li>
								<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlelist','?pg=articlenew','articlenew/','','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_article_head_all_article']; ?>
</a>
							</li>

							<li>
								<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlelist','?pg=myarticles','myarticles/','','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_article_head_my_article']; ?>
</a>
							</li>
                            <li>
                                <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('managearticlecomments','','','','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_article_head_manage_article_comments']; ?>
</a>
                            </li>
						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'listdropdown_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						</ul>
	                </li>
	            </ul>
	        </div>
   </div>
</div>
<div class="clsBreadcum">
	<p>
		<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','',''); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_article_link_home']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_article_link_home']; ?>
</a>
    	<?php if ($this->_tpl_vars['myobj']->_currentPage == 'index'): ?>
    		<span><?php echo $this->_tpl_vars['LANG']['common_article_link_article']; ?>
</span>
    	<?php else: ?>
	    	<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','','article'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_article_link_article']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['common_article_link_article']; ?>
</span></a>
	        <?php if ($this->_tpl_vars['myobj']->_currentPage == 'articlelist'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_article_link_view_all_article']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'articlewriting'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_article_link_upload_article']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'manageattachments'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_article_link_article_attachments']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'viewarticle'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_article_link_view_article']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'managearticlecomments'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_article_link_manage_article_comments']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'articlecategory'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_article_link_article_categories']; ?>
</span>
	        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'tags'): ?>
	        	<span><?php echo $this->_tpl_vars['LANG']['common_article_link_article_tags']; ?>
</span>
	        <?php endif; ?>
	    <?php endif; ?>
	</p>
</div>


<?php if (! $this->_tpl_vars['myobj']->chkIsAllowedLeftMenu()): ?>
    <!--SIDEBAR-->

<!--SIDEBAR-->
<div id="sideBar">
  <!--SIDEBAR1-->
  <div class="sideBar1">
    <div class="clsSideBar1Article" id="sideBarArticle">

				<?php if ($this->_tpl_vars['myobj']->_currentPage == 'index'): ?>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

        <div class="clsIndexMainContainer"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "indexActivityHead.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
        <?php endif; ?>
		
		
                     <?php echo $this->_tpl_vars['myobj']->populateMemberDetail('article'); ?>

         
         <?php if ($this->_tpl_vars['myobj']->_currentPage == 'index'): ?>
                                    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('sidebar_topcontributors_block')): ?>
                        <?php echo $this->_tpl_vars['myobj']->topWritters(); ?>

                    <?php endif; ?>
                        <?php endif; ?>

                      <?php echo $this->_tpl_vars['myobj']->populateGenres(); ?>

         
		 		 <?php if ($this->_tpl_vars['myobj']->_currentPage == 'index'): ?>
		   <div class="cls336pxBanner">
			   <div><?php getAdvertisement('sidebanner1_336x280') ?></div>
		   </div>
		  <?php endif; ?> 
		 
                      	<?php echo $this->_tpl_vars['myobj']->populateSidebarClouds('article','article_tags'); ?>

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