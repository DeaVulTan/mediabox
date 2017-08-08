<?php /* Smarty version 2.6.18, created on 2011-10-18 15:28:01
         compiled from profileMyfriendsBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'profileMyfriendsBlock.tpl', 29, false),)), $this); ?>
<div class="clsFriendsInfoTable">
<table <?php echo $this->_tpl_vars['myobj']->defaultTableBgColor; ?>
 >
        <tr>
          <th <?php echo $this->_tpl_vars['myobj']->defaultBlockTitle; ?>
 >
           <div class="clsProfileFriendsInfoTitle"><?php echo $this->_tpl_vars['LANG']['myprofile_shelf_friends']; ?>
</div>
           <div class="clsProfileFriendsInfoLink">
                <?php if ($this->_tpl_vars['myobj']->isEditableLinksAllowed()): ?>
                    <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('membersinvite'); ?>
"><?php echo $this->_tpl_vars['LANG']['viewprofile_link_view_invite_friends']; ?>
</a>
                <?php endif; ?>
            </div>
          </th>
        </tr>
	 <?php if ($this->_tpl_vars['friends_list_arr'] == 0): ?>
        <tr>
          <td>
          <div id="selMsgAlert">
              <p><?php echo $this->_tpl_vars['LANG']['viewprofile_friends_no_msg']; ?>
</p>
          </div></td>
        </tr>
      <?php else: ?>
        <tr>
          <td>
          <div class="clsFriendsInfo" id="<?php echo $this->_tpl_vars['CFG']['profile_box_id']['friends_list']; ?>
">
              <ul>
              <?php $this->assign('td_count', 0); ?>
               <?php $_from = $this->_tpl_vars['friends_list_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
                <li>
                    <a class="ClsProfileImageContainer ClsProfileImageBorder1 ClsProfile45x45" href="<?php echo $this->_tpl_vars['value']['firiendProfileUrl']; ?>
">
                        <img src="<?php echo $this->_tpl_vars['value']['friendicon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['value']['friendName'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['value']['friendName']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['value']['firiendProfileUrl']; ?>
')" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['value']['friendicon']['s_width'],$this->_tpl_vars['value']['friendicon']['s_height']); ?>
/>
                    </a>
                    <p id="selMemberName_<?php echo $this->_tpl_vars['item']; ?>
" class="clsProfileRootThumbImg">
                        <a href="<?php echo $this->_tpl_vars['value']['firiendProfileUrl']; ?>
"><?php echo $this->_tpl_vars['value']['friendName']; ?>
</a>
                    </p>
	             </li>
                 <?php $this->assign('td_count', $this->_tpl_vars['td_count']+1); ?>
                <?php endforeach; endif; unset($_from); ?>
                <?php if ($this->_tpl_vars['td_count'] < 7): ?>
                <?php $this->assign('td_max', 7); ?>
                <?php $this->assign('td_loop', $this->_tpl_vars['td_max']-$this->_tpl_vars['td_count']); ?>
                <?php unset($this->_sections['loop']);
$this->_sections['loop']['name'] = 'loop';
$this->_sections['loop']['start'] = (int)0;
$this->_sections['loop']['loop'] = is_array($_loop=$this->_tpl_vars['td_loop']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['loop']['show'] = true;
$this->_sections['loop']['max'] = $this->_sections['loop']['loop'];
$this->_sections['loop']['step'] = 1;
if ($this->_sections['loop']['start'] < 0)
    $this->_sections['loop']['start'] = max($this->_sections['loop']['step'] > 0 ? 0 : -1, $this->_sections['loop']['loop'] + $this->_sections['loop']['start']);
else
    $this->_sections['loop']['start'] = min($this->_sections['loop']['start'], $this->_sections['loop']['step'] > 0 ? $this->_sections['loop']['loop'] : $this->_sections['loop']['loop']-1);
if ($this->_sections['loop']['show']) {
    $this->_sections['loop']['total'] = min(ceil(($this->_sections['loop']['step'] > 0 ? $this->_sections['loop']['loop'] - $this->_sections['loop']['start'] : $this->_sections['loop']['start']+1)/abs($this->_sections['loop']['step'])), $this->_sections['loop']['max']);
    if ($this->_sections['loop']['total'] == 0)
        $this->_sections['loop']['show'] = false;
} else
    $this->_sections['loop']['total'] = 0;
if ($this->_sections['loop']['show']):

            for ($this->_sections['loop']['index'] = $this->_sections['loop']['start'], $this->_sections['loop']['iteration'] = 1;
                 $this->_sections['loop']['iteration'] <= $this->_sections['loop']['total'];
                 $this->_sections['loop']['index'] += $this->_sections['loop']['step'], $this->_sections['loop']['iteration']++):
$this->_sections['loop']['rownum'] = $this->_sections['loop']['iteration'];
$this->_sections['loop']['index_prev'] = $this->_sections['loop']['index'] - $this->_sections['loop']['step'];
$this->_sections['loop']['index_next'] = $this->_sections['loop']['index'] + $this->_sections['loop']['step'];
$this->_sections['loop']['first']      = ($this->_sections['loop']['iteration'] == 1);
$this->_sections['loop']['last']       = ($this->_sections['loop']['iteration'] == $this->_sections['loop']['total']);
?>
               <li>&nbsp;</li>
               <?php endfor; endif; ?>
                <?php endif; ?>
              </ul>
            </div>
		   </td>
		 </tr>	
		 <td colspan="2" class="clsMoreBgCols">
            <div class="clsRootViewMoreLink">
                <?php if ($this->_tpl_vars['friends_list_arr'] != 0): ?>
                    <a href="<?php echo $this->_tpl_vars['userfriendlistURL']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewprofile_link_view_friends']; ?>
</a>
                <?php endif; ?>
            </div>
            </td>
       <?php endif; ?>       </table>
</div>