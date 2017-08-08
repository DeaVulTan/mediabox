    <ul class="clsModuleHeading">
    	<li {if $CFG.site.is_module_page == 'blog'}class="clsActiveModuleLink" {else} class="clsInActiveModuleLink"{/if}>
    		<a href="{$CFG.site.url}admin/blog/postManage.php">{$LANG.admin_header_blog_management_links}</a>
   		 </li>
   </ul>