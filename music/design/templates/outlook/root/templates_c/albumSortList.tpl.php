<?php /* Smarty version 2.6.18, created on 2012-01-12 23:00:07
         compiled from albumSortList.tpl */ ?>
<?php if ($this->_tpl_vars['displaySongList_arr']['record_count']): ?>
	<?php $this->assign('count', '1'); ?>
	<div class="clsAlbumShotListDetails">
		<table width="100%">
			<tr>
				<?php $_from = $this->_tpl_vars['displaySongList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sortListKey'] => $this->_tpl_vars['sortListValue']):
?>
				<?php if ($this->_tpl_vars['sortListValue']['open_tr'] != ''): ?><?php echo $this->_tpl_vars['sortListValue']['open_tr']; ?>
 <?php endif; ?>
			        <?php echo $this->_tpl_vars['sortListValue']['album_title_wrap']; ?>
<?php echo $this->_tpl_vars['sortListValue']['song_count']; ?>
<?php echo $this->_tpl_vars['sortListValue']['album_title_end']; ?>

				<?php if ($this->_tpl_vars['sortListValue']['close_tr'] != ''): ?><?php echo $this->_tpl_vars['sortListValue']['close_tr']; ?>
<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>
			</tr>
		</table>
	</div>
<?php endif; ?>