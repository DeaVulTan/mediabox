{$myobj->setTemplateFolder('general/','article')}
{include file="box.tpl" opt="sidebar_top"}
<div class="clsSideBarLinks">
<div class="clsSideBarLeft">
    <div class="clsSideBar">
        <p class="clsSideBarLeftTitle">
            {$LANG.sidebar_genres_heading_label}
        </p>
        <span class=""></span>
    </div>
	<div class="clsSideBarRight clsOverflow">
    <div class="clsSideBarContent clsCategoryLists">
    {if $populateGenres_arr.record_count}
    	<ul>
        	{assign var=break_count value=1}
            {foreach key=genresKey item=genresValue from=$populateGenres_arr.row}
            <li {if $cid == $genresValue.record.article_category_id}class='clsActiveLink'{/if}>
                <a id="ancGenres{$break_count}"  class="" href="{$genresValue.articlelist_url}" title="{$genresValue.record.article_category_name}">{$genresValue.article_category_name|truncate:45} &nbsp;<span>({$genresValue.articleCount})</span></a>
                {*<ul>
                <li>
                	{if $genresValue.populateSubGenres.record_count}
                    	<a {if $cid == $genresValue.record.article_category_id}class='clsHideSubmenuLinks'{else}class="clsShowSubmenuLinks"{/if} href="javascript:void(0)" id="mainGenresID{$break_count}" onclick="showHideMenu('ancGenres', 'subGenresID', '{$break_count}', 'genresCount', 'mainGenresID')">show</a>
                    {/if}
                </li>
            	</ul>*}
                <ul  id="subGenresID{$break_count}" style="display:{if $cid == $genresValue.record.article_category_id}block{else}none{/if};">
                	{foreach key=subgenresKey item=subgenresValue from=$genresValue.populateSubGenres.row}
                    	<li {if $sid == $subgenresValue.record.article_category_id}class='clsActiveLink'{else}class='clsInActiveLink'{/if}><a href="{$subgenresValue.articlelist_url}" title="{$subgenresValue.record.article_category_name}">{$subgenresValue.article_category_name} &nbsp;<span>({$subgenresValue.articleCount})</span></a></li>
                    {/foreach}
                </ul>
            	{assign var=break_count value=$break_count+1}
            </li>
            {/foreach}
	        <input type="hidden" value="{$break_count}" id="genresCount"  name="genresCount" />
    	</ul>
        <p class="clsMoreTags"><a href="{$moregenres_url}">{$LANG.sidebar_more_label}</a></p>
    {else}
      	<div class="clsNoRecordsFound">{$LANG.sidebar_no_genres_found_error_msg}</div>
    {/if}
</div>
</div>
</div>
</div>
{$myobj->setTemplateFolder('general/','article')}
{include file="box.tpl" opt="sidebar_bottom"}