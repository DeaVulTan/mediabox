<?php /* Smarty version 2.6.18, created on 2011-10-18 15:28:01
         compiled from profileAllprofileinfoBlock.tpl */ ?>
<?php unset($this->_sections['profile_info']);
$this->_sections['profile_info']['name'] = 'profile_info';
$this->_sections['profile_info']['loop'] = is_array($_loop=$this->_tpl_vars['profile_info_arr']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['profile_info']['show'] = true;
$this->_sections['profile_info']['max'] = $this->_sections['profile_info']['loop'];
$this->_sections['profile_info']['step'] = 1;
$this->_sections['profile_info']['start'] = $this->_sections['profile_info']['step'] > 0 ? 0 : $this->_sections['profile_info']['loop']-1;
if ($this->_sections['profile_info']['show']) {
    $this->_sections['profile_info']['total'] = $this->_sections['profile_info']['loop'];
    if ($this->_sections['profile_info']['total'] == 0)
        $this->_sections['profile_info']['show'] = false;
} else
    $this->_sections['profile_info']['total'] = 0;
if ($this->_sections['profile_info']['show']):

            for ($this->_sections['profile_info']['index'] = $this->_sections['profile_info']['start'], $this->_sections['profile_info']['iteration'] = 1;
                 $this->_sections['profile_info']['iteration'] <= $this->_sections['profile_info']['total'];
                 $this->_sections['profile_info']['index'] += $this->_sections['profile_info']['step'], $this->_sections['profile_info']['iteration']++):
$this->_sections['profile_info']['rownum'] = $this->_sections['profile_info']['iteration'];
$this->_sections['profile_info']['index_prev'] = $this->_sections['profile_info']['index'] - $this->_sections['profile_info']['step'];
$this->_sections['profile_info']['index_next'] = $this->_sections['profile_info']['index'] + $this->_sections['profile_info']['step'];
$this->_sections['profile_info']['first']      = ($this->_sections['profile_info']['iteration'] == 1);
$this->_sections['profile_info']['last']       = ($this->_sections['profile_info']['iteration'] == $this->_sections['profile_info']['total']);
?>
<?php if ($this->_tpl_vars['selected_category'] == $this->_tpl_vars['profile_info_arr'][$this->_sections['profile_info']['index']]['cat_id']): ?>
   <div class="clsDefaultInfoTable <?php echo $this->_tpl_vars['profile_info_arr'][$this->_sections['profile_info']['index']]['css_class_name']; ?>
">
      <table <?php echo $this->_tpl_vars['myobj']->defaultTableBgColor; ?>
 >
        <tr>
          <th colspan="2" class="<?php echo $this->_tpl_vars['profile_info_arr'][$this->_sections['profile_info']['index']]['css_class_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->defaultBlockTitle; ?>
 ><span class="whitetext12"><?php echo $this->_tpl_vars['profile_info_arr'][$this->_sections['profile_info']['index']]['title']; ?>
</span></th>
        </tr>
        <tr><td class="<?php echo $this->_tpl_vars['profile_info_arr'][$this->_sections['profile_info']['index']]['css_class_name']; ?>
" colspan="2">
            <div class="clsProfileTableInfo">
				<table class="clsOtherInfo" id="<?php echo $this->_tpl_vars['CFG']['profile_box_id']['otherInfo_list']; ?>
">
                    <?php $_from = $this->_tpl_vars['profile_info_arr'][$this->_sections['profile_info']['index']]['profile_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
                    	<?php if ($this->_tpl_vars['value']['answer_result'] != $this->_tpl_vars['CFG']['profile']['question_no_answer'] && $this->_tpl_vars['value']['answer_result'] != ''): ?>
                     		<tr>
                     			<td><p><?php echo $this->_tpl_vars['value']['question']; ?>
</p></td>
                     			<td class="clsOtherAnswerSection">
                     					<div id="<?php echo $this->_tpl_vars['value']['sel_id']; ?>
" class="<?php echo $this->_tpl_vars['value']['class_name']; ?>
"><?php echo $this->_tpl_vars['value']['answer_result']; ?>
</div>
								</td>
                     		</tr>
                     	<?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
            	</table>
			</div>
		</td></tr>
      </table>
   </div>
<?php endif; ?>
<?php endfor; endif; ?>