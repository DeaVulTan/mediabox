<?php /* Smarty version 2.6.18, created on 2011-10-31 10:32:25
         compiled from ../general/pagination.tpl */ ?>
<?php if ($this->_tpl_vars['myobj']->isPagingRequired() && $this->_tpl_vars['smarty_paging_list']): ?>
<div class="clsPagingList">
	<ul>
		<!-- Previous link -->
		<?php if ($this->_tpl_vars['smarty_paging_list']['previous']['start']): ?>
			<li class="clsPrevLinkPage"><a href="<?php echo $this->_tpl_vars['smarty_paging_list']['first']['href']; ?>
" onclick="return <?php echo $this->_tpl_vars['smarty_paging_list']['first']['onclick']; ?>
"><span><?php echo $this->_tpl_vars['smarty_paging_list']['first']['display_text']; ?>
</span></a></li>
		<?php else: ?>
			<li class="clsInactivePrevLinkPage clsInActivePageLink"><span><?php echo $this->_tpl_vars['smarty_paging_list']['first']['display_text']; ?>
</span></li>
		<?php endif; ?>
		<!-- First link -->
		<?php if ($this->_tpl_vars['smarty_paging_list']['first']['start']): ?>
			<li class="clsFirstPageLink"><a href="<?php echo $this->_tpl_vars['smarty_paging_list']['previous']['href']; ?>
" onclick="return <?php echo $this->_tpl_vars['smarty_paging_list']['previous']['onclick']; ?>
"><span><?php echo $this->_tpl_vars['smarty_paging_list']['previous']['display_text']; ?>
</span></a></li>
		<?php else: ?>
			<li class="clsInactiveFirstPageLink clsInActivePageLink"><span><?php echo $this->_tpl_vars['smarty_paging_list']['previous']['display_text']; ?>
</span></li>
		<?php endif; ?>
		<!-- paging list start -->
		<?php $_from = $this->_tpl_vars['smarty_paging_list']['list']['start']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['start']):
?>
			<?php if ($this->_tpl_vars['smarty_paging_list']['list']['start'][$this->_tpl_vars['key']]): ?>
				<li class="clsPagingLink"><a href="<?php echo $this->_tpl_vars['smarty_paging_list']['list']['href'][$this->_tpl_vars['key']]; ?>
" onclick="return <?php echo $this->_tpl_vars['smarty_paging_list']['list']['onclick'][$this->_tpl_vars['key']]; ?>
"><span><?php echo $this->_tpl_vars['smarty_paging_list']['list']['display_text'][$this->_tpl_vars['key']]; ?>
</span></a></li>
			<?php else: ?>
				<li class="clsCurrPageLink clsInActivePageLink"><span><?php echo $this->_tpl_vars['smarty_paging_list']['list']['display_text'][$this->_tpl_vars['key']]; ?>
</span></li>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
		<!-- pagin list end -->
		<!-- Last Link -->
		<?php if ($this->_tpl_vars['smarty_paging_list']['last']['start']): ?>
			<li class="clsLastPageLink"><a href="<?php echo $this->_tpl_vars['smarty_paging_list']['next']['href']; ?>
" onclick="return <?php echo $this->_tpl_vars['smarty_paging_list']['next']['onclick']; ?>
"><span><?php echo $this->_tpl_vars['smarty_paging_list']['next']['display_text']; ?>
</span></a></li>
		<?php else: ?>
			<li class="clsInactiveLastPageLink clsInActivePageLink"><span><?php echo $this->_tpl_vars['smarty_paging_list']['next']['display_text']; ?>
</span></li>
		<?php endif; ?>
		<!-- Next link -->
		<?php if ($this->_tpl_vars['smarty_paging_list']['next']['start']): ?>
			<li class="clsNextPageLink"><a href="<?php echo $this->_tpl_vars['smarty_paging_list']['last']['href']; ?>
" onclick="return <?php echo $this->_tpl_vars['smarty_paging_list']['last']['onclick']; ?>
"><span><?php echo $this->_tpl_vars['smarty_paging_list']['last']['display_text']; ?>
</span></a></li>
		<?php else: ?>
			<li class="clsInactiveNextPageLink clsInActivePageLink"><span><?php echo $this->_tpl_vars['smarty_paging_list']['last']['display_text']; ?>
</span></li>
		<?php endif; ?>
	</ul>
</div>
<?php endif; ?>