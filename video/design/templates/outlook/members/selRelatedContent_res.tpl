{if $myobj->tagRelatedVideo.total_records}
       <form name="selected_video_form1" id="selected_video_form1" action="{$myobj->relatedViewVideoUrl}" method="post" >
        <div id="selVideoDisp">
            <div class="clsOverflow">
				<table>
            <tr>
                <td>
                    <table>
                    {foreach from=$myobj->tagRelatedVideo.display item=result}
                    <tr class="clsVideoSepartor">
                        <td class="clsPopupVideoImage">
                            <p id="selImageBorder">
                            <a href="{$result.videoLink}">
                                <img src="{$result.imageSrc}" alt="{$result.record.video_title|truncate:10}" {$result.disp_image} />
                            </a>
							<span class="clsRunTime">{$result.playing_time}</span>
                            <div class="clsAddQuickVideoImg">
                            </div>
                            </p>
                        </td>
                        <td class="clsPopupVideoImageDetails">
                            <p id="selMemberName">
                                <a href="{$result.videoLink}">{$result.video_title}</a>
                            </p>                            
                            <p>{$LANG.common_from}: {$result.name}</p>
                            <p>{$LANG.views} {$result.record.total_views}</p>
							<div class="clsSelectPreview">
                            
                                <input class="clsVideoPreviewButton" type="submit" name="select_response_video[{$result.record.video_id}]" 
                                id="select_video" value="{$LANG.select_this_video}" />
                            
                                <input class="clsVideoPreviewButton" type="button" 
                                onclick="videoSlideShow_res('{$result.record.video_id}','{$myobj->tagRelatedVideo.pg}')" value="{$LANG.preview_this_video}" />
                            
                            </div>
                        </td>
                    </tr>
                    {/foreach}
                    </table>
                </td>
                <td>
                    <table>
                    <tr>
                        <td class="clsPreviewPopup">
                            <div id="slideShowBlock_{$myobj->tagRelatedVideo.pg}">
                            </div>
                        </td>
                    </tr>
                    </table>
                </td>
            </tr>
            </table>
			</div>
            <div id="selNextPrev" class="clsPopUpPrevNext clsOverflow">
                <input type="button" {if $myobj->tagRelatedVideo.leftButtonExist} onclick="moveVideoSetToLeft_res(this, '{$myobj->tagRelatedVideo.pg}')" {/if}                 value="" id="videoPrevButton_{$myobj->tagRelatedVideo.pg}" class="clsPrevButton {$myobj->tagRelatedVideo.leftButtonClass}"/>
                <input type="button" {if $myobj->tagRelatedVideo.rightButtonExists} onclick="moveVideoSetToRight_res(this, '{$myobj->tagRelatedVideo.pg}')" {/if} value="" 
                id="videoNextButton_{$myobj->tagRelatedVideo.pg}" class="clsNextButton {$myobj->tagRelatedVideo.rightButtonClass}" />
            </div>
        </div>
        </form>
{else}
    <div class="selVideoDisp">
        <div class="clsNoDatas">
                <p>{$LANG.no_related_videos_found}
                </p>
        </div>
    </div>
{/if}