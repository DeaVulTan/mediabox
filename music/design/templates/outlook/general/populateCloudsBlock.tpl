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

{if $opt eq 'music' || $opt eq 'artist' || $opt eq 'playlist'}
{if !$tag_clouds_title_displayed}
<div class="clsTagsHeading clsOverflow">
	<div class="clsTagsLeftHead">
		<h3>{$LANG.sidebar_music_tag_clouds_heading_label}</h3>
	</div>        
</div>
{/if}
<div id="tagClouds{$opt}" {if $tag_clouds_title_displayed}style="display:none"{/if}>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="tags_top"}
    <div class="clsTagsContainer">
        {if $populateCloudsBlock.resultFound}
            <p class="clsAudioTags">
                {foreach from=$populateCloudsBlock.item item=tag}
                    <span class="{$tag.class}"><a {$tag.fontSizeClass} href="{$tag.url}" title="{$tag.name}" >{$tag.name}</a></span>
                {/foreach}
             </p>
            <p class="clsViewMore"><a href="{$moreclouds_url}" title="{$LANG.sidebar_more_label}">{$LANG.sidebar_view_all_label_tags}</a></p>
        {else}
             <div class="clsNoRecordsFound"> {$cloud_no_record}</div>        		 
        {/if}
    </div>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="tags_bottom"}
</div>
{/if}