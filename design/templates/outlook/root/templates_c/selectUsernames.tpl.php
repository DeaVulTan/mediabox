<?php /* Smarty version 2.6.18, created on 2012-01-21 09:06:50
         compiled from selectUsernames.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'selectUsernames.tpl', 7, false),)), $this); ?>
<?php if (isAjaxpage ( )): ?>	
	<?php if ($this->_tpl_vars['myobj']->getFormField('relation_id') == 0): ?>
         <input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" onclick = "CA(document.formContactList.name, document.formContactList.check_all.name)" />
        <label for="check_all"><?php echo $this->_tpl_vars['LANG']['selectusername_check_uncheck']; ?>
</label><br/>
        <?php $_from = $this->_tpl_vars['populateCheckBoxForRelation_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
        	<?php if ($this->_tpl_vars['populateCheckBoxForRelation_arr'][$this->_tpl_vars['inc']]['relation_label']): ?>
           <input type="checkbox" class="clsCheckBox" name="relation_arr[]" value="<?php echo $this->_tpl_vars['populateCheckBoxForRelation_arr'][$this->_tpl_vars['inc']]['relation_name']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="updateEmailList(this)"/>
          <label for="relation_<?php echo $this->_tpl_vars['populateCheckBoxForRelation_arr'][$this->_tpl_vars['inc']]['relation_id']; ?>
"><b><?php echo $this->_tpl_vars['populateCheckBoxForRelation_arr'][$this->_tpl_vars['inc']]['relation_label']; ?>
</b></label>                            
          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><br/>
        <?php $_from = $this->_tpl_vars['populateCheckBoxForFriendsList_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
        	<?php if ($this->_tpl_vars['populateCheckBoxForFriendsList_arr'][$this->_tpl_vars['inc']]['user_name']): ?>
            <input type="checkbox" class="clsCheckBox" name="friends_list[]" value="<?php echo $this->_tpl_vars['populateCheckBoxForFriendsList_arr'][$this->_tpl_vars['inc']]['user_name']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="updateEmailFriends(this)" id="friend_<?php echo $this->_tpl_vars['populateCheckBoxForFriendsList_arr'][$this->_tpl_vars['inc']]['friend']; ?>
"/>
            <label for="friend_<?php echo $this->_tpl_vars['populateCheckBoxForFriendsList_arr'][$this->_tpl_vars['inc']]['friend']; ?>
"><?php echo $this->_tpl_vars['populateCheckBoxForFriendsList_arr'][$this->_tpl_vars['inc']]['user_name']; ?>
</label>
            <?php endif; ?>                            
        <?php endforeach; endif; unset($_from); ?>	    
	<?php else: ?>    
        <?php $_from = $this->_tpl_vars['populateCheckBoxForRelationList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
        	<?php if ($this->_tpl_vars['value']['user_name']): ?>
                <input type="checkbox" class="clsCheckBox" name="friends_list[]" value="<?php echo $this->_tpl_vars['value']['user_name']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="updateEmailFriends(this)" id="friend_<?php echo $this->_tpl_vars['value']['record']['friend']; ?>
"/>
                <label for="friend_<?php echo $this->_tpl_vars['value']['record']['friend']; ?>
"><?php echo $this->_tpl_vars['value']['user_name']; ?>
</label>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>    
    <?php endif; ?>        
<?php else: ?>
    <div>
        <div id="selSelectUsername">
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

             <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupwithheadingtop_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                  <h2><?php echo $this->_tpl_vars['LANG']['selectusername_title']; ?>
</h2>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupheadingtop_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupwithheadingbottom_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_error')): ?>
                  <div id="selMsgError">
                    <p><?php echo $this->_tpl_vars['myobj']->getCommonErrorMsg(); ?>
</p>
                  </div>
                  <?php endif; ?>
                <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_success')): ?>
                  <div id="selMsgSuccess">
                    <p><?php echo $this->_tpl_vars['myobj']->getCommonErrorMsg(); ?>
</p>
                    <p><a href="#" onClick="window.close()"><?php echo $this->_tpl_vars['LANG']['selectusername_close']; ?>
</a></p>
                  </div>
                 <?php endif; ?>
            
                 <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('select_username')): ?>
                     <div id="selSelectUsername">
					    <div id="selSelectUserScroll" class="clsSelectUserName">
                                <form name="formContactList" id="formContactList" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                                  <table summary="<?php echo $this->_tpl_vars['LANG']['selectusername_tbl_summary']; ?>
">
                                    <tr>
                                      <td class="clsFormLabelCellDefault"><span><?php echo $this->_tpl_vars['LANG']['selectusername_address_book']; ?>
</span>
                                        <label for="relation_id"><span><?php echo $this->_tpl_vars['LANG']['selectusername_view']; ?>
</span></label> </td>
                                      <td class="clsFormFieldCellDefault"> <select name="relation_id" id="relation_id" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onChange="return callAjax('<?php echo $this->_tpl_vars['select_username_url']; ?>
'+this.value, 'friends_list')">
                                          <option value="0"><?php echo $this->_tpl_vars['LANG']['selectusername_all_contacts']; ?>
</option>
                                          <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['populateContactLists'],$this->_tpl_vars['myobj']->getFormField('relation_name')); ?>

                                        </select> </td>
                                    </tr>
                                    <tr>
                                      <td class="clsFormLabelCellDefault"> <label><span><?php echo $this->_tpl_vars['LANG']['selectusername_to_friend']; ?>
</span></label> </td>
                                      <td class="clsFormFieldCellDefault">
                                        <div id="friends_list">
                            <?php endif; ?>
                                        <?php if ($this->_tpl_vars['myobj']->getFormField('relation_id') == 0): ?>
                                            <input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" onclick = "CA(document.formContactList.name, document.formContactList.check_all.name)" />
                                            <label for="check_all" class="clsPaddingLine"><?php echo $this->_tpl_vars['LANG']['selectusername_check_uncheck']; ?>
</label><br/>
                                            <?php $_from = $this->_tpl_vars['populateCheckBoxForRelation_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
                                            	<?php if ($this->_tpl_vars['populateCheckBoxForRelation_arr'][$this->_tpl_vars['inc']]['relation_label']): ?>
                                                   <input type="checkbox" class="clsCheckBox" name="relation_arr[]" value="<?php echo $this->_tpl_vars['populateCheckBoxForRelation_arr'][$this->_tpl_vars['inc']]['relation_name']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="updateEmailList(this)" id="relation_<?php echo $this->_tpl_vars['populateCheckBoxForRelation_arr'][$this->_tpl_vars['inc']]['relation_id']; ?>
"/>
                                                  <label for="relation_<?php echo $this->_tpl_vars['populateCheckBoxForRelation_arr'][$this->_tpl_vars['inc']]['relation_id']; ?>
" class="clsPaddingLine"><b><?php echo $this->_tpl_vars['populateCheckBoxForRelation_arr'][$this->_tpl_vars['inc']]['relation_label']; ?>
</b></label>
                                              <?php endif; ?>                            
                                            <?php endforeach; endif; unset($_from); ?><br/>
                                            <?php $_from = $this->_tpl_vars['populateCheckBoxForFriendsList_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
                                            	<?php if ($this->_tpl_vars['populateCheckBoxForFriendsList_arr'][$this->_tpl_vars['inc']]['user_name']): ?>
                                                <input type="checkbox" class="clsCheckBox" name="friends_list[]" value="<?php echo $this->_tpl_vars['populateCheckBoxForFriendsList_arr'][$this->_tpl_vars['inc']]['user_name']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="updateEmailFriends(this)" id="friend_<?php echo $this->_tpl_vars['populateCheckBoxForFriendsList_arr'][$this->_tpl_vars['inc']]['friend']; ?>
"/>
                                                <label for="friend_<?php echo $this->_tpl_vars['populateCheckBoxForFriendsList_arr'][$this->_tpl_vars['inc']]['friend']; ?>
" class="clsPaddingLine"><?php echo $this->_tpl_vars['populateCheckBoxForFriendsList_arr'][$this->_tpl_vars['inc']]['user_name']; ?>
</label>                            
                                                <?php endif; ?>
                                            <?php endforeach; endif; unset($_from); ?>				
                                        <?php else: ?>					
                                            <?php $_from = $this->_tpl_vars['populateCheckBoxForFriendsList_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
                                            	<?php if ($this->_tpl_vars['populateCheckBoxForFriendsList_arr'][$this->_tpl_vars['inc']]['user_name']): ?>
                                                <input type="checkbox" class="clsCheckBox" name="friends_list[]" value="<?php echo $this->_tpl_vars['populateCheckBoxForFriendsList_arr'][$this->_tpl_vars['inc']]['user_name']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="updateEmailFriends(this)" id="friend_<?php echo $this->_tpl_vars['populateCheckBoxForFriendsList_arr'][$this->_tpl_vars['inc']]['friend']; ?>
"/>
                                                <label for="friend_<?php echo $this->_tpl_vars['populateCheckBoxForFriendsList_arr'][$this->_tpl_vars['inc']]['friend']; ?>
" class="clsPaddingLine"><?php echo $this->_tpl_vars['populateCheckBoxForFriendsList_arr'][$this->_tpl_vars['inc']]['user_name']; ?>
</label>   
                                                <?php endif; ?>                     
                                            <?php endforeach; endif; unset($_from); ?>
                                        <?php endif; ?>
            
                                        </div>
                                    </td>
                                  </tr>
                                    </table>
                                </form>
                                <form name="formEmailList" id="formEmailList" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
                                  <table summary="<?php echo $this->_tpl_vars['LANG']['selectusername_tbl_summary']; ?>
">
                                    <tr>
                                      <td class="clsFormLabelCellDefault"> <label for="email_address"><span><?php echo $this->_tpl_vars['LANG']['selectusername_email_to']; ?>
</span></label> </td>
                                      <td class="clsFormFieldCellDefault"> <textarea name="email_address" id="email_address" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="5" cols="50" ><?php echo $this->_tpl_vars['myobj']->getFormField('email_address'); ?>
</textarea>
                                        <br />
                                        <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->select_username['hidden_fields']); ?>

                                         </td>
                                    </tr>
                                    <tr>
                                    <td class="clsFormLabelCellDefault"></td>
                                      <td class="clsFormFieldCellDefault"> <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="button" class="clsSubmitButton" name="select" id="select" onClick="exit(); return false;" value="<?php echo $this->_tpl_vars['LANG']['selectusername_select']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></div></div> </td>
                                    </tr>
                                  </table>
                                </form>
                              </div>
                     </div>
                 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupwithheadingbottom_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>  
    
        </div>
    </div>
<?php endif; ?>
<?php echo '
<script type="text/javascript">
	$Jq(\'#selSelectUserScroll\').jScrollPane({scrollbarWidth:10, scrollbarMargin:10,showArrows:true});
</script>
'; ?>