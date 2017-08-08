<?php /* Smarty version 2.6.18, created on 2011-10-17 14:55:23
         compiled from mainIndexPhotoCarousel.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'mainIndexPhotoCarousel.tpl', 17, false),)), $this); ?>
<?php if ($this->_tpl_vars['photo_block_record_count']): ?>

<?php $this->assign('row_count', 4); ?>

<?php $this->assign('break_count', 1); ?>

<?php $_from = $this->_tpl_vars['populateCarousalphotoBlock_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['upload_photoKey'] => $this->_tpl_vars['upload_photoValue']):
?>
<div class="clsCarouselListContent <?php if ($this->_tpl_vars['break_count'] == $this->_tpl_vars['row_count']): ?>clsNoRightMargin<?php endif; ?>">
	<div class="clsZoom">
        <a href="javascript:;" title="<?php echo $this->_tpl_vars['LANG']['common_zoom']; ?>
" class="clsPhotoVideoEditLinks" id="img_<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_id']; ?>
" onclick="zoom('img_<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_id']; ?>
','<?php echo $this->_tpl_vars['upload_photoValue']['photo_large_image_src']; ?>
','<?php echo $this->_tpl_vars['upload_photoValue']['photo_title_js']; ?>
')">&nbsp;&nbsp;</a>
    </div>
    <div class="clsCarouselListImage">
    	<a href="javascript:void(0);" onclick="Redirect2URL('<?php echo $this->_tpl_vars['upload_photoValue']['viewphoto_url']; ?>
')" class="clsImageContainer clsImageBorder7 cls142x108">
        	<?php if ($this->_tpl_vars['upload_photoValue']['photo_image_src'] != ''): ?>
            <img src="<?php echo $this->_tpl_vars['upload_photoValue']['photo_image_src']; ?>
" title="<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['upload_photoValue']['record']['photo_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 12) : smarty_modifier_truncate($_tmp, 12)); ?>
" id="image_img_<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_id']; ?>
" <?php echo $this->_tpl_vars['mainIndexObj']->DISP_IMAGE(140,106,$this->_tpl_vars['upload_photoValue']['record']['t_width'],$this->_tpl_vars['upload_photoValue']['record']['t_height']); ?>
/>
         	<?php else: ?>
            <img src="<?php echo $this->_tpl_vars['mainIndexObj']->CFG['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['mainIndexObj']->CFG['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['mainIndexObj']->CFG['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_photo_S.jpg" title="<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_title']; ?>
" title="<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['upload_photoValue']['record']['photo_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 12) : smarty_modifier_truncate($_tmp, 12)); ?>
"/>
         	<?php endif; ?>
        </a>
    </div>
    <div class="clsCarouselListDetails">
        <p class="clsTitle"><a href="<?php echo $this->_tpl_vars['upload_photoValue']['viewphoto_url']; ?>
" title="<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_title']; ?>
"><?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_title']; ?>
</a></p>
        <p class="clsName"><?php echo $this->_tpl_vars['LANG']['mainIndex_by']; ?>
 <a href="<?php echo $this->_tpl_vars['upload_photoValue']['MemberProfileUrl']; ?>
" title="<?php echo $this->_tpl_vars['upload_photoValue']['record']['user_name']; ?>
"><?php echo $this->_tpl_vars['upload_photoValue']['record']['user_name']; ?>
</a></p>
        <p class="clsViews"><?php echo $this->_tpl_vars['LANG']['mainIndex_photo_views']; ?>
: <span><?php echo $this->_tpl_vars['upload_photoValue']['record']['total_views']; ?>
</span></p>
    </div>
</div>
<?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
<?php endforeach; endif; unset($_from); ?>

<?php else: ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['mainIndex_photo_no_record']; ?>
</div>
<?php endif; ?>