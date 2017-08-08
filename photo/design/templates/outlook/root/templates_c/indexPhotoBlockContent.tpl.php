<?php /* Smarty version 2.6.18, created on 2011-10-18 17:31:52
         compiled from indexPhotoBlockContent.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'indexPhotoBlockContent.tpl', 17, false),array('function', 'math', 'indexPhotoBlockContent.tpl', 81, false),)), $this); ?>
<?php if ($this->_tpl_vars['photo_block_record_count']): ?>
<table class="clsPhotoCarouselList">
	<?php $this->assign('row_count', 4); ?>
	<?php $this->assign('break_count', 1); ?>
	<?php $_from = $this->_tpl_vars['populateCarousalphotoBlock_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['upload_photoKey'] => $this->_tpl_vars['upload_photoValue']):
?>
    <?php if ($this->_tpl_vars['break_count'] == 1): ?>
    	<tr>
    <?php endif; ?>
		<td <?php if ($this->_tpl_vars['break_count'] == $this->_tpl_vars['row_count']): ?> class="clsFinalData" <?php endif; ?>>
        	<!--div class="clsPlayCurrentPhoto">
            	<a href="<?php echo $this->_tpl_vars['upload_photoValue']['viewphoto_url']; ?>
" title="<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_title']; ?>
"> <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-play.gif" /></a>
            </div-->
            <div class="clsLargeThumbImageBackground" id="" onclick="Redirect2URL('<?php echo $this->_tpl_vars['upload_photoValue']['viewphoto_url']; ?>
')">
                	<?php if ($this->_tpl_vars['upload_photoValue']['photo_image_src'] != ''): ?>
						<a href="<?php echo $this->_tpl_vars['upload_photoValue']['viewphoto_url']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['upload_photoValue']['viewphoto_url']; ?>
')" class="cls146x112 clsImageHolder ClsImageBorder" >
                        	<img src="<?php echo $this->_tpl_vars['upload_photoValue']['photo_image_src']; ?>
" title="<?php echo $this->_tpl_vars['upload_photoValue']['wordWrap_mb_ManualWithSpace_photo_title']; ?>
 <?php echo $this->_tpl_vars['upload_photoValue']['photo_additional_details']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['upload_photoValue']['wordWrap_mb_ManualWithSpace_photo_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 25) : smarty_modifier_truncate($_tmp, 25)); ?>
 <?php echo $this->_tpl_vars['upload_photoValue']['photo_additional_details']; ?>
" id="image_img_<?php echo $this->_tpl_vars['case']; ?>
_<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_id']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_photo_thumb_width'],$this->_config[0]['vars']['image_photo_thumb_height'],$this->_tpl_vars['upload_photoValue']['thumb_width'],$this->_tpl_vars['upload_photoValue']['thumb_height']); ?>
/>
						</a>
                     <?php else: ?>
                        <img  src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_photo_T.jpg" title="<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_title']; ?>
 <?php echo $this->_tpl_vars['upload_photoValue']['photo_additional_details']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['upload_photoValue']['record']['photo_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 25) : smarty_modifier_truncate($_tmp, 25)); ?>
 <?php echo $this->_tpl_vars['upload_photoValue']['photo_additional_details']; ?>
"/>
                     <?php endif; ?>
             </div>
			 <?php if ($this->_tpl_vars['upload_photoValue']['photo_image_src']): ?>
			 	<div class="clsSlideTip" >
    		 		<a href="javascript:;"  title="<?php echo $this->_tpl_vars['LANG']['common_zoom']; ?>
" class="clsPhotoVideoEditLinks" id="img_<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_id']; ?>
" onclick="zoom('img_<?php echo $this->_tpl_vars['case']; ?>
_<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_id']; ?>
','<?php echo $this->_tpl_vars['upload_photoValue']['photo_large_image_src']; ?>
','<?php echo ((is_array($_tmp=$this->_tpl_vars['upload_photoValue']['photo_title_js'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 50) : smarty_modifier_truncate($_tmp, 50)); ?>
')"><span class="clsIndexZoomImg"></span></a>
         		</div>
    		<?php endif; ?>
            <div class="clsPhotoIndexCauroselListContent" id="cur_<?php echo $this->_tpl_vars['case']; ?>
_<?php echo $this->_tpl_vars['upload_photoValue']['record']['photo_id']; ?>
" >
            	<div class="clsOverflow">
                	<div class="clsIndexPhotoQuickMixLeft">
                    	<p><a href="<?php echo $this->_tpl_vars['upload_photoValue']['viewphoto_url']; ?>
" title="<?php echo $this->_tpl_vars['upload_photoValue']['wordWrap_mb_ManualWithSpace_photo_title']; ?>
"><pre><?php echo $this->_tpl_vars['upload_photoValue']['wordWrap_mb_ManualWithSpace_photo_title']; ?>
</pre></a></p>
                  	</div>
                  					</div>
				<?php if ($this->_tpl_vars['case'] == 'mostrecentphoto'): ?>
					<p class="clsNormal"><?php echo $this->_tpl_vars['LANG']['common_by']; ?>
&nbsp;<a href="<?php echo $this->_tpl_vars['upload_photoValue']['MemberProfileUrl']; ?>
" title="<?php echo $this->_tpl_vars['upload_photoValue']['username']; ?>
"><?php echo $this->_tpl_vars['upload_photoValue']['username']; ?>
</a> </p>
				<?php elseif ($this->_tpl_vars['case'] == 'recommendedphoto'): ?>
                	<div class="clsOverflow">
                    	<p class="clsNormal clsIndexFeaturedRateLeft"><?php echo $this->_tpl_vars['LANG']['common_by']; ?>
&nbsp;<a href="<?php echo $this->_tpl_vars['upload_photoValue']['MemberProfileUrl']; ?>
" title="<?php echo $this->_tpl_vars['upload_photoValue']['username']; ?>
"><?php echo $this->_tpl_vars['upload_photoValue']['username']; ?>
</a> </p>
                    	                  	</div>
				<?php elseif ($this->_tpl_vars['case'] == 'mostfavoritephoto'): ?>
                	<div class="clsOverflow">
                    	<p class="clsNormal clsIndexFeaturedRateLeft"><?php echo $this->_tpl_vars['LANG']['common_by']; ?>
&nbsp;<a href="<?php echo $this->_tpl_vars['upload_photoValue']['MemberProfileUrl']; ?>
" title="<?php echo $this->_tpl_vars['upload_photoValue']['username']; ?>
"><?php echo $this->_tpl_vars['upload_photoValue']['username']; ?>
</a></p>
						                   	</div>
				<?php elseif ($this->_tpl_vars['case'] == 'topratedphoto'): ?>
                	<div class="clsOverflow">
                    	<div class="clsNormal clsTopRatedPhotoLeft"><?php echo $this->_tpl_vars['LANG']['common_by']; ?>
&nbsp;<a href="<?php echo $this->_tpl_vars['upload_photoValue']['MemberProfileUrl']; ?>
" title="<?php echo $this->_tpl_vars['upload_photoValue']['username']; ?>
"><?php echo $this->_tpl_vars['upload_photoValue']['username']; ?>
</a></div>
                                            </div>
				<?php endif; ?>
            </div>
        </td>
        <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
    	<?php if ($this->_tpl_vars['break_count'] > $this->_tpl_vars['row_count']): ?>
    		</tr>
    		<?php $this->assign('break_count', 1); ?>
    	<?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php if ($this->_tpl_vars['break_count'] != 1): ?>
    	    	<td colspan="<?php echo smarty_function_math(array('equation' => "(".($this->_tpl_vars['row_count'])."+1)-".($this->_tpl_vars['break_count'])), $this);?>
">&nbsp;</td>
    	</tr>
    <?php endif; ?>
</table>
<?php else: ?>
	<div class="clsNoRecordsFoundNoPadding"><?php echo $this->_tpl_vars['LANG']['sidebar_no_photo_found_error_msg']; ?>
</div>
<?php endif; ?>