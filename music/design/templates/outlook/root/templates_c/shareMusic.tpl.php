<?php /* Smarty version 2.6.18, created on 2012-02-02 01:03:53
         compiled from shareMusic.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'shareMusic.tpl', 7, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_checkbox')): ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('populate_checkbox_for_relation')): ?>
    <input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" />
<?php echo $this->_tpl_vars['LANG']['sharemusic_check_uncheck']; ?>
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
<?php echo $this->_tpl_vars['LANG']['sharemusic_check_uncheck']; ?>
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
            <h3><?php echo $this->_tpl_vars['LANG']['sharemusic_address_book']; ?>
</h3>
            <form name="formContactList" id="formContactList" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCUrrentUrl(true); ?>
" autocomplete="off">
                <label for="relation_id"><?php echo $this->_tpl_vars['LANG']['sharemusic_view']; ?>
</label> <select name="relation_id" id="relation_id" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onChange="return callFriendRelation('<?php echo $this->_tpl_vars['myobj']->relation_onchange; ?>
&amp;relation_id='+this.value, 'friends_list');">
                    <option value="0"><?php echo $this->_tpl_vars['LANG']['sharemusic_all_contacts']; ?>
</option>
                    <?php echo $this->_tpl_vars['myobj']->populateContactLists(); ?>

                </select>
                <h3><?php echo $this->_tpl_vars['LANG']['sharemusic_to_friend']; ?>
</h3>

                <div id="friends_list">
                    <ul>
                       <li><input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" /> <?php echo $this->_tpl_vars['LANG']['sharemusic_check_uncheck']; ?>
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
    <div id="selShareMusicBody">
    <?php if ($this->_tpl_vars['myobj']->getFormField('page') != 'music' && $this->_tpl_vars['myobj']->getFormField('page') != 'sharemusic'): ?>
<!--      <div class="clsOverflow">
        <div class="clsShareTitle"><?php echo $this->_tpl_vars['LANG']['sharemusic_title']; ?>
</div>
        <div class="clsShareFlag"><a title="close" onClick="hideMusicSection('shareDiv','clsDisplayNone')"><?php echo $this->_tpl_vars['LANG']['music_close']; ?>
</a></div>
      </div>
-->    <?php endif; ?>

    <?php if (isAjaxpage ( ) || $this->_tpl_vars['myobj']->getFormField('page') == 'music'): ?>
        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_success')): ?>
              <div id="selMsgSuccess">
                <p><?php echo $this->_tpl_vars['myobj']->getCommonSuccessMsg(); ?>
</p>
              </div>
        <?php endif; ?>
    <?php else: ?>
        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_success')): ?>
        	<?php if ($this->_tpl_vars['myobj']->getFormField('page') == 'music'): ?>
              <div id="selMsgSuccess">
                <p><?php echo $this->_tpl_vars['myobj']->getCommonSuccessMsg(); ?>
</p>
              </div>
            <?php else: ?>
              <div id="selMsgSuccess">
                <p><?php echo $this->_tpl_vars['myobj']->getCommonSuccessMsg(); ?>
 <span><a href="javascript:void(0);" onClick="window.close()" title="<?php echo $this->_tpl_vars['LANG']['sharemusic_close']; ?>
"><?php echo $this->_tpl_vars['LANG']['sharemusic_close']; ?>
</a></span></p>
              </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('share_music_block')): ?>
        <div id="selMsgError" style="display:none;">
            <p id="commentSelMsgError"></p>
        </div>
        <div id="selShareMusic" class="clsFormTable">
            <form name="formEmailList" id="formEmailList" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" autocomplete="off">
            <table summary="<?php echo $this->_tpl_vars['LANG']['sharemusic_tbl_summary']; ?>
">
                <tr>
                    <td colspan="2">
                      <h3><?php echo $this->_tpl_vars['LANG']['sharemusic_email_to']; ?>
</h3>
                    </td>
                <tr>
                	  <td>
                            <label for="email_address"><?php echo $this->_tpl_vars['LANG']['sharemusic_email_addres']; ?>
</label><span id="selCompulsoryField">*</span><?php echo $this->_tpl_vars['LANG']['sharemusic_email_separated_values']; ?>

                              <?php if (isMember ( )): ?>
                                <br /><?php echo $this->_tpl_vars['LANG']['sharemusic_or']; ?>

                                <p><a id="import_contacts" href="javascript:void(0)" onclick="loadImportContactsLightWindow('<?php echo $this->_tpl_vars['myobj']->share_music_block['import_contacts_url']; ?>
', '<?php echo $this->_tpl_vars['LANG']['sharemusic_import_contacts']; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['sharemusic_import_contacts']; ?>
"><?php echo $this->_tpl_vars['LANG']['sharemusic_import_contacts']; ?>
</a></p>
                  	      <?php endif; ?>
                    </td>
                    <td>
                            <textarea name="email_address" id="email_address" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="5" cols="50"><?php echo $this->_tpl_vars['myobj']->getFormField('email_address'); ?>
</textarea>
                            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('email_address'); ?>

                    </td>
                </tr>
              <?php if (! isMember ( )): ?>
                <tr>
                	  <td>
                              <label for="first_name"><?php echo $this->_tpl_vars['LANG']['sharemusic_first_name']; ?>
</label><span id="selCompulsoryField">*</span>
                    </td>
                    <td>
                            <input type="text" name="first_name" id="first_name" value="<?php echo $this->_tpl_vars['myobj']->getFormField('first_name'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('first_name'); ?>

                    </td>
                </tr>
              <?php endif; ?>
			<tr>
                     <td>
                        <label for="personal_message"><?php echo $this->_tpl_vars['LANG']['sharemusic_personal_message']; ?>
</label>
                     </td>
                     <td>
                        <textarea name="personal_message" id="personal_message" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="5" cols="50"><?php echo $this->_tpl_vars['myobj']->getFormField('personal_message'); ?>
</textarea>
                        <?php if ($this->_tpl_vars['CFG']['admin']['musics']['captcha'] && $this->_tpl_vars['CFG']['admin']['musics']['captcha_method'] == 'honeypot'): ?>
                            <?php echo $this->_tpl_vars['myobj']->hpSolutionsRayzz(); ?>

                        <?php endif; ?>
                     </td>
                  </tr>
                  <?php if ($this->_tpl_vars['CFG']['admin']['musics']['captcha'] && $this->_tpl_vars['CFG']['admin']['musics']['captcha_method'] == 'image'): ?>
                        <tr>
                           <td>
                              <label for="captcha_value"><?php echo $this->_tpl_vars['LANG']['sharemusic_captcha']; ?>
</label></label><span id="selCompulsoryField">*</span>
                           </td>
                           <td>
                              <input type="text" class="clsTextBox" name="captcha_value" id="captcha_value" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" maxlength="15" value="" />
                              <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('captcha_value'); ?>

                              <img src="<?php echo $this->_tpl_vars['myobj']->captcha_url; ?>
" />
                           </td>
                         </td>
                  <?php endif; ?>
			<tr style="display:none" id="share_loader_row">    <td><!----></td>
                  	<td>
                              <div id="share_submitted"></div>
                        </td>
                  </tr>
			<tr>    <td><!----></td>
                  	<td>
                        <?php if ($this->_tpl_vars['CFG']['admin']['musics']['captcha'] && isAjaxpage ( )): ?>
                            <?php if ($this->_tpl_vars['CFG']['admin']['musics']['captcha_method'] == 'image'): ?>
                                <p class="clsButton"><span>
	                            <input type="button" class="clsSubmitButton" name="send" id="send" value="<?php echo $this->_tpl_vars['LANG']['sharemusic_send']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return sendAjaxEmailImage('<?php echo $this->_tpl_vars['myobj']->share_music_block['send_onclick']; ?>
', 'shareDiv');" /></span></p>
                            <?php elseif ($this->_tpl_vars['CFG']['admin']['musics']['captcha_method'] == 'honeypot'): ?>
                                <p class="clsButton"><span>
	                            <input type="button" class="clsSubmitButton" name="send" id="send" value="<?php echo $this->_tpl_vars['LANG']['sharemusic_send']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return sendAjaxEmailHoneyPot('<?php echo $this->_tpl_vars['myobj']->share_music_block['send_onclick']; ?>
', '<?php echo $this->_tpl_vars['myobj']->phFormulaRayzz(); ?>
', 'shareDiv')" /></span></p>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="clsButton"><span>
                            <input type="submit" class="clsSubmitButton" name="send" id="send" value="<?php echo $this->_tpl_vars['LANG']['sharemusic_send']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php if (isAjaxPage ( )): ?> onclick="return sendAjaxEmail('<?php echo $this->_tpl_vars['myobj']->share_music_block['send_onclick']; ?>
', 'shareDiv');" <?php endif; ?>/>
                            </span></p>
                        <?php endif; ?>
                		</td>
	            </tr>
          </table>
        </form>
       </div>
     <?php endif; ?>

    </div>
<?php endif; ?>