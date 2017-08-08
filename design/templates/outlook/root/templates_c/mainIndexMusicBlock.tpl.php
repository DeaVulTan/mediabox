<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:37
         compiled from mainIndexMusicBlock.tpl */ ?>
<?php if (chkAllowedModule ( array ( 'music' ) )): ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'musicblock_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsMainIndexmusicBlock">
   	<!--heading and right heading content starts-->
   	<div class="clsOverflow">
       	<h2 class="clsBlockHeading"><?php echo $this->_tpl_vars['LANG']['mainIndex_music']; ?>
</h2>
        <div class="clsBlockHeadingDetails">
            <?php $_from = $this->_tpl_vars['modulestatistics']['music']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['music_stats'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['music_stats']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['caption'] => $this->_tpl_vars['detail']):
        $this->_foreach['music_stats']['iteration']++;
?>
            <?php echo $this->_tpl_vars['detail']['lang']; ?>
: <span><?php echo $this->_tpl_vars['detail']['value']; ?>
</span>
            <?php if (! ($this->_foreach['music_stats']['iteration'] == $this->_foreach['music_stats']['total'])): ?><span class="clsSeperator">&nbsp;</span><?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
        </div>
    </div>
    <!--heading and right heading content ends-->
    
        <?php if ($this->_tpl_vars['total_music_carousel_pages']): ?>
            <div class="clsOverflow">
                <!-- Player section starts -->
                <div class="clsPlayerBlock" id="clsIndexMusicBlockPlayer">
                        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mainIndexMusicPlayer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                </div>
                <!-- Player section ends -->
                
                <div class="clsCarouselBlock">
                    <h3><?php echo $this->_tpl_vars['mainIndexObj']->LANG['mainIndex_music_heading']; ?>
</h3>
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'musicinner_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <div class="clsCarouselBlockContent">
                        <ul id="carouselMusicList" class="jcarousel-skin-tango">
                            <!-- The content will be dynamically loaded here -->
                        </ul>
                        <script type="text/javascript">
                            var music_index_ajax_url = '<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
index.php';
                            <?php echo '			
                            function mainmusiccarousel_itemLoadCallback(carousel, state)
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
                                        limit: 4,
                                        mainmusicblock: block
                                    },
                                    function(data) {
                                        //add the returned response from the ajax call as the item
                                        carousel.add(i, data);
                                    }
                                );
                            };
                            jQuery(\'#carouselMusicList\').jcarousel({
                                    scroll: 1,
                                    size: '; ?>
<?php echo $this->_tpl_vars['total_music_carousel_pages']; ?>
<?php echo ',
                                    block: \''; ?>
<?php echo $this->_tpl_vars['mainIndexObj']->default_music_block; ?>
<?php echo '\',
                                    itemFallbackDimension: 610,
                                    itemLoadCallback: mainmusiccarousel_itemLoadCallback
                                });
                            '; ?>

                        </script>
                    </div>
                    <div class="clsMainIndexViewAllLinks">
						<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('musiclist','?pg=musicnew','musicnew/','','music'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['mainIndex_music_view_all']; ?>
">&nbsp; <?php echo $this->_tpl_vars['LANG']['mainIndex_music_view_all']; ?>
</a>
					</div>            
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'musicinner_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>                
                </div>
            </div>
        <?php else: ?>
            <div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['mainIndex_music_no_record']; ?>
</div>
        <?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'musicblock_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>