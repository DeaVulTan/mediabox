<?php /* Smarty version 2.6.18, created on 2012-02-02 01:23:24
         compiled from imageList.tpl */ ?>
<div class="manager clsOverflow">
	<?php $_from = $this->_tpl_vars['file_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
    <div class="clsUploadArticleIframe" style="float:left; background:#FFF; width:70px; margin:0 10px 10px 0; padding:5px; border:1px solid #eeeff1">
    	<div class="item clsUploadImage">
         	<a href="javascript: ImageManager.populateFields('<?php echo $this->_tpl_vars['file_array'][$this->_tpl_vars['inc']]['image_path']; ?>
')">
            	<img src="<?php echo $this->_tpl_vars['file_array'][$this->_tpl_vars['inc']]['image_path']; ?>
" width="60" height="45" alt="<?php echo $this->_tpl_vars['file_array'][$this->_tpl_vars['inc']]['image_name']; ?>
" style="border:1px solid #eeeff1" />
                <span style="width:65px;height:15px;overflow:hidden;display:block;"><?php echo $this->_tpl_vars['file_array'][$this->_tpl_vars['inc']]['image_name']; ?>
</span>
            </a>
		</div>
		<div class="clsUploadImageTitle"></div>
    </div>
    <?php endforeach; endif; unset($_from); ?>
</div>