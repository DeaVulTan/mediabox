{if $show_languages}
    <li class="selDropDownLink clsBlock clsLanguageSwitcherLink">
        <div id="selLang" lang="en">
            {foreach key=key item=value from=$smarty_available_languages}
                {if $key == $CFG.lang.default}
                    <a class="language clsBlock" onClick="showHideLang()" onmouseover="document.getElementById('showhidelang').style.display=''" onmouseout="document.getElementById('showhidelang').style.display='none'" title="{$value}"><img src="{$CFG.site.url}design/css/flag_icon/{$key}.gif" /></a>
                {/if}
            {/foreach}
                <ul id="langlist" class="clsLanguageSwitcherContainer">
                    {foreach key=key item=value from=$smarty_available_languages}
                        {if $key != $CFG.lang.default}
                            <li><a href="{$header->chooseLang($key)}"><img src="{$CFG.site.url}design/css/flag_icon/{$key}.gif" />&nbsp; {$value}</a></li>
                        {/if}
                    {/foreach}
                </ul>
        </div>
    </li>
{/if}
