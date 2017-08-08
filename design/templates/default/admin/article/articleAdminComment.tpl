<div id="selArticleCategory" class="clsArticleCategory">
	<h2><span>{$LANG.page_title}</span></h2>
	<div class="clsLeftNavigation" id="selLeftNavigation">

  	{$myobj->setTemplateFolder('admin/')}
  	{include file='information.tpl'}

	{if $myobj->isShowPageBlock('show_admin_comment')}
	        <div id="selMsgConfirmDelete" class="clsPopupConfirmation" style="display:none;">
            	<h3 id="confirmation_msg"></h3>
                <form name="deleteForm" id="deleteForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                    <table summary="{$LANG.tbl_summary}" class="clsFormTableSection">
                        <tr>
                            <td>
                                <input type="submit" class="clsSubmitButton" name="delete_add" id="delete_add" value="{$LANG.act_yes}" tabindex="{smartyTabIndex}" /> &nbsp;
                                <input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="{$LANG.act_no}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks();" />
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
                	<table summary="{$LANG.tbl_summary}" class="clsFormTableSection">
                    	<tr>
                            <th>{$LANG.articleadmincomment_article_title}</th>
                            <th>{$LANG.articleadmincomment_article_owner}</th>
                            <th>{$LANG.articleadmincomment_comment_description}</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr class="{$myobj->getCSSRowClass()}">
                            <td>{$populateArticle_arr.article_title}</td>
                            <td><p class="clsImage"><a href="{$populateArticle_arr.articleOwnerProfileUrl}"><img src="{$populateArticle_arr.profileIcon.t_url}" alt="{$populateArticle_arr.UserDetails}" title="{$populateArticle_arr.UserDetails}" {$myobj->DISP_IMAGE(#image_thumb_width#, #image_thumb_height#, $populateArticle_arr.profileIcon.t_width, $populateArticle_arr.profileIcon.t_height)} /></a></p></td>
                            <td><textarea rows="4" cols="50" id="article_admin_comments" name="article_admin_comments">{$populateArticle_arr.article_admin_comments}</textarea><br/>{$myobj->getFormFieldErrorTip('article_admin_comments')}</td>
                            <td><input type="submit" class="clsSubmitButton" name="updateSubmit" id="updateSubmit" value="{$LANG.submit}" tabindex="{smartyTabIndex}" /></td>
                        </tr>
                    </table>
                </form>
            </div>

		{else}
			<div id="selMsgAlert">
				<p>{$LANG.no_records_found}</p>
			</div>
		{/if}
	</div>
</div>