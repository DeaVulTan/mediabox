<?php /* Smarty version 2.6.18, created on 2011-10-17 15:09:54
         compiled from indexPopularPlaylistHead.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audiocontent_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $this->assign('playlist_limit_per_page', 4); ?>
<div class="clsIndexFearuredAlbum" id="indexPopularPlaylistContainer">
	<div class="clsJQCarousel" id="popularPlaylistTabs">
		<h3 class="clsJQCarouselHead"><?php echo $this->_tpl_vars['LANG']['myhome_popular_playlist']; ?>
</h3>
        <ul class="clsJQCarouselTabs clsOverflow">
            <li><a href="index.php?playlist_tab=playlistmostviewed&limit=<?php echo $this->_tpl_vars['playlist_limit_per_page']; ?>
"><span style="display:none;"><?php echo $this->_tpl_vars['LANG']['myhome_popular_playlist']; ?>
</span></a></li>
        </ul>
    </div>
</div>
<script type="text/javascript">
	addLoadingBg('indexPopularPlaylistContainer');
	<?php echo '
	function popularPlaylistcarousel_itemLoadCallback(carousel, state)
	{
		var playlist_block = carousel.options.playlist_block;
		var playlist_item = carousel.first;
		
		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(playlist_item)) {
            return;
        }

		jQuery.get(
			music_index_ajax_url,
			{
				start: playlist_item,
				limit: '; ?>
<?php echo $this->_tpl_vars['playlist_limit_per_page']; ?>
<?php echo ',
				playlist_block: playlist_block
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(playlist_item, data);
			}
		);
	};
	
	$Jq(window).load(function(){
		attachJqueryTabs(\'popularPlaylistTabs\');
	});
	
	'; ?>

</script>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audiocontent_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>