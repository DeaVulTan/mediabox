<div id="articleManage">
  	<h2><span>{$LANG.articleManage_title}</span></h2>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(false)}">
			<table summary="{$LANG.articleManage_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirmdel" id="confirmdel" tabindex="{smartyTabIndex}" value="{$LANG.confirm}" />
						&nbsp;
						<input type="button" class="clsSubmitButton" name="subcancel" id="subcancel" tabindex="{smartyTabIndex}" value="{$LANG.articleManage_cancel}"  onClick="return hideAllBlocks();" />
						<input type="hidden" name="checkbox" id="checkbox" />
						<input type="hidden" name="action" id="action" />
						<input type="hidden" name="article_categories" id="article_categories" />
						{$myobj->populateHidden($myobj->hidden_arr)}
					</td>
				</tr>
			</table>
		</form>
	</div>

{$myobj->setTemplateFolder('admin/')}
{include file='information.tpl'}

{if $myobj->isShowPageBlock('form_search')}
	<div id="selShowSearchGroup">
		<form name="selFormSearch" id="selFormSearch" method="post" action="{$myobj->getCurrentUrl(false)}">
			<table border="1" cellspacing="0" summary="{$LANG.articleManage_search_tbl_summary}">
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_uname')}"><label for="srch_uname">{$LANG.articleManage_search_username}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_uname')}"><input type="text" class="clsTextBox" name="srch_uname" id="srch_uname" value="{$myobj->getFormField('srch_uname')}" tabindex="{smartyTabIndex}"/></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_title')}"><label for="srch_title">{$LANG.articleManage_search_title}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_title')}">{$myobj->getFormFieldErrorTip('srch_title')}<input type="text" class="clsTextBox" name="srch_title" id="srch_title" value="{$myobj->getFormField('srch_title')}" tabindex="{smartyTabIndex}"/></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_flag')}"><label for="srch_flag">{$LANG.articleManage_search_flaged}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_flag')}">
					<select name="srch_flag" id="srch_flag" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.action_select}</option>
						<option value="Yes" {if $myobj->getFormField('srch_flag') == 'Yes'} SELECTED {/if}>{$LANG.articleManage_search_flag_yes}</option>
						<option value="No" {if $myobj->getFormField('srch_flag') == 'No'} SELECTED {/if}>{$LANG.articleManage_search_flag_no}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_feature')}"><label for="srch_feature">{$LANG.articleManage_search_featured}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_feature')}">
					<select name="srch_feature" id="srch_feature" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.action_select}</option>
						<option value="Yes" {if $myobj->getFormField('srch_feature') == 'Yes'} SELECTED {/if}>{$LANG.articleManage_search_feature_yes}</option>
						<option value="No" {if $myobj->getFormField('srch_feature') == 'No'} SELECTED {/if}>{$LANG.articleManage_search_feature_no}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_date_added')}"><label for="srch_date">{$LANG.articleManage_search_date_created}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_date_added')}">{$myobj->getFormFieldErrorTip('srch_date_added')}
					<select name="srch_date" id="srch_date" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.articleManage_search_date}</option>
						{$myobj->populateBWNumbers(1, 31, $myobj->getFormField('srch_date'))}
					</select>
					<select name="srch_month" id="srch_month" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.articleManage_search_month}</option>
						{$myobj->populateMonthsList($myobj->getFormField('srch_month'))}
					</select>
					<select name="srch_year" id="srch_year" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.articleManage_search_year}</option>
						{$myobj->populateBWNumbers(1920, $myobj->current_year, $myobj->getFormField('srch_year'))}
					</select>

				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_categories')}"><label for="srch_categories">{$LANG.articleManage_search_categories}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_categories')}">{$myobj->getFormFieldErrorTip('srch_categories')}
					<select name="srch_categories" id="srch_categories" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.action_select}</option>
                        {$myobj->populateArticleCategory($myobj->getFormField('srch_categories'))}
					</select>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormFieldCellClass('articleManage_search')}" colspan="2"><input type="submit" class="clsSubmitButton" value="{$LANG.articleManage_search}" id="search" name="search" tabindex="{smartyTabIndex}"/></td>
			</tr>
			</table>
			{$myobj->populateHidden($myobj->form_search.hidden_arr)}
		</form>
	</div>
{/if}

