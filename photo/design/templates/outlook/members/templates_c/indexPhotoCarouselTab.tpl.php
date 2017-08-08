<?php /* Smarty version 2.6.18, created on 2011-10-17 15:12:17
         compiled from indexPhotoCarouselTab.tpl */ ?>
<?php if ($this->_tpl_vars['total_photo_list_pages']): ?>
<div class="clsCarouselContainer">
    <div class="clsIndexViewAll">
    	<ul id="<?php echo $this->_tpl_vars['showtab']; ?>
carouselPhotoList" class="jcarousel-skin-tango">
      		<!-- The content will be dynamically loaded here -->
    	</ul>
    	<div class="clsIndexViewAllLinks">
    		<?php if ($this->_tpl_vars['showtab'] == 'mostrecentphoto'): ?>
				<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photolist','?pg=photonew','photonew/','','photo'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['index_photo_view_all_photos']; ?>
"><?php echo $this->_tpl_vars['LANG']['index_photo_view_all_photos']; ?>
</a>
			<?php elseif ($this->_tpl_vars['showtab'] == 'topratedphoto'): ?>
				<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photolist','?pg=phototoprated','phototoprated/','','photo'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['index_photo_view_all_photos']; ?>
"><?php echo $this->_tpl_vars['LANG']['index_photo_view_all_photos']; ?>
</a>
			<?php endif; ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	var photo_carousel_tab = '<?php echo $this->_tpl_vars['showtab']; ?>
carouselPhotoList';
	<?php echo '
	jQuery(\'#\' + photo_carousel_tab).jcarousel({
		scroll: 1,
		size: '; ?>
<?php echo $this->_tpl_vars['total_photo_list_pages']; ?>
<?php echo ',
		block: \''; ?>
<?php echo $this->_tpl_vars['showtab']; ?>
<?php echo '\',
		itemFallbackDimension: 610,
		itemLoadCallback: photocarousel_itemLoadCallback
	});
	'; ?>

</script>
<?php else: ?>
<div class="clsNoRecordsFound">
	<?php if ($this->_tpl_vars['showtab'] == 'topratedphoto'): ?>
		<?php echo $this->_tpl_vars['LANG']['index_photo_block_top_rated_error_msg']; ?>

	<?php else: ?>
		<?php echo $this->_tpl_vars['LANG']['index_photo_block_recent_uploads_error_msg']; ?>

	<?php endif; ?>
</div>
<?php endif; ?>