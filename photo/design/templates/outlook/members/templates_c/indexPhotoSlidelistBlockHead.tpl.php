<?php /* Smarty version 2.6.18, created on 2011-10-17 15:12:14
         compiled from indexPhotoSlidelistBlockHead.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'indexphotomain_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script language="javascript" type="text/javascript">
var module_name_js="photo";
</script>
<?php $this->assign('slidelist_limit_per_page', 4); ?>
<div class="clsIndexPopularSlideList">
	<div class="clsJQCarousel" id="popularSlidelistTabs">
		<h3 class="clsJQCarouselHead"><?php echo $this->_tpl_vars['LANG']['index_popular_slidelist']; ?>
</h3>
        <ul class="clsJQCarouselTabs clsOverflow">
            <li><a href="index.php?slidelist_tab=slidelistmostviewed&slidelist_limit=<?php echo $this->_tpl_vars['slidelist_limit_per_page']; ?>
"><span style="display:none;"><?php echo $this->_tpl_vars['LANG']['index_popular_slidelist']; ?>
</span></a></li>
        </ul>
    </div>
</div>
<script type="text/javascript">
	<?php echo '
	function popularSlidelistcarousel_itemLoadCallback(carousel, state)
	{
		var slidelist_block = carousel.options.slidelist_block;
		var slidelist_item = carousel.first;

		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(slidelist_item)) {
            return;
        }

		jQuery.get(
			photo_index_ajax_url,
			{
				slidelist_start: slidelist_item,
				slidelist_limit: '; ?>
<?php echo $this->_tpl_vars['slidelist_limit_per_page']; ?>
<?php echo ',
				slidelist_block: slidelist_block
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(slidelist_item, data);
			}
		);
	};

	$Jq(window).load(function(){
		attachJqueryTabs(\'popularSlidelistTabs\');
	});

	'; ?>

</script>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'indexphotomain_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>