{if $myobj->isShowPageBlock('list_article_form')}
    <div id="selArticleList">

	{if $myobj->isResultsFound()}
		   	<form name="article_manage_form2" id="article_manage_form2" method="post" action="{$myobj->getCurrentUrl(true)}">

            {if $CFG.admin.navigation.top}
            	{$myobj->setTemplateFolder('admin/')}
                {include file='pagination.tpl'}
            {/if}
            	<p><b>{$LANG.common_article_note}</b>&nbsp;{$LANG.common_article_articlepreview_note}</p>
			  	<table summary="{$LANG.articleManage_tbl_summary}">
					<tr>
						<th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.article_manage_form2.name, document.article_manage_form2.check_all.name)"/></th>
						<th>{$LANG.article_article_id}</th>
                        <th>{$LANG.common_article_article_title}</th>
						<th>{$LANG.article_article_category}</th>
                     {if $CFG.admin.articles.sub_category}
                        <th>{$LANG.article_article_sub_category}</th>
                     {/if}
						<th>{$LANG.article_user_name}</th>
						<th>{$LANG.article_date_added}</th>
						<th>{$LANG.article_option}</th>
						<th>{$LANG.article_featured}</th>
						<th>&nbsp;</th>
					</tr>
					{foreach key=dalKey item=dalValue from=$displayarticleList_arr.row}
						<tr>
							<td class="clsSelectAllItems"><input type='checkbox' name='checkbox[]' value="{$dalValue.record.article_id}-{$dalValue.record.user_id}" /></td>
							<td>{$dalValue.record.article_id}</td>
                            <td><a id="previewArticle_{$dalValue.record.article_id}" href="{$CFG.site.url}admin/article/articlePreview.php?article_id={$dalValue.record.article_id}" class="lightwindow">{$dalValue.record.article_title}</a></td>
							<td>{$myobj->getArticleCategory($dalValue.record.article_category_id)}</td>
                        {if $CFG.admin.articles.sub_category}
                            <td>{$myobj->getArticleCategory($dalValue.record.article_sub_category_id)}</td>
                        {/if}
							<td>{$dalValue.name}</td>
							<td>{$dalValue.record.date_added}</td>
							<td>{$dalValue.record.flagged_status}</td>
							<td>{$dalValue.record.featured}</td>
							<td>
								<!--a href="articleWriting.php?article_id={$dalValue.record.article_id}" class="clsPhotoArticleEditLinks" title="{$LANG.articlelist_edit_article}">{$LANG.articlelist_edit_article}</a><br/-->
								<a id="viewArticleComment_{$dalValue.record.article_id}" href="{$CFG.site.url}admin/article/manageArticleComments.php?article_id={$dalValue.record.article_id}"  class="lightwindow">{$dalValue.comments_text}</a>
							</td>
						</tr>
                    {/foreach}
					<tr>
						<td colspan="9">
							<a href="#" id="dAltMlti"></a>
							<select name="article_options" id="article_options" tabindex="{smartyTabIndex}">
								<option value="">{$LANG.action_select}</option>
								<option value="Delete">{$LANG.action_delete}</option>
								<option value="Flag">{$LANG.action_flag}</option>
								<option value="UnFlag">{$LANG.action_unflag}</option>
								<option value="Featured">{$LANG.action_featured}</option>
								<option value="UnFeatured">{$LANG.action_unfeatured}</option>
							</select>&nbsp;
							<input type="button" class="clsSubmitButton" name="delete" tabindex="{smartyTabIndex}" value="{$LANG.articleManage_submit}" onClick="if(getMultiCheckBoxValue('article_manage_form2', 'check_all', '{$LANG.articleManage_err_tip_select_articles}'))  {literal} { {/literal} getAction() {literal} } {/literal}" />
							&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
					</tr>
				</table>

            {if $CFG.admin.navigation.bottom}
            	{$myobj->setTemplateFolder('admin/')}
                {include file='pagination.tpl'}
            {/if}

			{$myobj->populateHidden($myobj->list_article_form.hidden_arr)}

			</form>
	{else}
        {$LANG.articleManage_no_records_found}
	{/if}

    </div>
{/if}
</div>
{* Added code to display fancy box for article comments and preview article *}
<script>
{literal}
$Jq(document).ready(function() {
	{/literal}
	{if $myobj->isResultsFound()}
	{foreach key=dalKey item=dalValue from=$displayarticleList_arr.row}
	{literal}
	$Jq('#viewArticleComment_'+{/literal}{$dalValue.record.article_id}{literal}).fancybox({
		'width'				: 900,
		'height'			: 750,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});

	$Jq('#previewArticle_'+{/literal}{$dalValue.record.article_id}{literal}).fancybox({
		'width'				: 900,
		'height'			: 750,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
	{/literal}
	{/foreach}
	{/if}
	{literal}
});
{/literal}
</script>