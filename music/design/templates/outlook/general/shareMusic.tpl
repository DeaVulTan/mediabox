{if $myobj->isShowPageBlock('block_checkbox')}
    {if $myobj->isShowPageBlock('populate_checkbox_for_relation')}
    <input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" />
{$LANG.sharemusic_check_uncheck}<br />
        {foreach item=cbrValue from=$populateCheckBoxForRelation_arr}

            <input type="checkbox" class="clsCheckRadio" name="relation_arr[]" value="{$cbrValue.record.relation_name}" tabindex="{smartyTabIndex}" onClick="updateEmailList(this)" />
            <label><b>{$cbrValue.record.relation_name}({$cbrValue.record.total_contacts})</b></label><br />
        {/foreach}
    {/if}
    {if $myobj->isShowPageBlock('populate_checkbox_for_friend_list')}
    {if !$myobj->isShowPageBlock('populate_checkbox_for_relation')}
    	<input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" />
{$LANG.sharemusic_check_uncheck}<br />
     {/if}

        {foreach item=cbfValue from=$populateCheckBoxForFriendsList_arr}
            <input type="checkbox" class="clsCheckRadio" name="friends_list[]" value="{$cbfValue.record.user_name}" tabindex="{smartyTabIndex}" onClick="updateEmailFriends(this)" />
            <label>{$cbfValue.record.user_name}</label><br />
        {/foreach}
    {/if}
{elseif $myobj->isShowPageBlock('import_contacts')}
      <div class="clsAddContactsPopUp">
            <h3>{$LANG.sharemusic_address_book}</h3>
            <form name="formContactList" id="formContactList" method="post" action="{$myobj->getCUrrentUrl(true)}" autocomplete="off">
                <label for="relation_id">{$LANG.sharemusic_view}</label> <select name="relation_id" id="relation_id" tabindex="{smartyTabIndex}" onChange="return callFriendRelation('{$myobj->relation_onchange}&amp;relation_id='+this.value, 'friends_list');">
                    <option value="0">{$LANG.sharemusic_all_contacts}</option>
                    {$myobj->populateContactLists()}
                </select>
                <h3>{$LANG.sharemusic_to_friend}</h3>

                <div id="friends_list">
                    <ul>
                       <li><input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" /> {$LANG.sharemusic_check_uncheck}</li>

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
    <div id="selShareMusicBody">
    {if $myobj->getFormField('page') != 'music' and $myobj->getFormField('page') != 'sharemusic'}
<!--      <div class="clsOverflow">
        <div class="clsShareTitle">{$LANG.sharemusic_title}</div>
        <div class="clsShareFlag"><a title="close" onClick="hideMusicSection('shareDiv','clsDisplayNone')">{$LANG.music_close}</a></div>
      </div>
