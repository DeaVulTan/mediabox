<div id="selVideoList">
	<h2><span>{$LANG.reported_users_title}</span></h2>
  	<div id="selMsgConfirm" style="display:none;">
  		<p id="confirmMessage"></p>
    	<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
    		<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_yes_option}" />&nbsp;
        	<input type="button" class="clsCancelButton" name="no" id="no" tabindex="{smartyTabIndex}" value="{$LANG.common_no_option}"  onClick="return hideAllBlocks();" />
        	<input type="hidden" name="reported_user_ids" id="reported_user_ids" />
        	<input type="hidden" name="select_action" id="select_action" />
			{$myobj->populateHidden($myobj->hiddenArr)}
    	</form>
  	</div>

	{if $myobj->isShowPageBlock('block_report_details')}
	 	<div class="clsBackToReport"><a href="reportedUsers.php">{$LANG.back_to_reports}</a></div>
	{/if}

	{$myobj->setTemplateFolder('admin/')}
	{include file="information.tpl"}

 	{if $myobj->isShowPageBlock('block_report_details')}
 		<div id="selFlaggedDetails">
    		{if isset($reported_user_details)}
	        	<h4>
	        		{$LANG.reports_for}
				</h4>
	        		<a href="{$reported_user_link}">
		        		<img src="{$reported_user_details.icon.t_url}" alt="{$reported_user_details.display_name}" title="{$reported_user_details.display_name}" {if $reported_user_details.icon.t_width} {$myobj->DISP_IMAGE(#image_thumb_width#,#image_thumb_height#,$reported_user_details.icon.t_width,$reported_user_details.icon.t_height)}" {/if}/>
		        	</a>
	            	<p><a href="{$reported_user_link}">{$reported_user_details.display_name}</a></p>
	    		<table summary="{$LANG.reportedusers_tbl_summary}">
	        		<tr>
	                	<th class="clsWidth100">{$LANG.header_reported_by}</th>
	                	<th class="clsSelectSmall">{$LANG.reportedusers_flaged_text}</th>
		                <th class="clsCustomMessage">{$LANG.reportedusers_additional_message}</th>
		                <th class="clsSelectSmall">{$LANG.reportedusers_date_added}</th>
			        </tr>
		            {section name='det' loop=$myobj->flaggedContents}
		            	<tr>
		                    <td>
		                    	<a href="{$myobj->flaggedContents[det].reporter_link}">
		                    		<img src="{$myobj->flaggedContents[det].reporter_avatar}" alt="{$myobj->flaggedContents[det].reporter_name}" title="{$myobj->flaggedContents[det].reporter_name}" {if $myobj->flaggedContents[det].reporter_avatar_width} {$myobj->DISP_IMAGE(#image_thumb_width#,#image_thumb_height#,$myobj->flaggedContents[det].reporter_avatar_width,$myobj->flaggedContents[det].reporter_avatar_height)}" {/if}/>
		                    	</a>
		                    	<a href="{$myobj->flaggedContents[det].reporter_link}">
			                        {$myobj->flaggedContents[det].reporter_name}
								</a>
							</td>
		                    <td>
		                    	{section name='i' loop=$myobj->flaggedContents[det].flag}
			                    	{$myobj->flaggedContents[det].flag[i].flag} <br />
		                        {/section}
							</td>
		                    {if $myobj->flaggedContents[det].custom_message}
			                    <td>{$myobj->flaggedContents[det].custom_message}</td>
		                    {else}
		                    	<td>-</td>
		                    {/if}
		                    <td>{$myobj->flaggedContents[det].date_added|date_format:#format_date_year#}</td>
		                  </tr>
		            {/section}
		        </table>
		    {/if}
    	</div>
 	{/if}
 	{if $myobj->isShowPageBlock('list_reported_users')}
 		<div id="selVideoList">
	    	<form name="reportedListForm" id="reportedListForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
	        	{if $CFG.admin.navigation.top}
	                {include file='../general/pagination.tpl' opt='top'}
	            {/if}
	        	<table summary="{$LANG.reportedusers_tbl_summary}">
	            	<tr>
	                	<th class="clsAlignCenter clsWidth20">
	                        <input type="checkbox" class="clsCheckRadio" name="check_all" onclick = "CheckAll(document.reportedListForm.name, document.reportedListForm.check_all.name)" />
						</th>
	                    <th class="clsWidth100">{$LANG.header_reported_user}</th>
	                    <th>{$LANG.header_total_requests}</th>
	                    <th class="clsSelectSmall">{$LANG.header_option}</th>
	                </tr>
	                {section name='reports' loop=$myobj->reportedUsers}
	                	<tr class="{$myobj->getCSSRowClass()}">
	                    	<td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="reported_user_ids[]" value="{$myobj->reportedUsers[reports].reported_user_id}" tabindex="{smartyTabIndex}" onclick = "deselectCheckBox(document.reportedListForm.name, document.reportedListForm.check_all.name)"/></td>

	                         <td class="clsAlignCenter">
	                         	{if $myobj->reportedUsers[reports].user_details}
	                            	<a href="{$myobj->reportedUsers[reports].memberProfileUrl}">
	                                    <img src="{$myobj->reportedUsers[reports].icon.t_url}" {$myobj->DISP_IMAGE(#image_thumb_width#, #image_thumb_height#, $myobj->reportedUsers[reports].icon.t_width, $myobj->reportedUsers[reports].icon.t_height)} />
	                                </a>
		                         	<p><a href="{$myobj->reportedUsers[reports].memberProfileUrl}">{$myobj->reportedUsers[reports].user_details.display_name}</a></p>
	                            {else}
	                            	{$LANG.common_user_deleted}
	                            {/if}
	                         </td>
	                         <td>
								{section name='j' loop=$myobj->reportedUsers[reports].reports}
	                            	<p id="clsBold">
	                                	{$myobj->reportedUsers[reports].reports[j].flag} : {$myobj->reportedUsers[reports].reports[j].count}
	                                </p>
	                            {/section}
							</td>
	                        <td><span id="detail"><a href="?action=detail&amp;rid={$myobj->reportedUsers[reports].reported_user_id}&amp;start={$myobj->getFormField('start')}">{$LANG.detail}</a></span></td>
	                    </tr>
	                {/section}
	                <tr>
					<td colspan="6" class="{$myobj->getCSSFormFieldCellClass('report_submit')}">
	           			{$myobj->populateHidden($myobj->hiddenArr)}
	                    <select name="select_action" id="select_action" tabindex="{smartyTabIndex}" >
		                    <option value="">{$LANG.select_one}</option>
	                    	<option value="block_user">{$LANG.reportedusers_block}</option>
	                        <option value="delete_report">{$LANG.reportedusers_delete_report}</option>
	                        <option value="delete_user">{$LANG.reportedusers_delete_user}</option>
	                    </select>
						<input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.reportedusers_action_sumbit}" onclick="{literal}if(getMultiCheckBoxValue('reportedListForm', 'check_all', '{/literal}{$LANG.err_tip_select_user}{literal}')){getAction();}{/literal}" />
					</td>
				</tr>
	            </table>
	            {if $CFG.admin.navigation.bottom}
	                {include file='../general/pagination.tpl' opt='bottom'}
	            {/if}
	        </form>
    	</div>
 	{/if}
</div>