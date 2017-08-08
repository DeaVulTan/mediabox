<div id="selVideoList">
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
      <div id="selVideoTitle">
                 <div class="clsPageHeading">
           			 <h2>{$LANG.videolist_playilst|capitalize:true}</h2>
        		</div>
      </div>
        {if $myobj->isResultsFound()}
        <div id="selVideoListDisplay" class="clsLeftSideDisplayTable" style="clear:left">
            <div id="topLinks">
            {if $CFG.admin.navigation.top}
                {$myobj->setTemplateFolder('general/')}
                {include file=pagination.tpl}
            {/if}
            </div>
            <div>
            <ul class="clsViewPlaylist">
            {assign var=count value=0}
            {foreach from=$myobj->showPlaylist.record item=playlist key=index name=videoplaylist}
            <li>
            	<div class="clsOverflow">
                <div class="clsViewPlaylistLeft">
                        <div class="clsThumbImageLink">
                            <a href="{$playlist.url}" class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                            <img border="0" src="{$playlist.imageSrc}"  {$myobj->DISP_IMAGE(142, 108, $playlist.t_width, $playlist.t_height)} />
                            </a>
                        </div>
                            {*<div>{$LANG.videolist_play}</div>*}
                </div>
                <div class="clsViewPlaylistMiddle">
                            <p class="clsViewPlaylistTitle"><a href="{$playlist.url}">{$playlist.playlist_name}</a><span>({$playlist.total_videos} videos)</span>
                            </p>
                            <p>{$LANG.videolist_by} <a href="{$myobj->memberProfileUrl[$playlist.user_id]}">{$myobj->getUserDetail('user_id',$playlist.user_id, 'user_name')}</a></p>
                            <p>{$playlist.date_added}</p>
                            <p><label>{$LANG.videolist_caption}</label>{$playlist.playlist_description}</p>
                        	<p><label>{$LANG.videolist_tags}</label>
                        {foreach from=$playlist.playlist_tags item=tag}
                            <a href="{$tag.tag_url}">{$tag.tag}</a>
                        {/foreach}</p>
                </div>
                <div class="clsViewPlaylistRight">
                            <p class="clsPlayThisVideo">{$myobj->getNextPlayListLinks($playlist.playlist_id)}</p>
                </div>
               {*<!-- <td style="width:20%">
                    <ul>
                        <li>Views: {$playlist.total_views}</li>
                        {if $playlist.last_played}
                        <li>Last Played: {$playlist.last_played}</li>
                        {/if}
                        {assign var=your_rank value=false}
                        <li>{$myobj->populateRatingImages($playlist.rating)}</li>
                    </ul>
                </td>-->*}
                </div>
             </li>
             {/foreach}
            </div>
             </div>
        </div>
        {if $CFG.admin.navigation.bottom}
        <div id="bottomLinks">
              {include file='pagination.tpl'}
         </div>
        {/if}
        {else}
        <div id="selMsgAlert">
            <p>{$LANG.videolist_no_records_found}</p>
        </div>
        {/if}
{include file='box.tpl' opt='display_bottom'}
</div>

