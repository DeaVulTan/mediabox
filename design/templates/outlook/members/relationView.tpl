{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selManageFriends">
<div class="clsPageHeading"><h2>{$LANG.managerelations_title}&nbsp;-&nbsp;{$myobj->getFormField('relation_name')}&nbsp;-&nbsp;<a href="{$myobj->getUrl('membersinvite', '', '', 'members')}">{$LANG.managerelations_title_invite}</a>
</h2></div>
 <!-- confirmation box -->
  <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
	<p id="confirmMessage"></p>
	  <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
		<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
		&nbsp;
		<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
		<input type="hidden" name="relationship_ids" id="relationship_ids" />
        <input type="hidden" name="relationship_id" id="relationship_id" />
		<input type="hidden" name="action" id="action" />
			{$myobj->populateHidden($myobj->paging_arr)}
	  </form>
	</div>
    <!-- confirmation box-->
 <div id="selTwoColumn">
    <div id="selLeftNavigation">

	{include file='../general/information.tpl'}

    {if $myobj->isShowPageBlock('msg_form_info')}
        <div id="selMsgAlert">
            <p>{$LANG.msg_no_friends}</p>
            <p>{$LANG.managerelations_link_add_friends_start}&nbsp;<a href="{$myobj->getUrl('membersinvite', '', '', 'members')}">{$LANG.managerelations_link_add_friends_text}</a>&nbsp;{$LANG.managerelations_link_add_friends_end}</p>
        </div>
    {/if}

    {if $myobj->isShowPageBlock('form_list_friends')}
        {if $myobj->form_list_friends.totalFriends}
            <div id="selShowFriends" class="clsDataTable clsMembersDataTable">
                <form name="form_show_friends" id="selShowFriends" method="post" action="{$myobj->form_list_friends.form_action}" autocomplete="off">
                    <table border = "0" summary="{$LANG.managerelations_tbl_summary}">
                        <tr>
                            <th><input type="checkbox" class="clsCheckRadio" id="check_all" onclick="CheckAll(document.form_show_friends.name, document.form_show_friends.check_all.name)" name="check_all" value="" tabindex="{smartyTabIndex}" /></th>
                            <th>{$LANG.managerelations_friend_name}</th>
                            <th>Action</th>
                        </tr>
      					{foreach item=dmfValue from=$displayMyFriends_arr.row}
                            <tr class="{$myobj->getCSSRowClass()}">
                                <td class="clsFriendsCheckbox"><input type="checkbox" class="clsCheckRadio" name="relationship_id[]" value="{$dmfValue.record.relationship_id}" tabindex="{smartyTabIndex}" onClick="checkCheckBox(this.form, 'checkall');"/></td>
                                <td id="selPhotoGallery" class="clsFriendsNameWidth">
                                    <a class="ClsImageContainer ClsImageBorder2 Cls66x66" href="{$dmfValue.friendProfileUrl}" id="{$myFriendsValue.image_id}" >
                                     <img src="{$dmfValue.icon.s_url}" border="0" alt="{$dmfValue.record.friend_name|truncate:7}" title="{$dmfValue.record.friend_name}" {$myobj->DISP_IMAGE(#image_small_width#, #image_small_height#, $dmfValue.icon.s_width, $dmfValue.icon.s_height)} />
                                	</a>
                                    <p class="clsGroupSmallImg clsBold"><a href="{$dmfValue.friendProfileUrl}">{$dmfValue.record.friend_name}</a></p>
                                </td>
                                <td>
                                <div class="clsListSubmitLeft"><div class="clsListSubmitRight"><input type="button" class="clsSubmitButton" name="removeFriend[{$dmfValue.record.relationship_id}]" value="{$LANG.managerelations_remove}"  onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('relationship_id', 'action', 'confirmMessage'), Array({$dmfValue.record.relationship_id}, 'Remove', '{$LANG.managerelations_select_user_confirm_message}'), Array('value', 'value', 'innerHTML'),'selFormForums');"  /></div></div>
                                </td>
                            </tr>
                        {/foreach}


                        <tr>
                            <td></td><td colspan="2"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="button" class="clsSubmitButton" value="{$LANG.managerelations_remove_selected}" name="removeSelected" id="removeSelected" onClick="getMultiCheckBoxValue('form_show_friends', 'check_all', '{$LANG.managerelations_err_tip_select_titles}');if(multiCheckValue!='') getAction()" /></div></div>
                            <input type="hidden" name="relation" value="{$myobj->getFormField('relation')}" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        {else}
            <div id="selMsgError">
                <p>{$LANG.managerelations_search_msg_no_records}</p>
            </div>
        {/if}
    {/if}
	</div>
</div>
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}