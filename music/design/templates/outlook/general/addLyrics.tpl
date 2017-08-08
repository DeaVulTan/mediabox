<div id="selLyricsMsgError" class="clsErrorMessage" style="display:none">
</div>
<div id="selLyricsMsgSuccess" class="clsSuccessMessage" style="display:none">
</div>
{if $myobj->getFormField('light_window') == ''}
{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_top"}    
{/if}
<div id="selMusicPlaylistManage" class="clsAudioContentContainer">
	{if $myobj->getFormField('light_window') == ''}
        <!-- heading -->
        <h3 class="clsH3Heading">
            {$LANG.managelyrics_title}
        </h3>
        {/if}    
        <!-- information div -->	
        {$myobj->setTemplateFolder('general/','music')}
        {include file='information.tpl'}


    <!-- Create playlist block -->
    {if $myobj->isShowPageBlock('add_lyrics_block') and isMember()}
  <!-- music information -->
  		{if $myobj->getFormField('light_window') == ''}
            {$myobj->setTemplateFolder('general/','music')}
                {include file='musicInformation.tpl'}
          {/if}  
            <form id="selFormLyrics" name="selFormLyrics" method="post" action="{$myobj->getCurrentUrl(true)}">
			  <table class="clsTable">
                  <tr>
                    <td class="clsLyricLabel"><label for="lyric">{$LANG.managelyrics_lyrics_label}</label></td>
                    <td>
                    	{* if $CFG.feature.html_editor eq 'tinymce'}
    	                    {$myobj->populateHtmlEditor('lyric')}
                        {else *} 
	                    	<textarea name="lyric" id="lyric" cols="60" rows="13"></textarea>
                        {*/if*}
                        {$myobj->getFormFieldErrorTip('lyric')}
                        {$myobj->ShowHelpTip('lyric', 'lyric')}   
                    </td>
                  </tr>
                  <tr>
                    <td><!--&nbsp;--></td>
                    <td>
                    {if $myobj->getFormField('light_window') == ''}
                    	 <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="submit_button" id="submit_button" value="{$LANG.managelyrics_submit}" /></span></p>
                    	{if $myobj->chkIsAdminSide()}
                         	<p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" name="submit_button" id="submit_button" value="{$LANG.managelyrics_cancel}"                       
                        		 onclick="Redirect2URL('{$CFG.site.url}admin/music/manageLyrics.php?music_id={$myobj->getFormField('music_id')}')"tabindex="{smartyTabIndex}"/></span></p>
                         {/if}	
                     {else}
	                     <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" name="submit_button" id="submit_button" value="{$LANG.managelyrics_submit}" 
                         
                         onclick="light_addMusiclyrics('{$CFG.site.url}music/addLyrics.php?ajax_page=true&amp;music_id={$myobj->getFormField('music_id')}&amp;page=addlyrics')"/></span></p>
                    {/if}	
                    <input type="hidden"  name="music_id" id="music_id" value="{$myobj->getFormField('music_id')}" />
                    </td>
                  </tr>
                </table>
			</form>
	{/if}
</div>
{if $myobj->getFormField('light_window') == ''}
{$myobj->setTemplateFolder('general/','music')}
	{include file="box.tpl" opt="audioindex_bottom"}
{/if}