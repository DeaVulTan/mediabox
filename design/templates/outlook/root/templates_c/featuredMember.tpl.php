<?php /* Smarty version 2.6.18, created on 2011-12-23 17:20:27
         compiled from featuredMember.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'featuredMember.tpl', 10, false),array('modifier', 'count', 'featuredMember.tpl', 24, false),array('modifier', 'cat', 'featuredMember.tpl', 29, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsSideBarLinks" id="selFeaturedMembers">
	<div class="clsSideBar">
    	<div>
			<p class="clsSideBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['header_nav_featured_title']; ?>
</p>
		</div>
		<div class="clsSideBarRight">
			<div class="clsFeaturedMemberLeft">
                   	<a href="<?php echo $this->_tpl_vars['featuredMember']['profileUrl']; ?>
" class="ClsImageContainer ClsImageBorder2 Cls90x90">
                       	<img src="<?php echo $this->_tpl_vars['featuredMember']['icon']['t_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['featuredMember']['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 9) : smarty_modifier_truncate($_tmp, 9)); ?>
" title="<?php echo $this->_tpl_vars['featuredMember']['name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_thumb_width'],$this->_config[0]['vars']['image_thumb_height'],$this->_tpl_vars['featuredMember']['icon']['t_width'],$this->_tpl_vars['featuredMember']['icon']['t_height']); ?>
 />
                    </a>
				</div>
                <div class="clsFeaturedMemberRight">
                    	<div class="clsFeaturedMembersLinks"><a href="<?php echo $this->_tpl_vars['featuredMember']['profileUrl']; ?>
"><?php echo $this->_tpl_vars['featuredMember']['name']; ?>
</a> 
							<span><?php echo $this->_tpl_vars['featuredMember']['age']; ?>
 / <?php echo $this->_tpl_vars['featuredMember']['sex']; ?>
</span></div>
                		<div class="clsMembersLinks">
                          <?php $this->assign('break_count', 0); ?>
                          <ul class="clsFloatLeft"> 
							<li class="clsMembersFriend">
                            <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
								<span><?php echo $this->_tpl_vars['LANG']['header_nav_featured_total_friends']; ?>
:</span><a href="<?php echo $this->_tpl_vars['featuredMember']['viewFriendsUrl']; ?>
"> <?php echo $this->_tpl_vars['featuredMember']['total_friends']; ?>
</a>
							</li>
            
                            <?php $this->assign('totcnt', count($this->_tpl_vars['CFG']['site']['modules_arr'])); ?>
                            <?php $this->assign('totcnt', $this->_tpl_vars['totcnt']-1); ?>
                                <?php $_from = $this->_tpl_vars['CFG']['site']['modules_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['module_value']):
?>
                                      <?php if (chkAllowedModule ( array ( $this->_tpl_vars['module_value'] ) )): ?>
                                          <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
                                            <?php $this->assign('total_stats_value', ((is_array($_tmp=((is_array($_tmp='total_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['module_value']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['module_value'])))) ? $this->_run_mod_handler('cat', true, $_tmp, 's') : smarty_modifier_cat($_tmp, 's'))); ?>
                                            <li class="clsMembers<?php echo $this->_tpl_vars['module_value']; ?>
"><?php echo $this->_tpl_vars['featuredMember'][$this->_tpl_vars['total_stats_value']]; ?>
</li>
                                          <?php if (( $this->_tpl_vars['break_count'] > 3 && $this->_tpl_vars['totcnt'] != $this->_tpl_vars['inc'] )): ?>
                                                </ul>
                                                <ul class="clsFloatRight">
                                                <?php $this->assign('break_count', 0); ?>
                                          <?php endif; ?>
                                              
                                        <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?>
                                </ul>
                        </div>
                </div>
           </div>
    </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>