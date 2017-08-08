<?php /* Smarty version 2.6.18, created on 2011-10-18 15:30:22
         compiled from indexVideoChannel.tpl */ ?>
<?php $_from = $this->_tpl_vars['video_detail_category_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
<td>
	<div class="clsIndexVideoContent">
	<div class="clsPointer">
		<div class="clsCategoryImgRight"><a href="<?php echo $this->_tpl_vars['value']['channel_url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls142x108">
            <?php if ($this->_tpl_vars['value']['image_url']): ?>
			<img src="<?php echo $this->_tpl_vars['value']['image_url']; ?>
" <?php echo $this->_tpl_vars['videoIndexObj']->DISP_IMAGE(142,108,$this->_tpl_vars['value']['t_width'],$this->_tpl_vars['value']['t_height']); ?>
/>
			<?php else: ?>
		    <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
video/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImageVideo_T.jpg" />
            <?php endif; ?>
		</a>
		</div>
		 <div class="clsTime"><?php echo $this->_tpl_vars['value']['playing_time']; ?>
</div>
	</div>
	<div class="clsVideoImageTitle">
		<pre><a href="<?php echo $this->_tpl_vars['value']['channel_url']; ?>
" title="<?php echo $this->_tpl_vars['value']['video_title']; ?>
"><?php echo $this->_tpl_vars['value']['video_title']; ?>
</a></pre>
	</div>
	</div>
</td>
<?php endforeach; endif; unset($_from); ?>


