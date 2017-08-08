{include file="box.tpl" opt="sidebar_top"}

<div class="clsSideBarLinks" id="selManageRelations">
	<div class="clsSideBar">
        <p class="clsSideBarLeftTitle">{$LANG.header_nav_managerelations_friends}</p>

     <div class="clsSideBarRight">
      <div class="clsSideBarContent">
      <ul>
        <li{$populateRelationRightNavigation_arr.membersInvite}><a href="{$header->getUrl('membersinvite', '', '', 'members')}">{$LANG.header_top_menu_invite_friends}</a></li>
        <li{$populateRelationRightNavigation_arr.invitationHistory}><a href="{$header->getUrl('invitationhistory', '', '', 'members')}">{$LANG.header_nav_friends_invite_history}</a></li>
        <li{$populateRelationRightNavigation_arr.myFriends}><a href="{$header->getUrl('myfriends', '', '', 'members')}">{$LANG.header_nav_managerelations_my_friends}</a></li>
        <li{$populateRelationRightNavigation_arr.myFriends_pg_top_friends}><a href="{$header->getUrl('myfriends', '?pg=top_friends', '?pg=top_friends', 'members')}">{$LANG.header_nav_managerelations_my_top_friends}</a></li>
        <li{$populateRelationRightNavigation_arr.relationManage}><a href="{$header->getUrl('relationmanage', '', '', 'members')}">{$LANG.header_nav_managerelations_manage_relations}</a>
          <ul>
            {foreach key=myRelationKey item=myRelationValue from=$populateRelationRightNavigation_arr.myRelation_arr}
	            <li {$myRelationValue.class}><a {$myRelationValue.href} title="{$myRelationValue.title} {$LANG.header_nav_managerelations_contacts}">{$myRelationValue.value}&nbsp;[{$myRelationValue.count}]</a></li>
            {/foreach}
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>
</div>
{include file="box.tpl" opt="sidebar_bottom"}