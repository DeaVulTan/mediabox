<div id="viewPhotoFlag" class="clsDisplayNone clsTextAlignLeft clsOverflow">
	<div id="clsMsgDisplay_flag" class="clsDisplayNone clsFlagMsg"></div>
    <div class="clsOverflow">
    {*<p class="clsFlagInContent">{$LANG.viewphoto_flag_inappropriate_content}</p>*}
	<div class="clsViewTopicLeft">
		<div class="clsViewTopicRight">
        {if isMember()}
			<a href="{$myobj->getCurrentUrl(true)}" onclick="return Confirmation('flagDiv', 'flagfrm', Array(), Array(), Array())" title="{$LANG.viewphoto_flag_inappropriate_content}">{$LANG.viewphoto_flag_inappropriate_content}</a>
            {else}
            <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_comment_flag_err_msg}','{$myobj->memberviewPhotoUrl}'); return false;" title="{$LANG.viewphoto_flag_inappropriate_content}">{$LANG.viewphoto_flag_inappropriate_content}</a>
            {/if}
		</div>
	</div>
    </div>
</div>

<div id="flagDiv" class="clsPopupConfirmation clsTextAlignLeft" style="display:none;">
	<div id="clsMsgDisplayFlagDiv" class="clsDisplayNone clsFeaturedContent clsAddErrorMsg"></div>
	<div class="clsOverflow">
    	<div class="clsFlagTitle">{$LANG.viewphoto_flag_title}</div>
    </div>
    <div id="flagFrm" class="clsFlagTable">
		<form name="flagfrm" action="{$myobj->getCurrentUrl()}" method="post" autocomplete="off" onsubmit="return false">
			<table>
					<p class="clsUserActionMessage">{$LANG.viewphoto_report_media}</p>
                <tr>  
					<td>{$LANG.viewphoto_choose_reasons}<br />
                    </td>
                    <td>
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
					 	{$LANG.viewphoto_flag_comment}&nbsp;<span class="clsCompulsoryField">{$LANG.common_photo_mandatory}</span>
					</td>
					<td>
						<textarea name="flag_comment" id="flag_comment" tabindex="{smartyTabIndex}" rows="5" cols="30" style="width:95%;" maxlength="5" class="clsFlagTextarea"></textarea>
					</td>
			 	</tr>
			 	<tr>
             		<td><!-- --></td>
			 		<td>
						<div class="clsFlagButtonLeft">
							<div class="clsFlagButtonRight">
								<input type="button" name="add_to_flag" id="add_to_flag" value="{$LANG.viewphoto_set_flag}" onClick="return addPhotoFlagContentAjax('{$flagContent.url}')" />
							</div>
						</div>
					</td>
 				</tr>
			</table>
		</form>
    </div>
</div>