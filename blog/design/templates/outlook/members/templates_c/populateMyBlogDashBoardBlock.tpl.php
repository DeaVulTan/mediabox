<?php /* Smarty version 2.6.18, created on 2011-10-18 14:49:56
         compiled from populateMyBlogDashBoardBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'populateMyBlogDashBoardBlock.tpl', 4, false),)), $this); ?>
<?php if ($this->_tpl_vars['opt'] == 'blog'): ?>
			<?php $this->assign('css_temp', ''); ?>
             <?php if ($this->_tpl_vars['myobj']->_currentPage == 'blogpostlist'): ?>
                    <?php $this->assign('css_temp', ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['myobj']->_currentPage)) ? $this->_run_mod_handler('cat', true, $_tmp, '_') : smarty_modifier_cat($_tmp, '_')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['myobj']->getFormField('pg')) : smarty_modifier_cat($_tmp, $this->_tpl_vars['myobj']->getFormField('pg')))); ?>
             <?php endif; ?>
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        <p class="
            <?php if ($this->_tpl_vars['myobj']->_currentPage == 'managepostcomments'): ?>
                <?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_managepostcomments'); ?>

            <?php elseif ($this->_tpl_vars['css_temp'] == 'blogpostlist_myposts'): ?>
                <?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_blogpostlist_myposts'); ?>

            <?php elseif ($this->_tpl_vars['css_temp'] == 'blogpostlist_myfavoriteposts'): ?>
                <?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_blogpostlist_myfavoriteposts'); ?>

            <?php endif; ?>    " ></p>
                        <div class="clsSideBarLeft">
                            <p class="clsSideBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['common_sidebar_myblog_dashboard_label']; ?>
</p>
                        </div>

                <div class="clsSideBarRight clsNoPadding">
            <?php if (! isMember ( )): ?>
           <div class="clsblogMemberContainer clsNoBorder">
           	<div class="clsblogMemberDetails">
            	<p class="clsSignUpLink">
                	<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('signup'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_signup_label']; ?>
</a>&nbsp; <?php echo $this->_tpl_vars['LANG']['common_or_label']; ?>
 &nbsp;<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('login'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_login_label']; ?>
</a>
                </p>
           	</div>
           </div>
           <?php endif; ?>
            <?php $this->assign('blog_count', 1); ?>
                   <div class="clsDashBoardBlock">
						<ul class="clsMyBlogListing" id="subblogID<?php echo $this->_tpl_vars['blog_count']; ?>
">
                            <li class="<?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_manageblog'); ?>
 <?php if ($this->_tpl_vars['myobj']->_currentPage == 'manageblog'): ?>clsActiveLink<?php endif; ?>" >
                            <?php if ($this->_tpl_vars['populateMyBlogDetail_arr']['check_blog_added']): ?>
                             <table>
							 	<tr>
									<td colspan="2" class="clsBlogLinksDashboard"><a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('manageblog','','','members','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_manage_edit_blog']; ?>
</a></td>

								</tr>
							</table>
                             <?php else: ?>
                               <table>
							 	<tr>
									<td colspan="2" class="clsBlogLinksDashboard"><a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('manageblog','','','members','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_manage_add_blog']; ?>
</a></td>
								</tr>
							</table>
                             <?php endif; ?>
                            </li>
                             <?php if ($this->_tpl_vars['populateMyBlogDetail_arr']['check_blog_added']): ?>
                             <li class="<?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_viewblog'); ?>
 <?php if ($this->_tpl_vars['myobj']->_currentPage == 'viewblog'): ?>clsActiveLink<?php endif; ?>" >
                                  <table>
							 	<tr>
									<td colspan="2" class="clsBlogLinksDashboard"><a  href="<?php echo $this->_tpl_vars['populateMyBlogDetail_arr']['my_blog_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_manage_my_blog']; ?>
</a></td>
								</tr>
							</table>
                            </li>
                             <?php endif; ?>

                            <li class="<?php if ($this->_tpl_vars['myobj']->_currentPage == 'myposts' || $this->_tpl_vars['css_temp'] == 'blogpostlist_draftposts' || $this->_tpl_vars['css_temp'] == 'blogpostlist_notapproved' || $this->_tpl_vars['css_temp'] == 'blogpostlist_infutureposts' || $this->_tpl_vars['css_temp'] == 'blogpostlist_publishedposts' || $this->_tpl_vars['css_temp'] == 'blogpostlist_toactivate' || $this->_tpl_vars['css_temp'] == 'blogpostlist_myfavoriteposts'): ?>clsActiveLink<?php else: ?><?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_blogpostlist_myposts'); ?>
<?php endif; ?> clsBlogSubMenu">
                                 <table>
							 	<tr>
									<td class="clsBlogLinksDashboard"><a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('blogpostlist','?pg=myposts','myposts/','members','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_mypost_label']; ?>
</a></td>
									<td><a href="javascript:void(0)"  id="mainblogID<?php echo $this->_tpl_vars['blog_count']; ?>
" onClick="showHideMenu('ancPlaylist', 'blogSubMenu','1','<?php echo $this->_tpl_vars['blog_count']; ?>
', 'mainblogID')" <?php if ($this->_tpl_vars['css_temp'] == 'blogpostlist_draftposts' || $this->_tpl_vars['css_temp'] == 'blogpostlist_notapproved' || $this->_tpl_vars['css_temp'] == 'blogpostlist_infutureposts' || $this->_tpl_vars['css_temp'] == 'blogpostlist_publishedposts' || $this->_tpl_vars['css_temp'] == 'blogpostlist_toactivate'): ?> class="clsHideSubmenuLinks" <?php else: ?> class="clsShowSubmenuLinks"<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['common_myblogpost_detail_show']; ?>
</a></td>
                            	  </tr>
								</table>
	                            <ul id="blogSubMenu<?php echo $this->_tpl_vars['blog_count']; ?>
" <?php if ($this->_tpl_vars['myobj']->_currentPage == 'blogpostlist_myposts' || $this->_tpl_vars['css_temp'] == 'blogpostlist_toactivate' || $this->_tpl_vars['css_temp'] == 'blogpostlist_notapproved' || $this->_tpl_vars['css_temp'] == 'blogpostlist_draftposts' || $this->_tpl_vars['css_temp'] == 'blogpostlist_publishedposts' || $this->_tpl_vars['css_temp'] == 'blogpostlist_infutureposts' || $this->_tpl_vars['css_temp'] == 'blogpostlist_myfavoriteposts'): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
                                    <li class="<?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_blogpostlist_toactivate'); ?>
">
                                        <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('blogpostlist','?pg=toactivate','toactivate/','members','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_toactivate_mypost']; ?>
</a>
                                    </li>
                                    <li class="<?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_blogpostlist_notapproved'); ?>
">
                                        <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('blogpostlist','?pg=notapproved','notapproved/','members','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_not_approvedpost']; ?>
</a>
                                    </li>
                                    <li class="<?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_blogpostlist_draftposts'); ?>
">
                                        <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('blogpostlist','?pg=draftposts','draftposts/','members','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_draftposts']; ?>
</a>
                                    </li>
                                    <li class="<?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_blogpostlist_infutureposts'); ?>
">
                                        <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('blogpostlist','?pg=infutureposts','infutureposts/','members','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_infutureposts']; ?>
</a>
                                    </li>
                                    <li class="<?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_blogpostlist_publishedposts'); ?>
">
                                        <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('blogpostlist','?pg=publishedposts','publishedposts/','members','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_publishedposts']; ?>
</a>
                                    </li>
                                    <li class="<?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_blogpostlist_myfavoriteposts'); ?>
">
                                        <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('blogpostlist','?pg=myfavoriteposts','myfavoriteposts/','members','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_myfavoriteposts']; ?>
</a>
                                    </li>
	                            </ul>
							</li>
                            <li class="<?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_manageblogpost'); ?>
 <?php if ($this->_tpl_vars['myobj']->_currentPage == 'manageblogpost'): ?>clsActiveLink<?php endif; ?>" >
                                  <table>
							 	<tr>
									<td colspan="2" class="clsBlogLinksDashboard"><a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('manageblogpost','','','members','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_blog_new_post']; ?>
</a></td>

								</tr>
							</table>
                            </li>
                            <li class="<?php echo $this->_tpl_vars['myobj']->getBlogNavClass('left_managepostcomments'); ?>
 <?php if ($this->_tpl_vars['myobj']->_currentPage == 'managepostcomments'): ?>clsActiveLink<?php endif; ?>">
                                     <table>
							 	<tr>
									<td colspan="2" class="clsBlogLinksDashboard"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('managepostcomments','','','members','blog'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_post_comments_label']; ?>
</a></td>
								</tr>
							</table>
                            </li>
                        </ul>
                    </div>
            </div>
            <input type="hidden" value="1" id="memberCount"  name="memberCount" />
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php endif; ?>