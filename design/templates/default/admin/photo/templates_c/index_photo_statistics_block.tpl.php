<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from index_photo_statistics_block.tpl */ ?>
<table class="">
    <tr>
        <th colspan="2">
        	<?php echo $this->_tpl_vars['LANG']['admin_index_module_photo']; ?>
                        
        </th>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_total_photo']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['photoStatistics_arr']['total_active_photo']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_activate_photo']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['photoStatistics_arr']['total_toactivate_photo']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_today_new_photo']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['photoStatistics_arr']['total_today_photo']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_this_week_photo']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['photoStatistics_arr']['this_week_photo']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_this_month_photo']; ?>
                        
        </td>
        <td>
       		<?php echo $this->_tpl_vars['photoStatistics_arr']['this_month_photo']; ?>
                        
        </td>
    </tr>
</table>