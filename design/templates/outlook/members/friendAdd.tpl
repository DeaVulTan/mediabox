{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
	<div id="selFormAddFriend">
		<div class="clsPageHeading"><h2>{$LANG.addfriend_title}</h2></div>
{if  $myobj->isShowPageBlock('form_member_blocked')}
    <div id="selMsgAlert">
        <p>{$LANG.addfriend_msg_blocked}&nbsp;<a href="{$myobj->form_member_blocked.memberProfileUrl}">{$myobj->getFormField('friend_name')}</a></p>
        <p class="clsMsgAdditionalText">{$LANG.addfriend_msg_blocked_hint}</p>
        <p class="clsMsgAdditionalText"><a href="{$myobj->form_member_blocked.memberblock_url}">{$LANG.addfriend_link_unblock}&nbsp;{$myobj->getFormField('friend_name')}</a></p>
        <p class="clsMsgAdditionalText"><a href="{$myobj->getUrl('memberblock', '', '', 'members')}">{$LANG.addfriend_link_block_list}</a></p>
    </div>
{/if}

	{include file='../general/information.tpl'}

{if  $myobj->isShowPageBlock('form_confirmation')}
		<form id="formAddFriend" name="formAddFriend" method="post" action="{$myobj->getUrl('friendadd', '', '', 'members')}">
		<div class="clsPadding10">
			<p class="clsBold">{$LANG.addfriend_msg_1}<span class="clsUser">{$myobj->getFormField('friend_name')}</span>{$LANG.addfriend_msg_2}</p>
			<div class="clsDataTable">
            <table>
				<tr>
					<td id="selPhotoGallery">
                        <div class="clsOverflow">
							<a class="ClsImageContainer ClsImageBorder1 Cls90x90" href="{$myobj->form_confirmation_arr.user_details.profile_url}"><img src="{$myobj->form_confirmation_arr.icon.t_url}" alt="{$myobj->getFormField('friend_name')|truncate:9}"  title="{$myobj->getFormField('friend_name')}" {$myobj->DISP_IMAGE(#image_thumb_width#, #image_thumb_height#, $myobj->form_confirmation_arr.icon.t_width, $myobj->form_confirmation_arr.icon.t_height)} /></a>
                        </div>
                        <p><a href="{$myobj->form_confirmation_arr.user_details.profile_url}">{$myobj->getFormField('friend_name')}</a></p>
					</td>
				</tr>
				<tr>
					<td>
						({$LANG.addfriend_optional_message})<br/>
						<textarea class="clsAddFriendsTextArea selInputLimiter" rows="4" cols="40" id="user_message" name="user_message" maxlimit="{$CFG.fieldsize.friendadd.description}">{$myobj->getFormField('user_message')}</textarea>
						<input type="hidden" name="backUrl" value="{$myobj->getFormField('backUrl')}" />
						<input type="hidden" name="friend_name" value="{$myobj->getFormField('friend_name')}" />
						<input type="hidden" name="friend" value="{$myobj->getFormField('friend')}" />
					</td>
				</tr>
				<tr>
					<td>
						<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="confirmSubmit" id="confirmSubmit" value="{$LANG.addfriend_submit_send}" /></div></div><div class="clsCancelLeft clsMarginLeft5"><div class="clsCancelRight"><input type="submit" class="clsSubmitButton" name="cancel" id="cancel" value="{$LANG.addfriend_submit_cancel}" /></div></div></td>
				</tr>
			</table>
            </div>
		</div>
		</form>
	</div>
{/if}
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}