<div id="selMusicList">
	<!-- heading start-->
	<h2>
    	<span>
        	{$LANG.search_member_type_title}
        </span>
    </h2>
    <!-- heading end-->
    <!-- Confirmation message block start-->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
        <p id="confirmMessage"></p>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
            <table summary="">
                <tr>
                    <td>
                        <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
                        &nbsp;
                        <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
                        <input type="hidden" name="ch_status" id="ch_status" />
                        <input type="hidden" name="act" id="act" />
                         <input type="hidden" name="uid" id="uid" />
                        {$myobj->populateHidden($myobj->form_list_members.populateHidden_arr)}
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- Confirmation message block end-->
     <!-- information div -->
    {$myobj->setTemplateFolder('admin')}
    {include file='information.tpl'}
    {if $myobj->isShowPageBlock('form_search')}
        <form name="formSearch" id="formSearch" method="post" action="{$myobj->getCurrentUrl()}">
        <table class="clsNoBorder">
            <tr>
			  <td class="{$myobj->getCSSFormLabelCellClass('uname')}"><label for="uname">{$LANG.search_user_name}</label></td>
              <td class="{$myobj->getCSSFormFieldCellClass('uname')}">{$myobj->getFormFieldErrorTip('uname')}<input type="text" class="clsTextBox" name="uname" id="uname" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('uname')}" /></td>
              <td class="{$myobj->getCSSFormLabelCellClass('email')}"><label for="email">{$LANG.search_email}</label></td>
              <td class="{$myobj->getCSSFormFieldCellClass('email')}">{$myobj->getFormFieldErrorTip('email')}<input type="text" class="clsTextBox" name="email" id="email" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('email')}" /></td>
            </tr>
           <tr>
             <td class="{$myobj->getCSSFormLabelCellClass('fname')}"><label for="fname">{$LANG.search_first_name}</label></td>
             <td class="{$myobj->getCSSFormFieldCellClass('fname')}">{$myobj->getFormFieldErrorTip('fname')}<input type="text" class="clsTextBox" name="fname" id="fname" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('fname')}" /></td>
              <td class="{$myobj->getCSSFormLabelCellClass('tagz')}"><label for="tagz">{$LANG.search_profile_tag}</label></td>
              <td class="{$myobj->getCSSFormFieldCellClass('tagz')}">{$myobj->getFormFieldErrorTip('tagz')}<input type="text" class="clsTextBox" name="tagz" id="tagz" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('tagz')}" /></td>
          </tr>

            <tr>
                <td class="{$myobj->getCSSFormFieldCellClass('submit')}">
                    <input type="submit" class="clsSubmitButton" name="search_submit" id="search_submit" tabindex="{smartyTabIndex}" value="{$LANG.search_submit}" />
                    &nbsp;&nbsp;
                    <input type="submit" class="clsSubmitButton" name="search_submit_reset" id="search_submit_reset" tabindex="{smartyTabIndex}" value="{$LANG.search_submit_reset}" onclick=""/>                </td>
            </tr>
            <tr>
                <td colspan="4" align="center" id="searchErrorMsg">&nbsp;</td><!--for php coders -->
            </tr>
        </table>
  </form>
    {/if}
    {if  $myobj->isShowPageBlock('form_no_records_found')}
        <div id="selMsgAlert">
            <p>{$LANG.search_msg_no_records}</p>
        </div>
	{/if}
    {if $myobj->isShowPageBlock('msg_form_user_details_updated') && $myobj->getCommonErrorMsg()}
		<div id="selMsgSuccess">{$myobj->getCommonErrorMsg()}</div>
    {/if }
	{if $myobj->isShowPageBlock('form_list_members')}
    	<div id="selMsgChangeStatus" class="clsPopupConfirmation" style="display:none;">
    		<p id="msgConfirmText"></p>
	      	<form name="formChangeStatus" id="formChangeStatus" method="post" action="{$_SERVER.PHP_SELF}">
	        	<table class="clsNoBorder">
		          	<tr>
				  		<td id="selPhotoGallery">
							<p id="profileIcon"></p>
						</td>
				  	</tr>
				  	<!--<tr>
		            	<td>
							<p><textarea name="featured_description" id="featured_description"></textarea></p>

						</td>
		          	</tr>-->
				  	<tr>
		            	<td>
						  	<input type="submit" class="clsSubmitButton" name="submit_yes" id="submit_yes" value="Activate" tabindex="{smartyTabIndex}" /> &nbsp;
			              	<input type="button" class="clsSubmitButton" name="submit_no" id="submit_no" value="Cancel" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
							<input type="hidden" name="action" id="action" />
			              	<input type="hidden" name="uid" id="uid" />
							{$myobj->populateHidden($myobj->form_list_members.populateHidden_arr)}
						</td>
		          	</tr>
	        	</table>
	      	</form>
	    </div>
        <!-- top pagination start-->
        {if $CFG.admin.navigation.top}
            {include file='pagination.tpl'}
        {/if}
        <table summary="{$LANG.member_list_tbl_summary}">
			<tr>
                <th >{$LANG.search_results_title_user_account_info}</th>

                <th >{$LANG.search_results_title_user_site_info}</th>
                <th>{$LANG.search_results_title_status}</th>
                <th>{$LANG.action_links}</th>
			</tr>
			{foreach key=dmKey  item=dmValue from=$myobj->form_list_members.displayMembers.row}
                <tr class="{$dmValue.cssRowClass} {$dmValue.userClass}">
                    <td>
					<span class="clsProfileThumbImg">
                            <a href="{$dmValue.memberProfileUrl}">
                                <img src="{$dmValue.icon.t_url}" alt="{$dmValue.record.user_name}" title="{$dmValue.record.user_name}" {$dmValue.icon.t_attribute} />
                            </a>
                        </span>
                    <p>
					<span class="clsProfileThumbImg"><a href="{$dmValue.memberProfileUrl}" id="{$dmValue.anchor}">{$dmValue.record.user_name}</a></span>
					</p>
					</td>

                    <td align="left" valign="top" ><p>{$LANG.search_results_title_friends}: {if $dmValue.record.total_friends != ''} {$dmValue.record.total_friends}{/if} </p>
                      {foreach key=marrKey  item=marrValue from=$dmValue.modules_arr}
                      <p>{if $marrValue.total_upload != ''}{$marrValue.total_upload}{/if}</p>
                    {/foreach} </td>
                    <td>{$dmValue.accountStatus}</td>
                   	<td>{if $dmValue.record.music_user_type == 'Artist'}
                             <a href="javascript:void(0);" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('ch_status', 'uid', 'act', 'confirmMessage'), Array('Listener', '{$dmValue.user_id}', 'music_user_type', '{$LANG.member_confirm_remove_as_artist}'), Array('value', 'value', 'value', 'innerHTML'), 10, -400,'anchor_confirm_{$dmValue.user_id}');">
                                    {$LANG.member_remove_as_artist}                             </a>
                        {else}
                             <a href="javascript:void(0);" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('ch_status', 'uid', 'act', 'confirmMessage'), Array('Artist', '{$dmValue.user_id}', 'music_user_type', '{$LANG.member_confirm_set_as_artist}'), Array('value', 'value', 'value', 'innerHTML'), 10, -400,'anchor_confirm_{$dmValue.user_id}');">
                                    {$LANG.member_set_as_artist}                             </a>
                        {/if}</td>
                </tr>

                <tr class="{$dmValue.cssRowClass}">

          </tr>
                <tr class="{$dmValue.cssRowClass}">
                </tr>
            {/foreach}
		</table>
        <!-- top pagination start-->
        {if $CFG.admin.navigation.bottom}
         {include file='pagination.tpl'}
        {/if}
        <!-- top pagination end-->
    {/if}
 </div>