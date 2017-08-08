<div class="clsIndexMusicBlockPlayer" >
{if isset($mainIndexObj->main_player_music_title)}<h3>{$mainIndexObj->main_player_music_title}</h3>{/if}
     {if $mainIndexObj->valid_music_details}
        {*GENERATE SINGLE PLAYER*}
        {$mainIndexObj->populateSinglePlayer($music_fields)}
        {*GENERATE SINGLE PLAYER*}
    {else}
        <div class="clsNoRecordsFound">{$LANG.mainIndex_music_no_record}</div>
    {/if}           	
</div>

