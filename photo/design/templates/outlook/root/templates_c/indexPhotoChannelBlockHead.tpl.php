<?php /* Smarty version 2.6.18, created on 2011-10-18 17:31:50
         compiled from indexPhotoChannelBlockHead.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'indexphotomain_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script language="javascript" type="text/javascript">
var module_name_js="photo";
</script>
<?php $this->assign('category_limit_per_page', 2); ?>
<?php $this->assign('photo_limit_per_category', 4); ?>
<?php $this->assign('total_category', $this->_tpl_vars['myobj']->getTotalCategoryListPages('mostrecentphoto',$this->_tpl_vars['category_limit_per_page'])); ?>
<div class="clsPhotoCategoryContainer">
<div class="clsIndexPhotoChannelContainer">
    <div class="clsIndexPhotoCategoryHeading clsIndexCategoryHeading">
        <h3><span><?php echo $this->_tpl_vars['LANG']['sidebar_photo_channel_label']; ?>
</span></h3>
    </div>
</div>
<?php if ($this->_tpl_vars['total_category']): ?>
	<div class="clsIndexPhotoCategory">
	    <div class="clsCarouselContainer">
	    	<div class="clsIndexViewAll">
	    		<ul id="carouselChannelList" class="jcarousel-skin-tango">
	      			<!-- The content will be dynamically loaded here -->
	    		</ul>
	    		<div class="clsIndexViewAllLinks">
	    			<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photocategory','','','','photo'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['index_photo_view_all_categories']; ?>
"><?php echo $this->_tpl_vars['LANG']['index_photo_view_all_categories']; ?>
</a>
	    		</div>
	    	</div>
		</div>
	</div>
<?php else: ?>
	<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['index_photo_categories_block_error_msg']; ?>
</div>
<?php endif; ?>
</div>
<script type="text/javascript">
	var photo_index_ajax_url = '<?php echo $this->_tpl_vars['CFG']['site']['photo_url']; ?>
index.php';
	<?php echo '

	function photochannelcarousel_itemLoadCallback(carousel, state)
	{
		var block = carousel.blockName();
		var i = carousel.first;
		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(i)) {
            return;
        }

		jQuery.get(
			photo_index_ajax_url,
			{
				start: i,
				limit: '; ?>
<?php echo $this->_tpl_vars['category_limit_per_page']; ?>
<?php echo ',
				photo_limit: '; ?>
<?php echo $this->_tpl_vars['photo_limit_per_category']; ?>
<?php echo ',
				photoChannel: block
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(i, data);
			}
		);
	};
	jQuery(\'#carouselChannelList\').jcarousel({
			scroll: 1,
			size: '; ?>
<?php echo $this->_tpl_vars['total_category']; ?>
<?php echo ',
			block: \'mostrecentphoto\',
			itemFallbackDimension: 610,
			itemLoadCallback: photochannelcarousel_itemLoadCallback
		});

'; ?>

</script>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'indexphotomain_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>