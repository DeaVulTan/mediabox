<div id="selManageComments">
    <div class="clsPageHeading">
        <h2><span>{$LANG.common_comments}</span></h2>
    </div>
    <div class="clsOverflow clsCommentsFancyInner">
   		 <div class="clsViewCommentThumb">
        <p>{if $myobj->announcement_list.showComments.img_src == ''}
           	<img  src="{$CFG.site.url}video/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImagePhoto_T.jpeg" title="{$myobj->block_view_commets.showComments.photo_title}"/>
           {else}
        <img src="{$myobj->announcement_list.showComments.img_src}" />{/if}</p>
        </div>
        <div class="clsViewCommentDetails clsViewPopUpCommentDetails">
   		<p><strong>{$LANG.common_video_title}</strong>: {$myobj->announcement_list.showComments.video_title}</p>
        <p><strong>{$LANG.common_comments_by}:</strong> {$myobj->announcement_list.showComments.comments_by}</p>
        <p><strong>{$LANG.common_comment_date}:</strong> {$myobj->announcement_list.showComments.comment_date}</p>
        <p><strong>{$LANG.common_comments}:</strong> {$myobj->announcement_list.showComments.comments}</p>
        </div>
    </div>
</div>
