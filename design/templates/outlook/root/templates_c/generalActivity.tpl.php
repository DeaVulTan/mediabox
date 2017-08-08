<?php /* Smarty version 2.6.18, created on 2011-10-31 10:32:54
         compiled from generalActivity.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'generalActivity.tpl', 9, false),array('modifier', 'ucwords', 'generalActivity.tpl', 43, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['generalActivity_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['generalValue']):
?>
    <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['generalValue']['parent_id']): ?>
        <?php if ($this->_tpl_vars['generalValue']['action_key'] == 'be_friended'): ?>
            <div>
                <div class="clsWhatsGoingUserDetails">
                    <div class="clsWhatsGoingBg clsOverflow">
                        <div class="clsFloatLeft">
                            <a href="<?php echo $this->_tpl_vars['generalValue']['be_friended']['user2']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                                <img border="0" src="<?php echo $this->_tpl_vars['generalValue']['be_friended']['user2']['icon']['s_url']; ?>
" border="0" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['generalValue']['be_friended']['user2']['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['generalValue']['be_friended']['user2']['name']; ?>
"   <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['generalValue']['be_friended']['user1']['icon']['s_width'],$this->_tpl_vars['generalValue']['be_friended']['user1']['icon']['s_height']); ?>
  />
                            </a>
                        </div>
                        <div class="clsUserDetailsFriends">
                            <div class="clsOverflow clsWhatsGoingUser">
                                <div class="clsFloatLeft">
                                   <a href="<?php echo $this->_tpl_vars['generalValue']['be_friended']['user2']['url']; ?>
"><?php echo $this->_tpl_vars['generalValue']['be_friended']['user2']['name']; ?>
</a> 
                                </div>	
                                <div class="clsFloatRight">
                                    <span></span>
                                </div>	
                            </div>
                            <div class="clsUserActivityWhtsgoing">
                                <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-newlyjoined.gif" alt="" border="0" />
                                <?php echo $this->_tpl_vars['generalValue']['be_friended']['hasfriend']; ?>
 <a href="<?php echo $this->_tpl_vars['generalValue']['be_friended']['user1']['url']; ?>
"><?php echo $this->_tpl_vars['generalValue']['be_friended']['user1']['name']; ?>
</a>  
                              
                            </div>	
                        </div>	
                    </div>	
                </div>   
             </div>
        <?php elseif ($this->_tpl_vars['generalValue']['action_key'] == 'new_member'): ?>
            <div>
            
                <div class="clsWhatsGoingUserDetails">
                    <div class="clsWhatsGoingBg clsOverflow">
                        <div class="clsFloatLeft">
                            <a href="<?php echo $this->_tpl_vars['generalValue']['new_member']['user_url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                                <img src="<?php echo $this->_tpl_vars['generalValue']['new_member']['icon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['generalValue']['new_member']['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" border="0" title="<?php echo $this->_tpl_vars['generalValue']['new_member']['name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['generalValue']['new_member']['icon']['s_width'],$this->_tpl_vars['generalValue']['new_member']['icon']['s_height']); ?>
  />
                            </a>
                        </div>
                        <div class="clsUserDetailsFriends">
                            <div class="clsOverflow clsWhatsGoingUser">
                                <div class="clsFloatLeft">
                                    <a href="<?php echo $this->_tpl_vars['generalValue']['new_member']['user_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['generalValue']['new_member']['name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a> 
                                </div>	
                                <div class="clsFloatRight">
                                    <span><?php echo $this->_tpl_vars['generalValue']['new_member']['date_added']; ?>
</span>
                                </div>	
                            </div>
                            <div class="clsUserActivityWhtsgoing">
                                <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-newlyjoined.gif" alt="" border="0" />
                                <?php echo $this->_tpl_vars['generalValue']['new_member']['lang']; ?>

                                
                            </div>	
                        </div>	
                    </div>	
                </div>    
           </div>        
        <?php elseif ($this->_tpl_vars['generalValue']['action_key'] == 'new_member_by_admin'): ?>
            <div>

                    <div class="clsWhatsGoingUserDetails">
                        <div class="clsWhatsGoingBg clsOverflow">
                            <div class="clsFloatLeft">
                                <a href="<?php echo $this->_tpl_vars['generalValue']['new_member_by_admin']['user_url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                                    <img border="0" src="<?php echo $this->_tpl_vars['generalValue']['new_member_by_admin']['user_icon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['generalValue']['new_member_by_admin']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['generalValue']['new_member_by_admin']['user_name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['generalValue']['new_member_by_admin']['user_icon']['s_width'],$this->_tpl_vars['generalValue']['new_member_by_admin']['user_icon']['s_height']); ?>
 border="0" />
                                </a>
                            </div>
                            <div class="clsUserDetailsFriends">
                                <div class="clsOverflow clsWhatsGoingUser">
                                    <div class="clsFloatLeft">
                                        <a href="<?php echo $this->_tpl_vars['generalValue']['new_member_by_admin']['user_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['generalValue']['new_member_by_admin']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a> 
                                    </div>	
                                    <div class="clsFloatRight">
                                        <span><?php echo $this->_tpl_vars['generalValue']['new_member_by_admin']['date_added']; ?>
</span>
                                    </div>	
                                </div>
                                <div class="clsUserActivityWhtsgoing">
                                    <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-newlyjoined.gif" alt="" border="0" />
                                    <?php echo $this->_tpl_vars['generalValue']['new_member_by_admin']['lang3']; ?>

                                    
                                </div>	
                            </div>	
                        </div>	
                    </div>    
           </div>                  
        <?php elseif ($this->_tpl_vars['generalValue']['action_key'] == 'new_scrap'): ?>
            <div>

                 	<div class="clsWhatsGoingUserDetails">
                        <div class="clsWhatsGoingBg clsOverflow">
                            <div class="clsFloatLeft">
                                <a href="<?php echo $this->_tpl_vars['generalValue']['new_scrap']['user_url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                                    <img border="0" src="<?php echo $this->_tpl_vars['generalValue']['new_scrap']['icon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['generalValue']['new_scrap']['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['generalValue']['new_scrap']['name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['generalValue']['new_scrap']['icon']['s_width'],$this->_tpl_vars['generalValue']['new_scrap']['icon']['s_height']); ?>
 border="0" />
                                </a>
                            </div>
                            <div class="clsUserDetailsFriends">
                                <div class="clsOverflow clsWhatsGoingUser">
                                    <div class="clsFloatLeft">
                                        <a href="<?php echo $this->_tpl_vars['generalValue']['new_scrap']['user_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['generalValue']['new_scrap']['name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a> 
                                    </div>	
                                    <div class="clsFloatRight">
                                        <span></span>
                                    </div>	
                                </div>
                                <div class="clsUserActivityWhtsgoing">
                                    <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-recivescrap.gif" alt="" border="0" />
                                     <?php echo $this->_tpl_vars['generalValue']['new_scrap']['lang']; ?>

                                   
                                </div>	
                            </div>	
                        </div>	
                    </div> 
             </div> 
        <?php elseif ($this->_tpl_vars['generalValue']['action_key'] == 'subscribed'): ?>
            <div>
            
                 	<div class="clsWhatsGoingUserDetails">
                        <div class="clsWhatsGoingBg clsOverflow">
                            <div class="clsFloatLeft">
                                <a href="<?php echo $this->_tpl_vars['generalValue']['subscribed']['user1']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                                    <img src="<?php echo $this->_tpl_vars['generalValue']['subscribed']['user1']['icon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['generalValue']['subscribed']['user1']['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['generalValue']['subscribed']['user1']['name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['generalValue']['subscribed']['user1']['icon']['s_width'],$this->_tpl_vars['generalValue']['subscribed']['user1']['icon']['s_height']); ?>
 border="0" />
                                </a>
                            </div>
                            <div class="clsUserDetailsFriends">
                                <div class="clsOverflow clsWhatsGoingUser">
                                    <div class="clsFloatLeft"><a href="<?php echo $this->_tpl_vars['generalValue']['subscribed']['user1']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['generalValue']['subscribed']['user1']['name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a> 
                                    </div>	
                                    <div class="clsFloatRight">
                                        <span></span>
                                    </div>	
                                </div>
                                <div class="clsUserActivityWhtsgoing">
                                    <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-newlyjoined.gif" alt="" border="0" />
                                     <?php echo $this->_tpl_vars['generalValue']['subscribed']['lang']; ?>
 <a href="<?php echo $this->_tpl_vars['generalValue']['subscribed']['user2']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['generalValue']['subscribed']['user2']['name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a>
                                  
                                </div>	
                            </div>	
                        </div>	
                    </div>
            </div>
        <?php endif; ?>
	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>