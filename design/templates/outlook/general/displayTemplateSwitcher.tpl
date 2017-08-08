{if $show_templates}
<li class="selDropDownLink clsBlock clsTemplateSwitcherLink">
    <form class="clsBlock" name="form_style" id="form_style" method="post" action="{$header->getCurrentUrl(true)}" autocomplete="off">
        <input type="hidden" name="template" id="template" />
        <a href="#" class="language" onclick="return false;" onmouseover="document.getElementById('selTemplateList').style.display=''" onmouseout="document.getElementById('selTemplateList').style.display='none'"><img src="{$header->displayTemplateSwitcher_arr.default_template_img}" alt="{$CFG.html.stylesheet.screen.default|truncate:3}"/></a>
        <ul class="clsTemplateSwitcherContainer">
            {foreach key=template item=css_arr from=$template_arr}
                <li class="clsThemeHeading">{$template}</li>
                {foreach key=css_key item=css from=$css_arr}
                    {assign var="smarty_current_template" value="`$template`__`$css`"}
                    <li class="clsStyleHeading"><a href="#" onclick="document.getElementById('template').value='{$smarty_current_template}';document.getElementById('form_style').submit();return false;"><img src="{$CFG.site.url}design/css/themes/{$template}_{$css}.jpg" alt="{$css}"/> {$css}</a></li>
                {/foreach}
            {/foreach}
            </ul>
    </form>
</li>
{/if}