<?php /* Smarty version 2.6.18, created on 2012-02-01 23:56:28
         compiled from viewArticleContent.tpl */ ?>
									<div id="articlePageContent">

                                                                            <?php if ($this->_tpl_vars['displayArticle_arr']['page_break']): ?>
                                        <div class="clsOverflow clsArticleInnerHeader">
                                            <div class="clsViewHeader" id="displayPageTitle">
                                                <h3></h3>
                                            </div>
                                            <p class="clsViewArticlePrevNext">
                                            <?php if ($this->_tpl_vars['displayArticle_arr']['disable_prev_link']): ?>
                                               <a href="javascript:void(0)" onClick="return getArticleContent('<?php echo $this->_tpl_vars['displayArticle_arr']['previous_link']; ?>
&ajax_page=true', '')" class="clsPrev" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_previous']; ?>
">
                                                 <?php echo $this->_tpl_vars['LANG']['viewarticle_prev']; ?>

                                               </a>
                                            <?php endif; ?>
                                            <?php if ($this->_tpl_vars['displayArticle_arr']['disable_next_link']): ?>
                                                <a href="javascript:void(0)" onClick="return getArticleContent('<?php echo $this->_tpl_vars['displayArticle_arr']['next_link']; ?>
&ajax_page=true', '')" class="clsNext" title="<?php echo $this->_tpl_vars['LANG']['viewarticle_next']; ?>
">
                                                    <?php echo $this->_tpl_vars['LANG']['viewarticle_next']; ?>

                                                </a>
                                            <?php endif; ?>
                                            </p>
                                        </div>
                                       <?php endif; ?>
                                    
                                                                          <?php if ($this->_tpl_vars['displayArticle_arr']['page_break']): ?>
                                        <h4 id="displayPageTitle"></h4><br/>
                                      <?php endif; ?>
                                     
                                                                        <div class="clsViewArticleImage clsOverflow">
                                                                        <p><?php echo $this->_tpl_vars['displayArticle_arr']['article_caption']; ?>
</p>
                                    </div>

                                    </div>