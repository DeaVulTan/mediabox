{if chkAllowedModule(array('video'))}
{if $isFeaturedvideo}
<div class="clsFeaturedVideoBlockTable">
<div class="clsFeaturedVideoBlock">
<div class="clsFeaturedVideoBlock" id="{$CFG.profile_box_id.featuredvideo_list}">
	<div class="clsFeaturedVideoPlayer">
			<div id="flashcontent2" class="clsVideoPlayerBorder">
			{if $featured_video_list_arr.is_external_embed_video=="Yes"}
				{$featured_video_list_arr.video_external_embed_code}
			{/if}
			 </div>
			{if $featured_video_list_arr.is_external_embed_video=="Yes"}
			<script type="text/javascript">
			var playerActualHeight ={$CFG.profile.featured_video_player_minimum_height};
			var playerActualWidth={$CFG.profile.featured_video_player_minimum_width};
			{literal}
	function chkValidHeightAndWidth(ele)
		{

			flash_content_div_width = $Jq('#flashcontent2').css('width');
			flash_content_div_height = $Jq('#flashcontent2').css('height');

			height=parseInt($Jq(ele).css('height'));
			width=parseInt($Jq(ele).css('width'));
			if((height>playerActualHeight || width >playerActualWidth))
				{
					$Jq(ele).css('height', playerActualHeight);
					$Jq(ele).css('width', playerActualWidth);
				}
		}
	function chkExtenalEmbededHeightAndWidth()
	  {
		var embeded_ele=$Jq('#flashcontent2 embed').length;
		if(embeded_ele)
			{
				$Jq('#flashcontent2 embed').each(function(ele)
					{
					   	chkValidHeightAndWidth($Jq(this));
					});
			}


		object_ele=$Jq('#flashcontent2 object').length;
		if(object_ele)
			{

				$Jq('#flashcontent2 object').each(function(ele)
					{
					   	chkValidHeightAndWidth($Jq(this));
					});

			}
	  }

							var user_agent = navigator.userAgent.toLowerCase();
							if(user_agent.indexOf("msie") != -1)
								{
									// FIX for IE 6 since sometimes dom:loaded not working
									$Jq(window).load(function(){
										chkExtenalEmbededHeightAndWidth();
									});
								}
							else
								{
									$Jq(document).ready( function(){
										chkExtenalEmbededHeightAndWidth();
									});
								}
								{/literal}
							</script>

			{else}
			{* Video Player Begins *}
			<script type="text/javascript" src="{$CFG.site.url}js/swfobject.js"></script>
			<script type="text/javascript">
			var so1 = new SWFObject("{$flv_player_url}", "flvplayer", "{$CFG.profile.featured_video_player_minimum_width}", "{$CFG.profile.featured_video_player_minimum_height}", "7",  null, true);
			so1.addParam("allowFullScreen", "true");
			so1.addParam("wmode", "transparent");
			so1.addParam("autoplay", "false");
			so1.addParam("allowSciptAccess", "always");
			so1.addVariable("config", "{$configXmlUrl}");
			so1.write("flashcontent2");

		   </script>
			{* Video Player ends *}
			{/if}

	</div>
		<div class="clsFeaturedVideoBlockDetails">
			<p>{$LANG.myprofile_featured_videos_title}:&nbsp;<span class="clsBold clsNoSeparator">
			   <a href="{$featured_video_list_arr.videoUrl}">{$featured_video_list_arr.video_title}</a></span>
			</p>
			<p>{$LANG.index_playing_time}:<span>{$featured_video_list_arr.playing_time}</span>
			   {$LANG.index_added}:<span>{$featured_video_list_arr.video_date_added}</span>
			   {$LANG.index_views}:<span class="clsNoSeparator">{$featured_video_list_arr.total_views}</span>
			</p>
		</div>
	</div>
 </div>
{else}
		<div class="clsOverflow">
		<div class="clsNoRecordsFound">{$LANG.myprofile_featuredvideo_no_records}</div>
	  </div>
{/if}
{/if}