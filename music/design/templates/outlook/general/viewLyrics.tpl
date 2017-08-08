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
                {$LANG.viewlyrics_title}
                </span></h2>
              </div>
              {if $myobj->flag && !$myobj->chkIsAdminSide()}
                  <div class="clsHeadingRight">
                    <p class="clsHeadingLink"><a href="{$myobj->morelyrics_url}">More lyrics</a></p>
                  </div>
              {/if}
          </div>
    <!-- information div -->
{$myobj->setTemplateFolder('general/','music')}
    	{include file='information.tpl'}
{/if}
	 <!-- view lyrics block -->
    {if $myobj->record_count}
	{if !isAjaxPage()}
      	<!-- music information -->
       	{$myobj->setTemplateFolder('general/','music')}
    		{include file='musicInformation.tpl'}
	{/if}
         {if $myobj->isResultsFound()}
           {if !isAjaxPage()}<div>{/if}
            {if isAjaxPage()}
            	<div class="clsOverflow">
            	<p class="clsLeft">
            	<div class="clsViewTopicLeft">
                    <div class="clsViewTopicRight">
                    	{if isMember()}
                        <a href="{$myobj->getCurrentUrl(true)}" onclick="return populateAddLyrics('{$myobj->addlyrics_light_window_url}');" title="{$LANG.common_music_lyrics_add}">{$LANG.common_music_lyrics_add}</a>
                        {else}
                        <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_comment_lyrics_err_msg}','{$myobj->memberviewMusicUrl}');return false;" title="{$LANG.common_music_lyrics_add}">{$LANG.common_music_lyrics_add}</a>
                        {/if}
                    </div>
                </div>
                 </p>
                {if isMember() && $myobj->chkisMusicOwner()}
                    <p class="clsRight">
					<div class="clsViewTopicLeft">
                    <div class="clsViewTopicRight">
					<a href="{$myobj->managelyrics_url}"  >{$LANG.viewlyrics_manage_lyrics_label}</a>
					</div></div></p>
                {/if}
                </div>

             {/if}
            	<p class="clsLyrics">{if isAjaxPage()}{$myobj->lyric} {else} {$myobj->viewlyricpage}{/if}</p>
                {if isAjaxPage()}
                	<p class="clsOverflow">
                	<p class="clsRight">
					<div class="clsViewTopicLeft">
                    <div class="clsViewTopicRight">
					<a href="{$myobj->morelyrics_url}"  >{$LANG.viewlyrics_more_lyrics_label}</a></p>
					</div></div>
                    </p>
                {/if}
            {if !isAjaxPage()}
                <p class="clsLyricsPostedBy">{$LANG.viewlyrics_Post_by}: <a href="{$myobj->user_url}">{$myobj->user_name}</a></p>
                {if $myobj->chkIsAdminSide()}
               	 <p><input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="{$LANG.viewlyrics_cancel_label}" onclick="Redirect2URL('{$CFG.site.url}admin/music/manageLyrics.php?music_id={$myobj->getFormField('music_id')}')"tabindex="{smartyTabIndex}"></p>
           	    {/if}
                </div>
            {/if}
      	{else}
          <div id="selMsgAlert">{$LANG.viewlyrics_no_record_found}</div>
          {if $myobj->chkIsAdminSide()}
          	<p><input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="{$LANG.viewlyrics_cancel_label}" onclick="Redirect2URL('{$CFG.site.url}admin/music/manageLyrics.php?music_id={$myobj->getFormField('music_id')}')"tabindex="{smartyTabIndex}"></p>
          {/if}
       	{/if}
	  {/if}
{if !isAjaxPage()}
	</div>
{/if}
</div>
{if !isAjaxPage()}
{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_bottom"}
{/if}