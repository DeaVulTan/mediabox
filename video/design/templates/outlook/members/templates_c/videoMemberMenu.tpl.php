<?php /* Smarty version 2.6.18, created on 2012-02-03 23:11:03
         compiled from videoMemberMenu.tpl */ ?>
<?php if (isLoggedin ( )): ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsSideBarLinks">
	<div class="clsSideBar">
    	<div class="clsOverflow">
            <p class="clsSideBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['header_nav_video_my_dash_board_videos']; ?>
</p>

        </div>
    	<div class="clsSideBarRight">
            <div class="clsSideBarContent">
                <ul>
                	<!--<li class="<?php echo $this->_tpl_vars['myobj']->getVideoNavClass('left_videouploadpopup'); ?>
"><a href="<?php  echo getUrl('videouploadpopup','','','members','video');  ?>"><?php echo $this->_tpl_vars['LANG']['header_nav_video_upload_my_video']; ?>
</a></li>-->
	                <li class="<?php echo $this->_tpl_vars['myobj']->getVideoNavClass('left_videolist_videonew'); ?>
"><a href="<?php  echo getUrl('videolist', '?pg=videonew', 'videonew/','','video');  ?>"><?php echo $this->_tpl_vars['LANG']['header_nav_video_all_videos']; ?>
</a></li>
                    <!--<li class="<?php echo $this->_tpl_vars['myobj']->getVideoNavClass('left_videolist_myvideos'); ?>
"><a href="<?php  echo getUrl('videolist', '?pg=myvideos', 'myvideos/','members','video');  ?>"><?php echo $this->_tpl_vars['LANG']['header_nav_video_my_videos']; ?>
</a></li>-->
                    <li class="<?php echo $this->_tpl_vars['myobj']->getVideoNavClass('left_videolist_myfavoritevideos'); ?>
">
                        <a href="<?php  echo getUrl('videolist', '?pg=myfavoritevideos', 'myfavoritevideos/','members','video');  ?>">
                        <?php echo $this->_tpl_vars['LANG']['header_nav_video_my_favorites']; ?>

                        </a>
                    </li>
                    <li class="<?php echo $this->_tpl_vars['myobj']->getVideoNavClass('left_myvideoalbums'); ?>
"><a href="<?php  echo getUrl('myvideoalbums','','','members','video')  ?>"><?php echo $this->_tpl_vars['LANG']['header_nav_video_my_video_albums']; ?>
</a></li>
                    <li class="<?php echo $this->_tpl_vars['myobj']->getVideoNavClass('left_managecomments'); ?>
">
                        <a href="<?php  echo getUrl('managecomments', '', '','members','video');  ?>"><?php echo $this->_tpl_vars['LANG']['header_nav_video_manage_video_comments']; ?>
</a>
                    </li>
                    <!--<li class="<?php echo $this->_tpl_vars['myobj']->getVideoNavClass('left_managevideoresponses'); ?>
"><a href="<?php  echo getUrl('managevideoresponses', '', '', 'members', 'video');  ?>"><?php echo $this->_tpl_vars['LANG']['header_lang_my_video_responses']; ?>
</a></li>-->
                    <?php if ($this->_tpl_vars['CFG']['user']['is_upload_background_image'] == 'Yes'): ?>
                     <li class="<?php echo $this->_tpl_vars['myobj']->getVideoNavClass('left_managebackground'); ?>
"><a href="<?php  echo getUrl('managebackground', '', '','members','video');  ?>"><?php echo $this->_tpl_vars['LANG']['header_nav_video_manage_background']; ?>
</a></li>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['header']->isAffiliateMember()): ?>
                    <li class="<?php echo $this->_tpl_vars['myobj']->getVideoNavClass('left_videoadvertisement'); ?>
"><a href="<?php  echo getUrl('videoadvertisement','','members','video');  ?>"><?php echo $this->_tpl_vars['LANG']['header_nav_video_manage_video_advertisemet']; ?>
</a></li>
                    <?php endif; ?>
                </ul>
            </div>
    	</div>
    </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->_currentPage != 'index'): ?>
<?php if ($this->_tpl_vars['CFG']['admin']['videos']['allow_quick_links'] || $this->_tpl_vars['CFG']['admin']['videos']['allow_play_list'] || $this->_tpl_vars['CFG']['admin']['videos']['allow_history_links']): ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsSideBarLinks">
	<div class="clsSideBar">
    	<div class="clsSideBarLeft">
            <p class="clsSideBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['header_nav_video_manage_video_my_playlist_quicklinks_title']; ?>
</p>
            </div>
    	<div class="clsSideBarRight">
        	<div class="clsSideBarContent">
    			<ul>
	<?php if ($this->_tpl_vars['CFG']['admin']['videos']['allow_play_list']): ?>
					<li class="<?php echo $this->_tpl_vars['myobj']->getVideoNavClass('left_videoplaylist'); ?>
"><a href="<?php  echo getUrl('videoplaylist', '', '', '', 'video');  ?>"><?php echo $this->_tpl_vars['LANG']['header_nav_video_manage_video_playlist_list']; ?>
</a></li>
                    <li class="<?php echo $this->_tpl_vars['myobj']->getVideoNavClass('left_videoplaylistmanage'); ?>
"><a href="<?php  echo getUrl('videoplaylistmanage', '', '', '', 'video'); ?>"><?php echo $this->_tpl_vars['LANG']['header_nav_video_manage_video_playlist']; ?>
</a></li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['CFG']['admin']['videos']['allow_quick_links']): ?>
                    <li class="<?php echo $this->_tpl_vars['myobj']->getVideoNavClass('left_mydashboard_ql'); ?>
"><a href="<?php  echo getUrl('mydashboard', '?block=ql', '?block=ql','','video'); ?>"><?php echo $this->_tpl_vars['LANG']['header_nav_video_manage_video_my_quicklinks']; ?>
</a></li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['CFG']['admin']['videos']['allow_history_links']): ?>
                    <li class="<?php echo $this->_tpl_vars['myobj']->getVideoNavClass('left_mydashboard_hst'); ?>
"><a href="<?php  echo getUrl('mydashboard', '?block=hst', '?block=hst','','video');  ?>"><?php echo $this->_tpl_vars['LANG']['header_nav_video_manage_video_my_views_histories']; ?>
</a>
                    </li>
                <?php endif; ?>
           		 </ul>
            </div>
    	</div>
    </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>

