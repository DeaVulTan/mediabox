<?php /* Smarty version 2.6.18, created on 2014-05-20 17:21:46
         compiled from latestNews.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'latestNews.tpl', 15, false),)), $this); ?>
<div id="sellatestNews" class="clsCommonAdminTbl">

  	<h2><?php echo $this->_tpl_vars['LANG']['latestnews_title']; ?>
</h2>
   <div class="clsAdminLatestNews">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_main_ionformation')): ?>
            <div id="selReportBlock">

            </div>
        <?php endif; ?>
        <table class="clsFormTbl">
        	<?php $_from = $this->_tpl_vars['myobj']->block_main_ionformation['populateNews']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pnkey'] => $this->_tpl_vars['pnvalue']):
?>
            	<tr>
                    <td><p class="clsLatestSubject"><span><?php echo $this->_tpl_vars['pnvalue']['SUBJECT']; ?>
</span></p>
                    <p ><?php echo ((is_array($_tmp=$this->_tpl_vars['pnvalue']['DATE_ADDED'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_datetime']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_datetime'])); ?>
</p>

                    <p><?php echo $this->_tpl_vars['pnvalue']['CONTENT']; ?>
</p>
                    </td>
                </tr>
	        <?php endforeach; else: ?>
                <tr>
                    <td>
                        <div id="selMsgAlert">
                        <p><?php echo $this->_tpl_vars['LANG']['latestnews_no_records_found']; ?>
</p>
                        </div>
                    </td>
                </tr>
        <?php endif; unset($_from); ?>
        </table>
    </div>
</div>