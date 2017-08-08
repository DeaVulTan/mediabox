<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from index_blog_statistics_block.tpl */ ?>
<table class="">
    <tr>
        <th colspan="2">
        	<?php echo $this->_tpl_vars['LANG']['admin_index_module_blog']; ?>
                        
        </th>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_total_blog']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['blogStatistics_arr']['total_active_blog']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_activate_blog']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['blogStatistics_arr']['total_toactivate_blog']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_today_new_blog']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['blogStatistics_arr']['total_today_blog']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_this_week_blog']; ?>
                        
        </td>
        <td>
        	<?php echo $this->_tpl_vars['blogStatistics_arr']['this_week_blog']; ?>
                        
        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_this_month_blog']; ?>
                        
        </td>
        <td>
       		<?php echo $this->_tpl_vars['blogStatistics_arr']['this_month_blog']; ?>
                        
        </td>
    </tr>
</table>