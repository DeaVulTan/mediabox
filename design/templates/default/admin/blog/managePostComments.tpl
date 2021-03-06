<div id="selPostComments" class="selPostComments">
	<h2><span>{$LANG.managepostcomments_page_title}</span></h2>
	<div class="clsLeftNavigation" id="selLeftNavigation">

  	{$myobj->setTemplateFolder('admin/')}
  	{include file='information.tpl'}

	{if $myobj->isShowPageBlock('comments_list')}
		{if $myobj->isResultsFound()}
	    	{if $CFG.admin.navigation.top}
	        	{$myobj->setTemplateFolder('admin/')}
	            {include file='pagination.tpl'}
	        {/if}

	        <div id="selMsgConfirmDelete" class="clsPopupConfirmation" style="display:none;">
            	<h3 id="confirmation_msg"></h3>
                <form name="deleteForm" id="deleteForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                    <table summary="{$LANG.tbl_summary}" class="clsFormTableSection">
                        <tr>
                            <td>
                                <input type="submit" class="clsSubmitButton" name="delete_add" id="delete_add" value="{$LANG.managepostcomments_act_yes}" tabindex="{smartyTabIndex}" /> &nbsp;
                                <input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="{$LANG.managepostcomments_act_no}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
                                <input type="hidden" name="cid" id="aid" />
                                <input type="hidden" name="act" id="act" />
                                {$myobj->populateHidden($myobj->comments_list.hidden_arr)}
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div>
            	<form name="form_comments_list" id="form_comments_list" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                	<table summary="{$LANG.managepostcomments_tbl_summary}" class="clsFormTableSection">
                    	<tr>
                        	<th><input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CheckAll(document.form_comments_list.name, document.form_comments_list.check_all.name)" tabindex="{smartyTabIndex}" /></th>
                            <th>{$LANG.managepostcomments_commented_user}</th>
                            <th>{$LANG.managepostcomments_comment_description}</th>
                            <th>{$LANG.managepostcomments_date_added}</th>
                            <th>
                                <input type="hidden" name="new_comment" id="new_comment" />
                                <input type="hidden" name="new_cid" id="new_cid" />
                                &nbsp;
                            </th>
                        </tr>
                        {foreach key=pcKey item=pcValue from=$populateComments_arr}
                            <tr class="{$myobj->getCSSRowClass()}">
                                <td><input type="checkbox" class="clsCheckRadio" name="cid[]" value="{$pcValue.record.blog_comment_id}" tabindex="{smartyTabIndex}" /></td>
                                <td><p class="clsImage"><a href="{$pcValue.commentUserProfileUrl}"><img src="{$pcValue.profileIcon.t_url}" alt="{$pcValue.UserDetails}" title="{$pcValue.UserDetails}" {$pcValue.profileIcon} /></a></p></td>
                                <td><textarea rows="4" cols="50" name="commentText_{$pcValue.record.blog_comment_id}">{$pcValue.record.comment}</textarea></td>
                                <td>{$pcValue.record.date_added}</td>
                                <td><input type="submit" class="clsSubmitButton" name="updateSubmit" id="updateSubmit" value="{$LANG.managepostcomments_update}" tabindex="{smartyTabIndex}" onClick="changeSubmitText({$pcValue.record.blog_comment_id})" /></td>
                            </tr>
                        {/foreach}
                        <tr>
                            <td colspan="4">
                                {$myobj->populateHidden($myobj->comments_list.hidden_arr)}
                                <a href="#" id="{$myobj->anchor}"></a>
                                <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.managepostcomments_delete}" onClick="if(getMultiCheckBoxValue('form_comments_list', 'check_all', '{$LANG.managepostcomments_check_atleast_one}')) {literal} { {/literal} Confirmation('selMsgConfirmDelete', 'deleteForm', Array('cid', 'act', 'confirmation_msg'), Array(multiCheckValue, 'delete', '{$LANG.managepostcomments_delete_confirmation|nl2br}'), Array('value', 'value', 'innerHTML'), -100, -500); {literal} } {/literal}" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

            {if $CFG.admin.navigation.bottom}
           	    {$myobj->setTemplateFolder('admin/')}
                {include file='pagination.tpl'}
            {/if}

		{else}
			<div id="selMsgAlert">
				<p>{$LANG.managepostcomments_no_records_found}</p>
			</div>
		{/if}
	{/if}
	</div>
</div>