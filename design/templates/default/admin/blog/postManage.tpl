<div id="postManage">
  	<h2><span>{$LANG.postmanage_title}</span></h2>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(false)}">
			<table summary="{$LANG.postmanage_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirmdel" id="confirmdel" tabindex="{smartyTabIndex}" value="{$LANG.postmanage_confirm}" />
						&nbsp;
						<input type="button" class="clsSubmitButton" name="subcancel" id="subcancel" tabindex="{smartyTabIndex}" value="{$LANG.postmanage_cancel}"  onClick="return hideAllBlocks();" />
						<input type="hidden" name="checkbox" id="checkbox" />
						<input type="hidden" name="action" id="action" />
						<input type="hidden" name="blog_categories" id="blog_categories" />
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
			<table border="1" cellspacing="0" summary="{$LANG.postmanage_search_tbl_summary}">
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_uname')}"><label for="srch_uname">{$LANG.postmanage_search_username}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_uname')}"><input type="text" class="clsTextBox" name="srch_uname" id="srch_uname" value="{$myobj->getFormField('srch_uname')}" tabindex="{smartyTabIndex}"/></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_title')}"><label for="srch_title">{$LANG.postmanage_search_title}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_title')}">{$myobj->getFormFieldErrorTip('srch_title')}<input type="text" class="clsTextBox" name="srch_title" id="srch_title" value="{$myobj->getFormField('srch_title')}" tabindex="{smartyTabIndex}"/></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_flag')}"><label for="srch_flag">{$LANG.postmanage_search_flaged}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_flag')}">
					<select name="srch_flag" id="srch_flag" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.postmanage_action_select}</option>
						<option value="Yes" {if $myobj->getFormField('srch_flag') == 'Yes'} SELECTED {/if}>{$LANG.postmanage_search_flag_yes}</option>
						<option value="No" {if $myobj->getFormField('srch_flag') == 'No'} SELECTED {/if}>{$LANG.postmanage_search_flag_no}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_feature')}"><label for="srch_feature">{$LANG.postmanage_search_featured}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_feature')}">
					<select name="srch_feature" id="srch_feature" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.postmanage_action_select}</option>
						<option value="Yes" {if $myobj->getFormField('srch_feature') == 'Yes'} SELECTED {/if}>{$LANG.postmanage_search_feature_yes}</option>
						<option value="No" {if $myobj->getFormField('srch_feature') == 'No'} SELECTED {/if}>{$LANG.postmanage_search_feature_no}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_date_added')}"><label for="srch_date">{$LANG.postmanage_search_date_created}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_date_added')}">{$myobj->getFormFieldErrorTip('srch_date_added')}
					<select name="srch_date" id="srch_date" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.postmanage_search_date}</option>
						{$myobj->populateBWNumbers(1, 31, $myobj->getFormField('srch_date'))}
					</select>
					<select name="srch_month" id="srch_month" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.postmanage_search_month}</option>
						{$myobj->populateMonthsList($myobj->getFormField('srch_month'))}
					</select>
					<select name="srch_year" id="srch_year" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.postmanage_search_year}</option>
						{$myobj->populateBWNumbers(1920, $myobj->current_year, $myobj->getFormField('srch_year'))}
					</select>

				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_categories')}"><label for="srch_categories">{$LANG.postmanage_search_categories}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_categories')}">{$myobj->getFormFieldErrorTip('srch_categories')}
					<select name="srch_categories" id="srch_categories" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.postmanage_action_select}</option>
                        {$myobj->populateAdminBlogCategory($myobj->getFormField('srch_categories'))}
					</select>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormFieldCellClass('postmanage_search')}" colspan="2">
                <input type="submit" class="clsSubmitButton" value="{$LANG.postmanage_search}" id="search" name="search" tabindex="{smartyTabIndex}"/>&nbsp;
                <input type="submit" class="clsSubmitButton" value="{$LANG.postmanage_reset}" id="reset" name="reset" tabindex="{smartyTabIndex}"/>&nbsp;
               </td>
			</tr>
			</table>
			{$myobj->populateHidden($myobj->form_search.hidden_arr)}
		</form>
	</div>
{/if}

