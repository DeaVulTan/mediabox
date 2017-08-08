<?php /* Smarty version 2.6.18, created on 2011-10-18 14:16:10
         compiled from viewFriends.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'viewFriends.tpl', 47, false),array('modifier', 'truncate', 'viewFriends.tpl', 154, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selMembersBrowse" class="viewFriends">
  <div id="selLeftNavigation">

<?php if (! $this->_tpl_vars['myobj']->isShowPageBlock('form_list_top_friends')): ?>
    <?php if ($this->_tpl_vars['myobj']->isCurrentUser()): ?>
          <?php if ($this->_tpl_vars['myobj']->is_myFriendsPage): ?>
        <div class="clsOverflow"><div class="clsVideoListHeading"><h2><span><?php echo $this->_tpl_vars['myobj']->page_title; ?>
</span></h2></div><div class="clsVideoListHeadingRight clsVideoListHeadingRightLink"><h2><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('membersinvite','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['viewfriends_title_invite']; ?>
</a></h2></div></div>
          <?php else: ?>
          <div class="clsPageHeading"><h2><a href="<?php echo $this->_tpl_vars['myobj']->profile_url; ?>
"><?php echo $this->_tpl_vars['myobj']->page_title; ?>
</a>&nbsp;<?php echo $this->_tpl_vars['LANG']['viewfriends_friends']; ?>
</h2></div>
          <?php endif; ?>

    <?php else: ?>
        <?php if ($this->_tpl_vars['myobj']->otherUser): ?>
            <div class="clsPageHeading"><h2><a href="<?php echo $this->_tpl_vars['myobj']->profile_url; ?>
"><?php echo $this->_tpl_vars['myobj']->page_title; ?>
</a>&nbsp;<?php echo $this->_tpl_vars['LANG']['viewfriends_friends']; ?>
</h2></div>
        <?php else: ?>
            <div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['myobj']->page_title; ?>
</h2></div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_info')): ?>
    <div id="selMsgAlert">
      <p><?php echo $this->_tpl_vars['myobj']->LANG['msg_no_friends']; ?>
</p>
        <?php if ($this->_tpl_vars['myobj']->isCurrentUser()): ?>
           <p class="clsMsgAdditionalText"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('membersinvite','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['viewfriends_link_add_friends_start']; ?>
</a>&nbsp;<?php echo $this->_tpl_vars['LANG']['viewfriends_link_add_friends_end']; ?>
</p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_form_error')): ?>
    <div id="selMsgAlert">
      <p><?php echo $this->_tpl_vars['LANG']['msg_invalid_username']; ?>
</p>
        <?php if ($this->_tpl_vars['myobj']->isCurrentUser()): ?>
              <p><?php echo $this->_tpl_vars['LANG']['viewfriends_link_add_friends_start']; ?>
&nbsp;<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('membersinvite','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['viewfriends_link_add_friends_text']; ?>
</a>&nbsp;<?php echo $this->_tpl_vars['LANG']['viewfriends_link_add_friends_end']; ?>
</p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_search_friend')): ?>
          <div id="selFriendSearch" class="clsListTable clsFriendSearchTable">
        <form name="formFriendSearch" id="formFriendSearch" method="post" action="<?php echo $this->_tpl_vars['myobj']->form_search_friend_arr['form_action']; ?>
">
          <table summary="<?php echo $this->_tpl_vars['LANG']['myfriends_search_table']; ?>
">
            <tr>
              <td><label for="uname"><?php echo $this->_tpl_vars['LANG']['common_username']; ?>
</label><div class="clsMarginTop5"><input class="clsFriendsTextBox" type="text" name="uname" id="uname" value="<?php echo $this->_tpl_vars['myobj']->getFormField('uname'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['username']['max']; ?>
"/></div></td>
              <td><label for="email"><?php echo $this->_tpl_vars['LANG']['myfriends_search_email']; ?>
</label><div class="clsMarginTop5"><input class="clsFriendsTextBox" type="text" name="email" id="email" value="<?php echo $this->_tpl_vars['myobj']->getFormField('email'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></div></td>
              <td><label for="tagz"><?php echo $this->_tpl_vars['LANG']['myfriends_search_tags']; ?>
</label><div class="clsMarginTop5"><input class="clsFriendsTextBox" type="text" name="tagz" id="tagz" value="<?php echo $this->_tpl_vars['myobj']->getFormField('tagz'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></div></td>
              <td class=""><div class="clsListSubmitLeft clsMarginTop14"><div class="clsListSubmitRight"><input type="submit" value="<?php echo $this->_tpl_vars['LANG']['common_search']; ?>
" name="friendSearch" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></div></div></td>
            </tr>
          </table>
		  <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_search_friend_arr['hidden_arr']); ?>

        </form>
      </div>
        <?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="selMembersBrowse viewFriends">
  <div class="selLeftNavigation">
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
      <p id="msgConfirmText"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
			<input type="submit" class="clsSubmitButton" name="yes" id="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
            &nbsp;
            <input type="button" class="clsCancelButton" name="no" id="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks()" />
            <input type="hidden" name="act" id="act" />
            <input type="hidden" name="friendship_id" id="friendship_id" />
      </form>
    </div>
  </div>
</div>

<div class="selMembersBrowse viewFriends">
  <div class="selLeftNavigation">
    <div id="selMsgConfirmDelete" class="clsPopupConfirmation" style="display:none;">
      <p id="msgConfirmDeleteText"></p>
      	<form name="msgConfirmDeleteform" id="msgConfirmDeleteform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
        	<input type="submit" class="clsSubmitButton" name="yes" id="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
            &nbsp;
            <input type="button" class="clsCancelButton" name="no" id="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks()" />
            <input type="hidden" name="act" id="act" />
            <input type="hidden" name="friendshipId" id="friendshipId" />
            <input type="hidden" name="friendship_id" id="friendship_id" />
      </form>
    </div>
  </div>
</div>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_list_top_friends')): ?>
	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['myfriends_manage_top_friends']; ?>
</h2></div>
        <div id="selMsgSuccess" style="display:none;">
            <p id="selMsgSuccessText"></p>
        </div>
    <?php if ($this->_tpl_vars['displayTopFriends_arr']['row']): ?>
    	<div id="selMsgAlert"><p><?php echo $this->_tpl_vars['LANG']['myfriends_note']; ?>
:&nbsp;<?php echo $this->_tpl_vars['LANG']['myfriends_top_friends_info1']; ?>
<br/><?php echo $this->_tpl_vars['LANG']['myfriends_top_friends_info2']; ?>
</p></div>
        <div class="clsImageMain">
        <?php $_from = $this->_tpl_vars['displayTopFriends_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dtfValue']):
?>
            <div class="imageBox" id="<?php echo $this->_tpl_vars['dtfValue']['record']['user_id']; ?>
">
                <div class="imageBox_theImage" style="background-image:url('<?php echo $this->_tpl_vars['dtfValue']['icon']['t_url']; ?>
')"></div>
                <div class="imageBox_label clsImageBox clsOverflow">
                	<span class="clsImageBoxName"><?php echo $this->_tpl_vars['dtfValue']['record']['user_name']; ?>
</span>
                  <a class="clsImageBoxRemove clsPhotoVideoEditLinks" href="javascript:void(0);" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','friendship_id', 'msgConfirmText'), Array('delete', '<?php echo $this->_tpl_vars['dtfValue']['record']['friend_id']; ?>
', '<?php echo $this->_tpl_vars['dtfValue']['delete_top_friend_confirm_msg']; ?>
'), Array('value','value','innerHTML'), -100, -500);" title="<?php echo $this->_tpl_vars['LANG']['viewfriends_remove_top_friend']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewfriends_remove_top_friend']; ?>
</a>
                </div>
              </div>
        <?php endforeach; endif; unset($_from); ?>
        </div>
        <div id="insertionMarker">
            <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/marker_top.gif" />
            <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/marker_middle.gif" id="insertionMarkerLine" />
            <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/marker_bottom.gif" />
        </div>
            <div id="dragDropContent">
        </div>

        <form action="" method="post">
            <table><tr><td>
                <div class="clsSubmitLeft"><div class="clsSubmitRight"><input class="clsSubmitButton" type="button" style="width:100px" value="Save" onclick="saveImageOrder('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
myFriends.php?ajax_page=true&amp;act=saveOrder')" /></div></div>
            </td></tr></table>
        </form>
      <?php echo '
		<script type="text/javascript" language="javascript">
			//Event.observe(window, "load", initGallery);
			$Jq(document).ready(function(){
				initGallery();
			});
        </script>
     '; ?>

    <?php else: ?>
        <div id="selMsgAlert">
            <p><?php echo $this->_tpl_vars['LANG']['myfriends_msg_no_top_friends']; ?>
<br /><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('myfriends','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['myfriends_add_top_friends']; ?>
</a></p>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_list_friends')): ?>
	<form name="formFriendListing" id="formFriendListing" method="post" action="<?php echo $this->_tpl_vars['myobj']->form_list_friends_arr['form_action']; ?>
">
	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
        <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?><?php if ($this->_tpl_vars['smarty_paging_list']): ?>
     		 <div class="clsTopPagination clsMarginRight10"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>  </div>
	     <?php endif; ?>            
    <?php endif; ?>
		<div class="clsListTable clsMemberListTable clsFriendsContainerMain">
	    <table id="selMembersBrowseTable" class="clsContentsDisplayTbl" cellspacing="0">
            <?php $_from = $this->_tpl_vars['displayMyFriends_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['dmfValue']):
?>
				<?php if ($this->_tpl_vars['dmfValue']['open_tr']): ?>
					<tr class="<?php echo $this->_tpl_vars['myobj']->getCSSRowClass(); ?>
">
			    <?php endif; ?>
                  <td class="selPhotoGallery">
                    	<ul class="clsMembersPhotoListDisplay">
                        	<li id="memberlist_videoli_<?php echo $this->_tpl_vars['inc']; ?>
" onmouseover="showVideoDetail(this)" onmouseout="hideVideoDetail(this)"> <a class="ClsImageContainer ClsImageBorder2 Cls90x90" href="<?php echo $this->_tpl_vars['dmfValue']['friendProfileUrl']; ?>
">
                            <img src="<?php echo $this->_tpl_vars['dmfValue']['icon']['t_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['dmfValue']['record']['friend_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 9) : smarty_modifier_truncate($_tmp, 9)); ?>
" onclick="Redirect2URL('<?php echo $this->_tpl_vars['dmfValue']['friendProfileUrl']; ?>
')" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_thumb_width'],$this->_config[0]['vars']['image_thumb_height'],$this->_tpl_vars['dmfValue']['icon']['t_width'],$this->_tpl_vars['dmfValue']['icon']['t_height']); ?>
 />
                        </a>
                        <p class="selMemberName clsProfileThumbImg clsPaddingTop9"><a href="<?php echo $this->_tpl_vars['dmfValue']['friendProfileUrl']; ?>
" <?php echo $this->_tpl_vars['dmfValue']['online']; ?>
><?php echo $this->_tpl_vars['dmfValue']['record']['friend_name']; ?>
</a></p>
                        <div class="clsPopInfoWidth clsPopInfo clsDisplayNone <?php if ($this->_tpl_vars['dmfValue']['end_tr']): ?> clsPopInfoRight <?php endif; ?>" id="memberlist_selVideoDetails_<?php echo $this->_tpl_vars['inc']; ?>
">
                                               <div class="clsPopUpFriendsContainer <?php if ($this->_tpl_vars['dmfValue']['end_tr']): ?> clsPopUpDivLastContainer <?php endif; ?>"> <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

                                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popinfo_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                            <div class="clsPopUpPaddingContent">
                                                 <div class="selMemDetails clsFriendsListIco clsOverflow">
                                                      <p class="selSendMsg"><a class="clsSendMessage clsPhotoVideoEditLinks" href="<?php echo $this->_tpl_vars['dmfValue']['sendMessageUrl']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewfriends_sendmessage']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewfriends_sendmessage']; ?>
</a></p>
                                                    <?php if ($this->_tpl_vars['myobj']->isCurrentUser()): ?>
                                                        <p>
                                                            <?php if ($this->_tpl_vars['dmfValue']['top_friends']['result']['friend_id'] != $this->_tpl_vars['dmfValue']['record']['friend_id']): ?>
                                                                    <a class="clsAddToFriends clsPhotoVideoEditLinks" href="javascript:void(0);" onclick="if(<?php echo $this->_tpl_vars['myobj']->getTotalTopFriends(); ?>
 < <?php echo $this->_tpl_vars['CFG']['admin']['total_top_friends']; ?>
) <?php echo ' { '; ?>
 return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','friendship_id', 'msgConfirmText'), Array('add','<?php echo $this->_tpl_vars['dmfValue']['record']['friend_id']; ?>
', '<?php echo $this->_tpl_vars['dmfValue']['add_top_friend_confirm_msg']; ?>
'), Array('value','value','innerHTML'), -100, -500) <?php echo ' } '; ?>
 else <?php echo ' { '; ?>
 alert('<?php echo $this->_tpl_vars['LANG']['viewfriends_top_friend_exceeded']; ?>
'); <?php echo ' } '; ?>
;" title="<?php echo $this->_tpl_vars['LANG']['viewfriends_add_top_friend']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewfriends_add_top_friend']; ?>
</a>
                                                            <?php else: ?>
                                                                    <a class="clsRemoveFromFriends clsPhotoVideoEditLinks" href="javascript:void(0);" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','friendship_id', 'msgConfirmText'), Array('delete', '<?php echo $this->_tpl_vars['dmfValue']['record']['friend_id']; ?>
', '<?php echo $this->_tpl_vars['dmfValue']['delete_top_friend_confirm_msg']; ?>
'), Array('value','value','innerHTML'), -100, -500);" title="<?php echo $this->_tpl_vars['LANG']['viewfriends_remove_top_friend']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewfriends_remove_top_friend']; ?>
</a>
                                                            <?php endif; ?>
                                                        </p>
                                                        <p>
                                                          <a class="clsDeleteList clsPhotoVideoEditLinks" name="friendshipId[<?php echo $this->_tpl_vars['dmfValue']['record']['friendship_id']; ?>
]" onclick="return Confirmation('selMsgConfirmDelete', 'msgConfirmDeleteform', Array('act','friendshipId', 'friendship_id', 'msgConfirmDeleteText'), Array('delete','<?php echo $this->_tpl_vars['dmfValue']['record']['friendship_id']; ?>
', '<?php echo $this->_tpl_vars['dmfValue']['record']['friend_id']; ?>
', '<?php echo $this->_tpl_vars['dmfValue']['delete_friend_confirm_msg']; ?>
'), Array('value', 'value', 'value', 'innerHTML'), -100, -500);" title="<?php echo $this->_tpl_vars['LANG']['viewfriends_submit_remove']; ?>
" ><?php echo $this->_tpl_vars['LANG']['viewfriends_submit_remove']; ?>
</a>
                                                        </p>
                                                    <?php endif; ?>
                                                    </div> 
                                            </div>
                                            
                                            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

                                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popinfo_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
                            
                       </div></li>
                        </ul>
					</td>
                <?php if ($this->_tpl_vars['dmfValue']['end_tr']): ?>
                    </tr>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
            <?php if ($this->_tpl_vars['displayMyFriends_arr']['extra_td_tr']): ?>
                  <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['displayMyFriends_arr']['records_per_row']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                  <?php endfor; endif; ?>
            <?php endif; ?>
	    </table>
        </div>
        <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
		<?php if ($this->_tpl_vars['smarty_paging_list']): ?>
		  <div class="clsPaddingRightBottom">
			 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		  </div>	
		<?php endif; ?>           
        <?php endif; ?>
	<?php else: ?>
        <div id="selMsgAlert">
            <p><?php echo $this->_tpl_vars['myobj']->form_list_friends_arr['not_found_msg']; ?>
</p>
        </div>
	<?php endif; ?>
	<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_list_friends_arr['hidden_arr']); ?>

	</form>
<?php endif; ?>

  </div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" language="javascript" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
js/videoDetailsToolTip.js"></script>