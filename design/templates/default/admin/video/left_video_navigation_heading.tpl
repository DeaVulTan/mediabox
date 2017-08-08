<ul class="clsModuleHeading">
    <li {if $CFG.site.is_module_page == 'video'}class="clsActiveModuleLink"{else}class="clsInActiveModuleLink"{/if}>
        <a href="{$CFG.site.url}admin/video/videoManage.php">
            {$LANG.header_video_management_links}
        </a>
    </li>
</ul>