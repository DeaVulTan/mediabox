{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selMembersBrowse" class="clsListTable">
  <div class="clsOverflow">
    <div class="clsListHeadingLeft">
      <h2><span>{$myobj->form_list_members.page_title}</span></h2>
    </div>
    <div class="clsListHeadingRight">
      <form id="members_nav" action="{$myobj->getUrl('memberslist', '', '')}" method="get" onSubmit="return false">
        <select id="browse" name="browse" onchange="membersNav()">	
          {$myobj->generalPopulateArray($populateMoreBrowseMembersLinks_arr, $myobj->getFormField('browse'))}		
        </select>
      </form>
    </div>
  </div>
  {literal}
  <script type="text/javascript">
	//new Autocompleter.SelectBox('browse', {submit: 'members_nav'});
	function membersNav()
		{
			memberUrl = {/literal}'{$myobj->getUrl('memberslist', '', '')}';{literal}
			memberUrl = memberUrl+'?browse='+$('browse').value;
			window.location = memberUrl;
		}
	</script>
  {/literal}
  
  {$myobj->setTemplateFolder('general/')}
  {include file='information.tpl'}
  <div id="selLeftNavigation" class="clsMemberListMain"> {if $myobj->isShowPageBlock('form_list_members')}
    {if isMember()}
    <div class="clsPaddingLeftRight">
      <p class="clsBrowseMemberLink"> <a href="{$myobj->getUrl('membersbrowse')}" id="selMemberBrowseLinkID">{$LANG.common_members_list_browse_members}</a> <a class="clsBlockUser" href="{$myobj->getUrl('memberblock', '', '', 'members')}" id="selMemberBlockLinkId">{$LANG.members_list_blocked_members}</a> </p>
    </div>
    {/if}
    <div id="membersThumsDetailsLinks" class="clsMembersRight clsShowHideFilter"> <a href="javascript:void(0);" id="show_link" class="clsShowFilterSearch"  onclick="divShowHide('advanced_search', 'show_link', 'hide_link');"><span>{$LANG.members_show_adv_filters}</span></a> <a href="javascript:void(0);" id="hide_link" style="display:none" class="clsHideFilterSearch"  onclick="divShowHide('advanced_search', 'show_link', 'hide_link');"> <span>{$LANG.members_hide_adv_filters}</span></a> </div>
    <div  id="advanced_search"  style="display:none;"  class="clsFriendSearchTable"> {*$myobj->setTemplateFolder('general/')*}
      {*include file='box.tpl' opt='form_top'*}
      <form id="membersAdvancedFilters" name="membersAdvancedFilters" method="post" action="{$myobj->getCurrentUrl(false)}">
        <div class="clsOverflow">
          <div class="clsAdvancedSearchBg">
            <table class="clsAdvancedFilterTable">
              <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('uname')}"><input type="text" class="clsTextBox selAutoText" name="uname" id="uname" tabindex="{smartyTabIndex}" value="{if $myobj->getFormField('tags')}{$myobj->getFormField('tags')}{else}{$myobj->getFormField('uname')}{/if}" title="{$LANG.search_uname_tag}" />
                </td>
                <td class="{$myobj->getCSSFormLabelCellClass('sex')}"><select id="sex" name="sex" tabindex="{smartyTabIndex}">
                    
					{$myobj->generalPopulateArray($myobj->gender_arr, $myobj->getFormField('sex'))}
				
                  </select>
                </td>
              </tr>
              <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('ucity')}"><input type="text" class="clsTextBox selAutoText" name="ucity" id="ucity" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('ucity')}" title="{$LANG.search_ucity}" />
                </td>
                <td class="{$myobj->getCSSFormLabelCellClass('country')}"><select name="country" id="country" tabindex="{smartyTabIndex}">
                    
					{$myobj->populateUserCountriesList($myobj->getFormField('country'))}
				
                  </select>
                </td>
              </tr>
              <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('uhometown')}" colspan="2"><input type="text" class="clsTextBox selAutoText" name="uhometown" id="uhometown" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('uhometown')}" title="{$LANG.search_uhometown}" />
                </td>
              </tr>
            </table>
          </div>
          <div class="clsAdvancedSearchBtn">
            <table>
              <tr>
                <td colspan="2" align="right" valign="middle"><div class="clsListSubmitLeft">
                    <div class="clsListSubmitRight">
                      <input type="submit" name="avd_search" id="avd_search" value="Search" tabindex="{smartyTabIndex}"/>
                    </div>
                  </div></td>
              </tr>
              <tr>
                <td><div class="clsListCancelLeft">
                    <div class="clsListCancelRight">
                      <input type="submit" name="search_reset" id="search_reset" value="{$LANG.members_list_browse_reset}" tabindex="{smartyTabIndex}" />
                    </div>
                  </div></td>
              </tr>
            </table>
          </div>
        </div>
      </form>
      {*include file='box.tpl' opt='form_bottom'*} </div>
    {if $myobj->isResultsFound()}
     <div class="clsOverflow clsPaddingLeftRight"> {*{if isMember()}
       <div class="clsFloatLeft">
        <p class="clsBrowseMemberLink"> <a href="{$myobj->getUrl('membersbrowse')}" id="selMemberBrowseLinkID">{$LANG.common_members_list_browse_members}</a> <a class="clsBlockUser" href="{$myobj->getUrl('memberblock', '', '', 'members')}" id="selMemberBlockLinkId">{$LANG.members_list_blocked_members}</a> </p>
      </div>
      {/if}*}
      {if $CFG.admin.navigation.top}
	   {if $smarty_paging_list}
     	 <div class="clsTopPagination"> {include file='pagination.tpl'}  </div>
	   {/if}	 
      {/if} </div>
    <div id="selViewAllMembers" class="clsMemberListTable clsMemberListMainTable">
      <table summary="{$LANG.member_list_tbl_summary}">
        {foreach key=inc item=value from=$myobj->form_list_members.display_members}
        {if $value.open_tr}
        <tr> {/if}
          <td id="selPhotoGallery_{$inc}">
		   <ul class="clsMembersPhotoListDisplay">
              <li id="memberlist_videoli_{$inc}" onmouseover="showVideoDetail(this)" onmouseout="hideVideoDetail(this)">
                <div class="clsMemberImageContainer" id="memberlist_thumb_{$inc}" >
                    <div class="clsThumbImageLink" id="selMemberName">
                      <div onclick="Redirect2URL('{$value.memberProfileUrl}')" >
				       <a class="ClsImageContainer ClsImageBorder2 Cls90x90" href="{$value.memberProfileUrl}" title="{$value.record.user_name}"> 
					     <img src="{$value.profileIcon.t_url}" alt="{$value.record.user_name|truncate:9}" title="{$value.record.user_name}" onclick="Redirect2URL('{$value.memberProfileUrl}')"  {$myobj->DISP_IMAGE(#image_thumb_width#, #image_thumb_height#, $value.profileIcon.t_width, $value.profileIcon.t_height)} onclick="Redirect2URL('{$value.memberProfileUrl}')"/></a> </div>
                      {$myobj->membersRelRayzz($value.record)} </div>
                    <p class="clsPaddingTop9"> <a href="{$value.memberProfileUrl}" {$value.online}>{$value.record.user_name}</a> {$value.userLink} </p>
                    <a href="#" class="" id="memberlist_info_{$inc}"></a> 
                </div>
                {if isMember()}
                {if $CFG.admin.members_listing.online_status}
                <p class="clsOnline"><a class="{$value.onlineStatusClass}" title="{$value.currentStatus}">{$value.currentStatus}</a></p>
                {/if}              
                {/if}
                
                {* pop up info starts *}
                <div class="clsPopInfoWidth clsPopInfo clsDisplayNone  {if $value.end_tr} clsPopInfoRight {/if}" id="memberlist_selVideoDetails_{$inc}">
                  <div class="clsPopUpDivContainer {if $value.end_tr} clsPopUpDivLastContainer {/if}"> {$myobj->setTemplateFolder('general/')}
                    {include file='box.tpl' opt='popinfo_top'}
                    <div class="clsPopUpPaddingContent">
                      <p class="clsPopUpInnerContainer"><a href="{$value.memberProfileUrl}" {$value.online}>{$value.record.user_name}</a> {$value.userLink} | <strong> <span>{$value.record.age}</span>, <span>{$value.record.sex|capitalize}</span>,</strong> <span>{$value.country}</span></p>
					  <div class="clsOverflow">
                     	 <div class="clsPopUpInnerContainer clsPopUpContentBtm"> 
                      		{if $myobj->listDetails}
                        		{$LANG.profile_list_joined}:&nbsp;
                                <span>
                                    {if $value.record.doj neq '0000-00-00 00:00:00'}
                                        {$value.record.doj|date_format:#format_date_year#}
                                    {/if}
                                </span>
                                &nbsp; | &nbsp;
                        	{/if}{* listDetails if end *}
                        		{$LANG.members_list_member_last_login}:&nbsp;
                                <span>
                                    {if $value.last_logged neq '0000-00-00 00:00:00'}
                                        {$value.last_logged|date_format:#format_date_year#}
                                    {else}
                                        {$LANG.members_browse_member_first_login}
                                    {/if} 
                                </span> 
     					</div>
						 <div id="selMemDetails" class="clsMembersList clsPopUpContentRight"> 
                            {if isMember()}
                              {if $CFG.user.user_id != $value.record.user_id}
                                  <p id="selSendMsg"><a class="clsSendMessage clsPhotoVideoEditLinks" href="{$value.mailComposeUrl}" title="{$LANG.member_list_send_message}">{$LANG.member_list_send_message}</a></p>
                                  {if $value.friend == 'yes'}
                                  <p id="selAlReadyFriend"><a class="clsAlreadyFriend" title="{$LANG.members_list_friend}" class="clsPhotoVideoEditLinks">{$LANG.members_list_friend}</a></p>
                                  {else}
                                  <p id="selAddFriend"><a class="clsAddToFriends clsPhotoVideoEditLinks" href="{$value.friendAddUrl}" title="{$LANG.member_list_add_friend}">{$LANG.member_list_add_friend}</a></p>
                                  {/if}                                     
                              {/if}          
                              
                              {else}
                              <p id="selSendMsg"><a class="clsSendMessage clsPhotoVideoEditLinks" href="{$value.mailComposeUrl}" title="{$LANG.member_list_send_message}">{$LANG.member_list_send_message}</a></p>
                              <p id="selAddFriend"><a class="clsAddToFriends clsPhotoVideoEditLinks" href="{$value.friendAddUrl}" title="{$LANG.member_list_add_friend}">{$LANG.member_list_add_friend}</a></p>
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
                                            {$LANG.profile_list_friends}:
                                            {if $value.record.total_friends > 0} <a href="{$value.viewfriendsUrl}" title="{$value.friend_icon_title}">{$value.record.total_friends}</a> {else} <span>{$value.record.total_friends}</span> {/if}  </li>
										{/if}                                                
                                        		
                                                {assign var=totcnt value= $CFG.site.modules_arr|@count}
                                                {assign var=totcnt value=$totcnt-1}
                                               
                                            {foreach from= $CFG.site.modules_arr key=inc item=module_value}
                                                  {if chkAllowedModule(array($module_value))}
                                                      {assign var=break_count value=$break_count+1}
                                                      {assign var='total_stats' value=$module_value|cat:'_icon_title'}
                                                      {assign var='icon_url' value=$module_value|cat:'ListUrl'}
                                                   		{assign var='total_stats_value' value='total_'|cat:$module_value|cat:'s'}						   
                                                      {assign var='image1_exists' value=$module_value|cat:'_image1_exists'}
                                                      {assign var='image2_exists' value=$module_value|cat:'_image2_exists'}
																	<li class="clsListValues">{$value.$total_stats_value}</li>
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
                            {* listDetails if end *}   
                            
                                {if $myobj->profileHits}
                                |
                                {$LANG.profile_list_profile_hits}:&nbsp;<span>{$value.record.profile_hits}</span>
                              {/if}
                          </div>                        
                      </div>
                    </div>
                    {$myobj->setTemplateFolder('general/')}
                    {include file='box.tpl' opt='popinfo_bottom'} </div>
                </div>
                {* pop up info ends *} </li>
            </ul></td>
          {if $value.end_tr} </tr>
        {/if}
        {/foreach}
        {if $myobj->last_tr_close}
        {section name=foo start=0 loop=$myobj->user_per_row step=1}
        <td>&nbsp;</td>
          {/section} </tr>
        {/if}
      </table>
    </div>
    {if $CFG.admin.navigation.bottom}
    {$myobj->setTemplateFolder('general/')}	
	{if $smarty_paging_list}
	  <div class="clsPaddingRightBottom">
	    {include file='pagination.tpl'}
	  </div>	
	 {/if}
    {/if}    
    {if $myobj->showRelatedTags}
    <div id="selRelatedTags"> <span>{$LANG.members_list_related_tags}:&nbsp;</span> {foreach key=inc item=value from=$myobj->form_list_members.related_tags} <span><a href="{$myobj->tagListUrl}?tags={$value.tags}" >{$value.tags}</a></span> {/foreach} </div>
    {/if}
    {else}
    <div id="selMsgError">{$LANG.msg_no_records}</div>
    {/if}
    {/if} </div>
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}

