<?php /* Smarty version 2.6.18, created on 2011-10-18 15:29:58
         compiled from indexAudioBlockHead.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audiocontent_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $this->assign('music_limit_per_page', 4); ?>
<div class="clsIndexAudioContainer" id="indexAudioContainer">
    <div class="clsJQCarousel" id="musicListTabs">
		<h3 class="clsJQCarouselHead"><?php echo $this->_tpl_vars['LANG']['sidebar_audio_label']; ?>
</h3>
        <ul class="clsJQCarouselTabs clsOverflow">
            <li id="newmusic_Head"><a href="index.php?showtab=newmusic&limit=<?php echo $this->_tpl_vars['music_limit_per_page']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['sidebar_recently_upldated_label']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['sidebar_recently_upldated_label']; ?>
</span></a></li>
            <li id="topratedmusic_Head"><a href="index.php?showtab=topratedmusic&limit=<?php echo $this->_tpl_vars['music_limit_per_page']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['sidebar_top_rating_label']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['sidebar_top_rating_label']; ?>
</span></a></li>
        </ul>
    </div>
</div>
<script type="text/javascript">
	var music_index_ajax_url = '<?php echo $this->_tpl_vars['CFG']['site']['music_url']; ?>
index.php';
	addLoadingBg('indexAudioContainer');
	<?php echo '
	function musiccarousel_itemLoadCallback(carousel, state)
	{
		var block = carousel.blockName();
		var i = carousel.first;

		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(i)) {
            return;
        }

		jQuery.get(
			music_index_ajax_url,
			{
				start: i,
				limit: '; ?>
<?php echo $this->_tpl_vars['music_limit_per_page']; ?>
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
		attachJqueryTabs(\'musicListTabs\');
	});
	'; ?>

</script>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audiocontent_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>