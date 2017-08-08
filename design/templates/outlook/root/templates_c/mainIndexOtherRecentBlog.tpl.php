<?php /* Smarty version 2.6.18, created on 2011-10-18 16:12:26
         compiled from mainIndexOtherRecentBlog.tpl */ ?>

    <div class="clsOtherBlocksContent">
        <div class="clsBlogContent">
		  <div class="clsIndexBlogContent">
            <h3><?php echo $this->_tpl_vars['LANG']['recent_blogs']; ?>
</h3>
            <?php if (isset ( $this->_tpl_vars['populateBlogRecentBlock_arr']['row'] ) && ( $this->_tpl_vars['populateBlogRecentBlock_arr']['row'] )): ?>
                <?php $_from = $this->_tpl_vars['populateBlogRecentBlock_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['caption'] => $this->_tpl_vars['detail']):
?>
                <div class="clsOtherBlockContentList">
                    <p class="clsTitle"><a href="<?php echo $this->_tpl_vars['detail']['view_blog_post_link']; ?>
"><?php echo $this->_tpl_vars['detail']['record']['blog_post_name']; ?>
</a></p>
                    <p class="clsPostedName">(<?php echo $this->_tpl_vars['LANG']['in_blogs']; ?>
: <a href="<?php echo $this->_tpl_vars['detail']['view_blog_link']; ?>
" title="<?php echo $this->_tpl_vars['detail']['record']['blog_name']; ?>
"><?php echo $this->_tpl_vars['detail']['record']['blog_name']; ?>
</a>)</p>
                    <div class="clsOtherBlockMainContent"><?php echo $this->_tpl_vars['detail']['message']; ?>
</div>
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'othercontent_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        <div class="clsOverflow">
                            <div class="clsMembersName">by <img src="<?php echo $this->_tpl_vars['detail']['member_icon']['t_url']; ?>
" alt="<?php echo $this->_tpl_vars['detail']['name']; ?>
" title="<?php echo $this->_tpl_vars['detail']['name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(66,66,$this->_tpl_vars['detail']['member_icon']['t_width'],$this->_tpl_vars['detail']['member_icon']['t_height']); ?>
 /> <a href="<?php echo $this->_tpl_vars['detail']['member_profile_url']; ?>
"><?php echo $this->_tpl_vars['detail']['name']; ?>
</a></div>
                            <div class="clsContentDetails">
                                <ul class="clsFloatRight">
                                	<li><?php echo $this->_tpl_vars['detail']['record']['published_date']; ?>
</li>
                                    <li><span><?php echo $this->_tpl_vars['detail']['record']['total_comments']; ?>
</span> <?php echo $this->_tpl_vars['LANG']['common_comment']; ?>
</li>
                                    <li><span><?php echo $this->_tpl_vars['detail']['record']['total_views']; ?>
</span>  <?php echo $this->_tpl_vars['LANG']['common_views']; ?>
</li>
                                    <li class="clsBackgroundNone"><span><?php echo $this->_tpl_vars['detail']['record']['total_favorites']; ?>
</span>  <?php echo $this->_tpl_vars['LANG']['common_favourites']; ?>
</li>
                                </ul>
                            </div>
                        </div>
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'othercontent_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                </div>
                <?php endforeach; endif; unset($_from); ?>
            <?php else: ?>
            	<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['common_no_records_found']; ?>
</div>
            <?php endif; ?> 
			</div>
            <?php if (isset ( $this->_tpl_vars['populateBlogRecentBlock_arr']['row'] ) && ( $this->_tpl_vars['populateBlogRecentBlock_arr']['row'] )): ?>           
            	<div class="clsViewAll">
               		 <a href="<?php echo $this->_tpl_vars['populateBlogRecentBlock_arr']['blog_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_viewall_blogs']; ?>
</a>
            	</div>
            <?php endif; ?>
        </div>
    </div>