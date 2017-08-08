<h2>{$LANG.header_admin_navigation_links}</h2>
<div class="clsMenu"><ul>
  <li class="{$header->getNavClass('left_index')}"><a href="{$CFG.site.url}admin/index.php">{$LANG.header_admin_index_links}</a></li>
  {if !$CFG.admin.module.site_maintenance}
 	 <li class="{$header->getNavClass('left_inactive')}"><a href="{$myobj->getUrl('index', '', '', 'members')}">{$LANG.header_member_link}</a></li>
  {/if}
  <li class="{$header->getNavClass('left_inactive')}">
  	{if $myobj->isFacebookUser()}
  	<a href="{$myobj->getUrl('logout', '', '', 'root')}" onClick="return facebookLogout();">{$LANG.header_logout_link}</a>
	{else}
	<a href="{$myobj->getUrl('logout', '', '', 'root')}">{$LANG.header_logout_link}</a>
	{/if}</li>
</ul></div>