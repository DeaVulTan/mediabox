{$myobj->setTemplateFolder('general')}
{include file="box.tpl" opt="otherblock_top"}
<div class="clsIndexOtherBlocksContainer">
    <div class="clsJQCarousel" id="searchListTabs">
        <ul class="clsJQCarouselTabs clsOverflow clsOtherTabs">
            <li><a href="photo/photoSearchList.php?tags={$myobj->getFormField('tags')}&showtab=1"><span class="clsOuter"><span class="clsForums">{$LANG.tag_list_photos}</span></span></a></li>
            <li><a href="music/musicSearchList.php?tags={$myobj->getFormField('tags')}&showtab=1"><span class="clsOuter"><span class="clsBlogs">{$LANG.tag_list_musics}</span></span></a></li>
            <li><a href="video/videoSearchList.php?tags={$myobj->getFormField('tags')}&showtab=1"><span class="clsOuter"><span class="clsArticles">{$LANG.tag_list_videos}</span></span></a></li>
            <li><a href="article/articleSearchList.php?tags={$myobj->getFormField('tags')}&showtab=1"><span class="clsOuter"><span class="clsArticles">{$LANG.tag_list_articles}</span></span></a></li>
            <li><a href="blog/blogSearchList.php?tags={$myobj->getFormField('tags')}&showtab=1"><span class="clsOuter"><span class="clsArticles">{$LANG.tag_list_blogs}</span></span></a></li>            
        </ul>
    </div>
</div>
<script type="text/javascript">
	{literal}
	$Jq(window).load(function(){
		attachJqueryTabs('searchListTabs');
	});
	{/literal}
</script>
{$myobj->setTemplateFolder('general')}
{include file="box.tpl" opt="otherblock_bottom"}
