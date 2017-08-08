<div id="selHomePageBlock" class="clsArticleCategory">
	<h2><span>{$LANG.homepageblock_title}</span></h2>
    <p class="clsBackLink"><a href="reOrderIndexBlock.php">{$LANG.homepageblock_back}</a></p>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			<table summary="{$LANG.homepageblock_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_yes_option}" />&nbsp;
						<input type="button" class="clsSubmitButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_no_option}" onClick="return hideAllBlocks();" />
						<input type="hidden" name="home_page_block_ids" id="home_page_block_ids" />
						<input type="hidden" name="action" id="action" />
						{$myobj->populateHidden($myobj->hidden_arr1)}
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="clsLeftNavigation" id="selLeftNavigation">


  {$myobj->setTemplateFolder('admin/')} {include file='information.tpl'}
<p class="ClsMandatoryText">{$LANG.common_mandatory_hint_1}{$myobj->displayCompulsoryIcon()}{$LANG.common_mandatory_hint_2}</p>

{if $myobj->isShowPageBlock('form_create_home_page_block')}
	<div id="selCreateCategory">
		<form name="manageSelCreateCategory" id="manageSelCreateCategory" enctype="multipart/form-data" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
		<table class="clsNoBorder" border="0" summary="{$LANG.homepageblock_create_tbl_summary}">
		   	<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('module_name')}"><label for="module_name">{$LANG.homepageblock_module_name}</label> {$myobj->displayCompulsoryIcon()}</td>
				<td class="{$myobj->getCSSFormFieldCellClass('module_name')}">{$myobj->getFormFieldErrorTip('module_name')}
					<input type="text" class="clsTextBox" name="module_name" id="module_name" value="{$myobj->getFormField('module_name')}" tabindex="{smartyTabIndex}" />				</td>
			</tr>
            <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('block_name')}"><label for="block_name">{$LANG.homepageblock_block_name}</label> {$myobj->displayCompulsoryIcon()}</td>
				<td class="{$myobj->getCSSFormFieldCellClass('block_name')}">{$myobj->getFormFieldErrorTip('block_name')}
					<input type="text" class="clsTextBox" name="block_name" id="block_name" value="{$myobj->getFormField('block_name')}" tabindex="{smartyTabIndex}" />				</td>
			</tr>
            <tr>
			  <td class="{$myobj->getCSSFormLabelCellClass('block_description')}">{$LANG.homepageblock_block_description}</td>
			  <td class="{$myobj->getCSSFormFieldCellClass('block_description')}"><textarea name="block_description" id="block_description" cols="45" rows="5" tabindex="{smartyTabIndex}">{$myobj->getFormField('block_description')}</textarea></td>
		  </tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('display')}"><label for="display_yes">{$LANG.homepageblock_block_display}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('display')}">
					<input type="radio" class="clsCheckRadio" name="display" id="display_yes" value="Yes" {if $myobj->getFormField('display') == 'Yes'} CHECKED {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="display_yes">{$LANG.homepageblock_display_yes}</label>
					&nbsp;&nbsp;
					<input type="radio" class="clsCheckRadio" name="display" id="display_no" value="No" {if $myobj->getFormField('display') == 'No'} CHECKED {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="display_no">{$LANG.homepageblock_display_no}</label>				</td>
			</tr>

			<tr>
				<td class="{$myobj->getCSSFormFieldCellClass('profile_block_submit')}"></td>
				<td class="{$myobj->getCSSFormFieldCellClass('profile_block_submit')}">
			{if $myobj->chkIsEditMode()}
					<input type="submit" class="clsSubmitButton" name="homepage_block_submit" id="homepage_block_submit" tabindex="{smartyTabIndex}" value="{$LANG.homepageblock_update_submit}" />
					<input type="submit" class="clsCancelButton" name="category_cancel" id="category_cancel" tabindex="{smartyTabIndex}" value="{$LANG.homepageblock_cancel_submit}" />
			{else}
			        <input type="submit" class="clsSubmitButton" name="homepage_block_submit" id="homepage_block_submit" tabindex="{smartyTabIndex}" value="{$LANG.homepageblock_add_submit}" />
			{/if}				</td>
			</tr>
		</table>
        {$myobj->populateHidden($myobj->form_create_home_page_block.hidden_arr)}
		</form>
	</div>

{/if}

{if $myobj->isShowPageBlock('form_show_Home_page_block')}
	<form name="selFormCategory" id="selFormCategory" method="post" action="{$myobj->getCurrentUrl()}">
    {$myobj->populateHidden($myobj->form_show_Home_page_block.hidden_arr)}

    <div id="selShowCategories">
        {if $myobj->isResultsFound()}
            {if $CFG.admin.navigation.top}

                {$myobj->setTemplateFolder('admin/')} {include file='pagination.tpl'}
            {/if}

            <table summary="{$LANG.homepageblock_tbl_summary}">
                <tr>
                    <th><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.selFormCategory.name, document.selFormCategory.check_all.name)"/></th>
                    <th>{$LANG.homepageblock_module_name}</th>
                    <th>{$LANG.homepageblock_block_name}</th>
                    <th>{$LANG.homepageblock_block_description}</th>
                    <th>{$LANG.homepageblock_block_display}</th>
                    <th>{$LANG.homepageblock_date_added}</th>
                    <th>&nbsp;</th>
                </tr>
			{foreach key=scKey item=scValue from=$showHomePageBlock_arr}
                <tr>
                    <td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="home_page_block_ids[]" value="{$scValue.record.home_page_block_id}" tabindex="{smartyTabIndex}" onClick="checkCheckBox(this.form, 'check_all');" {$scValue.checked}/></td>
                   <td> <p>{$scValue.record.module_name}<p></td>
                   <td> <p>{$scValue.record.block_name}</p></td>
                   <td>{$scValue.record.block_description}</td>
                   <td> <p>{$scValue.record.display}</p></td>
                   <td> <p>{$scValue.record.date_added}</p></td>
                    <td>
                        <p id="edit"><a href="manageHomePageBlock.php?home_page_block_id={$scValue.record.home_page_block_id}&amp;start={$myobj->getFormField('start')}">{$LANG.homepageblock_edit}</a></p>                    </td>
                </tr>
            {/foreach}
				<tr>
                <td></td>
					<td colspan="7" class="{$myobj->getCSSFormFieldCellClass('delete')}">
						<a href="#" id="dAltMlti"></a>
                        <select name="homepage_block_options" id="homepage_block_options" tabindex="{smartyTabIndex}" >
							<option value="Enable">{$LANG.homepageblock_action_enable}</option>
	  						<option value="Disable">{$LANG.homepageblock_action_disable}</option>
	  						<option value="Delete">{$LANG.homepageblock_action_delete}</option>
	  					</select>
						<input type="button" class="clsSubmitButton" name="action_delete" id="action_delete" tabindex="{smartyTabIndex}" value="{$LANG.homepageblock_submit}" onClick="if(getMultiCheckBoxValue('selFormCategory', 'check_all', '{$LANG.homepageblock_err_tip_select_profile_block}', 'dAltMlti', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirm', 'msgConfirmform', Array('home_page_block_ids', 'action', 'confirmMessage'), Array(multiCheckValue,  document.selFormCategory.homepage_block_options.value, '{$LANG.homepageblock_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" />					</td>
				</tr>
			</table>

        {if $CFG.admin.navigation.bottom}

                {$myobj->setTemplateFolder('admin/')} {include file='pagination.tpl'}
            {/if}
        {else}
            <div id="selMsgAlert">
                <p>{$LANG.homepageblock_no_block_found}</td>
            </div>
        {/if}
    </div>
	</form>
{/if}

	</div>
</div>