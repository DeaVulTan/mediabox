{if $header->display_search_form}
    <div id="selFooterCommonSearch" class="clsOverflow">
        <form name="searchFooterForm" id="searchFooterForm" method="post" action="{$header->search_form_action}" onsubmit="return chooseSearchSelect('{$populateSearchModules_arr[0].module}', 'footer')">
            <table>
                <tr>
                    <td>
                        <div class="clsSearchBoxBg">
							<input type="text" class="clsSearchTextBox selAutoText" name="tags" id="searchTags_footer" title="{$LANG.header_search_text}" value="{if $header->getFormField('tags')}{$header->getFormField('tags')|stripslashes}{elseif $header->getFormField('keyword') != ''}{$header->getFormField('keyword')}{else}{$LANG.header_search_text}{/if}" tabindex="{smartyTabIndex}" />
                        </div>
                    </td>
                    <td>
                        <div class="clsTopGreyButtonLeft">
							<div class="clsTopGreyButtonRight">
								<div class="{if $populateSearchModules_arr}clsSearchModules{/if}">
		                            <ul style="">
		                                <li class="selDropDownLink">
											<a class="clsSearchLink">{$LANG.common_search}</a>
		                                    <ul class="clsSearchDropDownList">
		                                        {foreach item=searchModule from=$populateSearchModules_arr}
		                                            <li><a onclick="chooseSearchSelect('{$searchModule.module}', 'footer')">{$searchModule.label}</a></li>
		                                        {/foreach}
		                                    </ul>
		                                </li>
		                            </ul>
                        		</div>
							</div>
						</div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
{/if}