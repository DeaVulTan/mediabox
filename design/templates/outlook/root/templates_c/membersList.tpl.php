<?php /* Smarty version 2.6.18, created on 2011-10-18 14:16:08
         compiled from membersList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'membersList.tpl', 44, false),array('modifier', 'truncate', 'membersList.tpl', 113, false),array('modifier', 'capitalize', 'membersList.tpl', 129, false),array('modifier', 'date_format', 'membersList.tpl', 136, false),array('modifier', 'count', 'membersList.tpl', 182, false),array('modifier', 'cat', 'membersList.tpl', 188, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selMembersBrowse" class="clsListTable">
  <div class="clsOverflow">
    <div class="clsListHeadingLeft">
      <h2><span><?php echo $this->_tpl_vars['myobj']->form_list_members['page_title']; ?>
</span></h2>
    </div>
    <div class="clsListHeadingRight">
      <form id="members_nav" action="<?php echo $this->_tpl_vars['myobj']->getUrl('memberslist','',''); ?>
" method="get" onSubmit="return false">
        <select id="browse" name="browse" onchange="membersNav()">	
          <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['populateMoreBrowseMembersLinks_arr'],$this->_tpl_vars['myobj']->getFormField('browse')); ?>
		
        </select>
      </form>
    </div>
  </div>
  <?php echo '
  <script type="text/javascript">
	//new Autocompleter.SelectBox(\'browse\', {submit: \'members_nav\'});
	function membersNav()
		{
			memberUrl = '; ?>
'<?php echo $this->_tpl_vars['myobj']->getUrl('memberslist','',''); ?>
';<?php echo '
			memberUrl = memberUrl+\'?browse=\'+$(\'browse\').value;
			window.location = memberUrl;
		}
	</script>
  '; ?>

  
  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <div id="selLeftNavigation" class="clsMemberListMain"> <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_list_members')): ?>
    <?php if (isMember ( )): ?>
    <div class="clsPaddingLeftRight">
      <p class="clsBrowseMemberLink"> <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('membersbrowse'); ?>
" id="selMemberBrowseLinkID"><?php echo $this->_tpl_vars['LANG']['common_members_list_browse_members']; ?>
</a> <a class="clsBlockUser" href="<?php echo $this->_tpl_vars['myobj']->getUrl('memberblock','','','members'); ?>
" id="selMemberBlockLinkId"><?php echo $this->_tpl_vars['LANG']['members_list_blocked_members']; ?>
</a> </p>
    </div>
    <?php endif; ?>
    <div id="membersThumsDetailsLinks" class="clsMembersRight clsShowHideFilter"> <a href="javascript:void(0);" id="show_link" class="clsShowFilterSearch"  onclick="divShowHide('advanced_search', 'show_link', 'hide_link');"><span><?php echo $this->_tpl_vars['LANG']['members_show_adv_filters']; ?>
</span></a> <a href="javascript:void(0);" id="hide_link" style="display:none" class="clsHideFilterSearch"  onclick="divShowHide('advanced_search', 'show_link', 'hide_link');"> <span><?php echo $this->_tpl_vars['LANG']['members_hide_adv_filters']; ?>
</span></a> </div>
    <div  id="advanced_search"  style="display:none;"  class="clsFriendSearchTable">             <form id="membersAdvancedFilters" name="membersAdvancedFilters" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
">
        <div class="clsOverflow">
          <div class="clsAdvancedSearchBg">
            <table class="clsAdvancedFilterTable">
              <tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('uname'); ?>
"><input type="text" class="clsTextBox selAutoText" name="uname" id="uname" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php if ($this->_tpl_vars['myobj']->getFormField('tags')): ?><?php echo $this->_tpl_vars['myobj']->getFormField('tags'); ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('uname'); ?>
<?php endif; ?>" title="<?php echo $this->_tpl_vars['LANG']['search_uname_tag']; ?>
" />
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('sex'); ?>
"><select id="sex" name="sex" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                    
					<?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->gender_arr,$this->_tpl_vars['myobj']->getFormField('sex')); ?>

				
                  </select>
                </td>
              </tr>
              <tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('ucity'); ?>
"><input type="text" class="clsTextBox selAutoText" name="ucity" id="ucity" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('ucity'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['search_ucity']; ?>
" />
                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('country'); ?>
"><select name="country" id="country" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                    
					<?php echo $this->_tpl_vars['myobj']->populateUserCountriesList($this->_tpl_vars['myobj']->getFormField('country')); ?>

				
                  </select>
                </td>
              </tr>
              <tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('uhometown'); ?>
" colspan="2"><input type="text" class="clsTextBox selAutoText" name="uhometown" id="uhometown" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('uhometown'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['search_uhometown']; ?>
" />
                </td>
              </tr>
            </table>
          </div>
          <div class="clsAdvancedSearchBtn">
            <table>
              <tr>
                <td colspan="2" align="right" valign="middle"><div class="clsListSubmitLeft">
                    <div class="clsListSubmitRight">
                      <input type="submit" name="avd_search" id="avd_search" value="Search" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/>
                    </div>
                  </div></td>
              </tr>
              <tr>
                <td><div class="clsListCancelLeft">
                    <div class="clsListCancelRight">
                      <input type="submit" name="search_reset" id="search_reset" value="<?php echo $this->_tpl_vars['LANG']['members_list_browse_reset']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                    </div>
                  </div></td>
              </tr>
            </table>
          </div>
        </div>
      </form>
       </div>
    <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
     <div class="clsOverflow clsPaddingLeftRight">       <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
	   <?php if ($this->_tpl_vars['smarty_paging_list']): ?>
     	 <div class="clsTopPagination"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>  </div>
	   <?php endif; ?>	 
      <?php endif; ?> </div>
    <div id="selViewAllMembers" class="clsMemberListTable clsMemberListMainTable">
      <table summary="<?php echo $this->_tpl_vars['LANG']['member_list_tbl_summary']; ?>
">
        <?php $_from = $this->_tpl_vars['myobj']->form_list_members['display_members']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
        <?php if ($this->_tpl_vars['value']['open_tr']): ?>
        <tr> <?php endif; ?>
          <td id="selPhotoGallery_<?php echo $this->_tpl_vars['inc']; ?>
">
		   <ul class="clsMembersPhotoListDisplay">
              <li id="memberlist_videoli_<?php echo $this->_tpl_vars['inc']; ?>
" onmouseover="showVideoDetail(this)" onmouseout="hideVideoDetail(this)">
                <div class="clsMemberImageContainer" id="memberlist_thumb_<?php echo $this->_tpl_vars['inc']; ?>
" >
                    <div class="clsThumbImageLink" id="selMemberName">
                      <div onclick="Redirect2URL('<?php echo $this->_tpl_vars['value']['memberProfileUrl']; ?>
')" >
				       <a class="ClsImageContainer ClsImageBorder2 Cls90x90" href="<?php echo $this->_tpl_vars['value']['memberProfileUrl']; ?>
" title="<?php echo $this->_tpl_vars['value']['record']['user_name']; ?>
"> 
					     <img src="<?php echo $this->_tpl_vars['value']['profileIcon']['t_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['value']['record']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 9) : smarty_modifier_truncate($_tmp, 9)); ?>
" title="<?php echo $this->_tpl_vars['value']['record']['user_name']; ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['value']['memberProfileUrl']; ?>
')"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_thumb_width'],$this->_config[0]['vars']['image_thumb_height'],$this->_tpl_vars['value']['profileIcon']['t_width'],$this->_tpl_vars['value']['profileIcon']['t_height']); ?>
 onclick="Redirect2URL('<?php echo $this->_tpl_vars['value']['memberProfileUrl']; ?>
')"/></a> </div>
                      <?php echo $this->_tpl_vars['myobj']->membersRelRayzz($this->_tpl_vars['value']['record']); ?>
 </div>
                    <p class="clsPaddingTop9"> <a href="<?php echo $this->_tpl_vars['value']['memberProfileUrl']; ?>
" <?php echo $this->_tpl_vars['value']['online']; ?>
><?php echo $this->_tpl_vars['value']['record']['user_name']; ?>
</a> <?php echo $this->_tpl_vars['value']['userLink']; ?>
 </p>
                    <a href="#" class="" id="memberlist_info_<?php echo $this->_tpl_vars['inc']; ?>
"></a> 
                </div>
                <?php if (isMember ( )): ?>
                <?php if ($this->_tpl_vars['CFG']['admin']['members_listing']['online_status']): ?>
                <p class="clsOnline"><a class="<?php echo $this->_tpl_vars['value']['onlineStatusClass']; ?>
" title="<?php echo $this->_tpl_vars['value']['currentStatus']; ?>
"><?php echo $this->_tpl_vars['value']['currentStatus']; ?>
</a></p>
                <?php endif; ?>              
                <?php endif; ?>
                
                                <div class="clsPopInfoWidth clsPopInfo clsDisplayNone  <?php if ($this->_tpl_vars['value']['end_tr']): ?> clsPopInfoRight <?php endif; ?>" id="memberlist_selVideoDetails_<?php echo $this->_tpl_vars['inc']; ?>
">
                  <div class="clsPopUpDivContainer <?php if ($this->_tpl_vars['value']['end_tr']): ?> clsPopUpDivLastContainer <?php endif; ?>"> <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popinfo_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <div class="clsPopUpPaddingContent">
                      <p class="clsPopUpInnerContainer"><a href="<?php echo $this->_tpl_vars['value']['memberProfileUrl']; ?>
" <?php echo $this->_tpl_vars['value']['online']; ?>
><?php echo $this->_tpl_vars['value']['record']['user_name']; ?>
</a> <?php echo $this->_tpl_vars['value']['userLink']; ?>
 | <strong> <span><?php echo $this->_tpl_vars['value']['record']['age']; ?>
</span>, <span><?php echo ((is_array($_tmp=$this->_tpl_vars['value']['record']['sex'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</span>,</strong> <span><?php echo $this->_tpl_vars['value']['country']; ?>
</span></p>
					  <div class="clsOverflow">
                     	 <div class="clsPopUpInnerContainer clsPopUpContentBtm"> 
                      		<?php if ($this->_tpl_vars['myobj']->listDetails): ?>
                        		<?php echo $this->_tpl_vars['LANG']['profile_list_joined']; ?>
:&nbsp;
                                <span>
                                    <?php if ($this->_tpl_vars['value']['record']['doj'] != '0000-00-00 00:00:00'): ?>
                                        <?php echo ((is_array($_tmp=$this->_tpl_vars['value']['record']['doj'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>

                                    <?php endif; ?>
                                </span>
                                &nbsp; | &nbsp;
                        	<?php endif; ?>                        		<?php echo $this->_tpl_vars['LANG']['members_list_member_last_login']; ?>
:&nbsp;
                                <span>
                                    <?php if ($this->_tpl_vars['value']['last_logged'] != '0000-00-00 00:00:00'): ?>
                                        <?php echo ((is_array($_tmp=$this->_tpl_vars['value']['last_logged'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>

                                    <?php else: ?>
                                        <?php echo $this->_tpl_vars['LANG']['members_browse_member_first_login']; ?>

                                    <?php endif; ?> 
                                </span> 
     					</div>
						 <div id="selMemDetails" class="clsMembersList clsPopUpContentRight"> 
                            <?php if (isMember ( )): ?>
                              <?php if ($this->_tpl_vars['CFG']['user']['user_id'] != $this->_tpl_vars['value']['record']['user_id']): ?>
                                  <p id="selSendMsg"><a class="clsSendMessage clsPhotoVideoEditLinks" href="<?php echo $this->_tpl_vars['value']['mailComposeUrl']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['member_list_send_message']; ?>
"><?php echo $this->_tpl_vars['LANG']['member_list_send_message']; ?>
</a></p>
                                  <?php if ($this->_tpl_vars['value']['friend'] == 'yes'): ?>
                                  <p id="selAlReadyFriend"><a class="clsAlreadyFriend" title="<?php echo $this->_tpl_vars['LANG']['members_list_friend']; ?>
" class="clsPhotoVideoEditLinks"><?php echo $this->_tpl_vars['LANG']['members_list_friend']; ?>
</a></p>
                                  <?php else: ?>
                                  <p id="selAddFriend"><a class="clsAddToFriends clsPhotoVideoEditLinks" href="<?php echo $this->_tpl_vars['value']['friendAddUrl']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['member_list_add_friend']; ?>
"><?php echo $this->_tpl_vars['LANG']['member_list_add_friend']; ?>
</a></p>
                                  <?php endif; ?>                                     
                              <?php endif; ?>          
                              
                              <?php else: ?>
                              <p id="selSendMsg"><a class="clsSendMessage clsPhotoVideoEditLinks" href="<?php echo $this->_tpl_vars['value']['mailComposeUrl']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['member_list_send_message']; ?>
"><?php echo $this->_tpl_vars['LANG']['member_list_send_message']; ?>
</a></p>
                              <p id="selAddFriend"><a class="clsAddToFriends clsPhotoVideoEditLinks" href="<?php echo $this->_tpl_vars['value']['friendAddUrl']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['member_list_add_friend']; ?>
"><?php echo $this->_tpl_vars['LANG']['member_list_add_friend']; ?>
</a></p>
                              <?php endif; ?> 
                          </div>
					   </div>	  
                    </div>
                    <div class="clsPopInfo-bottom">
                      <div class="clsPopUpPaddingContentBtm clsOverflow">
                        <div class="clsPopUpContentLeft">
                         	<?php if ($this->_tpl_vars['myobj']->listDetails): ?>
                                                                        <?php $this->assign('break_count', 0); ?>
                                    <ul class="clsMemberPopUpBox">
                                        <?php if ($this->_tpl_vars['myobj']->friendsCount): ?>
                                         <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
										   <li>
                                            <?php echo $this->_tpl_vars['LANG']['profile_list_friends']; ?>
:
                                            <?php if ($this->_tpl_vars['value']['record']['total_friends'] > 0): ?> <a href="<?php echo $this->_tpl_vars['value']['viewfriendsUrl']; ?>
" title="<?php echo $this->_tpl_vars['value']['friend_icon_title']; ?>
"><?php echo $this->_tpl_vars['value']['record']['total_friends']; ?>
</a> <?php else: ?> <span><?php echo $this->_tpl_vars['value']['record']['total_friends']; ?>
</span> <?php endif; ?>  </li>
										<?php endif; ?>                                                
                                        		
                                                <?php $this->assign('totcnt', count($this->_tpl_vars['CFG']['site']['modules_arr'])); ?>
                                                <?php $this->assign('totcnt', $this->_tpl_vars['totcnt']-1); ?>
                                               
                                            <?php $_from = $this->_tpl_vars['CFG']['site']['modules_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['module_value']):
?>
                                                  <?php if (chkAllowedModule ( array ( $this->_tpl_vars['module_value'] ) )): ?>
                                                      <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
                                                      <?php $this->assign('total_stats', ((is_array($_tmp=$this->_tpl_vars['module_value'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_icon_title') : smarty_modifier_cat($_tmp, '_icon_title'))); ?>
                                                      <?php $this->assign('icon_url', ((is_array($_tmp=$this->_tpl_vars['module_value'])) ? $this->_run_mod_handler('cat', true, $_tmp, 'ListUrl') : smarty_modifier_cat($_tmp, 'ListUrl'))); ?>
                                                   		<?php $this->assign('total_stats_value', ((is_array($_tmp=((is_array($_tmp='total_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['module_value']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['module_value'])))) ? $this->_run_mod_handler('cat', true, $_tmp, 's') : smarty_modifier_cat($_tmp, 's'))); ?>						   
                                                      <?php $this->assign('image1_exists', ((is_array($_tmp=$this->_tpl_vars['module_value'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_image1_exists') : smarty_modifier_cat($_tmp, '_image1_exists'))); ?>
                                                      <?php $this->assign('image2_exists', ((is_array($_tmp=$this->_tpl_vars['module_value'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_image2_exists') : smarty_modifier_cat($_tmp, '_image2_exists'))); ?>
																	<li class="clsListValues"><?php echo $this->_tpl_vars['value'][$this->_tpl_vars['total_stats_value']]; ?>
</li>
                                                      <?php if (( $this->_tpl_vars['break_count'] > 3 && $this->_tpl_vars['totcnt'] != $this->_tpl_vars['inc'] )): ?>
															</ul>
                                                            <ul class="clsMemberPopUpBox">
                                                            <?php $this->assign('break_count', 0); ?>
                                                      <?php endif; ?>
                                                          
                                                    <?php endif; ?>
                                            <?php endforeach; endif; unset($_from); ?>
                                     </ul>

                                    
                                                                
                            	<?php endif; ?>
                               
                            
                                <?php if ($this->_tpl_vars['myobj']->profileHits): ?>
                                |
                                <?php echo $this->_tpl_vars['LANG']['profile_list_profile_hits']; ?>
:&nbsp;<span><?php echo $this->_tpl_vars['value']['record']['profile_hits']; ?>
</span>
                              <?php endif; ?>
                          </div>                        
                      </div>
                    </div>
                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popinfo_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
                </div>
                 </li>
            </ul></td>
          <?php if ($this->_tpl_vars['value']['end_tr']): ?> </tr>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
        <?php if ($this->_tpl_vars['myobj']->last_tr_close): ?>
        <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['myobj']->user_per_row) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
        <td>&nbsp;</td>
          <?php endfor; endif; ?> </tr>
        <?php endif; ?>
      </table>
    </div>
    <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>
	
	<?php if ($this->_tpl_vars['smarty_paging_list']): ?>
	  <div class="clsPaddingRightBottom">
	    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	  </div>	
	 <?php endif; ?>
    <?php endif; ?>    
    <?php if ($this->_tpl_vars['myobj']->showRelatedTags): ?>
    <div id="selRelatedTags"> <span><?php echo $this->_tpl_vars['LANG']['members_list_related_tags']; ?>
:&nbsp;</span> <?php $_from = $this->_tpl_vars['myobj']->form_list_members['related_tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?> <span><a href="<?php echo $this->_tpl_vars['myobj']->tagListUrl; ?>
?tags=<?php echo $this->_tpl_vars['value']['tags']; ?>
" ><?php echo $this->_tpl_vars['value']['tags']; ?>
</a></span> <?php endforeach; endif; unset($_from); ?> </div>
    <?php endif; ?>
    <?php else: ?>
    <div id="selMsgError"><?php echo $this->_tpl_vars['LANG']['msg_no_records']; ?>
</div>
    <?php endif; ?>
    <?php endif; ?> </div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
