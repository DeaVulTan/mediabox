{if chkAllowedModule(array('video'))}
<div class="clsVideoShelfTable">
 <table {$myobj->defaultTableBgColor}>
        <tr>
          <th colspan="2">
          	 <div class="clsOverflow">
                  <div class="clsProfileVideoBlockTitle">{$myobj->defaultBlockTitle} <span>{$LANG.myprofile_shelf_videos}</span></div>
                  <div class="clsProfileVideoBlockLink">
                        {if $myprofileObj->isEditableLinksAllowed()}  
                            <a class="clsProfileVideoUpload" href="{$myprofileObj->getUrl('videouploadpopup','','','','video')}">{$LANG.viewprofile_link_view_videos_upload}</a>
                        {else}
                            &nbsp;
                        {/if}
                  </div>
              </div>
          </th>
        </tr>
  {if $video_list_arr==0}
        <tr>
          <td colspan="2"><div class="clsProfileTableInfo"><div id="selMsgAlert" class=""><p> {$LANG.viewprofile_videos_no_msg}</p></div></div></td>
        </tr>
  {else}
        <tr>
          <td colspan="2">
              <div class="clsProfileTableInfo">
			  <table class="clsVideoShelf" id="{$CFG.profile_box_id.videos_list}">
                <tr>
                 {foreach key=item item=value from=$video_list_arr}
                <td class="clsVideoBlockDetails"> 
				 <div class="clsOverflow">
                    <div class="clsThumbImageLink">                 
					  <a class="ClsImageContainer ClsImageBorder1 Cls93x70" href="{$value.videoUrl}">
						<img src="{$value.video_path}" title="{$value.video_title}" {$myobj->DISP_IMAGE(93, 70, $value.t_width, $value.t_height)}/>
					  </a>
					 </div>
				 </div>	  
                  <div class="clsProfileVideoTime">{$value.playing_time}</div>
                  <p class="clsProfileVideoTitle"><!--<span>{$LANG.myprofile_featured_videos_title}:</span>&nbsp;--><a href="{$value.videoUrl}" title="{$value.video_title}">{$value.video_wrap_title}</a></p>
                  <div class="clsProfileVideoDes">
                  	<p><span>{$LANG.index_views}:</span>&nbsp;{$value.total_views}</p>
                  </div>
                </td>
                {/foreach}
                </tr>
                </table>
              </div>
		 	</td>
		 </tr>
		  <td colspan="2" class="clsMoreBgVideoCols">
		  <div class="clsVideoViewMoreLink">
				{if $videoDisplayed}
					<a href="{$uservideolistURL}">{$LANG.viewprofile_link_view_videos}</a>
				{/if}
		  </div>
   	</td>
  {/if} {* video_list_arr condition closed *}
</table>
</div>
{/if}