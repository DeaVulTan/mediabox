<!-- Confirmation message block start-->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
        <p id="confirmMessage"></p>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(false)}">
				<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
				<input type="hidden" name="action" id="action" />
				<input type="hidden" name="id" id="id" />
				<input type="hidden" name="start" id="start" value='{$myobj->getFormField('start')}' />
        </form>
    </div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selInvitationHistory">
		<div class="clsPageHeading"><h2>{$LANG.invitation_history_title}</h2></div>
	{include file='../general/information.tpl'}
	{if ($myobj->isShowPageBlock('form_invite_history'))}
		<div id="selLeftNavigation">
			{if $CFG.admin.navigation.top}
	 			{include file='../general/pagination.tpl'}
			{/if}
			<form id="formInvitaionHistory" name="formInvitationHistory" method="post" action="{$myobj->form_invitaion_history.pageActionUrl}">
							<div class="clsDataTable clsMembersDataTable">
								<table summary="{$LANG.invitation_history_tbl_summary}" id="selInviteHistoryTbl">
									<tr>
                                    	<th class="">
                                        	<input type="checkbox" class="clsCheckRadio" name="history_id_all" id="history_id_all" onClick="checkAll(this.checked)" />
											{foreach key=ssokey item=ssovalue from=$myobj->form_invitaion_history.showPopulateHidden}
												<input type="hidden" name="{$ssovalue.field_name}" value="{$ssovalue.field_value}" />
											{/foreach}
                                        </th>
										<th class="{$myobj->getCSSColumnHeaderCellClass('date_added')}"><a href="{$myobj->form_invitaion_history.dateOrderByUrl}" title="{$myobj->form_invitaion_history.dateOrderByTitle}">{$LANG.invitation_history_date}</a></th>
										<th>{$LANG.invitation_history_attempts}</th>
										<th>{$LANG.invitation_history_email}</th>
										<th>{$LANG.invitation_history_status}</th>
										<th>{$LANG.invitation_history_action}</th>
									</tr>
									{if $myobj->form_invitaion_history.inviteHistory}
										{foreach key=inc item=value from=$myobj->form_invitaion_history.inviteHistory}
											<tr>
												<td>
													{if $value.status!= 'Joined'}
														<input type="checkbox" class="clsCheckRadio" name="history_id[]" value="{$value.check_box_value}" onClick="isCheckedAll()"/>
													{/if}
												</td>
												<td>{$value.date_added|date_format:#format_date_year#}</td>
												<td>{$value.attempts}</td>
												<td class="clsInviteEmail">{$value.email}</td>
												<td class="{$value.class}">{$value.status}</td>
												<td class="clsRemind">
													{if $value.status!= 'Joined'}
														<a id="selRemindLink" href="{$value.remind_url}">{$LANG.invitation_history_individual_remind}</a>&nbsp;|&nbsp;
													{/if}
													<a href="#" onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('id', 'action', 'confirmMessage'), Array('{$value.check_box_value}', 'delete', '{$LANG.common_confirm_delete}'), Array('value', 'value', 'innerHTML'));">{$LANG.invitation_history_individual_delete}</a>
												</td>
											</tr>
								        {/foreach}
							        {else}
								        <tr>
										<td>{$LANG.exturl_no_exturl}</td>
										</tr>
							        {/if}
								</table>
										<div class="clsPadding10 clsOverflow">
											<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" name="remind_submit" id="remind_submit" value="{$LANG.invitation_history_remind_all}" onclick="{literal}if(getMultiCheckBoxValue('formInvitationHistory', 'history_id_all', '{/literal}{$LANG.common_check_atleast_one}{literal}')){return true;}else{return false;}{/literal}" /></div></div>
										</div>
                            </div>
	     	</form>
			{if $CFG.admin.navigation.bottom}
		         {include file='../general/pagination.tpl'}
		    {/if}

			{literal}
			<script language="javascript">
			  function checkAll(chkd){
				chks = document.formInvitationHistory.getElementsByTagName('input');
					for(i=0; i<chks.length; i++){
							if(chks[i].type=='checkbox' && chks[i].name.indexOf('history_id')==0)
							chks[i].checked = chkd;
					}
				}
				function isCheckedAll(){
				chks = document.formInvitationHistory.getElementsByTagName('input');
				var tInput = 0;
				var tChkd = 0;
					for(i=0; i<chks.length; i++){
							if(chks[i].type=='checkbox'  && chks[i].name.indexOf('history_id')==0 && chks[i].name!='history_id_all'){
								tInput += 1;
								tChkd  += chks[i].checked?1:0
							}
						}
				document.formInvitationHistory.history_id_all.checked = (tInput==tChkd);
				}
			</script>
			{/literal}
		</div>
	{/if}
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}