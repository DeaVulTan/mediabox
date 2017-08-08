<div id="video_random_player">
    {* Video Player Begins *}
	{if $videoIndexObj->checkEmbedPlayer($videoIndexObj->getFormField('video_id'))}
	<div id="flashcontent3" class="clsVideoPlayerBorder">
    	{$videoIndexObj->displayEmbededVideo($videoIndexObj->video_external_embed_code)}
	</div>
	{else}
    <div id="flashcontent2" class="clsVideoPlayerBorder"></div>
		{$videoIndexObj->getPlayer($videoIndexObj->getFormField('video_id'))}
    {/if}
    {* Video Player ends *}
</div>