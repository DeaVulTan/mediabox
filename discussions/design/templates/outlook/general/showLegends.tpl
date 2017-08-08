{if $myobj->isShowPageBlock('form_all_boards')}
<div id="" class="clsSideBarSections clsClearFix">
	{$myobj->setTemplateFolder('general/', 'discussions')}
	{include file='box.tpl' opt='sidebar_top'}
	<h3>{$LANG.legend}</h3>
		<div class="clsThreadDetails">
			<ul>
				<li><p><span class="clsIconNewThread">{$LANG.legend_newpost}</span></p></li>
				<li><p><span class="clsIconNoNewThread">{$LANG.legend_nonew}</span></p></li>
				<li><p><span class="clsIconMyThread">{$LANG.legend_inc}</span></p></li>
				<li><p><span class="clsIconROThread">{$LANG.legend_readonly}</span></p></li>
				<li><p><span class="clsIconHotThread">{$LANG.legend_hot}</span></p></li>
				<li class="clsNoBorder"><p><span class="clsIconBestThread">{$LANG.legend_best}</span></p></li>
			</ul>
		</div>
	{$myobj->setTemplateFolder('general/', 'discussions')}
	{include file='box.tpl' opt='sidebar_bottom'}  
</div>
{/if}