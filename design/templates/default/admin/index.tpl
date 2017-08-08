{if $myobj->isShowPageBlock('statistics_list')}
        <h2>{$CFG.site.name}&nbsp;</h2>
        <h3>{$LANG.index_statistics}</h3>
   		<table class="clsWithoutBorder">
        <tr>
          <td class="clsWithoutBorder">
          <table class="">
                    <tr>
                    <th colspan="2">{$LANG.index_module_members}</th>
                    </tr>
                    <tr>
                        <td>
                            {$LANG.index_total_members}                        </td>
                        <td>
                           	{$myobj->statistics_list.membersStatistics.total_active_member}                        </td>
                    </tr>
                    <tr>
                        <td>
                            {$LANG.index_activate_members}                        </td>
                        <td>
                            {$myobj->statistics_list.membersStatistics.total_toactivate_member}                        </td>
                    </tr>
                    <tr>
                          <td>{$LANG.index_today_new_members}</td>
                          <td>{$myobj->statistics_list.membersStatistics.total_today_member}</td>
                    </tr>
                     <tr>
                          <td>{$LANG.admin_index_this_week}</td>
                          <td>{$myobj->statistics_list.membersStatistics.this_week_member}</td>
                    </tr>
                     <tr>
                          <td>{$LANG.admin_index_this_month}</td>
                          <td>{$myobj->statistics_list.membersStatistics.this_month_member}</td>
                    </tr>
                </table>

          </td>
          {if $myobj->statistics_list.firstModule}
          	<td class="clsWithoutBorder">
                {if $myobj->statistics_list.firstModule != ''}
                	{$myobj->setTemplateFolder('admin/',$myobj->statistics_list.firstModule)}
                 	{assign var=module_heading_tpl value='index_'|cat:$myobj->statistics_list.firstModule|cat:'_statistics_block.tpl'}
		   			{include file=$module_heading_tpl}
                 {/if}
              </td>
           {/if}
          </tr>
        {assign var='count' value='0'}
        {assign var='is_td' value='0'}
        {foreach item=module from=$CFG.site.modules_arr}
        	{if chkAllowedModule(array($module)) and $module!=$myobj->statistics_list.firstModule and $myobj->statistics_list.firstModule != ''}
               {if $count == 0}
                <tr>
                {/if}

                 <td class="clsWithoutBorder">
					{$myobj->setTemplateFolder('admin/',$module)}
                 	{assign var=module_heading_tpl value='index_'|cat:$module|cat:'_statistics_block.tpl'}
		   			{include file=$module_heading_tpl}
                 </td>

                {counter  assign=count}
                {if $count%2 eq 0}
                    {counter start=0}
                    </tr>
                {/if}
                {assign var=is_td value=$is_td+1}
             {/if}
        {/foreach}
        {if $is_td%2!=0}
            	<td class="clsWithoutBorder">&nbsp;</td>
                </tr>
        {/if}
    </table>
{/if}

{if $myobj->isShowPageBlock('latestnews_list')}
<div id="sellatestNews">
        <div>
            <h3>{$LANG.index_latest_news}</h3>
             {$myobj->setTemplateFolder('admin/')}
{include file="information.tpl"}
            {if $myobj->isShowPageBlock('latestnews_list')}
<div id="selReportBlock">
                </div>
            {/if}
            {if $myobj->latestnews_list.populateNews }
                <div class="clsLatestNews">
            	    {foreach key=pnkey item=pnvalue from=$myobj->latestnews_list.populateNews}
                			<div class="clsLatestNewsContent">
				                <p><span>{$pnvalue.CONTENT}</span></p>
                			</div>
        	        {/foreach}
                		<div class="clsBold" align="right">
			                <p><a href="latestNews.php">{$LANG.index_more}</a></p>
            		    </div>
                </div>
            {else}
                  <div id="selMsgAlert">
                       <p>{$LANG.common_no_records_found}</p>
                </div>
            {/if}
        </div>
    </div>
{/if}