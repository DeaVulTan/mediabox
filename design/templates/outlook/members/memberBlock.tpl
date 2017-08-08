{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selMemberBlockFormHandler">
   <div class="clsPageHeading"><h2>{$LANG.memberblock_title}</h2></div>
   	{if isMember()}
     <div class="clsPaddingLeftRight">
	   	<p class="clsBrowseMemberLink">
	   	<a href="{$myobj->getUrl('memberslist')}" class="selMemberBrowseLinkID">{$LANG.common_members_list_list_members}</a>
	   	<a href="{$myobj->getUrl('membersbrowse')}" class="selMemberBrowseLinkID">{$LANG.common_members_list_browse_members}</a>
   		</p>
   </div>
   {/if}

      {if !$myobj->isResultsFound()}
		<div class="clsNoteMessage">
              <span class="clsNoteTitle">{$LANG.memberblock_note}</span>:&nbsp;{$LANG.memberblock_info}&nbsp;{$LANG.memberblock_info1}
            </div>
      {/if}

    <!-- confirmation box -->
    <div id="selMsgConfirm" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getUrl('memberblock')}">
			<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
			&nbsp;
			<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onclick="return hideAllBlocks('selFormForums');" />
			<input type="hidden" name="block_ids" id="block_ids" />
            <input type="hidden" name="block_id" id="block_id" />
			<input type="hidden" name="action" id="action" />
            {if $myobj->isShowPageBlock('form_block_listing')}
				{$myobj->populateHidden($myobj->paging_arr)}
            {/if}
		</form>
	</div>
    <!-- confirmation box-->
 	{include file='../general/information.tpl'}
    {if $myobj->isShowPageBlock('msg_form_success_block_unblock') AND isset($myobj->success_msg) AND $myobj->success_msg}
		  <div id="selMsgSuccess">
		   	<p>{$myobj->success_msg}</p>
			<p class="clsMsgAdditionalText"><a href="{$myobj->msg_form_success_block_unblock.blockUserProfileUrl}">{$LANG.memberblock_back_profile}</a></p>
		  </div>
	{/if}
    {if $myobj->isShowPageBlock('msg_form_success_unblock')}
        <div id="selMsgSuccess">
            <p>{$LANG.memberblock_unblock_success}</p>
        </div>
	{/if}
	{if  $myobj->isShowPageBlock('form_block') && $myobj->getFormField('block_id')}
        <div class="clsMsgConfirmation"><div class="clsMsgConfirm">
            <p>
           		{$myobj->form_block.nl2br_user_name}
            </p>
                <form name="form_block" id="formAddToGroup" method="post" action="{$myobj->getUrl('memberblock')}" autocomplete="off">
                    <table summary="{$LANG.memberblock_tbl_summary}" >
                        <tr>
                        <td>
                        {if $myobj->alreadyBlocked()}
                        	<input type="button" class="clsSubmitButton" name="Unblock" id="Unblock" value="{$LANG.memberblock_unblock}" tabIndex="{smartyTabIndex}"  onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('block_id', 'action', 'confirmMessage'), Array(document.form_block.block_id.value, 'Unblock', '{$LANG.memberblock_unblock_confirm_message}'), Array('value', 'value', 'html'),'selFormForums');"  />
                        {else}
                        	<input type="button" class="clsSubmitButton" name="Block" id="Block" value="{$LANG.memberblock_block}" tabIndex="{smartyTabIndex}" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('block_id', 'action', 'confirmMessage'), Array(document.form_block.block_id.value, 'Block', '{$LANG.memberblock_block_confirm_message}'), Array('value', 'value', 'html'),'selFormForums');" />
                        {/if}
                        &nbsp;&nbsp;
                        <a href="{$myobj->form_block.blockUserProfileUrl}"><input type="submit" class="clsSubmitButton" name="cancel" id="cancel" value="{$LANG.memberblock_cancel}" tabIndex="{smartyTabIndex}"  /></a>
                        </td>
                        </tr>
                    </table>
                	<input type="hidden" name="block_id" value="{$myobj->getFormField('block_id')}" />
                </form>
        </div></div>
	{/if}
    {if $myobj->isShowPageBlock('form_block_listing')}
    	{if $myobj->isResultsFound()}
            {if $CFG.admin.navigation.top}
                {$myobj->setTemplateFolder('general/')}
                {include file='../general/pagination.tpl'}
            {/if}

            <form name="formBlockedMembers" id="formBlockedMembers" method="post" action="{$myobj->getUrl('memberblock')}">
           	{assign var='table_header' value='1'}
            {assign var='i' value='0'}
			{assign var=count value=1}
            	{foreach key=inc item=value from=$myobj->form_block_listing.showBlockList.row}
                	{if $table_header}
                    	<div class="clsDataTable clsMembersDataTable clsPaddingTop9">
                        <table summary="{$LANG.blocklist_tbl_summary}" class="clsMyPhotoAlbumTbl">
                            <tr>
                                <th class="clsWidth20"><input type="checkbox" class="clsCheckRadio" onclick="CheckAll(document.formBlockedMembers.name, document.formBlockedMembers.check_all.name)" name="check_all" id="check_all" value="" tabindex="{smartyTabIndex}" /></th>
                                <th colspan="2">{$LANG.blocklist_details}</th>
                            </tr>
                          {assign var='table_header' value='0'}
                     {/if}
                     <tr class="{if $count % 2 == 0} clsAlternateRecord{/if}">
							<td class="clsWidth20"><input type="checkbox" class="clsCheckRadio" name="block_ids[]" value="{$value.record.id}" tabindex="{smartyTabIndex}" onclick="disableHeading('formBlockedMembers');"/></td>
							<td class="clsUserThumImagetd selPhotoGallery">
                            <div class="clsOverflow">
								{if $value.icon}
									<div class="clsThumbImageContainer clsMemberImageContainer clsFloatLeft">
                                    	<div class="clsThumbImageContainer">
                                        	<a class="ClsImageContainer ClsImageBorder2 Cls66x66" href="{$value.getMemberProfileUrl}">
                                       			<img src="{$value.icon.s_url}" alt="{$value.record.user_name|truncate:7}" {$myobj->DISP_IMAGE(#image_small_width#, #image_small_height#, $value.icon.s_width, $value.icon.s_height)} />
											</a>
                                        </div>
									</div>
                                {/if}
								<p class="selMemberName clsGroupSmallImg clsFloatLeft">
									<a href="{$value.getMemberProfileUrl}">
										{$value.name}
									</a>
								</p>
                             </div>								
							</td>
							<td>
							 <div class="clsBlockedList">
								<p><span>{$LANG.blocklist_name}</span>{$value.record.first_name}&nbsp;{$value.record.last_name}</p>
								<p><span>{$LANG.blocklist_date_added}</span>{$value.record.date_added|date_format:#format_date_year#}</p>
							 </div>	
							</td>
						</tr>
							{assign var=count value=$count+1}
                        	{counter  assign=i}
                       {/foreach}
						</table>
                       {if !$i}
                           <div id="selMsgAlert">
                                <p>{$LANG.blocklist_no_blocks}</p>
                            </div>
                       {else}
                       		<div class="clsOverflow">
				            	<div class="{$myobj->getCSSFormFieldCellClass('unblock')} clsPadding10">
							  		<input type="hidden" name="start" value="{$myobj->getFormField('start')}" />
                                    <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="button" class="clsSubmitButton" name="blocklist_unblock" id="blocklist_unblock" tabindex="{smartyTabIndex}" value="{$LANG.blocklist_unblock}" onclick="getMultiCheckBoxValue('formBlockedMembers', 'check_all', '{$LANG.memberblock_err_tip_select_titles}');if(multiCheckValue!='') getAction()" /> </div></div>
									{*<!--&nbsp;&nbsp;
									<input type="submit" class="clsSubmitButton" name="blocklist_cancel" id="blocklist_cancel" tabindex="{smartyTabIndex}" value="{$LANG.blocklist_cancel}" />  -->*}							</div>
				            </div>
                        </div>
                       {/if}

            </form>

            {if $CFG.admin.navigation.bottom}
                {$myobj->setTemplateFolder('general/')}
                {include file='pagination.tpl'}
            {/if}

        {else}
        	<div id="selMsgAlert">
				<p>{$LANG.memberblock_no_blocked_member} </p>
			</div>
		{/if}
    {/if}
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}