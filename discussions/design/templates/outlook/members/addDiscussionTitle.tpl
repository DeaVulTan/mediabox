{if !isAjax()}
<div id="selDiscussionTitleCreate">
<div class="clsCommonIndexRoundedCorner clsClearFix">
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
						<h3>
                {$LANG.discussionslinks_add_title}
            </h3></div>
    <div class="clsInboxReadTbl">
    <div id="selLeftNavigation">

{include file='../general/information.tpl'}
{/if}
{if $myobj->isShowPageBlock('form_create_discussion')}

    <div id="selShowCreateDiscussion">
        <div id="selGroupDiscussionPost">
        <h3 id="selBackToDiscussion">
            <a href="{$myobj->back_to_discussions.url}">
                {$LANG.discussion_back_index}
            </a>
        </h3>
        </div>
        <form name="selAddDiscussionFrm" id="selAddDiscussionFrm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
            <table summary="{$LANG.discussion_tbl_summary}" class="clsLoginTable">
                <tr>
                    <td class="{$myobj->getCSSFormLabelCellClass('discussion_title')}"><label for="discussion_title">{$LANG.discussion_title_add}</label>
                    <span class="clsRequired">*</span>{$myobj->ShowHelpTip('discussion_title')}</td>
                    <td class="{$myobj->getCSSFormFieldCellClass('discussion_title')}">
                        <input type="text" class="clsTextBox {$myobj->getCSSFormFieldElementClass('discussion_title')}" name="discussion_title" id="discussion_title" maxlength="200" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('discussion_title')}" />{$myobj->getFormFieldElementErrorTip('discussion_title')}
                    </td>
                </tr>
                    <tr>
                    <td class="{$myobj->getCSSFormLabelCellClass('discussion_description')}"><label for="discussion_description">{$LANG.discussion_description}</label>
                     <span class="clsRequired">*</span>{$myobj->ShowHelpTip('discussion_title_description', 'discussion_description')}</td>
                    <td class="{$myobj->getCSSFormFieldCellClass('discussion_description')}">
                        <textarea name="discussion_description" id="discussion_description" class="{$myobj->getCSSFormFieldElementClass('discussion_description')} clsTextArea selInputLimiter" rows="5" cols="23" maxlength="{$myobj->CFG.admin.description.limit}" tabindex="{smartyTabIndex}" maxlimit="{$myobj->CFG.admin.description.limit}">{$myobj->getFormField('discussion_description')}</textarea>{$myobj->getFormFieldElementErrorTip('discussion_description')}
                    </td>
                    </tr>
	                <tr id="selCategoryBlock">
						<td class="{$myobj->getCSSFormLabelCellClass('category')}"><label for="category">{$LANG.discuzz_common_category}</label>{if $CFG.admin.category.mandatory}<span class="clsRequired">*</span>{/if}
					    	{$myobj->ShowHelpTip('board_category', 'category')}
					    </td>
					    <td class="{$myobj->getCSSFormFieldCellClass('category')}">
					    	<div id="selGeneralCategory">
						        <select name="category" id="category" class="{$myobj->getCSSFormFieldElementClass('category')}" tabindex="{smartyTabIndex}" onchange="showNextCategory('{$myobj->discussionsAddTitle_url}', this.value, 'subCategoryDiv');">
						        	<option value="" selected>{$LANG.discuzz_common_select_choose}</option>
						            {$myobj->generalPopulateArray($myobj->populateCategories_arr, $myobj->getFormField('category'))}
						        </select>
					        </div>
					        <div id="subCategoryDiv">
					        {assign var=nextitem value=0}
							{foreach key=inc item=value from=$myobj->sublevel_categories}
								{if $value}
									{assign var=nextitem value=$inc+1}
									<div id="subCategoryDiv{$inc}">
										<select name="subcategory[]" id="subcategory" class="{$myobj->getCSSFormFieldElementClass('category')}" tabindex="{smartyTabIndex}" onchange="showNextCategory('addDiscussionTitle.php', this.value, 'subCategoryDiv{$nextitem}');">
											<option value="" selected>{$LANG.discuzz_common_select_choose}</option>
										{foreach key=inc item=cat_details from=$value}
											<option value="{$cat_details.cat_id}" {$cat_details.selected}>{$cat_details.cat_name}</option>
										{/foreach}
										</select>
									</div>
								{/if}
							{/foreach}
							{if $nextitem gt 0}<div id="subCategoryDiv{$nextitem}"></div>{/if}
							{$myobj->getFormFieldElementErrorTip('category', 'select')}
							</div>
					    </td>
					</tr>
					{if $CFG.admin.friends.allowed and $CFG.admin.discussions.visibility.needed}
                        <tr>
                        <td class="{$myobj->getCSSFormLabelCellClass('visible_to')}"><label for="status_all">{$myobj->LANG.discussion_visible_to}</label>
                        {$myobj->ShowHelpTip('visible_to')}
                        </td>
                        <td class="{$myobj->getCSSFormFieldCellClass('visible_to')}">
                        <div class="clsRadioBtn"><input type="radio" name="visible_to" id="status_all" value="All" {$myobj->isCheckedRadio('visible_to', 'All')} tabindex="{smartyTabIndex}" /><label for="status_all">{$LANG.discuzz_common_all_option}</label>
                        <input type="radio" name="visible_to" id="status_friends" value="Friends" {$myobj->isCheckedRadio('visible_to', 'Friends')} tabindex="{smartyTabIndex}" /><label for="status_friends">{$LANG.discuzz_common_friends_option}</label>
                        <input type="radio" name="visible_to" id="status_none" value="None" {$myobj->isCheckedRadio('visible_to', 'None')} tabindex="{smartyTabIndex}" /><label for="status_none">{$LANG.discuzz_common_none_option}</label>
                        </div>
						<p class="clsFormInfo">{$LANG.discussion_msg_board_visible_to_help}</p>{$myobj->getFormFieldElementErrorTip('visible_to')}
                        </td>
                        </tr>
    	            {/if}
                    {if !$CFG.admin.board_auto_publish.allowed}
                        <tr>
                        <td class="{$myobj->getCSSFormLabelCellClass('publish')}"><label for="status_yes">{$myobj->LANG.discussion_publish_allboards}</label>
                        {$myobj->ShowHelpTip('publish_boards', 'status_no')}
                        </td>
                        <td class="{$myobj->getCSSFormFieldCellClass('publish')}">
                        <input type="radio" name="publish" id="status_yes" value="Yes" {$myobj->isCheckedRadio('publish', 'Yes')} tabindex="{smartyTabIndex}" /> 
						<label for="status_yes">{$LANG.discuzz_common_yes_option}</label>
                        <input type="radio" name="publish" id="status_no" value="No" {$myobj->isCheckedRadio('publish', 'No')} tabindex="{smartyTabIndex}" /> 
						<label for="status_no">{$LANG.common_no_option}</label>
                        <p class="clsCaption">{$LANG.discussion_msg_board_publish_help}</p>{$myobj->getFormFieldElementErrorTip('publish')}
                        </td>
                        </tr>
    	            {/if}
                    <tr>
                    <td></td>
                       <td  class="{$myobj->getCSSFormFieldCellClass('submit')}">
                       <p class="clsSubmitButton">
						<span>
					    <input type="submit" class="clsSearchButtonInput" name="discussion_submit" id="submit" tabindex="{smartyTabIndex}" value="{$myobj->button_value}" onclick="return updatelengthMine(this.form.discussion_description);" />
                       </span></p>
					   <p class="clsCancelButton">
						<span>
                        <input type="submit" class="clsCancelButtonInput cancel" name="discussion_cancel" id="discussion_cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" />
						</span></p>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="discussion_id" id="discussion_id" value="{$myobj->getFormField('discussion_id')}" />
        </form>
    </div>
{/if}
{if !isAjax()}
	</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div></div>
  <!--end of rounded corners-->
</div>
</div>
{/if}
{if $myobj->isShowPageBlock('sub_category_block')}
	{if $myobj->subcategory_details}
		<select name="subcategory[]" id="subcategory{$myobj->getFormField('cat_id')}" class="{$myobj->getCSSFormFieldElementClass('category')}" tabindex="1023" onchange="showNextCategory('addDiscussionTitle.php', this.value, 'subCategoryDiv{$myobj->getFormField('cat_id')}');">
			<option value="" selected>{$LANG.discuzz_common_select_choose}</option>
			{$myobj->generalPopulateArray($myobj->subcategory_details, $myobj->getFormField('subcategory'))}
		</select>
		<div id="subCategoryDiv{$myobj->getFormField('cat_id')}"></div>
	{/if}
{/if}