<?php /* Smarty version 2.6.18, created on 2011-10-18 14:49:59
         compiled from populateMemberBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'populateMemberBlock.tpl', 12, false),)), $this); ?>
<?php if ($this->_tpl_vars['opt'] == 'article'): ?>
    	  <!--<div class="clsSideBarLinks">
            <div class="clsSideBar">
                <div class="clsSideBarLeft">
                   <p class="clsSideBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['sidebar_myarticle_label']; ?>
</p>
                </div>
                <div class="clsSideBarRight">
                    <div class="clsSideBarContent">
                        <ul>
                            <?php $this->assign('css_temp', ''); ?>
                            <?php if ($this->_tpl_vars['flag']): ?>
                                <?php $this->assign('css_temp', ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['myobj']->_currentPage)) ? $this->_run_mod_handler('cat', true, $_tmp, '_') : smarty_modifier_cat($_tmp, '_')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['myobj']->getFormField('pg')) : smarty_modifier_cat($_tmp, $this->_tpl_vars['myobj']->getFormField('pg')))); ?>
                            <?php endif; ?>
                                                        <?php if (isAllowedArticleUpload ( )): ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>-->
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        	            <?php if ($this->_tpl_vars['header']->_currentPage == 'index1' && isMember ( )): ?>
            	<div class="clsarticleMemberContainer clsNoBorder">
                	<div class="clsarticleMemberThumb">
                    	<div class="clsThumbImageLink">
                        	<a href="<?php echo $this->_tpl_vars['populateMemberDetail_arr']['memberProfileUrl']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls45x45 clsPointer">
                                <img src="<?php echo $this->_tpl_vars['populateMemberDetail_arr']['icon']['m_url']; ?>
" title="<?php echo $this->_tpl_vars['populateMemberDetail_arr']['name']; ?>
" />
                            </a>
                        </div>
                    </div>
                    <div class="clsarticleMemberDetails ">
                        <p class="clsBold clsMyarticleUser"><a href="<?php echo $this->_tpl_vars['populateMemberDetail_arr']['memberProfileUrl']; ?>
" title="<?php echo $this->_tpl_vars['populateMemberDetail_arr']['name']; ?>
"><?php echo $this->_tpl_vars['populateMemberDetail_arr']['name']; ?>
</a></p>
                        <p><?php echo $this->_tpl_vars['LANG']['sidebar_totalarticle_label']; ?>
<span><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlelist','?pg=myarticle','myarticle/','members','article'); ?>
"><?php echo $this->_tpl_vars['populateMemberDetail_arr']['total_article']; ?>
</a></span></p>
                    </div>
                </div>
           <?php endif; ?>

            <?php endif; ?>
                        <p class="
            <?php if ($this->_tpl_vars['myobj']->_currentPage == 'managearticlecomments'): ?>
                <?php echo $this->_tpl_vars['myobj']->getArticleNavClass('left_managearticlecomments'); ?>

            <?php elseif ($this->_tpl_vars['css_temp'] == 'articlelist_myarticles'): ?>
                <?php echo $this->_tpl_vars['myobj']->getArticleNavClass('left_articlelist_myarticles'); ?>

            <?php elseif ($this->_tpl_vars['css_temp'] == 'articlelist_myfavoritearticles'): ?>
                <?php echo $this->_tpl_vars['myobj']->getArticleNavClass('left_articlelist_myfavoritearticles'); ?>

            <?php endif; ?>    " >
                <?php $this->assign('article_count', 1); ?>
                        <div class="clsSideBarLeft">
                            <p class="clsSideBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['sidebar_myarticle_dashboard_label']; ?>
</p>
                                                        </div>
                <div class="clsSideBarRight clsNoPadding">
		            <?php if (! isMember ( )): ?>
		           <div class="clsarticleMemberContainer clsNoBorder">
		           	<div class="clsarticleMemberDetails">
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
                   <div class="clsSideBarContent">
                       						<ul class="clsMyArticleListing" id="subarticleID<?php echo $this->_tpl_vars['article_count']; ?>
">
                            <li class="<?php echo $this->_tpl_vars['myobj']->getArticleNavClass('left_articleuploadpopup'); ?>
 <?php if ($this->_tpl_vars['myobj']->_currentPage == 'articlewriting'): ?>clsActiveLink<?php endif; ?>" >
                             <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlewriting','','','members','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_article_upload']; ?>
</a>
                            </li>
                            <li class="<?php echo $this->_tpl_vars['myobj']->getArticleNavClass('left_articlelist_articlenew'); ?>
 <?php if ($this->_tpl_vars['myobj']->_currentPage == 'articlenew'): ?>clsActiveLink<?php endif; ?>" >
                             <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlelist','?pg=articlenew','articlenew/','','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_allarticle']; ?>
</a>
                            </li>
                            <li class="<?php if ($this->_tpl_vars['myobj']->_currentPage == 'myarticles' || $this->_tpl_vars['css_temp'] == 'articlelist_myfavoritearticles' || $this->_tpl_vars['css_temp'] == 'articlelist_draftarticle' || $this->_tpl_vars['css_temp'] == 'articlelist_notapproved' || $this->_tpl_vars['css_temp'] == 'articlelist_infuturearticle' || $this->_tpl_vars['css_temp'] == 'articlelist_publishedarticle' || $this->_tpl_vars['css_temp'] == 'articlelist_toactivate'): ?>clsActiveLink<?php else: ?><?php echo $this->_tpl_vars['myobj']->getArticleNavClass('left_articlelist_myarticles'); ?>
<?php endif; ?> clsArticleSubMenu">
                            	<table>
                            		<tbody>
                            			<tr>
                            				<td class="clsNoSubmenuImg"><a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlelist','?pg=myarticles','myarticles/','members','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_myarticle_label']; ?>
</a></td>
                            				<td><a href="javascript:void(0)" id="mainarticleID<?php echo $this->_tpl_vars['article_count']; ?>
" onClick="showHideMenu('ancPlaylist', 'articleSubMenu','1','<?php echo $this->_tpl_vars['article_count']; ?>
', 'mainarticleID')" <?php if ($this->_tpl_vars['css_temp'] == 'articlelist_draftarticle' || $this->_tpl_vars['css_temp'] == 'articlelist_notapproved' || $this->_tpl_vars['css_temp'] == 'articlelist_infuturearticle' || $this->_tpl_vars['css_temp'] == 'articlelist_publishedarticle' || $this->_tpl_vars['css_temp'] == 'articlelist_toactivate' || $this->_tpl_vars['css_temp'] == 'articlelist_myarticles'): ?> class="clsHideSubmenuLinks" <?php else: ?>class="clsShowSubmenuLinks"<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['common_show']; ?>
</a></td>
                            			</tr>
									</tbody>
								</table>
                                
	                            <ul id="articleSubMenu<?php echo $this->_tpl_vars['article_count']; ?>
" <?php if ($this->_tpl_vars['css_temp'] == 'articlelist_myarticles' || $this->_tpl_vars['css_temp'] == 'articlelist_myfavoritearticles' || $this->_tpl_vars['css_temp'] == 'articlelist_toactivate' || $this->_tpl_vars['css_temp'] == 'articlelist_notapproved' || $this->_tpl_vars['css_temp'] == 'articlelist_draftarticle' || $this->_tpl_vars['css_temp'] == 'articlelist_livearticle' || $this->_tpl_vars['css_temp'] == 'articlelist_publishedarticle' || $this->_tpl_vars['css_temp'] == 'articlelist_infuturearticle'): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
	                            <li class="<?php echo $this->_tpl_vars['myobj']->getArticleNavClass('left_articlelist_myarticles'); ?>
">
	                                <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlelist','?pg=myarticles','myarticles/','members','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_myarticle_label']; ?>
</a>
	                            </li>
	                            <li class="<?php echo $this->_tpl_vars['myobj']->getArticleNavClass('left_articlelist_myfavoritearticles'); ?>
">
	                                <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlelist','?pg=myfavoritearticles','myfavoritearticles/','members','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_favourite_article_label']; ?>
</a>
	                            </li>
	                            <li class="<?php echo $this->_tpl_vars['myobj']->getArticleNavClass('left_articlelist_toactivate'); ?>
" >
	                                <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlelist','?pg=toactivate','toactivate/','members','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_toactivate_myarticle']; ?>
</a>
	                            </li>
	                            <li class="<?php echo $this->_tpl_vars['myobj']->getArticleNavClass('left_articlelist_notapproved'); ?>
">
	                                <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlelist','?pg=notapproved','notapproved/','members','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_not_approvedarticle']; ?>
</a>
	                            </li>
	                            <!--li class="<?php echo $this->_tpl_vars['myobj']->getArticleNavClass('left_articlelist_livearticle'); ?>
">
	                                <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlelist','?pg=livearticle','livearticle/','members','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_in_livearticle']; ?>
</a>
	                            </li-->
	                            <li class="<?php echo $this->_tpl_vars['myobj']->getArticleNavClass('left_articlelist_draftarticle'); ?>
">
	                                <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlelist','?pg=draftarticle','draftarticle/','members','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_draftarticle']; ?>
</a>
	                            </li>
	                            <li class="<?php echo $this->_tpl_vars['myobj']->getArticleNavClass('left_articlelist_infuturearticle'); ?>
">
	                                <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlelist','?pg=infuturearticle','infuturearticle/','members','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_infuturearticle']; ?>
</a>
	                            </li>
	                            <li class="<?php echo $this->_tpl_vars['myobj']->getArticleNavClass('left_articlelist_publishedarticle'); ?>
">
	                                <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('articlelist','?pg=publishedarticle','publishedarticle/','members','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_publishedarticle']; ?>
</a>
	                            </li>
	                            </ul>
							</li>
                            <li class="<?php echo $this->_tpl_vars['myobj']->getArticleNavClass('left_managearticlecomments'); ?>
 <?php if ($this->_tpl_vars['myobj']->_currentPage == 'managearticlecomments'): ?>clsActiveLink<?php endif; ?>">
                                <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('managearticlecomments','','','members','article'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_article_comments_label']; ?>
</a>
                            </li>
                        </ul>
                	</ul>
            	</div>
        	</div>
    	</p>
	<input type="hidden" value="1" id="memberCount"  name="memberCount" />
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>