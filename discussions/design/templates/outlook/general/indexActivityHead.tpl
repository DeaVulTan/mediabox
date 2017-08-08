{$myobj->setTemplateFolder('general/', 'discussions')}
{include file="box.tpl" opt="whatsgoing_top"}
<div class="clsWhatgoingHeading clsOverflow">
	<h3>{$LANG.sidebar_discussion_activities_label}</h3>
    <div class="clsWhatgoingRightTab" id="indexActivitesTabs">
        <ul class="clsFloatRight">
        	{if isMember()}
            <li><a href="index.php?activity_type=My"><span>{$LANG.sidebar_my_label}</span></a></li>
            <li><a href="index.php?activity_type=Friends"><span>{$LANG.sidebar_friends_label}</span></a></li>
            {/if}
            <li><a href="index.php?activity_type=All"><span>{$LANG.sidebar_everyone_label}</span></a></li>
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
{$myobj->setTemplateFolder('general/', 'discussions')}
{include file="box.tpl" opt="whatsgoing_bottom"}