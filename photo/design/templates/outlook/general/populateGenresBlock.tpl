      <div class="clsSideBarContent">
        {if $populateGenres_arr.record_count}
        	<div class="clsOverflow">
	            <ul class="clsPhotoSidebarLinks">
                {assign var=break_count value=1}
                {foreach key=genresKey item=genresValue from=$populateGenres_arr.row}
                    <li class="{if $cid == $genresValue.record.photo_category_id}clsActiveLink{/if} {*{if $genresValue.populateSubGenres.record_count}clsHasSubMenu{/if}*}">
                        <table>
                        	<tr>
                                {*{if $genresValue.populateSubGenres.record_count}
                            	<td>
                                   <a {if $cid == $genresValue.record.photo_category_id}class='clsHideSubmenuLinks'{else}class="clsShowSubmenuLinks"{/if} href="javascript:void(0)" id="mainGenresID{$break_count}" onClick="showHideMenu('ancGenres', 'subGenresID', '{$break_count}', 'genresCount', 'mainGenresID')" >show</a>
                                </td>
                                 {/if}*}
                         		<td>
                                	<a id="ancGenres{$break_count}"  class="" href="{$genresValue.photolist_url}" title="{$genresValue.record.photo_category_name}">{$genresValue.wordWrap_mb_ManualWithSpace_photo_category_name|truncate:40} &nbsp;<span>({$genresValue.photoCount})</span></a>
                                </td>
                            </tr>
                        </table>
                        {*<ul  id="subGenresID{$break_count}" style="display:{if $cid == $genresValue.record.photo_category_id}block{else}none{/if};">
                        {foreach key=subgenresKey item=subgenresValue from=$genresValue.populateSubGenres.row}
                            <li {if $sid == $subgenresValue.record.photo_category_id}class='clsActiveLink'{else}class='clsInActiveLink'{/if}><a href="{$subgenresValue.photolist_url}" title="{$subgenresValue.record.photo_category_name}">{$subgenresValue.wordWrap_mb_ManualWithSpace_photo_category_name} &nbsp;<span>({$subgenresValue.photoCount})</span></a></li>
                        {/foreach}
                        </ul>*}
                        {assign var=break_count value=$break_count+1}
                    </li>
                {/foreach}
	            <input type="hidden" value="{$break_count}" id="genresCount"  name="genresCount" >
    	    </ul>
            </div>
           <div class="clsOverflow">
            <div class="clsViewMoreLinks">
        	<p class="clsViewMore"><a href="{$moregenres_url}">{$LANG.sidebar_view_all_category}</a></p>
           </div>
          </div>
        {else}
        	<div class="clsNoRecordsFound">{$LANG.sidebar_no_genres_found_error_msg}</div>
        {/if}
    </div>