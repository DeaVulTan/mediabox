{if $photo_block_record_count}
<table class="clsPhotoCarouselList">
{* Assigned to set num. of records in each row *}
	{assign var=row_count value=4}
	{assign var=break_count value=1}
	{foreach key=upload_photoKey item=upload_photoValue from=$populateCarousalphotoBlock_arr.row}
    {if $break_count == 1}
    	<tr>
    {/if}
		<td {if $break_count == $row_count} class="clsFinalData" {/if}>
        	<!--div class="clsPlayCurrentPhoto">
            	<a href="{$upload_photoValue.viewphoto_url}" title="{$upload_photoValue.record.photo_title}"> <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-play.gif" /></a>
            </div-->
            <div class="clsLargeThumbImageBackground" id="" onclick="Redirect2URL('{$upload_photoValue.viewphoto_url}')">
                	{if $upload_photoValue.photo_image_src != ''}
						<a href="{$upload_photoValue.viewphoto_url}" onclick="Redirect2URL('{$upload_photoValue.viewphoto_url}')" class="cls146x112 clsImageHolder ClsImageBorder" >
                        	<img src="{$upload_photoValue.photo_image_src}" title="{$upload_photoValue.wordWrap_mb_ManualWithSpace_photo_title} {$upload_photoValue.photo_additional_details}" alt="{$upload_photoValue.wordWrap_mb_ManualWithSpace_photo_title|truncate:25} {$upload_photoValue.photo_additional_details}" id="image_img_{$case}_{$upload_photoValue.record.photo_id}" {$myobj->DISP_IMAGE(#image_photo_thumb_width#, #image_photo_thumb_height#, $upload_photoValue.thumb_width, $upload_photoValue.thumb_height)}/>
						</a>
                     {else}
                        <img  src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_photo_T.jpg" title="{$upload_photoValue.record.photo_title} {$upload_photoValue.photo_additional_details}" alt="{$upload_photoValue.record.photo_title|truncate:25} {$upload_photoValue.photo_additional_details}"/>
                     {/if}
             </div>
			 {if $upload_photoValue.photo_image_src}
			 	<div class="clsSlideTip" >
    		 		<a href="javascript:;"  title="{$LANG.common_zoom}" class="clsPhotoVideoEditLinks" id="img_{$upload_photoValue.record.photo_id}" onclick="zoom('img_{$case}_{$upload_photoValue.record.photo_id}','{$upload_photoValue.photo_large_image_src}','{$upload_photoValue.photo_title_js|truncate:50}')"><span class="clsIndexZoomImg"></span></a>
         		</div>
    		{/if}
            <div class="clsPhotoIndexCauroselListContent" id="cur_{$case}_{$upload_photoValue.record.photo_id}" {*onmouseover="showCaption('cur_{$case}_{$upload_photoValue.record.photo_id}');" onmouseout="hideCaption('cur_{$case}_{$upload_photoValue.record.photo_id}')"*}>
            	<div class="clsOverflow">
                	<div class="clsIndexPhotoQuickMixLeft">
                    	<p><a href="{$upload_photoValue.viewphoto_url}" title="{$upload_photoValue.wordWrap_mb_ManualWithSpace_photo_title}"><pre>{$upload_photoValue.wordWrap_mb_ManualWithSpace_photo_title}</pre></a></p>
                  	</div>
                  	{*<div class="clsIndexPhotoQuickMixRight">
						{if isMember()}
					    	{if $upload_photoValue.add_quickmix}
						    	{if $upload_photoValue.is_quickmix_added && $upload_photoValue.photo_status == 'Ok'}
						  			<p class="clsQuickMix" id="quick_mix_added_{$upload_photoValue.photo_id}"><a href="javascript:void(0)" onClick="removePhotosQuickMixCount('{$upload_photoValue.photo_id}')"  class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.photo_list_remove_from_quickmix}" >{$LANG.common_photo_quick_mix}</a></p>
						  			<p class="clsQuickMix" id="quick_mix_{$upload_photoValue.photo_id}" style="display:none"><a href="javascript:void(0)" onClick="updatePhotosQuickMixCount('{$upload_photoValue.photo_id}')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="{$LANG.photo_list_add_to_quickmix}">{$LANG.common_photo_quick_mix}</a></p>
						  		{elseif $upload_photoValue.photo_status == 'Ok'}
						  			<p class="clsQuickMix" id="quick_mix_added_{$upload_photoValue.photo_id}" style="display:none"><a href="javascript:void(0)" onClick="removePhotosQuickMixCount('{$upload_photoValue.photo_id}')"  class="clsQuickMix-on clsPhotoVideoEditLinks" title="{$LANG.photo_list_remove_from_quickmix}">{$LANG.common_photo_quick_mix}</a></p>
						  			<p class="clsQuickMix" id="quick_mix_{$upload_photoValue.photo_id}"><a href="javascript:void(0)" onClick="updatePhotosQuickMixCount('{$upload_photoValue.photo_id}')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="{$LANG.photo_list_add_to_quickmix}">{$LANG.common_photo_quick_mix}</a></p>
						  		{/if}
					    	{/if}
				     	{/if}
                	</div>*}
				</div>
				{if $case == 'mostrecentphoto'}
					<p class="clsNormal">{$LANG.common_by}&nbsp;<a href="{$upload_photoValue.MemberProfileUrl}" title="{$upload_photoValue.username}">{$upload_photoValue.username}</a> {*{$upload_photoValue.date_added}*}</p>
				{elseif $case == 'recommendedphoto'}
                	<div class="clsOverflow">
                    	<p class="clsNormal clsIndexFeaturedRateLeft">{$LANG.common_by}&nbsp;<a href="{$upload_photoValue.MemberProfileUrl}" title="{$upload_photoValue.username}">{$upload_photoValue.username}</a> </p>
                    	{*<p class="clsIndexFeaturedRateRight">{$LANG.index_featured_label} {$upload_photoValue.total_featured}</p>*}
                  	</div>
				{elseif $case == 'mostfavoritephoto'}
                	<div class="clsOverflow">
                    	<p class="clsNormal clsIndexFeaturedRateLeft">{$LANG.common_by}&nbsp;<a href="{$upload_photoValue.MemberProfileUrl}" title="{$upload_photoValue.username}">{$upload_photoValue.username}</a></p>
						{*<p class="clsIndexFeaturedRateRight">{$LANG.index_favorite_label} {$upload_photoValue.total_favorites}</p>*}
                   	</div>
				{elseif $case == 'topratedphoto'}
                	<div class="clsOverflow">
                    	<div class="clsNormal clsTopRatedPhotoLeft">{$LANG.common_by}&nbsp;<a href="{$upload_photoValue.MemberProfileUrl}" title="{$upload_photoValue.username}">{$upload_photoValue.username}</a></div>
                        {*<div class="clsTopRatedPhotoRight">
							{if $myobj->populateRatingDetails($upload_photoValue.record.rating)}
                         		{$myobj->populatePhotoRatingImages($upload_photoValue.record.rating,'photo')}
                			{else}
                            	{$myobj->populatePhotoRatingImages(0,'photo')}
                        	{/if}
                       </div>*}
                    </div>
				{/if}
            </div>
        </td>
        {assign var=break_count value=$break_count+1}
    	{if $break_count > $row_count}
    		</tr>
    		{assign var=break_count value=1}
    	{/if}
    {/foreach}
    {if $break_count != 1}
    	{* Added to display empty row if last row records < row_count *}
    	<td colspan="{math equation=($row_count+1)-$break_count}">&nbsp;</td>
    	</tr>
    {/if}
</table>
{else}
	<div class="clsNoRecordsFoundNoPadding">{$LANG.sidebar_no_photo_found_error_msg}</div>
{/if}