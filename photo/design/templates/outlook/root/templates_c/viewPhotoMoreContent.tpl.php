<?php /* Smarty version 2.6.18, created on 2011-10-18 17:32:25
         compiled from viewPhotoMoreContent.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'viewPhotoMoreContent.tpl', 10, false),)), $this); ?>
<div class="clsSideCaroselContainer clsOverflow">
	<?php $this->assign('count', 1); ?>
    <?php $this->assign('row_count', 1); ?>
    <?php if ($this->_tpl_vars['myobj']->total_records): ?>
        <?php $_from = $this->_tpl_vars['relatedPhoto']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['result']):
?>
             <?php if ($this->_tpl_vars['count'] % 2 != 0): ?><div class="clsOverflow clsViewPhotoBorderBottom"><?php endif; ?>
             <div class="clsViewPageSideContainer <?php if ($this->_tpl_vars['count'] % 2 == 0): ?> clsThumbPhotoFinalRecord<?php endif; ?>">
                <div class="clsViewPageSideImage">
					<a href="<?php echo $this->_tpl_vars['result']['photo_url']; ?>
" class="cls146x112 clsImageHolder clsImageBorderBgSidebar clsPointer">                                	
							<img src="<?php echo $this->_tpl_vars['result']['photo_image_src']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['photo_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 25) : smarty_modifier_truncate($_tmp, 25)); ?>
" <?php echo $this->_tpl_vars['result']['photo_disp']; ?>
 title="<?php echo $this->_tpl_vars['result']['photo_title']; ?>
"/>                                    
					</a>           
                </div>
                <div class="clsViewPageMoreContent">
                    <p class="clsViewPageMoreContentTitle"><a href="<?php echo $this->_tpl_vars['result']['photo_url']; ?>
" title="<?php echo $this->_tpl_vars['result']['photo_title']; ?>
"><?php echo $this->_tpl_vars['result']['photo_title']; ?>
</a></p>
                                    </div>
            </div>  
          <?php if ($this->_tpl_vars['count'] % 2 == 0): ?></div><?php endif; ?>         
         <?php $this->assign('count', $this->_tpl_vars['count']+1); ?>          
        <?php endforeach; endif; unset($_from); ?>
         <div id="selNextPrev" class="clsPhotoCarouselPaging" style="display:none">
            <input type="button" href="javascript:void(0);" title="<?php echo $this->_tpl_vars['LANG']['common_previous']; ?>
" <?php if ($this->_tpl_vars['myobj']->leftButtonExist): ?> onclick="movePhotoSetToLeft(this, '<?php echo $this->_tpl_vars['myobj']->pg; ?>
')" <?php endif; ?> value="" id="photoPrevButton_<?php echo $this->_tpl_vars['myobj']->pg; ?>
" class="<?php echo $this->_tpl_vars['myobj']->leftButtonClass; ?>
" />
            <input type="button" href="javascript:void(0);" title="<?php echo $this->_tpl_vars['LANG']['common_next']; ?>
" <?php if ($this->_tpl_vars['myobj']->rightButtonExists): ?> onclick="movePhotoSetToRight(this, '<?php echo $this->_tpl_vars['myobj']->pg; ?>
')"<?php endif; ?> value="" id="photoNextButton_<?php echo $this->_tpl_vars['myobj']->pg; ?>
" class="<?php echo $this->_tpl_vars['myobj']->rightButtonClass; ?>
" />
        </div>
    <?php else: ?>
    	<div id="selNextPrev" class="clsPhotoCarouselPaging" style="display:none">
        </div>
        <div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['viewphoto_no_related_photos_found']; ?>
</div>
    <?php endif; ?>
</div>