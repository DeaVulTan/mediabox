<div id="selLeftNavigation">
<div class="clsPlayListHeader">
{$myobj->setTemplateFolder('general/','photo')}
 {include file='box.tpl' opt='popupwithheadingtop_top'}
 <div class="clsOverflow">
	<div class="clsPhotoListHeading"><h3>{$LANG.common_comments}</h3></div>
 </div>
 {$myobj->setTemplateFolder('general/', 'photo')}
 {include file='box.tpl' opt='popupheadingtop_bottom'}

{$myobj->setTemplateFolder('general/','photo')}
   {include file='box.tpl' opt='popupwithheadingbottom_top'}
    <div class="clsOverflow">
   		<div class="clsViewCommentThumb">
        <p class="clsMarginTop14">
        	{if $myobj->block_view_commets.showComments.photo_path == ''}
           	<img  src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImagePhoto_T.jpeg" title="{$myobj->block_view_commets.showComments.photo_title}" alt="{$myobj->block_view_commets.showComments.photo_title}"/>
           {else}
           	<img src="{$myobj->block_view_commets.showComments.photo_path}" {$myobj->block_view_commets.showComments.photo_disp} title="{$myobj->block_view_commets.showComments.photo_title}" alt="{$myobj->block_view_commets.showComments.photo_title}"/>
           {/if}</p>
        </div>
        <div class="clsViewCommentDetails clsMarginTop14">
        <div class="clsMarginBottom5">
    	  <div class="clsPhotoCommentsLeftContent">{$LANG.common_photo_title}</div><div class="clsCommentsColon">:</div><div class="clsPhotoCommentsRightContent">{$myobj->block_view_commets.showComments.photo_title}</div>
        </div>
        <div class="clsMarginBottom5">
         <div class="clsPhotoCommentsLeftContent">{$LANG.common_comments_by}</div><div class="clsCommentsColon">:</div><div class="clsPhotoCommentsRightContent clsPhotoCommentsUserContent">{$myobj->block_view_commets.showComments.comments_by}</div>
        </div>
        <div class="clsMarginBottom5">
         <div class="clsPhotoCommentsLeftContent">{$LANG.common_comment_date}</div><div class="clsCommentsColon">:</div><div class="clsPhotoCommentsRightContent">{$myobj->block_view_commets.showComments.comment_date}</div>
        </div>
       <div class="clsMarginBottom5">
         <div class="clsPhotoCommentsLeftContent">{$LANG.common_comments}</div><div class="clsCommentsColon">:</div><div class="clsPhotoCommentsRightContent">{$myobj->block_view_commets.showComments.comments}</div>
        </div>
        </div>
    </div>
{$myobj->setTemplateFolder('general/', 'photo')}
{include file='box.tpl' opt='popupwithheadingbottom_bottom'}
</div>
</div>