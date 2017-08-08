<div id="option-tab-2" class="clsDisplayNone clsTextAlignLeft clsOverflow">
	<div id="clsMsgDisplay_flag" class="clsDisplayNone clsTextAlignLeft"></div>
	<div class="clsViewTopicLeft">
		<div class="clsViewTopicRight">
        	{if isMember()}
			<a href="{$myobj->getCurrentUrl(true)}" onclick="return Confirmation('flagDiv', 'flagfrm', Array(), Array(), Array())">{$LANG.viewvideo_flag_inappropriate_content}</a>
            {else}
            <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.common_video_login_flag_msg}', '{$myobj->memberviewVideoUrl}');return false;">{$LANG.viewvideo_flag_inappropriate_content}</a>
            {/if}
			</div>
		</div>
</div>

<div id="flagDiv" class="clsPopupConfirmation clsTextAlignLeft" style="display:none;">
	<div id="clsMsgDisplayFlagDiv" class="clsDisplayNone clsFeaturedContent clsAddErrorMsg"></div>
	<div class="clsOverflow">
    	<div class="clsFlagTitle">{$LANG.viewvideo_flag_title}</div>
    </div>
    <div id="flagFrm" class="clsFlagTable">
		<form name="flagfrm" action="{$myobj->getCurrentUrl()}" method="post" autocomplete="off" onsubmit="return false">
			<table class="clsTable100">
				<tr>
					<td class="clsTDLabelwidth">{$LANG.viewvideo_report_media}</td>
					<td>{$LANG.viewvideo_choose_reasons}<br />
	                    <select name="flag" id="flag" tabindex="{smartyTabIndex}">
	                        <option value="">{$LANG.common_select_option}</option>
	                        {foreach key=ftKey item=ftValue from=$myobj->flag_type_arr}
	                        <option value="{$ftKey}">{$ftValue}</option>
	                        {/foreach}
	                    </select>
	       			</td>
				</tr>
				<tr>
			 		<td>
					 	{$LANG.viewvideo_flag_comment}&nbsp;<span class="clsCompulsoryField">{$LANG.important}</span>
					</td>
					<td>
						<textarea name="flag_comment" id="flag_comment" tabindex="{smartyTabIndex}" rows="5" cols="30" style="width:95%;" maxlength="5"></textarea>
					</td>
			 	</tr>
			 	<tr>
             		<td><!-- --></td>
			 		<td>
						<div class="clsFlagButtonLeft">
							<div class="clsFlagButtonRight">
								<input type="button" name="add_to_flag" id="add_to_flag" value="{$LANG.viewvideo_set_flag}" onClick="return addFlagContent('{$flagContent.url}')" />
							</div>
						</div>
					</td>
 				</tr>
			</table>
		</form>
    </div>
</div>