<?php /* Smarty version 2.6.18, created on 2011-10-17 15:12:18
         compiled from indexPopularSlidelistCarouselTab.tpl */ ?>
<?php if ($this->_tpl_vars['total_popular_slidelist_pages']): ?>
<div class="clsCarouselContainer">
	<div class="clsIndexViewAll">
    	<ul id="<?php echo $this->_tpl_vars['slidelist_tab']; ?>
carouselPhotoList" class="jcarousel-skin-tango">
      		<!-- The content will be dynamically loaded here -->
    	</ul>
    	<div class="clsIndexViewAllLinks">
    		<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photoslidelist','?pg=slidelistnew','slidelistnew/','','photo'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['index_photo_view_all_slidelist']; ?>
"><?php echo $this->_tpl_vars['LANG']['index_photo_view_all_slidelist']; ?>
</a>
    	</div>
    </div>
</div>
<script type="text/javascript">
	var slidelist_carousel_tab = '<?php echo $this->_tpl_vars['slidelist_tab']; ?>
carouselPhotoList';
	<?php echo '
	jQuery(\'#\' + slidelist_carousel_tab).jcarousel({
		scroll: 1,
		size: '; ?>
<?php echo $this->_tpl_vars['total_popular_slidelist_pages']; ?>
<?php echo ',
		slidelist_block: \''; ?>
<?php echo $this->_tpl_vars['slidelist_tab']; ?>
<?php echo '\',
		itemFallbackDimension: 610,
		itemLoadCallback: popularSlidelistcarousel_itemLoadCallback
	});
	'; ?>

</script>
<?php else: ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['index_popular_slidelist_block_error_msg']; ?>
</div>
<?php endif; ?>