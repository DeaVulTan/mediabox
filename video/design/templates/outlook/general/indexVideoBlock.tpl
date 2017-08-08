{if chkAllowedModule(array('video'))}
	{if $CFG.admin.videos.recentlyviewedvideo or $CFG.admin.videos.recommendedvideo
		   or $CFG.admin.videos.newvideo or $CFG.admin.videos.topratedvideo}
		   <script language="javascript" type="text/javascript">
			var module_name_js="video";
			</script>
         {$myobj->setTemplateFolder('general/','video')}
         {include file='box.tpl' opt='videos_top'}
		 <div class="clsOverflow">
           <div class="clsFloatLeft">
                    <div class="clsVideoBlockTitleLeft"><h2 class="clsSideHeading clsTitleVideo">{$LANG.index_page_videos}</h2><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/foxLoader.gif" alt="" title="" id="loaderVideos" style="display:none" /> </div>
                </div>

{assign var=music_limit_per_page value=4}
<div class="clsIndexAudioContainer">
 <div class="clsJQCarousel" id="musicListTabs">
    <ul class="clsJQCarouselTabs clsOverflow">
        {if $CFG.admin.videos.newvideo}
        <li id="li_newvideo_Head" ><a href="indexVideoBlock.php?showtab=newvideo&limit={$music_limit_per_page}"><span>{$LANG.index_page_random_videos_new_videos}</span></a></li>
        {/if}
        {if $CFG.admin.videos.topratedvideo}
        <li id="li_topratedvideo_Head" ><a href="indexVideoBlock.php?showtab=topratedvideo&limit={$music_limit_per_page}"><span>{$LANG.index_page_videos_top_rated_videos}</span></a></li>
        {/if}
    </ul>
</div>
</div>
</div>

{if !isAjaxPage()}
<div class="clsVideoIndexVideoBlock">
{/if}
<div class="clsIndexVideoContainer">
       <div class="clsVideoPopUpClear" style="width:150px;"></div>
        </div>
 		 {if !isAjaxPage()}
              {$myobj->setTemplateFolder('general/','video')}
        	 {include file='box.tpl' opt='videos_bottom'}
             </div>
         {/if}
	  {/if} {* end of recentlyviewedvideo,recommendedvideo,newvideo,topratedvideo CFG condition *}
{/if}{* end of chkAllowed module video condition *}

{assign var=channel_limit_per_page value=3}
	 {$myobj->setTemplateFolder('general/','video')}
	{include file='box.tpl' opt='videos_top'}

<div class="clsVideoCarouselCategory">
<div class="clsIndexVideoContent">
<h2 class="clsSideHeading clsTitleVideo clsFloatLeft">{$LANG.index_page_video_channels_title}</h2>
 <div class="clsJQCarousel" id="channelListTabs">
    <ul class="clsJQCarouselTabs clsOverflow">
		<li id="li_recentlyviewedvideo"><a href="indexVideoBlock.php?show_catgeroy=video_category&video_limit={$channel_limit_per_page}"><!----></a></li>
    </ul>
</div>
</div>
</div>

 {$myobj->setTemplateFolder('general/','video')}
{include file='box.tpl' opt='videos_bottom'}
<script type="text/javascript">
	var music_index_ajax_url = '{$CFG.site.video_url}indexVideoBlock.php';

	{literal}
	function videocarousel_itemLoadCallback(carousel, state)
	{
		var block = carousel.blockName();
		//var block = carousel.options.block;
		var i = carousel.first;

		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(i)) {
            return;
        }

		jQuery.get(
			music_index_ajax_url,
			{
				start: i,
				limit: {/literal}{$music_limit_per_page}{literal},
				block: block
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(i, data);
			}
		);
	};

	$Jq(window).load(function(){
		attachJqueryTabs('musicListTabs');
	});
	{/literal}
</script>


<script type="text/javascript">
	var music_index_ajax_url = '{$CFG.site.video_url}indexVideoBlock.php';

	{literal}
	function videoChannelCarousel_ItemLoadCallback(carousel, state)
	{

		var block_video = carousel.options.block_video;

		//var block = carousel.options.block;
		var video_item = carousel.first;

		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(video_item)) {
            return;
        }

		jQuery.get(
			music_index_ajax_url,
			{
				start_video: video_item,
				video_limit: 3,
				block_video: block_video
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(video_item, data);
			}
		);
	};

	$Jq(window).load(function(){
		attachJqueryTabs('channelListTabs');
	});
	{/literal}
</script>

{* BANNER SECTION STARTS *}
	<div class="cls468pxBanner">
		<div>{php}global $CFG; getAdvertisement('bottom_banner_468x60'){/php}</div>
	</div>
{* BANNER SECTION ENDS *}	
