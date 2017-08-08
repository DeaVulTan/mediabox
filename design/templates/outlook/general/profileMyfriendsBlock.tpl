<div class="clsFriendsInfoTable">
<table {$myobj->defaultTableBgColor} >
        <tr>
          <th {$myobj->defaultBlockTitle} >
           <div class="clsProfileFriendsInfoTitle">{$LANG.myprofile_shelf_friends}</div>
           <div class="clsProfileFriendsInfoLink">
                {if $myobj->isEditableLinksAllowed()}
                    <a href="{$myobj->getUrl('membersinvite')}">{$LANG.viewprofile_link_view_invite_friends}</a>
                {/if}
            </div>
          </th>
        </tr>
	 {if $friends_list_arr==0}
        <tr>
          <td>
          <div id="selMsgAlert">
              <p>{$LANG.viewprofile_friends_no_msg}</p>
          </div></td>
        </tr>
      {else}
        <tr>
          <td>
          <div class="clsFriendsInfo" id="{$CFG.profile_box_id.friends_list}">
              <ul>
              {assign var=td_count value=0}
               {foreach key=item item=value from=$friends_list_arr}
                <li>
                    <a class="ClsProfileImageContainer ClsProfileImageBorder1 ClsProfile45x45" href="{$value.firiendProfileUrl}">
                        <img src="{$value.friendicon.s_url}" alt="{$value.friendName|truncate:5}" title="{$value.friendName}" onclick="Redirect2URL('{$value.firiendProfileUrl}')" {$myobj->DISP_IMAGE(45, 45, $value.friendicon.s_width, $value.friendicon.s_height)}/>
                    </a>
                    <p id="selMemberName_{$item}" class="clsProfileRootThumbImg">
                        <a href="{$value.firiendProfileUrl}">{$value.friendName}</a>
                    </p>
	             </li>
                 {assign var=td_count value=$td_count+1}
                {/foreach}
                {if $td_count lt 7}
                {assign var=td_max value=7}
                {assign var=td_loop value=$td_max-$td_count}
                {section name=loop start=0 loop=$td_loop}
               <li>&nbsp;</li>
               {/section}
                {/if}
              </ul>
            </div>
		   </td>
		 </tr>	
		 <td colspan="2" class="clsMoreBgCols">
            <div class="clsRootViewMoreLink">
                {if $friends_list_arr!=0}
                    <a href="{$userfriendlistURL}">{$LANG.viewprofile_link_view_friends}</a>
                {/if}
            </div>
            </td>
       {/if} {* friends_list_arr condition closed *}
      </table>
</div>