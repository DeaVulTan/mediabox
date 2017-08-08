<div id="listenMusicFlag" class="clsDisplayNone clsTextAlignLeft clsOverflow">
	<div id="clsMsgDisplay_flag" class="clsDisplayNone clsTextAlignLeft"></div>
	<div class="clsViewTopicLeft">
		<div class="clsViewTopicRight">
        	{if $myobj->isMember}
			<a href="{$myobj->getCurrentUrl(true)}" onclick="return Confirmation('flagDiv', 'flagfrm', Array(), Array(), Array())" title="{$LANG.viewmusic_flag_inappropriate_content}">{$LANG.viewmusic_flag_inappropriate_content}</a>
            {else}
            <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_comment_flag_err_msg}','{$myobj->memberviewMusicUrl}');return false;" title="{$LANG.viewmusic_flag_inappropriate_content}">{$LANG.viewmusic_flag_inappropriate_content}</a>
            {/if}
        </div>
    </div>	
</div>
<div id="flagDiv" class="clsPopupConfirmation clsTextAlignLeft" style="display:none;">
	<div id="clsMsgDisplayFlagDiv" class="clsDisplayNone clsFeaturedContent clsAddErrorMsg"></div>
	<div class="clsOverflow">
    	<div class="clsFlagTitle">{$LANG.viewmusic_flag_title}</div>
    </div>
    <div id="flagFrm" class="clsInnerPlaylist">
		<form name="flagfrm" action="{$myobj->getCurrentUrl()}" method="post" autocomplete="off" onsubmit="return false">
        <div class="clsCreatePlaylist">
        	<div class="clsUserActionMessage"> 
            {$LANG.viewmusic_report_media}
            </div>
			<div class="clsRow"> 
                <div class="clsTDLabel">{$LANG.viewmusic_choose_reasons}</div>
                <div class="clsTDText">
                    <select name="flag" id="flag" tabindex="{smartyTabIndex}">
                        <option value="">{$LANG.common_select_option}</option>
                        {foreach key=ftKey item=ftValue from=$myobj->flag_type_arr}
                        <option value="{$ftKey}">{$ftValue}</option>
                        {/foreach}
                    </select>
       			</div>
            </div>
			<div class="clsRow">
			 	<div class="clsTDLabel">{$LANG.viewmusic_flag_comment}&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.common_music_mandatory}</span>&nbsp;</div>
				<div class="clsTDText">
                	<textarea name="flag_comment" id="flag_comment" tabindex="{smartyTabIndex}" rows="5" cols="30" style="width:95%;" maxlength="5"></textarea>
				</div>
			</div>                 
			<div class="clsRow">
            	<div class="clsTDLabel"><!----></div>
			 	<div class="clsTDText">
					<p class="clsButton"><span><input type="button" name="add_to_flag" id="add_to_flag" value="{$LANG.viewmusic_set_flag}" onClick="addFlagContentAjax('{$flagContent.url}')" /></span></p>
				</div>
 			</div>
		</div>
		</form>
    </div>
</div>