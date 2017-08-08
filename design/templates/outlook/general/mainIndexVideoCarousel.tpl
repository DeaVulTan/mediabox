
{if $video_block_record_count}
{* Assigned to set num. of records in each row *}
	{assign var=row_count value=4}
	{assign var=break_count value=1}
	{foreach key=upload_videoKey item=value from=$populateCarousalVideoBlock_arr.row}
		<div class="clsCarouselListContent {if $break_count == $row_count} clsNoRightMargin {/if}">
			<div class="clsCarouselListImage">
			 	<div class="clsTime">{$value.playing_time}</div>
                <a onclick="loadThisVideo('{$value.record.video_id}')" href="javascript:void(0)" title="{$value.record.video_title}" class="clsImageContainer clsImageBorder5 cls142x108">
                    <img src="{$value.image_url}" alt="{$value.record.video_title|truncate:12}" title="{$value.record.video_title}" {$mainIndexObj->DISP_IMAGE(140, 106, $value.record.t_width, $value.record.t_height)}/>
                </a>
            </div>
        	<div class="clsCarouselListDetails">
            	<p class="clsTitle"><a href="{$value.video_url}" title={$value.record.video_title}>{$value.record.video_title}</a></p>
            	<p class="clsName">{$LANG.mainIndex_by} <a href="{$value.memberProfileUrl}">{$value.uploaded_by_user_name}</a></p>
            	<p class="clsViews">{$LANG.mainIndex_video_views}: <span>{$value.total_views}</span></p>
        	</div>
    	</div>
       {assign var=break_count value=$break_count+1}
    {/foreach}
{else}
	<div class="clsNoRecordsFound">{$LANG.mainIndex_video_no_record}</div>
{/if}