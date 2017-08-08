<?php /* Smarty version 2.6.18, created on 2011-10-17 15:09:57
         compiled from indexFeaturedAlbumsCarouselTab.tpl */ ?>
<script type="text/javascript">
	removeLoadingBg('indexFeaturedAlbumContainer');
</script>
<?php if ($this->_tpl_vars['total_featured_albums_pages']): ?>
<div class="clsCarouselContainer">
    <ul id="<?php echo $this->_tpl_vars['albums_tab']; ?>
carouselMusicList" class="jcarousel-skin-tango">    	
      	<!-- The content will be dynamically loaded here -->
    </ul>
	<div class="clsIndexViewAllLinks">
			<a title="<?php echo $this->_tpl_vars['LANG']['myhome_music_view_all_albums']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->view_all_albums_url; ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_music_view_all_albums']; ?>
</a>
	</div>

</div>

<script type="text/javascript">
	var albums_carousel_tab = '<?php echo $this->_tpl_vars['albums_tab']; ?>
carouselMusicList';
	<?php echo '
	jQuery(\'#\' + albums_carousel_tab).jcarousel({
		scroll: 1,
		size: '; ?>
<?php echo $this->_tpl_vars['total_featured_albums_pages']; ?>
<?php echo ',
		albums_block: \''; ?>
<?php echo $this->_tpl_vars['albums_tab']; ?>
<?php echo '\',
		itemFallbackDimension: 610,
		itemLoadCallback: featuredAlbumscarousel_itemLoadCallback
	});
	'; ?>

</script>
<?php else: ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_featured_album_found_error_msg']; ?>
</div>
<?php endif; ?>