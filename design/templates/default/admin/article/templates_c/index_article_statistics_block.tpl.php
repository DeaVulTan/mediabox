<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from index_article_statistics_block.tpl */ ?>
<table class="">
    <tr>
        <th colspan="2">
        	<?php echo $this->_tpl_vars['LANG']['admin_index_module_article']; ?>

        </th>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_total_article']; ?>

        </td>
        <td>
        	<?php echo $this->_tpl_vars['articleStatistics_arr']['total_active_article']; ?>

        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_activate_article']; ?>

        </td>
        <td>
        	<?php echo $this->_tpl_vars['articleStatistics_arr']['total_toactivate_article']; ?>

        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_today_new_article']; ?>

        </td>
        <td>
        	<?php echo $this->_tpl_vars['articleStatistics_arr']['total_today_article']; ?>

        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_this_week_article']; ?>

        </td>
        <td>
        	<?php echo $this->_tpl_vars['articleStatistics_arr']['this_week_article']; ?>

        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_index_this_month_article']; ?>

        </td>
        <td>
       		<?php echo $this->_tpl_vars['articleStatistics_arr']['this_month_article']; ?>

        </td>
    </tr>
</table>