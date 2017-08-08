{assign var=div_alternate_class value=''}
    {if isset($activitiesView)}
    	{assign var=totRecords value=$activitiesView}
    {else}
    	{assign var=totRecords value=$CFG.admin.myhome.total_recent_activities}
    {/if}
	{if isset($module_arr) && ($module_arr) }
		{foreach key=keyValue item=moduleValue from=$module_arr}
			{if $moduleValue.module == 'general'}
				{$myobj->setTemplateFolder('members/')}
			{else}
				{$myobj->setTemplateFolder('members/', $moduleValue.module)}
			{/if}
		
			{if $keyValue < $totRecords}
				{include file=$moduleValue.file_name key=$moduleValue.parent_id}
			{/if}	
			{if $CFG.site.script_name == 'myHome.php' || $CFG.site.script_name == 'index.php'}
				{if $keyValue == $module_total_records}
					<!--Total Activitity >4  view all link visible-->
					{if $moduleValue.total_count >= $totRecords}
					<p class="clsViewAllLinks"><a href="{$activity_view_all_url}">{$LANG.myhome_recent_activities_view_all}</a></p>
					{/if}
				{/if}
			{/if}
			 {if $div_alternate_class == ''}
				{assign var=div_alternate_class value=' class="clsAlternativeClr "'}
			 {else}
				{assign var=div_alternate_class value=''}
			 {/if}
		{/foreach}
	{else}
	  <div class="clsOverflow">
		<div class="clsNoRecordsFound">{$LANG.myhome_recent_activities_no_records}</div>
	  </div>	
	{/if}
