<div id="musicImage" class="clsLyricContainer">
    <div class="clsThumb">
        <div class="clsLargeThumbImageBackground clsNoLink">
          <div class="cls132x88PXthumbImage clsThumbImageOuter" onclick="Redirect2URL('{$musicInfo.viewmusic_url}')">
            <div class="clsrThumbImageMiddle">
              <div class="clsThumbImageInner">
                {if $musicInfo.music_image_src	== ''}
                <img   src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/admin/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg"
				   title="{$musicInfo.music_title}"/>
                {else}
                    <img  src="{$musicInfo.music_image_src}" {$musicInfo.music_disp} title="{$musicInfo.music_title}"/>
                {/if}
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="clsThumbContent">
        <p><strong>{$LANG.common_music_title}:</strong> <a href="{$musicInfo.viewmusic_url}">{$musicInfo.music_title}</a></p>
        <p><strong>{$LANG.common_artist_name}:</strong> {$myobj->getArtistLink($musicInfo.music_artist, true)}</p>
        <p><strong>{$LANG.common_music_owner}:</strong> <a href="{$musicInfo.music_owner_url}">{$musicInfo.user_name}</a></p>
    </div>
</div>