{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="sidebar_whatsgoing_top"}
<div class="clsWhatgoingHeading clsOverflow">
	<h3>{$LANG.myhome_whats_going_on}</h3>
    <div class="clsWhatgoingRightTab" id="indexActivitesTabs">
        <ul class="clsFloatRight">
        	{if isMember()}
            <li><a href="index.php?activity_type=My" title="{$LANG.sidebar_my_label}"><span>{$LANG.sidebar_my_label}</span></a></li>
            <li><a href="index.php?activity_type=Friends" title="{$LANG.sidebar_friends_label}"><span>{$LANG.sidebar_friends_label}</span></a></li>
            {/if}
            <li><a href="index.php?activity_type=All" title="{$LANG.sidebar_everyone_label}"><span>{$LANG.sidebar_everyone_label}</span></a></li>
        </ul>
    </div>
    <script type="text/javascript">
		{literal}
		$Jq(window).load(function(){
			attachJqueryTabs('indexActivitesTabs');
		});
		{/literal}
	</script>
</div>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="sidebar_whatsgoing_bottom"}