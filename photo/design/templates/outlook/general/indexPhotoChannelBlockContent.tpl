	{if $photo_block_category_record_count}
	<div class="clsCarouselList">
            {section name=all_category loop=$category_id_arr}
                {assign var=cid value=$category_id_arr[all_category]}
                <div class="clsMainCategory">
                    <div class="clsPhotoSubCategeroy">
                        <h3>
							<a href="{$photo_channel_url_arr[$cid]}" title="{$category_name_arr[$cid]}">{$category_name_arr[$cid]}&nbsp;<span>({$myobj->photoCount($cid)})</span></a>
						</h3>
                    </div>
                    <table class="clsPhotoCarouselList">
                            {assign var=break_count value=1}
                            {foreach key=upload_photoKey item=upload_photoValue from=$populateCarousalphotoBlock_arr[$cid].row}
                                {if $break_count == 1}
                                    <tr>
                                        {/if}
                                        <td {if $break_count == 4} class="clsFinalData" {/if}>
                                            <div class="clsLargeThumbImageBackground" title="{$upload_photoValue.wordWrap_mb_ManualWithSpace_photo_title}" onclick="Redirect2URL('{$upload_photoValue.viewphoto_url}')">
                                                <div class="clsPhotoThumbImageOuter">
                                                    {if $upload_photoValue.photo_image_src != ''}
                                                                <a  href="{$upload_photoValue.viewphoto_url}" onclick="Redirect2URL('{$upload_photoValue.viewphoto_url}')" class="cls146x112 clsImageHolder ClsImageBorder" >
                                                                    <img src="{$upload_photoValue.photo_image_src}" title="{$upload_photoValue.wordWrap_mb_ManualWithSpace_photo_title}" alt="{$upload_photoValue.wordWrap_mb_ManualWithSpace_photo_title|truncate:25}" id="image_img_photoInCategory_{$case}_{$upload_photoValue.record.photo_id}" {$myobj->DISP_IMAGE(#image_photo_thumb_width#, #image_photo_thumb_height#, $upload_photoValue.thumb_width, $upload_photoValue.thumb_height)}/>
                                                                </a>
                                                             {else}
                                                                <img  src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_photo_T.jpg" title="{$upload_photoValue.record.photo_title}" alt="{$LANG.common_no_images}"/>
                                                    {/if}

                                                   </div>
                                                </div>
                                            {if $upload_photoValue.photo_image_src != ''}
                                                <div class="clsSlideTip" >
                                                    <a href="javascript:;"  title="{$LANG.common_zoom}" class="clsPhotoVideoEditLinks" id="img_{$upload_photoValue.record.photo_id}" onclick="zoom('img_photoInCategory_{$case}_{$upload_photoValue.record.photo_id}','{$upload_photoValue.photo_large_image_src}','{$upload_photoValue.photo_title_js|truncate:50}')"><span class="clsIndexZoomImg"></span></a>
                                                </div>
                                            {/if}
                                                <div class="clsCategorySubTitle">
                                                    <a href="{$upload_photoValue.viewphoto_url}" title="{$upload_photoValue.wordWrap_mb_ManualWithSpace_photo_title}"><pre>{$upload_photoValue.wordWrap_mb_ManualWithSpace_photo_title}</pre></a>
                                                </div>
                                        </td>
                                        {assign var=break_count value=$break_count+1}
                                        {if $break_count > 4}
                                    </tr>
                                    {assign var=break_count value=1}
                                {/if}
                            {/foreach}
                        </table>
                </div>
            {/section}
     </div>
   	{else}
    	<div class="clsNoRecordsFoundNoPadding">{$LANG.sidebar_no_record_found_error_msg}</div>
    {/if}

