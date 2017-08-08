{if $featured_record_count}
<div class="clsIndexPlayerContainer">
	<div class="clsIndexPlayerHeading">
        <h2 id="selSlideHead"></span></h2>
    </div>
    <div class="clsIndexPlayerContent clsOverflow">
    	<div class="clsIndexPlayer">
			<div id="gallery" class="content">
				<div class="slideshow-container">
					<div id="slideshow" class="slideshow"></div>
				</div>
			</div>
		</div>
		<div class="clsIndexPlayerDetailsContent">
			<div class="clsindexPlayerDetails">
				<div id="caption" class="caption-container"></div>
			</div>
			<div id="thumbs" class="navigation clsIndexPlayerImageContainer">
				<ul class="thumbs noscript">
        			{foreach key=genresKey item=photoValue from=$populate_featured_photo_arr}
            		<li class="clsActive">
            			<a href="#" id="thumbshash{$genresKey}"></a>
                		<a class="thumb cls81x59 clsImageHolder ClsImageBorder3" href="{$photoValue.photo_image_src_medium}"><img src="{$photoValue.photo_image_src_small}" alt="{$photoValue.photoTitle|truncate:$CFG.admin.photos.photo_index_featured_title_length:'..':true:true}" title="{$photoValue.photoTitle|truncate:$CFG.admin.photos.photo_index_featured_title_length:'..':true:true}" imgattr='{$myobj->DISP_IMAGE(375, 281, $photoValue.record.m_width, $photoValue.record.m_height)}' slidehead="{$photoValue.photo_slide_head}" viewurl="{$photoValue.photo_url}" {$myobj->DISP_IMAGE(81, 59, $photoValue.record.s_width, $photoValue.record.s_height)} /></a>
                		<div class="caption">
                			<div class="clsIndexPlayerDet">
			                	<div class="clsIndexPlayerInfo">
			                		<p class="clsIndexDes">{if $photoValue.photoCaption}{$photoValue.photoCaption}{else}{$LANG.photo_no_description}{/if}</p>
                                    
			                	</div>
	                        	<div class="clsIndexPlayerAddedby">
	                            	<p class="clsAddedUser">by <a class="clsUserNames" href="{$photoValue.user_details.profile_url}">{$photoValue.user_details.display_name}</a></p>
                                    <p>{$photoValue.record.p_date_added}</p>
	                        	</div>
		                	</div>
		                    	<div class="clsIndexPlayerCounts">
		                        	<div class="clsIndexPlayerViews"><p>{$LANG.index_views_label}: <span class="clsViewCount">{$photoValue.record.total_views}</span> {$LANG.index_comments_label}: <span>{$photoValue.record.total_comments}</span></p></div>
		                        	<div class="clsIndexPlayerRating clsOverflow">
                                    <p class="clsFloatLeft">{$LANG.index_rating_label}:{$myobj->populateRatingImages($photoValue.record.rating, '', '', '', 'photo')}({$photoValue.record.rating})</p>
                                    <p class="clsIndexMore clsOverflow clsFloatRight"><a href="{$photoValue.photo_url}">{$LANG.index_photo_view_label}</a></p>
                                    </div>
		                    	</div>
						</div>
               		</li>
               		{/foreach}
            	</ul>
			</div>
			{literal}
				<script language="javascript">
					$Jq('#thumbs').jScrollPane({scrollbarWidth:10, scrollbarMargin:10,showArrows:true});
				</script>
			{/literal}
		</div>
	</div>
</div>
{/if}
