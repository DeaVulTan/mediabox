{if $myobj->isShowPageBlock('block_checkbox')}
    {if $myobj->isShowPageBlock('populate_checkbox_for_relation')}
    <input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" />
{$LANG.emailsolutions_check_uncheck}<br />
        {foreach item=cbrValue from=$populateCheckBoxForRelation_arr}

            <input type="checkbox" class="clsCheckRadio" name="relation_arr[]" value="{$cbrValue.record.relation_name}" tabindex="{smartyTabIndex}" onClick="updateEmailList(this)" />
            <label><b>{$cbrValue.record.relation_name}({$cbrValue.record.total_contacts})</b></label><br />
        {/foreach}
    {/if}
    {if $myobj->isShowPageBlock('populate_checkbox_for_friend_list')}
    {if !$myobj->isShowPageBlock('populate_checkbox_for_relation')}
    	<input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" />
{$LANG.emailsolutions_check_uncheck}<br />
     {/if}

        {foreach item=cbfValue from=$populateCheckBoxForFriendsList_arr}
            <input type="checkbox" class="clsCheckRadio" name="friends_list[]" value="{$cbfValue.record.user_name}" tabindex="{smartyTabIndex}" onClick="updateEmailFriends(this)" />
            <label>{$cbfValue.record.user_name}</label><br />
        {/foreach}
    {/if}
{elseif $myobj->isShowPageBlock('import_contacts')}
      <div class="clsAddContactsPopUp">
            <h3>{$LANG.emailsolutions_address_book}</h3>
            <form name="formContactList" id="formContactList" method="post" action="{$myobj->getCUrrentUrl(true)}" autocomplete="off">
                <label for="relation_id">{$LANG.emailsolutions_view}</label> <select name="relation_id" id="relation_id" tabindex="{smartyTabIndex}" onChange="return callFriendRelation('{$myobj->relation_onchange}&amp;relation_id='+this.value, 'friends_list');">
                    <option value="0">{$LANG.emailsolutions_all_contacts}</option>
                    {$myobj->populateContactLists()}
                </select>
                <h3>{$LANG.emailsolutions_to_friend}</h3>

                <div id="friends_list">
                    <ul>
                       <li class="clsCheckAllHd"><input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" /> {$LANG.emailsolutions_check_uncheck}</li>

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
        	<div class="clsFlagTitle">{$LANG.emailsolutions_title}</div>
        </div>
    {if isAjaxpage() || $myobj->getFormField('page')=='discussions'}
        {if $myobj->isShowPageBlock('form_success')}
              <div id="selMsgSuccess">
                <p>{$myobj->getCommonSuccessMsg()}</p>
              </div>
        {/if}
    {else}
        {if $myobj->isShowPageBlock('form_success')}
        	{if $myobj->getFormField('page') == 'discussions'}
              <div id="selMsgSuccess">
                <p>{$myobj->getCommonSuccessMsg()}</p>
              </div>
            {else}
              <div id="selMsgSuccess">
                <p>{$myobj->getCommonSuccessMsg()} <span><a href="javascript:void(0);" onClick="window.close()">{$LANG.emailsolutions_close}</a></span></p>
              </div>
            {/if}
        {/if}
    {/if}

    {$myobj->setTemplateFolder('general/')}
    {include file='information.tpl'}

    {if $myobj->isShowPageBlock('share_board_block')}
        <div id="selMsgError" style="display:none;">
            <p id="commentSelMsgError"></p>
        </div><br />
        <div id="selSharePhoto" class="clsFlagTable clsSharePhotoHeading">
          <form name="formEmailList" id="formEmailList" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off">
            <table summary="{$LANG.emailsolutions_tbl_summary}" class="clsEmailPopuptable">
                <tr><td colspan="2"><h3>{$LANG.emailsolutions_email_to}</h3></td></tr>
                <tr>
                    <td class="clsTDLabelwidth">
                        <label for="email_address">{$LANG.emailsolutions_email_addres}</label><span id="selCompulsoryField" class="clsCompulsoryField">*</span><br />
                     </td>
                     <td>
                        <textarea name="email_address" id="email_address" tabindex="{smartyTabIndex}" rows="5" cols="50">{$myobj->getFormField('email_address')}</textarea>
                        {$myobj->getFormFieldErrorTip('email_address')}
                        {if isMember()}
                                <p class="clsLinkButton"><a id="import_contacts" href="javascript:void(0)" onclick="loadImportContactsLightWindow('{$myobj->share_board_block.import_contacts_url}', '{$LANG.emailsolutions_import_contacts}')">{$LANG.emailsolutions_import_contacts}</a></p>
                        {/if}
            		</td>
                    </tr>

                    {if !isMember()}
                    <tr>
                        <td><label for="first_name">{$LANG.emailsolutions_first_name}</label><span id="selCompulsoryField" class="clsCompulsoryField">*</span></td>
                        <td><input type="text" name="first_name" class="clsTextBox clsWidth300" id="first_name" value="{$myobj->getFormField('first_name')}" tabindex="{smartyTabIndex}" />
                            {$myobj->getFormFieldErrorTip('first_name')}</td>
                    </tr>
                    {/if}

                    <tr>
                    	<td><label for="personal_message">{$LANG.emailsolutions_personal_message}</label></td>
                        <td><textarea name="personal_message" id="personal_message" tabindex="{smartyTabIndex}" rows="5" cols="50">{$myobj->getFormField('personal_message')}</textarea></td>
                    </tr>

                    <tr><td><!-- --></td>
                        <td><p class="clsButton"><span>
                        <input type="submit" class="clsSubmitButton" name="send" id="send" value="{$LANG.emailsolutions_send}" tabindex="{smartyTabIndex}" {if isAjaxPage()} onclick="return sendAjaxEmail('{$myobj->share_board_block.send_onclick}', 'selSharePhotoContent');" {/if}/></span></p></td>
                    </tr>
          </table>
        </form>


       </div>
     {/if}

    </div>{include file='box.tpl' opt='flag_bottom'}
{/if}