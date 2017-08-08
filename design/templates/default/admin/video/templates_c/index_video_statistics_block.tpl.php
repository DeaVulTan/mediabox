<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from index_video_statistics_block.tpl */ ?>
<table class="">
    <tr>
        <th colspan="2">
        	<?php echo $this->_tpl_vars['LANG']['admin_index_module_video']; ?>
                        
        </th>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_total_video']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['videoStatistics_arr']['total_active_video']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_activate_video']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['videoStatistics_arr']['total_toactivate_video']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_today_new_video']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['videoStatistics_arr']['total_today_video']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_this_week_video']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['videoStatistics_arr']['this_week_video']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_this_month_video']; ?>
                        
        </td>
        <td>
       		<?php echo $this->_tpl_vars['videoStatistics_arr']['this_month_video']; ?>
                        
        </td>
    </tr>
</table>