<div id="selPostCategory" class="clsPostCategory">
	<h2><span>{$LANG.postadmincomment_page_title}</span></h2>
	<div class="clsLeftNavigation" id="selLeftNavigation">

  	{$myobj->setTemplateFolder('admin/')}
  	{include file='information.tpl'}

	{if $myobj->isShowPageBlock('show_admin_comment')}
	        <div id="selMsgConfirmDelete" class="clsPopupConfirmation" style="display:none;">
            	<h3 id="confirmation_msg"></h3>
                <form name="deleteForm" id="deleteForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                    <table summary="{$LANG.postadmincomment_tbl_summary}" class="clsFormTableSection">
                        <tr>
                            <td>
                                <input type="submit" class="clsSubmitButton" name="delete_add" id="delete_add" value="{$LANG.postadmincomment_act_yes}" tabindex="{smartyTabIndex}" /> &nbsp;
                                <input type="button" class="clsCancelButton" name="cancel" id="cancel" value="{$LANG.postadmincomment_act_no}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks();" />
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
                	<table summary="{$LANG.postadmincomment_tbl_summary}" class="clsFormTableSection">
                    	<tr>
                            <th>{$LANG.postadmincomment_post_title}</th>
                            <th>{$LANG.postadmincommentt_post_owner}</th>
                            <th>{$LANG.postadmincomment_comment_description}</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr class="{$myobj->getCSSRowClass()}">
                            <td>{$populatePost_arr.blog_post_name}</td>
                            <td><p class="clsImage"><a href="{$populatePost_arr.postOwnerProfileUrl}"><img src="{$populatePost_arr.profileIcon.t_url}" alt="{$populatePost_arr.UserDetails}" title="{$populatePost_arr.UserDetails}" {$populatePost_arr.profileIcon} /></a></p></td>
                            <td><textarea rows="4" cols="50" id="blog_admin_comments" name="blog_admin_comments">{$populatePost_arr.blog_admin_comments}</textarea><br/>{$myobj->getFormFieldErrorTip('blog_admin_comments')}</td>
                            <td><input type="submit" class="clsSubmitButton" name="updateSubmit" id="updateSubmit" value="{$LANG.postadmincomment_update}" tabindex="{smartyTabIndex}" /></td>
                        </tr>
                    </table>
                </form>
            </div>

		{else}
			<div id="selMsgAlert">
				<p>{$LANG.postadmincomment_no_records_found}</p>
			</div>
		{/if}
	</div>
</div>