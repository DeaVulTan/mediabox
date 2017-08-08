{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selMembersBrowse" class="clsListTable">
    <div class="clsOverflow">
    <div class="clsListHeadingLeft">
	  <h2>{$LANG.mysubscribers_title}</h2>
    </div>
    
 
</div>  
 <div id="selLeftNavigation">
  {if $myobj->isShowPageBlock('subscribers_list')}
	<div id="selViewAllMembers" class="clsMemberListTable">
        {if $myobj->isResultsFound()}    
         {if $CFG.admin.navigation.top}
             {include file='pagination.tpl'}
         {/if}
               
          <table>
          {foreach key=inc item=value from=$myobj->member_subscription_arr}
            {if $value.open_tr}
            <tr>
            {/if}
               <td>
                <ul class="clsSubscribersListDisplay">
                  <li id="memberlist_videoli_{$inc}"> 

                    <div class="clsThumbImageContainer clsMemberImageContainer">
                            <div class="clsThumbImageContainer">
                                <div class="clsThumbImageLink" id="selMemberName">
                                    <div  class="clsPointer">
                                        <div class="ClsImageContainer ClsImageBorder2 Cls66x66" {$value.profileIcon.t_attribute} id="memberlist_thumb_{$inc}">
                                        <a href="{$value.memberProfileUrl}" class="ClsImageContainer ClsImageBorder2 Cls66x66">
                                           <img src="{$value.profileIcon.s_url}" border="0" alt="{$value.record.user_name|truncate:7}" title="{$value.record.user_name}"  {$value.profileIcon.s_attribute}/></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="clsMemberListThumbTitle">
                                    <a href="{$value.memberProfileUrl}">{$value.record.user_name}</a>
                                </div>
                            </div>
                    </div>
                  </li>
                 </ul>
              </td>
            {if $value.end_tr}
                  </tr>
            {/if}
        {/foreach}
        {if $myobj->mem_last_tr_close}
                {section name=foo start=0 loop=$myobj->mem_user_per_row step=1}
                        <td>&nbsp;</td>
                {/section}
              </tr>
        {/if}
          </table>

         {if $CFG.admin.navigation.bottom}
              {include file='pagination.tpl'}
         {/if}
        {/if}
      </div>
  {/if}
   </div>
</div>  
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}