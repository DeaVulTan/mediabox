<?php /* Smarty version 2.6.18, created on 2011-11-03 12:05:01
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'index.tpl', 10, false),)), $this); ?>
<!--rounded corners-->

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'article_list_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<form id="articleListIndexForm" name="articleListIndexForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
<input type="hidden" name="advanceFromSubmission" value="1"/>
<div class="clsOverflow clsIndexContainer">
  <div class="clsArticleListHeading">
    <h2><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['index_articlelist_title'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</h2>
  </div>
  <div class="clsArticleListHeadingRight">
    <input type="hidden" value="" />
    <select name="select" onchange="loadUrl(this)" id="articleselect">
      <option value="<?php  echo getUrl('index','?pg=articlerecent','?pg=articlerecent','','article') ?>" <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == ''): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['sidebar_article_most_recent']; ?>
</option>
      <option value="<?php  echo getUrl('index','?pg=articletoprated','?pg=articletoprated','','article') ?>" <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'articletoprated'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['sidebar_article_top_rated']; ?>
</option>
      <option value="<?php  echo getUrl('index','?pg=articlemostviewed','?pg=articlemostviewed','','article') ?>" <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'articlemostviewed'): ?> selected <?php endif; ?> ><?php echo $this->_tpl_vars['LANG']['sidebar_article_most_viewed']; ?>
</option>
      <option value="<?php  echo getUrl('index','?pg=articlemostdiscussed','?pg=articlemostdiscussed','','article') ?>" <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'articlemostdiscussed'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['sidebar_article_most_discussed']; ?>
</option>
      <option value="<?php  echo getUrl('index','?pg=articlemostfavorite','?pg=articlemostfavorite','','article') ?>" <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'articlemostfavorite'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['sidebar_article_most_favorite']; ?>
</option>
    </select>
  </div>
</div>
<div id="selLeftNavigation">
  <?php if ($this->_tpl_vars['populateCarousalarticleBlock_arr']['row']): ?>
	  <?php $_from = $this->_tpl_vars['populateCarousalarticleBlock_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['salKey'] => $this->_tpl_vars['salValue']):
?>
	  <div class="clsArticleListContent">
	    <div class="clsHomeDispContent">
	      <div class="clsOverflow clsArticleHeader">
              <h3 class="clsTitleLink"><a href="<?php echo $this->_tpl_vars['salValue']['view_article_link']; ?>
" title="<?php echo $this->_tpl_vars['salValue']['wordWrap_mb_ManualWithSpace_article_title']; ?>
"><?php echo $this->_tpl_vars['salValue']['wordWrap_mb_ManualWithSpace_article_title']; ?>
</a></h3>
          </div>
	      <div class="clsArticleDetails">
              <p><?php echo $this->_tpl_vars['LANG']['index_article_date_published']; ?>
&nbsp;:&nbsp;<span><?php echo $this->_tpl_vars['salValue']['record']['date_published']; ?>
</span></p>
	      		<p>
	                <a href="<?php echo $this->_tpl_vars['salValue']['member_profile_url']; ?>
">
	                     <span class="clsUserProfileImage"></span>
	                </a>
	      		</p>
	            <p class="clsViewTagsLink">
	            	<?php echo $this->_tpl_vars['salValue']['article_caption_manual']; ?>
&nbsp;
                    	            </p>
	            <p class="clsArticleIndexTagDetails">
	            	<span>
	                	<?php echo $this->_tpl_vars['LANG']['index_article_tags']; ?>
:
	                </span>
	                <?php if ($this->_tpl_vars['salValue']['record']['article_tags'] != ''): ?> <?php echo $this->_tpl_vars['myobj']->getArticleTagsLinks($this->_tpl_vars['salValue']['record']['article_tags'],10); ?>
<?php endif; ?>
	            </p>
                <div class="clsArticleDetMiddle">
                	<div class="clsArticleDetLeft">
                    	<div class="clsArticleDetRight clsOverflow">
                        	<div class="clsArticleUser">
                                <p class="">
                                    <?php echo $this->_tpl_vars['LANG']['index_by_label']; ?>
&nbsp;
                                    <a href="<?php echo $this->_tpl_vars['salValue']['member_profile_url']; ?>
" class="cls15x15 clsImageBorder ClsImageContainer">
                                    <img src="<?php echo $this->_tpl_vars['salValue']['member_icon']['s_url']; ?>
" border="0" alt="<?php echo $this->_tpl_vars['salValue']['name']; ?>
" title="<?php echo $this->_tpl_vars['salValue']['name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(15,15,$this->_tpl_vars['salValue']['member_icon']['s_width'],$this->_tpl_vars['salValue']['member_icon']['s_height']); ?>
/></a>
                                    <a href="<?php echo $this->_tpl_vars['salValue']['member_profile_url']; ?>
" title="<?php echo $this->_tpl_vars['salValue']['name']; ?>
">
									<?php echo $this->_tpl_vars['salValue']['name']; ?>
</a>
                                </p>
                            </div>
                            <div class="clsArticleListDetails">
                                <ul>
                                	                                    <li>
                                        <span class="clsTotalComment"><?php echo $this->_tpl_vars['salValue']['record']['total_comments']; ?>
</span>&nbsp;<?php if ($this->_tpl_vars['salValue']['record']['total_comments'] > 1): ?><?php echo $this->_tpl_vars['LANG']['index_article_comments']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['index_article_comment']; ?>
<?php endif; ?>
                                    </li>
                                    <li>
                             	       <span><?php echo $this->_tpl_vars['salValue']['record']['total_views']; ?>
</span>&nbsp;<?php if ($this->_tpl_vars['salValue']['record']['total_views'] > 1): ?><?php echo $this->_tpl_vars['LANG']['index_article_views']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['index_article_view']; ?>
<?php endif; ?>
                                    </li>
                                    <li>
                                        <span><?php echo $this->_tpl_vars['salValue']['record']['total_favorites']; ?>
</span>&nbsp;<?php if ($this->_tpl_vars['salValue']['record']['total_favorites'] > 1): ?><?php echo $this->_tpl_vars['LANG']['index_article_favorites']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['index_article_favorite']; ?>
<?php endif; ?>
                                    </li>
                                    <?php if ($this->_tpl_vars['salValue']['record']['article_attachment']): ?>
                                        <li>
                                            <span><?php echo $this->_tpl_vars['salValue']['record']['total_downloads']; ?>
</span>&nbsp;<?php if ($this->_tpl_vars['salValue']['record']['total_downloads'] > 1): ?><?php echo $this->_tpl_vars['LANG']['index_article_downloads']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['index_article_download']; ?>
<?php endif; ?>
                                        </li>
                                    <?php endif; ?>
                                    <li class="clsRatingDisplay">
                                        <?php if ($this->_tpl_vars['myobj']->populateRatingDetails($this->_tpl_vars['salValue']['record']['rating'])): ?>
                                            <?php echo $this->_tpl_vars['myobj']->populateArticleRatingImages($this->_tpl_vars['salValue']['record']['rating'],'article'); ?>

                                        <?php else: ?>
                                           <?php echo $this->_tpl_vars['myobj']->populateArticleRatingImages(0,'article'); ?>

                                        <?php endif; ?>
                                        (<span><?php echo $this->_tpl_vars['salValue']['record']['rating_count']; ?>
</span>)
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
	      </div>
	    </div>
	  </div>
	  <?php endforeach; endif; unset($_from); ?>
	  	<div class="clsMoreLink"><h3 class=""><a href="<?php echo $this->_tpl_vars['populateCarousalarticleBlock_arr']['view_all_articles_link']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['index_article_see_all_articles']; ?>
"><?php echo $this->_tpl_vars['LANG']['index_article_see_all_articles']; ?>
</a></h3></div>
  <?php else: ?>
  	<div id="selMsgAlert" class="clsNoArticlesFound">
    	<p><?php echo $this->_tpl_vars['LANG']['index_article_no_articles_found']; ?>
</p>
    </div>
  <?php endif; ?>
</div>
</form>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'article_list_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



