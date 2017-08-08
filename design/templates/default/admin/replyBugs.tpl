<div id="selreplyBugs">
		<h2>{$LANG.replybugs_title}</h2>
		<div class="clsCommonInsideContent clsReplayBugsMain">
			<div class="clsReportBugLinks">
				{if $myobj->getFormField('order') != 'all' && $myobj->getFormField('order') != ''}
					<a href="replyBugs.php?order=all">{$LANG.all}</a>
				{else}
					{$LANG.all}
				{/if}
				|
				{if $myobj->getFormField('order') != 'open'}
					 <a href="replyBugs.php?order=open">{$LANG.open}</a>
				{else}
					{$LANG.open}
				{/if}
				|
				{if $myobj->getFormField('order') != 'close'}
				    <a href="replyBugs.php?order=close">{$LANG.close}</a>
				{else}
					{$LANG.close}
				{/if}
			</div>
			{include file='../general/information.tpl'}
			{if $myobj->isShowPageBlock('block_bugs_list')}
				<form name="selListStaticForm" id="selListStaticForm" method="post" action="{$myobj->getCurrentUrl(false)}">
				{$myobj->populateHidden($myobj->block_sel_page_list.hidden_arr)}
				<!-- clsDataDisplaySection - starts here -->
				{foreach key=pblkey item=pblvalue from=$myobj->block_sel_page_list.populateBugsList}
						<table class="clsBugManagementTbl {$myobj->getCSSRowClass()}">
							<tr>
                            	<td>
									<div class="clsReportSubject">
										<p class="clsReportBugTitle">{$pblvalue.record.bug_subject}</p>
										<p>{$pblvalue.record.bug_site}</p>
										<p>{$pblvalue.record.bug_content}</p>
										<p><span class="">{$LANG.date_added}</span>&nbsp;&nbsp;:&nbsp;&nbsp; {$myobj->getFormatedDate($pblvalue.record.date_added, #format_datetime#)}</p>
										<p><span class="">{$LANG.posted_by}</span>&nbsp;&nbsp;:&nbsp;&nbsp;{$pblvalue.record.reply_from}</p>
										<p><span class="">{$LANG.status}</span>&nbsp;&nbsp;:&nbsp;&nbsp;{$pblvalue.record.status}</p>
									</div>
									<p class="clsReplayText"><a href="javascript:void(0);" onclick="$Jq('#msgreplySpanID_{$pblvalue.record.bug_id}').show();return false;">{$LANG.replybugs_reply}</a></p>
									{if $pblvalue.populateBugReplyList}
										<div class="clsAllReportRepplies">
											{foreach key=pbrlkey item=pbrlvalue from=$pblvalue.populateBugReplyList}
                                                <div class="clsBugReply {$pbrlvalue.record.class_client_post}">
                                                    <p class="clsReportBugTitle">{$pbrlvalue.record.bug_content}</p>
                                                    <p><span class="">{$LANG.date_added}</span>&nbsp;&nbsp;:&nbsp;&nbsp; {$myobj->getFormatedDate($pbrlvalue.record.date_added, #format_datetime#)}</p>
                                                    <p><span class="">{$LANG.posted_by}</span>&nbsp;&nbsp;:&nbsp;&nbsp;{$pbrlvalue.record.reply_from}</p>
												</div>
											{/foreach}
										</div>
									{/if}

										<div id="msgreplySpanID_{$pblvalue.record.bug_id}" style="display:none">
                                        	<div class="clsReplaBugReplayTable clsAllReportRepplies">
                                                <form name="form_replybugs_show" id="form_replybugs_show" method="post" action="{$myobj->getCurrentUrl(false)}?start={$myobj->getFormField('start')}&order={$myobj->getFormField('order')}">
                                                    <!-- clsFormSection - starts here -->
                                                    <table class="clsFormTbl">
                                                        <tr class="clsFormRow">
                                                            <td class="{$myobj->getCSSFormLabelCellClass('message')}">
	                                                            {$myobj->displayCompulsoryIcon()}
                                                                <label for="message">{$LANG.replybugs_message}</label>
                                                            </td>
                                                            <td class="{$myobj->getCSSFormFieldCellClass('message')}">
                                                                <textarea name="message" id="message" tabindex="{smartyTabIndex}" rows="4" cols="45">{$myobj->getFormField('message')}</textarea>
                                                                {$myobj->getFormFieldErrorTip('message')}
                                                            </td>
                                                        </tr>
                                                        <tr class="clsFormRow">
                                                            <td></td>
                                                            <td class="clsButtonAlignment {$myobj->getCSSFormFieldCellClass('default')}">
                                                                {* $myobj->populateHidden($myobj->block_replyBugs.hidden_arr) *}
                                                                <input type="hidden" name="bid" id="bid" value="{$pblvalue.record.bug_id}" />
                                                                <input type="submit" class="clsSubmitButton" name="submit_replyBugs" id="submit_replyBugs" value="{$LANG.replybugs_submit}" tabindex="{smartyTabIndex}" />
                                                                <input type="submit" class="clsCancelButton" name="submit_cancel" id="submit_cancel" value="{$LANG.replybugs_cancel}" tabindex="{smartyTabIndex}" />
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- clsFormSection - ends here -->
                                                </form>
											</div>
										</div>
								</td>
							</tr>
						</table>
					{/foreach}
					<!-- clsDataDisplaySection - ends here -->
					{if $CFG.admin.navigation.bottom}
						{include file='../general/pagination.tpl' opt='bottom'}
					{/if}
				</form>
			{/if}
		</div>
</div>