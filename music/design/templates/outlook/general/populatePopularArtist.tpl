{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="sidebar_top"}
    <div class="clsAudioIndex clsIndexPopularArtist">
        <h3>{$LANG.sidebar_popular_artist_label}</h3>
        {if $populatePopularArtist_arr.record_count}
		<div class="clsOverflow clsPopularArtistInnerpad">
           {foreach item=artistValue from=$populatePopularArtist_arr.row }
                <div class="clsAudioMemberContainer">
                    <div class="clsAudioMemberThumb">
                        <div class="clsThumbImageLink">
                            <a href="{$artistValue.viewartist_url}" class="ClsImageContainer ClsImageBorder1 Cls45x45">
									{if $artistValue.music_path != ''}
										<img src="{$artistValue.music_path}" title="{$artistValue.record.artist_name}" alt="{$artistValue.record.artist_name}" {$myobj->DISP_IMAGE(#music_index_activity_thumb_width#, #music_index_activity_thumb_width#, $artistValue.mini_width, $artistValue.mini_height)} />
									{else}
										<img  src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_artist_M.jpg" title="{$artistValue.record.artist_name}" alt="{$artistValue.record.artist_name}"/>
									{/if}
                            </a>
                        </div>
                    </div>
                <div class="clsAudioMemberDetails">
                    <p class="clsName"><a href="{$artistValue.viewartist_url}" title="{$artistValue.record.artist_name}">{$artistValue.record.artist_name}</a></p>
                    {if $artistValue.record.total_songs !='0'}
					<p>{if $artistValue.record.total_songs=='1'} {$LANG.sidebar_popular_artist_song_label}: {else} {$LANG.sidebar_popular_artist_songs_label}: {/if}<span><a href="{$artistValue.viewartist_url}">{$artistValue.record.total_songs}</a></span></p>
					{/if}
					{if $artistValue.record.sum_plays!='0'}
                    <p>{if $artistValue.record.sum_plays=='1'} {$LANG.sidebar_popular_artist_play_label}: {else} {$LANG.sidebar_popular_artist_plays_label}: {/if}{$artistValue.record.sum_plays}</p>
					{/if}
                </div>
                </div>
            {/foreach}
		</div>
            <!-- by Abror Ahmedov 22.06.2012
            <p class="clsViewMore"><a href="{$moreartist_url}" title="{$LANG.sidebar_viewall_label}">{$LANG.sidebar_viewall_label}</a></p>
            -->
         {else}
         	<div class="clsNoRecordsFound">{$LANG.sidebar_no_popular_artist_found_error_msg}</div>
         {/if}
    </div>
	
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="sidebar_bottom"}