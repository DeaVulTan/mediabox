{if $myobj->isShowPageBlock('block_checkbox')}
	{if $myobj->isShowPageBlock('populate_checkbox_for_relation')}
    	{foreach item=cbrValue from=$populateCheckBoxForRelation_arr}
        	<input type="checkbox" class="clsCheckRadio" name="relation_arr[]" value="{$cbrValue.record.relation_name}" tabindex="{smartyTabIndex}" onClick="updateEmailList(this)" />
            <label><b>{$cbrValue.record.relation_name}({$cbrValue.record.total_contacts})</b></label><br />
        {/foreach}
    {/if}
    {if $myobj->isShowPageBlock('populate_checkbox_for_friend_list')}
    	{if !$myobj->isShowPageBlock('populate_checkbox_for_relation')}
    		<input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" />
			{$LANG.sharearticle_check_uncheck}<br />
    	{/if}
        {foreach item=cbfValue from=$populateCheckBoxForFriendsList_arr}
            <input type="checkbox" class="clsCheckRadio" name="friends_list[]" value="{$cbfValue.record.user_name}" tabindex="{smartyTabIndex}" onClick="updateEmailFriends(this)" />
            <label>{$cbfValue.record.user_name}</label><br />
        {/foreach}
    {/if}
{elseif $myobj->isShowPageBlock('import_contacts')}
	<div class="clsAddContactsPopUp">
    	<h3>{$LANG.sharearticle_address_book}</h3>
        <form name="formContactList" id="formContactList" method="post" action="{$myobj->getCUrrentUrl(true)}" autocomplete="off">
        	<label for="relation_id">{$LANG.sharearticle_view}</label>
			<select name="relation_id" id="relation_id" tabindex="{smartyTabIndex}" onChange="return callFriendRelation('{$myobj->relation_onchange}&amp;relation_id='+this.value, 'friends_list');">
            	<option value="0">{$LANG.sharearticle_all_contacts}</option>
                {$myobj->populateContactLists()}
            </select>
            <h3>{$LANG.sharearticle_to_friend}</h3>
            <div id="friends_list">
            	<ul>
                	<li><input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CA(document.formContactList.name, document.formContactList.check_all.name)" /> {$LANG.sharearticle_check_uncheck}</li>
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
    <div id="selShareArticleBody" class="clsFlagDetails">
        <div class="clsOverflow clsFlagTitle">
        <h2>{$LANG.sharearticle_title}</h2>
    {if isAjaxpage()}
        <div id="cancel"><a href="javascript:void(0);" onClick="return close_ajax_div('email_content_tab');">{$LANG.sharearticle_cancel}</a></div>
       </div>
        <div class="clsFlagInfo">{if $myobj->isShowPageBlock('form_success')}
              <div id="selMsgSuccess">
                <p>{$myobj->getCommonSuccessMsg()}</p>
              </div>
        {/if}
    {else}
        {if $myobj->isShowPageBlock('form_success')}
              <div id="selMsgSuccess">
                <p>{$myobj->getCommonSuccessMsg()} <span><a href="javascript:void(0);" onClick="window.close()">{$LANG.sharearticle_close}</a></span></p>
              </div>
        {/if}  </div>
    {/if}

    {$myobj->setTemplateFolder('general/','article')}
    {include file='information.tpl'}

    {if $myobj->isShowPageBlock('share_article_block')}
        <div id="selShareArticle" class="clsFormTable">
            <form name="formEmailList" id="formEmailList" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off">
            <table summary="{$LANG.sharearticle_tbl_summary}">
                <tr>
                    <td colspan="2"><h3>{$LANG.sharearticle_email_to}</h3></td>
                </tr>
                <tr>
                	<td>
                    	<label for="email_address">{$LANG.sharearticle_email_addres}</label>{$LANG.sharearticle_email_separated_values}<span id="selCompulsoryField" class="clsMandatoryFieldIcon">*</span>
                        {if isMember()}
                        	<br />&nbsp;&nbsp;{$LANG.sharearticle_or}
                  	    {/if}
                    </td>
                    <td>
                        <textarea name="email_address" id="email_address" tabindex="{smartyTabIndex}" rows="5" cols="50">{$myobj->getFormField('email_address')}</textarea>
                        {$myobj->getFormFieldErrorTip('email_address')}
						{if isMember()}
                        	<p class="clsLinkButton"><a id="import_contacts" href="javascript:void(0)" onclick="loadImportContactsLightWindow('{$myobj->share_article_block.import_contacts_url}', '{$LANG.sharearticle_import_contacts}')">{$LANG.sharearticle_import_contacts}</a></p>
						{/if}
                    </td>
                </tr>
	            {if !isMember()}
	            	<tr>
	                	<td>
	                    	<label for="first_name">{$LANG.sharearticle_first_name}</label><span id="selCompulsoryField" class="clsMandatoryFieldIcon">*</span>
	                    </td>
	                    <td>
	                    	<input type="text" name="first_name" id="first_name" value="{$myobj->getFormField('first_name')}" tabindex="{smartyTabIndex}" />
	                        {$myobj->getFormFieldErrorTip('first_name')}
	                    </td>
	                </tr>
	            {/if}
				<tr>
                	<td><label for="personal_message">{$LANG.sharearticle_personal_message}</label></td>
                    <td>
                    	<textarea name="personal_message" id="personal_message" tabindex="{smartyTabIndex}" rows="5" cols="50">{$myobj->getFormField('personal_message')}</textarea>
                        {if $CFG.admin.articles.captcha AND $CFG.admin.articles.captcha_method =='honeypot'}
                            {$myobj->hpSolutionsRayzz()}
                        {/if}
                    </td>
                </tr>
                {if $CFG.admin.articles.captcha_method =='image'}
                	<tr>
                    	<td>
                        	<label for="captcha_value">{$LANG.sharearticle_captcha}</label></label><span id="selCompulsoryField" class="clsMandatoryFieldIcon">*</span>
                        </td>
                        <td>
                        	<input type="text" class="clsTextBox" name="captcha_value" id="captcha_value" tabindex="{smartyTabIndex}" maxlength="15" value="" /><br/>
                            {$myobj->getFormFieldErrorTip('captcha_value')}
                            <img src="{$myobj->captcha_url}" />
                        </td>
                {/if}
				<tr style="display:none" id="share_loader_row">    <td><!----></td>
	                <td>
	                	<div id="share_submitted"></div>
	                 </td>
                </tr>
				<tr>
					<td><!----></td>
                  	<td>
                        {if $CFG.admin.articles.captcha AND isAjaxpage()}
                            {if $CFG.admin.articles.captcha_method =='image'}
                                <p class="clsButton"><span>
	                            <input type="button" class="clsSubmitButton" name="send" id="send" value="{$LANG.sharearticle_send}" tabindex="{smartyTabIndex}" onClick="return sendAjaxEmailImage('{$myobj->share_article_block.send_onclick}', 'selShareArticleBody');" /></span></p>
                            {elseif $CFG.admin.articles.captcha_method =='honeypot'}
                                <p class="clsButton"><span>
	                            <input type="button" class="clsSubmitButton" name="send" id="send" value="{$LANG.sharearticle_send}" tabindex="{smartyTabIndex}" onClick="return sendAjaxEmailHoneyPot('{$myobj->share_article_block.send_onclick}', '{$myobj->phFormulaRayzz()}', 'selShareArticleBody')" /></span></p>
                            {/if}
                        {else}
                            <p class="clsButton"><span>
                            <input type="submit" class="clsSubmitButton" name="send" id="send" value="{$LANG.sharearticle_send}" tabindex="{smartyTabIndex}" {if isAjaxPage()} onclick="return sendAjaxEmail('{$myobj->share_article_block.send_onclick}', 'selShareArticleBody');" {/if}/>
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

