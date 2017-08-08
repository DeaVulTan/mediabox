<div id="seldiscussionsTopics" class="clsDiscussions">
  <h2 id="selDiscussionTitle"></h2>
  {include file='../general/information.tpl'}
  {if $myobj->isShowPageBlock('form_advanced_search')}
  <div class="clsCommonIndexRoundedCorner">
  <!--rounded corners-->
  <div class="lbtopanalyst">
    <div class="rbtopanalyst">
      <div class="bbtopanalyst">
        <div class="blctopanalyst">
          <div class="brctopanalyst">
            <div class="tbtopanalyst">
              <div class="tlctopanalyst">
                <div class="trctopanalyst">
					<div class="clsBoardsLink">
						<h3><a href="{$myobj->discussions_url}">{$LANG.discussion_search_discussion}</a> &nbsp;-&nbsp; {$myobj->search_title}</h3>
					</div>

			  <form name="formAdvanceSearch" id="formAdvanceSearch" method="post" action="{$myobj->advanced_search_action}">
				<div id="moreSearchOptions" class="clsAdvanceSearchOption">
				  <table summary="{$LANG.discuzz_common_displaying_more_search_options}" class="clsLoginTable">
				  <tr>
				  	<th colspan="2">{$LANG.discuzz_common_enter_search_options}</th>
				  </tr>
					<tr>
					  <td class="{$myobj->getCSSFormLabelCellClass('discussion_title')}"><label for="discussion_title">{$LANG.discussion_search_title}</label>
					  </td>
					  <td class="{$myobj->getCSSFormFieldCellClass('discussion_title')}">{$myobj->getFormFieldErrorTip('discussion_title')}
						<input type="text" class="clsTextBox" name="discussion_title" id="discussion_title" value="{$myobj->getFormField('discussion_title')}" tabindex="{smartyTabIndex}" />
					  </td>
					</tr>
					<tr>
					  <td class="{$myobj->getCSSFormLabelCellClass('dname')}"><label for="dname">{$LANG.search_username}</label>
					  </td>
					  <td class="{$myobj->getCSSFormFieldCellClass('dname')}">{$myobj->getFormFieldErrorTip('dname')}
						<p>
						  <input type="text" class="clsTextBox" name="dname" id="dname" value="{$myobj->getFormField('dname')}" tabindex="{smartyTabIndex}" />
						</p></td>
					</tr>
					<tr>
			            <td class="{$myobj->getCSSFormLabelCellClass('cat_id')}"><label for="cat_id">{$LANG.discuzz_common_category}</label></td>
			            <td class="{$myobj->getCSSFormFieldCellClass('cat_id')}">{$myobj->getFormFieldErrorTip('cat_id')}
			              <select class="clsCommonListBox" name="cat_id" id="cat_id" tabindex="{smartyTabIndex}">
			                <option value="">{$LANG.discuzz_common_select_choose}</option>
			                {$myobj->generalPopulateArray($myobj->populateCategories_arr, $myobj->getFormField('cat_id'))}
			              </select>
			            </td>
			        </tr>
					<tr>
					  <td class="{$myobj->getCSSFormLabelCellClass('date_limits_to')}"><label for="date_limits_to">{$LANG.discussion_search_date_limits_to}</label></td>
					  <td class="{$myobj->getCSSFormFieldCellClass('date_limits_to')}">{$myobj->getFormFieldErrorTip('date_limits_to')}
						<label for="date_limits_to">
						<select name="date_limits_to" id="date_limits_to" tabindex="{smartyTabIndex}">
							{$myobj->generalPopulateArray($myobj->searchOption_arr, $myobj->getFormField('date_limits_to'))}
						</select>
						</label>
					  </td>
					</tr>
					<tr>
					<td class="clsBorderBottomNone"></td>
					 <td class="{$myobj->getCSSFormFieldCellClass('submitsearch')}">
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
			  </form>
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
  {/if}
  {if $myobj->isShowPageBlock('form_show_topics')}
 	  {if $CFG.admin.navigation.top}
		  	{include file='../general/pagination.tpl'}
	  {/if}
 		<div class="clsCommonIndexRoundedCorner clsClearFix">
			<div class="clsCommonTopAnalystRoundedCorner">
		  	<!--rounded corners-->
		  		<div class="lbtopanalyst">
		    		<div class="rbtopanalyst">
		      			<div class="bbtopanalyst">
		        			<div class="blctopanalyst">
		          				<div class="brctopanalyst">
		            				<div class="tbtopanalyst">
		              					<div class="tlctopanalyst">
		                					<div class="trctopanalyst">
		                						<!-- tabs start -->
												<div class="clsBoardsLink">
													<h3>
														<span id="selRecentlySolutionedLI">{$LANG.discussion_search_results}</span>
													</h3>
												</div>
												<!-- tabs end -->
                                                <div class="clsCommonTableContainer" id="recently_solutioned" style="display: block;">
												  {if $myobj->isResultsFound()}
												  <table summary="{$LANG.discussions_tbl_summary}" class="clsCommonTable">
													<tr>
													  <th class="clsIconTittle"></th>
													  <th>{$LANG.index_startedby}</th>
													  <th  lang="clsLastPostTittle">{$LANG.index_last_posts}</th>
													  <th>{$LANG.discuzz_common_boards}</th>
													  <th class="clsTittleSolutions clsNoBorder">{$LANG.discuzz_common_solutions}</th>
													</tr>
													{foreach key=fstkey item=fsfvalue from=$myobj->form_show_topics_arr}
													<tr>
													  <td class="clsIconValue"><div class="clsIconDiscussion"></div></td>
													  <td>
														  <p><span class="clsDiscussionLink"><a href="{$fsfvalue.discussionBoards.url}"> {$fsfvalue.discussionBoards.title} </a></span></p>
														  <p class="clsDiscussionDesc">{$fsfvalue.discussion_description_manual}</p>
														  <p class="clsAskBy">{$LANG.index_by} <a href="{$fsfvalue.myanswers.url}">{$fsfvalue.record.post_name}</a></p>
													  </td>
													  <td class="clsLastPostValue">
													  	{if $fsfvalue.record.last_post_date and $fsfvalue.record.last_post_name neq ''}
															<span class="clsLastPostDate">{$fsfvalue.record.last_post_date_only},</span>
															<span class="clsLatPostTime">{$fsfvalue.record.last_post_time_only}</span>
													  		<p class="clsAskBy"><span class="clsLastAskby">{$LANG.index_by}</span> <a href="{$fsfvalue.lastPost.url}">{$fsfvalue.record.last_post_name}</a></p>
													  	{/if}
													  </td>
													  <td class="clsTotalBoardsValue">{$fsfvalue.record.total_boards}</td>
													  <td class="clsTotalSolutionsValue">{$fsfvalue.record.total_solutions}</td>
													</tr>
													{/foreach}
													</table>
													{else}
														<div id="selMsgAlert">
															<p>{$LANG.discussions_no_titles}. <a class="clsPostNewData" href="{$myobj->discussionsAddTitle_url}">{$LANG.click_here_to_post_new_discussion}</a></p>
														</div>
													{/if}
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
		</div>
		  {if $CFG.admin.navigation.bottom}
		  	{include file='../general/pagination.tpl'}
		  {/if}
  {/if}
</div>