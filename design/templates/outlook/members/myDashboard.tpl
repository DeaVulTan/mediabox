<h3>{$LANG.header_mydashboard_short_links}</h3>
			<ul class="clsDashLink">
                {if $header->headerBlock.is_dashboard_module}
                {assign var=break_count value=0}
                    {assign var=totcnt value= $header->headerBlock.dashboard_module_arr|@count}
                    {assign var=totcnt value=$totcnt-1}                        
                    {foreach key=module  item=moduleStats from=$header->headerBlock.dashboard_module_arr}  
                         {if $header->headerBlock.dashboard_module_arr.$module}
					{foreach key=item  item=dashshortlink from=$header->headerBlock.dashboard_module_arr.$module.shortcuts}
                    				{assign var=break_count value=$break_count+1}
                                    
                    	     	   <li><a href="{$dashshortlink.link_url}">{$dashshortlink.link_name|capitalize}</a></li>
									{if $break_count > 3}
                                    </ul><ul class="clsDashLink">
                                    {assign var=break_count value=0}
                                    {/if}                                   
                             {/foreach}
                         {/if}
                    {/foreach}
                {/if}
				
                {assign var=break_count value=$break_count+1}
                <li><a href="{$myobj->getUrl('myfriends')}">{$LANG.header_mydashboard_friends}: <span>{$getTotalFriendsNew}</span></a></li>
                    {if $break_count > 3}
                        </ul><ul class="clsDashLink">
                        {assign var=break_count value=0}
                    {/if}                 
                {if chkAllowedModule(array('affiliate'))}
                    {assign var=break_count value=$break_count+1}
                <li><a href="{$myobj->getUrl('memberslist', '?browse=referrals', '?browse=referrals')}">{$LANG.header_mydashboard_my_referrals}</a></li>
                    {if $break_count > 3}
                        </ul><ul class="clsDashLink">
                        {assign var=break_count value=0}
                    {/if}  
                {/if}
                {if chkAllowedModule(array('mail'))}
                    {assign var=break_count value=$break_count+1}
                <li><a href="{$myobj->getUrl('mail', '?folder=inbox', 'inbox/')}">{$LANG.header_mydashboard_inbox}</a></li>
                    {if $break_count > 3}
                        </ul><ul class="clsDashLink">
                        {assign var=break_count value=0}
                    {/if}  
                {/if}
                	{assign var=break_count value=$break_count+1}
                <li><a href="{$myobj->getUrl('myprofile')}">{$LANG.header_mydashboard_profile}</a></li>
                    {if $break_count > 3}
                        </ul><ul class="clsDashLink">
                        {assign var=break_count value=0}
                    {/if}                
                {if chkAllowedModule(array('members_banner', 'members_post_banner'))}
                    {assign var=break_count value=$break_count+1}
                <li ><a href="{$myobj->getUrl('managebanner')}">{$LANG.header_mydashboard_manage_banner}</a></li>
					{if $break_count > 3}
                        </ul><ul class="clsDashLink">
                        {assign var=break_count value=0}
                    {/if}                
                {/if}
                {if chkAllowedModule(array('affiliate'))}
                    {assign var=break_count value=$break_count+1}
                <li><a href="{$myobj->getUrl('earnings')}">{$LANG.header_mydashboard_my_earnings}</a></li>
					{if $break_count > 3}
                        </ul><ul class="clsDashLink">
                        {assign var=break_count value=0}
                    {/if}                
                {/if}
                    {assign var=break_count value=$break_count+1}
				<li ><a href="{$myobj->getUrl('membersinvite')}">{$LANG.header_dashboard_members_invite}</a></li>
					{if $break_count > 3}
                        </ul><ul class="clsDashLink">
                        {assign var=break_count value=0}
                    {/if}                
              </ul>
            {if $header->headerBlock.is_dashboard_module}                       
                  {foreach key=module  item=dashmodule from=$header->headerBlock.dashboard_module_arr} 
                      {if $header->headerBlock.dashboard_module_arr.$module}
                         {assign var=module_header_lang value='mydahsboard_'|cat:$module|cat:'_stats_header_title'}
                          <h3>{$LANG.$module_header_lang}</h3>
                                    <ul id="selDashStats" class="clsDashLink"> 
                                  {if $header->headerBlock.dashboard_module_arr.$module}                              
                                     {foreach key=item  item=dashstatslink from=$header->headerBlock.dashboard_module_arr.$module.stats} 
                                        <li><a href="{$dashstatslink.link_url}">{$dashstatslink.link_name|capitalize}{if $dashstatslink.stats_value != ''}: <span>{$dashstatslink.stats_value}</span>{/if}</a></li>
                                     {/foreach} 
                                  {/if}                                                                  
                                 </ul>
                       {/if}
                   {/foreach}
             {/if}  