<h2>{$LANG.viewprofile_title}</h2>
<p class="clsBackLink"><a href="memberManage.php">{$LANG.common_back}</a></p>
<!-- information div -->
{$myobj->setTemplateFolder('admin/')}
{include file='information.tpl'}
{if $myobj->isShowPageBlock('form_show_profile')}
	<div id="actionBlock">
		{if $myobj->form_show_profile.user_details_arr.usr_status == 'Ok'}
	        <p class="clsPageLink">
	        	<a href="{$myobj->form_show_profile.userProfileLink}" target="_blank">
	            	{$myobj->form_show_profile.user_details_arr.user_name}
	            </a>{$LANG.myprofile_view_profile}
	        </p>
	        <p>
	        	<a href="{$myobj->form_show_profile.userProfileLink}" >
	            	{$myobj->form_show_profile.userProfileLink}
	            </a>
	        </p>
		{else}
			<p class="clsPageLink">
				{$myobj->form_show_profile.user_details_arr.user_name}
			</p>
		{/if}
	</div>
    <table class="clsWithoutBorder">
    	<tr>
    		<td class="clsWithoutBorder clsProfileDatas">
           		<table id="{$CFG.profile_box_id.profile_icon}" cellspacing="0" {$myobj->form_show_profile.defaultTableBgColor} >
                    <tr>
                        <td rowspan="2">
                          	<p id="selImageBorder" class="clsPlainImageBorder">
                                <span id="selPlainCenterImage">
                                	<a href="{$myobj->form_show_profile.user_details_arr.profile_url}">
                                    	<img src="{$myobj->form_show_profile.userIcon.t_url}" alt="{$myobj->form_show_profile.user_details_arr.user_name}" border="0" {$myobj->DISP_IMAGE(#image_thumb_width#,#image_thumb_height#,$myobj->form_show_profile.userIcon.t_width,$myobj->form_show_profile.userIcon.t_height)}" />
                                    </a>
                               </span>
                          	</p>
                        </td>
                        <td>
                            <table class="clsNoBorder clsNoMargin">
                                <tr>
                                    <th class="text clsProfileTitle">
                                        <span class="whitetext12">
                                            {$myobj->form_show_profile.user_details_arr.user_name}
                                        </span>
                                    </th>
                                    <td>&nbsp;

                                    </td>
                                </tr>
                                {if $myobj->form_show_profile.currentStatus}
                                    <tr>
                                        <td colspan="2" class="text clsTextBox">
                                            <span class="{$myobj->form_show_profile.onlineStatusClass}">
                                                {$myobj->form_show_profile.currentStatus}
                                            </span>
                                        </td>
                                    </tr>
                                {/if}
                        	</table>
                        </td>
                    </tr>
                    <tr>
                        <td class="text clsTextBox clsProfilePadding" id="selUserProfileDetailTable" >
                            <div id="selDet" >
                                <p>
                                    {$myobj->form_show_profile.details}
                                </p>
                                <p class="clsProfileViews">
                                    {$myobj->form_show_profile.user_details_arr.profile_hits}&nbsp;&nbsp;{$LANG.myprofile_navi_profile_views}
                                </p>
                             </div>
                        </td>
                    </tr>
           		</table>

           		<table id="{$CFG.profile_box_id.table_all_stats}" cellspacing="0" {$myobj->form_show_profile.defaultTableBgColor}>
                    <tr>
                        <td class="text clsProfileTitle" {$myobj->form_show_profile.defaultBlockTitle}>
                        	<span class="whitetext12">
                            	{$LANG.myprofile_title_all_stats}
                            </span>
                        </td>
                        <td {$myobj->form_show_profile.defaultBlockTitle}>
                        	&nbsp;
                        </td>
                    </tr>
                    {$myobj->displayRecord($LANG.myprofile_age, $myobj->form_show_profile.user_details_arr.age)}
                    {$myobj->displayRecord($LANG.myprofile_gender, $myobj->form_show_profile.user_details_arr.sex)}
                    {$myobj->displayRecord($LANG.myprofile_country, $myobj->form_show_profile.country)}
                    {$myobj->displayRecord($LANG.myprofile_user_type, $myobj->form_show_profile.usr_type)}
                    {$myobj->displayRecord($LANG.myprofile_relation_status, $myobj->form_show_profile.relation)}

                    {if $myobj->form_show_profile.user_details_arr.show_dob}
                    	<tr>
                            <td class="text clsProfileSideTitle">
                            	{$LANG.myprofile_birthday}
                            </td>
                        	<td>
                            	{$myobj->form_show_profile.user_details_arr.birthday|date_format:#format_date#}
                            </td>
                        </tr>
                        <tr>
                            <td class="text clsProfileSideTitle">
                            	{$LANG.myprofile_zodiac}
                            </td>
                            <td>
                            	{$myobj->getZodiacSign($myobj->form_show_profile.user_details_arr.dob_zodiac)}
                            </td>
                        </tr>
                	{/if}
           		</table>
                {if $myobj->form_show_profile.module_statistics_arr.row}
                     <table  {$myobj->form_show_profile.defaultTableBgColor}>
                        <tr>
                        	<td class="text clsProfileTitle" {$myobj->form_show_profile.defaultBlockTitle} >&nbsp;</th>
                            <td class="text clsProfileTitle" {$myobj->form_show_profile.defaultBlockTitle} >{$LANG.viewprofile_uploaded}</td>
                            <td class="text clsProfileTitle" {$myobj->form_show_profile.defaultBlockTitle} >{$LANG.viewprofile_views}</td>
                        </tr>

                        {foreach item=module_value from=$myobj->form_show_profile.module_statistics_arr.row}
                            <tr>
                                <td>{$module_value.lang}</td>
                                <td>{$module_value.total_uploaded}</td>
                                <td>{$module_value.total_views}</td>
                           </tr>
                        {/foreach}
                    </table>
                {/if}
                {if $personal_info_arr!=0}
                	<div class="clsPersonalInfoTable">
                      	<table >
                        	<tr>
                          		<th colspan="2" class="text clsProfileTitle" ><span class="whitetext12">{$LANG.myprofile_personal_info}</span></th>
                        	</tr>
                            <tr>
                          		<td colspan="2">
                            		<div class="clsProfileTableInfo">
                                		<table class="clsNoBorder clsNoMargin">
                                     		{foreach key=item item=value from=$personal_info_arr}
                                     			{if $value.answer_result != $CFG.profile.question_no_answer && $value.answer_result !=''}
                                     				<tr>
                                     					<td class="text clsProfileSideTitle"><p class="clsListing">{$value.question}</p></td>
				                                    	<td class="clsAnswerSection"><p class="clsListing">{$value.answer_result}</p></td>
				                                    </tr>
			                                    {/if}
		                                    {/foreach}
                            			</table>
                             		</div>
                            	</td>
                         	</tr>
                      	</table>
                	</div>
				{/if}
           		<!--{* {if $myobj->form_show_profile.temp OR $myobj->isEditableLinksAllowed()}
                    <table id="{$CFG.profile_box_id.table_personal_info}" cellspacing="0" {$myobj->form_show_profile.defaultTableBgColor}>
                        <tr>
                            <td class="text clsProfileTitle" {$myobj->form_show_profile.defaultBlockTitle}>
                                <span class="whitetext12">
                                    {$LANG.myprofile_title_personal_info}
                                </span>
                            </td>
                            <td {$myobj->form_show_profile.defaultBlockTitle}>
                                &nbsp;
                            </td>
                        </tr>
                       {foreach key=Key  item=value from=$myobj->form_show_profile.showTheseValuesIfExistIn}
                            <tr>
                              <td class="text clsProfileSideTitle">{$value.lang} </td>
                              <td>{$value.record} </td>
                            </tr>
                       {/foreach}
                   </table>
           		{/if} *} -->
           	</td>
            <td class="clsWithoutBorder" rowspan="2">
           		<table id="{$CFG.profile_box_id.table_vital_info}" cellspacing="0" {$myobj->form_show_profile.defaultTableBgColor}>
                    <tr>
                        <td class="text clsProfileTitle" {$myobj->form_show_profile.defaultBlockTitle}>
                            <span class="whitetext12">
                                {$LANG.myprofile_title_vital_info}
                            </span>
                        </td>
                        <td {$myobj->form_show_profile.defaultBlockTitle}>
                            &nbsp;
                        </td>
                    </tr>
                    {if  $myobj->form_show_profile.about_me OR $myobj->isEditableLinksAllowed()}
                        <tr>
                            <td class="text clsProfileSideTitle" >
                                {$LANG.myprofile_about_me}
                            </td>
                            <td>
                                {$myobj->form_show_profile.about_me}
                            </td>
                        </tr>
                    {/if}
	                <tr>
	                    <td class="text clsProfileSideTitle" >
	                        {$LANG.myprofile_member_since}
	                    </td>
	                    <td>
	                        {$myobj->form_show_profile.user_details_arr.doj|date_format:#format_date_year#}
	                    </td>
	                </tr>
	                <tr>
	                    <td class="text clsProfileSideTitle" >
	                        {$LANG.myprofile_last_active}
	                    </td>
	                    <td>
	                    	{if $myobj->form_show_profile.user_details_arr.last_active eq '0000-00-00 00:00:00'}
	                    		-
	                    	{else}
								{$myobj->form_show_profile.user_details_arr.last_active|date_format:#format_date_year#}
	                    	{/if}
	                    </td>
	                </tr>
           		</table>
				
                {*
           		{foreach item=module from=$CFG.site.modules_arr}
	                {if chkAllowedModule(array($module))}
	                	{$myobj->setTemplateFolder('admin/', $module)}
	                    {assign var=module_heading_tpl value='viewprofile_'|cat:$module|cat:'_block.tpl'}
	                   	{include file=$module_heading_tpl}
	               {/if}
           		{/foreach}
                *}
           		<table cellspacing="0" {$myobj->form_show_profile.defaultTableBgColor}>
	        		<tr>
	              		<td colspan="2" class="text clsProfileTitle" {$myobj->form_show_profile.defaultBlockTitle}><span class="whitetext12">{$myobj->form_show_profile.user_details_arr.user_name}'s {$LANG.myprofile_shelf_friends}</span></td>
	            	</tr>
		            {if !$myobj->form_show_profile.hasFriends}
		                <tr>
		                	<td colspan="2">
		                  		<div id="selMsgAlert">
		                      		<p>{$LANG.viewprofile_friends_no_msg}</p>
		                    	</div>
		                  	</td>
		                </tr>
		            {else}
		                <tr><td colspan="2">
		                    <table id="{$CFG.profile_box_id.friends_list}">
		                    	<tr>
		                            {foreach key=dmfKey  item=dmfValue from=$myobj->form_show_profile.displayMyFriends.row}
		                                <td><p id="selImageBorder">
		                                	<a href="{$dmfValue.userDetails.profile_url}">
										 	<img src="{$dmfValue.icon.t_url}" alt="{$dmfValue.friendName}" title="{$dmfValue.friendName}" {$myobj->DISP_IMAGE(#image_thumb_width#,#image_thumb_height#,$dmfValue.icon.t_width, $dmfValue.icon.t_height)}" />
											</a>
										 </p></td>
		                            {/foreach}
		                    	</tr>
		                    </table>
		                </td></tr>
		            {/if}
           		</table>
                <table cellspacing="0" {$myobj->form_show_profile.defaultTableBgColor}>
	            	<tr>
	                    <td colspan="2" class="text clsProfileTitle" {$myobj->form_show_profile.defaultBlockTitle}>
	                        <span class="whitetext12">
	                            {$myobj->form_show_profile.user_details_arr.user_name}'s {$LANG.myprofile_shelf_scraps}
	                        </span>
	                   </td>
	                </tr>
	                <tr>
	                    <td colspan="2" id="profileCommentsSection">
	                     	{if $myobj->form_show_profile.displayProfileComments.totalResults gt 0}
	                        	<table width="100%" class="clsNoBorder" cellspacing="0" id="{$CFG.profile_box_id.scraps_list}">
	                            	{foreach key=dpcKey  item=dpcValue from=$myobj->form_show_profile.displayProfileComments.row}
		                                <tr>
		                                    <td class="clsImageWidth" id="selProfileComment"><p id="selImageBorder"><a href="{$dpcValue.commentorProfileUrl}"  {$dpcValue.online}><img src="{$dpcValue.profileIcon.s_url}" alt="{$dpcValue.record.user_name}" title="{$dpcValue.record.user_name}" {$myobj->DISP_IMAGE(#image_thumb_width#,#image_thumb_height#,$dpcValue.profileIcon.t_width,$dpcValue.profileIcon.t_height)}" /></a></p></td>
		                                    <td>
		                                    	<p class="clsUserName">{$dpcValue.record.display_date_added|date_format:#format_date_year#}{$LANG.viewprofile_comment_by}<a href="{$dpcValue.commentorProfileUrl}">{$dpcValue.record.user_name}</a></p>
		                                    	<p>{$dpcValue.record.comment}</p>
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td style="font: normal 11px tahoma"></td>
		                                </tr>
	                            	{/foreach}
	                        	</table>
	                       	{else}
	                            <div id="selMsgAlert">
	                            	<p>{$LANG.viewprofile_comments_no_msg}</p>
	                            </div>
	                        {/if}
                        </td>
                    </tr>
           		</table>
            </td>
        </tr>
    </table>
{/if}