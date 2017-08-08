<?php /* Smarty version 2.6.18, created on 2011-10-31 10:32:35
         compiled from mail_message_header.tpl */ ?>
<div class="clsDataTable"><table id="selShowMail"> 
  <tr>
    <td>    
    <div id="selMisNavLinks">
      <ul class="clsMailLinks">
        <?php $_from = $this->_tpl_vars['mail_header_link']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
            <li class="cls<?php echo $this->_tpl_vars['value']['display_text']; ?>
"><div class="clsMailLinkLeft"><div class="clsMailLinkRight"><a href="<?php echo $this->_tpl_vars['value']['href']; ?>
" onclick="<?php echo $this->_tpl_vars['value']['onclick']; ?>
"><?php echo $this->_tpl_vars['mail_header_link'][$this->_tpl_vars['key']]['display_text']; ?>
</a></div></div></li>
        <?php endforeach; endif; unset($_from); ?>
      </ul>
    </div>
    </td>
    <td class="clsMsgNavigationCell"><div class="clsPagingList">
       <ul>
          <?php if ($this->_tpl_vars['mail_previous_link']): ?>
         <li class="clsPrevLinkPage"><a href="<?php echo $this->_tpl_vars['mail_previous_link']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['common_paging_previous']; ?>
</span></a></li>
          <?php else: ?>
         <li class="clsInactivePrevLinkPage clsInActivePageLink"><span><?php echo $this->_tpl_vars['LANG']['common_paging_previous']; ?>
</span></li>
          <?php endif; ?>
          <?php if ($this->_tpl_vars['mail_next_link']): ?>
         <li class="clsNextPageLink"><a href="<?php echo $this->_tpl_vars['mail_next_link']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['common_paging_next']; ?>
</span></a></li>
          <?php else: ?>
         <li class="clsInactiveNextPageLink clsInActivePageLink"><span><?php echo $this->_tpl_vars['LANG']['common_paging_next']; ?>
</span></li>
          <?php endif; ?>
        </ul>
      </div></td>
  </tr>
</table></div>