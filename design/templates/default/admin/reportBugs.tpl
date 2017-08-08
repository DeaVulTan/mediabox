{literal}
	<script type="text/javascript" language="javascript">
		var block_arr= new Array('selMsgConfirm', 'selDelInfoconfirm');
		var bug_id = '';
		var confirm_message = '';
		function getAction()
			{
				var act_value = document.selListStaticForm.action.value;
				if(act_value)
					{
						switch(act_value)
							{
								case '{/literal}{$LANG.bug_close}{literal}':
									confirm_message = '{/literal}{$LANG.confirm_close}{literal}';
								break;
							}
						$Jq('#msgConfirmText').html(confirm_message);
						document.msgConfirmform.action.value = act_value;
						document.msgConfirmform.act.value = '';
						Confirmation('selMsgConfirm', 'msgConfirmform', Array('bug_ids'), Array(multiCheckValue), Array('value'),'selListStaticForm');
					}
			}
		function postBugReply(url, pars, txt_id, bid)
			{
				var message = $Jq('#'+txt_id).val();
				$Jq('#reply_bugs_'+bid).attr('disabled', 'true');
				pars += '&message='+escape(message);
				$Jq.ajax({
					type: "POST",
					url: url,
					data: pars,
					success: function(response){
						result = response.split('|');
						if(result[0] == 'success')
							{
								$Jq('#msgreplySpanID_'+bid).hide();
								$Jq('#user_reply_'+bid).val('');
								$Jq('#trBugs_'+bid).html(result[1]);
							}
						else if(result[0] == 'error')
							{
								$Jq('#msgreplySpanID_'+bid).html(result[1]);
							}
					}
				 });
				return false;
			}
		</script>
{/literal}
<div id="selMsgConfirm" style="display:none;">
	<p id="msgConfirmText"></p>
	<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCUrrentUrl()}" autocomplete="off">
		<table class="clsCommonTable" summary="{$LANG.member_tbl_summary}">
			<tr>
				<td>
					<input type="submit" class="clsSubmitButton" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
					&nbsp;
					<input type="button" class="clsCancelButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks('selListStaticForm')" />
				</td>
			</tr>
		</table>
        <input type="hidden" name="act" id="act" />
        <input type="hidden" name="bug_ids" id="bug_ids" />
        <input type="hidden" name="action" id="action" />
		{$myobj->populateHidden($myobj->list_records_confirm_arr)}
	</form>
