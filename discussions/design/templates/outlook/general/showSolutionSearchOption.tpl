 <form name="selFormSearchBoard" id="selFormSearchBoard" method="post" onsubmit="return checkforSearchText(this.search_board, '{$showSolutionSearchOption_arr.defaultText}', '{$LANG.header_enter_text_for_search}');" action="{$showSolutionSearchOption_arr.form_action}">
	<div class="clsHeadSearch">
		<div class="clsSearchLeftButton">
		<input type="text" name="search_board" id="search_board" maxlength="250" tabindex="{smartyTabIndex}" value="{$showSolutionSearchOption_arr.board_field_value}" onBlur="displayDefaultValue(this, '{$showSolutionSearchOption_arr.defaultText}')" onclick="clearDefaultValue(this, '{$showSolutionSearchOption_arr.defaultText}')"/>
		</div>
        <input type="hidden" class="clsSearchSubmitButton" name="search" id="search" tabindex="{smartyTabIndex}" value="{$LANG.header_search}" />
		<a href="#" class="clsSearchRightButton" onclick="javascript:document.getElementById('selFormSearchBoard').submit();"></a>
	</div>
	<div class="clsHeadAdvanceSearch">
		<a href="{$showSolutionSearchOption_arr.advanced_search.url}" class=""></a>
	</div>
    </form>