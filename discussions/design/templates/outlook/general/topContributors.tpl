<div id="selListAll" >
	{if $myobj->isShowPageBlock('form_contributors') or $myobj->isShowPageBlock('form_week_experts') or $myobj->isShowPageBlock('form_featured_contributors')}
    	{if $CFG.admin.navigation.top}
        	{include file='../general/pagination.tpl'}
        {/if}
 	{/if}
    {if $myobj->isShowPageBlock('form_normal_heading')}
		<div class="clsCommonIndexRoundedCorner">
			<div class="clsBoardsLink">
				<h3>
					{$LANG.discuzz_common_top_contributor_title}
				</h3>
			</div>
            <div class="clsClearFix">
                <div class="clsContributorAllTimelast">
                    <ul>
                    <li class="{$myobj->clsAllTime} clsAllTime"><span class="">{$LANG.contributors_alltime_title}</span></li>
                    <li class="{$myobj->clsLastWeek}"><span>{$LANG.contributors_lastweek_title}<span class="clsContributorInfo">{$LANG.contributors_this_week_note}</span></span></li>
                    </ul>
                </div>
            </div>
    {/if}
    {if $myobj->isShowPageBlock('form_featured_contributors')}
		<div class="clsCommonIndexRoundedCorner">
			<div class="clsBoardsLink">
				<h3>
					{$LANG.discuzz_common_featured_contributor_title}
				</h3>
			</div>
    {/if}


{include file='../general/information.tpl'}

{if $myobj->isShowPageBlock('form_advanced_search')}
    <form name="formAdvanceSearch" id="formAdvanceSearch" method="post" action="{$myobj->form_advanced_search.form_action}">
        <div id="moreSearchOptions">
        <div class="clsCommonIndexRoundedCorner">
  <!--rounded corners-->
  <div class="lbtopcontributor">
    <div class="rbtopcontributor">
      <div class="bbtopcontributor">
        <div class="blctopcontributor">
          <div class="brctopcontributor">
            <div class="tbtopcontributor">
              <div class="tlctopcontributor">
                <div class="trctopcontributor">
                {if $myobj->isShowPageBlock('form_search_heading')}
					<div class="clsBoardsLink">
						<h3>
							{$LANG.contributors_home_title}
						</h3>
					</div>
				{/if}


                <div class="clsAdvanceSearchOption" >

        <table summary="{$LANG.discuzz_common_displaying_more_search_options}" class="clsLoginTable">
        	   <tr>
                <th colspan="2" >
                    {$LANG.discuzz_common_enter_search_options}
                </th>

            </tr>
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('search_member')}">
                    <label for="search_member">{$LANG.contributors_membername}</label>
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('search_member')}">{$myobj->getFormFieldErrorTip('search_member')}
                    <input type="text" class="clsCommonTextBox" name="search_member" id="search_member" value="{$myobj->getFormField('search_member')}" tabindex="{smartyTabIndex}" />
                </td>
            </tr>
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('total_points')}">
                    <label for="total_points">{$LANG.contributors_total_poinsts_greater}</label>
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('total_points')}">
                    <input type="text" class="clsCommonNumberTextBox" name="total_points" id="total_points" value="{$myobj->getFormField('total_points')}" tabindex="{smartyTabIndex}" />
                    {$LANG.and}
                    <input type="text" class="clsCommonNumberTextBox" name="maxtotal_points" id="maxtotal_points" value="{$myobj->getFormField('maxtotal_points')}" tabindex="{smartyTabIndex}" />
                    {$myobj->getFormFieldElementErrorTip('total_points')}
                </td>
            </tr>
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('total_boards')}">
                    <label for="total_boards">{$LANG.contributors_total_board_greater}</label>
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('total_boards')}">
                    <input type="text" class="clsCommonNumberTextBox" name="total_boards" id="total_boards" value="{$myobj->getFormField('total_boards')}" tabindex="{smartyTabIndex}" />
                    {$LANG.and}
                    <input type="text" class="clsCommonNumberTextBox" name="maxtotal_boards" id="maxtotal_boards" value="{$myobj->getFormField('maxtotal_boards')}" tabindex="{smartyTabIndex}" />
                    {$myobj->getFormFieldElementErrorTip('total_boards')}
                </td>
            </tr>
            <tr>
                <td class="{$myobj->getCSSFormLabelCellClass('total_solutions')}">
                    <label for="total_solutions">{$LANG.contributors_total_solutions_greater}</label>
                </td>
                <td class="{$myobj->getCSSFormFieldCellClass('total_solutions')}">
                    <input type="text" class="clsCommonNumberTextBox" name="total_solutions" id="total_solutions" value="{$myobj->getFormField('total_solutions')}" tabindex="{smartyTabIndex}" />
                    {$LANG.and}
                    <input type="text" class="clsCommonNumberTextBox" name="maxtotal_solutions" id="maxtotal_solutions" value="{$myobj->getFormField('maxtotal_solutions')}" tabindex="{smartyTabIndex}" />
                    {$myobj->getFormFieldElementErrorTip('total_solutions')}
                </td>
            </tr>
            <tr>
            	<td class="clsBorderBottomNone"></td>
                <td  class="{$myobj->getCSSFormFieldCellClass('submitsearch')}">
                	<p class="clsSubmitButton"><span>
                    	<input type="submit" class="clsSearchButtonInput" name="adv_search" id="adv_search" value="{$LANG.search}" tabindex="{smartyTabIndex}" />
					</span></p>
				  	<p class="clsCancelButton"><span>
		            	<input type="button" class="clsCancelButtonInput" name="reset" id="reset" onclick="resetSearchCriteria(this.form);" tabindex="{smartyTabIndex}" value="{$LANG.discuzz_common_reset}" />
					</span></p>
                </td>
            </tr>
            </table>
            </div>
            </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--end of rounded corners-->
