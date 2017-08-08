{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selMembersBrowse" class="viewFriends">
  <div id="selLeftNavigation">

{if !$myobj->isShowPageBlock('form_list_top_friends')}
    {if $myobj->isCurrentUser()}
          {if $myobj->is_myFriendsPage}
        <div class="clsOverflow"><div class="clsVideoListHeading"><h2><span>{$myobj->page_title}</span></h2></div><div class="clsVideoListHeadingRight clsVideoListHeadingRightLink"><h2><a href="{$myobj->getUrl('membersinvite', '', '', 'members')}">{$LANG.viewfriends_title_invite}</a></h2></div></div>
          {else}
          <div class="clsPageHeading"><h2><a href="{$myobj->profile_url}">{$myobj->page_title}</a>&nbsp;{$LANG.viewfriends_friends}</h2></div>
          {/if}

    {else}
        {if $myobj->otherUser}
            <div class="clsPageHeading"><h2><a href="{$myobj->profile_url}">{$myobj->page_title}</a>&nbsp;{$LANG.viewfriends_friends}</h2></div>
        {else}
            <div class="clsPageHeading"><h2>{$myobj->page_title}</h2></div>
        {/if}
    {/if}
{/if}

{if $myobj->isShowPageBlock('msg_form_info')}
    <div id="selMsgAlert">
      <p>{$myobj->LANG.msg_no_friends}</p>
        {if $myobj->isCurrentUser()}
           <p class="clsMsgAdditionalText"><a href="{$myobj->getUrl('membersinvite', '', '', 'members')}">{$LANG.viewfriends_link_add_friends_start}</a>&nbsp;{$LANG.viewfriends_link_add_friends_end}</p>
        {/if}
    </div>
{/if}

{if $myobj->isShowPageBlock('block_form_error')}
    <div id="selMsgAlert">
      <p>{$LANG.msg_invalid_username}</p>
        {if $myobj->isCurrentUser()}
              <p>{$LANG.viewfriends_link_add_friends_start}&nbsp;<a href="{$myobj->getUrl('membersinvite', '', '', 'members')}">{$LANG.viewfriends_link_add_friends_text}</a>&nbsp;{$LANG.viewfriends_link_add_friends_end}</p>
        {/if}
    </div>
{/if}

{if $myobj->isShowPageBlock('form_search_friend')}
    {*include file='box.tpl' opt='form_top'*}
      <div id="selFriendSearch" class="clsListTable clsFriendSearchTable">
        <form name="formFriendSearch" id="formFriendSearch" method="post" action="{$myobj->form_search_friend_arr.form_action}">
          <table summary="{$LANG.myfriends_search_table}">
            <tr>
              <td><label for="uname">{$LANG.common_username}</label><div class="clsMarginTop5"><input class="clsFriendsTextBox" type="text" name="uname" id="uname" value="{$myobj->getFormField('uname')}" tabindex="{smartyTabIndex}" maxlength="{$CFG.fieldsize.username.max}"/></div></td>
              <td><label for="email">{$LANG.myfriends_search_email}</label><div class="clsMarginTop5"><input class="clsFriendsTextBox" type="text" name="email" id="email" value="{$myobj->getFormField('email')}" tabindex="{smartyTabIndex}"/></div></td>
              <td><label for="tagz">{$LANG.myfriends_search_tags}</label><div class="clsMarginTop5"><input class="clsFriendsTextBox" type="text" name="tagz" id="tagz" value="{$myobj->getFormField('tagz')}" tabindex="{smartyTabIndex}"/></div></td>
              <td class=""><div class="clsListSubmitLeft clsMarginTop14"><div class="clsListSubmitRight"><input type="submit" value="{$LANG.common_search}" name="friendSearch" tabindex="{smartyTabIndex}"/></div></div></td>
            </tr>
          </table>
		  {$myobj->populateHidden($myobj->form_search_friend_arr.hidden_arr)}
        </form>
      </div>
        {*include file='box.tpl' opt='form_bottom'*}
{/if}

{include file='../general/information.tpl'}

<div class="selMembersBrowse viewFriends">
  <div class="selLeftNavigation">
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
      <p id="msgConfirmText"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			<input type="submit" class="clsSubmitButton" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
            &nbsp;
            <input type="button" class="clsCancelButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
            <input type="hidden" name="act" id="act" />
            <input type="hidden" name="friendship_id" id="friendship_id" />
      </form>
    </div>
  </div>
</div>

<div class="selMembersBrowse viewFriends">
  <div class="selLeftNavigation">
    <div id="selMsgConfirmDelete" class="clsPopupConfirmation" style="display:none;">
      <p id="msgConfirmDeleteText"></p>
      	<form name="msgConfirmDeleteform" id="msgConfirmDeleteform" method="post" action="{$myobj->getCurrentUrl()}">
        	<input type="submit" class="clsSubmitButton" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
            &nbsp;
            <input type="button" class="clsCancelButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
            <input type="hidden" name="act" id="act" />
            <input type="hidden" name="friendshipId" id="friendshipId" />
            <input type="hidden" name="friendship_id" id="friendship_id" />
      </form>
    </div>
  </div>
</div>

{if $myobj->isShowPageBlock('form_list_top_friends')}
	<div class="clsPageHeading"><h2>{$LANG.myfriends_manage_top_friends}</h2></div>
        <div id="selMsgSuccess" style="display:none;">
            <p id="selMsgSuccessText"></p>
        </div>
    {if $displayTopFriends_arr.row}
    	<div id="selMsgAlert"><p>{$LANG.myfriends_note}:&nbsp;{$LANG.myfriends_top_friends_info1}<br/>{$LANG.myfriends_top_friends_info2}</p></div>
        <div class="clsImageMain">
        {foreach item=dtfValue from=$displayTopFriends_arr.row}
            <div class="imageBox" id="{$dtfValue.record.user_id}">
                <div class="imageBox_theImage" style="background-image:url('{$dtfValue.icon.t_url}')"></div>
                <div class="imageBox_label clsImageBox clsOverflow">
                	<span class="clsImageBoxName">{$dtfValue.record.user_name}</span>
                  <a class="clsImageBoxRemove clsPhotoVideoEditLinks" href="javascript:void(0);" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','friendship_id', 'msgConfirmText'), Array('delete', '{$dtfValue.record.friend_id}', '{$dtfValue.delete_top_friend_confirm_msg}'), Array('value','value','innerHTML'), -100, -500);" title="{$LANG.viewfriends_remove_top_friend}">{$LANG.viewfriends_remove_top_friend}</a>
                </div>
              </div>
        {/foreach}
        </div>
        <div id="insertionMarker">
            <img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/marker_top.gif" />
            <img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/marker_middle.gif" id="insertionMarkerLine" />
            <img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/images/marker_bottom.gif" />
        </div>
            <div id="dragDropContent">
        </div>

        <form action="" method="post">
            <table><tr><td>
                <div class="clsSubmitLeft"><div class="clsSubmitRight"><input class="clsSubmitButton" type="button" style="width:100px" value="Save" onclick="saveImageOrder('{$CFG.site.url}myFriends.php?ajax_page=true&amp;act=saveOrder')" /></div></div>
            </td></tr></table>
        </form>
      {literal}
		<script type="text/javascript" language="javascript">
			//Event.observe(window, "load", initGallery);
			$Jq(document).ready(function(){
				initGallery();
			});
        </script>
     {/literal}
    {else}
        <div id="selMsgAlert">
            <p>{$LANG.myfriends_msg_no_top_friends}<br /><a href="{$myobj->getUrl('myfriends', '', '', 'members')}">{$LANG.myfriends_add_top_friends}</a></p>
        </div>
    {/if}
{/if}

{if $myobj->isShowPageBlock('form_list_friends')}
	<form name="formFriendListing" id="formFriendListing" method="post" action="{$myobj->form_list_friends_arr.form_action}">
	{if $myobj->isResultsFound()}
        {if $CFG.admin.navigation.top}{if $smarty_paging_list}
     		 <div class="clsTopPagination clsMarginRight10"> {include file='../general/pagination.tpl'}  </div>
	     {/if}            
    {/if}
		<div class="clsListTable clsMemberListTable clsFriendsContainerMain">
	    <table id="selMembersBrowseTable" class="clsContentsDisplayTbl" cellspacing="0">
            {foreach  key=inc item=dmfValue from=$displayMyFriends_arr.row}
				{if $dmfValue.open_tr}
					<tr class="{$myobj->getCSSRowClass()}">
			    {/if}
                  <td class="selPhotoGallery">
                    	<ul class="clsMembersPhotoListDisplay">
                        	<li id="memberlist_videoli_{$inc}" onmouseover="showVideoDetail(this)" onmouseout="hideVideoDetail(this)"> <a class="ClsImageContainer ClsImageBorder2 Cls90x90" href="{$dmfValue.friendProfileUrl}">
                            <img src="{$dmfValue.icon.t_url}" alt="{$dmfValue.record.friend_name|truncate:9}" onclick="Redirect2URL('{$dmfValue.friendProfileUrl}')" {$myobj->DISP_IMAGE(#image_thumb_width#, #image_thumb_height#, $dmfValue.icon.t_width, $dmfValue.icon.t_height)} />
                        </a>
                        <p class="selMemberName clsProfileThumbImg clsPaddingTop9"><a href="{$dmfValue.friendProfileUrl}" {$dmfValue.online}>{$dmfValue.record.friend_name}</a></p>
                        <div class="clsPopInfoWidth clsPopInfo clsDisplayNone {if $dmfValue.end_tr} clsPopInfoRight {/if}" id="memberlist_selVideoDetails_{$inc}">
                   {* <p><a href="#" id="{$dmfValue.anchor}"></a></p> *}
                            <div class="clsPopUpFriendsContainer {if $dmfValue.end_tr} clsPopUpDivLastContainer {/if}"> {$myobj->setTemplateFolder('general/')}
                                            {include file='box.tpl' opt='popinfo_top'}
                                            <div class="clsPopUpPaddingContent">
                                                 <div class="selMemDetails clsFriendsListIco clsOverflow">
                                                      <p class="selSendMsg"><a class="clsSendMessage clsPhotoVideoEditLinks" href="{$dmfValue.sendMessageUrl}" title="{$LANG.viewfriends_sendmessage}">{$LANG.viewfriends_sendmessage}</a></p>
                                                    {if $myobj->isCurrentUser()}
                                                        <p>
                                                            {if $dmfValue.top_friends.result.friend_id != $dmfValue.record.friend_id}
                                                                    <a class="clsAddToFriends clsPhotoVideoEditLinks" href="javascript:void(0);" onclick="if({$myobj->getTotalTopFriends()} < {$CFG.admin.total_top_friends}) {literal} { {/literal} return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','friendship_id', 'msgConfirmText'), Array('add','{$dmfValue.record.friend_id}', '{$dmfValue.add_top_friend_confirm_msg}'), Array('value','value','innerHTML'), -100, -500) {literal} } {/literal} else {literal} { {/literal} alert('{$LANG.viewfriends_top_friend_exceeded}'); {literal} } {/literal};" title="{$LANG.viewfriends_add_top_friend}">{$LANG.viewfriends_add_top_friend}</a>
                                                            {else}
                                                                    <a class="clsRemoveFromFriends clsPhotoVideoEditLinks" href="javascript:void(0);" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','friendship_id', 'msgConfirmText'), Array('delete', '{$dmfValue.record.friend_id}', '{$dmfValue.delete_top_friend_confirm_msg}'), Array('value','value','innerHTML'), -100, -500);" title="{$LANG.viewfriends_remove_top_friend}">{$LANG.viewfriends_remove_top_friend}</a>
                                                            {/if}
                                                        </p>
                                                        <p>
                                                          <a class="clsDeleteList clsPhotoVideoEditLinks" name="friendshipId[{$dmfValue.record.friendship_id}]" onclick="return Confirmation('selMsgConfirmDelete', 'msgConfirmDeleteform', Array('act','friendshipId', 'friendship_id', 'msgConfirmDeleteText'), Array('delete','{$dmfValue.record.friendship_id}', '{$dmfValue.record.friend_id}', '{$dmfValue.delete_friend_confirm_msg}'), Array('value', 'value', 'value', 'innerHTML'), -100, -500);" title="{$LANG.viewfriends_submit_remove}" >{$LANG.viewfriends_submit_remove}</a>
                                                        </p>
                                                    {/if}
                                                    </div> 
                                            </div>
                                            
                                            {$myobj->setTemplateFolder('general/')}
                                            {include file='box.tpl' opt='popinfo_bottom'} </div>
                            
                       </div></li>
                        </ul>
					</td>
                {if $dmfValue.end_tr}
                    </tr>
                {/if}
            {/foreach}
            {if $displayMyFriends_arr.extra_td_tr}
                  {section name=foo start=0 loop=$displayMyFriends_arr.records_per_row step=1}
                        <td>&nbsp;</td>
                  {/section}
            {/if}
	    </table>
        </div>
        {if $CFG.admin.navigation.bottom}
		{if $smarty_paging_list}
		  <div class="clsPaddingRightBottom">
			 {include file='../general/pagination.tpl'}
		  </div>	
		{/if}           
        {/if}
	{else}
        <div id="selMsgAlert">
            <p>{$myobj->form_list_friends_arr.not_found_msg}</p>
        </div>
	{/if}
	{$myobj->populateHidden($myobj->form_list_friends_arr.hidden_arr)}
	</form>
{/if}

  </div>
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
<script type="text/javascript" language="javascript" src="{$CFG.site.url}js/videoDetailsToolTip.js"></script>