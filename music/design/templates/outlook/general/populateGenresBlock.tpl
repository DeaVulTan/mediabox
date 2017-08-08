{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="sidebar_top"}
    <div class="clsAudioIndex clsCategoryHd clsindexCategriesBlock">
        <h3>{$LANG.sidebar_genres_heading_label}</h3>
        {if $populateGenres_arr.record_count}
            <ul class="clsOverflow">
                {assign var=break_count value=1} 
                {foreach key=genresKey item=genresValue from=$populateGenres_arr.row}
                    <li>        
                       <div class="clsOverflow">
                            <span class="clsTDLinks clsSidelinkLeft">
                                    <a id="ancGenres{$break_count}"  class="" href="{$genresValue.musiclist_url}" title="{$genresValue.record.music_category_name}">{$genresValue.wordWrap_mb_ManualWithSpace_music_category_name} &nbsp;<span>({$genresValue.musicCount})</span></a>
                               </span>
                              <span class="clsSidelinkRight">                   
                                    {if $genresValue.populateSubGenres.record_count}
	                                    <a class="clsShowSubmenuLinks" href="javascript:void(0)" id="mainGenresID{$break_count}" onClick="showHideMenu('ancGenres', 'subGenresID', '{$break_count}', 'genresCount', 'mainGenresID')">show</a>
                                    {/if}
								</span>
                            </div>
                        {if $genresValue.populateSubGenres.record_count}                                
                                <ul  id="subGenresID{$break_count}" style="display:none;">
                                    {foreach key=subgenresKey item=subgenresValue from=$genresValue.populateSubGenres.row}
                                        <li><a href="{$subgenresValue.musiclist_url}" title="{$subgenresValue.record.music_category_name}">{$subgenresValue.wordWrap_mb_ManualWithSpace_music_category_name} &nbsp;<span>({$subgenresValue.musicCount})</span></a></li>
                                    {/foreach}
                                </ul>	
                         {/if}   
                    </li>
                    {assign var=break_count value=$break_count+1}                    
                {/foreach}	            
    	    </ul>
            <input type="hidden" value="{$break_count}" id="genresCount"  name="genresCount" />
        	<p class="clsViewMore"><a href="{$moregenres_url}" title="{$LANG.sidebar_more_label}">{$LANG.sidebar_view_all_category}</a></p>
        {else}	
        	<div class="clsNoRecordsFound">{$LANG.sidebar_no_genres_found_error_msg}</div>
        {/if}
    </div>          
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="sidebar_bottom"}