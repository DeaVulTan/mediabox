{if $videoIndexObj->video_list_show}
 {$myobj->setTemplateFolder('general/','video')}
{include file='box.tpl' opt='lastwatchedvideo_top'}
        <div class="clsVideoListContainer">
            <div class="clsRandomVideosTitle">
                <h2>{$LANG.index_title_watched_now_videos_title}</h2>
            </div>
            <div class="clsRandomVideosList">
            	<table>
                  <tr>
                    <td>
                    	<div class="clsRandomVideoInfo">
                    		<div id="flashcontent_youtube"></div>
				       <script type="text/javascript">
					var so1 = new SWFObject("{$videoIndexObj->recentvideo_flv_player_url}", "playList", "640", "110", "5",  null, true);
					so1.addParam("allowSciptAccess", "always");
					so1.addParam("wmode", "transparent");
					so1.addVariable("xmlpath", "{$videoIndexObj->recentvideo_configXmlcode_url}");
					so1.addVariable("listCounts", "{$CFG.admin.videos.recent_videos_play_list_counts}");
					so1.write("flashcontent_youtube");
					</script>
                    	</div>
                    </td>
                  </tr>
                </table>
            </div>
        </div>
 {$myobj->setTemplateFolder('general/','video')}		
{include file='box.tpl' opt='lastwatchedvideo_bottom'}
<!--<script type="text/javascript" language="javascript">
//recentViewedSlideShowRepeat();
</script> -->
{/if}