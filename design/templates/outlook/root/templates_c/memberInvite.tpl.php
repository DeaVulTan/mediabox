<?php /* Smarty version 2.6.18, created on 2011-12-23 02:15:04
         compiled from memberInvite.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'memberInvite.tpl', 58, false),)), $this); ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/css/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/jquery.fancybox.css" media="screen" title="<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
" />
<div class="clsInviteFriendPage">
    <div class="clsInviteFriendContent">
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php echo '
    <script language="javascript" type="text/javascript">
        function popupWindow(url){
             window.open (url, "","status=0,toolbar=0,resizable=0,scrollbars=1");
             return false;
        }
    </script>
    '; ?>

    <div id="selMembersInvitation">
    	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['invite_title']; ?>
</h2></div>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_success_msg')): ?>
        	<div id="selMsgSuccess">
            	<?php if (( isset ( $this->_tpl_vars['myobj']->form_success['display_success_message']['sent_email'] ) && $this->_tpl_vars['myobj']->form_success['display_success_message']['sent_email']['email'] )): ?>
                	<div class="clsSentMailMessange"><h2><?php echo $this->_tpl_vars['myobj']->form_success['display_success_message']['sent_email']['title']; ?>
</h2>
                    <?php $_from = $this->_tpl_vars['myobj']->form_success['display_success_message']['sent_email']['email']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ssokey'] => $this->_tpl_vars['ssovalue']):
?>
                        <p><?php echo $this->_tpl_vars['ssovalue']; ?>
</p>
                    <?php endforeach; endif; unset($_from); ?></div>
                <?php endif; ?>
               	<?php if (( isset ( $this->_tpl_vars['myobj']->form_success['display_success_message']['exist_email'] ) && $this->_tpl_vars['myobj']->form_success['display_success_message']['exist_email']['email'] )): ?>
                     <div class="clsSentMailMessange"><h2><?php echo $this->_tpl_vars['myobj']->form_success['display_success_message']['exist_email']['title']; ?>
</h2>
                    <?php $_from = $this->_tpl_vars['myobj']->form_success['display_success_message']['exist_email']['email']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ssokey'] => $this->_tpl_vars['ssovalue']):
?>
                        <p class="clsPaddingBottom5"><?php echo $this->_tpl_vars['ssovalue']['value']; ?>
&nbsp;<span><a href="<?php echo $this->_tpl_vars['ssovalue']['profile_url']; ?>
"><?php echo $this->_tpl_vars['ssovalue']['user_name']; ?>
</a></span></p>
                    <?php endforeach; endif; unset($_from); ?></div>
                <?php endif; ?>
                <?php if (( isset ( $this->_tpl_vars['myobj']->form_success['display_success_message']['invalid_email'] ) && $this->_tpl_vars['myobj']->form_success['display_success_message']['invalid_email']['email'] )): ?>
                    <div class="clsSentMailMessange clsNotSentMail"><h2><?php echo $this->_tpl_vars['myobj']->form_success['display_success_message']['invalid_email']['title']; ?>
</h2>
                    <?php $_from = $this->_tpl_vars['myobj']->form_success['display_success_message']['invalid_email']['email']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ssokey'] => $this->_tpl_vars['ssovalue']):
?>
                    	<p><?php echo $this->_tpl_vars['ssovalue']; ?>
</p>
                    <?php endforeach; endif; unset($_from); ?></div>
                <?php endif; ?>
              	<p class="clsMsgAdditionalText"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('invitationhistory'); ?>
"><?php echo $this->_tpl_vars['LANG']['invite_link_history']; ?>
</a></p>
              	<p class="clsMsgAdditionalText"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('membersinvite'); ?>
"><?php echo $this->_tpl_vars['LANG']['invite_link_again']; ?>
</a></p>
            </div>
        <?php endif; ?>

    	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_invite')): ?>
      	<form name="form_contactus_show" id="form_contactus_show" method="post" action="<?php echo $this->_tpl_vars['myobj']->getUrl('membersinvite'); ?>
">
      	<div id="selMembersInvitationLeft" class="clsMemberInvitationBar">
        	<p class="clsInviteNote"><?php echo $this->_tpl_vars['LANG']['use_form_message']; ?>
&nbsp;<?php echo $this->_tpl_vars['CFG']['site']['title']; ?>
. <?php echo $this->_tpl_vars['LANG']['save_time_importing_contacts']; ?>
</p>
        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
          	<div id="selPostCard">
            	<div class="clsInviteInformation">
                	<div class="clsInviteInformationLeft">
                    							<h2 class="clsInviteSubTitle"><?php echo $this->_tpl_vars['LANG']['invite_youraddress']; ?>
</h2>
                    	<div class="clsInviteTable">
                        	<table summary="<?php echo $this->_tpl_vars['LANG']['member_invite_tbl_summary']; ?>
">
                            	<tr>
                                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('from_email'); ?>
 clsWidth180">
                                    	<p><label for="from_email"><?php echo $this->_tpl_vars['LANG']['from_email']; ?>
</label></p>
                                	</td>
                                	<td>
                                    	<input type="text" readonly  class="clsTextBox" name="from_email" id="from_email" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('from_email'); ?>
" />
                                    	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('from_email'); ?>

                                	</td>
                              	</tr>
                              	<tr>
                                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('from_name'); ?>
 clsWidth180">
                                    	<p><label for="from_name"><?php echo $this->_tpl_vars['LANG']['from_name']; ?>
</label><br /><span><label for="from_name"><?php echo $this->_tpl_vars['LANG']['from_optional']; ?>
</label></span></p>
                                 	</td>
                                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('from_name'); ?>
">
                                    	<input type="text" readonly  class="clsTextBox" name="from_name" id="from_name" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('from_name'); ?>
" />
                                    	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('from_name'); ?>

                                	</td>
                              	</tr>
                              	<tr>
                                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('personal_message'); ?>
 clsWidth180">
                                    	<p><label for="personal_message"><?php echo $this->_tpl_vars['LANG']['personal_message']; ?>
</label><br /><span><label for="personal_message"><?php echo $this->_tpl_vars['LANG']['from_optional']; ?>
</label></span></p>
                                 	</td>
                                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('personal_message'); ?>
">
                                    	<textarea class="clsEmbedInvite selInputLimiter" maxlimit="<?php echo $this->_tpl_vars['CFG']['fieldsize']['invitation']['description']; ?>
" name="personal_message" id="personal_message" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="5" cols="50"><?php echo $this->_tpl_vars['myobj']->getFormField('personal_message'); ?>
</textarea>
                                    	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('personal_message'); ?>

                                 	</td>
                              	</tr>
                            </table>
                        </div>
						<div class="clsInviteTable">
						<h2 class="clsInviteSubTitle"><?php echo $this->_tpl_vars['LANG']['invite_friendsaddress']; ?>
</h2>
                        	<table summary="<?php echo $this->_tpl_vars['LANG']['member_invite_tbl_summary']; ?>
">
                            	<tr>
                                	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('to_emails'); ?>
 clsWidth180">
                                    	<p><label for="to_emails"><?php echo $this->_tpl_vars['LANG']['invite_email']; ?>
</label><span><span class="clsMandatoryFieldIcon">*</span><br /><label for="to_emails"><?php echo $this->_tpl_vars['LANG']['invite_comma']; ?>
</label></span></p>
                                    </td>
                                    <td>
                                    	<textarea class="clsEmbedInvite" name="to_emails" id="to_emails" rows="5" cols="50" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('to_emails'); ?>
</textarea>
                                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('to_emails'); ?>

										<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('email'); ?>

                                	</td>
                                </tr>
                                <tr>
                                	<td colspan="2" class="clsAddressBgCol">
                                     	<p class=""><?php echo $this->_tpl_vars['LANG']['use_addressbook']; ?>
</p>
                                    </td>
                                </tr>
                                <tr>
                                	<td colspan="2">
                                    	<input type="checkbox" class="clsCheckBox" name="send_copy" id="send_copy" tabindex="1" value="1" title="send copy" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('send_copy','1'); ?>
/>
                                    	&nbsp;
                                    	<label for="send_copy"><?php echo $this->_tpl_vars['LANG']['sendacopy_tomyemail']; ?>
</label>
                                    </td>
                                </tr>
                                <?php if ($this->_tpl_vars['CFG']['mail']['captcha']): ?>
					      			<?php if ($this->_tpl_vars['CFG']['mail']['mail_captcha_method'] == 'recaptcha' && $this->_tpl_vars['CFG']['captcha']['public_key'] && $this->_tpl_vars['CFG']['captcha']['private_key']): ?>
                                    	<tr>
                                        	<td class="clsWidth180">
                                            	<label for="recaptcha_response_field"><?php echo $this->_tpl_vars['LANG']['invite_captcha']; ?>
</label>
											</td>
											<td>	
                                                <?php echo $this->_tpl_vars['myobj']->recaptcha_get_html(); ?>

                                                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('recaptcha_response_field'); ?>

                                                <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('captcha','recaptcha_response_field'); ?>

                                            </td>
                                        </tr>
                                     <?php endif; ?>
                                 <?php endif; ?>
                                <tr>
                                	<td colspan="2">
                                    	<div class="clsInviteMemberButton"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class=" clsInviteFriendsButton" name="invite_submit" id="invite_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['invite_submit']; ?>
" /></div></div>
                            		</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                     </div>
                     <div class="clsInviteInformationRight">
					  <div class="clsInviteMemberBanner"><!-- --></div>
                     	                        <form name="formEmailList" id="formEmailList" method="post" action="" autocomplete="off">
          			   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'invitemember_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						<table summary="<?php echo $this->_tpl_vars['LANG']['member_invite_tbl_summary']; ?>
" class="clsAddressBookTable">
							<tr>
								<td colspan="2" class="clsAddressBook"><?php echo $this->_tpl_vars['LANG']['address_book']; ?>
</td>
							</tr>
							<tr>
								<td colspan="2"><label><?php echo $this->_tpl_vars['LANG']['quick_wizard']; ?>
<label></td>
							</tr>
							<tr>
								<td class="clsBottomBorder20"><label><?php echo $this->_tpl_vars['LANG']['import_yourcontacts_from']; ?>
</label> <p class="clsBold"><?php echo $this->_tpl_vars['LANG']['invite_mailingaddress']; ?>
</p></td>              		
							</tr>
							<tr class="clsPasswordStore">
								<td class="clsBottomBorder" colspan="2"><p><?php echo $this->_tpl_vars['LANG']['willnotstore_password']; ?>
</p></td>
								<td>
								  <div class="clsSubmitLeft">
									<div class="clsSubmitRight">
										<a class="clsImportContactsButton" href="<?php echo $this->_tpl_vars['myobj']->form_invite['importer_url']; ?>
" id="change_lang" name="change_lang" title="<?php echo $this->_tpl_vars['LANG']['import_contacts']; ?>
"><?php echo $this->_tpl_vars['LANG']['import_contacts']; ?>
</a>
									</div>
								 </div>
								</td>
							</tr>
						</table>
        		      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'invitemember_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					</form>
                      </div>
                </div>
        	</div>
      	</div>
        </form>

      	<div class="clsMembersInvitationRight">
      	
      	</div>
      	<div id="selLeftNavigation">
      	</div>
      	<?php endif; ?>
    </div>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</div><input type="hidden"  name="return_url" id="return_url"  value=""/>