<div class="">
    <div id="selSharehedding">
        <h2><span>{$LANG.report_user}</span></h2>
    </div>
	{include file='../general/information.tpl'}
    <div class="clsReportUserPopupCont">
    	{if ($CFG.user.usr_access eq 'Admin' || checkUserPermission($CFG.user.user_actions, 'report_users') eq 'Yes')}
    		<p id='loadingUpdates' style="text-align:center;display:none">
        		<img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/ajaxLoadingRed.gif" /> <br/><span style="color:#DD6C34">Loading..</span>
        	</p>
	        <form name="frmReportUsers" id="frmReportUsers" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
			<table>
	        	<tr>
	            	<td><h3>{$LANG.reporting_content}</h3></td>
	            </tr>
	            <tr>
	                <td><p>{$LANG.choose_reasons}</p></td>
				</tr>
	            <tr>
	                <td>
	                    {foreach name=i item=item from=$LANG_LIST_ARR.report_content}
	                        <p>
	                            <input type="checkbox" class="clsCheckRadio" name="report_type[]" id="report_type_{$smarty.foreach.i.index+1}" value="{$smarty.foreach.i.index+1}" tabindex="{smartyTabIndex}" />
	                            <label for="report_type_{$smarty.foreach.i.index+1}">{$item}</label>
	                        </p>
	                    {/foreach}
	                    <div id="selShowCustomDivs">
	                        <p class="clsBold">
								<span >{$LANG.add_custom_message}</span>
	                            <span>
	                                <a id="selCancelCustom" href="javascript:void(0);" onclick="$Jq('#custom_message').val('');">{$LANG.cancel}</a>
		                            <textarea id="custom_message" name="custom_message">{$myobj->getFormField('custom_message')}</textarea>
								</span>
	                        </p>
	                	</div>
	                </td>
	            </tr>
	            <tr>
	                <td>
	                    <div class="clsShareButton">
	                        <div class="clsSubmitButtonRight">
	                            <div class="clsSubmitButtonLeft">
			<input type="button" name="add_to_flag" id="add_to_flag" value="{$LANG.set_flag}" onclick="return openAjaxWindow('true', 'ajaxupdate', 'submitReporting', 1, '{$myobj->reportingUrl}');" />
	                            </div>
	                        </div>
	                    </div>
	                </td>
	            </tr>
			</table>
	  		</form>
      	{else}
        	{$LANG.reporting_user_permission_not_available}
      	{/if}
    </div>
    {include file='../general/box.tpl' opt='popup_type1_bottom_middle'}
    {include file='../general/box.tpl' opt='popup_type1_footer'}
</div>