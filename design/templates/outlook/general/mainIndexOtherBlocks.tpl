{if (chkAllowedModule(array('discussions'))) || (chkAllowedModule(array('blog'))) || (chkAllowedModule(array('article'))) }
{$myobj->setTemplateFolder('general')}
{include file="box.tpl" opt="otherblock_top"}
<div class="clsIndexOtherBlocksContainer">
    <div class="clsJQCarousel" id="recentListTabs">
        <ul class="clsJQCarouselTabs clsOverflow clsOtherTabs">
        	{if (chkAllowedModule(array('article')))}
            <li><a href="index.php?showtab=recentarticle"><span class="clsOuter"><span class="clsArticles">{$LANG.common_article}</span></span></a></li>
            {/if}        	
           	{if (chkAllowedModule(array('blog')))}
            <li><a href="index.php?showtab=recentblog"><span class="clsOuter"><span class="clsBlogs">{$LANG.common_blogs}</span></span></a></li>
            {/if}
            {if (chkAllowedModule(array('discussions')))}
            <li><a href="index.php?showtab=recentboard"><span class="clsOuter"><span class="clsForums">{$LANG.common_boards}</span></span></a></li>
            {/if}
        </ul>
    </div>
</div>
<script type="text/javascript">
	{literal}
	$Jq(window).load(function(){
		attachJqueryTabs('recentListTabs');
	});
	{/literal}
</script>
{$myobj->setTemplateFolder('general')}
{include file="box.tpl" opt="otherblock_bottom"}
{/if}
