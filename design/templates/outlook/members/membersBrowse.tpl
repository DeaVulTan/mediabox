{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selMemberList">
	<div class="clsPageHeading"><h2>{$LANG.browse_criteria_title}&nbsp;</h2></div>
	{if isMember()}
    <div class="clsPaddingLeftRight">
	   	<p class="clsBrowseMemberLink">
       	<a href="{$myobj->getUrl('memberslist')}" id="selMemberBrowseLinkID">{$LANG.common_members_list_list_members}</a>
	   	<a class="clsBlockUser" href="{$myobj->getUrl('memberblock', '', '', 'members')}" id="selMemberBlockLinkId">{$LANG.members_list_blocked_members}</a>
   		</p>
   </div>
   {/if}
  	<div class="clsShowHideFilter">
  	   <a href="#" class="clsHideFilterSearch" onclick="showSearchForm();this.blur();return false;" id="anchorToggleSearchForm">
		<span>{$LANG.browse.form_title_anchor_hide_search_form}</span></a>
  	</div>
	{$myobj->setTemplateFolder('general/')}
	{include file='information.tpl'}
  	<div id="selSetBrowseCriteria">
		{if $myobj->isShowPageBlock('form_browse_criteria')}
     	 	<div id="selBrowseCriteria" class="clsDataTable clsMembersBrowseTable clsFriendSearchTable">
   			<form name="formSetBrowseCriteria" id="formSetBrowseCriteria" method="post" action="{$myobj->getCurrentUrl()}">
            {*include file='box.tpl' opt='form_top'*}
            <table>
            	<tr>
                	<th colspan="4"><span>{$LANG.browse.form_title}</span></th>
                </tr>
                <tr>
                	<td class="clsGenderWiseSearch">{$LANG.browse.gender_title}</td>
                  	<td colspan="3" class="clsCheckBoxList">
                    	<p>
							<span class="clsCheckBox"><input type="radio" class="clsCheckRadio clsNoBorder" tabindex="{smartyTabIndex}" name="gender" id="women" value="female" {$myobj->form_browse_criteria.female}/></span>
                        	<label for="women">{$LANG.browse.gender_women}</label>
						</p>
                        <p>
							<span class="clsCheckBox"><input type="radio" class="clsCheckRadio clsNoBorder" tabindex="{smartyTabIndex}" name="gender" id="men" value="male" {$myobj->form_browse_criteria.male}/></span>
                        	<label for="men">{$LANG.browse.gender_men}</label>
						</p>
                        <p>
							<span class="clsCheckBox"><input type="radio" class="clsCheckRadio clsNoBorder" tabindex="{smartyTabIndex}" name="gender" id="both" value="both" {$myobj->form_browse_criteria.both}/></span>
                        	<label for="both">{$LANG.browse.gender_both}</label>
						</p>
                  	</td>
                </tr>
                <tr>
                	<td><label for="age_prefer_yes">{$LANG.browse.age}</label></td>
                  	<td colspan="3">
                    	<p>
                    		<input type="radio" class="clsCheckRadio clsNoBorder" name="age_prefer" {$myobj->form_browse_criteria.agePreferYes} id="age_prefer_yes" value="1" onclick="agePreferOptions()" tabindex="{smartyTabIndex}" />
                      		<select name="age_start" id="age_start" tabindex="{smartyTabIndex}">
                        		<option value=''>{$LANG.members_choose}</option>
                        		{foreach key=inc item=value from=$myobj->form_browse_criteria.ageSetStart_arr}
                        		<option value='{$value.values}' {$value.selected}>{$value.values}</option>
                        		{/foreach}                        		
                      		</select>
                      		<label for="age_end">{$LANG.browse_and}</label>
                      		<select name="age_end" id="age_end" tabindex="{smartyTabIndex}" >
                        		<option value=''>{$LANG.members_choose}</option>
                        		{foreach key=inc item=value from=$myobj->form_browse_criteria.ageSetEnd_arr}
                        		<option value='{$value.values}' {$value.selected}>{$value.values}</option>
                        		{/foreach}
                      		</select>
                    	</p>
                    	<p><span class="clsCheckBox"><input type="radio" tabindex="{smartyTabIndex}" class="clsCheckRadio clsNoBorder" {$myobj->form_browse_criteria.agePreferNo} name="age_prefer" id="age_prefer_no" value="0" onclick="agePreferOptions()"/><label for="age_prefer_no">{$LANG.browse.age_no_preference}</label></span></p>
                    </td>
                </tr>
                <tr>
                	<td><p>{$LANG.browse.relation_status}&nbsp;&nbsp;</p></td>
                  	<td colspan="3" class="clsCheckBoxList">
                  		{foreach key=inc item=value from=$myobj->form_browse_criteria.relation_status}
                       		<p><span class="clsCheckBox"><input type="checkbox" class="clsCheckBox clsNoBorder" name="{$value.field_name}[]" id="{$value.id}" value="{$value.values}" {$value.checked} tabindex="{smartyTabIndex}"/></span><label for="{$value.id}">{$value.description}</label></p>
                   		{/foreach}
                   	</td>
                </tr>
                <tr>
                	<td colspan="4"> <h4>{$LANG.browse.location}</h4></td>
                </tr>
                <tr>
                	<td><p><label for="country">{$LANG.browse.country}</label>&nbsp;&nbsp;</p></td>
                  	<td colspan="3">
                      <select name="country" id="country" tabindex="{smartyTabIndex}">
                        {$myobj->populateUserCountriesList($myobj->getFormField('country'))}
                      </select>
                    </td>
                </tr>
                {if $myobj->block_show_htmlfields}
                {section name=quest_cat loop=$myobj->block_show_htmlfields}
                <tr><th colspan="4"><span>{$myobj->block_show_htmlfields[quest_cat].title}</span></th></tr>
                {foreach key=inc item=value from=$myobj->block_show_htmlfields[quest_cat].questions}
         			{if $value.question_type=='text'}
                		<tr>
                    		<td class="{$value.label_cell_class}">
                        		<label for="{$value.question}">{$value.question}</label>
                    		</td>
                    		<td colspan="3" class="{$value.field_cell_class}">
                            	{assign var="temp_name" value=$value.id}
                    			<input type="text" class="clsTextBox" name="{$value.id}" id="{$value.question}" tabindex="{smartyTabIndex}" value="{if $smarty.post}{$smarty.post.$temp_name}{/if}" maxlength="{$value.max_length}" style="{$value.width}"/>
                    			<div class="clsHelpText" id="{$value.question}_Help" style="visibility:hidden">{$value.instruction}</div>
                    		</td>
                		</tr>
        			{/if}
	        		{if $value.question_type=='textarea'}
	                	<tr>
	                		<td class="{$value.label_cell_class}"><label for="{$value.question}">{$value.question}</label></td>
	                    	<td colspan="3" class="{$value.field_cell_class}">
                            	{assign var="temp_name" value=$value.id} 
	                    		<textarea class="clsTextBox" name="{$value.id}" id="textArea_{$value.id}" tabindex="{smartyTabIndex}" rows="{$value.rows}" style="{$value.width}">{if $smarty.post}{$smarty.post.$temp_name}{/if}</textarea>
	                    		<div class="clsHelpText" id="textArea_{$value.id}_Help" style="visibility:hidden">{$value.instruction}</div>
	                    	</td>
	                	</tr>
	        		{/if}
	        		{if $value.question_type=='password'}
	                	<tr>
	                		<td class="{$value.label_cell_class}"><label for="{$value.question}">{$value.question}</label></td>
	                    	<td colspan="3" class="{$value.field_cell_class}">
                            	{assign var="temp_name" value=$value.id} 
	                    		<input type="password" class="clsTextBox" name="{$value.id}" id="{$value.question}" tabindex="{smartyTabIndex}" value="{if $smarty.post}{$smarty.post.$temp_name}{/if}" maxlength="{$value.max_length}"/>
	                    		<div class="clsHelpText" id="{$value.question}_Help" style="visibility:hidden">{$value.instruction}</div>
	                    	</td>
	                	</tr>
	        		{/if}
	        		{if $value.question_type=='radio'}
	        			<tr>
	            			<td class="{$value.label_cell_class}"><label>{$value.question}</label></td>
	            			<td colspan="3" class="clsCheckBoxList">
	            				{foreach key=ssokey item=ssovalue from=$value.option_arr}
	              				{assign var = checkboxId value = $value.id}
	                           	<p><span class="clsCheckBox"><input type="checkbox" class="clsCheckRadio clsNoBorder" tabindex="{smartyTabIndex}" id="opt_{$ssokey}_{$value.id}" name="{$value.id}[]"
							   	{php}
	            			   		$obj_ref = $this->get_template_vars('myobj');
	            					if(in_array($this->get_template_vars('ssovalue'),$obj_ref->getFormField($this->get_template_vars('checkboxId')))) { echo 'checked="checked"'; }
	            				{/php}
	         					value="{$ssovalue}" /></span><label for="opt_{$ssokey}_{$value.id}">{$ssovalue}</label></p>
	            				{/foreach}
	            				<div class="clsHelpText" id="opt_{$ssovalue.ssokey}_{$value.id}_Help" style="visibility:hidden">{$value.instruction}</div>
	            			</td>
	        			</tr>
	        		{/if}
	        		{if $value.question_type=='checkbox'}
	        			<tr>
	            			<td class="{$value.label_cell_class}"><label>{$value.question}</label></td>
	            			<td colspan="3" class="clsCheckBoxList" align="left">
			        			{foreach key=ssokey item=ssovalue from=$value.option_arr}
			        			{assign var = checkboxId value = $value.id}
			        			<p><span class="clsCheckBox"><input type="checkbox" class="clsCheckRadio clsNoBorder" tabindex="{smartyTabIndex}" id="opt_{$ssokey}_{$value.id}" name="{$value.id}[]"
					            {php}
			        				$obj_ref = $this->get_template_vars('myobj');
			        				if(in_array($this->get_template_vars('ssovalue'),$obj_ref->getFormField($this->get_template_vars('checkboxId')))) { echo 'checked="checked"'; }
			        			{/php}
			      				value="{$ssovalue}" /></span><label for="opt_{$ssokey}_{$value.id}">{$ssovalue}</label></p>
			        			{/foreach}
	            				<div class="clsHelpText" id="opt_{$ssovalue.ssokey}_{$value.id}_Help" style="visibility:hidden">{$value.instruction}</div>
	            			</td>
	        			</tr>
	        		{/if}
	        		{if $value.question_type=='select'}
	        			<tr>
	            			<td class="{$value.label_cell_class}"><label for="{$value.question}">{$value.question}</label></td>
	            			<td colspan="3" class="{$value.field_cell_class}">
	            			<select class="clsMemberBrowseSelect" name="{$value.id}[]" id="{$value.question}" tabindex="{smartyTabIndex}" multiple="multiple" size="{$CFG.admin.members.browse_members_select_box_size}">
		                		{foreach  key=item item=sovalue from=$myobj->multiSelectPopulateArray($value.option_arr)}
		                			{assign var = selectId value = $value.id}
		                			{assign var = optval value = $sovalue.values}
		                			<option value="{$sovalue.values}"
		                			{php}
		                 			$obj_ref = $this->get_template_vars('myobj');
		                  			if(in_array($this->get_template_vars('optval'),$obj_ref->getFormField($this->get_template_vars('selectId')))) { echo 'selected="selected"'; }
		                			{/php} >{$sovalue.optionvalue}</option>
		                		{/foreach}
	            			</select>
	            			<div class="clsHelpText" id="{$value.question}_Help" style="visibility:hidden">{$value.instruction}</div>
	            			</td>
	        			</tr>
	        		{/if}
        		{/foreach}
                {/section}
                {/if}
                <tr>
                	<td><h4>{$LANG.browse.field_sortresult_title}</h4></td>
                  	<td colspan="3" class="clsCheckBoxList">
                    	<input type="hidden" value="{$myobj->question_ids}" name="question_ids"/>
                      	<p>
						  <span class="clsCheckBox"><input type="radio" class="clsCheckRadio clsNoBorder" name="sort_result" {$myobj->form_browse_criteria.last_active} value="last_active" id="sort_result_last_active"/></span>
                      	  <label for="sort_result_last_active">{$LANG.browse.field_sortresult_recent}</label>
						</p>
                      	<p>
						  <span class="clsCheckBox"><input type="radio" class="clsCheckRadio clsNoBorder" name="sort_result" {$myobj->form_browse_criteria.last_logged} value="last_logged" id="sort_result_last_logged"/></span>
                      	  <label for="sort_result_last_logged">{$LANG.browse.field_sortresult_last_logged}</label>
						</p>
                      	<p>
						  <span class="clsCheckBox"><input type="radio" class="clsCheckRadio clsNoBorder" name="sort_result" {$myobj->form_browse_criteria.doj} value="doj" id="sort_result_doj"/></span>
                      	  <label for="sort_result_doj">{$LANG.browse.field_sortresult_new_to_rayzz}</label>
						</p>
                  	</td>
                </tr>
                <tr>
                	<td colspan="4">
                    	<div class="clsListSubmitLeft"><div class="clsListSubmitRight"><input type="submit" class="clsSubmitButton" name="browse_submit" id="browse_submit" value="{$LANG.browse_submit}" /></div></div><div class="clsCancelMargin"><div class="clsListCancelLeft"><div class="clsListCancelRight"><input type="reset" class="clsSubmitButton" name="browse_reset" id="browse_reset" value="{$LANG.browse_reset}" /></div></div></div>
                    </td>
                </tr>
            </table>
            {*include file='box.tpl' opt='form_bottom'*}
  			</form>
 		 	</div>
		{/if}{* end of form_browse_criteria condition*}

		{if $myobj->isShowPageBlock('form_list_members')}
   			{if $myobj->isShowPageBlock('show_result_heading')}
  				<h2 class="clsBrowseResult">{$LANG.browse.search_title_result}</h2>
   			{/if}
  			<div id="selMembersListing">
				{if $CFG.admin.navigation.top}
                	{if $smarty_paging_list}
				  <div class="clsTopPagination">	
         			{include file='pagination.tpl'}
				  </div>	
                  {/if}
        		{/if}
        		<div class="clsMemberListTable clsListTable clsMemberListMainTable">
		    	<table summary="{$LANG.member_list_tbl_summary}" id="selMembersBrowseTable" class="clsMembersDisplayTbl clsContentsDisplayTbl">

			 		{foreach key=inc item=values from=$myobj->form_list_members.displayMembers}
  						{if $values.open_tr}
                    		<tr>
                    	{/if}
                        	<td class="selPhotoGallery">
                            <ul class="clsMembersPhotoListDisplay">
                              <li id="memberlist_videoli_{$inc}" onmouseover="showVideoDetail(this)" onmouseout="hideVideoDetail(this)">
                                 	<div class="clsUserMenuContainer selMemberName">
                                    	<div class="clsMemberImageContainer">
                                            	<a class="ClsImageContainer ClsImageBorder2 Cls90x90" href="{$values.memberProfileUrl}" >
		                                        	<img src="{$values.profileIcon.t_url}" alt="{$values.record.user_name|truncate:9}" title="{$values.record.user_name}" {$myobj->DISP_IMAGE(#image_thumb_width#, #image_thumb_height#, $values.profileIcon.t_width, $values.profileIcon.t_height)} />
		                                        </a>
                            					<p class="selMemberName clsPaddingTop9"><a href="{$values.record.user_name}">{$values.record.user_name}</a></p>
                                            <a href="#" class="clsMemberInfo clsDisplayNone" id="memberlist_info_{$inc}" onmouseover="showVideoDetail(this)"></a>
                                        </div>
                                     </div>
                                   {if $CFG.admin.members_listing.online_status}
								   	  <p class="clsOnline"><a class="{$values.onlineStatusClass}" title="{$values.currentStatus}">{$values.currentStatus}</a></p>
								   {/if}
                                {* Popup content Start *}
                                     
                                <div class="clsPopInfoWidth clsPopInfo clsDisplayNone  {if $values.end_tr} clsPopInfoRight {/if}" id="memberlist_selVideoDetails_{$inc}">
                                  <div class="clsPopUpDivContainer {if $values.end_tr} clsPopUpDivLastContainer {/if}"> {$myobj->setTemplateFolder('general/')}
                                    {include file='box.tpl' opt='popinfo_top'}
                                        <div class="clsPopUpPaddingContent">
                                          <p class="clsPopUpInnerContainer"><a href="{$values.memberProfileUrl}" {$values.online}>{$values.record.user_name}</a> {$values.userLink} | <strong> <span>{$values.record.age}</span>, <span>{$values.record.sex|capitalize}</span>,</strong> <span>{$values.country}</span></p>
                                          <div class="clsOverflow">
                                             <div class="clsPopUpInnerContainer clsPopUpContentBtm"> 
                                                {if $myobj->listDetails}
                                                    {$LANG.member_browse_member_joined}:&nbsp;
                                                    <span>
                                                        {if $values.record.doj neq '0000-00-00 00:00:00'}
                                                            {$values.record.doj|date_format:#format_date_year#}
                                                        {/if}
                                                    </span>
                                                    &nbsp; | &nbsp;
                                                {/if}{* listDetails if end *}
                                                    {$LANG.members_browse_member_last_login}:&nbsp;
                                                    <span>
                                                        {if $values.last_logged neq '0000-00-00 00:00:00'}
                                                            {$values.last_logged|date_format:#format_date_year#}
                                                        {else}
                                                            {$LANG.members_browse_member_first_login}
                                                        {/if} 
                                                    </span> 
                                            </div>
                                             <div id="selMemDetails" class="clsMembersList clsPopUpContentRight"> 
                                                {if isMember()}
                                                      {if $CFG.user.user_id != $values.record.user_id}
                                                          <p id="selSendMsg"><a class="clsSendMessage clsPhotoVideoEditLinks" href="{$values.mailComposeUrl}" title="{$LANG.member_list_send_message}">{$LANG.member_list_send_message}</a></p>
                                                          {if $values.friend == 'yes'}
                                                          <p id="selAlReadyFriend"><a class="clsAlreadyFriend" title="{$LANG.members_list_friend}" class="clsPhotoVideoEditLinks">{$LANG.members_list_friend}</a></p>
                                                          {else}
                                                          <p id="selAddFriend"><a class="clsAddToFriends clsPhotoVideoEditLinks" href="{$values.friendAddUrl}" title="{$LANG.member_list_add_friend}">{$LANG.member_list_add_friend}</a></p>
                                                          {/if}                                     
                                                      {/if}          
                                                  
                                                  {else}
                                                      <p id="selSendMsg"><a class="clsSendMessage clsPhotoVideoEditLinks" href="{$values.mailComposeUrl}" title="{$LANG.member_list_send_message}">{$LANG.member_list_send_message}</a></p>
                                                      <p id="selAddFriend"><a class="clsAddToFriends clsPhotoVideoEditLinks" href="{$values.friendAddUrl}" title="{$LANG.member_list_add_friend}">{$LANG.member_list_add_friend}</a></p>
                                                  {/if} 
                                              </div>
                                           </div>	  
                                        </div>
                                        <div class="clsPopInfo-bottom">
                                          <div class="clsPopUpPaddingContentBtm clsOverflow">
                                            <div class="clsPopUpContentLeft">
                                               {if $myobj->listDetails}
                                                   {* stats_display_as_text else part *}
                                                      {assign var=break_count value=0}
                                                         <ul class="clsMemberPopUpBox">
                                                            {if $myobj->friendsCount}
                                                            	{assign var=break_count value=$break_count+1}
																<li>
                                                                {$LANG.browse_result_user_friends}:
                                                                {if $values.record.total_friends > 0} <a href="{$values.viewfriendsUrl}" title="{$values.friend_icon_title}">{$values.record.total_friends}</a> {else} <span>{$values.record.total_friends}</span> {/if} </li>                                                
                                                             {/if} 
                                                                {assign var=totcnt value= $CFG.site.modules_arr|@count}
                                                                {assign var=totcnt value=$totcnt-1}                                                                    
                                                                {foreach from= $CFG.site.modules_arr item=module_value}
                                                                      {if chkAllowedModule(array($module_value))}
                                                                          {assign var=break_count value=$break_count+1}
                                                                          {assign var='total_stats' value=$module_value|cat:'_icon_title'}
                                                                          {assign var='icon_url' value=$module_value|cat:'ListUrl'}
                                                                            {assign var='total_stats_value' value='total_'|cat:$module_value|cat:'s'}						   
                                                                          {assign var='image1_exists' value=$module_value|cat:'_image1_exists'}
                                                                          {assign var='image2_exists' value=$module_value|cat:'_image2_exists'}
                                                                          
                                                                          <li class="clsListValues">{$values.$total_stats_value}</li>
                                                                          {if ($break_count > 3 && $totcnt neq $inc)}
                                                                                </ul>
                                                                                <ul class="clsMemberPopUpBox">
                                                                                {assign var=break_count value=0}
                                                                          {/if}
                                                                          
                                                                       {/if}
                                                                {/foreach}                                        
                                                         </ul>
                                                        {* stats_display_as_text if end *}
                                                    {/if}                                              
                                              </div>                        
                                          </div>
                                        </div>
                                    {$myobj->setTemplateFolder('general/')}
                                    {include file='box.tpl' opt='popinfo_bottom'} </div>
                                </div>
                                
                                {* popup content end *}
                                     
                                     
                              </li>
                            </ul>
						 	</td>
 					 	{if $values.end_tr}
                       		</tr>
                     	{/if}
					{/foreach}
					{if $myobj->final_tr_close}
                    	<td colspan="{$myobj->member_per_row}">&nbsp;</td>
                    	</tr>
                    {/if}
    		</table>
		{if $CFG.admin.navigation.bottom}
           {if $smarty_paging_list}
             <div class="clsMarginRight10">	
               {include file='pagination.tpl'}
             </div>	
           {/if}
        {/if}
        </div>
    </div>
	{/if}{* end of form_list_members condition*}
</div>
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
{if $myobj->resultFound}
	<script type="text/javascript">
		showSearchForm();
	</script>
{/if}
<script type="text/javascript" language="javascript" src="{$CFG.site.url}js/videoDetailsToolTip.js"></script>