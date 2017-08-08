{if $videoIndexObj->getrandomVideo_arr}
{$myobj->setTemplateFolder('general/','video')}
{include file='box.tpl' opt='featuredvideo_top'}
<div class="clsVideoPlayerContainer">
<h2>{$LANG.index_title_featured_videos} - <span id="random_title" title="{$videoIndexObj->randFirstTitle}">{$videoIndexObj->randFirstTitle}</span></h2>
<table>
	<tr>
    	<td class="clsVideoPlayer" id="clsVideoPlayer">
              {$videoIndexObj->populateFeaturedVideoPlayers($videoIndexObj->getFormField('video_id'))}
        </td>
    	<td class="clsVideoPlayerInfo">
		<div class="clsIndexPlayerContent">
			<p class="clsUserSummaryIndex"><span id="video_caption">{$videoIndexObj->randVideoCaption}</span></p>
			<div id="video_url_link" class="clsFloatRight"><a href="{$videoIndexObj->videoUrl}">{$LANG.video_index_page_featured_view_more_link}</a></div>
			<div class="clsUserNamePosted">{$LANG.video_index_random_video_block_added_by_lbl} <span id="user_name"><a href="{$videoIndexObj->randUserNameLink}" title="{$videoIndexObj->randUserName}">{$videoIndexObj->randUserName}</a></span><span class="clsBlackColorStrip">|</span><span class="clsFeaturedMinutes"></span><span id="date_added">{$videoIndexObj->randVideoAdded}</span></div>
		</div>
		<div class="clsIndexPlayerViews">
			<table>
				<tr>
				    <td class="clsWidthTd">{$LANG.video_index_random_video_block_view_lbl}: <span id="views">{$videoIndexObj->randVideoTotalViews}</span></td>
					<td>{$LANG.video_index_random_video_block_comments_lbl}: <span id="total_comments">{$videoIndexObj->randVideoTotalComments}</span></td>
					<td class="clsIndexPlayerRating">{$LANG.video_index_random_video_block_rating_lbl}: <span id="rating_image">{$videoIndexObj->populateRatingImages($videoIndexObj->randVideoRating, 'video', '', '', 'video')}</span>
					(<span id="rating">{$videoIndexObj->randVideoRating}</span>)</td>

				</tr>
			</table>
		</div>
		<h3 class="clsFeaturedViewMore">{$LANG.video_index_random_video_block_more_videos_lbl}</h3>
        <div class="clsListedFeaturedVideo">
        {foreach key=inc item=value from=$videoIndexObj->getrandomVideo_arr}
        	<div id="featured_video_info_{$inc}" class="clsFeaturedVideoInfo{if $inc==0} clsActiveFeaturedVideoInfo{/if}">
            	<div class="">
						<a class="Cls93x70 ClsImageContainer ClsImageBorder5" onClick="toggleFeaturedListClass({$inc});playThisVideo('{$value.member_profile_url}','{$value.video_url}','{$value.record.video_id}','{$value.video_title_full}','{$value.video_date_added}','{$value.rating}','{$value.total_views}','{$value.total_comments}','{$value.user_name}');getMoreInfoBlockList('{$value.video_caption}','{$value.record.video_id}');">
					  <img src="{$value.image_url}" width="93px" height="70px" />
					  </a> </div>
					  <div class="clsTime">{$value.playing_time}</div>

            </div>
        {/foreach}
        </div>
        </td>
    </tr>
</table>
      </div>

  {$myobj->setTemplateFolder('general/','video')}
{include file='box.tpl' opt='featuredvideo_bottom'}
      {literal}
<script type="text/javascript">
var total_featured_vidoes_list = {/literal}{$inc}{literal};
function toggleFeaturedListClass(inc)
    {
          $Jq("#featured_video_info_"+inc).addClass("clsActiveFeaturedVideoInfo");

          for(var i=0;i<=total_featured_vidoes_list;i++)
                {
                      if(i != inc)
                            $Jq("#featured_video_info_"+i).removeClass("clsActiveFeaturedVideoInfo");
                }
    }
</script>
      {/literal}
{/if}


