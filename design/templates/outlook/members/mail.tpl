{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
{if $myobj->isShowPageBlock('block_form_mail') }
<div id="selMsgConfirm" class="clsPopupAlert" style="display:none;">
  <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
    <p id="confirmMessage"></p>
        <!-- clsFormSection - starts here -->
    <div class="clsFormSection">

      <div class="clsFormRow">
        <div class="clsFormFieldCellDefault">
          <input type="submit" class="clsSubmitButton" name="confirm" id="confirm" value="{$LANG.mail_confirm}" tabindex="{smartyTabIndex}" />
          &nbsp;
          <input type="button" class="clsCancelButton" name="cancel" id="cancel" value="{$LANG.mail_cancel}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks('selFormMail');" />
          <input type="hidden" name="message_ids" />
          <input type="hidden" name="action" />
        </div>
      </div>
    </div>
    {$myobj->populateHidden($myobj->msg_confirm_form.msg_confirm_form_hidden_arr)}
    <!-- clsFormSection - ends here -->
  </form>
</div>
{/if}

<div class="clsPageHeading"><h2>{$LANG.mail_page_title}</h2></div>
{include file='../general/information.tpl'}
{if $myobj->isShowPageBlock('block_form_mail') }
	{if $myobj->isShowPageBlock('msg_form_success')}
	  <div id="selMsgSuccess">
		 <p>{$myobj->getCommonSuccessMsg()}</p>
	  </div>
	{/if}
 	{if $CFG.admin.navigation.top}
	  <div class="clsPaddingRightBottom">
    	{include file='../general/pagination.tpl'}
	  </div> 	
   	{/if}
 	
{assign var=count value=1}
<form name="selFormMail" id="selFormMail" method="post" action="{$myobj->getCurrentUrl()}">
<div class="clsDataTable clsMailDataTable">
	<table summary="{$LANG.mail_tbl_summary}">
		<tr>
			<th class="clsCheckBoxTD"><input type="checkbox" class="clsCheckRadio" id="checkall" onclick="selectAll(this.form)" name="checkall" value="" tabindex="{smartyTabIndex}" /></th>
			<th class="clsFromTitle">{$LANG.sender_name_title}</th>
			<th>{$LANG.mail_status}</th>
			<th>{$LANG.mail_subject}</th>
			<th>{$LANG.mail_date}</th>
		</tr>
	{foreach key=inc item=value from=$populateMessages_arr}
		<tr class="{if $count % 2 == 0} clsAlternateRecord{/if}">
			<td>
				<input type="checkbox" class="clsCheckBox" name="message_ids[]" value="{$populateMessages_arr.$inc.from_id}_{$populateMessages_arr.$inc.to_id}_{$populateMessages_arr.$inc.info_id}" tabindex="{smartyTabIndex}" onclick="disableHeading('selFormMail')" />
			</td>
			<td class="clsMailMemberWidth">
				<div class="clsOverflow">
					<p class="clsFloatLeft"><a href="{$populateMessages_arr.$inc.user_profile_url}" class="ClsImageContainer ClsImageBorder2 Cls45x45">
						<img src="{$populateMessages_arr.$inc.user_profiles_icon.s_url}" alt="{$populateMessages_arr.$inc.user_name|truncate:4}" {$myobj->DISP_IMAGE(45, 45, $populateMessages_arr.$inc.user_profiles_icon.s_width, $populateMessages_arr.$inc.user_profiles_icon.s_height)}/>
					</a>
				    </p>
					<p class="clsMailMember" id="selMemberName_{$inc}">
					  <a href="{$populateMessages_arr.$inc.user_profile_url}">{$populateMessages_arr.$inc.display_user_name}</a>
					</p>
				</div>
			</td>
			<td class="clsMailStatusWidth">
				<span class="{$populateMessages_arr.$inc.row_css}">{$populateMessages_arr.$inc.mail_status}</span>
			</td>
			<td>
				<span class="clsMailTitle"><a href="{$populateMessages_arr.$inc.mail_read_link}">{$populateMessages_arr.$inc.subject}</a></span>
			</td>
			<td class="clsMailDateWidth">
				<p>{$populateMessages_arr.$inc.mess_date|date_format:#format_date_year#}</p>
				<p>{$populateMessages_arr.$inc.mess_date|date_format:#format_time#}</p>
			</td>
		</tr>
		{assign var=count value=$count+1}
	 {/foreach}
	</table>
	 <div class="clsOverflow clsDataTableButton">
		<div class="clsMailSelectBox">
			<select name="action" id="action" tabindex="{smartyTabIndex}">
			<option value="">{$LANG.mail_select_action}&nbsp;&nbsp;</option>
			{$myobj->generalPopulateArray($action_arr, $myobj->getFormField('action'))}
			</select>
		</div>			
		<div class="clsSubmitLeft">
			<div class="clsSubmitRight">
				<input type="button" name="mail_action" id="mail_action" onclick="{$mail_action_onclick}" tabindex="{smartyTabIndex}" value="{$LANG.mail_action}" />
			</div>
		</div>
      {if $CFG.admin.navigation.bottom}
      	{include file='../general/pagination.tpl'}
      {/if}
	</div>	
		{$myobj->populateHidden($myobj->msg_confirm_form.selFormMail_hidden_arr)}
		{include file='../general/box.tpl' opt='data_bottom'}
</div>
</form>
  
  {/if}
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
