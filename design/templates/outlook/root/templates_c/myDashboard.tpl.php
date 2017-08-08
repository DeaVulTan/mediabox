<?php /* Smarty version 2.6.18, created on 2011-10-17 14:53:01
         compiled from myDashboard.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'myDashboard.tpl', 5, false),array('modifier', 'capitalize', 'myDashboard.tpl', 12, false),array('modifier', 'cat', 'myDashboard.tpl', 76, false),)), $this); ?>
<h3><?php echo $this->_tpl_vars['LANG']['header_mydashboard_short_links']; ?>
</h3>
			<ul class="clsDashLink">
                <?php if ($this->_tpl_vars['header']->headerBlock['is_dashboard_module']): ?>
                <?php $this->assign('break_count', 0); ?>
                    <?php $this->assign('totcnt', count($this->_tpl_vars['header']->headerBlock['dashboard_module_arr'])); ?>
                    <?php $this->assign('totcnt', $this->_tpl_vars['totcnt']-1); ?>                        
                    <?php $_from = $this->_tpl_vars['header']->headerBlock['dashboard_module_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module'] => $this->_tpl_vars['moduleStats']):
?>  
                         <?php if ($this->_tpl_vars['header']->headerBlock['dashboard_module_arr'][$this->_tpl_vars['module']]): ?>
					<?php $_from = $this->_tpl_vars['header']->headerBlock['dashboard_module_arr'][$this->_tpl_vars['module']]['shortcuts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['dashshortlink']):
?>
                    				<?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
                                    
                    	     	   <li><a href="<?php echo $this->_tpl_vars['dashshortlink']['link_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['dashshortlink']['link_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</a></li>
									<?php if ($this->_tpl_vars['break_count'] > 3): ?>
                                    </ul><ul class="clsDashLink">
                                    <?php $this->assign('break_count', 0); ?>
                                    <?php endif; ?>                                   
                             <?php endforeach; endif; unset($_from); ?>
                         <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                <?php endif; ?>
				
                <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
                <li><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('myfriends'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_mydashboard_friends']; ?>
: <span><?php echo $this->_tpl_vars['getTotalFriendsNew']; ?>
</span></a></li>
                    <?php if ($this->_tpl_vars['break_count'] > 3): ?>
                        </ul><ul class="clsDashLink">
                        <?php $this->assign('break_count', 0); ?>
                    <?php endif; ?>                 
                <?php if (chkAllowedModule ( array ( 'affiliate' ) )): ?>
                    <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
                <li><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('memberslist','?browse=referrals','?browse=referrals'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_mydashboard_my_referrals']; ?>
</a></li>
                    <?php if ($this->_tpl_vars['break_count'] > 3): ?>
                        </ul><ul class="clsDashLink">
                        <?php $this->assign('break_count', 0); ?>
                    <?php endif; ?>  
                <?php endif; ?>
                <?php if (chkAllowedModule ( array ( 'mail' ) )): ?>
                    <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
                <li><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mail','?folder=inbox','inbox/'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_mydashboard_inbox']; ?>
</a></li>
                    <?php if ($this->_tpl_vars['break_count'] > 3): ?>
                        </ul><ul class="clsDashLink">
                        <?php $this->assign('break_count', 0); ?>
                    <?php endif; ?>  
                <?php endif; ?>
                	<?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
                <li><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('myprofile'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_mydashboard_profile']; ?>
</a></li>
                    <?php if ($this->_tpl_vars['break_count'] > 3): ?>
                        </ul><ul class="clsDashLink">
                        <?php $this->assign('break_count', 0); ?>
                    <?php endif; ?>                
                <?php if (chkAllowedModule ( array ( 'members_banner' , 'members_post_banner' ) )): ?>
                    <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
                <li ><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('managebanner'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_mydashboard_manage_banner']; ?>
</a></li>
					<?php if ($this->_tpl_vars['break_count'] > 3): ?>
                        </ul><ul class="clsDashLink">
                        <?php $this->assign('break_count', 0); ?>
                    <?php endif; ?>                
                <?php endif; ?>
                <?php if (chkAllowedModule ( array ( 'affiliate' ) )): ?>
                    <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
                <li><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('earnings'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_mydashboard_my_earnings']; ?>
</a></li>
					<?php if ($this->_tpl_vars['break_count'] > 3): ?>
                        </ul><ul class="clsDashLink">
                        <?php $this->assign('break_count', 0); ?>
                    <?php endif; ?>                
                <?php endif; ?>
                    <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
				<li ><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('membersinvite'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_dashboard_members_invite']; ?>
</a></li>
					<?php if ($this->_tpl_vars['break_count'] > 3): ?>
                        </ul><ul class="clsDashLink">
                        <?php $this->assign('break_count', 0); ?>
                    <?php endif; ?>                
              </ul>
            <?php if ($this->_tpl_vars['header']->headerBlock['is_dashboard_module']): ?>                       
                  <?php $_from = $this->_tpl_vars['header']->headerBlock['dashboard_module_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module'] => $this->_tpl_vars['dashmodule']):
?> 
                      <?php if ($this->_tpl_vars['header']->headerBlock['dashboard_module_arr'][$this->_tpl_vars['module']]): ?>
                         <?php $this->assign('module_header_lang', ((is_array($_tmp=((is_array($_tmp='mydahsboard_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['module']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['module'])))) ? $this->_run_mod_handler('cat', true, $_tmp, '_stats_header_title') : smarty_modifier_cat($_tmp, '_stats_header_title'))); ?>
                          <h3><?php echo $this->_tpl_vars['LANG'][$this->_tpl_vars['module_header_lang']]; ?>
</h3>
                                    <ul id="selDashStats" class="clsDashLink"> 
                                  <?php if ($this->_tpl_vars['header']->headerBlock['dashboard_module_arr'][$this->_tpl_vars['module']]): ?>                              
                                     <?php $_from = $this->_tpl_vars['header']->headerBlock['dashboard_module_arr'][$this->_tpl_vars['module']]['stats']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['dashstatslink']):
?> 
                                        <li><a href="<?php echo $this->_tpl_vars['dashstatslink']['link_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['dashstatslink']['link_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
<?php if ($this->_tpl_vars['dashstatslink']['stats_value'] != ''): ?>: <span><?php echo $this->_tpl_vars['dashstatslink']['stats_value']; ?>
</span><?php endif; ?></a></li>
                                     <?php endforeach; endif; unset($_from); ?> 
                                  <?php endif; ?>                                                                  
                                 </ul>
                       <?php endif; ?>
                   <?php endforeach; endif; unset($_from); ?>
             <?php endif; ?>  