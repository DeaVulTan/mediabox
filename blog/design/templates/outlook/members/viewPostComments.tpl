<div class="clsMarginTop75">
{$myobj->setTemplateFolder('general/','blog')}
{include file="box.tpl" opt="blogmain_top"}
<div id="selLeftNavigation">
	<div class="clsPageHeading"><h2>{$LANG.common_comments}</h2></div>
     <p class="clsMarginTop10">
      <span class="clsViewCommentsTitle">{$LANG.common_post_title}:</span>&nbsp; 
      <span class="clsViewCommentsName clsBoldFont">{$myobj->block_view_commets.showComments.blog_post_name}</span>
     </p>
    <div class="clsOverflow">   		 
      <div class="clsViewCommentsTitle">
        <p>{$LANG.common_comments_by}:&nbsp;<span class="clsViewCommentsAdded clsBoldFont">{$myobj->block_view_commets.showComments.comments_by}</span></p>
        <p>{$LANG.common_comment_date}:<span class="clsViewCommentsDate">{$myobj->block_view_commets.showComments.comment_date}</span></p>
        <p>{$LANG.common_comments}:&nbsp;<span class="clsViewCommentsContent">{$myobj->block_view_commets.showComments.comments}</span></p>
      </div>
    </div>
</div>
{$myobj->setTemplateFolder('general/','blog')}
{include file="box.tpl" opt="blogmain_bottom"}
</div>