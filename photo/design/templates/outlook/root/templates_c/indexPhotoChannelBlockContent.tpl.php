<?php /* Smarty version 2.6.18, created on 2011-10-18 17:31:52
         compiled from indexPhotoChannelBlockContent.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'indexPhotoChannelBlockContent.tpl', 22, false),)), $this); ?>
	<?php if ($this->_tpl_vars['photo_block_category_record_count']): ?>
	<div class="clsCarouselList">
            <?php unset($this->_sections['all_category']);
$this->_sections['all_category']['name'] = 'all_category';
$this->_sections['all_category']['loop'] = is_array($_loop=$this->_tpl_vars['category_id_arr']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['all_category']['show'] = true;
$this->_sections['all_category']['max'] = $this->_sections['all_category']['loop'];
$this->_sections['all_category']['step'] = 1;
$this->_sections['all_category']['start'] = $this->_sections['all_category']['step'] > 0 ? 0 : $this->_sections['all_category']['loop']-1;
if ($this->_sections['all_category']['show']) {
    $this->_sections['all_category']['total'] = $this->_sections['all_category']['loop'];
    if ($this->_sections['all_category']['total'] == 0)
        $this->_sections['all_category']['show'] = false;
} else
    $this->_sections['all_category']['total'] = 0;
if ($this->_sections['all_category']['show']):

            for ($this->_sections['all_category']['index'] = $this->_sections['all_category']['start'], $this->_sections['all_category']['iteration'] = 1;
                 $this->_sections['all_category']['iteration'] <= $this->_sections['all_category']['total'];
                 $this->_sections['all_category']['index'] += $this->_sections['all_category']['step'], $this->_sections['all_category']['iteration']++):
$this->_sections['all_category']['rownum'] = $this->_sections['all_category']['iteration'];
$this->_sections['all_category']['index_prev'] = $this->_sections['all_category']['index'] - $this->_sections['all_category']['step'];
$this->_sections['all_category']['index_next'] = $this->_sections['all_category']['index'] + $this->_sections['all_category']['step'];
$this->_sections['all_category']['first']      = ($this->_sections['all_category']['iteration'] == 1);
$this->_sections['all_category']['last']       = ($this->_sections['all_category']['iteration'] == $this->_sections['all_category']['total']);
?>
                <?php $this->assign('cid', $this->_tpl_vars['category_id_arr'][$this->_sections['all_category']['index']]); ?>
                <div class="clsMainCategory">
                    <div class="clsPhotoSubCategeroy">
                        <h3>
							<a href="<?php echo $this->_tpl_vars['photo_channel_url_arr'][$this->_tpl_vars['cid']]; ?>
" title="<?php echo $this->_tpl_vars['category_name_arr'][$this->_tpl_vars['cid']]; ?>
"><?php echo $this->_tpl_vars['category_name_arr'][$this->_tpl_vars['cid']]; ?>
&nbsp;<span>(<?php echo $this->_tpl_vars['myobj']->photoCount($this->_tpl_vars['cid']); ?>
)</span></a>
						</h3>
                    </div>
                    <table class="clsPhotoCarouselList">
                            <?php $this->assign('break_count', 1); ?>
                            <?php $_from = $this->_tpl_vars['populateCarousalphotoBlock_arr'][$this->_tpl_vars['cid']]['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['upload_photoKey'] => $this->_tpl_vars['upload_photoValue']):
?>
                                <?php if ($this->_tpl_vars['break_count'] == 1): ?>
                                    <tr>
                                        <?php endif; ?>
                                        <td <?php if ($this->_tpl_vars['break_count'] == 4): ?> class="clsFinalData" <?php endif; ?>>
                                            <div class="clsLargeThumbImageBackground" title="<?php echo $this->_tpl_vars['upload_photoValue']['wordWrap_mb_ManualWithSpace_photo_title']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['upload_photoValue']['viewphoto_url']; ?>
')">
                                                <div class="clsPhotoThumbImageOuter">
                                                    <?php if ($this->_tpl_vars['upload_photoValue']['photo_image_src'] != ''): ?>
                                                                <a  href="<?php echo $this->_tpl_vars['upload_photoValue']['viewphoto_url']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['upload_photoValue']['viewphoto_url']; ?>
')" class="cls146x112 clsImageHolder ClsImageBorder" >
                                                                    <img src="<?php echo $this->_tpl_vars['upload_photoValue']['photo_image_src']; ?>
" title="<?php echo $this->_tpl_vars['upload_photoValue']['wordWrap_mb_ManualWithSpace_photo_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['upload_photoValue']['wordWrap_mb_ManualWithSpace_photo_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 25) : smarty_modifier_truncate($_tmp, 25)); ?>
" id="image_img_photoInCategory_<?php echo $this->_tpl_vars['case']; ?>
_<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_id']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_photo_thumb_width'],$this->_config[0]['vars']['image_photo_thumb_height'],$this->_tpl_vars['upload_photoValue']['thumb_width'],$this->_tpl_vars['upload_photoValue']['thumb_height']); ?>
/>
                                                                </a>
                                                             <?php else: ?>
                                                                <img  src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_photo_T.jpg" title="<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_title']; ?>
" alt="<?php echo $this->_tpl_vars['LANG']['common_no_images']; ?>
"/>
                                                    <?php endif; ?>

                                                   </div>
                                                </div>
                                            <?php if ($this->_tpl_vars['upload_photoValue']['photo_image_src'] != ''): ?>
                                                <div class="clsSlideTip" >
                                                    <a href="javascript:;"  title="<?php echo $this->_tpl_vars['LANG']['common_zoom']; ?>
" class="clsPhotoVideoEditLinks" id="img_<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_id']; ?>
" onclick="zoom('img_photoInCategory_<?php echo $this->_tpl_vars['case']; ?>
_<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_id']; ?>
','<?php echo $this->_tpl_vars['upload_photoValue']['photo_large_image_src']; ?>
','<?php echo ((is_array($_tmp=$this->_tpl_vars['upload_photoValue']['photo_title_js'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 50) : smarty_modifier_truncate($_tmp, 50)); ?>
')"><span class="clsIndexZoomImg"></span></a>
                                                </div>
                                            <?php endif; ?>
                                                <div class="clsCategorySubTitle">
                                                    <a href="<?php echo $this->_tpl_vars['upload_photoValue']['viewphoto_url']; ?>
" title="<?php echo $this->_tpl_vars['upload_photoValue']['wordWrap_mb_ManualWithSpace_photo_title']; ?>
"><pre><?php echo $this->_tpl_vars['upload_photoValue']['wordWrap_mb_ManualWithSpace_photo_title']; ?>
</pre></a>
                                                </div>
                                        </td>
                                        <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
                                        <?php if ($this->_tpl_vars['break_count'] > 4): ?>
                                    </tr>
                                    <?php $this->assign('break_count', 1); ?>
                                <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>
                        </table>
                </div>
            <?php endfor; endif; ?>
     </div>
   	<?php else: ?>
    	<div class="clsNoRecordsFoundNoPadding"><?php echo $this->_tpl_vars['LANG']['sidebar_no_record_found_error_msg']; ?>
</div>
    <?php endif; ?>
