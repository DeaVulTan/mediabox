{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div class="clsChangeThumbnailPage">
	<div class="clsOverflow">
    <div class="clsVideoListHeading"><h2>{$LANG.change_thumbnail}</h2></div>
	<div class="clsVideoListHeadingRight">
    <h3><a href="{$myobj->editVideoUrl}">{$LANG.back_to_edit_video}</a></h3>
    </div>
    </div>
{include file=information.tpl}
{if $myobj->isShowPageBlock('display_image')}
	<div class="clsOverflow clsChangeThumbnailContent">
    	<h3>{$LANG.current_thumbnail}</h3>
        <p class="clsViewThumbImage">
			<span><img src="{$myobj->currentThumb}?{php}echo time();{/php}" /></span>
        </p>
	</div>
	<div>
    	<div class="clsAvailableThumbnailContent">
            <h3>{$LANG.available_thumbnail}</h3>
            <p>{$LANG.available_thumbnail_description}</p>
        <div class="clsDataTable clsViewVideoPlaylistTable">
			<table>
                {foreach from=$myobj->image item=thumbnail}
                {if $thumbnail.opentr}
                <tr>
                {/if}
                {if $thumbnail.path}
                   <td>
                        <p class="clsViewThumbImage">
                            <a href="{$thumbnail.changeThumbUrl}"><img src="{$thumbnail.path}" width="{$thumbnail.width}" height="{$thumbnail.height}"/></a>
                        </p>
                   </td>
                {else}
                   <td></td>
                {/if}
                {if $thumbnail.closetr}
       			</tr>
        {/if}
		{/foreach}
		</table>
        </div>
        </div>
	</div>
	<div class="clsOverflow clsChangeThumbnailContent">
		<h3>{$LANG.upload_thumbnail}</h3>
		<form action="{$myobj->uploadThumbUrl}" method="post" enctype="multipart/form-data">
        	<div>
                <label for="thumbfile">{$LANG.upload_thumbnail_label}</label> {$myobj->getFormFieldErrorTip('thumbfile')}
                <input type="file" name="thumbfile" id="thumbfile" />
            </div>        
           <div class="clsOverflow">
               <div class="clsGreyButtonLeft">
                    <div class="clsGreyButtonRight">
                        <input type="submit" value="{$LANG.upload_button}" name="upload">
                    </div>
                </div>
            </div>
			</form>
    </div>
{/if}
</div>
{include file='box.tpl' opt='display_bottom'}