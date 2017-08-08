<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:36
         compiled from multiLanguage.tpl */ ?>
<?php if ($this->_tpl_vars['show_languages']): ?>
    <li class="selDropDownLink clsBlock clsLanguageSwitcherLink">
        <div id="selLang" lang="en">
            <?php $_from = $this->_tpl_vars['smarty_available_languages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
                <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['CFG']['lang']['default']): ?>
                    <a class="language clsBlock" onClick="showHideLang()" onmouseover="document.getElementById('showhidelang').style.display=''" onmouseout="document.getElementById('showhidelang').style.display='none'" title="<?php echo $this->_tpl_vars['value']; ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/css/flag_icon/<?php echo $this->_tpl_vars['key']; ?>
.gif" /></a>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
                <ul id="langlist" class="clsLanguageSwitcherContainer">
                    <?php $_from = $this->_tpl_vars['smarty_available_languages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
                        <?php if ($this->_tpl_vars['key'] != $this->_tpl_vars['CFG']['lang']['default']): ?>
                            <li><a href="<?php echo $this->_tpl_vars['header']->chooseLang($this->_tpl_vars['key']); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/css/flag_icon/<?php echo $this->_tpl_vars['key']; ?>
.gif" />&nbsp; <?php echo $this->_tpl_vars['value']; ?>
</a></li>
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
        </div>
    </li>
<?php endif; ?>