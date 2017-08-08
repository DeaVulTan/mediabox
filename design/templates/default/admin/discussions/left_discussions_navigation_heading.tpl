<ul class="clsModuleHeading">
    <li {if $CFG.site.is_module_page == 'discussions'}class="clsActiveModuleLink"{else}class="clsInActiveModuleLink"{/if}>
        <a href="{$CFG.site.url}admin/discussions/discussions.php">
            {$LANG.header_discussions_management_links}
        </a>
    </li>
</ul>