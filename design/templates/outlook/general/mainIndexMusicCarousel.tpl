{if $music_block_record_count}

{* Assigned to set num. of records in each row *}
{assign var=row_count value=4}

{* Assigned to find last record of each row *}
{assign var=break_count value=1}

{foreach key=upload_musicKey item=upload_musicValue from=$populateCarousalMusicBlock_arr.row}
<div class="clsCarouselListContent {if $break_count == $row_count}clsNoRightMargin{/if}">
	<div class="clsCarouselListImage">
    	<div class="clsTime">{$upload_musicValue.playing_time}</div>
        <a href="javascript:void(0);" onclick="loadThisMusic('{$upload_musicValue.record.music_id}');return false;" class="clsImageContainer clsImageBorder6 cls142x108">
            {if $upload_musicValue.music_image_src != ''}
            <img  src="{$upload_musicValue.music_image_src}" alt="{$upload_musicValue.record.music_title|truncate:12}" title="{$upload_musicValue.record.music_title}" {$mainIndexObj->DISP_IMAGE(140, 106, $upload_musicValue.record.thumb_width, $upload_musicValue.record.thumb_height)}/>
            {else}
            <img  src="{$mainIndexObj->CFG.site.url}music/design/templates/{$mainIndexObj->CFG.html.template.default}/root/images/{$mainIndexObj->CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" alt="{$upload_musicValue.record.music_title|truncate:12}" title="{$upload_musicValue.record.music_title}"/>
            {/if}
        </a>
    </div>
    <div class="clsCarouselListDetails">
        <p class="clsTitle"><a href="{$upload_musicValue.viewmusic_url}" title="{$upload_musicValue.record.music_title}">{$upload_musicValue.record.music_title}</a></p>
        <p class="clsName">{$LANG.mainIndex_by} <a href="{$upload_musicValue.memberprofile_url}" title="{$upload_musicValue.record.user_name}">{$upload_musicValue.record.user_name}</a></p>
        <p class="clsViews">{$LANG.mainIndex_music_plays}: <span>{$upload_musicValue.record.total_plays}</span></p>
    </div>
</div>
{assign var=break_count value=$break_count+1}
{/foreach}

{else}
<div class="clsNoRecordsFound">{$LANG.mainIndex_music_no_record}</div>
{/if}