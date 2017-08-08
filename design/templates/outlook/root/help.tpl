{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selHelp">
	<div class="clsPageHeading"><h2>{$LANG.help_title}</h2></div>
	<dl>
	{foreach key=tip_key item=help_arr from=$LANG.help}
		<dt><a name="{$tip_key}">{$help_arr.text}</a></dt>
		<dd>{$help_arr.desc|htmlspecialchars}</dd>
	{/foreach}
	</dl>
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}