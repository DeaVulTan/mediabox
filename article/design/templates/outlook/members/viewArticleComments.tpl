<div class="clsCommentsPopup">
{*{$myobj->setTemplateFolder('general/','article')}
{include file="box.tpl" opt="display_top"}*}
<div id="selLeftNavigation">
	<div class="selLeftNavigation">
	<div class="clsPageHeading"><h2>{$LANG.common_comments}</h2></div>
    <div class="clsOverflow">
        <div class="clsViewCommentDetails">
   		 <p class="clsManageCommentsTitle">{$LANG.common_article_title}: <span>{$myobj->block_view_commets.showComments.article_title}</span></p>
        <p>{$LANG.common_comments_by}:<span class="clsAddedBy"> {$myobj->block_view_commets.showComments.comments_by}</span></p>
        <p>{$LANG.common_comment_date}:<span> {$myobj->block_view_commets.showComments.comment_date}</span></p>
        <p>{$LANG.common_comments}:<span> {$myobj->block_view_commets.showComments.comments}</span></p>
        </div>
    </div>
</div></div>
{*{$myobj->setTemplateFolder('general/','article')}
{include file="box.tpl" opt="display_bottom"}*}
</div>
