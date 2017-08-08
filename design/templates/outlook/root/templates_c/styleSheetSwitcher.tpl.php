<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:36
         compiled from styleSheetSwitcher.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'styleSheetSwitcher.tpl', 5, false),)), $this); ?>
<?php if ($this->_tpl_vars['show_templates']): ?>
<li class="selDropDownLink clsBlock clsTemplateSwitcherLink">
    <form class="clsBlock" name="form_style" id="form_style" method="post" action="<?php echo $this->_tpl_vars['header']->getCurrentUrl(true); ?>
" autocomplete="off">
        <input type="hidden" name="template" id="template" />
        <a href="#" class="language" onclick="return false;" onmouseover="document.getElementById('selTemplateList').style.display=''" onmouseout="document.getElementById('selTemplateList').style.display='none'"><img src="<?php echo $this->_tpl_vars['header']->displayTemplateSwitcher_arr['default_template_img']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 3) : smarty_modifier_truncate($_tmp, 3)); ?>
"/></a>
        <ul class="clsTemplateSwitcherContainer">
            <?php $_from = $this->_tpl_vars['template_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['template'] => $this->_tpl_vars['css_arr']):
?>
                <li class="clsThemeHeading"><?php echo $this->_tpl_vars['template']; ?>
</li>
                <?php $_from = $this->_tpl_vars['css_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['css_key'] => $this->_tpl_vars['css']):
?>
                    <?php $this->assign('smarty_current_template', ($this->_tpl_vars['template'])."__".($this->_tpl_vars['css'])); ?>
                    <li class="clsStyleHeading"><a href="#" onclick="document.getElementById('template').value='<?php echo $this->_tpl_vars['smarty_current_template']; ?>
';document.getElementById('form_style').submit();return false;"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/css/themes/<?php echo $this->_tpl_vars['template']; ?>
_<?php echo $this->_tpl_vars['css']; ?>
.jpg" alt="<?php echo $this->_tpl_vars['css']; ?>
"/> <?php echo $this->_tpl_vars['css']; ?>
</a></li>
                <?php endforeach; endif; unset($_from); ?>
            <?php endforeach; endif; unset($_from); ?>
            </ul>
    </form>
</li>
<?php endif; ?>