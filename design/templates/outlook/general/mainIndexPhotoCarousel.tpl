{if $photo_block_record_count}

{* Assigned to set num. of records in each row *}
{assign var=row_count value=4}

{* Assigned to find last record of each row *}
{assign var=break_count value=1}

{foreach key=upload_photoKey item=upload_photoValue from=$populateCarousalphotoBlock_arr.row}
<div class="clsCarouselListContent {if $break_count == $row_count}clsNoRightMargin{/if}">
	<div class="clsZoom">
        <a href="javascript:;" title="{$LANG.common_zoom}" class="clsPhotoVideoEditLinks" id="img_{$upload_photoValue.record.photo_id}" onclick="zoom('img_{$upload_photoValue.record.photo_id}','{$upload_photoValue.photo_large_image_src}','{$upload_photoValue.photo_title_js}')">&nbsp;&nbsp;</a>
    </div>
    <div class="clsCarouselListImage">
    	<a href="javascript:void(0);" onclick="Redirect2URL('{$upload_photoValue.viewphoto_url}')" class="clsImageContainer clsImageBorder7 cls142x108">
        	{if $upload_photoValue.photo_image_src != ''}
            <img src="{$upload_photoValue.photo_image_src}" title="{$upload_photoValue.record.photo_title}" alt="{$upload_photoValue.record.photo_title|truncate:12}" id="image_img_{$upload_photoValue.record.photo_id}" {$mainIndexObj->DISP_IMAGE(140, 106, $upload_photoValue.record.t_width, $upload_photoValue.record.t_height)}/>
         	{else}
            <img src="{$mainIndexObj->CFG.site.url}photo/design/templates/{$mainIndexObj->CFG.html.template.default}/root/images/{$mainIndexObj->CFG.html.stylesheet.screen.default}/no_image/noImage_photo_S.jpg" title="{$upload_photoValue.record.photo_title}" title="{$upload_photoValue.record.photo_title}" alt="{$upload_photoValue.record.photo_title|truncate:12}"/>
         	{/if}
        </a>
    </div>
    <div class="clsCarouselListDetails">
        <p class="clsTitle"><a href="{$upload_photoValue.viewphoto_url}" title="{$upload_photoValue.record.photo_title}">{$upload_photoValue.record.photo_title}</a></p>
        <p class="clsName">{$LANG.mainIndex_by} <a href="{$upload_photoValue.MemberProfileUrl}" title="{$upload_photoValue.record.user_name}">{$upload_photoValue.record.user_name}</a></p>
        <p class="clsViews">{$LANG.mainIndex_photo_views}: <span>{$upload_photoValue.record.total_views}</span></p>
    </div>
</div>
{assign var=break_count value=$break_count+1}
{/foreach}

{else}
<div class="clsNoRecordsFound">{$LANG.mainIndex_photo_no_record}</div>
{/if}