<link rel="stylesheet" type="text/css" href="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/css/{$CFG.html.stylesheet.screen.default}/jquery.fancybox.css" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
<div class="clsInviteFriendPage">
    <div class="clsInviteFriendContent">
    {$myobj->setTemplateFolder('general/')}
	{include file="box.tpl" opt="display_top"}
    {literal}
    <script language="javascript" type="text/javascript">
        function popupWindow(url){
             window.open (url, "","status=0,toolbar=0,resizable=0,scrollbars=1");
             return false;
        }
    </script>
    {/literal}
    <div id="selMembersInvitation">
    	<div class="clsPageHeading"><h2>{$LANG.invite_title}</h2></div>
		{if $myobj->isShowPageBlock('form_success_msg')}
        	<div id="selMsgSuccess">
            	{if (isset($myobj->form_success.display_success_message.sent_email) && $myobj->form_success.display_success_message.sent_email.email)}
                	<div class="clsSentMailMessange"><h2>{$myobj->form_success.display_success_message.sent_email.title}</h2>
                    {foreach key=ssokey item=ssovalue from=$myobj->form_success.display_success_message.sent_email.email}
                        <p>{$ssovalue}</p>
                    {/foreach}</div>
                {/if}
               	{if (isset($myobj->form_success.display_success_message.exist_email) && $myobj->form_success.display_success_message.exist_email.email)}
                     <div class="clsSentMailMessange"><h2>{$myobj->form_success.display_success_message.exist_email.title}</h2>
                    {foreach key=ssokey item=ssovalue from=$myobj->form_success.display_success_message.exist_email.email}
                        <p class="clsPaddingBottom5">{$ssovalue.value}&nbsp;<span><a href="{$ssovalue.profile_url}">{$ssovalue.user_name}</a></span></p>
                    {/foreach}</div>
                {/if}
                {if (isset($myobj->form_success.display_success_message.invalid_email) && $myobj->form_success.display_success_message.invalid_email.email)}
                    <div class="clsSentMailMessange clsNotSentMail"><h2>{$myobj->form_success.display_success_message.invalid_email.title}</h2>
                    {foreach key=ssokey item=ssovalue from=$myobj->form_success.display_success_message.invalid_email.email}
                    	<p>{$ssovalue}</p>
                    {/foreach}</div>
                {/if}
              	<p class="clsMsgAdditionalText"><a href="{$myobj->getUrl('invitationhistory')}">{$LANG.invite_link_history}</a></p>
              	<p class="clsMsgAdditionalText"><a href="{$myobj->getUrl('membersinvite')}">{$LANG.invite_link_again}</a></p>
            </div>
        {/if}

    	{if $myobj->isShowPageBlock('form_invite') }
      	<form name="form_contactus_show" id="form_contactus_show" method="post" action="{$myobj->getUrl('membersinvite')}">
      	<div id="selMembersInvitationLeft" class="clsMemberInvitationBar">
        	<p class="clsInviteNote">{$LANG.use_form_message}&nbsp;{$CFG.site.title}. {$LANG.save_time_importing_contacts}</p>
        	{include file='../general/information.tpl'}
          	<div id="selPostCard">
            	<div class="clsInviteInformation">
                	<div class="clsInviteInformationLeft">
                    	{*<h1><a href="{$CFG.site.url}" title="Browse to homepage">{$CFG.site.name}</a></h1>*}
						<h2 class="clsInviteSubTitle">{$LANG.invite_youraddress}</h2>
                    	<div class="clsInviteTable">
                        	<table summary="{$LANG.member_invite_tbl_summary}">
                            	<tr>
                                	<td class="{$myobj->getCSSFormLabelCellClass('from_email')} clsWidth180">
                                    	<p><label for="from_email">{$LANG.from_email}</label></p>
                                	</td>
                                	<td>
                                    	<input type="text" readonly  class="clsTextBox" name="from_email" id="from_email" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('from_email')}" />
                                    	{$myobj->getFormFieldErrorTip('from_email')}
                                	</td>
                              	</tr>
                              	<tr>
                                	<td class="{$myobj->getCSSFormLabelCellClass('from_name')} clsWidth180">
                                    	<p><label for="from_name">{$LANG.from_name}</label><br /><span><label for="from_name">{$LANG.from_optional}</label></span></p>
                                 	</td>
                                	<td class="{$myobj->getCSSFormLabelCellClass('from_name')}">
                                    	<input type="text" readonly  class="clsTextBox" name="from_name" id="from_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('from_name')}" />
                                    	{$myobj->getFormFieldErrorTip('from_name')}
                                	</td>
                              	</tr>
                              	<tr>
                                	<td class="{$myobj->getCSSFormLabelCellClass('personal_message')} clsWidth180">
                                    	<p><label for="personal_message">{$LANG.personal_message}</label><br /><span><label for="personal_message">{$LANG.from_optional}</label></span></p>
                                 	</td>
                                	<td class="{$myobj->getCSSFormLabelCellClass('personal_message')}">
                                    	<textarea class="clsEmbedInvite selInputLimiter" maxlimit="{$CFG.fieldsize.invitation.description}" name="personal_message" id="personal_message" tabindex="{smartyTabIndex}" rows="5" cols="50">{$myobj->getFormField('personal_message')}</textarea>
                                    	{$myobj->getFormFieldErrorTip('personal_message')}
                                 	</td>
                              	</tr>
                            </table>
                        </div>
						<div class="clsInviteTable">
						<h2 class="clsInviteSubTitle">{$LANG.invite_friendsaddress}</h2>
                        	<table summary="{$LANG.member_invite_tbl_summary}">
                            	<tr>
                                	<td class="{$myobj->getCSSFormLabelCellClass('to_emails')} clsWidth180">
                                    	<p><label for="to_emails">{$LANG.invite_email}</label><span><span class="clsMandatoryFieldIcon">*</span><br /><label for="to_emails">{$LANG.invite_comma}</label></span></p>
                                    </td>
                                    <td>
                                    	<textarea class="clsEmbedInvite" name="to_emails" id="to_emails" rows="5" cols="50" tabindex="{smartyTabIndex}">{$myobj->getFormField('to_emails')}</textarea>
                                        {$myobj->getFormFieldErrorTip('to_emails')}
										{$myobj->ShowHelpTip('email')}
                                	</td>
                                </tr>
                                <tr>
                                	<td colspan="2" class="clsAddressBgCol">
                                     	<p class="">{$LANG.use_addressbook}</p>
                                    </td>
                                </tr>
                                <tr>
                                	<td colspan="2">
                                    	<input type="checkbox" class="clsCheckBox" name="send_copy" id="send_copy" tabindex="1" value="1" title="send copy" {$myobj->isCheckedRadio('send_copy', '1')}/>
                                    	&nbsp;
                                    	<label for="send_copy">{$LANG.sendacopy_tomyemail}</label>
                                    </td>
                                </tr>
                                {if $CFG.mail.captcha}
					      			{if $CFG.mail.mail_captcha_method =='recaptcha' and $CFG.captcha.public_key and $CFG.captcha.private_key}
                                    	<tr>
                                        	<td class="clsWidth180">
                                            	<label for="recaptcha_response_field">{$LANG.invite_captcha}</label>
											</td>
											<td>	
                                                {$myobj->recaptcha_get_html()}
                                                {$myobj->getFormFieldErrorTip('recaptcha_response_field')}
                                                {$myobj->ShowHelpTip('captcha', 'recaptcha_response_field')}
                                            </td>
                                        </tr>
                                     {/if}
                                 {/if}
                                <tr>
                                	<td colspan="2">
                                    	<div class="clsInviteMemberButton"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class=" clsInviteFriendsButton" name="invite_submit" id="invite_submit" tabindex="{smartyTabIndex}" value="{$LANG.invite_submit}" /></div></div>
                            		</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                     </div>
                     <div class="clsInviteInformationRight">
					  <div class="clsInviteMemberBanner"><!-- --></div>
                     	{*<h1><a href="{$CFG.site.url}" title="Browse to homepage">{$CFG.site.name}</a></h1>*}
                        <form name="formEmailList" id="formEmailList" method="post" action="" autocomplete="off">
          			   {include file='box.tpl' opt='invitemember_top'}
						<table summary="{$LANG.member_invite_tbl_summary}" class="clsAddressBookTable">
							<tr>
								<td colspan="2" class="clsAddressBook">{$LANG.address_book}</td>
							</tr>
							<tr>
								<td colspan="2"><label>{$LANG.quick_wizard}<label></td>
							</tr>
							<tr>
								<td class="clsBottomBorder20"><label>{$LANG.import_yourcontacts_from}</label> <p class="clsBold">{$LANG.invite_mailingaddress}</p></td>              		
							</tr>
							<tr class="clsPasswordStore">
								<td class="clsBottomBorder" colspan="2"><p>{$LANG.willnotstore_password}</p></td>
								<td>
								  <div class="clsSubmitLeft">
									<div class="clsSubmitRight">
										<a class="clsImportContactsButton" href="{$myobj->form_invite.importer_url}" id="change_lang" name="change_lang" title="{$LANG.import_contacts}">{$LANG.import_contacts}</a>
									</div>
								 </div>
								</td>
							</tr>
						</table>
        		      {include file='box.tpl' opt='invitemember_bottom'}
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
      	{/if}
    </div>
    {include file="box.tpl" opt="display_bottom"}
</div>
</div><input type="hidden"  name="return_url" id="return_url"  value=""/>