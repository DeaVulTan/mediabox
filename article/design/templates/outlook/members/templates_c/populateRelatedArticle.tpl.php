<?php /* Smarty version 2.6.18, created on 2012-02-01 20:18:01
         compiled from populateRelatedArticle.tpl */ ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('populate_related_article')): ?>
    <?php if ($this->_tpl_vars['populateRelatedArticle_arr']['total_records']): ?>
        <div>
            <?php $_from = $this->_tpl_vars['populateRelatedArticle_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['rowKey'] => $this->_tpl_vars['rowValue']):
?>
          <div class="clsMoreArticleDisplay">
                        <p class="clsMoreArticleTitle"><a href="<?php echo $this->_tpl_vars['rowValue']['article_title_url']; ?>
"><?php echo $this->_tpl_vars['rowValue']['article_title']; ?>
</a></p>
                        <p class="clsMoreArticleInfo"><?php echo $this->_tpl_vars['rowValue']['article_summary']; ?>
</p>
                        <p class="clsMoreArticleDetails"><?php echo $this->_tpl_vars['LANG']['viewarticle_from']; ?>
&nbsp;<a href="<?php echo $this->_tpl_vars['rowValue']['memberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['rowValue']['name']; ?>
</a><span class="clsLinkSeperator">|</span><span><?php echo $this->_tpl_vars['LANG']['viewarticle_views']; ?>
</span>&nbsp;<?php echo $this->_tpl_vars['rowValue']['row_total_views']; ?>
</p>
         </div>
            <?php endforeach; endif; unset($_from); ?>

            <?php if ($this->_tpl_vars['populateRelatedArticle_arr']['total_records'] == $this->_tpl_vars['CFG']['admin']['articles']['total_related_article'] && $this->_tpl_vars['populateRelatedArticle_arr']['pg'] != 'tag'): ?>
                <div class="clsMoreArticleLinks">
                  <a href="<?php echo $this->_tpl_vars['populateRelatedArticle_arr']['more_link']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewarticle_see_all_articles']; ?>
</a>
                </div>
            <?php endif; ?>
          </div>
    <?php else: ?>
        <div class="clsNoArticlesFound">
               <p><?php echo $this->_tpl_vars['LANG']['viewarticle_no_related_articles_found']; ?>
</p>
        </div>
    <?php endif; ?>
<?php endif; ?>