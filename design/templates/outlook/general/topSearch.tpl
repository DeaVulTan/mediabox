{if $header->display_search_form}
<div class="clsTopSearchContainer">
    <form name="formCommonSearch" id="formCommonSearch" method="post" action="{$header->search_form_action}" onsubmit="return chooseSearchSelect('{$populateSearchModules_arr[0].module}', 'header')">
        <div class="clsTopSearchInput">
        	<input type="text" class="selAutoText" name="tags" id="searchTags_header" title="{$LANG.header_search_text}" value="{if $header->getFormField('tags')}{$header->getFormField('tags')|stripslashes}{elseif $header->getFormField('keyword') != ''}{$header->getFormField('keyword')}{else}{$LANG.header_search_text}{/if}" tabindex="{smartyTabIndex}" />
        </div>
        <div class="{if $populateSearchModules_arr}clsSearchModules{/if} clsTopSearchIcon">
            <ul>
                <li class="selDropDownLink">
                    <a class="clsSearchLink" title="{$LANG.common_search}"><!----></a>
                    <ul class="clsTopSearchDropdownList">
                    	<div class="clsTopSearch-top"><div class="clsTopSearch-bottom"><div class="clsTopSearch-middle">
                        {foreach item=searchModule from=$populateSearchModules_arr}
                            <li><a onclick="chooseSearchSelect('{$searchModule.module}', 'header')">{$searchModule.label}</a></li>
                        {/foreach}
                        </div></div></div>
                    </ul>
                </li>
            </ul>
        </div>
    </form>
</div>
{/if}
