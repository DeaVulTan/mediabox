{$myobj->setTemplateFolder('general/','blog')}
{include file="box.tpl" opt="display_top"}
<div id="selBlogWriting" class="clsPageHeading">
	<div class="clsOverflow"><div class="clsBlogListHeading"><h2>{if $myobj->chkIsEditMode()} {$LANG.manageblogpost_edit_title} {else} {$LANG.manageblogpost_title} {/if}</h2></div>
	{if $myobj->chkIsEditMode()}<div class="clsBlogListHeadingRight"></div>{/if}</div>
	<div id="selLeftNavigation">
  		{$myobj->setTemplateFolder('general/','blog')}
  		{include file='information.tpl'}
		{if $myobj->isShowPageBlock('blog_post_form')}
		<p class="ClsMandatoryText">{$LANG.common_mandatory_hint_1}<span class="clsMandatoryFieldIconInText">*</span>{$LANG.common_mandatory_hint_2}</p>
			<div id="selWriting">
				{if $myobj->chkIsEditMode()}
					<form name="blog_post_form" id="blog_post_form" method="post" action="{$myobj->blog_post_form.form_action}" enctype="multipart/form-data" autocomplete="off">
				{else}
					<form name="blog_post_form" id="blog_post_form" method="post" action="{$myobj->getUrl('manageblogpost', '', '', 'members', 'blog')}" enctype="multipart/form-data"  autocomplete="off">
				{/if}

				<div id="selMsgConfirm1" class="clsPopupConfirmation" style="display:none;">
      			<p id="msgConfirmText1"></p>
					<input type="submit" class="clsSubmitButton" name="update" id="update" value="{$LANG.common_confirm_option}" tabindex="{smartyTabIndex}" onClick = "document.blog_post_form.submit()" />&nbsp;

					<input type="button" class="clsSubmitButton" name="notconfirm" id="notconfirm" value="{$LANG.common_cancel_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks();" />
    			</div>

		        <div id="selWritingBlock">
		        	<table summary="{$LANG.manageblogpost_tbl_summary}" id="selWritingTbl" class="clsRichTextTable clsFormTableSection clsWritingBlock">
		        		{if $myobj->chkIsEditMode()}
		        			{if $myobj->getFormField('status')}
		        			<tr>
		        				<td class="clsWidth160">&nbsp;</td>
		        				<td>
									<label class="clsBold">
										{$LANG.manageblogpost_blog_status_msg1}&nbsp;
										{if $myobj->getFormField('status') == 'Ok'}
											{$LANG.manageblogpost_blog_status_published}
										{else}
											{$myobj->getFormField('status')}
										{/if}
										&nbsp;{$LANG.manageblogpost_blog_status_msg2}
									</label>
								</td>
		        			</tr>
		        			{/if}
		        		{/if}
		                <tr>
		                    <td class="{$myobj->getCSSFormLabelCellClass('blog_post_name')} clsWidth160">
		                        <label for="blog_post_name">{$LANG.manageblogpost_blog_post_title}</label>{$myobj->displayCompulsoryIcon()}
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('blog_post_name')}">{$myobj->getFormFieldErrorTip('blog_post_name')}
		                        <input type="text" class="clsTextBox required" name="blog_post_name" id="blog_post_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('blog_post_name')}" maxlength="{$CFG.admin.blog.blog_post_title_length}" />
		                        {$myobj->ShowHelpTip('blog_post_name')}
		                    </td>
		                </tr>
		                <tr>
		                    <td colspan="2" class="{$myobj->getCSSFormLabelCellClass('message')}">
		                        <label for="message">{$LANG.manageblogpost_blog_caption}</label>
		                    </td>
		                 </tr>
		                 <tr>
		                 	<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('message')}">{$myobj->getFormFieldErrorTip('message')}
		                    	{$myobj->populateTinyMceEditor('message','',$myobj->tinyReadMode)}
		                        {$myobj->ShowHelpTip('blog_message','message')}
		                    </td>
		                </tr>
		                <tr>
		                    <td class="{$myobj->getCSSFormLabelCellClass('blog_tags')}">
		                        <label for="blog_tags">{$LANG.manageblogpost_blog_tags|nl2br}</label>{$myobj->displayCompulsoryIcon()}
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('blog_tags')}">{$myobj->getFormFieldErrorTip('blog_tags')}
		                        <input type="text" class="clsTextBox validate-tags" name="blog_tags" id="blog_tags" value="{$myobj->getFormField('blog_tags')}" tabindex="{smartyTabIndex}" /><br />
		                        {$LANG.manageblogpost_tags_msg|nl2br}
		                        {$myobj->ShowHelpTip('blog_tags')}
		                    </td>
		                </tr>
		                {if $myobj->content_filter}
			                <tr id="selDateLocationRow">
			                	<td class="{$myobj->getCSSFormLabelCellClass('blog_category_type')}">
			                    	<label for="blog_category_type2">{$LANG.manageblogpost_blog_category_type}</label>
			                    </td>
			                    <td class="{$myobj->getCSSFormFieldCellClass('blog_category_type')}">
			                        <input type="radio" name="blog_category_type" id="blog_category_type1" class="clsRadioButtonBorder" value="Porn" tabindex="{smartyTabIndex}" {$myobj->isCheckedRadio('blog_category_type','Porn')} onclick="document.getElementById('selGeneralCategory').style.display='none';document.getElementById('selPornCategory').style.display='';" />
			                        &nbsp;<label for="blog_category_type1" class="clsBold">{$LANG.common_porn}</label>
			                        &nbsp;&nbsp;
			                        <input type="radio" name="blog_category_type" id="blog_category_type2" class="clsRadioButtonBorder" value="General" tabindex="{smartyTabIndex}"
			                        {$myobj->isCheckedRadio('blog_category_type','General')}
			                        onclick="document.getElementById('selGeneralCategory').style.display='';document.getElementById('selPornCategory').style.display='none';" />
			                        &nbsp;<label for="blog_category_type2" class="clsBold">{$LANG.common_general}</label>
			                        {$myobj->getFormFieldErrorTip('blog_category_type')}
			                        {$myobj->ShowHelpTip('blog_category_type1')} {$myobj->ShowHelpTip('blog_category_type2')}
								 </td>
			                </tr>
		                {/if}
		                <tr id="selCategoryBlock">
		                    <td class="{$myobj->getCSSFormLabelCellClass('blog_category_id')}">
		                        <label for="blog_category_id">{$LANG.manageblogpost_blog_category_id}</label>{$myobj->displayCompulsoryIcon()}
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('blog_category_id')}">{$myobj->getFormFieldErrorTip('blog_category_id')}

		                        <div id="selGeneralCategory" style="display:{$myobj->General}">
		                            <select name="blog_category_id" id="blog_category_id" tabindex="{smartyTabIndex}" class="required">
		                                <option value="">{$LANG.manageblogpost_select_category}</option>
		                                {$myobj->populateBlogCatagory('General')}
		                            </select>
		                        </div>
								{$LANG.manageblogpost_select_a_category}
		                        {$myobj->ShowHelpTip('blog_category_id')}
		                    </td>
		                </tr>
		                {if $CFG.admin.blog.sub_category}
		                    <tr id="selSubCategoryBlock">
		                        <td class="{$myobj->getCSSFormLabelCellClass('blog_sub_category_id')}">
		                            <label for="blog_sub_category_id">{$LANG.manageblogpost_blog_sub_category_id}</label>
		                        </td>
		                        <td class="{$myobj->getCSSFormFieldCellClass('blog_sub_category_id')}">{$myobj->getFormFieldErrorTip('blog_sub_category_id')}
		                            <div id="selSubCategoryBox">
		                                <select name="blog_sub_category_id" id="blog_sub_category_id" tabindex="{smartyTabIndex}">
		                                    <option value="">{$LANG.manageblogpost_select_sub_category}</option>
		                                </select>
		                            </div>
		                            {$myobj->ShowHelpTip('blog_sub_category_id')}
		                        </td>
		                    </tr>
		                {/if}
		                <tr>
		                    <th class="clsBlogManageSetting">{$LANG.manageblogpost_blog_settings}</th>
		                    <th>&nbsp;</th>
		                </tr>
		                <tr id="selAllowDraft" class="clsAllowOptions">
		                    <td class="{$myobj->getCSSFormLabelCellClass('draft_mode')}">
		                        <label for="draft_mode">{$LANG.manageblogpost_draft_mode}</label>
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('draft_mode2')}">{$myobj->getFormFieldErrorTip('draft_mode')}
		                        <p><input type="radio" class="clsCheckRadio" name="draft_mode" id="draft_mode1" value="Yes" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('draft_mode','Yes')} />&nbsp;<label for="draft_mode1" class="clsBold">{$LANG.manageblogpost_yes}</label>{$LANG.manageblogpost_draft_mode_world}</p>
		                        <p><input type="radio" class="clsCheckRadio" name="draft_mode" id="draft_mode2" value="No" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('draft_mode','No')} />&nbsp;<label for="draft_mode2" class="clsBold">{$LANG.manageblogpost_no}</label>{$LANG.manageblogpost_undraft_mode_world}</p>
		                        {$myobj->ShowHelpTip('draft_mode')}
		                    </td>
		                </tr>
		                {if !$myobj->checkTinyMode()}
		                <tr id="selPublishDate" class="clsAllowOptions">
							<td class="{$myobj->getCSSFormLabelCellClass('date_of_publish')}"><label for="publish_date">{$LANG.manageblogpost_date_of_publish}</label>{$myobj->displayCompulsoryIcon()}</td>
							<td class="{$myobj->getCSSFormFieldCellClass('date_of_publish')}">
							<input type="text" class="ClsTextBox" name="date_of_publish" id="date_of_publish" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('date_of_publish')}" />
	                        {$myobj->populateDateCalendar('date_of_publish', $dob_calendar_opts_arr)}
	                        {$myobj->getFormFieldErrorTip('date_of_publish', true)}
	                        {$myobj->ShowHelpTip('date_of_publish')}
							</td>
				    	</tr>
		                {/if}
		                <tr id="selBlogAccessRow">
		                    <td class="{$myobj->getCSSFormLabelCellClass('blog_access_type')}">
		                        <label for="blog_access_type1">{$LANG.manageblogpost_blog_access_type}</label>
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('blog_access_type')}">{$myobj->getFormFieldErrorTip('blog_access_type')}
		                        <p><input type="radio" class="clsCheckRadio" name="blog_access_type" id="blog_access_type1" value="Public" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('blog_access_type','Public')} />&nbsp;<label for="blog_access_type1" class="clsBold">{$LANG.manageblogpost_public}</label>{$LANG.manageblogpost_share_your_blog_world}</p>
		                        <p><input type="radio" class="clsCheckRadio" name="blog_access_type" id="blog_access_type2" value="Private" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('blog_access_type','Private')} />&nbsp;<label for="blog_access_type2" class="clsBold">{$LANG.manageblogpost_private}</label>{$LANG.manageblogpost_only_viewable_you}</p>
		                        <p class="clsSelectHighlightNote">{$LANG.manageblogpost_only_viewable_you_email}</p>
		                        <br />{$myobj->populateCheckBoxForRelationList()}
		                        {$myobj->ShowHelpTip('blog_access_type')}
		                    </td>
		                </tr>
		                <tr id="selAllowCommentsRow" class="clsAllowOptions">
		                    <td class="{$myobj->getCSSFormLabelCellClass('allow_comments')}">
		                        <label for="allow_comments1">{$LANG.manageblogpost_allow_comments}</label>
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('allow_comments')}">{$myobj->getFormFieldErrorTip('allow_comments')}
		                        <p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments1" value="Yes" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('allow_comments','Yes')} />&nbsp;<label for="allow_comments1" class="clsBold">{$LANG.manageblogpost_yes}</label>{$LANG.manageblogpost_allow_comments_world}</p>
		                        <p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments2" value="No" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('allow_comments','No')} />&nbsp;<label for="allow_comments2" class="clsBold">{$LANG.manageblogpost_no}</label>{$LANG.manageblogpost_disallow_comments}</p>
		                        <p><input type="radio" class="clsCheckRadio" name="allow_comments" id="allow_comments3" value="Kinda" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('allow_comments','Kinda')} />&nbsp;<label for="allow_comments3" class="clsBold">{$LANG.manageblogpost_kinda}</label>{$LANG.manageblogpost_approval_comments}</p>
		                        {$myobj->ShowHelpTip('allow_comments')}
		                    </td>
		                </tr>
		                <tr id="selAllowRatingsRow" class="clsAllowOptions">
		                    <td class="{$myobj->getCSSFormLabelCellClass('allow_ratings')}">
		                        <label for="allow_ratings1">{$LANG.manageblogpost_allow_ratings}</label>
		                    </td>
		                    <td class="{$myobj->getCSSFormFieldCellClass('allow_ratings')}">{$myobj->getFormFieldErrorTip('allow_ratings')}
		                        <p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings1" value="Yes" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('allow_ratings','Yes')} />&nbsp;<label for="allow_ratings1" class="clsBold">{$LANG.manageblogpost_yes}</label>{$LANG.manageblogpost_allow_ratings_world}</p>
		                        <p><input type="radio" class="clsCheckRadio" name="allow_ratings" id="allow_ratings2" value="No" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('allow_ratings','No')} />&nbsp;<label for="allow_ratings2" class="clsBold">{$LANG.manageblogpost_no}</label>{$LANG.manageblogpost_disallow_ratings}</p>
		                        <p id="selDisableNote">{$LANG.manageblogpost_disallow_ratings1}</p>
		                        {$myobj->ShowHelpTip('allow_ratings')}
		                    </td>
		                </tr>
		                <tr>
		                    <td>&nbsp;</td><td class="clsFormFieldCellDefault">

		                        {$myobj->populateHidden($myobj->hidden_arr)}
		                        {if !$myobj->chkIsEditMode()}
		                            <input type="submit" class="clsSubmitButton" name="submit" id="submit" tabindex="{smartyTabIndex}" value="{$LANG.manageblogpost_submit_blog_post}"/>
		                        {else}
		                        	{if !$CFG.admin.blog.blog_post_auto_activate && $CFG.admin.blog.allow_edit_blog_post_to_approve && ($myobj->getFormField('status') == 'Ok' || $myobj->getFormField('status') == 'InFuture') && !isAdmin()}
		                            	<input type="button" class="clsSubmitButton" name="update_from" id="update_form" tabindex="{smartyTabIndex}" value="{$LANG.manageblogpost_edit_update}" onclick="checkAdminConfirmation();"  />
		                            	<input type="hidden" name="confirmSubmit" value="yes">
									{else}
		                            	<input type="submit" class="clsSubmitButton" name="update" id="update" tabindex="{smartyTabIndex}" value="{$LANG.manageblogpost_edit_update}" />
		                            {/if}
		                            <input type="submit" class="clsSubmitButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.manageblogpost_cancel}" />
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
                            	Confirmation('selMsgConfirm1', 'blog_post_form', Array('msgConfirmText1'), Array('{/literal}{$LANG.manageblogpost_admin_editing_admin_approval}{literal}'), Array('innerHTML'), -100, -500);

                            }
                            else
                            {
								document.blog_post_form.submit();
							}
						}
		            </script>
		        {/literal}
				 {literal}
					<script type="text/javascript">
					$Jq("#blog_post_form").validate({
						rules: {
						    blog_post_name: {
						    	required: true
							 },
							 blog_tags: {
						    	required: true,
						    	minlength: tag_min,
								maxlength: tag_max
							 },
							 blog_category_id:{
						    	required: true
							 },
							 date_of_publish: {
							    required: true,
							   	chkInValidPreDate: true
							 }
						},
						messages: {
							blog_post_name: {
								required: LANG_JS_err_tip_required
							},
							blog_tags: {
						    	required: LANG_JS_err_tip_required
							 },
							 blog_category_id: {
								required: LANG_JS_err_tip_required
							},
							 date_of_publish: {
						    	required: LANG_JS_err_tip_required,
						    	chkInValidPreDate: LANG_JS_date_valid_format
							 }
						}
					});
		            </script>
		        {/literal}
			</div>
		{/if}
	</div>
	{if $myobj->isShowPageBlock('block_blogposting_paidmembership_upgrade_form')}
		<div>{$myobj->blogposting_upgrade_membership}</div>
	{/if}
</div>
{$myobj->setTemplateFolder('general/','blog')}
{include file="box.tpl" opt="display_bottom"}