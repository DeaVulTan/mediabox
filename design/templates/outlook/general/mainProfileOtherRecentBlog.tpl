{if isset($populateBlogRecentBlock_arr.row) && ($populateBlogRecentBlock_arr.row)}
  <ul>
	{foreach from=$populateBlogRecentBlock_arr.row item=detail key=caption}
		<li class="clsProfileBlockContentList">
			<p class="clsSubscribersInfoTitle"><a href="{$detail.view_blog_post_link}" title="{$detail.record.blog_post_name}">{$detail.record.blog_post_name}</a></p>
            <p>({$LANG.in_blogs}: <a href="{$detail.view_blog_link}" title="{$detail.record.blog_name}">{$detail.record.blog_name}</a>)</p>
			<p class="clsSubscriberDetails">{$LANG.common_publishon} <span>{$detail.record.published_date}</span>
				<span class="clsSubscribeMembersName">by <a href="{$detail.member_profile_url}">{$detail.name}</a></span>
			</p>
		 </li>
	{/foreach}
  </ul>	
{else}
	<div class="clsNoRecordsFound">{$LANG.common_no_records_found}</div>
{/if}
{if isset($populateBlogRecentBlock_arr.row) && ($populateBlogRecentBlock_arr.row)}            
<div class="clsRecentViewAllMain">
	<a href="{$populateBlogRecentBlock_arr.blog_url}">{$LANG.common_viewall_blogs}</a>
</div>
{/if}
