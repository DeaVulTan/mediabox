{include file="box.tpl" opt="sidebar_top"}
<div class="clsSideBarLinks" id="selMails">
	<div class="clsSideBar"><div>
	<p class="clsSideBarLeftTitle">{$LANG.header_nav_mail_mail}</p>
</div>

<div class="clsSideBarRight">
<div class="clsSideBarContent">
 <ul>
  <li class="{$mail_pg_inbox_class}"><a href="{$myobj->getUrl('mail', '?folder=inbox', 'inbox/')}">{$LANG.header_nav_mail_inbox} ({$myobj->countUnReadMail()})</a></li>
  <li class="{$mail_pg_sent_class}"><a href="{$myobj->getUrl('mail', '?folder=sent', 'sent/')}">{$LANG.header_nav_mail_sent}</a></li>
  <li class="{$mail_pg_saved_class}"><a href="{$myobj->getUrl('mail', '?folder=saved', 'saved/')}">{$LANG.header_nav_mail_saved}</a></li>
  <li class="{$mail_pg_request_class}"><a href="{$myobj->getUrl('mail', '?folder=request', 'request/')}">{$LANG.header_nav_mail_requests} ({$myobj->countUnReadMailByType('Request')})</a></li>
  <li class="{$mail_pg_trash_class}"><a href="{$myobj->getUrl('mail', '?folder=trash', 'trash/')}">{$LANG.header_nav_mail_trash}</a></li>
   {if $CFG.user.usr_access == 'Admin' OR $myobj->checkUserPermission($CFG.user.user_actions, 'compose_mail') == 'Yes'}
	<li class="{$mailCompose_class}"><a href="{$myobj->getUrl('mailcompose')}">{$LANG.header_nav_mail_compose}</a></li>
   {/if}
 </ul>
</div>
</div></div></div>
{include file="box.tpl" opt="sidebar_bottom"}
