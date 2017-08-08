{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_top"}    
<div id="selMusicPlaylistManage" class="clsAudioContentContainer">
    <!-- heading -->
    <h3 class="clsH3Heading">
    	{$LANG.morelyrics_title}
    </h3>
    <!-- information div -->	
        {$myobj->setTemplateFolder('general/','music')}
    	{include file='information.tpl'}
	
    <!-- Create playlist block -->
    {if $myobj->isShowPageBlock('list_lyrics_block')}
    	<!-- music information -->
    	{$myobj->setTemplateFolder('general/','music')}
    		{include file='musicInformation.tpl'}
         {if $myobj->isResultsFound()}
            {if $CFG.admin.navigation.top}
                   <div class="clsAudioPaging"> 
					{$myobj->setTemplateFolder('general/','music')}
				   {include file=pagination.tpl}
				   </div>
            {/if}   
                <form class="clsDataTable" id="selFormLyrics" name="selFormLyrics" method="post" action="{$myobj->getCurrentUrl(true)}">
                <table width="100%"  >
                <tr>
                
                <th width="35%" align="left" valign="middle">{$LANG.morelyrics_lyrics}</th>
                <th width="25%" align="left" valign="top">{$LANG.morelyrics_Post_by}</th>
                </tr>
                {foreach key=lyricsKey item=lyricsValue from=$myobj->list_lyrics_block.displayLyrics}
                <tr>
                
                <td width="35%" align="left" valign="top"><p title="{$lyricsValue.lyrics}"><a href="{$lyricsValue.viewLyrics_url}" title="{$lyricsValue.lyrics}">{$lyricsValue.lyrics}</a></p></td>
                <td width="25%" align="left" valign="top"><a class="clsUsername" href="{$lyricsValue.lyrics_post_user_url}" title="{$lyricsValue.record.user_name}">{$lyricsValue.record.user_name}</a></td>
                </tr>
                {/foreach}  
                </table>
                </form>
            {if $CFG.admin.navigation.bottom}
                <div id="bottomLinks" class="clsAudioPaging">
					{$myobj->setTemplateFolder('general/','music')}
                    {include file='pagination.tpl'}
                </div>
      	    {/if} 
      	{else}
          <div id="selMsgAlert">{$LANG.morelyrics_no_record_found}</div>
       	{/if}    
	{/if}
</div>
    {$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_bottom"}