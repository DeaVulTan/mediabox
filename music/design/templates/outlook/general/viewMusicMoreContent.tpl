<div class="clsSideCaroselContainer clsOverflow">
    {if $myobj->total_records}
        {foreach from=$relatedMusic item=result}
            <div class="clsViewPageSideContainer">
                <div class="clsViewPageSideImage">
                    <div class="clsThumbImageLink clsThumbImageBackground">
                        <a href="{$result.music_url}" class="ClsImageContainer ClsImageBorder1 Cls144x110">
							{if $result.record.music_thumb_ext}
								<img src="{$result.music_image_src}" title="{$result.record.music_title}" alt="{$result.record.music_title|truncate:5}" {$myobj->DISP_IMAGE(#image_music_thumb_width#, #image_music_thumb_height#, $result.record.thumb_width, $result.record.thumb_height)} />
							{else}
								<img  src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" title="{$result.record.music_title}" alt="{$result.record.music_title|truncate:5}"/>
							{/if}    
                        </a>
                    </div>
                    <div class="clsTime">{$result.playing_time}</div>
					
					 <div class="clsViewPageSideContent">
                    <p class="clsName"><a href="{$result.music_url}" title="{$result.record.music_title}">{$result.record.music_title}</a></p>
                </div>
                </div>
               
            </div>
        {/foreach}
         <div id="selNextPrev" style="display:none">
            <input type="button" href="javascript:void(0);" title="{$LANG.common_previous}" {if $myobj->leftButtonExist} onclick="moveMusicSetToLeft(this, '{$myobj->pg}')" {/if} value="" id="musicPrevButton_{$myobj->pg}" class="{$myobj->leftButtonClass}" />
            <input type="button" href="javascript:void(0);" title="{$LANG.common_next}" {if $myobj->rightButtonExists} onclick="moveMusicSetToRight(this, '{$myobj->pg}')"{/if} value="" id="musicNextButton_{$myobj->pg}" class="{$myobj->rightButtonClass}" />
        </div>
    {else}
    	<div id="selNextPrev" style="display:none">
        </div>
        <div class="clsNoRecordsFound">{$LANG.viewmusic_no_related_musics_found}</div>
    {/if}
</div>