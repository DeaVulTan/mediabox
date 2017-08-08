<?php /* Smarty version 2.6.18, created on 2011-10-18 14:16:10
         compiled from populateRelationRightNavigation.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="clsSideBarLinks" id="selManageRelations">
	<div class="clsSideBar">
        <p class="clsSideBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['header_nav_managerelations_friends']; ?>
</p>

     <div class="clsSideBarRight">
      <div class="clsSideBarContent">
      <ul>
        <li<?php echo $this->_tpl_vars['populateRelationRightNavigation_arr']['membersInvite']; ?>
><a href="<?php echo $this->_tpl_vars['header']->getUrl('membersinvite','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_top_menu_invite_friends']; ?>
</a></li>
        <li<?php echo $this->_tpl_vars['populateRelationRightNavigation_arr']['invitationHistory']; ?>
><a href="<?php echo $this->_tpl_vars['header']->getUrl('invitationhistory','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_friends_invite_history']; ?>
</a></li>
        <li<?php echo $this->_tpl_vars['populateRelationRightNavigation_arr']['myFriends']; ?>
><a href="<?php echo $this->_tpl_vars['header']->getUrl('myfriends','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_managerelations_my_friends']; ?>
</a></li>
        <li<?php echo $this->_tpl_vars['populateRelationRightNavigation_arr']['myFriends_pg_top_friends']; ?>
><a href="<?php echo $this->_tpl_vars['header']->getUrl('myfriends','?pg=top_friends','?pg=top_friends','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_managerelations_my_top_friends']; ?>
</a></li>
        <li<?php echo $this->_tpl_vars['populateRelationRightNavigation_arr']['relationManage']; ?>
><a href="<?php echo $this->_tpl_vars['header']->getUrl('relationmanage','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_nav_managerelations_manage_relations']; ?>
</a>
          <ul>
            <?php $_from = $this->_tpl_vars['populateRelationRightNavigation_arr']['myRelation_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['myRelationKey'] => $this->_tpl_vars['myRelationValue']):
?>
	            <li <?php echo $this->_tpl_vars['myRelationValue']['class']; ?>
><a <?php echo $this->_tpl_vars['myRelationValue']['href']; ?>
 title="<?php echo $this->_tpl_vars['myRelationValue']['title']; ?>
 <?php echo $this->_tpl_vars['LANG']['header_nav_managerelations_contacts']; ?>
"><?php echo $this->_tpl_vars['myRelationValue']['value']; ?>
&nbsp;[<?php echo $this->_tpl_vars['myRelationValue']['count']; ?>
]</a></li>
            <?php endforeach; endif; unset($_from); ?>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>