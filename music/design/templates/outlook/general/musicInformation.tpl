<div id="musicImage" class="clsLyricContainer">
    <div class="clsThumb">
        <div class="clsLargeThumbImageBackground clsNoLink">
          <a href="{$musicInfo.viewmusic_url}" class="ClsImageContainer ClsImageBorder1 Cls132x88">
                {if $musicInfo.music_image_src	== ''}
                   <img width="132" height="88" src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" title="{$musicInfo.music_title}" alt="{$musicInfo.music_title|truncate:5}"/>
                {else}
                    <img alt="{$musicInfo.music_title}" src="{$musicInfo.music_image_src}" title="{$musicInfo.music_title}" {$myobj->DISP_IMAGE(132, 88, $musicInfo.thumb_width, $musicInfo.thumb_height)}/>
                {/if}
          </a>
        </div>
    </div>
    <div class="clsThumbContent">
        <p class="clsLyricMusicTitle">{$LANG.common_music_title}: <a href="{$musicInfo.viewmusic_url}" title="{$musicInfo.music_title}">{$musicInfo.music_title}</a></p>
        <p>{$LANG.common_music_cast}: {$myobj->getArtistLink($musicInfo.music_artist, true)}</p>
        <p>{$LANG.common_artist_name}: <a href="{$musicInfo.music_owner_url}" title="{$musicInfo.user_name}">{$musicInfo.user_name}</a></p>
    </div>
</div>