{if $myobj->isShowPageBlock('list_post_form')}
    <div id="selPostList">

	{if $myobj->isResultsFound()}
		   	<form name="post_manage_form2" id="post_manage_form2" method="post" action="{$myobj->getCurrentUrl(true)}">

            {if $CFG.admin.navigation.top}
            	{$myobj->setTemplateFolder('admin/')}
                {include file='pagination.tpl'}
            {/if}
            	<p><b>{$LANG.postmanage_post_note}</b>&nbsp;{$LANG.postmanage_post_preview_note}</p>
			  	<table summary="{$LANG.postmanage_tbl_summary}">
					<tr>
						<th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.post_manage_form2.name, document.post_manage_form2.check_all.name)"/></th>
						<th>{$LANG.postmanage_post_name_id}</th>
                        <th>{$LANG.postmanage_post_name_title}</th>
						<th>{$LANG.postmanage_blog_category}</th>
                     	{if $CFG.admin.blog.sub_category}
                        <th>{$LANG.postmanage_blog_sub_category}</th>
                    	{/if}
						<th>{$LANG.postmanage_post_user_name}</th>
						<th>{$LANG.postmanage_post_date_added}</th>
						<th>{$LANG.postmanage_post_option}</th>
						<th>{$LANG.postmanage_post_featured}</th>
						<th>&nbsp;</th>
					</tr>
					{foreach key=dalKey item=dalValue from=$displaypostList_arr.row}
						<tr>
							<td class="clsSelectAllItems"><input type='checkbox' name='checkbox[]' value="{$dalValue.record.blog_post_id}-{$dalValue.record.user_id}" /></td>
							<td>{$dalValue.record.blog_post_id}</td>
                            <td>
                            <a id="previewArticle_{$dalValue.record.blog_post_id}" href="{$CFG.site.url}admin/blog/postPreview.php?blog_post_id={$dalValue.record.blog_post_id}" title="{$LANG.postmanage_post_preview}"  class="lightwindow">{$dalValue.record.blog_post_name}</a>
                            
                            {*
                            <a href="{$CFG.site.url}admin/blog/postPreview.php?blog_post_id={$dalValue.record.blog_post_id}" title="{$LANG.postmanage_post_preview}" class="lightwindow" params="lightwindow_type=external">{$dalValue.record.blog_post_name}</a>
                            *}
                            </td>
							<td>{$myobj->getBlogCategory($dalValue.record.blog_category_id)}</td>
                        {if $CFG.admin.blog.sub_category}
                            <td>{$myobj->getBlogCategory($dalValue.record.blog_sub_category_id)}</td>
                        {/if}
							<td>{$dalValue.name}</td>
							<td>{$dalValue.record.date_added|date_format:#format_date_year#}</td>
							<td>{$dalValue.record.flagged_status}</td>
							<td>{$dalValue.record.featured}</td>
							<td>
                            {*							
								<a href="{$CFG.site.url}admin/blog/managePostComments.php?blog_post_id={$dalValue.record.blog_post_id}" title="{$LANG.postmanage_manage_comments}" class="lightwindow" params="lightwindow_type=external">{$dalValue.comments_text}</a>
                                *}
                                
                                <a id="viewArticleComment_{$dalValue.record.blog_post_id}" href="{$CFG.site.url}admin/blog/managePostComments.php?blog_post_id={$dalValue.record.blog_post_id}"  class="lightwindow" title="{$LANG.postmanage_manage_comments}">{$dalValue.comments_text}</a>
                                
							</td>
						</tr>
                    {/foreach}

					<tr>
						<td colspan="9">
							<a href="#" id="dAltMlti"></a>
							<select name="post_options" id="post_options" tabindex="{smartyTabIndex}">
								<option value="">{$LANG.postmanage_action_select}</option>
								<option value="Delete">{$LANG.postmanage_action_delete}</option>
								<option value="Flag">{$LANG.postmanage_action_flag}</option>
								<option value="UnFlag">{$LANG.postmanage_action_unflag}</option>
								<option value="Featured">{$LANG.postmanage_action_featured}</option>
								<option value="UnFeatured">{$LANG.postmanage_action_unfeatured}</option>
							</select>&nbsp;
							<input type="button" class="clsSubmitButton" name="delete" tabindex="{smartyTabIndex}" value="{$LANG.postmanage_submit}" onClick="if(getMultiCheckBoxValue('post_manage_form2', 'check_all', '{$LANG.postmanage_err_tip_select_posts}'))  {literal} { {/literal} getAction() {literal} } {/literal}" />
							&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
					</tr>
				</table>

            {if $CFG.admin.navigation.bottom}
            	{$myobj->setTemplateFolder('admin/')}
                {include file='pagination.tpl'}
            {/if}

			{$myobj->populateHidden($myobj->list_post_form.hidden_arr)}

			</form>
	{else}
        <div id="selErrorMsg">
            <p>{$LANG.postmanage_no_records_found}</p>
        </div>
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
	{foreach key=dalKey item=dalValue from=$displaypostList_arr.row}
	{literal}
	$Jq('#viewArticleComment_'+{/literal}{$dalValue.record.blog_post_id}{literal}).fancybox({
		'width'				: 900,
		'height'			: 600,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});

	$Jq('#previewArticle_'+{/literal}{$dalValue.record.blog_post_id}{literal}).fancybox({
		'width'				: 900,
		'height'			: 600,
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