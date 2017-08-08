<?php /* Smarty version 2.6.18, created on 2011-10-18 16:30:24
         compiled from pluginConfig.tpl */ ?>
<div id="pluginConfig">
	<h2><?php echo $this->_tpl_vars['LANG']['pluginconfig']; ?>
</h2>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('plugin_list_block')): ?>
    	<form id="pluginConfig" name="pluginConfig" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
        	<table cellpadding="2" cellspacing="4" class="clsNoBorder">
            	<?php if ($this->_tpl_vars['myobj']->err_msg != ''): ?>
            		<tr>
            			<td colspan="3"><h3><?php echo $this->_tpl_vars['myobj']->err_msg; ?>
</h3></td>
					</tr>
				<?php endif; ?>
            	<?php if ($this->_tpl_vars['myobj']->plugin_list_block['displayPluginList_arr']): ?>
            		<tr>
                		<th><?php echo $this->_tpl_vars['LANG']['pluginconfig_title']; ?>
</th>
                		<th><?php echo $this->_tpl_vars['LANG']['pluginconfig_version']; ?>
</th>
                		<th><?php echo $this->_tpl_vars['LANG']['pluginconfig_description']; ?>
</th>
                		<th><?php echo $this->_tpl_vars['LANG']['pluginconfig_status']; ?>
</th>
            		</tr>
                    <?php $_from = $this->_tpl_vars['myobj']->plugin_list_block['displayPluginList_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['dplValue']):
?>
                    	<tr>
                      		<td class="clsSmallWidth"><?php echo $this->_tpl_vars['dplValue']['title']; ?>
</td>
                      		<td class="clsSmallWidth"><p><?php echo $this->_tpl_vars['dplValue']['version']; ?>
</p></td>
                            <td><p><?php echo $this->_tpl_vars['dplValue']['description']; ?>
</p></td>
                            <td class="clsSmallWidth">
                            	<?php if (! $this->_tpl_vars['myobj']->chkAlreadyExists($this->_tpl_vars['dplValue']['title'],$this->_tpl_vars['myobj']->getFormField('action'))): ?>
                                	<a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
<?php echo $this->_tpl_vars['dplValue']['link']; ?>
"  >
                                    	<b><font color="#006600"><?php echo $this->_tpl_vars['LANG']['pluginconfig_install']; ?>
</font></b>
                                    </a>
                                <?php else: ?>
                                	<b><font color="#FF0000"><?php echo $this->_tpl_vars['LANG']['pluginconfig_installed']; ?>
</font></b>
									(<a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
<?php echo $this->_tpl_vars['dplValue']['link']; ?>
">
                                		<b><font color="#006600"><?php echo $this->_tpl_vars['LANG']['pluginconfig_reinstalled']; ?>
</font></b>
                                    </a>)
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; endif; unset($_from); ?>
                <?php else: ?>
                	<tr>
                    	<td colspan="3" align="center" valign="middle"><div id="selMsgAlert"><?php echo $this->_tpl_vars['LANG']['pluginconfig_no_record']; ?>
</div></td>
                    </tr>
                <?php endif; ?>
			</table>
		 	<input type="hidden" id="module_name" name="module_name"/>
			<input type="hidden" id="plugin_name" name="plugin_name"/>
      	</form>
	<?php endif; ?>
</div>