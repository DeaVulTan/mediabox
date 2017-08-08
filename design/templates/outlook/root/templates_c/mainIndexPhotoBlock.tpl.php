<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:37
         compiled from mainIndexPhotoBlock.tpl */ ?>
<?php if (chkAllowedModule ( array ( 'photo' ) )): ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'photoblock_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsMainIndexphotoBlock">
   	<!--heading and right heading content starts-->
   	<div class="clsOverflow">
       	<h2 class="clsBlockHeading"><?php echo $this->_tpl_vars['LANG']['mainIndex_photo']; ?>
</h2>
        <div class="clsBlockHeadingDetails">
        <?php $_from = $this->_tpl_vars['modulestatistics']['photo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['photo_stats'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['photo_stats']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['caption'] => $this->_tpl_vars['detail']):
        $this->_foreach['photo_stats']['iteration']++;
?>
        <?php echo $this->_tpl_vars['detail']['lang']; ?>
: <span><?php echo $this->_tpl_vars['detail']['value']; ?>
</span>
        <?php if (! ($this->_foreach['photo_stats']['iteration'] == $this->_foreach['photo_stats']['total'])): ?><span class="clsSeperator">&nbsp;</span><?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
        </div>
    </div>
    <!--heading and right heading content ends-->
                <?php if ($this->_tpl_vars['total_photo_carousel_pages']): ?>
    <div class="clsOverflow">
        <!-- Player section starts -->
        <div class="clsPlayerBlock">
            <?php if (chkAllowedModule ( array ( 'photo' ) ) && $this->_tpl_vars['myobjFeaturedPhoto']->isFeaturedphoto): ?>
			<script src="<?php echo $this->_tpl_vars['CFG']['site']['photo_url']; ?>
js/jquery.cycle.js" type="text/javascript"></script>
            <div class="slideshow">
                <?php $this->assign('increment', 0); ?>
                <?php $_from = $this->_tpl_vars['featured_photo_list_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['genresKey'] => $this->_tpl_vars['photoValue']):
?>
				  <div class="clsIndexBlockPlayer">
				  <h3><?php echo $this->_tpl_vars['photoValue']['photo_title']; ?>
</h3>
                    <div class="clsIndexPhotoContainer">
                        <img src="<?php echo $this->_tpl_vars['photoValue']['medium_img_src']; ?>
" alt="<?php echo $this->_tpl_vars['photoValue']['photo_title']; ?>
" <?php echo $this->_tpl_vars['myobjFeaturedPhoto']->DISP_IMAGE(298,244,$this->_tpl_vars['photoValue']['thumb_width'],$this->_tpl_vars['photoValue']['thumb_height']); ?>
/>
                    </div>
                </div>
                <?php endforeach; endif; unset($_from); ?>
             </div>
            <?php echo '
            <script type="text/javascript">
            $Jq(document).ready(function() {
                $Jq(\'.slideshow\').cycle({
                    fx: \'all\' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
                });
            });
            </script>
            '; ?>

            <?php else: ?>
                <div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['mainIndex_photo_no_record']; ?>
</div>
            <?php endif; ?>
        </div>
        <!-- Player section ends -->
        <div class="clsCarouselBlock">
            <h3><?php echo $this->_tpl_vars['LANG']['mainIndex_photo_heading']; ?>
</h3>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'photoinner_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div class="clsCarouselBlockContent">
    			<ul id="carouselPhotoList" class="jcarousel-skin-tango">
				  	<!-- The content will be dynamically loaded here -->
				</ul>
                <script type="text/javascript">
					var photo_index_ajax_url = '<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
index.php';
					<?php echo '
					function mainphotocarousel_itemLoadCallback(carousel, state)
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
								limit: 4,
								mainphotoblock: block
							},
							function(data) {
								//add the returned response from the ajax call as the item
								carousel.add(i, data);
							}
						);
					};
					jQuery(\'#carouselPhotoList\').jcarousel({
							scroll: 1,
							size: '; ?>
<?php echo $this->_tpl_vars['total_photo_carousel_pages']; ?>
<?php echo ',
							block: \''; ?>
<?php echo $this->_tpl_vars['mainIndexObj']->default_photo_block; ?>
<?php echo '\',
							itemFallbackDimension: 610,
							itemLoadCallback: mainphotocarousel_itemLoadCallback
						});
					'; ?>

				</script>
            </div>			
			 <div class="clsMainIndexViewAllLinks">
			 	<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photolist','?pg=photonew','photonew/','','photo'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['mainIndex_photo_view_all']; ?>
"><?php echo $this->_tpl_vars['LANG']['mainIndex_photo_view_all']; ?>
</a>
			</div>    
        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'photoinner_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>        
    </div>
                <?php else: ?>
                <div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['mainIndex_photo_no_record']; ?>
</div>
                <?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'photoblock_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>