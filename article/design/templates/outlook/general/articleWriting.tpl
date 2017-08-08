{$myobj->setTemplateFolder('general/','article')}
{include file="box.tpl" opt="display_top"}
<div id="selArticleWriting" class="clsPageHeading">
	<div class="clsOverflow"><div class="clsArticleListHeading"><h2>{if $myobj->chkIsEditMode()} {$LANG.articlewriting_edit_title} {else} {$LANG.articlewriting_title} {/if}</h2></div>
	{if $myobj->chkIsEditMode()}<div class="clsArticleListHeadingRight"><h4><a href="{$myobj->article_writing_form.manage_attachments_url}">{$LANG.articlewriting_manage_attachments}</a></h4></div>{/if}</div>
  	{*{if $CFG.admin.articles.auto_activate || $CFG.admin.is_logged_in}{if $myobj->chkIsEditMode()}<div class="clsArticleListHeadingRight"><h4><a href="{$myobj->article_writing_form.manage_attachments_url}">{$LANG.articlewriting_manage_attachments}</a></h4></div>{/if}{/if}</div>*}
	<div id="selLeftNavigation">
    	{$myobj->setTemplateFolder('general/','article')}
  		{include file='information.tpl'}
		{if $myobj->isShowPageBlock('article_writing_form')}
			<div id="selWriting">
				{if $myobj->chkIsEditMode()}
					<form name="article_writing_form" id="article_writing_form" method="post" action="{$myobj->article_writing_form.form_action}" enctype="multipart/form-data" autocomplete="off">
					<input type="hidden" name="article_status" id="article_status" value="{$myobj->getFormField('article_status')}">
				{else}
					<form name="article_writing_form" id="article_writing_form" method="post" action="{$myobj->getUrl('articlewriting', '', '', 'members', 'article')}" enctype="multipart/form-data"  autocomplete="off">
				{/if}

				<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
      			<p id="msgConfirmText"></p>
					<input type="submit" class="clsSubmitButton" name="updateConfirm" id="updateConfirm" value="{$LANG.common_confirm_option}" tabindex="{smartyTabIndex}"  onClick = "document.article_writing_form.submit()" />&nbsp;
	            	<input type="button" class="clsSubmitButton" name="notconfirm" id="notconfirm" value="{$LANG.common_cancel_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks();" />
    			</div>

		        <div id="selWritingBlock">
		        	<table summary="{$LANG.articlewriting_tbl_summary}" id="selWritingTbl" class="clsRichTextTable clsFormTableSection clsWritingBlock">
		        		{if $myobj->chkIsEditMode()}
		        			{if $myobj->getFormField('article_status')}
		        			<tr>
		        				<td>&nbsp;</td>
		        				<td>
									<label class="clsBold">
										{$LANG.articlewriting_article_status_msg1}&nbsp;
										{if $myobj->getFormField('article_status') == 'Ok'}
											{$LANG.articlewriting_article_status_published}
										{else}
											{$myobj->getFormField('article_status')}
										{/if}
										&nbsp;{$LANG.articlewriting_article_status_msg2}
									</label>
								</td>
		        			</tr>
		        			{/if}
		        		{/if}
		                <tr>
		                    <td class="{$myobj->getCSSFormLabelCellClass('article_title')}">
		                        {$myobj->displayCompulsoryIcon()}<label for="article_title">{$LANG.articlewriting_article_title}</label>
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('article_title')}">
		                        <input type="text" class="clsTextBox" name="article_title" id="article_title" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('article_title')}" maxlength="{$CFG.admin.articles.title_length}" />
		                        {$myobj->getFormFieldErrorTip('article_title')}
		                        {$myobj->ShowHelpTip('article_title')}
		                    </td>
		                </tr>
		                <tr>
		                    <td class="{$myobj->getCSSFormLabelCellClass('article_summary')}">
		                        {$myobj->displayCompulsoryIcon()}<label for="article_summary">{$LANG.articlewriting_article_summary}</label>
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('article_summary')}">
		                    	<textarea name="article_summary" id="article_summary" rows="5" cols="10"  tabindex="{smartyTabIndex}" maxlength="{$CFG.admin.articles.summary_length}" class="clsTextBox" >{$myobj->getFormField('article_summary')}</textarea><br/>
		                    	<div id="ss" class="clsZeroColour"><span class="clsCharacterLimit">{if !$myobj->chkIsEditMode()}{$LANG.articlewriting_summary_max_chars}{/if}</span></div>
		                    	{$myobj->getFormFieldErrorTip('article_summary')}
		                    	{$myobj->ShowHelpTip('article_summary')}
		                    </td>
		                </tr>
		                <tr>
		                    <td colspan="2" class="{$myobj->getCSSFormLabelCellClass('article_caption')}">
		                        <label for="article_caption">{$LANG.articlewriting_article_caption}</label>
		                    </td>
		                 </tr>
		                 <tr>
		                 	<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('article_caption')}">{$myobj->getFormFieldErrorTip('article_caption')}
		                    	{$myobj->populateTinyMceEditor('article_caption','',$myobj->tinyReadMode)}
		                        <div class="clsEditImageArticle">
		                            <div class="button2-left"><a id="article_pagebreak" href="{$myobj->article_writing_form.page_break_url}" class="pagebreak">{$LANG.articlewriting_pagebreak}</a></div>
		                            {if $CFG.admin.articles.article_insert_image}
		                            	<div class="button2-left"><a id="article_insertimage" href="{$myobj->article_writing_form.insert_image_url}" class="image">{$LANG.articlewriting_inserimage}</a></div>
		                            {/if}
		                            {*<div class="button2-left"><a href="javascript:void(0)" onclick="insertReadmore('article_caption');" title="{$LANG.articlewriting_readmore}" class="readmore">{$LANG.articlewriting_readmore}</a></div>*}
		                        </div>
		                        {$myobj->ShowHelpTip('article_caption')}
		                    </td>
		                </tr>
				        {if $CFG.admin.articles.article_attachment}
				            {if !$myobj->chkIsEditMode()}
				                <tr>
				                  <td class="{$myobj->getCSSFormLabelCellClass('article_file')}">
				                  	{if $CFG.admin.articles.article_attachment_compulsory}{$myobj->displayCompulsoryIcon()}{/if}
				                    <label for="article_file">{$LANG.articlewriting_article_attachment}</label>
				                 </td>
				                  <td class="{$myobj->getCSSFormFieldCellClass('article_file')}">
				                    <input type="file" name="article_file" id="article_file" class="clsFileBox" accept="image/{$myobj->changeArrayToCommaSeparator($CFG.admin.articles.attachment_format_arr)}"  tabindex="{smartyTabIndex}" /><br/>
				                    <label class="clsBold">{$LANG.articlewriting_attachment_max_filesize}</label>&nbsp;{$CFG.admin.articles.attachment_max_size}&nbsp;{$LANG.common_kilobyte}<br />
									<label class="clsBold">{$LANG.articlewriting_attachment_allowed_formats}</label>&nbsp;{$myobj->changeArrayToCommaSeparator($CFG.admin.articles.attachment_format_arr)}
									{$myobj->getFormFieldErrorTip('article_file')}
				                    {$myobj->ShowHelpTip('article_attachment', 'article_file')}
				                    </td>
				                </tr>
				             {/if}
				        {/if}
		                <tr>
		                    <td class="{$myobj->getCSSFormLabelCellClass('article_tags')}">
		                        {$myobj->displayCompulsoryIcon()}<label for="article_tags">{$LANG.articlewriting_article_tags|nl2br}</label>
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('article_tags')}">
		                        <input type="text" class="clsTextBox" name="article_tags" id="article_tags" value="{$myobj->getFormField('article_tags')}" tabindex="{smartyTabIndex}" /><br />
		                        {$LANG.articlewriting_tags_msg|nl2br}
		                        {$myobj->getFormFieldErrorTip('article_tags')}
		                        {$myobj->ShowHelpTip('article_tags')}
		                    </td>
		                </tr>
		                {if $myobj->content_filter}
			                <tr id="selDateLocationRow">
			                	<td class="{$myobj->getCSSFormLabelCellClass('article_category_type')}">
			                    	<label for="article_category_type2">{$LANG.articlewriting_article_category_type}</label>
			                    </td>
			                    <td class="{$myobj->getCSSFormFieldCellClass('article_category_type')}">
			                        <input type="radio" name="article_category_type" id="article_category_type1" class="clsRadioButtonBorder" value="Porn" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('article_category_type','Porn')} onclick="document.getElementById('selGeneralCategory').style.display='none';document.getElementById('selPornCategory').style.display='';" />
			                        &nbsp;<label for="article_category_type1" class="clsBold">{$LANG.common_porn}</label>
			                        &nbsp;&nbsp;
			                        <input type="radio" name="article_category_type" id="article_category_type2" class="clsRadioButtonBorder" value="General" tabindex="{smartyTabIndex}"
			                        {$myobj->isCheckedRadio('article_category_type','General')}
			                        onclick="document.getElementById('selGeneralCategory').style.display='';document.getElementById('selPornCategory').style.display='none';" />
			                        &nbsp;<label for="article_category_type2" class="clsBold">{$LANG.common_general}</label>
			                        {$myobj->getFormFieldErrorTip('article_category_type')}
			                        {$myobj->ShowHelpTip('article_category_type1')} {$myobj->ShowHelpTip('article_category_type2')}
								 </td>
			                </tr>
		                {/if}
		                <tr id="selCategoryBlock">
		                    <td class="{$myobj->getCSSFormLabelCellClass('article_category_id')}">
		                        {$myobj->displayCompulsoryIcon()}<label for="article_category_id">{$LANG.articlewriting_article_category_id}</label>
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('article_category_id')}">

		                        <div id="selGeneralCategory" style="display:{$myobj->General}">
		                            <!--<select name="article_category_id" id="article_category_id" tabindex="{smartyTabIndex}" {if $CFG.admin.articles.sub_category} onchange="return populate_article_sub_categories('{$CFG.site.url}article/article_ajax.php', 't={smartyTabIndex}','selGeneralSubCategory');" {/if} class="required">-->
		                            <select name="article_category_id" id="article_category_id" tabindex="{smartyTabIndex}" {if $CFG.admin.articles.sub_category} onchange="return populateArticleSubCategory(this.value);" {/if}>
		                                <option value="">{$LANG.articlewriting_select_category}</option>
		                                {$myobj->populateArticleCatagory('General')}
		                                {*$myobj->generalPopulateArray($myobj->articleCategory_arr, $myobj->getFormField('article_category_id'))*}
		                            </select>
		                        </div>
								{if $myobj->content_filter}
		                        <div id="selPornCategory" style="display:{$myobj->Porn}">
			                        <select name="article_category_id_porn" id="article_category_id_porn" {if $CFG.admin.articles.sub_category} onchange="populateArticleSubCategory(this.value)" {/if} tabindex="{smartyTabIndex}">
		                            	<option value="">{$LANG.articlewriting_select_category}</option>
		                                {$myobj->populateArticleCatagory('Porn')}
		                              	{*$myobj->populateArticleCategory('Porn')*}
		                            </select>
		                            {$myobj->getFormFieldErrorTip('article_category_id_porn')}
		                        </div>
		                    	{/if}
								{$LANG.articlewriting_select_a_category}
								{$myobj->getFormFieldErrorTip('article_category_id')}
		                        {$myobj->ShowHelpTip('article_category_id')}
		                    </td>
		                </tr>
		                {if $CFG.admin.articles.sub_category}
		                    <tr id="selSubCategoryBlock">
		                        <td class="{$myobj->getCSSFormLabelCellClass('article_sub_category_id')}">
		                            <label for="article_sub_category_id">{$LANG.articlewriting_article_sub_category_id}</label>
		                        </td>
		                        <td class="{$myobj->getCSSFormFieldCellClass('article_sub_category_id')}">
		                            <div id="selSubCategoryBox">
		                                <select name="article_sub_category_id" id="article_sub_category_id" tabindex="{smartyTabIndex}">
		                                    <option value="">{$LANG.articlewriting_select_sub_category}</option>
		                                </select>
		                            </div>
		                            {$myobj->getFormFieldErrorTip('article_sub_category_id')}
		                            {$myobj->ShowHelpTip('article_sub_category_id')}
		                        </td>
		                    </tr>
		                {/if}
		                <tr>
		                    <th class="clsArticleSettings">{$LANG.articlewriting_article_settings}</th>
		                    <th>&nbsp;</th>
		                </tr>
		                <tr id="selAllowDraft" class="clsAllowOptions">
		                    <td class="{$myobj->getCSSFormLabelCellClass('draft_mode')}">
		                        <label for="draft_mode">{$LANG.articlewriting_draft_mode}</label>
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('draft_mode2')}">{$myobj->getFormFieldErrorTip('draft_mode')}
		                        <p><input type="radio" class="clsCheckRadio" name="draft_mode" id="draft_mode1" value="Yes" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('draft_mode','Yes')} />&nbsp;<label for="draft_mode1" class="clsBold">{$LANG.articlewriting_yes}</label>{$LANG.articlewriting_draft_mode_world}</p>
		                        <p><input type="radio" class="clsCheckRadio" name="draft_mode" id="draft_mode2" value="No" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('draft_mode','No')} />&nbsp;<label for="draft_mode2" class="clsBold">{$LANG.articlewriting_no}</label>{$LANG.articlewriting_undraft_mode_world}</p>
		                        {$myobj->ShowHelpTip('draft_mode')}
		                    </td>
		                </tr>
		                {if !$myobj->checkTinyMode()}
				    	<tr>
		                	<td class="{$myobj->getCSSFormLabelCellClass('date_of_publish')}">
		                    	{$myobj->displayCompulsoryIcon()}<label for="date_of_publish">{$LANG.date_of_publish}</label>
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('date_of_publish')}">
		                        <input type="text" class="ClsTextBox" name="date_of_publish" id="date_of_publish" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('date_of_publish')}" />
		                        {$myobj->populateDateCalendar('date_of_publish', $dob_calendar_opts_arr)}
		                        {$myobj->getFormFieldErrorTip('date_of_publish', true)}
		                        {$myobj->ShowHelpTip('date_of_publish')}
		                    </td>
                		</tr>
		                {elseif $myobj->checkTinyMode()}
		                <tr id="selPublishDate" class="clsAllowOptions">
							<td>{$LANG.articlewriting_article_status}</td>
							<td><label class="clsBold">{$LANG.articlewriting_article_published}</label></td>
							{*<td><label class="clsBold">{$LANG.articlewriting_article_published}&nbsp;{$myobj->getFormField('article_published_date')}</label></td>*}
							<input type="hidden" name="date_of_publish" id="date_of_publish" value="{$myobj->getFormField('date_of_publish')}">
		                </tr>
		                {/if}
		                <tr id="selArticleAccessRow">
		                    <td class="{$myobj->getCSSFormLabelCellClass('article_access_type')}">
		                        <label for="article_access_type1">{$LANG.articlewriting_article_access_type}</label>
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('article_access_type')}">{$myobj->getFormFieldErrorTip('article_access_type')}
		                        <p><input type="radio" class="clsCheckRadio" name="article_access_type" id="article_access_type1" value="Public" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('article_access_type','Public')} />&nbsp;<label for="article_access_type1" class="clsBold">{$LANG.articlewriting_public}</label>{$LANG.articlewriting_share_your_article_world}</p>
		                        <p><input type="radio" class="clsCheckRadio" name="article_access_type" id="article_access_type2" value="Private" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('article_access_type','Private')} />&nbsp;<label for="article_access_type2" class="clsBold">{$LANG.articlewriting_private}</label>{$LANG.articlewriting_only_viewable_you}</p>
		                        <p class="clsSelectHighlightNote">{$LANG.articlewriting_only_viewable_you_email}</p>
		                        <br />{$myobj->populateCheckBoxForRelationList()}
		                        {$myobj->ShowHelpTip('article_access_type')}
		                    </td>
		                </tr>
		                <tr id="selAllowCommentsRow" class="clsAllowOptions">
		                    <td class="{$myobj->getCSSFormLabelCellClass('allow_comments')}">
		                        <label for="allow_comments1">{$LANG.articlewriting_allow_comments}</label>
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('allow_comments')}">{$myobj->getFormFieldErrorTip('allow_comments')}
		                        <p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments1" value="Yes" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('allow_comments','Yes')} />&nbsp;<label for="allow_comments1" class="clsBold">{$LANG.articlewriting_yes}</label>{$LANG.articlewriting_allow_comments_world}</p>
		                        <p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments2" value="No" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('allow_comments','No')} />&nbsp;<label for="allow_comments2" class="clsBold">{$LANG.articlewriting_no}</label>{$LANG.articlewriting_disallow_comments}</p>
		                        <p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments3" value="Kinda" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('allow_comments','Kinda')} />&nbsp;<label for="allow_comments3" class="clsBold">{$LANG.articlewriting_kinda}</label>{$LANG.articlewriting_approval_comments}</p>
		                        {$myobj->ShowHelpTip('allow_comments')}
		                    </td>
		                </tr>
		                <tr id="selAllowRatingsRow" class="clsAllowOptions">
		                    <td class="{$myobj->getCSSFormLabelCellClass('allow_ratings')}">
		                        <label for="allow_ratings1">{$LANG.articlewriting_allow_ratings}</label>
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('allow_ratings')}">{$myobj->getFormFieldErrorTip('allow_ratings')}
		                        <p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings1" value="Yes" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('allow_ratings','Yes')} />&nbsp;<label for="allow_ratings1" class="clsBold">{$LANG.articlewriting_yes}</label>{$LANG.articlewriting_allow_ratings_world}</p>
		                        <p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings2" value="No" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('allow_ratings','No')} />&nbsp;<label for="allow_ratings2" class="clsBold">{$LANG.articlewriting_no}</label>{$LANG.articlewriting_disallow_ratings}</p>
		                        <p id="selDisableNote">{$LANG.articlewriting_disallow_ratings1}</p>
		                        {$myobj->ShowHelpTip('allow_ratings')}
		                    </td>
		                </tr>
		                <tr>
		                    <td>&nbsp;</td><td class="clsFormFieldCellDefault">

		                        {$myobj->populateHidden($myobj->hidden_arr)}
		                        {if !$myobj->chkIsEditMode()}
		                            <input type="submit" class="clsSubmitButton" name="submit" id="submit" tabindex="{smartyTabIndex}" value="{$LANG.articlewriting_submit_article}"/>
		                        {else}
		                        	{if !$CFG.admin.articles.auto_activate && $CFG.admin.articles.allow_edit_article_to_approve && !$CFG.admin.is_logged_in && ($myobj->getFormField('article_status') == 'Ok' || $myobj->getFormField('article_status') == 'InFuture') }
		                            	<input type="button" class="clsSubmitButton" name="update" id="update" tabindex="{smartyTabIndex}" value="{$LANG.articlewriting_edit_update}"  onclick="checkAdminConfirmation();" />
		                            	<input type="hidden" name="confirmSubmit" value="yes">
		                            {else}
		                            	<input type="submit" class="clsSubmitButton" name="update" id="update" tabindex="{smartyTabIndex}" value="{$LANG.articlewriting_edit_update}" />
		                            {/if}
		                            <input type="submit" class="clsSubmitButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.articlewriting_cancel}" />
		                        {/if}
		                    </td>
		                </tr>
		            </table>
		        </div>
				</form>
		        {literal}
					<script type="text/javascript">
						/* Function to display admin approval confirmation if move to draft folder is not checked */
						function checkAdminConfirmation()
						{
							if(document.getElementById('draft_mode2').checked)
							{
                            	Confirmation('selMsgConfirm', 'article_writing_form', Array('msgConfirmText'), Array('{/literal}{$LANG.articlewriting_article_editing_admin_approval}{literal}'), Array('innerHTML'), -100, -500);
							}
                            else
                            {
								document.article_writing_form.submit();
							}
						}
		            </script>
		        {/literal}
			</div>
		{/if}
	</div>
	{if $myobj->isShowPageBlock('block_articleupload_paidmembership_upgrade_form')}
		<div>{$myobj->articleupload_upgrade_membership}</div>
	{/if}
</div>
{$myobj->setTemplateFolder('general/','article')}
{include file="box.tpl" opt="display_bottom"}
{* Added code to display to display fancy box for page break and insert image options *}
<script>
{literal}
$Jq(document).ready(function() {
	$Jq('#article_pagebreak').fancybox({
		'width'				: 450,
		'height'			: '40%',
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});

	$Jq('#article_insertimage').fancybox({
		'width'				: 580,
		'height'			: '78%',
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
});
{/literal}
</script>