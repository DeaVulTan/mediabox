{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_top"}
<div id="selManageComments">
	<div class="clsAudioIndex"><h3>{$LANG.common_comments}</h3></div>
  
    <div class="clsOverflow">
   		 <div class="clspopViewCommentThumb">
        <p class="ClsImageContainer ClsImageBorder1 Cls144x110">
        	{if $myobj->block_view_commets.showComments.music_path == ''}
           	<img  width="142" src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" title="{$myobj->block_view_commets.showComments.music_title}"/>
           {else}
           	<img  src="{$myobj->block_view_commets.showComments.music_path}" title="{$myobj->block_view_commets.showComments.music_title}"/>
           {/if}</p>	
        </div>
        <div class="clspopViewCommentDetails">
		  <p class="clsManageCommentsTitle"><span>{$LANG.common_music_title}:</span> {$myobj->block_view_commets.showComments.music_title}</p>
        <p><span>{$LANG.common_comments_by}:</span> {$myobj->block_view_commets.showComments.comments_by}</p>
        <p><span>{$LANG.common_comment_date}:</span> {$myobj->block_view_commets.showComments.comment_date}</p>
        <p class="clspopViewCommentDesc"><span>{$LANG.common_comments}:</span> {$myobj->block_view_commets.showComments.comments}</p>
        </div>
    </div>
</div>
{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_bottom"}