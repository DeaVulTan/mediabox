{if chkAllowedModule(array('music')) || chkAllowedModule(array('video')) || chkAllowedModule(array('photo')) }
    {if chkAllowedModule(array('music'))}
        {if $opt eq 'music'}
            {assign var='cloud_block_head' value=$LANG.sidebar_music_clouds_heading_label}
            {assign var='cloud_no_record' value=$LANG.sidebar_no_musicclouds_found_error_msg}
        {elseif $opt eq 'artist'}
            {if $CFG.admin.musics.music_artist_feature}
                {assign var='cloud_block_head' value=$LANG.sidebar_cast_clouds_heading_label}
                {assign var='cloud_no_record' value=$LANG.sidebar_no_castclouds_found_error_msg}
            {else}
                {assign var='cloud_block_head' value=$LANG.sidebar_artist_clouds_heading_label}
                {assign var='cloud_no_record' value=$LANG.sidebar_no_artistclouds_found_error_msg}
            {/if}
        {elseif $opt eq 'playlist'}
            {assign var='cloud_block_head' value=$LANG.sidebar_playlist_clouds_heading_label}
            {assign var='cloud_no_record' value=$LANG.sidebar_no_playlistclouds_found_error_msg}
        {/if}
    {/if}
    {if chkAllowedModule(array('video'))}
    	{if $opt eq 'video'}    
            {assign var='cloud_block_head' value=$LANG.sidebar_video_clouds_heading_label}
            {assign var='cloud_no_record' value=$LANG.sidebar_no_videoclouds_found_error_msg}
        {/if}
    {/if}    
    {if chkAllowedModule(array('photo'))}    
    	{if $opt eq 'photo'}    
            {assign var='cloud_block_head' value=$LANG.sidebar_photo_clouds_heading_label}
            {assign var='cloud_no_record' value=$LANG.sidebar_no_photoclouds_found_error_msg}
        {/if}
    {/if}
    {$myobj->setTemplateFolder('general/', '')}
    {include file="box.tpl" opt="tags_top"}
        <div class="clsTagsContainer">
            {if $populateCloudsBlock.resultFound}
                <p class="clsAudioTags">
                    {foreach from=$populateCloudsBlock.item item=tag}
                        <span class="{$tag.class}"><a {$tag.fontSizeClass} href="{$tag.url}" title="{$tag.name}" >{$tag.name}</a></span>
                    {/foreach}
                 </p>
                <p class="clsViewMore"><a href="{$moreclouds_url}">{$LANG.sidebar_view_all_label_tags}</a></p>
            {else}
                 <div class="clsNoRecordsFound"> {$cloud_no_record}</div>        		 
            {/if}
        </div>
    {$myobj->setTemplateFolder('general/', '')}
    {include file="box.tpl" opt="tags_bottom"}
{/if}