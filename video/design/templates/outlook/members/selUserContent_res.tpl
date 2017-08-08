{if $myobj->userRelatedVideo.total_records}
    <form name="selected_video_form1" id="selected_video_form1" action="{$myobj->relatedViewVideoUrl}" method="post" >
        <div id="selVideoDisp">
            <table>
            <tr>
                <td>
                    <table>
                    {foreach from=$myobj->userRelatedVideo.display item=result}
                    <tr class="clsVideoSepartor">
                        <td class="clsPopupVideoImage">
                            <p id="selImageBorder">
                            <a href="{$result.videoLink}">
                                <img src="{$result.imageSrc}" alt="{$result.record.video_title|truncate:10}" {$result.disp_image} />
                            </a>
                            <div class="clsAddQuickVideoImg">
                            </div>
                            </p>
                        </td>
                        <td class="clsPopupVideoImageDetails">
                            <p id="selMemberName">
                                <a href="{$result.videoLink}">{$result.video_title}</a>
                            </p>
                            <p>{$result.playing_time}</p>
                            <p>{$LANG.views} {$result.record.total_views}</p>
                        </td>
                        <td>
                            <div class="clsSelectPreview">
                            <p>
                                <input class="clsVideoPreviewButton" type="submit" name="select_response_video[{$result.record.video_id}]" 
                                id="select_video" value="{$LANG.select_this_video}" />
                            </p>
                            <p>
                                <input class="clsVideoPreviewButton" type="button" 
                                onclick="videoSlideShow_res('{$result.record.video_id}','{$myobj->userRelatedVideo.pg}')" value="{$LANG.preview_this_video}" />
                            </p>
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
                            <div id="slideShowBlock_{$myobj->userRelatedVideo.pg}"></div>
                        </td>
                    </tr>
                    </table>
                </td>
            </tr>
            </table>
        
            <div id="selNextPrev" class="clsPopUpPrevNext">
            <input type="button" {if $myobj->userRelatedVideo.leftButtonExist} onclick="moveVideoSetToLeft_res(this, '{$myobj->userRelatedVideo.pg}')" 				
            {/if} value="" id="videoPrevButton_{$myobj->userRelatedVideo.pg}" class="clsPrevButton {$myobj->userRelatedVideo.leftButtonClass}"/>
            <input type="button" {if $myobj->userRelatedVideo.rightButtonExists} onclick="moveVideoSetToRight_res(this, '{$myobj->userRelatedVideo.pg}')" 
            {/if} value="" id="videoNextButton_{$myobj->userRelatedVideo.pg}" class="clsNextButton {$myobj->userRelatedVideo.rightButtonClass}" />
        </div>
        </div>
    </form>
{else}
    <div class="selVideoDisp">
    <div class="clsNoDatas">
            <p>
            	{$LANG.no_related_videos_found}
            </p>
    </div>
    </div>
{/if}