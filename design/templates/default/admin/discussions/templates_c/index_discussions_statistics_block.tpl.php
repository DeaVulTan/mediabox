<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:20
         compiled from index_discussions_statistics_block.tpl */ ?>
<table class="">
    <tr>
        <th colspan="2">
        	<?php echo $this->_tpl_vars['LANG']['discussions']; ?>

        </th>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_total_boards']; ?>

        </td>
        <td>
        	<?php echo $this->_tpl_vars['discussionStatistics_arr']['total_boards']; ?>

        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_todays_boards']; ?>

        </td>
        <td>
        	<?php echo $this->_tpl_vars['discussionStatistics_arr']['todays_boards']; ?>

        </td>
    </tr>
    <tr>
        <td>
        	<?php echo $this->_tpl_vars['LANG']['admin_todays_solutions']; ?>

        </td>
        <td>
        	<?php echo $this->_tpl_vars['discussionStatistics_arr']['todays_solutions']; ?>

        </td>
    </tr>
</table>