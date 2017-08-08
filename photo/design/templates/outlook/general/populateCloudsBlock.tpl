{if $opt eq 'photo'}
        <div class="clsSideBarContent">
            {if $populateCloudsBlock.resultFound}
                <p class="clsPhotoTags">
                    {foreach from=$populateCloudsBlock.item item=tag}
                        <span class="{$tag.class}"><a style="font-size: 13px;" href="{$tag.url}" title="{$tag.name}">{$tag.name}</a></span>
                    {/foreach}
                 </p>
                <div class="clsOverflow">
                 <div class="clsViewMoreLinks">
	             <p class="clsViewMore"><a href="{$moreclouds_url}">{$LANG.sidebar_view_all_label_tags}</a></p>
                </div>
               </div>
            {else}
               <div><p class="clsNoRecordsFound">{$LANG.sidebar_no_photoclouds_found_error_msg}</p></div>
			{/if}
        </div>
{elseif $opt eq 'playlist'}
        <div class="clsSideBarContent">
            {if $populateCloudsBlock.resultFound}
                <p class="clsPhotoTags">
                    {foreach from=$populateCloudsBlock.item item=tag}
                        <span class="{$tag.class}"><a style="font-size: 13px;" href="{$tag.url}" title="{$tag.name}" >{$tag.name}</a></span>
                    {/foreach}
                 </p>
              <div class="clsOverflow">
               <div class="clsViewMoreLinks">
	            <p class="clsViewMore"><a href="{$moreclouds_url}">{$LANG.sidebar_view_all_label_tags}</a></p>
               </div>
              </div>
            {else}
	           <div class="clsNoRecordsFound"> {$LANG.sidebar_no_playlistclouds_found_error_msg}</div>
            {/if}
        </div>
{/if}