<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:36
         compiled from html_header.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->getTpl('general','header.tpl'); ?>

<iframe name="facebook_logout" id="facebook_logout" style="display:none"></iframe>

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
<!-- Header ends -->

<!--body content starts-->
   	<?php if ($this->_tpl_vars['header']->isUserStyle()): ?>
    	<div class="clsBodyContent profileBodyContent">
    <?php else: ?>
		<div class="clsBodyContent">
	<?php endif; ?>
    
 <?php if ($this->_tpl_vars['header']->chkIsAllMemberPage()): ?>   
        <div class="clsOverflow">
            <div class="clsMainModuleHeadLeft">
                <div class="clsMainModuleHeadDetLeft">
                    <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('memberslist','','','',''); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_member']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_member']; ?>
</a>
                </div>
                <div class="clsMainModuleHeadDetRight">
                    <p>
                       <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('memberslist','','?browse=viewAllMembers','',''); ?>
"> <?php echo $this->_tpl_vars['header']->getTotalMembers(); ?>
</a><span> <?php echo $this->_tpl_vars['LANG']['common_member_total']; ?>
,</span> 
                       <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('memberslist','','?browse=onlineMembers','',''); ?>
"> <?php echo $this->_tpl_vars['header']->getTotalOnlineMembers(); ?>
</a><span> <?php echo $this->_tpl_vars['LANG']['common_member_online']; ?>
</span> 
                    </p>
                </div>
            </div>
        </div>
        <div class="clsModuleBreadcum">
            <p>
                <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','',''); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_home']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_home']; ?>
</a>
				<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('memberslist','','','',''); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_member']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['common_member']; ?>
</span></a>
            </p>
        </div>
<?php endif; ?>

 <?php if ($this->_tpl_vars['header']->chkIsAllMailPage()): ?>   
        <div class="clsOverflow clsModuleMail">
            <div class="clsMainModuleHeadLeft">
                <div class="clsMainModuleHeadDetLeft">
                    <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mail','','','',''); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_mail']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_mail']; ?>
</a>
                </div>
                <div class="clsMainModuleHeadDetRight">
                    <p>
                      <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mail','?folder=inbox','inbox/'); ?>
"> <?php echo $this->_tpl_vars['myobj']->countUnReadMail(); ?>
</a><span> <?php echo $this->_tpl_vars['LANG']['common_mail_new']; ?>
,</span>
                      <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mail','?folder=request','request/'); ?>
"> <?php echo $this->_tpl_vars['myobj']->countUnReadMailByType('Request'); ?>
</a><span> <?php echo $this->_tpl_vars['LANG']['common_mail_request']; ?>
</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="clsModuleBreadcum">
            <p>
                <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','',''); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_home']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_home']; ?>
</a>
                <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mail','','','',''); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_mail']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['common_mail']; ?>
</span></a>
            </p>
        </div>
<?php endif; ?>

 <?php if ($this->_tpl_vars['header']->chkIsAllFriendPage()): ?>   
        <div class="clsOverflow clsModuleFriends">
            <div class="clsMainModuleHeadLeft">
                <div class="clsMainModuleHeadDetLeft">
                    <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('myfriends','','','',''); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_friend']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_friend']; ?>
</a>
                </div>
                <div class="clsMainModuleHeadDetRight">
                    <p>
                       <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('myfriends','','','',''); ?>
"> <?php echo $this->_tpl_vars['header']->getTotalFriendsNew(); ?>
</a><span> <?php echo $this->_tpl_vars['LANG']['common_friend_total']; ?>
,</span> 
                       <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mail','?folder=request','request/'); ?>
"> <?php echo $this->_tpl_vars['header']->newMail; ?>
</a><span> <?php echo $this->_tpl_vars['LANG']['common_friend_request']; ?>
</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="clsModuleBreadcum">
            <p>
                <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','',''); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_home']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_home']; ?>
</a>
                <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('myfriends','','','',''); ?>
"  title="<?php echo $this->_tpl_vars['LANG']['common_friend']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['common_friend']; ?>
</span></a>
            </p>
        </div>
<?php endif; ?>

 <?php if ($this->_tpl_vars['header']->chkIsAllProfilePage()): ?>   
        <div class="clsOverflow clsModuleProfile">
            <div class="clsMainModuleHeadLeft">
                <div class="clsMainModuleHeadDetLeft">
                    <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('profilebasic','','','',''); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_profile']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_profile']; ?>
</a>
                </div>
                <div class="clsMainModuleHeadDetRight">
                    <p>
                      <?php echo $this->_tpl_vars['header']->populateSiteUserStatistics(); ?>
 <?php unset($this->_sections['count']);
