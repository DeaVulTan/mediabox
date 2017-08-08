<div id="selSearchForm" class="clsSearchForm">
	<form name="selFormSearchBoard" id="selFormSearchBoard" method="post" onsubmit="return checkforSearchText(this.search_member, '{$showMemberSearchOption_arr.defaultText}', '{$LANG.header_enter_text_for_search}');" action="{$showMemberSearchOption_arr.form_action}">
		<span class="clsSearchHeading">Search</span>
		<input type="text" class="clsSearchInput" name="search_member" id="search_member" maxlength="250" tabindex="{smartyTabIndex}" value="{$showMemberSearchOption_arr.board_field_value}" onBlur="displayDefaultValue(this, '{$showMemberSearchOption_arr.defaultText}')" onclick="clearDefaultValue(this, '{$showMemberSearchOption_arr.defaultText}')" />
        	<div class="clsSearchButtonContainer">
    			<p class="clsSearchButton">
            	<span>
					<input type="submit" class="clsSearchSubmitButton" name="search" id="search" tabindex="{smartyTabIndex}" value="{$LANG.header_search}" />
				</span>
                </p>
				<p class="clsAdvanceSearch">
					<a class="" href="{$showMemberSearchOption_arr.advanced_search.url}">{$LANG.advanced_search}</a>
				</p>
			</div>
  	</form>
</div>
