<?php /* Smarty version 2.6.18, created on 2011-10-19 09:47:00
         compiled from pagination.tpl */ ?>
<?php if ($this->_tpl_vars['myobj']->isPagingRequired() && $this->_tpl_vars['smarty_paging_list']): ?>
<div class="clsPagingList">
	<ul>
		<!-- Previous link -->
		<?php if ($this->_tpl_vars['smarty_paging_list']['previous']['start']): ?>
			<li class="clsPrevLinkPage"><span><a href="<?php echo $this->_tpl_vars['smarty_paging_list']['first']['href']; ?>
" onclick="return <?php echo $this->_tpl_vars['smarty_paging_list']['first']['onclick']; ?>
" title="<?php echo $this->_tpl_vars['smarty_paging_list']['first']['display_text']; ?>
"><?php echo $this->_tpl_vars['smarty_paging_list']['first']['display_text']; ?>
</a></span></li>
		<?php else: ?>
			<li class="clsInactivePrevLinkPage clsInActivePageLink"><span><?php echo $this->_tpl_vars['smarty_paging_list']['first']['display_text']; ?>
</span></li>
		<?php endif; ?>
		<!-- First link -->
		<?php if ($this->_tpl_vars['smarty_paging_list']['first']['start']): ?>
			<li class="clsFirstPageLink"><span><a href="<?php echo $this->_tpl_vars['smarty_paging_list']['previous']['href']; ?>
" onclick="return <?php echo $this->_tpl_vars['smarty_paging_list']['previous']['onclick']; ?>
" title="<?php echo $this->_tpl_vars['smarty_paging_list']['previous']['display_text']; ?>
"><?php echo $this->_tpl_vars['smarty_paging_list']['previous']['display_text']; ?>
</a></span></li>
		<?php else: ?>
			<li class="clsFirstPageLink clsInActiveFirstPageLink"><span><?php echo $this->_tpl_vars['smarty_paging_list']['previous']['display_text']; ?>
</span></li>
		<?php endif; ?>
		<!-- paging list start -->
		<?php $_from = $this->_tpl_vars['smarty_paging_list']['list']['start']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['start']):
?>
			<?php if ($this->_tpl_vars['smarty_paging_list']['list']['start'][$this->_tpl_vars['key']]): ?>
				<li class="clsPagingLink"><a href="<?php echo $this->_tpl_vars['smarty_paging_list']['list']['href'][$this->_tpl_vars['key']]; ?>
" onclick="return <?php echo $this->_tpl_vars['smarty_paging_list']['list']['onclick'][$this->_tpl_vars['key']]; ?>
" title="<?php echo $this->_tpl_vars['smarty_paging_list']['list']['display_text'][$this->_tpl_vars['key']]; ?>
"><?php echo $this->_tpl_vars['smarty_paging_list']['list']['display_text'][$this->_tpl_vars['key']]; ?>
</a></li>
			<?php else: ?>
				<li class="clsCurrPageLink clsInActivePageLink"><span><?php echo $this->_tpl_vars['smarty_paging_list']['list']['display_text'][$this->_tpl_vars['key']]; ?>
</span></li>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
		<!-- pagin list end -->
		<!-- Last Link -->
		<?php if ($this->_tpl_vars['smarty_paging_list']['last']['start']): ?>
			<li class="clsLastPageLink"><span><a href="<?php echo $this->_tpl_vars['smarty_paging_list']['next']['href']; ?>
" onclick="return <?php echo $this->_tpl_vars['smarty_paging_list']['next']['onclick']; ?>
" title="<?php echo $this->_tpl_vars['smarty_paging_list']['next']['display_text']; ?>
"><?php echo $this->_tpl_vars['smarty_paging_list']['next']['display_text']; ?>
</a></span></li>
		<?php else: ?>
			<li class="clsLastPageLink clsLastInActivePageLink"><span><?php echo $this->_tpl_vars['smarty_paging_list']['next']['display_text']; ?>
</span></li>
		<?php endif; ?>
		<!-- Next link -->
		<?php if ($this->_tpl_vars['smarty_paging_list']['next']['start']): ?>
			<li class="clsNextPageLink"><span><a href="<?php echo $this->_tpl_vars['smarty_paging_list']['last']['href']; ?>
" onclick="return <?php echo $this->_tpl_vars['smarty_paging_list']['last']['onclick']; ?>
" title="<?php echo $this->_tpl_vars['smarty_paging_list']['last']['display_text']; ?>
"><?php echo $this->_tpl_vars['smarty_paging_list']['last']['display_text']; ?>
</a></span></li>
		<?php else: ?>
			<li class="clsInactiveNextPageLink clsInActivePageLink"><span><?php echo $this->_tpl_vars['smarty_paging_list']['last']['display_text']; ?>
</span></li>
		<?php endif; ?>
	</ul>
</div>
<?php endif; ?>