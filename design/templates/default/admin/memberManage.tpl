<div id="selMemberList">
	<!-- heading start-->
	<h2>
    	<span>
        	{$LANG.search_title}
        </span>
    </h2>
    <!-- heading end-->
    <!-- Confirmation message block start-->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
        <p id="confirmMessage"></p>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(false)}">
            <table summary="">
                <tr>
                    <td>
                        <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
                        &nbsp;
                        <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
                    </td>
                </tr>
            </table>
            <input type="hidden" name="ch_status" id="ch_status" />
            <input type="hidden" name="act" id="act" />
            <input type="hidden" name="uid" id="uid" />
            {$myobj->populateHidden($myobj->form_list_members.populateHidden_arr)}
        </form>
    </div>
    <!-- Confirmation message block end-->
     <!-- information div -->
    {$myobj->setTemplateFolder('admin/')}
    {include file='information.tpl'}
    {if $myobj->isShowPageBlock('form_search')}
        <form name="formSearch" id="formSearch" method="post" action="{$myobj->getCurrentUrl(false)}">
        <table class="clsNoBorder clsTextBoxTable">
            <tr>
              <td class="{$myobj->getCSSFormLabelCellClass('uname')}"><label for="uname">{$LANG.common_username}</label></td>
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
              <td class="{$myobj->getCSSFormLabelCellClass('sex')}"><label for="sex">{$LANG.search_sex}</label></td>
              <td class="{$myobj->getCSSFormFieldCellClass('sex')}">{$myobj->getFormFieldErrorTip('sex')}
              <select name="sex" id="sex" tabindex="{smartyTabIndex}">
                <option value="">{$LANG.search_sex_option_both}</option>
                {$myobj->generalPopulateArray($myobj->form_search.LANG_LIST_ARR, $myobj->getFormField('sex'))}
              </select>             </td>
                <td class="{$myobj->getCSSFormLabelCellClass('country')}"><label for="country">{$LANG.search_results_sub_title_country}</label></td>
                <td class="{$myobj->getCSSFormFieldCellClass('country')}">{$myobj->getFormFieldErrorTip('country')}<select name="country" id="country" tabindex="{smartyTabIndex}">{$myobj->populateCountriesList($myobj->getFormField('country'))}</select></td>
            </tr>
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('doj_s_d')}"><label for="doj_s_d">{$LANG.search_results_sub_title_doj} </label></td>
                <td  class="{$myobj->getCSSFormFieldCellClass('doj_s_d')}">
                    <p>
                        <label for="doj_s_d"><label for="doj_s_d">{$LANG.search_results_label_doj_from}</label></label>
                        <select name="doj_s_d" id="doj_s_d" tabindex="{smartyTabIndex}" >
                        <option value="">-</option>
                        {$myobj->populateDaysList($myobj->getFormField('doj_s_d'))}
                        </select>&nbsp;
                        <select name="doj_s_m" id="doj_s_m" tabindex="{smartyTabIndex}" >
                        <option value="">-</option>
                        {$myobj->populateMonthsList($myobj->getFormField('doj_s_m'))}
                        </select>&nbsp;
                        <select name="doj_s_y" id="doj_s_y" tabindex="{smartyTabIndex}" >
                        <option value="">-</option>
                       	 {$myobj->populateYearsList($myobj->getFormField('doj_s_y'))}
                        </select>
                    </p>
                    <p>
                        <label for="doj_e_d"><label for="doj_e_d">{$LANG.search_results_label_doj_to}</label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <select name="doj_e_d" id="doj_e_d" tabindex="{smartyTabIndex}" >
                        <option value="">-</option>
                        {$myobj->populateDaysList($myobj->getFormField('doj_e_d'))}
                        </select>&nbsp;
                        <select name="doj_e_m" id="doj_e_m" tabindex="{smartyTabIndex}" >
                        <option value="">-</option>
                        {$myobj->populateMonthsList($myobj->getFormField('doj_e_m'))}
                        </select>&nbsp;
                        <select name="doj_e_y" id="doj_e_y" tabindex="{smartyTabIndex}" >
                        <option value="">-</option>
                        {$myobj->populateYearsList($myobj->getFormField('doj_e_y'))}
                        </select>
                    </p>                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('login_s_d')}"><label for="login_s_d">{$LANG.search_results_label_last_logged}</label></td>
                <td  class="{$myobj->getCSSFormFieldCellClass('login_s_d')}">
                    <p>
                        <label for="login_s_d"><label for="login_s_d">{$LANG.search_results_label_last_logged_from}</label>&nbsp;</label>
                        <select name="login_s_d" id="login_s_d" tabindex="{smartyTabIndex}" >
                        <option value="">-</option>
                        {$myobj->populateDaysList($myobj->getFormField('login_s_d'))}
                        </select>
                        <select name="login_s_m" id="login_s_m" tabindex="{smartyTabIndex}" >
                        <option value="">-</option>
                        {$myobj->populateMonthsList($myobj->getFormField('login_s_m'))}
                        </select>
                        <select name="login_s_y" id="login_s_y" tabindex="{smartyTabIndex}" >
                        <option value="">-</option>
                        {$myobj->populateYearsList($myobj->getFormField('login_s_y'))}
                        </select>
                    </p>
                    <p>
                        <label for="login_e_d"><label for="login_e_d">{$LANG.search_results_label_last_logged_to}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <select name="login_e_d" id="login_e_d" tabindex="{smartyTabIndex}" >
                        <option value="">-</option>
                        {$myobj->populateDaysList($myobj->getFormField('login_e_d'))}
                        </select>
                        <select name="login_e_m" id="login_e_m" tabindex="{smartyTabIndex}" >
                        <option value="">-</option>
                        {$myobj->populateMonthsList($myobj->getFormField('login_e_m'))}
                        </select>
                        <select name="login_e_y" id="login_e_y" tabindex="{smartyTabIndex}" >
                        <option value="">-</option>
                        {$myobj->populateYearsList($myobj->getFormField('login_e_y'))}
                        </select>
                    </p>                    </td>
            </tr>
            <tr>
              <td class="{$myobj->getCSSFormFieldCellClass('hasVideos')}"><label for="hasFriends">{$LANG.search_with_photos_videos_friends_groups}</label></td>
              <td  class="{$myobj->getCSSFormFieldCellClass('hasVideos')}">
              {if $myobj->module_array}
                 {foreach item=module_detail from=$myobj->module_array}
                 	<span><input type="checkbox" class="clsCheckRadio" id="{$module_detail.field_name}" name="{$module_detail.field_name}" {$myobj->isCheckedCheckBox($module_detail.field_name)} value="1" tabindex="{smartyTabIndex}"/><label for="{$module_detail.field_name}">&nbsp;{$module_detail.lang_value}</label>&nbsp;&nbsp;</span>
                 {/foreach}
             {/if}
              <span><input type="checkbox" class="clsCheckRadio" id="hasFriends" name="hasFriends" {$myobj->isCheckedCheckBox('hasFriends')} value="1" tabindex="{smartyTabIndex}"/><label for="hasFriends">&nbsp;{$LANG.search_with_friends}</label>&nbsp;&nbsp;</span>             </td>
             <td class="{$myobj->getCSSFormFieldCellClass('user_status_Ok')}" ><label for="user_status_Ok">{$LANG.search_results_label_status}</label></td>
             <td  class="{$myobj->getCSSFormFieldCellClass('user_status_Ok')}">
                <span><input type="checkbox" class="clsCheckRadio" value="Ok" id="user_status_Ok" name="user_status_Ok"  {$myobj->isCheckedCheckBox('user_status_Ok')} tabindex="{smartyTabIndex}"/><label for="user_status_Ok">{$LANG.search_results_label_status_active}</label></span>
                <span><input type="checkbox" class="clsCheckRadio" value="ToActivate" id="user_status_ToActivate" name="user_status_ToActivate" {$myobj->isCheckedCheckBox('user_status_ToActivate')} tabindex="{smartyTabIndex}"/><label for="user_status_ToActivate">{$LANG.search_results_label_status_in_active}</label></span>
                <span><input type="checkbox" class="clsCheckRadio" value="Locked" id="user_status_Locked" name="user_status_Locked" {$myobj->isCheckedCheckBox('user_status_Locked')} tabindex="{smartyTabIndex}"/><label for="user_status_Locked">{$LANG.search_results_label_status_locked}</label></span>             </td>
            </tr>
            {if $CFG.feature.membership_payment}
	            <tr>
	              <td class="{$myobj->getCSSFormFieldCellClass('user_type')}"><label for="user_type1">{$LANG.member_manage_payment_user_type}</label></td>
	              <td  class="{$myobj->getCSSFormFieldCellClass('user_type')}">
	               <input type="radio" name="user_type" id="user_type1" value="Yes" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('user_type','Yes')} />
	              <label for="user_type1">{$LANG.member_manage_paid_user}</label>
	              <input type="radio" name="user_type" id="user_type2" value="No" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('user_type','No')} />
	              <label for="user_type2">{$LANG.member_manage_unpaid_user}</label>
	              </td>
	              <td class="{$myobj->getCSSFormFieldCellClass('empty')}">&nbsp;</td>
	              <td  class="{$myobj->getCSSFormFieldCellClass('empty')}">&nbsp;

	              </td>
	            </tr>
            {/if}
            <tr>
                <td class="{$myobj->getCSSFormFieldCellClass('sort_field')}"><label for="sort_field">{$LANG.search_results_label_sort_by}</label></td>
                <td  class="{$myobj->getCSSFormFieldCellClass('sort_field')}">
	                <select name="sort_field" id="sort_field" tabindex="{smartyTabIndex}">
	                <option value="user_id" {$myobj->form_search.SORT_user_id}>{$LANG.search_results_label_sort_by_doj}</option>
	                <option value="user_name" {$myobj->form_search.SORT_user_name}>{$LANG.search_results_label_sort_by_user_name}</option>
	                <option value="last_logged" {$myobj->form_search.SORT_last_logged}>{$LANG.search_results_label_sort_by_last_visit}</option>
	                <option value="">{$LANG.search_results_label_sort_by_none}</option>
	                </select>
	                &nbsp;{$LANG.search_results_label_sort_in}&nbsp;
	                <select name="sort_field_order_by" id="sort_field_order_by" tabindex="{smartyTabIndex}">
	                    <option value="ASC" {$myobj->form_search.SORT_ORDER_ASC}>{$LANG.search_results_label_sort_in_asc}</option>
	                    <option value="DESC" {$myobj->form_search.SORT_ORDER_DESC}>{$LANG.search_results_label_sort_in_desc}</option>
	                </select>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('usr_type')}"><label for="usr_type">{$LANG.member_manage_user_type}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('usr_type')}">
					<select name="usr_type" id="usr_type" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.search_country_choose}</option>
						{$myobj->generalPopulateArray($myobj->user_types, $myobj->getFormField('usr_type'))}
					</select>
				</td>
            </tr>
            <tr>
                <td colspan="4" class="{$myobj->getCSSFormFieldCellClass('submit')}">
                    <input type="submit" class="clsSubmitButton" name="search_submit" id="search_submit" tabindex="{smartyTabIndex}" value="{$LANG.search_submit}" />
                    &nbsp;&nbsp;
                    <input type="submit" class="clsSubmitButton" name="search_submit_reset" id="search_submit_reset" tabindex="{smartyTabIndex}" value="{$LANG.search_submit_reset}" onclick=""/>
				</td>
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
    	<div id="selMsgChangeStatus" style="display:none;">
	      	<form name="formChangeStatus" id="formChangeStatus" class="clsCenterAlignTD" method="post" action="{$_SERVER.PHP_SELF}">
	        	<table class="clsNoBorder">
		          	<tr>
					  	<td colspan="2"><p id="msgConfirmText"></p></td>
		          	</tr>
		          	<tr>
				  		<td id="selPhotoGallery">
							<p id="profileIcon"></p>
						</td>
				  	</tr>
				  	<tr>
		            	<td>
						  	<input type="submit" class="clsSubmitButton" name="submit_yes" id="submit_yes" value="Activate" tabindex="{smartyTabIndex}" /> &nbsp;
			              	<input type="button" class="clsSubmitButton" name="submit_no" id="submit_no" value="Cancel" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
						</td>
		          	</tr>
	        	</table>
				<input type="hidden" name="action" id="action" />
	          	<input type="hidden" name="uid" id="uid" />
				{$myobj->populateHidden($myobj->form_list_members.populateHidden_arr)}
	      	</form>
	    </div>
        <!-- top pagination start-->
        {if $CFG.admin.navigation.top}
            {include file='pagination.tpl'}
        {/if}
        <table summary="{$LANG.member_list_tbl_summary}">
			<tr>
                <th>{$LANG.search_results_title_user_id_info}</th>
                <th  colspan="2">{$LANG.search_results_title_user_account_info}</th>
                <th>{$LANG.search_results_title_user_primary_info}</th>
                <th>{$LANG.search_results_title_user_site_info}</th>
                <th>{$LANG.search_results_title_status}</th>
                <th>{$LANG.action_links}</th>
			</tr>
			{foreach key=dmKey  item=dmValue from=$myobj->form_list_members.displayMembers.row}
                <tr class="{$dmValue.cssRowClass} {$dmValue.userClass}">
                	<td>
                    	<div>	{$dmValue.record.user_id} </div>
                    </td>
                    <td>
                    	<ul>
							<li><span class="clsProfileThumbImg"><a href="{$dmValue.memberProfileUrl}">{$dmValue.record.user_name}</a></span></li>
							<li id="imgProfileIcon_{$dmValue.user_id}">
		                        <span class="clsProfileThumbImg">
		                            <a href="{$dmValue.memberProfileUrl}">
		                                <img src="{$dmValue.icon.t_url}" alt="{$dmValue.record.user_name}" title="{$dmValue.record.user_name}" {$myobj->DISP_IMAGE(45, 45, $dmValue.icon.t_width, $dmValue.icon.t_height)} />
		                            </a>
		                        </span>
                        	</li>
                        </ul>
					</td>
                    <td>
	                    <ul class="clsListValues">
	                    	<li>
								<div>{$dmValue.record.first_name|cat:' '|cat:$dmValue.record.last_name|wordWrap_mb_Manual:15:15}</div>
							</li>
	                    	<li>
								<div class="clsLeft">{$LANG.search_results_sub_title_age}</div>
								<div class="clsRight">{$dmValue.record.age}&nbsp;</div>
							</li>
	                    	<li>
								<div class="clsLeft">{$LANG.search_results_sub_title_last_logged}</div>
								<div class="clsRight">{if $dmValue.record.last_logged == '0000-00-00 00:00:00'}{$LANG.search_results_sub_title_not_visited}{else}{$dmValue.record.last_logged|date_format:#format_date_year#}{/if}</div>
							</li>
	                    	<li>
								<div class="clsLeft">{$LANG.search_results_sub_title_doj}</div>
								<div class="clsRight">{$dmValue.record.doj|date_format:#format_date_year#}</div>
							</li>
	                    	<li>
								<div class="clsLeft">{$LANG.member_manage_user_type}</div>
								<div class="clsRight">{$myobj->getUserTypeName($dmValue.record.usr_type)}</div>
							</li>
	                    </ul>
					</td>
                    <td>
                    	<ul class="clsListValues">
							<li>
								<div class="clsLeft">{$LANG.search_results_sub_title_email}</div>
								<div class="clsRight">{$dmValue.record.email}</div>
							</li>
		                    <li>
								<div class="clsLeft">{$LANG.search_results_sub_title_city}</div>
								<div class="clsRight">{$dmValue.record.city}&nbsp;</div>
							</li>
		                    <li>
								<div class="clsLeft">{$LANG.search_results_sub_title_zip}</div>
								<div class="clsRight">{$dmValue.record.postal_code}&nbsp;</div>
							</li>
		                    <li>
								<div class="clsLeft">{$LANG.search_results_sub_title_country}</div>
								<div class="clsRight">{$dmValue.country}&nbsp;</div>
							</li>
						</ul>
					</td>
                    <td>
						<p>{$LANG.search_results_title_friends} {if $dmValue.record.total_friends != ''}({$dmValue.record.total_friends}){/if} </p>
                      	{foreach key=marrKey  item=marrValue from=$dmValue.modules_arr}
                      		<p>{$marrValue.total_upload}</p>
                    	{/foreach}
					</td>
                    <td>{$dmValue.accountStatus}</td>
                   	<td>
						<ul>
							{if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'user_manage', 'Edit')}
								<li><a href="memberAdd.php?user_id={$dmValue.user_id}{$dmValue.sessionSearchQueryString}" >{$LANG.search_results_link_edit}</a></li>
							{/if}
							{if $CFG.user.user_id ne $dmValue.user_id}
	                    		{if $dmValue.activateLink AND ($CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'user_manage', 'Activate'))}
		                        	<li>
			                        	<a href="javascript:void(0);"  onClick="return activateMember('{$dmValue.user_id}')">{$LANG.search_results_link_activate}</a>
		                        	</li>
	                        	{/if}
	                        	{if $dmValue.deActivateLink AND ($CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'user_manage', 'Inactivate'))}
		                        	<li>
		                         		<a href="javascript:void(0);" onClick="return deActivateMember('{$dmValue.user_id}')">{$LANG.search_results_link_de_activate}</a>
		                         	</li>
	                        	{/if}
	                        {/if}
	                        {if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'user_manage', 'View')}
		                        <li>
		                            <a href="{$dmValue.memberProfileUrl}" >{$LANG.search_results_link_view}</a>
		                        </li>
	                        {/if}
	                        {if $CFG.user.user_id ne $dmValue.user_id}
	                        	{if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'user_manage', 'Delete')}
			                    	<li>
			                       		<a href="javascript:void(0);" onClick="return deleteMember('{$dmValue.user_id}')">
			                        		{$LANG.search_results_link_delete}
			                        	</a>
			                        </li>
			                    {/if}
	                        {/if}
	                        {if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'user_manage', 'Featured')}
		                        {if $dmValue.record.featured == 'Yes'}
		                       		<li>
		                                <a href="javascript:void(0);" onClick="return removeFeaturedMember('{$dmValue.user_id}')">
		                                    {$LANG.search_results_link_remove_feature}
		                                </a>
		                            </li>
		                        {else}
		                       		 <li>
		                             	<a href="javascript:void(0);" onClick="return setFeaturedMember('{$dmValue.user_id}')">
		                             	   {$LANG.search_results_link_set_featured}
		                                </a>
		                             </li>
	                        	{/if}
	                        {/if}
	                        {if chkAllowedModule(array('video')) and $CFG.admin.videos.show_background_image_link_admin}
	                            {if $dmValue.record.is_upload_background_image == 'No'}
	                                <li>
	                                    <a href="javascript:void(0);" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('ch_status', 'uid', 'act', 'confirmMessage'), Array('Yes', '{$dmValue.user_id}', 'is_upload_background_image', '{$LANG.member_manage_approve_msg}'), Array('value', 'value', 'value', 'innerHTML'));">
	                                        {$LANG.member_manage_approve}
	                                     </a>
	                                 </li>
	                            {else}
	                                <li>
	                                    <a href="javascript:void(0);" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('ch_status', 'uid', 'act', 'confirmMessage'), Array('No', '{$dmValue.user_id}', 'is_upload_background_image', '{$LANG.member_manage_disapprove_msg}'), Array('value', 'value', 'value', 'innerHTML'));">
	                                      {$LANG.member_manage_disapprove}
	                                    </a>
	                                </li>
	                            {/if}
	                        {/if}
	                        {if $CFG.feature.signup_payment}
		                        {if $dmValue.record.is_paid_member == 'Yes'}
		                        	<li
		                             	<a href="javascript:void(0);" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('ch_status', 'uid', 'act', 'confirmMessage'), Array('No', '{$dmValue.user_id}', 'is_paid_member', '{$LANG.member_confirm_remove_as_paidmembers}'), Array('value', 'value', 'value', 'innerHTML'));">
		                                    {$LANG.member_remove_as_paidmembers}
	                                  </a>
	                                </li>
		                        {else}
		                        	<li>
		                             	<a href="javascript:void(0);" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('ch_status', 'uid', 'act', 'confirmMessage'), Array('Yes', '{$dmValue.user_id}', 'is_paid_member', '{$LANG.member_confirm_set_as_paidmembers}'), Array('value', 'value', 'value', 'innerHTML'));">
		                                    {$LANG.member_set_as_paidmembers}
	                                 	</a>
	                                </li>
		                        {/if}
	                        {/if}
						</ul>
					</td>
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