<div class="clsSideCaroselContainer clsOverflow">

    {* ------content starts----- *}
    {if $myobj->listened_total_records}
        {foreach from=$peopleListened item=result}
           <div class="clsViewPageSideContainer clsOverflow">
                   <div class="clsViewPageSideImageListening">
                      <div class="clsThumbImageLink clsThumbImageBackground">
                          <a href="{$result.music_url}" class="ClsImageContainer ClsImageBorder1 Cls106x82">
							  {if $result.record.music_thumb_ext}
								  <img src="{$result.music_image_src}" title="{$result.record.music_title}" alt="{$result.record.music_title|truncate:5}" {$myobj->DISP_IMAGE(104, 80, $result.record.thumb_width, $result.record.thumb_height)}/>
							  {else}
								  <img  src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_M.jpg" title="{$result.record.music_title}" alt="{$result.record.music_title|truncate:5}"/>
							  {/if} 
                          </a>
                      </div>
                      <div class="clsTime"><!---->{$result.playing_time}</div>
                  </div>
                  <div class="clsViewPageSideContent clsFloatLeft clspepolListenRight">
                      <p class="clsName"><a href="{$result.music_url}">{$result.record.music_title}</a></p>
                      <p class="clsListenLbum"><span>{$LANG.viewmusic_album_title}: </span><a href="{$result.viewalbum_url}">{$result.album_title}</a></p>
					  <p class="clsListenGenres"><span>{$LANG.music_genre_in}</span><a href="{$result.musiccategory_url}">{$result.music_category_name}</a></p>
                      <p class="clsListenPlayscount">{$LANG.viewmusic_plays_label}: <span>{$result.record.total_plays}</span></p>
                  </div>
		</div>
         {/foreach}
         <input type="hidden" name="listenedstart" id="listenedstart" value="{$myobj->getFormField('listenedstart')}" />
     {else}
     	<div class="clsNoRecordsFound" >{$LANG.viewmusic_no_related_musics_found}</div>
     {/if}
</div>     
    {* ------content ends----- *}
<div id="people_listened_Paging" class="clsAudioCarouselPaging"  style="display:none" >
	{if $myobj->listened_total_records} 
      <ul>
        <li><a  id="Previous" class="{$myobj->activeClsPrevious}" {if $myobj->isPreviousButton} onclick="getPeopleListenedMusic('Previous')" {/if} href="javascript:void(0);">{$LANG.viewmusic_previous_label}</a></li>
        <li><a  id="Next" class="{$myobj->activeClsNext}" {if $myobj->isNextButton} onclick="getPeopleListenedMusic('Next')" {/if} href="javascript:void(0);">{$LANG.viewmusic_next_label}</a></li>
      </ul>
  {/if}
</div>