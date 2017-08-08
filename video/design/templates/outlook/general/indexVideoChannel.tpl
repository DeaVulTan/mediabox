{foreach key=inc item=value from=$video_detail_category_arr}
<td>
	<div class="clsIndexVideoContent">
	<div class="clsPointer">
		<div class="clsCategoryImgRight"><a href="{$value.channel_url}" class="ClsImageContainer ClsImageBorder1 Cls142x108">
            {if $value.image_url}
			<img src="{$value.image_url}" {$videoIndexObj->DISP_IMAGE(142, 108, $value.t_width, $value.t_height)}/>
			{else}
		    <img src="{$CFG.site.url}video/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImageVideo_T.jpg" />
            {/if}
		</a>
		</div>
		 <div class="clsTime">{$value.playing_time}</div>
	</div>
	<div class="clsVideoImageTitle">
		<pre><a href="{$value.channel_url}" title="{$value.video_title}">{$value.video_title}</a></pre>
	</div>
	</div>
</td>
{/foreach}



