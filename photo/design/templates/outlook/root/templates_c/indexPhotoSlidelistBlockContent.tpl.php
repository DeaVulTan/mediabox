<?php /* Smarty version 2.6.18, created on 2012-11-17 08:19:02
         compiled from indexPhotoSlidelistBlockContent.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'math', 'indexPhotoSlidelistBlockContent.tpl', 44, false),)), $this); ?>
<?php if ($this->_tpl_vars['photo_block_slide_record_count']): ?>
	<table class="clsPhotoCarouselList">
				<?php $this->assign('row_count', 4); ?>
		<?php $this->assign('break_count', 1); ?>
		<script type="text/javascript">
			original_height = new Array();
			original_width = new Array();
		</script>
		<?php $this->assign('array_count', '1'); ?>
		<?php $_from = $this->_tpl_vars['populateCarousalPhotoSlidelistBlock_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['upload_photoKey'] => $this->_tpl_vars['upload_playlistValue']):
?>
			<?php if ($this->_tpl_vars['break_count'] == 1): ?>
	   			<tr>
	    	<?php endif; ?>
					<td <?php if ($this->_tpl_vars['break_count'] == $this->_tpl_vars['row_count']): ?> class="clsFinalData" <?php endif; ?>>
						<div class="clsLargeThumbImageBackground" title="<?php echo $this->_tpl_vars['upload_playlistValue']['photo_playlist_name']; ?>
" <?php if (( $this->_tpl_vars['upload_playlistValue']['total_photos'] - $this->_tpl_vars['upload_playlistValue']['private_photo'] ) > 0): ?>onclick="Redirect2URL('<?php echo $this->_tpl_vars['upload_playlistValue']['view_playlisturl']; ?>
')" <?php endif; ?>>
							<?php if (( $this->_tpl_vars['upload_playlistValue']['total_photos'] - $this->_tpl_vars['upload_playlistValue']['private_photo'] ) > 0): ?>
								<a href="<?php echo $this->_tpl_vars['upload_playlistValue']['view_playlisturl']; ?>
" title="<?php echo $this->_tpl_vars['upload_playlistValue']['photo_playlist_name']; ?>
">
							<?php endif; ?>
	            				          				<?php echo $this->_tpl_vars['myobj']->displayPhotoList($this->_tpl_vars['upload_playlistValue']['photo_playlist_id'],true,4); ?>

	          				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

	        				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "photosInSlideListForIndex.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	    												<?php if (( $this->_tpl_vars['upload_playlistValue']['total_photos'] - $this->_tpl_vars['upload_playlistValue']['private_photo'] ) > 0): ?>
								</a>
							<?php endif; ?>
						</div>
						<div class="clsPhotoChannelCurrentPhoto">
							<p><?php if (( $this->_tpl_vars['upload_playlistValue']['total_photos'] - $this->_tpl_vars['upload_playlistValue']['private_photo'] ) > 0): ?>
                            <a href="<?php echo $this->_tpl_vars['upload_playlistValue']['view_playlisturl']; ?>
" title="<?php echo $this->_tpl_vars['upload_playlistValue']['photo_playlist_name']; ?>
"><pre><?php echo $this->_tpl_vars['upload_playlistValue']['photo_playlist_name']; ?>
</pre></a><?php else: ?><a href="javascript:;" title="<?php echo $this->_tpl_vars['upload_playlistValue']['photo_playlist_name']; ?>
"><pre><?php echo $this->_tpl_vars['upload_playlistValue']['photo_playlist_name']; ?>
</pre></a><?php endif; ?>
                            </p>
                        	<p class="clsSlidelistTotal"><?php echo $this->_tpl_vars['LANG']['index_popular_slidelist_total_photos']; ?>
&nbsp;<span><?php echo $this->_tpl_vars['upload_playlistValue']['total_photos']; ?>
</span></p>
						</div>
					</td>
			<?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
			<?php if ($this->_tpl_vars['break_count'] > $this->_tpl_vars['row_count']): ?>
				</tr>
				<?php $this->assign('break_count', 1); ?>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
		<?php if ($this->_tpl_vars['break_count'] != 1): ?>
    		    		<td colspan="<?php echo smarty_function_math(array('equation' => "(".($this->_tpl_vars['row_count'])."+1)-".($this->_tpl_vars['break_count'])), $this);?>
">&nbsp;</td>
    		</tr>
    	<?php endif; ?>
	</table>
<?php else: ?>
	<div class="clsNoRecordsFoundNoPadding"><?php echo $this->_tpl_vars['LANG']['sidebar_no_record_found_error_msg']; ?>
</div>
<?php endif; ?>