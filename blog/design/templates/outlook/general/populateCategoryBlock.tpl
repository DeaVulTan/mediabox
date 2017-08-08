<div class="clsCategoryBlock">
{$myobj->setTemplateFolder('general/','blog')}
{include file="box.tpl" opt="sidebar_top"}
<div class="clsSideBarLinks">
<div class="clsSideBarLeft">
        <p class="clsSideBarLeftTitle">
            {$LANG.common_sidebar_category_heading_label}
        </p>
        <span class=""></span>
	<div class="clsSideBarRight">
    <div class="clsSideBarContent">
    {if $populateBlogCategory_arr.record_count}
	<div class="clsOverflow">
    	<ul>
        	{assign var=cate_break_count value=1}
            {foreach key=genresKey item=categoryValue from=$populateBlogCategory_arr.row}
             <li class="{if $cid == $categoryValue.record.blog_category_id}clsActiveLink{else}clsInActiveLink{/if} {if $categoryValue.populateSubCategory.record_count}clsBlogSubMenu{/if}">
              {if $categoryValue.populateSubCategory.record_count}
                  <table>
                        <tr>

                            <td>
                               <a {if $cid == $categoryValue.record.blog_category_id}class='clsHideSubmenuLinks'{else}class="clsShowSubmenuLinks"{/if} href="javascript:void(0)" id="mainCategoryID{$cate_break_count}" onClick="showHideMenu('ancCategory', 'subCategoryID', '{$cate_break_count}', 'categoryCount', 'mainCategoryID')">{$LANG.common_myblogpost_detail_show}</a>
                            </td>
                            <td class="clsNoSubmenuImg">
                                <a id="ancCategory{$cate_break_count}"  class="" href="{$categoryValue.blogpostlist_url}" title="{$categoryValue.record.blog_category_name}">{$categoryValue.blog_category_name} &nbsp;<span>({$categoryValue.postCount})</span></a>
                            </td>
                        </tr>
                   </table>
                {else}
                   <a href="{$categoryValue.blogpostlist_url}" title="{$categoryValue.record.blog_category_name}">{$categoryValue.blog_category_name} &nbsp;<span>({$categoryValue.postCount})</span></a>
                {/if}
                <ul  id="subCategoryID{$cate_break_count}" style="display:{if $cid == $categoryValue.record.blog_category_id}block{else}none{/if};">
                	{foreach key=subgenresKey item=subcategoryValue from=$categoryValue.populateSubCategory.row}
                    	<li {if $sid == $subcategoryValue.record.blog_category_id}class='clsActiveLink'{else}class='clsInActiveLink'{/if}><a href="{$subcategoryValue.blogpostlist_url}" title="{$subcategoryValue.record.blog_category_name}">{$subcategoryValue.blog_category_name} &nbsp;<span>({$subcategoryValue.postCount})</span></a></li>
                    {/foreach}
                </ul>
            	{assign var=cate_break_count value=$cate_break_count+1}
            </li>
            {/foreach}
	        <input type="hidden" value="{$cate_break_count}" id="categoryCount"  name="categoryCount" />
    	</ul>
		</div>
        {if $morecategory_url}
        <div class="clsOverflow"><p class="clsMoreTags"><a href="{$morecategory_url}">{$LANG.common_sidebar_more_label}</a></p></div>
        {/if}
    {else}
      	<div class="clsNoRecordsFound">{$LANG.No comments found}</div>
    {/if}
</div>
</div>
</div>
</div>
{$myobj->setTemplateFolder('general/','blog')}
{include file="box.tpl" opt="sidebar_bottom"}
</div>