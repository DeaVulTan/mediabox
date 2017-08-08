{if chkIsSubscriptionEnabled() and $myobj->getFormField('user_id') == $CFG.user.user_id}
<div class="clsSubscribersInfoTable">
<table {$myobj->defaultTableBgColor} >
        <tr>
          <th {$myobj->defaultBlockTitle} >
           <div class="clsOverflow">
           <div class="clsProfileSubscribersInfoTitle">{$LANG.myprofile_shelf_subscribers}</div>
           <div class="clsProfileSubscribersInfoLink">
            </div>
            </div>
          </th>
        </tr>
	 {if $subscribers_list_arr|@count==0}
        <tr>
          <td>
          <div id="selMsgAlert">
              <p>{$LANG.viewprofile_subscribers_no_msg}</p>
          </div></td>
        </tr>
      {else}
        <tr>
          <td>
          <table class="clsSubscribersInfo" id="{$CFG.profile_box_id.mysubscribers}">
              <tr>
              {assign var=td_count value=0}
               {foreach key=item item=value from=$subscribers_list_arr}
                <td>
                	<div class="clsProfileOverflow">
						<div class="clsThumbImageContainer clsMemberImageContainer">
                        	<div class="clsThumbImageContainer">
								<a class="ClsImageContainer ClsImageBorder2 Cls66x66" href="{$value.memberProfileUrl}">
                            		<img src="{$value.profileIcon.s_url}" alt="{$value.record.user_name}" title="{$value.record.user_name}" onclick="Redirect2URL('{$value.memberProfileUrl}')" {$myobj->DISP_IMAGE(#image_small_width#, #image_small_height#, $value.profileIcon.s_width, $value.profileIcon.s_height)} />
								</a>
                             </div>
                       	</div>
                    </div>
                    <p id="selMemberName" class="clsProfileThumbImg">
                        <a href="{$value.memberProfileUrl}">{$value.record.user_name}</a>
                    </p>
	             </td>
                 {assign var=td_count value=$td_count+1}
                {/foreach}
                {if $td_count lt 7}
                {assign var=td_max value=7}
                {assign var=td_loop value=$td_max-$td_count}
                {section name=loop start=0 loop=$td_loop}
               <td>&nbsp;</td>
               {/section}
                {/if}
              </tr>
            </table>
            <div class="clsViewMoreLink">
                {if $subscribers_list_arr|@count > $CFG.profile.total_list_my_subscribers-1}
                    <a href="{$myobj->getUrl('mysubscribers', '', '', 'members')}">{$LANG.viewprofile_link_view_subscribers}</a>
                {/if}
            </div>
            </td>
        </tr>
       {/if}
      </table>
</div>
{/if}