<div id="selSearchForm" class="clsSearchForm clsClearFix">
  <form name="selFormSearchBoard" id="selFormSearchBoard" method="post" onsubmit="return checkforSearchText(this.search_discussion, '{$showDiscussionSearchOption_arr.defaultText}', '{$LANG.header_enter_text_for_search}');" action="{$showDiscussionSearchOption_arr.form_action}">
	<span class="clsSearchHeading">Search</span>
	<input type="text" class="clsSearchInput" name="search_discussion" id="search_discussion" maxlength="250" tabindex="{smartyTabIndex}" value="{$showDiscussionSearchOption_arr.discussion_field_value}" onBlur="displayDefaultValue(this, '{$showDiscussionSearchOption_arr.defaultText}')" onclick="clearDefaultValue(this, '{$showDiscussionSearchOption_arr.defaultText}')" />
    <div class="clsSearchButtonContainer">
	    <p class="clsSearchButton">
	        <span><input type="submit" class="clsSearchSubmitButton" name="search" id="search" tabindex="{smartyTabIndex}" value="{$LANG.header_search}" /></span>
	    </p>
		<p class="clsAdvanceSearch"><a class="" href="{$showDiscussionSearchOption_arr.advanced_search.url}">{$LANG.advanced_search}</a></p>
	</div>
  </form>
</div>