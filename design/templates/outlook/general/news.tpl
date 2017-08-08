<div id="selNews">
	<h2>{$LANG.news_title}</h2>
	{ if $myobj->isShowPageBlock('block_detail_news')}
	<p><a href="{$myobj->getUrl('news')}">{$LANG.back}</a></p>
	{/if}
	{ if $myobj->isShowPageBlock('block_news_index')}
	<div id="selNewsDetails">
	{foreach key=news_id item=dummy_value from=$LANG_LIST_ARR.news}
	    <h3><a href="{$myobj->getCurrentUrl()}?news_id={$news_id}">{$LANG_LIST_ARR.news.$news_id.title} -  ({$LANG_LIST_ARR.news.$news_id.date})</a></h3>
    	<p>{$LANG_LIST_ARR.news.$news_id.subject}
		{if $LANG_LIST_ARR.news.$news_id.subject_more}
			...<a href="{$myobj->getCurrentUrl()}?news_id={$news_id}">{$LANG.news_read_more}</a>
		{/if}
		</p>
	{/foreach}
	</div>
	{/if}
	{ if $myobj->isShowPageBlock('block_detail_news')}
	<div id="selNews">
		  <h3>{$LANG_LIST_ARR.news.$news_id.title} -  ({$LANG_LIST_ARR.news.$news_id.date})</h3>
	      <p>{$LANG_LIST_ARR.news.$news_id.subject}</p>
	</div>
	{/if}
</div>