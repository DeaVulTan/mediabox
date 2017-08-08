<?php /* Smarty version 2.6.18, created on 2011-10-17 15:09:54
         compiled from indexTopChartHead.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audiocontent_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $this->assign('top_chart_limit_per_page', 4); ?>
<div class="clsIndexTopChart" id="indexTopChartContainer">
<div class="clsJQCarousel" id="indexTopChartTabs">
		<h3 class="clsJQCarouselHead"><?php echo $this->_tpl_vars['LANG']['sidebar_topchart_label']; ?>
</h3>
        <ul class="clsJQCarouselTabs clsOverflow">
        	<?php $_from = $this->_tpl_vars['myobj']->sidebar_topchart_block['display_order']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['showKey'] => $this->_tpl_vars['showValue']):
?>
            <?php $this->assign('topchartDivID', $this->_tpl_vars['showValue']['divID']); ?>
            <li id="<?php echo $this->_tpl_vars['showValue']['divID']; ?>
_Head">
                <a href="index.php?top_chart_tab=<?php echo $this->_tpl_vars['showValue']['divID']; ?>
&limit=<?php echo $this->_tpl_vars['top_chart_limit_per_page']; ?>
"><span><?php echo $this->_tpl_vars['showValue']['lang']; ?>
</span></a>
            </li>
       		<?php endforeach; endif; unset($_from); ?>
        </ul>
    </div>
</div>
<script type="text/javascript">
	addLoadingBg('indexTopChartContainer');
	<?php echo '
	function topChartCarousel_itemLoadCallback(carousel, state)
	{
		var topChart = carousel.options.topChart;
		var top_chart_item = carousel.first;

		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(top_chart_item)) {
            return;
        }

		jQuery.get(
			music_index_ajax_url,
			{
				start: top_chart_item,
				limit: '; ?>
<?php echo $this->_tpl_vars['top_chart_limit_per_page']; ?>
<?php echo ',
				topChart: topChart
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(top_chart_item, data);
			}
		);
	};

	$Jq(window).load(function(){
		$Jq("#indexTopChartTabs").tabs({
			cache: true
		});
	});
	'; ?>

</script>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audiocontent_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>