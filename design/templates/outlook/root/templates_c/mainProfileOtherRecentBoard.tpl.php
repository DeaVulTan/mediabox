<?php /* Smarty version 2.6.18, created on 2011-10-18 15:28:01
         compiled from mainProfileOtherRecentBoard.tpl */ ?>
<?php if (isset ( $this->_tpl_vars['recentDiscussionBoards']['row'] ) && ( $this->_tpl_vars['recentDiscussionBoards']['row'] )): ?>
 <ul>
   <?php $_from = $this->_tpl_vars['recentDiscussionBoards']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['caption'] => $this->_tpl_vars['detail']):
?>
	 <li class="clsProfileBlockContentList">
			<p class="clsSubscribersInfoTitle"><?php echo $this->_tpl_vars['detail']['boardDetails']['board_link']; ?>
</p>						
			<p class="clsSubscriberDetails"><?php echo $this->_tpl_vars['LANG']['common_publishon']; ?>
 <span><?php echo $this->_tpl_vars['detail']['boardDetails']['pubdate']; ?>
</span>
			   <span class="clsSubscribeMembersName">by <a href="<?php echo $this->_tpl_vars['detail']['member_profile_url']; ?>
"><?php echo $this->_tpl_vars['detail']['boardDetails']['name']; ?>
</a></span>
			</p>
	 </li>
   <?php endforeach; endif; unset($_from); ?>
 </ul>  
<?php else: ?>
		<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['common_no_records_found']; ?>
</div>
<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['recentDiscussionBoards']['row'] ) && ( $this->_tpl_vars['recentDiscussionBoards']['row'] )): ?>
<div class="clsRecentViewAllMain">
	<a href="<?php echo $this->_tpl_vars['recentDiscussionBoards']['boards_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_viewall_boards']; ?>
</a>
</div>
<?php endif; ?>