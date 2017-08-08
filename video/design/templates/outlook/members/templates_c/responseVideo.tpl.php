<?php /* Smarty version 2.6.18, created on 2011-10-19 10:52:53
         compiled from responseVideo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'responseVideo.tpl', 6, false),)), $this); ?>
<?php if ($this->_tpl_vars['responseVideo']['total_records']): ?>
<div class="clsVideoDetailsList">
	<ul class="clsVideoResponseList">
		<?php $_from = $this->_tpl_vars['responseVideo']['video']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['video']):
?>
		<li>
        	          <a href="<?php echo $this->_tpl_vars['video']['viewUrl']; ?>
" class="Cls101x78 ClsImageContainer ClsImageBorder1"><img src="<?php echo $this->_tpl_vars['video']['image']; ?>
"  alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['video']['alt_tag'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 10) : smarty_modifier_truncate($_tmp, 10)); ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(93,70,$this->_tpl_vars['video']['small_width'],$this->_tpl_vars['video']['small_height']); ?>
/></a>                   
        </a>
        <p><?php echo $this->_tpl_vars['video']['video_title']; ?>
</p>
		</li>
		<?php endforeach; endif; unset($_from); ?>
     </ul>
  </div>
  <div class="clsMoreResponse">
  	<div class="clsFloatLeft"></div>
    <div class="clsFloatRight"><a href="<?php echo $this->_tpl_vars['responseVideo']['more_link']; ?>
"><?php echo $this->_tpl_vars['LANG']['video_response_show_all_resp']; ?>
</a></div>
</div>
<?php else: ?>

<div class="selVideoDisp" >
	<div class="clsNoVideo">
	<p><?php echo $this->_tpl_vars['LANG']['no_related_videos_found']; ?>
</p>
	</div>
</div>
<?php endif; ?>