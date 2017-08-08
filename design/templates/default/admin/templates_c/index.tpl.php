<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'index.tpl', 42, false),array('function', 'counter', 'index.tpl', 62, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('statistics_list')): ?>
        <h2><?php echo $this->_tpl_vars['CFG']['site']['name']; ?>
&nbsp;</h2>
        <h3><?php echo $this->_tpl_vars['LANG']['index_statistics']; ?>
</h3>
   		<table class="clsWithoutBorder">
        <tr>
          <td class="clsWithoutBorder">
          <table class="">
                    <tr>
                    <th colspan="2"><?php echo $this->_tpl_vars['LANG']['index_module_members']; ?>
</th>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->_tpl_vars['LANG']['index_total_members']; ?>
                        </td>
                        <td>
                           	<?php echo $this->_tpl_vars['myobj']->statistics_list['membersStatistics']['total_active_member']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->_tpl_vars['LANG']['index_activate_members']; ?>
                        </td>
                        <td>
                            <?php echo $this->_tpl_vars['myobj']->statistics_list['membersStatistics']['total_toactivate_member']; ?>
                        </td>
                    </tr>
                    <tr>
                          <td><?php echo $this->_tpl_vars['LANG']['index_today_new_members']; ?>
</td>
                          <td><?php echo $this->_tpl_vars['myobj']->statistics_list['membersStatistics']['total_today_member']; ?>
</td>
                    </tr>
                     <tr>
                          <td><?php echo $this->_tpl_vars['LANG']['admin_index_this_week']; ?>
</td>
                          <td><?php echo $this->_tpl_vars['myobj']->statistics_list['membersStatistics']['this_week_member']; ?>
</td>
                    </tr>
                     <tr>
                          <td><?php echo $this->_tpl_vars['LANG']['admin_index_this_month']; ?>
</td>
                          <td><?php echo $this->_tpl_vars['myobj']->statistics_list['membersStatistics']['this_month_member']; ?>
</td>
                    </tr>
                </table>

          </td>
          <?php if ($this->_tpl_vars['myobj']->statistics_list['firstModule']): ?>
          	<td class="clsWithoutBorder">
                <?php if ($this->_tpl_vars['myobj']->statistics_list['firstModule'] != ''): ?>
                	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/',$this->_tpl_vars['myobj']->statistics_list['firstModule']); ?>

                 	<?php $this->assign('module_heading_tpl', ((is_array($_tmp=((is_array($_tmp='index_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['myobj']->statistics_list['firstModule']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['myobj']->statistics_list['firstModule'])))) ? $this->_run_mod_handler('cat', true, $_tmp, '_statistics_block.tpl') : smarty_modifier_cat($_tmp, '_statistics_block.tpl'))); ?>
		   			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['module_heading_tpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                 <?php endif; ?>
              </td>
           <?php endif; ?>
          </tr>
        <?php $this->assign('count', '0'); ?>
        <?php $this->assign('is_td', '0'); ?>
        <?php $_from = $this->_tpl_vars['CFG']['site']['modules_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
        	<?php if (chkAllowedModule ( array ( $this->_tpl_vars['module'] ) ) && $this->_tpl_vars['module'] != $this->_tpl_vars['myobj']->statistics_list['firstModule'] && $this->_tpl_vars['myobj']->statistics_list['firstModule'] != ''): ?>
               <?php if ($this->_tpl_vars['count'] == 0): ?>
                <tr>
                <?php endif; ?>

                 <td class="clsWithoutBorder">
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/',$this->_tpl_vars['module']); ?>

                 	<?php $this->assign('module_heading_tpl', ((is_array($_tmp=((is_array($_tmp='index_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['module']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['module'])))) ? $this->_run_mod_handler('cat', true, $_tmp, '_statistics_block.tpl') : smarty_modifier_cat($_tmp, '_statistics_block.tpl'))); ?>
		   			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['module_heading_tpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                 </td>

                <?php echo smarty_function_counter(array('assign' => 'count'), $this);?>

                <?php if ($this->_tpl_vars['count']%2 == 0): ?>
                    <?php echo smarty_function_counter(array('start' => 0), $this);?>

                    </tr>
                <?php endif; ?>
                <?php $this->assign('is_td', $this->_tpl_vars['is_td']+1); ?>
             <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
        <?php if ($this->_tpl_vars['is_td']%2 != 0): ?>
            	<td class="clsWithoutBorder">&nbsp;</td>
                </tr>
        <?php endif; ?>
    </table>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('latestnews_list')): ?>
<div id="sellatestNews">
        <div>
            <h3><?php echo $this->_tpl_vars['LANG']['index_latest_news']; ?>
</h3>
             <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('latestnews_list')): ?>
<div id="selReportBlock">
                </div>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['myobj']->latestnews_list['populateNews']): ?>
                <div class="clsLatestNews">
            	    <?php $_from = $this->_tpl_vars['myobj']->latestnews_list['populateNews']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pnkey'] => $this->_tpl_vars['pnvalue']):
?>
                			<div class="clsLatestNewsContent">
				                <p><span><?php echo $this->_tpl_vars['pnvalue']['CONTENT']; ?>
</span></p>
                			</div>
        	        <?php endforeach; endif; unset($_from); ?>
                		<div class="clsBold" align="right">
			                <p><a href="latestNews.php"><?php echo $this->_tpl_vars['LANG']['index_more']; ?>
</a></p>
            		    </div>
                </div>
            <?php else: ?>
                  <div id="selMsgAlert">
                       <p><?php echo $this->_tpl_vars['LANG']['common_no_records_found']; ?>
</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>