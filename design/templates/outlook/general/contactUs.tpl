{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selContactUs">
  <div class="clsPageHeading"><h2>{$LANG.contactus_title}</h2></div>
  {include file='../general/information.tpl'}
  { if $myobj->isShowPageBlock('block_contactus')}
  <div class="clsDataTable">
  <form name="form_contactus_show" id="form_contactus_show" method="post" action="{$myobj->getCurrentUrl()}">
  <p class="clsMandatoryText">{$LANG.common_mandatory_hint_1}<span class="clsMandatoryFieldIconInText">*</span>{$LANG.common_mandatory_hint_2}</p>
        <!-- clsFormSection - starts here -->
    <table>
      <tr>
        <td class="{$myobj->getCSSFormLabelCellClass('useremail')}">
          {$myobj->displayCompulsoryIcon()}
          <label for="useremail">{$LANG.contactus_user_email}</label>
        </td>
        <td class="{$myobj->getCSSFormFieldCellClass('useremail')}">
         <input type="text" class="clsTextBox" name="useremail" id="useremail" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('useremail')}" />
         {$myobj->getFormFieldErrorTip('useremail')}
        {$myobj->ShowHelpTip('contact_us_useremail', 'useremail')}
        </td></tr>
      <tr>
        <td class="{$myobj->getCSSFormLabelCellClass('subject')}">
          {$myobj->displayCompulsoryIcon()}
          <label for="subject">{$LANG.contactus_subject} </label>
        </td>
        <td class="{$myobj->getCSSFormFieldCellClass('subject')}">
         <input type="text" class="clsTextBox" name="subject" id="subject" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('subject')}" />
         {$myobj->getFormFieldErrorTip('subject')}
        {$myobj->ShowHelpTip('contact_us_subject', 'subject')}
        </td></tr>
      <tr>
        <td class="{$myobj->getCSSFormLabelCellClass('message')}">
          {$myobj->displayCompulsoryIcon()}
          <label for="message">{$LANG.contactus_message}</label>
        </td>
        <td class="{$myobj->getCSSFormFieldCellClass('message')}">
         <textarea name="message" id="message" tabindex="{smartyTabIndex}" rows="4" cols="45" class="selInputLimiter" maxlimit="{$CFG.fieldsize.contactus.description}">{$myobj->getFormField('message')}</textarea>
         {$myobj->getFormFieldErrorTip('message')}
        {$myobj->ShowHelpTip('contact_us_message', 'message')}
        </td>
      </tr>
    {if $CFG.mail.captcha}
        {if $CFG.mail.mail_captcha_method =='recaptcha' and $CFG.captcha.public_key and $CFG.captcha.private_key}
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('captcha')}">
                    <label for="recaptcha_response_field">{$LANG.contactus_captcha}</label>
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
        <td class="{$myobj->getCSSFormFieldCellClass('default')}">
          <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="submit_contactus" id="submit_contactus" value="{$LANG.contactus_submit}" tabindex="{smartyTabIndex}" /></div></div>
        </td>
      </tr>
    </table>
    <!-- clsFormSection - ends here -->
  </form></div>
  {/if} </div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}