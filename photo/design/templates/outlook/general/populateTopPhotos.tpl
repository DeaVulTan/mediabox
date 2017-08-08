{if $record_count}
<div class="clsIndexMainContainer">
{$myobj->setTemplateFolder('general/','photo')}
    {include file="box.tpl" opt="indextopphotos_top"}
    <div class="clsOverflow">
        <div class="clsIndexPhotoHeading clsIndexTopPhotosHeading">
            <h3><span>{$LANG.sidebar_top_photos_label}</span></h3>
        </div>  </div>  
    <div class="clsOverflow">
        {foreach key=topPhotoKey item=topPhotoValue from=$topPhoto_arr}
            <div class="clsTopPhotosSection">
                <div class="clsThumbImageLink">
                    <div class="cls106x79 clsImageHolder clsImageBorderBgSidebar clsPointer" >
                    	<a href="{$topPhotoValue.photo_url}" class="cls106x79 clsImageHolder clsImageBorderBgSidebar clsPointer">
                         <img src="{$topPhotoValue.photo_image_src}" border="0"  title="{$topPhotoValue.photoTitle}" alt="{$topPhotoValue.photoTitle}" />
                         </a>
                    </div>
                </div>
                <div>
                    <p class="clsTitle"><a href="{$topPhotoValue.photo_url}" title="{$topPhotoValue.photoTitle}">{$topPhotoValue.photoTitle}</a></p>
                    <p class="clsName"><span><a href="{$topPhotoValue.memberProfileUrl}" title="{$topPhotoValue.name}">{$topPhotoValue.name}</a></span></p>
                    <p class="clsViews">{$LANG.sidebar_top_photos_label_views}&nbsp;<span>{$topPhotoValue.views}</span><!-- | {$LANG.sidebar_comments}&nbsp;<span>{$topPhotoValue.comments}</span>--></p>
                </div>
            </div>
        {/foreach}
    </div>
	{$myobj->setTemplateFolder('general/','photo')}
	{include file="box.tpl" opt="indextopphotos_bottom"}
</div>
{/if}