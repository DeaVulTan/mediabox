<?php /* Smarty version 2.6.18, created on 2011-10-18 16:12:27
         compiled from mainIndexOtherRecentBoard.tpl */ ?>

    <div class="clsOtherBlocksContent">
        <div class="clsForumContent">
		  <div class="clsIndexForumContent">	
            <h3><?php echo $this->_tpl_vars['LANG']['recent_boards']; ?>
</h3>
            <?php if (isset ( $this->_tpl_vars['recentDiscussionBoards']['row'] ) && ( $this->_tpl_vars['recentDiscussionBoards']['row'] )): ?>
               <?php $_from = $this->_tpl_vars['recentDiscussionBoards']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['caption'] => $this->_tpl_vars['detail']):
?>
                <div class="clsOtherBlockContentList">
                    <p class="clsTitle"><?php echo $this->_tpl_vars['detail']['boardDetails']['board_link']; ?>
  </p>
                    <div class="clsOtherBlockMainContent"><?php echo $this->_tpl_vars['detail']['boardDetails']['description']; ?>
</div>
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'othercontent_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        <div class="clsOverflow">
                            <div class="clsMembersName">by <img src="<?php echo $this->_tpl_vars['detail']['member_icon']['t_url']; ?>
" alt="<?php echo $this->_tpl_vars['detail']['boardDetails']['name']; ?>
" title="<?php echo $this->_tpl_vars['detail']['boardDetails']['name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(66,66,$this->_tpl_vars['detail']['member_icon']['t_width'],$this->_tpl_vars['detail']['member_icon']['t_height']); ?>
 /><a href="<?php echo $this->_tpl_vars['detail']['member_profile_url']; ?>
"><?php echo $this->_tpl_vars['detail']['boardDetails']['name']; ?>
</a></div>
                            <div class="clsContentDetails">
                                <ul class="clsFloatRight">
                                 	<li><?php echo $this->_tpl_vars['detail']['boardDetails']['pubdate']; ?>
</li>
                                    <li><span><?php echo $this->_tpl_vars['detail']['boardDetails']['total_solutions']; ?>
</span> <?php echo $this->_tpl_vars['LANG']['common_solutions']; ?>
</li>
                                    <li class="clsBackgroundNone"><span><?php echo $this->_tpl_vars['detail']['boardDetails']['total_views']; ?>
</span>  <?php echo $this->_tpl_vars['LANG']['common_views']; ?>
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
            <?php if (isset ( $this->_tpl_vars['recentDiscussionBoards']['row'] ) && ( $this->_tpl_vars['recentDiscussionBoards']['row'] )): ?>
            	<div class="clsViewAll">
               	 	<a href="<?php echo $this->_tpl_vars['recentDiscussionBoards']['boards_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_viewall_boards']; ?>
</a>
           		 </div>
            <?php endif; ?>
        </div>
    </div>