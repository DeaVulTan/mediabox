{if $recentVideoIndexObj->video_list_show}
	
  <div id="selRandomVideos">  
	<div id="VideoListContainer">
		<div id="selRandomVideosTitle">
		</div>
		<div id="selRandomVideosList">
			<table class="clsRandomVideos">
				<tr>
                {section name=video_count loop=$CFG.admin.videos.recent_videos_play_list_counts} 			
					<td>
						<div class="clsRandomList">
						<div id="innnerVideoList_{$smarty.section.video_count.iteration}" class="clsRandomInnerList">
						</div>
						</div>
					</td>
                 {/section}
				</tr>
			</table>
		</div>
	</div>
	</div>
{/if}
{if $recentVideoIndexObj->video_list_show}
<script language="javascript" type="text/javascript">
recentViewedSlideShowRepeat();
</script>
{/if}   
