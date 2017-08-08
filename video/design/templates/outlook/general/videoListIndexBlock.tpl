<div class="clsInfoPopUpContainerDiv clsDisplayNone"  onmouseover="hideCurrentToolTip()">
</div>
<div class="clsInfoPopUp clsDisplayNone"  style="position:absolute;z-index:100000">

</div>
{if !isAjaxPage()}
	<div id="selProcess"></div>
    <p class="clsPageNo" id="selPageNo"></p>
    {*assign var = height value=160*}
    {*assign var = cur_row value=$myobj->no_of_row-1*}
    {*assign var = incheight value=$cur_row*150*}
    {*assign var = heightRow value=$height+$incheight*}
	<div  style="position:relative;margin-left:7px; width:645px;height:px;overflow-x:hidden;">
		<div class="clsVideoListCount" style="position:absolute;left:0px;top:0px;">
{/if}
{if $video_block_record_count}
<div class="ClsMusicListCarouselContainer">
    <div class="ClsMusicListCarousel">
<table class="clsCarouselList">

	{* Assigned to set num. of records in each row *}
	{assign var=row_count value=4}
	{assign var=break_count value=1}
	{foreach key=inc item=value from=$populateCarousalVideoBlock_arr.row}
    {if $break_count == 1}
    <tr>
    {/if}
    <td >

    <ul class="cls141x106PXThumbImage">
          <li id="videolist_videoli_{$block_type}{$record_count}{$inc}" class="clsVideoListDisplayVideos">
     <div class="clsIndexVideoContent">
            <div class="clsListVideoThumbImage" id="videolist_video_thumb_image_{$block_type}{$record_count}{$inc}" >
                <div class="clsListThumbImageContainer" id="videolist_thumb_image_container_{$block_type}{$record_count}{$inc}">
                    <div class="clsThumbImageContainer">
                        <div>
                            <div onclick="Redirect2URL('{$value.video_url}')" class="clsPointer">
                                <span class="clsRunTime">{$value.playing_time}</span>
                                <div id="videolist_thumb_{$block_type}{$record_count}{$inc}" class="Cls142x108 ClsImageBorder1 ClsImageContainer" {$value.div_onmouseOverText} >
                                          <img src="{$value.image_url}" {$value.div_onmouseOverText} {$videoIndexObj->DISP_IMAGE(142, 108, $value.record.t_width, $value.record.t_height)} />

                                </div>
                             </div>
                        </div>
                        <a href="javascript:void(0)" class="clsInfo clsDisplayNone" id="videolist_info_{$block_type}{$record_count}{$inc}" onmouseover="show_thumb=true;this.className='clsDisplayNone';showVideoDetail(this)" title="{$value.user_name}"></a>
                        <!--<a href="javascript:void(0)" class="clsInfo_home clsDisplayNone"  onmouseover="show_thumb=true;this.className='clsDisplayNone';showVideoDetail(this)"></a> -->
                    </div>
                </div>

                    <div class="clsVideoDetailsInfo" id="videolist_selVideoDetails_{$block_type}{$record_count}{$inc}" onmouseover="show_thumb=true;showVideoDetail(this)" onmouseout="show_thumb=false;hideVideoDetail(this)">
                        <div class="clsVideoDetailsInfoCont">
                           <div class=" clsVideoBackgroundInfo">
                        <a href="javascript:void(0)" id="clsInfo" class="clsInfo_inside" style="display:none"></a>
                       <div>
 
                      <p>{$LANG.index_views}:&nbsp;<span>{$value.total_views}</span></p>
                      <p>{$LANG.index_added}:&nbsp;<span>{$value.video_date_added}</span></p>
                       <p>{$videoIndexObj->populateRatingImages($value.rating, 'video')}</p>                
                   </div>
              </div>
            </div>
			</div>
			</div>
            <div class="clsThumbImageTitle" >
                <pre><a href="{$value.video_url}" title="{$value.record.video_title}">{$value.record.video_title}</a></pre>
				<p class="clsUserNameDetails">{$LANG.index_by}:&nbsp;<a href="{$value.user_url}" title="{$value.user_name}">{$value.user_name}</a></p>
            </div>
			</div>
               </li>
           </ul>
    </td>
    {assign var=break_count value=$break_count+1}
    {if $break_count > $row_count}
    </tr>
    {assign var=break_count value=1}
    {/if}
    {/foreach}
    {if $break_count != 1}
    {* Added to display empty row if last row records < row_count *}
    <td colspan="{math equation=($row_count+1)-$break_count}">&nbsp;</td>
    </tr>
    {/if}
  </table>
    </div>

</div>
{/if}
{if !isAjaxPage()}
</div>
</div>
{/if}