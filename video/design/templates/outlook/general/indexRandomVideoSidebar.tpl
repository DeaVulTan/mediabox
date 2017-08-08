<div>
  {if $myobj->getrandomVideo_arr}
               <div class="clsSBFeaturedTitleMiddle"><div class="clsSBFeaturedTitleRight"><div class="clsSBFeaturedTitleLeft"><h2>{$LANG.index_title_featured_videos} - <span id="random_title">{$myobj->randFirstTitle}</span></h2></div></div></div>

                            <div id="video_random_player">                                 
                                {* Video Player Begins *}                                
                                <div id="flashcontent2" class="clsSideVideoPlayer"></div>                            
                                {$myobj->getSideBarFeaturedVideoPlayer($myobj->getFormField('video_id'))}				
                                {* Video Player ends *} 
                                          
                            </div>

                        <div id="featured_videos_list" style="display:none;" class="clsSideFeatureVideoBlock">
                        {foreach key=inc item=value from=$myobj->getrandomVideo_arr}    
                        	 <div class="clsSideFeaturedList">
                            	   <div class="clsSideFeaturedListImage">
                          			<a href="javascript:void(0)" onClick="playThisSideBarVideo('{$value.record.video_id}','{$value.video_title_full}')"><img src="{$value.image_url}" width="68px" height="52px;" /></a>
                               		</div>
                                <div class="clsSideFeaturedListDetails">
                                	<p><a href="javascript:void(0)" onClick="playThisSideBarVideo('{$value.record.video_id}','{$value.video_title_full}')">{$value.video_title}</a></p>
                                    <p>{$value.playing_time}</p>
                                </div>
                            </div>
                        {/foreach}	
                        </div>
                        <div class="clsFeaturedShowHide">
                            <div class="clsShowRight">
                                <div class="clsShowLeft">
                                    <a href="javascript:void(0);" class="clsHide" id="hide_featured_list" style="display:none;">{$LANG.index_hide_more}</a>
                                    <a href="javascript:void(0);" class="clsShow" id="show_featured_list">{$LANG.index_show_more}</a>                              
                                </div>
                            </div>
                        </div>

   {else}
  <h2>{$LANG.index_title_featured_videos}</h2>    
  <p id="random_title">{$myobj->randFirstTitle}</p>
   {/if}
</div>
{literal}
<script type="text/javascript">
$Jq("#hide_featured_list").click(function(){
	$Jq("#featured_videos_list").animate({
      "height": "toggle"
    }, { duration: "slow" });

	$Jq("#hide_featured_list").hide();
	$Jq("#show_featured_list").show();
    });
$Jq("#show_featured_list").click(function(){
	$Jq("#featured_videos_list").animate({
      "height": "toggle"
    }, { duration: "slow" });
	
	$Jq("#show_featured_list").hide();
	$Jq("#hide_featured_list").show();
    });    
</script>
{/literal}