<div class="clsDataTable"><table id="selShowMail"> 
  <tr>
    <td>    
    <div id="selMisNavLinks">
      <ul class="clsMailLinks">
        {foreach key=key item=value from=$mail_header_link}
            <li class="cls{$value.display_text}"><div class="clsMailLinkLeft"><div class="clsMailLinkRight"><a href="{$value.href}" onclick="{$value.onclick}">{$mail_header_link.$key.display_text}</a></div></div></li>
        {/foreach}
      </ul>
    </div>
    </td>
    <td class="clsMsgNavigationCell"><div class="clsPagingList">
       <ul>
          {if $mail_previous_link}
         <li class="clsPrevLinkPage"><a href="{$mail_previous_link}"><span>{$LANG.common_paging_previous}</span></a></li>
          {else}
         <li class="clsInactivePrevLinkPage clsInActivePageLink"><span>{$LANG.common_paging_previous}</span></li>
          {/if}
          {if $mail_next_link}
         <li class="clsNextPageLink"><a href="{$mail_next_link}"><span>{$LANG.common_paging_next}</span></a></li>
          {else}
         <li class="clsInactiveNextPageLink clsInActivePageLink"><span>{$LANG.common_paging_next}</span></li>
          {/if}
        </ul>
      </div></td>
  </tr>
</table></div>