<?php /* Smarty version 2.6.18, created on 2011-10-18 17:54:54
         compiled from mainIndexVideoBlockHead.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'videoinner_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script language="javascript" type="text/javascript">
var module_name_js="video";
</script>
<div class="clsCarouselBlockContent">
    <ul id="carouselVideoList" class="jcarousel-skin-tango">
      	<!-- The content will be dynamically loaded here -->
    </ul>
	<script type="text/javascript">
        var video_index_ajax_url = '<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
index.php';
        <?php echo '
    
        function mainvideocarousel_itemLoadCallback(carousel, state)
        {
            var block = carousel.blockName();
            var i = carousel.first;
    
            // need not call ajax again if the carousel page is already fetched
            if (carousel.has(i)) {
                return;
            }
    
            jQuery.get(
                video_index_ajax_url,
                {
                    start: i,
                    limit: 4,
                    mainvideoblock: block
                },
                function(data) {
                    //add the returned response from the ajax call as the item
                    carousel.add(i, data);
                }
            );
        };
        jQuery(\'#carouselVideoList\').jcarousel({
                scroll: 1,
                size: '; ?>
<?php echo $this->_tpl_vars['total_video_carousel_pages']; ?>
<?php echo ',
                block: \''; ?>
<?php echo $this->_tpl_vars['mainIndexObj']->default_video_block; ?>
<?php echo '\',
                itemFallbackDimension: 610,
                itemLoadCallback: mainvideocarousel_itemLoadCallback
            });
    
    </script>
    '; ?>

 </div> 
<div class="clsMainIndexViewAllLinks">
	<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('videolist','?pg=videonew','videonew/','','video'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['mainIndex_video_view_all']; ?>
"><?php echo $this->_tpl_vars['LANG']['mainIndex_video_view_all']; ?>
</a>
</div>            
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'videoinner_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>