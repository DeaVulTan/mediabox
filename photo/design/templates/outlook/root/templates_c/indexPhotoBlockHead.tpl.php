<?php /* Smarty version 2.6.18, created on 2011-10-18 17:31:50
         compiled from indexPhotoBlockHead.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'indexphotomain_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script language="javascript" type="text/javascript">
var photo_tabs_divid_array = new Array();
var module_name_js="photo";
</script>
<?php $this->assign('photo_limit_per_page', 4); ?>
<div class="clsIndexPhotoContainer">
	<div class="clsJQCarousel" id="photoListTabs">
		<h3 class="clsJQCarouselHead"><?php echo $this->_tpl_vars['LANG']['sidebar_photo_label']; ?>
</h3>
        <ul class="clsJQCarouselTabs clsOverflow">
        	<li id="mostrecentphoto_Head"><a href="index.php?showtab=mostrecentphoto&limit=<?php echo $this->_tpl_vars['photo_limit_per_page']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['sidebar_photo_most_recent']; ?>
</span></a></li>
        	            <li id="topratedphoto_Head"><a href="index.php?showtab=topratedphoto&limit=<?php echo $this->_tpl_vars['photo_limit_per_page']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['sidebar_top_rating_label']; ?>
</span></a></li>
        </ul>
    </div>
</div>
<script type="text/javascript">
	var photo_index_ajax_url = '<?php echo $this->_tpl_vars['CFG']['site']['photo_url']; ?>
index.php';

	<?php echo '
	function photocarousel_itemLoadCallback(carousel, state)
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
<?php echo $this->_tpl_vars['photo_limit_per_page']; ?>
<?php echo ',
				block: block
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(i, data);
			}
		);
	};

	$Jq(window).load(function(){
		attachJqueryTabs(\'photoListTabs\');
	});
	'; ?>

</script>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'indexphotomain_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>