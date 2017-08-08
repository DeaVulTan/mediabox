<?php /* Smarty version 2.6.18, created on 2011-11-03 09:23:42
         compiled from activity.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'myhomesidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selActivities" class="clsAllActivitiesBar">
<div class="clsOverflow">
  <div class="clsFloatLeft"><h2 class="clsMyHomeBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['myhome_recent_activities_title']; ?>
</h2></div>
    <div id="selActivityLinks" class="clsTabNavigation clsRecentActivities">
        <ul>
            <li id="selHeaderActivityMy"><span><a href="<?php echo $this->_tpl_vars['myobj']->activity_my_url; ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_recent_activities_my']; ?>
</a></span></li>
            <li id="selHeaderActivityFriends"><span><a href="<?php echo $this->_tpl_vars['myobj']->activity_friends_url; ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_recent_activities_friends']; ?>
</a></span></li>
            <li id="selHeaderActivityAll"><span><a href="<?php echo $this->_tpl_vars['myobj']->activity_all_url; ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_recent_activities_all']; ?>
</a></span></li>
        </ul>
    </div>
 </div>	
    <script type="text/javascript">
		var subMenuClassName1='clsActiveTabNavigation';
		var hoverElement1  = '.clsTabNavigation';
		var selector = 'li';
		loadChangeClass(hoverElement1, selector, subMenuClassName1);
	</script>


  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_activities')): ?>
    <?php if ($this->_tpl_vars['CFG']['admin']['show_recent_activities']): ?>
    	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
            <!--Recent Activities Starts here -->
              <div class="clsRecentActivityContent">
                    <div id="selActivityContent" class="clsMembersListActivity">
                        <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
						  <div class="clsPaddingTopBottom">
                            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						  </div>	
                        <?php endif; ?>

                           <?php echo $this->_tpl_vars['myobj']->myHomeActivity(10); ?>


                        <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
						 <div class="clsPaddingTop5">
                            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						  </div>	
                        <?php endif; ?>

                    </div>
              </div>
            <!--Recent Activities Ends here -->
	    <?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'myhomesidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>