<?php /* Smarty version 2.6.18, created on 2011-10-17 15:09:54
         compiled from indexFeaturedAlbumsHead.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audiocontent_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $this->assign('albums_limit_per_page', 4); ?>
<div class="clsIndexFearuredAlbum" id="indexFeaturedAlbumContainer">
	<div class="clsJQCarousel" id="featuredAlbumsTabs">
		<h3 class="clsJQCarouselHead"><?php echo $this->_tpl_vars['LANG']['myhome_featured_albums']; ?>
</h3>
        <ul class="clsJQCarouselTabs clsOverflow">
            <li><a href="index.php?albums_tab=featured&limit=<?php echo $this->_tpl_vars['albums_limit_per_page']; ?>
"><span style="display:none;"><?php echo $this->_tpl_vars['LANG']['myhome_featured_albums']; ?>
</span></a></li>
        </ul>
    </div>
</div>
<script type="text/javascript">
	addLoadingBg('indexFeaturedAlbumContainer');
	<?php echo '
	function featuredAlbumscarousel_itemLoadCallback(carousel, state)
	{
		var albums_block = carousel.options.albums_block;
		var albums_item = carousel.first;
		
		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(albums_item)) {
            return;
        }

		jQuery.get(
			music_index_ajax_url,
			{
				start: albums_item,
				limit: '; ?>
<?php echo $this->_tpl_vars['albums_limit_per_page']; ?>
<?php echo ',
				albums_block: albums_block
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(albums_item, data);
			}
		);
	};
	
	$Jq(window).load(function(){
		attachJqueryTabs(\'featuredAlbumsTabs\');
	});
	
	'; ?>

</script>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audiocontent_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>