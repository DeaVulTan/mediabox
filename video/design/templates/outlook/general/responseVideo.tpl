{if $responseVideo.total_records}
<div class="clsVideoDetailsList">
	<ul class="clsVideoResponseList">
		{foreach from=$responseVideo.video item=video}
		<li>
        	          <a href="{$video.viewUrl}" class="Cls101x78 ClsImageContainer ClsImageBorder1"><img src="{$video.image}"  alt="{$video.alt_tag|truncate:10}"  {$myobj->DISP_IMAGE(93,70,$video.small_width,$video.small_height)}/></a>                   
        </a>
        <p>{$video.video_title}</p>
		</li>
		{/foreach}
     </ul>
  </div>
  <div class="clsMoreResponse">
  	<div class="clsFloatLeft"></div>
    <div class="clsFloatRight"><a href="{$responseVideo.more_link}">{$LANG.video_response_show_all_resp}</a></div>
</div>
{else}

<div class="selVideoDisp" >
	<div class="clsNoVideo">
	<p>{$LANG.no_related_videos_found}</p>
	</div>
</div>
{/if}