$this->_sections['count']['name'] = 'count';
$this->_sections['count']['loop'] = is_array($_loop=$this->_tpl_vars['userstatistics']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['count']['show'] = true;
$this->_sections['count']['max'] = $this->_sections['count']['loop'];
$this->_sections['count']['step'] = 1;
$this->_sections['count']['start'] = $this->_sections['count']['step'] > 0 ? 0 : $this->_sections['count']['loop']-1;
if ($this->_sections['count']['show']) {
    $this->_sections['count']['total'] = $this->_sections['count']['loop'];
    if ($this->_sections['count']['total'] == 0)
        $this->_sections['count']['show'] = false;
} else
    $this->_sections['count']['total'] = 0;
if ($this->_sections['count']['show']):

            for ($this->_sections['count']['index'] = $this->_sections['count']['start'], $this->_sections['count']['iteration'] = 1;
                 $this->_sections['count']['iteration'] <= $this->_sections['count']['total'];
                 $this->_sections['count']['index'] += $this->_sections['count']['step'], $this->_sections['count']['iteration']++):
$this->_sections['count']['rownum'] = $this->_sections['count']['iteration'];
$this->_sections['count']['index_prev'] = $this->_sections['count']['index'] - $this->_sections['count']['step'];
$this->_sections['count']['index_next'] = $this->_sections['count']['index'] + $this->_sections['count']['step'];
$this->_sections['count']['first']      = ($this->_sections['count']['iteration'] == 1);
$this->_sections['count']['last']       = ($this->_sections['count']['iteration'] == $this->_sections['count']['total']);
?>                
        <?php echo $this->_tpl_vars['userstatistics'][$this->_sections['count']['index']]['value']; ?>
<span> <?php echo $this->_tpl_vars['userstatistics'][$this->_sections['count']['index']]['lang']; ?>
, </span> <?php endfor; endif; ?> <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('myfriends','','','members'); ?>
"><?php echo $this->_tpl_vars['header']->getTotalFriendsNew(); ?>
</a> <span><?php echo $this->_tpl_vars['LANG']['common_total_friend']; ?>
,</span> <a href="<?php echo $this->_tpl_vars['profileCommentURL']; ?>
"><?php echo $this->_tpl_vars['header']->getTotalComments(); ?>
</a> <span><?php echo $this->_tpl_vars['LANG']['common_total_comments']; ?>
</span> 
                    </p>
                </div>
            </div>
        </div>
        <div class="clsModuleBreadcum">
            <p>
                <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','',''); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_home']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_home']; ?>
</a>
                <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('profilebasic','','','',''); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_profile']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['common_profile']; ?>
</span></a>
            </p>
        </div>
<?php endif; ?>

<?php if (! $this->_tpl_vars['header']->headerBlock['left_menu_display']): ?>
<!--SIDEBAR-->
<div id="sideBar">
  <!--SIDEBAR1-->
  <div class="sideBar1">
    <?php echo $this->_tpl_vars['header']->populateProfileRightNavigation(); ?>

    <?php echo $this->_tpl_vars['header']->populateTopContributorsRightNavigation(); ?>

    <?php echo $this->_tpl_vars['header']->displayFeaturedMemberRightNavigation(); ?>

    <?php echo $this->_tpl_vars['header']->populateMailRightNavigation(); ?>

    <?php echo $this->_tpl_vars['header']->populateRelationRightNavigation(); ?>

	
			<?php if ($this->_tpl_vars['header']->chkIsAllMemberPage() || $this->_tpl_vars['header']->chkIsNoSidebarPage()): ?>   
			<div class="cls336pxBanner"><?php getAdvertisement('sidebanner1_336x280') ?></div>
			<div class="cls336pxBanner"><?php getAdvertisement('sidebanner2_336x280') ?></div>
        <?php elseif ($this->_tpl_vars['header']->chkIsAllMailPage() || $this->_tpl_vars['header']->chkIsAllFriendPage() || $this->_tpl_vars['header']->chkIsAllProfilePage()): ?>
        	<div class="cls336pxBanner"><?php getAdvertisement('sidebanner1_336x280') ?></div>
		<?php endif; ?> 
	  
	 
  </div>
</div>
<!--end of SIDEBAR-->
<?php endif; ?>
<!-- Main  starts-->
<div id="main" class="<?php echo $this->_tpl_vars['CFG']['main']['class_name']; ?>
 <?php echo $this->_tpl_vars['header']->headerBlock['banner']['class']; ?>
">

<?php if ($this->_tpl_vars['header']->chkIsProfilePage()): ?>
	<div class="clsProfilePageStyles">
<?php endif; ?>