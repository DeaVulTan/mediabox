{if isset($populateCarousalarticleBlock_arr.row) && ($populateCarousalarticleBlock_arr.row)}
   <ul>
	 {foreach from=$populateCarousalarticleBlock_arr.row item=detail key=caption}
		<li class="clsProfileBlockContentList">
			<p class="clsSubscribersInfoTitle"><a href="{$detail.view_article_link}">{$detail.record.article_title}</a></p>
			<p class="clsSubscriberDetails">{$LANG.common_publishon} <span>{$detail.record.published_date}</span>
				<span class="clsSubscribeMembersName">by <a href="{$detail.member_profile_url}">{$detail.name}</a></span>
			</p>
		</li>
	{/foreach}
   </ul>	
{else}
	<div class="clsNoRecordsFound">{$LANG.common_no_records_found}</div>
{/if}
{if isset($populateCarousalarticleBlock_arr.row) && ($populateCarousalarticleBlock_arr.row)}
<div class="clsRecentViewAllMain">
	<a href="{$populateCarousalarticleBlock_arr.view_all_articles_link}">{$LANG.common_viewall_articles}</a>
</div>
{/if}
