{if $featuredContentTotal > 1}
    <link rel="stylesheet" href="{$CFG.site.url}js/lib/jQuery_plugins/anythingslider/slider.css" type="text/css" media="screen" />

	<script language="javascript" type="text/javascript" src="{$CFG.site.url}js/lib/jQuery_plugins/anythingslider/jquery.anythingslider.js"></script>
	<script language="javascript" type="text/javascript" src="{$CFG.site.url}js/lib/jQuery_plugins/anythingslider/jquery.easing.js"></script>
	<script language="javascript" type="text/javascript" src="{$CFG.site.url}js/anythingslider_config.js"></script>
{/if}
<!-- START AnythingSlider -->
{include file="box.tpl" opt="slider_top"}
{if $featuredContentTotal > 1}
<div class="anythingSlider">
{else}
<div class="anythingSlider clsIndexSingleSlide">
{/if}
	<div class="wrapper">
		<ul>
			{foreach key=inc item=content from=$featuredContent}
				<li>
                {if is_array($content.sidebar_content)}
                    <div class="clsSiteContent">
                {else}
                    <div class="clsCustomContent">
                 {/if}
					<h2>{$content.glider_title}</h2>
					<div class="clsLatestFeatureContent">
						<div class="clsImage">
							{if $content.rollover_text}
						    	<div class="clsTransparent" id="{$content.selRollover}" >
						            <p class="{$content.clsRollover}">{$content.rollover_text}</p>
						        </div>
							{/if}
					    	<div>
					    		{if $content.target_url}
					    			<a class="clsImageContainer clsImageBorder4 cls368x277" href="{$content.target_url}"><img src="{$content.image_src}" {$myobj->DISP_IMAGE(366, 275, $content.image_width, $content.image_height)}/></a>
					    		{else}
					    			<div class="clsImageContainer clsImageBorder4 cls368x277"><img src="{$content.image_src}" /></div>
					    		{/if}
					        </div>
					    </div>
					    <div class="clsDetails">
					        {$myobj->setTemplateFolder('general/')}
					        {include file='box.tpl' opt='featuredetails_top'}
					        	<div class="clsFeatureDetailsContainer">
					            	<div class="clsFeatureDetailsContent" id="{$content.selIndexGliderSidebarContent}">
					            		{if is_array($content.sidebar_content)}
						                	<h3>{$content.sidebar_content.title}</h3>
						                	{if $content.sidebar_content.description}
						                		<p>
													{$content.sidebar_content.description}
													{if strlen($content.sidebar_content.description) > 74}
														<a href="{$content.sidebar_content.target_url}">..{$LANG.common_more}</a>
													{/if}
												</p>
						                    {/if}
						                    <p class="clsUserName">{$LANG.common_by} <a href="{$content.sidebar_content.user_url}">{$content.sidebar_content.user_name}</a></p>

						                    <div class="clsSeperator"><!-- seperator line --></div>

						                    <div class="clsViewDetails">
						                    	{if $content.sidebar_content.duration}
													<p><span class="clsLeft">{$LANG.common_duration}</span><span class="clsRight">{$content.sidebar_content.duration}</span></p>
						                    	{/if}
						                    	<p><span class="clsLeft">{$LANG.common_views}</span><span class="clsRight">{$content.sidebar_content.total_views}</span></p>
						                    	<p><span class="clsLeft">{$LANG.common_comments}</span><span class="clsRight">{$content.sidebar_content.total_comments}</span></p>
						                    </div>

						                    <div class="clsFeatureRating">
								            	{* ---------------DISPLAYING RATING FORM BEGINS--------------------------*}
							                	{if $myobj->chkAllowRating($content.media_type, $content.media_id)}
							                        {$myobj->populateStaticRatingImages($content.sidebar_content.total_ratings, $content.media_type)}
							                  	{/if}
								                {* -------------- DISPLAYING RATING FORM ENDS------------------------*}
						                    	<span>({$content.sidebar_content.total_ratings} {$content.sidebar_content.ratings_text})</span>
						                    </div>

						                    <div class="clsSeperator"><!-- seperator line --></div>

						                    <div class="clsWatchMore">
						                    	<a href="{$content.target_url}">{$content.sidebar_content.view_content_text}</a>
						                    </div>
					            		{else}
					            			{$content.sidebar_content}
					            		{/if}
					                </div>
					            </div>
					        {include file='box.tpl' opt='featuredetails_bottom'}
					    </div>
					</div>
				</div>
        		{if !is_array($content.sidebar_content)}
        			{literal}
        				<script language="javascript" type="text/javascript">
        					$Jq({/literal}"#{$content.selIndexGliderSidebarContent}"{literal}).jScrollPane({showArrows: true, scrollbarWidth: 10, scrollbarMargin: 10});
        				</script>
        			{/literal}
        		{/if}
				</li>
			{/foreach}
		</ul>
	</div>
</div> <!-- END AnythingSlider -->
{include file="box.tpl" opt="slider_bottom"}
