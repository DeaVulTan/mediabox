<?php /* Smarty version 2.6.18, created on 2011-12-16 01:21:07
         compiled from html_header.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->getTpl('general','header.tpl'); ?>

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
	<div class="clsHeadTopDiscussLeft">
		<div class="clsDiscussHeadDetailLeft">

			<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','','discussions'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_boards']; ?>
</a>
		</div>
		<div class="clsDiscussHeadDetailRight">
			<p>

				<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('boards','?view=recent','recent/','','discussions'); ?>
"><?php echo $this->_tpl_vars['discussion']->getModuleTotalBoard(); ?>
</a> <span><?php echo $this->_tpl_vars['LANG']['boards']; ?>
,</span>
				<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('discussions','','','','discussions'); ?>
"><?php echo $this->_tpl_vars['discussion']->getModuleTotalDiscussion(); ?>
</a> <span><?php echo $this->_tpl_vars['LANG']['discussions']; ?>
,</span>
				<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('boards','?view=recentlysolutioned','recentlysolutioned/','','discussions'); ?>
"><?php echo $this->_tpl_vars['discussion']->getModuleTotalSolution(); ?>
</a> <span><?php echo $this->_tpl_vars['LANG']['solutions']; ?>
</span>
			</p>
		</div>
	</div>
	<div class="clsHeadTopDiscussRight">
    <?php echo $this->_tpl_vars['discussion']->showSolutionSearchOption(); ?>

	<?php echo $this->_tpl_vars['discussion']->showPostLinks(); ?>

    <?php echo $this->_tpl_vars['discussion']->showShortcutDetails(); ?>

	<div class="clsMyDiscussShortcut clsOverflow">
    <?php $this->assign('css_temp', ''); ?>
		<ul>
			<li class="selDropDownLink">
				<div class="clsMyDiscussShortcutLeft">
					<div class="clsMyDiscussShortcutRight">
						<a href="#">My Shortcuts</a>
					</div>
				</div>
				<ul class="clsMyshortcutDropdown">
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'musicdrop_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

						  <li class="clsProfileFav"><a href="<?php echo $this->_tpl_vars['showUserInfo_arr']['favorites_link']; ?>
"><?php echo $this->_tpl_vars['LANG']['header_total_favs']; ?>
 <span class="clsTotalPoints">(<?php echo $this->_tpl_vars['showUserInfo_arr']['favorites']; ?>
)</span></a></li>
						  <li class="clsProfilePosts"><a href="<?php echo $this->_tpl_vars['showUserInfo_arr']['total_postlink']; ?>
"><?php echo $this->_tpl_vars['LANG']['discuzz_common_boards']; ?>
 <span class="clsTotalPoints">(<?php echo $this->_tpl_vars['showUserInfo_arr']['userLog']['total_board']; ?>
)</span></a></li>
						  <li class="clsProfileEdit"><a href="<?php echo $this->_tpl_vars['showUserInfo_arr']['edit_info']; ?>
"><?php echo $this->_tpl_vars['LANG']['edit_info_text']; ?>
</a></li>

					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'musicdrop_bottom')));
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
		<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','','discussions'); ?>
" alt="<?php echo $this->_tpl_vars['LANG']['common_music_link_home']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_music_link_home']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_link_home']; ?>
</a>

		<?php if (isset ( $this->_tpl_vars['myobj']->category_titles ) && ( $this->_tpl_vars['myobj']->category_titles ) || $this->_tpl_vars['discussion']->chkIsBoardPage() || $this->_tpl_vars['discussion']->chkIsSolutionPage()): ?>

        	<?php if ($this->_tpl_vars['discussion']->chkIsBoardPage()): ?>
                <?php if (( $this->_tpl_vars['myobj']->getFormField('so') != 'adv' ) && ! $this->_tpl_vars['myobj']->getFormField('search_board')): ?>
                    <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('discussions','','','','discussions'); ?>
" alt="<?php echo $this->_tpl_vars['LANG']['discussions']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['discussions']; ?>
"><?php echo $this->_tpl_vars['LANG']['discussions']; ?>
</a>
                 <?php else: ?>
                    <?php echo $this->_tpl_vars['LANG']['discussions']; ?>

                <?php endif; ?>
            <?php else: ?>
            	<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('discussions','','','','discussions'); ?>
" alt="<?php echo $this->_tpl_vars['LANG']['discussions']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['discussions']; ?>
"><?php echo $this->_tpl_vars['LANG']['discussions']; ?>
</a>
            <?php endif; ?>
         <?php else: ?>
			<?php echo $this->_tpl_vars['LANG']['discussions']; ?>

         <?php endif; ?>
             <?php $this->assign('counter', 0); ?>
                <?php $this->assign('nextClass', ''); ?>
                <?php if (isset ( $this->_tpl_vars['myobj']->category_titles ) && ( $this->_tpl_vars['myobj']->category_titles )): ?>
                    <?php $_from = $this->_tpl_vars['myobj']->category_titles; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ckey'] => $this->_tpl_vars['cat_value']):
?>
                        <?php $this->assign('counter', $this->_tpl_vars['counter']+1); ?>
                        <?php if ($this->_tpl_vars['counter'] > 4): ?>
                            <?php if (( $this->_tpl_vars['cat_value']['cat_url'] )): ?> <?php echo $this->_tpl_vars['cat_value']['cat_url']; ?>
<?php endif; ?>
                            <?php $this->assign('counter', 0); ?>
                            <?php $this->assign('nextClass', 'clsNextClass'); ?>
                        <?php else: ?>
                            <?php if (( $this->_tpl_vars['cat_value']['cat_url'] )): ?> <?php echo $this->_tpl_vars['cat_value']['cat_url']; ?>
<?php endif; ?>
                            <?php if ($this->_tpl_vars['nextClass'] != ''): ?><?php $this->assign('nextClass', ''); ?><?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                 <?php endif; ?>
                     <?php if ($this->_tpl_vars['discussion']->chkIsBoardPage()): ?>
                        <?php if ($this->_tpl_vars['myobj']->getFormField('cid')): ?>
                            <?php if (( $this->_tpl_vars['myobj']->navigation_details['discussion_url'] )): ?> <?php echo $this->_tpl_vars['myobj']->navigation_details['discussion_url']; ?>
<?php endif; ?>
                            <?php echo $this->_tpl_vars['myobj']->board_details['board_title']; ?>

                        <?php else: ?>
                            <?php if (isset ( $this->_tpl_vars['myobj']->discussion_details ) && ( $this->_tpl_vars['myobj']->discussion_details )): ?>  <span><?php echo $this->_tpl_vars['myobj']->discussion_details['discussion_title']; ?>
</span><?php endif; ?>
                        <?php endif; ?>
                     <?php endif; ?>
                     <?php if ($this->_tpl_vars['discussion']->chkIsSolutionPage()): ?>
                       <?php if (( $this->_tpl_vars['myobj']->navigation_details['discussion_url'] )): ?>   <?php echo $this->_tpl_vars['myobj']->navigation_details['discussion_url']; ?>
<?php endif; ?>
                       <?php if (( $this->_tpl_vars['myobj']->navigation_details['navigation_board_title'] )): ?> <span><?php echo $this->_tpl_vars['myobj']->navigation_details['navigation_board_title']; ?>
</span><?php endif; ?>
                    <?php endif; ?>
					</p>
</div>
<?php if (! $this->_tpl_vars['discussion']->chkIsSolutionPage()): ?>
    <!--SIDEBAR-->
    <div id="sideBar">
        <!--SIDEBAR1-->
        <div class="sideBar1" id="sideBar1">

			<?php if ($this->_tpl_vars['discussion']->chkIsIndexPage()): ?>
            	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_recent_activities')): ?>
              <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','discussions'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sidebar_whatsgoing_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
              <div class="clsWhatsGoingOnContainer"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "indexActivityHead.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
			  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','discussions'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sidebar_whatsgoing_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
              <?php endif; ?>
             <?php endif; ?>
            <?php echo $this->_tpl_vars['header']->populateTopContributorsRightNavigation(); ?>

            <?php echo $this->_tpl_vars['header']->displayFeaturedMemberRightNavigation(); ?>

            <?php echo $this->_tpl_vars['discussion']->rightBarSettings(); ?>

            <?php if ($this->_tpl_vars['discussion']->chkIsBoardPage()): ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "showLegends.tpl", 'smarty_include_vars' => array('opt' => 'musicdrop_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>

						 <?php if ($this->_tpl_vars['myobj']->_currentPage == 'index'): ?>
			   <div class="cls336pxBanner">
				   <div><?php getAdvertisement('sidebanner1_336x280') ?></div>
			   </div>
			  <?php endif; ?>
			
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