<?php /* Smarty version 2.6.18, created on 2012-01-13 22:18:29
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'index.tpl', 10, false),array('function', 'smartyTabIndex', 'index.tpl', 22, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div id="selindexPostList">
        <!--rounded corners-->
        <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
        <?php echo $this->_tpl_vars['myobj']->populateBlogListHidden($this->_tpl_vars['paging_arr']); ?>

            <div class="clsOverflow">
                <div class="clsBlogListHeading">
                    <h2><span>
                            <?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['index_title'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>

                        </span>
                    </h2>
                </div>
            </div>
        </form>
        <div id="selLeftNavigation">
        <!-- Delete Single Post -->
            <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
                <p id="msgConfirmText"></p>
                <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                    <div class="clsBlogListTable clsContentsDisplayTbl">
						<input type="submit" class="clsSubmitButton" name="yes" id="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />&nbsp;
						<input type="button" class="clsSubmitButton" name="no" id="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks()" />
						<input type="hidden" name="act" id="act" />
						<input type="hidden" name="blog_post_id" id="blog_post_id" />
                    </div>
                </form>
            </div>
            <div id="selEditPostComments" class="clsPopupConfirmation" style="display:none;"></div>
                <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('my_posts_form')): ?>
                    <div id="selPostListDisplay" class="clsLeftSideDisplayTable">
                        <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
                            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                            <?php endif; ?>
                            <form name="blogPostListForm" id="blogPostListForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                                <p><a href="#" id="<?php echo $this->_tpl_vars['myobj']->anchor; ?>
"></a></p>
                                <div id="selDisplayTable">
                                    <?php $_from = $this->_tpl_vars['showindexPostList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['salKey'] => $this->_tpl_vars['salValue']):
?>
                                        <div class="clsBlogListContent">
                                            <a href="#" id="<?php echo $this->_tpl_vars['salValue']['anchor']; ?>
"></a>
                                            <?php if ($this->_tpl_vars['salValue']['record']['status'] == 'Locked'): ?>
                                                <div class="clsHomeDispContent">
                                                  <h3 class="clsTitleLink"><?php echo $this->_tpl_vars['salValue']['row_blog_post_name_manual']; ?>
</h3>
                                                  <p class="clsAddedDate"><?php echo $this->_tpl_vars['LANG']['index_added']; ?>
&nbsp;<?php echo $this->_tpl_vars['salValue']['record']['date_added']; ?>
</p>
                                                </div>
                                            <?php else: ?>
                                                <div class="clsHomeDispContent">
                                                    <div class="clsOverflow">
														<h3 class="clsTitleLink clsFloatLeft">
															<a href="<?php echo $this->_tpl_vars['salValue']['view_blog_post_link']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['salValue']['row_blog_post_name_manual'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</a>&nbsp;&nbsp;
														</h3>
														<div class="clsBlogViewDetails clsFloatLeft">
																	<span class="clsGreyColor">
																	<?php if ($this->_tpl_vars['salValue']['record']['status'] == 'Ok'): ?>
																		<?php echo $this->_tpl_vars['LANG']['index_date_published_on']; ?>
:&nbsp;
																		<span class=""><?php if ($this->_tpl_vars['salValue']['record']['date_published'] != ''): ?><?php echo $this->_tpl_vars['salValue']['record']['date_published']; ?>
<?php else: ?><?php echo $this->_tpl_vars['salValue']['record']['date_added']; ?>
<?php endif; ?></span>
																	<?php else: ?>
																		<?php echo $this->_tpl_vars['LANG']['index_date_published_on']; ?>
 :&nbsp;
																		<span><?php echo $this->_tpl_vars['salValue']['record']['date_added']; ?>
</span>
																	<?php endif; ?>
																	</span>
																	   <?php if (isMember ( ) && $this->_tpl_vars['salValue']['record']['user_id'] == $this->_tpl_vars['CFG']['user']['user_id']): ?>
																	 &nbsp;|&nbsp;
																	 <span><a href="<?php echo $this->_tpl_vars['salValue']['blog_post_posting_url_ok']; ?>
" class="clsBlogEditLinks" title="<?php echo $this->_tpl_vars['LANG']['index_edit_blog_post']; ?>
"><?php echo $this->_tpl_vars['LANG']['index_edit_blog_post']; ?>
</a></span>&nbsp;|&nbsp;
																<span><a href="#" class="clsBlogEditLinks" title="<?php echo $this->_tpl_vars['LANG']['index_delete_submit']; ?>
" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','blog_post_id', 'msgConfirmText'), Array('delete','<?php echo $this->_tpl_vars['salValue']['record']['blog_post_id']; ?>
','<?php echo $this->_tpl_vars['LANG']['index_delete_confirmation']; ?>
'), Array('value','value', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['index_delete_submit']; ?>
</a></span>
																	 <?php endif; ?>

															</div>
													</div>
                                                    <div class="clsBlogDetails">
                                                        <div class="clsOverflow">
																<p class="clsPostedName">(<?php echo $this->_tpl_vars['LANG']['index_post_list_added_in_blog_title']; ?>
:&nbsp;<a href="<?php echo $this->_tpl_vars['salValue']['view_blog_link']; ?>
" title="<?php echo $this->_tpl_vars['salValue']['record']['blog_name']; ?>
"><?php echo $this->_tpl_vars['salValue']['record']['blog_name']; ?>
</a>)</p>
													</div>
														<div id="blogUserProfile_<?php echo $this->_tpl_vars['salValue']['record']['blog_post_id']; ?>
" class="clsCoolMemberActive"  style="display:none;" onmouseover="showUserInfoPopup('<?php echo $this->_tpl_vars['myobj']->getUrl('userdetail'); ?>
', '<?php echo $this->_tpl_vars['salValue']['record']['user_id']; ?>
', 'blogUserProfile_<?php echo $this->_tpl_vars['salValue']['record']['blog_post_id']; ?>
');" onmouseout="hideUserInfoPopup('blogUserProfile_<?php echo $this->_tpl_vars['salValue']['record']['blog_post_id']; ?>
')"></div>
                                                        <div class="clsBlogContent">

                                                        <?php echo $this->_tpl_vars['salValue']['message']; ?>

                                                        </div>
                                                         <div class="clsOverflow clsTagsCategory">
										  					 <div class="clsFloatLeft">
                                                             <?php $this->assign('blog_tags', ''); ?>
                                                            <span class="clsTagBg"><?php echo $this->_tpl_vars['LANG']['index_search_blogpost_tags']; ?>
 :</span><?php if ($this->_tpl_vars['salValue']['record']['blog_tags'] != ''): ?> <?php echo $this->_tpl_vars['myobj']->getBlogPostsTagsLinks($this->_tpl_vars['salValue']['record']['blog_tags'],13,$this->_tpl_vars['blog_tags']); ?>
<?php endif; ?>
                                                           </div>
														   <div class="clsFloatRight">
																<span><?php echo $this->_tpl_vars['LANG']['index_blog_post_category_name']; ?>
 <?php echo $this->_tpl_vars['showindexPostList_arr']['separator']; ?>
</span>
																<span class="clsBlogValues"><?php echo $this->_tpl_vars['salValue']['row_blog_category_name_manual']; ?>
</span>
															</div>
                                                        </div>  </div>
														<div class="clsOverflow">
                                                        <div class="clsRatingLeft">
															<div class="clsRatingRight">
																<div class="clsRatingCenter">
																	<div class="clsFloatLeft clsUserImageBorder">
																	 by <a href="<?php echo $this->_tpl_vars['salValue']['member_profile_url']; ?>
">
																	 <img src="<?php echo $this->_tpl_vars['salValue']['profileIcon']['s_url']; ?>
" title="<?php echo $this->_tpl_vars['salValue']['name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(15,15,$this->_tpl_vars['salValue']['width'],$this->_tpl_vars['salValue']['height']); ?>
/>&nbsp;<span class="clsUserProfileImage" onmouseover="showUserInfoPopup('<?php echo $this->_tpl_vars['myobj']->getUrl('userdetail'); ?>
',
                                                                '<?php echo $this->_tpl_vars['salValue']['record']['user_id']; ?>
', 'blogUserProfile_<?php echo $this->_tpl_vars['salValue']['record']['blog_post_id']; ?>
');" onmouseout="hideUserInfoPopup('blogUserProfile_<?php echo $this->_tpl_vars['salValue']['record']['blog_post_id']; ?>
')"></span></a>
																<a href="<?php echo $this->_tpl_vars['salValue']['member_profile_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['salValue']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</a>
																	</div>
																	<div class="clsFloatRight">
																					  <span class="clsBoldFont"><?php echo $this->_tpl_vars['salValue']['record']['total_comments']; ?>
</span>
                                                                <?php if ($this->_tpl_vars['salValue']['record']['total_comments'] > 1): ?><?php echo $this->_tpl_vars['LANG']['index_comments']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['index_comment']; ?>
<?php endif; ?>&nbsp;|&nbsp;
                                                                <span class="clsBoldFont"><?php echo $this->_tpl_vars['salValue']['record']['total_views']; ?>
</span>
                                                                <?php if ($this->_tpl_vars['salValue']['record']['total_views'] > 1): ?><?php echo $this->_tpl_vars['LANG']['index_views']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['index_view']; ?>
<?php endif; ?>&nbsp;|&nbsp;
                                                                <span class="clsBoldFont"><?php echo $this->_tpl_vars['salValue']['record']['total_favorites']; ?>
</span>
                                                                <?php if ($this->_tpl_vars['salValue']['record']['total_favorites'] > 1): ?><?php echo $this->_tpl_vars['LANG']['index_favorites']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['index_favorite']; ?>
<?php endif; ?>
																	&nbsp;|&nbsp;<?php if ($this->_tpl_vars['myobj']->populateRatingDetails($this->_tpl_vars['salValue']['record']['rating'])): ?>
																		<?php echo $this->_tpl_vars['myobj']->populateBlogRatingImages($this->_tpl_vars['salValue']['record']['rating'],'blog'); ?>

																	<?php else: ?>
																	   <?php echo $this->_tpl_vars['myobj']->populateBlogRatingImages(0,'blog'); ?>

																	<?php endif; ?>
																	</div>
		                                                        </div>
															</div>
														</div>
														</div>
                                                    </div>

                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; endif; unset($_from); ?>
                                    <?php if ($this->_tpl_vars['showindexPostList_arr']['extra_td_tr']): ?>
                                        <div>&nbsp;</div>
                                    <?php endif; ?>
                                </div>
                             </form>
                            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <div id="selMsgAlert">
                                <p><?php echo $this->_tpl_vars['LANG']['index_no_records_found']; ?>
</p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <!--end of rounded corners-->
        </div>
    </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

