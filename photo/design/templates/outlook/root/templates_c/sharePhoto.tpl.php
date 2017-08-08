<?php /* Smarty version 2.6.18, created on 2012-02-04 12:03:11
         compiled from sharePhoto.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'sharePhoto.tpl', 7, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_checkbox')): ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('populate_checkbox_for_relation')): ?>
    <input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" />
<?php echo $this->_tpl_vars['LANG']['sharephoto_check_uncheck']; ?>
<br />
        <?php $_from = $this->_tpl_vars['populateCheckBoxForRelation_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cbrValue']):
?>

            <input type="checkbox" class="clsCheckRadio" name="relation_arr[]" value="<?php echo $this->_tpl_vars['cbrValue']['record']['relation_name']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="updateEmailList(this)" />
            <label><b><?php echo $this->_tpl_vars['cbrValue']['record']['relation_name']; ?>
(<?php echo $this->_tpl_vars['cbrValue']['record']['total_contacts']; ?>
)</b></label><br />
        <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('populate_checkbox_for_friend_list')): ?>
    <?php if (! $this->_tpl_vars['myobj']->isShowPageBlock('populate_checkbox_for_relation')): ?>
    	<input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" />
<?php echo $this->_tpl_vars['LANG']['sharephoto_check_uncheck']; ?>
<br />
     <?php endif; ?>

        <?php $_from = $this->_tpl_vars['populateCheckBoxForFriendsList_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cbfValue']):
?>
            <input type="checkbox" class="clsCheckRadio" name="friends_list[]" value="<?php echo $this->_tpl_vars['cbfValue']['record']['user_name']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="updateEmailFriends(this)" />
            <label><?php echo $this->_tpl_vars['cbfValue']['record']['user_name']; ?>
</label><br />
        <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
<?php elseif ($this->_tpl_vars['myobj']->isShowPageBlock('import_contacts')): ?>
      <div class="clsAddContactsPopUp">
            <h3><?php echo $this->_tpl_vars['LANG']['sharephoto_address_book']; ?>
</h3>
            <form name="formContactList" id="formContactList" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCUrrentUrl(true); ?>
" autocomplete="off">
                <label for="relation_id"><?php echo $this->_tpl_vars['LANG']['sharephoto_view']; ?>
</label> <select name="relation_id" id="relation_id" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onChange="return callFriendRelation('<?php echo $this->_tpl_vars['myobj']->relation_onchange; ?>
&amp;relation_id='+this.value, 'friends_list');">
                    <option value="0"><?php echo $this->_tpl_vars['LANG']['sharephoto_all_contacts']; ?>
</option>
                    <?php echo $this->_tpl_vars['myobj']->populateContactLists(); ?>

                </select>
                <h3><?php echo $this->_tpl_vars['LANG']['sharephoto_to_friend']; ?>
</h3>

                <div id="friends_list">
                    <ul>
                       <li class="clsCheckAllHd"><input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" /> <?php echo $this->_tpl_vars['LANG']['sharephoto_check_uncheck']; ?>
</li>

                        <?php $_from = $this->_tpl_vars['populateCheckBoxForRelation_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cbrValue']):
?>
                        <li><input type="checkbox" class="clsCheckRadio" name="relation_arr[]" value="<?php echo $this->_tpl_vars['cbrValue']['record']['relation_name']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="updateEmailList(this)" /> <label><?php echo $this->_tpl_vars['cbrValue']['record']['relation_name']; ?>
(<?php echo $this->_tpl_vars['cbrValue']['record']['total_contacts']; ?>
)</label></li>
                        <?php endforeach; endif; unset($_from); ?>

                        <?php $_from = $this->_tpl_vars['populateCheckBoxForFriendsList_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cbfValue']):
?>
                        <li><input type="checkbox" class="clsCheckRadio" name="friends_list[]" value="<?php echo $this->_tpl_vars['cbfValue']['record']['user_name']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="updateEmailFriends(this)" /> <label><?php echo $this->_tpl_vars['cbfValue']['record']['user_name']; ?>
</label></li>
                        <?php endforeach; endif; unset($_from); ?>
                    </ul>
                </div>
            </form>
    </div>
<?php else: ?>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'flag_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <div id="selSharePhotoBody">
    	<div class="clsOverflow">
        	<div class="clsFlagTitle"><?php echo $this->_tpl_vars['LANG']['sharephoto_title']; ?>
</div>
        </div>
    <?php if (isAjaxpage ( ) || $this->_tpl_vars['myobj']->getFormField('page') == 'photo'): ?>
        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_success')): ?>
              <div id="selMsgSuccess">
                <p><?php echo $this->_tpl_vars['myobj']->getCommonSuccessMsg(); ?>
</p>
              </div>
        <?php endif; ?>
    <?php else: ?>
        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_success')): ?>
        	<?php if ($this->_tpl_vars['myobj']->getFormField('page') == 'photo'): ?>
              <div id="selMsgSuccess">
                <p><?php echo $this->_tpl_vars['myobj']->getCommonSuccessMsg(); ?>
</p>
              </div>
            <?php else: ?>
              <div id="selMsgSuccess">
                <p><?php echo $this->_tpl_vars['myobj']->getCommonSuccessMsg(); ?>
 <span><a href="javascript:void(0);" onClick="window.close()"><?php echo $this->_tpl_vars['LANG']['sharephoto_close']; ?>
</a></span></p>
              </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('share_photo_block')): ?>
        <div id="selMsgError" style="display:none;">
            <p id="commentSelMsgError"></p>
        </div><br />
        <div id="selSharePhoto" class="clsFlagTable clsSharePhotoHeading">
          <form name="formEmailList" id="formEmailList" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" autocomplete="off">
            <table summary="<?php echo $this->_tpl_vars['LANG']['sharephoto_tbl_summary']; ?>
">
                <tr><td colspan="2"><h3><?php echo $this->_tpl_vars['LANG']['sharephoto_email_to']; ?>
</h3></td></tr>
                <tr>
                    <td class="clsTDLabelwidth">
                        <label for="email_address"><?php echo $this->_tpl_vars['LANG']['sharephoto_email_addres']; ?>
</label><span id="selCompulsoryField" class="clsCompulsoryField">*</span><br />
                     </td>
                     <td>
                        <textarea name="email_address" id="email_address" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="5" cols="50"><?php echo $this->_tpl_vars['myobj']->getFormField('email_address'); ?>
</textarea>
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('email_address'); ?>

                        <?php if (isMember ( )): ?>
                                <p class="clsLinkButton"><a id="import_contacts" href="javascript:void(0)" onclick="loadImportContactsLightWindow('<?php echo $this->_tpl_vars['myobj']->share_photo_block['import_contacts_url']; ?>
', '<?php echo $this->_tpl_vars['LANG']['sharephoto_import_contacts']; ?>
')"><?php echo $this->_tpl_vars['LANG']['sharephoto_import_contacts']; ?>
</a></p>
                        <?php endif; ?>
            		</td>
                    </tr>

                    <?php if (! isMember ( )): ?>
                    <tr>
                        <td><label for="first_name"><?php echo $this->_tpl_vars['LANG']['sharephoto_first_name']; ?>
</label><span id="selCompulsoryField" class="clsCompulsoryField">*</span></td>
                        <td><input type="text" name="first_name" class="clsTextBox clsWidth300" id="first_name" value="<?php echo $this->_tpl_vars['myobj']->getFormField('first_name'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('first_name'); ?>
</td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                    	<td><label for="personal_message"><?php echo $this->_tpl_vars['LANG']['sharephoto_personal_message']; ?>
</label></td>
                        <td><textarea name="personal_message" id="personal_message" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="5" cols="50"><?php echo $this->_tpl_vars['myobj']->getFormField('personal_message'); ?>
</textarea></td>
                    </tr>


                    <?php if ($this->_tpl_vars['CFG']['admin']['photos']['captcha'] && $this->_tpl_vars['CFG']['admin']['photos']['captcha_method'] == 'honeypot'): ?>
                    <tr><td class="" colspan="2">
                            <?php echo $this->_tpl_vars['myobj']->hpSolutionsRayzz(); ?>

                    </td></tr>
                     <?php endif; ?>

                    <?php if ($this->_tpl_vars['CFG']['admin']['photos']['captcha'] && $this->_tpl_vars['CFG']['admin']['photos']['captcha_method'] == 'image'): ?>
                    <tr>
                    	<td><label for="captcha_value"><?php echo $this->_tpl_vars['LANG']['sharephoto_captcha']; ?>
</label></label><span id="selCompulsoryField" class="clsCompulsoryField">*</span></td>
                        <td><input type="text" class="clsTextBox clsWidth300" name="captcha_value" id="captcha_value" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" maxlength="15" value="" />
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('captcha_value'); ?>

                        <p><img src="<?php echo $this->_tpl_vars['myobj']->captcha_url; ?>
" /></p></td>
                    </td>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['CFG']['admin']['photos']['captcha'] && isAjaxpage ( )): ?>
                        <?php if ($this->_tpl_vars['CFG']['admin']['photos']['captcha_method'] == 'image'): ?>
                        <tr><td><!-- --></td>
                            <td><div class="clsFlagButtonLeft"><div class="clsFlagButtonRight">
                            <input type="button" class="clsSubmitButton" name="send" id="send" value="<?php echo $this->_tpl_vars['LANG']['sharephoto_send']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return sendAjaxEmailImage('<?php echo $this->_tpl_vars['myobj']->share_photo_block['send_onclick']; ?>
', 'selSharePhotoContent');" /></div></div></td>
                        </tr>
                        <?php elseif ($this->_tpl_vars['CFG']['admin']['photos']['captcha_method'] == 'honeypot'): ?>
                        <tr><td><!-- --></td>
                            <td><div class="clsFlagButtonLeft"><div class="clsFlagButtonRight">
                            <input type="button" class="clsSubmitButton" name="send" id="send" value="<?php echo $this->_tpl_vars['LANG']['sharephoto_send']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return sendAjaxEmailHoneyPot('<?php echo $this->_tpl_vars['myobj']->share_photo_block['send_onclick']; ?>
', '<?php echo $this->_tpl_vars['myobj']->phFormulaRayzz(); ?>
', 'selSharePhotoContent')" /></div></div></td>
                        </tr>
                        <?php endif; ?>
                    <?php else: ?>
                        <tr><td><!-- --></td>
                            <td><div class="clsFlagButtonLeft"><div class="clsFlagButtonRight">
                        	<input type="submit" class="clsSubmitButton" name="send" id="send" value="<?php echo $this->_tpl_vars['LANG']['sharephoto_send']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php if (isAjaxPage ( )): ?> onclick="return sendAjaxEmail('<?php echo $this->_tpl_vars['myobj']->share_photo_block['send_onclick']; ?>
', 'selSharePhotoContent');" <?php endif; ?>/></div></div></td>
                        </tr>
                    <?php endif; ?>
          </table>
        </form>


       </div>
     <?php endif; ?>

    </div><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'flag_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>