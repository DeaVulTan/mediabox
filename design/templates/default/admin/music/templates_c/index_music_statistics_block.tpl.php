<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from index_music_statistics_block.tpl */ ?>
<table class="">
    <tr>
        <th colspan="2">
        	<?php echo $this->_tpl_vars['LANG']['admin_index_module_music']; ?>
                        
        </th>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_total_music']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['musicStatistics_arr']['total_active_music']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_activate_music']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['musicStatistics_arr']['total_toactivate_music']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_today_new_music']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['musicStatistics_arr']['total_today_music']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_this_week_music']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['musicStatistics_arr']['this_week_music']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_this_month_music']; ?>
                        
        </td>
        <td>
       		<?php echo $this->_tpl_vars['musicStatistics_arr']['this_month_music']; ?>
                        
        </td>
    </tr>
</table>