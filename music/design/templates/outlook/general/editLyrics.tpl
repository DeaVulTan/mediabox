{if !isAjaxPage()}
	{$myobj->setTemplateFolder('general/','music')}
	{include file="box.tpl" opt="audioindex_top"}
{/if}
<div class="clsAudioContentContainer">
	{if !isAjaxPage()}
		<div id="selViewLyrics">
		<!-- heading -->
		<div class="clsOverflow">
		<div class="clsHeadingLeft">
		<h2><span>
			{$LANG.managelyrics_edit_title}
		</span></h2>
	</div>
</div>
	<!-- information div -->
        {$myobj->setTemplateFolder('general/','music')}
		{include file='information.tpl'}
	{/if}
	{if $myobj->record_count}
	{if !isAjaxPage()}
	<!-- music information -->
		{$myobj->setTemplateFolder('general/','music')}
	{include file='musicInformation.tpl'}
	{/if}
{if $myobj->isResultsFound()}
{if isAjaxPage()}
	<div class="clsOverflow">
		<p class="clsLeft">
			{if isMember()}
			<a href="javascript:void(0)" onclick="javascript: myLightWindow.activateWindow({literal}{{/literal}type:'external',href:'{$myobj->addlyrics_light_window_url}',title:'{$LANG.viewmusic_add_lyrics}',width:450,height:280{literal}}{/literal});" >{$LANG.common_music_lyrics_add}</a></p>
				{else}
			<a href="{$myobj->memberviewMusicUrl}" title="{$LANG.common_music_lyrics_add}"  >{$LANG.common_music_lyrics_add}</a>
			{/if}
		</p>
		{if isMember() && $myobj->chkisMusicOwner()}
			<p class="clsRight"><a href="{$myobj->managelyrics_url}" title="{$LANG.viewlyrics_manage_lyrics_label}"  >{$LANG.viewlyrics_manage_lyrics_label}</a></p>
		{/if}

		</div>
		{/if}
		<div id="editselMusicPlaylistManage" class="clsAudioContentContainer">
		<div class="clsLyrics">
			<form id="editFormLyrics" name="editFormLyrics" method="post" action="{$myobj->getCurrentUrl(true)}" class="clsDataTable">
				<table class="clsFormTableSection" width="100%" >
				<p class="clsLyricsPostedBy">{$LANG.managelyrics_Post_by}: <a href="{$myobj->user_url}">{$myobj->user_name}</a></p>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('edit_lyrics')}"><label for="edit_lyrics">{$LANG.managelyrics_lyrics_label}</label></td>
					<td class="{$myobj->getCSSFormFieldCellClass('edit_lyrics')}">
					<textarea name="edit_lyrics" id="edit_lyrics" tabindex="{smartyTabIndex}" rows="10" cols="50">{$myobj->showEditLyrics()}</textarea>
                    {$myobj->getFormFieldErrorTip('edit_lyrics')}
					</td>
				</tr>
				<tr>
                	<td>&nbsp;</td>
					<td>
                    <div class="clsSubmitLeft">
                        <div class="clsSubmitRight">
                        	<input type="submit" class="clsSubmitButton" name="edit_submit" id="edit_submit" tabindex="{smartyTabIndex}" value="{$LANG.managelyrics_edit_submit_label}"/>
                        </div>
                    </div>
                    </td>
                    <td>
						<input type="hidden" class="clsSubmitButton" name="music_lyric_id" id="music_lyric_id" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('music_lyric_id')}"/>
                    </td>
				</tr>
				<tr><td class="clsBack"><a href="{$CFG.site.url}music/manageLyrics.php?music_id={$myobj->getFormField('music_id')}" title="{$LANG.managelyrics_edit_back_label}">{$LANG.managelyrics_edit_back_label}</a></td></tr>
				</table>
			</form>
	</div>
{/if}
{/if}
	{if !isAjaxPage()}
		</div>
	{/if}
</div>
{if !isAjaxPage()}
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_bottom"}
{/if}


