<div class="clsMusicInfoPopUpContainerDiv clsMusicDisplayNone" id="outerContainerDiv_{$myobj->music_block}"  onmouseover="hideCurrentMusicToolTip()">
</div>
<div class="clsMusicInfoPopUp clsMusicDisplayNone" id="{$myobj->music_block}_DisplaySec" style="position:absolute;z-index:100000">
</div>
{if !isAjaxPage()}
	<div id="sel{$myobj->getFormField('block')}Process"></div>
    <p class="clsPageNo" id="sel{$myobj->getFormField('block')}PageNo"></p>
    {assign var = height value=150}
    {assign var = cur_row value=$myobj->no_of_row-1}
    {assign var = incheight value=$cur_row*100}    
    {assign var = heightRow value=$height+$incheight}
	<div id="container{$myobj->getFormField('block')}" style="position:relative;width:645px;height:{$heightRow}px;overflow-x:hidden;">
		<div id="sel{$myobj->getFormField('block')}List" class="clsMusicListCount" style="position:absolute;left:0px;top:0px;">
{/if}
{if isAjaxPage()}
{if $music_list_arr!=0}
<table class="clsCarouselList">
	{foreach key=inc item=value from=$music_list_arr}	
    {if $value.open_tr}
    	<tr>
    {/if}
    {assign var=inc_id value=$inc+$start}
    <td id="musicli_{$inc}"> 
		<div id="{$myobj->music_block}_musicli_{$inc_id}"> 
        <div class="clsThumbImageContainer">
            <div class="clsThumbImage clsOverflow">
                <a href="{$value.music_url}">
                    <span class="clsRunTime">{$value.playing_time}</span>
                    <img src="{$value.image_url}" id="{$myobj->music_block}_thumb_{$inc_id}" onmouseover="showMusicInfo(this)" />
                 </a>
                 
            </div>
            <a href="#" class="clsInfo_home clsMusicDisplayNone" id="{$myobj->music_block}_info_{$inc_id}" onmouseover="showMusicDetail_home(this)" ></a>
            
            <div class="clsThumbImageTitle">
                <p><a href="{$value.music_url}">{$value.music_title}</a></p>
            </div>          
        </div>
        
        <div class="clsMusicInfoPopUp clsMusicDisplayNone" id="{$myobj->music_block}_selMusicDetails_{$inc_id}">
             <div class="clsThumbImageContainer_inside" >
                <div class="clsThumbImage">
                    <a href="{$value.music_url}">
                        <span class="clsRunTime">{$value.playing_time}</span>
                        <img src="{$value.image_url}" />
                     </a>
                </div>
                <div class="clsThumbImageTitle">
                    <p><a href="{$value.music_url}">{$value.music_title}</a></p>
                </div>
                <a href="#" class="clsInfo_inside"></a>
                <div >
                 	<p>{$LANG.indexmusicblock_popup_from_label}:&nbsp;<a href="{$myobj->memberProfileUrl[$value.record.user_id]}">{$myobj->getUserName($value.record.user_id)}</a></p>
                </div>
             </div>
             <div class="clsMusicDetails" id="{$myobj->music_block}_clsMusicDetails_{$inc_id}" onmouseover="hideMusicDetail_home(this)">
                <p>{$value.record.music_caption}</p>
                <div class="clsMusicUserBottom"><div class="clsMusicUserTop"><div class="clsMusicUserDetails">
                    <p>{$LANG.indexmusicblock_popup_views_label}:&nbsp;{$value.record.total_views}</p>
                     <p>{$myobj->populateRatingImages($value.record.rating)}</p>
                    <p>{$LANG.indexmusicblock_popup_added_label}:&nbsp;{$value.music_date_added}</p>                
                </div></div></div>
             </div>
        </div>
    </div>
    </td>
    {if $value.end_tr}
    	<tr>
    {/if}
    {/foreach}
  </table>
{else}
	<p class="clsNoDatas">{$LANG.indexmusicblock_msg_no_musics}</p>
{/if}
{/if}
{if !isAjaxPage()}
</div>
</div>
{/if}

