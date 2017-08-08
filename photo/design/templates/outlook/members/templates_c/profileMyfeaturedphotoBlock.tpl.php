<?php /* Smarty version 2.6.18, created on 2011-10-18 15:28:01
         compiled from profileMyfeaturedphotoBlock.tpl */ ?>
<?php if (chkAllowedModule ( array ( 'photo' ) )): ?>
<?php if ($this->_tpl_vars['myobjFeaturedPhoto']->isFeaturedphoto): ?>
<script src="<?php echo $this->_tpl_vars['CFG']['site']['photo_url']; ?>
js/jquery.cycle.js" type="text/javascript"></script>
<div class="clsPhotoFeaturedShelfTable">
	 <div class="slideshow">
		<?php $this->assign('increment', 0); ?>
		<?php $_from = $this->_tpl_vars['featured_photo_list_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['genresKey'] => $this->_tpl_vars['photoValue']):
?>
		  <a href="<?php echo $this->_tpl_vars['photoValue']['view_photo_link']; ?>
" class="Cls470x392 clsPhotoImageHolder clsPhotoImageBorder" alt="<?php echo $this->_tpl_vars['photoValue']['photo_title']; ?>
" title="<?php echo $this->_tpl_vars['photoValue']['photo_title']; ?>
">
			 <img src="<?php echo $this->_tpl_vars['photoValue']['medium_img_src']; ?>
" alt="<?php echo $this->_tpl_vars['photoValue']['photo_title']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(470,392,$this->_tpl_vars['photoValue']['l_width'],$this->_tpl_vars['photoValue']['l_height']); ?>
/>
		  </a>  
		<?php endforeach; endif; unset($_from); ?>
	</div>
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
		<div class="clsOverflow">
		<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['myprofile_featuredphoto_no_records']; ?>
</div>
	  </div>
<?php endif; ?>
<?php endif; ?>