{if chkAllowedModule(array('music'))}
	{if $CFG.admin.musics.recentlyviewedmusic or $CFG.admin.musics.recommendedmusic
		   or $CFG.admin.musics.newmusic or $CFG.admin.musics.topratedmusic}
     {if !isAjaxPage()}
         {$myobj->setTemplateFolder('general/','music')}
         {include file='music_box.tpl' opt='musics_top'}         
     {/if}
<div class="clsIndexMusicContainer">
                <div class="clsOverflow">
                    <div class="clsMusicHeading"><h2>{$LANG.indexmusicblock_block_title_musics}</h2><img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/foxLoader.gif" alt="" title="" id="loaderMusics" style="display:none" /> </div>
                    <div class="clsMusicPaging" id="nav_recentlyviewedmusic"></div>
                    <div class="clsMusicPaging" style="display:none" id="nav_recommendedmusic"></div>
                    <div class="clsMusicPaging" style="display:none" id="nav_newmusic"></div>
                    <div class="clsMusicPaging" style="display:none" id="nav_topratedmusic"></div>
                </div> 
                <div class="clsIndexMusicLinks">
                	<ul class="musicBlockMenu">
                    	{if $CFG.admin.musics.recentlyviewedmusic}
                    	<li id="li_recentlyviewedmusic" class="{$musicIndexObj->recentlyviewedmusic_li_class}"><a onclick="showIndexMusicTabs('recentlyviewedmusic');"><span>{$LANG.indexmusicblock_block_musics_recently_viewed}</span></a></li>
                        {/if}
                        {if $CFG.admin.musics.recommendedmusic}
                    	<li id="li_recommendedmusic" class="{$musicIndexObj->recommendedmusic_li_class}" ><a onclick="showIndexMusicTabs('recommendedmusic');"><span>{$LANG.indexmusicblock_block_musics_recommended}</span></a></li>
                        {/if}
                        {if $CFG.admin.musics.newmusic}	
                    	<li id="li_newmusic" class="{$musicIndexObj->newmusic_li_class}"><a onclick="showIndexMusicTabs('newmusic');"><span>{$LANG.indexmusicblock_block_musics_new_musics}</span></a></li>
                        {/if}
                        {if $CFG.admin.musics.topratedmusic}
                    	<li id="li_topratedmusic" class="{$musicIndexObj->topratedmusic_li_class}"><a onclick="showIndexMusicTabs('topratedmusic');"><span>{$LANG.indexmusicblock_block_musics_top_rated_musics}</span></a></li>
                        {/if}                      
                    </ul>
                </div>
                {if $CFG.admin.musics.recentlyviewedmusic}
                <div class="clsIndexMusics" id="selIndex_recentlyviewedmusic">
                	{$musicIndexObj->getMusicIndexBlock('recentlyviewedmusic')}
                </div>
                {/if}
               {if $CFG.admin.musics.recommendedmusic}
                <div class="clsIndexMusics" id="selIndex_recommendedmusic" style="{$musicIndexObj->chk_for_music_block_display}">
                	{$musicIndexObj->getMusicIndexBlock('recommendedmusic')}
                </div>
                {/if}
                {if $CFG.admin.musics.newmusic}	
                <div class="clsIndexMusics" id="selIndex_newmusic" style="{$musicIndexObj->chk_for_music_block_display}">
                	{$musicIndexObj->getMusicIndexBlock('newmusic')}
                </div>
                {/if}
                
                {if $CFG.admin.musics.topratedmusic}
                <div class="clsIndexMusics" id="selIndex_topratedmusic" style="{$musicIndexObj->chk_for_music_block_display}">
                	{$musicIndexObj->getMusicIndexBlock('topratedmusic')}
                </div>
                {/if}
                <div class="clsMusicPopUpClear" style="width:150px;"></div>
        </div>
        
 		 {if !isAjaxPage()}
             {$myobj->setTemplateFolder('general/','music')}
        	 {include file='music_box.tpl' opt='musics_bottom'}
         {/if}
	  {/if} {* end of recentlyviewedmusic,recommendedmusic,newmusic,topratedmusic CFG condition *}
{/if}{* end of chkAllowed module music condition *}

