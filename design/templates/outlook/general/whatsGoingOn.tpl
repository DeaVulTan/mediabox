{$myobj->setTemplateFolder('general/', '')}
{include file="box.tpl" opt="sidebar_whatsgoing_top"}
<div class="clsIndexWhatsGoingOnSection">
    <span class="clsWhatgoingHeading">{$LANG.myhome_whats_going_on}</span>
    {if $CFG.admin.show_recent_activities}
        {$myobj->myHomeActivity(4)}
    {/if}
</div>          
{$myobj->setTemplateFolder('general/', '')}
{include file="box.tpl" opt="sidebar_whatsgoing_bottom"}