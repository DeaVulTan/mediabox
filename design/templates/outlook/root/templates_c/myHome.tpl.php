<?php /* Smarty version 2.6.18, created on 2011-10-18 14:18:57
         compiled from myHome.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'myHome.tpl', 3, false),array('modifier', 'capitalize', 'myHome.tpl', 19, false),array('modifier', 'date_format', 'myHome.tpl', 69, false),)), $this); ?>
<div id="selMyHome">
  <div class="clsMyhomeUserBlock clsOverflow">
    <p class="clsMyHomeAvatar"> <a class="ClsImageContainer ClsImageBorder2 Cls66x66" href="<?php echo $this->_tpl_vars['myobj']->getUserDetail('user_id',$this->_tpl_vars['CFG']['user']['user_id'],'profile_url'); ?>
"> <img src="<?php echo $this->_tpl_vars['myobj']->icon['t_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['CFG']['user']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 7) : smarty_modifier_truncate($_tmp, 7)); ?>
" title="<?php echo $this->_tpl_vars['CFG']['user']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(66,66,$this->_tpl_vars['myobj']->icon['t_width'],$this->_tpl_vars['myobj']->icon['t_height']); ?>
 /> </a> </p>
    <div class="clsFloatRight clsMyHomeUrlcontainer">
      <div class="clsMyHomeUrlTextBox" id="purl" onclick="fnSelect('purl')">
        <div class="clsMyHomeUrlTextBoxInner"><?php echo $this->_tpl_vars['myobj']->profile_url_wbr; ?>
</div>
      </div>
      <div class="clsDashboardRightlinks">
        <ul class="clsOverflow">
          <li class="selDropDownLink clsMyHomeShortcut "> <a class="clsMainShortcutMenu" href="#"><?php echo $this->_tpl_vars['LANG']['myhome_myshortcuts_title']; ?>
</a>
            <ul class="clsMyHomeDropDownMenu">
              <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/',''); ?>

              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'myhomedrop_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
              <li><a href="<?php echo $this->_tpl_vars['myobj']->myshortcuts_arr['viewprofile_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_myshortcuts_profile']; ?>
</a></li>
              <li><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('myfriends','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_myshortcuts_friends']; ?>
</a></li>
              <?php if ($this->_tpl_vars['myobj']->myshortcuts_arr['is_shortcut_module']): ?>
              <?php $_from = $this->_tpl_vars['myobj']->myshortcuts_arr['shortcut_module_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module'] => $this->_tpl_vars['linkmodule']):
?>
              <?php if ($this->_tpl_vars['myobj']->myshortcuts_arr['shortcut_module_arr'][$this->_tpl_vars['module']]): ?>
              <li><a href="<?php echo $this->_tpl_vars['myobj']->myshortcuts_arr['shortcut_module_arr'][$this->_tpl_vars['module']]['viewmy']['link_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->myshortcuts_arr['shortcut_module_arr'][$this->_tpl_vars['module']]['viewmy']['link_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</a></li>
              <?php endif; ?>
              <?php endforeach; endif; unset($_from); ?>
              <?php endif; ?>
              <?php if (chkIsSubscriptionEnabled ( )): ?>
              <li><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mysubscription','?pg=member_subscription','member_subscription/','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_myshortcuts_subscriptions']; ?>
</a></li>
              <?php endif; ?>
              <li><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('profilebasic','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_myshortcuts_edit_profile']; ?>
</a></li>
              <li><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('profilesettings','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_myshortcuts_account_settings']; ?>
</a></li>
              <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/',''); ?>

              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'myhomedrop_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </ul>
          </li>
          <li class="selDropDownLink clsMyHomeInvite"> <a class="clsMainShortcutMenu" href="<?php echo $this->_tpl_vars['myobj']->getUrl('membersinvite','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['nav_friends_invite_friends']; ?>
</a>
            <ul class="clsMyHomeInviteDropDownMenu">
              <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/',''); ?>

              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'invitedrop_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
              <?php if ($this->_tpl_vars['myobj']->userDetails['new_requests']): ?>
              <li><a class="clsFriendsRequest" href="<?php echo $this->_tpl_vars['myobj']->getUrl('mail','?folder=request','request/','members'); ?>
"><?php echo $this->_tpl_vars['myobj']->userDetails['new_requests']; ?>
&nbsp;<?php if ($this->_tpl_vars['myobj']->userDetails['new_requests'] > 1): ?><?php echo $this->_tpl_vars['LANG']['nav_friends_friends_requests']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['nav_friends_friends_request']; ?>
<?php endif; ?></a></li>
              <?php endif; ?>
              <?php if ($this->_tpl_vars['myobj']->userDetails['video_mails']): ?>
              <li><a class="clsVideoMail" href="<?php echo $this->_tpl_vars['myobj']->getUrl('mail','?folder=video','video/','members'); ?>
"><?php echo $this->_tpl_vars['myobj']->userDetails['video_mails']; ?>
&nbsp;<?php if ($this->_tpl_vars['myobj']->userDetails['new_requests'] > 1): ?><?php echo $this->_tpl_vars['LANG']['nav_friends_video_mails']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['nav_friends_video_mail']; ?>
<?php endif; ?></a></li>
              <?php endif; ?>
              <li><a class="clsInviteFriends" href="<?php echo $this->_tpl_vars['myobj']->getUrl('membersinvite','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['nav_friends_invite_friends']; ?>
</a></li>
              <li><a class="clsInvitationHistory" href="<?php echo $this->_tpl_vars['myobj']->getUrl('invitationhistory','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['nav_friends_invitation_history']; ?>
</a></li>
              <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/',''); ?>

              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'invitedrop_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </ul>
          </li>
        </ul>
      </div>
    </div>
    <div class="clsDashboardUserdetails">
	 <div class="clsOverflow">
      	<div class="clsFloatLeft"><p class="clsMydashboardHeading"> My Dashboard </p> </div>
		<div class="clsFloatLeft">
			<?php if ($this->_tpl_vars['myobj']->showUpgradeMembershipButton()): ?>
			  <div class="clsUpgradeMembership">
				 <p><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('upgrademembership'); ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_upgrademembership']; ?>
</a></p>
			  </div>
			<?php endif; ?>
		</div>
	 </div>	
      <p class="clsDashboardUsername clsOverflow"> 
      	<span class="clsUsername">
        	<a href="<?php echo $this->_tpl_vars['myobj']->profile_url; ?>
"><?php if ($this->_tpl_vars['CFG']['admin']['display_first_last_name']): ?><?php echo $this->_tpl_vars['myobj']->userDetails['first_name']; ?>
&nbsp;<?php echo $this->_tpl_vars['myobj']->userDetails['last_name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['CFG']['user']['user_name']; ?>
<?php endif; ?></a>
        </span> 
        <span> <?php echo $this->_tpl_vars['LANG']['myhome_subtitle_last_login']; ?>
:</span>
        <span> 
        <?php if ($this->_tpl_vars['myobj']->userDetails['last_logged'] != '0000-00-00 00:00:00'): ?>
           <?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->userDetails['last_logged'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_datetime']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_datetime'])); ?>

        <?php else: ?>
          <?php echo $this->_tpl_vars['LANG']['myhome_subtitle_first_login']; ?>

        <?php endif; ?>
        </span> 
      </p>
      <p class="clsUserDatacount"> <?php echo $this->_tpl_vars['header']->populateSiteUserStatistics(); ?>
 <?php unset($this->_sections['count']);
$this->_sections['count']['name'] = 'count';
$this->_sections['count']['loop'] = is_array($_loop=$this->_tpl_vars['userstatistics']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['count']['show'] = true;
$this->_sections['count']['max'] = $this->_sections['count']['loop'];
$this->_sections['count']['step'] = 1;
$this->_sections['count']['start'] = $this->_sections['count']['step'] > 0 ? 0 : $this->_sections['count']['loop']-1;
if ($this->_sections['count']['show']) {
    $this->_sections['count']['total'] = $this->_sections['count']['loop'];
    if ($this->_sections['count']['total'] == 0)
        $this->_sections['count']['show'] = false;
} else
    $this->_sections['count']['total'] = 0;
if ($this->_sections['count']['show']):

            for ($this->_sections['count']['index'] = $this->_sections['count']['start'], $this->_sections['count']['iteration'] = 1;
                 $this->_sections['count']['iteration'] <= $this->_sections['count']['total'];
                 $this->_sections['count']['index'] += $this->_sections['count']['step'], $this->_sections['count']['iteration']++):
$this->_sections['count']['rownum'] = $this->_sections['count']['iteration'];
$this->_sections['count']['index_prev'] = $this->_sections['count']['index'] - $this->_sections['count']['step'];
$this->_sections['count']['index_next'] = $this->_sections['count']['index'] + $this->_sections['count']['step'];
$this->_sections['count']['first']      = ($this->_sections['count']['iteration'] == 1);
$this->_sections['count']['last']       = ($this->_sections['count']['iteration'] == $this->_sections['count']['total']);
?>                
        <?php echo $this->_tpl_vars['userstatistics'][$this->_sections['count']['index']]['value']; ?>
<span> <?php echo $this->_tpl_vars['userstatistics'][$this->_sections['count']['index']]['lang']; ?>
, </span> <?php endfor; endif; ?> <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('myfriends','','','members'); ?>
"><?php echo $this->_tpl_vars['header']->getTotalFriendsNew(); ?>
</a> <span><?php echo $this->_tpl_vars['LANG']['myhome_total_friends']; ?>
,</span> <a href="<?php echo $this->_tpl_vars['profileCommentURL']; ?>
"><?php echo $this->_tpl_vars['header']->getTotalComments(); ?>
</a> <span><?php echo $this->_tpl_vars['LANG']['myhome_total_comments']; ?>
</span> </p>
    </div>
  </div>
  <div class="clsBreadcum">
    <p><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('myhome','','',''); ?>
"><?php echo $this->_tpl_vars['LANG']['common_home']; ?>
</a> <?php echo $this->_tpl_vars['LANG']['myhome_title_myhome']; ?>
</p>
  </div>
  <!-- Left side content of myHome -->
  <div id="selLeftContents" class="clsMyHomeLeftContent"> <?php if ($this->_tpl_vars['CFG']['admin']['show_recent_activities'] && $this->_tpl_vars['CFG']['admin']['display_myhome_recent_activities']): ?>
    <!--Recent Activities Starts here -->
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'myhomesidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div class="clsActivitiesSection clsMyHomeSideBar">
      <div class="clsActivitiesSectionLeft">
	  <div class="clsOverflow">
        <div class="clsFloatLeft">
          <p class="clsMyHomeBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['myhome_recent_activities_title']; ?>
</p>
		</div>  
          <div class="clsTabNavigation clsRecentActivities">
            <ul>
              <li id="selHeaderActivityFriends"><span><a href="javascript:void(0);" onclick="getMoreContent('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
myHome.php?ajax_page=true&amp;activity_type=friends', 'selActivityFriendsContent', 'selHeaderActivityFriends'); return false;"><?php echo $this->_tpl_vars['LANG']['myhome_recent_activities_friends']; ?>
</a></span></li>
              <li id="selHeaderActivityMy"><span><a href="javascript:void(0);" onclick="getMoreContent('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
myHome.php?ajax_page=true&amp;activity_type=my', 'selActivityMyContent', 'selHeaderActivityMy'); return false;"><?php echo $this->_tpl_vars['LANG']['myhome_recent_activities_my']; ?>
</a></span></li>
              <li id="selHeaderActivityAll"><span><a href="javascript:void(0);" onclick="getMoreContent('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
myHome.php?ajax_page=true&amp;activity_type=all', 'selActivityAllContent', 'selHeaderActivityAll'); return false;"><?php echo $this->_tpl_vars['LANG']['myhome_recent_activities_all']; ?>
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
          <div id="selActivityFriendsContent" class="clsRecentActivityContent clsMembersListActivity" style="display:none"> <?php if ($this->_tpl_vars['myobj']->userDetails['total_friends']): ?>
            <?php if ($this->_tpl_vars['CFG']['admin']['myhome']['recent_activity_default_content'] == 'Friends'): ?>
            <?php echo $this->_tpl_vars['myobj']->myHomeActivity(10); ?>

            <?php endif; ?>
            <?php else: ?>
			<div class="clsOverflow">
              <div class="clsNoRecordsFound"> <?php echo $this->_tpl_vars['LANG']['myhome_recent_activities_no_friends']; ?>
 </div>
			</div>  
            <?php endif; ?> </div>
          <div id="selActivityMyContent" class="clsRecentActivityContent clsMembersListActivity" style="display:none"> <?php if ($this->_tpl_vars['CFG']['admin']['myhome']['recent_activity_default_content'] == 'My'): ?>
            <?php echo $this->_tpl_vars['myobj']->myHomeActivity(10); ?>

            <?php endif; ?> </div>
          <div id="selActivityAllContent" class="clsRecentActivityContent clsMembersListActivity" style="display:none"> <?php if ($this->_tpl_vars['CFG']['admin']['myhome']['recent_activity_default_content'] == 'All'): ?>
            <?php echo $this->_tpl_vars['myobj']->myHomeActivity(10); ?>

            <?php endif; ?> </div>
      </div>
    </div>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'myhomesidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <!--Recent Activities Ends here -->
    <?php endif; ?>
    
        
    <?php if ($this->_tpl_vars['myobj']->CFG['admin']['myhome']['upcoming_birthdays']): ?>
        
 	<div class="ClsUpcomingBirthdaysCarouselContainer"> 
    	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'myhomedetails_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <div class="clsOverflow">
        <div class="clsMyHomeRecentVisitonsTitleLeft">
          <h3><?php echo $this->_tpl_vars['LANG']['myhome_upcoming_birthdays_title']; ?>
</h3>
        </div>
      </div>
      <div class="ClsUpcomingBirthdaysCarousel">
	  <?php if (isset ( $this->_tpl_vars['upcomingBirthdayList_arr']['row'] ) && ( $this->_tpl_vars['upcomingBirthdayList_arr']['row'] )): ?> 
        <ul id="carouselUpcomingBirthday" class="jcarousel-skin-tango">
          <?php $_from = $this->_tpl_vars['upcomingBirthdayList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['birthdayValue']):
?>
          <li> <div class="clsFloatLeft"> <a class="ClsImageContainer ClsImageBorder2 Cls45x45" href="<?php echo $this->_tpl_vars['birthdayValue']['friendProfileUrl']; ?>
"> <img  src="<?php echo $this->_tpl_vars['birthdayValue']['icon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['birthdayValue']['record']['friend_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
"  title="<?php echo $this->_tpl_vars['birthdayValue']['record']['friend_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['birthdayValue']['icon']['s_width'],$this->_tpl_vars['birthdayValue']['icon']['s_height']); ?>
 /> </a> </div>
		   
		   <div class="clsUpcomingBirthdaysContent">
            <p id="selMemberName" class="clsProfileThumbImg clsPaddingBottom5"><a href="<?php echo $this->_tpl_vars['birthdayValue']['friendProfileUrl']; ?>
" <?php echo $this->_tpl_vars['birthdayValue']['online']; ?>
><?php echo $this->_tpl_vars['birthdayValue']['display_name']; ?>
</a> </p>
                <?php if ($this->_tpl_vars['birthdayValue']['record']['dob_comp']): ?>
                <p><?php echo $this->_tpl_vars['birthdayValue']['record']['dob']; ?>
</p>
                <?php else: ?>
                <p><?php echo ((is_array($_tmp=$this->_tpl_vars['birthdayValue']['record']['dob'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date'])); ?>
</p>
                <?php endif; ?>
		    </div>		
          </li>
          <?php endforeach; endif; unset($_from); ?>
        </ul>
		<?php else: ?>
		 <div class="clsOverflow">
          <div class="clsNoListDatas"> <?php echo $this->_tpl_vars['LANG']['myhome_upcoming_birthdays_no_records']; ?>
 </div>
		 </div> 
		<?php endif; ?>
      </div>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'myhomedetails_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
    <?php echo '
    <script type="text/javascript">
                // <![CDATA[
                  jQuery(document).ready(function() {
					    jQuery(\'#carouselUpcomingBirthday\').jcarousel({
					        // Configuration goes here
					    });
					});
                // ]]>
                </script>
    '; ?>
    
    
    <?php endif; ?> </div>
  <!-- End of Left side content of myHome -->
  <!-- Right side content of myHome -->
  <div id="selRightContents" class="clsMyHomeRightContent">   
    <?php if ($this->_tpl_vars['CFG']['admin']['myhome']['show_profile_visitors']): ?>
    <div class="ClsRecentVisitorCarouselContainer"> <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'myhomedetails_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <div class="clsOverflow">
        <div class="clsMyHomeRecentVisitonsTitleLeft">
          <h3><?php echo $this->_tpl_vars['LANG']['myhome_profile_visitors_title']; ?>
</h3>
        </div>
      </div>
      <div class="ClsRecentVisitorCarousel">
	  <?php if (isset ( $this->_tpl_vars['displayMyProfileVisitors_arr']['row'] ) && ( $this->_tpl_vars['displayMyProfileVisitors_arr']['row'] )): ?>
        <ul id="carouselRecentVisitors" class="jcarousel-skin-tango">
          <?php $_from = $this->_tpl_vars['displayMyProfileVisitors_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pKey'] => $this->_tpl_vars['profileVisitors']):
?>
          <li> <a class="ClsImageContainer Cls66x66 ClsImageBorder1 ClsImageMargin" href="<?php echo $this->_tpl_vars['profileVisitors']['memberProfileUrl']; ?>
" id="<?php echo $this->_tpl_vars['profileVisitors']['anchor_id']; ?>
"> <img src="<?php echo $this->_tpl_vars['profileVisitors']['icon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['profileVisitors']['visitor_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 7) : smarty_modifier_truncate($_tmp, 7)); ?>
" title="<?php echo $this->_tpl_vars['profileVisitors']['visitor_name']; ?>
" id="<?php echo $this->_tpl_vars['profileVisitors']['image_id']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_small_width'],$this->_config[0]['vars']['image_small_height'],$this->_tpl_vars['profileVisitors']['icon']['s_width'],$this->_tpl_vars['profileVisitors']['icon']['s_height']); ?>
/> </a>
            <p class="ClsMembersName"><a href="<?php echo $this->_tpl_vars['profileVisitors']['memberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['profileVisitors']['visitor_name']; ?>
</a></p>
          </li>
          <?php endforeach; endif; unset($_from); ?>
        </ul>
         <?php else: ?>
		  <div class="clsNoRecordPadding">
          	<div class="clsNoListDatas"> <?php echo $this->_tpl_vars['LANG']['myhome_profile_visitors_no_records']; ?>
 </div>
		 </div>	
		<?php endif; ?>  
      </div>
      <?php if (! isset ( $this->_tpl_vars['displayMyProfileVisitors_arr']['row'] ) && ! ( $this->_tpl_vars['displayMyProfileVisitors_arr']['row'] )): ?>
          <div class="clsMyHomeRecentVisitonsTitleRight clsOverflow">
            <p><span><?php echo $this->_tpl_vars['LANG']['common_total']; ?>
:&nbsp;<?php echo $this->_tpl_vars['myobj']->getProfileViewCounts(); ?>
</span></p>
            <p><?php echo $this->_tpl_vars['LANG']['common_since']; ?>
&nbsp;<?php echo $this->_tpl_vars['myobj']->userDetails['profile_since_date']; ?>
:&nbsp;<?php echo $this->_tpl_vars['myobj']->userDetails['profile_hits_count_by']; ?>
</p>
          </div>
      <?php endif; ?>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'myhomedetails_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
    <?php echo '
    <script type="text/javascript">
                // <![CDATA[
                  jQuery(document).ready(function() {
					    jQuery(\'#carouselRecentVisitors\').jcarousel({
					        // Configuration goes here
					    });
					});
                // ]]>
                </script>
    '; ?>

    <?php endif; ?>
    
    
    <?php if ($this->_tpl_vars['myobj']->CFG['admin']['myhome']['show_my_friends']): ?>
    
        <?php $this->assign('myhome_total_friends_display', '14'); ?>    
    <?php if ($this->_tpl_vars['myobj']->userDetails['total_friends']): ?>
        <?php echo $this->_tpl_vars['myobj']->displayMyFriends($this->_tpl_vars['myobj']->userDetails['total_friends'],0,$this->_tpl_vars['myhome_total_friends_display']); ?>

    <?php endif; ?>
        
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'myhomedetails_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div id="selMyFriendsContent" class="">
      	<div class="clsMyHomeRecentVisitonsTitleLeft">
        	<h3><?php echo $this->_tpl_vars['LANG']['myhome_my_friends_title']; ?>
</h3>
      	</div>
      	<div class="clsMyHomeFriendListing">
        	<ul class="clsMyHomeFriends clsOverflow">
        		<?php if ($this->_tpl_vars['myobj']->userDetails['total_friends']): ?>        
              		
                <?php $_from = $this->_tpl_vars['displayMyFriends_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['myFriendsValue']):
?>
                <li id="selPhotoGallery"> <a class="ClsImageContainer ClsImageBorder2 Cls32x32" href="<?php echo $this->_tpl_vars['myFriendsValue']['memberProfileUrl']; ?>
" id="<?php echo $this->_tpl_vars['myFriendsValue']['anchor_id']; ?>
"> <img src="<?php echo $this->_tpl_vars['myFriendsValue']['icon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['myFriendsValue']['friendName'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 3) : smarty_modifier_truncate($_tmp, 3)); ?>
" title="<?php echo $this->_tpl_vars['myFriendsValue']['friendName']; ?>
" id="<?php echo $this->_tpl_vars['myFriendsValue']['image_id']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(30,30,$this->_tpl_vars['myFriendsValue']['icon']['s_width'],$this->_tpl_vars['myFriendsValue']['icon']['s_height']); ?>
  /> </a>
                <!--  <p id="selMemberName" class="clsProfileThumbImg"><a class="clsFriendsName" href="<?php echo $this->_tpl_vars['myFriendsValue']['memberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['myFriendsValue']['friendName']; ?>
</a></p>-->
                </li>
                <?php endforeach; else: ?>
                <div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['myhome_my_friends_no_records']; ?>
</div>
                <?php endif; unset($_from); ?>
            	
                <?php else: ?>
                <div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['myhome_my_friends_no_records']; ?>
</div>
            	<?php endif; ?>
        	</ul>
        	
            <?php if ($this->_tpl_vars['myobj']->userDetails['total_friends'] > $this->_tpl_vars['myhome_total_friends_display']): ?>
        	<p class="clsViewAllFriends"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('myfriends','','','members'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['myhome_link_friends_view_all']; ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_link_friends_view_all']; ?>
</a></p>
        	<?php endif; ?>
		</div>
    </div>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'myhomedetails_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
    
    <?php if ($this->_tpl_vars['CFG']['admin']['myhome']['show_friend_suggestions']): ?>
    <div class="ClsFriendsSuggestionCarouselContainer"> <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'myhomedetails_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <div class="clsOverflow">
        <div class="clsMyHomeRecentVisitonsTitleLeft">
          <h3><?php echo $this->_tpl_vars['LANG']['myhome_friends_suggestion_title']; ?>
</h3>
        </div>
      </div>
      <div class="ClsFriendsSuggestionCarousel">
	  <?php if (isset ( $this->_tpl_vars['populateFriendSuggestions_arr']['row'] ) && ( $this->_tpl_vars['populateFriendSuggestions_arr']['row'] )): ?>
        <ul id="carouselFriendSuggestions" class="jcarousel-skin-tango">
          <?php $_from = $this->_tpl_vars['populateFriendSuggestions_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['friendSuggestions']):
?>
          <li id="suggestion_<?php echo $this->_tpl_vars['friendSuggestions']['friend_id']; ?>
">
             <div> <a class="ClsImageContainer Cls66x66 ClsImageBorder1 ClsImageMargin" href="<?php echo $this->_tpl_vars['friendSuggestions']['memberProfileUrl']; ?>
" id="<?php echo $this->_tpl_vars['friendSuggestions']['anchor_id']; ?>
"> 
			   <img src="<?php echo $this->_tpl_vars['friendSuggestions']['icon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['friendSuggestions']['user_friend_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 7) : smarty_modifier_truncate($_tmp, 7)); ?>
" title="<?php echo $this->_tpl_vars['friendSuggestions']['user_friend_name']; ?>
" id="<?php echo $this->_tpl_vars['friendSuggestions']['image_id']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_small_width'],$this->_config[0]['vars']['image_small_height'],$this->_tpl_vars['friendSuggestions']['icon']['s_width'],$this->_tpl_vars['friendSuggestions']['icon']['s_height']); ?>
/> 
			  </a>
              <p id="selMemberName" class="ClsSuggestionName clsPaddingBottom5"><a href="<?php echo $this->_tpl_vars['friendSuggestions']['memberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['friendSuggestions']['user_friend_name']; ?>
</a></p>
              <p class="ClsFriendsSuggestion"><a href="<?php echo $this->_tpl_vars['friendSuggestions']['friend_add_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_friends_suggestion_add_friend']; ?>
</a></p>
                         </div>
          </li>
          <?php endforeach; endif; unset($_from); ?>
        </ul>
		<?php else: ?>
          <div class="clsNoListDatas"><?php echo $this->_tpl_vars['LANG']['myhome_friends_suggestion_no_records']; ?>
</div>
		<?php endif; ?>		
      </div>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'myhomedetails_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
    <?php echo '
    <script type="text/javascript">
                // <![CDATA[
                  jQuery(document).ready(function() {
					    jQuery(\'#carouselFriendSuggestions\').jcarousel({
					        // Configuration goes here
					    });
					});
                // ]]>
                </script>
    '; ?>

    <?php endif; ?>
    <?php if ($this->_tpl_vars['CFG']['admin']['myhome']['show_announcement']): ?>
    <?php if ($this->_tpl_vars['populateAnnouncement_arr']['row']): ?>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'myhomesidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div class="clsMyHomeSideBar">
      <div>
        <p class="clsMyHomeBarLeftTitle"><?php echo $this->_tpl_vars['LANG']['myhome_announcement_title']; ?>
</p>
      </div>
      <div class="clsSideBarRight">
        <div class="clsSideBarContent">
          <div style="height:<?php echo $this->_tpl_vars['myobj']->announcment_height; ?>
px" onmouseover='stopScroll=1' onmouseout='stopScroll=0;scrollMe()' id="announcement_content"> <?php $_from = $this->_tpl_vars['populateAnnouncement_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['announcementKey'] => $this->_tpl_vars['announcementValue']):
?>
            <div id="announcment_<?php echo $this->_tpl_vars['announcementKey']; ?>
"><?php echo $this->_tpl_vars['announcementValue']['description']; ?>
</div>
            <br />
            <br />
            <hr style="background-color:#666666;border:1px solid #666666" size="2" />
            <br />
            <br />
            <?php endforeach; endif; unset($_from); ?> </div>
          <?php if ($this->_tpl_vars['populateAnnouncement_arr']['row']): ?>
          <div class="clsAnnouncementButtonContainer" id="announcement_controls" style="display:none"> <a class="clsAnnouncementPrevious" href="javascript:void(0);" onclick="stopScroll=0;scrollBack();" title="<?php echo $this->_tpl_vars['LANG']['myhome_announcement_prev']; ?>
">&nbsp;</a> <a class="clsAnnouncementPlay" href="javascript:void(0);" onclick="stopScroll=0;scrollMe();" title="<?php echo $this->_tpl_vars['LANG']['myhome_announcement_play']; ?>
">&nbsp;</a> <a class="clsAnnouncementStop" href="javascript:void(0);" onclick="stopScroll=1;" title="<?php echo $this->_tpl_vars['LANG']['myhome_announcement_stop']; ?>
">&nbsp;</a> </div>
          <?php endif; ?> </div>
        <!-- End of div for rounded corners -->
      </div>
    </div>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'myhomesidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php else: ?>
    <div class="clsMyHomeSideBanner">
	</div>
    <?php endif; ?>
    <?php endif; ?> </div>
  <!-- End of Right side content of myHome -->
</div>