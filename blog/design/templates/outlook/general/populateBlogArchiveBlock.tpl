{$myobj->setTemplateFolder('general/','blog')}
{include file="box.tpl" opt="sidebar_top"}
    <div class="clsViewPostArchiveContent">
       <p class="clsSideBarLeftTitle">{$LANG.common_sidebar_archives_label}</p>
       <div class="clsSideBarContent">
       <ul>
          {assign var=yr_break_count value=1}
          {foreach item=blogArchive from=$archive_year}
           <li class="{if $myobj->getFormField('y') == $blogArchive.year}clsActiveLink{else}clsInActiveLink{/if} {if $blogArchive.year_total_post}clsBlogSubMenu{/if}">
            {if $blogArchive.year_total_post}
            <table>
                <tr>                   
                    <!--<td>                                   
                       <a {if $myobj->getFormField('y') == $blogArchive.year}class="clsHideSubmenuLinks"{else}class="clsShowSubmenuLinks"{/if} href="javascript:void(0)" id="mainYearID{$yr_break_count}" onClick="showHideMenu('ancYear', 'subMonthID', '{$yr_break_count}', 'yearCount', 'mainYearID')">{$LANG.common_myblogpost_detail_show}</a>                                   
                    </td> -->
                   
                    <td class="clsNoSubmenuImg"> 
                        <a id="ancYear{$yr_break_count}"  class="" href="{$blogArchive.blog_link}">{$blogArchive.year} &nbsp;<span>({$blogArchive.year_total_post})</span></a>
                    </td>                               	
                </tr>
           </table>
             {else}
              <a href="{$blogArchive.blog_link}">{$blogArchive.year} &nbsp;<span>({$blogArchive.year_total_post})</span></a>
             {/if}
           <!--<a href="{$blogArchive.blog_link}">{$blogArchive.year}({$blogArchive.year_total_post})</a> -->
               <ul  id="subMonthID{$yr_break_count}" style="display:{if $myobj->getFormField('y') == $blogArchive.year}block{else}none{/if};">
                 {foreach item=blogMonthArchive from=$blogArchive.month_archive}
                  <li {if $myobj->getFormField('y') == $blogArchive.year && $myobj->getFormField('m')==$blogMonthArchive.month_name}class="clsActiveLink"{else}class="clsInActiveLink"{/if}><a href="{$blogMonthArchive.blog_link}">{$blogMonthArchive.month_name}({$blogMonthArchive.month_total_post})</a></li>
                 {/foreach}
               </ul>
           </li>
           {assign var=yr_break_count value=$yr_break_count+1}
          {/foreach}  
           <input type="hidden" value="{$yr_break_count}" id="yearCount"  name="yearCount" />                
       </ul>
      </div>
    </div>
{$myobj->setTemplateFolder('general/','blog')}
{include file="box.tpl" opt="sidebar_bottom"}
