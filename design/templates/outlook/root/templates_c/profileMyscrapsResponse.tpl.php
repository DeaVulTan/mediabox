<?php /* Smarty version 2.6.18, created on 2011-12-29 18:23:29
         compiled from profileMyscrapsResponse.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'profileMyscrapsResponse.tpl', 10, false),array('modifier', 'date_format', 'profileMyscrapsResponse.tpl', 15, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<table class="clsScrapBook" id="<?php echo $this->_tpl_vars['profile_scrap_box_id']; ?>
">
	<?php $_from = $this->_tpl_vars['ajax_comment_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
  		<tr>
    		<td id="selProfileComment">
        		<div class="clsScrapBookContent">
            		<div class="clsFrameScrapBookThumb">
                		<p id="selImageBorder">
                    		<a href="<?php echo $this->_tpl_vars['value']['commentorProfileUrl']; ?>
" class="ClsImageContainer ClsImageBorder2 Cls45x45" <?php echo $this->_tpl_vars['value']['online']; ?>
>
								<img src="<?php echo $this->_tpl_vars['value']['profileIcon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['value']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['value']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['value']['profileIcon']['s_width'],$this->_tpl_vars['value']['profileIcon']['s_height']); ?>
/>
                    		</a>
                		</p>
            		</div>
            		<div class="clsScrapBookThumbDetails">
                		<p><a href="<?php echo $this->_tpl_vars['value']['commentorProfileUrl']; ?>
"><?php echo $this->_tpl_vars['value']['user_name']; ?>
</a><span><?php echo ((is_array($_tmp=$this->_tpl_vars['value']['display_date_added'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_datetime']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_datetime'])); ?>
</span></p>
                		<p><?php echo $this->_tpl_vars['value']['comment']; ?>
</p>
            		</div>
        		</div>
    		</td>
  		</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>