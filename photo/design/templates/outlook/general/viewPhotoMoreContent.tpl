<div class="clsSideCaroselContainer clsOverflow">
	{assign var=count value=1}
    {assign var=row_count value=1}
    {if $myobj->total_records}
        {foreach from=$relatedPhoto item=result}
             {if $count % 2 != 0}<div class="clsOverflow clsViewPhotoBorderBottom">{/if}
             <div class="clsViewPageSideContainer {if $count % 2 == 0} clsThumbPhotoFinalRecord{/if}">
                <div class="clsViewPageSideImage">
					<a href="{$result.photo_url}" class="cls146x112 clsImageHolder clsImageBorderBgSidebar clsPointer">                                	
							<img src="{$result.photo_image_src}" alt="{$result.photo_title|truncate:25}" {$result.photo_disp} title="{$result.photo_title}"/>                                    
					</a>           
                </div>
                <div class="clsViewPageMoreContent">
                    <p class="clsViewPageMoreContentTitle"><a href="{$result.photo_url}" title="{$result.photo_title}">{$result.photo_title}</a></p>
                    {*--------  <p>{$LANG.viewphoto_from_label}: <span><a href="{$result.getMemberProfileUrl}">{$result.name}</a></span></p>
                    <p>{$LANG.viewphoto_views_label}: <span>{$result.record.total_views}</span></p>
                    <p>{if $result.record.rating > 1}
                        {$LANG.viewphoto_total_ratings}:
                    {else}
                        {$LANG.viewphoto_total_rating}:
                     {/if}<span> {$result.rating}</span></p> ---------------*}
                </div>
            </div>  
          {if $count % 2 == 0}</div>{/if}         
         {assign var=count value=$count+1}          
        {/foreach}
         <div id="selNextPrev" class="clsPhotoCarouselPaging" style="display:none">
            <input type="button" href="javascript:void(0);" title="{$LANG.common_previous}" {if $myobj->leftButtonExist} onclick="movePhotoSetToLeft(this, '{$myobj->pg}')" {/if} value="" id="photoPrevButton_{$myobj->pg}" class="{$myobj->leftButtonClass}" />
            <input type="button" href="javascript:void(0);" title="{$LANG.common_next}" {if $myobj->rightButtonExists} onclick="movePhotoSetToRight(this, '{$myobj->pg}')"{/if} value="" id="photoNextButton_{$myobj->pg}" class="{$myobj->rightButtonClass}" />
        </div>
    {else}
    	<div id="selNextPrev" class="clsPhotoCarouselPaging" style="display:none">
        </div>
        <div class="clsNoRecordsFound">{$LANG.viewphoto_no_related_photos_found}</div>
    {/if}
</div>