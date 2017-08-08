{if isAjaxpage()}	
	{if $myobj->getFormField('relation_id') == 0}
         <input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" onclick = "CA(document.formContactList.name, document.formContactList.check_all.name)" />
        <label for="check_all">{$LANG.selectusername_check_uncheck}</label><br/>
        {foreach key=inc item=value from=$populateCheckBoxForRelation_arr}
        	{if $populateCheckBoxForRelation_arr.$inc.relation_label}
           <input type="checkbox" class="clsCheckBox" name="relation_arr[]" value="{$populateCheckBoxForRelation_arr.$inc.relation_name}" tabindex="{smartyTabIndex}" onClick="updateEmailList(this)"/>
          <label for="relation_{$populateCheckBoxForRelation_arr.$inc.relation_id}"><b>{$populateCheckBoxForRelation_arr.$inc.relation_label}</b></label>                            
          {/if}
        {/foreach}<br/>
        {foreach key=inc item=value from=$populateCheckBoxForFriendsList_arr}
        	{if $populateCheckBoxForFriendsList_arr.$inc.user_name}
            <input type="checkbox" class="clsCheckBox" name="friends_list[]" value="{$populateCheckBoxForFriendsList_arr.$inc.user_name}" tabindex="{smartyTabIndex}" onClick="updateEmailFriends(this)" id="friend_{$populateCheckBoxForFriendsList_arr.$inc.friend}"/>
            <label for="friend_{$populateCheckBoxForFriendsList_arr.$inc.friend}">{$populateCheckBoxForFriendsList_arr.$inc.user_name}</label>
            {/if}                            
        {/foreach}	    
	{else}    
        {foreach key=inc item=value from=$populateCheckBoxForRelationList_arr.row}
        	{if $value.user_name}
                <input type="checkbox" class="clsCheckBox" name="friends_list[]" value="{$value.user_name}" tabindex="{smartyTabIndex}" onClick="updateEmailFriends(this)" id="friend_{$value.record.friend}"/>
                <label for="friend_{$value.record.friend}">{$value.user_name}</label>
            {/if}
        {/foreach}    
    {/if}        
{else}
    <div>
        <div id="selSelectUsername">
            {$myobj->setTemplateFolder('general/')}
             {include file='box.tpl' opt='popupwithheadingtop_top'}
                  <h2>{$LANG.selectusername_title}</h2>
            {include file='box.tpl' opt='popupheadingtop_bottom'}
            
                {$myobj->setTemplateFolder('general/')}
               {include file='box.tpl' opt='popupwithheadingbottom_top'}
                {if $myobj->isShowPageBlock('msg_form_error')}
                  <div id="selMsgError">
                    <p>{$myobj->getCommonErrorMsg()}</p>
                  </div>
                  {/if}
                {if $myobj->isShowPageBlock('msg_form_success')}
                  <div id="selMsgSuccess">
                    <p>{$myobj->getCommonErrorMsg()}</p>
                    <p><a href="#" onClick="window.close()">{$LANG.selectusername_close}</a></p>
                  </div>
                 {/if}
            
                 {if $myobj->isShowPageBlock('select_username')}
                     <div id="selSelectUsername">
					    <div id="selSelectUserScroll" class="clsSelectUserName">
                                <form name="formContactList" id="formContactList" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                                  <table summary="{$LANG.selectusername_tbl_summary}">
                                    <tr>
                                      <td class="clsFormLabelCellDefault"><span>{$LANG.selectusername_address_book}</span>
                                        <label for="relation_id"><span>{$LANG.selectusername_view}</span></label> </td>
                                      <td class="clsFormFieldCellDefault"> <select name="relation_id" id="relation_id" tabindex="{smartyTabIndex}" onChange="return callAjax('{$select_username_url}'+this.value, 'friends_list')">
                                          <option value="0">{$LANG.selectusername_all_contacts}</option>
                                          {$myobj->generalPopulateArray($populateContactLists, $myobj->getFormField('relation_name'))}
                                        </select> </td>
                                    </tr>
                                    <tr>
                                      <td class="clsFormLabelCellDefault"> <label><span>{$LANG.selectusername_to_friend}</span></label> </td>
                                      <td class="clsFormFieldCellDefault">
                                        <div id="friends_list">
                            {/if}
                                        {if $myobj->getFormField('relation_id')==0}
                                            <input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" onclick = "CA(document.formContactList.name, document.formContactList.check_all.name)" />
                                            <label for="check_all" class="clsPaddingLine">{$LANG.selectusername_check_uncheck}</label><br/>
                                            {foreach key=inc item=value from=$populateCheckBoxForRelation_arr}
                                            	{if $populateCheckBoxForRelation_arr.$inc.relation_label}
                                                   <input type="checkbox" class="clsCheckBox" name="relation_arr[]" value="{$populateCheckBoxForRelation_arr.$inc.relation_name}" tabindex="{smartyTabIndex}" onClick="updateEmailList(this)" id="relation_{$populateCheckBoxForRelation_arr.$inc.relation_id}"/>
                                                  <label for="relation_{$populateCheckBoxForRelation_arr.$inc.relation_id}" class="clsPaddingLine"><b>{$populateCheckBoxForRelation_arr.$inc.relation_label}</b></label>
                                              {/if}                            
                                            {/foreach}<br/>
                                            {foreach key=inc item=value from=$populateCheckBoxForFriendsList_arr}
                                            	{if $populateCheckBoxForFriendsList_arr.$inc.user_name}
                                                <input type="checkbox" class="clsCheckBox" name="friends_list[]" value="{$populateCheckBoxForFriendsList_arr.$inc.user_name}" tabindex="{smartyTabIndex}" onClick="updateEmailFriends(this)" id="friend_{$populateCheckBoxForFriendsList_arr.$inc.friend}"/>
                                                <label for="friend_{$populateCheckBoxForFriendsList_arr.$inc.friend}" class="clsPaddingLine">{$populateCheckBoxForFriendsList_arr.$inc.user_name}</label>                            
                                                {/if}
                                            {/foreach}				
                                        {else}					
                                            {foreach key=inc item=value from=$populateCheckBoxForFriendsList_arr}
                                            	{if $populateCheckBoxForFriendsList_arr.$inc.user_name}
                                                <input type="checkbox" class="clsCheckBox" name="friends_list[]" value="{$populateCheckBoxForFriendsList_arr.$inc.user_name}" tabindex="{smartyTabIndex}" onClick="updateEmailFriends(this)" id="friend_{$populateCheckBoxForFriendsList_arr.$inc.friend}"/>
                                                <label for="friend_{$populateCheckBoxForFriendsList_arr.$inc.friend}" class="clsPaddingLine">{$populateCheckBoxForFriendsList_arr.$inc.user_name}</label>   
                                                {/if}                     
                                            {/foreach}
                                        {/if}
            
                                        </div>
                                    </td>
                                  </tr>
                                    </table>
                                </form>
                                <form name="formEmailList" id="formEmailList" method="post" action="{$myobj->getCurrentUrl()}">
                                  <table summary="{$LANG.selectusername_tbl_summary}">
                                    <tr>
                                      <td class="clsFormLabelCellDefault"> <label for="email_address"><span>{$LANG.selectusername_email_to}</span></label> </td>
                                      <td class="clsFormFieldCellDefault"> <textarea name="email_address" id="email_address" tabindex="{smartyTabIndex}" rows="5" cols="50" >{$myobj->getFormField('email_address')}</textarea>
                                        <br />
                                        {$myobj->populateHidden($myobj->select_username.hidden_fields)}
                                         </td>
                                    </tr>
                                    <tr>
                                    <td class="clsFormLabelCellDefault"></td>
                                      <td class="clsFormFieldCellDefault"> <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="button" class="clsSubmitButton" name="select" id="select" onClick="exit(); return false;" value="{$LANG.selectusername_select}" tabindex="{smartyTabIndex}" /></div></div> </td>
                                    </tr>
                                  </table>
                                </form>
                              </div>
                     </div>
                 {include file='box.tpl' opt='popupwithheadingbottom_bottom'}  
    
        </div>
    </div>
{/if}
{literal}
<script type="text/javascript">
	$Jq('#selSelectUserScroll').jScrollPane({scrollbarWidth:10, scrollbarMargin:10,showArrows:true});
</script>
{/literal}