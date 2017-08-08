{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<link rel="stylesheet" type="text/css" href="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/css/{$CFG.html.stylesheet.screen.default}/jquery.fancybox.css" media="screen" title="{$CFG.html.stylesheet.screen.default}" />
<div id="selComposeMail">
	<div class="clsPageHeading"><h2>{$LANG.mailcompose_title}</h2></div>
    {include file='../general/information.tpl'}
    <div id="selLeftNavigation">

{if $myobj->isShowPageBlock('form_error')}
	<div id="selMsgError">
		 <p>{$LANG.common_msg_error_sorry}&nbsp;{$myobj->getCommonErrorMsg()}</p>
	</div>
{/if}

{if $myobj->isShowPageBlock('form_success')}
	<div id="selMsgSuccess">
		<p>{$LANG.mailcompose_success_mail}</p>
	</div>
{/if}

{if $myobj->isShowPageBlock('form_compose')}
	{if $CFG.admin.static_page_editor}
	<form name="form_compose" id="selFormCompose" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off" onsubmit="return { if $CFG.feature.html_editor eq 'richtext'}getHTMLSource('rte1', 'frmDocumentEditor', 'page_content');{else}true{/if}">
    {else}
		<form name="selFormCompose" id="selFormCompose" method="post" action="{$myobj->getCurrentUrl(false)}" >
	{/if}
    <div>
		<table border="0" summary="{$LANG.mailcompose_tbl_summary}" class="clsRichTextTable">
		   <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('username')}">{$myobj->displayMandatoryIcon('username')}<label for="username">{$LANG.mailcompose_to}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('username')}">
					<p><textarea name="username" id="username" cols="40" rows="2" tabindex="{smartyTabIndex}">{$myobj->getFormField('username')}</textarea></p>
					{$myobj->getFormFieldErrorTip('username')}
                    {$myobj->ShowHelpTip('messages_to', 'username')}
					<p><a href="{$select_username_url}" id="selComposeSelectUserDiv">{$LANG.mailcompose_select}</a>&nbsp;
					<select name="contacts" id="contacts" tabindex="{smartyTabIndex}" onchange="setUserName(this.form);">
						<option value="">{$LANG.mailcompose_select_contacts}</option>
						<optgroup label="{$LANG.mailcompose_recent_contacts}"></optgroup>
                        {$myobj->generalPopulateArray($populateContacts, $myobj->getFormField('username'))}
						<optgroup label="{$LANG.mailcompose_my_friends}"></optgroup>
                        {$myobj->generalPopulateArray($populateFriends, $myobj->getFormField('username'))}
						<optgroup label="{$LANG.mailcompose_my_relations}"></optgroup>
                        {$myobj->generalPopulateArray($populateRelations, $myobj->getFormField('username'))}
					</select>
					</p>
				</td>
		   </tr>
		   <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('subject')}"><label for="subject">{$LANG.mailcompose_subject}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('message')}">
					<input type="text" class="clsTextBox" name="subject" id="subject" tabindex="{smartyTabIndex}" maxlength="250"  value="{$myobj->getFormField('subject')}" />
					{$myobj->getFormFieldErrorTip('subject')}
                    {$myobj->ShowHelpTip('messages_subject', 'subject')}
				</td>
		   </tr>
		   {*{if chkAllowedModule(array('video'))}
		   <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('video')}"><label for="video">{$LANG.mailcompose_attach_video}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('video')}">
					<select class="clsSelectAtachVideo" name="video" id="video" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.mailcompose_select_videos}</option>
						<optgroup label="{$LANG.mailcompose_my_videos}"></optgroup>
                        {$myobj->generalPopulateArray($populateMyVideos, $myobj->getFormField('video'))}
						<optgroup label="{$LANG.mailcompose_my_favorites}"></optgroup>
                        {$myobj->generalPopulateArray($populateMyFavorites, $myobj->getFormField('video'))}
					</select>
					{$myobj->getFormFieldErrorTip('video')}
                    {$myobj->ShowHelpTip('mailcompose_attach_video', 'video')}
				</td>
		   </tr>
		  {/if} *}
		   <tr>
				<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('message')}">
					{if $CFG.feature.html_editor eq 'tinymce'}
                    	{$myobj->populateHtmlEditor('message')}
                    {else}
				   		<textarea name="message" id="message" cols="82" rows="7"  tabindex="{smartyTabIndex}">{$myobj->getFormField('message')}</textarea>
					{/if}
                	{$myobj->getFormFieldErrorTip('message')}
			   	</td>
			   </tr>
		   </tr>

		   		{if $myobj->getFormField('original_message')}

						<tr>
					   		<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('original_message')}">
								<textarea name="original_message" id="original_message" cols="82" rows="4" disabled readonly >{$myobj->getFormField('original_message')}</textarea>
							</td>
					   	</tr>
					   <tr>
					   		<td class="{$myobj->getCSSFormLabelCellClass('include_original_message')}"><label for="include_original_message_yes">{$LANG.mailcompose_include_message}></label></td>
					        <td class="{$myobj->getCSSFormFieldCellClass('include_original_message')}">
								<input type="radio" class="clsCheckRadio" name="include_original_message" id="include_original_message_yes"  tabindex="{smartyTabIndex}" value="Yes" {$myobj->isCheckedRadio('include_original_message', 'Yes')}/>
					          	<label for="include_original_message_yes">{$LANG.mailcompose_include_message_yes}></label>&nbsp;&nbsp;
			                  	<input type="radio" class="clsCheckRadio" name="include_original_message" id="include_original_message_no" tabindex="{smartyTabIndex}" value="No" {$myobj->isCheckedRadio('include_original_message', 'No')} />
			                  	<label for="include_original_message_no">{$LANG.mailcompose_include_message_no}</label>
                                {$myobj->ShowHelpTip('messages_include_original_message', 'username')}
							</td>
					   </tr>
				{/if}

           {if $CFG.admin.mails.redirect}

					   <tr>
					   		<td class="{$myobj->getCSSFormLabelCellClass('goto')}"><label for="gotocompose">{$LANG.mailcompose_go_to}</label>
                            </td>
                            <td>
								<input type="radio" class="clsCheckRadio" name="goto" id="gotocompose" tabindex="{smartyTabIndex}" value="compose" {$myobj->isCheckedRadio('goto', 'compose')} /> <label for="gotocompose">{$LANG.mailcompose_goto_compose}</label>&nbsp;&nbsp;
								<input type="radio" class="clsCheckRadio" name="goto" id="gotoinbox" tabindex="{smartyTabIndex}" value="inbox" {$myobj->isCheckedRadio('goto', 'inbox')} /> <label for="gotoinbox">{$LANG.mailcompose_goto_inbox}</label>&nbsp;&nbsp;
								<input type="radio" class="clsCheckRadio" name="goto" id="gotosent" tabindex="{smartyTabIndex}" value="sent" {$myobj->isCheckedRadio('goto', 'sent')} /> <label for="gotosent">{$LANG.mailcompose_goto_sent}</label>&nbsp;&nbsp;
							</td>
					   </tr>
		  {/if}
		   <tr>
		   		<td></td>
                <td class="{$myobj->getCSSFormFieldCellClass('to_notify')}">
					<input type="checkbox" class="clsCheckRadio" name="to_notify" id="to_notify" value="Yes" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('to_notify', 'Yes')}/>
					<label for="to_notify">{$LANG.mailcompose_notify}</label>
				</td>
		   </tr>
        {if $CFG.mail.captcha}
            {if $CFG.mail.mail_captcha_method =='recaptcha' and $CFG.captcha.public_key and $CFG.captcha.private_key}
                <tr>
                    <td class="{$myobj->getCSSFormLabelCellClass('captcha')}">
                        <label for="recaptcha_response_field">{$LANG.mailcompose_captcha}</label>
                    </td>
                    <td class="clsOverwriteRecaptcha {$myobj->getCSSFormLabelCellClass('captcha')}">
                        {$myobj->recaptcha_get_html()}
                        {$myobj->getFormFieldErrorTip('recaptcha_response_field')}
                        {$myobj->ShowHelpTip('captcha', 'recaptcha_response_field')}
                    </td>
                </tr>
             {/if}
         {/if}
		   <tr>
				<td></td>
                <td class="{$myobj->getCSSFormFieldCellClass('submit')}">
					<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" name="mailcompose_submit" id="mailcompose_submit" tabindex="{smartyTabIndex}" value="{$LANG.mailcompose_send}" /></div></div>
				</td>
		   </tr>
		</table>
    </div>
		<input type="hidden" name="action" value="{$myobj->getFormField('action')}" />
		<input type="hidden" name="msgFolder" value="{$myobj->getFormField('msgFolder')}" />
		<input type="hidden" name="message_id" value="{$myobj->getFormField('message_id')}" />
		<input type="hidden" name="bulletin_id" value="{$myobj->getFormField('bulletin_id')}" />
		<input type="hidden" name="answer_id" value="{$myobj->getFormField('answer_id')}" />
	</form>
{/if}
	</div>
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
