<?php /* Smarty version 2.6.18, created on 2012-02-01 23:56:28
         compiled from viewArticle.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'viewArticle.tpl', 14, false),array('modifier', 'truncate', 'viewArticle.tpl', 256, false),)), $this); ?>
<?php echo '
<script language="javascript" type="text/javascript">
	function toggleVideoPostCommentOption(){
		$Jq("#selEditMainComments").toggle(\'slow\');
	}
	$Jq("#tabs").tabs();
</script>
'; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('articleMainBlock')): ?>

    <div id="selMsgConfirmWindow" class="clsMsgConfirmWindow" style="display:none;">
        <h3 id="confirmationMsg"></h3>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
            <input type="button" class="clsSubmitButton" name="confirm_action" id="confirm_action" onclick="deleteCommandOrReply();" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
            &nbsp;
            <input type="button" class="clsCancelButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks();" />
            <input type="hidden" name="comment_id" id="comment_id" />
            <input type="hidden" name="maincomment_id" id="maincomment_id" />
            <input type="hidden" name="commentorreply" id="commentorreply" />
        </form>
    </div>
	<div class="clsViewArticlePage">
	    <div class="clsViewArticleContent">
            <?php if (! isAjaxpage ( )): ?>
                <div id="selViewArticle">
                   <div id="selLeftNavigation">
            <?php endif; ?>
           
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

    	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'articlecontent_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('confirmation_flagged_form')): ?>
            <div id="flaggedForm" class="clsFlaggedForm">
              <p><?php echo $this->_tpl_vars['LANG']['viewarticle_flagged_msg']; ?>
</p>
              	<div class="clsSubmitLeft">
					<span class="clsSubmitRight">
                    	<a href="<?php echo $this->_tpl_vars['myobj']->confirmation_flagged_form['viewarticle_url']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_flagged']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewarticle_flagged']; ?>
</a>
                    </span>
                </div>
            </div>
        <?php endif; ?>
	   <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('confirmation_adult_form')): ?>
        <div id="selAdultUserForm">
          <p><?php echo $this->_tpl_vars['myobj']->replaceAdultText($this->_tpl_vars['LANG']['viewarticle_confirmation_alert_text']); ?>
</p>
          <p>
            <a href="<?php echo $this->_tpl_vars['confirmation_adult_form_arr']['view_article_accept_url']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_accept']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewarticle_accept']; ?>
</a>&nbsp;&nbsp;
            <a href="<?php echo $this->_tpl_vars['confirmation_adult_form_arr']['view_article_view_url']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_accept_this_page_only']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewarticle_accept_this_page_only']; ?>
</a>&nbsp;&nbsp;
            <a href="<?php echo $this->_tpl_vars['confirmation_adult_form_arr']['view_article_reject_url']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_reject']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewarticle_reject']; ?>
</a>&nbsp;&nbsp;
            <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_reject_this_page_only']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewarticle_reject_this_page_only']; ?>
</a>
          </p>
        </div>
	 <?php endif; ?>

         <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('articles_form') && $this->_tpl_vars['myobj']->validate): ?>
                <div id="selViewArticleFrm">
                   <div id="article_content">
<div id="selArticlePlayerCell">
            	<div class="clsOverflow">
                    <h3 class="clsViewArticleHeading"><?php echo $this->_tpl_vars['myobj']->getFormField('article_title'); ?>
</h3>
                    <div class="clsViewArticleRanking">
                                                  <?php if ($this->_tpl_vars['myobj']->chkAllowRating()): ?>
                            <div id="ratingForm">
                                <?php $this->assign('tooltip', ""); ?>
                                <?php if (! isLoggedIn ( )): ?>
                                    <?php echo $this->_tpl_vars['myobj']->populateRatingImages($this->_tpl_vars['myobj']->article_rating,'article',$this->_tpl_vars['LANG']['viewarticle_login_message'],$this->_tpl_vars['myobj']->memberviewArticleUrl,'article'); ?>

                                    <?php $this->assign('tooltip', $this->_tpl_vars['LANG']['viewarticle_login_message']); ?>
                                <?php else: ?>
                                    <span id="selRatingArticle" class="clsArticle1Rating">
                                        <?php if (isMember ( ) && $this->_tpl_vars['myobj']->rankUsersRayzz): ?>
                                            <?php echo $this->_tpl_vars['myobj']->populateRatingImagesForAjax($this->_tpl_vars['myobj']->article_rating,'article'); ?>

                                        <?php else: ?>
                                            <?php echo $this->_tpl_vars['myobj']->populateRatingImages($this->_tpl_vars['myobj']->article_rating,'article',$this->_tpl_vars['LANG']['viewarticle_rate_yourself'],'#','article'); ?>

                                            <?php $this->assign('tooltip', $this->_tpl_vars['LANG']['viewarticle_rate_yourself']); ?>
                                        <?php endif; ?>
                                        <span>
                                            (<?php echo $this->_tpl_vars['myobj']->getFormField('rating_count'); ?>
)
                                                                                    </span>
                                    </span>
                                <?php endif; ?>
                                <script type="text/javascript">
								  <?php echo '
								  $Jq(document).ready(function(){
								    $Jq(\'#ratingLink\').attr(\'title\',\''; ?>
<?php echo $this->_tpl_vars['tooltip']; ?>
<?php echo '\');
								  	$Jq(\'#ratingLink\').tooltip({
															track: true,
															delay: 0,
															showURL: false,
															showBody: " - ",
															extraClass: "clsToolTip",
															top: -10
														});
										});
									'; ?>

                          		</script>
                            </div>
                        <?php endif; ?>
                      </div>
                </div>
				<a id="dAltMulti" href="#"></a>


            </div><!-- end of div7 selArticlePlayerCell -->
          </div>


        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                     <div class="clsOverflow">
                            <div class="clsViewArticleContainer">
                                    <div>
                                        <?php if ($this->_tpl_vars['myobj']->getFormField('article_status') != 'Ok'): ?>
                                            <p class="clsUnderPublished"><?php echo $this->_tpl_vars['LANG']['viewarticle_preview_article_msg']; ?>
</p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="clsOverflow clsArticleUserAction">
                                        <div class="clsAritcleInfo">
                                            <ul>
                                                <li>
                                                     <span><?php echo $this->_tpl_vars['LANG']['viewarticle_views']; ?>
</span><span class="clsEmberRatingLeft"><span class="clsEmberRatingRight"><?php echo $this->_tpl_vars['myobj']->getFormField('total_views'); ?>
</span></span>
                                                </li>
                                                <li>
                                                      <span><?php echo $this->_tpl_vars['LANG']['viewarticle_comments']; ?>
</span><span class="clsEmberRatingLeft"><span class="clsEmberRatingRight"><?php echo $this->_tpl_vars['myobj']->getFormField('comments'); ?>
</span></span>
                                                </li>
                                                <li>
                                                      <span><?php echo $this->_tpl_vars['LANG']['viewarticle_favorited']; ?>
</span><span class="clsEmberRatingLeft"><span class="clsEmberRatingRight"><?php echo $this->_tpl_vars['myobj']->getFormField('favorited'); ?>
</span></span>
                                                </li>
                                            </ul>
                                         </div>
                                         <div class="clsEditArticle">
                                                                                        <?php if ($this->_tpl_vars['displayArticle_arr']['article_writing_url_ok']): ?>
                                              <a href="<?php echo $this->_tpl_vars['displayArticle_arr']['article_writing_url_ok']; ?>
" class="clsPhotoArticleEditLinks" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_edit_article']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewarticle_edit_article']; ?>
</a>
                                            <?php endif; ?>
                                         </div>
                                     </div>

                                     
                                      <?php if (( ! isAjaxPage ( ) )): ?>
                            				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

                            				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'viewArticleContent.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                            		  <?php endif; ?>

                                    

                                                                        <?php if ($this->_tpl_vars['displayArticle_arr']['read_more']): ?>
                                        <div align="right" style="padding-right:20px;">
                                            <p>
                                            <a href="<?php echo $this->_tpl_vars['displayArticle_arr']['viewmore_link']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_read_more']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewarticle_read_more']; ?>
</a>
                                            </p>
                                        </div><br />
                                   <?php endif; ?>
                                   
																<?php if ($this->_tpl_vars['myobj']->getFormField('article_status') == 'Ok'): ?>
                                   <?php if ($this->_tpl_vars['displayArticle_arr']['article_attachment']): ?>
                                        <div class="clsAttachmentArticle">
                                             <h3><?php echo $this->_tpl_vars['LANG']['viewarticle_attachments']; ?>
</h3>
                                             <div id="attachments">
                                                <?php $_from = $this->_tpl_vars['getAttachmentDetails']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['gadKey'] => $this->_tpl_vars['gadValue']):
?>
                                                    <p><?php echo $this->_tpl_vars['gadKey']; ?>
. <a href="<?php echo $this->_tpl_vars['gadValue']['download_url']; ?>
" title="<?php echo $this->_tpl_vars['gadValue']['record']['file_name']; ?>
"><?php echo $this->_tpl_vars['gadValue']['record']['file_name']; ?>
</a></p>
                                                <?php endforeach; endif; unset($_from); ?>
                                             </div>
                                        </div>
                                   <?php endif; ?>
                                <?php endif; ?>
                                    <!-- COMMENTS BLOCK STARTED HERE-->
                                                                       	<?php if ($this->_tpl_vars['myobj']->getFormField('article_status') == 'Ok'): ?>
                                    <div class="clsViewComments">
                                            <div class="clsCommentTitle">
                                                <h3><?php echo $this->_tpl_vars['LANG']['viewarticle_comments']; ?>

                                               		(<span class="clsCommentsCount" id="selVideoCommentsCount"><?php echo $this->_tpl_vars['myobj']->getFormField('total_comments'); ?>
</span>)
                                                </h3>
                                            </div>
                                			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

                                			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewcomments_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                            <div class="clsPostCommentHeading clsOverflow">
                                                <?php if ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda' || $this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Yes'): ?>
                                                    <?php if (isMember ( )): ?>
                                                            <p id="selViewPostComment" class="clsPostComment clsOverflow">
                                                                <a class="" id="selPostVideoComment" href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" onclick="toggleVideoPostCommentOption(); return false;" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_post_comment']; ?>
">
                                                                <span><?php echo $this->_tpl_vars['LANG']['viewarticle_post_comment']; ?>
</span>
                                                                </a>

                                                            </p>
                                                    <?php else: ?>
                                                        <div class="clsOverflow">
                                                            <p id="selViewPostComment" class="clsPostComment">
                                                                <a class="" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['common_video_login_post_comment_msg']; ?>
', '<?php echo $this->_tpl_vars['myobj']->notLoginArticleUrl; ?>
')">
                                                                    <span><?php echo $this->_tpl_vars['LANG']['viewarticle_post_comment']; ?>
</span> <?php if ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda'): ?>(<?php echo $this->_tpl_vars['LANG']['approval']; ?>
)<?php endif; ?>
                                                                </a>
                                                            </p>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addComments.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php if (isMember ( )): ?>
                                            <?php if ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda'): ?>
                                               <div class="clsOverflow"><div class="clsPostCommentHeading clsVideVideoHeadingRight">(<?php echo $this->_tpl_vars['LANG']['approval']; ?>
)</div></div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                                                                <div id="selMsgSuccess" style="display:none">
                                            <p id="kindaSelMsgSuccess"></p>
                                        </div>
                                        <div id="selCommentBlock" class="clsViewVideoDetailsContent">
                                            <?php echo $this->_tpl_vars['myobj']->populateCommentOfThisArticle(); ?>

                                        </div>
                                		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

                                		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewcomments_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                    </div>
                                    <?php endif; ?>
                                    <!-- COMMENTS BLOCK END HERE -->
                                </div>
                            <div class="clsViewArticleContentDet">
                                <div id="selArticleInfo">
                                  <!-- For rounded corners -->
                                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

                                     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'article_rank_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                          <div id="selArticleInfoDisplay" class="clsOverflow">
                                              <!--<div class="clsOverflow">-->
                                                                                              <!-- </div>-->
                                              <div class="clsOverflow">
                                              <div class="clsAritcleInfoMember">
                                                    <a href="<?php echo $this->_tpl_vars['displayArticle_arr']['member_profile_url']; ?>
" class="Cls45x45 ClsImageBorder2 ClsImageContainer">
                                                        <img src="<?php echo $this->_tpl_vars['displayArticle_arr']['member_icon_url']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->getFormField('name'))) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['myobj']->getFormField('name'); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['displayArticle_arr']['member_icon_url']['s_width'],$this->_tpl_vars['displayArticle_arr']['member_icon_url']['s_height']); ?>
 />
                                                    </a>
                                               </div>
                                               <div class="clsAritcleInfoDet">
                                                  <p>
                                                   <?php echo $this->_tpl_vars['LANG']['viewarticle_added_by']; ?>
&nbsp;<a href="<?php echo $this->_tpl_vars['displayArticle_arr']['member_profile_url']; ?>
" title="<?php echo $this->_tpl_vars['myobj']->getFormField('name'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('name'); ?>
</a>
                                                   &nbsp;|
                                                   &nbsp;<?php if ($this->_tpl_vars['myobj']->getFormField('article_status') == 'Ok'): ?><?php echo $this->_tpl_vars['LANG']['viewarticle_published_date']; ?>

                                                   &nbsp;<span><?php echo $this->_tpl_vars['myobj']->getFormField('date_of_publish'); ?>
</span><?php else: ?><?php echo $this->_tpl_vars['LANG']['viewarticle_added_date']; ?>

                                                   &nbsp;<span><?php echo $this->_tpl_vars['myobj']->getFormField('date_added'); ?>
</span><?php endif; ?>

                                                                                                      <!-- &nbsp;<span>|</span>&nbsp;<?php echo $this->_tpl_vars['LANG']['viewarticle_rating']; ?>
:<span id="articleRating"><?php echo $this->_tpl_vars['myobj']->article_rating; ?>
</span>-->
                                                  </p>

                                                  <p class="clsArticleUser">Article by this user: <span><?php echo $this->_tpl_vars['displayArticle_arr']['total_article']; ?>
</span></p>
                                              </div>
                                              </div>
                                          </div>
                                                                                <div class="clsArticleTags clsTagsLink">
                                            <p><?php echo $this->_tpl_vars['LANG']['viewarticle_tags']; ?>

                                                <?php $_from = $this->_tpl_vars['displayArticle_arr']['getTagsOfThisArticle_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['gtaKey'] => $this->_tpl_vars['gtaValue']):
?>
                                                    <a href="<?php echo $this->_tpl_vars['gtaValue']['url']; ?>
" title="<?php echo $this->_tpl_vars['gtaValue']['tags']; ?>
"><?php echo $this->_tpl_vars['gtaValue']['tags']; ?>
</a>
                                                <?php endforeach; endif; unset($_from); ?>
                                            </p>
                                        </div>
                                                                             <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

                                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'article_rank_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                  <!--end of rounded corners-->
                                </div>
                               
                                    <?php if ($this->_tpl_vars['displayArticle_arr']['page_break']): ?>
                                        <div class="clsArticleIndex">
                                            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

                                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewarticle_index_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                            	<div class="clsArticleIndexTitle">
                                                 	<h3><?php echo $this->_tpl_vars['LANG']['viewarticle_article_index']; ?>
</h3>
                                                 </div>
                                                <div class="clsArticleIndexListing">
                                                    <ul>
                                                        <li id="show_1" class="clsAticleIndexActive"><a href="javascript:void(0)" onClick="return getArticleContent('<?php echo $this->_tpl_vars['displayArticle_arr']['page_break_home']; ?>
&page_title=0&ajax_page=true', '')" title=<?php echo $this->_tpl_vars['LANG']['viewarticle_article_home']; ?>
><?php echo $this->_tpl_vars['LANG']['viewarticle_article_home']; ?>
</a></li>
                                                        <?php $_from = $this->_tpl_vars['displayArticle_arr']['pagebreak_toc_title_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pageno'] => $this->_tpl_vars['page']):
?>
                                                            <li id="show_<?php echo $this->_tpl_vars['pageno']; ?>
"><a href="javascript:void(0)" onClick="return getArticleContent('<?php echo $this->_tpl_vars['displayArticle_arr']['pagebreak_title_link']; ?>
<?php echo $this->_tpl_vars['pageno']; ?>
&page_title=<?php echo $this->_tpl_vars['displayArticle_arr']['pagebreak_title_arr'][$this->_tpl_vars['pageno']]; ?>
&ajax_page=true', '')" title="<?php echo $this->_tpl_vars['page']; ?>
"><?php echo $this->_tpl_vars['displayArticle_arr']['pagebreak_toc_title_manual_arr'][$this->_tpl_vars['pageno']]; ?>
</a></li>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                        <li id="show_all"><a href="javascript:void(0)" onClick="return getArticleContent('<?php echo $this->_tpl_vars['displayArticle_arr']['page_break_show_all']; ?>
&page_title=0&ajax_page=true', '')" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_article_allpages']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewarticle_article_allpages']; ?>
</a></li>
                                                                                                            </ul>
                                                </div>
                                            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

                                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewarticle_index_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                        </div>
                                    <?php endif; ?>

                                    


                                <!--CONTENT TAB -->
                                                                <?php if ($this->_tpl_vars['myobj']->getFormField('article_status') == 'Ok'): ?>
	                                <div class="clsArticleFeatured clsOverflow">
	                                    <ul id="selArticleDetails">
	                                         <li class="clsContentCell">
	                                            <p class="clsShare">
	                                                <a href="javascript:void(0)" onClick="showShareArticleDiv('<?php echo $this->_tpl_vars['displayArticle_arr']['share_article_url']; ?>
', 'email_content_tab')" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_email_to_friends']; ?>
">
	                                            		<span><?php echo $this->_tpl_vars['LANG']['viewarticle_email_to_friends']; ?>
</span>
	                                          		</a>
	                                            </p>
	                                        </li>
	                                        <li class="clsContentCell">
	                                            <?php if ($this->_tpl_vars['myobj']->getFormField('flagged_status') == 'No'): ?>
	                                                <?php if (isMember ( )): ?>
	                                                  <p class="clsFlagContent">
	                                                  	 <a href="javascript:void(0)" onclick="return Confirmation('flagDiv', 'flagfrm', Array(), Array(), Array())" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_flag_content']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewarticle_flag_content']; ?>
</span></a>
	                                                  </p>
	                                                <?php else: ?>
	                                                  	                                                  <p class="clsFlagContent">
	                                                      <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_comment_flag_err_msg']; ?>
','<?php echo $this->_tpl_vars['displayArticle_arr']['flag_article_url']; ?>
');return false;">
	                                                    	  <span><?php echo $this->_tpl_vars['LANG']['viewarticle_flag_content']; ?>
</span>
	                                                      </a>
	                                                  </p>
	                                                <?php endif; ?>
	                                             <?php endif; ?>
	                                        </li>
	                                        <li class="clsContentCell">
	                                            <?php if (isMember ( )): ?>
	                                                <p id="selHeaderFavorites" class="clsFavourites">
	                                                    <div class="clsFavouriteContent" id="favorite"<?php if ($this->_tpl_vars['myobj']->favorite['added']): ?> style="display:none"<?php endif; ?>>
	                                                        <a class="favorites" href="javascript:void(0);" onclick="getViewArticleMoreContent('Favorites');">
	                                                      		<span class="clsFavourites"><?php echo $this->_tpl_vars['LANG']['viewarticle_favorites']; ?>
</span>
	                                                        </a>
	                                                    </div>
	                                                    <div  class="clsFavouriteContent clsFavoured" id="unfavorite"<?php if (! $this->_tpl_vars['myobj']->favorite['added']): ?> style="display:none"<?php endif; ?>>
	                                                        <a class="favorited" href="javascript:void(0);" onclick="getViewArticleMoreContent('Favorites','remove');">
	                                                        	<span class="clsFavourited"><?php echo $this->_tpl_vars['LANG']['viewarticle_article_favorited']; ?>
</span>
	                                                        </a>
	                                                    </div>
	                                                </p>
	                                            <?php else: ?>
	                                                 <p id="selHeaderFavorites">
	                                                    <div class="clsFavouriteContent">
	                                                     	                                                        <a class="favorites" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_favorite_err_msg']; ?>
','<?php echo $this->_tpl_vars['displayArticle_arr']['getFavoriteLink_arr']['view_article_url']; ?>
');return false;">
	                                                       		<span class="clsFavourites"><?php echo $this->_tpl_vars['LANG']['viewarticle_favorites']; ?>
</span>
	                                                        </a>
	                                                    </div>
	                                                 </p>

	                                            <?php endif; ?>
	                                            <p id="selHeaderFavorites">
	                                                    <div class="clsFavouriteContent" id="favorite_saving" style="display:none">
	                                                        <a class="favorites" href="javascript:void(0);"><span class="clsFavourites">Saving</span></a>
	                                                    </div>
	                                            </p>
	                                            <li  class="clsMusicfavorite" id="favorite_saving" style="display:none">
	                       							<a class="favorited"><span><?php echo $this->_tpl_vars['LANG']['viewmusic_saving']; ?>
</span></a>
	                  							</li>


	                                             <div id="shareDiv" class="clsPopupConfirmation" style="display:none">
												 	  <br />&nbsp;
												 </div>
												 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'articleFlag.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	                                         </li>
	                                    </ul>
	                                </div>
                                <?php endif; ?>

                                <div class="clsArticleFlag">
                                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

                                     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'articleflag_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                        <div id="flag_content_tab"></div>
                                                                                    <div class="clsFlagDetails" id="selSlideContainer" style="display:none">
                                                <div class="clsOverflow clsFlagTitle">
                                                <h2><?php echo $this->_tpl_vars['LANG']['viewarticle_title_favorite']; ?>
</h2>
                                                <div id="cancel"><a href="javascript:void(0);" onclick="closeShareSlider();" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_cancel']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewarticle_cancel']; ?>
</a></div>
                                                </div>
                                                <div class="clsFavouritesContent"><span id="selFavoritesContent" style="display:none"></span></div>
                                            </div>
                                                                                <div id="favorite_content_tab" class="selFavoriteMsgSuccess"></div>
                                        <div id="email_content_tab"></div>
                                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

                                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'articleflag_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                </div>
                                <!--END OF CONTENT TAB -->
                                <div class="clsMoreArticleContent">
                                    <div class="clsAriclTitleContainer">
                                          <div class="clsOverflow">
                                                <div class="clsViewArticleTitle">
                                                        <h3><?php echo $this->_tpl_vars['LANG']['viewarticle_more_articles']; ?>
</h3>
                                                </div>
                                                <div id="" class="clsMoreArticleNav">
                                                  <ul>
                                                    <li id="selHeaderArticleUser"><span><a class="" onClick="getMoreContent('<?php echo $this->_tpl_vars['displayArticle_arr']['more_article_user_url']; ?>
', 'selUserContent', 'selHeaderArticleUser'); return false;" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_more_articles_user']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewarticle_more_articles_user']; ?>
</a></span></li>
                                                    <li id="selHeaderArticleRel"><span><a class="" onClick="getMoreContent('<?php echo $this->_tpl_vars['displayArticle_arr']['more_article_tag_url']; ?>
', 'selRelatedContent', 'selHeaderArticleRel'); return false;" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_more_articles_related']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewarticle_more_articles_related']; ?>
</a></span></li>
                                                    <li id="selHeaderArticleTop"><span><a onClick="getMoreContent('<?php echo $this->_tpl_vars['displayArticle_arr']['more_article_top_url']; ?>
', 'selTopContent', 'selHeaderArticleTop'); return false;" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_more_articles_top']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewarticle_more_articles_top']; ?>
</a></span></li>
                                                  </ul>
                                                </div>
                                          </div>
                                        </div>
                                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

                                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'morearticles_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                         <div id="more_article_<?php echo $this->_tpl_vars['myobj']->getFormField('article_id'); ?>
">
                                                <div id="" class="clsMoreArticlesContent">
                                                  <div class="clsUserContent" id="selUserContent">
                                                    <?php echo $this->_tpl_vars['myobj']->populateRelatedArticle('user'); ?>

                                                  </div>
                                                  <div class="clsRelatedContent" id="selRelatedContent" style="display:none">
                                                    <?php echo $this->_tpl_vars['myobj']->populateRelatedArticle('tag'); ?>

                                                  </div>
                                                  <div class="clsTopContent" id="selTopContent" style="display:none">
                                                    <?php echo $this->_tpl_vars['myobj']->populateRelatedArticle('top'); ?>

                                                  </div>
                                                </div>
                                        </div>
                                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

                                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'morearticles_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                </div>
                            </div>

                            <?php if (isAjaxpage ( )): ?>
                                ***--***!!!
                                <?php echo $this->_tpl_vars['myobj']->captchaText; ?>

                            <?php endif; ?>
                      </div>
                </div>
         <?php endif; ?>

    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'articlecontent_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	  <?php if (! isAjaxpage ( )): ?>
          </div>
        </div>
	  <?php endif; ?>
</div>
</div>

<?php endif; ?>

<?php echo '
<script language="javascript" type="text/javascript">
	function toggleVideoPostCommentOption(){
		$Jq("#selEditMainComments").toggle(\'slow\');
	}
	$Jq("#tabs").tabs();
</script>
'; ?>