</div>
        </div>
    </form>
{/if}

{if $myobj->isShowPageBlock('form_contributors') or $myobj->isShowPageBlock('form_week_experts') or $myobj->isShowPageBlock('form_featured_contributors')}
    {if $myobj->isResultsFound()}
            <div class="clsCommonTopContributorRoundedCorner">
  <!--rounded corners-->
  <div class="lbtopcontributor">
    <div class="rbtopcontributor">
      <div class="bbtopcontributor">
        <div class="blctopcontributor">
          <div class="brctopcontributor">
            <div class="tbtopcontributor">
              <div class="tlctopcontributor">
                <div class="trctopcontributor">
                <div class="clsBorderPadding">
                <table summary="{$LANG.display_all_contributors}" id="selFormTable"  class="clsCommonTable">
                <tr>
                 <th class="clsFormSubject clsNoBorder">{$LANG.contributors_name}</th>
                 <th class="clsCommonPointsTittle clsCenter"><div class="clsMiddleTitle">{$LANG.contributors_points}</div></th>
                 {if $myobj->CFG.admin.user_levels.allowed}
                     <th class="clsCommonPointsTittle clsCenter"><div class="clsMiddleTitle">{$LANG.discuzz_common_contributor_level}</div></th>
                 {/if}
                 <th class="clsCommonPointsTittle clsCenter"><div class="clsMiddleTitle">{$LANG.contributors_boards}</div></th>
                 {if $CFG.admin.friends.allowed and isMember()}
				 <th class="clsCommonPointsTittle clsCenter"><div class="clsMiddleTitle">{$LANG.contributors_solutions}</div></th>
				 {else}
				 <th class="clsCommonPointsTittle clsCenter">{$LANG.contributors_solutions}</th>
				 {/if}
               </tr>

            {foreach key=dtakey item=dtavalue from=$myobj->form_contributors.TopContributors}
                <tr>
                <td class="clsLeftAlign">
                <div class="clsFloatLeft">
                    {if isUserImageAllowed()}
                    	<div class="clsTopContributorImage">
                    		{$discussion->displayTopContributorSmallImage($dtavalue.record, true, $CFG.admin.discussions.showpopup)}
                        </div>
                     {/if}
                </div>
                <div class="clsFloatLeft">
                    <span class="clsUserName"><a href="{$dtavalue.mysolutions.url}">{$dtavalue.mysolutions.href_val}</a></span>
                    {if $dtavalue.record.user_id neq $CFG.user.user_id and $CFG.admin.friends.allowed}
						<!--p id="send_req_{$dtavalue.record.user_id}" style="{$dtavalue.friend.req}">
							<span id="send_req_{$dtavalue.record.user_id}_msg"></span>
							<input type="button" class="clsTopAddRequest" name="send_req" value="{$LANG.friend_add}" onClick="doFriendAction('{$dtavalue.contributor.url}', 'ajax_page=true&sendRequest=1&request_from={$CFG.user.user_id}&request_to={$dtavalue.record.user_id}', Array('{$dtavalue.record.user_id}', Array('send_req', 'msg'), Array('remove_req'), Array('send_req'), Array('msg'), Array('{$LANG.friend_requested}'))); return false;">
						</p>
	                	<p id="remove_fri_{$dtavalue.record.user_id}" style="{$dtavalue.friend.rem}">
							<span id="remove_fri_{$dtavalue.record.user_id}_msg"></span>
							<input type="button" name="remove_fri" class="clsTopSendRequest" value="{$LANG.friend_remove}" onClick="doFriendAction('{$dtavalue.contributor.url}', 'ajax_page=true&removeFriend=1&request_from={$CFG.user.user_id}&request_to={$dtavalue.record.user_id}', Array('{$dtavalue.record.user_id}', Array('remove_fri', 'msg'), Array('send_req'), Array('remove_fri'), Array('msg'), Array('{$LANG.friend_not_requested}'))); return false;">
						</p>
	                	<p id="remove_req_{$dtavalue.record.user_id}" style="{$dtavalue.friend.rem_req}">
							<span id="remove_req_{$dtavalue.record.user_id}_msg"></span>
							<input type="button" class="clsTopSendRequest" name="remove_req" value="{$LANG.friend_remove_request}" onClick="doFriendAction('{$dtavalue.contributor.url}', 'ajax_page=true&removeRequest=1&request_from={$CFG.user.user_id}&request_to={$dtavalue.record.user_id}', Array('{$dtavalue.record.user_id}', Array('remove_req', 'msg'), Array('send_req'), Array('remove_req'), Array('msg'), Array('{$LANG.friend_not_requested}'))); return false;">
						</p-->
	                {/if}
                    </div>
                </td>
                    <td class="clsViewsValue"><span class="clsTotalPoints">{$dtavalue.record.total_points}</span></td>
                    {if $myobj->CFG.admin.user_levels.allowed}
                        <td class="clsTopContributorLevel {$dtavalue.userLevelClass} clsCenter"><span class="clsLevelTypes"></span></td>
                    {/if}
                    <td class="clsViewsValue">
                    	{if $dtavalue.record.total_board neq 0}
                    		<a href="{$dtavalue.boards.url}">{$dtavalue.record.total_board}</a>
                    	{else}
                    		{$dtavalue.record.total_board}
                    	{/if}
					</td>
                    <td class="clsViewsValue">
                    	{if $dtavalue.record.total_solution neq 0}
                    		<a href="{$dtavalue.boards.url}">{$dtavalue.record.total_solution}</a>
                    	{else}
                    		{$dtavalue.record.total_solution}
                    	{/if}
					</td>
                </tr>
            {/foreach}
            </table>
            </div>
            </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--end of rounded corners-->
</div>


    {else}
        <div id="selMsgAlert">
            <p>{$LANG.discuzz_common_no_contributors}</p>
        </div>
    {/if}
</div>
{/if}
	{if $myobj->isShowPageBlock('form_contributors') or $myobj->isShowPageBlock('form_week_experts') or $myobj->isShowPageBlock('form_featured_contributors')}
    	 {if $CFG.admin.navigation.bottom}
            {include file='../general/pagination.tpl'}
        {/if}
 	{/if}
</div>