</div>
<div id="selReportBugs">
	<h2>{$LANG.reportbugs_title}</h2>
	<div class="clsCommonInsideContent clsAdminReportBugs">
		{$myobj->setTemplateFolder('admin/')}
		    {include file='information.tpl'}

			{if $myobj->isShowPageBlock('block_reportbugs')}
				<form name="form_reportbugs_show" id="form_reportbugs_show" method="post" action="{$myobj->getCurrentUrl()}">
					<!-- clsFormSection - starts here -->
					<table class="clsFormTbl">
						<tr class="clsFormRow">
							<td class="{$myobj->getCSSFormLabelCellClass('subject')}">
								{$myobj->displayCompulsoryIcon()}
								<label for="subject">{$LANG.reportbugs_subject}</label>
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('subject')}">
								<select name="subject" id="subject" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('subject')}">
									{$myobj->generalPopulateArray($bug_list_array, $myobj->getFormField('subject'))}
								</select>
								{$myobj->getFormFieldErrorTip('subject')}
							</td>
						</tr>
						<tr class="clsFormRow">
							<td class="{$myobj->getCSSFormLabelCellClass('message')}">
								{$myobj->displayCompulsoryIcon()}
								<label for="message">{$LANG.reportbugs_message}&nbsp;</label>
							</td>
							<td class="{$myobj->getCSSFormFieldCellClass('message')}">
								<textarea name="message" id="message" tabindex="{smartyTabIndex}" rows="4" cols="45">{$myobj->getFormField('message')}</textarea>
								{$myobj->getFormFieldErrorTip('message')}
							</td>
						</tr>
						<tr class="clsFormRow">
							<td class="clsButtonAlignment {$myobj->getCSSFormFieldCellClass('default')}"></td>
							<td>
								<input type="submit" class="clsSubmitButton" name="submit_reportbugs" id="submit_reportbugs" value="{$LANG.reportbugs_submit}" tabindex="{smartyTabIndex}" />
							</td>
						</tr>
					</table>
					<!-- clsFormSection - ends here -->
				</form>
			{/if}
			<div class="clsReportBugLinks">
            	{if $myobj->getFormField('order') != 'all' && $myobj->getFormField('order') != ''}
            		<a href="reportBugs.php?order=all">{$LANG.all}</a>
                {else}
                	{$LANG.all}
                {/if}
                |
                {if $myobj->getFormField('order') != 'open'}
               		 <a href="reportBugs.php?order=open">{$LANG.open}</a>
                {else}
                	{$LANG.open}
                {/if}
                |
                {if $myobj->getFormField('order') != 'close'}
                    <a href="reportBugs.php?order=close">{$LANG.close}</a>
                {else}
                	{$LANG.close}
                {/if}
            </div>
			{if $myobj->isShowPageBlock('block_bugs_list')}
				<h3 id="selBugsListHeading">{$LANG.bugs_list}</h3>
				<form name="selListStaticForm" id="selListStaticForm" method="post" action="{$myobj->getCurrentUrl(false)}">
					{if $CFG.admin.navigation.top}
							{$myobj->setTemplateFolder('admin/')}
                    		{include file='pagination.tpl' opt='top'}
                    {/if}
					{$myobj->populateHidden($myobj->block_sel_page_list.hidden_arr)}
					<!-- clsDataDisplaySection - starts here -->
					<div class="clsReportBugList">
	                    <table class="clsDataRow {$myobj->getCSSRowClass()}">
						<tr>
							{if $myobj->getFormField('order') neq 'close'}
								<th class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" id="check_all" onclick="CheckAll(document.selListStaticForm.name, document.selListStaticForm.check_all.name)" name="check_all" tabindex="{smartyTabIndex}" /></th>
							{/if}
							<th>{$LANG.reportbugs_subject}</th>
							<th>{$LANG.reportbugs_message}</th>
						</tr>
						{foreach key=pblkey item=pblvalue from=$myobj->block_sel_page_list.populateBugsList}
							<tr>
								{if $myobj->getFormField('order') neq 'close'}
									<td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="bug_ids[]" tabindex="{smartyTabIndex}" value="{$pblvalue.record.bug_id}" onclick="deselectCheckBox(document.selListStaticForm.name, document.selListStaticForm.check_all.name)"/></td>
								{/if}
								<td><p class="clsBugReportSubject">{$pblvalue.record.bug_subject}</p></td>
								<td>
                                	<div class="clsReportSubject">
                                        <p class="clsReportBugTitle">{$pblvalue.record.bug_content}</p>
                                        <p><span class="">{$LANG.date_added}</span>&nbsp;&nbsp;:&nbsp;&nbsp; {$myobj->getFormatedDate($pblvalue.record.date_added, #format_datetime#)}</p>
                                        <p><span class="">{$LANG.posted_by}</span>&nbsp;&nbsp;:&nbsp;&nbsp;{$pblvalue.record.reply_from}</p>
                                        <p><span class="">{$LANG.common_status}</span>&nbsp;:&nbsp;{$pblvalue.record.status}</p>
                                    </div>
                                    {if $pblvalue.populateBugReplyList}
                                        <div class="clsAllReportRepplies">
                                            <div id="trBugs_{$pblvalue.record.bug_id}" class="clsReportReplies">
                                                <div>

                                                    {foreach key=pbrlkey item=pbrlvalue from=$pblvalue.populateBugReplyList}
                                                        <div class="clsBugReply">
                                                            <p class="clsReportBugTitle">{$pbrlvalue.record.bug_content}</p>
                                                            <p><span class="">{$LANG.date_added}</span>&nbsp;&nbsp;:&nbsp;&nbsp; {$myobj->getFormatedDate($pbrlvalue.record.date_added, #format_datetime#)}</p>
                                                            <p><span class="">{$LANG.posted_by}</span>&nbsp;&nbsp;:&nbsp;&nbsp;{$pbrlvalue.record.reply_from}</p>
                                                            <p><span class="">{$LANG.common_status}</span>&nbsp;:&nbsp;{$pbrlvalue.record.status}</p>
                                                        </div>
                                                    {/foreach}
                                                </div>
                                                {if $pblvalue.populateBugReplyList && $pblvalue.record.status neq 'Closed'}
                                                    <p class="clsReplayText"><a href="{$pblvalue.replybugs_open.url}" onclick="$Jq('#msg{$pblvalue.replySpanIDId}').show();return false;">{$LANG.replybugs_reply}</a></p>
                                                {/if}
                                                  <div class="clsReplaBugReplayTable">
                                              		  <div id="msg{$pblvalue.replySpanIDId}" style="display:none">

                                                        <table>
                                                        <tr class="clsFormRow">
                                                            <td class="{$myobj->getCSSFormLabelCellClass('message')}">
																<label for="message">
                                                                	{$LANG.reportbugs_message}
																</label>
                                                                {$myobj->displayCompulsoryIcon()}
                                                            </td>
                                                            <td class="{$myobj->getCSSFormFieldCellClass('message')}">
                                                                <textarea name="user_reply_{$pblvalue.record.bug_id}" id="user_reply_{$pblvalue.record.bug_id}" tabindex="{smartyTabIndex}" rows="4" cols="45">{$myobj->getFormField('message')}</textarea>
                                                                {$myobj->getFormFieldErrorTip('message')}
                                                            </td>
                                                        </tr>
                                                        <tr class="clsFormRow">
                                                            <td class="clsButtonAlignment {$myobj->getCSSFormFieldCellClass('default')}"></td>
                                                            <td>
                                                                <input type="hidden" name="bug_id" id="bug_id" value="{$pblvalue.record.bug_id}"  />
                                                                <input type="button" class="clsSubmitButton" name="reply_bugs" id="reply_bugs_{$pblvalue.record.bug_id}" value="{$LANG.reportbugs_submit}" tabindex="{smartyTabIndex}" onclick="postBugReply('{$pblvalue.replybugs_open.url}','postYourReply=1&bug_id={$pblvalue.record.bug_id}&parent_id={$pblvalue.record.parent_id}','user_reply_{$pblvalue.record.bug_id}','{$pblvalue.record.bug_id}');" />
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    </div>
                                                </div>
											</div>
                                        </div>
                                     {/if}
								</td>
							</tr>
						{/foreach}
						{if $myobj->getFormField('order') neq 'close'}
							<tr>
								<td colspan="3"  class="clsButtonAlignment {$myobj->getCSSFormFieldCellClass('submit')}">
                                    <input type="hidden" value="{$LANG.bug_close}" name="action" id="action" />
                                    <input type="button" class="clsSubmitButton" name="todo" id="todo" onclick="getMultiCheckBoxValue('selListStaticForm', 'check_all', '{$LANG.select_a_bug}');if(multiCheckValue!='')getAction()" value="{$LANG.bug_close}" tabindex="{smartyTabIndex}" />
								</td>
							</tr>
						{/if}
					</table>
                    </div>
                    <!-- clsDataDisplaySection - ends here -->
                    {if $CFG.admin.navigation.bottom}
                    {$myobj->setTemplateFolder('admin/')}
                    {include file='pagination.tpl' opt='bottom'}
                    {/if}
				</form>
			{/if}
		</div>
</div>