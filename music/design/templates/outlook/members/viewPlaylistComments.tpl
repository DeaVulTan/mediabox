{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_top"}
<div id="selManageComments">
	<div class="clsAudioIndex">
	<h3>{$LANG.common_comments}</h3>
	</div>
   
    <div class="clsOverflow">
		<div class="clspopViewCommentThumb">
			 <div class="clsMultipleImage clsPopupInformationLeft" title="{$myobj->block_view_commets.showComments.playlist_name}">
							{if $myobj->block_view_commets.showComments.getPlaylistImageDetail.total_record gt 0}
								{foreach key=playlistImageDetailKey item=playlistImageDetailValue from=$myobj->block_view_commets.showComments.getPlaylistImageDetail.row}
								   <table><tr><td><img src="{$playlistImageDetailValue.playlist_path}"/></td></tr></table>
								{/foreach}
								{if $myobj->block_view_commets.showComments.getPlaylistImageDetail.total_record lt 4}
									{section name=foo start=0 loop=$myobj->block_view_commets.showComments.getPlaylistImageDetail.noimageCount step=1}
										<table><tr><td><img  width="65" height="44" src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_S.jpg" /></td></tr></table>
									{/section}	
								{/if}
							{else}    
								<div class="clsSingleImage"><img src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" /></div>
							{/if}    
					</div>
		</div>
        <div class="clspopViewCommentDetails">
		 <p class="clsManageCommentsTitle"><span>{$LANG.common_playlist_title}:</span> {$myobj->block_view_commets.showComments.playlist_name}</p>
        <p><span>{$LANG.common_comments_by}:</span> {$myobj->block_view_commets.showComments.comments_by}</p>
        <p><span>{$LANG.common_comment_date}:</span> {$myobj->block_view_commets.showComments.comment_date}</p>
        <p class="clspopViewCommentDesc"><span>{$LANG.common_comments}:</span> {$myobj->block_view_commets.showComments.comments}</p>
        </div>
    </div>
</div>
{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_bottom"}