-->    {/if}

    {if isAjaxpage() || $myobj->getFormField('page')=='music'}
        {if $myobj->isShowPageBlock('form_success')}
              <div id="selMsgSuccess">
                <p>{$myobj->getCommonSuccessMsg()}</p>
              </div>
        {/if}
    {else}
        {if $myobj->isShowPageBlock('form_success')}
        	{if $myobj->getFormField('page') == 'music'}
              <div id="selMsgSuccess">
                <p>{$myobj->getCommonSuccessMsg()}</p>
              </div>
            {else}
              <div id="selMsgSuccess">
                <p>{$myobj->getCommonSuccessMsg()} <span><a href="javascript:void(0);" onClick="window.close()" title="{$LANG.sharemusic_close}">{$LANG.sharemusic_close}</a></span></p>
              </div>
            {/if}
        {/if}
    {/if}

	{$myobj->setTemplateFolder('general/','music')}
    {include file='information.tpl'}

    {if $myobj->isShowPageBlock('share_music_block')}
        <div id="selMsgError" style="display:none;">
            <p id="commentSelMsgError"></p>
        </div>
        <div id="selShareMusic" class="clsFormTable">
            <form name="formEmailList" id="formEmailList" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off">
            <table summary="{$LANG.sharemusic_tbl_summary}">
                <tr>
                    <td colspan="2">
                      <h3>{$LANG.sharemusic_email_to}</h3>
                    </td>
                <tr>
                	  <td>
                            <label for="email_address">{$LANG.sharemusic_email_addres}</label><span id="selCompulsoryField">*</span>{$LANG.sharemusic_email_separated_values}
                              {if isMember()}
                                <br />{$LANG.sharemusic_or}
                                <p><a id="import_contacts" href="javascript:void(0)" onclick="loadImportContactsLightWindow('{$myobj->share_music_block.import_contacts_url}', '{$LANG.sharemusic_import_contacts}')" title="{$LANG.sharemusic_import_contacts}">{$LANG.sharemusic_import_contacts}</a></p>
                  	      {/if}
                    </td>
                    <td>
                            <textarea name="email_address" id="email_address" tabindex="{smartyTabIndex}" rows="5" cols="50">{$myobj->getFormField('email_address')}</textarea>
                            {$myobj->getFormFieldErrorTip('email_address')}
                    </td>
                </tr>
              {if !isMember()}
                <tr>
                	  <td>
                              <label for="first_name">{$LANG.sharemusic_first_name}</label><span id="selCompulsoryField">*</span>
                    </td>
                    <td>
                            <input type="text" name="first_name" id="first_name" value="{$myobj->getFormField('first_name')}" tabindex="{smartyTabIndex}" />
                            {$myobj->getFormFieldErrorTip('first_name')}
                    </td>
                </tr>
              {/if}
			<tr>
                     <td>
                        <label for="personal_message">{$LANG.sharemusic_personal_message}</label>
                     </td>
                     <td>
                        <textarea name="personal_message" id="personal_message" tabindex="{smartyTabIndex}" rows="5" cols="50">{$myobj->getFormField('personal_message')}</textarea>
                        {if $CFG.admin.musics.captcha AND $CFG.admin.musics.captcha_method =='honeypot'}
                            {$myobj->hpSolutionsRayzz()}
                        {/if}
                     </td>
                  </tr>
                  {if $CFG.admin.musics.captcha AND $CFG.admin.musics.captcha_method =='image'}
                        <tr>
                           <td>
                              <label for="captcha_value">{$LANG.sharemusic_captcha}</label></label><span id="selCompulsoryField">*</span>
                           </td>
                           <td>
                              <input type="text" class="clsTextBox" name="captcha_value" id="captcha_value" tabindex="{smartyTabIndex}" maxlength="15" value="" />
                              {$myobj->getFormFieldErrorTip('captcha_value')}
                              <img src="{$myobj->captcha_url}" />
                           </td>
                         </td>
                  {/if}
			<tr style="display:none" id="share_loader_row">    <td><!----></td>
                  	<td>
                              <div id="share_submitted"></div>
                        </td>
                  </tr>
			<tr>    <td><!----></td>
                  	<td>
                        {if $CFG.admin.musics.captcha AND isAjaxpage()}
                            {if $CFG.admin.musics.captcha_method =='image'}
                                <p class="clsButton"><span>
	                            <input type="button" class="clsSubmitButton" name="send" id="send" value="{$LANG.sharemusic_send}" tabindex="{smartyTabIndex}" onClick="return sendAjaxEmailImage('{$myobj->share_music_block.send_onclick}', 'shareDiv');" /></span></p>
                            {elseif $CFG.admin.musics.captcha_method =='honeypot'}
                                <p class="clsButton"><span>
	                            <input type="button" class="clsSubmitButton" name="send" id="send" value="{$LANG.sharemusic_send}" tabindex="{smartyTabIndex}" onClick="return sendAjaxEmailHoneyPot('{$myobj->share_music_block.send_onclick}', '{$myobj->phFormulaRayzz()}', 'shareDiv')" /></span></p>
                            {/if}
                        {else}
                            <p class="clsButton"><span>
                            <input type="submit" class="clsSubmitButton" name="send" id="send" value="{$LANG.sharemusic_send}" tabindex="{smartyTabIndex}" {if isAjaxPage()} onclick="return sendAjaxEmail('{$myobj->share_music_block.send_onclick}', 'shareDiv');" {/if}/>
                            </span></p>
                        {/if}
                		</td>
	            </tr>
          </table>
        </form>
       </div>
     {/if}

    </div>
{/if}
