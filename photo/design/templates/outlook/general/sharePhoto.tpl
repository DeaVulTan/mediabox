{if $myobj->isShowPageBlock('block_checkbox')}
    {if $myobj->isShowPageBlock('populate_checkbox_for_relation')}
    <input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" />
{$LANG.sharephoto_check_uncheck}<br />
        {foreach item=cbrValue from=$populateCheckBoxForRelation_arr}

            <input type="checkbox" class="clsCheckRadio" name="relation_arr[]" value="{$cbrValue.record.relation_name}" tabindex="{smartyTabIndex}" onClick="updateEmailList(this)" />
            <label><b>{$cbrValue.record.relation_name}({$cbrValue.record.total_contacts})</b></label><br />
        {/foreach}
    {/if}
    {if $myobj->isShowPageBlock('populate_checkbox_for_friend_list')}
    {if !$myobj->isShowPageBlock('populate_checkbox_for_relation')}
    	<input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" />
{$LANG.sharephoto_check_uncheck}<br />
     {/if}

        {foreach item=cbfValue from=$populateCheckBoxForFriendsList_arr}
            <input type="checkbox" class="clsCheckRadio" name="friends_list[]" value="{$cbfValue.record.user_name}" tabindex="{smartyTabIndex}" onClick="updateEmailFriends(this)" />
            <label>{$cbfValue.record.user_name}</label><br />
        {/foreach}
    {/if}
{elseif $myobj->isShowPageBlock('import_contacts')}
      <div class="clsAddContactsPopUp">
            <h3>{$LANG.sharephoto_address_book}</h3>
            <form name="formContactList" id="formContactList" method="post" action="{$myobj->getCUrrentUrl(true)}" autocomplete="off">
                <label for="relation_id">{$LANG.sharephoto_view}</label> <select name="relation_id" id="relation_id" tabindex="{smartyTabIndex}" onChange="return callFriendRelation('{$myobj->relation_onchange}&amp;relation_id='+this.value, 'friends_list');">
                    <option value="0">{$LANG.sharephoto_all_contacts}</option>
                    {$myobj->populateContactLists()}
                </select>
                <h3>{$LANG.sharephoto_to_friend}</h3>

                <div id="friends_list">
                    <ul>
                       <li class="clsCheckAllHd"><input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" /> {$LANG.sharephoto_check_uncheck}</li>

                        {foreach item=cbrValue from=$populateCheckBoxForRelation_arr}
                        <li><input type="checkbox" class="clsCheckRadio" name="relation_arr[]" value="{$cbrValue.record.relation_name}" tabindex="{smartyTabIndex}" onClick="updateEmailList(this)" /> <label>{$cbrValue.record.relation_name}({$cbrValue.record.total_contacts})</label></li>
                        {/foreach}

                        {foreach item=cbfValue from=$populateCheckBoxForFriendsList_arr}
                        <li><input type="checkbox" class="clsCheckRadio" name="friends_list[]" value="{$cbfValue.record.user_name}" tabindex="{smartyTabIndex}" onClick="updateEmailFriends(this)" /> <label>{$cbfValue.record.user_name}</label></li>
                        {/foreach}
                    </ul>
                </div>
            </form>
    </div>
{else}
    {$myobj->setTemplateFolder('general/')}
    {include file='box.tpl' opt='flag_top'}

    <div id="selSharePhotoBody">
    	<div class="clsOverflow">
        	<div class="clsFlagTitle">{$LANG.sharephoto_title}</div>
        </div>
    {if isAjaxpage() || $myobj->getFormField('page')=='photo'}
        {if $myobj->isShowPageBlock('form_success')}
              <div id="selMsgSuccess">
                <p>{$myobj->getCommonSuccessMsg()}</p>
              </div>
        {/if}
    {else}
        {if $myobj->isShowPageBlock('form_success')}
        	{if $myobj->getFormField('page') == 'photo'}
              <div id="selMsgSuccess">
                <p>{$myobj->getCommonSuccessMsg()}</p>
              </div>
            {else}
              <div id="selMsgSuccess">
                <p>{$myobj->getCommonSuccessMsg()} <span><a href="javascript:void(0);" onClick="window.close()">{$LANG.sharephoto_close}</a></span></p>
              </div>
            {/if}
        {/if}
    {/if}

    {$myobj->setTemplateFolder('general/')}
    {include file='information.tpl'}

    {if $myobj->isShowPageBlock('share_photo_block')}
        <div id="selMsgError" style="display:none;">
            <p id="commentSelMsgError"></p>
        </div><br />
        <div id="selSharePhoto" class="clsFlagTable clsSharePhotoHeading">
          <form name="formEmailList" id="formEmailList" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off">
            <table summary="{$LANG.sharephoto_tbl_summary}">
                <tr><td colspan="2"><h3>{$LANG.sharephoto_email_to}</h3></td></tr>
                <tr>
                    <td class="clsTDLabelwidth">
                        <label for="email_address">{$LANG.sharephoto_email_addres}</label><span id="selCompulsoryField" class="clsCompulsoryField">*</span><br />
                     </td>
                     <td>
                        <textarea name="email_address" id="email_address" tabindex="{smartyTabIndex}" rows="5" cols="50">{$myobj->getFormField('email_address')}</textarea>
                        {$myobj->getFormFieldErrorTip('email_address')}
                        {if isMember()}
                                <p class="clsLinkButton"><a id="import_contacts" href="javascript:void(0)" onclick="loadImportContactsLightWindow('{$myobj->share_photo_block.import_contacts_url}', '{$LANG.sharephoto_import_contacts}')">{$LANG.sharephoto_import_contacts}</a></p>
                        {/if}
            		</td>
                    </tr>

                    {if !isMember()}
                    <tr>
                        <td><label for="first_name">{$LANG.sharephoto_first_name}</label><span id="selCompulsoryField" class="clsCompulsoryField">*</span></td>
                        <td><input type="text" name="first_name" class="clsTextBox clsWidth300" id="first_name" value="{$myobj->getFormField('first_name')}" tabindex="{smartyTabIndex}" />
                            {$myobj->getFormFieldErrorTip('first_name')}</td>
                    </tr>
                    {/if}

                    <tr>
                    	<td><label for="personal_message">{$LANG.sharephoto_personal_message}</label></td>
                        <td><textarea name="personal_message" id="personal_message" tabindex="{smartyTabIndex}" rows="5" cols="50">{$myobj->getFormField('personal_message')}</textarea></td>
                    </tr>


                    {if $CFG.admin.photos.captcha AND $CFG.admin.photos.captcha_method =='honeypot'}
                    <tr><td class="" colspan="2">
                            {$myobj->hpSolutionsRayzz()}
                    </td></tr>
                     {/if}

                    {if $CFG.admin.photos.captcha AND $CFG.admin.photos.captcha_method =='image'}
                    <tr>
                    	<td><label for="captcha_value">{$LANG.sharephoto_captcha}</label></label><span id="selCompulsoryField" class="clsCompulsoryField">*</span></td>
                        <td><input type="text" class="clsTextBox clsWidth300" name="captcha_value" id="captcha_value" tabindex="{smartyTabIndex}" maxlength="15" value="" />
                        {$myobj->getFormFieldErrorTip('captcha_value')}
                        <p><img src="{$myobj->captcha_url}" /></p></td>
                    </td>
                    {/if}
                    {if $CFG.admin.photos.captcha AND isAjaxpage()}
                        {if $CFG.admin.photos.captcha_method =='image'}
                        <tr><td><!-- --></td>
                            <td><div class="clsFlagButtonLeft"><div class="clsFlagButtonRight">
                            <input type="button" class="clsSubmitButton" name="send" id="send" value="{$LANG.sharephoto_send}" tabindex="{smartyTabIndex}" onClick="return sendAjaxEmailImage('{$myobj->share_photo_block.send_onclick}', 'selSharePhotoContent');" /></div></div></td>
                        </tr>
                        {elseif $CFG.admin.photos.captcha_method =='honeypot'}
                        <tr><td><!-- --></td>
                            <td><div class="clsFlagButtonLeft"><div class="clsFlagButtonRight">
                            <input type="button" class="clsSubmitButton" name="send" id="send" value="{$LANG.sharephoto_send}" tabindex="{smartyTabIndex}" onClick="return sendAjaxEmailHoneyPot('{$myobj->share_photo_block.send_onclick}', '{$myobj->phFormulaRayzz()}', 'selSharePhotoContent')" /></div></div></td>
                        </tr>
                        {/if}
                    {else}
                        <tr><td><!-- --></td>
                            <td><div class="clsFlagButtonLeft"><div class="clsFlagButtonRight">
                        	<input type="submit" class="clsSubmitButton" name="send" id="send" value="{$LANG.sharephoto_send}" tabindex="{smartyTabIndex}" {if isAjaxPage()} onclick="return sendAjaxEmail('{$myobj->share_photo_block.send_onclick}', 'selSharePhotoContent');" {/if}/></div></div></td>
                        </tr>
                    {/if}
          </table>
        </form>


       </div>
     {/if}

    </div>{include file='box.tpl' opt='flag_bottom'}
{/if}